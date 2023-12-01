$(document).ready(function () {
  $("#medios").hide();

  
  /*
    var allElems = document.getElementsByTagName('input');
    for (i = 0; i < allElems.length; i++) {
        if (allElems[i].type == 'radio' && allElems[i].value == '1') {
            allElems[i].checked = true;
        }
    }
   */

  var current_fs, next_fs, previous_fs; //fieldsets
  var opacity;

  $(".next").click(function () {
    var check = $("#checkAviso").is(":checked");

    if (!check) {
      alert(
        "Para continuar con la captura debe aceptar el aviso de privacidad.."
      );
      return;
    }

    let medio = $("input[name='medio_captura']:checked").val();

    if (medio === undefined) {
      swal.fire({
        icon: 'warning',
        text: 'Seleccione el medio por el cual realizó la encuesta.',
        title: 'Cuidado'
      })
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
      alert("No puede continuar si no acepta");
      return;
    }

    let medio = $("input[name='medio_captura']:checked").val();

    if (medio === undefined) {
      swal.fire({
        icon: 'warning',
        text: 'Seleccione el medio por el cual realizó la encuesta.',
        title: 'Cuidado'
      })
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

  $(".validacion_prev").hide();

  /*
  //SOLO CARACTERES
  $("#nombre_encuestador").each(function () {
    let id = $(this)[0].id;
    $("#" + id).attr("pattern", "[A-Za-z]+");
  });
  */

  $("#1a").each(function () {
    let id = $(this)[0].id;
    $("#" + id)
      .attr("min", 18)
      .attr("max", 130);
  });

  $("#7a, #8a").each(function () {
    let id = $(this)[0].id;
    $("#" + id)
      .attr("min", 0)
      .attr("max", 24)
      .attr("step", "0.1");
  });

  $("#14d,#14e,#14f").each(function () {
    let id = $(this)[0].id;
    $("#" + id)
      .attr("min", 0)
      .attr("max", 168);
  });

  $("#14g").attr('min',0).attr('max',10).attr('step',.1)

  /*
  $("#15f").attr('pattern', '^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$')
  $("#15g").attr('pattern', '[^@\s]+@[^@\s]+')
  $("#15h").attr('pattern', '^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$')
  $("#15i").attr('pattern', '(?<=^|(?<=[^a-zA-Z0-9-_\.]))@([A-Za-z]+[A-Za-z0-9-_]+)')
  */
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


            let val1 = $("#14d").val();
            let val2 = $("#14e").val();
            let val3 = $("#14f").val();

            if (val1 != "" && val2 != "" && val3 != "") {
              let suma = parseInt(val1) + parseInt(val2) + parseInt(val3);
              if (suma > 168) {
                swal
                  .fire({
                    icon: "warning",
                    title: "Cuidado",
                    text: "La suma de las preguntas 14d), 14e) y 14f) excede el máximo de horas que tiene una semana. Complete correctamente.",
                  })
                  .then(function () {
                    $("#14d").val("");
                    $("#14e").val("");
                    $("#14f").val("");

                    $("fieldset").css({
                      display: "none",
                      position: "relative",
                    });
  
                    $("#field3").css({
                      opacity: 1,
                      display: "block",
                    });
                    $("#14d").focus();
                  });
              }
            }


            if (form.checkValidity() === false) {
              $("button[type='submit']").prop("disabled", true);

              swal.fire({
                  title: 'Cuidado',
                  text:
                    "Asegúrese que TODAS las preguntas tengan una respuesta seleccionada sobre todo en los apartados 4 y 5. Recuerde que CADA PREGUNTA debe tener una respuesta VÁLIDA para poder FINALIZAR.",
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

                  let id_parentNode = '';
                  let id_first_invalid = '';

                  if(invalids.length === 0){
                    if(invalidSelects.length === 0){
                      //Entonces es en los radios
                      id_parentNode = 'field4'
                    }else{
                      id_first_invalid = invalidSelects[0].id;
                      let parentNode = $("#" + id_first_invalid)
                        .parent()
                        .parent();
                        id_parentNode = parentNode[0].id;
                    }
                  }else{
                    id_first_invalid = invalids[0].id;
                    let parentNode = $("#" + id_first_invalid)
                      .parent()
                      .parent();
                    id_parentNode = parentNode[0].id;
                  }

                  let existe = id_parentNode.indexOf('field')
                  
                  if(existe == -1){
                    id_parentNode = 'field1'
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

$("input[type='number'], #14a").on("keypress", function (event) {
  /*Solamente numeros*/
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

$("#1h").on("keypress", function (event) {
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

/*
function check_na(e) {
  let id = e.target.defaultValue;
  let checkbox = $("#check_" + id)[0].checked;
  if (checkbox) {
    $('input[name="' + id + '"]').val("na");
    $('input[name="' + id + '"]').text("NA");
    $('input[name="' + id + '"]').prop("readonly", true);
  } else {
    $('input[name="' + id + '"]').val("");
    $('input[name="' + id + '"]').text("");
    $('input[name="' + id + '"]').prop("readonly", false);
  }
}
*/

function check_na(e) {
  let id = e.target.defaultValue;
  let checkbox = $("#check_" + id)[0].checked;
  let pattern = "";
  if (id == "15g") {
    //Correo
    pattern = "[^@s]+@[^@s]+";
  } else if (id == "15f") {
    //facebook
    pattern =
      "^(https?://)?(www.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*.)+[w]{2,}(/S*)?$";
  } else if (id == "15h") {
    //website
    pattern =
      "^(https?://)?(www.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*.)+[w]{2,}(/S*)?$";
  } else if (id == "15i") {
    pattern = "(?<=^|(?<=[^a-zA-Z0-9-_.]))@([A-Za-z]+[A-Za-z0-9-_]+)";
  } else {
    pattern = "";
  }

  if (checkbox) {
    $('input[name="' + id + '"]')
      .prop("type", "text")
      .val("na");
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
    imageUrl: base_url + "/resources/gifs/Maps.gif",
    imageWidth: 780,
    imageHeight: 600,
    imageAlt: "Custom image",
    customClass: "swal-wide",
  });
});

$("#correo_encuestador, #15i").on("keypress", function (e) {
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

$("input").on("keydown", function (e) {
  let txt = $(this).val();
  if (e.which == 32) {
    if (txt.length == 0) {
      if (txt == "") {
        e.preventDefault();
      }
    }
  }
});

$("input[type='number']").on("keypress", function (event) {
  /*Solamente numeros*/
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

$("#1a").on("keyup", function () {
  let val = $(this).val();

  if (val < 18 || val > 130) {
    $("#inst_edad")
      .show()
      .addClass("text-danger")
      .text("Ingrese una edad válida.");
  } else {
    $("#inst_edad").hide().removeClass("text-danger").text("");
  }
});

$("#7a, #8a").on("keyup", function () {
  let val = $(this).val();
  let id = $(this)[0].id;

  if (val > 24 || val < 0) {
    $("#inst_" + id)
      .show()
      .addClass("text-danger")
      .text("Ingrese un valor válido.");
  } else {
    $("#inst_" + id)
      .hide()
      .removeClass("text-danger")
      .text("");
  }
});

$("#14d,#14e,#14f").on("keyup", function () {
  let val = $(this).val();
  let id = $(this)[0].id;

  if (val > 168 || val < 0) {
    $("#inst_" + id)
      .show()
      .addClass("text-danger")
      .text("Ingrese un valor válido.");
  } else {
    $("#inst_" + id)
      .hide()
      .removeClass("text-danger")
      .text("");
  }

  let val1 = $("#14d").val();
  let val2 = $("#14e").val();
  let val3 = $("#14f").val();

  if (val1 != "" && val2 != "" && val3 != "") {
    let suma = parseInt(val1) + parseInt(val2) + parseInt(val3);
    if (suma > 168) {
      swal
        .fire({
          icon: "warning",
          title: "Cuidado",
          text: "La suma de las preguntas 14d), 14e) y 14f) excede el máximo de horas que tiene una semana. Complete correctamente.",
        })
        .then(function () {
          $("#14d").val("");
          $("#14e").val("");
          $("#14f").val("");
        });
    }
  }
});

$("#14g").on("keyup", function () {
  let val = $(this).val();
  let id = $(this)[0].id;
  
  if (val < 0 || val > 10) {
    $("#inst_" + id)
      .show()
      .addClass("text-danger")
      .text("Ingrese un promedio válido.");
  } else {
    $("#inst_" + id).hide().removeClass("text-danger").text("");
  }
});

$("#nombre_encuestador").on("keypress", function (event) {
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

$("#7a_horas, #7a_minutos").on('keyup',function(){
  let horas = $("#7a_horas").val()
  let minutos = $("#7a_minutos").val()

  if(minutos != '' && horas != ''){
    if(minutos.length == 1){
      minutos = '0'+minutos
    }
    if(horas.length == 1){
      horas = '0'+horas
    }
    let tiempo = horas+':'+minutos
    $("#7a").val(tiempo)
  }

})

$("#8a_horas, #8a_minutos").on('keyup',function(){
  let horas = $("#8a_horas").val()
  let minutos = $("#8a_minutos").val()

  if(minutos != '' && horas != ''){
    if(minutos.length == 1){
      minutos = '0'+minutos
    }
    if(horas.length == 1){
      horas = '0'+horas
    }
    let tiempo = horas+':'+minutos
    $("#8a").val(tiempo)
  }

})

$("#14g").on('keypress',function(){
  key = event.keyCode || event.which;

  tecla = String.fromCharCode(key).toLowerCase();

  letras = "1234567890.";

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
})

$("input[name='medio_captura']").on('change',function(){
  let val = $(this).val();

  if(val == 'enlace'){
    $("#nombre_encuestador").val('No aplica por el medio de captura.').prop('readonly',true)
    $("#correo_encuestador").attr('type','text').val('No aplica por el medio de captura.').prop('readonly',true)
  }else{
    $("#nombre_encuestador").val('').prop('readonly',false)
    $("#correo_encuestador").attr('type','email').val('').prop('readonly',false)
  }
})
