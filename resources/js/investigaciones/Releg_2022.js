$(document).on('click', '#eliminar', function(e) {
    var productId = $(this).data('id');
    SwalDelete(productId);
    e.preventDefault();
});

$(document).on('click', '#eliminarCategoria', function(e) {
    var productId = $(this).data('id');
    SwalDelete(productId);
    e.preventDefault();
});

$(document).on("click", "#recapturar", function(e) {
    var id = $(this).data('id');
    recapturar(id);
    e.preventDefault();
});

$(document).on("click", "#editar", function(e) {
    var id = $(this).data('id');
    editar(id);
    e.preventDefault();
});

$(document).on('click', '#terminar', function(e) {
    var proyecto = $("#nombre_proyecto").val();
    terminarProceso(proyecto);
    e.preventDefault();
});

$(document).on('click', '#volverValidar', function(e) {
    var proyecto = $("#nombre_proyecto").val();
    volverValidar(proyecto);
    e.preventDefault();
});

$(document).on('click','#terminar2dafase', function(){
    var proyecto = $("#nombre_proyecto").val();
    terminarProceso2daFase(proyecto);
    e.preventDefault();
});

$(document).on('click', '#volverValidar2', function(e) {
    var proyecto = $("#nombre_proyecto").val();
    volverValidar2(proyecto);
    e.preventDefault();
});

$(document).on('click', '#eliminarCodigos', function(e) {
    var claveCuerpo = $(this).data('clave');
    deleteCategorizacion(claveCuerpo);
    e.preventDefault();
});

function SwalDelete(productId) {

    swal.fire({
        title: '¿Estas seguro?',
        text: "Se eliminará la entrevista junto con su bitácora. Esta acción no se puede deshacer",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, bórralo!',
        showLoaderOnConfirm: true,

        preConfirm: function() {
            return new Promise(function(resolve) {

                $.ajax({
                        url: base_url + "/borrarEntrevista/" + productId,
                        type: 'POST',
                        dataType: 'json'
                    })
                    .done(function(response) {
                        swal.fire('Eliminado!', response.message, response.status).then(function() {
                            location.reload();
                        })
                        //redireccionar
                    })
                    .fail(function() {
                        swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
                    });
            });
        },
        allowOutsideClick: false
    });

}

function terminarProceso(proyecto) {

    swal.fire({
        icon: 'warning',
        title: '¿Desea terminar el proceso de captura de entrevistas?',
        text: 'Esta acción no es reversible',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',

        preConfirm: function() {
            return new Promise(function(resolve) {

                $.ajax({
                        url: base_url + "/validacionRelmo/" + proyecto,
                        type: 'POST',
                        dataType: 'json'
                    })
                    .done(function(response) {
                        console.log(response);
                        swal.fire('¡Importante!', response.message, response.status).then(function() {
                            location.reload();
                        })
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                        swal.fire('Oops...', 'Algo salió mal !', 'error');
                    });
            });
        },
        allowOutsideClick: false
    });

}

function recapturar(id) {
    $.ajax({
            url: base_url + "/takeid",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            }
        })
        .done(function(response) {
            if (response == 'nais') {
                window.location.href = base_url + "/recapturarEntrevista";
            } else {
                swal.alert({
                    icon: 'error',
                    title: 'Ha ocurrido un error. Intente mas tarde nuevamente',
                    footer: '¿El problema persiste? Contacte al siguiente correo: jaramosp@e.redesla.net'
                })
            }
            //window.location.href = base_url + "recapturarEntrevista";
            //redireccionar
        })
        .fail(function() {
            swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
        });

}

function editar(id) {
    console.log('entra');
    $.ajax({
            url: base_url + "/takeid",
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            }
        })
        .done(function(response) {
            if (response == 'nais') {
                window.location.href = base_url + "/editarEntrevista";
            } else {
                swal.alert({
                    icon: 'error',
                    title: 'Ha ocurrido un error. Intente mas tarde nuevamente',
                    footer: '¿El problema persiste? Contacte al siguiente correo: jaramosp@e.redesla.net'
                })
            }
            //window.location.href = base_url + "recapturarEntrevista";
            //redireccionar
        })
        .fail(function() {
            swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
        });

}

function volverValidar(proyecto) {

    swal.fire({
        icon: 'warning',
        title: '¿Desea reenviar el proceso de recaptura de entrevistas?',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',

        preConfirm: function() {
            return new Promise(function(resolve) {

                $.ajax({
                        url: base_url + "/validacionRelmo/" + proyecto,
                        type: 'POST',
                        dataType: 'json'
                    })
                    .done(function(response) {
                        console.log(response);
                        swal.fire('¡Importante!', response.message, response.status).then(function() {
                            location.reload();
                        })
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                        swal.fire('Oops...', 'Algo salió mal !', 'error');
                    });
            });
        },
        allowOutsideClick: false
    });

}

