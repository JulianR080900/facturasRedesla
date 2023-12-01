<!DOCTYPE html>

<html lang="es-MX">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resources/css/encuestador/index.css") ?>">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">

    <title>Constancias de encuestador</title>

</head>

<body>

    <div class="container">
        <section>
            <div class="row col-auto text-center" id="row_imagenes">
                <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" width="50%" alt="Contancias de encuestador REDESLA">
                <hr>
                <h1>Constancias de encuestador</h1>
            </div>
        </section>
        <section>
            <div class="row justify-content-center justify-content-md-start">

                <div class="col align-self-center">

                    <form action="./encuestadores/verificar" method="post">

                        <div class="col-md-12">

                            <label for="correo">Ingrese el correo electronico con el que realizo la encuesta</label>

                            <input class="form-control" type="email" name="correo" id="correo" placeholder="Ingrese el correo electronico que proporciono en el proceso de las encuestas" required>

                        </div>

                        <div class="col-md-12">

                            <button type="submit" class="btn btn-block btnPrimary">Verificar <i class="fa-solid fa-caret-right"></i></button>

                        </div>

                    </form>

                    <div class="col-md-12">

                        <button type="buttton" onclick="location.href='<?php echo base_url() ?>';" class="btn btn-block btn-danger"><i class="fas fa-home"></i> Regresar al inicio</button>

                    </div>

                </div>

            </div>
        </section>
    </div>

</body>

</html>