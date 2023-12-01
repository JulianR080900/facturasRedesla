<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de moderadores</h4>
                <hr>
                <h5>Los campos <label class="text-danger">requeridos</label> son necesarios para aceptar los movimientos</h5>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_moderador">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Clave</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Contacto</i></th>
                                <th class="centered">Editar</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="dt_moderador">

                        </tbody>
                    </table>
                </div>
                <br>
                <a href="./agregar" class="btn btn-success btn-block">Agregar miembro</a>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
</script>
<script>
        $(document).on('click', '.eliminarmoderador', function(e) {
        var id = $(this).data('id')

        Swal.fire({
            title: '¿Estas seguro que desea eliminar el moderador?',
            html: '<p style="color:red">Esta accion NO es reversible</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminalo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "./eliminar",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if(data == 'empty'){
                            Swal.fire(
                            'Warning!',
                            'El usuario que intenta borrar no existe. Si es un error, contacte a sistemas',
                            'error'
                            ) 
                        }else if(data == 'error'){
                            Swal.fire(
                            'Lo sentimos!',
                            'Ha ocurrido un error al eliminar. Contacte a sistemas',
                            'error'
                            )
                        }else if(data == 'success'){
                            Swal.fire(
                                'ÉXITO',
                                'Se ha eliminado el usuario correctamente.',
                                'success'
                            )
                        }
                        initDataTable()
                    },
                });

            }
        });
    });
    </script>
<script src="<?= base_url('resources/admin/datatables/congresos/moderadores.js') ?>"></script>