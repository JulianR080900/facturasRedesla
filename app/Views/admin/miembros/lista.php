<div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-uppercase">Lista de Miembros</h4>
               <div class="text-right">
                <a href="./getExcelMiembros" class="btn btn-rounded btn-success btn-sm text-right">Descargar Excel de todos los miembros</a>
               </div>
                <div class="table-responsive">
                    <table class="table" id="dt_miembros">
                        <thead>
                            <tr>
                                <th class="centered">ID</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Teléfono</th>
                                <th class="centered">Correo</th>
                                <th class="centered">Correo institucional</th>
                                <th class="centered">Grado</th>
                                <th class="centered">Especialidad</th>
                                <th class="centered">Nivel de SNI</th>
                                <th class="centered">Año de SNI</th>
                                <th class="centered">Registrado como</th>
                                <th class="centered">Lider</th>
                                <th class="centered">Cuerpo académico</th>
                                <th class="centered">Universidad</th>
                                <th class="centered">Red</th>
                                <th class="centered">Editar</th>
                                <th class="centered">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_miembros">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?= base_url() ?>';
</script>
<script>
    $(document).on('click', '.eliminarMiembro', function(e) {
        var id = $(this).data('id')

        Swal.fire({
            title: '¿Estas seguro que desea eliminar el miembro del cuerpo académico?',
            html: '<p style="color:red">Esta accion NO es reversible</p><p style="color:gray">Nota: Antes de eliminar a un líder, cambielo en el módulo de cuerpos académicos.</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminalo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "./eliminar",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if(data == 'errorDelete'){
                            Swal.fire(
                            'Lo sentimos!',
                            'Ha ocurrido un error al eliminar el miembro. Contacte a sistemas',
                            'error'
                            ) 
                        }else if(data == 'errorLider'){
                            Swal.fire(
                            'Lo sentimos!',
                            'El miembro se ha eliminado pero el lider no se ha actualizado en automático. Favor de asignarlo en el módulo de cuerpos académicos',
                            'error'
                            )
                        }else if(data == 'success'){
                            Swal.fire(
                                'ÉXITO',
                                'Se ha eliminado el miembro correctamente y se ha asignado un nuevo lider en automático. Favor de revisar.',
                                'success'
                            )
                        }
                        initDataTable()
                    },
                });

            }
        });
    });

    $(document).on('click', '.eliminarAccesos', function(e) {
        var id = $(this).data('id')

        Swal.fire({
            title: '¿Estas seguro que desea eliminar el miembro del cuerpo académico y sus accesos?',
            html: '<p style="color:red">Esta accion NO es reversible</p><p style="color:gray">Nota: El acceso se eliminara en caso de que no haya otro cuerpo académico ligado a el.</p>',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminalo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "./eliminarAccesos",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if(data == 'errorDelete'){
                            Swal.fire(
                            'Lo sentimos!',
                            'Ha ocurrido un error al eliminar el miembro. Contacte a sistemas',
                            'error'
                            ) 
                        }else if(data == 'errorLider'){
                            Swal.fire(
                            'Lo sentimos!',
                            'El miembro se ha eliminado pero el lider no se ha actualizado en automático. Favor de asignarlo en el módulo de cuerpos académicos',
                            'error'
                            )
                        }else if(data == 'success'){
                            Swal.fire(
                                'ÉXITO',
                                'Se ha eliminado el miembro correctamente y se ha asignado un nuevo lider en automático. Favor de revisar.',
                                'success'
                            )
                        }else if(data == 'successAccesos'){
                            Swal.fire(
                                'ÉXITO',
                                'Se ha eliminado el miembro correctamente, sus accesos y se ha asignado un nuevo lider en automático. Favor de revisar.',
                                'success'
                            )
                        }
                        
                    },
                });

            }
        });
    });
</script>
<script src="<?= base_url('resources/admin/datatables/miembros.js') ?>"></script>