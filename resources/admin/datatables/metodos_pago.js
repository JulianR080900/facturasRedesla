let dataTable;
let dataTableIsInitialized = false; 

var parts = document.location.pathname.split('/');
var id = parts.pop() || parts.pop();

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4] },
    { orderable: false, targets: [1,2]},
    //{ width: '50%', targets: [0]},
    //{ sercheable: false, targets: [2]} //Quita el buscar en esas columnas

  ],
  rowReorder: {
    selector: 'td:nth-child(2)'
  },
  responsive: true,
  pageLength: 10, //Numero de registros por pagina
  destroy: true, //Decimos que la tabla es destruible
  language: {
    lengthMenu: 'Mostrar _MENU_ registros por página',
    zeroRecords: 'Ningun registro encontrado',
    info: 'Mostrando en _START_ a _END_ de un total de _TOTAL_ registros',
    infoEmpty: 'Ningun registro encontrado',
    infoFiltered: '(filtrados desde _MAX_ registros totales)',
    search: 'Buscar 🔎',
    loadingRecords: 'Cargando...',
    paginate: {
      first: 'Primero',
      last: 'Último',
      next: 'Siguiente',
      previous: 'Anterior'
    }
  },
  serverSide: true,
  processing: true,
  ajax: {
    url: './getListado/',
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {data: 'nombre'},
    {data: 'numero'},
    {data: 'tipo_tarjeta'},
    {
        data: null,
        render: function(row){
          return `${row.usuarios_nombre} ${row.usuarios_ap_paterno} ${row.usuarios_ap_materno}`
        }
    },
    {data:'fecha_registro'},
    {
        data:null,
        render: function(row){
            return `<button class='btn btn-md btn-warning edit' data-id='${row.id}' data-nombre='${row.nombre}' data-numero='${row.numero}' data-tipo='${row.tipo_tarjeta}'  >Editar</button>`
        }
    },
    {
        data:null,
        render: function(row){
            return `<button class='btn btn-md btn-danger delete' data-id='${row.id}' >Eliminar</button>`
        }
    }
  ],
}

const initDataTable = async()=>{
  if(dataTableIsInitialized){
    dataTable.destroy();
  }

  dataTable = $('#dt_metodos').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

}

window.addEventListener('load', async() => {
await initDataTable();
})

$(document).on('click','.agregar',function(e){
    e.preventDefault()
    $("#modalAdd").modal('show')
})

$('.numero').mask("9999 9999 9999 9999");

$("#formAdd").on('submit',function(e){
    e.preventDefault()
    var formDataArray = $(this).serializeArray();
    var formDataObject = {};
    formDataArray.forEach(function(input) {
        formDataObject[input.name] = input.value;
    });
    var form = $(this)
    $.ajax({
        type: "POST",
        url: "./add", // URL a la que enviar los datos
        data: formDataObject, // Datos a enviar
        dataType: 'json',
        beforeSend: function(){
            $("#loader").show()
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Listo',
                text: 'Método de pago agregado correctamente'
            })
        },
        error: function(jqXHR) {
            Swal.fire({
                icon: 'error',
                title: 'Ha ocurrido un problema',
                text: jqXHR.responseText
            })
        },
        complete: function(){
            $("#loader").hide()
            $("#modalAdd").modal('hide');
            form[0].reset();
            initDataTable()
        }
    });
})


$(document).on('click','.edit',function(e){
  e.preventDefault()
  let id = $(this).data('id')
  let nombre = $(this).data('nombre')
  let numero = $(this).data('numero')
  let tipo = $(this).data('tipo')

  $("#nombre_edit").val(nombre)
  $("#numero_edit").val(numero)
  $('#tipo_tarjeta_edit option[value="'+tipo+'"]').attr("selected", "selected");
  $("#id").val(id)

  $("#modalEdit").modal('show')

})

$("#formEdit").on('submit',function(e){
  e.preventDefault()
  var formDataArray = $(this).serializeArray();
  var formDataObject = {};
  formDataArray.forEach(function(input) {
      formDataObject[input.name] = input.value;
  });
  var form = $(this)
  $.ajax({
      type: "POST",
      url: "./update", // URL a la que enviar los datos
      data: formDataObject, // Datos a enviar
      dataType: 'json',
      beforeSend: function(){
          $("#loader").show()
      },
      success: function(response) {
          Swal.fire({
              icon: 'success',
              title: 'Listo',
              text: 'Método de pago actualizado correctamente'
          })
      },
      error: function(jqXHR) {
          Swal.fire({
              icon: 'error',
              title: 'Ha ocurrido un problema',
              text: jqXHR.responseText
          })
      },
      complete: function(){
          $("#loader").hide()
          $("#modalEdit").modal('hide');
          form[0].reset();
          initDataTable()
      }
  });
})

$(document).on('click','.delete',function(){
  let id = $(this).data('id')

  swal.fire({
      icon: 'info',
      text: 'Estas seguro que deseas eliminar este método de pago?',
      title: 'Cuidado',
      footer: 'Esta acción no es reversible. Asegurese que este método de pago no este en su lista de facturas.',
      confirmButtonText: 'Si, estoy seguro',
      cancelButtonText: 'Cancelar',
      showCancelButton: true
  }).then( (result) => {
      if(result.isConfirmed){
          $.ajax({
              type: "POST",
              url: "./delete", // URL a la que enviar los datos
              data: {
                  id:id
              }, // Datos a enviar
              beforeSend: function(){
                  $("#loader").show()
              },
              success: function(response) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Listo',
                      text: 'Método de pago eliminado correctamente'
                  })
              },
              error: function(error) {
                  Swal.fire({
                      icon: 'error',
                      title: 'Lo sentimos',
                      text: 'Ha ocurrido un error, contacte a sistemas'
                  })
              },
              complete: function(){
                  $("#loader").hide()
                  initDataTable()
              }
          });
      }
  })
})

$(".check_na").on('click',function(){
  if( $(this).prop('checked') ){

    $('.numero').prop('disabled',true).prop('placeholder','NA')
    $('.numero').val('')
  
  }else{
    $('.numero').prop('disabled',false).prop('placeholder','xxxx xxxx xxxx xxxx')
    $('.numero').val('')
  }
})