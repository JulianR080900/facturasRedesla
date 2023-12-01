
// ===================== ALERTA GENERAL DE VALIDACION DE CAMPOS ========================

(function () {
    "use strict";

    // Fetch all the forms we want to apply custom Bootstrap validation styles to

    var forms = document.querySelectorAll(".needs-validation");

    // Loop over them and prevent submission

    Array.prototype.slice.call(forms).forEach(function (form) {
      form.addEventListener(
        "submit",

        function (event) {
          $("#btnTerminarRegistro").prop("disabled", true);

          if (!form.checkValidity()) {
            event.preventDefault();

            event.stopPropagation();

            swal.fire({
              icon: "error",

              title: "Lo sentimos",

              text: "Favor de completar todos los campos.",
            });

            const parentPaqueteria = document.getElementById("formularioDocumentos");

            const childrenPaqueteria = parentPaqueteria.querySelectorAll("input:not([type='checkbox'])");

            childrenPaqueteria.forEach((element) => {
              let id = element.id;
              let val = $("#" + id).val();
              let option = $("#tipo_vialidad_select2 option:selected").val();

              if(val == ''){
                $("#" + id).css('border-color', 'purple')
              }
              
              if(option ==''){
                $("#tipo_vialidad_select2").css('border-color', 'purple')
              }

            });

            $("#btnTerminarRegistro").prop("disabled", false);
          }else{
            event.preventDefault(); // Evitar la presentación normal del formulario
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: "./insertRegistroRedes",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function(){
                  $('#loader').show()
                },
                success: function (response) {
                  Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Registro completado correctamente',
                    footer: 'Se mandaron instrucciones a los correos proporcionados',
                    confirmButtonColor: '#4ADEDE',
                    confirmButtonText: `<a href='https://redesla.la/redesla'  style='text-decoration: none;color:#fff;' >Hecho</a>`,
                    allowOutsideClick: false
                  })
                },
                error: function (jqXHR) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error '+jqXHR.responseJSON.status,
                    text: 'Ha ocurrido un error',
                    confirmButtonColor: '#25D366',
                    confirmButtonText: `<a target='_blank' style='text-decoration: none;color:#fff;' href="https://api.whatsapp.com/send?phone=52${jqXHR.responseJSON.telefono}&text=${encodeURIComponent(`Hola, me llamo *su nombre* y tengo problemas al hacer mi registro, el código de error que me arroja es: *${jqXHR.responseJSON.status}*`)}"><i class="fa-brands fa-whatsapp"></i> Notificar</a>`,
                    allowOutsideClick: false
                  })
                },
                complete: function () {
                  $('#loader').hide()
                  $("#btnTerminarRegistro").prop("disabled", false);
                },
            });
          }

          form.classList.add("was-validated");
        },

        false
      );
    });
})();

// ===================== FIN ========================



// ===================== BOTONES ========================

$("#regresar_universidad").on("click", function () {
  $("#datos_universidad").show("slow");

  $("#cantidad_miembros").hide();
});

$("#regresar_cantidad").on("click", function () {
  $("#cantidad_miembros").show("slow");

  $("#datos_miembros").hide();
});

$("#siguiente_datos").on("click", function () {
  var cheked = document.querySelector('input[name="c_miembros"]:checked');

  if (cheked === null) {
    swal.fire({
      icon: "warning",

      text: "Seleccione una cantidad de miembros para el cuerpo academico",
    });
  } else {
    total_miembros = document.querySelector(
      'input[name="c_miembros"]:checked'
    ).value;

    tipo_registro = $("input[name='tipo_registro']:checked").val();

    if (tipo_registro == "oyente" && total_miembros > 1) {
      swal.fire({
        icon: "warning",
        title:
          "No puede seleccionar mas de 1 integrante por su tipo de registro",
      });
    } else if (tipo_registro == "coloquio" && total_miembros > 3) {
      swal.fire({
        icon: "warning",
        title:
          "No puede seleccionar mas de 3 integrantes por su tipo de registro",
      });
    } else {
      $("#datos_miembros").show("slow");

      $("#cantidad_miembros").hide();

      var imprimir_datosMiembros = document.getElementById("div_datosMiembros");

      generarFormulariosMiembros(imprimir_datosMiembros)

      
    }
  }
});

// ===================== FIN ========================




// ===================== FUNCIONES GENERALES ========================

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

function isNum(val) {
  return !isNaN(val);
}

