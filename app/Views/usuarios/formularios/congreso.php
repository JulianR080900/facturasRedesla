<link rel="stylesheet" href="<?= base_url('resources/css/oyente.css') ?>">
<div class="content">
    <style>
        .pop-outer {
            background-color: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .pop-inner {
            background-color: #fff;
            width: 800px;
            height: 500px;
            padding: 25px;
            margin: 5% auto;
            color: #000;
        }

        table {
            padding: 0.1rem;
        }
    </style>
    <div class="card card-body-congresos">
        <form action="<?php echo base_url("insertarCongreso") ?>" method="POST" id='formPonencia' class="needs-validation" novalidate>
            <div class="card-header card-header-congresos">
                <h2>Datos de su ponencia</h2>
            </div>
            <div class="card-body">
                <h2>Instrucciones</h2>

                <p>
                Los siguientes datos han sido autocompletados con la información registrada en <b><span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</b>  
                al enviar su ponencia. Solicitamos corrobore que los datos previamente capturados sean correctos, 
                en caso de que alguno sea incorrecto podrán editarlos 1 única vez dando clic al pincel  Editar, dato que se actualizará en la plataforma de <b><span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</b> , 
                preste atención a los datos que va capturar o <b>CONFIRMAR</b>.
                </p>

                <p>
                Una vez verificados los datos de la ponencia, debe hacer la selección de usuarios de la plataforma de <b><span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</b>  y 
                <b class="n_Redesla">REDESLA</b>; debiendo seleccionar al autor y miembro del grupo en 
                ambos campos para registrarlos de forma correcta; rectifique que el nombre está completo y sin faltas de ortografía, si en uno de los dos campos la 
                información está errónea solicite las correcciones con el equipo <b class="n_Redesla"><a href="<?= $whatsapp ?>" target="_blank">RedesLA</a></b>.
                Todo esto es con la finalidad de asegurar una pronta y correcta emisión de sus constancias de participación.
                </p>


                <h2>Nombre de la ponencia. Datos registrados en <span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</h2>
                <h4 class="text-warning">IMPORTANTE</h4>
                <p>
                Si alguno de los campos está vacío es porque no se capturó en la plataforma <b><span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</b> , 
                ya que el dato no es obligatorio. Dé clic para ver un <a href="#miModal" data-bs-toggle="modal">ejemplo</a> de captura.
                Si presenta un error y no le permite modificarlo, <b><span class="text-danger">NO CONTINUE EL PROCESO</span></b>, debe contactar al equipo RedesLA y retomar el proceso hasta ver los cambios reflejados.
                Si continúa sin realizar el reporte o bien esperar las modificaciones, ya no se podrán integrar a los autores faltantes o ejecutar cambios en sus errores.
                </p>
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 text-center">
                        <object id="obj_svg" data="<?= base_url('resources/img/svg/conferencia.svg') ?>" type="image/svg+xml"></object>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-8">
                        <div class="form-group">
                            <label for="">Prefijo</label> (Plataforma <b><span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</b> )
                            <div class="input-group">
                                <input type="text" class="form-control" name="prefijo" id="prefijo" value="<?php echo $ponencia["prefijo"] ?>">
                                <div class="input-group-append">
                                    <button type="button" name="" id="editPrefijo" class="btn btn-warning">Editar <i class="far fa-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Nombre</label><span class="text-danger">*</span> (Plataforma <b><span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</b> )
                            <div class="input-group">
                                <input type="text" required name="titulo" id="titulo" class="form-control" value="<?php echo $ponencia["titulo"] ?>">
                                <div class="input-group-append">
                                    <button type="button" name="" id="editTitulo" class="btn btn-warning">Editar <i class="far fa-edit"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Subtítulo</label> (Plataforma <b><span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</b> )

                            <div class="input-group">
                                <input type="text" name="subtitulo" id="subtitulo" class="form-control" value="<?php echo $ponencia["subtitulo"] ?>">
                                <div class="input-group-append">
                                    <button type="button" name="" id="editSubtitulo" class="btn btn-warning">Editar <i class="far fa-edit"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 style="padding-top: 10px;">Autores</h2>
                <h4 class="text-danger">
                Seleccione nuevamente al autor del grupo y rectifique que el nombres en la plataforma de <a href="https://iquatroeditores.org/revista/" target="_blank">iQuatro Editores</a> y RedesLA se registró de forma correcta; 
                completo y sin faltas de ortografía, si en uno de los dos campos está errónea solicite las correcciones con el equipo <a href="<?= $whatsapp ?>" target="_blank">RedesLA</a>.
                </h4>
                <hr>

                <div class="row" id="autoresRow">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-8">
                        <?php
                         foreach ($ponencia["miembros"] as $key=>$autor) {
                            $i = $key+1;
                            ?>
                            <input type="text" class="form-control" name="id_autor[]" id="id_autor_<?php echo $i ?>" value="<?php echo $autor["author_id"] ?>" required hidden>
                            <div class="form-group">
                                <label for="">Nombre</label> (Plataforma <b><span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</b> )<span class="text-danger">*</span>
                                <input type="text" class="form-control" name="autores[]" id="autor_id_a_<?php echo $i; ?>" value="<?php echo $autor["nombre"]; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">Apellidos</label> (Plataforma <b><span class="text-danger">iQ</span>u<span class="text-danger">4</span>tro Editores</b> )<span class="text-danger">*</span>
                                <input type="text" class="form-control" name="autores[]" id="autor_appat_id_a_<?php echo $i; ?>" value="<?php echo $autor["apellidos"]; ?>" required>
                            </div>

                            <div class="form-group" id="form_group_<?= $key ?>">
                                <label for="">
                                Seleccione nuevamente al autor del grupo y rectifique que el nombres en la plataforma de iQuatro Editores y RedesLA se registró de forma correcta; 
                                completo y sin faltas de ortografía, si en uno de los dos campos está errónea solicite las correcciones con el equipo RedesLA. <span>(Plataforma <b class="n_Redesla">REDESLA</b> )</span><span class="text-danger">*</span>
                                </label>
                                <select name="miembros[<?= $key ?>][usuario]" class="form-control miembros-select" required>
                                    <option selected disabled value="">Seleccione un miembro</option>
                                    <?php
                                        foreach ($miembros as $m) {
                                            ?>
                                            <option value="<?= $m['usuario'] ?>"><?= $m['nombre'] ?></option>
                                            <?php
                                        }
                                    ?>
                                    <option value="oy">Registrar como oyente</option>
                                    <option value="nc">Este autor sólo estará en la publicación, no desea acceder al congreso ni las contancias de participación.</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="button" name="editarAutor" id="id_a_<?php echo $i ?>" class="btn btn-warning btn-block">Editar <i class="fas fa-level-up" id="id_a_<?php echo $i ?>"></i></button>
                            </div>
                            <hr>
                            <?php
                         }
                        ?>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 text-center divEquipos">
                        <object id="obj_svg_2" data="<?= base_url('resources/img/svg/equipos.svg') ?>" type="image/svg+xml"></object>
                    </div>
                    
                </div>
                <hr>
                <h2>Seleccione al ponente <span class="text-danger">*</span></h2>
                <p class="text-warning">Es la persona que presentará la ponencia.</p>
                <select name="nombre_completo_ponente" id="nombre_completo_ponente" class="form-control" required>
                    <option value="" selected disabled>Seleccione a su ponente</option>
                    <?php
                    foreach ($ponencia["miembros"] as $m) {
                        $nombre = $m['nombre'] . ' ' . $m['apellidos'];
                    ?>
                        <option value="<?= $nombre ?>"><?= $nombre ?></option>
                    <?php
                    }
                    ?>
                </select>
                <input name="pub_id" id="pub_id" value="<?php echo $ponencia["pub_id"] ?>" hidden>
                <input name="submission_id" id="submission_id" value="<?php echo $ponencia["submission_id"] ?>" hidden>
                <input name="nombre_congreso" id="nombre_congreso" value="<?= $nombre_congreso ?>" hidden>
                <input name="password_congreso" id="password_congreso" value="<?= $password_ponencia ?>" hidden>
                <hr>
                <h2>Seleccione su tipo de asistencia <span class="text-danger">*</span></h2>
                <p class="text-warning">Sujeto a disponibilidad de cupo</p>
                <div class="container">
                    <div class="grid-container">
                        <div class="grid-item">
                            <label for="radio-card-1" class="radio-card">
                                <input type="radio" name="tipo_asistencia" id="radio-card-1" value="presencial" required />
                                <div class="card-content-wrapper">
                                    <span class="check-icon"></span>
                                    <div class="card-content">
                                        <img src="<?= base_url('resources/img/svg/undraw_conference_re_2yld.svg') ?>" alt="" />
                                        <h4>Presencial</h4>
                                        <h5>Realizada en la institución anfitriona de este año</h5>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="grid-item">
                            <label for="radio-card-2" class="radio-card">
                                <input type="radio" name="tipo_asistencia" id="radio-card-2" value="virtual" required />
                                <div class="card-content-wrapper">
                                    <span class="check-icon"></span>
                                    <div class="card-content">
                                        <img src="<?= base_url('resources/img/svg/undraw_video_call_re_4p26.svg') ?>" alt="" />
                                        <h4>Virtual</h4>
                                        <h5>Realizada mediante nuestro espacio virtual <b>VIVE REDESLA</b></h5>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- /.radio-card -->
                    </div>
                    <!-- /.grid-wrapper -->
                </div>
                <!-- /.container -->
                <br>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="checkbox" name="checkbox">
                        Acepto las <a href="#Modal" data-bs-toggle="modal">condiciones</a> para solicitar constancia de participación
                    </div>
                </div>


                <div id="Modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title text-left">Condiciones</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>
                                Apreciables participantes, los siguientes datos han sido autocompletados con la información registrada en "Libros iQuatro Editores" 
                                al enviar su ponencia, debe escribir los datos que desea corregir tal y como se PUBLICARÁN, evite colorar grados académicos y abreviaturas.
                                </p>
                                <p>
                                Si el sistema NO MUESTRA todos sus autores, debe verificar que los registró en la sección de Autoría y colaboradores/as al realizar el 
                                envío en la etapa 3. Introducir los metadatos, o bien en la sección de envíos en Publicación y colaboradores/as, para solicitar la 
                                actualización de sus datos debe enviar la siguiente información a la editorial (<a href="<?= $whatsapp ?>"><?= $whatsapp ?></a>) o el equipo RedesLA.
                                </p>
                                <p>
                                    <ul style="margin-left: 1rem">
                                        <li>Nombre completo:</li> 
                                        <li>Grado académico: </li>
                                        <li>Institución de afiliación:</li>
                                        <li>Nacionalidad:</li>
                                        <li>Especialidad:</li>
                                        <li>Teléfono: </li>
                                        <li>Correo personal (obligatorio):</li>
                                        <li>Correo institucional:</li>
                                        <li>Miembros SNI</li>
                                        <li>Nivel SNI:</li>
                                        <li>Año de obtención:</li>
                                        <li>Sexo:</li>
                                        <li>Código ORCID:</li>
                                    </ul>
                                </p>
                                <p>
                                    <i>No continúe el proceso hasta CONTAR CON SU ACTUALIZACIÓN porque no podrá modificarlos más adelante.</i>
                                </p>
                                <p>
                                    Al concluir este proceso ACEPTO que las cartas y constancias serán emitidas con la información que me 
                                    muestra el sistema, <b>ENTIENDO</b> que una vez <b>ACEPTADOS</b> los datos y <b>REGISTRADOS</b> los gafetes, ya <b>NO SE PODRÁN</b> 
                                    ejecutar cambios.
                                </p> 
                                <p>
                                    En caso de tener problemas para realizar dicha solicitud, puede enviar
                                    un mensaje de WhatsApp al número: (<a href="<?= $whatsapp ?>" target="_blank">enlace</a>) con la información necesaria.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal fade" id="miModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ejemplo de captura de metadatos en IQuatro Editores</h5>
                            <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="<?= base_url('resources/img/congresos/Ejemplo_Iquatro.png') ?>" alt="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                        </div>
                    </div>
                </div>

                <hr>
                <button type="button" class="btn btn-block bg-<?= $_SESSION['red'] ?>" id="btnRegistrar">Registrar ponencia</button>
            </div>

        </form>
    </div>
    <br><br>

    <script>
        let color = '<?= $color_red ?>'
        let color_secundario = '<?= $color_secundario ?>'
        $('a[href$="#Modal"]').on("click", function() {
            $('#Modal').modal('show');
        });

        $('a[href$="#miModal"]').on("click", function() {
            $('#miModal').modal('show');
        });

        $(document).on('click', '#btnRegistrar', function(e) {
            SwalSubmit(e);
        });

        function SwalSubmit(e) {

            swal.fire({
                title: '¿Está seguro de terminar con el registro?',
                text: "Una vez confirmados sus datos ya no los podrá modificar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Regresar',
                showLoaderOnConfirm: true
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var form = $("#formPonencia")[0];
                    var isValid = form.checkValidity();
                    if (!isValid) {
                        e.preventDefault();
                        e.stopPropagation();
                        swal.fire({
                            title: 'Cuidado',
                            text: "Complete todos los campos antes de continuar",
                            icon: 'warning'
                        })
                        form.classList.add('was-validated');
                        return false;
                    } else {
                        let formData = $("#formPonencia").serialize();
                        $.ajax({
                            type: 'post',
                            dataType: 'json',
                            url: './insertarCongreso',
                            data: formData,
                            success: function(data){
                                if(data.codigo == 200){
                                    Swal.fire({
                                        icon: "success",
                                        title: data.title,
                                        html: data.mensaje,
                                    }).then(function(){
                                        window.location.href = base_url + data.url
                                    })
                                }
                            },
                            error: function(jqXHR){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error '+jqXHR.status,
                                    html: jqXHR.responseText
                                })
                            }
                        })
                    }
                }
            })
        }

        function disableUsedOptions($table) {
            $selects = $table.find("select");
            $selects.on("change", function() {
                $selects = $table.find("select");

                //console.log("In table:");
                //console.log($table);
                //console.log("there are " + $selects.length + " selects");
                if ($selects.length <= 1) return;
                let selected = [];

                $selects.each(function(index, select) {
                    if (select.value !== "") {
                        selected.push(select.value);
                    }
                });

                //console.log("option values, that are being deactivated: " + selected);

                $table.find("option").prop("disabled", false);
                for (var index in selected) {
                    $table
                        .find('option[value="' + selected[index] + '"]:not(:selected)')
                        .prop("disabled", true);
                }
            });
            $selects.trigger("change");
        }

        $table = $('#autoresRow');
        //disableUsedOptions($table);

        document.addEventListener('DOMContentLoaded', function() {
            var svgElement = document.getElementById('obj_svg'); // Obtiene el elemento SVG por su ID
            var svgDoc = svgElement.contentDocument; // Obtiene el documento SVG dentro del objeto <object>
            var svgPath = svgDoc.querySelectorAll('.svg_red'); // Obtiene el elemento <path> dentro del SVG
            svgPath.forEach(function(elemento) {
                elemento.style.fill = color;
            });

            var svgElement = document.getElementById('obj_svg_2'); // Obtiene el elemento SVG por su ID
            var svgDoc = svgElement.contentDocument; // Obtiene el documento SVG dentro del objeto <object>
            var svgPath = svgDoc.querySelectorAll('.svg_equipos'); // Obtiene el elemento <path> dentro del SVG
            svgPath.forEach(function(elemento) {
                elemento.style.fill = color;
            });

            var svgElement = document.getElementById('obj_svg_2'); // Obtiene el elemento SVG por su ID
            var svgDoc = svgElement.contentDocument; // Obtiene el documento SVG dentro del objeto <object>
            var svgPath = svgDoc.querySelectorAll('.svg_equipos_2'); // Obtiene el elemento <path> dentro del SVG
            svgPath.forEach(function(elemento) {
                elemento.style.fill = color_secundario;
            });
        });

        $(document).ready(function(){
            const oyentesRegistrados = [];
            const usuariosRegistrados = [];

            $('.miembros-select').on('change', function() {
                // Obtener el valor seleccionado del select
                let val = $(this).val()

                let name_select = $(this).attr('name');

                // Extraer el índice numérico del atributo "name"
                let index = name_select.match(/\[(\d+)\]/);
                
                if (!index && index.length < 1) {
                    return;
                }
                let posicion = index[1];

                if ($('#form_group_'+posicion).find('#clave_oyente_'+posicion).length) {
                    $('#clave_oyente_'+posicion).remove();
                    return;
                }

                if(val == 'oy'){
                    let html = `
                    <div id='clave_oyente_${posicion}'>
                        <div class='form-group'>
                            <label>Ingrese la clave de oyente del participante</label>
                            <input type='text' class='form-control' name='miembros[${posicion}][clave_oyente]' id='claveMiembro${posicion}' required>
                            <button type='button' class='btn btn-info btn-block validarClaveOyente' data-id='${posicion}' style='margin-top: 5px;'>Obtener información</button>
                        </div>
                    </div>
                    `;
                    $("#form_group_"+posicion).append(html)
                    return;
                }
                
                if(val != 'nc'){
                    const indice = usuariosRegistrados.indexOf(val);
                    if (indice !== -1) { // comprueba si se encontró el elemento
                        Swal.fire({
                            icon: 'warning',
                            title: 'Cuidado',
                            text: 'Este usuario ya ha sido seleccionado y no se puede volver a seleccionar. Si persiste el error, recargue la página e intente nuevamente.'
                        })
                        $("select[name='miembros["+posicion+"][usuario]'] option:eq(0)").prop("selected", true);
                        return;
                    }
                    usuariosRegistrados.push(val)
                }
                

                
            });

            $(document).on('click','.validarClaveOyente',function(){
                let id = $(this).data('id');

                let val = $("#claveMiembro"+id).val()

                let congreso = $("#nombre_congreso").val()

                let button = $(this);

                $("#claveMiembro"+id).prop('disabled',true);

                const indice = oyentesRegistrados.indexOf(val);
                if (indice !== -1) { // comprueba si se encontró el elemento
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cuidado',
                        text: 'Esta clave ya ha sido registrada en este módulo'
                    })
                    $("#claveMiembro"+id).prop('disabled',false);
                    return;
                }



                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: './getOyente',
                    data: {
                        claveCuerpo: val,
                        congreso: congreso
                    },
                    success: function(data){
                        oyentesRegistrados.push(val)
                        button.remove();
                        let img = data.profile_pic === null ? 'avatar.png': data.profile_pic
                        let html = `
                        <div class='form-group'>
                            <label>Información del oyente</label>
                            <input type='text' name='miembros[${id}][usuario]' value='${data.usuario}' hidden>
                            <input type='text' name='miembros[${id}][tipo]' value='oy' hidden>
                            <input type='text' name='miembros[${id}][claveCuerpo]' value='${data.claveCuerpo}' hidden>
                            <div class="input-group">
                                <img src="${base_url+'/resources/img/profiles/'+img}" alt="Imagen" style='width: 50px; border-radius:50%; margin-right: 5px;'>
                                <div class="input-group-append align-items-center">
                                    ${data.grado} ${data.nombre}
                                </div>
                            </div>
                        </div>
                        <div class='form-group'>
                        ¿La información no es correcta? <a data-id='${id}' data-clave='${val}' class='try text-warning' style='cursor: pointer'>Intente de nuevo</a>
                        </div>
                        `;
                        $("#clave_oyente_"+id).append(html)
                    },
                    error: function(jqXHR){
                        $("#claveMiembro"+id).prop('disabled',false);
                        swal.fire({
                            icon: 'error',
                            title: 'Error '+jqXHR.status,
                            html: jqXHR.responseText
                        })
                    }
                })
            })

            $(document).on('click','.try',function(){
                let id = $(this).data('id')
                let clave = $(this).data('clave');
                const indice = oyentesRegistrados.indexOf(clave);
                if (indice !== -1) { // comprueba si se encontró el elemento
                    oyentesRegistrados.splice(indice, 1); // elimina el elemento en el índice encontrado
                }
                $("select[name='miembros["+id+"][usuario]'] option:eq(0)").prop("selected", true);
                $("#clave_oyente_"+id).remove()
            })
            
        })

        
    </script>
</div>

<script src="<?= base_url('resources/js/form-validation/index.js') ?>"></script>
<script type="text/javascript" src="<?php echo base_url("resources/js/congreso.js") ?>"></script>