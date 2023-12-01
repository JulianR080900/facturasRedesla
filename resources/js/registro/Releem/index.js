// ===================== Primera Seccion ========================

$(document).ready(function () {

    $("#prodep").hide();

    $("#cantidad_miembros").hide();

    $("#datos_miembros").hide();

    $("#datos_miembro_1").hide();

    $("#datos_miembro_2").hide();

    $("#datos_miembro_3").hide();

    $("#datos_miembro_4").hide();

    $("#informacion_general").hide();

    $("#direcciones_universidad").hide();

    $("#prodep_universidad").hide();

    $("#numeros_universidad").hide();

    $("#inst_universidad").hide();

    $("#cantidad_alumnos").hide();

    $("#datos_alumnos").hide();

    $("#divUniversidadAdscripcion").hide(); //NUEVO

    $("#direcciones_universidad").hide(); //NUEVO

    $("#divEnviosDocumentos").hide();

    $.ajax({

        type: "POST",

        url: base_url + "/nacionalidad",

        data: {},

        success: function (data) {

            $("#nacionalidad1").html(data);

            $("#nacionalidad2").html(data);

            $("#nacionalidad3").html(data);

            $("#nacionalidad4").html(data);

        },

    });

});



$("input[name='tipo_registro']").on('change', function () {

    tipo_registro = this.value;

    if (tipo_registro == "investigación") {

        $("#informacion_general").show('slow');

        $("#direcciones_universidad").show('slow');

        $("#prodep_universidad").show('slow');

        $("#numeros_universidad").show('slow');

        $("#cbx_municipio").prop('required', true);

        $("#div_municipio").show('slow');

        $("#direccionUniversidad").prop('required', true);

        $("#direccionEnvio").prop('required', true);

        $("#inst_universidad").show('slow');

        $("#inst_est").prop('required', true);



        Swal.fire({

            title: '<p>Está a punto de comenzar su registro como: </p> <p style="color:#40277e">' + tipo_registro.toUpperCase() + '</p>',

            imageUrl: base_url + '/resources/img/registros_redes/Releem/investigacion.jpeg',

            imageWidth: 400,

            imageHeight: 300,

            imageAlt: 'Congreso',

            confirmButtonText: 'Continuar'

        })



    } else if (tipo_registro == "oyente") {

        $("#informacion_general").show('slow');

        $("#direcciones_universidad").hide();//ocultamos las direcciones y municipio

        $("#prodep_universidad").show('slow');

        $("#numeros_universidad").show('slow');

        $("#cbx_municipio").prop('required', false);

        $("#direccionUniversidad").prop('required', false);

        $("#direccionEnvio").prop('required', false);

        $("#div_municipio").hide();

        document.getElementById("otromunicipio").value = "NA";

        $("#inst_universidad").hide();

        $("#inst_est").prop('required', false);



        Swal.fire({

            title: '<p>Está a punto de comenzar su registro como: </p> <p style="color:#40277e">' + tipo_registro.toUpperCase() + '</p>',

            imageUrl: base_url + '/resources/img/registros_redes/Releem/oyente.jpg',

            imageWidth: 400,

            imageHeight: 300,

            imageAlt: 'Oyente',

            confirmButtonText: 'Continuar'

        })



    } else if (tipo_registro == "congreso") {

        $("#informacion_general").show('slow');

        $("#direcciones_universidad").hide();//ocultamos las direcciones y municipio

        $("#prodep_universidad").show('slow');

        $("#numeros_universidad").show('slow');

        $("#cbx_municipio").prop('required', false);

        $("#direccionUniversidad").prop('required', false);

        $("#direccionEnvio").prop('required', false);

        $("#div_municipio").hide();

        document.getElementById("otromunicipio").value = "NA";

        $("#inst_universidad").hide();

        $("#inst_est").prop('required', false);



        Swal.fire({

            title: '<p>Está a punto de comenzar su registro como: </p> <p style="color:#40277e">' + tipo_registro.toUpperCase() + '</p>',

            imageUrl: base_url + '/resources/img/registros_redes/Releem/congreso.jpeg',

            imageWidth: 400,

            imageHeight: 300,

            imageAlt: 'Congreso',

            confirmButtonText: 'Continuar'

        })

    }

});







function cambiaravatar(id) {

    //vamos a traernos el valor del radio de sexo

    var sexo = $("input[name='miembros[" + id + "][sexo]']:checked").val();

    // 1 es hombre 0 es mujer

    if (sexo == 1) {

        $("#imagenAvatar" + id).attr(

            "src",

            base_url + "/resources/img/registros_redes/avatar_hombre.png"

        );

    } else if (sexo == 0) {

        $("#imagenAvatar" + id).attr(

            "src",

            base_url + "/resources/img/registros_redes/avatar_mujer.png"

        );

    }

}



// Example starter JavaScript for disabling form submissions if there are invalid fields

(function () {

    "use strict";



    // Fetch all the forms we want to apply custom Bootstrap validation styles to

    var forms = document.querySelectorAll(".needs-validation");



    // Loop over them and prevent submission

    Array.prototype.slice.call(forms).forEach(function (form) {

        form.addEventListener(

            "submit",

            function (event) {

                $("#btnTerminarRegistro").prop('disabled', true);

                if (!form.checkValidity()) {

                    event.preventDefault();

                    event.stopPropagation();

                    swal.fire({

                        icon: "error",

                        title: "Lo sentimos",

                        text: 'Favor de completar todos los campos.'

                    });

                    $("#btnTerminarRegistro").prop('disabled', false);

                }



                form.classList.add("was-validated");

            },

            false

        );

    });

})();



$("#cbx_pais").on("change", function () {

    pais = $("#cbx_pais").val();

    $("#cbx_municipio")

        .find("option")

        .remove()

        .end()

        .append('<option value=""></option>')

        .val("");

    if (pais == 1) {

        $("#divotropais").show('slow');

        $("#otropais").prop("required", true).prop("disabled", false);

    } else {

        $("#divotropais").hide();

        $("#otropais").prop("required", false).prop("disabled", true);

    }

    $.ajax({

        type: "POST",

        url: base_url + "/getEstado",

        data: {

            pais: pais,

        },

        success: function (data) {

            $("#cbx_estado").html(data);

        },

    });

});



$("#cbx_estado").on("change", function () {

    estado = $("#cbx_estado").val();

    if (estado == 1) {

        $("#divotroestado").show('slow');

        $("#otroestado").prop("required", true).prop("disabled", false);

    } else {

        $("#divotroestado").hide();

        $("#otroestado").prop("required", false).prop("disabled", true);

    }

    $.ajax({

        type: "POST",

        url: base_url + "/getMunicipio",

        data: {

            estado: estado,

        },

        success: function (data) {

            $("#cbx_municipio").html(data);

        },

    });

});



$("#cbx_municipio").on("change", function () {

    municipio = $("#cbx_municipio").val();

    if (municipio == 1) {

        $("#divotromunicipio").show('slow');

        $("#otromunicipio").prop("required", true).prop("disabled", false);

    } else {

        $("#divotromunicipio").hide();

        $("#otromunicipio").prop("required", false).prop("disabled", true);

    }

});



$("input[name='prodep']").on("change", function () {

    prodep = this.value;

    if (prodep == "si") {

        $("#prodep").show('slow');

        $("#nombreProdep").prop("required", true);

        $("#nivelProdep").prop("required", true);

        $("#anoProdep").prop("required", true);

        $("#withoutProdep").prop("disabled", true);

    } else {

        $("#prodep").hide();

        $("#nombreProdep").prop("required", false);

        $("#nivelProdep").prop("required", false);

        $("#anoProdep").prop("required", false);

        $("#withoutProdep").prop("disabled", false);

    }

});



$("#siguiente_miembros").on("click", function () {

    $("#cantidad_miembros").show('slow');

    $("#datos_universidad").hide();

});

// ===================== Fin Primera Seccion ========================



// ===================== Segunda Seccion ========================

var tipo_registro = $("input[name='tipo_registro']:checked").val();



function mostrarMiembros() {

    if (tipo_registro == "oyente") {

        $("#cantidadMiembro2").hide();

        $("#cantidadMiembro3").hide();

        $("#cantidadMiembro4").hide();

    } else {

        $("#cantidadMiembro2").show('slow');

        $("#cantidadMiembro3").show('slow');

        $("#cantidadMiembro4").show('slow');

    }

}







