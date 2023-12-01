<style>
  .fila-seleccionada {
    background-color: #f0f0f0; /* Cambia el color de fondo a tu preferencia */
  }

  textarea, select{
    background-color: #fff !important;
    color: #000 !important;
  }
  
</style>
<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de proyectos</h4>
                </p>
                <div class="table-responsive">
                    <table class="table" id="dt_proyectos">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Cuerpo académico</th>
                                <th class="centered">Proyecto</th>
                                <th class="centered">Monto</th>
                                <th class="centered">Restante</th>
                                <th class="centered">Moneda</th>
                                <th class="centered">Registro por investigación</th>
                                <th class="centered">Fecha de registro</th>
                                <th class="centered">Movimientos</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_proyectos">

                        </tbody>
                    </table>
                   
                </div>
                <hr>
                    
                <button class="btn btn-block btn-danger" id="btnEliminarMultiples">Eliminar proyectos seleccionados</button>
            </div>
        </div>
    </div>
</div>
<script> var base_url = '<?= base_url() ?>'; </script>

<script src="<?= base_url('resources/admin/datatables/proyectos.js') ?>"></script>