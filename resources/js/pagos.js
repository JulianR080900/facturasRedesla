



$("button[name='addPago']").on("click",function() {

    id = this.value;

    $("#id_pago").attr("value",id);

    $("#modalMoldePagos").modal("show");

});



$("#submitId").closest('form').on('submit', function(e) {

    e.preventDefault();

    $('#btnAddProyecto').attr('disabled', true);

    this.submit(); // ahora hace el submit de tu formulario.

});





function funcionMax(q){

    max = $(q).data('max');

    $("#cantidad").attr({

        "max": max,

        "min": 1

    });

}


$("#btnAddProyecto").on('click', async function(e){
  let proyecto = $("#proyecto option:selected").val();

  if(proyecto == ''){
    Swal.fire({
      icon: 'warning',
      title: 'Seleccione un proyecto a registrar'
    });
    return;
  }

  //VAMOS A COMPROBAR SI EL PROYECTO ES DUPLICADO O SI YA SE TIENE UNO IGUAL ANTERIORMENTE

  $.ajax({
    type: 'post',
    dataType: 'json',
    url: './verificarProyecto',
    data: {
      id_proyecto: proyecto
    },
    beforeSend: function(){
      $("#btnAddProyecto").prop('disabled', true);
    },
    success: async function(data){
      if(data == 200){
        try {
          let isInserted = await insertProyecto(proyecto);

          Swal.fire({
            icon: 'success',
            title: isInserted.title,
            text: isInserted.text
          }).then(function(){
            location.reload()
          })
        } catch (error) {
          $("#btnAddProyecto").prop('disabled', false);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message
          });
        }
      }
    },
    error: function(jqXHR){
      $("#btnAddProyecto").prop('disabled', false);
      Swal.fire({
        icon: 'error',
        title: 'Error '+jqXHR.status,
        text: jqXHR.responseText
      });
    }
  });
});

function insertProyecto(proyecto){
  return new Promise(function(resolve, reject){
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: './insert',
      data: {
        id_proyecto: proyecto
      },
      success: function(data){
        resolve(data);
      },
      error: function(jqXHR){
        reject(new Error(jqXHR.responseText));
      }
    });
  });
}


$(".btnEliminarPago").on('click',function(e){
  e.preventDefault();

  let id = $(this).data('id')

  Swal.fire({
    icon: "warning",
    title: "¿Esta seguro que desea eliminar este proyecto?",
    text: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "./delete",
        type: "post",
        dataType: "json",
        data: {
          id:id
        },
        beforeSend: function(){
          $("#loader").show()
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Proyecto eliminado correctamente.",
          }).then(function () {
            location.reload();
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          });
        },
        complete: function(){
          $("#loader").hide()
        }
      });
    }
  });
})
