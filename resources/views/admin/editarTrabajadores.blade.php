@extends('layouts.nav')

@section('titulo', 'Editar Trabajador')

@section('panelContenido')

<div class="container py-4">

    <h2 class="mb-4">Editar Trabajador</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Información del usuario</h5>
        </div>
        <div class="card-body">

            <form method="POST" class="validar" action="{{ route('actualizarTrabajadores', $trabajador->user_id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="Nombre" class="form-control soloLetras" value="{{ $trabajador->Nombre }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre de usuario</label>
                    <input type="text" name="NombreUsuario" class="form-control" value="{{ $trabajador->NombreUsuario }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="Correo" class="form-control" value="{{ $trabajador->Correo }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol del usuario</label>
                    <select name="Rol" class="form-select" required>
                        <option value="trabajador" {{ $trabajador->Rol==='trabajador'?'selected':'' }}>Trabajador</option>
                        <option value="jefe" {{ $trabajador->Rol==='jefe'?'selected':'' }}>Jefe</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('gestionarTrabajadores') }}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>

            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Generar contraseña nueva</h5>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('resetearContrasena', $trabajador->user_id) }}">
                @csrf
                <button type="submit" class="btn btn-warning">Resetear</button>
            </form>

        </div>
    </div>

</div>

@endsection
