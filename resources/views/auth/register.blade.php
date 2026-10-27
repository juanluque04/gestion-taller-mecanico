@extends('layouts.auth')

@section('titulo', 'Registro')

@section('contenido')

<main class="form-signin w-100 m-auto">

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <img class="d-flex justify-content-left align-items-center gap-3 mb-4" src="{{ asset('img/herramientas.png') }}" alt="Logo" width="72" height="72">

        <h1 class="h3 d-flex justify-content-left align-items-center gap-3 mb-4">Crear cuenta</h1>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingNombre" name="Nombre" placeholder="Juan Pérez" value="{{ old('Nombre') }}" required>
            <label for="floatingNombre">Nombre completo</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingUsuario" name="NombreUsuario" placeholder="usuario123" value="{{ old('NombreUsuario') }}" required>
            <label for="floatingUsuario">Nombre de usuario</label>
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingCorreo" name="Correo" placeholder="correo@ejemplo.com" value="{{ old('Correo') }}" required>
            <label for="floatingCorreo">Correo electrónico</label>
        </div>

        <div class="form-floating mb-3 password-wrapper">
            <input type="password" class="form-control" id="registerPassword" name="Contrasena" placeholder="********" required>
            <label for="registerPassword">Contraseña</label>

            <button type="button" class="password-toggle-btn" data-password-toggle="registerPassword">
                <img src="{{ asset('img/ojo-off.png') }}" alt="Mostrar contraseña">
            </button>
        </div>

        <div class="form-floating mb-4 password-wrapper">
            <input type="password" class="form-control" id="registerPassword2" name="Contrasena_confirmation" placeholder="********" required>
            <label for="registerPassword2">Confirmar contraseña</label>

            <button type="button" class="password-toggle-btn" data-password-toggle="registerPassword2">
                <img src="{{ asset('img/ojo-off.png') }}" alt="Mostrar contraseña">
            </button>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">
            Crear cuenta
        </button>

        <p class="mt-4 mb-0">
            <a href="{{ route('login') }}"><small>¿Ya tienes cuenta? Inicia sesión</small></a>
        </p>

    </form>

</main>

@endsection
