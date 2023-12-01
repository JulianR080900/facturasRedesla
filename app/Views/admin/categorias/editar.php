<h1>Editar categoría</h1>
<form action="update" method="post">
    <label for="">Nombre de la categoría</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $categoria['nombre'] ?>" required>
    <label for="">Descripción</label>
    <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="form-control" required><?= $categoria['descripcion'] ?></textarea>
    <input type="text" id="id" hidden value="<?= $categoria['id'] ?>">
    <label for="">Color de la categoría</label>
    <input type="color" name="" id="color" class="form-control" value="#<?= $categoria['color'] ?>" required>
    <hr>
    <button type="submit" class="btn btn-success btn-block submitUpdate" value="1">Actualizar y activar categoría <i class="mdi mdi-arrow-right-drop-circle"></i></button>
    <button type="submit" class="btn btn-info btn-block submitUpdate" value="0">Actualizar y no activar la categoría <i class="mdi mdi-arrow-right-drop-circle"></i></button>
    <a href="<?= base_url('admin/categorias/lista') ?>" class="btn btn-danger btn-block btn-icon-text"><i class="mdi mdi-arrow-left-drop-circle btn-icon-append"></i> Regresar</a>

</form>

<style>
    label {
        padding-top: 1rem;
    }
</style>

<script>
    $(".submitUpdate").on('click', function(e) {
        e.preventDefault();
        var activo = $(this).val();
        var nombre = $("#nombre").val();
        var descripcion = $("#descripcion").val();
        var id = $("#id").val();
        var color = $("#color").val();
        color = color.substring(1);
        if (color == '000000') {
            Swal.fire({
                title: '<label style="color:#545454">Cuidado</label>',
                icon: 'warning',
                html: '<label style="color:#545454">Seleccione un color válido</label>',
            })
            return
        }

        $.ajax({
            url: '<?= base_url('admin/categorias/update') ?>',
            type: "post",
            data: {
                'activo': activo,
                'nombre': nombre,
                'descripcion': descripcion,
                'id': id,
                'color': color
            },
            success: function(response) {
                if (response == 'success') {
                    Swal.fire({
                        title: '<label style="color:#545454">Éxito</label>',
                        icon: 'success',
                        html: '<label style="color:#545454">Acción realizada correctamente</label>',
                    }).then(function() {
                        window.location.href = '<?= base_url('admin/categorias/lista') ?>';
                    });
                } else {
                    Swal.fire({
                        title: '<label style="color:#545454">Lo sentimos</label>',
                        icon: 'error',
                        html: '<label style="color:#545454">Ha ocurrido un error, contacte a sistemas</label>',
                    }).then(function() {
                        window.location.href = '<?= base_url('admin/categorias/lista') ?>';
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                $("#submit").prop('disabled', false);
            }
        });

    });
</script>