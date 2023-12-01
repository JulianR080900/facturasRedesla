

$("button[name='addPago']").on("click",function() {
    id = this.value;
    $("#id_pago").attr("value",id);
    $("#modalMoldePagos").modal("show");
});

if (message == "error10") {
        Swal.fire({
          icon: 'warning',
          title: 'OJO',
          text: 'Solo se permiten archivos JPG y PDF con peso menor a 5MB',
        });    
}

if (message == "success1") {
    Swal.fire({
        icon: 'success',
        title: 'Listo',
        text: 'Archivo subido correctamente',
      });
}

if (message == "error1") {
    Swal.fire({
        icon: 'error',
        title: 'Lo sentimos',
        text: 'Ha ocurrido un error, intente mas tarde',
      });
}

if(message == "successInsert"){
    Swal.fire({
        icon: 'success',
        title: 'Listo',
        text: 'Pago agregado correctamente',
      });
}

if(message == "errorInsert"){
    Swal.fire({
        icon: 'error',
        title: 'Lo sentimos',
        text: 'Ha ocurrido un error, intente mas tarde',
      });
}

if(message == "vacio"){
        Swal.fire({
          icon: 'warning',
          title: 'Cuidado',
          text: 'Seleccione un proyecto',
        });    

}

$("#submitId").closest('form').on('submit', function(e) {
    e.preventDefault();
    $('#btnAddProyecto').attr('disabled', true);
    this.submit(); // ahora hace el submit de tu formulario.
});
