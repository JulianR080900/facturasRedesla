<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de CFDI´s 4.0</h4>

                <div class="table-responsive">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th class="centered">Razon Social del receptor</th>
                                <th class="centered">Folio</th>
                                <th class="centered">UID</th>
                                <th class="centered">UUID</th>
                                <th class="centered">Subtotal</th>
                                <th class="centered">Descuento</th>
                                <th class="centered">Total</th>
                                <th class="centered">Receptor</th>
                                <th class="centered">Fecha de timbrado</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Version</th>
                            </tr>
                        </thead>
                        <tbody id="table">

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: './getListadoCFDI40',
        success: async function(response) {
            await dataTable(response);
        },
        error: function(jqXHR) {
            console.log(jqXHR);
        }
    })

    async function dataTable(response) {
        $("#table").DataTable({
            lengthChange: false,
            data: response.data,
            columns: [
                {data: 'RazonSocialReceptor'},
                {data: 'Folio'},
                {data: 'UID'},
                {data: 'UUID'},
                {data: 'Subtotal'},
                {
                    data: null,
                    render: function(data,type,row){
                        if(row.Descuento === null){
                            return 'No aplica'
                        }else{
                            return row.Descuento
                        }
                    } 
                },
                {data: 'Total'},
                {data: 'Receptor'},
                {data: 'FechaTimbrado'},
                {
                    data: null,
                    render: function(data,type,row){
                        if(row.Status == 'cancelada'){
                            return `<span class='text-danger'>${row.Status}</span>`
                        }else if(row.Status == 'enviada'){
                            return `<span class='text-success'>${row.Status}</span>`
                        }else{
                            return row.Status
                        }
                    }
                },
                {data: 'Version'}
            ]
        })
    }
</script>