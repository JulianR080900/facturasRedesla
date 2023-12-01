document.addEventListener("DOMContentLoaded", function () {
  // Añade la línea para deshabilitar el enfoque automático en los modales
  $.fn.modal.Constructor.prototype._enforceFocus = function() {};
});

let dataTable;
let dataTableIsInitialized = false;

const dataTableOptions = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 15, 20, 100, 200, 500],
  columnDefs: [
    { className: "centered", targets: [0, 1, 2, 3, 4, 5, 6, 7] },
    { orderable: false, targets: [2, 3, 4, 5, 6, 7] },
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
    info: "Registros filtrados de un total de _TOTAL_ registros",
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
    url: "./getListaInvestigacionesEquipos",
    type: "post",
    data: {
      anio: anio,
      red: red,
    },
  },
  columns: [
    { data: "id" },
    { data: "claveCuerpo" },
    { data: "esquema" },
    {
      data: null,
      render: function (row) {
        let tabla = `cuestionarios_${red}_${anio}`;
        return `
        <a href='./descargas/encuestasEquipo/${tabla}/${row.claveCuerpo}' class='btn btn-info'>Encuestas ${row.claveCuerpo}</a><br><br>
        <a href='./descargas/encuestasEquipoValidos/${tabla}/${row.claveCuerpo}' class='btn btn-success'>Encuestas válidas ${row.claveCuerpo}</a>
        `;
      },
    },
    {
      data: null,
      render: function (row) {
        if (row.esquema == "A") {
          return `<span class='text-warning'>No aplica por esquema</span>`;
        } else {
          return fases[row.f_impreso];
        }
      },
    },
    {
      data: null,
      render: function (row) {
        if (row.esquema == "A") {
          return `<span class='text-warning'>No aplica por esquema</span>`;
        } else {
          if (row.r_impreso == 1) {
            if (row.f_impreso == 7) {
              return `<button type='button' class='btn btn-md btn-success carta_derechosImpreso' data-archivo='carta_derechos' data-clave='${row.claveCuerpo}' data-red='${row.red}' data-anio='${row.anio}'>Ver revisión</button>`;
            }else if (row.f_impreso == 8) {
              return `<button type='button' class='btn btn-md btn-success carta_vistoImpreso' data-archivo='carta_visto' data-clave='${row.claveCuerpo}' data-red='${row.red}' data-anio='${row.anio}'>Ver revisión</button>`;
            }
            return `<a href='./revision/impreso/${row.claveCuerpo}' class='btn btn-md btn-success'>Ir a revisión <i class='mdi mdi-eye'></i> </a>`;
          } else if (row.r_impreso == 0) {
            return `<span class='text-primary'>Trabajando...</span>`;
          } else if (row.r_impreso == 2) {
            return `<span class='text-warning'>Trabajando en revisiones...</span>`;
          } else {
            return `Hay un error, contacte a sistemas`;
          }
        }
      },
    },
    {
      data: null,
      render: function (row) {
        return fases[row.f_digital];
      },
    },
    {
      data: null,
      render: function (row) {
        if (row.r_digital == 1) {
          if (row.f_digital == 7) {
            return `<button type='button' class='btn btn-md btn-success carta_derechosDigital' data-archivo='carta_derechos' data-clave='${row.claveCuerpo}' data-red='${row.red}' data-anio='${row.anio}'>Ver revisión</button>`;
          }else if (row.f_digital == 8) {
            return `<button type='button' class='btn btn-md btn-success carta_vistoDigital' data-archivo='carta_visto' data-clave='${row.claveCuerpo}' data-red='${row.red}' data-anio='${row.anio}'>Ver revisión</button>`;
          }else{
            return `<a href='./revision/digital/${row.claveCuerpo}' class='btn btn-md btn-success'>Ir a revisión <i class='mdi mdi-eye'></i> </a>`;
          }
          
        } else if (row.r_digital == 0) {
          return `<span class='text-primary'>Trabajando...</span>`;
        } else if (row.r_digital == 2) {
          return `<span class='text-warning'>Trabajando en revisiones...</span>`;
        } else {
          return `Hay un error, contacte a sistemas`;
        }
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

  dataTable = $("#dt_inv").DataTable(dataTableOptions);

  dataTableIsInitialized = true;
};

window.addEventListener("load", async () => {
  await initDataTable();
});

const form = document.querySelector("#formUploadImpreso"),
  fileInput = document.querySelector(".file-input"),
  progressArea = document.querySelector(".progress-area"),
  uploadedArea = document.querySelector(".uploaded-area");

form.addEventListener("click", () => {
  fileInput.click();
});

fileInput.onchange = ({ target }) => {
  const files = target.files;
  for (var i = 0; i < files.length; i++) {
    let file = target.files[i];
    if (file) {
      let fileName = file.name;
      if (fileName.length >= 12) {
        let splitName = fileName.split(".");
        fileName = splitName[0].substring(0, 20) + "... ." + splitName[1];
      }
      uploadFile(fileName);
    }
  }
};

function uploadFile(name) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./subir/preliminar/impreso");
  xhr.upload.addEventListener("progress", ({ loaded, total }) => {
    let fileLoaded = Math.floor((loaded / total) * 100);
    let fileTotal = Math.floor(total / 1000);
    let fileSize;
    fileTotal < 1024
      ? (fileSize = fileTotal + " KB")
      : (fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB");
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Subiendo</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
    uploadedArea.classList.add("onprogress");
    progressArea.innerHTML = progressHTML;
    if (loaded == total) {
      xhr.addEventListener("load", () => {
        if (xhr.status === 200) {
          progressArea.innerHTML = "";
          let uploadedHTML = `<li class="row">
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span class="name">${name} • Subido / actualizado</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
          uploadedArea.classList.remove("onprogress");
          uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
        } else {
          progressArea.innerHTML = "";
          let uploadedHTML = `<li class="row" style='background: #e11919 !important;'>
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span>${name} • No se ha podido subir el archivo</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
          uploadedArea.classList.remove("onprogress");
          uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      });
    }
  });
  let data = new FormData(form);
  xhr.send(data);
}

const formDigital = document.querySelector("#formUploadDigital"),
  fileInputDigital = document.querySelector(".file-input-digital"),
  progressAreaDigital = document.querySelector(".progress-area-digital"),
  uploadedAreaDigital = document.querySelector(".uploaded-area-digital");

formDigital.addEventListener("click", () => {
  fileInputDigital.click();
});

fileInputDigital.onchange = ({ target }) => {
  const files = target.files;
  for (var i = 0; i < files.length; i++) {
    let file = target.files[i];
    if (file) {
      let fileName = file.name;
      if (fileName.length >= 12) {
        let splitName = fileName.split(".");
        fileName = splitName[0].substring(0, 20) + "... ." + splitName[1];
      }
      uploadFileDigital(fileName);
    }
  }
};

function uploadFileDigital(name) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./subir/preliminar/digital");
  xhr.upload.addEventListener("progress", ({ loaded, total }) => {
    let fileLoaded = Math.floor((loaded / total) * 100);
    let fileTotal = Math.floor(total / 1000);
    let fileSize;
    fileTotal < 1024
      ? (fileSize = fileTotal + " KB")
      : (fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB");
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Subiendo</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
    uploadedAreaDigital.classList.add("onprogress");
    progressAreaDigital.innerHTML = progressHTML;
    if (loaded == total) {
      xhr.addEventListener("load", () => {
        console.log(xhr);
        if (xhr.status === 200) {
          progressAreaDigital.innerHTML = "";
          let uploadedHTML = `<li class="row">
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span class="name">${name} • Subido / actualizado</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
          uploadedAreaDigital.classList.remove("onprogress");
          uploadedAreaDigital.insertAdjacentHTML("afterbegin", uploadedHTML);
        } else {
          progressAreaDigital.innerHTML = "";
          let uploadedHTML = `<li class="row" style='background: #e11919 !important;'>
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span>${name} • No se ha podido subir el archivo</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
          uploadedAreaDigital.classList.remove("onprogress");
          uploadedAreaDigital.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      });
    }
  });
  let data = new FormData(formDigital);
  xhr.send(data);
}

/* IMPRESO DERECHOS */
$(document).on("click", ".carta_derechosImpreso", function (e) {
  e.preventDefault();
  let claveCuerpo = $(this).data("clave");
  let red = $(this).data("red");
  let anio = $(this).data("anio");

  $("#iframeCartasDerechosImpreso").attr(
    "src",
    `./ver/carta/carta_derechos/${claveCuerpo}/impreso`
  );

  $("#iframeCartasDerechosImpreso").on("load", function () {
    $("#claveCuerpo_impreso").val(claveCuerpo);
    $("#tipo_impreso").val("impreso");
    $("#red_impreso").val(red);
    $("#anio_impreso").val(anio);
    $(document).off('focusin.modal');
    $("#modalTitleCartaDerechosImpreso").text(
      `Carta de sesión de derechos impreso - ${claveCuerpo}`
    );
    $("#modalCartaDerechosImpreso").modal("show");
  });
});

$(".aceptarCartaDerechosImpreso").on("click", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "¿Esta seguro que desea aceptar esta fase?",
    text: "Esta accion no es reversible",
    icon: "warning",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    let claveCuerpo = $("#claveCuerpo_impreso").val();
    let tipo = $("#tipo_impreso").val();
    let red = $("#red_impreso").val();
    let anio = $("#anio_impreso").val();
    if (result.isConfirmed) {
      $.ajax({
        url: "./updatePhase",
        type: "post",
        dataType: "json",
        data: {
          claveCuerpo: claveCuerpo,
          tipo: tipo,
          red: red,
          anio: anio,
          terminado: 0,
        },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Exito",
            text: "Fase aceptada correctamente.",
          }).then(function () {
            location.reload()
          });
        },
        error: function (jqXHR) {
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte a sistemas.",
          });
        },
      });
    }
  });
});

