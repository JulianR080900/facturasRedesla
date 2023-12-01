<?php

namespace App\Controllers;
use App\Models\ExternalModel;
use App\Models\IquatroModel;
use App\Models\CuestionariosModel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Exception;

class ExternalController extends BaseController
{

    public $db_serv;
    public $ExternalModel;
    public $CuestionariosModel;
    public $IquatroModel;

    public function __construct()
    {
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $this->ExternalModel = new ExternalModel();
        $db = db_connect('iquatro');
        $this->IquatroModel = new IquatroModel($db);
        $this->CuestionariosModel = new CuestionariosModel();
        $this->db_serv = \Config\Database::connect('cuestionarios');
    }

    public function registro(){
        return view('external/registro');
    }

    public function registro_form($red){

        $condiciones = [];

        $redes_bd = $this->ExternalModel->getAll('redes',$condiciones);

        $redes = [];

        if(!empty($redes_bd)){
            foreach($redes_bd as $r){
                array_push($redes,$r['nombre_red']);
            }
        }

        $url = $_SERVER["REQUEST_URI"];

        $path = $this->request->getPath();
        $explode = explode('/',$path);        
        
        if (in_array($explode[1], $redes)) {
            //   echo '<script>console.log("existe");</script>';

            $data = [];

            $condiciones = ['id !=' => 1];

            $paises = $this->ExternalModel->getAll('pais',$condiciones);

            $data["a_pais"] = $paises;

            $condiciones = [];

            $grados_academicos = $this->ExternalModel->getAll('grado_academico',$condiciones);

            $data["grados_academicos"] = $grados_academicos;

            $especialidades = $this->ExternalModel->getAll("especialidades", $condiciones);

            $data["especialidades"] = $especialidades;

            $vialidades = $this->ExternalModel->getAll("vialidades", $condiciones);

            $data["vialidades"] = $vialidades;

            $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
            $this->response->setHeader('Pragma', 'no-cache');
            $this->response->setHeader('Expires', '0');
            $this->response->setHeader('X-Content-Type-Options', 'nosniff');
            
            return view('external/librerias/index')
            .view('external/registro_redes/'.$red, $data);
            //$this->load->view("registro/redes/$red", $data);

        } else {

            return redirect()->to(base_url('/registro'));

        }
        

    }

    public function nacionalidad(){

        $html = '<option value="" selected="true" disabled>Selecciona nacionalidad</option>';

        $html .= '<option value="2">Mexicana</option>';

        $html .= '<option value="3">Colombiana</option>';

        $html .= '<option value="4">Peruana</option>';

        $html .= '<option value="5">Ecuatoriana</option>';

        $html .= '<option value="6">Argentina</option>';

        $html .= '<option value="1">Otro</option>';

        echo $html;

    }

    public function getEstado(){

        $id_pais = $_POST["pais"];

        if($id_pais == "1"){

            $html = "<option style='display:none' value=''>Seleccina un Estado</option>";

            $html .= "<option value='1'>Otro estado</option>";

            echo $html;

        }else{

            $estados = $this->ExternalModel->getEstados($id_pais);

        $html = "<option style='display:none' value=''>Seleccina un Estado</option>";

        foreach ($estados as $estado) {

            $html .= "<option value='".$estado['id']."'>".$estado['nombre']."</option>";

        }

        $html .= "<option value='1'>Otro estado</option>";

        echo $html;

        }

        

    }

    public function check_email_registro(){
        #VERIFICA SI YA EXISTE EL CORREO EN NUESTRO SISTEMA PARA AUTOCOMPLETAR CAMPOS

        if(!isset($_POST["correo"])){
            redirect(base_url());
            die();
        }

        $correo = $_POST["correo"];

        $condiciones = ['correo' => $correo];

        $usuario = $this->ExternalModel->getAllOneRow('usuarios',$condiciones);

        if(empty($usuario)){
            echo json_encode("");

        }else{

            $condiciones = ['usuario' => $usuario['usuario']];

            $info = $this->ExternalModel->getAllOneRow('miembros',$condiciones);

            $columnas = ['cuerpoAcademico'];

            $cuerpos = $this->ExternalModel->getColumnsAll($columnas,'miembros',$condiciones);

            $cuerpo_inactivo = false;

            foreach($cuerpos as $c){
                $condiciones = [
                    'activo' => 0,
                    'claveCuerpo' => $c['cuerpoAcademico']
                ];

                $is_exist = $this->ExternalModel->exist('cuerpos_academicos',$condiciones);

                if($is_exist){
                    $cuerpo_inactivo = true;
                    break;
                }

            }

            
            
            $array_info = array(

                "nombre" => $info['nombre'],

                "apaterno" => $info["apaterno"],

                "amaterno" => $info["amaterno"],

                "especialidad" => $info["especialidad"],

                "telefono" => $info["telefono"],

                "correo" => $correo,

                "correo_institucional" => $usuario["correo_institucional"],

                "grado_academico" => $info["grado"],

                "nivelSNI" => $info["nivelSNI"],

                "anoSNI" => $info["anoSNI"],

                "usuario" =>$info["usuario"],

                "sexo" => $usuario["sexo"],

                "nacionalidad" => $info["pais"],

                "cuerpo_inactivo" => $cuerpo_inactivo,

                "profile_pic" => $usuario['profile_pic']

            );

            echo json_encode($array_info);

        }
    }

    public function prueba(){
        ob_start();
        // Cargar la vista y capturar la salida en una variable
        echo view('external/registro_redes/correo.php');
        $html = ob_get_contents();
        ob_end_clean();

        echo $html;
    }

    private function registroError($red,$codigo){
        $condiciones = ['nombre_red' => $_POST['redCueCa']];
        $info_red = $this->ExternalModel->getAllOneRow('redes',$condiciones);

        $res = [
            'status' => $codigo,
            'telefono' => str_replace(' ','',$info_red['telefonos']),
        ];
        http_response_code(500);
        echo json_encode($res);
        exit;
    }

