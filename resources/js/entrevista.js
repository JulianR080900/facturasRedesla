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

                            icon: 'error',

                            text: 'Favor de completar todos los campos'

                        })

                    }



                    form.classList.add('was-validated')

                }, false);

            });

    })();



    $("#siguiente").on("click", function() {

        $("#primeraSeccion").hide();

        $("#bitacoraSection").show();

        var hora_inicio = $("#hora_aplicacion_inicio").val();

        var hora_final = $("#hora_aplicacion_final").val();

        var duracion_entrevista = $("#duracion_entrevista").val();

        var fecha_entrevista = $("#fecha_entrevista").val();

        $("#hora_inicio").val(hora_inicio);

        $("#hora_final").val(hora_final);

        $("#duracion").val(duracion_entrevista);

        $("#fecha").val(fecha_entrevista);



    });



    $("#regresar").on("click", function() {

        $("#primeraSeccion").show();

        $("#bitacoraSection").hide();

    })





    $("#pregunta19").on("change", function() {

        var val = this.value;

        var selects = [20, 21, 22, 23];

        if (val == "si") {

            $("#preguntas_condicionales").show();

            selects.forEach(function(index) {

                id = "pregunta" + index;

                $("#" + id).prop("required", true);

            });

        } else {

            $("#preguntas_condicionales").hide();

            selects.forEach(function(index) {

                id = "pregunta" + index;

                $("#" + id).prop("required", false);

            });

        }

    });



    $("#pregunta3").on("change", function() {

        var val = this.value;

        if (val == "si") {

            $("#oculto1").show();

            $("#pregunta4").prop("required", true);

            //mostramos el boton de enviar

        } else {

            $("#oculto1").hide();

            $("#pregunta4").prop("required", false);

            //mostramos el boton de enviar

        }

    });



    $("#pregunta10").on("change", function() {

        var estado = this.value;

        $.ajax({

            type: "POST",

            url: base_url + '/getMunicipio',

            data: {

                'estado': estado

            },

            success: function(data) {

                $("#pregunta11").html(data);

            }

        });

    });



    $("#pregunta7").on("change", function() {

        var val = this.value;

        console.log(val);

        if (val == "otro") {

            $("#otro_ciclo").show();

            $("#pregunta7_5").prop("required", true);

        } else {

            $("#otro_ciclo").hide();

            $("#pregunta7_5").prop("required", false);

        }

    });



    function soloNA(e) {

        var key = e.keyCode || e.which,

            tecla = String.fromCharCode(key).toLowerCase(),

            letras = " naNA0123456789",

            especiales = [8, 37, 39, 46],

            tecla_especial = false;





        if (letras.indexOf(tecla) == -1 && !tecla_especial) {

            return false;

        }

    }



    $("#hora_aplicacion_inicio, #hora_aplicacion_final").on("change", function() {

        var inicio = $("#hora_aplicacion_inicio").val();

        var final = $("#hora_aplicacion_final").val();

        var inicio_split = inicio.split(':');

        var final_split = final.split(':');

        if (inicio === "" || final === "") {



        } else {

            min_inicio = parseInt(inicio_split[1]);

            min_final = parseInt(final_split[1]);

            min_max = Math.max(min_inicio, min_final);

            if (min_max == min_inicio) {

                resta = min_inicio - min_final;

            } else {

                resta = min_final - min_inicio;

            }

            //////////////////////////////

            hr_inicio = parseInt(inicio_split[0]);

            hr_final = parseInt(final_split[0]);

            hr_max = Math.max(hr_inicio, hr_final);

            if (min_max == hr_inicio) {

                resta2 = hr_inicio - hr_final;

            } else {

                resta2 = hr_final - hr_inicio;

            }

            if (Math.sign(resta2) == -1) {

                Swal.fire(

                    'Cuidado',

                    'Ingrese las horas en el orden correcto',

                    'warning'

                )

                $("#hora_aplicacion_inicio").val("");

                $("#hora_aplicacion_final").val("");

            } else {

                console.log(resta.toString().length);

                console.log(resta);

                if (resta2.toString().length == 1) {

                    resta2 = "0" + resta2;

                }

                if (resta.toString().length == 1) {

                    resta = "0" + resta;

                }

                $("#duracion_entrevista").val(resta2 + ":" + resta + " horas");

            }



        }

    });


/*
    if (message == "successInsert") {

        Swal.fire({

            icon: 'success',

            title: 'Entrevista registrada correctamente',

            html: 'Su número de entrevista es el <h2>'+id_insert+'</h2>Favor de ingresar este número en su encuesta impresa.<br>¿Desea transcribir otra entrevista?',

            allowOutsideClick: false,

            allowEscapeKey: false,

            showCancelButton: true,

            confirmButtonColor: '#3085d6',

            cancelButtonColor: '#d33',

            confirmButtonText: 'Sí',

            cancelButtonText: 'No'

        }).then((result) => {

            if (result.isConfirmed) {

                //recargar la pagina

                location.reload();

            } else {

                //cerrar la pagina

                Swal.fire({

                    icon: 'success',

                    title: 'Gracias por haber transcrito su entrevista',

                    allowOutsideClick: false,

                    allowEscapeKey: false,

                    showCancelButton: false

                }).then((result) => {

                    if (result.isConfirmed) {

                        window.close();

                    }

                })





            }

        })

    }
    */