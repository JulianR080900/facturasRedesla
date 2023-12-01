<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-uppercase">Editar miembro</h4>
            </div>
            <div class="card-body">
                <form action="../updateMiembro" method="post">
                    <div class="row">
                        <div class="col-md-4 text-center" id="imagen">
                            <img class="img-fluid" src="<?= empty($usuario['profile_pic']) ? base_url("resources/img/avatar.png") : base_url("resources/img/profiles/" . $usuario["profile_pic"]); ?>" alt="Avatar">
                            <hr>
                            <h3><?= $miembro['nombre'].' '.$miembro['apaterno'].' '.$miembro['amaterno'] ?></h3>
                            <h4><?= $usuario['grado_academico'] ?></h4>
                            <h6>en</h6>
                            <h4><?= $miembro['especialidad'] ?></h4>
                        </div>
                        <div class="col-md-8">
                            <h3>Información personal</h3>
                            <hr>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="" value="<?= $miembro['nombre'] ?>" class="form-control" required>

                            <label for="apaterno">Apellido paterno</label>
                            <input type="text" name="apaterno" id="" value="<?= $miembro['apaterno'] ?>" class="form-control" required>

                            <label for="amaterno">Apellido materno</label>
                            <input type="text" name="amaterno" id="" value="<?= $miembro['amaterno'] ?>" class="form-control" required>

                            <label for="selectGrado">Grado académico</label>
                            <select class="selectGrado form-control" name="grado" id="grado" style="width:100%">
                                <option value="" selected disabled>Selecciona el grado académico del miembro</option>
                                <?php
                                foreach ($grados_academicos as $g) {
                                ?>
                                    <option value="<?= $g['id'] ?>" <?= $g['id'] == $miembro['grado'] ? 'selected' : '';  ?>><?= $g['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>

                            <label for="especialidad">Especialidad</label>
                            <input type="text" name="especialidad" id="" value="<?= $miembro['especialidad'] ?>" class="form-control" required>

                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="" value="<?= $miembro['telefono'] ?>" class="form-control" required>

                            <label for="selectSNI">Nivel de SNI</label>
                            <select class="selectSNI form-control" name="nivelSNI" id="nivelSNI" style="width:100%">
                                <option value="" selected disabled>Selecciona el nivel de SNI del miembro</option>
                                <?php
                                foreach ($sni as $s) {
                                ?>
                                    <option value="<?= $s['id'] ?>" <?= $s['id'] == $miembro['nivelSNI'] ? 'selected' : '';  ?>><?= $s['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>

                            <label for="anoSNI">Año de SNI</label>
                            <input type="number" name="anoSNI" id="anoSNI" value="<?= $miembro['anoSNI'] ?>" class="form-control">
                            <hr>
                            <h3>Accesos</h3>
                            <label for="correo">Correo personal (acceso a la plataforma)</label>
                            <input type="email" name="correo" id="correo" value="<?= $usuario['correo'] ?>" class="form-control" required>

                            <label for="correo_institucional">Correo institucional</label>
                            <input type="email" name="correo_institucional" id="correo_institucional" value="<?= $usuario['correo_institucional'] ?>" class="form-control" required>

                            <label for="password">Contraseña</label>
                            <p class="text-warning">Si deseas cambiar la contraseña del usuario, escribela en el apartado de abajo, de caso de no ser asi, dejelo tal cual esta. Mínimo 8 caracteres (no se aceptan espacios)</p>
                            <input type="text" name="password" id="password" value="" class="form-control" minlength="8">
                            <input type="number" name="id" value="<?= $miembro['id'] ?>" required hidden>
                            <input type="text" name="usuario" value="<?= $miembro['usuario'] ?>" required hidden>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-block btn-info">Guardar información</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>

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
    $(document).ready(function() {

        var selectedSNI = $("#nivelSNI option:selected").val();

        if (selectedSNI != 6) {
            $("#anoSNI").prop('required', true);
        }

    });

    if ($(".selectGrado").length) {
        $(".selectGrado").select2();
    }

    $("#nivelSNI").on('change', function() {
        var selectedSNI = $("#nivelSNI option:selected").val();

        if (selectedSNI != 6) {
            $("#anoSNI").prop('required', true);
        } else {
            $("#anoSNI").prop('required', false);
            $("#anoSNI").val('');
        }
    });

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