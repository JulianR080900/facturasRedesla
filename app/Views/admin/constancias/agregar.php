<h1>Agregar constancias</h1>
<hr>

<form action="insert" method="post" id="form">

    <label for="ConstanciaSelect2">Seleccione el tipo de constancia</label>
    <select class="selectConstancia form-control" name="tipo_constancia" id="ConstanciaSelect2" style="width:100%" required>
        <option value="" selected disabled>Selecciona un tipo de constancia</option>
        <?php
        foreach ($constancias as $c) {
        ?>
            <option value="<?= $c['abreviacion'] ?>"><?= $c['nombre'] ?></option>
        <?php
        }
        ?>
    </select>

    <div id="red">
        <label for="RedSelect2">Area de revisión(Red)</label>
        <select class="selectAreaRevision form-control" name="red" id="RedSelect2" style="width:100%">
            <option value="" selected disabled>Seleccione una red</option>
            <?php
            foreach ($redes as $r) {
            ?>
                <option value="<?= $r['nombre_red'] ?>"><?= $r['nombre_red'] ?></option>
            <?php
            }
            ?>
        </select>
    </div>

    <div id="correo">
        <label for="inp_correo">Ingrese el correo</label>
        <input type="email" class="form-control" name="correo" id="inp_correo">
    </div>

    <div id="nombre">
        <label for="inp_nombre">Ingrese el nombre del autor</label>
        <input type="text" class="form-control" name="nombre" id="inp_nombre">
    </div>

    <div id="id_ponencia">
        <label for="inp_ponencia">Ingresa el ID de ponencia</label>
        <input type="number" class="form-control" name="id_iq4" id="inp_ponencia">
    </div>

    <div id="nombre_ponencia">
        <label for="inp_nombre_ponencia">Ingresa el nombre de la ponencia / artículo</label>
        <textarea name="nombre_ponencia" id="inp_nombre_ponencia" cols="30" rows="10" class="form-control"></textarea>
    </div>

    <div id="fecha">
        <label for="fecha_revision">Fecha de revisión</label>
        <input type="date" name="fecha_revision" class="form-control" id="inp_fecha">
    </div>

    <div id="universidad">
        <label for="inp_universidad">Universidad</label>
        <input type="text" name="universidad" class="form-control" id="inp_universidad">
    </div>

    <div id="grados_academicos">
        <label for="gradosSelect2">Grado académico</label>
        <select class="selectGrados form-control" name="grado_academico" id="gradosSelect2" style="width:100%">
            <option value="" selected disabled>Seleccione un grado académico</option>
            <option value="Dra.">Doctora</option>
            <option value="Dr.">Doctor</option>
            <option value="Mtro.">Maestro</option>
            <option value="Mtra.">Maestra</option>
            <option value="Lic.">Licenciatura</option>
            <option value="Ing.">Ingenieria</option>
        </select>
    </div>

    <div id="apellido_paterno">
        <label for="inp_ap_paterno">Apellido paterno</label>
        <input type="text" name="ap_paterno" class="form-control" id="inp_ap_paterno">
    </div>

    <div id="usuario">
        <label for="selectUsuario">Seleccione un usuario</label>
        <select class="selectUsuario form-control" name="usuario" id="usuarioSelect2" style="width:100%">
            <option value="" selected disabled>Selecciona un usuario</option>
            <?php
            foreach ($usuarios as $u) {
                $nombre = $u['nombre'] . ' ' . $u['ap_paterno'] . ' ' . $u['ap_materno'];
            ?>
                <option value="<?= $u['usuario'] ?>"><?= $nombre ?></option>
            <?php
            }
            ?>
        </select>
    </div>

    <div id="claveCuerpo">
        <label for="selectClaveCuerpo">Seleccione el cuerpo académico del usuario</label>
        <select class="selectClaveCuerpo form-control" name="claveCuerpo" id="claveCuerpoSelect2" style="width:100%">
            <option value="" selected disabled>Selecciona un cuerpo académico</option>
        </select>
    </div>

    <div id="anio">
        <label for="selectAnio">Seleccione el año de la constancia / articulo / curso</label>
        <select class="selectAnio form-control" name="anio" id="anioSelect2" style="width:100%">
            <option value="" selected disabled>Selecciona el año de la constancia/artículo</option>
            <?php
            foreach ($anios as $a) {
            ?>
                <option value="<?= $a ?>"><?= $a ?></option>
            <?php
            }
            ?>
        </select>
    </div>

    <div id="previsualizar">
        <hr>
        <button type="button" class="btn btn-success btn-block pv">Previsualizar constancia de dictaminador</button>
    </div>

    <div id="edicion">
        
        <select class="selectEdicion form-control" name="edicion" id="edicionSelect2" style="width:100%">
            <option value="" selected disabled>Selecciona la edición del curso</option>
            <option value="1ra">1ra Edición</option>
            <option value="6ta">6ta Edición</option>
            <option value="13va">13va Edición</option>
        </select>
    </div>
    






    

    <hr>
    <button type="submit" class="btn btn-block btn-info">Agregar constancia</button>