$(".devolverCartaDerechosImpreso").on("click", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "¿Esta seguro que desea devolver esta fase?",
    text: "Esta accion no es reversible",
    icon: "warning",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    input: "text",
    inputLabel: "Escriba el porque ha sido devuelta la fase",
    inputPlaceholder: "",
  }).then((result) => {
    if (result.isConfirmed) {
      let mensaje = result.value;
      let claveCuerpo = $("#claveCuerpo_impreso").val();
      let tipo = $("#tipo_impreso").val();
      let red = $("#red_impreso").val();
      let anio = $("#anio_impreso").val();
      $.ajax({
        url: "./updatePhase",
        type: "post",
        dataType: "json",
        data: {
          claveCuerpo: claveCuerpo,
          tipo: tipo,
          red: red,
          anio: anio,
          terminado: 2,
          mensaje: mensaje,
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "Exito",
            text: "Fase devuelta correctamente.",
          }).then(function () {
            location.reload()
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte a sistemas.",
          });
        },
      });
    }
  });
});

/* DIGITAL DERECHOS */

$(document).on("click", ".carta_derechosDigital", function (e) {
  e.preventDefault();
  let claveCuerpo = $(this).data("clave");
  let red = $(this).data("red");
  let anio = $(this).data("anio");

  $("#iframeCartasDerechosDigital").attr(
    "src",
    `./ver/carta/carta_derechos/${claveCuerpo}/digital`
  );

  $("#iframeCartasDerechosDigital").on("load", function () {
    $("#claveCuerpo_digital").val(claveCuerpo);
    $("#tipo_digital").val("digital");
    $("#red_digital").val(red);
    $("#anio_digital").val(anio);
    $(document).off('focusin.modal');
    $("#modalTitleCartaDerechosDigital").text(
      `Carta de sesión de derechos digital - ${claveCuerpo}`
    );
    $("#modalCartaDerechosDigital").modal("show");
  });
});

