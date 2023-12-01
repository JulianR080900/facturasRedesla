<?php
function investigacionrelayn2023($investigacion)
{
    $nombre = $investigacion['nombre_esquema'];
?>
    <?php
    if ($investigacion['esquema'] == 'A') {
    ?>
        <h1>Orden de los autores para obras</h1>
        <p>
            Instrucciones: Estimados investigadores, en este apartado es necesario establecer el orden correcto de los autores para el libro digital RELAYN 2023, deberá realizarlo dando clic sobre el autor
            que desea mover de posición, manteniendo el cursor sobre el autor lo podrá colocar en la posición seleccionada.
            Una vez que los autores estén en el orden deseado, dé clic sobre el botón de Registrar orden de autores obra digital paso INDISPENSABLE para que registre el cambio el sistema,
            dicho proceso debe realizarse a más tardar el día 10 de abril de 2023, sino lo realizan se establecerá el orden que está actualmente en plataforma.
        </p>
        <p>
            Si el botón ya no está habilitado es porque alguno de los autores ya lo registró, si este no es correcto favor de enviar el orden correcto al correo pmejiaa@redesla.la con copia a todos los autores indicando:
        </p>
        <p>
        <h6>Obra digital</h6>
        <ul>
            <li>Autor 1: Nombre completo</li>
            <li>Autor 2: Nombre completo</li>
            <li>Autor 3: Nombre completo</li>
            <li>Autor 4: Nombre completo</li>
        </ul>
        </p>
        <h3>Orden digital</h3>
        <hr>
        <form action="../orden_libros/digital/<?= $investigacion['anio_investigacion'] ?>" method="post" id="form_digital">
            <div class="row">
                <div class="col-md-12">
                    <ul id="digital">
                    </ul>
                </div>
            </div>
            <button type="submit" id="submit_digital" class="btn btn-success btn-block">Registrar orden digital</button>
        </form>
    <?php
    } else if ($investigacion['esquema'] == 'B') {
    ?>
        <h1>Orden de los autores para obras</h1>
        <p>
            Instrucciones: Estimados investigadores, en este apartado es necesario establecer el orden correcto de los autores para el libro digital e impreso RELAYN 2023, deberá realizarlo dando clic sobre el autor
            que desea mover de posición, manteniendo el cursor sobre el autor lo podrá colocar en la posición seleccionada.
            Una vez que los autores estén en el orden deseado, dé clic sobre el botón de Registrar orden de autores obra digital e impresa paso INDISPENSABLE para que registre el cambio el sistema,
            dicho proceso debe realizarse a más tardar el día 10 de abril de 2023, sino lo realizan se establecerá el orden que está actualmente en plataforma.
        </p>
        <p>
            Si el botón ya no está habilitado es porque alguno de los autores ya lo registró, si este no es correcto favor de enviar el orden correcto al correo pmejiaa@redesla.la con copia a todos los autores indicando:
        </p>
        <p>
        <h6>Obra digital/impresa</h6>
        <ul>
            <li>Autor 1: Nombre completo</li>
            <li>Autor 2: Nombre completo</li>
            <li>Autor 3: Nombre completo</li>
            <li>Autor 4: Nombre completo</li>
        </ul>
        </p>
        <h3>Orden impreso</h3>
        <hr>
        <form action="../orden_libros/impreso/<?= $investigacion['anio_investigacion'] ?>" method="post" id="form_impreso">
            <div class="row">
                <div class="col-md-12">
                    <ul id="impreso">
                    </ul>
                </div>
            </div>
            <button type="submit" id="submit_impreso" class="btn btn-success btn-block">Registrar orden impreso</button>
        </form>
        <h3>Orden digital</h3>
        <hr>
        <form action="../orden_libros/digital/<?= $investigacion['anio_investigacion'] ?>" method="post" id="form_digital">
            <div class="row">
                <div class="col-md-12">
                    <ul id="digital">
                    </ul>
                </div>
            </div>
            <button type="submit" id="submit_digital" class="btn btn-success btn-block">Registrar orden digital</button>
        </form>
    <?php
    }
    ?>



    <input hidden id="nombre_proyecto" value="<?= $nombre ?>">
    <hr>
    <p>
        Para cuando proporcionen la asignación y materiales de aplicación de instrumentos a sus alumnos (encuestadores), les sugerimos envíen mensaje parecido a este,
        sea por correo electrónico, Moodle, WhatsApp o el medio que ustedes prefieran:
    </p>
    <div class="clipboard">
        <div id="txt_clipboard">
            Estimados encuestadores:
            Gracias por formar parte de esta investigación, su labor es de suma importancia para la Investigación Científica, les compartimos el enlace para que realicen la
            captura de las encuestas una vez aplicado al directivo: <?= base_url('encuestas/' . $_SESSION['CA']) . '/' . $investigacion['password'] ?>

            Una vez capturada la encuesta podrán consultar el folio en: <?= base_url('encuestas/lista/' . $_SESSION['CA']) . '/2023/' . $investigacion['password'] ?>

            ¡Ustedes forman parte de una gran investigación!

        </div>
        <i class="fas fa-clone btnClipboard" id="iconClip" title="Copiar"></i>
    </div>
    <hr>
    <h3>Enlaces</h3>
    <ul>
        <li>Carpeta general: <a target="_blank" href="https://drive.google.com/drive/folders/1WmLDOVyO8upHpGEREn7Hwz3nnCIdwaBL">https://drive.google.com/drive/folders/1WmLDOVyO8upHpGEREn7Hwz3nnCIdwaBL</a></li>
        <li>Video de habilitación de investigación / capacitación a investigadores: <a href="https://www.youtube.com/watch?v=XcvDfC6P2Fs">https://www.youtube.com/watch?v=XcvDfC6P2Fs</a></li>
        <li>Video reunión extraordinaria: <a href="https://www.youtube.com/watch?v=Q-BJ02JxpmE">https://www.youtube.com/watch?v=Q-BJ02JxpmE</a></li>
        <li>Capacitación encuestadores: <a href="https://drive.google.com/file/d/1aDgUaBqqMp52Gu7dsbgqSxELnMHqjVJB/view?usp=share_link">https://drive.google.com/file/d/1aDgUaBqqMp52Gu7dsbgqSxELnMHqjVJB/view?usp=share_link</a></li>
        <li>Capacitación investigadores: <a href="https://drive.google.com/file/d/1mkZPSocko_ShUmtHPhqHCaXz1m4QmySA/view?usp=sharing">https://drive.google.com/file/d/1mkZPSocko_ShUmtHPhqHCaXz1m4QmySA/view?usp=sharing</a></li>
        <li>Enlace para registrar sus encuestas: <a target="_blank" href="<?= base_url('encuestas/' . $_SESSION['CA']) . '/' . $investigacion['password'] ?>"><?= base_url('encuestas/' . $_SESSION['CA']) . '/' . $investigacion['password'] ?></a></li>
        <li>Enlace para que sus alumnos vean el listado de las encuestas capturadas: <a target="_blank" href="<?= base_url('encuestas/lista/' . $_SESSION['CA']) . '/2023/' . $investigacion['password'] ?>"><?= base_url('encuestas/lista/' . $_SESSION['CA']) . '/2023/' . $investigacion['password'] ?></a></li>
    </ul>
    <h1>Resumen general</h1>
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
    
    <br>
    <h2 class="text-center">Porcentaje de avance con respecto a las encuestas registradas</h2>
    <div class="progress">
        <div class="progress-bar <?= $investigacion['pocentaje_completado'] == 100 ? 'bg-success' : 'bg-warning'; ?>" role="progressbar" style="width: <?= $investigacion['pocentaje_completado'] ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <p class="text-center">
        <?= $investigacion['pocentaje_completado'] == 100 ? 'Todas las encuestas revisadas' : $investigacion['pocentaje_completado'] . '% completado'; ?>
    </p>
    <hr>
    <div class="col-lg-12 table-responsive">
        <h3>Lista de encuestas</h3>
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
            atencion@redesl.la y jaramosp@red.redesla.la
        </div>

        <a href="../getExcel/2023"><span class="badge badge-pill badge-success">Descargar todas las encuestas en Excel</span></a>
        <table class="table table-striped table-responsive-lg" id="dt_investigacion">
            <thead>
                <tr>
                    <th class="centered">Folio</th>
                    <th class="centered">Nombre del encuestador</th>
                    <th class="centered">Validación</th>
                    <th class="centered">Ítems (NA)</th>
                    <th class="centered">Ver cuestionario</th>
                    <th class="centered">Editar</th>
                </tr>
            </thead>
            <tbody id="tbody_investigacion">

            </tbody>
        </table>
    </div>
    <hr>
    <?php
    if (!isset($investigacion['validacion'])) {
    ?>
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
        <div class="row">
            <h3 class="text-center">Una vez concluido el proceso de captura y validación de sus encuestas envíe a revisión con el Equipo RedesLA, dé clic en el siguiente botón</h3>
            <?php
            if ($investigacion['entrevistas_pendientes'] > 0) {
            ?>
                <h5 class="text-warning text-center">Favor de terminar de validar todas sus encuestas para enviar su validación a revisión.</h5>
            <?php
            } else {
            ?>
                <button id="terminarProcesoCapturaEncuestas" name="terminar" class="btn btn-success btn-block">Cerrar captura y enviar revisión de validación de encuestas</button>
            <?php
            }
            ?>

        </div>
    <?php
    } else if ($investigacion['validacion'] == 1) {
    ?>
        <h3 class="text-warning text-center">Sus encuestas estan en proceso de revisión. Favor de esperar instrucciones.</h3>
        <script>
            $(document).on('click', 'a.verCuestionario, a.editarCuestionario', function(e) {
                e.preventDefault()
            });
        </script>
    <?php
    } else if ($investigacion['validacion'] == 2) {
    ?>
        <p class="text-center">
            Estimados investigadores e investigadoras del grupo <b class="n_<?= $_SESSION['red'] ?>"><?= $_SESSION['CA'] ?></b>. <br>

            El Equipo RedesLA confirma que su validación de sus encuestas se ha sido realizado de forma correcta, agradecemos el cumplimiento de actividades en tiempo y
            forma, la siguiente etapa es la de redacción de capitulo(s), les pedimos amablemente estar pendiente de nuestros comunicados.<br>

            🧡 En RELAYN tenemos #PasiónPorLaInvestigación <br>
            🤓 Manténgase actualizado: <a href="https://www.facebook.com/RELAYN.ORG" target="_blank">https://www.facebook.com/RELAYN.ORG</a><br>
            🌍 <a href="https://relayn.redesla.la" target="_blank">https://relayn.redesla.la</a>
        </p>

        <script>
            $(document).on('click', 'a.verCuestionario', function(e) {
                e.preventDefault()
            });
        </script>
    <?php
    } else if ($investigacion['validacion'] == 3) {
    ?>
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
        <h3 class="text-warning text-center">¡Importante! Su proceso de validación de sus encuestas necesita correcciones, revise su correo.</h3>
        <h3 class="text-center">Una vez concluido el proceso de captura y validación de sus encuestas envíe a revisión con el Equipo RedesLA, dé clic en el siguiente botón</h3>
        <?php
        if ($investigacion['entrevistas_pendientes'] > 0) {
        ?>
            <h5 class="text-warning text-center">Favor de terminar de validar todas sus encuestas para enviar su validación a revisión.</h5>
        <?php
        } else {
        ?>
            <button id="terminarProcesoCapturaEncuestas" name="terminar" class="btn btn-success btn-block">Cerrar captura y enviar revisión de validación de encuestas</button>
        <?php
        }
        ?>
    <?php
    }
    ?>







    <style>
        .dropdown-item:focus,
        .dropdown-item:hover {
            background-color: transparent !important;
            cursor: pointer;
        }

        select[name="dt_investigacion_length"] {
            color: black !important;
        }
    </style>
    <script>
        let proyecto = $("#nombre_proyecto").val();
        let nombre_investigacion = '<?= $investigacion['nombre_tabla'] ?>';
        let impreso = '<?= $investigacion['impreso'] ?>'
        let digital = '<?= $investigacion['digital'] ?>'
        let anio = '<?= $investigacion['anio_investigacion'] ?>'
    </script>
    <script src="<?= base_url('resources/js/investigaciones/orden_libros.js') ?>"></script>
    <script src="<?= base_url('resources/js/datatables/investigaciones.js') ?>"></script>
    <script src="<?= base_url('resources/js/investigaciones/index.js') ?>"></script>

<?php
}


