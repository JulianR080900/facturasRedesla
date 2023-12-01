<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de indices</h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_indices">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Capítulo</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Paginas</th>
                                <th class="centered">Autores</th>
                                <th class="centered">Editar</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_indices">

                        </tbody>
                    </table>
                </div>
                <hr>
                <button type="button" class="btn btn-block btn-success btn-rounded" data-toggle="modal" data-target="#exampleModal">Agregar capítulo</button>
                <a href="../../lista" class="btn btn-block btn-danger btn-rounded">Regresar a libros</a>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar capítulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddCap" action="./agregar" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <span>Numero capitulo:</span>
                        <input type="number" class="form-control" id="num_capitulo" name="num_capitulo" required>
                    </div>

                    <div class="form-group">
                        <span>Nombre:</span>
                        <input type="text" class="form-control" id="nombre_capitulo" name="nombre_capitulo" required>
                    </div>

                    <div class="form-group">
                        <span>Paginas:</span> <span class="text-warning">Ejemplo: 1-9</span>
                        <input type="text" class="form-control" id="paginas" name="paginas" required>
                    </div>

                    <div class="form-group">
                        <span>DOI</span>
                        <input type="text" class="form-control" id="doi" name="doi">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check_doi" data-val='doi' onchange="check_na(event);">
                            <label class="form-check-label" for="check_doi">
                                Este capítulo no tiene DOI.
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <span>Archivo</span>
                        <input type="file" class="form-control" id="archivo" name="archivo" accept="application/pdf">
                    </div>

                    <input type="text" value="<?= $id_libro ?>" id="id_libro" name="id_libro" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info">Agregar capítulo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".autores", function() {
        var uno = $(this).data('uno');
        var dos = $(this).data('dos');
        var tres = $(this).data('tres');
        var cuatro = $(this).data('cuatro');

        var html = `
        <h3>Primer autor</h3>
        <p>` + uno + `</p>
        <h3>Segundo autor</h3>
        <p>` + dos + `</p>
        <h3>Tercer autor</h3>
        <p>` + tres + `</p>
        <h3>Cuarto autor</h3>
        <p>` + cuatro + `</p>
        `;
        $("#myModal .modal-body").empty()
        $("#myModal .modal-body").append(html);
    });
    $(document).on("click", ".codigo", function() {
        var codigo = $(this).data('codigo');
        $(".modal-body").empty();
        $(".modal-body").append(codigo);
    });

    $(document).on('click', '.eliminarCap', function(e) {
        var id = $(this).data('id')

        Swal.fire({
            title: '¿Estas seguro que desea eliminar este capitulo?',
            html: '<p style="color:red">Esta accion NO es reversible</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminalo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "../eliminar",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        console.log(data);
                        if (data == 'error') {
                            Swal.fire(
                                'Lo sentimos!',
                                'Ha ocurrido un error al eliminar el capítulo. Contacte a sistemas',
                                'error'
                            )
                        } else if (data == 'success') {
                            Swal.fire(
                                'Éxito',
                                'Se ha eliminado el índice correctamente.',
                                'success'
                            )
                        }
                        initDataTable()
                    },
                });

            }
        });
    });

    $("#formAddCap").on('submit', function(e) {
        e.preventDefault()
        const form = e.target;
        const formData = new FormData(form);

        $.ajax({
            url: '../agregar', // Reemplaza 'URL_DEL_SERVIDOR' con la URL del servidor que manejará la solicitud
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Se ejecutará si la solicitud es exitosa
                Swal.fire({
                    icon: 'success',
                    title: 'Listo',
                    text: 'Capítulo insertado correctamente'
                }).then(function() {
                    $("#exampleModal").modal('hide')
                    initDataTable()
                })
            },
            error: function(xhr, status, error) {
                // Se ejecutará si hay algún error en la solicitud

                Swal.fire({
                    icon: 'error',
                    title: 'Error ' + xhr.status,
                    text: xhr.responseText
                }).then(function() {
                    $("#exampleModal").modal('hide')
                })
            }
        })

    })

    function check_na(e) {
        let id = e.target.dataset.val;
        let checkbox = $("#check_" + id)[0].checked;

        if (checkbox) {
            $("#" + id).val('NA').prop('readonly', true);
        } else {
            $("#" + id).val('').prop('readonly', false);
        }
        document.getElementById(id).dispatchEvent(keyupEvent);
    }
</script>



<script>
    var base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/indices.js') ?>"></script>