
<div class="modal fade" id="modalNuevoMaterial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Añadir Material</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('agregarMaterial', $tarea->id_Tarea) }}" method="POST">
                @csrf
                <div class="modal-body">

                    <label class="form-label">Descripción*</label>
                    <textarea class="form-control" name="Descripcion" required></textarea>

                    <label class="form-label mt-3">Cantidad*</label>
                    <input type="number" class="form-control" name="Cantidad" required>

                    <label class="form-label mt-3">Estado</label>
                    <select name="Estado" class="form-select">
                        <option value="pedido">Pedido</option>
                        <option value="recibido">Recibido</option>
                        <option value="usado">Usado</option>
                    </select>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary">Guardar material</button>
                </div>
            </form>

        </div>
    </div>
</div>