function investigacionrelen2023($investigacion)
{
?>
    <?php
    $nombre = $investigacion['nombre_esquema'];
    if ($investigacion['esquema'] == 'A') {
    ?>
        <h1>Orden de los autores para obras</h1>
        <p>
            Instrucciones: Estimados investigadores, en este apartado es necesario establecer el orden correcto de los autores para el libro digital RELAYN 2023, deberá realizarlo dando clic sobre el autor
            que desea mover de posición, manteniendo el cursor sobre el autor lo podrá colocar en la posición seleccionada.
            Una vez que los autores estén en el orden deseado, dé clic sobre el botón de Registrar orden de autores obra digital paso INDISPENSABLE para que registre el cambio el sistema,
            dicho proceso debe realizarse a más tardar el día 17 de abril de 2023, sino lo realizan se establecerá el orden que está actualmente en plataforma.
        </p>
        <h3>Orden digital</h3>
        <hr>
        <form action="../orden_libros/digital/<?= $investigacion['anio_investigacion'] ?>" method="post" id="form_digital">
            <div class="row">
                <div class="col-md-12">
                    <ul id="digital">
                    </ul>
                </div>
            </div>
            <button type="submit" id="submit_digital" class="btn btn-success btn-block">Registrar orden digital</button>
        </form>
    <?php
    } else if ($investigacion['esquema'] == 'B') {
    ?>
        <h1>Orden de los autores para obras</h1>
        <p>
            Instrucciones: Estimados investigadores, en este apartado es necesario establecer el orden correcto de los autores para el libro digital e impreso RELAYN 2023, deberá realizarlo dando clic sobre el autor
            que desea mover de posición, manteniendo el cursor sobre el autor lo podrá colocar en la posición seleccionada.
            Una vez que los autores estén en el orden deseado, dé clic sobre el botón de Registrar orden de autores obra digital e impresa paso INDISPENSABLE para que registre el cambio el sistema,
            dicho proceso debe realizarse a más tardar el día 17 de abril de 2023, sino lo realizan se establecerá el orden que está actualmente en plataforma.
        </p>
        <h3>Orden impreso</h3>
        <hr>
        <form action="../orden_libros/impreso/<?= $investigacion['anio_investigacion'] ?>" method="post" id="form_impreso">
            <div class="row">
                <div class="col-md-12">
                    <ul id="impreso">
                    </ul>
                </div>
            </div>
            <button type="submit" id="submit_impreso" class="btn btn-success btn-block">Registrar orden impreso</button>
        </form>
        <h3>Orden digital</h3>
        <hr>
        <form action="../orden_libros/digital/<?= $investigacion['anio_investigacion'] ?>" method="post" id="form_digital">
            <div class="row">
                <div class="col-md-12">
                    <ul id="digital">
                    </ul>
                </div>
            </div>
            <button type="submit" id="submit_digital" class="btn btn-success btn-block">Registrar orden digital</button>
        </form>
    <?php
    }
    ?>
    <input hidden id="nombre_proyecto" value="<?= $nombre ?>">
    <hr>
    <p>
        Para cuando proporcionen la asignación y materiales de aplicación de instrumentos a sus alumnos (encuestadores), les sugerimos envíen mensaje parecido a este,
        sea por correo electrónico, Moodle, WhatsApp o el medio que ustedes prefieran:
    </p>
    <div class="clipboard">
        <div id="txt_clipboard">
            Estimados alumnos:
            Gracias por formar parte de esta investigación, su labor es de suma importancia para la Investigación Científica, les compartimos el enlace para que
            realicen la captura de las encuestas una vez aplicado al directivo: <?= base_url('encuestas/' . $_SESSION['CA']) . '/' . $investigacion['password'] ?>
        </div>
        <i class="fas fa-clone btnClipboard" id="iconClip" title="Copiar"></i>
    </div>
    <hr>
    <h3>Enlaces</h3>
    <ul>
        <li>Carpeta general: <a target="_blank" href="https://drive.google.com/drive/folders/1KPG7lfgDy8kSLTDKtw9OBqDD6XfBa7vO?usp=share_link">https://drive.google.com/drive/folders/1KPG7lfgDy8kSLTDKtw9OBqDD6XfBa7vO?usp=share_link</a></li>
        <li>Video de habilitación de investigación / capacitación a investigadores: <a href="https://youtu.be/TL8CDWeXa6Q">https://youtu.be/TL8CDWeXa6Q</a></li>
        <li>Capacitación encuestadores: <a href="https://drive.google.com/file/d/1GQKYY8eVuN07yVtVNGDu_ml_rW3Q0oHJ/view?usp=share_link">https://drive.google.com/file/d/1GQKYY8eVuN07yVtVNGDu_ml_rW3Q0oHJ/view?usp=share_link</a></li>
        <li>Capacitación investigadores: <a href="https://drive.google.com/file/d/12SYBOJlLjExOtzsLT-3TuiRFzNmm1sRj/view?usp=share_link">https://drive.google.com/file/d/12SYBOJlLjExOtzsLT-3TuiRFzNmm1sRj/view?usp=share_link</a></li>
        <li>Enlace para registrar sus encuestas: <a target="_blank" href="<?= base_url('encuestas/' . $_SESSION['CA']) . '/' . $investigacion['password'] ?>"><?= base_url('encuestas/' . $_SESSION['CA']) . '/' . $investigacion['password'] ?></a></li>
        <li>Enlace para que sus alumnos vean el listado de las encuestas capturadas: <a target="_blank" href="<?= base_url('encuestas/lista/' . $_SESSION['CA']) . '/2023/' . $investigacion['password'] ?>"><?= base_url('encuestas/lista/' . $_SESSION['CA']) . '/2023/' . $investigacion['password'] ?></a></li>
    </ul>
    <h1>Resumen general</h1>
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
    

    <br>
    <h2 class="text-center">Porcentaje de avance con respecto a las encuestas registradas</h2>
    <div class="progress">
        <div class="progress-bar <?= $investigacion['pocentaje_completado'] == 100 ? 'bg-success' : 'bg-warning'; ?>" role="progressbar" style="width: <?= $investigacion['pocentaje_completado'] ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <p class="text-center">
        <?= $investigacion['pocentaje_completado'] == 100 ? 'Todas las encuestas revisadas' : $investigacion['pocentaje_completado'] . '% completado'; ?>
    </p>
    <hr>
    <div class="col-lg-12 table-responsive">
        <h3>Lista de encuestas</h3>
        <p>Instrucciones:</p>
        <p>
            Aqui podra ver el listado de todas sus encuestas capturadas. Favor de completar cada una de las encuestas con un estatus. Si desea cambiar el estatus de una encuesta, posicione el <u>mouse</u>
            sobre la columa de <b>Validación</b> en la tabla y de clic. Se desglosara un menú en donde podra cambiar la validación del cuestionario seleccionado.
        </p>
        <p>
            Si esta usando un dispositivo móvil y no ve las demas columas de la tabla, pulse sobre el fólio del cuestionario y se le desglozará las columnas restantes. El proceso de cambio de estado es el mismo.
        </p>
        <a href="../getExcel/2023"><span class="badge badge-pill badge-success">Descargar todas las encuestas en Excel</span></a>
        <table class="table table-striped table-responsive-lg" id="dt_investigacion">
            <thead>
                <tr>
                    <th class="centered">Folio</th>
                    <th class="centered">Nombre del encuestador</th>
                    <th class="centered">Validación</th>
                    <th class="centered">Ítems (NA)</th>
                    <th class="centered">Ver cuestionario</th>
                    <th class="centered">Editar</th>
                </tr>
            </thead>
            <tbody id="tbody_investigacion">

            </tbody>
        </table>
    </div>
    <hr>
    <?php
    if (!isset($investigacion['validacion'])) {
    ?>
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
        <div class="row">
            <h3 class="text-center">Una vez concluido el proceso de captura y validación de sus encuestas envíe a revisión con el Equipo RedesLA, dé clic en el siguiente botón</h3>
            <?php
            if ($investigacion['entrevistas_pendientes'] > 0) {
            ?>
                <h5 class="text-warning text-center">Favor de terminar de validar todas sus encuestas para enviar su validación a revisión.</h5>
            <?php
            } else {
            ?>
                <button id="terminarProcesoCapturaEncuestas" name="terminar" class="btn btn-success btn-block">Cerrar captura y enviar revisión de validación de encuestas</button>
            <?php
            }
            ?>

        </div>
    <?php
    } else if ($investigacion['validacion'] == 1) {
    ?>
        <h3 class="text-warning text-center">Sus encuestas estan en proceso de revisión. Favor de esperar instrucciones.</h3>
        <script>
            $(document).on('click', 'a.verCuestionario, a.editarCuestionario', function(e) {
                e.preventDefault()
            });
        </script>
    <?php
    } else if ($investigacion['validacion'] == 2) {
    ?>
        <p class="text-center">
            Estimados investigadores e investigadoras del grupo <b class="n_<?= $_SESSION['red'] ?>"><?= $_SESSION['CA'] ?></b>. <br>

            El Equipo RedesLA confirma que su validación de sus encuestas se ha sido realizado de forma correcta, agradecemos el cumplimiento de actividades en tiempo y
            forma, la siguiente etapa es la de redacción de capitulo(s), les pedimos amablemente estar pendiente de nuestros comunicados.<br>

            ❤️ En RELEN tenemos #PasiónPorLaInvestigación <br>
            🤓 Manténgase actualizado: <a href="https://www.facebook.com/RELEN.LA" target="_blank">https://www.facebook.com/RELEN.LA</a><br>
            🌍 <a href="https://relen.redesla.la" target="_blank">https://relen.redesla.la</a>
        </p>

        <script>
            $(document).on('click', 'a.verCuestionario, a.editarCuestionario', function(e) {
                e.preventDefault()
            });
        </script>
    <?php
    } else if ($investigacion['validacion'] == 3) {
    ?>
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
        <h3 class="text-warning text-center">¡Importante! Su proceso de validación de sus encuestas necesita correcciones, revise su correo.</h3>
        <h3 class="text-center">Una vez concluido el proceso de captura y validación de sus encuestas envíe a revisión con el Equipo RedesLA, dé clic en el siguiente botón</h3>
        <?php
        if ($investigacion['entrevistas_pendientes'] > 0) {
        ?>
            <h5 class="text-warning text-center">Favor de terminar de validar todas sus encuestas para enviar su validación a revisión.</h5>
        <?php
        } else {
        ?>
            <button id="terminarProcesoCapturaEncuestas" name="terminar" class="btn btn-success btn-block">Cerrar captura y enviar revisión de validación de encuestas</button>
        <?php
        }
        ?>
    <?php
    }
    ?>
    <style>
        .dropdown-item:focus,
        .dropdown-item:hover {
            background-color: transparent !important;
            cursor: pointer;
        }

        select[name="dt_investigacion_length"] {
            color: black !important;
        }
    </style>
    <script>
        let proyecto = $("#nombre_proyecto").val();
        let nombre_investigacion = '<?= $investigacion['nombre_tabla'] ?>';
        let impreso = '<?= $investigacion['impreso'] ?>'
        let digital = '<?= $investigacion['digital'] ?>'
        let anio = '<?= $investigacion['anio_investigacion'] ?>'
    </script>
    <script src="<?= base_url('resources/js/datatables/investigaciones.js') ?>"></script>
    <script src="<?= base_url('resources/js/investigaciones/orden_libros.js') ?>"></script>
    <script src="<?= base_url('resources/js/investigaciones/index.js') ?>"></script>
<?php
}
?>

