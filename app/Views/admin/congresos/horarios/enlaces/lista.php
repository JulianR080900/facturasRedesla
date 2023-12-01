
<style>
    .svgImg{
        width: 100%;
    }
    .table th, .jsgrid .jsgrid-table th, .table td, .jsgrid .jsgrid-table td{
        white-space: break-spaces !important;
        line-height: 1.4rem !important;
    }
    .colImg{
        display: flex;
        align-items: center;
        align-content: center;
    }
    hr{
        background-color: #fff;
    }
    a{
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de horarios para congresos de <?= session('nombre') ?></h4>
                <hr>

                <?php
                foreach($congresos as $c){
                    ?>
                    <div class='row'>
                        <div class='col-md-4 colImg'>
                            <img src='<?= base_url('/resources/img/congresos/horarios_moderadores.svg') ?>' class='svgImg'>
                        </div>
                        <div class='col-md-8'>
                        <div class='form-group'>
                                <h2>Evento</h2>
                                <p><?= $c['congreso'] ?></p>
                            </div>
                            <div class='form-group'>
                                <h2>Horario</h2>
                                <p><?= $c['horario'] ?></p>
                            </div>
                            <div class='form-group'>
                                <h2>Salón</h2>
                                <p><?= $c['salon'] ?></p>
                            </div>
                            <div class='form-group'>
                                <h2>Enlace de Zoom</h2>
                                <p><a href='<?= $c['zoom'] ?>' target='_blank'>Clic para ir a Zoom</a></p>
                            </div>
                            <div class='form-group'>
                                <h2>Moderador</h2>
                                <?php
                                $texto_codificado = urlencode('Buen día, soy '.session('nombre').' el enlace del equipo REDESLA del congreso '.strtoupper($c['red']).', el motivo de mi mensaje es porque aún no lo veo en sala, el acceso es '.$c['zoom'] );
                                $texto_codificado = str_replace('+', '%20', $texto_codificado);
                                ?>
                                <p><?= $c['moderador'] ?> - <a href='https://api.whatsapp.com/send?phone=<?= $c['contacto_mod'] ?>&text=<?= $texto_codificado ?>' target='_blank' class='text-success'><?= $c['contacto_mod'] ?> <i class='mdi mdi-whatsapp'></i></a></p>
                            </div>
                            <div class='form-group'>
                                <h2>Mesa</h2>
                                <p><?= $c['mesa'] ?></p>
                            </div>
                        </div>
                    </div>

                    <?php
                    if(!isset($c['ponencias'])){
                        ?>
                        <h2>Sin ponencias registradas</h2>
                        <?php
                    }else{
                        ?>
                        <div class='row'>
                            <h2>Ponencias</h2>
                            <div class='col-md-12'>
                            <table class="table table-responsive text-center">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Nombre</td>
                                        <td>Ponente</td>
                                        <td>Constancia</td>
                                        <td>Accesos</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($c['ponencias'] as $p){
                                        ?>
                                        <tr>
                                            <td><?= $p['submission_id'] ?></td>
                                            <td><?= $p['ponencia'] ?></td>
                                            <td><?= $p['ponente'] ?></td>
                                            <td>
                                                <button 
                                                    class='btn btn-success btn-rounded const' 
                                                    data-pub='<?= $p['publication_id'] ?>'  
                                                    data-sub='<?= $p['submission_id'] ?>' 
                                                    <?= $p['constancias'] == 1 ? 'disabled':'' ?>
                                                ><?= $p['constancias'] == 1 ? 'Constancias otorgadas':'Otorgar constancia' ?></button>
                                            </td>
                                            <td>
                                            <button class='btn btn-primary btn-rounded copy' data-clave='<?= $p['clave_ponencia'] ?>'>Copiar accesos para zoom</button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    
                    <hr>
                    <?php
                }
                ?>
                
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $(window).scrollLeft(x);
        $(window).scrollTop(y);
    })

    $(document).on('click','.const', function(){

        let publication_id = $(this).data('pub')
        let submission_id = $(this).data('sub')
        
        Swal.fire({
            icon: 'question',
            title: '¿Seguro que desea aprobar las constancias de ponentes a esta ponencia?',
            text: `Esto significa que la ponencia con ID ${submission_id} ha expuesto su ponencia en el congreso.`,
            showCancelButton: true, //Solo mostrando el de cancelar, se muestra el otro
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Aprobar constancias'
            }).then((result) => {
            if(result.isConfirmed){
                var screen = $("#loader")
                loaderScreen(screen)
                let publication_id = $(this).data('pub')
                let submission_id = $(this).data('sub')
                $.ajax({
                type: 'post',
                url: './constancias_ponentes',
                dataType: 'json',
                data: {
                    publication_id:publication_id,
                    submission_id: submission_id,
                },
                success: function(res){
                    console.log(res)
                    Swal.fire({
                        icon: "success",
                        title: res.title,
                        text: res.mensaje,
                    }).then(function(){
                        var x = $(window).scrollLeft();
                        var y = $(window).scrollTop();
                        location.reload()
                    })
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Manejar el error
                    console.log(jqXHR);
                    Swal.fire({
                    icon: "error",
                    title: 'Error '+jqXHR.status,
                    text: jqXHR.responseText,
                    })
                }
                })
            }
        })
    })

    $(document).on('click','.copy', function(){
        let clave = $(this).data('clave')
        let textToCopy = `La clave para esta ponencia es: ${clave} y la puede calificar desde: https://vive.redesla.la/congresos/calificar/inicio?clave=${clave}`
        navigator.clipboard.writeText(textToCopy);
        Swal.fire({
            icon: 'success',
            title: 'Texto copiado en el portapapeles',
            timer: 1000
        })
    })

</script>