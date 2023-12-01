$("#cbx_pais").on("change", function () {
  pais = $("#cbx_pais").val();

  $("#cbx_municipio")
    .find("option")
    .remove()
    .end()
    .append('<option value="whatever"></option>')
    .val("whatever");

  if (pais == 1) {
    $("#divotroPais").fadeIn();
  } else {
    $("#divotroPais").fadeOut();

    $("#divotroEst").fadeOut();

    $("#divotroMun").fadeOut();
  }

  $.ajax({
    type: "POST",

    url: base_url + "/getEstado",

    data: {
      pais: pais,
    },

    success: function (data) {
      $("#cbx_estado").html(data);
    },
  });
});

$("#cbx_estado").on("change", function () {
  estado = $("#cbx_estado").val();

  if (estado == 1) {
    $("#divotroEst").fadeIn();
  } else {
    $("#divotroEst").fadeOut();
  }

  $.ajax({
    type: "POST",

    url: base_url + "/getMunicipio",

    data: {
      estado: estado,
    },

    success: function (data) {
      $("#cbx_municipio").html(data);
    },
  });
});

$("#cbx_municipio").on("change", function () {
  municipio = $("#cbx_municipio").val();

  if (municipio == 1) {
    $("#divotroMun").fadeIn();
  } else {
    $("#divotroMun").fadeOut();
  }
});

/*
$("#nombre").on("keypress", function (event) {
  key = event.keyCode || event.which;

  tecla = String.fromCharCode(key).toLowerCase();
  //

  letras = "abcdefghijklmnñopqrstuvwxyz ";

  especiales = "8-37-39-46";

  tecla_especial = false;

  for (var i in especiales) {
    if (key == especiales[i]) {
      tecla_especial = true;

      break;
    } else if (key == 32) {
      // Agrega esta condición para evitar espacios en blanco
      tecla_especial = false;
      break;
    }
  }

  if (letras.indexOf(tecla) == -1 && !tecla_especial) {
    event.preventDefault();
  }
});
*/

$("#rfc").on("paste", function (e) {
  e.preventDefault();
});

$(document).ready(function(){
  $("#loaderCustom").hide();
  $("#csf2").hide()
  $("#nombre").hide()
  $("#rfc").hide()
  $("#csf").prop('required',true)
  requiredInputs()
})

const estadosFactura = {
  0: `<span class='text-info'>Se puede facturar</span>`,
  1: `<span class='text-warning'>En proceso</span>`,
  2: `<span class='text-success'>Facturado</span>`,
};

var today = new Date();

var year = today.getFullYear().toString();
var month = (today.getMonth() + 1).toString().padStart(2, "0");
var day = today.getDate().toString().padStart(2, "0");

var currentDate = year + month + day;

let dataTable;
let dataTableIsInitialized = false;
const filasSeleccionadas = [];
let enviar = $("#enviar");

const dataTableOptions = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 15, 20, 100, 200, 500],
  columnDefs: [
    { className: "centered", targets: [0, 1, 2, 3, 4, 5] },
    { orderable: false, targets: [0, 3, 5] },
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
    url: "./facturas/getListado",
    type: "get",
  },
  columns: [
    {
      data: null,
      render: function (data, type, row) {
        return "";
      },
    },
    {
      data: null,
      render: function (data, type, row) {
        return `<span class='font_color'>${row.movimiento}</span>`;
      },
    },
    {
      data: null,
      render: function (data, type, row) {
        if (row.estado_factura == 0 && row.fechaLimiteFactura >= currentDate) {
          return `<span class='text-info'>Se puede facturar</span>`;
        } else if (row.estado_factura == 1) {
          return `<span class='text-warning'>Factura en proceso</span>`;
        } else if (row.estado_factura == 2) {
          return `<span class='text-success'>Factura emitida</span>`;
        } else {
          return `<span class='text-danger'>Apreciable investigador para solicitar su factura solo es dentro del mes de pago, lamentablemente ya no se puede realizar dicha solicitud.</span>`;
        }
      },
    },
    {
      data: null,
      render: function (data, type, row) {
        return `<a href='./visualizador/${row.comprobante}'><i class='far fa-file-alt'></i></a>`;
      },
    },
    {
      data: null,
      render: function (data, type, row) {
        return `<span class='font_color'>${row.fecha_comprobante}</span>`;
      },
    },
    {
      data: null,
      render: function (data, type, row) {
        if (row.carpeta == "" || row.carpeta === null) {
          return `<span class='text-danger'>No tiene una carpeta para este año</span>`;
        } else if (row.carpeta != "" && row.red == "Releg") {
          return `<a target='_blank' href='${row.carpeta}'><i class="fas fa-folder-open"></i></a>`;
        } else if (row.carpeta != "") {
          return `<a target='_blank' href='https://drive.google.com/drive/u/0/folders/${row.carpeta}'><i class="fas fa-folder-open"></i></a>`;
        }
      },
    },
  ],
  createdRow: function (row, data, dataIndex) {
    // Obtener el ID de la fila actual
    var idFila = data.id_movimiento; // Reemplaza "data.id" con la propiedad que contiene el ID de la fila en tus datos

    // Verificar si la fila actual está seleccionada
    if (filasSeleccionadas.includes(idFila)) {
      // Agregar clase CSS a la fila si está seleccionada
      $(row).addClass("fila-seleccionada").css("background-color", "#f0f0f0");
    }
  },
};

