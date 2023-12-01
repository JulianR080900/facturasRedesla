<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de movimientos</h4>
                </p>
                <div class="row">
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Monto del proyecto</h5>
                                <div class="row">
                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $datos_generales['total_proyecto'] ?></h2>
                                        </div>
                                        <h6 class="text-muted font-weight-normal">Ingresado el <?= $datos_generales['fecha_registro'] ?></h6>
                                    </div>
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-cart-plus text-primary ml-auto"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Adeudo</h5>
                                <div class="row">
                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0">$<?= $datos_generales['restante'] ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-wallet text-danger ml-auto"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Cantidad de movimientos</h5>
                                <div class="row">
                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= count($movimientos) ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-format-list-bulleted-type text-success ml-auto"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2>Porcentaje de la deuda</h2>
                <div class="progress">
                    <div class="progress-bar bg-<?= $datos_generales['porcentaje'] == 100 ? 'success':'warning' ?>" role="progressbar" style="width: <?= $datos_generales['porcentaje'] ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <br>
                <div class="text-center"><?= $datos_generales['porcentaje'] == 100 ? 'Completado' : $datos_generales['porcentaje'].'% completado' ?></div>

                <hr>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped" id="dt_movimientos_pago">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Movimiento </th>
                                    <th> Comprobante </th>
                                    <th> Estado </th>
                                    <th> Facturado </th>
                                    <th> Fecha de comprobante </th>
                                    <th> Fecha de registro </th>
                                    <th> Editar </th>
                                    <th> Eliminar </th>
                                </tr>
                            </thead>
                            <tbody id="tbody_movimientos_pago">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

<script>
    var base_url = '<?= base_url() ?>';
</script>
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
                window.location.href = base_url+'/admin/finanzas/movimientos/rechazar/'+id
            }
        });
    });
</script>
<script src="<?= base_url('resources/admin/datatables/movimientosPago.js') ?>"></script>