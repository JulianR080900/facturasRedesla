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

if(message == "send"){

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

if(message == "vacio"){

	Swal.fire({

        icon: 'error',

        title: 'Lo sentimos',

        text: 'Ha ocurrido un error, intente mas tarde',

      });

}

if(message == 'difUsuario'){
    Swal.fire({

        icon: 'error',

        title: 'Lo sentimos',

        text: 'Ha ocurrido un error, intente mas tarde',

      });
}