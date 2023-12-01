
let dataTable;
let dataTableIsInitialized = false; 

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4,5,6,7] },
    { orderable: false, targets: [3,4,5,6,7]},
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
    url: base_url+'/admin/categorias/digitales/getListadoCategorias',
    type: 'get'
  },
  columns: [
    {data: 'id'},
    {data: 'nombre'},
    {
        data: null,
        render: function(data, type, row){
            if(row.claveCuerpo == ''){
                return 'Administración'
            }else{
                return row.claveCuerpo
            }
        }
    },
    {
        data: null,
        render: function(data, type, row){
            return `<a class="btn btn-primary btn-rounded descripcion" data-toggle="modal" data-target="#myModal" data-descripcion="${row.descripcion}">Ver descripcion</a>`
        }
    },
    {
        data: null,
        render: function(data, type, row){
            return `'<a class="btn btn-info btn-rounded codigo" data-toggle="modal" data-target="#myModal" data-codigo="${row.codigo_en_vivo}">Ver código en vivo</a>`
        }
    },
    {
        data: null,
        render: function(data,type, row){
            if(row.grupo == '' || row.grupo == 0){
                return `<button data-toggle='modal' data-target='#modalGrupo' data-id='${row.id}' class='btn btnGrupo'>Sin asignar</button>`
            }else{
              return `<button data-toggle='modal' data-target='#modalGrupo' data-id='${row.id}' class='btn btnGrupo'>${row.grupo}</button>`
            }
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
            if(row.claveCuerpo == ''){
                return `<button type="button" class="btn btn-rounded btn-danger" disabled><i class="mdi mdi-delete"></i></button>`
            }else{
                return `<a href="eliminar/${row.id}" class="btn btn-rounded btn-danger"><i class="mdi mdi-delete"></i></a>`
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

  dataTable = $('#dt_categorias').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

}

window.addEventListener('load', async() => {
await initDataTable();
})

$("#formAct").on('submit', function(e){
  e.preventDefault()

  const formData = $(this).serializeArray();

  $.ajax({
    type: 'post',
    dataType: 'json',
    data: formData,
    url: './actualizarGrupo',
    beforeSend: function(){
        $("#submit").prop('disabled',true);
    },
    success: function(data){
      $("#submit").prop('disabled',false);
        Swal.fire({
            icon: 'success',
            title: data.title,
            text: data.text
        }).then(function(){
          $("#modalGrupo").modal('hide')
            initDataTable()
        })
    },
    error: function(jqXHR){
        $("#submit").prop('disabled',false);
        Swal.fire({
            icon: 'danger',
            title: 'Error '+jqXHR.status,
            text: jqXHR.responseText
        })
    }
  })
})

$(document).on('click', '.btnGrupo', function(){
  let id = $(this).data('id')
  $("#id").val(id)
})

$("#diagrama").on('click', function(){
  $.ajax({
    type: 'post',
    dataType: 'json',
    url: './diagrama',
    success: function(data){
      console.log(data);
    },
    error: function(jqXHR){
        Swal.fire({
            icon: 'danger',
            title: 'Error '+jqXHR.status,
            text: jqXHR.responseText
        })
    }
  })
})