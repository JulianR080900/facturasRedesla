<style>
    input::-webkit-outer-spin-button,

    input::-webkit-inner-spin-button {

        -webkit-appearance: none;

        margin: 0;

    }



    /* Firefox */

    input[type=number] {

        -moz-appearance: textfield;

    }

    ul#impreso li:hover,
    ul#digital li:hover {
        background-color: var(--<?= $_SESSION['red'] ?>) !important;
    }
</style>


<div class="content">

    <!--

    Aqui obtenemos los datos de la tabla carpetas con respuescto a la respuesta del usuario

    Condicionamos con año y con CA, si no hay, no se mostrara si hay se muestra

    dentro de los if's van a ir los datos correspondientes, formularios, listados, etc.

    -->

    <?php

    if (isset($instruccion_investigacion)) {
    ?>
        <div class="card card-header-congresos">

            <div class="card-header">

                <h3><?= $instruccion_investigacion['tipo'] . ' ' . strtoupper($instruccion_investigacion['red']) . ' ' . $instruccion_investigacion['anio'] ?></h3>

            </div>

            <div class="card-body card-body-congresos">
                <?= $instruccion_investigacion['instrucciones']; ?>
                <?php
                #VAMOS A HACER LAS CUESTIONES DE LO QUE TIENEN QUE HACER EN FORMA DE FUNCIONES, IGUAL QUE ABAJO PERO MAS ORDENADITO JAJAJAJA
                switch ($instruccion_investigacion['tipo'] . '_' . $instruccion_investigacion['red'] . '_' . $instruccion_investigacion['anio']) {
                    case 'Investigación_Relayn_2023':
                        investigacionrelayn2023($investigacion);
                        break;
                    case 'Investigación_Relen_2023':
                        investigacionrelen2023($investigacion);
                        break;
                    case 'Investigación_Relep_2023':
                        investigacionrelep2023($investigacion);
                        break;
                    case 'Investigación_Releg_2022':
                        investigacionreleg2022($info);
                        break;
                    default:
                        echo 'Apartado en desarrollo';
                        break;
                }
                ?>
            </div>
        </div>
    <?php
    } else {

        $nombre = $info['nombre_esquema'];

        $nombre = str_replace("_", " ", $nombre);

        $nombre = urldecode($nombre);

        $nombre = trim($nombre);

        if (empty($info)) {

            echo "<h1>Lo sentimos, no tienes enlaces en este proyecto</h1>";
        } else {

            switch ($nombre) {

                case 'Esquema A: Investigación Relep 2021-2022': //NUEVO

                    investigacionRelep2021_2022($nombre, $info);

                    break;

                case 'Esquema B: Investigación Relep 2021-2022':

                    investigacionRelep2021_2022($nombre, $info);

                    break;

                case 'Esquema A: Investigacion Relen 2021-2022':

                    investigacionRelen2022($nombre, $info);

                    break;

                case 'Esquema B: Investigacion Relen 2021-2022':

                    investigacionRelen2022($nombre, $info);

                    break;

                case 'Esquema A: Investigacion Relayn 2022':

                    investigacionRelayn2022($nombre, $info);

                    break;

                case 'Esquema B: Investigacion Relayn 2022':

                    investigacionRelayn2022($nombre, $info);

                    break;

                case 'Esquema A: Investigación Releg 2022':

                    investigacionRelmo2022($nombre, $info);

                    break;

                case 'Esquema B: Investigación Releg 2022':

                    investigacionRelmo2022($nombre, $info);

                    break;

                case 'Congreso Relep 2022':

                    break;

                case 'Desafío Releem 2022':

                    desafioReleem2022($nombre, $info);

                    break;

                case 'Esquema A: Oyente individual presencial con callejoneada Releem 2022':

                    esquemaAReleem2022($nombre, $info);

                    break;

                case 'prueba Relmo 2022':

                    pruebarelmo($nombre, $info);

                    break;



                    // Nuevos Proyectos

                case 'Esquema B: Oyente individual virtual Releem 2022':

                    esquemaBReleem2022($nombre, $info);

                    break;

                case 'Esquema C: Oyente grupal virtual Releem 2022':

                    esquemaCReleem2022($nombre, $info);

                    break;

                case 'Esquema D: Oyente individual virtual con constancia Releem 2022':

                    esquemaDReleem2022($nombre, $info);

                    break;

                case 'Esquema E: Oyente individual presencial sin callejoneada Releem 2022':

                    esquemaEReleem2022($nombre, $info);

                    break;

                case 'Esquema F: Oyente grupal presencial sin callejoneada Releem 2022':

                    esquemaFReleem2022($nombre, $info);

                    break;

                case 'Esquema G: Oyente grupal presencial con tradicional callejoneada Releem 2022':

                    esquemaGReleem2022($nombre, $info);

                    break;

                default:

                    echo "No hay enlaces para esta investigacion: <u>$nombre</u>";

                    break;
            }
        }
    }

    ?>

</div>


