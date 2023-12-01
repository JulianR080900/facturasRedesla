<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Agregar dimensión</h4>
                <hr>
                <form id="form">
                    <div class="form-group">
                        <label for="">Nombre de la dimensión</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Descripción</label>
                        <textarea name="descripcion" id="" cols="30" rows="10" class="form-control" required></textarea>
                    </div>
                    <hr>
                    <h3>Escalas</h3>
                    <div class="form-group">
                        <div class='row'>
                            <div id="divEscalas"></div>
                            <button type='button' id="addEscala" data-toggle="modal" data-target="#exampleModal" class="btn btn-info btn-rounded">Agregar escala <i class="mdi mdi-plus"></i></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="submit" class="btn btn-block btn-success">Agregar dimensión</button>
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
    $("#form").on('submit',function(e){
        e.preventDefault();

        const formData = $(this).serializeArray()

        $.ajax({
            type: 'post',
            dataType: 'json',
            data: formData,
            url: './post',
            beforeSend: function(){
                $("#submit").prop('disabled',true);
            },
            success: function(data){
                Swal.fire({
                    icon: 'success',
                    title: data.title,
                    text: data.text
                }).then(function(){
                    window.location.href = './lista'
                })
            },
            error: function(jqXHR){
                $("#submit").prop('disabled',false);
                Swal.fire({
                    icon: 'danger',
                    title: 'Error '+jqXHR.status,
                    text: jqXHR.responseText
                })
            }
        })
    })

    $("#addEscalaModal").on('click',function(e){
        let nombre = $("#nombre_escala").val().trim();
        if(nombre == ''){
            return
        }
        let html = `
        <span class="badge badge-pill badge-warning">${nombre}</span>
        <input type='text' name='escalas[]' value='${nombre}' hidden>
        `
        $("#nombre_escala").val('')
        $("#divEscalas").append(html)
    })
</script>