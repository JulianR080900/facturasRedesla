
let dataTable;
let dataTableIsInitialized = false; 
// Variable para almacenar las filas seleccionadas
var filasSeleccionadas = [];
let enviar = $("#enviar");

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,20,100,200,500,1000,5000],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4,5] },
    { orderable: false, targets: []},
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
    {data: 'submissison_id'},
    {data: 'congreso'},
    {
        data: null,
        render: function(data, type, row, meta){
            return `<button data-toggle='modal' data-target='#modalMesa' data-id='${row.id}' data-mesa='${row.val_mesa}' class='btn btnMesa'>${row.mesa}</button>`
        }
    },
    {
        data: 'tipo_registro',
        render: function(data){
            return data.toUpperCase()
        }
    },
    {
      data: 'clave_ponencia'
    },
    {
      data: 'ponencia',
      render: function(data, type, row, meta) {
        // Truncar el texto y agregar puntos suspensivos
        var texto_truncado = data.substring(0, 100) + '...';
        return `
        <div class="texto-truncado" title="${data}">
        ${texto_truncado}
        </div>`;
      }
    },
    {data: 'ponente'}
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

  dataTable = $('#dt_ponencias').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

  $('#dt_ponencias tbody').on('click', '.texto-truncado', function () {
    // Obtener el objeto de celda correspondiente al texto truncado
    const cell = dataTable.cell($(this).parent());
  
    // Obtener el valor completo de la celda
    const fullText = cell.data();
  
    // Ocultar el tooltip
    $(this).attr('title', '');
  
    // Mostrar el texto completo
    $(this).text(fullText);
  
    // Agregar una clase CSS al elemento para indicar que se ha mostrado el texto completo
    $(this).addClass('texto-completo');
  });
  
  $('#dt_ponencias tbody').on('click', '.texto-completo', function () {
    // Obtener el objeto de celda correspondiente al texto completo
    const cell = dataTable.cell($(this).parent());
  
    // Obtener el valor truncado de la celda
    const truncatedText = cell.render('display')
  
    // Restablecer el texto truncado
    $(this).html(truncatedText);
  
    // Eliminar la clase CSS del elemento para indicar que se ha restablecido el texto truncado
    $(this).removeClass('texto-completo');
  });
  

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

$(document).on('click','.btnMesa', function(){
    let id = $(this).data('id')
    let mesa = $(this).data('mesa')

    $("#id").val(id)

    if(mesa != ''){
        $("#mesa option[value="+ mesa +"]").attr("selected",true);
        return
    }
    $("#mesa option:eq(0)").prop("selected", true);
    return;    
})

$("#formAct").on('submit',function(e){
    e.preventDefault()

    let mesa = $("#mesa").val();
    let id = $("#id").val();

    $.ajax({
        type: 'post',
        dataType: 'json',
        url: './update',
        data: {
            mesa: mesa,
            id: id
        },
        success: function(data){
            Swal.fire({
                icon: 'success',
                title: data.title,
                html: data.mensaje
            }).then(function(){
                var filtro = $('#dt_ponencias_filter input').val(); // Obtener el valor del filtro aplicado
                initDataTable(); // Recargar la tabla
                $('#dt_ponencias_filter input').val(filtro); // Restaurar el filtro aplicado
                $('#dt_ponencias').DataTable().search(filtro).draw(); // Aplicar y dibujar el filtro
                $("#modalMesa").modal('hide')
            })
        },
        error: function(jqXHR){
            Swal.fire({
                icon: 'error',
                title: 'Error '+jqXHR.status,
                text: jqXHR.responseText
            })
        }
    })
    
})