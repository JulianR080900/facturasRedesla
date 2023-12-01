
let dataTable;
let dataTableIsInitialized = false; 

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4,5] },
    { orderable: false, targets: [2,4,5]},
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
    url: '../getListadoCuestionarios/'+nombre_investigacion,
    type: 'get'
  },
  columns: [
    {data: 'folio'},
    {data: 'nombre_encuestador'},
    {data: 'estado'},
    {data: 'nc'},
    {data: 'entrevista'},
    {data: 'editar'}
  ]
}

const initDataTable = async()=>{
  if(dataTableIsInitialized){
    dataTable.destroy();
  }

  dataTable = $('#dt_investigacion').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

}

window.addEventListener('load', async() => {
await initDataTable();
})