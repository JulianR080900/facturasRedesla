<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="text-uppercase">Agregar Congreso</h4>
            </div>
            <div class="card-body">
                <form action="./insert" method="post">
                <label for="">Nombre del congreso</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required >
                <label for="">Red</label>
                 <select class="selectRed form-control" name="red" id="red" style="width:100%" required>
                    <option value="" selected disabled>Selecciona la red</option>
                    <?php
                    foreach($redes as $r){
                    ?>
                      <option value="<?=$r ['nombre_red']?>"><?=$r ['nombre_red']?></option>
                    <?php
                    }
                    
                    ?>
                  </select>
                <label for="">Sede</label>
                <input type="text" name="sede" id="sede" class="form-control" required>
                <label for="">Fechas</label>
                <p class="text-warning">Ejemplo: 25 y 26 de mayo de 2023</p>
                <input type="text" name="fechas" id="fechas" class="form-control" required>
                <label for="">Año</label>
                <input type="number" name="anio" id="anio" class="form-control" min = "<?= date('Y') ?>" max = "<?= date('Y')+1?>"  onKeyPress="if(this.value.length==4) return false;" required>
                <label for="">¿Desea activar el congreso/coloqio al insertarlo?</label>
                <div class="form-group">
                <input type="text" name="activo" hidden id="inp_activo" value="0">

                <label class="switch">
                    <input type="checkbox" id="switch" onclick="activar()">
                    <span class="slider round"></span>
                </label>
                </div>
                <button type="submit" class="btn btn-success btn-block">Agregar Congreso<i class="mdi mdi-arrow-right-drop-circle"></i></button>
                <a href="<?= base_url('admin/congresos_info/lista') ?>" class="btn btn-danger btn-block btn-icon-text"><i class="mdi mdi-arrow-left-drop-circle btn-icon-append"></i> Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/select2/select2.min.js"></script>

<script>
function activar(){
  let activo = $("#inp_activo").val();
  if(activo == 0){
    $("#inp_activo").val(1);
  }else{
    $("#inp_activo").val(0);
  }

}
    if ($(".selectRed").length) {
        $(".selectRed").select2();
    }
</script>

<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: red;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: green;
}

input:focus + .slider {
  box-shadow: 0 0 1px green;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50% !important;
}

    label {
        padding-top: 1rem;
    }
</style>