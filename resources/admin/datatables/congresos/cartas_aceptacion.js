
let dataTable;
let dataTableIsInitialized = false; 
// Variable para almacenar las filas seleccionadas
var filasSeleccionadas = [];
let enviar = $("#enviar");

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,20,100,200,500,1000,5000],
  columnDefs: [
    { className: 'centered', targets: [0,1,2] },
    { orderable: false, targets: [1,2]},
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
    {
      data: 'nombre',
      render: function(data, type, row, meta) {
        // Truncar el texto y agregar puntos suspensivos
        if(data == 'Inexistente'){
          return `<div class='text-danger'>Información no encontrada</div>`
        }
        var texto_truncado = data.substring(0, 100) + '...';
        return `
        <div class="texto-truncado" title="${data}">
        ${texto_truncado}
        </div>`;
      }
    },
    {
      data: 'autor',
      render: function(data, type, row, meta){
        return data ? data.toUpperCase() : '<div class="text-danger">Información no encontrada</div>'
      }
    },
    {
      data: 'enviado',
      render: function(data,row){
        if(data == 1){
          return `<span class="text-success">Carta enviada</span>`
        }else{
          return '<span class="text-warning">Sin enviar</span>'
        }
      }
    },
    {
      data: null,
      render: function(data,type,row){
        if(row.enviado == 1){
          return `<button class="btn btn-rounded btn-danger cancelar" data-id='${row.id}'>Cancelar envío</button>`;
        }else{
          return '<span class="text-warning">Sin acciones adjuntas</span>';
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

  // Evento de clic en una fila
  $('#dt_ponencias tbody').on('click', 'tr', function() {

    var idFila = dataTable.row(this).data().id; // Reemplaza "data.id" con la propiedad que contiene el ID de la fila en tus datos
    let nombre = dataTable.row(this).data().nombre;
    let autor = dataTable.row(this).data().autor;
    let enviado = dataTable.row(this).data().enviado;

    if(nombre == 'Inexistente' || !autor || enviado == 1){
      return;
    }
    // Verificar si la fila ya está seleccionada
    if (filasSeleccionadas.includes(idFila)) {
      // Si está seleccionada, quitarla de las filas seleccionadas y quitar la clase CSS
      var index = filasSeleccionadas.indexOf(idFila);
      filasSeleccionadas.splice(index, 1);
      $(this).removeClass('fila-seleccionada').css('background-color', 'transparent');
    } else {
      // Si no está seleccionada, agregarla a las filas seleccionadas y agregar la clase CSS
      filasSeleccionadas.push(idFila);
      $(this).addClass('fila-seleccionada').css('background-color', '#fff');
    }
  });

  enviar.click(function(){

    if(filasSeleccionadas.length <= 0){
      alert('Seleccione al menos una ponencia');
      return
    }

    let str_ponencias = ''

    filasSeleccionadas.forEach(function(fila) {
      str_ponencias += fila + ', '
    });

    str_ponencias = str_ponencias.slice(0,-2);

    var indiceUltimoCaracter = str_ponencias.lastIndexOf(', '); // Obtener el índice del último carácter buscado

    if (indiceUltimoCaracter !== -1) {
      str_ponencias = str_ponencias.substring(0, indiceUltimoCaracter) + ' y' + str_ponencias.substring(indiceUltimoCaracter + 1); // Reemplazar el último carácter buscado por el nuevo texto
    }

    Swal.fire({
      icon: 'question',
      title: 'Seguro que desea mandar cartas de aceptación a las siguientes ponencias',
      text: str_ponencias,
      showCancelButton: true, //Solo mostrando el de cancelar, se muestra el otro
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Enviar cartas'
    }).then((result) => {
      if(result.isConfirmed){
        var screen = $("#loader")
        loaderScreen(screen)
        let congreso = $("#congreso option:selected").val()
        let comentarios = $("#comentarios").val()
        let pagado = $("input[name='optradio']:checked").val()

        if(pagado === undefined){
          alert('Seleccione si las ponencias han sido pagadas o no')
          return;
        }
        $.ajax({
          type: 'post',
          url: './enviar',
          dataType: 'json',
          data: {
            submission_ids:filasSeleccionadas,
            congreso: congreso,
            comentarios: comentarios,
            pagado: pagado,
          },
          success: function(res){
            if(res.codigo == 200){
              Swal.fire({
                icon: "success",
                title: res.title,
                text: res.mensaje,
              }).then(function(){
                location.reload();
                return;
                filasSeleccionadas = []
                var filtro = $('#dt_ponencias_filter input').val(); // Obtener el valor del filtro aplicado
                initDataTable(); // Recargar la tabla
                $('#dt_ponencias_filter input').val(filtro); // Restaurar el filtro aplicado
                $('#dt_ponencias').DataTable().search(filtro).draw(); // Aplicar y dibujar el filtro
              })
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            // Manejar el error
            console.log(jqXHR);
            console.log(errorThrown)
            Swal.fire({
              icon: "error",
              title: 'Error '+jqXHR.status,
              text: jqXHR.responseText,
            })
          }
        })
      }
    })

  })
  

}

window.addEventListener('load', async() => {
await initDataTable();
})
// Función para obtener las filas seleccionadas
function obtenerFilasSeleccionadas() {
  return filasSeleccionadas;
}

function loaderScreen(screen){
  $(document)
  .ajaxStart(function(){
    screen.fadeIn();
  })
  .ajaxStop(function(){
    screen.fadeOut()
  })
}

$(document).on('click', '.cancelar', function() {
  let id = $(this).data('id')

  Swal.fire({
    icon: 'question',
    title: 'Seguro que desea cancelar el envio de esta carta?',
    text: 'El id en cuestion es: '+id,
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí'
  }).then((result) => {
    if(result.isConfirmed){
      var screen = $("#loader")
      loaderScreen(screen)
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: './cancelar',
        data: {
          id: id
        },
        success: function(res){
          if(res.codigo == 200){
            Swal.fire({
              icon: "success",
              title: res.title,
              text: res.mensaje,
            }).then(function(){
              var filtro = $('#dt_ponencias_filter input').val(); // Obtener el valor del filtro aplicado
              initDataTable(); // Recargar la tabla
              $('#dt_ponencias_filter input').val(filtro); // Restaurar el filtro aplicado
              $('#dt_ponencias').DataTable().search(filtro).draw(); // Aplicar y dibujar el filtro
            })
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Manejar el error
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: 'Error '+jqXHR.status,
            text: jqXHR.responseText,
          })
        }
      })
    }
  })
})





