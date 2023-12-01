<style>
    iframe{
        width: 100%;
        height: 50rem;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de marcajes solicitados</h4>
                <h5 class='text-warning'>Marcajes pendientes: <?= $c_marcajes_pendientes ?></h5>
                <div class="table-responsive">
                    <table class="table" id="dt_marcajes">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Equipo</th>
                                <th class="centered">Obra</th>
                                <th class="centered">Red</th>
                                <th class="centered">Año</th>
                                <th class="centered">Atendido</th>
                                <th class="centered">Archivo</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_inv">

                        </tbody>
                    </table>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalVerMarcaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleMarcaje"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" id="iframeMarcaje"></iframe>
                <input type="hidden" id="claveCuerpo">
                <input type="hidden" id="tipo">
                <input type="hidden" id="red">
                <input type="hidden" id="anio">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rechazarMarcaje">Rechazar marcaje</button>
                <button type="button" class="btn btn-success aceptarMarcaje">Aceptar marcaje</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('resources/admin/datatables/investigaciones/marcajes.js') ?>"></script>