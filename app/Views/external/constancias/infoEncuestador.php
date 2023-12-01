<!DOCTYPE html>

<html lang="es-MX">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resources/css/encuestador/index.css") ?>">
    <script src="https://kit.fontawesome.com/cd008eda05.js" crossorigin="anonymous"></script>
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
                <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" width="50%" alt="">
                <hr>
                <h1>Listado de constancias de encuestador</h1>
            </div>
        </section>
        <section>
            <div class="row justify-content-center justify-content-md-start">

                <div class="col align-self-center text-center">
                    
                    <h2>Constancias disponibles</h2>
                    <?php
                        foreach($info as $f){
                            ?>
                            <div class="col-md-12 text-center">
                                <form action="./descargar" method="post">
                                    <input type="text" name="red" hidden value="<?= $f['red'] ?>">
                                    <input type="text" name="anio" hidden value="<?= $f['anio'] ?>">
                                    <input type="text" name="correo" hidden value="<?= $f['correo'] ?>">
                                    <button type="submit" class=" btn btn-block <?= $f['red'] ?>"><?= $f['red'] . ' ' . $f['anio'] ?> <i class="fa-solid fa-download"></i></button>
                                </form>
                            </div>
                            <hr>
                            <?php
                        }
                    ?>

                    <div class="col-md-12"></div>

                    <div class="col-md-12">

                        <button type="buttton" onclick="location.href='<?php echo base_url('/encuestadores') ?>';" class="btn btn-block regresar"><i class="fa-solid fa-caret-left"></i> Regresar</button>

                        <button type="buttton" onclick="location.href='<?php echo base_url() ?>';" class="btn btn-block btn-danger"><i class="fas fa-home"></i> Regresar al inicio</button>

                    </div>

                </div>

            </div>
        </section>
    </div>

</body>

</html>