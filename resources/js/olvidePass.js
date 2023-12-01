$(document).ready(function(){
  $('button[type="submit"]').prop('disabled',true);
})

$("#contra, #conf").on('keyup',function(){
  var contra = $("#contra").val();
  var conf = $("#conf").val();

  var c_contra = contra.length;

  if(c_contra < 8){
    $("#message").html('Las contraseña debe ser mayor a 8 caracteres').css('color','red');
    $('button[type="submit"]').prop('disabled',true);
  }else{
    if(conf == contra){
      $('#message').html('');
      $('button[type="submit"]').prop('disabled',false);
    }else{
      $("#message").html('Las contraseñas no coinciden').css('color','red');
      $('button[type="submit"]').prop('disabled',true);
    }
  }


  

});