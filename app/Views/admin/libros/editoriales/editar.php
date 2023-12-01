<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-uppercase">Editar casa editorial</h4>
            </div>
            <div class="card-body">
                <form action="../update" method="post">
                <label for="">Nombre</label>
                <input type="text" name="nombre" id="" class="form-control" value="<?= $casa['nombre'] ?>" required>
                <label for="">Abreviación</label>
                <input type="text" name="abreviacion" id="" class="form-control" value="<?= $casa['abreviacion'] ?>" required>
                <input type="text" name="id" id="" class="form-control" value="<?= $casa['id'] ?>" hidden>
                <hr>
                <button type="submit" class="btn btn-block btn-info">Guardar cambios</button>
                <a class="btn btn-danger btn-block" href="../lista">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>