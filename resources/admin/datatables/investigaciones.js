
let dataTable;
let dataTableIsInitialized = false; 

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,5] },
    { orderable: false, targets: [4,5]},
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
    info: 'Registros filtrados de un total de _TOTAL_ registros',
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
    url: '../getListaInvestigacionesEquipos/'+tabla,
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {data: 'claveCuerpo'},
    {data: 'universidad'},
    {data: 'c_encuestas'},
    {data: 'porcentaje'},
    {data: 'estado'},
    {data: 'ver'}
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

  dataTable = $('#dt_inv').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

}

window.addEventListener('load', async() => {
await initDataTable();
})