    public function insertRegistroRedes(){

        $anio = date('md') >= 1118 ? date('Y')+1 : date('Y');

        $prefijo = $this->getPrefijoRegistro($_POST['tipo_registro']);

        if($prefijo != 'INV'){
            $anio = date('Y');
        }

        if(empty($prefijo)){
            $this->registroError($_POST['redCueCa'],100);
        }

        $str_facultades = '';
        if(isset($_POST['aplicacion_estudio'])){
            foreach($_POST['aplicacion_estudio'] as $index=>$a){
                if($a != ''){
                    if($index === end($_POST['aplicacion_estudio'])){
                        $str_facultades .= $a;
                    }else{
                        $str_facultades .= $a.';';
                    }
                }
            }
        }

        $CA_preliminar = $prefijo.$anio."-" . $this->generateRandom(10);

        $dataUbicacion = $this->validarUbicacion($_POST['cbx_pais'],$_POST['cbx_estado'],$_POST['cbx_municipio']);

        $data_institucion = [
            'claveCuerpo' => isset($CA_preliminar) ? $CA_preliminar : '',
            'nombre' => isset($_POST["nombreUniversidad"]) ? $_POST["nombreUniversidad"] : '',
            'nombre_rector' => isset($_POST["nombreRector"]) ? $_POST["nombreRector"] : '',
            'grado_rector' => isset($_POST["gradoRector"]) ? $_POST["gradoRector"] : '',
            'municipio' => isset($dataUbicacion['municipio']) ? $dataUbicacion['municipio'] : '',
            'estado' => isset($dataUbicacion['estado']) ? $dataUbicacion['estado'] : '',
            'pais' => isset($dataUbicacion['pais']) ? $dataUbicacion['pais'] : '',
            'especialidad' => isset($_POST["especialidad"]) ? $_POST["especialidad"] : 'especialidad pendiente',
            'direccion' => isset($_POST["direccionUniversidad"]) ? $_POST["direccionUniversidad"] : '',
            'telefono' => isset($_POST["telefonoUniversidad"]) ? $_POST["telefonoUniversidad"] : '',
            'extension' => isset($_POST["extensionUniversidad"]) ? $_POST["extensionUniversidad"] : '',
            'direccion_envio' => isset($_POST["direccionEnvio"]) ? $_POST["direccionEnvio"] : '',
            'nombre_prodep' => isset($_POST["nombreProdep"]) ? $_POST["nombreProdep"] : '',
            'nivel_prodep' => isset($_POST["nivelProdep"]) ? $_POST["nivelProdep"] : '',
            'ano_prodep' => isset($_POST["anoProdep"]) ? $_POST["anoProdep"] : '',
            'redCueCa' => isset($_POST['redCueCa']) ? $_POST['redCueCa'] : '',
            'tipo_registro' => isset($_POST["tipo_registro"]) ? $_POST["tipo_registro"] : '',
            'inst_est' => isset($_POST["inst_est"]) ? $_POST["inst_est"] : 'No aplica.',
            'medio_entero' => isset($_POST['cbx_medio']) ? $_POST['cbx_medio'] : '',
            'anio_inscripcion' => $anio,
            'password' => random_int(1, 100000000),
            'preAsistencia' => isset($_POST['preAsistencia']) ? $_POST['preAsistencia'] : '',
            'fac_estudio' => $str_facultades,
            'activo' => 0,
        ];

        $this->ExternalModel->generalInsertSession("cuerpos_academicos", $data_institucion);

        $id_insertado = $_SESSION["id_insertado"];

        unset($_SESSION["id_insertado"]);

        $inserciones = 0;

        $count_miembros = count($_POST["miembros"]);

        foreach($_POST['miembros'] as $key => $m){

            if(!empty($m['usuario'])){
                #SIGNIFICA QUE SI HAY UN USUARIO POR LO QUE NO LO AGREGAMOS EN LA TABLA DE USUARIOS
                $usuario = $m['usuario'];
                #ACTUALIZAMOS LA TABLA DE USUARIOS
                $condiciones_actualizar = ["usuario" => $usuario];
                $data_actualizar = [
                    $_POST['redCueCa'] => 1,
                    'sexo' => $m["sexo"]
                ];
                $this->ExternalModel->generalUpdate("usuarios",$data_actualizar, $condiciones_actualizar);
                //ACTUALIZAMOS LA TABLA DE MIEMBROS EN LA COLUMNA PAIS
                $condiciones_miembros = ["usuario" => $usuario];
                $datos_actualizar = ['pais' => $m["nacionalidad"]];
                $this->ExternalModel->generalUpdate("miembros",$datos_actualizar, $condiciones_miembros);
            }else{
                #SIGNIFICA QUE NO EXISTE Y ES UN USUARIO COMPLETAMENTE NUEVO, SE DEBE INSERTAR EN LA TABLA DE USUARIOS
                #TENEMOS QUE CREAR UN USUARIO
                $usuario = $this->generateRandom(20);
                $pass = password_hash($m['correo_personal'], PASSWORD_DEFAULT);
                $dataUsuario = [
                    'nombre' => trim($m['nombre']),
                    'ap_paterno' => trim($m['ap_paterno']),
                    'ap_materno' => trim($m['ap_materno']),
                    'correo' => trim($m['correo_personal']),
                    'correo_institucional' => trim($m['correo_institucional']),
                    'password' => $pass,
                    'usuario' => $usuario,
                    $_POST['redCueCa'] => 1,
                    'sexo' => $m['sexo']
                ];
            }

            if ($m["SNI"] == "no") {
                $m["nivelSNI"] = NULL;
                $m["anoSNI"] = NULL;
            }

            #CREAMOS EL ARRAY PARA INSERTAR EN LA TABLA DE MIEMBROS

            $data = [
                'nombre' => trim($m['nombre']),
                'apaterno' => trim($m['ap_paterno']),
                'amaterno' => trim($m['ap_materno']),
                'usuario' => "$usuario",
                'grado' => $m['grado_academico'],
                'especialidad' => $m['especialidad'],
                'telefono' => $m['telefono'],
                'nivelSNI' => $m['nivelSNI'],
                'anoSNI' => $m['anoSNI'],
                'tipo' => 'maestro',
                'lider' => $m['lider'],
                'redCueCa' => $_POST['redCueCa'],
                'cuerpoAcademico' => $CA_preliminar,
                'pais' => $m["nacionalidad"],
                'fecha_registro' => date("Y-m-d H:i:s")
            ];

            $dataHistoria = [
                "usuario" => $usuario,
                "redCueCa" => $_POST['redCueCa'],
                "cuerpoAcademico" => $CA_preliminar,
                "year" => $anio
            ];

            $dataCarpeta = [
                "claveCuerpo" => $CA_preliminar,
                "ano_carpeta" => $anio,
                "red" => $_POST['redCueCa']
            ];

            $array_miembros = [];

            $array_historia_usuario = [];

            $array_usuarios = [];

            //HACEMOS UN TRY-CATCH PARA LAS INSERCIONES

            try {
                if ($m["correo_personal"] != "") {

                    if ($this->ExternalModel->generalInsertSession('miembros', $data)) {

                        //SE INSERTO MIEMBROS, AHORA TOCA INSERTAR LA HISTORIA DE USUARIO, TOMAMOS EL ID DEL MIEMBRO Y LO AGREMAMOS A UN ARRAY

                        $id_miembro = $_SESSION["id_insertado"];

                        unset($_SESSION["id_insertado"]);

                        array_push($array_miembros, $id_miembro);

                        if ($this->ExternalModel->generalInsertSession("historia_usuarios", $dataHistoria)) {

                            $id_historia = $_SESSION["id_insertado"];

                            array_push($array_historia_usuario, $id_historia);

                            if (isset($dataUsuario)) { //SI EXISTE LA VARIABLE HACE LA INSERCION

                                if ($m["usuario"] == "") {

                                    if ($this->ExternalModel->generalInsertSession('usuarios', $dataUsuario)) {

                                        $id_usuario = $_SESSION["id_insertado"];

                                        array_push($array_usuarios, $id_usuario);

                                        $inserciones++;

                                    } else {

                                        # OCURRIO UN ERROR AL INSERTAR EL USUARIO, HAY QUE BORRAR EL CUERPO ACADEMICO, LOS MIEMBROS, LAS HISTORIAS DE USUARIO Y LOS USUARIOS REGISTRADOS

                                        throw new Exception('usuarios', 102);

                                    }

                                }

                            }else{

                                //NO TIENE UN USUARIO ASOCIADO AL SISTEMA, POR LO QUE ES COMPLETAMENTE NUEVO

                                $inserciones++;

                            }

                        } else {

                            // OCURRIO UN ERROR AL INSERTAR UNA HISTORIA DE USUARIO, HAY QUE BORRAR EL CUERPO ACADEMICO, LOS MIEMBROS Y LAS HISTORIAS DE USUARIO REGISTRADAS

                            throw new Exception('historia_usuario', 101);

                        }

                    } else {

                        //SIGNIFICA QUE NO SE INSERTO EN MIEMBROS, HUBO UN ERROR, BORRAMOS EL CUERPO ACADEMICO Y LOS MIEMBROS QUE SE HAYAN INSERTADO

                        throw new Exception('miembros', 100);

                    }

                }

            } catch (Exception $e) {
                $codigo_error = $e->getCode();

                switch ($e->getMessage()) {

                    case 'miembros':

                        $condiciones = ['id' => $id_insertado];

                        $this->ExternalModel->generalDelete("cuerpos_academicos", $condiciones);

                        foreach ($array_miembros as $m) {

                            $condiciones = ['id' => $m];

                            $this->ExternalModel->generalDelete("miembros", $condiciones);

                        }

                        break;

                    case 'historia_usuario':

                        $condiciones = ['id' => $id_insertado];

                        $this->ExternalModel->generalDelete("cuerpos_academicos", $condiciones);

                        foreach ($array_miembros as $m) {

                            $condiciones = ['id' => $m];

                            $this->ExternalModel->generalDelete("miembros", $condiciones);

                        }

                        foreach ($array_historia_usuario as $m) {

                            $condiciones = ['id' => $m];

                            $this->ExternalModel->generalDelete("historia_usuarios", $condiciones);

                        }

                        break;

                    case 'usuarios':

                        $condiciones = ['id' => $id_insertado];

                        $this->ExternalModel->generalDelete("cuerpos_academicos", $condiciones);

                        foreach ($array_miembros as $m) {

                            $condiciones = ['id' => $m];

                            $this->ExternalModel->generalDelete("miembros", $condiciones);

                        }

                        foreach ($array_historia_usuario as $m) {

                            $condiciones = ['id' => $m];

                            $this->ExternalModel->generalDelete("historia_usuarios", $condiciones);

                        }

                        foreach ($array_usuarios as $m) {

                            $condiciones = ['id' => $m];

                            $this->ExternalModel->generalDelete("usuarios", $condiciones);

                        }

                        break;



                    default:

                        $this->registroError($_POST['redCueCa'],200);
                        exit;

                }

            }
        }

        /* if($count_miembros != $inserciones){
            $this->registroError($_POST['redCueCa'],300);
        } */

        #$this->ExternalModel->generalInsert("carpetas", $dataCarpeta);


        ###############################################
        $condiciones = ['nombre_red' => $_POST['redCueCa']];
        $info_red = $this->ExternalModel->getAllOneRow('redes',$condiciones);
        //pais
        $condiciones_pais = ["id" => $dataUbicacion['pais']];
        $pais = $this->ExternalModel->getAllOneRow("pais",$condiciones_pais);
        $pais = isset($pais["nombre"]) ? $pais["nombre"] : 'Pendiente';
        //estado
        $condiciones_estado = ["id" => $dataUbicacion['estado']];
        $estado = $this->ExternalModel->getAllOneRow("estados",$condiciones_estado);
        $estado = isset($estado["nombre"]) ? $estado["nombre"] : 'Pendiente';
        //municipio/s
        $condiciones_municipio = ["id" => $dataUbicacion["municipio"]];
        $municipio = $this->ExternalModel->getAllOneRow("municipios",$condiciones_municipio);
        $municipio = isset($municipio["nombre"]) ? $municipio["nombre"] : 'Pendiente';

        $arr_miembros = [];

        foreach($_POST['miembros'] as $m){

            $condiciones = ['id' => $m['grado_academico']];
            $grado_academico = $this->ExternalModel->getAllOneRow("grado_academico",$condiciones);
            $grado_academico = $grado_academico['nombre'];

            $nombre_completo = empty($m['ap_materno']) ? $m['nombre'].' '.$m['ap_paterno'] : $m['nombre'].' '.$m['ap_paterno'].' '.$m['ap_materno'];

            $arr_miembros[] = [
                'grado_academico' => $grado_academico,
                'rol' => $m['lider'] == 1 ? 'Líder' : 'Miembro',
                'nombre_completo' => $nombre_completo,
                'especialidad' => $m['especialidad'],
                'telefono' => $m['telefono'],
                'correo_personal' => $m['correo_personal'],
                'correo_institucional' => $m['correo_institucional']
            ];
        }

        $especialidad = '';

        if( $_POST['redCueCa'] == 'Relen' && $prefijo == 'INV' ){
            $condiciones = ['id' => $data_institucion['especialidad']];
            $especialidad_info = $this->ExternalModel->getAllOneRow('especialidades',$condiciones);

            if(empty($especialidad_info)){
                $this->registroError($_POST['redCueCa'],400);
            }

            $especialidad = $especialidad_info['nombre'];

        }
        


        foreach($_POST["miembros"] as $m){
            $condiciones_ga = ["id" => $m['grado_academico']];

            $grado_academico = $this->ExternalModel->getAllOneRow("grado_academico",$condiciones_ga);

            $grado_academico_abreviatura = $grado_academico["abreviatura"];

            $nombre_miembro = $m["nombre"]." ".$m["ap_paterno"]." ".$m["ap_materno"];

            $nombre_miembro = trim($nombre_miembro);

            $dataCorreo = [
                'info_red' => $info_red,
                'nombre_miembro' => $nombre_miembro,
                'grado_academico' => $grado_academico_abreviatura,
                'anio' => $anio,
                'institucion' => [
                    'nombre' => $data_institucion['nombre'],
                    'rector' => $data_institucion['nombre_rector'],
                    'direccion_paqueteria' => $data_institucion['direccion_envio'],
                    'pais' => $pais,
                    'estado' => $estado,
                    'municipio' => $municipio,
                    'tipo_registro' => $data_institucion['tipo_registro'],
                    'preAsistencia' => $data_institucion['preAsistencia'],
                    'especialidad' => $especialidad
                ],
                'miembros' => $arr_miembros,
                'str_facultades' => $str_facultades,
            ];

            $html = $this->generateHTMLRegistro($dataCorreo);

            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Registro '.strtoupper($_POST['redCueCa']));
            $email->setTo($m["correo_personal"],$m['correo_institucional']);
            $email->setCC('pmejiaa@redesla.la');
            $email->setSubject('¡Bienvenidos a '.strtoupper($_POST['redCueCa']).'!');
            $email->setMessage($html);
            $email->send();
            $email->clear(); 
        }

        

        ###############################################

        return json_encode($html);
        exit;
        
    }

