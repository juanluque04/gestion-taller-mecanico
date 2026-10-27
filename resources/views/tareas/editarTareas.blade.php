@extends('layouts.nav')

@section('titulo', 'Editar Tarea')

@section('panelContenido')

<div class="container py-4">

    <h2 class="mb-4">Editar Tarea</h2>

    <!-- <div class="card mb-4">
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
    </div> -->

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Datos de la tarea</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('actualizarTarea', $tarea->id_Tarea) }}" method="POST" class="validar">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Descripción *</label>
                    <textarea name="Descripcion" class="form-control" required>{{ $tarea->Descripcion }}</textarea>
                </div>

                <div class="row mb-3">

                    <div class="col-md-4">
                        <label class="form-label">Trabajador *</label>
                        <select name="user_id" class="form-select" required>
                            @foreach($trabajadores as $u)
                                <option value="{{ $u->user_id }}" {{ $tarea->user_id == $u->user_id ? 'selected' : '' }}>
                                    {{ $u->Nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Prioridad *</label>
                        <select name="Prioridad" class="form-select" required>
                            <option value="alta"  {{ $tarea->Prioridad=='alta' ? 'selected' : '' }}>Alta</option>
                            <option value="media" {{ $tarea->Prioridad=='media' ? 'selected' : '' }}>Media</option>
                            <option value="baja"  {{ $tarea->Prioridad=='baja' ? 'selected' : '' }}>Baja</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado *</label>
                        <select name="Estado" class="form-select" required>
                            <option value="pendiente"  {{ $tarea->Estado=='pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="en curso"   {{ $tarea->Estado=='en curso' ? 'selected' : '' }}>En curso</option>
                            <option value="terminada"  {{ $tarea->Estado=='terminada' ? 'selected' : '' }}>Terminada</option>
                            <option value="revisada"   {{ $tarea->Estado=='revisada' ? 'selected' : '' }}>Revisada</option>
                        </select>
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4">
                        <label class="form-label">Fecha programada</label>
                        <input type="date" name="FechaProgramada" class="form-control"
                               value="{{ $tarea->FechaProgramada ? \Carbon\Carbon::parse($tarea->FechaProgramada)->format('Y-m-d') : '' }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Horas previstas</label>
                        <input type="number" name="HorasPrevistas" class="form-control"
                               value="{{ $tarea->HorasPrevistas }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Horas reales</label>
                        <input type="number" name="HorasReales" class="form-control"
                               value="{{ $tarea->HorasReales }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Importe</label>
                    <input type="number" step="0.01" name="Importe" class="form-control" value="{{ $tarea->Importe }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="Observaciones" class="form-control">{{ $tarea->Observaciones }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ session('prev_url') }}" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>

            </form>

        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Materiales usados</h5>
        </div>

        <div class="card-body">

            @if($tarea->materiales->isEmpty())
                <p class="text-muted">No hay materiales registrados.</p>
            @else
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th data-label="Cantidad">Cantidad</th>
                            <th data-label="Descripción">Descripción</th>
                            <th data-label="Estado">Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($tarea->materiales as $m)
                        <tr>
                            <td>{{ $m->Cantidad }}</td>
                            <td>{{ $m->Descripcion }}</td>
                            <td>{{ ucfirst($m->Estado) }}</td>
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
                        <div class="d-flex gap-2">
                            <form action="{{ route('eliminarFoto', $fotoInicial->id_Foto) }}" method="POST" onsubmit="return confirm('¿Eliminar foto inicial?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </form>

                            @if(Auth::user()->Rol === 'jefe')
                                <a href="{{ route('descargarFoto', $fotoInicial->id_Foto) }}" class="btn btn-info btn-sm">
                                    Descargar
                                </a>
                            @endif
                        </div>
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
                        <div class="d-flex gap-2">
                            <form action="{{ route('eliminarFoto', $fotoFinal->id_Foto) }}" method="POST" onsubmit="return confirm('¿Eliminar foto final?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </form>

                            @if(Auth::user()->Rol === 'jefe')
                                <a href="{{ route('descargarFoto', $fotoFinal->id_Foto) }}" class="btn btn-info btn-sm">
                                    Descargar
                                </a>
                            @endif
                        </div>
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

