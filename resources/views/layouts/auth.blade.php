<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Autenticación')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body class="auth-body">
    
<div class="toast-container position-fixed end-0 p-3" style="z-index: 11000; top:70px;">
    @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endforeach
    @endif
</div>

    <div class="auth-container">
        <div class="auth-card">
            @yield('contenido')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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


</body>
</html>
