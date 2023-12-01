let btn = "<?= $btn_facturar ?>";
btn == "disabled"
  ? $(".submitUpdate")
      .text("Debe validar los pagos para validar la factura")
      .attr("title", "Debe validar los pagos para validar la factura")
      .prop("disabled", true)
  : "Establecer factura emitida";


const keys = {}

$(document).ready(async function (e) {
  $("#tipo_cambio").hide();
  $("#loaderCustom").hide();

  await getEmpresas();

});



$(".rechazar").on("click", function () {
  Swal.fire({
    icon: "info",
    title: "Estas seguro que deseas rechazar los datos de facturación?",
    text: "Escriba en la parte de abajo el motivo del rechazo de la información de la factura.",
    footer:
      '<span class="text-center text-danger">*Esta factura se eliminara para el usuario y tendra que hacer una nueva.</span>',
    showCancelButton: true,
    cancelButtonText: "Cancelar",
    confirmButtonText: "Sí, rechazar",
    input: "text",
    inputAttributes: {
      autocapitalize: "off",
    },
  }).then((result) => {
    if (result.isConfirmed) {
      let mensaje = result.value;
      let id_factura = $("#id_factura").val();

      $.ajax({
        type: "post",
        dataType: "json",
        url: "../rechazar",
        data: {
          mensaje,
          id_factura,
        },
        beforeSend: function () {
          $(".rechazar").prop("disabled", true);
        },
        success: function (data) {
          Swal.fire({
            icon: "success",
            title: data.title,
            text: data.text,
          }).then(function () {
            window.location.href = "../lista";
          });
        },
        error: function (jqXHR) {
          $(".rechazar").prop("disabled", false);
          Swal.fire({
            icon: "error",
            title: "Error " + jqXHR.status,
            text: jqXHR.responseText,
          }).then(function () {
            window.location.href = "../lista";
          });
        },
      });
    }
  });
});

$("#facturaCFDI").on("click", async function (e) {
  //COMPROBAMOS QUE HAYA SELECCIONADO UNA EMPRESA
  e.preventDefault()

  let empresaSelecionada = $("#selectEmpresa option:selected").val()

  if(empresaSelecionada === '' || keys.length === 0 || keys === undefined){
    Swal.fire({
      icon: 'warning',
      title: 'Seleccione una empresa con la que desea emitir la factura.'
    })
    $("#modalFactura").modal('hide')
    return;
  }

  //NOS TRAEMOS LOS PRODUCTOS QUE OFRECEMOS
  await getProductos();
  await getImpuestos();
  await getUsosCFDI();
  await getSeries();
  await getFormaPago();
  await getMetodoPago();
  await getMoneda();
  await getPaises();

  let csf_info = await verificarCSF(factura.csf) //VA A DETERMINAR S EL ARCHIVO ES UNA CSF EN PDF O NO, SI ES EN PDF, LOS DATOS SON VERIDICOS, SI ES UNA IMAGEN, HAY QUE CORROBORAR.

  if(csf_info === false){
    Swal.fire({
      icon: 'info',
      title: 'La Constancia de Situación Fiscal no es un PDF, por lo que los datos pueden ser erroneos.'
    })
  }

  //factura['csf_info'] = csf_info
  //console.log(factura.csf_info.rfc);

  $("#modalFactura").modal('show')
});

//PETICIONES A LA API

async function getProductos() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "../../factura/getProductos",
    data: {
      keys: keys
    },
    success: async function (response) {
      await fillSelectProductos(response);
    },
    error: function (jqXHR) {
      console.log(jqXHR);
    },
  });
}

async function getImpuestos() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "../../factura/getImpuestos",
    data: {
      keys: keys
    },
    success: async function (response) {
      await fillSelectImpuestos(response);
    },
    error: function (jqXHR) {
      console.log(jqXHR);
    },
  });
}

async function getUsosCFDI() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "../../factura/getUsosCFDI",
    data: {
      keys:keys
    },
    success: async function (response) {
      await fillSelectUsosCDFI(response);
    },
    error: function (jqXHR) {
      console.log(jqXHR);
    },
  });
}

async function getSeries() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "../../factura/getSeries",
    data: {
      keys:keys
    },
    success: async function (response) {
      await fillSelectSeries(response);
    },
    error: function (jqXHR) {
      console.log(jqXHR);
    },
  });
}

async function getFormaPago() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "../../factura/getFormaPago",
    data:{
      keys:keys
    },
    success: async function (response) {
      await fillSelectFormaPago(response);
    },
    error: function (jqXHR) {
      console.log(jqXHR);
    },
  });
}

async function getMetodoPago() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "../../factura/getMetodoPago",
    data: {
      keys: keys
    },
    success: async function (response) {
      await fillSelectMetodoPago(response);
    },
    error: function (jqXHR) {
      console.log(jqXHR);
    },
  });
}

