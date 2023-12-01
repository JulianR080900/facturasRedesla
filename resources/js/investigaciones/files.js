const selectImage = document.querySelector(".select-image");
const inputFile = document.querySelector("#file");
const imgArea = document.querySelector(".img-area");

$(document).ready(function () {
  $(".send").prop("disabled", true);
});

$(".verArchivo").on('click', function() {
  let nombre = $(this).data('nombre')
  let obra = $(this).data('obra')
  let url = `../ver/${nombre}/${obra}/${anio}`;
  window.open(url, '_blank');
})

if(selectImage !== null){
  selectImage.addEventListener("click", function (e) {
    inputFile.click();
  });
  inputFile.addEventListener("change", function () {
    const image = this.files[0];
    if (image.size > 2000000) {
      Swal.fire({
        icon: "warning",
        title: "Archivo demasiado pesado",
        html: "Recuerde que el tamaño máximo es de <b>2MB</b>",
      });
      return;
    }
    const reader = new FileReader();
    reader.onload = () => {
      const allImg = imgArea.querySelectorAll("img");
      allImg.forEach((item) => item.remove());
      const imgUrl = reader.result;
      const img = document.createElement("img");
      img.src = imgUrl;
      imgArea.appendChild(img);
      imgArea.classList.add("active");
      imgArea.dataset.img = image.name;
      $(".send").prop("disabled", false);
    };
    reader.readAsDataURL(image);
  });
}



$(".logo").on("click", function (e) {
  e.preventDefault();
  Swal.fire({
    icon: "warning",
    title: "¿Desea enviar a revisión el logotipo de su institución?",
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
        var formData = new FormData()
        var fileInput = document.getElementById("file");
        var archivo = fileInput.files[0];

        formData.append("archivo", archivo);
        formData.append("anio", anio);

      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loader").show()
            $(".send").prop('disabled',true);
        },
        success: function (data) {
            console.log(data);
            $("#loader").hide()
            $(".send").prop('disabled',false);
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
            $("#loader").hide()
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          }).then(function(){
            $(".send").prop('disabled',false);
          })
        },
      });
    }
  });
});

/* SESION DE DERECHOS */

$(".btnCartaDerechosImpreso").on('click',function(e){
  e.preventDefault()
  const inputFile = document.querySelector("#cartaDerechosImpreso");

  if(inputFile.files.length <= 0){
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'Ningun archivo seleccionado'
    })
    return
  }

  const selectedFile = inputFile.files[0];

  if(selectedFile.type != 'application/pdf'){
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'El archivo debe ser en formato PDF'
    })
    return
  }

  if(selectedFile.size > 5000000){
    Swal.fire({
      icon: "warning",
      title: "Archivo demasiado pesado",
      html: "Recuerde que el tamaño máximo es de <b>5MB</b>",
    });
    return;
  }

  Swal.fire({
    icon: "warning",
    title: "¿Desea enviar a revisión la carta de sesión de derechos de la obra impresa?",
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
        var formData = new FormData()
        formData.append("archivo", selectedFile);
        formData.append("anio", anio);
        formData.append("obra", 'impreso');

      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loader").show()
            $(".btnCartaDerechosImpreso").prop('disabled',true);
        },
        success: function (data) {
            console.log(data);
            $("#loader").hide()
            $(".send").prop('disabled',false);
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
            $("#loader").hide()
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          }).then(function(){
            $(".btnCartaDerechosImpreso").prop('disabled',false);
          })
        },
      });
    }
  });
    
})

$(".btnCartaDerechosDigital").on('click',function(e){
  e.preventDefault()
  const inputFile = document.querySelector("#cartaDerechosDigital");

  if(inputFile.files.length <= 0){
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'Ningun archivo seleccionado'
    })
    return
  }

  const selectedFile = inputFile.files[0];

  if(selectedFile.type != 'application/pdf'){
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'El archivo debe ser en formato PDF'
    })
    return
  }

  if(selectedFile.size > 5000000){
    Swal.fire({
      icon: "warning",
      title: "Archivo demasiado pesado",
      html: "Recuerde que el tamaño máximo es de <b>5MB</b>",
    });
    return;
  }

  Swal.fire({
    icon: "warning",
    title: "¿Desea enviar a revisión la carta de sesión de derechos de la obra digital?",
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
        var formData = new FormData()
        formData.append("archivo", selectedFile);
        formData.append("anio", anio);
        formData.append("obra", 'digital');

      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loader").show()
            $(".btnCartaDerechosDigital").prop('disabled',true);
        },
        success: function (data) {
            console.log(data);
            $("#loader").hide()
            $(".send").prop('disabled',false);
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
            $("#loader").hide()
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          }).then(function(){
            $(".btnCartaDerechosDigital").prop('disabled',false);
          })
        },
      });
    }
  });
    
})

