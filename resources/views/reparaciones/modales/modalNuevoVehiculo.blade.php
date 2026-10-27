<div class="modal fade" id="modalNuevoVehiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header">
                <h5 class="modal-title">Añadir Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="formNuevoVehiculo" class="validar">

                    @csrf

                    <input type="hidden" name="id_Cliente" id="vehiculoModal_idCliente">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Matrícula *</label>
                            <input type="text" name="Matricula" class="form-control matriculaEsp" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Marca *</label>
                            <input type="text" name="Marca" class="form-control soloLetras" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Modelo *</label>
                            <input type="text" name="Modelo" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Año</label>
                            <input type="number" name="Ano" class="form-control" min="1900" max="{{ date('Y') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Versión</label>
                            <input type="text" name="Version" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Bastidor</label>
                            <input type="text" name="Bastidor" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Número de Motor</label>
                            <input type="text" name="NumeroMotor" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tipo Motor</label>
                            <input type="text" name="TipoMotor" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Cilindrada</label>
                            <input type="text" name="Cilindrada" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Potencia</label>
                            <input type="text" name="Potencia" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Kilómetros</label>
                            <input type="number" name="Kilometros" class="form-control">
                        </div>

                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Vehículo</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
