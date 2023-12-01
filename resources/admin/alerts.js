if(message == "success"){
    Swal.fire({
        icon: 'success',
        title: 'Exito!',
        text: 'Se ha actualizado el registro correctamente',
      });
      message = "";
}
if(message == "Error al actualizar"){
    Swal.fire({
        icon: 'error',
        title: 'Opss',
        text: 'Ha ocurrido un error, favor de contactar a sistemas',
      });
      message = "";
}

if(message == "errorSelect"){
  Swal.fire({
    icon: 'warning',
    title: 'Cuidado',
    text: 'Selecciona un proyecto',
  });
  message = "";
}

if(message == "successInsert"){
  Swal.fire({
    icon: 'success',
    title: 'Listo',
    text: 'Registro insertado correctamente',
  });
  message = "";
}

if(message == "errorInsert"){
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'Ha ocurrido un error al insertar el registro',
  });
  message = "";
}

if(message == "errorMiembroDuplicado"){
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'El usuario ya esta registrado en este cuerpo academico',
  });
  message = "";
}

if(message == "no existe miembro"){
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'La clave de usuario no esta registrado en la base de datos',
  });
  message = "";
}

if(message == "Verifique el folio"){
  Swal.fire({
    icon: 'error',
    title: 'Error',
    //text: 'La clave de usuario no esta registrado en la base de datos',
    text: 'Favor de verificar el folio',
  });
  message = "";
}

if(message == "NoExisteFolio"){
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'El folio no esta registrado en la base de datos',
  });
  message = "";
}

if(message == "successMov"){
  Swal.fire({
    icon: 'success',
    title: 'Exito!',
    text: 'Movimiento aceptado correctamente. Restante actualizado',
  });
  message = "";
}

if(message == "errorEntrada"){
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'Ha ocurrido un error aceptando el movimiento. Contacte a sistemas',
  });
  message = "";
}

if(message == "errorCero"){
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'No se puede tener un restante negativo. Contacte a sistemas',
  });
  message = "";
}

if(message == "errorNoProyecto"){
  Swal.fire({
    icon: 'warning',
    title: 'OJO',
    text: 'No se encuentra el proyecto en las condiciones. Se actualizo el restante, pero no valido constancias.',
  });
  message = "";
}