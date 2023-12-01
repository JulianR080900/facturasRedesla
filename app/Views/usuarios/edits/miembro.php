<link rel="stylesheet" href="<?= base_url('resources/intl-tel-input/build/css/intlTelInput.css') ?>">
<div class="content">
    <div class="col-md-12">
    <div class="card card-body-congresos">
        <div class="card-header card-header-congresos">
            <h3>Editar miembro</h3>
        </div>
        <div style="padding: 30px;">
        <?php
        if(!isset($miembro)){
            echo "<h1>Ha ocurrido un error. Intente mas tarde</h1>";
        }else{
            foreach($miembro as $m){
                ?>
                <form method="post" action="<?php echo base_url("generalUpdate/miembros") ?>" class="needs-validation" novalidate>
                
                <div class="mb-3">

                    <label for="nombre">Nombre del miembro</label>

                    <input required type="text" name="nombre" id="nombre" class="form-control ol" value="<?php echo $m["nombre"] ?>"><br>

                    <div class="invalid-feedback">

                        Ingrese el nombre del miembro

                    </div>

                </div>

                <div class="mb-3">

                    <label for="apaterno">Apellido paterno</label>

                    <input required type="text" name="apaterno" id="apaterno" class="form-control ol" value="<?php echo $m["apaterno"] ?>"><br>

                    <div class="invalid-feedback">

                        Ingrese el apellido paterno del miembro

                    </div>

                </div>

                <div class="mb-3">

                    <label for="amaterno">Apellido materno</label>

                    <input required type="text" name="amaterno" id="amaterno" class="form-control ol" value="<?php echo $m["amaterno"] ?>"><br>

                    <div class="invalid-feedback">

                        Ingrese el apellido materno del miembro

                    </div>

                </div>

                <div class="mb-3">

                    <label for="amaterno">Grado academico</label>

                    <select class="form-control" name="grado" id="grado" required>
                    <option value="" selected="true" disabled>Selecciona el grado académico del miembro</option>
                    <?php
                    foreach($grados_academicos as $ga){
                        if($ga["id"] == $m["grado"]){
                            ?>
                                <option selected value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>
                            <?php
                        }else{
                            ?>
                                <option value="<?php echo $ga["id"] ?>"><?php echo $ga["nombre"] ?></option>
                            <?php
                        }
                        
                    }
                    ?>
                    </select><br>

                </div>

                <div class="mb-3">

                    <label for="especialidad">Especialidad</label>

                    <input required type="text" name="especialidad" id="especialidad" class="form-control ol" value="<?php echo $m["especialidad"] ?>"><br>

                    <div class="invalid-feedback">

                        Ingrese la especialidad del miembro

                    </div>

                </div>

                <div class="mb-3">

                    <label for="especialidad">Teléfono</label>

                    <p style="font-size: 12px;">
                        La bandera que aparece en la parte de abajo es puesta por defecto. Si su numero no cuenta con la LADA o es erronea,
                        borre el valor del campo y seleccione la bandera de su pais para añadir la LADA automáticamente 
                    </p>

                    <input required type="tel" name="telefono" id="telefono" class="form-control on" value="<?php echo $m["telefono"] ?>"><br>

                    <div class="invalid-feedback">

                        Ingrese el teléfono del miembro

                    </div>

                </div>
                <input hidden name="id" value="<?= $m['id'] ?>">

                <div class="mb-3">
                    <button type="submit" class="btn btn-block bg-<?= $_SESSION['red'] ?>">Actualizar datos <i class="fa-solid fa-caret-right"></i></button>
                    <a href="<?php echo base_url("Miembros") ?>" class="btn btn-block btn-danger"><i class="fa-solid fa-caret-left"></i> Regresar</a>
                </div>
                </form>
                <?php
            }
        }
        ?>
    </div>
    </div>
    </div>
</div>

<script src="<?= base_url('resources/js/form-validation/index.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js" integrity="sha512-XGZwM3U4PM6aH04G+9uL3qma2xu2feLpy5qX7WRlFu2Ti3tiRPoY9vuD9bz7wiTVJ139hdogEYBFZtevPPR1Yw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= base_url('resources/intl-tel-input/build/js/intlTelInput.js') ?>"></script>
<script src="<?= base_url('resources/js/inicio/editar_miembro.js') ?>"></script>