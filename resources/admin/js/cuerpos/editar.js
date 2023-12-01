$( document).ready(function(){

    $("#editarRector").hide();

    $("#direccion_envio").attr("readonly",true);

    $("#editarDirEnv").attr('disabled',true);

    if ($("#cbx_pais").length) {
        $("#cbx_pais").select2();
    }
    if ($("#cbx_estado").length) {
        $("#cbx_estado").select2();
    }
    if ($("#cbx_municipio").length) {
        $("#cbx_municipio").select2();
    }

    
    

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

$("#cbx_pais").on("change", function () {

    pais = $("#cbx_pais option:selected").val();
    
    
    $.ajax({
    
        type: "POST",
    
        url: base_url + "/getEstado",
    
        data: {
    
            pais: pais,
    
        },
    
        success: function (data) {
    
            $("#cbx_estado").html(data);
    
        },
    
    });
    
});

$("#cbx_estado").on("change", function () {

    estado = $("#cbx_estado option:selected").val();
    
    
    $.ajax({
    
        type: "POST",
    
        url: base_url + "/getMunicipio",
    
        data: {
    
            estado: estado,
    
        },
    
        success: function (data) {
    
            $("#cbx_municipio").html(data);
    
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

$("#formatear").on("click",function(){

    $("#editarRector").show();

    $("#formatear").hide();

    calle = $("#calle").val().trim();

    numero = $("#numero").val().trim();

    colonia = $("#colonia").val().trim();

    estado = $("#estado option:selected").text();

    municipio = $("#municipio option:selected").text();

    console.log(estado);
    console.log(municipio);

    cp = $("#cp").val().trim();

    if(calle == "" || numero == "" || colonia == "" || estado == "Seleccione una opción" || municipio == "Seleccina un municipio" || cp == ""){
        console.log('wtf');

        Swal.fire({

            icon: 'warning',

            title: 'Espera',

            text: 'Completa correctamente los campos para continuar',

          });
        $("#editarDirEnv").attr('disabled',true);


    }else{

        $("#editarDirEnv").attr('disabled',false);

        $("#direccion_envio").val("Calle/Av. "+calle + " #" + numero + ", Estado de "+ estado + " en el Municipio de "+ municipio + " Colonia " +colonia + " C.P. " +cp);
    }

});

$("#cbx_municipioplus").on('change',function(){
    let id = $("#cbx_municipioplus").val();
    
    if(id == 1){
        $("#otromunplus").prop('required',true)
        $("#divotroMunplus").show();
    }else{
        $("#otromunplus").prop('required',false)
        $("#divotroMunplus").hide();
    }
})


