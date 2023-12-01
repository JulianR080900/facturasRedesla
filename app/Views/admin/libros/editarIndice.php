<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-uppercase">Editar indice</h4>
            </div>
            <div class="card-body">
                <form action="../update" method="post" enctype="multipart/form-data">
                    <h3>Información del capítulo</h3>
                    <hr>
                    <label for="">Numero de capitulo <span class="text-danger">*</span></label>
                    <input type="number" name="capitulo" id="" class="form-control" value="<?= $capitulo['capitulo'] ?>" required>

                    <label for="">Nombre del capítulo <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" id="" class="form-control" value="<?= $capitulo['nombre_capitulo'] ?>" required>

                    <label for="">Páginas <span class="text-danger">*</span></label>
                    <input type="text" name="paginas" id="" class="form-control" value="<?= $capitulo['paginas'] ?>" required>

                    <label for="">DOI</label>
                    <input type="text" name="doi" id="doi" class="form-control" value="<?= $capitulo['doi'] ?>">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="check_doi" data-val='doi' onchange="check_na(event);">
                        <label class="form-check-label" for="check_doi">
                            Este capítulo no tiene DOI.
                        </label>
                    </div>

                    <span for="">Archivo <span class="text-danger">*</span></span><span class="text-warning">Si no se sube un archivo, el archivo actual quedara intacto.</span>
                    <input type="file" name="archivo" id="archivo" class="form-control" accept="application/pdf">
                    <br>
                    <h3>Autores</h3>
                    <hr>
                    <span for="">Primer autor</span>
                    <select class="selectPrimerAutor form-control" name="autor_1" id="autor_1" style="width:100%" required>
                        <option value="" selected disabled>Selecciona al primer autor</option>
                        <?php
                        foreach ($usuarios as $u) {
                            $nombre = empty($u['ap_materno']) ? $u['nombre'] . ' ' . $u['ap_paterno'] : $u['nombre'] . ' ' . $u['ap_paterno'] . ' ' . $u['ap_materno'];
                        ?>
                            <option value="<?= $nombre ?>" <?= $capitulo['autor_1'] == $nombre ? 'selected' : '';  ?>><?= $nombre ?></option>
                        <?php
                        }
                        ?>
                        <option value="otro">Otro autor</option>
                    </select>
                    <input type="text" name="autor_1_otro" id="otro_primer_autor" placeholder="Escriba el nombre del primer autor" class="form-control">




                    <label for="">Segundo autor</label>
                    <p class="text-warning">Si no es requerido deje el campo vacio</p>
                    <select class="selectSegundoAutor form-control" name="autor_2" id="autor_2" style="width:100%">
                        <option value="" selected disabled>Selecciona al segundo autor</option>
                        <?php
                        foreach ($usuarios as $u) {
                            $nombre = empty($u['ap_materno']) ? $u['nombre'] . ' ' . $u['ap_paterno'] : $u['nombre'] . ' ' . $u['ap_paterno'] . ' ' . $u['ap_materno'];
                        ?>
                            <option value="<?= $nombre ?>" <?= $capitulo['autor_2'] == $nombre ? 'selected' : '';  ?>><?= $nombre ?></option>
                        <?php
                        }
                        ?>
                        <option value="otro">Otro autor</option>
                    </select>
                    <input type="text" name="autor_2_otro" id="otro_segundo_autor" placeholder="Escriba el nombre del segundo autor" class="form-control">







                    <label for="">Tercer autor</label>
                    <p class="text-warning">Si no es requerido deje el campo vacio</p>
                    <select class="selectTercerAutor form-control" name="autor_3" id="autor_3" style="width:100%">
                        <option value="" selected disabled>Selecciona al tercer autor</option>
                        <?php
                        foreach ($usuarios as $u) {
                            $nombre = empty($u['ap_materno']) ? $u['nombre'] . ' ' . $u['ap_paterno'] : $u['nombre'] . ' ' . $u['ap_paterno'] . ' ' . $u['ap_materno'];
                        ?>
                            <option value="<?= $nombre ?>" <?= $capitulo['autor_3'] == $nombre ? 'selected' : '';  ?>><?= $nombre ?></option>
                        <?php
                        }
                        ?>
                        <option value="otro">Otro autor</option>
                    </select>
                    <input type="text" name="autor_3_otro" id="otro_tercer_autor" placeholder="Escriba el nombre del tercer autor" class="form-control">







                    <label for="">Cuarto autor</label>
                    <p class="text-warning">Si no es requerido deje el campo vacio</p>
                    <select class="selectCuartoAutor form-control" name="autor_4" id="autor_4" style="width:100%">
                        <option value="" selected disabled>Selecciona al cuarto autor</option>
                        <?php
                        foreach ($usuarios as $u) {
                            $nombre = empty($u['ap_materno']) ? $u['nombre'] . ' ' . $u['ap_paterno'] : $u['nombre'] . ' ' . $u['ap_paterno'] . ' ' . $u['ap_materno'];
                        ?>
                            <option value="<?= $nombre ?>" <?= $capitulo['autor_4'] == $nombre ? 'selected' : '';  ?>><?= $nombre ?></option>
                        <?php
                        }
                        ?>
                        <option value="otro">Otro autor</option>
                    </select>
                    <input type="text" name="autor_4_otro" id="otro_cuarto_autor" placeholder="Escriba el nombre del cuarto autor" class="form-control">
                    <hr>
                    <input type="text" name="id" value="<?= $capitulo['id'] ?>" hidden>
                    <button type="submit" class="btn btn-block btn-info" id="guardar">Guradar cambios</button>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>

