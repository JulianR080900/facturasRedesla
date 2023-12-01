<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de facturas</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table" id="dt_facturas">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Clave</th>
                                <th class="centered">Nombre del Proyecto</th>
                                <th class="centered">Tipo</i></th>
                                <th class="centered">Comprobante (s)</th>
                                <th class="centered">Estado</i></th>
                                <th class="centered">Información</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="dt_facturas">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <!--del div de reultado es solo para ver resultado, se eliminara mas adelante-->
        <div id="result-container"></div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
</script>
<script>
    $(document).on('click', '.eliminarFactura', function(e) {
        var id = $(this).data('id')

        Swal.fire({
            title: '¿Estás seguro que deseas eliminar la factura?',
            html: '<p style="color:red">Esta acción NO es reversible</p><p style="color:gray">Nota: Se eliminarán los comprobantes de movimientos al igual que se cambiará el estado de facturado.</p><p>Se eliminara el siguiente ID: ' + id + '</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Elimínalo',
            cancelButtonText: 'Cancelar',
            input: "text",
            inputAttributes: {
            autocapitalize: "off",
            },

        }).then((result) => {
            if (result.isConfirmed) {
                let mensaje = result.value;
                $.ajax({
                    type: "POST",
                    url: "./eliminarFactura",
                    data: {
                        id: id,
                        mensaje: mensaje,
                    },
                    success: function(data) {
                        if(data == 'error'){
                            Swal.fire(
                            'Lo sentimos!',
                            'Ha ocurrido un error al eliminar la factura. Contacte a sistemas',
                            'error'
                            )
                        }else if(data == 'success'){
                            Swal.fire(
                                'ÉXITO',
                                'Se ha eliminado la factura correctamente.',
                                'success'
                            )
                        }else {
                                // Mostrar el resultado en el div con id "result-container"
                             $('#result-container').html(data);
                            }
                        initDataTable()
                    },
                });
            }
        });
    });
</script>

<script src="<?= base_url('resources/admin/datatables/facturasAdmin.js') ?>"></script>