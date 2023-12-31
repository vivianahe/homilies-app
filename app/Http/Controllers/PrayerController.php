<?php

namespace App\Http\Controllers;
use App\Models\Prayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Prayer::orderBy('prayers.date','DESC')->get();
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
        $praExist = Prayer::where('date', $request->date)->exists();
        if (!$praExist){
            $pray = Prayer::Create([
                'date' => $request->date,
                'link' => $request->link,
                'user_id' => Auth::user()->id,
            ]);
    
            return response()->json([
                'data' => $pray,
                'message'=>"Oración guardada exitosamente!"
            ]);
        } else {
            return response()->json([
                'data' => $praExist,
                'message'=>"Ya existe una oración con fecha "
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Prayer::where('id', $id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prayer = Prayer::where([['date', $request->date], ['id', '!=', $id]])->exists();
        if (!$prayer) {
            Prayer::where('id', $id)->update([
                'date' => $request->date,
                'link' => $request->link,
                'user_id' => Auth::user()->id,
            ]);
            return response()->json([
                'data' => $prayer,
                'message' => "Oración actualizada exitosamente!"
            ]);
        } else {
            return response()->json([
                'data' => $prayer,
                'message' => "Ya existe una oración con esa fecha."
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prayer = Prayer::find($id);
    
        if (!$prayer) {
            return response()->json([
                'message' => 'Oración no encontrada',
            ], 404);
        }
    
        $prayer->delete();
    
        return response()->json([
            'data' => "ok",
            'message' => 'Oración eliminada exitosamente',
        ]);
    }
}
