<style>
    b{
        color: <?= $color_red ?>;
    }
</style>
<p>
    Apreciable investigador(a) <b><?= $primer_autor ?></b>, reciba un cordial saludo por parte de la <b><?= $nombre_red ?></b>.
</p>

<p>
    Por medio del presente le agradecemos el envío en tiempo y forma de su trabajo de investigación

    y a nombre del <b>Comité Técnico Académico</b>, le informamos que su ponencia `<b><?= $nombre_ponencia ?></b>` ha sido ACEPTADA

    para ser presentada en el <b><?= empty($marco) ? $nombre_congreso : $nombre_congreso . ' en el marco del ' . $marco ?></b>.

    <i>Se adjunta carta de aceptación-ponencia.</i>
</p>

<p>
    Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestra plataforma '<b>Vive REDESLA</b>',

    teniendo como institución anfitriona: la <b><?= $sede ?></b>, quienes en conjunto con

    <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><?= strtoupper($red) ?></b>, llevarán a cabo la organización de este congreso

    de investigación, los días <b><?= $fechas ?></b>.
</p>

<p>
    Puede consultar nuestro programa general en: <a href='<?= $url_programa ?>'><?= $url_programa ?></a>
</p>

<p>
    Déjanos tu 👍 y mantente actualizado.
</p>

<p>
<?php
if(!empty($comentarios)){
    ?>
    <p><?= $comentarios ?></p>
    <?php
}
?>
</p>

<h2>PRÓXIMOS PASOS</h2>

<p>
    Podrá cubrir a más tardar el <?= $fecha_limite_pago ?> del presente año la <b>tarifa de

    participación</b> por la cantidad de <b>$<?= number_format($proyecto['montoMx'], 0, '.', ',') ?> <?= $proyecto['monto_escritoMx'] ?></b>

    IVA incluido por ponencia, para los participantes

    fuera de México es de <b>$<?= $proyecto['montoUs'] ?> USD <?= $proyecto['monto_escritoUs'] ?></b>

    IVA incluido por ponencia, esta puede ser de <?= $min ?> a máximo <?= $max ?> autores.
</p>

<?php
// Fecha en formato YYYY-MM-DD
$fecha = $proyecto['fecha_limite_prontoPago'];

// Obtener el día, mes y año
$dia = substr($fecha, 8, 2);
$mes = substr($fecha, 5, 2);
$anio = substr($fecha, 0, 4);

// Array con los nombres de los meses en español
$meses = array(
    '01' => 'enero',
    '02' => 'febrero',
    '03' => 'marzo',
    '04' => 'abril',
    '05' => 'mayo',
    '06' => 'junio',
    '07' => 'julio',
    '08' => 'agosto',
    '09' => 'septiembre',
    '10' => 'octubre',
    '11' => 'noviembre',
    '12' => 'diciembre'
);

// Formatear la fecha en español
$fechaEspañol = $dia . ' de ' . $meses[$mes] . ' de ' . $anio;
?>

<?php
if($red != 'RELEG'){
    ?>
    <p>
    Podrán aprovechar los <b>descuentos de pronto pago</b> hasta el

    <b><?= $fechaEspañol ?></b>, obteniendo una tarifa de participación por la cantidad de: <b>$<?= number_format($proyecto['precio_prontoPagoMx'], 0, '.', ',') ?>

<?= $proyecto['precio_prontoPagoEscritoMx'] ?></b> IVA incluido por ponencia, para los

    participantes fuera de México será de <b>$<?= $proyecto['precio_prontoPagoUs'] ?> USD: <?= $proyecto['precio_prontoPagoEscritoUs'] ?></b>

    IVA incluido por ponencia, esta puede ser de <?= $min ?> a máximo <?= $max ?> autores.
</p>
    <?php
}
?>

<p>
Los participantes de México podrán realizar el pago mediante <b>transferencia interbancaria</b> desde su banca móvil a <b>Grupo REDESLA</b> con RFC <b>GRE230221H2A</b> en la cuenta bancaria <b>65509756427</b> del banco SANTANDER con CLABE interbancaria <b>0146 8565 5097 5642 76</b> o bien en depósito desde OXXO al número de tarjeta <b>5579 0890 0446 0880</b>. Para pago en OXXO, sólo podrá utilizar la tarjeta no la cuenta ni la clabe interbancaria.
</p>


