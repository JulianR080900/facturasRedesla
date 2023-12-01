<h1>Carta de dictamen</h1>
<hr>
<form action="<?= base_url('admin/libros/getPDF') ?>" method="post">
    <h5>Seleccione un cuerpo académico</h5>
    <select class="selectClaveCuerpo form-control" name="claveCuerpo" id="claveCuerpoSelect2" style="width:100%" required>
        <option value="" selected disabled>Selecciona un cuerpo académico</option>
        <?php
        foreach ($claves as $c) {
        ?>
            <option value="<?= $c['claveCuerpo'] ?>"><?= $c['claveCuerpo'] ?></option>
        <?php
        }
        ?>
        <option value="otra">Otra</option>
    </select>

    <div id="otra_uni">
        <label for="">Especifique el nombre de la universidad</label>
        <input type="text" name="nombre_uni" id="otra_uni_input" class="form-control">

        <label for="">Clave de la universidad</label>
        <input type="text" class="form-control" name="claveCuerpoOtra" id="otra_claveCuerpo">

        <label for="">Red de la universidad</label>
        <select name="red" id="red_otra_uni" class="form-control">
            <option value="" selected disabled>Seleccione una opción</option>
            <?php
            foreach($redes as $r){
                ?>
                <option value="<?= $r['nombre_red'] ?>"><?= $r['nombre_red'] ?></option>
                <?php
            }
            ?>
        </select>

        <label for="">Nombre Prodep</label>
        <p class="text-warning">Si no aplica, deje el campo vacío.</p>
        <input type="text" name="nombre_prodep" id="nombre_prodep" class="form-control">
    </div>

    <h5>Seleccione un libro</h5>
    <select class="selectLibro form-control" name="libros[]" id="libroSelect2" multiple="multiple" style="width:100%" required>
        <?php
        foreach ($libros as $l) {
        ?>
            <option value="<?= $l['id'] ?>"><?= $l['nombre'] ?></option>
        <?php
        }
        ?>
    </select>

    <h5>Seleccione los capitulos</h5>
    <select class="capitulos" name="capitulos[]" multiple="multiple" style="width:100%" required>
    </select>

    <h5>Investigación a la que corresponde</h5>
    <select class="selectInvestigacion form-control" name="investigacion" id="investigacionSelect2" style="width:100%" required>
        <option value="" selected disabled>Selecciona una investigación</option>
        <?php
        foreach ($investigaciones as $i) {
        ?>
            <option value="<?= $i['id'] ?>"><?= $i['nombre'] . ' ' . $i['red'] . ' ' . $i['anio'] ?></option>
        <?php
        }
        ?>
    </select>
    <hr>
    <button type="submit" class="btn btn-block btn-info">Generar carta</button>
    <br>
</form>

<style>
    h5 {
        padding-top: 1rem;
    }
</style>

<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>
<script>
    if ($(".selectClaveCuerpo").length) {
        $(".selectClaveCuerpo").select2();
    }
    if ($(".selectLibro").length) {
        $(".selectLibro").select2();
    }
    if ($(".capitulos").length) {
        $(".capitulos").select2();
    }
    if ($(".selectInvestigacion").length) {
        $(".selectInvestigacion").select2();
    }


    $("#libroSelect2").on('change', function(e) {
        var libros = $(".selectLibro").val();
        console.log(libros);
        $.ajax({
            url: '<?= base_url('admin/libros/getCapitulos') ?>',
            type: "post",
            data: {
                libros: libros
            },
            success: function(response) {
                $(".capitulos").empty();
                $(".capitulos").append(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                $("#submit").prop('disabled', false);
            }
        });
    });

    $(document).ready(function() {
        $("#otra_uni").hide()
    });

    $("#claveCuerpoSelect2").on('change', function() {
        let val = $(this).val()
        if (val == 'otra') {
            $("#otra_uni_input").prop('disabled', false).prop('required', true).val('')
            $("#red_otra_uni").prop('disabled', false).prop('required', true).val($('select option:first').val());
            $("#otra_claveCuerpo").prop('disabled', false).prop('required', true).val('')
            $("#nombre_prodep").prop('disabled', false).val('')
            
            $("#otra_uni").show()
        } else {
            $("#otra_uni_input").prop('disabled', true).prop('required', false).val('')
            $("#red_otra_uni").prop('disabled', true).prop('required', false).val($('select option:first').val());
            $("#otra_claveCuerpo").prop('disabled', true).prop('required', false).val('')
            $("#nombre_prodep").prop('disabled', true).val('')
            $("#otra_uni").hide()
        }
    })
</script>