<!DOCTYPE html>

<html lang="es-MX" dir="ltr">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menú RedesLa</title>
    <!-- FAVICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">

    <!-- JQUERY -->
    <script src="<?= base_url('resources/jquery/jquery.min.js') ?>"></script> <!-- V. 3.7.1 -->

    <!-- SELECT2 -->
    <link rel="stylesheet" id="styles" href="<?php echo base_url("resources/css/select2.min.css") ?>">

    <!-- BOOTSTRAP 4 -->
    <link rel="stylesheet" href="<?= base_url('resources/bootstrap4/css/bootstrap.min.css') ?>">

    <!-- FONTAWSOME 6 -->
    <link rel="stylesheet" href="<?= base_url('resources/fontawesome/css/all.css') ?>">
    </link>

    <!-- SWEETALERT2 -->
    <script src="<?= base_url('resources/sweetalert/sweetalert2.all.min.js') ?>"></script>

    <!-- DATATABLES -->

    <link rel="stylesheet" href="<?= base_url('resources/datatables/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('resources/datatables/buttons.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('resources/datatables/jquery.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('resources/datatables/responsive.dataTables.min.css') ?>">

    <!-- ARCHIVOS PROPIOS -->
    <link rel="stylesheet" href="<?= base_url('resources/css/index.css') ?>"> <!-- estilos principal -->


    <!-- <script src="https://kit.fontawesome.com/cd008eda05.js" crossorigin="anonymous"></script> -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css"> -->
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
    <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> <!-- Select2-->




    <script type="text/javascript">
        var base_url = '<?= base_url() ?>';
        var red = '<?= session('red') ?>';
        var profile_pic = '<?= session('profile_pic') ?>'
        var nombreUser = '<?= session('nombre') ?>'
    </script>

</head>



