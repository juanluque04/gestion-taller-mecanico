<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reparacion;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PaginaController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->Rol === 'jefe') {

            $reparacionesActivas = Reparacion::whereIn('Estado', ['pendiente', 'en curso'])->count();
            $tareasPendientes    = Tarea::where('Estado', 'pendiente')->count();
            $vehiculosEnTaller   = Reparacion::whereNull('FechaSalida')->count();
            $numTrabajadores     = User::where('Rol', 'trabajador')->count();

            return view('inicio', compact(
                'reparacionesActivas',
                'tareasPendientes',
                'vehiculosEnTaller',
                'numTrabajadores'
            ));
        }

        $id = $user->user_id;

        $tareasHoy = Tarea::where('user_id', $id)->whereDate('FechaProgramada', today())->count();

        $tareasPendientes = Tarea::where('user_id', $id)->where('Estado', 'pendiente')->count();

        $horasPrevistasHoy = Tarea::where('user_id', $id)->whereDate('FechaProgramada', today())->sum('HorasPrevistas');

        return view('inicio', compact(
            'tareasHoy',
            'tareasPendientes',
            'horasPrevistasHoy'
        ));
    }



}
