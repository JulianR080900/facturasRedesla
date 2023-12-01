
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de participantes</h4>
                <hr>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_participantes">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class='centered'>Clave de gafete</th>
                                <th class='centered'>Nombre</th>
                                <th class="centered">Clave de universidad</th>
                                <th class="centered">ID ponencia</th>
                                <th class="centered">Oyente</th>
                                <th class="centered">Red</th>
                                <th class="centered">Año</th>
                                <th class="centered">Tipo de asistencia</th>
                                <th class="centered">Congreso</th>
                                <th class="centered">Constancia de asistencia</th>
                            </tr>
                        </thead>
                        <tbody id="dt_participantes">

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
<script src="<?= base_url('resources/admin/datatables/congresos/participantes.js') ?>"></script>