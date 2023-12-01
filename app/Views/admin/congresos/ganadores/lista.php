<style>
    /* .card-body *{
        border: 1px solid red;
    } */

    .first_icon{
        font-size: 6rem;
        background-image: linear-gradient(
            to right,
            #462523 0,
                #cb9b51 22%, 
            #f6e27a 45%,
            #f6f2c0 50%,
            #f6e27a 55%,
            #cb9b51 78%,
            #462523 100%
            );
        color:transparent;
        -webkit-background-clip:text;
    }

    .second_icon{
        font-size: 4rem;
        background-image: linear-gradient(
        to right,
        #462523 0,
        #96938f 22%, 
        #c0c0c0 45%,
        #c0c0c0 50%, 
        #c0c0c0 55%, 
        #96938f 78%,
        #462523 100%
        );
        color: transparent;
        -webkit-background-clip: text;
    }

    .third_icon{
        font-size: 4rem;
        background-image: linear-gradient(
        to right,
        #462523 0,
        #bd6324 22%, 
        #cc7436 45%,
        #cc7436 50%, 
        #cc7436 55%, 
        #bd6324 78%,
        #462523 100%
        );
        color: transparent;
        -webkit-background-clip: text;
    }

    .alignment{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .alignment button{
        margin-bottom: 5px;
    }

    .txt_lugar{
        font-size: 1.5rem;
        font-weight: bold;
    }

    .imgUsuarios{
        width: 40px;
        height: 40px;
        border-radius: 100%;
        margin: 5px;
    }

    .divGanadores{
        margin-bottom: 10px;
    }
</style>
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">Lista de ganadores</div>
            <div class="card-body">
                <span>Instrucciones: A los ganadores se les asigna un reconocimiento que podran ver en la plataforma de miembros REDESLA en el módulo de Perfil. En caso de editar el ganador, se le removeran los renoconimientos a los anteriores ganadores asignados para darselos a lus nuevos.</span>
                <div class="row alignment">
                    <i class="mdi mdi-trophy-award first_icon"></i>
                    <span class="txt_lugar">Primer lugar</span>

                    <span class="text-sm font-weight-light n_<?= $red ?>">Ponencia</span>
                    <span class="font-italic text-center">
                        <?= empty($lugares['primero']['ponencia']) ? 'Sin asignar': $lugares['primero']['ponencia'] ?>
                    </span>

                    <span class="text-sm font-weight-light n_<?= $red ?>">Universidad del grupo de investigación</span>
                    <span class="font-italic text-center">
                        <?= empty($lugares['primero']['uni']) ? 'Sin asignar': $lugares['primero']['uni'] ?>
                    </span>

                    <span class="text-sm font-weight-light n_<?= $red ?>">Clave del grupo de investigación</span>
                    <span class="font-italic text-center">
                        <?= empty($lugares['primero']['claveCuerpo']) ? 'Sin asignar': $lugares['primero']['claveCuerpo'] ?>
                    </span>

                    
                    <?php
                    if(!empty($lugares['primero']['miembros'])){
                        echo '<span class="text-sm font-weight-light n_'.$red.'">Ganadores</span>';
                        echo '<div class="row divGanadores">';
                        foreach($lugares['primero']['miembros'] as $l){
                            ?>
                            <img class='imgUsuarios' src="<?= base_url('resources/img/profiles').'/'.$l['profile_pic'] ?>" alt="<?= $l['nombre'] ?>" title="<?= $l['nombre'] ?>">
                            <?php
                        }
                        echo '</div>';
                    }
                    ?>
                    

                    <button class="btn btn-warning btnEditar" data-lugar='1'>Editar ganador <i class="mdi mdi-pencil"></i> </button>
                </div>


                <div class="row">
                    <div class="col-md-6 alignment">
                        <i class="mdi mdi-trophy second_icon"></i>
                        <span class="txt_lugar">Segundo lugar</span>
                        
                        <span class="text-sm font-weight-light n_<?= $red ?>">Ponencia</span>
                        <span class="font-italic text-center">
                            <?= empty($lugares['segundo']['ponencia']) ? 'Sin asignar': $lugares['segundo']['ponencia'] ?>
                        </span>

                        <span class="text-sm font-weight-light n_<?= $red ?>">Universidad del grupo de investigación</span>
                        <span class="font-italic text-center">
                            <?= empty($lugares['segundo']['uni']) ? 'Sin asignar': $lugares['segundo']['uni'] ?>
                        </span>

                        <span class="text-sm font-weight-light n_<?= $red ?>">Clave del grupo de investigación</span>
                        <span class="font-italic text-center">
                            <?= empty($lugares['segundo']['claveCuerpo']) ? 'Sin asignar': $lugares['segundo']['claveCuerpo'] ?>
                        </span>
                        
                        <?php
                        if(!empty($lugares['segundo']['miembros'])){
                            echo '<h4>Ganadores</h4>';
                            echo '<div class="row divGanadores">';
                            foreach($lugares['segundo']['miembros'] as $l){
                                ?>
                                <img class='imgUsuarios' src="<?= base_url('resources/img/profiles').'/'.$l['profile_pic'] ?>" alt="<?= $l['nombre'] ?>" title="<?= $l['nombre'] ?>">
                                <?php
                            }
                            echo '</div>';
                        }
                        ?>
                        <button class="btn btn-warning btnEditar" data-lugar='2'>Editar ganador <i class="mdi mdi-pencil"></i> </button>
                    </div>


                    <div class="col-md-6 alignment">
                        <i class="mdi mdi-trophy third_icon"></i>
                        <span class="txt_lugar">Tercer lugar</span>
                        
                        <span class="text-sm font-weight-light n_<?= $red ?>">Ponencia</span>
                        <span class="font-italic text-center">
                            <?= empty($lugares['tercero']['ponencia']) ? 'Sin asignar': $lugares['tercero']['ponencia'] ?>
                        </span>

                        <span class="text-sm font-weight-light n_<?= $red ?>">Universidad del grupo de investigación</span>
                        <span class="font-italic text-center">
                            <?= empty($lugares['tercero']['uni']) ? 'Sin asignar': $lugares['tercero']['uni'] ?>
                        </span>

                        <span class="text-sm font-weight-light n_<?= $red ?>">Clave del grupo de investigación</span>
                        <span class="font-italic text-center">
                            <?= empty($lugares['tercero']['claveCuerpo']) ? 'Sin asignar': $lugares['tercero']['claveCuerpo'] ?>
                        </span>
                        <?php
                        if(!empty($lugares['tercero']['miembros'])){
                            echo '<h4>Ganadores</h4>';
                            echo '<div class="row divGanadores">';
                            foreach($lugares['tercero']['miembros'] as $l){
                                ?>
                                <img class='imgUsuarios' src="<?= base_url('resources/img/profiles').'/'.$l['profile_pic'] ?>" alt="<?= $l['nombre'] ?>" title="<?= $l['nombre'] ?>">
                                <?php
                            }
                            echo '</div>';
                        }
                        ?>
                        <button class="btn btn-warning btnEditar" data-lugar='3'>Editar ganador <i class="mdi mdi-pencil"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalGanador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar ganador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class='text-danger'>X</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAct">
                    <div class="form-group">
                        <label for="">Selecciona la ponencia a la cual se le asignara el reconocimiento de <b id='lugar_modal'></b> lugar </label>
                        <select name="" id="selectPonencias" class="form-control" required>
                            <option value="" selected disabled>Seleccione una ponencia</option>
                            <?php
                            foreach($ponencias as $p){
                                ?>
                                <option data-submission="<?= $p['submission_id'] ?>" data-publication="<?= $p['publication_id'] ?>" value="<?= $p['publication_id'] ?>">
                                    <?= $p['submission_id'] . ' - '.$p['nombre'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type='hidden' id='input_lugar' value='' />

                    <div class='form-group'>
                        <button class="btn btn-success btn-block" id="btnSubmitGanador">Guardar cambios</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<script>
/* No funciona el select2 */
let public_submisson;
let public_publication;
let public_lugar;

$(document).ready(function(){
    $("#btnSubmitGanador").addClass('disabled').css('cursor','not-allowed')
})

$(".btnEditar").on('click',function(){
    let lugar = $(this).data('lugar');

    if(lugar === undefined){
        alert('Faltan configuraciones')
        return
    }

    $("#lugar_modal").text(lugar).css('color','lightgreen')
    $("#input_lugar").val(lugar)
    public_lugar = lugar
    $("#modalGanador").modal('show')
})

$("#selectPonencias").on('change',function(){
    // Obtén el valor del option seleccionado
    var selectedValue = $(this).val();

    // Encuentra el option seleccionado dentro del select
    var selectedOption = $(this).find('option[value="' + selectedValue + '"]');

    // Obtén los valores de data-submission y data-publication
    var submission_id = selectedOption.data('submission');
    var publication_id = selectedOption.data('publication');

    if(!submission_id || !publication_id){
        alert('Ocurrio un error')
        return
    }

    $("#btnSubmitGanador").removeClass('disabled').css('cursor','pointer')

    public_submisson = submission_id
    public_publication = publication_id

})

$("#btnSubmitGanador").on('click',function(e){
    e.preventDefault()
    /* Vamos a obtener la info para insertar la info */

    if(!public_publication || !public_submisson || !public_lugar){
        alert('Otro error')
        return;
    }

    $.ajax({
        type: 'post',
        url: '../../submit',
        data: {
            submission_id: public_submisson,
            publication_id: public_publication,
            lugar: public_lugar
        },
        dataType: 'json',
        beforeSend: function(){
            $("#loader").removeProp('display')
        },
        success: function(data){
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Reconocimientos otorgados correctamente'
            }).then(function(){
                window.location.reload();
            })
        },
        error: function(jqXHR){
            Swal.fire({
                icon: 'error',
                title: 'Lo sentimos',
                text: 'Ha ocurrido un error'
            })
        }
    })


    console.log(public_publication);
    console.log(public_submisson);
    console.log(public_lugar);
    return;
})
</script>