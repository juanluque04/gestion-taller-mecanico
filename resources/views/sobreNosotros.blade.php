@extends('layouts.nav')

@section('titulo', 'Sobre Nosotros')

@section('panelContenido')
<div class="container py-4">

    <div class="card shadow-sm p-4" style="border-radius: 14px;">
        <h2 class="mb-3">Sobre Nosotros</h2>
        <p>
            Somos un taller comprometido con la organización, eficiencia y transparencia en cada reparación.
            Este sistema ha sido creado para optimizar el control de tareas, mejorar la comunicación interna
            y ofrecer un servicio más profesional a nuestros clientes.
        </p>

        <p>
            Nuestro objetivo es que tanto trabajadores como jefes tengan una herramienta moderna, intuitiva
            y rápida para gestionar el día a día del taller.
        </p>

        <p class="mt-3">
            Gracias por confiar en nosotros.
        </p>

        <p class="lead">
            Este proyecto ha sido desarrollado por <strong>Juan Luque</strong> como parte del trabajo académico
            realizado en el instituto <strong>IES Trassierra</strong>.
        </p>

        <a href="{{ route('inicio') }}" class="btn btn-primary mt-3">Volver al inicio</a>
    </div>

</div>
@endsection


