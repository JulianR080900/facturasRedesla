<!DOCTYPE html>

<html lang="es-MX" dir="ltr">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menú RedesLa</title>

    <script src="https://kit.fontawesome.com/cd008eda05.js" crossorigin="anonymous"></script>

    <script src="<?= base_url('resources/jquery/jquery.min.js') ?>"></script> <!-- V. 3.6.1 -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url('resources/css/datatables.css') ?>">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php
    if ($_SESSION['theme'] == 'dark') {
    ?>
        <link rel="stylesheet" id="styles" href="<?php echo base_url("resources/css/dark_header.css") ?>">
    <?php
    } else {
    ?>
        <link rel="stylesheet" id="styles" href="<?php echo base_url("resources/css/light.css") ?>">
    <?php
    }
    ?>


    <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> <!-- Select2-->

    <link rel="stylesheet" id="styles" href="<?php echo base_url("resources/css/select2.min.css") ?>"><!-- Select2-->

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">
    <script src="<?= base_url('resources/js/inicio/index.js') ?>"></script>

</head>



<body>

    <style type="text/css">
        .sidebar a:hover {
            background: var(--<?= $_SESSION['red'] ?>);
        }

        label #sidebar_btn:hover {
            color: var(--<?= $_SESSION['red'] ?>);
        }

        .nav_bar .nav_btn {
            color: var(--<?= $_SESSION['red'] ?>);
        }

        .mobile_nav_items a:hover {
            background: var(--<?= $_SESSION['red'] ?>);
        }
    </style>


    <input type="checkbox" id="check">

    <!--header area start-->

    <header>

        <label for="check">

            <i class="fa fa-bars" id="sidebar_btn"></i>

        </label>

        <div class="left_area">

            <h3>Redesla / <span class="n_<?php echo $_SESSION["red"] ?>"><?php echo $_SESSION["red"]; ?></span></h3>

        </div>



    </header>
    <div id="loader">
        <span class="loader"></span>
    </div>

    <!--header area end-->

    <!--mobile navigation bar start-->

    <div class="mobile_nav">

        <div class="nav_bar">



            <?php

            if ($_SESSION["profile_pic"] !== NULL) {

            ?>

                <img src="<?php echo base_url("resources/img/profiles/" . $_SESSION["profile_pic"]) ?>" class="profile_image" alt="">

            <?php

            } else {

            ?>

                <img src="<?php echo base_url("resources/img/avatar.png") ?>" class="profile_image" alt="">

            <?php

            }

            ?>

            <form method="post" enctype="multipart/form-data" accept=".jpg,.pdf,.png,.jpeg" action="<?php echo base_url("foto"); ?>" id="frmFotoMobile">

                <input type="file" id="profileMobile" name="profileMobile">

            </form>

            <label for="profileMobile" id="uploadBtnMobile">Cambiar</label>

            <i class="fa fa-bars nav_btn"></i>

        </div>

        <div class="mobile_nav_items">

            <a href="<?php echo base_url('inicio/' . $_SESSION["red"] . '/' . $_SESSION["CA"]) ?>"><i class="fa fa-home"></i><span>Inicio</span></a>

            <a href="<?php echo base_url('perfil') ?>"><i class="fa fa-user"></i><span>Perfil</span></a>

            <a data-toggle="collapse" href="#CA_menu_mobile" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-users"></i><span>Grupo</span></a>

            <div class="row">

                <div class="col">

                    <div class="collapse multi-collapse" id="CA_menu_mobile">

                        <a href="<?php echo base_url("Datos_Generales") ?>"><i class="fa fa-home"></i><span>Datos generales</span></a>

                        <a href="<?php echo base_url("Miembros") ?>"><i class="fa fa-users"></i><span>Miembros</span></a>

                        <a href="<?php echo base_url("Carpetas") ?>"><i class="fa-solid fa-folder-tree"></i><span>Carpetas</span></a>

                    </div>

                </div>

            </div>

            <?php
            if (empty($_SESSION['proyectos'])) {
            ?>
                <a href="<?php echo base_url("pagos/inicio") ?>"><i class="fas fa-folder"></i><span>Proyectos</span></a>
            <?php
            } else {
            ?>
                <a data-toggle="collapse" href="#proyectos_menu_mobile" aria-expanded="false" aria-controls="multiCollapseExample2"><i class="fas fa-folder"></i><span>Proyectos</span></a>
            <?php
            }
            ?>
            <div class="row">

                <div class="col">

                    <div class="collapse multi-collapse" id="proyectos_menu_mobile">

                        <?php
                        $arr_proyectos = [];
                        foreach ($_SESSION['proyectos'] as $proyecto) {

                            $nombre_guiones = str_replace(" ", "_", $proyecto["proyecto"]);

                            $anio = preg_match_all('!\d+!', $nombre_guiones, $matches); //Hemos usado el patrón !\d+! para extraer números de la cadena. Si ocurre un error, favor de hacer print_r a $matches

                            if ($anio == 2) {

                                $anio = $matches[0][0] . "-" . $matches[0][1];
                            } else {

                                $anio = $matches[0][0];
                            }

                            if (in_array($proyecto["proyecto"], $arr_proyectos)) {
                                //EXISTE, YA NO LO MOSTRAMOS
                            } else {
                                //NO EXISTE, MOSTRAMOS
                        ?>
                                <a style="border-top:10px; box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.71);-webkit-box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.71);-moz-box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.71);" href="<?php echo base_url('proyecto/' . $nombre_guiones . "/" . $anio) ?>"><i class="fas fa-folder-open"></i><span style="font-size: 12px"><?php echo $proyecto["proyecto"] ?></span></a>
                            <?php
                            }

                            ?>


                        <?php
                            array_push($arr_proyectos, $proyecto["proyecto"]);
                        }

                        ?>

                    </div>

                </div>

            </div>

            <a href="<?php echo base_url("pagos/inicio") ?>"><i class="fas fa-chart-pie"></i><span>Pagos</span></a>

            <a href="<?php echo base_url("facturas") ?>"><i class="fa-solid fa-file-invoice-dollar"></i><span>Facturas</span></a>

            <a href="<?php echo base_url("cuerpos") ?>"><i class="fas fa-globe-americas"></i>Seleccionar red</a>

            <a href="<?php echo base_url("acerca_de") ?>"><i class="fas fa-info-circle"></i><span>Acerca de</span></a>

            <a href="<?= base_url('config') ?>"><i class="fas fa-sliders-h"></i><span>Configuracion</span></a>

            <a href="#" onclick="cambiarPass();"><i class="fas fa-key"></i><span>Cambiar contraseña</span></a>

            <a href="<?= base_url('changeTheme') ?>">
                <?php
                if ($_SESSION['theme'] == 'dark') {
                ?>
                    <i class="fa-solid fa-sun"></i>
                <?php
                } else {
                ?>
                    <i class="fa-solid fa-moon"></i>
                <?php
                }
                ?>
                <span>Cambiar tema</span></a>

            <a href="<?php echo base_url("logout") ?>"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>

        </div>

    </div>

    <!--mobile navigation bar end-->





    <!--sidebar start-->

    <div class="sidebar">

        <div class="profile_info">

            <div class="imgbox">

                <?php

                if ($_SESSION["profile_pic"] !== NULL) {

                ?>

                    <img src="<?php echo base_url("resources/img/profiles/" . $_SESSION["profile_pic"]) ?>" class="profile_image" alt="">

                <?php

                } else {

                ?>

                    <img src="<?php echo base_url("resources/img/avatar.png") ?>" class="profile_image" alt="">

                <?php

                }

                ?>

                <form method="post" enctype="multipart/form-data" action="<?php echo base_url("foto"); ?>" id="frmFoto">

                    <input type="file" id="profile" name="profile" accept=".jpg,.pdf,.png,.jpeg">

                </form>

                <label for="profile" id="uploadBtn">Cambiar</label>

            </div>

            <h4><?php echo $_SESSION["nombre"]; ?></h4>

        </div>

        <a href="<?php echo base_url('inicio/' . $_SESSION["red"] . '/' . $_SESSION["CA"]) ?>"><i class="fa fa-home"></i><span>Inicio</span></a>

        <a href="<?php echo base_url('perfil') ?>"><i class="fa fa-user"></i><span>Perfil</span></a>

        <a data-toggle="collapse" href="#CA_menu" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-users"></i><span>Grupo </span><i class="fas fa-angle-down"></i></a>

        <div class="row menu_grupo">

            <div class="col">

                <div class="collapse multi-collapse" id="CA_menu">

                    <a href="<?php echo base_url("Datos_Generales") ?>"><i class="fa fa-home"></i><span>Datos generales</span></a>

                    <a href="<?php echo base_url("Miembros") ?>"><i class="fa fa-users"></i><span>Miembros</span></a>

                    <a href="<?php echo base_url("Carpetas") ?>"><i class="fa-solid fa-folder-tree"></i><span>Carpetas</span></a>

                </div>

            </div>

        </div>
        <?php
        if (empty($_SESSION['proyectos'])) {
        ?>
            <a href="<?php echo base_url("pagos/inicio") ?>"><i class="fas fa-folder"></i><span>Proyectos</span></a>
        <?php
        } else {
        ?>
            <a data-toggle="collapse" href="#proyectos_menu" aria-expanded="false" aria-controls="multiCollapseExample2"><i class="fas fa-folder"></i><span>Proyectos </span><i class="fas fa-angle-down"></i></a>
        <?php
        }
        ?>

        <div class="row menu_proyectos">

            <div class="col">

                <div class="collapse multi-collapse" id="proyectos_menu">

                    <?php
                    $arr_proyectos = [];
                    foreach ($_SESSION['proyectos'] as $proyecto) {

                        $nombre_guiones = str_replace(" ", "_", $proyecto["proyecto"]);

                        $anio = preg_match_all('!\d+!', $nombre_guiones, $matches); //Hemos usado el patrón !\d+! para extraer números de la cadena. Si ocurre un error, favor de hacer print_r a $matches

                        if ($anio == 2) {

                            $anio = $matches[0][0] . "-" . $matches[0][1];
                        } else {

                            $anio = $matches[0][0];
                        }

                        if (in_array($proyecto["proyecto"], $arr_proyectos)) {
                            //EXISTE, YA NO LO MOSTRAMOS
                        } else {
                            //NO EXISTE, MOSTRAMOS
                            if($proyecto['anio'] >= 2024 && $proyecto['esquema'] != ''){
                                ?>
                                <a style="border-top:10px; box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.71);-webkit-box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.71);-moz-box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.71);" href="<?php echo base_url('proyecto/investigacion/' . $proyecto['esquema'] . "/" . $proyecto['anio']) ?>"><i class="fas fa-folder-open"></i><span style="font-size: 12px"><?php echo $proyecto["proyecto"] ?></span></a>
                                <?php
                            }else{
                                ?>
                                <a style="border-top:10px; box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.71);-webkit-box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.71);-moz-box-shadow: 0px 1px 0px 0px rgba(0,0,0,0.71);" href="<?php echo base_url('proyecto/' . $nombre_guiones . "/" . $anio) ?>"><i class="fas fa-folder-open"></i><span style="font-size: 12px"><?php echo $proyecto["proyecto"] ?></span></a>
                                <?php
                            }
                        }

                        ?>


                    <?php
                        array_push($arr_proyectos, $proyecto["proyecto"]);
                    }

                    ?>

                </div>

            </div>

        </div>

        <!-- Esto se condiciona -->

        <?php

        if ($_SESSION["lider_ca"] == 1) {

        ?>

            <a href="<?php echo base_url("pagos/inicio") ?>"><i class="fas fa-chart-pie"></i><span>Pagos</span></a>

            <a href="<?php echo base_url("facturas") ?>"><i class="fa-solid fa-file-invoice-dollar"></i><span>Facturas</span></a>

        <?php

        }

        ?>

        <a href="<?php echo base_url("cuerpos") ?>"><i class="fas fa-globe-americas"></i><span>Seleccionar red</span></a>

        <a href="<?php echo base_url("acerca_de") ?>"><i class="fas fa-info-circle"></i><span>Acerca de</span></a>

        <!--<a href="#"><i class="fas fa-sliders-h"></i><span>Configuración</span></a>-->

        <a href="#" onclick="cambiarPass();"><i class="fas fa-key"></i><span>Cambiar contraseña</span></a>
        <a href="<?= base_url('changeTheme') ?>">
            <?php
            if ($_SESSION['theme'] == 'dark') {
            ?>
                <i class="fa-solid fa-sun"></i>
            <?php
            } else {
            ?>
                <i class="fa-solid fa-moon"></i>
            <?php
            }
            ?>
            <span>Cambiar tema</span></a>

        <!--<a href="#" value="light" class="theme"><i class="fas fa-adjust"></i><span>Tema</span></a>

      <input type="text" class="act_theme" value="dark" hidden>-->

        <a href="<?php echo base_url("logout") ?>"><i class="fas fa-sign-out-alt"></i><span>Cerrar sesión</span></a>

    </div>





    <!-- Modal -->

    <div class="modal fade" id="cambiarPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLongTitle">Cambiar contraseña</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: var( --font-color-primary);">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body card-body-password">

                    <div class="col-md-12">

                        <label for="pass_act">Contraseña actual:</label><br>

                        <input hidden value="<?php echo $_SESSION["pass"] ?>" id="pass_bd" name="pass_bd">

                        <input class="form-control form-control-lg input-lg" autocomplete="off" type="password" autocomplete="new-password" placeholder="Ingrese su contraseña actual" required id="pass_act" name="pass_act" required><br>

                        <button class="btn btn-block bg-<?= $_SESSION['red'] ?>" id="validacion">Validar contraseña</button>

                    </div><br>

                    <div class="col-md-12" id="form_new">

                        <label for="nueva_pass">Nueva contraseña:</label>

                        <input class="form-control input-lg" type="password" autocomplete="new-password" placeholder="Nueva contraseña" required id="nueva_pass">

                        <br>

                        <span id="mensaje"></span>

                        <div id="pswd_info">

                            <h4>La contraseña debería cumplir con los siguientes requerimientos:</h4>

                            <ul>

                                <li id="capital">Al menos debería tener <strong>una letra en mayúsculas</strong></li>

                                <li> Un caracter especial: <strong>!@#$&*_-</strong></li>

                                <li id="number">Al menos debería tener <strong>un número</strong></li>

                                <li id="length">Debería tener <strong>8 carácteres</strong> como mínimo</li>

                            </ul>

                        </div>

                        <label for="nueva_pass_confirm">Confirmar contraseña:</label>

                        <input class="form-control input-lg" type="password" autocomplete="new-password" required id="nueva_pass_confirm">

                        <span id="advertencia" style="display:none">Al momento de actualizar su contraseña, se cerrara su sesión y tendra que ingresar con su nueva contraseña</span><br><br>

                        <button class="btn btn-block bg-<?= $_SESSION['red'] ?>" id="btn_act_pass" disabled>Actualizar contraseña</button>

                        <input hidden value="<?= $_SESSION["usuario"]; ?>" id="id_m" name="id_m">

                    </div>

                </div>

                <div class="modal-footer" hidden>

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>

                    <button type="button" class="btn bg-<?= $_SESSION['red'] ?>">Guardar cambios</button>

                </div>

            </div>

        </div>

    </div>