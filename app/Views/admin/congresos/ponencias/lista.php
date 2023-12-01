
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de ponencias</h4>
                <hr>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_ponencias">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class='centered'>Evento</th>
                                <th class="centered">Mesa preliminar</th>
                                <th class="centered">Tipo de asistencia</th>
                                <th class="centered">Clave de ponencia</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Autor</th>
                            </tr>
                        </thead>
                        <tbody id="dt_ponencias">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMesa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar mesa preliminar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white">X</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAct">
                    <div class="form-group">
                        <label for="">Seleccione una mesa</label>
                        <select class='form-control' name='mesa' id='mesa' required>
                            <option selected disabled value=''>Seleccione una opcion</option>
                            <?php
                            foreach($mesas as $m){
                                ?>
                                <option value='<?= $m['clave'] ?>' ><?= $m['nombre'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="text" name="id" id="id" hidden>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-rounded btn-block">Actualizar información</button>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/congresos/ponencias.js') ?>"></script>