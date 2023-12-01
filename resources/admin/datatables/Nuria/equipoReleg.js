
    let dataTable;
    let dataTableIsInitialized = false; 

    const dataTableOptions = {
      scrollC: '2000px',
      lengthMenu: [5,10,15,20,100,200,500],
      columnDefs: [
        { className: 'centered', targets: [0,1,2,3,4,5,6] },
        { orderable: false, targets: []},
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
      }
    }

    const initDataTable = async()=>{
      if(dataTableIsInitialized){
        dataTable.destroy();
      }

      await listCuerpos();

      dataTable = $('#dt_equiposReleg').DataTable(dataTableOptions);

      dataTableIsInitialized = true;

    }

  const listCuerpos = async()=>{
    try{
      const response = await fetch(base_url+'/admin/entrevistas/getListadoEquipo/'+claveCuerpo )
      const entrevistas = await response.json()
      let content = ``;

      entrevistas.forEach((entrevista,index)=>{
        content += `
        <tr>
          <td>${entrevista.id}</td>
          <td>${entrevista.estado}</td>
          <td>${entrevista.nombre_entrevistadora}</td>
          <td>${entrevista.institucion}</td>
          <td>${entrevista.ver}</td>
          <td>${entrevista.bitacora}</td>
          <td>${entrevista.editado}</td>
        </tr>
        `;
      })
      tbody_equiposReleg.innerHTML = content;
        
      
    }catch(e){
      alert(e)
    }
  }

window.addEventListener('load', async() => {
  await initDataTable();
})