<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de categorías</h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_categorias">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Autor</th>
                                <th class="centered">Ver descripción</th>
                                <th class="centered">Ver código en vivo</th>
                                <th class="centered">Dimensión</th>
                                <th class="centered">Escala</th>
                                <th class="centered">Editar</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Rechazar</th>
                                <th class="centered">Aceptar</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_categorias">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Descripción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalGrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar dimensión de la categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white">X</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAct">
                    <span class="text-warning">Al actualizar la dimensión y aunque esta sea la misma, la escala se removerá y se tendra que asignar de nuevo.</span>
                    <div class="form-group">
                        <label for="">Seleccione la dimensión</label>
                        <select class='form-control' name='grupo' id='grupo' required>
                            <option selected disabled value=''>Seleccione una opcion</option>
                            <?php
                            foreach($grupos as $g){
                                ?>
                                <option value="<?= $g['id'] ?>"><?= $g['nombre'] ?></option>
                                <?php
                            }
                            ?>
                            <option value=''>Remover dimensión</option>
                        </select>
                    </div>
                    <input type="text" name="id" id="id" hidden>
                    <div class="form-group">
                        <button type="submit" id="submit" class="btn btn-success btn-rounded btn-block">Actualizar información</button>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEscala" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar escala</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white">X</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formActEscalas">
                    <div class="form-group">
                        <label for="">Seleccione una escala</label>
                        <select class='form-control' name='escala' id='escala' required>
                        </select>
                    </div>
                    <input type="text" name="id" id="id_escala" hidden>
                    <div class="form-group">
                        <button type="submit" id="submit" class="btn btn-success btn-rounded btn-block">Actualizar información</button>
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
    $(document).on("click", ".descripcion", function() {
        var descripcion = $(this).data('descripcion');
        $(".modal-body").empty();
        $(".modal-body").append(descripcion);
    });
    $(document).on("click", ".codigo", function() {
        var codigo = $(this).data('codigo');
        $(".modal-body").empty();
        $(".modal-body").append(codigo);
    });
</script>


<script>
    var base_url = '<?= base_url() ?>';
    $(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
<script src="<?= base_url('resources/admin/datatables/Nuria/categorias.js') ?>"></script>