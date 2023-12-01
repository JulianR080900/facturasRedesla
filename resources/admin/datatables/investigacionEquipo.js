let dataTable;
let dataTableIsInitialized = false;

const dataTableOptions = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 15, 20, 100, 200, 500],
  columnDefs: [
    { className: "centered", targets: [0, 1, 3] },
    { orderable: false, targets: [3] },
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
    url: "../getListaInvestigacionesEquipo/" + tabla + "/" + claveCuerpo,
    type: "get",
  },
  dom: "Bfrtip",
  buttons: ["copy", "csv", "excel", "pdf", "print"],
  columns: [
    { data: "folio" },
    { data: "nombre_encuestador" },
    { data: "estado" },
    { data: "nc" },
    { data: "entrevista" },
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
};

const initDataTable = async () => {
  if (dataTableIsInitialized) {
    dataTable.destroy();
  }

  dataTable = $("#dt_investigacion").DataTable(dataTableOptions);

  dataTableIsInitialized = true;
};

window.addEventListener("load", async () => {
  await initDataTable();
});

  (async () => {
    // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
    const respuestaRaw = await fetch("../chartGiro/"+tabla+'/'+claveCuerpo);
    const respuesta = await respuestaRaw.json()
    // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
    // Obtener una referencia al elemento canvas del DOM
    const $grafica = document.querySelector("#giro").getContext('2d');
    const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX
    const colores = respuesta.colores.toString();
    // Podemos tener varios conjuntos de datos. Comencemos con uno
    const datasets = {
        label: "Cantidad de registros",
        // Pasar los datos igualmente desde PHP
        data: respuesta.datos, // <- Aquí estamos pasando el valor traído usando AJAX
        backgroundColor: [
          'rgba(255, 99, 132, 0.8)',
          'rgba(54, 162, 235, 0.8)',
          'rgba(255, 206, 86, 0.8)',
        ], // Color de fondo
        fill: 1,
        borderWidth: 1,
    };
    var chartGiro = new Chart($grafica, {
        type: 'pie', // Tipo de gráfica
        data: {
            labels: etiquetas,
            datasets: [
                datasets,
                // Aquí más datos...
            ]
        },options: {
          responsive: true,
          animation: {
            onComplete: function () {
              var a = document.createElement('a');
              a.href = chartGiro.toBase64Image();
              //a.download = 'my_file_name.png';
              // Trigger the download
              a.click();
            },
          },
        },
    });
    
})();


(async () => {
  // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
  const respuestaRawIngresos = await fetch(base_url + "/admin/charts/individual/ingresos_gastos/"+tabla+'/'+claveCuerpo);
  const respuestaIngresos = await respuestaRawIngresos.json()
  // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
  // Obtener una referencia al elemento canvas del DOM
  const $graficaIngresos = document.querySelector("#ingresos_gastos");
  
  const etiquetasIngresos = respuestaIngresos.labels_externos; // <- Aquí estamos pasando el valor traído usando AJAX
  // Podemos tener varios conjuntos de datos. Comencemos con uno
  const datasetsIngresos = respuestaIngresos.datasets;
  var chartIngresos = new Chart($graficaIngresos, {
      type: 'radar', // Tipo de gráfica
      data: {
          labels: etiquetasIngresos,
          datasets: datasetsIngresos,
      },options: {
        responsive: true,
      },
  });
  
})();

(async () => {
  // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
  const respuestaRawInsumos = await fetch(base_url + "/admin/charts/individual/insumos/"+tabla+'/'+claveCuerpo);
  const respuestaInsumos = await respuestaRawInsumos.json()
  // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
  // Obtener una referencia al elemento canvas del DOM
  const $graficaInsumos = document.querySelector("#insumos");
  
  const etiquetasInsumos = respuestaInsumos.labels_externos; // <- Aquí estamos pasando el valor traído usando AJAX
  // Podemos tener varios conjuntos de datos. Comencemos con uno
  const datasetsInsumos = respuestaInsumos.datasets;
  var chartInsumos = new Chart($graficaInsumos, {
      type: 'radar', // Tipo de gráfica
      data: {
          labels: etiquetasInsumos,
          datasets: datasetsInsumos,
      },options: {
        responsive: true,
      },
  });
  
})();







/*
const config = {
  type: 'radar',
  data: data,
  options: {
    elements: {
      line: {
        borderWidth: 3
      }
    }
  },
};

const data = {
  labels: [
    'Eating',
    'Drinking',
    'Sleeping',
    'Designing',
    'Coding',
    'Cycling',
    'Running'
  ],
  datasets: [{
    label: 'My First Dataset',
    data: [65, 59, 90, 81, 56, 55, 40],
    fill: true,
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
    borderColor: 'rgb(255, 99, 132)',
    pointBackgroundColor: 'rgb(255, 99, 132)',
    pointBorderColor: '#fff',
    pointHoverBackgroundColor: '#fff',
    pointHoverBorderColor: 'rgb(255, 99, 132)'
  }, {
    label: 'My Second Dataset',
    data: [28, 48, 40, 19, 96, 27, 100],
    fill: true,
    backgroundColor: 'rgba(54, 162, 235, 0.2)',
    borderColor: 'rgb(54, 162, 235)',
    pointBackgroundColor: 'rgb(54, 162, 235)',
    pointBorderColor: '#fff',
    pointHoverBackgroundColor: '#fff',
    pointHoverBorderColor: 'rgb(54, 162, 235)'
  }]
};

*/


/*
const initChart = async () => {
  console.log('entra');
  // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
  const respuestaRaw = await fetch("./obtener_datos_ajax");
  // Decodificar como JSON
  const respuesta = await respuestaRaw.json();
  // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
  // Obtener una referencia al elemento canvas del DOM
  const $grafica = document.querySelector("#giro");
  const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX
  // Podemos tener varios conjuntos de datos. Comencemos con uno
  const datosVentas2020 = {
      label: "Ventas por mes",
      // Pasar los datos igualmente desde PHP
      data: respuesta.datos, // <- Aquí estamos pasando el valor traído usando AJAX
      backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
      borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
      borderWidth: 1, // Ancho del borde
  };
  new Chart($grafica, {
      type: 'line', // Tipo de gráfica
      data: {
          labels: etiquetas,
          datasets: [
              datosVentas2020,
              // Aquí más datos...
          ]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }],
          },
      }
  });
};*/