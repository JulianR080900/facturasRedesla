<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Resumen del grupo <?= $claveCuerpo ?></h4>
                <div class="row">
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas validas</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_1 ?></h2>
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
                                <h5>Encuestas incompletas</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_2 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class=" icon-lg mdi mdi-alert text-warning"></i>
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
                                        <i class=" icon-lg mdi mdi-block-helper text-danger"></i>
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
                                        <i class=" icon-lg mdi mdi-backup-restore text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas de prueba</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_5 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class=" icon-lg mdi mdi-test-tube text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas sin revisión</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_0 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-color-helper text-secondary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h4 class="card-title text-uppercase">Descargas</h4>
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-success btn-block btn-rounded downloadButton" href="../../getExcelEncuestasEquipo/<?= $nombre_tabla ?>/<?= $claveCuerpo ?>"><i class="mdi mdi-file-excel"></i>Descargar todas las encuestas de este equipo.</a>
                    </div>
                    <div class="col-md-6">
                        <a href="../../getExcelEncuestasEquipoValidas/<?= $nombre_tabla ?>/<?= $claveCuerpo ?>" class="btn btn-block btn-warning btn-rounded downloadButton"><i class="mdi mdi-file-excel"></i>Descargar solo las encuestas válidas</a>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="dropdown">
                            <button class="btn btn-info btn-block btn-sm btn-rounded dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-history"></i>Historial de mensajes enviados <span class="badge badge-danger badge-pill badge-sm"><?= count($mensajes) ?></span>
                            </button>
                            <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                <?php foreach ($mensajes as $mensaje) { ?>
                                    <button class="dropdown-item mensaje-item" name="" href="#" data-toggle="modal" data-target="#mensajeModal" data-mensaje="<?php echo $mensaje['mensaje']; ?>">Mensaje del <?php echo $mensaje['fechaExpiracion']; ?></button>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div> -->

                <hr>
                <!-- <h4 class="card-title text-uppercase">Lista de encuestas</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped table-responsive-lg" id="dt_investigacion">
                        <thead>
                            <tr>
                                <th class="centered">Folio</th>
                                <th class="centered">Nombre del encuestador</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Cantidad de NC/NA detectados</th>
                                <th class="centered">Ver cuestionario</th>
                            </tr>
                        </thead>
                        <tbody id="tb_investigacion">

                        </tbody>
                    </table>
                </div> -->
                <h4 class="card-title text-uppercase">Validación</h4>
                <div class="row">
                    <div class="col md-6">
                        <button type="button" class="btn btn-success btn-rounded btn-block aceptar">Aceptar fase</button>
                    </div>
                    <div class="col md-6">
                        <button type="button" class="btn btn-danger btn-rounded btn-block devolver">Devolver fase</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="claveCuerpo" value="<?= $claveCuerpo ?>">
    <input type="hidden" id="tipo" value="<?= $tipo ?>">
    <input type="hidden" id="red" value="<?= $red ?>">
    <input type="hidden" id="anio" value="<?= $anio ?>">

</div>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Observaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="../validar">
                    <div class="form-group">
                        <label for="nombre">Escribe tus observaciones:</label>
                        <textarea name="observaciones" id="observaciones" cols="30" rows="10" class="form-control"></textarea>
                        <input type="hidden" name="estado" id="estado">
                        <input type="hidden" name="claveCuerpo" value="<?= $claveCuerpo ?>">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mensajeModalLabel">Mensaje</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="mensajeTexto"></p>
            </div>
        </div>
    </div>
</div>

<script>

    $(".aceptar").on('click',function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Esta seguro que desea aceptar esta fase?',
            text: 'Esta accion no es reversible',
            icon: 'warning',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí",
            cancelButtonText: "No",
        }).then((result) => {
            if(result.isConfirmed){
                let claveCuerpo = $("#claveCuerpo").val()
                let tipo = $("#tipo").val()
                let red = $("#red").val()
                let anio = $("#anio").val()
                $.ajax({
                    url: '../../updatePhase',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        claveCuerpo: claveCuerpo,
                        tipo: tipo,
                        red: red,
                        anio: anio,
                        terminado: 0
                    },
                    beforeSend: function(){
                        $("#loader").show()
                    },
                    success: function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'Exito',
                            text: 'Fase aceptada correctamente.'
                        }).then(function(){
                            window.location.href = '../../inicio'
                        })
                    },
                    error: function(jqXHR){
                        Swal.fire({
                            icon: 'error',
                            title: `Error ${jqXHR.status}`,
                            text: 'Contacte a sistemas.'
                        })
                    },
                    complete: function(){
                        $("#loader").hide()
                    }
                })
            }
        })
    })

    $(".devolver").on('click',function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Esta seguro que desea devolver esta fase?',
            text: 'Esta accion no es reversible',
            icon: 'warning',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí",
            cancelButtonText: "No",
            input: 'text',
            inputLabel: 'Escriba el porque ha sido devuelta la fase',
            inputPlaceholder: '',
        }).then((result) => {
            if(result.isConfirmed){
                let claveCuerpo = $("#claveCuerpo").val()
                let tipo = $("#tipo").val()
                let red = $("#red").val()
                let anio = $("#anio").val()
                let mensaje = result.value
                $.ajax({
                    url: '../../updatePhase',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        claveCuerpo: claveCuerpo,
                        tipo: tipo,
                        red: red,
                        anio: anio,
                        terminado: 2,
                        mensaje: mensaje
                    },
                    beforeSend: function(){
                        $("#loader").show()
                    },
                    success: function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'Exito',
                            text: 'Fase devuelta correctamente.'
                        }).then(function(){
                            window.location.href = '../../inicio'
                        })
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                        Swal.fire({
                            icon: 'error',
                            title: `Error ${jqXHR.status}`,
                            text: 'Contacte a sistemas.'
                        })
                    },
                    complete: function(){
                        $("#loader").hide()
                    }
                })
            }
        })
    })
</script>