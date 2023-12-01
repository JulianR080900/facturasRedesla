
<style>
    .svgImg{
        width: 100%;
    }
    .table th, .jsgrid .jsgrid-table th, .table td, .jsgrid .jsgrid-table td{
        white-space: break-spaces !important;
        line-height: 1.4rem !important;
    }
    .colImg{
        display: flex;
        align-items: center;
        align-content: center;
    }
    hr{
        background-color: #fff;
    }
</style>
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de horarios para congresos de <?= session('nombre') ?></h4>
                <hr>

                <?php
                foreach($congresos as $c){
                    ?>
                    <div class='row'>
                        <div class='col-md-4 colImg'>
                            <img src='<?= base_url('/resources/img/congresos/horarios_moderadores.svg') ?>' class='svgImg'>
                        </div>
                        <div class='col-md-8'>
                        <div class='form-group'>
                                <h2>Evento</h2>
                                <p><?= $c['congreso'] ?></p>
                            </div>
                            <div class='form-group'>
                                <h2>Horario</h2>
                                <p><?= $c['horario'] ?></p>
                            </div>
                            <div class='form-group'>
                                <h2>Salón</h2>
                                <p><?= $c['salon'] ?></p>
                            </div>
                            <div class='form-group'>
                                <h2>Zoom</h2>
                                <p><?= $c['zoom'] == '' ? 'No registrado': $c['zoom'] ?></p>
                            </div>
                            <div class='form-group'>
                                <h2>Ponencias a presentar</h2>
                                <?php
                                if(!isset($c['ponencias'])){
                                    ?>
                                    <h5 class='text-warning'>Sin ponencias registradas a este horario.</h5>
                                    <?php
                                    continue;
                                }
                                ?>
                                <table class='table table-striped table-dark text-secondary'>
                                    <thead class='thead-dark'>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre de la ponencia</th>
                                            <th>Ponente</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($c['ponencias'] as $p){
                                            ?>
                                            <tr>
                                                <td><?= $p['submission_id'] ?></td>
                                                <td><?= $p['ponencia'] ?></td>
                                                <td><?= $p['ponente'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <?php
                }
                ?>
                
            </div>
        </div>
    </div>
</div>