<p>
Los participantes que radiquen fuera de  México recibirán la solicitud de pago mediante un enlace de <b>PayPal</b> a su correo electrónico o WhatsApp por su promotor RedesLA y podrán realizarlo vía internet de acuerdo a las políticas de sus bancos, o bien  en caso de no haber recibido la solicitud podrá ejecutarlo desde este link: <a href="https://paypal.me/GRUPOREDESLA?country.x=MX&locale.x=es_XC">https://paypal.me/GRUPOREDESLA?country.x=MX&locale.x=es_XC</a><br>
También podrá realizarlo por  <b>transferencia interbancaria</b> desde su banca móvil o depósito bancario a <b>Grupo REDESLA</b> con RFC <b>GRE230221H2A</b> en la cuenta bancaria <b>65509756427</b> del banco SANTANDER con Código SWIFT <b>BMSXMXMMXXX</b> y CLABE interbancaria <b>0146 8565 5097 5642 76</b>.
</p>

<p>
    <i>Recuerde colocar el en concepto su ID del artículo-<?= $tipo_evento ?> <?= strtoupper($red) ?>.</i>
</p>

<h2>REGISTRO DE PAGO Y GENERACIÓN DE CLAVE DE PONENCIA</h2>

<p>Para poder registrar su ponencia es necesario que siga los siguientes pasos:</p>

<h3>1.- Acceso y registro del proyecto</h3>

<p>

<ul>

    <li>Ingresar a la plataforma <a href='<?= base_url() ?>'><?= base_url() ?></a></li>

    <li>Sus accesos serán su correo electrónico personal de cada integrante. Revise correo de registro con sus accesos.</li>

    <li>Seleccionar congreso (logo de red <b><?= strtoupper($red) ?></b>)</li>

    <li>Ir al apartado de <b>Pagos</b></li>

    <li>Seleccionar un <b>Proyecto (tipo de participación)</b> y dar clic en <b>Agregar proyecto</b></li>

    <li>Cerrar sesión y volver a iniciar sesión para visualizar el cambio.</li>

    <li>Dar clic en el apartado de <b>Proyectos</b> y agregar el pago correspondiente. Puede solicitar su factura en la seccion de <b>Facturas</b></li>

</ul>

<h1 style="text-align: center;">La contraseña de su ponencia es: <u><?= $password ?></u></h1>

</p>

<h3>2.- Registro de ponencia y generación de gafetes</h3>

<p>

<p>Ver manual de siguiente paso en: <a href="https://drive.google.com/file/d/1CdhpLOsiqQ8BmKtbTzVjfdkzYU9DkT-q/view?usp=sharing">https://drive.google.com/file/d/1CdhpLOsiqQ8BmKtbTzVjfdkzYU9DkT-q/view?usp=sharing</a> </p>
<ol>

    <li>Para generarlos, tendrá que dirigirse a la sección de <b>Proyectos</b>,

        seleccionando el congreso, utilizando como contraseña de ponencia: <b><u><?= $password ?></u></b>. Si no visualiza el proyecto de <?= strtolower($tipo_evento) ?>, cierre sesión y acceda nuevamente.</li>

    <li>Una vez ingresada, dar clic en <b>Buscar</b> (Si la contraseña es incorrecta le mandara una alerta de clave incorrecta,

        favor de verificar su correcta escritura y verificar que no tenga espacios. Si el problema persiste, favor de

        contactar al siguiente correo: jaramosp@red.redesla.la o bien diríjase a su promotor)</li>

    <li>Una vez aceptada la clave por el sistema, le mostrará los datos de su ponencia como:

        su nombre y los datos de los integrantes. Estos los podrá modificar dando clic en el recuadro

        amarillo que tiene al lado del campo que quiere editar (los datos modificados aquí se verán

        reflejados también en la plataforma iQuatro). <b>Si no aparecen todos sus autores es importante

            que no siga el proceso y envíe los datos faltantes mediante la sección de discusiones en su

            envío de iQuatro</b>. Es indispensable seleccionar al ponente para que los moderadores puedan llamarlo,

        así como leer y aceptar las condiciones para solicitar la constancia de participación-asistencia

        en el evento.

    </li>

    <li>Una vez verificados sus datos (que se encuentren todos los autores, que no tenga

        faltas de ortografía) de clic en el botón de Registrar. Una vez realizado este proceso,

        su ponencia ha sido agregada correctamente para participar en el <b><?= $nombre_congreso ?></b>.</li>

    <li>La página se recargará automáticamente y le mostrará las claves de gafete de los

        integrantes de la ponencia. Las claves de gafete servirán para poder ingresar al congreso

        de manera VIRTUAL o PRESENCIAL. Por lo que es importante que cada integrante la tenga a

        su disposición el día del evento. </li>

