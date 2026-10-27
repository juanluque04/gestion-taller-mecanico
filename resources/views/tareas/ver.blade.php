@extends('layouts.nav')

@section('titulo', 'Mi tarea')

@section('panelContenido')

<div class="container py-4">

    <h2 class="mb-4">Detalle de la Tarea</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Vehículo</h5>
        </div>
        <div class="card-body">
            <p><strong>Matrícula:</strong> {{ $tarea->reparacion->vehiculo->Matricula }}</p>
            <p><strong>Marca:</strong> {{ $tarea->reparacion->vehiculo->Marca }}</p>
            <p><strong>Modelo:</strong> {{ $tarea->reparacion->vehiculo->Modelo }}</p>

            <hr>

            <p><strong>Cliente:</strong> {{ $tarea->reparacion->vehiculo->cliente->Nombre }}</p>
            <p><strong>Teléfono:</strong> {{ $tarea->reparacion->vehiculo->cliente->Telefono }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Datos de la tarea</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('actualizarTareaTrabajador', $tarea->id_Tarea) }}" method="POST">
                @csrf

                <p><strong>Descripción:</strong> {{ $tarea->Descripcion }}</p>
                <p><strong>Prioridad:</strong> {{ ucfirst($tarea->Prioridad) }}</p>
                <p><strong>Horas Previstas:</strong> {{ $tarea->HorasPrevistas ?? '—' }}</p>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Horas Reales</label>
                        <input type="number" name="HorasReales" value="{{ $tarea->HorasReales }}" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado</label>
                        <select name="Estado" class="form-select">
                            <option value="pendiente"   {{ $tarea->Estado=='pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en curso"    {{ $tarea->Estado=='en curso' ? 'selected' : '' }}>En curso</option>
                            <option value="terminada"   {{ $tarea->Estado=='terminada' ? 'selected' : '' }}>Terminada</option>
                            <option value="revisada"    {{ $tarea->Estado=='revisada' ? 'selected' : '' }}>Revisada</option>
                        </select>
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="Observaciones" class="form-control" rows="3">{{ $tarea->Observaciones }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ session('prev_url') ?? route('misTareas') }}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
           
            </form>

        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">Materiales usados</h5>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevoMaterial">
                + Añadir material
            </button>
        </div>

        <div class="card-body">
            @if($tarea->materiales->isEmpty())
                <div class="alert alert-info">No hay materiales registrados.</div>
            @else
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($tarea->materiales as $m)
                        <tr>
                            <td data-label="Cantidad">{{ $m->Cantidad }}</td>
                            <td data-label="Descripción">{{ $m->Descripcion }}</td>
                            <td data-label="Estado">{{ ucfirst($m->Estado) }}</td>
                            <td data-label="Acciones">
                                <form action="{{ route('eliminarMaterial', $m->id_Material) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">Fotos de la tarea</h5>
        </div>

        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-6">
                    <h6 class="mb-2">Foto inicial</h6>

                    @php
                        $fotoInicial = $tarea->fotos->where('Tipo', 'inicial')->first();
                    @endphp

                    <div class="foto-box mb-3">
                        @if($fotoInicial)
                            <img onclick="abrirLightbox('{{ asset('storage/'.$fotoInicial->Url) }}')" src="{{ asset('storage/'.$fotoInicial->Url) }}" class="foto-img img-fluid mb-3" style="cursor:pointer;">
                        @else
                            <div class="foto-placeholder">Sin foto</div>
                        @endif
                    </div>

                    <form action="{{ route('subirFoto', $tarea->id_Tarea) }}" method="POST" enctype="multipart/form-data" class="mb-2">
                        @csrf
                        <input type="hidden" name="Tipo" value="inicial">
                        <input type="file" name="foto" class="form-control" required>
                        <button class="btn btn-primary btn-sm mt-2">Subir foto inicial</button>
                    </form>

                    @if($fotoInicial)
                        <form action="{{ route('eliminarFoto', $fotoInicial->id_Foto) }}" method="POST" onsubmit="return confirm('¿Eliminar foto inicial?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar foto</button>
                        </form>
                    @endif
                </div>

                <div class="col-md-6">
                    <h6 class="mb-2">Foto final</h6>

                    @php
                        $fotoFinal = $tarea->fotos->where('Tipo', 'final')->first();
                    @endphp

                    <div class="foto-box mb-3">
                        @if($fotoFinal)
                            <img onclick="abrirLightbox('{{ asset('storage/'.$fotoFinal->Url) }}')" src="{{ asset('storage/'.$fotoFinal->Url) }}" class="foto-img img-fluid mb-3" style="cursor:pointer;">
                        @else
                            <div class="foto-placeholder">Sin foto</div>
                        @endif
                    </div>

                    <form action="{{ route('subirFoto', $tarea->id_Tarea) }}" method="POST" enctype="multipart/form-data" class="mb-2">
                        @csrf
                        <input type="hidden" name="Tipo" value="final">
                        <input type="file" name="foto" class="form-control" required>
                        <button class="btn btn-primary btn-sm mt-2">Subir foto final</button>
                    </form>

                    @if($fotoFinal)
                        <form action="{{ route('eliminarFoto', $fotoFinal->id_Foto) }}"
                            method="POST"
                            onsubmit="return confirm('¿Eliminar foto final?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar foto</button>
                        </form>
                    @endif
                </div>

            </div>

        </div>

    </div>

</div>


<div class="modal fade" id="lightboxModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark p-2" style="border-radius: 10px;">
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            <img id="lightboxImage" src="" class="img-fluid rounded">
        </div>
    </div>
</div>

@include('tareas.modales.modalNuevoMaterial')
@endsection

@section('scripts')
<script>
    function abrirLightbox(src) {
        document.getElementById('lightboxImage').src = src;
        let modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
        modal.show();
    }
</script>
@endsection
