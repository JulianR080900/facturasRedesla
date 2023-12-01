$("#act_localidad").on("click",function(){
    pais = $("#cbx_pais").val();
    estado = $("#cbx_estado").val();
    municipio = $("#cbx_municipio").val();
    ca = $("input[name=clave]").val();
    if(pais == 1){
        pais = $("#otropais").val();
    }
    if(estado == 1){
        estado = $("#otroest").val();
    }
    if(municipio == 1){
        municipio = $("#otromun").val();
    }
    if(pais === null || estado === null || municipio === null || estado == "Seleccina un Estado" || municipio == "whatever" || municipio == "Seleccina un municipio"){
        console.log("llena");
    }else if(pais === "" || estado === "" || municipio === ""){
        console.log("llena2");
    }else{
        $.ajax({
            type:"POST",
            url: base_url+"UpdateCaAdmin/localidad/"+ca,
            data:{
                "pais":pais,
                "estado": estado,
                "municipio":municipio,
                "ca" : ca
            },success: function(data){
                if(data == "nice"){
                    Swal.fire(
                      'Exito',
                      'Se ha actualizado correctamente',
                      'success'
                    ).then(function(){
                        location.reload(true);
                    })
                    
                }
            },error : function (xhr, ajaxOptions, thrownError){  
                console.log(xhr.status);          
                console.log(thrownError);
            }
        })
    }
});

$("#cbx_municipioplus").on("change",function(){
    municipio = $("#cbx_municipioplus").val();
        if(municipio == 1){
            $("#divotroMunplus").fadeIn();
        }else{
            $("#divotroMunplus").fadeOut();
        }
});

$("#add_mun").on("click",function(){
    ca = $("input[name=clave]").val();
    municipio = $("#cbx_municipioplus").val();
    if(municipio == 1){
        municipio = $("#otromunplus").val();
    }
    if(municipio === null){
        console.log("llena");
    }else if(municipio === ""){
        console.log("llena2");
    }else{
        $.ajax({
            type:"POST",
            url: base_url+"UpdateCaAdmin/addMun/"+ca,
            data:{
                "municipio":municipio,
                "ca":ca
            },success: function(data){
                console.log(data);
                if(data == "nice"){
                    Swal.fire(
                      'Exito',
                      'Se ha agregado correctamente',
                      'success'
                    ).then(function(){
                        location.reload(true);
                    })
                }
            },error: function (xhr, ajaxOptions,thrownError){
                console.log(xhr.status);          
                console.log(thrownError);
            }
        })
    }
});

function elim_mun(id){
    ca = $("input[name=clave]").val();
    $.ajax({
        type:"POST",
        url:base_url+"simpleDelete/municipios_ca/"+id
        ,success: function(data){
            if(data == "nice"){
                Swal.fire(
                    'Exito',
                    'Se ha eliminado correctamente',
                    'success'
                ).then(function(){
                    location.reload(true);
                })
            }
        }, error: function(xhr, ajaxOptions, thrownError){
            console.log(xhr.status);
            console.log(thrownError);
        }
    })
}