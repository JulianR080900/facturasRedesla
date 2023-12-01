<p style="text-align: right; padding-top: 40px;">San Juan del Río, Querétaro, a <?= $fecha_actual ?></p>

<b><?= $primer_autor ?></b><br>
<b><?= $universidad ?></b><br>
<b>PRESENTE</b> <br>

<p>
Apreciable investigador(a), reciba un cordial saludo por parte de la <b><?= $nombre_red ?> y la editorial iQuatro Editores.</b>
</p>

<p>
Agradecemos el envío en tiempo y forma de su trabajo de investigación para participar en 
el <b><?= $nombre_congreso ?>. <?= $red ?> <?= $anio ?></b>
</p>

<p>
Es un placer informarle que el trabajo de investigación enviado a la página de la editorial <a href="https://iquatroeditores.org/revista/index.php/iquatro/submissions">iQuatro Editores</a> con ID <b><?= $id ?></b>, titulado: “<b><?= $nombre_ponencia ?></b>” y elaborado por: <b><?= $autores ?></b>, ha sido ACEPTADO para ser presentado como PONENCIA del  <b><?= $nombre_congreso ?> <?= $red ?> <?= $anio ?></b>.
</p>

<p>
Dicho evento se llevará a cabo bajo <b>modalidad mixta</b> siendo de manera virtual dentro de nuestro 
espacio <b>"Vive REDESLA"</b>, y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: 
el <b><?= $sede ?></b>, quienes en conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece 
<b><?= strtoupper($red) ?></b>, llevarán a cabo la organización de este congreso
de investigación los días <b><?= $fechas ?></b>.
</p>

<p>
<b>Días previos al evento se le dará a conocer al ponente la fecha, hora y salón de las instalaciones físicas y/o
virtuales</b> del <b><?= $nombre_congreso ?> <?= $red ?> <?= $anio ?></b>,
donde llevará a cabo la presentación de su ponencia; por lo que con gusto esperamos verlos y contar con su
presencia realizando la ponencia correspondiente.
</p>

<p>
Así mismo le comunicamos que para iniciar con el proceso de arbitraje a doble ciego y obtener la aceptación de su publicación deberá
atender las solicitudes de la <i>editorial</i> <b>iQuatro Editores</b>; con la dictaminación a doble ciego se determinará si dicha ponencia cumple con los requisitos de publicación, ya sea como capítulo en el libro electrónico o como artículo en la 
<b>
<?php
if($red == 'RELEG'){
    echo 'Revista RELEP o Revista RELAYN ';
}else{
    echo 'Revista '.$red;
}
?>
</b>
. Es indispensable atender sus revisiones y enviarlas en tiempo y forma para dar continuidad a la publicación del trabajo.
</p>

<p>
Sin más por el momento agradecemos su atención y quedamos a sus órdenes para cualquier duda al respecto.
</p>

<?php
if($pagado == 0){
    ?>
    <p>PD: Se requiere el pago de la participación para continuar con el proceso. Una vez realizado, esta carta se actualizará.</p>
    <?php
}
?>

<div style="text-align:center">
    <b>A T E N T A M E N T E</b><br>
    <img src="<?= base_url('resources/img/firmas/PaulaMejia.jpg') ?>" alt="" style="width: 70px;" ><br>
    <b>Ing. Paula Mejia Avila</b><br>
    <b>Gerente administrativo</b>
</div>