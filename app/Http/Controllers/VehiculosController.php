<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Cliente;

class VehiculosController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::with('cliente')->paginate(10);
        return view('vehiculos.gestionarVehiculos', compact('vehiculos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('vehiculos.crearVehiculos', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Marca'         => 'required|string|max:255',
            'Modelo'        => 'required|string|max:50',
            'Ano'           => 'nullable|integer|min:1900|max:' . date('Y'),
            'Matricula'     => 'required|string|max:20|unique:vehiculos',
            'Version'       => 'nullable|string|max:255',
            'Bastidor'      => 'nullable|string|max:255',
            'NumeroMotor'   => 'nullable|string|max:255',
            'TipoMotor'     => 'nullable|string|max:255',
            'Cilindrada'    => 'nullable|string|max:50',
            'Potencia'      => 'nullable|string|max:50',
            'Kilometros'    => 'nullable|integer',
            'id_Cliente'    => 'required|exists:clientes,id_Cliente',
        ]);

        Vehiculo::create($request->all());

        return redirect()->route('gestionarVehiculos')->with('success', 'Vehículo creado correctamente.');
    }

    public function edit($id)
    {
        $prev = url()->previous();

        if (str_contains($prev, '/clientes') || str_contains($prev, '/vehiculos')) {
            session(['prev_url_vehiculos' => $prev]);
        }

        $vehiculo = Vehiculo::findOrFail($id);
        $clientes = Cliente::all();

        return view('vehiculos.editarVehiculos', compact('vehiculo', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        $request->validate([
            'Marca'         => 'required|string|max:255',
            'Modelo'        => 'required|string|max:50',
            'Ano'           => 'nullable|integer|min:1900|max:' . date('Y'),
            'Matricula'     => 'required|string|max:20|unique:vehiculos,Matricula,' . $vehiculo->id_Vehiculo . ',id_Vehiculo',
            'Version'       => 'nullable|string|max:255',
            'Bastidor'      => 'nullable|string|max:255',
            'NumeroMotor'   => 'nullable|string|max:255',
            'TipoMotor'     => 'nullable|string|max:255',
            'Cilindrada'    => 'nullable|string|max:50',
            'Potencia'      => 'nullable|string|max:50',
            'Kilometros'    => 'nullable|integer',
            'id_Cliente'    => 'required|exists:clientes,id_Cliente',
        ]);

        $vehiculo->update($request->all());

        return redirect()->route('gestionarVehiculos')->with('success', 'Vehículo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->delete();

        return redirect()->route('gestionarVehiculos')->with('success', 'Vehículo eliminado.');
    }


    public function guardarAjax(Request $request)
    {
        $validated = $request->validate([
            'Matricula'     => 'required|string|max:20|unique:vehiculos,Matricula',
            'Marca'         => 'required|string|max:255',
            'Modelo'        => 'required|string|max:255',
            'Ano'           => 'nullable|integer|min:1900|max:' . date('Y'),
            'Version'       => 'nullable|string|max:255',
            'Bastidor'      => 'nullable|string|max:255',
            'NumeroMotor'   => 'nullable|string|max:255',
            'TipoMotor'     => 'nullable|string|max:255',
            'Cilindrada'    => 'nullable|string|max:50',
            'Potencia'      => 'nullable|string|max:50',
            'Kilometros'    => 'nullable|integer',
            'id_Cliente'    => 'required|exists:clientes,id_Cliente',
        ]);

        $vehiculo = Vehiculo::create($validated);

        return response()->json([
            'success' => true,
            'vehiculo' => $vehiculo
        ]);
    }

    public function validarMatricula(Request $request)
    {
        $request->validate(['Matricula' => 'required|string']);

        $existe = Vehiculo::where('Matricula', $request->Matricula)->exists();

        return response()->json(['exists' => $existe]);
    }




}
