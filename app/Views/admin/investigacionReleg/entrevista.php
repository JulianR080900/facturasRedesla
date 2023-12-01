<h1 style="padding-top: 10px;">Entrevista #<?= $entrevista['id'] ?></h1>
<hr>

<style>
    <?php
    foreach ($categorias as $c) {
    ?>.e_<?= $c['color'] ?> {
        color: #<?= $c['color'] ?>;
    }

    <?php
    }
    ?>
</style>

<table class="table table-dark">

    <tbody>

        <tr>

            <th COLSPAN="2" class="text-center table-info" style='color:white'>DATOS GENERALES</th>

        </tr>

        <tr>

            <td>Nombre de la entrevistadora</td>

            <td><?php echo $entrevista["nombre_entrevistadora"]; ?></td>

        </tr>

        <tr>

            <td>Lugar de la realización de la entrevista:</td>

            <td><?php echo $entrevista["lugar_entrevista"]; ?></td>

        </tr>

        <tr>

            <td>Hora de aplicacion de la entrevista:</td>

            <td><?php echo $entrevista["hora_aplicacion_inicio"]; ?></td>

        </tr>

        <tr>

            <td>Hora de aplicacion de la entrevista:</td>

            <td><?php echo $entrevista["hora_aplicacion_final"]; ?></td>

        </tr>

        <tr>

            <td>Duración de la aplicación de la entrevista:</td>

            <td><?php echo $entrevista["duracion_entrevista"]; ?></td>

        </tr>

        <tr>

            <td>Nombre de la entrevistada:</td>

            <td><?php echo $entrevista["nombre_entrevistada"]; ?></td>

        </tr>

        <tr>

            <th COLSPAN="2" class="text-center table-info" style='color:white'>1ra PARTE: CARACTERÍSTICAS SOCIODEMOGRÁFICAS DE LA UNIVERSITARIA DIRECTORA O DUEÑA DE LA MYPE</th>

        </tr>

        <tr>

            <td>1. ¿Cuál es tu edad?</td>

            <td><?php echo $entrevista["pregunta1"]; ?></td>

        </tr>

        <tr>

            <td>2. ¿Cuál es tu estado civil?</td>

            <td><?php echo $entrevista["pregunta2"]; ?></td>

        </tr>

        <tr>

            <td>3. ¿Tienes hijos (as)?</td>

            <td><?php echo $entrevista["pregunta3"]; ?></td>

        </tr>

        <tr>

            <td>3a. ¿Cuántos hijos (as) tienes?</td>

            <td><?php echo $entrevista["pregunta4"]; ?></td>

        </tr>

        <tr>

            <td>4. ¿Qué carrera estás estudiando?</td>

            <td><?php echo $entrevista["pregunta5"]; ?></td>

        </tr>

        <tr>

            <td>5. ¿Qué grado académico estás estudiando?</td>

            <td><?php echo $entrevista["pregunta6"]; ?></td>

        </tr>

        <tr>

            <td>6. ¿En qué tipo de ciclo estudias?</td>

            <td><?php echo $entrevista["pregunta7"]; ?></td>

        </tr>

        <tr>

            <td>7. ¿En qué número de semestre, cuatrimestre, año te encuentras?</td>

            <td><?php echo $entrevista["pregunta8"]; ?></td>

        </tr>

        <tr>

            <th COLSPAN="2" class="text-center table-info" style='color:white'>2da PARTE: DATOS DE LA INSTITUCIÓN</th>

        </tr>

        <tr>

            <td>8. Nombre completo de la institución:</td>

            <td><?php echo $entrevista["pregunta9"]; ?></td>

        </tr>

        <tr>

            <td>9. Estado al que pertenece:</td>

            <td><?php echo $entrevista["pregunta10"]; ?></td>

        </tr>

        <tr>

            <td>10. Municipio al que pertenece:</td>

            <td><?php echo $entrevista["pregunta11"]; ?></td>

        </tr>

        <tr>

            <td>11. ¿Tu institución es Pública o privada?:</td>

            <td><?php echo $entrevista["pregunta12"]; ?></td>

        </tr>

        <tr>

            <th COLSPAN="2" class="text-center table-info" style='color:white'>3ra PARTE: CARACTERÍSTICAS DE LA MYPE.</th>

        </tr>

        <tr>

            <td>12. ¿Cuál es el año de inicio de operaciones de tu micro o pequeña empresa?:</td>

            <td><?php echo $entrevista["pregunta13"]; ?></td>

        </tr>

        <tr>

            <td>13. ¿Cuántas personas trabajan permanente en tu empresa actualmente?</td>

            <td><?php echo $entrevista["pregunta14"]; ?></td>

        </tr>

        <tr>

            <td>14. ¿Cuántas mujeres trabajan permanente en tu empresa actualmente?</td>

            <td><?php echo $entrevista["pregunta15"]; ?></td>

        </tr>

        <tr>

            <td>15. ¿Cuántos familiares trabajan permanente en tu empresa actualmente?</td>

            <td><?php echo $entrevista["pregunta16"]; ?></td>

        </tr>

        <tr>

            <td>16. ¿Cuál es el sector económico que mejor describe la actividad/giro de tu empresa?</td>

            <td><?php echo $entrevista["pregunta17"]; ?></td>

        </tr>

        <tr>

            <td>17.¿Cuál es la modalidad en la que trabaja tu empresa? ¿física, virtual o mixta?</td>

            <td><?php echo $entrevista["pregunta18"]; ?></td>

        </tr>



        <tr>

            <th COLSPAN="2" class="text-center table-info" style='color:white'>4ta PARTE: SOBRE LOS OBSTÁCULOS</th>

        </tr>

        <tr>

            <td>18. ¿Para ti ha sido difícil ser directora de empresa y estudiante al mismo tiempo?</td>

            <td><?php echo $entrevista["pregunta19"]; ?></td>

        </tr>

        <tr>

            <td>19. Platícame por favor, ¿qué te motivó a ser dueña de una empresa o tomar la responsabilidad de dirigir una empresa?</td>

            <td><?php echo $entrevista["pregunta20"]; ?></td>

        </tr>

        <tr>

            <td>20. Ahora cuéntame, ¿que fue lo que te motivó a estar estudiando una carrera universitaria?</td>

            <td><?php echo $entrevista["pregunta21"]; ?></td>

        </tr>

        <tr>

            <td>21. Desde tu experiencia dime, ¿qué ha sido más difícil para ti? ¿Ser directora de empresa o ser estudiante universitaria?</td>

            <td><?php echo $entrevista["pregunta22"]; ?></td>

        </tr>

        <tr>

            <td>22. Me podrías platicar por favor, ¿cuáles han sido los obstáculos a los cuáles te has enfrentado en la gestión de tu empresa?</td>

            <td><?php echo $entrevista["pregunta23"]; ?></td>

        </tr>

        <tr>

            <td>23. Me podrías comentar por favor, ¿cuáles han sido los obstáculos a los cuáles te has enfrentado en tu formación académica?</td>

            <td><?php echo $entrevista["pregunta24"]; ?></td>

        </tr>

        <tr>

            <td>24. ¿Cómo has hecho para resolver estos obstáculos que me has mencionado?</td>

            <td><?php echo $entrevista["pregunta25"]; ?></td>

        </tr>

    </tbody>

