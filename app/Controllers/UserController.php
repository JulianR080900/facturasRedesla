<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\IquatroModel;
use App\Models\CuestionariosModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use PgSql\Lob;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpParser\Node\Expr\Empty_;
use PhpParser\Node\Stmt\Foreach_;
use PHPUnit\Util\Json;
use CodeIgniter\HTTP\Response;
use PhpParser\Node\Stmt\Else_;


use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS\Root;
use TCPDF;
use Smalot\PdfParser\Parser;
use Smalot\PdfParser\Config;

class gafetesCongresos extends TCPDF
{
    //Page header
    public function Header()
    {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = base_url('resources/img/congresos/gafetes/' . session('anio_gafete') . '/' . session('red') . '.png');
        $this->Image($img_file, 0, 0, 100, 140, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        $this->SetMargins(10, 40, 10);
    }
}

class ConstanciasAsistenciaReleg2023 extends TCPDF
{
    //Page header
    public function Header()
    {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = base_url('resources/img/constancias/Asistencia_Releg_2023/' . $_SESSION['folio']);
        $h = 170;
        $w = 220;

        if ($this->Image($img_file, 0, 0, $w, $h, '', '', '', false, 300, '', false, false, 0) === false) {
            $mensaje = "No se ha encontrado la imagen de la menbretada. Ninguna accion realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

        // restore auto-page-break status
        //$this->SetAutoPageBreak($auto_page_break, $bMargin);

        $this->SetMargins(10, 40, 10);
    }
}

class ConstanciasAsistencia extends TCPDF
{
    //Page header
    public function Header()
    {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = base_url('resources/img/constancias/' . $_SESSION['nombre_constancia']);
        $h = 170;
        $w = 220;

        if ($this->Image($img_file, 0, 0, $w, $h, '', '', '', false, 300, '', false, false, 0) === false) {
            $mensaje = "No se ha encontrado la imagen de la menbretada. Ninguna accion realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

        // restore auto-page-break status
        //$this->SetAutoPageBreak($auto_page_break, $bMargin);

        $this->SetMargins(10, 40, 10);
    }
}

class ConstanciasPonente extends TCPDF
{
    public function Header()
    {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = base_url('resources/img/constancias/' . $_SESSION['nombre_constancia']);
        $h = 170;
        $w = 220;

        if ($this->Image($img_file, 0, 0, $w, $h, '', '', '', false, 300, '', false, false, 0) === false) {
            $mensaje = "No se ha encontrado la imagen de la menbretada. Ninguna accion realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

        // restore auto-page-break status
        //$this->SetAutoPageBreak($auto_page_break, $bMargin);
    }
}

class ConstanciasInvestigador extends TCPDF{
    public function Header(){
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->getAutoPageBreak();
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);

        $h = 297;

        $w = 210;
        // set bacground image
        $img_file = base_url('resources/img/constancias/' . $_SESSION['nombre_constancia']);
        if ($this->Image($img_file, 0, 0, $w, $h, '', '', '', false, 300, '', false, false, 0) === false) {
            $mensaje = "No se ha encontrado la imagen de la menbretada. Ninguna accion realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

    }
}

class ConstanciasAsociado extends TCPDF{
    public function Header()
    {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = base_url('resources/img/constancias/' . $_SESSION['nombre_constancia']);
        $h = 170;
        $w = 220;

        if ($this->Image($img_file, 0, 0, $w, $h, '', '', '', false, 300, '', false, false, 0) === false) {
            $mensaje = "No se ha encontrado la imagen de la menbretada. Ninguna accion realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

        // restore auto-page-break status
        //$this->SetAutoPageBreak($auto_page_break, $bMargin);
    }
}

class ConstanciasModerador extends TCPDF
{
    public function Header()
    {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = base_url('resources/img/constancias/' . $_SESSION['nombre_constancia']);
        $h = 170;
        $w = 220;

        if ($this->Image($img_file, 0, 0, $w, $h, '', '', '', false, 300, '', false, false, 0) === false) {
            $mensaje = "No se ha encontrado la imagen de la menbretada. Ninguna accion realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

        // restore auto-page-break status
        //$this->SetAutoPageBreak($auto_page_break, $bMargin);
    }
}

class UserController extends LoginController
{

    public $db_serv;
    public $db_serv_main;
    public $CuestionariosModel;
    public $UserModel;
    public $IquatroModel;



    public function __construct()
    {
        parent::__construct();
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $db = db_connect('iquatro');
        $this->UserModel = new UserModel();
        $this->IquatroModel = new IquatroModel($db);
        $this->CuestionariosModel = new CuestionariosModel();
        $this->db_serv = \Config\Database::connect('cuestionarios');
        $this->db_serv_main = \Config\Database::connect('default');


        /*
        if(session('is_logged') && session('usuario') != '6euto5rSaAElZhqRTkCU'){
            session_destroy();
            return redirect()->to(base_url());
        }
        */
    }

    //===POSIBLEMENTE NO SE USEN===
    public function verifyPostData()
    {

        $form = $_POST;
        foreach ($form as $f) {
            if (trim($f) == "") {
                echo json_encode(true);
                die();
            }
        }
        echo json_encode(false);
    }

    private function pre($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }
    //===================================

    public function cuerpos()
    {
        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }
        if (session('user_type') == 1) {
            return redirect()->to(base_url('/admin/dashboard'));
        }

        return view('librerias/cuerpos')
            . view('usuarios/cuerpos');
    }

    public function getMiembrosCuerpo(){

        $miembros = $this->UserModel->miembros_actuales($_POST['ca']);

        $data["miembros"] = $miembros;

        usort($data['miembros'], function ($a, $b) {
            return $b['lider'] - $a['lider'];
        });

        return json_encode($data['miembros']);
    }

    public function inicio($red, $ca)
    {
        #PREPARA LAS VARIABLES PARA LA VISTA PARA EL CUERPO ACADEMICO QUE SELECCIONO EL USUARIO
        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        #DECLARAMOS LA CLAVE DEL CUERPO Y LA RED
        $_SESSION["CA"] = $ca;

        $_SESSION["red"] = $red;

        #TOMO LOS PAISES (QUIEN SABE CUANDO SE PUEDEN OCUPAR Y APARTE ES UNA HUEVA extraer A CADA RATO XD)
        $condiciones = ['id !=' => 1];

        $paises = $this->UserModel->getAll('pais', $condiciones);


        $_SESSION["a_pais"] = $paises;

        $proyectos = [];

        #TOMAMOS LOS PROYECTOS DE LOS PAGOS

        $condiciones = ['claveCuerpo' => $_SESSION['CA']];

        $pagos =  $this->UserModel->getAll('pagos', $condiciones);

        foreach ($pagos as $pago) {
            $condiciones = ['id' => $pago['id_proyecto']];
            $columnas = ['esquema','anio'];
            $info_proyecto = $this->UserModel->getColumnsOneRow($columnas,'proyectos',$condiciones);

            $proyectos[] = [
                'esquema' => $info_proyecto['esquema'],
                'anio' => $info_proyecto['anio'],
                'proyecto' => $pago['proyecto']
            ];
        }
        
        usort($proyectos, function ($a, $b) {
            $anioA = preg_replace('/[^0-9]/', '', $a['anio']); // Elimina todos los caracteres no numéricos
            $anioB = preg_replace('/[^0-9]/', '', $b['anio']); // Elimina todos los caracteres no numéricos
        
            return intval($anioB) - intval($anioA);
        });
        
        $_SESSION['proyectos'] = $proyectos;

        #TOMAMOS LOS MENSAJES PARA ESE CUERPO ACADEMICO
        $condiciones_mensaje = ['claveCuerpo' => $_SESSION["CA"]];

        $mensajes =  $this->UserModel->getAll("mensajes_CA", $condiciones_mensaje);

        $_SESSION['mensajes_activo'] = $this->getNotiActivo($mensajes);

        foreach($mensajes as $key=>$m){
            $mensaje_nuevo = str_replace('"',"'",$m['mensaje']);
            $mensajes[$key]['mensaje'] = $mensaje_nuevo;
        }

        $_SESSION['mensajes'] = $mensajes;

        $data["mensajes"] = $mensajes;

        $datos_universidad =  $this->UserModel->datos_universidad($_SESSION["CA"]);

        if (!empty($datos_universidad)) {

            #TOMAMOS EL PAIS PARA LA MONEDA
            $_SESSION["pais"] = $datos_universidad["pais"];

            $condiciones = array("cuerpoAcademico" => $_SESSION["CA"], "usuario" => $_SESSION["usuario"]);

            #PARA SABER SI ES EL LIDER O NO
            $lider =  $this->UserModel->getAllOneRow("miembros", $condiciones);

            $_SESSION["lider_ca"] = $lider["lider"];

            return view('usuarios/headers/index', $data)
                . view('usuarios/index', $data)
                . view('usuarios/footers/index');
        } else {
            return redirect()->to(base_url('cuerpos'));
        }
    }

    private function getNotiActivo($mensajes){
        $contador = 0;

        foreach ($mensajes as $elemento) {
            if ($elemento['activo'] == 1) {
                $contador++;
            }
        }
        return $contador;
    }

    public function logout()
    {
        session_destroy();
        return redirect()->to(base_url());
    }

    public function inactivoMensajeCa(){
        $id = $_POST["id"];

        $condiciones_mensaje = ['id' => $id];

        $data = ["activo" => "0"];

        if ($this->UserModel->generalUpdate("mensajes_CA", $data, $condiciones_mensaje)) {

            $condiciones = ['claveCuerpo' => $_SESSION["CA"]];

            $mensajes = $this->UserModel->getAll("mensajes_CA", $condiciones);

            $_SESSION['mensajes'] = $mensajes;
            $_SESSION['mensajes_activo'] = $this->getNotiActivo($mensajes);

            return json_encode(true);
        }else{
            http_response_code(100);
            exit;
        }
    }

    public function validarPass()
    {

        #VALIDA SI PA PASS QUE INGRESO EL USUARIO COINCIDE CON LA DE LA BD

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $bd = $_POST["pass_bd"];

        $act = $_POST["pass_act"];

        if (password_verify($act, $bd)) {

            echo "yes";
        } else {

            echo "no";
        }
    }

    public function actualizarPass()
    {

        #ACTUALIZA LA CONTRASEñA EN LA BD

        #SI NO PASA POR POST O NO TIENE SESION INICIADA NO PASA

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST['conf'])) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->to(base_url('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA']));
            }
        }

        $conf = $_POST["conf"];

        $id_m = $_POST["id_m"];

        $pass = password_hash($conf, PASSWORD_DEFAULT);

        $condiciones = ['id' => $id_m];

        $data = ['password' => $pass];

        if ($this->UserModel->generalUpdate('usuarios', $data, $condiciones) == 1) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function Datos_Generales()
    {

        #PREPARAMOS LOS DATOS PARA LA VISTA DE DATOS GENERALES

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $data = [];

        #CONSULTA ESPECIAL, TIENE SUBCONSULTA

        $datos_universidad = $this->UserModel->datos_universidad($_SESSION["CA"]);

        #NOS TRAEMOS EL LIDEL DEL CUERPO ACADEMICO

        $condiciones = ["cuerpoAcademico" => $_SESSION["CA"], "usuario" => $_SESSION["usuario"]];

        $lider = $this->UserModel->getAllOneRow('miembros', $condiciones);

        $data["datos_universidad"] = $datos_universidad;

        $data["lider"] = $lider["lider"];

        #NOS TRAEMOS LOS MUNICIPIOS EXTRAS O ZONAS DE ESTUDIO EXTRA QUE SE AñADIERON

        $condiciones = ["claveCuerpo" => $_SESSION["CA"]];

        $municipios_ca = $this->UserModel->getAll("municipios_ca", $condiciones);

        $i = 0;

        foreach ($municipios_ca as $m) {

            $data["datos_universidad"]["municipios_ca"][$i] = $m["nombre_municipio"];

            $i++;
        }

        #LOS GRADOS ACADEMICOS PARA PONERLO EN UN SELECT O ALGO ASI

        $condiciones = [];

        $grados_rector = $this->UserModel->getAll('grado_academico', $condiciones);

        $data["grados_rector"] = $grados_rector;

        $condicion = ['id_pais' => $_SESSION['pais']];

        $estados = $this->UserModel->getAll('estados', $condicion);

        $data['estados'] = $estados;

        return view('usuarios/headers/index', $data)
            . view('usuarios/datos_generales', $data)
            . view('usuarios/modales/datos_generales', $data)
            . view('usuarios/footers/index');
    }