async function getMoneda() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "../../factura/getMoneda",
    data: {
      keys:keys
    },
    success: async function (response) {
      await fillSelectMoneda(response);
    },
    error: function (jqXHR) {
      console.log(jqXHR);
    },
  });
}

async function getUID(rfc) {
  return new Promise((resolve, reject) => {
    let razonSocial = $("#nombre").val();
    $.ajax({
      type: "post",
      dataType: "json",
      url: "../../factura/getUID",
      data: {
        rfc: rfc,
        keys:keys
      },
      success: async function (response) {
        console.log(response);
        if (response.status == "success") {
          response.Data.forEach((element) => {
            if (element.RazonSocial == razonSocial) {
              resolve(element.UID);
            }
          });

          resolve(false);
        } else {
          resolve(false);
        }
      },
      error: function (jqXHR) {
        reject(jqXHR);
      },
    });
  });
}

async function getPaises() {
  $.ajax({
    type: "post",
    dataType: "json",
    url: "../../factura/getPaises",
    data: {
      keys:keys
    },
    success: async function (response) {
      await fillSelectPaises(response);
    },
    error: function (jqXHR) {
      console.log(jqXHR);
    },
  });
}

async function getEmpresas(){
  return new Promise((resolve,reject) => {
    $.ajax({
      type: 'get',
      dataType: 'json',
      url: '../../factura/getEmpresas',
      success: async function(response){
        console.log(response);
        await fillSelectEmpresas(response)
      },
      error: function(jqXHR){
        reject(jqXHR)
      }
    })
  })
}

//RELLENAR SELECTS

async function fillSelectProductos(response) {
  response = response.data;

  let htmlOptions = '<option value="" selected disabled>Seleccione una opción</option>';
  for (let index = 0; index < response.length; index++) {
    let id = response[index].claveprodserv;
    let text = response[index].name;
    let unidad = response[index].claveunidad;
    let nombreUnidad = response[index].unidad;
    let sku = response[index].sku;
    let precioUnitario = response[index].price;

    htmlOptions += `
        <option value='${id}' data-unidad='${unidad}' data-unidad-nombre='${nombreUnidad}' data-sku='${sku}' data-precio-unitario='${precioUnitario}' >${text}</option>
        `;
  }

  $("#selectProductos").empty().append(htmlOptions);
}

async function fillSelectImpuestos(response) {
  response = response.data;

  let htmlOptions = '<option value="" selected disabled>Seleccione una opción</option>';

  for (let index = 0; index < response.length; index++) {
    if (response[index].name == "IVA") {
      let id = response[index].key;
      let name = response[index].name;

      htmlOptions += `
            <option value='${id}' >${name}</option>
            `;
    }
  }

  $("#Impuesto").empty().append(htmlOptions);
}

async function fillSelectUsosCDFI(response) {
  response = response.data;

  let htmlOptions = '<option value="" selected disabled>Seleccione una opción</option>';

  for (let index = 0; index < response.length; index++) {
    let id = response[index].key;
    let name = response[index].name;

    htmlOptions += `
            <option value='${id}' >${name}</option>
        `;
  }

  $("#UsoCFDI").empty().append(htmlOptions);
}

async function fillSelectSeries(response) {
  response = response.data;

  let htmlOptions = '<option value="" selected disabled>Seleccione una opción</option>';

  for (let index = 0; index < response.length; index++) {
    let id = response[index].SerieID;
    let name = response[index].SerieName;

    htmlOptions += `
            <option value='${id}' >${name}</option>
        `;
  }

  $("#Serie").empty().append(htmlOptions);
}

async function fillSelectFormaPago(response) {
  response = response.data;

  let htmlOptions = '<option value="" selected disabled>Seleccione una opción</option>';

  for (let index = 0; index < response.length; index++) {
    let id = response[index].key;
    let name = response[index].name;

    if (id == 03) {
      htmlOptions += `
            <option value='${id}' selected >${name}</option>
            `;
    } else {
      htmlOptions += `
            <option value='${id}' >${name}</option>
            `;
    }
  }

  $("#FormaPago").empty().append(htmlOptions);
}

async function fillSelectMetodoPago(response) {
  response = response.data;

  let htmlOptions = '<option value="" selected disabled>Seleccione una opción</option>';

  for (let index = 0; index < response.length; index++) {
    let id = response[index].key;
    let name = response[index].name;

    htmlOptions += `
        <option value='${id}' >${name}</option>
        `;
  }

  $("#MetodoPago").empty().append(htmlOptions);
}

