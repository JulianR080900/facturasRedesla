<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resources/css/cuestionarios/Relen/2023/index.css") ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">
    <title>Encuesta RELEN 2023</title>
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
                    <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Relen.png"); ?>" style="width: 90%; height: 82%;">
                </div>
            </div>
            <h1 class="text-center">Investigación RELEN 2023</h1>
            <h3 class="text-center">
                “Los procesos metacognitivos y su impacto en la formación 
                lectora competente del docente en servicio de educación obligatoria”
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
                            Estudiar la metacognición y la comprensión lectora del docente en servicio de 
                            educación obligatoria para identificar de manera específica si una adecuada 
                            comprensión lectora favorece en tener conciencia en los  propios procesos del 
                            pensamiento, considerando una perspectiva comparativa entre las zonas y 
                            contextos abordados.
                            </p>
                            <h1 class="text-center">Instrucciones</h1>
                            <p class="text-center">
                                Si alguna pregunta no se puede contestar seleccione la opción “No sé / No aplica”. Es importante leer con especial atención 
                                a las palabras que están en <b>negritas</b>.
                            </p>
                            <h1 class="text-center">Aviso de privacidad</h1>
                            <h6 class="text-center">
                                SUS RESPUESTAS SON ABSOLUTAMENTE CONFIDENCIALES, AL CONTESTAR EL CUESTIONARIO AUTORIZA QUE SUS RESPUESTAS SEAN USADAS DE <u>MANERA ANÓNIMA</u>,
                                ÚNICA Y EXCLUSIVAMENTE CON FINES ACADÉMICOS, ¿ESTÁ DE ACUERDO?
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
                                    <input class="form-check-input" type="radio" name="medio_captura" id="opcion1" value="entrevista_impresa" required>
                                    <label class="form-check-label" for="opcion1">
                                        Mediante encuesta impresa al docente en servicio de educación básica.
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
                                        Soy docente en servicio de educación básica, me compartieron el enlace para responder.
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
                            Por favor, preste cuidado en la captura de su nombre y correo, con estos datos se emitirá su constancia de encuestador(a)<br>
                            Cada encuestador(a) DEBE REGISTRAR
                            SU CORREO ELECTRÓNICO PERSONAL (No está permitido utilizar el correo electrónico de otro encuestador)
                            Si el nombre del encuestador o correo electrónico es capturado erróneamente, <b>NO ES POSIBLE</b> realizar cambios.
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
                            <h2 class="text-center">1ra PARTE. PERFIL DOCENTE Y DEL GRUPO</h2>
                            <hr>
                            <h3>1) Perfil docente y del grupo</h3>
                            <div>
                                <label for="">1) Edad</label>
                                <input type="text" class="form-control" name="1a" id="1a" required>
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
                                <label for="">4) ¿Durante cuántos años ha sido docente de educación básica?</label>
                                <p class="instrucciones">Escribe 1 si es su primer año.</p>
                                <input class="form-control" type="text" name="4a" id="4a" required min='0'>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">5) ¿Tiene hijos?</label>
                                <input type="text" name="5a" id="5a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">6) ¿Cuál fue el último año de estudios que terminó?</label>
                                <input type="text" name="6a" id="6a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">7) ¿En qué tipo de institución estudió para ser docente?</label>
                                <input type="text" name="7a" id="7a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <h3>Características del grupo al que le das clases</h3>
                            <p class="instrucciones">En caso de que des en más de un grupo, refiérete al que le dedicas más horas a lo largo de todo el cuestionario.</p>

                            <hr>
                            <div>
                                <label for="">8) ¿Cómo está contratado en la institución donde labora?</label>
                                <input type="text" name="8a" id="8a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">9) ¿Cuántos años de servicio tiene en la escuela en la que imparte clases?</label>
                                <input type="text" name="9a" id="9a" class="form-control" required min='0'>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">10) ¿Qué tipo de financiamiento tiene la escuela en la que imparte clases?</label>
                                <input type="text" name="11a" id="11a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">11) ¿En qué contexto se ubica la escuela en la que imparte clases?</label>
                                <input type="text" name="12a" id="12a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">12) ¿Atienden a estudiantes provenientes de pueblos originarios en la escuela en la que imparte clases?</label>
                                <input type="text" name="13a" id="13a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">13) ¿De qué nivel de estudios es el grupo al que da clases?</label>
                                <input type="text" name="14a" id="14a" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">14) ¿De qué grado es el grupo al que da clases? (sólo el número).</label>
                                <input type="text" name="15a" id="15a" class="form-control" required min='0'>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">15) ¿Cuántos alumnos tiene en ese grupo?</label>
                                <input type="text" name="16a" id="16a" class="form-control" required min='0'>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">16) ¿Qué edad tiene la mayoría de sus alumnos de ese grupo?</label>
                                <input type="text" name="17a" id="17a" class="form-control" required min='0'>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">17) ¿A qué hora terminan clase sus alumnos?</label>
                                <input type="time" name="18a" id="18a" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>


                            <!--
                            <div>
                                <label for="">10) ¿En qué municipio se encuentra la escuela en la que impartes clases?</label>
                                <input type="text" name="10a" id="" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>
                            -->
                            
                            <br>

                            <h2>Datos de la escuela</h2>

                            <hr>

                            <div>
                                <label for="">18) País (Información obtenida  de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>).</label>
                                <input type="text" name="18c" id="18c" class="form-control" required readonly">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">18a) Estado (Información obtenida  de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>).</label>
                                <input type="text" name="18d" id="18d" class="form-control" required readonly>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">18b) Municipio de estudio (Información obtenida  de los datos que registró en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>).</label>
                                <input type="text" name="18b" id="18b" class="form-control">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">18c) Nombre de la escuela a encuestar</label>
                                <input type="text" name="18e" id="18e" class="form-control" required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">18d) Enlace de <a href="https://www.google.com/maps" target="_blank">Google Maps</a> con la ubicación de la escuela</label>
                                    <a id="dudas"><i class="fas fa-question-circle text-warning"></i></a>
                                <input type="text" name="coordenadas" pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$" placeholder="Ejemplo: https://www.google.com/maps/place/Escuela+Normal+Superior+Mo%C3%ADses+S%C3%A1enz+Garza/@25.6792873,-100.3362721,17z/data=!3m1!4b1!4m6!3m5!1s0x866295f46d5504cd:0xa4f7379d52e079f!8m2!3d25.6792825!4d-100.3317874!16s%2Fm%2F0bh7z9j" id="coordenadas" class='form-control' required>
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">18e) Especialidad a encuestar (Dato obtenido de sus datos de registro en la plataforma <a target="_blank" href="<?= base_url() ?>">REDESLA</a>).</label>
                                <p class="instrucciones">Nota: Si la opción seleccionada no es la que que se registro, favor de notificarlo al equipo <a target="_blank" href="https://wa.link/j7pnld">REDESLA</a></p>
                                <p class="text-danger" id="aviso_especialidad">Si cambia la especialidad su encuesta no se tomará en cuenta, ya que ésta se encuentra asignada al grupo de investigación.</p>
                                <input type="text" name="18f" id="select_18f" class="form-control">
                                <input type="text" name="cambio_especialidad" id="cambio_especialidad" required hidden value="0">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                                <label for="">Especifique la especialidad</label>
                                <input type="text" name="18f_otra" id="input_otra_especialidad" class="form-control">

                            <div>
                            <label for="">18f) Facebook de la escuela</label>
                            <p class="text-primary" style="font-size: 11px;">Ejemplo: https://www.facebook.com/RELEN.LA</p>

                                <input type="text" class="form-control" name="18g" id="18g" required pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">18g) Correo electrónico de la escuela</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: relen@redesla.la</p>
                                <input type="text" class="form-control" name="18h" id="18h" required  pattern="[^@\s]+@[^@\s]+">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">18h) Página de internet de la escuela</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: https://redesla.la/redesla/</p>
                                <input type="text" class="form-control" name="18i" id="18i" required pattern="^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$">
                                <div class="invalid-feedback">
                                    Complete este campo.
                                </div>
                            </div>

                            <div>
                                <label for="">18i) Twitter de la escuela</label>
                                <p class="text-primary" style="font-size: 11px;">Ejemplo: @UserName1</p>
                                <input type="text" class="form-control" name="18j" id="18j" required pattern="(?<=^|(?<=[^a-zA-Z0-9-_\.]))@([A-Za-z]+[A-Za-z0-9-_]+)">
                                <div class="invalid-feedback">
                                    El usuario de Twitter debe contener un @ inicial.
                                </div>
                            </div>

                            <br>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value='Regresar' />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />

                        </fieldset>

                        <fieldset id="field2">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">2da. Parte. Habilidades del docente</h2>
                            <label for="">En la siguiente sección seleccione con qué frecuencia realiza o promueve lo que se menciona en la frase.</label>
                            <table class="table table-striped table-responsive">
                                <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Siempre</th>
                                        <th>Casi siempre</th>
                                        <th>A veces</th>
                                        <th>Casi nunca</th>
                                        <th>Nunca</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">19) Habilidades para favorecer el aprendizaje, la participación y el bienestar de todos los alumnos.</td>
                                    </tr>
                                    <tr>
                                        <td>19a) Desarrolla con sus alumnos actividades de aprendizaje que requieren del esfuerzo y compromiso individual.</td>
                                        <td><input type="radio" name="19a" id="" value="5" required></td>
                                        <td><input type="radio" name="19a" id="" value="4" required></td>
                                        <td><input type="radio" name="19a" id="" value="3" required></td>
                                        <td><input type="radio" name="19a" id="" value="2" required></td>
                                        <td><input type="radio" name="19a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>19b) Utiliza el tiempo escolar en actividades orientadas a la participación de todos los alumnos.</td>
                                        <td><input type="radio" name="19b" id="" value="5" required></td>
                                        <td><input type="radio" name="19b" id="" value="4" required></td>
                                        <td><input type="radio" name="19b" id="" value="3" required></td>
                                        <td><input type="radio" name="19b" id="" value="2" required></td>
                                        <td><input type="radio" name="19b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>19c) Establece una comunicación asertiva y empática, que estimula la participación de sus alumnos en las actividades de aprendizaje, el gusto por aprender y el logro de los propósitos educativos.</td>
                                        <td><input type="radio" name="19c" id="" value="5" required></td>
                                        <td><input type="radio" name="19c" id="" value="4" required></td>
                                        <td><input type="radio" name="19c" id="" value="3" required></td>
                                        <td><input type="radio" name="19c" id="" value="2" required></td>
                                        <td><input type="radio" name="19c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>19d) Utiliza el espacio escolar de manera flexible, teniendo en cuenta las opiniones, características y necesidades de los alumnos.</td>
                                        <td><input type="radio" name="19d" id="" value="5" required></td>
                                        <td><input type="radio" name="19d" id="" value="4" required></td>
                                        <td><input type="radio" name="19d" id="" value="3" required></td>
                                        <td><input type="radio" name="19d" id="" value="2" required></td>
                                        <td><input type="radio" name="19d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">20) Habilidades para utilizar estrategias, actividades y materiales didácticos.</td>
                                    </tr>
                                    <tr>
                                        <td>20a) Utiliza estrategias didácticas variadas, innovadoras, retadoras y flexibles, en el tratamiento de los contenidos y/o desarrollo de las capacidades de los alumnos.</td>
                                        <td><input type="radio" name="20a" id="" value="5" required></td>
                                        <td><input type="radio" name="20a" id="" value="4" required></td>
                                        <td><input type="radio" name="20a" id="" value="3" required></td>
                                        <td><input type="radio" name="20a" id="" value="2" required></td>
                                        <td><input type="radio" name="20a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>20b) Plantea actividades didácticas cercanas a la realidad y contexto, que impliquen indagación, creatividad, pensamiento crítico, colaboración y en las que participen con entusiasmo.</td>
                                        <td><input type="radio" name="20b" id="" value="5" required></td>
                                        <td><input type="radio" name="20b" id="" value="4" required></td>
                                        <td><input type="radio" name="20b" id="" value="3" required></td>
                                        <td><input type="radio" name="20b" id="" value="2" required></td>
                                        <td><input type="radio" name="20b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>20c) Emplea materiales didácticos pertinentes y disponibles, incluidas las tecnologías de la información, comunicación, conocimiento y aprendizaje digital.</td>
                                        <td><input type="radio" name="20c" id="" value="5" required></td>
                                        <td><input type="radio" name="20c" id="" value="4" required></td>
                                        <td><input type="radio" name="20c" id="" value="3" required></td>
                                        <td><input type="radio" name="20c" id="" value="2" required></td>
                                        <td><input type="radio" name="20c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>20d) Considera los saberes de sus alumnos, sus ideas y puntos de vista respecto al contenido a abordar en la construcción o precisión de nuevos aprendizajes.</td>
                                        <td><input type="radio" name="20d" id="" value="5" required></td>
                                        <td><input type="radio" name="20d" id="" value="4" required></td>
                                        <td><input type="radio" name="20d" id="" value="3" required></td>
                                        <td><input type="radio" name="20d" id="" value="2" required></td>
                                        <td><input type="radio" name="20d" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>20e) Realiza ajustes en el desarrollo de las actividades didácticas a partir de los avances y dificultades de los alumnos, para evitar la creación de barreras en su aprendizaje y participación.</td>
                                        <td><input type="radio" name="20e" id="" value="5" required></td>
                                        <td><input type="radio" name="20e" id="" value="4" required></td>
                                        <td><input type="radio" name="20e" id="" value="3" required></td>
                                        <td><input type="radio" name="20e" id="" value="2" required></td>
                                        <td><input type="radio" name="20e" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">21) Habilidades en la construcción de una escuela que tiene una cultura de colaboración.</td>
                                    </tr>
                                    <tr>
                                        <td>21a) Se involucra en actividades de aprendizaje colectivo que contribuyan a profundizar en la comprensión de las <b>políticas educativas</b>.</td>
                                        <td><input type="radio" name="21a" id="" value="5" required></td>
                                        <td><input type="radio" name="21a" id="" value="4" required></td>
                                        <td><input type="radio" name="21a" id="" value="3" required></td>
                                        <td><input type="radio" name="21a" id="" value="2" required></td>
                                        <td><input type="radio" name="21a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>21b) Se involucra en actividades de aprendizaje colectivo, que contribuyan a profundizar en la comprensión de los <b>contenidos de mayor dificultad para los alumnos</b>.</td>
                                        <td><input type="radio" name="21b" id="" value="5" required></td>
                                        <td><input type="radio" name="21b" id="" value="4" required></td>
                                        <td><input type="radio" name="21b" id="" value="3" required></td>
                                        <td><input type="radio" name="21b" id="" value="2" required></td>
                                        <td><input type="radio" name="21b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>21c) Se involucra en actividades de aprendizaje colectivo, que contribuyan a profundizar en la comprensión de <b>temas relevantes para la comunidad escolar</b>.</td>
                                        <td><input type="radio" name="21c" id="" value="5" required></td>
                                        <td><input type="radio" name="21c" id="" value="4" required></td>
                                        <td><input type="radio" name="21c" id="" value="3" required></td>
                                        <td><input type="radio" name="21c" id="" value="2" required></td>
                                        <td><input type="radio" name="21c" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">22) Habilidades para conocer a sus alumnos para desarrollar su quehacer docente de forma pertinente y contextualizada.</td>
                                    </tr>
                                    <tr>
                                        <td>22a) Reconoce los procesos de desarrollo y aprendizaje infantil y adolescente, como base de una docencia centrada en las posibilidades de aprendizaje de sus alumnos.</td>
                                        <td><input type="radio" name="22a" id="" value="5" required></td>
                                        <td><input type="radio" name="22a" id="" value="4" required></td>
                                        <td><input type="radio" name="22a" id="" value="3" required></td>
                                        <td><input type="radio" name="22a" id="" value="2" required></td>
                                        <td><input type="radio" name="22a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>22b) Identifica que los alumnos tienen características, necesidades, formas de actuar y relacionarse, producto de la influencia de su contexto familiar, social y escolar.</td>
                                        <td><input type="radio" name="22b" id="" value="5" required></td>
                                        <td><input type="radio" name="22b" id="" value="4" required></td>
                                        <td><input type="radio" name="22b" id="" value="3" required></td>
                                        <td><input type="radio" name="22b" id="" value="2" required></td>
                                        <td><input type="radio" name="22b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>22c) Comprende la situación de vida de los alumnos y la relación que tiene con su desempeño escolar, para apoyarlos en el logro de sus aprendizajes de manera específica.</td>
                                        <td><input type="radio" name="22c" id="" value="5" required></td>
                                        <td><input type="radio" name="22c" id="" value="4" required></td>
                                        <td><input type="radio" name="22c" id="" value="3" required></td>
                                        <td><input type="radio" name="22c" id="" value="2" required></td>
                                        <td><input type="radio" name="22c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>22d) Valora la diversidad entre sus alumnos, como una oportunidad pedagógica para ampliar y enriquecer las posibilidades de aprendizaje de todos.</td>
                                        <td><input type="radio" name="22d" id="" value="5" required></td>
                                        <td><input type="radio" name="22d" id="" value="4" required></td>
                                        <td><input type="radio" name="22d" id="" value="3" required></td>
                                        <td><input type="radio" name="22d" id="" value="2" required></td>
                                        <td><input type="radio" name="22d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">23) Habilidades para conocer a mis alumnos y brindarles una atención educativa incluyente y equitativa.</td>
                                    </tr>
                                    <tr>
                                        <td>23a) Dialoga con sus alumnos de forma respetuosa y empática, a fin de conocer sus necesidades, intereses y emociones. </td>
                                        <td><input type="radio" name="23a" id="" value="5" required></td>
                                        <td><input type="radio" name="23a" id="" value="4" required></td>
                                        <td><input type="radio" name="23a" id="" value="3" required></td>
                                        <td><input type="radio" name="23a" id="" value="2" required></td>
                                        <td><input type="radio" name="23a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>23b) Observa a sus alumnos en <b>diferentes espacios escolares</b> para entender su comportamiento, formas de interacción y modos de resolución de problemas.</td>
                                        <td><input type="radio" name="23b" id="" value="5" required></td>
                                        <td><input type="radio" name="23b" id="" value="4" required></td>
                                        <td><input type="radio" name="23b" id="" value="3" required></td>
                                        <td><input type="radio" name="23b" id="" value="2" required></td>
                                        <td><input type="radio" name="23b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>23c) Observa a sus alumnos en <b>diferentes momentos de la jornada</b> escolar para entender su comportamiento, formas de interacción y modos de resolución de problemas.</td>
                                        <td><input type="radio" name="23c" id="" value="5" required></td>
                                        <td><input type="radio" name="23c" id="" value="4" required></td>
                                        <td><input type="radio" name="23c" id="" value="3" required></td>
                                        <td><input type="radio" name="23c" id="" value="2" required></td>
                                        <td><input type="radio" name="23c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>23d) Obtiene información acerca de sus alumnos a través de sus familias y otros actores escolares, para enriquecer el conocimiento que tiene de ellos.</td>
                                        <td><input type="radio" name="23d" id="" value="5" required></td>
                                        <td><input type="radio" name="23d" id="" value="4" required></td>
                                        <td><input type="radio" name="23d" id="" value="3" required></td>
                                        <td><input type="radio" name="23d" id="" value="2" required></td>
                                        <td><input type="radio" name="23d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">24) Habilidades para propiciar la participación de todos los alumnos más allá del aula y la escuela.</td>
                                    </tr>
                                    <tr>
                                        <td>24a) Motiva a sus alumnos a participar en las actividades de aprendizaje que implican esfuerzo intelectual, curiosidad y creatividad.</td>
                                        <td><input type="radio" name="24a" id="" value="5" required></td>
                                        <td><input type="radio" name="24a" id="" value="4" required></td>
                                        <td><input type="radio" name="24a" id="" value="3" required></td>
                                        <td><input type="radio" name="24a" id="" value="2" required></td>
                                        <td><input type="radio" name="24a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>24b) Motiva a sus alumnos a enfrentar las dificultades con iniciativa, perseverancia y espíritu crítico.</td>
                                        <td><input type="radio" name="24b" id="" value="5" required></td>
                                        <td><input type="radio" name="24b" id="" value="4" required></td>
                                        <td><input type="radio" name="24b" id="" value="3" required></td>
                                        <td><input type="radio" name="24b" id="" value="2" required></td>
                                        <td><input type="radio" name="24b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>24c) Impulsa la participación de todos los alumnos para favorecer el desarrollo de sus habilidades cognitivas, lingüísticas, socioemocionales y motrices para que alcancen una formación integral.</td>
                                        <td><input type="radio" name="24c" id="" value="5" required></td>
                                        <td><input type="radio" name="24c" id="" value="4" required></td>
                                        <td><input type="radio" name="24c" id="" value="3" required></td>
                                        <td><input type="radio" name="24c" id="" value="2" required></td>
                                        <td><input type="radio" name="24c" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">25) Habilidades para propiciar el aprendizaje de todos los alumnos más allá del aula y la escuela.</td>
                                    </tr>
                                    <tr>
                                        <td>25a) Tiene altas expectativas sobre las capacidades y posibilidades de aprendizaje de todos sus alumnos.</td>
                                        <td><input type="radio" name="25a" id="" value="5" required></td>
                                        <td><input type="radio" name="25a" id="" value="4" required></td>
                                        <td><input type="radio" name="25a" id="" value="3" required></td>
                                        <td><input type="radio" name="25a" id="" value="2" required></td>
                                        <td><input type="radio" name="25a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>25b) Comunica a sus alumnos los propósitos y aprendizajes a lograr para que tengan clara la actividad y orienten su esfuerzo y participación.</td>
                                        <td><input type="radio" name="25b" id="" value="5" required></td>
                                        <td><input type="radio" name="25b" id="" value="4" required></td>
                                        <td><input type="radio" name="25b" id="" value="3" required></td>
                                        <td><input type="radio" name="25b" id="" value="2" required></td>
                                        <td><input type="radio" name="25b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>25c) Estimula a sus alumnos a establecer metas de aprendizaje realistas, que favorezcan el desarrollo de su autonomía, toma de decisiones, compromiso y responsabilidad.</td>
                                        <td><input type="radio" name="25c" id="" value="5" required></td>
                                        <td><input type="radio" name="25c" id="" value="4" required></td>
                                        <td><input type="radio" name="25c" id="" value="3" required></td>
                                        <td><input type="radio" name="25c" id="" value="2" required></td>
                                        <td><input type="radio" name="25c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>25d) Estimula a sus alumnos a establecer metas de aprendizaje realistas, que favorezcan el bienestar personal y el de sus compañeros, familia y comunidad.</td>
                                        <td><input type="radio" name="25d" id="" value="5" required></td>
                                        <td><input type="radio" name="25d" id="" value="4" required></td>
                                        <td><input type="radio" name="25d" id="" value="3" required></td>
                                        <td><input type="radio" name="25d" id="" value="2" required></td>
                                        <td><input type="radio" name="25d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">26) Habilidades para preparar el trabajo pedagógico para lograr que todos los alumnos aprendan.</td>
                                    </tr>
                                    <tr>
                                        <td>26a) Comprende los contenidos de las asignaturas que imparte, de acuerdo al nivel educativo del grupo.</td>
                                        <td><input type="radio" name="26a" id="" value="5" required></td>
                                        <td><input type="radio" name="26a" id="" value="4" required></td>
                                        <td><input type="radio" name="26a" id="" value="3" required></td>
                                        <td><input type="radio" name="26a" id="" value="2" required></td>
                                        <td><input type="radio" name="26a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>26b) Comprende las capacidades fundamentales a desarrollar en sus alumnos según el nivel del grupo.</td>
                                        <td><input type="radio" name="26b" id="" value="5" required></td>
                                        <td><input type="radio" name="26b" id="" value="4" required></td>
                                        <td><input type="radio" name="26b" id="" value="3" required></td>
                                        <td><input type="radio" name="26b" id="" value="2" required></td>
                                        <td><input type="radio" name="26b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>26c) Comprende los enfoques pedagógicos del currículo, según el nivel educativo y las asignaturas del grupo.</td>
                                        <td><input type="radio" name="26c" id="" value="5" required></td>
                                        <td><input type="radio" name="26c" id="" value="4" required></td>
                                        <td><input type="radio" name="26c" id="" value="3" required></td>
                                        <td><input type="radio" name="26c" id="" value="2" required></td>
                                        <td><input type="radio" name="26c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>26d) Comprende los propósitos educativos del currículo, según el nivel educativo y las asignaturas del grupo.</td>
                                        <td><input type="radio" name="26d" id="" value="5" required></td>
                                        <td><input type="radio" name="26d" id="" value="4" required></td>
                                        <td><input type="radio" name="26d" id="" value="3" required></td>
                                        <td><input type="radio" name="26d" id="" value="2" required></td>
                                        <td><input type="radio" name="26d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">27) Habilidades para evaluar de manera permanente el desempeño de los alumnos.</td>
                                    </tr>
                                    <tr>
                                        <td>27a) Realiza un diagnóstico acerca de los saberes, ideas y habilidades con que cuentan sus alumnos, que permite la toma de decisiones orientadas a la mejora de los procesos de enseñanza y aprendizaje.</td>
                                        <td><input type="radio" name="27a" id="" value="5" required></td>
                                        <td><input type="radio" name="27a" id="" value="4" required></td>
                                        <td><input type="radio" name="27a" id="" value="3" required></td>
                                        <td><input type="radio" name="27a" id="" value="2" required></td>
                                        <td><input type="radio" name="27a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>27b) Utiliza estrategias de evaluación diversificadas, permanentes, flexibles y coherentes con los aprendizajes a lograr, las actividades realizadas y las características de sus alumnos.</td>
                                        <td><input type="radio" name="27b" id="" value="5" required></td>
                                        <td><input type="radio" name="27b" id="" value="4" required></td>
                                        <td><input type="radio" name="27b" id="" value="3" required></td>
                                        <td><input type="radio" name="27b" id="" value="2" required></td>
                                        <td><input type="radio" name="27b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>27c) Dialoga con sus alumnos de manera oportuna sobre sus avances y retos, a partir de la información que tiene sobre su desempeño para hacerlos partícipes de su aprendizaje.</td>
                                        <td><input type="radio" name="27c" id="" value="5" required></td>
                                        <td><input type="radio" name="27c" id="" value="4" required></td>
                                        <td><input type="radio" name="27c" id="" value="3" required></td>
                                        <td><input type="radio" name="27c" id="" value="2" required></td>
                                        <td><input type="radio" name="27c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>27d) Analiza la información relativa al logro en los aprendizajes de sus alumnos, identificando los elementos que le permitan reflexionar y mejorar su práctica docente.</td>
                                        <td><input type="radio" name="27d" id="" value="5" required></td>
                                        <td><input type="radio" name="27d" id="" value="4" required></td>
                                        <td><input type="radio" name="27d" id="" value="3" required></td>
                                        <td><input type="radio" name="27d" id="" value="2" required></td>
                                        <td><input type="radio" name="27d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">28) Habilidades de participación en el trabajo de la escuela para el logro de los propósitos educativos.</td>
                                    </tr>
                                    <tr>
                                        <td>28a) Cumple sus responsabilidades conforme a la normativa vigente y en el marco de una escuela que aspira a brindar un servicio educativo incluyente y de excelencia.</td>
                                        <td><input type="radio" name="28a" id="" value="5" required></td>
                                        <td><input type="radio" name="28a" id="" value="4" required></td>
                                        <td><input type="radio" name="28a" id="" value="3" required></td>
                                        <td><input type="radio" name="28a" id="" value="2" required></td>
                                        <td><input type="radio" name="28a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>28b) Colabora en el diseño, implementación y evaluación del programa escolar de mejora continua.</td>
                                        <td><input type="radio" name="28b" id="" value="5" required></td>
                                        <td><input type="radio" name="28b" id="" value="4" required></td>
                                        <td><input type="radio" name="28b" id="" value="3" required></td>
                                        <td><input type="radio" name="28b" id="" value="2" required></td>
                                        <td><input type="radio" name="28b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>28c) Asume responsabilidades en el logro de las metas y objetivos de la escuela.</td>
                                        <td><input type="radio" name="28c" id="" value="5" required></td>
                                        <td><input type="radio" name="28c" id="" value="4" required></td>
                                        <td><input type="radio" name="28c" id="" value="3" required></td>
                                        <td><input type="radio" name="28c" id="" value="2" required></td>
                                        <td><input type="radio" name="28c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>28d) Aporta ideas fundamentadas en su experiencia y conocimientos acerca de los procesos de enseñanza y aprendizaje, para la transformación y mejora del servicio educativo de la escuela.</td>
                                        <td><input type="radio" name="28d" id="" value="5" required></td>
                                        <td><input type="radio" name="28d" id="" value="4" required></td>
                                        <td><input type="radio" name="28d" id="" value="3" required></td>
                                        <td><input type="radio" name="28d" id="" value="2" required></td>
                                        <td><input type="radio" name="28d" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>28e) Aporta ideas fundamentadas en su experiencia y conocimientos acerca de la organización y funcionamiento de la escuela, para la transformación y mejora del servicio educativo de la escuela.</td>
                                        <td><input type="radio" name="28e" id="" value="5" required></td>
                                        <td><input type="radio" name="28e" id="" value="4" required></td>
                                        <td><input type="radio" name="28e" id="" value="3" required></td>
                                        <td><input type="radio" name="28e" id="" value="2" required></td>
                                        <td><input type="radio" name="28e" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">29) Habilidades para involucrar a las familias y a la comunidad en la tarea educativa.</td>
                                    </tr>
                                    <tr>
                                        <td>29a) Utiliza formas de comunicación asertiva con las familias de sus alumnos, que responden a las características de sus contextos culturales, lingüísticos y sociales.</td>
                                        <td><input type="radio" name="29a" id="" value="5" required></td>
                                        <td><input type="radio" name="29a" id="" value="4" required></td>
                                        <td><input type="radio" name="29a" id="" value="3" required></td>
                                        <td><input type="radio" name="29a" id="" value="2" required></td>
                                        <td><input type="radio" name="29a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>29b) Genera espacios y formas diversas de encuentro con las familias que permitan coordinar acciones orientadas a la mejora y el máximo logro de aprendizaje en todos los alumnos.</td>
                                        <td><input type="radio" name="29b" id="" value="5" required></td>
                                        <td><input type="radio" name="29b" id="" value="4" required></td>
                                        <td><input type="radio" name="29b" id="" value="3" required></td>
                                        <td><input type="radio" name="29b" id="" value="2" required></td>
                                        <td><input type="radio" name="29b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>29c) Desarrolla acciones para que las familias sean corresponsables en la tarea educativa escolar, basadas en el respeto, la confianza, equidad, inclusión y convicción de que aportan a los logros de sus hijos.</td>
                                        <td><input type="radio" name="29c" id="" value="5" required></td>
                                        <td><input type="radio" name="29c" id="" value="4" required></td>
                                        <td><input type="radio" name="29c" id="" value="3" required></td>
                                        <td><input type="radio" name="29c" id="" value="2" required></td>
                                        <td><input type="radio" name="29c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>29d) Colabora en actividades que favorecen el intercambio de saberes, valores, normas, culturas y formas de convivencia entre la escuela y la comunidad, y busquen el bienestar común.</td>
                                        <td><input type="radio" name="29d" id="" value="5" required></td>
                                        <td><input type="radio" name="29d" id="" value="4" required></td>
                                        <td><input type="radio" name="29d" id="" value="3" required></td>
                                        <td><input type="radio" name="29d" id="" value="2" required></td>
                                        <td><input type="radio" name="29d" id="" value="1" required></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />
                        </fieldset>

                        <fieldset id="field3">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">3ra. Parte. Herramientas para la enseñanza</h2>
                            <label for="">En la siguiente sección seleccione con qué frecuencia realiza o promueve lo que se menciona en la frase.</label>
                            <table class="table table-striped table-responsive">
                                <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Siempre</th>
                                        <th>Casi siempre</th>
                                        <th>A veces</th>
                                        <th>Casi nunca</th>
                                        <th>Nunca</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">30) El libro de texto como herramienta de enseñanza.</td>
                                    </tr>
                                    <tr>
                                        <td>30a) Las actividades propuestas se apegan al libro de texto, proponiendo actividades en hojas de trabajo.</td>
                                        <td><input type="radio" name="30a" id="" value="5" required></td>
                                        <td><input type="radio" name="30a" id="" value="4" required></td>
                                        <td><input type="radio" name="30a" id="" value="3" required></td>
                                        <td><input type="radio" name="30a" id="" value="2" required></td>
                                        <td><input type="radio" name="30a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>30b) Las actividades propuestas se apegan al libro de texto, proponiendo actividades en y con la familia.</td>
                                        <td><input type="radio" name="30b" id="" value="5" required></td>
                                        <td><input type="radio" name="30b" id="" value="4" required></td>
                                        <td><input type="radio" name="30b" id="" value="3" required></td>
                                        <td><input type="radio" name="30b" id="" value="2" required></td>
                                        <td><input type="radio" name="30b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>30c) Las actividades propuestas se apegan al libro de texto, proponiendo la búsqueda en Internet.</td>
                                        <td><input type="radio" name="30c" id="" value="5" required></td>
                                        <td><input type="radio" name="30c" id="" value="4" required></td>
                                        <td><input type="radio" name="30c" id="" value="3" required></td>
                                        <td><input type="radio" name="30c" id="" value="2" required></td>
                                        <td><input type="radio" name="30c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>30d) Las actividades propuestas se apegan al libro de texto, permitiendo libertad para consultar diversas fuentes.</td>
                                        <td><input type="radio" name="30d" id="" value="5" required></td>
                                        <td><input type="radio" name="30d" id="" value="4" required></td>
                                        <td><input type="radio" name="30d" id="" value="3" required></td>
                                        <td><input type="radio" name="30d" id="" value="2" required></td>
                                        <td><input type="radio" name="30d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">31) Las TIC como herramienta de enseñanza.</td>
                                    </tr>
                                    <tr>
                                        <td>31a) Envía videos explicativos de elaboración propia por mensajería instantánea (WhatsApp, messenger, telegram, entre otros) para apoyar el desarrollo de las actividades.</td>
                                        <td><input type="radio" name="31a" id="" value="5" required></td>
                                        <td><input type="radio" name="31a" id="" value="4" required></td>
                                        <td><input type="radio" name="31a" id="" value="3" required></td>
                                        <td><input type="radio" name="31a" id="" value="2" required></td>
                                        <td><input type="radio" name="31a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>31b) Envía enlaces de videos y tutoriales en plataformas como YouTube o Facebook para apoyar la actividad.</td>
                                        <td><input type="radio" name="31b" id="" value="5" required></td>
                                        <td><input type="radio" name="31b" id="" value="4" required></td>
                                        <td><input type="radio" name="31b" id="" value="3" required></td>
                                        <td><input type="radio" name="31b" id="" value="2" required></td>
                                        <td><input type="radio" name="31b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>31c) Envía grabaciones de audio explicativas por mensajería instantánea (WhatsApp, Messenger, Telegram, entre otros) para apoyar el desarrollo de las actividades.</td>
                                        <td><input type="radio" name="31c" id="" value="5" required></td>
                                        <td><input type="radio" name="31c" id="" value="4" required></td>
                                        <td><input type="radio" name="31c" id="" value="3" required></td>
                                        <td><input type="radio" name="31c" id="" value="2" required></td>
                                        <td><input type="radio" name="31c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>31d) Sugiere páginas de Internet de interés para las actividades programadas.</td>
                                        <td><input type="radio" name="31d" id="" value="5" required></td>
                                        <td><input type="radio" name="31d" id="" value="4" required></td>
                                        <td><input type="radio" name="31d" id="" value="3" required></td>
                                        <td><input type="radio" name="31d" id="" value="2" required></td>
                                        <td><input type="radio" name="31d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">32) Recursos didácticos como herramientas de enseñanza.</td>
                                    </tr>
                                    <tr>
                                        <td>32a) Solicita el libro de texto como único recurso para las actividades a desarrollar.</td>
                                        <td><input type="radio" name="32a" id="" value="5" required></td>
                                        <td><input type="radio" name="32a" id="" value="4" required></td>
                                        <td><input type="radio" name="32a" id="" value="3" required></td>
                                        <td><input type="radio" name="32a" id="" value="2" required></td>
                                        <td><input type="radio" name="32a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>32b) Solicita material costoso para las actividades a desarrollar.</td>
                                        <td><input type="radio" name="32b" id="" value="5" required></td>
                                        <td><input type="radio" name="32b" id="" value="4" required></td>
                                        <td><input type="radio" name="32b" id="" value="3" required></td>
                                        <td><input type="radio" name="32b" id="" value="2" required></td>
                                        <td><input type="radio" name="32b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>32c) Solicita material poco accesible para las actividades a desarrollar.</td>
                                        <td><input type="radio" name="32c" id="" value="5" required></td>
                                        <td><input type="radio" name="32c" id="" value="4" required></td>
                                        <td><input type="radio" name="32c" id="" value="3" required></td>
                                        <td><input type="radio" name="32c" id="" value="2" required></td>
                                        <td><input type="radio" name="32c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>32d) Solicita material accesible para las actividades a desarrollar.</td>
                                        <td><input type="radio" name="32d" id="" value="5" required></td>
                                        <td><input type="radio" name="32d" id="" value="4" required></td>
                                        <td><input type="radio" name="32d" id="" value="3" required></td>
                                        <td><input type="radio" name="32d" id="" value="2" required></td>
                                        <td><input type="radio" name="32d" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>32e) Solicita material de bajo costo para las actividades a desarrollar.</td>
                                        <td><input type="radio" name="32e" id="" value="5" required></td>
                                        <td><input type="radio" name="32e" id="" value="4" required></td>
                                        <td><input type="radio" name="32e" id="" value="3" required></td>
                                        <td><input type="radio" name="32e" id="" value="2" required></td>
                                        <td><input type="radio" name="32e" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>32f) Solicita material de reúso para las actividades a desarrollar.</td>
                                        <td><input type="radio" name="32f" id="" value="5" required></td>
                                        <td><input type="radio" name="32f" id="" value="4" required></td>
                                        <td><input type="radio" name="32f" id="" value="3" required></td>
                                        <td><input type="radio" name="32f" id="" value="2" required></td>
                                        <td><input type="radio" name="32f" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>32g) Solicita materiales del hogar para las actividades a desarrollar.</td>
                                        <td><input type="radio" name="32g" id="" value="5" required></td>
                                        <td><input type="radio" name="32g" id="" value="4" required></td>
                                        <td><input type="radio" name="32g" id="" value="3" required></td>
                                        <td><input type="radio" name="32g" id="" value="2" required></td>
                                        <td><input type="radio" name="32g" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>32h) Solicita materiales atractivos para las actividades a desarrollar.</td>
                                        <td><input type="radio" name="32h" id="" value="5" required></td>
                                        <td><input type="radio" name="32h" id="" value="4" required></td>
                                        <td><input type="radio" name="32h" id="" value="3" required></td>
                                        <td><input type="radio" name="32h" id="" value="2" required></td>
                                        <td><input type="radio" name="32h" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>32i) Trabaja sin solicitar recursos para las actividades a desarrollar</td>
                                        <td><input type="radio" name="32i" id="" value="5" required></td>
                                        <td><input type="radio" name="32i" id="" value="4" required></td>
                                        <td><input type="radio" name="32i" id="" value="3" required></td>
                                        <td><input type="radio" name="32i" id="" value="2" required></td>
                                        <td><input type="radio" name="32i" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">33) Evaluación de las actividades como herramientas de enseñanza.</td>
                                    </tr>
                                    <tr>
                                        <td>33a) Los criterios de la evaluación están basados en lo programado en las actividades enviadas.</td>
                                        <td><input type="radio" name="33a" id="" value="5" required></td>
                                        <td><input type="radio" name="33a" id="" value="4" required></td>
                                        <td><input type="radio" name="33a" id="" value="3" required></td>
                                        <td><input type="radio" name="33a" id="" value="2" required></td>
                                        <td><input type="radio" name="33a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>33b) Los criterios de la evaluación están basados en el cumplimiento de las actividades.</td>
                                        <td><input type="radio" name="33b" id="" value="5" required></td>
                                        <td><input type="radio" name="33b" id="" value="4" required></td>
                                        <td><input type="radio" name="33b" id="" value="3" required></td>
                                        <td><input type="radio" name="33b" id="" value="2" required></td>
                                        <td><input type="radio" name="33b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>33c) Los criterios de la evaluación están basados en la calidad del trabajo desarrollado.</td>
                                        <td><input type="radio" name="33c" id="" value="5" required></td>
                                        <td><input type="radio" name="33c" id="" value="4" required></td>
                                        <td><input type="radio" name="33c" id="" value="3" required></td>
                                        <td><input type="radio" name="33c" id="" value="2" required></td>
                                        <td><input type="radio" name="33c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>33d) Los criterios de la evaluación están basados en los tiempos de entrega programados.</td>
                                        <td><input type="radio" name="33d" id="" value="5" required></td>
                                        <td><input type="radio" name="33d" id="" value="4" required></td>
                                        <td><input type="radio" name="33d" id="" value="3" required></td>
                                        <td><input type="radio" name="33d" id="" value="2" required></td>
                                        <td><input type="radio" name="33d" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>33e) Los criterios de la evaluación están basados en los aciertos y errores del trabajo desarrollado.</td>
                                        <td><input type="radio" name="33e" id="" value="5" required></td>
                                        <td><input type="radio" name="33e" id="" value="4" required></td>
                                        <td><input type="radio" name="33e" id="" value="3" required></td>
                                        <td><input type="radio" name="33e" id="" value="2" required></td>
                                        <td><input type="radio" name="33e" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">34) Revisión de las actividades como recurso de comunicación y de aprendizaje.</td>
                                    </tr>
                                    <tr>
                                        <td>34a) Regresa los trabajos revisados sin oportunidad de corrección.</td>
                                        <td><input type="radio" name="34a" id="" value="5" required></td>
                                        <td><input type="radio" name="34a" id="" value="4" required></td>
                                        <td><input type="radio" name="34a" id="" value="3" required></td>
                                        <td><input type="radio" name="34a" id="" value="2" required></td>
                                        <td><input type="radio" name="34a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>34b) Regresa los trabajos revisados, en los primeros 3 días después de su entrega.</td>
                                        <td><input type="radio" name="34b" id="" value="5" required></td>
                                        <td><input type="radio" name="34b" id="" value="4" required></td>
                                        <td><input type="radio" name="34b" id="" value="3" required></td>
                                        <td><input type="radio" name="34b" id="" value="2" required></td>
                                        <td><input type="radio" name="34b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>34c) Regresa los trabajos revisados, durante la siguiente semana de su entrega.</td>
                                        <td><input type="radio" name="34c" id="" value="5" required></td>
                                        <td><input type="radio" name="34c" id="" value="4" required></td>
                                        <td><input type="radio" name="34c" id="" value="3" required></td>
                                        <td><input type="radio" name="34c" id="" value="2" required></td>
                                        <td><input type="radio" name="34c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>34d) Regresa los trabajos revisados.</td>
                                        <td><input type="radio" name="34d" id="" value="5" required></td>
                                        <td><input type="radio" name="34d" id="" value="4" required></td>
                                        <td><input type="radio" name="34d" id="" value="3" required></td>
                                        <td><input type="radio" name="34d" id="" value="2" required></td>
                                        <td><input type="radio" name="34d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">35) Asesoría académica como herramienta de enseñanza.</td>
                                    </tr>
                                    <tr>
                                        <td>35a) Atiende de manera individual las preguntas llegadas a los grupos de WhatsApp, Telegram o Messenger.</td>
                                        <td><input type="radio" name="35a" id="" value="5" required></td>
                                        <td><input type="radio" name="35a" id="" value="4" required></td>
                                        <td><input type="radio" name="35a" id="" value="3" required></td>
                                        <td><input type="radio" name="35a" id="" value="2" required></td>
                                        <td><input type="radio" name="35a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>35b) Atiende las dudas presentadas por el estudiante mediante llamada telefónica.</td>
                                        <td><input type="radio" name="35b" id="" value="5" required></td>
                                        <td><input type="radio" name="35b" id="" value="4" required></td>
                                        <td><input type="radio" name="35b" id="" value="3" required></td>
                                        <td><input type="radio" name="35b" id="" value="2" required></td>
                                        <td><input type="radio" name="35b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>35d) Busca comunicarse con el estudiante cuando deja de asistir a clases o de mandar actividades.</td>
                                        <td><input type="radio" name="35c" id="" value="5" required></td>
                                        <td><input type="radio" name="35c" id="" value="4" required></td>
                                        <td><input type="radio" name="35c" id="" value="3" required></td>
                                        <td><input type="radio" name="35c" id="" value="2" required></td>
                                        <td><input type="radio" name="35c" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">36) Las Tecnologías de Empoderamiento y la Participación (TEP) como herramienta de enseñanza.</td>
                                    </tr>
                                    <tr>
                                        <td>36a) Utiliza Google Classroom o Moodle o alguna plataforma similar para organizar las actividades.</td>
                                        <td><input type="radio" name="36a" id="" value="5" required></td>
                                        <td><input type="radio" name="36a" id="" value="4" required></td>
                                        <td><input type="radio" name="36a" id="" value="3" required></td>
                                        <td><input type="radio" name="36a" id="" value="2" required></td>
                                        <td><input type="radio" name="36a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>36b) Utiliza grupos cerrados de Facebook para organizar las actividades.</td>
                                        <td><input type="radio" name="36b" id="" value="5" required></td>
                                        <td><input type="radio" name="36b" id="" value="4" required></td>
                                        <td><input type="radio" name="36b" id="" value="3" required></td>
                                        <td><input type="radio" name="36b" id="" value="2" required></td>
                                        <td><input type="radio" name="36b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>36c)  Utiliza Wikis para organizar las actividades.</td>
                                        <td><input type="radio" name="36c" id="" value="5" required></td>
                                        <td><input type="radio" name="36c" id="" value="4" required></td>
                                        <td><input type="radio" name="36c" id="" value="3" required></td>
                                        <td><input type="radio" name="36c" id="" value="2" required></td>
                                        <td><input type="radio" name="36c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>36d) Utiliza un canal de YouTube propio para organizar las actividades.</td>
                                        <td><input type="radio" name="36d" id="" value="5" required></td>
                                        <td><input type="radio" name="36d" id="" value="4" required></td>
                                        <td><input type="radio" name="36d" id="" value="3" required></td>
                                        <td><input type="radio" name="36d" id="" value="2" required></td>
                                        <td><input type="radio" name="36d" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>36e) Utiliza WhatsApp, Telegram, Messenger, para organizar las actividades.</td>
                                        <td><input type="radio" name="36e" id="" value="5" required></td>
                                        <td><input type="radio" name="36e" id="" value="4" required></td>
                                        <td><input type="radio" name="36e" id="" value="3" required></td>
                                        <td><input type="radio" name="36e" id="" value="2" required></td>
                                        <td><input type="radio" name="36e" id="" value="1" required></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />
                        </fieldset>

                        <fieldset id="field4">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">4ta. Parte. Metacognición</h2>
                            <label for="">En la siguiente sección seleccione con qué frecuencia realiza o promueve lo que se menciona en la frase.</label>
                            <table class="table table-striped table-responsive">
                                <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Siempre</th>
                                        <th>Casi siempre</th>
                                        <th>A veces</th>
                                        <th>Casi nunca</th>
                                        <th>Nunca</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">37) Medida en que usted: </td>
                                    </tr>
                                    <tr>
                                        <td>37a) Quiere seguir aprendiendo sin la necesidad de una gratificación.</td>
                                        <td><input type="radio" name="37a" id="" value="5" required></td>
                                        <td><input type="radio" name="37a" id="" value="4" required></td>
                                        <td><input type="radio" name="37a" id="" value="3" required></td>
                                        <td><input type="radio" name="37a" id="" value="2" required></td>
                                        <td><input type="radio" name="37a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>37b) Se propone algo y es capaz de cumplirlo.</td>
                                        <td><input type="radio" name="37b" id="" value="5" required></td>
                                        <td><input type="radio" name="37b" id="" value="4" required></td>
                                        <td><input type="radio" name="37b" id="" value="3" required></td>
                                        <td><input type="radio" name="37b" id="" value="2" required></td>
                                        <td><input type="radio" name="37b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>37c) Es constante en sus estudios. </td>
                                        <td><input type="radio" name="37c" id="" value="5" required></td>
                                        <td><input type="radio" name="37c" id="" value="4" required></td>
                                        <td><input type="radio" name="37c" id="" value="3" required></td>
                                        <td><input type="radio" name="37c" id="" value="2" required></td>
                                        <td><input type="radio" name="37c" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">38) Grado en el que logra los siguientes elementos</td>
                                    </tr>
                                    <tr>
                                        <td>38a) Lee rápido y sin equivocarse.</td>
                                        <td><input type="radio" name="38a" id="" value="5" required></td>
                                        <td><input type="radio" name="38a" id="" value="4" required></td>
                                        <td><input type="radio" name="38a" id="" value="3" required></td>
                                        <td><input type="radio" name="38a" id="" value="2" required></td>
                                        <td><input type="radio" name="38a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>38b) Aprende palabras nuevas.</td>
                                        <td><input type="radio" name="38b" id="" value="5" required></td>
                                        <td><input type="radio" name="38b" id="" value="4" required></td>
                                        <td><input type="radio" name="38b" id="" value="3" required></td>
                                        <td><input type="radio" name="38b" id="" value="2" required></td>
                                        <td><input type="radio" name="38b" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">39) Nivel en el que consigue aplicar las siguientes facultades cognitivas</td>
                                    </tr>
                                    <tr>
                                        <td>39a) Capta y entiende nueva información.</td>
                                        <td><input type="radio" name="39a" id="" value="5" required></td>
                                        <td><input type="radio" name="39a" id="" value="4" required></td>
                                        <td><input type="radio" name="39a" id="" value="3" required></td>
                                        <td><input type="radio" name="39a" id="" value="2" required></td>
                                        <td><input type="radio" name="39a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>39b) Se enfoca en una cosa y no se distrae.</td>
                                        <td><input type="radio" name="39b" id="" value="5" required></td>
                                        <td><input type="radio" name="39b" id="" value="4" required></td>
                                        <td><input type="radio" name="39b" id="" value="3" required></td>
                                        <td><input type="radio" name="39b" id="" value="2" required></td>
                                        <td><input type="radio" name="39b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>39c) Recuerda hechos pasados.</td>
                                        <td><input type="radio" name="39c" id="" value="5" required></td>
                                        <td><input type="radio" name="39c" id="" value="4" required></td>
                                        <td><input type="radio" name="39c" id="" value="3" required></td>
                                        <td><input type="radio" name="39c" id="" value="2" required></td>
                                        <td><input type="radio" name="39c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>39d) Observa todo lo que le rodea.</td>
                                        <td><input type="radio" name="39d" id="" value="5" required></td>
                                        <td><input type="radio" name="39d" id="" value="4" required></td>
                                        <td><input type="radio" name="39d" id="" value="3" required></td>
                                        <td><input type="radio" name="39d" id="" value="2" required></td>
                                        <td><input type="radio" name="39d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">40) Medida en que practica los siguientes procesos metacognitivos</td>
                                    </tr>
                                    <tr>
                                        <td>40a) Lee rápido cuando es algo simple y con más atención cuando es algo más complicado.</td>
                                        <td><input type="radio" name="40a" id="" value="5" required></td>
                                        <td><input type="radio" name="40a" id="" value="4" required></td>
                                        <td><input type="radio" name="40a" id="" value="3" required></td>
                                        <td><input type="radio" name="40a" id="" value="2" required></td>
                                        <td><input type="radio" name="40a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>40b) Tiene claro cuando ha comprendido algo y cuando no.</td>
                                        <td><input type="radio" name="40b" id="" value="5" required></td>
                                        <td><input type="radio" name="40b" id="" value="4" required></td>
                                        <td><input type="radio" name="40b" id="" value="3" required></td>
                                        <td><input type="radio" name="40b" id="" value="2" required></td>
                                        <td><input type="radio" name="40b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>40c) Sabe a qué le debe de prestar más atención e ignorar lo que no es tan importante.</td>
                                        <td><input type="radio" name="40c" id="" value="5" required></td>
                                        <td><input type="radio" name="40c" id="" value="4" required></td>
                                        <td><input type="radio" name="40c" id="" value="3" required></td>
                                        <td><input type="radio" name="40c" id="" value="2" required></td>
                                        <td><input type="radio" name="40c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>40d) Reconoce que se le facilita más recordar (números, rostros, nombres).</td>
                                        <td><input type="radio" name="40d" id="" value="5" required></td>
                                        <td><input type="radio" name="40d" id="" value="4" required></td>
                                        <td><input type="radio" name="40d" id="" value="3" required></td>
                                        <td><input type="radio" name="40d" id="" value="2" required></td>
                                        <td><input type="radio" name="40d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">41) Medida en la que realiza los siguientes pasos del proceso cognitivos</td>
                                    </tr>
                                    <tr>
                                        <td>41a) Conoce la manera en que aprende mejor.</td>
                                        <td><input type="radio" name="41a" id="" value="5" required></td>
                                        <td><input type="radio" name="41a" id="" value="4" required></td>
                                        <td><input type="radio" name="41a" id="" value="3" required></td>
                                        <td><input type="radio" name="41a" id="" value="2" required></td>
                                        <td><input type="radio" name="41a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>41b) Planifica (prepara o indica qué realizará para resolver un problema y cómo).</td>
                                        <td><input type="radio" name="41b" id="" value="5" required></td>
                                        <td><input type="radio" name="41b" id="" value="4" required></td>
                                        <td><input type="radio" name="41b" id="" value="3" required></td>
                                        <td><input type="radio" name="41b" id="" value="2" required></td>
                                        <td><input type="radio" name="41b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>41c) Revisa que está siguiendo los pasos que planificó.</td>
                                        <td><input type="radio" name="41c" id="" value="5" required></td>
                                        <td><input type="radio" name="41c" id="" value="4" required></td>
                                        <td><input type="radio" name="41c" id="" value="3" required></td>
                                        <td><input type="radio" name="41c" id="" value="2" required></td>
                                        <td><input type="radio" name="41c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>41d) Evalúa los resultados para identificar un posible error y corregirlo.</td>
                                        <td><input type="radio" name="41d" id="" value="5" required></td>
                                        <td><input type="radio" name="41d" id="" value="4" required></td>
                                        <td><input type="radio" name="41d" id="" value="3" required></td>
                                        <td><input type="radio" name="41d" id="" value="2" required></td>
                                        <td><input type="radio" name="41d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">42) Medida en la que pone en práctica las siguientes habilidades metacognitivas</td>
                                    </tr>
                                    <tr>
                                        <td>42a) Reconoce cuál es la manera en la que aprende mejor (escuchando, viendo o con material).</td>
                                        <td><input type="radio" name="42a" id="" value="5" required></td>
                                        <td><input type="radio" name="42a" id="" value="4" required></td>
                                        <td><input type="radio" name="42a" id="" value="3" required></td>
                                        <td><input type="radio" name="42a" id="" value="2" required></td>
                                        <td><input type="radio" name="42a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>42b) Comparte oralmente lo que piensa del tema de la clase.</td>
                                        <td><input type="radio" name="42b" id="" value="5" required></td>
                                        <td><input type="radio" name="42b" id="" value="4" required></td>
                                        <td><input type="radio" name="42b" id="" value="3" required></td>
                                        <td><input type="radio" name="42b" id="" value="2" required></td>
                                        <td><input type="radio" name="42b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>42c) Sabe cuál es la meta a la que debe de llegar al resolver una situación.</td>
                                        <td><input type="radio" name="42c" id="" value="5" required></td>
                                        <td><input type="radio" name="42c" id="" value="4" required></td>
                                        <td><input type="radio" name="42c" id="" value="3" required></td>
                                        <td><input type="radio" name="42c" id="" value="2" required></td>
                                        <td><input type="radio" name="42c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>42d) Representa la información de un texto de manera que sea entendible (por medio de mapas mentales, cuadros sinópticos etc.).</td>
                                        <td><input type="radio" name="42d" id="" value="5" required></td>
                                        <td><input type="radio" name="42d" id="" value="4" required></td>
                                        <td><input type="radio" name="42d" id="" value="3" required></td>
                                        <td><input type="radio" name="42d" id="" value="2" required></td>
                                        <td><input type="radio" name="42d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">43) Grado en el que se identifica con las siguientes características de la mentalidad de crecimiento</td>
                                    </tr>
                                    <tr>
                                        <td>43a) Cree que la inteligencia es algo que depende del esfuerzo que pone al estudiar.</td>
                                        <td><input type="radio" name="43a" id="" value="5" required></td>
                                        <td><input type="radio" name="43a" id="" value="4" required></td>
                                        <td><input type="radio" name="43a" id="" value="3" required></td>
                                        <td><input type="radio" name="43a" id="" value="2" required></td>
                                        <td><input type="radio" name="43a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>43b) Ve la escuela como un lugar en que aprende cosas nuevas.</td>
                                        <td><input type="radio" name="43b" id="" value="5" required></td>
                                        <td><input type="radio" name="43b" id="" value="4" required></td>
                                        <td><input type="radio" name="43b" id="" value="3" required></td>
                                        <td><input type="radio" name="43b" id="" value="2" required></td>
                                        <td><input type="radio" name="43b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>43c) Para ser mejor en algo tiene que practicar mucho.</td>
                                        <td><input type="radio" name="43c" id="" value="5" required></td>
                                        <td><input type="radio" name="43c" id="" value="4" required></td>
                                        <td><input type="radio" name="43c" id="" value="3" required></td>
                                        <td><input type="radio" name="43c" id="" value="2" required></td>
                                        <td><input type="radio" name="43c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>43d) Realiza sus deberes para ser mejor, no para obtener un premio.</td>
                                        <td><input type="radio" name="43d" id="" value="5" required></td>
                                        <td><input type="radio" name="43d" id="" value="4" required></td>
                                        <td><input type="radio" name="43d" id="" value="3" required></td>
                                        <td><input type="radio" name="43d" id="" value="2" required></td>
                                        <td><input type="radio" name="43d" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>43e) Le gustan los retos difíciles y se esfuerza por resolverlo.</td>
                                        <td><input type="radio" name="43e" id="" value="5" required></td>
                                        <td><input type="radio" name="43e" id="" value="4" required></td>
                                        <td><input type="radio" name="43e" id="" value="3" required></td>
                                        <td><input type="radio" name="43e" id="" value="2" required></td>
                                        <td><input type="radio" name="43e" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">44) Cuando leo algo</td>
                                    </tr>
                                    <tr>
                                        <td>44a) Repite exactamente lo que dice el texto.</td>
                                        <td><input type="radio" name="44a" id="" value="5" required></td>
                                        <td><input type="radio" name="44a" id="" value="4" required></td>
                                        <td><input type="radio" name="44a" id="" value="3" required></td>
                                        <td><input type="radio" name="44a" id="" value="2" required></td>
                                        <td><input type="radio" name="44a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>44b) Comprende e interprete lo que lee.</td>
                                        <td><input type="radio" name="44b" id="" value="5" required></td>
                                        <td><input type="radio" name="44b" id="" value="4" required></td>
                                        <td><input type="radio" name="44b" id="" value="3" required></td>
                                        <td><input type="radio" name="44b" id="" value="2" required></td>
                                        <td><input type="radio" name="44b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>44c) Entiende cuál es la razón por la cuál se escribió el texto.</td>
                                        <td><input type="radio" name="44c" id="" value="5" required></td>
                                        <td><input type="radio" name="44c" id="" value="4" required></td>
                                        <td><input type="radio" name="44c" id="" value="3" required></td>
                                        <td><input type="radio" name="44c" id="" value="2" required></td>
                                        <td><input type="radio" name="44c" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">45) Grado en el que muestra los siguientes aspectos de la mentalidad de crecimiento</td>
                                    </tr>
                                    <tr>
                                        <td>45a) Genera una opinión de lo que sabe, de acuerdo a toda la información que le rodea.</td>
                                        <td><input type="radio" name="45a" id="" value="5" required></td>
                                        <td><input type="radio" name="45a" id="" value="4" required></td>
                                        <td><input type="radio" name="45a" id="" value="3" required></td>
                                        <td><input type="radio" name="45a" id="" value="2" required></td>
                                        <td><input type="radio" name="45a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>45b) Comparte su opinión sin dañar a sus compañeros.</td>
                                        <td><input type="radio" name="45b" id="" value="5" required></td>
                                        <td><input type="radio" name="45b" id="" value="4" required></td>
                                        <td><input type="radio" name="45b" id="" value="3" required></td>
                                        <td><input type="radio" name="45b" id="" value="2" required></td>
                                        <td><input type="radio" name="45b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>45c) Entiende las distintas maneras de pensar de sus compañeros.</td>
                                        <td><input type="radio" name="45c" id="" value="5" required></td>
                                        <td><input type="radio" name="45c" id="" value="4" required></td>
                                        <td><input type="radio" name="45c" id="" value="3" required></td>
                                        <td><input type="radio" name="45c" id="" value="2" required></td>
                                        <td><input type="radio" name="45c" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>45d) Se esfuerza para llegar a la meta sin importar los problemas a los que se enfrenta.</td>
                                        <td><input type="radio" name="45d" id="" value="5" required></td>
                                        <td><input type="radio" name="45d" id="" value="4" required></td>
                                        <td><input type="radio" name="45d" id="" value="3" required></td>
                                        <td><input type="radio" name="45d" id="" value="2" required></td>
                                        <td><input type="radio" name="45d" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">46) Medida en que las siguientes actividades le impulsan a seguir aprendiendo</td>
                                    </tr>
                                    <tr>
                                        <td>46a) Se dice que ha realizado un buen trabajo.</td>
                                        <td><input type="radio" name="46a" id="" value="5" required></td>
                                        <td><input type="radio" name="46a" id="" value="4" required></td>
                                        <td><input type="radio" name="46a" id="" value="3" required></td>
                                        <td><input type="radio" name="46a" id="" value="2" required></td>
                                        <td><input type="radio" name="46a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>46b) No se fija en su resultado, sino en su esfuerzo a pesar de que se equivocó.</td>
                                        <td><input type="radio" name="46b" id="" value="5" required></td>
                                        <td><input type="radio" name="46b" id="" value="4" required></td>
                                        <td><input type="radio" name="46b" id="" value="3" required></td>
                                        <td><input type="radio" name="46b" id="" value="2" required></td>
                                        <td><input type="radio" name="46b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>46c) Se dice que puede hacerlo mejor y se ayuda a lograrlo.</td>
                                        <td><input type="radio" name="46c" id="" value="5" required></td>
                                        <td><input type="radio" name="46c" id="" value="4" required></td>
                                        <td><input type="radio" name="46c" id="" value="3" required></td>
                                        <td><input type="radio" name="46c" id="" value="2" required></td>
                                        <td><input type="radio" name="46c" id="" value="1" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Siempre</th>
                                            <th>Casi siempre</th>
                                            <th>A veces</th>
                                            <th>Casi nunca</th>
                                            <th>Nunca</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td colspan="6" class="table-warning text-center">47) Nivel en que realiza los siguientes métodos de evaluación</td>
                                    </tr>
                                    <tr>
                                        <td>47a) Retroalimentación (mis compañeros expresan opiniones de las áreas de mejora).</td>
                                        <td><input type="radio" name="47a" id="" value="5" required></td>
                                        <td><input type="radio" name="47a" id="" value="4" required></td>
                                        <td><input type="radio" name="47a" id="" value="3" required></td>
                                        <td><input type="radio" name="47a" id="" value="2" required></td>
                                        <td><input type="radio" name="47a" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>47b) Autoevaluación (evalúo los resultados y señalo los puntos que se pueden mejorar).</td>
                                        <td><input type="radio" name="47b" id="" value="5" required></td>
                                        <td><input type="radio" name="47b" id="" value="4" required></td>
                                        <td><input type="radio" name="47b" id="" value="3" required></td>
                                        <td><input type="radio" name="47b" id="" value="2" required></td>
                                        <td><input type="radio" name="47b" id="" value="1" required></td>
                                    </tr>
                                    <tr>
                                        <td>47c) Evaluación entre pares (entre mis compañeros y yo detectamos qué es lo que está correcto y qué se puede mejorar).</td>
                                        <td><input type="radio" name="47c" id="" value="5" required></td>
                                        <td><input type="radio" name="47c" id="" value="4" required></td>
                                        <td><input type="radio" name="47c" id="" value="3" required></td>
                                        <td><input type="radio" name="47c" id="" value="2" required></td>
                                        <td><input type="radio" name="47c" id="" value="1" required></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                            <input type="button" name="next" class="next btn btn-block" value="Siguiente" />
                        </fieldset>

                        <fieldset id="field5">
                            <input type="button" name="previous" class="previous btn btn-danger previousTop" value="Regresar" />
                            <h2 class="text-center">5ta. Parte. Herramientas</h2>
                            <label for="">En la siguiente sección seleccione con qué frecuencia realiza o promueve lo que se menciona en la frase.</label>
                            <table class="table table-striped table-responsive text-left">
                                <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Diario</th>
                                        <th>Al menos 1 vez a la semana</th>
                                        <th>Al menos 1 vez al mes</th>
                                        <th>Al menos 1 vez al año</th>
                                        <th>Casi nunca o nunca</th>
                                        <th>No tengo acceso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="table-warning text-center">48) ¿Cuál es el equipo electrónico que más utiliza para sus actividades profesionales?</td>
                                    </tr>
                                    <tr>
                                        <td>48a) Computadora o Laptop.</td>
                                        <td><input type="radio" name="48a" id="" value="5" required></td>
                                        <td><input type="radio" name="48a" id="" value="4" required></td>
                                        <td><input type="radio" name="48a" id="" value="3" required></td>
                                        <td><input type="radio" name="48a" id="" value="2" required></td>
                                        <td><input type="radio" name="48a" id="" value="1" required></td>
                                        <td><input type="radio" name="48a" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>48b) Tableta Electrónica.</td>
                                        <td><input type="radio" name="48b" id="" value="5" required></td>
                                        <td><input type="radio" name="48b" id="" value="4" required></td>
                                        <td><input type="radio" name="48b" id="" value="3" required></td>
                                        <td><input type="radio" name="48b" id="" value="2" required></td>
                                        <td><input type="radio" name="48b" id="" value="1" required></td>
                                        <td><input type="radio" name="48b" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>48c) Aparato celular o teléfono.</td>
                                        <td><input type="radio" name="48c" id="" value="5" required></td>
                                        <td><input type="radio" name="48c" id="" value="4" required></td>
                                        <td><input type="radio" name="48c" id="" value="3" required></td>
                                        <td><input type="radio" name="48c" id="" value="2" required></td>
                                        <td><input type="radio" name="48c" id="" value="1" required></td>
                                        <td><input type="radio" name="48c" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>48d) Televisión.</td>
                                        <td><input type="radio" name="48d" id="" value="5" required></td>
                                        <td><input type="radio" name="48d" id="" value="4" required></td>
                                        <td><input type="radio" name="48d" id="" value="3" required></td>
                                        <td><input type="radio" name="48d" id="" value="2" required></td>
                                        <td><input type="radio" name="48d" id="" value="1" required></td>
                                        <td><input type="radio" name="48d" id="" value="0" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Diario</th>
                                        <th>Al menos 1 vez a la semana</th>
                                        <th>Al menos 1 vez al mes</th>
                                        <th>Al menos 1 vez al año</th>
                                        <th>Casi nunca o nunca</th>
                                        <th>No tengo acceso</th>
                                    </tr>
                                </thead>
                                    <tr>
                                        <td colspan="7" class="table-warning text-center">49) ¿Qué tipo de actividad deja más cómo tarea?</td>
                                    </tr>
                                    <tr>
                                        <td>49a) Ejercicios o problemas.</td>
                                        <td><input type="radio" name="49a" id="" value="5" required></td>
                                        <td><input type="radio" name="49a" id="" value="4" required></td>
                                        <td><input type="radio" name="49a" id="" value="3" required></td>
                                        <td><input type="radio" name="49a" id="" value="2" required></td>
                                        <td><input type="radio" name="49a" id="" value="1" required></td>
                                        <td><input type="radio" name="49a" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>49b) Escritura de planas.</td>
                                        <td><input type="radio" name="49b" id="" value="5" required></td>
                                        <td><input type="radio" name="49b" id="" value="4" required></td>
                                        <td><input type="radio" name="49b" id="" value="3" required></td>
                                        <td><input type="radio" name="49b" id="" value="2" required></td>
                                        <td><input type="radio" name="49b" id="" value="1" required></td>
                                        <td><input type="radio" name="49b" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>49c) Resolución de casos reales.</td>
                                        <td><input type="radio" name="49c" id="" value="5" required></td>
                                        <td><input type="radio" name="49c" id="" value="4" required></td>
                                        <td><input type="radio" name="49c" id="" value="3" required></td>
                                        <td><input type="radio" name="49c" id="" value="2" required></td>
                                        <td><input type="radio" name="49c" id="" value="1" required></td>
                                        <td><input type="radio" name="49c" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>49d) Resolución de cuestionarios.</td>
                                        <td><input type="radio" name="49d" id="" value="5" required></td>
                                        <td><input type="radio" name="49d" id="" value="4" required></td>
                                        <td><input type="radio" name="49d" id="" value="3" required></td>
                                        <td><input type="radio" name="49d" id="" value="2" required></td>
                                        <td><input type="radio" name="49d" id="" value="1" required></td>
                                        <td><input type="radio" name="49d" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>49e) Elaboración de ensayos.</td>
                                        <td><input type="radio" name="49e" id="" value="5" required></td>
                                        <td><input type="radio" name="49e" id="" value="4" required></td>
                                        <td><input type="radio" name="49e" id="" value="3" required></td>
                                        <td><input type="radio" name="49e" id="" value="2" required></td>
                                        <td><input type="radio" name="49e" id="" value="1" required></td>
                                        <td><input type="radio" name="49e" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>49f) Elaboración de resúmenes.</td>
                                        <td><input type="radio" name="49f" id="" value="5" required></td>
                                        <td><input type="radio" name="49f" id="" value="4" required></td>
                                        <td><input type="radio" name="49f" id="" value="3" required></td>
                                        <td><input type="radio" name="49f" id="" value="2" required></td>
                                        <td><input type="radio" name="49f" id="" value="1" required></td>
                                        <td><input type="radio" name="49f" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>49g) Elaboración de dibujos.</td>
                                        <td><input type="radio" name="49g" id="" value="5" required></td>
                                        <td><input type="radio" name="49g" id="" value="4" required></td>
                                        <td><input type="radio" name="49g" id="" value="3" required></td>
                                        <td><input type="radio" name="49g" id="" value="2" required></td>
                                        <td><input type="radio" name="49g" id="" value="1" required></td>
                                        <td><input type="radio" name="49g" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>49h) Elaboración y participación en obras de teatro.</td>
                                        <td><input type="radio" name="49h" id="" value="5" required></td>
                                        <td><input type="radio" name="49h" id="" value="4" required></td>
                                        <td><input type="radio" name="49h" id="" value="3" required></td>
                                        <td><input type="radio" name="49h" id="" value="2" required></td>
                                        <td><input type="radio" name="49h" id="" value="1" required></td>
                                        <td><input type="radio" name="49h" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>49i) Diseño de mapas mentales o conceptuales.</td>
                                        <td><input type="radio" name="49i" id="" value="5" required></td>
                                        <td><input type="radio" name="49i" id="" value="4" required></td>
                                        <td><input type="radio" name="49i" id="" value="3" required></td>
                                        <td><input type="radio" name="49i" id="" value="2" required></td>
                                        <td><input type="radio" name="49i" id="" value="1" required></td>
                                        <td><input type="radio" name="49i" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>49j) Invención de ejercicios por parte del alumno.</td>
                                        <td><input type="radio" name="49j" id="" value="5" required></td>
                                        <td><input type="radio" name="49j" id="" value="4" required></td>
                                        <td><input type="radio" name="49j" id="" value="3" required></td>
                                        <td><input type="radio" name="49j" id="" value="2" required></td>
                                        <td><input type="radio" name="49j" id="" value="1" required></td>
                                        <td><input type="radio" name="49j" id="" value="0" required></td>
                                    </tr>
                                    <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th>Diario</th>
                                        <th>Al menos 1 vez a la semana</th>
                                        <th>Al menos 1 vez al mes</th>
                                        <th>Al menos 1 vez al año</th>
                                        <th>Casi nunca o nunca</th>
                                        <th>No tengo acceso</th>
                                    </tr>
                                </thead>
                                    <tr>
                                        <td colspan="7" class="table-warning text-center">50) ¿Qué tipo de trabajos le gusta aplicar más?</td>
                                    </tr>
                                    <tr>
                                        <td>50a) Trabajo por proyectos.</td>
                                        <td><input type="radio" name="50a" id="" value="5" required></td>
                                        <td><input type="radio" name="50a" id="" value="4" required></td>
                                        <td><input type="radio" name="50a" id="" value="3" required></td>
                                        <td><input type="radio" name="50a" id="" value="2" required></td>
                                        <td><input type="radio" name="50a" id="" value="1" required></td>
                                        <td><input type="radio" name="50a" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>50b) Trabajo colaborativo por medio de redes sociales.</td>
                                        <td><input type="radio" name="50b" id="" value="5" required></td>
                                        <td><input type="radio" name="50b" id="" value="4" required></td>
                                        <td><input type="radio" name="50b" id="" value="3" required></td>
                                        <td><input type="radio" name="50b" id="" value="2" required></td>
                                        <td><input type="radio" name="50b" id="" value="1" required></td>
                                        <td><input type="radio" name="50b" id="" value="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>50c) Trabajo colaborativo de forma presencial.</td>
                                        <td><input type="radio" name="50c" id="" value="5" required></td>
                                        <td><input type="radio" name="50c" id="" value="4" required></td>
                                        <td><input type="radio" name="50c" id="" value="3" required></td>
                                        <td><input type="radio" name="50c" id="" value="2" required></td>
                                        <td><input type="radio" name="50c" id="" value="1" required></td>
                                        <td><input type="radio" name="50c" id="" value="0" required></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <h6 class="text-center text-success">Gracias por el tiempo y la información que ha proporcionado para este trabajo con fines académicos y estadísticos.</h6>
                            <input type="text" name="red" id="" value="<?= $red['nombre_red'] ?>" hidden required>
                            <input type="text" name="anio" id="" value="2023" hidden required>
                            <input type="text" name="claveCuerpo" id="" value="<?= $claveCuerpo ?>" hidden required>
                            <input type="button" name="previous" class="previous btn btn-block btn-danger" value="Regresar" />
                            <button type="submit" class="btn btn-warning btn-block">Terminar</button>
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
            if(value == ''){
                value = 'Sin respuesta.'
            }else if(value == 'na'){
                value = 'No aplica.'
            }
            $("input:text[name='"+name+"']").val(value)
        })

        Object.values(radios).forEach(val => {
            let name = val.name
            let value = val.value;
            if (value == formObj[name]) {
                $("input:radio[name='" + name + "']").filter('[value="' + value + '"]').prop('checked', true);
            }
        });
    </script>
    <script src="<?= base_url('resources/js/cuestionarios/Relen/2023/index.js') ?>"></script>

</body>

</html>















