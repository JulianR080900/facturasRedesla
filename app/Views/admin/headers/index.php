<!DOCTYPE html>
<html lang="es-MX">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin REDESLA</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= base_url('/resources/admin/') ?>/assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= base_url('/resources/admin/') ?>/assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="<?= base_url('/resources/admin/') ?>/assets/vendors/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="<?= base_url('/resources/admin/') ?>/assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?= base_url('/resources/admin/') ?>/assets/vendors/owl-carousel-2/owl.carousel.min.css">
  <link rel="stylesheet" href="<?= base_url('/resources/admin/') ?>/assets/vendors/owl-carousel-2/owl.theme.default.min.css">

  <!-- DATATABLES -->
  <link rel="stylesheet" href="<?= base_url('/resources/datatables/admin/bootstrap/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/resources/datatables/admin/Buttons-2.3.5/css/buttons.bootstrap4.min.css') ?>">
  <script src="https://kit.fontawesome.com/cd008eda05.js" crossorigin="anonymous"></script>

  <!--
  <link rel="stylesheet" href="<?php //base_url('/resources/datatables/datatables.min.css') 
                                ?>">
  <link rel="stylesheet" href="<?php //base_url('/resources/datatables/buttons.dataTables.min.css') 
                                ?>">
  <link rel="stylesheet" href="<?php //base_url('/resources/datatables/dataTables/css/jquery.dataTables.min.css') 
                                ?>">
-->

  <!-- End plugin css for this page -->
  <!--CKEDITOR-->
  <script src="<?= base_url('resources/ckeditor/build/ckeditor.js') ?>"></script>
  <!--JQUERY-->
  <script src="<?= base_url('resources/jquery/jquery.min.js') ?>"></script> <!-- V. 3.6.1 -->
  <!-- jQuery UI -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('/resources/admin/') ?>/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>
  <!--CHARTJS-->
  <script src="<?= base_url('/resources/admin/') ?>/assets/vendors/chart.js/Chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="<?= base_url('/resources/admin/') ?>/assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?= base_url('/resources/img/isotipos/Mapa_Redesla.png') ?>" />
</head>