async function fillSelectMoneda(response) {
  response = response.data;

  let htmlOptions = '<option value="" selected disabled>Seleccione una opción</option>';

  for (let index = 0; index < response.length; index++) {
    let id = response[index].key;
    let name = response[index].key;

    if (name == "MXN") {
      htmlOptions += `
            <option value='${id}' selected >${name}</option>
            `;
    } else {
      htmlOptions += `
            <option value='${id}' >${name}</option>
            `;
    }
  }

  $("#Moneda").empty().append(htmlOptions);
}

async function fillSelectPaises(response) {
  response = response.data;

  let htmlOptions = '<option value="" selected disabled>Seleccione una opción</option>';

  for (let index = 0; index < response.length; index++) {
    let id = response[index].key;
    let name = response[index].name;

    if (name == factura.pais) {
      htmlOptions += `
            <option value='${id}' selected >${name}</option>
            `;
    } else {
      htmlOptions += `
        <option value='${id}' >${name}</option>
        `;
    }
  }

  $("#PaisFactura").empty().append(htmlOptions);
}

async function fillSelectEmpresas(response){
  response = response.data;

  let htmlOptions = '<option value="" selected disabled>Seleccione una opción</option>';
  for (let index = 0; index < response.length; index++) {
    let empresa = response[index].razon_social;
    let key = response[index].api_key
    let privateKey = response[index].secret_key
    let uid = response[index].uid

    htmlOptions += `
        <option value='${uid}' data-key='${key}' data-privatekey='${privateKey}' >${empresa}</option>
        `;
  }

  $("#selectEmpresa").empty().append(htmlOptions);
}

//VERIFICAR INFORMACION

async function verificarCSF(csf){
  return new Promise((resolve, reject) => {
    $.ajax({
      type: 'post',
      url: '../../factura/verificarCSF',
      data: {
        csf:csf,
      },
      beforeSend: function(){
        $(".loaderCustom").text("Comprobando CSF");
        $("#loaderCustom").show();
      },
      success: async function(response){
        $(".loaderCustom").text("");
        $("#loaderCustom").hide();
        resolve(response)
      },
      error: function(jqXHR){
        reject(false)
      }
    })
  })
}


$("#selectProductos").on("change", function () {
  let unidad = $(this).find("option:selected").data("unidad");
  let nombreUnidad = $(this).find("option:selected").data("unidad-nombre");
  let sku = $(this).find("option:selected").data("sku");
  let precioUnitario = $(this).find("option:selected").data("precio-unitario");

  $("#ClaveUnidad").val(unidad);
  $("#Unidad").val(nombreUnidad);
  $("#NoIdentificacion").val(sku);
  $("#ValorUnitario").val(precioUnitario);
});

$("#Moneda").on("change", function () {
  let val = $(this).val();

  if (val != "MXN") {
    //NECESITA TENER EL TIPO DE CAMBIO
    $("#TipoCambio").prop("required", true).val("");
    $("#tipo_cambio").show();
  } else {
    $("#TipoCambio").prop("required", false).val("");
    $("#tipo_cambio").hide();
  }
  console.log(val);
});

$("#Impuesto").on("change", function () {
  let val = $(this).val();

  if (val == "002") {
    //IVA
    $("#TipoFactor").prop("required", true);
    $("#TasaOCuota").prop("required", true);
  } else {
    $("#TipoFactor").prop("required", false);
    $("#TasaOCuota").prop("required", false);
  }
});

