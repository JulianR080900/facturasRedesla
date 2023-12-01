<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de proyectos</h4>
                <hr>
                <h5>Los campos <label class="text-danger">requeridos</label> son necesarios para aceptar los movimientos</h5>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_proyectosAdmin">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Monto <i class="flag-icon flag-icon-mx"></i></th>
                                <th class="centered">Monto US <i class="flag-icon flag-icon-us"></i></th>
                                <th class="centered">Pronto pago</th>
                                <th class="centered">Precio PP MX <i class="flag-icon flag-icon-mx"></i></th>
                                <th class="centered">Precio PP US <i class="flag-icon flag-icon-us"></i></th>
                                <th class="centered">Activo</th>
                                <th class="centered">Editar</th>
                                <th class="centered">Ver instrucciones</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="dt_proyectosAdmin">

                        </tbody>
                    </table>
                </div>
                <br>
                <a href="./agregar" class="btn btn-success btn-block">Agregar proyecto</a>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/proyectosAdmin.js') ?>"></script>