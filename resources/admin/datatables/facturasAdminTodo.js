let dataTable;
let dataTableIsInitialized = false;

var parts = document.location.pathname.split("/");
var id = parts.pop() || parts.pop();

const dataTableOptions = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 15, 20, 100, 200, 500],
  columnDefs: [
    { className: "centered", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8] },
    { orderable: false, targets: [4, 5] },
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
    url: "./getListadoFacturasTodo/",
    type: "get",
  },
  columns: [
    { data: "id" },
    {
      data: null,
      render: function (row) {
        return `${row.usuarios_nombre} ${row.usuarios_ap_paterno} ${row.usuarios_ap_materno}`;
      },
    },
    {
      data: null,
      render: function (row) {
        if (row.provedores_nombre == null) {
          return `<span class='text-warning'>${row.provedor}</span>`;
        } else {
          return row.provedores_nombre;
        }
      },
    },
    {
      data: null,
      render: function (row) {
        if (row.metodos_pago_nombre == null) {
          return `<span class='text-warning' >${row.metodo_pago}</span>`;
        } else {
          return row.metodos_pago_nombre;
        }
      },
    },
    {
      data: null,
      render: function (row) {
        return `${row.monto} ${row.moneda} <i class="flag-icon flag-icon-${
          row.moneda == "MXN" ? "mx" : "us"
        }"></i>`;
      },
    },
    {
      data: null,
      render: function (row) {
        return `
          <a href='./downloadBlobFiles/pdf/${row.id}' title='Descargar'> <i class="fa-solid fa-file-pdf" style='font-size: 2rem; color: #b51308'></i> </a>
          <a target='_blank' href='./viewBlobFiles/pdf/${row.id}' title='Ver'> <i class="fa-solid fa-eye" style='font-size: 2rem; color: #fff'></i> </a>
          `;
      },
    },
    {
      data: null,
      render: function (row) {
        return `
          <a href='./downloadBlobFiles/xml/${row.id}' title='Descargar' > <i class="fa-regular fa-file-lines" style='font-size: 2rem; color: #ee9b40'></i> </a>
          <a target='_blank' href='./viewBlobFiles/xml/${row.id}' title='Ver'> <i class="fa-solid fa-eye" style='font-size: 2rem; color:#fff'></i> </a>
          `;
      },
    },
    { data: "fecha_pago" },
    { data: "fecha_factura" },
    { data: "fecha_insert" },
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

  dataTable = $("#dt_facturas").DataTable(dataTableOptions);

  dataTableIsInitialized = true;
};

window.addEventListener("load", async () => {
  await initDataTable();
});

$(".corte").on("click", function (e) {
  e.preventDefault();
  $("#modalDownload").modal("show");
});

$("#formDownload").on("submit", function (e) {
  e.preventDefault();
  var formDataArray = $(this).serializeArray();
  var formDataObject = {};
  formDataArray.forEach(function (input) {
    formDataObject[input.name] = input.value;
  });
  var form = $(this);
  $.ajax({
    type: "POST",
    url: "./validateArchivosFacturas/1", // URL a la que enviar los datos
    data: formDataObject, // Datos a enviar
    dataType: "json",
    beforeSend: function () {
      $("#loader").show();
    },
    success: function (data) {
      console.log(data);
      // Maneja la respuesta del servidor
      if (data.success) {
        download(data.zipName, data.zipContent);
      } else if (data.error) {
        Swal.fire({
          icon: "error",
          title: "Lo sentimos",
          text: data.error,
        });
      }      
    },
    error: function (jqXHR) {
      swal.fire({
        icon: "info",
        title: "Ups",
        text: "No existen facturas de ese ciclo",
      });
    },
    complete: function () {
      $("#loader").hide();
      $("#modalDownload").modal('hide');
      form[0].reset();
      initDataTable();
    },
  });
});

function download(filename, data) {
  var element = document.createElement('a');
  element.setAttribute('href', 'data:text/plain;base64,' + data);
  element.setAttribute('download', filename);

  element.style.display = 'none';
  document.body.appendChild(element);

  element.click();

  document.body.removeChild(element);
}
