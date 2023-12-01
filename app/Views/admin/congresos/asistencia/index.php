<style>
    img {
        border-radius: 50%;
    }

    .img-fluid {
        width: 20rem !important;
    }

    #imagen {
        display: block;
        align-items: center;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Asistencia a congresos</h4>
                <hr>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Seleccione un congreso</label>
                        <p class="text-warning">Seleccione el nombre del evento principal</p>
                        <select name="" id="congreso" class="form-control">
                            <option value="" selected disabled>Seleccione una opción</option>}
                            <?php
                            foreach ($congresos as $c) {
                            ?>
                                <option value="<?= $c['red'] . '_' . $c['anio']  ?>"><?= $c['nombre'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Clave de gafete</label>
                        <p class="text-warning">Posicione su mouse sobre el campo abajo, una vez que este ahi, escanee el codigo QR del participante y automaticamente se registrara su asistencia presencial. Ademas, se mostraran
                            acciones adicionales.
                        </p>
                        <input type="text" name="" id="clave_gafete" class="form-control" minlength="6" maxlength="6">
                        <input type="text" hidden name="">
                    </div>
                </div>
                <div id="info"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?= base_url() ?>';
    let red, anio
</script>
<script>
    $(document).on('change', '#congreso', function() {
        let val = $(this).val()

        const split = val.split('_')

        red = split[0]
        anio = split[1]
    })

    $('#clave_gafete').on('keypress', function() {
        let clave_gafete = $(this).val().replace(/\n|\r/g, '').replace(/\s+/g, '');
        if (clave_gafete.length == 6) {
            comprobarGafete(clave_gafete)
        }
    })

    function comprobarGafete(claveGafete) {

        if (red === undefined || anio === undefined) {
            return;
        }

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: './getInfoGafete',
            data: {
                gafete: claveGafete,
                red: red,
                anio: anio
            },
            success: function(data) {
                //hay que mostrar la info en una tarjetita con las diversas opciones
                console.log(data);

                if (data.id_ponencia != '') {
                    htmlPonencia = `
                    <div class="form-group">
                        <h3>ID de ponencia</h3>
                        <span>${data.id_ponencia}</span>
                    </div>
                    <div class="form-group">
                        <h3>Ponencia</h3>
                        <span>${data.ponencia}</span>
                    </div>
                    `;
                }else{
                    htmlPonencia = ``;
                }
                let html = `
                <hr>
                <div class="row">
                    <div class="col-md-4 text-center" id="imagen">
                        <img class="img-fluid" src="${base_url+'/resources/img/profiles/'+data.profile_pic}" alt="Avatar">
                        <hr>
                        <h4>Nombre del participante</h4>
                        <h3>${data.nombre}</h3>
                        <h5 class='text-success'>Asistencia registrada</h5>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <h3>Universidad</h3>
                            <span>${data.universidad}</span>
                        </div>
                        <div class="form-group">
                            <h3>Clave de la universidad</h3>
                            <span>${data.claveCuerpo}</span>
                        </div>
                        <div class="form-group">
                            <h3>Tipo de asistencia al evento</h3>
                            <span>${data.tipo_registro}</span>
                        </div>
                        <div class="form-group">
                            <h3>Tipo de gafete</h3>
                            <span>${data.tipo_gafete}</span>
                        </div>
                        ${htmlPonencia}
                        <div class='form-group'>
                            <h3>Kit presencial</h3>
                            <button class='btn btn-info kit' data-gafete='${data.gafete}' data-red='${red}' data-anio='${anio}' data-tipo='kit' data-val='${data.kit_presencial}' >${data.kit_presencial != 0 ? 'Kit presencial entregado' : 'Registrar entrega de paquete presencial'}</button>
                        </div>
                        <div class='form-group'>
                            <h3>Kit virtual</h3>
                            <button class='btn btn-info kit' data-gafete='${data.gafete}' data-red='${red}' data-anio='${anio}' data-tipo='kit_virtual' data-val='${data.kit_virtual}' >${data.kit_virtual != 0 ? 'Kit virtual entregado' : 'Registrar entrega de paquete virtual'}</button>
                        </div>
                    </div>
                </div>
                `;

                $("#info").empty().append(html)
                $("#clave_gafete").val('').focus()
            },
            error: function(jqXHR) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Error ' + jqXHR.status,
                    html: jqXHR.responseText
                })
                console.log(jqXHR);
            }
        })
    }

    $(document).on('click','.kit',function(){
        let gafete = $(this).data('gafete')
        let red = $(this).data('red')
        let anio = $(this).data('anio')
        let tipo = $(this).data('tipo')
        let val = $(this).data('val')
        const btn = $(this)
        $.ajax({
            type: 'post',
            url: './updateKit',
            dataType: 'json',
            data: {
                gafete: gafete,
                red: red,
                anio: anio,
                tipo: tipo,
                val: val
            },
            success: function(data){
                console.log(data);
                let str_tipo = tipo == 'kit' ? 'presencial' : 'virtual';
                btn.data('val',data.valReturn)

                if(data.valReturn == 1){
                    //DESHABILITAMOS\
                    console.log('Entra');
                    btn.text('Kit '+str_tipo+' entregado').removeClass('btn-info').addClass('btn-danger')
                }else{
                    //
                    btn.text('Registrar entrega de paquete '+str_tipo).removeClass('btn-danger').addClass('btn-info')
                }
                $("#clave_gafete").val('').focus()
            },
            error: function(jqXHR){
                Swal.fire({
                    icon: 'warning',
                    title: 'Error ' + jqXHR.status,
                    html: jqXHR.responseText
                })
            }
        })
        console.log(gafete+' '+red+' '+anio);
    })
</script>