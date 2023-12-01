<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de movimientos</h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_proyectos">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">ID del pago</th>
                                <th class="centered">Cuerpo académico</th>
                                <th class="centered">Movimiento</th>
                                <th class="centered">Comprobante</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Facturado</th>
                                <th class="centered">Fecha del comprobante</th>
                                <th class="centered">Fecha de registro</th>
                                <th class="centered">Editar</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_proyectos">

                        </tbody>
                    </table>
                </div>
               
            </div>
        </div>
    </div>
     <!--del div de reultado es solo para ver resultado, se eliminara mas adelante-->
     <div id="result-container"></div>
</div>

<div class="modal fade" id="modalMonto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar monto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class='text-danger'>X</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAct">
                    <div class="form-group">
                        <label for="">Escribe el nuevo monto del movimiento seleccionado</label>
                        <input type="number" name="" id="monto" class="form-control">
                        <input type="hidden" name="" id="id_mov">
                    </div>

                    <div class='form-group'>
                        <button class="btn btn-success btn-block" id="btnSubmitMonto">Guardar cambios</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<script> var base_url = '<?= base_url() ?>'; </script>
<script>
        $(document).on('click', '.rechazarPago', function(e) {
        var id = $(this).data('id')
        if(id == ''){
            return;
        }
        Swal.fire({
            title: '¿Estas seguro que desea rechazar el movimiento?',
            html: 'Las constancias y proyectos que se hayan ingresado por el pago completo del proyecto al que corresponde el movimiento seran removidos',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Rechazar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'rechazar/'+id
            }
        });
    });
</script>

<script src="<?= base_url('resources/admin/datatables/movimientos.js') ?>"></script>