$(".aceptarCartaDerechosDigital").on("click", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "¿Esta seguro que desea aceptar esta fase?",
    text: "Esta accion no es reversible",
    icon: "warning",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    let claveCuerpo = $("#claveCuerpo_digital").val();
    let tipo = $("#tipo_digital").val();
    let red = $("#red_digital").val();
    let anio = $("#anio_digital").val();
    if (result.isConfirmed) {
      $.ajax({
        url: "./updatePhase",
        type: "post",
        dataType: "json",
        data: {
          claveCuerpo: claveCuerpo,
          tipo: tipo,
          red: red,
          anio: anio,
          terminado: 0,
        },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Exito",
            text: "Fase aceptada correctamente.",
          }).then(function () {
            location.reload()
          });
        },
        error: function (jqXHR) {
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte a sistemas.",
          });
        },
      });
    }
  });
});

$(".devolverCartaDerechosDigital").on("click", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "¿Esta seguro que desea devolver esta fase?",
    text: "Esta accion no es reversible",
    icon: "warning",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    input: "text",
    inputLabel: "Escriba el porque ha sido devuelta la fase",
    inputPlaceholder: "",
  }).then((result) => {
    if (result.isConfirmed) {
      let mensaje = result.value;
      let claveCuerpo = $("#claveCuerpo_digital").val();
      let tipo = $("#tipo_digital").val();
      let red = $("#red_digital").val();
      let anio = $("#anio_digital").val();
      $.ajax({
        url: "./updatePhase",
        type: "post",
        dataType: "json",
        data: {
          claveCuerpo: claveCuerpo,
          tipo: tipo,
          red: red,
          anio: anio,
          terminado: 2,
          mensaje: mensaje,
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "Exito",
            text: "Fase devuelta correctamente.",
          }).then(function () {
            location.reload()
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte a sistemas.",
          });
        },
      });
    }
  });
});

