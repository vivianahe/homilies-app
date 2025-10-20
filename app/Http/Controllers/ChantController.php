<?php

namespace App\Http\Controllers;

use App\Models\Chant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Chant::orderBy('created_at', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'audio' => 'required|file|mimes:mp3,m4a,wav,ogg',
        ]);

        $audioFile = $request->file('audio');
        $audioExtension = $audioFile->getClientOriginalExtension();
        $filename = date('Y-m-d_H_i_s') . 'audio.' . $audioExtension;
        Storage::disk('audioChant')->put($filename, file_get_contents($audioFile->getRealPath()));

        $chant = Chant::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'audio' => $filename,
            'user_id' => Auth::user() ? Auth::user()->id : null,
        ]);

        return response()->json([
            'data' => $chant,
            'message' => 'Canto guardado exitosamente!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Chant::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'audio' => 'nullable|file|mimes:mp3,m4a,wav,ogg',
        ]);

        $chant = Chant::findOrFail($id);

        $filename = $chant->audio;
        if ($request->hasFile('audio')) {
            if ($chant->audio && file_exists(public_path('support/audioChant/') . $chant->audio)) {
                @unlink(public_path('support/audioChant/') . $chant->audio);
            }
            $audioFile = $request->file('audio');
            $audioExtension = $audioFile->getClientOriginalExtension();
            $filename = date('Y-m-d_H_i_s') . 'audio.' . $audioExtension;
            Storage::disk('audioChant')->put($filename, file_get_contents($audioFile->getRealPath()));
        }

        $chant->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'audio' => $filename,
            'user_id' => Auth::user() ? Auth::user()->id : $chant->user_id,
        ]);

        return response()->json([
            'data' => $chant,
            'message' => 'Canto actualizado exitosamente!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $chant = Chant::find($id);

        if (!$chant) {
            return response()->json([
                'message' => 'Canto no encontrado',
            ], 404);
        }

        if ($chant->audio && file_exists(public_path('support/audioChant/') . $chant->audio)) {
            @unlink(public_path('support/audioChant/') . $chant->audio);
        }
        $chant->delete();

        return response()->json([
            'data' => 'ok',
            'message' => 'Canto eliminado exitosamente',
        ]);
    }
}


