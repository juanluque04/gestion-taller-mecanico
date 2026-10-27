@extends('layouts.nav')

@section('titulo', 'Mi perfil')

@section('panelContenido')

<div class="container py-4">

    <h2 class="mb-4">Mi Perfil</h2>

    <form method="POST" action="{{ route('guardarPerfil') }}" class="validar">
        @csrf

        <div class="card app-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Información personal</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Nombre completo *</label>
                    <input type="text" name="Nombre" class="form-control soloLetras"
                           value="{{ Auth::user()->Nombre }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre de usuario *</label>
                    <input type="text" name="NombreUsuario" class="form-control"
                           value="{{ Auth::user()->NombreUsuario }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico *</label>
                    <input type="email" name="Correo" class="form-control"
                           value="{{ Auth::user()->Correo }}" required>
                </div>

            </div>
        </div>

        <div class="card app-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Cambiar contraseña</h5>
            </div>

            <div class="card-body">

                <div class="form-floating mb-3 password-wrapper">
                    <input type="password" class="form-control" id="oldPassword" name="old_password" placeholder="Contraseña actual">
                    <label for="oldPassword">Contraseña actual</label>

                    <button type="button" class="password-toggle-btn" data-password-toggle="oldPassword">
                        <img src="{{ asset('img/ojo-off.png') }}" alt="Mostrar contraseña" style="margin-right:20px">
                    </button>
                </div>

                <div class="form-floating mb-3 password-wrapper">
                    <input type="password" class="form-control"id="newPassword" name="new_password" placeholder="Nueva contraseña">
                    <label for="newPassword">Nueva contraseña</label>

                    <button type="button" class="password-toggle-btn" data-password-toggle="newPassword">
                        <img src="{{ asset('img/ojo-off.png') }}" alt="Mostrar contraseña" style="margin-right:20px">
                    </button>
                </div>

                <div class="form-floating mb-3 password-wrapper">
                    <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" placeholder="Confirmar nueva contraseña">
                    <label for="confirmPassword">Confirmar nueva contraseña</label>

                    <button type="button" class="password-toggle-btn" data-password-toggle="confirmPassword">
                        <img src="{{ asset('img/ojo-off.png') }}" alt="Mostrar contraseña" style="margin-right:20px">
                    </button>
                </div>

                <p class="text-muted small">
                    * Si no deseas cambiar la contraseña, deja estos campos vacíos.
                </p>

            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('inicio') }}" class="btn btn-secondary">Volver</a>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>

    </form>

</div>

@endsection

<script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('[data-password-toggle]').forEach(function(btn) {

                btn.addEventListener('click', function() {

                    const inputId = this.getAttribute('data-password-toggle');
                    const input = document.getElementById(inputId);
                    if (!input) return;

                    const img = this.querySelector("img");
                    if (!img) return;

                    const isHidden = input.type === "password";

                    input.type = isHidden ? "text" : "password";

                    img.src = isHidden 
                        ? "{{ asset('img/ojo-on.png') }}" 
                        : "{{ asset('img/ojo-off.png') }}";

                    this.classList.toggle("active", isHidden);
                });

            });

        });
    </script>
