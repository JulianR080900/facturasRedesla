<div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-uppercase">Entrevistas de la <?= $nombre_uni ?></h4>
                    </p>
                    <div class="table-responsive">
                        <table class="table" id="dt_equiposReleg">
                            <thead>
                                <tr>
                                    <th class="centered">ID entrevista</th>
                                    <th class="centered">Estado</th>
                                    <th class="centered">Nombre de la entrevistadora</th>
                                    <th class="centered">Institución</th>
                                    <th class="centered">Ver entrevista</th>
                                    <th class="centered">Ver bitácora</th>
                                    <th class="centered">Editado</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_equiposReleg">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    var base_url = '<?= base_url() ?>';
    var claveCuerpo = '<?= $claveCuerpo ?>';
    </script>
    <script src="<?= base_url('resources/admin/datatables/Nuria/equipoReleg.js') ?>"></script>