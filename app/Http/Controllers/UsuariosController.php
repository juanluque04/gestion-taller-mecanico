<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NuevoTrabajadorMail;



class UsuariosController extends Controller
{

    public function index()
    {
        $trabajadores = User::orderBy('Rol')->orderBy('Nombre')->paginate(10);
        return view('admin.gestionarTrabajadores', compact('trabajadores'));
    }


    public function create()
    {
        $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10); // contraseña Aleatoria

        return view('admin.crearTrabajadores', compact('password'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nombre'        => 'required|string|max:255',
            'NombreUsuario' => 'required|string|max:125|unique:users',
            'Correo'        => 'required|string|email|max:255|unique:users',
            'Contrasena'    => 'required|string'
        ]);

        $passwordPlano = $request->Contrasena;

        $usuario = User::create([
            'Nombre'        => $request->Nombre,
            'NombreUsuario' => $request->NombreUsuario,
            'Correo'        => $request->Correo,
            'Contrasena'    => Hash::make($passwordPlano),
            'Rol'           => $request->Rol,
        ]);

        Mail::to($usuario->Correo)->send(
            new \App\Mail\NuevoTrabajadorMail(
                $usuario->Nombre,
                $usuario->NombreUsuario,
                $passwordPlano
            )
        );

        return redirect()->route('gestionarTrabajadores')->with('success', 'Trabajador creado correctamente.');
    }


    public function edit($id)
    {
        $trabajador = User::findOrFail($id);
        return view('admin.editarTrabajadores', compact('trabajador'));
    }

    public function update(Request $request, $id)
    {
        $trabajador = User::findOrFail($id);

        $request->validate([
            'Nombre'        => 'required|string|max:255',
            'NombreUsuario' => 'required|string|max:125|unique:users,NombreUsuario,' . $trabajador->user_id . ',user_id',
            'Correo'        => 'required|string|email|max:255|unique:users,Correo,' . $trabajador->user_id . ',user_id',
            'Rol'           => 'required|in:jefe,trabajador'
        ]);

        $trabajador->update([
            'Nombre'        => $request->Nombre,
            'NombreUsuario' => $request->NombreUsuario,
            'Correo'        => $request->Correo,
            'Rol'           => $request->Rol
        ]);

        return redirect()->route('gestionarTrabajadores')->with('success', 'Trabajador actualizado correctamente.');
    }

    public function destroy($id)
    {
        $trabajador = User::findOrFail($id);

        // Para nunca permitir borrar al jefe principal
        if ($trabajador->Rol === 'jefe') {
            return redirect()->route('gestionarTrabajadores')->with('error', 'No puedes eliminar a un jefe.');
        }

        $trabajador->delete();

        return redirect()->route('gestionarTrabajadores')->with('success', 'Trabajador eliminado.');
    }

    public function resetPassword($id)
    {
        $trabajador = User::findOrFail($id);

        $nueva = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);

        $trabajador->Contrasena = Hash::make($nueva);

        $trabajador->save();
        DB::table('sessions')->where('user_id', $id)->delete();

        return redirect()->route('gestionarTrabajadores')->with('success', "Contraseña restablecida. Nueva contraseña: $nueva");
    }
}
