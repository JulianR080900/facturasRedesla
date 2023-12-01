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
    body{
        
    }

    /*
    base_url('admin/cuerpos/guardarMensaje')
    */
</style>
<h1>Editor de Correo</h1>
<hr>
<form action="" method="post">
    <label for="">Asunto</label>
    <input type="text" name="asunto" id="asunto" class="form-control" required value="<?= isset($asunto) ? $asunto:'' ?>"><br>
    <div class="editor">
        <?= isset($correo) ? $correo : ''; ?>
    </div>

    <hr>
    <input type="submit" id="submit" value="Guardar Correo" class="btn btn-block btn-rounded btn-info">
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
        const editorData = editor.getData();
        var asunto = $("#asunto").val();
        $.ajax({
            url: '<?= base_url('admin/cuerpos/guardarMensaje') ?>',
            type: "post",
            data: {
                mensaje: editorData,
                tipo: '<?= $mensaje['tipo'] ?>',
                red: '<?= $mensaje['red'] ?>',
                anio: '<?= $mensaje['anio'] ?>',
                asunto: asunto
            },
            success: function(response) {
                if(response == 'success'){
                    location.reload();
                }else{
                    alert('error');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
            }
        });
    });

</script>