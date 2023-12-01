let dataTable;
let dataTableIsInitialized = false;

const dataTableOptions = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 15, 20, 100, 200, 500],
  columnDefs: [
    {
      className: "centered",
      targets: [0, 1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12, 15, 16],
    },
    { orderable: false, targets: [13, 14, 15, 16] },
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
    info: "Mostrando en _START_ a _END_ de un total de _TOTAL_ registros",
    infoEmpty: "Ningun registro encontrado",
    infoFiltered: "(filtrados desde _MAX_ registros totales)",
    search: "Buscar 🔎",
    loadingRecords: "Cargando...",
    processing: 'Cargando...',
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
    url: base_url + "/admin/cuerpos/getListado",
    type: "get",
  },
  columns: [
    {
      data: null,
      render: function (data, type, row) {
        if (row.medio_entero === null) {
          return '<span class="text-danger">No registrado</span>';
        } else {
          let val = row.medio_entero;
          return val.toUpperCase();
        }
      },
    },
    { data: "id" },
    { data: "redCueCa" },
    { data: "claveCuerpo" },
    { data: "nombre_institucion" },
    { data: "zona_estudio" },
    { data: "nombre_lider" },
    { 
      /* tipo_registro */
      data: null,
      render: function(data,type,row){
        if(row.tipo_registro){
          return row.tipo_registro
        }else{
          return `No registrado`
        }
      }
     },
    { data: "tel_lider" },
    { data: "correo_lider" },
    { data: "correo_inst_lider" },
    { 
      /* PRODEP */
      data: null,
      render: function(data,type,row){
        if(row.prodep){
          return row.prodep
        }else{
          return `No aplica`
        }
      }
    },
    { data: "nombre_rector" },
    { data: "grado_rector" },
    {
      /* activo */
      data: null,
      render: function(row){
        if(row.activo == 1){
          return `<a type="button" href="updateActivo/${row.activo}/${row.claveCuerpo}" class="btn btn-success btn-icon-text btn-rounded"><i class="mdi mdi-check-circle"></i> Activo </a>`
        }else{
          return `<a type="button" href="updateActivo/${row.activo}/${row.claveCuerpo}" class="btn btn-danger btn-icon-text btn-rounded"><i class="mdi mdi-file-excel-box"></i> Inhabilitado </a>`
        }
      }
    },
    {
      /* editar */
      data: null,
      render: function(row){
        return `<a type="button" href="editar/${row.id}" class="btn btn-warning btn-icon-text btn-rounded"><i class="mdi mdi-lead-pencil"></i> Editar </a>`
      }
    },
    {
      /* Renovar cuerpo para otro año */
      data:null,
      render: function(row){
        return `<a class='btn btn-info btn-rounded disabled' href='cambioMiembros/" . $c['id'] . "' >Proximamente</a>`
      }
    },
    {
      /* Eliminar */
      data: null,
      render: function(row){
        return `<a class="btn btn-danger btn-icon-text btn-rounded deleteCa" href="eliminar" data-clave="${row.claveCuerpo}" ><i class='mdi mdi-delete'></i>Eliminar cuerpo académico</a>`
      }
    },
  ],
  dom: "lBfrtip", //lBfrtip
  buttons: [
    {
      extend: "excelHtml5",
      text: 'Descargar Excel <iclass="mdi mdi-file-excel"></iclass=>',
      titleAttr: "Exportar a Excel",
      className: "btn btn-success",
      exportOptions: {
        modifier: {
          page: "current",
        },
      },
      customize: function (xlsx) {
        var sheet = xlsx.xl.worksheets["sheet1.xml"];
        $("row:first c", sheet).attr("s", "7");
      },
    },
  ],
};

const initDataTable = async () => {
  if (dataTableIsInitialized) {
    dataTable.destroy();
  }

  dataTable = $("#"+tableID).DataTable(dataTableOptions);

  dataTableIsInitialized = true;
};

window.addEventListener("load", async () => {
  await initDataTable();
});