
    let dataTable;
    let dataTableIsInitialized = false; 

    const dataTableOptions = {
      scrollC: '2000px',
      lengthMenu: [5,10,20,100,200,500,1000,5000],
      columnDefs: [
        { className: 'centered', targets: [0,1,2,3,4,5] },
        { orderable: false, targets: [4,5]},
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
        url: './getListado',
        type: 'get'
      },
      columns: [
        {
          data: null,
          render: function(row){
            let img_path = '';
            if(row.profile_pic){
              img_path = base_url+`/resources/img/profiles/${row.profile_pic}`
            }else{
              img_path = base_url+`/resources/img/profiles/avatar.png`
            }
            return `<img src="${img_path}" alt="Usuario: ${row.nombre}">`
          }
        },
        {
          data: null,
          render: function(row){
            if(row.ap_materno){
              return `${row.nombre} ${row.ap_paterno} ${row.ap_materno}`
            }else{
              return `${row.nombre} ${row.ap_paterno}`
            }
          }
        },
        {data: 'correo'},
        {data: 'correo_institucional'},
        {
          data: null,
          render: function(row){
            return `<a type="button" href="editar/${row.id}" class="btn btn-warning btn-icon-text btn-rounded"><i class="mdi mdi-lead-pencil"></i> Editar </a>`
          }
        },
        {
          data: null,
          render: function(row){
            return `<button class="btn btn-danger btn-rounded btn-icon-text eliminarUsuario" data-id="${row.id}"> <i class="mdi mdi-delete"></i> Eliminar usuario</button>`
          }
        }
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

      dataTable = $('#dt_usuarios').DataTable(dataTableOptions);

      dataTableIsInitialized = true;

    }

window.addEventListener('load', async() => {
  await initDataTable();
})