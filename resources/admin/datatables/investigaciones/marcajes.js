let dataTable;
let dataTableIsInitialized = false;

const dataTableOptions = {
  scrollC: "2000px",
  lengthMenu: [5, 10, 15, 20, 100, 200, 500],
  columnDefs: [
    { className: "centered", targets: [0, 1, 2, 3, 4, 5, 6] },
    { orderable: false, targets: [6] },
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
    url: "./getListaMarcajes",
    type: "post",
  },
  columns: [
    { data: "id" },
    { data: "claveCuerpo" },
    { data: "tipo" },
    { data: "red" },
    { data: "anio" },
    {
      data: null,
      render: function (row) {
        if (row.atendido == "0") {
          return `<i class="fa-solid fa-triangle-exclamation text-warning"></i>`;
        } else if (row.atendido == 1) {
          return `<i class="fa-solid fa-circle-check text-success"></i>`;
        } else {
          return "Error";
        }
      },
    },
    {
      data: null,
      render: function (row) {
        if(row.atendido == 1){
          return `<a class='btn btn-md btn-success' href='./ver/${row.id}' target='_blank'>Ver marcaje</a>`
        }else if(row.atendido == 0){
          return `<button type='button' class='verArchivoMarcaje btn btn-md btn-info' data-red='${row.red}' data-anio='${row.anio}' data-tipo='${row.tipo}' data-clave='${row.claveCuerpo}' data-id=${row.id} ><i class='mdi mdi-eye' style='font-size: 0.8rem'></i>Ver marcaje</button>`;
        }else if(row.atendido == 2){
          return `<span class='text-danger'>Marcaje rechazado</span>`
        }
        
      },
    },
  ],
};

const initDataTable = async () => {
  if (dataTableIsInitialized) {
    dataTable.destroy();
  }

  dataTable = $("#dt_marcajes").DataTable(dataTableOptions);

  dataTableIsInitialized = true;
};

window.addEventListener("load", async () => {
  await initDataTable();
});

$(document).on("click", ".verArchivoMarcaje", function (e) {
  e.preventDefault();
  let claveCuerpo = $(this).data("clave");
  let anio = $(this).data("anio");
  let red = $(this).data("red");
  let tipo = $(this).data("tipo");
  let id = $(this).data("id");

  $("#iframeMarcaje").attr("src", `./ver/${id}`);

  $("#iframeMarcaje").on("load", function () {
    $("#claveCuerpo").val(claveCuerpo);
    $("#tipo").val(tipo);
    $("#red").val(red);
    $("#anio").val(anio);
    $(document).off("focusin.modal");
    $("#modalTitleMarcaje").text(`Marcaje - ${claveCuerpo}`);
    $("#modalVerMarcaje").modal("show");
  });
});

$(".aceptarMarcaje").on('click',function(e){
    Swal.fire({
        title: "¿Esta seguro que desea marcar el marcaje como atendido?",
        text: 'Ingrese el capítulo final con los marcajes atendidos',
        footer: "Esta accion no es reversible",
        icon: "warning",
        allowOutsideClick: false,
        allowEscapeKey: false,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí",
        cancelButtonText: "No",
        input: 'file',
        inputAttributes: {
            accept: '.pdf'
        },
      }).then((result) => {
        let claveCuerpo = $("#claveCuerpo").val();
        let tipo = $("#tipo").val();
        let red = $("#red").val();
        let anio = $("#anio").val();
        if (result.isConfirmed) {
            const fileInput = result.value;
            if (!fileInput) {
               Swal.fire({
                icon:'warning',
                title: 'Cuidado',
                text: 'Ningun archivo seleccionado'
               })
               return;
            }

            var formData = new FormData()
            formData.append("archivo", fileInput);
            formData.append("claveCuerpo", claveCuerpo);
            formData.append("tipo", tipo);
            formData.append("red", red);
            formData.append("anio", anio);
            formData.append("atendido", 1);

          $.ajax({
            url: "./updateMarcaje",
            type: "post",
            dataType: "json",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
              Swal.fire({
                icon: "success",
                title: "Exito",
                text: "Marcaje atendido correctamente.",
              }).then(function () {
                location.reload()
              });
            },
            error: function (jqXHR) {
                console.error(jqXHR);
              Swal.fire({
                icon: "error",
                title: `Error ${jqXHR.status}`,
                text: "Contacte a sistemas.",
              });
            },
          });
        }
      });
})

$(".rechazarMarcaje").on('click',function(e){
  Swal.fire({
      title: "¿Esta seguro que desea marcar el marcaje como rechazado?",
      text: 'Esta accion no es reversible',
      icon: "warning",
      allowOutsideClick: false,
      allowEscapeKey: false,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí",
      cancelButtonText: "No",
    }).then((result) => {
      let claveCuerpo = $("#claveCuerpo").val();
      let tipo = $("#tipo").val();
      let red = $("#red").val();
      let anio = $("#anio").val();
      if (result.isConfirmed) {

          var formData = new FormData()
          formData.append("claveCuerpo", claveCuerpo);
          formData.append("tipo", tipo);
          formData.append("red", red);
          formData.append("anio", anio);
          formData.append("atendido", 2);

        $.ajax({
          url: "./updateMarcaje",
          type: "post",
          dataType: "json",
          data: formData,
          contentType: false,
          processData: false,
          success: function (data) {
              console.log(data);
            Swal.fire({
              icon: "success",
              title: "Exito",
              text: "Marcaje rechazado correctamente.",
            }).then(function () {
              location.reload()
            });
          },
          error: function (jqXHR) {
              console.error(jqXHR);
            Swal.fire({
              icon: "error",
              title: `Error ${jqXHR.status}`,
              text: "Contacte a sistemas.",
            });
          },
        });
      }
    });
})