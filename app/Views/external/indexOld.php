<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url("resources/css/login/index.css"); ?>" rel="stylesheet" type="text/css" >
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">
    <title>Bienvenidos a REDESLA</title>
</head>
<body>
<div class="row">

<div class="mapas">

        <img src="<?php echo base_url("resources/img/logos_con_letras/tira_redes.png") ?>">

    </div>

</div><br>

<div class="container">

<div class="img">

    <img src="<?php echo base_url("resources/img/svg/teamColaboration.svg") ?>">

</div>

<div class="login-content">

    <form method="POST" action="<?php echo base_url('/login'); ?>">

        <img src="<?php echo base_url("resources/img/svg/undraw_male_avatar_323b.svg") ?>">

        <h2 class="title">REDESLA</h2>

        <h3 class="title">¡Bienvenido!</h3><br>

           <div class="input-div one">

              <div class="i">

                      <i class="fas fa-user"></i>

              </div>

              <div class="div">

                      <h5>Correo electrónico</h5>

                      <input type="text" class="input" name="correo" value="<?php echo get_cookie('correo');  ?>" placeholder="<?php get_cookie("correo") ?>">

              </div>

           </div>

           <div class="input-div pass">

              <div class="i"> 

                   <i class="fas fa-lock"></i>

              </div>

              <div class="div">

                   <h5>Contraseña</h5>

                   <input type="password" class="input" value="<?php echo get_cookie('pass');  ?>" name="password">

           </div>

        </div>

        <a href="<?= base_url("forgotPassword")?>">¿Olvidó su contraseña?</a>

        <a href="<?= base_url("registro")?>">¿No pertenece a una red? ¡Regístrese ahora!</a>

        <a href="<?= base_url("constancias") ?>">¿Desea validar una constancia? Haga clic aquí</a>

        <div class="div" style="float:right; margin-bottom: 6px">

            <input type="checkbox" name="remember" id="remember"><label for="remember">  Recordar contraseña</label>

        </div>

        <input type="submit" name="submit" class="btn" value="Iniciar sesión">

    </form>

</div>



</div>

<div class="row">

<div class="mapas">
        <img src="<?php echo base_url("resources/img/footers/informes.png") ?>" style="margin-top:-20px;">
    </div>

</div>

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

</body>
</html>