<div id="editClaveCuerpo_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/cuerpos/updateClaveCuerpo') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar clave</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Clave del grupo</label>

            <input type="text" class="form-control ol" id="verificarClave" name="claveCuerpo" value="<?= $cuerpo["claveCuerpo"]; ?>" required>
            <input type="text" class="form-control ol" name="claveCuerpoVieja" value="<?= $cuerpo["claveCuerpo"]; ?>" required hidden>
          </div>

        </div>

        <div class="modal-footer ">

          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editRector_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar nombre del Rector</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Rector</label>

            <input type="text" class="form-control ol" name="nombre_rector" value="<?= $cuerpo["nombre_rector"]; ?>" required>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" id="id" value="<?= $cuerpo['id'] ?>" required hidden>

          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editGradoRector_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar grado del Rector</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Rector</label>

            <select class="form-control" name="grado_rector">

              <?php

              foreach ($grados_academicos as $g) {



                if ($cuerpo["grado_rector"] == $g["id"]) {

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

          <input type="text" class="form-control" name="id" id="id" value="<?= $cuerpo['id'] ?>" required hidden>

          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editTelefono_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

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
            <input type="text" class="form-control on" name="telefono" value="<?= $cuerpo["telefono"] ?>" required>
          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" id="id" value="<?= $cuerpo['id'] ?>" required hidden>


          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editExtension_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

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
            <input type="text" class="form-control on" id="extension" name="extension" value="<?= $cuerpo["extension"] ?>" required>
          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" value="<?= $cuerpo['id'] ?>" required hidden>

          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editinstEst_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar institución a estudiar</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Institución a estudiar</label>

            <input type="text" class="form-control ln" id="inst_est" name="inst_est" value="<?= $cuerpo["inst_est"] ?>" required>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" id="id" value="<?= $cuerpo['id'] ?>" required hidden>

          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editDirEnvios_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar dirección de envio</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body">
          <div class="verde">
            <p>Instrucciones</p>
            <p>Ingrese los datos requeridos correctamente. Al finalizar de clic en <b>Unir información</b>. Para finalizar el proceso de clic en <b>Actualizar ahora</b></p>
          </div>
          <div class="form-group">

            <div class="mb-3">

              <label for="direccion_envio">Dirección de envio</label>

              <p class="text-warning">Este campo se autorrellenará al momento de unir los datos que introduzca a continuación</p>

              <input type="text" class="form-control" id="direccion_envio" name="direccion_envio" value="<?= $cuerpo["direccion_envio"] ?>" required>

              <input type="text" class="form-control" name="id" id="id" value="<?= $cuerpo['id'] ?>" required hidden>

              <div class="invalid-feedback">

                Ingrese la dirección de envio.

              </div>

            </div>

            <div class="mb-3">

              <label for="calle">Calle</label>

              <input type="text" class="form-control ln" autofocus id="calle" required>

              <div class="invalid-feedback">

                Registre correctamente la calle.

              </div>

            </div>

            <div class="mb-3">

              <label for="numero">Numero</label>

              <input type="number" class="form-control on" id="numero" required>

              <div class="invalid-feedback">

                Registre correctamente el numero de domicilio.

              </div>

            </div>

            <div class="mb-3">

              <label for="colonia">Colonia</label>

              <input type="text" class="form-control ol" id="colonia" required>

              <div class="invalid-feedback">

                Registre correctamente la colonia.

              </div>

            </div>

            <div class="mb-3">

              <label for="estado">Estado</label>

              <select class="form-control" name="estado" id="estado" required>
                <option selected disabled value="">Seleccione una opción</option>
                <?php
                foreach ($estados as $e) {
                ?>
                  <option value="<?= $e['id'] ?>"><?= $e['nombre'] ?></option>
                <?php
                }
                ?>
              </select>

              <div class="invalid-feedback">

                Seleccione correctamente el estado.

              </div>

            </div>

            <div class="mb-3">

              <label for="municipio">Municipio</label>

              <select class="form-control" name="municipio" id="municipio" required>
                <option selected disabled value="">Seleccione una opción</option>
              </select>

              <div class="invalid-feedback">

                Registre correctamente el municipio.

              </div>

            </div>

            <div class="mb-3">

              <label for="municipio">Código postal</label>

              <input type="number" class="form-control on" id="cp" required>

              <div class="invalid-feedback">

                Registre correctamente el código postal.

              </div>

            </div>



          </div>

        </div>

        <div class="modal-footer ">
          <div class="col-md-12 text-right">
            <button type="button" id="formatear" class="btn btn-warning">Unir información</button>

            <button type="submit" id="editarDirEnv" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">
          </div>



        </div>

      </form>

    </div>

  </div>

</div>

<div id="editProdep_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar PRODEP</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Nombre</label>

            <input type="text" autofocus class="form-control ln" id="nombre_prodep" name="nombre_prodep" value="<?= $cuerpo["nombre_prodep"] ?>" required> <br>

            <label>Nivel de consolidacion</label>

            <?= $cuerpo["nivel_prodep"]; ?>

            <div class="form-row">

              <label class="custom-control custom-radio custom-control-inline">

                <input type="radio" name="nivel_prodep" <?= $cuerpo["nivel_prodep"] == "Consolidado" ? "checked" : ""; ?> class="custom-control-input nivelProdep" value="Consolidado"><span class="custom-control-label">Consolidado</span>

              </label>

              <label class="custom-control custom-radio custom-control-inline">

                <input type="radio" name="nivel_prodep" class="custom-control-input nivelProdep" value="En consolidación" <?= $cuerpo["nivel_prodep"] == "En consolidación" ? "checked" : ""; ?>><span class="custom-control-label">En

                  consolidación</span>

              </label>

              <label class="custom-control custom-radio custom-control-inline">

                <input type="radio" name="nivel_prodep" class="custom-control-input nivelProdep" value="En formación" <?= $cuerpo["nivel_prodep"] == "En formación" ? " checked" : ""; ?>><span class="custom-control-label">En formación</span>

              </label>

            </div>

            <label>Año de consolidacion</label>

            <input type="number" class="form-control on" name="ano_prodep" id="year" value="<?= $cuerpo["ano_prodep"] ?>" required>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" name="id" value="<?= $cuerpo['id'] ?>" hidden>

          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editNombreUni_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar nombre de universidad</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Nombre</label>

            <input type="text" class="form-control ln" autofocus id="nombre" name="nombre" value="<?= $cuerpo["nombre"] ?>" required>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" name="id" value="<?= $cuerpo['id'] ?>" hidden>

          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editDirUni_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar direccion de universidad2</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Direccion</label>

            <input type="text" class="form-control ln" id="direccion" name="direccion" value="<?= $cuerpo["direccion"] ?>" required autofocus>

          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" name="id" value="<?= $cuerpo['id'] ?>" hidden>

          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editarLocalidad_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header">

          <h4 class="modal-title">Editar localidad</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body">

          <div class="form-group">

            <label>País</label>

            <select class="form-control" name="pais" id="cbx_pais" style="width:100%">

              <option value="0" selected="true" disabled>Seleccina un país</option>

              <?php

              foreach ($a_paises as $pais) {

              ?>

                <option value="<?= $pais["id"] ?>"><?= $pais["nombre"] ?></option>

              <?php

              }

              ?>
            </select>

            <label>Estado</label>

            <select class="form-control" name="estado" id="cbx_estado" style="width:100%"></select>

            <label for="cbx_municipio">Municipio (Zona de estudio) *</label>

            <select class=" form-control" name="municipio" id="cbx_municipio" style="width:100%"></select>

            <input type="text" name="id" value="<?= $cuerpo['id'] ?>" hidden>

          </div>

        </div>

        <div class="modal-footer">

          <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>



<div id="agregarMunicipio_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="../addMunicipioCa">

        <div class="modal-header">

          <h4 class="modal-title">Agregar municipio</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <input name="claveCuerpo" value="<?= $cuerpo["claveCuerpo"]; ?>" hidden>

        <div class="modal-body">

          <div class="form-group">

            <label for="cbx_municipioplus">Municipio (Zona de estudio) *</label>

            <select class=" form-control" name="id_municipio" id="cbx_municipioplus" required>

              <option value="" selected="true" disabled>Seleccina un municipio</option>

              <?php

              foreach ($municipios as $m) {

              ?>

                <option value="<?= $m["id"] ?>"><?= $m["nombre"] ?></option>

              <?php

              }

              ?>

              <option value="1">Otro municipio</option>

            </select>

          </div>

          <div class="form-row">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-12" id="divotroMunplus" style="display:none;">

              <label for="otromun">Municipio (Zona de estudio)</label>

              <input type="text" class="form-control" id="otromunplus" name="otromunplus" placeholder="Municipio">

            </div>

          </div>

        </div>

        <div class="modal-footer">

          <button type="submit" id="add_mun" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Agregar</button>

          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editarEspecialidad_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade bd-example-modal-lg">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header">

          <h4 class="modal-title">Editar Especialidad</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body">

          <div class="form-group">

            <label>Especialidad</label>

            <select class="form-control" name="especialidad" id="especialidad" style="width:100%">

              <option value="" selected="true" disabled>Seleccina una especialidad</option>

              <?php

              foreach ($especialidades as $e) {

              ?>

                <option value="<?= $e["id"] ?>"><?= $e["nombre"] ?></option>

              <?php

              }

              ?>
            </select>

            <input type="text" name="id" value="<?= $cuerpo['id'] ?>" hidden>

          </div>

        </div>

        <div class="modal-footer">

          <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<div id="editTipoRegistro_<?= $cuerpo["claveCuerpo"] ?>" class="modal fade">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="POST" action="<?= base_url('admin/generalUpdateAdmin/cuerpos_academicos') ?>">

        <div class="modal-header header_title_card">

          <h4 class="modal-title">Editar tipo de registro</h4>

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        </div>

        <div class="modal-body ">

          <div class="form-group">

            <label>Tipo de registro</label>

            <select class="form-control" name="tipo_registro">

            <?php
            
              foreach ($tipos_registro as $t) {
                ?>
                <option value="<?= $t["nombre"] ?>" <?= $t["nombre"] == $cuerpo['tipo_registro'] ? 'selected':'' ?> ><?= mb_strtoupper($t["nombre"]) ?></option>
                <?php
              }
              
              ?>

              <select>

          </div>
          <div class="form-group">
            <label for="">Año</label>
            <blockquote>Este se usará para tomar el mensaje de validación del grupo de investigación</blockquote>
            <input type="number" name="anio_inscripcion" id="" class="form-control" value="<?= $cuerpo['anio_inscripcion'] ?>">
          </div>

        </div>

        <div class="modal-footer ">

          <input type="text" class="form-control" name="id" id="id" value="<?= $cuerpo['id'] ?>" required hidden>

          <button type="submit" class="btn btn-warning style='color: var(--font-color-primary)' style='color: var(--primary-font-color)'><span class=" glyphicon glyphicon-check"></span> Actualizar Ahora</button>

          <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancelar">

        </div>

      </form>

    </div>

  </div>

</div>

<script>
  /*
  $("#verificarClave").on('keyup', function() {
    var claveCuerpo = $("#verificarClave");
    $.ajax({
      url: base_url + 'AdminController/verificarClaveCuerpo',
      type: "POST",
      data: {
        "claveCuerpo": claveCuerpo
      },
      success: function(resp) {
        // var respuesta = JSON.parse(resp);
        // console.log(resp);

        if (resp == "existe") {
          $('#existeCalve').css("display", "block");
          $('#UpdateClave').prop('disabled', true);

        } else {
          $('#existeCalve').css("display", "none");
          $('#UpdateClave').prop('disabled', false);
        }
      },
      statusCode: {
        400: function(xhr) {

        }
      }
    })
  })
  */
</script>

<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>
<script src="<?= base_url('resources/admin/js/cuerpos/editar.js') ?>"></script>