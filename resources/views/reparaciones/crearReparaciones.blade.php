@extends('layouts.nav')

@section('panelContenido')

<div class="container py-4">
    <h2 class="mb-4">Crear Reparación</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" class="validar" action="{{ route('guardarReparaciones') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Fecha de entrada</label>
                        <input type="date" name="FechaEntrada" class="form-control" value="{{ old('FechaEntrada') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado</label>
                        <select name="Estado" class="form-select" required>
                            <option value="pendiente">Pendiente</option>
                            <option value="en curso">En curso</option>
                            <option value="terminada">Terminada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Observaciones</label>
                        <textarea name="Observaciones" class="form-control" rows="1"></textarea>
                    </div>
                </div>

                <hr>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Cliente</label>

                        <button type="button" id="addCliente" class="btn btn-sm btn-outline-primary">
                            + Añadir cliente
                        </button>
                    </div>

                    <select id="selectCliente" name="id_Cliente" class="form-select" required>
                        <option value="">Seleccione un cliente...</option>

                        @foreach($clientes as $c)
                            <option value="{{ $c->id_Cliente }}">
                                {{ $c->Nombre }} {{ $c->Telefono ? "($c->Telefono)" : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Vehículo</label>

                        <button type="button" id="btnNuevoVehiculo" class="btn btn-sm btn-outline-primary d-none">
                            + Añadir vehículo
                        </button>
                    </div>

                    <select id="selectVehiculo" name="id_Vehiculo" class="form-select" disabled required>
                        <option value="">Seleccione primero un cliente...</option>

                        @foreach($vehiculos as $v)
                            <option value="{{ $v->id_Vehiculo }}" data-cliente="{{ $v->id_Cliente }}">
                                {{ $v->Matricula }} - {{ $v->Marca }} {{ $v->Modelo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('gestionarReparaciones') }}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Guardar Reparación</button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('reparaciones.modales.modalNuevoCliente')
@include('reparaciones.modales.modalNuevoVehiculo')

@endsection


@section('scripts')
<script>
    $(document).ready(function () {

        $('#selectCliente').select2({
            theme: "bootstrap-5",
            placeholder: "Seleccionar cliente...",
            allowClear: true
        });

        $("#addCliente").on("click", () => {
            $("#modalNuevoCliente").modal("show");
        });

        $("#modalNuevoCliente").on("hidden.bs.modal", () => {
            $("#formNuevoCliente")[0].reset();
        });

        $("#formNuevoCliente").on("submit", function(e) {
            e.preventDefault();

            let datos = $(this).serialize();

            $.ajax({
                url: "{{ route('guardarClienteAjax') }}",
                method: "POST",
                data: datos,

                success: function(res){
                    if(res.success){

                        let texto = res.cliente.Nombre
                            + (res.cliente.Telefono ? " (" + res.cliente.Telefono + ")" : "");

                        let opcion = new Option(texto, res.cliente.id_Cliente, true, true);

                        $("#selectCliente")
                            .append(opcion)
                            .trigger('change');

                        $("#modalNuevoCliente").modal("hide");
                    }
                }
            });

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

        $("#btnNuevoVehiculo").on("click", function () {

            let idCliente = $("#selectCliente").val();

            if (!idCliente) {
                alert("Selecciona un cliente primero.");
                return;
            }

            $("#vehiculoModal_idCliente").val(idCliente);
            $("#formNuevoVehiculo")[0].reset();
            $("#vehiculoModal_idCliente").val(idCliente);

            $("#modalNuevoVehiculo").modal("show");
        });

        $("#formNuevoVehiculo").on("submit", function(e){
            e.preventDefault();

            let datosVehiculo = $(this).serialize();

            $.ajax({
                url: "{{ route('guardarVehiculoAjax') }}",
                type: "POST",
                data: datosVehiculo,

                success: function(res){
                    if(res.success){

                        let txt = res.vehiculo.Matricula + " - " + res.vehiculo.Marca + " " + res.vehiculo.Modelo;

                        let $opcion = $(new Option(txt, res.vehiculo.id_Vehiculo, true, true));
                        $opcion.attr('data-cliente', res.vehiculo.id_Cliente);

                        $selectVehiculo.append($opcion).trigger("change");

                        $("#modalNuevoVehiculo").modal("hide");
                    }
                }
            });

        });

    });
</script>
@endsection