    private function generateHTMLRegistro($data){
        ob_start();
        // Cargar la vista y capturar la salida en una variable
        echo view('external/registro_redes/correo.php',$data);
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    private function validarUbicacion($pais,$estado,$municipio){
        
        $dataReturn = [];

        if(is_numeric($pais) && is_numeric($estado) && is_numeric($municipio)){
            $dataReturn = [
                'pais' => $pais,
                'estado' => $estado,
                'municipio' => $municipio
            ];
            return $dataReturn;
        }

        

        $numeric_pais = is_numeric($pais) ? true : false;

        if(!$numeric_pais){
            //El pais no es numerico, vamos a insertarlo
            $data = [
                'nombre' => $pais
            ];

            $inserted_pais = $this->ExternalModel->generalInsertLastId($data,'pais');

            $data = [
                'id_pais' => $inserted_pais,
                'nombre' => $estado
            ];

            $inserted_estado = $this->ExternalModel->generalInsertLastId($data,'estados');
            
            //Si no existia el estado, menos el pais

            $data = [
                'id_estado' => $inserted_estado,
                'nombre' => $municipio
            ];
            $inserted_municipio = $this->ExternalModel->generalInsertLastId($data,'municipios');

            
            $dataReturn = [
                'pais' => $inserted_pais,
                'estado' => $inserted_estado,
                'municipio' => $inserted_municipio
            ];

        }

        if(!is_numeric($estado)){
            //El pais no tiene id, por lo que hay que insertarlo como pais nuevo
            if($numeric_pais){
                //el pais si se selecciono bien
                $data = [
                    'id_pais' => $pais,
                    'nombre' => $estado
                ];

                $inserted_estado = $this->ExternalModel->generalInsertLastId($data,'estados');
                
                //Si no existia el estado, menos el pais

                $data = [
                    'id_estado' => $inserted_estado,
                    'nombre' => $municipio
                ];
                $inserted_municipio = $this->ExternalModel->generalInsertLastId($data,'municipios');

                
                $dataReturn = [
                    'pais' => $pais,
                    'estado' => $inserted_estado,
                    'municipio' => $inserted_municipio
                ];

            }
        }

        if(!is_numeric($municipio)){
            //El pais no tiene id, por lo que hay que insertarlo como pais nuevo
            $data = [
                'id_estado' => $estado,
                'nombre' => $municipio
            ];

            $inserted_municipio = $this->ExternalModel->generalInsertLastId($data,'municipios');
            
            $dataReturn = [
                'pais' => $pais,
                'estado' => $estado,
                'municipio' => $inserted_municipio
            ];
        }

        return $dataReturn;

    }

    private function getPrefijoRegistro($tipo_registro){
        switch($tipo_registro){
            case 'investigación':
                $prefijo = 'INV';
                break;
            case 'oyente':
                $prefijo = 'OY';
                break;
            case 'coloquio':
                $prefijo = 'COL';
                break;
            case 'congreso':
                $prefijo = 'CG';
                break;
            default:
                $prefijo = '';
                break;
        }

        return $prefijo;
    }

    private function generateRandom($strength){

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $input_length = strlen($permitted_chars);

        $random_string = '';

        for ($i = 0; $i < $strength; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

    public function forgotPassword(){
        return view('external/librerias/index') 
        .view('external/forgotPassword');
    }

    public function resetLink(){

        #ENVIAMOS UN CODIGO PARA LA RECUPERACION DE LA CONTRASEÑA

        if(!isset($_POST['email'])){
            return redirect()->to(base_url('/forgotPassword'));
        }


        $email = $_POST['email'];
        
        $correos = [];

        array_push($correos,$email);

        $condiciones = ['correo' => $email];

        $existe = $this->ExternalModel->exist('usuarios', $condiciones);

        if($existe == 1){

            $columnas = ['nombre'];
            $condiciones = ['correo' => $email];
            $usuario = $this->ExternalModel->getColumnsOneRow($columnas,'usuarios',$condiciones);
            $nombre = $usuario['nombre'];

            $token = rand(000000,999999);

            $data = ['token' => $token];

            $condiciones = ['correo' => $email];

            $url_token = base_url('reset?token=').$token;

            if($this->ExternalModel->generalUpdate('usuarios',$data,$condiciones)){
                #EL CORREO SE HIZO EN UNA PAGINA, EN DADO CASO QUE SE QUIERA CAMBIAR LO PUEDEN HACER CON HTML PURO O CON ESTA WEB
                # https://beefree.io/

                $body = "
                <!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'><head><!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]--><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><meta name='x-apple-disable-message-reformatting'><!--[if !mso]><!--><meta http-equiv='X-UA-Compatible' content='IE=edge'><!--<![endif]--><title></title>

                <style type='text/css'>@media only screen and (min-width: 620px) {.u-row {width: 600px !important;}.u-row .u-col {vertical-align: top;}

                .u-row .u-col-50 {width: 300px !important;}

                .u-row .u-col-100 {width: 600px !important;}

                }

                @media (max-width: 620px) {.u-row-container {max-width: 100% !important;padding-left: 0px !important;padding-right: 0px !important;}.u-row .u-col {min-width: 320px !important;max-width: 100% !important;display: block !important;}.u-row {width: 100% !important;}.u-col {width: 100% !important;}.u-col > div {margin: 0 auto;}}body {margin: 0;padding: 0;}

                table,tr,td {vertical-align: top;border-collapse: collapse;}

                p {margin: 0;}

                .ie-container table,.mso-container table {table-layout: fixed;}

                * {line-height: inherit;}

                a[x-apple-data-detectors=true] {color: inherit !important;text-decoration: none !important;}

                table, td { color: #000000; } #u_body a { color: #161a39; text-decoration: underline; }</style>

                <!--[if !mso]><!--><link href='https://fonts.googleapis.com/css?family=Lato:400,700&display=swap' rel='stylesheet' type='text/css'><!--<![endif]-->

                </head>

                <body class='clean-body u_body' style='margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #f9f9f9;color: #000000'><!--[if IE]><div class='ie-container'><![endif]--><!--[if mso]><div class='mso-container'><![endif]--><table id='u_body' style='border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #f9f9f9;width:100%' cellpadding='0' cellspacing='0'><tbody><tr style='vertical-align: top'><td style='word-break: break-word;border-collapse: collapse !important;vertical-align: top'><!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td align='center' style='background-color: #f9f9f9;'><![endif]-->

                <div class='u-row-container' style='padding: 0px;background-color: #f9f9f9'><div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #f9f9f9;'><div style='border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;'><!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding: 0px;background-color: #f9f9f9;' align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:600px;'><tr style='background-color: #f9f9f9;'><![endif]-->

                <!--[if (mso)|(IE)]><td align='center' width='600' style='width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]--><div class='u-col u-col-100' style='max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;'><div style='height: 100%;width: 100% !important;'><!--[if (!mso)&(!IE)]><!--><div style='box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:15px;font-family:Lato,sans-serif;' align='left'>

                <table height='0px' align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #f9f9f9;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'><tbody><tr style='vertical-align: top'><td style='word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'><span>&#160;</span></td></tr></tbody></table>

                </td></tr></tbody></table>

                <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--></div></div></div>

                <div class='u-row-container' style='padding: 0px;background-color: transparent'><div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;'><div style='border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;'><!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding: 0px;background-color: transparent;' align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:600px;'><tr style='background-color: #ffffff;'><![endif]-->

                <!--[if (mso)|(IE)]><td align='center' width='600' style='width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]--><div class='u-col u-col-100' style='max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;'><div style='height: 100%;width: 100% !important;'><!--[if (!mso)&(!IE)]><!--><div style='box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:25px 10px;font-family:Lato,sans-serif;' align='left'>

                <table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 0px;padding-left: 0px;' align='center'>

                <img align='center' border='0' src='".base_url('resources/img/logos_con_letras/Redesla_letras.png')."' alt='Image' title='Image' style='outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 40%;max-width: 232px;' width='232'/>

                </td></tr></table>

                </td></tr></tbody></table>

                <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--></div></div></div>

                <div class='u-row-container' style='padding: 0px;background-color: transparent'><div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #161a39;'><div style='border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;'><!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding: 0px;background-color: transparent;' align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:600px;'><tr style='background-color: #161a39;'><![endif]-->

                <!--[if (mso)|(IE)]><td align='center' width='600' style='width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]--><div class='u-col u-col-100' style='max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;'><div style='height: 100%;width: 100% !important;'><!--[if (!mso)&(!IE)]><!--><div style='box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:35px 10px 10px;font-family:Lato,sans-serif;' align='left'>

                <table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding-right: 0px;padding-left: 0px;' align='center'>

                <img align='center' border='0' src='".base_url('resources/img/correos/candado.png')."' alt='Image' title='Image' style='outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 10%;max-width: 58px;' width='58'/>

                </td></tr></table>

                </td></tr></tbody></table>

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:0px 10px 30px;font-family:Lato,sans-serif;' align='left'>

                <div style='line-height: 140%; text-align: left; word-wrap: break-word;'><p style='line-height: 140%; text-align: center;'><span style='color: #ffffff; line-height: 19.6px;'><span style='font-size: 28px; line-height: 39.2px;'>Recuperar contraseña</span></span></p></div>

                </td></tr></tbody></table>

                <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--></div></div></div>

                <div class='u-row-container' style='padding: 0px;background-color: transparent'><div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;'><div style='border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;'><!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding: 0px;background-color: transparent;' align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:600px;'><tr style='background-color: #ffffff;'><![endif]-->

                <!--[if (mso)|(IE)]><td align='center' width='600' style='width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]--><div class='u-col u-col-100' style='max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;'><div style='height: 100%;width: 100% !important;'><!--[if (!mso)&(!IE)]><!--><div style='box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:40px 40px 30px;font-family:Lato,sans-serif;' align='left'>

                <div style='line-height: 140%; text-align: left; word-wrap: break-word;'><p style='font-size: 14px; line-height: 140%;'><span style='font-size: 18px; line-height: 25.2px; color: #666666;'>Hola ".$nombre.",</span></p><p style='font-size: 14px; line-height: 140%;'> </p><p style='font-size: 14px; line-height: 140%;'><span style='font-size: 18px; line-height: 25.2px; color: #666666;'>Le hemos enviado este correo electrónico en respuesta a su solicitud de restablecer su contraseña en la plataforma REDESLA</span></p><p style='font-size: 14px; line-height: 140%;'> </p><p style='line-height: 140%;'><span style='color: #666666;'><span style='font-size: 18px; line-height: 25.2px;'>Para cambiar la contraseña, de clic al boton de aquí abajo. Abrira una pestaña en su navegador y siga las instrucciones que indique el sitio web. Si el botón no lo redirecciona, ingrese al siguiente enlace: ".$url_token."</span></span></p></div>

                </td></tr></tbody></table>

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:0px 40px;font-family:Lato,sans-serif;' align='left'>

                <!--[if mso]><style>.v-button {background: transparent !important;}</style><![endif]--><div align='left'><!--[if mso]><v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' xmlns:w='urn:schemas-microsoft-com:office:word' href='' style='height:47px; v-text-anchor:middle; width:520px;' arcsize='2%'  stroke='f' fillcolor='#18163a'><w:anchorlock/><center style='color:#FFFFFF;font-family:Lato,sans-serif;'><![endif]--><a href='".$url_token."' target='_blank' class='v-button' style='box-sizing: border-box;display: inline-block;font-family:Lato,sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #FFFFFF; background-color: #18163a; border-radius: 1px;-webkit-border-radius: 1px; -moz-border-radius: 1px; width:100%; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; mso-border-alt: none;font-size: 14px;'><span style='display:block;padding:15px 40px;line-height:120%;'>Cambiar contraseña</span></a><!--[if mso]></center></v:roundrect><![endif]--></div>

                </td></tr></tbody></table>

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:40px 40px 30px;font-family:Lato,sans-serif;' align='left'>

                <div style='line-height: 140%; text-align: left; word-wrap: break-word;'><p style='line-height: 140%;'><span style='color: #888888; line-height: 19.6px;'><span style='font-size: 16px; line-height: 22.4px;'><em>Ignore este correo electrónico si no solicitó un cambio de contraseña.</em></span></span><br /><span style='font-size: 14px; color: #888888; line-height: 19.6px;'><em><span style='font-size: 16px; line-height: 22.4px;'> </span></em></span></p></div>

                </td></tr></tbody></table>

                <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--></div></div></div>

                <div class='u-row-container' style='padding: 0px;background-color: transparent'><div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #18163a;'><div style='border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;'><!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding: 0px;background-color: transparent;' align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:600px;'><tr style='background-color: #18163a;'><![endif]-->

                <!--[if (mso)|(IE)]><td align='center' width='300' style='width: 300px;padding: 20px 20px 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]--><div class='u-col u-col-50' style='max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;'><div style='height: 100%;width: 100% !important;'><!--[if (!mso)&(!IE)]><!--><div style='box-sizing: border-box; height: 100%; padding: 20px 20px 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:Lato,sans-serif;' align='left'>

                <div style='line-height: 140%; text-align: left; word-wrap: break-word;'><p style='font-size: 14px; line-height: 140%;'><span style='font-size: 16px; line-height: 22.4px; color: #ecf0f1;'>Contacto</span></p><p style='font-size: 14px; line-height: 140%;'><span style='font-size: 14px; line-height: 19.6px; color: #ecf0f1;'>+52 427 138 3542 |</span></p><p style='font-size: 14px; line-height: 140%;'><span style='font-size: 14px; line-height: 19.6px; color: #ecf0f1;'>+52 427 138 9926 | atencion@redesla.la</span></p></div>

                </td></tr></tbody></table>

                <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]><td align='center' width='300' style='width: 300px;padding: 0px 0px 0px 20px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]--><div class='u-col u-col-50' style='max-width: 320px;min-width: 300px;display: table-cell;vertical-align: top;'><div style='height: 100%;width: 100% !important;'><!--[if (!mso)&(!IE)]><!--><div style='box-sizing: border-box; height: 100%; padding: 0px 0px 0px 20px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:61px 5px 5px;font-family:Lato,sans-serif;' align='left'>

                <div style='line-height: 140%; text-align: left; word-wrap: break-word;'><p style='line-height: 140%; font-size: 14px;'><span style='font-size: 14px; line-height: 19.6px;'><span style='color: #ecf0f1; font-size: 14px; line-height: 19.6px;'><span style='line-height: 19.6px; font-size: 14px;'>Redes de Estudios Latinoamericanos</span></span></span></p></div>

                </td></tr></tbody></table>

                <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--></div></div></div>

                <div class='u-row-container' style='padding: 0px;background-color: #f9f9f9'><div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #1c103b;'><div style='border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;'><!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding: 0px;background-color: #f9f9f9;' align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:600px;'><tr style='background-color: #1c103b;'><![endif]-->

                <!--[if (mso)|(IE)]><td align='center' width='600' style='width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]--><div class='u-col u-col-100' style='max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;'><div style='height: 100%;width: 100% !important;'><!--[if (!mso)&(!IE)]><!--><div style='box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:15px;font-family:Lato,sans-serif;' align='left'>

                <table height='0px' align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #1c103b;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'><tbody><tr style='vertical-align: top'><td style='word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%'><span>&#160;</span></td></tr></tbody></table>

                </td></tr></tbody></table>

                <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--></div></div></div>

                <div class='u-row-container' style='padding: 0px;background-color: transparent'><div class='u-row' style='Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #f9f9f9;'><div style='border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;'><!--[if (mso)|(IE)]><table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td style='padding: 0px;background-color: transparent;' align='center'><table cellpadding='0' cellspacing='0' border='0' style='width:600px;'><tr style='background-color: #f9f9f9;'><![endif]-->

                <!--[if (mso)|(IE)]><td align='center' width='600' style='width: 600px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;' valign='top'><![endif]--><div class='u-col u-col-100' style='max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;'><div style='height: 100%;width: 100% !important;'><!--[if (!mso)&(!IE)]><!--><div style='box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;'><!--<![endif]-->

                <table style='font-family:Lato,sans-serif;' role='presentation' cellpadding='0' cellspacing='0' width='100%' border='0'><tbody><tr><td style='overflow-wrap:break-word;word-break:break-word;padding:0px 40px 30px 20px;font-family:Lato,sans-serif;' align='left'>

                <div style='line-height: 140%; text-align: left; word-wrap: break-word;'>

                </div>

                </td></tr></tbody></table>

                <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]--></div></div><!--[if (mso)|(IE)]></td><![endif]--><!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]--></div></div></div>

                <!--[if (mso)|(IE)]></td></tr></table><![endif]--></td></tr></tbody></table><!--[if mso]></div><![endif]--><!--[if IE]></div><![endif]--></body>

                </html>
                ";
                    
                // APARTADO DE ENVIAR EL CORREO

                $email = \Config\Services::email();
                $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
                $email->setTo($correos);
                $email->setSubject('Recuperacion de la contraseña');
                $email->setMessage($body);

                if($email->send()){
                    return redirect()->to(base_url())
                    ->with('icon','success')
                    ->with('title','Listo')
                    ->with('text','Correo de recuperación enviado correctamente. Revise su bandeja de entrada');
                }else{
                    return redirect()->to(base_url())
                    ->with('icon','error')
                    ->with('title','Lo sentimos')
                    ->with('text','Ha ocurrido un error. Intente mas tarde');
                }

            }else{
                
                return redirect()->to(base_url())
                    ->with('icon','error')
                    ->with('title','Lo sentimos')
                    ->with('text','Ha ocurrido un error. Intente mas tarde');

            }

        }else{

            return redirect()->back()
            ->with('icon','error')
            ->with('title','El correo electrónico proporcionado no esta ligado al sistema')
            ->with('text','Verifique que su correo este escrito correctamente');

        }

    }

    public function reset(){

        #MANDAMOS LA VISTA DEL TOKEN EN CASO DE QUE ESE TOKEN EXISTA EN LA BD

        if(!isset($_GET['token'])){
            redirect(base_url('forgotPassword'));
            die();
        }

        #El token no debe ser mayor a 6 caracteres

        $token = $_GET['token'];

        $length = strlen($token);

        if($length < 6 || $length > 6){
            return redirect()->to(base_url())
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text','Asegurese de ingresar al enlace proporcionado en el correo');
        }

        $condiciones = ['token' => $token];


        if($this->ExternalModel->exist('usuarios',$condiciones) != 1){

            return redirect()->to(base_url())
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text','Asegurese de ingresar al enlace proporcionado en el correo');

        }

        $data['token'] = $token;

        return view('external/librerias/index') 
        .view('external/formularios/password',$data);

        
    }

    public function updatePass(){

        $password = $_POST['contra'];

        $password = password_hash($password,PASSWORD_DEFAULT);

        $condiciones = [
            'token' => $_POST['token']
        ];

        $data = [
            'password' => $password
        ];

        if($this->ExternalModel->generalUpdate('usuarios',$data,$condiciones)){
            return redirect()->to(base_url())
            ->with('icon','success')
            ->with('title','¡Éxito!')
            ->with('text','Su contraseña ha cambiado satisfactoriamente, ingrese con su nueva credencial');
        }else{
            return redirect()->back()
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text','Ha ocurrido un error, intente mas tarde');
        }

        
    }

    public function encuestadores(){
        return redirect()->to(base_url('constancias/encuestadores'));
        /* return view('external/librerias/index') 
        .view('external/formularios/encuestador')
        .view('external/footer/index'); */
    }

    public function constancias_dictaminador(){

        $condiciones = [];

        $redes = $this->ExternalModel->getAll('redes',$condiciones);

        $data['redes'] = $redes;

        return view('external/librerias/index') 
        .view('external/formularios/dictaminador',$data)
        .view('external/footer/index');

    }

    public function extraerConstancias(){

        $correo = $_POST["correo"];

        //$correo = 'ramos.julian00@outlook.com';

        $condiciones = array("correo" => $correo);

        $res = $this->ExternalModel->getAll("dictaminador2021",$condiciones);

        if(empty($res)){
            echo json_encode(false);
            exit;
        }

        $i = 0;

        $anios['anios_existentes'] = [];

        foreach($res as $row){

            $return_arr[] = [

                    "id" => $row["id"],

                    "area_revision" => $row["area_revision"],

                    "correo" => $row["correo"],

                    "nombre" => $row["nombre"], //()

                    "id_iq4" => $row["id_iq4"] ,

                    "nombre_articulo" => utf8_encode($row["nombre_articulo"]),

                    "c_revisiones" => $row["c_revisiones"],

                    "fecha" => $row["fecha"],

                    "anio" => $row["anio"]

                ];

                #AQUI OBTENEMOS LA CANTIDAD DE PONENCIAS POR AñO PARA SABER SI DEBEMOS DARLE DISTINCION
                #O NO

            if(isset($anios['anios_existentes'][$row['anio']]['anio'])){

                if(in_array($row['anio'],$anios['anios_existentes'][$row['anio']])){
                    //EXISTE
                    $anios['anios_existentes'][$row['anio']]['cantidad'] = $anios['anios_existentes'][$row['anio']]['cantidad'] + 1;
                }

            }else{

                $anios['anios_existentes'][$row['anio']]['anio'] = $row['anio'];
                $anios['anios_existentes'][$row['anio']]['cantidad'] = 1;
            
            }

            $i++;

        }

        

        $return_arr["cantidad_registros"] = $i;
        $return_arr["cantidad_anios"] = $anios['anios_existentes'];

        echo json_encode(($return_arr));

    }

    public function constancia_unico(){

        $correo = $_POST["correo"];

        $anio = $_POST["anio"];

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $mes = date('n');

        $mes_mx = $meses[$mes-1];

        $ahora = date("d").' de ' . $mes_mx . ' del '. date('Y'); //de %B del %Y
        
        $condiciones = ["correo" => $correo, "anio" => $anio];

        $rows_constancia = $this->ExternalModel->getAll("dictaminador2021",$condiciones);

        $existe = [];

        $cantidad = 0;

        foreach($rows_constancia as $r){

            if(!in_array($r['area_revision'], $existe)){

                array_push($existe,$r['area_revision']);

                $cantidad++;
            }

        }

        $nombre = $rows_constancia[0]["nombre"];

        $ap_paterno = $rows_constancia[0]["ap_paterno"];

        $grado_academico = $rows_constancia[0]["grado_academico"];

        $universidad = $rows_constancia[0]["universidad"];

        #A LO QUE CANTIDAD REFIERE ES A LA CANTIDAD DE REDES, NO A LA CANTIDAD DE PONENCIAS

        $c = $cantidad;
        

        $pdf = new TCPDF();

        function formatoCarta($pdf,$red,$ahora,$nombre,$universidad,$grado_academico, $ap_paterno,$folio){

            $pdf->SetPrintHeader(false);
            
            $pdf->SetPrintFooter(false);

            // set margins
            $pdf->SetMargins(0, 0, 0, true);

            // set auto page breaks false
            $pdf->SetAutoPageBreak(false, 0);

            $pdf->AddPage('P','A4',0);
            
            //$c = $c-5;

            $pdf->Ln(10);

            $pdf->Image(base_url("resources/pdf/constancias/Carta_$red.jpg"), 0, 0, 210, 297, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);
            
            $pdf->SetMargins(10, 0, 10, true);

            $pdf->SetFont('Times', '', 8);

            $pdf->Cell( 0, 10, $folio.'       ', 0, 0, 'R' ); 

    		$pdf->Ln(30);

    		$pdf->SetFont('Times', '', 12);

            $pdf->Cell( 0, 10, "Querétaro, Querétaro a $ahora       ", 0, 0, 'R' ); 

            $pdf->Ln(15);

            $pdf->SetFont('Times', 'B', 12);

            $pdf->write(10,"$nombre");

            $pdf->Ln(6);

            $pdf->SetFont('Times', 'B', 12);

            $pdf->write(10,"$universidad");

            $pdf->Ln(10);

            $pdf->SetFont('Times', '', 12);

            $pdf->write(10,"Apreciable $grado_academico $ap_paterno");

            $pdf->Ln(13);

            $pdf->SetFont('Times', '', 12);

            $pdf->write(6,"El Comité Técnico-Académico de la Red de Estudios Latinoamericanos hace constar y agradece su importante colaboración en el arbitraje de los siguientes productos académicos de la Red con las siguientes referencias:");//texto

            $pdf->Ln(10);

    		$pdf->SetFont('Times', '', 8);
        }

        function stringListado($pdf,$id_iq4,$nombre_articulo,$fecha_realizacion){
            #ESTABLECEMOS LA FUENTE Y EL TAMAñO

            $pdf->SetFont('Times', '', 10);

            #HACEMOS EL STRING DEL LISTADO

            $pdf->write(12,"ID".$id_iq4.": ".$nombre_articulo.", elaborada el $fecha_realizacion\n");

        }

        function pieCarta($pdf){
            $pdf->Ln(10);

            $pdf->SetFont('Times', '', 12);

            $pdf->write(6,"Su participación en el proceso de dictamen entre pares es un importante aporte decidido y fundamental en el compromiso compartido por impulsar el desarrollo de la investigación científica en Latinoamérica."); 

            $pdf->Ln(12);

            $pdf->write(6,"La Red de Estudios Latinoamericanos reitera a usted el reconocimiento por este apoyo brindado y expresa su deseo de seguir contando con su apreciable aporte académico.");
        }
        
        if($cantidad == 1){

            $red = $rows_constancia[0]["area_revision"];

        }else{

            $red = 'REDESLA';

        }

        $i = 0;

        $stringId = "";

        #ESTE APARTADO ES PARA EL FOLIO, LA ESTRUCTURA DEL FOLIO SERA LA SIGUIENTE:
        # DIC-RED-$result-ANIO
        #EN DONDE $result ES LA EXTRACCION DE LA PRIMERA LETRA DESPUES DEL ESPACIO EN EL NOMBRE

        $condiciones = [
            'correo' => $correo,
            'anio' => $anio
        ];

        if(!$this->ExternalModel->exist('constancia_dictaminador',$condiciones)){

            $re = '/\b(\w)[^\s]*\s*/m';
            $str = $nombre;
            $subst = '$1';
            $result = preg_replace($re, $subst, $str);

            $data = [
                'nombre' => $nombre,
                'anio' => $anio,
                'correo' => $correo,

            ];
            
            $insert_id = $this->ExternalModel->generalInsertLastId($data,'constancia_dictaminador');

            $folio = $insert_id.'DIC-'.$red.'-'.$result.'-'.$anio;

            $data = [
                'folio' => $insert_id,
                'folio_completo' => $folio
            ];

            $condiciones = ['id' => $insert_id];

            $this->ExternalModel->generalUpdate('constancia_dictaminador', $data, $condiciones);

        }else{
            
            $folio = $this->ExternalModel->getAllOneRow('constancia_dictaminador',$condiciones);

            $folio = $folio['folio_completo'];

        }

        #RECORREREMOS EL FOREACH DE LAS CONSTANCIAS

        foreach($rows_constancia as $row){
            
            $id_iq4 = $row["id_iq4"];

            $stringId .= $row['id'].',';

            $nombre_articulo = $row["nombre_articulo"];

            $nombre = $row["nombre"];

            $universidad = $row["universidad"];

            $grado_academico = $row["grado_academico"];

            $ap_paterno = $row["ap_paterno"];

            $fecha_realizacion = $row["fecha"];
            
            if($i == 0){

                formatoCarta($pdf,$red,$ahora,$nombre,$universidad,$grado_academico, $ap_paterno,$folio);

                stringListado($pdf,$id_iq4,$nombre_articulo,$fecha_realizacion);

                $i++;

            }else if($i <= 5){

                #SE HACE EL LISTADO EN LA MISMA PAGINA

                stringListado($pdf,$id_iq4,$nombre_articulo,$fecha_realizacion);

                $i++;

            }else{

                #SE RESETEA EL CICLO

                $i = 0;

                #SE HACE EL CIERRE DE LA CARTA ANTERIOR PARA HACER LA NUEVA

                pieCarta($pdf);

                #SE CREA UNA NUEVA HOJA PARA PODER PONER EL LISTADO RESTANTE

                formatoCarta($pdf,$red,$ahora,$nombre,$universidad,$grado_academico, $ap_paterno,$folio);

                #IMPRIMIMOS EL LISTADO CORRESPONDIENTE

                stringListado($pdf,$id_iq4,$nombre_articulo,$fecha_realizacion);
            }

            $i++;
        }

        //$condiciones = ['correo' => $correo, 'anio' => $anio];

        //$data = ['folio' => $folio];

        //$this->ExternalModel->generalUpdate('dictaminador2021',$data,$condiciones);
        

        pieCarta($pdf);

        #ACTUALIZAMOS EL LISTADO DE IDS DE LA PONENCIAS ASOCIADAS

        $data = ['ids_dictaminador' => $stringId];

        $condiciones = ['folio_completo' => $folio];

        $this->ExternalModel->generalUpdate('constancia_dictaminador', $data, $condiciones);

        $pdf->Output('Constancia_'.$red.'.pdf','D');

        exit;

    }

    public function distincion(){

        #OBTENEMOS LOS DATOS DEL POST

        $correo = $_POST['correo'];

        $anio = $_POST['anio'];

        #NOS TRAEMOS TODOS LOS DATOS DE ESE AñO CON EL CORREO

        $condiciones = array("correo" => $correo, "anio" => $anio);

        $rows_constancia = $this->ExternalModel->getAll("dictaminador2021",$condiciones);

        #OBTENEMOS LA CANTIDAD DE REDES QUE SON EN TODOS LOS REGISTROS

        $existe = [];

        $cantidad = 0;

        foreach($rows_constancia as $r){

            if(!in_array($r['area_revision'], $existe)){

                array_push($existe,$r['area_revision']);

                $cantidad++;
            }

        }

        #OBTENEMOS EL NOMBRE DEL PRIMER REGISTRO

        $nombre = $rows_constancia[0]['nombre'];

        #OBTENEMOS QUE TIPO DE CARTA ES, SI ES UNA SOLA RED, PUES A LA RED QUE ES
        #SI SON 2 O MAS, PASA EN AUTOMATICO A REDESLA

        if($cantidad == 1){

            $red = $rows_constancia[0]["area_revision"];

        }else{

            $red = 'REDESLA';

        }

        #VAMOS A CREAR EL FOLIO
        #COMO LA DISTINCION ES UNA CONSTANCIA OTORGADA POR TENER 10 O MAS PONENCIAS
        #EN UN SOLO AñO, NO HAY UNA TABLA

        $condiciones = [
            'correo' => $correo,
            'anio' => $anio
        ];

        if(!$this->ExternalModel->exist('constancia_distincionDictaminador',$condiciones)){

            $re = '/\b(\w)[^\s]*\s*/m';
            $str = $nombre;
            $subst = '$1';
            $result = preg_replace($re, $subst, $str);

            $data = [
                'nombre' => $nombre,
                'anio' => $anio,
                'correo' => $correo,

            ];
            
            $insert_id = $this->ExternalModel->generalInsertLastId('constancia_distincionDictaminador',$data);

            $folio = $insert_id.'DISTDIC-'.$red.'-'.$result.'-'.$anio;

            $data = [
                'folio' => $insert_id,
                'folio_completo' => $folio
            ];

            $condiciones = ['id' => $insert_id];

            $this->ExternalModel->generalUpdate('constancia_distincionDictaminador', $data, $condiciones);

        }else{
            
            $folio = $this->ExternalModel->getAllOneRow('constancia_distincionDictaminador',$condiciones);

            $folio = $folio['folio_completo'];

        }

        #INSTANCIAMOS FPDF

        $pdf = new TCPDF();

        $pdf->SetPrintHeader(false);
            
        $pdf->SetPrintFooter(false);

        // set margins
        $pdf->SetMargins(0, 0, 0, true);

        // set auto page breaks false
        $pdf->SetAutoPageBreak(false, 0);

        $pdf->AddPage('L',array(330,255),0);

        $pdf->image(base_url("resources/pdf/constancias/distinciones/$red.jpg"),0,-1,330,255,'jpg');

        $pdf->SetFont('Times', '', 8);

        $pdf->Ln(5);

        $pdf->SetMargins(0, 0, 10, true);

        $pdf->Cell( 0, 10, $folio, 0, 0, 'R' ); 

        $pdf->SetFont('Times', 'B', 34);

        $pdf->Ln(100);

        $pdf->Cell(0,0,$nombre,0,0,'C');

        $pdf->Output('Distincion_'.$red.'_'.$anio.'.pdf','D');
        

    }

    public function marcos(){
        
        #marcos para fotos

        $redes = [
            'Relep',
            'Relen',
            'Relayn',
            'Releem',
            'Releg'
        ];

        $data['redes'] = $redes;

        return view('external/librerias/index') 
        .view('external/marcos/index',$data)
        .view('external/footer/index');
    }

    public function getMarco(){ 










        /*
        $src = $_FILES['photo']['tmp_name'];
        $imageName = uniqid() . $_FILES['photo']['name'];
        $targ = base_url('public/images/marcos/usuarios/'). $imageName;
        move_uploaded_file($src, $targ);
        echo $targ;
        */

        
        if($imgFile = $this->request->getFile('photo')){
            if($imgFile->isValid() && !$imgFile->hasMoved()){
                $validated = $this->validate([
                    'imagen' => [
                        'uploaded[photo]',
                        'mime_in[photo,image/png,image/jpeg,image/jpg]',
                        'max_size[photo,5000]'
                    ]
                ]);

                if($validated){
                    $nombre = $imgFile->getRandomName();
                    $imagen = \Config\Services::image()
                    ->withFile($imgFile)
                    ->resize(450,450,true,'height')
                    ->save(ROOTPATH.'public/images/marcos/usuarios/'.$nombre);
                    #$imgFile->move(ROOTPATH.'public/images/marcos/usuarios',$nombre);
                    echo base_url('public/images/marcos/usuarios/'.$nombre);
                }
            }

        }else{
            echo 'no';
        }
        

        /*
        if($imgFile = $this->request->getFile('fotoUsuario')){
            if($imgFile->isValid() && !$imgFile->hasMoved()){
                $validated = $this->validate([
                    'imagen' => [
                        'uploaded[fotoUsuario]',
                        'mime_in[fotoUsuario,image/png]',
                        'max_size[fotoUsuario,5000]'
                    ]
                ]);

                if($validated){
                    $nombre = $imgFile->getRandomName();
                    $marco_size = getimagesize(base_url('resources/img/marcos/'.$_POST['red'].'.png'));
                    $imagen = \Config\Services::image()
                    ->withFile($imgFile)
                    ->resize($marco_size[0],$marco_size[1],true,'height')
                    ->save(ROOTPATH.'public/images/marcos/usuarios/'.$nombre);
                    $imagenUsuario = imagecreatefrompng(base_url('public/images/marcos/usuarios/'.$nombre));
                    $marco = imagecreatefrompng(base_url('resources/img/marcos/'.$_POST['red'].'.png'));
                    imagealphablending($marco,false);
                    imagesavealpha($marco, true);
                    imagecreatetruecolor($marco_size[0],$marco_size[1]);
                    imagecopymerge($marco, $imagenUsuario, 10, 9, 0, 0, 181,180, 100);
                    imagepng($marco);
                    $this->response->setHeader('Content-type','image/png');
                    #$imgFile->move(ROOTPATH.'public/images/marcos/usuarios',$nombre);
                    /
                    if($imgFile->move(ROOTPATH.'public/images/marcos/usuarios',$nombre)){
                        $dest = imagecreatefrompng(base_url('public/images/marcos/usuarios/'.$nombre));
                        $marco = imagecreatefrompng(base_url('resources/img/marcos/'.$_POST['red'].'.png'));
                        $marco_size = getimagesize(base_url('resources/img/marcos/'.$_POST['red'].'.png'));
                        
                        imagecopymerge($marco, $dest, 0, 0, 10, 0, 100,100, 100);
                        imagepng($marco);
                        $this->response->setHeader('Content-type','image/png');
                    }else{
                        echo 'error';
                    }
                }else{
                    #NO CUMPLIO LAS VALIDACIONES DEL ARCHIVO
                    return redirect()->back()
                        ->with('icon','warning')
                        ->with('title','Cuidado')
                        ->with('text','Los archivos aceptados son PNG, JPEG y JPG y su peso debe ser menor a 5MB');
                }
            }
        }
        */
        /*
        $marco = file_get_contents(base_url('resources/img/marcos/'.$_POST['red'].'.png'));

        list($width,$height) = getimagesize($imagen);

        $imagen = imagecreatefromstring($imagen);
        $marco = imagecreatefromstring($marco);

        imagecopymerge($marco,$imagen,0,100,0,0,$width,$height,100);
        header('Content-Type: image/png');
        imagepng($marco);
        */

    }

    public function generate_password(){
        $pass = "monipsic2014@gmail.com";
        $hash = password_hash($pass,PASSWORD_DEFAULT);
        echo $hash;
    }

    public function foliosCursos(){
        $condiciones = [];
        $constancias = $this->ExternalModel->getAll('constancia_sni',$condiciones);
        foreach($constancias as $c){
            $folio = $c['id'].'-'.$c['formatoFolio'];
            $data = ['folio' => $folio];
            $condiciones = ['id' => $c['id']];
            $this->ExternalModel->generalUpdate('constancia_sni',$data,$condiciones);
        }
    }

    # ========================== CUESTIONARIOS ===================================
    public function cuestionarios($anio,$claveCuerpo,$pass){

        $max_connections = 2000; // Define el número máximo de conexiones permitidas
        
        $num_connections = $this->CuestionariosModel->get_max_connections(); //OBTENEMOS EL NUMERO DE CONEXIONES ACTUALES

        if ($num_connections >= $max_connections) {
            // Si hay más conexiones que el límite permitido, muestra un mensaje de error
            return redirect()->to(base_url())
            ->with('icon','warning')
            ->with('title','Lo sentimos')
            ->with('text','En este momento hay muchas personas utilizando el sistema. Para garantizar que todos tengan una experiencia fluida, 
            se ha alcanzado el límite máximo de personas conectadas. Por favor, inténtalo de nuevo más tarde. Gracias por tu comprensión.');
        }
        
        
        $condiciones = ['claveCuerpo' => $claveCuerpo, 'password' => $pass];

        if(!$this->ExternalModel->exist('cuerpos_academicos',$condiciones)){
            #NO EXISTE EL CUERPO, LO MANDAMOS al menu
            return redirect()->to(base_url())
            ->with('icon','warning')
            ->with('title','Lo sentimos')
            ->with('text','El enlace no es válido');
        }

        #VERIFICAMOS SI YA TERMINARON SU PROCESO
        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => $anio];
        $validado = $this->ExternalModel->getAllOneRow('validacion',$condiciones);

        if(!empty($validado)){
            if($validado['terminado'] == 1){
                return redirect()->to(base_url())
                ->with('icon','warning')
                ->with('title','Lo sentimos')
                ->with('text','El proceso de captura ha sido suspendido para una fase de revisión.');
            }
        }

        $nombre_metodo = "investigacion_{$anio}";
        
        if(!method_exists($this,$nombre_metodo)){
            return redirect()->to(base_url())
                ->with('icon','warning')
                ->with('title','Lo sentimos')
                ->with('text','Instrumento de investigación en proceso');
        }

        $data = $this->$nombre_metodo($claveCuerpo);

        if(!$data['avalible']){
            //No esta disponible en este momento
            return redirect()->to(base_url())
            ->with('icon','warning')
            ->with('title','Trabajando... 👷🏻‍♀️')
            ->with('text','La encuesta está bajo labor de mantenimiento. Se estará habilitando lo más pronto posible.');
        }

        //No se puede optimizar
        $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', '0');

        return view('external/librerias/index') 
        .view('external/cuestionarios/'.$data['red']['nombre_red'].'/'.$anio.'/'.$data['nombre_archivo'],$data)
        .view('external/footer/index');
        
        
    }

    private function investigacion_2024($claveCuerpo){
        #VAMOS A VERIFICAR SI EL CUERPO TIENE LA INVETSIGACION (PENDIENTE)
        $condiciones = ['claveCuerpo' => $claveCuerpo];

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['redCueCa','municipio','pais','especialidad', 'estado','inst_est'];
        $ca = $this->ExternalModel->getColumnsOneRow($columnas,'cuerpos_academicos',$condiciones);

        $condiciones = ['id' => $ca['municipio']];
        $municipio_original = $this->ExternalModel->getAllOneRow('municipios',$condiciones);
        $municipio = [];
        array_push($municipio,$municipio_original['nombre']);

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $municipios_extra = $this->ExternalModel->getAll('municipios_ca',$condiciones);

        if(!empty($municipios_extra)){
            foreach($municipios_extra as $me){
                array_push($municipio,$me['nombre_municipio']);
            }
            
        }
        

        $condiciones = ['id' => $ca['estado']];
        $estado = $this->ExternalModel->getAllOneRow('estados',$condiciones);

        $condiciones = ['id' => $ca['pais']];
        $pais = $this->ExternalModel->getAllOneRow('pais',$condiciones);
        
        $condiciones = ['nombre_red' => $ca['redCueCa']];
        $red = $this->ExternalModel->getAllOneRow('redes',$condiciones);

        $condiciones = [];

        $tipo_asociaciones = $this->CuestionariosModel->getAll('tipo_asociaciones',$condiciones);

        $giros = $this->CuestionariosModel->getAll('giros',$condiciones);

        $entidades = $this->CuestionariosModel->getAll('entidades_federativas',$condiciones);

        $fundacion = $this->CuestionariosModel->getAll('fundacion',$condiciones);

        $estrategias = $this->CuestionariosModel->getAll('estrategias',$condiciones);

        $problematicas = $this->CuestionariosModel->getAll('problematicas',$condiciones);

        $concentracion_empresas = $this->CuestionariosModel->getAll('concentracion_empresas',$condiciones);

        $propiedad_empresa = $this->CuestionariosModel->getAll('propiedad_empresa',$condiciones);

        $nivel_estudios = $this->CuestionariosModel->getAll('nivel_estudios',$condiciones);

        $paises = $this->CuestionariosModel->getAll('paises',$condiciones);

        $estado_civil = $this->CuestionariosModel->getAll('estado_civil',$condiciones);

        $vialidades = $this->CuestionariosModel->getAll('vialidades',$condiciones);

        $rama1 = $this->CuestionariosModel->getAll('rama1',$condiciones);

        $asentamientos = $this->CuestionariosModel->getAll('asentamientos',$condiciones);

        $conglomerados = $this->CuestionariosModel->getAll('conglomerados',$condiciones);

        $pisos = $this->CuestionariosModel->getAll('pisos',$condiciones);

        $estado = empty($estado) ? $ca['estado'] : $estado['nombre'];

        $nombre_archivo = 'index'; #propuesta

        $is_claveEstado = false;

        if($red['nombre_red'] == 'Relen'){
            $condiciones = [];
            $especialidades = $this->ExternalModel->getAll('especialidades',$condiciones);
            $data['especialidades'] = $especialidades;
            $condiciones = ['id' => $ca['especialidad']];
            $especialidad_ca = $this->ExternalModel->getAllOneRow('especialidades',$condiciones);
            $especialidad_ca = empty($especialidad_ca) ? $ca['especialidad'] : $especialidad_ca['nombre'];
            $data['especialidad_ca'] = $especialidad_ca;
        }

        if($red['nombre_red'] == 'Relayn'){
            if($pais['id'] == 2){
                $condiciones = ['estado' => $estado];
                $clave_estado = $this->CuestionariosModel->getAllOneRow('claves_municipios',$condiciones);
                $clave_estado = $clave_estado['clave_estado'];
                $is_claveEstado = true;
            }else if($pais['id'] == 5){
                $nombre_archivo = 'Ecuador';
            }else if($pais['id'] == 4){
                $nombre_archivo = 'Peru';
            }else if($pais['id'] == 3){
                $condiciones = ['nivel' => 1];
                #$ciiu = $this->CuestionariosModel->getAll('comun_codigo_ciiu',$condiciones);
                $nombre_archivo = 'Colombia';
            }
            
        }

        $data = [
            'ca' => $ca,
            'red' => $red,
            'claveCuerpo' => $claveCuerpo,
            'tipo_asociaciones' => $tipo_asociaciones,
            'giros' => $giros,
            'entidades' => $entidades,
            'fundacion' => $fundacion,
            'estrategias' => $estrategias,
            'problematicas' => $problematicas,
            'concentracion_empresas' => $concentracion_empresas,
            'propiedad_empresa' => $propiedad_empresa,
            'nivel_estudios' => $nivel_estudios,
            'paises' => $paises,
            'estado_civil' => $estado_civil,
            'municipio' => $municipio,
            'pais' => $pais,
            'vialidades' => $vialidades,
            'rama1' => $rama1,
            'asentamientos' => $asentamientos,
            'conglomerados' => $conglomerados,
            'pisos' => $pisos,
            'estado' => $estado,
            'nombre_archivo' => $nombre_archivo,
            'avalible' => true
        ];

        if($is_claveEstado){
            $data['clave_estado'] = $clave_estado;
        }

        return $data;
    }

    public function addCuestionario(){
    
        #VAMOS A HACER EL DIABLO MANO
        #VAMOS A HACER TABLAS EN LA BASE DE DATOS DE MANERA DINAMICA

        #VAMOS A VERIFICAR SI EXISTE UNA TABLA CON LAS CONDICIONES DADAS

        /* echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        exit; */

        $_POST['anio'] = 2024;
        
        $red = strtolower($_POST['red']);
        $nombre_tabla = 'cuestionarios_'.$red.'_'.$_POST['anio'];

        $db = db_connect('cuestionarios');

        if(!$db->tableExists($nombre_tabla)){

            #NO EXISTE LA TABLA, VAMOS A CREARLA DINAMICAMENTE MANO
            $data = $_POST;
            unset($data['red']);
            unset($data['anio']);
            unset($data['claveCuerpo']);
            unset($data['claveCuerpo']);
            unset($data['type']);

            $consulta = 'CREATE TABLE IF NOT EXISTS '.$nombre_tabla.' (
            id int UNSIGNED NOT NULL AUTO_INCREMENT, 
            red varchar(10) NOT NULL, 
            claveCuerpo varchar(50) NOT NULL, 
            anio int(4) NOT NULL, 
            fecha_insert datetime NOT NULL, 
            fecha_update datetime ON UPDATE CURRENT_TIMESTAMP, 
            estado int(1) NOT NULL, 
            folio varchar (20) NOT NULL, ';

            foreach($data as $key=>$d){
                $consulta .= $key.' TEXT NOT NULL,'; 
            }
            $consulta .= 'PRIMARY KEY(id)
            ) ENGINE=MyISAM ROW_FORMAT=COMPRESSED';
            
            if(!$this->db_serv->query($consulta)){
                return redirect()->back();
            }

        }

        

        #UNA VEZ CREADA LA TABLA, SI ES QUE SE CREO VAMOS A INSERTAR LOS DATOS A LA BASE DE DATOS MANO

        $formulario = $_POST;

        if($_POST['red'] == 'Relayn' && $_POST['anio'] == 2024){ //funciono para 2023 tambien
            unset($formulario['type']);
            $str_productos = '';
            foreach($_POST['productos'] as $keyProductos=>$p){
                $str_productos = $str_productos.$p.',';
            }
            $str_productos = substr($str_productos, 0, -1);
            $formulario['productos'] = $str_productos;
        }
        

        $data = [];
        foreach($formulario as $key=>$f){
            $data[$key] = $f;
        }

        $data['fecha_insert'] = date("Y-m-d H:i:s");

        $folio = $this->CuestionariosModel->generalInsertLastId($data,$nombre_tabla);
        
        $formato_folio = $folio.'-'.strtoupper($_POST['red']).'-'.$_POST['anio'];

        $data = ['folio' => $formato_folio];

        if(empty($folio)){
            #ERROR AL INSERTAR EL REGISTRO
            return redirect()->back()
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text', 'Ha ocurrido un error al registrar su folio. Intente mas tarde');
            
        }

        #LE ACTUALIZAMOS EL FOLIO
        $consulta = 'UPDATE '.$nombre_tabla.' SET folio = "'.$formato_folio.'" WHERE id = '.$folio;
        
        if(!$this->db_serv->query($consulta)){
            return redirect()->back()
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text', 'Ha ocurrido un error, intente mas tarde');
        }

        
        return redirect()->back()
        ->with('icon','success')
        ->with('title','Éxito')
        ->with('text', 'Encuesta registrada correctamente. El folio de su cuestionario es: '.$formato_folio);
        

    }

