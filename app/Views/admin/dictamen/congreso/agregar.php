<style>
    input {
        color: gray !important;
    }
</style>
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Agregar carta de dictamen del libro derivado de congreso</h4>
                <hr>
                <form action="./getPDF" method="post" class="needs-validation" novalidate id="form">
                    <div>
                        <label for="">Universidad</label>
                        <select name="universidad" id="universidad" class="form-control selectUni" required style="width: 100%;">
                            <option value="" selected disabled>Seleccione una opción</option>
                            <?php
                            foreach ($universidades as $u) {
                            ?>
                                <option value="<?= $u['nombre'] ?>"><?= $u['nombre'] ?></option>
                            <?php
                            }
                            ?>
                            <option value="otra">Otra</option>
                        </select>
                    </div>
                    <div id="otra_uni">
                        <label for="">Especifique la universidad</label>
                        <input type="text" name="universidad" id="otra_uni_input" class="form-control">
                    </div>
                    <div>
                        <label for="">ID del trabajo en IQuatro</label>
                        <input type="number" name="submission_id" id="submission_id" class="form-control" required>
                    </div>
                    <div>
                        <label for="">Nombre del trabajo</label>
                        <p class="text-muted">Este campo y los autores se autocompletará automáticamente. Se podrá editar si existe o se presenta algun error. Si no aplican mas autores, deje el campo en blanco.</p>
                        <input type="text" name="nombre_trabajo" id="nombre_trabajo" class="form-control" readonly required>
                    </div>
                    <div>
                        <label for="">Autor 1</label>
                        <input type="text" name="autor_1" id="autor_1" class="form-control" readonly required>
                    </div>
                    <div>
                        <label for="">Autor 2</label>
                        <input type="text" name="autor_2" id="autor_2" class="form-control" readonly>
                    </div>
                    <div>
                        <label for="">Autor 3</label>
                        <input type="text" name="autor_3" id="autor_3" class="form-control" readonly>
                    </div>
                    <div>
                        <label for="">Autor 4</label>
                        <input type="text" name="autor_4" id="autor_4" class="form-control" readonly>
                    </div>
                    <div>
                        <label for="">Libro</label>
                        <select class="selectLibro form-control" name="libros[]" id="libroSelect2" multiple="multiple" style="width:100%" required>
                            <?php
                            foreach ($libros as $l) {
                            ?>
                                <option value="<?= $l['id'] ?>"><?= $l['nombre'] ?></option>
                            <?php
                            }
                            ?>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div id="divOtroLibro">
                        <div>
                            <label for="">Especifique el nombre del libro</label>
                            <input type="text" name="libros" id="otro_libro" class="form-control">
                        </div>
                        <div>
                            <label for="">Especifique el nombre del/los capítulo (s).</label>
                            <input type="text" name="capitulos" id="otro_capitulos" class="form-control">
                        </div>
                        <div>
                            <label for="">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-control">
                        </div>
                        <div>
                            <label for="">Enlace de consulta</label>
                            <input type="text" name="enlace" id="enlace" class="form-control">
                        </div>
                    </div>







                    <div id="divCapitulos">
                        <label for="">Seleccione los capitulos</label>
                        <select class="capitulos" name="capitulos[]" multiple="multiple" id="capitulos" style="width:100%" required>
                        </select>
                    </div>
                    <div>
                        <label for="">Red</label>
                        <select name="red" id="red" class="form-control" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <?php
                            foreach ($redes as $r) {
                            ?>
                                <option value="<?= $r['nombre_red'] ?>"><?= $r['nombre_red'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="">Congreso</label>
                        <select name="congreso" id="congreso" class="form-control" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <?php
                            foreach ($congresos as $c) {
                            ?>
                                <option value="<?= $c['id'] ?>"><?= $c['nombre'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <div>
                        <button type="submit" class="btn btn-block btn-success">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<iframe id="iframe" name="myIframe" frameborder="5" width="500" height="300"></iframe>


<script>
    let base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $("#otra_uni").hide()
        $("#divOtroLibro").hide()
    });

    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }else{
                        event.preventDefault()
                        let formEl = document.forms.form;
                        const formData = new FormData(formEl);
                        console.log($(this).serialize());
                        formData.append('key', 'value')
                        formEl.submit()
                        Swal.fire({
                            title: '¿Desea guardar el registro?',
                            text: "Se ha descargado el archivo en su computadora. Si desea guardar el registro para almacenarlo en la base de datos y consultarlo cuando se desee, de clic en GUARDAR.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Guardar',
                            cancelButtonText: 'No deseo guardar'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "POST",
                                    url: './insert',
                                    data: formData,
                                    processData: false,  // tell jQuery not to process the data
                                    contentType: false,
                                    success: function(data) {
                                        if(data == 'success'){
                                            swal.fire({
                                                icon: 'success',
                                                title: 'Éxito',
                                                text: 'Registro guardado correctamente'
                                            }).then(function(){
                                                window.location.href = base_url+'/admin/dictamen/libro_congreso/lista'
                                            })
                                        }else{
                                            swal.fire({
                                                icon: 'error',
                                                title: 'Lo sentimos',
                                                text: 'Ha ocurrido un error. Intente mas tarde.'
                                            }).then(function(){
                                                location.reload();
                                            })
                                        }
                                    },
                            });
                            }
                        })
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    if ($(".selectUni").length) {
        $(".selectUni").select2();
    }
    if ($(".selectLibro").length) {
        $(".selectLibro").select2();
    }
    if ($(".capitulos").length) {
        $(".capitulos").select2();
    }


    $("#submission_id").focusout(function() {
        let val = $(this).val()
        $.ajax({
            type: "POST",
            url: base_url + "/admin/dictamen/getInfoIquatro",
            data: {
                id: val,
            },
            success: function(data) {
                if (data == 'no_publication_id') {
                    $("#nombre_trabajo").prop('readonly',false)
                    $("#autor_1").prop('readonly',false)
                    $("#autor_2").prop('readonly',false)
                    $("#autor_3").prop('readonly',false)
                    $("#autor_4").prop('readonly',false)
                    return
                }
                $("#nombre_trabajo").prop('readonly', false)
                $("#nombre_trabajo").val(data['nombre_ponencia'])
                Object.entries(data['autores']).forEach(([key, value]) => {
                    $("#autor_" + (parseInt(key) + 1)).val(value['nombre']).prop('readonly', false)
                });
            },
        });
    });

    $("#libroSelect2").on('change', function(e) {
        let libros = $(".selectLibro").val();
        const inputs = $("#divOtroLibro :input[type='text']")
        if(libros.length == 0){
            requiredOption(inputs,false)
            $("#capitulos").prop('disabled',false)
            $("#divOtroLibro").hide()
            $("#divCapitulos").show()
            return;
        }

        if(libros != 'otro'){
            requiredOption(inputs,false)
            $("#capitulos").prop('disabled',false)
            $("#divOtroLibro").hide()
            $("#divCapitulos").show()
            $.ajax({
                url: '<?= base_url('admin/libros/getCapitulos') ?>',
                type: "post",
                data: {
                    libros: libros
                },
                success: function(response) {
                    $(".capitulos").empty();
                    $(".capitulos").append(response);
                    return;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown, jqXHR);
                    $("#submit").prop('disabled', false);
                }
            });
            return;
        }
        requiredOption(inputs,true)
        $("#capitulos").prop('disabled',true)
        $("#divCapitulos").hide()
        $("#divOtroLibro").show()
        
    });

    function requiredOption(obj,option){
        Object.values(obj).forEach(val => {
            if(option === false){
                $("#"+val.id).prop('required',option).prop('disabled',true)
            }else{
                $("#"+val.id).prop('required',option).prop('disabled',false)
            }
            
        })
    }

    $("#universidad").on('change', function() {
        let val = $(this).val()
        if (val == 'otra') {
            $("#otra_uni_input").prop('disabled', false).prop('required', true).val('')
            $("#otra_uni").show()
        } else {
            $("#otra_uni_input").prop('disabled', true).prop('required', false).val('')
            $("#otra_uni").hide()
        }
    })
</script>