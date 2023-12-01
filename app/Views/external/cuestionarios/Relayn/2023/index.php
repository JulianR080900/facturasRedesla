<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resources/css/cuestionarios/Relayn/2023/index.css") ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">
    <link rel="stylesheet" href="<?= base_url('resources/intl-tel-input/build/css/intlTelInput.css') ?>">
    <title>Encuesta RELAYN 2023</title>
</head>

<body>

    <style>
        /*Background color*/
        body {
            background: url(<?= base_url('resources/img/backgrounds/registros/' . $red['nombre_red'] . '.png') ?>);
        }

        .next {
            background-color: <?= $red['color_secundario'] ?>;
            color: #fff;
        }

        section {
            max-width: none !important;
        }

        /*Color number of the step and the connector before it*/
        #progressbar li.active:before,
        #progressbar li.active:after {
            color: <?= $red['color_primario'] ?>;
        }
    </style>

    <div class="container">
        <section>
            <div class="row text-center">
                <div class="col-md-6 text-center">
                    <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" style="width:90%">
                </div>
                <div class="col-md-6 text-center">
                    <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_" . $red['nombre_red'] . ".png"); ?>" style="width: 90%; height: 100%;">
                </div>
            </div>
            <h1 class="text-center">Investigación <?= strtoupper($red['nombre_red']) . ' ' . date('Y') ?></h1>
            <h3 class="text-center">
                “Habilidades directivas y clima
                organizacional en las micro y pequeñas empresas latinoamericanas”
            </h3>
            <hr>
            <h1 class="text-center">Encuesta para el grupo</h1>
            <h1 class="text-center"><?= $claveCuerpo ?></h1>
        </section>

        <section>
            <div class="row justify-content-center justify-content-md-start">
                <div class="col align-self-center">
                    <form id="msform" method="post" action="../agregar" class="needs-validation" novalidate data-toggle="validator">
                        <!-- progressbar -->

                        <ul id="progressbar" class="text-center">
                            <li class="active" id="general"></li>
                            <li id="fase1"></li>
                            <li id="fase2"></li>
                            <li id="fase3"></li>
                            <li id="fase4"></li>
                            <li id="fase5"></li>
                            <li id="fase6"></li>
                        </ul>

                        <fieldset id="field0">

                            <h1 class="text-center">Objetivo</h1>
                            <p class="text-center">
                                Determinar el grado de asociación entre habilidades directivas y clima organizacional de las micro y pequeñas empresas de Latinoamérica.
                            </p>
                            <h1 class="text-center">Instrucciones</h1>
                            <p class="text-center">La encuesta debe ser respondida por <b><u>el personal directivo</u></b> de la empresa, que es la persona que toma la mayor parte de las decisiones.
                                En la encuesta, la empresa es cualquier organización o negocio con fines de lucro donde exista por lo menos una persona que
                                trabaje para el personal directivo. Si alguna pregunta no se puede contestar seleccione la opción <b>“No sé / No aplica”</b>.
                                Es importante leer con especial atención las palabras que están en <b>negritas</b>.
                            </p>
                            <h1 class="text-center">Aviso de privacidad</h1>
                            <h6 class="text-center">
                                SUS RESPUESTAS SON ABSOLUTAMENTE CONFIDENCIALES, AL CONTESTAR EL CUESTIONARIO AUTORIZA QUE SUS RESPUESTAS SEAN USADAS DE <b>MANERA ANÓNIMA</b>,
                                ÚNICA Y EXCLUSIVAMENTE CON FINES ACADÉMICOS Y ESTADÍSTICOS, ¿ESTÁ DE ACUERDO?
                            </h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="checkAviso">
                                <label class="form-check-label" for="checkAviso">
                                    Sí, estoy de acuerdo.
                                </label>
                            </div>

                            <div id="medios">
                                <hr>
                                <h3>Por favor seleccione el medio por el cuál se realizó la encuesta.</h3>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medio_captura" id="opcion1" value="personal" required>
                                    <label class="form-check-label" for="opcion1">
                                        Mediante encuesta directa a la persona empresaria.
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medio_captura" id="opcion2" value="videollamada" required>
                                    <label class="form-check-label" for="opcion2">
                                        Mediante encuesta por videollamada.
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medio_captura" id="opcion3" value="telefono" required>
                                    <label class="form-check-label" for="opcion3">
                                        Mediante encuesta por vía telefónica.
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medio_captura" id="opcion4" value="enlace" required>
                                    <label class="form-check-label" for="opcion4">
                                        Soy el Director (a) de la MYPE, me compartieron el enlace para responder.
                                    </label>
                                </div>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <hr>
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />
                        </fieldset>

                        <fieldset id="field1">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">Datos del encuestador (a)</h2>
                            <br>
                            <p>
                                Por favor, preste cuidado en la captura de su nombre y correo electrónico, con estos datos se emitirá su constancia de encuestador (a).
                                La persona encuestadora DEBE REGISTRAR SU CORREO ELECTRÓNICO PERSONAL, no está permitido utilizar el correo electrónico de otra persona
                                encuestadora. Si captura erróneamente su nombre o correo electrónico ES IMPOSIBLE realizar cambios o modificaciones para la emisión de la constancia.
                            </p>
                            <hr>
                            <div>
                                <label for="">Nombre completo del encuestador (a).</label>
                                <input type="text" name="nombre_encuestador" id="nombre_encuestador" class="form-control" required autofocus minlength="6">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>
                            <div>
                                <label for="">Correo electrónico del encuestador (a).</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: correo_personal@outlook.com</p>
                                <input type="email" name="correo_encuestador" id="correo_encuestador" class="form-control" required>
                                <div class="invalid-feedback">
                                    Ingrese un correo electrónico válido.
                                </div>
                            </div>
                            <br>
                            <h2 class="text-center">1ª PARTE: DATOS DE LA EMPRESA Y/O DIRECTOR (A)</h2>
                            <hr>
                            <h3>1) Datos de la empresa y/o director (a)</h3>
                            <div>
                                <label for="">1a) Nombre comercial de la empresa.</label>
                                <input type="text" class="form-control" name="1a" id="1a" required>

                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1b) Tipo de asociación que describe mejor a la empresa.</label>
                                <select name="1b" id="1b" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($tipo_asociaciones as $t) {
                                    ?>
                                        <option value="<?= $t['nombre'] ?>"><?= $t['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1c) Nombre del director (a) o razón social de la empresa.</label>
                                <input type="text" class="form-control" name="1c" id="1c" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1d) ¿La empresa cuenta con RFC?</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="radioRFC" id="inlineRadio1" value="1" required>
                                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="radioRFC" id="inlineRadio2" value="nc" required>
                                    <label class="form-check-label" for="inlineRadio2">No aplica RFC/NIT</label>
                                </div>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>
                            <br>
                            <div id="rfcnit">
                                <?php
                                if ($ca['pais'] == 2) {
                                ?>
                                    <div>
                                        <label for="">Escribe el RFC de la empresa.</label>
                                        <input type="text" class="form-control" name="rfc" id="inputRFC" minlength="12" maxlength="13" pattern="^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$">
                                        <p id="valid_rfc"></p>
                                        <div class="invalid-feedback">
                                            El RFC son al menos 10 carácteres.
                                        </div>
                                    </div>
                                    <div>
                                        <label for="">¿El RFC es personal o de la empresa?</label>
                                        <select name="tipo_rfc" id="tipo_rfc" class="form-control">
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <option value="personal">Personal</option>
                                            <option value="empresa">De la empresa</option>
                                        </select>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div>
                                        <label for="">Escriba su NIT.</label>
                                        <input type="text" class="form-control" name="nit" id="inputNIT" minlength="12" maxlength="13" pattern="^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$">
                                        <p id="valid_nit"></p>
                                        <div class="invalid-feedback">
                                            El NIT son al menos 13 catácteres.
                                        </div>
                                    </div>
                                    <div>
                                        <label for="">¿El NIT es personal o de la empresa?</label>
                                        <select name="tipo_nit" id="tipo_nit" class="form-control">
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <option value="personal">Personal</option>
                                            <option value="empresa">De la empresa</option>
                                        </select>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                            <div>
                                <label for="">1e) Teléfonos</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Numero de teléfono fijo de la empresa</label>
                                        <input type="text" name="tel_fijo" required id="tel_fijo" class="form-control" minlength="10" maxlength="10" placeholder="10 dígitos sin espacios.">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_tel_fijo" id="tel_fijo" value="tel_fijo" onchange="check_na(event);">
                                            <label class="form-check-label" for="check_tel_fijo">
                                                No aplica numero de teléfono fijo de la empresa.
                                            </label>
                                        </div>
                                        <p id="valid_tel_fijo" class="invalid_inputs"></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Extensión</label>
                                        <input type="text" name="tel_extension" id="tel_extension" class="form-control" minlength="1" maxlength="4" required placeholder="De 1 a 4 dígitos sin espacios.">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_tel_extension" id="tel_extension" value="tel_extension" onchange="check_na(event);">
                                            <label class="form-check-label" for="check_tel_extension">
                                                No aplica extensión.
                                            </label>
                                        </div>
                                        <p id="valid_tel_extension" class="invalid_inputs"></p>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Numero de teléfono celular de la empresa</label>
                                        <input type="text" name="tel_cel" required id="tel_cel" class="form-control" minlength="10" maxlength="10" placeholder="10 dígitos sin espacios.">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_tel_cel" id="tel_cel" value="tel_cel" onchange="check_na(event);">
                                            <label class="form-check-label" for="check_tel_cel">
                                                No aplica numero de teléfono celular de la empresa.
                                            </label>
                                        </div>
                                        <p id="valid_tel_cel" class="invalid_inputs"></p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="">1f) Tipo de vialidad donde se ubica la empresa.</label>
                                <select name="1e" id="1e" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($vialidades as $v) {
                                    ?>
                                        <option value="<?= $v['nombre'] ?>"><?= $v['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1g) Nombre de la vialidad donde se ubica la empresa.</label>
                                <input type="text" class="form-control" name="1f" id="1f" required>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_1f" id="1f" value="1f" onchange="check_na(event);">
                                    <label class="form-check-label" for="check_1f">
                                        No aplica nombre de la vialidad.
                                    </label>
                                </div>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1h) Núm. exterior (número y/o letra).</label>
                                <input type="text" class="form-control" name="1h" id="1h" required>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_1h" value="1h" onchange="check_na(event);">
                                    <label class="form-check-label" for="check_1h">
                                        No aplica Núm. Exterior.
                                    </label>
                                </div>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1i) Núm. interior (número y/o letra).</label>
                                <input type="text" class="form-control" name="1g" id="1g" required>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_1g" value="1g" onchange="check_na(event);">
                                    <label class="form-check-label" for="check_1g">
                                        No aplica Núm. Interior.
                                    </label>
                                </div>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1j) Tipo de asentamiento donde se ubica la empresa.</label>
                                <select name="1i" id="1i" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($asentamientos as $a) {
                                    ?>
                                        <option value="<?= $a['nombre'] ?>"><?= $a['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1k) Código postal.</label>
                                <input type="text" class="form-control" name="1j" id="1j" required minlength="5" maxlength="6">
                                <p id="valid_cp"></p>
                                <div class="invalid-feedback">
                                    El código postal debe contener entre 5 y 6 caracteres.
                                </div>
                            </div>

                            <div id="selectLugar">
                                <label for="">Seleccione su ubicación</label>
                                <select name="info_cp" id="info_cp" required class="form-control">
                                </select>
                            </div>

                            <div id="otra_ubi">
                                <label for="">Especifique</label>
                                <input type="text" class="form-control" name="otra_info_cp" id="otra_info_cp">
                            </div>

                            <div>
                                <label for="">1l) Tipo de conglomerado en el que se encuentra la empresa.</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">Tipo de conglomerado</label>
                                        <select name="tipo_conglomerado" id="tipo_conglomerado" class="form-control" required>
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <?php
                                            foreach ($conglomerados as $c) {
                                            ?>
                                                <option value="<?= $c['nombre'] ?>"><?= $c['nombre'] ?></option>
                                            <?php
                                            }
                                            ?>
                                            <option value="na">No aplica.</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="">Nombre del conglomerado</label>
                                        <input type="text" name="nombre_conglomerado" id="nombre_conglomerado" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="">1m) Tipo y nombre de las vialidades entre las que se ubica la empresa (para registrar las vialidades debe posicionarse dando la espalda a la
                                    puerta de acceso principal de la empresa. La Vialidad 1 será ubicada en el costado derecho; la Vialidad 2 será ubicada en el costado izquierdo;
                                    la vialidad posterior será la ubicada a su espalda).</label>
                                <p>
                                    <a style="cursor: pointer;" id="ejemplo_vialidad_1" class="text-info">Ver ejemplo 1</i></a> o
                                    <a style="cursor: pointer;" id="ejemplo_vialidad_2" class="text-info">Ver ejemplo 2</i></a>
                                </p>
                                <div class="row">
                                    <div class="col md-4">
                                        <label for="">Tipo de vialidad 1</label>
                                        <select name="tipo_vialidad_1" id="tipo_vialidad_1" class="form-control" required>
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <?php
                                            foreach ($vialidades as $v) {
                                            ?>
                                                <option value="<?= $v['nombre'] ?>"><?= $v['nombre'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="">Nombre de la vialidad 1</label>
                                        <input type="text" name="nombre_vialidad_1" id="nombre_vialidad_1" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col md-4">
                                        <label for="">Tipo de vialidad 2</label>
                                        <select name="tipo_vialidad_2" id="tipo_vialidad_2" class="form-control" required>
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <?php
                                            foreach ($vialidades as $v) {
                                            ?>
                                                <option value="<?= $v['nombre'] ?>"><?= $v['nombre'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="">Nombre de la vialidad 2</label>
                                        <input type="text" name="nombre_vialidad_2" id="nombre_vialidad_2" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col md-4">
                                        <label for="">Tipo de vialidad posterior</label>
                                        <select name="tipo_vialidad_posterior" id="tipo_vialidad_posterior" class="form-control" required>
                                            <option value="" selected disabled>Seleccione una opción</option>
                                            <?php
                                            foreach ($vialidades as $v) {
                                            ?>
                                                <option value="<?= $v['nombre'] ?>"><?= $v['nombre'] ?></option>
                                            <?php
                                            }
                                            ?>
                                            <option value="na">No aplica.</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="">Nombre de la vialidad posterior</label>
                                        <input type="text" name="nombre_vialidad_posterior" id="nombre_vialidad_posterior" class="form-control" required>
                                    </div>
                                </div>


                            </div>


                            <div>
                                <label for="">1n) Nombre, letra o número del edificio donde se encuentra la empresa</label>
                                <input type="text" name="nombre_ubicacion_empresa" id="nombre_ubicacion_empresa" class="form-control" required>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_nombre_ubicacion_empresa" id="nombre_ubicacion_empresa" value="nombre_ubicacion_empresa" onchange="check_na(event);">
                                    <label class="form-check-label" for="check_nombre_ubicacion_empresa">
                                        No aplica nombre, letra o número del edificio donde se encuentra la empresa.
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label for="">1o) Piso o nivel donde se encuentra la empresa es: </label>
                                <select name="piso_empresa" id="piso_empresa" required class="form-control">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($pisos as $p) {
                                    ?>
                                        <option value="<?= $p['nombre'] ?>"><?= $p['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>

                            <div id="otro_piso">
                                <label for="">Especifique</label>
                                <input type="text" name="otro_piso" id="otro_piso_input" class="form-control" value="">
                            </div>

                            <div>
                                <label for="">1p) Descripción de ubicación </label><a style="cursor: pointer;" id="ejemplo_descripcion_ubicacion" class="text-info">Ver ejemplo<i class="fas fa-question-circle text-warning"></i></a>
                                <p class="text-primary" style="font-size: 11px;">Describir brevemente las características físicas (geoespaciales) de la ubicación del establecimiento, hacer referencia de elementos cercanos como negocios, escuelas, oficinas, que permitan identificarlo fácilmente. </p>
                                <textarea name="descripcion_mype" id="descripcion_mype" class="form-control" cols="30" rows="5" required minlength="15"></textarea>
                            </div>

                            <div>
                                <label for="">1q) País (Información obtenida de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>) </label>
                                <input type="text" name="1l" id="1l" class='form-control' readonly value="<?= $pais['nombre'] ?>">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1r) Estado (Información obtenida de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>)</label>
                                <input type="text" name="estado_pais" id="estado_pais" class="form-control" value="<?= $estado ?>" readonly>
                            </div>

                            <div>
                                <label for="">1s) Clave de su estado</label>
                                <p class="text-primary" style="font-size: 11px;">Campo autocompletado automáticamente.</p>
                                <input type="number" name="clave_estado" id="clave_estado" class="form-control" readonly value="<?= $clave_estado ?>">
                            </div>

                            <div>
                                <label for="">1t) Municipio (Información obtenida de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>) </label>
                                <p class='text-danger'><u>Para el correcto funcionamiento de este cuestionario borre la memoria caché de su navegador.</u> <a target="_bank" href="https://www.youtube.com/watch?v=guCUVC9E2CM&ab_channel=BorjaGir%C3%B3n">Ver ejemplo.</a></p>
                                <select name="1k" id="1k" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($municipio as $m) {
                                    ?>
                                        <option value="<?= $m ?>"><?= $m ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1u) Clave de su municipio</label>
                                <p class="text-primary" style="font-size: 11px;">Este campo se autocompletará al seleccionar su municipio.</p>
                                <input type="number" name="clave_municipio" id="clave_municipio" class="form-control" readonly>
                            </div>

                            <div>
                                <label for="">1v) Seleccione su localidad</label>
                                <select name="nombre_localidad" id="localidad" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción una vez seleccionado el municipio.</option>
                                </select>
                            </div>
                            <div>
                                <label for="">1w) Clave de la localidad</label>
                                <input type="text" name="clave_localidad" id="clave_loc" class="form-control" readonly>
                            </div>



                            <div>
                                <label for="">1x) Enlace de <a href="https://www.google.com/maps" target="_blank">Google Maps</a> con la ubicación física de la empresa.</label>
                                <a id="dudas" class="text-info">Ver ejemplo<i class="fas fa-question-circle text-warning"></i></a>
                                <input type="text" name="coordenadas" id='coordenadas' pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$" placeholder="Ejemplo: https://www.google.com/maps/place/Tacos+El+Lim%C3%B3n/@25.6856556,-100.2790426,19z/data=!4m5!3m4!1s0x866295f844945fa5:0x22653f6d78ef4e91!8m2!3d25.6855628!4d-100.2789006" id="" class='form-control' required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1y) Tipo de comercio.</label>
                                <select name="tipo_comercio" id="tipo_comercio" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="comerciante_fijo">Comerciante fijo: toda persona que realice cualquier actividad comercial en la vía pública, en un local, puesto o estructura anclado o adherido al suelo o construcción permanente</option>
                                    <option value="puesto_semifijo">Puesto Semifijo: es el lugar o local donde el comerciante de vía pública ejerce su comercio</option>
                                </select>
                            </div>

                            <div>
                                <label for="">1z) Facebook de la empresa.</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: https://www.facebook.com/Relayn.org</p>
                                <input type="text" class="form-control" name="1m" id="1m" required pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_1m" id="1m" value="1m" onchange="check_na(event);">
                                    <label class="form-check-label" for="check_1m">
                                        No aplica página de Facebook.
                                    </label>
                                </div>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">1aa) Correo electrónico de la empresa.</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: relayn@redesla.la</p>
                                <input type="text" class="form-control" name="1n" id="1n" required pattern="[^@\s]+@[^@\s]+">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_1n" id="1n" value="1n" onchange="check_na(event);">
                                    <label class="form-check-label" for="check_1n">
                                        No aplica correo electrónico.
                                    </label>
                                </div>
                                <div class="invalid-feedback">
                                    Ingrese un correo electrónico válido
                                </div>
                            </div>

                            <div>
                                <label for="">1ab) Página de internet de la empresa.</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: https://redesla.la/redesla/</p>
                                <input type="text" class="form-control" name="1o" id="1o" required pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_1o" id="1o" value="1o" onchange="check_na(event);">
                                    <label class="form-check-label" for="check_1o">
                                        No aplica página de internet.
                                    </label>
                                </div>
                                <div class="invalid-feedback">
                                    Ingrese una página de internet válida.
                                </div>
                            </div>

                            <div>
                                <label for="">1ac) Twitter de la empresa.</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: @UserName1</p>
                                <input type="text" class="form-control" name="1p" id="input_1p" required pattern="(?<=^|(?<=[^a-zA-Z0-9-_\.]))@([A-Za-z]+[A-Za-z0-9-_]+)">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_1p" id="1p" value="1p" onchange="check_na(event);">
                                    <label class="form-check-label" for="check_1p">
                                        No aplica.
                                    </label>
                                </div>
                                <div class="invalid-feedback">
                                    El usuario de Twitter debe contener un @ inicial.
                                </div>
                            </div>

                            <div>
                                <label for="">1ad) Giro del negocio.</label>
                                <select name="1q" id="1q" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($giros as $g) {
                                    ?>
                                        <option value="<?= $g['nombre'] ?>"><?= $g['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>

                            </div>
                            <br>
                            <label for="">
                                1ae) Se realizó la equivalencia entre el catálogo de clasificación de los sectores empleada por
                                la RELAYN y el clasificador oficial que utiliza el INEGI (Sistema de Clasificación Industrial de América del Norte SCIAN 2018).
                            </label>

                            <input type="text" hidden name="1r" id="1r" required>

                            <div>
                                <p class="text-danger">Primero seleccione el <u>giro del negocio</u> para seleccionar su sector.</p>
                                <label for="">Sector</label>
                                <select id="rama1" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                                <!--
                                <select id="rama1" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($rama1 as $r) {
                                    ?>
                                        <option value="<?php #$r['nombre'] 
                                                        ?>"><?php #$r['nombre'] 
                                                            ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                -->
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">Subsector</label>
                                <select id="rama2" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">Rama</label>
                                <select id="rama3" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">Sub-rama</label>
                                <select id="rama4" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">Clase</label>
                                <select id="rama5" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <hr>

                            <h3>2) Características de la empresa</h3>

                            <div>
                                <label for="">2a) Año de inicio de operaciones.</label>
                                <input type="number" class="form-control" name="2a" id="2a" min="1800" max="2023" required pattern="^[0-9]{4,}$">
                                <p id="valid_inicio_operaciones"></p>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">2b) ¿Quién fundó la empresa?</label>
                                <select name="2b" id="2b" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($fundacion as $f) {
                                    ?>
                                        <option value="<?= $f['nombre'] ?>"><?= $f['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">2c) ¿Cuál es su estrategia principal para la empresa hoy en día?</label>
                                <select name="2c" id="2c" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($estrategias as $e) {
                                    ?>
                                        <option value="<?= $e['nombre'] ?>"><?= $e['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">2d) ¿Cuál es la problemática a la que le dedica más tiempo hoy en día?</label>
                                <select name="2d" id="2d" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($problematicas as $p) {
                                    ?>
                                        <option value="<?= $p['nombre'] ?>"><?= $p['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">2e) Las ventas de la empresa se concentran principalmente en:</label>
                                <select name="2e" id="2e" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($concentracion_empresas as $c) {
                                    ?>
                                        <option value="<?= $c['nombre'] ?>"><?= $c['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <blockquote style="font-size: 11px;">
                                    "<label for="" style="font-size: 11px !important;" class="text-danger">La familia</label> se define como un grupo de
                                    personas, incluidas aquellas ascendentes y/o descendientes de una pareja,
                                    sin importar el grado de parentesco. <br>
                                    <label style="font-size: 11px !important;" class="text-danger">Propiedad</label> significa dueño de las acciones o capital de la empresa. "
                                </blockquote>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>


                            <div>
                                <label for="">2f) Considera que la propiedad de la empresa es:</label>
                                <select name="2f" id="2f" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($propiedad_empresa as $p) {
                                    ?>
                                        <option value="<?= $p['nombre'] ?>"><?= $p['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">2g) La toma de decisiones de la empresa se concentra en los votos de los miembros de la familia.</label>
                                <select name="2g" id="2g" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">2h) La continuidad de la empresa está considerada unicamente en la familia.</label>
                                <select name="2h" id="2h" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div hidden>
                                <label for="">2i) La pregunta se sustituye por las preguntas 2b y 2f.</label>
                                <input type="text" name="2i" id="2i" hidden value='Columna a eliminar'>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">2i) Indique los tres principales productos y/o servicios que fabricó y ofreció el negocio durante el año 2022 (colocar al menos 1).</label>
                                <select name="productos[] form-control" id="selectProductos" style="width: 100%;" required multiple="multiple">
                                </select>
                                <div class="form-check" id="solo1producto">
                                    <input type="checkbox" id="check_producto">
                                    <label class="form-check-label" for="check_producto">
                                        Solo vendo este producto
                                    </label>
                                    <select name="productos[]" id="selectSolo1Producto" hidden multiple='multiple'></select>
                                </div>
                                <div class="invalid-feedback">
                                    Debe seleccionar 3 productos para continuar.
                                </div>
                            </div>

                            <b>Tamaño de la empresa.</b>
                            <hr>
                            <label for="">De acuerdo con la siguiente tabla, seleccione el tamaño de la empresa.</label>
                            <table class="table text-center table-bordered table-responsive-lg" id="estratificacion">
                                <thead class="thead-dark">
                                    <tr>
                                        <th colspan="5">Estratificación</th>
                                    </tr>
                                </thead>
                                <thead class='thead-light'>
                                    <tr>
                                        <th>Tamaño</th>
                                        <th>Giro</th>
                                        <th>Rango de número de trabajadores</th>
                                        <th>Rango de monto de ventas anuales (millones de pesos)</th>
                                        <th>Seleccione</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-primary">
                                        <td>Micro</td>
                                        <td>Todos</td>
                                        <td>Hasta 10</td>
                                        <td>Hasta $4</td>
                                        <td><input type="radio" name="tamanio_empresa" id="tamanio_empresa" required value="micro_todas"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td rowspan="2">Pequeña</td>
                                        <td>Comercio</td>
                                        <td>Desde 11 hasta 30</td>
                                        <td>Desde $4.01 hasta $100</td>
                                        <td><input type="radio" name="tamanio_empresa" id="" required value="pequenia_comercio"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Industria y servicios</td>
                                        <td>Desde 11 hasta 50</td>
                                        <td>Desde $4.01 hasta $100</td>
                                        <td><input type="radio" name="tamanio_empresa" id="" required value="pequenia_industria_servicios"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <p>
                                <b>Para las preguntas 3 y 4 debe considerarse también a usted mismo en el número de personas que trabajan en la empresa.</b>
                            </p>
                            <h3>3) Personal ocupado</h3>
                            <p>
                                Favor de revisar que el número total de la clasificación de mujeres y hombres, sea el mismo que el número total de la clasificación de familiares y no familiares.
                            </p>

                            <label for="">¿Cuántas personas trabajan permanentemente en la empresa?</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Mujeres</label>
                                    <input type="number" class="form-control" name="3a" id="mujeres" required>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Hombres</label>
                                    <input type="number" class="form-control" name="3b" id="hombres" required>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Total</label>
                                    <input type="number" class="form-control" name="3c" id="total1" required readonly>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Familiares</label>
                                    <input type="number" class="form-control" name="3d" id="familiares" required>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">No familiares</label>
                                    <input type="number" class="form-control" name="3e" id="no_familiares" required>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Total</label>
                                    <input type="number" class="form-control" name="3f" id="total2" required readonly>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                            </div>
                            <p id="totales_coinciden"></p>
                            <hr>
                            <h4>4) ¿Cuál es el nivel de estudios de sus trabajadores?</h3>

                                <label for="">4a) <b>Analfabeta (no sabe leer o escribir).</b></label>

                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Mujeres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4a1" id="4a1" required>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Hombres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4a2" id="4a2" required>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="">4b) <b>Sin estudios (sabe leer y escribir, pero no tiene estudios).</b></label>

                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Mujeres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4aa1" id="4aa1" required>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Hombres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4aa2" id="4aa2" required>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <hr>
                                <label for="">4c) <b>Educación básica (preescolar, primaria, secundaria, formación para el trabajo).</b></label>





                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Mujeres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4b1" id="4b1" required>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Hombres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4b2" id="4b2" required>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <label for="">4d) <b>Educación media superior (bachillerato general, bachillerato bivalente, profesional técnico).</b></label>


                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Mujeres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4c1" id="4c1" required>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Hombres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4c2" id="4c2" required>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <label for="">4e) <b>Educación superior (licenciatura, ingeniería, especialidad, posgrado).</b></label>


                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Mujeres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4d1" id="4d1" required><br>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Hombres</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" name="4d2" id="4d2" required>
                                        <div class="col-md-4">
                                            <div class="invalid-feedback">
                                                Complete este campo.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <b>Total de personas que trabajan permanentemente en la empresa: </b>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Total</label><br>
                                        <input type="number" name="4total" id="4total" class="form-control" readonly>
                                        <p id="total4"></p>
                                    </div>
                                </div>
                                <hr>

                                <h3>5) Seleccione la opción de respuesta que corresponda a lo que ofrece a sus trabajadores</h3>

                                <label for="">5a) Seguridad social o servicio formal de salud</label>
                                <select name="5a" id="5a" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>

                                <label for="">5b) Pensión</label>
                                <select name="5b" id="5b" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>

                                <label for="">5c) Bonos o prima de servicios</label>
                                <select name="5c" id="5c" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>

                                <label for="">5d) Participación de las utilidades a los trabajadores</label>
                                <select name="5d" id="5d" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>

                                <label for="">5e) Capacitación formal</label>
                                <select name="5e" id="5e" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>

                                <label for="">5f) Vacaciones pagadas</label>
                                <select name="5f" id="5f" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>

                                <hr>

                                <h3>6) Ingresos y gastos</h3>

                                <label for="">Comparando el inicio y final del año 2022, ¿cuáles fueron los resultados de la empresa en los siguientes conceptos?</label>
                                <table class="table table-responsive table-striped text-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Aumentaron mucho</th>
                                            <th>Aumentaron poco</th>
                                            <th>Permanece igual</th>
                                            <th>Disminuyeron poco</th>
                                            <th>Disminuyeron mucho</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td>6a) Las ventas anuales</td>
                                            <td><input type="radio" name="6a" id="" value="5" required></td>
                                            <td><input type="radio" name="6a" id="" value="4" required></td>
                                            <td><input type="radio" name="6a" id="" value="3" required></td>
                                            <td><input type="radio" name="6a" id="" value="2" required></td>
                                            <td><input type="radio" name="6a" id="" value="1" required></td>
                                            <div class="invalid-feedback">
                                                Seleccione una opción de las ventas anuales.
                                            </div>
                                        </tr>
                                        <tr>
                                            <td>6b) Las utilidades anuales</td>
                                            <td><input type="radio" name="6b" id="" value="5" required></td>
                                            <td><input type="radio" name="6b" id="" value="4" required></td>
                                            <td><input type="radio" name="6b" id="" value="3" required></td>
                                            <td><input type="radio" name="6b" id="" value="2" required></td>
                                            <td><input type="radio" name="6b" id="" value="1" required></td>
                                            <div class="invalid-feedback">
                                                Seleccione una opción de las utilidades.
                                            </div>
                                        </tr>
                                        <tr>
                                            <td>6c) El número de empleados</td>
                                            <td><input type="radio" name="6c" id="" value="5" required></td>
                                            <td><input type="radio" name="6c" id="" value="4" required></td>
                                            <td><input type="radio" name="6c" id="" value="3" required></td>
                                            <td><input type="radio" name="6c" id="" value="2" required></td>
                                            <td><input type="radio" name="6c" id="" value="1" required></td>
                                            <div class="invalid-feedback">
                                                Seleccione una opción del número de empleados.
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>

                                <label for="">Indique el porcentaje de ingresos y egresos de acuerdo a la siguiente distribución:</label>
                                <blockquote style="font-size: 11px;">
                                    Favor de anotar en cada recuadro el valor correspondiente, el rango permitido es de 0 a 100 por ciento.
                                </blockquote>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Partida</th>
                                                <th>Porcentaje</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>6d) Ingreso - Venta de servicios</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6d" id="6d" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6e) Ingreso - Venta de productos para su reventa sin transformación</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6e" id="6e" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6f) Ingreso - Venta de productos transformados por la empresa</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6f" id="6f" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-warning">Total de ventas <br>
                                                    <blockquote style="font-size: 11px;">El total de ventas es igual a la suma de la venta de servicios,
                                                        de productos para su reventa sin transformación y de productos transformados por la empresa.
                                                        La suma debe ser igual a 100%.</blockquote>
                                                </td>
                                                <td class="bg-warning">
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6g" id="6g" class="form-control" min='0' max='100' required readonly>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            La suma del total de ventas debe ser 100.
                                                        </div>
                                                    </div>
                                                    <p id="ingresos"></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6g) Egreso - Compra de materia prima (materiales para transformar en un producto)</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6h" id="6h" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6h) Egreso - Compra de productos para reventa sin transformación</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6i" id="6i" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6i) Egreso - Nómina</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6j" id="6j" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6j) Egreso - Gastos fijos (luz, agua, renta, gas, internet, telefonía, etc.)</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6k" id="6k" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6k) Egreso - Gastos variables (comisiones de venta, costos de distribución, etc.)</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6l" id="6l" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6l) Egreso - Gastos financieros (intereses de préstamos)</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6m" id="6m" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6m) Egreso - Otros</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6n" id="6n" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6n) Egreso - Impuestos (IVA, ISR, reparto de utilidades, etc.)</td>
                                                <td>
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6o" id="6o" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-warning">Total de egresos <br>
                                                    <blockquote style="font-size: 11px;">El total de egresos es la suma de todos los gastos: materia prima, productos para
                                                        reventa sin transformación, nómina, gastos fijos, gastos variables, gastos financieros, impuestos, otros e impuestos.
                                                        La suma debe ser igual al 100%.</blockquote>
                                                </td>
                                                <td class="bg-warning">
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6p" id="6p" class="form-control" min='0' max='100' required readonly>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            La suma del total de egresos debe ser 100.
                                                        </div>
                                                    </div>
                                                    <p id="egresos"></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-success">Utilidad <br>
                                                    <blockquote style="font-size: 11px;">La utilidad es el porcentaje de ganancia que considera que obtuvo la empresa.</blockquote>
                                                </td>
                                                <td class="bg-success">
                                                    <div class="input-group mb-3">
                                                        <input type="number" name="6q" id="6q" class="form-control" min='0' max='100' required onkeyup="countPorcentaje(event)">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="basic-addon2">%</span>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Ingrese un valor en el rango de 0 a 100
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                                <input type="button" name="next" class="next btn btn-block" value="Siguiente" />
                        </fieldset>

                        <fieldset id="field2">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">2ª PARTE: DATOS DEL DIRECTOR (A)</h2>
                            <hr>
                            <b>7) Información del directivo (a)</b>
                            <br>
                            <div>
                                <label for="">7a) Nivel de estudios</label>
                                <select name="7a" id="7a" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($nivel_estudios as $n) {
                                    ?>
                                        <option value="<?= $n['nombre'] ?>"><?= $n['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">7b) Edad</label>
                                <input type="number" class="form-control" name="7b" id="7b" min="18" max="130" required>
                                <p id="valid_edad"></p>
                                <div class="invalid-feedback">
                                    Ingrese una edad válida.
                                </div>
                            </div>

                            <div>
                                <label for="">7c) País donde nació</label>
                                <select name="7c" id="7c" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($paises as $p) {
                                    ?>
                                        <option value="<?= $p['nombre'] ?>"><?= $p['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">7d) Sexo</label>
                                <select name="7d" id="7d" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Hombre">Hombre</option>
                                    <option value="Mujer">Mujer</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">7e) ¿Tiene hijos?</label>
                                <select name="7e" id="7e" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Sí">Sí</option>
                                    <option value="No">No</option>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">7f) Estado civil</label>
                                <select name="7f" id="7f" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    foreach ($estado_civil as $e) {
                                    ?>
                                        <option value="<?= $e['nombre'] ?>"><?= $e['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>


                            <b>8) Tiempo dedicado a diversas labores</b>
                            <br>
                            <div class="row">
                                <div class="col-md-8">
                                    8a) ¿Cuántos días a la semana trabaja en la empresa?
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="8a" id="8a" min="1" max="7" class="form-control" required>
                                    <p id="valid_dias"></p>
                                    <div class="invalid-feedback">
                                        Ingrese una cantidad válida, valores permitidos del 1 al 7.
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-8">
                                    8b) ¿Cuántas horas promedio trabaja en la empresa por día?
                                </div>
                                <div class="col-md-4">
                                    <select name="8b" id="8b" class="form-control" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Hasta 3 horas">Hasta 3 horas</option>
                                        <option value="Hasta 6 horas">Hasta 6 horas</option>
                                        <option value="Hasta 9 horas">Hasta 9 horas</option>
                                        <option value="Hasta 12 horas">Hasta 12 horas</option>
                                        <option value="Hasta 15 horas">Hasta 15 horas</option>
                                        <option value="Más de 16 horas al día">Mas de 16 horas al día</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-8">
                                    8c) ¿Cuenta con otro trabajo en alguna organización?
                                </div>
                                <div class="col-md-4">
                                    <select name="8c" id="8c" class="form-control" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Sí">Sí</option>
                                        <option value="No">No</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    8d) ¿Actualmente estudia, ya sea una carrera o cursos?
                                </div>
                                <div class="col-md-4">
                                    <select name="8d" id="8d" class="form-control" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Sí">Sí</option>
                                        <option value="No">No</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    8e) ¿Cuántas horas dedica a labores del hogar al día?
                                </div>
                                <div class="col-md-4">
                                    <select name="8e" id="8e" class="form-control" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Nada de tiempo">Nada de tiempo</option>
                                        <option value="Hasta 3 horas">Hasta 3 horas</option>
                                        <option value="Hasta 6 horas">Hasta 6 horas</option>
                                        <option value="Hasta 9 horas">Hasta 9 horas</option>
                                        <option value="Hasta 12 horas">Hasta 12 horas</option>
                                        <option value="Hasta 15 horas">Hasta 15 horas</option>
                                        <option value="Más de 16 horas al día">Mas de 16 horas al día</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    8f) ¿Cuántas horas dedica al cuidado de otros miembros del hogar (hijos (as), esposo (a), padres u otros miembros) al día?
                                </div>
                                <div class="col-md-4">
                                    <select name="8f" id="8f" class="form-control" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Nada de tiempo">Nada de tiempo</option>
                                        <option value="Hasta 3 horas">Hasta 3 horas</option>
                                        <option value="Hasta 6 horas">Hasta 6 horas</option>
                                        <option value="Hasta 9 horas">Hasta 9 horas</option>
                                        <option value="Hasta 12 horas">Hasta 12 horas</option>
                                        <option value="Hasta 15 horas">Hasta 15 horas</option>
                                        <option value="Más de 16 horas al día">Mas de 16 horas al día</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Complete este campo.
                                    </div>
                                </div>
                            </div>





                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />

                        </fieldset>

                        <fieldset id="field3">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">3ª PARTE: INSUMOS DEL SISTEMA</h2>
                            <label for="">En la siguiente sección seleccione qué tan de acuerdo está con las frases que se mencionan.</label>
                            <label for="">En caso de que no aplique la pregunta o no sepa a qué se refiere seleccione <b>No sé / No aplica</b></label>
                            <table class="table table-striped table-responsive text-left">
                                <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Muy de acuerdo</th>
                                        <th>De acuerdo</th>
                                        <th>En desacuerdo</th>
                                        <th>Muy en desacuerdo</th>
                                        <th>No sé / No aplica</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">9) Recursos humanos</td>
                                    </tr>
                                    <tr>
                                        <td>9a) La empresa ha logrado conseguir un equipo de trabajo muy leal.</td>
                                        <td><input type="radio" name="9a" id="" value="4" required></td>
                                        <td><input type="radio" name="9a" id="" value="3" required></td>
                                        <td><input type="radio" name="9a" id="" value="2" required></td>
                                        <td><input type="radio" name="9a" id="" value="1" required></td>
                                        <td><input type="radio" name="9a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>9b) La empresa ha logrado conseguir un equipo de trabajo muy capaz.</td>
                                        <td><input type="radio" name="9b" id="" value="4" required></td>
                                        <td><input type="radio" name="9b" id="" value="3" required></td>
                                        <td><input type="radio" name="9b" id="" value="2" required></td>
                                        <td><input type="radio" name="9b" id="" value="1" required></td>
                                        <td><input type="radio" name="9b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>9c) La empresa ha logrado conseguir un equipo de trabajo que tiene buen trato con todas las personas.</td>
                                        <td><input type="radio" name="9c" id="" value="4" required></td>
                                        <td><input type="radio" name="9c" id="" value="3" required></td>
                                        <td><input type="radio" name="9c" id="" value="2" required></td>
                                        <td><input type="radio" name="9c" id="" value="1" required></td>
                                        <td><input type="radio" name="9c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>9d) Me enfoco principalmente en mejorar la productividad del personal empleado.</td>
                                        <td><input type="radio" name="9d" id="" value="4" required></td>
                                        <td><input type="radio" name="9d" id="" value="3" required></td>
                                        <td><input type="radio" name="9d" id="" value="2" required></td>
                                        <td><input type="radio" name="9d" id="" value="1" required></td>
                                        <td><input type="radio" name="9d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>9e) Me enfoco principalmente en mejorar el bienestar del personal empleado.</td>
                                        <td><input type="radio" name="9e" id="" value="4" required></td>
                                        <td><input type="radio" name="9e" id="" value="3" required></td>
                                        <td><input type="radio" name="9e" id="" value="2" required></td>
                                        <td><input type="radio" name="9e" id="" value="1" required></td>
                                        <td><input type="radio" name="9e" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">10) Análisis de mercado (información)</td>
                                    </tr>
                                    <tr>
                                        <td>10a) Tengo métodos eficaces para evaluar si el precio de mis productos o servicios es adecuado.</td>
                                        <td><input type="radio" name="10a" id="" value="4" required></td>
                                        <td><input type="radio" name="10a" id="" value="3" required></td>
                                        <td><input type="radio" name="10a" id="" value="2" required></td>
                                        <td><input type="radio" name="10a" id="" value="1" required></td>
                                        <td><input type="radio" name="10a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>10b) Tengo métodos eficaces para evaluar la calidad de mis productos o servicios.</td>
                                        <td><input type="radio" name="10b" id="" value="4" required></td>
                                        <td><input type="radio" name="10b" id="" value="3" required></td>
                                        <td><input type="radio" name="10b" id="" value="2" required></td>
                                        <td><input type="radio" name="10b" id="" value="1" required></td>
                                        <td><input type="radio" name="10b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>10c) Tengo métodos eficaces para conocer a mis clientes, sus necesidades y preferencias.</td>
                                        <td><input type="radio" name="10c" id="" value="4" required></td>
                                        <td><input type="radio" name="10c" id="" value="3" required></td>
                                        <td><input type="radio" name="10c" id="" value="2" required></td>
                                        <td><input type="radio" name="10c" id="" value="1" required></td>
                                        <td><input type="radio" name="10c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>10d) Tengo métodos eficaces para evaluar la calidad de la atención que le doy a mis clientes.</td>
                                        <td><input type="radio" name="10d" id="" value="4" required></td>
                                        <td><input type="radio" name="10d" id="" value="3" required></td>
                                        <td><input type="radio" name="10d" id="" value="2" required></td>
                                        <td><input type="radio" name="10d" id="" value="1" required></td>
                                        <td><input type="radio" name="10d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>10e) Tengo métodos eficaces para detectar las fortalezas y debilidades de mi competencia.</td>
                                        <td><input type="radio" name="10e" id="" value="4" required></td>
                                        <td><input type="radio" name="10e" id="" value="3" required></td>
                                        <td><input type="radio" name="10e" id="" value="2" required></td>
                                        <td><input type="radio" name="10e" id="" value="1" required></td>
                                        <td><input type="radio" name="10e" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">11) Proveedores</td>
                                    </tr>
                                    <tr>
                                        <td>11a) Lo más importante para mí en un proveedor es que me dé el mejor precio.</td>
                                        <td><input type="radio" name="11a" id="" value="4" required></td>
                                        <td><input type="radio" name="11a" id="" value="3" required></td>
                                        <td><input type="radio" name="11a" id="" value="2" required></td>
                                        <td><input type="radio" name="11a" id="" value="1" required></td>
                                        <td><input type="radio" name="11a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>11b) Lo más importante para mí en un proveedor es la calidad de su producto o servicio.</td>
                                        <td><input type="radio" name="11b" id="" value="4" required></td>
                                        <td><input type="radio" name="11b" id="" value="3" required></td>
                                        <td><input type="radio" name="11b" id="" value="2" required></td>
                                        <td><input type="radio" name="11b" id="" value="1" required></td>
                                        <td><input type="radio" name="11b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>11c) Lo más importante para mí en un proveedor es que siempre tenga lo que necesito.</td>
                                        <td><input type="radio" name="11c" id="" value="4" required></td>
                                        <td><input type="radio" name="11c" id="" value="3" required></td>
                                        <td><input type="radio" name="11c" id="" value="2" required></td>
                                        <td><input type="radio" name="11c" id="" value="1" required></td>
                                        <td><input type="radio" name="11c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>11d) Lo más importante para mí en un proveedor es la marca de su producto o servicio.</td>
                                        <td><input type="radio" name="11d" id="" value="4" required></td>
                                        <td><input type="radio" name="11d" id="" value="3" required></td>
                                        <td><input type="radio" name="11d" id="" value="2" required></td>
                                        <td><input type="radio" name="11d" id="" value="1" required></td>
                                        <td><input type="radio" name="11d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>11e) Lo más importante para mí en un proveedor es que me trate muy bien y atienda mis quejas.</td>
                                        <td><input type="radio" name="11e" id="" value="4" required></td>
                                        <td><input type="radio" name="11e" id="" value="3" required></td>
                                        <td><input type="radio" name="11e" id="" value="2" required></td>
                                        <td><input type="radio" name="11e" id="" value="1" required></td>
                                        <td><input type="radio" name="11e" id="" value="nc" required></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />
                        </fieldset>

                        <fieldset id="field4">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">4ª PARTE: PROCESOS DEL SISTEMA</h2>
                            <label for="">En la siguiente sección seleccione qué tan de acuerdo está con las frases que se mencionan.</label>
                            <label for="">En caso de que no aplique la pregunta o no sepa a qué se refiere seleccione <b>No sé / No aplica</b></label>

                            <table class="table table-striped table-responsive text-left">
                                <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Muy de acuerdo</th>
                                        <th>De acuerdo</th>
                                        <th>En desacuerdo</th>
                                        <th>Muy en desacuerdo</th>
                                        <th>No sé / No aplica</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">12) Dirección</td>
                                    </tr>
                                    <tr>
                                        <td>12a) Tengo clara la misión y la visión, la comparto con el personal empleado y tratamos de realizarla.</td>
                                        <td><input type="radio" name="12a" id="" value="4" required></td>
                                        <td><input type="radio" name="12a" id="" value="3" required></td>
                                        <td><input type="radio" name="12a" id="" value="2" required></td>
                                        <td><input type="radio" name="12a" id="" value="1" required></td>
                                        <td><input type="radio" name="12a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>12b) Planteo objetivos concretos que tenemos que lograr en la empresa.</td>
                                        <td><input type="radio" name="12b" id="" value="4" required></td>
                                        <td><input type="radio" name="12b" id="" value="3" required></td>
                                        <td><input type="radio" name="12b" id="" value="2" required></td>
                                        <td><input type="radio" name="12b" id="" value="1" required></td>
                                        <td><input type="radio" name="12b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>12c) Planteo una estrategia comercial y se realizan algunas acciones a prueba y error.</td>
                                        <td><input type="radio" name="12c" id="" value="4" required></td>
                                        <td><input type="radio" name="12c" id="" value="3" required></td>
                                        <td><input type="radio" name="12c" id="" value="2" required></td>
                                        <td><input type="radio" name="12c" id="" value="1" required></td>
                                        <td><input type="radio" name="12c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>12d) No suelo planear de antemano la estrategia de la empresa, sino que surge a medida que veo la mejor forma de lograr nuestros objetivos.</td>
                                        <td><input type="radio" name="12d" id="" value="4" required></td>
                                        <td><input type="radio" name="12d" id="" value="3" required></td>
                                        <td><input type="radio" name="12d" id="" value="2" required></td>
                                        <td><input type="radio" name="12d" id="" value="1" required></td>
                                        <td><input type="radio" name="12d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>12e) La estrategia competitiva de mi empresa generalmente resulta de un proceso formal de planeación, es decir, el plan formal precede a la acción.</td>
                                        <td><input type="radio" name="12e" id="" value="4" required></td>
                                        <td><input type="radio" name="12e" id="" value="3" required></td>
                                        <td><input type="radio" name="12e" id="" value="2" required></td>
                                        <td><input type="radio" name="12e" id="" value="1" required></td>
                                        <td><input type="radio" name="12e" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">13) Gestión de ventas</td>
                                    </tr>
                                    <tr>
                                        <td>13a) Realizo actividades para detectar y agregar nuevos clientes a la empresa.</td>
                                        <td><input type="radio" name="13a" id="" value="4" required></td>
                                        <td><input type="radio" name="13a" id="" value="3" required></td>
                                        <td><input type="radio" name="13a" id="" value="2" required></td>
                                        <td><input type="radio" name="13a" id="" value="1" required></td>
                                        <td><input type="radio" name="13a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>13b) Realizo actividades para vender en un área más grande o en más lugares.</td>
                                        <td><input type="radio" name="13b" id="" value="4" required></td>
                                        <td><input type="radio" name="13b" id="" value="3" required></td>
                                        <td><input type="radio" name="13b" id="" value="2" required></td>
                                        <td><input type="radio" name="13b" id="" value="1" required></td>
                                        <td><input type="radio" name="13b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>13c) Realizo actividades para promocionar las ventas.</td>
                                        <td><input type="radio" name="13c" id="" value="4" required></td>
                                        <td><input type="radio" name="13c" id="" value="3" required></td>
                                        <td><input type="radio" name="13c" id="" value="2" required></td>
                                        <td><input type="radio" name="13c" id="" value="1" required></td>
                                        <td><input type="radio" name="13c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>13d) Realizo actividades de financiamiento (crédito) para cerrar algunas ventas.</td>
                                        <td><input type="radio" name="13d" id="" value="4" required></td>
                                        <td><input type="radio" name="13d" id="" value="3" required></td>
                                        <td><input type="radio" name="13d" id="" value="2" required></td>
                                        <td><input type="radio" name="13d" id="" value="1" required></td>
                                        <td><input type="radio" name="13d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>13e) Invierto tiempo y dinero en las relaciones con los clientes aun sin pretender vender inmediatamente.</td>
                                        <td><input type="radio" name="13e" id="" value="4" required></td>
                                        <td><input type="radio" name="13e" id="" value="3" required></td>
                                        <td><input type="radio" name="13e" id="" value="2" required></td>
                                        <td><input type="radio" name="13e" id="" value="1" required></td>
                                        <td><input type="radio" name="13e" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">14) Finanzas</td>
                                    </tr>
                                    <tr>
                                        <td>14a) Tengo muy claro el valor de lo que vendo cada mes.</td>
                                        <td><input type="radio" name="14a" id="" value="4" required></td>
                                        <td><input type="radio" name="14a" id="" value="3" required></td>
                                        <td><input type="radio" name="14a" id="" value="2" required></td>
                                        <td><input type="radio" name="14a" id="" value="1" required></td>
                                        <td><input type="radio" name="14a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>14b) Tengo muy claro el valor de todo lo que cobro cada mes.</td>
                                        <td><input type="radio" name="14b" id="" value="4" required></td>
                                        <td><input type="radio" name="14b" id="" value="3" required></td>
                                        <td><input type="radio" name="14b" id="" value="2" required></td>
                                        <td><input type="radio" name="14b" id="" value="1" required></td>
                                        <td><input type="radio" name="14b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>14c) Tengo muy claro el valor de todo lo que compro a proveedores cada mes.</td>
                                        <td><input type="radio" name="14c" id="" value="4" required></td>
                                        <td><input type="radio" name="14c" id="" value="3" required></td>
                                        <td><input type="radio" name="14c" id="" value="2" required></td>
                                        <td><input type="radio" name="14c" id="" value="1" required></td>
                                        <td><input type="radio" name="14c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>14d) Tengo muy claro el valor de todo lo que pago a proveedores cada mes.</td>
                                        <td><input type="radio" name="14d" id="" value="4" required></td>
                                        <td><input type="radio" name="14d" id="" value="3" required></td>
                                        <td><input type="radio" name="14d" id="" value="2" required></td>
                                        <td><input type="radio" name="14d" id="" value="1" required></td>
                                        <td><input type="radio" name="14d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>14e) Tengo muy claro el valor de todo lo que gasto.</td>
                                        <td><input type="radio" name="14e" id="" value="4" required></td>
                                        <td><input type="radio" name="14e" id="" value="3" required></td>
                                        <td><input type="radio" name="14e" id="" value="2" required></td>
                                        <td><input type="radio" name="14e" id="" value="1" required></td>
                                        <td><input type="radio" name="14e" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">15) Innovación</td>
                                    </tr>
                                    <tr>
                                        <td>15a) Desarrollo o pago para innovar mis procesos de producción o distribución.</td>
                                        <td><input type="radio" name="15a" id="" value="4" required></td>
                                        <td><input type="radio" name="15a" id="" value="3" required></td>
                                        <td><input type="radio" name="15a" id="" value="2" required></td>
                                        <td><input type="radio" name="15a" id="" value="1" required></td>
                                        <td><input type="radio" name="15a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>15b) Desarrollo o pago para innovar los productos o servicios que ofrezco.</td>
                                        <td><input type="radio" name="15b" id="" value="4" required></td>
                                        <td><input type="radio" name="15b" id="" value="3" required></td>
                                        <td><input type="radio" name="15b" id="" value="2" required></td>
                                        <td><input type="radio" name="15b" id="" value="1" required></td>
                                        <td><input type="radio" name="15b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>15c) Desarrollo o pago para innovar la forma en la que vendo mi producto o servicio (diseño, envase, promoción, forma de cotizar, etc.).</td>
                                        <td><input type="radio" name="15c" id="" value="4" required></td>
                                        <td><input type="radio" name="15c" id="" value="3" required></td>
                                        <td><input type="radio" name="15c" id="" value="2" required></td>
                                        <td><input type="radio" name="15c" id="" value="1" required></td>
                                        <td><input type="radio" name="15c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>15d) Desarrollo o pago para innovar la forma en la que organizo la empresa.</td>
                                        <td><input type="radio" name="15d" id="" value="4" required></td>
                                        <td><input type="radio" name="15d" id="" value="3" required></td>
                                        <td><input type="radio" name="15d" id="" value="2" required></td>
                                        <td><input type="radio" name="15d" id="" value="1" required></td>
                                        <td><input type="radio" name="15d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>15e) Asisto a ferias, cursos, congresos o a otras actividades relacionadas con el negocio.</td>
                                        <td><input type="radio" name="15e" id="" value="4" required></td>
                                        <td><input type="radio" name="15e" id="" value="3" required></td>
                                        <td><input type="radio" name="15e" id="" value="2" required></td>
                                        <td><input type="radio" name="15e" id="" value="1" required></td>
                                        <td><input type="radio" name="15e" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">16) Mercadotecnia</td>
                                    </tr>
                                    <tr>
                                        <td>16a) Me enfoco principalmente en dar un muy buen servicio a mis clientes.</td>
                                        <td><input type="radio" name="16a" id="" value="4" required></td>
                                        <td><input type="radio" name="16a" id="" value="3" required></td>
                                        <td><input type="radio" name="16a" id="" value="2" required></td>
                                        <td><input type="radio" name="16a" id="" value="1" required></td>
                                        <td><input type="radio" name="16a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16b) Fijo los precios de mis productos y servicios en función de mis clientes y mi competencia.</td>
                                        <td><input type="radio" name="16b" id="" value="4" required></td>
                                        <td><input type="radio" name="16b" id="" value="3" required></td>
                                        <td><input type="radio" name="16b" id="" value="2" required></td>
                                        <td><input type="radio" name="16b" id="" value="1" required></td>
                                        <td><input type="radio" name="16b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16c) Busco crear, desarrollar y usar una marca para que mis clientes identifiquen mi empresa.</td>
                                        <td><input type="radio" name="16c" id="" value="4" required></td>
                                        <td><input type="radio" name="16c" id="" value="3" required></td>
                                        <td><input type="radio" name="16c" id="" value="2" required></td>
                                        <td><input type="radio" name="16c" id="" value="1" required></td>
                                        <td><input type="radio" name="16c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16d) Realizo actividades de publicidad y promoción sobre mi producto o servicio.</td>
                                        <td><input type="radio" name="16d" id="" value="4" required></td>
                                        <td><input type="radio" name="16d" id="" value="3" required></td>
                                        <td><input type="radio" name="16d" id="" value="2" required></td>
                                        <td><input type="radio" name="16d" id="" value="1" required></td>
                                        <td><input type="radio" name="16d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16e) Hago pruebas de mis productos o servicios antes de lanzarlos al mercado.</td>
                                        <td><input type="radio" name="16e" id="" value="4" required></td>
                                        <td><input type="radio" name="16e" id="" value="3" required></td>
                                        <td><input type="radio" name="16e" id="" value="2" required></td>
                                        <td><input type="radio" name="16e" id="" value="1" required></td>
                                        <td><input type="radio" name="16e" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">17) Producción-operación</td>
                                    </tr>
                                    <tr>
                                        <td>17a) Me enfoco mucho en la calidad de mis productos o servicios.</td>
                                        <td><input type="radio" name="17a" id="" value="4" required></td>
                                        <td><input type="radio" name="17a" id="" value="3" required></td>
                                        <td><input type="radio" name="17a" id="" value="2" required></td>
                                        <td><input type="radio" name="17a" id="" value="1" required></td>
                                        <td><input type="radio" name="17a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17b) Me enfoco mucho en reducir el tiempo entre que el cliente solicita y recibe su producto o servicio.</td>
                                        <td><input type="radio" name="17b" id="" value="4" required></td>
                                        <td><input type="radio" name="17b" id="" value="3" required></td>
                                        <td><input type="radio" name="17b" id="" value="2" required></td>
                                        <td><input type="radio" name="17b" id="" value="1" required></td>
                                        <td><input type="radio" name="17b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17c) Me enfoco mucho en entregar mi servicio siempre en tiempo y forma.</td>
                                        <td><input type="radio" name="17c" id="" value="4" required></td>
                                        <td><input type="radio" name="17c" id="" value="3" required></td>
                                        <td><input type="radio" name="17c" id="" value="2" required></td>
                                        <td><input type="radio" name="17c" id="" value="1" required></td>
                                        <td><input type="radio" name="17c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17d) Me enfoco mucho en mantener un inventario óptimo para poder operar.</td>
                                        <td><input type="radio" name="17d" id="" value="4" required></td>
                                        <td><input type="radio" name="17d" id="" value="3" required></td>
                                        <td><input type="radio" name="17d" id="" value="2" required></td>
                                        <td><input type="radio" name="17d" id="" value="1" required></td>
                                        <td><input type="radio" name="17d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17e) Me enfoco mucho en reducir mis costos en todas las áreas de la empresa.</td>
                                        <td><input type="radio" name="17e" id="" value="4" required></td>
                                        <td><input type="radio" name="17e" id="" value="3" required></td>
                                        <td><input type="radio" name="17e" id="" value="2" required></td>
                                        <td><input type="radio" name="17e" id="" value="1" required></td>
                                        <td><input type="radio" name="17e" id="" value="nc" required></td>
                                    </tr>
                                </tbody>
                            </table>


                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />
                        </fieldset>

                        <fieldset id="field5">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">5ª PARTE: RESULTADOS DEL SISTEMA</h2>
                            <label for="">En la siguiente sección seleccione qué tan de acuerdo está con las frases que se mencionan.</label>
                            <label for="">En caso de que no aplique la pregunta o no sepa a qué se refiere seleccione <b>No sé / No aplica</b></label>

                            <table class="table table-striped table-responsive text-left">
                                <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Muy de acuerdo</th>
                                        <th>De acuerdo</th>
                                        <th>En desacuerdo</th>
                                        <th>Muy en desacuerdo</th>
                                        <th>No sé / No aplica</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">18) Satisfacción con la empresa</td>
                                    </tr>
                                    <tr>
                                        <td>18a) Estoy muy satisfecho con el desempeño de la empresa en su conjunto.</td>
                                        <td><input type="radio" name="18a" id="" value="4" required></td>
                                        <td><input type="radio" name="18a" id="" value="3" required></td>
                                        <td><input type="radio" name="18a" id="" value="2" required></td>
                                        <td><input type="radio" name="18a" id="" value="1" required></td>
                                        <td><input type="radio" name="18a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18b) La empresa le deja más que suficiente dinero para vivir.</td>
                                        <td><input type="radio" name="18b" id="" value="4" required></td>
                                        <td><input type="radio" name="18b" id="" value="3" required></td>
                                        <td><input type="radio" name="18b" id="" value="2" required></td>
                                        <td><input type="radio" name="18b" id="" value="1" required></td>
                                        <td><input type="radio" name="18b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18c) La empresa le permite realizarme como persona.</td>
                                        <td><input type="radio" name="18c" id="" value="4" required></td>
                                        <td><input type="radio" name="18c" id="" value="3" required></td>
                                        <td><input type="radio" name="18c" id="" value="2" required></td>
                                        <td><input type="radio" name="18c" id="" value="1" required></td>
                                        <td><input type="radio" name="18c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18d) Tengo expectativas de crecimiento de mi empresa muy altas.</td>
                                        <td><input type="radio" name="18d" id="" value="4" required></td>
                                        <td><input type="radio" name="18d" id="" value="3" required></td>
                                        <td><input type="radio" name="18d" id="" value="2" required></td>
                                        <td><input type="radio" name="18d" id="" value="1" required></td>
                                        <td><input type="radio" name="18d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18e) A futuro tengo expectativas de que mi empresa va a exportar.</td>
                                        <td><input type="radio" name="18e" id="" value="4" required></td>
                                        <td><input type="radio" name="18e" id="" value="3" required></td>
                                        <td><input type="radio" name="18e" id="" value="2" required></td>
                                        <td><input type="radio" name="18e" id="" value="1" required></td>
                                        <td><input type="radio" name="18e" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">19) Ventaja competitiva</td>
                                    </tr>
                                    <tr>
                                        <td>19a) Los clientes nos eligen porque nuestro producto o servicio es el mejor en su categoría.</td>
                                        <td><input type="radio" name="19a" id="" value="4" required></td>
                                        <td><input type="radio" name="19a" id="" value="3" required></td>
                                        <td><input type="radio" name="19a" id="" value="2" required></td>
                                        <td><input type="radio" name="19a" id="" value="1" required></td>
                                        <td><input type="radio" name="19a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19b) Los clientes nos eligen porque los tratamos muy bien.</td>
                                        <td><input type="radio" name="19b" id="" value="4" required></td>
                                        <td><input type="radio" name="19b" id="" value="3" required></td>
                                        <td><input type="radio" name="19b" id="" value="2" required></td>
                                        <td><input type="radio" name="19b" id="" value="1" required></td>
                                        <td><input type="radio" name="19b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19c) Los clientes nos eligen porque ofrecemos el mejor precio.</td>
                                        <td><input type="radio" name="19c" id="" value="4" required></td>
                                        <td><input type="radio" name="19c" id="" value="3" required></td>
                                        <td><input type="radio" name="19c" id="" value="2" required></td>
                                        <td><input type="radio" name="19c" id="" value="1" required></td>
                                        <td><input type="radio" name="19c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19d) Los clientes nos eligen porque aprecian nuestra marca.</td>
                                        <td><input type="radio" name="19d" id="" value="4" required></td>
                                        <td><input type="radio" name="19d" id="" value="3" required></td>
                                        <td><input type="radio" name="19d" id="" value="2" required></td>
                                        <td><input type="radio" name="19d" id="" value="1" required></td>
                                        <td><input type="radio" name="19d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19e) Los clientes nos eligen porque saben que siempre tenemos disponible el producto o servicio.</td>
                                        <td><input type="radio" name="19e" id="" value="4" required></td>
                                        <td><input type="radio" name="19e" id="" value="3" required></td>
                                        <td><input type="radio" name="19e" id="" value="2" required></td>
                                        <td><input type="radio" name="19e" id="" value="1" required></td>
                                        <td><input type="radio" name="19e" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">20) Responsabilidad Social Corporativa (RSC) - Asuntos de ISO 26000</td>
                                    </tr>

                                    <tr>
                                        <td>20a) Tenemos políticas y procedimientos para el respeto a los <b><u>derechos humanos</u></b> y para evitar complicidad en actos contra los derechos civiles, económicos, sociales, laborales y para evitar la discriminación.</td>
                                        <td><input type="radio" name="20a" id="" value="4" required></td>
                                        <td><input type="radio" name="20a" id="" value="3" required></td>
                                        <td><input type="radio" name="20a" id="" value="2" required></td>
                                        <td><input type="radio" name="20a" id="" value="1" required></td>
                                        <td><input type="radio" name="20a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20b) En mi empresa procuramos prevenir <b><u>la contaminación y la producción de desechos</u></b> que impactan el ecosistema; así como reciclar y cuidar el medio ambiente.</td>
                                        <td><input type="radio" name="20b" id="" value="4" required></td>
                                        <td><input type="radio" name="20b" id="" value="3" required></td>
                                        <td><input type="radio" name="20b" id="" value="2" required></td>
                                        <td><input type="radio" name="20b" id="" value="1" required></td>
                                        <td><input type="radio" name="20b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20c) En mi empresa procuramos el <b><u>bienestar del personal empleado</u></b>, escuchando sus necesidades, dándoles un ambiente seguro, acceso a servicios de salud y una vida personal balanceada.</td>
                                        <td><input type="radio" name="20c" id="" value="4" required></td>
                                        <td><input type="radio" name="20c" id="" value="3" required></td>
                                        <td><input type="radio" name="20c" id="" value="2" required></td>
                                        <td><input type="radio" name="20c" id="" value="1" required></td>
                                        <td><input type="radio" name="20c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20d) En mi empresa evitamos involucrarnos en <b><u>malas prácticas</u></b> como en sobornos, corrupción, piratería o competencia desleal; y tampoco las permitimos en nuestros clientes y proveedores.</td>
                                        <td><input type="radio" name="20d" id="" value="4" required></td>
                                        <td><input type="radio" name="20d" id="" value="3" required></td>
                                        <td><input type="radio" name="20d" id="" value="2" required></td>
                                        <td><input type="radio" name="20d" id="" value="1" required></td>
                                        <td><input type="radio" name="20d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20e) En mi empresa somos <b><u>responsables con nuestros clientes</u></b>: cuidamos su confidencialidad, atendemos sus quejas, comunicamos sin engaños la información que les interesa respecto a precios, costos, términos de servicio, contratos y ofrecemos productos que son seguros.</td>
                                        <td><input type="radio" name="20e" id="" value="4" required></td>
                                        <td><input type="radio" name="20e" id="" value="3" required></td>
                                        <td><input type="radio" name="20e" id="" value="2" required></td>
                                        <td><input type="radio" name="20e" id="" value="1" required></td>
                                        <td><input type="radio" name="20e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20f) La empresa promueve actividades de <b><u>desarrollo comunitario</u></b> con gente de la comunidad en donde se encuentra ubicada. Se preocupa por no provocar e incluso solucionar problemas sociales locales. Preferimos proveedores locales que foráneos.</td>
                                        <td><input type="radio" name="20f" id="" value="4" required></td>
                                        <td><input type="radio" name="20f" id="" value="3" required></td>
                                        <td><input type="radio" name="20f" id="" value="2" required></td>
                                        <td><input type="radio" name="20f" id="" value="1" required></td>
                                        <td><input type="radio" name="20f" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">21) Valoración del entorno</td>
                                    </tr>

                                    <tr>
                                        <td>21a) En la empresa nos preocupa la situación económica del país.</td>
                                        <td><input type="radio" name="21a" id="" value="4" required></td>
                                        <td><input type="radio" name="21a" id="" value="3" required></td>
                                        <td><input type="radio" name="21a" id="" value="2" required></td>
                                        <td><input type="radio" name="21a" id="" value="1" required></td>
                                        <td><input type="radio" name="21a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>21b) En la empresa nos preocupa la inseguridad y la violencia.</td>
                                        <td><input type="radio" name="21b" id="" value="4" required></td>
                                        <td><input type="radio" name="21b" id="" value="3" required></td>
                                        <td><input type="radio" name="21b" id="" value="2" required></td>
                                        <td><input type="radio" name="21b" id="" value="1" required></td>
                                        <td><input type="radio" name="21b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>21c) En la empresa nos preocupa la corrupción.</td>
                                        <td><input type="radio" name="21c" id="" value="4" required></td>
                                        <td><input type="radio" name="21c" id="" value="3" required></td>
                                        <td><input type="radio" name="21c" id="" value="2" required></td>
                                        <td><input type="radio" name="21c" id="" value="1" required></td>
                                        <td><input type="radio" name="21c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>21d) En la empresa nos preocupa la inestabilidad política.</td>
                                        <td><input type="radio" name="21d" id="" value="4" required></td>
                                        <td><input type="radio" name="21d" id="" value="3" required></td>
                                        <td><input type="radio" name="21d" id="" value="2" required></td>
                                        <td><input type="radio" name="21d" id="" value="1" required></td>
                                        <td><input type="radio" name="21d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>21e) En la empresa nos preocupa que la gente en el gobierno este haciendo un buen trabajo.</td>
                                        <td><input type="radio" name="21e" id="" value="4" required></td>
                                        <td><input type="radio" name="21e" id="" value="3" required></td>
                                        <td><input type="radio" name="21e" id="" value="2" required></td>
                                        <td><input type="radio" name="21e" id="" value="1" required></td>
                                        <td><input type="radio" name="21e" id="" value="nc" required></td>
                                    </tr>


                                </tbody>
                            </table>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />





                        </fieldset>

                        <fieldset id="field6">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">6ª PARTE: TEMA ANUAL</h2>
                            <label for="">En la siguiente sección seleccione qué tan de acuerdo está con las frases que se mencionan.</label>
                            <label for="">En caso de que no aplique la pregunta o no sepa a qué se refiere seleccione <b>No sé / No aplica</b></label>

                            <table class="table table-striped table-responsive text-left">
                                <tbody>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">22) El trabajo decente desde la perspectiva directiva</td>
                                    </tr>
                                    <tr>
                                        <td>22a) Para mi equipo de trabajo es fácil conseguir empleo en negocios como el mío.</td>
                                        <td><input type="radio" name="22a" id="" value="4" required></td>
                                        <td><input type="radio" name="22a" id="" value="3" required></td>
                                        <td><input type="radio" name="22a" id="" value="2" required></td>
                                        <td><input type="radio" name="22a" id="" value="1" required></td>
                                        <td><input type="radio" name="22a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22b) En este negocio se brinda empleo a jóvenes aun cuando no tienen experiencia.</td>
                                        <td><input type="radio" name="22b" id="" value="4" required></td>
                                        <td><input type="radio" name="22b" id="" value="3" required></td>
                                        <td><input type="radio" name="22b" id="" value="2" required></td>
                                        <td><input type="radio" name="22b" id="" value="1" required></td>
                                        <td><input type="radio" name="22b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22c) El personal de la empresa dura más de un año en el negocio.</td>
                                        <td><input type="radio" name="22c" id="" value="4" required></td>
                                        <td><input type="radio" name="22c" id="" value="3" required></td>
                                        <td><input type="radio" name="22c" id="" value="2" required></td>
                                        <td><input type="radio" name="22c" id="" value="1" required></td>
                                        <td><input type="radio" name="22c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22d) Considero que podré continuar con el mismo personal para el próximo año.</td>
                                        <td><input type="radio" name="22d" id="" value="4" required></td>
                                        <td><input type="radio" name="22d" id="" value="3" required></td>
                                        <td><input type="radio" name="22d" id="" value="2" required></td>
                                        <td><input type="radio" name="22d" id="" value="1" required></td>
                                        <td><input type="radio" name="22d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22e) El ingreso de mi equipo de trabajo le permite cubrir sus necesidades básicas.</td>
                                        <td><input type="radio" name="22e" id="" value="4" required></td>
                                        <td><input type="radio" name="22e" id="" value="3" required></td>
                                        <td><input type="radio" name="22e" id="" value="2" required></td>
                                        <td><input type="radio" name="22e" id="" value="1" required></td>
                                        <td><input type="radio" name="22e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22f) Los salarios se establecen de acuerdo con el rendimiento y preparación de cada miembro del negocio.</td>
                                        <td><input type="radio" name="22f" id="" value="4" required></td>
                                        <td><input type="radio" name="22f" id="" value="3" required></td>
                                        <td><input type="radio" name="22f" id="" value="2" required></td>
                                        <td><input type="radio" name="22f" id="" value="1" required></td>
                                        <td><input type="radio" name="22f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22g) La jornada de trabajo con frecuencia es agotadora para el personal.</td>
                                        <td><input type="radio" name="22g" id="" value="4" required></td>
                                        <td><input type="radio" name="22g" id="" value="3" required></td>
                                        <td><input type="radio" name="22g" id="" value="2" required></td>
                                        <td><input type="radio" name="22g" id="" value="1" required></td>
                                        <td><input type="radio" name="22g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22h) El horario laboral permite a mi equipo de trabajo cumplir con sus actividades.</td>
                                        <td><input type="radio" name="22h" id="" value="4" required></td>
                                        <td><input type="radio" name="22h" id="" value="3" required></td>
                                        <td><input type="radio" name="22h" id="" value="2" required></td>
                                        <td><input type="radio" name="22h" id="" value="1" required></td>
                                        <td><input type="radio" name="22h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22i) Mi equipo de trabajo cuenta con tiempo para compartir con su familia.</td>
                                        <td><input type="radio" name="22i" id="" value="4" required></td>
                                        <td><input type="radio" name="22i" id="" value="3" required></td>
                                        <td><input type="radio" name="22i" id="" value="2" required></td>
                                        <td><input type="radio" name="22i" id="" value="1" required></td>
                                        <td><input type="radio" name="22i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22j) Mi equipo de trabajo cuenta con tiempo para actividades recreativas o deportivas.</td>
                                        <td><input type="radio" name="22j" id="" value="4" required></td>
                                        <td><input type="radio" name="22j" id="" value="3" required></td>
                                        <td><input type="radio" name="22j" id="" value="2" required></td>
                                        <td><input type="radio" name="22j" id="" value="1" required></td>
                                        <td><input type="radio" name="22j" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22k) Mi equipo de trabajo cuenta con tiempo para continuar con sus estudios.</td>
                                        <td><input type="radio" name="22k" id="" value="4" required></td>
                                        <td><input type="radio" name="22k" id="" value="3" required></td>
                                        <td><input type="radio" name="22k" id="" value="2" required></td>
                                        <td><input type="radio" name="22k" id="" value="1" required></td>
                                        <td><input type="radio" name="22k" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22l) Aquí se dan las mismas oportunidades de crecimiento para hombres y mujeres.</td>
                                        <td><input type="radio" name="22l" id="" value="4" required></td>
                                        <td><input type="radio" name="22l" id="" value="3" required></td>
                                        <td><input type="radio" name="22l" id="" value="2" required></td>
                                        <td><input type="radio" name="22l" id="" value="1" required></td>
                                        <td><input type="radio" name="22l" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22m) Aquí se les paga igual a hombres y mujeres.</td>
                                        <td><input type="radio" name="22m" id="" value="4" required></td>
                                        <td><input type="radio" name="22m" id="" value="3" required></td>
                                        <td><input type="radio" name="22m" id="" value="2" required></td>
                                        <td><input type="radio" name="22m" id="" value="1" required></td>
                                        <td><input type="radio" name="22m" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22n) Mi equipo de trabajo se siente seguro realizando sus actividades.</td>
                                        <td><input type="radio" name="22n" id="" value="4" required></td>
                                        <td><input type="radio" name="22n" id="" value="3" required></td>
                                        <td><input type="radio" name="22n" id="" value="2" required></td>
                                        <td><input type="radio" name="22n" id="" value="1" required></td>
                                        <td><input type="radio" name="22n" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22o) En los últimos doce meses, mi equipo de trabajo no ha tenido accidentes desempeñando sus actividades laborales.</td>
                                        <td><input type="radio" name="22o" id="" value="4" required></td>
                                        <td><input type="radio" name="22o" id="" value="3" required></td>
                                        <td><input type="radio" name="22o" id="" value="2" required></td>
                                        <td><input type="radio" name="22o" id="" value="1" required></td>
                                        <td><input type="radio" name="22o" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22p) En mi negocio se toman en cuenta las opiniones de mi equipo de trabajo.</td>
                                        <td><input type="radio" name="22p" id="" value="4" required></td>
                                        <td><input type="radio" name="22p" id="" value="3" required></td>
                                        <td><input type="radio" name="22p" id="" value="2" required></td>
                                        <td><input type="radio" name="22p" id="" value="1" required></td>
                                        <td><input type="radio" name="22p" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22q) Permito el diálogo abierto con mi equipo de trabajo.</td>
                                        <td><input type="radio" name="22q" id="" value="4" required></td>
                                        <td><input type="radio" name="22q" id="" value="3" required></td>
                                        <td><input type="radio" name="22q" id="" value="2" required></td>
                                        <td><input type="radio" name="22q" id="" value="1" required></td>
                                        <td><input type="radio" name="22q" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td colspan="6" class="table-warning text-left">23) X1 = Negociación (desde el punto de vista personal)</td>
                                    </tr>
                                    <tr>
                                        <td>23a) Me reconocen por mi habilidad para llegar a acuerdos satisfactorios para todos.</td>
                                        <td><input type="radio" name="23a" id="" value="4" required></td>
                                        <td><input type="radio" name="23a" id="" value="3" required></td>
                                        <td><input type="radio" name="23a" id="" value="2" required></td>
                                        <td><input type="radio" name="23a" id="" value="1" required></td>
                                        <td><input type="radio" name="23a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23b) Es mejor un mal arreglo para ambas partes que un buen pleito.</td>
                                        <td><input type="radio" name="23b" id="" value="4" required></td>
                                        <td><input type="radio" name="23b" id="" value="3" required></td>
                                        <td><input type="radio" name="23b" id="" value="2" required></td>
                                        <td><input type="radio" name="23b" id="" value="1" required></td>
                                        <td><input type="radio" name="23b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23c) En una negociación me centro en el problema y no en la persona.</td>
                                        <td><input type="radio" name="23c" id="" value="4" required></td>
                                        <td><input type="radio" name="23c" id="" value="3" required></td>
                                        <td><input type="radio" name="23c" id="" value="2" required></td>
                                        <td><input type="radio" name="23c" id="" value="1" required></td>
                                        <td><input type="radio" name="23c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23d) La sorpresa es una táctica importante en la negociación.</td>
                                        <td><input type="radio" name="23d" id="" value="4" required></td>
                                        <td><input type="radio" name="23d" id="" value="3" required></td>
                                        <td><input type="radio" name="23d" id="" value="2" required></td>
                                        <td><input type="radio" name="23d" id="" value="1" required></td>
                                        <td><input type="radio" name="23d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23e) El resultado de la negociación mejora las relaciones.</td>
                                        <td><input type="radio" name="23e" id="" value="4" required></td>
                                        <td><input type="radio" name="23e" id="" value="3" required></td>
                                        <td><input type="radio" name="23e" id="" value="2" required></td>
                                        <td><input type="radio" name="23e" id="" value="1" required></td>
                                        <td><input type="radio" name="23e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23f) Me llaman para colaborar en acuerdos de negociación.</td>
                                        <td><input type="radio" name="23f" id="" value="4" required></td>
                                        <td><input type="radio" name="23f" id="" value="3" required></td>
                                        <td><input type="radio" name="23f" id="" value="2" required></td>
                                        <td><input type="radio" name="23f" id="" value="1" required></td>
                                        <td><input type="radio" name="23f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23g) En una negociación prefiero que ambas partes ganemos.</td>
                                        <td><input type="radio" name="23g" id="" value="4" required></td>
                                        <td><input type="radio" name="23g" id="" value="3" required></td>
                                        <td><input type="radio" name="23g" id="" value="2" required></td>
                                        <td><input type="radio" name="23g" id="" value="1" required></td>
                                        <td><input type="radio" name="23g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23h) No continúo una mala negociación, prefiero terminarla.</td>
                                        <td><input type="radio" name="23h" id="" value="4" required></td>
                                        <td><input type="radio" name="23h" id="" value="3" required></td>
                                        <td><input type="radio" name="23h" id="" value="2" required></td>
                                        <td><input type="radio" name="23h" id="" value="1" required></td>
                                        <td><input type="radio" name="23h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23i) Cuando se rompe una negociación dejo una opción abierta para el futuro.</td>
                                        <td><input type="radio" name="23i" id="" value="4" required></td>
                                        <td><input type="radio" name="23i" id="" value="3" required></td>
                                        <td><input type="radio" name="23i" id="" value="2" required></td>
                                        <td><input type="radio" name="23i" id="" value="1" required></td>
                                        <td><input type="radio" name="23i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23j) En la negociación se debe dar la menor información posible.</td>
                                        <td><input type="radio" name="23j" id="" value="4" required></td>
                                        <td><input type="radio" name="23j" id="" value="3" required></td>
                                        <td><input type="radio" name="23j" id="" value="2" required></td>
                                        <td><input type="radio" name="23j" id="" value="1" required></td>
                                        <td><input type="radio" name="23j" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">24) X2 = Toma de decisiones (desde el punto de vista personal)</td>
                                    </tr>
                                    <tr>
                                        <td>24a) Llevo una metodología al definir el problema y generar alternativas, antes de proponer la selección de alguna de ellas.</td>
                                        <td><input type="radio" name="24a" id="" value="4" required></td>
                                        <td><input type="radio" name="24a" id="" value="3" required></td>
                                        <td><input type="radio" name="24a" id="" value="2" required></td>
                                        <td><input type="radio" name="24a" id="" value="1" required></td>
                                        <td><input type="radio" name="24a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24b) Defino claramente cuál es el problema y evito tratar de resolverlo precipitadamente.</td>
                                        <td><input type="radio" name="24b" id="" value="4" required></td>
                                        <td><input type="radio" name="24b" id="" value="3" required></td>
                                        <td><input type="radio" name="24b" id="" value="2" required></td>
                                        <td><input type="radio" name="24b" id="" value="1" required></td>
                                        <td><input type="radio" name="24b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24c) Reúno mucha información antes de tomar una decisión.</td>
                                        <td><input type="radio" name="24c" id="" value="4" required></td>
                                        <td><input type="radio" name="24c" id="" value="3" required></td>
                                        <td><input type="radio" name="24c" id="" value="2" required></td>
                                        <td><input type="radio" name="24c" id="" value="1" required></td>
                                        <td><input type="radio" name="24c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24d) Trato de obtener información de individuos que serán afectados por la decisión, para determinar sus preferencias y expectativas.</td>
                                        <td><input type="radio" name="24d" id="" value="4" required></td>
                                        <td><input type="radio" name="24d" id="" value="3" required></td>
                                        <td><input type="radio" name="24d" id="" value="2" required></td>
                                        <td><input type="radio" name="24d" id="" value="1" required></td>
                                        <td><input type="radio" name="24d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24e) Prefiero que las decisiones sean tomadas por consenso.</td>
                                        <td><input type="radio" name="24e" id="" value="4" required></td>
                                        <td><input type="radio" name="24e" id="" value="3" required></td>
                                        <td><input type="radio" name="24e" id="" value="2" required></td>
                                        <td><input type="radio" name="24e" id="" value="1" required></td>
                                        <td><input type="radio" name="24e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24f) Siempre genero más de una alternativa para la solución del problema en lugar de identificar únicamente una solución obvia.</td>
                                        <td><input type="radio" name="24f" id="" value="4" required></td>
                                        <td><input type="radio" name="24f" id="" value="3" required></td>
                                        <td><input type="radio" name="24f" id="" value="2" required></td>
                                        <td><input type="radio" name="24f" id="" value="1" required></td>
                                        <td><input type="radio" name="24f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24g) Divido el problema en pequeños componentes y analizo cada uno de ellos.</td>
                                        <td><input type="radio" name="24g" id="" value="4" required></td>
                                        <td><input type="radio" name="24g" id="" value="3" required></td>
                                        <td><input type="radio" name="24g" id="" value="2" required></td>
                                        <td><input type="radio" name="24g" id="" value="1" required></td>
                                        <td><input type="radio" name="24g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24h) Hago muchas preguntas sobre la naturaleza de la decisión, antes de considerar maneras de tomarla.</td>
                                        <td><input type="radio" name="24h" id="" value="4" required></td>
                                        <td><input type="radio" name="24h" id="" value="3" required></td>
                                        <td><input type="radio" name="24h" id="" value="2" required></td>
                                        <td><input type="radio" name="24h" id="" value="1" required></td>
                                        <td><input type="radio" name="24h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24i) Tengo en mente consecuencias a corto y largo plazo cuando evalúo varias soluciones alternativas.</td>
                                        <td><input type="radio" name="24i" id="" value="4" required></td>
                                        <td><input type="radio" name="24i" id="" value="3" required></td>
                                        <td><input type="radio" name="24i" id="" value="2" required></td>
                                        <td><input type="radio" name="24i" id="" value="1" required></td>
                                        <td><input type="radio" name="24i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24j) Me asesoro con personas externas para que me auxilien en la toma de decisiones.</td>
                                        <td><input type="radio" name="24j" id="" value="4" required></td>
                                        <td><input type="radio" name="24j" id="" value="3" required></td>
                                        <td><input type="radio" name="24j" id="" value="2" required></td>
                                        <td><input type="radio" name="24j" id="" value="1" required></td>
                                        <td><input type="radio" name="24j" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">25) X3 = Liderazgo (desde el punto de vista personal)</td>
                                    </tr>
                                    <tr>
                                        <td>25a) Habitualmente, las personas de mi entorno suelen aceptar y seguir mis ideas y opiniones.</td>
                                        <td><input type="radio" name="25a" id="" value="4" required></td>
                                        <td><input type="radio" name="25a" id="" value="3" required></td>
                                        <td><input type="radio" name="25a" id="" value="2" required></td>
                                        <td><input type="radio" name="25a" id="" value="1" required></td>
                                        <td><input type="radio" name="25a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25b) Me considero una persona de principios sólidos y me comporto en coherencia con mis valores y creencias.</td>
                                        <td><input type="radio" name="25b" id="" value="4" required></td>
                                        <td><input type="radio" name="25b" id="" value="3" required></td>
                                        <td><input type="radio" name="25b" id="" value="2" required></td>
                                        <td><input type="radio" name="25b" id="" value="1" required></td>
                                        <td><input type="radio" name="25b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25c) Me gusta escuchar a mi equipo de trabajo para apoyarles en aquello que sea necesario.</td>
                                        <td><input type="radio" name="25c" id="" value="4" required></td>
                                        <td><input type="radio" name="25c" id="" value="3" required></td>
                                        <td><input type="radio" name="25c" id="" value="2" required></td>
                                        <td><input type="radio" name="25c" id="" value="1" required></td>
                                        <td><input type="radio" name="25c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25d) Me considero una persona abierta, flexible y generosa.</td>
                                        <td><input type="radio" name="25d" id="" value="4" required></td>
                                        <td><input type="radio" name="25d" id="" value="3" required></td>
                                        <td><input type="radio" name="25d" id="" value="2" required></td>
                                        <td><input type="radio" name="25d" id="" value="1" required></td>
                                        <td><input type="radio" name="25d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25e) Tengo interés por evolucionar profesionalmente e intento actualizar mis conocimientos.</td>
                                        <td><input type="radio" name="25e" id="" value="4" required></td>
                                        <td><input type="radio" name="25e" id="" value="3" required></td>
                                        <td><input type="radio" name="25e" id="" value="2" required></td>
                                        <td><input type="radio" name="25e" id="" value="1" required></td>
                                        <td><input type="radio" name="25e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25f) Soy una persona creativa y me intereso por las novedades que surgen.</td>
                                        <td><input type="radio" name="25f" id="" value="4" required></td>
                                        <td><input type="radio" name="25f" id="" value="3" required></td>
                                        <td><input type="radio" name="25f" id="" value="2" required></td>
                                        <td><input type="radio" name="25f" id="" value="1" required></td>
                                        <td><input type="radio" name="25f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25g) Disfruto motivando a quienes me rodean y transmitiendo mis ganas de hacer, les expreso mi ilusión e interés por las cosas importantes.</td>
                                        <td><input type="radio" name="25g" id="" value="4" required></td>
                                        <td><input type="radio" name="25g" id="" value="3" required></td>
                                        <td><input type="radio" name="25g" id="" value="2" required></td>
                                        <td><input type="radio" name="25g" id="" value="1" required></td>
                                        <td><input type="radio" name="25g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25h) Defiendo mis ideas, cuando estoy convencido de ellas, sin esperar la aprobación de otras personas.</td>
                                        <td><input type="radio" name="25h" id="" value="4" required></td>
                                        <td><input type="radio" name="25h" id="" value="3" required></td>
                                        <td><input type="radio" name="25h" id="" value="2" required></td>
                                        <td><input type="radio" name="25h" id="" value="1" required></td>
                                        <td><input type="radio" name="25h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25i) Cuando tomo decisiones, pienso y reflexiono sobre los hechos y sus consecuencias. No me gusta actuar de manera improvisada.</td>
                                        <td><input type="radio" name="25i" id="" value="4" required></td>
                                        <td><input type="radio" name="25i" id="" value="3" required></td>
                                        <td><input type="radio" name="25i" id="" value="2" required></td>
                                        <td><input type="radio" name="25i" id="" value="1" required></td>
                                        <td><input type="radio" name="25i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25j) Conozco en profundidad a mi equipo de trabajo, sus puntos fuertes y sus puntos débiles, sus virtudes y sus defectos. Me interesa conocer a las personas con las que me relaciono y con las que colaboro.</td>
                                        <td><input type="radio" name="25j" id="" value="4" required></td>
                                        <td><input type="radio" name="25j" id="" value="3" required></td>
                                        <td><input type="radio" name="25j" id="" value="2" required></td>
                                        <td><input type="radio" name="25j" id="" value="1" required></td>
                                        <td><input type="radio" name="25j" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">26) X4 = Comunicación (desde el punto de vista personal)</td>
                                    </tr>

                                    <tr>
                                        <td>26a) Tengo la capacidad de escuchar, hacer preguntas, expresar conceptos e ideas en forma efectiva.</td>
                                        <td><input type="radio" name="26a" id="" value="4" required></td>
                                        <td><input type="radio" name="26a" id="" value="3" required></td>
                                        <td><input type="radio" name="26a" id="" value="2" required></td>
                                        <td><input type="radio" name="26a" id="" value="1" required></td>
                                        <td><input type="radio" name="26a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26b) Soy congruente al expresar mis necesidades personales.</td>
                                        <td><input type="radio" name="26b" id="" value="4" required></td>
                                        <td><input type="radio" name="26b" id="" value="3" required></td>
                                        <td><input type="radio" name="26b" id="" value="2" required></td>
                                        <td><input type="radio" name="26b" id="" value="1" required></td>
                                        <td><input type="radio" name="26b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26c) Escucho sin prejuzgar, siendo objetivo.</td>
                                        <td><input type="radio" name="26c" id="" value="4" required></td>
                                        <td><input type="radio" name="26c" id="" value="3" required></td>
                                        <td><input type="radio" name="26c" id="" value="2" required></td>
                                        <td><input type="radio" name="26c" id="" value="1" required></td>
                                        <td><input type="radio" name="26c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26d) Muestro completa honestidad en la retroalimentación que le doy a otros, aun cuando es negativa.</td>
                                        <td><input type="radio" name="26d" id="" value="4" required></td>
                                        <td><input type="radio" name="26d" id="" value="3" required></td>
                                        <td><input type="radio" name="26d" id="" value="2" required></td>
                                        <td><input type="radio" name="26d" id="" value="1" required></td>
                                        <td><input type="radio" name="26d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26e) Cuando doy retroalimentación, evito referirme a características personales y me enfoco en la solución.</td>
                                        <td><input type="radio" name="26e" id="" value="4" required></td>
                                        <td><input type="radio" name="26e" id="" value="3" required></td>
                                        <td><input type="radio" name="26e" id="" value="2" required></td>
                                        <td><input type="radio" name="26e" id="" value="1" required></td>
                                        <td><input type="radio" name="26e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26f) Siempre sugiero alternativas específicas a los individuos motivándolos para compartir ideas.</td>
                                        <td><input type="radio" name="26f" id="" value="4" required></td>
                                        <td><input type="radio" name="26f" id="" value="3" required></td>
                                        <td><input type="radio" name="26f" id="" value="2" required></td>
                                        <td><input type="radio" name="26f" id="" value="1" required></td>
                                        <td><input type="radio" name="26f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26g) Adquiero propiedad sobre mis enunciados, usando palabras personales tales como “yo pienso” en lugar de impersonales como “ellos piensan” o “ellas piensan”.</td>
                                        <td><input type="radio" name="26g" id="" value="4" required></td>
                                        <td><input type="radio" name="26g" id="" value="3" required></td>
                                        <td><input type="radio" name="26g" id="" value="2" required></td>
                                        <td><input type="radio" name="26g" id="" value="1" required></td>
                                        <td><input type="radio" name="26g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26h) Demuestro interés genuino en el punto de vista de otras personas, aun cuando estoy en desacuerdo con ellas.</td>
                                        <td><input type="radio" name="26h" id="" value="4" required></td>
                                        <td><input type="radio" name="26h" id="" value="3" required></td>
                                        <td><input type="radio" name="26h" id="" value="2" required></td>
                                        <td><input type="radio" name="26h" id="" value="1" required></td>
                                        <td><input type="radio" name="26h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26i) Comparto mis ideas y planes con mi equipo de trabajo.</td>
                                        <td><input type="radio" name="26i" id="" value="4" required></td>
                                        <td><input type="radio" name="26i" id="" value="3" required></td>
                                        <td><input type="radio" name="26i" id="" value="2" required></td>
                                        <td><input type="radio" name="26i" id="" value="1" required></td>
                                        <td><input type="radio" name="26i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26j) Respeto y no domino las conversaciones de otras personas.</td>
                                        <td><input type="radio" name="26j" id="" value="4" required></td>
                                        <td><input type="radio" name="26j" id="" value="3" required></td>
                                        <td><input type="radio" name="26j" id="" value="2" required></td>
                                        <td><input type="radio" name="26j" id="" value="1" required></td>
                                        <td><input type="radio" name="26j" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">27) X5 = Trabajo en equipo (desde el punto de vista personal)</td>
                                    </tr>

                                    <tr>
                                        <td>27a) Sé de varias maneras de facilitar el cumplimiento de la tarea en el equipo.</td>
                                        <td><input type="radio" name="27a" id="" value="4" required></td>
                                        <td><input type="radio" name="27a" id="" value="3" required></td>
                                        <td><input type="radio" name="27a" id="" value="2" required></td>
                                        <td><input type="radio" name="27a" id="" value="1" required></td>
                                        <td><input type="radio" name="27a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>27b) Sé de varias maneras de construir una buena relación y cohesión entre los miembros.</td>
                                        <td><input type="radio" name="27b" id="" value="4" required></td>
                                        <td><input type="radio" name="27b" id="" value="3" required></td>
                                        <td><input type="radio" name="27b" id="" value="2" required></td>
                                        <td><input type="radio" name="27b" id="" value="1" required></td>
                                        <td><input type="radio" name="27b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>27c) Sé cómo establecer credibilidad e influencia entre los miembros del equipo.</td>
                                        <td><input type="radio" name="27c" id="" value="4" required></td>
                                        <td><input type="radio" name="27c" id="" value="3" required></td>
                                        <td><input type="radio" name="27c" id="" value="2" required></td>
                                        <td><input type="radio" name="27c" id="" value="1" required></td>
                                        <td><input type="radio" name="27c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>27d) Ayudo a los miembros a comprometerse con sus objetivos.</td>
                                        <td><input type="radio" name="27d" id="" value="4" required></td>
                                        <td><input type="radio" name="27d" id="" value="3" required></td>
                                        <td><input type="radio" name="27d" id="" value="2" required></td>
                                        <td><input type="radio" name="27d" id="" value="1" required></td>
                                        <td><input type="radio" name="27d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>27e) Motivo que los miembros del equipo se comprometan al éxito de su equipo y a su éxito personal.</td>
                                        <td><input type="radio" name="27e" id="" value="4" required></td>
                                        <td><input type="radio" name="27e" id="" value="3" required></td>
                                        <td><input type="radio" name="27e" id="" value="2" required></td>
                                        <td><input type="radio" name="27e" id="" value="1" required></td>
                                        <td><input type="radio" name="27e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>27f) Comparto información con el equipo y propicio la participación.</td>
                                        <td><input type="radio" name="27f" id="" value="4" required></td>
                                        <td><input type="radio" name="27f" id="" value="3" required></td>
                                        <td><input type="radio" name="27f" id="" value="2" required></td>
                                        <td><input type="radio" name="27f" id="" value="1" required></td>
                                        <td><input type="radio" name="27f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>27g) Creo una energía positiva siendo optimista y motivando al equipo.</td>
                                        <td><input type="radio" name="27g" id="" value="4" required></td>
                                        <td><input type="radio" name="27g" id="" value="3" required></td>
                                        <td><input type="radio" name="27g" id="" value="2" required></td>
                                        <td><input type="radio" name="27g" id="" value="1" required></td>
                                        <td><input type="radio" name="27g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>27h) Llego a un acuerdo con el equipo antes de comenzar con la tarea propuesta.</td>
                                        <td><input type="radio" name="27h" id="" value="4" required></td>
                                        <td><input type="radio" name="27h" id="" value="3" required></td>
                                        <td><input type="radio" name="27h" id="" value="2" required></td>
                                        <td><input type="radio" name="27h" id="" value="1" required></td>
                                        <td><input type="radio" name="27h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>27i) Puedo diagnosticar y capitalizar en las competencias fundamentales de mi equipo y en sus fortalezas.</td>
                                        <td><input type="radio" name="27i" id="" value="4" required></td>
                                        <td><input type="radio" name="27i" id="" value="3" required></td>
                                        <td><input type="radio" name="27i" id="" value="2" required></td>
                                        <td><input type="radio" name="27i" id="" value="1" required></td>
                                        <td><input type="radio" name="27i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>27j) Los motivo a trabajar bajo criterios precisos para asegurar que los materiales, productos, procesos y servicios sean consistentes.</td>
                                        <td><input type="radio" name="27j" id="" value="4" required></td>
                                        <td><input type="radio" name="27j" id="" value="3" required></td>
                                        <td><input type="radio" name="27j" id="" value="2" required></td>
                                        <td><input type="radio" name="27j" id="" value="1" required></td>
                                        <td><input type="radio" name="27j" id="" value="nc" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Muy de acuerdo</th>
                                            <th>De acuerdo</th>
                                            <th>En desacuerdo</th>
                                            <th>Muy en desacuerdo</th>
                                            <th>No sé / No aplica</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-left">28) Y = Clima organizacional (desde el punto de vista laboral)</td>
                                    </tr>

                                    <tr>
                                        <td>28a) Ofrezco a mi equipo los materiales y el espacio que necesitan para hacer bien su trabajo.</td>
                                        <td><input type="radio" name="28a" id="" value="4" required></td>
                                        <td><input type="radio" name="28a" id="" value="3" required></td>
                                        <td><input type="radio" name="28a" id="" value="2" required></td>
                                        <td><input type="radio" name="28a" id="" value="1" required></td>
                                        <td><input type="radio" name="28a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>28b) Doy a mi equipo reconocimientos o elogios por trabajos bien realizados.</td>
                                        <td><input type="radio" name="28b" id="" value="4" required></td>
                                        <td><input type="radio" name="28b" id="" value="3" required></td>
                                        <td><input type="radio" name="28b" id="" value="2" required></td>
                                        <td><input type="radio" name="28b" id="" value="1" required></td>
                                        <td><input type="radio" name="28b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>28c) Muestro interés en el aspecto personal por mi equipo de trabajo.</td>
                                        <td><input type="radio" name="28c" id="" value="4" required></td>
                                        <td><input type="radio" name="28c" id="" value="3" required></td>
                                        <td><input type="radio" name="28c" id="" value="2" required></td>
                                        <td><input type="radio" name="28c" id="" value="1" required></td>
                                        <td><input type="radio" name="28c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>28d) Estimulo el desarrollo personal y profesional de mi equipo de trabajo.</td>
                                        <td><input type="radio" name="28d" id="" value="4" required></td>
                                        <td><input type="radio" name="28d" id="" value="3" required></td>
                                        <td><input type="radio" name="28d" id="" value="2" required></td>
                                        <td><input type="radio" name="28d" id="" value="1" required></td>
                                        <td><input type="radio" name="28d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>28e) Considero las opiniones de mi equipo de trabajo para la toma de decisiones.</td>
                                        <td><input type="radio" name="28e" id="" value="4" required></td>
                                        <td><input type="radio" name="28e" id="" value="3" required></td>
                                        <td><input type="radio" name="28e" id="" value="2" required></td>
                                        <td><input type="radio" name="28e" id="" value="1" required></td>
                                        <td><input type="radio" name="28e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>28f) Considero que mi equipo está dedicado y comprometido con hacer un trabajo de calidad.</td>
                                        <td><input type="radio" name="28f" id="" value="4" required></td>
                                        <td><input type="radio" name="28f" id="" value="3" required></td>
                                        <td><input type="radio" name="28f" id="" value="2" required></td>
                                        <td><input type="radio" name="28f" id="" value="1" required></td>
                                        <td><input type="radio" name="28f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>28g) En este último año he dado la oportunidad de que mi equipo aprenda y crezca personal y profesionalmente en el trabajo.</td>
                                        <td><input type="radio" name="28g" id="" value="4" required></td>
                                        <td><input type="radio" name="28g" id="" value="3" required></td>
                                        <td><input type="radio" name="28g" id="" value="2" required></td>
                                        <td><input type="radio" name="28g" id="" value="1" required></td>
                                        <td><input type="radio" name="28g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>28h) Otorgo a mi equipo de trabajo compensaciones por el logro de metas y objetivos.</td>
                                        <td><input type="radio" name="28h" id="" value="4" required></td>
                                        <td><input type="radio" name="28h" id="" value="3" required></td>
                                        <td><input type="radio" name="28h" id="" value="2" required></td>
                                        <td><input type="radio" name="28h" id="" value="1" required></td>
                                        <td><input type="radio" name="28h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>28i) Brindo a mi equipo de trabajo facilidades como flexibilidad horaria para equilibrio entre su vida personal y laboral.</td>
                                        <td><input type="radio" name="28i" id="" value="4" required></td>
                                        <td><input type="radio" name="28i" id="" value="3" required></td>
                                        <td><input type="radio" name="28i" id="" value="2" required></td>
                                        <td><input type="radio" name="28i" id="" value="1" required></td>
                                        <td><input type="radio" name="28i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>28j) Ofrezco a mi equipo un sueldo o salario justo de acuerdo al perfil y actividades de trabajo que realizan.</td>
                                        <td><input type="radio" name="28j" id="" value="4" required></td>
                                        <td><input type="radio" name="28j" id="" value="3" required></td>
                                        <td><input type="radio" name="28j" id="" value="2" required></td>
                                        <td><input type="radio" name="28j" id="" value="1" required></td>
                                        <td><input type="radio" name="28j" id="" value="nc" required></td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6 class="text-center text-success">Gracias por el tiempo y la información que ha proporcionado para este trabajo con fines académicos y estadísticos.</h6>

                            <input type="text" name="red" id="" value="<?= $red['nombre_red'] ?>" hidden required>
                            <input type="text" name="anio" id="" value="<?= date('Y') ?>" hidden required>
                            <input type="text" name="claveCuerpo" id="" value="<?= $claveCuerpo ?>" hidden required>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                            <button type="submit" class="btn btn-warning btn-block">Terminar</button>
                        </fieldset>


                    </form>
                </div>
            </div>
        </section>


    </div>
    <script>
        var base_url = '<?= base_url() ?>';
        let pais = '<?= $ca['pais'] ?>'
        let claveCuerpo = '<?= $claveCuerpo ?>'
        if(pais != 2){
            const editables = ['tel_fijo','tel_extension','tel_cel','tipo_conglomerado','nombre_conglomerado',
            'tipo_vialidad_1','nombre_vialidad_1','tipo_vialidad_2','nombre_vialidad_2','tipo_vialidad_posterior',
            'nombre_vialidad_posterior','nombre_ubicacion_empresa','piso_empresa','otro_piso','descripcion_mype',
            'estado_pais','clave_municipio','clave_estado','info_cp','otra_info_cp'];

            const selects = ['tipo_conglomerado','tipo_vialidad_1','tipo_vialidad_2','piso_empresa','info_cp','tipo_vialidad_posterior']

            Object.values(editables).forEach(e => {
                const parent = $('#'+e).parent()
                let html = '<input type="text" class="form-control" name="'+e+'" readonly value="No aplica para el país registrado.">'
                parent.append(html)
                $("#"+e).remove()
            })
            
        }
    </script>
    <script src="<?= base_url('resources/js/cuestionarios/Relayn/2023/index.js') ?>"></script>
    <script src="<?= base_url('resources/intl-tel-input/build/js/intlTelInput.js') ?>"></script>
</body>

</html>