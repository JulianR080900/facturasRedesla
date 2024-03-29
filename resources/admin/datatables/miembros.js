
    let dataTable;
    let dataTableIsInitialized = false; 

    const dataTableOptions = {
      scrollC: '2000px',
      lengthMenu: [5,10,15,20,100,200,500],
      columnDefs: [
        { className: 'centered', targets: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] },
        { orderable: false, targets: [10,12,14,15]},
        //{ width: '50%', targets: [0]},
        //{ sercheable: false, targets: [2]} //Quita el buscar en esas columnas

      ],
      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      responsive: true,
      pageLength: 10, //Numero de registros por pagina
      destroy: true, //Decimos que la tabla es destruible
      language: {
        lengthMenu: 'Mostrar _MENU_ registros por página',
        zeroRecords: 'Ningun registro encontrado',
        info: 'Mostrando en _START_ a _END_ de un total de _TOTAL_ registros',
        infoEmpty: 'Ningun registro encontrado',
        infoFiltered: '(filtrados desde _MAX_ registros totales)',
        search: 'Buscar 🔎',
        loadingRecords: 'Cargando...',
        paginate: {
          first: 'Primero',
          last: 'Último',
          next: 'Siguiente',
          previous: 'Anterior'
        }
      },
      serverSide: true,
      processing: true,
      ajax: {
        url: 'getListadoMiembros',
        type: 'get'
      },
      columns: [
        {data: 'id'},
        {data: 'nombre'},
        {data: 'telefono'},
        {data: 'correo'},
        {data: 'correo_institucional'},
        {data: 'grado_academico'},
        {data: 'especialidad'},
        {data: 'nivelSNI'},
        {data: 'anoSNI'},
        {data: 'tipo'},
        {data: 'lider'},
        {data: 'claveCuerpo'},
        {data: 'universidad'},
        {data: 'red'},
        {data: 'editar'},
        {data: 'eliminar'}
      ],
      dom: 'lBfrtip', //lBfrtip
      buttons: [
        {
          extend: 'excelHtml5',
          text: 'Descargar Excel <iclass="mdi mdi-file-excel"></iclass=>',
          titleAttr: 'Exportar a Excel',
          className: 'btn btn-success',
          exportOptions: {
            modifier: {
              page: "current",
            },
          },
          customize: function (xlsx) {
            var sheet = xlsx.xl.worksheets["sheet1.xml"];
            $("row:first c", sheet).attr("s", "7");
          },
        }
      ],
    }

    const initDataTable = async()=>{
      if(dataTableIsInitialized){
        dataTable.destroy();
      }

      dataTable = $('#dt_miembros').DataTable(dataTableOptions);

      dataTableIsInitialized = true;

    }

window.addEventListener('load', async() => {
  await initDataTable();
})