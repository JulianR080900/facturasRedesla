<!DOCTYPE html>

<html lang="es-MX">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resources/css/password/index.css") ?>">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">

    <title>Cambiar contraseña</title>

</head>

<body>


    <section class="text-center">
        <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" width="50%" alt="Redesla - Red de Estudios Latinoamericanos">
        <hr>
        <h2>CAMBIAR CONTRASEÑA</h2>
    </section>

    <section class="text-left">
        <form action="<?php echo base_url("updatePass/"); ?>" method="post">

            <div class="col-md-12">

            <label for="contra">Escriba su nueva contraseña</label>

                <input class="form-control" type="password" name="contra" id="contra" placeholder="Contraseña">

            </div>

            <div class="col-md-12">

                <label for="conf">Confirme su nueva contraseña</label>

                <input class="form-control" type="password" name="conf" id="conf" placeholder="Confirmar contraseña">

            </div>

            <input type="text" value="<?= $token ?>" name="token" hidden>

            <div class="col-md-12">

                <label for="" id="message"></label>

                <button type="submit" class="btn btn-block btn-success">Cambiar contraseña <i class="fa-solid fa-key"></i></button>

                <a  href='<?= base_url() ?>' class="btn btn-block btn-danger"><i class="fa-solid fa-house"></i> Regresar al inicio</a>

            </div>

        </form>
    </section>

    <script src="<?php echo base_url("resources/js/olvidePass.js") ?>"></script>

</body>

</html>