/* VISTO IMPRESO */

$(document).on("click", ".carta_vistoImpreso", function (e) {
  e.preventDefault();
  let claveCuerpo = $(this).data("clave");
  let red = $(this).data("red");
  let anio = $(this).data("anio");

  $("#iframeCartasVistoImpreso").attr(
    "src",
    `./ver/carta/carta_visto/${claveCuerpo}/impreso`
  );

  $("#iframeCartasVistoImpreso").on("load", function () {
    $("#claveCuerpoVisto_impreso").val(claveCuerpo);
    $("#tipoVisto_impreso").val("impreso");
    $("#redVisto_impreso").val(red);
    $("#anioVisto_impreso").val(anio);
    $(document).off('focusin.modal');
    $("#modalTitleCartaVistoImpreso").text(
      `Carta de visto bueno impreso - ${claveCuerpo}`
    );
    $("#modalCartaVistoImpreso").modal("show");
  });
});

$(".aceptarCartaVistoImpreso").on("click", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "¿Esta seguro que desea aceptar esta fase?",
    text: "Esta accion no es reversible",
    icon: "warning",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    let claveCuerpo = $("#claveCuerpoVisto_impreso").val();
    let tipo = $("#tipoVisto_impreso").val();
    let red = $("#redVisto_impreso").val();
    let anio = $("#anioVisto_impreso").val();
    if (result.isConfirmed) {
      $.ajax({
        url: "./updatePhase",
        type: "post",
        dataType: "json",
        data: {
          claveCuerpo: claveCuerpo,
          tipo: tipo,
          red: red,
          anio: anio,
          terminado: 0,
        },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Exito",
            text: "Fase aceptada correctamente.",
          }).then(function () {
            location.reload()
          });
        },
        error: function (jqXHR) {
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte a sistemas.",
          });
        },
      });
    }
  });
});

$(".devolverCartaVistoImpreso").on("click", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "¿Esta seguro que desea devolver esta fase?",
    text: "Esta accion no es reversible",
    icon: "warning",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    input: "text",
    inputLabel: "Escriba el porque ha sido devuelta la fase",
    inputPlaceholder: "",
  }).then((result) => {
    if (result.isConfirmed) {
      let mensaje = result.value;
      let claveCuerpo = $("#claveCuerpoVisto_impreso").val();
      let tipo = $("#tipoVisto_impreso").val();
      let red = $("#redVisto_impreso").val();
      let anio = $("#anioVisto_impreso").val();
      $.ajax({
        url: "./updatePhase",
        type: "post",
        dataType: "json",
        data: {
          claveCuerpo: claveCuerpo,
          tipo: tipo,
          red: red,
          anio: anio,
          terminado: 2,
          mensaje: mensaje,
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "Exito",
            text: "Fase devuelta correctamente.",
          }).then(function () {
            location.reload()
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte a sistemas.",
          });
        },
      });
    }
  });
});

/* VISTO DIGITAL */

$(document).on("click", ".carta_vistoDigital", function (e) {
  e.preventDefault();
  let claveCuerpo = $(this).data("clave");
  let red = $(this).data("red");
  let anio = $(this).data("anio");

  $("#iframeCartasVistoDigital").attr(
    "src",
    `./ver/carta/carta_visto/${claveCuerpo}/digital`
  );

  $("#iframeCartasVistoDigital").on("load", function () {
    $("#claveCuerpoVisto_digital").val(claveCuerpo);
    $("#tipoVisto_digital").val("digital");
    $("#redVisto_digital").val(red);
    $("#anioVisto_digital").val(anio);
    $(document).off('focusin.modal');
    $("#modalTitleCartaVistoDigital").text(
      `Carta de visto bueno digital - ${claveCuerpo}`
    );
    $("#modalCartaVistoDigital").modal("show");
  });
});

