<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Métodos de pago</h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_metodos">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Número de tarjeta</th>
                                <th class="centered">Tipo de tarjeta</th>
                                <th class="centered">Subido por</th>
                                <th class="centered">Fecha de registro</th>
                                <th class="centered">Editar</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_metodos">

                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <button class="btn btn-block btn-md btn-success agregar">Agregar método de pago</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar método de pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAdd">
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            Nombre del método de pago <span class="text-warning">* Si es Paypal o relacionados, establecer el nombre con el número de la tarjeta. Ejemplo: <u>Paypal - 1234-5678-9012-3456</u></span>
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>
                            Número de tarjeta <span class="text-warning">* Si no aplica, establecer <u>NA</u></span>
                        </label>
                        <input type="text" placeholder="xxxx xxxx xxxx xxxx" name="numero" id="numero" class="form-control numero">
                        <label for="check_na" style="margin-top: 5px;">
                            <input type="checkbox" id="check_na">
                            No aplica
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Tipo de tarjeta
                        </label>
                        <select class="form-control" name="tipo_tarjeta" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="Debito">Tarjeta de débito</option>
                            <option value="Crédito">Tarjeta de crédito</option>
                            <option value="NA">No aplica</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar método de pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEdit">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>
                            Nombre del método de pago <span class="text-warning">* Si es Paypal o relacionados, establecer el nombre con el número de la tarjeta. Ejemplo: <u>Paypal - 1234-5678-9012-3456</u></span>
                        </label>
                        <input type="text" name="nombre" id="nombre_edit" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>
                            Número de tarjeta <span class="text-warning">* Si no aplica, establecer <u>NA</u></span>
                        </label>
                        <input type="text" placeholder="xxxx xxxx xxxx xxxx" name="numero" id="numero_edit" class="form-control numero">
                        <label for="check_na" style="margin-top: 5px;">
                            <input type="checkbox" class="check_na">
                            No aplica
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Tipo de tarjeta
                        </label>
                        <select class="form-control" name="tipo_tarjeta" id="tipo_tarjeta_edit" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="Debito">Tarjeta de débito</option>
                            <option value="Crédito">Tarjeta de crédito</option>
                            <option value="NA">No aplica</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    const base_url = '<?= base_url() ?>';
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url('resources/admin/datatables/metodos_pago.js') ?>"></script>