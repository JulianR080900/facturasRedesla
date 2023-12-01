$(document).ready(function (e) {
  $(".sendLogo").prop("disabled", true);
  $("#tableArchivos").DataTable(dataTableOptionsFiles);
});



$(document).on("click", ".changeStatus", function () {
  var id = $(this).data("id");
  var folio = $(this).data("folio");
  $("#id_cuestionario").val(id);
});

$(".btnClipboard").on("click", function () {
  console.log('Hola');
  let copyText = document.querySelector(".btnClipboard");
  text = $("#txt_clipboard").html();
  $("#iconClip").removeClass("fa-clone").addClass("fa-check-circle");
  navigator.clipboard.writeText(text);
  copyText.classList.add("active");
  window.getSelection().removeAllRanges();
  setTimeout(() => {
    copyText.classList.remove("active");
    $("#iconClip").removeClass("fa-check-circle").addClass("fa-clone");
  }, 2500);
  //$("#iconClip").removeClass('fa-check').addClass('fa-clone')
});

const form = document.querySelector('[name="form"]');
if (form != null) {
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    var id_cuestionario = $("#id_cuestionario").val();
    var selectStatus = $("#selectStatus option:selected").val();
    let nombre_investigacion = $("#nombre_investigacion").val();
    if (selectStatus == "") {
      alert("Selecciona una validación");
      return;
    }
    $.ajax({
      type: "POST",
      url: "../updateStatusEncuesta",
      data: {
        id_cuestionario: id_cuestionario,
        selectStatus: selectStatus,
        tabla: nombre_investigacion,
      },
      success: function (data) {
        $("#myModal").modal("hide");
        initDataTablePlus();
      },
      error: function (jqXHR) {
        Swal.fire({
          icon: "error",
          title: `Error ${jqXHR.status}`,
          text: "Intente mas tarde o contacte con el equipo Redesla.",
        });
      },
    });
  });
}

$(document).on("click", "#terminarProcesoCapturaEncuestas", function (e) {
  swal.fire({
    icon: "warning",
    title:
      "¿Desea cerrar captura y enviar revisión de validación de encuestas?",
    text: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",

    preConfirm: function () {
      return new Promise(function (resolve) {
        $.ajax({
          type: "POST",
          url: "../terminar",
          dataType: "json",
          data: { proyecto: proyecto },
          success: function (respuesta) {
            if (respuesta.codigo == 200) {
              Swal.fire({
                icon: "success",
                title: respuesta.title,
                text: respuesta.mensaje,
              }).then(function () {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Error " + respuesta.codigo,
                text: respuesta.mensaje,
              }).then(function () {
                location.reload();
              });
            }
          },
          error: function (xhr, status, error) {
            if (xhr.status == 401) {
              //Sesion expiro
              location.reload();
            } else {
              Swal.fire({
                icon: "error",
                title: "Error " + xhr.status,
                text: "Ha ocurrido un error. Contacte a sistemas.",
              }).then(function () {
                location.reload();
              });
            }
          },
        });
      });
    },
    allowOutsideClick: false,
  });
});

let dataTablePlus;
let dataTableIsInitializedPlus = false;
red = red.toLowerCase();
let url = anio > 2023 ? `../getListadoEncuestas/${anio}` : `../getListadoCuestionarios/cuestionarios_${red}_${anio}`