</form>

<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>
<script>
    $(document).ready(function() {
        //ESTOS SON TODOS LOS INPUTS DISPONIBLES, SE VAN A HABILITAR O DESHABILITAR DEPENDIENDO DE LA OPCION SELECCIONADA
        $("#correo").hide();
        $("#red").hide();
        $("#id_ponencia").hide();
        $("#nombre").hide();
        $("#nombre_ponencia").hide();
        $("#fecha").hide();
        $("#universidad").hide();
        $("#grados_academicos").hide();
        $("#apellido_paterno").hide();
        $("#usuario").hide();
        $("#claveCuerpo").hide();
        $("#anio").hide();
        $("#edicion").hide();
        $("#previsualizar").hide();
    });

    if ($(".selectUsuario").length) {
        $(".selectUsuario").select2();
    }
    if ($(".selectClaveCuerpo").length) {
        $(".selectClaveCuerpo").select2();
    }
    if ($(".selectConstancia").length) {
        $(".selectConstancia").select2();
    }
    if ($(".selectAnio").length) {
        $(".selectAnio").select2();
    }
    if ($(".selectGrados").length) {
        $(".selectGrados").select2();
    }
    if ($(".selectAreaRevision").length) {
        $(".selectAreaRevision").select2();
    }
    if ($(".selectEdicion").length) {
        $(".selectEdicion").select2();
    }
    
    
    

    $("#ConstanciaSelect2").on('change', function() {
        //LOS INPUTS QUE SE HABILITAN O DESABILITAAN SON LOS SIGUIENTES
        //("#id_ponencia").prop('required',true).prop('disabled',false);
        var constancia = $("#ConstanciaSelect2 option:selected").val();
        if (constancia == 'DIC') {
            //INPUTS NECESARIOS
            $("#RedSelect2").prop('required',true).prop('disabled',false);
            $("#inp_correo").prop('required',true).prop('disabled',false);
            $("#inp_nombre").prop('required',true).prop('disabled',false);
            $("#inp_ponencia").prop('required',true).prop('disabled',false);
            $("#inp_nombre_ponencia").prop('required',true).prop('disabled',false);
            $("#inp_fecha").prop('required',true).prop('disabled',false);
            $("#inp_universidad").prop('required',true).prop('disabled',false);
            $("#gradosSelect2").prop('required',true).prop('disabled',false);
            $("#inp_ap_paterno").prop('required',true).prop('disabled',false);
            $("#anioSelect2").prop('required',true).prop('disabled',false);
            //INPUTS QUE NO SE NECESITAN
            $("#usuarioSelect2").prop('required',false).prop('disabled',true);
            $("#claveCuerpoSelect2").prop('required',false).prop('disabled',true);
            $("#edicionSelect2").prop('required',false).prop('disabled',true);
            //MOSTRAR Y OCULTAR INPUTS
            $("#red").show();
            $("#correo").show();
            $("#nombre").show();
            $("#id_ponencia").show();
            $("#nombre_ponencia").show();
            $("#fecha").show();
            $("#universidad").show();
            $("#grados_academicos").show();
            $("#apellido_paterno").show();
            $("#anio").show();
            $("#usuario").hide();
            $("#claveCuerpo").hide();
            $("#edicion").hide();
            $("#previsualizar").show()
        }else if(constancia == 'DISTDIC'){
            alert('Esta constancia se genera automáticamente al tener 10 o mas constancias de DICTAMINADOR');
            //INPUTS NECESARIOS
            
            //INPUTS QUE NO SE NECESITAN
            $("#usuarioSelect2").prop('required',false).prop('disabled',true);
            $("#claveCuerpoSelect2").prop('required',false).prop('disabled',true);
            $("#RedSelect2").prop('required',false).prop('disabled',true);
            $("#inp_correo").prop('required',false).prop('disabled',true);
            $("#inp_nombre").prop('required',false).prop('disabled',true);
            $("#inp_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_nombre_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_fecha").prop('required',false).prop('disabled',true);
            $("#inp_universidad").prop('required',false).prop('disabled',true);
            $("#gradosSelect2").prop('required',false).prop('disabled',true);
            $("#inp_ap_paterno").prop('required',false).prop('disabled',true);
            $("#anioSelect2").prop('required',false).prop('disabled',true);
            $("#edicionSelect2").prop('required',false).prop('disabled',true);
            $("#previsualizar").hide();
            //MOSTRAR Y OCULTAR
            $("#red").hide();
            $("#correo").hide();
            $("#nombre").hide();
            $("#id_ponencia").hide();
            $("#nombre_ponencia").hide();
            $("#fecha").hide();
            $("#universidad").hide();
            $("#grados_academicos").hide();
            $("#apellido_paterno").hide();
            $("#anio").hide();
            $("#usuario").hide();
            $("#claveCuerpo").hide();
            $("#edicion").hide();
        }else if(constancia == 'CE' || constancia == 'MO'){
            //INPUTS NECESARIOS
            $("#RedSelect2").prop('required',true).prop('disabled',false);
            //$("#inp_correo").prop('required',true).prop('disabled',false);
            //$("#inp_nombre").prop('required',true).prop('disabled',false);
            $("#anioSelect2").prop('required',true).prop('disabled',false);
            $("#usuarioSelect2").prop('required',true).prop('disabled',false);       
            //INPUTS QUE NO SE NECESITAN
            $("#claveCuerpoSelect2").prop('required',false).prop('disabled',true);
            $("#inp_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_nombre_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_fecha").prop('required',false).prop('disabled',true);
            $("#inp_universidad").prop('required',false).prop('disabled',true);
            $("#gradosSelect2").prop('required',false).prop('disabled',true);
            $("#inp_ap_paterno").prop('required',false).prop('disabled',true);
            $("#edicionSelect2").prop('required',false).prop('disabled',true);
            $("#previsualizar").hide();
            //MOSTRAR Y OCULTAR INPUTS
            $("#red").show();
            $("#correo").hide();
            $("#nombre").hide();
            $("#anio").show();
            $("#usuario").show();
            $("#id_ponencia").hide();
            $("#nombre_ponencia").hide();
            $("#fecha").hide();
            $("#universidad").hide();
            $("#grados_academicos").hide();
            $("#apellido_paterno").hide();
            $("#claveCuerpo").hide();
            $("#edicion").hide();
        }else if(constancia == 'CTSNI' || constancia == 'CTMI' || constancia == 'CTEST'){
            //INPUTS NECESARIOS
            $("#inp_correo").prop('required',true).prop('disabled',false);
            $("#inp_nombre").prop('required',true).prop('disabled',false);      
            $("#edicionSelect2").prop('required',true).prop('disabled',false);
            $("#anioSelect2").prop('required',true).prop('disabled',false);
            //INPUTS QUE NO SE NECESITAN
            $("#usuarioSelect2").prop('required',false).prop('disabled',true);
            $("#claveCuerpoSelect2").prop('required',false).prop('disabled',true);
            $("#inp_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_nombre_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_fecha").prop('required',false).prop('disabled',true);
            $("#inp_universidad").prop('required',false).prop('disabled',true);
            $("#gradosSelect2").prop('required',false).prop('disabled',true);
            $("#inp_ap_paterno").prop('required',false).prop('disabled',true);
            $("#RedSelect2").prop('required',false).prop('disabled',true);
            $("#previsualizar").hide();
            //MOSTRAR Y OCULTAR INPUTS
            $("#correo").show();
            $("#nombre").show();
            $("#edicion").show();
            $("#anio").show();
            $("#id_ponencia").hide();
            $("#nombre_ponencia").hide();
            $("#fecha").hide();
            $("#universidad").hide();
            $("#grados_academicos").hide();
            $("#apellido_paterno").hide();
            $("#usuario").hide();
            $("#claveCuerpo").hide();
            $("#red").hide();
        }else if(constancia == 'MI' || constancia == 'MA' || constancia == 'PA'){
            //INPUTS NECESARIOS
            $("#usuarioSelect2").prop('required',true).prop('disabled',false);
            $("#anioSelect2").prop('required',true).prop('disabled',false);
            $("#claveCuerpoSelect2").prop('required',true).prop('disabled',false);
            $("#RedSelect2").prop('required',true).prop('disabled',false);
            //INPUTS QUE NO SE NECESITAN
            $("#inp_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_nombre_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_fecha").prop('required',false).prop('disabled',true);
            $("#inp_universidad").prop('required',false).prop('disabled',true);
            $("#gradosSelect2").prop('required',false).prop('disabled',true);
            $("#inp_ap_paterno").prop('required',false).prop('disabled',true);
            $("#inp_correo").prop('required',false).prop('disabled',true);
            $("#inp_nombre").prop('required',false).prop('disabled',true);
            $("#edicionSelect2").prop('required',false).prop('disabled',true);
            $("#previsualizar").hide();
            //MOSTRAR Y OCULTAR INPUTS
            $("#red").show();
            $("#anio").show();
            $("#usuario").show();
            $("#claveCuerpo").show();
            $("#correo").hide();
            $("#nombre").hide();
            $("#id_ponencia").hide();
            $("#nombre_ponencia").hide();
            $("#fecha").hide();
            $("#universidad").hide();
            $("#grados_academicos").hide();
            $("#apellido_paterno").hide();
            $("#edicion").hide();
        }else if(constancia == 'PO'){
            alert('Esta constancia aun no esta habilitada, falta enlace a iquatro');
            //INPUTS NECESARIOS
            
            //INPUTS QUE NO SE NECESITAN
            $("#usuarioSelect2").prop('required',false).prop('disabled',true);
            $("#claveCuerpoSelect2").prop('required',false).prop('disabled',true);
            $("#RedSelect2").prop('required',false).prop('disabled',true);
            $("#inp_correo").prop('required',false).prop('disabled',true);
            $("#inp_nombre").prop('required',false).prop('disabled',true);
            $("#inp_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_nombre_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_fecha").prop('required',false).prop('disabled',true);
            $("#inp_universidad").prop('required',false).prop('disabled',true);
            $("#gradosSelect2").prop('required',false).prop('disabled',true);
            $("#inp_ap_paterno").prop('required',false).prop('disabled',true);
            $("#anioSelect2").prop('required',false).prop('disabled',true);
            $("#edicionSelect2").prop('required',false).prop('disabled',true);
            $("#previsualizar").hide();
            //MOSTRAR Y OCULTAR
            $("#red").hide();
            $("#correo").hide();
            $("#nombre").hide();
            $("#id_ponencia").hide();
            $("#nombre_ponencia").hide();
            $("#fecha").hide();
            $("#universidad").hide();
            $("#grados_academicos").hide();
            $("#apellido_paterno").hide();
            $("#anio").hide();
            $("#usuario").hide();
            $("#claveCuerpo").hide();
            $("#edicion").hide();
            /*
            //INPUTS NECESARIOS
            $("#usuarioSelect2").prop('required',true).prop('disabled',false);
            $("#anioSelect2").prop('required',true).prop('disabled',false);
            $("#claveCuerpoSelect2").prop('required',true).prop('disabled',false);
            $("#RedSelect2").prop('required',true).prop('disabled',false);
            $("#inp_ponencia").prop('required',true).prop('disabled',false);
            //INPUTS QUE NO SE NECESITAN
            $("#inp_nombre_ponencia").prop('required',false).prop('disabled',true);
            $("#inp_fecha").prop('required',false).prop('disabled',true);
            $("#inp_universidad").prop('required',false).prop('disabled',true);
            $("#gradosSelect2").prop('required',false).prop('disabled',true);
            $("#inp_ap_paterno").prop('required',false).prop('disabled',true);
            $("#inp_correo").prop('required',false).prop('disabled',true);
            $("#inp_nombre").prop('required',false).prop('disabled',true);
            //MOSTRAR Y OCULTAR INPUTS
            $("#red").show();
            $("#anio").show();
            $("#usuario").show();
            $("#claveCuerpo").show();
            $("#id_ponencia").show();
            $("#correo").hide();
            $("#nombre").hide();
            $("#nombre_ponencia").hide();
            $("#fecha").hide();
            $("#universidad").hide();
            $("#grados_academicos").hide();
            $("#apellido_paterno").hide();
            */
        }
    });

    $("#usuarioSelect2").on('change', function(e) {
        var usuario = $("#usuarioSelect2 option:selected").val();
        console.log(usuario);

        $.ajax({
            url: '<?= base_url('admin/constancias/getCuerpos') ?>',
            type: "post",
            data: {
                usuario: usuario
            },
            success: function(response) {
                $(".selectClaveCuerpo").empty();
                $(".selectClaveCuerpo").append(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                $("#submit").prop('disabled', false);
            }
        });
    });

    $(document).on('click','.pv',function(){
        const form = $("#form").serialize()
        if(form.indexOf('=&') > -1 || form.substr(form.length - 1) == '='){
            return;
        }

        let actionAnterior = $('#form').attr('action');

        console.log(actionAnterior);

        $('#form').attr('action','./previsualizar');

        $('#form').attr('target', '_blank');

        $("#form").submit();

        $('#form').attr('action',actionAnterior);

        $('#form').attr('target', '');

        return;

        console.log(form);
        $.ajax({
            type: 'post',
            url: './previsualizar',
            data: form,
            success: function(data){
                console.log(data);
            },
            error(jqXHR){
                console.log(jqXHR);
            }
        })
    })
</script>