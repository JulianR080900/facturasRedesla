let dataTable;
let dataTableIsInitialized = false;
// Variable para almacenar las filas seleccionadas
var filasSeleccionadas = [];
let enviar = $("#enviar");

const dataTableOptions = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 20, 100, 200, 500, 1000, 5000],
  columnDefs: [
    { className: "centered", targets: [0, 1, 2, 3] },
    { orderable: false, targets: [2, 3] },
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
    url: "getListado",
    type: "get",
  },
  columns: [
    { data: "id" },
    {
      data: "nombre",
      render: function (data, type, row, meta) {
        // Truncar el texto y agregar puntos suspensivos'
        var texto_truncado = data.substring(0, 100);
        if (data.length >= 100) {
          texto_truncado = data.substring(0, 100) + "...";
        }

        return `
            <div class="texto-truncado" title="${data}">
            ${texto_truncado}
            </div>`;
      },
    },
    {
      data: null,
      render: function (data, type, row) {
        return `<a href='./ver/${row.id}' class='btn btn-success btn-rounded'>Ver y editar horario</a>`;
      },
    },
    {
      data: null,
      render: function (data, type, row) {
        return `<button data-salones='${row.salones}' data-toggle="modal" data-target="#myModal" data-id='${row.id}' data-horarios='${row.horarios}' data-nombre='${row.nombre}' class='btn btn-warning btn-rounded ag'>Editar aspectos generales</button>`;
      },
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

  dataTable = $("#dt_horarios").DataTable(dataTableOptions);

  dataTableIsInitialized = true;

  $("#dt_horarios tbody").on("click", ".texto-truncado", function () {
    // Obtener el objeto de celda correspondiente al texto truncado
    const cell = dataTable.cell($(this).parent());

    // Obtener el valor completo de la celda
    const fullText = cell.data();

    // Ocultar el tooltip
    $(this).attr("title", "");

    // Mostrar el texto completo
    $(this).text(fullText);

    // Agregar una clase CSS al elemento para indicar que se ha mostrado el texto completo
    $(this).addClass("texto-completo");
  });

  $("#dt_horarios tbody").on("click", ".texto-completo", function () {
    // Obtener el objeto de celda correspondiente al texto completo
    const cell = dataTable.cell($(this).parent());

    // Obtener el valor truncado de la celda
    const truncatedText = cell.render("display");

    // Restablecer el texto truncado
    $(this).html(truncatedText);

    // Eliminar la clase CSS del elemento para indicar que se ha restablecido el texto truncado
    $(this).removeClass("texto-completo");
  });
};

window.addEventListener("load", async () => {
  await initDataTable();
});
// Función para obtener las filas seleccionadas
function obtenerFilasSeleccionadas() {
  return filasSeleccionadas;
}

function loaderScreen(screen) {
  $(document)
    .ajaxStart(function () {
      screen.fadeIn();
    })
    .ajaxStop(function () {
      screen.fadeOut();
    });
}

$(document).on("click", ".ag", function () {
  
  let salones = $(this).data("salones");
  let horarios = $(this).data("horarios");
  let nombre = $(this).data("nombre");
  let id = $(this).data('id')

  $("#nombre").val(nombre);
  $("#horarios").val(horarios);
  $("#salones").val(salones);
  $("#id").val(id);
});

$("#btnAct").on('click',function(e){

  e.preventDefault()

  const form = $("#formUpdate").serializeArray()
  //filtramos el array
  const new_form = form.filter(function(elemento) {
    return /^ponencias_salon_\d+_horario_\d+\[\]$/.test(elemento.name);
  });

  

  // Buscar un valor repetido
  let valorRepetido = null;
  for (var i = 0; i < new_form.length; i++) {
    for (var j = i+1; j < new_form.length; j++) {
      if (new_form[i]['value'] === new_form[j]['value']) {
        if(new_form[i]['value'] != ''){
          valorRepetido = new_form[i]['value'];
          break;
        }
      }
    }
    if (valorRepetido !== null) {
      break;
    }
  }

  // Mostrar el valor repetido en la consola
  if (valorRepetido !== null) {
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      html: `La ponencia <b>${valorRepetido}</b> no puede estar repetida.`
    })
    return
  }

  const valoresPermitidos = []
  for (let index = 0; index < ponencias.length; index++) {
    const element = ponencias[index]['submission_id'];
    valoresPermitidos.push(element)
  }
  const valoresIngresados = []
  for (let index = 0; index < new_form.length; index++) {
    const element = new_form[index]['value'];
    valoresIngresados.push(element)
  }

  // Comprobar si los valores ingresados están en el array de valores permitidos
    for (var i = 0; i < valoresIngresados.length; i++) {
      if(valoresIngresados[i] != ''){
        if (valoresPermitidos.indexOf(valoresIngresados[i]) === -1) {
          Swal.fire({
            icon: 'warning',
            title: 'Cuidado',
            html: 'La ponencia <b>'+valoresIngresados[i]+'</b> no es una ponencia permitida para este evento.'
          })
          return
        }
      }
      
    }

    $('#formUpdate').submit();
})

$("#ventana").on('click',function(){
  var modalWindow = window.open("", "modalWindow", "width=800,height=400");
  var modalContent = tabla
  modalWindow.document.write(modalContent);
})

$("#formAdd").on('submit', function(e){
    e.preventDefault()
    const form_data = $(this).serializeArray()
    
    for (var i = 0; i < form_data.length; i++) {
        if (form_data[i].value.trim() === "") {
          alert("El campo " + form_data[i].name + " no puede estar vacío");
          return;
        }
      }
    
      $.ajax({
        type: 'post',
        url: './insert',
        data: form_data,
        dataType: 'json',
        success: function(data){
            console.log(data);
            Swal.fire({
                icon: 'success',
                title: data.title,
                html: data.mensaje
            }).then(function(){
                initDataTable()
                $("#modalAgregarHorario").modal('hide')
            })
        },
        error: function(jqXHR){
            console.log(jqXHR);
            Swal.fire({
                icon: 'error',
                title: 'Error '+jqXHR.status,
                text: jqXHR.responseText
            })
        }
      })
})

$("#formAct").on('submit', function(e){
  e.preventDefault()
  const form_data = $(this).serializeArray()
  
  for (var i = 0; i < form_data.length; i++) {
      if (form_data[i].value.trim() === "") {
        alert("El campo " + form_data[i].name + " no puede estar vacío");
        return;
      }
    }
  
    $.ajax({
      type: 'post',
      url: './updateAspectos',
      data: form_data,
      dataType: 'json',
      success: function(data){
          console.log(data);
          Swal.fire({
              icon: 'success',
              title: data.title,
              html: data.mensaje
          }).then(function(){
              initDataTable()
              $("#myModal").modal('hide')
          })
      },
      error: function(jqXHR){
          console.log(jqXHR);
          Swal.fire({
              icon: 'error',
              title: 'Error '+jqXHR.status,
              text: jqXHR.responseText
          })
      }
    })
})
