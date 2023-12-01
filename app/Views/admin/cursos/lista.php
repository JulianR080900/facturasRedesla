<div class="content-wrapper">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Listado del curso: <i><?= $nombre_curso ?>. 18a Edición</i></h4>
                    <div class="table-responsive">
                        <table class="table" id="dt_cursos">
                            <thead>
                                <tr>
                                    <th class="centered">ID</th>
                                    <th class="centered">Correo</th>
                                    <th class="centered">Nombre</th>
                                    <th class="centered">CURP</th>
                                    <th class="centered">Grado academico</th>
                                    <th class="centered">Actividad</th>
                                    <th class="centered">Area conocimiento</th>
                                    <th class="centered">Trabajo</th>
                                    <th class="centered">Telefono</th>
                                    <th class="centered">Pais</th>
                                    <th class="centered">Paquete</th>
                                    <th class="centered">Medio entero</th>
                                    <th class="centered">Factura</th>
                                    <th class="centered">Razon factura</th>
                                    <th class="centered">RFC</th>
                                    <th class="centered">CFDI</th>
                                    <th class="centered">Correo factura</th>
                                    <th class="centered">Calle factura</th>
                                    <th class="centered">Exterior Factura</th>
                                    <th class="centered">Interior factura</th>
                                    <th class="centered">CP factura</th>
                                    <th class="centered">Colonia factura</th>
                                    <th class="centered">Municipio factura</th>
                                    <th class="centered">Estado factura</th>
                                    <th class="centered">Pais factura</th>
                                    <th class="centered">Régimen fiscal</th>
                                    <th class="centered">Congreso</th>
                                    <th class="centered">Terminos</th>
                                    <th class="centered">Fecha</th>
                                    <th class="centered">Año curso</th>
                                    <th class="centered">Sexo</th>
                                    <th class="centered">Constancia</th>
                                    <th class="centered">Pago</th>
                                    <th class="centered">Formato DC-3</th>
                                    <th class="centered">Reenviar correo de inscripción</th>
                                    <th class="centered">Reenviar correo y DC-3</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_cursos">

                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="row">
                        <a href="../getCSVMoodle/<?= $id ?>/17ma" class="btn btn-block btn-rounded btn-success">Descargar CSV de usuarios que ya pagaron. 17ma edición</a>
                    </div>
                    <div class="row" style="padding-top: 10px;">
                        <button class="btn btn-block btn-rounded btn-info constancia_multiple" id="multiple_constancias">Otorgar constancias</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        let base_url = '<?= base_url() ?>';
        let id = '<?= $id ?>'
    </script>
    <script src="<?= base_url('resources/admin/datatables/cursos.js') ?>"></script>