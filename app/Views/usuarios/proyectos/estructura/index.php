<!-- VAMOS A IR ORDENANDO POR FASES -->
<?php
if ($fase['f_impreso'] == 1 || $fase['f_digital'] == 1) {
    if ($fase['r_impreso'] == 1 || $fase['r_digital'] == 1) {
        //Las entrevistas estan en revision
?>
        <div class="alert alert-success" role="alert">
            La fase de captura de encuestas ha sido enviada a revisión. Favor de estar pendientes de sus correos para mas detalles.
        </div>
        <div class="row">
            <a href="../getExcel/<?= $anio ?>" class="btn btn-success btn-sm btn-rounded btn-block">Descargar todas las encuestas en Excel <i class="fa-solid fa-table"></i></a>
        </div>
    <?php
        return;
    }
    ?>
    <script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
    <link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />

    <script src="https://jsuites.net/v4/jsuites.js"></script>
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />

    <?php
    if ($fase['r_impreso'] == 2 || $fase['r_digital'] == 2) {
    ?>
        <div class="alert alert-danger" role="alert">
            La fase de validación de encuestas ha sido devuelta, favor revisar el correo enviado a sus accesos.
        </div>
    <?php
    }
    ?>
    <p>
        Para cuando proporcionen la asignación y materiales de aplicación de instrumentos a sus alumnos (encuestadores), les sugerimos envíen mensaje parecido a este,
        sea por correo electrónico, Moodle, WhatsApp o el medio que ustedes prefieran:
    </p>
    <div class="clipboard">
        <div id="txt_clipboard">
            Estimados encuestadores:
            Gracias por formar parte de esta investigación, su labor es de suma importancia para la Investigación Científica, les compartimos el enlace para que realicen la
            captura de las encuestas una vez aplicado al directivo: <?= base_url("/encuestas/{$anio}/{$claveCuerpo}/{$password}") ?>

            Una vez capturada la encuesta podrán consultar el folio en: <?= base_url("encuestas/lista/{$claveCuerpo}/{$anio}/{$password}") ?>

            ¡Ustedes forman parte de una gran investigación!

        </div>
        <i class="fas fa-clone btnClipboard" id="iconClip" title="Copiar"></i>
    </div>
    <h1 class="n_<?= session('red') ?>">Archivos comúnes</h1>
    <iframe src="https://drive.google.com/embeddedfolderview?id=1mCHpHh41IjtXTC4eqMZANBjodkqpLKsY#grid" style="width:100%; height:300px; border:0;background-color:lightgray;"></iframe>
    <h1 class="n_<?= session('red') ?>">Enlaces</h1>
    <ul>
        <li>Carpeta general:</li>
        <li>Video de habilitación de investigación / capacitación a investigadores:</li>
        <li>Video reunión extraordinaria:</li>
        <li>Capacitación encuestadores:</li>
        <li>Capacitación investigadores:</li>
        <li>Enlace para registrar sus encuestas: <a target="_blank" href="<?= base_url("/encuestas/{$anio}/{$claveCuerpo}/{$password}") ?>"><?= base_url("/encuestas/{$anio}/{$claveCuerpo}/{$password}") ?></a></li>
        <li>Enlace para que sus alumnos vean el listado de las encuestas capturadas: <a target="_blank" href="<?= base_url("encuestas/lista/{$claveCuerpo}/{$anio}/{$password}") ?>"><?= base_url("encuestas/lista/{$claveCuerpo}/{$anio}/{$password}") ?></a></li>
    </ul>

    <h1 class="n_<?= session('red') ?>">Resumen general</h1>
    <p>Si realizo cambio de validación en sus encuestas recientemente, actualice la página para visualizar correctamente su <b>Resumen</b>, <b>Desglose</b> y <b>Porcentaje</b></p>
    
    <div class="desgloseInv">
    <div class="row">
        <div class="col-sm-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Encuestas pendientes de revisión</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $investigacion['entrevistas_pendientes'] ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg fas fa-exclamation-triangle text-warning ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Encuestas revisadas</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $investigacion['entrevistas_completadas'] ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg fas fa-check-circle text-success ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h3>Desglose</h3>
    <div class="row">
        <div class="col-sm-3 grid-margin" data-toggle='tooltip' title="Encuesta solo registrada. Faltan realizar acciones.">
            <div class="card">
                <div class="card-body">
                    <h5>Encuestas sin revisión</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $investigacion['entrevistas_pendientes'] ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg fas fa-info-circle ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 grid-margin" data-toggle='tooltip' title="Las encuestas son válidas y deben ser consideradas.">
            <div class="card">
                <div class="card-body">
                    <h5>Encuestas a considerar</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $investigacion['estado_1'] ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg fas fa-check-circle verde ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 grid-margin" data-toggle='tooltip' title="Las encuestas tienen mas de 20 ítems erroneos.">
            <div class="card">
                <div class="card-body">
                    <h5>Incompletos</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $investigacion['estado_2'] ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg fas fa-times-circle text-danger ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 grid-margin" data-toggle='tooltip' title="Encuestas no válidas.">
            <div class="card">
                <div class="card-body">
                    <h5>No válidos</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $investigacion['estado_3'] ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg fas fa-ban text-danger ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-6 grid-margin" data-toggle='tooltip' title="Encuestas que se volvieron a capturar.">
            <div class="card">
                <div class="card-body">
                    <h5>Recapturados</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $investigacion['estado_4'] ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg fas fa-recycle text-warning ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 grid-margin" data-toggle='tooltip' title="Encuestas de prueba.">
            <div class="card">
                <div class="card-body">
                    <h5>Pruebas</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $investigacion['estado_5'] ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg fas fa-vial text-info ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="p-2">
        <h2 class="text-center">Porcentaje de avance con respecto a las encuestas registradas</h2>
        <div class="progress">
            <div class="progress-bar <?= $investigacion['pocentaje_completado'] == 100 ? 'bg-success' : 'bg-warning'; ?>" role="progressbar" style="width: <?= $investigacion['pocentaje_completado'] ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p class="text-center">
            <?= $investigacion['pocentaje_completado'] == 100 ? 'Todas las encuestas revisadas' : $investigacion['pocentaje_completado'] . '% completado'; ?>
        </p>
        <input type="hidden" id="nombre_investigacion" value="cuestionarios_<?= strtolower($red) ?>_<?= $anio ?>">
    </div>

    <div class="col-lg-12 table-responsive">
        <h1 class="n_<?= session('red') ?>">Lista de encuestas</h1>
        <p>Instrucciones:</p>
        <p>
            Aqui podra ver el listado de todas sus encuestas capturadas. Favor de completar cada una de las encuestas con un estatus. Si desea cambiar el estatus de una encuesta, posicione el <u>mouse</u>
            sobre la columa de <b>Validación</b> en la tabla y de clic. Se desglosara un menú en donde podra cambiar la validación del cuestionario seleccionado.
        </p>
        <p>
            Si esta usando un dispositivo móvil y no ve las demas columas de la tabla, pulse sobre el fólio del cuestionario y se le desglozará las columnas restantes. El proceso de cambio de estado es el mismo.
        </p>
        <div class="alert alert-warning" role="alert">
            IMPORTANTE: Antes de iniciar con el levantamiento de sus encuestas es OBLIGATORIO realizar 1 captura de prueba y registrar su estado
            de validación para comprobar que sus datos de la zona de estudio son correctos, se registran en plataforma y el sistema de
            validación funciona correctamente. Si presentan o detecta algún error por favor enviar capturas de pantalla a los correos:
            <a href="mailto.atencion@redesla.la">atencion@redesla.la</a>, <a href="mailto:jaramosp@red.redesla.la">jaramosp@red.redesla.la</a> o 
            <a href="mailto:svchavez@redesla.la">svchavez@redesla.la</a>
        </div>

        <a href="../getExcel/<?= $anio ?>" class="btn btn-success btn-sm btn-rounded allEncuestas">Descargar todas las encuestas en Excel <i class="fa-solid fa-table"></i></a>
        <table class="display nowrap table table-bordered" id="dt_investigacion" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th class="centered">Folio</th>
                    <th class="centered">Nombre del encuestador</th>
                    <th class="centered">Validación</th>
                    <th class="centered">Ver encuesta</th>
                </tr>
            </thead>
            <tbody id="tbody_investigacion">

            </tbody>
        </table>

        <div class="row pt2">
            <h3 class="text-center">Una vez concluido el proceso de captura y validación de sus encuestas envíe a revisión con el Equipo RedesLA, dé clic en el siguiente botón.</h3>
            <button type="button" class="btn btn-info btn-sm btn-block btn-rounded revision">Cerrar captura y enviar a revisión de validación de encuestas <i class="fa-solid fa-paper-plane"></i></button>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModal">Cambiar validación de la encuesta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" name="form" method="post">
                        <div id="folioModal"></div>
                        <label for="">Selecciona la nueva validación</label>
                        <select name="" id="selectStatus" class="form-control">
                            <option value="" selected disabled>Selecciona una opción</option>
                            <option value="1">La encuesta es válida y debe ser considerada</option>
                            <option value="2">La encuesta tiene más de 20 ítem erróneos o vacíos (incompleto)</option>
                            <option value="3">La encuesta no es válida</option>
                            <option value="4">La encuesta se volvió a capturar y será sustituido por otro folio válido</option>
                            <option value="5">La encuesta es de prueba y no será sustituido por otro folio</option>
                        </select>
                        <input type="text" name="id_cuestionario" id="id_cuestionario" hidden>
                        <hr>
                        <button type="submit" id="btnActCuest" class="btn btn-block btn-warning">Actualizar encuesta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modalExcel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalExcel">Visualización de encuesta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="spreadsheet" style="overflow-x: auto;"></div>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>
<link rel="stylesheet" href="<?= base_url('resources/css/investigaciones/miembros.css') ?>">


<?php
if($fase['f_impreso'] >= 2 || $fase['f_digital'] >= 2){
    ?>
    <div style="margin-bottom: 1rem;margin-top: 1rem;">
    <h2 class="n_<?= session('red') ?>">Bases de datos</h2>
    <a href="../getExcel/<?= $anio ?>" class="btn btn-success btn-sm btn-rounded sendLogo">Descargar todas las encuestas de su equipo en Excel <i class="fa-solid fa-table"></i></a>
</div>

<h2 class="n_<?= session('red') ?>">Archivos enviados</h2>
<table class="display nowrap" id="tableArchivos" style="width:100%">
    <thead>
        <tr>
            <th>Expandir</th>
            <th class="centered">Nombre del archivo</th>
            <th class="centered">Ultima modificación</th>
            <th class="centered">Fecha de registro</th>
            <th class="centered">Validado</th>
            <th class="centered">Archivo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($archivos as $a) {
            $timestamp = strtotime($a['fecha_update']);
            $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM);
            $fechaFormateadaUpdate = $formatter->format($timestamp);
            $timestampInsert = strtotime($a['fecha_insert']);
            $fechaFormateadaInsert = $formatter->format($timestampInsert);
        ?>
            <tr>
                <td></td>
                <td><span><?= $a['nombre_usuarios'] ?> <?= !empty($a['tipo']) ? ' - '.$a['tipo']:'' ?></span></td>
                <td>
                    <?php
                    if ($a['usuario'] == 'admin') {
                    ?>
                        Administración
                    <?php
                    } else {
                    ?>
                        <img src="<?= base_url('resources/img/profiles/' . $a['profile_pic']) ?>" alt="" class="profile_icon">&nbsp <?= $a['nombre_usuario'] ?> - <?= $fechaFormateadaUpdate ?>
                    <?php
                    }
                    ?>

                </td>
                <td><?= $fechaFormateadaInsert ?></td>
                <td>
                    <?php
                    if($a['nombre'] != 'marcaje'){
                        if ($a['fecha_validate'] == '0000-00-00 00:00:00') {
                            ?>
                                <span><i class="fa-solid fa-triangle-exclamation text-warning"></i> Sin validación</span>
                            <?php
                            } else if($a['validado'] == 0){
                                ?>
                                <span title="Rechazado el <?= $a['fecha_validate'] ?>"><i class="fa-solid fa-circle-exclamation text-danger"></i> Rechazado</span>
                                <?php
                            }else if($a['validado'] == 2){
                                ?>
                                <span title="Reenviado el <?= $a['fecha_update'] ?>"><i class="fa-solid fa-repeat text-warning"></i> Reenviado</span>
                                <?php
                            }else{
                            ?>
                                <span title="Validado el <?= $a['fecha_validate'] ?>"><i class="fa-solid fa-circle-check text-success"></i> Validado</span>
                            <?php
                            }
                    }else if($a['nombre'] == 'marcaje'){
                        if($a['atendido'] == 0){
                            ?>
                            <span><i class="fa-solid fa-triangle-exclamation text-warning"></i> Enviado a revisión a la editorial</span>
                            <?php
                        }else if($a['atendido'] == 1){
                            ?>
                            <span><i class="fa-solid fa-circle-check text-success"></i> Atendido por la editorial</span>
                            <?php
                        }else if($a['atendido'] == 2){
                            ?>
                            <span><i class="fa-solid fa-times-circle text-danger"></i> Rechazado por la editorial</span>
                            <?php
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($a['usuario'] == 'admin' && $a['tipo_archivo'] != 'application/pdf') {
                    ?>
                        <i class="fa-solid fa-download verArchivo" data-nombre="<?= $a['nombre'] ?>" data-obra="<?= $a['tipo'] ?>" style="cursor:pointer"></i>
                    <?php
                    } else {
                    ?>
                        <i class="fa-solid fa-eye verArchivo" data-nombre="<?= $a['nombre'] ?>" data-obra="<?= $a['tipo'] ?>" style="cursor:pointer"></i>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
    <?php
}
?>



<hr>
<?php

if ($fase['f_impreso'] == 2 || $fase['f_digital'] == 2) {
    if ($fase['r_impreso'] == 1 || $fase['r_digital'] == 1) {
?>
        <div class="alert alert-success" role="alert">
            La fase de subir el logotipo de su institución esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
        </div>
    <?php
        return;
    }
    ?>
    <?php
    if ($fase['r_impreso'] == 2 || $fase['r_digital'] == 2) {
    ?>
        <div class="alert alert-danger" role="alert">
            La fase de subir logotipo de su institución sido devuelta, favor revisar el correo enviado a sus accesos.
        </div>
    <?php
    }
    ?>
    <h2 class="n_<?= session('red') ?>">Subir logotipo de la institución</h2>
    Instrucciones: Seleccione la imagen de la institución de afiliación para los agradecimientos de las obras registradas de acuerdo con el esquema <b class="n_<?= $red ?>"><?= $esquema ?></b> de la <b class="n_<?= $red ?>">Investigación <?= strtoupper($red) . ' ' . $anio ?></b>. Si su institución está colaborando con otra, deberá unir los dos logos en una sola imagen y subirla. La imagen debe ser en blanco y negro. Una vez que la haya cargado dé clic en el botón "Mandar logotipo de la institución a revisión" para concluir el envío.

    <div class="content-file">
        <input type="file" id="file" accept="image/png" hidden>
        Previsualización:
        <div class="img-area active" data-img="">
            <i class="fa-solid fa-upload icon"></i>
            <h3>Subir imagen</h3>
            <p>El tamaño de la imagen debe ser menor a <span>2MB</span></p>
        </div>
        <button class="select-image">Seleccionar imagen</button>
    </div>
    <div>
        <button type="button" class="btn btn-block btn-success btn-md btn-rounded send logo">Mandar logotipo de institución a revisión</button>
    </div>
<?php
}

if ($fase['f_impreso'] == 3 || $fase['f_digital'] == 3) {
?>
    <h2 class="n_<?= session('red') ?>">Orden de autores</h2>
    Instrucciones: En este apartado se debe establecer el orden correcto de los(as) autores(as) de su capítulo, de acuerdo con su esquema de participación en las obras <?= strtoupper($red) ?> <?= $anio ?>. Deberá dar clic y mantener el cursor sobre el nombre del autor que desea mover de posición, podrá desplazarlos hacia arriba y abajo para colocarlos en la posición correcta. Una vez que los autores estén en el orden deseado, es INDISPENSABLE dar clic sobre el botón <a class="text-success" href="#btnOrdenAutores">Registrar orden de autores</a> para que se refleje el cambio en el sistema.

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
    
    <div class="paddingOrdenAutores">
    <?php
    if ($esquema == 'A') {
    ?>
        <div class="paddingOrdenAutores">
            <div class="fase_3">
                <h3>Orden de la obra digital</h3>
                <input name='inputAutoresDigital' value='' class="form-control">
            </div>
        </div>
    <?php
    } else if ($esquema == 'B') {
    ?>
        
        <div class="fase_3">
            <h3>Orden de la obra impresa</h3>
            <input name='inputAutoresImpreso' value='' class="form-control">
        </div>
        <div class="fase_3">
            <h3>Orden de la obra digital</h3>
            <input name='inputAutoresDigital' value='' class="form-control">
        </div>
    <?php
    }
    ?>
    </div>
    <div class="paddingOrdenAutores">
        <button type="button" class="btn btn-block btn-success btn-md btn-rounded ordenAutores" id="btnOrdenAutores">Registrar orden de autores</button>
    </div>
    <script>
        var fase = 3;
    </script>

<?php
}

if ($fase['f_impreso'] == 4) {
    //Ya aqui se divide
    if($fase['r_impreso'] == 1){
        ?>
        <div>
        <div class="alert alert-warning" role="alert">
            La fase de redacción de resumen de obra impresa esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
        </div
        </div>
        <?php
    }else{
        ?>
        <div>
            <h2 class="n_<?= session('red') ?>">Redacción de resumen de obra impresa</h2>
            Instrucciones: Dentro de la siguiente fase se redactará la discusión para su obra impresa. Esta debe constar de 70 a 100 palabras y debe ser en base a su capítulo preliminar impreso ubicado en el apartado de archivos. Al finalizar, de clíc en el boton <a href="#btnResumenImpreso" class="text-success">Mandar resumen de obra impresa a revisión</a>.
        
            <textarea id="resumenImpreso" rows="6" cols="50" class="form-control" placeholder="Escribe el resumen de su obra impresa"></textarea>
            <p>Contador de palabras: <span id="wordCountResumenImpreso">0</span></p>
        
            <button class="btn btn-success btn-md btn-block btnResumenImpreso" id="btnResumenImpreso">Mandar resumen de obra impresa a revisión</button>
        </div>
        <?php
    }
    
}

if ($fase['f_digital'] == 4) {
    //Ya aqui se divide
    if($fase['r_digital'] == 1){
        ?>
        <div>
            <div class="alert alert-warning" role="alert">
                La fase de redacción de resumen de obra digital esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <?php
    }else{
        ?>
        <div>
            <h2 class="n_<?= session('red') ?>">Redacción de resumen de obra digital</h2>
            Instrucciones: Dentro de la siguiente fase se redactará la discusión para su obra digital. Esta debe constar de 70 a 100 palabras y debe ser en base a su capítulo preliminar digital ubicado en el apartado de archivos. Al finalizar, de clíc en el boton <a href="#resumenDigital" class="text-success">Mandar resumen de obra digital a revisión</a>.
            
            <textarea id="resumenDigital" rows="6" cols="50" class="form-control" placeholder="Escribe el resumen de su obra digital"></textarea>
            <p>Contador de palabras: <span id="wordCountResumenDigital">0</span></p>

            <button class="btn btn-success btn-md btn-block btnResumenDigital" id="resumenDigital">Mandar resumen de obra digital a revisión</button>
        </div>
        <?php
    }
}

if ($fase['f_impreso'] == 5) {
    //Ya aqui se divide
    if($fase['r_impreso'] == 1){
        ?>
        <div>
            <div class="alert alert-warning" role="alert">
                La fase de palabras clave de obra impresa esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <?php
    }else{
        ?>
        <div class="fase_5">
            <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
            <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
            <h2 class="n_<?= session('red') ?>">Palabras clave de obra impresa</h2>
            Instrucciones: Dentro de este modulo se delimitarán de 3 a 5 palabras clave, en el idioma español, para su <b class="n_<?= $red ?>">obra impresa</b>. Para agregarlas, escriba en el campo de abajo la(s) palabra(s) clave de manera individual, presionando el botón <b class="n_<?= $red ?>">"enter"</b> para introducir cada palabra. Deberá dar clic en <a class="text-success" href="#btnPalabrasImpreso" >Registrar palabras clave de la obra impresa</a> para registrarlas en la plataforma.
            
            <div class="keyWords">
                <input name="tagsImpreso" placeholder="Ingrese la palabra clave" class="form-control">
                <button type="button" class="btn btn-md btn-block btn-success btnKeyImpreso" id="btnPalabrasImpreso">Registrar palabras clave de la obra impresa</button>
            </div>
        </div>
        <?php
    }
    
}

if ($fase['f_digital'] == 5) {
    //Ya aqui se divide
    if($fase['r_digital'] == 1){
        ?>
        <div>
            <div class="alert alert-warning" role="alert">
                La fase de palabras clave de obra digital esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <?php
    }else{
        ?>
        <div class="fase_5">
            <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
            <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
            <h2 class="n_<?= session('red') ?>">Palabras clave de obra digital</h2>
            Instrucciones: Dentro de este modulo se delimitarán de 3 a 5 palabras clave, en el idioma español, para su <b class="n_<?= $red ?>">obra digital</b>. Para agregarlas, escriba en el campo de abajo la(s) palabra(s) clave de manera individual, presionando el botón <b class="n_<?= $red ?>">"enter"</b> para introducir cada palabra. Deberá dar clic en <a class="text-success" href="#btnPalabrasDigital">Registrar palabras clave de la obra digital</a> para registrarlas en la plataforma.
            
            <div class="keyWords">
                <input name="tagsDigital" placeholder="Ingrese la palabra clave" class="form-control">
                <button type="button" class="btn btn-md btn-block btn-success btnKeyDigital" id="btnPalabrasDigital">Registrar palabras clave de la obra digital</button>
            </div>
        </div>
        <?php
    }
    
}

if ($fase['f_impreso'] == 6) {
    //Ya aqui se divide
    if($fase['r_impreso'] == 1){
        ?>
        <div>
        <div class="alert alert-warning" role="alert">
            La fase de redacción de discusión de obra impresa esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
        </div
        </div>
        <?php
    }else{
        ?>
        <div>
            <h2 class="n_<?= session('red') ?>">Redacción de discusión de obra impresa</h2>
            Instrucciones: Dentro de la siguiente fase se redactará la discusión para su obra impresa. Esta debe constar de 250 a 500 palabras y debe ser en base a su capítulo preliminar impreso ubicado en el apartado de archivos. Al finalizar, de clíc en el boton <a class="text-success" href="#btnDiscusionImpreso">Mandar discusión de obra impresa a revisión</a>.
        
            <textarea id="discusionImpreso" rows="6" cols="50" class="form-control" placeholder="Escribe la discusión de su obra impresa"></textarea>
            <p>Contador de palabras: <span id="wordCountDiscusionImpreso">0</span></p>
        
            <button class="btn btn-success btn-md btn-block btnDiscusionImpreso" id="btnDiscusionImpreso">Mandar resumen de obra impresa a revisión</button>
        </div>
        <?php
    }
}

if ($fase['f_digital'] == 6) {
    //Ya aqui se divide
    if($fase['r_digital'] == 1){
        ?>
        <div>
        <div class="alert alert-warning" role="alert">
            La fase de redacción de discusión de obra digital esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
        </div
        </div>
        <?php
    }else{
        ?>
        <div>
            <h2 class="n_<?= session('red') ?>">Redacción de discusión de obra digital</h2>
            Instrucciones: Dentro de la siguiente fase se redactará la discusión para su obra digital. Esta debe constar de 250 a 500 palabras y debe ser en base a su capítulo preliminar digital ubicado en el apartado de archivos. Al finalizar, de clíc en el boton <a class="text-success" href="#btnDiscusionDigital">Mandar discusión de obra digital a revisión</a>.
        
            <textarea id="discusionDigital" rows="6" cols="50" class="form-control" placeholder="Escribe la discusión de su obra digital"></textarea>
            <p>Contador de palabras: <span id="wordCountDiscusionDigital">0</span></p>
        
            <button class="btn btn-success btn-md btn-block btnDiscusionDigital" id="btnDiscusionDigital">Mandar resumen de obra digital a revisión</button>
        </div>
        <?php
    }
}

if ($fase['f_impreso'] == 7) {
    //Ya aqui se divide
    if($fase['r_impreso'] == 1){
        ?>
        <div>
            <div class="alert alert-warning" role="alert">
                La fase de la carta de cesión de derechos de la obra impresa esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <?php
    }else if($fase['r_impreso'] == 2){
        //RECHAZADO  QUE LO VUELVAN A HACER
        ?>
        <div>
            <div class="alert alert-danger" role="alert">
                La fase de la carta de cesión de derechos de la obra impresa ha sido rechazada. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <div class="marginTopBottom">
            <h2 class="n_<?= session('red') ?>">Carta de cesión de derechos de la obra impresa</h2>
            <p>Instrucciones: A continuación deberán realizar el llenado y envío de su carta de cesión de derechos correspondiente a la obra impresa <?= strtoupper($red) ?> <?= $anio ?>. Descargue el molde de la carta, dando clic en el archivo que se encuentra abajo de estas instrucciones o haga clic aquí. Después deberá completar los campos subrayados en color amarillo (El nombre y número de capitulo lo encontrara en el archivo de su capitulo preliminar de la obra impresa), además, se solicitan firmas y deberán anexar, en una sola cuartilla, las identificaciones oficiales de los autores. El documento debe estar en formato PDF y no exceder las dos cuartillas con un peso máximo de 5MB. Cuando el documento esté completo con los datos solicitados, deberá cargarlos en la sección de abajo "Cargar carta de cesión de derechos de obra impresa" y dar clic en <a href="#cesionImpreso" class="text-success">Enviar carta de cesión de derechos a revisión (obra impresa)</a>.</p>

            <a href="../generar/carta/derechos/<?= $anio ?>/impreso" class="btn btn-md btn-info">Descargar molde de carta de cesión de derechos (obra impresa) <i class="fa-solid fa-cloud-arrow-down"></i></a>
        </div>
        <div class="marginTopBottom">
            <h4>Cargar carta de cesión de derechos de obra impresa</h4>
            <input type="file" name="cartaDerechosImpreso" id="cartaDerechosImpreso" class="form-control" required accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <button type="button" class="btn btn-md btn-block btn-success btnCartaDerechosImpreso" id="cesionImpreso">Enviar carta de cesión de derechos a revisión (obra impresa)</button>
        </div>
        <?php
    }else{
        ?>
        <div class="marginTopBottom">
            <h2 class="n_<?= session('red') ?>">Carta de cesión de derechos de la obra impresa</h2>
            <p>Instrucciones: A continuación deberán realizar el llenado y envío de su carta de cesión de derechos correspondiente a la obra impresa <?= strtoupper($red) ?> <?= $anio ?>. Descargue el molde de la carta, dando clic en el archivo que se encuentra abajo de estas instrucciones o haga clic aquí. Después deberá completar los campos subrayados en color amarillo (El nombre y número de capitulo lo encontrara en el archivo de su capitulo preliminar de la obra impresa), además, se solicitan firmas y deberán anexar, en una sola cuartilla, las identificaciones oficiales de los autores. El documento debe estar en formato PDF y no exceder las dos cuartillas con un peso máximo de 5MB. Cuando el documento esté completo con los datos solicitados, deberá cargarlos en la sección de abajo "Cargar carta de cesión de derechos de obra impresa" y dar clic en <a href="#cesionImpreso" class="text-success">Enviar carta de cesión de derechos a revisión (obra impresa)</a>.</p>

            <a href="../generar/carta/derechos/<?= $anio ?>/impreso" class="btn btn-md btn-info">Descargar molde de carta de cesión de derechos (obra impresa) <i class="fa-solid fa-cloud-arrow-down"></i></a>
        </div>
        <div class="marginTopBottom">
            <h4>Cargar carta de cesión de derechos de obra impresa</h4>
            <input type="file" name="cartaDerechosImpreso" id="cartaDerechosImpreso" class="form-control" required accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <button type="button" class="btn btn-md btn-block btn-success btnCartaDerechosImpreso" id="cesionImpreso">Enviar carta de cesión de derechos a revisión (obra impresa)</button>
        </div>
        <?php
    }
}

if ($fase['f_digital'] == 7) {
    //Ya aqui se divide
    if($fase['r_digital'] == 1){
        ?>
        <div>
            <div class="alert alert-warning" role="alert">
                La fase de la carta de cesión de derechos de la obra digital esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <?php
        return;
    }else if($fase['r_digital'] == 2){
        //RECHAZADO  QUE LO VUELVAN A HACER
        ?>
        <div>
            <div class="alert alert-danger" role="alert">
                La fase de la carta de cesión de derechos de la obra digital ha sido rechazada. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <div class="marginTopBottom">
            <h2 class="n_<?= session('red') ?>">Carta de cesión de derechos de la obra digital</h2>
            <p>Instrucciones: A continuación deberán realizar el llenado y envío de su carta de cesión de derechos correspondiente a la obra digital <?= strtoupper($red) ?> <?= $anio ?>. Descargue el molde de la carta, dando clic en el archivo que se encuentra abajo de estas instrucciones o haga clic aquí. Después deberá completar los campos subrayados en color amarillo (El nombre y número de capitulo lo encontrara en el archivo de su capitulo preliminar de la obra digital), además, se solicitan firmas y deberán anexar, en una sola cuartilla, las identificaciones oficiales de los autores. El documento debe estar en formato PDF y no exceder las dos cuartillas con un peso máximo de 5MB. Cuando el documento esté completo con los datos solicitados, deberá cargarlos en la sección de abajo "Cargar carta de cesión de derechos de obra digital" y dar clic en <a href="#cesionDigital" class="text-success">Enviar carta de cesión de derechos a revisión (obra digital)</a>.</p>
            <a href="../generar/carta/derechos/<?= $anio ?>/digital" class="btn btn-md btn-info">Descargar molde de carta de cesión de derechos (obra digital) <i class="fa-solid fa-cloud-arrow-down"></i></a>
        </div>
        <div class="marginTopBottom">
            <h4>Cargar carta de cesión de derechos de obra digital</h4>
            <input type="file" name="cartaDerechosDigital" id="cartaDerechosDigital" class="form-control" required accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <button type="button" class="btn btn-md btn-block btn-success btnCartaDerechosDigital" id="cesionDigital">Enviar carta de cesión de derechos a revisión (obra digital)</button>
        </div>
        <?php
    }else{
        ?>
        <div class="marginTopBottom">
            <h2 class="n_<?= session('red') ?>">Carta de cesión de derechos de la obra digital</h2>
            <p>Instrucciones: A continuación deberán realizar el llenado y envío de su carta de cesión de derechos correspondiente a la obra digital <?= strtoupper($red) ?> <?= $anio ?>. Descargue el molde de la carta, dando clic en el archivo que se encuentra abajo de estas instrucciones o haga clic aquí. Después deberá completar los campos subrayados en color amarillo (El nombre y número de capitulo lo encontrara en el archivo de su capitulo preliminar de la obra digital), además, se solicitan firmas y deberán anexar, en una sola cuartilla, las identificaciones oficiales de los autores. El documento debe estar en formato PDF y no exceder las dos cuartillas con un peso máximo de 5MB. Cuando el documento esté completo con los datos solicitados, deberá cargarlos en la sección de abajo "Cargar carta de cesión de derechos de obra impresa" y dar clic en <a href="#cesionDigital" class="text-success">Enviar carta de cesión de derechos a revisión (obra digital)</a>.</p>

            <a href="../generar/carta/derechos/<?= $anio ?>/digital" class="btn btn-md btn-info">Descargar molde de carta de cesión de derechos (obra digital) <i class="fa-solid fa-cloud-arrow-down"></i></a>
        </div>
        <div class="marginTopBottom">
            <h4>Cargar carta de cesión de derechos de obra digital</h4>
            <input type="file" name="cartaDerechosDigital" id="cartaDerechosDigital" class="form-control" required accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <button type="button" class="btn btn-md btn-block btn-success btnCartaDerechosDigital" id="cesionDigital">Enviar carta de cesión de derechos a revisión (obra digital)</button>
        </div>
        <?php
    }
}

if ($fase['f_impreso'] == 8) {
    //Ya aqui se divide
    if($fase['r_impreso'] == 1){
        ?>
        <div>
            <div class="alert alert-warning" role="alert">
                La fase de la carta de visto bueno de la obra impresa esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <?php
    }else if($fase['r_impreso'] == 2){
        //RECHAZADO  QUE LO VUELVAN A HACER
        ?>
        <div>
            <div class="alert alert-danger" role="alert">
                La fase de la carta de visto bueno de la obra impresa ha sido rechazada. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <div class="marginTopBottom">
            <h2>Carta de visto bueno de la obra impresa</h2>
            <p>Instrucciones: A continuación deberán realizar el llenado y envío de su carta de visto bueno correspondiente a la obra impresa <?= strtoupper($red) ?> <?= $anio ?>. Descargue el molde de la carta, dando clic en el archivo que se encuentra abajo de estas instrucciones o haga clic aquí. Después deberá completar los campos subrayados en color amarillo (El nombre y número de capitulo lo encontrara en el archivo de su capitulo preliminar de la obra impresa), además, se solicitan firmas y deberán anexar, en una sola cuartilla, las identificaciones oficiales de los autores. El documento debe estar en formato PDF y no exceder las dos cuartillas con un peso máximo de 5MB. Cuando el documento esté completo con los datos solicitados, deberá cargarlos en la sección de abajo "Cargar carta de visto bueno de obra impresa" y dar clic en "Enviar carta de visto bueno a revisión (obra impresa)".</p>

            <a href="../generar/carta/visto/<?= $anio ?>/impreso" class="btn btn-md btn-info">Descargar molde de carta de visto bueno (obra impresa)<i class="fa-solid fa-cloud-arrow-down"></i></a>
        </div>
        <div class="marginTopBottom">
            <h4>Cargar carta de visto bueno de obra impresa <label class="text-danger">*</label></h4>
            <input type="file" name="cartaVistoImpreso" id="cartaVistoImpreso" class="form-control" required accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <button type="button" class="btn btn-md btn-block btn-success btnCartaVistoImpreso">Enviar carta de visto bueno a revisión (obra impresa)</button>
        </div>
        <?php
    }else{
        ?>
        <div class="marginTopBottom">
            <h2>Carta de visto bueno de la obra impresa</h2>
            <p>Instrucciones: A continuación deberán realizar el llenado y envío de su carta de visto bueno correspondiente a la obra impresa <?= strtoupper($red) ?> <?= $anio ?>. Descargue el molde de la carta, dando clic en el archivo que se encuentra abajo de estas instrucciones o haga clic aquí. Después deberá completar los campos subrayados en color amarillo (El nombre y número de capitulo lo encontrara en el archivo de su capitulo preliminar de la obra impresa), además, se solicitan firmas y deberán anexar, en una sola cuartilla, las identificaciones oficiales de los autores. El documento debe estar en formato PDF y no exceder las dos cuartillas con un peso máximo de 5MB. Cuando el documento esté completo con los datos solicitados, deberá cargarlos en la sección de abajo "Cargar carta de visto bueno de obra impresa" y dar clic en "Enviar carta de visto bueno a revisión (obra impresa)".</p>
            <p>Si su capitulo final necesita correcciones, favor de hacer comentarios dentro del pdf subrayando el texto a cambiar comentando Dice: y Debe decir: . Una vez hecho todas las correciones, subir el archivo en el apartado de Capitulo final impreso con marcaje. Las solicitudes seran revisadas y atendidas en medida de lo posible. Si existe algun tema de cambios que no se pueda, se le notificara por correo electronico o por via WhatsApp.</p>

            <a href="../generar/carta/visto/<?= $anio ?>/impreso" class="btn btn-md btn-info">Descargar molde de carta de visto bueno (obra impresa) <i class="fa-solid fa-cloud-arrow-down"></i></a>
        </div>
        <div class="marginTopBottom">
            <h4>Cargar carta de visto bueno de obra impresa <label class="text-danger">*</label></h4>
            <input type="file" name="cartaVistoImpreso" id="cartaVistoImpreso" class="form-control" required accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <h4>Capítulo final impreso con marcaje</h4>
            <input type="file" name="marcajeImpreso" id="marcajeImpreso" class="form-control" accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <button type="button" class="btn btn-md btn-block btn-success btnCartaVistoImpreso">Enviar carta de visto bueno a revisión (obra impresa)</button>
        </div>
        <?php
    }
}

if ($fase['f_digital'] == 8) {
    //Ya aqui se divide
    if($fase['r_digital'] == 1){
        ?>
        <div>
            <div class="alert alert-warning" role="alert">
                La fase de la carta de visto bueno de la obra digital esta en revisión. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <?php
        return;
    }else if($fase['r_digital'] == 2){
        //RECHAZADO  QUE LO VUELVAN A HACER
        ?>
        <div>
            <div class="alert alert-danger" role="alert">
                La fase de la carta de visto bueno de la obra digital ha sido rechazada. Favor de estar pendientes de sus correos para mas detalles.
            </div
        </div>
        <div class="marginTopBottom">
            <h2>Carta de visto bueno de la obra digital</h2>
            <p>Instrucciones: A continuación deberán realizar el llenado y envío de su carta de visto bueno correspondiente a la obra digital <?= strtoupper($red) ?> <?= $anio ?>. Descargue el molde de la carta, dando clic en el archivo que se encuentra abajo de estas instrucciones o haga clic aquí. Después deberá completar los campos subrayados en color amarillo (El nombre y número de capitulo lo encontrara en el archivo de su capitulo preliminar de la obra digital), además, se solicitan firmas y deberán anexar, en una sola cuartilla, las identificaciones oficiales de los autores. El documento debe estar en formato PDF y no exceder las dos cuartillas con un peso máximo de 5MB. Cuando el documento esté completo con los datos solicitados, deberá cargarlos en la sección de abajo "Cargar carta de visto bueno de obra digital" y dar clic en "Enviar carta de visto bueno a revisión (obra digital)".</p>


            <a href="../generar/carta/visto/<?= $anio ?>/digital" class="btn btn-md btn-info">Descargar molde de carta de visto bueno (obra digital) <i class="fa-solid fa-cloud-arrow-down"></i></a>
        </div>
        <div class="marginTopBottom">
            <h4>Cargar carta de visto bueno de obra digital</h4>
            <input type="file" name="cartaVistoDigital" id="cartaVistoDigital" class="form-control" required accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <button type="button" class="btn btn-md btn-block btn-success btnCartaVistoDigital">Enviar carta de visto bueno a revisión (obra digital)</button>
        </div>
        <?php
    }else{
        ?>
        <div class="marginTopBottom">
            <h2>Carta de visto bueno de la obra digital</h2>
            <p>Instrucciones: A continuación deberán realizar el llenado y envío de su carta de visto bueno correspondiente a la obra digital <?= strtoupper($red) ?> <?= $anio ?>. Descargue el molde de la carta, dando clic en el archivo que se encuentra abajo de estas instrucciones o haga clic aquí. Después deberá completar los campos subrayados en color amarillo (El nombre y número de capitulo lo encontrara en el archivo de su capitulo preliminar de la obra digital), además, se solicitan firmas y deberán anexar, en una sola cuartilla, las identificaciones oficiales de los autores. El documento debe estar en formato PDF y no exceder las dos cuartillas con un peso máximo de 5MB. Cuando el documento esté completo con los datos solicitados, deberá cargarlos en la sección de abajo "Cargar carta de visto bueno de obra digital" y dar clic en "Enviar carta de visto bueno a revisión (obra digital)".</p>
            <p>Si su capitulo final necesita correcciones, favor de hacer comentarios dentro del pdf subrayando el texto a cambiar comentando Dice: y Debe decir: . Una vez hecho todas las correciones, subir el archivo en el apartado de Capitulo final digital con marcaje. Las solicitudes seran revisadas y atendidas en medida de lo posible. Si existe algun tema de cambios que no se pueda, se le notificara por correo electronico o por via WhatsApp.</p>

            <a href="../generar/carta/visto/<?= $anio ?>/digital" class="btn btn-md btn-info">Descargar molde de carta de visto bueno (obra digital) <i class="fa-solid fa-cloud-arrow-down"></i></a>
        </div>
        <div class="marginTopBottom">
            <h4>Cargar carta de visto bueno de obra digital</h4>
            <input type="file" name="cartaVistoDigital" id="cartaVistoDigital" class="form-control" required accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <h4>Capítulo final digital con marcaje</h4>
            <input type="file" name="marcajeDigital" id="marcajeDigital" class="form-control" accept=".pdf">
        </div>
        <div class="marginTopBottom">
            <button type="button" class="btn btn-md btn-block btn-success btnCartaVistoDigital">Enviar carta de visto bueno a revisión (obra digital)</button>
        </div>
        <?php
    }
}

if($fase['f_impreso'] == 9){
    ?>
    <script>
        Swal.fire({
            title: "🎉¡Felicidades!🎉",
            text: 'Ha completado todas sus fases de la investigación del libro impreso',
            width: 600,
            padding: "3em",
            background: "#fff url(/images/trees.png)",
            backdrop: `
                rgba(0,0,123,0.4)
                url("${base_url+'/resources/gifs/confetti.gif'}")
                left top
            `,
            confirmButtonText: 'Gracias'
        });
    </script>
    <?php
}

if($fase['f_digital'] == 9){
    ?>
    <script>
        Swal.fire({
            title: "🎉¡Felicidades!🎉",
            text: 'Ha completado todas sus fases de la investigación del libro digital',
            width: 600,
            padding: "3em",
            background: "#fff url(/images/trees.png)",
            backdrop: `
                rgba(0,0,123,0.4)
                url("${base_url+'/resources/gifs/confetti.gif'}")
                left top
            `,
            confirmButtonText: 'Gracias'
        });
    </script>
    <?php
}

if($fase['f_digital'] == 9 && $fase['f_impreso'] == 9){
    ?>
    <script>
        Swal.fire({
            title: "🎉¡Felicidades!🎉",
            text: 'Ha completado todas sus fases de las investigaciones del libro impreso y digital',
            width: 600,
            padding: "3em",
            background: "#fff url(/images/trees.png)",
            backdrop: `
                rgba(0,0,123,0.4)
                url("${base_url+'/resources/gifs/confetti.gif'}")
                left top
            `,
            confirmButtonText: 'Gracias'
        });
    </script>
    <?php
}

?>
<script>
    let anio = <?= $anio ?>;
    let esquema = '<?= $esquema ?>';
</script>

<script src="<?= base_url('resources/js/investigaciones/files.js') ?>"></script>
<script src="<?= base_url('resources/js/investigaciones/index.js') ?>"></script>
<?php