<?php
function investigacionrelep2023($investigacion)
{
    $nombre = $investigacion['nombre_esquema'];
?>
    <?php
    if ($investigacion['esquema'] == 'A') {
    ?>
        <h1>Orden de los autores para obras</h1>
        <p>
            Instrucciones: Estimados investigadores, en este apartado es necesario establecer el orden correcto de los autores para el libro digital RELAYN 2023, deberá realizarlo dando clic sobre el autor
            que desea mover de posición, manteniendo el cursor sobre el autor lo podrá colocar en la posición seleccionada.
            Una vez que los autores estén en el orden deseado, dé clic sobre el botón de Registrar orden de autores obra digital paso INDISPENSABLE para que registre el cambio el sistema,
            dicho proceso debe realizarse a más tardar el día 17 de abril de 2023, sino lo realizan se establecerá el orden que está actualmente en plataforma.
        </p>
        <h3>Orden digital</h3>
        <hr>
        <form action="../orden_libros/digital/<?= $investigacion['anio_investigacion'] ?>" method="post" id="form_digital">
            <div class="row">
                <div class="col-md-12">
                    <ul id="digital">
                    </ul>
                </div>
            </div>
            <button type="submit" id="submit_digital" class="btn btn-success btn-block">Registrar orden digital</button>
        </form>
    <?php
    } else if ($investigacion['esquema'] == 'B') {
    ?>
        <h1>Orden de los autores para obras</h1>
        <p>
            Instrucciones: Estimados investigadores, en este apartado es necesario establecer el orden correcto de los autores para el libro digital e impreso RELAYN 2023, deberá realizarlo dando clic sobre el autor
            que desea mover de posición, manteniendo el cursor sobre el autor lo podrá colocar en la posición seleccionada.
            Una vez que los autores estén en el orden deseado, dé clic sobre el botón de Registrar orden de autores obra digital e impresa paso INDISPENSABLE para que registre el cambio el sistema,
            dicho proceso debe realizarse a más tardar el día 17 de abril de 2023, sino lo realizan se establecerá el orden que está actualmente en plataforma.
        </p>
        <h3>Orden impreso</h3>
        <hr>
        <form action="../orden_libros/impreso/<?= $investigacion['anio_investigacion'] ?>" method="post" id="form_impreso">
            <div class="row">
                <div class="col-md-12">
                    <ul id="impreso">
                    </ul>
                </div>
            </div>
            <button type="submit" id="submit_impreso" class="btn btn-success btn-block">Registrar orden impreso</button>
        </form>
        <h3>Orden digital</h3>
        <hr>
        <form action="../orden_libros/digital/<?= $investigacion['anio_investigacion'] ?>" method="post" id="form_digital">
            <div class="row">
                <div class="col-md-12">
                    <ul id="digital">
                    </ul>
                </div>
            </div>
            <button type="submit" id="submit_digital" class="btn btn-success btn-block">Registrar orden digital</button>
        </form>
    <?php
    }
    ?>
    <input hidden id="nombre_proyecto" value="<?= $nombre ?>">
    <hr>
    <p>
        Para cuando proporcionen la asignación y materiales de aplicación de instrumentos a sus alumnos (encuestadores), les sugerimos envíen mensaje parecido a este,
        sea por correo electrónico, Moodle, WhatsApp o el medio que ustedes prefieran:
    </p>
    <div class="clipboard">
        <div id="txt_clipboard">
            Estimados alumnos:
            Gracias por formar parte de esta investigación, su labor es de suma importancia para la Investigación Científica, les compartimos el enlace para que
            realicen la captura de las encuestas una vez aplicado al directivo: <?= base_url('encuestas/' . $_SESSION['CA']) . '/' . $investigacion['password'] ?>
        </div>
        <i class="fas fa-clone btnClipboard" id="iconClip" title="Copiar"></i>
    </div>
    <hr>
    <h3>Enlaces</h3>
    <ul>
        <li>Carpeta general: <a target="_blank" href="https://drive.google.com/drive/folders/10Npatrf7Q1H5LLG8MI8CoH6tpkIf7elf?usp=share_link">https://drive.google.com/drive/folders/10Npatrf7Q1H5LLG8MI8CoH6tpkIf7elf?usp=share_link</a></li>
        <li>Video de habilitación de investigación / capacitación a investigadores: <a href="https://www.youtube.com/watch?v=vAXO7yJn98A">https://www.youtube.com/watch?v=vAXO7yJn98A</a></li>
        <li>Capacitación encuestadores: Pendiente</li>
        <li>Capacitación investigadores: Pendiente</li>
        <li>Enlace para registrar sus encuestas: <a target="_blank" href="<?= base_url('encuestas/' . $_SESSION['CA']) . '/' . $investigacion['password'] ?>"><?= base_url('encuestas/' . $_SESSION['CA']) . '/' . $investigacion['password'] ?></a></li>
        <li>Enlace para que sus alumnos vean el listado de las encuestas capturadas: <a target="_blank" href="<?= base_url('encuestas/lista/' . $_SESSION['CA']) . '/2023/' . $investigacion['password'] ?>"><?= base_url('encuestas/lista/' . $_SESSION['CA']) . '/2023/' . $investigacion['password'] ?></a></li>
    </ul>
    <h1>Resumen general</h1>
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
    

    <br>
    <h2 class="text-center">Porcentaje de avance con respecto a las encuestas registradas</h2>
    <div class="progress">
        <div class="progress-bar <?= $investigacion['pocentaje_completado'] == 100 ? 'bg-success' : 'bg-warning'; ?>" role="progressbar" style="width: <?= $investigacion['pocentaje_completado'] ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <p class="text-center">
        <?= $investigacion['pocentaje_completado'] == 100 ? 'Todas las encuestas revisadas' : $investigacion['pocentaje_completado'] . '% completado'; ?>
    </p>
    <hr>
    <div class="col-lg-12 table-responsive">
        <h3>Lista de encuestas</h3>
        <p>Instrucciones:</p>
        <p>
            Aqui podra ver el listado de todas sus encuestas capturadas. Favor de completar cada una de las encuestas con un estatus. Si desea cambiar el estatus de una encuesta, posicione el <u>mouse</u>
            sobre la columa de <b>Validación</b> en la tabla y de clic. Se desglosara un menú en donde podra cambiar la validación del cuestionario seleccionado.
        </p>
        <p>
            Si esta usando un dispositivo móvil y no ve las demas columas de la tabla, pulse sobre el fólio del cuestionario y se le desglozará las columnas restantes. El proceso de cambio de estado es el mismo.
        </p>
        <a href="../getExcel/2023"><span class="badge badge-pill badge-success">Descargar todas las encuestas en Excel</span></a>
        <table class="table table-striped table-responsive-lg" id="dt_investigacion">
            <thead>
                <tr>
                    <th class="centered">Folio</th>
                    <th class="centered">Nombre del encuestador</th>
                    <th class="centered">Validación</th>
                    <th class="centered">Ítems (NA)</th>
                    <th class="centered">Ver cuestionario</th>
                    <th class="centered">Editar</th>
                </tr>
            </thead>
            <tbody id="tbody_investigacion">

            </tbody>
        </table>
    </div>
    <hr>
    <?php
    if (!isset($investigacion['validacion'])) {
    ?>
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
        <div class="row">
            <h3 class="text-center">Una vez concluido el proceso de captura y validación de sus encuestas envíe a revisión con el Equipo RedesLA, dé clic en el siguiente botón</h3>
            <?php
            if ($investigacion['entrevistas_pendientes'] > 0) {
            ?>
                <h5 class="text-warning text-center">Favor de terminar de validar todas sus encuestas para enviar su validación a revisión.</h5>
            <?php
            } else {
            ?>
                <button id="terminarProcesoCapturaEncuestas" name="terminar" class="btn btn-success btn-block">Cerrar captura y enviar revisión de validación de encuestas</button>
            <?php
            }
            ?>

        </div>
    <?php
    } else if ($investigacion['validacion'] == 1) {
    ?>
        <h3 class="text-warning text-center">Sus encuestas estan en proceso de revisión. Favor de esperar instrucciones.</h3>
        <script>
            $(document).on('click', 'a.verCuestionario, a.editarCuestionario', function(e) {
                e.preventDefault()
            });
        </script>
    <?php
    } else if ($investigacion['validacion'] == 2) {
    ?>
        <p class="text-center">
            Estimados investigadores e investigadoras del grupo <b class="n_<?= $_SESSION['red'] ?>"><?= $_SESSION['CA'] ?></b>. <br>

            El Equipo RedesLA confirma que su validación de sus encuestas se ha sido realizado de forma correcta, agradecemos el cumplimiento de actividades en tiempo y
            forma, la siguiente etapa es la de redacción de capitulo(s), les pedimos amablemente estar pendiente de nuestros comunicados.<br>

            💚 En RELEP tenemos #PasiónPorLaInvestigación <br>
            🤓 Manténgase actualizado: <a href="https://www.facebook.com/Relep.redesla.la" target="_blank">https://www.facebook.com/Relep.redesla.la</a><br>
            🌍 <a href="https://relep.redesla.la" target="_blank">https://relep.redesla.la</a>
        </p>

        <script>
            $(document).on('click', 'a.verCuestionario, a.editarCuestionario', function(e) {
                e.preventDefault()
            });
        </script>
    <?php
    } else if ($investigacion['validacion'] == 3) {
    ?>
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
        <h3 class="text-warning text-center">¡Importante! Su proceso de validación de sus encuestas necesita correcciones, revise su correo.</h3>
        <h3 class="text-center">Una vez concluido el proceso de captura y validación de sus encuestas envíe a revisión con el Equipo RedesLA, dé clic en el siguiente botón</h3>
        <?php
        if ($investigacion['entrevistas_pendientes'] > 0) {
        ?>
            <h5 class="text-warning text-center">Favor de terminar de validar todas sus encuestas para enviar su validación a revisión.</h5>
        <?php
        } else {
        ?>
            <button id="terminarProcesoCapturaEncuestas" name="terminar" class="btn btn-success btn-block">Cerrar captura y enviar revisión de validación de encuestas</button>
        <?php
        }
        ?>
    <?php
    }
    ?>
    <style>
        .dropdown-item:focus,
        .dropdown-item:hover {
            background-color: transparent !important;
            cursor: pointer;
        }

        select[name="dt_investigacion_length"] {
            color: black !important;
        }
    </style>
    <script>
        let proyecto = $("#nombre_proyecto").val();
        let nombre_investigacion = '<?= $investigacion['nombre_tabla'] ?>';
        let impreso = '<?= $investigacion['impreso'] ?>'
        let digital = '<?= $investigacion['digital'] ?>'
        let anio = '<?= $investigacion['anio_investigacion'] ?>'
    </script>
    <script src="<?= base_url('resources/js/datatables/investigaciones.js') ?>"></script>
    <script src="<?= base_url('resources/js/investigaciones/orden_libros.js') ?>"></script>
    <script src="<?= base_url('resources/js/investigaciones/index.js') ?>"></script>
<?php
}
?>


