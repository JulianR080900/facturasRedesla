$(document).ready(function () {
  $("#medios").hide();
  $("#aviso_especialidad").hide();
  $("#otra_especialidad").hide();
  
  
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
      swal.fire({
        icon: 'warning',
        text: 'Para continuar con la captura debe aceptar el aviso de privacidad.',
        title: 'Cuidado'
      })

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
      swal.fire({
        icon: 'warning',
        text: 'Para continuar con la captura debe aceptar el aviso de privacidad.',
        title: 'Cuidado'
      })
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

  //SOLO CARACTERES
  /*
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

  /*
  $("#18g").attr('pattern', '^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$')
  $("#18h").attr('pattern', '[^@\s]+@[^@\s]+')
  $("#18i").attr('pattern', '^(https?:\/\/)?(www\.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*\.)+[\w]{2,}(\/\S*)?$')
  $("#18j").attr('pattern', '(?<=^|(?<=[^a-zA-Z0-9-_\.]))@([A-Za-z]+[A-Za-z0-9-_]+)')
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
            if (form.checkValidity() === false) {

              $("button[type='submit']").prop("disabled", true);

              swal.fire({
                  title: 'Cuidado',
                  text:
                    "Asegúrese que TODAS las preguntas tengan una respuesta seleccionada sobre todo en los apartados 2, 3, 4 y 5. Recuerde que CADA PREGUNTA debe tener una respuesta VÁLIDA para poder FINALIZAR.",
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
  if (id == "18h") {
    //Correo
    pattern = "[^@s]+@[^@s]+";
  } else if (id == "18g") {
    //facebook
    pattern =
      "^(https?://)?(www.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*.)+[w]{2,}(/S*)?$";
  } else if (id == "18i") {
    //website
    pattern =
      "^(https?://)?(www.)?([a-zA-Z0-9]+(-?[a-zA-Z0-9])*.)+[w]{2,}(/S*)?$";
  } else if (id == "18j") {
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

$("#select_18f").on('change',function(){
  let valor_change = $(this).val();
  if(valor_change == especialidad){
    $("#aviso_especialidad").hide();
    $("#cambio_especialidad").val('0');
  }else{
    $("#cambio_especialidad").val('1');
    $("#aviso_especialidad").show();
  }
  if(valor_change == 'otra'){
    $("#otra_especialidad").show();
    $("#input_otra_especialidad").prop('required',true);
  }else{
    $("#otra_especialidad").hide();
    $("#input_otra_especialidad").prop('required',false);
  }
})

$("#dudas").on('click',function(){
  Swal.fire({
    imageUrl: base_url+'/resources/gifs/Maps.gif',
    imageWidth: 780,
    imageHeight: 600,
    imageAlt: 'Custom image',
    customClass: 'swal-wide',
  })
})


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

$("#correo_encuestador, #18j").on("keypress", function (e) {
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

