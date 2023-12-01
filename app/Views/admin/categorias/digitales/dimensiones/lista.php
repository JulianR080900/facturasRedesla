<style>
    .modal-body-escalas{
        padding: 1rem !important;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de dimensiones para libro digital 2022</h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_grupos">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Ver descripción</th>
                                <th class="centered">Ver escalas</th>
                                <th class="centered">Editar</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_grupos">

                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <a href="./agregar" class="btn btn-block btn-success">Agregar dimensión</a>
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

<div class="modal fade" id="myModalEscalas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Escalas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white">&times;</span>
                </button>
            </div>
            <div class="modal-body-escalas">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
    $(document).on("click", ".escalas", function() {
        var escalas = $(this).data('escalas');
        if(escalas == 'na'){
            $(".modal-body-escalas").empty();
            $(".modal-body-escalas").append('Sin escalas registradas.')
            return
        }
        const explode = escalas.split(';')
        let html = '';
        for (let index = 0; index < explode.length-1; index++) {
            let listado = parseInt(index)+1;
            html += `
            <h3>${listado}.- ${explode[index]}</h3>
            `
        }
        $(".modal-body-escalas").empty();
        $(".modal-body-escalas").append(html)
    });
</script>


<script>
    var base_url = '<?= base_url() ?>';
    $(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
<script src="<?= base_url('resources/admin/datatables/Nuria/gruposDigital.js') ?>"></script>