<h1 class="text-toupper">Redactar el mensaje para cambiar el estado de la categoría: <b class="text-info"><?= $nombre ?></b> a <?= $estado == 0 ? '<b class="text-danger">Rechazado</b>': '<b class="text-success">Validado</b>' ?></h1>
<style>
    .editor {
        background-color: #fff;
        height: 75%;
        width: 99%;
        color: #000;
    }

    .footer {
        display: none;
    }
</style>

<form action="" method="post">
    <label for="">Asunto</label>
    <input type="text" name="asunto" id="asunto" class="form-control" required value="<?= isset($asunto) ? $asunto:'' ?>"><br>
    <div class="editor"></div>
    <hr>
    <input type="submit" id="submit" value="Enviar Correo" class="btn btn-block btn-rounded btn-info">
</form>


<script>


    InlineEditor
        .create(document.querySelector('.editor'), {

            licenseKey: '',
            simpleUpload: {
                // The URL that the images are uploaded to.
                uploadUrl: '<?= base_url('admin/cuerpos/imageUpload') ?>',
            }
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: q621p0pn4u3q-91vshejkawwy');
            console.error(error);
        });

    document.querySelector('#submit').addEventListener('click', () => {
        event.preventDefault();
        $("#submit").prop('disabled',true);
        const editorData = editor.getData();
        var asunto = $("#asunto").val();

        if(asunto == '' || editorData == ''){
            Swal.fire({
                title: '<label style="color:#545454">Cuidado</label>',
                icon: 'warning',
                html:'<label style="color:#545454">Complete los campos correctamente</label>',
            })
            $("#submit").prop('disabled',false);
            return
        }

        $.ajax({
            url: '<?= base_url('admin/categorias/updateEstado') ?>',
            type: "post",
            data: {
                mensaje: editorData,
                asunto: asunto,
                estado: '<?= $estado ?>',
                id: '<?= $id ?>',
                claveCuerpo: '<?= $claveCuerpo ?>'
            },
            success: function(response) {
                console.log(response);
                
                if(response == 'successAdmin'){
                    Swal.fire({
                        title: '<label style="color:#545454">Éxito</label>',
                        icon: 'success',
                        html:'<label style="color:#545454">Se cambió el estado de la categoría, no se enviaron correo debido a que la categoría fue insertada por un administrador</label>',
                    }).then(function(){
                        window.location.href = '<?= base_url('admin/categorias/lista') ?>';
                    });
                }else if(response == 'successCorreos'){
                    Swal.fire({
                        title: '<label style="color:#545454">Éxito</label>',
                        icon: 'success',
                        html:'<label style="color:#545454">Se cambió el estado de la categoría y se enviaron los correos a los miembros del cuerpo académico</label>',
                    }).then(function(){
                        window.location.href = '<?= base_url('admin/categorias/lista') ?>';
                    });
                }else{
                    Swal.fire({
                        title: '<strong style="color:#545454">Lo sentimos</strong>',
                        icon: 'error',
                        html:'<label style="color:#545454">Ha ocurrido un error, contacte a sistemas</label>',
                    })
                    $("#submit").prop('disabled',false);
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                $("#submit").prop('disabled',false);
            }
        });
    });

</script>