<div class="content">

    <?php
    if (session('lider') == 1) {
    ?>
        <div class="alert alert-danger" role="alert">

            Estimado líder usted podrá modificar los datos de todos los miembros del grupo, si desean <b>CAMBIAR</b> el líder contacten al equipo RedesLA o envíen un correo a pmejiaa@redesla.la, <b>NO</b> la realice usted.

        </div>
    <?php
    }
    ?>

    <div class="card card-perfil">

        <div class="card-body">
            <h5 class="card-title text-uppercase">Miembros de grupo <?= session('CA') ?></h5>
            <div class="row divMiembros">

                <?php
                foreach ($miembros as $info) {
                    $img_user = !empty($info["img_user"]) ? base_url("resources/img/profiles/" . $info["img_user"]) : base_url("resources/img/avatar.png");

                    if (!file_exists($img_user)) {
                        $img_user = base_url("resources/img/avatar.png");
                    }
                ?>
                    <div class="col-md-6 col-lg-3 col-xl-3 col-sm-12">
                        <div class="divMiembros">
                            <div class="centered-content">
                                <img src="<?= $img_user ?>" alt="avatar" class="imgMiembro">
                                <div class="dataMiembro">
                                    <p class="nombre"><?= $info["nombreCompleto"] ?></p>
                                    <?php
                                    if ($info["tipo"] == "alumno" && $info["lider"] == 0) {
                                        echo '<small><p>Alumno</p></small>';
                                    } else if ($info["tipo"] == "maestro" && $info["lider"] == 0) {
                                        echo '<p><i class="fa-solid fa-user-tie"></i> Miembro</p>';
                                    } else {
                                        echo '<p><i class="fa-solid fa-crown"></i> Líder</p>';
                                    }
                                    ?>
                                    <p>
                                        <i class="fas fa-user-graduate">&nbsp</i><label for=""><?php echo $info["grado_academico"] . " en " . $info["especialidad"] ?></label>
                                    </p>
                                    <p>
                                        <i class="fas fa-envelope">&nbsp</i><label for=""><?php echo $info["correo"] ?></label>
                                    </p>

                                    <p>
                                        <i class="fas fa-envelope">&nbsp</i><label for=""><?php echo $info["correo_institucional"] ?></label>
                                    </p>

                                    <p>
                                        <i class="fas fa-phone-alt" style="rotate: 90deg;">&nbsp</i><label for=""><?php echo $info["telefono"] ?></label>
                                    </p>
                                    <form action="<?= base_url("editarMiembro") ?>" method="post">
                                        <?php
                                        if (session('lider') == 1) {
                                        ?>
                                            <button type="submit" disabled name="id_miembro" id="id_miembro" value="<?php echo $info["id"] ?>" class="btn btn-warning btn-block editButtonGeneric">Editar &nbsp<i class="far fa-edit"></i></button>
                                        <?php
                                        }
                                        ?>
                                    </form>
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




</div>
<style>
    .editButtonGeneric {
        pointer-events: none;
        content: 'No disponible';
    }
</style>