<style>
    hr{
        background-color:white;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-uppercase">Editar proyecto</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/generalUpdateAdmin/proyectos') ?>" method="post">
                <label for="">Tipo de proyecto</label>
                <select name="nombre" id="nombre" class="form-control" required>
                    <option value="" selected disabled>Seleccione un tipo de proyecto</option>
                    <option value="Esquema A: Investigación" <?= $proyecto['nombre'] ==  'Esquema A: Investigación' ? 'selected':''?>>Esquema A: Investigación</option>
                    <option value="Esquema B: Investigación" <?= $proyecto['nombre'] ==  'Esquema B: Investigación' ? 'selected':''?> >Esquema B: Investigación</option>
                    <option value="Congreso" <?= $proyecto['nombre'] ==  'Congreso' ? 'selected':''?>>Congreso</option>
                    <option value="Coloquio" <?= $proyecto['nombre'] ==  'Coloquio' ? 'selected':''?>>Coloquio</option>
                    <option value="Oyente" <?= $proyecto['nombre'] ==  'Oyente' ? 'selected':''?>>Oyente</option>
                </select>
                <input type="hidden" name="esquema" id="esquema" value="<?= $proyecto['esquema'] ?>">
                <label for="">Red</label>
                <select name="redCueCa" id="" class="form-control" required>
                    <option value="" selected disabled>Seleccione la red</option>
                    <?php
                    foreach($redes as $r){
                        ?>
                        <option value="<?= $r['nombre_red'] ?>" <?= $r['nombre_red'] == $proyecto['redCueCa'] ? 'selected':'' ?> ><?= $r['nombre_red'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <label for="anio">Año</label>
                <input type="number" name="anio" id="" required class="form-control" value="<?= $proyecto['anio'] ?>">
                
                <h3>Precios generales</h3>
                <hr>
                <label for="">Monto en pesos</label>
                <input type="number" name="montoMx" id="" class="form-control" required value="<?= $proyecto['montoMx'] ?>">
                <label for="">Monto escrito en pesos</label>
                <p class="text-warning" >Escribelo entre los parentesis</p>
                <input type="text" name="monto_escritoMx" id="" class="form-control" required value="<?= $proyecto['monto_escritoMx'] ?>">
                <label for="">Monto en dolares</label>
                <input type="number" name="montoUs" id="" class="form-control" required value="<?= $proyecto['montoUs'] ?>">
                <p class="text-warning" >Escribelo entre los parentesis</p>
                <label for="">Monto escrito en dolares</label>
                <input type="text" name="monto_escritoUs" id="" class="form-control" required value="<?= $proyecto['monto_escritoUs'] ?>">

                <h3>Precios pronto pago</h3>
                <hr>
                <label for="">Monto en pesos</label>
                <input type="number" name="precio_prontoPagoMx" id="" class="form-control" required value="<?= $proyecto['precio_prontoPagoMx'] ?>">
                <label for="">Monto escrito en pesos</label>
                <p class="text-warning" >Escribelo entre los parentesis</p>
                <input type="text" name="precio_prontoPagoEscritoMx" id="" class="form-control" required value="<?= $proyecto['precio_prontoPagoEscritoMx'] ?>">
                <label for="">Monto en dolares</label>
                <input type="number" name="precio_prontoPagoUs" id="" class="form-control" required value="<?= $proyecto['precio_prontoPagoUs'] ?>">
                <label for="">Monto escrito en dolares</label>
                <p class="text-warning" >Escribelo entre los parentesis</p>
                <input type="text" name="precio_prontoPagoEscritoUs" id="" class="form-control" required value="<?= $proyecto['precio_prontoPagoEscritoUs'] ?>">
                <label for="">Fecha pronto pago</label>
                <input type="date" name="fecha_limite_prontoPago" id="" class="form-control" required value="<?= $proyecto['fecha_limite_prontoPago'] ?>">
                <input type="text" name="id" id="" value="<?= $proyecto['id'] ?>" hidden>
                <hr>
                <button type="submit" class="btn btn-block btn-info">Editar proyecto</button>
                <a class="btn btn-danger btn-block" href="../lista">Regresar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $("#nombre").on('change',function(){
        let val = $(this).val()

        if(val == 'Esquema A: Investigación'){
            $("#esquema").val('A')
        }else if(val == 'Esquema B: Investigación'){
            $("#esquema").val('B')
        }else{
            $("#esquema").val('')
        }
    })
</script>