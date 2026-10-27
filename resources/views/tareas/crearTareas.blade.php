@extends('layouts.nav')

@section('titulo', 'Nueva Tarea')

@section('panelContenido')

<div class="container py-4">

    <h2 class="mb-4">Crear Tarea</h2>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Datos de la tarea</h5>
        </div>

        <div class="card-body">

            <form method="POST" class="validar" action="{{ route('guardarTarea') }}">
                @csrf

                <input type="hidden" name="id_Reparacion" value="{{ $reparacion->id_Reparacion }}">

                <div class="mb-3">
                    <label class="form-label">Descripción *</label>
                    <textarea name="Descripcion" class="form-control" required></textarea>
                </div>

                <div class="row mb-3">

                    <div class="col-md-4">
                        <label class="form-label">Trabajador *</label>
                        <select name="user_id" class="form-select" required>
                            @foreach($trabajadores as $u)
                            <option value="{{ $u->user_id }}">{{ $u->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Prioridad *</label>
                        <select name="Prioridad" class="form-select" required>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado *</label>
                        <select name="Estado" class="form-select" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="en curso">En curso</option>
                            <option value="terminada">Terminada</option>
                            <option value="revisada">Revisada</option>
                        </select>
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4">
                        <label class="form-label">Fecha programada</label>
                        <input type="date" name="FechaProgramada" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Horas previstas</label>
                        <input type="number" step="0.1" name="HorasPrevistas" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Importe</label>
                        <input type="number" step="0.01" name="Importe" class="form-control">
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="Observaciones" class="form-control"></textarea>
                </div>


                <div class="d-flex justify-content-between">
                    <a href="{{ route('editarReparaciones', $reparacion->id_Reparacion) }}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Crear Tarea</button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