function miembroSNI(i) {
  // radioSNI = $("#radioSNI"+i).val();

  radioSNI = $('input:radio[name="miembros[' + i + '][SNI]"]:checked').val();

  if (radioSNI == "si") {
    $("#datosSNI" + i).show("slow");

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

  correo1 = $("#correop1").val();

  correo2 = $("#correop2").val();

  correo3 = $("#correop3").val();

  correo4 = $("#correop4").val();

  if (correo === "") {
    swal.fire({
      icon: "error",
      title: "Favor de ingresar un correo electrónico",
    });
  } else {
    const correos = [correo1, correo2, correo3, correo4];
    const duplicateCheck = correos.filter(c => c === correo);
  
    if (duplicateCheck.length > 1) {
      swal.fire({
        icon: "error",
        title: "Favor de no ingresar el mismo correo 2 veces",
      });
    } else {
      switch (i) {
        case 1:
          traer_datos(1, correo);
          break;
        case 2:
          traer_datos(2, correo);
          break;
        case 3:
          traer_datos(3, correo);
          break;
        case 4:
          traer_datos(4, correo);
          break;
        default:
          // Handle other cases or provide a default behavior
          break;
      }
    }
  }
  
}

function nacionalidad(i) {
  valorNacionalidad = $("#nacionalidad" + i).val();

  // alert(valorNacionalidad);

  if (valorNacionalidad == 1) {
    $("#divOtraNAcionalidad" + i).show("slow");

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

        if(datos.cuerpo_inactivo){
          Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Actualmente este correo tiene un registro en revisión, no es necesario ejecutar un nuevo registro para tener acceso. Debe esperar de 1 a 3 días hábiles para ser aprobado.',
            confirmButtonText: "Entiendo, deseo continuar con un nuevo registro",
            allowOutsideClick: false,
            confirmButtonColor: '#6ca348',
            focusConfirm: false,
          });
        }
        

        $("#editMail_"+i).prop('disabled',false).click(function(){
          EditMailBorrarDatos(i);
        })
        // console.log(datos);

        if (datos == "") {
          //no existe correo

          $("#correo_miembro_" + i).show();

          $("#correop" + i).attr("readonly", "readonly");

          $("#datos_miembro_" + i).show("slow");
        } else {
          $("#correo_miembro_" + i).show();

          $("#correop" + i).attr("readonly", "readonly");

          $("#datos_miembro_" + i).show("slow");

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

          $("#msjTelefono" + i)
            .removeAttr("hidden")
            .append(
              `Nota: La imagen alusiva es por defecto. Su número continua tal como esta, 
              si desea realizar un cambio favor de realizarlo dentro de la plataforma.`
            )
            .css("font-size", "13px");

          $("#correoi" + i)
            .val(datos["correo_institucional"])

            .attr("readonly", "readonly");

            if(datos['profile_pic'] != ''){
              $("#imagenAvatar"+i).attr('src','../resources/img/profiles/'+datos['profile_pic']).css('border-radius','50%')
            }

          $("#usuario" + i).val(datos["usuario"]);

          // $('input:radio[name="miembros[`+i+`][SNI]"]').attr("readonly", true);

          // $("input:radio[name='miembros["+i+"][SNI]'][value='no']").addClass("avoid-clicks");

          // $("input:radio[name='miembros["+i+"][SNI]'][value='si']").addClass("avoid-clicks");

          $("#siSNI" + i).addClass("avoid-clicks-radio");

          $("#noSNI" + i).addClass("avoid-clicks-radio");

          // Verificar si hay datos SNI

          if (
            datos["nivelSNI"] == "" ||
            datos["nivelSNI"] === null ||
            datos["nivelSNI"] == 6
          ) {
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

            $("#datosSNI" + i).show("slow");

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
              // console.log("es numerico");

              $("#nacionalidad" + i)
                .val(datos["nacionalidad"])

                .addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

              $("#otraNacionalidad" + i).attr("disabled", "disabled");

              $("#divOtraNAcionalidad" + i).hide();
            } else {
              // console.log("es text");

              $("#nacionalidad" + i)
                .val("1")

                .addClass("avoid-clicks"); // añado una clase que desabilita los click y cambia el fondo color gris

              $("#otraNacionalidad" + i)
                .val(datos["nacionalidad"])

                .attr("readonly", true);

              $("#divOtraNAcionalidad" + i).show("slow");
            }
          }
        }
      },
    });
  }
}