    public function getRama1(){
        $giro = $_POST['giro'];

        $condiciones = ['giro' => $giro];

        $sectores = $this->CuestionariosModel->getAll('rama1',$condiciones);
 
        $html = '<option value="" selected disabled>Seleccione una opción</option>';
        foreach($sectores as $s){
            $html .= '<option value="'.$s['nombre'].'">'.$s['nombre'].'</option>';
        }

        echo $html;
    }

    public function getRama1Ciiu(){
        $giro = $_POST['giro'];

        $condiciones = ['giro' => $giro, 'nivel' => 1];

        $sectores = $this->CuestionariosModel->getAll('comun_codigo_ciiu',$condiciones);
 
        $html = '<option value="" selected disabled>Seleccione una opción</option>';
        foreach($sectores as $s){
            $descripcion = $s['codigo'].'--'.$s['descripcion'];
            $html .= '<option value="'.$s['codigo'].'">'.$descripcion.'</option>';
        }

        echo $html;
    }

    public function getRama2(){

        $nombre = $_POST['nombre'];
        preg_match_all('!\d+!', $nombre, $id);
        $id = $id[0][0];
        $id_format = '_'.$id.'_%';
        if($id == 31){
            $consulta = 'SELECT * FROM rama2 WHERE nombre LIKE "_32_%" OR nombre LIKE "_33_%" OR nombre LIKE "'.$id_format.'"';
        }else if($id == 48){
            $consulta = 'SELECT * FROM rama2 WHERE nombre LIKE "_49_%" OR nombre LIKE "'.$id_format.'"';
        }else{
            $consulta = 'SELECT * FROM rama2 WHERE nombre LIKE "'.$id_format.'"';
        }
        
        $datos = $this->db_serv->query($consulta)->getResult();
        $array = json_decode(json_encode($datos), true);
        $html = '<option value="" selected disabled>Seleccione una opción</option>';
        foreach($array as $d){
            $html .= '<option value="'.$d['nombre'].'">'.$d['nombre'].'</option>';
        }
        echo $html;
    }

