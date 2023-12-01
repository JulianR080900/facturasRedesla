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
        <form method='post' action='../getDocReleg' target="_blank" class='needs-validation' novalidate> <!--addCapitulo -->
            <section>
                <h1 class='text-center'>Proceso para edición de su discusión</h1>
                <hr>
                <p>INSTRUCCIONES</p>
                <p>Estimadas investigadoras, favor de leer atentamente las indicaciones para editar su discusión.</p>
            </section>

            <section id='categorias'>
                <h2>Discusión</h2>
                <hr>
                <h4 class="">Observaciones</h4>
                <p class="text-danger"><?= $discusion['retroalimentacion'] ?></p>
                <!-- minlength='350' maxlength='400' -->
                <textarea name="discusion" id="discusion" cols="30" rows="10" class="form-control" minlength='350' maxlength='400' required><?= $discusion['discusion'] ?></textarea>
                <hr>
                <div class="row">
                    <button type="button" class="btn btn-block btn-success" id="update">Enviar a revisión</button>
                </div>
            </section>

        </form>
        <section>
            <h3 class="text-center">¿Tienes un problema?</h3>
            <p class="text-center">Envianos un correo describiéndonos tu problema a la siguiente dirección:</p>
            <p class="text-center">jaramosp@red.redesla.la</p>
        </section>
    </div>

    <script>
        let base_url = '<?= base_url() ?>';
        $("#update").on('click',function(){

            let discusion = $("#discusion").val().trim()

            if(discusion.length < 350 || discusion.length > 400){
                Swal.fire({
                    title: 'La discusión debe ser de mínimo 350 caracteres y máximo 400'
                })
                return
            }
            
            Swal.fire({
                icon: 'question',
                title: '¿Esta seguro que desea enviar a revisión su discusión para el capitulo digital RELEG 2022?',
                text: 'Esta acción no es reversible',
                showCancelButton: true,
                cancelButtonText: 'No',
                confirmButtonText: 'Sí, enviar a revisión'
            }).then((result) => {
                if(result.isConfirmed){
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: '../../update',
                        data: {
                            discusion
                        },
                        beforeSend: function(){
                            $("#update").prop('disabled',true)
                        },
                        success: function(data){
                            Swal.fire({
                                icon: 'success',
                                title: data.title,
                                text: data.text
                            }).then(function(){
                                window.location.href = base_url
                            })
                        },
                        error: function(jqXHR){
                            $("#update").prop('disabled',false)
                            Swal.fire({
                                icon: 'error',
                                title: 'Error '+jqXHR.status,
                                text: jqXHR.responseText
                            })
                        }
                    })
                }
            })
        })
    </script>


</body>
</html>