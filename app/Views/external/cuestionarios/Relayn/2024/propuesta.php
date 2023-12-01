<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" href="<?= base_url('/resources/css/investigaciones/Relayn/2024/index.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/resources/css/investigaciones/Relayn/2024/geolocalizacion.css') ?>">
    <title>Encuestas Relayn 2024</title>
</head>

<body>
    <div class="container">
        <!-- <section>
            <div class="row text-center">
                <div class="col-md-6 text-center">
                    <img src="<?= base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" style="width:90%">
                </div>
                <div class="col-md-6 text-center">
                    <img src="<?= base_url("resources/img/logos_con_letras/Letras_" . $red['nombre_red'] . ".png"); ?>" style="width: 90%; height: 100%;">
                </div>
            </div>
            <h1 class="text-center">Investigación RELAYN 2024</h1>
            <h3 class="text-center">
                “Habilidades directivas y clima
                organizacional en las micro y pequeñas empresas latinoamericanas Vol.2”
            </h3>
            <hr>
            <h1 class="text-center">Encuesta para el grupo</h1>
            <h1 class="text-center"><?= $claveCuerpo ?></h1>
            <hr>
            <h1 class="text-center">Objetivo</h1>
            <p class="text-center">
                Determinar el grado de asociación entre habilidades directivas y clima organizacional de las micro y pequeñas empresas de Latinoamérica.
            </p>
            <h1 class="text-center">Instrucciones</h1>
            <p class="text-center">La encuesta debe ser respondida por <b><u>el personal directivo</u></b> de la empresa, que es la persona que toma la mayor parte de las decisiones.
                En la encuesta, la empresa es cualquier organización o negocio con fines de lucro donde exista por lo menos una persona que
                trabaje para el personal directivo. Si alguna pregunta no se puede contestar seleccione la opción <b>“No sé / No aplica”</b>.
                Es importante leer con especial atención las palabras que están en <b>negritas</b>.
            </p>
            <h1 class="text-center">Aviso de privacidad</h1>
            <h6 class="text-center">
                SUS RESPUESTAS SON ABSOLUTAMENTE CONFIDENCIALES, AL CONTESTAR EL CUESTIONARIO AUTORIZA QUE SUS RESPUESTAS SEAN USADAS DE <b>MANERA ANÓNIMA</b>,
                ÚNICA Y EXCLUSIVAMENTE CON FINES ACADÉMICOS Y ESTADÍSTICOS, ¿ESTÁ DE ACUERDO?
            </h6>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="checkAviso">
                <label class="form-check-label" for="checkAviso">
                    Sí, estoy de acuerdo.
                </label>
            </div>
        </section> -->

        <section id="preguntaContainer">
            <!-- Aquí se mostrará la pregunta actual -->
        </section>
        
        <div class="row">
            <div class="col md-6">
            <button id="regresarBtn" disabled class="btn btn-block btn-danger">Regresar</button>
            </div>
            <div class="col md-6">
                <button id="continuarBtn" class="btn btn-block btn-success">Continuar</button>
            </div>
        </div>


        <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQh6LMKdJHPK_jf4ZMZAdq4VbGluN8Vlo&callback=initMap&libraries=places&v=weekly" defer></script> -->

        <script>
            //VARIABLES GLOBALES
            let googleMapsUrl;
        </script>
        <script src="<?= base_url('/resources/js/investigaciones/Relayn/2024/preguntas.js') ?>"></script>
        <script src="<?= base_url('/resources/js/investigaciones/Relayn/2024/propuesta.js') ?>"></script>
        <!-- <script src="<?= base_url('/resources/js/investigaciones/Relayn/2024/geolocalizacion.js') ?>"></script> -->

</body>

</html>