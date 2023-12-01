if(message == "no_ca"){
	Swal.fire({
        icon: 'warning',
        title: 'Cuidado!',
        text: 'Seleccione un cuerpo academico',
      });
}

if(message == "correos_enviados"){
    Swal.fire({
        icon: 'success',
        title: 'Listo',
        text: 'Correo reenviado correctamente',
    });
}

if(message == "success"){
     Swal.fire({
        icon: 'success',
        title: 'Listo',
        text: 'Tarea completada con exito',
    });
}

if(message == "error"){
     Swal.fire({
        icon: 'error',
        title: 'Lo sentimos',
        text: 'Ha ocurrido un error, contacte a sistemas',
    });
}