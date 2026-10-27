@extends('layouts.nav')

@section('titulo', 'Crear trabajador')

@section('panelContenido')
<div class="container py-4">

    <h2 class="mb-4">Registrar nuevo trabajador</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" class="validar" action="{{ route('guardarTrabajadores') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="Nombre" class="form-control soloLetras" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre de usuario</label>
                    <input type="text" name="NombreUsuario" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="Correo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña generada automáticamente</label>
                    <input type="text" name="Contrasena" class="form-control bg-light" value="{{ $password }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol del usuario</label>
                    <select name="Rol" class="form-select" required>
                        <option value="trabajador">Trabajador</option>
                        <option value="jefe">Jefe</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('gestionarTrabajadores') }}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Crear trabajador</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