function generarFormulariosMiembros(imprimir_datosMiembros){
  if (c_miembros_global == "") {
    // si no existe se crea los campos para los datos de los miembros

    for (var i = 1; i <= total_miembros; i++) {
      lider = i == 1 ? 1 : 0;
      texto = i == 1 ? "líder (autor)" : "miembro (autor)";
      imprimir_datosMiembros.insertAdjacentHTML(
        "beforeend",
        `<div class="row" id="miembro` +
        i +
        `">
                    <div class="col-md-3">
                    <div class="text-center">
                    <img src="../resources/img/registros_redes/avatar_hombre.png" 
                    style="width: 110px; height: 130px;" id="imagenAvatar` +
        i +
        `" alt="" />
                    </div>
                    <br />
                    <div class="text-center">
                    <div class="yc-form">
                    <input type="radio" id="hombre` +
        i +
        `" name="miembros[` +
        i +
        `][sexo]" onchange="cambiaravatar(` +
        i +
        `)" 
                    value="1" checked="checked" required="" /> 
                    <label for="hombre` +
        i +
        `" id="labelHombre` +
        i +
        `" class="sexo">Hombre</label> 
                    <input type="radio" id="mujer` +
        i +
        `" name="miembros[` +
        i +
        `][sexo]" 
                    onchange="cambiaravatar(` +
        i +
        `)" value="0" required="" /> 
                    <label for="mujer` +
        i +
        `" id="labelMujer` +
        i +
        `" class="sexo">Mujer</label>
                    </div>
                    </div>
                    </div>
                    <div class="col-md-9">
                    <h1>Datos del ` +
        texto +
        `</h1>
                    <div id="correo_miembro_` +
        i +
        `">
                    <div class="mb-3">
                    <label for="correop` +
        i +
        `">Correo personal</label> 
        <div class="input-group mb-3">
        <input type="email" class="form-control oe" id="correop` +i +`" name="miembros[` +i +`][correo_personal]" placeholder="Correo personal" required="" />
        <div class="invalid-feedback">Ingresa un correo electr&oacute;nico v&aacute;lido.</div>
          <div class="input-group-append">
            <button class="btn btn-warning editMail" type="button" id="editMail_${i}">Editar</button>
          </div>
        </div>


                    
                    <br />
                    <button type="button" class="btn btn-miembros btn-block" id="validarCorreo` +
        i +
        `" 
                    onclick="verificarCorreo(` +
        i +
        `);">Validar correo</button>
        
                    <input type="text" hidden="" id="usuario` +
        i +
        `" name="miembros[` +
        i +
        `][usuario]" /> 
                    <input type="text" hidden="" name="miembros[` +
        i +
        `][lider]" value="` +
        lider +
        `" />
                    </div>
                    </div>
                    <div id="datos_miembro_` +
        i +
        `" style="display: none;">
                    <div class="mb-3">
                    <label for="nombre` +
        i +
        `">Nombre</label> 
                    <input type="text" class="form-control ol" id="nombre` +
        i +
        `" name="miembros[` +
        i +
        `][nombre]" 
                    placeholder="Nombre" required="" />
                    <div class="invalid-feedback">Ingresa el nombre.</div>
                    </div><div class="mb-3">
                    <label for="appat` +
        i +
        `">Apellito paterno</label> 
                    <input type="text" class="form-control ol" id="appat` +
        i +
        `" name="miembros[` +
        i +
        `][ap_paterno]" 
                    placeholder="Apellido paterno" required="" />
                    <div class="invalid-feedback">Ingresa el apellido paterno.</div>
                    </div>
                    <div class="mb-3">
                    <label for="apmat` +
        i +
        `">Apellito materno</label> 
                    <input type="text" class="form-control ol" id="apmat` +
        i +
        `" name="miembros[` +
        i +
        `][ap_materno]" 
                    placeholder="Apellido materno" required="" />
                    <div class="invalid-feedback">Ingresa el apellido materno.</div>
                    <div class="mb-3">
                    <label for="nacionalidad` +
        i +
        `">Nacionalidad</label>
                    <select class="form-control" name="miembros[` +
        i +
        `][nacionalidad]" id="nacionalidad` +
        i +
        `" 
                    onchange="nacionalidad(` +
        i +
        `)" required="">
                    <option value="" selected="selected" disabled="disabled">Selecciona nacionalidad</option>
                    <option value="2">Mexicana</option>
                    <option value="3">Colombiana</option>
                    <option value="4">Peruana</option>
                    <option value="5">Ecuatoriana</option>
                    <option value="6">Argentina</option>
                    <option value="1">Otro</option></select>
                    <div class="invalid-feedback">Ingrese su nacionalidad</div>
                    </div><div class="mb-3" id="divOtraNAcionalidad` +
        i +
        `" style="display: none;">
                    <label for="nacionalidad` +
        i +
        `">Nombre de la nacionalidad</label> 
                    <input type="text" class="form-control ol" id="otraNacionalidad` +
        i +
        `" 
                    name="miembros[` +
        i +
        `][nacionalidad]" placeholder="Nacionalidad" />
                    <div class="invalid-feedback">Ingresa el nombre de la nacionalidad del miembro.</div>
                    </div><div class="mb-3"><label for="grado` +
        i +
        `">Grado acad&eacute;mico</label>
                    <select class="form-control" name="miembros[` +
        i +
        `][grado_academico]" id="grado` +
        i +
        `" 
                    required="">
                    <option value="" selected="selected" disabled="disabled">Selecciona grado acad&eacute;mico</option>
                    <option value="1">Licenciatura</option>
                    <option value="2">Ingenier&iacute;a</option>
                    <option value="3">Maestr&iacute;a</option>
                    <option value="4">Doctorado</option>
                    <option value="5">Sin registrar</option>
                    </select><div class="invalid-feedback">Ingrese el grado acad&eacute;mico</div>
                    </div>
                    <div class="mb-3">
                    <label for="especialidad` +
        i +
        `">Especialidad</label> 
                    <input type="text" class="form-control ol" id="especialidad` +
        i +
        `" name="miembros[` +
        i +
        `][especialidad]" 
                    placeholder="Especialidad" required="" />
                    <div class="invalid-feedback">Ingresa el nombre de la especialidad.</div>
                    </div>
                    <div class="mb-3">
                    <label for="">SNII</label><br />
                    <label id="siSNI` +
        i +
        `" class="custom-control custom-radio custom-control-inline"> 
                    <input type="radio" name="miembros[` +
        i +
        `][SNI]" value="no" id="radioSNI` +
        i +
        `" checked="checked" 
                    class="custom-control-input prodep" onclick="miembroSNI(` +
        i +
        `)" required="" />
                    <span class="custom-control-label">No</span> </label> 
                    <label id="noSNI` +
        i +
        `" class="custom-control custom-radio custom-control-inline"> 
                    <input type="radio" name="miembros[` +
        i +
        `][SNI]" value="si" id="radioSNI` +
        i +
        `" 
                    class="custom-control-input prodep" onclick="miembroSNI(` +
        i +
        `)" required="" />
                    <span class="custom-control-label">Sí</span> </label>
                    </div>
                    <div id="datosSNI` +
        i +
        `" style="display: none;">
                    <div class="mb-3"><label for="nivelSNI` +
        i +
        `">Nivel SNII</label>
                    <select class="form-control" name="miembros[` +
        i +
        `][nivelSNI]" id="nivelSNI` +
        i +
        `">
                    <option value="" selected="selected" disabled="disabled">Selecciona nivel SNII</option>
                    <option value="1">Candidato a Investigador Nacional</option>
                    <option value="2">Investigador Nacional Nivel I</option>
                    <option value="3">Investigador Nacional Nivel II</option>
                    <option value="4">Investigador Nacional Nivel III</option>
                    <option value="5">Investigador Nacional Em&eacute;rito</option>
                    </select>
                    <div class="invalid-feedback">Ingrese el nivel SNII</div>
                    </div>
                    <div class="mb-3">
                    <label for="anioSNI` +
        i +
        `">A&ntilde;o en que obtuvo el nivel</label> 
                    <input type="number" class="form-control on" id="anioSNI` +
        i +
        `" name="miembros[` +
        i +
        `][anoSNI]" 
                    placeholder="A&ntilde;o SNII" />
                    <div class="invalid-feedback">A&ntilde;o en que obtuvo el nivel</div>
                    </div>
                    </div>
                    <div class="mb-3">
                    <label for="telefono` +
        i +
        `">Tel&eacute;fono</label> 
                    <div id='msjTelefono` +
        i +
        `' hidden></div>
                    <input type="tel" class="form-control" id="telefono` +
        i +
        `" name="miembros[` +
        i +
        `][telefono]" 
                    placeholder="Telefono" required="" />
                    <div class="invalid-feedback">Ingresa su número de teléfono</div>
                    </div>
                    <div class="mb-3">
                    <label for="correoi` +
        i +
        `">Correo institucional</label> 
                    <input type="email" class="form-control oe" id="correoi` +
        i +
        `" name="miembros[` +
        i +
        `][correo_institucional]" 
                    placeholder="Correo institucional" required="" />
                    <div class="invalid-feedback">Ingresa su correo institucional.</div>
                    </div>
                    </div>
                    </div>
                    </div>`
      );

      var inputEditEmail = document.querySelectorAll('button.editMail');
      inputEditEmail.forEach(function(button) {
        button.disabled = true;
      });

      var telefono = document.querySelector(
        "input[name='miembros[" + i + "][telefono]']"
      );
      window.intlTelInput(telefono, {
        preventInvalidNumbers: true,
        autoPlaceholder: "polite",
        initialCountry: "MX",
        formatOnDisplay: true,
        separateDialCode: false,
        utilsScript: "../resources/intl-tel-input/build/js/utils.js",
        autoHideDialCode: false,
        nationalMode: false,
      });

      c_miembros_global = total_miembros; // y damos valor a la variable global de la cantidad de miembros
    }
  } else if (c_miembros_global < total_miembros) {
    for (
      var i = parseInt(c_miembros_global) + 1;
      i <= total_miembros;
      i++
    ) {
      lider = i == 1 ? 1 : 0;
      texto = i == 1 ? "lider" : "miembro";

      imprimir_datosMiembros.insertAdjacentHTML(
        "beforeend",
        `<div class="row" id="miembro` +
        i +
        `">
                    <div class="col-md-3">
                    <div class="text-center">
                    <img src="../resources/img/registros_redes/avatar_hombre.png" 
                    style="width: 110px; height: 130px;" id="imagenAvatar` +
        i +
        `" alt="" />
                    </div>
                    <br />
                    <div class="text-center">
                    <div class="yc-form">
                    <input type="radio" id="hombre` +
        i +
        `" name="miembros[` +
        i +
        `][sexo]" onchange="cambiaravatar(` +
        i +
        `)" 
                    value="1" checked="checked" required="" /> 
                    <label for="hombre` +
        i +
        `" id="labelHombre` +
        i +
        `" class="sexo">Hombre</label> 
                    <input type="radio" id="mujer` +
        i +
        `" name="miembros[` +
        i +
        `][sexo]" 
                    onchange="cambiaravatar(` +
        i +
        `)" value="0" required="" /> 
                    <label for="mujer` +
        i +
        `" id="labelMujer` +
        i +
        `" class="sexo">Mujer</label>
                    </div>
                    </div>
                    </div>
                    <div class="col-md-9">
                    <h1>Datos del ` +
        texto +
        `</h1>
                    <div id="correo_miembro_` +
        i +
        `">
                    <div class="mb-3">
                    <label for="correop` +
        i +
        `">Correo personal</label> 
                    <input type="email" class="form-control" id="correop` +
        i +
        `" name="miembros[` +
        i +
        `][correo_personal]" 
                    placeholder="Correo personal" required="" />
                    <div class="invalid-feedback">Ingresa un correo electr&oacute;nico v&aacute;lido.</div>
                    <br />
                    <button type="button" class="btn btn-miembros btn-block" id="validarCorreo` + i +`" onclick="verificarCorreo(` + i +`);">Validar correo</button>
                    
                    <input type="text" hidden="" id="usuario` +
        i +
        `" name="miembros[` +
        i +
        `][usuario]" /> 
                    <input type="text" hidden="" name="miembros[` +
        i +
        `][lider]" value="` +
        lider +
        `" />
                    </div>
                    </div>
                    <div id="datos_miembro_` +
        i +
        `" style="display: none;">
                    <div class="mb-3">
                    <label for="nombre` +
        i +
        `">Nombre</label> 
                    <input type="text" class="form-control" id="nombre` +
        i +
        `" name="miembros[` +
        i +
        `][nombre]" 
                    placeholder="Nombre" required="" />
                    <div class="invalid-feedback">Ingresa el nombre.</div>
                    </div><div class="mb-3">
                    <label for="appat` +
        i +
        `">Apellito paterno</label> 
                    <input type="text" class="form-control" id="appat` +
        i +
        `" name="miembros[` +
        i +
        `][ap_paterno]" 
                    placeholder="Apellido paterno" required="" />
                    <div class="invalid-feedback">Ingresa el apellido paterno.</div>
                    </div>
                    <div class="mb-3">
                    <label for="apmat` +
        i +
        `">Apellito materno</label> 
                    <input type="text" class="form-control" id="apmat` +
        i +
        `" name="miembros[` +
        i +
        `][ap_materno]" 
                    placeholder="Apellido materno" required="" />
                    <div class="invalid-feedback">Ingresa el apellido materno.</div>
                    <div class="mb-3">
                    <label for="nacionalidad` +
        i +
        `">Nacionalidad</label>
                    <select class="form-control" name="miembros[` +
        i +
        `][nacionalidad]" id="nacionalidad` +
        i +
        `" 
                    onchange="nacionalidad(` +
        i +
        `)" required="">
                    <option value="" selected="selected" disabled="disabled">Selecciona nacionalidad</option>
                    <option value="2">Mexicana</option>
                    <option value="3">Colombiana</option>
                    <option value="4">Peruana</option>
                    <option value="5">Ecuatoriana</option>
                    <option value="6">Argentina</option>
                    <option value="1">Otro</option></select>
                    <div class="invalid-feedback">Ingrese su nacionalidad</div>
                    </div><div class="mb-3" id="divOtraNAcionalidad` +
        i +
        `" style="display: none;">
                    <label for="nacionalidad` +
        i +
        `">Nombre de la nacionalidad</label> 
                    <input type="text" class="form-control" id="otraNacionalidad` +
        i +
        `" 
                    name="miembros[` +
        i +
        `][nacionalidad]" placeholder="Nacionalidad" />
                    <div class="invalid-feedback">Ingresa el nombre de la nacionalidad del miembro.</div>
                    </div><div class="mb-3"><label for="grado` +
        i +
        `">Grado acad&eacute;mico</label>
                    <select class="form-control" name="miembros[` +
        i +
        `][grado_academico]" id="grado` +
        i +
        `" 
                    required="">
                    <option value="" selected="selected" disabled="disabled">Selecciona grado acad&eacute;mico</option>
                    <option value="1">Licenciatura</option>
                    <option value="2">Ingenier&iacute;a</option>
                    <option value="3">Maestr&iacute;a</option>
                    <option value="4">Doctorado</option>
                    <option value="5">Sin registrar</option>
                    </select><div class="invalid-feedback">Ingrese el grado acad&eacute;mico</div>
                    </div>
                    <div class="mb-3">
                    <label for="especialidad` +
        i +
        `">Especialidad</label> 
                    <input type="text" class="form-control" id="especialidad` +
        i +
        `" name="miembros[` +
        i +
        `][especialidad]" 
                    placeholder="Especialidad" required="" />
                    <div class="invalid-feedback">Ingresa el nombre de la especialidad.</div>
                    </div>
                    <div class="mb-3">
                    <label for="">SNII</label><br />
                    <label id="siSNI` +
        i +
        `" class="custom-control custom-radio custom-control-inline"> 
                    <input type="radio" name="miembros[` +
        i +
        `][SNI]" value="no" id="radioSNI` +
        i +
        `" checked="checked" 
                    class="custom-control-input prodep" onclick="miembroSNI(` +
        i +
        `)" required="" />
                    <span class="custom-control-label">No</span> </label> 
                    <label id="noSNI` +
        i +
        `" class="custom-control custom-radio custom-control-inline"> 
                    <input type="radio" name="miembros[` +
        i +
        `][SNI]" value="si" id="radioSNI` +
        i +
        `" 
                    class="custom-control-input prodep" onclick="miembroSNI(` +
        i +
        `)" required="" />
                    <span class="custom-control-label">Si</span> </label>
                    </div>
                    <div id="datosSNI` +
        i +
        `" style="display: none;">
                    <div class="mb-3"><label for="nivelSNI` +
        i +
        `">Nivel SNII</label>
                    <select class="form-control" name="miembros[` +
        i +
        `][nivelSNI]" id="nivelSNI` +
        i +
        `">
                    <option value="" selected="selected" disabled="disabled">Selecciona nivel SNII</option>
                    <option value="1">Candidato a Investigador Nacional</option>
                    <option value="2">Investigador Nacional Nivel I</option>
                    <option value="3">Investigador Nacional Nivel II</option>
                    <option value="4">Investigador Nacional Nivel III</option>
                    <option value="5">Investigador Nacional Em&eacute;rito</option>
                    </select>
                    <div class="invalid-feedback">Ingrese el nivel SNII</div>
                    </div>
                    <div class="mb-3">
                    <label for="anioSNI` +
        i +
        `">A&ntilde;o en que obtuvo el nivel</label> 
                    <input type="number" class="form-control" id="anioSNI` +
        i +
        `" name="miembros[` +
        i +
        `][anoSNI]" 
                    placeholder="A&ntilde;o SNI" />
                    <div class="invalid-feedback">A&ntilde;o en que obtuvo el nivel</div>
                    </div>
                    </div>
                    <div class="mb-3">
                    <label for="telefono` +
        i +
        `">Tel&eacute;fono</label> 
                    <div id='msjTelefono` +
        i +
        `' hidden></div>
                    <input type="tel" class="form-control" id="telefono` +
        i +
        `" name="miembros[` +
        i +
        `][telefono]" 
                    placeholder="Telefono" required="" />
                    <div class="invalid-feedback">Ingresa su número de teléfono</div>
                    </div>
                    <div class="mb-3">
                    <label for="correoi` +
        i +
        `">Correo institucional</label> 
                    <input type="email" class="form-control" id="correoi` +
        i +
        `" name="miembros[` +
        i +
        `][correo_institucional]" 
                    placeholder="Correo institucional" required="" />
                    <div class="invalid-feedback">Ingresa su correo institucional.</div>
                    </div>
                    </div>
                    </div>
                    </div>`
      );

      var telefono = document.querySelector(
        "input[name='miembros[" + i + "][telefono]']"
      );
      window.intlTelInput(telefono, {
        preventInvalidNumbers: true,
        autoPlaceholder: "polite",
        initialCountry: "MX",
        formatOnDisplay: true,
        separateDialCode: false,
        utilsScript: "../resources/intl-tel-input/build/js/utils.js",
        autoHideDialCode: false,
        nationalMode: false,
      });
    }

    c_miembros_global = total_miembros; // y damos valor a la variable global de la cantidad de miembros
  } else if (c_miembros_global > total_miembros) {
    for (var i = c_miembros_global; i > total_miembros; i--) {
      $("#miembro" + i).remove();
    }

    c_miembros_global = total_miembros; // y damos valor a la variable global de la cantidad de miembros
  }
}

