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
<div class="content-wrapper">
<h1 class="text-uppercase">Editor de instrucciones para <?= $info['tipo'].' '.$info['red'].' '.$info['anio'] ?> <?= isset($info['congreso']) ? ': '.$info['congreso']:'' ?></h1>
<hr>
<form action="" method="post">
    <div class="editor">
        <?= isset($instrucciones) ? $instrucciones : ''; ?>
    </div>

    <hr>
    <input type="text" id="tipo_instruccion" value="<?= isset($info['congreso']) ? $info['congreso']:'' ?>" hidden>
    <input type="submit" id="submit" value="Guardar instrucciones" class="btn btn-block btn-rounded btn-info">
</form>
</div>



<script>

var tipo_instruccion = $("#tipo_instruccion").val()

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
        }
    );

    const segments = window.location.pathname.split('/').filter(segment => segment !== '');

    let url = '';

    if(segments.length == 8){
        url = '../../../../guardarInstruccion'
    }else if(segments.length == 7){
        url = '../../../guardarInstruccion'
    }else{
        window.close()
    }
    console.log(segments.length);

    document.querySelector('#submit').addEventListener('click', () => {
        event.preventDefault();
        const editorData = editor.getData();
        if(editorData == ''){
            swal.fire({
                icon:'warning',
                title:'No deje campos vacios'
            })
            return;
        }

        $.ajax({
            url: url,
            type: "post",
            data: {
                mensaje: editorData,
                red: '<?= $info['red'] ?>',
                anio: '<?= $info['anio'] ?>',
                tipo: '<?= $info['tipo'] ?>',
                tipo_instruccion: tipo_instruccion
            },
            success: function(response) {
                console.log(response);
                if(response == 'success'){
                    swal.fire({
                        icon:'success',
                        title:'Accion realizada correctamente'
                    }).then(function(){
                        location.reload();
                    })
                    
                }else{
                    swal.fire({
                        icon:'error',
                        title:'Ha ocurrido un error. Contacte a sistemas'
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
            }
        });
    });

</script>