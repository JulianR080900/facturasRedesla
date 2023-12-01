<div class="content">

    <div class="row">

        <div class="col-md-12">

            <h2>Carpetas</h2>

            <hr>

        </div>

        <hr>

    </div>
    <style>
        .active{
            color: var(--font-color-primary) !important;
        }

        .nav-link.active{
            color: #000 !important;
        }
    </style>


    <div class="row">

        <div class="container">

            <div class="card-header tab-regular card-carpetas">

                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">

                    <?php
                    foreach ($carpetas as $key => $li) {
                        if ($li['ano_carpeta'] == date('Y')) {
                    ?>
                            <li class="nav-item item-carpetas">

                                <a class="nav-link active show" id="card-tab-<?= $key; ?>" data-toggle="tab" href="#<?= $li["ano_carpeta"] ?>" role="tab" aria-controls="card-<?= $key; ?>" aria-selected="true"><?= $li["ano_carpeta"] ?></a>

                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item item-carpetas">

                                <a class="nav-link" id="card-tab-<?= $key; ?>" data-toggle="tab" href="#<?= $li["ano_carpeta"] ?>" role="tab" aria-controls="card-<?= $key; ?>" aria-selected="true"><?= $li["ano_carpeta"] ?></a>

                            </li>
                    <?php

                        }
                    }

                    $i = 1;

                    ?>

                </ul>

            </div>

            <?php
            foreach($carpetas as $key=>$c){
                if($key == 0){
                    ?>
                    <div data-role="content" id="<?= $c['ano_carpeta'] ?>" class="card-body card-body-carpetas">
                    <?php
                }else{
                    ?>
                    <div data-role="page" id="<?= $c['ano_carpeta'] ?>" class="card-body card-body-carpetas">
                    <?php
                }
                ?>
                <!-- AQUI VA EL CONTENIDO DE CADA AñO -->
                <h3>1.- Descargar el archivo con su capítulo preliminar</h3>
                <p>En la carpeta de archivos enviados por <?= strtoupper($_SESSION['red']) ?>, misma que encontrará identificada con la clave <b><?= $_SESSION['CA'] ?></b>.</p>
                <iframe src="https://drive.google.com/embeddedfolderview?id=<?= $c["envios"] ?>#grid" style="width:100%; height:300px; border:0;background-color:lightgray;"></iframe>
                <a href="https://drive.google.com/drive/u/0/folders/<?= $c["envios"] ?>" target="_blank" class="btn btn-rounded bg-<?= $_SESSION['red'] ?> btn-block btn-carpetas">Abrir carpeta de envíos por parte de <?= $_SESSION['CA'] ?></a>
                <hr>
                <h3>2.- Completar redactacción de capítulo</h3>
                <a target="_blank" href="<?php echo base_url("resources/pdf/Descarga y envío de capitulo.pdf") ?>"><i class="fas fa-book"></i> Descargar Manual</a>
                <?php
                switch ($_SESSION['red']) {
                    case 'Relep':
                        ?>
                        <p>
                            <ol type="A">
                                <li>Deberán desarrollar el resumen y la discusión de los resultados:</li>
                                <ul>
                                    <li>En el resumen deberá complementar esta sección de acuerdo con los resultados recabados en su levantamiento, se podrán agregar un máximo de 100 palabras y un mínimo de 60 palabras.</li>
                                    <li>La discusión debe tener de 250 a 500 palabras y debe interpretar los resultados enfocándose igualmente en las características de la zona que abordan ustedes.</li>
                                    <li>Por favor no rebasen el límite que se les marca. Sólo redacten en donde hay indicaciones de redacción dentro del capítulo modelo, no borren, ni cambien nada del resto del texto ya que debe ser genérico para todos los capítulos. Si dentro de alguna de las redacciones (resumen o discusión), cita a otros autores, favor de enviar sus referencias para incluirlas, marcándolas en amarillo.</li>
                                </ul>
                                <li>No está permitido cambiar a los autores del capítulo. Los autores del capítulo deben ser forzosamente los que están registrados como miembros. No puede agregar a un autor que no sea miembro de su grupo de investigación registrado en el año actual.</li>
                                <li>Es de suma importancia recordar que deben revisar su capítulo completo.</li>
                                <li>Una vez que envíe el documento completo, se enviará a la casa editorial para la limpieza del formato del capítulo final y no podrá haber ninguna modificación.</li>
                            </ol>
                        </p>
                        <?php
                        break;
                    case 'Relen':
                        ?>
                        <p>
                            <ol type="A">
                                <li>Deberán desarrollar el resumen y la discusión de los resultados:</li>
                                <ul>
                                    <li>En el resumen deberá complementar esta sección de acuerdo con los resultados recabados en su levantamiento, se podrán agregar un máximo de 100 palabras y un mínimo de 60 palabras.</li>
                                    <li>La discusión debe tener de 250 a 500 palabras y debe interpretar los resultados enfocándose igualmente en las características de la zona que abordan ustedes.</li>
                                    <li>Por favor no rebasen el límite que se les marca. Sólo redacten en donde hay indicaciones de redacción dentro del capítulo modelo, no borren, ni cambien nada del resto del texto ya que debe ser genérico para todos los capítulos. Si dentro de alguna de las redacciones (resumen o discusión), cita a otros autores, favor de enviar sus referencias para incluirlas, marcándolas en amarillo.</li>
                                </ul>
                                <li>No está permitido cambiar a los autores del capítulo. Los autores del capítulo deben ser forzosamente los que están registrados como miembros. No puede agregar a un autor que no sea miembro de su grupo de investigación registrado en el año actual.</li>
                                <li>Es de suma importancia recordar que deben revisar su capítulo completo.</li>
                                <li>Una vez que envíe el documento completo, se enviará a la casa editorial para la limpieza del formato del capítulo final y no podrá haber ninguna modificación.</li>
                            </ol>
                        </p>
                        <?php
                        break;
                    case 'Relayn';
                        ?>
                        <p>
                            <ol type="A">
                                <li>Deberán desarrollar el resumen y la discusión de los resultados:</li>
                                <ul>
                                    <li>En el resumen deberá complementar esta sección de acuerdo con los resultados recabados en su levantamiento, se podrán agregar un máximo de 100 palabras y un mínimo de 60 palabras.</li>
                                    <li>La discusión debe tener de 250 a 500 palabras y debe interpretar los resultados enfocándose igualmente en las características de la zona que abordan ustedes.</li>
                                    <li>Por favor no rebasen el límite que se les marca. Sólo redacten en donde hay indicaciones de redacción dentro del capítulo modelo, no borren, ni cambien nada del resto del texto ya que debe ser genérico para todos los capítulos. Si dentro de alguna de las redacciones (resumen o discusión), cita a otros autores, favor de enviar sus referencias para incluirlas, marcándolas en amarillo.</li>
                                </ul>
                                <li>No está permitido cambiar a los autores del capítulo. Los autores del capítulo deben ser forzosamente los que están registrados como miembros. No puede agregar a un autor que no sea miembro de su grupo de investigación registrado en el año actual.</li>
                                <li>Es de suma importancia recordar que deben revisar su capítulo completo.</li>
                                <li>Una vez que envíe el documento completo, se enviará a la casa editorial para la limpieza del formato del capítulo final y no podrá haber ninguna modificación.</li>
                            </ol>
                        </p>
                        <?php
                        break;
                }
                ?>
                <hr>
                <h3>3.- Subir archivos finales.</h3>
                <hr>
                <p>En la carpeta de Recibidos podrá integrar los archivos completados en los formatos solicitados por parte de <?= strtoupper($_SESSION['red']) ?>: capítulo (s), carta (s) de cesión de derechos y vo.bo., preliminares, logo u algún otro documento solicitado para su Grupo de Investigación (GI).</p>
                <?php
                if($_SESSION['red'] == 'Releg' && $c['ano_carpeta'] == 2022){
                    ?>
                    <a href="<?= $c["recibidos"] ?>" target="_blank" class="btn btn-rounded bg-<?= $_SESSION['red'] ?> btn-block btn-carpetas">Abrir carpeta de recibidos del GI para <?= $_SESSION['red'] ?></a>
                    <?php
                }else{
                    ?>
                    <iframe src="https://drive.google.com/embeddedfolderview?id=<?= $c["recibidos"] ?>#grid" style="width:100%; height:300px; border:0;background-color:lightgray;"></iframe>
                    <a href="https://drive.google.com/drive/u/0/folders/<?= $c["recibidos"] ?>" target="_blank" class="btn btn-rounded bg-<?= $_SESSION['red'] ?> btn-block btn-carpetas">Abrir carpeta de recibidos del GI para <?= $_SESSION['red'] ?></a>
                    <?php
                }
                ?>
                
                <hr>
                <p>
                Una vez que envíe el documento completo, se enviará a la casa editorial para producir la versión definitiva del capítulo.
                </p>
                <p>
                Es de suma importancia recordar que deben revisar su capítulo completo y si existe alguna observación, deberá de comunicarse con la Ing. Sylvia Chávez a los siguientes datos de contacto:
                </p>
                <p>
                Cel. WhatsApp: 427 172 07 01<br>
                Tel: 4271389926<br>
                Correo electrónico: svchavez@redesla.la<br>
                </p>
                <!-- SE TERMINA EL DIV DE CADA CARPETA -->
                </div>
                <?php
            }
            ?>

        </div>

    </div>

</div>

<script>
    $(".card-body-carpetas").hide()
    $("div[data-role='content']").show()
    $("a[data-toggle=tab]").on('click',function(e){
        let anio = e.target.innerHTML
        $("div.card-body-carpetas").hide()
        $("div#"+anio).show()
    })
</script>