// ===================== FIN ========================




// ===================== FUNCIONES SELECTS ========================

var anterior_id = "";

var c_miembros_global = "";

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

  $("label[for=" + id + "]").css("border-color", "#ffaa01");

  anterior_id = id;
});

$("#mismaDireccion").change(function () {
  if (this.checked) {
    $("#divEnviosDocumentos").show("slow");

    direccionUniversidad = $("#direccionUniversidad").val();

    $("#direccionEnvio").val(direccionUniversidad).prop("readonly", true);

    $("#formularioDocumentos").hide();
  } else {
    $("#formularioDocumentos").show("slow");

    $("#direccionEnvio").val("").prop("readonly", false);

    $("#divEnviosDocumentos").hide();
  }
});

$("#cbx_pais").on("change", function () {
  pais = $("#cbx_pais").val();

  $("#cbx_municipio")
    .find("option")

    .remove()

    .end()

    .append('<option value=""></option>')

    .val("");

  if (pais == 1) {
    $("#divotropais").show("slow");

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
    $("#divotroestado").show("slow");

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
    $("#divotromunicipio").show("slow");

    $("#otromunicipio").prop("required", true).prop("disabled", false);
  } else {
    $("#divotromunicipio").hide();

    $("#otromunicipio").prop("required", false).prop("disabled", true);
  }
});

