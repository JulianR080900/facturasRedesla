<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
            <h1>Editar datos del enlace</h1>
            </div>
            <div class="card-body">
    <form action="../update" method="post">
    <input type="text" name="id" hidden value="<?=$enlaces_congresos['id'] ?>">
    <input type="text" name="id_usuario" hidden value="<?=$id_usuario?>">
    <label for="">Clave</label>
    <input type="text" name="clave" id="clave" class="form-control" value="<?=$enlaces_congresos['clave'] ?>" >
    <label for="">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="<?=$enlaces_congresos['nombre'] ?>">
    <label for="">Contacto</label>
    <p class='text-warning'>Si edita el contacto, la contraseña tambien cambiará por el nuevo contacto del enlace.</p>
    <input type="numbre" name="contacto" id="contacto" class="form-control" value="<?=$enlaces_congresos['contacto'] ?>">
    <hr>
    <button type="submit" class="btn btn-success btn-block submitUpdate">Actualizar <i class="mdi mdi-arrow-right-drop-circle"></i></button>
    <a href="<?= base_url('admin/congresos/enlaces/lista') ?>" class="btn btn-danger btn-block btn-icon-text"><i class="mdi mdi-arrow-left-drop-circle btn-icon-append"></i> Regresar</a>

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
