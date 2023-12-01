let dataTable;
let dataTableIsInitialized = false;

const dataTableOptions = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 15, 20, 100, 200, 500],
  columnDefs: [
    { className: "centered", targets: [0,1,2,3,4,5] },
    { orderable: false, targets: [5] },
    //{ width: '50%', targets: [0]},
    //{ sercheable: false, targets: [2]} //Quita el buscar en esas columnas
  ],
  rowReorder: {
    selector: "td:nth-child(2)",
  },
  responsive: true,
  pageLength: 10, //Numero de registros por pagina
  destroy: true, //Decimos que la tabla es destruible
  language: {
    lengthMenu: "Mostrar _MENU_ registros por página",
    zeroRecords: "Ningun registro encontrado",
    info: "Registros filtrados de un total de _TOTAL_ registros",
    infoEmpty: "Ningun registro encontrado",
    infoFiltered: "(filtrados desde _MAX_ registros totales)",
    search: "Buscar 🔎",
    loadingRecords: "Cargando...",
    paginate: {
      first: "Primero",
      last: "Último",
      next: "Siguiente",
      previous: "Anterior",
    },
  },
  serverSide: true,
  processing: true,
  ajax: {
    url: "./getListaCartas",
    type: "post",
  },
  columns: [
    {data: 'id'},
    {
      data: null,
      render: function(row){
        if(row.tipo == 'derechos'){
          return `Carta de sesión de derechos`
        }else if(row.tipo == 'visto'){
          return `Carta de visto bueno`
        }else{
          return `error`
        }
      }
    },
    {data: 'obra'},
    {data: 'red'},
    {data: 'anio'},
    {
        data: null,
        render: function(row){
            return `<a href='./downloadDerechos/${row.red}/${row.anio}/${row.obra}/${row.tipo}'><i class='mdi mdi-download' style='font-size: 1.5rem'></i></a>`
        }
    }
  ],
};

const initDataTable = async () => {
  if (dataTableIsInitialized) {
    dataTable.destroy();
  }

  dataTable = $("#dt_cartas_derechos").DataTable(dataTableOptions);

  dataTableIsInitialized = true;
};

window.addEventListener("load", async () => {
  await initDataTable();
});

$(".addDerechos").on('click',function(e){
    e.preventDefault()
    $("#modalDerechos").modal('show')
})