$(".aceptarCartaVistoDigital").on("click", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "¿Esta seguro que desea aceptar esta fase?",
    text: "Esta accion no es reversible",
    icon: "warning",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    let claveCuerpo = $("#claveCuerpoVisto_digital").val();
    let tipo = $("#tipoVisto_digital").val();
    let red = $("#redVisto_digital").val();
    let anio = $("#anioVisto_digital").val();
    if (result.isConfirmed) {
      $.ajax({
        url: "./updatePhase",
        type: "post",
        dataType: "json",
        data: {
          claveCuerpo: claveCuerpo,
          tipo: tipo,
          red: red,
          anio: anio,
          terminado: 0,
        },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "Exito",
            text: "Fase aceptada correctamente.",
          }).then(function () {
            location.reload()
          });
        },
        error: function (jqXHR) {
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte a sistemas.",
          });
        },
      });
    }
  });
});

$(".devolverCartaVistoDigital").on("click", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "¿Esta seguro que desea devolver esta fase?",
    text: "Esta accion no es reversible",
    icon: "warning",
    footer: 'Carta visto bueno digital',
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
    input: "text",
    inputLabel: "Escriba el porque ha sido devuelta la fase",
    inputPlaceholder: "",
  }).then((result) => {
    if (result.isConfirmed) {
      let mensaje = result.value;
      let claveCuerpo = $("#claveCuerpoVisto_digital").val();
      let tipo = $("#tipoVisto_digital").val();
      let red = $("#redVisto_digital").val();
      let anio = $("#anioVisto_digital").val();
      $.ajax({
        url: "./updatePhase",
        type: "post",
        dataType: "json",
        data: {
          claveCuerpo: claveCuerpo,
          tipo: tipo,
          red: red,
          anio: anio,
          terminado: 2,
          mensaje: mensaje,
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "Exito",
            text: "Fase devuelta correctamente.",
          }).then(function () {
            location.reload()
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte a sistemas.",
          });
        },
      });
    }
  });
});

/* CAPS FINALES IMPRESOS */

const formImpresoFinal = document.querySelector("#formUploadImpresoFinal"),
  fileInputImpresoFinal = document.querySelector(".file-input-finalImpreso"),
  progressAreaImpresoFinal = document.querySelector(".progress-area-finalImpreso"),
  uploadedAreaImpresoFinal = document.querySelector(".uploaded-area-finalImpreso");

formImpresoFinal.addEventListener("click", () => {
  fileInputImpresoFinal.click();
});

fileInputImpresoFinal.onchange = ({ target }) => {
  const files = target.files;
  for (var i = 0; i < files.length; i++) {
    let file = target.files[i];
    if (file) {
      let fileName = file.name;
      if (fileName.length >= 12) {
        let splitName = fileName.split(".");
        fileName = splitName[0].substring(0, 20) + "... ." + splitName[1];
      }
      uploadFileImpresoFinal(fileName);
    }
  }
};