<body>
  <style>
    .sidebar .nav .nav-item .nav-link {
      white-space: break-spaces !important;
      ;
    }

    .dataTables_wrapper .dataTables_filter input {
      color: #000 !important;
    }
  </style>
  <div id="loader">
    <span class="loader"></span>
  </div>

  <div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="<?= base_url('/admin/dashboard') ?>"><img src="<?= base_url('/resources/admin') ?>/assets/images/logo.svg" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="<?= base_url('/admin/dashboard') ?>"><img src="<?= base_url('/resources/admin') ?>/assets/images/logo-mini.svg" alt="logo" /></a>
      </div>
      <ul class="nav">
        <li class="nav-item profile">
          <div class="profile-desc">
            <div class="profile-pic">
              <div class="count-indicator">
                <img class="img-xs rounded-circle " src="<?= base_url('/resources/img/profiles/' . session('profile_pic')) ?>" alt="">
                <span class="count bg-success"></span>
              </div>
              <div class="profile-name">
                <h5 class="mb-0 font-weight-normal"><?= session('nombre') ?></h5>
                <span>Administrador</span>
              </div>
            </div>
            <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
            <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
              <a href="#" class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-dark rounded-circle">
                    <i class="mdi mdi-settings text-primary"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-dark rounded-circle">
                    <i class="mdi mdi-onepassword  text-info"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-dark rounded-circle">
                    <i class="mdi mdi-calendar-today text-success"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                </div>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item nav-category">
          <span class="nav-link">Menú</span>
        </li>
        <?php
        if (session('nombre') == 'Ing. Paula') {
        ?>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/dashboard') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Inicio</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/usuarios/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-outline"></i>
              </span>
              <span class="menu-title">Usuarios</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_cuerpos_academicos" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-home-modern"></i>
              </span>
              <span class="menu-title">Cuerpos académicos</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_cuerpos_academicos">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/cuerpos/lista') ?>">Listado</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/cuerpos/mensajes') ?>">Mensajes de validación</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/cuerpos/orden_autores/lista') ?>">Orden de autores</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_libros" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-book-open-page-variant"></i>
              </span>
              <span class="menu-title">Libros</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_libros">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/libros/lista') ?>">Listado</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/libros/carta') ?>">Carta de dictamen</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/libros/editoriales/lista') ?>">Casas editoriales</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_constancias" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-certificate"></i>
              </span>
              <span class="menu-title">Constancias</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_constancias">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/constancias/agregar') ?>">Agregar constancia</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_miembros" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              <span class="menu-title">Miembros</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_miembros">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/miembros/lista') ?>">Lista</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_proyectos" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-lightbulb"></i>
              </span>
              <span class="menu-title">Proyectos de la red</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_proyectos">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/proyectos/lista') ?>">Lista</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_finanzas" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-cash-multiple"></i>
              </span>
              <span class="menu-title">Finanzas</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_finanzas">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/finanzas/proyectos/lista') ?>">Lista de proyectos</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/finanzas/movimientos/lista') ?>">Movimientos</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/finanzas/facturas/lista') ?>">Facturas</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_congreso" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-clipboard-check"></i>
              </span>
              <span class="menu-title">Instrucciones</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_congreso">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/congresos/instrucciones') ?>">Instrucciones</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_cursos" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-book"></i>
              </span>
              <span class="menu-title">Cursos</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_cursos">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/cursos/metodologia/lista') ?>">Metodología 18a edición</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/carpetas/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-folder"></i>
              </span>
              <span class="menu-title">Carpetas</span>
            </a>
          </li>

          <li class="nav-item nav-category">
            <span class="nav-link">Investigaciones</span>
          </li>

          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_equipos_investigaciones" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-book"></i>
              </span>
              <span class="menu-title">Datos y revisiones</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_equipos_investigaciones">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/Relayn/2024/inicio') ?>">Relayn 2024</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/equipos/Relayn/2023') ?>">Relayn 2023</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/equipos/Relep/2023') ?>">Relep 2023</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/equipos/Relen/2023') ?>">Relen 2023</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('admin/investigaciones/cartas/inicio') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-certificate"></i>
              </span>
              <span class="menu-title">Cartas</span>
            </a>
          </li>

          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('admin/investigaciones/marcajes/inicio') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-certificate"></i>
              </span>
              <span class="menu-title">Marcajes</span>
            </a>
          </li>

          <li class="nav-item nav-category">
            <span class="nav-link">Congresos</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted"></i>
              </span>
              <span class="menu-title">Lista de congresos</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/cartas/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-certificate"></i>
              </span>
              <span class="menu-title">Cartas de aceptación</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/asistencia/inicio') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-check"></i>
              </span>
              <span class="menu-title">Asistencia</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/ponencias/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-school"></i>
              </span>
              <span class="menu-title">Ponencias registradas</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/participantes/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted"></i>
              </span>
              <span class="menu-title">Lista de participantes</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/moderadores/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              <span class="menu-title">Moderadores</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/enlaces/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              <span class="menu-title">Enlaces</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/mesas/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-tablet"></i>
              </span>
              <span class="menu-title">Mesas</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/horarios/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-calendar-clock"></i>
              </span>
              <span class="menu-title">Horarios de ponencias</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_ganadores" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-crown"></i>
              </span>
              <span class="menu-title">Ganadores</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_ganadores">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/congresos/ganadores/lista/Relayn/2022') ?>">Relayn 2022</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/congresos/ganadores/lista/Relep/2022') ?>">Relep 2022</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/congresos/ganadores/lista/Relen/2022') ?>">Relen 2022</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/congresos/ganadores/lista/Releg/2023') ?>">Releg 2023</a></li>
              </ul>
            </div>
          </li>

        <?php
        } else if (session('nombre') == 'Dra. Nuria') {
        ?>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/entrevistas/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-outline"></i>
              </span>
              <span class="menu-title">Equipos RELEG</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/categorias/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted"></i>
              </span>
              <span class="menu-title">Lista de categorías</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/categorias/digitales/dimensiones/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted"></i>
              </span>
              <span class="menu-title">Lista de dimensiones</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/capitulos/impresos/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted"></i>
              </span>
              <span class="menu-title">Lista de capítulos impresos</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/capitulos/digitales/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted"></i>
              </span>
              <span class="menu-title">Lista de capítulos digitales</span>
            </a>
          </li>
        <?php
        } else if (session('nombre') == 'Lic. Sergio') {
        ?>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/imagenes/marcos') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-outline"></i>
              </span>
              <span class="menu-title">Marcos para Facebook</span>
            </a>
          </li>
        <?php
        } else if (session('nombre') == 'Ing. Sylvia') {
        ?>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_cuerpos_academicos" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-home-modern"></i>
              </span>
              <span class="menu-title">Cuerpos académicos</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_cuerpos_academicos">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/cuerpos/orden_autores/lista') ?>">Orden de autores</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_equipos_investigaciones" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-book"></i>
              </span>
              <span class="menu-title">Investigaciones</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_equipos_investigaciones">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/equipos/Relayn/2023') ?>">Relayn 2023</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/equipos/Relep/2023') ?>">Relep 2023</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/equipos/Relen/2023') ?>">Relen 2023</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/carpetas/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-folder"></i>
              </span>
              <span class="menu-title">Carpetas</span>
            </a>
          </li>
        <?php
        } else if (session('nombre') == 'Promoción') {
        ?>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_cuerpos_academicos" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-home-modern"></i>
              </span>
              <span class="menu-title">Cuerpos académicos</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_cuerpos_academicos">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/cuerpos/lista') ?>">Listado</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/cuerpos/mensajes') ?>">Mensajes de validación</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/cuerpos/orden_autores/lista') ?>">Orden de autores</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_miembros" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              <span class="menu-title">Miembros</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_miembros">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/miembros/lista') ?>">Lista</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/usuarios/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-outline"></i>
              </span>
              <span class="menu-title">Usuarios</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_libros" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-book-open-page-variant"></i>
              </span>
              <span class="menu-title">Libros</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_libros">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/libros/lista') ?>">Listado</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/libros/carta') ?>">Carta de dictamen</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_congreso" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              <span class="menu-title">Instrucciones</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_congreso">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/congresos/instrucciones') ?>">Instrucciones</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_equipos_investigaciones" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-book"></i>
              </span>
              <span class="menu-title">Investigaciones</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_equipos_investigaciones">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/equipos/Relayn/2023') ?>">Relayn 2023</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/equipos/Relep/2023') ?>">Relep 2023</a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/investigaciones/equipos/Relen/2023') ?>">Relen 2023</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Congresos</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/ponencias/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-school"></i>
              </span>
              <span class="menu-title">Ponencias registradas</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/participantes/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted"></i>
              </span>
              <span class="menu-title">Lista de participantes</span>
            </a>
          </li>
        <?php
        } else if (session('nombre') == 'Nadia') {
        ?>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_constancias" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-certificate"></i>
              </span>
              <span class="menu-title">Constancias</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_constancias">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/constancias/agregar') ?>">Agregar constancia</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_libros" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-book-open-page-variant"></i>
              </span>
              <span class="menu-title">Libros</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_libros">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/libros/lista') ?>">Listado</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#menu_dictamen" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-certificate"></i>
              </span>
              <span class="menu-title">Cartas</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="menu_dictamen">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?= base_url('/admin/dictamen/libro_congreso/lista') ?>">Lista de libros derivados de congreso</a></li>
              </ul>
            </div>
          </li>
        <?php
        } else if (session('nombre') == 'Lic. Aracely') {
        ?>
          <li class="nav-item nav-category">
            <span class="nav-link">Congresos</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted"></i>
              </span>
              <span class="menu-title">Lista de congresos</span>
            </a>
          </li>
        <?php
        } else if (session('user_type') == 2) {
          #moderadores
        ?>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/horarios/moderadores/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-calendar-clock"></i>
              </span>
              <span class="menu-title">Horarios de ponencias</span>
            </a>
          </li>
        <?php
        } else if (session('user_type') == 4) {
          #moderadores
        ?>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/horarios/enlaces/instrucciones') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-calendar-clock"></i>
              </span>
              <span class="menu-title">Instrucciones virtuales</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="<?= base_url('/admin/congresos/horarios/enlaces/lista') ?>">
              <span class="menu-icon">
                <i class="mdi mdi-calendar-clock"></i>
              </span>
              <span class="menu-title">Horarios de ponencias</span>
            </a>
          </li>
        <?php
        }
        ?>
      </ul>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="<?= base_url('resources/admin') ?>/assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav w-100">
            <li class="nav-item w-100">
              <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                <input type="text" class="form-control" placeholder="Search products">
              </form>
            </li>
          </ul>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown d-none d-lg-block">
              <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-toggle="dropdown" aria-expanded="false" href="#">+ Create New Project</a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                <h6 class="p-3 mb-0">Projects</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-file-outline text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Software Development</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-web text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">UI Development</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-layers text-danger"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Software Testing</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <p class="p-3 mb-0 text-center">See all projects</p>
              </div>
            </li>
            <li class="nav-item nav-settings d-none d-lg-block">
              <a class="nav-link" href="#">
                <i class="mdi mdi-view-grid"></i>
              </a>
            </li>
            <li class="nav-item dropdown border-left">
              <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-email"></i>
                <span class="count bg-success"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                <h6 class="p-3 mb-0">Messages</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="<?= base_url('/resources/admin/') ?>/assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                    <p class="text-muted mb-0"> 1 Minutes ago </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="<?= base_url('/resources/admin/') ?>/assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                    <p class="text-muted mb-0"> 15 Minutes ago </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="<?= base_url('/resources/admin/') ?>/assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                    <p class="text-muted mb-0"> 18 Minutes ago </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <p class="p-3 mb-0 text-center">4 new messages</p>
              </div>
            </li>
            <li class="nav-item dropdown border-left">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-bell"></i>
                <span class="count bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <h6 class="p-3 mb-0">Notifications</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Event today</p>
                    <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-danger"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Settings</p>
                    <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-link-variant text-warning"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Launch Admin</p>
                    <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <p class="p-3 mb-0 text-center">See all notifications</p>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                <div class="navbar-profile">
                  <img class="img-xs rounded-circle" src="<?= base_url('/resources/img/profiles/' . session('profile_pic')) ?>" alt="">
                  <p class="mb-0 d-none d-sm-block navbar-profile-name"><?= session('nombre') ?></p>
                  <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                <h6 class="p-3 mb-0">Perfil</h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item" href="<?= base_url('/logout') ?>">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-logout text-danger"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject mb-1">Salir</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <p class="p-3 mb-0 text-center">Advanced settings</p>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="main-panel">