$("input[name='prodep']").on("change", function () {
  prodep = this.value;

  if (prodep == "si") {
    $("#prodep").show("slow");

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
  $("#cantidad_miembros").show("slow");

  $("#datos_universidad").hide();
});

// ===================== FIN  ========================


// ===================== VALIDACIONES DE CAMPOS ========================


const inputSelectorsLetrasAcentosyPunto = "#nombreRector, #nombreProdep, #nombre1, #nombre2, #nombre3, #nombre4, #appat1, #appat2, #appat3, #appat4, #apmat1, #apmat2, #apmat3, #apmat4, #otraNacionalidad1, #otraNacionalidad2, #otraNacionalidad3, #otraNacionalidad4, #especialidad1, #especialidad2, #especialidad3, #especialidad4";

$(inputSelectorsLetrasAcentosyPunto).on("keypress", LetrasAcentosyPunto);

function LetrasAcentosyPunto(event){

  key = event.keyCode || event.which;

  tecla = String.fromCharCode(key).toLowerCase();

  letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.";

  especiales = "8-37-39-46";

  const tecla_especial = especiales.includes(key);

  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
    event.preventDefault();
  }
}

const inputSelectorsLetrasAcentosNumerosPuntoyComa = "#nombreUniversidad, #direccionUniversidad, #direccionEnvio, #noInt,#noExt,#noInt2,#noExt2";

