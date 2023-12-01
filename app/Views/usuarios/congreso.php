<style>
    .max-width-sweet {
        width: 950px !important;
    }

    .tarjetas_gafete .card .head .circle {
        background: var(--<?= $_SESSION['red'] ?>) !important;
    }

    .tarjetas_gafete .card .contact a {
        background: var(--<?= $_SESSION['red'] ?>) !important;
    }

    .linea {
        border-top: 1px solid var(--<?= $_SESSION['red'] ?>) !important;
    }
</style>
<link rel="stylesheet" href="<?= base_url('resources/css/oyente.css') ?>">
<div class="content">

    <!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-body" style="height: 160px;">

                    <div class="row">

                        <div class="col-md-8">

                            <h5 class="modal-title" id="exampleModalLabel">Buscar Ponencia</h5>

                        </div>

                        <div class="col-md-4">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                <span aria-hidden="true">&times;</span>

                            </button>

                        </div>

                    </div>

                    <hr>

                    <!--...-->

                    <h5 class="text-center">Ingrese la contraseña de su ponencia</h5>

                    <div class="col-md-12">

                        <form action="<?php echo base_url("infoCongreso") ?>" id="form-ponencia" method="POST">

                            <input type="text" class="form-control" name="iquatro" id="iquatro" placeholder="Contraseña de ponencia"><br>

                            <!--<button type="submit" class="btn btn-block btn-primary">Buscar</button>-->

                        </form>

                    </div>

                </div>

                <div class="modal-footer" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    <button type="button" class="btn btn-primary" onclick="buscarPonencia()">Buscar</button>

                </div>

            </div>

        </div>

    </div>



    <div class="col-md-12">

        <div class="card card-header-congresos">

            <div class="card-header">

                <h3><?= $nombre_congreso ?></h3>

            </div>

            <div class="card-body card-body-congresos">
                <h3>Archivos adjuntos:</h3>

                <a class="btn btn-danger btn-rounded" href=https://drive.google.com/file/d/1CdhpLOsiqQ8BmKtbTzVjfdkzYU9DkT-q/view?usp=share_link" target="_blank">Manual de registro de ponencias <i class="fas fa-file-pdf"></i> </a>
                <?php
                if (isset($horario_ponencias_congreso)) {
                ?>
                    <a class="btn btn-danger btn-rounded" href="<?= $horario_ponencias_congreso ?>" target="_blank">Programa de ponencias <i class="fas fa-file-pdf"></i> </a>
                <?php
                }

                if (isset($ponencias) || isset($gafetes)) {
                    $url = $_SERVER['REQUEST_URI'];
                    // Obtener el último parámetro
                    $parametros = explode('/', $url);
                    $anio = end($parametros);
                ?>
                    <a class='btn btn-rounded btn-danger' href='../descargas/gafetes/<?= $anio ?>'>Descargar gafetes <i class="fas fa-id-badge"></i></a>
                <?php
                }
                ?>
                <hr>
                <?= isset($instrucciones) ? $instrucciones : 'Instrucciones pendientes'; ?>
                <hr>
                <h3>Archivos adjuntos:</h3>

                <a class="btn btn-danger btn-rounded" href=https://drive.google.com/file/d/1CdhpLOsiqQ8BmKtbTzVjfdkzYU9DkT-q/view?usp=share_link" target="_blank">Manual de registro de ponencias <i class="fas fa-file-pdf"></i> </a>
                <?php
                if (isset($horario_ponencias_congreso)) {
                ?>
                    <a class="btn btn-danger btn-rounded" href="<?= $horario_ponencias_congreso ?>" target="_blank">Programa de ponencias <i class="fas fa-file-pdf"></i> </a>
                <?php
                }

                if (isset($ponencias) || isset($gafetes)) {
                    $url = $_SERVER['REQUEST_URI'];
                    // Obtener el último parámetro
                    $parametros = explode('/', $url);
                    $anio = end($parametros);
                ?>
                    <a class='btn btn-rounded btn-danger' href='../descargas/gafetes/<?= $anio ?>'>Descargar gafetes <i class="fas fa-id-badge"></i></a>
                <?php
                }
                ?>
                <hr>
                
                <?php
                if (!isset($ponencias_registradas)) {
                    #SIGNIFICA QUE NO TIENE CLAVES DE GAFETE, SOLO MOSTRAMOS EL FORMULARIO DE BUSQUEDA
                    $str_instruccion = "";
                    if ($ponencias_pendientes > 0 && $ponencias_disponibles <= 1) {
                        #Tengo pendientes pero no tengo disponibles
                        $str_instruccion = "Tiene {$ponencias_pendientes} ponencia(s) pendientes por registrar. Debe completar el pago correspondiente para continuar.";
                    }

                    if (!empty($str_instruccion)) {
                        echo "<h3>{$str_instruccion}</h3>";
                    } else {
                        if (isset($gafetes)) {
                ?>
                            <h3 class="text-center">Gafetes de oyentes</h3>
                            <div class="row">
                                <div style="margin:auto;">
                                    <div class="linea">&nbsp;</div>
                                    <div class="leyenda">SOMOS <?= $_SESSION['red'] ?></div>
                                    <div class="linea">&nbsp;</div>
                                </div>
                            </div>
                            <div class="tarjetas_gafete">
                                <?php
                                foreach ($gafetes as $g) {
                                    $img = base_url('resources/img/profiles/');
                                    $img .= empty($g['profile_pic']) ? '/avatar.png' : '/' . $g['profile_pic'];
                                ?>
                                    <div class="card">
                                        <div class="head">
                                            <div class="circle"></div>
                                            <div class="img">
                                                <img src="<?= $img ?>" alt="">
                                            </div>
                                        </div>

                                        <div class="description">
                                            <h3><?= $g['nombre'] ?></h3>
                                            <p>Tipo de registro</p>
                                            <h2><?= $g['oyente'] == 1 ? 'Oyente' : 'Ponente' ?></h2>
                                            <h3>Clave de gafete</h3>
                                            <h2><?= $g['clave_gafete'] ?></h2>
                                        </div>

                                        <div class="contact">
                                            <a href="https://vive.redesla.la/congresos/?clave=<?= $g['clave_gafete'] ?>" target="_blank">Ir a VIVE REDESLA</a>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }

                        if (isset($ponencias)) {
                        ?>
                            <h3 class="text-center">Gafetes de ponentes</h3>
                            <div class="row">
                                <div style="margin:auto;">
                                    <div class="linea">&nbsp;</div>
                                    <div class="leyenda">SOMOS <?= $_SESSION['red'] ?></div>
                                    <div class="linea">&nbsp;</div>
                                </div>
                            </div>

                            <?php
                            foreach ($ponencias as $p) {
                            ?>
                                <p class="text-center">Nombre de la ponencia</p>
                                <h3 class="text-center"><?= $p['nombre'] ?></h3>
                                <div class="tarjetas_gafete">
                                    <?php
                                    foreach ($p['gafetes'] as $pg) {
                                        $img = base_url('resources/img/profiles/');
                                        $img .= empty($pg['profile_pic']) ? '/avatar.png' : '/' . $pg['profile_pic'];
                                    ?>
                                        <div class="card">
                                            <div class="head">
                                                <div class="circle"></div>
                                                <div class="img">
                                                    <img src="<?= $img ?>" alt="">
                                                </div>
                                            </div>

                                            <div class="description">
                                                <h3><?= $pg['nombre'] ?></h3>
                                                <p>Tipo de registro</p>
                                                <h2><?= $pg['oyente'] == 1 ? 'Oyente' : 'Ponente' ?></h2>
                                                <h3>Clave de gafete</h3>
                                                <h2><?= $pg['clave_gafete'] ?></h2>
                                            </div>

                                            <div class="contact">
                                                <a href="https://vive.redesla.la/congresos/?clave=<?= $pg['clave_gafete'] ?>" target="_blank">Ir a VIVE REDESLA</a>
                                            </div>
                                        </div>
                                    <?php

                                    }

                                    ?>
                                </div>
                                <p class="text-center">
                                    <small>Los participantes han aceptado las siguientes condiciones:<br>
                                    Sus datos registrados son correctos y no requieren ninguna modificación. <br>
                                    Que para poder acceder a la Constancia de Asistencia del Congreso, es indispensable que participe en las ponencias de sus colegas y las evalúe. Debe tener en cuenta que podrá recibirlo evaluando por lo menos una ponencia y el diploma incluirá su porcentaje de participación. La Constancia de Ponencia sólo podrá recibirla al haber presentado su ponencia en el día, lugar y modalidad asignada.
                                    </small>
                                </p>
                                <hr>
                                <h3 class="text-center">Comentarios de su ponencia</h3>
                                <?php
                                if (empty($p['comentarios'])) {
                                    echo '<p class="text-center">Sin comentarios adjuntos</p>';
                                } else {
                                ?>
                                    <table class="table table-striped" style="width: 100%;" id='example'>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Comentario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($p['comentarios'] as $keyCO => $co) {
                                            ?>
                                                <tr>
                                                    <td><?= $co['id'] ?></td>
                                                    <td><?= $co['comentario'] ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php
                                }
                                ?>
                            <?php
                            }
                            ?>
                        <?php
                        }

                        if ($ponencias_disponibles >= 1) {
                        ?>
                            <h2 class="text-center text-uppercase">Registro de ponencia</h2>
                            <p>Instrucciones: Ingrese dentro del campo la contraseña de su ponencia, dé clic en buscar y siga las instrucciones. La contraseña se encuentra en el asunto y correo electrónico que le fue enviado con su <b>CARTA DE ACEPTACIÓN</b>.</p>

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 text-center">
                                    <object id="obj_svg" data="<?= base_url('resources/img/svg/formulario.svg') ?>" type="image/svg+xml"></object>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-8">
                                    <form action="<?= base_url("eventos/ponencia") ?>" method="POST" class="needs-validation" novalidate id="form_password">
                                        <div class="form-group">
                                            <label for="">Ingrese la contraseña de su ponencia</label>
                                            <input type="text" name="nombre_congreso" id="nombre_congreso" value="<?= $nombre_congreso ?>" hidden>
                                            <input type="text" class="form-control" name="iquatro" id="iquatro" placeholder="Contraseña de ponencia" required><br>
                                        </div>
                                        <button type="button" class="btn btn-block bg-<?= $_SESSION['red'] ?> cp">Buscar</button>
                                        <button type="button" class="btn btn-block btn-success sp">Participar sin ponencia, ser sólo asistentes</button>
                                    </form>
                                </div>
                            </div>
                <?php
                        }
                    }
                }
                ?>
            </div>

        </div>

    </div>

</div>



<div class="modal fade" id="condiciones" tabindex="-1" role="dialog" aria-labelledby="condiciones" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="condiciones">Condiciones</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <p>Estimado(a) participante, los presentes datos fueron leídos desde la plataforma de envío Libros

                    IQuatro Editores, escriba los datos que desea corregir tal y como desea que aparezcan, para los

                    coautores debe proporcionar la siguiente información, de acuerdo al orden de la publicación: <br>

                    nombre completo, institución de afiliación, número de contacto, correo electrónico, y si cuenta con

                    ORCID puede proporcionar el mismo (este último no es obligatorio).</p>



                <p>Quedamos a sus órdenes.</p>



                <p>En caso de tener problemas para solicitar dicha solicitud, puede enviar un mensaje de whatsApp al

                    número: 4271067882, con la solicitud del correo.</p>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>

            </div>

        </div>

    </div>

</div>

<script src="<?= base_url('resources/js/form-validation/index.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url("resources/js/congreso.js") ?>"></script>

<script>
    function buscarPonencia() {

        $('#form-ponencia').submit();

    }

    let claveCuerpo = '<?= $_SESSION['CA'] ?>'
    let anio = '<?= $anio_congreso ?>'
    let nombre_congreso = '<?= $nombre_congreso ?>';

    let htmlTipoAsistencia = `
    <div class="container">
                    <div class="grid-container">
                        <div class="grid-item">
                            <label for="radio-card-1" class="radio-card">
                                <input type="radio" name="tipo_asistencia" id="radio-card-1" value="presencial" required />
                                <div class="card-content-wrapper">
                                    <span class="check-icon"></span>
                                    <div class="card-content">
                                        <img src="<?= base_url('resources/img/svg/undraw_conference_re_2yld.svg') ?>" alt="" />
                                        <h4>Presencial</h4>
                                        <h5>Realizada en la institución anfitriona de este año</h5>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="grid-item">
                            <label for="radio-card-2" class="radio-card">
                                <input type="radio" name="tipo_asistencia" id="radio-card-2" value="virtual" required />
                                <div class="card-content-wrapper">
                                    <span class="check-icon"></span>
                                    <div class="card-content">
                                        <img src="<?= base_url('resources/img/svg/undraw_video_call_re_4p26.svg') ?>" alt="" />
                                        <h4>Virtual</h4>
                                        <h5>Realizada mediante nuestro espacio virtual <b>VIVE REDESLA</b></h5>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- /.radio-card -->
                    </div>
                    <!-- /.grid-wrapper -->
                </div>
    `;

    $(document).on('click', '.cp', function() {
        $("#form_password").submit();
    })

    $(document).on('click', '.sp', function() {
        Swal.fire({
            icon: 'question',
            title: '¿Están seguros de registrarse sin ponencia?',
            text: 'Al aceptar este registro su categoría será sólo de asistente y no podrán presentar ponencia ni obtener constancias de ponente.',
            html: htmlTipoAsistencia,
            footer: '<label class="text-danger text-center">Una vez aceptado el registro, NO PODRÁ HACER CAMBIOS DE CATEGORÍA</label>',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, estoy seguro',
            cancelButtonColor: '#cc0000',
            customClass: {
                confirmButton: 'bg-' + red,
            },
            customClass: 'max-width-sweet'
        }).then((result) => {
            if (result.isConfirmed) {
                let tipo_asistencia = $("input[name='tipo_asistencia']:checked").val()

                if (tipo_asistencia === undefined) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cuidado',
                        text: 'Seleccione su tipo de asistencia'
                    })
                    return;
                }
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: '../../eventos/soloAsistentes',
                    data: {
                        claveCuerpo: claveCuerpo,
                        anio_congreso: anio,
                        red: red,
                        tipo_asistencia: tipo_asistencia,
                        nombre_congreso: nombre_congreso
                    },
                    success: function(res) {
                        console.log(res.codigo);
                        if (res.codigo == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: res.title,
                                html: res.mensaje
                            }).then(function() {
                                location.reload()
                            })
                        }
                    },
                    error: function(jqXHR) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error ' + jqXHR.status,
                            html: jqXHR.responseText
                        })
                    }
                })
            }
        })
    })
</script>

<script>
    /* $(document).ready(function() {

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))

        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {

            return new bootstrap.Tooltip(tooltipTriggerEl)

        })

    })



    var exampleEl = document.getElementById('popInvestigacion')

    var popover = new bootstrap.Popover(exampleEl, {

        html: true,

        trigger: 'hover',

        content: function() {

            return '<img src="' + $(this).data('img') + '" width="500" />';

        }

    }) */
</script>