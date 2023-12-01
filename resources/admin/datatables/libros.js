
    let dataTable;
    let dataTableIsInitialized = false; 

    const dataTableOptions = {
      scrollC: '2000px',
      lengthMenu: [5,10,15,20,100,200,500],
      columnDefs: [
        { className: 'centered', targets: [0,1,3,4,5,6,7,8,9,10,11,12] },
        { orderable: false, targets: [1,10,11,12]},
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
        url: 'getListadoLibros',
        type: 'get'
      },
      columns: [
        {data: 'id'},
        {
          data: null,
          render: function(data,type,row){
            if(row.img === null){
              return `Portada no cargada`
            }else{
              return `<img src='data:image/jpeg;base64,${row.img}' >`
            }
          }
        },
        {
          data: null,
          render: function(data,type,row){

            if(row.status === 0){
              return `<span class='text-warning'>Ningun archivo cargado</span>`
            }

            let html = '';

            if(row.img === null){
              html += `<p><i class='mdi mdi-close-box text-danger'></i> Portada</p>`
            }else{
              html += `<p><i class='mdi mdi-checkbox-marked text-success'></i> Portada</p>`
            }

            if(row.libro_exist === null){
              html += `<p><i class='mdi mdi-close-box text-danger'></i> Libro</p>`
            }else{
              html += `<p><i class='mdi mdi-checkbox-marked text-success'></i> Libro</p>`
            }

            if(row.dictamen_exist === null){
              html += `<p><i class='mdi mdi-close-box text-danger'></i> Dictamen</p>`
            }else{
              html += `<p><i class='mdi mdi-checkbox-marked text-success'></i> Dictamen</p>`
            }


            return html

          }
        },
        {data: 'nombre'},
        {data: 'isbn'},
        {
          data: 'editorial',
          render: function(data,type,row){
            if(row.change_editorial === true){
              return `${row.editorial} <i class='text-warning mdi mdi-alert' title='Favor de cambiar por el nuevo formato'></i>`
            }

            return row.editorial

          }
        },
        {data: 'anio'},
        {data: 'formato'},
        {data: 'red'},
        {data: 'enlace'},
        {
          data: null,
          render: function(data,type,row){
            return `<a type="button" href="indices/lista/${row.id}" class="btn btn-info btn-icon-text btn-rounded">
            <i class="mdi mdi-book-open-page-variant"></i> Indices </a>`
          }
        },
        {
          data: null,
          render: function(data,type,row){
            return `<a type="button" href="editar/${row.id}" class="btn btn-warning btn-icon-text btn-rounded">
            <i class="mdi mdi-lead-pencil"></i> Editar </a>`
          }
        },
        {
          data: null,
          render: function(data,type,row){
            return `
            <button class="btn btn-danger btn-rounded eliminarLibro" data-id="${row.id}"><i class="mdi mdi-close"></i> Eliminar libro</button>`
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

      dataTable = $('#dt_libros').DataTable(dataTableOptions);

      dataTableIsInitialized = true;

    }

window.addEventListener('load', async() => {
  await initDataTable();
})