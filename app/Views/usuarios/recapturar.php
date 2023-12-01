<!DOCTYPE html>

<html lang="es-MX">



<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="<?= base_url("resources/css/entrevista.css") ?>">

    <title>Recaptura de entrevista</title>

</head>



<body>

    <section>

        <div class="row">

            <div class="col-md-6 text-center">

                <img src="<?= base_url("resources/img/logos_con_letras/Letras_Relmo.png") ?>" style="width:200px">

            </div>

            <div class="col-md-6 text-center">

                <img src="<?= base_url("resources/img/UAQ.png") ?>">

            </div>

        </div>

        <hr>

        <h4 class='text-center'>En este apartado se recapturara la entrevista # <?= $_SESSION["id_recapturar"] ?>. </h4>

    </section>

    <form class="row g-3 needs-validation" novalidate method="post" action="<?= base_url("actRecapturarEntrevista") ?>">

        <section id="primeraSeccion">

            <!-- ENTREVISTADORA -->

            <h1>Entrevistadora</h1>

            <div class="mb-3">

                <label for="nombre_entrevistadora" class="form-label">Nombre de la entrevistadora:</label>

                <input type="text" class="form-control" name="nombre_entrevistadora" id="nombre_entrevistadora" required>

            </div>

            <div class="mb-3">

                <label for="lugar_entrevista" class="form-label">Lugar de la realización de la entrevista:</label>

                <input type="text" class="form-control" name="lugar_entrevista" id="lugar_entrevista" required>

            </div>





            <div class="mb-3">

                <label for="hora_aplicacion" class="form-label">Hora de aplicación de la entrevista:</label>

                <div class"row">

                    <div class="col-md-12">

                        <div class="input-group has-validation">

                            <span class="input-group-text" id="inputGroupPrepend">Hora inicio</span>

                            <input type="time" class="form-control" name="hora_aplicacion_inicio" id="hora_aplicacion_inicio" required>

                        </div>

                    </div><br>

                    <div class="col-md-12">

                        <div class="input-group has-validation">

                            <span class="input-group-text" id="inputGroupPrepend">Hora final</span>

                            <input type="time" class="form-control" name="hora_aplicacion_final" id="hora_aplicacion_final" required>

                        </div>

                    </div>

                </div>

            </div>



            <div class="mb-3">

                <label for="fecha_entrevista" class="form-label">Fecha de la entrevista:</label>

                <input type="date" class="form-control" name="fecha_entrevista" id="fecha_entrevista" required>

            </div>









            <div class="mb-3">

                <label for="duracion_entrevista" class="form-label">Duración de la aplicación de la entrevista:</label>

                <input type="text" class="form-control without_ampm" name="duracion_entrevista" id="duracion_entrevista" required readonly>

            </div>







            <!-- ENTREVISTADORA -->

            <!-- ENTREVISTADA -->

            <div class="mb-3">

                <label for="nombre_entrevistada" class="form-label">Nombre de la entrevistada:</label>

                <input type="text" class="form-control" id="nombre_entrevistada" name="nombre_entrevistada" aria-describedby="infoHelp">

                <div id="emailHelp" class="form-text">Este dato no es obligatorio.</div>

            </div>

            <!--PRIMERA PARTE-->

            <h3>1ra PARTE: CARACTERÍSTICAS SOCIODEMOGRÁFICAS DE LA UNIVERSITARIA DIRECTORA O DUEÑA DE LA MYPE</h3>

            <div class="mb-3">

                <label for="pregunta1" class="form-label">1. ¿Cuál es tu edad?</label>

                <div class="input-group has-validation">

                    <span class="input-group-text" id="inputGroupPrepend">Años</span>

                    <input type="number" class="form-control" id="pregunta1" name="pregunta1" required>

                </div>



            </div>

            <div class="mb-3">

                <label for="pregunta2" class="form-label">2. ¿Cuál es tu estado civil?</label>

                <input type="text" class="form-control" id="pregunta2" name="pregunta2" required>

            </div>

            <div class="mb-3">

                <label for="pregunta3" class="form-label">3. ¿Tienes hijos (as)?</label>

                <select id="pregunta3" class="form-control" required name="pregunta3">

                    <option selected="true" disabled="disabled" value="">Seleccione una opción</option>

                    <option value="si">Sí</option>

                    <option value="no">No</option>

                </select>

                <div class="invalid-feedback">

                    Seleccione una opcion correcta

                </div>

            </div>

            <div class="mb-3" id="oculto1">

                <label for="pregunta4" class="form-label">3a. ¿Cuántos hijos (as) tienes?</label>

                <input type="number" class="form-control" id="pregunta4" name="pregunta4">

            </div>

            <div class="mb-3">

                <label for="pregunta5" class="form-label">4. ¿Qué carrera estás estudiando?</label>

                <input type="text" class="form-control" id="pregunta5" name="pregunta5" aria-describedby="pregunta5" required>

                <div id="pregunta5" class="form-text">Poner nombre completo y oficial de la carrera, no abreviaturas o iniciales.</div>

            </div>

            <div class="mb-3">

                <label for="pregunta6" class="form-label">5. ¿Qué grado académico estás estudiando?</label>

                <select id="pregunta6" name="pregunta6" class="form-select" required>

                    <option selected disabled value="">Seleccione una opción</option>

                    <option value="TSU">TSU</option>

                    <option value="Licenciatura">Licenciatura</option>

                    <option value="Maestría">Maestría</option>

                    <option value="Doctorado">Doctorado</option>

                    <option value="Posgrado">Posgrado</option>

                </select>

                <div class="invalid-feedback">

                    Seleccione un grado academico

                </div>

            </div>

            <div class="mb-3">

                <label for="pregunta7" class="form-label">6. ¿En qué tipo de ciclo estudias?</label>

                <select id="pregunta7" name="pregunta7" class="form-select" required>

                    <option selected disabled value="">Seleccione una opción</option>

                    <option value="Anual">Anual</option>

                    <option value="Semestral">Semestral</option>

                    <option value="Mensual">Mensual (cada materia dura un mes)</option>

                    <option value="Libre avance">Libre avance</option>

                    <option value="otro">Otro</option>

                </select>

                <div class="invalid-feedback">

                    Seleccione un ciclo

                </div>

                <div id="otro_ciclo">

                    <label for="pregunta7_5" class="form-label">6a. ¿Cómo se llama el ciclo?</label>

                    <input type="text" id="pregunta7_5" name="pregunta7_5" class="form-control" required>

                </div>

            </div>

            <div class="mb-3">

                <label for="pregunta8" class="form-label">7. ¿En qué número de semestre, cuatrimestre, año te encuentras? </label>

                <input type="text" class="form-control" id="pregunta8" name="pregunta8" aria-describedby="pregunta8" required onkeypress="return soloNA(event)">

                <div id="pregunta8" class="form-text">En caso de que vaya por materia o avance libre se escribe NA.</div>

            </div>

            <!--PRIMERA PARTE-->

            

            

            <!--SEGUNDA PARTE-->

            

            

            

            <h3>2da PARTE: DATOS DE LA INSTITUCIÓN</h3>

            <div class="mb-3">

                <label for="pregunta9" class="form-label">8. Nombre completo de la institución:</label>

                <input type="text" class="form-control" id="pregunta9" name="pregunta9" aria-describedby="pregunta9" required>

                <div id="pregunta9" class="form-text">Sin abreviaturas o siglas</div>

            </div>

            <div class="mb-3">

                <label for="pregunta10" class="form-label">9. Estado al que pertenece:</label>

                <select id="pregunta10" name="pregunta10" class="form-control" required>

                    <option selected="true" disabled="disabled" value="">Seleccione una opción</option>

                    <?php

                    foreach ($info["estados"] as $estado) {

                    ?>

                        <option value="<?php echo $estado["id"] ?>"><?php echo $estado["nombre"] ?></option>

                    <?php

                    }

                    ?>

                </select>

                <div class="invalid-feedback">

                    Seleccione un Estado

                </div>



            </div>

            <div class="mb-3">

                <label for="pregunta11" class="form-label">10. Municipio al que pertenece:</label>

                <select class=" form-control" id="pregunta11" name="pregunta11" required></select>

            </div>

            <div class="mb-3">

                <label for="pregunta12" class="form-label">11. ¿Tu institución es pública o privada?:</label>

                <select id="pregunta12" name="pregunta12" class="form-control" required>

                    <option selected="true" disabled="disabled" value="">Seleccione una opción</option>

                    <!--VALIDAR ESTO CUIDADO-->

                    <option value="público">Pública</option>

                    <option value="privado">Privada</option>

                </select>

                <div class="invalid-feedback">

                    Seleccione un sector

                </div>

            </div>

            

            <!--SEGUNDA PARTE-->

            

            

            <!--TERCERA PARTE-->

            <h3>3ra PARTE: CARACTERÍSTICAS DE LA MYPE.</h3>

            <div class="mb-3">

                <label for="pregunta13" class="form-label">12. ¿Cuál es el año de inicio de operaciones de tu micro o pequeña empresa?:</label>

                <input type="number" class="form-control" id="pregunta13" name="pregunta13" aria-describedby="pregunta13" required>

                <div id="pregunta13" class="form-text">Se requiere por lo menos un año de operación</div>

            </div>

            <div class="mb-3">

                <label for="pregunta14" class="form-label">13. ¿Cuántas personas trabajan permanente en tu empresa actualmente?</label>

                <input type="number" class="form-control" id="pregunta14" name="pregunta14" required>

            </div>

            <div class="mb-3">

                <label for="pregunta15" class="form-label">14. ¿Cuántas mujeres trabajan permanente en tu empresa actualmente?</label>

                <input type="number" class="form-control" id="pregunta15" name="pregunta15" required>

            </div>

            <div class="mb-3">

                <label for="pregunta16" class="form-label">15. ¿Cuántos familiares trabajan permanente en tu empresa actualmente?</label>

                <input type="number" class="form-control" id="pregunta16" name="pregunta16" required>

            </div>

            <div class="mb-3">

                <label for="pregunta17" class="form-label">16. ¿Cuál es el sector económico que mejor describe la actividad/giro de tu empresa?</label>

                <input type="number" class="form-control" id="pregunta17" name="pregunta17" aria-describedby="pregunta17" required>

                <div id="pregunta17" class="form-text"><a href="<?= base_url("resources/pdf/Anexo.pdf") ?>" target="_blank">Basarse en el catálogo de actividades</a> o puede consultarlo <a target="_blank" href="https://www.relmo.org/entrevistas/giro">aquí</a></div>

            </div>

            <div class="mb-3">

                <label for="pregunta18" class="form-label">17.¿Cuál es la modalidad en la que trabaja tu empresa? ¿física, virtual o mixta?</label>

                <select id="pregunta18" name="pregunta18" class="form-control" required>

                    <option selected="true" disabled="disabled" value="">Seleccione una opción</option>

                    <!--VALIDAR ESTO CUIDADO-->

                    <option value="física">Física</option>

                    <option value="virtual">Virtual</option>

                    <option value="mixta">Mixta</option>

                </select>

                <div class="invalid-feedback">

                    Seleccione una modalidad

                </div>

            </div>

            

            <!--TERCERA PARTE-->

            

            <!--CUARTA PARTE-->

            <h3>4ta PARTE: SOBRE LOS OBSTÁCULOS</h3>

            <div class="mb-3">

                <label for="pregunta19" class="form-label">18. ¿Para ti ha sido difícil ser directora de empresa y estudiante al mismo tiempo?</label>

                <select id="pregunta19" name="pregunta19" class="form-control" required>

                    <option selected disabled value="">Seleccione una opción</option>

                    <option value="si">Sí</option>

                    <!--depende si es si o no se mostraran las siguientes preguntas-->

                    <option value="no">No</option>

                </select>

                <div class="invalid-feedback">

                    Seleccione una opción

                </div>

            </div>

            <div id="preguntas_condicionales">

                <div class="mb-3">

                    <label for="pregunta20" class="form-label">19. Platícame por favor, ¿qué te motivó a ser dueña de una empresa o tomar la responsabilidad de dirigir una empresa?</label>

                    <textarea type="text" class="form-control" id="pregunta20" name="pregunta20"></textarea>

                </div>

                <div class="mb-3">

                    <label for="pregunta21" class="form-label">20. Ahora cuéntame, ¿qué fue lo que te motivó a estar estudiando una carrera universitaria?</label>

                    <textarea type="text" class="form-control" id="pregunta21" name="pregunta21"></textarea>

                </div>

                <div class="mb-3">

                    <label for="pregunta22" class="form-label">21. Desde tu experiencia dime, ¿qué ha sido más difícil para ti? ¿Ser directora de empresa o ser estudiante universitaria?</label>

                    <textarea type="text" class="form-control" id="pregunta22" name="pregunta22" aria-describedby="pregunta22"></textarea>

                    <div id="pregunta22" class="form-text">Por favor, explícame por qué. </div>

                </div>

                <div class="mb-3">

                    <label for="pregunta23" class="form-label">22. Me podrías platicar por favor, ¿cuáles han sido los obstáculos a los cuáles te has enfrentado en la gestión de tu empresa?</label>

                    <textarea type="text" class="form-control" id="pregunta23" name="pregunta23" aria-describedby="pregunta23"></textarea>

                    <div id="pregunta23" class="form-text">Es importante profundizar sobre la experiencia de la sujeta de investigación de acuerdo a su contexto empresaria-estudiante.</div>

                </div>

                <div class="mb-3">

                    <label for="pregunta24" class="form-label">23. Me podrías comentar por favor, ¿cuáles han sido los obstáculos a los cuáles te has enfrentado en tu formación académica?</label>

                    <textarea type="text" class="form-control" id="pregunta24" name="pregunta24" aria-describedby="pregunta24"></textarea>

                    <div id="pregunta24" class="form-text">Es importante profundizar sobre la experiencia de la sujeta de investigación de acuerdo a su contexto estudiante-empresaria.</div>

                </div>

                <div class="mb-3">

                    <label for="pregunta25" class="form-label">24. ¿Cómo has hecho para resolver estos obstáculos que me has mencionado?</label>

                    <textarea type="text" class="form-control" id="pregunta25" name="pregunta25"></textarea>

                </div>

            </div>

            <div class="row">

                <button type="button" class="btn btn-block" style="background-color:#e9609f;color:white" id="siguiente">Siguiente</button>

            </div>

            <!--CUARTA PARTE-->

            <!-- ENTREVISTADA -->



        </section>



        <section id="bitacoraSection">

            <h1 class="text-uppercase text-center">bitácora</h1>

            <hr>

            <div class="mb-3">

                <label for="hora_inicio" class="form-label">Hora de inicio de la entrevista:</label>

                <input type="text" class="form-control" name="hora_inicio" id="hora_inicio" disabled required aria-describedby="hora_inicio">

                <div id="hora_inicio" class="form-text">Debes completar este campo en la sección de entrevista</div>

            </div>

            <div class="mb-3">

                <label for="hora_final" class="form-label">Hora de finalización de la entrevista:</label>

                <input type="text" class="form-control" name="hora_final" id="hora_final" disabled required aria-describedby="hora_final">

                <div id="hora_inicio" class="form-text">Debes completar este campo en la sección de entrevista</div>

            </div>

            <div class="mb-3">

                <label for="duracion" class="form-label">Duración de la entrevista:</label>

                <input type="text" class="form-control" name="duracion" id="duracion" disabled required aria-describedby="duracion">

                <div id="hora_inicio" class="form-text">Debes completar este campo en la sección de entrevista</div>

            </div>

            <div class="mb-3">

                <label for="fecha" class="form-label">Fecha de la entrevista:</label>

                <input type="date" class="form-control" name="fecha" id="fecha" disabled required aria-describedby="fecha">

                <div id="fecha" class="form-text">Debes completar este campo en la sección de entrevista</div>

            </div>

            <div class="mb-3">

                <label for="bitacora" class="form-label">Anotaciones de campo:</label>

                <textarea type="text" rows="20" class="form-control" name="bitacora" id="bitacora" required></textarea>

            </div>

            <div class="row">

                <button type="button" class="btn btn-block" style="background-color:#e9609f;color:white" id="regresar">Regresar a la entrevista</button>

            </div><br>

            <div class="row">

                <button class="btn btn-block" style="background-color:#e9609f;color:white" type='submit' id="addRegistro">Terminar</button>

            </div>





        </section>

    </form>

    <footer>

        <h3 class="text-center">¿Tienes un problema?</h3>

        <p class="text-center">Envianos un correo describiendonos tu problema a la siguiente dirección:</p>

        <p class="text-center">jaramosp@e.redesla.net</p>

    </footer>









    <script type="text/javascript">

        var base_url = "<?= base_url() ?>";

        $(document).ready(function() {

            $("#preguntas_condicionales").hide();

            $("#oculto1").hide();

            $("#otro_ciclo").hide();

            $("#bitacoraSection").hide();

        });

    </script>

<script type="text/javascript">
    $(document).ready(function(){
        <?php if( session()->getFlashdata('icon') ){ ?>
            Swal.fire({
                icon: '<?= session()->getFlashdata('icon') ?>',
                title: '<?= session()->getFlashdata('title') ?>',
                text: '<?= session()->getFlashdata('text') ?>',
            })
        <?php } ?>
    })
</script>

    <script src="<?= base_url("resources/js/entrevista.js"); ?>"></script>

</body>



</html>