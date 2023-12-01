<style>
    #img {
        width: 100%;
        height: 500px;
        display: block;
    }

    textarea{
        background-color: #fff !important;
        color: #000 !important;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-uppercase">Editar libro</h4>
            </div>
            <div class="card-body">
                <span class="text-warning">* Si no desea cambiar algunos archivos (portada, libro o dictamen), deje el campo vacio.</span><br>
                <span class="text-warning">* Si desea cambiar la red o el año de este libro, contacte a sistemas.</span>
                <hr>
                <form action="../update" method="post" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-4" id="coverBook">
                            <div class="text-center" id="img_info">
                            </div>
                            <img src="<?= isset($base_64_cover) ? 'data:image/jpeg;base64,'.$base_64_cover : '' ?>" alt="" id="img" accept="image/png">
                            <hr>
                            <input type="file" name="portada" id="portada" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" name="nombre" id="" class="form-control" value="<?= $libro['nombre'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">ISBN</label>
                                <input type="text" name="isbn" id="" class="form-control" value="<?= $libro['isbn'] ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="">DOI</label>
                                <input type="text" name="doi" id="doi" class="form-control" value="<?= $libro['doi'] ?>">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check_doi" data-val='doi' onchange="check_na(event);">
                                    <label class="form-check-label" for="check_doi">
                                        Este capítulo no tiene DOI.
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Número de páginas</label>
                                <input type="number" class="form-control" name="paginas" id="paginas" value="<?= $libro['paginas'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="">Autores</label>
                                <input type="text" class="form-control" name="autores" id="autores" value="<?= $libro['autores'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="">Coordinadores</label>
                                <input type="text" class="form-control" name="coordinadores" id="coordinadores" value="<?= $libro['coordinadores'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="">Descripción del libro</label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="form-control"><?= $libro['descripcion'] ?></textarea>
                            </div>

                            <div class="form-group">

                                <label for="">Editorial</label>
                                <select name="editorial" id="editorial" required class="form-control">
                                    <option value="" selected disabled>Selecciona una opción</option>
                                    <?php
                                    foreach($editoriales as $e){
                                        ?>
                                        <option value="<?= $e['id'] ?>" <?= $e['id'] == $libro['editorial'] ? 'selected':'' ?> ><?= $e['nombre'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!--
                                Para cambiar red o añ primero es a nivel carpetas y luego a nivel bd
                            -->

                            <div class="form-group" hidden>
                                <label for="">Año de publicación</label>
                                <input type="number" name="anio" id="" class="form-control" value="<?= $libro['anio'] ?>" required disabled>
                            </div>

                            <div class="form-group">
                                <label for="">Formato</label>
                                <select name="formato" id="" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Impreso" <?= $libro['formato'] == 'Impreso' ? 'selected' : '' ?>>Impreso</option>
                                    <option value="Digital" <?= $libro['formato'] == 'Digital' ? 'selected' : '' ?>>Digital</option>
                                </select>
                            </div>

                            <div class="form-group" hidden>
                                <label for="">Biblioteca a la que esta asignado el libro</label>
                                <select name="red" id="" class="form-control" required disabled>
                                    <option value="" selected disabled>Seleccione una red</option>
                                    <?php
                                    foreach ($redes as $r) {
                                    ?>
                                        <option <?= $r['nombre_red'] == $libro['red'] ? 'selected' : '' ?> value="<?= $r['nombre_red'] ?>"><?= $r['nombre_red'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Archivo del libro</label>
                                <input type="file" name="documento" id="documento" accept="application/pdf" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Carta de dictamen</label>
                                <input type="file" name="dictamen" id="dictamen" accept="application/pdf" class="form-control">
                            </div>
                        </div>
                    </div>



                    <input type="text" name="id" id="" value="<?= $libro['id'] ?>" hidden>
                    <hr>
                    <button type="submit" class="btn btn-block btn-info">Guardar cambios</button>
                    <a class="btn btn-danger btn-block" href="../lista">Regresar</a>
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