<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Agregar miembro a <u><?= $claveCuerpo ?></u></h4>
                <hr>
                <form id="formAddMiembro">
                    <div class='form-group'>
                        <label>Correo electrónico</label><span class="text-danger">*</span>
                        <input type="email" class="form-control" name="correo" id="correo">
                    </div>
                    <div class="form-group">
                        <button type="button" id="verificar" class="btn btn-info btn-block">Verificar correo</button>
                    </div>
                    <div id="infoMiembro">
                        <div class="form-group">
                            <label for="">Nombre</label><span class="text-danger">*</span>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Apellido paterno</label><span class="text-danger">*</span>
                            <input type="text" name="ap_paterno" id="ap_paterno" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Apellido materno</label>
                            <input type="text" name="ap_materno" id="ap_materno" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Grado académico</label><span class="text-danger">*</span>
                            <select name="grado" id="grado" class="form-control" required>
                                <option value="" selected disabled>Seleccione una opción</option>
                                <?php
                                foreach ($grados as $g) {
                                ?>
                                    <option value="<?= $g['id'] ?>"><?= $g['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Especialidad</label><span class="text-danger">*</span>
                            <input type="text" name="especialidad" id="especialidad" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Teléfono</label><span class="text-danger">*</span>
                            <input type="tel" name="telefono" id="telefono" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nivel de SNI</label><span class="text-danger">*</span>
                            <select name="nivelSNI" id="nivelSNI" class="form-control" required>
                                <option value="" selected disabled>Seleccione una opción</option>
                                <?php
                                foreach ($sni as $s) {
                                ?>
                                    <option value="<?= $s['id'] ?>"><?= $s['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div id="nombreSNI">
                            <div class="form-group">
                                <label for="">Año de SNI</label><span class="text-warning">*</span>
                                <input type="number" name="anoSNI" id="anoSNI" class="form-control" min="1900" max="<?= date('Y') ?>">
                            </div>
                        </div>
                        <div class='form-group'>
                            <label>Correo electrónico institucional</label><span class="text-danger">*</span>
                            <input type="email" class="form-control" name="correo_institucional" id="correo_institucional" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="claveCuerpo" id="claveCuerpo" hidden value="<?= $claveCuerpo ?>">
                            <input type="text" name="usuario" id="usuario" hidden>
                            <input type="text" name="red" id="red" hidden value="<?= $red ?>">
                            <button type="submit" id="btnSubmit" class="btn btn-block btn-success">Agregar miembro</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    let base_url = '<?= base_url() ?>';
</script>

<script>
    $(document).ready(function() {
        $("#infoMiembro").hide();
    })

    $("#verificar").on('click', function() {
        let email = $("#correo").val()
        var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);

        if (!caract.test(email)) {
            Swal.fire({
                icon: 'warning',
                title: 'Ingrese un correo válido.'
            })
            return;
        }

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: './verificar',
            data: {
                email
            },
            beforeSend: function(){
                $("#verificar").hide()
            },
            success: function(data) {
                if (data === false) {
                    $("#infoMiembro").show()
                    return
                }
                //Llenamos la info
                $("#nombre").val(data.nombre).prop('readonly',true)
                $("#ap_paterno").val(data.ap_paterno).prop('readonly',true)
                $("#ap_materno").val(data.ap_materno).prop('readonly',true)
                $(`#grado option[value=${data.grado}]`).attr('selected',true);
                $("#grado").attr("style", "pointer-events: none;");
                $("#especialidad").val(data.especialidad).prop('readonly',true)
                $("#telefono").val(data.telefono).prop('readonly',true);
                $(`#nivelSNI option[value=${data.nivelSNI}]`).attr('selected', true)
                $("#nivelSNI").attr("style", "pointer-events: none;");
                $("#anoSNI").val(data.anoSNI).prop('readonly', true)
                $("#correo_institucional").val(data.correo_institucional).prop('readonly', true)
                $("#usuario").val(data.usuario)
                $("#infoMiembro").show()
            },
            error: function(jqXHR) {
                console.log(jqXHR);
            }
        })
    })

    $("#nivelSNI").on('change',function(){
        let val = $(this).val()

        if(val == 6){
            $("#anoSNI").prop('required', false)
            $("#anoSNI").val('')
            $("#nombreSNI").hide();
            return;
        }
        $("#anoSNI").prop('required', true)
        $("#nombreSNI").show();
    })

    $("#formAddMiembro").on('submit', function(e){
        e.preventDefault();
        const form = $(this).serializeArray()
        let claveCuerpo = $("#claveCuerpo").val()
        Swal.fire({
            icon: 'info',
            title: 'Estas seguro de agregar este miembro al grupo '+claveCuerpo,
            showCancelButton: true,
            cancelButtonText: 'No',
            confirmButtonText: 'Sí'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: './submit',
                    data: form,
                    beforeSend: function(){
                        $("#btnSubmit").prop('disabled',true)
                    },
                    success: function(res){
                        if(res.codigo == 200){
                            Swal.fire({
                                icon: "success",
                                title: res.title,
                                text: res.mensaje,
                            }).then(function(){
                                window.location.href='../lista'
                            })
                        }
                    },
                    error: function(jqXHR){
                        $("#btnSubmit").prop('disabled',false);
                        Swal.fire({
                            icon: "error",
                            title: 'Error '+jqXHR.status,
                            text: jqXHR.responseText,
                        })
                    },
                })
            }
        })
    })
</script>