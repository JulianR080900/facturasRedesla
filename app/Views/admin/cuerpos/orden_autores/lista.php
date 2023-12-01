<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de orden de autor</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table" id="dt_orden_autor">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Clave</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Orden Digital</th>
                                <th class="centered">Orden Impreso</th>
                                
                            </tr>
                        </thead>
                        <tbody id="dt_orden_autor">

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
                <h5 class="modal-title">Autores</h5>
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
    var base_url = '<?= base_url() ?>';

    $(document).on("click", ".autores", function() {
        var uno = $(this).data('autor_0');
        var dos = $(this).data('autor_1');
        var tres = $(this).data('autor_2');
        var cuatro = $(this).data('autor_3');

        var html = `
        <h3>Primer autor</h3>
        <p>`+uno+`</p>
        <h3>Segundo autor</h3>
        <p>`+dos+`</p>
        <h3>Tercer autor</h3>
        <p>`+tres+`</p>
        <h3>Cuarto autor</h3>
        <p>`+cuatro+`</p>
        `;
        $(".modal-body").empty()
        $(".modal-body").append(html);
    });
</script>
<script src="<?= base_url('resources/admin/datatables/ordenAutores.js') ?>"></script>