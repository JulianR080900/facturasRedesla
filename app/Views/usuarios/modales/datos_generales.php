<div id="editRector_<?php echo $_SESSION["CA"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?php echo base_url('generalUpdate/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar nombre del Rector</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Rector</label>

            <input type="text" class="form-control ol" name="nombre_rector" value="<?php echo $datos_universidad["nombre_rector"]; ?>" required>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" id="id" value="<?= $datos_universidad['id'] ?>" required hidden>

          <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>" style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editGradoRector_<?php echo $_SESSION["CA"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?php echo base_url('generalUpdate/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar grado del Rector</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Rector</label>

            <select class="form-control" name="grado_rector">

              <?php

              foreach ($grados_rector as $g) {



                if ($datos_universidad["grado_rector"] == $g["id"]) {

                  echo '<option value="' . $g["id"] . '" selected>' . $g["nombre"] . '</option>';
                } else {

                  echo '<option value="' . $g["id"] . '">' . $g["nombre"] . '</option>';
                }
              }

              ?>

              <select>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" id="id" value="<?= $datos_universidad['id'] ?>" required hidden>

          <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>" style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editTelefono_<?php echo $_SESSION["CA"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?php echo base_url('generalUpdate/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar teléfono</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>


        <div class="modal-body ">

          <label>Telefono</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">Tel</span>
            </div>
            <input type="text" class="form-control on" name="telefono" value="<?php echo $datos_universidad["telefono"] ?>" required>
          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" id="id" value="<?= $datos_universidad['id'] ?>" required hidden>


          <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>" style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editExtension_<?php echo $_SESSION["CA"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?php echo base_url('generalUpdate/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar Extensión</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">
          <label>Extensión</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">+</span>
            </div>
            <input type="text" class="form-control on" id="extension" name="extension" value="<?php echo $datos_universidad["extension"] ?>" required>
          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" value="<?= $datos_universidad['id'] ?>" required hidden>

          <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>" style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editinstEst_<?php echo $_SESSION["CA"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?php echo base_url('generalUpdate/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar institución a estudiar</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Institución a estudiar</label>

            <input type="text" class="form-control ln" id="inst_est" name="inst_est" value="<?php echo $datos_universidad["inst_est"] ?>" required>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" id="id" value="<?= $datos_universidad['id'] ?>" required hidden>

          <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>" style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editDirEnvios_<?php echo $_SESSION["CA"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form method="POST" action="<?php echo base_url('generalUpdate/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar dirección de envio</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body">
          <div class="verde">
            <p>Instrucciones</p>
            <p>Ingrese los datos requeridos correctamente. Para finalizar el proceso de clic en <b>Actualizar ahora</b></p>
          </div>
          <div id="direcciones_universidad_form">

            <h3>Formato para la dirección de la universidad de adscripción</h3>

            <label for="nombre_vialidad">Nombre y tipo de la vialidad (calle, avenida, privada), ejemplo: Calle Jazmín</label>

            <input type="text" id="nombre_vialidad" placeholder="Ingrese el nombre de la vialidad (calle, avenida, privada)" class="form-control ln">

            <label for="noInt">No. Interior (En caso de que el domicilio no cuente con numeración, colocar <b>S/N</b>)</label>

            <input type="text" id="noInt" placeholder="Ingrese el No. Interior" class="form-control">

            <label for="noExt">No. Exterior (En caso de que el domicilio no cuente con numeración, colocar <b>S/N</b>)</label>

            <input type="text" id="noExt" placeholder="Ingrese el No. Exterior" class="form-control">

            <label for="colonia">Colonia</label>

            <input type="text" id="colonia" placeholder="Ingrese la colonia" class="form-control ln">

            <label for="localidad">Localidad</label>

            <input type="text" id="localidad" placeholder="Ingrese la localidad" class="form-control ol">

            <label for="municipio">Municipio</label>

            <input type="text" id="municipio" placeholder="Ingrese el municipio" class="form-control ol">

            <label for="estado">Estado</label>

            <input type="text" id="estado" placeholder="Ingrese el estado" class="form-control ol">

            <label for="cp">Código postal</label>

            <input type="number" id="cp" placeholder="Ingrese el código postal" class="form-control on">

            <label for="referencias">Referencias del domicilio</label>

            <input type="text" id="referencias" placeholder="Ingrese las referencias" class="form-control ln">

            <hr>

          </div>

          <div class="mb-3" id="divUniversidadAdscripcion">

            <label for="direccionUniversidad">Dirección de la universidad de adscripción </label>

            <input type="text" class="form-control" name="id" id="id" value="<?= $datos_universidad['id'] ?>" required hidden>

            <textarea type="text" class="form-control" id="direccionUniversidad" name="direccion_envio" placeholder="Nombre de la vialidad (calle, avenida, privada), número Ext. e Int., colonia, localidad, municipio, estado, C.P., referencias del domicilio" required></textarea>

            <div class="invalid-feedback">

              Ingrese la dirección de la universidad.

            </div>

          </div>

        </div>

        <div class="modal-footer ">
          <div class="col-md-12 text-right">

            <button type="submit" id="editarDirEnv" class="btn bg-<?= $_SESSION['red'] ?>" style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">
          </div>



        </div>

      </form>

    </div>

  </div>

</div>

<div id="editProdep_<?php echo $_SESSION["CA"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form method="POST" action="<?php echo base_url('generalUpdate/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar PRODEP</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Nombre</label>

            <input type="text" autofocus class="form-control ln" id="nombre_prodep" name="nombre_prodep" value="<?php echo $datos_universidad["nombre_prodep"] ?>" required> <br>

            <label>Nivel de consolidacion</label>

            <?php echo $datos_universidad["nivel_prodep"]; ?>

            <div class="form-row">

              <label class="custom-control custom-radio custom-control-inline">

                <input type="radio" name="nivel_prodep" <?php echo $datos_universidad["nivel_prodep"] == "Consolidado" ? "checked" : ""; ?> class="custom-control-input nivelProdep" value="Consolidado"><span class="custom-control-label">Consolidado</span>

              </label>

              <label class="custom-control custom-radio custom-control-inline">

                <input type="radio" name="nivel_prodep" class="custom-control-input nivelProdep" value="En consolidación" <?php echo $datos_universidad["nivel_prodep"] == "En consolidación" ? "checked" : ""; ?>><span class="custom-control-label">En

                  consolidación</span>

              </label>

              <label class="custom-control custom-radio custom-control-inline">

                <input type="radio" name="nivel_prodep" class="custom-control-input nivelProdep" value="En formación" <?php echo $datos_universidad["nivel_prodep"] == "En formación" ? " checked" : ""; ?>><span class="custom-control-label">En formación</span>

              </label>

            </div>

            <label>Año de consolidacion</label>

            <input type="number" class="form-control on" name="ano_prodep" id="year" value="<?php echo $datos_universidad["ano_prodep"] ?>" required>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" name="id" value="<?= $datos_universidad['id'] ?>" hidden>

          <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>" style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editNombreUni_<?php echo $_SESSION["CA"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?php echo base_url('generalUpdate/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar nombre de universidad</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Nombre</label>

            <input type="text" class="form-control ln" autofocus id="nombre" name="nombre" value="<?php echo $datos_universidad["nombre"] ?>" required>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" name="id" value="<?= $datos_universidad['id'] ?>" hidden>

          <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>" style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editDirUni_<?php echo $_SESSION["CA"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?php echo base_url('generalUpdate/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar direccion de universidad2</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Direccion</label>

            <input type="text" class="form-control ln" id="direccion" name="direccion" value="<?php echo $datos_universidad["direccion"] ?>" required autofocus>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" name="id" value="<?= $datos_universidad['id'] ?>" hidden>

          <button type="submit" class="btn bg-<?= $_SESSION['red'] ?>" style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>


<script src="<?= base_url('resources/js/datos_generales.js') ?>"></script>