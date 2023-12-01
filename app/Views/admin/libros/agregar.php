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
                <h4 class="card-title text-uppercase">Agregar libro</h4>
            </div>
            <div class="card-body">
                <form action="./insert" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-4" id="coverBook">
                            <div class="text-center" id="img_info">
                                Sin portada seleccionada <span class="text-danger">*</span>
                            </div>
                            <img src="" alt="" id="img">
                            <hr>
                            <input type="file" name="portada" id="portada" class="form-control" required accept="image/png">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Nombre del libro <span class="text-danger">*</span> </label>
                                <input type="text" name="nombre" id="" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">ISBN</label>
                                <input type="text" name="isbn" id="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">DOI</label>
                                <input type="text" name="doi" id="doi" class="form-control">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_doi" data-val='doi' onchange="check_na(event);">
                                    <label class="form-check-label" for="check_doi">
                                        Este capítulo no tiene DOI.
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Número de páginas <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="paginas" id="paginas" required>
                            </div>
                            <div class="form-group">
                                <label for="">Autores <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="autores" id="autores" required>
                            </div>
                            <div class="form-group">
                                <label for="">Coordinadores <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="coordinadores" id="coordinadores" required>
                            </div>
                            <div class="form-group">
                                <label for="">Descripción del libro <span class="text-danger">*</span></label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Editorial <span class="text-danger">*</span></label>
                                <select name="editorial" id="editorial" required class="form-control">
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    <?php
                                    foreach ($editoriales as $e) {
                                    ?>
                                        <option value="<?= $e['id'] ?>"><?= $e['nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Año de publicación <span class="text-danger">*</span></label>
                                <input type="number" name="anio" id="" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">Formato <span class="text-danger">*</span></label>
                                <select name="formato" id="" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Impreso">Impreso</option>
                                    <option value="Digital">Digital</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Biblioteca a la que esta asignado el libro <span class="text-danger">*</span></label>
                                <select name="red" id="" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una red</option>
                                    <?php
                                    foreach ($redes as $r) {
                                    ?>
                                        <option value="<?= $r['nombre_red'] ?>"><?= $r['nombre_red'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Archivo del libro <span class="text-danger">*</span></label>
                                <input type="file" name="documento" id="documento" accept="application/pdf" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="">Carta de dictamen <span class="text-danger">*</span></label>
                                <input type="file" name="dictamen" id="dictamen" accept="application/pdf" class="form-control">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <p class="text-warning">* El enlace en donde se encontrara el libro estara pendiente por el momento.</p>
                        <p class="text-warning">** Se podra insertar el DOI en el listado de libros.</p>
                        <p class="text-warning">*** Los DOI por capitulos se tienen que realizar dentro de cada capítulo.</p>
                    </div>

                    <!--
                    El enlace se dara en automatico una vez tengamos las rutas
                    <label for="">Enlace</label>
                    <input type="text" name="enlace" id="" class="form-control" required>
                    -->
                    <hr>
                    <button type="submit" class="btn btn-block btn-info">Agregar libro</button>
                    <a class="btn btn-danger btn-block" href="./lista">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const file = document.getElementById('portada')
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
    }
</script>