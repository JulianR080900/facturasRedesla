<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de cartas para investigaciones</h4>

                <div class="table-responsive">
                    <table class="table" id="dt_cartas_derechos">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Tipo</th>
                                <th class="centered">Obra</th>
                                <th class="centered">Red</th>
                                <th class="centered">Año</th>
                                <th class="centered">Archivo</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_inv">

                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <button type="button" class="btn btn-info btn-md btn-block addDerechos">Agregar/editar molde de carta</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalDerechos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subir carta de sesión de derechos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Instrucciones: ..</span>
                <form action="./subir" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Seleccione el tipo de carta</label>
                        <select name="tipo" id="tipo" class="form-control" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="derechos">Carta de sesión de derechos</option>
                            <option value="visto">Carta de visto bueno</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Seleccione una red</label>
                        <select name="red" id="red" class="form-control" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <?php
                            foreach ($redes as $r) {
                            ?>
                                <option value="<?= $r['nombre_red'] ?>"><?= $r['nombre_red'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Año de la carta</label>
                        <select name="anio" id="anio" class="form-control" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                            <option value="<?= date('Y') + 1 ?>"><?= date('Y') + 1 ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tipo de obra</label>
                        <select name="obra" id="obra" class="form-control" required>
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="impreso">Impresa</option>
                            <option value="digital">Digital</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Archivo molde</label>
                        <input type="file" name="molde" id="molde" accept=".docx" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-md btn-block">Subir archivo molde</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('resources/admin/datatables/investigaciones/cartas_derechos.js') ?>"></script>