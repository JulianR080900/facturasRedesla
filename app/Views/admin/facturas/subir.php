<style>
    #img {
        width: 100%;
        height: 500px;
        display: none;
    }

    textarea {
        background-color: #fff !important;
        color: #000 !important;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-uppercase">Agregar factura</h4>
            </div>
            <div class="card-body">
                <form action="./insert" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="text-success">Recuerde que al agregar esta factura tomara su nombre de usuario, en su caso: <u><?= session('nombre') ?></u> </span>
                            </div>

                            <div class="form-group">
                                <label for="">Provedor <span class="text-danger">*</span> <span class="text-warning">Si el provedor se le autocompleta, seleccionelo, caso contrario se creara un nuevo provedor</span> </label>
                                <input type="search" name="provedor" id="provedor" list="provedores" class="form-control" required>
                                <datalist id="provedores">
                                    <?php
                                    foreach($provedores as $p){
                                        ?>
                                        <option value="<?= $p['nombre'] ?>"></option>
                                        <?php
                                    }
                                    ?>
                                </datalist>

                            </div>

                            <div class="form-group">
                                <label for="">Detalles de la compra <span class="text-danger">*</span></label>
                                <textarea name="detalles" id="" cols="30" rows="10" class="form-control" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="">Monto <span class="text-danger">*</span></label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">$</div>
                                    </div>
                                    <input type="number" step="0.01" name="monto" id="monto" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Moneda <span class="text-danger">*</span> </label>
                                <select name="moneda" id="" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="MXN">MXN</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Metodo de pago <span class="text-danger">*</span> <span class="text-warning">Si el método de pago se le autocompleta, seleccionelo, caso contrario se creara un nuevo método de pago.</span> </label>
                                <input type="search" name="metodo_pago" id="metodo_pago" class="form-control" list="metodos">
                                <datalist id="metodos">
                                <?php
                                    foreach($metodos as $m){
                                        ?>
                                        <option value="<?= $m['nombre'] ?>"></option>
                                        <?php
                                    }
                                    ?>
                                </datalist>
                            </div>

                            <div class="form-group">
                                <label for="">Fecha del pago <span class="text-danger">*</span> </label>
                                <input type="date" name="fecha_pago" id="" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="">Fecha de emisión de la factura <span class="text-danger">*</span> </label>
                                <input type="date" name="fecha_factura" id="" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="">Factura en PDF <span class="text-danger">*</span> </label>
                                <input type="file" name="facturaPDF" id="documento" accept="application/pdf" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="">Factura en XML</label>
                                <input type="file" name="facturaXML" id="documento" accept="text/xml" class="form-control">
                            </div>

                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-block btn-info">Agregar factura</button>
                    <a class="btn btn-danger btn-block" href="./lista">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    /* const file = document.getElementById('portada')
    const img = document.getElementById('img')
    const img_info = document.getElementById('img_info')

    file.addEventListener('change', e => {
        if (e.target.files[0]) {
            const reader = new FileReader()
            reader.onload = function(e) {
                const base_64 = e.srcElement.result.split('data:image/jpeg;base64,')
                console.log(base_64);
                img.src = e.srcElement.result
                img.style.display = 'block'
                img_info.innerHTML = ''
            }
            reader.readAsDataURL(e.target.files[0])
        } else {
            img.src = ''
            img.style.display = 'none'
            img_info.innerHTML = 'Sin portada seleccionada'
        }
    })

    function check_na(e) {
        let id = e.target.dataset.val;
        let checkbox = $("#check_" + id)[0].checked;

        if (checkbox) {
            $("#" + id).val('NA').prop('readonly', true);
        } else {
            $("#" + id).val('').prop('readonly', false);
        }
        document.getElementById(id).dispatchEvent(keyupEvent);
    } */



</script>