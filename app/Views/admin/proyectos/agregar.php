<style>
    hr{
        background-color:white;
    }
</style>

<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-uppercase">Agregar proyecto</h4>
            </div>
            <div class="card-body">
                <form action="./insert" method="post">
                <label for="">Tipo de proyecto</label>
                <select name="nombre" id="nombre" class="form-control" required>
                    <option value="" selected disabled>Seleccione un tipo de proyecto</option>
                    <option value="Esquema A: Investigación">Esquema A: Investigación</option>
                    <option value="Esquema B: Investigación">Esquema B: Investigación</option>
                    <option value="Congreso">Congreso</option>
                    <option value="Coloquio">Coloquio</option>
                    <option value="Oyente">Oyente</option>
                </select>
                <input type="hidden" name="esquema" id="esquema">
                <label for="">Red</label>
                <select name="redCueCa" id="" class="form-control" required>
                    <option value="" selected disabled>Seleccione la red</option>
                    <?php
                    foreach($redes as $r){
                        ?>
                        <option value="<?= $r['nombre_red'] ?>"><?= $r['nombre_red'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <label for="anio">Año</label>
                <input type="number" name="anio" id="" required class="form-control">
                
                <h3>Precios generales</h3>
                <hr>
                <label for="">Monto en pesos</label>
                <input type="number" name="montoMx" id="" class="form-control" required>
                <label for="">Monto escrito en pesos</label>
                <p class="text-warning" >Escribelo entre los parentesis</p>
                <input type="text" name="monto_escritoMx" id="" class="form-control" required value="(00/100 M.N)">
                <label for="">Monto en dolares</label>
                <input type="number" name="montoUs" id="" class="form-control" required>
                <p class="text-warning" >Escribelo entre los parentesis</p>
                <label for="">Monto escrito en dolares</label>
                <input type="text" name="monto_escritoUs" id="" class="form-control" required value="(00/100 USD)">

                <h3>Precios pronto pago</h3>
                <hr>
                <label for="">Monto en pesos</label>
                <input type="number" name="precio_prontoPagoMx" id="" class="form-control" required>
                <label for="">Monto escrito en pesos</label>
                <p class="text-warning" >Escribelo entre los parentesis</p>
                <input type="text" name="precio_prontoPagoEscritoMx" id="" class="form-control" required value="(00/100 M.N)">
                <label for="">Monto en dolares</label>
                <input type="number" name="precio_prontoPagoUs" id="" class="form-control" required>
                <label for="">Monto escrito en dolares</label>
                <p class="text-warning" >Escribelo entre los parentesis</p>
                <input type="text" name="precio_prontoPagoEscritoUs" id="" class="form-control" required value="(00/100 USD)">
                <label for="">Fecha pronto pago</label>
                <input type="date" name="fecha_limite_prontoPago" id="" class="form-control" required>
                <hr>
                <button type="submit" class="btn btn-block btn-info">Agregar proyecto</button>
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