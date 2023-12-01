<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('resources/bootstrap/css/bootstrap.min.css') ?>">
    <script src="<?= base_url('resources/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('resources/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('resources/css/Releg/capitulo.css') ?>">
    <title>Redacción del capítulo de libro impreso</title>
</head>

<body>
    <div class="container">
    <form method='post' action='../getDocReleg' target="_blank" class='needs-validation' novalidate> <!--addCapitulo -->
        <section>
            <h1 class='text-center'>Proceso para análisis de resultados</h1>
            <hr>
            <p>INSTRUCCIONES</p>
            <p>Estimadas investigadoras, favor de leer atentamente las indicaciones para realizar el  análisis de resultados.</p>
        </section>
        <section id='categorias'>
            <div>
                <h3>Tipo de enfoque</h3>
                <p>Instrucciones: Por favor seleccionar el tipo de enfoque bajo el cual realizarán el análisis de la investigación</p>
                <select name="enfoque" id="enfoque" class="form-control" required>
                    <option value="" selected disabled>Seleccione una opción</option>
                    <option value="Educación y Pedagogía">Educación y Pedagogía</option>
                    <option value="Empresarial/Negocios/Administración">Empresarial/Negocios/Administración</option>
                </select>
            </div>
            <hr>
            <div id="hoja">
                <h3>
                Capítulo ___. Los obstáculos que tienen las estudiantes de la <?= $universidad ?> que dirigen una micro o pequeña empresa en <?= $municipios ?>.
                </h3>
                <p>
                    <ul>
                        <?php
                        foreach($ordenes_autores as $o){
                            ?>
                            <li><?= $o ?></li>
                            <?php
                        }
                        ?>
                    </ul>
                </p>
                <h3>Resumen</h3>
                <p>Trabajando por parte del Comité Revisor RELEG.</p>
                <h3>Palabras clave</h3>
                <p>Trabajando por parte del Comité Revisor RELEG.</p>
                <h3>Introducción</h3>
                <p>Trabajando por parte del Comité Revisor RELEG.</p>
                <h3>Metodología</h3>
                <p>Trabajando por parte del Comité Revisor RELEG.</p>
                <h3>Resultados</h3>
                <p>
                    En este apartado se presenta el análisis de resultados de la investigación cualitativa realizada a <?= $c_entrevistas ?> estudiantes universitarias de <?= $universidad_completo ?>.
                </p>
                <p>
                    Las unidades de análisis son los párrafos que conforman las respuestas a las preguntas eje de este trabajo. A partir del análisis a estas unidades surgieron los códigos en vivo 
                    que dieron origen a las categorías (Hernández Sampieri et al., 2014). 
                </p>
                <p>
                    Las categorías que emergieron en esta institución de educación superior y que describen los obstáculos de las mujeres universitarias que dirigen una Mype son: 
                    <?= $str_categorias ?>. 
                </p>
                <p>
                    Para fines de este capítulo, se determinó analizar las 5 categorías más importantes que describen los obstáculos que presentan las mujeres universitarias de 
                    <?= $universidad ?>, que dirigen o son dueñas de una micro o pequeña empresa. La importancia fue determinada a partir del orden y constancia con la que 
                    fueron emergiendo a lo largo del proceso de análisis de las entrevistas. 
                </p>
            <?php
            $i = 1;
            foreach ($categorias as $c) {
            ?>
                <div id="divCat<?= $c['id'] ?>">
                    <h4><?= $c['nombre'] ?></h4>
                    <p>Descripción de la categoría</p>
                    <p><?= $c['descripcion'] ?></p>
                    <p><b>Instrucciones</b>: Estimadas investigadoras, para este apartado, por favor seleccionar los 2 códigos en vivo que ustedes consideren son los que <b style="color:red">mejor describen el obstáculo</b> que define la categoría.</p>
                    <p><button type="button" class="btn btn-sm btn-dark" name="table_codigos" data-id="<?= $c['id'] ?>" data-toggle="modal" data-target="#modal_codigos_<?= $c['id'] ?>">Ver lista de códigos en vivo de la <?= $c['nombre'] ?></button></p>
                    <div class="modal modal-lg" id="modal_codigos_<?= $c['id'] ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Códigos en vivo de <?= $c['nombre'] ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <table class="table table-striped table-dark table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>ID de entrevista</th>
                                        <th>Código en vivo</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($c['lista_codigos'] as $l){
                                        ?>
                                        <tr>
                                            <td><?= $l['id_entrevista'] ?></td>
                                            <td><?= $l['codigo_en_vivo'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    for ($i = 1; $i <= 2; $i++) {
                    ?>
                        <div class='row' id='categoria_<?= $c['id'] ?>_<?= $i ?>'>
                            <div class='col-md-3'>
                                <select class='form-control' id='select_entrevista_<?= $c['id'] ?>_ciclo_<?= $i ?>' name='categorias[<?= $c['id'] ?>][<?= $i ?>][id_entrevista]' onchange="getEntrevistas(<?= $c['id'] ?>,<?= $i ?>)" required>
                                    <option value='' selected disabled>Seleccione una entrevista</option>
                                    <?php
                                    foreach($c['entrevistas'] as $e){
                                        ?>
                                        <option value="<?= $e ?>" ><?= $e ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class='col-md-9'>
                                <select class='form-control' id='select_codigo_<?= $c['id'] ?>_ciclo_<?= $i ?>' id='select_categoria_<?= $c['id'] ?>_ciclo_<?= $i ?>' name='categorias[<?= $c['id'] ?>][<?= $i ?>][codigo_en_vivo]' required onchange="getinfoEntrevista(<?= $c['id'] ?>,<?= $i ?>)">
                                    <option value='' selected disabled>Seleccione un código en vivo</option>
                                </select>
                            </div>
                        </div>
                        <div id="info_entrevista_<?= $c['id'] ?>_ciclo_<?= $i ?>">
                                    
                        </div>
                        <br>
                    <?php
                    }
                    ?>
                    <h4>Análisis</h4>
                    <p>
                    <b>Instrucciones para análisis de categoría</b><br>
                    Instrucciones: Estimadas investigadoras, en este apartado <b>se describe el análisis que se hace sobre la <?= substr($c['nombre'], 0, -1) ?></b>, es importante que expliquen cómo entienden este obstáculo las universitarias que fueron entrevistadas y que externaron alguna experiencia al respecto. 
                    Es importante llevar a cabo el análisis, tomando en cuenta los datos demográficos de sus entrevistadas. Por ejemplo, en qué edades, en qué estado civil o algún otro dato demográfico que consideren, se presentó con mayor frecuencia esta categoría y a partir de ello dar posibles explicaciones al fenómeno. 
                    <b style="color:red">IMPORTANTE: NO recurrir a porcentajes, cifras o números.</b><br>
                    De igual manera es SUMAMENTE PERTINENTE que el análisis de estos códigos en vivo que describen la experiencia de las universitarias, explicarlos bajo LAS PARTICULARIDADES DEL CONTEXTO QUE RODEAN A LA INSTITUCIÓN EDUCATIVA, DEL MUNICIPIO O DEL ESTADO DE LA REPÚBLICA EN EL QUE SE LLEVÓ A CABO LA INVESTIGACIÓN.
                    </p>
                    <textarea name='categorias[<?= $c['id'] ?>][analisis]' class='form-control' placeholder="Redactar el análisis de la categoría: <?= $c['nombre'] ?>" required minlength='300' maxlength='350'></textarea>
                    <br>
                </div>
            <?php
                /*
                echo "<div id='divCat" . $c['id'] . "'>";
                echo "<h4>" . $c['nombre'] . "</h4>";
                echo '<p><u>Cantidad de códigos en vivo encontrados: '.$c['cantidad'].'</u></p>';
                echo "<p>Descripción de la categoría: </p>";
                echo "<p>" . $c['descripcion'] . "</p>";
                echo "<p class='text-right'><i>Esta sección se incluye en el capítulo 1, más no en el capítulo que les corresponde 
                a ustedes</i> <button name='addCategoria' id='addCategoria_" . $c['id'] . "' type='button' class='btn btn-success' data-id='" . $c['id'] . "'>Añadir categoría</button></p>";
                echo "</div>";
                $i++;
                */
            }
            ?>
            <div class="row">
            <button type="submit" class="btn btn-block btn-success">Guardar</button>
            </div>
            </div>
            
        </section>

        <!--
        <section id='introduccion'>
            <h1>Introducción</h1>
            <textarea class='form-control' name='introduccion' id='introduccionSectionValue' value='' required></textarea>
            <h1>Discusión</h1>
            <textarea class='form-control' name='discusion' id='discusionSectionValue' value='' required></textarea>
        </section>
        <section id='Capitulo'>
            Aqui concatenaremos todo
        </section>
        -->

    </form>
    <footer>
        <h3 class="text-center">¿Tienes un problema?</h3>
        <p class="text-center">Envianos un correo describiéndonos tu problema a la siguiente dirección:</p>
        <p class="text-center">jaramosp@e.redesla.net</p>
    </footer>
    </div>

    <script>

        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                            alert('Favor de completar todos los campos.')
                        }


                        form.classList.add('was-validated')
                    }, false)
                })
        })();

        let agregoCategoria = 0;

        $("button[name='addCategoria']").on('click', function(e) {
            agregoCategoria++;
            if (agregoCategoria > 5) {
                alert('Selecciono el maximo de categorias posibles')
                agregoCategoria--;
                return;
            }
            $("#capitulo").prop('disabled', false);
            $(this).prop('disabled', true);
            let id = e.target.dataset.id;
            let pathArray = window.location.pathname.split('/');
            let ca = pathArray[4];
            $.ajax({
                url: './../getEntrevistas',
                type: "POST",
                dataType: "json",
                data: {
                    ca: ca,
                    categoria: id
                },
                success: function(data) {
                    let str_options = ''
                    data.map(function(valor) {
                        str_options += `<option value="${valor.id_entrevista}" >${valor.id_entrevista}</option>`
                    });

                    $("#divCat" + id).append(`
                    <div id='info_cat_${id}'>
                        <h3>Análisis de resultados de la categoría</h3>
                        <textarea name='categorias[${id}][analisis]' class='form-control' required min='300' max='500'></textarea>
                        <p>Seleccione sus códigos en vivo</p>
                        <div id='categorias_info_${id}'>
                            <div class='row' id='categoria_${id}_1'>
                                <div class='col-md-3'>
                                    <select class='form-control' id='select_entrevista_${id}_ciclo_1' name='categorias[${id}][1][id_entrevista]' onchange='getEntrevistas(${id},1)' required>
                                        <option value='' selected disabled>Seleccione una entrevista</option>
                                        ${str_options}
                                    </select>
                                </div>
                                <div class='col-md-9'>
                                    <select class='form-control' id='select_codigo_${id}_ciclo_1' id='select_categoria_${id}_ciclo_1' name='categorias[${id}][1][codigo_en_vivo]' required>
                                        <option value='' selected disabled>Seleccione un código en vivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <button class='btn btn-block btn-success' type='button' id='btn_${id}' onclick='siguiente(2,${id})' >Agregar otro código en vivo</button>
                            <br>
                            <button class='btn btn-block btn-danger' type='button' onclick='removeCategoria(${id})'>Remover categoría</button>
                        </div>
                    </div>
                    `)
                },
                error: function(error) {
                    console.log(`Error ${error}`);
                }
            });
        })

        function siguiente(siguiente, id) {
            let pathArray = window.location.pathname.split('/');
            let ca = pathArray[4];
            $.ajax({
                url: './../getEntrevistas',
                type: "POST",
                dataType: "json",
                data: {
                    ca: ca,
                    categoria: id
                },
                success: function(data) {
                    let str_options = ''
                    data.map(function(valor) {
                        str_options += `<option value="${valor.id_entrevista}" >${valor.id_entrevista}</option>`
                    });

                    let htmlSiguiente = `
                    <br>
                    <div class='row' id='categoria_${id}_1'>
                        <div class='col-md-3'>
                            <select class='form-control' id='select_entrevista_${id}_ciclo_${siguiente}' name='categorias[${id}][${siguiente}][id_entrevista]' onchange='getEntrevistas(${id},${siguiente})' required>
                                <option value='' selected disabled>Seleccione una entrevista</option>
                                    ${str_options}
                            </select>
                        </div>
                        <div class='col-md-9'>
                            <select class='form-control'  id='select_codigo_${id}_ciclo_${siguiente}' name='categorias[${id}][${siguiente}][codigo_en_vivo]' required>
                                <option value='' selected disabled>Seleccione un código en vivo</option>
                            </select>
                        </div>
                    </div>
                    `;
                    let sig_btn = parseInt(siguiente) + 1;

                    //AQUI DELIMITAS LA CANTIDAD DE CODIGOS EN VIVO QUE SE QUIEREN POR CATEGORIA
                    if (sig_btn <= 2) {
                        $("#btn_" + id).attr("onclick", "siguiente(" + sig_btn + "," + id + ")");
                    } else {
                        $("#btn_" + id).remove();
                    }

                    $("#categorias_info_" + id).append(htmlSiguiente);
                },
                error: function(error) {
                    console.log(`Error ${error}`);
                }
            });

        }

        function removeCategoria(id) {
            agregoCategoria--;
            if (agregoCategoria == 0) {
                $("#capitulo").prop('disabled', true);
            }
            $("#info_cat_" + id).remove();
            $("#addCategoria_" + id).prop('disabled', false);
        }

        function getEntrevistas(id, actual) {
            let entrevista = $('#select_entrevista_' + id + '_ciclo_' + actual).find(":selected").val();
            $('#info_entrevista_' + id + '_ciclo_' + actual).empty()
            $.ajax({
                url: './../getCodigos',
                type: "POST",
                dataType: "json",
                data: {
                    entrevista: entrevista,
                    categoria: id
                },
                success: function(data) {
                    let str_options_codigos = `<option value='' selected disabled>Seleccione un código en vivo</option>`

                    data.map(function(valor) {
                        str_options_codigos += `<option value="${valor.id}" >${valor.codigo_en_vivo}</option>`
                    });

                    $('#select_codigo_' + id + '_ciclo_' + actual).empty()
                    $('#select_codigo_' + id + '_ciclo_' + actual).append(str_options_codigos);


                },
                error: function(error) {
                    console.log(`Error ${error}`);
                }
            });

        }

        $("input[name='seccion']").on('change', function() {
            let val = $(this).val();
            if (val == 'adicionales') {
                $("#categorias").hide();
                $("#Capitulo").hide();
                $("#introduccion").show();
            } else if (val == 'Categorias') {
                $("#categorias").show();
                $("#Capitulo").hide();
                $("#introduccion").hide();
            } else if (val == 'capitulo') {
                $("#categorias").hide();
                $("#Capitulo").show();
                $("#introduccion").hide();
                if (agregoCategoria == 0) {
                    alert('Favor de agregar por lo menos una categoría')
                } else {
                    $('form').submit();
                }
            }
        })

        function getinfoEntrevista(id,actual){
            let id_codigo = $('#select_codigo_' + id + '_ciclo_' + actual).find(":selected").val();
            $.ajax({
                url: './../getInfoEntrevista',
                type: "POST",
                data: {
                    id_codigo: id_codigo
                },
                success: function(data) {
                    $('#info_entrevista_' + id + '_ciclo_' + actual).empty().append('<i>'+data+'</i>')
                },
                error: function(error) {
                    console.log(`Error ${error}`);
                }
            });
        }

        
        $("button[name='table_codigos']").click(function(){
            let id = $(this).data('id')
            $('#modal_codigos_'+id).modal('show').appendTo('body');
        })

        $("textarea").on("keyup", function() {
            let name = $(this)[0]['name'];
            let val = $(this).val()
            localStorage.setItem(name,val);
        });
        
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        <?php if( session()->getFlashdata('icon') ){ ?>
            Swal.fire({
                icon: '<?= session()->getFlashdata('icon') ?>',
                title: '<?= session()->getFlashdata('title') ?>',
                text: '<?= session()->getFlashdata('text') ?>',
            })
        <?php } ?>
        const textareas = document.getElementsByTagName('textarea');
        for (var i = 0; i < textareas.length; i++) {
            let name = textareas[i].name;
            let val = localStorage.getItem(name);
            $("textarea[name='"+name+"']").val(val)
        }
        //console.log(textareas);
    })