const dataTableOptionsPlus = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 15, 20, 100, 200, 500],
  columnDefs: [
    { className: "centered", targets: [ 1, 2, 3,4] },
    { orderable: false, targets: [4] },
    {
      className: 'dtr-control',
      orderable: false,
      target: 0
    },
    //{ width: '50%', targets: [0]},
    //{ sercheable: false, targets: [2]} //Quita el buscar en esas columnas
  ],
  rowReorder: {
    selector: "td:nth-child(2)",
  },
  order: [1, 'asc'],
  responsive: {
      details: {
          type: 'column',
          target: 'tr'
      }
  },
  scrollX: true,
  responsive: true,
  pageLength: 10, //Numero de registros por pagina
  destroy: true, //Decimos que la tabla es destruible
  language: {
    lengthMenu: "Mostrar _MENU_ registros por página",
    zeroRecords: "Ningun registro encontrado",
    info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
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
    url: url,
    type: "get",
  },
  columns: [
    {
      data:null,
      render: function(){
        return `Expandir`
      }
    },
    { data: "folio" },
    { data: "nombre_encuestador" },
    {
      data: null,
      render: function (row) {
        if (row.estado == 0) {
          return `<a class="changeStatus" data-toggle="modal" data-target="#myModal" data-id="${row.id}" data-folio="${row.folio}"><i class="fas fa-info-circle"></i> Encuesta solo ingresada. Realizar acciones</a>`;
        } else if (row.estado == 1) {
          return `<a class="changeStatus" data-toggle="modal" data-target="#myModal" data-id="${row.id}" data-folio="${row.folio}"><i class="fas fa-check-circle verde"></i> La encuesta es válida y debe ser considerada.</a>`;
        } else if (row.estado == 2) {
          return `<a class="changeStatus" data-toggle="modal" data-target="#myModal" data-id="${row.id}" data-folio="${row.folio}"><i class="fas fa-times-circle text-danger"></i> La encuesta tiene más de 20 ítem erróneos o vacíos (incompleto).</a>`;
        } else if (row.estado == 3) {
          return `<a class="changeStatus" data-toggle="modal" data-target="#myModal" data-id="${row.id}" data-folio="${row.folio}"><i class="fas fa-ban text-danger"></i> La encuesta no es válida.</a>`;
        } else if (row.estado == 4) {
          return `<a class="changeStatus" data-toggle="modal" data-target="#myModal" data-id="${row.id}" data-folio="${row.folio}"><i class="fas fa-recycle text-warning"></i> La encuesta se volvió a capturar y será sustituido por otro folio válido.</a>`;
        } else if (row.estado == 5) {
          return `<a class="changeStatus" data-toggle="modal" data-target="#myModal" data-id="${row.id}" data-folio="${row.folio}"><i class="fas fa-vial text-info"></i> La encuesta es de prueba y no será sustituido por otro folio.</a>`;
        } else {
          return `Contacte a sistema Redesla.`;
        }
      },
    },
    {
      data: null,
      render: function (row) {
        return `<a class="changeExcelModal" data-id="${row.id}" data-folio="${row.folio}" title="Ver encuesta" ><i class="fa-solid fa-eye" style="color: --font-color-primary; font-size: 1rem"></i></a>`;
      },
    },
  ],
};

const dataTableOptionsFiles = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 15, 20, 100, 200, 500],
  columnDefs: [
    { className: "centered", targets: [1, 2, 3,4,5] },
    { orderable: false, targets: [0,4,5] },
    {
      className: 'dtr-control',
      orderable: false,
      target: 0
    },
    { width: '50%', targets: [0]},
    //{ sercheable: false, targets: [2]} //Quita el buscar en esas columnas
  ],
  order: [1, 'asc'],
  responsive: {
      details: {
          type: 'column',
          target: 'tr'
      }
  },
  scrollX: true,
  responsive:true,
  rowReorder: {
    selector: "td:nth-child(2)",
  },
  pageLength: 10, //Numero de registros por pagina
  destroy: true, //Decimos que la tabla es destruible
  language: {
    lengthMenu: "Mostrar _MENU_ registros por página",
    zeroRecords: "Ningun registro encontrado",
    info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
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
  }
};

const initDataTablePlus = async () => {
  if (dataTableIsInitializedPlus) {
    dataTablePlus.destroy();
  }

  dataTablePlus = $("#dt_investigacion").DataTable(dataTableOptionsPlus);

  dataTableIsInitializedPlus = true;
};

window.addEventListener("load", async () => {
  if(anio !== undefined || anio !== null){
    await initDataTablePlus();
  }
});