$("#siguiente_datos").on("click", function () {

    var cheked = document.querySelector('input[name="c_miembros"]:checked');



    var tipo_registro = $("input[name='tipo_registro']:checked").val(); // obtenemos el tipo de registro



    var cantidad_miembros = $("input[name='c_miembros']:checked").val(); // obtenemos la cantidad de miembros



    if (cheked === null) {

        swal.fire({

            icon: "warning",

            text: "Seleccione una cantidad de miembros para el cuerpo academico",

        });



    } else if (tipo_registro == "oyente" && cantidad_miembros > 1) {

        console.log("oyente");

        swal.fire({

            icon: "warning",

            text: "No puede seleccionar más de 1 integrante por su tipo de registro",

        });



    } else {

        total_miembros = document.querySelector(

            'input[name="c_miembros"]:checked'

        ).value;

        $("#datos_miembros").show('slow');

        $("#cantidad_miembros").hide();





        //imprimir el boton de finalizar registro

        if (total_miembros == 4 || tipo_registro == "oyente") {

            document.getElementById("datosAlumnos").innerHTML = "";

            document.getElementById("divCantidadAlumnos").innerHTML = "";

            $("button[name=btnTerminarRegistro2]").show('slow');

            $("#siguiente_cantidad_alumnos").hide();

            total_miembros_global = ""; // damos valos vacio para volver a imprimir los div para la cantidadd e alumnos

            c_alumnos_global = "";



        } else {

            $("button[name=btnTerminarRegistro2]").hide();

            $("#siguiente_cantidad_alumnos").show('slow');

        }











        for (i = 1; i <= 4; i++) {

            //codigo nuevo

            if (i <= total_miembros) {

                $("#miembro" + i).show('slow'); // mostrar div de cada miembro



                // agregamos el atribute required

                $("#nombre" + i)

                    .prop("required", true)

                    .attr("disabled", false);

                $("#appat" + i)

                    .prop("required", true)

                    .attr("disabled", false);

                $("#apmat" + i)

                    .prop("required", true)

                    .attr("disabled", false);

                $("#grado" + i)

                    .prop("required", true)

                    .attr("disabled", false);

                $("#especialidad" + i)

                    .prop("required", true)

                    .attr("disabled", false);

                //   $("#radioSNI" + i)

                //     .prop("required", true)

                //     .attr("disabled", false);

                //

                // esto es para solucionar el error del radio en los datos de los miembros y tambien se debe modificar en la funcion de SNI

                $("input[name='miembros[" + i + "][SNI]'][value='no']").prop("required", true).attr("disabled", false);

                $("input[name='miembros[" + i + "][SNI]'][value='si']").prop("required", true).attr("disabled", false);

                //



                $("#telefono" + i)

                    .prop("required", true)

                    .attr("disabled", false);

                $("#correop" + i)

                    .prop("required", true)

                    .attr("disabled", false);

                $("#correoi" + i)

                    .prop("required", true)

                    .attr("disabled", false);

                $("#nacionalidad" + i)

                    .prop("required", true)

                    .attr("disabled", false);

                $('input[name="miembros[' + i + '][correo_personal]"]').attr(

                    "disabled",

                    false

                );

                $("#hombre" + i)

                    .attr("readonly", false)

                    .attr("disabled", false);

                $("#mujer" + i)

                    .attr("readonly", false)

                    .attr("disabled", false);

                $('input[name="miembros[' + i + '][usuario]"]').attr("disabled", false);

                $('input[name="miembros[' + i + '][lider]"]').attr("disabled", false);

                $('input[name="miembros[' + i + '][anoSNI]"]').attr("disabled", false);

            } else {

                $("#miembro" + i).hide(); // ocultar div de cada miembro



                // eliminamos el atributo required al correo

                $("#correop" + i).prop("required", false);



                // agregamos el atribute required y eliminamos el atributo readonly

                $("#nombre" + i)

                    .prop("required", false)

                    .attr("readonly", false)

                    .attr("disabled", true);

                $("#appat" + i)

                    .prop("required", false)

                    .attr("readonly", false)

                    .attr("disabled", true);

                $("#apmat" + i)

                    .prop("required", false)

                    .attr("readonly", false)

                    .attr("disabled", true);

                $("#grado" + i)

                    .prop("required", false)

                    .removeClass("avoid-clicks")

                    .attr("disabled", true); // eliminamos la clase para habilitar los click y quitar el fondo al select

                $("#especialidad" + i)

                    .prop("required", false)

                    .attr("readonly", false)

                    .attr("disabled", true);

                //   $("#radioSNI" + i)

                //     .prop("required", false)

                //     .attr("disabled", true);





                // esto es para solucionar el error del radio en los datos de los miembros y tambien se debe modificar en la funcion de SNI

                $("input[name='miembros[" + i + "][SNI]'][value='no']").prop("required", true).attr("disabled", false);

                $("input[name='miembros[" + i + "][SNI]'][value='si']").prop("required", true).attr("disabled", false);





                $('input:radio[name="miembros[' + i + '][SNI]"]')

                    .attr("readonly", false)

                    .attr("disabled", true); //Cambiamos a redonly

                $("#anioSNI" + i)

                    .prop("required", false)

                    .attr("readonly", false); // eliminamos el atributo de required a los datos de sni

                $("#nivelSNI" + i)

                    .prop("required", false)

                    .removeClass("avoid-clicks")

                    .attr("disabled", true); // eliminamos la clase para habilitar los click y quitar el fondo al select

                $("#telefono" + i)

                    .prop("required", false)

                    .attr("readonly", false)

                    .attr("disabled", true);

                $("#correoi" + i)

                    .prop("required", false)

                    .attr("readonly", false)

                    .attr("disabled", true);

                $('input:radio[name="miembros[' + i + '][sexo]"]');

                $("#nacionalidad" + i)

                    .prop("required", false)

                    .removeClass("avoid-clicks")

                    .attr("disabled", true); // eliminamos la clase para habilitar los click y quitar el fondo al select

                $("#labelHombre" + i).removeClass("avoid-clicks");

                $("#labelMujer" + i).removeClass("avoid-clicks");

                $("#otraNacionalidad" + i)

                    .attr("readonly", false)

                    .attr("disabled", true);

                //nuevo

                $("#hombre" + i)

                    .attr("readonly", false)

                    .attr("disabled", true);

                $("#mujer" + i)

                    .attr("readonly", false)

                    .attr("disabled", true);

                $('input[name="miembros[' + i + '][correo_personal]"]')

                    .attr("readonly", false)

                    .attr("disabled", true);

                $('input[name="miembros[' + i + '][usuario]"]')

                    .attr("readonly", false)

                    .attr("disabled", true);

                $('input[name="miembros[' + i + '][lider]"]')

                    .attr("readonly", false)

                    .attr("disabled", true);

                $('input[name="miembros[' + i + '][anoSNI]"]')

                    .attr("readonly", false)

                    .attr("disabled", true);

                //termina nuevo

                $("#siSNI" + i).removeClass("avoid-clicks-radio");

                $("#noSNI" + i).removeClass("avoid-clicks-radio");



                // Vaciamos los campos de los div ocultos

                $("#nombre" + i).val("");

                $("#appat" + i).val("");

                $("#apmat" + i).val("");

                $("#grado" + i).val("");

                $("#especialidad" + i).val("");

                // checkeamos el radio  con el valor "no"

                $('input:radio[name="miembros[' + i + '][SNI]"][value="no"]').prop(

                    "checked",

                    true

                );

                $("#datosSNI" + i).hide(); // ocultamos y eliminamos el atributo required

                $("#anioSNI" + i).val("");

                $("#nivelSNI" + i).val("");

                $("#telefono" + i).val("");

                $("#correoi" + i).val("");

                $('input:radio[name="miembros[' + i + '][sexo]"][value="1"]').prop(

                    "checked",

                    true

                );

                $("#correop" + i).val(""); // limipiamos el campo del correo

                $("#nacionalidad" + i).val("");

                $("#usuario" + i).val("");

                $("#otraNacionalidad" + i).val("");



                //mostramos los datos del correo y ocultamos la informacion

                $("#correo_miembro_" + i).show('slow');

                $("#datos_miembro_" + i).hide();



                //ocultamos del div Otra NAcionalidad

                $("#divOtraNAcionalidad" + i).hide();

            }



            //fin codigo nuevo

        }

    }

});



$("#regresar_universidad").on("click", function () {

    $("#datos_universidad").show('slow');

    $("#cantidad_miembros").hide();

});



// ===================== Fin Segunda Seccion ========================



// ===================== tercera Seccion ========================



function nacionalidad(i) {

    valorNacionalidad = $("#nacionalidad" + i).val();

    // alert(valorNacionalidad);

    if (valorNacionalidad == 1) {

        $("#divOtraNAcionalidad" + i).show('slow');

        $("#otraNacionalidad" + i)

            .prop("required", true)

            .prop("disabled", false);

    } else {

        $("#divOtraNAcionalidad" + i).hide();

        $("#otraNacionalidad" + i)

            .prop("required", false)

            .prop("disabled", true);

    }

}



$("#regresar_cantidad").on("click", function () {

    $("#cantidad_miembros").show('slow');

    $("#datos_miembros").hide();

});



function miembroSNI(i) {

    // radioSNI = $("#radioSNI"+i).val();

    radioSNI = $('input:radio[name="miembros[' + i + '][SNI]"]:checked').val();



    if (radioSNI == "si") {

        $("#datosSNI" + i).show('slow');

        $("#anioSNI" + i).prop("required", true);

        $("#nivelSNI" + i).prop("required", true);

        $("#nivelSNI" + i).prop("disabled", false);

    } else {

        $("#datosSNI" + i).hide();

        $("#anioSNI" + i).prop("required", false);

        $("#nivelSNI" + i).prop("required", false);

    }

}



