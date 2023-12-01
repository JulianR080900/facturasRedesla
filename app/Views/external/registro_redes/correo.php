<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <style>
        #membretada {
            background-color: <?= $info_red['color_primario'] ?>;
        }

        h1,
        b,
        span {
            color: <?= $info_red['color_primario'] ?>;
        }
    </style>
    <div id="membretada" style="width: 100%; height: 3rem;"></div>

    <div style="display: flex; justify-content: center; gap: 3rem; margin-top: 1rem; margin-bottom: 1rem;">
        <img src="<?= base_url('/resources/img/logos_con_letras/Letras_Redesla.png') ?>" alt="Logotipo RedesLA" style="width: 30%;">
        <img src="<?= base_url('/resources/img/logos_con_letras/Letras_' . ucfirst($info_red['nombre_red']) . '.png') ?>" alt="Logotipo <?= ucfirst($info_red['nombre_red']) ?>" style="width: 30%;">
    </div>

    <div style="padding-left:1rem; padding-right: 1rem; text-align: justify;text-justify: inter-word;">
        <p>
            Apreciable investigador (a) <b><?= $grado_academico . ' ' . $nombre_miembro ?></b>, por medio del presente reciban
            un cordial saludo por parte de la <b><?= $info_red['significado'] . ' ' . strtoupper($info_red['nombre_red']) ?></b>.
        </p>
        <p>
            Nos servimos del mismo para hacer de su conocimiento que se ha realizado <b>exitosamente su registro</b>
            <?= $institucion['tipo_registro'] == 'oyente' ? 'como' : ($institucion['tipo_registro'] == 'investigación' ? 'para la' : 'para el') ?> <?= mb_strtoupper($institucion['tipo_registro'].' '.strtoupper($info_red['nombre_red']).' '.$anio ) ?>. Su información pasará por una <b>fase de revisión</b> con nuestro <i>equipo RedesLA</i>,
            por lo que por el momento no contará con acceso a la plataforma RedesLA: <a href="<?= base_url() ?>"><?= base_url() ?></a>.
            Tenga en cuenta que el <b>tiempo de revisión</b> es de <b>1 a 3 días hábiles</b>, no es necesario hacer otro registro.
        </p>
        <p>
            Los datos e información registrada es la siguiente, si alguno de estos datos requiere corrección,
            la puede hacer llegar respondiendo a <a href="mailto:atencion@redesla.la">este correo </a>
        </p>
        <p>
        <ul>
            <li>Nombre de la universidad / institución: <i><?= $institucion['nombre'] == 'NA' ? 'No pertenezco' : $institucion['nombre'] ?></i> </li>
            <li>Nombre de la autoridad (Rector/Director): <i><?= $institucion['rector'] ?></i> </li>
            <?php
            if($institucion['tipo_registro'] != 'oyente'){
                ?>
                <li>Dirección de la paquetería: <i><?= $institucion['direccion_paqueteria'] ?></i> </li>
                <?php
            }
            ?>
            <li>País: <i><?= $institucion['pais'] ?></i> </li>
            <li>Estado: <i><?= $institucion['estado'] ?></i> </li>
            <?php

            if($institucion['tipo_registro'] == 'investigación'){
                ?>
                <li>
                    Zona de estudio para investigación anual: <i> <?= $institucion['municipio'] ?></i>
                </li>
                <?php
            }

            ?>
            <?php

            if( ( ucfirst($info_red['nombre_red']) == 'Relep' || ucfirst($info_red['nombre_red']) == 'Releg' ) && $institucion['tipo_registro'] == 'investigación' ){
                ?>
                <li>Facultades o carreras a las que se aplicará el estudio: <?= $str_facultades ?> </li>
                <?php
            }

            ?>

            <?php

            if( ucfirst($info_red['nombre_red']) == 'Relen' && $institucion['tipo_registro'] == 'investigación' ){
                ?>
                <li>Especialidad: <?= $institucion['especialidad'] ?> </li>
                <?php
            }

            ?>
            <?php
            if($institucion['tipo_registro'] == 'oyente'){
                ?>
                <li>
                    Pre-registro de modalidad de asistencia al evento: <i> <?= $institucion['preAsistencia'] ?></i>
                </li>
                <?php
            }
            ?>
            
        </ul>
        </p>

        <h3>Grupo de investigación - autores:</h3>

        <div>
            <?php
            foreach ($miembros as $key => $m) {
            ?>
                <ul>
                    <li>Rol de participación: <?= $m['rol'] ?> </li>
                    <li>Nombre completo: <?= $m['nombre_completo'] ?> </li>
                    <li>Grado académico: <?= $m['grado_academico'] ?> </li>
                    <li>Especialidad: <?= $m['especialidad'] ?> </li>
                    <li>Número de teléfono: <?= $m['telefono'] ?> </li>
                    <li>Correo personal: <?= $m['correo_personal'] ?> </li>
                    <li>Correo institucional: <?= $m['correo_institucional'] ?> </li>
                </ul>
                <hr>
            <?php
            }
            ?>
        </div>

        <p>
            Tenga en cuenta que el <b>tiempo de revisión es de 1 a 3 días hábiles</b>, no es necesario hacer otro registro, por lo que
            por el momento no contará con acceso a la plataforma RedesLA: <a href="<?= base_url() ?>"><?= base_url() ?></a>.
            <i>Una vez aprobado el acceso <b>recibirá un correo de confirmación</b> con sus ACCESOS</i>.
        </p>

        <p>
            Nos reiteramos a sus órdenes para cualquier duda o aclaración, pronto nos pondremos en contacto con usted.
        <ul>
            <li>
                Correo (s): <?php
                            $explode = explode(';', $info_red['correos']);
                            foreach ($explode as $e) {
                            ?>
                    <a href="mailto:<?= $e ?>"><?= $e ?></a>
                <?php
                            }
                ?>
            </li>
            <li>WhatsApp: <a href="https://api.whatsapp.com/send?phone=52<?= $info_red['telefonos'] ?>"><?= $info_red['whatsapp'] ?></a> </li>
            <li>Teléfono (s): <a href="tel:<?= $info_red['telefonos'] ?>"><?= $info_red['telefonos'] ?></a></li>
        </ul>
        </p>

        <p>
            <img src="<?= base_url('/resources/img/firmas/' . ucfirst($info_red['nombre_red']) . '.jpeg') ?>" alt="Firma <?= $info_red['nombre_red'] ?>" width="300px" height="80px" style="border: 1px solid black;">
        </p>

        <h3>Mantenerse actualizado</h3>

        <p>
            Todos los comunicados de la red serán enviados vía correo electrónico y zona miembros, pero también lo invitamos a
            seguirnos en nuestras redes para estar al pendiente de las actividades o noticias del trabajo colaborativo.
        </p>
    </div>

    <div style="display: flex; justify-content: center; gap: 3rem;">
        <a target="_blank" href="<?= $info_red['facebook'] ?>"><img src="<?= base_url('/resources/img/attachments_correos/redes_sociales/facebook.png') ?>" alt="Logo Facebook" width="100px" height="100px"></a>
        <a target="_blank" href="<?= $info_red['instagram'] ?>"><img src="<?= base_url('/resources/img/attachments_correos/redes_sociales/instagram.png') ?>" alt="Logo Instagram" width="100px" height="100px"></a>
        <a target="_blank" href="<?= $info_red['tiktok'] ?>"><img src="<?= base_url('/resources/img/attachments_correos/redes_sociales/tiktok.png') ?>" alt="Logo Tiktok" width="100px" height="100px"></a>
        <a target="_blank" href="<?= $info_red['x'] ?>"><img src="<?= base_url('/resources/img/attachments_correos/redes_sociales/x.png') ?>" alt="Logo X" width="100px" height="100px"></a>
        <a target="_blank" href="<?= $info_red['youtube'] ?>"><img src="<?= base_url('/resources/img/attachments_correos/redes_sociales/youtube.png') ?>" alt="Logo Youtube" width="100px" height="100px"></a>
    </div>

    <div style="display: flex; align-items: center; justify-content:center;flex-direction:column;">
        <span style="font-size: 5rem; font-weight: 600;">Síguenos</span>
        <label style="font-size: 3rem; font-weight: 600;">.............................</label>
        <span style="font-size: 3rem; font-weight: 200;">En nuestras redes sociales</span>
    </div>



    <footer style="text-align: center; font-size: x-small;">
        Este correo no acepta respuestas de dudas, sólo corrección de datos con el equipo TI, para enviar la confirmación de su
        participación, resolver dudas o aclaraciones, dejamos a continuación los medios de contacto a través de los cuales les
        daremos la atención debida.
        <ul style="list-style: none;">
            <li>
                Correo (s): <?php
                            $explode = explode(';', $info_red['correos']);
                            foreach ($explode as $e) {
                            ?>
                    <a href="mailto:<?= $e ?>"><?= $e ?></a>
                <?php
                            }
                ?>
            </li>
            <li>WhatsApp: <a href="https://api.whatsapp.com/send?phone=52<?= $info_red['telefonos'] ?>"><?= $info_red['whatsapp'] ?></a> </li>
            <li>Teléfono (s): <a href="tel:<?= $info_red['telefonos'] ?>"><?= $info_red['telefonos'] ?></a></li>
        </ul>
    </footer>
</body>

</html>