<?php
function investigacionreleg2022($info)
{
    $nombre = $info['nombre_esquema'];
    $entro = false;
?>
    <h3>Enlaces</h3>
    <li>Ver video de capacitación</li>
    <a target="_blank" href="https://youtu.be/R244Q6gLLtU">Click para ver video de capacitación</a>
    <li>Ver video de reunión extraordinaria</li>
    <a target="_blank" href="https://youtu.be/B9fvsBGAXVM">Click para ver video de reunión extraordinaria</a>
    <li>Carpeta compartida general:</li>
    <a target="_blank" href="<?php echo $info["carpetas_comunes"]["url"] ?>">Click para abrir la carpeta compartida general</a><br>
    <li>Enlace para la transcripción de las entrevistas</li>
    <a target="_blank" href="https://relmo.redesla.la/entrevistas/entrevista/<?= $_SESSION["CA"] . "/" . $info["password"] ?>">https://relmo.redesla.la/entrevistas/<?= $_SESSION["CA"] . "/" . $info["password"] ?></a>
    <li>Reunión 2da. Fase de la investigación</li>
    <a href="https://www.youtube.com/watch?v=4KWXO8o86ZI" target="_blank">Vídeo de la Reunión 2da. Fase de la investigación</a>
    <li>Reunión 3ra. Fae de la inestigación</li>
    <a href="https://www.youtube.com/watch?v=ZAlYNMSIgak" target="_blank">https://www.youtube.com/watch?v=ZAlYNMSIgak</a>
    <li>Lista de categorias Word/Pdf</li>
    <a href="<?= base_url('resources/pdf/Lista de categorias RELEG.pdf') ?>" target="_blank">Lista de categorias WORD/PDF</a>
    <li>Presentación 2da Fase de la investgación</li>
    <a href="https://drive.google.com/file/d/1o3VbQToOtYRG0hxvI3H5HERyfR_awN0Y/view?usp=share_link" target="_blank">https://drive.google.com/file/d/1o3VbQToOtYRG0hxvI3H5HERyfR_awN0Y/view?usp=share_link</a>
    <br>
    <li>Subir audios:</li>
    <a target="_blank" href="<?php echo $info["carpeta"]["recibidos"] ?>">Ir a la carpeta para el grupo <?= $_SESSION["CA"] ?></a><br>
    <hr>
    <div id="tabla_entrevistas">
        <h3>Entrevistas realizadas</h3>
        <table class="table table-striped text-center" id="example">
            <thead class="thead-table-facturas">
                <tr>
                    <th scope="col">Número de entrevista</th>
                    <th scope="col">Nombre de la entrevistadora</th>
                    <th scope="col">Nombre de la entrevistada</th>
                    <th scope="col">Modificado</th>
                    <th scope="col">Entrevista completa</th>
                    <th scope="col">Bitácora</th>
                    <th scope="col">Categorias identificadas</th>
                    <th scope="col">Recapturar</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody class="table-body-facturas">
                <?php
                if (empty($info["entrevistas"])) {
                ?>
                    <td colspan="7" class="text-center">No tienes entrevistas registradas</td>
                    <?php
                } else {
                    foreach ($info["entrevistas"] as $e) {
                    ?>
                        <tr>
                            <td><?= $e["id"] ?></td>
                            <td><?= $e["nombre_entrevistadora"] ?></td>
                            <td><?= $e["nombre_entrevistada"] ?></td>
                            <td>
                                <?php
                                echo $e['editado'] == 1 ? '<i class="fas fa-check-circle verde" data-toggle="popover" data-content="Ha modificado la entrevista desde la última revisión"></i>' :
                                    '<i class="fas fa-info-circle text-warning" data-toggle="popover" data-content="No se ha modificado la entrevista desde la última revisión"></i>';
                                ?>
                            </td>
                            <td>
                                <a target="_blank" href="<?= base_url("visualizarEntrevista/" . $e["id"]) ?>" type='button' class="btn btn-info">Ver completa</a>
                            </td>
                            <td>
                                <a target="_blank" href="<?= base_url("visualizarBitacora/" . $e["id"]) ?>" type='button' class="btn btn-info">Ver bitácora</a>
                            </td>
                            <td>
                                <?php
                                foreach ($e['colores'] as $c) {
                                    echo '<i class="fa-solid fa-circle" style="color:#' . $c . '"></i>&nbsp';
                                }
                                ?>
                            </td>
                            <td>
                                <button id="recapturar" name="recapturar" data-id="<?= $e["id"] ?>" href="recapturar()" class="btn btn-success">Recapturar</button>
                            </td>
                            <td>
                                <button id="editar" name="editar" data-id="<?= $e["id"] ?>" href="editar()" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</button>
                            </td>
                            <td>
                                <button id="eliminar" name="eliminar" data-id="<?= $e["id"] ?>" href="eliminar()" class="btn btn-danger"><i class="fas fa-trash-alt"></i>Eliminar</button>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <input hidden id="nombre_proyecto" value="<?= $nombre ?>">
    <?php
    if (empty($info["validacion"])) {
    ?>
        <button id="terminar" class="btn btn-block btn-success" data-ca="<?php echo $_SESSION["CA"] ?>" href="terminar()">Enviar a revisión</button>
    <?php
    } else if ($info["validacion"][0]["terminado"] == 1 || $info["validacion"][0]["terminado"] == 4) {
    ?>
        <h2 class="text-center">Sus entrevistas se encuentran en un estado de revisión. Le recomendamos esperar antes de capturar mas entrevistas.</h2>
    <?php
    } else if ($info["validacion"][0]["terminado"] == 2) {
    ?>
        <!-- <h2 class="text-center verde">Su revisión fue un éxito. Espere intrucciones para la siguiente fase de la investigación. </h2> -->
        <h1>FASE II DEL PROCESO DE LA INVESTIGACIÓN CUALITATIVA: <br> “Los obstáculos que tienen las estudiantes universitarias que dirigen una micro o pequeña empresa”.</h1>
        <hr>
        <p>
            En esta fase de la investigación se llevará a cabo el “Proceso de Categorización” de la información obtenida en la aplicación de las entrevistas y que han sido capturadas en esta plataforma.
        </p>
        <ol type="1">
            <li>
                Por favor revisar las categorías que emergieron durante el análisis y proceso de saturación que realizó el Comité
                Académico, así como también revisar las descripciones de cada una de las categorías señaladas,
                esta información se presenta en el <a href="#categorias">siguiente apartado</a>
            </li>
            <li>
                Codificación: a cada categoría que emergió, se le ha asignado un color dentro de la plataforma.
            </li>
            <li>
                Habrá que ingresar a la plataforma REDESLA.LA/REDESLA en el apartado de sus proyectos, para ingresar
                a la sección en la que se encuentran capturadas sus entrevistas.
            </li>
            <li>
                Para esta segunda fase de la investigación se trabajará particularmente en las respuestas de las preguntas
                21, 22 y 23 de las entrevistas aplicadas. Habrá que realizar el análisis de estas respuestas que abordan
                los obstáculos que externaron las mujeres universitarias de su zona, detectando si se presentan los
                obstáculos definidos a través de las categorías proporcionadas por el Comité Académico RELEG.
            </li>
            <li>
                Al momento de llevar el análisis, si las investigadoras detectaron en las respuestas “códigos en vivo”
                proporcionados por sus sujetas de investigación y que corresponden a alguna o algunas categorías
                proporcionadas por el Comité Académico de RELEG, se llevarán a cabo los siguientes pasos:
            </li>
            Pasos para la captura de las categorías identificadas en sus entrevistas:
            <ul>
                <li>
                    Den clic en en el botón: “Ver Completa” dentro de la entrevista en la que realizará la categorización.
                </li>
                <li>
                    Dentro del apartado podrá ver la transcripción de su entrevista. Dentro de ésta, se tendrá que identificar,
                    de manera manual, la categoría a la que pertenece el código en vivo que identificó dentro de su entrevista.
                </li>
                <li>
                    Seleccione y copie el código en vivo tal cual lo registró en su entrevista.
                </li>
                <li>
                    En la parte de abajo de la página se cuenta con un formulario en donde tiene que -pegar-
                    el código en vivo anteriormente copiado.
                </li>
                <li>
                    Dentro de este formulario, seleccione la categoría a la que pertenece el código en vivo.
                </li>
                <li>
                    Una vez llenado todos los datos solicitados, deberán hacer clíc en Ingresar categoría
                </li>
                <li>
                    Se refrescará la página y se podrá visualizar, con el código al que pertenece la categoría,
                    el texto con el color al que hace referencia la categoría ingresada.
                </li>
            </ul>
        </ol>
        <h3>Notas</h2>
            <hr>
            <ul>
                <li>
                    También podrá ver la definición de la categoría y lo que engloba dando clic al ícono de i en la tabla del listado de categorías.
                </li>
                <li>
                    Se pueden registrar tantas categorías identifiquen, solamente éstas no se deben sobreponer unas con otras.
                </li>
                <li>
                    En el listado de las entrevistas se podrá visualizar de manera general, las categorías que engloba cada entrevista con el código de la categoría.
                </li>
                <li>
                    Si al realizar el análisis considera que encontró una categoría ajena a las proporcionadas y desea hacer una propuesta de una categoría nueva para
                    ser considerada dentro de la investigación, puede hacerlo dando clic en el botón de <a href="#proponer">PROPONER CATEGORÍA</a> y
                    llenando los campos solicitados. La propuesta, pasará por un estado de revisión por parte del equipo de
                    RELEG. Si su propuesta fue aceptada, se le dará a conocer al equipo de investigación que la sugirió y
                    se verá reflejada en el listado de categorías de esta investigación para que la puedan considerar el
                    resto de las y los investigadores que integran esta investigación.
                </li>
            </ul>
            <h1 name='categorias' id="categorias">Lista de categorías</h1>
            <!--INSTRUCCIONES-->
            <table class="table table-dark text-center" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Código</th>
                        <th>Ver definición</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($info['categorias'] as $c) {
                    ?>
                        <tr>
                            <td><?= $c['nombre'] ?></td>
                            <td><i class="fa-solid fa-circle" style="color: #<?= $c['color'] ?>"></i></td>
                            <td><i class="fas fa-info-circle" style="color: #ffbb33; font-size: 15px" data-toggle="popover" data-content="<?= $c['descripcion'] ?>"></i></label></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <hr>
            <p>
                Estimadas Investigadoras, si consideran que dentro de la información obtenida en sus entrevistas ha emergido una categoría que no se presenta en esta fase de categorización,
                favor de ingresarla dando clíc en el botón de <b class="n_<?= $_SESSION['red'] ?>">Proponer categoría</b> ubicado en la parte inferior de la página, considerando ponerle un <b class="n_<?= $_SESSION['red'] ?>">nombre tentativo</b>,
                así como una <b class="n_<?= $_SESSION['red'] ?>">breve descripción</b> de la categoría encontrada sobre los obstáculos de la joven universitaria en la gestión de la organización, de igual forma es importante
                ingresar <b class="n_<?= $_SESSION['red'] ?>">tres códigos en vivo</b> que sustenten dicha propuesta. Posteriormente serán revisados por el Comité Académico de RELEG, el cual analizará la validación de su
                propuesta de categoría, de ser aprobada será publicada para que sea considerada en esta investigación.
            </p>
            <h4>El tiempo de propuestas de categorías ha finalizado.</h4>
            <button type="button" disabled class="btn btn-block bg-<?= $_SESSION['red'] ?>" data-toggle="modal" data-target="#propuesta" style="text-decoration:none; color:var(--font-primary-color)" name="proponer" id="proponer">
                Proponer categoría
            </button>
            <?php
            if (!empty($info['propuestas'])) {
            ?>
                <hr>
                <h3>Categorías propuestas</h3><br>
                <table class="table table-dark text-center" style="width: 100%;" id="example2">
                    <thead>
                        <tr>
                            <th>Nombre de la categoría</th>
                            <th>Descripción</th>
                            <th>Código en vivo</th>
                            <th>Estado</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($info['propuestas'] as $c) {
                        ?>
                            <tr>
                                <td><?= $c['nombre'] ?></td>
                                <td><?= $c['descripcion'] ?></td>
                                <td><?= $c['codigo_en_vivo'] ?></td>
                                <td><?= $c['activo'] == 1 ? '<i class="fas fa-check-circle verde"></i> Validado' : '<i class="fas fa-info-circle text-warning"></i> En revisión'; ?></td>
                                <td><button id="editarPropuesta" disabled name="editar" data-id="<?= $c['id'] ?>" data-toggle="modal" data-codigo="<?= $c['codigo_en_vivo'] ?>" data-nombre="<?= $c['nombre'] ?>" data-descripcion="<?= $c['descripcion'] ?>" data-target="#editpropuesta" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</button></td>
                                <td><button id="eliminarCategoria" disabled name="eliminar" data-id="<?= $c["id"] ?>" href="eliminarCategoria()" class="btn btn-danger"><i class="fas fa-trash-alt"></i>Eliminar</button></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            }
            ?>

            <button id="terminar2dafase" class="btn btn-block btn-success" data-ca="<?php echo $_SESSION["CA"] ?>" href="terminar()">Enviar a revisión</button>

            <div class="modal fade" id="propuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Proponer categoría</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo base_url('agregarCategoria'); ?>" method="post">
                                <div class="mb-3">
                                    <label for="nombre" class="col-form-label">Nombre de la categoría:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="col-form-label">Descripción:</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="codigo_en_vivo" class="col-form-label">Código en vivo:</label>
                                    <p class="text-warning">Favor de NO colocar los ID de las entrevistas para que su propuesta sea considerada</p>
                                    <textarea class="form-control" id="codigo_en_vivo" name="codigo_en_vivo" required minlength="150"></textarea>
                                </div>
                                <p>* Su propuesta pasará por un proceso de validación con el Cómite Revisor RELEG.</p>
                                <p>* La categoría propuesta puede sufrir cambios de redacción al ser válidada.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>">Enviar propuesta</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editpropuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Proponer categoría</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?php echo base_url('generalUpdate/categorias'); ?>" method="post">
                                <div class="mb-3">
                                    <label for="nombre" class="col-form-label">Nombre de la categoría:</label>
                                    <input type="text" class="form-control" id="nombreEdit" name="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="col-form-label">Descripción:</label>
                                    <textarea class="form-control" id="descripcionEdit" name="descripcion" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="codigo_en_vivo" class="col-form-label">Código en vivo:</label>
                                    <textarea class="form-control" id="codigo_en_vivo_edit" name="codigo_en_vivo" required minlength="150"></textarea>
                                </div>
                                <input type="text" name="id" id="id_edit_propuesta" hidden>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>">Editar propuesta</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php
    } else if ($info["validacion"][0]["terminado"] == 0) {
        ?>
            <h2 class="text-center" style="color:red">
                Estimadas Investigadoras: lamentamos informarles que derivado de que la información obtenida de la aplicación de sus entrevistas,
                no cumple con los estándares solicitados en el protocolo de esta investigación, éstas han sido rechazadas. Para mayor información
                sobre esta resolución, consulte su correo donde el Comité de Relmo da una explicación más amplia al respecto. Sin embargo, es
                importante destacar que si desean continuar participando pueden enviar un correo o comunicarse directamente al siguiente número:
                +52 1 442 879 4549, para concertar una cita vía nuestra plataforma Vive Redesla y hablar directamente con una integrante del Comité
                Académico para abordar su caso. Muchas gracias</h2>
            <br>
            <p class='text-center'>UNA VEZ QUE <b><u>TODAS</u></b> LAS INTEGRANTES HAYAN REALIZADO EN SU TOTALIDAD LAS CORRECCIONES QUE LES FUERON INDICADAS POR EL COMITÉ REVISOR, POR FAVOR DÉ CLICK EN EL BOTÓN PARA ENVIARLO NUEVAMENTE A REVISIÓN</p>
            <a id="volverValidar" class="btn btn-rounded btn-block bg-<?= $_SESSION['red'] ?> " style="text-decoration:none; color:var(--font-primary-color)" data-ca="<?php echo $_SESSION["CA"] ?>" href="volverValidar()" href="<?php echo base_url("validacionRelmo/$nombre"); ?>" />De clic aquí para enviar correcciones</a>
        <?php
    } else if ($info["validacion"][0]["terminado"] == 3) {
        ?>
            <h3 class="text-center" style="color:#ffc000">
                Investigadoras: atender una revisión implica que tiene que REENVIAR las entrevistas. DEBE RE-CAPTURAR(captura un nuevo ID de entrevista) o
                editar (mantener el mismo ID de entrevista), esto se lleva a cabo dando clic al ícono del pincel, el cual se encuentra al lado de su listado de entrevistas.
                Si requiere (n) más información por favor consulte su correo o el apartado de "INICIO"./h3>
                <br>
                <p class='text-center'>UNA VEZ QUE <b><u>TODAS</u></b> LAS INTEGRANTES HAYAN REALIZADO EN SU TOTALIDAD LAS CORRECCIONES QUE LES FUERON INDICADAS POR EL COMITÉ REVISOR, POR FAVOR DÉ CLICK EN EL BOTÓN PARA ENVIARLO NUEVAMENTE A REVISIÓN</p>
                <a id="volverValidar" class="btn btn-rounded btn-block bg-<?= $_SESSION['red'] ?> " style="text-decoration:none; color:var(--font-primary-color)" data-ca="<?php echo $_SESSION["CA"] ?>" href="volverValidar()" href="<?php echo base_url("validacionRelmo/$nombre"); ?>" />De clic aquí para enviar correcciones</a>

            <?php
        } else if ($info["validacion"][0]["terminado"] == 5) {
            ?>
                <h2 class="text-center text-warning">Su categorización se encuentran en un estado de revisión. Mantente pendiente en los correos y en las plataforma para recibir actualizaciones de su revisión</h2>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 6) {
            ?>
                <?php
                if ($info['esquema'] == 'A') {
                ?>
                    <h1>Orden de los autores para obras</h1>
                    <p>
                        Instrucciones: Estimados investigadores, en este apartado es necesario establecer el orden correcto de los autores para el libro digital RELEG 2023, deberá realizarlo dando clic sobre el autor
                        que desea mover de posición, manteniendo el cursor sobre el autor lo podrá colocar en la posición seleccionada.
                        Una vez que los autores estén en el orden deseado, dé clic sobre el botón de Registrar orden de autores obra digital paso INDISPENSABLE para que registre el cambio el sistema,
                        dicho proceso debe realizarse a más tardar el día 03 de abril de 2023, sino lo realizan se establecerá el orden que está actualmente en plataforma.
                    </p>
                    <h3>Orden digital</h3>
                    <hr>
                    <form action="../orden_libros/digital/<?= $info['anio_investigacion'] ?>" method="post" id="form_digital">
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="digital">
                                </ul>
                            </div>
                        </div>
                        <button type="submit" id="submit_digital" class="btn btn-success btn-block">Registrar orden digital</button>
                    </form>
                <?php
                } else if ($info['esquema'] == 'B') {
                ?>
                    <h1>Orden de los autores para obras</h1>
                    <p>
                        Instrucciones: Estimados investigadores, en este apartado es necesario establecer el orden correcto de los autores para el libro digital e impreso RELEG 2023, deberá realizarlo dando clic sobre el autor
                        que desea mover de posición, manteniendo el cursor sobre el autor lo podrá colocar en la posición seleccionada.
                        Una vez que los autores estén en el orden deseado, dé clic sobre el botón de Registrar orden de autores obra digital e impresa paso INDISPENSABLE para que registre el cambio el sistema,
                        dicho proceso debe realizarse a más tardar el día 03 de abril de 2023, sino lo realizan se establecerá el orden que está actualmente en plataforma.
                    </p>
                    <h3>Orden impreso</h3>
                    <hr>
                    <form action="../orden_libros/impreso/<?= $info['anio_investigacion'] ?>" method="post" id="form_impreso">
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="impreso">
                                </ul>
                            </div>
                        </div>
                        <button type="submit" id="submit_impreso" class="btn btn-success btn-block">Registrar orden impreso</button>
                    </form>
                    <h3>Orden digital</h3>
                    <hr>
                    <form action="../orden_libros/digital/<?= $info['anio_investigacion'] ?>" method="post" id="form_digital">
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="digital">
                                </ul>
                            </div>
                        </div>
                        <button type="submit" id="submit_digital" class="btn btn-success btn-block">Registrar orden digital</button>
                    </form>
                <?php
                }
                ?>
                <hr>
                <h5 class="text-warning text-center">El proceso de análisis de resultados no permite guardar avances.</h5>
                <a href="../capitulo/<?= $_SESSION["CA"] . "/" . $info["password"] ?>" class="btn btn-info btn-block" id="btnAnalisis">Ir a proceso para análisis de resultados</a>
                <script>
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    //$("#tabla_entrevistas").empty();
                </script>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 7) {
            ?>
                <h3 class="text-center" style="color:#ffc000">
                    Investigadoras: atender una revisión implica que tiene que REENVIAR la categorización.
                    Si requiere (n) más información por favor consulte su correo o el apartado de "INICIO".
                </h3>
                <h3 class="text-center">Si desea eliminar toda su categorización e iniciar de nuevo, de clic en el siguiente botón</h3>
                <a id="eliminarCodigos" data-clave='<?= $_SESSION['CA'] ?>' class="btn btn-block btn-rounded btn-danger">Eliminar <b>TODAS</b> mis categorizaciones</a>
                <br>
                <p class='text-center'>UNA VEZ QUE <b><u>TODAS</u></b> LAS INTEGRANTES HAYAN REALIZADO EN SU TOTALIDAD LAS CORRECCIONES QUE LES FUERON INDICADAS POR EL COMITÉ REVISOR, POR FAVOR DÉ CLICK EN EL BOTÓN PARA ENVIARLO NUEVAMENTE A REVISIÓN</p>
                <a id="volverValidar2" class="btn btn-rounded btn-block bg-<?= $_SESSION['red'] ?> " style="text-decoration:none; color:var(--font-primary-color)" data-ca="<?php echo $_SESSION["CA"] ?>" href="volverValidar2()" href="<?php echo base_url("validacionRelmo/$nombre"); ?>" />De clic aquí para enviar correcciones</a>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 9) {
            ?>
                <h2 class="text-center" style="color:red">
                    Estimadas Investigadoras: lamentamos informarles que derivado de que la información obtenida de la categorización de sus entrevistas,
                    no cumple con los estándares solicitados en el protocolo de esta investigación, éstas han sido rechazadas. Para mayor información
                    sobre esta resolución, consulte su correo donde el Comité de Relmo da una explicación más amplia al respecto. Sin embargo, es
                    importante destacar que si desean continuar participando pueden enviar un correo o comunicarse directamente al siguiente número:
                    +52 1 442 879 4549, para concertar una cita vía nuestra plataforma Vive Redesla y hablar directamente con una integrante del Comité
                    Académico para abordar su caso. Muchas gracias
                </h2>
                <h3 class="text-center">Si desea eliminar toda su categorización e iniciar de nuevo, de clic en el siguiente botón</h3>
                <a id="eliminarCodigos" data-clave='<?= $_SESSION['CA'] ?>' class="btn btn-block btn-rounded btn-danger">Eliminar <b>TODAS</b> mis categorizaciones</a>
                <br>
                <p class='text-center'>UNA VEZ QUE <b><u>TODAS</u></b> LAS INTEGRANTES HAYAN REALIZADO EN SU TOTALIDAD LAS CORRECCIONES QUE LES FUERON INDICADAS POR EL COMITÉ REVISOR, POR FAVOR DÉ CLICK EN EL BOTÓN PARA ENVIARLO NUEVAMENTE A REVISIÓN</p>
                <a id="volverValidar2" class="btn btn-rounded btn-block bg-<?= $_SESSION['red'] ?> " style="text-decoration:none; color:var(--font-primary-color)" data-ca="<?php echo $_SESSION["CA"] ?>" href="volverValidar2()" href="<?php echo base_url("validacionRelmo/$nombre"); ?>" />De clic aquí para enviar correcciones</a>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 8) {
            ?>
                <h2 class="text-center text-warning">Su categorización se encuentran en un estado de revisión. Mantente pendiente en los correos y en las plataforma para recibir actualizaciones de su revisión</h2>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 10) {
            ?>
                <!-- <h3 class="text-warning text-center">Ahora el apartado de análisis de resultados se encuentra en fase de revisión. Favor de esperar instrucciones por parte del Comité Revisor RELEG.</h3> -->


                <!-- <h2>Redactar discusión de libro digital</h2>
                <p>Estimadas Investigadoras (es), PARA LLEVAR A CABO este apartado de DISCUSIONES ES NECESARIO LEER Y ANALIZAR EL DOCUEMNTO DE LA REVISIÓN DE LA LITERATURA QUE SE LES ENVIÓ Y QUE TAMBIÉN ESTA DIPONDIBLE EN ESTA SECCIÓN, AQUÍ TAMBIÉN PODRÁ VER LOS RESULTADOS DE LAS CATEGORÍAS QUE SE OBTUVIERON DE LA INFORMACIÓN Y ANÁLISIS DE SUS ENTREVISTAS. EN EL APARTADO DE DISCUSIONES, entonces se resumen e interpretan los resultados de acuerdo al contexto en el que se llevó a cabo la investigación, se analizan los RESULTADOS QUE OBTUVIERON con sus implicaciones considerando cómo ha sido la perspectiva de otros autores. Tiene un límite de caracteres de 1300 y un máximo de 2000. Muchas gracias.</p>
                <hr>
                <h3>Archivos</h3>
                <a href="../ver/resultados/impreso/<?= $info['pdfPath'] ?>" target='_blank' class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Descargar resultados de su investigación</a>
                <a href="<?= base_url('resources/pdf/REVISIÓN DE LA LITERATURA 2022-2023 - OBRA DIGITAL.pdf') ?>" target="_blank" class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Ver revisión de la literatura</a>
                <hr>
                <form action="../insertDiscusionDigital" method="post">
                    <textarea class="form-control" name="discusion" id="discusion" cols="30" rows="10" minlength="1300" maxlength="2000" placeholder="Redacte su discusión con base en la Revisión de la Literatura y los Resultados de su Investigación." required></textarea>
                    <p id="contador-caracteres">0 / 2000 caracteres</p>
                    <input type="submit" class="btn btn-block bg-<?= $_SESSION['red'] ?>" id="btn_discusion" value="Enviar discusión">
                </form> -->
                <script>
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    //$("#tabla_entrevistas").empty();
                </script>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 11) {
            $entro = true;
            ?>
                <!-- <h3 class="text-success text-center">Su análisis de resultados para el libro impreso ha sido aceptado.</h3> -->
                <script>
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    //$("#tabla_entrevistas").empty();
                </script>

                <!-- <h2>Redactar discusión de libro digital</h2>
                <p>Estimadas Investigadoras (es), PARA LLEVAR A CABO este apartado de DISCUSIONES ES NECESARIO LEER Y ANALIZAR EL DOCUEMNTO DE LA REVISIÓN DE LA LITERATURA QUE SE LES ENVIÓ Y QUE TAMBIÉN ESTA DIPONDIBLE EN ESTA SECCIÓN, AQUÍ TAMBIÉN PODRÁ VER LOS RESULTADOS DE LAS CATEGORÍAS QUE SE OBTUVIERON DE LA INFORMACIÓN Y ANÁLISIS DE SUS ENTREVISTAS. EN EL APARTADO DE DISCUSIONES, entonces se resumen e interpretan los resultados de acuerdo al contexto en el que se llevó a cabo la investigación, se analizan los RESULTADOS QUE OBTUVIERON con sus implicaciones considerando cómo ha sido la perspectiva de otros autores. Tiene un límite de caracteres de 1300 y un máximo de 2000. Muchas gracias.</p>
                <hr>
                <h3>Archivos</h3>
                <a href="../ver/resultados/impreso/<?= $info['pdfPath'] ?>" target='_blank' class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Descargar resultados de su investigación</a>
                <a href="<?= base_url('resources/pdf/REVISIÓN DE LA LITERATURA 2022-2023 - OBRA DIGITAL.pdf') ?>" target="_blank" class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Ver revisión de la literatura</a>
                <hr>
                <form action="../insertDiscusionDigital" method="post">
                    <textarea class="form-control" name="discusion" id="discusion" cols="30" rows="10" minlength="1300" maxlength="2000" placeholder="Redacte su discusión con base en la Revisión de la Literatura y los Resultados de su Investigación." required></textarea>
                    <p id="contador-caracteres">0 / 2000 caracteres</p>
                    <input type="submit" class="btn btn-block bg-<?= $_SESSION['red'] ?>" id="btn_discusion" value="Enviar discusión">
                </form> -->

                <?php
                if ($info['esquema'] == 'B') {
                    $_SESSION['esquema'] = 'B';
                ?>

                    <!-- <a href="../capitulo/digital/<?php // $_SESSION["CA"] . "/" . $info["password"] 
                                                        ?>" class="btn btn-block btn-info">Ir a libro digital</a> -->
                <?php
                }
                ?>

            <?php
        } else if ($info["validacion"][0]["terminado"] == 12) {
            ?>
                <h3 class="text-warning text-center">
                    Su análisis de resultados ha sido reenviado para su corrección por el Comité Revisor RELEG.
                    Para editar su análisis, de clic en el botón <label class="text-info">Editar su análisis de resultados</label> y edite los apartados que se le habiliten.
                </h3>
                <a href="../capitulo/editar/<?= $_SESSION["CA"] . "/" . $info["password"] ?>" class="btn btn-info btn-block">Editar su análisis de resultados</a>
                <script>
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    //$("#tabla_entrevistas").empty();
                </script>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 13) {
            ?>
                <!-- <h3 class="text-warning text-center">El apartado de análisis de resultados se encuentra en fase de revisión. Favor de esperar instrucciones por parte del Comité Revisor RELEG.</h3> -->


                <!-- <h2>Redactar discusión de libro digital</h2>
                <p>Estimadas Investigadoras (es), PARA LLEVAR A CABO este apartado de DISCUSIONES ES NECESARIO LEER Y ANALIZAR EL DOCUEMNTO DE LA REVISIÓN DE LA LITERATURA QUE SE LES ENVIÓ Y QUE TAMBIÉN ESTA DIPONDIBLE EN ESTA SECCIÓN, AQUÍ TAMBIÉN PODRÁ VER LOS RESULTADOS DE LAS CATEGORÍAS QUE SE OBTUVIERON DE LA INFORMACIÓN Y ANÁLISIS DE SUS ENTREVISTAS. EN EL APARTADO DE DISCUSIONES, entonces se resumen e interpretan los resultados de acuerdo al contexto en el que se llevó a cabo la investigación, se analizan los RESULTADOS QUE OBTUVIERON con sus implicaciones considerando cómo ha sido la perspectiva de otros autores. Tiene un límite de caracteres de 1300 y un máximo de 2000. Muchas gracias.</p>
                <hr>
                <h3>Archivos</h3>
                <a href="../ver/resultados/impreso/<?= $info['pdfPath'] ?>" target='_blank' class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Descargar resultados de su investigación</a>
                <a href="<?= base_url('resources/pdf/REVISIÓN DE LA LITERATURA 2022-2023 - OBRA DIGITAL.pdf') ?>" target="_blank" class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Ver revisión de la literatura</a>
                <hr>
                <form action="../insertDiscusionDigital" method="post">
                    <textarea class="form-control" name="discusion" id="discusion" cols="30" rows="10" minlength="1300" maxlength="2000" placeholder="Redacte su discusión con base en la Revisión de la Literatura y los Resultados de su Investigación." required></textarea>
                    <p id="contador-caracteres">0 / 2000 caracteres</p>
                    <input type="submit" class="btn btn-block bg-<?= $_SESSION['red'] ?>" id="btn_discusion" value="Enviar discusión">
                </form> -->
                <script>
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                </script>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 14) {
            ?>
                <h3 class="text-danger text-center">
                    Su análisis de resultados ha sido rechazado por el Comité Revisor RELEG.
                    Para editar su análisis, de clic en el botón <label class="text-info">Editar su análisis de resultados</label> y edite los apartados que se le habiliten.
                </h3>
                <a href="../capitulo/editar/<?= $_SESSION["CA"] . "/" . $info["password"] ?>" class="btn btn-info btn-block">Editar su análisis de resultados</a>
                <script>
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    //$("#tabla_entrevistas").empty();
                </script>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 15) {
            ?>
                <h3 class="text-warning text-center">La discusión del capitulo digital RELEG se encuentra en revisión</h3>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 16) {
            ?>
                <h3 class="text-warning text-center">
                    Su discusión ha sido reenviada por el Comité Revisor RELEG.
                    Para editar su discusión, de clic en el botón <label class="text-info">Editar discusión</label>.
                </h3>
                <a href="../capitulo/digital/editar/<?= $_SESSION["CA"] . "/" . $info["password"] ?>" class="btn btn-info btn-block">Editar discusión</a>
                <script>
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    //$("#tabla_entrevistas").empty();
                </script>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 17) {
            ?>
                <h3 class="text-danger text-center">
                    Su discusión ha sido rechazada por el Comité Revisor RELEG.
                    Para editar su discusión, de clic en el botón <label class="text-info">Editar discusión</label>.
                </h3>
                <a href="../capitulo/digital/editar/<?= $_SESSION["CA"] . "/" . $info["password"] ?>" class="btn btn-info btn-block">Editar discusión</a>
                <script>
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    //$("#tabla_entrevistas").empty();
                </script>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 18) {
            ?>
                <h3 class="text-success text-center">
                    Su discusión ha sido aceptada para el libro digital RELEG 2022 por el Comité Revisor RELEG.
                </h3>
                <script>
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    //$("#tabla_entrevistas").empty();
                </script>
            <?php
        } else if ($info["validacion"][0]["terminado"] == 19) {
            ?>
                <h3 class="text-warning text-center">
                    Su discusión esta en proceso de revisión por el Comité Revisor RELEG.
                </h3>
                <script>
                    $("button[name='eliminar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='recapturar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    $("button[name='editar']").prop('disabled', true).attr('title', 'No permitido en la fase actual.')
                    //$("#tabla_entrevistas").empty();
                </script>
                <?php
            }

            if ($info['esquema'] == 'B') {
                if ($info['discusion_exist'] === false) {
                ?>
                    <h2>Redactar discusión</h2>
                    <p>Estimadas Investigadoras (es), PARA LLEVAR A CABO este apartado de DISCUSIONES ES NECESARIO LEER Y ANALIZAR EL APARTADO DE LA REVISIÓN DE LA LITERATURA QUE SE LE ENVIÓ, ASÍ COMO AQUÍ TAMBIÉN PODRÁ VER LOS RESULTADOS DE LAS CATEGORÍAS QUE SE OBTUVIERON DE LA INFORMACIÓN Y ANÁLISIS QUE SE OBTUVO DE SUS ENTREVISTAS. EN EL APARTADO DE DISCUSIONES, entonces se resumen e interpretan los resultados de acuerdo al contexto en el que se llevó a cabo la investigación, se analizan los RESULTADOS QUE OBTUVIERON con sus implicaciones considerando cómo ha sido la perspectiva de otros autores. Tiene un límite de caracteres de 1300 y un máximo de 2000. Muchas gracias.</p>
                    <hr>
                    <h3>Archivos</h3>
                    <a href="../ver/resultados/impreso/<?= $info['pdfPath'] ?>" target='_blank' class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Descargar resultados de su investigación (libro impreso)</a>
                    <a href="<?= base_url('resources/pdf/REVISIÓN DE LA LITERATURA 2022-2023.pdf') ?>" target="_blank" class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Ver revisión de la literatura</a>
                    <hr>
                    <form action="../insertDiscusion" method="post">
                        <textarea class="form-control" name="discusion" id="discusion" cols="30" rows="10" minlength="1300" maxlength="2000" placeholder="Redacte su discusión con base en la Revisión de la Literatura y los Resultados de su Investigación." required></textarea>
                        <p id="contador-caracteres">0 / 2000 caracteres</p>
                        <input type="submit" class="btn btn-block bg-<?= $_SESSION['red'] ?>" id="btn_discusion" value="Enviar discusión">
                    </form>
            <?php
                }else{
                    if($entro === false){
                        ?>
                        <!-- <h2>Redactar discusión de libro digital</h2>
                        <p>Estimadas Investigadoras (es), PARA LLEVAR A CABO este apartado de DISCUSIONES ES NECESARIO LEER Y ANALIZAR EL DOCUEMNTO DE LA REVISIÓN DE LA LITERATURA QUE SE LES ENVIÓ Y QUE TAMBIÉN ESTA DIPONDIBLE EN ESTA SECCIÓN, AQUÍ TAMBIÉN PODRÁ VER LOS RESULTADOS DE LAS CATEGORÍAS QUE SE OBTUVIERON DE LA INFORMACIÓN Y ANÁLISIS DE SUS ENTREVISTAS. EN EL APARTADO DE DISCUSIONES, entonces se resumen e interpretan los resultados de acuerdo al contexto en el que se llevó a cabo la investigación, se analizan los RESULTADOS QUE OBTUVIERON con sus implicaciones considerando cómo ha sido la perspectiva de otros autores. Tiene un límite de caracteres de 1300 y un máximo de 2000. Muchas gracias.</p>
                        <hr>
                        <h3>Archivos</h3>
                        <a href="../ver/resultados/impreso/<?= $info['pdfPath'] ?>" target='_blank' class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Descargar resultados de su investigación</a>
                        <a href="<?= base_url('resources/pdf/REVISIÓN DE LA LITERATURA 2022-2023 - OBRA DIGITAL.pdf') ?>" target="_blank" class="btn bg-<?= $_SESSION['red'] ?>" style="text-decoration:none; color:var(--font-primary-color)">Ver revisión de la literatura</a>
                        <hr>
                        <form action="../insertDiscusionDigital" method="post">
                            <textarea class="form-control" name="discusion" id="discusion" cols="30" rows="10" minlength="1300" maxlength="2000" placeholder="Redacte su discusión con base en la Revisión de la Literatura y los Resultados de su Investigación." required></textarea>
                            <p id="contador-caracteres">0 / 2000 caracteres</p>
                            <input type="submit" class="btn btn-block bg-<?= $_SESSION['red'] ?>" id="btn_discusion" value="Enviar discusión">
                        </form> -->
                        <?php
                    }
                }
            }
            ?>
            <script>
                let impreso = '<?= $info['impreso'] ?>'
                let digital = '<?= $info['digital'] ?>'
                let anio = '<?= $info['anio_investigacion'] ?>'
            </script>
            <script src="<?= base_url('resources/js/investigaciones/orden_libros.js') ?>"></script>
            <script src="<?= base_url('resources/js/investigaciones/Releg_2022.js') ?>"></script>
        <?php
    }
        ?>