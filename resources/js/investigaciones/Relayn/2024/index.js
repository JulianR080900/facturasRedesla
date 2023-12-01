$(document).ready(function () {
  
    var allElems = document.getElementsByTagName("input");
    for (i = 0; i < allElems.length; i++) {
      if (allElems[i].type == "radio" && allElems[i].value == "1") {
        allElems[i].checked = true;
      }
    }

    dataSendFunction()
   
  $("#descripcion_mype").attr("minlenght", 15);

  var current_fs, next_fs, previous_fs; //fieldsets
  var opacity;

  $(".next").click(function () {
    var check = $("#checkAviso").is(":checked");

    if (!check) {
      swal.fire({
        icon: "warning",
        title:
          "Para continuar con la captura debe aceptar el aviso de privacidad.",
      });
      return;
    }

    let medio = $("input[name='medio_captura']:checked").val();

    if (medio === undefined) {
      swal.fire({
        icon: "warning",
        title: "Seleccione el medio por el cuál realizó la encuesta.",
      });
      return;
    }

    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate(
      {
        opacity: 0,
      },
      {
        step: function (now) {
          window.scrollTo(0, 0);
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            display: "none",
            position: "relative",
          });
          next_fs.css({
            opacity: opacity,
          });
        },
        duration: 600,
      }
    );
  });

  $(".previous").click(function () {
    var check = $("#checkAviso").is(":checked");

    if (!check) {
      swal.fire({
        icon: "warning",
        title: "No puede continuar si no acepta el aviso de privacidad.",
      });
      return;
    }

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //Remove class active
    $("#progressbar li")
      .eq($("fieldset").index(current_fs))
      .removeClass("active");

    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate(
      {
        opacity: 0,
      },
      {
        step: function (now) {
          window.scrollTo(0, 0);
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            display: "none",
            position: "relative",
          });
          previous_fs.css({
            opacity: opacity,
          });
        },
        duration: 100,
      }
    );
  });

  $(".invalid_inputs").hide();

  const elementosOcultar = [
    "#medios",
    "#curpdni",
    "#rfcnit",
    "#solo1producto",
    "#valid_edad",
    "#valid_dias",
    "#valid_cp",
    "#valid_rfc",
    "#valid_nit",
    "#totales_coinciden",
    "#ingresos",
    "#egresos",
    "#total4",
    "#otro_piso",
    "#valid_inicio_operaciones",
    "#selectLugar",
    "#otra_ubi"
  ];
  
  for (const elemento of elementosOcultar) {
    $(elemento).hide();
  }
  
/* 
POSIBLE ELIMINACION
$("#producto1").prop("disabled", true);
  $("#producto2").prop("disabled", true);
  $("#producto3").prop("disabled", true); */

  if ($(".selectScian").length) {
    $(".selectScian").select2();
  }

  $("#selectProductos").select2({
    ajax: {
      url: "../../getProductos",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          str: params.term, // search term
          page: params.page,
        };
      },
      processResults: function (data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;
        return {
          results: data.items,
          pagination: {
            more: params.page * 30 < data.total_count,
          },
        };
      },
      cache: true,
    },
    placeholder: "Escriba el nombre del producto.",
    language: "es",
    minimumInputLength: 3,
    language: {
      noResults: function () {
        return "No hay resultados.";
      },
      searching: function () {
        return "Buscando...";
      },
      inputTooShort: function () {
        return "Ingrese 3 o más caracteres.";
      },
    },
    maximumSelectionLength: 3,
    templateResult: formatRepo,
    templateSelection: formatRepoSelection,
  });

  /*
  posible eliminacion
    $("#selectProductos").on("select2:close", function (e) {
      let obj = $("#selectProductos").find(":selected").length;
      if (obj == 1) {
        $("#solo1producto").show();
      } else {
        $("#solo1producto").hide();
      }
    });
    */

  function formatRepo(repo) {
    if (repo.loading) {
      return repo.text;
    }

    var $container = $(
      "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'></div>" +
        "</div>" +
        "</div>" +
        "</div>"
    );

    $container.find(".select2-result-repository__title").text(repo.nombre);

    return $container;
  }

  function formatRepoSelection(repo) {
    return repo.nombre || repo.text;
  }
  
});

/*
  $(".radio-group .radio").click(function () {
    $(this).parent().find(".radio").removeClass("selected");
    $(this).addClass("selected");
  });
  */

$("#checkAviso").change(function () {
  var check = $("#checkAviso").is(":checked");

  if (!check) {
    $("#medios").hide();
  } else {
    $("#medios").show();
  }
});