const initDataTable = async () => {
  if (dataTableIsInitialized) {
    dataTable.destroy();
  }

  dataTable = $("#dt_facturas").DataTable(dataTableOptions);

  dataTableIsInitialized = true;

  // Evento de clic en una fila
  $("#dt_facturas tbody").on("click", "tr", function () {
    var idFila = dataTable.row(this).data().id_movimiento; // Reemplaza "data.id" con la propiedad que contiene el ID de la fila en tus datos

    var estado_factura = dataTable.row(this).data().estado_factura;

    var fechaLimiteFactura = dataTable.row(this).data().fechaLimiteFactura;

    if (estado_factura != 0 || currentDate > fechaLimiteFactura) {
      return;
    }
    // Verificar si la fila ya está seleccionada
    if (filasSeleccionadas.includes(idFila)) {
      // Si está seleccionada, quitarla de las filas seleccionadas y quitar la clase CSS
      var index = filasSeleccionadas.indexOf(idFila);
      filasSeleccionadas.splice(index, 1);
      $(this)
        .removeClass("fila-seleccionada")
        .css("background-color", "transparent");

      $(this).find("td:first-child").text("");
    } else {
      // Si no está seleccionada, agregarla a las filas seleccionadas y agregar la clase CSS
      filasSeleccionadas.push(idFila);
      $(this).addClass("fila-seleccionada").css("background-color", "#fff");
      $(this)
        .find("td:first-child")
        .css({
          "background-color": "yellow !important",
          cursor: "pointer !important",
        })
        .text("Seleccionado");
    }
  });

  enviar.click(function () {
    if (filasSeleccionadas.length <= 0) {
      Swal.fire({
        icon: "warning",
        title: "Seleccione al menos un movimiento.",
      });
      return;
    }

    let str_movimientos = "";

    filasSeleccionadas.forEach(function (fila) {
      str_movimientos += fila + ",";
    });

    str_movimientos = str_movimientos.slice(0, -1);

    $("#movimientos").val(str_movimientos);

    $("#formFacturas").submit();
  });
};

window.addEventListener("load", async () => {
  await initDataTable();
});

const dropArea = document.querySelector(".drop-area");
const dragText = dropArea.querySelector("h2");
const button = dropArea.querySelector("button");
const input = dropArea.querySelector("#csf");

let files;

button.addEventListener("click", (e) => {
  input.click();
});

input.addEventListener("change", (e) => {
  files = input.files;
  dropArea.classList.add("active");
  showFiles(files);
  dropArea.classList.remove("active");
});

dropArea.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropArea.classList.add("active");
  dragText.textContent = "Suelta para subir archivo";
});

dropArea.addEventListener("dragleave", (e) => {
  e.preventDefault();
  dropArea.classList.remove("active");
  dragText.textContent = "Arrastra y suelta el archivo";
});

dropArea.addEventListener("drop", (e) => {
  e.preventDefault();
  files = e.dataTransfer.files;
  showFiles(files)
  dropArea.classList.remove("active");
  dragText.textContent = "Arrastra y suelta el archivo";
});

function showFiles(files) {
  console.log(files.length);
  if(files.length > 1){
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'No se puede seleccionar mas de 1 archivo'
    })
    return
  }

  if (files.length === undefined) {
    proccessFile(files);
  } else {
    for (const file of files) {
      proccessFile(file);
    }
  }
}

