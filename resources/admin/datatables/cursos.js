
let dataTable;
let dataTableIsInitialized = false; 
let filasSeleccionadas = []

const dataTableOptions = {
  scrollC: '2000px',
  lengthMenu: [5,10,15,20,100,200,500],
  columnDefs: [
    { className: 'centered', targets: [0,1,2,3,4,5] },
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
    url: `../getListado/${id}`,
    type: 'post',
/*     success: function(res){
      console.log(res);
    },
    error: function(jqXHR){
      console.log(jqXHR);
    } */
  },
  columns: [
    {data: 'id'},
    {data: 'correo'},
    {data: 'nombre'},
    {data: 'curp'},
    {data: 'grado_academico'},
    {data: 'actividad'},
    {data: 'area_conocimiento'},
    {data: 'trabajo'},
    {data: 'num_tel'},
    {data: 'pais'},
    {data: 'paquete'},
    {data: 'medio_entero'},
    {data: 'factura'},
    {data: 'razon_factura'},
    {data: 'rfc'},
    {data: 'cfdi'},
    {data: 'fact_correo'},
    {data: 'calle_fact'},
    {data: 'exterior_fact'},
    {data: 'interior_fact'},
    {data: 'cp_fact'},
    {data: 'colonia_fact'},
    {data: 'muni_fact'},
    {data: 'estado_fact'},
    {data: 'pais_fact'},
    {data: 'regimen_fiscal'},
    {data: 'congreso'},
    {data: 'terminos'},
    {data: 'fecha'},
    {data: 'anio_curso'},
    {data: 'sexo'},
    {
      data: null,
      render: function(data,type,row){
        if(row.constancia == 1){
          return '<span class="text-success">Constancia otorgada</span>'
        }else{
          return `<button class="btn btn-rounded btn-info constancia" data-id='${row.id}'>Otorgar constancia</button>`
        }
      }
    },
    {
      data: null,
      render: function(data,type,row){
        if(row.pago == 1){
          return '<button class="pagar btn btn-rounded btn-success" data-estado="'+row.pago+'" data-id="'+row.id+'">Pagado</button>'
        }else{
          return '<button class="pagar btn btn-rounded btn-warning" data-estado="'+row.pago+'" data-id="'+row.id+'">Validar pago</button>'
        }
      }
    },
    {
      data: null,
      render: function(data,type,row){
        return `<a class="btn btn-rounded btn-danger" href='../dc3/${row.id}' >Formato DC-3</a>`
      }
    },
    {
      data: null,
      render: function(data,type,row){
        return `<a class='btn btn-rounded btn-info' href='../reenviar_correo_inscripcion/${row.id}'>Reenviar correo de inscripción</a>`
      }
    },
    {
      data: null,
      render: function(data,type,row){
        return `<button class="btn btn-rounded btn-warning correo_dc3" data-id='${row.id}'>Reenviar correo y DC-3</button>`
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
}



const initDataTable = async()=>{
  if(dataTableIsInitialized){
    dataTable.destroy();
  }

  dataTable = $('#dt_cursos').DataTable(dataTableOptions);

  dataTableIsInitialized = true;

  $('#dt_cursos tbody').on('click', 'tr', function() {

    var idFila = dataTable.row(this).data().id; // Reemplaza "data.id" con la propiedad que contiene el ID de la fila en tus datos
    let constancia = dataTable.row(this).data().constancia;
  
    if(constancia == 1){
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

    if(filasSeleccionadas.length >= 1){
      $("#multiple_constancias").show()
    }else{
      $("#multiple_constancias").hide()
    }
  });

}

window.addEventListener('load', async() => {
await initDataTable();
})

$(document).on('click', '.pagar', function() {
  let id = $(this).data('id')
  let estado = $(this).data('estado')

  let estadoTxt = estado==0?'validar':'declinar';

  Swal.fire({
    icon: 'question',
    title: 'Seguro que desea '+estadoTxt+' este pago?',
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
        url: '../pago',
        data: {
          estado: estado,
          id: id
        },
        success: function(res){
          console.log(res.codigo);
          if(res.codigo == 200){
            Swal.fire({
              icon: "success",
              title: res.title,
              text: res.mensaje,
            }).then(function(){
              var filtro = $('#dt_cursos_filter input').val(); // Obtener el valor del filtro aplicado
              initDataTable(); // Recargar la tabla
              $('dt_cursos_filter input').val(filtro); // Restaurar el filtro aplicado
              $('#dt_cursos').DataTable().search(filtro).draw(); // Aplicar y dibujar el filtro
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

$(document).on('click', '.constancia', function() {
  let id_constancia = $(this).data('id')

  Swal.fire({
    icon: 'question',
    title: 'Seguro que desea otorgar la constancia?',
    text: 'El id en cuestion es: '+id_constancia,
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí'
  }).then((result) => {
    if(result.isConfirmed){
      var screen = $("#loader")
      loaderScreen(screen)
      id_seleccionados = [id_constancia];
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '../addConstancias/'+id,
        data: {
          constancias: id_seleccionados
        },
        success: function(res){
          console.log(res);
          if(res.codigo == 200){
            Swal.fire({
              icon: "success",
              title: res.title,
              text: res.mensaje,
            }).then(function(){
              var filtro = $('#dt_cursos_filter input').val(); // Obtener el valor del filtro aplicado
              initDataTable(); // Recargar la tabla
              $('#dt_cursos_filter input').val(filtro); // Restaurar el filtro aplicado
              $('#dt_cursos').DataTable().search(filtro).draw(); // Aplicar y dibujar el filtro
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

$(document).ready(function(){
  $("#multiple_constancias").hide()
})

$(document).on('click', '.constancia_multiple', function() {

  let str_ponencias = ''

  filasSeleccionadas.forEach(function(fila) {
    str_ponencias += fila + ', '
  });

  Swal.fire({
    icon: 'question',
    title: 'Seguro que desea otorgar la constancia?',
    text: 'Los id en cuestion son: '+str_ponencias,
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
        url: '../addConstancias/'+id,
        data: {
          constancias: filasSeleccionadas
        },
        success: function(res){
          console.log(res);
          if(res.codigo == 200){
            Swal.fire({
              icon: "success",
              title: res.title,
              text: res.mensaje,
            }).then(function(){
              filasSeleccionadas = []
              var filtro = $('#dt_cursos_filter input').val(); // Obtener el valor del filtro aplicado
              initDataTable(); // Recargar la tabla
              $('#dt_cursos_filter input').val(filtro); // Restaurar el filtro aplicado
              $('#dt_cursos').DataTable().search(filtro).draw(); // Aplicar y dibujar el filtro
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

$(document).on('click', '.correo_dc3', function() {
  let id_constancia = $(this).data('id')

  Swal.fire({
    icon: 'question',
    title: 'Seguro que desea enviar el correo?',
    text: 'El id en cuestion es: '+id_constancia,
    showCancelButton: true,
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Sí'
  }).then((result) => {
    if(result.isConfirmed){
      var screen = $("#loader")
      loaderScreen(screen)
      id_seleccionados = [id_constancia];
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '../correo_dc3/'+id,
        data: {
          constancias: id_seleccionados
        },
        success: function(res){
          console.log(res);
          if(res.codigo == 200){
            Swal.fire({
              icon: "success",
              title: res.title,
              text: res.mensaje,
            }).then(function(){
              var filtro = $('#dt_cursos_filter input').val(); // Obtener el valor del filtro aplicado
              initDataTable(); // Recargar la tabla
              $('#dt_cursos_filter input').val(filtro); // Restaurar el filtro aplicado
              $('#dt_cursos').DataTable().search(filtro).draw(); // Aplicar y dibujar el filtro
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