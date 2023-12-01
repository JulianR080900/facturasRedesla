
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resources/css/constancias/index.css") ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">
    <title>Verificación de constancias REDESLA</title>
</head>
<body>
    <div class="container">
    <section>
        <div class="row col-auto text-center" id="row_imagenes">
            <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" width="50%" alt="Constancias Redesla" >
            <hr>
            <h1>Verificación de constancia</h1>
        </div>
    </section>
    <section>
            <div class="row justify-content-center justify-content-md-start">
            <div class="col align-self-center">
                <form action="./constancias/verificar" method="post">
                    <div class="col-md-12">
                        <label>Escriba el folio que viene adjuntado en la constancia que desea verificar</label>
                        <input class="form-control" type="text" name="folio" id="folio" placeholder="Escriba su folio" required>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-block" id="btnVerificar">Verificar folio <i class="fa-solid fa-caret-right"></i></button>
                    </div>
                </form>
                <div class="col-md-12">
                    <button type="buttton" onclick="location.href='<?= base_url()?>';" class="btn btn-block btn-danger"><i class="fas fa-home"></i> Regresar al inicio</button>
                </div><br>
            </div>
        </div>
    </section>
    </div>

</body>
</html>