function proccessFile(file) {
  const docType = file.type;
  const validExtensions = ['application/pdf'];
  let fileName = file.name

  if (validExtensions.includes(docType)) {
    const formData = new FormData();
    formData.append('archivo', file);

    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: formData,
      processData: false,
      contentType: false,
      url: './readCSF',
      beforeSend: function() {
        $(".drop-area").hide()
        $(".loaderCustom").text('Leyendo Carta de Situación Fiscal')
        $("#loaderCustom").show()
      },
      success: async function(response) {
        await autocompleteForm(response,fileName)
        Swal.fire({
          icon: 'info',
          title: 'Revise su información',
          text: 'Revise cuidadosamente los datos autocompletados por el sistema y complete los datos faltantes. Si presenta algun error, favor de modificarlo',
          footer: 'Campos no editables: <b>RFC, RAZÓN SOCIAL Y C.P</b>'
        })
        $(".loaderCustom").text('')
        $("#loaderCustom").hide()
        console.log(response);
        
      },
      error: function(jqXHR) {
        $(".drop-area").show()
        $(".loaderCustom").text('')
        $("#loaderCustom").hide()
        Swal.fire({
          icon: 'error',
          title: 'Lo sentimos',
          text: 'El archivo subido no es una Carta de Situación Fiscal',
          footer: 'Si es un error, contacte con el equipo REDESLA.'
        })
      }
    });
  } else {
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'Formato de archivo no admitido',
      footer: 'El archivo debe ser en formato PDF'
    })
    return;
  }
}

async function autocompleteForm(response,fileName){
  //$('label[for="rfc"]').text('RFC <span class="text-warning">Campo autocompletado</span>');
  
  $("#rfc").val(response.rfc).prop('readonly',true)
  $("#lbl_rfc").text(response.rfc)

  $("#nombre").val(response.razons).prop('readonly',true)
  $("#lbl_razons").text(response.razons)

  $("#nombre_archivo").text(fileName)

  $("#calle").val(response.vialidad)

  $("#noext").val(response.noExt)

  $("#noint").val(response.noInt)

  $("#cp").val(response.cp).prop('readonly',true)

  $("#colonia").val(response.colonia)

  $("#localidad").val(response.localidad)

  $("#cbx_pais").val(response.pais)

  //ESTADO

  if(response.estado.id === undefined){
    //NO ENCONTRO EL ESTADO, HAY QUE DARLE LOS INPUTS
    getEstadosRepublica(response.pais)
  }else{
    var inputElement = $('<input>').attr('type', 'text').attr('id', 'cbx_estado').attr('name','cbx_estado').addClass('form-control');
    var inputView = $('<input>').attr('type', 'text').attr('id', 'viewEstado').addClass('form-control').val(response.estado.nombre);
  
    $('#cbx_estado').replaceWith(inputElement)
    $("#cbx_estado").val(response.estado.id).hide()
  
    $("#cbx_estado").parent().append(inputView)
    $("#viewEstado").prop('readonly',true)
  }

  //MUNICIPIO

  if(response.municipio.id === undefined){
    //NO ENCONTRO EL MUNICIPIO, HAY QUE DARLE LA OPCION DE SELECCIONARLO
    if(response.estado.id !== undefined){
      getMunicipios(response.pais, response.estado.id)
    }

  }else{
    var inputElement = $('<input>').attr('type', 'text').attr('id', 'cbx_municipio').attr('name', 'cbx_municipio').addClass('form-control');
    var inputView = $('<input>').attr('type', 'text').attr('id', 'viewMunicipio').addClass('form-control').val(response.municipio.nombre);
  
    $('#cbx_municipio').replaceWith(inputElement)
    $("#cbx_municipio").val(response.municipio.id).hide()
  
    $("#cbx_municipio").parent().append(inputView)
    $("#viewMunicipio").prop('readonly',true)
  }

  



  var selectElement = $('#regimen_fiscal');
  var stringDado = response.regimenes[0];
  
  var options = selectElement.find('option');
  var bestMatch;
  var minDistance = Infinity;
  
  options.each(function() {
    var optionText = $(this).text();
    var distance = calculateSimilarity(optionText, stringDado);
  
    if (distance < minDistance) {
      bestMatch = this;
      minDistance = distance;
    }
  });

  // Seleccionar el mejor match
  $(bestMatch).prop('selected', true);





}

