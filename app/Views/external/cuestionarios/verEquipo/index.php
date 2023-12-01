<style>
    body {
        background-image: url("../../../../resources/img/backgrounds/encuestas.png");
    }

    .dt-buttons a {
        background-color: #fff;
        color: #000;
    }

    .dataTables_paginate a {
        color: #fff !important;
    }
    input[type=search]{
        background-color: #fff !important;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-white bg-dark">
                <div class="card-header">
                    <h4>Lista de encuestas: <?= mb_strtoupper($uni) ?></h4>
                </div>
                <div class="card-body">
                    <p>
                    El conteo de ítems es de preguntas con respuesta <b>No aplica o No sé</b>, cuentan sólo en los apartados del estudio (a partir de la 3era. parte), si rebasa los <i>20 ítems</i> <b>debe colocarse como NO válida</b>.
                    </p>
                    <a href="../../../getExcelEquipo/<?= $claveCuerpo ?>/<?= $nombre_tabla ?>"><span class="badge badge-pill badge-success">Descargar todas las encuestas en Excel</span></a>
                    <br><br>
                    <table class="table table-striped table-responsive-lg table-dark" id="dt_investigacion">
                        <thead>
                            <tr>
                                <th class="centered">Folio</th>
                                <th class="centered">Nombre del encuestador</th>
                                <th class="centered">Ítems (NA)</th>
                            </tr>
                        </thead>
                        <tbody id="tb_investigacion">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = '<?= base_url() ?>';
    var tabla = '<?= $nombre_tabla ?>';
    var pass = '<?= $pass ?>';
    var claveCuerpo = '<?= $claveCuerpo; ?>';
</script>
<script src="<?= base_url('resources/js/cuestionarios/equipo.js') ?>"></script>