$(inputSelectorsLetrasAcentosNumerosPuntoyComa).on("keypress", LetrasAcentosNumerosPuntoyComa);

function LetrasAcentosNumerosPuntoyComa(event){
    key = event.keyCode || event.which;

    tecla = String.fromCharCode(key).toLowerCase();

    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz1234567890.,";

    especiales = "8-37-39-46";

    const tecla_especial = especiales.includes(key);

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      event.preventDefault();
    }
}

const inputSelectorsSoloNumeros = "#telefonoUniversidad, #extensionUniversidad, #anoProdep, #telefono1, #telefono2, #telefono3, #telefono4, #anioSNI1, #anioSNI2, #anioSNI3, #anioSNI4";

$(inputSelectorsSoloNumeros).on("keypress", SoloNumeros);

function SoloNumeros(event){
  key = event.keyCode || event.which;

  tecla = String.fromCharCode(key).toLowerCase();

  letras = "1234567890";

  especiales = "8-37-39-46";

  const tecla_especial = especiales.includes(key);

  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
    event.preventDefault();
  }
}

// ===================== FIN ========================




// ===================== FUNCIONES PARA DIRECCIONES ========================

const valoresPreguntas = {
  0: "",
  1: '',
  2: "No.Int",
  3: "No. Ext",
  4: "Colonia",
  5: "Localidad",
  6: "Municipio",
  7: "Estado",
  8: "CP",
  9: "Referencias del domicilio",
};


