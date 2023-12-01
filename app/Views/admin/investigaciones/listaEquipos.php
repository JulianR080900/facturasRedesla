<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de Equipos</h4>

                <div class="row">
                    <div class="col-sm-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Cantidad de equipos con encuestas registradas</h5>
                                <div class="row">
                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $c_cuerpos ?></h2>
                                        </div>
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <a href="../getExcelEquipos/<?= $nombre_tabla ?>" style="text-decoration: none;" class="text-success">Descargar Excel de los equipos</a>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-worker text-primary ml-auto"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Cantidad de encuestas registradas</h5>
                                <div class="row">
                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $c_encuestas ?></h2>
                                        </div>
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <a href="../getExcelEncuestas/<?= $nombre_tabla ?>" style="text-decoration: none;" class="text-success">Descargar Excel de todas las encuestas</a>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-book text-danger ml-auto"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5 >Encuestas validas</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0" ><?= $estado_1 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                    <i class="icon-lg mdi mdi-check-circle text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5 >Encuestas incompletas</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_2 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                    <i class = " icon-lg mdi mdi-alert text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas no validas</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_3 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                    <i class = " icon-lg mdi mdi-block-helper text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas recapturables</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_4 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                    <i class = " icon-lg mdi mdi-backup-restore text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5 >Encuestas de prueba</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0" ><?= $estado_5 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                    <i class = " icon-lg mdi mdi-test-tube text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5 >Encuestas sin revisión</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0" ><?= $estado_0 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                    <i class = "icon-lg mdi mdi-color-helper text-secondary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <label for="" class="text-warning">Solo se puede buscar por clave de la universidad.</label>
                    <table class="table" id="dt_inv">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Clave</th>
                                <th class="centered">Universidad</th>
                                <th class="centered">Encuestas registradas</th>
                                <th class="centered">Porcentaje completado</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Ver información</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_inv">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
    var tabla = '<?= $nombre_tabla ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/investigaciones.js') ?>"></script>