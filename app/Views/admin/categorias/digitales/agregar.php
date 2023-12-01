<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de categorías</h4>
                <hr>
                <form id="form">
                    <div class="form-group">
                        <label for="">Nombre de la categoria</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Descripción</label>
                        <textarea name="descripcion" id="" cols="30" rows="10" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Código en vivo</label>
                        <textarea name="codigo_en_vivo" id="" cols="30" rows="10" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Color</label>
                        <input type="color" name="color" id="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="submit" class="btn btn-block btn-success">Agregar categoria</button>
                    </div>
                </form>
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
</script>