$("#frm_factura").on("submit", async function (e) {
  e.preventDefault();

  let rfc = $("#rfc").val()
  let ClaveProdServ = $("#selectProductos").val();
  let cantidad = $("#cantidad").val();
  let ClaveUnidad = $("#ClaveUnidad").val();
  let Unidad = $("#Unidad").val();
  let ValorUnitario = $("#ValorUnitario").val();
  let Descripcion = $("#Descripcion").val();

  let Impuesto = $("#Impuesto").val();
  let TipoFactor = $("#TipoFactor").val();
  let TasaOCuota = $("#TasaOCuota").val();
  let importe = ValorUnitario * TasaOCuota;
  importe = importe.toFixed(2);

  let UsoCFDI = $("#UsoCFDI").val();
  let Serie = $("#Serie").val();
  let FormaPago = $("#FormaPago").val();
  let MetodoPago = $("#MetodoPago").val();
  let Moneda = $("#Moneda").val();
  let TipoCambio = $("#TipoCambio").val();

  let CondicionesDePago = $("#CondicionesDePago").val();
  let NumOrder = $("#NumOrder").val();
  let Comentarios = $("#Comentarios").val();

  let EnviarCorreo = $("#EnviarCorreo").val();

  EnviarCorreo = EnviarCorreo == "on" ? true : false;

  const ImpuestosObj = {};

  if (Impuesto !== null) {
    ImpuestosObj.Traslados = [];
    const traslados = {
      Base: ValorUnitario,
      Impuesto: Impuesto,
      TipoFactor: TipoFactor,
      TasaOCuota: TasaOCuota,
      Importe: importe,
    };
    ImpuestosObj.Traslados.push(traslados);
  }

  let UID = await getUID(rfc);

  if (UID === false) {
    //El usuario EN fACTURA no existe, lo creamos
    $(".loaderCustom").text("Generando usuario");
    $("#loaderCustom").show();
    //CREANDO USUARIO
    let responseUID = await generateUID(factura);
    $(".loaderCustom").text("");
    $("#loaderCustom").hide();
    UID = responseUID;
  }

  const formFactura = {
    Receptor: {
      UID: UID,
      ResidenciaFiscal: "",
    },
    Conceptos: [
      {
        ClaveProdServ: ClaveProdServ,
        Cantidad: cantidad,
        ClaveUnidad: ClaveUnidad,
        Unidad: Unidad,
        ValorUnitario: ValorUnitario,
        Descripcion: Descripcion,
        Impuestos: ImpuestosObj,
      },
    ],
    TipoDocumento: "factura",
    BorradorSiFalla: 1,
    UsoCFDI: UsoCFDI,
    Serie: Serie,
    FormaPago: FormaPago,
    MetodoPago: MetodoPago,
    Moneda: Moneda,
    TipoCambio: TipoCambio,
    CondicionesDePago: CondicionesDePago,
    NumOrder: NumOrder,
    Comentarios: Comentarios,
    EnviarCorreo: EnviarCorreo,
  };

  $(".loaderCustom").text("Generando factura");
  $("#loaderCustom").show();

  $.ajax({
    type: "post",
    dataType: "json",
    url: "../../factura/emitirFactura",
    data: {
      formFactura:formFactura,
      keys:keys
    },
    success: function (data) {
      console.log(data);
      if (data.response == "error") {
        let msj = "";
        if (typeof data.message.message !== "undefined") {
          msj = data.message.message;
        } else {
          msj = data.message;
        }
        Swal.fire({
          icon: "warning",
          title: "Atención",
          text: msj,
        });
      } else {
        alertAndDownloadFiles(data);
        console.log(data);
      }
      $("#loaderCustom").hide();
      console.log(data);
    },
    error: function (jqXHR) {
      console.log(jqXHR);
    },
  });
});

async function generateUID(info) {
  return new Promise((resolve, reject) => {
    let regimen = info.regimen_fiscal;
    regimen = regimen.replace(/[^0-9]+/g, ""); // Esto retorna '1234'

    let clavePais = $("#PaisFactura").val();
    let razons = $("#nombre").val()
    let rfc = $("#rfc").val();
    // HAY QUE HACER PARA BUSCAR LA CLAVE DEL PAIS

    const objCliente = {
      email: info.correo,
      razons: razons,
      rfc: rfc,
      regimen: regimen,
      calle: info.calle,
      numero_exterior: info.numero_exterior,
      numero_interior: info.numero_interior,
      codpos: info.cp,
      colonia: info.colonia,
      estado: info.estado,
      pais: clavePais,
    };

    $.ajax({
      type: "post",
      dataType: "json",
      url: "../../factura/generateClient",
      data: {
        objCliente:objCliente,
        keys:keys
      },
      success: async function (response) {
        if (response.status == "success") {
          resolve(response.Data.UID);
        } else {
          reject(response);
        }
      },
      error: async function (jqXHR) {
        reject(jqXHR);
      },
    });
  });
}

function alertAndDownloadFiles(data){
  Swal.fire({
    title: data.message,
    icon: 'success',
    dataType: 'json',
    showCancelButton: true,
    cancelButtonText: 'No quiero descargar los archivos',
    confirmButtonText: 'Descargar PDF y XML'
  }).then((result) => {
    if(result.isConfirmed){
      $.ajax({
        url: '../../factura/getArchivos',
        type: 'post',
        data: {
          uuid: data.UUID,
          keys: keys
        },
        beforeSend: function(){
          $(".loaderCustom").text("Generando archivos");
          $("#loaderCustom").show();
        },
        success: function(response){
          $(".loaderCustom").text("");
          $("#loaderCustom").hide();

          console.log(`window.location.href = base_url+'/admin/descargar/zipFactura/${response}`);
          window.location.href = base_url+'/admin/descargar/zipFactura/'+response
          
        },
        error: function(jqXHR){
          console.log(jqXHR);
        }
      })
    }
  })
}

$("#selectEmpresa").on('change',function(){
  let key = $(this).find('option:selected').data('key');
  let private = $(this).find('option:selected').data('privatekey');

  keys['key'] = key
  keys['private_key'] = private
})
