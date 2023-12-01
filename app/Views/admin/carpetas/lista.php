<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de carpetas</h4>
                <hr>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_carpetas">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Clave del Cuerpo</th>
                                <th class="centered">Red</th>
                                <th class="centered">Año</th>
                                <th class="centered">Envios</th>
                                <th class="centered">Recibidos</th>
                                <th class="centered">Editar</th>
                                
                            </tr>
                        </thead>
                        <tbody id="dt_carpetas">

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/carpetas.js') ?>"></script>