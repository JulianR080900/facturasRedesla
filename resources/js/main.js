if(message == "error"){
	Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'El correo o contraseña son incorrectos',
      });
}

if(message == "success"){
  Swal.fire({
    icon: 'success',
    title: '¡ÉXITO!',
    text: 'Su registro se ha completado satisfactoriamente, se han enviado intrucciones a los correos proporcionados',
  })
}

if(message == "errorCa" || message == "Error100" || message == "Error101" || message == "Error102" || message == "ErrorUndefined"){
  Swal.fire({
    icon: 'error',
    title: 'Lo sentimos',
    text: 'Ha ocurrido un error. Favor intente de nuevo, si el error persiste, contacte a sistemas',
  })
}

if(message == "alta"){
  Swal.fire({
    icon: 'warning',
    title: 'Oops...',
    text: 'Su cuerpo academico aun no ha sido dado de alta, favor de esperar a su confirmación',
  });
}

if(message == "Message has been sent successfully"){
    Swal.fire({
        icon: 'success',
        title: 'Listo!',
        text: 'Hemos enviado un enlace a su correo personal',
      })
}

if(message == "cambiado"){
  Swal.fire({
    icon: 'success',
    title: 'Listo!',
    text: 'Se ha cambiado la contraseña, ingrese con su nueva credencial',
  })
}

if(message == "error2"){
	Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Ha ocurrido un error, intente mas tarde',
      });
}

if(message == "successUpdate"){
    Swal.fire({
        icon: 'success',
        title: 'Listo!',
        text: 'Se ha cambiado la información correctamente',
    })
}

if(message == "errorUpdate"){
    	Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Ha ocurrido un error, intente mas tarde',
      });
}

if(message == "successInsert"){
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'El proceso se ha realizado correctamente, si no se ve reflejado el cambio, cierre sesión e intente de nuevo',
    });
}

if(message == "errorInsert"){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Ha ocurrido un error, intente mas tarde',
    });
}

if(message == "successImage"){
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'Su foto de perfil se ha actualizado',
    });
}

if(message == "successRecaptura"){
  swal.fire({
    icon:'success',
    title:'Éxito',
    text:'Proceso realizado con éxito'
  })
}

if(message == "errorRecaptura"){
  swal.fire({
    icon:'error',
    title:'Lo sentimos',
    text:'Se ha producido un error al recapturar la entrevista',
    footer:'¿El problema persiste? Contacte al siguiente correo: jaramosp@e.redesla.net'
  })
}

if(message == 'ponenciaRegistrada'){
  swal.fire({
    icon:'success',
    title:'Éxito',
    text:'Su ponencia y autores fueron registrados exitosamente.',
  })
}

if(message == 'no_existe_encuestador'){
  Swal.fire({
    icon: 'warning',
    title: 'Lo sentimos',
    text: 'El correo proporcionado no tiene acceso a la constancia',
  });
}

$(function () {
  $('[data-toggle="popover"]').popover()
})

const inputs = document.querySelectorAll(".input");


function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}


inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});


