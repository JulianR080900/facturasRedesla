<h1>Cambio de miembros</h1>
<hr>
<h3>Seleccione los miembros que conformarán en el nuevo año</h3>
<form action="">
<label>Lider</label>
<select class="form-control" name="lider" id="lider" style="width:100%">
    <option value="" selected disabled>Selecciona un lider</option>
    <?php
    foreach ($info['miembros'] as $m) {
    ?>
        <option value="<?= $m['usuario'] ?>"><?= $m['nombre'] . ' ' . $m['apaterno'] . ' ' . $m['amaterno'] ?></option>
    <?php
    }
    ?>
    <option value="nuevo">Ingresra nuevo</option>
</select>

<div id="usuariosLider">
    <h5>Seleccione un usuario</h5>
    <select class="selectLider form-control" name="lider" id="liderSelect2" style="width:100%">
        <option value="" selected disabled>Selecciona un lider</option>
        <?php
        foreach ($info['usuarios'] as $m) {
        ?>
            <option value="<?= $m['usuario'] ?>"><?= $m['nombre'] . ' ' . $m['ap_paterno'] . ' ' . $m['ap_materno'] ?></option>
        <?php
        }
        ?>
    </select>
</div>
<div id="usuariosMiembro1">
    <h5>Seleccione el miembro 1</h5>
    <select class="selectLider form-control" name="miembro1" id="Miembro1Select2" style="width:100%">
        <option value="" selected disabled>Selecciona el primer miembro</option>
        <?php
        foreach ($info['usuarios'] as $m) {
        ?>
            <option value="<?= $m['usuario'] ?>"><?= $m['nombre'] . ' ' . $m['ap_paterno'] . ' ' . $m['ap_materno'] ?></option>
        <?php
        }
        ?>
    </select>
</div>
<button type="submit">Registrar</button>
</form>

<script>
    $(document).ready(function(){
        $("#usuariosLider").hide();
        $('#usuariosMiembro1').hide();
    });


    $("#lider").on('change', function(e) {
        var val = $("#lider option:selected").val();
        if (val == 'nuevo') {
            $("#usuariosLider").show();
        }
    });

    $('form').on('submit',function(e){
        e.preventDefault();
        var lider = $("#lider option:selected").val();
        if(lider == 'nuevo'){
            lider = $("#liderSelect2 option:selected").val();
        }

        if(lider == ''){
            alert('llena');
        }
        
    })


</script>

























<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>
<script>
    if ($(".selectLider").length) {
        $(".selectLider").select2();
    }
</script>