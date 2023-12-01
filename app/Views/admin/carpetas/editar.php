<h1>Editar carpetas</h1>
<form action="<?= base_url('admin/generalUpdateAdmin/carpetas') ?>" method="post">
    
    <input type="text" name="id" hidden value="<?= $carpeta['id'] ?>">
    <label for="">Envios</label>
    <input type="text" name="envios" id="envios" class="form-control" value="<?= $carpeta['envios'] ?>" >
    <label for="">Recibidos</label>
    <input type="text" name="recibidos" id="recibidos" class="form-control" value="<?= $carpeta['recibidos'] ?>" >
    <label for="">Formularios</label>
    <input type="text" name="formulario" id="formulario" class="form-control" value="<?= $carpeta['formulario'] ?>">
    <label for="">Respuestas</label>
    <input type="text" name="respuestas" id="respuestas" class="form-control" value="<?= $carpeta['respuestas'] ?>">
    <label for="">Validacion</label>
    <input type="text" name="validacion" id="validacion" class="form-control" value="<?= $carpeta['validacion'] ?>">
    <label for="">Alumnos</label>
    <input type="text" name="alumnos" id="alumnos" class="form-control" value="<?= $carpeta['alumnos'] ?>">
    <hr>
    <button type="button" onclick="formatear()" class="btn btn-warning btn-block">Formatear<i class="mdi mdi-arrow-right-drop-circle"></i></button>
    <button type="submit" class="btn btn-success btn-block submitUpdate">Actualizar <i class="mdi mdi-arrow-right-drop-circle"></i></button>
    <a href="<?= base_url('admin/carpetas/lista') ?>" class="btn btn-danger btn-block btn-icon-text"><i class="mdi mdi-arrow-left-drop-circle btn-icon-append"></i> Regresar</a>

</form>

<style>
    label {
        padding-top: 1rem;
    }
</style>

<script>
        function formatear(){
            //envios//
            let envios = $("#envios").val();
            envios = envios.replace('https://drive.google.com/drive/folders/', '');
            envios = envios.replace('/edit?usp=sharing', '');
            $("#envios").val(envios);
            //recibidos//
            let recibidos = $("#recibidos").val();
            recibidos = recibidos.replace('https://drive.google.com/drive/folders/', '');
            recibidos= recibidos.replace('/edit?usp=sharing', '');
            $("#recibidos").val(recibidos);
        }
          
    </script>
