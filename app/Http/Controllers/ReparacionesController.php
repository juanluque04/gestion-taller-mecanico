<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Cliente;
use App\Models\Reparacion;
use App\Models\User;

class ReparacionesController extends Controller
{
     public function index()
    {
        $reparaciones = Reparacion::with(['vehiculo'])->orderBy('id_Reparacion', 'desc')->paginate(10);
        return view('reparaciones.gestionarReparaciones', compact('reparaciones'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $vehiculos = Vehiculo::with('cliente')->orderBy('Matricula')->get();

        return view('reparaciones.crearReparaciones', compact('clientes','vehiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'FechaEntrada'   => 'required|date',
            'FechaSalida'    => 'nullable|date',
            'Estado'         => 'required|string',
            'Observaciones'  => 'nullable|string',
            'id_Vehiculo'    => 'required|integer|exists:vehiculos,id_Vehiculo',
        ]);

        Reparacion::create([
            'FechaEntrada'  => $request->FechaEntrada,
            'FechaSalida'   => $request->FechaSalida,
            'Estado'        => $request->Estado,
            'Observaciones' => $request->Observaciones,
            'id_Vehiculo'   => $request->id_Vehiculo,
        ]);

        return redirect()->route('gestionarReparaciones')->with('success', 'Reparación creada correctamente.');

    }

    public function edit($id)
    {
        session()->forget('prev_url');

        $reparacion = Reparacion::with([
            'vehiculo.cliente',  
            'tareas.usuario'       
        ])->findOrFail($id);

        $trabajadores = User::where('Rol', 'trabajador')->get();

        return view('reparaciones.editarReparaciones', compact('reparacion','trabajadores'));
    }


    public function update(Request $request, $id)
    {
        $reparacion = Reparacion::findOrFail($id);

        $request->validate([
            'FechaEntrada'   => 'required|date',
            'FechaSalida'    => 'nullable|date',
            'Estado'         => 'required|string',
            'Observaciones'  => 'nullable|string',
            //'id_Vehiculo'    => 'required|integer|exists:vehiculos,id_Vehiculo',
        ]);

        $reparacion->update([
            'FechaEntrada'  => $request->FechaEntrada,
            'FechaSalida'   => $request->FechaSalida !== "" ? $request->FechaSalida : null,
            'Estado'        => $request->Estado,
            'Observaciones' => $request->Observaciones,
            'id_Vehiculo'   => $reparacion->id_Vehiculo,
        ]);

        return redirect()->back()->with('success', 'Reparación actualizada.');
    }

    public function destroy($id)
    {
        $reparacion = Reparacion::findOrFail($id);
        $reparacion->delete();

        return redirect()->route('gestionarReparaciones')->with('success', 'Reparación eliminada.');
        
    }

    
}
