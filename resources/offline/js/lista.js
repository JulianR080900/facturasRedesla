$(document).ready(function () {
    tabla = $('#asistencia').DataTable({            
        "lengthChange": false,
        "scrollX":true,
        "autoWidth": false,
        responsive: false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "ajax": {
                    type:"POST",
                    url:base_url + "/getParticipantes",
                    dataSrc:"",
                    data:""
                },
                "columns":[
                    {
                        "data":"id"
                    },
                    {
                        "data":"nombre"
                    },
                    {
                        "data":"red"
                    },
                    {
                        "data":"claveCuerpo"
                    },
                    {
                        "data":"anio"
                    },
                    {
                        "data":"clave_gafete"
                    },
                    {
                        "data":"codigo_ponencia"
                    },
                    {
                        "data":"codigo_ponencia"
                    },
                    {
                        "data":"tipo_asistencia"
                    },
                    {
                        "data":"Asistencia_presencial"
                    },
                    {
                        "data":"Kit_presencial"
                    },
                    {
                        "data":"Asistencia_virtual"
                    },
                    {
                        "data":"Kit_virtual"
                    }
                ]
    });
    });