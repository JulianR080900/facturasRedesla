<h1>Bitácora de campo. Entrevista #<?= $bitacora['id_entrevista'] ?></h1>
<hr>
<textarea name="" id="" cols="15" rows="20" readonly><?= $bitacora['bitacora'] ?></textarea>
<hr>
<?php
if($bitacora['siguiente'] != ''){
    echo '<a class="btn btn-success btn-block" href="'.$bitacora['siguiente'].'">Ir a la siguiente bitacora <i class="mdi mdi-arrow-right-drop-circle"></i></a>';
}else{
    echo '<button class="btn btn-success btn-block disabled">No hay bitacora siguiente</button>';
}

if($bitacora['anterior'] != ''){
    echo '<a class="btn btn-warning btn-block" href="'.$bitacora['anterior'].'"><i class="mdi mdi-arrow-left-drop-circle"></i> Ir a la siguiente bitacora</a>';
}else{
    echo '<button class="btn btn-warning btn-block disabled">No hay bitacora anterior</button>';
}
#FALTA BOTACORA
    echo '<a class="btn btn-danger btn-block" href="../ver/'.$bitacora['claveCuerpo'].'">Ir al listado de entrevistas <i class="mdi mdi-format-list-bulleted-type"></i></a>'
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
                                <th class="centered">Ver bitácora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($entrevistas as $e) {
                            ?>
                                <tr>
                                    <td class="centered"><?= $e['id'] ?></td>
                                    <td class="centered"><a href="<?= $e['id'] ?>" class="btn btn-info btn-rounded">Ver bitácora</a></td>
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
