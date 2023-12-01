<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Cuerpos académicos</h4>
                <div class="row">
                    <a href="./descargas/direcciones" class="btn btn-md btn-info">Descargar dirección de envios de equipos</a>
                </div>
                <div class="table-responsive">
                    <table class="table" id="dt_cuerpos">
                        <thead>
                            <tr>
                                <th class="centered">Medio de entero</th>
                                <th class="centered">ID</th>
                                <th class="centered">Red</th>
                                <th class="centered">Clave</th>
                                <th class="centered">Universidad</th>
                                <th class="centered">Zona de estudio</th>
                                <th class="centered">Líder</th>
                                <th class="centered">Tipo de inscripción</th>
                                <th class="centered">Teléfono</th>
                                <th class="centered">Correo</th>
                                <th class="centered">Correo Institucional</th>
                                <th class="centered">Prodep</th>
                                <th class="centered">Rector</th>
                                <th class="centered">Grado del rector</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Editar</th>
                                <th class="centered">Cambio de miembros <?= date('Y') ?></th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_cuerpos">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('resources/admin/datatables/cuerpos_academicos.js') ?>"></script>