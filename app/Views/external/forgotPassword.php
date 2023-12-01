<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resources/css/password/index.css") ?>">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">

    <title>Recuperar contraseña</title>

</head>

<body>

<div class="container">


    <section>

        <div class="row col-auto text-center" id="row_imagenes">

            <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" width="50%" alt="" >

            <hr>

            <h1>Recuperar contraseña</h1>

        </div>

    </section>

    <section>

        <div class="row justify-content-center justify-content-md-start">

            <div class="col align-self-center">

                <form action="<?php echo base_url("resetLink"); ?>" method="post">

                    <div class="col-md-12">

                        <label>Ingrese su correo electrónico</label>

                        <input class="form-control" type="email" name="email" id="email" placeholder="Correo electrónico">

                    </div>

                    <div class="col-md-12">

                        <button type="submit" class="btn btn-block btnPrimary">Enviar código <i class="fas fa-paper-plane"></i></button>

                    </div>

                </form>

                <div class="col-md-12">

                    <button type="buttton" onclick="location.href='<?php echo base_url()?>';" class="btn btn-block btn-danger"><i class="fas fa-home"></i> Regresar al inicio</button>

                </div><br>

            </div>

        </div>

    </section>

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