/* VISTO BUENO */

$(".btnCartaVistoImpreso").on('click',function(e){
  e.preventDefault()
  const inputFile = document.querySelector("#cartaVistoImpreso");

  if(inputFile.files.length <= 0){
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'Ningun archivo seleccionado'
    })
    return
  }

  const selectedFile = inputFile.files[0];

  const inputMarcaje = document.querySelector("#marcajeImpreso");
  const fileMarcaje = inputMarcaje.files[0];

  if(selectedFile.type != 'application/pdf'){
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'El archivo debe ser en formato PDF'
    })
    return
  }

  if(selectedFile.size > 5000000){
    Swal.fire({
      icon: "warning",
      title: "Archivo demasiado pesado",
      html: "Recuerde que el tamaño máximo es de <b>5MB</b>",
    });
    return;
  }

  if(fileMarcaje != undefined){
    if(fileMarcaje.type != 'application/pdf'){
      Swal.fire({
        icon: 'warning',
        title: 'Cuidado',
        text: 'El archivo debe ser en formato PDF',
        footer: 'Archivo de marcaje'
      })
      return
    }
  
    if(fileMarcaje.size > 5000000){
      Swal.fire({
        icon: "warning",
        title: "Archivo demasiado pesado",
        html: "Recuerde que el tamaño máximo es de <b>5MB</b>",
        footer: 'Archivo de marcaje'
      });
      return;
    }
  }

  Swal.fire({
    icon: "warning",
    title: "¿Desea enviar a revisión la carta de visto bueno de la obra impresa?",
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
        var formData = new FormData()
        formData.append("archivo[]", selectedFile);
        formData.append("anio", anio);
        formData.append("obra", 'impreso');

        if(fileMarcaje != undefined){
          formData.append("archivo[]", fileMarcaje);
        }

      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loader").show()
            $(".btnCartaVistoImpreso").prop('disabled',true);
        },
        success: function (data) {
            console.log(data);
            $("#loader").hide()
            $(".send").prop('disabled',false);
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
            $("#loader").hide()
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          }).then(function(){
            $(".btnCartaVistoImpreso").prop('disabled',false);
          })
        },
      });
    }
  });
    
})

$(".btnCartaVistoDigital").on('click',function(e){
  console.log(e);
  e.preventDefault()
  const inputFile = document.querySelector("#cartaVistoDigital");

  if(inputFile.files.length <= 0){
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'Ningun archivo seleccionado'
    })
    return
  }

  const selectedFile = inputFile.files[0];
  const inputMarcaje = document.querySelector("#marcajeDigital");
  const fileMarcaje = inputMarcaje.files[0];

  if(selectedFile.type != 'application/pdf'){
    Swal.fire({
      icon: 'warning',
      title: 'Cuidado',
      text: 'El archivo debe ser en formato PDF'
    })
    return
  }

  if(selectedFile.size > 5000000){
    Swal.fire({
      icon: "warning",
      title: "Archivo demasiado pesado",
      html: "Recuerde que el tamaño máximo es de <b>5MB</b>",
    });
    return;
  }

  if(fileMarcaje != undefined){
    if(fileMarcaje.type != 'application/pdf'){
      Swal.fire({
        icon: 'warning',
        title: 'Cuidado',
        text: 'El archivo debe ser en formato PDF',
        footer: 'Archivo de marcaje'
      })
      return
    }
  
    if(fileMarcaje.size > 5000000){
      Swal.fire({
        icon: "warning",
        title: "Archivo demasiado pesado",
        html: "Recuerde que el tamaño máximo es de <b>5MB</b>",
        footer: 'Archivo de marcaje'
      });
      return;
    }
  }

  Swal.fire({
    icon: "warning",
    title: "¿Desea enviar a revisión la carta de visto bueno de la obra digital?",
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
        var formData = new FormData()
        formData.append("archivo[]", selectedFile);
        formData.append("anio", anio);
        formData.append("obra", 'digital');
        if(fileMarcaje != undefined){
          formData.append("archivo[]", fileMarcaje);
        }

      $.ajax({
        url: "../updatePhase",
        type: "post",
        dataType: "json",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("#loader").show()
            $(".btnCartaVistoDigital").prop('disabled',true);
        },
        success: function (data) {
            console.log(data);
            $("#loader").hide()
            $(".send").prop('disabled',false);
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
            $("#loader").hide()
          Swal.fire({
            icon: "error",
            title: `Error ${jqXHR.status}`,
            text: "Contacte con el equipo Redesla.",
          }).then(function(){
            $(".btnCartaVistoDigital").prop('disabled',false);
          })
        },
      });
    }
  });
    
})