<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script type="text/javascript">
    $("input[type=number]").on("keydown", function(e) {

        var invalidChars = ["-", "+", "e"]; //include "." if you only want integers

        if (invalidChars.includes(e.key)) {

            e.preventDefault();

        }

    });
</script>

<script>
    var t = [];

    const lista = document.getElementById('lista');

    Sortable.create(lista, {

        animation: 150,

        chosenClass: "seleccionado",

        //ghostClass: "fantasma",

        dragClass: 'drag',



        onEnd: () => {

            console.log('se inserto un elemento')

        },

        group: 'lista-ordenamiento',

        store: {

            //guardamos el orden de la lista

            set: (sortable) => {

                const orden = sortable.toArray();

                t = sortable.toArray();

                localStorage.setItem(sortable.options.group.name, orden.join('|'));

            },

            //OBTENEMOS EL ORDEN DE LA LISTA

            get: (sortable) => {

                const orden = localStorage.getItem(sortable.options.group.name);

                orden ? t = orden.split('|') : '';

                return orden ? orden.split('|') : [];

            }

        }

    });



    $("#confirmacion").on("click", function() {

        if (t.length == 0) {

            swal.fire({

                icon: 'warning',

                title: 'Favor de hacer un movimiento para seguir'

            })

        } else {

            var listadoText = "";

            var ultimo = t.length;

            var i = 1;

            t.forEach(function(valor, indice, array) {

                var usuario = valor;

                nombre = $("#" + usuario).val();

                i == ultimo ? listadoText += nombre + "." : listadoText += nombre + ", ";

                i++;

            });

            swal.fire({

                icon: 'warning',

                title: 'El orden de los autores sera el siguiente',

                html: listadoText + '<br><b>Desea continuar?</b>',

                showCancelButton: true,

                confirmButtonColor: '#3085d6',

                cancelButtonColor: '#d33',

                confirmButtonText: 'Si',

                cancelButtonText: 'No'

            }).then((result) => {

                if (result.isConfirmed) {

                    var valParam = JSON.stringify(t);

                    $.ajax({

                            url: base_url + "orden/digital",

                            type: 'POST',

                            dataType: 'json',

                            data: {
                                valParam: valParam
                            }

                        })

                        .done(function(response) {

                            if (response) { //devuelve true

                                swal.fire({

                                    icon: 'success',

                                    title: 'Orden registrado correctamente'

                                }).then(function() {

                                    location.reload();

                                })

                            }

                        })

                        .fail(function(jqXHR, textStatus, errorThrown) {

                            swal.fire('Oops...', 'Algo sali贸 mal con ajax !', 'error');

                            console.log(errorThrown);

                        });

                }

            })

        }

    })
</script>



<script>
    var d = [];

    const listaDigital = document.getElementById('lista_impreso');

    Sortable.create(listaDigital, {

        animation: 150,

        chosenClass: "seleccionado",

        //ghostClass: "fantasma",

        dragClass: 'drag',



        onEnd: () => {

            console.log('se inserto un elemento')

        },

        group: 'lista-ordenamiento-impreso',

        store: {

            //guardamos el orden de la lista

            set: (sortable) => {

                const orden = sortable.toArray();

                d = sortable.toArray();

                localStorage.setItem(sortable.options.group.name, orden.join('|'));

            },

            //OBTENEMOS EL ORDEN DE LA LISTA

            get: (sortable) => {

                const orden = localStorage.getItem(sortable.options.group.name);

                orden ? d = orden.split('|') : '';

                return orden ? orden.split('|') : [];

            }

        }

    });



    $("#confirmacion_impresos").on("click", function() {

        if (d.length == 0) {

            swal.fire({

                icon: 'warning',

                title: 'Favor de hacer un movimiento para seguir'

            })

        } else {

            var listadoText = "";

            var ultimo = d.length;

            var i = 1;

            d.forEach(function(valor, indice, array) {

                var usuario = valor;

                nombre = $("#d_" + usuario).val();

                i == ultimo ? listadoText += nombre + "." : listadoText += nombre + ", ";

                i++;

            });

            swal.fire({

                icon: 'warning',

                title: 'El orden de los autores sera el siguiente',

                html: listadoText + '<br><b>Desea continuar?</b>',

                showCancelButton: true,

                confirmButtonColor: '#3085d6',

                cancelButtonColor: '#d33',

                confirmButtonText: 'Si',

                cancelButtonText: 'No'

            }).then((result) => {

                if (result.isConfirmed) {

                    var valParam = JSON.stringify(d);

                    $.ajax({

                            url: base_url + "orden/impreso",

                            type: 'POST',

                            dataType: 'json',

                            data: {
                                valParam: valParam
                            }

                        })

                        .done(function(response) {

                            if (response) { //devuelve true

                                swal.fire({

                                    icon: 'success',

                                    title: 'Orden registrado correctamente'

                                }).then(function() {

                                    location.reload();

                                })

                            }

                        })

                        .fail(function(jqXHR, textStatus, errorThrown) {

                            swal.fire('Oops...', 'Algo sali贸 mal con ajax !', 'error');

                            console.log(errorThrown);

                        });

                }

            })

        }

    })
</script>