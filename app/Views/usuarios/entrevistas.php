<style>
    <?php
    foreach ($categorias as $c) {
        ?>
        .e_<?= $c['color'] ?>{
            color: #<?= $c['color'] ?>;
        }
        <?php
    }
    ?>
</style>
<div class="content">

    <h1>Entrevista # <?= $data["id"] ?></h1>

    <table class="display nowrap table table-dark" style="width:100%">

        <tbody>

            <tr>

                <th COLSPAN="2" class="text-center table-info" style='color:black'>DATOS GENERALES</th>

            </tr>

            <tr>

                <td>Nombre de la entrevistadora</td>

                <td><?php echo $data["nombre_entrevistadora"]; ?></td>

            </tr>

            <tr>

                <td>Lugar de la realización de la entrevista:</td>

                <td><?php echo $data["lugar_entrevista"]; ?></td>

            </tr>

            <tr>

                <td>Hora de aplicacion de la entrevista:</td>

                <td><?php echo $data["hora_aplicacion_inicio"]; ?></td>

            </tr>

            <tr>

                <td>Hora de aplicacion de la entrevista:</td>

                <td><?php echo $data["hora_aplicacion_final"]; ?></td>

            </tr>

            <tr>

                <td>Duración de la aplicación de la entrevista:</td>

                <td><?php echo $data["duracion_entrevista"]; ?></td>

            </tr>

            <tr>

                <td>Nombre de la entrevistada:</td>

                <td><?php echo $data["nombre_entrevistada"]; ?></td>

            </tr>

            <tr>

                <th COLSPAN="2" class="text-center table-info" style='color:black'>1ra PARTE: CARACTERÍSTICAS SOCIODEMOGRÁFICAS DE LA UNIVERSITARIA DIRECTORA O DUEÑA DE LA MYPE</th>

            </tr>

            <tr>

                <td>1. ¿Cuál es tu edad?</td>

                <td><?php echo $data["pregunta1"]; ?></td>

            </tr>

            <tr>

                <td>2. ¿Cuál es tu estado civil?</td>

                <td><?php echo $data["pregunta2"]; ?></td>

            </tr>

            <tr>

                <td>3. ¿Tienes hijos (as)?</td>

                <td><?php echo $data["pregunta3"]; ?></td>

            </tr>

            <tr>

                <td>3a. ¿Cuántos hijos (as) tienes?</td>

                <td><?php echo $data["pregunta4"]; ?></td>

            </tr>

            <tr>

                <td>4. ¿Qué carrera estás estudiando?</td>

                <td><?php echo $data["pregunta5"]; ?></td>

            </tr>

            <tr>

                <td>5. ¿Qué grado académico estás estudiando?</td>

                <td><?php echo $data["pregunta6"]; ?></td>

            </tr>

            <tr>

                <td>6. ¿En qué tipo de ciclo estudias?</td>

                <td><?php echo $data["pregunta7"]; ?></td>

            </tr>

            <tr>

                <td>7. ¿En qué número de semestre, cuatrimestre, año te encuentras?</td>

                <td><?php echo $data["pregunta8"]; ?></td>

            </tr>

            <tr>

                <th COLSPAN="2" class="text-center table-info" style='color:black'>2da PARTE: DATOS DE LA INSTITUCIÓN</th>

            </tr>

            <tr>

                <td>8. Nombre completo de la institución:</td>

                <td><?php echo $data["pregunta9"]; ?></td>

            </tr>

            <tr>

                <td>9. Estado al que pertenece:</td>

                <td><?php echo $data["pregunta10"]; ?></td>

            </tr>

            <tr>

                <td>10. Municipio al que pertenece:</td>

                <td><?php echo $data["pregunta11"]; ?></td>

            </tr>

            <tr>

                <td>11. ¿Tu institución es Pública o privada?:</td>

                <td><?php echo $data["pregunta12"]; ?></td>

            </tr>

            <tr>

                <th COLSPAN="2" class="text-center table-info" style='color:black'>3ra PARTE: CARACTERÍSTICAS DE LA MYPE.</th>

            </tr>

            <tr>

                <td>12. ¿Cuál es el año de inicio de operaciones de tu micro o pequeña empresa?:</td>

                <td><?php echo $data["pregunta13"]; ?></td>

            </tr>

            <tr>

                <td>13. ¿Cuántas personas trabajan permanente en tu empresa actualmente?</td>

                <td><?php echo $data["pregunta14"]; ?></td>

            </tr>

            <tr>

                <td>14. ¿Cuántas mujeres trabajan permanente en tu empresa actualmente?</td>

                <td><?php echo $data["pregunta15"]; ?></td>

            </tr>

            <tr>

                <td>15. ¿Cuántos familiares trabajan permanente en tu empresa actualmente?</td>

                <td><?php echo $data["pregunta16"]; ?></td>

            </tr>

            <tr>

                <td>16. ¿Cuál es el sector económico que mejor describe la actividad/giro de tu empresa?</td>

                <td><?php echo $data["pregunta17"]; ?></td>

            </tr>

            <tr>

                <td>17.¿Cuál es la modalidad en la que trabaja tu empresa? ¿física, virtual o mixta?</td>

                <td><?php echo $data["pregunta18"]; ?></td>

            </tr>



            <tr>

                <th COLSPAN="2" class="text-center table-info" style='color:black'>4ta PARTE: SOBRE LOS OBSTÁCULOS</th>

            </tr>

            <tr>

                <td>18. ¿Para ti ha sido difícil ser directora de empresa y estudiante al mismo tiempo?</td>

                <td><?php echo $data["pregunta19"]; ?></td>

            </tr>

            <tr>

                <td>19. Platícame por favor, ¿qué te motivó a ser dueña de una empresa o tomar la responsabilidad de dirigir una empresa?</td>

                <td><?php echo $data["pregunta20"]; ?></td>

            </tr>

            <tr>

                <td>20. Ahora cuéntame, ¿que fue lo que te motivó a estar estudiando una carrera universitaria?</td>

                <td><?php echo $data["pregunta21"]; ?></td>

            </tr>

            <tr>

                <td>21. Desde tu experiencia dime, ¿qué ha sido más difícil para ti? ¿Ser directora de empresa o ser estudiante universitaria?</td>

                <td><?php echo $data["pregunta22"]; ?></td>

            </tr>

            <tr>

                <td>22. Me podrías platicar por favor, ¿cuáles han sido los obstáculos a los cuáles te has enfrentado en la gestión de tu empresa?</td>
                <!-- Esta pregunta se trabaja en el digital -->

                <td><?php echo $data["pregunta23"]; ?></td>

            </tr>

            <tr>

                <td>23. Me podrías comentar por favor, ¿cuáles han sido los obstáculos a los cuáles te has enfrentado en tu formación académica?</td>

                <td><?php echo $data["pregunta24"]; ?></td>

            </tr>

            <tr>

                <td>24. ¿Cómo has hecho para resolver estos obstáculos que me has mencionado?</td>

                <td><?php echo $data["pregunta25"]; ?></td>

            </tr>

        </tbody>

    </table>

    <?php
    if($validacion == 2 || $validacion == 7 || $validacion == 8 || $validacion == 9){
        ?>
        <hr>
        <h1>Lista de categorías</h1>
        <!--INSTRUCCIONES-->
        <table class="table table-dark text-center" style="width: 100%;">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Código</th>
                    <th>Ver definición</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($categorias as $c) {
                ?>
                    <tr>
                        <td><?= $c['nombre'] ?></td>
                        <td><i class="fa-solid fa-circle" style="color: #<?= $c['color'] ?>"></i></td>
                        <td><i class="fas fa-info-circle" style="color: #ffbb33; font-size: 15px" data-toggle="popover" data-content="<?= $c['descripcion'] ?>"></i></label></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <hr>
        <h1>Añadir categoría</h1>
        <!--INSTRUCCIONES-->
        <form action="<?= base_url('addCategoria') ?>" method="post">
        <label for="">Seleccione una categoría</label>
        <select class="form-control" name="categoria" required>
            <option selected="" disabled="" value="">Selecciona una categoría</option>
            <?php
            foreach($categorias as $c){
                ?>
                <option value="<?= $c['id'] ?>"><?= $c['nombre'] ?></option>
                <?php
            }
            ?>
        </select>
        <br>
        <label for="">Código en vivo</label>
        <textarea name="codigo_en_vivo" class="form-control" id="cev" rows="5" required minlength="100" maxlength='280' onvalid="this.setCustomValidity('El codigo debe ter mínimo 100 caracteres y máximo 280.')"></textarea>
        <input type="text" name="id_entrevista" hidden value="<?= $data['id'] ?>">
        <input type="text" name="claveCuerpo" hidden value="<?= $_SESSION['CA'] ?>">
        <hr>
        <!-- <h6 class="text-warning">El tiempo de categorización ha finalizado</h6> -->
        <button type="submit" class="btn btn-block btn-success">Ingresar categoría</button>
        </form>
        <hr>
        <h1>Eliminar código en vivo</h1>
        <p>
        Si usted categorizó de manera incorrecta un código en vivo, seleccione el código en vivo incorrecto de la lista y dé clíc en <b class="text-danger">Eliminar código en vivo</b>
        </p>
        <form action="<?= base_url('/eliminar_cev') ?>" method="post">
        <select name="id" id="" required class="form-control">
            <option value="" selected disabled>Seleccione el código en vivo a eliminar</option>
            <?php
            foreach($filtro_categorias as $f){
                ?>
                <option value="<?= $f['id'] ?>"><?= $f['codigo_en_vivo'] ?></option>
                <?php
            }
            ?>
        </select>
        <br>
        <!-- <h6 class="text-warning">El tiempo de categorización ha finalizado</h6> -->
        <button type="submit" class="btn btn-block btn-danger">Eliminar código en vivo</button>
        </form>
        <?php
    }
    ?>
    
    <hr>
    <button onclick="self.close()" class="btn btn-block bg-<?= $_SESSION['red'] ?>"><i class="fa-solid fa-caret-left"></i> Regresar</button>
    <br><br>

</div>


    </div>
