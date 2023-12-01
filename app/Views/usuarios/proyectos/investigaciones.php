
<style>
    .btnClipboard,
    .changeStatus,
    .changeExcelModal{
        cursor: pointer;
    }

    #spreadsheet,
    select[name="dt_investigacion_length"]{
        color: #000;
    }

    .pt2{
        margin-top: 0.5rem;
    }
</style>

<div class="content">
    <div class="card card-header-congresos">

            <div class="card-header">

                <h3>Investigación <?= $red.' '.$anio ?></h3>

            </div>

            <div class="card-body card-body-congresos">
                <?= $instrucciones ?>
                <?= $html ?>
            </div>
        </div>
</div>