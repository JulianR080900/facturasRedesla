<style>
    .escalasRow {
        padding: 1rem;
    }

    .badge-danger {
        background: #fc424a !important;
        color: #ffffff !important;
        border-radius: 50% !important;
        margin-left: 5px !important;
        cursor: pointer !important;
    }

    #divEscalas {
        display: inline-flex;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Editar grupo</h4>
                <hr>
                <form id="form">
                    <div class="form-group">
                        <label for="">Nombre del grupo</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required value="<?= $grupo['nombre'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Descripción</label>
                        <textarea name="descripcion" id="" cols="30" rows="10" class="form-control" required><?= $grupo['descripcion'] ?></textarea>
                    </div>
                    <hr>
                    <h3>Escalas</h3>
                    <div class="form-group">
                        <div class='row'>
                            <div id="divEscalas">
                                <?php
                                if (count($escalas) > 0) {
                                    foreach ($escalas as $e) {
                                ?>
                                        <div id="escala_<?= $e['id'] ?>" class="escalasRow">
                                            <h6><span class="badge badge-pill badge-warning w-100"><?= $e['nombre'] ?><span class="badge badge-danger deleteEscala" data-id='<?= $e['id'] ?>'>x</span></span></h6>
                                            <input type='text' name='escalas[]' value='<?= $e['nombre'] ?>' hidden>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type='button' id="addEscala" data-toggle="modal" data-target="#exampleModal" class="btn btn-info btn-block">Agregar escala <i class="mdi mdi-plus"></i></button>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?= $grupo['id'] ?>" name="id" hidden>
                        <button type="submit" id="submit" class="btn btn-block btn-warning">Actualizar datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar escala</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <label>Nombre de la escala</label>
                <input type="text" name="nombre_escala" id="nombre_escala" class="form-control">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" id="addEscalaModal">Agregar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#form").on('submit', function(e) {
        e.preventDefault();

        const formData = $(this).serializeArray()

        $.ajax({
            type: 'post',
            dataType: 'json',
            data: formData,
            url: '../actualizar',
            beforeSend: function() {
                $("#submit").prop('disabled', true);
            },
            success: function(data) {
                Swal.fire({
                    icon: 'success',
                    title: data.title,
                    text: data.text
                }).then(function() {
                    window.location.href = '../lista'
                })
            },
            error: function(jqXHR) {
                $("#submit").prop('disabled', false);
                Swal.fire({
                    icon: 'danger',
                    title: 'Error ' + jqXHR.status,
                    text: jqXHR.responseText
                })
            }
        })
    })

    $("#addEscalaModal").on('click', function(e) {
        let nombre = $("#nombre_escala").val().trim();
        if (nombre == '') {
            return
        }
        let html = `
        <div id="escala_${nombre}" class="escalasRow">
            <h6><span class="badge badge-pill badge-warning w-100">${nombre}<span class="badge badge-danger deleteEscala" data-id='${nombre}'>x</span></span></h6>
            <input type='text' name='escalas[]' value='${nombre}' hidden>
        </div>                                    
        `
        $("#nombre_escala").val('')
        $("#divEscalas").append(html)
    })

    $(document).on('click', '.deleteEscala', function() {
        let id = $(this).data('id')

        $("#escala_" + id).remove()
    })
</script>