function calculateSimilarity(str1, str2) {
  var m = str1.length;
  var n = str2.length;
  var dp = [];

  for (var i = 0; i <= m; i++) {
    dp[i] = [];
    dp[i][0] = i;
  }

  for (var j = 0; j <= n; j++) {
    dp[0][j] = j;
  }

  for (var i = 1; i <= m; i++) {
    for (var j = 1; j <= n; j++) {
      if (str1[i - 1] === str2[j - 1]) {
        dp[i][j] = dp[i - 1][j - 1];
      } else {
        dp[i][j] = 1 + Math.min(dp[i - 1][j - 1], dp[i][j - 1], dp[i - 1][j]);
      }
    }
  }

  return dp[m][n];
}



function requiredInputs(){
  $('.form-group input[required], .form-group select[required]').each(function() {
    var label = $(this).closest('.form-group').find('label');
    label.append('<span style="color: red !important;"> *</span>');
  });
}

$("#manual").on('click',function(e){
  $("#csf2").prop('required',true).show()
  $("#csf").prop('required',false)

  $("#lbl_razons").hide()
  $("#nombre").show()

  $("#lbl_rfc").hide()
  $("#rfc").show()

  $(".drop-area").hide()

})

$("#csf2").on('change',function(e){
  let archivo = this.files[0];
  $("#nombre_archivo").text(archivo.name)
})

document.getElementById('nombre').addEventListener('input', function() {
  var texto = this.value;
  texto = texto.replace(/[^a-zA-Z0-9\s]/g, '');
  texto = texto.toUpperCase();
  this.value = texto;
});

document.getElementById('nombre').addEventListener('keydown', function(event) {
  var tecla = event.key;
  if (/[áéíóúÁÉÍÓÚ]/.test(tecla)) {
    console.log('entra');
    event.preventDefault();
  }
});

document.getElementById('rfc').addEventListener('input', function(e) {
  var texto = this.value;
  texto = texto.replace(/[^a-zA-Z0-9]/g, '');
  texto = texto.toUpperCase();
  this.value = texto;
});

document.getElementById('rfc').addEventListener('keydown', function(event) {
  console.log(event.target.value);
  var tecla = event.key;
  if (/[áéíóúÁÉÍÓÚ]/.test(tecla)) {
    event.preventDefault();
  }
});

function getMunicipios(estado){
  $.ajax({
    type: "POST",

    url: base_url + "/getMunicipio",

    data: {
      estado: estado,
    },

    success: function (data) {
      $("#cbx_municipio").html(data);
    },
  });
}

function getEstadosRepublica(pais){
  $.ajax({
    type: "POST",
    url: base_url + "/getEstado",
    data: {
      pais: pais,
    },
    success: function (data) {
      $("#cbx_estado").html(data);
    },
  });
}

let formSoliFact = document.getElementById('frm_factura')

formSoliFact.addEventListener('submit', function(e){
  e.preventDefault()
  const formData = $(this).serializeArray()

  let archivo

  let csf1 = $("#csf")[0].files[0]
  let csf2 = $("#csf2")[0].files[0]

  if(csf1 === undefined){
    if(csf2 === undefined){
      Swal.fire({
        icon: 'warning',
        title: 'Lo sentimos',
        text: 'Ha ocurrido un error al intentar emitir su solicitud de factura. Intente mas tarde.'
      })
      return
    }
    archivo = csf2
    
  }else{
    archivo = csf1
  }

  const dataSubmit = new FormData()

  $.each(formData, function(index, field) {
    if(field.name == 'cbx_estado'){
      field.name = 'estado'
    }else if(field.name == 'cbx_municipio'){
      field.name = 'municipio'
    }else if(field.name == 'cbx_pais'){
      field.name = 'pais'
    }
    dataSubmit.append(field.name, field.value);
  });

  dataSubmit.append('csf', archivo);

  $.ajax({
    type: 'post',
    dataType: 'json',
    url: './enviar_fact',
    processData: false,
    contentType: false,
    data: dataSubmit,
    beforeSend: function(){
        $(".loaderCustom").text('Procesando solicitud')
        $("#loaderCustom").show()
    },
    success: function(response){
      $(".loaderCustom").text('')
      $("#loaderCustom").hide()
      Swal.fire({
        icon: 'success',
        title: response.title,
        text: response.text
      }).then(function(){
        window.location.href = base_url+'/facturas'
      })
    },
    error: function(jqXHR){
      $(".loaderCustom").text('')
      $("#loaderCustom").hide()
      Swal.fire({
        icon: 'error',
        title: 'Error '+jqXHR.status,
        text: jqXHR.responseText
      }).then(function(){
        window.location.href = base_url+'/facturas'
      })
      console.log(jqXHR);
    }
  })

  
  //console.log(dataSubmit);
})