function verificarCorreo(i) {

    correo = $("#correop" + i).val();



    // Correos de los miembros

    correo1 = $("#correop1").val();

    correo2 = $("#correop2").val();

    correo3 = $("#correop3").val();

    correo4 = $("#correop4").val();



    // correos de los alumnos

    a_correo1 = $("#a_correop1").val();

    a_correo2 = $("#a_correop2").val();

    a_correo3 = $("#a_correop3").val();

    a_correo4 = $("#a_correop4").val();

    a_correo5 = $("#a_correop5").val();

    a_correo6 = $("#a_correop6").val();



    if (correo == "") {

        swal.fire({

            icon: "error",

            title: "Favor de  ingresar un correo electronico",

        });

    } else if (correo == a_correo1 || correo == a_correo2 || correo == a_correo3 || correo == a_correo4 || correo == a_correo5 || correo == a_correo6) {

        swal.fire({

            icon: "error",

            title: "Los correos de los miembros y alumnos deben ser diferentes",

        });

    } else {

        if (i == 1) {

            if (correo == correo2 || correo == correo3 || correo == correo4) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                traer_datos(1, correo);

            }

        } else if (i == 2) {

            if (correo == correo1 || correo == correo3 || correo == correo4) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                traer_datos(2, correo);

            }

        } else if (i == 3) {

            if (correo == correo1 || correo == correo2 || correo == correo4) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                traer_datos(3, correo);

            }

        } else if (i == 4) {

            if (correo == correo1 || correo == correo2 || correo == correo3) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                traer_datos(4, correo);

            }

        }

    }

}



function traer_datos(i, correo) {

    re =

        /^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(.[a-zA-Z0-9-]+)*(.[a-z]{2,3})$/;

    if (!re.exec(correo)) {

        // alert("no es correo");

        swal.fire({

            icon: "error",

            title: "Favor de ingresar un correo valido",

        });

    } else {

        $.ajax({

            type: "POST",

            url: base_url + "/check_email_registro",

            data: {

                correo: correo,

            },

            success: function (data) {

                var datos = JSON.parse(data);

                // console.log(datos);

                if (datos == "") {

                    //no existe correo

                    $("#correo_miembro_" + i).show();

                    $("#correop" + i).attr("readonly", "readonly");

                    $("#datos_miembro_" + i).show('slow');

                } else {

                    $("#correo_miembro_" + i).show();

                    $("#correop" + i).attr("readonly", "readonly");

                    $("#datos_miembro_" + i).show('slow');

                    // llenamos los datos con la info de la base de datos

                    $("#nombre" + i)

                        .val(datos["nombre"])

                        .attr("readonly", "readonly");

                    $("#appat" + i)

                        .val(datos["apaterno"])

                        .attr("readonly", "readonly");

                    $("#apmat" + i)

                        .val(datos["amaterno"])

                        .attr("readonly", "readonly");

                    ///$('#grado' + i).val(datos["grado_academico"]).prop('readonly', 'readonly'); // usamos prop para desabilitar los select    No funciona el readonly

                    $("#grado" + i)

                        .val(datos["grado_academico"])

                        .addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

                    $("#especialidad" + i)

                        .val(datos["especialidad"])

                        .attr("readonly", "readonly");

                    $("#telefono" + i)

                        .val(datos["telefono"])

                        .attr("readonly", "readonly");

                        $("#msjTelefonoMaestros" + i)
                        .removeAttr('hidden')
                        .append(`Nota: La imagen alusiva es por defecto. Su número continua tal como esta, 
                        si desea realizar un cambio favor de realizarlo dentro de la plataforma.`)
                        .css('font-size', '13px');

                    $("#correoi" + i)

                        .val(datos["correo_institucional"])

                        .attr("readonly", "readonly");

                    $("#usuario" + i).val(datos["usuario"]);



                    // $('input:radio[name="miembros[`+i+`][SNI]"]').attr("readonly", true);

                    // $("input:radio[name='miembros["+i+"][SNI]'][value='no']").addClass("avoid-clicks");

                    // $("input:radio[name='miembros["+i+"][SNI]'][value='si']").addClass("avoid-clicks");

                    $("#siSNI" + i).addClass("avoid-clicks-radio");

                    $("#noSNI" + i).addClass("avoid-clicks-radio");



                    // Verificar si hay datos SNI

                    if (datos["nivelSNI"] == "" || datos["nivelSNI"] === null || datos["nivelSNI"] == 6) {

                        // sni vacio se habilita la opcion no en el radio

                        $("input[name='miembros[" + i + "][SNI]'][value='no']").prop(

                            "checked",

                            true

                        );

                        $("input[name='miembros[" + i + "][SNI]'][value='si']").prop(

                            "checked",

                            false

                        );

                        $("#datosSNI" + i).hide();



                        // elimino el atributo required

                        $("#anioSNI" + i).prop("required", false);

                        $("#nivelSNI" + i).prop("required", false);

                    } else {

                        // si existen datos se habilita la opcion si en el radio

                        $("input[name='miembros[" + i + "][SNI]'][value='no']").prop(

                            "checked",

                            false

                        );

                        $("input[name='miembros[" + i + "][SNI]'][value='si']").prop(

                            "checked",

                            true

                        );

                        $("#datosSNI" + i).show('slow');



                        // Agregamos el atributo required

                        $("#anioSNI" + i).prop("required", true);

                        $("#nivelSNI" + i).prop("required", true);



                        // Agrega los datos

                        $("#nivelSNI" + i)

                            .val(datos["nivelSNI"])

                            .addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

                        $("#anioSNI" + i)

                            .val(datos["anoSNI"])

                            .attr("readonly", "readonly");

                    }



                    // verificar si hay datos en el sexo

                    if (datos["sexo"] === null) {

                    } else if (datos["sexo"] == 1) {

                        $('input:radio[name="miembros[' + i + '][sexo]"][value="1"]').prop(

                            "checked",

                            true

                        ); //checkeo el sexo desabilito los label para no dar click en el radio

                        $("#labelHombre" + i).addClass("avoid-clicks");

                        $("#labelMujer" + i).addClass("avoid-clicks");

                    } else if (datos["sexo"] == 0) {

                        $('input:radio[name="miembros[' + i + '][sexo]"][value="0"]').prop(

                            "checked",

                            true

                        ); //checkeo el sexo desabilito los label para no dar click en el radio

                        $("#labelHombre" + i).addClass("avoid-clicks");

                        $("#labelMujer" + i).addClass("avoid-clicks");

                    }



                    if (datos["nacionalidad"] === null || datos["nacionalidad"] == "") {

                        // console.log("el dato es null");

                    } else {

                        if (isNum(datos["nacionalidad"])) {

                            console.log(datos["nacionalidad"]);

                            // console.log("es numerico");

                            $("#nacionalidad" + i)

                                .val(datos["nacionalidad"])

                                .addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

                            $("#divOtraNAcionalidad" + i).hide();

                        } else {

                            // console.log("es text");

                            console.log(datos["nacionalidad"]);

                            $("#nacionalidad" + i)

                                .val("1")

                                .addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

                            $("#otraNacionalidad" + i)

                                .val(datos["nacionalidad"])

                                .attr("readonly", true);

                            $("#divOtraNAcionalidad" + i).show('slow');

                        }

                    }

                }

            },

        });

    }

}



// con esta funcion determinamos si la variable de nacionalidd es texto o numerico

function isNum(val) {

    return !isNaN(val);

}













//button para continuar con la cantidad de alumnos

$("#siguiente_cantidad_alumnos").on("click", function () {

    $("#cantidad_alumnos").show('slow');

    $("#datos_miembros").hide();

    cantidad_alumnos();

});



//button para regresar a los datos de los miembros

$("#regresar_datos_miembros").on("click", function () {

    $("#cantidad_alumnos").hide();

    $("#datos_miembros").show('slow');

});



// ===================== Fin tercera Seccion ========================





// ===================== Cuarta Seccion ============================





var total_miembros_global = ""; //variable global





function cantidad_alumnos() {

    var total_miembros = document.querySelector(

        'input[name="c_miembros"]:checked'

    ).value;



    if (total_miembros_global == "" || total_miembros_global != total_miembros) {

        imprimir_C_alumnos(total_miembros);

    }



}



function imprimir_C_alumnos(total_miembros) {



    c_alumnos = (4 - total_miembros) * 2;



    var div_c_alumnos = document.getElementById('divCantidadAlumnos');



    div_c_alumnos.innerHTML = '';



    for (var i = 1; i <= c_alumnos; i++) {



        if (i == 1) {

            var iconos = '<i class="fa fa-user" aria-hidden="true">&nbsp;</i>';

        } else if (i == 2) {

            var iconos = '<i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i>';

        } else if (i == 3) {

            var iconos = '<i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i>';

        } else if (i == 4) {

            var iconos = '<i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i>';

        } else if (i == 5) {

            var iconos = '<i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i>';

        } else if (i == 6) {

            var iconos = '<i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i><i class="fa fa-user" aria-hidden="true">&nbsp;</i>';

        }



        div_c_alumnos.innerHTML += '<p class="form__answer"><input type="radio" name="c_alumnos" id="alumnos_match_' + i + '" value="' + i + '"><label for="alumnos_match_' + i + '" style="color: black">' + iconos + '<br>' + i + ' alumnos</label></p>';

        $("input[name='c_alumnos']").on("change", function (e) {

            id = e.target.id;

            if (anterior_id != "") {

                $("label[for=" + anterior_id + "]").css("border", "2px solid");

                $("label[for=" + anterior_id + "]").css(

                    "border-color",

                    "rgba(0, 0, 0, 0.3)"

                );

            }

            $("label[for=" + id + "]").css("border", "2px solid");

            $("label[for=" + id + "]").css("border-color", "#40277e");

            anterior_id = id;

        });

    }



    total_miembros_global = total_miembros;



}







