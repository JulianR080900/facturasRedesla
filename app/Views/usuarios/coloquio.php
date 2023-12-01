<div class="content">


    <div class="row">

        <div class="col-md-12">

            <h1>Coloquio</h1>

            <hr>

        </div>

        <hr>

    </div>



    <div class="col md-12">

        <div class="card card-header-congresos">

            <div class="card-header">

                <h3>Registro de ponencias</h3>

            </div>

            <div class="card-body card-body-congresos">

                <h1 class="text-center">1.- Instrucciones</h1>

                <?php
                #ESTAS SON INSTRUCCIONES ESPECIFICAS PARA CADA RED, CAMBIARAN CON LOS AñOS, AQUI LAS PODRAS CAMBIAR
                #IGUAL PODRIAS PONERLAS EN LA BD Y MANDARLAS LLAMAR, COMO GUSTES
                if ($_SESSION['red'] == "Relep") {
                } else if ($_SESSION['red'] == "Releem") {
                } else if ($_SESSION['red'] == 'Relayn') {

                    echo '

                        <center><img src="https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELAYN.jpg" style="

						height: 150px;" /></center>
						<br>
                        <p>

                        Apreciable investigador (a) ' . $nombre_completo_usuario . ' <br>

                        Le confirmamos que ya contamos con su solicitud para ser parte del <b>"4to. Coloquio de Investigación para alumnos de Doctorado

                        y Maestría RELAYN 2022"</b>, que se llevará a cabo en el marco del <b>"7mo. Congreso Latinoamericano de Investigación

                        en Administración y Negocios. RELAYN 2022"</b>.

                        </p>

                        <p>

                        El evento será de gran relevancia académica ya que los productos que de éste deriven abonan al perfil PRODEP,

                        al perfil SNI, al PNPC, a la consolidación de cuerpos académicos, a las certificaciones de CACECA, 

                        a programas de fortalecimiento como PIFI, PROFOCIE, PFCE. 

                        </p>

                        <p>

                        Dicho evento se llevará a cabo <a onclick="return false">bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio 

                        <b>"Vive RedesLA"</b> y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona</a>: el <b>Centro

                        Universitario de la Costa de la Universidad de Guadalajara en Puerto Vallarta, Jalisco</b>, quienes en 

                        conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b>RELAYN</b>, llevarán a cabo 

                        la organización de este congreso de investigación, los días <b>17 y 18 de noviembre del 2022</b>.

                        </p>

                        <p>

                        Para continuar con su participación deberá hacer el <b>"Envío de artículo-ponencia"</b>

                        </p>

                        <p>

                        <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de iQuatro Editores e iniciar sesión realizando el siguiente proceso:</b><br>

                        <ol>

                            <li>

                            Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro en plataforma

                            de iQuatro Editores: <a href="http://iquatroeditores.com/revista/index.php/iquatro/user/register" target="_blank">Registrarse | Libros IQuatro(iquatroeditores.com)</a>. Si ya cuenta con un usuario, omita este paso e inicie sesión

                            </li>

                            <li>

                            Dé clic en: <b>Enviar artículo</b>. Revise que cumpla con todos los <b><a href="http://iquatroeditores.com/revista/index.php/iquatro/about/submissions">requisitos</a></b>,

                            antes de proceder con el envío de su artículo.  

                            </li>

                            <li>

                            En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la "<a href="https://drive.google.com/file/d/1NssoXPsK7aujW8eDAtP6dP6KAv31XFSB/view" target="_blank">convocatoria"</a>

                            y el nivel (categoría) con el que participará, mismo que contiene los parámetros mencionados en el apartado <b>I. 

                            Formato de la <a href="https://drive.google.com/file/d/1NssoXPsK7aujW8eDAtP6dP6KAv31XFSB/view" target="_blank">convocatoria</a></b>.

                            </li>

                            <li>

                            Introducir <b>"los metadatos (nombre de artículo y autores)" y "el resumen"</b>.  En la pestaña de "CONFIRMACIÓN" dar

                            clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. Es importante que su archivo Word

                            no contenga el nombre de los autores para garantizar la revisión anónima. 

                            </li>

                            <li>

                            Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores, 

                            es importante verificar la bandeja de correo no deseado, ver <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">manual</a> 

                            de envío <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">aquí</a>.

                            </li>

                            <li>

                            El Cuerpo Arbitral conformado por investigadores expertos en el área realizará la evaluación donde se definirá si es aceptada 

                            o rechazada la presentación de la ponencia en el <b>4to. Coloquio de Investigación para alumnos de Doctorado y 

                            Maestría RELAYN 2022</b> en el marco del <b>7mo. Congreso Latinoamericano de Investigación en Administración y Negocios.

                            RELAYN 2022</b>. Se notificará dicho dictamen vía electrónica.

                            </li>

                            <li>

                            <b><u>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten</u></b>.  

                            Deberá confirmar si enviarán su trabajo en la categoría 4, en caso de haber seleccionado la categoría 1, 2 o 3.

                            </li>

                            <li>

                            Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar

                            si dicha ponencia será publicada como artículo en la <a href="http://iquatroeditores.com/revista/index.php/relayn/index" target="_blank">Revista RELAYN</a> 

                            o como capítulo en el <a href="https://www.relayn.org/biblioteca/" target="_blank">libro electrónico</a> del 

                            <b>"7mo. Congreso Latinoamericano de Investigación en Administración y Negocios. RELAYN 2022"</b>.  

                            </li>

                            <li>

                            Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación; una vez realizada la revisión por pares y enviadas sus correcciones. 

                            </li>

                            <li>

                            Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que deberá editar, 

                            firmar y subirla a la <a href="http://iquatroeditores.com/revista/index.php/iquatro/login" target="_blank">plataforma</a> escaneada en formato PDF, según las indicaciones de la editorial iQuatro Editores.   

                            </li>

                        </ol>

                        </p>

                        <p>

                        <b><u>Una vez aceptada su ponencia:</u></b><br>

                        Se deberá cubrir a más tardar el 19 de noviembre del presente año la <b>tarifa de inscripción</b>: $6,410.00 (seis mil cuatrocientos diez pesos 00/100 MXN) 

                        IVA incluido por ponencia, para los participantes fuera de México será de: 330 USD (trescientos treinta dólares 00/100 USD) IVA incluido por

                        ponencia, esta puede ser de uno a máximo dos autores.

                        </p>

                        <p>

                        Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 07 de octubre del 2022, con la <b>tarifa de inscripción 

                        con descuento</b>: $6,010.00 (seis mil diez pesos 00/100 MXN) IVA incluido por ponencia, para los participantes fuera de México será de 

                        305 USD: (trescientos cinco dólares 00/100 USD) IVA incluido por ponencia, esta puede ser de uno a máximo dos autores.

                        </p>

                        <p>

                        Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca móvil o depósito bancario 

                        a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en la cuenta clásica 0223143300201 del banco BANBAJIO BANCO

                        DEL BAJIO S.A con <b>CLABE interbancaria 030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de 

                        forma directa, OXXO o tiendas de conveniencia: <a herf="https://link.mercadopago.com.mx/sdmypesredesla" target="_blank">https://link.mercadopago.com.mx/sdmypesredesla</a>  

                        </p>

                        <p>

                        Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una 

                        <a href="https://www.paypal.com/mx/webapps/mpp/country-worldwide" target="_blank">plataforma online</a> a sus correos 

                        electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus bancos, o bien podrá ejecutarlo desde este link:

                        <a href="https://paypal.me/paqueteb1?locale.x=es_XC" target="_blank">https://paypal.me/paqueteb1?locale.x=es_XC</a>.  

                        </p>

                        <p>

                        Recuerde colocar el en concepto su ID del artículo-Coloquio RELAYN.

                        </p>

                        <p>

                        <b>MANTÉNGASE ACTUALIZADO:</b><br>

                        Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle "like" 

                        a nuestra página de Facebook para estar actualizado de todas las actividades a realizar:

                        <a href="https://www.facebook.com/Relayn.org" target="_blank">https://www.facebook.com/Relayn.org</a>

                        </p>

                        <p>

                        Esperamos verlos y contar con su presencia física o virtual, realizando la ponencia correspondiente y asistiendo a las 

                        actividades de nuestro <b>7mo. Congreso Latinoamericano de Investigación en Administración y Negocios. RELAYN 2022</b>.<br>

                        <b>#PasiónPorLaInvestigación</b>

                        </p>

                   ';
                }

                ?>

                <?php

                if (!isset($ponencias)) {

                    if ($cantidad_ponencias_pendientes > 0 && $cantidad_de_ponencias <= 0) {
                ?>
                        <h3>Tiene <b class='n_<?= $_SESSION['red'] ?>'><?= $cantidad_ponencias_pendientes ?></b> ponencias pendientes por registrar, debe completar el pago correspondiente para continuar</h3>
                    <?php
                    } else {
                    ?>

                        <h1 class="text-center">2.- Registro de ponencia</h1>

                        <div class="col-md-12">

                            <label class="text-left">Ingrese la contraseña de su ponencia, esta se encuentra en el correo de su <b>CARTA DE ACEPTACIÓN</b></label>

                            <form action="<?= base_url("infoCongreso") ?>" method="POST" class="needs-validation" novalidate>



                                <div class="mb-3">

                                    <input type="text" class="form-control" name="iquatro" id="iquatro" placeholder="Contraseña de ponencia" required><br>

                                    <input name="nombre_congreso" value="<?= $nombre_congreso ?>" hidden>

                                    <div class="invalid-feedback">

                                        Ingrese la contraseña de su ponencia.

                                    </div>

                                </div>


                                <button type="submit" disabled class="btn btn-block bg-<?= $_SESSION['red'] ?>">Buscar</button>

                            </form>

                        </div>

                        <hr>

                    <?php
                    }
                } else {

                    ?>

                    <?php

                    $cantidad_en_vista = 0;

                    foreach ($ponencias as $ponencia) {

                        $cantidad_en_vista++;

                    ?>

                        <h1>3.- Ponencias registradas</h1>

                        <div class="row">

                            <div class="col-md-12">

                                <h3 class="n_<?php echo $_SESSION["red"] ?>"><?php echo $ponencia["nombre"] ?></h3>

                            </div>

                        </div>

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

                                        foreach ($ponencia["autores"] as $autor) {

                                        ?>

                                            <tr>

                                                <td><?php echo $autor["gafete"] ?></td>

                                                <td><?php echo $autor["nombre"] ?></td>

                                            </tr>

                                        <?php

                                        }

                                        ?>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                        <hr style="height:6px">

                        <?php

                    }

                    //AQUI, NO SE MOSTRARA EL OTRO FORMULARIO SI TIENE 2 O MAS INSCRIPCIONES A CONGRESO

                    //SI EL PAGO NO ESTA COMPLETADO

                    if ($cantidad_de_ponencias > 1) {

                        if ($cantidad_en_vista == $cantidad_de_ponencias) {
                        } else {

                        ?>

                            <h1>Ingrese su clave de ponencia</h1>

                            <div class="col-md-12">

                                <form action="<?= base_url("infoCongreso") ?>" method="POST" class="needs-validation" novalidate>



                                    <div class="mb-3">

                                        <input type="text" class="form-control" name="iquatro" id="iquatro" placeholder="Contraseña de ponencia" required><br>

                                        <input name="nombre_congreso" value="<?= $nombre_congreso ?>" hidden>

                                        <div class="invalid-feedback">

                                            Ingrese la contraseña de su ponencia.

                                        </div>

                                    </div>


                                    <button type="submit" class="btn btn-block bg-<?= $_SESSION['red'] ?>">Buscar</button>

                                </form>

                            </div>

                        <?php

                        }
                    }
                    if ($cantidad_ponencias_pendientes > 0) {

                        ?>

                        <h3>Tiene <b class='n_<?= $_SESSION['red'] ?>'><?= $cantidad_ponencias_pendientes ?></b> ponencias pendientes por registrar, debe completar el pago correspondiente para continuar</h3>

                <?php

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
</script>