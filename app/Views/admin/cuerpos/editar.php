<style>
    .dropdown-menu {
        z-index: 1000;
    }

    .card {
        z-index: 0;
    }
</style>
<div class="content-wrapper">
    <div class="col-md-12">

        <div class="card">

            <div class="card-header header_title_card">
                <h5>Datos de la universidad</h5>
            </div>

            <div class="card-body body_card">

                <div class="row">

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 img_card_div">

                        <img id="img_ca" src="<?php echo base_url("resources/img/svg/undraw_education_f8ru.svg"); ?>" alt="" width="100%">

                    </div>

                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                        <h4>Clave de la institución:</h4>
                        <h6><?php echo $cuerpo["claveCuerpo"]; ?> <a href='#editClaveCuerpo_<?= $cuerpo["claveCuerpo"] ?>' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a></h6>
                        <hr>
                        <h4>Nombre de la institución:</h4>
                        <h6><?php echo $cuerpo["nombre"];
                            echo $lider == 1 ? "&nbsp<a href='#editNombreUni_" . $cuerpo["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>" : ""; ?></h6>
                        <hr>
                        <h4>Dirección de la institución:</h4>
                        <h6>
                            <i class="fas fa-map-marker-alt" style="color:red"></i>
                            <?php echo "  " . $cuerpo["direccion"];
                            echo $lider == 1 ? "&nbsp<a href='#editDirUni_" . $cuerpo["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>" : ""; ?>
                        </h6>
                        <hr>

                        <h4>Rector / Director:</h4>

                        <h6><?php echo $cuerpo["nombre_rector"];
                            echo $lider == 1 ? "&nbsp<a href='#editRector_" . $cuerpo["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>" : ""; ?></h6>

                        <hr>

                        <h4>Grado académico del Rector / Director:</h4>

                        <h6><?php echo $cuerpo['grado_rector'];
                            echo $lider == 1 ? "&nbsp<a href='#editGradoRector_" . $cuerpo["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>" : ""; ?></h6>

                        <hr>
                        <h4>Tipo de registro</h4>
                        <?= $cuerpo['tipo_registro'] ?> &nbsp<a href='#editTipoRegistro_<?= $cuerpo["claveCuerpo"] ?>' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>

                        <hr>
                        <h4>Zona de estudio</h4>
                        <span class="badge badge-pill badge-info"><?php echo $cuerpo["pais"]; ?></span>

                        <span class="badge badge-pill badge-info"><?php echo $cuerpo["estado"]; ?></span>

                        <span class="badge badge-pill badge-info"><?php echo $cuerpo["municipio"]; ?></span>

                        <?php

                        if (isset($municipios_adicionales)) {

                            foreach ($municipios_adicionales as $m) {

                                echo "<span class='badge badge-pill badge-light' style='color:#000'>" . $m['nombre_municipio'] . "</span>";
                            }
                        }

                        ?>

                        <a href="#editarLocalidad_<?= $cuerpo["claveCuerpo"] ?>" data-toggle="modal" data-target='#editarLocalidad_<?= $cuerpo["claveCuerpo"] ?>' class="badge badge-warning"><i class="mdi mdi-lead-pencil"></i>&nbspEditar</a>

                        <a href="#agregarMunicipio_<?= $cuerpo["claveCuerpo"] ?>" data-toggle="modal" data-target="#agregarMunicipio_<?= $cuerpo["claveCuerpo"] ?>" class="badge badge-success"><i class="mdi mdi-plus-box"></i></a>

                    </div>

                </div>
                <div class="row">

                    <div class="col-md-12 text-center">
                        <hr>
                        <h2>Datos de mi institución</h2>

                    </div>

                </div>

                <div class="row justify-content-center">
                    <div class="col-md-3 text-center">
                        <hr>
                        <h5>Teléfono</h5>

                        <h6><?php echo $cuerpo["telefono"];
                            echo $lider == 1 ? "&nbsp<a href='#editTelefono_" . $cuerpo["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>" : ""; ?></h6>

                    </div>

                    <div class="col-md-3 text-center">
                        <hr>

                        <h5>Extensión</h5>

                        <h6>+<?php echo $cuerpo["extension"];
                                echo $lider == 1 ? "&nbsp<a href='#editExtension_" . $cuerpo["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>" : ""; ?></h6>

                    </div>

                    <div class="col-md-3 text-center">
                        <hr>

                        <h5>Dirección de envios</h5>

                        <h6><?php echo $cuerpo["direccion_envio"];
                            echo $lider == 1 ? "&nbsp<a href='#editDirEnvios_" . $cuerpo["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>" : ""; ?></h6>

                    </div>

                </div>
                <hr>

                <div class="row">

                    <div class="col-md-12 text-center">

                        <h2 class="n_<?php echo $cuerpo["redCueCa"] ?>">Datos de CA ante Prodep <?php echo $lider == 1 ? "&nbsp<a href='#editProdep_" . $cuerpo["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>" : ""; ?></h2>

                    </div>

                </div>
                <hr>

                <div class="row justify-content-center">

                    <div class="col-md-3 text-center">

                        <h5>Nombre Prodep</h5>

                        <h6><?php echo $cuerpo["nombre_prodep"] == "" ? "No Registrado" : $cuerpo["nombre_prodep"] ?></h6>

                    </div>

                    <div class="col-md-3 text-center">

                        <h5>Nivel del cuerpo académico</h5>

                        <h6><?php echo $cuerpo["nivel_prodep"] == "" ? "No Registrado" : $cuerpo["nivel_prodep"] ?></h6>

                    </div>

                    <div class="col-md-3 text-center">

                        <h5>Año del último cambio de nivel</h5>

                        <h6><?php echo $cuerpo["ano_prodep"] == "" ? "No Registrado" : $cuerpo["ano_prodep"] ?></h6>

                    </div>

                </div>
                <hr>

                <?php

                if ($cuerpo["redCueCa"] == "Relep" || $cuerpo['redCueCa'] == 'Releg') {

                ?>

                    <div class="row justify-content-center">

                        <div class="col-md-12 text-center">

                            <h5>Instituciónes a estudiar</h5>

                            <h6><?php echo $cuerpo["inst_est"];
                                echo $lider == 1 ? "&nbsp<a href='#editinstEst_" . $cuerpo["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a>" : ""; ?></h6>

                        </div>

                    </div>

                <?php

                } elseif ($cuerpo["redCueCa"] == "Relen") {

                ?>

                    <div class="row justify-content-center">

                        <div class="col-md-12 text-center">

                            <h5>Zona de especialidad</h5>

                            <h6><?php echo $cuerpo["especialidad"] ?> &nbsp<a href='#editarEspecialidad_<?= $cuerpo["claveCuerpo"] ?>' data-toggle='modal' class='badge badge-warning'><i class='mdi mdi-lead-pencil'></i>&nbspEditar</a></h6>

                        </div>

                    </div>

                <?php
                }

                if ($cuerpo['redCueCa'] == 'Releg' || $cuerpo['redCueCa'] == 'Relep') {
                ?>
                <hr>
                    <div class="row justify-content-center">

                        <div class="col-md-12 text-center">

                            <h5>Facultades a las que se les aplicara el estudio</h5>

                            <h6><?= $cuerpo["fac_estudio"] ?></h6>

                        </div>

                    </div>
                <?php
                }
                ?>
            </div>

        </div>

    </div>
    <hr>
    <div class="col-md 12">
        <div class="card">
            <div class="card-header header_title_card">
                <h5>Miembros</h5>
            </div>
            <div class="card-body body_card">
                <div class="row">
                    <?php
                    foreach ($miembros as $m) {
                    ?>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card card-custom bg-white border-white border-0">
                                <div class="card-custom-img" style="background-image: url(http://res.cloudinary.com/d3/image/upload/c_scale,q_auto:good,w_1110/trianglify-v1-cs85g_cc5d2i.jpg);"></div>
                                <div class="card-custom-avatar">
                                    <img class="img-fluid" src="<?= empty($m['profile_pic']) ? base_url("resources/img/avatar.png") : base_url("resources/img/profiles/" . $m["profile_pic"]); ?>" alt="Avatar" />
                                </div>
                                <div class="card-body card-miembros" style="overflow-y: auto">
                                    <h4 class="card-title"><?= $m['nombre'] . ' ' . $m['apaterno'] . ' ' . $m['amaterno'] ?></h4>
                                    <div class="card-text">
                                        <h5><?= $m['lider'] == 1 ?
                                                'Lider <i class="mdi mdi-crown" style="color:gold"></i>' :
                                                'Miembro <a href="../lider/' . $m['id'] . '/' . $m['cuerpoAcademico'] . '" class="lider" title="Cambiar a líder"><i class="mdi mdi-account"></i></a>' ?>
                                        </h5>
                                        <hr class="hr-miembros">
                                        <b>Información de contacto</b>
                                        <p>Correo personal</p>
                                        <p><?= $m['correo'] ?></p>
                                        <p>Correo institucional</p>
                                        <p><?= $m['correo_institucional'] ?></p>
                                        <p>Teléfono</p>
                                        <p><?= $m['telefono'] ?></p>
                                        <hr class="hr-miembros">
                                        <b>Información académica</b>
                                        <p><?= $m['grado'] ?> en <?= $m['especialidad'] ?></p>
                                        <hr class="hr-miembros">
                                        <b>Información SNI</b>
                                        <?php
                                        if ($m['sni'] == 'Sin SNI' || $m['sni'] === null || empty($m['sni'])) {
                                            echo '<p>Sin SNI</p>';
                                        } else {
                                            echo "<p>" . $m['sni'] . "</p>";
                                            echo "<b>Año de obtención</b>";
                                            echo '<p>' . $m['anoSNI'] . '</p>';
                                        }
                                        ?>
                                    </div>
                                    <hr>
                                    <h5>Opciones</h5>
                                    <a href="<?= base_url('admin/miembros/editar/' . $m['id']) ?>" class="btn btn-warning btn-block">Editar</a>
                                    <br>
                                    <div class="dropdown">
                                        <button class="btn btn-danger btn-block dropdown-toggle" type="button" id="dropdownMenuSizeButton<?= $m['id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Eliminar </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton<?= $m['id']; ?>">
                                            <h6 class="dropdown-header">Opciones</h6>
                                            <a class="dropdown-item eliminarMiembro" data-id="<?= $m['id'] ?>">Eliminar del cuerpo</a>
                                            <a class="dropdown-item eliminarAccesos" data-id="<?= $m['id'] ?>">Eliminar del cuerpo y accesos</a>
                                            <div class="dropdown-divider"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                if ($faltantes > 0) {
                ?>
                    <div class='row'>
                        <a href='../agregar/<?= $cuerpo['claveCuerpo'] ?>' class='btn btn-success btn-block'>Agregar miembro <i class='mdi mdi-account-plus'></i></a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>






    </div>
</div>

<style>
    .card-custom {
        overflow: hidden;
        min-height: 450px;
        box-shadow: 0 0 15px rgba(10, 10, 10, 0.3);
    }

    .card-custom-img {
        height: 200px;
        min-height: 200px;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border-color: #000;
    }

    /* First border-left-width setting is a fallback */
    .card-custom-img::after {
        position: absolute;
        content: '';
        top: 161px;
        left: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-top-width: 40px;
        border-right-width: 0;
        border-bottom-width: 0;
        border-left-width: 545px;
        border-left-width: calc(575px - 5vw);
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: inherit;
    }

    .card-custom-avatar img {
        border-radius: 50%;
        box-shadow: 0 0 15px rgba(10, 10, 10, 0.3);
        position: absolute;
        top: 100px;
        left: 1.25rem;
        width: 100px;
        height: 100px;
    }

    .card-miembros {
        background-color: #000;
    }

    .hr-miembros {
        background-color: gray;
    }

    .mdi.mdi-account:hover {
        color: gold;
        cursor: pointer;
        content: '\f6a4';
    }
</style>

<script>
    var base_url = '<?= base_url() ?>';
    $(document).on('click', '.eliminarMiembro', function(e) {
        var id = $(this).data('id')

        Swal.fire({
            title: '¿Estas seguro que desea eliminar el miembro del cuerpo académico?',
            html: '<p style="color:red">Esta accion NO es reversible</p><p style="color:gray">Nota: Antes de eliminar a un líder, cambielo en el módulo de cuerpos académicos.</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminalo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + "/admin/miembros/eliminar",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data == 'errorDelete') {
                            Swal.fire(
                                'Lo sentimos!',
                                'Ha ocurrido un error al eliminar el miembro. Contacte a sistemas',
                                'error'
                            )
                        } else if (data == 'errorLider') {
                            Swal.fire(
                                'Lo sentimos!',
                                'El miembro se ha eliminado pero el lider no se ha actualizado en automático. Favor de asignarlo en el módulo de cuerpos académicos',
                                'error'
                            )
                        } else if (data == 'success') {
                            Swal.fire(
                                'ÉXITO',
                                'Se ha eliminado el miembro correctamente y se ha asignado un nuevo lider en automático. Favor de revisar.',
                                'success'
                            )
                        }
                        location.reload();
                    },
                });

            }
        });
    });

    $(document).on('click', '.eliminarAccesos', function(e) {
        var id = $(this).data('id')

        Swal.fire({
            title: '¿Estas seguro que desea eliminar el miembro del cuerpo académico y sus accesos?',
            html: '<p style="color:red">Esta accion NO es reversible</p><p style="color:gray">Nota: El acceso se eliminara en caso de que no haya otro cuerpo académico ligado a el.</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminalo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + "/admin/miembros/eliminarAccesos",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data == 'errorDelete') {
                            Swal.fire(
                                'Lo sentimos!',
                                'Ha ocurrido un error al eliminar el miembro. Contacte a sistemas',
                                'error'
                            )
                        } else if (data == 'errorLider') {
                            Swal.fire(
                                'Lo sentimos!',
                                'El miembro se ha eliminado pero el lider no se ha actualizado en automático. Favor de asignarlo en el módulo de cuerpos académicos',
                                'error'
                            )
                        } else if (data == 'success') {
                            Swal.fire(
                                'ÉXITO',
                                'Se ha eliminado el miembro correctamente y se ha asignado un nuevo lider en automático. Favor de revisar.',
                                'success'
                            )
                        } else if (data == 'successAccesos') {
                            Swal.fire(
                                'ÉXITO',
                                'Se ha eliminado el miembro correctamente, sus accesos y se ha asignado un nuevo lider en automático. Favor de revisar.',
                                'success'
                            )
                        }
                        location.reload();
                    },
                });

            }
        });
    });
</script>