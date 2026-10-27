@extends('layouts.nav')

@section('panelContenido')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Gestión de Reparaciones</h2>
        <a href="{{ route('crearReparaciones') }}" class="btn btn-success">Crear Reparación</a>
    </div>

    @if($reparaciones->isEmpty())
        <div class="alert alert-info">No hay reparaciones registradas.</div>
    @else
        <table class="table-modern table-sortable">
            <thead>
                <tr>
                    <th data-sort="string">Cliente</th>
                    <th data-sort="string">Vehículo</th>
                    <th data-sort="date">Fecha entrada</th>
                    <th data-sort="date">Fecha salida</th>
                    <th data-sort="string">Estado</th>
                    <th data-sort="string">Observaciones</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reparaciones as $r)
                <tr>

                    <td data-label="Cliente">
                        @if($r->vehiculo && $r->vehiculo->cliente)
                            <strong>{{ $r->vehiculo->cliente->Nombre }}</strong><br>
                            <small>{{ $r->vehiculo->cliente->Telefono }}</small>
                        @else
                            <em>Sin cliente</em>
                        @endif
                    </td>

                    <td data-label="Vehículo">
                        @if($r->vehiculo)
                            <strong>{{ $r->vehiculo->Matricula }}</strong><br>
                            <small>{{ $r->vehiculo->Marca }} {{ $r->vehiculo->Modelo }}</small>
                        @else
                            <em>Sin vehículo</em>
                        @endif
                    </td>

                    <td data-label="Fecha entrada">
                        {{ \Carbon\Carbon::parse($r->FechaEntrada)->format('d/m/Y') }}
                    </td>

                    <td data-label="Fecha salida">
                        @if($r->FechaSalida)
                            {{ \Carbon\Carbon::parse($r->FechaSalida)->format('d/m/Y') }}
                        @else
                            <em>-</em>
                        @endif
                    </td>

                    <td data-label="Estado">
                        <span class="badge
                            @if($r->Estado == 'pendiente') bg-warning text-dark
                            @elseif($r->Estado == 'en curso') bg-primary
                            @elseif($r->Estado == 'terminada') bg-success
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($r->Estado) }}
                        </span>
                    </td>

                    <td data-label="Observaciones" class="td-wrap">
                        <small>{{ Str::limit($r->Observaciones, 60) }}</small>
                    </td>

                    <td data-label="Acciones" class="text-end">
                        <a href="{{ route('editarReparaciones', $r->id_Reparacion) }}"
                        class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('eliminarReparaciones', $r->id_Reparacion) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('¿Seguro que deseas eliminar esta reparación?');">
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
                {{ $reparaciones->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

@endsection
