<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
 
    public function index()
    {
        return view('perfil.perfil');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'Nombre' => 'required|string|max:255',
            'NombreUsuario' => 'required|string|max:125|unique:users,NombreUsuario,' . $user->user_id . ',user_id',
            'Correo' => 'required|email|max:255|unique:users,Correo,' . $user->user_id . ',user_id',
        ]);

        $user->Nombre = $request->Nombre;
        $user->NombreUsuario = $request->NombreUsuario;
        $user->Correo = $request->Correo;

        if ($request->filled('old_password') || $request->filled('new_password')) {

            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ]);

            if (!Hash::check($request->old_password, $user->Contrasena)) {
                return back()->with('error', 'La contraseña actual es incorrecta.');
            }

            $user->Contrasena = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}
