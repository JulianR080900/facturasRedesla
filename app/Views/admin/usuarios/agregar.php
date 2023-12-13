<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Agregar usuario</h4>
            <form class="forms-sample needs-validation" novalidate method="post" action="./submitUsuario" autocomplete="off">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre" autocomplete="FALSE" required>
                        </div>
                        <div class="form-group">
                            <label for="ap_paterno">Apellido paterno</label>
                            <input type="text" class="form-control" name="ap_paterno" placeholder="Apellido paterno" required>
                        </div>
                        <div class="form-group">
                            <label for="ap_materno">Apellido materno</label>
                            <input type="text" class="form-control" name="ap_materno" placeholder="Apellido materno" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectGender">Sexo</label>
                            <select class="form-control" name="sexo" required>
                                <option selected disabled value="">Seleccione una opcion</option>
                                <option value="1">Hombre</option>
                                <option value="0">Mujer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo electrónico (acceso al sistema)</label>
                            <input type="email" class="form-control" name="correo" placeholder="Correo electrónico" autocomplete="FALSE" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <p class="text-warning">Si deseas establecer una contraseña personalizada escribala en el espacio de abajo. Si desea establecer una contraseña por defecto (correo de acceso) deje el campo en blanco (8 carácteres mínimo)</p>
                            <input type="password" name="password" id="password" value="" class="form-control" minlength="8">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-info btn-block">Guardar cambios</button>
                <a href="./lista" class="btn btn-danger btn-block">Regresar</a>
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