(function () {
  "use strict";
  window.addEventListener(
    "load",
    function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName("needs-validation");
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            let txtProductos = $("#total4").text();

            if (txtProductos != "") {
              swal
                .fire({
                  title: "Corrija el nivel de estudios de sus trabajadores.",
                  icon: "warning",
                })
                .then(function () {
                  $("fieldset").css({
                    display: "none",
                    position: "relative",
                  });

                  $("#field1").css({
                    opacity: 1,
                    display: "block",
                  });
                  $("#4a1").focus();
                });

              event.preventDefault();
              event.stopPropagation();
              return;
            }

            var total1 = $("#total1").val();
            var total2 = $("#total2").val();

            if (total1 == "" || total2 == "") {
              swal
                .fire({
                  title:
                    "La suma de hombres-mujeres y familiares-no familiares debe ser completada.",
                  icon: "warning",
                })
                .then(function () {
                  $("fieldset").css({
                    display: "none",
                    position: "relative",
                  });

                  $("#field1").css({
                    opacity: 1,
                    display: "block",
                  });
                  $("#mujeres").focus();
                });

              event.preventDefault();
              event.stopPropagation();
              return;
            }

            if (total1 != total2) {
              swal
                .fire({
                  title:
                    "La suma de hombres-mujeres y familiares-no familiares no coincide.",
                  icon: "warning",
                })
                .then(function () {
                  $("fieldset").css({
                    display: "none",
                    position: "relative",
                  });

                  $("#field1").css({
                    opacity: 1,
                    display: "block",
                  });
                  $("#mujeres").focus();
                });

              event.preventDefault();
              event.stopPropagation();
              return;
            }

            let radio_val = $("input[name='tamanio_empresa']:checked").val();

            if (radio_val === undefined) {
              swal
                .fire({
                  title: "Seleccione el tamaño de su empresa.",
                  icon: "warning",
                })
                .then(function () {
                  $("fieldset").css({
                    display: "none",
                    position: "relative",
                  });

                  $("#field1").css({
                    opacity: 1,
                    display: "block",
                  });
                  $("#tamanio_empresa").focus();
                });

              event.preventDefault();
              event.stopPropagation();
              return;
            }

            let total = $("#total1").val();
            total = total == "" ? 0 : total;
            let c_min = 0;
            let c_max = 0;
            if (radio_val == "micro_todas") {
              c_min = 1;
              c_max = 10;
            } else if (radio_val == "pequenia_comercio") {
              c_min = 11;
              c_max = 30;
            } else if (radio_val == "pequenia_industria_servicios") {
              c_min = 11;
              c_max = 50;
            }

            if (total < c_min || total > c_max) {
              swal
                .fire({
                  title:
                    "La cantidad de trabajadores no coincide con el tamaño de la empresa.",
                  icon: "warning",
                })
                .then(function () {
                  $("fieldset").css({
                    display: "none",
                    position: "relative",
                  });

                  $("#field1").css({
                    opacity: 1,
                    display: "block",
                  });
                  $("#tamanio_empresa").focus();
                });

              event.preventDefault();
              event.stopPropagation();
              return;
              //return;
            }

            var productos = $("#selectProductos :selected").length;

            if (productos == 0) {
              swal
                .fire({
                  title:
                    "Seleccione al menos 1 producto que su negocio ofrece.",
                  icon: "warning",
                })
                .then(function () {
                  $("fieldset").css({
                    display: "none",
                    position: "relative",
                  });

                  $("#field1").css({
                    opacity: 1,
                    display: "block",
                  });
                  $("#selectProductos").focus();
                });

              event.preventDefault();
              event.stopPropagation();
              return;
            }

            if (form.checkValidity() === false) {
              $("button[type='submit']").prop("disabled", true);

              swal
                .fire({
                  title:
                    "Asegúrese que TODAS las preguntas tengan una respuesta seleccionada sobre todo en los apartados 3, 4 y 5. Recuerde que CADA PREGUNTA debe tener una respuesta VÁLIDA para poder FINALIZAR.",
                  icon: "warning",
                })
                .then(function () {
                  $("button[type='submit']").prop("disabled", false);
                  let invalids = document.querySelectorAll(
                    "input.form-control:invalid"
                  );
                  let invalidSelects = document.querySelectorAll(
                    "select.form-control:invalid"
                  );

                  let id_parentNode = "";
                  let id_first_invalid = "";

                  if (invalids.length === 0) {
                    if (invalidSelects.length === 0) {
                      //Entonces es en los radios
                      id_parentNode = "field3";
                    } else {
                      id_first_invalid = invalidSelects[0].id;
                      let parentNode = $("#" + id_first_invalid)
                        .parent()
                        .parent();
                      id_parentNode = parentNode[0].id;
                    }
                  } else {
                    id_first_invalid = invalids[0].id;
                    let parentNode = $("#" + id_first_invalid)
                      .parent()
                      .parent();
                    id_parentNode = parentNode[0].id;
                  }

                  let existe = id_parentNode.indexOf("field");

                  if (existe == -1) {
                    id_parentNode = "field1";
                  }

                  $("fieldset").css({
                    display: "none",
                    position: "relative",
                  });

                  $("#" + id_parentNode).css({
                    opacity: 1,
                    display: "block",
                  });

                  window.scrollTo(0, 0);

                  $("#progressbar li>ul").removeClass("active");

                  $("#" + id_first_invalid).focus();
                  $("button[type='submit']").prop("disabled", false);
                });

              event.preventDefault();
              event.stopPropagation();
            }

            //dataSendFunction();

            form.classList.add("was-validated");
            return;
          },
          false
        );
      });
    },
    false
  );
})();

