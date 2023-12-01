$("#pais").on("change",function(){
    pais = $("#pais").val();
    $('#municipio').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
    if(pais == 1){
      $("#divotroPais").fadeIn();
    }else{
      $("#divotroPais").fadeOut();
      $("#divotroEst").fadeOut();
      $("#divotroMun").fadeOut();
    }
    $.ajax({
      type: "POST",
      url: base_url + 'adminController/getEstado',
      data: {
          'pais': pais
      },success: function (data) {  
        $("#estado").html(data);
      }
  });

 });

$("#estado").on("change",function(){
  estado = $("#estado").val();
  if(estado == 1){
    $("#divotroEst").fadeIn();
  }else{
    $("#divotroEst").fadeOut();
  }
  $.ajax({
    type: "POST",
    url: base_url + 'adminController/getMunicipio',
    data: {
        'estado': estado
    },success: function (data) {  
      $("#municipio").html(data);
    }
});
 });

$("#municipio").on("change",function(){
  municipio = $("#municipio").val();
  if(municipio == 1){
    $("#divotroMun").fadeIn();
  }else{
    $("#divotroMun").fadeOut();
  }
 });