$(document).on("click", ".changeExcelModal", function (e) {
  $("#modalExcel").modal("hide");
  e.preventDefault();
  let id = $(this).data("id");
  let folio = $(this).data("folio");
  console.log(folio);
  let nombre_investigacion = $("#nombre_investigacion").val();
  $("#titleModalExcel").text(`Datos de la encuesta con folio: ${folio}`);
  $.ajax({
    type: "POST",
    url: "../getInfoEncuesta",
    data: {
      id: id,
      tabla: nombre_investigacion,
      anio: anio,
    },
    dataType: "json",
    success: function (data) {
      const columnas = data.columnas;
      const valores = data.data;
      generateExcel(columnas, valores);
      $("#modalExcel").modal("show");
    },
    error: function (jqXHR) {
      Swal.fire({
        icon: 'warning',
        title: 'Lo sentimos',
        text: jqXHR.responseText
      })
      console.log(jqXHR);
    },
  });
});

function generateExcel(columnas, valores) {
  $("#spreadsheet").empty();
  jspreadsheet(document.getElementById("spreadsheet"), {
    data: valores,
    columns: columnas,
    minDimensions: [2, 10],
  });
}

$("#modalExcel").on("hidden.bs.modal", function (e) {
  $("#spreadsheet").empty();
});

$(".revision").on("click", function (e) {
  e.preventDefault();
  Swal.fire({
    icon: "warning",
    title:
      "¿Desea cerrar captura y enviar revisión de validación de encuestas?",
    text: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: {
          anio: anio,
        },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Fase enviada a revisión.",
          }).then(function () {
            location.reload();
          });
        },
        error: function (jqXHR) {
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          });
        },
      });
    }
  });
});

async function getMiembros() {
  let url = "../getMiembros";
  try {
    let res = await fetch(url);
    return await res.json();
  } catch (error) {
    console.log(error);
  }
}

async function renderMiembros(id) {
  let miembros = await getMiembros();

  const ul = document.querySelector("ul#" + id);
  ul.innerHTML = "";
  let html = "";
  miembros.forEach((miembro, i) => {
    const li = document.createElement("li");
    li.setAttribute("list-pos", i);
    li.innerHTML = `
              <div class='user'>
                  <img src='${base_url}/resources/img/profiles/${miembro.profile_pic}' >
                  <div class='info'>
                      <input type='text' name='usuarios[]' id='usuario_${miembro.usuario}' hidden value='${miembro.usuario}' />
                      <h2>${miembro.nombre}</h2>
                      <p>${miembro.especialidad}</p>
                  </div>
              </div>
              <h1 class='icon'>&#10978</h1>
              `;
    ul.appendChild(li);
  });
  listentoEvents(miembros, id);
}

function listentoEvents(miembros, id) {
  const ul = document.querySelector("ul#" + id);
  let lists = ul.querySelectorAll("li"),
    current_pos,
    drop_pos;
  for (let li of lists) {
    li.draggable = true;

    li.ondragstart = function () {
      current_pos = this.getAttribute("list-pos");
      ul.style.height = ul.clientHeight + "px";
      setTimeout(() => {
        this.style.display = "none";
      }, 0);
      ul.style.height = ul.clientHeight - this.clientHeight + "px";
    };
    li.ondragenter = () => li.classList.add("active");
    li.ondragleave = () => li.classList.remove("active");
    li.ondragend = function () {
      this.style.display = "flex";
      if (drop_pos === undefined) {
        console.log("enter");
        ul.style.height = ul.clientHeight + this.clientHeight + "px";
      }
      for (let active_list of lists) {
        active_list.classList.remove("active");
      }
    };
    li.ondragover = (e) => e.preventDefault();
    li.ondrop = function (e) {
      e.preventDefault();
      ul.style.height = ul.clientHeight + this.clientHeight + "px";
      drop_pos = this.getAttribute("list-pos");
      miembros.splice(drop_pos, 0, miembros.splice(current_pos, 1)[0]);
      renderMiembrosAfter(miembros, id);
    };
  }
}

function renderMiembrosAfter(newMiembros, id) {
  const ul = document.querySelector("ul#" + id);
  ul.innerHTML = "";
  console.log(newMiembros);
  newMiembros.forEach((miembro, i) => {
    const li = document.createElement("li");
    li.setAttribute("list-pos", i);
    li.innerHTML = `
      <div class='user'>
          <img src='${base_url}/resources/img/profiles/${miembro.profile_pic}' >
          <div class='info'>
          <input type='text' name='usuarios[]' id='usuario_${miembro.usuario}' hidden value='${miembro.usuario}' />
              <h2>${miembro.nombre}</h2>
              <p>${miembro.especialidad}</p>
          </div>
      </div>
      <h1 class='icon'>&#10978</h1>
      `;
    ul.appendChild(li);
  });
  listentoEvents(newMiembros, id);
}

