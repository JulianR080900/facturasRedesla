<div class="tabla">
    <!--<div id="searchdiv" class="searchdiv" style="width: 60%;margin: auto;">-->
    <!--    <label for="s" class="assistive-text">Buscar</label>-->
    <!--    <input type="search" class="txt-search" placeholder="Buscar..." name="search" id="search" onkeyup="buscar_participante()">-->
    <!--</div>-->
    
    <br>
    <div class="container">
        <table style="margin: 0 auto;" class="display" id="asistencia">
        <thead>
            <tr>
                <th style="width: 100px;">ID</th>
                <th style="width: 400px;">Nombre</th>
                <th style="width: 200px;">Red</th>
                <th style="width: 200px;">Cuerpo académico</th>
                <th style="width: 200px;">Año</th>
                <th style="width: 200px;">Gafete</th>
                <th style="width: 200px;">Clave de ponencia</th>
                <th style="width: 200px;">Código de ponencia IQuatro</th>
                <th style="width: 200px;">Tipo de asistencia registrado</th>
                <th style="width: 200px;">Asistencia presencial</th>
                <th style="width: 200px;">Kit presencial</th>
                <th style="width: 200px;">Asistencia virtual</th>
                <th style="width: 200px;">Kit virtual</th>
            </tr>
        </thead>

        <tbody id="datos_participantes">
            
        </tbody>

    </table>
    </div>
</div>

<script>
    var base_url = '<?= base_url() ?>';
</script>