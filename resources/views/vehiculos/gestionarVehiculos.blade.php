@extends('layouts.nav')

@section('panelContenido')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Gestión de Vehículos</h2>
        <a href="{{ route('crearVehiculos') }}" class="btn btn-success">Crear Vehículos</a>
    </div>

    @if($vehiculos->isEmpty())
        <div class="alert alert-info">No hay vehículos registrados.</div>
    @else
        <table class="table-modern table-sortable">
            <thead>
                <tr>
                    <th data-sort="string">Marca</th>
                    <th data-sort="string">Modelo</th>
                    <th data-sort="number">Año</th>
                    <th data-sort="string">Matrícula</th>
                    <th data-sort="string">Cliente</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehiculos as $v)
                <tr>
                    <td data-label="Marca">{{ $v->Marca }}</td>
                    <td data-label="Modelo">{{ $v->Modelo }}</td>
                    <td data-label="Año">{{ $v->Ano }}</td>
                    <td data-label="Matrícula">{{ $v->Matricula }}</td>
                    <td data-label="Cliente">
                        @if ($v->cliente)
                            <strong>{{ $v->cliente->Nombre }}</strong>
                            ({{ $v->cliente->Telefono }})
                        @else
                            <em>Sin cliente</em>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('editarVehiculos', $v->id_Vehiculo) }}" 
                           class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('eliminarVehiculos', $v->id_Vehiculo) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('¿Seguro que deseas eliminar este Vehículo?');">

                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3 pagination-wrapper">
            <div class="pagination-buttons">
                {{ $vehiculos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

@endsection