function terminarProceso2daFase(proyecto){
    swal.fire({
        icon: 'warning',
        title: '¿Desea terminar el proceso de categorización?',
        text: 'Esta acción no es reversible',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',

        preConfirm: function() {
            return new Promise(function(resolve) {

                $.ajax({
                        url: base_url + "/validacionRelmo/" + proyecto,
                        type: 'POST',
                        dataType: 'json'
                    })
                    .done(function(response) {
                        console.log(response);
                        swal.fire('¡Importante!', response.message, response.status).then(function() {
                            location.reload();
                        })
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                        swal.fire('Oops...', 'Algo salió mal !', 'error');
                    });
            });
        },
        allowOutsideClick: false
    });
}

function volverValidar2(proyecto) {

    swal.fire({
        icon: 'warning',
        title: '¿Desea reenviar el proceso de categorización?',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',

        preConfirm: function() {
            return new Promise(function(resolve) {

                $.ajax({
                        url: base_url + "/validacionRelmo/" + proyecto,
                        type: 'POST',
                        dataType: 'json'
                    })
                    .done(function(response) {
                        console.log(response);
                        swal.fire('¡Importante!', response.message, response.status).then(function() {
                            location.reload();
                        })
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                        swal.fire('Oops...', 'Algo salió mal !', 'error');
                    });
            });
        },
        allowOutsideClick: false
    });

}

function SwalDelete(productId) {

    swal.fire({
    title: '¿Estas seguro?',
    text: "Se eliminará la propuesta de categoría. Esta acción no se puede deshacer",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, bórralo!',
    showLoaderOnConfirm: true,

    preConfirm: function() {
        return new Promise(function(resolve) {

            $.ajax({
                    url: base_url + "/generalDelete/categorias",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id:productId
                    }
                })
                .done(function(response) {
                    swal.fire('Eliminado!', response.message, response.status).then(function() {
                        location.reload();
                    })
                    //redireccionar
                })
                .fail(function(e) {
                    console.log(e);
                    swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
                });
        });
    },
    allowOutsideClick: false
    });
}

function deleteCategorizacion(claveCuerpo){
    swal.fire({
    title: '¿Estas seguro?',
    text: "Se eliminarán todos las categorizaciones que se hayan registrado. Esta acción no se puede deshacer",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, bórralo!',
    cancelButtonText: 'Cancelar',
    showLoaderOnConfirm: true,

    preConfirm: function() {
        return new Promise(function(resolve) {

            $.ajax({
                    url: base_url + "/deleteCategorias",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        claveCuerpo:claveCuerpo
                    }
                })
                .done(function(response) {                            
                    swal.fire('Eliminado!', response.message, response.status).then(function() {
                        location.reload();
                    })
                    
                    //redireccionar
                })
                .fail(function(e) {
                    console.log(e);
                    swal.fire('Oops...', 'Algo salió mal con ajax !', 'error');
                });
        });
    },
    allowOutsideClick: false
    });
}

$("#editarPropuesta").on('click',function(){
    var nombre = $(this).data('nombre');
    var descripcion = $(this).data('descripcion');
    var codigo = $(this).data('codigo');
    var id = $(this).data('id');

    $("#nombreEdit").val(nombre);
    $("#descripcionEdit").val(descripcion);
    $("#codigo_en_vivo_edit").val(codigo);
    $("#id_edit_propuesta").val(id);
})

$(document).ready(function(){
    $("#btn_discusion").prop('disabled',true)
    let date = new Date().toISOString().slice(0, 10);
    date = date.split('-').join("")
    let path = window.location.pathname
    let split = path.split('/')
    let proyecto = split[3]
    let split_proyecto = proyecto.split('_')  
  
    if(date > '20230602'){
      //Deshabilitar
      $("#btnAnalisis")
      .addClass('disabled')
      .prop('title','El tiempo para registrar el proceso de análisis de resultados. Agradecemos su comprensión.')
      .text('El tiempo para registrar el proceso de análisis de resultados. Agradecemos su comprensión. Fecha límite alcanzada.')
      .prop('href','')
      .css('white-space', 'pre-wrap')
      return
  }
  
  
  })

  const textarea = document.getElementById('discusion');
        const contador = document.getElementById('contador-caracteres');

        textarea.addEventListener('input', function() {
            const longitud = textarea.value.length;
            if(longitud < 1300){
                contador.style.color = 'red'
                $("#btn_discusion").prop('disabled',true)
            }else{
                contador.style.color = 'lightgreen'
                $("#btn_discusion").prop('disabled',false)
            }
            contador.textContent = longitud + ' / 2000 caracteres';
        });
  