</table>

<?php
if ($entrevista['siguiente'] != '') {
    echo '<a class="btn btn-success btn-block" href="' . $entrevista['siguiente'] . '">Ir a la siguiente entrevista <i class="mdi mdi-arrow-right-drop-circle"></i></a>';
} else {
    echo '<button class="btn btn-success btn-block disabled">No hay entrevista siguiente</button>';
}

if ($entrevista['anterior'] != '') {
    echo '<a class="btn btn-warning btn-block" href="' . $entrevista['anterior'] . '"><i class="mdi mdi-arrow-left-drop-circle"></i> Ir a la anterior entrevista</a>';
} else {
    echo '<button class="btn btn-warning btn-block disabled">No hay entrevista anterior</button>';
}
echo '<a class="btn btn-info btn-block" href="../bitacora/' . $entrevista['id'] . '">Ir a la bitacora <i class="mdi mdi-book-open-variant"></i></a>';

echo '<a class="btn btn-danger btn-block" href="../ver/' . $entrevista['claveCuerpo'] . '">Ir al listado de entrevistas <i class="mdi mdi-format-list-bulleted-type"></i></a>'
?>
<br>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de entrevistas</h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="entrevistas">
                        <thead>
                            <tr>
                                <th class="centered">ID entrevista</th>
                                <th class="centered">Ver entrevista</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($entrevistas as $e) {
                            ?>
                                <tr>
                                    <td class="centered"><?= $e['id'] ?></td>
                                    <td class="centered"><a href="<?= $e['id'] ?>" class="btn btn-info btn-rounded">Ver entrevista</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#entrevistas').DataTable();
    });
</script>

<style>
    .table th,
    .jsgrid .jsgrid-table th,
    .table td,
    .jsgrid .jsgrid-table td {
        white-space: unset !important;
    }
</style>