function getInputsFromAutores(tipo) {
  const input = [];

  // Selecciona los elementos input dentro del elemento ul con id "impreso"
  $(`#${tipo} li input[name='usuarios[]']`).each(function () {
    const value = $(this).val();
    input.push(value);
  });

  return input;
}

const resumenImpreso = document.getElementById("resumenImpreso");
const wordCountResumenImpreso = document.getElementById(
  "wordCountResumenImpreso"
);

const resumenDigital = document.getElementById("resumenDigital");
const wordCountResumenDigital = document.getElementById(
  "wordCountResumenDigital"
);

if (resumenImpreso !== null) {
  resumenImpreso.addEventListener("input", function () {
    //AQUI 70 ES MINIMO Y 100 ES PAXIMO
    const text = resumenImpreso.value;
    const words = text.trim().split(/\s+/);

    if (words.length < 70) {
      wordCountResumenImpreso.style.setProperty("color", "red", "important");
    } else if (words.length >= 70 && words.length <= 100) {
      wordCountResumenImpreso.style.setProperty(
        "color",
        "lightgreen",
        "important"
      );
    } else if (words.length > 100) {
      wordCountResumenImpreso.style.setProperty("color", "red", "important");
    }
    wordCountResumenImpreso.textContent = text.trim() === "" ? 0 : words.length;
  });

  resumenImpreso.addEventListener("paste", function (e) {
    e.preventDefault();
    const text = e.clipboardData.getData("text/plain");
    const textWithoutNewlines = text.replace(/(\r\n|\n|\r)/gm, " ");
    document.execCommand("insertText", false, textWithoutNewlines);
  });
}

if (resumenDigital !== null) {
  resumenDigital.addEventListener("input", function () {
    //AQUI 70 ES MINIMO Y 100 ES PAXIMO
    const text = resumenDigital.value;
    const words = text.trim().split(/\s+/);

    if (words.length < 70) {
      wordCountResumenDigital.style.setProperty("color", "red", "important");
    } else if (words.length >= 70 && words.length <= 100) {
      wordCountResumenDigital.style.setProperty(
        "color",
        "lightgreen",
        "important"
      );
    } else if (words.length > 100) {
      wordCountResumenDigital.style.setProperty("color", "red", "important");
    }
    wordCountResumenDigital.textContent = text.trim() === "" ? 0 : words.length;
  });

  resumenDigital.addEventListener("paste", function (e) {
    e.preventDefault();
    const text = e.clipboardData.getData("text/plain");
    const textWithoutNewlines = text.replace(/(\r\n|\n|\r)/gm, " ");
    document.execCommand("insertText", false, textWithoutNewlines);
  });
}

$(".btnResumenImpreso").on("click", function (e) {
  e.preventDefault();
  const resumenImpreso = document.getElementById("resumenImpreso");
  const text = resumenImpreso.value;
  const words = text.trim().split(/\s+/);

  if (words.length < 70 || words.length > 100) {
    Swal.fire({
      icon: "warning",
      title: "Lo sentimos",
      text: "El resumen debe de constar de un mínimo de 70 palabras y un máximo de 100.",
    });
    return;
  }

  Swal.fire({
    icon: "warning",
    title:
      "¿Desea cerrar captura y enviar revisión el resumen de la obra impresa?",
    text: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: {
          anio: anio,
          resumen: text,
          obra: "impreso",
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Fase enviada a revisión.",
          }).then(function () {
            location.reload();
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          });
        },
      });
    }
  });
});