/* //DIRECCION DE LA UNIVERSIDAD

const parent = document.getElementById("direcciones_universidad_form");

const children = parent.querySelectorAll("input:not([type='checkbox'])");

// Nombres de los elementos que deseas eliminar
const nombresAEliminar = ["check_noInt", "check_noExt","check_localidad"];

children.forEach((element,index) => {
  if (nombresAEliminar.includes(element.id)) {
    children.splice(index, 1);
  }
});

children.forEach((element) => {
  let id = element.id;
  let val = $("#" + id).val();

  element.addEventListener("keyup", (e) => {
    let id_input = e.target.id;
    let value = $("#" + id_input).val();

    const arreglo = valoresUni();

    //console.log(children.length, arreglo.length);

    if (children.length !== arreglo.length) {
      document.getElementById("direccionUniversidad").value = "";
      $("#divUniversidadAdscripcion").hide("slow");
      return;
    }

    let direccionFormato = "";

    arreglo.forEach((element, index) => {
      if(index == 0){
        direccionFormato += element + ' ' + arreglo[1] + ',';
      }else if(index == 1){

      }else{
        direccionFormato += valoresPreguntas[index] + " " + element + ", ";
      }

    });

    direccionFormato = direccionFormato.slice(0, direccionFormato.length - 2);

    direccionFormato = direccionFormato + ".";

    document.getElementById("direccionUniversidad").value = direccionFormato;
    document.getElementById("direccionUniversidad").readOnly = true;
    $("#divUniversidadAdscripcion").show("slow");
  });
});

function valoresUni() {
  const arreglo = [];
  children.forEach((element) => {
    let val = element.value;
    if (val !== "") {
      arreglo.push(val);
    }
  });

  return arreglo;
} */

//DIRECCION DE PAQUETERIA

const parentPaqueteria = document.getElementById("formularioDocumentos");

