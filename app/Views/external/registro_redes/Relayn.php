<!DOCTYPE html>

<html lang="es-MX">



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO A RELAYN</title>
    <link rel="stylesheet" href="<?= base_url("resources/css/registro/Relayn.css") ?>">
    <link rel="stylesheet" href="<?= base_url('resources/intl-tel-input/build/css/intlTelInput.css') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">
</head>



<body>

    <div id="loader">
        <span class="loader"></span>
        <span>Cargando...</span>
    </div>
    <form class="g-3 needs-validation" novalidate> <!-- action="base_url("insertarRegistroRelayn") method="post" -->
        <!--g-3 needs-validation <-- ponerlo en la clase-->

        <section class="text-center">

            <img src="<?= base_url("resources/img/logos_con_letras/Letras_Relayn.png"); ?>" width="40%" alt="">

            <hr>

            <h1>REGISTRO A RELAYN</h1>

        </section>

        <section id="datos_universidad">

            <label for="tipo_registro">Tipo de registro</label><br>

            <div class="mb-3">

                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="radio" name="tipo_registro" id="tipo_registro1" value="investigación" required>

                    <label class="form-check-label" for="tipo_registro1">Investigación</label>

                </div>

                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="radio" name="tipo_registro" id="tipo_registro2" value="congreso" required>

                    <label class="form-check-label" for="tipo_registro2">Congreso</label>

                </div>

                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="radio" name="tipo_registro" id="tipo_registro3" value="oyente" required>

                    <label class="form-check-label" for="tipo_registro3">Oyente</label>

                </div>

                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="radio" name="tipo_registro" id="tipo_registro4" value="coloquio" required>

                    <label class="form-check-label" for="tipo_registro4">Coloquio</label>

                </div>

            </div>

            <div id="informacion_general">

                <div class="mb-3" id="divNombreUni">

                    <label for="nombreUniversidad">Nombre de la universidad / institución a la que pertenece</label>

                    <input type="text" class="form-control ln" id="nombreUniversidad" name="nombreUniversidad" placeholder="Nombre completo de la universidad" required>

                    <div class="invalid-feedback">

                        Nombre de la universidad / institución a la que pertenece

                    </div>

                </div>

                <div class="mb-3">

                    <label for="nombreRector">Nombre completo de la autoridad (Rector/ Director)</label>

                    <input type="text" class="form-control ol" id="nombreRector" name="nombreRector" placeholder="Nombre completo del rector" required>

                    <div class="invalid-feedback">

                        Ingresa el nombre del rector.

                    </div>

                </div>

                <div class="mb-3">

                    <label for="gradoRector">Grado académico de la autoridad (Rector/Director)</label>

                    <select class="form-control" name="gradoRector" id="gradoRector" required>

                        <option value="" selected="true" disabled>Selecciona el grado académico de la autoridad (Rector/Director)</option>

                        <?php

                        foreach ($grados_academicos as $ga) {

                        ?>

                            <option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>

                        <?php

                        }

                        ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label for="cbx_pais">País</label>

                    <select class="form-control" name="cbx_pais" id="cbx_pais" required>

                        <option value="" selected="true" disabled>Selecciona un país</option>

                        <?php

                        foreach ($a_pais as $pais) {

                        ?>

                            <option value="<?php echo $pais["id"] ?>"><?php echo $pais["nombre"] ?></option>

                        <?php

                        }

                        ?>

                        <option value="1">Otro país</option>

                    </select>

                    <div class="invalid-feedback">

                        Ingresa su pais.

                    </div>

                </div>

                <div class="mb-3" style="display:none" id="divotropais">

                    <label for="otropais">Pais</label>

                    <input type="text" class="form-control ol" id="otropais" name="cbx_pais" placeholder="Nombre del país">

                    <div class="invalid-feedback">

                        Ingresa el nombre de su país.

                    </div>

                </div>

                <div class="mb-3">

                    <label for="cbx_estado">Estado / Departamento</label>

                    <select class="form-control" name="cbx_estado" id="cbx_estado" required>

                    </select>

                    <div class="invalid-feedback">

                        Ingrese su estado.

                    </div>

                </div>

                <div class="mb-3" style="display:none" id="divotroestado">

                    <label for="otroestado">Estado</label>

                    <input type="text" class="form-control ol" id="otroestado" name="cbx_estado" placeholder="Nombre del estado">

                    <div class="invalid-feedback">

                        Ingresa el nombre de su estado.

                    </div>

                </div>

                <div class="mb-3" id="div_municipio">

                    <label for="cbx_municipio">Municipio/Provincia (Zona de estudio)</label>

                    <select class=" form-control" name="cbx_municipio" id="cbx_municipio" required>

                    </select>

                    <div class="invalid-feedback">

                        Ingresa su municipio.

                    </div>

                </div>

                <div class="mb-3" style="display:none" id="divotromunicipio">

                    <label for="otromunicipio">Municipio/Provincia (Zona de estudio)</label>

                    <input type="text" class="form-control ol" id="otromunicipio" name="cbx_municipio" placeholder="Nombre del municipio">

                    <div class="invalid-feedback">

                        Ingresa el nombre de su municipio.

                    </div>

                </div>

                <div class="mb-3" id="preAsistencia">
                    <label for="preAsistencia">Pre-registro de modalidad de asistencia al evento</label>
                    <select name="preAsistencia" id="preAsistenciaID" class="form-control">
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="presencial">Presencial</option>
                        <option value="virtual">Virtual</option>
                    </select>
                </div>
                
            </div>

            <div id="direcciones_universidad">

                <div id="formularioDocumentos">

                    <h3>Formato para la dirección de envío de paquetería</h3>

                    <p>Instrucciones: Para registrar la dirección de manera correcta es necesario completar todos los campos solicitados. En caso de que algún dato no aplique deberá seleccionar la casilla <b>no aplica</b>.</p>

                    <p class="text-danger">* Puede ser la dirección de su institución</p>

                    <label for="">Tipo de vialidad</label>

                    <select id="tipo_vialidad_select2" class="form-control">
                        <option value="" selected disabled>Seleccione una opción</option>
                        <?php
                        foreach ($vialidades as $v) {
                        ?>
                            <option value="<?= $v['nombre'] ?>"><?= $v['nombre'] ?></option>
                        <?php
                        }
                        ?>
                    </select>

                    <input type="hidden" id="tipo_vialidad2" value="">


                    <label for="nombre_vialidad2">Nombre de la vialidad.</label>

                    <input type="text" id="nombre_vialidad2" placeholder="Ejemplo: Circuito escolar" class="form-control ln">



                    <label for="noInt2">No. Interior.</label>

                    <input type="text" id="noInt2" placeholder="Ejemplo: 411A" class="form-control">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_noInt2" data-val='noInt2' onchange="check_sn(event);">
                        <label class="form-check-label" for="check_noInt2">
                            No aplica Núm. Interior.
                        </label>
                    </div>


                    <label for="noExt2">No. Exterior.</label>

                    <input type="text" id="noExt2" placeholder="Ejemplo: S/N" class="form-control">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_noExt2" data-val='noExt2' onchange="check_sn(event);">
                        <label class="form-check-label" for="check_noExt2">
                            No aplica Núm. Exterior.
                        </label>
                    </div>



                    <label for="colonia">Colonia</label>

                    <input type="text" id="colonia2" placeholder="Ejemplo: Copilco Universidad" class="form-control ln">



                    <label for="localidad">Localidad</label>

                    <input type="text" id="localidad2" placeholder="Ejemplo: Coyoacán" class="form-control ol">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_localidad2" data-val='localidad2' onchange="check_na(event);">
                        <label class="form-check-label" for="check_localidad2">
                            No aplica localidad.
                        </label>
                    </div>



                    <label for="municipio">Municipio</label>

                    <input type="text" id="municipio2" placeholder="Ejemplo: Coyoacán" class="form-control ol">



                    <label for="estado">Estado</label>

                    <input type="text" id="estado2" placeholder="Ejemplo: Cuidad de México" class="form-control ln">

                    <label for="cp">Código postal</label>

                    <input type="number" id="cp2" placeholder="Ejemplo: 04360" class="form-control on">

                    <label for="referencias">Referencias del domicilio</label>

                    <input type="text" id="referencias2" placeholder="Ejemplo: Edificio H de la facultad de medicina, color rojo, segunda planta. Entregar en Servicios escolares, cuenta con placa de identificación" class="form-control ln">

                    <hr>

                </div>



                <div class="mb-3" id="divEnviosDocumentos">

                    <label for="direccionEnvio">Dirección para envío de paquetería.</label>

                    <textarea type="text" class="form-control" id="direccionEnvio" name="direccionEnvio" placeholder="Nombre de la vialidad (calle, avenida, privada), número Ext. e Int., colonia, localidad, municipio, estado, C.P., referencias del domicilio"></textarea>

                    <div class="invalid-feedback">

                        Ingrese una dirección para envíos.

                    </div>

                </div>

            </div>

            <div id="numeros_universidad">

                <div class="mb-3">

                    <label for="telefonoUniversidad">Número de teléfono de la universidad</label><br>

                    <input type="tel" class="form-control on" id="telefonoUniversidad" name="telefonoUniversidad" required>

                    <div class="invalid-feedback">

                        Ingresa el número de teléfono de la universidad.

                    </div>

                </div>

                <div class="mb-3">

                    <label for="extensionUniversidad">Extensión (Opcional)</label>

                    <input type="number" class="form-control on" id="extensionUniversidad" name="extensionUniversidad" placeholder="Extensión">

                </div>

                <div class="mb-3">

                    <label for="medioEntero">Medio por el cual se enteró de la convocatoria</label>

                    <select class="form-control" name="cbx_medio" id="cbx_medio" required>

                        <option value="" selected="true" disabled>Selecciona el medio por el cual se enteró</option>

                        <option value="correo">Correo</option>

                        <option value="whatsapp">WhatsApp</option>

                        <option value="facebook">Facebook</option>

                        <option value="recomendacion">Recomendación</option>

                        <option value-"paginaWeb">Alguna página web de REDESLA</option>

                    </select>

                </div>

            </div>

            <div id="prodep_universidad">

                <div class="mb-3">

                    <h3>¿Perteneces a un cuerpo académico PRODEP?</h3>

                    <label class="custom-control custom-radio custom-control-inline">

                        <input type="radio" name="prodep" value="no" checked class="custom-control-input prodep"><span class="custom-control-label">No</span>

                    </label>

                    <label class="custom-control custom-radio custom-control-inline">

                        <input type="radio" name="prodep" value="si" class="custom-control-input prodep"><span class="custom-control-label">Si</span>

                    </label>

                </div>

                <div id="prodep">

                    <div class="mb-3">

                        <label for="nombreProdep">Nombre de CA</label>

                        <input type="text" class="form-control ln" id="nombreProdep" name="nombreProdep" placeholder="Nombre de CA">

                        <div class="invalid-feedback">

                            Ingresa el nombre del CA.

                        </div>

                    </div>

                    <input type="text" value="No aplica" id="withoutProdep" name="nivelProdep" hidden>

                    <div class="mb-3">

                        <label for="nivelProdep">Nivel</label>

                        <select class="form-control" name="nivelProdep" id="nivelProdep">

                            <option value="" selected="true" disabled>Selecciona el nivel PRODEP al que pertenece</option>

                            <option value="Consolidado">Consolidado</option>

                            <option value="En consolidación">En consolidación</option>

                            <option value="En formación">En formación</option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label for="anoProdep">Año en que recibió su nivel</label>

                        <input type="text" class="form-control on" id="anoProdep" name="anoProdep" placeholder="Año en que recibió su nivel">

                        <div class="invalid-feedback">

                            Ingresa el año e que se adquirió.

                        </div>

                    </div>

                </div>

            </div>

            <button type="button" id="siguiente_miembros" class="btn btn-block" style="background-color: #E55204; color: white;">Siguiente</button>

            <div class="mb-3"></div>

            <div class="mb-3"></div>

        </section>

        <section id="cantidad_miembros">

            <h1>Seleccione la cantidad de miembros (autores) de su grupo de investigación</h1>

            <div class="cantidad_desktop">
                <p class="form__answer">

                    <input type="radio" name="c_miembros" id="match_1" value="1">

                    <label for="match_1" style="color: black">

                        <i class="fa fa-user"></i><br>

                        1 miembro (autor)

                    </label>

                </p>

                <p class="form__answer">

                    <input type="radio" name="c_miembros" id="match_2" value="2">

                    <label for="match_2" style="color: black">

                        <i class="fa fa-user">&nbsp</i><i class="fa fa-user"></i><br>

                        2 miembros (autores)

                    </label>

                </p>

                <p class="form__answer">

                    <input type="radio" name="c_miembros" id="match_3" value="3">

                    <label for="match_3" style="color: black">

                        <i class="fa fa-user">&nbsp</i><i class="fa fa-user">&nbsp</i><i class="fa fa-user"></i><br>

                        3 miembros (autores)

                    </label>

                </p>

                <p class="form__answer">

                    <input type="radio" name="c_miembros" id="match_4" value="4">

                    <label for="match_4" style="color: black">

                        <i class="fa fa-user">&nbsp</i><i class="fa fa-user">&nbsp</i><i class="fa fa-user">&nbsp</i><i class="fa fa-user"> </i><br>

                        4 miembros (autores)

                    </label>

                </p>
            </div>

            <div class="cantidad_mobile">
                <div class="row">
                    <div class="col-md-6">
                        <p class="form__answer">

                            <input type="radio" name="c_miembros" id="match_1" value="1">

                            <label for="match_1">

                                <i class="fa fa-user"></i><br>

                                1 miembro (autor)

                            </label>

                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="form__answer">

                            <input type="radio" name="c_miembros" id="match_2" value="2">

                            <label for="match_2">

                                <i class="fa fa-user">&nbsp</i><i class="fa fa-user"></i><br>

                                2 miembros (autores)

                            </label>

                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="form__answer">

                            <input type="radio" name="c_miembros" id="match_3" value="3">

                            <label for="match_3">

                                <i class="fa fa-user"></i><br>

                                3 miembros (autores)

                            </label>

                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="form__answer">

                            <input type="radio" name="c_miembros" id="match_4" value="4">

                            <label for="match_4">

                                <i class="fa fa-user">&nbsp</i><i class="fa fa-user"></i><br>

                                4 miembros (autores)

                            </label>

                        </p>
                    </div>
                </div>
            </div>


            <input type="hidden" name="redCueCa" value="Relayn">
            <button type="button" id="siguiente_datos" class="btn btn-block" style="background-color: #E55204; color: white;">Siguiente</button>

            <button type="button" id="regresar_universidad" class="btn btn-block" style="background-color: #E55204; color: white;">Anterior</button>

        </section>

        <section id="datos_miembros">

            <h1>Añadir datos de miembros (autores)</h1>

            <hr>

            <div id="div_datosMiembros">



            </div>


            <p>Nota: Si requiere corregir el número de miembros (autores) a registrar, dé clic en el botón "Anterior" para regresar y seleccionar la cantidad de miembros (autores) correcta e ingresar sus datos.</p>
            <button type="submit" class="btn btn-block" style="background-color: #E55204; color: white;" id="btnTerminarRegistro">Terminar registro</button>

            <button type="button" id="regresar_cantidad" class="btn btn-block" style="background-color: #E55204; color: white;">Anterior</button>

        </section>

        <section class="text-center">

            <h3>IMPORTANTE</h3>

            Este es un registro para la gestión de su participación en la convocatoria, el líder es quien gestionará los proceso de la misma. Es independiente, no tiene un vínculo directo con su gestión de PRODEP.
            <hr>
            <h3>¿Necesitas ayuda?</h3>
            <h4>Visualiza nuestro manual de registro</h4>
            <i class="fas fa-file-pdf text-danger"></i> <a target="_blank" href="https://drive.google.com/file/d/16cM73N2gvdeomGieBD5Da98GpkGK52ii/view">Manual de registro</a>
            <h4>Contactanos a nuestro WhatsApp</h4>
            <i class="fa-brands fa-whatsapp text-success"></i> <a target="_blank" href="https://wa.link/pkbtai">https://wa.link/pkbtai</a>
        </section>

    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js" integrity="sha512-XGZwM3U4PM6aH04G+9uL3qma2xu2feLpy5qX7WRlFu2Ti3tiRPoY9vuD9bz7wiTVJ139hdogEYBFZtevPPR1Yw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="<?= base_url('resources/intl-tel-input/build/js/intlTelInput.js') ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


    <script>
        base_url = "<?php echo base_url() ?>";
    </script>
    <script src="<?= base_url("resources/js/form-validation/inputs.js") ?>"></script>
    <script src="<?= base_url("resources/js/registro/Relayn/index.js") ?>"></script>
    <script src="<?= base_url("resources/js/registro/general.js") ?>"></script>
</body>



</html>