<div class="modal modal-sheet fade" id="modalNuevoCliente" tabindex="-1" aria-labelledby="modalNuevoClienteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow">

      <div class="modal-header">
        <h5 class="modal-title">Añadir Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

          <form id="formNuevoCliente" class="validar">
              @csrf

              <div class="form-floating mb-3">
                  <input type="text" name="Nombre" class="form-control soloLetras" id="nuevoClienteNombre" required>
                  <label for="nuevoClienteNombre">Nombre</label>
              </div>

              <div class="form-floating mb-3">
                  <input type="text" name="DNI" class="form-control dniEsp" id="nuevoClienteDNI" required>
                  <label for="nuevoClienteDNI">DNI</label>
              </div>

              <div class="form-floating mb-3">
                  <input type="text" name="Direccion" class="form-control" id="nuevoClienteDireccion">
                  <label for="nuevoClienteDireccion">Dirección</label>
              </div>

              <div class="form-floating mb-3">
                  <input type="text" name="Telefono" class="form-control telefonoEsp" id="nuevoClienteTelefono">
                  <label for="nuevoClienteTelefono">Teléfono</label>
              </div>

              <div class="mt-4 text-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Cliente</button>
              </div>

          </form>
      </div>

    </div>
  </div>
</div>