$(".btnResumenDigital").on("click", function (e) {
  e.preventDefault();
  const resumenDigital = document.getElementById("resumenDigital");
  const text = resumenDigital.value;
  const words = text.trim().split(/\s+/);

  if (words.length < 70 || words.length > 100) {
    Swal.fire({
      icon: "warning",
      title: "Lo sentimos",
      text: "El resumen debe de constar de un mínimo de 70 palabras y un máximo de 100.",
    });
    return;
  }

  Swal.fire({
    icon: "warning",
    title:
      "¿Desea cerrar captura y enviar revisión el resumen de la obra impresa?",
    text: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: {
          anio: anio,
          resumen: text,
          obra: "digital",
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Fase enviada a revisión.",
          }).then(function () {
            location.reload();
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          });
        },
      });
    }
  });
});

var inputKeyImpreso = document.querySelector("input[name=tagsImpreso]");

if (inputKeyImpreso !== null) {
  var tagify = new Tagify(inputKeyImpreso);
}

$(".btnKeyImpreso").on("click", function (e) {
  e.preventDefault();
  var tags = tagify.value.map(function (tag) {
    return tag.value; // Acceder al valor (texto) de cada etiqueta
  });

  if (tags.length < 3 || tags.length > 5) {
    Swal.fire({
      icon: "warning",
      title: "Cuidado",
      text: "Solo puede haber un mínimo de 3 y un máximo de 5 palabras clave.",
    });
    return;
  }

  Swal.fire({
    icon: "warning",
    title: "¿Desea cerrar captura de palabras clave de su obra impresa?",
    text: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: {
          anio: anio,
          tags: tags,
          obra: "impreso",
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Palabras clave de su obra impresa registradas correctamente.",
          }).then(function () {
            location.reload();
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          });
        },
      });
    }
  });
});

var inputKeyDigital = document.querySelector("input[name=tagsDigital]");

if (inputKeyDigital !== null) {
  var tagifyDigital = new Tagify(inputKeyDigital);
}

$(".btnKeyDigital").on("click", function (e) {
  e.preventDefault();
  var tags = tagifyDigital.value.map(function (tag) {
    return tag.value; // Acceder al valor (texto) de cada etiqueta
  });

  if (tags.length < 3 || tags.length > 5) {
    Swal.fire({
      icon: "warning",
      title: "Cuidado",
      text: "Solo puede haber un mínimo de 3 y un máximo de 5 palabras clave.",
    });
    return;
  }

  Swal.fire({
    icon: "warning",
    title: "¿Desea cerrar captura de palabras clave de su obra impresa?",
    text: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: {
          anio: anio,
          tags: tags,
          obra: "digital",
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Palabras clave de su obra digital registradas correctamente.",
          }).then(function () {
            location.reload();
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          });
        },
      });
    }
  });
});

function tagTemplate(tagData) {
  return `
                <tag title="${tagData.email}"
                        contenteditable='false'
                        spellcheck='false'
                        tabIndex="-1"
                        class="tagify__tag ${
                          tagData.class ? tagData.class : ""
                        }"
                        ${this.getAttributes(tagData)}>
                    <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                    <div>
                        <div class='tagify__tag__avatar-wrap'>
                            <img onerror="this.style.visibility='hidden'" src="${
                              tagData.avatar
                            }">
                        </div>
                        <span class='tagify__tag-text'>${tagData.name}</span>
                    </div>
                </tag>
            `;
}

function suggestionItemTemplate(tagData) {
  return `
                <div ${this.getAttributes(tagData)}
                    class='tagify__dropdown__item ${
                      tagData.class ? tagData.class : ""
                    }'
                    tabindex="0"
                    role="option">
                    ${
                      tagData.avatar
                        ? `
                    <div class='tagify__dropdown__item__avatar-wrap'>
                        <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                    </div>`
                        : ""
                    }
                    <strong>${tagData.name}</strong>
                    <span>${tagData.email}</span>
                </div>
            `;
}

function dropdownHeaderTemplate(suggestions) {
  return `
                <div class="${this.settings.classNames.dropdownItem} ${
    this.settings.classNames.dropdownItem
  }__addAll">
                    <strong>${
                      this.value.length
                        ? `Add remaning ${suggestions.length}`
                        : "Add All"
                    }</strong>
                    <span>${suggestions.length} members</span>
                </div>
            `;
}

