
let dataTable;
let dataTableIsInitialized = false; 

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4,5,6,7,8,9,10] },
    { orderable: false, targets: [5]},
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
    url: 'getListadoMovimientos',
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {data: 'id_pago'},
    {data: 'claveCuerpo'},
    {
      /* Movimiento */
      data: null,
      render: function(data, type, row){
        if(row.type_mov){
          return `<span class="text-success">${row.movimiento}</span>`
        }else{
          return `<span class='text-danger'>${row.movimiento}</span>`
        }
      }
    },
    {
      /* Comprobante */
      data: null,
      render: function(data,type,row){
        if(row.is_comprobante){
          return `<a target="_blank" href="../../visualizadorComprobantes/${row.comprobante}"><i class="mdi mdi-file-pdf text-danger" style="font-size: 1.3rem;"></i></a>`
        }else{
          return `<span>No requiere</span>`
        }
      }
    },
    {
      /* Estado */
      data: null,
      render: function(data,type,row){
        if(row.estado == 0){
          return `<a class="btn btn-rounded btn-danger" href="validar/${row.id}">Sin validar</a>`
        }
        if(row.is_comprobante === false){
          return `Sin acciones a realizar`
        }else{
          if(row.facturado == 1 || row.facturado == 0){
            return `<button class="btn btn-rounded btn-success rechazarPago" data-id="${row.id}" >Validado</button>`
          }else{
            return `Sin acciones a realizar`
          }
        }
      }
    },
    {
      /* Facturado */
      data: null,
      render: function(data,type,row){
        if(row.facturado == 0){
          return `<span class='text-info'>Sin solicitar</span>`
        }else if(row.facturado == 1){
          return `<span class='text-warning'>Factura solicitada por el usuario</span>`
        }else if(row.facturado == 2){
          return `<span class='text-success'>Factura emitida</span>`
        }else{
          return `<span class='text-danger'>Sin estado registrado</span>`
        }
      }
    },
    {
      /* Fecha del comprobante */
      data: null,
      render: function(data,type,row){
        if(row.fecha_comprobante === null){
          return `<span>No registrada</span>`
        }else{
          return `<span>${row.fecha_comprobante}</span>`
        }
      }
    },
    {
      /* Fecha de registro */
      data: null,
      render: function(data,type,row){
        if(row.fecha_registro === false){
          return `<span>No requiere</span>`
        }else{
          return `<span>${row.fecha_registro}</span>`
        }
      }
    },
    {
      /* Boton editar */
      data: null,
      render: function(data, type, row){
        if(row.estado == 0 && (row.facturado == 0 || row.facturado == 1) ){
          console.log(row);
          return `<a class="btn btn-rounded btn-warning editarMonto" data-id='${row.id}' data-mov='${row.mov_formated}' >Editar monto</a>`
        }else{
          return `<span>No disponible</span>`
        }
      }
    },
    {
      /* Eliminar */
      data: null,
      render: function(data,type,row){
        if(row.estado == 0 && (row.facturado == 0 || row.facturado == 1) ){
          return `<button type='button' class="btn btn-rounded btn-danger eliminarMovimiento" data-id="${row.id}"> <i class='mdi mdi-alert-box'></i> Eliminar Movimiento</button>`
        }else{
          return `<span>No disponible</span>`
        }
      }
    }
  ],
  dom: 'lBfrtip', //lBfrtip
  buttons: [
    {
      extend: 'excelHtml5',
      text: 'Descargar Excel <iclass="mdi mdi-file-excel"></iclass=>',
      titleAttr: 'Exportar a Excel',
      className: 'btn btn-success',
      exportOptions: {
        modifier: {
          page: "current",
        },
      },
      customize: function (xlsx) {
        var sheet = xlsx.xl.worksheets["sheet1.xml"];
        $("row:first c", sheet).attr("s", "7");
      },
    }
  ],
}

const initDataTable = async()=>{
  if(dataTableIsInitialized){
    dataTable.destroy();
  }

  dataTable = $('#dt_proyectos').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

}

window.addEventListener('load', async() => {
await initDataTable();
})

$(document).on('click', '.eliminarMovimiento', function(e) {
  var id = $(this).data('id')

  Swal.fire({
      icon: 'question',
      title: '¿Estás seguro que deseas eliminar movimiento del pago?',
      html: '<p style="color:red">Esta acción NO es reversible</p><p style="color:gray">Nota: Se eliminarán los comprobantes de movimientos al igual que se cambiará el estado de facturado.</p><p>Se eliminara el siguiente ID: ' + id + '</p><p>Escriba un mensaje para notificar a los cuerpos académicos.</p>',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Elimínalo',
      cancelButtonText: 'Cancelar',
      input: "text",
      inputAttributes: {
      autocapitalize: "off",
      },

  }).then((result) => {
      let mensaje = result.value;
      if (result.isConfirmed) {
          $.ajax({
              type: "POST",
              url: "./eliminarMovimiento",
              data: {id: id},
              success: function(data) {
                  //Aqui vas a hacer una sola alerta
                  console.log(data);
                  if(data == 'error'){
                      Swal.fire(
                      'Lo sentimos!',
                      'Ha ocurrido un error al eliminar el movimiento. Contacte a sistemas',
                      'error'
                      )
                  }else if(data == 'success'){
                      Swal.fire(
                          'ÉXITO',
                          'Se ha eliminado movimiento correctamente.',
                          'success'
                      )
                  }
                  else {
                          // Mostrar el resultado en el div con id "result-container"
                       $('#result-container').html(data);
                      }
                  initDataTable()
              },error:function(jqXHR,textStatus, errorThrown ){
                  //Aqui vas a manejar los errores
                  console.error(jqXHR);
                  console.error(textStatus);
                  console.error(errorThrown);
              }
          });
      }
  });
});

$(document).on('click', '.editarMonto', function(e){
  e.preventDefault();
  let monto = $(this).data('mov')
  let id = $(this).data('id')

  if(!monto){
    return
  }

  $("#monto").val(monto)
  $("#id_mov").val(id)
  $("#modalMonto").modal('show')
})

$("#btnSubmitMonto").on('click',function(e){
  e.preventDefault()
  let monto = $("#monto").val()
  let id_movimiento = $("#id_mov").val()

  if(!monto || !id_movimiento){
    return
  }

  $.ajax({
    type: "POST",
    url: "./updateMov",
    data: {
      monto: monto,
      id_movimiento: id_movimiento
    },
    success: function(data) {
        Swal.fire({
          icon: 'success',
          title: 'Listo',
          text: 'Monto actualizado correctamente'
        }).then(function(){
          $("#monto").val('')
          $("#id_mov").val('')
          $("#modalMonto").modal('hide')
          initDataTable()
        })
    },error:function(jqXHR,textStatus, errorThrown ){
        //Aqui vas a manejar los errores
        Swal.fire({
          icon: "error",
          title: 'Error '+jqXHR.status,
        })
    }
});

})