//button para continuar con los datos de los alumnos

$("#siguiente_datos_alumnos").on("click", function () {



    var c_alumnos = $('input[name="c_alumnos"]:checked').val();



    if (c_alumnos === undefined) {

        swal.fire({

            icon: "warning",

            text: "Seleccione una cantidad de alumnos para el cuerpo academico",

        });

    } else {

        datos_alumnos(c_alumnos);

        // variable_cantidad_alumnos = c_alumnos; // le damos la cantidad de alumnos a la variable global

        $("#cantidad_alumnos").hide();

        $("#datos_alumnos").show('slow');





    }



});





// ===================== Fin cuarta Seccion ========================



// ===================== Quinta Seccion ============================





var c_alumnos_global = "";



function datos_alumnos(c_alumnos) {



    var div_datosAlumnos = document.getElementById('datosAlumnos');





    if (c_alumnos_global == "") {



        for (var i = 1; i <= c_alumnos; i++) {



            div_datosAlumnos.insertAdjacentHTML('beforeend', `
          <div class="row" id="alumno`+ i + `">
          <div class="col-md-3"> 
          <div class="text-center">
          <img src="../resources/img/registros_redes/avatar_hombre.png" 
          style="width:110px; height: 130px" id="a_imagenAvatar`+ i + `" 
          alt="">
          </div>
          <br> 
          <div class="text-center"> 
          <!--============= apartado de radio css ================--> 
          <div class="yc-form">
          <input type="radio" id="a_hombre`+ i + `" name="alumnos[` + i + `][sexo]" 
          onchange="cambiaravataralumnos(`+ i + `)" value="1" checked="" required="">
          <label for="a_hombre`+ i + `" id="a_labelHombre` + i + `" class="sexo">Hombre</label>
          <input type="radio" id="a_mujer`+ i + `" name="alumnos[` + i + `][sexo]" 
          onchange="cambiaravataralumnos(`+ i + `)" value="0" required="">
          <label for="a_mujer`+ i + `" id="a_labelMujer` + i + `" class="sexo">Mujer</label>
          </div> 
          <!--============= apartado de radio css ================--> 
          </div> 
          </div> 
          <div class="col-md-9"> 
          <h1>Datos del alumno `+ i + `</h1> 
          <div id="a_correo_alumno_`+ i + `"> 
          <div class="mb-3">
          <label for="a_correop`+ i + `">Correo personal*</label>
          <input type="email" class="form-control" id="a_correop`+ i + `" 
          name="alumnos[`+ i + `][correo_personal]" placeholder="Correo personal" required=""> 
          <div class="invalid-feedback">Ingresa un correo electrónico válido.</div>
          <br>
          <button type="button" class="btn btn-miembros btn-block" id="validarCorreo`+ i + `" 
          onclick="verificarCorreoAlumno(`+ i + `);">Validar correo</button>
          <input type="text" hidden="" id="a_usuario`+ i + `" name="alumnos[` + i + `][usuario]"> 
          <input type="text" hidden="" name="alumnos[`+ i + `][lider]" value="0">
          </div> 
          </div> 
          <div id="datos_alumno_`+ i + `" style="display: none;"> 
          <div class="mb-3"> 
          <label for="a_nombre`+ i + `">Nombre</label> 
          <input type="text" class="form-control" id="a_nombre`+ i + `" name="alumnos[` + i + `][nombre]" 
          placeholder="Nombre" required=""> 
          <div class="invalid-feedback">Ingresa el nombre. </div> 
          </div> 
          <div class="mb-3"> 
          <label for="a_appat`+ i + `">Apellito paterno</label> 
          <input type="text" class="form-control" id="a_appat`+ i + `" name="alumnos[` + i + `][ap_paterno]" 
          placeholder="Apellido paterno" required=""> 
          <div class="invalid-feedback">Ingresa el apellido paterno. </div> 
          </div> 
          <div class="mb-3"> 
          <label for="a_apmat`+ i + `">Apellito materno</label> 
          <input type="text" class="form-control" id="a_apmat`+ i + `" name="alumnos[` + i + `][ap_materno]" 
          placeholder="Apellido materno" required=""> 
          <div class="invalid-feedback">Ingresa el apellido materno. </div> 
          </div> 
          <div class="mb-3"> 
          <label for="a_nacionalidad`+ i + `">Nacionalidad</label> 
          <select class="form-control" name="alumnos[`+ i + `][nacionalidad]" id="a_nacionalidad` + i + `" 
          onchange="nacionalidadAlumno(`+ i + `)"required=""> 
          <option value="" selected="true" disabled="">Selecciona nacionalidad</option> 
          <option value="2">Mexicana</option> 
          <option value="3">Colombiana</option> 
          <option value="4">Peruana</option> 
          <option value="5">Ecuatoriana</option> 
          <option value="6">Argentina</option> 
          <option value="1">Otro</option> 
          </select> 
          <div class="invalid-feedback">Ingrese su nacionalidad </div> 
          </div> 
          <!-- div otra nacionalidad--> 
          <div class="mb-3" id="a_divOtraNAcionalidad`+ i + `" style="display:none"> 
          <label for="a_nacionalidad`+ i + `">Nombre de la nacionalidad</label> 
          <input type="text" class="form-control" id="a_otraNacionalidad'+1+'" 
          name="alumnos[`+ i + `][nacionalidad]"placeholder="Nacionalidad"> 
          <div class="invalid-feedback">Ingresa el nombre de la nacionalidad del miembro. </div> 
          </div> 
          <div class="mb-3"> 
          <label for="a_grado`+ i + `">Grado académico</label> 
          <select class="form-control" name="alumnos[`+ i + `][grado_academico]" 
          id="a_grado`+ i + `" required=""> 
          <option value="" selected="true" disabled="">Selecciona grado académico</option> 
          <option value="1">Licenciatura</option> 
          <option value="2">Ingeniería</option> 
          <option value="3">Maestría</option> 
          <option value="4">Doctorado</option> 
          <option value="5">Sin registrar</option> 
          </select> 
          <div class="invalid-feedback">Ingrese el grado académico </div> 
          </div> 
          <div class="mb-3"> 
          <label for="a_especialidad`+ i + `">Especialidad</label> 
          <input type="text" class="form-control" id="a_especialidad`+ i + `" 
          name="alumnos[`+ i + `][especialidad]" placeholder="Especialidad" required=""> 
          <div class="invalid-feedback">Ingresa el nombre de la especialidad. </div> 
          </div> 
          <!-- ========= SNI ================ --> 
          <div class="mb-3"> 
          <label for="">SNI*</label><br> 
          <label id="a_siSNI`+ i + `" class="custom-control custom-radio custom-control-inline"> 
          <input type="radio" name="alumnos[`+ i + `][SNI]" value="no" id="a_radioSNI` + i + `" 
          checked=""class="custom-control-input prodep" onclick="a_SNI(`+ i + `)" required="">
          <span class="custom-control-label">No</span> </label> 
          <label id="a_noSNI`+ i + `" class="custom-control custom-radio custom-control-inline"> 
          <input type="radio" name="alumnos[`+ i + `][SNI]" value="si" id="a_radioSNI` + i + `" 
          class="custom-control-input prodep" onclick="a_SNI(`+ i + `)" required="">
          <span class="custom-control-label">Si</span> </label> 
          </div> 
          <div id="a_datosSNI`+ i + `" style="display:none"> 
          <div class="mb-3"> <label for="a_nivelSNI`+ i + `">Nivel SNI*</label> 
          <select class="form-control" name="alumnos[`+ i + `][nivelSNI]" id="a_nivelSNI` + i + `"> 
          <option value="" selected="true" disabled="">Selecciona nivel SNI</option> 
          <option value="1">Candidato a Investigador Nacional</option> 
          <option value="2">Investigador Nacional Nivel I</option> 
          <option value="3">Investigador Nacional Nivel II</option> 
          <option value="4">Investigador Nacional Nivel III</option> 
          <option value="5">Investigador Nacional Emérito</option> 
          <!--<option value="5">Sin registrar</option>--> </select> 
          <div class="invalid-feedback">Ingrese el nivel SNI </div> 
          </div> 
          <div class="mb-3"> 
          <label for="a_anioSNI`+ i + `">Año en que obtuvo el nivel*</label> 
          <input type="number" class="form-control" id="a_anioSNI`+ i + `" name="alumnos[` + i + `][anoSNI]" 
          placeholder="Año SNI"> 
          <div class="invalid-feedback">Año en que obtuvo el nivel </div> 
          </div> 
          </div> 
          <!-- ========== SNI ============= --> 
          <div class="mb-3"> 
          <label for="a_telefono`+ i + `">Teléfono*</label> 
          <div id='msjTelefono`+ i + `' hidden></div>
          <input type="tel" class="form-control" id="a_telefono`+ i + `" name="alumnos[` + i + `][telefono]" 
          placeholder="Telefono" required=""> 
          <div class="invalid-feedback">Ingresa su número de teléfono. </div> 
          </div> 
          <div class="mb-3"> 
          <label for="a_correoi`+ i + `">Correo institucional*</label> 
          <input type="email" class="form-control" id="a_correoi`+ i + `" 
          name="alumnos[`+ i + `][correo_institucional]"placeholder="Correo institucional" required=""> 
          <div class="invalid-feedback">Ingresa su correo institucional. </div> 
          </div> 
          </div> 
          </div> 
          </div>`);

            var telefono = document.querySelector("input[name='alumnos[" + i + "][telefono]']");
            window.intlTelInput(telefono, {
                preventInvalidNumbers: true,
                autoPlaceholder: 'polite',
                initialCountry: "MX",
                formatOnDisplay: true,
                separateDialCode: false,
                utilsScript: '../resources/intl-tel-input/build/js/utils.js',
                autoHideDialCode: false,
                nationalMode: false,
            });

        }

        c_alumnos_global = c_alumnos; // damos el valor de la cantidad de alumnos a la variable global de la cantidad de alumnos





    } else if (c_alumnos_global < c_alumnos) {





        for (var i = parseInt(c_alumnos_global) + 1; i <= c_alumnos; i++) {



            // div_datosAlumnos.insertAdjacentHTML('beforeend','<div class="row" id="alumno`+i+`"><div class="col-md-3"><div class="text-center"><img src="https://redesla.net/redesla/resources/img/registros_redes/avatar_hombre.png" style="width:110px; height: 130px" id="a_imagenAvatar`+i+`" alt=""></div><br><div class="text-center"><!--============= apartado de radio css ================--><div class="yc-form"><input type="radio" id="a_hombre`+i+`" name="alumnos[`+i+`][sexo]" onchange="cambiaravataralumnos(`+i+`)" value="1" checked="" required=""><label for="a_hombre`+i+`" id="a_labelHombre`+i+`" class="sexo">Hombre</label><input type="radio" id="a_mujer`+i+`" name="alumnos[`+i+`][sexo]" onchange="cambiaravataralumnos(`+i+`)" value="0" required=""><label for="a_mujer`+i+`" id="a_labelMujer`+i+`" class="sexo">Mujer</label></div><!--============= apartado de radio css ================--></div></div><div class="col-md-9"><h1>Datos del alumno `+i+`</h1><div id="a_correo_alumno_`+i+`"><div class="mb-3"><label for="a_correop`+i+`">Correo personal*</label><input type="email" class="form-control" id="a_correop`+i+`" name="alumnos[`+i+`][correo_personal]" placeholder="Correo personal" required=""><div class="invalid-feedback">Ingresa un correo electrónico válido.</div><br><button type="button" class="btn btn-info btn-block" id="validarCorreo`+i+`" onclick="verificarCorreoAlumno(`+i+`);">Validar correo</button><input type="text" hidden="" id="usuario`+i+`" name="alumnos[`+i+`][usuario]"></div></div><div id="datos_alumno_`+i+`"></div></div></div>');

            div_datosAlumnos.insertAdjacentHTML('beforeend', `
              <div class="row" id="alumno`+ i + `">
              <div class="col-md-3"> 
              <div class="text-center">
              <img src="../resources/img/registros_redes/avatar_hombre.png" 
              style="width:110px; height: 130px" id="a_imagenAvatar`+ i + `" 
              alt="">
              </div>
              <br> 
              <div class="text-center"> 
              <!--============= apartado de radio css ================--> 
              <div class="yc-form">
              <input type="radio" id="a_hombre`+ i + `" name="alumnos[` + i + `][sexo]" 
              onchange="cambiaravataralumnos(`+ i + `)" value="1" checked="" required="">
              <label for="a_hombre`+ i + `" id="a_labelHombre` + i + `" class="sexo">Hombre</label>
              <input type="radio" id="a_mujer`+ i + `" name="alumnos[` + i + `][sexo]" 
              onchange="cambiaravataralumnos(`+ i + `)" value="0" required="">
              <label for="a_mujer`+ i + `" id="a_labelMujer` + i + `" class="sexo">Mujer</label>
              </div> 
              <!--============= apartado de radio css ================--> 
              </div> 
              </div> 
              <div class="col-md-9"> 
              <h1>Datos del alumno `+ i + `</h1> 
              <div id="a_correo_alumno_`+ i + `"> 
              <div class="mb-3">
              <label for="a_correop`+ i + `">Correo personal*</label>
              <input type="email" class="form-control" id="a_correop`+ i + `" 
              name="alumnos[`+ i + `][correo_personal]" placeholder="Correo personal" required=""> 
              <div class="invalid-feedback">Ingresa un correo electrónico válido.</div>
              <br>
              <button type="button" class="btn btn-miembros btn-block" id="validarCorreo`+ i + `" 
              onclick="verificarCorreoAlumno(`+ i + `);">Validar correo</button>
              <input type="text" hidden="" id="a_usuario`+ i + `" name="alumnos[` + i + `][usuario]"> 
              <input type="text" hidden="" name="alumnos[`+ i + `][lider]" value="0">
              </div> 
              </div> 
              <div id="datos_alumno_`+ i + `" style="display: none;"> 
              <div class="mb-3"> 
              <label for="a_nombre`+ i + `">Nombre</label> 
              <input type="text" class="form-control" id="a_nombre`+ i + `" name="alumnos[` + i + `][nombre]" 
              placeholder="Nombre" required=""> 
              <div class="invalid-feedback">Ingresa el nombre. </div> 
              </div> 
              <div class="mb-3"> 
              <label for="a_appat`+ i + `">Apellito paterno</label> 
              <input type="text" class="form-control" id="a_appat`+ i + `" name="alumnos[` + i + `][ap_paterno]" 
              placeholder="Apellido paterno" required=""> 
              <div class="invalid-feedback">Ingresa el apellido paterno. </div> 
              </div> 
              <div class="mb-3"> 
              <label for="a_apmat`+ i + `">Apellito materno</label> 
              <input type="text" class="form-control" id="a_apmat`+ i + `" name="alumnos[` + i + `][ap_materno]" 
              placeholder="Apellido materno" required=""> 
              <div class="invalid-feedback">Ingresa el apellido materno. </div> 
              </div> 
              <div class="mb-3"> 
              <label for="a_nacionalidad`+ i + `">Nacionalidad</label> 
              <select class="form-control" name="alumnos[`+ i + `][nacionalidad]" id="a_nacionalidad` + i + `" 
              onchange="nacionalidadAlumno(`+ i + `)"required=""> 
              <option value="" selected="true" disabled="">Selecciona nacionalidad</option> 
              <option value="2">Mexicana</option> 
              <option value="3">Colombiana</option> 
              <option value="4">Peruana</option> 
              <option value="5">Ecuatoriana</option> 
              <option value="6">Argentina</option> 
              <option value="1">Otro</option> 
              </select> 
              <div class="invalid-feedback">Ingrese su nacionalidad </div> 
              </div> 
              <!-- div otra nacionalidad--> 
              <div class="mb-3" id="a_divOtraNAcionalidad`+ i + `" style="display:none"> 
              <label for="a_nacionalidad`+ i + `">Nombre de la nacionalidad</label> 
              <input type="text" class="form-control" id="a_otraNacionalidad'+1+'" 
              name="alumnos[`+ i + `][nacionalidad]"placeholder="Nacionalidad"> 
              <div class="invalid-feedback">Ingresa el nombre de la nacionalidad del miembro. </div> 
              </div> 
              <div class="mb-3"> 
              <label for="a_grado`+ i + `">Grado académico</label> 
              <select class="form-control" name="alumnos[`+ i + `][grado_academico]" 
              id="a_grado`+ i + `" required=""> 
              <option value="" selected="true" disabled="">Selecciona grado académico</option> 
              <option value="1">Licenciatura</option> 
              <option value="2">Ingeniería</option> 
              <option value="3">Maestría</option> 
              <option value="4">Doctorado</option> 
              <option value="5">Sin registrar</option> 
              </select> 
              <div class="invalid-feedback">Ingrese el grado académico </div> 
              </div> 
              <div class="mb-3"> 
              <label for="a_especialidad`+ i + `">Especialidad</label> 
              <input type="text" class="form-control" id="a_especialidad`+ i + `" 
              name="alumnos[`+ i + `][especialidad]" placeholder="Especialidad" required=""> 
              <div class="invalid-feedback">Ingresa el nombre de la especialidad. </div> 
              </div> 
              <!-- ========= SNI ================ --> 
              <div class="mb-3"> 
              <label for="">SNI*</label><br> 
              <label id="a_siSNI`+ i + `" class="custom-control custom-radio custom-control-inline"> 
              <input type="radio" name="alumnos[`+ i + `][SNI]" value="no" id="a_radioSNI` + i + `" 
              checked=""class="custom-control-input prodep" onclick="a_SNI(`+ i + `)" required="">
              <span class="custom-control-label">No</span> </label> 
              <label id="a_noSNI`+ i + `" class="custom-control custom-radio custom-control-inline"> 
              <input type="radio" name="alumnos[`+ i + `][SNI]" value="si" id="a_radioSNI` + i + `" 
              class="custom-control-input prodep" onclick="a_SNI(`+ i + `)" required="">
              <span class="custom-control-label">Si</span> </label> 
              </div> 
              <div id="a_datosSNI`+ i + `" style="display:none"> 
              <div class="mb-3"> <label for="a_nivelSNI`+ i + `">Nivel SNI*</label> 
              <select class="form-control" name="alumnos[`+ i + `][nivelSNI]" id="a_nivelSNI` + i + `"> 
              <option value="" selected="true" disabled="">Selecciona nivel SNI</option> 
              <option value="1">Candidato a Investigador Nacional</option> 
              <option value="2">Investigador Nacional Nivel I</option> 
              <option value="3">Investigador Nacional Nivel II</option> 
              <option value="4">Investigador Nacional Nivel III</option> 
              <option value="5">Investigador Nacional Emérito</option> 
              <!--<option value="5">Sin registrar</option>--> </select> 
              <div class="invalid-feedback">Ingrese el nivel SNI </div> 
              </div> 
              <div class="mb-3"> 
              <label for="a_anioSNI`+ i + `">Año en que obtuvo el nivel*</label> 
              <input type="number" class="form-control" id="a_anioSNI`+ i + `" name="alumnos[` + i + `][anoSNI]" 
              placeholder="Año SNI"> 
              <div class="invalid-feedback">Año en que obtuvo el nivel </div> 
              </div> 
              </div> 
              <!-- ========== SNI ============= --> 
              <div class="mb-3"> 
              <label for="a_telefono`+ i + `">Teléfono*</label> 
              <div id='msjTelefono`+ i + `' hidden></div>
              <input type="tel" class="form-control" id="a_telefono`+ i + `" name="alumnos[` + i + `][telefono]" 
              placeholder="Telefono" required=""> 
              <div class="invalid-feedback">Ingresa su número de teléfono. </div> 
              </div> 
              <div class="mb-3"> 
              <label for="a_correoi`+ i + `">Correo institucional*</label> 
              <input type="email" class="form-control" id="a_correoi`+ i + `" 
              name="alumnos[`+ i + `][correo_institucional]"placeholder="Correo institucional" required=""> 
              <div class="invalid-feedback">Ingresa su correo institucional. </div> 
              </div> 
              </div> 
              </div> 
              </div>`);

            var telefono = document.querySelector("input[name='alumnos[" + i + "][telefono]']");
            window.intlTelInput(telefono, {
                preventInvalidNumbers: true,
                autoPlaceholder: 'polite',
                initialCountry: "MX",
                formatOnDisplay: true,
                separateDialCode: false,
                utilsScript: '../resources/intl-tel-input/build/js/utils.js',
                autoHideDialCode: false,
                nationalMode: false,
            });




        }



        c_alumnos_global = c_alumnos; // damos el valor de la cantidad de alumnos a la variable global de la cantidad de alumnos



    } else if (c_alumnos_global > c_alumnos) {



        for (var g = c_alumnos_global; g > c_alumnos; g--) {

            $("#alumno" + g).remove();

        }

        c_alumnos_global = c_alumnos; // damos el valor de la cantidad de alumnos a la variable global de la cantidad de alumnos

    }

}



