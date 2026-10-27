@extends('layouts.nav')

@section('panelContenido')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Gestión de Clientes</h2>
        <a href="{{ route('crearClientes') }}" class="btn btn-success">Crear Clientes</a>
    </div>

    @if($clientes->isEmpty())
        <div class="alert alert-info">No hay clientes registrados.</div>
    @else

        <table class="table-modern table-sortable w-100">
            <thead>
                <tr>
                    <th data-sort="string">Nombre</th>
                    <th data-sort="string">Teléfono</th>
                    <th data-sort="string">Vehículos</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $c)
                <tr>
                    <td data-label="Nombre">{{ $c->Nombre }}</td>
                    <td data-label="Teléfono">{{ $c->Telefono }}</td>
                    <td data-label="Vehículos">
                        @if ($c->vehiculos->isEmpty())
                            <span class="text-muted">Sin vehículos</span>
                        @else
                            <ul class="mb-0">
                                @foreach ($c->vehiculos as $v)
                                <li>
                                    <a href="{{ route('editarVehiculos', $v->id_Vehiculo) }}" class="text-decoration-none">
                                        <strong>{{ $v->Marca }} {{ $v->Modelo }}</strong> ({{ $v->Matricula }})
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>

                    <td class="text-end">
                        <a href="{{ route('editarClientes', $c->id_Cliente) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('eliminarClientes', $c->id_Cliente) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
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
                {{ $clientes->links('pagination::bootstrap-5') }}
            </div>
        </div>

    @endif
</div>

@endsection
