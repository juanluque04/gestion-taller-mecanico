@extends('layouts.nav')

@section('titulo', 'Crear Cliente')

@section('panelContenido')
<div class="container py-4">

    <h2 class="mb-4">Registrar nuevo Cliente</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <form id="formCrearCliente" class="validar" method="POST" action="{{ route('guardarClientes') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="Nombre" class="form-control soloLetras" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="Telefono" class="form-control telefonoEsp" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">DNI</label>
                    <input type="text" name="DNI" class="form-control dniEsp" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="Direccion" class="form-control" minlength="5">
                </div>

                <input type="hidden" name="vehiculos_json" id="vehiculos_json">

                <button type="button" class="btn btn-secondary mb-2" id="btnAñadirVehiculo">
                    + Añadir vehículo
                </button>

                <ul id="listaVehiculosTemp" class="list-group mb-3 d-none"></ul>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('gestionarClientes') }}" class="btn btn-outline-secondary">
                        Volver
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Crear cliente
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

@include('reparaciones.modales.modalNuevoVehiculo')

@endsection

@section('scripts')
<script>
    let vehiculosTemp = [];

    $("#btnAñadirVehiculo").on("click", function () {
        $("#formNuevoVehiculo")[0].reset();
        $("#formNuevoVehiculo").validate().resetForm();
        $("#modalNuevoVehiculo").modal("show");
    });

    $("#formNuevoVehiculo").validate({
        rules: {
            Matricula: { required: true },
            Marca: { required: true },
            Modelo: { required: true }
        },
        messages: {
            Matricula: "Introduce una matrícula",
            Marca: "Introduce una marca",
            Modelo: "Introduce un modelo"
        },
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },
        submitHandler: function (form) {

            let datos = {
                Marca: $("input[name='Marca']").val(),
                Modelo: $("input[name='Modelo']").val(),
                Ano: $("input[name='Ano']").val(),
                Matricula: $("input[name='Matricula']").val(),
                Version: $("input[name='Version']").val(),
                Bastidor: $("input[name='Bastidor']").val(),
                NumeroMotor: $("input[name='NumeroMotor']").val(),
                TipoMotor: $("input[name='TipoMotor']").val(),
                Cilindrada: $("input[name='Cilindrada']").val(),
                Potencia: $("input[name='Potencia']").val(),
                Kilometros: $("input[name='Kilometros']").val()
            };

            vehiculosTemp.push(datos);
            actualizarListaVehiculos();

            $("#vehiculos_json").val(JSON.stringify(vehiculosTemp));

            $("#modalNuevoVehiculo").modal("hide");
        }
    });

    function actualizarListaVehiculos() {
        let lista = $("#listaVehiculosTemp");
        lista.empty();

        if (vehiculosTemp.length === 0) {
            lista.addClass("d-none");
            return;
        }

        lista.removeClass("d-none");

        vehiculosTemp.forEach((v, index) => {
            lista.append(`
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><strong>${v.Marca} ${v.Modelo}</strong> (${v.Matricula})</span>

                    <button class="btn btn-sm btn-danger" onclick="eliminarVehiculo(${index})">
                        Eliminar
                    </button>
                </li>
            `);
        });
    }

    function eliminarVehiculo(index) {
        vehiculosTemp.splice(index, 1);
        actualizarListaVehiculos();
        $("#vehiculos_json").val(JSON.stringify(vehiculosTemp));
    }

    $("#formCrearCliente").on("submit", function () {
        $("#vehiculos_json").val(JSON.stringify(vehiculosTemp));
    });

</script>
@endsection