$("#regresar_cantidad_alumnos").on("click", function () {

    $("#cantidad_alumnos").show('slow');

    $("#datos_alumnos").hide();

});



function cambiaravataralumnos(id) {

    //vamos a traernos el valor del radio de sexo

    var sexo = $("input[name='alumnos[" + id + "][sexo]']:checked").val();

    // 1 es hombre 0 es mujer

    if (sexo == 1) {

        $("#a_imagenAvatar" + id).attr(

            "src",

            base_url + "/resources/img/registros_redes/avatar_hombre.png"

        );

    } else if (sexo == 0) {

        $("#a_imagenAvatar" + id).attr(

            "src",

            base_url + "/resources/img/registros_redes/avatar_mujer.png"

        );

    }

}





function verificarCorreoAlumno(i) {

    correo = $("#a_correop" + i).val();



    correo = $("#a_correop" + i).val();



    // traemos los correos de los miembros para comprar que no se repitan

    correo1_miembro = $("#correop1").val();

    correo2_miembro = $("#correop2").val();

    correo3_miembro = $("#correop3").val();

    correo4_miembro = $("#correop4").val();



    if (correo == "") {

        swal.fire({

            icon: "error",

            title: "Favor de  ingresar un correo electronico",

        });



    } else if (correo == correo1_miembro || correo == correo2_miembro || correo == correo3_miembro || correo == correo4_miembro) { // verificar si el correo es igual a uno de los miembros

        swal.fire({

            icon: "error",

            title: "Los correos de los miembros y alumnos deben ser diferentes",

        });



    } else {



        var c_alumnos = $('input[name="c_alumnos"]:checked').val();

        otro_correo1 = $("#a_correop1").val();

        otro_correo2 = $("#a_correop2").val();

        otro_correo3 = $("#a_correop3").val();

        otro_correo4 = $("#a_correop4").val();

        otro_correo5 = $("#a_correop5").val();

        otro_correo6 = $("#a_correop6").val();





        if (i == 6) {

            if (correo == otro_correo1 || correo == otro_correo2 || correo == otro_correo3 || correo == otro_correo4 || correo == otro_correo5) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                verificar_correo_alumnos(i)

            }

        } else if (i == 5) {

            if (correo == otro_correo1 || correo == otro_correo2 || correo == otro_correo3 || correo == otro_correo4 || correo == otro_correo6) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                verificar_correo_alumnos(i)

            }

        } else if (i == 4) {

            if (correo == otro_correo1 || correo == otro_correo2 || correo == otro_correo3 || correo == otro_correo5 || correo == otro_correo6) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                verificar_correo_alumnos(i)

            }

        } else if (i == 3) {

            if (correo == otro_correo1 || correo == otro_correo2 || correo == otro_correo4 || correo == otro_correo5 || correo == otro_correo6) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                verificar_correo_alumnos(i)

            }

        } else if (i == 2) {

            if (correo == otro_correo1 || correo == otro_correo3 || correo == otro_correo4 || correo == otro_correo5 || correo == otro_correo6) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                verificar_correo_alumnos(i)

            }

        } else if (i == 1) {

            if (correo == otro_correo2 || correo == otro_correo3 || correo == otro_correo4 || correo == otro_correo5 || correo == otro_correo6) {

                swal.fire({

                    icon: "error",

                    title: "Favor de no ingresar el mismo correo 2 veces",

                });

            } else {

                verificar_correo_alumnos(i)

            }

        }



    }

}







