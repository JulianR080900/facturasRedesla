let dataTable;
let dataTableIsInitialized = false; 

var parts = document.location.pathname.split('/');
var id = parts.pop() || parts.pop();

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [] },
    { orderable: false, targets: [6,7]},
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
    url: 'getlistacongresosinfo',
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {data: 'nombre'},
    {data: 'red'},
    {data: 'sede'},
    {data: 'fechas'},
    {data: 'anio'},
    {
      data: null,
      render: function(data, type, row){
        if(row.activo == 1){
          return `<a type='btton' href='activo/${row.activo}/${row.id}' class='btn btn-success btn-icon-text btn-rounded'>Activo</a>`;
        }else if(row.activo == 0){
          return `<a type='btton' href='activo/${row.activo}/${row.id}' class='btn btn-danger btn-icon-text btn-rounded'>Inctivo</a>`;
        }else{
          return '<span class="text-danger">Error</span>'
        }
      }
    },
    {
      data: null,
      render: function(data,type,row){
        return `<a href='./ver/${row.id}' class='btn btn-rounded btn-info'>Ver información</a>`
      }
    },
    {
      data: null,
      render: function(data,type,row){
        return `<a type="button" href="editar/${row.id}" class="btn btn-warning btn-icon-text btn-rounded">
        <i class="mdi mdi-lead-pencil"></i> Editar </a>`;
      }
    },
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

  dataTable = $('#dt_congresosinfo').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

}

window.addEventListener('load', async() => {
await initDataTable();
})