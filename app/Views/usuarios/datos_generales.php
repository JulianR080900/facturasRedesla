<div class="content">

    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header header_title_card">
                    <h5>Datos de la universidad</h5>
                </div>

                <div class="card-body body_card">

                    <div class="row">

                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 img_card_div">

                            <img id="img_ca" src="<?php echo base_url("resources/img/svg/undraw_education_f8ru.svg"); ?>" alt="">

                        </div>

                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                            <h4>Clave de la institución:</h4>
                            <h6><?php echo $datos_universidad["claveCuerpo"]; ?></h6>
                            <hr>
                            <h4>Nombre de la institución:</h4>
                            <h6><?php echo $datos_universidad["nombre"];
                                echo $lider == 1 ? "&nbsp<a href='#editNombreUni_" . $datos_universidad["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning disabled_edit'><i class='fas fa-pen'></i>&nbspEditar</a>" : ""; ?></h6>
                            <hr>
                            <h6>
                                <i class="fas fa-map-marker-alt" style="color:red"></i>
                                <?php echo "  " . $datos_universidad["direccion"];
                                echo $lider == 1 ? "&nbsp<a href='#editDirUni_" . $datos_universidad["claveCuerpo"] . "' data-toggle='modal' class='badge badge-warning disabled_edit'><i class='fas fa-pen'></i>&nbspEditar</a>" : ""; ?></h6>
                            <hr>

                            <h4>Rector / Director:</h4>

                            <h6><?php echo $datos_universidad["nombre_rector"];
                                echo $lider == 1 ? "&nbsp<a href='#editRector_" . $_SESSION["CA"] . "' data-toggle='modal' class='badge badge-warning disabled_edit'><i class='fas fa-pen'></i>&nbspEditar</a>" : ""; ?></h6>

                            <hr>

                            <?php

                            foreach ($grados_rector as $g) {



                                if ($datos_universidad["grado_rector"] == $g["id"]) {

                                    $grado_rector = $g["nombre"];
                                }
                            }

                            ?>

                            <h4>Grado académico del Rector / Director:</h4>

                            <h6><?php echo $grado_rector;
                                echo $lider == 1 ? "&nbsp<a href='#editGradoRector_" . $_SESSION["CA"] . "' data-toggle='modal' class='badge badge-warning disabled_edit'><i class='fas fa-pen'></i>&nbspEditar</a>" : ""; ?></h6>



                            <hr>
                            <h4>Zona de estudio</h4>
                            <span class="badge badge-pill badge-info"><?php echo $datos_universidad["nombre_pais"]; ?></span>

                            <span class="badge badge-pill badge-info"><?php echo $datos_universidad["nombre_estado"]; ?></span>

                            <span class="badge badge-pill badge-info"><?php echo $datos_universidad["nombre_municipio"]; ?></span>

                            <?php

                            if (isset($datos_universidad["municipios_ca"])) {

                                foreach ($datos_universidad["municipios_ca"] as $m) {

                                    echo "<span class='badge badge-pill badge-light'>" . $m . "</span>";
                                }
                            }

                            ?>

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

                            <h6><?php echo $datos_universidad["telefono"];
                                echo $lider == 1 ? "&nbsp<a href='#editTelefono_" . $_SESSION["CA"] . "' data-toggle='modal' class='badge badge-warning disabled_edit'><i class='fas fa-pen'></i>&nbspEditar</a>" : ""; ?></h6>

                        </div>

                        <div class="col-md-3 text-center">
                            <hr>

                            <h5>Extensión</h5>

                            <h6>+<?php echo $datos_universidad["extension"];
                                    echo $lider == 1 ? "&nbsp<a href='#editExtension_" . $_SESSION["CA"] . "' data-toggle='modal' class='badge badge-warning disabled_edit'><i class='fas fa-pen'></i>&nbspEditar</a>" : ""; ?></h6>

                        </div>

                        <div class="col-md-3 text-center">
                            <hr>

                            <h5>Dirección de envios</h5>

                            <h6>
                            <?php echo $datos_universidad["direccion_envio"];
                            
                                if(ucfirst(session('red')) == 'Relen' || ucfirst(session('red')) == 'Relep'){
                                    echo $lider == 1 ? "&nbsp<a href='#editDirEnvios_" . $_SESSION["CA"] . "' data-toggle='modal' class='badge badge-warning'><i class='fas fa-pen'></i>&nbspEditar</a>" : ""; 
                                }else{
                                    echo $lider == 1 ? "&nbsp<a href='#editDirEnvios_" . $_SESSION["CA"] . "' data-toggle='modal' class='badge badge-warning disabled_edit'>&nbspEditar</a>" : ""; 
                                }
                                
                            ?>
                            </h6>

                        </div>

                    </div>
                    <hr>

                    <div class="row">

                        <div class="col-md-12 text-center">

                            <h2 class="n_<?php echo $_SESSION["red"] ?>">Datos de CA ante Prodep <?php echo $lider == 1 ? "&nbsp<a href='#editProdep_" . $_SESSION["CA"] . "' data-toggle='modal' class='badge badge-warning disabled_edit'><i class='fas fa-pen'></i>&nbspEditar</a>" : ""; ?></h2>

                        </div>

                    </div>
                    <hr>

                    <div class="row justify-content-center">

                        <div class="col-md-3 text-center">

                            <h5>Nombre Prodep</h5>

                            <h6><?php echo $datos_universidad["nombre_prodep"] == "" ? "No Registrado" : $datos_universidad["nombre_prodep"] ?></h6>

                        </div>

                        <div class="col-md-3 text-center">

                            <h5>Nivel del cuerpo académico</h5>

                            <h6><?php echo $datos_universidad["nivel_prodep"] == "" ? "No Registrado" : $datos_universidad["nivel_prodep"] ?></h6>

                        </div>

                        <div class="col-md-3 text-center">

                            <h5>Año del último cambio de nivel</h5>

                            <h6><?php echo $datos_universidad["ano_prodep"] == "" ? "No Registrado" : $datos_universidad["ano_prodep"] ?></h6>

                        </div>

                    </div>
                    <hr>

                    <?php

                    if ($_SESSION["red"] == "Relep") {

                    ?>

                        <div class="row justify-content-center">

                            <div class="col-md-12 text-center">

                                <h5>Institución a estudiar</h5>

                                <h6><?php echo $datos_universidad["inst_est"];
                                    echo $lider == 1 ? "&nbsp<a href='#editinstEst_" . $_SESSION["CA"] . "' data-toggle='modal' class='badge badge-warning'><i class='fas fa-pen'></i>&nbspEditar</a>" : ""; ?></h6>

                            </div>

                        </div>

                    <?php

                    } elseif ($_SESSION["red"] == "Relen") {

                    ?>

                        <div class="row justify-content-center">

                            <div class="col-md-12 text-center">

                                <h5>Especialidad</h5>

                                <h6><?php echo $datos_universidad["inst_est"] ?> </h6>

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

<!-- Busca <a disabled y borra disabled -->