function verificar_correo_alumnos(i) {

    correo = $("#a_correop" + i).val();



    re = /^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(.[a-zA-Z0-9-]+)*(.[a-z]{2,3})$/;



    if (!re.exec(correo)) {      // no es un correo valido 

        swal.fire({

            icon: "error",

            title: "Favor de ingresar un correo valido",

        });

    } else {

        $.ajax({

            type: "POST",

            url: base_url + "/check_email_registro",

            data: {

                correo: correo,

            },

            success: function (data) {

                var datos = JSON.parse(data);





                if (datos == "") {

                    //   no existe correo

                    $("#a_correo_alumno_" + i).show();

                    $("#a_correop" + i).attr("readonly", "readonly");

                    $("#datos_alumno_" + i).show('slow');

                } else {

                    $("#a_correo_alumno_" + i).show();

                    $("#a_correop" + i).attr("readonly", "readonly");

                    $("#datos_alumno_" + i).show('slow');

                    $("#a_nombre" + i).val(datos["nombre"]).attr("readonly", "readonly");

                    $("#a_appat" + i).val(datos["apaterno"]).attr("readonly", "readonly");

                    $("#a_apmat" + i).val(datos["amaterno"]).attr("readonly", "readonly");



                    // Nacionalidad

                    if (datos["nacionalidad"] === null || datos["nacionalidad"] == "") {

                        //muestra el select de nacionalidad habilitado

                    } else {

                        if (isNum(datos["nacionalidad"])) {

                            console.log(datos["nacionalidad"]);

                            $("#a_nacionalidad" + i).val(datos["nacionalidad"]).addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

                            $("#a_divOtraNAcionalidad" + i).hide();

                        } else {

                            // el resultado es texto

                            console.log(datos["nacionalidad"]);

                            $("#a_nacionalidad" + i).val("1").addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

                            $("#a_otraNacionalidad" + i).val(datos["nacionalidad"]).attr("readonly", true);

                            $("#a_divOtraNAcionalidad" + i).show('slow');

                        }

                    }

                    $("#a_grado" + i).val(datos["grado_academico"]).addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

                    $("#a_especialidad" + i).val(datos["especialidad"]).attr("readonly", "readonly");





                    // Verificar si hay datos SNI



                    $("#a_siSNI" + i).addClass("avoid-clicks-radio");

                    $("#a_noSNI" + i).addClass("avoid-clicks-radio");



                    if (datos["nivelSNI"] == "" || datos["nivelSNI"] === null || datos["nivelSNI"] == 6) {

                        // sni vacio se habilita la opcion no en el radio

                        $("input[name='alumnos[" + i + "][SNI]'][value='no']").prop("checked", true);

                        $("input[name='alumnos[" + i + "][SNI]'][value='si']").prop("checked", false);

                        $("#a_datosSNI" + i).hide();



                        // elimino el atributo required

                        $("#a_anioSNI" + i).prop("required", false);

                        $("#a_nivelSNI" + i).prop("required", false);

                    } else {

                        // si existen datos se habilita la opcion si en el radio

                        $("input[name='alumnos[" + i + "][SNI]'][value='no']").prop("checked", false);

                        $("input[name='alumnos[" + i + "][SNI]'][value='si']").prop("checked", true);

                        $("#a_datosSNI" + i).show('slow');



                        // Agregamos el atributo required

                        $("#a_anioSNI" + i).prop("required", true);

                        $("#a_nivelSNI" + i).prop("required", true);



                        // Agrega los datos

                        $("#a_nivelSNI" + i).val(datos["nivelSNI"]).addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

                        $("#a_anioSNI" + i).val(datos["anoSNI"]).attr("readonly", "readonly");

                    }



                    $("#a_telefono" + i).val(datos["telefono"]).attr("readonly", "readonly");

                    $("#msjTelefono" + i)
                        .removeAttr('hidden')
                        .append(`Nota: La imagen alusiva es por defecto. Su número continua tal como esta, 
                        si desea realizar un cambio favor de realizarlo dentro de la plataforma.`)
                        .css('font-size', '13px');

                    $("#a_correoi" + i).val(datos["correo_institucional"]).attr("readonly", "readonly");

                    $("#a_usuario" + i).val(datos["usuario"]);





                    // verificar si hay datos en el sexo

                    if (datos["sexo"] === null) {

                    } else if (datos["sexo"] == 1) {

                        $('input:radio[name="alumnos[' + i + '][sexo]"][value="1"]').prop("checked", true); //checkeo el sexo desabilito los label para no dar click en el radio

                        $("#a_labelHombre" + i).addClass("avoid-clicks");

                        $("#a_labelMujer" + i).addClass("avoid-clicks");

                    } else if (datos["sexo"] == 0) {

                        $('input:radio[name="alumnos[' + i + '][sexo]"][value="0"]').prop("checked", true); //checkeo el sexo desabilito los label para no dar click en el radio

                        $("#a_labelHombre" + i).addClass("avoid-clicks");

                        $("#a_labelMujer" + i).addClass("avoid-clicks");

                    }





                }

            },

        });

    }

}





