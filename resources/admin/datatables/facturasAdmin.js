let dataTable;
let dataTableIsInitialized = false; 

var parts = document.location.pathname.split('/');
var id = parts.pop() || parts.pop();

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4,5,6] },
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
    url: './getListadoFacturas/',
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {
      data: null,
      render: function(row){
        return `${row.monto} ${row.moneda} <i class="flag-icon flag-icon-${row.moneda == 'MXN' ? 'mx' : 'us'}"></i>`
      }
    },
    {
      data: null,
      render: function(row){
        if(row.provedores_nombre == null){
          return `<span class='text-warning'>${row.provedor}</span>`
        }else{
          return row.provedores_nombre
        }
      }
    },
    {
      data: null,
      render: function(row){
        console.log(row);
        if(row.metodos_pago_nombre == null){
          return `<span class='text-warning' >${row.metodo_pago}</span>`
        }else{
          return row.metodos_pago_nombre
        }
      }
    },
    {
      data: null,
      render: function(row){
        console.log(row);
        return `${row.monto} ${row.moneda} <i class="flag-icon flag-icon-${row.moneda == 'MXN' ? 'mx' : 'us'}"></i>`
      }
    },
    {
        data: null,
        render: function(row){
          return `
          <a href='./downloadBlobFiles/pdf/${row.id}' title='Descargar'> <i class="fa-solid fa-file-pdf" style='font-size: 2rem; color: #b51308'></i> </a>
          <a target='_blank' href='./viewBlobFiles/pdf/${row.id}' title='Ver'> <i class="fa-solid fa-eye" style='font-size: 2rem; color: #fff'></i> </a>
          `
        }
      },
    {data: 'fecha_pago'},
    {data: 'fecha_factura'},
    {data: 'fecha_insert'}
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

  dataTable = $('#dt_facturas').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

}

window.addEventListener('load', async() => {
await initDataTable();
})