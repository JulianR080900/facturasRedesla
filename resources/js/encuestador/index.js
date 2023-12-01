if(message == 'vacio'){
    Swal.fire({
        icon:'warning',
        title:'Lo sentimos',
        text: 'No existe registros con el correo proporcionado'
    })
}

if(message == 'pendiente'){
    Swal.fire({
        icon:'warning',
        title:'Lo sentimos',
        text: 'Aun no esta habilitada la constancia para su visualización. Intentelo mas tarde'
    })
}