    public function getRama2Ciiu(){
        $codigo = $_POST['codigo'];

        $condiciones = ['referencia' => $codigo, 'nivel' => 2];

        $sectores = $this->CuestionariosModel->getAll('comun_codigo_ciiu',$condiciones);
 
        $html = '<option value="" selected disabled>Seleccione una opción</option>';
        foreach($sectores as $s){
            $descripcion = $s['codigo'].'--'.$s['descripcion'];
            $html .= '<option value="'.$s['codigo'].'">'.$descripcion.'</option>';
        }

        echo $html;
    }

    public function getRama3(){

        $nombre = $_POST['nombre'];
        preg_match_all('!\d+!', $nombre, $id);
        $id = $id[0][0];
        $id_format = '_'.$id.'_%';

        $consulta = 'SELECT * FROM rama3 WHERE nombre LIKE "'.$id_format.'"';
        $datos = $this->db_serv->query($consulta)->getResult();
        $array = json_decode(json_encode($datos), true);
        $html = '<option value="" selected disabled>Seleccione una opción</option>';
        foreach($array as $d){
            $html .= '<option value="'.$d['nombre'].'">'.$d['nombre'].'</option>';
        }
        echo $html;
    }

    public function getRama3Ciiu(){
        $codigo = $_POST['codigo'];

        $condiciones = ['referencia' => $codigo, 'nivel' => 3];

        $sectores = $this->CuestionariosModel->getAll('comun_codigo_ciiu',$condiciones);
 
        $html = '<option value="" selected disabled>Seleccione una opción</option>';
        foreach($sectores as $s){
            $descripcion = $s['codigo'].'--'.$s['descripcion'];
            $html .= '<option value="'.$s['codigo'].'">'.$descripcion.'</option>';
        }

        echo $html;
    }