</script>

    <!--
    <script type="text/javascript">
        var base_url = "<?= base_url() ?>";
        var agregoCategoria = 0;
        var arr_entrevistas = [];
        var pathArray = window.location.pathname.split('/');
        var ca = pathArray[4];

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                            Swal.fire({
                                icon: 'warning',
                                title: 'Favor de completar todos los campos'
                            })
                        }
                        if (agregoCategoria == 0) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Favor de agregar por lo menos una categoría'
                            })
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()


        $(document).ready(function() {
            $("#introduccion").hide();
            $("#Capitulo").hide();
            var pathArray = window.location.pathname.split('/');
            var ca = pathArray[4];
            $.ajax({
                url: base_url + '/proyecto/capitulo/getEntrevistas',
                type: "POST",
                dataType: "json",
                data: {
                    ca: ca
                },
                success: function(data) {
                    arr_entrevistas = data;
                },
                error: function(error) {
                    console.log(`Error ${error}`);
                }
            });
        });

        $("button[name='addCategoria']").on('click', function(e) {
            $(this).prop('disabled', true);
            //FALTA LO DE LAS DESCRIPCIONES ABAJO, NO SE PUEDEN CON ID PORQUE SON INCREMENTALES, POR LO QUE OCUPAMOS SER POR NAME EN ONCHANGE PERO HAY QUE VER COMO HACERLE
            id = e.target.dataset.id;
            var categoria = $("#nombreCategoria_" + id).val();
            var descripcion = $("#descripcionCategoria_" + id).val();
            $.ajax({
                url: base_url + '/proyecto/capitulo/getEntrevistas',
                type: "POST",
                dataType: "json",
                data: {
                    ca: ca,
                    categoria: id
                },
                success: function(data) {
                    arr_entrevistas = data;
                    var arr_id = "";
                    //es el id al que le vamos a hacer append
                    arr_entrevistas.map(function(valor) {
                        arr_id += `<option value="` + valor.id_entrevista + `" data-id='` + id + `'>` + valor.id_entrevista + `</option>`
                    });
                    html = `
                    <div id='datosCat` + id + `'>
                    <h3>Análisis de resultados de la categoría</h3>
                    <input id='valorCiclo` + id + `' value='1' hidden />
                    <textarea name='categorias[` + id + `][presentacion]' class='form-control' value='' required></textarea>
                    <h3>Código en vivo</h3>
                    <div class="input-group mb-3">
                    <div class='col-md-3'>
                    <select class="form-select" name='categorias[` + id + `][entrevistas][entrevista` + 1 + `][id]' onChange='changeSelect(this,this.value)' required>
                        <option selected disabled value="">Selecciona una entrevista</option>
                        ` + arr_id + `
                    </select>
                    </div>
                    <input type="text" class="form-control" name='categorias[` + id + `][entrevistas][entrevista` + 1 + `][codigo_en_vivo]' value='' required><br>
                    </div>
                    <p id='descripcionCiclo` + id + `'></p>
                    <div id='caracteristicasCat` + id + `'></div>
                    <div id='entrevistasCat` + id + `'></div>
                    <input type="text" hidden name='categorias[` + id + `][categoria]' value='` + categoria + `' />
                    <input type="text" hidden name='categorias[` + id + `][descripcion]' value='` + descripcion + `' />
                    <hr>
                    <button class='btn form-control btn-info' data-id='` + id + `' id='addEntrevista` + id + `' type='button'>Añadir otro código en vivo </button>
                    <button class='btn form-control btn-danger' data-id='` + id + `' name='eliminarCategoria'>Eliminar esta categoría</button>
                    </div>`;
                    $("#divCat" + id).append(html);
                    agregoCategoria = agregoCategoria + 1;
                    $("button[name='eliminarCategoria']").on('click', function(e) {
                        e.stopImmediatePropagation();
                        id = e.target.dataset.id;
                        $("#datosCat" + $(this).data("id")).remove();
                        agregoCategoria = agregoCategoria - 1;
                        $("#addCategoria_" + $(this).data("id")).prop('disabled', false);
                    });
                    $("#addEntrevista" + id).on('click', function(e) {
                        ciclo = $("#valorCiclo" + id).val();
                        ciclo = parseInt(ciclo) + 1;
                        var arr_id = "";
                        arr_entrevistas.map(function(valor) {
                            arr_id += `<option value="` + valor.id + `" data-id='` + id + `' data-ciclo='` + ciclo + `'>` + valor.id + `</option>`
                        });
                        entrevista = `
                    <div class="input-group mb-3">
                    <div class='col-md-3'>
                    <select class="form-select" name='categorias[` + id + `][entrevistas][entrevista` + ciclo + `][id]' onChange='changeSelect2(this,this.value)' required>
                    <option selected disabled value="">Selecciona una entrevista</option>
                    ` + arr_id + `
                    </select>
                    </div>
                    <input type="text" class="form-control" name='categorias[` + id + `][entrevistas][entrevista` + ciclo + `][codigo_en_vivo]' value='' required>
                    </div>
                    <p id='descripcionCiclo` + id + `_` + ciclo + `'></p>
                `;

                        $("#entrevistasCat" + $(this).data("id")).append(entrevista);
                        $("#valorCiclo" + id).val(ciclo);
                    });
                },
                error: function(error) {
                    console.log(`Error ${error}`);
                }
            });



        });

        $("input[name='seccion']").on('change', function() {
            if ($(this).val() == 'adicionales') {
                $("#categorias").hide();
                $("#Capitulo").hide();
                $("#introduccion").show();
            } else if ($(this).val() == 'Categorias') {
                $("#categorias").show();
                $("#Capitulo").hide();
                $("#introduccion").hide();
            } else if ($(this).val() == 'capitulo') {
                $("#categorias").hide();
                $("#Capitulo").show();
                $("#introduccion").hide();
                if (agregoCategoria == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Favor de agregar por lo menos una categoría'
                    })
                } else {
                    $('form').submit();
                }
            }
        })

        function changeSelect(e, id_select) {
            var opt = e.options[e.selectedIndex];
            var data = opt.dataset.id;
            arr_entrevistas.map(function(valor) {
                if (valor.id == id_select) {
                    var txt = "Universitaria de " + valor.pregunta1 + ' años, ' + valor.pregunta2;
                    if (valor.pregunta3 == "no") {
                        txt += ", sin hijos";
                    } else {
                        txt += ", " + valor.pregunta4 + " hijos";
                    }
                    tipo_uni = valor.pregunta12 == "público" ? "pública" : "privada";
                    txt += ", " + valor.pregunta6 + ", universidad " + tipo_uni + ". Estado de " + valor.pregunta10;
                    $("#descripcionCiclo" + data).html(txt);
                    var input = "<input type='text' hidden name='categorias[" + data + "][entrevistas][entrevista1][caracteristicas]' value='" + txt + "' />";
                    $("#caracteristicasCat" + data).html(input);
                    console.log('input[name="categorias[' + data + '][entrevistas][entrevista1][caracteristicas]"]');
                }
            });
        }

        function changeSelect2(e, id_select) {
            var opt = e.options[e.selectedIndex];
            var data = opt.dataset.id;
            var ciclo = opt.dataset.ciclo;
            arr_entrevistas.map(function(valor) {
                if (valor.id == id_select) {
                    var txt = "Universitaria de " + valor.pregunta1 + ' años, ' + valor.pregunta2;
                    if (valor.pregunta3 == "no") {
                        txt += ", sin hijos";
                    } else {
                        txt += ", " + valor.pregunta4 + " hijos";
                    }
                    tipo_uni = valor.pregunta12 == "público" ? "pública" : "privada";
                    txt += ", " + valor.pregunta6 + ", universidad " + tipo_uni + ". Estado de " + valor.pregunta10;
                    $("#descripcionCiclo" + data + '_' + ciclo).html(txt);
                    var input = "<input type='text' hidden name='categorias[" + data + "][entrevistas][entrevista" + ciclo + "][caracteristicas]' value='" + txt + "' />";
                    $("#caracteristicasCat" + data).append(input);
                }
            });
        }
    </script>
    -->

</body>

</html>