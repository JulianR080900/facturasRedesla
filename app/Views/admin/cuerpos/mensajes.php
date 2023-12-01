<h1>Lista de mensajes</h1>
<hr>

<div id="accordion">
    <?php
    foreach ($redes as $r) {
    ?>
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn" data-toggle="collapse" data-target="#collapse<?= $r['id'] ?>" aria-expanded="true" aria-controls="collapseOne">
                        <h2 class="text-uppercase"><?= $r['nombre_red'] ?></h2>
                    </button>
                </h5>
            </div>

            <div id="collapse<?= $r['id'] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <?php
                    foreach ($tipos_registros as $t) {
                    ?>
                        <div id="accordion2">
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn" data-toggle="collapse" data-target="#collapseSubmenu<?= $t['id'] ?>" aria-expanded="true" aria-controls="collapseTwo">
                                            <h4><?= $t['nombre'] ?></h4>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseSubmenu<?= $t['id'] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion2">
                                    <div class="card-body">
                                        <a href="<?= base_url('/admin/cuerpos/verMensaje/'.$t['nombre'].'/'.$r['nombre_red'].'/2023') ?>" class="btn">2023</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>