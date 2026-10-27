@extends('layouts.nav')

@section('titulo', 'Editar Vehículo')

@section('panelContenido')

<div class="container py-4">

    <h2 class="mb-4">Editar Vehículo</h2>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Información del vehículo</h5>
        </div>

        <div class="card-body">

            <form method="POST" class="validar" action="{{ route('actualizarVehiculos', $vehiculo->id_Vehiculo) }}">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="Marca" class="form-control soloLetras" minlength="2" required value="{{ $vehiculo->Marca }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="Modelo" class="form-control" minlength="1" required value="{{ $vehiculo->Modelo }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Versión</label>
                        <input type="text" name="Version" class="form-control" maxlength="255" value="{{ $vehiculo->Version }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Año</label>
                        <input type="number" name="Ano" class="form-control anioValido" value="{{ $vehiculo->Ano }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Matrícula</label>
                        <input type="text" name="Matricula" class="form-control matriculaEsp" minlength="6" required value="{{ $vehiculo->Matricula }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kilómetros</label>
                        <input type="number" name="Kilometros" class="form-control" value="{{ $vehiculo->Kilometros }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bastidor</label>
                        <input type="text" name="Bastidor" class="form-control" maxlength="255" value="{{ $vehiculo->Bastidor }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Número de Motor</label>
                        <input type="text" name="NumeroMotor" class="form-control" maxlength="255" value="{{ $vehiculo->NumeroMotor }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo de Motor</label>
                        <input type="text" name="TipoMotor" class="form-control" maxlength="255" value="{{ $vehiculo->TipoMotor }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cilindrada</label>
                        <input type="text" name="Cilindrada" class="form-control" maxlength="50" value="{{ $vehiculo->Cilindrada }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Potencia</label>
                        <input type="text" name="Potencia" class="form-control" maxlength="50" value="{{ $vehiculo->Potencia }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Cliente asociado</label>
                        <select name="id_Cliente" class="form-select" required>
                            @foreach ($clientes as $c)
                                <option value="{{ $c->id_Cliente }}" {{ $vehiculo->id_Cliente == $c->id_Cliente ? 'selected' : '' }}>
                                    {{ $c->Nombre }} ({{ $c->Telefono }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ session('prev_url_vehiculos', route('gestionarVehiculos')) }}" class="btn btn-outline-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
