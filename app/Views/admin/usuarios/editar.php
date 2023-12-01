<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Editar usuario</h4>
            <form class="forms-sample needs-validation" novalidate method="post" action="../update">
                <div class="row">
                    <div class="col-md-4 text-center" id="imagen">
                        <img class="img-fluid" src="<?= empty($usuario['profile_pic']) ? base_url("resources/img/avatar.png") : base_url("resources/img/profiles/" . $usuario["profile_pic"]); ?>" alt="Avatar">
                        <hr>
                        <h3><?= $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'] ?></h3>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="id" hidden value="<?= $usuario['id'] ?>">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" autocomplete="FALSE" value="<?= $usuario['nombre'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="ap_paterno">Apellido paterno</label>
                            <input type="text" class="form-control" name="ap_paterno" placeholder="Apellido paterno" value="<?= $usuario['ap_paterno'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="ap_materno">Apellido materno</label>
                            <input type="text" class="form-control" name="ap_materno" placeholder="Apellido materno" value="<?= $usuario['ap_materno'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo electrónico (acceso al sistema)</label>
                            <input type="email" class="form-control" name="correo" placeholder="Correo electrónico" value="<?= $usuario['correo'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="correo_institucional">Correo electrónico institucional</label>
                            <input type="email" class="form-control" name="correo_institucional" placeholder="Correo electrónico" autocomplete="off" value="<?= $usuario['correo_institucional'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <p class="text-warning">Si deseas cambiar la contraseña del usuario, escribela en el apartado de abajo, de caso de no ser asi, dejelo tal cual esta. Mínimo 8 caracteres (no se aceptan espacios)</p>
                            <input type="password" name="password" id="password" value="" class="form-control" minlength="8">
                        </div>
                        <!--
                <div class="form-group">
                    <label>Foto de perfil</label>
                    <input type="file" id="profile_pic" name="profile_pic" required accept=".jpg,.pdf,.png,.jpeg" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Subir">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Seleccione una archivo</button>
                        </span>
                    </div>
                </div>
                -->
                        <div class="form-group">
                            <label for="exampleSelectGender">Sexo</label>
                            <select class="form-control" name="sexo" required>
                                <option <?= $usuario['sexo'] == null ? 'selected disabled value="" ' : ''  ?>>Seleccione una opcion</option>
                                <option <?= $usuario['sexo'] == '1' ? 'selected value="1" ' : ''  ?>>Hombre</option>
                                <option <?= $usuario['sexo'] == '0' ? 'selected value="0" ' : ''  ?>>Mujer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-info btn-block">Guardar cambios</button>
                <a href="../lista" class="btn btn-danger btn-block">Regresar</a>
            </form>
        </div>
    </div>
</div>

<style>
    img {
        border-radius: 50%;
    }

    .img-fluid {
        width: 20rem !important;
        height: 20rem !important;
    }

    #imagen {
        display: block;
        align-items: center;
    }
</style>

<script>
    $("#password").on('keyup', function(e) {
        if (e.keyCode == 32) {
            $("#password").val('')
        } else {
            var txt = $("#password").val()
            if (txt.length > 0) {
                $("#password").prop('required', true)
            } else {
                $("#password").prop('required', false)
            }
        }

    });
</script>