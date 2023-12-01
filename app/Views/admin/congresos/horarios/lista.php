
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de horarios para congresos</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table" id="dt_horarios">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Nombre del congreso</th>
                                <th class="centered">Ver y editar horario</th>
                                <th class="centered">Editar aspectos generales</th>
                            </tr>
                        </thead>
                        <tbody id="dt_horarios">

                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <button class="btn btn-info btn-block btn-rounded" data-toggle='modal' data-target='#modalAgregarHorario' id="addHorario">Agregar horario</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar aspectos generales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white">X</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAct">
                    <div class="form-group">
                        <label for="">Nombre del evento</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="">Número de salones</label>
                        <p class="text-warning">Si el número de salones disminuye, las ultimas columnas de salones seran removidas, si se tiene información en esos campos, se perderán.</p>
                        <input type="number" class="form-control" name="salones" id="salones" required min='1'>
                    </div>
                    <div class="form-group">
                        <label for="">Número de horarios</label>
                        <p class="text-warning">Si el número de horarios disminuye, las ultimas filas de horarios seran removidas, si se tiene información en esos campos, se perderán.</p>
                        <input type="number" class="form-control" name="horarios" id="horarios" required min='1'>
                    </div>
                    <input type="text" name="id" id="id" hidden>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-rounded btn-block">Actualizar información</button>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgregarHorario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar horario de congreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white">X</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAdd">
                    <div class="form-group">
                        <label for="">Seleccione el horario</label>
                        <p class="text-warning">Los congresos que se muestran son los que estan actualmente activos en el módulo de <span class="text-info">Lista de congresos</span>. Agregue o modifique la información desde ahi. Recuerde que esa misma información de utiliza para las <span class="text-info">cartas de aceptación</span></p>
                        <select class="form-control" name="nombre" id="nombre_congreso" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <?php
                            foreach($congresos_activos as $c){
                                ?>
                                <option value="<?= $c['nombre'].'~'.$c['red'].'~'.$c['anio'] ?>"><?= $c['nombre'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Número de salones</label>
                        <input type="number" class="form-control" name="salones" id="salones" required min='1'>
                    </div>
                    <div class="form-group">
                        <label for="">Número de horarios</label>
                        <input type="number" class="form-control" name="horarios" id="horarios" required min='1'>
                    </div>
                    <div class="form-group">
                        <label for="">Seleccione el proyecto al que corresponde el horario</label>
                        <p class="text-warning">Seleccione el evento principal. Ejemplo: <u>Congreso</u> o <u>Coloquio</u></p>
                        <select class="form-control" name="id_proyecto" id="id_proyecto" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <?php
                            foreach($proyectos as $p){
                                ?>
                                <option value="<?= $p['id'] ?>"><?= $p['nombre'].' '.$p['redCueCa'].' '.$p['anio'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-rounded btn-block">Agregar congreso</button>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/congresos/horarios.js') ?>"></script>