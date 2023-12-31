<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userExist = User::where('email', $request->email)->exists();
        if (!$userExist) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'api_token' => Str::random(60), // Genera un token aleatorio
            ]);
            return response()->json([
                'data' => $user,
                'message' => "Usuario guardado exitosamente!"
            ]);
        } else {
            return response()->json([
                'data' => $userExist,
                'message' => "Ya existe un usuario con correo "
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
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
        $user = User::where([['email', $request->email], ['id', '!=', $id]])->exists();
        if ($user === false) {
            $userData = User::where('id', $id)->first();
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password !== null ? bcrypt($request->password) : $userData->password,
            ]);
            return response()->json([
                'data' => $user,
                'message' => "Usuario actualizado exitosamente!"
            ]);
        } else {
            return response()->json([
                'data' => $user,
                'message' => "Ya existe un usuario con ese correo electrónico."
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete(); // Realiza la eliminación suave (soft delete)
            return response()->json([
                'data' => "ok",
                'message' => "Usuario eliminado exitosamente!"
            ]);
        } else {
            return response()->json([
                'data' => null,
                'message' => "Usuario no encontrado"
            ]);
        }
    }
}
