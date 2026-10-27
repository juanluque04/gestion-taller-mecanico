@extends('layouts.nav')

@section('titulo', 'Inicio')

@section('panelContenido')

@php
    $user = Auth::user();
    $rol = $user->Rol ?? 'trabajador';
@endphp

<div class="py-4 d-flex justify-content-center">
    <div class="dashboard-wrapper" style="width:100%; max-width: 1300px;">

        <div class="mb-4">
            <h1 class="fw-bold mb-1" style="font-size:1.8rem; color:var(--color-text-main);">
                @if($rol === 'jefe')
                    Panel general del taller
                @else
                    Bienvenido, {{ $user->Nombre }}
                @endif
            </h1>

            <p class="mb-0" style="font-size:1rem; color:var(--color-text-soft);">
                @if($rol === 'jefe')
                    Resumen rápido del estado del taller y accesos a las secciones principales.
                @else
                    Aquí tienes un resumen de tus tareas y accesos directos.
                @endif
            </p>
        </div>

        @if($rol === 'jefe')

            <div class="row g-4 mb-4">

                @php
                    $stats = [
                        ['label' => 'Reparaciones activas', 'value' => $reparacionesActivas ?? 0, 'desc' => 'En curso o pendientes'],
                        ['label' => 'Tareas pendientes', 'value' => $tareasPendientes ?? 0, 'desc' => 'Asignadas a trabajadores'],
                        ['label' => 'Vehículos en taller', 'value' => $vehiculosEnTaller ?? 0, 'desc' => 'Con reparación abierta'],
                        ['label' => 'Trabajadores', 'value' => $numTrabajadores ?? 0, 'desc' => 'Usuarios activos'],
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div class="col-lg-3 col-md-6">
                        <div class="card text-white" style="background:#0b1628; padding:20px; border-radius:14px;">
                            <p class="text-uppercase small mb-1" style="opacity:0.7;">{{ $stat['label'] }}</p>
                            <h2 class="fw-bold">{{ $stat['value'] }}</h2>
                            <p class="small" style="opacity:0.7;">{{ $stat['desc'] }}</p>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="row g-4">

                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 h-100" style="border-radius:16px;">
                        <div class="card-body d-flex flex-column justify-content-between">

                            <div class="mb-3">
                                <h4 class="fw-semibold mb-1">Gestión de tareas y calendario</h4>
                                <p class="text-muted small">
                                    Organiza el trabajo diario, consulta qué hay para hoy y revisa el calendario.
                                </p>
                            </div>

                            <div class="d-flex flex-column align-items-end gap-2">
                                <a href="{{ route('misTareas') }}" class="btn btn-primary w-50 text-center">
                                    Ver lista de tareas
                                </a>
                                <a href="{{ route('calendario') }}" class="btn btn-outline-secondary w-50 text-center">
                                    Abrir calendario
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 h-100" style="border-radius:16px;">
                        <div class="card-body d-flex flex-column justify-content-between">

                            <div class="mb-3">
                                <h4 class="fw-semibold mb-1">Gestión del taller</h4>
                                <p class="text-muted small">
                                    Accede rápidamente a clientes, vehículos, reparaciones y trabajadores.
                                </p>
                            </div>

                            <div class="d-flex flex-column align-items-end gap-2">
                                <a href="{{ route('gestionarReparaciones') }}" class="btn btn-primary w-50 text-center">
                                    Reparaciones
                                </a>

                                <div class="btn-group w-50">
                                    <a href="{{ route('gestionarClientes') }}" class="btn btn-outline-secondary btn-sm w-100">Clientes</a>
                                    <a href="{{ route('gestionarVehiculos') }}" class="btn btn-outline-secondary btn-sm w-100">Vehículos</a>
                                    <a href="{{ route('gestionarTrabajadores') }}" class="btn btn-outline-secondary btn-sm w-100">Trabajadores</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        @else

            <div class="row g-4 mb-4">

                @php
                    $statsTrab = [
                        ['label'=>'Tareas para hoy','value'=>$tareasHoy ?? 0,'desc'=>'Programadas en el calendario'],
                        ['label'=>'Pendientes totales','value'=>$tareasPendientes ?? 0,'desc'=>'Sin terminar'],
                        ['label'=>'Horas previstas hoy','value'=>$horasPrevistasHoy ?? 0,'desc'=>'Horas estimadas de tus tareas'],
                    ];
                @endphp

                @foreach($statsTrab as $stat)
                    <div class="col-lg-4 col-md-6">
                        <div class="card text-white" style="background:#0b1628; padding:20px; border-radius:14px;">
                            <p class="text-uppercase small mb-1" style="opacity:.7;">{{ $stat['label'] }}</p>
                            <h2 class="fw-bold">{{ $stat['value'] }}</h2>
                            <p class="small" style="opacity:.7;">{{ $stat['desc'] }}</p>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="row g-4">

                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 h-100" style="border-radius:16px;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <h4 class="fw-semibold">Tus tareas</h4>
                                <p class="text-muted small">Accede a tu lista de tareas asignadas.</p>
                            </div>

                            <a href="{{ route('misTareas') }}" class="btn btn-primary w-50 ms-auto">
                                Ver mis tareas
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 h-100" style="border-radius:16px;">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <h4 class="fw-semibold">Calendario</h4>
                                <p class="text-muted small">Visualiza tus tareas en el calendario.</p>
                            </div>

                            <a href="{{ route('calendario') }}" class="btn btn-outline-secondary w-50 ms-auto">
                                Abrir calendario
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        @endif

    </div>
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
