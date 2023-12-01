<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Listado de categorizaciones de la  <b class="text-info"><?= strtoupper($universidad) ?></b> </h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_categorizacion">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Categoria</th>
                                <th class="centered">Codigo en vivo</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_categorizacion">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
var base_url = '<?= base_url() ?>';
let claveCuerpo = '<?= $claveCuerpo ?>';
</script>
<script>
</script>
<script src="<?= base_url('resources/admin/datatables/Nuria/categorizacion.js') ?>"></script>