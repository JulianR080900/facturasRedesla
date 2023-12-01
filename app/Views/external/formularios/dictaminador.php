<!DOCTYPE html>

<html lang="es-MX">

<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('resources/css/dictaminador/index.css') ?>">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">

    <title>Constancias Dictaminador REDESLA</title>

</head>

<body>

    <div class="container">

        <section>
            <div class="row col-auto text-center" id="row_imagenes">

                <?php
                foreach ($redes as $r) {
                ?>
                    <img src="<?= base_url("resources/img/isotipos/Mapa_" . $r['nombre_red'] . ".png"); ?>" style="width:10%" alt="Constancias Dictaminador <?= $r['nombre_red'] ?>" />
                <?php
                }
                ?>

                <hr>

                <h1>Constancias dictaminador</h1>

            </div>
        </section>

        <section>
            <div class="row col-auto">

                <div class="col-md-12">
                    <label for="mail">Correo electrónico</label>
                    <div class="input-group" style="padding-bottom: 2rem;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="mail">Correo</span>
                        </div>
                        <input type="email" class="form-control" id="correo" placeholder="Ingrese su correo electrónico" aria-describedby="mail" required>
                    </div>

                </div>

                <div class="col-md-12" id="divconsultar">

                    <button type="button" class="btn btn-block btnPrimary" id="consultar">Consultar <i class="fa-solid fa-caret-right"></i></button><br>

                </div>

            </div>

            <div class="row col-auto text-center" id="datos"></div>
        </section>
        
    </div>

    <script>
        var base_url = '<?php echo base_url(); ?>';
    </script>
    <script src="<?= base_url('resources/js/dictaminador/index.js') ?>"></script>
</body>

</html>