<div class="content">

    <div class="row">

        <div class="col-md-12">

            <h2>Notas de la plataforma</h2>

            <div class="alert alert-warning" role="alert">

                Para visualizar el proyecto y sus accesos seleccione su esquema de participación en la sección de pagos, posteriormente cierre sesión e inicie nuevamente

            </div>

            <?php

            if ($_SESSION["lider"] == 1) {

            ?>

                <div class="alert alert-warning" role="alert">

                    Recuerde actualizar la institucion a estudiar en el apartado de <b>Grupo > Datos generales</b>

                </div>

            <?php

            }
            

            ?>

            <?php
            /* if($_SESSION['red'] == 'Releg'){
                ?>
                <div class="alert alert-danger" role="alert">
                Las y los participantes del <b>esquema B</b>, deberán desarrollar el apartado de <b>DISCUSIÓN</b> para libro impreso del <b>03 al 10 de octubre 2023</b>. A partir del apartado de Revisión de la literatura que se les hizo llegar por parte del Comité Académico RELEG. 
                Favor de revisar las indicaciones en la sección de <b>Proyectos -> Esquema B: Investigación Releg 2022</b> en el menú lateral.

                <b>Sólo se recibirán dentro de la plataforma RELEG</b>, no se recibirán por correo electrónico, WhatsApp o algún otro medio. La plataforma RELEG cerrará a las <b>18:00 HRS</b>.
                </div>
                <?php
            }if($_SESSION['red'] == 'Relayn'){
                ?>
                <!-- <div class="alert alert-warning" role="alert">
                Los materiales del cuestionario estarán activos una vez que sean autorizados por INEGI
                </div> -->
                <!-- <div class="alert alert-warning" role="alert">
                IMPORTANTE: Antes de iniciar con el levantamiento de sus encuestas es OBLIGATORIO realizar 1 captura de prueba y registrar su estado 
                de validación para comprobar que sus datos de la zona de estudio son correctos, se registran en plataforma y el sistema de 
                validación funciona correctamente. Si presentan o detecta algún error por favor enviar capturas de pantalla a los correos: 
                atencion@redesl.la y jaramosp@red.redesla.la
                </div> -->
                
                <?php
            } */
            ?>

            <div class="alert alert-success" role="alert">
                <p><b>Nuevos cambios en la plataforma</b></p>
                <ul>
                    <li>Nueva interfaz, mismo contenido</li>
                    <li>Cambio de tema en timpo real, disponible <b>Tema claro</b> y <b>Tema oscuro</b>. Se puede cambiar desde el menú superior en el ícono del sol o la luna</li>
                    <li>Las notas sobre su cuerpo académico se visualizaran desde el apartado de notificaciones ubicado en el menú superior, dando clíc en el ícono de una campana.</li>
                    <li>Problemas al momento de cambiar la foto de perfil solucionado.</li>
                    <li>Eliminar proyecto en caso de error de registro o si no tiene ningun movimiento aprobado por el equipo RedesLA.</li>
                </ul>
            </div>


<!-- 
            <div id="mensajesCA">

                <?php

/*                 if (!empty($mensajes)) {

                    $fecha_hoy = date("Y-m-d");

                    echo '<h3>Notas para el cuerpo academico ' . $_SESSION["CA"] . '</h3>';

                    for ($i = 0; $i < count($mensajes); $i++) {

                        echo '<div class="alert alert-' . $mensajes[$i]['nivelAlerta'] . '" role="alert">' . $mensajes[$i]['mensaje'] . '<button onclick="notas(' . $mensajes[$i]["id"] . ');" style="    background-color: transparent;outline: none;border: transparent;position: absolute;left: 95%;top: 10%;font-size: 26px;"><i class="fa fa-close alert-' . $mensajes[$i]['nivelAlerta'] . '"></i></button></div>';
                    }
                } */

                ?>

            </div> -->





            <script>
                function notas(id) {

                    $.ajax({

                        type: "POST",

                        url: base_url + '/eliminarMensajesCA',

                        data: {

                            'id': id

                        },
                        success: function(data) {

                            if (data == "") {

                                $("#mensajesCA").show();

                                $("#mensajesCA").html('<h3>Notas para el cuerpo academico <?php echo $_SESSION["CA"] ?></h3><hr><h5>No tienes mensajes</h5>');

                            } else {

                                $("#mensajesCA").show();

                                $("#mensajesCA").html('<h3>Notas para el cuerpo academico <?php echo $_SESSION["CA"] ?></h3>' + data);

                            }

                        }

                    });

                }
            </script>
        </div>

    </div>
</div>