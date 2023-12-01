
let dataTable;
let dataTableIsInitialized = false; 

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4] },
    { orderable: false, targets: [2,3,4]},
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
  serverSide:true,
  processing: true,
  ajax: {
    url: './getListadoDimensiones',
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {data: 'nombre'},
    {
        data: null,
        render: function(data, type, row){
            return `<a class="btn btn-primary btn-rounded descripcion" data-toggle="modal" data-target="#myModal" data-descripcion="${row.descripcion}">Ver descripcion</a>`
        }
    },
    {
      data: null,
      render: function(data,type,row){
        let res = ''
        if(data.escalas.length == 0){
          res = 'na'
        }else{
          for (let index = 0; index < data.escalas.length; index++) {
            res += data.escalas[index]['nombre']+';'
          }
        }
        return `<a class="btn btn-info btn-rounded escalas" data-toggle="modal" data-target="#myModalEscalas" data-escalas="${res}">Ver escalas</a>`
      }
    },
    {
        data: null,
        render: function(data, type, row){
            return `<a href="editar/${row.id}" class="btn btn-warning btn-icon-text btn-rounded"><i class="mdi mdi-lead-pencil btn-icon-prepend"></i> Editar </a>`
        }
    },
    {
        data: null,
        render: function(data, type, row){
            return `<button class="btn btn-rounded btn-danger eliminarGrupo" data-id="${row.id}">Eliminar</button>`
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

  dataTable = $('#dt_grupos').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

}

window.addEventListener('load', async() => {
await initDataTable();
})

$(document).on('click', '.eliminarGrupo', function(e) {
    var id = $(this).data('id')

    Swal.fire({
        title: '¿Estas seguro que desea eliminar esta dimensión?',
        html: '<p style="color:red">Esta accion NO es reversible</p>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        footer: '<span class="text-sm-center">Las categorias que tengan asigado esta dimensión se desasignaran y se tendrán que asignar de nuevo una dimensión a las categorias afectadas.</span>'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "./eliminar",
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function(data) {
                  console.log(data);
                  Swal.fire({
                    icon: 'success',
                    title: data.title,
                    text: data.text
                  }).then(function(){
                    initDataTable()
                  })
                    
                },
                error: function(jqXHR){
                  Swal.fire({
                      icon: 'danger',
                      title: 'Error '+jqXHR.status,
                      text: jqXHR.responseText
                  })
                }
            });

        }
    });
});