<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Todas las facturas</h4>
                <div class="row">
                    <button type="button" class="btn btn-md btn-info corte">Descargar corte de facturas</button>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table" id="dt_facturas">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Subido por</th>
                                <th class="centered">Provedor</th>
                                <th class="centered">Método de pago</th>
                                <th class="centered">Monto</th>
                                <th class="centered">Archivo PDF</i></th>
                                <th class="centered">Archivo XML</th>
                                <th class="centered">Fecha del pago</i></th>
                                <th class="centered">Fecha de factura</th>
                                <th class="centered">Fecha de inserción al sistema</th>
                            </tr>
                        </thead>
                        <tbody id="dt_facturas">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDownload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Obtener facturas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formDownload">
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            Ciclo de la factura
                        </label>
                        <select name="mes" id="mes" class="form-control" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label>
                            Año
                        </label>
                        <select name="anio" id="anio" class="form-control" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <?php
                            foreach($anios as $a){
                                ?>
                                <option value="<?= $a['anio'] ?>"><?= $a['anio'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Obtener facturas</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
</script>

<script src="<?= base_url('resources/admin/datatables/facturasAdminTodo.js') ?>"></script>