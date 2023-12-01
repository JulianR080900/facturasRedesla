<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="text-uppercase">Agregar Mesa</h4>
            </div>
            <div class="card-body">
                <form action="./insert" method="post">
                <label for="">Clave</label>
                <input type="text" name="clave" id="clave" class="form-control" required>
                <label for="">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required >
                <hr>
                <button type="submit" class="btn btn-success btn-block">Agregar mesa<i class="mdi mdi-arrow-right-drop-circle"></i></button>
                <a href="<?= base_url('admin/congresos/mesas/lista') ?>" class="btn btn-danger btn-block btn-icon-text"><i class="mdi mdi-arrow-left-drop-circle btn-icon-append"></i> Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    label {
        padding-top: 1rem;
    }
</style>


