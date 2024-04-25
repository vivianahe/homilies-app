<?php

namespace App\Http\Controllers;

use App\Models\Homilie;
use App\Models\Solemnity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContactFormNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class HomiliesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Homilie::orderBy('homilies.date', 'DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $solemnity = null;

        if ($request->solemnity !== null) {
            $solemnity = Solemnity::updateOrCreate([
                'name' => $request->solemnity
            ]);
        }

        $audio = $request->file('audio');
        $img = $request->file('img');
        $fileAudio = $audio->getClientOriginalExtension();
        $fileImg = $img->getClientOriginalExtension();
        $name_audio = $request->date . '_' . date('H_i_s') . 'audio.' . $fileAudio;
        $name_img = $request->date . '_' . date('H_i_s') . 'img.' . $fileImg;
        $img->move(public_path('support/imgHomily'), $name_img);
        $audio->move(public_path('support/audioHomily'), $name_audio);

        $hom = Homilie::Create([
            'date' => $request->date,
            'citation' => $request->citation,
            'title' => $request->title,
            'reading' => $request->reading,
            'gospel' => $request->gospel,
            'img' => $name_img,
            'audio' => $name_audio,
            'message' => $request->messag,
            'user_id' => Auth::user()->id,
            'solemnity_id' => $solemnity ? $solemnity->id : null
        ]);

        return response()->json([
            'data' => $hom,
            'message' => "Homilía guardada exitosamente!"
        ]);
    }

    public function show(string $id)
    {
        return Homilie::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateHomilia(Request $request)
    {
        $imgHom = Homilie::where('img', $request->img)->exists();
        $dataHom = Homilie::where('id', $request->id)->first();
        if ($imgHom) {
            $name_img = $request->img;
        } else {
            unlink(public_path('support/imgHomily/') . $dataHom->img);
            $img = $request->file('img');
            $fileImg = $img->getClientOriginalExtension();
            $name_img = $request->date . '_' . date('H_i_s') . 'img.' . $fileImg;
            Storage::disk('imgHomily')->put($name_img, file_get_contents($img->getRealPath()));
        }
        $audHom = Homilie::where('audio', $request->audio)->exists();
        if ($audHom) {
            $name_audio = $request->audio;
        } else {
            unlink(public_path('support/audioHomily/') . $dataHom->audio);
            $audio = $request->file('audio');
            $fileAudio = $audio->getClientOriginalExtension();
            $name_audio = $request->date . '_' . date('H_i_s') .  'audio.' . $fileAudio;
            Storage::disk('audioHomily')->put($name_audio, file_get_contents($audio->getRealPath()));
        }
        $solemnity = null;

        if ($request->solemnity !== null) {
            $solemnity = Solemnity::updateOrCreate([
                'name' => $request->solemnity
            ]);
        }
        Homilie::where('id', $request->id)->update([
            'date' => $request->date,
            'citation' => $request->citation,
            'title' => $request->title,
            'reading' => $request->reading,
            'gospel' => $request->gospel,
            'img' => $name_img,
            'audio' => $name_audio,
            'message' => $request->messag,
            'user_id' => Auth::user()->id,
            'solemnity_id' => $solemnity ? $solemnity->id : null
        ]);
        return response()->json([
            'data' => false,
            'message' => "Homilía actualizada exitosamente!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $homilia = Homilie::find($id);
        if ($homilia) {
            unlink(public_path('/support/imgHomily/') . $homilia->img);
            unlink(public_path('/support/audioHomily/') . $homilia->audio);
            $homilia->delete();
            return response()->json([
                'data' => "ok",
                'message' => "Homilía eliminada exitosamente!"
            ]);
        } else {
            return response()->json([
                'data' => null,
                'message' => "Homilía no encontrada."
            ]);
        }
    }

    public function getDescHomily()
    {
        $homily = Homilie::orderBy('date', 'desc')->first();

        if ($homily) {
            return $homily;
        } else {
            return response()->json(['message' => 'No se encontraron homilías.'], 404);
        }
    }

    public function postFrmContact(Request $request)
    {
        $data = $request->all(); // Los datos del formulario
        Notification::route('mail', 'urielalejo@gmail.com')->notify(new ContactFormNotification($data));
    }
    public function getHomeliasId(string $id)
    {
        $data = Homilie::join('solemnity', 'solemnity.id', '=', 'homilies.solemnity_id')->select('homilies.*', 'solemnity.name')->where('homilies.id', $id)->first();
        return response()->json($data);
    }

    public function getSolemnity($param)
    {
        $data = explode(" ", $param);
        $json = [];
        for ($i = 0; $i < count($data); $i++) {
            $conditional = ['name', 'like', '%' . $data[$i] . '%'];
            array_push($json, $conditional);
        }
        $position = Solemnity::where($json)->limit(5)->get();
        return response()->json($position);
    }
}
