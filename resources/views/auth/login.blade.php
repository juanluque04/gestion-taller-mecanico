@extends('layouts.auth')

@section('titulo', 'Iniciar sesión')

@section('contenido')

<main class="form-signin w-100 m-auto">

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <img class="h3 d-flex justify-content-left align-items-center gap-3 mb-4" src="{{ asset('img/herramientas.png') }}" alt="Logo" width="72" height="72">

        <h1 class="h3 d-flex justify-content-left align-items-center gap-3 mb-4">Iniciar sesión</h1>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingUser" name="NombreUsuario" placeholder="Usuario" value="{{ old('NombreUsuario') }}" required autofocus>
            <label for="floatingUser">Nombre de usuario</label>
        </div>

        <div class="form-floating mb-3 password-wrapper">
            <input type="password" class="form-control" id="loginPassword" name="Contrasena" placeholder="Contraseña" required>
            <label for="loginPassword">Contraseña</label>

            <button type="button" class="password-toggle-btn" data-password-toggle="loginPassword">
                <img src="{{ asset('img/ojo-off.png') }}" alt="Mostrar contraseña">
            </button>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">
            Entrar
        </button>

        <p class="mt-4 mb-0">
            <a href="{{ route('register') }}"><small>¿No tienes cuenta? Regístrate</small></a>
        </p>
    </form>

</main>

@endsection