function nacionalidadAlumno(i) {

    valorNacionalidad = $("#a_nacionalidad" + i).val();

    // alert(valorNacionalidad);

    if (valorNacionalidad == 1) {

        $("#a_divOtraNAcionalidad" + i).show('slow');

        $("#a_otraNacionalidad" + i).prop("required", true).prop("disabled", false);

    } else {

        $("#a_divOtraNAcionalidad" + i).hide();

        $("#a_otraNacionalidad" + i).prop("required", false).prop("disabled", true);

    }

}



function a_SNI(i) {

    // radioSNI = $("#radioSNI"+i).val();

    radioSNI = $('input:radio[name="alumnos[' + i + '][SNI]"]:checked').val();



    if (radioSNI == "si") {

        $("#a_datosSNI" + i).show('slow');

        $("#a_anioSNI" + i).prop("required", true);

        $("#a_nivelSNI" + i).prop("required", true);

    } else {

        $("#a_datosSNI" + i).hide();

        $("#a_anioSNI" + i).prop("required", false);

        $("#a_nivelSNI" + i).prop("required", false);

    }

}

// ===================== Fin quinta Seccion =========================



// ===================== Seccion para estilos ========================



var anterior_id = "";

$("input[name='c_miembros']").on("change", function (e) {

    id = e.target.id;

    if (anterior_id != "") {

        $("label[for=" + anterior_id + "]").css("border", "2px solid");

        $("label[for=" + anterior_id + "]").css(

            "border-color",

            "rgba(0, 0, 0, 0.3)"

        );

    }

    $("label[for=" + id + "]").css("border", "2px solid");

    $("label[for=" + id + "]").css("border-color", "rgb(64, 39, 126)");

    anterior_id = id;

});





// var anterior_id2 = "";

// $("input[name='c_alumnos']").on("change", function (e) {

//   id = e.target.id2;

//   alert("hola");

//   if (anterior_id2 != "") {

//     $("label[for=" + anterior_id2 + "]").css("border", "2px solid");

//     $("label[for=" + anterior_id2 + "]").css(

//       "border-color",

//       "rgba(0, 0, 0, 0.3)"

//     );

//   }

//   $("label[for=" + id + "]").css("border", "2px solid");

//   $("label[for=" + id + "]").css("border-color", "rgb(64, 39, 126)");

//   anterior_id2 = id;

// });











// ===================== Fin seccion para estilos =========================

$(

    "#nombreRector, #nombreProdep",

    "#nombre1",

    "#nombre2",

    "#nombre3",

    "#nombre4"

).on("keypress", function (event) {

      /*Nombres con acentos*/ key = event.keyCode || event.which;

    tecla = String.fromCharCode(key).toLowerCase();

    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.";

    especiales = "8-37-39-46";

    tecla_especial = false;

    for (var i in especiales) {

        if (key == especiales[i]) {

            tecla_especial = true;

            break;

        }

    }



    if (letras.indexOf(tecla) == -1 && !tecla_especial) {

        event.preventDefault();

    }

});



$(

    "#nombreUniversidad, #direccionUniversidad, #direccionEnvio").on("keypress", function (event) {

    /*Nombres con acentos*/ key = event.keyCode || event.which;

        tecla = String.fromCharCode(key).toLowerCase();

        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz1234567890.,";

        especiales = "8-37-39-46";

        tecla_especial = false;

        for (var i in especiales) {

            if (key == especiales[i]) {

                tecla_especial = true;

                break;

            }

        }



        if (letras.indexOf(tecla) == -1 && !tecla_especial) {

            event.preventDefault();

        }

    });



$(

    "#appat1, #appat2, #appat3, #appat4, #apmat1, #apmat2, #apmat3, #apmat4, #otraNacionalidad1, #otraNacionalidad2, #otraNacionalidad3, #otraNacionalidad4"

).on("keypress", function (event) {

    /*Nombres con acentos*/ console.log("entra");

    key = event.keyCode || event.which;

    tecla = String.fromCharCode(key).toLowerCase();

    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.";

    especiales = "8-37-39-46";

    tecla_especial = false;

    for (var i in especiales) {

        if (key == especiales[i]) {

            tecla_especial = true;

            break;

        }

    }



    if (letras.indexOf(tecla) == -1 && !tecla_especial) {

        event.preventDefault();

    }

});



$("#especialidad1, #especialidad2, #especialidad3, #especialidad4").on(

    "keypress",

    function (event) {

        /*Nombres con acentos*/

        console.log("entra");

        key = event.keyCode || event.which;

        tecla = String.fromCharCode(key).toLowerCase();

        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.";

        especiales = "8-37-39-46";

        tecla_especial = false;

        for (var i in especiales) {

            if (key == especiales[i]) {

                tecla_especial = true;

                break;

            }

        }



        if (letras.indexOf(tecla) == -1 && !tecla_especial) {

            event.preventDefault();

        }

    }

);



$(

    "#telefonoUniversidad, #extensionUniversidad, #anoProdep, #telefono1, #telefono2, #telefono3, #telefono4, #anioSNI1, #anioSNI2, #anioSNI3, #anioSNI4"

).on("keypress", function (event) {

    /*Solamente numeros*/ key = event.keyCode || event.which;

    tecla = String.fromCharCode(key).toLowerCase();

    letras = "1234567890";

    especiales = "8-37-39-46";

    tecla_especial = false;

    for (var i in especiales) {

        if (key == especiales[i]) {

            tecla_especial = true;

            break;

        }

    }



    if (letras.indexOf(tecla) == -1 && !tecla_especial) {

        event.preventDefault();

    }

});



$("#formatearDireccion").on("click", function () {

    //NOS TRAEMOS LOS DATOS, LOS OCUPAMOS COMPLETOS PARA PODER DARLES UN FORMATO

    nombre_vialidad = $("#nombre_vialidad").val().trim();

    noInt = $("#noInt").val().trim();

    noExt = $("#noExt").val().trim();

    colonia = $("#colonia").val().trim();

    localidad = $("#localidad").val().trim();

    municipio = $("#municipio").val().trim();

    estado = $("#estado").val().trim();

    cp = $("#cp").val().trim();

    referencias = $("#referencias").val().trim();

    //VALIDAMOS SI TIENEN DATOS

    if (nombre_vialidad == "" || noInt == "" || noExt == "" || colonia == "" || localidad == "" ||

        municipio == "" || estado == "" || cp == "" || referencias == "") {

        //ALGUNO DE LOS CAMPOS ESTAN VACIOS, DEBO DE ADVERTIRLE AL USUARIO

        swal.fire({ icon: 'warning', title: 'Favor de completar los campos de su dirección para continuar' })

    } else {

        //TODO ESTA LLENO, SO... FORMATEAMOS Y LE DAMOS VALOR A LA DIRECCION CON EL CAMPO OBLIGATORIO

        completo = "Tipo " + nombre_vialidad + ", No.Int " + noInt + ", No. Ext " + noExt + ", Colonia " + colonia + ", Localidad " + localidad + ", Municipio " + municipio + ", Estado " + estado + ", CP " + cp + ". Referencias del domicilio " + referencias + ".";

        $("#direccionUniversidad").val(completo).prop("readonly", true);

        $("#divUniversidadAdscripcion").show('slow');

        if ($("#mismaDireccion").is(':checked')) {

            $("#direccionEnvio").val(completo);

        }

    }

});