    public function getRama4(){

        $nombre = $_POST['nombre'];
        preg_match_all('!\d+!', $nombre, $id);
        $id = $id[0][0];
        $id_format = '_'.$id.'_%';

        $consulta = 'SELECT * FROM rama4 WHERE nombre LIKE "'.$id_format.'"';
        $datos = $this->db_serv->query($consulta)->getResult();
        $array = json_decode(json_encode($datos), true);
        $html = '<option value="" selected disabled>Seleccione una opción</option>';
        foreach($array as $d){
            $nombre = $d['nombre'];
            preg_match_all('!\d+!', $nombre, $denue);
            $denue = $denue[0][0];
            $html .= '<option value="'.$denue.'">'.$d['nombre'].'</option>';
        }
        echo $html;
    }

    public function getRama4Ciiu(){
        $codigo = $_POST['codigo'];

        $condiciones = ['referencia' => $codigo, 'nivel' => 4];

        $sectores = $this->CuestionariosModel->getAll('comun_codigo_ciiu',$condiciones);
 
        $html = '<option value="" selected disabled>Seleccione una opción</option>';
        foreach($sectores as $s){
            $descripcion = $s['codigo'].'--'.$s['descripcion'];
            $html .= '<option value="'.$s['codigo'].'">'.$descripcion.'</option>';
        }

        echo $html;
    }

    public function getRama5(){

        $nombre = $_POST['nombre'];
        preg_match_all('!\d+!', $nombre, $id);
        $id = $id[0][0];
        $id_format = '_'.$id.'_%';

        $consulta = 'SELECT * FROM rama5 WHERE nombre LIKE "'.$id_format.'"';
        $datos = $this->db_serv->query($consulta)->getResult();
        $array = json_decode(json_encode($datos), true);
        $html = '<option value="" selected disabled>Seleccione una opción</option>';
        foreach($array as $d){
            $nombre = $d['nombre'];
            preg_match_all('!\d+!', $nombre, $denue);
            $denue = $denue[0][0];
            $html .= '<option value="'.$denue.'">'.$d['nombre'].'</option>';
        }
        echo $html;
    }

    public function getProductos(){
        if(isset($_GET['str'])){
            $str = $_GET['str'];
            $sql = 'SELECT * FROM productos WHERE nombre LIKE "%'.$str.'%"';
            $items = $this->db_serv->query($sql)->getResult();
            $data['total_count'] = $this->db_serv->affectedRows($sql);
            $data['items'] = $items;
            $data = (object) $data;
            return $this->response->setJSON($data);
        }
    }

    public function getClaveMunicipio(){
        $condiciones = [
            'estado' => $_POST['estado'],
            'municipio' => $_POST['municipio']
        ];
        $clave_municipio = $this->CuestionariosModel->getAllOneRow('claves_municipios',$condiciones);
        if(!empty($clave_municipio)){
            $data['clave_municipio'] = $clave_municipio['clave_municipio'];
            $condiciones = [
                'clave_estado' => $clave_municipio['clave_estado'],
                'clave_municipio' => $clave_municipio['clave_municipio']
            ];
            $localidades = $this->CuestionariosModel->getAll('localidades',$condiciones);
            $str_options = '<option value="" selected disabled>Seleccione una opción.</option>';
            foreach($localidades as $l){
                $str_options .= '<option value="'.$l['clave_localidad'].'">'.$l['nombre_localidad'].'</option>';
            }
            $data['localidades'] = $str_options;
        }else{
            $data['clave_municipio'] = 'null';
        }
        return json_encode($data);
    }

