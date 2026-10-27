@extends('layouts.nav')

@section('panelContenido')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 mis-tareas-header">
        <h2 class="mb-0">Mis tareas</h2>

        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa-solid fa-filter me-1"></i> Filtros
            </button>

            <div class="dropdown-menu dropdown-menu-end p-3" style="min-width:250px;">

                <div class="mb-2">
                    <label class="form-label small">Estado</label>
                    <select id="filtroEstado" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="en curso">En curso</option>
                        <option value="terminada">Terminada</option>
                        <option value="revisada">Revisada</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label small">Prioridad</label>
                    <select id="filtroPrioridad" class="form-select form-select-sm">
                        <option value="">Todas</option>
                        <option value="alta">Alta</option>
                        <option value="media">Media</option>
                        <option value="baja">Baja</option>
                    </select>
                </div>

                <hr class="my-2">

                <div class="mb-2">
                    <label class="form-label small">Desde</label>
                    <input type="date" id="filtroFechaDesde" class="form-control form-control-sm">
                </div>

                <div class="mb-2">
                    <label class="form-label small">Hasta</label>
                    <input type="date" id="filtroFechaHasta" class="form-control form-control-sm">
                </div>

            </div>
        </div>
    </div>

    <div class="row g-3">

        @foreach($tareasPorDia as $fecha => $grupo)
            @foreach($grupo as $t)

                <div class="col-12 col-md-6 col-lg-4 tarea-card" data-estado="{{ $t->Estado }}" data-prioridad="{{ $t->Prioridad }}" data-fecha="{{ $fecha !== 'Sin fecha' ? $fecha : '' }}">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body d-flex flex-column">

                            <span class="badge bg-secondary mb-2 align-self-start">
                                {{ $fecha === 'Sin fecha'
                                    ? 'Sin fecha'
                                    : \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                            </span>

                            <strong class="mb-1">{{ $t->Descripcion }}</strong>

                            <small class="text-muted mb-3">
                                Estado: {{ ucfirst($t->Estado) }} |
                                Prioridad: {{ ucfirst($t->Prioridad) }}
                            </small>

                            <div class="mt-auto d-flex justify-content-between align-items-center">

                                <span class="badge bg-info text-dark">
                                    <i class="fa-solid fa-user me-1"></i>
                                    {{ $t->usuario->Nombre ?? 'Sin asignar' }}
                                </span>

                                <a href="{{ auth()->user()->Rol === 'jefe'
                                    ? route('editarTarea', $t->id_Tarea)
                                    : route('verTarea', $t->id_Tarea) }}"
                                   class="btn btn-sm btn-warning">
                                    Editar
                                </a>

                            </div>

                        </div>
                    </div>

                </div>

            @endforeach
        @endforeach

    </div>

</div>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const filtroEstado = document.getElementById('filtroEstado');
    const filtroPrioridad = document.getElementById('filtroPrioridad');
    const filtroFechaDesde = document.getElementById('filtroFechaDesde');
    const filtroFechaHasta = document.getElementById('filtroFechaHasta');

    function aplicarFiltros() {

        document.querySelectorAll('.tarea-card').forEach(card => {

            const estado = card.dataset.estado;
            const prioridad = card.dataset.prioridad;
            const fecha = card.dataset.fecha;

            let visible = true;

            if (filtroEstado.value && filtroEstado.value !== estado) {
                visible = false;
            }

            if (filtroPrioridad.value && filtroPrioridad.value !== prioridad) {
                visible = false;
            }

            if (fecha) {
                if (filtroFechaDesde.value && fecha < filtroFechaDesde.value) {
                    visible = false;
                }
                if (filtroFechaHasta.value && fecha > filtroFechaHasta.value) {
                    visible = false;
                }
            }

            card.style.display = visible ? '' : 'none';
        });
    }

    filtroEstado.addEventListener('change', aplicarFiltros);
    filtroPrioridad.addEventListener('change', aplicarFiltros);
    filtroFechaDesde.addEventListener('change', aplicarFiltros);
    filtroFechaHasta.addEventListener('change', aplicarFiltros);
});
</script>
@endsection

