@extends('layouts.nav')

@section('panelContenido')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Gestión de Trabajadores</h2>
        <a href="{{ route('crearTrabajadores') }}" class="btn btn-success">Crear Trabajador</a>
    </div>

    @if($trabajadores->isEmpty())
        <div class="alert alert-info">No hay trabajadores registrados.</div>
    @else
        <table class="table-modern table-sortable">
            <thead>
                <tr>
                    <th data-sort="string">Nombre</th>
                    <th data-sort="string">Usuario</th>
                    <th data-sort="string">Correo</th>
                    <th data-sort="string">Rol</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($trabajadores as $t)
                <tr>
                    <td data-label="Nombre">{{ $t->Nombre }}</td>
                    <td data-label="Usuario">{{ $t->NombreUsuario }}</td>
                    <td data-label="Correo">{{ $t->Correo }}</td>
                    <td data-label="Rol">
                        @if($t->Rol === 'jefe')
                            <span >Jefe</span>
                        @else
                            <span>Trabajador</span>
                        @endif
                    </td>


                    <td class="text-end">
                        <a href="{{ route('tareasTrabajador', $t->user_id) }}" class="btn btn-sm btn-info">
                            Ver tareas
                        </a>

                        <a href="{{ route('editarTrabajadores', $t->user_id) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        @if($t->Rol !== 'jefe')
                            <form action="{{ route('eliminarTrabajadores', $t->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este trabajador?');">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        @endif

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3 pagination-wrapper">
            <div class="pagination-buttons">
                {{ $trabajadores->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const input = document.getElementById('tablaFiltro');
    if (!input) return;

    input.addEventListener('keyup', () => {
        const texto = input.value.toLowerCase();

        document.querySelectorAll('tbody tr').forEach(fila => {
            const contenido = fila.innerText.toLowerCase();
            fila.style.display = contenido.includes(texto) ? '' : 'none';
        });
    });
});
</script>
@endsection
