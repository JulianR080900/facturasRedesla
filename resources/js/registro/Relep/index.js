// ===================== Primera Seccion ========================

$(document).ready(function () {

  $('#loader').hide();
  
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

  $("#fac_estudio").hide();

  $("#telefonoUniversidad").attr("pattern", "[0-9]{8,15}");

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

$("input[name='tipo_registro']").on("change", function () {
  tipo_registro = this.value;

  const today = new Date();
  let year = today.getFullYear();

  if (tipo_registro == "investigación") {
    //MOSTRAMOS TODO

    Swal.fire({
      title:
        '<p>Está a punto de comenzar su registro como: </p> <p style="color:#189B4F">' +
        tipo_registro.toUpperCase() +
        "</p>",

      imageUrl:
        base_url +
        `/resources/img/registros_redes/Relep/${year}/investigacion.jpg`,

      imageWidth: 400,

      imageHeight: 300,

      imageAlt: "Información de investigación " + year,

      confirmButtonText: "Continuar",
    });

    $("#informacion_general").show("slow"); //info general

    $("#direcciones_universidad").show("slow"); //direcciones

    $("#prodep_universidad").show("slow"); //prodep

    $("#numeros_universidad").show("slow"); //numeros de la universidad

    $("#cbx_municipio").prop("required", true); //requerimos el municipio

    $("#div_municipio").show("slow"); //mostramos el div del municipio

    $("#direccionUniversidad").prop("required", true);

    $("#direccionEnvio").prop("required", true);

    $("#inst_universidad").show("slow");

    $("#inst_est").prop("required", true);

    $("#divUniversidadAdscripcion").hide();

    $("#divEnviosDocumentos").hide();

    $("#facultades_estudio").show();

    $("#aplicacion_estudio").prop("required", true);

    $("#estudio_mismo").show();

    $("input[name='tipo_uni']").prop("required", true);

    $("#preAsistencia").hide()
    
    $("#preAsistenciaID").val('').prop('required', false);

    $("#checkNAUni").remove();

  } else if (tipo_registro == "oyente") {
    //OCULTAMOS DIRECCIONES, PRODEP Y MUNICIPIO

    $("#informacion_general").show("slow");

    $("#direcciones_universidad").hide(); //ocultamos las direcciones y municipio

    $("#prodep_universidad").show("slow");

    $("#numeros_universidad").show("slow");

    $("#cbx_municipio").prop("required", false);

    $("#direccionUniversidad").prop("required", false);

    $("#direccionEnvio").prop("required", false);

    $("#div_municipio").hide();

    document.getElementById("otromunicipio").value = "NA";

    $("#inst_universidad").hide();

    $("#inst_est").prop("required", false);

    $("#facultades_estudio").hide();

    $("#aplicacion_estudio").prop("required", false);

    $("#estudio_mismo").hide();

    $("input[name='tipo_uni']").prop("required", false);

    //PRODEP le vamos a quitar el required

    $("#prodep_universidad").hide();

    checkNAUni()

    Swal.fire({
      title:
        '<p>Está a punto de comenzar su registro como: </p> <p style="color:#189B4F">' +
        tipo_registro.toUpperCase() +
        "</p>",

      imageUrl:
        base_url + `/resources/img/registros_redes/Relep/${year}/oyente.jpg`,

      imageWidth: 400,

      imageHeight: 300,

      imageAlt: "Información de oyente " + year,

      confirmButtonText: "Continuar",
    });
  } else if (tipo_registro == "congreso") {
    //OCULTAMOS MUNICIPIO

    $("#informacion_general").show("slow");

    $("#direcciones_universidad").show("slow");

    $("#prodep_universidad").show("slow");

    $("#numeros_universidad").show("slow");

    $("#direccionUniversidad").prop("required", true);

    $("#direccionEnvio").prop("required", true);

    $("#cbx_municipio").prop("required", false);

    $("#div_municipio").hide();

    $("#inst_universidad").hide();

    $("#inst_est").prop("required", false);

    $("#facultades_estudio").hide();

    $("#aplicacion_estudio").prop("required", false);

    $("#estudio_mismo").hide();

    $("input[name='tipo_uni']").prop("required", false);

    $("#divUniversidadAdscripcion").hide();

    $("#divEnviosDocumentos").hide();

    $("#preAsistencia").show('slow')

    $("#preAsistenciaID").prop('required',true);

    checkNAUni()

    Swal.fire({
      title:
        '<p>Está a punto de comenzar su registro como: </p> <p style="color:#189B4F">' +
        tipo_registro.toUpperCase() +
        "</p>",

      imageUrl:
        base_url + `/resources/img/registros_redes/Relep/${year}/congreso.jpg`,

      imageWidth: 400,

      imageHeight: 300,

      imageAlt: "Información de congreso " + year,

      confirmButtonText: "Continuar",
    });
  } else if (tipo_registro == "coloquio") {
    $("#informacion_general").show("slow");

    $("#direcciones_universidad").show("slow");

    $("#prodep_universidad").show("slow");

    $("#numeros_universidad").show("slow");

    $("#direccionUniversidad").prop("required", true);

    $("#direccionEnvio").prop("required", true);

    $("#cbx_municipio").prop("required", false);

    $("#div_municipio").hide();

    $("#inst_universidad").hide();

    $("#inst_est").prop("required", false);

    $("#facultades_estudio").hide();

    $("#aplicacion_estudio").prop("required", false);

    $("#estudio_mismo").hide();

    $("input[name='tipo_uni']").prop("required", false);

    $("#preAsistencia").show('slow')

    $("#preAsistenciaID").prop('required',true);

    checkNAUni()

    Swal.fire({
      title:
        '<p>Está a punto de comenzar su registro como: </p> <p style="color:#189B4F">' +
        tipo_registro.toUpperCase() +
        "</p>",

      imageUrl:
        base_url + `/resources/img/registros_redes/Relep/${year}/coloquio.jpg`,

      imageWidth: 400,

      imageHeight: 300,

      imageAlt: "Información de coloquio " + year,

      confirmButtonText: "Continuar",
    });
  }
});

function checkNAUni(){
  $("#checkNAUni").remove();

    $("#divNombreUni").append(`
    <div class="form-check" id='checkNAUni'>
      <input class="form-check-input" type="checkbox" id="check_nombreUniversidad" data-val='nombreUniversidad' onchange="check_na(event);">
        <label class="form-check-label" for="check_nombreUniversidad">
          No pertenezco a una universidad / institución.
        </label>
    </div>
    `);
}