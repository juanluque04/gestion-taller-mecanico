$(document).ready(function () {

    $.validator.addMethod("soloLetras", function (value, element) {
        return this.optional(element) || /^[a-zA-ZÁÉÍÓÚáéíóúñÑ\s]+$/.test(value);
    }, "Solo se permiten letras");

    $.validator.addMethod("telefonoEsp", function (value, element) {
        return this.optional(element) || /^[0-9]{9}$/.test(value);
    }, "Introduce un teléfono válido");

    $.validator.addMethod("dniEsp", function (value, element) {
        return this.optional(element) || /^[0-9]{8}[A-Za-z]$/.test(value);
    }, "Formato de DNI no válido");

    $.validator.addMethod("matriculaEsp", function (value, element) {
        return this.optional(element) || /^[0-9]{4}[A-Z]{3}$/.test(value) ||/^[A-Z]{1,2}[0-9]{4}[A-Z]{0,2}$/.test(value);
    }, "Introduce una matrícula válida");

    $.validator.addMethod("anioValido", function (value, element) {
        if (this.optional(element)) return true;
        let y = parseInt(value);
        let max = new Date().getFullYear();
        return (y >= 1900 && y <= max);
    }, "Introduce un año válido");

    $.validator.setDefaults({
        errorClass: "is-invalid",
        validClass: "is-valid",

        errorPlacement: function (error, element) {
            if (!element.next(".invalid-feedback").length) {
                element.after('<div class="invalid-feedback"></div>');
            }
            element.next(".invalid-feedback").text(error.text());
        }
    });

    $("form.validar").each(function () {

        $(this).validate({

            rules: {

                // clientes
                Nombre: { soloLetras: true, minlength: 3 },
                Telefono: { telefonoEsp: true },
                DNI: { required: true,dniEsp: true },
                Direccion: { minlength: 5 },

                // vehiculos
                Marca: { required: true, soloLetras: true },
                Modelo: { required: true, soloLetras: true },
                Matricula: {required: true, matriculaEsp: true },
                Ano: { anioValido: true },
                Clientes: {required: true},

                // trabajadores
                Correo: { email: true },

                // reparaciones
                FechaEntrada: { required: true, date: true },
                FechaSalida: { date: true },
                Estado: { required: true },

                // tareas
                Descripcion: { required: true, minlength: 3 },
                Prioridad: { required: true },
                Estado: { required: true },
                HorasPrevistas: { number: true},
                HorasReales: { number: true, min: 0 },
                Importe: { number: true, min: 0 },

                // login y register
                Contrasena: { minlength: 6 },
                Contrasena_confirmation: { equalTo: "#floatingPassword" },

            },

            messages: {
                Nombre: { required: "El nombre es obligatorio" },
                Telefono: { required: "El teléfono es obligatorio" },
                DNI: { required: "El DNI es obligatorio" },
                Marca:{ required: "La marca es obligatoria" },
                Modelo:{ required: "El modelo es obligatorio" },
                Matricula: { required: "La matrícula es obligatoria" },
                Clientes: { required: "Seleccione un cliente"},
                Descripcion: { required: "La descripción es obligatoria" },
                Contrasena: {minlength: "La contraseña debe tener al menos 6 caracteres"},
                Contrasena_confirmation: { equalTo: "Las contraseñas no coinciden"},

            }
        });

    });

});