const childrenPaqueteria = parentPaqueteria.querySelectorAll("input:not([type='checkbox'])");

childrenPaqueteria.forEach((element) => {
  let id = element.id;
  let val = $("#" + id).val();
  
  element.addEventListener("keyup", (e) => {
    let id_input = e.target.id;
    let value = $("#" + id_input).val();
    $("#" + id_input).css('border-color','#28a745')

    const arreglo = valoresPaq();

    if (childrenPaqueteria.length !== arreglo.length) {
      document.getElementById("direccionEnvio").value = "";
      $("#divEnviosDocumentos").hide("slow");
      return;
    }

    let direccionFormato = "";

    arreglo.forEach((element, index) => {

      if(index == 0){
        direccionFormato += element + ' ' + arreglo[1] + ',';
      }else if(index == 1){

      }else{
        direccionFormato += valoresPreguntas[index] + " " + element + ", ";
      }

    });

    direccionFormato = direccionFormato.slice(0, direccionFormato.length - 2);

    direccionFormato = direccionFormato + ".";

    document.getElementById("direccionEnvio").value = direccionFormato;
    document.getElementById("direccionEnvio").readOnly = true;
    $("#divEnviosDocumentos").show("slow");
  });
});

$("#tipo_vialidad_select2").on('change', function(){
  if( $("#tipo_vialidad_select2 option:selected") != '' ){
    $('#tipo_vialidad_select2').css('border-color', '#28a745')
  }
})


function valoresPaq() {
  const arreglo = [];

  childrenPaqueteria.forEach((element) => {
    let val = element.value;
    if (val !== "") {
      arreglo.push(val);
    }
  });

  return arreglo;
}

function EditMailBorrarDatos(id){

  var elementosDentroDeDiv = $("#datos_miembro_"+id).find("input, select");
  // Recorre los elementos y establece sus valores en una cadena vacía
  elementosDentroDeDiv.each(function() {
    if ($(this).is('select')) { // Verifica si el elemento es un select
      if ($(this).hasClass('avoid-clicks')) { // Verifica si tiene una clase específica
        $(this).removeClass('avoid-clicks'); // Remueve la clase
      }
    }

    if (!$(this).is('input[type="radio"]')) {
      $(this).val('').prop('readonly', false);
    }

  });

  $('input:radio[name="miembros[' + id + '][SNI]"]:checked').prop('checked', false);

  $("#datosSNI"+id).hide()
  //$(document).find('input[name="miembros['+id+'][SNI]"]:checked').removeAttr('checked')

  if($("#siSNI"+id).hasClass('avoid-clicks-radio')){
    $("#siSNI"+id).removeClass('avoid-clicks-radio')
  }

  if($("#noSNI"+id).hasClass('avoid-clicks-radio')){
    $("#noSNI"+id).removeClass('avoid-clicks-radio')
  }

  if( $("#labelHombre"+id).hasClass('avoid-clicks') ){
    $("#labelHombre"+id).removeClass('avoid-clicks')
  }

  if( $("#labelMujer"+id).hasClass('avoid-clicks') ){
    $("#labelMujer"+id).removeClass('avoid-clicks')
  }

  $("#datos_miembro_"+id).hide()

  $("#correop"+id).prop('readonly',false);
  $("#editMail_"+id).prop('disabled',true);

  
}

let keyupEvent = new Event('keyup', {
  bubbles: true,
  cancelable: true,
});

function check_sn(e) {
  let id = e.target.dataset.val;
  let checkbox = $("#check_" + id)[0].checked;

  if (checkbox) {
    $("#"+id).val('S/N').prop('readonly',true);
  } else {
    $("#"+id).val('').prop('readonly',false);
  }
  document.getElementById(id).dispatchEvent(keyupEvent);
}

function check_na(e) {
  let id = e.target.dataset.val;
  let checkbox = $("#check_" + id)[0].checked;

  if (checkbox) {
    $("#"+id).val('NA').prop('readonly',true);
  } else {
    $("#"+id).val('').prop('readonly',false);
  }
  document.getElementById(id).dispatchEvent(keyupEvent);
}

$("#tipo_vialidad_select, #tipo_vialidad_select2").on('change',function(e){
  let id = $(this)[0].id;
  let val = $(this).val()

  let id_input;
  switch (id) {
    case 'tipo_vialidad_select':
      id_input = 'tipo_vialidad'
      break;
    case 'tipo_vialidad_select2':
      id_input = 'tipo_vialidad2'
      break;
    default:
      break;
  }

  $("#"+id_input).val(val)

  // Despachar (disparar) el evento keyup en #tipo_vialidad
  document.getElementById(id_input).dispatchEvent(keyupEvent);

})

$("input[name=tipo_uni]").on('change',function(){
  let val = $(this).val()

  if(val == 'si'){
    let val_uni = $("#nombreUniversidad").val()
    $("#inst_est").val(val_uni).prop('readonly',true)
  }else{
    $("#inst_est").val('').prop('readonly',false)
  }

})

// ===================== FIN ========================