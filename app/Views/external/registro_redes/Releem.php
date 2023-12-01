<!DOCTYPE html>

<html lang="es-MX">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>REGISTRO RELEEM</title>

    <link rel="stylesheet" href="<?= base_url("resources/css/registro/Releem.css") ?>">

    <link rel="stylesheet" href="<?= base_url('resources/intl-tel-input/build/css/intlTelInput.css') ?>">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">

</head>

<body>

    <form class="g-3 needs-validation" action="<?= base_url("insertarRegistroReleem") ?>" method="post" novalidate>
        <!--g-3 needs-validation <-- ponerlo en la clase-->

        <section class="text-center">

            <img src="<?= base_url("resources/img/logos_con_letras/Letras_Releem.png"); ?>" width="40%" alt="">

            <hr>

            <h1>REGISTRO A RELEEM</h1>

        </section>

        <section id="datos_universidad">

            <label for="tipo_registro">Tipo de registro</label><br>

            <div class="mb-3">

                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="radio" name="tipo_registro" id="tipo_registro1" value="investigación" required>

                    <label class="form-check-label" for="tipo_registro1">Desafíos / Investigación

                    </label>

                </div>

                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="radio" name="tipo_registro" id="tipo_registro2" value="congreso" required>

                    <label class="form-check-label" for="tipo_registro2">Congreso</label>

                </div>

                <div class="form-check form-check-inline">

                    <input class="form-check-input" type="radio" name="tipo_registro" id="tipo_registro3" value="oyente" required>

                    <label class="form-check-label" for="tipo_registro3">Oyente</label>

                </div>

            </div>

            <div id="informacion_general">

                <div class="mb-3">

                    <label for="nombreUniversidad">Nombre de la universidad</label>

                    <input type="text" class="form-control ln" id="nombreUniversidad" name="nombreUniversidad" placeholder="Nombre completo de la universidad" required>

                    <div class="invalid-feedback">

                        Ingresa el nombre de la universidad.

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

            </div>

            <div id="direcciones_universidad">

                <div id="direcciones_universidad_form">

                    <h3>Formato para la dirección de la universidad de adscripción</h3>

                    <label for="nombre_vialidad">Nombre y tipo de la vialidad (calle, avenida, privada), ejemplo: Calle Jazmín</label>

                    <input type="text" id="nombre_vialidad" placeholder="Ingrese el nombre de la vialidad (calle, avenida, privada)" class="form-control ln">

                    <label for="noInt">No. Interior (En caso de que el domicilio no cuente con numeración, colocar <b>S/N</b>)</label>

                    <input type="text" id="noInt" placeholder="Ingrese el No. Interior" class="form-control">

                    <label for="noExt">No. Exterior (En caso de que el domicilio no cuente con numeración, colocar <b>S/N</b>)</label>

                    <input type="text" id="noExt" placeholder="Ingrese el No. Exterior" class="form-control">

                    <label for="colonia">Colonia</label>

                    <input type="text" id="colonia" placeholder="Ingrese la colonia" class="form-control ln">

                    <label for="localidad">Localidad</label>

                    <input type="text" id="localidad" placeholder="Ingrese la localidad" class="form-control ol">

                    <label for="municipio">Municipio</label>

                    <input type="text" id="municipio" placeholder="Ingrese el municipio" class="form-control ol">

                    <label for="estado">Estado</label>

                    <input type="text" id="estado" placeholder="Ingrese el estado" class="form-control ol">

                    <label for="cp">Código postal</label>

                    <input type="number" id="cp" placeholder="Ingrese el código postal" class="form-control on">

                    <label for="referencias">Referencias del domicilio</label>

                    <input type="text" id="referencias" placeholder="Ingrese las referencias" class="form-control ln">

                    <hr>

                </div>



                <div class="mb-3" id="divUniversidadAdscripcion">

                    <label for="direccionUniversidad">Dirección de la universidad de adscripción </label>

                    <textarea type="text" class="form-control" id="direccionUniversidad" name="direccionUniversidad" placeholder="Nombre de la vialidad (calle, avenida, privada), número Ext. e Int., colonia, localidad, municipio, estado, C.P., referencias del domicilio" required></textarea>

                    <div class="invalid-feedback">

                        Ingrese la dirección de la universidad.

                    </div>

                    <br>

                    <label for=""><input type="checkbox" id="mismaDireccion"> ¿Desea usar la misma dirección para el envio de paquetería?</label>

                </div>



                <div id="formularioDocumentos">

                    <h3>Formato para la dirección de envío de paquetería</h3>

                    <label for="nombre_vialidad">Nombre y tipo de la vialidad (calle, avenida, privada), ejemplo: Calle Jazmín</label>

                    <input type="text" id="nombre_vialidad2" placeholder="Ingrese el nombre de la vialidad (calle, avenida, privada)" class="form-control ln">

                    <label for="noInt">No. Interior (En caso de que el domicilio no cuente con numeración, colocar <b>S/N</b>)</label>

                    <input type="text" id="noInt2" placeholder="Ingrese el No. Interior" class="form-control">

                    <label for="noExt">No. Exterior (En caso de que el domicilio no cuente con numeración, colocar <b>S/N</b>)</label>

                    <input type="text" id="noExt2" placeholder="Ingrese el No. Exterior" class="form-control">

                    <label for="colonia">Colonia</label>

                    <input type="text" id="colonia2" placeholder="Ingrese la colonia" class="form-control ln">

                    <label for="localidad">Localidad</label>

                    <input type="text" id="localidad2" placeholder="Ingrese la localidad" class="form-control ol">

                    <label for="municipio">Municipio</label>

                    <input type="text" id="municipio2" placeholder="Ingrese el municipio" class="form-control ol">

                    <label for="estado">Estado</label>

                    <input type="text" id="estado2" placeholder="Ingrese el estado" class="form-control ln">

                    <label for="cp">Código postal</label>

                    <input type="number" id="cp2" placeholder="Ingrese el código postal" class="form-control on">

                    <label for="referencias">Referencias del domicilio</label>

                    <input type="text" id="referencias2" placeholder="Ingrese las referencias" class="form-control ln">

                    <hr>

                </div>



                <div class="mb-3" id="divEnviosDocumentos">

                    <label for="direccionEnvio">Dirección para envío de paquetería (según la convocatoria).</label>

                    <textarea type="text" class="form-control" id="direccionEnvio" name="direccionEnvio" placeholder="Nombre de la vialidad (calle, avenida, privada), número Ext. e Int., colonia, localidad, municipio, estado, C.P., referencias del domicilio" required></textarea>

                    <div class="invalid-feedback">

                        Ingrese una dirección para envíos.

                    </div>

                </div>





















            </div>

            <div id="numeros_universidad">

                <div class="mb-3">

                    <label for="telefonoUniversidad">Número de teléfono de la universidad</label>

                    <input type="number" class="form-control on" id="telefonoUniversidad" name="telefonoUniversidad" placeholder="No. teléfono" required>

                    <div class="invalid-feedback">

                        Ingresa el número de teléfono de la universidad.

                    </div>

                </div>

                <div class="mb-3">

                    <label for="telefonoUniversidad">Extensión (Opcional)</label>

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

                    <h3>¿Perteneces a un cuerpo academico PRODEP?</h3>

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

            <button type="button" id="siguiente_miembros" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white;" onclick="mostrarMiembros();">Siguiente</button>

            <div class="mb-3"></div>

            <div class="mb-3"></div>

        </section>



        <section id="cantidad_miembros">

            <h1>Seleccione la cantidad de miembros de su grupo de investigación</h1>

            <div class="cantidad_desktop">
                <div id="divcantidadMiembro" style="display: flex; justify-content: center; align-items: flex-start; align-content: center; flex-wrap: wrap;">

                    <p class="form__answer" id="cantidadMiembro1">

                        <input type="radio" name="c_miembros" id="match_1" value="1">

                        <label for="match_1" style="color: black">

                            <i class="fa fa-user"></i><br>

                            1 miembro

                        </label>

                    </p>

                    <p class="form__answer" id="cantidadMiembro2">

                        <input type="radio" name="c_miembros" id="match_2" value="2">

                        <label for="match_2" style="color: black">

                            <i class="fa fa-user">&nbsp</i><i class="fa fa-user"></i><br>

                            2 miembros

                        </label>

                    </p>

                    <p class="form__answer" id="cantidadMiembro3">

                        <input type="radio" name="c_miembros" id="match_3" value="3">

                        <label for="match_3" style="color: black">

                            <i class="fa fa-user">&nbsp</i><i class="fa fa-user">&nbsp</i><i class="fa fa-user"></i><br>

                            3 miembros

                        </label>

                    </p>

                    <p class="form__answer" id="cantidadMiembro4">

                        <input type="radio" name="c_miembros" id="match_4" value="4">

                        <label for="match_4" style="color: black">

                            <i class="fa fa-user">&nbsp</i><i class="fa fa-user">&nbsp</i><i class="fa fa-user">&nbsp</i><i class="fa fa-user"> </i><br>

                            4 miembros

                        </label>

                    </p>

                </div>
            </div>

            <div class="cantidad_mobile">
                <div class="row">
                    <div class="col-md-6">
                        <p class="form__answer">

                            <input type="radio" name="c_miembros" id="match_1" value="1">

                            <label for="match_1">

                                <i class="fa fa-user"></i><br>

                                1 miembro

                            </label>

                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="form__answer">

                            <input type="radio" name="c_miembros" id="match_2" value="2">

                            <label for="match_2">

                                <i class="fa fa-user">&nbsp</i><i class="fa fa-user"></i><br>

                                2 miembros

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

                                3 miembros

                            </label>

                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="form__answer">

                            <input type="radio" name="c_miembros" id="match_4" value="4">

                            <label for="match_4">

                                <i class="fa fa-user">&nbsp</i><i class="fa fa-user"></i><br>

                                4 miembros

                            </label>

                        </p>
                    </div>
                </div>
            </div>












            <button type="button" id="siguiente_datos" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white;">Siguiente</button>

            <button type="button" id="regresar_universidad" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white;">Anterior</button>

        </section>



        <section id="datos_miembros">

            <h1>Añadir datos de miembros</h1>

            <hr>

            <div class="row" id="miembro1" style="display:none">

                <div class="col-md-3">

                    <div class="text-center">

                        <img src="<?= base_url("resources/img/registros_redes/avatar_hombre.png"); ?>" style="width:110px; height: 130px" id="imagenAvatar1" alt="">

                    </div>

                    <br>

                    <div class="text-center">

                        <!--============= apartado de radio css ================-->

                        <div class="yc-form">

                            <input type="radio" id="hombre1" name="miembros[1][sexo]" onchange="cambiaravatar(1)" value="1" checked required />

                            <label for="hombre1" id="labelHombre1" class="sexo">Hombre</label>

                            <input type="radio" id="mujer1" name="miembros[1][sexo]" onchange="cambiaravatar(1)" value="0" required />

                            <label for="mujer1" id="labelMujer1" class="sexo">Mujer</label>

                        </div>

                        <!--============= apartado de radio css ================-->

                    </div>

                </div>

                <div class="col-md-9">

                    <h1>Datos del lider</h1>

                    <div id="correo_miembro_1">

                        <div class="mb-3">

                            <label for="correop1">Correo personal</label>

                            <input type="email" class="form-control oe" id="correop1" name="miembros[1][correo_personal]" placeholder="Correo personal">

                            <div class="invalid-feedback">

                                Ingresa un correo electrónico válido.

                            </div>

                            <br>

                            <button type="button" class="btn btn-miembros btn-block" id="validarCorreo1" onclick="verificarCorreo(1);">Validar correo</button>

                            <input type="text" hidden id="usuario1" name="miembros[1][usuario]">

                            <input type="text" hidden name="miembros[1][lider]" value="1">

                        </div>

                    </div>

                    <div id="datos_miembro_1">

                        <div class="mb-3">

                            <label for="nombre1">Nombre</label>

                            <input type="text" class="form-control ol" id="nombre1" name="miembros[1][nombre]" placeholder="Nombre">

                            <div class="invalid-feedback">

                                Ingresa el nombre.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="appat1">Apellido paterno</label>

                            <input type="text" class="form-control ol" id="appat1" name="miembros[1][ap_paterno]" placeholder="Apellido paterno">

                            <div class="invalid-feedback">

                                Ingresa el apellido paterno.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="apmat1">Apellido materno</label>

                            <input type="text" class="form-control ol" id="apmat1" name="miembros[1][ap_materno]" placeholder="Apellido materno">

                            <div class="invalid-feedback">

                                Ingresa el apellido materno.

                            </div>

                        </div>







                        <div class="mb-3">

                            <label for="nacionalidad1">Nacionalidad</label>

                            <select class="form-control" name="miembros[1][nacionalidad]" id="nacionalidad1" onChange="nacionalidad(1)">



                            </select>

                            <div class="invalid-feedback">

                                Seleccione una nacionalidad

                            </div>

                        </div>



                        <!-- div otra nacionalidad-->

                        <div class="mb-3" id="divOtraNAcionalidad1" style="display:none">

                            <label for="nacionalidad1">Nombre de la nacionalidad</label>

                            <input type="text" class="form-control ol" id="otraNacionalidad1" name="miembros[1][nacionalidad]" placeholder="Nacionalidad">

                            <div class="invalid-feedback">

                                Ingresa el nombre de la nacionalidad.

                            </div>

                        </div>











                        <div class="mb-3">

                            <label for="grado1">Grado académico</label>

                            <select class="form-control" name="miembros[1][grado_academico]" id="grado1">

                                <option value="" selected="true" disabled>Selecciona grado académico</option>

                                <?php

                                foreach ($grados_academicos as $ga) {

                                ?>

                                    <option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>

                                <?php

                                }

                                ?>

                            </select>

                            <div class="invalid-feedback">

                                Seleccione un grado académico

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="especialidad1">Especialidad</label>

                            <input type="text" class="form-control ol" id="especialidad1" name="miembros[1][especialidad]" placeholder="Especialidad">

                            <div class="invalid-feedback">

                                Ingresa el nombre de la especialidad.

                            </div>

                        </div>



                        <!-- ========= SNI ================ -->



                        <div class="mb-3">

                            <label for="">SNI</label><br>

                            <label id="siSNI1" class="custom-control custom-radio custom-control-inline">

                                <input type="radio" name="miembros[1][SNI]" value="no" id="radioSNI1" checked="" class="custom-control-input prodep" onclick="miembroSNI(1)" required><span class="custom-control-label">No</span>

                            </label>

                            <label id="noSNI1" class="custom-control custom-radio custom-control-inline">

                                <input type="radio" name="miembros[1][SNI]" value="si" id="radioSNI1" class="custom-control-input prodep" onclick="miembroSNI(1)" required><span class="custom-control-label">Si</span>

                            </label>

                        </div>







                        <div id="datosSNI1" style="display:none">

                            <div class="mb-3">

                                <label for="nivelSNI1">Nivel SNI</label>

                                <select class="form-control" name="miembros[1][nivelSNI]" id="nivelSNI1">

                                    <option value="" selected="true" disabled>Selecciona nivel SNI</option>

                                    <option value="1">Candidato a Investigador Nacional</option>

                                    <option value="2">Investigador Nacional Nivel I</option>

                                    <option value="3">Investigador Nacional Nivel II</option>

                                    <option value="4">Investigador Nacional Nivel III</option>

                                    <option value="5">Investigador Nacional Emérito</option>

                                    <?php

                                    //foreach ($grados_academicos as $ga) {

                                    ?>

                                    <!--<option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>-->

                                    <?php

                                    //}

                                    ?>

                                </select>

                                <div class="invalid-feedback">

                                    Ingrese el nivel SNI

                                </div>

                            </div>



                            <div class="mb-3">

                                <label for="anioSNI1">Año en que obtuvo el nivel</label>

                                <input type="number" class="form-control on" id="anioSNI1" name="miembros[1][anoSNI]" placeholder="Año SNI">

                                <div class="invalid-feedback">

                                    Año en que obtuvo el nivel

                                </div>

                            </div>

                        </div>

                        <!--  ========== SNI ============= -->





                        <div class="mb-3">

                            <label for="telefono1">Teléfono</label>

                            <div id='msjTelefonoMaestros1' hidden></div>

                            <input type="tel" class="form-control" id="telefono1" name="miembros[1][telefono]" placeholder="Telefono">

                            <div class="invalid-feedback">

                                Ingresa su número de teléfono.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="correoi1">Correo institucional</label>

                            <input type="email" class="form-control oe" id="correoi1" name="miembros[1][correo_institucional]" placeholder="Correo institucional">

                            <div class="invalid-feedback">

                                Ingresa su correo institucional.

                            </div>

                        </div>

                    </div>



                </div>



            </div>

            <div class="row" id="miembro2" style="display:none">

                <div class="col-md-3">

                    <div class="text-center">

                        <img src="<?= base_url("resources/img/registros_redes/avatar_hombre.png"); ?>" id="imagenAvatar2" style="width:110px; height: 130px" alt="">

                    </div>

                    <br>

                    <div class="text-center">

                        <div class="yc-form">

                            <input type="radio" id="hombre2" name="miembros[2][sexo]" onchange="cambiaravatar(2)" value="1" checked required />

                            <label for="hombre2" id="labelHombre2" class="sexo">Hombre</label>

                            <input type="radio" id="mujer2" name="miembros[2][sexo]" onchange="cambiaravatar(2)" value="0" required />

                            <label for="mujer2" id="labelMujer2" class="sexo">Mujer</label>

                        </div>

                    </div>

                </div>

                <div class="col-md-9">

                    <h1>Datos miembro 1</h1>

                    <div id="correo_miembro_2">

                        <div class="mb-3">

                            <label for="correop2">Correo personal</label>

                            <input type="text" class="form-control oe" id="correop2" name="miembros[2][correo_personal]" placeholder="Correo personal" required>

                            <div class="invalid-feedback">

                                Ingresa un correo electrónico válido.

                            </div>

                            <br>

                            <button type="button" class="btn btn-miembros btn-block" id="validarCorreo2" onclick="verificarCorreo(2);">Validar correo</button>

                            <input type="text" hidden id="usuario2" name="miembros[2][usuario]">

                            <input type="text" hidden name="miembros[2][lider]" value="0">

                        </div>

                    </div>

                    <div id="datos_miembro_2">

                        <div class="mb-3">

                            <label for="nombre2">Nombre</label>

                            <input type="text" class="form-control ol" id="nombre2" name="miembros[2][nombre]" placeholder="Nombre" required>

                            <div class="invalid-feedback">

                                Ingresa el nombre.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="appat2">Apellido paterno</label>

                            <input type="text" class="form-control ol" id="appat2" name="miembros[2][ap_paterno]" placeholder="Apellido paterno" required>

                            <div class="invalid-feedback">

                                Ingresa el apellido paterno.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="apmat2">Apellido materno</label>

                            <input type="text" class="form-control ol" id="apmat2" name="miembros[2][ap_materno]" placeholder="Apellido materno" required>

                            <div class="invalid-feedback">

                                Ingresa el apellido materno.

                            </div>

                        </div>





                        <div class="mb-3">

                            <label for="nacionalidad2">Nacionalidad</label>

                            <select class="form-control" name="miembros[2][nacionalidad]" id="nacionalidad2" onChange="nacionalidad(2)">



                            </select>

                            <div class="invalid-feedback">

                                Seleccione una nacionalidad

                            </div>

                        </div>



                        <!-- div otra nacionalidad-->

                        <div class="mb-3" id="divOtraNAcionalidad2" style="display:none">

                            <label for="nacionalidad2">Nombre nacionalidad</label>

                            <input type="text" class="form-control ol" id="otraNacionalidad2" name="miembros[2][nacionalidad]" placeholder="Nacionalidad">

                            <div class="invalid-feedback">

                                Ingresa el nombre de la nacionalidad.

                            </div>

                        </div>





                        <div class="mb-3">

                            <label for="grado2">Grado académico</label>

                            <select class="form-control" name="miembros[2][grado_academico]" id="grado2">

                                <option value="" selected="true" disabled>Selecciona grado académico</option>

                                <?php

                                foreach ($grados_academicos as $ga) {

                                ?>

                                    <option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>

                                <?php

                                }

                                ?>

                            </select>

                            <div class="invalid-feedback">

                                Seleccione un grado académico

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="especialidad2">Especialidad</label>

                            <input type="text" class="form-control ol" id="especialidad2" name="miembros[2][especialidad]" placeholder="Especialidad" required>

                            <div class="invalid-feedback">

                                Ingresa el nombre de la especialidad.

                            </div>

                        </div>



                        <!-- ========= SNI ================ -->



                        <div class="mb-3">

                            <label for="">SNI</label><br>

                            <label id="siSNI2" class="custom-control custom-radio custom-control-inline">

                                <input type="radio" name="miembros[2][SNI]" value="no" id="radioSNI2" checked="" class="custom-control-input prodep" onclick="miembroSNI(2)" required><span class="custom-control-label">No</span>

                            </label>

                            <label id="noSNI2" class="custom-control custom-radio custom-control-inline">

                                <input type="radio" name="miembros[2][SNI]" value="si" id="radioSNI2" class="custom-control-input prodep" onclick="miembroSNI(2)" required><span class="custom-control-label">Si</span>

                            </label>

                        </div>







                        <div id="datosSNI2" style="display:none">

                            <div class="mb-3">

                                <label for="nivelSNI2">Nivel SNI</label>

                                <select class="form-control" name="miembros[2][nivelSNI]" id="nivelSNI2">

                                    <option value="" selected="true" disabled>Selecciona nivel SNI</option>

                                    <option value="1">Candidato a Investigador Nacional</option>

                                    <option value="2">Investigador Nacional Nivel I</option>

                                    <option value="3">Investigador Nacional Nivel II</option>

                                    <option value="4">Investigador Nacional Nivel III</option>

                                    <option value="5">Investigador Nacional Emérito</option>

                                    <?php

                                    //foreach ($grados_academicos as $ga) {

                                    ?>

                                    <!--<option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>-->

                                    <?php

                                    //}

                                    ?>

                                </select>

                                <div class="invalid-feedback">

                                    Ingrese el nivel SNI

                                </div>

                            </div>



                            <div class="mb-3">

                                <label for="anioSNI2">Año en que obtuvo el nivel</label>

                                <input type="number" class="form-control on" id="anioSNI2" name="miembros[2][anoSNI]" placeholder="Año SNI">

                                <div class="invalid-feedback">

                                    Año en que obtuvo el nivel

                                </div>

                            </div>

                        </div>

                        <!--  ========== SNI ============= -->





                        <div class="mb-3">

                            <label for="telefono2">Teléfono</label>

                            <div id='msjTelefonoMaestros2' hidden></div>

                            <input type="tel" class="form-control" id="telefono2" name="miembros[2][telefono]" placeholder="Telefono" required>

                            <div class="invalid-feedback">

                                Ingresa su número de teléfono.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="correoi2">Correo institucional</label>

                            <input type="text" class="form-control oe" id="correoi2" name="miembros[2][correo_institucional]" placeholder="Correo institucional" required>

                            <div class="invalid-feedback">

                                Ingresa su correo institucional.

                            </div>

                        </div>

                    </div>



                </div>



            </div>

            <div class="row" id="miembro3" style="display:none">

                <div class="col-md-3">

                    <div class="text-center">

                        <img src="<?= base_url("resources/img/registros_redes/avatar_hombre.png"); ?>" id="imagenAvatar3" style="width:110px; height: 130px" alt="">

                    </div>

                    <br>

                    <div class="text-center">

                        <div class="yc-form">

                            <input type="radio" id="hombre3" name="miembros[3][sexo]" onchange="cambiaravatar(3)" value="1" checked required />

                            <label for="hombre3" id="labelHombre3" class="sexo">Hombre</label>

                            <input type="radio" id="mujer3" name="miembros[3][sexo]" onchange="cambiaravatar(3)" value="0" required />

                            <label for="mujer3" id="labelMujer3" class="sexo">Mujer</label>

                        </div>

                    </div>

                </div>

                <div class="col-md-9">

                    <h1>Datos miembro 2</h1>

                    <div id="correo_miembro_3">

                        <div class="mb-3">

                            <label for="correop3">Correo personal</label>

                            <input type="text" class="form-control oe" id="correop3" name="miembros[3][correo_personal]" placeholder="Correo personal" required>

                            <div class="invalid-feedback">

                                Ingrese un correo electrónico válido.

                            </div>

                            <br>

                            <button type="button" class="btn btn-miembros btn-block" id="validarCorreo3" onclick="verificarCorreo(3);">Validar correo</button>

                            <input type="text" hidden id="usuario3" name="miembros[3][usuario]">

                            <input type="text" hidden name="miembros[3][lider]" value="0">

                        </div>

                    </div>



                    <div id="datos_miembro_3">

                        <div class="mb-3">

                            <label for="nombre3">Nombre</label>

                            <input type="text" class="form-control ol" id="nombre3" name="miembros[3][nombre]" placeholder="Nombre" required>

                            <div class="invalid-feedback">

                                Ingresa el nombre.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="appat3">Apellido paterno</label>

                            <input type="text" class="form-control ol" id="appat3" name="miembros[3][ap_paterno]" placeholder="Apellido paterno" required>

                            <div class="invalid-feedback">

                                Ingresa el apellido paterno.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="apmat3">Apellido materno</label>

                            <input type="text" class="form-control ol" id="apmat3" name="miembros[3][ap_materno]" placeholder="Apellido materno" required>

                            <div class="invalid-feedback">

                                Ingresa el apellido materno.

                            </div>

                        </div>



                        <div class="mb-3">

                            <label for="nacionalidad3">Nacionalidad</label>

                            <select class="form-control" name="miembros[3][nacionalidad]" id="nacionalidad3" onChange="nacionalidad(3)">



                            </select>

                            <div class="invalid-feedback">

                                Seleccione una nacionalidad

                            </div>

                        </div>



                        <!-- div otra nacionalidad-->

                        <div class="mb-3" id="divOtraNAcionalidad3" style="display:none">

                            <label for="nacionalidad3">Nombre nacionalidad</label>

                            <input type="text" class="form-control ol" id="otraNacionalidad3" name="miembros[3][nacionalidad]" placeholder="Nacionalidad">

                            <div class="invalid-feedback">

                                Ingresa el nombre de la nacionalidad.

                            </div>

                        </div>





                        <div class="mb-3">

                            <label for="grado3">Grado académico</label>

                            <select class="form-control" name="miembros[3][grado_academico]" id="grado3">

                                <option value="" selected="true" disabled>Selecciona grado académico</option>

                                <?php

                                foreach ($grados_academicos as $ga) {

                                ?>

                                    <option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>

                                <?php

                                }

                                ?>

                            </select>

                            <div class="invalid-feedback">

                                Seleccione un grado académico

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="especialidad3">Especialidad</label>

                            <input type="text" class="form-control ol" id="especialidad3" name="miembros[3][especialidad]" placeholder="Especialidad" required>

                            <div class="invalid-feedback">

                                Ingresa el nombre de la especialidad.

                            </div>

                        </div>



                        <!-- ========= SNI ================ -->



                        <div class="mb-3">

                            <label for="radioSNI3">SNI</label><br>

                            <label id="siSNI3" class="custom-control custom-radio custom-control-inline">

                                <input type="radio" name="miembros[3][SNI]" value="no" id="radioSNI3" checked="" class="custom-control-input prodep" onclick="miembroSNI(3)" required><span class="custom-control-label">No</span>

                            </label>

                            <label id="noSNI3" class="custom-control custom-radio custom-control-inline">

                                <input type="radio" name="miembros[3][SNI]" value="si" id="radioSNI3" class="custom-control-input prodep" onclick="miembroSNI(3)" required><span class="custom-control-label">Si</span>

                            </label>

                        </div>







                        <div id="datosSNI3" style="display:none">

                            <div class="mb-3">

                                <label for="nivelSNI3">Nivel SNI</label>

                                <select class="form-control" name="miembros[3][nivelSNI]" id="nivelSNI3">

                                    <option value="" selected="true" disabled>Selecciona nivel SNI</option>

                                    <option value="1">Candidato a Investigador Nacional</option>

                                    <option value="2">Investigador Nacional Nivel I</option>

                                    <option value="3">Investigador Nacional Nivel II</option>

                                    <option value="4">Investigador Nacional Nivel III</option>

                                    <option value="5">Investigador Nacional Emérito</option>

                                    <?php

                                    //foreach ($grados_academicos as $ga) {

                                    ?>

                                    <!--<option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>-->

                                    <?php

                                    //}

                                    ?>

                                </select>

                                <div class="invalid-feedback">

                                    Ingrese el nivel SNI

                                </div>

                            </div>



                            <div class="mb-3">

                                <label for="anioSNI3">Año en que obtuvo el nivel</label>

                                <input type="number" class="form-control on" id="anioSNI3" name="miembros[3][anoSNI]" placeholder="Año SNI">

                                <div class="invalid-feedback">

                                    Año en que obtuvo el nivel

                                </div>

                            </div>

                        </div>

                        <!--  ========== SNI ============= -->

                        <div class="mb-3">

                            <label for="telefono3">Teléfono</label>

                            <div id='msjTelefonoMaestros3' hidden></div>

                            <input type="tel" class="form-control" id="telefono3" name="miembros[3][telefono]" placeholder="Telefono" required>

                            <div class="invalid-feedback">

                                Ingresa su número de teléfono.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="correoi3">Correo institucional</label>

                            <input type="text" class="form-control oe" id="correoi3" name="miembros[3][correo_institucional]" placeholder="Correo institucional" required>

                            <div class="invalid-feedback">

                                Ingresa su correo institucional.

                            </div>

                        </div>

                    </div>



                </div>



            </div>

            <div class="row" id="miembro4" style="display:none">

                <div class="col-md-3">

                    <div class="text-center">

                        <img src="<?= base_url("resources/img/registros_redes/avatar_hombre.png"); ?>" id="imagenAvatar4" style="width:110px; height: 130px" alt="">

                    </div>

                    <br>

                    <div class="text-center">

                        <div class="yc-form">

                            <input type="radio" id="hombre4" name="miembros[4][sexo]" onchange="cambiaravatar(4)" value="1" checked required />

                            <label for="hombre4" id="labelHombre4" class="sexo">Hombre</label>

                            <input type="radio" id="mujer4" name="miembros[4][sexo]" onchange="cambiaravatar(4)" value="0" required />

                            <label for="mujer4" id="labelMujer4" class="sexo">Mujer</label>

                        </div>

                    </div>

                </div>

                <div class="col-md-9">

                    <h1>Datos miembro 3</h1>
                    <!--HAY QUE HACERLO COMO ESTE CON ESTAS CLAUSULAS miembros[4][sexo]-->

                    <div id="correo_miembro_4">

                        <div class="mb-3">

                            <label for="correop4">Correo personal</label>

                            <input type="text" class="form-control oe" id="correop4" name="miembros[4][correo_personal]" placeholder="Correo personal" required>

                            <div class="invalid-feedback">

                                Ingrese un correo electrónico válido.

                            </div>

                            <br>

                            <button type="button" class="btn btn-miembros btn-block" id="validarCorreo4" onclick="verificarCorreo(4);">Validar correo</button>

                            <input type="text" hidden id="usuario4" name="miembros[4][usuario]">

                            <input type="text" hidden name="miembros[4][lider]" value="0">

                        </div>

                    </div>

                    <div id="datos_miembro_4">

                        <div class="mb-3">

                            <label for="nombre4">Nombre</label>

                            <input type="text" class="form-control ol" id="nombre4" name="miembros[4][nombre]" placeholder="Nombre" required>

                            <div class="invalid-feedback">

                                Ingresa el nombre.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="appat4">Apellido paterno</label>

                            <input type="text" class="form-control ol" id="appat4" name="miembros[4][ap_paterno]" placeholder="Apellido paterno" required>

                            <div class="invalid-feedback">

                                Ingresa el apellido paterno.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="apmat4">Apellido materno</label>

                            <input type="text" class="form-control ol" id="apmat4" name="miembros[4][ap_materno]" placeholder="Apellido materno" required>

                            <div class="invalid-feedback">

                                Ingresa el apellido materno.

                            </div>

                        </div>



                        <div class="mb-3">

                            <label for="nacionalidad4">Nacionalidad</label>

                            <select class="form-control" name="miembros[4][nacionalidad]" id="nacionalidad4" onChange="nacionalidad(4)">



                            </select>

                            <div class="invalid-feedback">

                                seleccione una nacionalidad

                            </div>

                        </div>



                        <!-- div otra nacionalidad-->

                        <div class="mb-3" id="divOtraNAcionalidad4" style="display:none">

                            <label for="nacionalidad4">Nombre nacionalidad</label>

                            <input type="text" class="form-control ol" id="otraNacionalidad4" name="miembros[4][nacionalidad]" placeholder="Nacionalidad">

                            <div class="invalid-feedback">

                                Ingresa el nombre de la nacionalidad.

                            </div>

                        </div>





                        <div class="mb-3">

                            <label for="grado4">Grado académico</label>

                            <select class="form-control" name="miembros[4][grado_academico]" id="grado4">

                                <option value="" selected="true" disabled>Selecciona grado académico</option>

                                <?php

                                foreach ($grados_academicos as $ga) {

                                ?>

                                    <option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>

                                <?php

                                }

                                ?>

                            </select>

                            <div class="invalid-feedback">

                                Seleccione un grado académico

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="especialidad4">Especialidad</label>

                            <input type="text" class="form-control ol" id="especialidad4" name="miembros[4][especialidad]" placeholder="Especialidad" required>

                            <div class="invalid-feedback">

                                Ingresa el nombre de la especialidad.

                            </div>

                        </div>



                        <!-- ========= SNI ================ -->



                        <div class="mb-3">

                            <label for="radioSNI4">SNI</label><br>

                            <label id="siSNI4" class="custom-control custom-radio custom-control-inline">

                                <input type="radio" name="miembros[4][SNI]" value="no" id="radioSNI4" checked="" class="custom-control-input prodep" onclick="miembroSNI(4)" required><span class="custom-control-label">No</span>

                            </label>

                            <label id="noSNI4" class="custom-control custom-radio custom-control-inline">

                                <input type="radio" name="miembros[4][SNI]" value="si" id="radioSNI4" class="custom-control-input prodep" onclick="miembroSNI(4)" required><span class="custom-control-label">Si</span>

                            </label>

                        </div>







                        <div id="datosSNI4" style="display:none">

                            <div class="mb-3">

                                <label for="nivelSNI4">Nivel SNI</label>

                                <select class="form-control" name="miembros[4][nivelSNI]" id="nivelSNI4">

                                    <option value="" selected="true" disabled>Selecciona nivel SNI</option>

                                    <option value="1">Candidato a Investigador Nacional</option>

                                    <option value="2">Investigador Nacional Nivel I</option>

                                    <option value="3">Investigador Nacional Nivel II</option>

                                    <option value="4">Investigador Nacional Nivel III</option>

                                    <option value="5">Investigador Nacional Emérito</option>

                                    <?php

                                    //foreach ($grados_academicos as $ga) {

                                    ?>

                                    <!--<option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>-->

                                    <?php

                                    //}

                                    ?>

                                </select>

                                <div class="invalid-feedback">

                                    Ingrese el nivel SNI

                                </div>

                            </div>



                            <div class="mb-3">

                                <label for="anioSNI4">Año en que obtuvo el nivel</label>

                                <input type="number" class="form-control on" id="anioSNI4" name="miembros[4][anoSNI]" placeholder="Año SNI">

                                <div class="invalid-feedback">

                                    Ingrese el año en que obtuvo el nivel

                                </div>

                            </div>

                        </div>

                        <!--  ========== SNI ============= -->

                        <div class="mb-3">

                            <label for="telefono4">Teléfono</label>

                            <div id='msjTelefonoMaestros4' hidden></div>

                            <input type="tel" class="form-control" id="telefono4" name="miembros[4][telefono]" placeholder="Telefono" required>

                            <div class="invalid-feedback">

                                Ingrese su número de teléfono.

                            </div>

                        </div>

                        <div class="mb-3">

                            <label for="correoi4">Correo institucional</label>

                            <input type="text" class="form-control oe" id="correoi4" name="miembros[4][correo_institucional]" placeholder="Correo institucional" required>

                            <div class="invalid-feedback">

                                Ingresa su correo institucional.

                            </div>

                        </div>

                    </div>

                </div>



            </div>

            <button type="submit" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white; display: none;" id="btnTerminarRegistro" name="btnTerminarRegistro2">Terminar registro</button>

            <button type="button" id="siguiente_cantidad_alumnos" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white; display: none;">Siguiente</button>

            <button type="button" id="regresar_cantidad" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white;">Anterior</button>

        </section>



        <section id="cantidad_alumnos">

            <h1>Seleccione la cantidad de alumnos de su grupo de investigación</h1>



            <!--<p class="form__answer"><input type="radio" name="c_alumnos" id="alumnos_match_1" value="1"><label-->

            <!--           for="alumnos_match_1" style="color: black"><i class="fa fa-user" aria-hidden="true">&nbsp;</i><br>1-->

            <!--           miembros</label></p>-->



            <div id="divCantidadAlumnos" style="    display: flex; justify-content: center; align-items: flex-start; align-content: center; flex-wrap: wrap;">



            </div>









            <button type="button" id="siguiente_datos_alumnos" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white;">Siguiente</button>

            <button type="button" id="regresar_datos_miembros" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white;">Anterior</button>

        </section>



        <section id="datos_alumnos">

            <h1>Añadir datos de alumnos</h1>

            <hr>



            <div id="datosAlumnos">



            </div>



            <!--El boton sera hasta la ultima seccion-->

            <button type="submit" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white;" id="btnTerminarRegistro">Terminar registro</button>

            <button type="button" id="regresar_cantidad_alumnos" class="btn btn-block" style="background-color: rgb(64, 39, 126); color: white;">Anterior</button>

        </section>

        <section class="text-center">

            <h3>IMPORTANTE</h3>

            Este es un registro para la gestión de su participación en la convocatoria, el líder es quién gestionará los proceso de la misma. Es independiente, no tiene un vínculo directo con su gestión de PRODEP.
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script>
        base_url = "<?php echo base_url() ?>";
    </script>

    <script src="<?= base_url("resources/js/form-validation/inputs.js") ?>"></script>
    <script src="<?= base_url("resources/js/registro/Releem/index.js") ?>"></script>



</body>



</html>