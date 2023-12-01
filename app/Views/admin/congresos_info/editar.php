<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
            <h1>Editar Congreso</h1>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/generalUpdateAdmin/congresos_info') ?>" method="post">
    
    <input type="text" name="id" hidden value="<?= $congreso_info['id'] ?>">
    <label for="">Congreso</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $congreso_info['nombre'] ?>" >
    <label for="">Red</label>
    <select class="selectRed form-control" name="red" id="red" style="width:100%" required>
                    <option value="" selected disabled>Selecciona la red</option>
                    <?php
                    foreach($redes as $r){
                        ?>
                        <option value="<?= $r['nombre_red'] ?>" <?= $congreso_info['red'] == $r['nombre_red'] ? 'selected':'' ?> ><?= $r['nombre_red'] ?></option>
                        <?php
                    }
                    ?>

    </select>
    <label for="">Sede</label>
    <input type="text" name="sede" id="sede" class="form-control" value="<?= $congreso_info['sede'] ?>">
    <label for="">Fechas</label>
    <p class="text-warning">Ejemplo: 25 y 26 de mayo de 2023</p>
    <input type="text" name="fechas" id="fechas" class="form-control" value="<?= $congreso_info['fechas'] ?>">
    <label for="">Año</label>
    <input type="number" name="anio" id="anio" class="form-control" min = "<?= date('Y') ?>" max = "<?= date('Y')+1?>"  onKeyPress="if(this.value.length==4) return false;" value="<?= $congreso_info['anio'] ?>">
    <hr>
    <button type="submit" class="btn btn-success btn-block submitUpdate">Actualizar <i class="mdi mdi-arrow-right-drop-circle"></i></button>
    <a href="<?= base_url('admin/congresos_info/lista') ?>" class="btn btn-danger btn-block btn-icon-text"><i class="mdi mdi-arrow-left-drop-circle btn-icon-append"></i> Regresar</a>

</form>

            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>

<script>
    if ($(".selectRed").length) {
        $(".selectRed").select2();
    }
</script>
<style>
    label {
        padding-top: 1rem;
    }
</style>
