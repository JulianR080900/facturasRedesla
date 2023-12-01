<div class="content">

    <div class="col-md-12">

        <div class="card card-body-congresos">

            <div class="card-header card-header-congresos">
                <h3>Editar perfil</h3>
            </div>

            <div class="card-body">

                <form method="post" action="./actualizar" class="needs-validation" novalidate enctype="multipart/form-data">

                    <div class="mb-3 editImageProfile">
                        <?php
                        if ($usuario["profile_pic"] !== NULL) {
                        ?>
                            <img src="<?php echo base_url("resources/img/profiles/" . $usuario["profile_pic"]) ?>" alt="" id="imageUser">
                        <?php
                        } else {
                        ?>
                            <img src="<?php echo base_url("resources/img/svg/avatar.png") ?>" alt="" id="imageUser">
                        <?php
                        }
                        ?>
                    </div>
                    <div class="mb-3 editImageProfile">
                        <?= $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'] ?>
                    </div>
                    <div class="mb-3 editImageProfile">
                        <input type="file" name="profile_pic" id="profile_pic" accept=".png">
                        <span id="btnChoosePic"><i class="fa-solid fa-cloud-arrow-up"></i> Cambiar foto de perfil</span>
                    </div>

                    <div class="mb-3">
                        <h3 class="text-danger text-center">Su nombre no está habilitado para ser editado, favor de contactar al equipo si requiere una modificación.</h3>
                    </div>
                    <!-- <div class="mb-3">

                        <label for="nombre">Nombre</label>

                        <input type="text" name="nombre" id="nombre" class="form-control ol" value="<?php //echo $usuario["nombre"] ?>" autofocus required><br>

                        <div class="invalid-feedback">

                            Ingrese el nombre.

                        </div>

                    </div>

                    <div class="mb-3">

                        <label for="ap_paterno">Apellido paterno</label>

                        <input type="text" name="ap_paterno" id="ap_paterno" class="form-control ol" value="<?php //echo $usuario["ap_paterno"] ?>" required><br>

                        <div class="invalid-feedback">

                            Ingrese el apellido paterno.

                        </div>

                    </div>

                    <div class="mb-3">

                        <label for="ap_paterno">Apellido materno</label>

                        <input type="text" name="ap_materno" id="ap_materno" class="form-control ol" value="<?php //echo $usuario["ap_materno"] ?>" required><br>

                        <div class="invalid-feedback">

                            Ingrese el apellido materno.

                        </div>

                    </div> -->

                    <div class="mb-3">

                        <label for="correo">Correo personal (Acceso a la plataforma) <i class="fas fa-info-circle" style="color: #ffbb33; font-size: 15px" data-toggle="popover" data-content="Si cambia el correo, la contraseña quedara como la que tiene actualmente, por lo que recomendamos actualizar su contraseña a una personal, esto lo podra hacer desde el menú lateral"></i></label>

                        <input type="email" name="correo" id="correo" class="form-control oe" value="<?php echo $usuario["correo"] ?>" required><br>

                        <div class="invalid-feedback">

                            Ingrese un correo electrónico personal.

                        </div>

                    </div>

                    <div class="mb-3">

                        <label for="correo">Correo institucional</label>

                        <input type="email" required name="correo_institucional" id="correo_institucional" class="form-control oe" value="<?php echo $usuario["correo_institucional"] ?>"><br>

                        <div class="invalid-feedback">

                            Ingrese un correo electrónico institucional.

                        </div>

                    </div>

                    <h3>Cambiar contraseña</h3>
                    <p>
                        <small class="text-danger"> (Si no desea cambiar su contraseña, deje los campos vacíos)</small>
                    </p>
                    <div class="input-group mb-3">
                        <label for="password">Contraseña actual</label>
                        <div class="input-group show_hide_password">
                            <input type="password" name="act_password" id="act_password" minlength="8" class="form-control oe password-input">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary toggle-password"><i class="fa fa-eye-slash"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="password">Nueva contraseña <small class="text-danger"> (Mínimo 8 carácteres)</small></label>
                        <div class="input-group show_hide_password">
                            <input type="password" name="password" id="password" minlength="8" class="form-control oe password-input">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary toggle-password"><i class="fa fa-eye-slash"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <label for="password">Confirmar nueva contraseña</label>
                        <div class="input-group show_hide_password">
                            <input type="password" name="conf_password" id="conf_password" minlength="8" class="form-control oe password-input">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary toggle-password"><i class="fa fa-eye-slash"></i></button>
                            </div>
                        </div>
                    </div>

                    <p style="font-size: 12px;">* Si desea editar su número de teléfono, hacerlo desde el módulo de miembros</p>
                    <input type="text" name="id" hidden value="<?= $usuario['id'] ?>">

                    <button type="submit" class="btn btn-block bg-<?= $_SESSION['red'] ?>">Actualizar perfil <i class="fa-solid fa-caret-right"></i></button>

                    <a href="./inicio" class="btn btn-block btn-danger"><i class="fa-solid fa-caret-left"></i> Regresar</a>

                </form>

            </div>

        </div>

    </div>

    <br>

    <br><br>

</div>


<script>
    $("#btnChoosePic").on('click', function(e) {
        e.preventDefault()
        $("#profile_pic").click()
    })

    $("#profile_pic").on('change', function(e) {
        e.preventDefault();
        const image = this.files[0];
        if (image.size > 2000000) {
            $("#profile_pic").val('')
            Swal.fire({
                icon: "warning",
                title: "Archivo demasiado pesado",
                html: "Recuerde que el tamaño máximo es de <b>2MB</b>",
            });
            return;
        }
        var imageURL = URL.createObjectURL(image);

        // Actualizar el atributo src de la etiqueta <img>
        $('#imageUser').attr('src', imageURL);
    })

    $(".toggle-password").on('click', function(event) {
        event.preventDefault();

        var parentDiv = $(this).closest(".show_hide_password"); // Encuentra el contenedor más cercano
        var passwordInput = parentDiv.find(".password-input");
        var eyeIcon = $(this).find("i");

        if (passwordInput.attr("type") == "text") {
            passwordInput.attr('type', 'password');
            eyeIcon.addClass("fa-eye");
            eyeIcon.removeClass("fa-eye-slash");
        } else if (passwordInput.attr("type") == "password") {
            passwordInput.attr('type', 'text');
            eyeIcon.removeClass("fa-eye");
            eyeIcon.addClass("fa-eye-slash");
        }
    });


    $("#act_password,#password,#conf_password").on('keyup', function() {

        let act_password = $("#act_password").val();
        let password = $("#password");
        let conf_password = $("#conf_password").val()

        if (act_password != '' || password != '' || conf_password != '') {
            $("#conf_password").prop('required', true);
            $("#password").prop('required', true);
            $("#act_password").prop('required', true);
        } else {
            $("#conf_password").prop('required', false);
            $("#password").prop('required', false);
            $("#act_password").prop('required', false);
        }
    })
</script>





<script src="<?= base_url('resources/js/form-validation/index.js') ?>"></script>
<script src="<?= base_url('resources/js/form-validation/inputs.js') ?>"></script>