<script>
    if ($(".selectPrimerAutor").length) {
        $(".selectPrimerAutor").select2();
    }
    if ($(".selectSegundoAutor").length) {
        $(".selectSegundoAutor").select2();
    }
    if ($(".selectTercerAutor").length) {
        $(".selectTercerAutor").select2();
    }
    if ($(".selectCuartoAutor").length) {
        $(".selectCuartoAutor").select2();
    }



    $(document).ready(function() {
        $("#otro_primer_autor").hide();
        $("#otro_segundo_autor").hide();
        $("#otro_tercer_autor").hide();
        $("#otro_cuarto_autor").hide();
    })

    $("#autor_1").on('change', function() {
        var autor1 = $("#autor_1 option:selected").val();

        if (autor1 == 'otro') {
            $(".selectPrimerAutor").prop('required', false);
            $("#autor_1").hide();
            $("#otro_primer_autor").prop('required', true).show();
        } else {
            $(".selectPrimerAutor").prop('required', true);
            $("#autor_1").show();
            $("#otro_primer_autor").prop('required', false).hide();
        }
    })

    $("#autor_2").on('change', function() {
        var autor2 = $("#autor_2 option:selected").val();

        if (autor2 == 'otro') {
            $(".selectSegundoAutor").prop('required', false);
            $("#autor_2").hide();
            $("#otro_segundo_autor").prop('required', true).show();
        } else {
            $(".selectSegundoAutor").prop('required', true);
            $("#autor_2").show();
            $("#otro_segundo_autor").prop('required', false).hide();
        }
    })

    $("#autor_3").on('change', function() {
        var autor3 = $("#autor_3 option:selected").val();

        if (autor3 == 'otro') {
            $(".selectTercerAutor").prop('required', false);
            $("#autor_3").hide();
            $("#otro_tercer_autor").prop('required', true).show();
        } else {
            $(".selectTercerAutor").prop('required', true);
            $("#autor_3").show();
            $("#otro_tercer_autor").prop('required', false).hide();
        }
    })

    $("#autor_4").on('change', function() {
        var autor4 = $("#autor_4 option:selected").val();

        if (autor4 == 'otro') {
            $(".selectCuartoAutor").prop('required', false);
            $("#autor_4").hide();
            $("#otro_cuarto_autor").prop('required', true).show();
        } else {
            $(".selectCuartoAutor").prop('required', true);
            $("#autor_4").show();
            $("#otro_cuarto_autor").prop('required', false).hide();
        }
    })

    function check_na(e) {
        let id = e.target.dataset.val;
        let checkbox = $("#check_" + id)[0].checked;

        if (checkbox) {
            $("#" + id).val('NA').prop('readonly', true);
        } else {
            $("#" + id).val('').prop('readonly', false);
        }
        document.getElementById(id).dispatchEvent(keyupEvent);
    }
</script>