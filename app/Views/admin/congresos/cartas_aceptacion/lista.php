<style>
    .texto-truncado {
        white-space: nowrap;
        overflow: hidden;
        cursor: pointer;
    }

    .fila-seleccionada {
        background-color: #f0f0f0;
        /* Cambia el color de fondo a tu preferencia */
    }

    textarea,
    select {
        background-color: #fff !important;
        color: #000 !important;
    }
</style>
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
                                <th class="centered">Nombre de la ponencia</th>
                                <th class="centered">Primer autor</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="dt_ponencias">

                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">Seleccione el congreso al que corresponden las ponencias</label>
                        <select name="" id="congreso" class="form-control">
                            <option value="" selected disabled>Seleccione una opción</option>
                            <?php
                            foreach ($congresos as $c) {
                            ?>
                                <option value="<?= $c['id'] ?>"><?= $c['nombre'] . ' - ' . $c['fechas'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Comentarios</label>
                        <p class="text-warning">Si no desea adjuntar un comentario, deje el campo vacio</p>
                        <textarea name="comentarios" id="comentarios" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div class="form-group col-md-12">
                        <p>¿La ponencia seleccionada ha sido pagada?</p>
                        <div class="radio">
                            <label class="radio-inline"><input type="radio" name="optradio" value="1" required>Si</label>
                            <label class="radio-inline"><input type="radio" name="optradio" value="0" required>No</label>
                        </div>
                    </div>
                    <button id="enviar" class="btn btn-info btn-block btn-rounded">Enviar cartas de aceptación</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/congresos/cartas_aceptacion.js') ?>"></script>