    public function generalUpdate($tabla)
    {

        #ACTUALIZA LA INFO A LA BASE DE DATOS DE MANERA GENERAL, CON LA UNICA CONDICION DEL ID

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST['id'])) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->to(base_url('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA']));
            }
        }

        $form = $_POST;

        #PASARA POR UN TERCER FILTRO PARA EVITAR DATOS VACIOS, ESTE LO MANDARA AL INICIO GENERAL
        #NO CREO QUE PASE HASTA ESTE PUNTO PERO POR SI LAS MOSCAS

        foreach ($form as $f) {
            if (trim($f) == "") {
                return redirect()->to(base_url('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA']));
            }
        }

        #TOMAMOS EL ID DEL ARRAY Y HACEMOS LA CONDICION

        $id = $form['id'];

        $condiciones = ['id' => $id];

        #LO ELIMINAMOS DEL ARRAY AL QUE VAMOS A HACER UPDATE

        unset($form['id']);

        #print_r($form);

        #HACEMOS EL UPDATE

        if ($this->UserModel->generalUpdate($tabla, $form, $condiciones)) {
            #EL UPDATE FUNCIONO, HACEMOS REDIRECCIONES

            switch ($tabla) {
                case 'miembros':
                    return redirect()->to(base_url('Miembros'))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
                case 'cuerpos_academicos':
                    return redirect()->to(base_url('Datos_Generales'))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
                case 'usuarios':
                    return redirect()->to(base_url('perfil'))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
                default:
                    return redirect()->back()
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
            }
        } else {

            #OCURRIO UN ERROR AL HACER UPDATE, PA ATRAS

            return redirect()->to(base_url('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA']))
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
        }
    }

    public function generalDelete($tabla)
    {

        #ACTUALIZA LA INFO A LA BASE DE DATOS DE MANERA GENERAL, CON LA UNICA CONDICION DEL ID

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST['id'])) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->to(base_url('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA']));
            }
        }

        $form = $_POST;

        #TOMAMOS EL ID DEL ARRAY Y HACEMOS LA CONDICION

        $id = $form['id'];

        $condiciones = ['id' => $id];

        #HACEMOS EL UPDATE

        if ($this->UserModel->generalDelete($tabla, $condiciones)) {
            #EL UPDATE FUNCIONO, HACEMOS REDIRECCIONES

            $response['status'] = 'success';

            $response['message'] = 'Entrevista eliminada correctamente';
        } else {

            #OCURRIO UN ERROR AL HACER UPDATE, PA ATRAS
            $response['status'] = 'error';

            $response['message'] = 'No se puede eliminar la entrevista';
        }

        echo json_encode($response);
    }

    public function Miembros()
    {

        #SE PREPARAN LOS DATOS PARA LA VISTA DE MIEMBROS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $miembros = $this->UserModel->miembros_actuales(session('CA'));

        $data["miembros"] = $miembros;

        usort($data['miembros'], function ($a, $b) {
            return $b['lider'] - $a['lider'];
        });

        return view('usuarios/headers/index', $data)
            . view('usuarios/miembros', $data)
            . view('usuarios/footers/index');
    }

    public function editarMiembro()
    {

        #MODULO PARA EDITAR UN MIEMBRO EN EL APARTADO DEL USUARIO

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST['id_miembro'])) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->to(base_url('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA']));
            }
        }

        $data = $_POST;

        $condiciones = array(

            "id" => $data["id_miembro"]

        );

        $res = $this->UserModel->getAll("miembros", $condiciones);

        $data["miembro"] = $res;

        $condiciones = [];

        $grados_academicos = $this->UserModel->getAll('grado_academico', $condiciones);

        $data['grados_academicos'] = $grados_academicos;

        return view('usuarios/headers/index', $data)
            . view('usuarios/edits/miembro', $data)
            . view('usuarios/footers/index');

        //$this->load->view("edits/editar_miembro",$data);

    }

    public function perfil()
    {

        #PREPARA LA VISTA PARA VISUALIZARLA, AQUI SE MUESTRA LA TARJETA DE PRESENTACION
        #ADEMAS DE LAS CONSTANCIAS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $condiciones = ['usuario' => $_SESSION['usuario']];

        $columnas = [];

        array_push($columnas, 'id');
        array_push($columnas, 'nombre');
        array_push($columnas, 'ap_paterno');
        array_push($columnas, 'ap_materno');
        array_push($columnas, 'correo');
        array_push($columnas, 'correo_institucional');
        array_push($columnas, 'profile_pic');

        $usuario = $this->UserModel->getColumnsOneRow($columnas, "usuarios", $condiciones);

        $tabla_a_consultar = "constancia_" . $_SESSION["red"];

        $condiciones = [
            'usuario' => session('usuario'),
            'redCueAca' => session('CA')
        ];

        $constancias = $this->UserModel->getAll($tabla_a_consultar, $condiciones);

        #VAMOS A BUSCAR EN MODERADORES

        $condiciones = ['usuario' => $_SESSION['usuario'], 'red' => $_SESSION['red']];
        $constancias_moderadores = $this->UserModel->getAll('constancia_moderadores', $condiciones);

        $constancias = array_merge($constancias,$constancias_moderadores);

        #TOMAMOS EL GRADO ACADEMICO DEL USUARIO

        $condiciones = ['usuario' => $_SESSION['usuario']];

        $columnas = [];
        array_push($columnas, 'grado');
        array_push($columnas, 'especialidad');
        array_push($columnas, 'telefono');
        array_push($columnas, 'grado');

        $miembro = $this->UserModel->getColumnsOneRow($columnas, "miembros", $condiciones);

        $condiciones = ['id' => $miembro['grado']];

        $grado = $this->UserModel->getAllOneRow("grado_academico", $condiciones);

        $usuario['grado_academico'] = $grado['nombre'];

        $usuario['especialidad'] = $miembro['especialidad'];

        $usuario['telefono'] = $miembro['telefono'];

        $columnas = [];

        array_push($columnas, 'nombre');

        $condiciones = ['id' => $miembro['grado']];

        $nombre_ga = $this->UserModel->getColumnsOneRow($columnas, "grado_academico", $condiciones);

        $usuario['grado_academico'] = $nombre_ga['nombre'];

        if (empty($usuario['ap_materno'] || $usuario['ap_materno'] == "" || $usuario['ap_materno'] === null)) {

            $nombre_completo = $usuario['nombre'] . ' ' . $usuario['ap_paterno'];
        } else {

            $nombre_completo = $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
        }

        $usuario['nombre_completo'] = $nombre_completo;

        $data["usuario"] = $usuario;

        //$data['constancias_moderadores'] = $constancias_moderadores;

        $fullname_red = '';

        $columnas = [];

        array_push($columnas, 'significado');

        $condiciones = ['nombre_red' => $_SESSION['red']];

        $nombre_red = $this->UserModel->getColumnsOneRow($columnas, "redes", $condiciones);

        $fullname_red = !empty($nombre_red) ?  $nombre_red['significado'] : 'No registrado';

        $data['fullname_red'] = $fullname_red;
        
        usort($constancias, array($this, 'ordenarPorAnio'));

        $constancias_format = [];

        foreach($constancias as $key=>$c){
            $constancias_format[$c['anio']][] = $c;
        }

        //VAMOS A ESTABLECER LAS CONSTANCIAS DE ENCUESTADORES TAMBIEN DENTRO DE

        $constancias_encuestadores = [
            'Relayn' => [
                2023,2024
            ],
            'Relep' => [
                'anio' => '2023',
            ],
            'Relen' => [
                'anio' => '2023',
            ]
        ];

        foreach($constancias_encuestadores as $key => $c){
            if($key == session('red')){
                foreach($c as $val){
                    if( isset($constancias_format[$val] ) ){
                        //La constancia existe y la insertamos
                        $constancias_format[$val][] = [
                            'tipo_constancia' => 'Encuestador',
                            'red' => session('red'),
                            'anio' => $val,
                            'path' => '/encuestadores'
                        ];
                    }
                }
            }
        }

        /* echo '<pre>';
        print_r($constancias_format);
        echo '</pre>';
        exit; */

        $data["constancias"] = $constancias_format;

        

        return view('usuarios/headers/index', $data)
            . view('usuarios/perfil', $data)
            . view('usuarios/footers/index');
    }

    function ordenarPorAnio($a, $b) {
        // Comprobar si $a contiene "_2022" y $b no lo contiene
        if (strpos($a['anio'], '2021_2022') !== false && strpos($b['anio'], '2021_2022') === false) {
            return 1; // Mover $a al final
        }
        // Comprobar si $b contiene "_2022" y $a no lo contiene
        if (strpos($b['anio'], '2021_2022') !== false && strpos($a['anio'], '2021_2022') === false) {
            return -1; // Mover $b al final
        }
        // Si ninguno de los dos contiene "_2022" o ambos lo contienen, ordenar normalmente
        return $b['anio'] - $a['anio'];
    }

    public function editarPerfil()
    {

        #EDITA EL APARTADO DE PERFIL, NO HAY POST PORQUE TOMAMOS EL USUARIO
        #POR ESO VALIDAMOS SOLAMENTE LA SESION

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $condiciones = ['usuario' => $_SESSION['usuario']];

        $usuario = $this->UserModel->getAllOneRow("usuarios", $condiciones);

        $condiciones = [];

        $grados_academicos = $this->UserModel->getAll('grado_academico', $condiciones);

        $data['usuario'] = $usuario;

        $data['grados_academicos'] = $grados_academicos;

        return view('usuarios/headers/index', $data)
            . view('usuarios/edits/perfil', $data)
            . view('usuarios/footers/index');
    }

    public function actualizarPerfil(){
        $data = $_POST;
        $file = $_FILES;

        $columnas = ['password'];
        $condiciones = ['usuario' => session('usuario')];

        $usuario = $this->UserModel->getColumnsOneRow($columnas,'usuarios',$condiciones);

        $dataUpdate = [];

        isset($data['nombre']) ? $dataUpdate['nombre'] = $data['nombre'] : '';
        isset($data['ap_paterno']) ? $dataUpdate['ap_paterno'] = $data['ap_paterno'] : '';
        isset($data['ap_materno']) ? $dataUpdate['ap_materno'] = $data['ap_materno'] : '';
        isset($data['correo']) ? $dataUpdate['correo'] = $data['correo'] : '';
        isset($data['correo_institucional']) ? $dataUpdate['correo_institucional'] = $data['correo_institucional'] : '';

        //VAMOS A HACER LAS CONFICIONES DE LA CONTRASEñA
        if($data['act_password'] != ''){
            
            $act_pass = $data['act_password'];

            if(!password_verify($act_pass,$usuario['password'] )){
                return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Cuidado')
                ->with('text', 'La contraseña actual no coincide.');
            }

            if(strlen($data['password']) < 8){
                return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Cuidado')
                ->with('text', 'La contraseña debe tener mínimo 8 carácteres.');
            }
    
            if($data['password'] != $data['conf_password']){
                return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Cuidado')
                ->with('text', 'Las contraseñas no coinciden.');
            }

            $dataUpdate['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        }

        $condicionesUpdate = [
            'id' => $data['id']
        ];

        if($file['profile_pic']['size'] > 0){

            if ($imgFile = $this->request->getFile('profile_pic')) {
                if ($imgFile->isValid() && !$imgFile->hasMoved()) {
                    $validated = $this->validate([
                        'profile_pic' => [
                            'uploaded[profile_pic]',
                            'mime_in[profile_pic,image/png,image/jpeg,image/jpg]',
                            'max_size[profile_pic,2000]'
                        ]
                    ]);
    
                    if ($validated) {
                        $nombre = $imgFile->getRandomName();
                        $ruta = ROOTPATH.'resources/img/profiles';
                        $ruta_completo = "$ruta/$nombre";
                        $databaseProfileName = "$nombre";
    
                        if (file_exists($ruta_completo)) {
                            // Eliminar el archivo existente
                            unlink($ruta_completo);
                        }

    
                        if (!$imgFile->move($ruta,$databaseProfileName)) {
                            return redirect()->back()
                            ->with('icon', 'warning')
                            ->with('title', 'Lo sentimos')
                            ->with('text', 'No se ha podido subir el archivo, contacte a sistemas.');
                        }
                    } else {
                        return redirect()->back()
                        ->with('icon', 'warning')
                        ->with('title', 'Lo sentimos')
                        ->with('text', 'La foto de perfil debe pesar menos de 2MB y debe ser un archivo PNG, JPEG O JPG.');
                    }
                } else {
                    return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error con el archivo. Cambie el archivo y si persiste el problema, contacte a sistemas.');
                }
            }
            
            $dataUpdate['profile_pic'] = $databaseProfileName;
            $_SESSION['profile_pic'] = $databaseProfileName;

        }

        $this->UserModel->generalUpdate('usuarios',$dataUpdate,$condicionesUpdate);

        return redirect()->to(base_url('perfil/inicio'))
        ->with('icon', 'success')
        ->with('title', 'Listo')
        ->with('text', 'Información actualizada correctamente.');
    }

    public function constancia($tipo, $red, $anio, $folio)
    {

        #EN ESTA FUNCION VAMOS A MOSTRAR UN PDF CON LA CONSTANCIA QUE SE LE ASIGNE AL USUARIO.
        #LA CONSTANCIA SE PUEDE OTORGAR PERO NECESITAS LAS IMAGENES PARA BRINDARSELAS, SE HACE
        #UN FILTRO ANTES DE, PERO AQUI TAMBIEN LO HACEMOS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }


        $nombre_constancia = $tipo . '_' . $red . '_' . $anio;

        #VERIFICAMOS LA RUTA DEL ARCHIVO QUE DESEAMOS, SI NO EXISTE, LA URL ESTA MAL O SIMPLEMENTE NO EXISTE EL ARCHIVO
        #CUALQUIERA DE LAS 2 ES VALIDA

        $path = 'resources/img/constancias/' . $nombre_constancia . '.jpg';

        if (!file_exists($path)) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url('/perfil'))
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'La dirección a la que intenta ingresar aún no es válida o es incorrecta. Intente mas tarde.');
            }
        }

        #EL ARCHIVO EXISTE, MAS NO SABEMOS SI EN REALIDAD LA URL SOLAMENTE LE ATINO, SABEN JAJAJAJA, HAY QUE VERIFICAR QUE SI
        #SEA DEL USUARIO

        $condiciones = ['usuario' => $_SESSION['usuario'], 'tipo_constancia' => $tipo, 'anio' => $anio, 'folio' => $folio];

        if (!$this->UserModel->exist('constancia_' . $red, $condiciones)) {
            #EXISTE LA CONSTANCIA PERO NO LE PERTENECE AL USUARIO, LO MANDAMOS PARA ATRAS
            #NO LE VAMOS A DECIR AL USUARIO EN QUE ESTA MAL, EL MENSAJE ES UNO GENERALIZADO, UN ERROR, PERO NOSOTROS SABEMOS QUE ES
            # JIJIJIJIJIJIJIJIJIJIJIJ
            return redirect()->to(base_url('/perfil'))
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intente mas tarde');
        }

        //OBTENEMOS EL NOMBRE COMPLETO DEL USUARIO
        $condiciones = ['folio' => $folio];

        $constancia = $this->UserModel->getAllOneRow('constancia_' . $red, $condiciones);

        if (!empty($constancia)) {
            $nombre_usuario = $constancia['nombre'];
        } else {
            #NO EXISTE EL USUARIO, BRO🧐
            return redirect()->to(base_url('/perfil'))
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intente mas tarde');
        }

        $link_relayn = 'https://www.relayn.org/';
        $link_relen = 'https://www.relen.la/';
        $link_relep = 'https://www.relep.org/';
        $link_releem = 'https://www.releem.org/';
        $link_relmo = 'https://www.relmo.org/';
        $link_releg = 'https://www.relmo.org/';
        $link_iquatro = 'https://iquatroeditores.com/revista/index.php/iquatro/about';

        switch ($red) {
            case 'Relayn':
                $link_red = $link_relayn;
                break;
            case 'Relen':
                $link_red = $link_relen;
                break;
            case 'Relep':
                $link_red = $link_relep;
                break;
            case 'Releem':
                $link_red = $link_releem;
                break;
            case 'Releg':
                $link_red = $link_relmo;
                break;
        }



        #AQUI SE HACE PARA CADA UNA DE LAS CONTANCIAS, YA QUE CADA AñO Y CADA TIPO DE CONSTANCIA SON DIFERENTES
        #HAZ SWITCH PARA EL TIPO Y PARA EL AñO PARA SABER QUE IMAGEN PONER Y TAMBIEN CONDICIONAR LOS SALTOS
        #USA LN PARA SALTOS DE LINEA NO HAGAS SALTOS DE LINEA CON MULTICELL PORFA JAJAJAJA, FUE UN PEDOTE
        #NO HACEMOS CONDICION POR RED PORQUE LA IMAGEN USA LAS MISMAS MEDIDAS PARA TODAS LAS REDES.

        $pdf = new TCPDF();

        $pdf->setPrintHeader(false);

        $html = "<b>$nombre_usuario</b>";

        function background($pdf, $w, $h, $nombre_constancia)
        {
            // get the current page break margin
            $bMargin = $pdf->getBreakMargin();
            // get current auto-page-break mode
            $auto_page_break = $pdf->getAutoPageBreak();
            // disable auto-page-break
            $pdf->SetAutoPageBreak(false, 0);
            // set bacground image
            $img_file = base_url('resources/img/constancias/' . $nombre_constancia . '.jpg');
            $pdf->Image($img_file, 0, 0, $h, $w, '', '', '', false, 300, '', false, false, 0);
            // restore auto-page-break status
            $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
            // set the starting point for the page content
            $pdf->setPageMark();
        }

        if ($anio >= 2023) {

            if ($tipo == 'Asistencia') {
                $_SESSION['nombre_constancia'] = 'Asistencia_' . ucfirst($red) . '_' . $anio . '.jpg';
                //$pdf = new ConstanciasAsistencia();
            } else if ($tipo == 'Ponente') {
                $_SESSION['nombre_constancia'] = 'Ponente_' . ucfirst($red) . '_' . $anio . '.jpg';
                //$pdf = new ConstanciasPonente();
            } else if ($tipo == 'Miembro_asociado') {
                $_SESSION['nombre_constancia'] = 'Miembro_asociado_' . ucfirst($red) . '_' . $anio . '.jpg';
                //$pdf = new ConstanciasPonente();
            } else if ($tipo == 'Miembro_investigador') {
                $_SESSION['nombre_constancia'] = 'Miembro_investigador_' . ucfirst($red) . '_' . $anio . '.jpg';
                //$pdf = new ConstanciasPonente();
            } else {
                http_response_code(500);
                exit;
            }

            $pdf->SetPrintHeader(true);

            $pdf->SetPrintFooter(false);

            $pdf->SetAutoPageBreak(true, 35);

            $pdf->SetAuthor('REDESLA');

            $pdf->SetCreator('REDESLA');

            $pdf->SetTitle("Constancia");

            if ($red == 'Releg' && $tipo == 'Asistencia') {
                $_SESSION['folio'] = $constancia['folio_completo'] . '.jpg';
                $pdf = new ConstanciasAsistenciaReleg2023();


                $h = 170;
                $w = 220;
                $pdf->AddPage('L', [$h, $w]);

                #================HYPERVINCULO====================

                $x = 7;  // Posición X
                $y = 160;  // Posición Y
                $width = 69;  // Ancho del área
                $height = 8;  // Alto del área

                $pdf->SetXY($x, $y);

                $pdf->SetTextColor(101, 113, 124);

                $url = 'https://redesla.la/';
                $pdf->SetAlpha(0.0);
                $pdf->Rect($x, $y, $width, $height, 'F');
                $pdf->Link($x, $y, $width, $height, $url);

                #================HYPERVINCULO====================

            } else if ($red == 'Releg' && $tipo == 'Ponente') {
                $pdf = new ConstanciasPonente();
                $h = 170;
                $w = 220;
                $pdf->AddPage('L', [$h, $w]);


                #================NOMBRE====================
                $x = 30;  // Posición X
                $y = 56;  // Posición Y
                $width = 165;  // Ancho del área
                $height = 12;  // Alto del área

                #AUTOSIZE FONT

                $texto = $constancia['nombre']; // Texto a mostrar

                // Obtener el ancho del texto con la fuente y el tamaño actual
                $textWidth = $pdf->GetStringWidth($texto);
                $fontSize = 16;
                $fontFamily = 'gothicb';
                $pdf->SetFont($fontFamily, '', $fontSize, '', false);

                // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
                while ($textWidth > $width) {
                    $fontSize -= 0.5; // Reducir el tamaño de fuente
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $textWidth = $pdf->GetStringWidth($texto);
                }



                // Establecer el área de texto
                $pdf->SetXY($x, $y);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

                #================NOMBRE====================

                #================PONENCIA====================
                $x = 30;  // Posición X
                $y = 80;  // Posición Y
                $width = 165;  // Ancho del área
                $height = 20;  // Alto del área

                #AUTOSIZE FONT

                $condiciones = [
                    'submission_id' => $constancia['submission_id']
                ];
                $columnas = ['nombre'];

                $ponencia = $this->UserModel->getColumnsOneRow($columnas, 'ponencias', $condiciones);

                if (empty($ponencia)) {
                    http_response_code(501);
                }

                $texto = $ponencia['nombre']; // Texto a mostrar

                // Obtener el ancho del texto con la fuente y el tamaño actual
                $textWidth = $pdf->GetStringWidth($texto);
                $fontSize = 12;
                $fontFamily = 'gothicb';
                $pdf->SetFont($fontFamily, '', $fontSize, '', false);

                // Establecer el área de texto
                $pdf->SetXY($x, $y);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

                #================PONENCIA====================

                #================FOLIO====================
                $x = 187;  // Posición X
                $y = 157;  // Posición Y
                $width = 25;  // Ancho del área
                $height = 6;  // Alto del área

                #AUTOSIZE FONT

                if ($constancia['folio_completo'] == '') {
                    $dataUpdate = [
                        'folio_completo' => $constancia['folio'] . 'PO-' . ucfirst($_SESSION['red']) . '-' . $constancia['anio']
                    ];
                    $condiciones = ['id' => $constancia['id']];

                    $this->UserModel->generalUpdate('constancia_' . $red, $dataUpdate, $condiciones);

                    $condiciones = ['folio' => $folio];

                    $constancia = $this->UserModel->getAllOneRow('constancia_' . $red, $condiciones);
                }

                $texto = $constancia['folio_completo']; // Texto a mostrar

                // Obtener el ancho del texto con la fuente y el tamaño actual
                $textWidth = $pdf->GetStringWidth($texto);
                $fontSize = 6;
                $fontFamily = 'century_gothic';
                $pdf->SetFont($fontFamily, '', $fontSize, '', false);

                // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
                while ($textWidth > $width) {
                    $fontSize -= 1; // Reducir el tamaño de fuente
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $textWidth = $pdf->GetStringWidth($texto);
                }



                // Establecer el área de texto
                $pdf->SetXY($x, $y);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

                #================FOLIO====================

                #================HYPERVINCULO====================

                $x = 4;  // Posición X
                $y = 160;  // Posición Y
                $width = 123;  // Ancho del área
                $height = 8;  // Alto del área

                $pdf->SetXY($x, $y);
                // Obtener el ancho del texto con la fuente y el tamaño actual
                $textWidth = $pdf->GetStringWidth($texto);
                $fontSize = 10;
                $fontFamily = 'century_gothic';

                $pdf->SetFont($fontFamily, '', $fontSize, '', false);

                // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
                while ($textWidth > $width) {
                    $fontSize -= 1; // Reducir el tamaño de fuente
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $textWidth = $pdf->GetStringWidth($texto);
                }

                $pdf->SetTextColor(101, 113, 124);

                $url = 'https://redesla.la/';
                $pdf->SetAlpha(0.0);
                $pdf->Rect($x, $y, $width, $height, 'F');
                $pdf->Link($x, $y, $width, $height, $url);

                #================HYPERVINCULO====================

            } else if ($red == 'Releg' && $tipo == 'Miembro_asociado') {
                $pdf = new ConstanciasAsociado();
                $h = 170;
                $w = 220;
                $pdf->AddPage('L', [$h, $w]);

                #================NOMBRE====================
                $x = 30;  // Posición X
                $y = 56;  // Posición Y
                $width = 165;  // Ancho del área
                $height = 12;  // Alto del área

                #AUTOSIZE FONT

                $texto = $constancia['nombre']; // Texto a mostrar

                // Obtener el ancho del texto con la fuente y el tamaño actual
                $textWidth = $pdf->GetStringWidth($texto);
                $fontSize = 16;
                $fontFamily = 'gothicb';
                $pdf->SetFont($fontFamily, '', $fontSize, '', false);

                // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
                while ($textWidth > $width) {
                    $fontSize -= 0.5; // Reducir el tamaño de fuente
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $textWidth = $pdf->GetStringWidth($texto);
                }



                // Establecer el área de texto
                $pdf->SetXY($x, $y);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

                #================NOMBRE====================

                #================FOLIO====================
                $x = 187;  // Posición X
                $y = 157;  // Posición Y
                $width = 25;  // Ancho del área
                $height = 6;  // Alto del área

                #AUTOSIZE FONT

                if ($constancia['folio_completo'] == '') {
                    $dataUpdate = [
                        'folio_completo' => $constancia['folio'] . 'MA-' . ucfirst($_SESSION['red']) . '-' . $constancia['anio']
                    ];
                    $condiciones = ['id' => $constancia['id']];

                    $this->UserModel->generalUpdate('constancia_' . $red, $dataUpdate, $condiciones);

                    $condiciones = ['folio' => $folio];

                    $constancia = $this->UserModel->getAllOneRow('constancia_' . $red, $condiciones);
                }

                $texto = $constancia['folio_completo']; // Texto a mostrar

                // Obtener el ancho del texto con la fuente y el tamaño actual
                $textWidth = $pdf->GetStringWidth($texto);
                $fontSize = 6;
                $fontFamily = 'century_gothic';
                $pdf->SetFont($fontFamily, '', $fontSize, '', false);

                // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
                while ($textWidth > $width) {
                    $fontSize -= 1; // Reducir el tamaño de fuente
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $textWidth = $pdf->GetStringWidth($texto);
                }



                // Establecer el área de texto
                $pdf->SetXY($x, $y);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

                #================FOLIO====================


                #================HYPERVINCULO====================

                $x = 3;  // Posición X
                $y = 160;  // Posición Y
                $width = 125;  // Ancho del área
                $height = 8;  // Alto del área

                $pdf->SetXY($x, $y);

                $pdf->SetTextColor(101, 113, 124);

                $url = 'https://redesla.la/';
                $pdf->SetAlpha(0.0);
                $pdf->Rect($x, $y, $width, $height, 'F');
                $pdf->Link($x, $y, $width, $height, $url);

                #================HYPERVINCULO====================



                #================HYPERVINCULO====================

            } else if ($tipo == 'Miembro_investigador') {
                $pdf = new ConstanciasInvestigador();
                $pdf->AddPage('P');

                #================NOMBRE====================
                $x = 25;  // Posición X
                $y = 78;  // Posición Y
                $width = 165;  // Ancho del área
                $height = 12;  // Alto del área

                #AUTOSIZE FONT

                $texto = $constancia['nombre']; // Texto a mostrar

                // Obtener el ancho del texto con la fuente y el tamaño actual
                $textWidth = $pdf->GetStringWidth($texto);
                $fontSize = 20;
                $fontFamily = 'gothicb';
                $pdf->SetFont($fontFamily, '', $fontSize, '', false);

                // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
                while ($textWidth > $width) {
                    $fontSize -= 0.5; // Reducir el tamaño de fuente
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $textWidth = $pdf->GetStringWidth($texto);
                }



                // Establecer el área de texto
                $pdf->SetXY($x, $y);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

                #================NOMBRE====================

                #================FOLIO====================
                $x = 10;  // Posición X
                $y = 0;  // Posición Y
                $width = 25;  // Ancho del área
                $height = 6;  // Alto del área

                #AUTOSIZE FONT

                if ($constancia['folio_completo'] == '') {
                    $dataUpdate = [
                        'folio_completo' => $constancia['folio'] . 'MA-' . ucfirst($_SESSION['red']) . '-' . $constancia['anio']
                    ];
                    $condiciones = ['id' => $constancia['id']];

                    $this->UserModel->generalUpdate('constancia_' . $red, $dataUpdate, $condiciones);

                    $condiciones = ['folio' => $folio];

                    $constancia = $this->UserModel->getAllOneRow('constancia_' . $red, $condiciones);
                }

                $texto = $constancia['folio_completo']; // Texto a mostrar

                // Obtener el ancho del texto con la fuente y el tamaño actual
                $textWidth = $pdf->GetStringWidth($texto);
                $fontSize = 6;
                $fontFamily = 'century_gothic';
                $pdf->SetFont($fontFamily, '', $fontSize, '', false);

                // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
                while ($textWidth > $width) {
                    $fontSize -= 1; // Reducir el tamaño de fuente
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $textWidth = $pdf->GetStringWidth($texto);
                }



                // Establecer el área de texto
                $pdf->SetXY($x, $y);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

                #================FOLIO====================


                #================HYPERVINCULO====================

                $x = 90;  // Posición X
                $y = 290;  // Posición Y
                $width = 125;  // Ancho del área
                $height = 8;  // Alto del área

                $pdf->SetXY($x, $y);

                $pdf->SetTextColor(101, 113, 124);

                $url = 'https://redesla.la/';
                $pdf->SetAlpha(0.0);
                $pdf->Rect($x, $y, $width, $height, 'F');
                $pdf->Link($x, $y, $width, $height, $url);

                #================HYPERVINCULO====================



                #================HYPERVINCULO====================

            } else {
                http_response_code(500);
                exit;
            }

            unset($_SESSION['nombre_constancia']);

            $this->response->setContentType('application/pdf');

            $pdf->Output($nombre_constancia . "_" . utf8_decode($nombre_usuario) . ".pdf", 'I');
            exit;
        }

        switch ($tipo) {

            case 'Miembro_investigador':

                $abreviacion = "MI";

                $h = 225;

                $w = 350;

                $pdf->AddPage('P', [$h, $w]);

                switch ($anio) {
                    case '2021_2022':
                        background($pdf, $w, $h, $nombre_constancia);
                        $pdf->SetFont('times', 'I', 8);
                        $folio_completo = $folio . "$abreviacion-" . $red . "-" . $anio;
                        $pdf->writeHTML($folio_completo, true, true, false, false, 'L');
                        $pdf->SetFont('times', 'I', 24);
                        $pdf->Ln(81);
                        $pdf->writeHTML($html, true, true, false, false, 'C');
                        break;
                    case 2019:
                        background($pdf, $w, $h, $nombre_constancia);
                        $pdf->SetFont('times', 'I', 8);
                        $folio_completo = $folio . "$abreviacion-" . $red . "-" . $anio;
                        $pdf->writeHTML($folio_completo, true, true, false, false, 'R');
                        $pdf->SetFont('times', 'I', 24);
                        $pdf->Ln(108);
                        $pdf->writeHTML($html, true, true, false, false, 'C');
                        break;
                    case 2022:
                        background($pdf, $w, $h, $nombre_constancia);
                        $pdf->SetFont('times', 'I', 8);
                        $folio_completo = $folio . "$abreviacion-" . $red . "-" . $anio;
                        $pdf->writeHTML($folio_completo, true, true, false, false, 'L');
                        #EL METODO MAS CUTRE QUE VERAS PARA METER UN ENLACE JAJAJAJAJAJ
                        $pdf->SetFont('times', 'I', 80);
                        $pdf->SetAlpha(0);
                        $pdf->MultiCell(100, 40, '<a href="' . $link_red . '" target="_blank">---------</a>', 0, 'C', 0, 0, '60', '10', true, 0, true, true, 40, 'M');
                        $pdf->SetAlpha(1);
                        $pdf->SetFont('times', 'I', 24);
                        $pdf->Ln(83);
                        $pdf->writeHTML($html, true, true, false, false, 'C');
                        break;
                    case 2023:
                        background($pdf, $w, $h, $nombre_constancia);
                        $pdf->SetFont('times', 'I', 8);
                        $folio_completo = $folio . "$abreviacion-" . $red . "-" . $anio;
                        $pdf->writeHTML($folio_completo, true, true, false, false, 'L');
                        #EL METODO MAS CUTRE QUE VERAS PARA METER UN ENLACE JAJAJAJAJAJ
                        $pdf->SetFont('times', 'I', 80);
                        $pdf->SetAlpha(0);
                        $pdf->MultiCell(100, 40, '<a href="' . $link_red . '" target="_blank">---------</a>', 0, 'C', 0, 0, '60', '10', true, 0, true, true, 40, 'M');
                        $pdf->SetAlpha(1);
                        $pdf->SetFont('times', 'I', 24);
                        $pdf->Ln(83);
                        $pdf->writeHTML($html, true, true, false, false, 'C');
                        break;
                }

                break;

            case 'Asistencia':

                $abreviacion = "PA";

                $h = 330;

                $w = 255;

                $pdf->AddPage('L', [$h, $w]);

                switch ($anio) {
                    case 2022:
                        background($pdf, $w, $h, $nombre_constancia);
                        $pdf->SetFont('times', 'I', 8);
                        $folio_completo = $folio . "$abreviacion-" . $red . "-" . $anio;
                        $pdf->writeHTML($folio_completo, true, true, false, false, 'R');
                        $pdf->SetFont('times', 'I', 24);
                        $pdf->Ln(85);
                        $pdf->writeHTML($html, true, true, false, false, 'C');
                        $pdf->SetFont('times', 'B', 24);
                        if ($red != 'Relayn') {
                            $pdf->setXY(205, 165);
                            $pdf->writeHTML($constancia['porcentaje'], true, true, false, false, '');
                        }

                        break;
                }

                break;

            case 'Ponente':

                $abreviacion = "PO";

                $h = 330;

                $w = 255;

                $pdf->AddPage('L', [$h, $w]);

                switch ($anio) {
                    case 2022:
                        background($pdf, $w, $h, $nombre_constancia);
                        $pdf->SetFont('times', 'I', 8);
                        $folio_completo = $folio . "$abreviacion-" . $red . "-" . $anio;
                        $pdf->writeHTML($folio_completo, true, true, false, false, 'R');
                        $pdf->SetFont('times', 'I', 24);
                        $pdf->Ln(70);
                        $pdf->writeHTML($html, true, true, false, false, 'C');
                        $condicion = ['folio' => $folio];
                        $info = $this->UserModel->getAllOneRow("constancia_$red", $condicion);
                        $condicion = ['publication_id' => $info['publication_id']];
                        $ponencia = $this->UserModel->getAllOneRow('ponencias', $condicion);
                        $ponencia_nombre = $ponencia['nombre'];
                        $pdf->Ln(20);
                        $pdf->writeHTML($ponencia_nombre, true, true, false, false, 'C');
                        break;
                }

                break;

            case 'Miembro_asociado':

                $abreviacion = "MA";

                $h = 330;

                $w = 255;

                $pdf->AddPage('L', [$h, $w]);

                switch ($anio) {
                    case 2022:
                        background($pdf, $w, $h, $nombre_constancia);
                        $pdf->SetFont('times', 'I', 8);
                        $folio_completo = $folio . "$abreviacion-" . $red . "-" . $anio;
                        $pdf->writeHTML($folio_completo, true, true, false, false, 'R');
                        $pdf->SetFont('times', 'I', 24);
                        $pdf->Ln(67);
                        $pdf->writeHTML($html, true, true, false, false, 'C');
                        break;
                }

                break;
        }

        $condiciones = ["folio" => $folio];

        $data = ["folio_completo" => $folio . "$abreviacion-" . $red . "-" . $anio];

        //$this->UserModel->generalUpdate("constancia_$red",$data,$condiciones);

        $this->response->setContentType('application/pdf');

        $pdf->Output($nombre_constancia . "_" . utf8_decode($nombre_usuario) . ".pdf", 'I');
    }

    public function constancia_moderadores($tipo, $red, $anio, $folio)
    {
        #EN ESTA FUNCION VAMOS A MOSTRAR UN PDF CON LA CONSTANCIA QUE SE LE ASIGNE AL USUARIO.
        #LA CONSTANCIA SE PUEDE OTORGAR PERO NECESITAS LAS IMAGENES PARA BRINDARSELAS, SE HACE
        #UN FILTRO ANTES DE, PERO AQUI TAMBIEN LO HACEMOS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }


        $nombre_constancia = $tipo . '_' . $red . '_' . $anio;

        #VERIFICAMOS LA RUTA DEL ARCHIVO QUE DESEAMOS, SI NO EXISTE, LA URL ESTA MAL O SIMPLEMENTE NO EXISTE EL ARCHIVO
        #CUALQUIERA DE LAS 2 ES VALIDA

        $path = 'resources/img/constancias/' . $nombre_constancia . '.jpg';

        if (!file_exists($path)) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url('/perfil'))
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'La dirección a la que intenta ingresar aún no es válida o es incorrecta. Intente mas tarde.');
            } else {
                http_response_code(404);
                exit;
            }
        }

        //OBTENEMOS EL NOMBRE COMPLETO DEL USUARIO
        $condiciones = ['id' => $folio];

        $constancia = $this->UserModel->getAllOneRow('constancia_moderadores', $condiciones);

        if ($red == 'Releg' && $anio == 2023) {
            $_SESSION['nombre_constancia'] = $nombre_constancia . '.jpg';
            $pdf = new ConstanciasModerador();

            $h = 170;
            $w = 220;
            $pdf->AddPage('L', [$h, $w]);

            #================NOMBRE====================
            $x = 30;  // Posición X
            $y = 62;  // Posición Y
            $width = 165;  // Ancho del área
            $height = 12;  // Alto del área

            #AUTOSIZE FONT

            $texto = $constancia['nombre']; // Texto a mostrar

            // Obtener el ancho del texto con la fuente y el tamaño actual
            $textWidth = $pdf->GetStringWidth($texto);
            $fontSize = 16;
            $fontFamily = 'gothicb';
            $pdf->SetFont($fontFamily, '', $fontSize, '', false);

            // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
            while ($textWidth > $width) {
                $fontSize -= 0.5; // Reducir el tamaño de fuente
                $pdf->SetFont($fontFamily, '', $fontSize);
                $textWidth = $pdf->GetStringWidth($texto);
            }



            // Establecer el área de texto
            $pdf->SetXY($x, $y);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

            #================NOMBRE====================

            #================FOLIO====================
            $x = 187;  // Posición X
            $y = 157;  // Posición Y
            $width = 25;  // Ancho del área
            $height = 6;  // Alto del área

            #AUTOSIZE FONT

            if ($constancia['folio_completo'] == '') {
                $dataUpdate = [
                    'folio_completo' => $constancia['folio'] . 'PO-' . ucfirst($_SESSION['red']) . '-' . $constancia['anio']
                ];
                $condiciones = ['id' => $constancia['id']];

                $this->UserModel->generalUpdate('constancia_' . $red, $dataUpdate, $condiciones);

                $condiciones = ['folio' => $folio];

                $constancia = $this->UserModel->getAllOneRow('constancia_' . $red, $condiciones);
            }

            $texto = $constancia['folio_completo']; // Texto a mostrar

            // Obtener el ancho del texto con la fuente y el tamaño actual
            $textWidth = $pdf->GetStringWidth($texto);
            $fontSize = 6;
            $fontFamily = 'century_gothic';
            $pdf->SetFont($fontFamily, '', $fontSize, '', false);

            // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
            while ($textWidth > $width) {
                $fontSize -= 1; // Reducir el tamaño de fuente
                $pdf->SetFont($fontFamily, '', $fontSize);
                $textWidth = $pdf->GetStringWidth($texto);
            }



            // Establecer el área de texto
            $pdf->SetXY($x, $y);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

            #================FOLIO====================

            #================HYPERVINCULO====================

            $x = 4;  // Posición X
            $y = 160;  // Posición Y
            $width = 123;  // Ancho del área
            $height = 8;  // Alto del área

            $pdf->SetXY($x, $y);
            // Obtener el ancho del texto con la fuente y el tamaño actual
            $textWidth = $pdf->GetStringWidth($texto);
            $fontSize = 10;
            $fontFamily = 'century_gothic';

            $pdf->SetFont($fontFamily, '', $fontSize, '', false);

            // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
            while ($textWidth > $width) {
                $fontSize -= 1; // Reducir el tamaño de fuente
                $pdf->SetFont($fontFamily, '', $fontSize);
                $textWidth = $pdf->GetStringWidth($texto);
            }

            $pdf->SetTextColor(101, 113, 124);

            $url = 'https://redesla.la/';
            $pdf->SetAlpha(0.0);
            $pdf->Rect($x, $y, $width, $height, 'F');
            $pdf->Link($x, $y, $width, $height, $url);

            #================HYPERVINCULO====================


            unset($_SESSION['nombre_constancia']);
            $this->response->setContentType('application/pdf');
            $pdf->Output($nombre_constancia . ".pdf", 'I');
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    public function Carpetas()
    {

        #VISTA DE GRUPOS>CARPETAS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'red' => $_SESSION['red']];

        $carpetas = $this->UserModel->getAll('carpetas', $condiciones);

        if (empty($carpetas)) {
            return redirect()->to(base_url('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA']))
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
        }

        $key_sort  = array_column($carpetas, 'ano_carpeta');
        array_multisort($key_sort, SORT_DESC, $carpetas);

        $data["carpetas"] = $carpetas;
        /*
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        */

        return view('usuarios/headers/index', $data)
            . view('usuarios/carpetas', $data)
            . view('usuarios/footers/index');
    }

    #=============PAGOS==============

    public function pagos()
    {

        #ESTE ES UNO DE LOS APARTADOS DONDE DEBES TENER MAS CUIDADO, POR EL PROCESO MAS QUE NADA
        #LEE ATENTAMENTE LOS COMENTARIOS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $array = [];

        $data = [];

        $i = 0;

        #NOS TRAEMOS TOSOS LOS PAGOS (PROYECTOS) DEL CUERPO ACADEMICO ACTUAL

        $condiciones = ['claveCuerpo' => $_SESSION['CA']];

        $pagos = $this->UserModel->getAll('pagos', $condiciones);

        #RECORREREMOS CADA UNO DE ELLOS PARA OBTENER MAS INFORMACION DE ELLOS

        foreach ($pagos as $pago) {

            //VAMOS A OBTENER LOS DATOS DEL PROYECTO

            $condiciones = ['concat(nombre," ",redCueCa," ",anio) =' => $pago["proyecto"]];

            $proyecto = $this->UserModel->getAllOneRow("proyectos", $condiciones);

            #OBTENEMOS LOS DATOS DE PRONTO PAGO PARA DARLE UN AVISO AL USUARIO SI LOS TIENE
            #EL PRONTO PAGO ES UNA FECHA EN LA CUAL SI SE PAGA ANTES DE CIERTA FECHA, LE DAREMOS UN DESCUENTO, 
            #EL BACKEND DE ESTO SE HACE EN ADMIN

            $pronto_pago = [];

            $pronto_pago["montoMx"] = $proyecto["montoMx"];

            $pronto_pago["montoUs"] = $proyecto["montoUs"];

            $pronto_pago["pronto_PagoMX"] = $proyecto["precio_prontoPagoMx"];

            $pronto_pago["pronto_PagoUs"] = $proyecto["precio_prontoPagoUs"];

            $pronto_pago["fechaLimite_prontoPago"] = $proyecto["fecha_limite_prontoPago"];

            $pago["pronto_pago"] = $pronto_pago;

            $array[] = $pago;

            #OBTENDREMOS TODOS LOS MOVIMIENTOS DE CADA PAGO DEL CUERPO ACADEMICO

            $condiciones = ['id_pago' => $pago['id']];

            $movimientos = $this->UserModel->getAll('movimientos', $condiciones);

            foreach ($movimientos as $movimiento) {

                $array[$i]["movimientos"][] = $movimiento;
            }

            $i++;
        }

        #OBTENEMOS LOS PAQUETES DISPONIBLES PARA ESA RED Y QUE ESTEN ACTIVOS, ESTA INFO SE UTILIZARA
        #EN EL SELECT DEL PROYECTO

        $condiciones = ["redCueCa" => $_SESSION["red"], "activacion_usuarios" => 1];

        $paq_disponibles = $this->UserModel->getAll("proyectos", $condiciones);

        $data["paq_disponibles"] = $paq_disponibles;

        $data["array_pagos"] = $array;

        $sum_restantes = 0;
        
        foreach($array as $a){
            $restante = $a['restante'];
            $sum_restantes = $sum_restantes+$restante;
        }
        $data["suma_restantes"] = $sum_restantes;

        return view('usuarios/headers/index', $data)
            . view('usuarios/pagos', $data)
            . view('usuarios/footers/index');
    }

    public function verificarExistenciaProyecto(){
        #VAMOS A VERIFICAR LA EXISTENCIA DEL PROYECTO PRIMERO Y SI SE ENCUENTRA ACTIVO

        $id_proyecto = $_POST['id_proyecto'];

        $condiciones = [
            'id' => $id_proyecto,
            'activacion_usuarios' => 1
        ];

        if(!$this->UserModel->exist('proyectos',$condiciones)){
            http_response_code(700);
            echo 'El proyecto que quiere registrar no se encuentra activo.';
            exit;
        }

        #EL PROYECTO EXISTE Y ESTA ACTIVO, VAMOS A VER SI YA ESTA REGISTRADO AL USUARIO

        $condiciones = [
            'id' => $id_proyecto
        ];

        $proyecto = $this->UserModel->getAllOneRow('proyectos',$condiciones);

        if(empty($proyecto)){
            http_response_code(404);
            echo 'El proyecto no ha sido encontrado.';
            exit;
        }

        #VAMOS A SABER SI ES INVESTIGACION U OTRO, SOLO LA INVESTIGACIONES NO SE PUEDEN DUPLICAR

        $explode_proyecto = explode(' ',$proyecto['nombre']); # [0] => 'Esquema' [1] => 'B:' [2] => 'investigacion'

        if(isset($explode_proyecto[2]) && $explode_proyecto[2] == 'Investigación'){
            #vamos a ver si se duplica

            $condiciones = [
                'id_proyecto' => $id_proyecto,
                'claveCuerpo' => $_SESSION['CA']
            ];
    
            if($this->UserModel->exist('pagos',$condiciones)){
                http_response_code(701);
                echo 'El proyecto que desea registrar ya se encuentra registrado.';
                exit;
            }

            #AHORA VAMOS A EXTRAER LA INFO DE ESE PROYECTO PARA SABER SI ES ESQUEMA Y PODER OBTENER QUE ESQUEMA ES Y BUSCAR SI HAY UNO DIFERENTE PARA DECOLVERLO
            #EJEMPLO: TIENE REGISTRADO EL ESQUEMA A PERO QUIERE REGISTRAR EL ESQUEMA B, DEBEMOS EVITAR QUE LO HAGA

            #REMOVEMOS LOS 2 PUNTOS DE LA POSICION 2

            $tipo_esquema = str_replace(':','',$explode_proyecto[1]);

            $esquemas_permitidos = ['A','B'];

            if(!in_array($tipo_esquema,$esquemas_permitidos)){
                http_response_code(702);
                echo 'Se ha producido un error. Contacte al equipo REDESLA.';
                exit;
            }

            $esquema_alterno = $tipo_esquema == 'A' ? 'B' : 'A';

            $condiciones = [
                'nombre' => "Esquema {$esquema_alterno}: Investigación",
                'redCueCa' => $_SESSION['red'],
                'anio' => $proyecto['anio']
            ];

            $columnas = ['id'];

            if(!$this->UserModel->exist('proyectos',$condiciones)){
                //No existe un esquema A o B en el proyecto. Ejemplo: Solo se agrego el proyecto B, no el A
                http_response_code(703);
                echo 'Ha ocurrido un error. Contacte a sistemas. Error 703.';
                exit;
            }

            $id_proyecto_alterno = $this->UserModel->getColumnsOneRow($columnas,'proyectos',$condiciones);

            if(empty($id_proyecto_alterno)){
                http_response_code(704);
                echo 'Ha ocurrido un error. Contacte a sistemas. Error 704.';
                exit;
            }

            #AHORA VAMOS A VER SI EXISTE ESE PROYECTO ALTERNO AGREGADO POR ESE GRUPO

            $condiciones = [
                'claveCuerpo' => $_SESSION['CA'],
                'id_proyecto' => $id_proyecto_alterno
            ];

            if($this->UserModel->exist('pagos',$condiciones)){
                http_response_code(705);
                echo 'Ya ha registrado un esquema para la investigación anual '.$proyecto['anio'].'.';
                exit;
            }

        }

        #EL PROYECTO NO ES INVESTIGACION Y HA PASADO TODOS LOS FILTROS.

        echo json_encode(http_response_code(200));
        
    }

    public function insertPago(){

        $data = $_POST;

        #OBTENEMOS LA INFORMACION DEL PROYECTO

        $condiciones = ['id' => $data["id_proyecto"]];

        $infoProyecto = $this->UserModel->getAllOneRow("proyectos", $condiciones);

        #VERIFICAMOS EL PAIS PARA SABER SI EL PRECIO ES EN MXN O USD

        $precio = $_SESSION["pais"] == 2 ? $infoProyecto["montoMx"] : $infoProyecto["montoUs"];

        $columnas = ['pais'];

        $condiciones = ['claveCuerpo' => $_SESSION['CA']];

        $paisUser = $this->UserModel->getColumnsOneRow($columnas, "cuerpos_academicos", $condiciones);

        $paisUser = $paisUser["pais"];

        $dataInsert = [
            "usuario" => $_SESSION['usuario'],
            "claveCuerpo" => $_SESSION['CA'],
            "proyecto" => $infoProyecto["nombre"] . " " . $infoProyecto["redCueCa"] . " " . $infoProyecto["anio"],
            "monto" => $precio,
            "restante" => $precio,
            "moneda" => $_SESSION["pais"] == 2 ? "MXN" : "USD",
            "fecha_registro" => date("Y-m-d H:i:s"),
            'id_proyecto' => $infoProyecto['id']
        ];

        $anios = $infoProyecto['anio'];

        $condiciones = [
            "claveCuerpo" => $_SESSION["CA"],
            "ano_carpeta" => $anios
        ];

        $carpeta = $this->UserModel->getAllOneRow("carpetas", $condiciones);

        #PARA QUE ES ESTO, SABEMOS QUE CUANDO SE REGISTRA UN CUERPO ACADEMICO NUEVO SE HACEN SUS CARETAS, ESTE CUERPO ACADEMICO PUEDE O NO PERSISTIR
        #DURANTE LOS AñOS, ENTONCES LA CARPETA SE QUEDARIA CON UN AñO SIEMPRE SI NO HACEMOS ALGO Y QUEREMOS TENER UN HISTORIAL DE SUS ARCHIVOS.
        #LA SOLUCION FUE QUE AL MOMENTO QUE LOS LIDERES AL AGREGAR UN NUEVO PROYECTO CON LOS AñOS SE LE CREE OTRO REGISTRO DE CARPETAS
        #SI NO TIENE CON EL AñO DE REGISTRO DEL PROYECTO, EJEMPLO
        #CA CREADO EN 2021, PERSISTE EN 2022 Y QUIERE INICIAR A CONGRESO 2022
        #SOLO TIENE CARPETAS DE 2021, AL REGISTRARSE AL CONGRESO 2022 SE LE CREARA UNA CARPETA PORQUE DE ESE AñO NO TIENE REGISTRO

        if (empty($carpeta)) {
            
            $dataCarpeta = [
                "claveCuerpo" => $_SESSION["CA"],
                "ano_carpeta" => $anios,
                "red" => $_SESSION["red"]
            ];

            $this->UserModel->generalInsert("carpetas", $dataCarpeta);
        }

        #AGREGAMOS EL PAGO Y EXTRAEMOS EL ID INSERTADO

        $id_pago = $this->UserModel->generalInsertLastId($dataInsert, "pagos");

        $dataInsert2 = [
            "id_pago" => $id_pago,
            "movimiento" => "+$$precio",
            "comprobante" => "No requiere",
            "estado" => "1"
        ];

        #AñADIMOS EL MOVIMIENTO EN LA BD

        if (!$this->UserModel->generalInsert("movimientos", $dataInsert2) == 1) {
            http_response_code(501);
            echo 'Ha ocurrido un error al insertar el pago. Contacte a sistemas';
            exit;
        }

        $this->updateSessionProyectos();

        $response = [
            'title' => 'Éxito',
            'text' => 'Proyecto registrado correctamente'
        ];

        echo json_encode($response);
        exit;

    }

    private function updateSessionProyectos(){
        $proyectos = [];

        #TOMAMOS LOS PROYECTOS DE LOS PAGOS

        $condiciones = ['claveCuerpo' => session('CA')];

        $pagos =  $this->UserModel->getAll('pagos', $condiciones);

        foreach ($pagos as $pago) {
            $condiciones = ['id' => $pago['id_proyecto']];
            $columnas = ['esquema','anio'];
            $info_proyecto = $this->UserModel->getColumnsOneRow($columnas,'proyectos',$condiciones);

            $proyectos[] = [
                'esquema' => $info_proyecto['esquema'],
                'anio' => $info_proyecto['anio'],
                'proyecto' => $pago['proyecto']
            ];
        }
        
        usort($proyectos, function ($a, $b) {
            $anioA = preg_replace('/[^0-9]/', '', $a['anio']); // Elimina todos los caracteres no numéricos
            $anioB = preg_replace('/[^0-9]/', '', $b['anio']); // Elimina todos los caracteres no numéricos
        
            return intval($anioB) - intval($anioA);
        });
        
        $_SESSION['proyectos'] = $proyectos;
    }

    #=============PAGOS==============

    /*
    public function addPagoUsuario()
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST['paquete'])) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->to(base_url('Pagos'))
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Debe seleccionar un proyecto para continuar.');
            }
        }

        $data = $_POST;

        #DOBLE FILTRO PARA VER QUE NO ESTE VACIO EL PROYECTO QUE SELECCIONO EL USUARIO

        if (empty($data)) {

            return redirect()->to(base_url('Pagos'))
                ->with('icon', 'warning')
                ->with('title', 'Cuidado')
                ->with('text', 'Seleccione un proyecto para poder continuar');
        } else {

            #PASO EL FILTRO, CONTINUA EL PROCESO

            #OBTENEMOS LA INFORMACION DEL PROYECTO

            $condiciones = ['id' => $data["paquete"]];

            $infoProyecto = $this->UserModel->getAllOneRow("proyectos", $condiciones);

            #VERIFICAMOS EL PAIS PARA SABER SI EL PRECIO ES EN MXN O USD

            $precio = $_SESSION["pais"] == 2 ? $infoProyecto["montoMx"] : $infoProyecto["montoUs"];

            $columnas = ['pais'];

            $condiciones = ['claveCuerpo' => $_SESSION['CA']];

            $paisUser = $this->UserModel->getColumnsOneRow($columnas, "cuerpos_academicos", $condiciones);

            $paisUser = $paisUser["pais"];



            $dataInsert = array(

                "usuario" => $_SESSION['usuario'],

                "claveCuerpo" => $_SESSION['CA'],

                "proyecto" => $infoProyecto["nombre"] . " " . $infoProyecto["redCueCa"] . " " . $infoProyecto["anio"],

                "monto" => $precio,

                "restante" => $precio,

                "moneda" => $_SESSION["pais"] == 2 ? "MXN" : "USD",

                "fecha_registro" => date("Y-m-d H:i:s"),

                'id_proyecto' => $infoProyecto['id']

            );

            $anios = $infoProyecto['anio'];

            $condiciones = array(

                "claveCuerpo" => $_SESSION["CA"],

                "ano_carpeta" => $anios

            );

            $carpeta = $this->UserModel->getAllOneRow("carpetas", $condiciones);

            #PARA QUE ES ESTO, SABEMOS QUE CUANDO SE REGISTRA UN CUERPO ACADEMICO NUEVO SE HACEN SUS CARETAS, ESTE CUERPO ACADEMICO PUEDE O NO PERSISTIR
            #DURANTE LOS AñOS, ENTONCES LA CARPETA SE QUEDARIA CON UN AñO SIEMPRE SI NO HACEMOS ALGO Y QUEREMOS TENER UN HISTORIAL DE SUS ARCHIVOS.
            #LA SOLUCION FUE QUE AL MOMENTO QUE LOS LIDERES AL AGREGAR UN NUEVO PROYECTO CON LOS AñOS SE LE CREE OTRO REGISTRO DE CARPETAS
            #SI NO TIENE CON EL AñO DE REGISTRO DEL PROYECTO, EJEMPLO
            #CA CREADO EN 2021, PERSISTE EN 2022 Y QUIERE INICIAR A CONGRESO 2022
            #SOLO TIENE CARPETAS DE 2021, AL REGISTRARSE AL CONGRESO 2022 SE LE CREARA UNA CARPETA PORQUE DE ESE AñO NO TIENE REGISTRO

            if (empty($carpeta)) {

                $dataCarpeta = array(

                    "claveCuerpo" => $_SESSION["CA"],

                    "ano_carpeta" => $anios,

                    "red" => $_SESSION["red"]
                );

                $this->UserModel->generalInsert("carpetas", $dataCarpeta);
            }

            #AGREGAMOS EL PAGO Y EXTRAEMOS EL ID INSERTADO

            $id_pago = $this->UserModel->generalInsertLastId($dataInsert, "pagos");

            $dataInsert2 = array(

                "id_pago" => $id_pago,

                "movimiento" => "+$$precio",

                "comprobante" => "No requiere",

                "estado" => "1"

            );

            #AñADIMOS EL MOVIMIENTO EN LA BD

            if ($this->UserModel->generalInsert("movimientos", $dataInsert2) == 1) {
                #TODO BIEN
                return redirect()->to(base_url('Pagos'))
                    ->with('icon', 'success')
                    ->with('title', 'Listo')
                    ->with('text', 'Proyecto registrado correctamente');
            } else {
                #FALLO
                return redirect()->to(base_url('Pagos'))
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
            }
        }
    }

    */

    public function addMovimiento()
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST['id_pago'])) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->to(base_url('Pagos'))
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
            }
        }

        #EL PROCESO QUE SE HACE AQUI ES INSERTAR LA IMAGEN DEL COMPROBANTE A LOS ARCHIVOS DEL SISTEMA
        #AL IGUAL QUE INSERTAR EL REGISTRO A LA BD

        $data = $_POST;

        if ($imgFile = $this->request->getFile('comprobante')) {
            if ($imgFile->isValid() && !$imgFile->hasMoved()) {
                $validated = $this->validate([
                    'comprobante' => [
                        'uploaded[comprobante]',
                        'mime_in[comprobante,image/png,image/jpeg,image/jpg,application/pdf]',
                        'max_size[comprobante,5000]'
                    ]
                ]);

                if ($validated) {
                    $nombre = $imgFile->getRandomName();
                    if ($imgFile->move(WRITEPATH . 'uploads/comprobantes/', $nombre)) {

                        #LA IMAGEN SE SUBIO, FALTA INGRESAR EL REGISTRO A LA BD

                        #SE HACE EL ARRAY CON LA INFORMACION NECESARIA


                        $dataMovimiento = [
                            'id_pago' => $data['id_pago'],
                            'movimiento' => '-$' . $data["cantidad"],
                            'comprobante' => $nombre,
                            'estado' => '0',
                            'fecha_comprobante' => $data["fecha"],
                            'fecha_insert' => date("Y-m-d H:i:s"),
                            'facturado' => 0
                        ];

                        #SE HACE EL INTENTO DE SUBIR EL REGISTRO

                        if ($this->UserModel->generalInsert('movimientos', $dataMovimiento) == 1) {

                            $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'ano_carpeta' => date('Y')];
                            $existeCarpeta = $this->UserModel->exist('carpetas', $condiciones);
                            if (empty($existeCarpeta)) {
                                #LA CARPETA NO EXISTE, LA CREAMOS
                                $data = ['claveCuerpo' => $_SESSION['CA'], 'ano_carpeta' => date('Y'), 'red' => $_SESSION['red']];
                                $this->UserModel->generalInsert('carpetas', $data);
                            }

                            return redirect()->to(base_url('facturas'))
                                ->with('icon', 'success')
                                ->with('title', '¡ÉXITO!')
                                ->with('text', 'Movimiento añadido correctamente; será revisado y aprobado por el equipo RedesLA. Ahora puede realizar su factura.')
                                ->with('textColor', '#FF0000'); // Código de color en hexadecimal para rojo
                            }
                    } else {

                        #POR ALGUNA RAZON FALLO AL INSERTAR LA IMAGEN

                        return redirect()->to(base_url('Pagos'))
                            ->with('icon', 'error')
                            ->with('title', 'Lo sentimos')
                            ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
                    }
                } else {
                    #NO CUMPLIO LAS VALIDACIONES DEL ARCHIVO
                    return redirect()->to(base_url('Pagos'))
                        ->with('icon', 'warning')
                        ->with('title', 'Cuidado')
                        ->with('text', 'Los archivos aceptados son PNG, JPEG, JPG Y PDF y su peso debe ser menor a 5MB');
                }
            }
        }
    }

    public function deleteProyecto(){

        $id_pago = $_POST['id'];

        //VAMOS A ELIMINAR MOVIMIENTOS SI ES QUE LOS HAY

        $condiciones = ['id_pago' => $id_pago];
        $columnas = ['comprobante','id'];
        $movimientos = $this->UserModel->getAllColums($columnas,'movimientos',$condiciones);
        

        if(!empty($movimientos)){
            foreach($movimientos as $m){
                
                $comprobante = $m['comprobante'];
                $ruta = WRITEPATH . 'uploads/comprobantes/' . $comprobante;
                
                if($comprobante != 'No requiere'){
                    if(file_exists($ruta)){
                        unlink($ruta);
                    }
                }
            }

            $condicionesDelete = ['id_pago' => $id_pago];

            if(!$this->UserModel->generalDelete('movimientos',$condicionesDelete)){
                http_response_code(100);
                exit;
            }
        }

        $condicionesDelete = ['id' => $id_pago];

        if(!$this->UserModel->generalDelete('pagos',$condicionesDelete)){
            http_response_code(101);
            exit;
        }
        $this->updateSessionProyectos();

        return  json_encode(true);
        exit;
    }

    function visualizador($img = null)
    {

        if (!$img) {
            $img = $this->request->getGet('img');
        }

        if ($img == '') {
            throw PageNotFoundException::forPageNotFound();
        }

        $name = WRITEPATH . 'uploads/comprobantes/' . $img;

        if (!file_exists($name)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $fp = fopen($name, 'rb');

        $explode = explode('.', $img);
        if ($explode[1] == 'pdf') {
            header('Content-Type: application/pdf');
        } else if ($explode[1] == 'png') {
            header('Content-Type: image/png');
        } else if ($explode[1] == 'jpg') {
            header('Content-Type: image/jpg');
        } else if ($explode[1] == 'jpeg') {
            header('Content-Type: image/jpeg');
        }

        #ENVIA LAS CABECERAS CORRECTAS

        header('Content-Length: ' . filesize($name));

        #VUELCA LA IMAGEN Y DETIENE EL SCRIPT
        fpassthru($fp);
        exit;
    }

    #=====================FACTURAS=======================
    public function Facturas()
    {

        #ESTE APARTADO MUESTRA EL LISTADO DE LAS FACTURAS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if ($_SESSION['lider_ca'] != 1) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Solamente el líder puede solicitar facturas.');
        }


        return view('usuarios/headers/index')
            //Cambio hecho por Mario D. , original:  . view('usuarios/facturas')
            . view('usuarios/facturas')
            . view('usuarios/footers/index');

        //$this->load->view('inicio/factura', $data);

    }

    public function getListaFacturas(){

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'claveCuerpo', 'proyecto', 'id_proyecto', 'monto', 'restante', 'moneda', 'fecha_registro', 'tipo_registro'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM pagos";
        $sql_data = "SELECT * FROM pagos";

        $claveCuerpo = '"'.$_SESSION['CA'].'"';

        $condicion = "";

        /*
        if($columnas[$key] == 'id'){
                    $condicion .= " WHERE ".$val." LIKE '%".$valor_buscado."%'";
                }else{
                    $condicion .= " OR ".$val." LIKE '%".$valor_buscado."%'";
                }
        */

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    $condicion .= ' WHERE (claveCuerpo = ' . $claveCuerpo . ') AND ( ' . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }



        $sql_count = empty($condicion) ? $sql_count . ' WHERE claveCuerpo = ' . $claveCuerpo : $sql_count . $condicion . ')';

        $sql_data =  !empty($condicion) ? $sql_data . $condicion . ')' : $sql_data . ' WHERE claveCuerpo = ' . $claveCuerpo;

        $total_count = $this->db_serv_main->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv_main->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            $condiciones = ['id_pago' => $a['id']];
            $movimientos = $this->UserModel->getAll('movimientos', $condiciones);

            if(!empty($movimientos)){
                $arr_mov = [];
                if (!empty($movimientos)) {

                    foreach ($movimientos as $keyMov=>$movimiento) {
    
                        array_push($arr_mov,$movimiento);
                    }    
                }
            }


            if ($a['restante'] !== 0 && isset($arr_mov)) {
                #SIGNIFICA QUE NO ES UN PROYECTO DE CONGRESO AGREGADO POR INVESTIGACION O POR EL ADMINISTRADOR

                #RECORREMOS LOS MOVIMIENTOS

                foreach($arr_mov as $keyMov => $mov){
                     #EXTRAEMOS EL CARACTER DEL MOVIMIENTO, ESTO PARA SABER SI ES DE ADICION DE PAGO (+)
                        # O PARA SABER SI ES UNO RESTANTE (-)
                        #STRPOS DEVUELVE UN BOOL QUE ME DICE SI EXISTE O NO UN CARACTER EN UNA VARIABLE

                        $return = strpos($mov["movimiento"], "+");

                        #SI EN EL STRPOS NO ENCUENTRA EL CARACTER DE (+) PROCEDEMOS A OBTENER LOS DATOS PARA LA FACTURA
                        #DADO A QUE ESTE ES DE INDOLE NEGATIVA

                        if ($return === false) {
                            #AQUI HAY UNA CUESTION, LAS REDES DE RELEP Y RELEN DEL 2021 HACIA ATRAS SE TENIAN
                            #INVESTIGACIONES QUE ABARCABAN 2 AñOS, POR LO QUE SE PUSO ESTA CONDICIONAL, ENTONCES VAMOS A 
                            #HACER UNA CONDICION PARA ESO, PARA SABER SI VAMOS A PONER LOS DATOS COMO 2 AñOS O COMO 1

                            $explode = explode("-", $mov["fecha_insert"]);

                            $anio_mov = $explode[0];

                            if ($anio_mov <= 2021 && ($_SESSION["red"] == "Relep" || $_SESSION["red"] == "Relen")) {
                                $explode2 = explode(" ", $explode[2]);

                                $fecha_mov = $explode[1] . $explode2[0];

                                if ($fecha_mov <= 1031) {

                                    //Inicio desde el anterior

                                    $anio = ($anio_mov - 1) . "-" . $anio_mov;
                                } else {

                                    //Inicia desde este y el siguiente

                                    $anio = $anio_mov . "-" . ($anio_mov + 1);
                                }
                            } else {

                                #$explode = explode("-", $movimiento["fecha_comprobante"]);
                                $explode = explode(" ", $a["proyecto"]);

                                #$anio_mov = $explode[0];

                                #$anio = $anio_mov;
                                $anio = end($explode);
                            }

                            #OBTENEMOS LA CARPETA

                            $condiciones = array("claveCuerpo" => $_SESSION["CA"], "ano_carpeta" => $anio);

                            $carpeta = $this->UserModel->getAllOneRow("carpetas", $condiciones);

                            if (empty($carpeta)) {
                                $info_carpeta = '';
                            } else {
                                $info_carpeta = $carpeta["envios"];
                            }
                            
                            $fechaLimiteFactura = date("Ymd", strtotime($mov["fecha_comprobante"] . "+ 1 month"));

                            $array[] = [
                                'id_movimiento' => $mov['id'],
                                'proyecto' => $a['proyecto'],
                                'movimiento' => $mov['movimiento'],
                                'comprobante' => $mov['comprobante'],
                                'fecha_comprobante' => $mov['fecha_comprobante'],
                                'estado_factura' => $mov['facturado'],
                                'anio_carpeta' => $anio,
                                'carpeta' => $info_carpeta,
                                'fechaLimiteFactura' => $fechaLimiteFactura,
                                'red' => $_SESSION['red']
                            ];

                        }else{
                            unset($array[$key]);
                        }
                }
            }

        }

        $tempArray = array();

        foreach ($array as $item) {
            $idMovimiento = $item['id_movimiento'];
            if (!isset($tempArray[$idMovimiento])) {
                $tempArray[$idMovimiento] = $item;
            }
        }

        // Obtener el array final sin elementos duplicados en función de 'id_movimiento'
        $resultArray = array_values($tempArray);

        $array = $resultArray;

        $array = array_values($array);

        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function formularioFactura()
    {

        #AQUI VAMOS A MOSTRAR EL FORMULARIO PARA QUE COMPLETE LOS DATOS DE SU FACTURA

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST)) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->to(base_url('Facturas'))
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
            }
        }

        $array = $_POST;

        unset($array['dt_facturas_length']);

        #VERIFICAMOS QUE NO ESTE VACIO

        if (empty($array)) {

            return redirect()->to(base_url('Facturas'))
                ->with('icon', 'warning')
                ->with('title', 'Cuidado')
                ->with('text', 'Debes seleccionar un movimiento para realizar la factura');
        } else {

            #EXISTIERON DATOS, VAMOS A PREPARAR LOS DATOS NECESARIOS PARA LA VISTA

            $data = [];

            $condiciones = ['id !=' => 1];

            $paises = $this->UserModel->getAll('pais', $condiciones);

            $data['paises'] = $paises;

            #AQUI LO HACEMOS ASI, PORQUE, NECESITO EL ARRAY DE LOS PAGOS A FACTURAR AL MOMENTO DE INSERTAR.
            #Y NO SE COMO PASAR UN ARRAY ENTRE URL CON PHP MAS QUE ESTA, NO SOY MUY FAN DEL METODO GET LA VERDAD
            #SE ME HACE MUY INSEGURO, PERO CUANDO SE NECESITA PUES SI ESTA CHINGON JAJAJAJA

            //$_SESSION["id_pagos_facturar"] = $array;

            $movimientos = explode(',',$array['movimientos']);

            $data['id_pagos'] = $movimientos;
            $data['id_pagos_facturar'] = $array['movimientos'];

            return view('usuarios/headers/index', $data)
                . view('usuarios/formularios/facturas', $data)
                . view('usuarios/footers/index');
        }
    }

    public function enviar_fact()
    {

        if (!isset($_SESSION['is_logged'])) {
            http_response_code(403);
            echo 'Su sesión ha expirado, inicie sesión nuevamente.';
            exit;
        }

        /*
        if (!isset($_FILES)) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->to(base_url('Facturas'))
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
            }
        }
        */


        $array = $_POST;

        #SE ACUERDAN DEL ARRAY QUE DIJE QUE NO PODIA PASAR ENTRE URL, AQUI SE LO ASIGNO A UNA VARIABLE LOCAL
        #PARA DESPUES BORRARLO Y NO CONSUMA RECURSOS.

        $id_pagos = $_POST["id_pagos_facturar"];

        #EL PROCESO QUE SE HACE AQUI ES INSERTAR LA IMAGEN DE LA SITUACION FISCAL DEL SISTEMA
        #AL IGUAL QUE INSERTAR EL REGISTRO A LA BD

        $data = $_POST;

        #VERIFICAMOS SI SE ENVIO UN ARCHIVO Y NO ESTA VACIO

        if ($imgFile = $this->request->getFile('csf')) {
            if ($imgFile->isValid() && !$imgFile->hasMoved()) {
                $validated = $this->validate([
                    'csf' => [
                        'uploaded[csf]',
                        'mime_in[csf,image/png,image/jpeg,image/jpg,application/pdf]',
                        'max_size[csf,5000]'
                    ]
                ]);

                if ($validated) {

                    $nombre = $imgFile->getRandomName();

                    if ($imgFile->move(WRITEPATH . 'uploads/csf/', $nombre)) {

                        #LA IMAGEN SE SUBIO AHORA FALTA HACER LOS DEMAS PROCESOS

                        $array_facturas = explode(',',$id_pagos);

                        #EL SIGUIENTE PROCESO ES PARA CAMBIAR EL ESTADO DE CADA MOVIMIENTO A 'EN PROCESO', A SU VEZ, CREAMOS UN STRING QUE USAREMOS PARA UNA COLUMNA
                        #EN LA BD

                        $string_facturas = "";

                        foreach ($array_facturas as $id_mov) {

                            $data = ['facturado' => 1];

                            $condiciones = ['id' => $id_mov];

                            $this->UserModel->generalUpdate('movimientos', $data, $condiciones);

                            $string_facturas .= $id_mov . ",";
                        }

                        #INSERTAMOS LA INFORMACION EN LA TABLA DE FACTURAS

                        $data = [
                            "claveCuerpo" => $_SESSION["CA"],

                            "nombre" => $array["nombre"],

                            "rfc" => $array["rfc"],

                            "uso" => $array["uso"],

                            "correo" => $array["correo"],

                            "calle" => $array["calle"],

                            "numero_exterior" => $array["noext"],

                            "numero_interior" => $array["noint"],

                            "cp" => $array["cp"],

                            "colonia" => $array["colonia"],

                            "municipio" => $array["municipio"],

                            "estado" => $array["estado"],

                            "pais" => $array["pais"],

                            "regimen_fiscal" => $array["regimen_fiscal"],

                            "id_movimientos" => $string_facturas,

                            'csf' => $nombre,

                            'localidad' => $_POST['localidad'],

                            "facturado" => 0,

                            "fecha_insercion" => date("Y-m-d H:i:s"),

                            "usuario" => $_SESSION["usuario"]
                        ];

                        #HACEMOS UN INSERT GENERAL PERO NOS DEVUELVE EL ID DE LA INSERCION (ID DE LA FACTURA)

                        $id_factura_db = $this->UserModel->generalInsertLastId($data, 'factura');


                        #OBTENEMOS EL ID DEL PAGO

                        $columnas = ['id_pago'];

                        $condiciones = ['id' => $array_facturas[0]];

                        $id_pago = $this->UserModel->getColumnsOneRow($columnas, 'movimientos', $condiciones);

                        $dataAdmin = array(

                            "claveCuerpo" => $_SESSION["CA"],

                            "usuario" => $_SESSION["usuario"],

                            "tipo" => $array["tipo"],

                            "id_pago" => $id_pago['id_pago'],

                            "id_factura" => $id_factura_db

                        );

                        #HACEMOS EL INTENTO DE INSERTAR LA FACTURA A LA TABLA DE 'facturas_admin' Y REDIRIGIMOS SI TODO ESTA BIEN


                        if ($this->UserModel->generalInsert('facturas_admin', $dataAdmin) == 1) {

                            $return = [
                                'title' => '¡ÉXITO!',
                                'text' => 'Solicitud de factura enviada satisfactoriamente. Dentro de este apartado puedes ver el estado de su solicitud'
                            ];

                            echo json_encode($return);

                        } else {
                            unlink(WRITEPATH . 'uploads/csf/', $nombre);
                            http_response_code(505);
                            echo 'Ha ocurrido un error, intentelo mas tarde';
                            exit;
                        }
                    } else {

                        #POR ALGUNA RAZON FALLO AL INSERTAR LA IMAGEN

                        http_response_code(504);
                        echo 'Ha ocurrido un error, intentelo mas tarde.';
                        exit;
                    }
                } else {
                    #NO CUMPLIO LAS VALIDACIONES DEL ARCHIVO
                    http_response_code(503);
                    echo 'El archivo debe se rn formato PDF y su peso debe ser menor a 5MB';
                    exit;
                }
            } else {
                http_response_code(502);
                echo 'Ha ocurrido un error, intentelo mas tarde.';
                exit;
            }
        } else {

            http_response_code(501);
            echo 'Ha ocurrido un error, intentelo mas tarde.';
            exit;
        }
    }

    public function readCSF(){
        $archivo = $_FILES['archivo']['tmp_name'];
        $parser = new Parser();
        $pdf = $parser->parseFile($archivo);

        $texto = $pdf->getText();
        $texto = preg_replace('/\s+/', ' ', $texto);

        $na = '';


        if(preg_match('/RFC:\s*([^D]+)/',$texto,$matches)){
            $rfc = trim($matches[1]);
        }else{
            http_response_code(501);
            exit;
        }

        if (preg_match('/Denominación\/Razón\s+Social:\s+(.*)/', $texto, $matches)) {
            $denominacionSocial = $matches[1];
            $denominacionSocial = strstr($denominacionSocial, "Régimen Capital", true);
            $denominacionSocial = trim($denominacionSocial);
            $razons = $denominacionSocial;
        }else{
            http_response_code(502);
            exit;
        }

        if (preg_match('/Código\s+Postal:\s+(\d+)/', $texto, $matches)) {
            $cp = $matches[1];
        }else{
            http_response_code(503);
            exit;
        }

        if(preg_match('/Nombre de Vialidad:\s+(.*)/',$texto,$matches)){
            $vialidad = $matches[1];
            $vialidad = strstr($vialidad, "Número Exterior", true);
            $vialidad = trim($vialidad);
        }else{
            $vialidad = $na;
        }

        if(preg_match('/Número Interior:\s+(.*)/',$texto,$matches)){
            $noInt = $matches[1];
            $noInt = strstr($noInt, "Nombre de laColonia:", true);
            $noInt = trim($noInt);
        }else{
            $noInt = $na;
        }

        if(preg_match('/Número Exterior:\s+(.*)/',$texto,$matches)){
            $noExt = $matches[1];
            $noExt = strstr($noExt, "Número Interior:", true);
            $noExt = trim($noExt);
        }else{
            $noExt = $na;
        }

        if(preg_match('/Nombre de laColonia:\s+(.*)/',$texto,$matches)){
            $colonia = $matches[1];
            $colonia = strstr($colonia, "Nombre de laLocalidad:", true);
            $colonia = trim($colonia);
        }else{
            $colonia = $na;
        }

        if(preg_match('/Nombre de laLocalidad:\s+(.*)/',$texto,$matches)){
            $localidad = $matches[1];
            $localidad = strstr($localidad, "Nombre del Municipio oDemarcación Territorial:", true);
            $localidad = trim($localidad);
        }else{
            $localidad = $na;
        }

        if(preg_match('/Nombre de laEntidad Federativa:\s+(.*)/',$texto,$matches)){
            $nombre_estado = $matches[1];
            $nombre_estado = strstr($nombre_estado, "Entre Calle:", true);
            $nombre_estado = trim($nombre_estado);

            //HAY QUE BUSCAR EL ID DEL ESTADO
            $condiciones = [
                'id_pais' => 2,
                'nombre' => $nombre_estado
            ];

            $info_estado = $this->UserModel->getAllOneRow('estados',$condiciones);
            if(empty($info_estado)){
                $estado = [];
            }else{
                $estado = [
                    'id' => $info_estado['id'],
                    'nombre' => $info_estado['nombre']
                ];
            }

        }else{
            $estado = $na;
        }

        if(preg_match('/Nombre del Municipio oDemarcación Territorial:\s+(.*)/',$texto,$matches)){
            $nombre_municipio = $matches[1];
            $nombre_municipio = strstr($nombre_municipio, "Nombre de laEntidad Federativa:", true);
            $nombre_municipio = trim($nombre_municipio);

            //OBTENEMOS EL ID DEL MUNICIPIO
            if(!empty($estado)){
                $condiciones = [
                    'id_estado' => $estado['id'],
                    'nombre' => $nombre_municipio
                ];
                $info_municipio = $this->UserModel->getAllOneRow('municipios',$condiciones);
                if(empty($info_municipio)){
                    $municipio = [];
                }else{
                    $municipio = [
                        'id' => $info_municipio['id'],
                        'nombre' => $info_municipio['nombre']
                    ];
                }
            }

        }else{
            $municipio = $na;
        }

        if(preg_match('/Regímenes:\s+(.*)/',$texto,$matches)){
            $regimenes = $matches[1];
            $explode = explode('Régimen Fecha Inicio Fecha Fin',$regimenes);

            $arr_explode = array_chunk($explode,2);
            
            $patron = '/^(.*?)(?=\d{2}\/\d{2}\/\d{4})/';
            $arr_regimenes = [];

            foreach($arr_explode as $a){
                $txt = $a[1];
                if (preg_match($patron, $txt, $coincidencias)) {
                    $resultado = $coincidencias[1];
                    $resultado = trim($resultado);
                    array_push($arr_regimenes,$resultado);
                }
            }
        }else{
            $regimenes = $na;
        }

        

         

        

        


        

        $data = [
            'rfc' => $rfc,
            'razons' => $razons,
            'cp' => $cp,
            'vialidad' => $vialidad,
            'noInt' => $noInt,
            'noExt' => $noExt,
            'colonia' => $colonia,
            'localidad' => $localidad,
            'pais' => 2,
            'estado' => $estado,
            'municipio' => $municipio,
            'regimenes' => $arr_regimenes
        ];

        echo json_encode($data);
    }
    
    #=====================FACTURAS=======================

    

    public function getEstado()
    {

        $id_pais = $_POST["pais"];

        if ($id_pais == "1") {

            $html = "<option style='display:none' value=''>Seleccina un Estado</option>";

            $html .= "<option value='1'>Otro estado</option>";

            echo $html;
        } else {

            $columnas = [];
            array_push($columnas, 'id');
            array_push($columnas, 'nombre');

            $condiciones = ['id_pais' => $id_pais];

            $estados = $this->UserModel->getColumnsOrderBy($columnas, 'estados', $condiciones, 'nombre ASC');

            $html = "<option style='display:none' value=''>Seleccina un Estado</option>";

            foreach ($estados as $estado) {

                $html .= "<option value='" . $estado['id'] . "'>" . $estado['nombre'] . "</option>";
            }

            $html .= "<option value='1'>Otro estado</option>";

            echo $html;
        }
    }

    public function getMunicipio()
    {

        $id_estado = $_POST["estado"];

        if ($id_estado == "1") {

            $html = "<option style='display:none' value=''>Seleccina un municipio</option>";

            $html .= "<option value='1'>Otro municipio</option>";

            echo $html;
        } else {

            $columnas = [];
            array_push($columnas, 'id');
            array_push($columnas, 'nombre');

            $condiciones = ['id_estado' => $id_estado];

            $municipios = $this->UserModel->getColumnsOrderBy($columnas, 'municipios', $condiciones, 'nombre ASC');

            $html = "<option style='display:none' value=''>Seleccina un municipio</option>";

            foreach ($municipios as $municipio) {

                $html .= "<option value='" . $municipio['id'] . "'>" . $municipio['nombre'] . "</option>";
            }

            $html .= "<option value='1'>Otro municipio</option>";

            echo $html;
        }
    }

    

    public function acerca_de()
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        return view('usuarios/headers/index')
            . view('usuarios/acerca')
            . view('usuarios/footers/index');
    }

    public function changeTheme()
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (isset($_SESSION['theme'])) {
            if ($_SESSION['theme'] == 'dark') {
                $data = ['theme' => 'light'];
                $tema = 'light';
            } else {
                $data = ['theme' => 'dark'];
                $tema = 'dark';
            }
            $condicion = ['usuario' => $_SESSION['usuario']];
            if ($this->UserModel->generalUpdate("usuarios", $data, $condicion)) {
                $_SESSION['theme'] = $tema;
                return redirect()->back()->withInput()
                    ->with('icon', 'success')
                    ->with('title', '¡Éxito!')
                    ->with('text', 'Ha cambiado de tema');
            } else {
                return redirect()->to(base_url('Facturas'))
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
            }
        } else {
            return redirect()->to(base_url());
        }
    }

    public function soloAsistentesCongreso()
    {

        #SOLO PARTICIPARAN COMO ASISTENTES, VAMOS A TRAER A TODOS LOS MIEMBROS Y DARLES ACCESO DE OYENTES
        $condiciones = ['cuerpoAcademico' => $_POST['claveCuerpo']];
        $columnas = ['usuario'];
        $miembros = $this->UserModel->getAllColums($columnas, 'miembros', $condiciones);

        if (empty($miembros)) {
            http_response_code(404);
            $mensaje = 'No se ha encontrado información sobre sus miembros de su cuerpo académco.';
            echo $mensaje;
            exit;
        }

        $permitted_chars = 'ABCDEFGHJKLMNOPQRSTUVWXYZ123456789';

        foreach ($miembros as $m) {
            #OBTENEMOS LA INFORMACION DE CADA USUARIO
            $condiciones = ['usuario' => $m['usuario']];
            $usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);
            if (empty($usuario)) {
                http_response_code(404);
                $mensaje = 'No se ha encontrado informacion de un miembro. Contacte al Equipo Redesla.';
                echo $mensaje;
                exit;
            }

            $nombre_completo = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $clave_gafete =  substr(str_shuffle($permitted_chars), 0, 6);

            $dataOyentesRed[] = [
                'clave_gafete' => $clave_gafete,
                'nombre' => $nombre_completo,
                'claveCuerpo' => $_POST['claveCuerpo'],
                'publication_id' => 0, #no aplica
                'anio' => $_POST['anio_congreso'],
                'author_id' => 0,
                'red' => $_POST["red"],
                'tipo_asistencia' => $_POST['tipo_asistencia'], #USAMOS POST EN VEZ DE DATA PORQUE DON PROGRAMADOR SENIOR PUSO DATA COMO OTRA VARIABLE XD
                'usuario' => $usuario['usuario'],
                'oyente' => 1,
                'nombre_congreso' => $_POST['nombre_congreso']
            ];
        }

        if (!$this->UserModel->generalInsertBatch('participantes_congresos', $dataOyentesRed)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al registrar los gafetes. Contacte al Equipo Redesla.';
            echo $mensaje;
            exit;
        }

        $respuesta = [
            'title' => 'Hecho',
            'mensaje' => 'Hemos registrado sus gafetes de oyentes para el <b>' . $_POST['nombre_congreso'] . '</b>',
            'codigo' => 200
        ];
        $json_respuesta = json_encode($respuesta);
        echo $json_respuesta;
        exit;
    }

    public function proyecto($nombre, $anio)
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        #FORMATEAMOS EL NOMBRE DEL PROYECTO DE LA URL

        $nombre = str_replace("_", " ", $nombre);

        $nombre = urldecode($nombre);

        //LO DIVIDIMOS PARA HACER UNA CONDICION MAS ADELANTE

        $nombre_explode = explode(" ", $nombre);

        $tipo_proyecto = $nombre_explode[0];

        $data = [];

        #$condicion = ["claveCuerpo" => $_SESSION['CA']];

        #$columnas = [];

        #array_push($columnas,'tipo_registro');

        #$tipo_registro = $this->UserModel->getColumnsOneRow($columnas,"cuerpos_academicos",$condicion);

        #$data['tipo_registro'] = $tipo_registro['tipo_registro'];

        $condiciones = ['usuario' => $_SESSION['usuario']];

        $columnas = [];

        array_push($columnas, 'nombre');
        array_push($columnas, 'ap_paterno');
        array_push($columnas, 'ap_materno');

        $usuario = $this->UserModel->getColumnsOneRow($columnas, "usuarios", $condiciones);


        if ($tipo_proyecto !== 'Esquema' && $tipo_proyecto !== 'Desafío') {
            #VERIFICAMOS SI EL PROYECTO ESTA ACTIVO Y SI ES QUE EXISTE AUN
            $condiciones = [
                'nombre' => $nombre_explode[0],
                'redCueCa' => $nombre_explode[1],
                'anio' => $nombre_explode[2],
                'activacion_usuarios' => 1
            ];

            $columnas = ['id'];
            $infoProyecto = $this->UserModel->getColumnsOneRow($columnas, 'proyectos', $condiciones);

            if (empty($infoProyecto)) {
                return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'El proyecto ' . $nombre . ' no esta activo actualmente. Contacte al equipo REDESLA para saber más.');
            }

            #verificamis si tiene un horario de ponencias

            $condiciones = [
                'red' => $nombre_explode[1],
                'anio' => $nombre_explode[2],
                //'id_proyecto' => $infoProyecto['id']
            ];

            if ($this->UserModel->exist('congresos', $condiciones)) {
                $columnas = ['nombre'];
                $horario = $this->UserModel->getColumnsOneRow($columnas, 'congresos', $condiciones);

                $ruta = ROOTPATH . '/resources/pdf/congresos/' . $horario['nombre'] . '.pdf';
                if (file_exists($ruta)) {
                    $horario_ponencias_congreso = base_url('/resources/pdf/congresos/' . $horario['nombre'] . '.pdf');
                }
            }
        }


        #AQUI SE PREPARAN LOS PROYECTOS CON LAS VARIABLES, UNA CUESTION
        #HAY DISTINTOS TIPOS DE PROYECTOS, ESQUEMAS, IUNVESTIGACION, CONGRESO, COLOQUIO, OYENTE, DESAFIO
        #CADA UNO TIENE SU PROPIA ESTRUCTURA, POR LO QUE SI TE PIDEN UN CAMBIO SOLAMENTE TE DIRIGES AL TIPO QUE ES
        #Y LO MODIFICAS POR CUALQUIER COSA QUE TE PIDAN, ESTARE EXPLICANDO UN POCO EN CADA UNO.

        #CREO PARA TENER UN MEJOR ORDEN, PREFIERO UN IF EN VEZ DE UN SWITCH

        /*
        if ($tipo_proyecto == 'Coloquio') {

            $cantidad_ponencias = 0;  #PONENCIAS QUE TIENE DISPONIBLES PARA REGISTRAR

            $cantidad_ponencias_pendientes = 0; #PONENCIAS QUE TIENE PENDIENTES POR FALTA DE PAGO

            #EN CUESTIONES DE COLOQUIO Y CONGRESOS, LOS USUARIOS REGISTRAN SUS TEMAS DE IQUATRO AQUI,
            #PUEDEN TENER MAS DE 1 TEMA, POR LO QUE TENEMOS QUE TOMAR LOS DATOS QUE YA ESTAN, MOSTRARSELOS
            #Y DARLE UN FORMULARIO PARA QUE REGISTRE OTRO, EN CASO DE QUE HAYA PAGADO. ELLOS TIENEN QUE
            #INGRESAR UNA PASS QUE SE LES ENVIA A UN CORREO, ESO LO VERAS EN ADINM

            $condiciones = array("claveCuerpo" => $_SESSION["CA"]);

            $ponencia = $this->UserModel->getAll("ponencias", $condiciones);

            #HACEMOS UN SEGUNDO FILTRO PARA SACAR SOLAMENTE LAS DE CONGRESO Y DEL AÑO EN CUESTION
            
            $filtro_ponencia = [];

            $id_registrados = [];

            foreach($ponencia as $p){

                $fecha = $p['fecha_insercion'];

                $explode_fecha = explode('-',$fecha);
                
                $anio_db = $explode_fecha[0]; #ESTE ES EL ANIO DEL REGISTRO DE LA PONENCIA

                $nombre_congreso = $tipo_proyecto . ' ' . $_SESSION['red'] . ' ' . $anio_db;

                $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'nombre_congreso' => $nombre_congreso, 'id' => $p['id']];

                $proyectos_congreso = $this->UserModel->getAllOneRow('ponencias',$condiciones);

                if(!empty($proyectos_congreso)){
                    $filtro_ponencia[] = $proyectos_congreso;
                }
            
            }

            if (!empty($filtro_ponencia)) {

                #EXISTEN PONENCIAS REGISTRADAS, LAS SACAMOS

                $data = [];

                $data['nombre_completo_usuario'] = $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

                $data["nombre_congreso"] = $nombre;

                $x = 0;

                foreach ($filtro_ponencia as $p) {

                    $data["ponencias"]["ponencia$x"]["nombre"] = $p["nombre"];

                    $data["ponencias"]["ponencia$x"]["pub_id"] = $p["publication_id"];

                    $data["ponencias"]["ponencia$x"]["clave_ponencia"] = $p["clave_ponencia"];

                    $condiciones = array("publication_id" => $p["publication_id"]);

                    $autores = $this->UserModel->getAll("participantes_congresos", $condiciones);

                    $i = 0;

                    foreach ($autores as $autor) {

                        $data["ponencias"]["ponencia$x"]["autores"][$i]["nombre"] = $autor["nombre"];

                        $data["ponencias"]["ponencia$x"]["autores"][$i]["gafete"] = $autor["clave_gafete"];

                        $i++;
                    }

                    $x++;
                }



                $array = array();

                $i = 0;

                $condiciones = ['claveCuerpo' => $_SESSION['CA']];

                $pagos = $this->UserModel->getAll('pagos',$condiciones);

                foreach ($pagos as $pago) {

                    $explode = explode(" ", $pago["proyecto"]);

                    if ($explode[0] == "Coloquio") {

                        if ($pago["restante"] == 0) {

                            $cantidad_ponencias++;
                        } else {
                            $cantidad_ponencias_pendientes++;
                        }
                    }
                }

                $data["cantidad_de_ponencias"] = $cantidad_ponencias;

                $data["cantidad_ponencias_pendientes"] = $cantidad_ponencias_pendientes;

                $tipo_registro = $this->UserModel->getAllOneRow("cuerpos_academicos", $condicion);

                $data["tipo_registro"] = $tipo_registro["tipo_registro"];

            } else {

                #AQUI NO SE TIENE REGISTRO DE NINGUNA PONENCIA, DE NADA NADA, NINGUN AÑO

                $condiciones = ['claveCuerpo' => $_SESSION['CA']];

                $pagos = $this->UserModel->getAll('pagos',$condiciones);

                foreach ($pagos as $pago) {

                    $explode = explode(" ", $pago["proyecto"]);

                    if ($explode[0] == "Coloquio") {

                        if ($pago["restante"] == 0) {

                            $cantidad_ponencias++; //AUMENTA PONENCIAS DISPONIBLES, POR PAGO COMPLETO

                        } else {

                            $cantidad_ponencias_pendientes++; //AUMENTA PONENCIAS PENDIENTES, PORQUE TIENE EL PROYECTO PERO NO HA PAGADO

                        }
                    }
                }
                $data["cantidad_de_ponencias"] = $cantidad_ponencias;

                $data["cantidad_ponencias_pendientes"] = $cantidad_ponencias_pendientes;

                $data['nombre_completo_usuario'] = $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

                $data["nombre_congreso"] = $nombre;

            }

            #PRIMERO, DEBEMOS SABER SI YA PAGARON O NO, PARA TOMAR UNA INSTRUCCION
            #verificamos cuantos proyectos de congreso tiene, los recorremos para saber si hay que dejarle el despues o el antes
            $condiciones = ['id_proyecto' => $infoProyecto['id'], 'claveCuerpo' => $_SESSION['CA']];
            $columnas = ['restante','tipo_registro'];

            $proyectos_ca = $this->UserModel->getAllColums($columnas,'pagos',$condiciones);
            $tipo_instruccion = 'despues';
            foreach ($proyectos_ca as $row) {
                if ($row['restante'] > 0) {
                    $tipo_instruccion = 'antes';
                    break;
                }
            }
            #AHORA SAEMOS QUE INSTRUCCIONES TOMAR
            echo '<pre>';
            #print_r($proyectos_ca);
            echo '</pre>';

            $condiciones = [
                'red' => $nombre_explode[1],
                'anio' => $nombre_explode[2],
                'tipo' => $nombre_explode[0],
                'tipo_instruccion' => $tipo_instruccion
            ];


            $condiciones = [
                'red' => $nombre_explode[1],
                'anio' => $nombre_explode[2],
                'tipo' => $nombre_explode[0]
            ];

            $instrucciones = $this->UserModel->getAllOneRow('instrucciones_investigaciones',$condiciones);

            if(!empty($instrucciones)){
                $instrucciones['instrucciones'] = str_replace('$claveCuerpo', $_SESSION['CA'], $instrucciones['instrucciones']);
                $instrucciones['instrucciones'] = str_replace('$usuario', $_SESSION['nombre_completo'], $instrucciones['instrucciones']);
                $data['instrucciones'] = $instrucciones['instrucciones'];
            }

            return view('usuarios/headers/index',$data)
            .view('usuarios/coloquio',$data)
            .view('usuarios/footers/index');
                    
        }
        */

        if ($tipo_proyecto == 'Congreso' || $tipo_proyecto == 'Coloquio') {

            #VERIFICAMOS SI TIENE PONENCIAS REGISTRADAS

            $condiciones = [
                "claveCuerpo" => $_SESSION["CA"],
                'anio' => $nombre_explode[2],
                'nombre_congreso' => $nombre
            ];

            $ponencias = $this->UserModel->getAll("ponencias", $condiciones);

            if (empty($ponencias)) {
                #NO TIENE NINGUNA PONENCIA REGISTRADA, VAMOS A VER SI NO TIENE DE OYENTE
                $condiciones = [
                    'claveCuerpo' => $_SESSION['CA'],
                    'red' => $nombre_explode[1],
                    'anio' => $nombre_explode[2],
                ];
                if ($this->UserModel->exist('participantes_congresos', $condiciones)) {
                    #Existen gafetes de oyentes, vamos a tomarlos
                    $gafetes_oyentes = $this->UserModel->getAll('participantes_congresos', $condiciones);
                    foreach ($gafetes_oyentes as $keygo => $go) {
                        $condiciones = ['usuario' => $go['usuario']];
                        $columnas = ['profile_pic'];
                        $profile_pic = $this->UserModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
                        $profile_pic = empty($profile_pic) ? '' : $profile_pic['profile_pic'];
                        $gafetes_oyentes[$keygo]['profile_pic'] = $profile_pic;
                    }
                    $data['gafetes'] = $gafetes_oyentes;
                }
                #TOMANDO DATOS 
                $ponencias_disponibles = 0;
                $ponencias_pendientes = 0;
                $condiciones = ['id_proyecto' => $infoProyecto['id'], 'claveCuerpo' => $_SESSION['CA']];
                $columnas = ['restante', 'tipo_registro'];
                $proyectos_ca = $this->UserModel->getAllColums($columnas, 'pagos', $condiciones);

                foreach ($proyectos_ca as $row) {
                    if ($row['restante'] != 0) {
                        $ponencias_pendientes++;
                    } else if ($row['restante'] == 0) {
                        $ponencias_disponibles++;
                    }
                }
                if (isset($data['gafetes'])) {
                    $ponencias_disponibles--;
                }
                $data['ponencias_disponibles'] = $ponencias_disponibles;
                $data['ponencias_pendientes'] = $ponencias_pendientes;
                $data['nombre_congreso'] = $nombre;
            } else {
                #TIENE PONENCIAS REGISTRADAS
                $data['nombre_congreso'] = $nombre;
                $c_ponencias_registradas = 0;
                foreach ($ponencias as $key => $p) {
                    #obtenemos la info de la ponencia y las claves de gafete
                    $condiciones = ['publication_id' => $p['publication_id']];
                    $gafetes_ponencia = $this->UserModel->getAll('participantes_congresos', $condiciones);
                    foreach ($gafetes_ponencia as $keygp => $gp) {
                        $condiciones = ['usuario' => $gp['usuario']];
                        $columnas = ['profile_pic'];
                        $profile_pic = $this->UserModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
                        $profile_pic = empty($profile_pic) ? '' : $profile_pic['profile_pic'];

                        $infoGafetesPonencia[$keygp] = [
                            'nombre' => $gp['nombre'],
                            'clave_gafete' => $gp['clave_gafete'],
                            'oyente' => $gp['oyente'],
                            'tipo_asistencia' => $gp['tipo_asistencia'],
                            'profile_pic' => $profile_pic
                        ];
                    }

                    $condiciones = ['clavePonencia' => $p['clave_ponencia']];
                    $comentarios_ponencia = $this->UserModel->getAll('comentarios', $condiciones);

                    $data['ponencias'][$key] = [
                        'publication_id' => $p['publication_id'],
                        'nombre' => $p['nombre'],
                        'clave_ponencia' => $p['clave_ponencia'],
                        'comentarios' => $comentarios_ponencia,
                        'gafetes' => $infoGafetesPonencia
                    ];
                    $c_ponencias_registradas++;
                }

                #VERIFICAMOS SI HAY GAFETES DE OYENTES SOLAMENTE

                $condiciones = [
                    'claveCuerpo' => $_SESSION['CA'],
                    'red' => $nombre_explode[1],
                    'anio' => $nombre_explode[2],
                    'oyente' => 1,
                    'publication_id' => 0,
                ];

                if ($this->UserModel->exist('participantes_congresos', $condiciones)) {
                    #Existen gafetes de oyentes, vamos a tomarlos
                    $gafetes_oyentes = $this->UserModel->getAll('participantes_congresos', $condiciones);
                    foreach ($gafetes_oyentes as $keygo => $go) {
                        $condiciones = ['usuario' => $go['usuario']];
                        $columnas = ['profile_pic'];
                        $profile_pic = $this->UserModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
                        $profile_pic = empty($profile_pic) ? '' : $profile_pic['profile_pic'];
                        $gafetes_oyentes[$keygo]['profile_pic'] = $profile_pic;
                    }
                    $data['gafetes'] = $gafetes_oyentes;
                    $c_ponencias_registradas++;
                }

                $ponencias_disponibles = 0;
                $ponencias_pendientes = 0;
                $condiciones = ['id_proyecto' => $infoProyecto['id'], 'claveCuerpo' => $_SESSION['CA']];
                $columnas = ['restante', 'tipo_registro'];
                $proyectos_ca = $this->UserModel->getAllColums($columnas, 'pagos', $condiciones);

                foreach ($proyectos_ca as $row) {
                    if ($row['restante'] != 0) {
                        $ponencias_pendientes++;
                    } else if ($row['restante'] == 0) {
                        $ponencias_disponibles++;
                    }
                }

                $data['ponencias_disponibles'] = $ponencias_disponibles - $c_ponencias_registradas;
                $data['ponencias_pendientes'] = $ponencias_pendientes;
            }


            #HACEMOS UN SEGUNDO FILTRO PARA SACAR SOLAMENTE LAS DE CONGRESO Y DEL AÑO EN CUESTION

            /*
            POSIBLEMENTE BORRAR
            $filtro_ponencia = [];

            foreach($ponencia as $p){

                $fecha = $p['fecha_insercion'];

                $explode_fecha = explode('-',$fecha);
                
                $anio_db = $explode_fecha[0]; #ESTE ES EL ANIO DEL REGISTRO DE LA PONENCIA

                $nombre_congreso = $tipo_proyecto . ' ' . $_SESSION['red'] . ' ' . $anio_db;

                $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'nombre_congreso' => $nombre_congreso, 'id' => $p['id']];

                $proyectos_congreso = $this->UserModel->getAllOneRow('ponencias',$condiciones);

                if(!empty($proyectos_congreso)){
                    $filtro_ponencia[] = $proyectos_congreso;
                }
            
            }
            */


            /*
            pendiente de revision
            if (!empty($filtro_ponencia)) {

                //Existe, hay que sacar la info

                $data = [];

                $data['nombre_completo_usuario'] = $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

                $data["nombre_congreso"] = $nombre;

                $x = 0;

                foreach ($filtro_ponencia as $p) {

                    $data["ponencias"]["ponencia$x"]["nombre"] = $p["nombre"];

                    $data["ponencias"]["ponencia$x"]["pub_id"] = $p["publication_id"];

                    $data["ponencias"]["ponencia$x"]["clave_ponencia"] = $p["clave_ponencia"];

                    $condiciones = array("publication_id" => $p["publication_id"]);

                    $autores = $this->UserModel->getAll("participantes_congresos", $condiciones);

                    $i = 0;

                    foreach ($autores as $autor) {

                        $data["ponencias"]["ponencia$x"]["autores"][$i]["nombre"] = $autor["nombre"];

                        $data["ponencias"]["ponencia$x"]["autores"][$i]["gafete"] = $autor["clave_gafete"];

                        $i++;
                    }

                    $x++;
                }



                $array = array();

                $i = 0;

                $condiciones = ['claveCuerpo' => $_SESSION['CA']];

                $pagos = $this->UserModel->getAll('pagos',$condiciones);

                foreach ($pagos as $pago) {

                    $explode = explode(" ", $pago["proyecto"]);

                    if ($explode[0] == "Congreso") {

                        if ($pago["restante"] == 0) {

                            $cantidad_ponencias++;
                        } else {

                            $cantidad_ponencias_pendientes++;
                        }
                    }
                }

                $data["cantidad_de_ponencias"] = $cantidad_ponencias;

                $data["cantidad_ponencias_pendientes"] = $cantidad_ponencias_pendientes;

                $tipo_registro = $this->UserModel->getAllOneRow("cuerpos_academicos", $condicion);

                $data["tipo_registro"] = $tipo_registro["tipo_registro"];

            } else {

                //no existe un registro de poenncia, mando la vista general
                $condiciones = ['claveCuerpo' => $_SESSION['CA']];

                $pagos = $this->UserModel->getAll('pagos',$condiciones);

                foreach ($pagos as $pago) {

                    $explode = explode(" ", $pago["proyecto"]);

                    if ($explode[0] == "Congreso") {

                        if ($pago["restante"] == 0) {

                            $cantidad_ponencias++; //Ponencias disponibles

                        } else {

                            $cantidad_ponencias_pendientes++; //Ponencias pendientes

                        }
                    }
                }
                $data["cantidad_de_ponencias"] = $cantidad_ponencias;

                $data["cantidad_ponencias_pendientes"] = $cantidad_ponencias_pendientes;

                $data['nombre_completo_usuario'] = $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

                $data["nombre_congreso"] = $nombre;

            }
            */

            #PRIMERO, DEBEMOS SABER SI YA PAGARON O NO, PARA TOMAR UNA INSTRUCCION
            #verificamos cuantos proyectos de congreso tiene, los recorremos para saber si hay que dejarle el despues o el antes
            $condiciones = ['id_proyecto' => $infoProyecto['id'], 'claveCuerpo' => $_SESSION['CA']];
            $columnas = ['restante', 'tipo_registro'];

            $proyectos_ca = $this->UserModel->getAllColums($columnas, 'pagos', $condiciones);
            $tipo_instruccion = 'despues';
            foreach ($proyectos_ca as $row) {
                if ($row['restante'] > 0) {
                    $tipo_instruccion = 'antes';
                    break;
                }
            }

            $condiciones = [
                'red' => $nombre_explode[1],
                'anio' => $nombre_explode[2],
                'tipo' => $nombre_explode[0],
                'tipo_instruccion' => $tipo_instruccion
            ];

            $instrucciones = $this->UserModel->getAllOneRow('instrucciones_investigaciones', $condiciones);

            if (!empty($instrucciones)) {
                $instrucciones['instrucciones'] = str_replace('$claveCuerpo', $_SESSION['CA'], $instrucciones['instrucciones']);
                $instrucciones['instrucciones'] = str_replace('$usuario', $_SESSION['nombre_completo'], $instrucciones['instrucciones']);
                $data['instrucciones'] = $instrucciones['instrucciones'];
            }

            $data['anio_congreso'] = $nombre_explode[2];

            if (isset($horario_ponencias_congreso)) {
                $data['horario_ponencias_congreso'] = $horario_ponencias_congreso;
            }
            //echo $instrucciones;
            echo '<pre>';
            #print_r($data);
            echo '</pre>';
            #exit;


            return view('usuarios/headers/index', $data)
                . view('usuarios/congreso', $data)
                . view('usuarios/footers/index');
        }

        if ($tipo_proyecto == 'Oyente') {

            $oyentes_disponibles = 0;
            $oyentes_pendientes = 0;
            $condiciones = ['id_proyecto' => $infoProyecto['id'], 'claveCuerpo' => $_SESSION['CA']];
            $columnas = ['restante', 'tipo_registro'];
            $proyectos_ca = $this->UserModel->getAllColums($columnas, 'pagos', $condiciones);

            foreach ($proyectos_ca as $row) {
                if ($row['restante'] != 0) {
                    $oyentes_pendientes++;
                } else if ($row['restante'] == 0) {
                    $oyentes_disponibles++;
                }
            }

            $condiciones = [
                'claveCuerpo' => $_SESSION['CA'],
                'red' => $nombre_explode[1],
                'anio' => $nombre_explode[2]
            ];

            if ($this->UserModel->exist('participantes_congresos', $condiciones)) {
                #Existen gafetes de oyentes, vamos a tomarlos

                $gafetes_oyentes = $this->UserModel->getAll('participantes_congresos', $condiciones);

                foreach ($gafetes_oyentes as $keygo => $go) {



                    $condiciones = ['usuario' => $go['usuario']];
                    $columnas = ['profile_pic'];
                    $profile_pic = $this->UserModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
                    $profile_pic = empty($profile_pic) ? '' : $profile_pic['profile_pic'];

                    if ($oyentes_disponibles != 0 && $go['usuario'] == $_SESSION['usuario']) {
                        $oyentes_disponibles--;
                    }
                }
                $data['gafetes'] = $gafetes_oyentes;
            }

            $data = [
                'nombre_congreso' => $nombre,
                'oyentes_pendientes' => $oyentes_pendientes,
                'oyentes_disponibles' => $oyentes_disponibles,
                'anio_congreso' => $nombre_explode[2]
            ];

            if (isset($gafetes_oyentes)) {
                $data['gafetes'] = $gafetes_oyentes;
            }

            #PRIMERO, DEBEMOS SABER SI YA PAGARON O NO, PARA TOMAR UNA INSTRUCCION
            #verificamos cuantos proyectos de congreso tiene, los recorremos para saber si hay que dejarle el despues o el antes
            $condiciones = ['id_proyecto' => $infoProyecto['id'], 'claveCuerpo' => $_SESSION['CA']];
            $columnas = ['restante', 'tipo_registro'];

            $proyectos_ca = $this->UserModel->getAllColums($columnas, 'pagos', $condiciones);
            $tipo_instruccion = 'despues';
            foreach ($proyectos_ca as $row) {
                if ($row['restante'] >= 0) {
                    $tipo_instruccion = !isset($data['gafetes']) ? 'antes' : 'despues';
                    break;
                }
            }
            #AHORA SAEMOS QUE INSTRUCCIONES TOMAR

            $condiciones = [
                'red' => $nombre_explode[1],
                'anio' => $nombre_explode[2],
                'tipo' => $nombre_explode[0],
                'tipo_instruccion' => $tipo_instruccion
            ];

            $instrucciones = $this->UserModel->getAllOneRow('instrucciones_investigaciones', $condiciones);

            if (!empty($instrucciones)) {
                $instrucciones['instrucciones'] = str_replace('$claveCuerpo', $_SESSION['CA'], $instrucciones['instrucciones']);
                $instrucciones['instrucciones'] = str_replace('$usuario', $_SESSION['nombre_completo'], $instrucciones['instrucciones']);
                $data['instrucciones'] = $instrucciones['instrucciones'];
            }

            return view('usuarios/headers/index', $data)
                . view('usuarios/oyente', $data)
                . view('usuarios/footers/index');

            exit;

            $cantidad_oyente = 0;

            $cantidad_oyente_pendientes = 0;

            $condiciones = ['claveCuerpo' => $_SESSION['CA']];

            $pagos = $this->UserModel->getAll('pagos', $condiciones);

            #HACEMOS UN SEGUNDO FILTRO PARA SACAR SOLAMENTE LOS PROYECTOS DE OYENTE Y DEL AÑO EN CUESTION

            $filtro_pagos = [];

            foreach ($pagos as $p) {

                $fecha = $p['fecha_registro'];

                $explode_fecha = explode('-', $fecha);

                $anio_db = $explode_fecha[0]; #ESTE ES EL ANIO DEL REGISTRO DEL PROYECTO

                $nombre_proyecto = $tipo_proyecto . ' ' . $_SESSION['red'] . ' ' . $anio_db;

                $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'proyecto' => $nombre_proyecto, 'id' => $p['id']];

                $proyectos_oyente = $this->UserModel->getAllOneRow('pagos', $condiciones);

                if (!empty($proyectos_oyente)) {

                    $filtro_pagos[] = $proyectos_oyente;
                }
            }

            #RECORREMOS EL ARREGLO QUE HICIMOS

            foreach ($filtro_pagos as $pago) {

                $explode = explode(" ", $pago["proyecto"]);

                if ($explode[0] == "Oyente") {

                    if ($pago["restante"] == 0) {

                        #YA PAGO UN PROYECTO DE OYENTE, VERIFICAMOS SI YA TIENE CLAVE GAFETE

                        $cantidad_oyente++;

                        $data['pagado'] = 1;

                        $condiciones = ['oyente' => 1, 'red' => $_SESSION['red'], 'usuario' => $_SESSION['usuario'], 'claveCuerpo' => $_SESSION['CA']];

                        $existe = $this->UserModel->getAllOneRow('participantes_congresos', $condiciones);

                        if (!empty($existe)) {

                            $data['gafete']['clave_gafete'] = $existe['clave_gafete'];

                            $data['gafete']['nombre'] = $existe['nombre'];
                        }
                    } else {

                        $cantidad_oyente_pendientes++;
                    }
                }
            }

            #PRIMERO, DEBEMOS SABER SI YA PAGARON O NO, PARA TOMAR UNA INSTRUCCION
            #verificamos cuantos proyectos de congreso tiene, los recorremos para saber si hay que dejarle el despues o el antes
            $condiciones = ['id_proyecto' => $infoProyecto['id'], 'claveCuerpo' => $_SESSION['CA']];
            $columnas = ['restante', 'tipo_registro'];

            $proyectos_ca = $this->UserModel->getAllColums($columnas, 'pagos', $condiciones);
            $tipo_instruccion = 'despues';
            foreach ($proyectos_ca as $row) {
                if ($row['restante'] > 0) {
                    $tipo_instruccion = 'antes';
                    break;
                }
            }
            #AHORA SAEMOS QUE INSTRUCCIONES TOMAR
            echo '<pre>';
            #print_r($proyectos_ca);
            echo '</pre>';

            $condiciones = [
                'red' => $nombre_explode[1],
                'anio' => $nombre_explode[2],
                'tipo' => $nombre_explode[0],
                'tipo_instruccion' => $tipo_instruccion
            ];

            $instrucciones = $this->UserModel->getAllOneRow('instrucciones_investigaciones', $condiciones);

            if (!empty($instrucciones)) {
                $instrucciones['instrucciones'] = str_replace('$claveCuerpo', $_SESSION['CA'], $instrucciones['instrucciones']);
                $instrucciones['instrucciones'] = str_replace('$usuario', $_SESSION['nombre_completo'], $instrucciones['instrucciones']);
                $data['instrucciones'] = $instrucciones['instrucciones'];
            }

            $data['nombre_completo_usuario'] = $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

            $data["nombre_congreso"] = $nombre;

            $data["cantidad_oyente"] = $cantidad_oyente;

            $data["cantidad_oyente_pendientes"] = $cantidad_oyente_pendientes;

            if (isset($horario_ponencias_congreso)) {
                $data['horario_ponencias_congreso'] = $horario_ponencias_congreso;
            }

            //print_r($data);

            return view('usuarios/headers/index', $data)
                . view('usuarios/oyente', $data)
                . view('usuarios/footers/index');
        }

        if ($tipo_proyecto == 'Esquema') {

            #TOMAMOS SUS CARPETAS DE LA BD

            $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'ano_carpeta' => $anio];

            $existe = $this->UserModel->exist('carpetas', $condiciones);

            if (empty($existe)) {

                $_SESSION["proyecto"] = "Ha ocurrido un problema, favor de reportar a sistemas";
            } else {

                $data["info"] = [];

                #$condiciones = ['oyente' => 1, 'red' => $_SESSION['red'], 'claveCuerpo' => $_SESSION['CA']];

                #$selectDatosProyecto = $this->UserModel->getAll("participantes_congresos", $condiciones);

                #$data["info"]["infoGafetes"] = $selectDatosProyecto;

                #TOMAMOS LA CARPETA COMUN DE LA RED DE ESE AñO

                $condiciones_carpetas_comunes = ["red" => $_SESSION["red"], "anio" => $anio];

                $carpetas_comunes = $this->UserModel->getAllOneRow("carpetas_comunes", $condiciones_carpetas_comunes);

                $data["info"]["carpetas_comunes"] = $carpetas_comunes;

                $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'red' => $_SESSION['red'], 'ano_carpeta' => $anio];

                $carpetas = $this->UserModel->getAllOneRow('carpetas', $condiciones);

                $data["info"]["carpeta"] = $carpetas;

                $nombre = urldecode($nombre);

                $condiciones = ["nombre_proyecto" => $nombre, "claveCuerpo" => $_SESSION["CA"], "redCueCa" => $_SESSION["red"]];

                $validacion = $this->UserModel->getAll("validacion", $condiciones);

                $data["info"]["validacion"] = $validacion;

                $condicion_ca = ["claveCuerpo" => $_SESSION["CA"]];

                $ca = $this->UserModel->getAllOneRow("cuerpos_academicos", $condicion_ca);

                $data["info"]["password"] = $ca["password"];



                $miembros = $this->UserModel->miembros_actuales($_SESSION["CA"]);

                $condiciones = [
                    'red' => $nombre_explode[3],
                    'anio' => $nombre_explode[4],
                    'tipo' => $nombre_explode[2]
                ];

                if ($this->UserModel->exist('instrucciones_investigaciones', $condiciones)) {
                    /*
                    if($_SESSION['CA'] != 'CG-nMWmBBKn7B'){
                        return redirect()->back()
                        ->with('icon', 'warning')
                        ->with('title', 'Trabajando 👨‍💻')
                        ->with('text', 'El módulo aún no se encuestra disponible');
                    }
                    */
                    $instruccion_investigacion = $this->UserModel->getAllOneRow('instrucciones_investigaciones', $condiciones);
                    $data['instruccion_investigacion'] = $instruccion_investigacion;
                    #VAMOS A OBTENER DATOS PARA EL RESUMEN
                    $nombre_tabla_cuestionarios = 'cuestionarios_' . strtolower($nombre_explode[3]) . '_' . $nombre_explode['4'];
                    $db = db_connect('cuestionarios');
                    if (!$db->tableExists($nombre_tabla_cuestionarios) && $_SESSION['red'] != 'Releg') {
                        return redirect()->to(base_url('inicio/'.$_SESSION['red'].'/'.$_SESSION['CA']))
                            ->with('icon', 'warning')
                            ->with('title', 'Trabajando 👨‍💻')
                            ->with('text', 'El módulo aún no se encuentra disponible');
                    }


                    if ($_SESSION["red"] == "Releg") {

                        $data['info']['nombre_esquema'] = $nombre;

                        $data['info']['esquema'] = str_replace(':', '', $nombre_explode[1]);

                        $condiciones = array("claveCuerpo" => $_SESSION["CA"]);

                        $entrevistas = $this->UserModel->getAll("entrevistas_Relmo", $condiciones);

                        $data["info"]["entrevistas"] = $entrevistas;

                        $condiciones = ['claveCuerpo' => $_SESSION['CA']];

                        $categorias_propuestas = $this->UserModel->getAll('categorias', $condiciones);

                        $data['info']['propuestas'] = $categorias_propuestas;

                        #OBTENEMOS LAS CATEGORIAS
                        $condiciones = ['activo' => 1];
                        $categorias = $this->UserModel->getAll('categorias', $condiciones);
                        $data['info']['categorias'] = $categorias;

                        #OBTENEMOS LOS COLORES

                        foreach ($data["info"]["entrevistas"] as $key => $e) {

                            $condiciones = ['id_entrevista' => $e['id']];
                            $columnas = ['categoria'];
                            $existeCategoria = $this->UserModel->getColumnsOrderBy($columnas, 'filtro_categorias', $condiciones, 'categoria ASC');
                            $colores = [];
                            foreach ($existeCategoria as $c) {
                                $condiciones = ['id' => $c['categoria']];
                                $color = $this->UserModel->getAllOneRow('categorias', $condiciones);
                                $color = $color['color'];
                                array_push($colores, $color);
                            }
                            $data["info"]["entrevistas"][$key]['colores'] = $colores;
                        }

                        #OBTENEMOS EL ORDEN IMPRESO Y DIGITAL
                        $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'anio' => $nombre_explode['4']];
                        $columnas = ['orden_impreso', 'orden_digital', 'usuario'];
                        $orden_libros = $this->UserModel->getColumnsOneRow($columnas, 'ordenes_autores', $condiciones);
                        if (!empty($orden_libros)) {
                            if ($orden_libros['orden_impreso'] == 0 || $orden_libros['orden_impreso'] == '') {
                                $data['info']['impreso'] = 1;
                                $data['info']['digital'] = 0;
                            } else if ($orden_libros['orden_digital'] == 0 || $orden_libros['orden_digital'] == '') {
                                $data['info']['digital'] = 1;
                                $data['info']['impreso'] = 0;
                            } else if ($orden_libros['orden_digital'] != 0 && $orden_libros['orden_digital'] != 0) {
                                $data['info']['digital'] = 0;
                                $data['info']['impreso'] = 0;
                            }
                        } else {
                            $data['info']['digital'] = 1;
                            $data['info']['impreso'] = 1;
                        }

                        //Vamos a ver si ya tiene discusion o no

                        $resultados_impreso = $this->getResultadosRelegImpreso();
                        $pdf = new TCPDF();
                        $pdf->SetPrintHeader(false);
                        $pdf->SetPrintFooter(false);
                        $pdf->SetAutoPageBreak(true, 35);
                        $pdf->SetAuthor('REDESLA');
                        $pdf->SetCreator('REDESLA');
                        $pdf->SetTitle("Resultados investigación Releg");
                        $pdf->AddPage();
                        $pdf->SetFont('Times', '', 11);
                        // Luego, agrega el contenido HTML
                        $pdf->writeHTML($resultados_impreso, true, false, true, false);

                        $file_name = 'Resultados_Releg_' . strval(time()).'.pdf';

                        $pdfPath = ROOTPATH . "/public/zip/pdf_temporales/{$file_name}";
                        $data['info']['pdfPath'] = $file_name;
                        $pdf->Output($pdfPath, 'F');
                    }

                        $condiciones = ['claveCuerpo' => $_SESSION['CA']];
                        $columnas = ['discusion'];

                        $discusion_info = $this->UserModel->getColumnsOneRow($columnas,'capitulos_releg',$condiciones);
                        $discusion_exist = false;
                        $discusion = '';
                        $resultados_impreso = '';
                        if(isset($discusion_info)){
                            if(!empty($discusion_info['discusion'])){
                                $discusion_exist = true;
                                $discusion = $discusion_info['discusion'];
                        }
                        $data['info']['discusion_exist'] = $discusion_exist;
                        $data['info']['discusion'] = $discusion;
                        $data['info']['resultados_impreso'] = $resultados_impreso;

                        $data['info']['anio_investigacion'] = $nombre_explode['4'];
                        return view('usuarios/headers/index', $data)
                            . view('usuarios/proyectos/esquemas', $data)
                            . view('usuarios/esquemas', $data)
                            . view('usuarios/footers/index');
                    }

                    $data['investigacion']['anio_investigacion'] = $nombre_explode['4'];
                    #OBTENEMOS EL ORDEN IMPRESO Y DIGITAL
                    $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'anio' => $nombre_explode['4']];
                    $columnas = ['orden_impreso', 'orden_digital', 'usuario'];
                    $orden_libros = $this->UserModel->getColumnsOneRow($columnas, 'ordenes_autores', $condiciones);
                    if (!empty($orden_libros)) {
                        if ($orden_libros['orden_impreso'] == 0 || $orden_libros['orden_impreso'] == '') {
                            $data['investigacion']['impreso'] = 1;
                            $data['investigacion']['digital'] = 0;
                        } else if ($orden_libros['orden_digital'] == 0 || $orden_libros['orden_digital'] == '') {
                            $data['investigacion']['digital'] = 1;
                            $data['investigacion']['impreso'] = 0;
                        } else if ($orden_libros['orden_digital'] != 0 && $orden_libros['orden_digital'] != 0) {
                            $data['investigacion']['digital'] = 0;
                            $data['investigacion']['impreso'] = 0;
                        }
                    } else {
                        $data['investigacion']['digital'] = 1;
                        $data['investigacion']['impreso'] = 1;
                    }


                    $condiciones = ['estado' => 0, 'claveCuerpo' => $_SESSION['CA']];
                    $c_pendientes = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
                    $condiciones = ['estado !=' => 0, 'claveCuerpo' => $_SESSION['CA']];
                    $c_completadas = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);

                    #CANTIDAD DE CADA ESTADO
                    $condiciones = ['estado' => 1, 'claveCuerpo' => $_SESSION['CA']];
                    $estado_1 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
                    $condiciones = ['estado' => 2, 'claveCuerpo' => $_SESSION['CA']];
                    $estado_2 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
                    $condiciones = ['estado' => 3, 'claveCuerpo' => $_SESSION['CA']];
                    $estado_3 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
                    $condiciones = ['estado' => 4, 'claveCuerpo' => $_SESSION['CA']];
                    $estado_4 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
                    $condiciones = ['estado' => 5, 'claveCuerpo' => $_SESSION['CA']];
                    $estado_5 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);

                    $cantidad_minima = 384;

                    if (!empty($c_completadas)) {
                        $pocentaje_completado = ($estado_1 * 100) / $cantidad_minima;
                        $pocentaje_completado = round($pocentaje_completado, 2);
                        $pocentaje_completado = $pocentaje_completado > 100 ? 100 : $pocentaje_completado;
                    } else {
                        $pocentaje_completado = 0;
                    }

                    #obtenemos la password
                    $condiciones = ['claveCuerpo' => $_SESSION['CA']];
                    $columnas = ['password'];
                    $password = $this->UserModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);


                    $data['investigacion']['password'] = $password['password'];
                    $data['investigacion']['entrevistas_pendientes'] = $c_pendientes;
                    $data['investigacion']['entrevistas_completadas'] = $c_completadas;
                    $data['investigacion']['pocentaje_completado'] = $pocentaje_completado;
                    $data['investigacion']['estado_1'] = $estado_1;
                    $data['investigacion']['estado_2'] = $estado_2;
                    $data['investigacion']['estado_3'] = $estado_3;
                    $data['investigacion']['estado_4'] = $estado_4;
                    $data['investigacion']['estado_5'] = $estado_5;
                    $data['investigacion']['nombre_tabla'] = $nombre_tabla_cuestionarios;
                    $data['investigacion']['esquema'] = str_replace(':', '', $nombre_explode[1]);
                    $data['investigacion']['nombre_esquema'] = $nombre;
                    if (!empty($validacion)) {
                        $data["investigacion"]["validacion"] = $validacion[0]['terminado'];
                    }



                    return view('usuarios/headers/index', $data)
                        . view('usuarios/proyectos/esquemas', $data)
                        . view('usuarios/esquemas', $data)
                        . view('usuarios/footers/index');
                } else {
                    $data["info"]["miembros"] = $miembros;

                    $data['info']['nombre_esquema'] = $nombre;
                    return view('usuarios/headers/index', $data)
                        . view('usuarios/proyectos/index', $data)
                        . view('usuarios/esquemas', $data)
                        . view('usuarios/footers/index');
                }
            }

            #LAS VISTAS SON DE ESTA MANERA YA QUE LA EMPRESA ES MUY PROTENSA A CAMBIOS
            #CAMBIOS EN UN PROYECTO, PERO EN OTRO NO, Y ASI, EN VEZ DE MUCHISIMAS CONDICIONES
            #HAZ UNA VISTA PARA CADA PROYECTO Y MODIFICALO AHI. ES MAS TEDIOSO PERO MAS PERSONALIZABLE

            /*
            return view('usuarios/headers/index',$data)
            .view('usuarios/proyectos/index',$data)
            .view('usuarios/esquemas',$data)
            .view('usuarios/footers/index');
            */
        }

        /*if ($tipo_proyecto == 'Investigación') {

            $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'ano_carpeta' => $anio];

            $carpetas = $this->UserModel->exist('carpetas', $condiciones);

            if (empty($carpetas)) {

                $_SESSION["proyecto"] = "Ha ocurrido un problema, favor de reportar a sistemas";
            } else {

                $data["info"] = [];

                $selectDatosProyecto = $this->UserModel->getAllOneCondition("participantes_congresos", "anio", date("Y"), "red", $_SESSION["red"]);

                $data["info"]["infoGafetes"] = $selectDatosProyecto;

                $condiciones_carpetas_comunes = array(

                    "red" => $_SESSION["red"],

                    "anio" => $anio

                );

                $carpetas_comunes = $this->UserModel->getAllOneRow("carpetas_comunes", $condiciones_carpetas_comunes);



                $data["info"]["carpetas_comunes"] = $carpetas_comunes;

                $carpetas = $this->UserModel->carpeta($_SESSION["CA"], $anio);

                $data["info"]["carpeta"] = $carpetas;

                $nombre = urldecode($nombre);

                $condiciones = array(

                    "nombre_proyecto" => $nombre,

                    "claveCuerpo" => $_SESSION["CA"],

                    "redCueCa" => $_SESSION["red"]

                );

                $validacion = $this->UserModel->getAll("validacion", $condiciones);

                $data["info"]["validacion"] = $validacion;

                $condicion_ca = ["claveCuerpo" => $_SESSION["CA"]];

                $ca = $this->UserModel->getAllOneRow("cuerpos_academicos", $condicion_ca);

                $data["info"]["password"] = $ca["password"];
            }

            echo '<pre>';
            print_r($data);
            echo '</pre>';

            //$this->load->view("inicio/proyecto", $data);
        }*/

        if ($tipo_proyecto == 'Desafío') {

            #DESAFIO ACTUALMENTE 03/10/2022 ES SOLAMENTE PARA RELEEM, SOLAMENTE SE MUESTRA UNA VISTA, NO OCUPAMOS NADA

            $data["info"] = [];

            $data['info']['nombre'] = 'Desafío ' . $_SESSION['red'] . ' ' . $anio;

            $data['info']['nombre_esquema'] = $nombre;

            return view('usuarios/headers/index', $data)
                . view('usuarios/proyectos/index', $data)
                . view('usuarios/esquemas', $data)
                . view('usuarios/footers/index');
        }
    }

    private function getResultadosRelegImpreso(){
        $claveCuerpo = $_SESSION['CA'];
        $condiciones = [
            'claveCuerpo' => $claveCuerpo,
            'anio' => 2022
        ];
        #MXM-UAEH02
        $capitulo = $this->UserModel->getAllOneRow('capitulos_releg', $condiciones);

        if (empty($capitulo)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El equipo no tiene un capítulo registrado. Codigo de error: 100');
        }

        for ($i = 1; $i <= 5; $i++) {
            $name = 'categoria_' . $i;
            $explode_categoria = explode(';', $capitulo[$name]);

            #extraemos la categoria
            $condiciones = ['id' => $explode_categoria[0]];
            $info_categoria = $this->UserModel->getAllOneRow('categorias', $condiciones);

            $explode_codigos = explode(',', $explode_categoria[1]);
            $grupos = array_chunk($explode_codigos, 2);
            $str_info_codigos = '';
            foreach ($grupos as $key => $g) {
                $id_entrevista = $g[0];
                $id_codigo_en_vivo = $g[1];
                $condiciones = ['id' => $id_codigo_en_vivo];
                $info_codigo = $this->UserModel->getAllOneRow('filtro_categorias', $condiciones);
                $columnas = ['pregunta1', 'pregunta2', 'pregunta3', 'pregunta4', 'pregunta12', 'pregunta6', 'pregunta10'];
                $condiciones = ['id' => $id_entrevista];
                $entrevista = $this->UserModel->getColumnsOneRow($columnas, 'entrevistas_Relmo', $condiciones);
                $caracteristicas = 'Estudiante universitaria de ' . $entrevista['pregunta1'] . ' años, ' . $entrevista['pregunta2'];
                $tipo_institucion = $entrevista['pregunta12'] == 'público' ? 'pública' : 'privada';
                $condiciones = ['id' => $entrevista['pregunta10']];
                $estado = $this->UserModel->getAllOneRow('estados', $condiciones);
                $estado = empty($estado) ? $entrevista['pregunta10'] : $estado['nombre'];
                $caracteristicas .= ', de ' . $entrevista['pregunta6'] . ', institución ' . $tipo_institucion . '.';
                $caracteristicas = rtrim($caracteristicas, ', ');
                $caracteristicas = ucfirst(strtolower($caracteristicas));
                $info = "<p style='font-family: Herlvetica; font-size: 12pt;text-align: center;'>Entrevista {$id_entrevista}. {$caracteristicas}</p>";
                $caracter = '"';
                $str_info_codigos .= "<label style='font-family: Herlvetica; font-size: 12pt;text-align: center;'><i>{$caracter}{$info_codigo['codigo_en_vivo']}{$caracter}</i>.<div style='display: inline-block;height: 1em;'></div>{$info}<div style='height: 1em;'></div></label><div style='height: 1em;'></div>";
                # "sdkbfjsdvfjsdvf". 
                $dataCodigos[$key] = [
                    'id_entrevista' => $id_entrevista,
                    'codigo_en_vivo' => $info_codigo['codigo_en_vivo'],
                    'descripcion' => $info,
                    'id_codigo' => $id_codigo_en_vivo
                ];
            }

            $dataCategoria[$i] = [
                'id' => $info_categoria['id'],
                'nombre_categoria' => $info_categoria['nombre'],
                'descripcion_categoria' => $info_categoria['descripcion'],
                'codigos' => $dataCodigos,
                'analisis' => $explode_categoria[2],
                'str_info_codigos' => str_replace("\n", '', $str_info_codigos),
            ];

            $explode_observaciones = explode(';', $capitulo['observaciones']);
            if (isset($explode_observaciones[$i - 1])) {
                $explode_observaciones_2 = explode('~', $explode_observaciones[$i - 1]);
                if (isset($explode_observaciones_2[1])) {
                    $dataCategoria[$i]['observaciones'] = $explode_observaciones_2[1];
                } else {
                    $dataCategoria[$i]['observaciones'] = '';
                }
            } else {
                $dataCategoria[$i]['observaciones'] = '';
            }
        }


        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['nombre', 'municipio', 'estado'];
        $universidad = $this->UserModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        $condiciones = ['id' => $universidad['estado']];
        $estado = $this->UserModel->getAllOneRow('estados', $condiciones);
        $nombre_estado = empty($estado) ? $universidad['estado'] : $estado['nombre'];

        $condiciones = ['id' => $universidad['municipio']];
        $municipio = $this->UserModel->getAllOneRow('municipios', $condiciones);
        $nombre_mun = empty($municipio) ? $universidad['municipio'] : $municipio['nombre'];

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $municipios_adicionales = $this->UserModel->getAll('municipios_ca', $condiciones);

        if (empty($municipios_adicionales)) {
            $str_municipios = $nombre_mun;
        } else {
            $str_municipios = $nombre_mun;
            foreach ($municipios_adicionales as $key2 => $m) {
                $str_municipios .= ', ' . $m['nombre_municipio'];
            }
        }

        $columnas = ['categoria'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $categorias = $this->UserModel->getAllDistinc($columnas, "filtro_categorias", $condiciones);
        if (empty($categorias)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'No tiene categorias registradas para continuar.');
        }


        $str_categorias = '';
        foreach ($categorias as $key => $c) {
            $data['categorias'][$key]['id'] = $c['categoria'];
            $condiciones = ['id' => $c['categoria']];
            $info_categoria = $this->UserModel->getAllOneRow('categorias', $condiciones);
            if (empty($info_categoria)) {
                echo 'No existe la categoria, ha existido un error y regresar';
                return;
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['categoria']];
            $cantidad = $this->UserModel->count('filtro_categorias', $condiciones);


            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];

            $columnas = ['id_entrevista'];

            $entrevistas = $this->UserModel->getAllDistinc($columnas, "filtro_categorias", $condiciones); #LO OCUPO PARA LA LISTA DE TODAS LAS ENTREVISTAS Y CODIGOS EN VIVO
            $arr_codigos_cat = [];
            $columnas = ['id_entrevista', 'codigo_en_vivo'];
            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];
            $codigos_categoria = $this->UserModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
            foreach ($entrevistas as $key_entrevistas => $e) {
                $data['categorias'][$key]['entrevistas'][] = $e['id_entrevista'];
            }


            $explode_nombre_categoria = explode(': ', $info_categoria['nombre']);
            $nombre_solo = substr($explode_nombre_categoria[1], 0, -1);
            $str_categorias .= $nombre_solo . ', ';


            $data['categorias'][$key]['nombre'] = $info_categoria['nombre'];
            $data['categorias'][$key]['descripcion'] = $info_categoria['descripcion'];
            $data['categorias'][$key]['color'] = $info_categoria['color'];
            $data['categorias'][$key]['cantidad'] = $cantidad;
            $data['categorias'][$key]['lista_codigos'] = $codigos_categoria;
        }


        $str_categorias = substr($str_categorias, 0, -2);

        $explode_cat = explode(', ', $str_categorias);
        $last_cat = end($explode_cat);
        $str_categorias = str_replace(", $last_cat", " y $last_cat", $str_categorias, $count);
        $str_categorias = strtolower($str_categorias);

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $countCodigos = $this->UserModel->count('filtro_categorias', $condiciones);
        $countEntrevistas = $this->UserModel->count('entrevistas_Relmo', $condiciones);

        if ($claveCuerpo == 'MXM-SCU01') {
            $universidad['nombre'] == 'SINCE Colegio Universitario, S.C.';
        }

        $data = [
            'enfoque' => $capitulo['enfoque'],
            'categorias' => $dataCategoria,
            'universidad_completo' => $universidad['nombre'] . ' en ' . $str_municipios . ', ' . $nombre_estado . '. México',
            'universidad' => $universidad['nombre'],
            'municipios' => $str_municipios . ', ' . $nombre_estado . '. México',
            'str_categorias' => $str_categorias,
            'c_codigos' => $countCodigos,
            'c_entrevistas' => $countEntrevistas,
            'id_capitulo' => $capitulo['id'],
            'claveCuerpo' => $capitulo['claveCuerpo'],
            'codigos_validos' => $capitulo['codigos_validos'],
            'analisis_validos' => $capitulo['analisis_validos'],
            'observaciones' => $capitulo['observaciones']
        ];

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['discusion'];

        $discusion_info = $this->UserModel->getColumnsOneRow($columnas,'capitulos_releg',$condiciones);
        $txt_discusion = 'Pendiente de redactar por el grupo de investigación.';
        if(isset($discusion_info)){
            if(!empty($discusion_info['discusion'])){
                $txt_discusion = $discusion_info['discusion'];
            }
        }
        /*
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
        */

        $html = "
        <p style='font-size: 14pt;font-weight: bold;'>Resultados</p>

        <label>En este apartado se presenta el análisis de resultados de la investigación cualitativa realizada a {$data['c_entrevistas']} estudiantes universitarias de {$data['universidad_completo']}.
        </label>
        
        <label>Las unidades de análisis son los párrafos que conforman las respuestas a las preguntas eje de este trabajo. A partir del análisis a estas unidades surgieron los códigos en vivo 
            que dieron origen a las categorías (Hernández Sampieri et al., 2014). 
        </label>
        
        <label>Las categorías que emergieron en esta institución de educación superior y que describen los obstáculos de las mujeres universitarias que dirigen una Mype son: 
            {$data['str_categorias']}. 
        </label>
        
        <label>Para fines de este capítulo, se determinó analizar las 5 categorías más importantes que describen los obstáculos que presentan las mujeres universitarias de 
            {$data['universidad']}, que dirigen o son dueñas de una micro o pequeña empresa. La importancia fue determinada a partir del orden y constancia con la que 
            fueron emergiendo a lo largo del proceso de análisis de las entrevistas. 
        </label>

        <label>Las categorías y su análisis se presentan a continuación:</label>
        </div>
        ";

        foreach ($data['categorias'] as $c) {
            $html .= "
                <p style='font-size: 14pt;font-weight: bold;font-family: Herlvetica;'>{$c['nombre_categoria']}</p>
                <p style='font-size: 12pt;font-family: Herlvetica;'>Descripción de la categoría:</p>
                <lable style='font-size: 12pt;font-family: Herlvetica;'>{$c['descripcion_categoria']}</lable><p></p>
                {$c['str_info_codigos']}
                <label style='font-size: 14pt;font-weight: bold;'>Análisis</label>
                <label style='font-size: 12pt;font-family: Herlvetica;'>{$c['analisis']}</label>
                <div style='height: 1em;'></div>
            ";
        }

        return $html;
    }

    public function verResultadosImpreso($img = null){
        if (!$img) {
            $img = $this->request->getGet('img');
        }
        if ($img == '') {
            throw PageNotFoundException::forPageNotFound();
        }

        $name = ROOTPATH . "public/zip/pdf_temporales/{$img}";

        if (!file_exists($name)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $fp = fopen($name, 'rb');

        $explode = explode('.', $img);

        if ($explode[1] == 'pdf') {
            header('Content-Type: application/pdf');
        } else if ($explode[1] == 'png') {
            header('Content-Type: image/png');
        } else if ($explode[1] == 'jpg') {
            header('Content-Type: image/jpg');
        } else if ($explode[1] == 'jpeg') {
            header('Content-Type: image/jpeg');
        }

        #ENVIA LAS CABECERAS CORRECTAS

        header('Content-Length: ' . filesize($name));

        #VUELCA LA IMAGEN Y DETIENE EL SCRIPT
        fpassthru($fp);
        exit;
    }

    public function getListadoCuestionarios($nombre_investigacion)
    {

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'folio', 'nombre_encuestador', 'estado'
        ];

        $_SESSION['nombre_investigacion'] = $nombre_investigacion;

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM $nombre_investigacion";
        $sql_data = "SELECT * FROM $nombre_investigacion";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    #$condicion .= " WHERE ".$val." LIKE '%".$valor_buscado."%'";
                    $condicion .= ' WHERE (claveCuerpo = "' . $_SESSION['CA'] . '") AND ( ' . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = empty($condicion) ? $sql_count . ' WHERE claveCuerpo = "' . $_SESSION['CA'] . '"' : $sql_count . $condicion . ')';

        $sql_data =  !empty($condicion) ? $sql_data . $condicion . ')' : $sql_data . ' WHERE claveCuerpo = "' . $_SESSION['CA'] . '"';

        $total_count = $this->db_serv->query($sql_count)->getRow();


        /*
        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();
        */

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        $columnas = ['password'];
        $condiciones = ['claveCuerpo' => $_SESSION['CA']];
        $ca = $this->UserModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
        $password = $ca['password'];
        $explode_tabla = explode('_', $nombre_investigacion);
        foreach ($array as $key => $a) {

            $c_nc = 0;

            foreach ($a as $key2 => $r) {
                $pregunta_solo_num = preg_replace('/[^0-9]/', '', $key2);
                if (ucfirst($explode_tabla[1]) == 'Relayn' && $explode_tabla[2] == 2023) {
                    if ($pregunta_solo_num >= 9 && $pregunta_solo_num <= 28) {
                        if ($r == 'nc') {
                            $c_nc++;
                        }
                    }
                }
                if (ucfirst($explode_tabla[1]) == 'Relep' && $explode_tabla[2] == 2023) {
                    if ($pregunta_solo_num >= 16 && $pregunta_solo_num <= 26) {
                        if ($r == 'nc') {
                            $c_nc++;
                        }
                    }
                }
            }

            switch ($a['estado']) {
                case 0:
                    $htmlEstado = '<a class="dropdown-item dropdownMessage" data-toggle="modal" data-target="#myModal" data-id="' . $a['id'] . '" data-folio="' . $a['folio'] . '"><i class="fas fa-info-circle"></i> Encuesta solo ingresada. Realizar acciones</a>';
                    break;
                case 1:
                    $htmlEstado = '<a class="dropdown-item dropdownMessage" data-toggle="modal" data-target="#myModal" data-id="' . $a['id'] . '" data-folio="' . $a['folio'] . '"><i class="fas fa-check-circle verde"></i> La encuesta es válida y debe ser considerada.</a>';
                    break;
                case 2:
                    $htmlEstado = '<a class="dropdown-item dropdownMessage" data-toggle="modal" data-target="#myModal" data-id="' . $a['id'] . '" data-folio="' . $a['folio'] . '"><i class="fas fa-times-circle text-danger"></i> La encuesta tiene más de 20 ítem erróneos o vacíos (incompleto).</a>';
                    break;
                case 3:
                    $htmlEstado = '<a class="dropdown-item dropdownMessage" data-toggle="modal" data-target="#myModal" data-id="' . $a['id'] . '" data-folio="' . $a['folio'] . '"><i class="fas fa-ban text-danger"></i> La encuesta no es válida.</a>';
                    break;
                case 4:
                    $htmlEstado = '<a class="dropdown-item dropdownMessage" data-toggle="modal" data-target="#myModal" data-id="' . $a['id'] . '" data-folio="' . $a['folio'] . '"><i class="fas fa-recycle text-warning"></i> La encuesta se volvió a capturar y será sustituido por otro folio válido.</a>';
                    break;
                case 5:
                    $htmlEstado = '<a class="dropdown-item dropdownMessage" data-toggle="modal" data-target="#myModal" data-id="' . $a['id'] . '" data-folio="' . $a['folio'] . '"><i class="fas fa-vial text-info"></i> La encuesta es de prueba y no será sustituido por otro folio.</a>';
                    break;
            }

            $htmlCuestionario = '<a href="../ver/' . $a['id'] . '" target="_blank" class="text-center verCuestionario" data-toggle="tooltip" title="Ver cuestionario" ><i class="fas fa-file-alt text-center" style="color: #AE00FF; font-size: 2rem"></i></a>';

            if ($_SESSION['red'] == 'Relayn' && date('Y') == 2023) {


                if (empty($a['clave_localidad']) && $_SESSION['pais'] == 2) {
                    $htmlVerExternal = '<a style="text-decoration: none; color: #fff" target="_blank" href="' . base_url('encuestas/editar/' . $_SESSION['CA'] . '/' . $password . '/' . $a['id']) . '" class="text-center editarCuestionario"><i class="fas fa-edit text-center" style="color: #EFF104; font-size: 1.2rem"></i> Realizar acciones</a>';
                } else if (empty($a['tipo_conglomerado']) && $_SESSION['pais'] == 2) {
                    $htmlVerExternal = '<a style="text-decoration: none; color: #fff" target="_blank" href="' . base_url('encuestas/editar/' . $_SESSION['CA'] . '/' . $password . '/' . $a['id']) . '" class="text-center editarCuestionario"><i class="fas fa-edit text-center" style="color: #EFF104; font-size: 1.2rem"></i> Realizar acciones</a>';
                } else {
                    $htmlVerExternal = 'Sin acciones necesarias.';
                }
            } else {
                $htmlVerExternal = 'No disponible';
            }


            $array[$key] = [
                'folio' => $a['folio'],
                'nombre_encuestador' => $a['nombre_encuestador'],
                'estado' => $htmlEstado,
                'nc' => $c_nc,
                'entrevista' => $htmlCuestionario,
                'editar' => $htmlVerExternal
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

    public function verCuestionario($id)
    {

        if (!isset($_SESSION['nombre_investigacion'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Trabajando... 👷🏻‍♀️')
                ->with('text', 'La encuesta para editar está bajo labor de mantenimiento. Se estará habilitando lo más pronto posible.');
        }

        $condiciones = ['id' => $id, 'claveCuerpo' => $_SESSION['CA']];

        if (!$this->CuestionariosModel->exist($_SESSION['nombre_investigacion'], $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'OJO')
                ->with('text', 'Estas intentando acceder a una encuesta que no es de su grupo. Seleccionela de su listado.');
        }

        $archivo = 'index';

        $cuestionario = $this->CuestionariosModel->getAllOneRow($_SESSION['nombre_investigacion'], $condiciones);

        $explode = explode('_', $_SESSION['nombre_investigacion']);

        if (ucfirst($explode[1]) == 'Relayn') {

            //OBTENEMOS DATOS DEL CUERPO
            $condiciones = ['claveCuerpo' => $_SESSION['CA']];
            $columnas = ['estado', 'pais'];
            $cuerpo_aca = $this->UserModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
            $condiciones = ['id' => $cuerpo_aca['estado']];
            $estado = $this->UserModel->getAllOneRow('estados', $condiciones);
            $estado = empty($estado) ? $cuerpo_aca['estado'] : $estado['nombre'];

            if ($cuerpo_aca['pais'] == 2) {
                $condiciones = ['inciso' => $cuestionario['1b']];
                $columnas = ['nombre'];
                $b1 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'tipo_asociaciones', $condiciones);
                #VIALIDADES
                $condiciones = ['id' => $cuestionario['1e']];
                $columnas = ['nombre'];
                $e1 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'vialidades', $condiciones);
                #GIRO DE NEGOCIO
                $condiciones = ['inciso' => $cuestionario['1q']];
                $columnas = ['nombre'];
                $q1 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'giros', $condiciones);
                #FUNDACION
                $condiciones = ['inciso' => $cuestionario['2b']];
                $columnas = ['nombre'];
                $b2 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'fundacion', $condiciones);
                #ESTRATEGIAS
                $condiciones = ['inciso' => $cuestionario['2c']];
                $columnas = ['nombre'];
                $c2 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'estrategias', $condiciones);
                #PROBLEMATICAS
                $condiciones = ['inciso' => $cuestionario['2d']];
                $columnas = ['nombre'];
                $d2 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'problematicas', $condiciones);
                #CONCENTRACION DE EMPRESA
                $condiciones = ['inciso' => $cuestionario['2e']];
                $columnas = ['nombre'];
                $e2 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'concentracion_empresas', $condiciones);
                #PROPIEDAD DE LA EMPRESA
                $condiciones = ['inciso' => $cuestionario['2f']];
                $columnas = ['nombre'];
                $f2 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'propiedad_empresa', $condiciones);
                #NIVEL DE ESTUDIOS
                $condiciones = ['inciso' => $cuestionario['7a']];
                $columnas = ['nombre'];
                $a7 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'nivel_estudios', $condiciones);
                #PAIS
                $condiciones = ['id' => $cuestionario['7c']];
                $columnas = ['nombre'];
                $c7 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'paises', $condiciones);
                #ESTADO CIVIL
                $condiciones = ['inciso' => $cuestionario['7f']];
                $columnas = ['nombre'];
                $f7 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'estado_civil', $condiciones);
                #HORAS PROMEDIO
                $condiciones = ['inciso' => $cuestionario['8b']];
                $columnas = ['nombre'];
                $b8 = $this->CuestionariosModel->getColumnsOneRow($columnas, 'horas_promedio', $condiciones);

                $condiciones = [];

                $asentamientos = $this->CuestionariosModel->getAll('asentamientos', $condiciones);

                $conglomerados = $this->CuestionariosModel->getAll('conglomerados', $condiciones);

                $pisos = $this->CuestionariosModel->getAll('pisos', $condiciones);

                $vialidades = $this->CuestionariosModel->getAll('vialidades', $condiciones);

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
                $info = $this->CuestionariosModel->getAll('codigos_postales', $condiciones);
                $html = '<option value="" selected disabled>Seleccione una opción</option>';
                foreach ($info as $i) {
                    $val = $i['asentamiento'] . ' ' . $i['nombre_asentamiento'] . '. ' . $i['municipio'] . ', ' . $i['ciudad'] . ', ' . $i['estado'];
                    $html .= '<option value="' . $val . '">' . $val . '</option>';
                }
                $html .= '<option value="otra">Otra opción</option>';
                $data['info_cp'] = $html;

                $condiciones = ['estado' => $estado];
                $clave_estado = $this->CuestionariosModel->getAllOneRow('claves_municipios', $condiciones);
                $clave_estado = $clave_estado['clave_estado'];
                $data['clave_estado'] = $clave_estado;
                $data['estado'] = $estado;
                $data['pais'] = $cuerpo_aca['pais'];
                $condiciones = [
                    'estado' => $estado,
                    'municipio' => $cuestionario['1k']
                ];
                $clave_municipio = $this->CuestionariosModel->getAllOneRow('claves_municipios', $condiciones);
                $data['clave_municipio'] = $clave_municipio['clave_municipio'];

                $condiciones = ['clave_estado' => $clave_estado, 'clave_municipio' => $clave_municipio['clave_municipio']];
                $localidades = $this->CuestionariosModel->getAll('localidades', $condiciones);
                $data['localidades'] = $localidades;
            } else {
                $condiciones = [];

                $asentamientos = $this->CuestionariosModel->getAll('asentamientos', $condiciones);

                $conglomerados = $this->CuestionariosModel->getAll('conglomerados', $condiciones);

                $pisos = $this->CuestionariosModel->getAll('pisos', $condiciones);

                $vialidades = $this->CuestionariosModel->getAll('vialidades', $condiciones);

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

            switch ($_SESSION['pais']) {
                case 5:
                    $archivo = 'Ecuador';
                    break;
                case 4;
                    $archivo = 'Peru';
                    break;
                case 3:
                    $archivo = 'Colombia';
                    break;
            }
        }


        $condiciones = ['nombre_red' => $_SESSION['red']];
        $red = $this->UserModel->getAllOneRow('redes', $condiciones);

        $data['cuestionario'] = $cuestionario;
        $data['red'] = $red;
        $data['claveCuerpo'] = $_SESSION['CA'];
        $data['tabla'] = $_SESSION['nombre_investigacion'];

        $ruta = 'usuarios/vistas/encuestas/' . $cuestionario['red'] . '/' . $cuestionario['anio'] . '/' . $archivo;

        return view('external/librerias/index')
            . view($ruta, $data)
            . view('external/footer/index');



        /*
        echo $explode[1];
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        */
    }

    public function actualizarEncuesta()
    {
        $id_actualizar = $_POST['id_actualizar'];
        $tabla = $_POST['tabla'];

        unset($_POST['id_actualizar']);
        unset($_POST['tabla']);

        $condiciones = ['id' => $id_actualizar];

        $data = $_POST;

        if (!$this->CuestionariosModel->generalUpdate($tabla, $data, $condiciones)) {
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

    public function changeStatusCuestionario()
    {

        $data = [
            'estado' => $_POST['selectStatus']
        ];

        $condiciones = [
            'id' => $_POST['id_cuestionario']
        ];

        if (!$this->CuestionariosModel->generalUpdate($_POST['tabla'], $data, $condiciones)) {
            return 'error';
        }

        $condiciones = ['id' => $_POST['id_cuestionario']];

        $columnas = ['nombre_encuestador', 'correo_encuestador', 'red', 'anio', 'claveCuerpo'];

        $dataEncuesta = $this->CuestionariosModel->getColumnsOneRow($columnas, $_POST['tabla'], $condiciones);

        if ($dataEncuesta['correo_encuestador'] == 'No aplica por el medio de captura.') {
            return 'success_sin_constancia';
        }

        if ($_POST['selectStatus'] == 1) {

            $data = [
                'nombre' => $dataEncuesta['nombre_encuestador'],
                'correo' => $dataEncuesta['correo_encuestador'],
                'red' => $dataEncuesta['red'],
                'anio' => $dataEncuesta['anio']
            ];

            if (empty($dataEncuesta)) {
                return 'error';
            }

            $condiciones = [
                'correo' => $dataEncuesta['correo_encuestador'],
                'red' => $dataEncuesta['red'],
                'anio' => $dataEncuesta['anio']
            ];

            if (!$this->UserModel->exist('constancia_encuestador', $condiciones)) {
                if (!$this->UserModel->generalInsert('constancia_encuestador', $data)) {
                    return 'error';
                }
                return 'success';
            } else {
                return 'success';
            }
        } else {

            if ($this->UserModel->exist('constancia_encuestador', $condiciones)) {

                $columnas = ['estado'];
                $condiciones = [
                    'estado' => 1,
                    'correo_encuestador' => $dataEncuesta['correo_encuestador'],
                    'red' => $dataEncuesta['red'],
                    'anio' => $dataEncuesta['anio'],
                    'claveCuerpo' => $dataEncuesta['claveCuerpo']
                ];
                $c_correos = $this->CuestionariosModel->getAllColums($columnas, $_POST['tabla'], $condiciones);

                $c_correos = count($c_correos);

                if ($c_correos == 0) {
                    $condiciones = [
                        'nombre' => $dataEncuesta['nombre_encuestador'],
                        'correo' => $dataEncuesta['correo_encuestador'],
                        'red' => $dataEncuesta['red'],
                        'anio' => $dataEncuesta['anio']
                    ];
                    if (!$this->UserModel->generalDelete('constancia_encuestador', $condiciones)) {
                        return 'error';
                    }
                    return 'success';
                } else {
                    return 'success';
                }
            }

            return 'success';
        }



        return 'success';
    }

    public function getExcelEncuesta($anio)
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $condiciones = [
            'red' => $_SESSION['red'],
            'anio' => $anio,
            'pais' => 2
        ];

        $preguntas = $this->CuestionariosModel->getAll('preguntas_cuestionarios', $condiciones);

        if (empty($preguntas)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Trabajando...')
                ->with('text', 'El archivo aún no esta disponible.');
        }

        if ($_SESSION['pais'] != 2) {
            $condiciones = [
                'red' => $_SESSION['red'],
                'anio' => $anio,
                'pais' => $_SESSION['pais']
            ];

            $preguntas_pais = $this->CuestionariosModel->getAll('preguntas_cuestionarios', $condiciones);

            if (!empty($preguntas_pais)) {
                foreach ($preguntas_pais as $key => $value) {
                    $position_replace = array_search($value['inciso'], array_column($preguntas, 'inciso'));
                    $preguntas[$position_replace]['nombre'] = $value['nombre'];
                    /*
                    $position_delete = array_search($value['id'],array_column($preguntas, 'id'));
                    unset($preguntas[$position_delete]);
                    $preguntas = array_values($preguntas);
                    */
                }
                #CASO PERU
                switch ($_SESSION['pais']) {
                    case 4:
                        unset($preguntas[8]);
                        unset($preguntas[9]);
                        break;
                    case 5:
                        unset($preguntas[8]);
                        unset($preguntas[9]);
                        break;
                    case 3:
                        unset($preguntas[8]);
                        unset($preguntas[9]);
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }

        /*
        echo '<pre>';
        print_r($preguntas);
        echo '</pre>';
        return;
        */

        $condiciones = ['claveCuerpo' => $_SESSION['CA']];
        $tabla = 'cuestionarios_' . strtolower($_SESSION['red']) . '_' . $anio;

        $getAllEncuestas = $this->CuestionariosModel->getAll($tabla, $condiciones);

        $condiciones = ['nombre_red' => $_SESSION['red']];
        $red = $this->UserModel->getAllOneRow('redes', $condiciones);

        $color = $red['color_primario'];

        $color = str_replace('#', '', $color);
        $color = strtoupper($color);

        #CON EL SIGUIENTE FOREACH OBTENEMOS LAS PREGUNTAS, DEBE SER UN ARRAY UNIDIMENSIONAL
        $headerExcel = ['Folio', 'Estado'];
        foreach ($preguntas as $p) {
            array_push($headerExcel, $p['nombre']);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'font' => [
                'italic' => true,
                'bold' => true,
                'color' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ),
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FF' . $color,
                ],
            ],
        ];

        $sheet->fromArray([$headerExcel], NULL, 'A1');
        $highestColumn = $sheet->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . '1')->applyFromArray($styleArray);

        $arr_respuestas = [];
        $inicio = 2;

        function getEstado($estado)
        {
            switch ($estado) {
                case 0:
                    return 'Encuesta solo ingresada. Realizar acciones.';
                    break;
                case 1:
                    return 'La encuesta es válida y debe ser considerada.';
                    break;
                case 2:
                    return 'La encuesta tiene más de 20 ítem erróneos o vacíos (incompleto).';
                    break;
                case 3:
                    return 'La encuesta no es válida.';
                    break;
                case 4:
                    return 'La encuesta se volvió a capturar y será sustituido por otro folio válido.';
                    break;
                case 5:
                    return 'La encuesta es de prueba y no será sustituido por otro folio.';
                    break;
            }
        }

        foreach ($getAllEncuestas as $e) {
            $folio = $e['folio'];
            $estado = getEstado($e['estado']);
            array_push($arr_respuestas, $folio);
            array_push($arr_respuestas, $estado);
            foreach ($preguntas as $p) {
                $pregunta_solo_num = preg_replace('/[^0-9]/', '', $p['inciso']);
                if ($_SESSION['red'] == 'Relayn' && $anio == 2023) {
                    $valores = [
                        '4' => 'Muy de acuerdo',
                        '3' => 'De acuerdo',
                        '2' => 'En desacuerdo',
                        '1' => 'Muy en desacuerdo',
                        'nc' => 'No sé / No aplica'
                    ];
                    if ($pregunta_solo_num >= 9 && $pregunta_solo_num <= 28) {
                        if (array_key_exists($e[$p['inciso']], $valores)) {
                            $valor_pregunta = $valores[$e[$p['inciso']]];
                        } else {
                            $valor_pregunta = 'Contacte al Equipo REDESLA.';
                        }
                        array_push($arr_respuestas, $valor_pregunta);
                    } else {
                        $valor_pregunta = ucfirst($e[$p['inciso']]);
                        if ($valor_pregunta == 'Na' || $valor_pregunta == 'Nc') {
                            $valor_pregunta = 'No aplica';
                        } else if ($valor_pregunta == '') {
                            $valor_pregunta = 'Sin respuesta';
                        }
                        if ($p['inciso'] == '1r') {
                            $explode_1r = explode(',', $valor_pregunta);
                            $str_scian = '';
                            foreach ($explode_1r as $ex) {
                                $value_1r = $ex;
                                $id_format = '_' . $value_1r . '_%';
                                $consulta = 'SELECT * FROM rama5 WHERE nombre LIKE "' . $id_format . '"';
                                $datos = $this->db_serv->query($consulta)->getResult();
                                if (empty($datos)) {
                                    $consulta = 'SELECT * FROM comun_codigo_ciiu WHERE codigo = "' . $value_1r . '"';
                                    $datos = $this->db_serv->query($consulta)->getResult();
                                    $array = json_decode(json_encode($datos), true);
                                    if (empty($array)) {
                                        $str_scian = 'Contacte con el Equipo REDESLA.';
                                    } else {
                                        $str_scian .= $array[0]['codigo'] . '--' . $array[0]['descripcion'] . ', ';
                                    }
                                } else {
                                    $array = json_decode(json_encode($datos), true);
                                    $str_scian .= $array[0]['nombre'] . ', ';
                                }
                            }
                            $valor_pregunta = rtrim($str_scian, ', ');
                        }
                        array_push($arr_respuestas, $valor_pregunta);
                    }
                } else if ($_SESSION['red'] == 'Relen' && $anio == 2023) {
                    $valores_1 = [
                        '5' => 'Siempre',
                        '4' => 'Casi siempre',
                        '3' => 'A veces',
                        '2' => 'Casi nunca',
                        '1' => 'Nunca',
                    ];
                    $valores_2 = [
                        '5' => 'Diario',
                        '4' => 'Al menos 1 vez a la semana',
                        '3' => 'Al menos 1 vez al mes',
                        '2' => 'Al menos 1 vez al año',
                        '1' => 'Casi nunca o nunca',
                        '0' => 'No tengo acceso'
                    ];
                    if ($pregunta_solo_num >= 19 && $pregunta_solo_num <= 47) {

                        if (array_key_exists($e[$p['inciso']], $valores_1)) {
                            $valor_pregunta = $valores_1[$e[$p['inciso']]];
                        } else {
                            $valor_pregunta = 'Contacte al Equipo REDESLA.';
                        }

                        array_push($arr_respuestas, $valor_pregunta);
                    } else if ($pregunta_solo_num >= 48 && $pregunta_solo_num <= 50) {

                        if (array_key_exists($e[$p['inciso']], $valores_2)) {
                            $valor_pregunta = $valores_2[$e[$p['inciso']]];
                        } else {
                            $valor_pregunta = 'Contacte al Equipo REDESLA.';
                        }

                        array_push($arr_respuestas, $valor_pregunta);
                    } else {
                        $valor_pregunta = ucfirst($e[$p['inciso']]);
                        if ($valor_pregunta == 'Na' || $valor_pregunta == 'Nc') {
                            $valor_pregunta = 'No aplica';
                        } else if ($valor_pregunta == '') {
                            $valor_pregunta = 'Sin respuesta';
                        }
                        array_push($arr_respuestas, $valor_pregunta);
                    }
                } else if ($_SESSION['red'] == 'Relep' && $anio == 2023) {
                    $valores = [
                        '4' => 'Muy de acuerdo',
                        '3' => 'De acuerdo',
                        '2' => 'En desacuerdo',
                        '1' => 'Muy en desacuerdo',
                        'nc' => 'No sé / No aplica'
                    ];
                    if ($pregunta_solo_num >= 16 && $pregunta_solo_num <= 26) {

                        if (array_key_exists($e[$p['inciso']], $valores)) {
                            $valor_pregunta = $valores[$e[$p['inciso']]];
                        } else {
                            $valor_pregunta = 'Contacte al Equipo REDESLA.';
                        }
                        array_push($arr_respuestas, $valor_pregunta);
                    } else {
                        $valor_pregunta = ucfirst($e[$p['inciso']]);
                        if ($valor_pregunta == 'Na' || $valor_pregunta == 'Nc') {
                            $valor_pregunta = 'No aplica';
                        } else if ($valor_pregunta == '') {
                            $valor_pregunta = 'Sin respuesta';
                        }
                        array_push($arr_respuestas, $valor_pregunta);
                    }
                }
            }
            $sheet->fromArray([$arr_respuestas], NULL, 'A' . $inicio);
            $arr_respuestas = [];
            $inicio++;
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        /*
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        */
        //$sheet->setCellValue('A1', 'Hello World !');


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Encuestas_' . $_SESSION['CA'] . '_' . $anio . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function terminarInvestigacion()
    {

        if (!isset($_SESSION['CA'])) {
            $error = array(
                "mensaje" => "La sesión ha expirado.",
                "codigo" => 401
            );
            http_response_code(401);
            echo json_encode($error);
            exit;
        }
        #TERMINADO 1, el proceso de captura acabo
        $explode = explode(' ', $_POST['proyecto']);
        $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'nombre_proyecto' => $_POST['proyecto'], 'anio' => $explode[4], 'redCueCa' => $_SESSION["red"]];

        if (!$this->UserModel->exist('validacion', $condiciones)) {
            #No existe ese registro, lo insertamos
            $data = $condiciones;
            $data['terminado'] = 1;

            if (!$this->UserModel->generalInsert('validacion', $data)) {
                $error = array(
                    "mensaje" => "Ha ocurrido un error al intentar terminar su proceso de captura de encuestas. Contacte a sistemas.",
                    "codigo" => 500
                );
                http_response_code(500);
                echo json_encode($error);
                exit;
            }
            $respuesta = array(
                "title" => "¡Felicidades!",
                'mensaje' => 'Ha terminado con el proceso de captura de sus encuestas',
                "codigo" => 200,
            );
            $json_respuesta = json_encode($respuesta);
            echo $json_respuesta;
            exit;
        }

        $data = ['terminado' => 1];

        if (!$this->UserModel->generalUpdate('validacion', $data, $condiciones)) {
            $error = array(
                "mensaje" => "Ha ocurrido un error. Contacte a sistemas.",
                "codigo" => 501
            );
            http_response_code(500);
            echo json_encode($error);
            exit;
        }

        $respuesta = array(
            "title" => "¡Felicidades!",
            'mensaje' => 'Ha terminado con el proceso de captura de sus encuestas',
            "codigo" => 200,
        );
        $json_respuesta = json_encode($respuesta);
        echo $json_respuesta;
        exit;
    }

    public function capituloReleg($claveCuerpo, $pass)
    {
        $condiciones = ["claveCuerpo" => $claveCuerpo, "password" => $pass, 'redCueCa' => 'Releg'];

        if (!$this->UserModel->exist('cuerpos_academicos', $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Url no válida.');
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
        $orden_autores = $this->UserModel->getAll('ordenes_autores', $condiciones);
        if (empty($orden_autores)) {
            #tenemos que buscar el proyecto que registraron
            $condiciones = ['claveCuerpo' => $claveCuerpo];
            $validacion = $this->UserModel->getAllOneRow('validacion', $condiciones);
            $nombre_proyecto = $validacion['nombre_proyecto'];

            $condiciones = ['cuerpoAcademico' => $claveCuerpo];
            $columnas = ['usuario'];
            $usuarios = $this->UserModel->getAllColums($columnas, 'miembros', $condiciones);

            foreach ($usuarios as $key => $u) {
                if ($nombre_proyecto == 'Esquema A: Investigación Releg 2022') {
                    #solo digital
                    $data = [
                        'claveCuerpo' => $claveCuerpo,
                        'anio' => 2022,
                        'orden_digital' => intval($key + 1),
                        'usuario' => $u['usuario']
                    ];
                    $this->UserModel->generalInsert('ordenes_autores', $data);
                } else if ($nombre_proyecto == 'Esquema B: Investigación Releg 2022') {
                    #digital e impreso
                    $data = [
                        'claveCuerpo' => $claveCuerpo,
                        'anio' => 2022,
                        'orden_digital' => intval($key + 1),
                        'orden_impreso' => intval($key + 1),
                        'usuario' => $u['usuario']
                    ];
                    $this->UserModel->generalInsert('ordenes_autores', $data);
                }
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
            $orden_autores = $this->UserModel->getAll('ordenes_autores', $condiciones);
        }

        $columnas = ['categoria'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $categorias = $this->UserModel->getAllDistinc($columnas, "filtro_categorias", $condiciones);
        if (empty($categorias)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'No tiene categorias registradas para continuar.');
        }


        $str_categorias = '';
        foreach ($categorias as $key => $c) {
            $data['categorias'][$key]['id'] = $c['categoria'];
            $condiciones = ['id' => $c['categoria']];
            $info_categoria = $this->UserModel->getAllOneRow('categorias', $condiciones);
            if (empty($info_categoria)) {
                echo 'No existe la categoria, ha existido un error y regresar';
                return;
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['categoria']];
            $cantidad = $this->UserModel->count('filtro_categorias', $condiciones);


            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];

            $columnas = ['id_entrevista'];

            $entrevistas = $this->UserModel->getAllDistinc($columnas, "filtro_categorias", $condiciones); #LO OCUPO PARA LA LISTA DE TODAS LAS ENTREVISTAS Y CODIGOS EN VIVO
            $arr_codigos_cat = [];
            $columnas = ['id_entrevista', 'codigo_en_vivo'];
            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];
            $codigos_categoria = $this->UserModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
            foreach ($entrevistas as $key_entrevistas => $e) {
                $data['categorias'][$key]['entrevistas'][] = $e['id_entrevista'];
            }


            $explode_nombre_categoria = explode(': ', $info_categoria['nombre']);
            $nombre_solo = substr($explode_nombre_categoria[1], 0, -1);
            $str_categorias .= $nombre_solo . ', ';


            $data['categorias'][$key]['nombre'] = $info_categoria['nombre'];
            $data['categorias'][$key]['descripcion'] = $info_categoria['descripcion'];
            $data['categorias'][$key]['color'] = $info_categoria['color'];
            $data['categorias'][$key]['cantidad'] = $cantidad;
            $data['categorias'][$key]['lista_codigos'] = $codigos_categoria;
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['nombre', 'municipio', 'estado'];
        $universidad = $this->UserModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        $condiciones = ['id' => $universidad['estado']];
        $estado = $this->UserModel->getAllOneRow('estados', $condiciones);
        $nombre_estado = empty($estado) ? $universidad['estado'] : $estado['nombre'];

        $condiciones = ['id' => $universidad['municipio']];
        $municipio = $this->UserModel->getAllOneRow('municipios', $condiciones);
        $nombre_mun = empty($municipio) ? $universidad['municipio'] : $municipio['nombre'];

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $municipios_adicionales = $this->UserModel->getAll('municipios_ca', $condiciones);

        if (empty($municipios_adicionales)) {
            $str_municipios = $nombre_mun;
        } else {
            $str_municipios = $nombre_mun;
            foreach ($municipios_adicionales as $key2 => $m) {
                $str_municipios .= ', ' . $m['nombre_municipio'];
            }
        }


        $data['universidad_completo'] = $universidad['nombre'] . ' en ' . $str_municipios . ', ' . $nombre_estado . '. México';
        $data['universidad'] = $universidad['nombre'];
        $data['municipios'] = $str_municipios . ', ' . $nombre_estado . '. México';
        $str_categorias = substr($str_categorias, 0, -2);

        $explode_cat = explode(', ', $str_categorias);
        $last_cat = end($explode_cat);
        $str_categorias = str_replace(", $last_cat", " y $last_cat", $str_categorias, $count);
        $str_categorias = strtolower($str_categorias);

        $data['str_categorias'] = $str_categorias;

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $countCodigos = $this->UserModel->count('filtro_categorias', $condiciones);
        $data['c_codigos'] = $countCodigos;

        $countEntrevistas = $this->UserModel->count('entrevistas_Relmo', $condiciones);
        $data['c_entrevistas'] = $countEntrevistas;





        $key_sort2  = array_column($data['categorias'], 'cantidad');
        array_multisort($key_sort2, SORT_DESC, $data['categorias']);

        $data['categorias'] = array_slice($data['categorias'], 0, 5);

        $tipo_orden_autores = $orden_autores[0]['orden_impreso'] != 0 ? 'orden_impreso' : 'orden_digital';
        $key_sort3  = array_column($orden_autores, $tipo_orden_autores);
        array_multisort($key_sort3, SORT_ASC, $orden_autores);

        foreach ($orden_autores as $key4 => $o) {
            $condiciones = ['usuario' => $o['usuario']];
            $usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);
            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $data['ordenes_autores'][] = $nombre;
        }

        $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'anio' => 2022];
        if ($this->UserModel->exist('capitulos_releg', $condiciones)) {
            $info = $this->UserModel->getAllOneRow('capitulos_releg', $condiciones);
            $data['info'] = $info;
            return view('usuarios/vistas/Releg/2022/capitulo', $data);
            return;
        }


        /*
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        return;
        */

        return view('usuarios/proyectos/capitulo_releg', $data);
    }

    public function capituloRelegEditar($claveCuerpo, $pass)
    {

        $condiciones = ["claveCuerpo" => $claveCuerpo, "password" => $pass, 'redCueCa' => 'Releg'];

        if (!$this->UserModel->exist('cuerpos_academicos', $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Url no válida.');
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
        $orden_autores = $this->UserModel->getAll('ordenes_autores', $condiciones);
        if (empty($orden_autores)) {
            #tenemos que buscar el proyecto que registraron
            $condiciones = ['claveCuerpo' => $claveCuerpo];
            $validacion = $this->UserModel->getAllOneRow('validacion', $condiciones);
            $nombre_proyecto = $validacion['nombre_proyecto'];

            $condiciones = ['cuerpoAcademico' => $claveCuerpo];
            $columnas = ['usuario'];
            $usuarios = $this->UserModel->getAllColums($columnas, 'miembros', $condiciones);

            foreach ($usuarios as $key => $u) {
                if ($nombre_proyecto == 'Esquema A: Investigación Releg 2022') {
                    #solo digital
                    $data = [
                        'claveCuerpo' => $claveCuerpo,
                        'anio' => 2022,
                        'orden_digital' => intval($key + 1),
                        'usuario' => $u['usuario']
                    ];
                    $this->UserModel->generalInsert('ordenes_autores', $data);
                } else if ($nombre_proyecto == 'Esquema B: Investigación Releg 2022') {
                    #digital e impreso
                    $data = [
                        'claveCuerpo' => $claveCuerpo,
                        'anio' => 2022,
                        'orden_digital' => intval($key + 1),
                        'orden_impreso' => intval($key + 1),
                        'usuario' => $u['usuario']
                    ];
                    $this->UserModel->generalInsert('ordenes_autores', $data);
                }
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
            $orden_autores = $this->UserModel->getAll('ordenes_autores', $condiciones);
        }

        $columnas = ['categoria'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $categorias = $this->UserModel->getAllDistinc($columnas, "filtro_categorias", $condiciones);
        if (empty($categorias)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'No tiene categorias registradas para continuar.');
        }


        $str_categorias = '';
        foreach ($categorias as $key => $c) {
            $data['categorias'][$key]['id'] = $c['categoria'];
            $condiciones = ['id' => $c['categoria']];
            $info_categoria = $this->UserModel->getAllOneRow('categorias', $condiciones);
            if (empty($info_categoria)) {
                echo 'No existe la categoria, ha existido un error y regresar';
                return;
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['categoria']];
            $cantidad = $this->UserModel->count('filtro_categorias', $condiciones);


            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];

            $columnas = ['id_entrevista'];

            $entrevistas = $this->UserModel->getAllDistinc($columnas, "filtro_categorias", $condiciones); #LO OCUPO PARA LA LISTA DE TODAS LAS ENTREVISTAS Y CODIGOS EN VIVO
            $arr_codigos_cat = [];
            $columnas = ['id_entrevista', 'codigo_en_vivo'];
            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];
            $codigos_categoria = $this->UserModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
            foreach ($entrevistas as $key_entrevistas => $e) {
                $data['categorias'][$key]['entrevistas'][] = $e['id_entrevista'];
            }


            $explode_nombre_categoria = explode(': ', $info_categoria['nombre']);
            $nombre_solo = substr($explode_nombre_categoria[1], 0, -1);
            $str_categorias .= $nombre_solo . ', ';


            $data['categorias'][$key]['nombre'] = $info_categoria['nombre'];
            $data['categorias'][$key]['descripcion'] = $info_categoria['descripcion'];
            $data['categorias'][$key]['color'] = $info_categoria['color'];
            $data['categorias'][$key]['cantidad'] = $cantidad;
            $data['categorias'][$key]['lista_codigos'] = $codigos_categoria;
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['nombre', 'municipio', 'estado'];
        $universidad = $this->UserModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        $condiciones = ['id' => $universidad['estado']];
        $estado = $this->UserModel->getAllOneRow('estados', $condiciones);
        $nombre_estado = empty($estado) ? $universidad['estado'] : $estado['nombre'];

        $condiciones = ['id' => $universidad['municipio']];
        $municipio = $this->UserModel->getAllOneRow('municipios', $condiciones);
        $nombre_mun = empty($municipio) ? $universidad['municipio'] : $municipio['nombre'];

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $municipios_adicionales = $this->UserModel->getAll('municipios_ca', $condiciones);

        if (empty($municipios_adicionales)) {
            $str_municipios = $nombre_mun;
        } else {
            $str_municipios = $nombre_mun;
            foreach ($municipios_adicionales as $key2 => $m) {
                $str_municipios .= ', ' . $m['nombre_municipio'];
            }
        }

        if($_SESSION['CA'] == 'MXM-SCU01'){
            $universidad['nombre'] == 'SINCE Colegio Universitario, S.C.';
        }
        $data['universidad_completo'] = $universidad['nombre'] . ' en ' . $str_municipios . ', ' . $nombre_estado . '. México';
        $data['universidad'] = $universidad['nombre'];
        $data['municipios'] = $str_municipios . ', ' . $nombre_estado . '. México';
        $str_categorias = substr($str_categorias, 0, -2);

        $explode_cat = explode(', ', $str_categorias);
        $last_cat = end($explode_cat);
        $str_categorias = str_replace(", $last_cat", " y $last_cat", $str_categorias, $count);
        $str_categorias = strtolower($str_categorias);

        $data['str_categorias'] = $str_categorias;

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $countCodigos = $this->UserModel->count('filtro_categorias', $condiciones);
        $data['c_codigos'] = $countCodigos;

        $countEntrevistas = $this->UserModel->count('entrevistas_Relmo', $condiciones);
        $data['c_entrevistas'] = $countEntrevistas;


        $tipo_orden_autores = $orden_autores[0]['orden_impreso'] != 0 ? 'orden_impreso' : 'orden_digital';

        $key_sort3  = array_column($orden_autores, $tipo_orden_autores);
        array_multisort($key_sort3, SORT_ASC, $orden_autores);

        $key_sort2  = array_column($data['categorias'], 'cantidad');
        array_multisort($key_sort2, SORT_DESC, $data['categorias']);


        if ($_SESSION['CA'] == 'MXM-UTTEH01') {
            function ordenarArray($data, $keyValue)
            {
                $categorias = $data['categorias'];

                // Buscar el índice del elemento "CATEGORÍA 11: Competencia"
                $index = array_search($keyValue, array_column($categorias, 'nombre'));

                // Extraer el elemento y eliminarlo del array
                $elemento = array_splice($categorias, $index, 1);

                // Insertar el elemento en la primera posición del array
                array_unshift($categorias, $elemento[0]);

                // Actualizar el array original
                return $categorias;
            }

            $data['categorias'] = ordenarArray($data, 'CATEGORÍA 6: Identidad de género.');
            $data['categorias'] = ordenarArray($data, 'CATEGORÍA 1: La doble jornada (doméstica-empresarial)');
            $data['categorias'] = ordenarArray($data, 'CATEGORÍA 11: Competencia.');
            $data['categorias'] = ordenarArray($data, 'CATEGORÍA 5: Falta de experiencia.');
            $data['categorias'] = ordenarArray($data, 'CATEGORÍA 2: La doble jornada (empresarial-formación académica).');
        }



        $data['categorias'] = array_slice($data['categorias'], 0, 5);

        echo '<pre>';
        #print_r($data);
        echo '</pre>';
        #exit;


        foreach ($orden_autores as $key4 => $o) {
            $condiciones = ['usuario' => $o['usuario']];
            $usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);
            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $data['ordenes_autores'][] = $nombre;
        }


        $condiciones = ['claveCuerpo' => $_SESSION['CA'], 'anio' => 2022];
        if ($this->UserModel->exist('capitulos_releg', $condiciones)) {
            $info = $this->UserModel->getAllOneRow('capitulos_releg', $condiciones);

            $key_sum = 1;
            foreach ($info as $key_i => $i) {
                $key_info = 'categoria_' . $key_sum;
                #$key_info = 'categoria_2';
                if (array_key_exists($key_info, $info)) {
                    $autofill = $info[$key_info];
                    $explode_fill = explode(';', $autofill);
                    $explode_codigos = explode(',', $explode_fill[1]);
                    $explode_codigos = array_chunk($explode_codigos, 2);

                    $str_categoria = '';
                    $str_categoria = $explode_fill[0] . ';';
                    foreach ($explode_codigos as $e) {
                        $condiciones = ['id' => $e[1]];
                        $info_codigo = $this->UserModel->getAllOneRow('filtro_categorias', $condiciones);

                        $str_categoria .=  empty($info_codigo) ? 'Vacio' : $e[0] . '~' . $info_codigo['codigo_en_vivo'] . '~' . $e[1] . '~';
                    }

                    $str_categoria = rtrim($str_categoria, '~');
                    $str_categoria .= ';' . $explode_fill[2];
                    #echo $str_categoria;
                    #exit;
                    $info[$key_info] = $str_categoria;
                }
                $key_sum++;
            }

            $data['info'] = $info;

            echo '<pre>';
            #print_r($data);
            echo '</pre>';
            #return;


            return view('usuarios/vistas/Releg/2022/capitulo', $data);
        }


        return view('usuarios/proyectos/capitulo_releg', $data);
    }

    public function capituloDigitalRelegEditar($claveCuerpo, $pass)
    {
        $condiciones = ["claveCuerpo" => $claveCuerpo, "password" => $pass, 'redCueCa' => 'Releg'];

        if (!$this->UserModel->exist('cuerpos_academicos', $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Url no válida.');
        }

        #OBTENEMOS SU DISCUSION
        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => 2022];
        $discusion = $this->UserModel->getAllOneRow('capitulo_digital_releg', $condiciones);

        if (empty($discusion)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Se ha preentado un error. Contacte al equipo RELEG');
        }

        $data['discusion'] = $discusion;

        return view('usuarios/edits/capitulo_digital_releg', $data);
    }

    public function updateCapDigital2022()
    {
        if (!isset($_SESSION['CA'])) {
            http_response_code(403);
            echo 'Su sesión ha expirado. Vuelva a iniciar sesión.';
            exit;
        }

        $condiciones = [
            'claveCuerpo' => $_SESSION['CA'],
            'anio' => 2022
        ];

        $data = [
            'discusion' => $_POST['discusion']
        ];

        if (!$this->UserModel->generalUpdate('capitulo_digital_releg', $data, $condiciones)) {
            http_response_code(501);
            echo 'No se pudo actualizar la información. Contacte al equipo RELEG.';
            exit;
        }

        $dataUpdate = [
            'terminado' => 19
        ];

        $condiciones = [
            'claveCuerpo' => $_SESSION['CA'],
        ];

        if (!$this->UserModel->generalUpdate('validacion', $dataUpdate, $condiciones)) {
            http_response_code(502);
            echo 'Ha ocurrido un error al actualizar su información. Contacte al equipo RELEG.';
            exit;
        }

        $response = [
            'title' => '¡Éxito!',
            'text' => 'Información actualizada correctamente.'
        ];

        echo json_encode($response);
    }

    public function updateCapituloReleg()
    {
        $i = 1;
        foreach ($_POST['categorias'] as $key => $c) {
            //print_r($c);
            $str_categoria = '';
            $str_id_entrevistas = $c[1]['id_entrevista'] . ',' . $c[1]['codigo_en_vivo'] . ',';
            $str_codigo_en_vivo = $c[2]['id_entrevista'] . ',' . $c[2]['codigo_en_vivo'] . ',';


            $str_join = $str_id_entrevistas . $str_codigo_en_vivo;

            $str_join = substr($str_join, 0, -1);

            $str_categoria =  $key . ';' . $str_join . ';' . $c['analisis'];

            $data['categoria_' . $i] = $str_categoria;
            $i++;
        }
        $data['enfoque'] = $_POST['enfoque'];
        $data['claveCuerpo'] = $_SESSION['CA'];
        $data['anio'] = 2022;

        $condiciones = ['id' => $_POST['id_capitulo']];

        if (!$this->UserModel->generalUpdate('capitulos_releg', $data, $condiciones)) {
            return redirect()->back()
                ->with('icon', 'danger')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Intente mas tarde. Codigo de error: 100');
        }

        $data = ['terminado' => 13];
        $condiciones = [
            'claveCuerpo' => $_SESSION["CA"],
            'redCueCa' => $_SESSION["red"],
        ];

        if (!$this->UserModel->generalUpdate('validacion', $data, $condiciones)) {
            return redirect()->back()
                ->with('icon', 'danger')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Intente mas tarde. Codigo de error: 101');
        }

        return redirect()->to(base_url('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA']))
            ->with('icon', 'success')
            ->with('title', 'Éxito')
            ->with('text', 'Información actualizada correctamente. Espere instrucciones por parte del Comite Revisor RELEG.');
    }

    public function getEntrevistasCapitulo()
    {
        $condiciones = [
            "claveCuerpo" => $_POST['ca'],
            'categoria' => $_POST['categoria']
        ];

        $entrevistas = $this->UserModel->getAll("filtro_categorias", $condiciones);
        $i = 0;
        foreach ($entrevistas as $e) {
            $condiciones = ['id' => $e['id_entrevista']];
            $columnas = ['pregunta10'];
            $entrevista = $this->UserModel->getColumnsOneRow($columnas, 'entrevistas_Relmo', $condiciones);
            $condiciones = ["id" => $entrevista['pregunta10']];
            $estado = $this->UserModel->getAllOneRow("estados", $condiciones);
            $entrevistas[$i]['pregunta10'] = $estado['nombre'];
            $i++;
        }
        echo json_encode($entrevistas);
    }

    public function getCodigos()
    {

        $id_entrevista = $_POST['entrevista'];

        $columnas = ['id', 'codigo_en_vivo'];
        $condiciones = ['id_entrevista' => $id_entrevista, 'categoria' => $_POST['categoria'], 'claveCuerpo' => $_SESSION['CA']];
        $codigos = $this->UserModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
        echo json_encode($codigos);
    }

    public function getDocReleg()
    {

        $i = 1;
        foreach ($_POST['categorias'] as $key => $c) {
            //print_r($c);
            $str_categoria = '';
            $str_id_entrevistas = $c[1]['id_entrevista'] . ',' . $c[1]['codigo_en_vivo'] . ',';
            $str_codigo_en_vivo = $c[2]['id_entrevista'] . ',' . $c[2]['codigo_en_vivo'] . ',';


            $str_join = $str_id_entrevistas . $str_codigo_en_vivo;

            $str_join = substr($str_join, 0, -1);

            $str_categoria =  $key . ';' . $str_join . ';' . $c['analisis'];

            $data['categoria_' . $i] = $str_categoria;
            $i++;
        }
        $data['enfoque'] = $_POST['enfoque'];
        $data['claveCuerpo'] = $_SESSION['CA'];
        $data['anio'] = 2022;

        if (!$this->UserModel->generalInsert('capitulos_releg', $data)) {
            return redirect()->back()
                ->with('icon', 'danger')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Intente mas tarde. Codigo de error: 100');
        }

        $data = ['terminado' => 10];
        $condiciones = [
            'claveCuerpo' => $_SESSION["CA"],
            'redCueCa' => $_SESSION["red"],
        ];

        if (!$this->UserModel->generalUpdate('validacion', $data, $condiciones)) {
            return redirect()->back()
                ->with('icon', 'danger')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Intente mas tarde. Codigo de error: 101');
        }

        return redirect()->back()
            ->with('icon', 'success')
            ->with('title', 'Éxito')
            ->with('text', 'Información guardada correcamente. Espere instrucciones por parte del Comite Revisor RELEG.');
        return;

        $data = $_POST;

        $html = "
        <h1 style='text-align:center'>Introducción</h1>
        <p>" . $data['introduccion'] . "</p>
        <h1 style='text-align:center'>Resultados</h1>
	    <p>Valor fijo, disctaminado por la empresa</p>
        ";

        foreach ($data['categorias'] as $key => $c) {

            $id_categoria = $key;
            $condiciones = ['id' => $id_categoria];
            $columnas = ['nombre'];
            $categoria = $this->UserModel->getColumnsOneRow($columnas, 'categorias', $condiciones);
            $html .= "
            <h2>" . $categoria['nombre'] . "</h2>
            <p>" . $c['analisis'] . "</p>
            ";
            foreach ($c as $key2 => $codigo) {
                if ($key2 == 'analisis') {
                    continue;
                }
                if (!empty($codigo)) {

                    $columnas = ['pregunta1', 'pregunta2', 'pregunta3', 'pregunta4', 'pregunta12', 'pregunta6', 'pregunta10'];

                    $condiciones = ['id' => $codigo['id_entrevista']];

                    $entrevista = $this->UserModel->getColumnsOneRow($columnas, 'entrevistas_Relmo', $condiciones);

                    $caracteristicas = 'Universitaria de ' . $entrevista['pregunta1'] . ' años, ' . ucfirst($entrevista['pregunta2']);

                    if ($entrevista['pregunta3'] == 'no') {
                        $caracteristicas .= ', sin hijos';
                    } else {
                        $caracteristicas .= ', ' . $entrevista['pregunta4'] . ' hijo(s)';
                    }

                    $tipo_institucion = $entrevista['pregunta12'] == 'público' ? 'pública' : 'privada';

                    $condiciones = ['id' => $entrevista['pregunta10']];

                    $estado = $this->UserModel->getAllOneRow('estados', $condiciones);

                    $estado = empty($estado) ? $entrevista['pregunta10'] : $estado['nombre'];

                    $caracteristicas .= ', ' . $entrevista['pregunta6'] . ', universidad ' . $tipo_institucion . '. Estado de ' . ucfirst($estado);

                    $html .= "<p style='margin-left:35px'><i>" . $codigo['codigo_en_vivo'] . ". (Entrevista #" . $codigo['id_entrevista'] . ". " . $caracteristicas . ")</i></p><br>";
                }
            }
        }

        $html .= "
        <h1 style='text-align:center'>Discusión</h1>
        <p>" . $data['discusion'] . "</p>
        ";

        $pdf = new TCPDF();

        $pdf->setPrintHeader(false);

        $pdf->AddPage('A4');

        $pdf->writeHTML($html, true, true, false, false, 'C');

        $this->response->setContentType('application/pdf');

        $pdf->Output("Ver.pdf", 'I');

        //echo $html;
    }

    public function getInfoEntrevista()
    {
        $id = $_POST['id_codigo'];
        $condiciones = ['id' => $id];
        $columnas = ['id_entrevista'];
        $id_entrevista = $this->UserModel->getColumnsOneRow($columnas, 'filtro_categorias', $condiciones);
        $id_entrevista = $id_entrevista['id_entrevista'];

        $columnas = ['pregunta1', 'pregunta2', 'pregunta3', 'pregunta4', 'pregunta12', 'pregunta6', 'pregunta10'];
        $condiciones = ['id' => $id_entrevista];
        $entrevista = $this->UserModel->getColumnsOneRow($columnas, 'entrevistas_Relmo', $condiciones);
        $caracteristicas = 'Estudiante Universitaria de ' . $entrevista['pregunta1'] . ' años, ' . ucfirst($entrevista['pregunta2']);
        $tipo_institucion = $entrevista['pregunta12'] == 'público' ? 'pública' : 'privada';
        $condiciones = ['id' => $entrevista['pregunta10']];
        $estado = $this->UserModel->getAllOneRow('estados', $condiciones);
        $estado = empty($estado) ? $entrevista['pregunta10'] : $estado['nombre'];
        $caracteristicas .= ', de ' . $entrevista['pregunta6'] . ', institución ' . $tipo_institucion . '.';
        $info = mb_strtoupper('Entrevista #' . $id_entrevista . '. ' . $caracteristicas);
        echo $info;
    }

    public function deleteCategorias()
    {

        $condiciones = [
            'claveCuerpo' => $_POST['claveCuerpo']
        ];

        if ($this->UserModel->generalDelete('filtro_categorias', $condiciones)) {
            $response['status'] = 'success';

            $response['message'] = 'Categorizaciones eliminadas correctamente';
        } else {
            $response['status'] = 'error';

            $response['message'] = 'Lo sentimos, ha ocurrido un error al eliminar la categoirzación. Intente mas tarde.';
        }

        echo json_encode($response);
    }

    public function confirmTipoAsistencia()
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST['tipo_asistencia'])) {
            if (!isset($_SESSION['is_logged'])) {
                if (!isset($_SESSION['is_logged'])) {
                    return redirect()->to(base_url())
                        ->with('icon', 'warning')
                        ->with('title', 'Opsss')
                        ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
                }
            } else {
                if (!isset($_SESSION['is_logged'])) {
                    return redirect()->back()
                        ->with('icon', 'warning')
                        ->with('title', 'Cuidado')
                        ->with('text', 'Seleccione una opción');
                }
            }
        }

        #AQUI SE AGREGARA EL GAFETE DE OYENTE AL USUARIO, SE HIZO UNO INDIVIDUAL PORQUE TIENE DATOS DIFERENTES, PERO EN SI
        #ES LO MISMO
        #TOMAREMOS EL NOMBRE DEL USUARIO

        $condiciones = ['usuario' => $_SESSION['usuario']];

        $usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);

        if (empty($usuario['ap_materno'] || $usuario['ap_materno'] == '' || $usuario['ap_materno'] == null)) {

            $nombre_completo = $usuario['nombre'] . ' ' . $usuario['ap_paterno'];
        } else {

            $nombre_completo = $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
        }

        if ($_POST['pagado'] == 0) {

            #NO HA PAGADO, UNA CONDICION CREO INCECESARIA PERO BUENO, NO ESTA DE MAS JAJAJAJ

            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Debe completar su pago para continuar');
        } else {

            $permitted_chars = 'ABCDEFGHJKLMNOPQRSTUVWXYZ123456789';

            $clave_gafete =  substr(str_shuffle($permitted_chars), 0, 6);

            $dataParticipantes = array(

                "clave_gafete" => $clave_gafete,

                "nombre" => $nombre_completo,

                "claveCuerpo" => $_SESSION["CA"],

                "anio" => date("Y"),

                "red" => $_SESSION["red"],

                "tipo_asistencia" => $_POST["tipo_asistencia"],

                'oyente' => 1,

                'usuario' => $_SESSION['usuario']

            );

            if ($this->UserModel->generalInsert("participantes_congresos", $dataParticipantes) == 1) {

                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', '¡Éxito!')
                    ->with('text', 'Registramos su tipo de asistencia. Lo esperamos en el evento 🥳');
            } else {

                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
            }
        }
    }

    public function infoCongreso()
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST['iquatro'])) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ingrese correctamente su clave de ponencia.');
            }
        }


        //$this->load->view('inicio/congreso');

        $contraseña = $_POST["iquatro"];

        $nombre_congreso = $_POST['nombre_congreso'];

        if ($contraseña != "") {

            #AQUI IQUATRO MANEJA 2 ID, PUBLICATION Y SUBMISSION
            #SUBMISSION ES EL PUBLICO DE IQUATRO, EL QUE VE LOS USUARIOS
            #PUBLICATION ES CON EL QUE NOSOTROS SACAMOS LA INFO A LAS BASES DE DATOS

            $columnas = [];

            array_push($columnas, 'id_iquatro');

            $condiciones = ['password' => $contraseña];

            #DE LA CONTRASEÑA NOS TRAEMOS EL SUBMISSION ID QUE CON ESE TRAEREMOS LA INFO DE IQUATRO

            $submission = $this->UserModel->getColumnsOneRow($columnas, 'password_ponencias', $condiciones);


            if ($submission === null || empty($submission)) {

                return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Clave incorrecta');
            }

            $submission = trim($submission['id_iquatro']);

            //HAY QUE TRAERNOS EL PUBLICATION ID

            $condiciones = ['submission_id' => $submission];

            $columnas = [];

            array_push($columnas, 'publication_id');

            $pub_id = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);

            if (empty($pub_id)) {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, intentelo mas tarde.');
            }


            //HAY QUE VERIFICAR SI YA HAY REGISTRO DE ELLO

            $condiciones = ['publication_id' => $pub_id["publication_id"]];


            $existe = $this->UserModel->exist('ponencias', $condiciones);

            if (!empty($existe)) {

                #LA PONENCIA YA ESTA REGISTRADA EN EL SISTEMA, LO MANDAMOS PARA ATRAS

                return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'La ponencia ya se encuentra registrada');
            } else {


                //NO EXISTE LA PONENCIA, SEGUIMOS EL PROCESO

                $data = [];

                $data['nombre_congreso'] = $nombre_congreso;
                $data['password_ponencia'] = $contraseña;
                #EXTRAEMOS EL NOMBRE DE LA PONENCIA DE MANERA SEPARADA PARA ASI ACTUALIZAR DE MANERA CORRECTA

                #=======PREFIJO=======

                $columnas = [];

                array_push($columnas, 'setting_value');
                array_push($columnas, 'locale');

                $condiciones = ['publication_id' => $pub_id['publication_id'], 'setting_name' => 'prefix'];

                $prefijo = $this->IquatroModel->getColumns($columnas, 'publication_settings', $condiciones); //$prefijo = $prefijo["setting_value"];

                if (array_search('es_ES', array_column($prefijo, 'locale')) !== false) {
                    foreach ($prefijo as $n) {
                        if ($n['locale'] == 'es_ES') {
                            //IDIOMA ESPAñOL
                            $prefijo = $n['setting_value'];
                            break;
                        }
                    }
                } else {
                    foreach ($prefijo as $n) {
                        if ($n['locale'] == 'en_US') {
                            //IDIOMA ESPAñOL
                            $prefijo = $n['setting_value'];
                            break;
                        }
                    }

                    if (is_array($prefijo) && empty($prefijo)) {
                        $prefijo = '';
                    }
                }

                #=======NOMBRE=======

                $columnas = [];

                array_push($columnas, 'setting_value');
                array_push($columnas, 'locale');

                $condiciones = ['publication_id' => $pub_id['publication_id'], 'setting_name' => 'title'];

                $nombre = $this->IquatroModel->getColumns($columnas, 'publication_settings', $condiciones);

                if (array_search('es_ES', array_column($nombre, 'locale')) !== false) {
                    foreach ($nombre as $n) {
                        if ($n['locale'] == 'es_ES') {
                            //IDIOMA ESPAñOL
                            $nombre = $n['setting_value'];
                            break;
                        }
                    }
                } else {
                    foreach ($nombre as $n) {
                        if ($n['locale'] == 'en_US') {
                            //IDIOMA ESPAñOL
                            $nombre = $n['setting_value'];
                            break;
                        }
                    }
                }

                #=======SUBTITULO=======

                $columnas = [];

                array_push($columnas, 'setting_value');
                array_push($columnas, 'locale');

                $condiciones = ['publication_id' => $pub_id['publication_id'], 'setting_name' => 'subtitle'];

                $subtitulo = $this->IquatroModel->getColumns($columnas, 'publication_settings', $condiciones);

                if (array_search('es_ES', array_column($subtitulo, 'locale')) !== false) {
                    foreach ($subtitulo as $n) {
                        if ($n['locale'] == 'es_ES') {
                            //IDIOMA ESPAñOL
                            $subtitulo = $n['setting_value'];
                            break;
                        }
                    }
                } else {
                    foreach ($subtitulo as $n) {
                        if ($n['locale'] == 'en_US') {
                            //IDIOMA ESPAñOL
                            $subtitulo = $n['setting_value'];
                            break;
                        }
                    }

                    if (is_array($subtitulo) && empty($subtitulo)) {
                        $subtitulo = '';
                    }
                }



                #HACEMOS EL CORRECTO FORMATO DEL NOMBRE DE LA PONENCIA

                if ($prefijo == "") {

                    if ($subtitulo == "") {

                        $nombre_ponencia = $nombre;
                    } else {

                        $nombre_ponencia = $nombre . ": " . $subtitulo;
                    }
                } else {

                    if ($subtitulo == "") {

                        $nombre_ponencia = $prefijo . " " . $nombre;
                    } else {
                        $nombre_ponencia = $prefijo . " " . $nombre . ": " . $subtitulo;
                    }
                }

                $data["ponencia"]["pub_id"] = $pub_id["publication_id"];

                $data["ponencia"]["submission_id"] = $submission;

                $data["ponencia"]["nombre"] = $nombre_ponencia;

                $data["ponencia"]["prefijo"] = $prefijo;

                $data["ponencia"]["titulo"] = $nombre;

                $data["ponencia"]["subtitulo"] = $subtitulo;

                #AHORA EXTRAEMOS EL NOMBRE DE LOS AUTORES DE LA PONENCIA

                $columnas = [];

                array_push($columnas, 'author_id');

                $condiciones = ['publication_id' => $pub_id["publication_id"]];


                $autores_id = $this->IquatroModel->getColumns($columnas, 'authors', $condiciones);

                $i = 0;

                foreach ($autores_id as $aut_id) {

                    $nombre_autor = $this->IquatroModel->nombre_autor($aut_id["author_id"]);

                    $data["ponencia"]["miembros"][$i]["author_id"] = $aut_id["author_id"];

                    $data["ponencia"]["miembros"][$i]["nombre"] = $nombre_autor["nombre"];

                    $data["ponencia"]["miembros"][$i]["apellidos"] = $nombre_autor["apellidos"];

                    $i++;
                }

                $condiciones = ['cuerpoAcademico' => $_SESSION['CA']];
                $columnas = ['usuario'];
                $miembros_ca = $this->UserModel->getAllColums($columnas, 'miembros', $condiciones);
                foreach ($miembros_ca as $m) {
                    $condiciones = ['usuario' => $m['usuario']];
                    $usuario_info = $this->UserModel->getAllOneRow('usuarios', $condiciones);
                    $nombre_usuario = empty($usuario_info['ap_materno']) ? $usuario_info['nombre'] . ' ' . $usuario_info['ap_paterno'] : $usuario_info['nombre'] . ' ' . $usuario_info['ap_paterno'] . ' ' . $usuario_info['ap_materno'];
                    $dataMiembros[] = [
                        'usuario' => $m['usuario'],
                        'nombre' => $nombre_usuario
                    ];
                }

                $data['miembros'] = $dataMiembros;

                $condiciones = ['nombre_red' => $_SESSION['red']];
                $red = $this->UserModel->getAllOneRow('redes', $condiciones);
                $data['color_red'] = $red['color_primario'];
                $data['color_secundario'] = $red['color_secundario'];
                $data['whatsapp'] = $red['whatsapp_congreso'];
                return view('usuarios/headers/index', $data)
                    . view('usuarios/formularios/congreso', $data)
                    . view('usuarios/footers/index');
            }
        } else {

            #EL USUARIO NO INGRESO UNA CONTRASEñA (LA INGRESO VACIA)

            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ingrese correctamente su clave de ponencia.');
        }
    }

    public function getOyente()
    {

        $claveCuerpo = $_POST['claveCuerpo'];

        $claveCuerpo = strtoupper($claveCuerpo);

        #comprobamos si la clave del cuerpo academico esta bien estructuralmente

        if (strpos($claveCuerpo, 'OY-' . strtoupper($_SESSION['red'])) === false) {
            http_response_code(500);
            $mensaje = 'Ingrese una clave válida. Esta debe iniciar con <b>OY-</b> y debe ser correspondiente a la red de ' . strtoupper($_SESSION['red']);
            echo $mensaje;
            exit;
        }

        #vamos a verificar si existe el cuerpo academico

        $condiciones = ['claveCuerpo' => $claveCuerpo];

        if (!$this->UserModel->exist('cuerpos_academicos', $condiciones)) {
            http_response_code(404);
            $mensaje = 'No existe la clave ingresada';
            echo $mensaje;
            exit;
        }

        #vamos a verificar si tiene el proyecto como oyente agregado y pagado

        #obtenemos datos del congreso

        $explode_congreso = explode(' ', $_POST['congreso']);

        $anio = $explode_congreso[2];

        #verificamos si tiene el proyecto agregado
        $nombre_proyecto = 'Oyente ' . $_SESSION['red'] . ' ' . $anio;

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'proyecto' => $nombre_proyecto];

        if (!$this->UserModel->exist('pagos', $condiciones)) {
            http_response_code(404);
            $mensaje = "El oyente no tiene el registrado el proyecto: <b>{$nombre_proyecto}</b>";
            echo $mensaje;
            exit;
        }

        #tiene el proyecto registrado, pero... lo tiene pagado??🤔🤔🤔

        $columnas = ['restante', 'moneda'];
        $info_proyecto = $this->UserModel->getColumnsOneRow($columnas, 'pagos', $condiciones);

        if ($info_proyecto['restante'] != 0) {
            http_response_code(404);
            $mensaje = "El oyente no tiene el proyecto pagado en su totalidad. Su adeudo es de: $<b>{$info_proyecto['restante']} {$info_proyecto['moneda']}</b>";
            echo $mensaje;
            exit;
        }

        #Ya paso todos los filtros, ahora vamos a obtener la info del miembro
        $condiciones = ['cuerpoAcademico' => $claveCuerpo];
        $columnas = ['usuario', 'grado'];
        $miembro = $this->UserModel->getColumnsOneRow($columnas, 'miembros', $condiciones);

        if (empty($miembro)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al obtener la información del oyente. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }
        $condiciones = ['usuario' => $miembro['usuario']];
        $usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);

        $condiciones = ['id' => $miembro['grado']];
        $grado = $this->UserModel->getAllOneRow('grado_academico', $condiciones);

        if (empty($grado)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al obtener la información del oyente. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        $data = [
            'nombre' => $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'],
            'usuario' => $usuario['usuario'],
            'profile_pic' => $usuario['profile_pic'],
            'grado' => $grado['abreviatura'],
            'claveCuerpo' => $claveCuerpo
        ];

        return json_encode($data);
    }

    public function insertarCongreso()
    {


        $nombre_congreso = $_POST['nombre_congreso'];
        $explode = explode(' ', $nombre_congreso);
        $anio = $explode[2];
        $nombre_congreso = str_replace(' ', '_', $nombre_congreso);

        if (!isset($_SESSION['is_logged'])) {
            http_response_code(401);
            $mensaje = 'Su sesión ha expirado. Inicie sesión nuevamente';
            echo $mensaje;
            exit;
        }

        if (!isset($_POST['titulo'])) {
            if (!isset($_SESSION['is_logged'])) {
                http_response_code(401);
                $mensaje = 'Su sesión ha expirado. Inicie sesión nuevamente';
                echo $mensaje;
                exit;
            } else {
                return redirect()->to('/proyecto/' . $nombre_congreso . '/' . $anio);
            }
        }

        if (!isset($_POST["checkbox"])) {
            http_response_code(500);
            $mensaje = 'Acepte las condiciones para continuar.';
            echo $mensaje;
            exit;
        }

        $data = $_POST;

        #TODOS LOS MISMBROS DEL CUERPO ACADEMICO TENDRAN CLAVES DE GAFETE
        #SI NO ESTAN DENTRO DE LA PONENCIA, SOLO TIENE ACCESO A OYENTE

        $nombre_completo_ponente = trim($data["nombre_completo_ponente"]);

        $prefijo = trim($data["prefijo"]);

        $titulo = trim($data["titulo"]);

        $subtitulo = trim($data["subtitulo"]);

        $pub_id = $data['pub_id'];

        $columnas = ['submission_id'];
        $condiciones = ['publication_id' => $pub_id];
        $submission_id = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);

        if (empty($submission_id)) {
            http_response_code(503);
            $mensaje = 'Ha ocurrido un error. Contacte con el equipo REDESLA.';
            echo $mensaje;
            exit;
        }

        $submission_id = $submission_id['submission_id'];

        $nombre_congreso = $data["nombre_congreso"];

        $tipo_asistencia = $data['tipo_asistencia'];

        $permitted_chars = 'ABCDEFGHJKLMNOPQRSTUVWXYZ123456789';

        #OBTENEMOS LOS MIEMBROS DEL CUERPO ACADEMICO
        $condiciones = ['cuerpoAcademico' => $_SESSION['CA']];
        $columnas = ['usuario'];
        $miembros_ca = $this->UserModel->getAllColums($columnas, 'miembros', $condiciones);

        if (empty($titulo)) {
            http_response_code(500);
            $mensaje = 'Existe un error en el nombre de su ponencia. Asegurese que el título <b>No este vacío</b>.';
            echo $mensaje;
            exit;
        }

        if (!isset($data['tipo_asistencia'])) {
            http_response_code(500);
            $mensaje = 'Seleccione el tipo de asistencia al evento.';
            echo $mensaje;
            exit;
        }

        foreach ($data['autores'] as $a) {
            if (empty($a)) {
                http_response_code(500);
                $mensaje = 'Los nombres y apellidos de los autores no pueden estar vacios.';
                echo $mensaje;
                exit;
            }
        }

        #ACTUALIZAMOS LA INFORMACION EN IQUATRO

        if (!empty($prefijo)) {

            $condiciones = ["publication_id" => $pub_id, "setting_name" => "prefix"];

            $dataUpdateIQ4 = ['setting_value' => $prefijo];

            if (!$this->IquatroModel->generalUpdate('publication_settings', $dataUpdateIQ4, $condiciones)) {
                http_response_code(500);
                $mensaje = 'Ha ocurrido un error al actualizar el prefijo de la ponencia.';
                echo $mensaje;
                exit;
            }
        }

        if (!empty($titulo)) {

            $condiciones = ["publication_id" => $pub_id, "setting_name" => "title"];

            $dataUpdateIQ4 = ['setting_value' => $titulo];

            if (!$this->IquatroModel->generalUpdate('publication_settings', $dataUpdateIQ4, $condiciones)) {
                http_response_code(500);
                $mensaje = 'Ha ocurrido un error al actualizar el título de la ponencia.';
                echo $mensaje;
                exit;
            }
        }

        if (!empty($subtitulo)) {

            $condiciones = ["publication_id" => $pub_id, "setting_name" => "subtitle"];

            $dataUpdateIQ4 = ['setting_value' => $subtitulo];

            if (!$this->IquatroModel->generalUpdate('publication_settings', $dataUpdateIQ4, $condiciones)) {
                http_response_code(500);
                $mensaje = 'Ha ocurrido un error al actualizar el subtítulo de la ponencia.';
                echo $mensaje;
                exit;
            }
        }

        #formateamos el nombre de la ponencia de nuevo

        if (empty($prefijo)) {

            if (empty($subtitulo)) {

                $nombre_ponencia = $titulo;
            } else {

                $nombre_ponencia = $titulo . ": " . $subtitulo;
            }
        } else {

            if (empty($subtitulo)) {

                $nombre_ponencia = $prefijo . " " . $titulo;
            } else {

                $nombre_ponencia = $prefijo . " " . $titulo . ": " . $subtitulo;
            }
        }

        #CREAMOS LA INFO PARA INSERTAR LA PONENCIA

        $clave_ponencia =  substr(str_shuffle($permitted_chars), 0, 5);

        $dataPonencia = [
            'claveCuerpo' => $_SESSION["CA"],
            'publication_id' => $pub_id,
            'nombre' => $nombre_ponencia,
            'ponente' => $nombre_completo_ponente,
            'clave_ponencia' => $clave_ponencia,
            'red' => $_SESSION["red"],
            'nombre_congreso' => $nombre_congreso,
            'anio' => $anio,
            'tipo_registro' => $tipo_asistencia,
            'submission_id' => $submission_id
        ];

        #dividimos el array de 2 en 2
        $chunks_autores = array_chunk($data['autores'], 2);

        #cada chunk corresponde a una posicion de $data[miembros]
        foreach ($chunks_autores as $key => $chunk) {

            $nombre_despues = $chunk[0] . ' ' . $chunk[1];
            $usuario = $data['miembros'][$key]['usuario'];
            $author_id = $data['id_autor'][$key];

            if ($usuario == 'nc') {
                #significa que no tendra acceso a absolotamente nada del congreso
                continue;
            } else if (isset($data['miembros'][$key]['tipo'])) {
                #significa que es externo
                $claveCuerpoMiembro = $data['miembros'][$key]['claveCuerpo'];
            } else {
                $claveCuerpoMiembro = $_SESSION['CA'];
                $clave = array_search($usuario, array_column($miembros_ca, 'usuario'));
                if ($clave !== false) {
                    unset($miembros_ca[$clave]);
                    $miembros_ca = array_values($miembros_ca); // Reindexamos el array
                    sort($miembros_ca); // Ordenamos el array
                }
            }
            $condiciones = ['usuario' => $usuario];
            $info_usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);
            $nombre_usuario = empty($info_usuario['ap_materno']) ? $info_usuario['nombre'] . ' ' . $info_usuario['ap_paterno'] : $info_usuario['nombre'] . ' ' . $info_usuario['ap_paterno'] . ' ' . $info_usuario['ap_materno'];



            $info_autor_iquatro = $this->IquatroModel->nombre_autor($author_id);

            if (empty($info_autor_iquatro)) {
                http_response_code(500);
                $mensaje = 'Ha ocurrido un error al obtener datos de los autores. Contacte a sistemas.';
                echo $mensaje;
                exit;
            }

            $original = $info_autor_iquatro["nombre"] . ' ' . $info_autor_iquatro["apellidos"];

            $condicionesNombre = ["setting_name" => 'givenName', "author_id" => $author_id];
            $condicionesApellidos = ["setting_name" => 'familyName', "author_id" => $author_id];
            $dataNombre = array("setting_value" => $chunk[0]);
            $dataApellidos = array("setting_value" => $chunk[1]);
            $this->IquatroModel->generalUpdate('author_settings', $dataNombre, $condicionesNombre);
            $this->IquatroModel->generalUpdate('author_settings', $dataApellidos, $condicionesApellidos);

            $clave_gafete =  substr(str_shuffle($permitted_chars), 0, 6);

            $dataParticipantes[] = [
                'clave_gafete' => $clave_gafete,
                'nombre' => $nombre_usuario,
                'claveCuerpo' => $claveCuerpoMiembro,
                'publication_id' => $pub_id,
                'submission_id' => $submission_id,
                'anio' => $anio,
                'author_id' => $author_id,
                'red' => $_SESSION["red"],
                'tipo_asistencia' => $tipo_asistencia, #USAMOS POST EN VEZ DE DATA PORQUE DON PROGRAMADOR SENIOR PUSO DATA COMO OTRA VARIABLE XD
                'usuario' => $usuario,
                'oyente' => '0',
                'nombre_congreso' => $nombre_congreso
            ];

            $data_historia_autor[] = [
                'id_auth' => $author_id,
                'publication_id' => $pub_id,
                'antes' => $original,
                'despues' => $nombre_despues,
                'fecha' => date("Y-m-d H:i:s"),
                'red' => $_SESSION['red']
            ];
        }

        if (!empty($miembros_ca)) {
            #significan que son de la red, pero los externos ocuparon su lugar
            #les asignamos claves de gafete de oyentes

            foreach ($miembros_ca as $m) {
                #obtenemos la informacion
                $condiciones = ['usuario' => $m['usuario']];
                $usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);

                $nombre_usuario = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
                $clave_gafete =  substr(str_shuffle($permitted_chars), 0, 6);

                $dataOyentesRed[] = [
                    'clave_gafete' => $clave_gafete,
                    'nombre' => $nombre_usuario,
                    'claveCuerpo' => $_SESSION['CA'],
                    'publication_id' => $pub_id,
                    'submission_id' => $submission_id,
                    'anio' => $anio,
                    'author_id' => 0,
                    'red' => $_SESSION["red"],
                    'tipo_asistencia' => $tipo_asistencia, #USAMOS POST EN VEZ DE DATA PORQUE DON PROGRAMADOR SENIOR PUSO DATA COMO OTRA VARIABLE XD
                    'usuario' => $m['usuario'],
                    'oyente' => 1,
                    'nombre_congreso' => $nombre_congreso
                ];
            }

            if (!$this->UserModel->generalInsertBatch('participantes_congresos', $dataOyentesRed)) {
                http_response_code(504);
                $mensaje = 'Ha ocurrido un error al insertar los participantes al congreso. Contacte a sistemas.';
                echo $mensaje;
                exit;
            }
        }

        if (!$this->UserModel->generalInsertBatch('cambios_congresos', $data_historia_autor)) {
            http_response_code(501);
            $mensaje = 'Ha ocurrido un error al insertar los cambios de los autores. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        if (!$this->UserModel->generalInsertBatch('participantes_congresos', $dataParticipantes)) {
            http_response_code(502);
            $mensaje = 'Ha ocurrido un error al insertar los participantes al congreso. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        if (!$this->UserModel->generalInsert('ponencias', $dataPonencia)) {
            http_response_code(503);
            $mensaje = 'Ha ocurrido un error al insertar la ponencia. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        $nombre_congreso_2 = str_replace(' ', '_', $nombre_congreso);

        $respuesta = array(
            "title" => "Hecho",
            'mensaje' => 'Se ha registrado la ponencia <b>' . $nombre_ponencia . '</b> en el <b>' . $nombre_congreso . '</b>',
            "codigo" => 200,
            "url" => '/proyecto/' . $nombre_congreso_2 . '/' . $anio,
        );
        $json_respuesta = json_encode($respuesta);
        echo $json_respuesta;
        exit;
    }

    public function descargarGafetes($anio)
    {
        #VAMOS A HACER LOS GAFETES
        #obtenemos los participantes del congreso

        $condiciones = [
            'red' => session('red'),
            'claveCuerpo' => session('CA'),
            'anio' => $anio
        ];

        $participantes = $this->UserModel->getAll('participantes_congresos', $condiciones);

        if (empty($participantes)) {
            return redirect()->back();
        }

        $_SESSION['anio_gafete'] = $anio;

        $pdf = new gafetesCongresos();

        $pdf->SetPrintHeader(true);

        $pdf->SetPrintFooter(false);

        $pdf->SetAutoPageBreak(true, 35);

        $pdf->SetAuthor('REDESLA - GAFETES DE ACCESO');

        $pdf->SetCreator('REDESLA');

        $pdf->SetTitle("GAFETES " . strtoupper(session('CA')));

        foreach ($participantes as $p) {

            // Agregar una página personalizada
            $width = 100;  // Ancho de la página en milímetros
            $height = 140; // Alto de la página en milímetros
            $pdf->AddPage('P', array($width, $height));

            $gafete = $this->generarGafete($p['clave_gafete']);

            // Definir las coordenadas y dimensiones del área de texto
            $x = 5;  // Posición X
            $y = 43;  // Posición Y
            $width = 90;  // Ancho del área
            $height = 13;  // Alto del área

            // Establecer el área de texto
            $pdf->SetXY($x, $y);

            // Configurar el estilo de fuente inicial
            $fontFamily = 'times';
            $fontSize = 16;

            $nombre = $p['nombre'];

            // Establecer el tamaño de fuente inicial
            $pdf->SetFont($fontFamily, '', $fontSize);



            /*
            #AUTOSIZE FONT
            // Obtener el ancho del texto con la fuente y el tamaño actual
            $textWidth = $pdf->GetStringWidth($texto);

            // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
            while ($textWidth > $width) {
                $fontSize -= 0.5;  // Reducir el tamaño de fuente
                $pdf->SetFont($fontFamily, '', $fontSize);
                $textWidth = $pdf->GetStringWidth($texto);
            }
            */
            $pdf->MultiCell($width, $height, $nombre, 0, 'C');

            $x = 5;  // Posición X
            $y = 65;  // Posición Y
            $width = 90;  // Ancho del área
            $height = 8;  // Alto del área

            // Establecer el área de texto
            $pdf->SetXY($x, $y);

            $claveGafete = $p['clave_gafete'];

            $pdf->MultiCell($width, $height, $claveGafete, 0, 'C');

            $x = 5;  // Posición X
            $y = 75;  // Posición Y
            $width = 90;  // Ancho del área
            $height = 0;  // Alto del área

            // Establecer el área de texto
            $pdf->SetXY($x, $y);

            $claveGafete = $gafete;

            $img_base64_encoded = $claveGafete;
            // Obtén la extensión de la imagen desde el encabezado base64
            $extension = explode('/', mime_content_type($img_base64_encoded))[1];

            // Decodifica la imagen base64
            $imageContent = base64_decode(explode(',', $img_base64_encoded)[1]);

            // Genera un nombre de archivo único para la imagen
            $filename = uniqid() . '.' . $extension;

            // Ruta de destino para guardar la imagen
            $destinationPath = ROOTPATH . '/resources/img/congresos/gafetes/temp/temp_' . $filename;

            // Guarda la imagen en el archivo
            file_put_contents($destinationPath, $imageContent);


            $img = '<div style="text-align: center">
            <img src="' . $destinationPath . '" width="80" height="80" >
            </div>';

            $pdf->writeHTMLCell($width, $height, $x, $y, $img, 0, 1, 0, true, 'C', true);
        }

        $this->response->setHeader('Content-Type', 'application/pdf');

        $pdf->Output("Gafetes_" . session('CA') . ".pdf", "I");

        unset($_SESSION['anio_gafete']);
    }

    private function generarGafete($clave_gafete)
    {
        $writer = new PngWriter();

        //Obtener color e imagen del código QR con respecto a la red
        $colorImagen =  $this->escogerColorImagenCodigoQr(ucfirst(session('red')));
        $color = $colorImagen[0];
        $imagen = $colorImagen[1];

        //Crear el código QR
        $qrCode = QrCode::create($clave_gafete)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor($color); // Set foreground color to red

        // Crear el logo del código
        $logo = Logo::create(ROOTPATH . '/resources/img/isotipos/' . $imagen)
            ->setResizeToWidth(100);

        $result = $writer->write($qrCode, $logo);

        // Obtener la URL de la imagen para poder desplegar la imagen
        //header('Content-Type: '.$result->getMimeType());
        return $result->getDataUri();
    }

    private function escogerColorImagenCodigoQr($red)
    {
        $rgbImagen = [new Color(0, 0, 0), 'Mapa_Redesla.png'];

        switch ($red) {
            case "Relayn":
                $rgbImagen[0] = new Color(47, 29, 0);
                $rgbImagen[1] = 'Mapa_Relayn.png';
                break;
            case "Releem":
                $rgbImagen[0] = new Color(36, 0, 47);
                $rgbImagen[1] = 'Mapa_Releem.png';
                break;
            case "Releg":
                $rgbImagen[0] = new Color(47, 0, 39);
                $rgbImagen[1] = 'Mapa_Releg.png';
                break;
            case "Relen":
                $rgbImagen[0] = new Color(47, 0, 0);
                $rgbImagen[1] = 'Mapa_Relen.png';
                break;
            case "Relep":
                $rgbImagen[0] = new Color(3, 47, 0);
                $rgbImagen[1] = 'Mapa_Relep.png';
                break;
            default:
                $rgbImagen[0] = new Color(0, 0, 0);
                $rgbImagen[1] = 'Mapa_Redesla.png';
                break;
        }

        return $rgbImagen;
    }

    public function visualizarEntrevista($id)
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (isset($_SESSION['esquema'])) {
        }

        $condiciones = ['id' => $id];

        $entrevista = $this->UserModel->getAllOneRow("entrevistas_Relmo", $condiciones);

        if (empty($entrevista)) {
            #NO EXISTE LA ENTREVISTA, PARA ATRAS
            return redirect()->to('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA'])
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'La entrevista no existe');
        }

        $data['data'] = $entrevista;

        /*Datos Intitucion*/

        $condiciones = ['id' => $entrevista['pregunta10']];

        $estado = $this->UserModel->getAllOneRow("estados", $condiciones);

        $data['data']['pregunta10'] = $estado["nombre"];

        $condiciones = ['id' => $entrevista['pregunta11']];

        $estado = $this->UserModel->getAllOneRow("municipios", $condiciones);

        $data['data']['pregunta11'] = $estado["nombre"];

        #obtenemos la lista de las categorias

        $condiciones = ['activo' => 1];
        $categorias = $this->UserModel->getAll('categorias', $condiciones);
        $data['categorias'] = $categorias;

        $condiciones = ["claveCuerpo" => $_SESSION["CA"], "redCueCa" => $_SESSION["red"]];

        $validacion = $this->UserModel->getAllOneRow("validacion", $condiciones);

        $data['validacion'] = $validacion['terminado'];

        #OBTENEMOS LA LISTA DE CATEGORIAS DE ESE ID DE ENTREVISTA

        $condiciones = ['id_entrevista' => $data['data']['id']];
        $listaCategorias = $this->UserModel->getAll('filtro_categorias', $condiciones);

        foreach ($data['data'] as $key => $d) {

            foreach ($listaCategorias as $l) {
                $existe = stripos($d, $l['codigo_en_vivo']);
                if ($existe !== false) {
                    #$key es la posicion del array en donde se encontro
                    #vamos a buscar el color con el que se identifica
                    $condiciones = ['id' => $l['categoria']];
                    $infoColor = $this->UserModel->getAllOneRow('categorias', $condiciones);
                    $remplazar = "<span class='e_" . $infoColor['color'] . "'>" . $l['codigo_en_vivo'] . "</span>";
                    #estilos_de_texto TIENE EL FORMATO AL QUE SE LE VA A DAR COLOR
                    $texto = str_replace($l['codigo_en_vivo'], $remplazar, $data['data'][$key]);
                    $data['data'][$key] = $texto;
                }
            }
        }

        $data['filtro_categorias'] = $listaCategorias;

        return view('usuarios/headers/index', $data)
            . view('usuarios/entrevistas', $data)
            . view('usuarios/footers/index');
    }

    public function visualizarBitacora($id)
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $pagina_anterior = $_SERVER['HTTP_REFERER'];

        $condiciones = ["id_entrevista" => $id];

        $bitacora = $this->UserModel->getAllOneRow("bitacoras_Relmo", $condiciones);

        if (empty($bitacora)) {

            #NO EXISTE LA ENTREVISTA, PARA ATRAS
            return redirect()->to('inicio/' . $_SESSION['red'] . '/' . $_SESSION['CA'])
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'La entrevista no existe');
        }

        $data["bitacora"] = $bitacora;

        $data["pagina_anterior"] = $pagina_anterior;

        return view('usuarios/headers/index', $data)
            . view('usuarios/bitacora', $data)
            . view('usuarios/footers/index');
    }

    public function takeid()
    {

        #FUNCION UBICADA EN VIEWS/VARIABLES/PROYECTOS

        if (isset($_POST['id'])) {

            $pagina_anterior = $_SERVER['HTTP_REFERER'];

            $_SESSION["pagina_anterior"] = $pagina_anterior;

            $_SESSION["id_recapturar"] = $_POST['id'];

            echo json_encode('nais');
        } else {

            echo json_encode('error');
        }
    }

    public function recapturarEntrevista()
    {

        #FUNCION UBICADA EN VIEWS/VARIABLES/PROYECTOS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (isset($_SESSION["id_recapturar"])) {

            $condicion = ["id_pais" => 2];

            $estados = $this->UserModel->getAll("estados", $condicion);

            $data["info"]["estados"] = $estados;

            return view('usuarios/recapturar', $data);
        } else {

            return redirect()->to(base_url());
        }
    }

    public function actRecapturarEntrevista()
    {

        #FUNCION UBICADA EN VIEWS/VARIABLES/PROYECTOS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_SESSION['id_recapturar'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Entre desde la plataforma redesla.la/redesla para acceder a este módulo');
        }

        $condiciones = ['id' => $_SESSION['id_recapturar']];

        $entrevista = $_POST;

        unset($entrevista["bitacora"]);

        $entrevista['editado'] = 1;

        if ($this->UserModel->generalUpdate("entrevistas_Relmo", $entrevista, $condiciones)) {

            $bitacora = [

                "bitacora" => $_POST["bitacora"],

                "fecha_insert" => date("F j, Y, g:i a")

            ];

            $condiciones = ['id_entrevista' => $_SESSION['id_recapturar']];

            $this->UserModel->generalUpdate("bitacoras_Relmo", $bitacora, $condiciones);

            $pag_ant = $_SESSION["pagina_anterior"];

            $id = $_SESSION['id_recapturar'];

            unset($_SESSION['id_recapturar']);

            unset($_SESSION["pagina_anterior"]);

            return redirect()->to($pag_ant)
                ->with('icon', 'success')
                ->with('title', 'Acción realizada correctamente')
                ->with('text', 'Su número de entrevista es el ' . $id . '. Favor de ingresar este número en su encuesta impresa');
        } else {

            $pag_ant = $_SESSION["pagina_anterior"];

            unset($_SESSION['id_recapturar']);

            unset($_SESSION["pagina_anterior"]);

            return redirect()->to($pag_ant)
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Intentelo mas tarde.');
        }
    }

    public function editarEntrevista()
    {

        #FUNCION UBICADA EN VIEWS/VARIABLES/PROYECTOS

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (isset($_SESSION["id_recapturar"])) {

            $condicion = ["id_pais" => 2];

            $estados = $this->UserModel->getAll("estados", $condicion);

            $data["info"]["estados"] = $estados;

            //traernos toda la info

            $condicion = ['id' => $_SESSION['id_recapturar']];

            $entrevista = $this->UserModel->getAllOneRow("entrevistas_Relmo", $condicion);

            $data['data'] = $entrevista;

            $condicion = ["id_entrevista" => $_SESSION['id_recapturar']];

            $bitacora = $this->UserModel->getAllOneRow("bitacoras_Relmo", $condicion);

            $data['bitacora'] = $bitacora['bitacora'];

            return view('usuarios/edits/entrevista', $data);


            //$this->load->view('edits/entrevista',$data);

        } else {

            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Entre desde la plataforma redesla.la/redesla para acceder a este módulo');
        }
    }

    public function addCategoria()
    {
        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        };

        $data = $_POST;

        if ($this->UserModel->generalInsert('filtro_categorias', $data) == 1) {
            return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'Categoria agregada correctamente')
                ->with('text', 'Su categoria se registro a la entrevista #' . $data['id_entrevista']);
        }
    }

    public function getMunicipioID($id)
    {

        #Lo que hace es tomar el nombre del municipio en base al id, se utiliza en el modulo de 
        #editar entrevista de relmo

        $id_municipio = $id;

        $condiciones = ['id' => $id_municipio];

        $municipio_seleccionado = $this->UserModel->getAllOneRow('municipios', $condiciones);

        $condiciones = ['id_estado' => $_POST['estado']];

        $municipios = $this->UserModel->getAll('municipios', $condiciones);

        $html = '';

        foreach ($municipios as $m) {

            if ($m['id'] == $municipio_seleccionado['id']) {
                $html .= "<option selected value='" . $m['id'] . "'>" . $m['nombre'] . "</option>";
            } else {
                $html .= "<option value='" . $m['id'] . "'>" . $m['nombre'] . "</option>";
            }
        }

        echo $html;
    }

    public function borrarEntrevista($id)
    {

        $condiciones_delete = array("id" => $id);

        $delete = $this->UserModel->generalDelete("entrevistas_Relmo", $condiciones_delete);

        $condiciones_delete = array("id_entrevista" => $id);

        $delete = $this->UserModel->generalDelete("bitacoras_Relmo", $condiciones_delete);

        if ($delete) {

            $response['status'] = 'success';

            $response['message'] = 'Entrevista eliminada correctamente';
        } else {

            $response['status'] = 'error';

            $response['message'] = 'No se puede eliminar la entrevista';
        }

        echo json_encode($response);
    }

    public function orden($tipo)
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        if (!isset($_POST['valParam'])) {
            if (!isset($_SESSION['is_logged'])) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            } else {
                return redirect()->to(base_url('inicio/') . $_SESSION['red'] . '/' . $_SESSION['CA']);
            }
        }

        $data = json_decode($_POST["valParam"]); //decodificamos el array en json para manejarlo en PHP

        $i = 1; //inicializamos la posicion en 1

        foreach ($data as $d) { //recorreremos el array

            //Tenemos que actualizar sus datos en miembros

            $tipo == 'impreso' ? $columna = "orden_impreso" : $columna = 'orden_digital';

            $condiciones = ['id' => $d];

            $data = [$columna => $i];

            $update = $this->UserModel->generalUpdate('miembros', $data, $condiciones);

            $i++; //aumentamos a la siguiente posision 1->2->3

        }

        echo json_encode($update);
    }

    public function validacionRelmo($nombre)
    {

        $nombre = urldecode($nombre);

        $condiciones = array(

            'claveCuerpo' => $_SESSION['CA'],

            'redCueCa' => $_SESSION["red"],

            'nombre_proyecto' => $nombre,

        );

        $existencia = $this->UserModel->getAllOneRow("validacion", $condiciones);

        if (empty($existencia)) {

            $cadena = $nombre;

            $anio = intval(preg_replace('/[^0-9]+/', '', $cadena), 10);

            #OBTENEMOS EL ANIO DLE NOMBRE DEL PROYECTO

            $data = array(

                'claveCuerpo' => $_SESSION["CA"],

                'terminado' => 1,

                'redCueCa' => $_SESSION["red"],

                'nombre_proyecto' => $nombre,

                "anio" => $anio

            );

            if ($this->UserModel->generalInsert("validacion", $data) == 1) {

                $response['status'] = 'success';

                $response['message'] = 'Validación enviada correctamente';
            } else {

                $response['status'] = 'error';

                $response['message'] = 'No se pudo enviar la validación de las entrevistas';
            }

            echo json_encode($response);
        } else {
            #YA EXISTE UN PROCESO

            if ($existencia['terminado'] == 0) {

                #EL USUARIO FUE RECHAZADO Y VA A VOLER A ENVIAR SU VALIDACION

                $data = array('terminado' => 4);

                $condiciones = array(

                    'claveCuerpo' => $_SESSION["CA"],

                    'redCueCa' => $_SESSION["red"],

                    'nombre_proyecto' => $nombre

                );

                if ($this->UserModel->generalUpdate('validacion', $data, $condiciones) == 1) {

                    $response['status'] = 'success';

                    $response['message'] = 'Validación enviada correctamente';
                } else {

                    $response['status'] = 'error';

                    $response['message'] = 'No se pudo enviar la validación de las entrevistas';
                }

                echo json_encode($response);
            } else if ($existencia['terminado'] == 3) {

                //EL USUARIO REENVIARA LA VALIDACION DE LA PRIMERA FASE

                $data = array('terminado' => 4);

                $condiciones = array(

                    'claveCuerpo' => $_SESSION["CA"],

                    'redCueCa' => $_SESSION["red"],

                    'nombre_proyecto' => $nombre

                );


                if ($this->UserModel->generalUpdate('validacion', $data, $condiciones) == 1) {

                    $response['status'] = 'success';

                    $response['message'] = 'Validación enviada correctamente';
                } else {

                    $response['status'] = 'error';

                    $response['message'] = 'No se pudo enviar la validación de las entrevistas';
                }

                echo json_encode($response);
            } else if ($existencia['terminado'] == 2) {

                #EL USUARIO VA A VALIDAR LA 2DA FASE POR PRIMERA VEZ

                $data = array('terminado' => 5);

                $condiciones = array(

                    'claveCuerpo' => $_SESSION["CA"],

                    'redCueCa' => $_SESSION["red"],

                    'nombre_proyecto' => $nombre

                );


                if ($this->UserModel->generalUpdate('validacion', $data, $condiciones) == 1) {

                    $response['status'] = 'success';

                    $response['message'] = 'Validación enviada correctamente';
                } else {

                    $response['status'] = 'error';

                    $response['message'] = 'No se pudo enviar la validación de las entrevistas';
                }

                echo json_encode($response);
            } else if ($existencia['terminado'] == 7) {

                //EL USUARIO REENVIARA LA VALIDACION DE LA SEGUNDA FASE

                $data = array('terminado' => 8);

                $condiciones = array(

                    'claveCuerpo' => $_SESSION["CA"],

                    'redCueCa' => $_SESSION["red"],

                    'nombre_proyecto' => $nombre

                );


                if ($this->UserModel->generalUpdate('validacion', $data, $condiciones) == 1) {

                    $response['status'] = 'success';

                    $response['message'] = 'Validación enviada correctamente';
                } else {

                    $response['status'] = 'error';

                    $response['message'] = 'No se pudo enviar la validación de las entrevistas';
                }

                echo json_encode($response);
            } else if ($existencia['terminado'] == 9) {

                //EL USUARIO REENVIARA LA VALIDACION DE LA SEGUNDA FASE

                $data = array('terminado' => 8);

                $condiciones = array(

                    'claveCuerpo' => $_SESSION["CA"],

                    'redCueCa' => $_SESSION["red"],

                    'nombre_proyecto' => $nombre

                );


                if ($this->UserModel->generalUpdate('validacion', $data, $condiciones) == 1) {

                    $response['status'] = 'success';

                    $response['message'] = 'Validación enviada correctamente';
                } else {

                    $response['status'] = 'error';

                    $response['message'] = 'No se pudo enviar la validación de las entrevistas';
                }

                echo json_encode($response);
            }
        }
    }

    public function agregarCategoria()
    {

        if (!isset($_SESSION['is_logged'])) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $data = [
            'nombre' => $_POST["nombre"],
            'descripcion' => $_POST["descripcion"],
            'codigo_en_vivo' => $_POST["codigo_en_vivo"],
            'claveCuerpo' => $_SESSION['CA'],
            'activo' => 0
        ];

        if ($this->UserModel->generalInsert('categorias', $data) == 1) {
            return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'Enviada')
                ->with('text', 'Su propuesta estará siendo válidada por el equipo RELEG');
        } else {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intente mas tarde');
        }
    }

    public function cambio_red()
    {
        $condiciones = [];
        $constancias = $this->UserModel->getAll('constancia_releg', $condiciones);
        foreach ($constancias as $c) {
            $folio = str_replace('Relmo', 'Releg', $c['folio_completo']);
            $data = ['folio_completo' => $folio];
            $condiciones = ['id' => $c['id']];
            $this->UserModel->generalUpdate('constancia_releg', $data, $condiciones);
        }
    }

    public function cambio_pagos()
    {
        $condiciones = [];
        $pagos = $this->UserModel->getAll('pagos', $condiciones);
        foreach ($pagos as $p) {
            $nombre = str_replace('Relmo', 'Releg', $p['proyecto']);
            echo $nombre;
            $data = ['proyecto' => $nombre];
            $condiciones = ['id' => $p['id']];
            $this->UserModel->generalUpdate('pagos', $data, $condiciones);
        }
    }

    public function cambio_validacion()
    {
        $condiciones = [];
        $validacion = $this->UserModel->getAll('validacion', $condiciones);
        foreach ($validacion as $p) {
            $nombre = str_replace('Relmo', 'Releg', $p['nombre_proyecto']);
            $data = ['nombre_proyecto' => $nombre];
            $condiciones = ['id' => $p['id']];
            $this->UserModel->generalUpdate('validacion', $data, $condiciones);
        }
    }

    public function eliminar_cev()
    {
        #ESTA FUNCION ES PARA ELIMINAR UN CODIGO EN VIVO DE RELEG
        $condiciones = $_POST;

        if ($this->UserModel->generalDelete('filtro_categorias', $condiciones) == 1) {
            return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'Listo')
                ->with('text', 'El código en vivo ha sido eliminado');
        } else {
        }
        return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error, favor de intentarlo mas tarde');
    }

    public function getMiembros()
    {
        $condiciones = ['cuerpoAcademico' => $_SESSION['CA']];
        $columnas = ['usuario', 'especialidad', 'grado'];
        $miembros = $this->UserModel->getAllColums($columnas, 'miembros', $condiciones);
        foreach ($miembros as $m) {
            $condiciones = ['usuario' => $m['usuario']];
            $usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);
            $profile_pic = $usuario['profile_pic'] == null ? 'avatar.png' : $usuario['profile_pic'];
            $datos_miembro = $this->UserModel->getAllOneRow('miembros', $condiciones);
            $condiciones = ['id' => $datos_miembro['grado']];
            $info_grado = $this->UserModel->getAllOneRow('grado_academico', $condiciones);
            $str_academico = $info_grado['abreviatura'] . ' en ' . ucfirst($datos_miembro['especialidad']);
            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $data[] = [
                'nombre' => $nombre,
                'profile_pic' => $profile_pic,
                'usuario' => $usuario['usuario'],
                'especialidad' => $str_academico
            ];
        }
        return $this->response->setJSON($data);
    }

    public function orden_libros($tipo_orden, $anio)
    {

        $ordenes_aceptados = ['impreso', 'digital'];

        if (!in_array($tipo_orden, $ordenes_aceptados)) {
            //No es un ordne valido, para atras
        }
        $columna = 'orden_' . $tipo_orden;
        $i = 1;
        foreach ($_POST['usuarios'] as $a) {

            $condiciones = [
                'usuario' => $a,
                'claveCuerpo' => $_SESSION['CA'],
                'anio' => $anio
            ];
            if ($this->UserModel->exist('ordenes_autores', $condiciones)) {
                $data = [
                    $columna => $i
                ];
                $this->UserModel->generalUpdate('ordenes_autores', $data, $condiciones);
            } else {
                $data = [
                    $columna => $i,
                    'usuario' => $a,
                    'claveCuerpo' => $_SESSION['CA'],
                    'anio' => $anio
                ];
                $this->UserModel->generalInsert('ordenes_autores', $data);
            }

            $i++;
        }

        return redirect()->back()
            ->with('icon', 'success')
            ->with('title', 'Éxito')
            ->with('text', 'Orden de autores del libro ' . $tipo_orden . ' registrado correctamente.');
    }

    public function getMiembrosRegistrados($tipo_orden, $anio)
    {

        $ordenes_aceptados = ['impreso', 'digital'];

        if (!in_array($tipo_orden, $ordenes_aceptados)) {
            //No es un ordne valido, para atras
        }

        $columna = 'orden_' . $tipo_orden;

        $condiciones = [
            'claveCuerpo' => $_SESSION['CA'],
            'anio' => $anio
        ];
        $columnas = ['usuario', $columna];

        $usuarios_ordenes = $this->UserModel->getColumnsOrderBy($columnas, 'ordenes_autores', $condiciones, $columna . ' ASC');
        #$columnas = [$columna,'usuario','grado','especialidad'];
        #$miembros = $this->UserModel->getColumnsOrderBy($columnas,'miembros',$condiciones,$columna.' ASC');

        foreach ($usuarios_ordenes as $m) {
            $condiciones = ['usuario' => $m['usuario']];
            $usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);
            $profile_pic = $usuario['profile_pic'] == null ? 'avatar.png' : $usuario['profile_pic'];
            $datos_miembro = $this->UserModel->getAllOneRow('miembros', $condiciones);
            $condiciones = ['id' => $datos_miembro['grado']];
            $info_grado = $this->UserModel->getAllOneRow('grado_academico', $condiciones);
            $str_academico = $info_grado['abreviatura'] . ' en ' . ucfirst($datos_miembro['especialidad']);
            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $data[] = [
                'nombre' => $nombre,
                'profile_pic' => $profile_pic,
                'usuario' => $usuario['usuario'],
                'especialidad' => $str_academico
            ];
        }
        return $this->response->setJSON($data);
    }

    public function capituloRelegDigital($claveCuerpo, $pass)
    {

        $condiciones = ["claveCuerpo" => $claveCuerpo, "password" => $pass, 'redCueCa' => 'Releg'];

        if (!$this->UserModel->exist('cuerpos_academicos', $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Url no válida.');
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
        $orden_autores = $this->UserModel->getAll('ordenes_autores', $condiciones);
        #orden_digital
        $key_sort3  = array_column($orden_autores, 'orden_digital');
        array_multisort($key_sort3, SORT_ASC, $orden_autores);

        if (empty($orden_autores)) {
            #tenemos que buscar el proyecto que registraron
            $condiciones = ['claveCuerpo' => $claveCuerpo];
            $validacion = $this->UserModel->getAllOneRow('validacion', $condiciones);
            $nombre_proyecto = $validacion['nombre_proyecto'];

            $condiciones = ['cuerpoAcademico' => $claveCuerpo];
            $columnas = ['usuario'];
            $usuarios = $this->UserModel->getAllColums($columnas, 'miembros', $condiciones);

            foreach ($usuarios as $key => $u) {
                if ($nombre_proyecto == 'Esquema A: Investigación Releg 2022') {
                    #solo digital
                    $data = [
                        'claveCuerpo' => $claveCuerpo,
                        'anio' => 2022,
                        'orden_digital' => intval($key + 1),
                        'usuario' => $u['usuario']
                    ];
                    $this->UserModel->generalInsert('ordenes_autores', $data);
                } else if ($nombre_proyecto == 'Esquema B: Investigación Releg 2022') {
                    #digital e impreso
                    $data = [
                        'claveCuerpo' => $claveCuerpo,
                        'anio' => 2022,
                        'orden_digital' => intval($key + 1),
                        'orden_impreso' => intval($key + 1),
                        'usuario' => $u['usuario']
                    ];
                    $this->UserModel->generalInsert('ordenes_autores', $data);
                }
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
            $orden_autores = $this->UserModel->getAll('ordenes_autores', $condiciones);
        }

        foreach ($orden_autores as $key4 => $o) {
            $condiciones = ['usuario' => $o['usuario']];
            $usuario = $this->UserModel->getAllOneRow('usuarios', $condiciones);
            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $data['ordenes_autores'][] = $nombre;
        }

        #tomamos las categorias
        $columnas = ['categoria'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $categorias = $this->UserModel->getAllDistinc($columnas, "filtro_categorias", $condiciones);

        $str_categorias = '';
        foreach ($categorias as $key => $c) {
            $data['categorias'][$key]['id'] = $c['categoria'];
            $condiciones = ['id' => $c['categoria']];
            $info_categoria = $this->UserModel->getAllOneRow('categorias', $condiciones);
            if (empty($info_categoria)) {
                echo 'No existe la categoria, ha existido un error y regresar';
                return;
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['categoria']];
            $cantidad = $this->UserModel->count('filtro_categorias', $condiciones);


            $explode_nombre_categoria = explode(': ', $info_categoria['nombre']);
            $nombre_solo = substr($explode_nombre_categoria[1], 0, -1);
            $str_categorias .= $nombre_solo . ', ';

            $data['categorias'][$key]['nombre'] = $info_categoria['nombre'];
            $data['categorias'][$key]['descripcion'] = $info_categoria['descripcion'];
            $data['categorias'][$key]['color'] = $info_categoria['color'];
            $data['categorias'][$key]['cantidad'] = $cantidad;
        }

        $explode_cat = explode(', ', $str_categorias);
        $last_cat = end($explode_cat);
        if ($last_cat == '') {
            array_pop($explode_cat);
            $last_cat = end($explode_cat);
        }
        $str_categorias = str_replace(", $last_cat", " y $last_cat", $str_categorias, $count);
        $str_categorias = strtolower($str_categorias);
        $str_categorias = substr($str_categorias, 0, -2);

        $data['str_categorias'] = $str_categorias;

        #TRAERTE LOS GRUPOS
        #TOMAR LAS CATEGORIAS
        #DE LAS CATEGORIAS TOMAR LOS FILTROS
        #DE LOS FILTROS TOMAR LAS ENTREVISTAS

        $condiciones = [];
        $dimensiones = $this->UserModel->getAll('dimensiones', $condiciones);



        $arr_grupos = [];

        foreach ($dimensiones as $key => $g) {
            #obtenemos las escalas (si aplica)
            $condiciones = ['id_dimension' => $g['id']];
            $escalas = $this->UserModel->getAll('escalas', $condiciones);

            $arr_grupos[$key]['nombre'] = $g['nombre'];

            $c_categorias = 0;

            if (!empty($escalas)) {
                foreach ($escalas as $keyEscalas => $e) {
                    $arr_grupos[$key]['escalas'][$keyEscalas]['nombre'] = $e['nombre'];
                    $condiciones = ['dimension' => $g['id'], 'escala' => $e['id']];
                    $categorias = $this->UserModel->getAll('categorias', $condiciones);

                    foreach ($categorias as $key2 => $c) {
                        $arr_grupos[$key]['escalas'][$keyEscalas]['categorias'][$key2]['nombre'] = $c['nombre'];

                        $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['id']];
                        $columnas = ['id_entrevista'];
                        $filtro = $this->UserModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
                        $c_categorias++;
                        #$arr_grupos[$key]['categorias'][$key2]['entrevistas'] = $filtro;
                        #$arr_grupos[$key]['escalas'][$e['id']]['categorias'][$key2]['entrevistas'] = $filtro;
                    }
                }
                #$arr_grupos[$key]['c_categorias'] = $c_categorias;
                continue;
            }

            $condiciones = ['dimension' => $g['id']];
            $categorias = $this->UserModel->getAll('categorias', $condiciones);

            #$arr_grupos[$key]['nombre'] = $g['nombre'];

            foreach ($categorias as $key2 => $c) {
                $arr_grupos[$key]['categorias'][$key2]['nombre'] = $c['nombre'];
                $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['id']];
                $columnas = ['id_entrevista'];
                $filtro = $this->UserModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
                $c_categorias++;
                #$arr_grupos[$key]['categorias'][$key2]['entrevistas'] = $filtro;

            }
            #$arr_grupos[$key]['c_categorias'] = $c_categorias;
        }

        echo '<pre>';
        #print_r($arr_grupos);
        echo '</pre>';
        #exit;


        $data['dimensiones'] = json_encode($arr_grupos);

        return view('usuarios/proyectos/capitulo_digital', $data);
    }

    public function getDigitalReleg()
    {

        $data = [
            'discusion' => $_POST['discusion'],
            'anio' => 2022,
            'claveCuerpo' => $_SESSION['CA']
        ];

        if (!$this->UserModel->generalInsert('capitulo_digital_releg', $data)) {
            http_response_code(501);
            $mensaje = 'Ha ocurrido un error al registrar su discusión. Contacte al equipo REDESLA.';
            echo $mensaje;
            exit;
        }

        $dataUpdate = ['terminado' => 15];
        $condiciones = [
            'claveCuerpo' => $_SESSION["CA"],
            'redCueCa' => $_SESSION["red"],
        ];

        if (!$this->UserModel->generalUpdate('validacion', $dataUpdate, $condiciones)) {
            http_response_code(502);
            $mensaje = 'Ha ocurrido un error al registrar su discusión. Contacte al equipo REDESLA.';
            echo $mensaje;
            exit;
        }

        $return = [
            'title' => 'Éxito',
            'text' => 'Capitulo digital en proceso de revisión por el comite revisór RELEG. Espere instrucciones',
        ];

        echo json_encode($return);
        exit;
    }

    public function passwordUserChange()
    {
        echo password_hash('P4sionPorL4Inv3stigacion#2023', PASSWORD_DEFAULT);
    }

    public function insertDiscusion(){

        //INSERTAMOS LA DISCUSION

        $data = [
            'discusion' => $_POST['discusion']
        ];

        $condiciones = ['claveCuerpo' => $_SESSION['CA']];

        if(!$this->UserModel->generalUpdate('capitulos_releg',$data,$condiciones)){
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Intente mas tarde.');
        }

        return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'Éxito')
                ->with('text', 'Discusión insertada correctamente.');
    }

    public function insertDiscusionDigital(){
        $data = [
            'discusion' => $_POST['discusion'],
            'anio' => 2022,
            'claveCuerpo' => $_SESSION['CA']
        ];

        if (!$this->UserModel->generalInsert('capitulo_digital_releg', $data)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Intente mas tarde.');
        }

        $dataUpdate = ['terminado' => 15];
        $condiciones = [
            'claveCuerpo' => $_SESSION["CA"],
            'redCueCa' => $_SESSION["red"],
        ];

        if (!$this->UserModel->generalUpdate('validacion', $dataUpdate, $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Intente mas tarde.');
        }

        return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'Éxito')
                ->with('text', 'Discusión insertada correctamente.');
    }
}
