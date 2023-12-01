
<!DOCTYPE html>

<html lang="es-MX">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?= base_url("resources/css/constancias/verificar.css") ?>">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">

    <title>Información de su constancia</title>

</head>

<body>

    <div class="container">

        <section>

            <div class="row col-auto text-center" id="row_imagenes">

                <img src="<?php echo base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" width="50%" alt="Constancias Redesla" >

                <h1>Datos del folio <b><?= $info['folio'] ?></b></h1>

            </div>

        </section>

        <section>

            <div class="row justify-content-center justify-content-md-start">

                <div class="col align-self-center">

                <div class="col-md-12">

                    <?php
                    if($info['tipo_constancia'] == 'Dictaminador'){
                        ?>
                        <h3>Nombre del participante</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['nombre'] ?>"><br>

                        <h3>Tipo de constancia</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['tipo_constancia'] ?>"><br>

                        <h3>Cantidad de revisiones<h3>

                        <input type='text' class='form-control' readonly name="" id="" value="<?= $info['c_ponencias'] ?>">

                        <h3>Fecha de expedición<h3>

                        <input type='text' class='form-control' readonly name="" id="" value="<?= $info['fecha_insert'] ?>">

                        <h3>Colaboración con las redes<h3>

                            <?php
                            $i = 1;
                            foreach ($info['red'] as $r) {
                                if($i == 1){
                                    echo '<div class="row text-center">';
                                    echo '<div class="col-md-4">';
                                    ?>
                                    <img src="<?= base_url("resources/img/isotipos/Mapa_" . $r . ".png"); ?>" style="width:20%" 
                                    alt="<?= $r ?>" title="<?= $r ?>"   />
                                    <label><?= $r ?></label>
                                    <?php
                                    echo "</div>";
                                }else if($i == 2){
                                    echo '<div class="col-md-4">';
                                    ?>
                                    <img src="<?= base_url("resources/img/isotipos/Mapa_" . $r . ".png"); ?>" style="width:20%" 
                                    alt="<?= $r ?>" title="<?= $r ?>"   />
                                    <label><?= $r ?></label>
                                    <?php
                                    echo "</div>";
                                }else if($i == 3){
                                    echo '<div class="col-md-4">';
                                    ?>
                                    <img src="<?= base_url("resources/img/isotipos/Mapa_" . $r . ".png"); ?>" style="width:20%" 
                                    alt="<?= $r ?>" title="<?= $r ?>"   />
                                    <label><?= $r ?></label>
                                    <?php
                                    echo "</div>";
                                    echo '</div>';
                                    $i = 0;
                                }
                                ?>
                                
                                <?php
                                $i++;
                            }
                            ?>
                        </div>
                        <?php
                    }else if($info['tipo_constancia'] == 'Distincion Dictaminador'){
                        ?>
                        <h3>Nombre del participante</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['nombre'] ?>"><br>

                        <h3>Tipo de constancia</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['tipo_constancia'] ?>"><br>

                        <h3>Fecha de expedición<h3>

                        <input type='text' class='form-control' readonly name="" id="" value="<?= $info['fecha_insert'] ?>">
                        <?php
                    }else if($info['tipo_constancia'] == 'Acreditación del curso'){
                        ?>
                        <h3>Nombre del participante</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['nombre'] ?>"><br>

                        <h3>Tipo de constancia</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['tipo_constancia'] ?>"><br>

                        <h3>Nombre del curso</h3>

                        <textarea rows="2" class="form-control" readonly name="" id="" ><?= $info['curso'] ?></textarea><br>

                        <h3>Año de expedición<h3>

                        <input type='text' class='form-control' readonly name="" id="" value="<?= $info['anio'] ?>">

                        <h3>Edición del curso<h3>

                        <input type='text' class='form-control' readonly name="" id="" value="<?= $info['edicion'] ?>">
                        <?php
                    }else if($info['tipo_constancia'] == 'Moderador'){
                        ?>
                        <h3>Nombre del Moderador</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['nombre'] ?>"><br>

                        <h3>Tipo de constancia</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['tipo_constancia'] ?>"><br>

                        <h3>Colaboró con la red</h3>

                        <div class="row text-center">
                            <div class="col-md-12">
                            <img class="imgRed" src="<?= base_url("resources/img/isotipos/Mapa_" . $info['red'] . ".png"); ?>" style="width:10%" 
                            alt="<?= $info['red'] ?>" title="<?= $info['red'] ?>"   />
                            <label><?= $info['red'] ?></label>
                            </div>
                        </div>

                        <h3>Año en que colaboró con la red</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['anio_colaboracion'] ?>"><br>
                        <?php
                    }else{
                        ?>
                        <h3>Nombre del participante</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['nombre'] ?>"><br>

                        <h3>Tipo de constancia</h3>

                        <input type="text" class="form-control" readonly name="" id="" value="<?= $info['tipo_constancia'] ?>"><br>

                        <?php

                        if(isset($info['cuerpo_academico'])){

                            ?>

                            <h3>Nombre de la institución<h3>

                            <input type='text' class='form-control' readonly name="" id="" value="<?= $info['nombre_uni'] ?>">

                            <h3>Clave del grupo de investigación</h3>

                            <input type="text" class="form-control" readonly name="" id="" value="<?= $info['cuerpo_academico'] ?>"><br>

                            <?php

                        }

                        ?>

                        <h3>Colaboración con la red</h3>

                        <div class="row text-center">
                            <div class="col-md-12">
                            <img class="imgRed" src="<?= base_url("resources/img/isotipos/Mapa_" . $info['red'] . ".png"); ?>" style="width:10%" 
                            alt="<?= $info['red'] ?>" title="<?= $info['red'] ?>"   />
                            <label><?= $info['red'] ?></label>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>

                <button type="buttton" onclick="location.href='<?php echo base_url('constancias')?>';" class="btn btn-block btn-warning">Validar otro folio <i class="fas fa-undo-alt"></i></button>

                <button type="buttton" onclick="location.href='<?php echo base_url()?>';" class="btn btn-block btn-danger"><i class="fas fa-home" style="color: #fff;"></i> Regresar al inicio</button>

                </div>

            </div>

        </section>
        
    </div>

</body>

</html>