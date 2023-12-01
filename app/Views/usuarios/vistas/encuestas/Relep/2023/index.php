<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resources/css/cuestionarios/Relep/2023/index.css") ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">
    <title>Encuesta RELEP 2023</title>
</head>

<body>

    <style>
        .next {
            background-color: <?= $red['color_secundario'] ?>;
            color: #fff;
        }

        section {
            max-width: none !important;
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            color: <?= $red['color_primario'] ?>;
        }

        input[type="radio"]:checked {
            -webkit-appearance: none;
            display: inline-block;
            width: 12px;
            height: 12px;
            padding: 0px;
            background-clip: content-box;
            border: 2px solid #bbbbbb;
            background-color: blue;
            border-radius: 50%;
        }
    </style>

    <div class="container">
        <section>
            <div class="row text-center">
                <div class="col-md-6 text-center">
                    <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" style="width:90%">
                </div>
                <div class="col-md-6 text-center">
                    <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Relep.png"); ?>" style="width: 90%; height: 82%;">
                </div>
            </div>
            <h1 class="text-center">Investigación RELEP 2023</h1>
            <h3 class="text-center">
                “Rendimiento académico: Rendimiento académico: relación del aprovechamiento y compromiso de los estudiantes universitarios.”
            </h3>
            <hr>
            <h1 class="text-center">Encuesta para el grupo</h1>
            <h1 class="text-center"><?= $claveCuerpo ?></h1>
        </section>

        <form id="msform" method="post" action="" class="needs-validation" novalidate data-toggle="validator">

            <section>
                <div class="row justify-content-center justify-content-md-start">
                    <div class="col align-self-center">

                        <ul id="progressbar" class="text-center">
                            <li class="active" id="general"></li>
                            <li id="fase1"></li>
                            <li id="fase2"></li>
                            <li id="fase3"></li>
                            <li id="fase4"></li>
                            <li id="fase5"></li>
                        </ul>

                        <fieldset id="field0">
                            <h1 class="text-center">Objetivo</h1>
                            <p class="text-center">
                                Analizar el aprovechamiento y el compromiso de los estudiantes
                                universitarios latinoamericanos con su rendimiento académico.
                                Para efectos del estudio, tu hogar es el lugar en donde creciste
                                y donde viven las personas que son responsables de tu educación;
                                en caso de que tengas una familia nuclear formada por ti,
                                tu hogar sería éste. En todos los casos que se te pida que
                                cuentes a las personas de tu hogar, debes contarte tú cuando
                                aplique. Por favor contesta todas las preguntas.
                            </p>
                            <h1 class="text-center">Instrucciones</h1>
                            <p class="text-center">
                                Si alguna pregunta no se puede contestar seleccione la opción “No sé / No aplica”. Es importante leer con especial atención
                                a las palabras que están en <b>negritas</b>.
                            </p>
                            <h1 class="text-center">Aviso de privacidad</h1>
                            <h6 class="text-center">
                                Sus respuestas son absolutamente confidenciales, al contestar la encuesta autoriza que sus respuestas sean usadas de <u>MANERA ANÓNIMA</u>,
                                única y exclusivamente con fines académicos, ¿está de acuerdo?
                            </h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="checkAviso" checked disabled>
                                <label class="form-check-label" for="checkAviso">
                                    Sí, estoy de acuerdo.
                                </label>
                            </div>

                            <hr>
                            <h3>Por favor seleccione el medio por el cual se realizó la encuesta</h3>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="medio_captura" id="opcion1" value="personal" required>
                                <label class="form-check-label" for="opcion1">
                                    Mediante encuesta impresa a estudiantes universitarios.
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
                                    Soy estudiante universitario, me compartieron el enlace para responder.
                                </label>
                            </div>
                            <div class="invalid-feedback">
                                Complete este campo.
                            </div>

                            <hr>

                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />
                        </fieldset>

                        <fieldset id="field1">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">Datos del encuestador(a)</h2>
                            <br>
                            <p>
                                Por favor, preste cuidado en la captura de su nombre y correo electrónico, con estos datos se emitirá su constancia de encuestador (a)
                                La persona encuestadora DEBE REGISTRAR SU CORREO ELECTRÓNICO PERSONAL, no está permitido utilizar el correo electrónico de otra persona
                                encuestadora. Si captura erróneamente su nombre o correo electrónico ES IMPOSIBLE realizar cambios o modificaciones para la emisión de la constancia.
                            </p>
                            <hr>

                            <div>
                                <label for="">Nombre completo del encuestador (a)</label>
                                <input type="text" name="nombre_encuestador" id="nombre_encuestador" class="form-control" required autofocus>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">Correo electrónico del encuestador (a)</label>
                                <input type="text" name="correo_encuestador" id="correo_encuestador" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <br>
                            <h2 class="text-center">1ra PARTE: Datos generales del estudiante</h2>

                            <div>
                                <label for="">1) Edad</label>
                                <input type="text" min='0' name="1a" id="1a" class="form-control" required>
                                <p class="validacion_prev" id="inst_edad"></p>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">2) Sexo</label>
                                <input type="text" name="2a" id="2a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">3) Estado civil</label>
                                <input type="text" name="3a" id="3a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">4) ¿Tiene hijos?</label>
                                <input type="text" name="4a" id="4a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">5) Es originario de</label>
                                <input type="text" name="5a" id="5a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">6) Generalmente ¿Cómo se traslada a la escuela?</label>
                                <input type="text" name="6a" id="6a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">7) ¿Cuánto tiempo tarda en llegar a la escuela?</label>

                                <div class="input-group mb-3">
                                    <input type="text" name="7a" id="7a" class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Horas</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="">8) En promedio, ¿cuántas horas por día está en la escuela?</label>

                                <div class="input-group mb-3">
                                    <input type="text" name="8a" id="8a" class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Horas</span>
                                    </div>
                                </div>

                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">9) ¿Realiza comprometidamente alguna actividad extraescolar (no exigida por la escuela)?</label>
                                <input type="text" name="9a" id="9a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <hr>

                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value='Regresar' />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />

                        </fieldset>

                        <fieldset id="field2">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">2da parte: Datos familiares del estudiante</h2>
                            <hr>

                            <div>
                                <label for="">10) Incluyéndose, ¿cuántas personas hay en su hogar?</label>
                                <input type="text" min='0' name="10a" id="0a" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">11) Incluyéndose, ¿cuántos miembros de su hogar empezaron a estudiar una carrera en una universidad?</label>
                                <input type="text" min='0' name="11a" id="11a" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">12) Incluyéndose, ¿cuántos miembros de su hogar han terminado una carrera en una universidad?</label>
                                <input type="text" min='0' name="12a" id="12a" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">13) Entre semana vive con:</label>
                                <input type="text" name="13a" id="13a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>
                            <br>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value='Regresar' />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />

                        </fieldset>

                        <fieldset id="field3">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">3ra parte: Perfil del estudiante</h2>
                            <hr>

                            <div>
                                <label for="">14) ¿En qué número de semestre/cuatrimestre/año se encuentra?</label>
                                <input type="text" name="14a" id="14a" class="form-control" min='1' max='30' required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">14a) ¿Cuántos meses lleva estudiando esta carrera?</label>
                                <p class="instrucciones">No cuentes aquellos en los que dejaste de estudiar</p>
                                <input type="text" min='0' name="14b" id="14b" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">14b) ¿Hace cuántos meses terminó su último nivel de estudios?</label>
                                <p class="instrucciones">Si estas en pregrado y hace 4 años terminaste bachillerato, escribe 48</p>
                                <input type="text" min='0' name="14c" id="14c" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">14c) En una semana ¿Cuántas horas dedica a leer libros relacionados con su carrera?</label>
                                <input type="text" min='0' name="14d" id="14d" class="form-control" required>
                                <p class="validacion_prev" id="inst_14d"></p>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">14d) En una semana ¿Cuántas horas dedica a leer libros no relacionados con su carrera?</label>
                                <input type="text" min='0' name="14e" id="14e" class="form-control" required>
                                <p class="validacion_prev" id="inst_14e"></p>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">14e) En una semana ¿Cuántas horas dedica a conectarse a redes sociales o navegar por internet?</label>
                                <input type="text" min='0' name="14f" id="14f" class="form-control" required>
                                <p class="validacion_prev" id="inst_14f"></p>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">14f) ¿Cuál es su calificación promedio del período anterior?</label>
                                <p class="instrucciones">(Por favor escríbelo en escala del 1 al 10 con un decimal. Ejemplo 8.3)</p>
                                <input type="text" min='0' name="14g" id="14g" class="form-control" required min='0' max='10'>
                                <p class="validacion_prev" id="inst_14g"></p>
                                <div class="invalid-feedback">
                                    Complete este campo. Debe ser un valor entre 0 y 10
                                </div>
                            </div>

                            <div>
                                <label for="">14g) ¿A qué área pertenece la carrera que estudia?</label>
                                <input type="text" name="14h" id="14h" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">14h) ¿En qué tipo de institución cursó su último nivel de estudios terminado?</label>
                                <input type="text" name="14i" id="14i" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <br>

                            <h2>Datos de la institución del estudiante</h2>
                            <hr>


                            <div>
                                <label for="">15) País (Información obtenida de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>).</label>
                                <input type="text" name="15b" id="15b" class="form-control" required readonly>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15a) Estado (Información obtenida de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>).</label>
                                <input type="text" name="15c" id="15c" class="form-control" required readonly>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15b) Municipio de estudio (Información obtenida de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>).</label>
                                <input type="text" name="15a" id="15a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15c) Nombre de la facultad a encuestar (Información obtenida de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>.)</label>
                                <input type="text" name="15d" id="15d" class="form-control" required readonly>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15d) Enlace de <a href="https://www.google.com/maps" target="_blank">Google Maps</a> con la ubicación de la institución</label>
                                <a id="dudas"><i class="fas fa-question-circle text-warning"></i></a>
                                <input type="text" name="coordenadas" pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$" placeholder="Ejemplo: https://www.google.com/maps/place/Universidad+Nacional+Autónoma+de+México/@19.3365296,-99.1908135,17z/data=!4m14!1m7!3m6!1s0x85d1ffffe05f5ca1:0x8eeffb0ec378f2da!2sUniversidad+Nacional+Autónoma+de+México!8m2!3d19.3365296!4d-99.1886248!16zL20vMDEyZ3lm!3m5!1s0x85d1ffffe05f5ca1:0x8eeffb0ec378f2da!8m2!3d19.3365296!4d-99.1886248!16zL20vMDEyZ3lm" id="coordenadas" class='form-control' required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15e) Carrera</label>
                                <input type="text" name="15e" id="15e" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15f) Facebook de la institución</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: https://www.facebook.com/Relep.redesla.la</p>
                                <input type="text" class="form-control" name="15f" id="15f" required pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15g) Twitter de la institución</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: @UserName1</p>
                                <input type="text" class="form-control" name="15i" id="15i" required pattern="(?<=^|(?<=[^a-zA-Z0-9-_\.]))@([A-Za-z]+[A-Za-z0-9-_]+)">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15h) Correo electrónico de la institución</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: relep@redesla.la</p>
                                <input type="text" class="form-control" name="15g" id="15g" required pattern="[^@\s]+@[^@\s]+">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15i) Página de internet de la institución</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: https://redesla.la/redesla/</p>
                                <input type="text" class="form-control" name="15h" id="15h" required pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>



                            <br>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value='Regresar' />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />

                        </fieldset>

                        <fieldset id="field4">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">4ta Parte: Rendimiento académico</h2>
                            <hr>
                            <label for="">En la siguiente sección seleccione qué tan de acuerdo está con las frases que se mencionan. </label>
                            <label for="">En caso de que no aplique la pregunta o no conozca la respuesta seleccione <b>No sé / No aplica</b></label>
                            <table class="table table-striped table-responsive">
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
                                        <td colspan="6" class="table-warning text-center">16) Satisfacción.</td>
                                    </tr>
                                    <tr>
                                        <td>16a) Sus profesores(as) demuestran dominio de la materia que imparten.</td>
                                        <td><input type="radio" name="16a" id="" value="4" required></td>
                                        <td><input type="radio" name="16a" id="" value="3" required></td>
                                        <td><input type="radio" name="16a" id="" value="2" required></td>
                                        <td><input type="radio" name="16a" id="" value="1" required></td>
                                        <td><input type="radio" name="16a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16b) Sus profesores señalan desde el inicio del curso los temas a tratar en la materia.</td>
                                        <td><input type="radio" name="16b" id="" value="4" required></td>
                                        <td><input type="radio" name="16b" id="" value="3" required></td>
                                        <td><input type="radio" name="16b" id="" value="2" required></td>
                                        <td><input type="radio" name="16b" id="" value="1" required></td>
                                        <td><input type="radio" name="16b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16c) Sus profesores desde el inicio del curso le informan sobre los criterios de evaluación.</td>
                                        <td><input type="radio" name="16c" id="" value="4" required></td>
                                        <td><input type="radio" name="16c" id="" value="3" required></td>
                                        <td><input type="radio" name="16c" id="" value="2" required></td>
                                        <td><input type="radio" name="16c" id="" value="1" required></td>
                                        <td><input type="radio" name="16c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16d) Sus profesores demuestran compromiso en su formación como futuro profesionista.</td>
                                        <td><input type="radio" name="16d" id="" value="4" required></td>
                                        <td><input type="radio" name="16d" id="" value="3" required></td>
                                        <td><input type="radio" name="16d" id="" value="2" required></td>
                                        <td><input type="radio" name="16d" id="" value="1" required></td>
                                        <td><input type="radio" name="16d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16e) Sus profesores asisten normalmente a clase.</td>
                                        <td><input type="radio" name="16e" id="" value="4" required></td>
                                        <td><input type="radio" name="16e" id="" value="3" required></td>
                                        <td><input type="radio" name="16e" id="" value="2" required></td>
                                        <td><input type="radio" name="16e" id="" value="1" required></td>
                                        <td><input type="radio" name="16e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16f) Sus profesores están actualizados en el uso de las tecnologías de la información y comunicación.</td>
                                        <td><input type="radio" name="16f" id="" value="4" required></td>
                                        <td><input type="radio" name="16f" id="" value="3" required></td>
                                        <td><input type="radio" name="16f" id="" value="2" required></td>
                                        <td><input type="radio" name="16f" id="" value="1" required></td>
                                        <td><input type="radio" name="16f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16g) Sus profesores cuando detectan falta de conocimientos relacionados con algún tema, se detienen y ofrecen una breve regularización.</td>
                                        <td><input type="radio" name="16g" id="" value="4" required></td>
                                        <td><input type="radio" name="16g" id="" value="3" required></td>
                                        <td><input type="radio" name="16g" id="" value="2" required></td>
                                        <td><input type="radio" name="16g" id="" value="1" required></td>
                                        <td><input type="radio" name="16g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16h) El personal directivo de la institución se preocupa por el bienestar del alumnado.</td>
                                        <td><input type="radio" name="16h" id="" value="4" required></td>
                                        <td><input type="radio" name="16h" id="" value="3" required></td>
                                        <td><input type="radio" name="16h" id="" value="2" required></td>
                                        <td><input type="radio" name="16h" id="" value="1" required></td>
                                        <td><input type="radio" name="16h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16i) El personal directivo de la institución tiene un trato amable con el alumnado.</td>
                                        <td><input type="radio" name="16i" id="" value="4" required></td>
                                        <td><input type="radio" name="16i" id="" value="3" required></td>
                                        <td><input type="radio" name="16i" id="" value="2" required></td>
                                        <td><input type="radio" name="16i" id="" value="1" required></td>
                                        <td><input type="radio" name="16i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16j) El personal directivo siempre muestra disponibilidad para atender las necesidades del alumnado.</td>
                                        <td><input type="radio" name="16j" id="" value="4" required></td>
                                        <td><input type="radio" name="16j" id="" value="3" required></td>
                                        <td><input type="radio" name="16j" id="" value="2" required></td>
                                        <td><input type="radio" name="16j" id="" value="1" required></td>
                                        <td><input type="radio" name="16j" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16k) El personal directivo se muestra atento del rendimiento académico del alumnado.</td>
                                        <td><input type="radio" name="16k" id="" value="4" required></td>
                                        <td><input type="radio" name="16k" id="" value="3" required></td>
                                        <td><input type="radio" name="16k" id="" value="2" required></td>
                                        <td><input type="radio" name="16k" id="" value="1" required></td>
                                        <td><input type="radio" name="16k" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16l) La biblioteca ofrece recursos bibliográficos que permiten cumplir con sus actividades académicas.</td>
                                        <td><input type="radio" name="16l" id="" value="4" required></td>
                                        <td><input type="radio" name="16l" id="" value="3" required></td>
                                        <td><input type="radio" name="16l" id="" value="2" required></td>
                                        <td><input type="radio" name="16l" id="" value="1" required></td>
                                        <td><input type="radio" name="16l" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16m) En la cafetería de la institución se encuentra comida balanceada y a un precio accesible.</td>
                                        <td><input type="radio" name="16m" id="" value="4" required></td>
                                        <td><input type="radio" name="16m" id="" value="3" required></td>
                                        <td><input type="radio" name="16m" id="" value="2" required></td>
                                        <td><input type="radio" name="16m" id="" value="1" required></td>
                                        <td><input type="radio" name="16m" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16n) Las aulas de clase son cómodas y adecuadas para concentrarse en sus estudios.</td>
                                        <td><input type="radio" name="16n" id="" value="4" required></td>
                                        <td><input type="radio" name="16n" id="" value="3" required></td>
                                        <td><input type="radio" name="16n" id="" value="2" required></td>
                                        <td><input type="radio" name="16n" id="" value="1" required></td>
                                        <td><input type="radio" name="16n" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16o) Las condiciones sanitarias de las instalaciones son adecuadas.</td>
                                        <td><input type="radio" name="16o" id="" value="4" required></td>
                                        <td><input type="radio" name="16o" id="" value="3" required></td>
                                        <td><input type="radio" name="16o" id="" value="2" required></td>
                                        <td><input type="radio" name="16o" id="" value="1" required></td>
                                        <td><input type="radio" name="16o" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16p) La institución cuenta con laboratorios y áreas de práctica adecuados y suficientes para aplicar lo aprendido en clase.</td>
                                        <td><input type="radio" name="16p" id="" value="4" required></td>
                                        <td><input type="radio" name="16p" id="" value="3" required></td>
                                        <td><input type="radio" name="16p" id="" value="2" required></td>
                                        <td><input type="radio" name="16p" id="" value="1" required></td>
                                        <td><input type="radio" name="16p" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16q) La institución cuenta con una organización adecuada para contextualizar los ambientes de aprendizaje relacionados con el campo laboral.</td>
                                        <td><input type="radio" name="16q" id="" value="4" required></td>
                                        <td><input type="radio" name="16q" id="" value="3" required></td>
                                        <td><input type="radio" name="16q" id="" value="2" required></td>
                                        <td><input type="radio" name="16q" id="" value="1" required></td>
                                        <td><input type="radio" name="16q" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16r) El diseño de las instalaciones de la institución le motivan para estudiar.</td>
                                        <td><input type="radio" name="16r" id="" value="4" required></td>
                                        <td><input type="radio" name="16r" id="" value="3" required></td>
                                        <td><input type="radio" name="16r" id="" value="2" required></td>
                                        <td><input type="radio" name="16r" id="" value="1" required></td>
                                        <td><input type="radio" name="16r" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16s) El personal administrativo se preocupa por darle una excelente atención.</td>
                                        <td><input type="radio" name="16s" id="" value="4" required></td>
                                        <td><input type="radio" name="16s" id="" value="3" required></td>
                                        <td><input type="radio" name="16s" id="" value="2" required></td>
                                        <td><input type="radio" name="16s" id="" value="1" required></td>
                                        <td><input type="radio" name="16s" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16t) El proceso de inscripción y reinscripción es rápido, sencillo y cómodo.</td>
                                        <td><input type="radio" name="16t" id="" value="4" required></td>
                                        <td><input type="radio" name="16t" id="" value="3" required></td>
                                        <td><input type="radio" name="16t" id="" value="2" required></td>
                                        <td><input type="radio" name="16t" id="" value="1" required></td>
                                        <td><input type="radio" name="16t" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16u) La programación de clases le permitirá completar sus estudios en un tiempo definido.</td>
                                        <td><input type="radio" name="16u" id="" value="4" required></td>
                                        <td><input type="radio" name="16u" id="" value="3" required></td>
                                        <td><input type="radio" name="16u" id="" value="2" required></td>
                                        <td><input type="radio" name="16u" id="" value="1" required></td>
                                        <td><input type="radio" name="16u" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>16v) La entrega de documentación (constancias de talleres y control escolar) se realiza en tiempo y forma cuando las requiere.</td>
                                        <td><input type="radio" name="16v" id="" value="4" required></td>
                                        <td><input type="radio" name="16v" id="" value="3" required></td>
                                        <td><input type="radio" name="16v" id="" value="2" required></td>
                                        <td><input type="radio" name="16v" id="" value="1" required></td>
                                        <td><input type="radio" name="16v" id="" value="nc" required></td>
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
                                        <td colspan="6" class="table-warning text-center">17) Compromiso.</td>
                                    </tr>
                                    <tr>
                                        <td>17a) Siempre tiene disponibilidad para ir a clases o estudiar.</td>
                                        <td><input type="radio" name="17a" id="" value="4" required></td>
                                        <td><input type="radio" name="17a" id="" value="3" required></td>
                                        <td><input type="radio" name="17a" id="" value="2" required></td>
                                        <td><input type="radio" name="17a" id="" value="1" required></td>
                                        <td><input type="radio" name="17a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17b) Siempre busca tener buenas calificaciones.</td>
                                        <td><input type="radio" name="17b" id="" value="4" required></td>
                                        <td><input type="radio" name="17b" id="" value="3" required></td>
                                        <td><input type="radio" name="17b" id="" value="2" required></td>
                                        <td><input type="radio" name="17b" id="" value="1" required></td>
                                        <td><input type="radio" name="17b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17c) Se encuentra satisfecho (a) con los contenidos de las materias.</td>
                                        <td><input type="radio" name="17c" id="" value="4" required></td>
                                        <td><input type="radio" name="17c" id="" value="3" required></td>
                                        <td><input type="radio" name="17c" id="" value="2" required></td>
                                        <td><input type="radio" name="17c" id="" value="1" required></td>
                                        <td><input type="radio" name="17c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17d) Las tareas como estudiante le hacen sentir siempre contento (a).</td>
                                        <td><input type="radio" name="17d" id="" value="4" required></td>
                                        <td><input type="radio" name="17d" id="" value="3" required></td>
                                        <td><input type="radio" name="17d" id="" value="2" required></td>
                                        <td><input type="radio" name="17d" id="" value="1" required></td>
                                        <td><input type="radio" name="17d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17e) Le inspira hablar a otras personas de su carrera.</td>
                                        <td><input type="radio" name="17e" id="" value="4" required></td>
                                        <td><input type="radio" name="17e" id="" value="3" required></td>
                                        <td><input type="radio" name="17e" id="" value="2" required></td>
                                        <td><input type="radio" name="17e" id="" value="1" required></td>
                                        <td><input type="radio" name="17e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17f) Asiste a las clases por satisfacción e interés por aprender.</td>
                                        <td><input type="radio" name="17f" id="" value="4" required></td>
                                        <td><input type="radio" name="17f" id="" value="3" required></td>
                                        <td><input type="radio" name="17f" id="" value="2" required></td>
                                        <td><input type="radio" name="17f" id="" value="1" required></td>
                                        <td><input type="radio" name="17f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17g) Se siente satisfecho (a) por la carrera que está estudiando.</td>
                                        <td><input type="radio" name="17g" id="" value="4" required></td>
                                        <td><input type="radio" name="17g" id="" value="3" required></td>
                                        <td><input type="radio" name="17g" id="" value="2" required></td>
                                        <td><input type="radio" name="17g" id="" value="1" required></td>
                                        <td><input type="radio" name="17g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17h) Considera que dedica tiempo suficiente para estudiar, repasar y hacer tarea.</td>
                                        <td><input type="radio" name="17h" id="" value="4" required></td>
                                        <td><input type="radio" name="17h" id="" value="3" required></td>
                                        <td><input type="radio" name="17h" id="" value="2" required></td>
                                        <td><input type="radio" name="17h" id="" value="1" required></td>
                                        <td><input type="radio" name="17h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17i) Administra lo mejor posible su tiempo para poder realizar las tareas que le encargan en clase.</td>
                                        <td><input type="radio" name="17i" id="" value="4" required></td>
                                        <td><input type="radio" name="17i" id="" value="3" required></td>
                                        <td><input type="radio" name="17i" id="" value="2" required></td>
                                        <td><input type="radio" name="17i" id="" value="1" required></td>
                                        <td><input type="radio" name="17i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17j) Considera que demuestra interés por las materias que está cursando.</td>
                                        <td><input type="radio" name="17j" id="" value="4" required></td>
                                        <td><input type="radio" name="17j" id="" value="3" required></td>
                                        <td><input type="radio" name="17j" id="" value="2" required></td>
                                        <td><input type="radio" name="17j" id="" value="1" required></td>
                                        <td><input type="radio" name="17j" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>17k) Cree que demuestra dedicación en las tareas y trabajos que dejan los profesores.</td>
                                        <td><input type="radio" name="17k" id="" value="4" required></td>
                                        <td><input type="radio" name="17k" id="" value="3" required></td>
                                        <td><input type="radio" name="17k" id="" value="2" required></td>
                                        <td><input type="radio" name="17k" id="" value="1" required></td>
                                        <td><input type="radio" name="17k" id="" value="nc" required></td>
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
                                        <td colspan="6" class="table-warning text-center">18) Rendimiento académico.</td>
                                    </tr>
                                    <tr>
                                        <td>18a) Cree que su desempeño académico hasta este momento ha sido el adecuado.</td>
                                        <td><input type="radio" name="18a" id="" value="4" required></td>
                                        <td><input type="radio" name="18a" id="" value="3" required></td>
                                        <td><input type="radio" name="18a" id="" value="2" required></td>
                                        <td><input type="radio" name="18a" id="" value="1" required></td>
                                        <td><input type="radio" name="18a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18b) Los exámenes que ha presentado son de acuerdo a los temas expuestos por el profesor.</td>
                                        <td><input type="radio" name="18b" id="" value="4" required></td>
                                        <td><input type="radio" name="18b" id="" value="3" required></td>
                                        <td><input type="radio" name="18b" id="" value="2" required></td>
                                        <td><input type="radio" name="18b" id="" value="1" required></td>
                                        <td><input type="radio" name="18b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18c) Si ha obtenido calificaciones bajas ha sido su responsabilidad.</td>
                                        <td><input type="radio" name="18c" id="" value="4" required></td>
                                        <td><input type="radio" name="18c" id="" value="3" required></td>
                                        <td><input type="radio" name="18c" id="" value="2" required></td>
                                        <td><input type="radio" name="18c" id="" value="1" required></td>
                                        <td><input type="radio" name="18c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18d) Las calificaciones que ha recibido hasta este momento, considera que han sido justas.</td>
                                        <td><input type="radio" name="18d" id="" value="4" required></td>
                                        <td><input type="radio" name="18d" id="" value="3" required></td>
                                        <td><input type="radio" name="18d" id="" value="2" required></td>
                                        <td><input type="radio" name="18d" id="" value="1" required></td>
                                        <td><input type="radio" name="18d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18e) Las materias que ha llevado durante el tiempo de estudio plantean la aplicación de lo aprendido.</td>
                                        <td><input type="radio" name="18e" id="" value="4" required></td>
                                        <td><input type="radio" name="18e" id="" value="3" required></td>
                                        <td><input type="radio" name="18e" id="" value="2" required></td>
                                        <td><input type="radio" name="18e" id="" value="1" required></td>
                                        <td><input type="radio" name="18e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18f) Tiene confianza de que los conocimientos que está adquiriendo le ayudarán a encontrar un empleo aceptable.</td>
                                        <td><input type="radio" name="18f" id="" value="4" required></td>
                                        <td><input type="radio" name="18f" id="" value="3" required></td>
                                        <td><input type="radio" name="18f" id="" value="2" required></td>
                                        <td><input type="radio" name="18f" id="" value="1" required></td>
                                        <td><input type="radio" name="18f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>18g) Lo que ha aprendido en clase lo ha podido aplicar en resolver problemas de la vida real.</td>
                                        <td><input type="radio" name="18g" id="" value="4" required></td>
                                        <td><input type="radio" name="18g" id="" value="3" required></td>
                                        <td><input type="radio" name="18g" id="" value="2" required></td>
                                        <td><input type="radio" name="18g" id="" value="1" required></td>
                                        <td><input type="radio" name="18g" id="" value="nc" required></td>
                                    </tr>

                                </tbody>
                            </table>

                            <br>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value='Regresar' />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />
                        </fieldset>

                        <fieldset id="field5">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">5ta Parte: Aprendizaje</h2>
                            <hr>
                            <label for="">En la siguiente sección seleccione qué tan de acuerdo está con las frases que se mencionan. </label>
                            <label for="">En caso de que no aplique la pregunta o no conozca la respuesta seleccione <b>No sé / No aplica</b></label>
                            <table class="table table-striped table-responsive">
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
                                        <td colspan="6" class="table-warning text-center">19) Motivación.</td>
                                    </tr>
                                    <tr>
                                        <td>19a) ¿Valora positivamente su capacidad para aprender?</td>
                                        <td><input type="radio" name="19a" id="" value="4" required></td>
                                        <td><input type="radio" name="19a" id="" value="3" required></td>
                                        <td><input type="radio" name="19a" id="" value="2" required></td>
                                        <td><input type="radio" name="19a" id="" value="1" required></td>
                                        <td><input type="radio" name="19a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19b) ¿Desarrolla confianza en sus capacidades y habilidades?</td>
                                        <td><input type="radio" name="19b" id="" value="4" required></td>
                                        <td><input type="radio" name="19b" id="" value="3" required></td>
                                        <td><input type="radio" name="19b" id="" value="2" required></td>
                                        <td><input type="radio" name="19b" id="" value="1" required></td>
                                        <td><input type="radio" name="19b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19c) ¿Identifica condiciones emocionales que pueden influir en el estudio y sabe controlarlas?</td>
                                        <td><input type="radio" name="19c" id="" value="4" required></td>
                                        <td><input type="radio" name="19c" id="" value="3" required></td>
                                        <td><input type="radio" name="19c" id="" value="2" required></td>
                                        <td><input type="radio" name="19c" id="" value="1" required></td>
                                        <td><input type="radio" name="19c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19d) ¿Demuestra motivación propia por aprender a superar sus dificultades?</td>
                                        <td><input type="radio" name="19d" id="" value="4" required></td>
                                        <td><input type="radio" name="19d" id="" value="3" required></td>
                                        <td><input type="radio" name="19d" id="" value="2" required></td>
                                        <td><input type="radio" name="19d" id="" value="1" required></td>
                                        <td><input type="radio" name="19d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19e) ¿Aprovecha su potencial y deficiencias para mejorar su aprendizaje?</td>
                                        <td><input type="radio" name="19e" id="" value="4" required></td>
                                        <td><input type="radio" name="19e" id="" value="3" required></td>
                                        <td><input type="radio" name="19e" id="" value="2" required></td>
                                        <td><input type="radio" name="19e" id="" value="1" required></td>
                                        <td><input type="radio" name="19e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19f) ¿Mejora el control sobre sus condiciones emocionales que pueden influir en el estudio?</td>
                                        <td><input type="radio" name="19f" id="" value="4" required></td>
                                        <td><input type="radio" name="19f" id="" value="3" required></td>
                                        <td><input type="radio" name="19f" id="" value="2" required></td>
                                        <td><input type="radio" name="19f" id="" value="1" required></td>
                                        <td><input type="radio" name="19f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19g) ¿Toma iniciativa en la realización de actividades que complementen sus conocimientos?</td>
                                        <td><input type="radio" name="19g" id="" value="4" required></td>
                                        <td><input type="radio" name="19g" id="" value="3" required></td>
                                        <td><input type="radio" name="19g" id="" value="2" required></td>
                                        <td><input type="radio" name="19g" id="" value="1" required></td>
                                        <td><input type="radio" name="19g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19h) ¿Demuestra autocontrol de sus capacidades y condiciones emocionales?</td>
                                        <td><input type="radio" name="19h" id="" value="4" required></td>
                                        <td><input type="radio" name="19h" id="" value="3" required></td>
                                        <td><input type="radio" name="19h" id="" value="2" required></td>
                                        <td><input type="radio" name="19h" id="" value="1" required></td>
                                        <td><input type="radio" name="19h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19i) ¿Asume con alto sentido de responsabilidad sus asignaciones?</td>
                                        <td><input type="radio" name="19i" id="" value="4" required></td>
                                        <td><input type="radio" name="19i" id="" value="3" required></td>
                                        <td><input type="radio" name="19i" id="" value="2" required></td>
                                        <td><input type="radio" name="19i" id="" value="1" required></td>
                                        <td><input type="radio" name="19i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19j) ¿Busca información adicional fuera de clase?</td>
                                        <td><input type="radio" name="19j" id="" value="4" required></td>
                                        <td><input type="radio" name="19j" id="" value="3" required></td>
                                        <td><input type="radio" name="19j" id="" value="2" required></td>
                                        <td><input type="radio" name="19j" id="" value="1" required></td>
                                        <td><input type="radio" name="19j" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>19k) ¿No le satisface únicamente aprobar un examen, si no que le interesa más tener el conocimiento?</td>
                                        <td><input type="radio" name="19k" id="" value="4" required></td>
                                        <td><input type="radio" name="19k" id="" value="3" required></td>
                                        <td><input type="radio" name="19k" id="" value="2" required></td>
                                        <td><input type="radio" name="19k" id="" value="1" required></td>
                                        <td><input type="radio" name="19k" id="" value="nc" required></td>
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
                                        <td colspan="6" class="table-warning text-center">20) Planificación.</td>
                                    </tr>
                                    <tr>
                                        <td>20a) ¿Identifica metas de aprendizaje: a corto, mediano y largo plazo?</td>
                                        <td><input type="radio" name="20a" id="" value="4" required></td>
                                        <td><input type="radio" name="20a" id="" value="3" required></td>
                                        <td><input type="radio" name="20a" id="" value="2" required></td>
                                        <td><input type="radio" name="20a" id="" value="1" required></td>
                                        <td><input type="radio" name="20a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20b) ¿Se compromete a lograr metas de aprendizaje?</td>
                                        <td><input type="radio" name="20b" id="" value="4" required></td>
                                        <td><input type="radio" name="20b" id="" value="3" required></td>
                                        <td><input type="radio" name="20b" id="" value="2" required></td>
                                        <td><input type="radio" name="20b" id="" value="1" required></td>
                                        <td><input type="radio" name="20b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20c) ¿Analiza las condiciones de la tarea: tipo de actividad, complejidad, secuencia a seguir, condiciones dadas, entre otras?</td>
                                        <td><input type="radio" name="20c" id="" value="4" required></td>
                                        <td><input type="radio" name="20c" id="" value="3" required></td>
                                        <td><input type="radio" name="20c" id="" value="2" required></td>
                                        <td><input type="radio" name="20c" id="" value="1" required></td>
                                        <td><input type="radio" name="20c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20d) ¿Analiza las estrategias de aprendizaje más convenientes para lograr sus metas?</td>
                                        <td><input type="radio" name="20d" id="" value="4" required></td>
                                        <td><input type="radio" name="20d" id="" value="3" required></td>
                                        <td><input type="radio" name="20d" id="" value="2" required></td>
                                        <td><input type="radio" name="20d" id="" value="1" required></td>
                                        <td><input type="radio" name="20d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20e) ¿Determina el tiempo necesario para cumplir sus metas?</td>
                                        <td><input type="radio" name="20e" id="" value="4" required></td>
                                        <td><input type="radio" name="20e" id="" value="3" required></td>
                                        <td><input type="radio" name="20e" id="" value="2" required></td>
                                        <td><input type="radio" name="20e" id="" value="1" required></td>
                                        <td><input type="radio" name="20e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20f) ¿Formula un plan de estudio?</td>
                                        <td><input type="radio" name="20f" id="" value="4" required></td>
                                        <td><input type="radio" name="20f" id="" value="3" required></td>
                                        <td><input type="radio" name="20f" id="" value="2" required></td>
                                        <td><input type="radio" name="20f" id="" value="1" required></td>
                                        <td><input type="radio" name="20f" id="" value="nc" required></td>
                                    </tr>
                                    <!--
                                    <tr>
                                        <td>20g) ¿Analiza con mayor criterio las condiciones de la tarea: tipo de actividad, complejidad, secuencia a seguir, condiciones dadas, entre otras?</td>
                                        <td><input type="radio" name="20g" id="" value="4" required></td>
                                        <td><input type="radio" name="20g" id="" value="3" required></td>
                                        <td><input type="radio" name="20g" id="" value="2" required></td>
                                        <td><input type="radio" name="20g" id="" value="1" required></td>
                                        <td><input type="radio" name="20g" id="" value="nc" required></td>
                                    </tr>
                                    -->
                                    <tr>
                                        <td>20g) ¿Mejoras la selección de las estrategias de aprendizaje más convenientes para lograr sus metas?</td>
                                        <td><input type="radio" name="20h" id="" value="4" required></td>
                                        <td><input type="radio" name="20h" id="" value="3" required></td>
                                        <td><input type="radio" name="20h" id="" value="2" required></td>
                                        <td><input type="radio" name="20h" id="" value="1" required></td>
                                        <td><input type="radio" name="20h" id="" value="nc" required></td>
                                    </tr>
                                    <!--
                                    <tr>
                                        <td>20i) ¿Se compromete a lograr metas de aprendizaje?</td>
                                        <td><input type="radio" name="20i" id="" value="4" required></td>
                                        <td><input type="radio" name="20i" id="" value="3" required></td>
                                        <td><input type="radio" name="20i" id="" value="2" required></td>
                                        <td><input type="radio" name="20i" id="" value="1" required></td>
                                        <td><input type="radio" name="20i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20j) ¿Determina el tiempo necesario para cumplir sus metas?</td>
                                        <td><input type="radio" name="20j" id="" value="4" required></td>
                                        <td><input type="radio" name="20j" id="" value="3" required></td>
                                        <td><input type="radio" name="20j" id="" value="2" required></td>
                                        <td><input type="radio" name="20j" id="" value="1" required></td>
                                        <td><input type="radio" name="20j" id="" value="nc" required></td>
                                    </tr>
                                    -->
                                    <tr>
                                        <td>20h) ¿Se asegura de cumplir sus metas a corto plazo?</td>
                                        <td><input type="radio" name="20k" id="" value="4" required></td>
                                        <td><input type="radio" name="20k" id="" value="3" required></td>
                                        <td><input type="radio" name="20k" id="" value="2" required></td>
                                        <td><input type="radio" name="20k" id="" value="1" required></td>
                                        <td><input type="radio" name="20k" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>20i) ¿Recurre a un experto para intercambiar puntos de vista?</td>
                                        <td><input type="radio" name="20l" id="" value="4" required></td>
                                        <td><input type="radio" name="20l" id="" value="3" required></td>
                                        <td><input type="radio" name="20l" id="" value="2" required></td>
                                        <td><input type="radio" name="20l" id="" value="1" required></td>
                                        <td><input type="radio" name="20l" id="" value="nc" required></td>
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
                                        <td colspan="6" class="table-warning text-center">21) Auto-regulación.</td>
                                    </tr>
                                    <tr>
                                        <td>21a) ¿Es consciente sobre su capacidad de aprendizaje?</td>
                                        <td><input type="radio" name="21a" id="" value="4" required></td>
                                        <td><input type="radio" name="21a" id="" value="3" required></td>
                                        <td><input type="radio" name="21a" id="" value="2" required></td>
                                        <td><input type="radio" name="21a" id="" value="1" required></td>
                                        <td><input type="radio" name="21a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>21b) ¿Revisa y/o ajusta las estrategias de aprendizaje utilizadas en función de la tarea?</td>
                                        <td><input type="radio" name="21b" id="" value="4" required></td>
                                        <td><input type="radio" name="21b" id="" value="3" required></td>
                                        <td><input type="radio" name="21b" id="" value="2" required></td>
                                        <td><input type="radio" name="21b" id="" value="1" required></td>
                                        <td><input type="radio" name="21b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>21c) ¿Revisa y ajusta las acciones que vas realizando para lograr metas de aprendizaje?</td>
                                        <td><input type="radio" name="21c" id="" value="4" required></td>
                                        <td><input type="radio" name="21c" id="" value="3" required></td>
                                        <td><input type="radio" name="21c" id="" value="2" required></td>
                                        <td><input type="radio" name="21c" id="" value="1" required></td>
                                        <td><input type="radio" name="21c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>21d) ¿Evalúa y decide durante su desempeño aquello que debe cambiar, ajustar para lograr sus metas?</td>
                                        <td><input type="radio" name="21d" id="" value="4" required></td>
                                        <td><input type="radio" name="21d" id="" value="3" required></td>
                                        <td><input type="radio" name="21d" id="" value="2" required></td>
                                        <td><input type="radio" name="21d" id="" value="1" required></td>
                                        <td><input type="radio" name="21d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>21e) ¿Está consciente del avance de sus actividades?</td>
                                        <td><input type="radio" name="21e" id="" value="4" required></td>
                                        <td><input type="radio" name="21e" id="" value="3" required></td>
                                        <td><input type="radio" name="21e" id="" value="2" required></td>
                                        <td><input type="radio" name="21e" id="" value="1" required></td>
                                        <td><input type="radio" name="21e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>21f) ¿Cambia de materiales si los que utiliza no satisfacen la necesidad de aprendizaje o su nivel?</td>
                                        <td><input type="radio" name="21f" id="" value="4" required></td>
                                        <td><input type="radio" name="21f" id="" value="3" required></td>
                                        <td><input type="radio" name="21f" id="" value="2" required></td>
                                        <td><input type="radio" name="21f" id="" value="1" required></td>
                                        <td><input type="radio" name="21f" id="" value="nc" required></td>
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
                                        <td colspan="6" class="table-warning text-center">22) Auto-evaluación.</td>
                                    </tr>
                                    <tr>
                                        <td>22a) ¿Analiza errores, fallos, aciertos?</td>
                                        <td><input type="radio" name="22a" id="" value="4" required></td>
                                        <td><input type="radio" name="22a" id="" value="3" required></td>
                                        <td><input type="radio" name="22a" id="" value="2" required></td>
                                        <td><input type="radio" name="22a" id="" value="1" required></td>
                                        <td><input type="radio" name="22a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22b) ¿Utiliza lo aprendido en la formulación del siguiente plan o sesión de auto-aprendizaje?</td>
                                        <td><input type="radio" name="22b" id="" value="4" required></td>
                                        <td><input type="radio" name="22b" id="" value="3" required></td>
                                        <td><input type="radio" name="22b" id="" value="2" required></td>
                                        <td><input type="radio" name="22b" id="" value="1" required></td>
                                        <td><input type="radio" name="22b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22c) ¿Evalúa su actuación en función de las metas y plan formulados?</td>
                                        <td><input type="radio" name="22c" id="" value="4" required></td>
                                        <td><input type="radio" name="22c" id="" value="3" required></td>
                                        <td><input type="radio" name="22c" id="" value="2" required></td>
                                        <td><input type="radio" name="22c" id="" value="1" required></td>
                                        <td><input type="radio" name="22c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22d) ¿Se autoevalúa a partir de criterios dados (escala de valores/clave de respuestas)?</td>
                                        <td><input type="radio" name="22d" id="" value="4" required></td>
                                        <td><input type="radio" name="22d" id="" value="3" required></td>
                                        <td><input type="radio" name="22d" id="" value="2" required></td>
                                        <td><input type="radio" name="22d" id="" value="1" required></td>
                                        <td><input type="radio" name="22d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22e) ¿Utiliza la retroalimentación en sus actividades, tareas, practicas, o exámenes para mejorar sus conocimientos y desempeño?</td>
                                        <td><input type="radio" name="22e" id="" value="4" required></td>
                                        <td><input type="radio" name="22e" id="" value="3" required></td>
                                        <td><input type="radio" name="22e" id="" value="2" required></td>
                                        <td><input type="radio" name="22e" id="" value="1" required></td>
                                        <td><input type="radio" name="22e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22f. ¿Autoevalúa su desempeño en función de sus metas y plan formulado?</td>
                                        <td><input type="radio" name="22f" id="" value="4" required></td>
                                        <td><input type="radio" name="22f" id="" value="3" required></td>
                                        <td><input type="radio" name="22f" id="" value="2" required></td>
                                        <td><input type="radio" name="22f" id="" value="1" required></td>
                                        <td><input type="radio" name="22f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22g) ¿Implementa cambios, intenta nuevos materiales, para mejorar sus actividades de auto-aprendizaje?</td>
                                        <td><input type="radio" name="22g" id="" value="4" required></td>
                                        <td><input type="radio" name="22g" id="" value="3" required></td>
                                        <td><input type="radio" name="22g" id="" value="2" required></td>
                                        <td><input type="radio" name="22g" id="" value="1" required></td>
                                        <td><input type="radio" name="22g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22h) ¿Se autoevalúa a partir de criterios establecidos por sí mismo?</td>
                                        <td><input type="radio" name="22h" id="" value="4" required></td>
                                        <td><input type="radio" name="22h" id="" value="3" required></td>
                                        <td><input type="radio" name="22h" id="" value="2" required></td>
                                        <td><input type="radio" name="22h" id="" value="1" required></td>
                                        <td><input type="radio" name="22h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22i) ¿Compara la progresión de sus conocimientos con resultados anteriores?</td>
                                        <td><input type="radio" name="22i" id="" value="4" required></td>
                                        <td><input type="radio" name="22i" id="" value="3" required></td>
                                        <td><input type="radio" name="22i" id="" value="2" required></td>
                                        <td><input type="radio" name="22i" id="" value="1" required></td>
                                        <td><input type="radio" name="22i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22j) ¿Demuestra dominio en la formulación de criterios de auto-evaluación ante, durante y al final de su proceso de estudio?</td>
                                        <td><input type="radio" name="22j" id="" value="4" required></td>
                                        <td><input type="radio" name="22j" id="" value="3" required></td>
                                        <td><input type="radio" name="22j" id="" value="2" required></td>
                                        <td><input type="radio" name="22j" id="" value="1" required></td>
                                        <td><input type="radio" name="22j" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22k) ¿Asume la autoevaluación como actitud y estrategia permanente de mejora?</td>
                                        <td><input type="radio" name="22k" id="" value="4" required></td>
                                        <td><input type="radio" name="22k" id="" value="3" required></td>
                                        <td><input type="radio" name="22k" id="" value="2" required></td>
                                        <td><input type="radio" name="22k" id="" value="1" required></td>
                                        <td><input type="radio" name="22k" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>22l) ¿Corrige sus errores prácticamente sin ayuda externa?</td>
                                        <td><input type="radio" name="22l" id="" value="4" required></td>
                                        <td><input type="radio" name="22l" id="" value="3" required></td>
                                        <td><input type="radio" name="22l" id="" value="2" required></td>
                                        <td><input type="radio" name="22l" id="" value="1" required></td>
                                        <td><input type="radio" name="22l" id="" value="nc" required></td>
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
                                        <td colspan="6" class="table-warning text-center">23) Habilidades comunicativas y sociales.</td>
                                    </tr>
                                    <tr>
                                        <td>23a) ¿Usa estrategias de comprensión lectora?</td>
                                        <td><input type="radio" name="23a" id="" value="4" required></td>
                                        <td><input type="radio" name="23a" id="" value="3" required></td>
                                        <td><input type="radio" name="23a" id="" value="2" required></td>
                                        <td><input type="radio" name="23a" id="" value="1" required></td>
                                        <td><input type="radio" name="23a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23b) ¿Realiza actividades concretas para participar aportando ideas, opiniones o propuestas?</td>
                                        <td><input type="radio" name="23b" id="" value="4" required></td>
                                        <td><input type="radio" name="23b" id="" value="3" required></td>
                                        <td><input type="radio" name="23b" id="" value="2" required></td>
                                        <td><input type="radio" name="23b" id="" value="1" required></td>
                                        <td><input type="radio" name="23b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23c) ¿Es capaz de integrarse a un grupo?</td>
                                        <td><input type="radio" name="23c" id="" value="4" required></td>
                                        <td><input type="radio" name="23c" id="" value="3" required></td>
                                        <td><input type="radio" name="23c" id="" value="2" required></td>
                                        <td><input type="radio" name="23c" id="" value="1" required></td>
                                        <td><input type="radio" name="23c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23d) ¿Mejora sus estrategias de comprensión lectora?</td>
                                        <td><input type="radio" name="23d" id="" value="4" required></td>
                                        <td><input type="radio" name="23d" id="" value="3" required></td>
                                        <td><input type="radio" name="23d" id="" value="2" required></td>
                                        <td><input type="radio" name="23d" id="" value="1" required></td>
                                        <td><input type="radio" name="23d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23e) ¿Desempeña diversos roles en grupo (líder, mediador, guía, colaborador, etc.?</td>
                                        <td><input type="radio" name="23e" id="" value="4" required></td>
                                        <td><input type="radio" name="23e" id="" value="3" required></td>
                                        <td><input type="radio" name="23e" id="" value="2" required></td>
                                        <td><input type="radio" name="23e" id="" value="1" required></td>
                                        <td><input type="radio" name="23e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23f) ¿Desarrolla proyectos colaborativos?</td>
                                        <td><input type="radio" name="23f" id="" value="4" required></td>
                                        <td><input type="radio" name="23f" id="" value="3" required></td>
                                        <td><input type="radio" name="23f" id="" value="2" required></td>
                                        <td><input type="radio" name="23f" id="" value="1" required></td>
                                        <td><input type="radio" name="23f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23g) ¿Desarrolla habilidades para el trabajo individual?</td>
                                        <td><input type="radio" name="23g" id="" value="4" required></td>
                                        <td><input type="radio" name="23g" id="" value="3" required></td>
                                        <td><input type="radio" name="23g" id="" value="2" required></td>
                                        <td><input type="radio" name="23g" id="" value="1" required></td>
                                        <td><input type="radio" name="23g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23h) ¿Produce actividades en las que comunica con claridad el mensaje?</td>
                                        <td><input type="radio" name="23h" id="" value="4" required></td>
                                        <td><input type="radio" name="23h" id="" value="3" required></td>
                                        <td><input type="radio" name="23h" id="" value="2" required></td>
                                        <td><input type="radio" name="23h" id="" value="1" required></td>
                                        <td><input type="radio" name="23h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23i) ¿Lee e interpreta con un sentido auto-crítico y de profundidad?</td>
                                        <td><input type="radio" name="23i" id="" value="4" required></td>
                                        <td><input type="radio" name="23i" id="" value="3" required></td>
                                        <td><input type="radio" name="23i" id="" value="2" required></td>
                                        <td><input type="radio" name="23i" id="" value="1" required></td>
                                        <td><input type="radio" name="23i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23j) ¿Toma decisiones sobre su interacción con otros en función a sus metas de aprendizaje personal?</td>
                                        <td><input type="radio" name="23j" id="" value="4" required></td>
                                        <td><input type="radio" name="23j" id="" value="3" required></td>
                                        <td><input type="radio" name="23j" id="" value="2" required></td>
                                        <td><input type="radio" name="23j" id="" value="1" required></td>
                                        <td><input type="radio" name="23j" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23k) ¿Valora el aporte de otros en su proceso de aprendizaje?</td>
                                        <td><input type="radio" name="23k" id="" value="4" required></td>
                                        <td><input type="radio" name="23k" id="" value="3" required></td>
                                        <td><input type="radio" name="23k" id="" value="2" required></td>
                                        <td><input type="radio" name="23k" id="" value="1" required></td>
                                        <td><input type="radio" name="23k" id="" value="nc" required></td>
                                    </tr>
                                    <!--
                                    <tr>
                                        <td>23l) ¿Desarrolla proyectos colaborativos en favor de su desarrollo académico?</td>
                                        <td><input type="radio" name="23l" id="" value="4" required></td>
                                        <td><input type="radio" name="23l" id="" value="3" required></td>
                                        <td><input type="radio" name="23l" id="" value="2" required></td>
                                        <td><input type="radio" name="23l" id="" value="1" required></td>
                                        <td><input type="radio" name="23l" id="" value="nc" required></td>
                                    </tr>
                                    -->
                                    <tr>
                                        <td>23l) ¿Expresa su punto de vista para lograr puntos de acuerdo en grupo?</td>
                                        <td><input type="radio" name="23m" id="" value="4" required></td>
                                        <td><input type="radio" name="23m" id="" value="3" required></td>
                                        <td><input type="radio" name="23m" id="" value="2" required></td>
                                        <td><input type="radio" name="23m" id="" value="1" required></td>
                                        <td><input type="radio" name="23m" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>23m) ¿Logra con facilidad expresar sus ideas a los demás?</td>
                                        <td><input type="radio" name="23n" id="" value="4" required></td>
                                        <td><input type="radio" name="23n" id="" value="3" required></td>
                                        <td><input type="radio" name="23n" id="" value="2" required></td>
                                        <td><input type="radio" name="23n" id="" value="1" required></td>
                                        <td><input type="radio" name="23n" id="" value="nc" required></td>
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
                                        <td colspan="6" class="table-warning text-center">24) Estilo de aprendizaje - Kinestésico.</td>
                                    </tr>
                                    <tr>
                                        <td>24a) Cuando estudia lo hace mejor caminando de un lado a otro en la habitación.</td>
                                        <td><input type="radio" name="24a" id="" value="4" required></td>
                                        <td><input type="radio" name="24a" id="" value="3" required></td>
                                        <td><input type="radio" name="24a" id="" value="2" required></td>
                                        <td><input type="radio" name="24a" id="" value="1" required></td>
                                        <td><input type="radio" name="24a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24b) Cuando no puede pensar en una palabra específica, usa sus manos para tratar de explicar de qué está hablando.</td>
                                        <td><input type="radio" name="24b" id="" value="4" required></td>
                                        <td><input type="radio" name="24b" id="" value="3" required></td>
                                        <td><input type="radio" name="24b" id="" value="2" required></td>
                                        <td><input type="radio" name="24b" id="" value="1" required></td>
                                        <td><input type="radio" name="24b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24c) Cuando tiene una gran idea, debe escribirla inmediatamente o la olvida con facilidad.</td>
                                        <td><input type="radio" name="24c" id="" value="4" required></td>
                                        <td><input type="radio" name="24c" id="" value="3" required></td>
                                        <td><input type="radio" name="24c" id="" value="2" required></td>
                                        <td><input type="radio" name="24c" id="" value="1" required></td>
                                        <td><input type="radio" name="24c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24d) Cuando toma clase necesita escribir los puntos importantes para entender mejor.</td>
                                        <td><input type="radio" name="24d" id="" value="4" required></td>
                                        <td><input type="radio" name="24d" id="" value="3" required></td>
                                        <td><input type="radio" name="24d" id="" value="2" required></td>
                                        <td><input type="radio" name="24d" id="" value="1" required></td>
                                        <td><input type="radio" name="24d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24e) Le gusta interactuar con objetos nuevos e investigar cómo funcionan.</td>
                                        <td><input type="radio" name="24e" id="" value="4" required></td>
                                        <td><input type="radio" name="24e" id="" value="3" required></td>
                                        <td><input type="radio" name="24e" id="" value="2" required></td>
                                        <td><input type="radio" name="24e" id="" value="1" required></td>
                                        <td><input type="radio" name="24e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24f) Necesita hacer pausas frecuentes y mover su cuerpo cuando estudia.</td>
                                        <td><input type="radio" name="24f" id="" value="4" required></td>
                                        <td><input type="radio" name="24f" id="" value="3" required></td>
                                        <td><input type="radio" name="24f" id="" value="2" required></td>
                                        <td><input type="radio" name="24f" id="" value="1" required></td>
                                        <td><input type="radio" name="24f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24g) No le gusta leer o escuchar instrucciones, prefiere simplemente comenzar a hacer las cosas.</td>
                                        <td><input type="radio" name="24g" id="" value="4" required></td>
                                        <td><input type="radio" name="24g" id="" value="3" required></td>
                                        <td><input type="radio" name="24g" id="" value="2" required></td>
                                        <td><input type="radio" name="24g" id="" value="1" required></td>
                                        <td><input type="radio" name="24g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24h) Para aprender algo nuevo, prefiere experimentar.</td>
                                        <td><input type="radio" name="24h" id="" value="4" required></td>
                                        <td><input type="radio" name="24h" id="" value="3" required></td>
                                        <td><input type="radio" name="24h" id="" value="2" required></td>
                                        <td><input type="radio" name="24h" id="" value="1" required></td>
                                        <td><input type="radio" name="24h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24i) Piensa mejor cuando tiene la libertad de moverse.</td>
                                        <td><input type="radio" name="24i" id="" value="4" required></td>
                                        <td><input type="radio" name="24i" id="" value="3" required></td>
                                        <td><input type="radio" name="24i" id="" value="2" required></td>
                                        <td><input type="radio" name="24i" id="" value="1" required></td>
                                        <td><input type="radio" name="24i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>T24j) Toma muchos apuntes de lo que lee y escucha.</td>
                                        <td><input type="radio" name="24j" id="" value="4" required></td>
                                        <td><input type="radio" name="24j" id="" value="3" required></td>
                                        <td><input type="radio" name="24j" id="" value="2" required></td>
                                        <td><input type="radio" name="24j" id="" value="1" required></td>
                                        <td><input type="radio" name="24j" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>24k) Usa sus dedos para contar y mueve los labios cuando lee.</td>
                                        <td><input type="radio" name="24k" id="" value="4" required></td>
                                        <td><input type="radio" name="24k" id="" value="3" required></td>
                                        <td><input type="radio" name="24k" id="" value="2" required></td>
                                        <td><input type="radio" name="24k" id="" value="1" required></td>
                                        <td><input type="radio" name="24k" id="" value="nc" required></td>
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
                                        <td colspan="6" class="table-warning text-center">25) Estilo de aprendizaje - Visual.</td>
                                    </tr>
                                    <tr>
                                        <td>25a) “Inventa” o se imagina cosas, cuando está en plena clase.</td>
                                        <td><input type="radio" name="25a" id="" value="4" required></td>
                                        <td><input type="radio" name="25a" id="" value="3" required></td>
                                        <td><input type="radio" name="25a" id="" value="2" required></td>
                                        <td><input type="radio" name="25a" id="" value="1" required></td>
                                        <td><input type="radio" name="25a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25b) Cuando está en un examen, puede visualizar la página del libro donde está la respuesta.</td>
                                        <td><input type="radio" name="25b" id="" value="4" required></td>
                                        <td><input type="radio" name="25b" id="" value="3" required></td>
                                        <td><input type="radio" name="25b" id="" value="2" required></td>
                                        <td><input type="radio" name="25b" id="" value="1" required></td>
                                        <td><input type="radio" name="25b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25c) Cuando está tratando de recordar algo nuevo, por ejemplo, un número de teléfono, le ayuda formar una imagen mental para lograrlo.</td>
                                        <td><input type="radio" name="25c" id="" value="4" required></td>
                                        <td><input type="radio" name="25c" id="" value="3" required></td>
                                        <td><input type="radio" name="25c" id="" value="2" required></td>
                                        <td><input type="radio" name="25c" id="" value="1" required></td>
                                        <td><input type="radio" name="25c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25d) Le gusta ilustrar lo que va a aprendiendo.</td>
                                        <td><input type="radio" name="25d" id="" value="4" required></td>
                                        <td><input type="radio" name="25d" id="" value="3" required></td>
                                        <td><input type="radio" name="25d" id="" value="2" required></td>
                                        <td><input type="radio" name="25d" id="" value="1" required></td>
                                        <td><input type="radio" name="25d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25e) Le gusta usar mapas mentales o dibujos para estudiar.</td>
                                        <td><input type="radio" name="25e" id="" value="4" required></td>
                                        <td><input type="radio" name="25e" id="" value="3" required></td>
                                        <td><input type="radio" name="25e" id="" value="2" required></td>
                                        <td><input type="radio" name="25e" id="" value="1" required></td>
                                        <td><input type="radio" name="25e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25f) Le resulta fácil entender mapas, tablas y gráficos.</td>
                                        <td><input type="radio" name="25f" id="" value="4" required></td>
                                        <td><input type="radio" name="25f" id="" value="3" required></td>
                                        <td><input type="radio" name="25f" id="" value="2" required></td>
                                        <td><input type="radio" name="25f" id="" value="1" required></td>
                                        <td><input type="radio" name="25f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25g) Sus notas están escritas con plumas de colores o marcadas con marca textos.</td>
                                        <td><input type="radio" name="25g" id="" value="4" required></td>
                                        <td><input type="radio" name="25g" id="" value="3" required></td>
                                        <td><input type="radio" name="25g" id="" value="2" required></td>
                                        <td><input type="radio" name="25g" id="" value="1" required></td>
                                        <td><input type="radio" name="25g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25h) Para estar atento necesita mirar a quien le está hablando</td>
                                        <td><input type="radio" name="25h" id="" value="4" required></td>
                                        <td><input type="radio" name="25h" id="" value="3" required></td>
                                        <td><input type="radio" name="25h" id="" value="2" required></td>
                                        <td><input type="radio" name="25h" id="" value="1" required></td>
                                        <td><input type="radio" name="25h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25i) Prefiere los libros con imágenes, fotos o colores.</td>
                                        <td><input type="radio" name="25i" id="" value="4" required></td>
                                        <td><input type="radio" name="25i" id="" value="3" required></td>
                                        <td><input type="radio" name="25i" id="" value="2" required></td>
                                        <td><input type="radio" name="25i" id="" value="1" required></td>
                                        <td><input type="radio" name="25i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25j) Prefiere ver videos, que sólo escuchar la música.</td>
                                        <td><input type="radio" name="25j" id="" value="4" required></td>
                                        <td><input type="radio" name="25j" id="" value="3" required></td>
                                        <td><input type="radio" name="25j" id="" value="2" required></td>
                                        <td><input type="radio" name="25j" id="" value="1" required></td>
                                        <td><input type="radio" name="25j" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>25k) Puede fácilmente visualizar imágenes en su cabeza.</td>
                                        <td><input type="radio" name="25k" id="" value="4" required></td>
                                        <td><input type="radio" name="25k" id="" value="3" required></td>
                                        <td><input type="radio" name="25k" id="" value="2" required></td>
                                        <td><input type="radio" name="25k" id="" value="1" required></td>
                                        <td><input type="radio" name="25k" id="" value="nc" required></td>
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
                                        <td colspan="6" class="table-warning text-center">26) Estilo de aprendizaje - Auditivo.</td>
                                    </tr>
                                    <tr>
                                        <td>26a) Al leer le gusta escuchar las palabras en su cabeza o leer en voz alta.</td>
                                        <td><input type="radio" name="26a" id="" value="4" required></td>
                                        <td><input type="radio" name="26a" id="" value="3" required></td>
                                        <td><input type="radio" name="26a" id="" value="2" required></td>
                                        <td><input type="radio" name="26a" id="" value="1" required></td>
                                        <td><input type="radio" name="26a" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26b) Cuando escucha al profesor en clase, recuerda más que leyendo un libro.</td>
                                        <td><input type="radio" name="26b" id="" value="4" required></td>
                                        <td><input type="radio" name="26b" id="" value="3" required></td>
                                        <td><input type="radio" name="26b" id="" value="2" required></td>
                                        <td><input type="radio" name="26b" id="" value="1" required></td>
                                        <td><input type="radio" name="26b" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26c) Se concentra más escuchando música de fondo.</td>
                                        <td><input type="radio" name="26c" id="" value="4" required></td>
                                        <td><input type="radio" name="26c" id="" value="3" required></td>
                                        <td><input type="radio" name="26c" id="" value="2" required></td>
                                        <td><input type="radio" name="26c" id="" value="1" required></td>
                                        <td><input type="radio" name="26c" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26d) Le es fácil recordar un chiste para volverlo a contar.</td>
                                        <td><input type="radio" name="26d" id="" value="4" required></td>
                                        <td><input type="radio" name="26d" id="" value="3" required></td>
                                        <td><input type="radio" name="26d" id="" value="2" required></td>
                                        <td><input type="radio" name="26d" id="" value="1" required></td>
                                        <td><input type="radio" name="26d" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26e) Le resulta útil decir en voz alta las tareas que tiene que hacer.</td>
                                        <td><input type="radio" name="26e" id="" value="4" required></td>
                                        <td><input type="radio" name="26e" id="" value="3" required></td>
                                        <td><input type="radio" name="26e" id="" value="2" required></td>
                                        <td><input type="radio" name="26e" id="" value="1" required></td>
                                        <td><input type="radio" name="26e" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26f) Necesita hablar las cosas para entenderlas mejor.</td>
                                        <td><input type="radio" name="26f" id="" value="4" required></td>
                                        <td><input type="radio" name="26f" id="" value="3" required></td>
                                        <td><input type="radio" name="26f" id="" value="2" required></td>
                                        <td><input type="radio" name="26f" id="" value="1" required></td>
                                        <td><input type="radio" name="26f" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26g) Prefiere que alguien le diga cómo tiene que hacer las cosas en lugar de leer las instrucciones.</td>
                                        <td><input type="radio" name="26g" id="" value="4" required></td>
                                        <td><input type="radio" name="26g" id="" value="3" required></td>
                                        <td><input type="radio" name="26g" id="" value="2" required></td>
                                        <td><input type="radio" name="26g" id="" value="1" required></td>
                                        <td><input type="radio" name="26g" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26h) Puede entender fácilmente a una persona que está hablando aunque esté viendo hacia otro lugar.</td>
                                        <td><input type="radio" name="26h" id="" value="4" required></td>
                                        <td><input type="radio" name="26h" id="" value="3" required></td>
                                        <td><input type="radio" name="26h" id="" value="2" required></td>
                                        <td><input type="radio" name="26h" id="" value="1" required></td>
                                        <td><input type="radio" name="26h" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26i) Recuerda mejor lo que la gente dice, que su aspecto físico.</td>
                                        <td><input type="radio" name="26i" id="" value="4" required></td>
                                        <td><input type="radio" name="26i" id="" value="3" required></td>
                                        <td><input type="radio" name="26i" id="" value="2" required></td>
                                        <td><input type="radio" name="26i" id="" value="1" required></td>
                                        <td><input type="radio" name="26i" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26j) Recuerda mejor lo que lee cuando estudia en voz alta.</td>
                                        <td><input type="radio" name="26j" id="" value="4" required></td>
                                        <td><input type="radio" name="26j" id="" value="3" required></td>
                                        <td><input type="radio" name="26j" id="" value="2" required></td>
                                        <td><input type="radio" name="26j" id="" value="1" required></td>
                                        <td><input type="radio" name="26j" id="" value="nc" required></td>
                                    </tr>
                                    <tr>
                                        <td>26k) Si un tema musical le encanta, prefiere sólo escucharlo antes que escribir sus letras.</td>
                                        <td><input type="radio" name="26k" id="" value="4" required></td>
                                        <td><input type="radio" name="26k" id="" value="3" required></td>
                                        <td><input type="radio" name="26k" id="" value="2" required></td>
                                        <td><input type="radio" name="26k" id="" value="1" required></td>
                                        <td><input type="radio" name="26k" id="" value="nc" required></td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6 class="text-center text-success">Gracias por el tiempo y la información que has dado para este trabajo con fines académicos y estadísticos.</h6>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />

                        </fieldset>
                    </div>
                </div>
            </section>

        </form>
    </div>

    <script>
        var base_url = '<?= base_url() ?>';
    </script>
    <script>
        $("form :input[type='text']").prop("disabled", true);
        $("form :input[type='text']").prop("disabled", true);
        $("form :input[type='email']").prop("disabled", true);
        $("form :input[type='radio']").prop("disabled", true);
        $("form :input[type='time']").prop("disabled", true);
        $("form select").prop("disabled", true);

        let radios = $('form :input[type="radio"]');
        let text = $('form :input[type="text"]');

        const formObj = <?= json_encode($cuestionario) ?>


        Object.values(text).forEach(t => {
            name = t.name;
            value = formObj[name];
            if (value == '') {
                value = 'Sin respuesta.'
            } else if (value == 'na') {
                value = 'No aplica.'
            }
            $("input:text[name='" + name + "']").val(value)
        })

        Object.values(radios).forEach(val => {
            let name = val.name
            let value = val.value;
            if (value == formObj[name]) {
                $("input:radio[name='" + name + "']").filter('[value="' + value + '"]').prop('checked', true);
            }
        });
    </script>
    <script src="<?= base_url('resources/js/cuestionarios/Relep/2023/index.js') ?>"></script>

</body>

</html>