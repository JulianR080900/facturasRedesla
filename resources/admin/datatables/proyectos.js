let dataTable;
let dataTableIsInitialized = false; 
// Variable para almacenar las filas seleccionadas
var filasSeleccionadas = [];
let eliminar = $("#btnEliminarMultiples");
const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4,5,6,7] },
    { orderable: false, targets: [8]},
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
    url: 'getListadoProyectos',
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {data: 'claveCuerpo'},
    {data: 'proyecto'},
    {data: 'monto'},
    {data: 'restante'},
    {
      /* Moneda */
      data: null,
      render: function(data,type,row){
        if(row.moneda == 'MXN'){
          return `<i class="flag-icon flag-icon-mx"></i>`
        }else{
          return `<i class="flag-icon flag-icon-us"></i>`
        }
      }
    },
    {data: 'tipo_registro'},
    {data: 'fecha_registro'},
    {
      /* ver movimientos */
      data: null,
      render: function(data,type,row){
        return `<a type="button" href="movimientos/${row.id}" class="btn btn-info btn-icon-text btn-rounded">
        <i class="mdi mdi-format-list-bulleted"></i> Ver movimientos </a>`
      }
    },
  ],
  createdRow: function(row, data, dataIndex) {
    // Obtener el ID de la fila actual
    var idFila = data.id; // Reemplaza "data.id" con la propiedad que contiene el ID de la fila en tus datos
    // Obtenmos el nombre de la fila actual
   
    // Verificar si la fila actual está seleccionada
    if (filasSeleccionadas.includes(idFila)) {
      // Agregar clase CSS a la fila si está seleccionada
      $(row).addClass('fila-seleccionada').css('background-color','#f0f0f0');
    }
  },
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

  // Evento de clic en una fila
$('#dt_proyectos tbody').on('click', 'tr', function() {
  var idFila = dataTable.row(this).data().id; // Reemplaza "data.id" con la propiedad que contiene el ID de la fila en tus datos
  // Verificar si la fila ya está seleccionada
  if (filasSeleccionadas.includes(idFila)) {
    // Si está seleccionada, quitarla de las filas seleccionadas y quitar la clase CSS
    var index = filasSeleccionadas.indexOf(idFila);
    filasSeleccionadas.splice(index, 1);
    $(this).removeClass('fila-seleccionada').css('background-color', 'transparent');
  } else {
    // Si no está seleccionada, agregarla a las filas seleccionadas y agregar la clase CSS
    filasSeleccionadas.push(idFila);
    $(this).addClass('fila-seleccionada').css('background-color', '#fff');
  }
});
eliminar.click(function(){
  if(filasSeleccionadas.length <= 0){
    Swal.fire({
      icon: 'warning',
      title: 'Seleccione al menos 1 proyecto a eliminar.'
    })
    return
  }        
  Swal.fire({
    title: '¿Estas seguro que desea eliminar los proyectos?',
    html: '<p>Los proyectos que seran eliminados son los siguientes: </p><p>'+filasSeleccionadas+'</p>',
    footer: '<span class="text-center">Se eliminaran tambien los movimientos y constancias que estén ligados</span>',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
}).then((result) => {
    if (result.isConfirmed) {

      var screen = $("#loader")
      loaderScreen(screen)
         // Enviar los IDs seleccionados mediante una solicitud POST
         
          $.ajax({
              type: "POST",
              dataType: 'json',
              url: "eliminarmultiple",
              data: { 
                id: filasSeleccionadas, 
              },
              success: function(data) {
                Swal.fire({
                  icon: 'success',
                  title: data.title,
                  text: data.text
                }).then(function(){
                  initDataTable()
                })
              
            },
            error: function(jqXHR){
              console.log(jqXHR);
              Swal.fire({
                icon: 'error',
                title: 'Error '+jqXHR.status,
                text: jqXHR.responseText
              })
            }

          });
    }
});
})
}

window.addEventListener('load', async() => {
await initDataTable();
})

function loaderScreen(screen){
  $(document)
  .ajaxStart(function(){
    screen.fadeIn();
  })
  .ajaxStop(function(){
    screen.fadeOut()
  })
}