$('#mismaDireccion').change(function () {

    if (this.checked) {

        $("#divEnviosDocumentos").show('slow');

        direccionUniversidad = $("#direccionUniversidad").val();

        $("#direccionEnvio").val(direccionUniversidad).prop('readonly', true);

        $("#formularioDocumentos").hide();

    } else {

        $("#formularioDocumentos").show('slow');

        $("#direccionEnvio").val("").prop('readonly', false);

        $("#divEnviosDocumentos").hide();

    }

});



$("#formatearDireccion2").on("click", function () {

    //NOS TRAEMOS LOS DATOS, LOS OCUPAMOS COMPLETOS PARA PODER DARLES UN FORMATO

    nombre_vialidad = $("#nombre_vialidad2").val().trim();

    noInt = $("#noInt2").val().trim();

    noExt = $("#noExt2").val().trim();

    colonia = $("#colonia2").val().trim();

    localidad = $("#localidad2").val().trim();

    municipio = $("#municipio2").val().trim();

    estado = $("#estado2").val().trim();

    cp = $("#cp2").val().trim();

    referencias = $("#referencias2").val().trim();

    //VALIDAMOS SI TIENEN DATOS

    if (nombre_vialidad == "" || noInt == "" || noExt == "" || colonia == "" || localidad == "" ||

        municipio == "" || estado == "" || cp == "" || referencias == "") {

        //ALGUNO DE LOS CAMPOS ESTAN VACIOS, DEBO DE ADVERTIRLE AL USUARIO

        swal.fire({ icon: 'warning', title: 'Favor de completar todos los campos para poder continuar' })

    } else {

        //TODO ESTA LLENO, SO... FORMATEAMOS Y LE DAMOS VALOR A LA DIRECCION CON EL CAMPO OBLIGATORIO

        completo = "Tipo " + nombre_vialidad + ", No.Int " + noInt + ", No. Ext " + noExt + ", Colonia " + colonia + ", Localidad " + localidad + ", Municipio " + municipio + ", Estado " + estado + ", CP " + cp + ". Referencias del domicilio " + referencias + ".";

        $("#direccionEnvio").val(completo).prop("readonly", true);

        $("#divEnviosDocumentos").show('slow');

    }

});

var telefono1 = document.querySelector("input[name='miembros[1][telefono]']");
window.intlTelInput(telefono1, {
    preventInvalidNumbers: true,
    autoPlaceholder: 'polite',
    initialCountry: "MX",
    formatOnDisplay: true,
    separateDialCode: false,
    utilsScript: '../resources/intl-tel-input/build/js/utils.js',
    autoHideDialCode: false,
    nationalMode: false,
});
var telefono2 = document.querySelector("input[name='miembros[2][telefono]']");
window.intlTelInput(telefono2, {
    preventInvalidNumbers: true,
    autoPlaceholder: 'polite',
    initialCountry: "MX",
    formatOnDisplay: true,
    separateDialCode: false,
    utilsScript: '../resources/intl-tel-input/build/js/utils.js',
    autoHideDialCode: false,
    nationalMode: false,
});
var telefono3 = document.querySelector("input[name='miembros[3][telefono]']");
window.intlTelInput(telefono3, {
    preventInvalidNumbers: true,
    autoPlaceholder: 'polite',
    initialCountry: "MX",
    formatOnDisplay: true,
    separateDialCode: false,
    utilsScript: '../resources/intl-tel-input/build/js/utils.js',
    autoHideDialCode: false,
    nationalMode: false,
});
var telefono4 = document.querySelector("input[name='miembros[4][telefono]']");
window.intlTelInput(telefono4, {
    preventInvalidNumbers: true,
    autoPlaceholder: 'polite',
    initialCountry: "MX",
    formatOnDisplay: true,
    separateDialCode: false,
    utilsScript: '../resources/intl-tel-input/build/js/utils.js',
    autoHideDialCode: false,
    nationalMode: false,
});

$("#noInt,#noExt,#noInt2,#noExt2").on('keypress', function (e) {

    key = e.keyCode || e.which;

    tecla = String.fromCharCode(key).toLowerCase();

    letras = "s/n0123456789abcdefghijklmnñopqrstuvwxyz";

    especiales = "8-37-39-46";

    tecla_especial = false;

    for (var i in especiales) {

        if (key == especiales[i]) {

            tecla_especial = true;

            break;

        }

    }



    if (letras.indexOf(tecla) == -1 && !tecla_especial) {

        e.preventDefault();

    }

})




const valoresPreguntas = {
    0: 'Tipo',
    1: 'No.Int',
    2: 'No. Ext',
    3: 'Colonia',
    4: 'Localidad',
    5: 'Municipio',
    6: 'Estado',
    7: 'CP',
    8: 'Referencias del domicilio'
  }
  
  
  const parent = document.getElementById('direcciones_universidad_form');
  
  const children = parent.querySelectorAll('input')
  
  children.forEach(element => {
    element.addEventListener('keyup',() => {
        const arreglo = valoresUni()
        
        if(children.length !== arreglo.length){
            document.getElementById('direccionUniversidad').value = ''
            $("#divUniversidadAdscripcion").hide('slow');
            return
        }
  
        let direccionFormato = '';
  
        arreglo.forEach((element,index) => {
            direccionFormato += valoresPreguntas[index]+' '+element+', '
        });
  
        direccionFormato = direccionFormato.slice(0, direccionFormato.length - 2);
  
        direccionFormato = direccionFormato+'.'
  
        document.getElementById('direccionUniversidad').value = direccionFormato
        document.getElementById('direccionUniversidad').readOnly = true
        $("#divUniversidadAdscripcion").show('slow');
    })
  })
  
  function valoresUni(){
    const arreglo = [];
  
    children.forEach(element => {
        let val = element.value;
        if(val !== ''){
            arreglo.push(val);
        }
        
    })
  
    return arreglo
  }
  
  
  const parentPaqueteria = document.getElementById('formularioDocumentos');
  
  const childrenPaqueteria = parentPaqueteria.querySelectorAll('input')
  
  childrenPaqueteria.forEach(element => {
    element.addEventListener('keyup',() => {
        const arreglo = valoresPaq()
        
        if(childrenPaqueteria.length !== arreglo.length){
            document.getElementById('direccionEnvio').value = ''
            $("#divEnviosDocumentos").hide('slow');
            return
        }
  
        let direccionFormato = '';
  
        arreglo.forEach((element,index) => {
            direccionFormato += valoresPreguntas[index]+' '+element+', '
        });
  
        direccionFormato = direccionFormato.slice(0, direccionFormato.length - 2);
  
        direccionFormato = direccionFormato+'.'
  
        document.getElementById('direccionEnvio').value = direccionFormato
        document.getElementById('direccionEnvio').readOnly = true
        $("#divEnviosDocumentos").show('slow');
    })
  })
  
  function valoresPaq(){
    const arreglo = [];
  
    childrenPaqueteria.forEach(element => {
        let val = element.value;
        if(val !== ''){
            arreglo.push(val);
        }
        
    })
  
    return arreglo
  }


  $("input").on('keypress', function(e){
    key = e.keyCode || e.which;

    tecla = String.fromCharCode(key).toLowerCase();

    if(tecla == '"'){
      e.preventDefault()
    }
})
//[type='']

$(document).on('keyup','input[type="tel"]', function(e){
  var texto = $(this).val();
  var contar = 0;
  var start = 0;
  while ((start = texto.indexOf("+", start) + 1) > 0) {
      contar++;
  }

  if(contar > 1){
    texto = texto.substring(0, texto.length - 1);
    $(this).val(texto)
  }
})

$(document).on('keydown','input[type="tel"]', function(e){
  const keyPressed = e.key;
  const isNumber = /^\d$/.test(keyPressed);
  const isBackspaceOrDelete = ['Backspace', 'Delete'].includes(keyPressed);
  
  if (!isNumber && !isBackspaceOrDelete) {
    e.preventDefault();
  }
})

$(document).on('keypress','input[type="tel"]', function(e){

  key = e.keyCode || e.which;

  tecla = String.fromCharCode(key).toLowerCase();

  letras = "1234567890+";

  especiales = "8-37-39-46";

  tecla_especial = false;

  for (var i in especiales) {

      if (key == especiales[i]) {

          tecla_especial = true;

          break;

      }

  }

  if (letras.indexOf(tecla) == -1 && !tecla_especial) {

       e.preventDefault();       

  }
})