    public function getInfoCp(){
        $condiciones = ['cp' => $_POST['cp']];
        $info = $this->CuestionariosModel->getAll('codigos_postales',$condiciones);


        $condiciones = ['claveCuerpo' => $_POST['claveCuerpo']];
        $columnas = ['municipio'];
        $ca = $this->ExternalModel->getColumnsOneRow($columnas,'cuerpos_academicos',$condiciones);

        $condiciones = ['id' => $ca['municipio']];
        $municipio_original = $this->ExternalModel->getAllOneRow('municipios',$condiciones);
        $municipio = [];
        array_push($municipio,$municipio_original['nombre']);

        $condiciones = ['claveCuerpo' => $_POST['claveCuerpo']];
        $municipios_extra = $this->ExternalModel->getAll('municipios_ca',$condiciones);

        if(!empty($municipios_extra)){
            foreach($municipios_extra as $me){
                array_push($municipio,$me['nombre_municipio']);
            }
        }

        // Variable para indicar si se encuentra el elemento
        $encontrado = false;

        // Verificar si alguna posición del arreglo 1 existe en el arreglo 2
        foreach ($info as $elemento) {
            if (in_array($elemento['municipio'], $municipio)) {
                $encontrado = true;
                break;
            }
        }

        if(!$encontrado){
            echo 'invalido';
        }else{
            $html = '<option value="" selected disabled>Seleccione una opción</option>';
            foreach($info as $i){
                $val = $i['asentamiento'].' '.$i['nombre_asentamiento'].'. '.$i['municipio'].', '.$i['ciudad'].', '.$i['estado'];
                $html .= '<option value="'.$val.'">'.$val.'</option>';
            }
            $html .= '<option value="otra">Otra opción</option>';
            echo $html;
        }

        
    }

    public function listaInvestigacionEquipo($claveCuerpo,$anio,$pass){

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'password' => $pass];
        
