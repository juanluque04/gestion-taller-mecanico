<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cliente;


class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('vehiculos')->paginate(10); 
        return view('clientes.gestionarClientes', compact('clientes'));
    }


    public function create()
    {
        return view('clientes.crearClientes');
    }


    public function store(Request $request)
    {
       $request->validate([
            'Nombre'    => 'required|string|min:3',
            'Telefono'  => 'required|digits:9',
            'DNI'       => 'required|regex:/^[0-9]{8}[A-Za-z]$/',
            'Direccion' => 'nullable|string|min:5'
        ]);

        $cliente = Cliente::create($request->only('Nombre','Telefono','DNI','Direccion'));

        if ($request->vehiculos_json) {
            $vehiculos = json_decode($request->vehiculos_json, true);

            foreach ($vehiculos as $v) {

                // Convertir campos vacíos a null
                foreach ($v as $key => $value) {
                    if ($value === "") {
                        $v[$key] = null;
                    }
                }

                \App\Models\Vehiculo::create(array_merge($v, [
                    'id_Cliente' => $cliente->id_Cliente
                ]));
            }

        }

        return redirect()->route('gestionarClientes')->with('success', 'Cliente y vehículos registrados correctamente.');
    }


    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.editarClientes', compact('cliente'));
    }


    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
                'Nombre'    => 'required|string|min:3',
                'Telefono'  => 'required|digits:9',
                'DNI'       => 'required|regex:/^[0-9]{8}[A-Za-z]$/',
                'Direccion' => 'nullable|string|min:5'
            ]);

        $cliente->update([
            'Nombre'    => $request->Nombre,
            'Telefono'  => $request->Telefono,
            'DNI'       => $request->DNI,
            'Direccion' => $request->Direccion,
        ]);

        return redirect()->route('gestionarClientes')->with('success', 'Cliente actualizado correctamente.');
    }


    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('gestionarClientes')
            ->with('success', 'Cliente eliminado.');
    }


    public function guardarAjax(Request $request)
    {
        $validated = $request->validate([
            'Nombre'    => 'required|string|max:255',
            'Telefono'  => 'nullable|string|max:20',
            'DNI'       => 'nullable|string|max:20',
            'Direccion' => 'nullable|string|max:255',
        ]);

        $cliente = Cliente::create($validated);

        return response()->json([
            'success' => true,
            'cliente' => $cliente
        ]);
    }

    public function validarDni(Request $request)
    {
        $request->validate(['DNI' => 'required|string']);

        $existe = Cliente::where('DNI', $request->DNI)->exists();

        return response()->json(['exists' => $existe]);
    }


}
