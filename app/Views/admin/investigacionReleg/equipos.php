<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Equipos RELEG</h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_equiposReleg">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Universidad</th>
                                <th class="centered">Clave</th>
                                <th class="centered">Entrevistas</th>
                                <th class="centered">Carpetas</th>
                                <th class="centered">Ver mensajes</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Validar</th>
                                <th class="centered">Rechazar</th>
                                <th class="centered">Reenviar</th>
                                <th class="centered">Enviar correo</th>
                                <th class="centered">Ver categorización</th>
                                <th class="centered">Ver capítulo</th>
                                <th class="centered">Constancias</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_equiposReleg">

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
                <h5 class="modal-title">Mensaje</h5>
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

<script>
    $(document).on("click", ".dropdownMessage", function() {
        var mensaje = $(this).data('message');
        $(".modal-body").empty();
        $(".modal-body").append(mensaje);
        // As pointed out in comments, 
        // it is unnecessary to have to manually call the modal.
        // $('#addBookDialog').modal('show');
    });
</script>


<script>
    const base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/Nuria/equiposReleg.js') ?>"></script>