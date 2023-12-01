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

  $("#especialidad").hide();

  $("#divUniversidadAdscripcion").hide(); //NUEVO

  $("#divEnviosDocumentos").hide(); //NUEVO

  $("#telefonoUniversidad").attr("pattern", "[0-9]{8,15}");

  //$("#inst_universidad").hide();

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
    $("#informacion_general").show("slow");

    $("#direcciones_universidad").show("slow");

    $("#prodep_universidad").show("slow");

    $("#numeros_universidad").show("slow");

    $("#cbx_municipio").prop("required", true);

    $("#div_municipio").show("slow");

    $("#direccionUniversidad").prop("required", true);

    $("#direccionEnvio").prop("required", true);

    $("#especialidad").show("slow")
    
    $("select[name=especialidad]").prop("required", true);

    $("#preAsistencia").hide()
    
    $("#preAsistenciaID").val('').prop('required', false);

    $("#checkNAUni").remove();

    //$("#inst_est").prop('required',true);

    //$("#inst_universidad").show('slow');

    Swal.fire({
      title:
        '<p>Está a punto de comenzar su registro como: </p> <p style="color:#a91f24">' +
        tipo_registro.toUpperCase() +
        "</p>",

      imageUrl:
        base_url +
        `/resources/img/registros_redes/Relen/${year}/investigacion.jpg`,

      imageWidth: 400,

      imageHeight: 300,

      imageAlt: "Información de investigación " + year,

      confirmButtonText: "Continuar",
    });
  } else if (tipo_registro == "oyente") {
    $("#informacion_general").show("slow");

    $("#direcciones_universidad").hide(); //ocultamos las direcciones y municipio

    $("#prodep_universidad").show("slow");

    $("#numeros_universidad").show("slow");

    $("#cbx_municipio").prop("required", false);

    $("#direccionUniversidad").prop("required", false);

    $("#direccionEnvio").prop("required", false);

    $("#div_municipio").hide();

    document.getElementById("otromunicipio").value = "NA";

    $("#especialidad").hide()

    $("select[name=especialidad]").prop("required", false);

    //$("#inst_est").prop('required',false);

    //$("#inst_universidad").hide();

    $("#prodep_universidad").hide();

    $("#preAsistencia").show('slow')

    $("#preAsistenciaID").prop('required',true);

    checkNAUni()

    Swal.fire({
      title:
        '<p>Está a punto de comenzar su registro como: </p> <p style="color:#a91f24">' +
        tipo_registro.toUpperCase() +
        "</p>",

      imageUrl:
        base_url + `/resources/img/registros_redes/Relen/${year}/oyente.jpg`,

      imageWidth: 400,

      imageHeight: 300,

      imageAlt: "Información de oyente " + year,

      confirmButtonText: "Continuar",
    });
  } else if (tipo_registro == "congreso") {
    $("#informacion_general").show("slow");

    $("#direcciones_universidad").show("slow");

    $("#prodep_universidad").show("slow");

    $("#numeros_universidad").show("slow");

    $("#cbx_municipio").prop("required", false);

    $("#div_municipio").hide();

    $("#direccionUniversidad").prop("required", true);

    $("#direccionEnvio").prop("required", true);

    $("#especialidad").hide()

    $("select[name=especialidad]").prop("required", false);

    $("#divUniversidadAdscripcion").hide();

    $("#divEnviosDocumentos").hide();

    $("#preAsistencia").show('slow')

    $("#preAsistenciaID").prop('required',true);

    checkNAUni()

    //$("#inst_est").prop('required',false);

    //$("#inst_universidad").hide();

    Swal.fire({
      title:
        '<p>Está a punto de comenzar su registro como: </p> <p style="color:#a91f24">' +
        tipo_registro.toUpperCase() +
        "</p>",

      imageUrl:
        base_url + `/resources/img/registros_redes/Relen/${year}/congreso.jpg`,

      imageWidth: 400,

      imageHeight: 300,

      imageAlt: "Información de congreso " + year,

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