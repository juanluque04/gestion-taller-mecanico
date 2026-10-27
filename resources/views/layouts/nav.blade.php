<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>

<body>

<nav class="navbar app-navbar fixed-top px-3" style="height:60px;">

    <button id="toggleSidebar" class="navbar-toggler me-3" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand ms-2" href="{{ route('inicio') }}">
        AutoGestión
    </a>

    <div class="flex-grow-1"></div>

    @auth
    <div class="dropdown">
        <a href="#" class="text-white dropdown-toggle text-decoration-none" data-bs-toggle="dropdown">
            <i class="fa-solid fa-user-gear me-1"></i> {{ Auth::user()->Nombre }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('perfil') }}"><i class="fa-solid fa-id-badge me-2"></i>Mi perfil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item"><i class="fa-solid fa-right-from-bracket me-2"></i>Cerrar sesión</button>
                </form>
            </li>
        </ul>
    </div>
    @endauth
</nav>

<div id="sidebar" class="sidebar text-white p-3">

    <h5 class="border-bottom pb-2 mb-3 text-center">Panel del Taller</h5>

    <ul class="navbar-nav">

        <button class="sidebar-btn w-100">
            <a class="sidebar-link {{ request()->routeIs('inicio') ? 'active' : '' }}" 
               href="{{ route('inicio') }}">
                <i class="fa-solid fa-house"></i>
                <span>Inicio</span>
            </a>
        </button>

        @php
            $activeTareas = request()->routeIs('misTareas') || request()->routeIs('calendario');
        @endphp

        <button class="sidebar-btn w-100" data-bs-toggle="collapse" data-bs-target="#menu-tareas">
            <a class="sidebar-link {{ $activeTareas ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i>
                <span>Tareas</span>
            </a>
        </button>

        <div class="collapse {{ $activeTareas ? 'show' : '' }}" id="menu-tareas">
            <ul class="submenu-list list-unstyled small text-center">

                <li>
                    <a href="{{ route('misTareas') }}"
                       class="submenu-link {{ request()->routeIs('misTareas') ? 'active' : '' }}">
                        <i class="fa-solid fa-clipboard-list me-2"></i> Mis tareas
                    </a>
                </li>

                <li>
                    <a href="{{ route('calendario') }}"
                       class="submenu-link {{ request()->routeIs('calendario') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days me-2"></i> Calendario
                    </a>
                </li>

            </ul>
        </div>

        @if(Auth::check() && Auth::user()->Rol === 'jefe')

            @php
                $activeAdmin = request()->routeIs('gestionarTrabajadores') || request()->routeIs('gestionarClientes') || request()->routeIs('gestionarVehiculos') ||  request()->routeIs('gestionarReparaciones');
            @endphp

            <button class="sidebar-btn w-100" data-bs-toggle="collapse" data-bs-target="#menu-admin">
                <a class="sidebar-link {{ $activeAdmin ? 'active' : '' }}">
                    <i class="fa-solid fa-toolbox"></i>
                    <span>Panel de Administración</span>
                </a>
            </button>

            <div class="collapse {{ $activeAdmin ? 'show' : '' }}" id="menu-admin">
                <ul class="submenu-list list-unstyled small text-center">

                    <li>
                        <a href="{{ route('gestionarTrabajadores') }}"
                           class="submenu-link {{ request()->routeIs('gestionarTrabajadores') ? 'active' : '' }}">
                            <i class="fa-solid fa-users-gear me-2"></i> Trabajadores
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('gestionarClientes') }}"
                           class="submenu-link {{ request()->routeIs('gestionarClientes') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-tag me-2"></i> Clientes
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('gestionarVehiculos') }}"
                           class="submenu-link {{ request()->routeIs('gestionarVehiculos') ? 'active' : '' }}">
                            <i class="fa-solid fa-car-side me-2"></i> Vehículos
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('gestionarReparaciones') }}"
                           class="submenu-link {{ request()->routeIs('gestionarReparaciones') ? 'active' : '' }}">
                            <i class="fa-solid fa-screwdriver-wrench me-2"></i> Reparaciones
                        </a>
                    </li>

                </ul>
            </div>

        @endif

    </ul>
</div>

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

<div id="mainContent" class="d-flex flex-column" style="min-height: 100vh;">

    <div class="p-4 flex-grow-1">
        @yield('panelContenido')
    </div>

    @include('layouts.footer')

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

<script src="{{ asset('js/validaciones.js') }}"></script>
<script src="{{ asset('js/ordenarTablas.js') }}"></script>


@yield('scripts')

<script>
    // Barra de navegacion escondido en el menú hamburguesa
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('mainContent').classList.toggle('shifted');
    });


    const toastElList = document.querySelectorAll('.toast');
    toastElList.forEach(toastEl => {
        const t = new bootstrap.Toast(toastEl, { delay: 2500 });
        t.show();
    })

</script>

</body>
</html>