async function obtenerWhitelistData() {
  try {
    // Realiza una petición asincrónica para obtener los datos
    const response = await fetch("../getMiembros");
    if (!response.ok) {
      throw new Error("No se pudo obtener la whitelist");
    }

    // Parsea la respuesta como JSON
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error al obtener datos de la whitelist:", error);
    return [];
  }
}

var tagifyOrdenImpreso;
var tagifyOrdenDigital;
if( typeof(fase) != 'undefined' ){
  if(fase == 3){
    obtenerWhitelistData().then((data) => {
      // initialize Tagify on the above input node reference
      var inputAutoresImpreso = document.querySelector('input[name="inputAutoresImpreso"]');
      var inputAutoresDigital = document.querySelector('input[name="inputAutoresDigital"]');

      if(inputAutoresImpreso !== undefined){
        tagifyOrdenImpreso = new Tagify(inputAutoresImpreso, {
          tagTextProp: "name", // very important since a custom template is used with this property as text
          // enforceWhitelist: true,
          skipInvalid: true, // do not remporarily add invalid tags
          dropdown: {
            closeOnSelect: false,
            enabled: 0,
            classname: "users-list",
            searchKeys: ["name"], // very important to set by which keys to search for suggesttions when typing
          },
          templates: {
            tag: tagTemplate,
            dropdownItem: suggestionItemTemplate,
            /* dropdownHeader: dropdownHeaderTemplate */
          },
          whitelist: data,
          transformTag: (tagData, originalData) => {
            var { name, email } = parseFullValue(tagData.name);
            tagData.name = name;
            tagData.email = email || tagData.email;
          },
          validate({ name, email }) {
            // when editing a tag, there will only be the "name" property which contains name + email (see 'transformTag' above)
            if (!email && name) {
              var parsed = parseFullValue(name);
              name = parsed.name;
              email = parsed.email;
            }
      
            if (!name) return "Missing name";
            if (!validateEmail(email)) return "Invalid email";
      
            return true;
          },
        });
      }

      if(inputAutoresDigital !== undefined){
        tagifyOrdenDigital = new Tagify(inputAutoresDigital, {
          tagTextProp: "name", // very important since a custom template is used with this property as text
          // enforceWhitelist: true,
          skipInvalid: true, // do not remporarily add invalid tags
          dropdown: {
            closeOnSelect: false,
            enabled: 0,
            classname: "users-list",
            searchKeys: ["name"], // very important to set by which keys to search for suggesttions when typing
          },
          templates: {
            tag: tagTemplate,
            dropdownItem: suggestionItemTemplate,
            /* dropdownHeader: dropdownHeaderTemplate */
          },
          whitelist: data,
          transformTag: (tagData, originalData) => {
            var { name, email } = parseFullValue(tagData.name);
            tagData.name = name;
            tagData.email = email || tagData.email;
          },
          validate({ name, email }) {
            // when editing a tag, there will only be the "name" property which contains name + email (see 'transformTag' above)
            if (!email && name) {
              var parsed = parseFullValue(name);
              name = parsed.name;
              email = parsed.email;
            }
      
            if (!name) return "Missing name";
            if (!validateEmail(email)) return "Invalid email";
      
            return true;
          },
        });
      }
      
    
    
    });
  }
}

function onEditStart({ detail: { tag, data } }) {
  tagify.setTagTextNode(tag, `${data.name} <${data.email}>`);
}

// https://stackoverflow.com/a/9204568/104380
function validateEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function parseFullValue(value) {
  // https://stackoverflow.com/a/11592042/104380
  var parts = value.split(/<(.*?)>/g),
    name = parts[0].trim(),
    email = parts[1]?.replace(/<(.*?)>/g, "").trim();

  return { name, email };
}

async function getCountMiembros(){
  try {
    // Realiza una petición asincrónica para obtener los datos
    const response = await fetch("../getMiembros");
    if (!response.ok) {
      throw new Error("No se pudo obtener la whitelist");
    }

    // Parsea la respuesta como JSON
    const data = await response.json();
    return data.length;
  } catch (error) {
    console.error("Error al obtener datos de la whitelist:", error);
    return [];
  }
}

