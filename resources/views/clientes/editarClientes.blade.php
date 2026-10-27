@extends('layouts.nav')

@section('titulo', 'Editar Cliente')

@section('panelContenido')

<div class="container py-4">

    <h2 class="mb-4">Editar Cliente</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" class="validar" action="{{ route('actualizarClientes', $cliente->id_Cliente) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre completo *</label>
                    <input type="text" name="Nombre" class="form-control soloLetras" minlength="3" required value="{{ old('Nombre', $cliente->Nombre) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono *</label>
                    <input type="text" name="Telefono" class="form-control telefonoEsp" minlength="9" required value="{{ old('Telefono', $cliente->Telefono) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="text" name="DNI" class="form-control dniEsp" minlength="9" value="{{ old('DNI', $cliente->DNI) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="Direccion" class="form-control" minlength="5" value="{{ old('Direccion', $cliente->Direccion) }}">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('gestionarClientes') }}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
