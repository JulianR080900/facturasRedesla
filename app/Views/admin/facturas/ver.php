<div id="loaderCustom">
    <span class="loaderCustom"></span>
</div>

<style>
    .loaderCustom {
        display: inline-block;
        text-align: center;
        line-height: 86px;
        text-align: center;
        position: relative;
        padding: 0 48px;
        font-size: 48px;
        font-family: Arial, Helvetica, sans-serif;
        color: #fff;
    }

    .loaderCustom:before,
    .loaderCustom:after {
        content: "";
        display: block;
        width: 15px;
        height: 15px;
        background: currentColor;
        position: absolute;
        animation: load .7s infinite alternate ease-in-out;
        top: 0;
    }

    .loaderCustom:after {
        top: auto;
        bottom: 0;
    }

    @keyframes load {
        0% {
            left: 0;
            height: 43px;
            width: 15px;
            transform: translateX(0)
        }

        50% {
            height: 10px;
            width: 40px
        }

        100% {
            left: 100%;
            height: 43px;
            width: 15px;
            transform: translateX(-100%)
        }
    }

    #loaderCustom {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        /* Fondo semitransparente */
        z-index: 9999;
        /* Z-index alto para asegurarse de que esté por encima de otros elementos */
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card bg-dark text-white">

            <div class="card-header header_title_card">

                <h2 class="text-secondary">Datos de la factura - <?= $factura['claveCuerpo'] ?></h2>

            </div>
            <style>
                input:readonly {
                    background-color: #808080 !important;
                    color: #fff !important;
                }

                .switch {
                    position: relative;
                    display: block;
                    vertical-align: top;
                    width: 100px;
                    height: 30px;
                    padding: 3px;
                    margin: 0 10px 10px 0;
                    background: linear-gradient(to bottom, #eeeeee, #FFFFFF 25px);
                    background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF 25px);
                    border-radius: 18px;
                    box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
                    cursor: pointer;
                    box-sizing: content-box;
                }

                .switch-input {
                    position: absolute;
                    top: 0;
                    left: 0;
                    opacity: 0;
                    box-sizing: content-box;
                }

                .switch-label {
                    position: relative;
                    display: block;
                    height: inherit;
                    font-size: 10px;
                    text-transform: uppercase;
                    background: #D03A55;
                    border-radius: inherit;
                    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
                    box-sizing: content-box;
                }

                .switch-label:before,
                .switch-label:after {
                    position: absolute;
                    top: 50%;
                    margin-top: -.5em;
                    line-height: 1;
                    -webkit-transition: inherit;
                    -moz-transition: inherit;
                    -o-transition: inherit;
                    transition: inherit;
                    box-sizing: content-box;
                }

                .switch-label:before {
                    content: attr(data-off);
                    right: 11px;
                    color: #aaaaaa;
                    text-shadow: 0 1px rgba(255, 255, 255, 0.5);
                }

                .switch-label:after {
                    content: attr(data-on);
                    left: 11px;
                    color: #FFFFFF;
                    text-shadow: 0 1px rgba(0, 0, 0, 0.2);
                    opacity: 0;
                }

                .switch-input:checked~.switch-label {
                    background: #299617;
                    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
                }

                .switch-input:checked~.switch-label:before {
                    opacity: 0;
                }

                .switch-input:checked~.switch-label:after {
                    opacity: 1;
                }

                .switch-handle {
                    position: absolute;
                    top: 4px;
                    left: 4px;
                    width: 28px;
                    height: 28px;
                    background: linear-gradient(to bottom, #FFFFFF 40%, #f0f0f0);
                    background-image: -webkit-linear-gradient(top, #FFFFFF 40%, #f0f0f0);
                    border-radius: 100%;
                    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
                }

                .switch-handle:before {
                    content: "";
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    margin: -6px 0 0 -6px;
                    width: 12px;
                    height: 12px;
                    background: linear-gradient(to bottom, #eeeeee, #FFFFFF);
                    background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF);
                    border-radius: 6px;
                    box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
                }

                .switch-input:checked~.switch-handle {
                    left: 74px;
                    box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
                }

                /* Transition
                ========================== */
                .switch-label,
                .switch-handle {
                    transition: All 0.3s ease;
                    -webkit-transition: All 0.3s ease;
                    -moz-transition: All 0.3s ease;
                    -o-transition: All 0.3s ease;
                }
            </style>

            <div class="card-body body_card">

                <form action="">
                    <h4 class="text-upper text-info">Datos fiscales</h4>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label for="rfc">RFC:</label>

                            <input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC" readonly value="<?php echo $factura["rfc"] ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="nombre">Nombre / Razón Social:</label>

                            <input type="text" class="form-control" placeholder="Nombre/razon social" id="nombre" name="nombre" readonly value="<?php echo $factura["nombre"] ?>">

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label for="correo">Correo:</label>

                            <input type="email" class="form-control" id="correo" name="correo" placeholder="alguien@dominio.com" readonly value="<?php echo $factura["correo"] ?>">

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="regimen_fiscal">Regimen fiscal:</label>
                            <?php
                            if ($factura["regimen_fiscal"] == '') {
                                echo '<h5 class="text-warning">Regimen fiscal no encontrada</h5>';
                            } else {
                            ?>
                                <input type="text" name="" id="" class="form-control" readonly value="<?php echo $factura["regimen_fiscal"] ?>">
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label for="pais">Pais:</label>

                            <input type="text" name="pais" id="pais" class="form-control" readonly value="<?php echo $factura["pais"] ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="estado">Estado:</label>

                            <input type="text" name="estado" id="estado" class="form-control" readonly value="<?php echo $factura["estado"] ?>">



                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">

                            <label for="municipio">Ciudad/Delegación:</label>

                            <input type="text" name="municipio" id="municipio" class="form-control" readonly value="<?php echo $factura["municipio"] ?>">

                        </div>
                        <div class="col-md-6 mb-3">

                            <label for="municipio">Localidad:</label>

                            <input type="text" name="localidad" id="localidad" class="form-control" readonly value='<?= empty($factura['localidad']) ? 'Sin registrar' : $factura['localidad'] ?>'>

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label for="uso">Uso de la factura:</label>

                            <input type="text" name="" id="" class="form-control" readonly value="<?php echo $factura["uso"] ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="calle">Calle:</label>

                            <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" readonly value="<?php echo $factura["calle"] ?>">

                        </div>

                    </div>

                    <div class="row">


                        <div class="col-md-6 mb-3">

                            <label for="noext">No. Exterior:</label>

                            <input type="text" class="form-control" id="noext" name="noext" placeholder="Numero exterior" readonly value="<?php echo $factura["numero_exterior"] ?>">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label for="noint">No. Interior:</label>

                            <input type="text" class="form-control" id="noint" name="noint" placeholder="Numero interior" readonly value="<?php echo $factura["numero_interior"] ?>">

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label for="colonia">Colonia:</label>

                            <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia" readonly value="<?php echo $factura["colonia"] ?>">

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cp">C.P:</label>

                            <input type="number" class="form-control" id="cp" name="cp" placeholder="C.P" readonly value="<?php echo $factura["cp"] ?>">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3>Datos importante para Factura.com</h3>
                            <div class="form-group">
                                <label for="">Seleccione la empresa con la que se emitira la factura</label>
                                <select id="selectEmpresa" name="selectEmpresa" class="form-control w-100 selectEmpresa" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>

                    <hr>
                    <h4 class="text-upper text-info">Archivos / carpetas</h4>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <?php
                            if ($carpetas["envios"] == 'No encontrado.' || $carpetas["envios"] == '') {
                                echo '<h5 class="text-warning">La carpeta no ha sido encontrada.</h5>';
                            } else if ($anio == 2022 && $red == 'Releg') {
                            ?>
                                <a href="<?= $carpetas["envios"] ?>" class="btn btn-block btn-warning" target="_blank">Ir a carpeta de One Drive</a>
                            <?php
                            } else {
                            ?>
                                <iframe src="https://drive.google.com/embeddedfolderview?id=<?= $carpetas["envios"] ?>#grid" style="width:100%; height:300px; border:0;background-color:lightgray;"></iframe>
                                <a href="https://drive.google.com/drive/u/0/folders/<?= $carpetas["envios"] ?>" target="_blank" class="btn btn-block btn-warning btn-icon-text">Ir a carpeta de Drive <i class="mdi mdi-google-drive btn-icon-prepend"></i></a>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-6 mb-3 text-center">
                            <h5>Constancia de Situación Fiscal (CSF)</h5>
                            <?php
                            if ($factura["csf"] ==  '') {
                                echo '<p class="text-warning">Constacia de situación fiscal no encontrada</p>';
                            } else {
                            ?>
                                <div>
                                    <a target="_blank" href="<?= base_url('/admin/visualizadorCSF/' . $factura['csf']) ?>">
                                        <i class="mdi mdi-file-pdf text-danger" style="font-size: 3.5rem;"></i>
                                        <br>
                                        <?= $factura['csf'] ?>
                                    </a>
                                </div>

                            <?php
                            }
                            ?>
                            <hr>
                            <h5>Comprobantes</h5>
                            <?= !empty($comprobantes) ? $comprobantes : 'Sin comprobantes registrados' ?>
                        </div>

                    </div>
                </form>

                <form action="../aceptar" method="post">
                    <input type="text" name="id" hidden value="<?= $factura['id'] ?>">
                    <input type="text" name="facturado" id="facturado" readonly hidden value=2>
                    <hr class="mb-4">
                    <?php
                    if ($factura["facturado"] > 0) {
                        echo '<h5 class="text-warning">Ya se ha facturado</h5>';
                    } else {
                    ?>
                        <button type="submit" class="btn btn-success btn-block submitUpdate">Establecer factura emitida</button>
                        <button type="button" class="btn btn-warning btn-block rechazar">Rechazar información de la factura</button>
                    <?php
                    }
                    ?>
                    <button type="button" id="facturaCFDI" class="btn btn-info btn-block">Facturar en FACTURA.COM</button>
                    <a class="btn btn-danger btn-block" href="<?= base_url('/admin/finanzas/facturas/lista') ?>">Regresar</a>
                </form>

                <input type="text" id="id_factura" hidden value="<?= $factura['id'] ?>">

                <?php
                $factura = json_encode($factura);
                ?>
            </div>

        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modalFactura" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form id="frm_factura">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Opciones de factura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-danger">&times;</span>
                    </button>
                </div>
                <div class="modal-body">



                    <div class="row">
                        <div class="col-md-12">
                            <h4>INFORMACIÓN DEL PRODUCTO</h4>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Seleccione el producto <span class="text-danger">*</span></label>
                                <select id="selectProductos" name="selectProductos" class="form-control w-100 selectProductos" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Descripción del concepto <span class="text-danger">*</span></label>
                                <input type="text" list='sugerencias' id="Descripcion" placeholder="Escribe la descripción del concepto" class="form-control" autocomplete="on" required>
                                <datalist id="sugerencias">
                                    <option value="Servicios de edición">Servicios de edición</option>
                                    <option value="Capacitación taller redacción">Capacitación taller redacción</option>
                                    <option value="PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ,ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN ADMINISTRACIÓN Y NEGOCIOS, RELAYN.,PUBLICACIONES EN DISTINTOS MEDIOS ARBITRADOS.">PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ,ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN ADMINISTRACIÓN Y NEGOCIOS, RELAYN.,PUBLICACIONES EN DISTINTOS MEDIOS ARBITRADOS.</option>
                                    <option value="PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN EDUCACIÓN Y PEDAGOGÍA, RELEP.">PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN EDUCACIÓN Y PEDAGOGÍA, RELEP.</option>
                                    <option value="Coedición de un capítulo del libro impreso derivado de la investigación RELAYN 2023 'Habilidades directivas y clima organizacional en las micro y pequeñas empresas Latinoamericanas' y suministro de 15 ejemplares">Coedición de un capítulo del libro impreso derivado de la investigación RELAYN 2023 "Habilidades directivas y clima organizacional en las micro y pequeñas empresas Latinoamericanas" y suministro de 15 ejemplares</option>
                                    <option value='CURSO DE CAPACITACIÓN “METODOLOGÍA DE LA,INVESTIGACIÓN: DE CÓMO DESARROLLAR ARTÍCULOS CIENTÍFICOS”'>CURSO DE CAPACITACIÓN “METODOLOGÍA DE LA,INVESTIGACIÓN: DE CÓMO DESARROLLAR ARTÍCULOS CIENTÍFICOS”</option>
                                    <option value="CURSO DE CAPACITACIÓN “METODOLOGÍA DE LA,INVESTIGACIÓN: DE CÓMO DESARROLLAR ARTÍCULOS CIENTÍFICOS” Y PUBLICACIÓN EN LIBRO ELECTRÓNICO.">CURSO DE CAPACITACIÓN “METODOLOGÍA DE LA,INVESTIGACIÓN: DE CÓMO DESARROLLAR ARTÍCULOS CIENTÍFICOS” Y PUBLICACIÓN EN LIBRO ELECTRÓNICO.</option>
                                    <option value="PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ,ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN EDUCACIÓN Y PEDAGOGÍA, RELEP.,PUBLICACIONES EN DISTINTOS MEDIOS ARBITRADOS.">PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ,ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN EDUCACIÓN Y PEDAGOGÍA, RELEP.,PUBLICACIONES EN DISTINTOS MEDIOS ARBITRADOS.</option>
                                    <option value="PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN ADMINISTRACIÓN Y NEGOCIOS, RELAYN.">PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN ADMINISTRACIÓN Y NEGOCIOS, RELAYN.</option>
                                    <option value='Coedición de un capítulo del libro electrónico derivado de la investigación RELAYN 2023 "Habilidades directivas y clima organizacional en las micro y pequeñas empresas Latinoamericanas" con editorial iQuatro Editores.'>Coedición de un capítulo del libro electrónico derivado de la investigación RELAYN 2023 "Habilidades directivas y clima organizacional en las micro y pequeñas empresas Latinoamericanas" con editorial iQuatro Editores.</option>
                                    <option value="CURSO DE CAPACITACIÓN “METODOLOGÍA DE LA,INVESTIGACIÓN: DE CÓMO DESARROLLAR ARTÍCULOS CIENTÍFICOS”, PUBLICACIÓN EN LIBRO ELECTRÓNICO Y DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO DE INVESTIGACIÓN LATINOAMERICANO.">CURSO DE CAPACITACIÓN “METODOLOGÍA DE LA,INVESTIGACIÓN: DE CÓMO DESARROLLAR ARTÍCULOS CIENTÍFICOS”, PUBLICACIÓN EN LIBRO ELECTRÓNICO Y DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO DE INVESTIGACIÓN LATINOAMERICANO.</option>
                                    <option value='Coedición de un capitulo del libro electrónico "La micro y pequeña empresa frente a la pandemia de COVID-19 en Latinoamérica"'>Coedición de un capitulo del libro electrónico "La micro y pequeña empresa frente a la pandemia de COVID-19 en Latinoamérica"</option>
                                    <option value="INGRESOS ASIMILADOS A SALARIOS">INGRESOS ASIMILADOS A SALARIOS</option>
                                    <option value="CURSO DE CAPACITACIÓN “¿QUÉ ES EL PRODEP? Y,CÓMO PRESENTAR ADECUADAMENTE LA SOLICITUD PARA OBTENER EL RECONOCIMIENTO DEL PERFIL PRODEP”.">CURSO DE CAPACITACIÓN “¿QUÉ ES EL PRODEP? Y,CÓMO PRESENTAR ADECUADAMENTE LA SOLICITUD PARA OBTENER EL RECONOCIMIENTO DEL PERFIL PRODEP”.</option>
                                    <option value="CURSO DE CAPACITACIÓN  “¿QUÉ ES EL SISTEMA NACIONAL DE INVESTIGADORES (SNI)? Y CÓMO PRESENTAR ADECUADAMENTE LA SOLICITUD DE INGRESO O PERMANENCIA”">CURSO DE CAPACITACIÓN “¿QUÉ ES EL SISTEMA NACIONAL DE INVESTIGADORES (SNI)? Y CÓMO PRESENTAR ADECUADAMENTE LA SOLICITUD DE INGRESO O PERMANENCIA”</option>
                                    <option value="CURSOS DE CAPACITACIÓN:, “¿QUÉ ES EL SISTEMA NACIONAL DE INVESTIGADORES (SNI)? Y CÓMO PRESENTAR ADECUADAMENTE LA SOLICITUD DE INGRESO O PERMANENCIA” Y,“¿QUÉ ES EL PRODEP? Y CÓMO PRESENTAR ADECUADAMENTE LA SOLICITUD PARA OBTENER EL RECONOCIMIENTO DEL PERFIL PRODEP”.">CURSOS DE CAPACITACIÓN:, “¿QUÉ ES EL SISTEMA NACIONAL DE INVESTIGADORES (SNI)? Y CÓMO PRESENTAR ADECUADAMENTE LA SOLICITUD DE INGRESO O PERMANENCIA” Y,“¿QUÉ ES EL PRODEP? Y CÓMO PRESENTAR ADECUADAMENTE LA SOLICITUD PARA OBTENER EL RECONOCIMIENTO DEL PERFIL PRODEP”.</option>
                                    <option value="PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A COLOQUIO DOCTORAL Y DE MAESTRÍA CELEBRADO EN EL MARCO DEL CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN ADMINISTRACIÓN Y NEGOCIOS, RELAYN.,PUBLICACIONES EN DISTINTOS MEDIOS ARBITRADOS.">PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A COLOQUIO DOCTORAL Y DE MAESTRÍA CELEBRADO EN EL MARCO DEL CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN ADMINISTRACIÓN Y NEGOCIOS, RELAYN.,PUBLICACIONES EN DISTINTOS MEDIOS ARBITRADOS.</option>
                                    <option value="PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN EDUCACIÓN NORMAL, RELEN">PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN EDUCACIÓN NORMAL, RELEN</option>
                                    <option value='"Pago de derechos por el uso de base de datos"'>"Pago de derechos por el uso de base de datos"</option>
                                    <option value="Curso de capacitación Marketing y Publicidad “PROCESO CREATIVO: 5,herramientas para conectar con tus consumidores”">Curso de capacitación Marketing y Publicidad “PROCESO CREATIVO: 5,herramientas para conectar con tus consumidores”</option>
                                    <option value="Pago de intereses por préstamo otorgado el 21 de diciembre de 2020 al 12% anual">Pago de intereses por préstamo otorgado el 21 de diciembre de 2020 al 12% anual</option>
                                    <option value="ASESORÍA PARA PRESENTAR ADECUADAMENTE LA SOLICITUD DE INGRESO O PERMANENCIA SNI">ASESORÍA PARA PRESENTAR ADECUADAMENTE LA SOLICITUD DE INGRESO O PERMANENCIA SNI</option>
                                    <option value='Curso de capacitación en línea ¿Cómo puedo aumentar el valor de mi dinero? Mejora tu futuro aprendiendo a invertir en diversos instrumentos"'>Curso de capacitación en línea ¿Cómo puedo aumentar el valor de mi dinero? Mejora tu futuro aprendiendo a invertir en diversos instrumentos"</option>
                                    <option value='PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ,ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN EDUCACIÓN NORMAL, RELEN.,PUBLICACIONES EN DISTINTOS MEDIOS ARBITRADOS.'>PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ,ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN EDUCACIÓN NORMAL, RELEN.,PUBLICACIONES EN DISTINTOS MEDIOS ARBITRADOS.</option>
                                    <option value="CURSO DE CAPACITACIÓN “ESTADÍSTICA PARA INVESTIGACIÓN CIENTÍFICA”">CURSO DE CAPACITACIÓN “ESTADÍSTICA PARA INVESTIGACIÓN CIENTÍFICA”</option>
                                    <option value="CURSO DE CAPACITACIÓN “ESTADÍSTICA PARA INVESTIGACIÓN CIENTÍFICA” Y PUBLICACIÓN EN LIBRO ELECTRÓNICO.">CURSO DE CAPACITACIÓN “ESTADÍSTICA PARA INVESTIGACIÓN CIENTÍFICA” Y PUBLICACIÓN EN LIBRO ELECTRÓNICO.</option>
                                    <option value="CURSO DE CAPACITACIÓN “ESTADÍSTICA PARA INVESTIGACIÓN CIENTÍFICA”, PUBLICACIÓN EN LIBRO ELECTRÓNICO Y DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO DE INVESTIGACIÓN LATINOAMERICANO.">CURSO DE CAPACITACIÓN “ESTADÍSTICA PARA INVESTIGACIÓN CIENTÍFICA”, PUBLICACIÓN EN LIBRO ELECTRÓNICO Y DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN: ASISTENCIA A CONGRESO DE INVESTIGACIÓN LATINOAMERICANO.</option>
                                    <option value="CUOTA DE RECUPERACIÓN DEL CONGRESO LATINOAMERICANO DE INVESTIGACION EN -- EN EL HOTEL COMFORT INN MORELIA PARA LA NOCHE DEL 02 DE DICIEMBRE DEL 2022. INCLUYE HOSPEDAJE">CUOTA DE RECUPERACIÓN DEL CONGRESO LATINOAMERICANO DE INVESTIGACION EN -- EN EL HOTEL COMFORT INN MORELIA PARA LA NOCHE DEL 02 DE DICIEMBRE DEL 2022. INCLUYE HOSPEDAJE</option>
                                    <option value="Coedición de un capítulo del libro impreso derivado de la investigación RELEN 2023 “Los procesos metacognitivos y su impacto en la formación lectora competente del maestro en servicio de educación obligatoria” y suministro de 10 ejemplares.">Coedición de un capítulo del libro impreso derivado de la investigación RELEN 2023 “Los procesos metacognitivos y su impacto en la formación lectora competente del maestro en servicio de educación obligatoria” y suministro de 10 ejemplares.</option>
                                    <option value='Coedición de un capítulo del libro impreso derivado de la investigación RELEP 2023 "Rendimiento académico: relación del aprovechamiento y compromiso de los estudiantes universitarios" y suministro de 10 ejemplares'>Coedición de un capítulo del libro impreso derivado de la investigación RELEP 2023 "Rendimiento académico: relación del aprovechamiento y compromiso de los estudiantes universitarios" y suministro de 10 ejemplares</option>
                                    <option value="PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN:,ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN ESTUDIOS DE GÉNERO, RELEG.,PUBLICACIÓN EN DISTINTOS MEDIOS ARBITRADOS">PAGO DE DERECHOS DE PRODUCTOS ACADÉMICOS INTERNACIONALES. QUE CONSISTE EN:,ASISTENCIA A CONGRESO LATINOAMERICANO DE INVESTIGACIÓN EN ESTUDIOS DE GÉNERO, RELEG.,PUBLICACIÓN EN DISTINTOS MEDIOS ARBITRADOS</option>
                                    <option value='Coedición de un capítulo del libro electrónico derivado de la investigación RELEP 2023 "Rendimiento académico: Relación del aprovechamiento y compromiso de los estudiantes" con editorial iQuatro Editores.'>Coedición de un capítulo del libro electrónico derivado de la investigación RELEP 2023 "Rendimiento académico: Relación del aprovechamiento y compromiso de los estudiantes" con editorial iQuatro Editores.</option>
                                </datalist>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Precio unitario <span class="text-danger">*</span></label>
                                <input type="number" id="ValorUnitario" name="ValorUnitario" class="form-control" required step="0.01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Cantidad de productos <span class="text-danger">*</span> <i class="mdi mdi-information" title="Valor 1 por defecto"></i> </label>
                                <input type="number" name="Cantidad" id="cantidad" value="1" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Descuento</label>
                                <input type="number" name="Descuento" id="Descuento" class="form-control" placeholder="Escriba el descuento si es que aplica" value="0" min='0' max="100" step="0.01">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h4>IMPUESTOS - TRASLADOS</h4>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tipo de impuesto</label>
                                <select id="Impuesto" class="form-control w-100 Impuesto">
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tipo de factor <span class="text-warning">*</span> <i class="mdi mdi-information" title="Indica tipo de factor correspondiente al impuesto que deseas agregar."></i></label>
                                <select name="TipoFactor" id="TipoFactor" class="form-control">
                                    <option value="" selected disabled>Selecione una opción</option>
                                    <option value="Tasa">Tasa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Porcentaje del impuesto <span class="text-warning">*</span></label>
                                <select name="TasaOCuota" id="TasaOCuota" class="form-control">
                                    <option value="" selected disabled>Selecione una opción</option>
                                    <option value="0.16">16%</option>
                                    <option value="0.8">8%</option>
                                    <option value="0.4">4%</option>
                                    <option value="0">0%</option>
                                    <option value="00">Excento</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <h4>DATOS DE FACTURA</h4>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Uso de CFDI <span class="text-danger">*</span></label>
                                <select id="UsoCFDI" class="form-control w-100 UsoCFDI" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Serie <span class="text-danger">*</span></label>
                                <select id="Serie" class="form-control w-100 Serie" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Forma de pago <span class="text-danger">*</span></label>
                                <select id="FormaPago" class="form-control w-100 FormaPago" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Metodo de pago <span class="text-danger">*</span></label>
                                <select id="MetodoPago" class="form-control w-100 MetodoPago" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Condiciones de pago <span class="text-warning">Ejemplo: Pago en 9 meses</span> </label>
                                <input type="text" name="CondicionesDePago" id="CondicionesDePago" class="form-control" maxlength="1000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Moneda <span class="text-danger">*</span></label>
                                <select id="Moneda" class="form-control w-100 Moneda" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">No. de orden/ pedido</label>
                                <input type="text" name="NumOrder" id="NumOrder" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Comentarios</label>
                                <select id="Comentarios" class="form-control w-100 Comentarios" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Con la emisión de esta factura aceptan los términos y condiciones, no se aceptarán cambios ni devoluciones de un monto total o parcial en caso de: 1. No cumplir con el procedimiento de participación y las fechas establecidas en la convocatoria. 2. Ya no querer el producto. La ausencia de respuesta a los comunicados y desinterés en el seguimiento de sus participación y/o procesos no serán responsabilidad de la red ni su representada. IMPORTANTE: Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma por disposición fiscal.">CAMBIO, CANCELACIÓN O MODIFICACIÓN DE FACTURA</option>
                                    <option value="Con la emisión de esta factura aceptan los términos y condiciones, no se aceptarán cambios ni devoluciones de un monto total o parcial en caso de: 1. No cumplir con el procedimiento de participación y las fechas establecidas en la convocatoria. 2. Ya no querer el producto. 3. Dentro del artículo podrá colocar de 1 a 3 autores, es importante realizar el envío y atender las revisiones según determine RedesLA e iQuatro Editores. 4. Los productos académicos los adquieren los participantes registrados en ambas plataformas (RedesLA e iQuatro Editores); deberán revisar las condiciones para la emisión de la constancia de asistencia. 5. La entrada al evento es de dos personas en modalidad física y el resto en modalidad virtual sin costo adicional al congreso. 6. Es importante enviar la categoría 4 para dar seguimiento a la publicación y atender las observaciones solicitadas. 7. La ausencia de respuestas a los comunicados de la editorial para el autor, se tomará como desinterés de seguimiento y la publicación será rechazada sin posibilidad de retomar la misma para nuevas publicaciones. IMPORTANTE: Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma por disposición fiscal.">Coloquio</option>
                                    <option value="Con la emisión de esta factura aceptan los términos y condiciones, no se aceptarán cambios ni devoluciones de un monto total o parcial en caso de: 1. No cumplir con el procedimiento de participación y las fechas establecidas en la convocatoria. 2. Ya no querer el producto. 3. Dentro del artículo podrá colocar de 1 a 4 autores, es importante realizar el envío y atender las revisiones según determine RedesLA e iQuatro Editores. 4. Los productos académicos los adquieren los participantes registrados en ambas plataformas (RedesLA e iQuatro Editores); deberán revisar las condiciones para la emisión de la constancia de asistencia. 5. La entrada al evento es de dos personas en modalidad física y el resto en modalidad virtual sin costo adicional al congreso. 6. Es importante dar seguimiento a la publicación y atender las observaciones solicitadas. 7. La ausencia de respuestas a los comunicados de la editorial para el autor, se tomará como desinterés de seguimiento y la publicación será rechazada sin posibilidad de retomar la misma para nuevas publicaciones. IMPORTANTE: Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma por disposición fiscal.">Congreso</option>
                                    <option value="Con la emisión de esta factura aceptan los términos y condiciones, no se aceptarán cambios ni devoluciones de un monto total o parcial en caso de: 1. No cumplir con el procedimiento de participación y las fechas establecidas en la convocatoria. 2. Ya no querer el producto. 3. Dentro del artículo podrá colocar de 1 a 4 autores, es importante realizar el envío y atender las revisiones según determine RedesLA e iQuatro Editores. 4. Los productos académicos los adquiere sólo el participante titular, es decir quien toma el curso, será el único con derecho a constancia de asistencia y entrada sin otro costo adicional al curso-taller en cualquiera que fuese la modalidad y este no será intercambiable. 5. Para acreditar el curso-taller y recibir su constancia deberá cumplir con los criterios de evaluación establecidos en la convocatoria. 6. La ausencia de respuestas a los comunicados de la editorial para el autor, se tomará como desinterés de seguimiento y la publicación será rechazada sin posibilidad de retomar la misma para nuevas publicaciones. IMPORTANTE: Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma por disposición fiscal.">CURSO-TALLER</option>
                                    <option value="Incluye además de la coedición de su(s) capítulo(s): • Registro anual de los docentes del grupo como miembros de la Red de Estudios Latinoamericanos en Administración y Negocios (RELAYN). • Participación de los miembros del GI en la Investigación anual y el Congreso Anual. Con la emisión de esta factura aceptan los términos y condiciones para la participación del GI en la investigación anual; no se aceptarán cambios ni devoluciones de un monto total o parcial si no se cumple con el procedimiento de participación para obtener su(s) capítulo(s) y las principales actividades como son: 1. Levantamiento de la muestra solicitada en la investigación, respetando su zona de estudio y procedimiento de validación. 2. Entrega de capítulo(s) con las redacciones solicitadas en las fechas establecidas por RELAYN. 3. Envío, revisión y confirmación de preliminares de cada obra en tiempo y forma. 4. No entregar los solicitado para trámites administrativos (cesión de derechos u otros) a RELAYN. 5. Ya no querer el producto. La ausencia de respuesta a los comunicados y desinterés en el seguimiento de sus publicaciones y/o procesos no serán responsabilidad de la red ni su representada. IMPORTANTE: Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma por disposición fiscal.">INVESTIGACIÓN RELAYN</option>
                                    <option value="Incluye además de la coedición de su(s) capítulo(s): • Registro anual de los docentes del grupo como miembros de la Red de Estudios Latinoamericanos en Educación Normal (RELEN). • Participación de los miembros del GI en la Investigación anual y el Congreso Anual. Con la emisión de esta factura aceptan los términos y condiciones para la participación del GI en la investigación anual; no se aceptarán cambios ni devoluciones de un monto total o parcial si no se cumple con el procedimiento de participación para obtener su(s) capítulo(s) y las principales actividades como son: 1. Levantamiento de la muestra solicitada en la investigación, respetando su zona de estudio y procedimiento de validación. 2. Entrega de capítulo(s) con las redacciones solicitadas en las fechas establecidas por RELEN. 3. Envío, revisión y confirmación de preliminares de cada obra en tiempo y forma. 4. No entregar los solicitado para trámites administrativos (cesión de derechos u otros) a RELEN. 5. Ya no querer el producto. La ausencia de respuesta a los comunicados y desinterés en el seguimiento de sus publicaciones y/o procesos no serán responsabilidad de la red ni su representada. IMPORTANTE: Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma por disposición fiscal.">INVESTIGACIÓN RELEN</option>
                                    <option value="Incluye además de la coedición de su(s) capítulo(s): • Registro anual de los docentes del grupo como miembros de la Red de Estudios Latinoamericanos en Educación y Pedagogía (RELEP). • Participación de los miembros del GI en la Investigación anual y el Congreso Anual. Con la emisión de esta factura aceptan los términos y condiciones para la participación del GI en la investigación anual; no se aceptarán cambios ni devoluciones de un monto total o parcial si no se cumple con el procedimiento de participación para obtener su(s) capítulo(s) y las principales actividades como son: 1. Levantamiento de la muestra solicitada en la investigación, respetando su zona de estudio y procedimiento de validación. 2. Entrega de capítulo(s) con las redacciones solicitadas en las fechas establecidas por RELEP. 3. Envío, revisión y confirmación de preliminares de cada obra en tiempo y forma. 4. No entregar los solicitado para trámites administrativos (cesión de derechos u otros) a RELEP. 5. Ya no querer el producto. La ausencia de respuesta a los comunicados y desinterés en el seguimiento de sus publicaciones y/o procesos no serán responsabilidad de la red ni su representada. IMPORTANTE: Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma por disposición fiscal.">INVESTIGACIÓN RELEP</option>
                                    <option value="Con la emisión de esta factura aceptan los términos y condiciones, no se aceptarán cambios ni devoluciones de un monto total o parcial en caso de: 1. No cumplir con el procedimiento de participación y las fechas establecidas por la editorial iQuatro Editores. 2. Ya no querer el producto. 3. Dentro del artículo podrá colocar de 1 a 4 autores, es importante realizar el envío y atender las revisiones según determine RedesLA e iQuatro Editores. 4. Es importante dar seguimiento a la publicación y atender las observaciones solicitadas. 5. La ausencia de respuestas a los comunicados de la editorial para el autor, se tomará como desinterés de seguimiento y la publicación será rechazada sin posibilidad de retomar la misma para nuevas publicaciones. IMPORTANTE: Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma por disposición fiscal.">PUBLICACIÓN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Enviar correo</label>
                                <label class="switch">
                                    <input class="switch-input" type="checkbox" name="EnviarCorreo" id="EnviarCorreo" />
                                    <span class="switch-label" data-on="Si" data-off="No"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">País</label>
                                <select name="PaisFactura" id="PaisFactura" class="form-control" required>
                                    <option value="" selected required>Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-4" id="tipo_cambio">
                            <div class="form-group">
                                <label for="">Tipo de cambio <span class="text-warning">*</span></label>
                                <input type="number" name="TipoCambio" id="TipoCambio" class="form-control" step="any">
                            </div>
                        </div>
                    </div>

                    <input type="text" id="NoIdentificacion" name="NoIdentificacion" readonly hidden>
                    <input type="text" id="ClaveUnidad" name="ClaveUnidad" readonly hidden>
                    <input type="text" id="Unidad" name="Unidad" readonly hidden>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info" id="btnFacturarFactura">Facturar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    const factura = JSON.parse('<?= $factura ?>');
    let base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url() ?>/resources/js/facturas/ver.js"></script>