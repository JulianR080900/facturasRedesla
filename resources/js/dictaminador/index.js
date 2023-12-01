$("#consultar").on("click", function() {

    correo = $("#correo").val();

    if (correo === "") {

        Swal.fire({

            icon: 'error',

            title: 'Oops...',

            text: 'Ingrese su correo electronico para continuar',

        })

    } else {

        if (validarEmail(correo)) {

            try {



                $.ajax({

                    type: "POST",

                    url: base_url + '/extraerConstancias',

                    data: {
                        "correo": correo
                    },

                    dataType: "json",

                    success: function(data) {

                        if(data === false){
                            Swal.fire({

                            icon: 'error',

                            title: 'Lo sentimos',

                            text: 'Tu correo no esta proporcionado para la constancia',

                            });
                        }else {

                            $("#divconsultar").hide();

                            html = "";

                            a_redes = [];

                            $("#correo").prop("disabled", true);

                            for (var i = 0; i <= ((data["cantidad_registros"]) - 1); i++) {

                                a_redes.push(data[i]["area_revision"]);

                                html = html + "<div class='col-md-12'>";

                                html = html + "<h1 class='"+data[i]["area_revision"]+"'><i>" + data[i]["area_revision"] + "</i></h1><br>";

                                html = html + "<label>Nombre:</label><br>";

                                html = html + "<input type='text' class='form-control' placeholder='" + data[i]["nombre"] + "' disabled><br>";

                                html = html + "<label>Red:</label><br>";

                                html = html + "<input type='text' class='form-control' placeholder='" + data[i]["area_revision"] + "' disabled><br>";

                                html = html + "<label>Nombre del articulo:</label><br>";

                                html = html + "<input type='text' class='form-control' placeholder='" + decodeURIComponent(escape(data[i]["nombre_articulo"])) + "' disabled><br>";

                                html = html + "</div>";

                            }

                            c_registros = data["cantidad_registros"];

                            var unique = a_redes.filter(onlyUnique);

                            anios_encontrados = [];

                            for (var e = 0; e <= ((data["cantidad_registros"]) - 1); e++) {

                                var anio_ciclo = data[e].anio;

                                if (anios_encontrados.indexOf(anio_ciclo) != 0) { //SIGNIFICA QUE YA EXISTE

                                    anios_encontrados[e] = anio_ciclo;

                                    html = html + `
                                    <div class='col-md-12'>
                                    <form method='POST' action='` + base_url + `/constancia_unico'>
                                    <input name='correo' value='` + correo + `' hidden>
                                    <input name='anio' value='` + anio_ciclo + `' hidden>
                                    <button type='submit' 
                                    class='btn form-control btnPrimary' 
                                    data-id='` + anio_ciclo + `' 
                                    name='imprimir'>Imprimir cartas dictaminador ` + anio_ciclo + ` <i class='fa-solid fa-print'></i>
                                    </button>
                                    </form>
                                    </div>
                                    <br><br>`;

                                }

                            }

                            obj = data['cantidad_anios']

                            for (const index in obj) {
                                if(obj[index]['cantidad'] >= 10){
                                    html = html + `
                                    <div class='col-md-12'>
                                    <form method='POST' action='` + base_url + `/distincion'>
                                    <input name='correo' value='` + correo + `' hidden>
                                    <input name='anio' value='` + obj[index]['anio'] + `' hidden>
                                    <button type='submit' 
                                    class='btn  form-control btnSecundary' 
                                    id='distincion'>Imprimir Distinción `+obj[index]['anio']+` 
                                    <i style='color:gold' class="fa-solid fa-certificate"></i>
                                    </button>
                                    </form>
                                    </div>
                                    <br><br>`;
                                }
                            }

                            html = html + "</div>";

                            cantidad_redes = unique.length;

                            $("#datos").html(html);

                        }


                    },
                    error: function(request, status, error) {

                        // console.log(error);

                        Swal.fire({

                            icon: 'error',

                            title: 'Upsss...',

                            text: 'Ha ocurrido un error, favor de intentar mas tarde',

                        });

                    }

                });

            } catch (e) {

                Swal.fire({

                    icon: 'error',

                    title: 'Upsss...',

                    text: 'Ha ocurrido un error, favor de intentar mas tarde',

                });

            }

        } else {

            Swal.fire({

                icon: 'warning',

                title: '!OJO!',

                text: 'Ingrese un correo electrónico válido',

            });

        }

    }

});

function onlyUnique(value, index, self) {

    return self.indexOf(value) === index;

}

function validarEmail(valor) {

    if (valor === "") {

        return true

    }

    if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)) {

        return true;

    } else {

        return false;

    }

}