$(".ordenAutores").on("click", async function (e) {
  e.preventDefault();
  const autores = {};
  let htmlAutores = ``;
  if (esquema == "B") {
    htmlAutores += '<h4><b>Orden de obra impresa</b></h4>'
    var tagsImpreso = tagifyOrdenImpreso.value.map(function (tag,index) {
      htmlAutores += `<p>${index+1} - ${tag.name}</p>`
      return tag.value; // Acceder al valor (texto) de cada etiqueta
    });
    htmlAutores += '<h4><b>Orden de obra digital</b></h4>'
    var tagsDigital = tagifyOrdenDigital.value.map(function (tag, index) {
      htmlAutores += `<p>${index+1} - ${tag.name}</p>`
      return tag.value; // Acceder al valor (texto) de cada etiqueta
    });
    autores.impreso = tagsImpreso;
    autores.digital = tagsDigital;
  } else {
    htmlAutores += '<h4><b>Orden de obra digital</b></h4>'
    var tagsDigital = tagifyOrdenDigital.value.map(function (tag, index) {
      htmlAutores += `<p>${index+1} - ${tag.name}</p>`
      return tag.value; // Acceder al valor (texto) de cada etiqueta
    });
    autores.digital = tagsDigital;
  }

  let countMiembros = await getCountMiembros()

  if(autores.impreso.length < countMiembros || autores.impreso.length > countMiembros){
    Swal.fire({
      title: 'Cuidado',
      icon: 'warning',
      text: 'La cantidad de miembros en su orden de autores de la obra impresa no coincide con la cantidad de miembros de su equipo.'
    })
    return;
  }

  if(autores.digital.length < countMiembros || autores.digital.length > countMiembros){
    Swal.fire({
      title: 'Cuidado',
      icon: 'warning',
      text: 'La cantidad de miembros en su orden de autores de la obra digital no coincide con la cantidad de miembros de su equipo.'
    })
    return;
  }

  

  Swal.fire({
    icon: "warning",
    title: "¿Desea cerrar captura y registrar el orden de sus autores?",
    html: htmlAutores,
    footer: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: {
          anio: anio,
          autores: autores,
        },
        success: function (data) {
          console.log(data);
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Orden de autores registrados correctamente.",
          }).then(function () {
            location.reload();
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          });
        },
      });
    }
  });
});

var lenghtMinDiscusion = 250;
var lenghtMaxDiscusion = 500;

const discusionImpreso = document.getElementById("discusionImpreso");
const wordCountDiscusionImpreso = document.getElementById(
  "wordCountDiscusionImpreso"
);

if (discusionImpreso !== null) {
  discusionImpreso.addEventListener("input", function () {
    //AQUI 70 ES MINIMO Y 100 ES PAXIMO
    const text = discusionImpreso.value;
    const words = text.trim().split(/\s+/);

    if (words.length < lenghtMinDiscusion || words.length > lenghtMaxDiscusion) {
      wordCountDiscusionImpreso.style.setProperty("color", "red", "important");
    } else if (words.length >= lenghtMinDiscusion && words.length <= lenghtMaxDiscusion) {
      wordCountDiscusionImpreso.style.setProperty(
        "color",
        "lightgreen",
        "important"
      );
    }
    wordCountDiscusionImpreso.textContent = text.trim() === "" ? 0 : words.length;
  });

  discusionImpreso.addEventListener("paste", function (e) {
    e.preventDefault();
    const text = e.clipboardData.getData("text/plain");
    const textWithoutNewlines = text.replace(/(\r\n|\n|\r)/gm, " ");
    document.execCommand("insertText", false, textWithoutNewlines);
  });
}

$(".btnDiscusionImpreso").on('click',function(e){
  e.preventDefault()
  const discusionImpreso = document.getElementById("discusionImpreso");
  const text = discusionImpreso.value;
  const words = text.trim().split(/\s+/);

  if (words.length < lenghtMinDiscusion || words.length > lenghtMaxDiscusion) {
    Swal.fire({
      icon: "warning",
      title: "Lo sentimos",
      text: `La discusión debe de constar de un mínimo de ${lenghtMinDiscusion} palabras y un máximo de ${lenghtMaxDiscusion}.`,
    });
    return;
  }

  Swal.fire({
    icon: "warning",
    title: "¿Desea cerrar captura y guardar la discusión de la obra impresa?",
    text: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: {
          anio: anio,
          discusion: text,
          obra: "impreso",
        },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Discusión guardada correctamente.",
          }).then(function () {
            location.reload();
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          });
        },
      });
    }
  });

})

