<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Capitulo digital de la ...</h4>
                <hr>
                <style>
                    .editor {
                        background-color: #fff;
                        width: 99%;
                        color: #000;
                    }

                    .divEditable {
                        background-color: #fff;
                        color: #000;
                    }

                    textarea {
                        background-color: #fff !important;
                        color: #000 !important;
                    }

                    td {
                        color: #000;
                    }
                </style>

                <div class="editor" id="editorID">
                    <h3>Discusión</h3>
                    <?= $discusion['discusion'] ?>
                    <table style="border: 1px solid black;">
                        <thead style="border: 1px solid black;">
                            <tr style="border: 1px solid black;">
                                <th style="font-weight: bold;">Dimension</th>
                                <th style="font-weight: bold;">Escala</th>
                                <th style="font-weight: bold;">Categoria</th>
                            </tr>
                        </thead>
                        <tbody style="border: 1px solid black;">
                            <?php
                            foreach ($array as $dimension) {
                                if (isset($dimension['escalas'])) {
                                    foreach ($dimension['escalas'] as $escala) {
                                        foreach ($escala['categorias'] as $categoria) {
                            ?>
                                            <tr style="border: 1px solid black;">
                                                <td style="border: 1px solid black;"><?= $dimension['nombre'] ?></td>
                                                <td style="border: 1px solid black;"><?= $escala['nombre'] ?></td>
                                                <td style="border: 1px solid black;"><?= $categoria['nombre'] ?></td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                } else {
                                    foreach ($dimension['categorias'] as $categoria) {
                                        ?>
                                        <tr style="border: 1px solid black;">
                                            <td style="border: 1px solid black;"><?= $dimension['nombre'] ?></td>
                                            <td style="border: 1px solid black;">No aplica</td>
                                            <td style="border: 1px solid black;"><?= $categoria['nombre'] ?></td>
                                        </tr>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <hr>

                <h3>Seleccione una opción</h3>
                <select name="estado" id="estado" class="form-control">
                    <option value="" selected disabled>Seleccione una opción</option>
                    <option value="16">Reenviar</option>
                    <option value="17">Rechazar</option>
                    <option value="18">Aceptar</option>
                </select>

                <div id="mensaje">
                    <hr>
                    <textarea name="retroalimentacion" id="retroalimentacion" cols="30" rows="10" class="form-control" placeholder="Escribir retroalimentacion a ..."></textarea>
                    <hr>
                    <button class="btn btn-block btn-info" id="enviar">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</div>

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
        });

    let claveCuerpo = '<?= $claveCuerpo ?>';


    $(document).ready(function() {
        $("#mensaje").hide()
    })

    $("#estado").on('change', function() {
        $("#mensaje").show()
    })

    $("#enviar").on('click', function() {
        let validacion = $("#estado option:selected").val()
        let retroalimentacion = $("#retroalimentacion").val()
        const editorData = $("#editorID").html().trim().replace(/\s+/g, ' ');

        const valoresValidacion = {
            16: 'REENVIAR',
            17: 'RECHAZAR',
            18: 'ACEPTAR'
        }

        Swal.fire({
            icon: 'question',
            title: `¿Estas seguro que deseas ${valoresValidacion.validacion} este capítulo digital?`,
            text: 'Esta acción no es reversible',
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí, estoy seguro',
        }).then((result) => {
            if (result.isConfirmed) {

                if (validacion == 18) {
                    $.ajax({
                        type: "post",
                        url: './getWord',
                        data: {
                            editorData,
                            claveCuerpo
                        },
                        success: function(response) {
                            let ruta = base_url + '/admin/descargar/capitulo_releg_digital/' + response;
                            window.location.href = ruta;
                            swal.fire({
                                title: 'Se ha descargado la previsualización del archivo. ¿Desea validar el capítulo?',
                                icon: 'info',
                                showCancelButton: true,
                                text: `Esta seria la versión que se mandaria a editorial. Favor de darle estilos a la tabla, 
                                debido a la libreria usada, no se pueden aplicar los estilos del editor. 
                                Acción reversible contactando a sistemas.`,
                                input: 'file',
                                inputAttributes: {
                                    'accept': '.docx,.doc',
                                    'aria-label': 'Subir correcciones del archivo'
                                },
                                cancelButtonColor: '#d33',
                                confirmButtonColor: '#3085d6',
                                cancelButtonText: 'No',
                                confirmButtonText: 'Sí',
                                allowOutsideClick: false,
                                backdrop: true,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    console.log(result);
                                    if (result.value === null) {
                                        alert('Suba un archivo');
                                        return
                                    }
                                    var archivo = result.value;

                                    var formData = new FormData();
                                    formData.append("validacion", validacion);
                                    formData.append("retroalimentacion", retroalimentacion);
                                    formData.append("editorData", editorData);
                                    formData.append("claveCuerpo", claveCuerpo);
                                    formData.append("archivo", archivo);

                                    $.ajax({
                                        type: 'post',
                                        dataType: 'json',
                                        url: './validar',
                                        data: formData,
                                        processData: false, // Importante: deshabilitar el procesamiento automático de datos
                                        contentType: false, // Importante: deshabilitar el tipo de contenido automático
                                        beforeSend: function() {
                                            $("#enviar").prop('disabled', true)
                                        },
                                        success: function(data) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: data.title,
                                                text: data.text
                                            })
                                        },
                                        error: function(jqXHR) {
                                            $("#enviar").prop('disabled', false)
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error ' + jqXHR.status,
                                                text: jqXHR.responseText
                                            })
                                        }
                                    })
                                }
                            })
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(textStatus + " " + errorThrown + " " + jqXHR);
                            $("#submit").prop('disabled', false);
                        }
                    })

                    return
                }

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: './validar',
                    data: {
                        validacion,
                        retroalimentacion,
                        editorData,
                        claveCuerpo
                    },
                    beforeSend: function() {
                        $("#enviar").prop('disabled', true)
                    },
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(jqXHR) {
                        $("#enviar").prop('disabled', false)
                        console.log(jqXHR);
                    }
                })
            }
        })

    })
</script>