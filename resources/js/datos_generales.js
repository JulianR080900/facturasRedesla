$( document).ready(function(){

    $("#editarRector").hide();

    $("#direccion_envio").attr("readonly",true);

    $("#divUniversidadAdscripcion").hide()

    $("#editarDirEnv").prop('disabled',true);
    

})

$("#estado").on("change", function () {

    estado = $("#estado").val();
    
    
    $.ajax({
    
        type: "POST",
    
        url: base_url + "/getMunicipio",
    
        data: {
    
            estado: estado,
    
        },
    
        success: function (data) {
    
            $("#municipio").html(data);
    
        },
    
    });
    
    });


$("#nombre_rector").on('keypress',function(event){ /*Nombres con acentos*/

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

$("#calle,#numero,#colonia,#cp,#estado,#municipio").on("keydown",function(){

    $("#formatear").show();

    $("#editarDirEnv").attr('disabled',true);

});

$("#estado,#municipio").on("change",function(){

    $("#formatear").show();

    $("#editarDirEnv").attr('disabled',true);

});


 
const valoresPreguntas = {
    0: 'Tipo',
    1: 'No.Int',
    2: 'No. Ext',
    3: 'Colonia',
    4: 'Localidad',
    5: 'Municipio',
    6: 'Estado',
    7: 'CP',
    8: 'Referencias del domicilio'
  }
  
  
  const parent = document.getElementById('direcciones_universidad_form');
  
  const children = parent.querySelectorAll('input')
  
  children.forEach(element => {
    element.addEventListener('blur',() => {
        const arreglo = valoresUni()
        
        if(children.length !== arreglo.length){
            document.getElementById('direccionUniversidad').value = ''
            $("#divUniversidadAdscripcion").hide('slow');
            $("#editarDirEnv").prop('disabled',true)
            return
        }
  
        let direccionFormato = '';
  
        arreglo.forEach((element,index) => {
            direccionFormato += valoresPreguntas[index]+' '+element+', '
        });
  
        direccionFormato = direccionFormato.slice(0, direccionFormato.length - 2);
  
        direccionFormato = direccionFormato+'.'
  
        document.getElementById('direccionUniversidad').value = direccionFormato
        document.getElementById('direccionUniversidad').readOnly = true
        $("#divUniversidadAdscripcion").show('slow');
        $("#editarDirEnv").prop('disabled',false)
    })
  })
  
  function valoresUni(){
    const arreglo = [];
  
    children.forEach(element => {
        let val = element.value;
        if(val !== ''){
            arreglo.push(val);
        }
        
    })
  
    return arreglo
  }


  
  $("#noInt,#noExt").on('keypress',function(e){

    key = e.keyCode || e.which;

    tecla = String.fromCharCode(key).toLowerCase();

    letras = "s/n0123456789abcdefghijklmnñopqrstuvwxyz";

    especiales = "8-37-39-46";

    tecla_especial = false;

    for (var i in especiales) {

        if (key == especiales[i]) {

            tecla_especial = true;

            break;

        }

    }



    if (letras.indexOf(tecla) == -1 && !tecla_especial) {

         e.preventDefault();       

    }

})



const btnDisabled = document.querySelectorAll('.disabled_edit')

btnDisabled.forEach(element => {
    element.innerHTML = 'No disponible'
    element.style.pointerEvents = "none";
});