const discusionDigital = document.getElementById("discusionDigital");
const wordCountDiscusionDigital = document.getElementById(
  "wordCountDiscusionDigital"
);

if (discusionDigital !== null) {
  discusionDigital.addEventListener("input", function () {
    //AQUI 70 ES MINIMO Y 100 ES PAXIMO
    const text = discusionDigital.value;
    const words = text.trim().split(/\s+/);

    if (words.length < lenghtMinDiscusion || words.length > lenghtMaxDiscusion) {
      wordCountDiscusionDigital.style.setProperty("color", "red", "important");
    } else if (words.length >= lenghtMinDiscusion && words.length <= lenghtMaxDiscusion) {
      wordCountDiscusionDigital.style.setProperty(
        "color",
        "lightgreen",
        "important"
      );
    }
    wordCountDiscusionDigital.textContent = text.trim() === "" ? 0 : words.length;
  });

  discusionDigital.addEventListener("paste", function (e) {
    e.preventDefault();
    const text = e.clipboardData.getData("text/plain");
    const textWithoutNewlines = text.replace(/(\r\n|\n|\r)/gm, " ");
    document.execCommand("insertText", false, textWithoutNewlines);
  });
}

$(".btnDiscusionDigital").on('click',function(e){
  e.preventDefault()
  const discusionDigital = document.getElementById("discusionDigital");
  const text = discusionDigital.value;
  const words = text.trim().split(/\s+/);

  if (words.length < lenghtMinDiscusion || words.length > lenghtMaxDiscusion) {
    Swal.fire({
      icon: "warning",
      title: "Lo sentimos",
      text: `La discusión debe de constar de un mínimo de ${lenghtMinDiscusion} palabras y un máximo de ${lenghtMaxDiscusion}.`,
    });
    return;
  }

  Swal.fire({
    icon: "warning",
    title: "¿Desea cerrar captura y guardar la discusión de la obra digital?",
    text: "Esta acción no es reversible",
    allowOutsideClick: false,
    allowEscapeKey: false,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: {
          anio: anio,
          discusion: text,
          obra: "digital",
        },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Discusión guardada correctamente.",
          }).then(function () {
            location.reload();
          });
        },
        error: function (jqXHR) {
          console.log(jqXHR);
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          });
        },
      });
    }
  });

})


$("textarea").on("input", function(event) {
  const inputText = $(this).val();
  if(inputText == ' '){
    $(this).val(inputText.slice(0, -1));
    return;
  }
  const lastChar = inputText.slice(-1);
  const secondLastChar = inputText.slice(-2, -1);
  const isSpace = lastChar === " " && secondLastChar === " ";

  if (isSpace) {
    $(this).val(inputText.slice(0, -1));
  }
});








/* const resumenDigital = document.getElementById("resumenDigital");
const wordCountResumenDigital = document.getElementById(
  "wordCountResumenDigital"
); */



/* if (resumenDigital !== null) {
  resumenDigital.addEventListener("input", function () {
    //AQUI 70 ES MINIMO Y 100 ES PAXIMO
    const text = resumenDigital.value;
    const words = text.trim().split(/\s+/);

    if (words.length < 70) {
      wordCountResumenDigital.style.setProperty("color", "red", "important");
    } else if (words.length >= 70 && words.length <= 100) {
      wordCountResumenDigital.style.setProperty(
        "color",
        "lightgreen",
        "important"
      );
    } else if (words.length > 100) {
      wordCountResumenDigital.style.setProperty("color", "red", "important");
    }
    wordCountResumenDigital.textContent = text.trim() === "" ? 0 : words.length;
  });

  resumenDigital.addEventListener("paste", function (e) {
    e.preventDefault();
    const text = e.clipboardData.getData("text/plain");
    const textWithoutNewlines = text.replace(/(\r\n|\n|\r)/gm, " ");
    document.execCommand("insertText", false, textWithoutNewlines);
  });
} */