<body>

    <style type="text/css">
        .sidebar a:hover {
            background: var(--<?= $_SESSION['red'] ?>);
        }

        .nav_link:hover {
            background: var(--<?= $_SESSION['red'] ?>);
        }
    </style>

    <div id="loader">
        <span class="loader"></span>
    </div>

    <nav class="navbar">
        <div class="logo_item">
            <i class="fa-solid fa-bars" id="sidebarOpen"></i>
            <span class="title">RedesLA / <span class="n_<?= $_SESSION["red"] ?>"> <?= $_SESSION["red"] ?></span>
        </div>
        <div class="search_bar">
            <!-- <input type="text" placeholder="Search" /> -->
        </div>
        <div class="navbar_content" id="navContent">

            <div class="content-notification" data-cnoti='<?= session('mensajes_activo') ?>' id="notificationsMenu">
                <div class="notifications">
                    <div class="icon_wrap">
                        <i class="fa-solid fa-bell"></i>
                    </div>

                    <div class="notification_dd">
                        <ul class="notification_ul">
                            <?php
                            if(empty(session('mensajes'))){
                                ?>
                                <h4 class="text-center" style="margin-top: 1rem;">No tienes ningun notificación activa</h4>
                                <?php
                            }else{
                                foreach (session('mensajes') as $m) {
                                    ?>
                                        <li class="<?= $m['nivelAlerta'] ?> <?= $m['activo'] == 0 ? 'hide' : '' ?>" data-activo='<?= $m['activo'] == 0 ? 0 : 1 ?>'>
                                            <div class="notify_icon">
                                                <img src="<?= base_url('resources/img/isotipos/Mapa_' . ucfirst(session('red')) . '.png') ?>" alt="">
                                            </div>
                                            <div class="notify_data">
                                                <div class="title">
                                                    Equipo Redesla
                                                </div>
                                            </div>
                                            <div class="notify_status">
                                                <p>
                                                    <button type="button" class="verNoti btn btn-<?= $m['nivelAlerta'] ?> btn-sm" data-noti='<?= $m['mensaje'] ?>' data-id='<?= $m['id'] ?>'>Ver más</button>
                                                </p>
                                            </div>
                                        </li>
                                    <?php
                                }
                            }
                            ?>
                            <li class="show_all">
                                <button type="button" class="btn bg-<?= ucfirst(session('red')) ?>" id="showInactivas">Ver todas</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <i class='fas fa-sun' id="darkLight"></i>
            <div id="hideMobile">
                <a href="<?= base_url('perfil/inicio') ?>">
                    <img src="<?= base_url('resources/img/profiles/' . $_SESSION["profile_pic"]) ?>" alt="" class="profile" />
                </a>
                <span class="title"><?= $_SESSION['nombre'] ?> <?= session('lider_ca') == 1 ? '<i class="fa-solid fa-crown" title="Usted es el líder del cuerpo académico actual"></i>' : '<i class="fa-solid fa-user" title="Usted es miembro del cuerpo académico actual"></i>' ?> </span>
            </div>
        </div>
    </nav>
    <!-- sidebar -->
    <nav class="sidebar">
        <div class="menu_content">
            <ul class="menu_items">
                <div class="menu_title menu_dahsboard" data-text="Menú"></div>

                <li class="item">
                    <a href="<?= base_url('inicio/' . $_SESSION["red"] . '/' . $_SESSION["CA"]) ?>" class="nav_link" title="Inicio">
                        <span class="navlink_icon">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="navlink">Inicio</span>
                    </a>
                </li>

                <li class="item">
                    <a href="<?= base_url('perfil/inicio') ?>" class="nav_link" title="Perfil">
                        <span class="navlink_icon">
                            <i class="fa fa-user"></i>
                        </span>
                        <span class="navlink">Perfil</span>
                    </a>
                </li>

                <!-- start -->
                <li class="item">
                    <div href="#" class="nav_link submenu_item">
                        <span class="navlink_icon">
                            <i class="fa-solid fa-users-between-lines"></i>
                        </span>
                        <span class="navlink">Grupo</span>
                    </div>
                    <ul class="menu_items submenu">
                        <a href="<?= base_url("Datos_Generales") ?>" class="nav_link sublink">Datos generales</a>
                        <a href="<?= base_url("Miembros") ?>" class="nav_link sublink">Miembros</a>
                        <a href="<?= base_url("Carpetas") ?>" class="nav_link sublink">Carpetas</a>
                    </ul>
                </li>
                <!-- end -->

            </ul>
            <ul class="menu_items">
                <div class="menu_title menu_proyectos"></div>
                <!-- duplicate these li tag if you want to add or remove navlink only -->

                <?php
                if (empty($_SESSION['proyectos'])) {
                ?>
                    <li class="item">
                        <a href="<?= base_url("pagos/inicio") ?>" class="nav_link" title="Proyectos">
                            <span class="navlink_icon">
                                <i class="fas fa-folder-open"></i>
                            </span>
                            <span class="navlink">Proyectos</span>
                        </a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="item">
                        <div href="#" class="nav_link submenu_item">
                            <span class="navlink_icon">
                                <i class="fas fa-folder-open"></i>
                            </span>
                            <span class="navlink">Proyectos</span>
                            <i class="bx bx-chevron-right arrow-left"></i>
                        </div>
                        <ul class="menu_items submenu">
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

                                if (!in_array($proyecto["proyecto"], $arr_proyectos)) {
                                    if ($proyecto['anio'] >= 2024 && $proyecto['esquema'] != '') {
                            ?>
                                        <a href="<?= base_url('proyecto/investigacion/' . $proyecto['esquema'] . "/" . $proyecto['anio']) ?>" class="nav_link sublink"><?= $proyecto["proyecto"] ?></a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="<?= base_url('proyecto/' . $nombre_guiones . "/" . $anio) ?>" class="nav_link sublink"><?= $proyecto["proyecto"] ?></a>
                            <?php
                                    }
                                }

                                array_push($arr_proyectos, $proyecto["proyecto"]);
                            }
                            ?>
                            <!-- <a href="#" class="nav_link sublink">Carpetas</a> -->
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>

            <ul class="menu_items">
                <div class="menu_title menu_finanzas"></div>
                <li class="item">
                    <a href="<?= base_url("pagos/inicio") ?>" class="nav_link" title="Pagos">
                        <span class="navlink_icon">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </span>
                        <span class="navlink">Pagos</span>
                    </a>
                </li>
                <li class="item">
                    <a href="<?= base_url("facturas") ?>" class="nav_link" title="Facturas">
                        <span class="navlink_icon">
                            <i class="fa-solid fa-receipt"></i>
                        </span>
                        <span class="navlink">Facturas</span>
                    </a>
                </li>
            </ul>

            <ul class="menu_items">
                <div class="menu_title menu_extras" data-text='Más'></div>
                <li class="item">
                    <a href="<?= base_url("cuerpos") ?>" class="nav_link" title="Seleccionar red">
                        <span class="navlink_icon">
                            <i class="fas fa-globe-americas"></i>
                        </span>
                        <span class="navlink">Seleccionar red</span>
                    </a>
                </li>
                <li class="item">
                    <a href="https://redesla.la/" target="_blank" class="nav_link" title="Acerca de">
                        <span class="navlink_icon">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        <span class="navlink">Acerca de</span>
                    </a>
                </li>
                <li class="item">
                    <a href="<?= base_url("logout") ?>" class="nav_link" title="Cerrar sesión">
                        <span class="navlink_icon">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </span>
                        <span class="navlink">Cerrar sesión</span>
                    </a>
                </li>
            </ul>

            <!-- Sidebar Open / Close -->
            <div class="bottom_content">
                <div class="bottom expand_sidebar">
                    <i class="fa-solid fa-circle-chevron-down"></i>
                </div>
                <div class="bottom collapse_sidebar">
                    <i class="fa-solid fa-circle-chevron-down"></i>
                </div>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="modalNoti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="bodyNoti">
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_mensaje" id="id_mensaje">
                    <button type="button" class="btn btn-success leido">Marcar como leído</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    