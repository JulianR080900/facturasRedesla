<style>
    .btnCartaDerechos:hover{
        background: black !important;
        border-color: black !important;
        content: '';
    }
    .btnCartaDerechos:hover:before {
        content:"Cambiar/ingresar ";
    }
    iframe{
        width: 100%;
        height: 50rem;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de Equipos</h4>

                <div class="row">
                    <div class="col-sm-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Cantidad de equipos con encuestas registradas</h5>
                                <div class="row">
                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $c_cuerpos ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-worker text-primary ml-auto"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Cantidad de encuestas registradas</h5>
                                <div class="row">
                                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $c_encuestas ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-book text-danger ml-auto"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas validas</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_1 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-check-circle text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas incompletas</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_2 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class=" icon-lg mdi mdi-alert text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas no validas</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_3 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class=" icon-lg mdi mdi-block-helper text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas recapturables</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_4 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class=" icon-lg mdi mdi-backup-restore text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas de prueba</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_5 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class=" icon-lg mdi mdi-test-tube text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5>Encuestas sin revisión</h5>
                                <div class="row">
                                    <div class="col-2 col-sm-6 col-xl-8 my-auto">
                                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                                            <h2 class="mb-0"><?= $estado_0 ?></h2>
                                        </div>
                                    </div>
                                    <div class="col-2 col-sm-12 col-xl-4 text-center text-xl-right">
                                        <i class="icon-lg mdi mdi-color-helper text-secondary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <h3>Descargas</h3>
                </div>
                <div class="row buttonsDescargas">
                    <a href="./descargas/equipos/<?= $nombre_tabla ?>" class="btn btn-success btn-md">Descargar equipos de la investigación <i class="mdi mdi-format-list-bulleted"></i></a>
                    <a href="./descargas/orden_autores" class="btn btn-success btn-md">Descargar orden de autores <i class="mdi mdi-format-list-bulleted"></i></a>
                    <a href="./descargas/encuestas/<?= $nombre_tabla ?>" class="btn btn-success btn-md">Descargar CSV de todas las encuestas</a>
                    <a href="./descargas/encuestasValidas/<?= $nombre_tabla ?>" class="btn btn-success btn-md">Descargar CSV de todas las encuestas válidas (BD1)</a>
                    <a href="./descargas/archivos" class="btn btn-success btn-md">Descargar todos los archivos de los equipos</a>
                    <a href="./descargas/bd2/impreso" class="btn btn-success btn-md">Descargar BD2 (obra impresa)</a>
                    <a href="./descargas/bd2/digital" class="btn btn-success btn-md">Descargar BD2 (obra digital)</a>
                </div>

                <div class="row">
                    <h3>Cartas</h3>
                </div>
                <div class="row buttonsDescargas">
                    <a href='../../cartas/derechos' class="btn <?= $is_cartaDerechos ? 'btn-warning':'btn-danger' ?> btn-md btnCartaDerechos"><?= $is_cartaDerechos ? 'Carta de sesión de derechos registrada' : 'Carta de sesión de derechos sin registrar' ?></a>
                </div>

                <div class="row">
                    <h3>Subir archivos impresos</h3>
                </div>
                <div class="row buttonsDescargas">
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modalCapsImpresos">Subir capitulos preliminares impresos</button>
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modalCapsImpresosFinales">Subir capitulos finales impresos</button>
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modalCapsAgradecimientosImpreso">Subir agradecimientos/indices impresos</button>
                </div>

                <div class="row">
                    <h3>Subir archivos digitales</h3>
                </div>
                <div class="row buttonsDescargas">
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modalCapsDigitales">Subir capitulos preliminares digitales</button>
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modalCapsDigitalesFinales">Subir capitulos finales digitales</button>
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modalCapsAgradecimientosDigital">Subir agradecimientos/indices digitales</button>
                </div>

                <div class="table-responsive">
                    <label for="" class="text-warning">Solo se puede buscar por clave de la universidad.</label>
                    <table class="table" id="dt_inv">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Clave de institución</th>
                                <th class="centered">Esquema</th>
                                <th class="centered">Encuestas</th>
                                <th class="centered">Fase actual impreso</th>
                                <th class="centered">Estado de impreso</th>
                                <th class="centered">Fase actual digital</th>
                                <th class="centered">Estado de digital</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_inv">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCapsImpresos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subir capitulos preliminares impresos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Instrucciones: Dentro de este apartado se podran subir los capitulos preliminares para cada equipo. <span class="text-warning">Es importante subir el archivo con la clave del grupo <b>EN MAYUSCULAS</b></span>. Para seleccionarlos, de clic en el recuadro de abajo y se abrirá su explorador de archivos, podra seleccionar todos los capitulos que desea subir. Una vez seleccionados los capítulos de clic en abrir en el explorador de archivos, a continuación se empezarán a subir los archivos uno por uno. <span class="text-warning">Favor de esperar a que todos los archivos se hayan cargado para cerrar este vantana</span>.</span>
                <br>
                <span><span class="text-danger">Importante</span> Si el nombre del archivo ya se encuentra en el sistema, el archivo sera remplazado por la nueva versión, por lo que tambien funciona como actualización de los archivos.</span>
                <div class="wrapper">
                    <form action="#" id="formUploadImpreso">
                        <input class="file-input" type="file" name="file" hidden multiple>
                        <i class="mdi mdi-cloud-upload"></i>
                        <p>Abrir explorador de archivos para cargar</p>
                    </form>
                    <section class="progress-area"></section>
                    <section class="uploaded-area"></section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCapsDigitales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subir capitulos preliminares digitales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Instrucciones: Dentro de este apartado se podran subir los capitulos preliminares para cada equipo. <span class="text-warning">Es importante subir el archivo con la clave del grupo <b>EN MAYUSCULAS</b></span>. Para seleccionarlos, de clic en el recuadro de abajo y se abrirá su explorador de archivos, podra seleccionar todos los capitulos que desea subir. Una vez seleccionados los capítulos de clic en abrir en el explorador de archivos, a continuación se empezarán a subir los archivos uno por uno. <span class="text-warning">Favor de esperar a que todos los archivos se hayan cargado para cerrar este vantana</span>.</span>
                <br>
                <span><span class="text-danger">Importante</span> Si el nombre del archivo ya se encuentra en el sistema, el archivo sera remplazado por la nueva versión, por lo que tambien funciona como actualización de los archivos.</span>
                <div class="wrapper">
                    <form action="#" id="formUploadDigital">
                        <input class="file-input-digital" type="file" name="file" hidden multiple>
                        <i class="mdi mdi-cloud-upload"></i>
                        <p>Abrir explorador de archivos para cargar</p>
                    </form>
                    <section class="progress-area-digital"></section>
                    <section class="uploaded-area-digital"></section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCartaDerechosImpreso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleCartaDerechosImpreso"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" id="iframeCartasDerechosImpreso"></iframe>
                <input type="hidden" id="claveCuerpo_impreso">
                <input type="hidden" id="tipo_impreso">
                <input type="hidden" id="red_impreso">
                <input type="hidden" id="anio_impreso">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger devolverCartaDerechosImpreso">Devolver fase</button>
                <button type="button" class="btn btn-success aceptarCartaDerechosImpreso">Aceptar fase</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCartaDerechosDigital" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleCartaDerechosDigital"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" id="iframeCartasDerechosDigital"></iframe>
                <input type="hidden" id="claveCuerpo_digital">
                <input type="hidden" id="tipo_digital">
                <input type="hidden" id="red_digital">
                <input type="hidden" id="anio_digital">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger devolverCartaDerechosDigital">Devolver fase</button>
                <button type="button" class="btn btn-success aceptarCartaDerechosDigital">Aceptar fase</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCartaVistoImpreso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleCartaVistoImpreso"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" id="iframeCartasVistoImpreso"></iframe>
                <input type="hidden" id="claveCuerpoVisto_impreso">
                <input type="hidden" id="tipoVisto_impreso">
                <input type="hidden" id="redVisto_impreso">
                <input type="hidden" id="anioVisto_impreso">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger devolverCartaVistoImpreso">Devolver fase</button>
                <button type="button" class="btn btn-success aceptarCartaVistoImpreso">Aceptar fase</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCartaVistoDigital" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleCartaVistoDigital"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" id="iframeCartasVistoDigital"></iframe>
                <input type="hidden" id="claveCuerpoVisto_digital">
                <input type="hidden" id="tipoVisto_digital">
                <input type="hidden" id="redVisto_digital">
                <input type="hidden" id="anioVisto_digital">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger devolverCartaVistoDigital">Devolver fase</button>
                <button type="button" class="btn btn-success aceptarCartaVistoDigital">Aceptar fase</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCapsImpresosFinales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subir archivos impresos finales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Instrucciones: Dentro de este apartado se podran subir los capitulos finales para cada equipo. <span class="text-warning">Es importante subir el archivo con la clave del grupo <b>EN MAYUSCULAS</b></span>. Para seleccionarlos, de clic en el recuadro de abajo y se abrirá su explorador de archivos, podra seleccionar todos los capitulos que desea subir. Una vez seleccionados los capítulos de clic en abrir en el explorador de archivos, a continuación se empezarán a subir los archivos uno por uno. <span class="text-warning">Favor de esperar a que todos los archivos se hayan cargado para cerrar este vantana</span>.</span>
                <br>
                <span><span class="text-danger">Importante</span> Si el nombre del archivo ya se encuentra en el sistema, el archivo sera remplazado por la nueva versión, por lo que tambien funciona como actualización de los archivos.</span>
                <div class="wrapper">
                    <form action="#" id="formUploadImpresoFinal">
                        <input class="file-input-finalImpreso" type="file" name="file" hidden multiple>
                        <i class="mdi mdi-cloud-upload"></i>
                        <p>Abrir explorador de archivos para cargar</p>
                    </form>
                    <section class="progress-area-finalImpreso"></section>
                    <section class="uploaded-area-finalImpreso"></section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCapsDigitalesFinales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subir archivos digitales finales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Instrucciones: Dentro de este apartado se podran subir los capitulos finales para cada equipo. <span class="text-warning">Es importante subir el archivo con la clave del grupo <b>EN MAYUSCULAS</b></span>. Para seleccionarlos, de clic en el recuadro de abajo y se abrirá su explorador de archivos, podra seleccionar todos los capitulos que desea subir. Una vez seleccionados los capítulos de clic en abrir en el explorador de archivos, a continuación se empezarán a subir los archivos uno por uno. <span class="text-warning">Favor de esperar a que todos los archivos se hayan cargado para cerrar este vantana</span>.</span>
                <br>
                <span><span class="text-danger">Importante</span> Si el nombre del archivo ya se encuentra en el sistema, el archivo sera remplazado por la nueva versión, por lo que tambien funciona como actualización de los archivos.</span>
                <div class="wrapper">
                    <form action="#" id="formUploadDigitalFinal">
                        <input class="file-input-finalDigital" type="file" name="file" hidden multiple>
                        <i class="mdi mdi-cloud-upload"></i>
                        <p>Abrir explorador de archivos para cargar</p>
                    </form>
                    <section class="progress-area-finalDigital"></section>
                    <section class="uploaded-area-finalDigital"></section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCapsAgradecimientosImpreso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subir archivos de agradecimientos e índice impresos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Instrucciones: Dentro de este apartado se podran subir los agradecimientos e índice para cada equipo. <span class="text-warning">Es importante subir el archivo con la clave del grupo <b>EN MAYUSCULAS</b></span>. Para seleccionarlos, de clic en el recuadro de abajo y se abrirá su explorador de archivos, podra seleccionar todos los capitulos que desea subir. Una vez seleccionados los capítulos de clic en abrir en el explorador de archivos, a continuación se empezarán a subir los archivos uno por uno. <span class="text-warning">Favor de esperar a que todos los archivos se hayan cargado para cerrar este vantana</span>.</span>
                <br>
                <span><span class="text-danger">Importante</span> Si el nombre del archivo ya se encuentra en el sistema, el archivo sera remplazado por la nueva versión, por lo que tambien funciona como actualización de los archivos.</span>
                <div class="wrapper">
                    <form action="#" id="formUploadAgradecimientosImpreso">
                        <input class="file-input-agradecimientosImpreso" type="file" name="file" hidden multiple>
                        <i class="mdi mdi-cloud-upload"></i>
                        <p>Abrir explorador de archivos para cargar</p>
                    </form>
                    <section class="progress-area-agradecimientosImpreso"></section>
                    <section class="uploaded-area-agradecimientosImpreso"></section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalCapsAgradecimientosDigital" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subir archivos de agradecimientos e índice digital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-secondary">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Instrucciones: Dentro de este apartado se podran subir los agradecimientos e índice para cada equipo. <span class="text-warning">Es importante subir el archivo con la clave del grupo <b>EN MAYUSCULAS</b></span>. Para seleccionarlos, de clic en el recuadro de abajo y se abrirá su explorador de archivos, podra seleccionar todos los capitulos que desea subir. Una vez seleccionados los capítulos de clic en abrir en el explorador de archivos, a continuación se empezarán a subir los archivos uno por uno. <span class="text-warning">Favor de esperar a que todos los archivos se hayan cargado para cerrar este vantana</span>.</span>
                <br>
                <span><span class="text-danger">Importante</span> Si el nombre del archivo ya se encuentra en el sistema, el archivo sera remplazado por la nueva versión, por lo que tambien funciona como actualización de los archivos.</span>
                <div class="wrapper">
                    <form action="#" id="formUploadAgradecimientosDigital">
                        <input class="file-input-agradecimientosDigital" type="file" name="file" hidden multiple>
                        <i class="mdi mdi-cloud-upload"></i>
                        <p>Abrir explorador de archivos para cargar</p>
                    </form>
                    <section class="progress-area-agradecimientosDigital"></section>
                    <section class="uploaded-area-agradecimientosDigital"></section>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let red = '<?= $red ?>';
    let anio = '<?= $anio ?>';
    const fases = <?= json_encode($nombres_fases) ?>
</script>

<script src="<?= base_url('resources/admin/datatables/investigaciones/listaEquipos.js') ?>"></script>
