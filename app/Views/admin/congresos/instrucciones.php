<div class="content-wrapper">
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h1>Instrucciones de los proyectos</h1>
    <hr>
    <p>Seleccione la red, el tipo de proyecto y el año para acceder a las instrucciones de ese proyecto</p>
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

                                    <?php
                                    if ($t['nombre'] == 'Congreso' || $t['nombre'] == 'Coloquio' || $t['nombre'] == 'Oyente') {
                                    ?>
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="btn" data-toggle="collapse" data-target="#accordion_<?= $t['nombre'] ?>_<?= $t['id'] ?>" aria-expanded="true" aria-controls="collapseTwo">
                                                    <h4><?= $t['nombre'] ?></h4>
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="accordion_<?= $t['nombre'] ?>_<?= $t['id'] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion2">
                                            <div class="card">
                                                <div class="card-header" id="headingCongreso">
                                                    <h5 class="mb-0">
                                                        <button class="btn" data-toggle="collapse" data-target="#colapseSubmenu<?= $t['nombre'] ?><?= $t['id'] ?>_<?= $t['nombre'] ?>_1" aria-expanded="true" aria-controls="collapseThree">
                                                            <h3>Antes de pago</h3>
                                                        </button>
                                                        <div id="colapseSubmenu<?= $t['nombre'] ?><?= $t['id'] ?>_<?= $t['nombre'] ?>_1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_<?= $t['nombre'] ?>_<?= $t['id'] ?>">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="mb-0">
                                                                        <a class='btn' href="<?= base_url('/admin/congresos/verMensaje/' . $t['nombre'] . '/' . $r['nombre_red'] . '/2022') ?>/antes" class="btn">2022</a>
                                                                        <a class='btn' href="<?= base_url('/admin/congresos/verMensaje/' . $t['nombre'] . '/' . $r['nombre_red'] . '/2023') ?>/antes" class="btn">2023</a>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </h5>
                                                    <h5 class="mb-0">
                                                        <button class="btn" data-toggle="collapse" data-target="#colapseSubmenu<?= $t['nombre'] ?><?= $t['id'] ?>_<?= $t['nombre'] ?>_2" aria-expanded="true" aria-controls="collapseThree">
                                                            <h3>Despues de pago</h3>
                                                        </button>
                                                        <div id="colapseSubmenu<?= $t['nombre'] ?><?= $t['id'] ?>_<?= $t['nombre'] ?>_2" class="collapse" aria-labelledby="headingOne" data-parent="#accordion_<?= $t['nombre'] ?>_<?= $t['id'] ?>">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="mb-0">
                                                                        <a class='btn' href="<?= base_url('/admin/congresos/verMensaje/' . $t['nombre'] . '/' . $r['nombre_red'] . '/2022') ?>/despues" class="btn">2022</a>
                                                                        <a class='btn' href="<?= base_url('/admin/congresos/verMensaje/' . $t['nombre'] . '/' . $r['nombre_red'] . '/2023') ?>/despues" class="btn">2023</a>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="btn" data-toggle="collapse" data-target="#collapseSubmenu<?= $t['id'] ?>" aria-expanded="true" aria-controls="collapseTwo">
                                                    <h4><?= $t['nombre'] ?></h4>
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseSubmenu<?= $t['id'] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion2">
                                            <div class="card-body">
                                                <a href="<?= base_url('/admin/congresos/verMensaje/' . $t['nombre'] . '/' . $r['nombre_red'] . '/2022') ?>" class="btn">2022</a>
                                                <a href="<?= base_url('/admin/congresos/verMensaje/' . $t['nombre'] . '/' . $r['nombre_red'] . '/2023') ?>" class="btn">2023</a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
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
        </div>
    </div>
</div>
    
</div>