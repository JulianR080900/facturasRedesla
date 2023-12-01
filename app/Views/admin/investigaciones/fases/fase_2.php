<style>
    .fila_imagen {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fila_imagen img {
        height: 40rem;
        width: 70%;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Logotipo del grupo <?= $claveCuerpo ?></h4>

                <div class="row">
                    <div class="col-md-8">
                    <span class="text-warning">* Resolución de la imagen puede ser mayor o menor a la que se visualiza actualmente.</span>
                        <div class="fila_imagen">
                            <img src="data:image/jpeg;base64,<?= $logo ?>" alt="">
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-lg-4">
                        <h4 class="card-title text-uppercase">Validación</h4>
                        <button type="button" class="btn btn-success btn-rounded btn-block aceptar">Aceptar fase</button>
                        <button type="button" class="btn btn-danger btn-rounded btn-block devolver">Devolver fase</button>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <input type="hidden" id="claveCuerpo" value="<?= $claveCuerpo ?>">
    <input type="hidden" id="tipo" value="<?= $tipo ?>">
    <input type="hidden" id="red" value="<?= $red ?>">
    <input type="hidden" id="anio" value="<?= $anio ?>">

</div>

<script>
    $(".aceptar").on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Esta seguro que desea aceptar esta fase?',
            text: 'Esta accion no es reversible',
            icon: 'warning',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                let claveCuerpo = $("#claveCuerpo").val()
                let tipo = $("#tipo").val()
                let red = $("#red").val()
                let anio = $("#anio").val()
                $.ajax({
                    url: '../../updatePhase',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        claveCuerpo: claveCuerpo,
                        tipo: tipo,
                        red: red,
                        anio: anio,
                        terminado: 0
                    },
                    beforeSend: function(){
                        $("#loader").show()
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Exito',
                            text: 'Fase aceptada correctamente.'
                        }).then(function() {
                            window.location.href = '../../inicio'
                        })
                    },
                    error: function(jqXHR) {
                        Swal.fire({
                            icon: 'error',
                            title: `Error ${jqXHR.status}`,
                            text: 'Contacte a sistemas.'
                        })
                    },
                    complete: function(){
                        $("#loader").hide()
                    }
                })
            }
        })
    })

    $(".devolver").on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Esta seguro que desea devolver esta fase?',
            text: 'Esta accion no es reversible',
            icon: 'warning',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí",
            cancelButtonText: "No",
            input: 'text',
            inputLabel: 'Escriba el porque ha sido devuelta la fase',
            inputPlaceholder: '',
        }).then((result) => {
            if (result.isConfirmed) {
                let claveCuerpo = $("#claveCuerpo").val()
                let tipo = $("#tipo").val()
                let red = $("#red").val()
                let anio = $("#anio").val()
                let mensaje = result.value
                $.ajax({
                    url: '../../updatePhase',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        claveCuerpo: claveCuerpo,
                        tipo: tipo,
                        red: red,
                        anio: anio,
                        terminado: 2,
                        mensaje: mensaje
                    },
                    beforeSend: function(){
                        $("#loader").show()
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Exito',
                            text: 'Fase devuelta correctamente.'
                        }).then(function() {
                            window.location.href = '../../inicio'
                        })
                    },
                    error: function(jqXHR) {
                        console.log(jqXHR);
                        Swal.fire({
                            icon: 'error',
                            title: `Error ${jqXHR.status}`,
                            text: 'Contacte a sistemas.'
                        })
                    },
                    complete: function(){
                        $("#loader").hide()
                    }
                })
            }
        })
    })
</script>