<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Capitulo de la <?= $universidad ?></h4>
                <hr>
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

                    .checkedBox:checked {
                        background-color: green;
                    }

                    .divEditable {
                        background-color: #fff;
                        color: #000;
                    }
                    textarea{
                        background-color: #fff !important;
                        color: #000 !important;
                    }
                </style>

                <form action="./guardar" method="post" id="formularioCapitulo">
                    <p>INSTRUCCIONES</p>
                    <p>
                        A continuación, se muestra el listado de los códigos en vivo y analisis de cada categoria que se fue seleccionado por la <?= $universidad ?>. 
                        Se deberá validar cada código y cada análisis seleccionado por ellos de manera manual dando clic sobre el boton de <label for="" class="text-secondary">validar</label> 
                        ubicado al lado de los códigos en vivo y análisis utilizados. Se podra retroalimentar el porque ha sido rechazado por categoria, si no existe una retroalimentación, deje el campo en blanco. 
                        Al finalizar, seleccione un estado para el capítulo, si deben reenviar, rechazar o validar.
                    </p>
                    <input type="hidden" name="id_capitulo" value="<?= $id_capitulo ?>">
                    <input type="hidden" name="claveCuerpo" id="claveCuerpo" value="<?= $claveCuerpo ?>">
                    <h3 class="text-warning">Enfoque utilizado:</h3>
                    <p><?= $enfoque ?></p>
                    <h3 class="text-warning">Códigos en vivo utilizados:</h3>
                    <hr>
                    <?php
                    foreach ($categorias as $c) {
                    ?>
                        <h5 class="text-info">Nombre de la categoría:</h5>
                        <p><?= $c['nombre_categoria'] ?></p>
                        <h5>Códigos en vivo:</h5>
                        <?php
                        foreach ($c['codigos'] as $co) {
                            $cadena = $co['codigo_en_vivo'];
                            $cadena = preg_replace('/\s+/', ' ', $cadena); // Eliminar espacios dobles y saltos de línea
                            $cadena = str_replace(PHP_EOL, '', $cadena); // Eliminar saltos de línea
                            $cadena = trim($cadena); // Eliminar espacios en blanco al principio y al final de la cadena
                            if(mb_strlen($cadena) > 280){
                                $txt = 'danger';
                            }else{
                                $txt = 'success';
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-5">
                                    <h6>ID entrevista</h6>
                                    <p><?= $co['id_entrevista'] ?></p>
                                </div>
                                <div class="col-md-5">
                                    <h6>Código en vivo</h6>
                                    <div contenteditable="true" class="divEditableCodigos" data-id='<?= $co['id_codigo'] ?>'>
                                        <?= $cadena ?>
                                    </div>
                                    <input type="text" name='codigos_editables[<?= $co['id_codigo'] ?>]' id='inputEditable_cev_<?= $co['id_codigo'] ?>' value='<?= $cadena ?>' hidden>
                                    <p class="text-info">Cantidad de caracteres: <label for="" id="count_<?= $co['id_codigo'] ?>" class="text-<?= $txt ?>"><?= mb_strlen($co['codigo_en_vivo']) ?></p>
                                </div>
                                <div class="col-md-2 text-center">
                                    <h6>Validar</h6>
                                    <input type="checkbox" name="codigos[]" id="" value="<?= $co['id_codigo'] ?>" <?= strpos($codigos_validos, $co['id_codigo']) !== false ? 'checked style="" class="checkedBox"' : '' ?>>
                                    <?= strpos($codigos_validos, $co['id_codigo']) !== false ? '<p class="text-success">Validado anteriormente</p>' : '' ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-10">
                                <h6>Análisis</h6>
                                <p><?= $c['analisis'] ?></p>
                            </div>
                            <div class="col-md-2 text-center">
                                <h6>Validar</h6>
                                <input type="checkbox" name="analisis[]" id="" value="<?= $c['nombre_categoria'] ?>" <?= strpos($analisis_validos, $c['nombre_categoria']) !== false ? 'checked class="checkedBox"' : '' ?>>
                                <?= strpos($analisis_validos, $c['nombre_categoria']) !== false ? '<p class="text-success">Validado anteriormente</p>' : '' ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Observaciones</label>
                                <p class="text-sm">Escriba aqui las observaciones para la categoria. Si no existen haga caso omiso al campo.</p>
                                <textarea name="observaciones[<?= $c['id'] ?>]" id="" cols="30" rows="10" class="form-control" placeholder="Escriba aquí las observaciones"><?= $c['observaciones'] ?></textarea>
                            </div>
                        </div>
                        <hr style="background-color: yellow;">
                    <?php
                    }
                    ?>
                    <div>
                        <label for="">¿Que estado desea aplicar? <span class="text-warning">Si solo desea guardar, no seleccione ningun estado.</span></label>
                        <select name="accion" id="select_accion" class="form-control">
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="14">Rechazar</option>
                            <option value="12">Reenviar</option>
                        </select>
                    </div>
                    <hr>
                    <div id="editor">
                        <h3>Version preliminar del capítulo</h3>
                        <p>Instrucciones: La versión preeliminar que se muestra a continuación puede ser editada. Favor de solamente hacer correccipnes pequeñas,
                            puesto que si hace cambios grandes, puede afectar a la estructura final del documento. Antes de <label for="" class="text-info">Guardar cambios</label>
                            vea la <label for="" class="text-secondary">Previsualización del capítulo</label>. Si existe errores de visualización o de formato, favor de contactar a sistemas.
                            <label for="" class="text-danger">Favor de no eliminar <u>~no_capitulo~</u>.</label>
                        </p>

                        <!-- <div contenteditable="true" class="divEditable" id="capitulo"><?php //$html_capitulo ?></div> -->
                        <hr>
                        <button type="button" class="btn btn-rounded btn-secondary btn-block" id="verCapitulo">Previsualización del capítulo</button>
                    </div>


                    <button type="submit" id="submit" class="btn btn-block btn-rounded btn-info">Guardar cambios</button>
                </form>



                <script>

                    $(document).ready(function() {
                        $("#editor").hide();
                    })

                    let checkboxes = document.querySelectorAll('input[type="checkbox"]');

                    function contarChecked() {
                        let contador = 0;

                        checkboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                contador++
                            }
                        });

                        const select = document.getElementById('select_accion');

                        if (contador == checkboxes.length) {

                            const option = document.createElement('option')

                            option.text = 'Validar';
                            option.value = '11';

                            select.appendChild(option);
                        } else {
                            let valor_buscado = '11'
                            let indice = -1;

                            for (let i = 0; i < select.options.length; i++) {
                                if (select.options[i].value === valor_buscado) {
                                    indice = i;
                                    break;
                                }
                            }
                            if (indice == -1) {
                                return;
                            }
                            select.remove(indice)
                            $("#submit").show()
                        }
                    }

                    function formCapitulo() {
                        //const editorData = $("#capitulo").html().trim().replace(/\s+/g, ' ');
                        let claveCuerpo = $("#claveCuerpo").val()
                        $.ajax({
                            type: "post",
                            url: './getWord',
                            data: {
                                //mensaje: editorData,
                                claveCuerpo: claveCuerpo
                            },
                            success: function(response) {
                                let ruta = base_url + '/admin/descargar/capitulo_releg/' + response;
                                window.location.href = ruta;
                                swal.fire({
                                    title: 'Se ha descargado la previsualización del archivo. ¿Desea validar el capítulo?',
                                    icon: 'info',
                                    showCancelButton: true,
                                    text: 'Esta seria la versión que se mandaria a editorial. Acción reversible contactando a sistemas.',
                                    cancelButtonColor: '#d33',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonText: 'No',
                                    confirmButtonText: 'Sí',
                                    allowOutsideClick: false,
                                    backdrop: true,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let datosFormulario = $('#formularioCapitulo').serialize(); // Serializa los datos del formulario
                                        datosFormulario += '&claveCuerpo=' + claveCuerpo;
                                        $.ajax({
                                            url: './guardar',
                                            type: "post",
                                            data: datosFormulario,
                                            success: function(response) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Información actualizada y capítulo guardado correctamente'
                                                }).then(function(){
                                                    let ruta = base_url + '/admin/entrevistas/lista'
                                                    window.location.href = ruta;
                                                })
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                alert(textStatus + " " + errorThrown + " " + jqXHR);
                                                $("#submit").prop('disabled', false);
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
                    }

                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', contarChecked);
                    });

                    let btnVer = document.getElementById('verCapitulo')

                    btnVer.addEventListener('click', formCapitulo);

                    $("#select_accion").on('change', function() {
                        let val = $(this).val()

                        if (val != 11) {
                            $("#editor").hide()
                            $("#submit").show()
                            return;
                        }
                        $("#editor").show()
                        $("#submit").hide()
                    })

                    $(document).on('keyup','.divEditableCodigos',function(){
                        let id = $(this).data('id');
                        let html = $(this).html().trim().replace(/&nbsp;/g, ' ').replace(/\n/g, '');
                        $("#inputEditable_cev_"+id).val(html)
                        $("#count_"+id).text(html.length)
                        if(html.length > 280){
                            $("#count_"+id).removeClass('text-success').addClass('text-danger')
                        }else{
                            $("#count_"+id).removeClass('text-danger').addClass('text-success')
                        }
                    })

                    $(document).on('change', 'input[name="codigos[]"]', function(){
                        if($(this).is(':checked')){
                            $(this).attr('checked',true)
                        }else{
                            $(this).attr('checked',false)
                        }
                    })

                </script>

            </div>
        </div>
    </div>
</div>