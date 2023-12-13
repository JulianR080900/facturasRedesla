
let dataTable;
let dataTableIsInitialized = false; 

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,20,100,200,500,1000,5000],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4] },
    { orderable: false, targets: [3,4]},
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
    url: './getListado',
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {data: 'nombre'},
    {
        data: null,
        render: function(row){
            return `<button class='btn btn-md btn-info direccion' data-direccion='${row.direccion}'>Ver dirección</button>`
        }
    },
    {
        data: null,
        render: function(row){
            return `${row.usuarios_nombre} ${row.usuarios_ap_paterno} ${row.usuarios_ap_materno}`
        }
    },
    {
        data: null,
        render: function(row){
            return `<button class='btn btn-md btn-warning edit' data-id='${row.id}' data-nombre='${row.nombre}' data-direccion='${row.direccion}' >Editar</button>`
        }
    },
    {
        data: null,
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

  dataTable = $('#dt_provedores').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

}

window.addEventListener('load', async() => {
await initDataTable();
})

$(document).on('click','.edit',function(){
    let id = $(this).data('id')
    let nombre = $(this).data('nombre')
    let direccion = $(this).data('direccion')

    $("#nombreEdit").val(nombre)
    $("#direccionEdit").val(direccion)
    $("#idEdit").val(id)

    $("#modalEdit").modal('show');
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
        beforeSend: function(){
            $("#loader").show()
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Listo',
                text: 'Información actualizada correctamente'
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
            $("#modalEdit").modal('hide');
            form[0].reset();
            initDataTable()
        }
    });
})

$(document).on('click','.direccion',function(){
    let direccion = $(this).data('direccion')

    $("#modalBodyDireccion").empty().text(direccion)

    $("#modalDireccion").modal('show');
})

$(document).on('click','.delete',function(){
    let id = $(this).data('id')

    swal.fire({
        icon: 'info',
        text: 'Estas seguro que deseas eliminar este provedor?',
        title: 'Cuidado',
        footer: 'Esta acción no es reversible. Asegurese que este provedor no este en su lista de facturas.',
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
                        text: 'Provedor eliminado correctamente'
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

$(".add").on('click',function(e){
    e.preventDefault()
    $("#modalAdd").modal('show')
})

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
                text: 'Provedor agregado correctamente'
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

