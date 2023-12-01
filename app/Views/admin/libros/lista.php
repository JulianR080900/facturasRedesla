<style>
    .table th img, .jsgrid .jsgrid-table th img, .table td img, .jsgrid .jsgrid-table td img{
        width: 5rem !important;
        height: 7rem !important;
        border-radius: 0px !important;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de libros</h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_libros">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Portada</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">ISBN</th>
                                <th class="centered">Editorial</th>
                                <th class="centered">Año</th>
                                <th class="centered">Formato</th>
                                <th class="centered">Red</th>
                                <th class="centered">Enlace</th>
                                <th class="centered">Indices</th>
                                <th class="centered">Editar</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_libros">

                        </tbody>
                    </table>
                </div>
                <br>
                <a href="./agregar" class="btn btn-success btn-block">Agregar libro</a>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
</script>
<script>
    $(document).on('click', '.eliminarLibro', function(e) {
        var id = $(this).data('id')

        Swal.fire({
            title: '¿Estas seguro que desea eliminar este libro?',
            html: '<p style="color:red">Esta accion NO es reversible</p><p style="color:gray">Nota: El libro se eliminara junto con sus capítulos y archivos cargados.</p>',
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
                        if (data == 'errorCaps') {
                            Swal.fire(
                                'Lo sentimos!',
                                'Ha ocurrido un error al eliminar los capitulos. Contacte a sistemas',
                                'error'
                            )
                        } else if (data == 'errorLibro') {
                            Swal.fire(
                                'Lo sentimos!',
                                'Ha ocurrido un error al eliminar el libro. Contacte a sistemas',
                                'error'
                            )
                        } else if (data == 'success') {
                            Swal.fire(
                                'Éxito',
                                'Se ha eliminado el libro y sus índices correctamente.',
                                'success'
                            )
                        }
                        initDataTable()
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }
                });

            }
        });
    });
</script>
<script src="<?= base_url('resources/admin/datatables/libros.js') ?>"></script>