<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('resources/bootstrap/css/bootstrap.min.css') ?>">
    <script src="<?= base_url('resources/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('resources/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('resources/css/Releg/capitulo.css') ?>">
    <title>Redacción del capítulo de libro impreso</title>
</head>

<body>
    <div class="container">
        <form method='post' class='needs-validation' novalidate> <!--addCapitulo -->
            <section>
                <h1 class='text-center'>Capitulo digital RELEG</h1>
                <hr>
                <p>INSTRUCCIONES</p>
                <p>Estimadas investigadoras, favor de leer atentamente las indicaciones para realizar el capitulo digital RELEG.</p>
            </section>
            <section id='categorias'>
                <div id="tabla-container" hidden></div>

                <h3>Discusión</h3>
                <p class="text-sm">Instrucciones: ...</p>
                <hr>
                <!-- minlength='350' maxlength='400' -->
                <textarea name="discusion" id="discusion" cols="30" rows="10" class="form-control" minlength='350' maxlength='400' required></textarea>

                <hr>
                <div class="row">
                    <button type="submit" id="btnSubmit" class="btn btn-block btn-success">Guardar</button>
                </div>
            </section>

        </form>
        <section>
            <h3 class="text-center">¿Tienes un problema?</h3>
            <p class="text-center">Envianos un correo describiéndonos tu problema a la siguiente dirección:</p>
            <p class="text-center">jaramosp@red.redesla.la</p>
        </section>
    </div>

</body>

</html>












<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>




<script>
    let base_url = '<?= base_url() ?>';
    //action='../getDigitalReleg'

    $("form").on('submit', function(e) {
        e.preventDefault()

        let discusion = $("#discusion").val().trim()

        if (discusion.length < 350 || discusion.length > 400) {
            Swal.fire({
                title: 'La discusión debe ser de mínimo 350 caracteres y máximo 400'
            })
            return
        }

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../getDigitalReleg',
            data: {
                discusion
            },
            beforeSend: function() {
                $("#btnSubmit").prop('disabled', true)
            },
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: data.title,
                    text: data.text
                }).then(function() {
                    window.location.href = base_url
                })
            },
            error: function(jqXHR) {
                $("#btnSubmit").prop('disabled', false)
                console.log(jqXHR);
            }
        })
    })
</script>