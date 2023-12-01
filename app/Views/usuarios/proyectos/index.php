<?php

function imprimirClavesGafete($infoGafetes)
{
?>
    <div class="row">
        <?php
        foreach ($infoGafetes as $gafete) {
        ?>
            <div class="col-md-3" style="margin: 0 auto;">
                <div class="card text-white bg-dark" style="margin-bottom: 10px;">
                    <div class="card-body text-center">
                        <img src="https://redesla.net/RedesLa/resources/img/avatar.svg" alt="avatar" class="avatar">
                        <h3>Nombre</h3>
                        <label for=""><?php echo $gafete["nombre"] ?></label><br>
                        <h3>Clave de gafete</h3>
                        <label for=""><?php echo $gafete["clave_gafete"] ?></label>
                        <h3>ID IQuatroEditores</h3>
                        <label for=""><?php echo $gafete["publication_id"] ?></label>
                        <hr>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
<?php
}

function bienvenida()
{
?>
    <h1>Apreciable investigador(a)</h1>
    <label style="font-size: 20px">Gracias por ser parte del <b>1er. Congreso Latinoamericano de Investigación en Eléctrica, Electrónica y Mecatrónica RELEEM 2021</b>. Dicho evento se llevará a cabo el día 22 de octubre del 2021, bajo modalidad virtual dentro de nuestro espacio virtual <b>¡Vive RedesLA!</b>, teniendo como institución anfitriona a la <b>Universidad Autónoma de Zacatecas "Francisco García Salinas" (Unidad Académica de Ingeniería Eléctrica)</b>, quiénes en conjunto con <b>REDESLA</b> (Redes de Estudios Latinoamericanos) a quien pertenece <b>RELEEM</b>, llevarán acabo la organización de este Congreso de Investigación.
        Usted podrá cceder a nuestro espacio virtual <b>"Vive RedesLA"</b> desde esta liga: <a href="https://congreso.releem.org">https://congreso.releem.org</a>
        <b>¡Los esperamos!</b> Que disfrute al máximo de nuestro evento.</label>
    <hr>
    <h1>Participantes</h1><br>
    <?php
}

function investigacionRelep2021($nombre)
{
    $array_ca_falta_municipio = array("MXP-CUSUG01", "MXP-UASI01");
    if (in_array($_SESSION["CA"], $array_ca_falta_municipio)) {
        echo "<h2>Estimado participante para poder habilitar los accesos a sus encuestas en necesario confirmar con el equipo RELEP lo siguiente: <br>
                • Estado <br>
                • Municipio <br>
                • Institución/Universidad en la que se aplicará el estudio <br>
                • Facultades/Carreras en las que aplicarán el estudio <br><br>
            Dejamos a continuación los medios de contacto a través de los cuales les daremos la atención debida:<br>
            Correo: chernandezm@redesla.net  <br>
            WhatsApp  +52 4778433415
                </h2>";
    } else {

    ?>
        <div class="card card-body-congresos">
            <div class="card-header card-header-congresos">
                <h2>Competencias digitales, resiliencia y percepción de inclusión académica en estudiantes de educación superior</h2>
            </div>
            <hr>
            <ol>
                <h2>
                    <li>Objetivo</li>
                </h2>
                <p>Estudiar la relación entre la inclusión, las competencias digitales y la resiliencia de los estudiantes de instituciones de educación superior en el contexto local y las particularidades de las especialidades estudiadas.</p>
                <h2>
                    <li>Materiales de la investigación</li>
                </h2>
                <ul>
                    <li>Video de habilitación de miembros investigadores:</li>
                    <a href="">Click para ver el video</a>
                </ul>
                <ul>
                    <li>Carpeta compartida general:</li>
                    <a href="<?php echo $_SESSION["carpetas_comunes"][0]["url"] ?>">Click para abrir la carpeta compartida general</a>
                    <p><b>Esta carpeta contiene</b></p>
                    <ol type="a">
                        <li>Diapositivas de capacitación para los miembros investigadores de RELEP</li>
                        <li>Diapositivas para capacitar a los encuestadores (Alumnos)</li>
                        <li>Cuestionario en Excel para rellenar en caso de fallas de internet (uno por país).</li>
                        <li>Cuestionario en PDF para rellenar en caso de convivencia con el universitario (uno por país).</li>
                        <li>Convocatoria a 2a investigación anual 2021</li>
                    </ol>
                </ul>
                <h2>
                    <li>Formularios de captura</li>
                </h2>
                <?php
                foreach ($_SESSION["carpetas"] as $carpeta) {
                    if ($carpeta["ano_carpeta"] == 2021) {
                ?>
                        <ul>
                            <li>Los accesos de esta sección son específicamente para el grupo <b class="n_Relep"><?php echo $_SESSION["CA"] ?></b></li>
                            <a href="https://drive.google.com/drive/folders/<?php echo $carpeta["envios"]; ?>?usp=sharing">https://drive.google.com/drive/folders/<?php echo $carpeta["envios"]; ?>?usp=sharing</a>
                        </ul>
                        <ul>
                            <li>Base de datos para que ustedes verifiquen el trabajo de sus alumnos y para que al final validen los registros válidos según se explica en la capacitación:</li>
                            <a href="<?php echo $carpeta["validacion"] ?>"><?php echo $carpeta["validacion"] ?></a>
                        </ul>
                        <ul>
                            <li>Base de datos para que los alumnos consulten los folios ya capturados:</li>
                            <a href="<?php echo $carpeta["alumnos"] ?>"><?php echo $carpeta["alumnos"] ?></a>
                        </ul>
                        <ul>
                            <li>Formulario para que los participantes y/o los encuestadores capturen sus respuestas:</li>
                            <a href="<?php echo $carpeta["formulario"] ?>"><?php echo $carpeta["formulario"] ?></a>
                        </ul>
                <?php
                    }
                }
                ?>


                <h3>Les sugerimos que envíen a sus alumnos un mensaje parecido a este, sea por correo electrónico, Moodle, etc:</h3>
                <p>Estimados alumnos</p>
                <p>Les compartimos el enlace para que hagan la captura de los cuestionarios:</p>
                <p><a href="<?php echo $carpeta["formulario"] ?>"><?php echo $carpeta["formulario"] ?></a></p>
                <p>Si quieren hacer el cuestionario en Excel o en papel y después capturarlo, les dejamos los accesos directos:</p>
                <p>Excel: <a href="<?php echo $_SESSION["carpetas_comunes"][0]["url"] ?>" style="color:#4C87FB;"><?php echo $_SESSION["carpetas_comunes"][0]["url"] ?></a> </p><!-- Pendiente -->
                <p>PDF: <a href="<?php echo $_SESSION["carpetas_comunes"][0]["url"] ?>" style="color:#4C87FB;"><?php echo $_SESSION["carpetas_comunes"][0]["url"] ?></a> </p> <!-- Pendiente -->
                <p>Gracias de antemano, para cualquier duda estamos a sus órdenes.</p>
                <p>Atte. Profesor de la carrera.</p>
                <h2>
                    <li>Validación</li>
                </h2>
                <?php
                echo $nombre;
                if (empty($_SESSION["validacion"])) {
                ?>
                    <ul>
                        <li>
                            <p>Si usted ya finalizo correctamente de validar los cuestionarios mediante el archivo de validación disponible en sus carpetas de acuerdo al criterio establecido por la red, por favor de click en el siguiente botón:</p>
                        </li>
                        <br>
                        <a class="btn btn-rounded btn-lg btn-success" href="<?php echo base_url("validacionRelep/$nombre"); ?>" />Fin de validación</a>
                    </ul>
                <?php
                } else if ($_SESSION["validacion"][0]["terminado"] == 1) {
                ?>
                    <ul>
                        <li>
                            <p>Apreciable investigador, usted ha registrado la finalización de su validación, enviaremos la notificación a los coordinadores para que verifiquen la correcta evaluación. Le daremos una respuesta dentro de un plazo de 15 a 20 días, en caso de haberse realizado correctamente le notificaremos en este mismo sitio.
                                Si hubiese algún error en su evaluación les notificaremos vía correo electrónico y le habilitaremos nuevamente el botón fin de validación</p>
                        </li>
                        <li>
                            <p>Gracias por tu compromiso.</p>
                        </li>
                    </ul>

                <?php
                } else if ($_SESSION["validacion"][0]["terminado"] == 2) {
                ?>
                    <ul>
                        <li>
                            <p>Apreciable investigador, le notificamos que su validación fue realizada correctamente. La siguiente etapa será la redacción de capítulos, para esta etapa los coordinadores les notificarán.</p>
                        </li>
                        <li>
                            <p>Agradecemos tu compromiso.</p>
                        </li>
                    </ul>
                <?php
                } else if ($_SESSION["validacion"][0]["terminado"] == 0) {
                ?>
                    <ul>
                        <li>
                            <p>Su validación ha sido rechazada. Si usted ya finalizo correctamente de validar los cuestionarios mediante el archivo de validación disponible en sus carpetas de acuerdo al criterio establecido por la red, por favor de click en el siguiente botón:</p>
                        </li>
                        <br>
                        <a class="btn btn-rounded btn-lg btn-success" href="<?php echo base_url("validacionRelep/$nombre"); ?>" />Fin de validación</a>
                    </ul>
                <?php
                }
                ?>






            </ol>
        </div>
    <?php
    }
}

function investigacionRelen2022($nombre, $info)
{
    ?>
    <div class="card card-body-congresos">
        <div class="card-header card-header-congresos">
            <h2>2DA. INVESTIGACIÓN EN EDUCACIÓN NORMAL 2021</h2>
        </div>
        <hr>
        <h2>
            <li>Objetivo</li>
        </h2>
        <p>Identificar los retos que enfrentan los docentes de educación básica y media al regresar a la educación presencial, luego de la contingencia sanitaria por COVID-19 y analizar los saberes y herramientas que utilizan para enfrentarlos, con una perspectiva comparativa entre las zonas y contextos abordados..</p>
        <h2>
            <li>Materiales de la investigación</li>
        </h2>
        <ul>
            <li>Video de habilitación de miembros investigadores:</li>
            <a href="<?php echo $info["carpetas_comunes"]["video_miembros"] ?>">Click para ver el video</a>
        </ul>
        <ul>
            <li>Carpeta compartida general:</li>
            <a href="<?php echo $info["carpetas_comunes"]["url"] ?>">Click para abrir la carpeta compartida general</a>
            <p><b>Esta carpeta contiene</b></p>
            <ol type="a">
                <li>Diapositivas de capacitación para los miembros investigadores de RELEN</li>
                <li>Diapositivas para capacitar a los encuestadores (Alumnos)</li>
                <li>Cuestionario en Excel para rellenar en caso de fallas de internet (uno por país).</li>
                <li>Cuestionario en PDF para rellenar en caso de convivencia con el docente entrevistado.</li>
                <li>Convocatoria a 2a investigación anual 2022</li>
            </ol>
        </ul>
        <h2>
            <li>Formularios de captura</li>
        </h2>
        <ul>
            <li>Los accesos de esta sección son específicamente para el grupo <b class="n_Relen"><?php echo $_SESSION["CA"] ?></b></li>
            <a href="https://drive.google.com/drive/folders/<?php echo $info["carpeta"]["envios"] ?>?usp=sharing">https://drive.google.com/drive/folders/<?php echo $info["carpeta"]["envios"]; ?>?usp=sharing</a>
        </ul>
        <ul>
            <li>Base de datos para que ustedes verifiquen el trabajo de sus alumnos y para que al final validen los registros válidos según se explica en la capacitación:</li>
            <a href="<?php echo $info["carpeta"]["validacion"] ?>"><?php echo $info["carpeta"]["validacion"] ?></a>
        </ul>
        <ul>
            <li>Base de datos para que los alumnos consulten los folios ya capturados:</li>
            <a href="<?php echo $info["carpeta"]["alumnos"] ?>"><?php echo $info["carpeta"]["alumnos"] ?></a>
        </ul>
        <ul>
            <li>Formulario para que los participantes y/o los encuestadores capturen sus respuestas:</li>
            <a href="<?php echo $info["carpeta"]["formulario"] ?>"><?php echo $info["carpeta"]["formulario"] ?></a>
        </ul>
        <h3>Les sugerimos que envíen a sus alumnos un mensaje parecido a este, sea por correo electrónico, Moodle, etc:</h3>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Estimados alumnos</h5>
                <p style="background-color:transparent">Les compartimos el enlace para que hagan la captura de los cuestionarios:</p>
                <p style="background-color:transparent"><a href="<?php echo $info["carpeta"]["formulario"] ?>"><?php echo $info["carpeta"]["formulario"] ?></a></p>
                <p style="background-color:transparent">Si quieren hacer el cuestionario en Excel o en papel y después capturarlo, les dejamos los accesos directos:</p>
                <p style="background-color:transparent">Excel: <a href="<?php echo $info["carpetas_comunes"]["excel"] ?>" style="color:#4C87FB;"><?php echo $info["carpetas_comunes"]["excel"] ?></a> </p><!-- Pendiente -->
                <p style="background-color:transparent">PDF: <a href="<?php echo $info["carpetas_comunes"]["pdf"] ?>" style="color:#4C87FB;"><?php echo $info["carpetas_comunes"]["pdf"] ?></a> </p> <!-- Pendiente -->
                <p style="background-color:transparent">Gracias de antemano, para cualquier duda estamos a sus órdenes.</p>
                <p style="background-color:transparent">Atte. Profesor de la carrera.</p>

            </div>
        </div>

        <h2>
            <li>Validación</li>
        </h2>
        <?php
        if (empty($info["validacion"])) {
        ?>
            <ul>
                <li>
                    <p>Si usted ya terminó de validar los cuestionarios mediante el archivo de validación disponible en sus carpetas de acuerdo al criterio establecido por la red,
                        por favor de click en el siguiente botón:</p>
                </li>
                <br>
                <a href="<?php echo base_url("validacionRelen/$nombre"); ?>" style="text-decoration:none; color: var(--font-color-primary);" />
                <button class="btn btn-rounded bg-<?= $_SESSION['red'] ?>">Fin de validación</button>
                </a>
            </ul>
        <?php
        } else if ($info["validacion"][0]["terminado"] == 1) {
        ?>
            <ul>
                <li>
                    <p>Apreciable investigador, usted ha terminado su validación, enviaremos la notificación a los coordinadores de Relen para
                        que verifiquen la correcta evaluación. Le daremos una respuesta dentro de un plazo de 15 días como máximo, en caso de haberse realizado correctamente
                        le notificaremos en este mismo sitio.
                        Si hubiese algún error en su evaluación les notificaremos vía correo electrónico y le habilitaremos nuevamente el botón de 'Fin de validación'</p>
                </li>
                <li>
                    <p>Gracias por tu compromiso.</p>
                </li>
            </ul>
        <?php
        } else if ($info["validacion"][0]["terminado"] == 2) {
        ?>
            <ul>
                <li>
                    <p>Apreciable investigador, le notificamos que su validación fue realizada correctamente.
                        La siguiente etapa será la redacción de capítulos, espere la notificación de los coordinadores de Relen en los próximos meses.</p>
                </li>
                <li>
                    <p>Agradecemos tu compromiso.</p>
                </li>
            </ul>
            <?php

            if ($_SESSION["lider"] == 1 && $nombre == "Esquema B: Investigacion Relen 2021-2022") { //Condicion si es el lider, tambien si es Esquema A: Investigacion Relayn 2022 es solamente digital
            ?>
                <div hidden>
                    <h2>
                        <li>Orden de autores: libro impreso</li>
                        <!--ESTO TAMBIEN VA CONDICIONADO-->
                    </h2>

                    <p>
                        A continuación, se muestran los nombres y orden de los autores para el libro impreso, le pedimos amablemente que verifique si son correctos y no presentan errores de ortografía, tal como están escritos serán publicados. <br>

                        Para registrar el orden se deberá mover/arrastrar en el orden correcto de los autores, será de forma ascendente siendo el primer el de arriba y el último autor el de abajo. Esta acción es necesaria y de no realizarla estaremos usando el orden de la plataforma siendo el líder el primer autor. <br>

                        Una vez que se haya elegido el orden debe dar clic en el botón <b>Confirmar orden de autores</b>. Si usted desea que algún autor no aparezca en la obra, deberá colocarlo como último autor y notificarlo al siguiente correo: <b>svchavezv@e.redesla.net</b>, en caso de no realizar esta notificación no podremos eliminarlo de la obra.<br>
                    </p>
                    <div class="wrapper" id="lista_impreso">
                        <?php
                        foreach ($info["miembros"] as $m) {
                        ?>
                            <div class="item" data-id="<?= $m['id'] ?>">
                                <label class="label" type="text" /><?php echo $m["orden_impreso"] . ".- " . $m["nombreCompleto"] ?></label>
                                <input type="text" hidden id="d_<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                            </div>
                        <?php
                            $existe2 = $m["orden_impreso"] != 0 ? true : false;
                        }
                        ?>
                    </div>
                    <?php
                    if ($existe2 != 1) {
                        //ESTE ES PARA LIBRO IMPRESO
                    ?>
                        <!-- <h3 class="text-danger">El tiempo de captura ha finalizado</h3> -->
                        <button type="button" id="confirmacion_impresos" class="btn btn-block btn-info" disabled hidden>Confirmar orden de autores</button>
                    <?php
                    } else {
                    ?>
                        <button type="button" class="btn btn-block btn-info" disabled hidden>El orden ya ha sido proporcionado, no se podrán guardar más cambios</button>
                    <?php
                    }
                    ?>
                </div>
                <!------------------------------------------------->
                <h2>
                    <li>Orden de autores: libro digital</li>
                    <!--ESTO TAMBIEN VA CONDICIONADO-->
                </h2>

                <p>
                    A continuación, se muestran los nombres y orden de los autores para el libro digital, le pedimos amablemente que verifique si son correctos y no presentan errores de ortografía, tal como están escritos serán publicados. <br>

                    Para registrar el orden se deberá mover/arrastrar en el orden correcto de los autores, será de forma ascendente siendo el primer el de arriba y el último autor el de abajo. Esta acción es necesaria y de no realizarla estaremos usando el orden de la plataforma siendo el líder el primer autor. <br>

                    Una vez que se haya elegido el orden debe dar clic en el botón <b>Confirmar orden de autores</b>. Si usted desea que algún autor no aparezca en la obra, deberá colocarlo como último autor y notificarlo al siguiente correo: <b>svchavezv@e.redesla.net</b>, en caso de no realizar esta notificación no podremos eliminarlo de la obra.<br>
                </p>
                <div class="wrapper" id="lista">
                    <?php
                    foreach ($info["miembros"] as $m) {
                    ?>
                        <div class="item" data-id="<?= $m['id'] ?>">
                            <label class="label" type="text" /><?php echo $m["orden_digital"] . ".- " . $m["nombreCompleto"] ?></label>
                            <input type="text" hidden id="<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                        </div>
                    <?php
                        $existe = $m["orden_digital"] != 0 ? true : false;
                    }
                    ?>
                </div>
                <?php
                if ($existe != 1) {
                    //ESTE ES PARA LIBRO DIGITAL
                ?>
                    <!-- <h3 class="text-danger">El tiempo de captura ha finalizado</h3> -->
                    <button type="button" id="confirmacion" class="btn btn-block btn-info" disabled hidden>Confirmar orden de autores</button>
                <?php
                } else {
                ?>
                    <button type="button" class="btn btn-block btn-info" disabled hidden>El orden ya ha sido proporcionado, no se podrán guardar más cambios</button>
                <?php
                }
                ?>
                <!------------------------------------------------------------------------->
            <?php
            } else if ($_SESSION["lider"] == 1 && $nombre == "Esquema A: Investigacion Relen 2021-2022") {
            ?>
                <h2>
                    <li>Orden de autores: libro digital</li>
                    <!--ESTO TAMBIEN VA CONDICIONADO-->
                </h2>
                <p>
                    A continuación, se muestran los nombres y orden de los autores para el libro digital, le pedimos amablemente que verifique si son correctos y no presentan errores de ortografía, tal como están escritos serán publicados. <br>

                    Para registrar el orden se deberá mover/arrastrar en el orden correcto de los autores, será de forma ascendente siendo el primer el de arriba y el último autor el de abajo. Esta acción es necesaria y de no realizarla estaremos usando el orden de la plataforma siendo el líder el primer autor. <br>

                    Una vez que se haya elegido el orden debe dar clic en el botón <b>Confirmar orden de autores</b>. Si usted desea que algún autor no aparezca en la obra, deberá colocarlo como último autor y notificarlo al siguiente correo: <b>svchavezv@e.redesla.net</b>, en caso de no realizar esta notificación no podremos eliminarlo de la obra.<br>
                </p>
                <div class="wrapper" id="lista">
                    <?php
                    foreach ($info["miembros"] as $m) {
                    ?>
                        <div class="item" data-id="<?= $m['id'] ?>">
                            <label class="label" type="text" /><?php echo $m["orden_digital"] . ".- " . $m["nombreCompleto"] ?></label>
                            <input type="text" hidden id="<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                        </div>
                    <?php
                        $existe = $m["orden_digital"] != 0 ? true : false;
                    }
                    ?>
                </div>
                <?php
                if ($existe != 1) {
                    //ESTE ES PARA LIBRO DIGITAL
                ?>
                    <!-- <h3 class="text-danger">El tiempo de captura ha finalizado</h3> -->
                    <button type="button" id="confirmacion" class="btn btn-block btn-info" disabled hidden>Confirmar orden de autores</button>
                <?php
                } else {
                ?>
                    <button type="button" class="btn btn-block btn-info" disabled hidden>El orden ya ha sido proporcionado, no se podrán guardar más cambios</button>
            <?php
                }
            }

            ?>
        <?php
        } else if ($info["validacion"][0]["terminado"] == 0) {
        ?>
            <ul>
                <li>
                    <p>Su validación ha sido rechazada. Cuando termine de corregir la validación de los cuestionarios mediante el archivo de validación
                        disponible en sus carpetas de acuerdo al criterio establecido por la red, de click en el botón. Si tiene alguna duda, contacte por Whatsapp al teléfono <a href="https://wa.link/t5l7xu">427 172 07 01</a></p>
                </li>
                <br>
                <a href="<?php echo base_url("validacionRelen/$nombre"); ?>" style="text-decoration:none; color: var(--font-color-primary);" />
                <button class="btn btn-rounded btn-block bg-<?= $_SESSION['red'] ?>">Fin de validación</button>
                </a>
            </ul>
        <?php
        }
        ?>
    </div>
<?php
}

function investigacionRelayn2022($nombre, $info)
{
?>
    <h2>8° INVESTIGACIÓN DE LAS MICRO Y PEQUEÑAS EMPRESAS 2022</h2>
    <hr>
    <h2>
        <li>Objetivo</li>
    </h2>
    <p>El objetivo de la red es generar, promover y difundir producción científica de calidad en el
        área de la administración y áreas relacionadas, mediante investigaciones colaborativas,
        participación en foros y producción de productos académicos de difusión de resultados,
        fomentando así el fortalecimiento y la vinculación de investigadores y grupos de
        investigación latinoamericanos.</p>
    <h2>
        <li>Materiales de investigación</li>
    </h2>
    <ul>
        <li>Video de habilitación de miembros investigadores:</li>
        <a href="<?php echo $info["carpetas_comunes"]["video_miembros"] ?>">Click para ver el video</a>
    </ul>
    <ul>
        <li>Carpeta compartida general:</li>
        <a href="<?php echo $info["carpetas_comunes"]["url"]; ?>">Click para abrir la carpeta compartida general</a>
        <p><b>Esta carpeta contiene</b></p>
        <ol type="a">
            <li>Diapositivas de capacitación para los miembros investigadores de RELAYN</li>
            <li>Diapositivas para capacitar a los encuestadores (Alumnos)</li>
            <li>Cuestionario en Excel para rellenar en caso de fallas de internet (uno por país).</li>
            <li>Cuestionario en PDF para rellenar en caso de convivencia con el universitario (uno por país).</li>
            <li>Convocatoria a <b>8° INVESTIGACIÓN DE LAS MICRO Y PEQUEÑAS EMPRESAS 2022</b></li>
        </ol>
    </ul>
    <h2>
        <li>Formularios de captura</li>
    </h2>
    <ul>
        <li>Los accesos de esta sección son específicamente para el grupo <b class="n_Relayn"><?php echo $_SESSION["CA"] ?></b></li>
        <a href="https://drive.google.com/drive/folders/<?php echo $info["carpeta"]["envios"] ?>?usp=sharing">https://drive.google.com/drive/folders/<?php echo $info["carpeta"]["envios"]; ?>?usp=sharing</a>
    </ul>
    <ul>
        <li>Base de datos para que ustedes verifiquen el trabajo de sus alumnos y para que al final validen los registros válidos según se explica en la capacitación:</li>
        <a href="<?php echo $info["carpeta"]["validacion"] ?>"><?php echo $info["carpeta"]["validacion"] ?></a>
    </ul>
    <ul>
        <li>Base de datos para que los alumnos consulten los folios ya capturados:</li>
        <a href="<?php echo $info["carpeta"]["alumnos"] ?>"><?php echo $info["carpeta"]["alumnos"] ?></a>
    </ul>
    <ul>
        <li>Formulario para que los participantes y/o los encuestadores capturen sus respuestas:</li>
        <a href="<?php echo $info["carpeta"]["formulario"] ?>"><?php echo $info["carpeta"]["formulario"] ?></a>
    </ul>
    <h3>Les sugerimos que envíen a sus alumnos un mensaje parecido a este, sea por correo electrónico, Moodle, etc:</h3>
    <p>Estimados alumnos</p>
    <p>Les compartimos el enlace para que hagan la captura de los cuestionarios:</p>
    <p><a href="<?php echo $info["carpeta"]["formulario"] ?>"><?php echo $info["carpeta"]["formulario"] ?></a></p>
    <p>Si quieren hacer el cuestionario en Excel o en papel y después capturarlo, les dejamos los accesos directos:</p>
    <?php
    $colombia = array("CO-USECA01", "CO-ULS01", "CO-CETO01");
    $peru = array("PE-USMP02", "PE-UNJFSC01");
    $ecuador = array("EC-UTB01", "EC-USGP01", "EC-UTE01");
    $ecuador = array("EC-UTB01", "EC-USGP01", "EC-UTE01");
    if (in_array($_SESSION["CA"], $colombia)) {
    ?>
        <p>Excel: <a href="<?php echo $info["carpetas_comunes"]["excel_colombia"] ?>" style="color:#4C87FB;" target="_blank"><?php echo $info["carpetas_comunes"]["excel_colombia"] ?></a> </p><!-- Pendiente -->
        <p>PDF: <a href="<?php echo $info["carpetas_comunes"]["pdf_colombia"] ?>" style="color:#4C87FB;" target="_blank"><?php echo $info["carpetas_comunes"]["pdf_colombia"] ?></a> </p> <!-- Pendiente -->
    <?php
    } else if (in_array($_SESSION["CA"], $peru)) {
    ?>
        <p>Excel: <a href="<?php echo $info["carpetas_comunes"]["excel_peru"] ?>" style="color:#4C87FB;" target="_blank"><?php echo $info["carpetas_comunes"]["excel_peru"] ?></a> </p><!-- Pendiente -->
        <p>PDF: <a href="<?php echo $info["carpetas_comunes"]["pdf_peru"] ?>" style="color:#4C87FB;" target="_blank"><?php echo $info["carpetas_comunes"]["pdf_peru"] ?></a> </p> <!-- Pendiente -->
    <?php
    } else if (in_array($_SESSION["CA"], $ecuador)) {
    ?>
        <p>Excel: <a href="<?php echo $info["carpetas_comunes"]["excel_ecuador"] ?>" style="color:#4C87FB;" target="_blank"><?php echo $info["carpetas_comunes"]["excel_ecuador"] ?></a> </p><!-- Pendiente -->
        <p>PDF: <a href="<?php echo $info["carpetas_comunes"]["pdf_ecuador"] ?>" style="color:#4C87FB;" target="_blank"><?php echo $info["carpetas_comunes"]["pdf_ecuador"] ?></a> </p> <!-- Pendiente -->
    <?php
    } else {
    ?>
        <p>Excel: <a href="<?php echo $info["carpetas_comunes"]["excel"] ?>" style="color:#4C87FB;" target="_blank"><?php echo $info["carpetas_comunes"]["excel"] ?></a> </p><!-- Pendiente -->
        <p>PDF: <a href="<?php echo $info["carpetas_comunes"]["pdf"] ?>" style="color:#4C87FB;" target="_blank"><?php echo $info["carpetas_comunes"]["pdf"] ?></a> </p> <!-- Pendiente -->
    <?php
    }
    ?>





    <p>Gracias de antemano, para cualquier duda estamos a sus órdenes.</p>
    <p>Atte. Profesor de la carrera.</p>

    <h2>
        <li>Validación</li>
    </h2>
    <?php
    if (empty($info["validacion"])) {
    ?>
        <ul>
            <li>
                <p>Si usted ya finalizo correctamente de validar los cuestionarios mediante el archivo de validación disponible en sus carpetas de acuerdo al criterio establecido por la red, por favor de click en el siguiente botón:</p>
            </li>
            <br>
            <a class="btn btn-rounded btn-lg btn-success" href="<?php echo base_url("validacionRelen/$nombre"); ?>" />Fin de validación</a>
        </ul>
    <?php
    } else if ($info["validacion"][0]["terminado"] == 1) {
    ?>
        <ul>
            <li>
                <p>Apreciable investigador, usted ha registrado la finalización de su validación, enviaremos la notificación a los coordinadores para que verifiquen la correcta evaluación. Le daremos una respuesta dentro de un plazo de 15 a 20 días, en caso de haberse realizado correctamente le notificaremos en este mismo sitio.
                    Si hubiese algún error en su evaluación les notificaremos vía correo electrónico y le habilitaremos nuevamente el botón fin de validación</p>
            </li>
            <li>
                <p>Gracias por tu compromiso.</p>
            </li>
        </ul>

        <!--AQUI VAMOS A PONER LO DEL ORDENAMIENTO-->
    <?php
    } else if ($info["validacion"][0]["terminado"] == 2) {
    ?>
        <ul>
            <li>
                <p>Apreciable investigador, le notificamos que su validación fue realizada correctamente. La siguiente etapa será la redacción de capítulos, para esta etapa los coordinadores les notificarán.</p>
            </li>
            <li>
                <p>Agradecemos tu compromiso.</p>
            </li>
        </ul>
        <?php

        if ($_SESSION["lider"] == 1 && $nombre == "Esquema B: Investigacion Relayn 2022") { //Condicion si es el lider, tambien si es Esquema A: Investigacion Relayn 2022 es solamente digital
        ?>
            <div>
                <h2>
                    <li>Orden de autores: libro impreso</li>
                </h2>
                <!--ESTO TAMBIEN VA CONDICIONADO-->
                <p>
                    A continuación, se muestran los nombres y orden de los autores para el libro impreso, le pedimos amablemente que verifique si son correctos y no presentan errores de ortografía, tal como están escritos serán publicados. <br>

                    Para registrar el orden se deberá mover/arrastrar en el orden correcto de los autores, será de forma ascendente siendo el primer el de arriba y el último autor el de abajo. Esta acción es necesaria y de no realizarla estaremos usando el orden de la plataforma siendo el líder el primer autor. <br>

                    Una vez que se haya elegido el orden debe dar clic en el botón <b>Confirmar orden de autores</b>. Si usted desea que algún autor no aparezca en la obra, deberá colocarlo como último autor y notificarlo al siguiente correo: <b>svchavezv@e.redesla.net</b>, en caso de no realizar esta notificación no podremos eliminarlo de la obra.<br>
                </p>
                <div class="wrapper" id="lista_impreso">
                    <?php
                    $i = 1;
                    foreach ($info["miembros"] as $m) {
                    ?>
                        <div class="item" data-id="<?= $m['id'] ?>">
                            <?php
                            if ($m["orden_impreso"] == 0) { //No registro su orden a tiempo, se puso por defecto
                            ?>
                                <label class="label" type="text" /><?php echo $i . ".- " . $m["nombreCompleto"] ?></label>
                                <input type="text" hidden id="d_<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                            <?php
                                $i++;
                            } else {
                            ?>
                                <label class="label" type="text" /><?php echo $m["orden_impreso"] . ".- " . $m["nombreCompleto"] ?></label>
                                <input type="text" hidden id="d_<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                            <?php
                            }
                            ?>

                        </div>
                    <?php
                        $existe2 = $m["orden_impreso"] != 0 ? true : false;
                    }
                    ?>
                </div>
                <?php
                if ($existe2 != 1) {
                    //ESTE ES PARA LIBRO IMPRESO
                ?>
                    <!-- <h3 class="text-danger">El tiempo de captura ha finalizado</h3> -->
                    <button type="button" id="confirmacion_impresos" class="btn btn-block btn-info" disabled hidden>Confirmar orden de autores</button>
                <?php
                } else {
                ?>
                    <button type="button" class="btn btn-block btn-info" disabled hidden>El orden ya ha sido proporcionado, no se podrán guardar más cambios</button>
                <?php
                }
                ?>
            </div>
            <!------------------------------------------------->
            <h2>
                <li>Orden de autores: libro digital</li>
                <!--ESTO TAMBIEN VA CONDICIONADO-->
                <p>
            </h2>
            A continuación, se muestran los nombres y orden de los autores para el libro digital, le pedimos amablemente que verifique si son correctos y no presentan errores de ortografía, tal como están escritos serán publicados. <br>

            Para registrar el orden se deberá mover/arrastrar en el orden correcto de los autores, será de forma ascendente siendo el primer el de arriba y el último autor el de abajo. Esta acción es necesaria y de no realizarla estaremos usando el orden de la plataforma siendo el líder el primer autor. <br>

            Una vez que se haya elegido el orden debe dar clic en el botón <b>Confirmar orden de autores</b>. Si usted desea que algún autor no aparezca en la obra, deberá colocarlo como último autor y notificarlo al siguiente correo: <b>svchavezv@e.redesla.net</b>, en caso de no realizar esta notificación no podremos eliminarlo de la obra.<br>
            </p>
            <div class="wrapper" id="lista">
                <?php
                foreach ($info["miembros"] as $m) {
                ?>
                    <div class="item" data-id="<?= $m['id'] ?>">
                        <label class="label" type="text" /><?php echo $m["orden_digital"] . ".- " . $m["nombreCompleto"] ?></label>
                        <input type="text" hidden id="<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                    </div>
                <?php
                    $existe = $m["orden_digital"] != 0 ? true : false;
                }
                ?>
            </div>
            <?php
            if ($existe != 1) {
                //ESTE ES PARA LIBRO DIGITAL
            ?>
                <!-- <h3 class="text-danger">El tiempo de captura ha finalizado</h3> -->
                <button type="button" id="confirmacion" class="btn btn-block btn-info" disabled hidden>Confirmar orden de autores</button>
            <?php
            } else {
            ?>
                <button type="button" class="btn btn-block btn-info" disabled hidden>El orden ya ha sido proporcionado, no se podrán guardar más cambios</button>
            <?php
            }
            ?>
            <!------------------------------------------------------------------------->
        <?php
        } else if ($_SESSION["lider"] == 1 && $nombre == "Esquema A: Investigacion Relayn 2022") {
        ?>
            <h2>
                <li>Orden de autores: libro digital</li>
                <!--ESTO TAMBIEN VA CONDICIONADO-->
            </h2>
            <p>
                A continuación, se muestran los nombres y orden de los autores para el libro digital, le pedimos amablemente que verifique si son correctos y no presentan errores de ortografía, tal como están escritos serán publicados. <br>

                Para registrar el orden se deberá mover/arrastrar en el orden correcto de los autores, será de forma ascendente siendo el primer el de arriba y el último autor el de abajo. Esta acción es necesaria y de no realizarla estaremos usando el orden de la plataforma siendo el líder el primer autor. <br>

                Una vez que se haya elegido el orden debe dar clic en el botón <b>Confirmar orden de autores</b>. Si usted desea que algún autor no aparezca en la obra, deberá colocarlo como último autor y notificarlo al siguiente correo: <b>svchavezv@e.redesla.net</b>, en caso de no realizar esta notificación no podremos eliminarlo de la obra.<br>
            </p>
            <div class="wrapper" id="lista">
                <?php
                foreach ($info["miembros"] as $m) {
                ?>
                    <div class="item" data-id="<?= $m['id'] ?>">
                        <label class="label" type="text" /><?php echo $m["orden_digital"] . ".- " . $m["nombreCompleto"] ?></label>
                        <input type="text" hidden id="<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                    </div>
                <?php
                    $existe = $m["orden_digital"] != 0 ? true : false;
                }
                ?>
            </div>
            <?php
            if ($existe != 1) {
                //ESTE ES PARA LIBRO DIGITAL
            ?>
                <!-- <h3 class="text-danger">El tiempo de captura ha finalizado</h3> -->
                <button type="button" id="confirmacion" class="btn btn-block btn-info" disabled hidden>Confirmar orden de autores</button>
            <?php
            } else {
            ?>
                <button type="button" class="btn btn-block btn-info" disabled hidden>El orden ya ha sido proporcionado, no se podrán guardar más cambios</button>
        <?php
            }
        }

        ?>

    <?php
    } else if ($info["validacion"][0]["terminado"] == 0) {
    ?>
        <ul>
            <li>
                <p>Su validación ha sido rechazada. Si usted ya finalizo correctamente de validar los cuestionarios mediante el archivo de validación disponible en sus carpetas de acuerdo al criterio establecido por la red, por favor de click en el siguiente botón:</p>
            </li>
            <br>
            <a class="btn btn-rounded btn-lg btn-success" href="<?php echo base_url("validacionRelen/$nombre"); ?>" />Fin de validación</a>
        </ul>
    <?php
    }
    ?>
    <?php
}

function investigacionRelep2021_2022($nombre, $info)
{
    $array_ca_falta_municipio = array("MXP-CUSUG01", "MXP-UASI01");
    if (in_array($_SESSION["CA"], $array_ca_falta_municipio)) {
        echo "<h2>Estimado participante para poder habilitar los accesos a sus encuestas en necesario confirmar con el equipo RELEP lo siguiente: <br>
                • Estado <br>
                • Municipio <br>
                • Institución/Universidad en la que se aplicará el estudio <br>
                • Facultades/Carreras en las que aplicarán el estudio <br><br>
            Dejamos a continuación los medios de contacto a través de los cuales les daremos la atención debida:<br>
            Correo: chernandezm@redesla.net  <br>
            WhatsApp  +52 4778433415
                </h2>";
    } else {
    ?>
        <div class="card card-body-congresos">
            <div class="card-header card-header-congresos">
                <h2>Competencias digitales, resiliencia y percepción de inclusión académica en estudiantes de educación superior</h2>
            </div>
            <hr>
            <ol>
                <h2>
                    <li>Objetivo</li>
                </h2>
                <p>Estudiar la relación entre la inclusión, las competencias digitales y la resiliencia de los estudiantes de instituciones de educación superior en el contexto local y las particularidades de las especialidades estudiadas.</p>
                <h2>
                    <li>Materiales de la investigación</li>
                </h2>
                <ul>
                    <li>Video de habilitación de miembros investigadores:</li>
                    <a href="">Click para ver el video</a>
                </ul>
                <ul>
                    <li>Carpeta compartida general:</li>
                    <a href="<?php echo $info["carpetas_comunes"]["url"] ?>">Click para abrir la carpeta compartida general</a>
                    <p><b>Esta carpeta contiene</b></p>
                    <ol type="a">
                        <li>Diapositivas de capacitación para los miembros investigadores de RELEP</li>
                        <li>Diapositivas para capacitar a los encuestadores (Alumnos)</li>
                        <li>Cuestionario en Excel para rellenar en caso de fallas de internet (uno por país).</li>
                        <li>Cuestionario en PDF para rellenar en caso de convivencia con el universitario (uno por país).</li>
                        <li>Convocatoria a 2a investigación anual 2021</li>
                    </ol>
                </ul>
                <h2>
                    <li>Formularios de captura</li>
                </h2>
                <?php
                ?>
                <ul>
                    <li>Los accesos de esta sección son específicamente para el grupo <b class="n_Relep"><?php echo $_SESSION["CA"] ?></b></li>
                    <a href="https://drive.google.com/drive/folders/<?php echo $info["carpeta"]["envios"]; ?>?usp=sharing">https://drive.google.com/drive/folders/<?php echo $info["carpeta"]["envios"]; ?>?usp=sharing</a>
                </ul>
                <ul>
                    <li>Base de datos para que ustedes verifiquen el trabajo de sus alumnos y para que al final validen los registros válidos según se explica en la capacitación:</li>
                    <a href="<?php echo $info["carpeta"]["validacion"] ?>"><?php echo $info["carpeta"]["validacion"] ?></a>
                </ul>
                <ul>
                    <li>Base de datos para que los alumnos consulten los folios ya capturados:</li>
                    <a href="<?php echo $info["carpeta"]["alumnos"] ?>"><?php echo $info["carpeta"]["alumnos"] ?></a>
                </ul>
                <ul>
                    <li>Formulario para que los participantes y/o los encuestadores capturen sus respuestas:</li>
                    <a href="<?php echo $info["carpeta"]["formulario"] ?>"><?php echo $info["carpeta"]["formulario"] ?></a>
                </ul>
                <?php
                ?>


                <h3>Les sugerimos que envíen a sus alumnos un mensaje parecido a este, sea por correo electrónico, Moodle, etc:</h3>
                <p>Estimados alumnos</p>
                <p>Les compartimos el enlace para que hagan la captura de los cuestionarios:</p>
                <p><a href="<?php echo $info["carpeta"]["formulario"] ?>"><?php echo $info["carpeta"]["formulario"] ?></a></p>
                <p>Si quieren hacer el cuestionario en Excel o en papel y después capturarlo, les dejamos los accesos directos:</p>
                <p>Excel: <a href="<?php echo $info["carpetas_comunes"]["url"] ?>" style="color:#4C87FB;"><?php echo $info["carpetas_comunes"]["url"] ?></a> </p><!-- Pendiente -->
                <p>PDF: <a href="<?php echo $info["carpetas_comunes"]["url"] ?>" style="color:#4C87FB;"><?php echo $info["carpetas_comunes"]["url"] ?></a> </p> <!-- Pendiente -->
                <p>Gracias de antemano, para cualquier duda estamos a sus órdenes.</p>
                <p>Atte. Profesor de la carrera.</p>
                <h2>
                    <li>Validación</li>
                </h2>
                <?php

                if (empty($info["validacion"])) {
                ?>
                    <ul>
                        <li>
                            <p>Si usted ya finalizo correctamente de validar los cuestionarios mediante el archivo de validación disponible en sus carpetas de acuerdo al criterio establecido por la red, por favor de click en el siguiente botón:</p>
                        </li>
                        <br>
                        <a class="btn btn-rounded btn-block bg-<?= $_SESSION['red'] ?>" href="<?php echo base_url("validacionRelep/$nombre"); ?>" />Fin de validación</a>
                    </ul>
                <?php
                } else if ($info["validacion"][0]["terminado"] == 1) {
                ?>
                    <ul>
                        <li>
                            <p>Apreciable investigador, usted ha registrado la finalización de su validación, enviaremos la notificación a los coordinadores para que verifiquen la correcta evaluación. Le daremos una respuesta dentro de un plazo de 15 a 20 días, en caso de haberse realizado correctamente le notificaremos en este mismo sitio.
                                Si hubiese algún error en su evaluación les notificaremos vía correo electrónico y le habilitaremos nuevamente el botón fin de validación</p>
                        </li>
                        <li>
                            <p>Gracias por tu compromiso.</p>
                        </li>
                    </ul>

                <?php
                } else if ($info["validacion"][0]["terminado"] == 2) {
                ?>
                    <ul>
                        <li>
                            <p>Apreciable investigador, le notificamos que su validación fue realizada correctamente. La siguiente etapa será la redacción de capítulos, para esta etapa los coordinadores les notificarán.</p>
                        </li>
                        <li>
                            <p>Agradecemos tu compromiso.</p>
                        </li>
                    </ul>
                    <?php

                    if ($_SESSION["lider"] == 1 && $nombre == "Esquema B: Investigación Relep 2021-2022") { //Condicion si es el lider, tambien si es Esquema A: Investigacion Relayn 2022 es solamente digital
                    ?>
                        <div>
                            <h2>
                                <li>Orden de autores: libro impreso</li>
                                <!--ESTO TAMBIEN VA CONDICIONADO-->
                            </h2>

                            <p>
                                A continuación, se muestran los nombres y orden de los autores para el libro impreso, le pedimos amablemente que verifique si son correctos y no presentan errores de ortografía, tal como están escritos serán publicados. <br>

                                Para registrar el orden se deberá mover/arrastrar en el orden correcto de los autores, será de forma ascendente siendo el primer el de arriba y el último autor el de abajo. Esta acción es necesaria y de no realizarla estaremos usando el orden de la plataforma siendo el líder el primer autor. <br>

                                Una vez que se haya elegido el orden debe dar clic en el botón <b>Confirmar orden de autores</b>. Si usted desea que algún autor no aparezca en la obra, deberá colocarlo como último autor y notificarlo al siguiente correo: <b>svchavezv@e.redesla.net</b>, en caso de no realizar esta notificación no podremos eliminarlo de la obra.<br>
                            </p>
                            <div class="wrapper" id="lista_impreso">
                                <?php
                                foreach ($info["miembros"] as $m) {
                                ?>
                                    <div class="item" data-id="<?= $m['id'] ?>">
                                        <label class="label" type="text" /><?php echo $m["orden_impreso"] . ".- " . $m["nombreCompleto"] ?></label>
                                        <input type="text" hidden id="d_<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                                    </div>
                                <?php
                                    $existe2 = $m["orden_impreso"] != 0 ? true : false;
                                }
                                ?>
                            </div>
                            <?php
                            if ($existe2 != 1) {
                                //ESTE ES PARA LIBRO IMPRESO
                            ?>
                                <!-- <h3 class="text-danger">El tiempo de captura ha finalizado</h3> -->
                                <button type="button" id="confirmacion_impresos" class="btn btn-block btn-info" disabled hidden>Confirmar orden de autores</button>
                            <?php
                            } else {
                            ?>
                                <button type="button" class="btn btn-block btn-info" disabled hidden>El orden ya ha sido proporcionado, no se podrán guardar más cambios</button>
                            <?php
                            }
                            ?>
                        </div>
                        <!------------------------------------------------->
                        <h2>
                            <li>Orden de autores: libro digital</li>
                            <!--ESTO TAMBIEN VA CONDICIONADO-->
                        </h2>
                        <p>
                            A continuación, se muestran los nombres y orden de los autores para el libro digital, le pedimos amablemente que verifique si son correctos y no presentan errores de ortografía, tal como están escritos serán publicados. <br>

                            Para registrar el orden se deberá mover/arrastrar en el orden correcto de los autores, será de forma ascendente siendo el primer el de arriba y el último autor el de abajo. Esta acción es necesaria y de no realizarla estaremos usando el orden de la plataforma siendo el líder el primer autor. <br>

                            Una vez que se haya elegido el orden debe dar clic en el botón <b>Confirmar orden de autores</b>. Si usted desea que algún autor no aparezca en la obra, deberá colocarlo como último autor y notificarlo al siguiente correo: <b>svchavezv@e.redesla.net</b>, en caso de no realizar esta notificación no podremos eliminarlo de la obra.<br>
                        </p>
                        <div class="wrapper" id="lista">
                            <?php
                            foreach ($info["miembros"] as $m) {
                            ?>
                                <div class="item" data-id="<?= $m['id'] ?>">
                                    <label class="label" type="text" /><?php echo $m["orden_digital"] . ".- " . $m["nombreCompleto"] ?></label>
                                    <input type="text" hidden id="<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                                </div>
                            <?php
                                $existe = $m["orden_digital"] != 0 ? true : false;
                            }
                            ?>
                        </div>
                        <?php
                        if ($existe != 1) {
                            //ESTE ES PARA LIBRO DIGITAL
                        ?>
                            <!-- <h3 class="text-danger">El tiempo de captura ha finalizado</h3> -->
                            <button type="button" id="confirmacion" class="btn btn-block btn-info" disabled hidden>Confirmar orden de autores</button>
                        <?php
                        } else {
                        ?>
                            <button type="button" class="btn btn-block btn-info" disabled hidden>El orden ya ha sido proporcionado, no se podrán guardar más cambios</button>
                        <?php
                        }
                        ?>
                        <!------------------------------------------------------------------------->
                    <?php
                    } else if ($_SESSION["lider"] == 1 && $nombre == "Esquema A: Investigación Relep 2021-2022") {
                    ?>
                        <h2>
                            <li>Orden de autores: libro digital</li>
                            <!--ESTO TAMBIEN VA CONDICIONADO-->
                        </h2>
                        <p>
                            A continuación, se muestran los nombres y orden de los autores para el libro impreso, le pedimos amablemente que verifique si son correctos y no presentan errores de ortografía, tal como están escritos serán publicados. <br>

                            Para registrar el orden se deberá mover/arrastrar en el orden correcto de los autores, será de forma ascendente siendo el primer el de arriba y el último autor el de abajo. Esta acción es necesaria y de no realizarla estaremos usando el orden de la plataforma siendo el líder el primer autor. <br>

                            Una vez que se haya elegido el orden debe dar clic en el botón <b>Confirmar orden de autores</b>. Si usted desea que algún autor no aparezca en la obra, deberá colocarlo como último autor y notificarlo al siguiente correo: <b>svchavezv@e.redesla.net</b>, en caso de no realizar esta notificación no podremos eliminarlo de la obra.<br>
                        </p>
                        <div class="wrapper" id="lista">
                            <?php
                            foreach ($info["miembros"] as $m) {
                            ?>
                                <div class="item" data-id="<?= $m['id'] ?>">
                                    <label class="label" type="text" /><?php echo $m["orden_digital"] . ".- " . $m["nombreCompleto"] ?></label>
                                    <input type="text" hidden id="<?= $m["id"] ?>" value="<?= $m["nombreCompleto"] ?>" />
                                </div>
                            <?php
                                $existe = $m["orden_digital"] != 0 ? true : false;
                            }
                            ?>
                        </div>
                        <?php
                        if ($existe != 1) {
                            //ESTE ES PARA LIBRO DIGITAL
                        ?>
                            <!-- <h3 class="text-danger">El tiempo de captura ha finalizado</h3> -->
                            <button type="button" id="confirmacion" class="btn btn-block btn-info" disabled hidden>Confirmar orden de autores</button>
                        <?php
                        } else {
                        ?>
                            <button type="button" class="btn btn-block btn-info" disabled hidden>El orden ya ha sido proporcionado, no se podrán guardar más cambios</button>
                    <?php
                        }
                    }
                    ?>
                <?php
                } else if ($info["validacion"][0]["terminado"] == 0) {
                ?>
                    <ul>
                        <li>
                            <p>Su validación ha sido rechazada. Si usted ya finalizo correctamente de validar los cuestionarios mediante el archivo de validación disponible en sus carpetas de acuerdo al criterio establecido por la red, por favor de click en el siguiente botón:</p>
                        </li>
                        <br>
                        <a class="btn btn-rounded btn-block bg-<?= $_SESSION['red'] ?>" href="<?php echo base_url("validacionRelep/$nombre"); ?>" />Fin de validación</a>
                    </ul>
                <?php
                }
                ?>






            </ol>
        </div>
    <?php
    }
}

function investigacionRelmo2022($nombre, $info)
{
    ?>
    <div class="card card-body-congresos">
        <div class="card-header card-header-congresos">
            <h1>Los obstáculos que tienen las estudiantes universitarias que dirigen una micro o pequeña empresa.</h1>
        </div>
        <div style="padding: 1rem;">
            <hr>
            <h2>PROTOCOLO PARA APLICACIÓN DE ENTREVISTA DE LA INVESTIGACIÓN RELMO 2022.</h2>
            <hr>
            <h3>I.- SOBRE EL RECLUTAMIENTO, LUGAR DE LA APLICACIÓN DE LA ENTREVISTA Y EL MATERIAL.</h3>
            <p>
                <b>1.1.- SOBRE EL RECLUTAMIENTO.</b> Contactar en los salones de clase o con alumnas conocidas
                que cuenten con las características solicitadas que deben tener las entrevistadas
                que conforman la muestra de esta investigación. Se considera pertinente aplicar
                la técnica de “la bola de nieve”, la cual consiste en que una entrevistada con
                las características solicitadas nos pueda apoyar con el contacto de una entrevistada
                con similares características.
            </p>
            <p>
                No es necesario que las entrevistadas sean o hayan sido nuestras alumnas.
            </p>
            <p>
                La muestra puede estar conformada por entrevistadas que son alumnas de diferentes
                carreras, facultades o divisiones de la misma universidad o en casos acordados
                de la misma región. Únicamente es pertinente atender y respetar la universidad
                y municipio seleccionado
            </p>
            <p>
                <b>1.2.- Características de la muestra.</b>
            </p>
            <p>
                <b>El total de la muestra de entrevistadas debe de ser: 30</b>
            </p>
            <p>
            <ol>
                <li>Mujer estudiante universitaria o nivel académico equivalente.</li>
                <li>Que se encuentre estudiando cualquier grado académico.</li>
                <li>Que dirija o sea dueña de una micro o pequeña empresa, la cual cuente por lo menos con 1 año de operación.</li>
                <li>Las estudiantes universitarias deben pertenecer a la misma institución.
                    En instituciones pequeñas se puede considerar por municipio (aspecto que se
                    debe consultar previamente con el equipo coordinador para la autorización). </li>
                <li>Que sea directora o dueña de una micro o pequeña empresa (mype):
                    5a) La directora es la persona que toma la mayoría de las decisiones en la organización.
                    5b) Una mype es una organización en la que se gestionan diversas clases de recursos, que tiene fines de lucro y en la que participan diversos actores como clientes, proveedores, que <u>tenga al menos un empleado y 1 año de operación</u>. </li>
            </ol>
            </p>
            <p>
                Alternativamente la estudiante universitaria puede dirigir o ser dueña de una
                organización que cuente con todas las características señaladas en el inciso b,
                <u>salvo el requisito de tener empleados</u>, es decir, puede NO tener empleados, pero:
            </p>
            <p>
            <ul>
                <li><b>Se excluyen particularmente las estudiantes</b> en un esquema de autoempleo
                    que implique la pérdida de la autonomía en la gestión de la organización,
                    tales como: la venta por catálogo o esquemas piramidales (Mary Kay, Avon,
                    Andrea, Betterware). En la situación de tener empleados directos,
                    se considerará un caso incluido en el inciso 5b.</li>
            </ul>
            </p>
            <p>
                <b>1.3.- Directorio de entrevistadas</b>. Es importante que se realice un directorio
                ya sea físico o digital con los datos de las entrevistadas para tener un concentrado
                de los contactos. Datos necesarios: nombre completo, número de celular, carrera a
                la que pertenece, correo electrónico.
            </p>
            <p>
                <b>1.4- SOBRE LA CITA</b>. Se debe concretar la cita con la universitaria-empresaria
                con por lo menos un día de antelación, haciéndole conocer el objetivo de la entrevista,
                así como el tiempo de duración de ésta, señalarle la fecha, hora y lugar de aplicación.
                En caso de ser una entrevista de manera virtual, hacerle mención de cómo se le hará
                llegar el link para la conexión.
            </p>
            <p>
                Se puede hacer llegar una nota-invitación por vía de la red social Whatsapp,
                telegram o line, ya sea de manera individual o grupal
            </p>
            <p>
                <b>1.5.- SOBRE LA DURACIÓN DE LA ENTREVISTA</b>. Esta entrevista tiene una duración
                aproximada de 20 a 25 minutos.
            </p>
            <p>
                <b>1.6.- SOBRE LA MODALIDAD DE LA ENTREVISTA</b>. La entrevista se puede llevar a
                cabo de manera presencial o virtual (a través de plataformas como zoom, meet
                o similar). Es muy importante que se pueda grabar el audio a través de un
                dispositivo móvil y audio-video en dicha plataforma.
            </p>
            <p>
                <b>1.7.- SOBRE EL LUGAR DE APLICACIÓN DE LA ENTREVISTA</b>. Se sugiere aplicar
                la entrevista en un lugar que sea parte del contexto de la entrevistada como
                lo puede ser un salón de clases, la empresa, cubículo de la docente, etc…
                ya sea que ésta se lleve a cabo de manera virtual o presencial.
            </p>
            <p>
                <b>1.8.-SOBRE EL MATERIAL NECESARIO PARA LA APLICACIÓN</b>
            </p>
            <p>
                1.8.1.-Se sugiere imprimir la guía de la entrevista (vid: Entrevista Investigación Relmo 2022) con la finalidad de que la entrevistadora pueda recurrir a ella durante la aplicación. En caso de que decidan tener de manera digital la entrevista, considerar que no sea un factor que pueda distraer u obstruir si es que la entrevista se lleva a cabo de manera virtual.<br>
                1.8.2.-El formato que incluye la entrevista es únicamente una guía, se sugiere sólo seguirla y ser grabada, no ir llenando los campos. <br>
                1.8.3.- Es necesario contar con un celular o dispositivo para poder grabar la entrevista (audio y video o solamente audio), de igual manera si la entrevista se lleva a cabo a través de una plataforma digital será conveniente grabarla con audio y video (en caso de hacerlo vía una plataforma, se sugiere que se haga el registro de la entrevista a través de los dos medios).<br>
                1.8.4 Tener a la mano un cuadernillo el cual será la bitácora de campo (física) así como lapiceros, con la finalidad de tomar notas pertinentes con respecto al desarrollo de la entrevista, tales como y que la entrevistadora considere pertinentes para el análisis de la información obtenida tales como:<br>
            </p>
            <p>
                · Reacciones de la entrevistada que no son perceptibles en los registros audiovisuales (risas nerviosas, llanto, incomodidad, emociones que estén vinculadas a las respuestas que están proporcionando).<br>
                · Elementos que se puedan observar durante la entrevista y que puedan ser fundamentales para el análisis del contexto (el lugar, personas que interactúan con la entrevistada durante la aplicación del instrumento, etc).<br>
                · Factores en la hora y fecha de aplicación que pudiesen ser determinantes para que la entrevistada pudiese tener alguna alteración significativa en sus respuestas.
            </p>
            <p>
                Nota: Estas anotaciones no son necesarias que se hagan durante la entrevista, pero es pertinente que terminando la sesión o máximo un día después se hagan estas anotaciones en la bitácora.
            </p>
            <h3> II.- SOBRE LA APLICACIÓN DE LA ENTREVISTA</h3>
            <p>
                <b>2.1.- SOBRE LAS ENTREVISTADORAS (ES).</b>
            </p>
            <p>
                La entrevista debe ser realizada por cualquiera de las y los integrantes del equipo de investigación, por lo que pueden dividirse el número total de entrevistas a aplicar. Es necesario que cada entrevistador o entrevistadora conozca este protocolo y lleve a cabo en totalidad el proceso de la entrevista hasta la captura, así como lo necesario de darle seguimiento a las siguientes fases del proceso de investigación.
            </p>
            <p>
                El equipo de investigación de igual manera podrá apoyarse con alumnas que realicen la entrevista, sin embargo, éstas deben de tener una capacitación previa para la aplicación, así como el uso de herramientas que se presentan en este protocolo. Se sugiere que quienes realicen la entrevista sea el equipo de investigación por la naturaleza del trabajo cualitativo.
            </p>
            <p>
                <b>2.2.- SOBRE EL SALUDO, ABORDAJE E INTRODUCCIÓN PARA LA ENTREVISTA.</b>
            </p>
            <p>
            <ul>
                <li>Saludar a la entrevistada, de preferencia por su nombre, preguntarle cómo se encuentra, agradecerle atención a la cita.</li>
                <li>Mencionarle el objetivo de la investigación, así como recordarle la duración que tendrá la sesión.</li>
                <li>Posteriormente, decirle que la sesión será grabada de manera audiovisual o sólo con audio, según sea el caso y pedir su autorización. Esta mención se realiza en ambas modalidades: virtual y presencial.</li>
                <li>Es muy importante apelar a su honestidad, a que se sienta cómoda, así como dejarle una clara idea que no existen respuestas correctas, que lo que buscamos es conocer su experiencia a profundidad ante este fenómeno.</li>
                <li>En caso de no conocer previamente a la entrevistada y ser el primer contacto, presentarse con su nombre y cargo. Mencionarle que será la persona encargada de realizar la entrevista.</li>
            </ul>
            </p>
            <p>
                <i>
                    Ejemplo: “Buenos días Alicia, ¿cómo estás?, muchas gracias por atender esta invitación (si no la conocían, presentarse y decir que será la entrevistadora). El objetivo de la aplicación de esta entrevista es conocer los obstáculos a los cuales mujeres como tú se enfrentan al dirigir una empresa y al mismo tiempo ser estudiantes universitarias, te comento que esta sesión durará alrededor de 20 minutos. De igual manera quiero comentarte que requiero que la entrevista sea grabada (señalar de qué manera será), por lo que espero no tengas ningún inconveniente, te aseguro que tu nombre, así como tus datos no serán conocidos públicamente y la información que me des a través de tu experiencia como estudiante universitaria y empresaria será utilizada para fines académicos y científicos.
                </i>
            </p>
            <p>
                <i>
                    Te pido que te sientas cómoda y que en cada una de tus respuestas seas lo más honesta posible, lo que me interesa es conocer tu experiencia sobre lo que vives como estudiante y como empresaria. ¿Te parece que comencemos?
                </i>
            </p>
            <p>
                En ese momento se encienden los dispositivos que servirán para el registro audio-visual o de audio de la entrevista.
            </p>
            <p>
                <b>2.3.- SE COMIENZAN A REALIZAR LAS PREGUNTAS.</b>
            </p>
            <p>
                En caso de que vean pertinente, por el curso que toma la entrevista puede alterar el orden de las preguntas. Si es la primera vez que aplica entrevistas o considera que no se cuenta con la experiencia necesaria se sugiere seguir el orden de la guía de entrevista.
            </p>
            <p>
                Es muy pertinente que tome en cuenta que la investigación cualitativa requiere PROFUNDIDAD, por lo que <u>respuestas monosílabas no funcionan</u> para el análisis, así que es necesario que en nuestro papel de entrevistadoras o entrevistadores, llevemos a que la entrevistada extienda su respuesta, explicando la experiencia sobre el fenómeno que estamos investigando. Considerar que en caso de que la entrevistada comience a abordar temas ajenos a nuestro objetivo, repetir la pregunta y enfocarla a nuestro punto de interés.
            </p>
            <p>
                En caso de que considere necesario ahondar más en la respuesta de la entrevistada y requiera hacer otra pregunta para ampliar o dejar “clara” dicha respuesta, ésta se puede realizar y se deja plasmada también en la transcripción.
            </p>
            <h3>III.- SOBRE EL CONTEXTO, LA OBSERVACIÓN Y EL USO DE LA BITÁCORA DURANTE LA APLICACIÓN DE LA ENTREVISTA.</h3>
            <p>
                Como parte del proceso de investigación cualitativa, es necesario que la entrevistadora (or), estén en constante observación de lo que ocurre durante la sesión de la entrevista con respecto a nuestra entrevistada, tal como se mencionó en el párrafo: <b>1.8.4</b>. Se recuerda que este elemento es fundamental para el análisis de la información que nos proporcionarán las entrevistadas.
            </p>
            <p>
                Es muy pertinente que se tome en cuenta qué tipos de reacciones, acciones, etc se deben de considerar para el registro en la bitácora.
            </p>
            <h3>IV.-SOBRE EL CIERRE DE LA ENTREVISTA.</h3>
            <p>
                Al concluir la sesión de la entrevista, se le agradece a la entrevistada el haber compartido su experiencia y se le reitera que toda la información proporcionada en la sesión será ocupada para fines académicos y científicos. De igual manera se le menciona la posibilidad de volverla a contactar más adelante por si existe algún tema que sea necesario aclarar.
            </p>
            <p>
                Se termina la grabación audio-visual.
            </p>
            <h3>V.- SOBRE LA TRANSCRIPCIÓN DE LA ENTREVISTA.</h3>
            <p>
                5.1.-Al haber concluido la sesión de la entrevista, usted como entrevistadora deberá tener un archivo audio-visual de la sesión, el cual deberá de subir en una carpeta de google drive que se encontrará disponible en la plataforma de REDESLA-RELMO, en cuanto al archivo de audio, éste únicamente se tendrá como respaldo en caso de que llegara a fallar el archivo audio-visual. Se recomienda que el equipo tenga un respaldo de la información.
            </p>
            <p>
                5.2.- Con el archivo audio-visual o de audio que contiene la sesión de la entrevista usted deberá realizar cualquiera de las dos siguientes opciones:
            </p>
            <p>
                5.2.1.- Se tendrá que transcribir del archivo audiovisual o de audio de manera manual a Word u otro procesador de textos la entrevista en su totalidad, considerando realizar dentro del documentos ciertas anotaciones que son fundamentales para el análisis de la información.
            </p>
            <p>
                De igual manera se podrá usar un programa de transcripción el cual sugerimos en el anexo llamado: <a href="<?= base_url("resources/pdf/Relmo_guia.pdf") ?>" target="_blank">“SUGERENCIA DE SOFTWARE PARA TRANSCRIPCIÓN DE ENTREVISTA”</a>. Este archivo tambien esta disponible en la carpeta compartida general.
            </p>
            <p>
                Si usted decidió utilizar cualquier programa de transcripción, es importante que vuelva a revisar dicha transcripción sea correcta, así como las diversas intervenciones que tienen la entrevistada y la entrevistadora, además de hacer las anotaciones pertinentes consideradas sobre reacciones, acciones, etc…
            </p>
            <p>
                5.2.2.- A partir de la transcripción de su entrevista en el procesador de textos o Word, tendrá <b>que copiar y pegar</b> esta información en el espacio destinado para registrar la entrevista dentro de la plataforma de REDESLA-RELMO, por lo que es importante revisar el anexo: <b>“INSTRUCCIONES PARA ACCESAR A LA PLATAFORMA REDESLA”</b>
            </p>
            <p>
                5.2.3.- <b>Bitácora de campo</b>. Tal como se mencionó en el punto <b>1.8.4</b>, es necesario que como parte del proceso de investigación cualitativa, se tenga como parte del material de apoyo una bitácora física (cuadernillo) vid punto 1.8.4. Para tener dicho registro en la plataforma, de igual manera tendrá que copiar y pegar sus anotaciones que realizó en la bitácora física a la “BITÁCORA DE CAMPO DIGITAL RELMO”. Dentro de la plataforma encontrará las indicaciones para realizar el proceso completo.
            </p>
            <h3>VI.- SOBRE EL ENVÍO PARA LA VALIDACIÓN.</h3>
            <p>
                Una vez transcritas sus 30 entrevistas y haber corroborado que la información ha sido correcta, deberá presionar el botón de “ENVIAR A VALIDACIÓN DE ENTREVISTAS”.
            </p>
            <p>
                Recordar que este proceso de reclutamiento, aplicación, transcripción y captura en la plataforma para envío de validación comprende del 16 de mayo al 15 de junio del 2022.
            </p>
            <p>
                Desde el momento en que envían a validación sus entrevistas, se comenzarán a hacer las validaciones por parte del equipo coordinador de la investigación. El comité académico de RELMO, les enviará el resultado de su validación a más tardar el día 30 de junio del 2022.
            </p>
            <p>
                El equipo podrá recibir dos tipos de resultados de la validación:
            </p>
            <p>
            <ol type="1">
                <li><b>“TODAS LAS ENTREVISTAS VALIDADAS”</b>. Esperar indicaciones por parte del equipo coordinador de la investigación para continuar con la fase II del proceso de investigación.</li>
                <li><b>“X ENTREVISTA POR CORREGIR” (RECHAZADO)</b>. En caso de que se encuentren entrevistas mal elaboradas o transcripciones erróneas, se recibirá este resultado, por lo tanto, el equipo de investigación contará con 4 días para enviar las correcciones solicitadas. Una vez realizadas las correcciones y validadas por el equipo coordinador de la investigación, deberán de esperar indicaciones por parte del equipo coordinador para continuar con la fase II del proceso de investigación.</li>
                <li>Milk</li>
            </ol>
            </p>
            <p>
                FINALIZA PRIMERA FASE DE PROCESO DE LA PRIMERA INVESTIGACIÓN RELMO 2022.
            </p>
            <p>
                Esperar aviso para la capacitación para segunda fase de proceso de investigación cualitativa. Segunda quincena del mes de julio del 2022.
            </p>
            <h3>Fechas importantes</h3>
            <ul>
                <li>Capacitación para equipos de investigación o investigadoras 13 de mayo 2022.</li>
                <li>Aplicación de entrevistas, y captura de resultados para la investigación por parte de los equipos de investigación:
                    16 de mayo a 15 de junio. </li>
                <li>Revisión y entrega de resultados por parte del Comité Académico de la investigación
                    RELMO de la validación de su captura de entrevistas a los grupos de investigación : Hasta el 27 de junio 2022.</li>
                <li>Capacitación para segunda fase de investigación: segunda quincena de julio de 2022.</li>
                <li>Límite de pago de cuota: 15 de julio de 2022.</li>
            </ul>
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
            <li>Lista de categorias Word/Pdf</li>
            <a href="<?= base_url('resources/pdf/Lista de categorias RELEG.pdf') ?>" target="_blank">Lista de categorias WORD/PDF</a>
            <li>Presentación 2da Fase de la investgación</li>
            <a href="https://drive.google.com/file/d/1o3VbQToOtYRG0hxvI3H5HERyfR_awN0Y/view?usp=share_link" target="_blank">https://drive.google.com/file/d/1o3VbQToOtYRG0hxvI3H5HERyfR_awN0Y/view?usp=share_link</a>
            <br>
            <li>Subir audios:</li>
            <a target="_blank" href="<?php echo $info["carpeta"]["recibidos"] ?>">Ir a la carpeta para el grupo <?= $_SESSION["CA"] ?></a><br>

            
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
                    proporcionados por sus sujetas de investigación y que corresponden a alguna o algunas  categorías 
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
                    ser considerada dentro de la investigación,  puede hacerlo dando clic en el botón de <a href="#proponer">PROPONER CATEGORÍA</a> y 
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
                if(!empty($info['propuestas'])){
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
                                <td><?= $c['activo'] == 1 ? '<i class="fas fa-check-circle verde"></i> Validado': '<i class="fas fa-info-circle text-warning"></i> En revisión'; ?></td>
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
                <script>
                    $("#editarPropuesta").on('click',function(){
                        var nombre = $(this).data('nombre');
                        var descripcion = $(this).data('descripcion');
                        var codigo = $(this).data('codigo');
                        var id = $(this).data('id');

                        $("#nombreEdit").val(nombre);
                        $("#descripcionEdit").val(descripcion);
                        $("#codigo_en_vivo_edit").val(codigo);
                        $("#id_edit_propuesta").val(id);
                    })
                </script>
                
                <?php
            }else if ($info["validacion"][0]["terminado"] == 0) {
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
            }else if ($info["validacion"][0]["terminado"] == 3) {
            ?>
                <h3 class="text-center" style="color:#ffc000">
                    Investigadoras: atender una revisión implica que tiene que REENVIAR las entrevistas. DEBE RE-CAPTURAR(captura un nuevo ID de entrevista) o
                    editar (mantener el mismo ID de entrevista), esto se lleva a cabo dando clic al ícono del pincel, el cual se encuentra al lado de su listado de entrevistas.
                    Si requiere (n) más información por favor consulte su correo o el apartado de "INICIO"./h3>
                    <br>
                    <p class='text-center'>UNA VEZ QUE <b><u>TODAS</u></b> LAS INTEGRANTES HAYAN REALIZADO EN SU TOTALIDAD LAS CORRECCIONES QUE LES FUERON INDICADAS POR EL COMITÉ REVISOR, POR FAVOR DÉ CLICK EN EL BOTÓN PARA ENVIARLO NUEVAMENTE A REVISIÓN</p>
                    <a id="volverValidar" class="btn btn-rounded btn-block bg-<?= $_SESSION['red'] ?> " style="text-decoration:none; color:var(--font-primary-color)" data-ca="<?php echo $_SESSION["CA"] ?>" href="volverValidar()" href="<?php echo base_url("validacionRelmo/$nombre"); ?>" />De clic aquí para enviar correcciones</a>

                <?php
            }else if ($info["validacion"][0]["terminado"] == 5) {
                ?>
                <h2 class="text-center text-warning">Su categorización se encuentran en un estado de revisión. Mantente pendiente en los correos y en las plataforma para recibir actualizaciones de su revisión</h2>
                <?php
            }else if ($info["validacion"][0]["terminado"] == 6) {
                ?>
                <h2 class="text-center text-success">Su categorización fue un éxito. Espere instrucciones para la 3ra fase de la investigación RELEG</h2>
                <?php
                #|| $_SESSION['CA'] == 'MXM-UAEMEX01'
                if($_SESSION['CA'] == 'CG-LoebGi9KFM'){
                ?>
                <a href="../capitulo/<?= $_SESSION["CA"] . "/" . $info["password"] ?>">Link siguiente</a>
                <a href="https://www.relmo.org/entrevistas/listaCategorias/">Categorias</a>
                <?php
                }
            }else if ($info["validacion"][0]["terminado"] == 7) {
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
            }else if ($info["validacion"][0]["terminado"] == 9) {
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
            }else if ($info["validacion"][0]["terminado"] == 8) {
                ?>
                <h2 class="text-center text-warning">Su categorización se encuentran en un estado de revisión. Mantente pendiente en los correos y en las plataforma para recibir actualizaciones de su revisión</h2>
                <?php
            }
            ?>
        </div>
        <br><br><br>
    </div>
    <script>

        $(document).on('click', '#eliminar', function(e) {
            var productId = $(this).data('id');
            SwalDelete(productId);
            e.preventDefault();
        });

        $(document).on('click', '#eliminarCategoria', function(e) {
            var productId = $(this).data('id');
            SwalDelete(productId);
            e.preventDefault();
        });

        $(document).on("click", "#recapturar", function(e) {
            var id = $(this).data('id');
            recapturar(id);
            e.preventDefault();
        });

        $(document).on("click", "#editar", function(e) {
            var id = $(this).data('id');
            editar(id);
            e.preventDefault();
        });

        $(document).on('click', '#terminar', function(e) {
            var proyecto = $("#nombre_proyecto").val();
            terminarProceso(proyecto);
            e.preventDefault();
        });

        $(document).on('click', '#volverValidar', function(e) {
            var proyecto = $("#nombre_proyecto").val();
            volverValidar(proyecto);
            e.preventDefault();
        });

        $(document).on('click','#terminar2dafase', function(){
            var proyecto = $("#nombre_proyecto").val();
            terminarProceso2daFase(proyecto);
            e.preventDefault();
        });

        $(document).on('click', '#volverValidar2', function(e) {
            var proyecto = $("#nombre_proyecto").val();
            volverValidar2(proyecto);
            e.preventDefault();
        });

        $(document).on('click', '#eliminarCodigos', function(e) {
            var claveCuerpo = $(this).data('clave');
            deleteCategorizacion(claveCuerpo);
            e.preventDefault();
        });

        function SwalDelete(productId) {

            swal.fire({
                title: '¿Estas seguro?',
                text: "Se eliminará la entrevista junto con su bitácora. Esta acción no se puede deshacer",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, bórralo!',
                showLoaderOnConfirm: true,

                preConfirm: function() {
                    return new Promise(function(resolve) {

                        $.ajax({
                                url: base_url + "/borrarEntrevista/" + productId,
                                type: 'POST',
                                dataType: 'json'
                            })
                            .done(function(response) {
                                swal.fire('Eliminado!', response.message, response.status).then(function() {
                                    location.reload();
                                })
                                //redireccionar
                            })
                            .fail(function() {
                                swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

        }

        function terminarProceso(proyecto) {

            swal.fire({
                icon: 'warning',
                title: '¿Desea terminar el proceso de captura de entrevistas?',
                text: 'Esta acción no es reversible',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',

                preConfirm: function() {
                    return new Promise(function(resolve) {

                        $.ajax({
                                url: base_url + "/validacionRelmo/" + proyecto,
                                type: 'POST',
                                dataType: 'json'
                            })
                            .done(function(response) {
                                console.log(response);
                                swal.fire('¡Importante!', response.message, response.status).then(function() {
                                    location.reload();
                                })
                            })
                            .fail(function(jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR);
                                console.log(textStatus);
                                console.log(errorThrown);
                                swal.fire('Oops...', 'Algo salió mal !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

        }

        function recapturar(id) {
            $.ajax({
                    url: base_url + "/takeid",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    }
                })
                .done(function(response) {
                    if (response == 'nais') {
                        window.location.href = base_url + "/recapturarEntrevista";
                    } else {
                        swal.alert({
                            icon: 'error',
                            title: 'Ha ocurrido un error. Intente mas tarde nuevamente',
                            footer: '¿El problema persiste? Contacte al siguiente correo: jaramosp@e.redesla.net'
                        })
                    }
                    //window.location.href = base_url + "recapturarEntrevista";
                    //redireccionar
                })
                .fail(function() {
                    swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
                });

        }

        function editar(id) {
            console.log('entra');
            $.ajax({
                    url: base_url + "/takeid",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    }
                })
                .done(function(response) {
                    if (response == 'nais') {
                        window.location.href = base_url + "/editarEntrevista";
                    } else {
                        swal.alert({
                            icon: 'error',
                            title: 'Ha ocurrido un error. Intente mas tarde nuevamente',
                            footer: '¿El problema persiste? Contacte al siguiente correo: jaramosp@e.redesla.net'
                        })
                    }
                    //window.location.href = base_url + "recapturarEntrevista";
                    //redireccionar
                })
                .fail(function() {
                    swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
                });

        }

        function volverValidar(proyecto) {

            swal.fire({
                icon: 'warning',
                title: '¿Desea reenviar el proceso de recaptura de entrevistas?',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',

                preConfirm: function() {
                    return new Promise(function(resolve) {

                        $.ajax({
                                url: base_url + "/validacionRelmo/" + proyecto,
                                type: 'POST',
                                dataType: 'json'
                            })
                            .done(function(response) {
                                console.log(response);
                                swal.fire('¡Importante!', response.message, response.status).then(function() {
                                    location.reload();
                                })
                            })
                            .fail(function(jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR);
                                console.log(textStatus);
                                console.log(errorThrown);
                                swal.fire('Oops...', 'Algo salió mal !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

        }

        function terminarProceso2daFase(proyecto){
            swal.fire({
                icon: 'warning',
                title: '¿Desea terminar el proceso de categorización?',
                text: 'Esta acción no es reversible',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',

                preConfirm: function() {
                    return new Promise(function(resolve) {

                        $.ajax({
                                url: base_url + "/validacionRelmo/" + proyecto,
                                type: 'POST',
                                dataType: 'json'
                            })
                            .done(function(response) {
                                console.log(response);
                                swal.fire('¡Importante!', response.message, response.status).then(function() {
                                    location.reload();
                                })
                            })
                            .fail(function(jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR);
                                console.log(textStatus);
                                console.log(errorThrown);
                                swal.fire('Oops...', 'Algo salió mal !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });
        }

        function volverValidar2(proyecto) {

            swal.fire({
                icon: 'warning',
                title: '¿Desea reenviar el proceso de categorización?',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',

                preConfirm: function() {
                    return new Promise(function(resolve) {

                        $.ajax({
                                url: base_url + "/validacionRelmo/" + proyecto,
                                type: 'POST',
                                dataType: 'json'
                            })
                            .done(function(response) {
                                console.log(response);
                                swal.fire('¡Importante!', response.message, response.status).then(function() {
                                    location.reload();
                                })
                            })
                            .fail(function(jqXHR, textStatus, errorThrown) {
                                console.log(jqXHR);
                                console.log(textStatus);
                                console.log(errorThrown);
                                swal.fire('Oops...', 'Algo salió mal !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

        }

        function SwalDelete(productId) {

            swal.fire({
            title: '¿Estas seguro?',
            text: "Se eliminará la propuesta de categoría. Esta acción no se puede deshacer",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, bórralo!',
            showLoaderOnConfirm: true,

            preConfirm: function() {
                return new Promise(function(resolve) {

                    $.ajax({
                            url: base_url + "/generalDelete/categorias",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id:productId
                            }
                        })
                        .done(function(response) {
                            swal.fire('Eliminado!', response.message, response.status).then(function() {
                                location.reload();
                            })
                            //redireccionar
                        })
                        .fail(function(e) {
                            console.log(e);
                            swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
                        });
                });
            },
            allowOutsideClick: false
            });
        }

        function deleteCategorizacion(claveCuerpo){
            swal.fire({
            title: '¿Estas seguro?',
            text: "Se eliminarán todos las categorizaciones que se hayan registrado. Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, bórralo!',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,

            preConfirm: function() {
                return new Promise(function(resolve) {

                    $.ajax({
                            url: base_url + "/deleteCategorias",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                claveCuerpo:claveCuerpo
                            }
                        })
                        .done(function(response) {                            
                            swal.fire('Eliminado!', response.message, response.status).then(function() {
                                location.reload();
                            })
                            
                            //redireccionar
                        })
                        .fail(function(e) {
                            console.log(e);
                            swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
                        });
                });
            },
            allowOutsideClick: false
            });
        }

    </script>
<?php
}

function desafioReleem2022($nombre, $info)
{
?>
    <div class="card card-body-congresos">
        <div class="card-header card-header-congresos">
            <h1>1er Desafío Releem 2022</h1>
        </div>
        <hr>
        <p>
            Para participar en el Desafío RELEEM sera mediante la plataforma de <a href="https://iquatroeditores.com/revista/index.php/index" target="_blank">iQuatro Editores</a>.
        </p>
        <p>
            Para consultar todos los detalles en la convocatoria: <a href="https://drive.google.com/file/d/1csruvjW4iV3t9_808Zg7z4gZWwqpJlha/view?usp=sharing" target="_blank">Haga click aquí</a>
        </p>
        <h3>Objetivo</h3>
        <p>
            Aportar soluciones a una problemática particular contextualizada en el ámbito de Latinoamérica y se llevará a cabo de manera
            anual. La propuesta presentada en iQuatro Editores será evaluada bajo el proceso de
            revisión por pares a doble ciego. <br>
            El número de personas con limitaciones para moverse de manera autónoma en su entorno -es
            decir, quienes tienen alguna discapacidad motriz- se incrementa en el mundo y en Latinoamérica
            día con día. Entre ellas, particularmente en Latinoamérica, la gran mayoría no tienen acceso a
            las soluciones tecnológicas de diagnóstico y tratamiento, que les permitan mejorar su calidad de
            vida e inclusión en la sociedad. El desafío consiste en presentar análisis y propuestas de solución
            de movilidad de personas con limitaciones psicomotrices en Latinoamérica, mediante la
            innovación científica y tecnológica del área de la eléctrica, electrónica y mecatrónica,
            considerando las realidades locales de este fenómeno.
        </p><br>
        <h3>Las propuestas pueden consistir en:</h3>
        <ul>
            <li>Una solución a un problema de movilidad de personas con discapacidad detectado
                dentro de Latinoamérica.</li>
            <li>Desarrollo tecnológico de un producto, proceso o sistema de la eléctrica, electrónica y
                mecatrónica para la solución de problemas de los sectores social y productivo.</li>
            <li>Hallazgos derivados de investigaciones científicas aplicadas a la movilidad de personas
                con discapacidad.</li>
        </ul>
        <h3>Criterios de evaluación del trabajo en extenso del miembro investigador</h3>
        <p>Los trabajos presentados deberán cumplir con los siguientes requisitos:</p>
        <h5>I. Estructura y contenido</h5>
        <div class="row">
            <div class="col-md-6">
                <ul>
                    <li>Resumen</li>
                    <li>Palabras clave</li>
                    <li>Introducción</li>
                    <li>Marco teórico</li>
                    <li>Materiales y Métodos</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul>
                    <li>Resultados</li>
                    <li>Discusión</li>
                    <li>Conclusiones</li>
                    <li>Referencias</li>
                </ul>
            </div>
        </div>
        <h5>II. Formato</h5>
        <p>
            El estilo de redacción y citas deberá adecuarse al manual de estilo APA 7ma edición.
            Deberán usar la <a target="_blank" href="https://view.officeapps.live.com/op/view.aspx?src=https%3A%2F%2Fiquatroeditores.com%2Fdownloads%2FPlantilla%2520de%2520Trabajo%2520RELEEM%25202021.docx&wdOrigin=BROWSELINK">“Plantilla de trabajo de Desafío”</a> disponible en la página de la editorial,
            la cual servirá como guía para definir el tipo de letra, tamaño, espacio y márgenes. El
            trabajo deberá ser una contribución original, con una extensión de entre 2000 y 8000
            palabras y un máximo de 15 cuartillas, incluidas las referencias. Las tablas, gráficas y
            cuadros deberán estar en formato editable de Word y no como una imagen, si existiesen
            figuras deberán estar en formato jpg de 320 ppp o más.

            Para conocer todos los criterios de evaluación puede ver los criterios editoriales en la
            página de <a href="https://iquatroeditores.com/revista/index.php/index" target="_blank">iQuatro Editores</a>.
        </p>
        <h5>III. ENVIO DEL PROYECTO</h5>
        <p>
            Preparar el artículo usando la plantilla de trabajo adecuada y subirlo en la plataforma de la
            <a href="https://iquatroeditores.com/revista/index.php/iquatro/about/submissions">iQuatro Editores</a>. Para subir su trabajo, deberá solo un participante registrarse en la
            <a href="https://iquatroeditores.com/revista/index.php/iquatro/user/register">plataforma de iQuatro Editores</a> e iniciar sesión realizando el siguiente proceso
        </p>
        <ol type="a">
            <li>Registro en plataforma de iQuatro Editores: <a href="https://iquatroeditores.com/revista/index.php/iquatro/user/register">Registrarse | Libros IQuatro (iquatroeditores.com)</a>. Si ya cuenta con un usuario, omita este paso e inicie sesión.</li>
            <li>Dé clic en <b>Enviar artículo</b>. (Revise que cumpla con todos los requisitos enlistados, antes de proceder con el envío de su artículo)</li>
            <li>En caso de que cumpla con todos los requisitos, enviar el archivo del artículo en formato Word, respetando la
                “<a href="https://iquatroeditores.com/downloads/Plantilla%20de%20Trabajo%20RELEEM%202021.docx">plantilla de trabajo</a>” y los parámetros mencionados en el apartado <b>II. Formato</b> de la convocatoria.</li>
            <li>Introducir los “<b>metadatos (nombre de artículo y autores)</b>” y el “<b>resumen</b>”. En la pestaña de “CONFIRMACIÓN”
                dar clic al botón: <b>Finalizar el envío</b>, se le asignará un ID para su trabajo. Es importante que su archivo
                Word no contenga el nombre de los autores para garantizar la revisión anónima.</li>
            <li>Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores,
                es importante verificar la bandeja de correo no deseado.</li>
            <li>El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o rechazada la presentación del DESAFÍO en el
                <b>2do. Congreso Latinoamericano de Investigación en Eléctrica, Electrónica y Mecatrónica RELEEM 2022</b>.
                Se notificará dicho dictamen vía electrónica.
            </li>
            <li>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten. </li>
            <li>Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego para
                determinar si dicha ponencia será publicada como capítulo en el libro electrónico.</li>
            <li>Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de
                publicación; una vez realizada la revisión por pares y enviadas sus correcciones.</li>
            <li>j) Una vez aceptada la publicación y otorgado el dictamen recibirá la carta de cesión de derechos misma
                que deberá editar, firmar y subirla a la <a href="https://iquatroeditores.com/revista/index.php/iquatro/user/register">plataforma</a> escaneada en formato pdf, según las indicaciones de
                la editorial iQuatro Editores.</li>
        </ol>
        <p>
            Nota: Todos los trabajos sin excepción serán revisados por pares a doble ciego siguiendo las pautas establecidas por RELEEM y la editorial iQuatro Editores.
        </p>
        <br><br>
    </div>
<?php
}

function pruebarelmo($nombre, $info)
{
?>
    <h1 class="text-center"><?= $_SESSION["CA"] ?></h1>
    <hr>
    <table class="display nowrap table table-dark text-center" id="example" style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Edad</th>
                <th scope="col">Estado civil</th>
                <th scope="col">Numero de hijos</th>
                <th scope="col">Ver completa</th>
                <th scope="col">Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($info["entrevistas"] as $e) {
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $e["edad"] ?></td>
                    <td><?= $e["estado_civil"] ?></td>
                    <td><?= $e["hijos"] ?></td>
                    <td><a href="" class="btn btn-primary">Ver completa</a></td>
                    <td><button id="eliminar" data-id="<?= $e["id"] ?>" href="eliminar()" class="btn btn-danger">Borrar</button></td>
                </tr>
            <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <a href="#addEntrevista" data-toggle='modal' class="btn btn-info btn-block">Añadir entrevista</a>


    <div id="addEntrevista" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir entrevista</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url("insertEntrevista") ?>" method="post">
                        <h4>Edad</h4>
                        <input type="number" name="edad" class="form-control">
                        <h4>Estado civil</h4>
                        <input type="text" name="estado_civil" class="form-control">
                        <h4>Numero de hijos</h4>
                        <input type="number" name="hijos" class="form-control">
                        <hr>
                        <input type="submit" class="btn btn-primary btn-block" value="Subir entrevista">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).on('click', '#eliminar', function(e) {
            var productId = $(this).data('id');
            SwalDelete(productId);
            e.preventDefault();
        });

        function SwalDelete(productId) {

            swal.fire({
                title: 'Estas seguro?',
                text: "Se eliminara la entrevista seleccionada",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, bórralo!',
                showLoaderOnConfirm: true,

                preConfirm: function() {
                    return new Promise(function(resolve) {

                        $.ajax({
                                url: base_url + "simpleDelete/entrevistas/" + productId,
                                type: 'POST',
                                dataType: 'json'
                            })
                            .done(function(response) {
                                swal.fire('Eliminado!', response.message, response.status).then(function() {
                                    location.reload();
                                })
                                //redireccionar
                            })
                            .fail(function() {
                                swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });

        }
    </script>
<?php
}

function esquemaAReleem2022($nombre, $info)
{
?>

    <div class="card text-white bg-dark">
        <div class="card-header">
            <h3>Te has registrado al <?= urldecode($nombre) ?></h3>
        </div>
        <div class="card-body text-center">
            <h3>1.- Instrucciones</h3>
            <style>
                ol {
                    counter-reset: item
                }

                li {
                    display: block
                }

                li:before {
                    content: counters(item, '.') ' ';
                    counter-increment: item
                }
            </style>
            <img src='https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEEM (1).jpg' style="height:150px; text-align:center" />
            <p>
                Apreciable investigador (a) <b><?= $_SESSION['nombre_completo'] ?></b>
            </p>
            <p>
                Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del <b><span style='color:#b246fc'>'2do. Congreso
                        Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022'</span></b>.
            </p>
            <p>
                Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio '<b>Vive RedesLA</b>'
                y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: la <b><span style='color:#b246fc'>Universidad Autónoma de Zacatecas
                        'Francisco García Salinas' (Unidad Académica de Ingeniería Eléctrica) en Zacatecas, Zacatecas</span></b>, quienes en
                conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><span style='color:#b246fc'>RELEEM</span></b>, llevarán a cabo la organización
                de este congreso de investigación, los días <b>08 y 09 de septiembre del 2022</b>.
            </p>
            <p>
                Para continuar con su participación deberá hacer el '<b>Envío de artículo-ponencia</b>'
            </p>
            <p>
                <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de
                    <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>iQuatro Editores</a> e iniciar sesión realizando el siguiente proceso:</b>
            </p>
            <p>
            <ol>
                <li>
                    Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro
                    en plataforma de iQuatro Editores: <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>Registrarse | Libros IQuatro(iquatroeditores.com)</a>.
                    Si ya cuenta con un usuario, omita este paso e inicie sesión.
                </li>
                <li>
                    Dé clic en: <b>Enviar artículo</b>.
                </li>
                <ol>
                    <li>
                        Revise que cumpla con todos los <a href='https://iquatroeditores.com/revista/index.php/iquatro/about/submissions'>requisitos</a>, antes de proceder con el envío de su artículo.
                    </li>
                </ol>
                <li>
                    En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la
                    '<a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a>' y plantilla de trabajo misma que contiene los parámetros mencionados en el
                    apartado <b>I. Formato de la <a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a></b>.
                </li>
                <li>
                    Introducir <b>'los metadatos (nombre de artículo y autores)' y 'el resumen'</b>. En la pestaña de 'CONFIRMACIÓN'
                    dar clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. <i>Es importante que su archivo
                        Word no contenga el nombre de los autores para garantizar la revisión anónima</i>.
                </li>
                <li>
                    Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores,
                    es importante verificar la bandeja de correo no deseado, ver <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>manual</a> de envío <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>aquí</a>.
                </li>
                <li>
                    El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o rechazada la
                    presentación de la ponencia en el <b>2do. Congreso Latinoamericano de Investigación en Energía,
                        Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>. Se notificará dicho dictamen vía electrónica.
                </li>
                <li>
                    <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten.</i></b>
                </li>
                <li>
                    Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar
                    si dicha ponencia será publicada como capítulo en el <a href='https://www.releem.org/'>libro electrónico</a> del '<b>2do. Congreso Latinoamericano
                        de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>'.
                </li>
                <li>
                    Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación;
                    una vez realizada la revisión por pares y enviadas sus correcciones.
                </li>
                <li>
                    Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que
                    deberá editar, firmar y subirla a la <a href='https://iquatroeditores.com/revista/index.php/iquatro/login'>plataforma</a> escaneada en formato PDF, según las indicaciones
                    de la editorial iQuatro Editores.
                </li>
            </ol>
            </p>
            <p>
                <b><u>Una vez aceptada su ponencia: </u></b>
            </p>
            <p>
                Se deberá cubrir a más tardar el 05 de septiembre del presente año la <b>tarifa de inscripción</b>: $6,440.00
                (seis mil cuatrocientos cuarenta pesos 00/100 MXN) IVA incluido por ponencia, para los participantes
                fuera de México será de: 333 USD (trescientos treinta y tres dólares 00/100 USD) IVA incluido por ponencia,
                esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar conformados con un número mayor
                de alumnos y al menos con un profesor.
            </p>
            <p>
                Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 18 de julio del 2022,
                con la <b>tarifa de inscripción con descuento</b>: $6,040.00 (seis mil cuarenta pesos 00/100 MXN) IVA incluido
                por ponencia, para los participantes fuera de México será de 308 USD: (trescientos ocho dólares 00/100 USD)
                IVA incluido por ponencia, esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar
                conformados con un número mayor de alumnos y al menos con un profesor.
            </p>
            <p>
                Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca
                móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en
                la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria
                    030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de forma
                directa, OXXO y otras tiendas de conveniencia: <a href='https://link.mercadopago.com.mx/sdmypesredesla'>https://link.mercadopago.com.mx/sdmypesredesla</a>
            </p>
            <p>
                Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una plataforma
                online a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus
                bancos, o bien podrá ejecutarlo desde este link: <a href='https://paypal.me/paqueteb1?locale.x=es_XC'>https://paypal.me/paqueteb1?locale.x=es_XC</a>.
            </p>
            <p>
                Recuerde colocar el en concepto su ID del artículo-Congreso RELEEM.
            </p>
            <p>
                <b>MANTÉNGASE ACTUALIZADO:</b>
            </p>
            <p>
                Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle
                'like' a nuestra página de Facebook para estar actualizado de todas las actividades a realizar: <br>
                <a href='https://www.facebook.com/RELEEM.ORG'>https://www.facebook.com/RELEEM.ORG</a>
            </p>
            <p>
                Esperamos verlos y contar con su presencia física o virtual y asistiendo a las actividades de nuestro
                <b><span style='color:#b246fc'>2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</span></b>.<br>
                <b><span style='color:#b246fc'>#</span>Pasión<span style='color:#b246fc'>Por</span>La<span style='color:#b246fc'>Investigación</span></b>
            </p>
            <h3>2.- Gafetes</h3>
            <?php
            if (empty($info["infoGafetes"])) {
                echo 'Las claves de gafete aún se encuentran en proceso. Cuando esten listas se veran reflejadas en este apartado.';
            } else {
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Clave de gafete</th>
                                    <th scope="col">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($info["infoGafetes"] as $autor) {
                                ?>
                                    <tr>
                                        <td><?php echo $autor["clave_gafete"] ?></td>
                                        <td><?php echo $autor["nombre"] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
            <hr>
            <p>* Si desea facturar, vaya al apartado de <b>Facturas</b> ubicado en el menú lateral de esta página.</p>
        </div>
    </div>

<?php
}

function esquemaBReleem2022($nombre, $info)
{
?>
    <div class="card text-white bg-dark">
        <div class="card-header">
            <h3>Te has registrado al <?= urldecode($nombre) ?></h3>
        </div>
        <div class="card-body text-center">
            <h3>1.- Instrucciones</h3>
            <style>
                ol {
                    counter-reset: item
                }

                li {
                    display: block
                }

                li:before {
                    content: counters(item, '.') ' ';
                    counter-increment: item
                }
            </style>
            <img src='https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEEM (1).jpg' style="height:150px; text-align:center" />
            <p>
                Apreciable investigador (a) <b><?= $_SESSION['nombre_completo'] ?></b>
            </p>
            <p>
                Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del <b><span style='color:#b246fc'>'2do. Congreso
                        Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022'</span></b>.
            </p>
            <p>
                Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio '<b>Vive RedesLA</b>'
                y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: la <b><span style='color:#b246fc'>Universidad Autónoma de Zacatecas
                        'Francisco García Salinas' (Unidad Académica de Ingeniería Eléctrica) en Zacatecas, Zacatecas</span></b>, quienes en
                conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><span style='color:#b246fc'>RELEEM</span></b>, llevarán a cabo la organización
                de este congreso de investigación, los días <b>08 y 09 de septiembre del 2022</b>.
            </p>
            <p>
                Para continuar con su participación deberá hacer el '<b>Envío de artículo-ponencia</b>'
            </p>
            <p>
                <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de
                    <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>iQuatro Editores</a> e iniciar sesión realizando el siguiente proceso:</b>
            </p>
            <p>
            <ol>
                <li>
                    Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro
                    en plataforma de iQuatro Editores: <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>Registrarse | Libros IQuatro(iquatroeditores.com)</a>.
                    Si ya cuenta con un usuario, omita este paso e inicie sesión.
                </li>
                <li>
                    Dé clic en: <b>Enviar artículo</b>.
                </li>
                <ol>
                    <li>
                        Revise que cumpla con todos los <a href='https://iquatroeditores.com/revista/index.php/iquatro/about/submissions'>requisitos</a>, antes de proceder con el envío de su artículo.
                    </li>
                </ol>
                <li>
                    En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la
                    '<a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a>' y plantilla de trabajo misma que contiene los parámetros mencionados en el
                    apartado <b>I. Formato de la <a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a></b>.
                </li>
                <li>
                    Introducir <b>'los metadatos (nombre de artículo y autores)' y 'el resumen'</b>. En la pestaña de 'CONFIRMACIÓN'
                    dar clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. <i>Es importante que su archivo
                        Word no contenga el nombre de los autores para garantizar la revisión anónima</i>.
                </li>
                <li>
                    Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores,
                    es importante verificar la bandeja de correo no deseado, ver <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>manual</a> de envío <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>aquí</a>.
                </li>
                <li>
                    El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o rechazada la
                    presentación de la ponencia en el <b>2do. Congreso Latinoamericano de Investigación en Energía,
                        Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>. Se notificará dicho dictamen vía electrónica.
                </li>
                <li>
                    <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten.</i></b>
                </li>
                <li>
                    Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar
                    si dicha ponencia será publicada como capítulo en el <a href='https://www.releem.org/'>libro electrónico</a> del '<b>2do. Congreso Latinoamericano
                        de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>'.
                </li>
                <li>
                    Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación;
                    una vez realizada la revisión por pares y enviadas sus correcciones.
                </li>
                <li>
                    Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que
                    deberá editar, firmar y subirla a la <a href='https://iquatroeditores.com/revista/index.php/iquatro/login'>plataforma</a> escaneada en formato PDF, según las indicaciones
                    de la editorial iQuatro Editores.
                </li>
            </ol>
            </p>
            <p>
                <b><u>Una vez aceptada su ponencia: </u></b>
            </p>
            <p>
                Se deberá cubrir a más tardar el 05 de septiembre del presente año la <b>tarifa de inscripción</b>: $6,440.00
                (seis mil cuatrocientos cuarenta pesos 00/100 MXN) IVA incluido por ponencia, para los participantes
                fuera de México será de: 333 USD (trescientos treinta y tres dólares 00/100 USD) IVA incluido por ponencia,
                esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar conformados con un número mayor
                de alumnos y al menos con un profesor.
            </p>
            <p>
                Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 18 de julio del 2022,
                con la <b>tarifa de inscripción con descuento</b>: $6,040.00 (seis mil cuarenta pesos 00/100 MXN) IVA incluido
                por ponencia, para los participantes fuera de México será de 308 USD: (trescientos ocho dólares 00/100 USD)
                IVA incluido por ponencia, esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar
                conformados con un número mayor de alumnos y al menos con un profesor.
            </p>
            <p>
                Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca
                móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en
                la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria
                    030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de forma
                directa, OXXO y otras tiendas de conveniencia: <a href='https://link.mercadopago.com.mx/sdmypesredesla'>https://link.mercadopago.com.mx/sdmypesredesla</a>
            </p>
            <p>
                Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una plataforma
                online a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus
                bancos, o bien podrá ejecutarlo desde este link: <a href='https://paypal.me/paqueteb1?locale.x=es_XC'>https://paypal.me/paqueteb1?locale.x=es_XC</a>.
            </p>
            <p>
                Recuerde colocar el en concepto su ID del artículo-Congreso RELEEM.
            </p>
            <p>
                <b>MANTÉNGASE ACTUALIZADO:</b>
            </p>
            <p>
                Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle
                'like' a nuestra página de Facebook para estar actualizado de todas las actividades a realizar: <br>
                <a href='https://www.facebook.com/RELEEM.ORG'>https://www.facebook.com/RELEEM.ORG</a>
            </p>
            <p>
                Esperamos verlos y contar con su presencia física o virtual y asistiendo a las actividades de nuestro
                <b><span style='color:#b246fc'>2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</span></b>.<br>
                <b><span style='color:#b246fc'>#</span>Pasión<span style='color:#b246fc'>Por</span>La<span style='color:#b246fc'>Investigación</span></b>
            </p>
            <h3>2.- Gafetes</h3>
            <?php
            if (empty($info["infoGafetes"])) {
                echo 'Las claves de gafete aún se encuentran en proceso. Cuando esten listas se veran reflejadas en este apartado.';
            } else {
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Clave de gafete</th>
                                    <th scope="col">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($info["infoGafetes"] as $autor) {
                                ?>
                                    <tr>
                                        <td><?php echo $autor["clave_gafete"] ?></td>
                                        <td><?php echo $autor["nombre"] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
            <hr>
            <p>* Si desea facturar, vaya al apartado de <b>Facturas</b> ubicado en el menú lateral de esta página.</p>
        </div>
    </div>
<?php
}

function esquemaCReleem2022($nombre, $info)
{
?>
    <div class="card text-white bg-dark">
        <div class="card-header">
            <h3>Te has registrado al <?= urldecode($nombre) ?></h3>
        </div>
        <div class="card-body text-center">
            <h3>1.- Instrucciones</h3>
            <style>
                ol {
                    counter-reset: item
                }

                li {
                    display: block
                }

                li:before {
                    content: counters(item, '.') ' ';
                    counter-increment: item
                }
            </style>
            <img src='https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEEM (1).jpg' style="height:150px; text-align:center" />
            <p>
                Apreciable investigador (a) <b><?= $_SESSION['nombre_completo'] ?></b>
            </p>
            <p>
                Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del <b><span style='color:#b246fc'>'2do. Congreso
                        Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022'</span></b>.
            </p>
            <p>
                Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio '<b>Vive RedesLA</b>'
                y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: la <b><span style='color:#b246fc'>Universidad Autónoma de Zacatecas
                        'Francisco García Salinas' (Unidad Académica de Ingeniería Eléctrica) en Zacatecas, Zacatecas</span></b>, quienes en
                conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><span style='color:#b246fc'>RELEEM</span></b>, llevarán a cabo la organización
                de este congreso de investigación, los días <b>08 y 09 de septiembre del 2022</b>.
            </p>
            <p>
                Para continuar con su participación deberá hacer el '<b>Envío de artículo-ponencia</b>'
            </p>
            <p>
                <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de
                    <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>iQuatro Editores</a> e iniciar sesión realizando el siguiente proceso:</b>
            </p>
            <p>
            <ol>
                <li>
                    Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro
                    en plataforma de iQuatro Editores: <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>Registrarse | Libros IQuatro(iquatroeditores.com)</a>.
                    Si ya cuenta con un usuario, omita este paso e inicie sesión.
                </li>
                <li>
                    Dé clic en: <b>Enviar artículo</b>.
                </li>
                <ol>
                    <li>
                        Revise que cumpla con todos los <a href='https://iquatroeditores.com/revista/index.php/iquatro/about/submissions'>requisitos</a>, antes de proceder con el envío de su artículo.
                    </li>
                </ol>
                <li>
                    En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la
                    '<a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a>' y plantilla de trabajo misma que contiene los parámetros mencionados en el
                    apartado <b>I. Formato de la <a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a></b>.
                </li>
                <li>
                    Introducir <b>'los metadatos (nombre de artículo y autores)' y 'el resumen'</b>. En la pestaña de 'CONFIRMACIÓN'
                    dar clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. <i>Es importante que su archivo
                        Word no contenga el nombre de los autores para garantizar la revisión anónima</i>.
                </li>
                <li>
                    Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores,
                    es importante verificar la bandeja de correo no deseado, ver <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>manual</a> de envío <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>aquí</a>.
                </li>
                <li>
                    El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o rechazada la
                    presentación de la ponencia en el <b>2do. Congreso Latinoamericano de Investigación en Energía,
                        Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>. Se notificará dicho dictamen vía electrónica.
                </li>
                <li>
                    <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten.</i></b>
                </li>
                <li>
                    Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar
                    si dicha ponencia será publicada como capítulo en el <a href='https://www.releem.org/'>libro electrónico</a> del '<b>2do. Congreso Latinoamericano
                        de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>'.
                </li>
                <li>
                    Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación;
                    una vez realizada la revisión por pares y enviadas sus correcciones.
                </li>
                <li>
                    Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que
                    deberá editar, firmar y subirla a la <a href='https://iquatroeditores.com/revista/index.php/iquatro/login'>plataforma</a> escaneada en formato PDF, según las indicaciones
                    de la editorial iQuatro Editores.
                </li>
            </ol>
            </p>
            <p>
                <b><u>Una vez aceptada su ponencia: </u></b>
            </p>
            <p>
                Se deberá cubrir a más tardar el 05 de septiembre del presente año la <b>tarifa de inscripción</b>: $6,440.00
                (seis mil cuatrocientos cuarenta pesos 00/100 MXN) IVA incluido por ponencia, para los participantes
                fuera de México será de: 333 USD (trescientos treinta y tres dólares 00/100 USD) IVA incluido por ponencia,
                esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar conformados con un número mayor
                de alumnos y al menos con un profesor.
            </p>
            <p>
                Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 18 de julio del 2022,
                con la <b>tarifa de inscripción con descuento</b>: $6,040.00 (seis mil cuarenta pesos 00/100 MXN) IVA incluido
                por ponencia, para los participantes fuera de México será de 308 USD: (trescientos ocho dólares 00/100 USD)
                IVA incluido por ponencia, esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar
                conformados con un número mayor de alumnos y al menos con un profesor.
            </p>
            <p>
                Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca
                móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en
                la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria
                    030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de forma
                directa, OXXO y otras tiendas de conveniencia: <a href='https://link.mercadopago.com.mx/sdmypesredesla'>https://link.mercadopago.com.mx/sdmypesredesla</a>
            </p>
            <p>
                Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una plataforma
                online a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus
                bancos, o bien podrá ejecutarlo desde este link: <a href='https://paypal.me/paqueteb1?locale.x=es_XC'>https://paypal.me/paqueteb1?locale.x=es_XC</a>.
            </p>
            <p>
                Recuerde colocar el en concepto su ID del artículo-Congreso RELEEM.
            </p>
            <p>
                <b>MANTÉNGASE ACTUALIZADO:</b>
            </p>
            <p>
                Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle
                'like' a nuestra página de Facebook para estar actualizado de todas las actividades a realizar: <br>
                <a href='https://www.facebook.com/RELEEM.ORG'>https://www.facebook.com/RELEEM.ORG</a>
            </p>
            <p>
                Esperamos verlos y contar con su presencia física o virtual y asistiendo a las actividades de nuestro
                <b><span style='color:#b246fc'>2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</span></b>.<br>
                <b><span style='color:#b246fc'>#</span>Pasión<span style='color:#b246fc'>Por</span>La<span style='color:#b246fc'>Investigación</span></b>
            </p>
            <h3>2.- Gafetes</h3>
            <?php
            if (empty($info["infoGafetes"])) {
                echo 'Las claves de gafete aún se encuentran en proceso. Cuando esten listas se veran reflejadas en este apartado.';
            } else {
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Clave de gafete</th>
                                    <th scope="col">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($info["infoGafetes"] as $autor) {
                                ?>
                                    <tr>
                                        <td><?php echo $autor["clave_gafete"] ?></td>
                                        <td><?php echo $autor["nombre"] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
            <hr>
            <p>* Si desea facturar, vaya al apartado de <b>Facturas</b> ubicado en el menú lateral de esta página.</p>
        </div>
    </div>
<?php
}

function esquemaDReleem2022($nombre, $info)
{
?>
    <div class="card text-white bg-dark">
        <div class="card-header">
            <h3>Te has registrado al <?= urldecode($nombre) ?></h3>
        </div>
        <div class="card-body text-center">
            <h3>1.- Instrucciones</h3>
            <style>
                ol {
                    counter-reset: item
                }

                li {
                    display: block
                }

                li:before {
                    content: counters(item, '.') ' ';
                    counter-increment: item
                }
            </style>
            <img src='https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEEM (1).jpg' style="height:150px; text-align:center" />
            <p>
                Apreciable investigador (a) <b><?= $_SESSION['nombre_completo'] ?></b>
            </p>
            <p>
                Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del <b><span style='color:#b246fc'>'2do. Congreso
                        Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022'</span></b>.
            </p>
            <p>
                Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio '<b>Vive RedesLA</b>'
                y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: la <b><span style='color:#b246fc'>Universidad Autónoma de Zacatecas
                        'Francisco García Salinas' (Unidad Académica de Ingeniería Eléctrica) en Zacatecas, Zacatecas</span></b>, quienes en
                conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><span style='color:#b246fc'>RELEEM</span></b>, llevarán a cabo la organización
                de este congreso de investigación, los días <b>08 y 09 de septiembre del 2022</b>.
            </p>
            <p>
                Para continuar con su participación deberá hacer el '<b>Envío de artículo-ponencia</b>'
            </p>
            <p>
                <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de
                    <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>iQuatro Editores</a> e iniciar sesión realizando el siguiente proceso:</b>
            </p>
            <p>
            <ol>
                <li>
                    Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro
                    en plataforma de iQuatro Editores: <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>Registrarse | Libros IQuatro(iquatroeditores.com)</a>.
                    Si ya cuenta con un usuario, omita este paso e inicie sesión.
                </li>
                <li>
                    Dé clic en: <b>Enviar artículo</b>.
                </li>
                <ol>
                    <li>
                        Revise que cumpla con todos los <a href='https://iquatroeditores.com/revista/index.php/iquatro/about/submissions'>requisitos</a>, antes de proceder con el envío de su artículo.
                    </li>
                </ol>
                <li>
                    En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la
                    '<a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a>' y plantilla de trabajo misma que contiene los parámetros mencionados en el
                    apartado <b>I. Formato de la <a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a></b>.
                </li>
                <li>
                    Introducir <b>'los metadatos (nombre de artículo y autores)' y 'el resumen'</b>. En la pestaña de 'CONFIRMACIÓN'
                    dar clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. <i>Es importante que su archivo
                        Word no contenga el nombre de los autores para garantizar la revisión anónima</i>.
                </li>
                <li>
                    Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores,
                    es importante verificar la bandeja de correo no deseado, ver <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>manual</a> de envío <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>aquí</a>.
                </li>
                <li>
                    El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o rechazada la
                    presentación de la ponencia en el <b>2do. Congreso Latinoamericano de Investigación en Energía,
                        Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>. Se notificará dicho dictamen vía electrónica.
                </li>
                <li>
                    <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten.</i></b>
                </li>
                <li>
                    Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar
                    si dicha ponencia será publicada como capítulo en el <a href='https://www.releem.org/'>libro electrónico</a> del '<b>2do. Congreso Latinoamericano
                        de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>'.
                </li>
                <li>
                    Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación;
                    una vez realizada la revisión por pares y enviadas sus correcciones.
                </li>
                <li>
                    Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que
                    deberá editar, firmar y subirla a la <a href='https://iquatroeditores.com/revista/index.php/iquatro/login'>plataforma</a> escaneada en formato PDF, según las indicaciones
                    de la editorial iQuatro Editores.
                </li>
            </ol>
            </p>
            <p>
                <b><u>Una vez aceptada su ponencia: </u></b>
            </p>
            <p>
                Se deberá cubrir a más tardar el 05 de septiembre del presente año la <b>tarifa de inscripción</b>: $6,440.00
                (seis mil cuatrocientos cuarenta pesos 00/100 MXN) IVA incluido por ponencia, para los participantes
                fuera de México será de: 333 USD (trescientos treinta y tres dólares 00/100 USD) IVA incluido por ponencia,
                esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar conformados con un número mayor
                de alumnos y al menos con un profesor.
            </p>
            <p>
                Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 18 de julio del 2022,
                con la <b>tarifa de inscripción con descuento</b>: $6,040.00 (seis mil cuarenta pesos 00/100 MXN) IVA incluido
                por ponencia, para los participantes fuera de México será de 308 USD: (trescientos ocho dólares 00/100 USD)
                IVA incluido por ponencia, esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar
                conformados con un número mayor de alumnos y al menos con un profesor.
            </p>
            <p>
                Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca
                móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en
                la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria
                    030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de forma
                directa, OXXO y otras tiendas de conveniencia: <a href='https://link.mercadopago.com.mx/sdmypesredesla'>https://link.mercadopago.com.mx/sdmypesredesla</a>
            </p>
            <p>
                Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una plataforma
                online a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus
                bancos, o bien podrá ejecutarlo desde este link: <a href='https://paypal.me/paqueteb1?locale.x=es_XC'>https://paypal.me/paqueteb1?locale.x=es_XC</a>.
            </p>
            <p>
                Recuerde colocar el en concepto su ID del artículo-Congreso RELEEM.
            </p>
            <p>
                <b>MANTÉNGASE ACTUALIZADO:</b>
            </p>
            <p>
                Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle
                'like' a nuestra página de Facebook para estar actualizado de todas las actividades a realizar: <br>
                <a href='https://www.facebook.com/RELEEM.ORG'>https://www.facebook.com/RELEEM.ORG</a>
            </p>
            <p>
                Esperamos verlos y contar con su presencia física o virtual y asistiendo a las actividades de nuestro
                <b><span style='color:#b246fc'>2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</span></b>.<br>
                <b><span style='color:#b246fc'>#</span>Pasión<span style='color:#b246fc'>Por</span>La<span style='color:#b246fc'>Investigación</span></b>
            </p>
            <h3>2.- Gafetes</h3>
            <?php
            if (empty($info["infoGafetes"])) {
                echo 'Las claves de gafete aún se encuentran en proceso. Cuando esten listas se veran reflejadas en este apartado.';
            } else {
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Clave de gafete</th>
                                    <th scope="col">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($info["infoGafetes"] as $autor) {
                                ?>
                                    <tr>
                                        <td><?php echo $autor["clave_gafete"] ?></td>
                                        <td><?php echo $autor["nombre"] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
            <hr>
            <p>* Si desea facturar, vaya al apartado de <b>Facturas</b> ubicado en el menú lateral de esta página.</p>
        </div>
    </div>
<?php
}

function esquemaEReleem2022($nombre, $info)
{
?>
    <div class="card text-white bg-dark">
        <div class="card-header">
            <h3>Te has registrado al <?= urldecode($nombre) ?></h3>
        </div>
        <div class="card-body text-center">
            <h3>1.- Instrucciones</h3>
            <style>
                ol {
                    counter-reset: item
                }

                li {
                    display: block
                }

                li:before {
                    content: counters(item, '.') ' ';
                    counter-increment: item
                }
            </style>
            <img src='https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEEM (1).jpg' style="height:150px; text-align:center" />
            <p>
                Apreciable investigador (a) <b><?= $_SESSION['nombre_completo'] ?></b>
            </p>
            <p>
                Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del <b><span style='color:#b246fc'>'2do. Congreso
                        Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022'</span></b>.
            </p>
            <p>
                Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio '<b>Vive RedesLA</b>'
                y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: la <b><span style='color:#b246fc'>Universidad Autónoma de Zacatecas
                        'Francisco García Salinas' (Unidad Académica de Ingeniería Eléctrica) en Zacatecas, Zacatecas</span></b>, quienes en
                conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><span style='color:#b246fc'>RELEEM</span></b>, llevarán a cabo la organización
                de este congreso de investigación, los días <b>08 y 09 de septiembre del 2022</b>.
            </p>
            <p>
                Para continuar con su participación deberá hacer el '<b>Envío de artículo-ponencia</b>'
            </p>
            <p>
                <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de
                    <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>iQuatro Editores</a> e iniciar sesión realizando el siguiente proceso:</b>
            </p>
            <p>
            <ol>
                <li>
                    Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro
                    en plataforma de iQuatro Editores: <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>Registrarse | Libros IQuatro(iquatroeditores.com)</a>.
                    Si ya cuenta con un usuario, omita este paso e inicie sesión.
                </li>
                <li>
                    Dé clic en: <b>Enviar artículo</b>.
                </li>
                <ol>
                    <li>
                        Revise que cumpla con todos los <a href='https://iquatroeditores.com/revista/index.php/iquatro/about/submissions'>requisitos</a>, antes de proceder con el envío de su artículo.
                    </li>
                </ol>
                <li>
                    En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la
                    '<a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a>' y plantilla de trabajo misma que contiene los parámetros mencionados en el
                    apartado <b>I. Formato de la <a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a></b>.
                </li>
                <li>
                    Introducir <b>'los metadatos (nombre de artículo y autores)' y 'el resumen'</b>. En la pestaña de 'CONFIRMACIÓN'
                    dar clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. <i>Es importante que su archivo
                        Word no contenga el nombre de los autores para garantizar la revisión anónima</i>.
                </li>
                <li>
                    Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores,
                    es importante verificar la bandeja de correo no deseado, ver <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>manual</a> de envío <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>aquí</a>.
                </li>
                <li>
                    El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o rechazada la
                    presentación de la ponencia en el <b>2do. Congreso Latinoamericano de Investigación en Energía,
                        Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>. Se notificará dicho dictamen vía electrónica.
                </li>
                <li>
                    <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten.</i></b>
                </li>
                <li>
                    Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar
                    si dicha ponencia será publicada como capítulo en el <a href='https://www.releem.org/'>libro electrónico</a> del '<b>2do. Congreso Latinoamericano
                        de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>'.
                </li>
                <li>
                    Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación;
                    una vez realizada la revisión por pares y enviadas sus correcciones.
                </li>
                <li>
                    Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que
                    deberá editar, firmar y subirla a la <a href='https://iquatroeditores.com/revista/index.php/iquatro/login'>plataforma</a> escaneada en formato PDF, según las indicaciones
                    de la editorial iQuatro Editores.
                </li>
            </ol>
            </p>
            <p>
                <b><u>Una vez aceptada su ponencia: </u></b>
            </p>
            <p>
                Se deberá cubrir a más tardar el 05 de septiembre del presente año la <b>tarifa de inscripción</b>: $6,440.00
                (seis mil cuatrocientos cuarenta pesos 00/100 MXN) IVA incluido por ponencia, para los participantes
                fuera de México será de: 333 USD (trescientos treinta y tres dólares 00/100 USD) IVA incluido por ponencia,
                esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar conformados con un número mayor
                de alumnos y al menos con un profesor.
            </p>
            <p>
                Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 18 de julio del 2022,
                con la <b>tarifa de inscripción con descuento</b>: $6,040.00 (seis mil cuarenta pesos 00/100 MXN) IVA incluido
                por ponencia, para los participantes fuera de México será de 308 USD: (trescientos ocho dólares 00/100 USD)
                IVA incluido por ponencia, esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar
                conformados con un número mayor de alumnos y al menos con un profesor.
            </p>
            <p>
                Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca
                móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en
                la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria
                    030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de forma
                directa, OXXO y otras tiendas de conveniencia: <a href='https://link.mercadopago.com.mx/sdmypesredesla'>https://link.mercadopago.com.mx/sdmypesredesla</a>
            </p>
            <p>
                Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una plataforma
                online a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus
                bancos, o bien podrá ejecutarlo desde este link: <a href='https://paypal.me/paqueteb1?locale.x=es_XC'>https://paypal.me/paqueteb1?locale.x=es_XC</a>.
            </p>
            <p>
                Recuerde colocar el en concepto su ID del artículo-Congreso RELEEM.
            </p>
            <p>
                <b>MANTÉNGASE ACTUALIZADO:</b>
            </p>
            <p>
                Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle
                'like' a nuestra página de Facebook para estar actualizado de todas las actividades a realizar: <br>
                <a href='https://www.facebook.com/RELEEM.ORG'>https://www.facebook.com/RELEEM.ORG</a>
            </p>
            <p>
                Esperamos verlos y contar con su presencia física o virtual y asistiendo a las actividades de nuestro
                <b><span style='color:#b246fc'>2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</span></b>.<br>
                <b><span style='color:#b246fc'>#</span>Pasión<span style='color:#b246fc'>Por</span>La<span style='color:#b246fc'>Investigación</span></b>
            </p>
            <h3>2.- Gafetes</h3>
            <?php
            if (empty($info["infoGafetes"])) {
                echo 'Las claves de gafete aún se encuentran en proceso. Cuando esten listas se veran reflejadas en este apartado.';
            } else {
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Clave de gafete</th>
                                    <th scope="col">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($info["infoGafetes"] as $autor) {
                                ?>
                                    <tr>
                                        <td><?php echo $autor["clave_gafete"] ?></td>
                                        <td><?php echo $autor["nombre"] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
            <hr>
            <p>* Si desea facturar, vaya al apartado de <b>Facturas</b> ubicado en el menú lateral de esta página.</p>
        </div>
    </div>
<?php
}

function esquemaFReleem2022($nombre, $info)
{
?>
    <div class="card text-white bg-dark">
        <div class="card-header">
            <h3>Te has registrado al <?= urldecode($nombre) ?></h3>
        </div>
        <div class="card-body text-center">
            <h3>1.- Instrucciones</h3>
            <style>
                ol {
                    counter-reset: item
                }

                li {
                    display: block
                }

                li:before {
                    content: counters(item, '.') ' ';
                    counter-increment: item
                }
            </style>
            <img src='https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEEM (1).jpg' style="height:150px; text-align:center" />
            <p>
                Apreciable investigador (a) <b><?= $_SESSION['nombre_completo'] ?></b>
            </p>
            <p>
                Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del <b><span style='color:#b246fc'>'2do. Congreso
                        Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022'</span></b>.
            </p>
            <p>
                Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio '<b>Vive RedesLA</b>'
                y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: la <b><span style='color:#b246fc'>Universidad Autónoma de Zacatecas
                        'Francisco García Salinas' (Unidad Académica de Ingeniería Eléctrica) en Zacatecas, Zacatecas</span></b>, quienes en
                conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><span style='color:#b246fc'>RELEEM</span></b>, llevarán a cabo la organización
                de este congreso de investigación, los días <b>08 y 09 de septiembre del 2022</b>.
            </p>
            <p>
                Para continuar con su participación deberá hacer el '<b>Envío de artículo-ponencia</b>'
            </p>
            <p>
                <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de
                    <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>iQuatro Editores</a> e iniciar sesión realizando el siguiente proceso:</b>
            </p>
            <p>
            <ol>
                <li>
                    Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro
                    en plataforma de iQuatro Editores: <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>Registrarse | Libros IQuatro(iquatroeditores.com)</a>.
                    Si ya cuenta con un usuario, omita este paso e inicie sesión.
                </li>
                <li>
                    Dé clic en: <b>Enviar artículo</b>.
                </li>
                <ol>
                    <li>
                        Revise que cumpla con todos los <a href='https://iquatroeditores.com/revista/index.php/iquatro/about/submissions'>requisitos</a>, antes de proceder con el envío de su artículo.
                    </li>
                </ol>
                <li>
                    En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la
                    '<a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a>' y plantilla de trabajo misma que contiene los parámetros mencionados en el
                    apartado <b>I. Formato de la <a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a></b>.
                </li>
                <li>
                    Introducir <b>'los metadatos (nombre de artículo y autores)' y 'el resumen'</b>. En la pestaña de 'CONFIRMACIÓN'
                    dar clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. <i>Es importante que su archivo
                        Word no contenga el nombre de los autores para garantizar la revisión anónima</i>.
                </li>
                <li>
                    Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores,
                    es importante verificar la bandeja de correo no deseado, ver <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>manual</a> de envío <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>aquí</a>.
                </li>
                <li>
                    El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o rechazada la
                    presentación de la ponencia en el <b>2do. Congreso Latinoamericano de Investigación en Energía,
                        Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>. Se notificará dicho dictamen vía electrónica.
                </li>
                <li>
                    <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten.</i></b>
                </li>
                <li>
                    Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar
                    si dicha ponencia será publicada como capítulo en el <a href='https://www.releem.org/'>libro electrónico</a> del '<b>2do. Congreso Latinoamericano
                        de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>'.
                </li>
                <li>
                    Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación;
                    una vez realizada la revisión por pares y enviadas sus correcciones.
                </li>
                <li>
                    Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que
                    deberá editar, firmar y subirla a la <a href='https://iquatroeditores.com/revista/index.php/iquatro/login'>plataforma</a> escaneada en formato PDF, según las indicaciones
                    de la editorial iQuatro Editores.
                </li>
            </ol>
            </p>
            <p>
                <b><u>Una vez aceptada su ponencia: </u></b>
            </p>
            <p>
                Se deberá cubrir a más tardar el 05 de septiembre del presente año la <b>tarifa de inscripción</b>: $6,440.00
                (seis mil cuatrocientos cuarenta pesos 00/100 MXN) IVA incluido por ponencia, para los participantes
                fuera de México será de: 333 USD (trescientos treinta y tres dólares 00/100 USD) IVA incluido por ponencia,
                esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar conformados con un número mayor
                de alumnos y al menos con un profesor.
            </p>
            <p>
                Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 18 de julio del 2022,
                con la <b>tarifa de inscripción con descuento</b>: $6,040.00 (seis mil cuarenta pesos 00/100 MXN) IVA incluido
                por ponencia, para los participantes fuera de México será de 308 USD: (trescientos ocho dólares 00/100 USD)
                IVA incluido por ponencia, esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar
                conformados con un número mayor de alumnos y al menos con un profesor.
            </p>
            <p>
                Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca
                móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en
                la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria
                    030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de forma
                directa, OXXO y otras tiendas de conveniencia: <a href='https://link.mercadopago.com.mx/sdmypesredesla'>https://link.mercadopago.com.mx/sdmypesredesla</a>
            </p>
            <p>
                Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una plataforma
                online a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus
                bancos, o bien podrá ejecutarlo desde este link: <a href='https://paypal.me/paqueteb1?locale.x=es_XC'>https://paypal.me/paqueteb1?locale.x=es_XC</a>.
            </p>
            <p>
                Recuerde colocar el en concepto su ID del artículo-Congreso RELEEM.
            </p>
            <p>
                <b>MANTÉNGASE ACTUALIZADO:</b>
            </p>
            <p>
                Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle
                'like' a nuestra página de Facebook para estar actualizado de todas las actividades a realizar: <br>
                <a href='https://www.facebook.com/RELEEM.ORG'>https://www.facebook.com/RELEEM.ORG</a>
            </p>
            <p>
                Esperamos verlos y contar con su presencia física o virtual y asistiendo a las actividades de nuestro
                <b><span style='color:#b246fc'>2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</span></b>.<br>
                <b><span style='color:#b246fc'>#</span>Pasión<span style='color:#b246fc'>Por</span>La<span style='color:#b246fc'>Investigación</span></b>
            </p>
            <h3>2.- Gafetes</h3>
            <?php
            if (empty($info["infoGafetes"])) {
                echo 'Las claves de gafete aún se encuentran en proceso. Cuando esten listas se veran reflejadas en este apartado.';
            } else {
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Clave de gafete</th>
                                    <th scope="col">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($info["infoGafetes"] as $autor) {
                                ?>
                                    <tr>
                                        <td><?php echo $autor["clave_gafete"] ?></td>
                                        <td><?php echo $autor["nombre"] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
            <hr>
            <p>* Si desea facturar, vaya al apartado de <b>Facturas</b> ubicado en el menú lateral de esta página.</p>
        </div>
    </div>
<?php
}

function esquemaGReleem2022($nombre, $info)
{
?>
    <div class="card text-white bg-dark">
        <div class="card-header">
            <h3>Te has registrado al <?= urldecode($nombre) ?></h3>
        </div>
        <div class="card-body text-center">
            <h3>1.- Instrucciones</h3>
            <style>
                ol {
                    counter-reset: item
                }

                li {
                    display: block
                }

                li:before {
                    content: counters(item, '.') ' ';
                    counter-increment: item
                }
            </style>
            <img src='https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEEM (1).jpg' style="height:150px; text-align:center" />
            <p>
                Apreciable investigador (a) <b><?= $_SESSION['nombre_completo'] ?></b>
            </p>
            <p>
                Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del <b><span style='color:#b246fc'>'2do. Congreso
                        Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022'</span></b>.
            </p>
            <p>
                Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio '<b>Vive RedesLA</b>'
                y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: la <b><span style='color:#b246fc'>Universidad Autónoma de Zacatecas
                        'Francisco García Salinas' (Unidad Académica de Ingeniería Eléctrica) en Zacatecas, Zacatecas</span></b>, quienes en
                conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><span style='color:#b246fc'>RELEEM</span></b>, llevarán a cabo la organización
                de este congreso de investigación, los días <b>08 y 09 de septiembre del 2022</b>.
            </p>
            <p>
                Para continuar con su participación deberá hacer el '<b>Envío de artículo-ponencia</b>'
            </p>
            <p>
                <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de
                    <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>iQuatro Editores</a> e iniciar sesión realizando el siguiente proceso:</b>
            </p>
            <p>
            <ol>
                <li>
                    Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro
                    en plataforma de iQuatro Editores: <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>Registrarse | Libros IQuatro(iquatroeditores.com)</a>.
                    Si ya cuenta con un usuario, omita este paso e inicie sesión.
                </li>
                <li>
                    Dé clic en: <b>Enviar artículo</b>.
                </li>
                <ol>
                    <li>
                        Revise que cumpla con todos los <a href='https://iquatroeditores.com/revista/index.php/iquatro/about/submissions'>requisitos</a>, antes de proceder con el envío de su artículo.
                    </li>
                </ol>
                <li>
                    En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la
                    '<a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a>' y plantilla de trabajo misma que contiene los parámetros mencionados en el
                    apartado <b>I. Formato de la <a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a></b>.
                </li>
                <li>
                    Introducir <b>'los metadatos (nombre de artículo y autores)' y 'el resumen'</b>. En la pestaña de 'CONFIRMACIÓN'
                    dar clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. <i>Es importante que su archivo
                        Word no contenga el nombre de los autores para garantizar la revisión anónima</i>.
                </li>
                <li>
                    Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores,
                    es importante verificar la bandeja de correo no deseado, ver <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>manual</a> de envío <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>aquí</a>.
                </li>
                <li>
                    El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o rechazada la
                    presentación de la ponencia en el <b>2do. Congreso Latinoamericano de Investigación en Energía,
                        Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>. Se notificará dicho dictamen vía electrónica.
                </li>
                <li>
                    <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten.</i></b>
                </li>
                <li>
                    Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar
                    si dicha ponencia será publicada como capítulo en el <a href='https://www.releem.org/'>libro electrónico</a> del '<b>2do. Congreso Latinoamericano
                        de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>'.
                </li>
                <li>
                    Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación;
                    una vez realizada la revisión por pares y enviadas sus correcciones.
                </li>
                <li>
                    Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que
                    deberá editar, firmar y subirla a la <a href='https://iquatroeditores.com/revista/index.php/iquatro/login'>plataforma</a> escaneada en formato PDF, según las indicaciones
                    de la editorial iQuatro Editores.
                </li>
            </ol>
            </p>
            <p>
                <b><u>Una vez aceptada su ponencia: </u></b>
            </p>
            <p>
                Se deberá cubrir a más tardar el 05 de septiembre del presente año la <b>tarifa de inscripción</b>: $6,440.00
                (seis mil cuatrocientos cuarenta pesos 00/100 MXN) IVA incluido por ponencia, para los participantes
                fuera de México será de: 333 USD (trescientos treinta y tres dólares 00/100 USD) IVA incluido por ponencia,
                esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar conformados con un número mayor
                de alumnos y al menos con un profesor.
            </p>
            <p>
                Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 18 de julio del 2022,
                con la <b>tarifa de inscripción con descuento</b>: $6,040.00 (seis mil cuarenta pesos 00/100 MXN) IVA incluido
                por ponencia, para los participantes fuera de México será de 308 USD: (trescientos ocho dólares 00/100 USD)
                IVA incluido por ponencia, esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar
                conformados con un número mayor de alumnos y al menos con un profesor.
            </p>
            <p>
                Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca
                móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en
                la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria
                    030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de forma
                directa, OXXO y otras tiendas de conveniencia: <a href='https://link.mercadopago.com.mx/sdmypesredesla'>https://link.mercadopago.com.mx/sdmypesredesla</a>
            </p>
            <p>
                Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una plataforma
                online a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus
                bancos, o bien podrá ejecutarlo desde este link: <a href='https://paypal.me/paqueteb1?locale.x=es_XC'>https://paypal.me/paqueteb1?locale.x=es_XC</a>.
            </p>
            <p>
                Recuerde colocar el en concepto su ID del artículo-Congreso RELEEM.
            </p>
            <p>
                <b>MANTÉNGASE ACTUALIZADO:</b>
            </p>
            <p>
                Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle
                'like' a nuestra página de Facebook para estar actualizado de todas las actividades a realizar: <br>
                <a href='https://www.facebook.com/RELEEM.ORG'>https://www.facebook.com/RELEEM.ORG</a>
            </p>
            <p>
                Esperamos verlos y contar con su presencia física o virtual y asistiendo a las actividades de nuestro
                <b><span style='color:#b246fc'>2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</span></b>.<br>
                <b><span style='color:#b246fc'>#</span>Pasión<span style='color:#b246fc'>Por</span>La<span style='color:#b246fc'>Investigación</span></b>
            </p>
            <h3>2.- Gafetes</h3>
            <?php
            if (empty($info["infoGafetes"])) {
                echo 'Las claves de gafete aún se encuentran en proceso. Cuando esten listas se veran reflejadas en este apartado.';
            } else {
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Clave de gafete</th>
                                    <th scope="col">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($info["infoGafetes"] as $autor) {
                                ?>
                                    <tr>
                                        <td><?php echo $autor["clave_gafete"] ?></td>
                                        <td><?php echo $autor["nombre"] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            ?>
            <hr>
            <p>* Si desea facturar, vaya al apartado de <b>Facturas</b> ubicado en el menú lateral de esta página.</p>
        </div>
    </div>
<?php
}
