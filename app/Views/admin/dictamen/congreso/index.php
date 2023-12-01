<div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Cartas de dictamen de publicación Revista</h4>
                    </p>
                    <div class="table-responsive">
                        <table class="table" id="dt_dictamen">
                            <thead>
                                <tr>
                                    <th class="centered">ID</th>
                                    <th class="centered">Red</th>
                                    <th class="centered">Institución</th>
                                    <th class="centered">ID articulo</th>
                                    <th class="centered">Nombre del articulo</th>
                                    <th class="centered">ISBN</th>
                                    <th class="centered">Descargar carta</th>
                                    <th class="centered">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_dictamen">

                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <a href="./agregar" class="btn btn-block btn-success">Agregar carta</a>
                </div>
            </div>
        </div>
    </div>

    

    
    <script>const base_url = '<?= base_url() ?>';</script>

    <script>
        $(document).on('click', '.eliminar', function(e) {
        var id = $(this).data('id')

        Swal.fire({
            title: '¿Estas seguro que desea eliminar este registro?',
            footer: 'ID del registro a eliminar: '+id,
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
                        if(data == 'error'){
                            Swal.fire(
                            'Lo sentimos!',
                            'Ha ocurrido un error al eliminar. Contacte a sistemas',
                            'error'
                            )
                        }else if(data == 'success'){
                            Swal.fire(
                                'ÉXITO',
                                'Se ha eliminado el registro correctamente.',
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
    <script src="<?= base_url('resources/admin/datatables/cartas_dictamen.js') ?>"></script>