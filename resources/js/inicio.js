
function cambiarPass(){
    $("#cambiarPass").modal("show");
}
$(document).ready(function(){
    $("#form_new").hide();
    $("#nueva_pass").prop("disabled",true);
    $("#nueva_pass_confirm").prop("disabled",true);
});

$("#validacion").on("click",function(){
    var act = $("#pass_act").val();
    var bd = $("#pass_bd").val();
    //alert(act+"-"+bd);
                     $.ajax({
                      type: "POST",
                      url: base_url + 'validarPass',
                      data: {
                          'pass_act': act,
                          'pass_bd': bd
                      }, beforeSend: function(){
                         $("#validacion").prop("disabled",true);
                      },success: function (data) {
                          if(data == "yes"){
                            $("#form_new").show();
                            $("#nueva_pass").prop("disabled",false);
                          }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'La contraseña ingresada no es correcta',
                              });
                              $("#validacion").prop("disabled",false);
                          }
                      }
                  });
});

var correcto = "";

$("#nueva_pass,#nueva_pass_confirm").on("keyup",function(){
                  
    var pass = $("#nueva_pass").val();
    var mayus = new RegExp("^(?=.*[A-Z])");
    var special = new RegExp("^(?=.*[!@#$&*_-])");
    var numbers = new RegExp("^(?=.*[0-9])");
    var lower = new RegExp("^(?=.*[a-z])");
    var len = new RegExp("^(?=.{8,})");

    if(mayus.test(pass) && special.test(pass) && numbers.test(pass) && lower.test(pass) && len.test(pass)){
        $("#pswd_info").hide();
        $("#nueva_pass").addClass("is-valid").removeClass("is-invalid");
        correcto = "si";
        $("#nueva_pass_confirm").prop("disabled",false);
    }else{
        $("#pswd_info").show();
        correcto = "no";
        $("#nueva_pass").removeClass("is-valid").addClass("is-invalid");
        $("#nueva_pass_confirm").prop("disabled",true);
    }
    
    
    var conf = $("#nueva_pass_confirm").val();
    if(pass == conf && correcto == "si"){
        $("#btn_act_pass").prop("disabled",false);
        $("#advertencia").css("display","").css("color","red").css("text-align","center");
        $("#nueva_pass_confirm").addClass("is-valid").removeClass("is-invalid");
    }else{
        $("#btn_act_pass").prop("disabled",true);
        $("#advertencia").css("display","none").css("color","red").css("text-align","center");
        $("#nueva_pass_confirm").removeClass("is-valid").addClass("is-invalid");
    }
  });




  $("#btn_act_pass").on("click",function(){
                  
    var pass = $("#nueva_pass").val();
    var conf = $("#nueva_pass_confirm").val();
    var id_m = $("#id_m").val();
    
    
    if($("#nueva_pass").hasClass("is-valid") && $("#nueva_pass_confirm").hasClass("is-valid")){
        $.ajax({
            type: "POST",
            url: base_url + 'actualizarPass',
            data: {
                'pass': pass,
                'conf': conf,
                'id_m': id_m
            },beforeSend: function(){
                $("#btn_act_pass").prop("disabled",true);
            },success: function (data) {  
                if(data = "success"){
                    Swal.fire({
                        title: "Cambio de contraseña realizado correctamente",
                        text: "Inicie sesión con su nueva credencial",
                        icon: "success"
                      }).then(function() {
                          window.location.href = base_url+'logout';
                      }); 
                }else if(data == "error"){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ocurrio un error, intente mas tarde',
                      })
                  }
            }
        });
      }else{
        Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Ocurrio un error',
                })
            }    
  });
