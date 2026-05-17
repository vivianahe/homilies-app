<?php

namespace App\Http\Controllers;

use App\Models\Homilie;
use App\Models\Solemnity;
use App\Models\LiturgicalTime;
use App\Models\Gospel;
use App\Models\LiturgicalDay;
use App\Models\HomilyLiturgicalDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ContactFormNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HomiliesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Homilie::select(

            'id',
            'date',
            'citation',
            'title',
            'reading',
            'audio',
            'img',
            'solemnity_id'

        )
        ->orderBy('date', 'DESC')
        ->get();
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

        $hom = Homilie::create([
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


        $liturgicalDay = LiturgicalDay::create([

            'title' => $request->title,

            'slug' => Str::slug(
                $request->title . '-' . $request->date
            ),

            'liturgical_time_id' => $request->liturgical_time_id,

            'gospel_id' => $request->gospel_id,

            'cycle' => $request->cycle,

            'week_number' => $request->week_number ?: 0,

            'day_name' => Carbon::parse($request->date)
                ->locale('es')
                ->translatedFormat('l'),

            'celebration_type' => $request->celebration_type,

            'description' => $request->description ?? '',
        ]);

        HomilyLiturgicalDay::create([
            'homily_id' => $hom->id,
            'liturgical_day_id' => $liturgicalDay->id
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

        $solemnity = null;

        if ($request->solemnity !== null) {
            $solemnity = Solemnity::updateOrCreate([
                'name' => $request->solemnity
            ]);
        }


        $homily = Homilie::where('id', $request->id)->first();

        $updateData = [

            'date' => $request->date,
            'citation' => $request->citation,
            'title' => $request->title,
            'reading' => $request->reading,
            'gospel' => $request->gospel,

            'message' => $request->messag,
            'user_id' => Auth::user()->id,
            'solemnity_id' => $solemnity ? $solemnity->id : null
        ];

        if ($request->hasFile('img')) {

            $img = $request->file('img');

            $fileImg = $img->getClientOriginalExtension();

            $name_img = $request->date . '_' . date('H_i_s') . 'img.' . $fileImg;

            $img->move(public_path('support/imgHomily'), $name_img);

            $updateData['img'] = $name_img;
        }

        if ($request->hasFile('audio')) {

            $audio = $request->file('audio');

            $fileAudio = $audio->getClientOriginalExtension();

            $name_audio = $request->date . '_' . date('H_i_s') . 'audio.' . $fileAudio;

            $audio->move(public_path('support/audioHomily'), $name_audio);

            $updateData['audio'] = $name_audio;
        }

        $homily->update($updateData);


        $relation = HomilyLiturgicalDay::where(
            'homily_id',
            $request->id
        )->first();


        if ($relation) {

            LiturgicalDay::where(
                'id',
                $relation->liturgical_day_id
            )->update([

                'title' => $request->title,

                'slug' => Str::slug(
                    $request->title . '-' . $request->date
                ),

                'liturgical_time_id' => $request->liturgical_time_id,

                'gospel_id' => $request->gospel_id,

                'cycle' => $request->cycle,

                'week_number' => $request->week_number ?: 0,

                'celebration_type' => $request->celebration_type,

                'description' => $request->description ?? '',

                'day_name' => Carbon::parse($request->date)
                    ->locale('es')
                    ->translatedFormat('l'),
            ]);

        } else {

            $liturgicalDay = LiturgicalDay::create([

                'title' => $request->title,

                'slug' => Str::slug(
                    $request->title . '-' . $request->date
                ),

                'liturgical_time_id' => $request->liturgical_time_id,

                'gospel_id' => $request->gospel_id,

                'cycle' => $request->cycle,

                'week_number' => $request->week_number ?: 0,

                'celebration_type' => $request->celebration_type,

                'description' => $request->description ?? '',

                'day_name' => Carbon::parse($request->date)
                    ->locale('es')
                    ->translatedFormat('l'),
            ]);

            HomilyLiturgicalDay::create([

                'homily_id' => $request->id,

                'liturgical_day_id' => $liturgicalDay->id
            ]);
        }

        return response()->json([
            'data' => true,
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
            $imgPath = public_path('/support/imgHomily/') . $homilia->img;

            if (
                $homilia->img &&
                file_exists($imgPath)
            ) {
                unlink($imgPath);
            }

            $audioPath = public_path('/support/audioHomily/') . $homilia->audio;

            if (
                $homilia->audio &&
                file_exists($audioPath)
            ) {
                unlink($audioPath);
            }

            HomilyLiturgicalDay::where(
                'homily_id',
                $homilia->id
            )->delete();

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
        $data = Homilie::from('homilies as h')

            ->leftJoin(
                'solemnity as s',
                's.id',
                '=',
                'h.solemnity_id'
            )

            ->leftJoin(
                'homily_liturgical_day as hld',
                'hld.homily_id',
                '=',
                'h.id'
            )

            ->leftJoin(
                'liturgical_days as ld',
                'ld.id',
                '=',
                'hld.liturgical_day_id'
            )

            ->select(

                'h.*',

                's.name as solemnity_name',

                'ld.description',

                'ld.cycle',

                'ld.week_number',

                'ld.celebration_type',

                'ld.liturgical_time_id',

                'ld.gospel_id'

            )

            ->where('h.id', $id)

            ->first();
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

    public function getLiturgicalTimes()
    {
        return response()->json(
            LiturgicalTime::orderBy('name')->get()
        );
    }

    public function getGospels()
    {
        return response()->json(
            Gospel::orderBy('name')->get()
        );
    }
    
    public function getHomiliesNew()
    {
        $data = Homilie::from('homilies as h')

            ->leftJoin(
                'solemnity as s',
                's.id',
                '=',
                'h.solemnity_id'
            )

            ->leftJoin(
                'homily_liturgical_day as hld',
                'hld.homily_id',
                '=',
                'h.id'
            )

            ->leftJoin(
                'liturgical_days as ld',
                'ld.id',
                '=',
                'hld.liturgical_day_id'
            )

            ->leftJoin(
                'liturgical_times as lt',
                'lt.id',
                '=',
                'ld.liturgical_time_id'
            )

            ->leftJoin(
                'gospels as g',
                'g.id',
                '=',
                'ld.gospel_id'
            )

            ->select(
                'h.id',
                'h.date',
                'h.citation',
                'h.title',
                'h.reading',
                'h.gospel',
                'h.message',
                'h.audio',
                'h.img',
                'h.solemnity_id',
                'ld.description',
                'ld.cycle',
                'ld.week_number',
                'ld.celebration_type',
                'ld.day_name',
                'lt.name as liturgical_time',
                'g.name as gospel_name',
                's.name as solemnity_name'
            )

            ->orderBy('h.date', 'DESC')

            ->get();

        return response()->json($data);
    }
}
