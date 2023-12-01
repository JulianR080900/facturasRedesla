
let dataTable;
let dataTableIsInitialized = false; 
// Variable para almacenar las filas seleccionadas
var filasSeleccionadas = [];
let enviar = document.getElementById('enviar')

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,20,100,200,500,1000,5000],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4,5,6,7,8,9,10] },
    { orderable: false, targets: [9,10]},
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
    url: 'getListado',
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {data: 'clave_gafete'},
    {data: 'nombre'},
    {
        data: null,
        render: function(data,type,row){
            if(row.claveCuerpo == ''){
                return 'Registrado por administración'
            }else{
                return row.claveCuerpo
            }
        }
    },
    {data: 'submission_id'},
    {
        data: null,
        render: function(data,type,row){
            if(row.oyente == 0){
                return 'No'
            }else{
                return 'Si'
            }
        }
    },
    {data: 'red'},
    {data: 'anio'},
    {data: 'tipo_asistencia'},
    {
        data: null,
        render: function(data,type,row){
            if(row.nombre_congreso == ''){
                return 'No registrado en el momento.'
            }else{
                return row.nombre_congreso
            }
        }
    },
    {
      data: null,
      render: function(data,type,row){
        if(row.isset_asistencia === null){
          return `<span class='text-warning'>Sin constancia de asistencia</span>`
        }else{
          return `<span class='text-success'>${row.isset_asistencia.porcentaje}%</span>`
        }
      }
    }
  ],
  createdRow: function(row, data, dataIndex) {
    // Obtener el ID de la fila actual
    var idFila = data.id; // Reemplaza "data.id" con la propiedad que contiene el ID de la fila en tus datos

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

  dataTable = $('#dt_participantes').DataTable(dataTableOptions);

  dataTableIsInitialized = true;
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