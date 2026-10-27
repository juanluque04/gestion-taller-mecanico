@extends('layouts.nav')

@section('titulo', 'Crear Vehículo')

@section('panelContenido')

<div class="container py-4">

    <h2 class="mb-4">Registrar nuevo Vehículo</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" class="validar" action="{{ route('guardarVehiculos') }}">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marca</label>
                        <input type="text" name="Marca" class="form-control soloLetras" minlength="2" required value="{{ old('Marca') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modelo</label>
                        <input type="text" name="Modelo" class="form-control" minlength="1" required value="{{ old('Modelo') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Versión</label>
                        <input type="text" name="Version" class="form-control" maxlength="255" value="{{ old('Version') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Año</label>
                        <input type="number" name="Ano" class="form-control anioValido" value="{{ old('Ano') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Matrícula</label>
                        <input type="text" name="Matricula" class="form-control matriculaEsp" minlength="6" required value="{{ old('Matricula') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kilómetros</label>
                        <input type="number" name="Kilometros" class="form-control" value="{{ old('Kilometros') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bastidor</label>
                        <input type="text" name="Bastidor" class="form-control" maxlength="255" value="{{ old('Bastidor') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Número de Motor</label>
                        <input type="text" name="NumeroMotor" class="form-control" maxlength="255" value="{{ old('NumeroMotor') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo de Motor</label>
                        <input type="text" name="TipoMotor" class="form-control" maxlength="255" value="{{ old('TipoMotor') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cilindrada</label>
                        <input type="text" name="Cilindrada" class="form-control" maxlength="50" value="{{ old('Cilindrada') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Potencia</label>
                        <input type="text" name="Potencia" class="form-control" maxlength="50" value="{{ old('Potencia') }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Cliente asociado</label>
                        <select id="selectCliente" name="id_Cliente" class="form-select" required>
                            <option value="">Seleccione un cliente...</option>

                            @foreach($clientes as $c)
                                <option value="{{ $c->id_Cliente }}">
                                    {{ $c->Nombre }} {{ $c->Telefono ? "($c->Telefono)" : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('gestionarVehiculos') }}" class="btn btn-outline-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Crear Vehículo</button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection


@section('scripts')
<script>

    $(document).ready(function () {
        
        $('#selectCliente').select2({
            theme: "bootstrap-5",
            placeholder: "Seleccionar cliente...",
            allowClear: true
        });

        
        const $selectVehiculo = $('#selectVehiculo');

        $selectVehiculo.select2({
            theme: "bootstrap-5",
            placeholder: "Seleccione un vehículo...",
            allowClear: true
        });

        $('#selectCliente').on('change', function () {

            let idCliente = $(this).val();

            $selectVehiculo.val(null).trigger('change');

            if (!idCliente) {
                $selectVehiculo.prop('disabled', true);
                $("#btnNuevoVehiculo").addClass('d-none');
                return;
            }

            $selectVehiculo.prop('disabled', false);
            $("#btnNuevoVehiculo").removeClass('d-none');

            $selectVehiculo.find('option').each(function () {

                if (this.value === "") {
                    $(this).prop('disabled', false);
                    return;
                }

                const coincide = $(this).data('cliente') == idCliente;
                $(this).prop('disabled', !coincide);
            });

            $selectVehiculo.trigger('change.select2');
        });

    });

</script>

@endsection