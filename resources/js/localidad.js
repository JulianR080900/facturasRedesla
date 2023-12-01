$("#cbx_pais").on("change",function(){
    console.log("hi");
      pais = $("#cbx_pais").val();
      $('#cbx_municipio').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
      if(pais == 1){
        $("#divotroPais").fadeIn();
      }else{
        $("#divotroPais").fadeOut();
        $("#divotroEst").fadeOut();
        $("#divotroMun").fadeOut();
      }
      $.ajax({
        type: "POST",
        url: base_url + 'loginController/getEstado',
        data: {
            'pais': pais
        },success: function (data) {  
          $("#cbx_estado").html(data);
        }
    });

   });

  $("#cbx_estado").on("change",function(){
    estado = $("#cbx_estado").val();
    if(estado == 1){
      $("#divotroEst").fadeIn();
    }else{
      $("#divotroEst").fadeOut();
    }
    $.ajax({
      type: "POST",
      url: base_url + 'loginController/getMunicipio',
      data: {
          'estado': estado
      },success: function (data) {  
        $("#cbx_municipio").html(data);
      }
  });
   });

  $("#cbx_municipio").on("change",function(){
    municipio = $("#cbx_municipio").val();
    if(municipio == 1){
      $("#divotroMun").fadeIn();
    }else{
      $("#divotroMun").fadeOut();
    }
   });