$("input[type='number']").on("keypress", function (event) {
  /*Solamente numeros*/
  key = event.keyCode || event.which;

  tecla = String.fromCharCode(key).toLowerCase();

  letras = "1234567890na";

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

$("#1h, #1g").on("keyup", function (event) {
  let txt = $(this).val();
  txt = txt.toUpperCase();
  $(this).val(txt);
});

function changeDenue() {
  var val = $("input[name='empresa']").val();
  $("input[name='1r']").val(val);
}

$("#mujeres, #hombres").on("keyup", function () {
  var a3 = $("#mujeres").val();
  a3 = a3 == "" ? 0 : a3;
  var b3 = $("#hombres").val();
  b3 = b3 == "" ? 0 : b3;
  $("#7d option:eq(0)").prop("selected", true);
  var suma3 = parseInt(a3) + parseInt(b3);
  $("#total1").val(suma3);
  let radio_val = $("input[name='tamanio_empresa']:checked").val();

  let c_min = 0;
  let c_max = 0;
  if (radio_val == "micro_todas") {
    c_min = 1;
    c_max = 10;
  } else if (radio_val == "pequenia_comercio") {
    c_min = 11;
    c_max = 30;
  } else if (radio_val == "pequenia_industria_servicios") {
    c_min = 11;
    c_max = 50;
  } else {
    swal.fire({
      icon: "warning",
      title: "Seleccione el tamaño de su empresa",
    });
    $("#mujeres").val("");
    $("#hombres").val("");
    $("#total1").val("");
    $("#4total").val("");
    return;
  }

  if (suma3 > c_max) {
    swal.fire({
      icon: "warning",
      title:
        "La suma excede al rango de trabajadores del tamaño de su empresa. Favor de revisar.",
    });
    $("#mujeres").val("");
    $("#hombres").val("");
    $("#total1").val("");
    $("#4total").val("");
    return;
  }

  let m = $("#mujeres").val();
  let h = $("#hombres").val();

  if (m != "" && h != "") {
    if (suma3 == 0) {
      $("#mujeres").val("");
      $("#hombres").val("");
      $("#total1").val("");
      swal.fire({
        icon: "warning",
        title: "La suma de hombres y mujeres no debe ser igual a 0.",
      });
      return;
    } else {
      $("#total1").val(suma3);
    }
  } else {
    $("#4total").val("");
  }
});

$("#familiares, #no_familiares").on("keyup", function () {
  var a3 = $("#familiares").val();
  a3 = a3 == "" ? 0 : a3;
  var b3 = $("#no_familiares").val();
  b3 = b3 == "" ? 0 : b3;

  var suma4 = parseInt(a3) + parseInt(b3);
  $("#total2").val(suma4);
  let radio_val = $("input[name='tamanio_empresa']:checked").val();

  let c_min = 0;
  let c_max = 0;
  if (radio_val == "micro_todas") {
    c_min = 1;
    c_max = 10;
  } else if (radio_val == "pequenia_comercio") {
    c_min = 11;
    c_max = 30;
  } else if (radio_val == "pequenia_industria_servicios") {
    c_min = 11;
    c_max = 50;
  } else {
    swal.fire({
      icon: "warning",
      title: "Seleccione el tamaño de su empresa.",
    });
    $("#familiares").val("");
    $("#no_familiares").val("");
    $("#total2").val("");
    $("#4total").val("");
    return;
  }

  if (suma4 > c_max) {
    swal.fire({
      icon: "warning",
      title:
        "La suma excede al rango de trabajadores del tamaño de su empresa. Favor de revisar.",
    });
    $("#familiares").val("");
    $("#no_familiares").val("");
    $("#total2").val("");
    $("#4total").val("");
    return;
  }

  let f = $("#familiares").val();
  let nf = $("#no_familiares").val();

  if (f != "" && nf != "") {
    if (suma4 == 0) {
      $("#familiares").val("");
      $("#no_familiares").val("");
      swal.fire({
        icon: "warning",
        title: "La suma de familiares-no familiares no debe ser igual a 0.",
      });
      return;
    } else {
      $("#total2").val(suma4);
    }
  }
});

$("#mujeres, #hombres, #familiares, #no_familiares").on("keyup", function () {
  //VAMOS A DARLE VALOR A 4total
  let val1 = $("#mujeres").val();
  let val2 = $("#hombres").val();
  let val3 = $("#familiares").val();
  let val4 = $("#no_familiares").val();
  $("#totales_coinciden").hide();

  if (val1 != "" && val2 != "" && val3 != "" && val4 != "") {
    let suma1 = parseInt(val1) + parseInt(val2);
    let suma2 = parseInt(val3) + parseInt(val4);
    let radio_val = $("input[name='tamanio_empresa']:checked").val();
    let c_min = 0;
    let c_max = 0;
    if (radio_val == "micro_todas") {
      c_min = 1;
      c_max = 10;
    } else if (radio_val == "pequenia_comercio") {
      c_min = 11;
      c_max = 30;
    } else if (radio_val == "pequenia_industria_servicios") {
      c_min = 11;
      c_max = 50;
    }

    if (suma1 < c_min) {
      $("#4total").val("");
      $("#totales_coinciden")
        .show()
        .addClass("text-danger")
        .text(
          "La suma de hombres y mujeres no coíncide con el rango mínimo del número de trabajadores de su empresa"
        );
      return;
    }
    if (suma2 < c_min) {
      $("#4total").val("");
      $("#totales_coinciden")
        .show()
        .addClass("text-danger")
        .text(
          "La suma de familiares y no familiares no coíncide con el rango mínimo del número de trabajadores de su empresa"
        );
      return;
    }
    if (suma1 != suma2) {
      $("#4total").val("");
      $("#totales_coinciden")
        .show()
        .addClass("text-danger")
        .text(
          "Los totales de mujeres-hombres y familiares-no familiares no coinciden"
        );
      return;
    }
  }
});

$("#4a1,#4a2,#4b1,#4b2,#4c1,#4c2,#4d1,#4d2, #4aa1, #4aa2").on(
  "keyup",
  function () {
    let a14 = $("#4a1").val();
    a14 = a14 == "" ? 0 : a14;
    let b14 = $("#4b1").val();
    b14 = b14 == "" ? 0 : b14;
    let c14 = $("#4c1").val();
    c14 = c14 == "" ? 0 : c14;
    let d14 = $("#4d1").val();
    d14 = d14 == "" ? 0 : d14;
    let aa41 = $("#4aa1").val();
    aa41 = aa41 == "" ? 0 : aa41;

    let suma_mujeres =
      parseInt(a14) +
      parseInt(b14) +
      parseInt(c14) +
      parseInt(d14) +
      parseInt(aa41);

    let a24 = $("#4a2").val();
    a24 = a24 == "" ? 0 : a24;

    let b24 = $("#4b2").val();
    b24 = b24 == "" ? 0 : b24;

    let c24 = $("#4c2").val();
    c24 = c24 == "" ? 0 : c24;

    let d24 = $("#4d2").val();
    d24 = d24 == "" ? 0 : d24;

    let aa42 = $("#4aa2").val();
    aa42 = aa42 == "" ? 0 : aa42;

    let suma_hombres =
      parseInt(a24) +
      parseInt(b24) +
      parseInt(c24) +
      parseInt(d24) +
      parseInt(aa42);

    let sumaTotal = parseInt(suma_mujeres) + parseInt(suma_hombres);

    let totalhm = $("#total1").val();
    let totalfnm = $("#total2").val();

    if (totalhm == totalfnm) {
      if (sumaTotal != totalhm) {
        $("#total4")
          .show()
          .addClass("text-danger")
          .text(
            "La suma no coincide con el total de personal total del negocio."
          );
      } else {
        $("#total4").hide().removeClass("text-danger").text("");
      }
    }

    $("#4total").val(sumaTotal);
  }
);

$("input[name=radioRFC]").on("change", function () {
  var val = $(this).val();
  if (val == "NA") {
    $("#rfcnit").hide();
    $("#inputRFC").prop("required", false);
    $("#tipo_rfc").prop("required", false);
    $("#inputNIT").prop("required", false);
    $("#tipo_nit").prop("required", false);
  } else {
    $("#curpdni").hide();
    $("#rfcnit").show();
    if (pais == 2) {
      $("#inputRFC").prop("required", true);
      $("#tipo_rfc").prop("required", true);

      $("#inputNIT").prop("required", false);
      $("#tipo_nit").prop("required", false);
    } else {
      $("#inputNIT").prop("required", true);
      $("#tipo_nit").prop("required", true);

      $("#inputRFC").prop("required", false);
      $("#tipo_rfc").prop("required", false);
    }
    $("#inputCURP").prop("required", false);
    $("#inputDNI").prop("required", false);
  }
});

$("#rama1").on("change", function () {
  var val = $(this).val();
  $("#1r").val("");
  $.ajax({
    type: "POST",
    url: "../../getRama2",
    data: {
      nombre: val,
    },
    success: function (data) {
      $("#rama2").empty();
      $("#rama3").empty();
      $("#rama4").empty();
      $("#rama5").empty();
      $("#rama2").html(data);
    },
  });
});

$("#rama2").on("change", function () {
  var val = $(this).val();
  $("#1r").val("");
  $.ajax({
    type: "POST",
    url: "../../getRama3",
    data: {
      nombre: val,
    },
    success: function (data) {
      $("#rama3").empty();
      $("#rama4").empty();
      $("#rama5").empty();
      $("#rama3").html(data);
    },
  });
});

$("#rama3").on("change", function () {
  var val = $(this).val();
  $("#1r").val("");
  $.ajax({
    type: "POST",
    url: "../../getRama4",
    data: {
      nombre: val,
    },
    success: function (data) {
      $("#rama4").empty();
      $("#rama5").empty();
      $("#rama4").html(data);
    },
  });
});

$("#rama4").on("change", function () {
  var val = $(this).val();
  $("#1r").val("");
  $.ajax({
    type: "POST",
    url: "../../getRama5",
    data: {
      nombre: val,
    },
    success: function (data) {
      $("#rama5").empty();
      $("#rama5").html(data);
    },
  });
});

$("#rama5").on("change", function () {
  var val = $(this).val();
  $("#1r").val(val);
});

function check_na(e) {
  let id = e.target.defaultValue;
  let checkbox = $("#check_" + id)[0].checked;
  let pattern = "";
  if (id == "1n") {
    //Correo
    pattern = "[^@s]+@[^@s]+";
  } else if (id == "1m") {
    //facebook
    pattern =
      "^(https?://)?(www.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*.)+[w]{2,}(/S*)?$";
  } else if (id == "1o") {
    //website
    pattern =
      "^(https?://)?(www.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*.)+[w]{2,}(/S*)?$";
  } else if (id == "1p") {
    pattern = "(?<=^|(?<=[^a-zA-Z0-9-_.]))@([A-Za-z]+[A-Za-z0-9-_]+)";
  } else {
    pattern = "";
  }

  if (checkbox) {
    $('input[name="' + id + '"]')
      .prop("type", "text")
      .val("NA");
    $('input[name="' + id + '"]').text("NA");
    $('input[name="' + id + '"]').prop("readonly", true);
    if (pattern != "") {
      $('input[name="' + id + '"]')
        .prop("readonly", true)
        .removeAttr("pattern");
    }
  } else {
    $('input[name="' + id + '"]')
      .prop("type", "text")
      .val("");
    $('input[name="' + id + '"]').text("");
    $('input[name="' + id + '"]').prop("readonly", false);
    if (pattern != "") {
      $('input[name="' + id + '"]').attr("pattern", pattern);
    }
  }
}

$("#dudas").on("click", function () {
  Swal.fire({
    title:
      "Cuando ubique el negocio, copie la URL de Google Maps que se encuentra en la barra de búsqueda y por favor péguela en la pregunta 1m)",
    imageUrl: base_url + "/resources/gifs/Maps.gif",
    imageWidth: 780,
    imageHeight: 600,
    imageAlt: "Custom image",
    customClass: "swal-wide",
  });
});

$("#ejemplo_descripcion_ubicacion").on("click", function () {
  Swal.fire({
    title: "Descripción",
    text: "Remolque verde, colocado sobre ladrillos en la calle, a un costado de la clínica dental, frente al taller de tornos.",
    imageUrl:
      base_url +
      "/resources/img/investigaciones/ejemplos/descripcion_negocio.jpg",
    imageWidth: 780,
    imageHeight: 600,
    imageAlt: "Custom image",
    customClass: "swal-wide",
  });
});

$("#ejemplo_vialidad_1").on("click", function () {
  Swal.fire({
    imageUrl:
      base_url + "/resources/img/investigaciones/ejemplos/direccion_1.jpg",
    imageWidth: 780,
    imageHeight: 600,
    imageAlt: "Custom image",
    customClass: "swal-wide",
  });
});

$("#ejemplo_vialidad_2").on("click", function () {
  Swal.fire({
    imageUrl:
      base_url + "/resources/img/investigaciones/ejemplos/direccion_2.jpg",
    imageWidth: 780,
    imageHeight: 600,
    imageAlt: "Custom image",
    customClass: "swal-wide",
  });
});

/*
  $("#check_producto").on("change", function () {
    if (this.checked) {
      let producto = $("#selectProductos").select2("data");
      producto = producto[0].id;
      $("#selectProductos").prop("disabled", true);
      $("#producto1").prop("disabled", false).val(producto);
      $("#producto2").prop("disabled", false).val(producto);
      $("#producto3").prop("disabled", false).val(producto);
      //$("#selectProductos").val([producto,2,1005])
    } else {
      $("#producto1").prop("disabled", true).val("");
      $("#producto2").prop("disabled", true).val("");
      $("#producto3").prop("disabled", true).val("");
      $("#solo1producto").hide();
      $("#selectProductos").prop("disabled", false);
    }
  });
  */

function countPorcentaje(e) {
  let id = e.target.id;
  let value = $("#" + id).val();
  if (value > 100) {
    swal.fire({
      icon: "warning",
      title: "Ingrese un un porcentaje entre 0 y 100.",
    });
    value = value.substring(0, value.length - 1);
    $("#" + id).val(value);
  }
}

$("#6d,#6e,#6f").on("keyup", function () {
  var d6 = $("#6d").val();
  d6 = d6 == "" ? 0 : d6;
  var e6 = $("#6e").val();
  e6 = e6 == "" ? 0 : e6;
  var f6 = $("#6f").val();
  f6 = f6 == "" ? 0 : f6;

  var suma = parseInt(d6) + parseInt(e6) + parseInt(f6);

  if (suma > 100) {
    swal.fire({
      icon: "warning",
      title: "La suma de sus ingresos es mayor a 100%. Inicie de nuevo.",
    });
    $("#6d").val("");
    $("#6e").val("");
    $("#6f").val("");
    $("#6g").val("");
    return;
  } else if (suma != 100) {
    $("#ingresos")
      .show()
      .addClass("text-danger")
      .text("La suma de sus ingresos no es 100%");
  } else if (suma == 100) {
    $("#ingresos").hide().removeClass("text-danger").text("");
  }
  $("#6g").val(suma);
});

$("#6h,#6i,#6j,#6k,#6l,#6m,#6n,#6o").on("keyup", function () {
  var h6 = $("#6h").val();
  h6 = h6 == "" ? 0 : h6;
  var i6 = $("#6i").val();
  i6 = i6 == "" ? 0 : i6;
  var j6 = $("#6j").val();
  j6 = j6 == "" ? 0 : j6;
  var k6 = $("#6k").val();
  k6 = k6 == "" ? 0 : k6;
  var l6 = $("#6l").val();
  l6 = l6 == "" ? 0 : l6;
  var m6 = $("#6m").val();
  m6 = m6 == "" ? 0 : m6;
  var n6 = $("#6n").val();
  n6 = n6 == "" ? 0 : n6;
  var o6 = $("#6o").val();
  o6 = o6 == "" ? 0 : o6;

  var suma =
    parseInt(h6) +
    parseInt(i6) +
    parseInt(j6) +
    parseInt(k6) +
    parseInt(l6) +
    parseInt(m6) +
    parseInt(n6) +
    parseInt(o6);

  if (suma > 100) {
    swal.fire({
      icon: "warning",
      title: "La suma de sus egresos es mayor a 100%. Inicie de nuevo.",
    });
    $("#6h").val("");
    $("#6i").val("");
    $("#6j").val("");
    $("#6k").val("");
    $("#6l").val("");
    $("#6m").val("");
    $("#6n").val("");
    $("#6o").val("");
    $("#6p").val("");
    return;
  } else if (suma != 100) {
    $("#egresos")
      .show()
      .addClass("text-danger")
      .text("La suma de sus egresos no es 100%");
  } else if (suma == 100) {
    $("#egresos").hide().removeClass("text-danger").text("");
  }

  $("#6p").val(suma);
});

$("#nombre_encuestador,#1c,#1f,#1i").on("keypress", function (event) {
  /*Nombres con acentos*/

  key = event.keyCode || event.which;

  tecla = String.fromCharCode(key).toLowerCase();

  letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";

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

$("input,#descripcion_mype").on("keydown", function (e) {
  let txt = $(this).val();
  if (e.which == 32) {
    if (txt.length == 0) {
      if (txt == "") {
        e.preventDefault();
      }
    }
  }
});

$("#inputRFC").on("keyup", function (e) {
  let txt = $(this).val();
  txt = txt.toUpperCase();
  $(this).val(txt);
});

$("#inputNIT").on("keyup", function (e) {
  let txt = $(this).val();
  txt = txt.toUpperCase();
  $(this).val(txt);
});

$(
  "#inputRFC, #inputNIT, #1h, #1g, #nombre_conglomerado, #nombre_vialidad_1, #nombre_vialidad_2, #nombre_vialidad_posterior, #nombre_ubicacion_empresa,#otro_piso_input, #descripcion_mype"
).on("keypress", function (event) {
  /*Nombres con acentos*/

  key = event.keyCode || event.which;

  tecla = String.fromCharCode(key).toLowerCase();

  letras = " abcdefghijklmnopqrstuvwxyz0123456789";

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

$("#correo_encuestador,#input_1p,#1n").on("keypress", function (e) {
  let txt = $(this).val();
  let cantidad = 0;
  var start = 0;
  while ((start = txt.indexOf("@", start) + 1) > 0) {
    cantidad++;
  }
  if (e.which == 64) {
    if (cantidad >= 1) {
      e.preventDefault();
    }
  }
});

$("#correo_encuestador").on("keypress", function (event) {
  /*Nombres con acentos*/

  key = event.keyCode || event.which;

  tecla = String.fromCharCode(key).toLowerCase();

  letras = " abcdefghijklmnopqrstuvwxyz0123456789._-!#@&~";

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

$("#2a").on("keyup", function (e) {
  let txt = $(this).val();
  if (txt.length > 4) {
    value = txt.substring(0, txt.length - 1);
    $(this).val(value);
  }
  let anio = new Date().getFullYear();
  if (txt > anio || txt < 1800 || txt.length < 4) {
    $("#valid_inicio_operaciones")
      .show()
      .addClass("text-danger")
      .text("Ingrese un año válido.");
  } else {
    $("#valid_inicio_operaciones").hide().removeClass("text-danger").text("");
  }
});

$("#2g").on("change", function () {
  let val = $(this).val();
  if (val == "Sí") {
    $("#2h option:eq(2)").prop("selected", true);
    $("#2i option:eq(2)").prop("selected", true);
  } else {
    $("#2h option:eq(0)").prop("selected", true);
    $("#2i option:eq(0)").prop("selected", true);
  }
});

$("input[name='tamanio_empresa']").on("change", function () {
  $("#mujeres").val("");
  $("#hombres").val("");
  $("#total1").val("");
  $("#familiares").val("");
  $("#no_familiares").val("");
  $("#total2").val("");
  $("#4a1").val("");
  $("#4b1").val("");
  $("#4c1").val("");
  $("#4d1").val("");
  $("#4aa1").val("");
  $("#4a2").val("");
  $("#4b2").val("");
  $("#4c2").val("");
  $("#4d2").val("");
  $("#4aa2").val("");
  $("#4total").val("");
  $("#totales_coinciden").hide();
  let opt_sel = $("#1q option:selected").val();
  if (opt_sel == "") {
    swal.fire({
      icon: "warning",
      title: "Seleccione un giro de negocio.",
    });
    $('input[name="tamanio_empresa"]').attr("checked", false);
    return;
  }
  let radio_val = $("input[name='tamanio_empresa']:checked").val();

  if (opt_sel == "Comercio") {
    if (radio_val == "pequenia_industria_servicios") {
      swal.fire({
        icon: "warning",
        title: "Seleccione una opción válida al giro de su negocio.",
      });
      $('input[name="tamanio_empresa"]').attr("checked", false);
      return;
    }
  } else if (opt_sel == "Servicios" || opt_sel == "Manufactura") {
    if (radio_val == "pequenia_comercio") {
      swal.fire({
        icon: "warning",
        title: "Seleccione una opción válida al giro de su negocio.",
      });
      $('input[name="tamanio_empresa"]').attr("checked", false);
      return;
    }
  }
});

$("#mujeres").on("keyup", function () {
  $("#4a1").val("");
  $("#4b1").val("");
  $("#4c1").val("");
  $("#4d1").val("");
  $("#4aa1").val("");
});

$("#hombres").on("keyup", function () {
  $("#4a2").val("");
  $("#4aa2").val("");
  $("#4b2").val("");
  $("#4c2").val("");
  $("#4d2").val("");
});

$("#4a1, #4aa1, #4b1, #4c1, #4d1").on("keyup", function (e) {
  let mujeres = $("#mujeres").val();
  let id_inp = e.target.id;

  if (mujeres == "") {
    swal.fire({
      icon: "warning",
      title:
        "Debe ingresar cuantas mujeres trabajan permanentemente en su empresa para continuar.",
    });
    $("#" + id_inp).val("");
    $("#4total").val("");
    return;
  }

  let value = $(this).val();
  value = parseInt(value);
  if (value > mujeres) {
    swal.fire({
      icon: "warning",
      title:
        "La cantidad que indica no corresponde a la cantidad de mujeres que trabajan permanentemente en su empresa",
    });
    $("#" + id_inp).val("");
    $("#4total").val("");
    return;
  }

  let a14 = $("#4a1").val();
  a14 = a14 == "" ? 0 : a14;
  let b14 = $("#4b1").val();
  b14 = b14 == "" ? 0 : b14;
  let c14 = $("#4c1").val();
  c14 = c14 == "" ? 0 : c14;
  let d14 = $("#4d1").val();
  d14 = d14 == "" ? 0 : d14;
  let aa41 = $("#4aa1").val();
  aa41 = aa41 == "" ? 0 : aa41;

  let suma =
    parseInt(a14) +
    parseInt(b14) +
    parseInt(c14) +
    parseInt(d14) +
    parseInt(aa41);
  if (suma > mujeres) {
    swal.fire({
      icon: "warning",
      title:
        "La suma de mujeres excede la cantidad que pertenecen a su empresa.",
    });
    $("#4a1").val("");
    $("#4b1").val("");
    $("#4c1").val("");
    $("#4d1").val("");
    $("#4aa1").val("");
    let a14 = $("#4a1").val();
    a14 = a14 == "" ? 0 : a14;
    let b14 = $("#4b1").val();
    b14 = b14 == "" ? 0 : b14;
    let c14 = $("#4c1").val();
    c14 = c14 == "" ? 0 : c14;
    let d14 = $("#4d1").val();
    d14 = d14 == "" ? 0 : d14;
    let aa41 = $("#4aa1").val();
    aa41 = aa41 == "" ? 0 : aa41;

    let suma_mujeres =
      parseInt(a14) +
      parseInt(b14) +
      parseInt(c14) +
      parseInt(d14) +
      parseInt(aa41);

    let a24 = $("#4a2").val();
    a24 = a24 == "" ? 0 : a24;

    let b24 = $("#4b2").val();
    b24 = b24 == "" ? 0 : b24;

    let c24 = $("#4c2").val();
    c24 = c24 == "" ? 0 : c24;

    let d24 = $("#4d2").val();
    d24 = d24 == "" ? 0 : d24;

    let aa42 = $("#4aa2").val();
    aa42 = aa42 == "" ? 0 : aa42;

    let suma_hombres =
      parseInt(a24) +
      parseInt(b24) +
      parseInt(c24) +
      parseInt(d24) +
      parseInt(aa42);

    let sumaTotal = parseInt(suma_mujeres) + parseInt(suma_hombres);
    $("#4total").val(sumaTotal);
    return;
  }
});

$("#4a2, #4aa2, #4b2, #4c2, #4d2").on("keyup", function (e) {
  let hombres = $("#hombres").val();
  let id_inp = e.target.id;

  if (hombres == "") {
    swal.fire({
      icon: "warning",
      title:
        "Debe ingresar cuantos hombres trabajan permanentemente en su empresa para continuar.",
    });
    $("#" + id_inp).val("");
    $("#4total").val("");
    return;
  }
  let value = $(this).val();
  value = parseInt(value);
  if (value > hombres) {
    swal.fire({
      icon: "warning",
      title:
        "La cantidad que indica no corresponde a la cantidad de hombres que trabajan permanentemente en su empresa",
    });
    $("#4total").val("");
    $("#" + id_inp).val("");
    return;
  }

  let a24 = $("#4a2").val();
  a24 = a24 == "" ? 0 : a24;

  let b24 = $("#4b2").val();
  b24 = b24 == "" ? 0 : b24;

  let c24 = $("#4c2").val();
  c24 = c24 == "" ? 0 : c24;

  let d24 = $("#4d2").val();
  d24 = d24 == "" ? 0 : d24;

  let aa42 = $("#4aa2").val();
  aa42 = aa42 == "" ? 0 : aa42;

  let suma =
    parseInt(a24) +
    parseInt(b24) +
    parseInt(c24) +
    parseInt(d24) +
    parseInt(aa42);
  if (suma > hombres) {
    swal.fire({
      icon: "warning",
      title:
        "La suma de hombres excede la cantidad que pertenecen a su empresa",
    });
    $("#4a2").val("");
    $("#4b2").val("");
    $("#4c2").val("");
    $("#4d2").val("");
    $("#4aa2").val("");
    let a14 = $("#4a1").val();
    a14 = a14 == "" ? 0 : a14;
    let b14 = $("#4b1").val();
    b14 = b14 == "" ? 0 : b14;
    let c14 = $("#4c1").val();
    c14 = c14 == "" ? 0 : c14;
    let d14 = $("#4d1").val();
    d14 = d14 == "" ? 0 : d14;
    let aa41 = $("#4aa1").val();
    aa41 = aa41 == "" ? 0 : aa41;

    let suma_mujeres =
      parseInt(a14) +
      parseInt(b14) +
      parseInt(c14) +
      parseInt(d14) +
      parseInt(aa41);

    let a24 = $("#4a2").val();
    a24 = a24 == "" ? 0 : a24;

    let b24 = $("#4b2").val();
    b24 = b24 == "" ? 0 : b24;

    let c24 = $("#4c2").val();
    c24 = c24 == "" ? 0 : c24;

    let d24 = $("#4d2").val();
    d24 = d24 == "" ? 0 : d24;

    let aa42 = $("#4aa2").val();
    aa42 = aa42 == "" ? 0 : aa42;

    let suma_hombres =
      parseInt(a24) +
      parseInt(b24) +
      parseInt(c24) +
      parseInt(d24) +
      parseInt(aa42);

    let sumaTotal = parseInt(suma_mujeres) + parseInt(suma_hombres);

    $("#4total").val(sumaTotal);
    return;
  }
});

$("#7b").on("keyup", function () {
  let val = $(this).val();
  if (val < 18 || val > 130) {
    $("#valid_edad")
      .show()
      .addClass("text-danger")
      .text("Ingrese una edad válida.");
  } else {
    $("#valid_edad").hide().removeClass("text-danger").text("");
  }
});

$("#8b,#8e,#8f").on("change", function () {
  let b8 = $("#8b option:selected").val();
  let e8 = $("#8e option:selected").val();
  let f8 = $("#8f option:selected").val();

  if (b8 != "" && e8 != "" && f8 != "") {
    b8 = b8.match(/\d+/)[0];

    e8 = e8 == "Nada de tiempo" ? 0 : e8.match(/\d+/)[0];

    f8 = f8 == "Nada de tiempo" ? 0 : f8.match(/\d+/)[0];

    let suma = parseInt(b8) + parseInt(e8) + parseInt(f8);

    if (suma > 24) {
      swal.fire({
        icon: "warning",
        title:
          "Existe incongruencia en las horas sumadas de las preguntas 8b, 8e y 8f. Intente de nuevo.",
      });
      $("#8b option:eq(0)").prop("selected", true);
      $("#8e option:eq(0)").prop("selected", true);
      $("#8f option:eq(0)").prop("selected", true);
      return;
    }
  }
});

$("#8a").on("keyup", function () {
  let val = $(this).val();
  if (val <= 0 || val > 7) {
    $("#valid_dias")
      .show()
      .addClass("text-danger")
      .text("Ingrese una cantidad válida.");
  } else {
    $("#valid_dias").hide().removeClass("text-danger").text("");
  }
});

$("#1j").on("keyup", function () {
  let val = $(this).val();
  val = val.length;
  if (val < 5 || val > 6) {
    $("#valid_cp")
      .show()
      .addClass("text-danger")
      .text("Ingrese un código postal válido.");
  } else {
    $("#valid_cp").hide().removeClass("text-danger").text("");
  }
});

$("#inputRFC").on("keyup", function () {
  let val = $(this).val();
  val = val.length;
  if (val < 12) {
    $("#valid_rfc")
      .show()
      .addClass("text-danger")
      .text("Ingrese un RFC válido.");
  } else {
    $("#valid_rfc").hide().removeClass("text-danger").text("");
  }
});

$("#inputNIT").on("keyup", function () {
  let val = $(this).val();
  val = val.length;
  if (val < 13) {
    $("#valid_nit")
      .show()
      .addClass("text-danger")
      .text("Ingrese un valor válido.");
  } else {
    $("#valid_nit").hide().removeClass("text-danger").text("");
  }
});

$("#1q").on("change", function () {
  $('input[name="tamanio_empresa"]').attr("checked", false);

  let val = $(this).val();
  $("#1r").val("");
  $.ajax({
    type: "POST",
    url: "../../getRama1",
    data: {
      giro: val,
    },
    success: function (data) {
      $("#rama1").empty();
      $("#rama2").empty();
      $("#rama3").empty();
      $("#rama4").empty();
      $("#rama5").empty();
      $("#rama1").html(data);
    },
  });
});

$("#1j,#tel_fijo,#tel_extension,#tel_cel").on("keypress", function () {
  key = event.keyCode || event.which;

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

document.addEventListener(
  "copy",
  function (event) {
    // Change the copied text if you want
    // Prevent the default copy action
    event.preventDefault();
  },
  false
);

$("#piso_empresa").on("change", function () {
  let val = $(this).val();

  if (val == "99. Otro (especifique)") {
    $("#otro_piso_input").val("");
    $("#otro_piso").show();
    $("#otro_piso_input").prop("required", true);
  } else {
    $("#otro_piso").hide();
    $("#otro_piso_input").prop("required", false);
    $("#otro_piso_input").val("");
  }
});

$("#1k").on("change", function () {
  if (pais != 2) {
    return;
  }
  let val = $(this).val();
  let estado = $("#estado_pais").val();
  $.ajax({
    type: "POST",
    url: "../../getClaveMunicipio",
    data: {
      municipio: val,
      estado: estado,
    },
    dataType: "json",
    success: function (data) {
      if (data.clave_municipio == "null") {
        //No existe el municipio, lo regresamos
        swal
          .fire({
            icon: "warning",
            title: "Lo sentimos",
            text: "No hemos encontrado la clave de su municipio. Contacte a sistemas para solucionar el problema.",
          })
          .then(function () {
            window.close();
          });
      } else {
        $("#clave_municipio").val(data.clave_municipio);
        $("#localidad").empty().append(data.localidades);
      }
    },
  });
});

$("input[name='medio_captura']").on("change", function () {
  let val = $(this).val();

  if (val == "enlace") {
    $("#nombre_encuestador")
      .val("No aplica por el medio de captura.")
      .prop("readonly", true);
    $("#correo_encuestador")
      .attr("type", "text")
      .val("No aplica por el medio de captura.")
      .prop("readonly", true);
  } else {
    $("#nombre_encuestador").val("").prop("readonly", false);
    $("#correo_encuestador")
      .attr("type", "email")
      .val("")
      .prop("readonly", false);
  }
});

$("input, #descripcion_mype").on("keydown", function (e) {
  let val = $(this).val();
  let id = e.target.id;
  let keycode = e.which;
  let last_key = val.substr(val.length - 1);
  if (last_key == " " && keycode == 32) {
    val = val.slice(0, -1);
    $("#" + id).val(val);
  }
});

$("#7d").on("change", function () {
  let val = $(this).val();
  let mujeres = $("#mujeres").val();
  let hombres = $("#hombres").val();
  if (!mujeres || !hombres) {
    $("#7d option:eq(0)").prop("selected", true);
    alert("Contesta el apartado 3) Personal ocupado para continuar.");
    return;
  }
  if (mujeres >= 1 && hombres == 0) {
    if (val != "Mujer") {
      $("#7d option:eq(0)").prop("selected", true);
      alert("Seleccione una opción válida con respecto a su personal.");
    }
  }
  if (hombres >= 1 && mujeres == 0) {
    if (val != "Hombre") {
      $("#7d option:eq(0)").prop("selected", true);
      alert("Seleccione una opción válida con respecto a su personal.");
    }
  }
});

$("#tipo_vialidad_posterior").on("change", function () {
  let val = $(this).val();
  if (val == "NA") {
    $("#nombre_vialidad_posterior").val("NA").prop("readonly", true);
  } else {
    $("#nombre_vialidad_posterior").val("").prop("readonly", false);
  }
});

$("#tipo_conglomerado").on("change", function () {
  let val = $(this).val();
  if (val == "NA") {
    $("#nombre_conglomerado").val("NA").prop("readonly", true);
  } else {
    $("#nombre_conglomerado").val("").prop("readonly", false);
  }
});

$("#tel_fijo,#tel_extension,#tel_cel").on("keyup", function () {
  let val = $(this).val();
  let id = $(this)[0].id;
  if (id == "tel_extension") {
    if (val.length < 1) {
      $("#valid_" + id)
        .show()
        .addClass("text-danger")
        .text("Ingrese un valor válido.");
    } else {
      $("#valid_" + id)
        .hide()
        .removeClass("text-danger")
        .text("");
    }
  } else {
    if (val.length < 10) {
      $("#valid_" + id)
        .show()
        .addClass("text-danger")
        .text("Ingrese un valor válido.");
    } else {
      $("#valid_" + id)
        .hide()
        .removeClass("text-danger")
        .text("");
    }
  }

});

$("#1j").focusout(function () {
  let val = $(this).val();
  if (val >= 5) {
    $.ajax({
      type: "POST",
      url: "../../getInfoCp",
      data: {
        cp: val,
        claveCuerpo: claveCuerpo,
      },
      success: function (data) {
        if (data == "invalido") {
          $("#valid_cp")
            .show()
            .addClass("text-danger")
            .text(
              "Ingrese un código postal que corresponda a la zona de estudio autorizada por RELAYN."
            );
          return;
        }
        $("#valid_cp").hide().removeClass("text-danger").text("");
        $("#selectLugar").show();
        $("#info_cp").empty();
        $("#info_cp").append(data);
      },
    });
  } else {
    $("#selectLugar").hide();
  }
});

$("#info_cp").on("change", function () {
  let val = $(this).val();

  if (val == "otra") {
    $("#otra_info_cp").prop("required", true);
    $("#otra_ubi").show();
    return;
  }
  $("#otra_info_cp").prop("required", false).val("");
  $("#otra_ubi").hide();
  return;
});

$("#localidad").on("change", function () {
  let clave_loc = $(this).val();
  $("#clave_loc").val(clave_loc);
});

function dataSendFunction() {
  var formDataArray = $("#msform").serializeArray();
  var formData = {};

  $.each(formDataArray, function(i, field) {
    let inputName = field.name;
    let inputElement = $(`[name='${inputName}']`);
    let parentNode = $(`[name='${inputName}']`).parent();
    let label = parentNode.find('label');

    let td = inputElement.closest('tr').find('td:first'); // Encuentra el primer td en la misma fila
    
    if (label.length > 0) {
      // Inicializa la estructura de datos para esta entrada si aún no existe
      if (!formData[i]) {
        formData[i] = {};
      }

      formData[i][inputName] = {};
      if(inputElement == 'radioRFC'){
        formData[i][inputName]['pregunta'] = '1d) ¿La empresa cuenta con RFC?';
      }else{
        formData[i][inputName]['pregunta'] = label.text();
      }
      
    }

    if (td.length > 0) {
      // Inicializa la estructura de datos para esta entrada si aún no existe
      if (!formData[i]) {
        formData[i] = {};
      }

      formData[i][inputName] = {};
      formData[i][inputName]['pregunta'] = td.text();
    }

    formData[i][inputName]['valor'] = field.value;
  });
}

/*
  document.addEventListener("paste", function(event){
    // Change the copied text if you want  
    // Prevent the default copy action
    event.preventDefault();
  }, false);
  */
