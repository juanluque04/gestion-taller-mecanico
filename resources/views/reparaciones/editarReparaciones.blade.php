@extends('layouts.nav')

@section('titulo', 'Editar Reparación')

@section('panelContenido')
<div class="container py-4">

    <h2 class="mb-4">Editar Reparación</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Información del vehículo</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Marca:</strong> {{ $reparacion->vehiculo->Marca }}</p>
                    <p><strong>Modelo:</strong> {{ $reparacion->vehiculo->Modelo }}</p>
                    <p><strong>Versión:</strong> {{ $reparacion->vehiculo->Version }}</p>
                    <p><strong>Matrícula:</strong> {{ $reparacion->vehiculo->Matricula }}</p>
                    <p><strong>Bastidor:</strong> {{ $reparacion->vehiculo->Bastidor }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Nº Motor:</strong> {{ $reparacion->vehiculo->NumeroMotor }}</p>
                    <p><strong>Tipo Motor:</strong> {{ $reparacion->vehiculo->TipoMotor }}</p>
                    <p><strong>Cilindrada:</strong> {{ $reparacion->vehiculo->Cilindrada }}</p>
                    <p><strong>Potencia:</strong> {{ $reparacion->vehiculo->Potencia }}</p>
                    <p><strong>Kilómetros:</strong> {{ $reparacion->vehiculo->Kilometros }}</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Cliente:</strong> {{ $reparacion->vehiculo->cliente->Nombre }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Teléfono:</strong> {{ $reparacion->vehiculo->cliente->Telefono }}</p>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Datos de la reparación</h5>
        </div>

        <div class="card-body">
            <form method="POST" class="validar" action="{{ route('actualizarReparaciones', $reparacion->id_Reparacion) }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha de entrada</label>
                        <input type="date" name="FechaEntrada" class="form-control" value="{{ $reparacion->FechaEntrada?->format('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Fecha de salida</label>
                        <input type="date" name="FechaSalida" class="form-control" value="{{ $reparacion->FechaSalida?->format('Y-m-d') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="Estado" class="form-select" required>
                        <option value="pendiente"  {{ $reparacion->Estado=='pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en curso"   {{ $reparacion->Estado=='en curso' ? 'selected' : '' }}>En curso</option>
                        <option value="terminada"  {{ $reparacion->Estado=='terminada' ? 'selected' : '' }}>Terminada</option>
                        <option value="cancelada"  {{ $reparacion->Estado=='cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="Observaciones" rows="4" class="form-control">{{ $reparacion->Observaciones }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('gestionarReparaciones') }}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>

            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">Tareas</h5>
            <a class="btn btn-success btn-sm" href="{{ route('crearTarea', $reparacion->id_Reparacion) }}">
                + Nueva tarea
            </a>
        </div>

        <div class="card-body">
            @if($reparacion->tareas->isEmpty())
                <div class="alert alert-info">No hay tareas registradas.</div>
            @else
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Trabajador</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Programada</th>
                        <th>Realizada</th>
                        <th>H. Prev.</th>
                        <th>H. Real.</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reparacion->tareas as $t)
                    <tr>
                        <td data-label="Descripción">{{ $t->Descripcion }}</td>
                        <td data-label="Usuario">{{ $t->usuario->Nombre ?? 'Sin asignar' }}</td>
                        <td data-label="Prioridad">{{ ucfirst($t->Prioridad) }}</td>
                        <td data-label="Estado">{{ ucfirst($t->Estado) }}</td>
                        <td data-label="Fecha Programada">{{ optional($t->FechaProgramada)->format('d/m/Y') }}</td>
                        <td data-label="Fecha Realizada">{{ optional($t->FechaRealizada)->format('d/m/Y') }}</td>
                        <td data-label="Horas Previstas">{{ $t->HorasPrevistas }}</td>
                        <td data-label="Horas Reales">{{ $t->HorasReales }}</td>
                        <td>
                            <a href="{{ route('editarTarea', $t->id_Tarea) }}" class="btn btn-warning btn-sm">Editar</a>

                            <form action="{{ route('eliminarTarea', $t->id_Tarea) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Borrar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

        </div>
    </div>

</div>

@endsection