        if(!$this->ExternalModel->exist('cuerpos_academicos',$condiciones)){
            return redirect()->back();
        }
        $columnas = ['redCueCa','nombre'];
        $red = $this->ExternalModel->getColumnsOneRow($columnas,'cuerpos_academicos',$condiciones);
        $tabla = 'cuestionarios_'.strtolower($red['redCueCa']).'_'.$anio;
        $data['uni'] = $red['nombre'];
        $data['nombre_tabla'] = $tabla;
        $data['claveCuerpo'] = $claveCuerpo;
        $data['pass'] = $pass;
        return view('external/librerias/index')
        .view('external/cuestionarios/verEquipo/index',$data)
        .view('external/footer/index');

    }

    public function getListaInvestigacionesEquipo($tabla,$claveCuerpo){

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'folio','nombre_encuestador','estado'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM $tabla";
        $sql_data = "SELECT * FROM $tabla";

        $condicion = "";

        if(!empty($valor_buscado)){
            foreach($columnas as $key => $val){
                if($columnas[$key] == 'id'){
                    #$condicion .= " WHERE ".$val." LIKE '%".$valor_buscado."%'";
                    $condicion .= ' WHERE (claveCuerpo = "'.$claveCuerpo.'") AND ( '.$val." LIKE '%".$valor_buscado."%'";
                }else{
                    $condicion .= " OR ".$val." LIKE '%".$valor_buscado."%'";
                }
            }
        }

        $sql_count = empty($condicion) ? $sql_count.' WHERE claveCuerpo = "'.$claveCuerpo.'"' : $sql_count.$condicion.')';

        $sql_data =  !empty($condicion) ? $sql_data . $condicion.')' : $sql_data.' WHERE claveCuerpo = "'.$claveCuerpo.'"';

        $total_count = $this->db_serv->query($sql_count)->getRow();


        /*
        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();
        */

        $sql_data .= " ORDER BY ".$columnas[$this->request->getGet('order')[0]['column']]." ".$this->request->getGet('order')[0]['dir']." LIMIT ".$this->request->getGet('start').", ".$this->request->getGet('length')."";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        $explode_tabla = explode('_',$tabla);

        foreach($array as $key=>$a){

            $c_nc = 0;

            foreach($a as $key2=>$r){
                $pregunta_solo_num = preg_replace('/[^0-9]/', '', $key2);
                if(ucfirst($explode_tabla[1]) == 'Relayn' && $explode_tabla[2] == 2023){
                    if($pregunta_solo_num >= 9 && $pregunta_solo_num <= 28){
                        if($r == 'nc'){
                            $c_nc++;
                        }
                    }
                }
                if(ucfirst($explode_tabla[1]) == 'Relep' && $explode_tabla[2] == 2023){
                    if($pregunta_solo_num >= 16 && $pregunta_solo_num <= 26){
                        if($r == 'nc'){
                            $c_nc++;
                        }
                    }
                }
            }
            

            $array[$key] = [
                'folio' => $a['folio'],
                'nombre_encuestador' => $a['nombre_encuestador'],
                'items_vacios' => $c_nc
            ];
        }

        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function getExcelEquipo($claveCuerpo,$tabla){

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['id','folio','nombre_encuestador'];
        $getEncuestas = $this->CuestionariosModel->getColumnsAll($columnas,$tabla,$condiciones);

        $headerExcel = ['Folio','Nombre del encuestador','Ítems (NA)'];
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();        
        $sheet->fromArray([$headerExcel], NULL, 'A1');
        $arr_respuestas = [];
        $inicio = 2;
        $explode_tabla = explode('_',$tabla);
        foreach($getEncuestas as $e){
            array_push($arr_respuestas,$e['folio']);
            array_push($arr_respuestas,$e['nombre_encuestador']);
            $c_nc = 0;
            $condiciones = ['id' => $e['id']];
            $encuesta_all = $this->CuestionariosModel->getAllOneRow($tabla,$condiciones);
            foreach($encuesta_all as $key2=>$a){
                $pregunta_solo_num = preg_replace('/[^0-9]/', '', $key2);
                if(ucfirst($explode_tabla[1]) == 'Relayn' && $explode_tabla[2] == 2023){
                    if($pregunta_solo_num >= 9 && $pregunta_solo_num <= 28){
                        if($a == 'nc'){
                            $c_nc++;
                        }
                    }
                }
                if(ucfirst($explode_tabla[1]) == 'Relep' && $explode_tabla[2] == 2023){
                    if($pregunta_solo_num >= 16 && $pregunta_solo_num <= 26){
                        if($a == 'nc'){
                            $c_nc++;
                        }
                    }
                }
            }
            $c_nc = strval($c_nc);
            array_push($arr_respuestas,$c_nc);
            $sheet->fromArray([$arr_respuestas], NULL, 'A'.$inicio);
            $arr_respuestas = [];
            $inicio++;
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$claveCuerpo.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function vistaEditarEncuesta($claveCuerpo,$pass,$id){
        $condiciones = ['claveCuerpo' => $claveCuerpo, 'password' => $pass];
        $ca = $this->ExternalModel->getAllOneRow('cuerpos_academicos',$condiciones);

        if(empty($ca)){
            return redirect()->to(base_url())
            ->with('icon','warning')
            ->with('title','Lo sentimos')
            ->with('text','El enlace no es válido');
        }

        $red = $ca['redCueCa'];

        if($red != 'Relayn'){
            return redirect()->to(base_url())
            ->with('icon','warning')
            ->with('title','Lo sentimos')
            ->with('text','Accion no válida para su red.');
        }

        if(date('Y') != 2023){
            return redirect()->to(base_url())
            ->with('icon','warning')
            ->with('title','Lo sentimos')
            ->with('text','El enlace no es válido.');
        }

        $nombre_tabla = 'cuestionarios_relayn_2023';
        $condiciones = ['id' => $id];
        $cuestionario = $this->CuestionariosModel->getAllOneRow($nombre_tabla,$condiciones);

        if(empty($cuestionario)){
            return redirect()->to(base_url())
            ->with('icon','warning')
            ->with('title','Lo sentimos')
            ->with('text','El enlace no es válido.');
        }

        //OBTENEMOS DATOS DEL CUERPO
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['estado','pais'];
        $cuerpo_aca = $this->ExternalModel->getColumnsOneRow($columnas,'cuerpos_academicos',$condiciones);
        $condiciones = ['id' => $cuerpo_aca['estado']];
        $estado = $this->ExternalModel->getAllOneRow('estados',$condiciones);
        $estado = empty($estado) ? $cuerpo_aca['estado'] : $estado['nombre'];

        if($ca['pais'] == 2){
            $condiciones = ['inciso' => $cuestionario['1b']];
            $columnas = ['nombre'];
            $b1 = $this->CuestionariosModel->getColumnsOneRow($columnas,'tipo_asociaciones',$condiciones);
            #VIALIDADES
            $condiciones = ['id' => $cuestionario['1e']];
            $columnas = ['nombre'];
            $e1 = $this->CuestionariosModel->getColumnsOneRow($columnas,'vialidades',$condiciones);
            #GIRO DE NEGOCIO
            $condiciones = ['inciso' => $cuestionario['1q']];
            $columnas = ['nombre'];
            $q1 = $this->CuestionariosModel->getColumnsOneRow($columnas,'giros',$condiciones);
            #FUNDACION
            $condiciones = ['inciso' => $cuestionario['2b']];
            $columnas = ['nombre'];
            $b2 = $this->CuestionariosModel->getColumnsOneRow($columnas,'fundacion',$condiciones);
            #ESTRATEGIAS
            $condiciones = ['inciso' => $cuestionario['2c']];
            $columnas = ['nombre'];
            $c2 = $this->CuestionariosModel->getColumnsOneRow($columnas,'estrategias',$condiciones);
            #PROBLEMATICAS
            $condiciones = ['inciso' => $cuestionario['2d']];
            $columnas = ['nombre'];
            $d2 = $this->CuestionariosModel->getColumnsOneRow($columnas,'problematicas',$condiciones);
            #CONCENTRACION DE EMPRESA
            $condiciones = ['inciso' => $cuestionario['2e']];
            $columnas = ['nombre'];
            $e2 = $this->CuestionariosModel->getColumnsOneRow($columnas,'concentracion_empresas',$condiciones);
            #PROPIEDAD DE LA EMPRESA
            $condiciones = ['inciso' => $cuestionario['2f']];
            $columnas = ['nombre'];
            $f2 = $this->CuestionariosModel->getColumnsOneRow($columnas,'propiedad_empresa',$condiciones);
            #NIVEL DE ESTUDIOS
            $condiciones = ['inciso' => $cuestionario['7a']];
            $columnas = ['nombre'];
            $a7 = $this->CuestionariosModel->getColumnsOneRow($columnas,'nivel_estudios',$condiciones);
            #PAIS
            $condiciones = ['id' => $cuestionario['7c']];
            $columnas = ['nombre'];
            $c7 = $this->CuestionariosModel->getColumnsOneRow($columnas,'paises',$condiciones);
            #ESTADO CIVIL
            $condiciones = ['inciso' => $cuestionario['7f']];
            $columnas = ['nombre'];
            $f7 = $this->CuestionariosModel->getColumnsOneRow($columnas,'estado_civil',$condiciones);
            #HORAS PROMEDIO
            $condiciones = ['inciso' => $cuestionario['8b']];
            $columnas = ['nombre'];
            $b8 = $this->CuestionariosModel->getColumnsOneRow($columnas,'horas_promedio',$condiciones);

            $condiciones = [];

            $asentamientos = $this->CuestionariosModel->getAll('asentamientos',$condiciones);

            $conglomerados = $this->CuestionariosModel->getAll('conglomerados',$condiciones);

            $pisos = $this->CuestionariosModel->getAll('pisos',$condiciones);

            $vialidades = $this->CuestionariosModel->getAll('vialidades',$condiciones);

            $cuestionario['1b'] = empty($b1['nombre']) ? $cuestionario['1b'] : $b1['nombre'];
            $cuestionario['1e'] = empty($e1['nombre']) ? $cuestionario['1e'] : $e1['nombre'];
            $cuestionario['1q'] = empty($q1['nombre']) ? $cuestionario['1q'] : $q1['nombre'];
            $cuestionario['2b'] = empty($b2['nombre']) ? $cuestionario['2b'] : $b2['nombre'];
            $cuestionario['2c'] = empty($c2['nombre']) ? $cuestionario['2c'] : $c2['nombre'];
            $cuestionario['2d'] = empty($d2['nombre']) ? $cuestionario['2d'] : $d2['nombre'];
            $cuestionario['2e'] = empty($e2['nombre']) ? $cuestionario['2e'] : $e2['nombre'];
            $cuestionario['2f'] = empty($f2['nombre']) ? $cuestionario['2f'] : $f2['nombre'];
            $cuestionario['7a'] = empty($a7['nombre']) ? $cuestionario['7a'] : $a7['nombre'];
            $cuestionario['7c'] = empty($c7['nombre']) ? $cuestionario['7c'] : $c7['nombre'];
            $cuestionario['7f'] = empty($f7['nombre']) ? $cuestionario['7f'] : $f7['nombre'];
            $cuestionario['8b'] = empty($b8['nombre']) ? $cuestionario['8b'] : $b8['nombre'];

            $data['conglomerados'] = $conglomerados;
            $data['asentamientos'] = $asentamientos;
            $data['pisos'] = $pisos;
            $data['vialidades'] = $vialidades;

            $condiciones = ['cp' => $cuestionario['1j']];
            $info = $this->CuestionariosModel->getAll('codigos_postales',$condiciones);
            $html = '<option value="" selected disabled>Seleccione una opción</option>';
            foreach($info as $i){
                $val = $i['asentamiento'].' '.$i['nombre_asentamiento'].'. '.$i['municipio'].', '.$i['ciudad'].', '.$i['estado'];
                $html .= '<option value="'.$val.'">'.$val.'</option>';
            }
            $html .= '<option value="otra">Otra opción</option>';
            $data['info_cp'] = $html;

            $condiciones = ['estado' => $estado];
            $clave_estado = $this->CuestionariosModel->getAllOneRow('claves_municipios',$condiciones);
            $clave_estado = $clave_estado['clave_estado'];
            $data['clave_estado'] = $clave_estado;
            $data['estado'] = $estado;
            $data['pais'] = $cuerpo_aca['pais'];
            $condiciones = [
                'estado' => $estado,
                'municipio' => $cuestionario['1k']
            ];
            $clave_municipio = $this->CuestionariosModel->getAllOneRow('claves_municipios',$condiciones);
            $data['clave_municipio'] = $clave_municipio['clave_municipio'];

            $condiciones = ['clave_estado' => $clave_estado,'clave_municipio' => $clave_municipio['clave_municipio']];
            $localidades = $this->CuestionariosModel->getAll('localidades',$condiciones);
            $data['localidades'] = $localidades;
        }else{
            $condiciones = [];

            $asentamientos = $this->CuestionariosModel->getAll('asentamientos',$condiciones);

            $conglomerados = $this->CuestionariosModel->getAll('conglomerados',$condiciones);

            $pisos = $this->CuestionariosModel->getAll('pisos',$condiciones);

            $vialidades = $this->CuestionariosModel->getAll('vialidades',$condiciones);

            $data['conglomerados'] = $conglomerados;
            $data['asentamientos'] = $asentamientos;
            $data['pisos'] = $pisos;
            $data['vialidades'] = $vialidades;
            $data['estado'] = $estado;
            $data['clave_estado'] = 'No aplica para el país registrado.';
            $data['clave_municipio'] = 'No aplica para el país registrado.';
            $data['info_cp'] = '';
            $data['pais'] = $cuerpo_aca['pais'];
        }

        $condiciones = ['nombre_red' => $red];
        $red = $this->ExternalModel->getAllOneRow('redes',$condiciones);

        

        $data['cuestionario'] = $cuestionario;
        $data['red'] = $red;
        $data['claveCuerpo'] = $claveCuerpo;
        $data['tabla'] = $nombre_tabla;
        

        $ruta = 'usuarios/vistas/encuestas/'.$cuestionario['red'].'/'.$cuestionario['anio'].'/index';
        
        
        return view('external/librerias/index') 
        .view($ruta,$data)
        .view('external/footer/index');
    }

    public function editarEncuesta(){
        $id_actualizar = $_POST['id_actualizar'];
        $tabla = $_POST['tabla'];

        unset($_POST['id_actualizar']);
        unset($_POST['tabla']);
        
        $condiciones = ['id' => $id_actualizar];

        $data = $_POST;

        if(!$this->CuestionariosModel->generalUpdate($tabla,$data,$condiciones)){
            return redirect()->back()
            ->with('icon', 'warning')
            ->with('title', 'Opsss')
            ->with('text', 'Lo sentimos, ha ocurrido un error. Intente mas tarde.');
        }

        return redirect()->back()
        ->with('icon', 'success')
        ->with('title', 'Éxito')
        ->with('text', 'Inforación actualizada correctamente.');
    }


    # ========================== CUESTIONARIOS ===================================

    public function get_id_proyectos(){

        $condiciones = [];
        $pagos = $this->ExternalModel->getAll('pagos',$condiciones);
        foreach($pagos as $m){
            $condiciones = ['concat(nombre," ",redCueCa," ",anio) =' => $m['proyecto']];
            $columnas = ['id'];
            $proyecto = $this->ExternalModel->getColumnsOneRow($columnas,'proyectos',$condiciones);
            if(!empty($proyecto)){
                $data = ['id_proyecto' => $proyecto['id']];
                $condiciones = ['id' => $m['id']];
                $this->ExternalModel->generalUpdate('pagos',$data,$condiciones);
            }
        }
    }

    public function generate_password_ca(){
        $condiciones = [];
        $columnas = ['id'];
        $ca = $this->ExternalModel->getColumnsAll($columnas,'cuerpos_academicos',$condiciones);
        foreach($ca as $c){
            $condiciones = ['id' => $c];
            $data = ['password' => random_int(1,100000000)];
            $this->ExternalModel->generalUpdate('cuerpos_academicos',$data,$condiciones);
        }
    }

    public function removeEntrevistasFiltro(){
        $condiciones = [];
        $columnas = ['id','id_entrevista'];
        $filtro = $this->ExternalModel->getColumnsAll($columnas,'filtro_categorias',$condiciones);

        foreach($filtro as $f){
            $condiciones = ['id' => $f['id_entrevista']];
            
            if(!$this->ExternalModel->exist('entrevistas_Relmo',$condiciones)){
                #No existe la entrevista, la eliminamos del filtro
                $condiciones = ['id' => $f['id']];
                $this->ExternalModel->generalDelete('filtro_categorias',$condiciones);
            }
        }
    }

    public function sortable(){
        return view('external/librerias/index') 
        .view('external/sortable')
        .view('external/footer/index');
    }

    public function getMiembros(){
        $condiciones = ['cuerpoAcademico' => 'MXP-UTQ01'];
        $columnas = ['usuario','especialidad','grado'];
        $miembros = $this->ExternalModel->getColumnsAll($columnas,'miembros',$condiciones);
        foreach($miembros as $m){
            $condiciones = ['usuario' => $m['usuario']];
            $usuario = $this->ExternalModel->getAllOneRow('usuarios',$condiciones);
            $profile_pic = $usuario['profile_pic'] == null ? 'avatar.png' : $usuario['profile_pic'];
            $condiciones = ['id' => $m['grado']];
            $info_grado = $this->ExternalModel->getAllOneRow('grado_academico',$condiciones);
            $str_academico = $info_grado['abreviatura'].' en '.ucfirst($m['especialidad']);
            $data[] = [
                'nombre' => $usuario['nombre'],
                'profile_pic' => $profile_pic,
                'usuario' => $usuario['usuario'],
                'especialidad' => $str_academico
            ];
        }
        return $this->response->setJSON($data);
    }

    public function letsgo(){
        print_r($_POST);
    }

    #=================INFO==========================

    public function info_encuestas($red,$anio){
        #Vamos a mostrar la lista de los equipos de cuestionarios
        $condiciones = [];
        $redes = $this->ExternalModel->getAll('redes', $condiciones);
        if (array_search($red, array_column($redes, 'nombre_red')) === false) {
            #NO EXISTE LA RED
            http_response_code(404);
            exit;
        }

        if($red == 'Releg' && $anio == 2022){
            #sacamos la cabtidad de equipos
            $condiciones = [];
            $columnas = ['claveCuerpo'];
            $cuerpos = $this->ExternalModel->getAllDistinc($columnas, 'entrevistas_Relmo', $condiciones);

            $condiciones = [];
            $c_entrevistas = $this->ExternalModel->count('entrevistas_Relmo',$condiciones);

            $c_filtros = $this->ExternalModel->count('filtro_categorias',$condiciones);



            $data['c_equipos'] = count($cuerpos)-1;
            $data['c_entrevistas'] = $c_entrevistas;
            $data['c_filtros'] = $c_filtros;
            $data['red'] = $red;
            $data['anio'] = $anio;

            return view('external/librerias/index') 
            .view('external/cuestionarios/info_releg_2022',$data)
            .view('external/footer/index');


            exit;
        }

        $tabla = 'cuestionarios_' . strtolower($red) . '_' . $anio;
        $db = db_connect('cuestionarios');
        if (!$db->tableExists($tabla)) {
            #NO EXSTE LA TABLA CON ESE AñO
            http_response_code(404);
            exit;
        }

        $condiciones = [];
        $columnas = ['claveCuerpo'];
        $c_cuerpos = $this->CuestionariosModel->getAllDistinc($columnas, $tabla, $condiciones);
        $c_cuerpos = count($c_cuerpos);

        $condiciones = [];
        $c_encuestas = $this->CuestionariosModel->count($tabla, $condiciones);
        $condiciones = ['estado' => 0];
        $estado_0 = $this->CuestionariosModel->count($tabla, $condiciones);
        $condiciones = ['estado' => 1];
        $estado_1 = $this->CuestionariosModel->count($tabla, $condiciones);
        $condicion = ['estado'=>2];
        $estado_2 = $this->CuestionariosModel->count($tabla,$condicion);
        $condicion = ['estado'=>3];
        $estado_3 = $this->CuestionariosModel->count($tabla,$condicion);
        $condicion = ['estado'=>4];
        $estado_4 = $this->CuestionariosModel->count($tabla,$condicion);
        $condicion = ['estado'=>5];
        $estado_5 = $this->CuestionariosModel->count($tabla,$condicion);

        $data['nombre_tabla'] = $tabla;
        $data['c_cuerpos'] = $c_cuerpos;
        $data['c_encuestas'] = $c_encuestas;
        $data['estado_0'] = $estado_0;
        $data['estado_1']=$estado_1;
        $data['estado_2']=$estado_2;
        $data['estado_3']=$estado_3;
        $data['estado_4']=$estado_4;
        $data['estado_5']=$estado_5;
        $data['red'] = $red;
        $data['anio'] = $anio;

        return view('external/librerias/index') 
        .view('external/cuestionarios/info',$data)
        .view('external/footer/index');
    }

    #=================INFO===================



    #=============DATOS============================

    public function getCountEntrevistas(){
        
        /*
        $condiciones = ['activo' => 1];
        $categorias = $this->ExternalModel->getAll('categorias',$condiciones);

        $condiciones = [];
        $entrevistas = $this->ExternalModel->getAll('entrevistas_Relmo',$condiciones);

        foreach($categorias as $c){
            $c_entrevistas_codigo = 0;
            foreach($entrevistas as $e){

                $condiciones = [
                    'id_entrevista' => $e['id'],
                    'categoria' => $c['id']
                ];
                
                if($this->ExternalModel->exist('filtro_categorias',$condiciones)){
                    $c_entrevistas_codigo++;
                }

            }

            $data[] = [
                'nombre_categoria' => $c['nombre'],
                'c_entrevistas_codigo' => $c_entrevistas_codigo
            ];
        }
        */

        $condiciones = [];
        $capitulos_releg = $this->ExternalModel->getAll('capitulos_releg',$condiciones);


        foreach($capitulos_releg as $c){
            for ($i=1; $i <=5 ; $i++) { 
                $variable = 'categoria_'.$i;

                $info = explode(';',$c[$variable]);

                if($info[0] == 5 || $info[0] == 13){
                    $explode_categorias = explode(',',$info[1]);

                    $condiciones = [
                        'id' => $explode_categorias[1]
                    ];
                    $cev_1 = $this->ExternalModel->getAllOneRow('filtro_categorias',$condiciones);

                    $condiciones = [
                        'id' => $explode_categorias[3]
                    ];
                    $cev_2 = $this->ExternalModel->getAllOneRow('filtro_categorias',$condiciones);

                    $condiciones = ['id' => $info[0]];
                    $categoria = $this->ExternalModel->getAllOneRow('categorias',$condiciones);
                    
                    $data[] = [
                        'id_categoria' => $info[0],
                        'nombre_categoria' => $categoria['nombre'],
                        'claveCuerpo' => $c['claveCuerpo'],
                        'codigos' => [
                            [
                                'id_entrevista' => $explode_categorias[0],
                                'id_cev' => $explode_categorias[1],
                                'cev' => $cev_1['codigo_en_vivo']
                            ],
                            [
                                'id_entrevista' => $explode_categorias[2],
                                'id_cev' => $explode_categorias[3],
                                'cev' => $cev_2['codigo_en_vivo']
                            ]
                        ]
                    ];
                }
            }
        }

        echo json_encode($data);

        echo '<pre>';
        print_r($data);
        echo '</pre>';
        

    }

    #=============DATOS============================
}
