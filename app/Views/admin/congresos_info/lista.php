<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de congresos</h4>
                <hr>
                <h5>Los campos <label class="text-danger">requeridos</label> son necesarios para aceptar los movimientos</h5>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_congresosinfo">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Congreso</th>
                                <th class="centered">Red</th>
                                <th class="centered">Sede</i></th>
                                <th class="centered">Fechas</th>
                                <th class="centered">Año</i></th>
                                <th class="centered">Activo</th>
                                <th class='centered'>Ver información completa</th>
                                <th class="centered">Editar</th>
                            </tr>
                        </thead>
                        <tbody id="dt_congresosinfo">

                        </tbody>
                    </table>
                </div>
                <br>
                <a href="./agregarcongreso" class="btn btn-success btn-block">Agregar Congreso</a>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/congresoinfo.js') ?>"></script>