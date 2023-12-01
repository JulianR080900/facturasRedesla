<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Vista y descarga de capitulos Releg</h4>
                <div class="table-responsive">
                    <table class="table" id="descarga">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Clave</th>
                                <th class = "centered">Universidad</th>
                                <th class="centered">Descarga</th>
                                
                            </tr>
                        </thead>
                        <tbody id="descarga">

                        </tbody>
                    </table>
                </div>
                <br>
                <a href="./descargar" class="btn btn-success btn-block">Descargar archivos en orden alfabetico</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Autores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('resources/admin/datatables/Nuria/descargaReleg.js') ?>"></script>