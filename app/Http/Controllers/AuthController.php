<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 

class AuthController extends Controller
{
    public function showRegister()
    {

        $jefe = User::where('rol', 'jefe')->count();
        //Si se quiere acceder con /register será redirigido
        if ($jefe > 1) {
            return redirect()->route('login')->with('error', 'El sistema ya tiene 2 jefes. El acceso está bloqueado.');
        }

        return view('auth.register');
    }


    public function register(Request $request)
    {
        // Si ya hay dos jefes registrados, bloquear el registro
        $jefe = User::where('rol', 'jefe')->count();
        if ($jefe > 1) {
            return redirect()->route('login')->with('error', 'Solo se permite crear la cuenta del jefe. Para crear más usuarios, el jefe debe crearlos.');
        }

        $request->validate([
            'Nombre'            => 'required|string|max:255',
            'NombreUsuario'     => 'required|string|max:125|unique:users',
            'Correo'            => 'required|string|email|max:255|unique:users',
            'Contrasena'        => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'Nombre'            => $request->Nombre,
            'NombreUsuario'     => $request->NombreUsuario,
            'Correo'            => $request->Correo,
            'Contrasena'        => Hash::make($request->Contrasena),
            'Rol'               => 'jefe',
        ]);

        Auth::login($user);

        return redirect()->route('inicio')->with('success', 'Cuenta del jefe creada correctamente.');
    }


    public function showLogin()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'NombreUsuario'     => 'required|string',
            'Contrasena'        => 'required|string',
        ]);

        //PAra que auth:attempt reciba "contrasena" en vez de "password"
        $credentials = [
            'NombreUsuario' => $request->NombreUsuario,
            'password'      => $request->Contrasena,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('inicio'))->with('success', 'Has iniciado sesión correctamente.'); 
        }

        return back()->withErrors([
            'NombreUsuario' => 'Las credenciales no son válidas.',
        ])->onlyInput('NombreUsuario');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio')->with('success', 'Sesión cerrada correctamente.');
    }
}