</ol>
</p>

<p>
    * En el caso de registrar 2 o mas ponencias, una vez que se haya registrado una de ellas le dará las claves de gafete

    de la ponencia registrada y a su vez le dará el mismo formulario para registrar una más. Las claves de gafete son

    independientes a la ponencia registrada por lo que tendrá 2 o mas claves de gafete que deberá presentar el día del evento.<br>

    ** Las constancias estarán disponibles en un lapso de 24 a 48 horas después del evento.
</p>

<h2>PRESENTACIÓN DE PONENCIA</h2>

<p>
    Para ver más detalles podrá consultar la convocatoria en la sección <i>d) Presentación de ponencia</i>,

    la estructura de presentación de ponencia será con el mismo esquema y contenido que el que se

    muestra en la “plantilla de trabajo”, pero de manera sintetizada con formato Power Point.

    La duración de las ponencias es de <i>15 minutos: 10 minutos de presentación y 5 minutos de

        preguntas y respuestas.</i>
</p>

<p>
<ol>

    <li>Ponencia presencial</li>

    <ul>

        <li>Días previos al evento se le dará a conocer al ponente la fecha, hora y salón de las instalaciones

            físicas y/o virtuales del <?= $nombre_congreso ?>.

        </li>

    </ul>

    <li>Ponencia virtual (en tiempo real)</li>

    <ul>

        <li>Días previos al evento se le dará a conocer al ponente la fecha, hora y salón de las instalaciones

            físicas y/o virtuales del <?= $nombre_congreso ?>.

        </li>

    </ul>

    <li>Ponencia grabada (enviada días previos):</li>

    <ul>

        <li>En caso de no poderse conectar en tiempo real o asistir físicamente, en esta

            modalidad también se hará la presentación de los videos de las ponencias en la mesa de

            trabajo correspondiente con investigadores especialistas en el área.</li>

    </ul>

</ol>
</p>

<h2>SOBRE LA PUBLICACIÓN</h2>

<p>
    
Para iniciar con el proceso de arbitraje a doble ciego y obtener la aceptación de su publicación 

deberá atender las solicitudes de la editorial iQuatro 

Editores, con la dictaminación a doble ciego se determinará si dicha ponencia cumple con los requisitos 
de publicación, ya sea como capítulo en el libro electrónico o como artículo en la Revista <?= strtoupper($red) ?>. 
Es indispensable atender sus revisiones y enviarlas en tiempo y forma para dar continuidad a la 
publicación del trabajo. <br>

Para consultar y darle seguimiento a su propuesta, ingresé a <a href='https://iquatroeditores.org/revista/' target="_blank">Entrar | 

Libros IQuatro (iquatroeditores.org)</a>
</p>

<h2>MANTENTE CONECTADO</h2>

<p>
Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle 'like' a nuestra

página de Facebook para estar actualizado de todas las actividades a realizar:

<a href='<?= $facebook ?>' target="_blank"><?= $facebook ?></a>

</p>

<p>
    
Esperamos verlos y contar con su presencia realizando la ponencia 

correspondiente y asistiendo a las actividades de nuestro <b><?= $nombre_congreso ?></b>
</p>

<p>
#PasiónPorLaInvestigación
</p>

<p>
Nos ponemos a sus órdenes para cualquier duda o aclaración:<br>

Correo: <?= strtolower($red) ?>@redesla.la<br>

WhatsApp: <a href="<?= $whatsapp ?>" target="_blank"><?= $whatsapp ?></a>  <br>

Teléfonos: 4271067882 y 4271389926 
</p>

<p>
    <img src="<?= base_url('resources/img/firmas/').'/'.ucfirst(strtolower($red)).'.jpeg' ?>" alt="" width="350px" height="90px">
</p>