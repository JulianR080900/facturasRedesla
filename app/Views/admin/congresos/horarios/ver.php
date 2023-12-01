<style>
form{
    overflow-x: auto !important;
}

.table, .table thead tr th{
    color: #fff !important;
}

.table input{
    width: auto !important;
}
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de horarios para congresos</h4>
                <p class='text-info'>INSTRUCCIONES</p>
                Dentro del modulo se podra editar el horario de ponencias para el evento. Dentro del modulo se podran editar los enlaces, moderadores, temas de salones, ponencias y enlaces de Zoom.
                Si el salon no aplica enlace de ZOOM porque es un salon presencial, escribir en el campo una leyenda de <b>No aplica por modalidad</b>.
                <p></p>
                <p class='text-info'>ARCHIVOS ADJUNTOS</p>
                <button class="btn btn-danger btn-rounded" id="ventana" >Ver listas de ponencias disponibles</button>
                <hr>
                <form action="../act_datos_congreso" method="post" id="formUpdate">

                    <input hidden type="text" name='id_congreso' value="<?php echo  $datos_tabla["id"]; ?>">

                    <div class="col-md-12">

                        <table class="table table-bordered" id="tb_horario">

                            <thead>

                                <tr>

                                    <th colspan="<?php echo ($datos_tabla["salones"]) + 1; ?>" class="text-center">Salones relayn</th>

                                </tr>

                                <tr>

                                    <th width="200px">Salones</th>

                                    <?php

                                    for ($i = 1; $i <= $datos_tabla["salones"]; $i++) {

                                    ?>

                                        <th width="100px"><?php echo $i; ?></th>

                                    <?php

                                    }

                                    ?>

                                </tr>

                                <tr>

                                    <th>Tema de salon</th>

                                    <?php
                                    if (!empty($datos_tabla["temas"])) {
                                        $explodeTemas = explode(",", $datos_tabla["temas"]);

                                        for ($i = 1; $i <= $datos_tabla["salones"]; $i++) {
                                    ?>

                                            <th>

                                                <input name="temas[]" class="form-control w-100" placeholder="Tema de la sala" value="<?= isset($explodeTemas[$i-1]) ? $explodeTemas[$i-1] : '' ?>">

                                            </th>

                                        <?php

                                        }
                                    } else {

                                        for ($i = 1; $i <= $datos_tabla["salones"]; $i++) {

                                        ?>

                                            <th>

                                                <input name="temas[]" class="form-control w-100" placeholder="Tema de la sala" value="" placeholder='Sin registrar'>

                                            </th>

                                    <?php

                                        }
                                    }

                                    ?>



                                </tr>







                                <tr>

                                    <th>Enlaces</th>

                                    <?php

                                    $explodeEnlace = explode(",", $datos_tabla["enlaces"]);

                                    for ($i = 1; $i <= $datos_tabla["salones"]; $i++) {

                                    ?>

                                        <th>

                                            <?php

                                            if (empty($datos_tabla["enlaces"])) {

                                            ?>

                                                <select name='enlaces[]' class="form-control w-100">

                                                    <option readonly selected value="" placeholder='Sin registrar'>Seleccione un enlace</option>

                                                    <?php

                                                    foreach ($enlaces as $e) {

                                                    ?>

                                                        <option value="<?php echo $e["clave"] ?>" title='<?= $e['nombre'] ?>'><?php echo $e["clave"] ?></option>

                                                    <?php

                                                    }

                                                    ?>

                                                </select>

                                            <?php

                                            } else {

                                            ?>

                                                <select name='enlaces[]' class="form-control w-100">

                                                    <option readonly selected value="" placeholder='Sin registrar'>Seleccione un enlace</option>

                                                    <?php

                                                    $x = 0;

                                                    foreach ($enlaces as $e) {
                                                        if(isset($explodeEnlace[$i - 1])){
                                                            ?>
                                                            <option <?= $explodeEnlace[$i - 1] == $e["clave"] ? 'selected' : '' ?> value="<?php echo $e["clave"] ?>" title='<?= $e['nombre'] ?>'><?php echo $e["clave"] ?></option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="<?php echo $e["clave"] ?>" title='<?= $e['nombre'] ?>'><?php echo $e["clave"] ?></option>
                                                            <?php
                                                        }

                                                        $x++;
                                                    }

                                                    ?>
                                                </select>

                                            <?php

                                            }

                                            ?>



                                        </th>

                                    <?php

                                    }

                                    ?>

                                </tr>

                                <tr>
                                    <th>Links de ZOOM</th>

                                    <?php
                                    if (!empty($datos_tabla["zoom"])) {

                                        $explodeZoom = explode(",", $datos_tabla["zoom"]);

                                        for ($i = 1; $i <= $datos_tabla["salones"]; $i++) {
                                            ?>
                                            <th>
                                                <input name="zoom[]" class="form-control w-100" placeholder="Enlace de zoom" value="<?= isset($explodeZoom[$i-1]) ? $explodeZoom[$i-1] : '' ?>">
                                            </th>
                                            <?php
                                        }
                                    }else{
                                        for ($i = 1; $i <= $datos_tabla["salones"]; $i++) {
                                            ?>
                                            <th>
                                                <input name="zoom[]" class="form-control w-100" placeholder="Enlace de zoom" value="">
                                            </th>
                                            <?php
                                        }
                                    }
                                    
                                    ?>
                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $explodeHorarios = explode(",", $datos_tabla["infoHorarios"]);

                                for ($i = 1; $i <= $datos_tabla["horarios"]; $i++) {

                                ?>

                                    <tr class="bg-danger">

                                        <th>Mesa</th>

                                        <?php

                                        //$explodeMesas = explode(",",$datos_tabla["mesas"]);

                                        for ($y = 1; $y <= $datos_tabla["salones"]; $y++) {

                                        ?>

                                            <th>

                                                <?php

                                                $name  = "mesas_salon_" . $y . "_horario_" . $i;

                                                if (empty($datos_tabla["mesas"])) {

                                                ?>

                                                    <select name='<?php echo $name ?>[]' class="form-control w-100">

                                                        <option readonly selected value="" placeholder='Sin registrar'>Seleccione una mesa</option>

                                                        <?php

                                                        foreach ($mesas as $m) {

                                                        ?>

                                                            <option value="<?php echo $m["clave"] ?>" title="<?= $m['nombre'] ?>"><?php echo $m["clave"] ?></option>

                                                        <?php

                                                        }

                                                        ?>

                                                    </select>

                                                <?php

                                                } else {

                                                ?>

                                                    <select name='<?php echo $name ?>[]' class="form-control w-100">

                                                        <option selected value="" placeholder='Sin registrar' readonly>Seleccione una mesa</option>

                                                        <?php

                                                        $x = 0;

                                                        foreach ($mesas as $e) {

                                                            $explodeMesas = explode($name, $datos_tabla["mesas"]); // 0 nombre 1 valor

                                                            if (isset($explodeMesas[1])) {

                                                                $valores = explode("-", $explodeMesas[1]); //en 0 estan los valores para ese tring 

                                                                $valor_real_ciclo = explode(";", $valores[0]);

                                                                $valor_real_ciclo = $valor_real_ciclo[1];
                                                            }

                                                            if ($valor_real_ciclo == $e["clave"]) {

                                                        ?>

                                                                <option selected value="<?php echo $e["clave"] ?>" title="<?= $e['nombre'] ?>"><?php echo $e["clave"] ?></option>

                                                            <?php

                                                            } else {

                                                            ?>

                                                                <option value="<?php echo $e["clave"] ?>" title="<?= $e['nombre'] ?>"><?php echo $e["clave"] ?></option>

                                                        <?php

                                                            }

                                                            $x++;
                                                        }

                                                        ?>













                                                    </select>

                                                <?php

                                                }

                                                ?>



                                            </th>

                                        <?php

                                        }

                                        ?>

                                    </tr>

                                    <tr class="bg-warning">

                                        <th>Moderadores</th>

                                        <?php

                                        //$explodeModeradores = explode(",",$datos_tabla["moderadores"]);

                                        for ($t = 1; $t <= $datos_tabla["salones"]; $t++) {

                                        ?>

                                            <th>

                                                <?php

                                                $name  = "moderadores_salon_" . $t . "_horario_" . $i;

                                                if (empty($datos_tabla["moderadores"])) {

                                                ?>

                                                    <select name='<?php echo $name ?>[]' class="form-control w-100">

                                                        <option readonly selected value="" placeholder='Sin registrar'>Seleccione un moderador</option>

                                                        <?php

                                                        foreach ($moderadores as $m) {

                                                        ?>

                                                            <option value="<?php echo $m["clave"] ?>" title='<?= $m['nombre'] ?>'><?php echo $m["clave"] ?></option>

                                                        <?php

                                                        }

                                                        ?>

                                                    </select>

                                                <?php

                                                } else {

                                                ?>

                                                    <select name='<?php echo $name ?>[]' class="form-control w-100">

                                                        <option readonly selected value="" placeholder='Sin registrar'>Seleccione un moderador</option>

                                                        <?php

                                                        $x = 0;

                                                        foreach ($moderadores as $e) {

                                                            $explodeModeradores = explode($name, $datos_tabla["moderadores"]); // 0 nombre 1 valor

                                                            if (isset($explodeModeradores[1])) {

                                                                $valores = explode("-", $explodeModeradores[1]); //en 0 estan los valores para ese tring 

                                                                $valor_real_ciclo = explode(";", $valores[0]);

                                                                $valor_real_ciclo = $valor_real_ciclo[1];
                                                            }

                                                            if ($valor_real_ciclo == $e["clave"]) {

                                                        ?>

                                                                <option selected value="<?php echo $e["clave"] ?>" title='<?= $e['nombre'] ?>'><?php echo $e["clave"] ?></option>

                                                            <?php

                                                            } else {

                                                            ?>

                                                                <option value="<?php echo $e["clave"] ?>" title='<?= $e['nombre'] ?>'><?php echo $e["clave"] ?></option>

                                                        <?php

                                                            }

                                                            $x++;
                                                        }

                                                        ?>













                                                    </select>

                                                <?php

                                                }

                                                ?>



                                            </th>

                                        <?php

                                        }

                                        ?>

                                    </tr>

                                    <tr>

                                        <td>

                                            <?php

                                            if (empty($datos_tabla["infoHorarios"])) {

                                            ?>

                                                <p>Horario</p>
                                                <span class="text-warning">Ejemplo: Jueves 17 de noviembre  ~ 11:30 a 13:30</span><br>

                                                <input type="text" class="form-control w-100" name="horarios[]" value="" placeholder='Sin registrar'>

                                                <?php

                                            } else {

                                                if (!empty($explodeHorarios[$i - 1])) {

                                                ?>

                                                    <p>Horario</p>

                                                    <input type="text" class="form-control w-100" name="horarios[]" value="<?php echo $explodeHorarios[$i - 1] ?>">

                                                <?php

                                                } else {

                                                ?>

                                                    <p>Horario</p><br>

                                                    <input type="text" class="form-control w-100" name="horarios[]" value="" placeholder='Sin registrar'>

                                                <?php

                                                }



                                                ?>

                                            <?php

                                            }

                                            ?>

                                        </td>

                                        <?php

                                        $stringPonencias = $datos_tabla["ponencias"];

                                        for ($e = 1; $e <= $datos_tabla["salones"]; $e++) {

                                        ?>

                                            <td>

                                                <table>

                                                    <tbody>

                                                        <?php

                                                        for ($q = 1; $q <= 6; $q++) { //con q sacaremos cada valor de un td del ciclo

                                                            //AQUI TOMAREMOS LOS 5 VALORES O EL VALOR DE CADA CICLO

                                                            $name  = "ponencias_salon_" . $e . "_horario_" . $i;

                                                            if ($stringPonencias !== "") {

                                                                $posicion = explode("$name;", $stringPonencias); //0 es vacio o en donde termina y el 1 tiene toodo lo demas del string

                                                                if (isset($posicion[1])) {

                                                                    $valores = explode("-", $posicion[1]); //en 0 estan los valores para ese tring 

                                                                    $valor_selects = explode(",", $valores[0]); //Me da valores del 0 al 4

                                                                    $valor_real_ciclo = $valor_selects[$q - 1];
                                                                }
                                                            } else {

                                                                $valor_real_ciclo = "";
                                                            }



                                                        ?>

                                                            <tr>

                                                                <td>

                                                                    <input type="text" class="form-control w-100" name="<?php echo $name . "[]"; ?>" value="<?php echo  $valor_real_ciclo ?>">

                                                                </td>

                                                            </tr>

                                                        <?php

                                                        }

                                                        ?>

                                                    </tbody>

                                                </table>

                                            </td>

                                        <?php

                                        }

                                        ?>

                                    </tr>

                                <?php

                                }

                                ?>

                            </tbody>

                        </table>

                        

                    </div>

                </form>
                <hr>
                <div class='row'>
                        <button type="submit" class="btn btn-block btn-success" id='btnAct'>Actualizar horario y previsualizar</button>
                        <a target="_blank" href="../previsualizacion/<?= $datos_tabla["id"] ?>" class="btn btn-block btn-danger">Subir archivo <i class="fa-solid fa-file-pdf"></i></a>
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?= base_url() ?>';
    const ponencias = <?= json_encode($ponencias) ?>;
    let tabla = `<?= $tabla_ponencias ?>`
    tabla = tabla.trim().replace(/&nbsp;/g, ' ').replace(/\n/g, '');
</script>
<script src="<?= base_url('resources/admin/datatables/congresos/horarios.js') ?>"></script>