function uploadFileImpresoFinal(name) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./subir/final/impreso");
  xhr.upload.addEventListener("progress", ({ loaded, total }) => {
    let fileLoaded = Math.floor((loaded / total) * 100);
    let fileTotal = Math.floor(total / 1000);
    let fileSize;
    fileTotal < 1024
      ? (fileSize = fileTotal + " KB")
      : (fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB");
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Subiendo</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
                        uploadedAreaImpresoFinal.classList.add("onprogress");
                        progressAreaImpresoFinal.innerHTML = progressHTML;
    if (loaded == total) {
      xhr.addEventListener("load", () => {
        console.log(xhr);
        if (xhr.status === 200) {
          progressAreaImpresoFinal.innerHTML = "";
          let uploadedHTML = `<li class="row">
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span class="name">${name} • Subido / actualizado</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
                          uploadedAreaImpresoFinal.classList.remove("onprogress");
                          uploadedAreaImpresoFinal.insertAdjacentHTML("afterbegin", uploadedHTML);
        } else {
          progressAreaImpresoFinal.innerHTML = "";
          let uploadedHTML = `<li class="row" style='background: #e11919 !important;'>
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span>${name} • No se ha podido subir el archivo</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
                          uploadedAreaImpresoFinal.classList.remove("onprogress");
                          uploadedAreaImpresoFinal.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      });
    }
  });
  let data = new FormData(formImpresoFinal);
  xhr.send(data);
}

/* CAPS FINALES DIGITALES */

const formDigitalFinal = document.querySelector("#formUploadDigitalFinal"),
  fileInputDigitalFinal = document.querySelector(".file-input-finalDigital"),
  progressAreaDigitalFinal = document.querySelector(".progress-area-finalDigital"),
  uploadedAreaDigitalFinal = document.querySelector(".uploaded-area-finalDigital");

formDigitalFinal.addEventListener("click", () => {
  fileInputDigitalFinal.click();
});

fileInputDigitalFinal.onchange = ({ target }) => {
  const files = target.files;
  for (var i = 0; i < files.length; i++) {
    let file = target.files[i];
    if (file) {
      let fileName = file.name;
      if (fileName.length >= 12) {
        let splitName = fileName.split(".");
        fileName = splitName[0].substring(0, 20) + "... ." + splitName[1];
      }
      uploadFileDigitalFinal(fileName);
    }
  }
};

function uploadFileDigitalFinal(name) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./subir/final/digital");
  xhr.upload.addEventListener("progress", ({ loaded, total }) => {
    let fileLoaded = Math.floor((loaded / total) * 100);
    let fileTotal = Math.floor(total / 1000);
    let fileSize;
    fileTotal < 1024
      ? (fileSize = fileTotal + " KB")
      : (fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB");
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Subiendo</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
                        uploadedAreaDigitalFinal.classList.add("onprogress");
                        progressAreaDigitalFinal.innerHTML = progressHTML;
    if (loaded == total) {
      xhr.addEventListener("load", () => {
        console.log(xhr);
        if (xhr.status === 200) {
          progressAreaDigitalFinal.innerHTML = "";
          let uploadedHTML = `<li class="row">
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span class="name">${name} • Subido / actualizado</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
                          uploadedAreaDigitalFinal.classList.remove("onprogress");
                          uploadedAreaDigitalFinal.insertAdjacentHTML("afterbegin", uploadedHTML);
        } else {
          progressAreaDigitalFinal.innerHTML = "";
          let uploadedHTML = `<li class="row" style='background: #e11919 !important;'>
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span>${name} • No se ha podido subir el archivo</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
                          uploadedAreaDigitalFinal.classList.remove("onprogress");
                          uploadedAreaDigitalFinal.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      });
    }
  });
  let data = new FormData(formDigitalFinal);
  xhr.send(data);
}

/* AGRADECIMIENTOS IMPRESO */

const formImpresoAgrad = document.querySelector("#formUploadAgradecimientosImpreso"),
  fileInputImpresoAgrad = document.querySelector(".file-input-agradecimientosImpreso"),
  progressAreaImpresoAgrad = document.querySelector(".progress-area-agradecimientosImpreso"),
  uploadedAreaImpresoAgrad = document.querySelector(".uploaded-area-agradecimientosImpreso");

formImpresoAgrad.addEventListener("click", () => {
  fileInputImpresoAgrad.click();
});

fileInputImpresoAgrad.onchange = ({ target }) => {
  const files = target.files;
  for (var i = 0; i < files.length; i++) {
    let file = target.files[i];
    if (file) {
      let fileName = file.name;
      if (fileName.length >= 12) {
        let splitName = fileName.split(".");
        fileName = splitName[0].substring(0, 20) + "... ." + splitName[1];
      }
      uploadFileImpresoAgrad(fileName);
    }
  }
};

function uploadFileImpresoAgrad(name) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./subir/agradecimientos/impreso");
  xhr.upload.addEventListener("progress", ({ loaded, total }) => {
    let fileLoaded = Math.floor((loaded / total) * 100);
    let fileTotal = Math.floor(total / 1000);
    let fileSize;
    fileTotal < 1024
      ? (fileSize = fileTotal + " KB")
      : (fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB");
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Subiendo</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
                        uploadedAreaImpresoAgrad.classList.add("onprogress");
                        progressAreaImpresoAgrad.innerHTML = progressHTML;
    if (loaded == total) {
      xhr.addEventListener("load", () => {
        console.log(xhr);
        if (xhr.status === 200) {
          progressAreaImpresoAgrad.innerHTML = "";
          let uploadedHTML = `<li class="row">
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span class="name">${name} • Subido / actualizado</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
                          uploadedAreaImpresoAgrad.classList.remove("onprogress");
                          uploadedAreaImpresoAgrad.insertAdjacentHTML("afterbegin", uploadedHTML);
        } else {
          progressAreaImpresoAgrad.innerHTML = "";
          let uploadedHTML = `<li class="row" style='background: #e11919 !important;'>
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span>${name} • No se ha podido subir el archivo</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
                          uploadedAreaImpresoAgrad.classList.remove("onprogress");
                          uploadedAreaImpresoAgrad.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      });
    }
  });
  let data = new FormData(formImpresoAgrad);
  xhr.send(data);
}

/* AGRADECIMIENTOS DIGITAL */

const formDigitalAgrad = document.querySelector("#formUploadAgradecimientosDigital"),
  fileInputDigitalAgrad = document.querySelector(".file-input-agradecimientosDigital"),
  progressAreaDigitalAgrad = document.querySelector(".progress-area-agradecimientosDigital"),
  uploadedAreaDigitalAgrad = document.querySelector(".uploaded-area-agradecimientosDigital");

formDigitalAgrad.addEventListener("click", () => {
  fileInputDigitalAgrad.click();
});

fileInputDigitalAgrad.onchange = ({ target }) => {
  const files = target.files;
  for (var i = 0; i < files.length; i++) {
    let file = target.files[i];
    if (file) {
      let fileName = file.name;
      if (fileName.length >= 12) {
        let splitName = fileName.split(".");
        fileName = splitName[0].substring(0, 20) + "... ." + splitName[1];
      }
      uploadFileDigitalAgrad(fileName);
    }
  }
};

function uploadFileDigitalAgrad(name) {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "./subir/agradecimientos/digital");
  xhr.upload.addEventListener("progress", ({ loaded, total }) => {
    let fileLoaded = Math.floor((loaded / total) * 100);
    let fileTotal = Math.floor(total / 1000);
    let fileSize;
    fileTotal < 1024
      ? (fileSize = fileTotal + " KB")
      : (fileSize = (loaded / (1024 * 1024)).toFixed(2) + " MB");
    let progressHTML = `<li class="row">
                          <i class="fas fa-file-alt"></i>
                          <div class="content">
                            <div class="details">
                              <span class="name">${name} • Subiendo</span>
                              <span class="percent">${fileLoaded}%</span>
                            </div>
                            <div class="progress-bar">
                              <div class="progress" style="width: ${fileLoaded}%"></div>
                            </div>
                          </div>
                        </li>`;
                        uploadedAreaDigitalAgrad.classList.add("onprogress");
                        progressAreaDigitalAgrad.innerHTML = progressHTML;
    if (loaded == total) {
      xhr.addEventListener("load", () => {
        console.log(xhr);
        if (xhr.status === 200) {
          progressAreaDigitalAgrad.innerHTML = "";
          let uploadedHTML = `<li class="row">
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span class="name">${name} • Subido / actualizado</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
                          uploadedAreaDigitalAgrad.classList.remove("onprogress");
                          uploadedAreaDigitalAgrad.insertAdjacentHTML("afterbegin", uploadedHTML);
        } else {
          progressAreaDigitalAgrad.innerHTML = "";
          let uploadedHTML = `<li class="row" style='background: #e11919 !important;'>
                            <div class="content upload">
                              <i class="fas fa-file-alt"></i>
                              <div class="details">
                                <span>${name} • No se ha podido subir el archivo</span>
                                <span class="size">${fileSize}</span>
                              </div>
                            </div>
                            <i class="fas fa-check"></i>
                          </li>`;
                          uploadedAreaDigitalAgrad.classList.remove("onprogress");
                          uploadedAreaDigitalAgrad.insertAdjacentHTML("afterbegin", uploadedHTML);
        }
      });
    }
  });
  let data = new FormData(formDigitalAgrad);
  xhr.send(data);
}