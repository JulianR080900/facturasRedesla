if(message == 'email'){
    Swal.fire({
        icon:'warning',
        title:'El correo electrónico proporcionado no esta ligado al sistema',
        text: 'Verifique que su correo este escrito correctamente'
    })
}

if(message == 'error'){
    Swal.fire({
        icon:'error',
        title:'Lo sentimos',
        text:'Ha ocurrido un error, intente mas tarde'
    })
}