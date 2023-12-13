<?php

#TODO VA A SER UNA API

namespace App\Controllers;


require_once 'vendor/autoload.php';

use App\Models\AdminModel;
use App\Models\IquatroModel;
use CodeIgniter\Exceptions\PageNotFoundException;

use CodeIgniter\HTTP\Response;
use PhpParser\Node\Stmt\Else_;

use App\Models\CuestionariosModel;
use App\Models\CursosModel;
use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS\Root;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpWord\PhpWord;

use CodeIgniter\Files\File;
use CodeIgniter\HTTP\DownloadResponse;
use NumberFormatter;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Smalot\PdfParser\Parser;


use TCPDF;
use ZipArchive;

use function PHPSTORM_META\map;
use function PHPUnit\Framework\isNull;

class CartasTCPDF extends TCPDF
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
        $img_file = base_url('resources/img/membretadas/libros/' . $_SESSION['red'] . '.png');
        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        $this->SetMargins(10, 42, 10);
    }
}

class CartasDictamenCongresoTCPDF extends TCPDF
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
        $img_file = base_url('resources/img/membretadas/iQuatro.jpg');
        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        $this->SetMargins(10, 40, 10);
    }
}

class dc3Pdf extends TCPDF
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
        $img_file = base_url('resources/img/cursos/dc3.jpg');
        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        $this->SetMargins(10, 40, 10);
    }
}

class AdminController extends BaseController
{

    public $db_serv;
    public $db_serv_cuest;
    public $CuestionariosModel;
    public $AdminModel;
    public $IquatroModel;
    public $db_cursos;
    public $CursosModel;
    public $charsUsuario;

    public $apikey;
    public $privateApiKey;
    public $rutaApi;

    public function __construct()
    {
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $this->AdminModel = new AdminModel();
        $this->CuestionariosModel = new CuestionariosModel();
        $this->CursosModel = new CursosModel();
        $this->db_serv = \Config\Database::connect();
        $this->charsUsuario = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        //PRUEBAS//
        /*
        $this->apikey = 'JDJ5JDEwJHc4ZVQ3dm10dU9OOERudC5YSEo2bk9NN1NvWnRPM0R6OURnWWkvQTRoRFlZUHQvYXNFMmJD';
        $this->privateApiKey = 'JDJ5JDEwJC5UM3pMR3RobEFFRkVLcUZISW5kdnVZV2d4dUZOYmZGVU4zVkduS09kMU03cEx1MG41cXRL';
        $this->rutaApi = 'https://sandbox.factura.com/api';
        */

        //PRODUCCION//
        
        $this->apikey = 'JDJ5JDEwJEZlVGJGRzJybExZdzVMOEwwNkMzR2VhSVdTT1FqSFhiU016S3M1VFUxSGpQUGdZR0VMSUYu';  //GRUPO
        $this->privateApiKey = 'JDJ5JDEwJEpMQW04SjdXWXRhL0RxUEZNV1ZBdi5HR2NUUTFHTW0wV2VkNzVJMUN6WTdDOU1hdFBaWjJl'; //GRUPO
        $this->rutaApi = 'https://api.factura.com';
        
    }

    function visualizadorMails($img = null)
    {

        if (!$img) {
            $img = $this->request->getGet('img');
        }

        if ($img == '') {
            throw PageNotFoundException::forPageNotFound();
        }

        $name = WRITEPATH . 'uploads/ckeditor/' . $img;

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

    function visualizadorComprobantes($img = null)
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

    function visualizadorCSF($img = null)
    {

        if (!$img) {
            $img = $this->request->getGet('img');
        }

        if ($img == '') {
            throw PageNotFoundException::forPageNotFound();
        }

        $name = WRITEPATH . 'uploads/csf/' . $img;

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

    function descargarArchivos($case, $archivo)
    {
        // Ruta del archivo a descargar


        // Ruta del archivo a descargar


        switch ($case) {
            case 'capitulo_releg':
                $ruta = 'public/docx/investigaciones/Releg/2022/';
                break;
            case 'capitulo_releg_digital':
                $ruta = 'public/docx/investigaciones/Releg/2022/digital/';
                break;
            case 'zipFactura':
                $ruta = 'public/zip/factura/';
                break;
            default:
                $ruta = '';
                break;
        }
        $nombreArchivo = $archivo;
        $ruta_completo = ROOTPATH . $ruta . $nombreArchivo;


        // Comprueba si el archivo existe
        if (!file_exists($ruta_completo)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('El archivo no existe');
        }

        // Obtener el tamaño del archivo
        $filesize = filesize($ruta_completo);

        $file = new \CodeIgniter\Files\File($ruta_completo);
        $nombreArchivo = $file->getFilename();

        if ($case == 'zipFactura') {
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
            header('Content-Length: ' . $filesize);
        } else {
            // Establecer los encabezados HTTP
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename=' . $nombreArchivo);
            header('Content-Length: ' . $filesize);
        }



        // Descargar el archivo
        readfile($ruta_completo);
    }

    public function generalUpdate($tabla)
    {

        #ACTUALIZA LA INFO A LA BASE DE DATOS DE MANERA GENERAL, CON LA UNICA CONDICION DEL ID

        if (session('user_type') == 0) {
            return redirect()->to(base_url());
        }

        if (!isset($_POST['id'])) {
            if (session('user_type') == 0) {
                return redirect()->to(base_url())
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
            }
        }

        $form = $_POST;

        #PASARA POR UN TERCER FILTRO PARA EVITAR DATOS VACIOS, ESTE LO MANDARA AL INICIO GENERAL
        #NO CREO QUE PASE HASTA ESTE PUNTO PERO POR SI LAS MOSCAS

        foreach ($form as $f) {
            if (trim($f) == "") {
                return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Complete los datos correctamente');
            }
        }

        #TOMAMOS EL ID DEL ARRAY Y HACEMOS LA CONDICION

        $id = $form['id'];

        $condiciones = ['id' => $id];

        #LO ELIMINAMOS DEL ARRAY AL QUE VAMOS A HACER UPDATE

        unset($form['id']);

        $form['updated_by'] = session('nombre');

        #HACEMOS EL UPDATE

        if ($this->AdminModel->generalUpdate($tabla, $form, $condiciones)) {
            #EL UPDATE FUNCIONO, HACEMOS REDIRECCIONES

            switch ($tabla) {
                case 'miembros':
                    return redirect()->to(base_url('admin/miembros/lista'))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
                case 'cuerpos_academicos':
                    return redirect()->to(base_url('admin/cuerpos/editar/' . $id))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
                case 'usuarios':
                    return redirect()->to(base_url('admin/usuarios/lista'))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
                case 'libros':
                    return redirect()->to(base_url('admin/libros/lista'))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
                case 'proyectos':
                    return redirect()->to(base_url('admin/proyectos/lista'))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
                case 'factura':
                    return redirect()->to(base_url('admin/finanzas/facturas/lista'))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
                default:
                    return redirect()->to(base_url('admin'))
                        ->with('icon', 'success')
                        ->with('title', '¡ÉXITO!')
                        ->with('text', 'Información actualizada correctamente');
                    break;
            }
        } else {

            #OCURRIO UN ERROR AL HACER UPDATE, PA ATRAS

            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intentelo mas tarde. Codigo de error: 101');
        }
    }

    #==================== FUNCIONES QUE SE VAN A DEJAR =======================

    private function pre($data){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }

    public function index(){

        if (session('user_type') == 0) {
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/index')
            . view('admin/footers/index');
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

    public function usuarios(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/usuarios/index')
            . view('admin/footers/index');
    }

    public function getListadoUsuarios(){

        $columnas = [
            'id', 'nombre', 'ap_paterno', 'ap_materno', 'usuario', 'correo', 'correo_institucional'
        ];

        $tabla = 'usuarios';

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function editUsuario($id){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $usuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);
        if (empty($usuario)) {
            #NO HAY REGISTROS
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'Esta intentando acceder a un registro inexistente');
        }
        //Mostrarenos una vista para que el admin edite los datos
        $data['usuario'] = $usuario;

        return view('admin/headers/index')
            . view('admin/usuarios/editar', $data)
            . view('admin/footers/index');
    }

    public function updateUsuario(){
        //NO SE PUEDE INGRESAR POR GET A ESTA DIRECCION
        //LO HACEMOS INDIVIDUAL PORQUE CADA UNO TIENE CONDICIONES ESPECIFICAS
        #PENDIENTE ACTUALIZAR LA FOTO DE PERFIL

        /*
        if ($imgFile = $this->request->getFile('profile_pic')) {
            echo 'hi';
            if ($imgFile->isValid() && !$imgFile->hasMoved()) {
                $validated = $this->validate([
                    'profile_pic' => [
                        'uploaded[profile_pic]',
                        'mime_in[profile_pic,image/png,image/jpeg,image/jpg,application/pdf]',
                        'max_size[profile_pic,5000]'
                    ]
                ]);

                if (!$validated){
                    return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Cuidado')
                    ->with('text', 'Los archivos aceptados son PNG, JPEG, JPG Y PDF y su peso debe ser menor a 5MB');
                }

                echo 'hihihi';
            }
        }
        */

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'ap_paterno' => $_POST['ap_paterno'],
            'ap_materno' => $_POST['ap_materno'],
            'correo' => $_POST['correo'],
            'correo_institucional' => $_POST['correo_institucional'],
            'sexo' => $_POST['sexo'],
            'updated_by' => session('nombre')
        ];

        if (!empty($_POST['password'])) {
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $data['password'] = $pass;
        }

        $condiciones = ['id' => $_POST['id']];


        if ($this->AdminModel->generalUpdate('usuarios', $data, $condiciones)) {
            return redirect()->to(base_url('/admin/usuarios/lista'))
                ->with('icon', 'success')
                ->with('title', '¡Éxito!')
                ->with('text', 'Registro modificado correctamente');
        } else {
            return redirect()->to(base_url('/admin/usuarios/lista'))
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
        }
    }

    public function eliminarUsuario(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        //Al eliminar un usuario se eliminaran de las siguientes tablas

        /*

        MIEMBROS

        HISTORIA_USUARIOS

        PAGOS (NO)

        MOVIMIENTOS (NO)

        PAGOS Y MOVIMIENTOS NO YA QUE ESTOS PERTENECEN AL CUERPO ACADEMICO, EL USUARIO YA NO ESTA PERO LA DEUDA EXISTE
        */

        $columnas = ['usuario'];
        $condiciones = ['id' => $_POST['id']];
        $miembro = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);

        $condiciones = ['id' => $_POST['id']];

        if (!$this->AdminModel->exist('usuarios', $condiciones)) {
            return 'empty';
        }

        $condiciones = array("usuario" => $miembro['usuario']);

        $this->AdminModel->generalDelete("miembros", $condiciones);

        $this->AdminModel->generalDelete("historia_usuarios", $condiciones);

        //$pagos = $this->AdminModel->getAll("pagos", $condiciones);

        //$this->AdminModel->generalDelete("factura", $condiciones);

        //$this->AdminModel->generalDelete("facturas_admin", $condiciones);

        $usuario = $this->AdminModel->generalDelete("usuarios", $condiciones);

        /*
        foreach ($pagos as $p) {

            $id = $p["id"];

            $condicion = array("id_pago" => $id);

            $movimiento = $this->AdminModel->generalDelete("movimientos", $condicion);

            $condicion_pago = array("id" => $id);

            $pago = $this->AdminModel->generalDelete("pagos", $condicion_pago);

        }
        */

        if ($usuario) {
            return 'success';
        } else {
            return 'error';
        }
    }
    
    public function agregarUsuario(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/usuarios/agregar')
            . view('admin/footers/index');
    }

    public function submitUsuario(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $pass = password_hash($_POST['correo'], PASSWORD_DEFAULT);
        if(!empty($_POST['password'])){
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $usuario = $this->generateRandom(20);

        $data = [
            'nombre' => $_POST['nombre'],
            'ap_paterno' => $_POST['ap_paterno'],
            'ap_materno' => $_POST['ap_materno'],
            'sexo' => $_POST['sexo'],
            'correo' => $_POST['correo'],
            'password' => $pass,
            'usuario' => $usuario,
            'tipo_usuario' => 1
        ];

        if(!$this->AdminModel->generalInsert('usuarios',$data)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error, intentelo mas tarde');
        }else{
            return redirect()->to(base_url('/admin/usuarios/lista'))
                ->with('icon', 'success')
                ->with('title', '¡Éxito!')
                ->with('text', 'Usuario agregado correctamente');
        }
    }

    public function facturas(){
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/facturas/lista')
            . view('admin/footers/index');
    }

    public function facturasTodo(){
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $columnas = ['fecha_factura'];

        $anios = $this->AdminModel->getDistinctYears('fecha_factura','facturas',[]);

        $data = [
            'anios' => $anios
        ];

        return view('admin/headers/index')
            . view('admin/facturas/todoLista',$data)
            . view('admin/footers/index');
    }

    public function validateArchivosFacturas($admin)
{
    // Validar la autenticación o permisos adecuados aquí

    $anio = isset($_POST['anio']) ? $_POST['anio'] : null;
    $mes = isset($_POST['mes']) ? $_POST['mes'] : null;

    // Validar y sanear las variables POST según sea necesario

    $condiciones = $admin == 1 ? [] : ['usuario' => session('usuario')];
    $facturas = $this->AdminModel->getFacturasPorAnioMes($anio, $mes, $condiciones);

    if (empty($facturas)) {
        http_response_code(404); // Cambié el código de respuesta HTTP a 404 para "No encontrado"
        echo json_encode(['error' => 'No se encontraron facturas para la fecha especificada']);
        return;
    }

    $zip = new ZipArchive();

    // Manejo de errores al abrir el archivo ZIP
    if ($zip->open('archivo.zip', ZipArchive::CREATE) !== true) {
        http_response_code(500); // Error interno del servidor
        echo json_encode(['error' => 'Error al crear el archivo ZIP']);
        return;
    }

    foreach($facturas as $f){
        $carpeta = "Factura_ID_{$f['id']}";
        $zip->addEmptyDir($carpeta);

        $blobPDF = $f['factura_pdf'];
        $ruta = "$carpeta/Factura.pdf";
        $zip->addFromString($ruta, $blobPDF);

        if($f['factura_xml'] != null){
            $blobXML = $f['factura_xml'];
            $ruta = "$carpeta/Factura.xml";
            $zip->addFromString($ruta, $blobXML);
        }

        $archivoDetalles = 'Detalles.txt';
        $pathDigital = "$carpeta/$archivoDetalles";

        $condiciones = ['id' => $f['metodo_pago']];
        $metodo_pago = $this->AdminModel->getAllOneRow('metodos_pago',$condiciones);

        $str_metodo = empty($metodo_pago) ? $f['metodo_pago'] : $metodo_pago['nombre'];

        $condiciones = ['id' => $f['provedor']];
        $provedor = $this->AdminModel->getAllOneRow('provedores',$condiciones);

        $str_provedor = empty($provedor) ? $f['provedor'] : $provedor['nombre'];

        $condiciones = ['usuario' => $f['inserted_by']];
        $usuario = $this->AdminModel->getAllOneRow('usuarios',$condiciones);

        $nombre_usuario = $usuario['nombre'].' '.$usuario['ap_paterno'].' '.$usuario['ap_materno'];

        $contenido = "
        ID de la factura: ".$f['id']." \n
        Provedor: ".$str_provedor." \n
        Método de pago: ".$str_metodo." \n
        Detalles: ".$f['detalles']." \n
        Monto: ".$f['monto']." ".$f['moneda']." \n
        Fecha del pago: ".$f['fecha_pago']." \n
        Fecha de la factura: ".$f['fecha_factura']." \n
        Factura insertada por: ".$nombre_usuario."
        ";

        file_put_contents($archivoDetalles, $contenido);
        
        
        $zip->addFile($archivoDetalles, $pathDigital);

    }
    

    $zip->close();
    // Leer el contenido del archivo ZIP
    $zipContent = file_get_contents('archivo.zip');
    // Envía el JSON antes de enviar el archivo ZIP
    $this->response->setHeader('Content-Type', 'application/zip');
    $this->response->setHeader('Content-Disposition', 'attachment; filename="archivo.zip"');

    $zipName = "Facturas_".$this->obtenerNombreMes($_POST['mes'])."_".$_POST['anio'];
    $zipName .= $admin == 1 ? '.zip' : "_".session('nombre').'_.zip';
    echo json_encode([
        'success' => true, 
        'zipContent' => base64_encode($zipContent),
        'zipName' => $zipName
    ]);

    // Elimina el archivo ZIP después de enviarlo
    unlink('archivo.zip');
}

    private function obtenerNombreMes($numeroMes) {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];
    
        // Verificar si el número de mes está en el rango permitido
        if ($numeroMes >= 1 && $numeroMes <= 12) {
            return $meses[$numeroMes];
        } else {
            return 'Mes no válido';
        }
    }




    public function getListadoFacturas(){
        
        $columnas = [
            'id', 'provedor', 'detalles', 'monto', 'moneda',
            'fecha_pago','fecha_factura','fecha_insert','inserted_by','metodo_pago'
        ];

        $tabla = 'facturas';

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
            'inner_join' => [
                'usuarios' => [
                    'join' => "usuarios.usuario = {$tabla}.inserted_by",
                    'columnas' => ['nombre','ap_paterno','ap_materno'],
                    'type' => 'LEFT JOIN'
                ],
                'provedores' => [
                    'join' => "provedores.id = {$tabla}.provedor",
                    'columnas' => ['nombre'],
                    'type' => 'LEFT JOIN'
                ],
                'metodos_pago' => [
                    'join' => "metodos_pago.id = {$tabla}.metodo_pago",
                    'columnas' => ['nombre'],
                    'type' => 'LEFT JOIN'
                ],
            ],
            'where' => "{$tabla}.inserted_by = '".session('usuario')."'"
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);

    }

    public function getListadoFacturasTodo(){
        
        $columnas = [
            'id', 'provedor', 'detalles', 'monto', 'moneda',
            'fecha_pago','fecha_factura','fecha_insert','inserted_by','metodo_pago'
        ];

        $tabla = 'facturas';

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
            'inner_join' => [
                'usuarios' => [
                    'join' => "usuarios.usuario = {$tabla}.inserted_by",
                    'columnas' => ['nombre','ap_paterno','ap_materno'],
                    'type' => 'LEFT JOIN'
                ],
                'provedores' => [
                    'join' => "provedores.id = {$tabla}.provedor",
                    'columnas' => ['nombre'],
                    'type' => 'LEFT JOIN'
                ],
                'metodos_pago' => [
                    'join' => "metodos_pago.id = {$tabla}.metodo_pago",
                    'columnas' => ['nombre'],
                    'type' => 'LEFT JOIN'
                ],
            ],
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);

    }

    public function subirFacturas(){

        $columnas = ['nombre'];
        $provedores = $this->AdminModel->getAllColums($columnas,'provedores',[]);

        $columnas = ['nombre'];
        $metodos = $this->AdminModel->getAllColums($columnas,'metodos_pago',[]);


        $data = [
            'provedores' => $provedores,
            'metodos' => $metodos
        ];

        return view('admin/headers/index')
            . view('admin/facturas/subir',$data)
            . view('admin/footers/index');
    }

    public function insertFacturas(){
        if (session('user_type') == 0 ) {
            session_destroy();
            return redirect()->to(base_url());
        }

        if($_POST['moneda'] == 'MXN'){
            $format = new NumberFormatter('es_MX',NumberFormatter::CURRENCY);
        }else{
            $format = new NumberFormatter('en_US',NumberFormatter::CURRENCY);
        }

        $monto = $format->formatCurrency($_POST['monto'],$_POST['moneda']);

        $condiciones = ['nombre' => $_POST['provedor']];

        if( $this->AdminModel->exist('provedores',$condiciones) ){
            #El provedor existe, tomamos el id
            $columnas = ['id'];
            $provedor = $this->AdminModel->getColumnsOneRow($columnas,'provedores',$condiciones);
            $id_provedor = $provedor['id'];
        }else{
            #El provedor no existe, lo añadimos y tomamos su id
            $dataInsert = [
                'nombre' => $_POST['provedor'],
                'inserted_by' => session('usuario')
            ];

            $id_provedor = $this->AdminModel->generalInsertLastId($dataInsert,'provedores');
            $new_provedor = true;
        }

        $condiciones = ['nombre' => $_POST['metodo_pago']];

        if( $this->AdminModel->exist('metodos_pago',$condiciones) ){
            #El provedor existe, tomamos el id
            $columnas = ['id'];
            $metodo_pago = $this->AdminModel->getColumnsOneRow($columnas,'metodos_pago',$condiciones);
            $id_metodo = $metodo_pago['id'];
        }else{
            #El provedor no existe, lo añadimos y tomamos su id
            $dataInsert = [
                'nombre' => $_POST['metodo_pago'],
                'inserted_by' => session('usuario')
            ];

            $id_metodo = $this->AdminModel->generalInsertLastId($dataInsert,'metodos_pago');
            $new_metodo = true;
        }


        $file_tmp = $_FILES['facturaPDF']['tmp_name'];

        $fp = fopen($file_tmp, 'r+b');
        $binario_pdf = fread($fp, filesize($file_tmp));
        fclose($fp);

        if( $_FILES['facturaXML']['size'] > 0){
            $file_tmp = $_FILES['facturaXML']['tmp_name'];
            $fp = fopen($file_tmp, 'r+b');
            $binario_xml = fread($fp, filesize($file_tmp));
            fclose($fp);
        }





        $data = [
            'provedor' => $id_provedor,
            'detalles' => $_POST['detalles'],
            'monto' => $monto,
            'moneda' => $_POST['moneda'],
            'fecha_pago' => $_POST['fecha_pago'],
            'fecha_factura' => $_POST['fecha_factura'],
            'factura_pdf' => $binario_pdf,
            'factura_xml' => isset($binario_xml) ? $binario_xml : null,
            'metodo_pago' => $id_metodo,
            'inserted_by' => session('usuario')
        ];

        if( !$this->AdminModel->generalInsert('facturas',$data) ){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error, contacte a sistemas. Código de error: 300');
        }

        $mensaje = 'Factura insertada correctamente. ';

        if(isset($new_provedor)){
            $mensaje .= 'Agrego un nuevo provedor, complete su información en el módulo de provedores. ';
        }

        if(isset($new_provedor)){
            $mensaje .= 'Agrego un nuevo método de pago, complete su información en el módulo de métodos de pago. ';
        }

        return redirect()->to(base_url('admin/facturas/lista'))
            ->with('icon', 'success')
            ->with('title', 'Éxito')
            ->with('text', $mensaje);
    }

    public function downloadBlobFiles($tipo, $id) {
        $condiciones = [
            'id' => $id
        ];
        $columnas = ['factura_' . $tipo, 'fecha_factura'];

        $archivo = $this->AdminModel->getColumnsOneRow($columnas, 'facturas', $condiciones);

        // Verifica si se encontró el archivo
        if (!$archivo) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        if($archivo['factura_' . $tipo] === null){
            return redirect()->back()
            ->with('icon', 'info')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Esta factura no tiene un XML asociado.');
        }

        $blobData = $archivo['factura_' . $tipo];
        $nombreArchivo = 'Factura_' . $id . '_' . $archivo['fecha_factura'];

        // Configura las cabeceras adicionales según el tipo de archivo
        if ($tipo == 'pdf') {
            $this->response->setHeader('Content-Type', 'application/pdf');
            $this->response->setHeader('Content-Disposition', 'attachment; filename=' . $nombreArchivo . '.pdf');
        } elseif ($tipo == 'xml') {
            $this->response->setHeader('Content-Type', 'text/xml');
            $this->response->setHeader('Content-Disposition', 'attachment; filename=' . $nombreArchivo . '.xml');
        } else {
            return response()->json(['error' => 'Tipo de archivo no admitido'], 400);
        }

        // Envía los datos binarios del BLOB
        echo $blobData;
    }

    public function viewBlobFiles($tipo, $id) {
        $condiciones = [
            'id' => $id
        ];
        $columnas = ['factura_' . $tipo, 'fecha_factura'];

        $archivo = $this->AdminModel->getColumnsOneRow($columnas, 'facturas', $condiciones);

        // Verifica si se encontró el archivo
        if (!$archivo) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        if($archivo['factura_' . $tipo] === null){
            return redirect()->back()
            ->with('icon', 'info')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Esta factura no tiene un XML asociado.');
        }

        $blobData = $archivo['factura_' . $tipo];
        $nombreArchivo = 'Factura_' . $id . '_' . $archivo['fecha_factura'];

        // Configura las cabeceras adicionales según el tipo de archivo
        if ($tipo == 'pdf') {
            $this->response->setHeader('Content-Type', 'application/pdf');
            $this->response->setHeader('Content-Disposition', 'inline; filename=' . $nombreArchivo . '.pdf');
        } elseif ($tipo == 'xml') {
            $this->response->setHeader('Content-Type', 'text/xml');
            $this->response->setHeader('Content-Disposition', 'inline; filename=' . $nombreArchivo . '.xml');
        } else {
            return response()->json(['error' => 'Tipo de archivo no admitido'], 400);
        }

        // Envía los datos binarios del BLOB
        echo $blobData;
    }

    public function provedores(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/provedores/lista')
            . view('admin/footers/index');
    }

    public function getListadoUProvedores(){

        $columnas = [
            'id', 'nombre', 'direccion', 'inserted_by'
        ];

        $tabla = 'provedores';

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
            'inner_join' => [
                'usuarios' => [
                    'join' => "usuarios.usuario = {$tabla}.inserted_by",
                    'columnas' => ['nombre','ap_paterno','ap_materno'],
                    'type' => 'LEFT JOIN'
                ],
            ],
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function updateProvedores(){

        $update = [
            'nombre' => $_POST['nombre'],
            'direccion' => $_POST['direccion'],
            'updated_by' => session('usuario'),
            'fecha_update' => $this->getDateTime()
        ];
        $condiciones = ['id' => $_POST['id']];

        if( !$this->AdminModel->generalUpdate('provedores',$update,$condiciones) ){
            http_response_code(700);
            exit;
        }
        return true;
    }

    public function deleteProvedores(){


        $columnas = ['id', 'provedor'];
        $condiciones = ['provedor' => $_POST['id']];

        $facturas = $this->AdminModel->getAllColums($columnas,'facturas',$condiciones);

        if(!empty($facturas)){
            foreach($facturas as $f){
                $condiciones = ['id' => $f['id']];
                $dataUpdate = ['provedor' => 'Provedor eliminado por '.session('nombre_completo').', actualizar registro.'];
                $this->AdminModel->generalUpdate('facturas',$dataUpdate,$condiciones);
            }
        }

        $condiciones = ['id' => $_POST['id']];

        if( !$this->AdminModel->generalDelete('provedores',$condiciones) ){
            http_response_code(700);
            exit;
        }
        return true;
    }

    public function addProvedores(){

        $data = [
            'nombre' => $_POST['nombre'],
            'direccion' => $_POST['direccion'],
            'inserted_by' => session('usuario')
        ];

        if( !$this->AdminModel->generalInsert('provedores',$data) ){
            http_response_code(801);
            echo 'Error al insertar el registro. Contacte a sistemas';
            exit;
        }

        return json_encode(true);


    }

    public function metodosPago(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/metodos_pago/lista')
            . view('admin/footers/index');
    }

    public function addMetodosPago(){


        if(isset($_POST['numero'])){
            $numero_tarjeta = $_POST['numero'];

            $condiciones = ['numero' => $numero_tarjeta, 'nombre' => $_POST['nombre']];
    
            if( $this->AdminModel->exist('metodos_pago',$condiciones) ){
                http_response_code(800);
                echo 'La tarjeta ya existe en el sistema';
                exit;
            }
        }else{
            $numero_tarjeta = 'NA';
        }

        $data = [
            'nombre' => $_POST['nombre'],
            'numero' => $numero_tarjeta,
            'tipo_tarjeta' => $_POST['tipo_tarjeta'],
            'inserted_by' => session('usuario')
        ];

        if( !$this->AdminModel->generalInsert('metodos_pago',$data) ){
            http_response_code(801);
            echo 'Error al insertar el registro. Contacte a sistemas';
            exit;
        }

        return json_encode(true);


    }

    public function getListadoMetodos(){

        $columnas = [
            'id', 'nombre', 'numero', 'tipo_tarjeta', 'fecha_registro', 'inserted_by'
        ];

        $tabla = 'metodos_pago';

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
            'inner_join' => [
                'usuarios' => [
                    'join' => "usuarios.usuario = {$tabla}.inserted_by",
                    'columnas' => ['nombre','ap_paterno','ap_materno'],
                    'type' => 'LEFT JOIN'
                ],
            ],
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function updateMetodosPago(){

        $fecha_update = $this->getDateTime();

        $condiciones = [
            'id' => $_POST['id']
        ];

        $dataUpdate = [
            'nombre' => $_POST['nombre'],
            'numero' => $_POST['numero'],
            'tipo_tarjeta' => $_POST['tipo_tarjeta'],
            'fecha_update' => $fecha_update,
            'updated_by' => session('usuario')
        ];

        if( !$this->AdminModel->generalUpdate('metodos_pago',$dataUpdate,$condiciones) ){
            http_response_code(800);
            echo 'Ocurrio un problema al acualizar el registro. Contacte a sistemas.';
            exit;
        }

        return json_encode(true);
    }

    public function deleteMetodosPago(){

        $columnas = ['id', 'metodo_pago'];
        $condiciones = ['metodo_pago' => $_POST['id']];

        $metodos = $this->AdminModel->getAllColums($columnas,'facturas',$condiciones);

        if(!empty($metodos)){
            foreach($metodos as $m){
                $condiciones = ['id' => $m['id']];
                $dataUpdate = ['metodo_pago' => 'Método de pago eliminado por '.session('nombre_completo').', actualizar registro.'];
                $this->AdminModel->generalUpdate('facturas',$dataUpdate,$condiciones);
            }
        }

        $condiciones = ['id' => $_POST['id']];

        if( !$this->AdminModel->generalDelete('metodos_pago',$condiciones) ){
            http_response_code(700);
            exit;
        }
        return true;
    }

    private function getDateTime(){
        return date("Y-m-d H:i:s");
    }


    public function eliminarFactura(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        //sacamos el id del post
        $condiciones = ['id' => $_POST['id']];
        //sacamos las columnas que queremos
        $columnas = ['id_factura','id_pago'];
        $factura = $this->AdminModel->getColumnsOneRow($columnas, 'facturas_admin', $condiciones);
        $id_factura = $factura['id_factura'];
        $condiciones = ['id'=> $id_factura];
        $columnas = ['id_movimientos','fecha_insercion','csf'];
        $factura_info = $this->AdminModel->getColumnsOneRow($columnas, 'factura', $condiciones);
        //Traernos la clave del cuerpo el cual sirve para el envio de correos
        $condiciones = ['id' => $factura['id_pago']];
        $columnas = ['claveCuerpo'];
        $claveCuerpo = $this->AdminModel->getColumnsOneRow($columnas,'pagos',$condiciones);
        $claveCuerpo = $claveCuerpo['claveCuerpo'];
        
       
        /*Eliminacion de los comprobantes de movimientos */
        if(empty($factura_info)){
            //No encontro informacion de la factura
            http_response_code(100);
            exit;
        }else {
            $id_movimientos_string = $factura_info['id_movimientos'];
            $id_movimientos_array = explode(',', $id_movimientos_string);
            if (end($id_movimientos_array) == '') {
                array_pop($id_movimientos_array);
            }
        
            /*Repeticion de una accion mediante el foreach en el cual se actualiza 
             los movimientos pertenecientes a la factura que se va a eliminar*/

            foreach ($id_movimientos_array as $id_movimiento) {
                $id_movimiento = intval($id_movimiento);
                $condiciones = ['id' => $id_movimiento];
                $data = ['facturado' => 0];
                    /*Actualización del estado de los movimientos */
                    if(!$this->AdminModel->generalUpdate('movimientos',$data,$condiciones)){
                        http_response_code(200);
                        exit;
                    }


            }

            /*Eliminación de la carta de situación fiscal */
            $csf = $factura_info['csf'];
            $path_csf = FCPATH . 'writable/uploads/csf/' . $csf;
                    
                if(!empty($csf)){
                    // Verifica si el archivo existe y si es un archivo válido para $name2
                    if (file_exists($path_csf) && is_file($path_csf)) {
                        // Elimina el archivo de comprobante para $name2
                        unlink($path_csf);
                    }
                }
        }

            /*Eliminación de los datos de la tabla de facturas */
            $condiciones = ['id'=> $id_factura];
            if(!$this->AdminModel->generalDelete('facturas',$condiciones)){
                http_response_code(300);
                exit;
            }


        //Obtenemos los correos de los miembros del cuerpo academico para enviarles un correo
        
        $columnas = ['usuario'];
        $condiciones = ['cuerpoAcademico' => $claveCuerpo];
        $miembros = $this->AdminModel->getAllColums($columnas,'miembros',$condiciones);
       
        if(empty($miembros)){
            http_response_code(400);
            exit;
        }
        
        $correos = ['pmejiaa@redesla.la']; #Variable en donde se almacenaran todos los correos a donde se van a enviar
        foreach($miembros as $m){
            $condiciones = ['usuario' => $m['usuario']];
            $columnas = ['correo'];
            $usuario = $this->AdminModel->getColumnsOneRow($columnas,'usuarios',$condiciones);
            
            if(!empty($usuario)){
                array_push($correos,$usuario['correo']);
            }
        }

        $msj = $_POST['mensaje'];

        $html = '';

        $email = \Config\Services::email();
        $email->setFrom('atencion@redesla.la', 'Equipo REDESLA'); //Quien lo manda
        $email->setTo($correos);
        $email->setSubject('Solicitud de movimiento RECHAZADO para corrección'); //Pendiente
        $email->setMessage($html);

        if (!$email->send()) {
            //No se pudieron enviar los correos
            http_response_code(600);
            exit;
        } 

        http_response_code(200);
        exit;
                    $fecha_emision_factura =  $factura_info['fecha_insercion'];

                    #Envio de correo de factura rechazada.
                

                    $html = "
                    <p>Estimados investigadores del grupo <b>{$claveCuerpo}</b></p>
                    <p>
                    El Equipo RedesLA informa que su factura emitida el {$fecha_emision_factura} ha sido cancelada y/o eliminada, rectificar sus datos para la solicitud nuevamente.
                    </p>
                    <p>Detalles:</p>
                    <p>{$msj}</p>
                    <p>
                    Sin más que agregar, quedamos atentos para cualquier duda o comentario al respecto.
                    </p>
                    <p>
                    <b>IMPORTANTE</b>, Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma en día hábil, en un horario no mayor a las 15:00 horas (Centro de México).
                    </p>" ;
        
        $condiciones = ['id' => $_POST['id']];
        if(!$this->AdminModel->generalDelete('facturas_admin',$condiciones)){
            http_response_code(600);
            exit;
        }else{
            return 'success';
        }

    }

    #====================USUARIOS=======================

    #====================CUERPOS ACADEMICOS=======================

    public function cuerpos()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/cuerpos/index')
            . view('admin/footers/index');
    }

    public function getListadoCuerpos()
    {
        $columnas = [
            'id', 'redCueCa', 'claveCuerpo', 'nombre', 'inst_est',
            'nombre_rector', 'grado_rector', 'activo', 'pais', 'estado', 'municipio',
            'tipo_registro', 'nombre_prodep', 'medio_entero'
        ];

        $tabla = 'cuerpos_academicos';

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
            'inner_join' => [
                'pais' => [
                    'join' => "pais.id = {$tabla}.pais",
                    'columnas' => ['nombre']
                ],
                'estados' => [
                    'join' => "estados.id = {$tabla}.estado",
                    'columnas' => ['nombre']
                ],
                'municipios' => [
                    'join' => "municipios.id = {$tabla}.municipio",
                    'columnas' => ['nombre'],
                    'type' => 'LEFT JOIN'
                ],
                'grado_academico' => [
                    'join' => "grado_academico.id = {$tabla}.grado_rector",
                    'columnas' => ['nombre']
                ],
                'miembros' => [
                    'join' => "miembros.cuerpoAcademico = {$tabla}.claveCuerpo AND miembros.lider = 1",
                    'columnas' => ['nombre','apaterno','amaterno','telefono'],
                    'type' => 'LEFT JOIN'
                ],
                'usuarios' => [
                    'join' => "usuarios.usuario = miembros.usuario AND miembros.lider = 1",
                    'columnas' => ['correo','correo_institucional'],
                    'type' => 'LEFT JOIN'
                ],
            ],
            #'where' => "movimientos.id_pago = 12"
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        /* echo '<pre>';
        print_r($array);
        echo '</pre>';
        exit; */

        /* foreach ($array as $key => $c) {

            $array[$key] = [
                "id" => $c['id'],
                "redCueCa" => $c['redCueCa'],
                "claveCuerpo" => $c['claveCuerpo'],
                "nombre_institucion" => $c['nombre'],
                "zona_estudio" => $c['inst_est'],
                "nombre_rector" => $c['nombre_rector'],
                "grado_rector" => $c['grado_academico_nombre'],
                "nombre_lider" => $nombreLider,
                "tel_lider" => $telLider,
                "correo_lider" => $correoLider,
                "correo_inst_lider" => $correoInstLider,
                "prodep" => $c['nombre_prodep'],
                "activo" => $c['activo'],
                "pais" => $c['pais_nombre'],
                "estado" => $c['estados_nombre'],
                "municipio" => $c['municipios_nombre'],
                "tipo_registro" => $c['tipo_registro'],
                "medio_entero" => $c['medio_entero'],
            ];
        } */

        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function editCuerpo($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $cuerpo = $this->AdminModel->getAllOneRow('cuerpos_academicos', $condiciones);
        if (empty($cuerpo)) {
            #NO HAY REGISTROS
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'Esta intentando acceder a un registro inexistente');
        }


        if ($cuerpo['redCueCa'] == 'Relen') {
            if (is_numeric($cuerpo["especialidad"])) {

                $condiciones = ["id" => $cuerpo["especialidad"]];

                $nombre_especialidad = $this->AdminModel->getAllOneRow("especialidades", $condiciones);

                $cuerpo["especialidad"] = $nombre_especialidad["nombre"];
            }
        }

        #OBTENEMOS LA INFORMACION DE LOS PAISES
        $condiciones = ['id !=' => 1];
        $paises = $this->AdminModel->getAll('pais', $condiciones);
        #OBTENEMOS LA INFORMACION DE LOS MUNICIPIOS, ESTO ES PARA AGREGAR MAS
        $condiciones = ['id_estado' => $cuerpo['estado']];
        $municipios = $this->AdminModel->getAll('municipios', $condiciones);
        #OBTENEMOS LA INFORMACION DE LOS ESTADOS
        $condiciones = ['id_pais' => $cuerpo['pais']];
        $estados = $this->AdminModel->getAll('estados', $condiciones);
        #OBTENEMOS LAS ESPECIALIDADES
        $condiciones = [];
        $especialidades = $this->AdminModel->getAll('especialidades', $condiciones);
        #OBTENEMOS LA INFORMACION DE LOS MUNICIPIOS EXTRAS
        $condiciones = ['claveCuerpo' => $cuerpo['claveCuerpo']];
        $municipios_adicionales = $this->AdminModel->getAll('municipios_ca', $condiciones);
        #OBTENEMOS LOS MIEMBROS, SOLO SERA PARA VISTA
        $condiciones = ['cuerpoAcademico' => $cuerpo['claveCuerpo']];
        $miembros = $this->AdminModel->getAll('miembros', $condiciones);
        foreach ($miembros as $key => $m) {
            $condiciones = ['usuario' => $m['usuario']];
            $columnas = ['profile_pic', 'correo', 'correo_institucional'];
            $usuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
            $miembros[$key]['profile_pic'] = $usuario['profile_pic'];
            $miembros[$key]['correo'] = $usuario['correo'];
            $miembros[$key]['correo_institucional'] = $usuario['correo_institucional'];
            $condiciones = ['id' => $m['grado']];
            $grado = $this->AdminModel->getAllOneRow('grado_academico', $condiciones);
            $miembros[$key]['grado'] = $grado['nombre'];
            $condiciones = ['id' => $m['nivelSNI']];
            $sni = $this->AdminModel->getAllOneRow('nombre_sni', $condiciones);
            if (empty($sni)) {
                $miembros[$key]['sni'] = '';
            } else {
                $miembros[$key]['sni'] = $sni['nombre'];
            }
        }
        #OBTENEMOS EL GRADO ACADEMICO DEL RECTOR
        $condiciones = ['id' => $cuerpo['grado_rector']];
        $grado_rector = $this->AdminModel->getAllOneRow('grado_academico', $condiciones);
        $grado_rector = $grado_rector['nombre'];
        #OBTENEMOS LOS GRADOS ACADEMICOS
        $condiciones = [];
        $grados_academicos = $this->AdminModel->getAll('grado_academico', $condiciones);
        #OBTENEMOS LOS VALORES DE LOS ID
        $condiciones = ['id' => $cuerpo['grado_rector']];
        $grado_rector_ca = $this->AdminModel->getAllOneRow('grado_academico', $condiciones);
        $grado_rector_ca = $grado_rector_ca['nombre'];
        #OBTENEMOS LOS TIPOS DE REGISTRO
        $condiciones = [];
        $tipos_registro = $this->AdminModel->getAll('tipos_registros', $condiciones);

        if (is_numeric($cuerpo['municipio'])) {
            $condiciones = ['id' => $cuerpo['municipio']];
            $municipio_ca = $this->AdminModel->getAllOneRow('municipios', $condiciones);
            $municipio_ca = empty($municipio_ca) ? 'Sin registro' : $municipio_ca['nombre'];
        } else {
            $municipio_ca = $cuerpo['municipio'];
        }

        if (is_numeric($cuerpo['estado'])) {
            $condiciones = ['id' => $cuerpo['estado']];
            $estado_ca = $this->AdminModel->getAllOneRow('estados', $condiciones);
            $estado_ca = $estado_ca['nombre'];
        } else {
            $estado_ca = $cuerpo['estado'];
        }

        if (is_numeric($cuerpo['pais'])) {
            $condiciones = ['id' => $cuerpo['pais']];
            $pais_Ca = $this->AdminModel->getAllOneRow('pais', $condiciones);
            $pais_Ca = $pais_Ca['nombre'];
        } else {
            $pais_Ca = $cuerpo['pais'];
        }

        //Mostrarenos una vista para que el admin edite los datos
        $data['cuerpo'] = $cuerpo;
        $data['a_paises'] = $paises;
        $data['grados_academicos'] = $grados_academicos;
        $data['tipos_registro'] = $tipos_registro;
        $data['miembros'] = $miembros;
        $data['municipios_adicionales'] = $municipios_adicionales;
        $data['especialidades'] = $especialidades;
        $data['estados'] = $estados;
        $data['municipios'] = $municipios;
        $data['cuerpo']['grado_rector'] = $grado_rector_ca;
        $data['cuerpo']['municipio'] = $municipio_ca;
        $data['cuerpo']['estado'] = $estado_ca;
        $data['cuerpo']['pais'] = $pais_Ca;
        $data['lider'] = 1;

        if ($cuerpo['redCueCa'] == 'Releem') {
            $data['faltantes'] = 7 - count($miembros);
        } else {
            $data['faltantes'] = 4 - count($miembros);
        }


        return view('admin/headers/index')
            . view('admin/cuerpos/editar', $data)
            . view('admin/footers/index')
            . view('admin/cuerpos/modales', $data);
    }

    public function mensajesCuerpos()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        if (session('user_type') == 0) {
            return redirect()->to(base_url());
        }

        #OBTENEMOS LOS TIPOS DE REGISTRO
        $condiciones = [];
        $tipos_registros = $this->AdminModel->getAll('tipos_registros', $condiciones);
        #OBTENEMOS LAS REDES
        $redes = $this->AdminModel->getAll('redes', $condiciones);
        #ASIGNAMOS VALORES
        $data['tipos_registros'] = $tipos_registros;
        $data['redes'] = $redes;

        return view('admin/headers/index')
            . view('admin/cuerpos/mensajes', $data)
            . view('admin/footers/index');
    }

    public function verMensaje($tipo, $red, $anio)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        //BUSCAMOS SI YA HAY UN MENSAJE REGISTRADO
        $condiciones = [
            'tipo' => $tipo,
            'red' => $red,
            'anio' => $anio
        ];

        if ($this->AdminModel->exist('correos', $condiciones) == 1) {
            #EXISTE, AHORA VAMOS A EXTRAER LA INFO
            $correo = $this->AdminModel->getAllOneRow('correos', $condiciones);
            $data['correo'] = $correo['mensaje'];
            $data['asunto'] = $correo['asunto'];
        }

        $data['mensaje'] = [
            'tipo' => $tipo,
            'red' => $red,
            'anio' => $anio
        ];
        return view('admin/headers/index')
            . view('admin/cuerpos/verMensaje', $data)
            . view('admin/footers/index');
    }

    public function imageUpload()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #UPLOAD DE CKEDITOR
        $imgFile = $this->request->getFile('upload');
        $nombre = $imgFile->getRandomName();
        $imgFile->move(WRITEPATH . 'uploads/ckeditor/', $nombre);
        $data = [
            'url' => base_url("admin/visualizadorMails/" . $nombre)
        ];
        return $this->response->setJSON($data);
    }

    public function guardarMensaje()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        if (!isset($_POST['mensaje'])) {
            return redirect()->back();
        }

        $data = $_POST;

        $data['updated_by'] = session('nombre');

        #VAMOS A VER SI YA HAY UN REGISTRO, SI YA HAY VAMOS A HACER SOLAMENTE UPDATE

        $condiciones = [
            'tipo' => $_POST['tipo'],
            'red' => $_POST['red'],
            'anio' => $_POST['anio']
        ];

        if ($this->AdminModel->exist('correos', $condiciones) == 1) {
            #EXISTE, HACEMOS UPDATE
            if ($this->AdminModel->generalUpdate('correos', $data, $condiciones)) {
                echo 'success';
            }
        } else {
            #NO EXISTE, LO CREAMOS
            if ($this->AdminModel->generalInsert('correos', $data) == 1) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }

    public function updateActivo($estado, $claveCuerpo)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A CAMBIAR EL STATUS DEL CUERPO ACADEMICO, ESTO SIGINFICA
        #QUE LE VAMOS A DAR ACCESO AL SISTEMA
        #TOMAREMOS SU ESTADO Y LO INVERTIREMOS

        $nuevoStatus = $estado == 1 ? 0 : 1;

        if ($nuevoStatus == 0) {
            #ACTUALIZAMOS EL ACTIVO EN LA BD Y MANDAMOS PARA ATRAS
            $data = ['activo' => $nuevoStatus];
            $condiciones = ['claveCuerpo' => $claveCuerpo];
            if ($this->AdminModel->generalUpdate('cuerpos_academicos', $data, $condiciones)) {
                #SE ACTUALIZO, MANDAMOS PARA ATRAS
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Listo')
                    ->with('text', 'Estado actualizado correctamente');
            }
        }

        #VAMOS A VERIFICAR SI EXISTE LA CLAVE DEL CUERPO
        $condiciones = [
            'claveCuerpo' => $claveCuerpo
        ];

        if ($this->AdminModel->exist('cuerpos_academicos', $condiciones) != 1) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'El cuerpo académico seleccionado no existe');
        }
        #PASANDO LA ANTERIOR CONDICION, SIGNIFICA QUE EXISTE, VAMOS A LOS DATOS PARA VERIFICAR QUE MENSAJE
        #VAMOS A ENVIAR
        $columnas = [
            'tipo_registro',
            'redCueCa',
            'anio_inscripcion'
        ];
        $condiciones = [
            'claveCuerpo' => $claveCuerpo
        ];
        $infoCuerpo = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        $condicionesCorreo = [
            'tipo' => $infoCuerpo['tipo_registro'],
            'red' => $infoCuerpo['redCueCa'],
            'anio' => $infoCuerpo['anio_inscripcion']
        ];

        #VERIFICAMOS SI EXISTE EL CORREO

        if ($this->AdminModel->exist('correos', $condicionesCorreo) != 1) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'El tipo de registro no tiene un correo redactado. Para redactarlo haga click <a href="verMensaje/' . $infoCuerpo['tipo_registro'] . '/' . $infoCuerpo['redCueCa'] . '/' . $infoCuerpo['anio_inscripcion'] . '">aquí</a>');
        }
        #SI TIENE UN CORREO REDACTADO, VAMOS A OBTENERLO
        $columnas = ['mensaje', 'asunto'];
        $correo = $this->AdminModel->getColumnsOneRow($columnas, 'correos', $condicionesCorreo);
        $mensaje = $correo['mensaje'];

        #VAMOS A FORMATEAR EL MENSAJE PARA HACERLO HTML CON VARIABLES PHP

        #BUSCAMOS AL LIDER
        $condiciones = [
            'cuerpoAcademico' => $claveCuerpo,
            'lider' => 1
        ];

        $lider = $this->AdminModel->getAllOneRow('miembros', $condiciones);

        #BUSCAMOS A TODOS LOS MIEMBROS
        $condiciones = [
            'cuerpoAcademico' => $claveCuerpo,
        ];
        $miembros = $this->AdminModel->getAll('miembros', $condiciones);

        if (empty($lider) || empty($miembros)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'El lider no existe');
        }
        $lider = $lider['nombre'] . ' ' . $lider['apaterno'] . ' ' . $lider['amaterno'];
        $htmlMiembros = '';
        $arr_correos = ['pmejiaa@redesla.la'];
        foreach ($miembros as $m) {
            $header = $m['lider'] == 1 ? '<h3>Lider</h3>' : '<h3>Miembro</h3>';
            $nombre_miembro = $m['nombre'] . ' ' . $m['apaterno'] . ' ' . $m['amaterno'];
            #OBTENEMOS EL GA DEL MIEMBRO
            $condiciones = [
                'id' => $m['grado']
            ];
            $grado_miembro = $this->AdminModel->getAllOneRow('grado_academico', $condiciones);
            $grado_miembro = $grado_miembro['nombre'];
            #OBTENEMOS SUS ACCESOS
            $columnas = ['correo', 'correo_institucional'];
            $condiciones = ['usuario' => $m['usuario']];
            $usuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);

            $htmlMiembros .= $header . '
            Nombre completo: ' . $nombre_miembro . '<br>
            Teléfono: ' . $m['telefono'] . '<br>
            Correo (acceso a la plataforma): ' . $usuario['correo'] . '<br>
            Contraseña: ' . $usuario['correo'] . '<br><hr>
            ';
            array_push($arr_correos, $usuario['correo']);
            array_push($arr_correos, $usuario['correo_institucional']);
        }

        $msj = str_replace('$nombre_lider', $lider, $mensaje);
        $msj = str_replace('$accesos_miembros', $htmlMiembros, $msj);
        $msj = str_replace('$claveCuerpo', $claveCuerpo, $msj);

        #ENVIAMOS EL MENSAJE
        $email = \Config\Services::email();
        $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
        $email->setTo($arr_correos);
        $email->setSubject($correo['asunto']);
        $email->setMessage($msj);
        

        if ($email->send()) {
            #SE ENVIO EL CORREO VAMOS A ACTUALIZAR EL ACTIVO
            $data = ['activo' => $nuevoStatus];
            $condiciones = ['claveCuerpo' => $claveCuerpo];
            if ($this->AdminModel->generalUpdate('cuerpos_academicos', $data, $condiciones)) {
                #SE ACTUALIZO, MANDAMOS PARA ATRAS
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Listo')
                    ->with('text', 'Estado actualizado y correos enviados correctamente');
            }
        } else {

            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error.' . $email->printDebugger());
        }

        //echo $correo['asunto'];
        #MIRA CARNAL, POR ALGUNA EXTRAÑISIMA RAZON, SI NO HAY UN ECHO, MANDA ERROR, ASI QUE NI LE MUEVAS JAJAJAJAJAJ

    }

    public function cambioMiembros($claveCuerpo)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A CAMBIAR DE MIEMBROS A UN CUERPO, LO QUE ES COMPLICADO ES QUE VAMOS A TENER REGISTROS
        #CON LA MISMA INFORMACION PERO DIFERENTE AñO

        $condiciones = ['cuerpoAcademico' => $claveCuerpo];
        $mimebros = $this->AdminModel->getAll('miembros', $condiciones);
        if (empty($mimebros)) {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'Este cuerpo académico no tiene miembros');
        }
        #MIEMBROS TIENE A LOS MIEMBROS ACTUALES
        #VAMOS A TAERNOS A TODOS LOS USUARIOS PARA HACER UNA LISTA
        $condiciones = [];
        $usuarios = $this->AdminModel->getAll('usuarios', $condiciones);
        $data['info'] = [
            'usuarios' => $usuarios,
            'claveCuerpo' => $claveCuerpo,
            'miembros' => $mimebros
        ];

        return view('admin/headers/index')
            . view('admin/cuerpos/cambioMiembros', $data)
            . view('admin/footers/index');
    }

    public function updateClaveCuerpo()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['claveCuerpo' => $_POST['claveCuerpo']];
        if ($this->AdminModel->exist('cuerpos_academicos', $condiciones) == 1) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'La clave ya esta en uso');
        }

        $data = ['claveCuerpo' => $_POST['claveCuerpo']];
        $condiciones = ['claveCuerpo' => $_POST['claveCuerpoVieja']];
        $this->AdminModel->generalUpdate("carpetas", $data, $condiciones);
        $this->AdminModel->generalUpdate("cuerpos_academicos", $data, $condiciones);
        $this->AdminModel->generalUpdate("municipios_ca", $data, $condiciones);
        $this->AdminModel->generalUpdate("pagos", $data, $condiciones);
        $this->AdminModel->generalUpdate("ponencias", $data, $condiciones);
        $this->AdminModel->generalUpdate("participantes_congresos", $data, $condiciones);
        $this->AdminModel->generalUpdate("factura", $data, $condiciones);
        $this->AdminModel->generalUpdate("facturas_admin", $data, $condiciones);
        $this->AdminModel->generalUpdate("entrevistas_Relmo", $data, $condiciones);
        $this->AdminModel->generalUpdate("calificaciones", $data, $condiciones);
        $this->AdminModel->generalUpdate("categorias", $data, $condiciones);
        $this->AdminModel->generalUpdate("filtro_categorias", $data, $condiciones);
        $this->AdminModel->generalUpdate("mensajes_ca", $data, $condiciones);
        $condiciones = ['redCueAca' => $_POST['claveCuerpoVieja']];
        $data = ['redCueAca' => $_POST['claveCuerpo']];
        $this->AdminModel->generalUpdate("constancia_Relayn", $data, $condiciones);
        $this->AdminModel->generalUpdate("constancia_Releem", $data, $condiciones);
        $this->AdminModel->generalUpdate("constancia_Releg", $data, $condiciones);
        $this->AdminModel->generalUpdate("constancia_Relen", $data, $condiciones);
        $this->AdminModel->generalUpdate("constancia_Relep", $data, $condiciones);
        $condiciones = ['cuerpoAcademico' => $_POST['claveCuerpoVieja']];
        $data = ['cuerpoAcademico' => $_POST['claveCuerpo']];
        $this->AdminModel->generalUpdate("miembros", $data, $condiciones);
        $this->AdminModel->generalUpdate("historia_usuarios", $data, $condiciones);

        return redirect()->back()
            ->with('icon', 'success')
            ->with('title', 'Exito')
            ->with('text', 'Clave actualizada correctamente');
    }

    public function verificarClaveCuerpo()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ["claveCuerpo" => $_POST["claveCuerpo"]];
        // $claveCuerpo = $_POST["claveCuerpo"];

        $cuerpo = $this->AdminModel->getAllOneRow("cuerpos_academicos", $condiciones);

        if (empty($cuerpo)) {
            $resp = "no_Existe";
        } else {
            $resp = "existe";
        }

        echo ($resp);
    }

    public function addMunicipioCa()
    {

        if ($_POST['id_municipio'] == 1) {
            $municipio = $_POST['otromunplus'];
        } else {
            $condiciones = ['id' => $_POST['id_municipio']];
            $municipio = $this->AdminModel->getAllOneRow('municipios', $condiciones);
            $municipio = $municipio['nombre'];
        }


        if (empty($municipio)) {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El municipio seleccionado no existe');
        }


        $data = [
            'id_municipio' => $_POST['id_municipio'],
            'claveCuerpo' => $_POST['claveCuerpo'],
            'nombre_municipio' => $municipio
        ];



        if ($this->AdminModel->generalInsert('municipios_ca', $data) == 1) {
            return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'ÉXITO')
                ->with('text', 'El municipio adicional se ha registrado correctamente');
        } else {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, contacte a sistemas');
        }
    }

    public function cambiar_lider($id_miembro, $claveCuerpo)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A BUSCAR AL MIEMBRO
        $condiciones = ['id' => $id_miembro, 'cuerpoAcademico' => $claveCuerpo];
        if (!$this->AdminModel->exist('miembros', $condiciones)) {
            #NO EXISTE, LO REGRESAMOS
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'Hubo problemas al cambiar el líder. Contacte a sistemas');
        }
        $condiciones = ['lider' => 1, 'cuerpoAcademico' => $claveCuerpo];
        $columnas = ['id'];
        $antigua_lider = $this->AdminModel->getColumnsOneRow($columnas, 'miembros', $condiciones);

        if (empty($antigua_lider)) {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'No se ha encontrado a la actual líder. Contacte a sistemas.');
        }

        $id_antigua_lider = $antigua_lider['id'];

        $condiciones = ['cuerpoAcademico' => $claveCuerpo, 'id' => $id_miembro];
        $data = ['lider' => 1];

        if (!$this->AdminModel->generalUpdate('miembros', $data, $condiciones)) {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'Ha ocurrido un error al actualizar el nuevo líder. Contacte a sistemas');
        }
        $data = ['lider' => 0];
        $condiciones = ['cuerpoAcademico' => $claveCuerpo, 'id' => $id_antigua_lider];

        if (!$this->AdminModel->generalUpdate('miembros', $data, $condiciones)) {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'Ha ocurrido un error al actualizar el antiguo líder. Contacte a sistemas');
        }

        return redirect()->back()
            ->with('icon', 'success')
            ->with('title', 'ÉXITO')
            ->with('text', 'Se ha actualizado el nuevo líder.');
    }

    public function orden_autores()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/cuerpos/orden_autores/lista')
            . view('admin/footers/index');
    }

    public function getListadoOrdenAutores()
    {
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = ['id', 'claveCuerpo', 'nombre'];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM cuerpos_academicos";
        $sql_data = "SELECT * FROM cuerpos_academicos";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {

                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {
            $condiciones = ['claveCuerpo' => $a['claveCuerpo']]; #columna a buscar en la tabla, segundo es el valor a encontrar
            $columnas = ['anio']; #especifico las columnas de la tabla de la bd a traer
            $infoAnios = $this->AdminModel->getAllDistinc($columnas, 'ordenes_autores', $condiciones);
            $htmlAutoresImp = '<div class="dropdown">
            <button class="btn btn-info dropdown-toggle btn-rounded  
            t" type="button" id="dropdownMenuSizeButton' . $a['id'] . '" 
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
            Autores 
            </button> 
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton' . $a['id'] . '" style="">
              <h6 class="dropdown-header">Seleccione un año</h6>';

            //[0] => [anio] => 2022, [1] => [anio] => 2023
            foreach ($infoAnios as $anio) {
                $condiciones = ['anio' => $anio['anio'], 'claveCuerpo' => $a['claveCuerpo']];
                $autores = $this->AdminModel->getAll('ordenes_autores', $condiciones);
                array_multisort(array_column($autores, 'orden_impreso'), SORT_ASC, $autores);
                $dataTargets = '';
                foreach ($autores as $keyaut => $aut) {
                    $condiciones = ['usuario' => $aut['usuario']];
                    $infoUsuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);
                    if (empty($infoUsuario)) {
                        $nombre = 'El usuario no existe.';
                    } else {
                        $nombre = $infoUsuario['nombre'] . ' ' . $infoUsuario['ap_paterno'] . ' ' . $infoUsuario['ap_materno'];
                    }

                    $dataTargets .= 'data-autor_' . $keyaut . '="' . $nombre . '" ';
                }
                if ($autores[0]['orden_impreso'] == 0) {
                    $a_tag = '<a class="dropdown-item" style="pointer-events: none;">No disponible</a>';
                } else {
                    $a_tag = "<a class='btn btn-info dropdown-item autores' data-toggle='modal' data-target='#myModal' {$dataTargets}>{$anio['anio']}</a>";
                }
                $htmlAutoresImp .= $a_tag;
            }

            $htmlAutoresImp .= "</div>
          </div>";
            $htmlAutoresDig = ' <div class="dropdown">
            <button class="btn btn-info dropdown-toggle btn-rounded  
            t" type="button" id="dropdownMenuSizeButton' . $a['id'] . '" 
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
            Autores 
            </button> 
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton' . $a['id'] . '" style="">
              <h6 class="dropdown-header">Seleccione un año</h6>
              ';

            //[0] => [anio] => 2022, [1] => [anio] => 2023
            foreach ($infoAnios as $anio) {
                $condiciones = ['anio' => $anio['anio'], 'claveCuerpo' => $a['claveCuerpo']];
                $autores = $this->AdminModel->getAll('ordenes_autores', $condiciones);
                array_multisort(array_column($autores, 'orden_digital'), SORT_ASC, $autores);
                $dataTargets = '';
                foreach ($autores as $keyaut => $aut) {
                    $condiciones = ['usuario' => $aut['usuario']];
                    $infoUsuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);
                    if (empty($infoUsuario)) {
                        $nombre = 'El usuario no existe.';
                    } else {
                        $nombre = $infoUsuario['nombre'] . ' ' . $infoUsuario['ap_paterno'] . ' ' . $infoUsuario['ap_materno'];
                    }

                    $dataTargets .= 'data-autor_' . $keyaut . '="' . $nombre . '" ';
                }
                if ($autores[0]['orden_digital'] == 0) {
                    $a_tag = '<a class="dropdown-item" style="pointer-events: none;">No disponible</a>';
                } else {
                    $a_tag = "<a class='btn btn-info dropdown-item autores' data-toggle='modal' data-target='#myModal' {$dataTargets}>{$anio['anio']}</a>";
                }
                $htmlAutoresDig .= $a_tag;
            }

            $htmlAutoresDig .= "</div>
          </div>";


            $array[$key] = [
                'id' => $a['id'],
                'claveCuerpo' => $a['claveCuerpo'],
                'nombre' => $a['nombre'],
                'autordig' => $htmlAutoresDig,
                'autorimp' => $htmlAutoresImp,
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

    public function formAgregar($claveCuerpo)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];
        $grados = $this->AdminModel->getAll('grado_academico', $condiciones);
        $sni = $this->AdminModel->getAll('nombre_sni', $condiciones);

        $columnas = ['redCueCa'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $uni = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        $data = [
            'claveCuerpo' => $claveCuerpo,
            'grados' => $grados,
            'sni' => $sni,
            'red' => $uni['redCueCa']
        ];

        return view('admin/headers/index')
            . view('admin/cuerpos/miembros/agregar', $data)
            . view('admin/footers/index');
    }

    public function verificarCorreo()
    {
        #VERIFICAMOS EL CORREO 
        $condiciones = ['correo' => $_POST['email']];
        $correo = $this->AdminModel->getAllOneRow('usuarios', $condiciones);

        if (empty($correo)) {
            echo json_encode(false);
            exit;
        }

        #obtenemos la info del usuario

        $condiciones = ['usuario' => $correo['usuario']];
        $miembro = $this->AdminModel->getAllOneRow('miembros', $condiciones);

        if (empty($miembro)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al obtener la información del usuario';
            echo $mensaje;
            exit;
        }

        $data = [
            'usuario' => $correo['usuario'],
            'nombre' => $correo['nombre'],
            'ap_paterno' => $correo['ap_paterno'],
            'ap_materno' => $correo['ap_materno'],
            'telefono' => $miembro['telefono'],
            'grado' => $miembro['grado'],
            'especialidad' => $miembro['especialidad'],
            'nivelSNI' => $miembro['nivelSNI'],
            'anoSNI' => $miembro['anoSNI'],
            'correo_institucional' => $correo['correo_institucional']
        ];

        echo json_encode($data);
    }

    public function AddMiembro()
    {
        #Aqui agregamos la info, vamos a hacer condicionales para hacerlo
        $info = $_POST;

        if (empty($info['usuario'])) {
            #EL USUARIO NO EXISTE, SE NECESITA CREAR
            $usuario = $this->generar_usuario();

            $dataMiembros = [
                'nombre' => $info["nombre"],
                'apaterno' => $info["ap_paterno"],
                'amaterno' => $info["ap_materno"],
                'grado' => $info["grado"],
                'especialidad' => $info["especialidad"],
                'telefono' => $info["telefono"],
                'nivelSNI' => $info["nivelSNI"],
                'tipo' => "maestro",
                'lider' => "0",
                'usuario' => $usuario,
                'anoSNI' => $info["anoSNI"],
                'cuerpoAcademico' => $info["claveCuerpo"],
                'redCueCa' => $info['red']
            ];

            $pass = password_hash($info["correo"], PASSWORD_DEFAULT);

            $dataUsuarios = [
                'nombre' => $info["nombre"],
                'ap_paterno' => $info["ap_paterno"],
                'ap_materno' => $info["ap_materno"],
                'correo' => $info["correo"],
                'correo_institucional' => $info["correo_institucional"],
                'password' => $pass,
                'usuario' => $usuario,
                'tipo_usuario' => "0",
                $info["red"] => "1"
            ];

            if (!$this->AdminModel->generalInsert('miembros', $dataMiembros)) {
                http_response_code(501);
                $mensaje = 'Ha ocurrido un error al insertar el miembro. Contacte a sistemas';
                echo $mensaje;
                exit;
            }

            if (!$this->AdminModel->generalInsert('usuarios', $dataUsuarios)) {
                http_response_code(502);
                $mensaje = 'Ha ocurrido un error al insertar el usuario. Contacte a sistemas';
                echo $mensaje;
                exit;
            }

            $respuesta = [
                "title" => "Hecho",
                'mensaje' => 'Se ha agregado el miembro al cuerpo academico ' . $info['claveCuerpo'],
                "codigo" => 200,
            ];

            $json_respuesta = json_encode($respuesta);
            echo $json_respuesta;
            exit;
        } else {
            $dataMiembros = [
                'nombre' => $info["nombre"],
                'apaterno' => $info["ap_paterno"],
                'amaterno' => $info["ap_materno"],
                'grado' => $info["grado"],
                'especialidad' => $info["especialidad"],
                'telefono' => $info["telefono"],
                'nivelSNI' => $info["nivelSNI"],
                'tipo' => "maestro",
                'lider' => "0",
                'usuario' => $info['usuario'],
                'anoSNI' => $info["anoSNI"],
                'cuerpoAcademico' => $info["claveCuerpo"],
                'redCueCa' => $info['red']
            ];

            if (!$this->AdminModel->generalInsert('miembros', $dataMiembros)) {
                http_response_code(503);
                $mensaje = 'Ha ocurrido un error al insertar el miembro. Contacte a sistemas';
                echo $mensaje;
                exit;
            }

            $respuesta = array(
                "title" => "Hecho",
                'mensaje' => 'Se ha agregado el miembro al cuerpo academico ' . $info['claveCuerpo'],
                "codigo" => 200,
            );

            $json_respuesta = json_encode($respuesta);
            echo $json_respuesta;
            exit;
        }
    }

    public function generar_usuario()
    {

        $strength = 16;
        $input_length = strlen($this->charsUsuario);
        $input = $this->charsUsuario;

        $random_string = '';

        for ($i = 0; $i < $strength; $i++) {

            $random_character = $input[mt_rand(0, $input_length - 1)];

            $random_string .= $random_character;
        }

        return $random_string;
    }
    
    public function deleteClaveCuerpo()
    {

        if (session('user_type') == 0) {
            session_destroy();
            http_response_code(403);
            $mensaje = 'Acceso denegado';
            echo $mensaje;
            exit;
        }

        $condiciones = ['claveCuerpo' => $_POST['claveCuerpo']];
        if ($this->AdminModel->exist('cuerpos_academicos', $condiciones) != 1) {
            http_response_code(404);
            $mensaje = 'No existe el cuerpo académico.';
            echo $mensaje;
            exit;
        }

        $condiciones = ['claveCuerpo' => $_POST['claveCuerpo']];
        $this->AdminModel->generalDelete("carpetas", $condiciones);
        $this->AdminModel->generalDelete("cuerpos_academicos", $condiciones);
        $this->AdminModel->generalDelete("municipios_ca", $condiciones);
        $this->AdminModel->generalDelete("pagos", $condiciones);
        $this->AdminModel->generalDelete("ponencias", $condiciones);
        $this->AdminModel->generalDelete("participantes_congresos", $condiciones);
        $this->AdminModel->generalDelete("factura", $condiciones);
        $this->AdminModel->generalDelete("facturas_admin", $condiciones);
        $this->AdminModel->generalDelete("entrevistas_Relmo", $condiciones);
        $this->AdminModel->generalDelete("calificaciones", $condiciones);
        $this->AdminModel->generalDelete("categorias", $condiciones);
        $this->AdminModel->generalDelete("filtro_categorias", $condiciones);
        $this->AdminModel->generalDelete("mensajes_ca", $condiciones);

        $condiciones = ['cuerpoAcademico' => $_POST['claveCuerpo']];
        $this->AdminModel->generalDelete("miembros", $condiciones);
        $this->AdminModel->generalDelete("historia_usuarios", $condiciones);

        $return = [
            'title' => 'Éxito',
            'text' => 'Registro eliminado correctamente'
        ];
        echo json_encode($return);
        exit;
        
    }

    public function dirreccionesEnvioCuerpos(){
        
        $columnas = ['claveCuerpo','direccion_envio','redCueCa'];

        $cuerpos = $this->AdminModel->getAllColums($columnas,'cuerpos_academicos',[]);

        $grupos = [];

        foreach ($cuerpos as $elemento) {
            $redCueCa = $elemento['redCueCa'];
            if (!isset($grupos[$redCueCa])) {
                $grupos[$redCueCa] = [];
            }
            $grupos[$redCueCa][] = $elemento;
        }

        $headerExcel = ['Clave','Direccion de envio','Lider','Correo','Telefono'];

        $spreadsheet = new Spreadsheet();

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
                    'argb' => 'FF000000',
                ],
            ],
        ];

        
        foreach ($grupos as $keyRed=>$grupoRed) {
            $arr_respuestas = [];
            $inicio = 2;
            $sheet = new Worksheet($spreadsheet, $keyRed); // Crea una nueva hoja con un nombre único
            $spreadsheet->addSheet($sheet);
            $spreadsheet->setActiveSheetIndexByName($keyRed); // Establece la hoja activa recién creada
    
            $sheet->fromArray([$headerExcel], NULL, 'A1');
            $highestColumn = $sheet->getHighestColumn();
            $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . '1')->applyFromArray($styleArray);
            
            foreach($grupoRed as $cuerpo){
                
                $condiciones = [
                    'cuerpoAcademico' => $cuerpo['claveCuerpo'],
                    'lider' => 1
                ];

                $miembroLider = $this->AdminModel->getAllOneRow('miembros',$condiciones);

                if(!empty($miembroLider)){
                    $nombre_lider = empty($miembroLider['amaterno']) ? $miembroLider['nombre'].' '.$miembroLider['apaterno'] : $miembroLider['nombre'].' '.$miembroLider['apaterno'].' '.$miembroLider['amaterno'];

                    $condiciones = ['usuario' => $miembroLider['usuario']];
                    $columnas = ['correo'];
                    $usuario = $this->AdminModel->getColumnsOneRow($columnas,'usuarios',$condiciones);
                    if(!empty($usuario)){
                        $correo = $this->filter_string_polyfill($usuario['correo']);
                        $telefono = $this->filter_string_polyfill($miembroLider['telefono']);
                    }else{
                        $correo = 'Información no encontrada';
                        $telefono = 'Información no encontrada';
                    }
                }else{
                    $correo = 'Información no encontrada';
                    $telefono = 'Información no encontrada';
                    $nombre_lider = 'Información no encontrada';
                }

                

                $arr_respuestas = [
                    $this->filter_string_polyfill($cuerpo['claveCuerpo']),
                    $this->filter_string_polyfill($cuerpo['direccion_envio']),
                    $nombre_lider,
                    $correo,
                    $telefono
                ];
                $sheet->fromArray([$arr_respuestas], NULL, 'A' . $inicio);
                $arr_respuestas = [];
                $inicio++;
            }
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setWidth(30);
            }
        }

        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Direcciones de envio.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    private function filter_string_polyfill(string $string): string{
        $str = preg_replace('/\x00|<[^>]*>?/', '', $string);
        return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
    }


    #====================CUERPOS ACADEMICOS=======================

    #====================ADMIN DR. NURIA==========================

    public function equiposReleg()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/investigacionReleg/equipos')
            . view('admin/footers/index');
    }

    public function listaEquiposReleg()
    {
        #VAMOS A OBTENER LOS CUERPOS ACADMEICOS
        $anio_investigacion = 2022;
        $condiciones = [];
        $columnas = ['claveCuerpo'];
        $cuerpos = $this->AdminModel->getAllDistinc($columnas, 'entrevistas_Relmo', $condiciones);
        #LO RECORREMOS PARA OBTENER CIERTOS VALORES ESPECIFICOS
        $i = 0;
        #ARREGLO CON LOS DATOS
        foreach ($cuerpos as $c) {

            $htmlVerEntrevistas = '
            <a href="ver/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-info">Ver entrevistas</a>
            ';

            #NOMBRE DE LA UNIVERSIDAD
            $condiciones = ['claveCuerpo' => $c];
            $columnas = ['nombre', 'redCueCa'];
            $nombre_universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
            $nombre_universidad = empty($nombre_universidad) ? 'No registrado' : $nombre_universidad;
            #OBTENEMOS LAS CARPETAS
            $condiciones = [
                'claveCuerpo' => $c,
                'red' => $nombre_universidad['redCueCa']
            ];
            $columnas = ['recibidos', 'ano_carpeta'];
            #LO HAREMOS SIN AñO PARA OBTENER TODAS LAS CARPETAS, SI UNA EN CUESTION NO FUNCIONA, ENTRA LA OTRA
            $carpetas = $this->AdminModel->getAllColums($columnas, 'carpetas', $condiciones);
            $htmlCarpetas = '';

            foreach ($carpetas as $keyCarpetas => $carpeta) {
                if ($keyCarpetas == 0) {
                    $htmlCarpetas .= '
                    <div class="dropdown">
                        <button class="btn btn-warning btn-rounded dropdown-toggle" type="button" id="dropdownMenuButtonCarpetas" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Carpetas </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonCarpetas">
                        <h6 class="dropdown-header">Carpetas</h6>
                        <a class="dropdown-item" href="#">' . $carpeta['ano_carpeta'] . '</a>
                    ';
                } else {
                    $htmlCarpetas .= '
                    <a class="dropdown-item" href="#">' . $carpeta['ano_carpeta'] . '</a>
                    ';
                }
            }

            $htmlCarpetas .= '
            </div>
            </div>
            ';

            #VAMOS A OBTENER EL ESTADO DE VALIDACION
            $condiciones = [
                'claveCuerpo' => $c['claveCuerpo'],
                'redCueCa' => $nombre_universidad['redCueCa'],
                'anio' => $anio_investigacion
            ];
            $validacion = $this->AdminModel->getAllOneRow('validacion', $condiciones);

            if ($c['claveCuerpo'] == 'MXM-UJED01') {
                continue;
            }
            if (!empty($validacion)) {
                $htmlCapitulo = 'No disponible';
                switch ($validacion['terminado']) {
                    case 0:
                        #REVISION RECHAZADA
                        $htmlEstado = '<label"><i class="mdi mdi-alert-octagon" style="color:red"></i> Se ha rechazado su validación</label>';
                        $htmlValidar = '<a href="mensajeCorreoyAlert/validado/' . $c['claveCuerpo'] . '" class="btn btn-success btn-rounded">Validar</a>';
                        $htmlRechazar = '<a class="btn btn-rounded btn-danger disabled">Completado</a>';
                        $htmlReenviar = '<a href="mensajeCorreoyAlert/reenviar/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-warning">Reenviar</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'No disponible por su validación';
                        break;
                    case 1:
                        #PRIMERA FASE DE REVISION
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo envió su primera revisión</label>';
                        $htmlValidar = '<a href="mensajeCorreoyAlert/validado/' . $c['claveCuerpo'] . '" class="btn btn-success btn-rounded">Validar</a>';
                        $htmlRechazar = '<a href="mensajeCorreoyAlert/rechazado/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-danger">Rechazar</a>';
                        $htmlReenviar = '<a href="mensajeCorreoyAlert/reenviar/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-warning">Reenviar</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'No disponible por su validación';
                        break;
                    case 2:
                        #LA REVISION HA SIDO APROBADA
                        $htmlEstado = '<label"><i class="mdi mdi-check-circle" style="color:lightgreen"></i> El equipo entró a la segunda fase</label>';
                        $htmlValidar = '<a class="btn btn-success btn-rounded disabled">Trabajando...</a>';
                        $htmlRechazar = '<a href="mensajeCorreoyAlert/rechazado/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-danger">Rechazar</a>';
                        $htmlReenviar = '<a href="mensajeCorreoyAlert/reenviar/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-warning">Reenviar</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'No disponible por su validación';
                        break;
                    case 3:
                        #LA REVISION HA SIDO REENVIADA
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo esta en proceso de reenvió de la primera fase</label>';
                        $htmlValidar = '<a href="mensajeCorreoyAlert/validado/' . $c['claveCuerpo'] . '" class="btn btn-success btn-rounded">Validar</a>';
                        $htmlRechazar = '<a href="mensajeCorreoyAlert/rechazado/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-danger">Rechazar</a>';
                        $htmlReenviar = '<a class="btn btn-rounded btn-warning disabled">Completado</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'No disponible por su validación';
                        break;
                    case 4:
                        #SEGUNDA FASE DE REVISION DE LA PRIMERA ETAPA
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo reenvió su revisión de la primera fase</label>';
                        $htmlValidar = '<a href="mensajeCorreoyAlert/validado/' . $c['claveCuerpo'] . '" class="btn btn-success btn-rounded">Validar</a>';
                        $htmlRechazar = '<a href="mensajeCorreoyAlert/rechazado/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-danger">Rechazar</a>';
                        $htmlReenviar = '<a href="mensajeCorreoyAlert/reenviar/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-warning">Reenviar</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'No disponible por su validación';
                        break;
                    case 5:
                        #SEGUNDA FASE DE LA INVESTIGACION, PRIMERA REVISION
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo envió su validación de la 2da fase</label>';
                        $htmlValidar = '<a href="mensajeCorreoyAlert/validado2/' . $c['claveCuerpo'] . '" class="btn btn-success btn-rounded">Validar</a>';
                        $htmlRechazar = '<a href="mensajeCorreoyAlert/rechazado2/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-danger">Rechazar</a>';
                        $htmlReenviar = '<a href="mensajeCorreoyAlert/reenviar2/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-warning">Reenviar</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = '<a class="btn btn-warning btn-rounded" href="categorizacion/' . $c['claveCuerpo'] . '">Ver categorización</a>';
                        break;
                    case 6:
                        #LA REVISION HA SIDO APROBADA
                        $htmlEstado = '<label"><i class="mdi mdi-check-circle" style="color:lightgreen"></i> El equipo entro en la tercera fase.</label>';
                        $htmlValidar = '<a class="btn btn-success btn-rounded disabled">En proceso...</a>';
                        $htmlRechazar = '<a href="mensajeCorreoyAlert/rechazado2/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-danger">Rechazar</a>';
                        $htmlReenviar = '<a href="mensajeCorreoyAlert/reenviar2/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-warning">Reenviar</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'No disponible por su validación';
                        break;
                    case 7:
                        #LA REVISION HA SIDO REENVIADA
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo esta en proceso de reenvió de la segunda fase</label>';
                        $htmlValidar = '<a href="mensajeCorreoyAlert/validado2/' . $c['claveCuerpo'] . '" class="btn btn-success btn-rounded">Validar</a>';
                        $htmlRechazar = '<a href="mensajeCorreoyAlert/rechazado2/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-danger">Rechazar</a>';
                        $htmlReenviar = '<a class="btn btn-rounded btn-warning disabled">Completado</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'No disponible por su validación';
                        break;
                    case 8:
                        #SEGUNDA FASE DE REVISION DE LA PRIMERA ETAPA
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo reenvió su revisión de la segunda fase</label>';
                        $htmlValidar = '<a href="mensajeCorreoyAlert/validado2/' . $c['claveCuerpo'] . '" class="btn btn-success btn-rounded">Validar</a>';
                        $htmlRechazar = '<a href="mensajeCorreoyAlert/rechazado2/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-danger">Rechazar</a>';
                        $htmlReenviar = '<a href="mensajeCorreoyAlert/reenviar2/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-warning">Reenviar</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = '<a class="btn btn-warning btn-rounded" href="categorizacion/' . $c['claveCuerpo'] . '">Ver categorización</a>';
                        break;
                    case 9:
                        #REVISION RECHAZADA
                        $htmlEstado = '<label"><i class="mdi mdi-alert-octagon" style="color:red"></i> Se ha rechazado la validación de la segunda fase.</label>';
                        $htmlValidar = '<a href="mensajeCorreoyAlert/validado2/' . $c['claveCuerpo'] . '" class="btn btn-success btn-rounded">Validar</a>';
                        $htmlRechazar = '<a class="btn btn-rounded btn-danger disabled">Completado</a>';
                        $htmlReenviar = '<a href="mensajeCorreoyAlert/reenviar2/' . $c['claveCuerpo'] . '" class="btn btn-rounded btn-warning">Reenviar</a>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'No disponible por su validación';
                        break;
                    case 10:
                        #PRIMERA REVISION DE LA FASE DEL CAPITULO
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo envió la revisión de la tercera fase.</label>';
                        $htmlValidar = '<button class="btn btn-success btn-rounded">Ir a ver capitulo</button>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">Ir a ver capitulo</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">Ir a ver capitulo</button>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<a class="btn btn-warning btn-rounded" href="capitulo/' . $c['claveCuerpo'] . '">Ver capitulo</a>';
                        break;
                    case 11:
                        #Toda la investogacion terminada, los digitales continuan
                        $htmlEstado = '<label"><i class="mdi mdi-success" style="color:yellow"></i> El equipo ha terminado el CAPÍTULO IMPRESO RELEG 2022 🥳</label>';
                        $htmlValidar = '<button href="" class="btn btn-success btn-rounded">Sin acciones</butt>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">Sin acciones</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">Sin acciones</butt>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<a href="' . base_url('/admin/descargar/capitulo_releg/' . $c['claveCuerpo']) . '.docx" class="btn btn-secondary btn-rounded" >Descargar capítulo</a>';
                        break;
                    case 12:
                        #LIMBO DE LA FASE DEL CAPITULO
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo esta editando su capítulo</label>';
                        $htmlValidar = '<button class="btn btn-success btn-rounded">Ir a ver capitulo</button>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">Ir a ver capitulo</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">Ir a ver capitulo</button>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<a class="btn btn-warning btn-rounded" href="capitulo/' . $c['claveCuerpo'] . '">Ver capitulo</a>';
                        break;
                    case 13:
                        #REENVIO DE LA FASE DEL CAPITULO
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo reenvió la revisión de la tercera fase.</label>';
                        $htmlValidar = '<button class="btn btn-success btn-rounded">Ir a ver capitulo</button>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">Ir a ver capitulo</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">Ir a ver capitulo</button>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<a class="btn btn-warning btn-rounded" href="capitulo/' . $c['claveCuerpo'] . '">Ver capitulo</a>';
                        break;
                    case 14:
                        #LIMBO DE LA FASE DEL CAPITULO
                        $htmlEstado = '<label"><i class="mdi mdi-alert-octagon" style="color:yellow"></i> Se ha rechazado el capítulo. El equipo esta editando su capítulo.</label>';
                        $htmlValidar = '<button class="btn btn-success btn-rounded">Ir a ver capitulo</button>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">Ir a ver capitulo</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">Ir a ver capitulo</button>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<a class="btn btn-warning btn-rounded" href="capitulo/' . $c['claveCuerpo'] . '">Ver capitulo</a>';
                        break;
                    case 15:
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo ha enviado la discusión del capitulo digital RELEG 2022</label>';
                        $htmlValidar = '<button class="btn btn-success btn-rounded">No disponible</button>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">No disponible</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">No disponible</button>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<a class="btn btn-warning btn-rounded" href="capitulo/digital/' . $c['claveCuerpo'] . '">Ver capitulo digital</a>';
                        break;
                    case 16:
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo esta trabajando reenviando su discusión del capítulo digital RELEG 2022</label>';
                        $htmlValidar = '<button class="btn btn-success btn-rounded">No disponible</button>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">No disponible</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">No disponible</button>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<a class="btn btn-warning btn-rounded" href="capitulo/digital/' . $c['claveCuerpo'] . '">Ver capitulo digital</a>';
                        break;
                    case 17:
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:red"></i> El equipo esta trabajando debido al rechazo en su discusión del capítulo digital RELEG 2022</label>';
                        $htmlValidar = '<button class="btn btn-success btn-rounded">No disponible</button>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">No disponible</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">No disponible</button>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<a class="btn btn-warning btn-rounded" href="capitulo/digital/' . $c['claveCuerpo'] . '">Ver capitulo digital</a>';
                        break;
                    case 18:
                        $htmlEstado = '<label"><i class="mdi mdi-check" style="color:lightgreen"></i> El equipo ha finalizado el capitulo digital RELEG 2022 🥳</label>';
                        $htmlValidar = '<button class="btn btn-success btn-rounded">No disponible</button>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">No disponible</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">No disponible</button>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<button class="btn btn-success btn-rounded">No disponible</button>';
                        break;
                    case 19:
                        $htmlEstado = '<label"><i class="mdi mdi-alert" style="color:yellow"></i> El equipo ha reenviado su discusión del capítulo digital RELEG 2022</label>';
                        $htmlValidar = '<button class="btn btn-success btn-rounded">No disponible</button>';
                        $htmlRechazar = '<button class="btn btn-rounded btn-danger">No disponible</button>';
                        $htmlReenviar = '<button class="btn btn-rounded btn-warning">No disponible</button>';
                        $htmlCorreo = '<a class="btn btn-primary btn-rounded" href="mensajeCorreoyAlert/correo/' . $c['claveCuerpo'] . '">Enviar correo de aviso</a>';
                        $htmlCategorizacion = 'Categorizacion revisada en la segunda fase.';
                        $htmlCapitulo = '<a class="btn btn-warning btn-rounded" href="capitulo/digital/' . $c['claveCuerpo'] . '">Ver capitulo digital</a>';
                        break;
                    default:
                        $htmlEstado = 'Falta';
                        $htmlValidar = 'Falta';
                        $htmlRechazar = 'Falta';
                        $htmlReenviar = 'Falta';
                        $htmlCorreo = 'Falta';
                        $htmlCategorizacion = 'Falta';
                        break;
                }
            } else {
                $htmlEstado = 'El equipo no ha enviado ninguna revisión';
            }

            #VERIFICAMOS SI EXISTEN CONSTANCIAS
            $condiciones = [
                "redCueAca" => $c,
                "anio" => $anio_investigacion
            ];

            if ($this->AdminModel->exist('constancia_Releg', $condiciones) == 1) {
                $htmlConstancias = '
                <div class="dropdown">
                    <button class="btn btn-info btn-rounded dropdown-toggle" type="button" id="dropdownMenuButtonConstancias" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Constancias otorgadas </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonConstancias">
                        <h6 class="dropdown-header">Acciones</h6>
                        <a class="dropdown-item text-danger" href="constancia_relmo/' . $c['claveCuerpo'] . '">Eliminar constancias</a>
                        </div>
                </div>
                ';
            } else {
                $htmlConstancias = '<a href="constancia_relmo/' . $c['claveCuerpo'] . '" class="btn btn-info btn-rounded">Otorgar constancias</a>';
            }

            $condicion = ['claveCuerpo' => $c['claveCuerpo']];

            $mensajes = $this->AdminModel->getAll("mensajes_CA", $condicion);

            $htmlMensajes = '';
            if (!empty($mensajes)) {
                foreach ($mensajes as $keyMensaje => $mensaje) {
                    $mensaje['mensaje'] = str_replace('"', '`', $mensaje['mensaje']);
                    if ($keyMensaje == 0) {
                        $htmlMensajes .= '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-rounded dropdown-toggle" type="button" id="dropdownMenuButtonMensajes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Mensajes </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonMensajes">
                            <h6 class="dropdown-header">Mensajes</h6>
                            <a class="dropdown-item dropdownMessage" data-toggle="modal" data-target="#myModal" data-message="' . $mensaje['mensaje'] . '">Ver mensaje</a>
                        ';
                    } else {
                        $htmlMensajes .= '
                        <a class="dropdown-item dropdownMessage" data-toggle="modal" data-target="#myModal" data-message="' . $mensaje['mensaje'] . '">Ver mensaje</a>
                        ';
                    }
                }

                $htmlMensajes .= '</div></div>';
            }


            $htmlMensajes = empty($htmlMensajes) ? 'Sin mensajes adjuntos' : $htmlMensajes;

            $data[] = [
                'id' => $i,
                'claveCuerpo' => $c['claveCuerpo'],
                'universidad' => $nombre_universidad['nombre'],
                'entrevistas' => $htmlVerEntrevistas,
                'carpetas' => $htmlCarpetas,
                'mensajes' => $htmlMensajes,
                'estado' => $htmlEstado,
                'validar' => $htmlValidar,
                'rechazar' => $htmlRechazar,
                'reenviar' => $htmlReenviar,
                'correo' => $htmlCorreo,
                'categorizacion' => $htmlCategorizacion,
                'capitulo' => $htmlCapitulo,
                'constancias' => $htmlConstancias
            ];

            $i++;
        }

        return $this->response->setJSON($data);
    }

    public function verEntrevistas($claveCuerpo)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $entrevistas = $this->AdminModel->getAll('entrevistas_Relmo', $condiciones);
        if (empty($entrevistas)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El equipo al que intenta acceder no existe o no tiene entrevistas registradas');
        }
        #obtenemos el nombre de la institucion
        $columnas = ['nombre'];
        $nombre_uni = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
        $data['nombre_uni'] = $nombre_uni['nombre'];
        $data['claveCuerpo'] = $claveCuerpo;

        return view('admin/headers/index')
            . view('admin/investigacionReleg/entrevistasEquipo', $data)
            . view('admin/footers/index');
    }

    public function verEntrevistasEquipo($claveCuerpo)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #HAY UNA CUESTION AQUI, SE MIRA UN SIMBOLO ENTRA ')' POR ESO LO ELIMINARE
        $claveCuerpo = str_replace(')', '', $claveCuerpo);
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $entrevistas = $this->AdminModel->getAll('entrevistas_Relmo', $condiciones);
        foreach ($entrevistas as $e) {

            $e['editado'] = $e['editado'] == 1 ? '<label class="text-danger">Editado</label>' : '<label class="text-success">Sin editar</label>';
            $htmlVerEntrevista = '<a href="../entrevista/' . $e['id'] . '" class="btn btn-info btn-rounded">Ver entrevista</a>';
            $htmlVerBitacora = '<a href="../bitacora/' . $e['id'] . '" class="btn btn-warning btn-rounded">Ver bitácora</a>';
            $htmlEstado = $e['estado'] == 0 ? '<a href="../validarEntrevista/1/' . $e['id'] . '"><i class="text-danger mdi mdi-alert-circle"></i></a>' : '<a href="../validarEntrevista/0/' . $e['id'] . '"><i class="text-success mdi mdi-check-circle"></i></a>';

            $data[] = [
                'id' => $e['id'],
                'nombre_entrevistadora' => $e['nombre_entrevistadora'],
                'institucion' => $e['pregunta9'],
                'editado' => $e['editado'],
                'ver' => $htmlVerEntrevista,
                'bitacora' => $htmlVerBitacora,
                'estado' => $htmlEstado
            ];
        }

        return $this->response->setJSON($data);
    }

    public function entrevista($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A OBTENER LOS DATOS
        $condiciones = ['id' => $id];
        $entrevista = $this->AdminModel->getAllOneRow('entrevistas_Relmo', $condiciones);
        if (empty($entrevista)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'La entrevista a la que intenta acceder no existe');
        }
        $condiciones = ['id' => $entrevista['pregunta10']];
        $estado = $this->AdminModel->getAllOneRow("estados", $condiciones);
        $entrevista['pregunta10'] = $estado["nombre"];

        $condiciones = ['id' => $entrevista['pregunta11']];
        $municipio = $this->AdminModel->getAllOneRow("municipios", $condiciones);
        $entrevista['pregunta11'] = $municipio["nombre"];

        $data['entrevista'] = $entrevista;

        #VAMOS A OBTENER EL ID DE TODAS LAS ENTREVISTAS QUE TIENE EL EQUIPO
        $columnas = ['id'];
        $condiciones = ['claveCuerpo' => $entrevista['claveCuerpo']];
        $id_entrevistas = $this->AdminModel->getAllColums($columnas, 'entrevistas_Relmo', $condiciones);
        foreach ($id_entrevistas as $key => $i) {
            if ($i['id'] == $id) {
                if (isset($id_entrevistas[$key - 1])) {
                    $anterior = $id_entrevistas[$key - 1]['id'];
                    if (isset($id_entrevistas[$key + 1])) {
                        $siguiente = $id_entrevistas[$key + 1]['id'];
                    } else {
                        $siguiente = '';
                    }
                } else {
                    $anterior = '';
                    if (isset($id_entrevistas[$key + 1])) {
                        $siguiente = $id_entrevistas[$key + 1]['id'];
                    } else {
                        $siguiente = '';
                    }
                }
            }
        }

        #OBTENEMOS LA LISTA DE CATEGORIAS DE ESE ID DE ENTREVISTA

        $condiciones = ['id_entrevista' => $id];
        $listaCategorias = $this->AdminModel->getAll('filtro_categorias', $condiciones);

        foreach ($entrevista as $key => $d) {

            foreach ($listaCategorias as $l) {
                $existe = stripos($d, $l['codigo_en_vivo']);
                if ($existe !== false) {
                    #$key es la posicion del array en donde se encontro
                    #vamos a buscar el color con el que se identifica
                    $condiciones = ['id' => $l['categoria']];
                    $infoColor = $this->AdminModel->getAllOneRow('categorias', $condiciones);
                    $remplazar = "<label class='e_" . $infoColor['color'] . "'>" . $l['codigo_en_vivo'] . "</label>";
                    #estilos_de_texto TIENE EL FORMATO AL QUE SE LE VA A DAR COLOR
                    $texto = str_replace($l['codigo_en_vivo'], $remplazar, $data['entrevista'][$key]);
                    $data['entrevista'][$key] = $texto;
                }
            }
        }

        $condiciones = ['activo' => 1];
        $categorias = $this->AdminModel->getAll('categorias', $condiciones);

        $data['categorias'] = $categorias;
        $data['entrevista']['siguiente'] = $siguiente;
        $data['entrevista']['anterior'] = $anterior;
        $data['entrevistas'] = $id_entrevistas;

        return view('admin/headers/index')
            . view('admin/investigacionReleg/entrevista', $data)
            . view('admin/footers/index');
    }

    public function bitacora($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A OBTENER LOS DATOS
        $condiciones = ['id' => $id];
        $entrevista = $this->AdminModel->getAllOneRow('entrevistas_Relmo', $condiciones);
        if (empty($entrevista)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'La entrevista a la que intenta acceder no existe');
        }
        #OBTENEMOS LA BITACORA
        $condiciones = ['id_entrevista' => $id];
        $bitacora = $this->AdminModel->getAllOneRow('bitacoras_Relmo', $condiciones);
        $data['bitacora'] = $bitacora;

        #VAMOS A OBTENER EL ID DE TODAS LAS ENTREVISTAS QUE TIENE EL EQUIPO
        $columnas = ['id'];
        $condiciones = ['claveCuerpo' => $entrevista['claveCuerpo']];
        $id_entrevistas = $this->AdminModel->getAllColums($columnas, 'entrevistas_Relmo', $condiciones);
        foreach ($id_entrevistas as $key => $i) {
            if ($i['id'] == $id) {
                if (isset($id_entrevistas[$key - 1])) {
                    $anterior = $id_entrevistas[$key - 1]['id'];
                    if (isset($id_entrevistas[$key + 1])) {
                        $siguiente = $id_entrevistas[$key + 1]['id'];
                    } else {
                        $siguiente = '';
                    }
                } else {
                    $anterior = '';
                    if (isset($id_entrevistas[$key + 1])) {
                        $siguiente = $id_entrevistas[$key + 1]['id'];
                    } else {
                        $siguiente = '';
                    }
                }
            }
        }


        $data['bitacora']['siguiente'] = $siguiente;
        $data['bitacora']['anterior'] = $anterior;
        $data['bitacora']['claveCuerpo'] = $entrevista['claveCuerpo'];
        $data['entrevistas'] = $id_entrevistas;

        return view('admin/headers/index')
            . view('admin/investigacionReleg/bitacora', $data)
            . view('admin/footers/index');
    }

    public function mensajeCorreoyAlert($estado, $claveCuerpo)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A MANDAR UNA VISTA, SOLO TOMAREMOS DATOS PARA LA VISTA
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['nombre'];
        $universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
        if (empty($universidad)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'La universidad a la que quiere cambiar el estado no existe');
        }
        $data['mensaje'] = [
            'universidad' => $universidad['nombre'],
            'claveCuerpo' => $claveCuerpo,
            'estado' => $estado
        ];

        preg_match_all('!\d+!', $estado, $matches);


        if (!empty($matches[0])) {
            #fase de categorizacion
            if ($matches[0][0] == 2) {
                $htmlCorreo = '
                <p>Estimada (s) investigadora (s) de la ' . $universidad['nombre'] . ':</p>
                <p>Por este medio les informamos que el estatus de la revisión de la CATEGORIZACIÓN es:</p>
                ';

                switch ($estado) {
                    case 'reenviar2':
                        $htmlCorreo .= '<p>REVISAR Y CORREGIR POR FAVOR</p>';
                        $modificaciones = '<p>Mucho agradeceremos que a la brevedad se puedan llevar a cabo las modificaciones señaladas.</p>';
                        break;
                    case 'rechazado2':
                        $htmlCorreo .= '<p>REVISAR Y CORREGIR POR FAVOR</p>';
                        $modificaciones = '<p>Mucho agradeceremos que a la brevedad se puedan llevar a cabo las modificaciones señaladas.</p>';
                        break;
                    case 'validado2':
                        $htmlCorreo .= '<p>ACEPTADO</p>';
                        break;
                }

                $htmlCorreo .= '
                <p>Observaciones:</p>
                <p></p>
                ';

                $htmlCorreo .= isset($modificaciones) ? $modificaciones : '';

                $htmlCorreo .= '
                <p>Muchas gracias y estamos al pendiente</p>
    
                <p>Comité Revisor RELEG</p>
    
                <p>P.D. En caso de responder este mensaje, opte por reenviar para incluir este texto en su mensaje.</p>
                ';
            }
        } else {
            #fase de captura
            $htmlCorreo = '
            <p>Estimada (s) investigadora (s) de la ' . $universidad['nombre'] . ':</p>
            <p>Por este medio les informamos que el  estatus de la revisión de la aplicación de sus entrevistas es:</p>
            ';

            switch ($estado) {
                case 'reenviar':
                    $htmlCorreo .= '<p>REVISAR Y CORREGIR POR FAVOR</p>';
                    $modificaciones = '<p>Mucho agradeceremos que a la brevedad se puedan llevar a cabo las modificaciones señaladas.</p>';
                    break;
                case 'rechazado':
                    $htmlCorreo .= '<p>REVISAR Y CORREGIR POR FAVOR</p>';
                    $modificaciones = '<p>Mucho agradeceremos que a la brevedad se puedan llevar a cabo las modificaciones señaladas.</p>';
                    break;
                case 'validado':
                    $htmlCorreo .= '<p>ACEPTADO</p>';
                    break;
            }

            $htmlCorreo .= '
            <p>Observaciones:</p>
            <p></p>
            ';

            $htmlCorreo .= isset($modificaciones) ? $modificaciones : '';

            $htmlCorreo .= '
            <p>Muchas gracias y estamos al pendiente</p>

            <p>Comité Revisor RELEG</p>

            <p>P.D. En caso de responder este mensaje, opte por reenviar para incluir este texto en su mensaje.</p>
            ';
        }

        $data['htmlCorreo'] = $htmlCorreo;


        return view('admin/headers/index')
            . view('admin/investigacionReleg/mensaje_estado', $data)
            . view('admin/footers/index');
    }

    public function enviarMensajeUpdate()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $fecha_actual = date("Y-m-d");
        $fecha_expiracion = date("Y-m-d", strtotime($fecha_actual . "+ 7 days"));

        #OBTENEMOS LOS USUARIOS DE LOS MIEMBROS DEL CUERPO ACADEMICO
        $condiciones = ['cuerpoAcademico' => $_POST['claveCuerpo']];
        $columnas = ['usuario'];
        $miembros = $this->AdminModel->getAllColums($columnas, 'miembros', $condiciones);
        #recorremos para obtener su correo
        $correos = [];
        foreach ($miembros as $m) {
            $usuario = $m['usuario'];
            $condiciones = ['usuario' => $usuario];
            $columnas = ['correo'];
            $infoUsuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
            if (!empty($infoUsuario)) {
                array_push($correos, $infoUsuario['correo']);
            }
        }

        if ($_POST['estado'] == 'correo') {
            $data = [
                'claveCuerpo' => $_POST['claveCuerpo'],
                'mensaje' => $_POST['mensaje'],
                'nivelAlerta' => 'info',
                'fechaExpiracion' => $fecha_expiracion,
                'activo' => 1
            ];
            #insertamos la alerta a la bd
            $this->AdminModel->generalInsert('mensajes_CA', $data);
            #Enviamos el correo
            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Equipo RELEG');
            $email->setTo($correos);
            $email->setSubject($_POST['asunto']);
            $email->setMessage($_POST['mensaje']);
            if ($email->send()) {
                echo 'success2';
            } else {
                echo 'error';
            }
        } else {

            //0 es rechazado

            //1 es que apenas lo envió

            //2 aceptada

            //3 reenviar

            //5 enviaron por primera vez su validacion

            switch ($_POST['estado']) {
                case 'validado':
                    $nivelAlerta = 'success';
                    $dataUpdate = ["terminado" => "2"];
                    $condiciones = ["claveCuerpo" => $_POST['claveCuerpo'], "anio" => date("Y") - 1];
                    $this->AdminModel->generalUpdate("validacion", $dataUpdate, $condiciones);
                    break;
                case 'rechazado':
                    $nivelAlerta = 'danger';
                    $dataUpdate = ["terminado" => "0"];
                    $condiciones = ["claveCuerpo" => $_POST['claveCuerpo'], "anio" => date("Y") - 1];
                    $this->AdminModel->generalUpdate("validacion", $dataUpdate, $condiciones);
                    break;
                case 'reenviar':
                    $nivelAlerta = 'warning';
                    $dataUpdate = ["terminado" => "3"];
                    $condiciones = ["claveCuerpo" => $_POST['claveCuerpo'], "anio" => date("Y") - 1];
                    $this->AdminModel->generalUpdate("validacion", $dataUpdate, $condiciones);
                    break;
                case 'validado2':
                    $nivelAlerta = 'success';
                    $dataUpdate = ["terminado" => "6"];
                    $condiciones = ["claveCuerpo" => $_POST['claveCuerpo'], "anio" => date("Y") - 1];
                    $this->AdminModel->generalUpdate("validacion", $dataUpdate, $condiciones);
                    break;
                case 'reenviar2':
                    $nivelAlerta = 'warning';
                    $dataUpdate = ["terminado" => "7"];
                    $condiciones = ["claveCuerpo" => $_POST['claveCuerpo'], "anio" => date("Y") - 1];
                    $this->AdminModel->generalUpdate("validacion", $dataUpdate, $condiciones);
                    break;
                case 'rechazado2':
                    $nivelAlerta = 'danger';
                    $dataUpdate = ["terminado" => "9"];
                    $condiciones = ["claveCuerpo" => $_POST['claveCuerpo'], "anio" => date("Y") - 1];
                    $this->AdminModel->generalUpdate("validacion", $dataUpdate, $condiciones);
                    break;
            }

            $cuerpo = ["claveCuerpo" => $_POST['claveCuerpo']];
            $getAllEntrevistas = $this->AdminModel->getAll("entrevistas_Relmo", $cuerpo);
            foreach ($getAllEntrevistas as $g) {
                $data = ['editado' => 0];
                $condiciones = ['id' => $g['id']];
                $this->AdminModel->generalUpdate("entrevistas_Relmo", $data, $condiciones);
            }

            $data = [
                'claveCuerpo' => $_POST['claveCuerpo'],
                'mensaje' => $_POST['mensaje'],
                'nivelAlerta' => $nivelAlerta,
                'fechaExpiracion' => $fecha_expiracion
            ];

            #insertamos la alerta a la bd
            $this->AdminModel->generalInsert('mensajes_CA', $data);

            #Enviamos el correo
            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Equipo RELEG');
            $email->setTo($correos);
            $email->setSubject($_POST['asunto']);
            $email->setMessage($_POST['mensaje']);
            if ($email->send()) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }

    public function constancia_relmo($claveCuerpo)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $anio_investigacion = 2022;

        $condiciones = ["cuerpoAcademico" => $claveCuerpo];

        $miembros = $this->AdminModel->getAll("miembros", $condiciones);

        $date = date('Y-m-d H:i:s');

        foreach ($miembros as $m) {

            $condiciones = [
                'usuario' => $m['usuario'],
                'redCueAca' => $claveCuerpo,
                'anio' => $anio_investigacion
            ];
            #VAMOS A VERIFICAR SI EXISTE UNA CONSTANCIA, SI NO EXISTE SE LA DAMOS,
            #SI EXISTE, SE LA QUITAMOS, PARA USAR LA FUNCION PARA LAS 2 FUNCIONES DE UNA VEZ

            $constancia = $this->AdminModel->getAllOneRow('constancia_Releg', $condiciones);

            if (empty($constancia)) {
                #No existe, agregamos constancias
                $data = [

                    "redCueAca" => $claveCuerpo,

                    "usuario" => $m["usuario"],

                    "nombre" => $m["nombre"] . " " . $m["apaterno"] . " " . $m["amaterno"],

                    "tipo_constancia" => "Miembro_investigador",

                    "red" => "Releg",

                    "anio" => $anio_investigacion,

                    "fecha_registro" => $date

                ];
                $folio = $this->AdminModel->generalInsertLastId($data, 'constancia_Releg');

                $dataUpdate = ['folio' => $folio];

                $condicionesUpdate = ['id' => $folio];

                $this->AdminModel->generalUpdate('constancia_Releg', $dataUpdate, $condicionesUpdate);
            } else {
                #LA CONSTANCIA EXISTE, SE LA QUITAMOS
                $this->AdminModel->generalDelete('constancia_Releg', $condiciones);
            }
        }

        return redirect()->back()
            ->with('icon', 'success')
            ->with('title', 'Éxito')
            ->with('text', 'Acción realizada correctamente al cuerpo académico <b>' . $claveCuerpo . '</b>');
    }

    public function categorias()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];
        $grupos = $this->AdminModel->getAll('dimensiones', $condiciones);

        $data['grupos'] = $grupos;

        return view('admin/headers/index')
            . view('admin/categorias/lista', $data)
            . view('admin/footers/index');
    }

    public function getListadoCategorias()
    {

        $valor_buscado = $this->request->getGet('search')['value']; #INPUT DE BUSCAR

        $table_map = ['id', 'nombre', 'descripcion', 'activo', 'grupo'];

        $sql_count = "SELECT count(id) as total FROM categorias";
        $sql_data = "SELECT * FROM categorias";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($table_map as $key => $val) {
                if ($table_map[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $table_map[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        #hacemos los cambios

        foreach ($array as $key => $d) {

            $condiciones = ['id' => $d['dimension']];

            $infoDimension = $this->AdminModel->getAllOneRow('dimensiones', $condiciones);

            $dimension = empty($infoDimension) ? '' : $infoDimension['nombre'];

            $condiciones = ['id' => $d['escala']];

            $infoEscala = $this->AdminModel->getAllOneRow('escalas', $condiciones);

            $escala = empty($infoEscala) ? '' : $infoEscala['nombre'];

            $condiciones = ['id_dimension' => $d['dimension']];
            $exist_escala = $this->AdminModel->exist('escalas', $condiciones);

            $array[$key] = [
                'id' => $d['id'],
                'nombre' => $d['nombre'],
                'claveCuerpo' => $d['claveCuerpo'],
                'descripcion' => $d['descripcion'],
                'cev' => $d['codigo_en_vivo'],
                'activo' => $d['activo'],
                'dimension' => $dimension,
                'escala' => $escala,
                'exist_escala' => $exist_escala
            ];
        }

        #Lo convertimos de nuevo a objeto
        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function actualizarGrupoListaNormal()
    {
        $data = ['dimension' => $_POST['grupo'], 'escala' => ''];
        $condiciones = ['id' => $_POST['id']];

        if (!$this->AdminModel->generalUpdate('categorias', $data, $condiciones)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al asignar la dimensión a la categoría.';
            echo $mensaje;
            exit;
        }

        $return = [
            'title' => 'Éxito',
            'text' => 'Dimensión asignada correctamente'
        ];

        echo json_encode($return);
        exit;
    }

    public function getEscalas()
    {

        $condiciones = ['id' => $_POST['id']];
        $columnas = ['dimension'];
        $categoria = $this->AdminModel->getColumnsOneRow($columnas, 'categorias', $condiciones);

        if (empty($categoria)) {
            http_response_code(400);
            $mensaje = 'Esta dimensión no tiene escalas registradas';
            echo $mensaje;
            exit;
        }

        $condiciones = ['id_dimension' => $categoria['dimension']];
        $escalas = $this->AdminModel->getAll('escalas', $condiciones);

        if (empty($escalas)) {
            http_response_code(402);
            $mensaje = 'Ha ocurrido un error recuperando las escalas. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        echo json_encode($escalas);
        exit;
    }

    public function actualizarEscala()
    {

        $data = ['escala' => $_POST['escala']];
        $condiciones = ['id' => $_POST['id']];

        if (!$this->AdminModel->generalUpdate('categorias', $data, $condiciones)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al asignar la escala a la categoría.';
            echo $mensaje;
            exit;
        }

        $return = [
            'title' => 'Éxito',
            'text' => 'Escala asignada correctamente'
        ];

        echo json_encode($return);
        exit;
    }


    public function editarCategoria($id)
    {
        #VAMOS A EDITAR UNA CATEGORIA
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $categoria = $this->AdminModel->getAllOneRow('categorias', $condiciones);
        if (empty($categoria)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'La categoría que quiere editar no existe');
        }
        $data['categoria'] = $categoria;

        return view('admin/headers/index')
            . view('admin/categorias/editar', $data)
            . view('admin/footers/index');
    }

    public function updateCategorias()
    {

        #FUNCIONALIDAD PARA AJAX, VAYA AL ARCHIVO JS

        $condiciones = ['id' => $_POST['id']];

        $data = $_POST;

        unset($data['id']);

        if ($this->AdminModel->generalUpdate('categorias', $data, $condiciones) == 1) {
            echo 'success';
        } else {
            echo 'error';
        }
    }

    public function mensajeValidacion($estado, $id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        $condiciones = ['id' => $id];
        $categoria = $this->AdminModel->getAllOneRow('categorias', $condiciones);

        if (empty($categoria)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'La categoría que quiere editar no existe');
        }

        $data = [
            'estado' => $estado,
            'id' => $id,
            'nombre' => $categoria['nombre'],
            'claveCuerpo' => $categoria['claveCuerpo']
        ];

        return view('admin/headers/index')
            . view('admin/categorias/correo', $data)
            . view('admin/footers/index');
    }

    public function updateEstadoCategorias()
    {

        if (empty($_POST['claveCuerpo'])) {
            #cambiamos el estado pero no hay mensaje porque es el administrador
            $condiciones = ['id' => $_POST['id']];
            $data = ['activo' => $_POST['estado']];

            if ($this->AdminModel->generalUpdate('categorias', $data, $condiciones) == 1) {
                echo 'successAdmin';
                exit;
            }
        } else {
            $condiciones = ['id' => $_POST['id']];
            $data = ['activo' => $_POST['estado']];
            $this->AdminModel->generalUpdate('categorias', $data, $condiciones);
            #OBTENEMOS LOS USUARIOS DE LOS MIEMBROS DEL CUERPO ACADEMICO
            $condiciones = ['cuerpoAcademico' => $_POST['claveCuerpo']];
            $columnas = ['usuario'];
            $miembros = $this->AdminModel->getAllColums($columnas, 'miembros', $condiciones);
            #recorremos para obtener su correo
            $correos = [];
            foreach ($miembros as $m) {
                $usuario = $m['usuario'];
                $condiciones = ['usuario' => $usuario];
                $columnas = ['correo'];
                $infoUsuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
                if (!empty($infoUsuario)) {
                    array_push($correos, $infoUsuario['correo']);
                }
            }
            $fecha_actual = date("Y-m-d");
            $fecha_expiracion = date("Y-m-d", strtotime($fecha_actual . "+ 7 days"));

            $data = [
                'claveCuerpo' => $_POST['claveCuerpo'],
                'mensaje' => $_POST['mensaje'],
                'nivelAlerta' => 'info',
                'fechaExpiracion' => $fecha_expiracion
            ];

            #insertamos la alerta a la bd
            $this->AdminModel->generalInsert('mensajes_CA', $data);

            #Enviamos el correo
            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Equipo RELEG');
            $email->setTo($correos);
            $email->setSubject($_POST['asunto']);
            $email->setMessage($_POST['mensaje']);
            if ($email->send()) {
                echo 'successCorreos';
            } else {
                echo 'error';
            }
        }
    }

    public function validarEntrevista($estado, $id)
    {
        $condiciones = ['id' => $id];
        $data = ['estado' => $estado];

        if ($this->AdminModel->generalUpdate('entrevistas_Relmo', $data, $condiciones) == 1) {
            return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'Éxito')
                ->with('text', 'La entrevista con ID <b>' . $id . '</b> ha cambiado de estado');
        } else {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, contacte a sistemas');
        }
    }

    public function eliminarCategoria($id)
    {
        $condiciones = ['id' => $id];
        $columnas = ['claveCuerpo'];
        $ca = $this->AdminModel->getColumnsOneRow($columnas, 'categorias', $condiciones);
        if ($this->AdminModel->generalDelete("categorias", $condiciones) == 1) {

            $condiciones = ['cuerpoAcademico' => $ca['claveCuerpo']];
            $columnas = ['usuario'];
            $usuarios = $this->AdminModel->getColumnsOneRow($columnas, 'miembros', $condiciones);
            $arr_correos = [];
            foreach ($usuarios as $u) {
                $condiciones = ['usuario' => $u];
                $columnas = ['correo'];
                $correo = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
                array_push($arr_correos, $correo['correo']);
            }
            $html = '
            <p>Estimadas Investigadoras: su categoría no ha sido aceptada derivado de alguno de los siguientes aspectos:</p> 
            <p>1.- se encuentra repetida con una categoría enviada por un equipo que la envió con anterioridad.</p>
            <p>2.- No cuenta o no cumple con los suficientes argumentos avalados con los "códigos en vivo"  para ser considerado categoría</p>
            <p>3.- El fenómeno que se describe ya se encuentra considerado dentro de alguna categoría descrita del primer catálogo publicado.</p>
            <p>El Comité Académico agradece su aportación.</p>';
            $fecha_actual = date("Y-m-d");
            $fecha_expiracion = date("Y-m-d", strtotime($fecha_actual . "+ 7 days"));
            $data = [
                'claveCuerpo' => $ca['claveCuerpo'],
                'nivelAlerta' => 'danger',
                'mensaje' => $html,
                'activo' => 1,
                'fechaExpiracion' => $fecha_expiracion
            ];
            $this->AdminModel->generalInsert('mensajes_CA', $data);
            #Enviamos el correo
            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Equipo RELEG');
            $email->setTo($arr_correos);
            $email->setSubject('Información sobre su propuesta de categoría');
            $email->setMessage($html);

            if ($email->send()) {
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'ÉXITO')
                    ->with('text', 'Categoría eliminada correctamente');
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error. Contacte a sistemas.');
            }
        } else {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Contacte a sistemas');
        }
    }

    public function categorizacion($claveCuerpo)
    {
        $condiciones = ['claveCuerpo' => $claveCuerpo];

        if (!$this->AdminModel->exist('entrevistas_Relmo', $condiciones)) {
            echo 'No existe pa atras';
        }

        $columnas = ['nombre'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        $data['claveCuerpo'] = $claveCuerpo;
        $data['universidad'] = $universidad['nombre'];

        return view('admin/headers/index')
            . view('admin/categorizacion/lista', $data)
            . view('admin/footers/index');
    }

    public function getListaCategorizacion($claveCuerpo)
    {
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'id_entrevista', 'categoria', 'codigo_en_vivo', 'claveCuerpo'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM filtro_categorias";
        $sql_data = "SELECT * FROM filtro_categorias";

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
                    $condicion .= ' WHERE (claveCuerpo = "' . $claveCuerpo . '") AND ( ' . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }



        $sql_count = empty($condicion) ? $sql_count . ' WHERE claveCuerpo = "' . $claveCuerpo . '"' : $sql_count . $condicion . ')';

        $sql_data =  !empty($condicion) ? $sql_data . $condicion . ')' : $sql_data . ' WHERE claveCuerpo = "' . $claveCuerpo . '"';

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            $condiciones = ['id' => $a['categoria']];
            $columnas = ['color', 'nombre'];
            $categoria = $this->AdminModel->getColumnsOneRow($columnas, 'categorias', $condiciones);
            $color = $categoria['color'];
            $htmlCategoria = '<i class="mdi mdi-checkbox-blank-circle" style="color: #' . $color . '"></i> ' . $categoria['nombre'];
            $limit = substr($a['codigo_en_vivo'], 0, 172);
            $htmlCodigo = '<label style="color: #' . $color . '" title="' . $a['codigo_en_vivo'] . '">' . $limit . '</label>';

            $columnas = ['id'];
            $condiciones = ['id' => $a['id_entrevista']];
            $entrevista = $this->AdminModel->getColumnsOneRow($columnas, 'entrevistas_Relmo', $condiciones);

            $condiciones_delete = ['id_entrevista' => $a['id_entrevista']];

            if (empty($entrevista)) {
                $id_entrevista = 'Entrevista eliminada. Se eliminara al recargar la página';
                $this->AdminModel->generalDelete('filtro_categorias', $condiciones_delete);
            } else {
                $id_entrevista = $entrevista['id'];
            }

            $array[$key] = [
                'id' => $id_entrevista,
                'categoria' => $htmlCategoria,
                'codigo_en_vivo' => $htmlCodigo
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

    public function capituloReleg($claveCuerpo)
    {
        $condiciones = [
            'claveCuerpo' => $claveCuerpo,
            'anio' => 2022
        ];
        #MXM-UAEH02
        $capitulo = $this->AdminModel->getAllOneRow('capitulos_releg', $condiciones);

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
            $info_categoria = $this->AdminModel->getAllOneRow('categorias', $condiciones);

            $explode_codigos = explode(',', $explode_categoria[1]);
            $grupos = array_chunk($explode_codigos, 2);
            $str_info_codigos = '';
            foreach ($grupos as $key => $g) {
                $id_entrevista = $g[0];
                $id_codigo_en_vivo = $g[1];
                $condiciones = ['id' => $id_codigo_en_vivo];
                $info_codigo = $this->AdminModel->getAllOneRow('filtro_categorias', $condiciones);
                $columnas = ['pregunta1', 'pregunta2', 'pregunta3', 'pregunta4', 'pregunta12', 'pregunta6', 'pregunta10'];
                $condiciones = ['id' => $id_entrevista];
                $entrevista = $this->AdminModel->getColumnsOneRow($columnas, 'entrevistas_Relmo', $condiciones);
                $caracteristicas = 'Estudiante universitaria de ' . $entrevista['pregunta1'] . ' años, ' . $entrevista['pregunta2'];
                $tipo_institucion = $entrevista['pregunta12'] == 'público' ? 'pública' : 'privada';
                $condiciones = ['id' => $entrevista['pregunta10']];
                $estado = $this->AdminModel->getAllOneRow('estados', $condiciones);
                $estado = empty($estado) ? $entrevista['pregunta10'] : $estado['nombre'];
                $caracteristicas .= ', de ' . $entrevista['pregunta6'] . ', institución ' . $tipo_institucion . '.';
                $caracteristicas = rtrim($caracteristicas, ', ');
                $caracteristicas = ucfirst(strtolower($caracteristicas));
                $info = "<p style='font-family: Herlvetica; font-size: 12pt;text-align: center;'>Entrevista {$id_entrevista}. {$caracteristicas}</p>";
                $info_onlydata = "Entrevista {$id_entrevista}. {$caracteristicas}";
                $caracter = '"';
                $str_info_codigos .= "<label style='font-family: Herlvetica; font-size: 12pt;text-align: center;'><i>{$caracter}{$info_codigo['codigo_en_vivo']}{$caracter}</i>.<div style='display: inline-block;height: 1em;'></div>{$info}<div style='height: 1em;'></div></label><div style='height: 1em;'></div>";
                # "sdkbfjsdvfjsdvf". 
                $dataCodigos[$key] = [
                    'id_entrevista' => $id_entrevista,
                    'codigo_en_vivo' => $info_codigo['codigo_en_vivo'],
                    'descripcion' => $info_onlydata,
                    'id_codigo' => $id_codigo_en_vivo,
                    'caracteristicas' => $caracteristicas,
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

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
        $orden_autores = $this->AdminModel->getAll('ordenes_autores', $condiciones);
        if (empty($orden_autores)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Cuidado')
                ->with('text', 'Debe completar su orden de autores para continuar.');
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['nombre', 'municipio', 'estado'];
        $universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        $condiciones = ['id' => $universidad['estado']];
        $estado = $this->AdminModel->getAllOneRow('estados', $condiciones);
        $nombre_estado = empty($estado) ? $universidad['estado'] : $estado['nombre'];

        $condiciones = ['id' => $universidad['municipio']];
        $municipio = $this->AdminModel->getAllOneRow('municipios', $condiciones);
        $nombre_mun = empty($municipio) ? $universidad['municipio'] : $municipio['nombre'];

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $municipios_adicionales = $this->AdminModel->getAll('municipios_ca', $condiciones);

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
        $categorias = $this->AdminModel->getAllDistinc($columnas, "filtro_categorias", $condiciones);
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
            $info_categoria = $this->AdminModel->getAllOneRow('categorias', $condiciones);
            if (empty($info_categoria)) {
                echo 'No existe la categoria, ha existido un error y regresar';
                return;
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['categoria']];
            $cantidad = $this->AdminModel->count('filtro_categorias', $condiciones);


            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];

            $columnas = ['id_entrevista'];

            $entrevistas = $this->AdminModel->getAllDistinc($columnas, "filtro_categorias", $condiciones); #LO OCUPO PARA LA LISTA DE TODAS LAS ENTREVISTAS Y CODIGOS EN VIVO
            $arr_codigos_cat = [];
            $columnas = ['id_entrevista', 'codigo_en_vivo'];
            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];
            $codigos_categoria = $this->AdminModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
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
        $countCodigos = $this->AdminModel->count('filtro_categorias', $condiciones);
        $countEntrevistas = $this->AdminModel->count('entrevistas_Relmo', $condiciones);

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
            'observaciones' => $capitulo['observaciones'],
            'nombre_estado' => $nombre_estado
        ];

        $tipo_orden_autores = $orden_autores[0]['orden_impreso'] != 0 ? 'orden_impreso' : 'orden_digital';
        $key_sort3  = array_column($orden_autores, $tipo_orden_autores);
        array_multisort($key_sort3, SORT_ASC, $orden_autores);

        $htmlOrdenAutores = '';
        foreach ($orden_autores as $key4 => $o) {
            $condiciones = ['usuario' => $o['usuario']];
            $usuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);
            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $htmlOrdenAutores .= "<li>{$nombre}</li>";
            $data['ordenes_autores'][] = $nombre;
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['discusion'];

        $discusion_info = $this->AdminModel->getColumnsOneRow($columnas,'capitulos_releg',$condiciones);
        $txt_discusion = 'Pendiente de redactar por el grupo de investigación.';
        if(isset($discusion_info)){
            if(!empty($discusion_info['discusion'])){
                $txt_discusion = $discusion_info['discusion'];
            }
        }


        
        


        $numero_entrevistas = $data['c_entrevistas'];
        $numero_bitacoras = $data['c_entrevistas'];
        $numero_autores = count($data['ordenes_autores']);
        $promedio_edad = $this->getPromedioReleg('pregunta1',$claveCuerpo);
        $porcentajes_estados_civiles = $this->getPorcentajeReleg('estado_civil',$claveCuerpo,$data['c_entrevistas']);
        $porcentajes_grados_academicos = $this->getPorcentajeReleg('grados_academicos',$claveCuerpo,$data['c_entrevistas']);
        $porcentajes_tipo_institucion = $this->getPorcentajeReleg('tipo_institucion',$claveCuerpo,$data['c_entrevistas']);
        $promedio_personas = $this->getPromedioReleg('pregunta14',$claveCuerpo);
        $promedio_mujeres = $this->getPromedioReleg('pregunta15',$claveCuerpo);
        $promedio_familiares = $this->getPromedioReleg('pregunta16',$claveCuerpo);
        $porcentaje_modalidades = $this->getPorcentajeReleg('modalidades',$claveCuerpo,$data['c_entrevistas']);
        $porcentaje_hijos = $this->getPorcentajeReleg('hijos',$claveCuerpo,$data['c_entrevistas']);

        //VAMOS A MANDAR TODOS LOS DATOS A DATA

        $dataMerge = [
            'numero_entrevistas' => $numero_entrevistas,
            'numero_bitacoras' => $numero_bitacoras,
            'numero_autores' => $numero_autores,
            'promedio_edad' => $promedio_edad,
            'porcentajes_estados_civiles' => $porcentajes_estados_civiles,
            'porcentajes_grados_academicos' => $porcentajes_grados_academicos,
            'porcentajes_tipo_institucion' => $porcentajes_tipo_institucion,
            'promedio_personas' => $promedio_personas,
            'promedio_mujeres' => $promedio_mujeres,
            'promedio_familiares' => $promedio_familiares,
            'porcentaje_modalidades' => $porcentaje_modalidades,
            'porcentaje_hijos' => $porcentaje_hijos,
            'txt_discusion' => $txt_discusion
        ];

        $data = array_merge($data,$dataMerge);

        //Ahora de estos queda pendiente sacalos de manera general 
        
        //grados_academicos

        

        /* $htmlTable = "
        <table style='border: 1px solid black; color:black; width: 100%; text-align: center;'>
            <thead style='background-color: #D3D3D3;'>
                <tr>
                    <th style='text-align: center;'>Característica</th>
                    <th style='text-align: center;'>Promedio</th>
                    <th style='text-align: center;'>Característica</th>
                    <th style='text-align: center;'>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style='text-align: center;'><b>Edad promedio</b></td>
                    <td style='text-align: center;'>{$promedio_edad}</td>
                    <td style='text-align: center;'><b>Estado Civil</b></td>
                    <td style='text-align: center;'></td>
                </tr>
                <tr>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'>Casadas</td>
                    <td style='text-align: center;'>{$porcentajes_estados_civiles['Casada']}%</td>
                </tr>
                <tr>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'>Solteras</td>
                    <td style='text-align: center;'>{$porcentajes_estados_civiles['Soltera']}%</td>
                </tr>
                <tr>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'>Divorciadas</td>
                    <td style='text-align: center;'>{$porcentajes_estados_civiles['Divorciada']}%</td>
                </tr>
                <tr>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'>Divorciadas</td>
                    <td style='text-align: center;'>{$porcentajes_estados_civiles['Divorciada']}%</td>
                </tr>
                <tr>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'>Viudas</td>
                    <td style='text-align: center;'>0.0%</td>
                </tr>
                <tr>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'>En concubinato</td>
                    <td style='text-align: center;'>{$porcentajes_estados_civiles['Concubinato']}%</td>
                </tr>
                <thead style='background-color: #D3D3D3;'>
                <tr>
                    <th style='text-align: center;'>Característica</th>
                    <th style='text-align: center;'>Porcentaje</th>
                    <th style='text-align: center;'>Característica</th>
                    <th style='text-align: center;'>Porcentaje</th>
                </tr>
            </thead>
                <tr>
                    <td style='text-align: center;'><b>Hijos (as)</b></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'><b>Grado académico</b></td>
                    <td style='text-align: center;'></td>
                </tr>
                <tr>
                    <td style='text-align: center;'>Tiene hijos (as)</td>
                    <td style='text-align: center;'>{$porcentaje_hijos['si']}%</td>
                    <td style='text-align: center;'>TSU</td>
                    <td style='text-align: center;'>{$porcentajes_grados_academicos['TSU']}%</td>
                </tr>
                <tr>
                    <td style='text-align: center;'>No tiene hijos (as)</td>
                    <td style='text-align: center;'>{$porcentaje_hijos['no']}%</td>
                    <td style='text-align: center;'>Licenciatura</td>
                    <td style='text-align: center;'>{$porcentajes_grados_academicos['Licenciatura']}%</td>
                </tr>
                <tr>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'>Maestría</td>
                    <td style='text-align: center;'>{$porcentajes_grados_academicos['Maestría']}%</td>
                </tr>
                <tr>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'></td>
                    <td style='text-align: center;'>Doctorado</td>
                    <td style='text-align: center;'>{$porcentajes_grados_academicos['Doctorado']}%</td>
                </tr>
            </tbody>
        </table>
        ";
        

        $html = "
        <div style='font-family: Herlvetica; font-size: 12pt;'><label>Capítulo ~no_capitulo~. Los obstáculos que tienen las estudiantes de la {$data['universidad']} que dirigen una micro o pequeña empresa en {$data['municipios']}.
        </label>
        <ul>
            {$htmlOrdenAutores}
        </ul>
        <p style='font-size: 14pt;font-weight: bold;'>Resumen</p>
        <label>Pendiente de redactar.</label>
        <p style='font-size: 14pt;font-weight: bold;'>Palabras clave</p>
        <label>Pendiente de redactar.</label>
        <p style='font-size: 14pt;font-weight: bold;'>Introducción</p>
        <label>Pendiente de redactar.</label>

        <p style='font-size: 14pt;font-weight: bold;'>Método</p>
        <p>Esta investigación por la naturaleza del planteamiento de su objetivo fue abordada desde un enfoque cualitativo, toda vez que se busca conocer los obstáculos que tienes las estudiantes universitarias mexicanas en la dirección de su micro o pequeña empresa:</p>
        <p style='margin-left: 20pt;'>Del porqué de la selección del diseño de investigación cualitativa radica principalmente en las siguientes características:</p>

        <p style='font-size: 14pt;font-weight: bold;'>Resultados</p>

        {$htmlTable}

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
        $html .= "
        <p style='font-size: 14pt;font-weight: bold;'>Discusión</p>
        <label>{$txt_discusion}</label>
        ";

        $data['html_capitulo'] = $html; */

        

        return view('admin/headers/index')
            . view('admin/capitulos/Releg/2022/index', $data)
            . view('admin/footers/index');
    }

    private function getDataCapituloImpresoReleg($claveCuerpo){
        $condiciones = [
            'claveCuerpo' => $claveCuerpo,
            'anio' => 2022
        ];
        #MXM-UAEH02
        $capitulo = $this->AdminModel->getAllOneRow('capitulos_releg', $condiciones);

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
            $info_categoria = $this->AdminModel->getAllOneRow('categorias', $condiciones);

            $explode_codigos = explode(',', $explode_categoria[1]);
            $grupos = array_chunk($explode_codigos, 2);
            $str_info_codigos = '';
            foreach ($grupos as $key => $g) {
                $id_entrevista = $g[0];
                $id_codigo_en_vivo = $g[1];
                $condiciones = ['id' => $id_codigo_en_vivo];
                $info_codigo = $this->AdminModel->getAllOneRow('filtro_categorias', $condiciones);
                $columnas = ['pregunta1', 'pregunta2', 'pregunta3', 'pregunta4', 'pregunta12', 'pregunta6', 'pregunta10'];
                $condiciones = ['id' => $id_entrevista];
                $entrevista = $this->AdminModel->getColumnsOneRow($columnas, 'entrevistas_Relmo', $condiciones);
                $caracteristicas = 'Estudiante universitaria de ' . $entrevista['pregunta1'] . ' años, ' . $entrevista['pregunta2'];
                $tipo_institucion = $entrevista['pregunta12'] == 'público' ? 'pública' : 'privada';
                $condiciones = ['id' => $entrevista['pregunta10']];
                $estado = $this->AdminModel->getAllOneRow('estados', $condiciones);
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
                    'id_codigo' => $id_codigo_en_vivo,
                    'caracteristicas' => $caracteristicas,
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

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
        $orden_autores = $this->AdminModel->getAll('ordenes_autores', $condiciones);
        if (empty($orden_autores)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Cuidado')
                ->with('text', 'Debe completar su orden de autores para continuar.');
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['nombre', 'municipio', 'estado'];
        $universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        $condiciones = ['id' => $universidad['estado']];
        $estado = $this->AdminModel->getAllOneRow('estados', $condiciones);
        $nombre_estado = empty($estado) ? $universidad['estado'] : $estado['nombre'];

        $condiciones = ['id' => $universidad['municipio']];
        $municipio = $this->AdminModel->getAllOneRow('municipios', $condiciones);
        $nombre_mun = empty($municipio) ? $universidad['municipio'] : $municipio['nombre'];

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $municipios_adicionales = $this->AdminModel->getAll('municipios_ca', $condiciones);

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
        $categorias = $this->AdminModel->getAllDistinc($columnas, "filtro_categorias", $condiciones);
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
            $info_categoria = $this->AdminModel->getAllOneRow('categorias', $condiciones);
            if (empty($info_categoria)) {
                echo 'No existe la categoria, ha existido un error y regresar';
                return;
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['categoria']];
            $cantidad = $this->AdminModel->count('filtro_categorias', $condiciones);


            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];

            $columnas = ['id_entrevista'];

            $entrevistas = $this->AdminModel->getAllDistinc($columnas, "filtro_categorias", $condiciones); #LO OCUPO PARA LA LISTA DE TODAS LAS ENTREVISTAS Y CODIGOS EN VIVO
            $arr_codigos_cat = [];
            $columnas = ['id_entrevista', 'codigo_en_vivo'];
            $condiciones = [
                "claveCuerpo" => $claveCuerpo,
                'categoria' => $c['categoria']
            ];
            $codigos_categoria = $this->AdminModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
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
        $countCodigos = $this->AdminModel->count('filtro_categorias', $condiciones);
        $countEntrevistas = $this->AdminModel->count('entrevistas_Relmo', $condiciones);

        if ($claveCuerpo == 'MXM-SCU01') {
            $universidad['nombre'] == 'SINCE Colegio Universitario, S.C.';
        }

        $data = [
            'enfoque' => $capitulo['enfoque'],
            'categorias' => $dataCategoria,
            'universidad_completo' => $universidad['nombre'] . ' en ' . $str_municipios . ', ' . $nombre_estado . '. México',
            'universidad' => $universidad['nombre'],
            'municipios' => $str_municipios . ', ' . $nombre_estado . '. México',
            'only_municipios' => $str_municipios,
            'estado' => $nombre_estado,
            'str_categorias' => $str_categorias,
            'c_codigos' => $countCodigos,
            'c_entrevistas' => $countEntrevistas,
            'id_capitulo' => $capitulo['id'],
            'claveCuerpo' => $capitulo['claveCuerpo'],
            'codigos_validos' => $capitulo['codigos_validos'],
            'analisis_validos' => $capitulo['analisis_validos'],
            'observaciones' => $capitulo['observaciones']
        ];

        $tipo_orden_autores = $orden_autores[0]['orden_impreso'] != 0 ? 'orden_impreso' : 'orden_digital';
        $key_sort3  = array_column($orden_autores, $tipo_orden_autores);
        array_multisort($key_sort3, SORT_ASC, $orden_autores);

        $htmlOrdenAutores = '';
        foreach ($orden_autores as $key4 => $o) {
            $condiciones = ['usuario' => $o['usuario']];
            $usuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);
            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $htmlOrdenAutores .= "<li>{$nombre}</li>";
            $data['ordenes_autores'][] = $nombre;
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['discusion'];

        $discusion_info = $this->AdminModel->getColumnsOneRow($columnas,'capitulos_releg',$condiciones);
        $txt_discusion = 'Pendiente de redactar por el grupo de investigación.';
        if(isset($discusion_info)){
            if(!empty($discusion_info['discusion'])){
                $txt_discusion = $discusion_info['discusion'];
            }
        }

        $numero_entrevistas = $data['c_entrevistas'];
        $numero_bitacoras = $data['c_entrevistas'];
        $numero_autores = count($data['ordenes_autores']);
        $promedio_edad = $this->getPromedioReleg('pregunta1',$claveCuerpo);
        $porcentajes_estados_civiles = $this->getPorcentajeReleg('estado_civil',$claveCuerpo,$data['c_entrevistas']);
        $porcentajes_grados_academicos = $this->getPorcentajeReleg('grados_academicos',$claveCuerpo,$data['c_entrevistas']);
        $porcentajes_tipo_institucion = $this->getPorcentajeReleg('tipo_institucion',$claveCuerpo,$data['c_entrevistas']);
        $promedio_personas = $this->getPromedioReleg('pregunta14',$claveCuerpo);
        $promedio_mujeres = $this->getPromedioReleg('pregunta15',$claveCuerpo);
        $promedio_familiares = $this->getPromedioReleg('pregunta16',$claveCuerpo);
        $porcentaje_modalidades = $this->getPorcentajeReleg('modalidades',$claveCuerpo,$data['c_entrevistas']);
        $porcentaje_hijos = $this->getPorcentajeReleg('hijos',$claveCuerpo,$data['c_entrevistas']);

        $promedio_edad_general = $this->getPromedioReleg('pregunta1','');
        $porcentajes_estados_civiles_general = $this->getPorcentajeReleg('estado_civil','',$data['c_entrevistas']);
        $porcentajes_grados_academicos_general = $this->getPorcentajeReleg('grados_academicos','',$data['c_entrevistas']);
        $porcentajes_tipo_institucion_general = $this->getPorcentajeReleg('tipo_institucion','',$data['c_entrevistas']);
        $promedio_personas_general = $this->getPromedioReleg('pregunta14','');
        $promedio_mujeres_general = $this->getPromedioReleg('pregunta15','');
        $promedio_familiares_general = $this->getPromedioReleg('pregunta16','');
        $porcentaje_modalidades_general = $this->getPorcentajeReleg('modalidades','',$data['c_entrevistas']);
        $porcentaje_hijos_general = $this->getPorcentajeReleg('hijos','',$data['c_entrevistas']);

        //VAMOS A MANDAR TODOS LOS DATOS A DATA

        $dataMerge = [
            'numero_entrevistas' => $numero_entrevistas,
            'numero_bitacoras' => $numero_bitacoras,
            'numero_autores' => $numero_autores,
            'promedio_edad' => $promedio_edad,
            'porcentajes_estados_civiles' => $porcentajes_estados_civiles,
            'porcentajes_grados_academicos' => $porcentajes_grados_academicos,
            'porcentajes_tipo_institucion' => $porcentajes_tipo_institucion,
            'promedio_personas' => $promedio_personas,
            'promedio_mujeres' => $promedio_mujeres,
            'promedio_familiares' => $promedio_familiares,
            'porcentaje_modalidades' => $porcentaje_modalidades,
            'porcentaje_hijos' => $porcentaje_hijos,
            'txt_discusion' => $txt_discusion,
            'promedio_edad_general' => $promedio_edad_general,
            'porcentajes_estados_civiles_general' => $porcentajes_estados_civiles_general,
            'porcentajes_grados_academicos_general' => $porcentajes_grados_academicos_general,
            'porcentajes_tipo_institucion_general' => $porcentajes_tipo_institucion_general,
            'promedio_personas_general' => $promedio_personas_general,
            'promedio_mujeres_general' => $promedio_mujeres_general,
            'promedio_familiares_general' => $promedio_familiares_general,
            'porcentaje_modalidades_general' => $porcentaje_modalidades_general,
            'porcentaje_hijos_general' => $porcentaje_hijos_general
        ];

        $data = array_merge($data,$dataMerge);
        return $data;
    }

    private function getPromedioReleg($columna,$claveCuerpo){
        $suma = 0;
        $condiciones = [];
        if($claveCuerpo != ''){
            $condiciones = ['claveCuerpo' => $claveCuerpo];
        }
        
        $columnas = [$columna];
        $info = $this->AdminModel->getAllColums($columnas,'entrevistas_Relmo',$condiciones);

        $cantidad = count($info);
        
        foreach ($info as $valor) {
            $suma += $valor[$columna];
        }

        $promedio = $suma / $cantidad;
        $promedio = $this->removeExtraDecimals($promedio);
        return $promedio;
    }

    private function getPorcentajeReleg($tipo,$claveCuerpo,$c_entrevistas){

        $data = [];
        $tipos = [];

        if($tipo == 'estado_civil'){
            $tipos = [
                'Soltera','Casada','Concubinato','Divorciada'
            ];
            $pregunta = 'pregunta2';
        }else if($tipo == 'grados_academicos'){
            $tipos = [
                'Licenciatura','Maestría','TSU','Doctorado','Posgrado'
            ];
            $pregunta = 'pregunta6';
        }else if($tipo == 'tipo_institucion'){
            $tipos = [
                'público','privado'
            ];
            $pregunta = 'pregunta12';
        }else if($tipo == 'modalidades'){
            $tipos = [
                'mixta','física','virtual'
            ];
            $pregunta = 'pregunta18';
        }
        else if($tipo == 'hijos'){
            $tipos = [
                'si','no'
            ];
            $pregunta = 'pregunta3';
        }

        foreach($tipos as $t){

            if($claveCuerpo == ''){
                $condiciones = [$pregunta => $t];
            }else{
                $condiciones = ['claveCuerpo' => $claveCuerpo, $pregunta => $t];
            }
            
            $c_estado = $this->AdminModel->count('entrevistas_Relmo',$condiciones);
    
            //c-entrevistas es el 100 porciento, cuanto es el c_estado
    
            $porcentaje = ($c_estado * 100) / $c_entrevistas;
            $porcentaje = $this->removeExtraDecimals($porcentaje);
            $data[$t] = $porcentaje;
        }
        
        return $data;
    }

    public function getDatosInvestigacionReleg2023(){

        $condiciones = [];
        $countCodigos = $this->AdminModel->count('filtro_categorias', $condiciones);
        $countEntrevistas = $this->AdminModel->count('entrevistas_Relmo', $condiciones);

        $promedio_edad_general = $this->getPromedioReleg('pregunta1','');
        $porcentajes_estados_civiles_general = $this->getPorcentajeReleg('estado_civil','',$countEntrevistas);
        $porcentajes_grados_academicos_general = $this->getPorcentajeReleg('grados_academicos','',$countEntrevistas);
        $porcentajes_tipo_institucion_general = $this->getPorcentajeReleg('tipo_institucion','',$countEntrevistas);
        $promedio_personas_general = $this->getPromedioReleg('pregunta14','');
        $promedio_mujeres_general = $this->getPromedioReleg('pregunta15','');
        $promedio_familiares_general = $this->getPromedioReleg('pregunta16','');
        $porcentaje_modalidades_general = $this->getPorcentajeReleg('modalidades','',$countEntrevistas);
        $porcentaje_hijos_general = $this->getPorcentajeReleg('hijos','',$countEntrevistas);

        $dataMerge = [
            'numero_entrevistas' => $countEntrevistas,
            'numero_codigos' => $countCodigos,
            'promedio_edad_general' => $promedio_edad_general,
            'porcentajes_estados_civiles_general' => $porcentajes_estados_civiles_general,
            'porcentajes_grados_academicos_general' => $porcentajes_grados_academicos_general,
            'porcentajes_tipo_institucion_general' => $porcentajes_tipo_institucion_general,
            'promedio_personas_general' => $promedio_personas_general,
            'promedio_mujeres_general' => $promedio_mujeres_general,
            'promedio_familiares_general' => $promedio_familiares_general,
            'porcentaje_modalidades_general' => $porcentaje_modalidades_general,
            'porcentaje_hijos_general' => $porcentaje_hijos_general
        ];

        echo '<pre>';
        print_r($dataMerge);
        echo '</pre>';
        exit;
    }

    private function removeExtraDecimals($number) {
        /*
        este es para solo 1
        $parts = explode('.', $number);
        if (count($parts) == 2 && strlen($parts[1]) > 1) {
            $number = $parts[0] . '.' . substr($parts[1], 0, 1);
        }
        return $number;
        */
        $parts = explode('.', $number);
        if (count($parts) == 2) {
            $number = $parts[0] . '.' . (isset($parts[1][0]) ? $parts[1][0] : '0') . (isset($parts[1][1]) ? $parts[1][1] : '0');
        }
        return $number;
    }

    public function guardarCapitulo()
    {

        if (isset($_POST['accion'])) {
            $data = [
                'terminado' => $_POST['accion']
            ];

            $condiciones = [
                'claveCuerpo' => $_POST['claveCuerpo']
            ];

            if (!$this->AdminModel->generalUpdate('validacion', $data, $condiciones)) {
                $response = service('response');
                $response->setStatusCode(500);
                $response->setBody('Error actualizando el estado del proceso.');
                return $response;
            }

            return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'Listo')
                ->with('text', 'Capítulo guardado correctamente.');
        }

        return redirect()->back()
            ->with('icon', 'success')
            ->with('title', 'Listo')
            ->with('text', 'Cambios guardados correctamente');
    }

    public function getWordCapitulo()
    {

        $claveCuerpo = $_POST['claveCuerpo'];

        $data = $this->getDataCapituloImpresoReleg($claveCuerpo);

        $clavePorcentaje = array_search(max($data['porcentajes_tipo_institucion']), $data['porcentajes_tipo_institucion']);

        $tipo_institucion = $clavePorcentaje == 'público' ? 'pública' : 'privada';

        $n_autores = count($data['ordenes_autores']);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $phpWord->addTitleStyle(1, array('size' => 14, 'bold' => true, 'color' => '4472c4'), array('alignment' => 'left'));
        $phpWord->addTitleStyle(2, array('size' => 12, 'bold' => true, 'color' => '4472c4'), array('alignment' => 'left'));

        $sangria = array(
            'indentation' => [
                'firstLine' => 720
            ],
            'alignment' => 'both'
        );

        $fontStyle = [
            'name' => 'Arial',
            'size' => '12',
            'lineHeight' => 1.5
        ];

        $fontStyle2 = [
            'name' => 'Arial',
            'size' => '12',
            'lineHeight' => 1.5,
            'italic' => true
        ];

        $fontBold = [
            'name' => 'Arial',
            'size' => '12',
            'lineHeight' => 1.5,
            'bold' => true
        ];

        $fontFooter = [
            'name' => 'Arial',
            'size' => '10',
            'lineHeight' => 1,
        ];

        $pFooterStyle = [
            'alignment' => 'both'
        ];



        $section->addTitle("Capítulo ~no_capitulo~. Los obstáculos que tienen las estudiantes de la {$data['universidad']} que dirigen una micro o pequeña empresa en {$data['municipios']}.",1);

        $section->addText('');
        // Agregar la lista al documento
        $section->addList();

        // Agregar elementos a la lista sin especificar el tipo de viñeta
        foreach ($data['ordenes_autores'] as $elemento) {
            $section->addListItem($elemento,0,$fontStyle);
        }

        $section->addTitle("Resumen",2);
        $section->addText("La participación de la mujer en la esfera pública toma sin duda cada vez mayor relevancia, el ingreso a la educación superior y su participación en el ámbito laboral cada vez es más destacada, sin embargo, el camino sigue siendo difícil para la gran mayoría de ellas y lo es más aún cuando a la par llevan a cabo ambas actividades: son estudiantes universitarias y son directoras de una micro o pequeña empresa. Es por ello que la presente investigación ha sido desarrollada con el fin de conocer aquellos obstáculos a los que se enfrentan las mujeres universitarias al dirigir una micro o pequeña empresa. En este capítulo se presentan los resultados del estudio cualitativo llevado a cabo en {$data['universidad']}, en {$data['municipios']}. Se lleva a cabo el análisis de resultados bajo el contexto de los estudios de género, resultados pertinentes para la toma de decisiones que beneficie a la equidad entre hombres y mujeres.",$fontStyle,$sangria);

        $section->addTitle("Palabras clave",2);
        $section->addText('Mujeres directivas / Estudiantes Universitarias /Micro y Pequeñas empresas/ Obstáculos.',$fontStyle,$sangria);

        $section->addTitle("Introducción",2);
        $section->addText('Para las mujeres estudiar una carrera universitaria y dirigir una micro o pequeña empresa les proporciona un doble acceso a la esfera pública, una esfera que les abre oportunidades permitiendo tener una participación activa fuera de su espacio privado, ganando espacios que les permiten aportar en la economía del país y de la región en la que se desarrollan.',$fontStyle,$sangria);

        $textrun = $section->addTextRun($sangria);
        $textrun->addText('En México el 51.2% de la población total son mujeres (Instituto Nacional de Geografía y Estadística [INEGI], 2020) y de acuerdo con el Instituto Mexicano de la Competitividad (2022) ',$fontStyle);
        $textrun->addText('4 de cada 10 mujeres ',$fontBold);
        $textrun->addText('participan en la economía, mientras que ',$fontStyle);
        $textrun->addText('7 de cada 10 hombres lo hacen',$fontBold);
        $textrun->addText('. De estas mujeres que participan en las actividades económicas del país, se encuentran quienes dirigen a 1,472,000 micro y pequeñas empresas mexicanas',$fontStyle,$sangria);
        $footnote = $textrun->addFootnote();
        $footnote->addText('Cifra obtenida a partir del análisis de datos proporcionados por INEGI (2020) y Secretaría de Economía [SE] (citado en Forbes, 2023), al considerar el número total de unidades económicas y a partir de ello determinar la proporción de únicamente el porcentaje de Micro y Pequeñas Empresas, para posteriormente considerar el porcentaje que correspondería para las unidades económicas propiedad de mujeres.',$fontFooter,$pFooterStyle);
        $textrun->addText(' De acuerdo, al análisis de datos proporcionados por el INEGI el 31.14% de la Micro y Pequeña Empresa',$fontStyle);
        $footnote = $textrun->addFootnote();
        $footnote->addText('Porcentaje obtenido a partir del análisis de datos proporcionados por INEGI (2020) y SE (citado en Forbes, 2023), de acuerdo a la cifra obtenida en cuanto al número de micro y pequeñas empresas lidereadas por mujeres.',$fontFooter,$pFooterStyle);
        $textrun->addText(' es liderada por mujeres en México y por lo tanto de acuerdo con los resultados de la Encuesta Nacional de Ocupación y Empleo-Nueva Edición [ENOEN] (2023) estas mujeres dieron empleo a 2.9 millones de personas (cifra que contempla a las propietarias mismas).',$fontStyle);
        

        $section->addText('El porcentaje de mujeres que en México estudian nivel superior, es del 51% (INEGI, 2023), es importante señalar que a pesar que el porcentaje está por encima del total de hombres  universitarios, al momento de ingresar al campo laboral, la cifra de mujeres se reduce, ésta situación deriva de una serie de factores que impiden que las mujeres puedan desarrollarse en el campo laboral, y se reduce aún más la cifra de aquéllas que se encuentran estudiando una carrera universitaria y al mismo tiempo  dirigen una micro o pequeña empresa siendo dueñas o empleándose lo que conlleva enfrentar a estas estudiantes-directoras de mypes una serie de obstáculos que determina el contexto en el que se desenvuelven con sus actividades. Obstáculos que provienen tanto de su espacio privado, su espacio doméstico y del propio espacio público, lo que dificulta que se lleven de manera eficiente los resultados de su organización y/o su desempeño académico.',$fontStyle,$sangria);

        $section->addText("¿Cuáles son entonces estos obstáculos que impiden a estas universitarias de {$data['universidad']} de {$data['only_municipios']}, {$data['estado']} la correcta gestión de sus empresas?, de esta pregunta parte el análisis que en este capítulo se presenta y para el cual se llevó a cabo un estudio cualitativo aplicando un total de {$data['c_entrevistas']} a mujeres estudiantes universitarias que dirigen una micro o pequeña empresa, un estudio que es parte de una investigación con otras 30 universidades mexicanas en las cuales se aplicó a estudiantes universitarias la misma entrevista y se llevo a cabo el análisis de resultados bajo el mismo proceso, lo que permitirá tener una radiografía de este grupo importante de la sociedad, un grupo con una gran necesidad de visibilizar.",$fontStyle,$sangria);

        $section->addTitle("Revisión de la Literatura",2);
        $section->addText('Este capítulo ha sido desarrollado en el contexto de la investigación cualitativa “Los obstáculos que tienen las estudiantes universitarias que dirigen una micro o pequeña empresa”, por lo que la argumentación teórica para el análisis de resultados se retomó del apartado general de “Revisión de la Literatura” de esta misma obra.',$fontStyle,$sangria);

        

        $section->addTitle("Método",2);
        $section->addText('Esta investigación por la naturaleza del planteamiento de su objetivo fue abordada desde un enfoque cualitativo, toda vez que se busca conocer los obstáculos que tienes las estudiantes universitarias mexicanas en la dirección de su micro o pequeña empresa:',$fontStyle,$sangria);

        $section->addText('Del porqué de la selección del diseño de investigación cualitativa radica principalmente en las siguientes características:',$fontStyle,$sangria);

        $section->addText('1.- La investigación cualitativa permite al investigador estudiar a las personas en su contexto, en las situaciones en las que se encuentra (Álvarez-Gayou, 2007).',$fontStyle,$sangria);

        $section->addText('2.- En la perspectiva cualitativa existe una visión holística que “que evita que los sujetos y las acciones nos sean reducidos a variables, sino entendidas como partes de un todo” (Vega, 2004, p. 226).',$fontStyle,$sangria);

        $section->addText('3.- La perspectiva cualitativa y su carácter humanista, que permite al investigador un acercamiento íntimo al mundo de los sujetos investigados (Taylor y Bodgan, 1996).',$fontStyle,$sangria);

        $section->addText('En tanto, el marco referencial interpretativo utilizado para la presente investigación fue el análisis fenomenográfico (Álvarez-Gayou, 2007), dado que se busca conocer las formas en cómo experimentan y perciben las mujeres de este estudio el fenómeno de los obstáculos que se presentan en la gestión de sus organizaciones.',$fontStyle,$sangria);

        $section->addText('De igual forma, para la presente investigación se utilizaron elementos de lo que se conoce como diseño sistemático, en el cual se consideran ciertos pasos para el análisis de los datos obtenidos, a partir de los cuales se desarrolla una codificación y luego se efectúa la generación de categorizaciones (Hernández Sampieri et al., 2014, p. 473), estos elementos derivan a partir de lo que se conoce como teoría fundamentada donde la teoría va emergiendo de los hallazgos, fundamentada en los datos obtenidos durante la investigación, por lo tanto, su propósito general es descubrir una teoría (Álvarez-Gayou, 2007; Hernández Sampieri et al., 2014).',$fontStyle,$sangria);

        $section->addTitle("Contexto o ambiente inicial",2);
        $section->addText('Tal como se mencionó en el capítulo de Método General, en el mes de mayo del 2022, las autoras de este capítulo recibimos capacitación por parte del Comité Académico de la Red Latinoamericana de Estudios de Género, para la determinación de la muestra así, aplicación del instrumento, captura de información y análisis de resultados.',$fontStyle,$sangria);

        $section->addText("Esta investigación se llevó a cabo en la Institución {$tipo_institucion} {$data['universidad_completo']}",$fontStyle,$sangria);

        $section->addText("Se aplicaron un total de {$data['c_entrevistas']} entrevistas a alumnas de la institución, las cuales se llevaron de manera presencial dentro de los cubículos de las docentes y en otros casos se solicitó que fuera vía la plataforma zoom o alguna similar, la elección de esta modalidad dependía de la disponibilidad de la entrevistada. En ambas modalidades las universitarias se encontraban en lugares de desarrollo de sus actividades cotidianas. El promedio de duración de cada entrevista fue de 15 a 20 minutos en promedio. Al finalizar la aplicación de las entrevistas se llevó a cabo el llenado de la bitácora con todos aquellos aspectos pertinentes para la interpretación de información. Todas las entrevistas fueron grabadas y colocadas en el espacio virtual que desarrolló RELEG para captura de información. Posteriormente se hizo de manera manual o apoyadas en software especializado la transcripción de las entrevistas. De igual manera se creo un directorio con los datos para de las universitarias con el fin de mantener el contacto con ellas para cualquier aclaración durante el análisis de los datos.",$fontStyle,$sangria);

        $section->addText("El levantamiento de datos se ejecutó en los meses de mayo y junio del año 2022.",$fontStyle,$sangria);

        $section->addTitle("Muestra",2);
        $section->addText("Se contó con la participación de {$data['c_entrevistas']} estudiantes, universitarias, quienes fueron reclutadas por {$n_autores} docentes investigadoras (es) de la institución estudiada.",$fontStyle,$sangria);

        $section->addText("Las entrevistadas contactadas fueron alumnas, tutoradas, asesoras o conocidas de que contaban con las características solicitadas, no era necesario que dichas entrevistas hubiesen sido alumnas directas de las investigadoras.",$fontStyle,$sangria);

        $section->addText("La muestra para esta investigación es de tipo homogénea, donde las unidades que fueron seleccionadas “poseen un mismo perfil o características, o bien comparten datos similares” (Hernández Sampieri et al., 2014, p. 388), es por ello que los criterios de selección solicitados por RELEG fueron los siguientes:",$fontStyle,$sangria);

        $phpWord->addNumberingStyle(
            'multilevel',
            array(
                'type' => 'multilevel',
                'levels' => array(
                    array('format' => 'decimal', 'text' => '%1.-', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
                    array('format' => \PhpOffice\PhpWord\SimpleType\NumberFormat::LOWER_LETTER, 'text' => '%1%2)', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
                )
            )
        );
        $section->addListItem('Mujer estudiante universitaria o nivel académico equivalente.', 0, $fontStyle, 'multilevel');
        $section->addListItem('Que se encuentre estudiando cualquier grado académico.', 0, $fontStyle, 'multilevel');
        $section->addListItem('Que dirija o sea dueña de una micro o pequeña empresa, la cual cuente por lo menos con 1 año de operación.', 0, $fontStyle, 'multilevel');
        $section->addListItem('Las estudiantes universitarias pertenecen a la misma institución.', 0, $fontStyle, 'multilevel');
        $section->addListItem('Directora o dueña de una micro o pequeña empresa (Mype):', 0, $fontStyle, 'multilevel');
        $section->addListItem('Tal como se ha señalado se considera directora a la persona que toma la mayoría de las decisiones en la organización.', 1, $fontStyle, 'multilevel');
        $section->addListItem('Una Mype es una organización en la que se gestionan diversas clases de recursos, que tiene fines de lucro y en la que participan diversos actores como clientes, proveedores, que tenga al menos un empleado y 1 año de operación.', 1, $fontStyle, 'multilevel');

        $section->addText("Alternativamente en la muestra también se encuentran estudiantes universitarias que dirigen o son dueñas de una organización que cuenta con todas las características, salvo el requisito de tener empleados, es decir, puede podían no tener empleados, pero: Se excluyeron particularmente las estudiantes en un esquema de autoempleo que implicaba la pérdida de la autonomía en la gestión de la organización, tales como: la venta por catálogo o esquemas piramidales.",$fontStyle,$sangria);

        $section->addTitle("Características de las universitarias de {$data['universidad']}",2);
        $section->addText("Muestra: {$data['c_entrevistas']} universitarias directivas de micro o pequeñas empresas.",$fontStyle,$sangria);

        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50,
            'alignment' => 'center'
        );

        $firstRowStyle = array('bgColor' => 'D3D3D3');

        $tableBoldTitles = [
            'bold' => true
        ];
        
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        // Crear la tabla
        $table = $section->addTable('myTable');
        $table->addRow();
        $table->addCell(5000)->addText('Característica',$tableBoldTitles);
        $table->addCell(5000)->addText('Promedio',$tableBoldTitles);
        $table->addCell(5000)->addText('Característica',$tableBoldTitles);
        $table->addCell(5000)->addText('Porcentaje',$tableBoldTitles);

        // Agregar filas y celdas de datos
        $promedio_edad = $data['promedio_edad']; // Ajusta este valor según tus datos
        $porcentajes_estados_civiles = array(
            'Casada' => $data['porcentajes_estados_civiles']['Casada'], // Ajusta estos valores según tus datos
            'Soltera' => $data['porcentajes_estados_civiles']['Soltera'],
            'Divorciada' => $data['porcentajes_estados_civiles']['Divorciada'],
            'Concubinato' => $data['porcentajes_estados_civiles']['Concubinato']
        );
        $porcentaje_hijos = array('si' => 0.0, 'no' => 0.0); // Ajusta estos valores según tus datos
        $porcentajes_grados_academicos = array(
            'TSU' => $data['porcentajes_grados_academicos']['TSU'], // Ajusta estos valores según tus datos
            'Licenciatura' => $data['porcentajes_grados_academicos']['Licenciatura'],
            'Maestría' => $data['porcentajes_grados_academicos']['Maestría'],
            'Doctorado' => $data['porcentajes_grados_academicos']['Doctorado']
        );

        // Agregar filas y celdas con datos
        // Primera sección
        $table->addRow();
        $table->addCell(5000)->addText('Edad promedio',$tableBoldTitles);
        $table->addCell(5000)->addText($promedio_edad);
        $table->addCell(5000)->addText('Estado Civil',$tableBoldTitles);
        $table->addCell(5000)->addText('');

        // Filas de datos para la sección de Estado Civil
        foreach ($porcentajes_estados_civiles as $estadoCivil => $porcentaje) {
            $table->addRow();
            $table->addCell(5000)->addText('');
            $table->addCell(5000)->addText('');
            $table->addCell(5000)->addText($estadoCivil);
            $table->addCell(5000)->addText($porcentaje . '%');
        }

        // Segunda sección
        $table->addRow(null,$firstRowStyle);
        $table->addCell(5000,$firstRowStyle)->addText('Característica',$tableBoldTitles);
        $table->addCell(5000,$firstRowStyle)->addText('Porcentaje',$tableBoldTitles);
        $table->addCell(5000,$firstRowStyle)->addText('Característica',$tableBoldTitles);
        $table->addCell(5000,$firstRowStyle)->addText('Porcentaje',$tableBoldTitles);

        // Filas de datos para la sección de Grado Académico $porcentaje_hijos['si'] . '%'
        $table->addRow();
        $table->addCell(5000)->addText('Hijos (as)',$tableBoldTitles);
        $table->addCell(5000)->addText('');
        $table->addCell(5000)->addText('Grado académico',$tableBoldTitles);
        $table->addCell(5000)->addText('');

        $table->addRow();
        $table->addCell(5000)->addText('Tiene hijos (as)',$tableBoldTitles);
        $table->addCell(5000)->addText($data['porcentaje_hijos']['si'] . '%');
        $table->addCell(5000)->addText('TSU',$tableBoldTitles);
        $table->addCell(5000)->addText($porcentajes_grados_academicos['TSU'].'%');

        $table->addRow();
        $table->addCell(5000)->addText('No tiene hijos (as)',$tableBoldTitles);
        $table->addCell(5000)->addText($data['porcentaje_hijos']['no'] . '%');
        $table->addCell(5000)->addText('Licenciatura',$tableBoldTitles);
        $table->addCell(5000)->addText($porcentajes_grados_academicos['Licenciatura'].'%');

        $table->addRow();
        $table->addCell(5000)->addText('');
        $table->addCell(5000)->addText('');
        $table->addCell(5000)->addText('Maestría',$tableBoldTitles);
        $table->addCell(5000)->addText($porcentajes_grados_academicos['Maestría'].'%');

        $table->addRow();
        $table->addCell(5000)->addText('');
        $table->addCell(5000)->addText('');
        $table->addCell(5000)->addText('Doctorado',$tableBoldTitles);
        $table->addCell(5000)->addText($porcentajes_grados_academicos['Doctorado'].'%');

        $section->addText('');
        $section->addText("Conforme a los datos obtenidos a través del instrumento se identificaron características de las Mypes dirigidas o propiedad de las universitarias de {$data['universidad']}. La modalidad en la que trabajan estas empresas es: {$data['porcentaje_modalidades']['física']}% de manera física, {$data['porcentaje_modalidades']['virtual']}% de manera virtual y {$data['porcentaje_modalidades']['mixta']}% de manera mixta.",$fontStyle,$sangria);

        $section->addText("Las Mypes que dirigen estas estudiantes tienen en promedio {$data['promedio_personas']} personas que trabajan permanentemente en estas organizaciones, de las cuales en promedio {$data['promedio_mujeres']} son mujeres y {$data['promedio_familiares']} de ellos son familiares contratadas (os).",$fontStyle,$sangria);

        $section->addTitle("Instrumento y recolección de datos",2);
        $section->addText("La técnica que se utilizó para esta investigación cualitativa fue la entrevista y cuyo diseño de cuestionario fue proporcionado a todos los equipos participantes de esta investigación a nivel nacional por el Comité Académico de RELEG.",$fontStyle,$sangria);

        $section->addText("La entrevista está estructurada por 5 bloques. El primero que aborda los Datos Generales de la aplicación de la entrevista los cuales apoyarán para la confiabilidad de la información, así como la validez y seguimiento si es necesario. El segundo bloque que aborda “Las características sociodemográficas de la universitaria dueña o administradora de la Mype”, tercer bloque contempla los datos de la institución donde estudia la directiva y el cuarto sobre los datos de la Mype. La entrevista contempla 24 preguntas y fue diseñada para ser contestada por la directora de la empresa (persona que toma la mayor parte de las decisiones de la organización), y para ser aplicada por cualquiera de las y los integrantes del equipo de investigación, por lo que se pudo dividir el número total de entrevistas a aplicar. Cada entrevistadora o entrevistador conocía el protocolo de aplicación y llevó a cabo en totalidad el proceso de la entrevista hasta la captura, así como lo necesario para darle seguimiento a las siguientes fases del proceso de investigación.",$fontStyle,$sangria);

        $section->addText("El equipo de investigación también pudo apoyarse con algún equipo de alumnas para la realización de la entrevista, sin embargo, éstas debían tener una capacitación previa para tal aplicación.",$fontStyle,$sangria);

        $textrun = $section->addTextRun($sangria);
        $textrun->addText('Finalmente se capturó la información obtenida en las entrevistas en la Plataforma para Estudios Cualitativos Redesla ',$fontStyle);
        $textrun->addText('Comprende',$fontStyle2);
        $textrun->addText("™, en el apartado creado para el estudio de {$data['universidad']}",$fontStyle);

        $textrun = $section->addTextRun($sangria);
        $textrun->addText('La primera fase consistió en que se tuvieron que transcribir las entrevistas del dispositivo móvil o de lo guardado a partir de la plataforma de telecomunicación (si es que fue utilizado) en el que se grabaron las sesiones de la entrevista a la plataforma ',$fontStyle);
        $textrun->addText('Comprende',$fontStyle2);
        $textrun->addText('™ donde fueron archivadas, así como el apartado de la bitácora con todos los aspectos necesarios para el análisis de texto y contexto.',$fontStyle);

        $textrun = $section->addTextRun($sangria);
        $textrun->addText('Posteriormente se realizó un análisis para determinar las categorías encontradas, de acuerdo a la categorización que el Comité Académico de RELEG realizó con los resultados de la investigación nacional donde emergieron 21 categorías y las cuales se describen en el capítulo de “Resultados Generales de la Investigación” y cuya relación se nos envió con sus respectivas descripciones;  partir de ello se identificó en las  transcripciones de las entrevistas que realizamos, las frases o textos que argumentaban las informantes para darle significado de acuerdo al contexto. La plataforma ',$fontStyle);
        $textrun->addText('Comprende',$fontStyle2);
        $textrun->addText("™ permitió señalar y categorizar cada categoría emergida, cabe aclarar que el orden de estas categorías fue de acuerdo a cómo según iban emergiendo. A cada categoría, dentro de la plataforma se le iba asignando un color. Es así como cuando se iba analizando cada respuesta, si brotaba una nueva categoría que no viniera en la relación enviada por RELEG, entonces se definía y se enviaba a la coordinación general de la red con el objetivo de la autorización y que fuese integrada para los resultados a nivel nacional.  Teniendo las 5 categorías con mayor saturación para el caso de la {$data['universidad']}, se fueron presentando las categorías que definen los obstáculos hallados, cuyo análisis se detalla en el apartado de resultados de este capítulo.",$fontStyle);

        $section->addTitle("Resultados",2);
        $section->addText("En este apartado se presenta el análisis de resultados de la investigación cualitativa realizada a {$data['c_entrevistas']} estudiantes universitarias de {$data['universidad_completo']}.",$fontStyle,$sangria);

        $section->addText("Las unidades de análisis son los párrafos que conforman las respuestas a las preguntas eje de este trabajo. A partir del análisis a estas unidades surgieron los códigos en vivo que dieron origen a las categorías (Hernández Sampieri et al., 2014).",$fontStyle,$sangria);

        $section->addText("Las categorías que emergieron en esta institución de educación superior y que describen los obstáculos de las mujeres universitarias que dirigen una Mype son: {$data['str_categorias']}.",$fontStyle,$sangria);

        $section->addText("Para fines de este capítulo, se determinó analizar las 5 categorías más importantes que describen los obstáculos que presentan las mujeres universitarias de {$data['universidad']}, que dirigen o son dueñas de una micro o pequeña empresa. La importancia fue determinada a partir del orden y constancia con la que fueron emergiendo a lo largo del proceso de análisis de las entrevistas.",$fontStyle,$sangria);

        $section->addText("Las categorías y su análisis se presentan a continuación:",$fontStyle,$sangria);

        $styleCategoria = [
            'name' => 'Arial',
            'size' => '14',
            'lineHeight' => 1.5,
            'bold' => true
        ];

        $styleCodigoEnVivo = [
            'italic' => true,
            'name' => 'Arial',
            'size' => '10',
            'lineHeight' => 1,
        ];

        foreach ($data['categorias'] as $c) {
            $section->addText("{$c['nombre_categoria']}",$styleCategoria);
            $section->addText("Descripción de la categoría:",$fontStyle);
            $section->addText("{$c['descripcion_categoria']}",$fontStyle);

            foreach($c['codigos'] as $codigo){
                $section->addText('"'.$codigo['codigo_en_vivo'].'"',$styleCodigoEnVivo,['alignment' => 'center']);
                $section->addText("Entrevista {$codigo['id_entrevista']}. {$codigo['caracteristicas']}",$fontStyle,['alignment' => 'center']);
            }
            
            $section->addText("Análisis",$styleCategoria);
            $section->addText("{$c['analisis']}",$fontStyle);
        }

        $section->addTitle("Discusión",2);
        $section->addText("{$data['txt_discusion']}",$fontStyle,$sangria);

        $pReferencesStyle = [
            'indentation' => [
                'left' => 720
            ],
            'alignment' => 'both'
        ];

        $section->addTitle("Referencias",2);

        $section->addText("Ahl, H. (2006). Why Research on women entrepreneurs needs new directions. entrepeneurship: Theory y practice, 30(5), 595-621",$fontStyle,$sangria);
        $section->addText("Ahl, H. J. (2002). The making of the female entrepreneur: A discourse analysis of research texts on women's entrepreneurship. Jönköping, Suecia: Parajett AB",$fontStyle,$sangria);
        $section->addText("Aldrich, H. (1989). Women on the verge of a break-through: Networking among entrepreneurs in the United States and Italy. Entrepreneurship and Regional Development, 1(4), 339-356.",$fontStyle,$sangria);
        $section->addText("Alimo-Metcalfe, B. (1995). Investigation of female and male constructs of leadership and empowerment. Women in Management Review, 10(1), 3-8.",$fontStyle,$sangria);
        $section->addText("Amorós, C. (2008). Espacio público, espacio privado y definiciones ideológicas de “lo masculino” y ' lo femenino '. Feminismo y Filosofía, 6, 2-21.",$fontStyle,$sangria);
        $section->addText("Amorós, J. E., Guerra, M., Pizarro, O., y Poblete, C. (2006). Mujeres y actividad emprendedora en Chile. Santiago de Chile, Chile: Global Entrepreneurship Monitor",$fontStyle,$sangria);
        $section->addText("Anker, R. (1997). La segregación profesional entre hombres y mujeres. Repaso de las teorías. Revista Internacional Del Trabajo , 116(3), 343-370.",$fontStyle,$sangria);
        $section->addText("Aranda, J. J., Oreza, W., Solorzano, M., y Madero, J. (2015). Criterios de conceptualización de la empresa familiar. 3c Empresa, 4(3), 185-199. http://doi.org/DOI: http://dx.doi.org/10.17993/3cemp.2015.040323.185-199",$fontStyle,$sangria);
        $section->addText("Ayman, R., y Korabik, K. (2010). Leadership: Why gender and culture matter. Psychologist, 65(3), 157-170.",$fontStyle,$sangria);
        $section->addText("Azcárate, T. (2006). Propios. Nueva sociedad, 135, 78-91.",$fontStyle,$sangria);
        $section->addText("Barbieri, M. T. De. (2007). Los ámbitos de acción de las mujeres. Revista mexicana de sociología, 53(1), 203-224.",$fontStyle,$sangria);
        $section->addText("Baum, J. (2004). The Relationship of entrepreneurial traits, skill and motivation to subsequent venture growth. Journal of Apllied Psychology, 89(4).",$fontStyle,$sangria);
        $section->addText("Baum, J., Locke, E., y Smith, K. (2001). A multidimensional model of venture growth. Academy of management review, 44(2), 292-303.",$fontStyle,$sangria);
        $section->addText("Berg, N. . (1997). Gender, place and entrepreneurship. Entrepreneurship and regional development, 9(3).",$fontStyle,$sangria);
        $section->addText("Bermúdez-Carrillo, L. (2014). Características de las pymes de Guanacaste. Revista de las sedes regionales, XV, 1-17.",$fontStyle,$sangria);
        $section->addText("Bonder, G. (2003). Construyendo el protagonismo de las mujeres en la sociedad del conocimiento : Estrategias educativas y de formación de redes (mujer, ciencia y tecnología en América). Bilbao, España: UNESCO.",$fontStyle,$sangria);
        $section->addText("Booth, S., Darke, J., y Yeandle, S. (1998). La vida de las mujeres en las ciudades. La ciudad, un espacio para el cambio. Madrid, España: Narcea.",$fontStyle,$sangria);
        $section->addText("Brush, C. G., Carter, N., Gatewood, E., Greene, P., y Hart, M. (2004). Clearing the hurdles: Women building high-growth businesses. Upper Saddle River, EEUU: Pretince Hall.",$fontStyle,$sangria);
        $section->addText("Carter, N., y Allen, K. (1997). Size determinants of women-owned business: choice or barriers to resources? Entrepreneurship and regional development, 9, 211-222.",$fontStyle,$sangria);
        $section->addText("Cheung, F., y Halpern, D. (2010). Women at the top. Powerful leaders define success as work + family in a culture of gender. American psychologist, 65(3), 182-193.",$fontStyle,$sangria);
        $section->addText("Citro, S. (2009). Cuerpos significantes: travesías de una etnografía dialéctica. Reseñas, 17(1), 208-210.",$fontStyle,$sangria);
        $section->addText("Cornet, A., y Constatinidis, C. (2004). Entreprendre au féminin: Une réalité multiple et des attentes différenciées. Revue Francaise de Gestion, 30(1), 191-205.",$fontStyle,$sangria);
        $section->addText("Delic, S. (2006). Income determinants and factors affecting the choice of self-employed canadians to invest in RRSPS and health-related benefits: an empirical analysis and policy reflection. University of Canada",$fontStyle,$sangria);
        $section->addText("Delmar, F., y Shane, S. (2003). Does planning facilitate product development in new ventures? Strategic Management Journal, 24(12), 1165-1185.",$fontStyle,$sangria);
        $section->addText("Eaglye, A. (2005). Achieving relational authenticity in leadership: Does gender matter? The Leadership Quarterly, 16, 459-474.",$fontStyle,$sangria);
        $section->addText("Encuesta Nacional de Ocupación y Empleo (28 de agosto de 2023). Encuesta Nacional de Ocupación y Empleo (ENOE), población de 15 años y más de edad. INEGI.",$fontStyle,$sangria);
        $section->addText("Escapa, R., y Martínez, L. (2010). Estrategias de liderazgo para mujeres directivas (Departamen). Barcelona, España: Departament de Treball.",$fontStyle,$sangria);
        $section->addText("Espinar, E., y Ríos, J. (2002). Producción del espacio y desigualdades de género. Alicante, España: Espagrafic",$fontStyle,$sangria);
        $section->addText("Fagenson, E., y Marcus, E. (1991). Perceptions of sex-role stereotypic characteristics of entrepreneurs: women's evaluations. Entrepeneurship: Theory y Practice, Summer, 33-47.",$fontStyle,$sangria);
        $section->addText("Fernández, J. (1998). Género y sociedad. Madrid, España: Pirámide.",$fontStyle,$sangria);
        $section->addText("Flores, C. (2002). Potencial social de las mujeres microempresarias. Cuadernos de Trabajo Social, 15, 83-92.",$fontStyle,$sangria);
        $section->addText("Forbes (27 de junio de 2023). Mujeres encabezan 1.6 millones de mipymes en México; lanzan plan para que exporten. FORBES. https://www.forbes.com.mx/mujeres-encabezan-1-6-millones-de-mipymes-en-mexico-lanzan-plan-para-que-exporten/",$fontStyle,$sangria);
        $section->addText("Frutos, L., y Titos, S. (2011). Formación y trabajo autónomo desde la perspectiva de género. X Jornadas de la Asociación de la Economía de la Educación (pp. 309-320). Servicio de Publicaciones.",$fontStyle,$sangria);
        $section->addText("Gamber, W. (1998). A gendered enterprise: Placing nineteenth-century businesswomen in history. Business Hisotry Review, 72(2), 188-218.",$fontStyle,$sangria);
        $section->addText("García, B., Blanco, M., y Pacheco, E. (1998). Género y trabajo extradoméstico.",$fontStyle,$sangria);
        $section->addText("Gascón, M. I. (2012). Las Mujeres entre la intimidad doméstica y espacio público : libros de cuentas femeninos y ordenanzas municipales. Revista de Historia Moderna, 30, 283-300.",$fontStyle,$sangria);
        $section->addText("Grant, J. (1989). “Women as managers: What can they offer to organizations.” Organizational Dynamics, 56-63.",$fontStyle,$sangria);
        $section->addText("Guerrero, L., Gómez, E., y Armenteros, M. del C. (2014). Mujeres emprendedoras: Similitudes y diferencias entre las ciudades de torreón y saltillo, coahuila. Revista Internacional Administracion y Finanzas, 7(5), 77-91.",$fontStyle,$sangria);
        $section->addText("Harmon, S. (1997). Do gender differences necessitate separate career development theories and measures? Journal of Career Assessment, 5(4), 463-470.",$fontStyle,$sangria);
        $section->addText("Heras, I., Encinas, L., y Ochoa, I. (2006). Participación de la mujer en el ejercicio del poder y la toma de decisiones dentro de los actuales escenarios laborales. Vértice Universitario, 31, 1-9.",$fontStyle,$sangria);
        $section->addText("Hisrich, R., y Brush, C. G. (1986). The woman entrepreneur: Starting, financing and managing a successful new business. Lexington: Lexington Books.",$fontStyle,$sangria);
        $section->addText("Instituto Nacional de Estadística y Geografía (2022). Estadística a propósito del días Internacional de la Mujer (8 de marzo). https://www.inegi.org.mx/contenidos/saladeprensa/aproposito/2022/EAP_Mujer22.pdf",$fontStyle,$sangria);
        $section->addText("Instituto Nacional de Estadística y Geografía (2023). Matrícula escolar por entidad federativa según nivel educativo, ciclos escolares seleccionados de 2000/2001 a 2022/2023. INEGI.",$fontStyle,$sangria);
        $section->addText("Langowitz, N., y Minniti, M. (2007). The entrepreneurial propensity of women. Theory and Practice, 31(3), 341-364.",$fontStyle,$sangria);
        $section->addText("Lee, F. C., Newton, K., Sharma, B., Gadenne, D., Stevenson, L., Amboise, G. D., Pleitner, H. J. (2001). Innovation of SMEs in the knowledge-based economy quality management strategies and performance : An empirical investigation sources in location decisions problems, motivations. Journal of Small Business y Entrepreneurship, 15(4).",$fontStyle,$sangria);
        $section->addText("Lamas, M. (1995). La perspectiva de género. Revista de educación y cultura de La Sección 47 Del SNTE, (8), 14-20.",$fontStyle,$sangria);
        $section->addText("Mavin, S. (2001). Women's career in theory and practice: Time for change? Women in Management Review, 16(4), 183-192.",$fontStyle,$sangria);
        $section->addText("Medrano, M. C. (2012). Cazando a la cazadora : Cuestiones sobre la posición de la mujer toba en los ámbitos políticos y públicos, domésticos y privados. Bulletin de I'Institu Francais d' Etudes Andines, 41(1), 123-146.",$fontStyle,$sangria);
        $section->addText("Murillo, S. (1997). El mito de la vida privada: De la entrega al tiempo propio. Madrid, España: Siglo XXI de España Editores.",$fontStyle,$sangria);
        $section->addText("Ochman, M. (2006). En busca de una nueva sociedad. Los aportes de la teoría feminista a la reformulación del mundo moderno. Desafíos, (15), 371-387.",$fontStyle,$sangria);
        $section->addText("Organización Internacional del Trabajo. (2014). La mujer en la gestión empresarial.",$fontStyle,$sangria);
        $section->addText("Posada, R., Aguilar, O., y Peña, N. (2015). Análisis Sistémico de la micro y pequeña empresa. Ciudad de México: Pearson.",$fontStyle,$sangria);
        $section->addText("Powell, G., y Butterfield, D. (1994). Investigating the “glass ceiling” phenomenon: An empirical study of actual promotions to top management. Academy of Management Journal, 37, 68-86.",$fontStyle,$sangria);
        $section->addText("Riger, S. (2002). Debates epistemológicos. Voces del feminismo. American Psychologist, 47.",$fontStyle,$sangria);
        $section->addText("Rigg, C., y Sparrow, J. (1994). Gender, diversity and working styles. Women in Management Review, 18(3), 9-16.",$fontStyle,$sangria);
        $section->addText("Rosa, P., y Hamilton, D. (1994). The Impact of Gender on Small Business Management: Preliminary Findings of a British Study. Internacional Small Business Journal, 12, 25-32.",$fontStyle,$sangria);
        $section->addText("Robles, L. (2009). Balance y perspectivas del campo mexicano : In P. Sesia y V.",$fontStyle,$sangria);
        $section->addText("Shane, S. (2003). A general theory of enttrepreneurship- The Individual oportunity nexus. New York, Nueva York, EE.UU.: Edward Elgar Editores.",$fontStyle,$sangria);
        $section->addText("Shane, S., y Venkataraman, S. (2000). The promise of entrepreneurship as a field of research. Academy of Management Review, 25, 217-226.",$fontStyle,$sangria);
        $section->addText("Shelton, L. M. (2006). Female entrepreneurs, work-family conflict, and venture performance: New insights into the work-family interface. Journal of Small Business y Entrepreneurship, 44(2).",$fontStyle,$sangria);
        $section->addText("Suárez, M. (2008). Barreras en el desarrollo profesional femenino. Reop, 19(1), 61-72.",$fontStyle,$sangria);
        $section->addText("Swanson, J., y Tokan, D. (1991). A college students perceptions of barriers to career development. Journal of Vocational Behavior, 38, 92-106.",$fontStyle,$sangria);
        $section->addText("Taylor, S., y Bodgan, R. (1996). Introducción a los métodos cualitativos de investigación. Barcelona, España:Paidós Educador.",$fontStyle,$sangria);
        $section->addText("Varela, H. (2012). Iguales , pero no tanto. El acceso limitado de las mujeres a la esfera pública en México. CONfines de Relaciones Internacionales Y Ciencia Política, VIII, 39-67.",$fontStyle,$sangria);
        $section->addText("Vázquez, V., Cárcamo, N., y Martínez, N. (2012). Entre el cargo, la maternidad y la doble jornada. Presidentas municipales de Oaxaca. Perfiles Latinoamericanos, (39), 31-57.",$fontStyle,$sangria);
        $section->addText("Vega, A. (2004). La decisión de voto de las amas de casa mexicanas y las noticias electorales. Universidad Autónoma de Barcelona.",$fontStyle,$sangria);
        $section->addText("Vega, A. (2007). Por la visibilidad de las amas de casa: Rompiendo la invisibilidad del trabajo doméstico. Política y Cultura, (28), 173-193.",$fontStyle,$sangria);
        $section->addText("Vega, A. (2014). Igualdad de género, poder y comunicación: Las mujeres en la propiedad, dirección y puestos de toma de decisión. La Ventana, 40, 186-213.",$fontStyle,$sangria);
        $section->addText("Verheul, I., Van Stel, A., y Thurik, R. (2006). Explaining female and male entrepreneurship at the country level.",$fontStyle,$sangria);
        $section->addText("Watson, J. (2002). Comparing the performance of male and female-controlled businesses: Re- lating outputs to inputs. Entrepeneurship: Theory y Practice, Primavera, 91-100",$fontStyle,$sangria);
        $section->addText("Welsh, D., y Dragusin, M. (2006). Women-entrepreneurs: A dynamic force of small business sector. Amfiteatru Economic, 20, 60-68.",$fontStyle,$sangria);
        $section->addText("Wiklund, J., Davidsson, P., and Delmar, F. (2003). What Do They Think and Feel about Growth? An Expectancy-Value Approach to Small Business Managers Attitudes Toward Growth1. Entrepreneurship theory and practice, 27(3), 247-270.",$fontStyle,$sangria);
        $section->addText("Zabludovsky, G. (1998). Las mujeres empresarias en México (1st ed.). Ciudad de México: Universidad Nacional Autónoma de México.",$fontStyle,$sangria);











        // Agregar contenido HTML al documento
        //$html = str_replace('\n', '', $_POST['mensaje']);

        //\PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $filePath = ROOTPATH . 'public/docx/investigaciones/Releg/2022/' . $claveCuerpo . '.docx';

        if(file_exists($filePath)){
            unlink($filePath);
        }
        $objWriter->save($filePath);

        echo $claveCuerpo . '.docx';
    }

    public function capituloRelegDigital($claveCuerpo)
    {
        $condiciones = ["claveCuerpo" => $claveCuerpo, 'redCueCa' => 'Releg'];

        if (!$this->AdminModel->exist('cuerpos_academicos', $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Url no válida.');
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
        $orden_autores = $this->AdminModel->getAll('ordenes_autores', $condiciones);
        #orden_digital
        $key_sort3  = array_column($orden_autores, 'orden_digital');
        array_multisort($key_sort3, SORT_ASC, $orden_autores);

        if (empty($orden_autores)) {
            #tenemos que buscar el proyecto que registraron
            $condiciones = ['claveCuerpo' => $claveCuerpo];
            $validacion = $this->AdminModel->getAllOneRow('validacion', $condiciones);
            $nombre_proyecto = $validacion['nombre_proyecto'];

            $condiciones = ['cuerpoAcademico' => $claveCuerpo];
            $columnas = ['usuario'];
            $usuarios = $this->AdminModel->getAllColums($columnas, 'miembros', $condiciones);

            foreach ($usuarios as $key => $u) {
                if ($nombre_proyecto == 'Esquema A: Investigación Releg 2022') {
                    #solo digital
                    $data = [
                        'claveCuerpo' => $claveCuerpo,
                        'anio' => 2022,
                        'orden_digital' => intval($key + 1),
                        'usuario' => $u['usuario']
                    ];
                    $this->AdminModel->generalInsert('ordenes_autores', $data);
                } else if ($nombre_proyecto == 'Esquema B: Investigación Releg 2022') {
                    #digital e impreso
                    $data = [
                        'claveCuerpo' => $claveCuerpo,
                        'anio' => 2022,
                        'orden_digital' => intval($key + 1),
                        'orden_impreso' => intval($key + 1),
                        'usuario' => $u['usuario']
                    ];
                    $this->AdminModel->generalInsert('ordenes_autores', $data);
                }
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => '2022'];
            $orden_autores = $this->AdminModel->getAll('ordenes_autores', $condiciones);
        }

        foreach ($orden_autores as $key4 => $o) {
            $condiciones = ['usuario' => $o['usuario']];
            $usuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);
            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $data['ordenes_autores'][] = $nombre;
        }

        #tomamos las categorias
        $columnas = ['categoria'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $categorias = $this->AdminModel->getAllDistinc($columnas, "filtro_categorias", $condiciones);

        $str_categorias = '';
        foreach ($categorias as $key => $c) {
            $data['categorias'][$key]['id'] = $c['categoria'];
            $condiciones = ['id' => $c['categoria']];
            $info_categoria = $this->AdminModel->getAllOneRow('categorias', $condiciones);
            if (empty($info_categoria)) {
                echo 'No existe la categoria, ha existido un error y regresar';
                return;
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['categoria']];
            $cantidad = $this->AdminModel->count('filtro_categorias', $condiciones);


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
        $dimensiones = $this->AdminModel->getAll('dimensiones', $condiciones);



        $arr_grupos = [];

        foreach ($dimensiones as $key => $g) {
            #obtenemos las escalas (si aplica)
            $condiciones = ['id_dimension' => $g['id']];
            $escalas = $this->AdminModel->getAll('escalas', $condiciones);

            $arr_grupos[$key]['nombre'] = $g['nombre'];

            $c_categorias = 0;

            if (!empty($escalas)) {
                foreach ($escalas as $keyEscalas => $e) {
                    $arr_grupos[$key]['escalas'][$keyEscalas]['nombre'] = $e['nombre'];
                    $condiciones = ['dimension' => $g['id'], 'escala' => $e['id']];
                    $categorias = $this->AdminModel->getAll('categorias', $condiciones);

                    foreach ($categorias as $key2 => $c) {
                        $arr_grupos[$key]['escalas'][$keyEscalas]['categorias'][$key2]['nombre'] = $c['nombre'];

                        $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['id']];
                        $columnas = ['id_entrevista'];
                        $filtro = $this->AdminModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
                        $c_categorias++;
                        #$arr_grupos[$key]['categorias'][$key2]['entrevistas'] = $filtro;
                        #$arr_grupos[$key]['escalas'][$e['id']]['categorias'][$key2]['entrevistas'] = $filtro;
                    }
                }
                #$arr_grupos[$key]['c_categorias'] = $c_categorias;
                continue;
            }

            $condiciones = ['dimension' => $g['id']];
            $categorias = $this->AdminModel->getAll('categorias', $condiciones);

            #$arr_grupos[$key]['nombre'] = $g['nombre'];

            foreach ($categorias as $key2 => $c) {
                $arr_grupos[$key]['categorias'][$key2]['nombre'] = $c['nombre'];
                $condiciones = ['claveCuerpo' => $claveCuerpo, 'categoria' => $c['id']];
                $columnas = ['id_entrevista'];
                $filtro = $this->AdminModel->getAllColums($columnas, 'filtro_categorias', $condiciones);
                $c_categorias++;
                #$arr_grupos[$key]['categorias'][$key2]['entrevistas'] = $filtro;

            }
            #$arr_grupos[$key]['c_categorias'] = $c_categorias;
        }

        #nos traemos la discusion de ellos

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => 2022];
        $discusion = $this->AdminModel->getAllOneRow('capitulo_digital_releg', $condiciones);

        if (empty($discusion)) {
            http_response_code(404);
            echo 'Discusión no encontrada';
            exit;
        }
        $data['discusion'] = $discusion;
        $data['array'] = $arr_grupos;
        $data['claveCuerpo'] = $claveCuerpo;

        return view('admin/headers/index')
            . view('admin/capitulos/Releg/digital/2022/index', $data)
            . view('admin/footers/index');
    }

    public function validarCapDigitalReleg2022()
    {
        /*
        const valoresValidacion = {
            16: 'REENVIAR',
            17: 'RECHAZAR',
            18: 'ACEPTAR'
        }
        */

        $mensaje = $_POST['retroalimentacion'];

        $condiciones = ['cuerpoAcademico' => $_POST['claveCuerpo']];

        $columnas = ['usuario'];

        $miembros = $this->AdminModel->getAllColums($columnas, 'miembros', $condiciones);

        if (empty($miembros)) {
            http_response_code(501);
            echo 'No se ha encontrado miembros de este cuerpo académico.';
            exit;
        }

        $correos = [];
        $str_correos = '';

        foreach ($miembros as $m) {
            $condiciones = ['usuario' => $m['usuario']];
            $columnas = ['correo'];
            $usuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);

            if (!empty($usuario)) {
                array_push($correos, $usuario['correo']);
                $str_correos .= $usuario['correo'] . ', ';
            }
        }

        if ($_POST['validacion'] == 18) {
            #HAY QUE SUBIR EL ARCHIVO YA CORREGIDO
            if ($imgFile = $this->request->getFile('archivo')) {
                if ($imgFile->isValid() && !$imgFile->hasMoved()) {
                    $validated = $this->validate([
                        'archivo' => [
                            'uploaded[archivo]',
                            'max_size[archivo,5000]'
                        ]
                    ]);

                    if ($validated) {
                        $ruta = 'public/docx/investigaciones/Releg/2022/digital/';
                        $ruta_completo = ROOTPATH . $ruta . $_POST['claveCuerpo'] . '.docx';

                        if (file_exists($ruta_completo)) {
                            // Eliminar el archivo existente
                            unlink($ruta_completo);
                        }

                        $ruta_archivo = ROOTPATH . $ruta;

                        if (!$imgFile->move($ruta_archivo)) {
                            http_response_code(601);
                            echo 'No se ha podido subir el archivo. Contacte a sistemas.';
                            exit;
                        }
                    } else {
                        http_response_code(602);
                        echo 'El archivo no cumple con los estandares. Debe tener un peso menor a 5MB.';
                        exit;
                    }
                } else {
                    http_response_code(603);
                    echo 'Ha ocurrido un error con el archivo. Contacte a sistemas.';
                    exit;
                }
            } else {
                echo json_encode($_FILES);
                exit;
            }
        }

        #ACTUALIZAMOS EL STATUS

        $data = [
            'terminado' => $_POST['validacion']
        ];

        $condiciones = [
            'claveCuerpo' => $_POST['claveCuerpo']
        ];

        if (!$this->AdminModel->generalUpdate('validacion', $data, $condiciones)) {
            http_response_code(700);
            echo 'No se pudo actualizar la validación. Contacte a sistemas.';
            exit;
        }

        $fecha_actual = date("Y-m-d");
        $fecha_expiracion = date("Y-m-d", strtotime($fecha_actual . "+ 7 days"));
        $data = [
            'claveCuerpo' => $_POST['claveCuerpo'],
            'nivelAlerta' => 'danger',
            'mensaje' => $_POST['retroalimentacion'],
            'activo' => 1,
            'fechaExpiracion' => $fecha_expiracion
        ];

        if (!$this->AdminModel->generalInsert('mensajes_CA', $data)) {
            http_response_code(506);
            echo 'No se pudo insertar su mensaje en la plataforma.';
            exit;
        }

        #actualizamos la tabla para insertar la retroalimentacion

        $condiciones = ['claveCuerpo' => $_POST['claveCuerpo'], 'anio' => 2022];
        $dataUpdate = ['retroalimentacion' => $_POST['retroalimentacion']];

        if (!$this->AdminModel->generalUpdate('capitulo_digital_releg', $dataUpdate, $condiciones)) {
            http_response_code(507);
            echo 'No se pudo actualizar el registro. Contacte a sistemas.';
            exit;
        }


        $email = \Config\Services::email();
        $email->setFrom('atencion@redesla.la', 'Equipo RELEG');
        $email->setTo($correos);
        $email->setSubject('Estado de su capítulo digital RELEG');
        $email->setMessage($_POST['retroalimentacion']);
        if (!$email->send()) {
            http_response_code(502);
            echo 'No se han podido enviar el mensaje a los siguientes correos: ' . $str_correos;
            exit;
        }

        $response = [
            'title' => 'Éxito',
            'text' => 'Acciones realizadas correctamente'
        ];

        echo json_encode($response);
    }

    public function getWordDigital2022()
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        // Agregar contenido HTML al documento
        $html = str_replace('\n', '', $_POST['editorData']);

        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $filePath = ROOTPATH . 'public/docx/investigaciones/Releg/2022/digital/' . $_POST['claveCuerpo'] . '.docx';
        $objWriter->save($filePath);

        echo $_POST['claveCuerpo'] . '.docx';
    }

    #====================ADMIN DR. NURIA==========================

    #========================LIBROS===============================

    public function libros()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/libros/lista')
            . view('admin/footers/index');
    }

    public function getListadoLibros()
    {

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'nombre', 'isbn', 'editorial', 'anio', 'formato', 'red',
            'enlace'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM libros";
        $sql_data = "SELECT * FROM libros";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {
            $libro_exist = '';
            $dictamen_exist = '';
            $status = '';

            if ($a['carpeta'] == '') {
                $img = null;
                $status = 0;
            } else {

                //VAMOS A VERIFICAR LA EXISTENCIA DE CADA ARCHIVO IMPORTANTE

                $ruta_libro = WRITEPATH . 'uploads/libros/' . $a['red'] . '/' . $a['anio'] . '/' . $a['carpeta'] . '/libro.pdf';

                if (!file_exists($ruta_libro)) {
                    $libro_exist = null;
                }

                $ruta_dictamen = WRITEPATH . 'uploads/libros/' . $a['red'] . '/' . $a['anio'] . '/' . $a['carpeta'] . '/dictamen.pdf';
                if (!file_exists($ruta_dictamen)) {
                    $dictamen_exist = null;
                }


                $ruta_imagen = WRITEPATH . 'uploads/libros/' . $a['red'] . '/' . $a['anio'] . '/' . $a['carpeta'] . '/portada.png';

                if (!file_exists($ruta_imagen)) {
                    $img = null;
                } else {
                    $imgData = file_get_contents($ruta_imagen);
                    $base_64_cover = base64_encode($imgData);
                    $img = $base_64_cover;
                }
            }

            if(is_numeric($a['editorial'])){
                //La editorial esta insertada con valor correcto
                $change_editorial = false;
                $condiciones = ['id' => $a['editorial']];
                $info_editorial = $this->AdminModel->getAllOneRow('editoriales',$condiciones);

                if(empty($info_editorial)){
                    $a['editorial'] = 'Ha ocurrido un error. Contacte a sistemas.';
                }else{
                    $a['editorial'] = $info_editorial['nombre'];
                }
            }else{
                //editorial agregada de la anterior forma, hay que cambiar
                $change_editorial = true;
            }

            $array[$key] = [
                'id' => $a['id'],
                'nombre' => $a['nombre'],
                'isbn' => $a['isbn'],
                'editorial' => $a['editorial'],
                'anio' => $a['anio'],
                'formato' => $a['formato'],
                'red' => $a['red'],
                'enlace' => $a['enlace'],
                'carpeta' => $a['carpeta'],
                'img' => $img,
                'libro_exist' => $libro_exist,
                'dictamen_exist' => $dictamen_exist,
                'status' => $status,
                'change_editorial' => $change_editorial
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

    public function editarLibro($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $libro = $this->AdminModel->getAllOneRow('libros', $condiciones);

        if (empty($libro)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El libro al que quiere acceder no existe');
        }

        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);

        $editoriales = $this->AdminModel->getAll('editoriales',$condiciones);

        $data['libro'] = $libro;
        $data['redes'] = $redes;
        $data['editoriales'] = $editoriales;

        $img_cover_url = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/portada.png';

        if (file_exists($img_cover_url)) {
            $imgData = file_get_contents($img_cover_url);
            $base_64_cover = base64_encode($imgData);
            $data['base_64_cover'] = $base_64_cover;
        }

        return view('admin/headers/index')
            . view('admin/libros/editar', $data)
            . view('admin/footers/index');
    }

    public function agregarLibro()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);
        $editoriales = $this->AdminModel->getAll('editoriales',$condiciones);

        $data['redes'] = $redes;
        $data['editoriales'] = $editoriales;

        return view('admin/headers/index')
            . view('admin/libros/agregar', $data)
            . view('admin/footers/index');
    }

    public function insertLibro()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }


        $data = $_POST;
        echo '<pre>';
        print_r($data);
        print_r($_FILES);
        echo '</pre>';

        $ruta = WRITEPATH . 'uploads/libros/' . $_POST['red'];

        if (!file_exists($ruta)) {
            //NO EXISTE, CREAMOS
            mkdir($ruta);
            $ruta = $ruta . '/' . $_POST['anio'];
            mkdir($ruta);
        }

        $ruta = WRITEPATH . 'uploads/libros/' . $_POST['red'] . '/' . $_POST['anio'];

        if (!file_exists($ruta)) {
            mkdir($ruta);
        }

        //Ahora hay que crear la estructura de un libro

        $n_carpeta = $this->generarNombreAleatorio();

        $ruta_carpeta_libro = $ruta . $n_carpeta;

        while (file_exists($ruta_carpeta_libro)) {
            $n_carpeta = $this->generarNombreAleatorio();
        }

        $ruta_carpeta_libro = $ruta . '/' . $n_carpeta;

        mkdir($ruta_carpeta_libro);

        mkdir($ruta_carpeta_libro . '/capitulos');

        move_uploaded_file($_FILES['portada']['tmp_name'], $ruta_carpeta_libro . '/portada.png');

        move_uploaded_file($_FILES['documento']['tmp_name'], $ruta_carpeta_libro . '/libro.pdf');

        if($_FILES['dictamen']['size'] != 0){
            move_uploaded_file($_FILES['dictamen']['tmp_name'], $ruta_carpeta_libro . '/dictamen.pdf');
        }

        $data = $_POST;
        $data['updated_by'] = session('nombre');
        $data['carpeta'] = $n_carpeta;

        if ($this->AdminModel->generalInsert('libros', $data)) {
            return redirect()->to(base_url('/admin/libros/lista'))
                ->with('icon', 'success')
                ->with('title', 'Exito')
                ->with('text', 'Libro agregado correctamente');
        } else {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Contacte a sistemas');
        }
    }

    private function generarNombreAleatorio($longitud = 8)
    {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nombreAleatorio = '';

        for ($i = 0; $i < $longitud; $i++) {
            $indiceAleatorio = random_int(0, strlen($caracteres) - 1);
            $nombreAleatorio .= $caracteres[$indiceAleatorio];
        }

        return $nombreAleatorio;
    }

    public function eliminarLibro()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A TRAERNOS LA CARPETA DEL LIBRO

        $condiciones = ['id' => $_POST['id']];
        $columnas = ['carpeta','red','anio'];
        $libro = $this->AdminModel->getColumnsOneRow($columnas,'libros',$condiciones);

        if($libro['carpeta'] != ''){
            #existe una carpeta, verificamos la ruta
            $ruta = WRITEPATH . 'uploads/libros/' . $libro['red'].'/'.$libro['anio'].'/'.$libro['carpeta'];

            if(file_exists($ruta)){
                if (is_dir($ruta)) {
                    $this->eliminarContenidoCarpeta($ruta);
                    rmdir($ruta.'/capitulos');
                    rmdir($ruta);
                }
            }
        }

        $condiciones = ['id_libro' => $_POST['id']];

        if ($this->AdminModel->generalDelete('indices_libros', $condiciones)) {
            $condiciones = ['id' => $_POST['id']];
            if ($this->AdminModel->generalDelete('libros', $condiciones)) {
                return 'success';
            } else {
                return 'errorLibro';
            }
        } else {
            return 'errorCaps';
        }
    }

    private function eliminarContenidoCarpeta($carpeta) {
        $archivos = glob($carpeta . '/*');
        foreach ($archivos as $archivo) {
            if (is_dir($archivo)) {
                $this->eliminarContenidoCarpeta($archivo);
            } else {
                unlink($archivo);
            }
        }
    }

    public function updateLibro()
    {

        //VAMOS A TRAERNOS LA INFO DEL LIBRO

        $form = $_POST;

        $condiciones = ['id' => $_POST['id']];
        $libro = $this->AdminModel->getAllOneRow('libros', $condiciones);

        if (empty($libro['carpeta'])) {
            //NO EXISTE LA CARPETA, HAY QUE CREARLA DENTRO DE SU RUTA CORRESPONDIENTE
            $ruta = WRITEPATH . 'uploads/libros/' . $libro['red'];

            if (!file_exists($ruta)) {
                //NO EXISTE, CREAMOS
                mkdir($ruta);
                $ruta = $ruta . '/' . $libro['anio'];
                mkdir($ruta);
            }

            $ruta = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'];

            if (!file_exists($ruta)) {
                mkdir($ruta);
            }

            //Ahora hay que crear la estructura de un libro

            $n_carpeta = $this->generarNombreAleatorio();

            $ruta_carpeta_libro = $ruta . $n_carpeta;

            while (file_exists($ruta_carpeta_libro)) {
                $n_carpeta = $this->generarNombreAleatorio();
            }

            $form['carpeta'] = $n_carpeta;

            $ruta_carpeta_libro = $ruta . '/' . $n_carpeta;

            mkdir($ruta_carpeta_libro);

            mkdir($ruta_carpeta_libro . '/capitulos');

            if ($_FILES['portada']['error'] != 4) {
                move_uploaded_file($_FILES['portada']['tmp_name'], $ruta_carpeta_libro . '/portada.png');
            }

            if ($_FILES['documento']['error'] != 4) {
                move_uploaded_file($_FILES['documento']['tmp_name'], $ruta_carpeta_libro . '/libro.pdf');
            }

            if ($_FILES['dictamen']['error'] != 4) {
                move_uploaded_file($_FILES['dictamen']['tmp_name'], $ruta_carpeta_libro . '/dictamen.pdf');
            }
        } else {

            if ($_FILES['portada']['error'] != 4) {
                $archivoExistente = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/portada.png';
                $archivoNuevo = $_FILES['portada']['tmp_name'];
                if (!move_uploaded_file($archivoNuevo, $archivoExistente)) {
                    echo 'Error al actualizar la portada';
                    exit;
                }
            }

            if ($_FILES['documento']['error'] != 4) {
                $archivoExistente = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/libro.pdf';
                $archivoNuevo = $_FILES['documento']['tmp_name'];
                if (!move_uploaded_file($archivoNuevo, $archivoExistente)) {
                    echo 'Error al actualizar el libro';
                    exit;
                }
            }

            if ($_FILES['dictamen']['error'] != 4) {
                $archivoExistente = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/dictamen.pdf';
                $archivoNuevo = $_FILES['dictamen']['tmp_name'];
                if (!move_uploaded_file($archivoNuevo, $archivoExistente)) {
                    echo 'Error al actualizar el dictamen';
                    exit;
                }
            }
        }

        /*        
        echo '<pre>';
        print_r($libro);
        echo '</pre>';
        exit;
        */

        #TOMAMOS EL ID DEL ARRAY Y HACEMOS LA CONDICION

        $id = $form['id'];

        $condiciones = ['id' => $id];

        #LO ELIMINAMOS DEL ARRAY AL QUE VAMOS A HACER UPDATE

        unset($form['id']);

        if (!$this->AdminModel->generalUpdate('libros', $form, $condiciones)) {
            echo 'error';
        }

        return redirect()->back()
            ->with('icon', 'success')
            ->with('title', 'Listo')
            ->with('text', 'Archivos e información actualizada correctamente.');
    }

    public function indices($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];

        if (!$this->AdminModel->exist('libros', $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El libro al que intenta acceder no existe');
        }

        $data['id_libro'] = $id;

        return view('admin/headers/index')
            . view('admin/libros/indices',$data)
            . view('admin/footers/index');
    }

    public function getListadoIndices($id)
    {
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'capitulo', 'nombre_capitulo', 'paginas'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM indices_libros";
        $sql_data = "SELECT * FROM indices_libros";

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
                    $condicion .= ' WHERE (id_libro = ' . $id . ') AND ( ' . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }



        $sql_count = empty($condicion) ? $sql_count . ' WHERE id_libro = ' . $id : $sql_count . $condicion . ')';

        $sql_data =  !empty($condicion) ? $sql_data . $condicion . ')' : $sql_data . ' WHERE id_libro = ' . $id;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            $htmlEditar = '<a type="button" href="../editar/' . $a['id'] . '" class="btn btn-warning btn-icon-text btn-rounded">
            <i class="mdi mdi-lead-pencil"></i> Editar </a>';

            $htmlAutores = '<a class="btn btn-info btn-rounded autores" data-toggle="modal" data-target="#myModal" data-uno="' . $a['autor_1'] . '" data-dos="' . $a['autor_2'] . '" data-tres="' . $a['autor_3'] . '" data-cuatro="' . $a['autor_4'] . '">Ver autores</a>';

            $htmlEliminar = '
            <div class="dropdown">
              <button class="btn btn-danger dropdown-toggle btn-rounded  btn-icon-text" type="button" id="dropdownMenuSizeButton' . $a['id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-alert btn-icon-prepend"></i> Eliminar </button> </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton' . $a['id'] . '" style="">
                <h6 class="dropdown-header">Seleccione una opcion</h6>
                <button class="dropdown-item eliminarCap" data-id="' . $a['id'] . '">Eliminar índice</button>
              </div>
            </div>
            ';

            $array[$key] = [
                'id' => $a['id'],
                'nombre' => $a['nombre_capitulo'],
                'capitulo' => $a['capitulo'],
                'paginas' => $a['paginas'],
                'autores' => $htmlAutores,
                'editar' => $htmlEditar,
                'eliminar' => $htmlEliminar

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

    public function editarIndice($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];

        $capitulo = $this->AdminModel->getAllOneRow('indices_libros', $condiciones);

        if (empty($capitulo)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El capitulo al que intenta acceder no existe');
        }

        $condiciones = [];
        $usuarios = $this->AdminModel->getAll('usuarios', $condiciones);

        $data['capitulo'] = $capitulo;
        $data['usuarios'] = $usuarios;

        return view('admin/headers/index')
            . view('admin/libros/editarIndice', $data)
            . view('admin/footers/index');
    }

    public function updateIndice()
    {

        $condiciones = ['id' => $_POST['id']];
        $columnas = ['id_libro','capitulo'];
        $indice_libro = $this->AdminModel->getColumnsOneRow($columnas,'indices_libros',$condiciones);
        $id_libro = $indice_libro['id_libro'];
        
        $condiciones = ['id' => $id_libro];
        $columnas = ['carpeta','red','anio'];
        $libro = $this->AdminModel->getColumnsOneRow($columnas,'libros',$condiciones);

        $ruta = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'].'/'.$libro['carpeta'].'/capitulos/capitulo_'.$indice_libro['capitulo'].'.pdf';

        if ($_FILES['archivo']['error'] != 4) {

            if(file_exists($ruta)){
                move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta);
            }else{
                /* return redirect()->to(base_url('admin/libros/indices/lista/' . $id_libro))
                ->with('icon', 'warning')
                ->with('title', 'Carpeta no encontrada')
                ->with('text', 'Le pedimos que suba los siguientes archivos para crear la carpeta del libro: PDF del libro, portada y/o carta dictamen. Posterior a eso, podra subir y actualizar los capitulos de los libros.'); */
                $nombre_cap = 'capitulo_'.$indice_libro['capitulo'].'.pdf';

                $ruta_capitulo_nuevo = WRITEPATH . 'uploads/libros/' . $libro['red'].'/'.$libro['anio'].'/'.$libro['carpeta'].'/capitulos/';

                if(!move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta_capitulo_nuevo . $nombre_cap)){
                    http_response_code(301);
                    echo 'Ha ocurrido un eror al insertar el archivo. Contacte a sistemas.';
                    exit;
                }
            }
        }

        $data = [
            'capitulo' => $_POST['capitulo'],
            'nombre_capitulo' => $_POST['nombre'],
            'paginas' => $_POST['paginas'],
            'doi' => $_POST['doi']
        ];

        $autor1 = $_POST['autor_1'] == 'otro' ? $_POST['autor_1_otro'] : $_POST['autor_1'];
        $data['autor_1'] = $autor1;

        if (isset($_POST['autor_2'])) {
            $autor2 = $_POST['autor_2'] == 'otro' ? $_POST['autor_2_otro'] : $_POST['autor_2'];
            $data['autor_2'] = $autor2;
        }

        if (isset($_POST['autor_3'])) {
            $autor3 = $_POST['autor_3'] == 'otro' ? $_POST['autor_3_otro'] : $_POST['autor_3'];
            $data['autor_3'] = $autor3;
        }

        if (isset($_POST['autor_4'])) {
            $autor4 = $_POST['autor_4'] == 'otro' ? $_POST['autor_4_otro'] : $_POST['autor_4'];
            $data['autor_4'] = $autor4;
        }

        $condiciones = ['id' => $_POST['id']];

        if ($this->AdminModel->generalUpdate('indices_libros', $data, $condiciones) == 1) {
            return redirect()->to(base_url('admin/libros/indices/lista/' . $id_libro))
                ->with('icon', 'success')
                ->with('title', 'Exito')
                ->with('text', 'Información actualizada correctamente');
        } else {
            return redirect()->to(base_url('admin/libros/indices/lista/' . $id_libro))
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Contacte a sistemas');
        }
    }

    public function eliminarIndice()
    {

        //VAMOS A TRAERNOS INFORMACION DEL INDICE PARA TRAERNOS DEL LIBRO

        $condiciones = ['id' => $_POST['id']];

        $columnas = ['id_libro','capitulo'];

        $indice_libro = $this->AdminModel->getColumnsOneRow($columnas,'indices_libros',$condiciones);

        //AHORA NOS TRAEMOS LA CARPETA DEL LIBRO

        $condiciones = ['id' => $indice_libro['id_libro']];
        $columnas = ['carpeta','red','anio'];
        $libro = $this->AdminModel->getColumnsOneRow($columnas,'libros',$condiciones);

        if($libro['carpeta'] != ''){
            //EL LIBRO  TIENE CARPETA, POR LO QUE PODEMOS ELIMINAR EL ARCHIVO
            $ruta = WRITEPATH . 'uploads/libros/' . $libro['red'].'/'.$libro['anio'].'/'.$libro['carpeta'].'/capitulos/capitulo_'.$indice_libro['capitulo'].'.pdf';

            if(file_exists($ruta)){
                unlink($ruta);
            }
        }

        $condiciones = ['id' => $_POST['id']];

        if ($this->AdminModel->generalDelete('indices_libros', $condiciones)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function agregarIndice(){

        #VAMOS A TRAERNOS INFORMACION DEL LIBRO, MAS CONCRETO LA CARPETA, RED Y AñO DEL LIBRO
        $id_libro = $_POST['id_libro'];

        $columnas = ['carpeta','red','anio'];
        $condiciones = ['id' => $id_libro];

        $libro = $this->AdminModel->getColumnsOneRow($columnas,'libros',$condiciones);

        if(empty($libro)){
            http_response_code(404);
            echo 'Este libro no existe.';
            exit;
        }

        if($libro['carpeta'] == ''){
            http_response_code(404);
            echo 'Este libro no tiene carpeta creada en el sistema. Favor de agregar los archivos correspondientes en el libro para crear la carpeta.';
            exit;
        }

        #Hay que verificar que el capitulo con el mismo numero ya existe, si existe, hay que devolverlo

        $condiciones = [
            'capitulo' => $_POST['num_capitulo'],
            'id_libro' => $id_libro
        ];

        if($this->AdminModel->exist('indices_libros',$condiciones)){
            //TRUE, si existe, lo devolvemos
            http_response_code(300);
            echo 'El número de capítulo que se ha ingresado ya existe. Favor de comprobar la numeración o si desea editar este capítulo, vaya a la sección de editar.';
            exit;
        }

        //El numero de capitulo no existe, entonces hay que insertarlo en las carpetas

        if($_FILES['archivo']['size'] != 0){
            $nombre_cap = 'capitulo_'.$_POST['num_capitulo'].'.pdf';

            $ruta = WRITEPATH . 'uploads/libros/' . $libro['red'].'/'.$libro['anio'].'/'.$libro['carpeta'].'/capitulos/';
    
            if(!move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta . $nombre_cap)){
                http_response_code(301);
                echo 'Ha ocurrido un eror al insertar el archivo. Contacte a sistemas.';
                exit;
            }
        }

        

        //ahora hay que insertar la informacion a la bd
        $dataIndice = [
            'id_libro' => $id_libro,
            'capitulo' => $_POST['num_capitulo'],
            'nombre_capitulo' => $_POST['nombre_capitulo'],
            'paginas' => $_POST['paginas'],
            'doi' => $_POST['doi']
        ];

        if(!$this->AdminModel->generalInsert('indices_libros',$dataIndice)){
            http_response_code(302);
            echo 'No se ha podido insertar este capítulo en la base de datos. Contacte a sistemas.';
            exit;
        }

        //YA SE INSERTO TODO

        http_response_code(200);
        exit;
    }

    public function carta()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A DAR LA INFO DE LOS INPUTS PARA CREAR LA CARTA
        #OBTENEMOS LOS CUERPOS ACADEMICOS
        $condiciones = [];
        $columnas = ['claveCuerpo'];
        $cuerpos_academicos = $this->AdminModel->getAllColums($columnas, 'cuerpos_academicos', $condiciones);
        #SE NECESITA OBTENER LA INFORMACION DE LOS LIBROS
        $columnas = ['nombre', 'id'];
        $libros = $this->AdminModel->getAllColums($columnas, 'libros', $condiciones);
        $condiciones = ['activo' => 1];
        $investigaciones = $this->AdminModel->getAll('investigaciones', $condiciones);
        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);

        $data['claves'] = $cuerpos_academicos;
        $data['libros'] = $libros;
        $data['investigaciones'] = $investigaciones;
        $data['redes'] = $redes;

        return view('admin/headers/index')
            . view('admin/libros/carta', $data)
            . view('admin/footers/index');
    }

    public function getCapitulos()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $libros = $_POST['libros'];

        $htmlCapitulos = '';

        foreach ($libros as $l) {
            $condiciones = ['id_libro' => $l];
            $capitulos = $this->AdminModel->getAll('indices_libros', $condiciones);
            #VAMOS A RECORRER LOS CAPITULOS Y DARLES FORMATO DE OPTION
            foreach ($capitulos as $key => $capitulo) {
                $htmlCapitulos .= '
                <option value="' . $capitulo['id'] . '">' . $capitulo['nombre_capitulo'] . ' Paginas: ' . $capitulo['paginas'] . '</option>
                ';
            }
        }

        echo $htmlCapitulos;
    }

    public function getPDFCarta()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A OBTENER LOS DATOS PARA GENERAR LA CARTA
        $condiciones = ['claveCuerpo' => $_POST['claveCuerpo']];
        $columnas = ['nombre', 'redCueCa', 'nombre_prodep'];
        $universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
        if ($_POST['claveCuerpo'] == 'otra') {
            $nombre_red = $_POST['red'];
            $universidad_vf = $_POST['nombre_uni'];
            $claveCuerpo = $_POST['claveCuerpoOtra'];
            $prodep = !empty($_POST['nombre_prodep']) ? 'cuerpo académico ' . $universidad_vf : 'grupo de investigación';
        } else {
            if (!empty($universidad['nombre_prodep'])) {
                $prodep = 'cuerpo académico ' . $universidad['nombre_prodep'];
            } else {
                $prodep = 'grupo de investigación';
            }
            $universidad_vf = $universidad['nombre'];
            $claveCuerpo = $_POST['claveCuerpo'];
            $nombre_red = $universidad['redCueCa'];
        }
        $condiciones = ['nombre_red' => $nombre_red];
        $red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $condiciones = ['id' => $_POST['investigacion']];
        $investigacion = $this->AdminModel->getAllOneRow('investigaciones', $condiciones);

        #obtenemos la informacion del libro
        $previo_editorial = 'y';

        foreach ($_POST['libros'] as $l) {
            $condiciones = ['id' => $l];
            $libro = $this->AdminModel->getAllOneRow('libros', $condiciones);

            $condiciones = ['id' => $libro['editorial']];
            $columnas = ['abreviacion','nombre'];
            $editorial = $this->AdminModel->getColumnsOneRow($columnas,'editoriales',$condiciones);

            switch ($editorial['abreviacion']) {
                case 'McGraw-Hill':
                    $membretada = $libro['red'] . '_McGraw';
                    break;
                case 'iQuatro Editores':
                    $membretada = $libro['red'] . '_IQuatro';
                    $previo_editorial = 'e';
                    break;
                case 'Fontamara':
                    $membretada = $libro['red'] . '_Fontamara';
                    break;
                case 'Peter Lang':
                    $membretada = $libro['red'] . '_Peter';
                    break;
                default:
                    http_response_code(600);
                    exit;
                    break;
            }

            $_SESSION['red'] = $membretada;

            #print_r($universidad).'<br>';
            #print_r($libro).'<br>';

            #VAMOS A OBTENER LOS MIEMBROS

            $condiciones = [
                'id_libro' => $l,
                'id' => $_POST['capitulos'][0]
            ];
            $columnas = ['autor_1', 'autor_2', 'autor_3', 'autor_4'];
            $miembros = $this->AdminModel->getColumnsOneRow($columnas, 'indices_libros', $condiciones);

            $pdf = new CartasTCPDF();

            $pdf->SetPrintHeader(true);



            $pdf->SetPrintFooter(false);

            $pdf->SetAutoPageBreak(true, 35);

            $pdf->SetAuthor('REDESLA');

            $pdf->SetCreator('REDESLA');

            $pdf->SetTitle("Carta de dictamen");

            $pdf->AddPage();

            /*
            function agregarHoja($pdf,$universidad,$fecha) {
    
                $pdf->AddPage('P', 'A4', 0);
    
                //$pdf->Image(base_url("resources/img/membretadas/" . $universidad['redCueCa'] . ".jpg"), 0, 0, 215, 300, '', '', '', false, 300, '', false, false, 0);
    
                $pdf->Ln(45);
    
                $pdf->SetFont('Times', '', 12);
    
                $pdf->Cell( 0, 10, $fecha, 1, 0, 'R' ); 
            }
            */

            #agregarHoja($pdf,$universidad,$fecha);



            $pdf->SetFont('Times', 'B', 11);

            $fecha = 'Querétaro, Querétaro, a ' . $investigacion['fecha_investigacion']; //de %B del %Y

            $pdf->Cell(0, 5, $fecha, 0, 0, 'R');

            $pdf->Ln();

            if ($miembros['autor_1'] != '') {
                $pdf->Cell(0, 5, $miembros['autor_1'], 0, 0, 'L');
                $pdf->Ln(5);
            }
            if ($miembros['autor_2'] != '') {
                $pdf->Cell(0, 5, $miembros['autor_2'], 0, 0, 'L');
                $pdf->Ln(5);
            }
            if ($miembros['autor_3'] != '') {
                $pdf->Cell(0, 5, $miembros['autor_3'], 0, 0, 'L');
                $pdf->Ln(5);
            }
            if ($miembros['autor_4'] != '') {
                $pdf->Cell(0, 5, $miembros['autor_4'], 0, 0, 'L');
                $pdf->Ln(5);
            }
            /*
            foreach($miembros as $m){
                $nombre = trim($m['nombre']).' '.trim($m['apaterno']).' '.trim($m['amaterno']);
                $pdf->Cell( 0, 5, $nombre, 0, 0, 'L' );
                $pdf->Ln(5);
            }
            */

            if ($miembros['autor_2'] == '') {
                $autores = $miembros['autor_1'];
            }
            if ($miembros['autor_3'] == '') {
                $autores = $miembros['autor_1'] . ' y ' . $miembros['autor_2'];
            }
            if ($miembros['autor_4'] == '') {
                $autores = $miembros['autor_1'] . ', ' . $miembros['autor_2'] . ' y ' . $miembros['autor_3'];
            }
            if ($miembros['autor_4'] != '') {
                $autores = $miembros['autor_1'] . ', ' . $miembros['autor_2'] . ', ' . $miembros['autor_3'] . ' y ' . $miembros['autor_4'];
            }

            $condiciones = ['id' => $libro['editorial']];
            $editorial_info = $this->AdminModel->getAllOneRow('editoriales',$condiciones);
            if(empty($editorial_info)){
                http_response_code(700);
                exit;
            }
            $nombre_editorial = $editorial_info['nombre'];



            /*
            switch(count($miembros)){
                case 1:
                    $autores = trim($miembros[0]['nombre']).' '.trim($miembros[0]['apaterno']).' '.trim($miembros[0]['amaterno']);
                    break;
                    case 2:
                        $autores = trim($miembros[0]['nombre']).' '.trim($miembros[0]['apaterno']).' '.trim($miembros[0]['amaterno']).' y '.trim($miembros[1]['nombre']).' '.trim($miembros[1]['apaterno']).' '.trim($miembros[1]['amaterno']);
                        break;
                        case 3:
                            $autores = trim($miembros[0]['nombre']).' '.trim($miembros[0]['apaterno']).' '.trim($miembros[0]['amaterno']).', '.trim($miembros[1]['nombre']).' '.trim($miembros[1]['apaterno']).' '.trim($miembros[1]['amaterno']).' y '.trim($miembros[2]['nombre']).' '.trim($miembros[2]['apaterno']).' '.trim($miembros[2]['amaterno']);
                            break;
                            case 4:
                                $autores = trim($miembros[0]['nombre']).' '.trim($miembros[0]['apaterno']).' '.trim($miembros[0]['amaterno']).', '.trim($miembros[1]['nombre']).' '.trim($miembros[1]['apaterno']).' '.trim($miembros[1]['amaterno']).', '.trim($miembros[2]['nombre']).' '.trim($miembros[2]['apaterno']).' '.trim($miembros[2]['amaterno']).' y '.trim($miembros[3]['nombre']).' '.trim($miembros[3]['apaterno']).' '.trim($miembros[3]['amaterno']);;
                                break;
    
            }
            */



            $pdf->SetFont('Times', '', 11);

            $pdf->Ln(3);

            $pdf->Cell(0, 5, $universidad_vf, 0, 0, 'L');

            $pdf->Ln(5);

            $pdf->Cell(0, 5, 'Miembros del grupo de investigación ' . $claveCuerpo, 0, 0, 'L');

            $pdf->Ln(5);

            $pdf->Cell(0, 5, 'PRESENTES', 0, 0, 'L');

            $pdf->Ln(8);
          
            $html = 'Estimados investigadores del <b>' . $prodep . '</b> reciban un cordial saludo por parte de la <b>' . $red['significado'] . ' (' . strtoupper($red['nombre_red']) . ') y ' . $nombre_editorial . '.</b>';

            $pdf->writeHTML($html, true, false, true, false, 'J');

            $dictamen = count($_POST['capitulos']) >= 1 ? 'Para nosotros un placer informarles sobre el dictamen de aceptación del:' : 'Para nosotros un placer informarles sobre los dictamenes de aceptación de los:';

            $dictamen2 = count($_POST['capitulos']) >= 1 ? 'Cada una de las obras es resultado de trabajos de investigación arbitrada por pares académicos, bajo el sistema de doble ciego' : 'La obra es resultado de trabajos de investigación arbitrada por pares académicos, bajo el sistema de doble ciego';

            $html = 'Sirva la presente para <b>constatar su participación</b> y agradecer el trabajo realizado para efectuar todos los <b>procesos de la 
            investigación anual ' . $investigacion['anio'] . '</b> tales como: asistencia a capacitación para el investigador, capacitación 
            de sus estudiantes-encuestadores, aplicación-levantamiento, monitoreo, captura y validación de instrumentos, 
            redacciones de capítulo(s) correspondiente a las publicaciones de las obras colectivas coordinadas por la red con tema anual 
            <b>“' . $investigacion['nombre'] . '”</b>, cabe destacar que estas obras fueron sujetas a un proceso de dictaminación se adjuntan los anexos.</b><br>';

            $pdf->Ln(3);

            $html .= $dictamen;

            $pdf->writeHTML($html, true, false, true, false, 'J');

            $html = '';

            $pdf->SetMargins(20, 40, 10);

            foreach ($_POST['capitulos'] as $c) {
                $condiciones = ['id' => $c];
                $indice_libro = $this->AdminModel->getAllOneRow('indices_libros', $condiciones);
                $condiciones = ['id' => $indice_libro['id_libro']];
                $libro = $this->AdminModel->getAllOneRow('libros', $condiciones);
                $html .= '<i>Capítulo ' . $indice_libro['capitulo'] . '</i>. "<b>' . $indice_libro['nombre_capitulo'] . '</b>", pp. ' . $indice_libro['paginas'] . ' 
                elaborado por <b>' . $autores . '</b>, publicado en el libro titulado "<b>' . $libro['nombre'] . '</b>", con ISBN <b>' . $libro['isbn'] . '</b>, la obra fue una edición elaborada por la editorial <b>' . $nombre_editorial . '</b>, dicha obra la podrá consultar en: <a href="' . $libro['enlace'] . '">' . $libro['enlace'] . '</a><br>';
            }

            $pdf->Ln(2);

            $pdf->writeHTML($html, true, false, true, false, 'J');

            $pdf->SetMargins(10, 40, 0);

            #OCUPAMOS EL AREA

            switch ($nombre_red) {
                case 'Relayn':
                    $area = 'económico-administrativo';
                    break;
                case 'Relep':
                    $area = 'educación y pedagogía';
                    break;
                case 'Relen':
                    $area = 'educación normal';
                    break;
                default:
                    return redirect()->back()
                        ->with('icon', 'warning')
                        ->with('title', 'Lo sentimos')
                        ->with('text', 'No existe un área registrada de la red solicitada. Contacte a sistemas.');
                    break;
            }

            $html = '<br>' . $dictamen2 . '. Se privilegia dicho dictamen con el aval de distintos investigadores adscritos a diversas universidades públicas y privadas, con líneas de investigación en el área ' . $area . ', dicho labor se realiza con el fin de generar producciones científicas de calidad, esto mismo se hace constar en la hoja legal.<br><br>Reconocemos el 
            esfuerzo a nuestros autores, porque además de estrechar y consolidar lazos de colaboración de diversas disciplinas e instituciones, construyen una comunidad científica comprometiéndose 
            con el desarrollo de la ciencia e investigación en Latinoamérica.<br>';

            $pdf->writeHTML($html, true, false, false, false, 'J');

            $pdf->SetFont('Times', 'B', 11);

            $pdf->writeHTML('Atentamente', true, false, true, false, 'C');

            $pdf->Ln(3);

            $pdf->Image(base_url('resources/img/firmas/PaulaMejia.jpg'), 90, '', 40, 20, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $pdf->Ln(20);

            $pdf->SetFont('Times', 'B', 10);

            $pdf->writeHTML('Ing. Paula Mejia Avila<br>Gerente administrativo', true, false, true, false, 'C');

            $this->response->setHeader('Content-Type', 'application/pdf');

            $pdf->Output("Carta.pdf", "I");
        }
    }

    #Editoriaes
    public function editoriales()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/libros/editoriales/lista')
            . view('admin/footers/index');
    }

    public function getListadoEditorial()
    {

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'nombre', 'abreviacion'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM editoriales";
        $sql_data = "SELECT * FROM editoriales";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            $htmlEditar = '<a type="button" href="editar/' . $a['id'] . '" class="btn btn-warning btn-icon-text btn-rounded">
            <i class="mdi mdi-lead-pencil"></i> Editar </a>';


            $htmlEliminar = '
            <div class="dropdown">
              <button class="btn btn-danger dropdown-toggle btn-rounded  btn-icon-text" type="button" id="dropdownMenuSizeButton' . $a['id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-alert btn-icon-prepend"></i> Eliminar </button> </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton' . $a['id'] . '" style="">
                <h6 class="dropdown-header">Seleccione una opcion</h6>
                <button class="dropdown-item eliminarCasa" data-id="' . $a['id'] . '">Eliminar Editorial</button>
              </div>
            </div>
            ';

            $array[$key] = [
                'id' => $a['id'],
                'nombre' => $a['nombre'],
                'abreviacion' => $a['abreviacion'],
                'editar' => $htmlEditar,
                'eliminar' => $htmlEliminar
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

    public function agregarEditorial()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/libros/editoriales/agregar')
            . view('admin/footers/index');
    }

    public function insertEditorial()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        // Obtener los datos del formulario
        $data = $this->request->getPost();
        $data['updated_by'] = session('nombre');
        // Insertar los datos en la base de datos
        if ($this->AdminModel->generalInsert('editoriales', $data)) {
            return redirect()->to(base_url('/admin/libros/editoriales/lista'))
                ->with('icon', 'success')
                ->with('title', 'Exito')
                ->with('text', 'Casa editorial agregada correctamente');
        } else {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Contacte a sistemas');
        }
    }

    public function editarEditorial($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $casa = $this->AdminModel->getAllOneRow('editoriales', $condiciones);

        if (empty($casa)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'La casa editorial a la que quiere acceder no existe');
        }

        $condiciones = [];
    
        $data['casa'] = $casa;

        return view('admin/headers/index')
            . view('admin/libros/editoriales/editar', $data)
            . view('admin/footers/index');
    }

    public function updateEditorial(){

        $form = $_POST;

        #PASARA POR UN TERCER FILTRO PARA EVITAR DATOS VACIOS, ESTE LO MANDARA AL INICIO GENERAL
        #NO CREO QUE PASE HASTA ESTE PUNTO PERO POR SI LAS MOSCAS

        foreach ($form as $f) {
            if (trim($f) == "") {
                return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Opsss')
                    ->with('text', 'Complete los datos correctamente');
            }
        }

        #TOMAMOS EL ID DEL ARRAY Y HACEMOS LA CONDICION

        $id = $form['id'];

        $condiciones = ['id' => $id];

        #LO ELIMINAMOS DEL ARRAY AL QUE VAMOS A HACER UPDATE

        unset($form['id']);

        $form['updated_by'] = session('nombre');

        #HACEMOS EL UPDATE

        if ($this->AdminModel->generalUpdate('editoriales', $form, $condiciones)) {
            #EL UPDATE FUNCIONO, HACEMOS REDIRECCIONES
            return redirect()->to(base_url('/admin/libros/editoriales/lista'))
                ->with('icon', 'success')
                ->with('title', 'Exito')
                ->with('text', 'Casa editorial editada correctamente');
            
        } else {

            #OCURRIO UN ERROR AL HACER UPDATE, PA ATRAS

            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intentelo mas tarde. Codigo de error: 101');
        }
    }

    public function eliminarEditorial(){
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }


        $condiciones = ['id' => $_POST['id']];
     
        if ($this->AdminModel->generalDelete('editoriales', $condiciones)) {
            return 'success';
        } else {
            return 'errorCasa';
        }
    }

    #========================LIBROS===============================

    #====================CONSTANCIA===========================

    public function vistaConstancias()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #ESTRAEMOS TODOS LOS USUARIOS
        $condiciones = [];
        $columnas = ['nombre', 'ap_paterno', 'ap_materno', 'usuario'];
        $usuarios = $this->AdminModel->getAllColums($columnas, 'usuarios', $condiciones);
        $data['usuarios'] = $usuarios;
        #EXTRAEMOS LAS REDES
        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);
        $data['redes'] = $redes;
        #EXTRAEMOS LOS GRADOS ACADEMICOS
        $condiciones = [];
        $grados_academicos = $this->AdminModel->getAll('grado_academico', $condiciones);
        $data['grados_academicos'] = $grados_academicos;
        #obtenemos los tipos de constancias
        $condiciones = [];
        $tipo_constancias = $this->AdminModel->getAll('tipo_constancias', $condiciones);
        $data['constancias'] = $tipo_constancias;
        $anio_inicio = 2015;
        $anios = [];
        for ($i = $anio_inicio; $i <= date('Y'); $i++) {
            array_push($anios, $i);
        }
        $data['anios'] = $anios;

        return view('admin/headers/index')
            . view('admin/constancias/agregar', $data)
            . view('admin/footers/index');
    }

    public function getCuerposConstancias()
    {
        $usuario = $_POST['usuario'];
        $condiciones = ['usuario' => $usuario];
        $columnas = ['cuerpoAcademico'];
        $cuerpos = $this->AdminModel->getAllColums($columnas, 'miembros', $condiciones);
        if (empty($cuerpos)) {
            echo '<option disabled>Usuarios sin cuerpos académicos registrados</option>';
            exit;
        }
        $htmlOptions = '';

        foreach ($cuerpos as $key => $c) {

            $htmlOptions .= '<option value="' . $c['cuerpoAcademico'] . '">' . $c['cuerpoAcademico'] . '</option>';
        }

        echo $htmlOptions;
    }

    public function insertConstancias()
    {
        #HAY QUE AGREGAR LA TABLA A LA QUE VA ASIGNADA LA CONSTANCIA EN LA BD, ADEMAS, ESTA DEBE SER IGUAL A LA BD DEL HOSTING
        #SE VA A CONDICIONAR CADA TIPO DE CONSTANCIA, LO HAGO CON IF PARA MANEJARLO MAS VISUAL, SWITCH SE ME HACE MUY RARO PARA ESTAS SITUACIONES DONDE 
        #HAY MUCHO CODIGO POR CASO
        $condiciones = ['abreviacion' => $_POST['tipo_constancia']];
        $tabla_insert = $this->AdminModel->getAllOneRow('tipo_constancias', $condiciones);
        $data_tabla = $tabla_insert;
        $tabla_insert = $tabla_insert['nombre_tabla'];

        if ($_POST['tipo_constancia'] == 'DIC') {
            $fecha = $_POST['fecha_revision'];
            $fecha_formato = date("d/m/Y", strtotime($fecha));
            $data = [
                'area_revision' => strtoupper($_POST['red']),
                'correo' => $_POST['correo'],
                'nombre' => $_POST['nombre'],
                'id_iq4' => $_POST['id_iq4'],
                'nombre_articulo' => $_POST['nombre_ponencia'],
                'fecha' => $fecha_formato,
                'universidad' => $_POST['universidad'],
                'grado_academico' => $_POST['grado_academico'],
                'ap_paterno' => $_POST['ap_paterno'],
                'anio' => $_POST['anio']
            ];
            if ($this->AdminModel->generalInsert($tabla_insert, $data) == 1) {
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Éxito')
                    ->with('text', 'Se inserto la constancia de Dictaminador correctamente');
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, contacte a sistemas');
            }
        }
        if ($_POST['tipo_constancia'] == 'CE' || $_POST['tipo_constancia'] == 'MO') {

            $tabla = [
                'MO' => 'constancia_moderadores',
                'CE' => 'constancia_encuestador'
            ];

            #BUSCAMOS EL USUARIO
            $condiciones = ['usuario' => $_POST['usuario']];
            $usuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);

            if (empty($usuario)) {
                http_response_code(500);
                echo 'No se ha encontrado el usuario';
                exit;
            }

            $nombre = $usuario['ap_materno'] == '' ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $correo = $usuario['correo'];

            $data = [
                'red' => $_POST['red'],
                'anio' => $_POST['anio'],
                'correo' => $correo,
                'nombre' => $nombre,
                'usuario' => $_POST['usuario']
            ];

            if ($this->AdminModel->generalInsert($tabla_insert, $data) == 1) {
                $condiciones = $data;
                $constancia = $this->AdminModel->getAllOneRow($tabla[$_POST['tipo_constancia']], $condiciones);

                $dataUpdate = [
                    'folio_completo' => $constancia['id'] . $_POST['tipo_constancia'] . '-' . $constancia['red'] . '-' . $constancia['anio']
                ];
                $condiciones = ['id' => $constancia['id']];

                $this->AdminModel->generalUpdate($tabla[$_POST['tipo_constancia']], $dataUpdate, $condiciones);
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Éxito')
                    ->with('text', 'Se inserto la constancia de ' . $data_tabla['nombre'] . ' correctamente');
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, contacte a sistemas');
            }
        }
        if ($_POST['tipo_constancia'] == 'MI' || $_POST['tipo_constancia'] == 'MA' || $_POST['tipo_constancia'] == 'PA') {

            switch ($_POST['tipo_constancia']) {
                case 'MI':
                    $tipo = 'Miembro_investigador';
                    break;
                case 'MA':
                    $tipo = 'Miembro_asociado';
                    break;
                case 'PA':
                    $tipo = 'Asistencia';
                    break;
                default:
                    return redirect()->back()
                        ->with('icon', 'error')
                        ->with('title', 'Oh no')
                        ->with('text', 'El tipo de constancia no esta asociado, contacte a sistemas');
                    break;
            }

            $condiciones = ['usuario' => $_POST['usuario']];
            $usuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);

            if (empty($usuario)) {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'Oh no')
                    ->with('text', 'El usuario no existe');
            }

            $nombre_usuario = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

            $data = [
                'red' => $_POST['red'],
                'anio' => $_POST['anio'],
                'usuario' => $_POST['usuario'],
                'nombre' => $nombre_usuario,
                'redCueAca' => $_POST['claveCuerpo'],
                'tipo_constancia' => $tipo
            ];

            $tabla_insert = $tabla_insert . $_POST['red'];

            $folio = $this->AdminModel->generalInsertLastId($data, $tabla_insert);

            $data = ['folio' => $folio];
            $condiciones = ['id' => $folio];

            if ($this->AdminModel->generalUpdate($tabla_insert, $data, $condiciones) == 1) {
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Éxito')
                    ->with('text', 'Se inserto la constancia de ' . $data_tabla['nombre'] . ' correctamente');
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, contacte a sistemas');
            }
        }
        if ($_POST['tipo_constancia'] == 'CTSNI' || $_POST['tipo_constancia'] == 'CTMI' || $_POST['tipo_constancia'] == 'CTEST') {
            switch ($_POST['tipo_constancia']) {
                case 'CTSNI':
                    $tabla = 'constancia_sni`';
                    break;
                case 'CTMI':
                    $tabla = 'constancia_metodologia';
                    break;
                case 'CTEST':
                    $tabla = 'constancia_estadistica';
                    break;
                default:
                    return redirect()->back()
                        ->with('icon', 'error')
                        ->with('title', 'Oh no')
                        ->with('text', 'El tipo de constancia no esta asociado, contacte a sistemas');
                    break;
            }

            $data = ['correo' => $_POST['correo'], 'nombre' => $_POST['nombre']];
            $id = $this->AdminModel->generalInsertLastId($data, $tabla);

            $folio = $id . '-' . $_POST['tipo_constancia'] . $_POST['edicion'] . '-' . $_POST['anio'];

            $data = ['folio' => $folio];

            $condiciones = ['id' => $id];

            if ($this->AdminModel->generalUpdate($tabla, $data, $condiciones) == 1) {
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Éxito')
                    ->with('text', 'Se inserto la constancia correctamente');
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, contacte a sistemas');
            }
        }
    }

    public function previsualizarConstancia()
    {

        $correo = $_POST["correo"];

        $anio = $_POST["anio"];

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $mes = date('n');

        $mes_mx = $meses[$mes - 1];

        $ahora = date("d") . ' de ' . $mes_mx . ' del ' . date('Y'); //de %B del %Y

        $condiciones = ["correo" => $correo, "anio" => $anio];

        $rows_constancia = $this->AdminModel->getAll("dictaminador2021", $condiciones);

        $existe = [];

        $cantidad = 1;

        $nombre = $_POST["nombre"];

        $ap_paterno = $_POST["ap_paterno"];

        $grado_academico = $_POST["grado_academico"];

        $universidad = $_POST["universidad"];

        #A LO QUE CANTIDAD REFIERE ES A LA CANTIDAD DE REDES, NO A LA CANTIDAD DE PONENCIAS

        $c = $cantidad;

        $fecha = $_POST['fecha_revision'];
        $fecha_formato = date("d/m/Y", strtotime($fecha));


        $pdf = new TCPDF();

        function formatoCarta($pdf, $red, $ahora, $nombre, $universidad, $grado_academico, $ap_paterno, $folio)
        {

            $pdf->SetPrintHeader(false);

            $pdf->SetPrintFooter(false);

            // set margins
            $pdf->SetMargins(0, 0, 0, true);

            // set auto page breaks false
            $pdf->SetAutoPageBreak(false, 0);

            $pdf->AddPage('P', 'A4', 0);

            //$c = $c-5;

            $pdf->Ln(10);

            $pdf->Image(base_url("resources/pdf/constancias/Carta_$red.jpg"), 0, 0, 210, 297, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);

            $pdf->SetMargins(10, 0, 10, true);

            $pdf->SetFont('Times', '', 8);

            $pdf->Cell(0, 10, $folio . '       ', 0, 0, 'R');

            $pdf->Ln(30);

            $pdf->SetFont('Times', '', 12);

            $pdf->Cell(0, 10, "Querétaro, Querétaro a $ahora       ", 0, 0, 'R');

            $pdf->Ln(15);

            $pdf->SetFont('Times', 'B', 12);

            $pdf->write(10, "$nombre");

            $pdf->Ln(6);

            $pdf->SetFont('Times', 'B', 12);

            $pdf->write(10, "$universidad");

            $pdf->Ln(10);

            $pdf->SetFont('Times', '', 12);

            $pdf->write(10, "Apreciable $grado_academico $ap_paterno");

            $pdf->Ln(13);

            $pdf->SetFont('Times', '', 12);

            $pdf->write(6, "El Comité Técnico-Académico de la Red de Estudios Latinoamericanos hace constar y agradece su importante colaboración en el arbitraje de los siguientes productos académicos de la Red con las siguientes referencias:"); //texto

            $pdf->Ln(10);

            $pdf->SetFont('Times', '', 8);
        }

        function stringListado($pdf, $id_iq4, $nombre_articulo, $fecha_realizacion)
        {
            #ESTABLECEMOS LA FUENTE Y EL TAMAñO

            $pdf->SetFont('Times', '', 10);

            #HACEMOS EL STRING DEL LISTADO

            $pdf->write(12, "ID" . $id_iq4 . ": " . $nombre_articulo . ", elaborada el $fecha_realizacion\n");
        }

        function pieCarta($pdf)
        {
            $pdf->Ln(10);

            $pdf->SetFont('Times', '', 12);

            $pdf->write(6, "Su participación en el proceso de dictamen entre pares es un importante aporte decidido y fundamental en el compromiso compartido por impulsar el desarrollo de la investigación científica en Latinoamérica.");

            $pdf->Ln(12);

            $pdf->write(6, "La Red de Estudios Latinoamericanos reitera a usted el reconocimiento por este apoyo brindado y expresa su deseo de seguir contando con su apreciable aporte académico.");
        }

        if ($cantidad == 1) {

            $red = strtoupper($_POST["red"]);
        } else {

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

        $folio = 'FOLIO PENDIENTE';


        $id_iq4 = $_POST["id_iq4"];

        $nombre_articulo = $_POST["nombre_ponencia"];

        $nombre = $_POST["nombre"];

        $universidad = $_POST["universidad"];

        $grado_academico = $_POST["grado_academico"];

        $ap_paterno = $_POST["ap_paterno"];

        $fecha_realizacion = $fecha_formato;

        if ($i == 0) {

            formatoCarta($pdf, $red, $ahora, $nombre, $universidad, $grado_academico, $ap_paterno, $folio);

            stringListado($pdf, $id_iq4, $nombre_articulo, $fecha_realizacion);

            $i++;
        } else if ($i <= 5) {

            #SE HACE EL LISTADO EN LA MISMA PAGINA

            stringListado($pdf, $id_iq4, $nombre_articulo, $fecha_realizacion);
        } else {



            #SE HACE EL CIERRE DE LA CARTA ANTERIOR PARA HACER LA NUEVA

            pieCarta($pdf);

            #SE CREA UNA NUEVA HOJA PARA PODER PONER EL LISTADO RESTANTE

            formatoCarta($pdf, $red, $ahora, $nombre, $universidad, $grado_academico, $ap_paterno, $folio);

            #IMPRIMIMOS EL LISTADO CORRESPONDIENTE

            stringListado($pdf, $id_iq4, $nombre_articulo, $fecha_realizacion);
        }


        //$condiciones = ['correo' => $correo, 'anio' => $anio];

        //$data = ['folio' => $folio];

        //$this->AdminModel->generalUpdate('dictaminador2021',$data,$condiciones);


        pieCarta($pdf);

        $pdf->Output('Previsualizacion_dictaminador.pdf', 'D');

        exit;
    }

    #====================CONSTANCIA===========================

    #====================MIEMBROS===========================

    public function miembros()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/miembros/lista')
            . view('admin/footers/index');
    }

    public function getListadoMiembros()
    {
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'nombre', 'apaterno', 'amaterno', 'especialidad', 'telefono', 'nivelSNI',
            'anoSNI', 'tipo', 'lider', 'redCueCa', 'cuerpoAcademico'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM miembros";
        $sql_data = "SELECT * FROM miembros";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $m) {

            $nombre = empty($m['amaterno']) ? $m['nombre'] . ' ' . $m['apaterno'] : $m['nombre'] . ' ' . $m['apaterno'] . ' ' . $m['amaterno'];

            $condiciones = [
                'usuario' => $m['usuario']
            ];

            $usuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);

            if (!empty($usuario)) {
                $correo = $usuario['correo'];
                $correo_institucional = $usuario['correo_institucional'];
            } else {
                $correo = '<label style="color:red">Sin registro</label>';
                $correo_institucional = '<label style="color:red">Sin registro</label>';
            }

            $condiciones = ['id' => $m['grado']];
            $grado = $this->AdminModel->getAllOneRow('grado_academico', $condiciones);

            if (!empty($grado)) {
                $grado_academico = $grado['nombre'];
            } else {
                $grado_academico = '<label style="color:red">Sin registro</label>';
            }

            if (!empty($m['nivelSNI'])) {
                $condiciones = ['id' => $m['nivelSNI']];
                $sni = $this->AdminModel->getAllOneRow('nombre_sni', $condiciones);
                $nivelSNI = $sni['nombre'];
                $anoSNI = $m['anoSNI'];
            } else {
                $nivelSNI = '<label style="color:red">Sin registro</label>';
                $anoSNI = '<label style="color:red">Sin registro</label>';
            }

            $lider = $m['lider'] == 1 ? '<i class="mdi mdi-crown" style="color:gold"></i>' : '<i class="mdi mdi-account" style="color:silver"></i>';

            $htmlEditar = '<a type="button" href="editar/' . $m['id'] . '" class="btn btn-warning btn-icon-text btn-rounded">
            <i class="mdi mdi-lead-pencil"></i> Editar </a>';

            $htmlEliminar = '
            <div class="dropdown">
              <button class="btn btn-danger dropdown-toggle btn-rounded  btn-icon-text" type="button" id="dropdownMenuSizeButton' . $m['id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-alert btn-icon-prepend"></i> Eliminar </button> </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton' . $m['id'] . '" style="">
                <h6 class="dropdown-header">Seleccione una opcion</h6>
                <button class="dropdown-item eliminarMiembro" data-id="' . $m['id'] . '">Eliminar el miembro del cuerpo académico actual</button>
                <button class="dropdown-item eliminarAccesos" data-id="' . $m['id'] . '">Eliminar el miembro y sus accesos</button>
              </div>
            </div>
            ';

            $condiciones = ['claveCuerpo' => $m['cuerpoAcademico']];
            $columnas = ['nombre'];
            $universidad = $this->AdminModel->getColumnsOneRow($columnas,'cuerpos_academicos',$condiciones);

            $nombre_uni = empty($universidad) ? 'No encontrada' : $universidad['nombre']; 

            $array[$key] = [
                'id' => $m['id'],
                'nombre' => $nombre,
                'correo' => $correo,
                'correo_institucional' => $correo_institucional,
                'grado_academico' => $grado_academico,
                'especialidad' => $m['especialidad'],
                'telefono' => $m['telefono'],
                'nivelSNI' => $nivelSNI,
                'anoSNI' => $anoSNI,
                'tipo' => $m['tipo'],
                'lider' => $lider,
                'claveCuerpo' => $m['cuerpoAcademico'],
                'universidad' => $nombre_uni,
                'red' => $m['redCueCa'],
                'editar' => $htmlEditar,
                'eliminar' => $htmlEliminar
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

    public function editMiembro($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $miembro = $this->AdminModel->getAllOneRow('miembros', $condiciones);

        if (empty($miembro)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El miembro que quiere editar no existe');
        }

        $condiciones = [];
        $grados_academicos = $this->AdminModel->getAll('grado_academico', $condiciones);
        $sni = $this->AdminModel->getAll('nombre_sni', $condiciones);

        $condiciones = ['usuario' => $miembro['usuario']];
        $columnas = ['correo', 'correo_institucional', 'password', 'profile_pic'];
        $usuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);

        if (empty($usuario)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El miembro que quiere editar no tiene accesos en usuarios');
        }

        $condiciones = ['id' => $miembro['grado']];
        $grado_usuario = $this->AdminModel->getAllOneRow('grado_academico', $condiciones);
        $usuario['grado_academico'] = $grado_usuario['nombre'];

        $data['miembro'] = $miembro;
        $data['grados_academicos'] = $grados_academicos;
        $data['sni'] = $sni;
        $data['usuario'] = $usuario;

        return view('admin/headers/index')
            . view('admin/miembros/editar', $data)
            . view('admin/footers/index');
    }

    public function updateMiembro()
    {

        #actualizacion de los datos de miembros y accesos

        print_r($_POST);

        $dataMiembro = [
            'nombre' => $_POST['nombre'],
            'apaterno' => $_POST['apaterno'],
            'amaterno' => $_POST['amaterno'],
            'grado' => $_POST['grado'],
            'especialidad' => $_POST['especialidad'],
            'telefono' => $_POST['telefono'],
            'nivelSNI' => $_POST['nivelSNI'],
            'anoSNI' => $_POST['anoSNI']
        ];

        $condiciones = ['id' => $_POST['id']];

        if ($this->AdminModel->generalUpdate('miembros', $dataMiembro, $condiciones)) {

            $condiciones = ['usuario' => $_POST['usuario']];

            if (!empty($_POST['password'])) {
                $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $dataUsuario = [
                    'correo' => $_POST['correo'],
                    'correo_institucional' => $_POST['correo_institucional'],
                    'password' => $pass
                ];
            } else {
                $dataUsuario = [
                    'correo' => $_POST['correo'],
                    'correo_institucional' => $_POST['correo_institucional']
                ];
            }

            if ($this->AdminModel->generalUpdate('usuarios', $dataUsuario, $condiciones)) {
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'ÉXITO')
                    ->with('text', 'Todos los datos se actualizaron correctamente');
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'Oh no')
                    ->with('text', 'Se actualizaron los datos del miembro pero no sus accesos. Contacte a sistemas');
            }
        } else {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Oh no')
                ->with('text', 'Ha ocurrido un error al actualizar los datos del miembro. Contacte a sistemas');
        }
    }

    public function eliminarMiembro()
    {
        $id = $_POST['id'];
        //VAMOS AOBTENER LOS DATOS DE ESE MIEMBRO
        $condiciones = ['id' => $id];
        $miembro = $this->AdminModel->getAllOneRow('miembros', $condiciones);
        $ca = $miembro['cuerpoAcademico'];

        //VAMOS A ELIMINAR EL MIEMBRO Y SI ES UN LIDER, VAMOS ASIGNAR EL LIDER DE MANERA AUTOMATICA AL PRIMER MIEMBRO QUE OBTENGAMOS DEL CUERPO

        if ($this->AdminModel->generalDelete('miembros', $condiciones)) {
            $condiciones = ['cuerpoAcademico' => $ca];
            $miembroRand = $this->AdminModel->getAllOneRow('miembros', $condiciones);
            $data = ['lider' => 1];
            $condiciones = ['id' => $miembroRand['id']];

            if ($this->AdminModel->generalUpdate('miembros', $data, $condiciones)) {
                return 'success';
            } else {
                return 'errorLider';
            }
        } else {
            return 'errorDelete';
        }
    }

    public function eliminarAccesos()
    {
        $id = $_POST['id'];
        //VAMOS AOBTENER LOS DATOS DE ESE MIEMBRO
        $condiciones = ['id' => $id];
        $miembro = $this->AdminModel->getAllOneRow('miembros', $condiciones);
        $ca = $miembro['cuerpoAcademico'];

        //VAMOS A ELIMINAR EL MIEMBRO Y SI ES UN LIDER, VAMOS ASIGNAR EL LIDER DE MANERA AUTOMATICA AL PRIMER MIEMBRO QUE OBTENGAMOS DEL CUERPO

        if ($this->AdminModel->generalDelete('miembros', $condiciones)) {
            $condiciones = ['cuerpoAcademico' => $ca];
            $miembroRand = $this->AdminModel->getAllOneRow('miembros', $condiciones);
            $data = ['lider' => 1];
            $condiciones = ['id' => $miembroRand['id']];
            if ($this->AdminModel->generalUpdate('miembros', $data, $condiciones)) {
                $condiciones = ['id' => $id];
                if (!$this->AdminModel->exist('miembros', $condiciones)) {
                    $condiciones = ['usuario' => $miembro['usuario']];
                    $this->AdminModel->generalDelete('usuarios', $condiciones);
                    return 'successAccesos';
                } else {
                    return 'success';
                }
            } else {
                return 'errorLider';
            }
        } else {
            return 'errorDelete';
        }
    }

    public function getExcelMiembros()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }



        $headerExcel = [
            'Nombre',
            'Apellido paterno',
            'Apellido materno',
            'Correo',
            'Correo institucional',
            'Grado académico',
            'Especialidad',
            'Teléfono',
            'Nivel de SNI',
            'Año de SNI',
            'Tipo de registro',
            'Líder',
            'Red',
            'Clave del cuerpo académico',
            'Nombre de la universidad',
            'Fecha de registro'
        ];

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
                    'argb' => 'FF000000',
                ],
            ],
        ];

        $sheet->fromArray([$headerExcel], NULL, 'A1');
        $highestColumn = $sheet->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . '1')->applyFromArray($styleArray);

        $condiciones = [];
        $miembros = $this->AdminModel->getAll('miembros', $condiciones);;

        $arr_respuestas = [];
        $inicio = 2;
        foreach ($miembros as $m) {

            /*
            'Nombre', 
            'Apellido paterno', 
            'Apellido materno', 
            'Grado académico', 
            'Especialidad', 
            'Teléfono', 
            'Nivel de SNI', 
            'Año de SNI', 
            'Tipo de registro', 
            'Líder', 
            'Red', 
            'Clave del cuerpo académico', 
            'Nombre de la universidad',
            'Fecha de registro'
            */
            $condiciones = ['id' => $m['grado']];
            $info_grado = $this->AdminModel->getAllOneRow('grado_academico', $condiciones);
            $grado = empty($info_grado) ? 'Grado academico sin registro.' : $info_grado['nombre'];

            if ($m['nivelSNI'] === null || $m['nivelSNI'] == '') {
                $nivelSNI = 'No aplica.';
            } else {
                $condiciones = ['id' => $m['nivelSNI']];
                $infoSNI = $this->AdminModel->getAllOneRow('nombre_sni', $condiciones);
                $nivelSNI = empty($infoSNI) ? 'Nivel de SNI sin registro.' : $infoSNI['nombre'];
            }

            if ($m['anoSNI'] === null || $m['anoSNI'] == '') {
                $anioSNI = 'No aplica.';
            } else {
                $anioSNI = $m['anoSNI'];
            }

            if ($m['lider'] == 1) {
                $lider = 'Sí';
            } else {
                $lider = 'No';
            }

            $condiciones = ['claveCuerpo' => $m['cuerpoAcademico']];
            $columnas = ['nombre'];
            $info_universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
            $universidad = empty($info_universidad) ? 'Universidad sin registro.' : $info_universidad['nombre'];

            $condiciones = [
                'usuario' => $m['usuario']
            ];

            $columnas = ['correo', 'correo_institucional'];

            $usuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);

            if (empty($usuario)) {
                continue;
            }

            $arr_respuestas = [
                $m['nombre'],
                $m['apaterno'],
                $m['amaterno'],
                $usuario['correo'],
                $usuario['correo_institucional'],
                $grado,
                $m['especialidad'],
                $m['telefono'],
                $nivelSNI,
                $anioSNI,
                ucfirst($m['tipo']),
                $lider,
                $m['redCueCa'],
                $m['cuerpoAcademico'],
                $universidad,
                $m['fecha_registro']
            ];
            $sheet->fromArray([$arr_respuestas], NULL, 'A' . $inicio);
            $arr_respuestas = [];
            $inicio++;
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $archivo = 'Miembros';

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $archivo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    #====================MIEMBROS===========================

    #====================CONGRESOS==========================
    public function instruccionesCongreso()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        #OBTENEMOS LAS REDES
        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);
        $tipos_registros = $this->AdminModel->getAll('tipos_registros', $condiciones);
        #ASIGNAMOS VALORES
        $data['tipos_registros'] = $tipos_registros;
        $data['redes'] = $redes;

        return view('admin/headers/index')
            . view('admin/congresos/instrucciones', $data)
            . view('admin/footers/index');
    }

    public function verMensajeInstruccionesCongresos($tipo, $red, $anio)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        //BUSCAMOS SI YA HAY UN MENSAJE REGISTRADO
        $condiciones = [
            'red' => $red,
            'anio' => $anio,
            'tipo' => $tipo
        ];

        if ($this->AdminModel->exist('instrucciones_investigaciones', $condiciones) == 1) {
            #EXISTE, AHORA VAMOS A EXTRAER LA INFO
            $instrucciones = $this->AdminModel->getAllOneRow('instrucciones_investigaciones', $condiciones);
            $data['instrucciones'] = $instrucciones['instrucciones'];
        }

        $data['info'] = [
            'red' => $red,
            'anio' => $anio,
            'tipo' => $tipo
        ];
        return view('admin/headers/index')
            . view('admin/congresos/verInstruccion', $data)
            . view('admin/footers/index');
    }

    public function verInstruccionesCongresos($tipo, $red, $anio, $tipo_inst)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        //BUSCAMOS SI YA HAY UN MENSAJE REGISTRADO
        $condiciones = [
            'red' => $red,
            'anio' => $anio,
            'tipo' => $tipo,
            'tipo_instruccion' => $tipo_inst
        ];

        if ($this->AdminModel->exist('instrucciones_investigaciones', $condiciones) == 1) {
            #EXISTE, AHORA VAMOS A EXTRAER LA INFO
            $instrucciones = $this->AdminModel->getAllOneRow('instrucciones_investigaciones', $condiciones);
            $data['instrucciones'] = $instrucciones['instrucciones'];
        }

        $data['info'] = [
            'red' => $red,
            'anio' => $anio,
            'tipo' => $tipo,
            'congreso' => $tipo_inst
        ];
        return view('admin/headers/index')
            . view('admin/congresos/verInstruccion', $data)
            . view('admin/footers/index');
    }

    public function guardarInstruccion()
    {

        $condiciones = [
            'red' => $_POST['red'],
            'anio' => $_POST['anio'],
            'tipo' => $_POST['tipo'],
            'tipo_instruccion' => $_POST['tipo_instruccion']
        ];
        $instruccion = $this->AdminModel->getAllOneRow('instrucciones_investigaciones', $condiciones);

        if (empty($instruccion['instrucciones'])) {
            #NO EXISTELA INSTRUCCION EN LA BD, VAMOS A INGRESARLA
            $data = [
                'red' => $_POST['red'],
                'anio' => $_POST['anio'],
                'tipo' => $_POST['tipo'],
                'instrucciones' => $_POST['mensaje'],
                'tipo_instruccion' => $_POST['tipo_instruccion'],
                'updated_by' => session('nombre')
            ];
            if ($this->AdminModel->generalInsert('instrucciones_investigaciones', $data)) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            #YA EXISTE SOLO ACTUALIZAMOS
            $data = [
                'instrucciones' => $_POST['mensaje'],
                'updated_by' => session('nombre')
            ];
            if ($this->AdminModel->generalUpdate('instrucciones_investigaciones', $data, $condiciones)) {
                return 'success';
            } else {
                return 'error';
            }
        }
    }

    #====================CONGRESOS==========================

    #======================FINANZAS============================

    public function proyectos()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/finanzas/proyectos/lista')
            . view('admin/footers/index');
    }

    public function getListadoProyectos()
    {

        $columnas = [
            'id', 'claveCuerpo', 'proyecto', 'monto', 'restante', 'moneda', 'fecha_registro',
            'tipo_registro'
        ];

        $tabla = 'pagos';

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        foreach ($array as $key => $a) {

            $array[$key] = [
                'id' => $a['id'],
                'claveCuerpo' => $a['claveCuerpo'],
                'proyecto' => $a['proyecto'],
                'monto' => $a['monto'],
                'restante' => $a['restante'],
                'moneda' => $a['moneda'],
                'tipo_registro' => $a['tipo_registro'],
                'fecha_registro' => $a['fecha_registro'],
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

    public function movimientosProyecto($id_pago)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id_pago' => $id_pago];
        $movimientos = $this->AdminModel->getAll('movimientos', $condiciones);

        if (empty($movimientos)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El pago seleccionado no tiene movimientos adjuntados');
        }

        $condiciones = ['id' => $id_pago];
        $pago = $this->AdminModel->getAllOneRow('pagos', $condiciones);

        foreach ($movimientos as $m) {

            $data['movimientos'][] = $m;
        }

        $porcentaje = ($pago['restante'] * 100) / $pago['monto'];
        $porcentaje = 100 - $porcentaje;
        $porcentaje = round($porcentaje, 2);

        $data['datos_generales'] = [
            'total_proyecto' => $pago['monto'],
            'restante' => $pago['restante'],
            'proyecto' => $pago['proyecto'],
            'claveCuerpo' => $pago['claveCuerpo'],
            'moneda' => $pago['moneda'],
            'fecha_registro' => $pago['fecha_registro'],
            'porcentaje' => $porcentaje
        ];

        return view('admin/headers/index')
            . view('admin/finanzas/proyectos/movimientos', $data)
            . view('admin/footers/index');
    }

    public function getListadoMovimientosPago($id)
    {

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'movimiento', 'comprobante', 'fecha_comprobante', 'fecha_insert', 'facturado', 'estado'
        ];

        $tabla = 'movimientos';

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
            'inner_join' => [
                'pagos' => [
                    'join' => "pagos.id = {$tabla}.id_pago",
                    'columnas' => ['claveCuerpo']
                ]
            ],
            'where' => "movimientos.id_pago = {$id}"
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        /* echo '<pre>';
        print_r($array);
        echo '</pre>';
        exit; */

        foreach ($array as $key => $a) {
            $explodeMov = explode('$', $a['movimiento']);

            $type_mov = $explodeMov[0] == '+' ? true:false;
            $is_comprobante = $a['comprobante'] == 'No requiere' ? false : true;

            $mov_formated = '';
            if($type_mov === false){
                $mov_formated = preg_replace("/[^0-9]/", "", $explodeMov[1]);
            }

            if ($a['fecha_insert'] == '' || empty($a['fecha_insert'])) {
                $fecha_registro = false;
            } else {
                $explodeFechaInsert = explode(' ', $a['fecha_insert']);
                $fecha_registro =  $explodeFechaInsert[0];
            }

            $array[$key] = [
                'id' => $a['id'],
                'id_pago' => $a['id_pago'],
                'claveCuerpo' => $a['pagos_claveCuerpo'],
                'movimiento' => $a['movimiento'],
                'comprobante' => $a['comprobante'],
                'type_mov' => $type_mov,
                'is_comprobante' => $is_comprobante,
                'estado' => $a['estado'],
                'facturado' => $a['facturado'],
                'fecha_comprobante' => $a['fecha_comprobante'],
                'fecha_registro' => $fecha_registro,
                'mov_formated' => $mov_formated
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

    public function movimientos()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/finanzas/movimientos/lista')
            . view('admin/footers/index');
    }

    public function getListadoMovimientos()
    {

        $columnas = [
            'id', 'id_pago', 'movimiento', 'comprobante', 'estado', 'fecha_comprobante', 'fecha_insert',
            'facturado'
        ];
        
        $tabla = 'movimientos';

        //Esta es la estructura que se manda llamar para obtener los datos de la tabla
        /*
        Explicare unas cosas: 
        Las posiciones sig. son opcionales, las demas obligatorias
        *inner_join
        *where
        Favor de seguir la estructura exactamente, para evitar problemas, si se ha encontrado un error, comunicarlo a sistemas

        En el foreach que solamente se encuentren consultas que no sean visuales en la tabla, ejemplo, mostrar todos los miembros de un ca en un modal ahi pues no hay tanta bronca porque no se ve directamente en la tabla.
        La finalidad de esto es que todas los valores de la columnas de la tabla se puedan buscar

        */

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
            'inner_join' => [
                'pagos' => [
                    'join' => "pagos.id = {$tabla}.id_pago",
                    'columnas' => ['claveCuerpo']
                ]
            ],
            #'where' => "movimientos.id_pago = 12"
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        foreach ($array as $key => $a) {
            $explodeMov = explode('$', $a['movimiento']);

            $type_mov = $explodeMov[0] == '+' ? true:false;
            $is_comprobante = $a['comprobante'] == 'No requiere' ? false : true;

            $mov_formated = '';
            if($type_mov === false){
                $mov_formated = preg_replace("/[^0-9]/", "", $explodeMov[1]);
            }

            if ($a['fecha_insert'] == '' || empty($a['fecha_insert'])) {
                $fecha_registro = false;
            } else {
                $explodeFechaInsert = explode(' ', $a['fecha_insert']);
                $fecha_registro =  $explodeFechaInsert[0];
            }

            $array[$key] = [
                'id' => $a['id'],
                'id_pago' => $a['id_pago'],
                'claveCuerpo' => $a['pagos_claveCuerpo'],
                'movimiento' => $a['movimiento'],
                'comprobante' => $a['comprobante'],
                'type_mov' => $type_mov,
                'is_comprobante' => $is_comprobante,
                'estado' => $a['estado'],
                'facturado' => $a['facturado'],
                'fecha_comprobante' => $a['fecha_comprobante'],
                'fecha_registro' => $fecha_registro,
                'mov_formated' => $mov_formated
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

    private function generateServerSideTable($send){
        
        $tabla = $send['tabla'];
        $valor_buscado = $send['valor_buscado'];

        $condicion = '';
        $join = '';

        if(!empty($send['valor_buscado'])){
            foreach ($send['columnas'] as $key => $val) {
                if ($send['columnas'][$key] == 'id') {
                    $condicion .= " {$tabla}.{$val} LIKE '%{$valor_buscado}%'";
                } else {
                    $condicion .= " OR {$tabla}.{$val} LIKE '%{$valor_buscado}%'";
                }
            }
        }
        
        if(isset($send['inner_join'])){
            $columns_joins = '';
            $search_join = '';
            foreach($send['inner_join'] as $key => $val){
                $tabla_join = $key;
                $relacion = $val['join'];
                $type = isset($val['type']) ? $val['type'] : 'INNER JOIN';
                $join .= " {$type} {$tabla_join} ON {$relacion} ";

                $count = count($val['columnas']);
                foreach($val['columnas'] as $key => $c){

                    if($key === $count-1){
                        $columns_joins .= "{$tabla_join}.{$c} as {$tabla_join}_{$c}, ";
                    }else{
                        $columns_joins .= "{$tabla_join}.{$c} as {$tabla_join}_{$c}, ";
                    }
                    
                    $search_join .= " OR {$tabla_join}.{$c} LIKE '%{$valor_buscado}%' ";
                }
            }
        }
        

        if(isset($columns_joins)){
            $columns_joins = substr($columns_joins, 0, -2);
        }
        $str_columnas = '';
        
        foreach($send['columnas'] as $c){
            $str_columnas .= "{$tabla}.$c,";
        }
        $str_columnas = substr($str_columnas, 0, -1);

        $sql_data = "select {$str_columnas}";
        $sql_count = "SELECT count({$tabla}.id) as total";

        $sql_data .= isset($columns_joins) ? ", {$columns_joins}" : '';
        #$sql_count .= isset($columns_joins) ? ", {$columns_joins}" : '';
        
        $sql_data .= " FROM {$tabla} ";
        $sql_count .= " FROM {$tabla} ";

        $sql_data .= isset($join) ? $join : '';
        $sql_count .= isset($join) ? $join : '';

        

        #$sql_data .= $condicion;

        if(isset($search_join) && !empty($valor_buscado)){
            $sql_data .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion}{$search_join})" : " WHERE {$condicion}{$search_join}";
            $sql_count .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion}{$search_join})" : " WHERE {$condicion}{$search_join}";
        }else{
            if(!empty($condicion)){
                $sql_data .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion})" : " WHERE {$condicion}";
                $sql_count .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion})" : " WHERE {$condicion}";
            }else{
                $sql_data .= isset($send['where']) ? " WHERE ({$send['where']})" : "{$condicion}";
                $sql_count .= isset($send['where']) ? " WHERE ({$send['where']})" : "{$condicion}";
            }
            
        }

        #echo $sql_count; exit;

        $total_count = $this->db_serv->query($sql_count)->getRow();
        
        $sql_data .= " ORDER BY " . $send['columnas'][$send['order_column']] . " " . $send['dir'] . " LIMIT " . $send['start'] . ", " . $send['length'] . "";

        //echo $sql_data; exit;

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        $dataReturn = [
            'total_count' => $total_count,
            'array' => $array
        ];

        return $dataReturn;
    }


    public function validarMovimiento($id)
    {

        //INFORMACION Y VALIDACIONES PARA LA ACTUALIZAFION DEL MOVIMIENTO

        #OBTENEMOS LOS DATOS DEL MOVIMIENTO
        $condiciones = ['id' => $id];
        $movimiento = $this->AdminModel->getAllOneRow('movimientos', $condiciones);

        if (empty($movimiento)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El movimiento seleccionado no existe. Ninguna acción realizada');
        }

        #OBTENEMOS LOS DATOS DEL PAGO
        $condiciones = ['id' => $movimiento['id_pago']];
        $pago = $this->AdminModel->getAllOneRow('pagos', $condiciones);

        if (empty($pago)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El pago al que se le aplicara la acción no existe. Ninguna acción realizada');
        }

        #VAMOS A OBTENER LOS DATOS DEL PROYECTO
        $condiciones = ['id' => $pago['id_proyecto']];
        $proyecto = $this->AdminModel->getAllOneRow('proyectos', $condiciones);

        if (empty($proyecto)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El proyecto registrado al pago no existe. Ninguna acción realizada');
        }

        $fecha_comprobante = $movimiento['fecha_comprobante'];
        $fecha_pronto_pago = $proyecto['fecha_limite_prontoPago'];

        if (empty($fecha_pronto_pago)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El proyecto no tiene registrado una fecha de pronto pago. Ninguna acción realizada');
        }

        #VAMOS A OBTENER EL MONTO DEL MOVIMIENTO
        $precio_movimiento = explode("-$", $movimiento["movimiento"]);
        $precio_movimiento = $precio_movimiento[1];
        #VAMOS A COMPARARLAS FECHAS PARA VER SI ENTRA A DESCUENTO DE PRONTO PAGO Y TOMAR COMO MONTO TOTAL EL DE PRONTO PAGO
        #EL PRONTO PAGO SOLAMENTE ES ACEPTADO SI ES EL PAGO COMPLETO DEL PROYECTO

        if ($fecha_comprobante <= $fecha_pronto_pago) {

            #ENTRA A PROMOCION DE PRONTO PAGO

            #OBTENEMOS EL PRECIO DEL PROYECTO

            $precio_proyecto = $pago['moneda'] == 'MXN' ? $proyecto["precio_prontoPagoMx"] : $proyecto["precio_prontoPagoUs"];

            $restante_preliminar = $precio_proyecto - $precio_movimiento;

            $pronto_pago = 1;
        } else {

            #NO ENTRA a PRONTO PAGO

            #OBTENEMOS EL PRECIO DEL PROYECTO

            $precio_proyecto = $pago['moneda'] == 'MXN' ? $proyecto["montoMx"] : $proyecto["montoUs"];

            $restante = $precio_proyecto == $pago['restante'] ? $precio_proyecto : $pago['restante'];

            $restante_preliminar = $restante - $precio_movimiento;



            $pronto_pago = 0;
        }

        if ($restante_preliminar < 0) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El restante no puede ser negativo');
        }

        if ($restante_preliminar != 0 && $pronto_pago == 1) {

            #ENTRO A PRONTOPAGO PERO NO SE DIO EL RESTANTE TOTAL
            #POR LO CUAL TOMAREMOS EL PRECIO REAL DEL PROYECTO

            $precio_proyecto = $pago['moneda'] == 'MXN' ? $proyecto["montoMx"] : $proyecto["montoUs"];

            $restante = $precio_proyecto == $pago['restante'] ? $precio_proyecto : $pago['restante'];

            $restante_preliminar = $restante - $precio_movimiento;
        }

        /*
        Parte para hacer tickets de cada movimiento
        Se hizo pensando en un sistema de facturacion automatico, pero la plataforma en su momento (Factura.com)
        No nos permitia esa tecnologia de diferentes productos por lo que se optop por no usarlo, si en un futuro lo necesitan
        Aqui se tienen unas bases

        #OBTENEMOS LA INFORMACION NECESITADA PARA EL TICKET
        $nombre_proyecto = $proyecto['nombre'].' '.$proyecto['redCueCa'].' '.$proyecto['anio'];
        $movimiento_efectuado = "$".preg_replace("/[^0-9]/", "", $movimiento["movimiento"]).' '.$pago['moneda'];

        $explode_proyecto = explode(' ',$proyecto['nombre']);

        if($explode_proyecto[0] == 'Esquema'){
            $uid = '6480ef18478cd';
            $empresa = $this->getInfoEmpresaFactura($uid);
        }else if($explode_proyecto[0] == 'Congreso'){
            $uid = '64820039d3568';
            $empresa = $this->getInfoEmpresaFactura($uid);
        }else{
            exit;
        }
        
        $empresa = json_decode($empresa,TRUE);
        $empresa = $empresa['data'];

        $rfc_empresa = $empresa['rfc'];
        $razons_empresa = $empresa['razon_social'];
        $regimenf_empresa = $empresa['regimen_fiscal'];
        $direccion = 'Calle '.$empresa['calle'].' #'.$empresa['exterior'].', colonia '.$empresa['colonia'].', CP '.$empresa['codpos'].'. '.$empresa['ciudad'].', '.$empresa['estado'];

        $id_movimiento = $movimiento['id'];

        $fecha_comprobante = explode('.',$movimiento['fecha_insert']);
        $fecha_comprobante = $fecha_comprobante[0];

        $pdf = new TCPDF();

        $pdf->SetPrintFooter(false);
        $pdf->SetPrintHeader(false);
        $pdf->SetAuthor('REDESLA');
        $pdf->SetCreator('REDESLA');
        $pdf->SetTitle("Ticket de Compra");
        $pdf->AddPage('P',[80,180]);

        #////////////////////LOGOTIPO//////////////////////////
        // Ruta de la imagen del logo
        $logoPath = base_url('/resources/img/logos_con_letras/Letras_Redesla.png');

        // Posición y dimensiones del logo
        $logoWidth = 50;
        $logoHeight = 25;

        // Obtener dimensiones de la página
        $pageWidth = $pdf->GetPageWidth();
        $pageHeight = $pdf->GetPageHeight();

        // Calcular coordenadas para centrar el logo
        $logoX = ($pageWidth - $logoWidth) / 2;
        $logoY = 5;

        // Agregar imagen del logo centrada
        $pdf->Image($logoPath, $logoX, $logoY, $logoWidth, $logoHeight);
        #////////////////////LOGOTIPO//////////////////////////

        #////////////////////INFO//////////////////////////

        $x = 0;  // Posición X
        $y = 30;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = "GRUPO REDESLA"; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        $x = 0;  // Posición X
        $y = 35;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $direccion; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        $x = 0;  // Posición X
        $y = 40;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = "RFC: {$rfc_empresa}     Régimen fiscal: {$regimenf_empresa}"; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        $x = 0;  // Posición X
        $y = 45;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        $texto = "Factura #{$id_movimiento}"; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        $x = 0;  // Posición X
        $y = 50;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        $texto = "{$fecha_comprobante}"; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'R', false, 1, '', '', true, 0, false, true, $height, 'M');

        #////////////////////INFO//////////////////////////

        $htmlTabla = <<<EOD
        <table cellspacing="0" cellpadding="1" border="1 pointer">
            <thead>
            <tr>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Importe</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{$nombre_proyecto}</td>
                    <td>{$movimiento_efectuado}</td>
                </tr>
                <tr>
                    <td></td>
                    <td style='text-align:right'><b>Total:</b></td>
                    <td>{$movimiento_efectuado}</td>
                </tr>
            </tbody>
        </table>
        EOD;

        // Agregar la tabla al documento PDF
        $pdf->writeHTML($htmlTabla, true, false, true, false, '');

        $x = 0;  // Posición X
        $y = 80;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        $texto = "**********************************************************"; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        $x = 0;  // Posición X
        $y = 85;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        $texto = "Este ticket puede ser facturado en:"; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 6;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        $x = 0;  // Posición X
        $y = 90;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        $texto = "https://autofacturacion.factura.com/{$uid}"; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 6;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        $x = 0;  // Posición X
        $y = 95;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        $texto = "**GRACIAS POR SU COMPRA**"; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 6;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        $x = 0;  // Posición X
        $y = 100;  // Posición Y
        $width = $pdf->GetPageWidth();  // Ancho del área
        $height = 6;  // Alto del área

        $texto = "https://redesla.la/"; // Texto a mostrar
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 6;
        $fontFamily = 'century_gothic';
        $pdf->SetFont($fontFamily, '', $fontSize);
        // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
        while ($textWidth > $width) {
            $fontSize -= 1; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textWidth = $pdf->GetStringWidth($texto);
        }
        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        $this->response->setContentType('application/pdf');

        $pdf->Output("d.pdf", 'I');

        exit;
        */

        #INGRESAMOS LOS DATOS QUE SE ACTUALIZARAN EN PAGOS
        $dataPagos = [
            'restante' => $restante_preliminar,
            'monto' => $precio_proyecto,
            'updated_by' => session('nombre')
        ];

        $dataMovimientos = [
            'estado' => 1,
            'accepted_by' => session('nombre')
        ];





        #SI ESTA EN CEROS LA CUENTA SOLO ACTUALIZAMOS LOS PAGOS

        if ($restante_preliminar != 0) {

            $condicionesPagos = ['id' => $pago['id']];

            if ($this->AdminModel->generalUpdate('pagos', $dataPagos, $condicionesPagos)) {

                $condicionesMovimientos = ['id' => $movimiento['id']];

                if ($this->AdminModel->generalUpdate('movimientos', $dataMovimientos, $condicionesMovimientos)) {
                    return redirect()->back()
                        ->with('icon', 'success')
                        ->with('title', 'Exito')
                        ->with('text', 'Se actualizo el monto correctamente');
                } else {
                    return redirect()->back()
                        ->with('icon', 'error')
                        ->with('title', 'OJO')
                        ->with('text', 'Se actualizo el restante pero hubo error al cambiar el estado del movimiento');
                }
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'OJO')
                    ->with('text', 'Hubo error en actualizar el restante');
            }
        }

        #AHORA CUANDO SE FINALICE LA DEUDA, SE OTORGAN CONSTANCIAS Y/O PROYECTOS
        #A VECES NADA, PERO POR CUMPLIR CON EL PAGO DEL PROYECTO SE OTORGA ALGO

        #LAS INVESTIGACIONES Y DESAFIOS OTORGAN: CONSTANCIA DE MIEMBRO INVESTIGADOR Y PROYECTO DE CONGRESO
        #LOS CONGRESOS OTORGAN CONSTANCIA DE MIEMBRO ASOCIADO

        #OBTENEMOS EL TIPO DE REGISTRO

        $strpos = stripos($proyecto['nombre'], ': ');

        $explode_condicion = $strpos !== false ? 1 : 0;

        $explode_proyecto = explode(' ', $pago['proyecto']);

        $tipo_proyecto = $explode_condicion == 1 ? $explode_proyecto[2] : $proyecto['nombre'];

        #HACEMOS CONDICIONES PARA CADA UNO
        #HACEMOS IF EN VEZ DE SWITCH POR CODIGO EXTENSO EN CADA CASO

        if ($tipo_proyecto == 'Investigación' || $tipo_proyecto == 'Desafío' || $tipo_proyecto == 'Investigacion') {

            #SE OTORGAN CONSTANCIAS DE INVESTIGADOR Y EL CONGRESO
            #VAMOS A BUSCAR EL PROYECTO DE CONGRESO EN LAS INVESTIGACIONES

            $nombre_congreso = 'Congreso ' . $explode_proyecto[3] . ' ' . $explode_proyecto[4];

            if ($explode_proyecto[3] == 'Releg' && $explode_proyecto[4] == 2022) {
                $condiciones = [
                    'nombre' => 'Congreso',
                    'redCueCa' => $explode_proyecto[3],
                    'anio' => $explode_proyecto[4] + 1
                ];
                $explode_proyecto[4] = $explode_proyecto[4] + 1;
                $nombre_congreso = 'Congreso ' . $explode_proyecto[3] . ' ' . $explode_proyecto[4];
            } else {
                $condiciones = [
                    'nombre' => 'Congreso',
                    'redCueCa' => $explode_proyecto[3],
                    'anio' => $explode_proyecto[4]
                ];
            }

            if (!$this->AdminModel->exist('proyectos', $condiciones)) {

                return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'El ' . $nombre_congreso . ' no esta registrado y no se pudo ingresar. Favor de ingresarlo. Ninguna acción realizada');
            }

            $congreso = $this->AdminModel->getAllOneRow('proyectos', $condiciones);

            #VAMOS A DAR LA DATA PARA INSERTAR EL PROYECTO
            #TIPO DE REGISTRO ES 1 PORQUE 1 ES POR INVESTIGACION

            #SE DEBE SACAR LA MONEDA POR EL PAIS DEL CUERPO PERO ME DIO HUEVA MANO SI FALLA PUES PODRIA
            #SER ESO

            $monto = $pago['moneda'] == 'MXN' ? $congreso["montoMx"] : $congreso["montoUs"];

            $dataProyecto = [
                'tipo_registro' => 1,
                'claveCuerpo' => $pago['claveCuerpo'],
                'proyecto' => $nombre_congreso,
                'id_proyecto' => $congreso['id'],
                'monto' => $monto,
                'restante' => 0,
                'fecha_registro' => date("Y-m-d H:i:s"),
                'moneda' => $pago['moneda']
            ];

            #VAMOS A INSERTAR CONSTANCIAS

            $condiciones = ['cuerpoAcademico' => $pago['claveCuerpo']];

            $miembros = $this->AdminModel->getAll('miembros', $condiciones);

            foreach ($miembros as $m) {

                $condiciones = [
                    'usuario' => $m['usuario'],
                    'tipo_constancia' => 'Miembro_investigador',
                    'red' => $explode_proyecto[3],
                    'anio' => $explode_proyecto[4]
                ];

                if (!$this->AdminModel->exist('constancia_' . $explode_proyecto[3], $condiciones)) {

                    $nombre_miembro = empty($m['amaterno']) ?  $m["nombre"] . ' ' . $m["apaterno"] : $m["nombre"] . ' ' . $m["apaterno"] . ' ' . $m["amaterno"];

                    $dataConstancia = [
                        'redCueAca' => $pago['claveCuerpo'],
                        'usuario' => $m["usuario"],
                        'tipo_constancia' => 'Miembro_investigador',
                        'nombre' => $nombre_miembro,
                        'red' => $explode_proyecto[3],
                        'anio' => $explode_proyecto[4],
                        'inserted_by' => session('nombre'),
                        'fecha_registro' => date("Y-m-d H:i:s")
                    ];

                    #DAMOS CONSTANCIA DE MIEMBRO IBVESTIGADOR

                    $last_id = $this->AdminModel->generalInsertLastId($dataConstancia, 'constancia_' . $explode_proyecto[3]);

                    $dataUpdateConstancia = ['folio' => $last_id];

                    $condicionesConstancia = ['id' => $last_id];

                    $this->AdminModel->generalUpdate('constancia_' . $explode_proyecto[3], $dataUpdateConstancia, $condicionesConstancia);
                }
            }

            #UNA VEZ QUE YA HICIMOS TODO EL PROCESO, VANOS A INSERTAR LOS DATOS

            if ($this->AdminModel->generalInsert('pagos', $dataProyecto)) {

                $condicionesPagos = ['id' => $pago['id']];

                if ($this->AdminModel->generalUpdate('pagos', $dataPagos, $condicionesPagos)) {

                    $condicionesMovimientos = ['id' => $movimiento['id']];

                    if ($this->AdminModel->generalUpdate('movimientos', $dataMovimientos, $condicionesMovimientos)) {
                        return redirect()->back()
                            ->with('icon', 'success')
                            ->with('title', 'Exito')
                            ->with('text', 'Se insertaron constancias, se registro el proyecto de congreso y se actualizo el monto');
                    } else {
                        return redirect()->back()
                            ->with('icon', 'error')
                            ->with('title', 'OJO')
                            ->with('text', 'Se insertaron constancias, se registro el proyecto de congreso, se actualizo el restante pero hubo error al cambiar el estado del movimiento. ID: ' . $id);
                    }
                } else {
                    return redirect()->back()
                        ->with('icon', 'error')
                        ->with('title', 'OJO')
                        ->with('text', 'Se insertaron constancias, se registro el proyecto de congreso, pero hubo error en actualizar el restante. ID: ' . $id);
                }
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'OJO')
                    ->with('text', 'Se insertaron constancias pero no se ingreso el proyecto de congreso. ID: ' . $id);
            }
        } else if ($tipo_proyecto == 'Congreso') {

            #AQUI SOLAMENTE SE OTORGA LA CONSTANCIA DE MIEMBRO ASOCIADO

            $condiciones = ['cuerpoAcademico' => $pago['claveCuerpo']];

            $miembros = $this->AdminModel->getAll('miembros', $condiciones);

            foreach ($miembros as $m) {

                $condiciones = [
                    'usuario' => $m['usuario'],
                    'tipo_constancia' => 'Miembro_asociado',
                    'red' => $explode_proyecto[1],
                    'anio' => $explode_proyecto[2]
                ];

                if (!$this->AdminModel->exist('constancia_' . $explode_proyecto[1], $condiciones)) {

                    $nombre_miembro = empty($m['amaterno']) ?  $m["nombre"] . ' ' . $m["apaterno"] : $m["nombre"] . ' ' . $m["apaterno"] . ' ' . $m["amaterno"];

                    $dataConstancia = [
                        'redCueAca' => $pago['claveCuerpo'],
                        'usuario' => $m["usuario"],
                        'tipo_constancia' => 'Miembro_asociado',
                        'nombre' => $nombre_miembro,
                        'red' => $explode_proyecto[1],
                        'anio' => $explode_proyecto[2],
                        'inserted_by' => session('nombre'),
                        'fecha_registro' => date("Y-m-d H:i:s")
                    ];

                    $last_id = $this->AdminModel->generalInsertLastId($dataConstancia, 'constancia_' . $explode_proyecto[1]);

                    $dataUpdateConstancia = ['folio' => $last_id];

                    $condicionesConstancia = ['id' => $last_id];

                    $this->AdminModel->generalUpdate('constancia_' . $explode_proyecto[1], $dataUpdateConstancia, $condicionesConstancia);
                }
            }

            $condicionesPagos = [
                'id' => $pago['id']
            ];

            if ($this->AdminModel->generalUpdate('pagos', $dataPagos, $condicionesPagos)) {

                $condicionesMovimientos = ['id' => $movimiento['id']];

                if ($this->AdminModel->generalUpdate('movimientos', $dataMovimientos, $condicionesMovimientos)) {
                    return redirect()->back()
                        ->with('icon', 'success')
                        ->with('title', 'Exito')
                        ->with('text', 'Se insertaron constancias y se actualizo el monto');
                } else {
                    return redirect()->back()
                        ->with('icon', 'error')
                        ->with('title', 'OJO')
                        ->with('text', 'Se insertaron constancias, se actualizo el restante pero hubo error al cambiar el estado del movimiento. ID: ' . $id);
                }
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'OJO')
                    ->with('text', 'Se insertaron constancias pero hubo error en actualizar el restante. ID: ' . $id);
            }
        } else {

            $condicionesPagos = ['id' => $pago['id']];

            if ($this->AdminModel->generalUpdate('pagos', $dataPagos, $condicionesPagos)) {

                $condicionesMovimientos = ['id' => $movimiento['id']];

                if ($this->AdminModel->generalUpdate('movimientos', $dataMovimientos, $condicionesMovimientos)) {
                    return redirect()->back()
                        ->with('icon', 'success')
                        ->with('title', 'Exito')
                        ->with('text', 'Se actualizo el monto correctamente. No hay una accion especial para el proyecto');
                } else {
                    return redirect()->back()
                        ->with('icon', 'error')
                        ->with('title', 'OJO')
                        ->with('text', 'Se actualizo el restante pero hubo error al cambiar el estado del movimiento. ID: ' . $id);
                }
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'OJO')
                    ->with('text', 'Hubo error en actualizar el restante. ID: ' . $id);
            }
        }
    }

    private function getInfoEmpresaFactura($uid)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi . '/v1/account/' . $uid,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'F-PLUGIN: 9d4095c8f7ed5785cb14c0e3b033eeb8252416ed',
                'F-Api-Key: ' . $this->apikey,
                'F-Secret-Key: ' . $this->privateApiKey
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function rechazarMovimiento($id)
    {

        #OBTENEMOS LOS DATOS DEL MOVIMIENTO
        $condiciones = ['id' => $id];
        $movimiento = $this->AdminModel->getAllOneRow('movimientos', $condiciones);

        if (empty($movimiento)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El movimiento seleccionado no existe');
        }

        #OBTENEMOS LOS DATOS DEL PAGO
        $condiciones = ['id' => $movimiento['id_pago']];
        $pago = $this->AdminModel->getAllOneRow('pagos', $condiciones);

        if (empty($pago)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El pago al que se le aplicara la acción no existe');
        }

        #VAMOS A OBTENER LOS DATOS DEL PROYECTO
        $condiciones = ['id' => $pago['id_proyecto']];
        $proyecto = $this->AdminModel->getAllOneRow('proyectos', $condiciones);

        #REGRESAMOS EL MONTO AL ORIGINAL
        $precio_proyecto = $pago['moneda'] == 'MXN' ? $proyecto["montoMx"] : $proyecto["montoUs"];
        $condiciones = ['id' => $pago['id']];
        $data = ['monto' => $precio_proyecto];
        $this->AdminModel->generalUpdate('pagos', $data, $condiciones);

        if (empty($proyecto)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El proyecto registrado al pago no existe');
        }

        $fecha_comprobante = $movimiento['fecha_comprobante'];
        $fecha_pronto_pago = $proyecto['fecha_limite_prontoPago'];

        if (empty($fecha_pronto_pago)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El proyecto no tiene registrado una fecha de pronto pago');
        }

        #VAMOS A OBTENER EL MONTO DEL MOVIMIENTO
        $precio_movimiento = explode("-$", $movimiento["movimiento"]);
        $precio_movimiento = $precio_movimiento[1];
        #VAMOS A COMPARARLAS FECHAS PARA VER SI ENTRA A DESCUENTO DE PRONTO PAGO Y TOMAR COMO MONTO TOTAL EL DE PRONTO PAGO
        #EL PRONTO PAGO SOLAMENTE ES ACEPTADO SI ES EL PAGO COMPLETO DEL PROYECTO

        $restante_preliminar = $pago['restante'] + $precio_movimiento;


        if ($restante_preliminar > $precio_proyecto) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El restante no puede exceder el monto del proyecto');
        }

        #INGRESAMOS LOS DATOS QUE SE ACTUALIZARAN EN PAGOS
        $dataPagos = [
            'restante' => $restante_preliminar,
            'monto' => $precio_proyecto,
            'updated_by' => session('nombre')
        ];

        $dataMovimientos = [
            'estado' => 0,
            'accepted_by' => session('nombre')
        ];

        #AHORA CUANDO SE FINALICE LA DEUDA, SE OTORGAN CONSTANCIAS Y/O PROYECTOS
        #A VECES NADA, PERO POR CUMPLIR CON EL PAGO DEL PROYECTO SE OTORGA ALGO

        #LAS INVESTIGACIONES Y DESAFIOS OTORGAN: CONSTANCIA DE MIEMBRO INVESTIGADOR Y PROYECTO DE CONGRESO
        #LOS CONGRESOS OTORGAN CONSTANCIA DE MIEMBRO ASOCIADO

        #OBTENEMOS EL TIPO DE REGISTRO

        $strpos = stripos($proyecto['nombre'], ': ');

        $explode_condicion = $strpos !== false ? 1 : 0;

        $explode_proyecto = explode(' ', $pago['proyecto']);

        $tipo_proyecto = $explode_condicion == 1 ? $explode_proyecto[2] : $proyecto['nombre'];

        #HACEMOS CONDICIONES PARA CADA UNO
        #HACEMOS IF EN VEZ DE SWITCH POR CODIGO EXTENSO EN CADA CASO

        if ($tipo_proyecto == 'Investigación' || $tipo_proyecto == 'Desafío') {

            #SE OTORGAN CONSTANCIAS DE INVESTIGADOR Y EL CONGRESO
            #LAS VAMOS A REMOVER

            $nombre_congreso = 'Congreso ' . $explode_proyecto[3] . ' ' . $explode_proyecto[4];

            if ($explode_proyecto[3] == 'Releg' && $explode_proyecto[4] == 2022) {
                $condiciones = [
                    'nombre' => 'Congreso',
                    'redCueCa' => $explode_proyecto[3],
                    'anio' => $explode_proyecto[4] + 1
                ];
                $explode_proyecto[4] = $explode_proyecto[4] + 1;
                $nombre_congreso = 'Congreso ' . $explode_proyecto[3] . ' ' . $explode_proyecto[4];
            } else {
                $condiciones = [
                    'nombre' => 'Congreso',
                    'redCueCa' => $explode_proyecto[3],
                    'anio' => $explode_proyecto[4]
                ];
            }


            if (!$this->AdminModel->exist('proyectos', $condiciones)) {
                return redirect()->back()
                    ->with('icon', 'warning')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'El ' . $nombre_congreso . ' no esta registrado y no se pudo ingresar. Favor de ingresarlo. Ninguna acción realizada');
            }

            $congreso = $this->AdminModel->getAllOneRow('proyectos', $condiciones);

            #VAMOS A INSERTAR CONSTANCIAS

            $condiciones = ['cuerpoAcademico' => $pago['claveCuerpo']];

            $miembros = $this->AdminModel->getAll('miembros', $condiciones);

            foreach ($miembros as $m) {

                $condiciones = [
                    'usuario' => $m['usuario'],
                    'tipo_constancia' => 'Miembro_investigador',
                    'red' => $explode_proyecto[3],
                    'anio' => $explode_proyecto[4]
                ];

                if ($this->AdminModel->exist('constancia_' . $explode_proyecto[3], $condiciones)) {

                    $condicionesDeleteConstanciaInvestigador = [
                        'redCueAca' => $pago['claveCuerpo'],
                        'usuario' => $m["usuario"],
                        'tipo_constancia' => 'Miembro_investigador',
                        'red' => $explode_proyecto[3],
                        'anio' => $explode_proyecto[4]
                    ];

                    #QUITAMOS CONSTANCIA DE MIEMBRO IBVESTIGADOR

                    $this->AdminModel->generalDelete('constancia_' . $explode_proyecto[3], $condicionesDeleteConstanciaInvestigador);
                }
            }

            $condicionesDeleteProyecto = [
                'tipo_registro' => 1,
                'claveCuerpo' => $pago['claveCuerpo'],
                'id_proyecto' => $congreso['id'],
            ];
            $this->AdminModel->generalDelete('pagos', $condicionesDeleteProyecto);

            #UNA VEZ QUE YA HICIMOS TODO EL PROCESO, VANOS A INSERTAR LOS DATOS

            $condicionesPagos = ['id' => $pago['id']];

            if ($this->AdminModel->generalUpdate('pagos', $dataPagos, $condicionesPagos)) {

                $condicionesMovimientos = ['id' => $movimiento['id']];

                if ($this->AdminModel->generalUpdate('movimientos', $dataMovimientos, $condicionesMovimientos)) {
                    return redirect()->back()
                        ->with('icon', 'success')
                        ->with('title', 'Exito')
                        ->with('text', 'Se eliminaron las constancias, el proyecto de congreso y se actualizo el restante');
                } else {
                    return redirect()->back()
                        ->with('icon', 'error')
                        ->with('title', 'OJO')
                        ->with('text', 'Se eliminaron constancias, el proyecto de congreso, se actualizo el restante pero hubo error al cambiar el estado del movimiento. ID: ' . $id);
                }
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'OJO')
                    ->with('text', 'Se eliminaron las constancias, el congreso de congreso pero hubo error en actualizar el restante. ID: ' . $id);
            }
        } else if ($tipo_proyecto == 'Congreso') {

            #AQUI SOLAMENTE SE ELIMINA LA CONSTANCIA DE MIEMBRO ASOCIADO

            $condiciones = ['cuerpoAcademico' => $pago['claveCuerpo']];

            $miembros = $this->AdminModel->getAll('miembros', $condiciones);

            foreach ($miembros as $m) {

                $condiciones = [
                    'usuario' => $m['usuario'],
                    'tipo_constancia' => 'Miembro_asociado',
                    'red' => $explode_proyecto[1],
                    'anio' => $explode_proyecto[2]
                ];

                if ($this->AdminModel->exist('constancia_' . $explode_proyecto[1], $condiciones)) {

                    $condicionesDeleteConstanciaAsociado = [
                        'redCueAca' => $pago['claveCuerpo'],
                        'usuario' => $m["usuario"],
                        'tipo_constancia' => 'Miembro_asociado',
                        'red' => $explode_proyecto[1],
                        'anio' => $explode_proyecto[2]
                    ];

                    $this->AdminModel->generalDelete('constancia_' . $explode_proyecto[1], $condicionesDeleteConstanciaAsociado);
                }
            }

            #UNA VEZ QUE YA HICIMOS TODO EL PROCESO, VANOS A INSERTAR LOS DATOS

            $condicionesPagos = ['id' => $pago['id']];

            if ($this->AdminModel->generalUpdate('pagos', $dataPagos, $condicionesPagos)) {

                $condicionesMovimientos = ['id' => $movimiento['id']];

                if ($this->AdminModel->generalUpdate('movimientos', $dataMovimientos, $condicionesMovimientos)) {
                    return redirect()->back()
                        ->with('icon', 'success')
                        ->with('title', 'Exito')
                        ->with('text', 'Se eliminaron las constancias y se actualizo el restante');
                } else {
                    return redirect()->back()
                        ->with('icon', 'error')
                        ->with('title', 'OJO')
                        ->with('text', 'Se eliminaron constancias, se actualizo el restante pero hubo error al cambiar el estado del movimiento. ID: ' . $id);
                }
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'OJO')
                    ->with('text', 'Se eliminaron las constancias pero hubo error en actualizar el restante. ID: ' . $id);
            }
        } else {

            $condicionesPagos = ['id' => $pago['id']];

            if ($this->AdminModel->generalUpdate('pagos', $dataPagos, $condicionesPagos)) {

                $condicionesMovimientos = ['id' => $movimiento['id']];

                if ($this->AdminModel->generalUpdate('movimientos', $dataMovimientos, $condicionesMovimientos)) {
                    return redirect()->back()
                        ->with('icon', 'success')
                        ->with('title', 'Exito')
                        ->with('text', 'Se actualizo el monto correctamente. No hay una accion especial para el proyecto');
                } else {
                    return redirect()->back()
                        ->with('icon', 'error')
                        ->with('title', 'OJO')
                        ->with('text', 'Se actualizo el restante pero hubo error al cambiar el estado del movimiento. ID: ' . $id);
                }
            } else {
                return redirect()->back()
                    ->with('icon', 'error')
                    ->with('title', 'OJO')
                    ->with('text', 'Hubo error en actualizar el restante. ID: ' . $id);
            }
        }
    }

    public function eliminarmultiple()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        $array_ids = $_POST['id'];

        $str_proyectos_eliminados = '';
        //OBTENEMOS LOS DATOS DEL PAGO MEDIANTE EL ID MEDIANTE UN FOREACH QUE 
        //RECORRA EL ARRAY DE EL ARRAY DE IDS
        foreach ($array_ids as $a) {
            $condiciones = ['id' => $a];
            $info = $this->AdminModel->getAllOneRow("pagos", $condiciones);
            $nombre_proyecto = $info['proyecto'];
            $id = $info['id'];
            $delimitante = ' '; // Delimitador para el explode
            $explode = explode($delimitante, $nombre_proyecto);
            $esquema = $explode[0];
            // Eliminar congreso 
            if ($info['restante'] == 0 && $esquema == 'Congreso') {
                //Se hace consulta de la tabla de proyectos
                $id_proyecto = $info['id_proyecto'];
                $condiciones1 = ['id' => $id_proyecto];
                $proyecto = $this->AdminModel->getAllOneRow("proyectos", $condiciones1);
                $red = $proyecto['redCueCa'];
                $anio = $proyecto['anio'];
                $claveCuerpo = $info['claveCuerpo'];
                $tabla = 'constancia_' . ucfirst($red); #constancia_relep  constancia_Relep
                //Condiciones para la tabla de constancia
                $condiciones_constancia_asistencia = [
                    'tipo_constancia' => 'Asistencia',
                    'redCueAca' => $claveCuerpo,
                    'anio' => $anio
                ];
                $condiciones_constancia_ponente = [
                    'tipo_constancia' => 'Ponente',
                    'redCueAca' => $claveCuerpo,
                    'anio' => $anio
                ];
                if (!$this->AdminModel->generalDelete($tabla, $condiciones_constancia_ponente)) {
                    http_response_code(502);
                    echo 'No se ha podido eliminar la constancia de ponente. El ID en cuestion es: ' . $id;
                    exit;
                }
                if (!$this->AdminModel->generalDelete($tabla, $condiciones_constancia_asistencia)) {
                    http_response_code(502);
                    echo 'No se ha podido eliminar la constancia de asistencia. El ID en cuestion es: ' . $id;
                    exit;
                }
            }
            if ($info['restante'] == 0 && $esquema == 'Esquema') {

                //Se hace consulta de la tabla de proyectos
                $id_proyecto = $info['id_proyecto'];
                $condiciones1 = ['id' => $id_proyecto];
                $claveCuerpo = $info['claveCuerpo'];
                $proyecto = $this->AdminModel->getAllOneRow("proyectos", $condiciones1);
                $red = $proyecto['redCueCa'];
                $anio = $proyecto['anio'];
                if (($red == 'Relep' || $red == 'Relen') && ($anio == 2021 || $anio == 2022 || $anio == '2021-2022')) {
                    $anio_constancia = '2021_2022';
                } else {
                    $anio_constancia = $anio;
                }
                $tabla = 'constancia_' . ucfirst($red); #constancia_relep  constancia_Relep
                //Condiciones para la tabla de constancia
                $condiciones_constancia = [
                    'tipo_constancia' => 'Miembro_investigador',
                    'redCueAca' => $claveCuerpo,
                    'anio' => $anio_constancia
                ];

                if (!$this->AdminModel->generalDelete($tabla, $condiciones_constancia)) {
                    http_response_code(502);
                    echo 'No se ha podido eliminar el pago. El ID en cuestion es: ' . $id;
                    exit;
                }
            }
            $claveCuerpo = $info['claveCuerpo'];
            //Se busca la informacion del poryecto dentro de la tabla de pagos.
            //Ojo, no confundir con la tabla de proyectos.
            $condiciones_proyecto = ['id' => $id, 'proyecto' => $nombre_proyecto, 'claveCuerpo' => $claveCuerpo];

            if (!$this->AdminModel->generalDelete('pagos', $condiciones_proyecto)) {
                http_response_code(501);
                echo 'No se ha podido eliminar el pago. El ID en cuestion es: ' . $id;
                exit;
            }
            //Se hacen las condicones para la tabla de movimientos
            $condiciones_movimiento = ['id_pago' => $id];
            if (!$this->AdminModel->generalDelete('movimientos', $condiciones_movimiento)) {
                http_response_code(503);
                echo 'No se ha podido eliminar el pago. El ID en cuestion es: ' . $id;
                exit;
            }

            $str_proyectos_eliminados .= $id . ',';
        }

        $return = [
            'icon' => 'success',
            'title' => 'Funciono',
            'text' => 'Los proyectos ' . $str_proyectos_eliminados . ' se han eliminado correctamente'
        ];
        echo json_encode($return);

        exit;
    }

    public function eliminarMovimiento() {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        // Obtenemos el id de la peticion
        $condiciones = ['id' => $_POST['id']];
        // Sacamos el id_pago para buscar la factura y el comprobante para poder eliminarlo de los archivos
        $columnas = ['id_pago', 'comprobante'];
        $movimientos_info = $this->AdminModel->getColumnsOneRow($columnas, 'movimientos', $condiciones);
        
        if(empty($movimientos_info)){
            //No encontro informacion del movimiento
            http_response_code(700);
            exit;
        }

        //Traernos la clave del cuerpo
        $condiciones = ['id' => $movimientos_info['id_pago']];
        $columnas = ['claveCuerpo'];
        $claveCuerpo = $this->AdminModel->getColumnsOneRow($columnas,'pagos',$condiciones);
        $claveCuerpo = $claveCuerpo['claveCuerpo'];

        //Sacamos la informacion de facturas admin con los datos de la consulta anterior
        $condiciones = ['id_pago' => $movimientos_info['id_pago']];
        $columnas = ['fa.id as id_factura_admin', 'fa.id_factura as id_factura','fa.claveCuerpo as claveCuerpo','fa.tipo as tipo'];
        $facturas_admin_info = $this->AdminModel->getColumnsOneRow($columnas, 'facturas_admin as fa', $condiciones);
        
        /* Antes de eliminar comprobamos si hay datos adicionales que ocupen eliminarse como los datos de facturas y facturas_admin
        en caso de que no haya, eliminamos solo el movimiento junto con el archivo de comprobante,
        este solo se aplica cuando hay un pago donde hay mas de un movimiento en una factura y eliminamos de uno en uno*/

        
        
        if (empty($facturas_admin_info)) {

            $comprobante =  $movimientos_info['comprobante'];
            
            $path_comprobante = FCPATH . 'writable/uploads/comprobantes/' . $comprobante;
            // Verifica si el archivo existe y si es un archivo válido para $path_comprobante
            if (file_exists($path_comprobante) && is_file($path_comprobante)) {
                // Elimina el archivo de comprobante para $path_comprobante si es que existe en el sistema
                unlink($path_comprobante);
            }

            $condiciones = ['id' => $_POST['id']];
            if(!$this->AdminModel->generalDelete('movimientos', $condiciones)){
                http_response_code(701);
                exit;
            }

        }else {
            //http_response_code(301);
            
            //Obtenemos la informacion que necesitamos de la tabla de Facturas
            $condiciones = ['id' => $facturas_admin_info['id_factura']];
            $columnas = ['f.id as factura_id', 'f.id_movimientos as id_movimientos', 'f.csf as csf','f.fecha_insercion as fecha_insercion'];
            $facturas_info = $this->AdminModel->getColumnsOneRow($columnas, 'factura as f', $condiciones);
            $id_movimientos_string = $facturas_info['id_movimientos'];
            $id_movimientos_array = explode(',', $id_movimientos_string);
            
            /* Al momento de insertar el $id_movimientos_string en el $id_movimientos_array,
            este genera un espacio vacío por lo que es necesario borrarlo o generará error */
            if (end($id_movimientos_array) == '') {
                array_pop($id_movimientos_array);
            }

            //Dentro de $info almacenaremos la informacion importante para la elimininacion de los datos
            $info = [];
            //Ciclo pa ra la combinacion de las tablas facturas_admin, facturas y movimientos
            ;
            foreach ($id_movimientos_array as $id_movimiento) {
                $id_movimiento = intval($id_movimiento);
                //Obtenemos la informacion de cada movimiento en el ciclo
                $condiciones = ['id' => $id_movimiento];
                $columnas = ['m.id as id_movimiento', 'm.comprobante as comprobante_movimiento', 'm.id_pago as id_pago'];
                $movimiento_info = $this->AdminModel->getColumnsOneRow($columnas, 'movimientos as m', $condiciones);
                if(empty($movimiento_info)){
                    http_response_code(710);
                    exit;
                }
                
                //Vamos a actualizar el estado de todos los movimientos a 0 para que se establezcan que no se han solicitado nada con ellos
                $facturado = 0;
                $dataMovimientos = ['facturado'=>$facturado];
                
                if(!$this->AdminModel->generalUpdate('movimientos', $dataMovimientos, $condiciones)){
                    //Ocurrio un error al hacer el update de facturado en la tabla de movimintos
                    //echo 'ID de error: '.$id_movimiento;
                    http_response_code(702);
                    exit;
                }
                // Comprueba si el id_movimiento del ciclo coincide con $_POST['id'], combina los datos de ese registro
                if ($movimiento_info['id_movimiento'] == $_POST['id']) {
                    $info = array_merge($facturas_admin_info, $movimiento_info, $facturas_info);
                }
            }
           
            //Se procede a la eliminacion de los datos
            $comprobante = $info['comprobante_movimiento'];
            $path_comprobante = FCPATH . 'writable/uploads/comprobantes/' . $comprobante;
            if(!empty($info['comprobante_movimiento'])){
                // Verifica si el archivo existe y si es un archivo válido
                if (file_exists($path_comprobante) && is_file($path_comprobante)) {
                   // Elimina el archivo de comprobante
                   unlink($path_comprobante);
               }
            }
            
            $csf = $info['csf'];
            $path_csf = FCPATH . 'writable/uploads/csf/' . $csf;
                    
            if(!empty($info['csf'])){
                // Verifica si el archivo existe y si es un archivo válido para $name2
                if (file_exists($path_csf) && is_file($path_csf)) {
                    // Elimina el archivo de comprobante para $name2
                    unlink($path_csf);
                }
            }
      
            //Se procede a eliminar los datos de las tablas
            $condicion1 = ['id'=>$info['id_factura_admin']];
            $condicion2 = ['id'=>$info['id_factura']];
            $condicion3 = ['id'=>$info['id_movimiento']];
            if(!$this->AdminModel->generalDelete('facturas_admin', $condicion1)){
                //return 'error_facturas_admin';
                http_response_code(800);
                exit;
            }
            if(!$this->AdminModel->generalDelete('factura', $condicion2)){
                //return 'error_factura';
                http_response_code(801);
                exit;
            }
            if(!$this->AdminModel->generalDelete('movimientos', $condicion3)){
                //return 'error_movimientos';
                http_response_code(802);
                exit;   
            }
                      
        }

        

        //Obtenemos los correos de los miembros del cuerpo academico para enviarles un correo

        
        $columnas = ['usuario'];
        
        $condiciones = ['cuerpoAcademico' => $claveCuerpo];
        
        
        
        $miembros = $this->AdminModel->getAllColums($columnas,'miembros',$condiciones);
       
        if(empty($miembros)){
            http_response_code(900);
            //echo 'No se ha encontrado miembros de este cuerpo académico. Se ha eliminado la factura.';
            exit;
        }
        
        

        $correos = ['pmejiaa@redesla.la']; #Variable en donde se almacenaran todos los correos a donde se van a enviar
        
        foreach($miembros as $m){
            $condiciones = ['usuario' => $m['usuario']];
            $columnas = ['correo'];
            $usuario = $this->AdminModel->getColumnsOneRow($columnas,'usuarios',$condiciones);
            
            if(!empty($usuario)){
                array_push($correos,$usuario['correo']);
            }
        }

        
        $msj = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';
        $fecha_emision_factura =  $facturas_info['fecha_insercion'];
        $html = "<p>Estimados investigadores del grupo <b>{$claveCuerpo}</b></p>
        <p>
        El Equipo RedesLA informa que su factura emitida el {$fecha_emision_factura} ha sido cancelada y/o eliminada, rectificar sus datos para la solicitud nuevamente.
        </p>
        <p>Detalles:</p>
        <p>{$msj}</p>
        <p>
        Sin más que agregar, quedamos atentos para cualquier duda o comentario al respecto.
        </p>
        <p>
        <b>IMPORTANTE</b>, Cualquier cambio, cancelación o modificación de esta factura deberá solicitarse dentro del mes de pago y emisión de la misma en día hábil, en un horario no mayor a las 15:00 horas (Centro de México).
        </p>";

        $email = \Config\Services::email();
        $email->setFrom('atencion@redesla.la', 'Equipo REDESLA'); //Quien lo manda
        $email->setTo($correos);
        $email->setSubject('Solicitud de movimiento RECHAZADO para corrección'); //Pendiente
        $email->setMessage($html);

        if (!$email->send()) {
            //No se pudieron enviar los correos
            http_response_code(600);
            exit;
        }
                
        return 'success';
    }

    public function updateMov(){
        $data_form = $_POST;

        $condiciones = ['id' => $data_form['id_movimiento']];
        $data = ['movimiento' => '-$'.$data_form['monto']];

        if(!$this->AdminModel->generalUpdate('movimientos',$data,$condiciones)){
            http_response_code(600);
            exit;
        }
    }

    #======================FINNANZAS============================

    #======================PROYECTOS===========================

    public function proyectosAdmin()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/proyectos/lista')
            . view('admin/footers/index');
    }

    public function getListadoproyectosAdmin()
    {

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'nombre', 'redCueCa', 'anio', 'montoMX', 'montoUs', 'activacion_usuarios',
            'precio_prontoPagoMx', 'precio_prontoPagoUs', 'fecha_limite_prontoPago'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM proyectos";
        $sql_data = "SELECT * FROM proyectos";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            $nombre_proyecto = $a['nombre'] . ' ' . $a['redCueCa'] . ' ' . $a['anio'];

            if (empty($a['fecha_limite_prontoPago'])) {
                $prontoPago = '<label class="text-danger">Requerido</label>';
            } else if ($a['fecha_limite_prontoPago'] < date('Y-m-d')) {
                $prontoPago = '<i class="mdi mdi-alert text-warning"></i>' . $a['fecha_limite_prontoPago'];
            } else {
                $prontoPago = '<label class="text-success">' . $a['fecha_limite_prontoPago'] . '</label>';
            }

            $btnActivo = $a['activacion_usuarios'] == 1 ? '<a href="./activar/' . $a['id'] . '" class="btn btn-rounded btn-success">Activo</a>' : '<a href="./activar/' . $a['id'] . '" class="btn btn-rounded btn-danger">Inactivo</a>';

            $htmlEditar = '<a href="./editar/' . $a['id'] . '" class="btn btn-rounded btn-warning">Editar</a>';

            $htmlVerInstrucciones = '<a href="./verInstrucciones/' . $a['id'] . '" class="btn btn-rounded btn-success">Ver instrucciones</a>';

            $array[$key] = [
                'id' => $a['id'],
                'nombre' => $nombre_proyecto,
                'montoMX' => $a['montoMx'],
                'montoUS' => $a['montoUs'],
                'fecha_pronto' => $prontoPago,
                'montoppmx' => $a['precio_prontoPagoMx'],
                'montoppus' => $a['precio_prontoPagoUs'],
                'activo' => $btnActivo,
                'editar' => $htmlEditar,
                'ver_instrucciones' => $htmlVerInstrucciones,
                'eliminar' => ''
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

    public function agregarProyecto()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);
        $data['redes'] = $redes;

        return view('admin/headers/index')
            . view('admin/proyectos/agregar', $data)
            . view('admin/footers/index');
    }

    public function insertProyecto()
    {
        print_r($_POST);
        #VAMOS A VERIFICAR SI YA EXISTE
        $condiciones = [
            'nombre' => $_POST['nombre'],
            'redCueCa' => $_POST['redCueCa'],
            'anio' => $_POST['anio']
        ];

        if ($this->AdminModel->exist('proyectos', $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El proyecto que quiere registrar ya existe');
        }
        $data = $_POST;

        if ($this->AdminModel->generalInsert('proyectos', $data)) {
            return redirect()->to(base_url('admin/proyectos/lista'))
                ->with('icon', 'success')
                ->with('title', 'Éxito')
                ->with('text', 'Proyecto registrado correctamente. Favor de activar si asi lo desea');
        } else {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error al insertar el proyecto. Contacte a sistemas');
        }
    }

    public function activarProyecto($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $columnas = ['activacion_usuarios'];
        $activo = $this->AdminModel->getColumnsOneRow($columnas,'proyectos', $condiciones);
        if ($activo['activacion_usuarios'] == 1) {
            #ACTUALIZAMOS EL ACTIVO EN LA BD Y MANDAMOS PARA ATRAS
            $activo = 0;
            $data1 = ['activacion_usuarios' => $activo];
            if ($this->AdminModel->generalUpdate('proyectos', $data1, $condiciones)) {
                #SE ACTUALIZO, MANDAMOS PARA ATRAS
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Listo')
                    ->with('text', 'Estado desactivado correctamente');
            }
        }else{
            $activo = 1;
            $data2 = ['activacion_usuarios' => $activo];
            if ($this->AdminModel->generalUpdate('proyectos', $data2, $condiciones)) {
                #SE ACTUALIZO, MANDAMOS PARA ATRAS
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Listo')
                    ->with('text', 'Estado activado correctamente');
            }
        }
}

    public function editarProyecto($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $proyecto = $this->AdminModel->getAllOneRow('proyectos', $condiciones);

        if (empty($proyecto)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El proyecto que quiere editar no existe');
        }
        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);

        $data['redes'] = $redes;
        $data['proyecto'] = $proyecto;

        return view('admin/headers/index')
            . view('admin/proyectos/editar', $data)
            . view('admin/footers/index');
    }

    public function verInstruccionesProyecto($id)
    {

        echo 'Pendiente';
    }

    #======================PROYECTOS===========================

    #======================INVESTIGACIONES=========================

    public function investigacionesEquipos($red, $anio)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        #Vamos a mostrar la lista de los equipos de cuestionarios
        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);
        if (array_search($red, array_column($redes, 'nombre_red')) === false) {
            #NO EXISTE LA RED
            return redirect()->back();
        }

        $tabla = 'cuestionarios_' . strtolower($red) . '_' . $anio;
        $db = db_connect('cuestionarios');
        if (!$db->tableExists($tabla)) {
            #NO EXSTE LA TABLA CON ESE AñO
            return redirect()->back();
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
        $condicion = ['estado' => 2];
        $estado_2 = $this->CuestionariosModel->count($tabla, $condicion);
        $condicion = ['estado' => 3];
        $estado_3 = $this->CuestionariosModel->count($tabla, $condicion);
        $condicion = ['estado' => 4];
        $estado_4 = $this->CuestionariosModel->count($tabla, $condicion);
        $condicion = ['estado' => 5];
        $estado_5 = $this->CuestionariosModel->count($tabla, $condicion);

        $data['nombre_tabla'] = $tabla;
        $data['c_cuerpos'] = $c_cuerpos;
        $data['c_encuestas'] = $c_encuestas;
        $data['estado_0'] = $estado_0;
        $data['estado_1'] = $estado_1;
        $data['estado_2'] = $estado_2;
        $data['estado_3'] = $estado_3;
        $data['estado_4'] = $estado_4;
        $data['estado_5'] = $estado_5;

        return view('admin/headers/index')
            . view('admin/investigaciones/listaEquipos', $data)
            . view('admin/footers/index');
    }

    public function getListaInvestigacionesEquipos($tabla)
    {

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'claveCuerpo'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM $tabla";
        $sql_data = "SELECT DISTINCT(claveCuerpo) FROM $tabla";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;

        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv_cuest->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv_cuest->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array
        $explode_tabla = explode('_', $tabla);
        $i = 1;
        foreach ($array as $key => $a) {
            $condiciones = ['claveCuerpo' => $a['claveCuerpo']];
            $columnas = ['nombre', 'redCueCa'];
            $universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

            if (empty($universidad)) {
                $htmlUni = '<label class="text-danger">Universidad sin nombre ingresado. Posible prueba o un error.</label>';
            } else {
                $htmlUni = $universidad['nombre'];
            }
            $condiciones = ['claveCuerpo' => $a['claveCuerpo']];
            $c_total = $this->CuestionariosModel->count($tabla, $condiciones);

            $condiciones = ['estado !=' => 0, 'claveCuerpo' => $a['claveCuerpo']];
            $c_completadas = $this->CuestionariosModel->count($tabla, $condiciones);

            $condiciones = ['claveCuerpo' => $a['claveCuerpo'], 'estado' => 1];
            $estado_1 = $this->CuestionariosModel->count($tabla, $condiciones);

            if (!empty($c_completadas)) {
                $pocentaje_completado = ($estado_1 * 100) / $c_completadas;
                $porcentaje = round($pocentaje_completado, 2);
            } else {
                $porcentaje = 0;
            }



            $color = $porcentaje == 100 ? 'bg-success' : 'bg-warning';
            $htmlPorcentaje = '
                <div class="progress" data-toggle="tooltip" title="' . $porcentaje . '% completado">
                    <div class="progress-bar ' . $color . '" role="progressbar" style="width: ' . $porcentaje . '%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            ';
            $htmlVer = '
            <a href="../../verEquipo/' . $a['claveCuerpo'] . '/' . $tabla . '" class="btn btn-rounded btn-info">Ver datos completos</a>
            ';

            $condiciones = ['claveCuerpo' => $a['claveCuerpo'], 'anio' => $explode_tabla[2]];
            $validacion = $this->AdminModel->getAllOneRow('validacion', $condiciones);
            if (!empty($validacion)) {
                switch ($validacion['terminado']) {
                    case 1:
                        $estado = '<label class="text-warning">El equipo envio sus encuestas a revisión.</label>';
                        break;
                    case 2:
                        $estado = '<label class="text-success">Encuestas validadas</label>';
                        break;
                    case 3:
                        $estado = '<label class="text-primary">El equipo esta atendiendo las observaciones.</label>';
                        break;
                    default:
                        $estado = '<label class="text-danger">Estado sin definir</label>';
                        break;
                }
            } else {
                $estado = '<label class="text-secondary">El equipo no ha enviado sus encuestas a revisión.</label>';
            }

            $array[$key] = [
                'id' => $i,
                'claveCuerpo' => $a['claveCuerpo'],
                'universidad' => $htmlUni,
                'c_encuestas' => $c_total,
                'porcentaje' => $htmlPorcentaje,
                'estado' => $estado,
                'ver' => $htmlVer
            ];
            $i++;
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

    public function getExcelEquipos($tabla)
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $explode_tabla = explode('_', $tabla);

        $red = ucfirst($explode_tabla[1]);

        $headerExcel = ['Clave del grupo de investigación', 'Nombre de la universidad'];

        $condiciones = ['nombre_red' => $red];
        $red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $color = $red['color_primario'];

        $color = str_replace('#', '', $color);
        $color = strtoupper($color);

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

        $condiciones = [];
        $columnas = ['claveCuerpo'];
        $cuerpos = $this->CuestionariosModel->getAllDistinc($columnas, $tabla, $condiciones);

        $arr_respuestas = [];
        $inicio = 2;
        foreach ($cuerpos as $c) {
            $condiciones = ['claveCuerpo' => $c['claveCuerpo']];
            $columnas = ['nombre'];
            $universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
            $nombre_uni = empty($universidad) ? 'Sin registro. Posible prueba o error.' : $universidad['nombre'];
            array_push($arr_respuestas, $c['claveCuerpo']);
            array_push($arr_respuestas, $nombre_uni);
            $sheet->fromArray([$arr_respuestas], NULL, 'A' . $inicio);
            $arr_respuestas = [];
            $inicio++;
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $archivo = 'Grupos_investigacion_' . $explode_tabla[1] . '_' . $explode_tabla[2] . '.xlsx"';

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $archivo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function getExcelEncuestas($tabla)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #HACEMOS LAS CONDICIONES PARA SACAR LAS PREGUNTAS DE LA INVESTIGACION
        $explode_tabla = explode('_', $tabla);
        $condiciones = [
            'red' => $explode_tabla[1],
            'anio' => $explode_tabla[2]
        ];
        $preguntas = $this->CuestionariosModel->getAll('preguntas_cuestionarios', $condiciones);

        #SI NO EXISTEN LO REGRESAMOS
        if (empty($preguntas)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Trabajando...')
                ->with('text', 'El archivo aún no esta disponible.');
        }
        #VERIFICAMOS SI LA RUTA EN DONDE VAMOS A GUARDAR LOS ARCHIVOS EXISTA, SINO, LA CREAMOS CON MKDIR
        if (!file_exists(ROOTPATH . 'public/csv/investigaciones/' . $explode_tabla[2] . '/' . ucfirst($explode_tabla[1]))) {
            mkdir(ROOTPATH . 'public/csv/investigaciones/' . $explode_tabla[2] . '/' . ucfirst($explode_tabla[1]), 0777, true);
        }

        #HACEMOS EL ARREGLO DEL HEADER DEL ARCHIVO
        $headerCsv = [];
        foreach ($preguntas as $p) {
            array_push($headerCsv, $p['nombre']);
        }

        #NOS TRAEMOS TODOS LOS REGISTROS DE LA INVESTIGACION
        $condiciones = [];
        $getAllEncuestas = $this->CuestionariosModel->getAll($tabla, $condiciones);

        $tamano_lote = 10000; #DECLARAMOS EL TAMAñO POR HOJA
        $num_lotes = ceil(count($getAllEncuestas) / $tamano_lote); // CALCULAMOS EL NUMERO DE LOTES NECESARIOS

        #VARIABLES PARA DARLE EL NOMBRE AL ARCHIVO CSV
        $len_inicio = 1;
        $len_final = $tamano_lote;

        #IMPORTAMOS LA LIRERIA QUE USAREMOS PARA CREAR EL ARCHIVO ZIP
        $zipFile = new \PhpZip\ZipFile();

        #RECORREMOS LOS LOTES

        for ($i = 0; $i < $num_lotes; $i++) {
            #OBTENEMOS EL LOTE ACTUAL, QUE ES SLICE AL ARRAY DE TODAS LAS ENCUESTAS Y LO DIVIDE POR EL TAMAÑO DEL LOTE
            $lote = array_slice($getAllEncuestas, $i * $tamano_lote, $tamano_lote);
            #ESTABLECEMOS EL NOMBRE DEL ARCHIVO Y LA RUTA

            $csv_filename =  'Investigación-' . strtoupper($explode_tabla[1]) . '-' . $explode_tabla[2] . '-' . $len_inicio . '-' . $len_final . '.csv'; // Crear un nombre de archivo único
            $ruta = ROOTPATH . 'public/csv/investigaciones/' . $explode_tabla[2] . '/' . ucfirst($explode_tabla[1]) . '/' . $csv_filename;
            #ABRIVOS EL ARCHIVO PARA ESCRITURA
            $csv_handler = fopen($ruta, 'w');
            #ESTO ES PARA LOS CARACTERES UTF-8.
            fprintf($csv_handler, chr(0xEF) . chr(0xBB) . chr(0xBF));
            #AGREGAMOS EL ARRAY DE LOS ENCABEZADOS
            fputcsv($csv_handler, $headerCsv);
            #RECORREMOS EL LOTE Y OBTENDREMOS REGISTRO POR REGISTRO LA INFORMACION
            foreach ($lote as $fila) {
                #FORMATEAMOS LA INFORMACION Y OBTENEMOS EL VALOR QUE DEBE TENER LA COLUMNA
                $data = [];
                foreach ($preguntas as $p) {
                    array_push($data, $fila[$p['inciso']]);
                }
                #ESCRIBIMOS LO QUE FORMATEAMOS EN UNA NUEVA FILA EN EL CSV
                fputcsv($csv_handler, $data);
            }
            #CUANDO FINALIZE EL LOTE CERRAMOS EL ARCHIVO
            fclose($csv_handler);
            #AGREGAMOS EL ARCHIVO CREADO AL ARCHIVO ZIP
            $zipFile->addFile($ruta);
            #CAMBIO DE NOMBRE DE VARIABLES PARA EL NOMBRE DEL DOCUMENTO
            $len_inicio = $len_final + 1;
            $len_final = $len_inicio + 999;
        }
        #LE DESCARGAMOS EL ARCHIVO ZIP CREADO AL USUARIO
        $zipFile->outputAsAttachment(mb_strtoupper($tabla) . '.zip');
        return;



        $spreadsheet = new Spreadsheet();
        #$sheet = $spreadsheet->getActiveSheet();

        // Crea una nueva hoja y escribe los datos en cada grupo
        for ($i = 1; $i < count($data_groups); $i++) {
            // Crea una nueva hoja
            $spreadsheet->createSheet($i);
            $spreadsheet->setActiveSheetIndex($i);

            // Escribe los datos en la hoja
            $spreadsheet->getActiveSheet()->fromArray($data_groups[$i], null, 'A1');
        }

        // Guarda el archivo Excel
        $writer = new Xlsx($spreadsheet);
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $writer->save('archivo.xlsx');


        echo '<pre>';
        //print_r($data_groups);
        echo '</pre>';
        return;
        #$getAllEncuestas = array_slice($getAllEncuestas, 0, 100); #<--

        $condiciones = ['nombre_red' => ucfirst($explode_tabla[1])];

        $red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $color = $red['color_primario'];

        $color = str_replace('#', '', $color);
        $color = strtoupper($color);

        #CON EL SIGUIENTE FOREACH OBTENEMOS LAS PREGUNTAS, DEBE SER UN ARRAY UNIDIMENSIONAL

        /*
        $asentamientos = $this->CuestionariosModel->getAll('asentamientos',[]);
        $conglomerados = $this->CuestionariosModel->getAll('conglomerados',[]);
        $pisos = $this->CuestionariosModel->getAll('pisos',[]);
        $estrategias = $this->CuestionariosModel->getAll('estrategias',[]);
        $problematicas = $this->CuestionariosModel->getAll('problematicas',[]);
        $concentracion_empresas = $this->CuestionariosModel->getAll('concentracion_empresas',[]);
        $nivel_estudios = $this->CuestionariosModel->getAll('nivel_estudios',[]);
        $estado_civil = $this->CuestionariosModel->getAll('estado_civil',[]);

        function asociacion($valor,$pais){
            if($pais == 2){
                $arr_valores = [
                    'Está constituida como empresa (S.A., S.R., etc.).' => 'a',
                    'Empresa con una persona propietaria sin registro en la Secretaría de Hacienda.' => 'b',
                    'Empresa con varias personas propietarias sin registro en la Secretaría de Hacienda.' => 'c',
                    'Persona física con actividad empresarial.' => 'd',
                    'Régimen de incorporación fiscal.' => 'e',
                    'Servicios profesionales (registrado).' => 'f'
                ];
                return array_key_exists($valor,$arr_valores) ? $arr_valores[$valor]: 'Asociación no encontrado. Favor de notificar a sistemas.';
            }
        }

        function vialidad($valor,$pais){
            if($pais == 2){
                $arr_valores = [
                    'Ampliación' => 'a',
                    'Andador' => 'b',
                    'Avenida' => 'c',
                    'Boulevard' => 'd',
                    'Calle' => 'e',
                    'Callejón' => 'f',
                    'Calzada' => 'g',
                    'Cerrada' => 'h',
                    'Circuito' => 'i',
                    'Circunvalación' => 'j',
                    'Continuación' => 'k',
                    'Corredor' => 'l',
                    'Diagonal' => 'm',
                    'Eje vial' => 'n',
                    'Pasaje' => 'o',
                    'Peatonal' => 'p',
                    'Periférico' => 'q',
                    'Privada' => 'r',
                    'Prolongación' => 's',
                    'Retorno' => 't',
                    'Viaducto' =>'u',
                    'Carretera' => 'v',
                    'Camino' => 'w',
                    'Terracería' => 'x',
                    'Brecha' => 'y',
                    'Vereda' => 'z'
                ];
                switch($valor){
                    case 'Na':
                        return 'No aplica vialidad posterior.';
                        break;
                    case '':
                        return 'Pregunta no contestada.';
                        break;
                    default:
                        return array_key_exists($valor,$arr_valores) ? $arr_valores[$valor] : 'Vialidad no encontrado. Favor de notificar a sistemas';
                        break;
                }
                
            }
        }

        function asentamientos($valor,$pais,$asentamientos){
            if($pais == 2){
                $key = array_search($valor, array_column($asentamientos, 'nombre'));
                if($key == ''){
                    return 'Asentamiento no encontrado. Favor de notificar a sistemas.';
                }
                return $asentamientos[$key]['id'];
            }
        }

        function conglomerados($valor,$pais,$conglomerados){
            if($pais == 2){
                $key = array_search($valor, array_column($conglomerados, 'nombre'));
                if($key == ''){
                    return 'Conglomerado no encontrado. Favor de notificar a sistemas.';
                }
                $num = preg_replace('/[^0-9]/', '', $conglomerados[$key]['nombre']);  
                return $num;
            }
        }

        function pisos($valor,$pais,$pisos){
            if($pais == 2){
                $key = array_search($valor, array_column($pisos, 'nombre'));
                if($key == ''){
                    return 'Piso no encontrado o no contestado. Favor de notificar a sistemas.';
                }
                $num = preg_replace('/[^0-9]/', '', $pisos[$key]['nombre']);  
                return $num;
            }
        }

        function tipo_comercio($valor,$pais){
            if($pais == 2){
                $arr_valores = [
                    'comerciante_fijo' => 'a',
                    'puesto_semifijo' => 'b'
                ];
                return array_key_exists($valor,$arr_valores) ? $arr_valores[$valor]: 'Tipo de comercio no encontrado. Favor de notificar a sistemas.';
            }
        }

        function giro($valor,$pais){
            if($pais == 2){
                $arr_valores = [
                    'Comercio' => 'a',
                    'Servicios' => 'b',
                    'Manufactura' => 'c'
                ];
                return array_key_exists($valor,$arr_valores) ? $arr_valores[$valor]: 'Giro no encontrado. Favor de notificar a sistemas.';
            }
        }

        function fundacion($valor,$pais){
            if($pais == 2){
                $arr_valores = [
                    'Primera generación (yo fundé la empresa)' => 'a',
                    'Segunda generación (la fundó uno de mis padres o hermanos)' => 'b',
                    'Tercera generación (la fundó uno de mis abuelos)' => 'c',
                    'Otra persona que no es mi familia.' => 'd'
                ];
                return array_key_exists($valor,$arr_valores) ? $arr_valores[$valor]: 'Fundación no encontrado. Favor de notificar a sistemas.';
            }
        }

        function estrategias($valor,$pais,$estrategias){
            if($pais == 2){
                $key = array_search($valor, array_column($estrategias, 'nombre'));
                if($key == ''){
                    return 'Estrategia no encontrado. Favor de notificar a sistemas.';
                }
                return $estrategias[$key]['inciso'];
            }
        }

        function problematicas($valor,$pais,$problematicas){
            if($pais == 2){
                $key = array_search($valor, array_column($problematicas, 'nombre'));
                if($key == ''){
                    return 'Problematica no encontrado. Favor de notificar a sistemas.';
                }
                return $problematicas[$key]['inciso'];
            }
        }

        function propiedad_empresa($valor,$pais){
            if($pais == 2){
                $arr_valores = [
                    'Tuya' => 'a',
                    'De tu familia' => 'b',
                    'De otra persona que no es mi familia' => 'c'
                ];
                return array_key_exists($valor,$arr_valores) ? $arr_valores[$valor]: 'Propiedad de la empresa no encontrado. Favor de notificar a sistemas.';
            }
        }

        function concentracion_empresas($valor,$pais,$concentracion_empresas){
            if($pais == 2){
                $key = array_search($valor, array_column($concentracion_empresas, 'nombre'));
                if($key == ''){
                    return 'Concentración no encontrado. Favor de notificar a sistemas.';
                }
                return $concentracion_empresas[$key]['inciso'];
            }
        }

        function nivel_estudios($valor,$pais,$nivel_estudios){
            if($pais == 2){
                $key = array_search($valor, array_column($nivel_estudios, 'nombre'));
                if($key == ''){
                    return 'Nivel de estudios no encontrado. Favor de notificar a sistemas.';
                }
                return $nivel_estudios[$key]['inciso'];
            }
        }

        function estado_civil($valor,$pais,$estado_civil){
            if($pais == 2){
                $key = array_search($valor, array_column($estado_civil, 'nombre'));
                if($key == ''){
                    return 'Estado civíl no encontrado. Favor de notificar a sistemas.';
                }
                return $estado_civil[$key]['inciso'];
            }
        }

        function sexo($valor,$pais){
            $arr_valores = [
                'Hombre' => 'a',
                'Mujer' => 'b'
            ];
            return array_key_exists($valor,$arr_valores) ? $arr_valores[$valor]: 'Sexo no encontrado. Favor de notificar a sistemas.';
        }

        function horas_promedio($valor){
            $arr_valores = [
                'Nada de tiempo' => '0',
                'Hasta 3 horas' => 'a',
                'Hasta 6 horas' => 'b',
                'Hasta 9 horas' => 'c',
                'Hasta 12 horas' => 'd',
                'Hasta 15 horas' => 'e',
                'Más de 16 horas al día' => 'f'
            ];
            return array_key_exists($valor,$arr_valores) ? $arr_valores[$valor]: 'Horas promedio no encontrado. Favor de notificar a sistemas.';
        }

        function getEstado($estado){
            switch($estado){
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
        */
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
        $ciclo = 0;
        $len_inicio = 1;
        $len_final = 1000;
        $name_archivo_ind = date("Y-m-d_h-i-sa") . '-' . $len_inicio . '-' . $len_final . '.xlsx';



        foreach ($getAllEncuestas as $e) {
            $folio = $e['folio'];
            $estado = $e['estado'];
            array_push($arr_respuestas, $folio);
            array_push($arr_respuestas, $estado);
            foreach ($preguntas as $p) {
                $pregunta_solo_num = preg_replace('/[^0-9]/', '', $p['inciso']);
                if (ucfirst($explode_tabla[1]) == 'Relayn' && $explode_tabla[2] == 2023) {

                    $valores = [
                        '4' => 'Muy de acuerdo',
                        '3' => 'De acuerdo',
                        '2' => 'En desacuerdo',
                        '1' => 'Muy en desacuerdo',
                        'nc' => 'No sé / No aplica'
                    ];
                    if ($pregunta_solo_num >= 9 && $pregunta_solo_num <= 28) {
                        $valor_pregunta = array_key_exists($e[$p['inciso']], $valores) ? $valores[$e[$p['inciso']]] : 'Valor numerico no registrado';
                        array_push($arr_respuestas, $valor_pregunta);
                    } else if ($p['inciso'] == 'nombre_localidad') {
                        $columnas = ['nombre_localidad'];
                        $condiciones = [
                            'clave_localidad' => trim($e['clave_localidad']),
                            'clave_estado' => trim($e['clave_estado']),
                            'clave_municipio' => trim($e['clave_municipio'])
                        ];
                        $nombre_localidad = $this->CuestionariosModel->getColumnsOneRow($columnas, 'localidades', $condiciones);
                        if (empty($nombre_localidad)) {
                            $n_loc = 'No registrado o no encontrado.';
                        } else {
                            $n_loc = $nombre_localidad['nombre_localidad'];
                        }
                        array_push($arr_respuestas, $n_loc);
                    } else {

                        $condiciones = ['claveCuerpo' => $e['claveCuerpo']];
                        $columnas = ['pais'];
                        $pais = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

                        /*
                        switch($p['inciso']){
                            case '1b':
                                $valor_pregunta = asociacion($e[$p['inciso']],$pais['pais']);
                                break;
                            case '1e':
                                $valor_pregunta = vialidad(ucfirst(mb_strtolower($e[$p['inciso']])),$pais['pais']);
                                break;
                            case '1i':
                                $valor_pregunta = asentamientos(ucfirst(mb_strtolower($e[$p['inciso']])),$pais['pais'],$asentamientos);
                                break;
                            case 'tipo_conglomerado':
                                $valor_pregunta = conglomerados($e[$p['inciso']],$pais['pais'],$conglomerados);
                                break;
                            case 'tipo_vialidad_1':
                                $valor_pregunta = vialidad(ucfirst(mb_strtolower($e[$p['inciso']])),$pais['pais']);
                                break;
                            case 'tipo_vialidad_2':
                                $valor_pregunta = vialidad(ucfirst(mb_strtolower($e[$p['inciso']])),$pais['pais']);
                                break;
                            case 'tipo_vialidad_posterior':
                                $valor_pregunta = vialidad(ucfirst(mb_strtolower($e[$p['inciso']])),$pais['pais']);
                                break;
                            case 'piso_empresa':
                                $valor_pregunta = pisos($e[$p['inciso']],$pais['pais'],$pisos);
                                break;
                            case 'tipo_comercio':
                                $valor_pregunta = tipo_comercio($e[$p['inciso']],$pais['pais']);
                                break;
                            case '1q':
                                $valor_pregunta = giro($e[$p['inciso']],$pais['pais']);
                                break;
                            case '2b':
                                $valor_pregunta = fundacion($e[$p['inciso']],$pais['pais']);
                                break;
                            case '2c':
                                $valor_pregunta = estrategias($e[$p['inciso']],$pais['pais'],$estrategias);
                                break;
                            case '2d':
                                $valor_pregunta = problematicas($e[$p['inciso']],$pais['pais'],$problematicas);
                                break;
                            case '2e':
                                $valor_pregunta = concentracion_empresas($e[$p['inciso']],$pais['pais'],$concentracion_empresas);
                                break;
                            case '2f':
                                $valor_pregunta = propiedad_empresa($e[$p['inciso']],$pais['pais']);
                                break;
                            case '7a':
                                $valor_pregunta = nivel_estudios($e[$p['inciso']],$pais['pais'],$nivel_estudios);
                                break;
                            case '7d':
                                $valor_pregunta = sexo($e[$p['inciso']],$pais['pais']);
                                break;
                            case '7f':
                                $valor_pregunta = estado_civil($e[$p['inciso']],$pais['pais'],$estado_civil);
                                break;
                            case '8b':
                                $valor_pregunta = horas_promedio($e[$p['inciso']]);
                                break;
                            case '8e':
                                $valor_pregunta = horas_promedio($e[$p['inciso']]);
                                break;
                            case '8f':
                                $valor_pregunta = horas_promedio($e[$p['inciso']]);
                                break;
                            default:
                                $valor_pregunta = ucfirst($e[$p['inciso']]);
                                break;
                        }
                        */
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
                                $datos = $this->db_serv_cuest->query($consulta)->getResult();
                                $array = json_decode(json_encode($datos), true);
                                $str_scian .= $array[0]['nombre'] . ', ';
                            }
                            $valor_pregunta = rtrim($str_scian, ', ');
                        }

                        array_push($arr_respuestas, $valor_pregunta);
                    }
                } else if (ucfirst($explode_tabla[1]) == 'Relen' && $explode_tabla[2] == 2023) {
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
                        $valor_pregunta = $valores_1[$e[$p['inciso']]];
                        array_push($arr_respuestas, $valor_pregunta);
                    } else if ($pregunta_solo_num >= 48 && $pregunta_solo_num <= 50) {
                        $valor_pregunta = $valores_2[$e[$p['inciso']]];
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
                } else if (ucfirst($explode_tabla[1]) == 'Relep' && $explode_tabla[2] == 2023) {
                    $valores = [
                        '4' => 'Muy de acuerdo',
                        '3' => 'De acuerdo',
                        '2' => 'En desacuerdo',
                        '1' => 'Muy en desacuerdo',
                        'nc' => 'No sé / No aplica'
                    ];
                    if ($pregunta_solo_num >= 16 && $pregunta_solo_num <= 26) {
                        $valor_pregunta = $valores[$e[$p['inciso']]];
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

            $ciclo++;
            $sheet->fromArray([$arr_respuestas], NULL, 'A' . $inicio);
            $arr_respuestas = [];
            $inicio++;

            if ($ciclo >= 1000) {
                $ciclo = 0;
                $inicio = 2;
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $ruta = ROOTPATH . 'public/excel/' . $name_archivo_ind;
                $len_inicio = $len_final + 1;
                $len_final = $len_inicio + 999;
                $name_archivo_ind = date("Y-m-d_h-i-sa") . '-' . $len_inicio . '-' . $len_final . '.xlsx';
                $writer->save($ruta);
                $zipFile->addFile($ruta);

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
            }
        }
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $ruta = ROOTPATH . 'public/excel/' . $name_archivo_ind;
        $len_inicio = $len_final + 1;
        $len_final = $len_inicio + 999;
        $name_archivo_ind = date("Y-m-d_h-i-sa") . '-' . $len_inicio . '-' . $len_final . '.xlsx';
        $writer->save($ruta);
        $zipFile->addFile($ruta);

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

        $zipFile->outputAsAttachment($tabla . '.zip');
        exit;


        /*
        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $nombre_archivo = 'Encuestas_'.ucfirst($explode_tabla[1]).'_'.$explode_tabla[2];
        
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$nombre_archivo.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');



        */
    }

    public function getExcelEncuestasEquipo($tabla, $claveCuerpo)
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $explode_tabla = explode('_', $tabla);

        $condiciones = [
            'red' => $explode_tabla[1],
            'anio' => $explode_tabla[2],
            'pais' => 2
        ];

        $preguntas = $this->CuestionariosModel->getAll('preguntas_cuestionarios', $condiciones);

        if (empty($preguntas)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Trabajando...')
                ->with('text', 'El archivo aún no esta disponible.');
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['pais'];
        $pais_ca = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
        $pais_ca = $pais_ca['pais'];

        if ($pais_ca != 2) {
            $condiciones = [
                'red' => $explode_tabla[1],
                'anio' => $explode_tabla[2],
                'pais' => $pais_ca
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
                switch ($pais_ca) {
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

        $condiciones = ['claveCuerpo' => $claveCuerpo];

        $getAllEncuestas = $this->CuestionariosModel->getAll($tabla, $condiciones);

        $condiciones = ['nombre_red' => ucfirst($explode_tabla[1])];

        $red = $this->AdminModel->getAllOneRow('redes', $condiciones);

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
                if (ucfirst($explode_tabla[1]) == 'Relayn' && $explode_tabla[2] == 2023) {
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
                    } else if ($p['inciso'] == 'nombre_localidad') {
                        $columnas = ['nombre_localidad'];
                        $condiciones = [
                            'clave_localidad' => trim($e['clave_localidad']),
                            'clave_estado' => trim($e['clave_estado']),
                            'clave_municipio' => trim($e['clave_municipio'])
                        ];
                        $nombre_localidad = $this->CuestionariosModel->getColumnsOneRow($columnas, 'localidades', $condiciones);
                        if (empty($nombre_localidad)) {
                            $n_loc = 'No registrado o no encontrado.';
                        } else {
                            $n_loc = $nombre_localidad['nombre_localidad'];
                        }
                        array_push($arr_respuestas, $n_loc);
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
                                $datos = $this->db_serv_cuest->query($consulta)->getResult();

                                ##############################
                                if (empty($datos)) {
                                    $consulta = 'SELECT * FROM comun_codigo_ciiu WHERE codigo = "' . $value_1r . '"';
                                    $datos = $this->db_serv_cuest->query($consulta)->getResult();
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
                                #############################
                            }
                            $valor_pregunta = rtrim($str_scian, ', ');
                        }
                        array_push($arr_respuestas, $valor_pregunta);
                    }
                } else if (ucfirst($explode_tabla[1]) == 'Relen' && $explode_tabla[2] == 2023) {
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
                } else if (ucfirst($explode_tabla[1]) == 'Relep' && $explode_tabla[2] == 2023) {
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

        #$nombre_archivo = 'Encuestas_'.ucfirst($explode_tabla[1]).'_'.$explode_tabla[2];
        $nombre_archivo = 'Encuestas_' . $claveCuerpo . '_' . ucfirst($explode_tabla[1]) . '_' . $explode_tabla[2];

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_archivo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function getExcelEncuestasEquipoValidos($tabla, $claveCuerpo)
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $explode_tabla = explode('_', $tabla);

        $condiciones = [
            'red' => $explode_tabla[1],
            'anio' => $explode_tabla[2],
            'pais' => 2
        ];

        $preguntas = $this->CuestionariosModel->getAll('preguntas_cuestionarios', $condiciones);

        if (empty($preguntas)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Trabajando...')
                ->with('text', 'El archivo aún no esta disponible.');
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['pais'];
        $pais_ca = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
        $pais_ca = $pais_ca['pais'];

        if ($pais_ca != 2) {
            $condiciones = [
                'red' => $explode_tabla[1],
                'anio' => $explode_tabla[2],
                'pais' => $pais_ca
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
                switch ($pais_ca) {
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

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'estado' => 1];

        $getAllEncuestas = $this->CuestionariosModel->getAll($tabla, $condiciones);

        $condiciones = ['nombre_red' => ucfirst($explode_tabla[1])];

        $red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $color = $red['color_primario'];

        $color = str_replace('#', '', $color);
        $color = strtoupper($color);

        #CON EL SIGUIENTE FOREACH OBTENEMOS LAS PREGUNTAS, DEBE SER UN ARRAY UNIDIMENSIONAL
        $headerExcel = ['Folio', 'Estado'];
        foreach ($preguntas as $p) {
            array_push($headerExcel, $p['nombre']);
        }

        #echo '<pre>';
        #print_r($headerExcel);
        #echo '</pre>';
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

        foreach ($getAllEncuestas as $e) {
            $folio = $e['folio'];
            $estado = $e['estado'];
            array_push($arr_respuestas, $folio);
            array_push($arr_respuestas, $estado);
            foreach ($preguntas as $p) {
                $pregunta_solo_num = preg_replace('/[^0-9]/', '', $p['inciso']);
                if (ucfirst($explode_tabla[1]) == 'Relayn' && $explode_tabla[2] == 2023) {
                    $valores = [
                        '4' => 'Muy de acuerdo',
                        '3' => 'De acuerdo',
                        '2' => 'En desacuerdo',
                        '1' => 'Muy en desacuerdo',
                        'nc' => 'No sé / No aplica'
                    ];
                    if ($pregunta_solo_num >= 9 && $pregunta_solo_num <= 28) {
                        $valor_pregunta = $valores[$e[$p['inciso']]];
                        array_push($arr_respuestas, $valor_pregunta);
                    } else if ($p['inciso'] == 'nombre_localidad') {
                        $columnas = ['nombre_localidad'];
                        $condiciones = [
                            'clave_localidad' => trim($e['clave_localidad']),
                            'clave_estado' => trim($e['clave_estado']),
                            'clave_municipio' => trim($e['clave_municipio'])
                        ];
                        $nombre_localidad = $this->CuestionariosModel->getColumnsOneRow($columnas, 'localidades', $condiciones);
                        if (empty($nombre_localidad)) {
                            $n_loc = 'No registrado o no encontrado.';
                        } else {
                            $n_loc = $nombre_localidad['nombre_localidad'];
                        }
                        array_push($arr_respuestas, $n_loc);
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
                                $datos = $this->db_serv_cuest->query($consulta)->getResult();
                                $array = json_decode(json_encode($datos), true);
                                $str_scian .= $array[0]['nombre'] . ', ';
                            }
                            $valor_pregunta = rtrim($str_scian, ', ');
                        }
                        array_push($arr_respuestas, $valor_pregunta);
                    }
                } else if (ucfirst($explode_tabla[1]) == 'Relen' && $explode_tabla[2] == 2023) {
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
                        $valor_pregunta = $valores_1[$e[$p['inciso']]];
                        array_push($arr_respuestas, $valor_pregunta);
                    } else if ($pregunta_solo_num >= 48 && $pregunta_solo_num <= 50) {
                        $valor_pregunta = $valores_2[$e[$p['inciso']]];
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
                } else if (ucfirst($explode_tabla[1]) == 'Relep' && $explode_tabla[2] == 2023) {
                    $valores = [
                        '4' => 'Muy de acuerdo',
                        '3' => 'De acuerdo',
                        '2' => 'En desacuerdo',
                        '1' => 'Muy en desacuerdo',
                        'nc' => 'No sé / No aplica'
                    ];
                    if ($pregunta_solo_num >= 16 && $pregunta_solo_num <= 26) {
                        $valor_pregunta = $valores[$e[$p['inciso']]];
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

        #$nombre_archivo = 'Encuestas_'.ucfirst($explode_tabla[1]).'_'.$explode_tabla[2];
        $nombre_archivo = 'Encuestas_Validas_' . $claveCuerpo . '_' . ucfirst($explode_tabla[1]) . '_' . $explode_tabla[2];

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_archivo . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function verEquipoInvestigacion($claveCuerpo, $tabla)
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        $condiciones = ['claveCuerpo' => $claveCuerpo];

        if (!$this->AdminModel->exist('cuerpos_academicos', $condiciones)) {
            echo 'No existe el cuerpo academico';
            return redirect()->back();
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => date('Y')];
        $validacion = $this->AdminModel->getAllOneRow('validacion', $condiciones);
        $anio = date('Y');
        $consulta = 'SELECT * FROM mensajes_CA WHERE claveCuerpo = "' . $claveCuerpo . '" AND fechaExpiracion LIKE "%' . $anio . '%"';
        $mensajes = $this->db_serv->query($consulta)->getResult();
        $mensajes = json_decode(json_encode($mensajes), true);


        if (!empty($validacion)) {
            switch ($validacion['terminado']) {
                case 2:
                    $data['validar'] = 'disabled';
                    $data['reenviar'] = '';
                    break;
                case 3:
                    $data['validar'] = '';
                    $data['reenviar'] = 'disabled';
                    break;
                default:
                    $data['validar'] = '';
                    $data['reenviar'] = '';
                    break;
            }
        } else {
            $data['validar'] = '';
            $data['reenviar'] = '';
        }
        $condiciones = ['estado' => 0];
        $estado_0 = $this->CuestionariosModel->count($tabla, $condiciones);
        $condiciones = ['claveCuerpo' => $claveCuerpo, 'estado' => 1];
        $estado_1 = $this->CuestionariosModel->count($tabla, $condiciones);
        $condiciones = ['claveCuerpo' => $claveCuerpo, 'estado' => 2];
        $estado_2 = $this->CuestionariosModel->count($tabla, $condiciones);
        $condiciones = ['claveCuerpo' => $claveCuerpo, 'estado' => 3];
        $estado_3 = $this->CuestionariosModel->count($tabla, $condiciones);
        $condiciones = ['claveCuerpo' => $claveCuerpo, 'estado' => 4];
        $estado_4 = $this->CuestionariosModel->count($tabla, $condiciones);
        $condiciones = ['claveCuerpo' => $claveCuerpo, 'estado' => 5];
        $estado_5 = $this->CuestionariosModel->count($tabla, $condiciones);

        $data['nombre_tabla'] = $tabla;
        $data['claveCuerpo'] = $claveCuerpo;
        $data['mensajes'] = $mensajes;
        $data['estado_0'] = $estado_0;
        $data['estado_1'] = $estado_1;
        $data['estado_2'] = $estado_2;
        $data['estado_3'] = $estado_3;
        $data['estado_4'] = $estado_4;
        $data['estado_5'] = $estado_5;

        return view('admin/headers/index')
            . view('admin/investigaciones/equipo', $data)
            . view('admin/footers/index');
    }

    public function getListaInvestigacionesEquipo($tabla, $claveCuerpo)
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'folio', 'nombre_encuestador', 'estado'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM $tabla";
        $sql_data = "SELECT * FROM $tabla";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    #$condicion .= " WHERE ".$val." LIKE '%".$valor_buscado."%'";
                    $condicion .= ' WHERE (claveCuerpo = "' . $claveCuerpo . '") AND ( ' . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = empty($condicion) ? $sql_count . ' WHERE claveCuerpo = "' . $claveCuerpo . '"' : $sql_count . $condicion . ')';

        $sql_data =  !empty($condicion) ? $sql_data . $condicion . ')' : $sql_data . ' WHERE claveCuerpo = "' . $claveCuerpo . '"';

        $total_count = $this->db_serv_cuest->query($sql_count)->getRow();


        /*
        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();
        */

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv_cuest->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        $explode_tabla = explode('_', $tabla);

        foreach ($array as $key => $a) {

            switch ($a['estado']) {
                case 0:
                    $htmlEstado = '<i class="mdi mdi-color-helper"></i> Cuestionario solo ingresado. Realizar acciones';
                    break;
                case 1:
                    $htmlEstado = '<i class="mdi mdi-check-circle text-success"></i> El cuestionario es válido y debe ser considerado.';
                    break;
                case 2:
                    $htmlEstado = '<i class="mdi mdi-alert text-warning"></i> El cuestionario tiene más de 20 ítem erróneos o vacíos (incompleto).';
                    break;
                case 3:
                    $htmlEstado = '<i class="mdi mdi-block-helper text-danger"></i> El cuestionario no es válido.';
                    break;
                case 4:
                    $htmlEstado = '<i class="mdi mdi-backup-restore text-warning"></i> El cuestionario se volvió a capturar y será sustituido por otro folio válido.';
                    break;
                case 5:
                    $htmlEstado = '<i class="mdi mdi-test-tube text-info"></i> El cuestionario es de prueba y no será sustituido por otro folio.';
                    break;
            }

            $htmlCuestionario = '<a href="../verCuestionario/' . $a['id'] . '/' . $tabla . '" target="_blank" class="text-center" data-toggle="tooltip" title="Ver cuestionario" ><i class="mdi mdi-file-document text-center" style="color: #AE00FF; font-size: 2rem"></i></a>';





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

            if ($c_nc <= 10) {
                $htmlNc = '<label class="text-success">' . $c_nc . '</label>';
            } else if ($c_nc > 10 && $c_nc <= 19) {
                $htmlNc = '<label class="text-warning">' . $c_nc . '</label>';
            } else if ($c_nc >= 20) {
                $htmlNc = '<label class="text-danger">' . $c_nc . '</label>';
            }


            $array[$key] = [
                'folio' => $a['folio'],
                'nombre_encuestador' => $a['nombre_encuestador'],
                'estado' => $htmlEstado,
                'entrevista' => $htmlCuestionario,
                'nc' => $htmlNc
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

    public function verCuestionarioAdmin($id, $tabla)
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        $condiciones = ['id' => $id];

        if (!$this->CuestionariosModel->exist($tabla, $condiciones)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'OJO')
                ->with('text', 'Estas intentando acceder a una encuesta que no es de su grupo. Seleccionela de su listado.');;
        }

        $cuestionario = $this->CuestionariosModel->getAllOneRow($tabla, $condiciones);

        #TIPO DE ASOCIACIONES
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

        $cuestionario['1b'] = $b1['nombre'];
        $cuestionario['1e'] = $e1['nombre'];
        $cuestionario['1q'] = $q1['nombre'];
        $cuestionario['2b'] = $b2['nombre'];
        $cuestionario['2c'] = $c2['nombre'];
        $cuestionario['2d'] = $d2['nombre'];
        $cuestionario['2e'] = $e2['nombre'];
        $cuestionario['2f'] = $f2['nombre'];
        $cuestionario['7a'] = $a7['nombre'];
        $cuestionario['7c'] = $c7['nombre'];
        $cuestionario['7f'] = $f7['nombre'];
        $cuestionario['8b'] = $b8['nombre'];

        $explode = explode('_', $tabla);

        $condiciones = ['nombre_red' => $explode[1]];
        $red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $data['cuestionario'] = $cuestionario;
        $data['red'] = $red;
        $data['claveCuerpo'] = $cuestionario['claveCuerpo'];

        return view('external/librerias/index')
            . view('usuarios/vistas/cuestionarios', $data)
            . view('external/footer/index');
    }

    public function chartGiroEquipo($tabla, $claveCuerpo)
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        $condiciones = ['claveCuerpo' => $claveCuerpo, '1q' => 'a'];
        $columnas = ['1q'];
        $giro_a = $this->CuestionariosModel->count($tabla, $condiciones);

        $condiciones = ['claveCuerpo' => $claveCuerpo, '1q' => 'b'];
        $giro_b = $this->CuestionariosModel->count($tabla, $condiciones);

        $condiciones = ['claveCuerpo' => $claveCuerpo, '1q' => 'c'];
        $giro_c = $this->CuestionariosModel->count($tabla, $condiciones);

        $colores = [];
        array_push($colores, '"rgba(255, 99, 132, 0.9)"');
        array_push($colores, '"rgba(54, 162, 235, 0.9)"');
        array_push($colores, '"rgba(255, 206, 86, 0.9)"');

        // Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor

        $etiquetas = ["Comercio", "Servicio", "Manufactura"];
        $datosVentas = [$giro_a, $giro_b, $giro_c];
        // Ahora las imprimimos como JSON para pasarlas a AJAX, pero las agrupamos
        $data = [
            "etiquetas" => $etiquetas,
            "datos" => $datosVentas,
            "colores" => $colores
        ];
        return $this->response->setJSON($data);
        //return $this->response->setJSON($respuesta);
    }

    public function validarInvestigacion()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $claveCuerpo = $_POST['claveCuerpo'];
        $estado = $_POST['estado'];
        $observaciones = $_POST['observaciones'];

        if (!empty($observaciones)) {
            $observaciones = "<p>Observaciones:</p><p>{$observaciones}</p>";
        }

        $condiciones = ['cuerpoAcademico' => $claveCuerpo];
        $columnas = ['usuario'];
        $miembros = $this->AdminModel->getAllColums($columnas, 'miembros', $condiciones);

        $correos = [];
        foreach ($miembros as $m) {
            $condiciones = ['usuario' => $m['usuario']];
            $columnas = ['correo'];
            $usuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
            if (!empty($usuario)) {
                array_push($correos, $usuario['correo']);
            }
        }

        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $columnas = ['redCueCa'];
        $ca = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        $condiciones = ['nombre_red' => $ca['redCueCa']];
        $info_red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $red_lower = strtolower($ca['redCueCa']);

        $red_upper = strtoupper($ca['redCueCa']);

        $corazon = "<span style='color: {$info_red['color_primario']}'>&#x2764;</span>";

        if ($estado == 3) {
            #Necesita reenviar
            $subject = '¡Importante! Su proceso de validación de sus encuestas necesita correcciones, revise este correo.';

            $html = "
            Estimados investigadores e investigadoras del grupo <b>{$claveCuerpo}</b>,<br>

            El Equipo RedesLA confirma que su validación de sus encuestas se ha sido reenviada. 
            Favor de atender las observaciones que se les indique.<br>

            {$observaciones}

            {$corazon} En {$red_upper} tenemos #PasiónPorLaInvestigación <br>
            🤓  Manténgase actualizado: <a href='{$info_red['facebook']}'>{$info_red['facebook']}</a><br>
            🌍 https://{$red_lower}.redesla.la 
            ";
        } else if ($estado == 2) {
            #Es aceptado sus encuestas, le vamos a mandar el correo de validacion
            #terminado => 2
            $subject = 'Su proceso de validación de sus encuestas se ha sido realizado de forma correcta.';
            $html = "
            Estimados investigadores e investigadoras del grupo <b>{$claveCuerpo}</b>,<br>

            El Equipo RedesLA confirma que su validación de sus encuestas se ha sido realizado de forma correcta, 
            agradecemos el cumplimiento de actividades en tiempo y forma, la siguiente etapa es la de redacción de capitulo(s), 
            les pedimos amablemente estar pendiente de nuestros comunicados.<br>

            {$observaciones}

            {$corazon} En {$red_upper} tenemos #PasiónPorLaInvestigación <br>
            🤓  Manténgase actualizado: <a href='{$info_red['facebook']}'>{$info_red['facebook']}</a><br>
            🌍 https://{$red_lower}.redesla.la 
            ";
        }

        $email = \Config\Services::email();
        $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
        $email->setTo($correos);
        $email->setSubject($subject);
        $email->setMessage($html);

        if ($email->send()) {
            $data = ['terminado' => $estado];
            $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => date('Y')];
            $this->AdminModel->generalUpdate('validacion', $data, $condiciones);

            $fecha_actual = date("Y-m-d");
            $fecha_expiracion = date("Y-m-d", strtotime($fecha_actual . "+ 7 days"));

            $msjPlataforma = trim($html);
            $msjPlataforma = str_replace(array("\r", "\n", "\r\n"), " ", $msjPlataforma);

            $data = [
                'claveCuerpo' => $claveCuerpo,
                'mensaje' => $msjPlataforma,
                'nivelAlerta' => 'info',
                'fechaExpiracion' => $fecha_expiracion,
                'activo' => 1
            ];
            #insertamos la alerta a la bd
            $this->AdminModel->generalInsert('mensajes_CA', $data);

            return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'Listo')
                ->with('text', 'Correos enviados correctamente');
        } else {
            $error = $email->printDebugger(['headers']);
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error al enviar un correo. Error: ' . $error);
        }
    }

    #======================INVESTIGACIONES=========================

    #=================CARTAS DE DICTAMEN DE REVISTA QUATRO====================

    public function libro_congreso_dictamen()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/dictamen/congreso/index')
            . view('admin/footers/index');
    }

    public function getListadoCartasLibroCongreso()
    {

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'red', 'institucion', 'id_articulo', 'nombre_articulo', 'ISSN'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM carta_dictamen_congreso";
        $sql_data = "SELECT * FROM carta_dictamen_congreso";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            $htmlEliminar = '
            <div class="dropdown">
              <button class="btn btn-danger dropdown-toggle btn-rounded  btn-icon-text" type="button" id="dropdownMenuSizeButton' . $a['id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-alert btn-icon-prepend"></i> Eliminar </button> </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton' . $a['id'] . '" style="">
                <h6 class="dropdown-header">Seleccione una opcion</h6>
                <button class="dropdown-item eliminar" data-id="' . $a['id'] . '">Eliminar registro</button>
              </div>
            </div>
            ';

            $htmlpdf = '<a href="./descargar/' . $a['id'] . '" target="_balnk"><i class="mdi mdi-file-pdf" style="color:red; font-size:2rem"></i></a>';

            $array[$key] = [
                'id' => $a['id'],
                'red' => $a['red'],
                'institucion' => $a['universidad'],
                'id_articulo' => $a['submission_id'],
                'nombre_articulo' => $a['nombre_trabajo'],
                'isbn' => $a['isbn'],
                'pdf' => $htmlpdf,
                'eliminar' => $htmlEliminar
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

    public function editDictamenCongreso($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        echo $id;
    }

    public function agregarCartaDictamenCongreso()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];
        $columnas = ['nombre'];
        $universidades = $this->AdminModel->getAllColums($columnas, 'cuerpos_academicos', $condiciones);
        $redes = $this->AdminModel->getAll('redes', $condiciones);
        $congresos = $this->AdminModel->getAll('congresos_info', $condiciones);
        $columnas = ['nombre', 'id'];
        $libros = $this->AdminModel->getAllColums($columnas, 'libros', $condiciones);
        $data = [
            'universidades' => $universidades,
            'redes' => $redes,
            'congresos' => $congresos,
            'libros' => $libros
        ];

        return view('admin/headers/index')
            . view('admin/dictamen/congreso/agregar', $data)
            . view('admin/footers/index');
    }

    public function getPdfCartaDictamenCongreso()
    {

        #ESTE MODULO VA RELACIONADO A LA FUNCION descargarPdfCartaDictamenCongreso
        #SI SE MODIFICA EL ANTERIOR, TAMBIEN ESTE Y VICEVERSA

        $str_libros = '';
        $str_capitulos = '';

        $nombre_capitulo = '';
        $isbn = ''; #Puede ser ISSN
        $nombre_libro = '';
        $enlace = '';

        if (is_array($_POST['libros'])) {

            #FORMATEAMOS LIBROS
            foreach ($_POST['libros'] as $l) {
                $str_libros .= $l . ',';
            }
            $str_libros = substr($str_libros, 0, -1);
            #FORMATEAMOS CAPITULOS
            foreach ($_POST['capitulos'] as $c) {
                $str_capitulos .= $c . ',';
                $condiciones = ['id' => $c];
                $columnas = ['id_libro', 'nombre_capitulo'];
                $infoCap = $this->AdminModel->getColumnsOneRow($columnas, 'indices_libros', $condiciones);
                $condiciones = ['id' => $infoCap['id_libro']];
                $columnas = ['isbn', 'nombre', 'enlace'];
                $infoLibro = $this->AdminModel->getColumnsOneRow($columnas, 'libros', $condiciones);
            }
            $nombre_capitulo = $infoCap['nombre_capitulo'];
            $isbn = $infoLibro['isbn'];
            $nombre_libro = $infoLibro['nombre'];
            $enlace = $infoLibro['enlace'];
            $str_capitulos = substr($str_capitulos, 0, -1);
        } else {
            $nombre_capitulo = $_POST['capitulos'];
            $isbn = $_POST['isbn'];
            $nombre_libro = $_POST['libros'];
            $enlace = $_POST['enlace'];

            $str_libros = $_POST['libros'];
            $str_capitulos = $_POST['capitulos'];
        }

        $str_autores = '';
        for ($i = 1; $i <= 4; $i++) {
            $variable = 'autor_' . $i;
            if ($_POST[$variable] != '') {
                $str_autores .= $_POST[$variable] . ', ';
            }
        }
        $str_autores = substr($str_autores, 0, -2);
        $explode_autores = explode(', ', $str_autores);
        $last_autor = end($explode_autores);
        $str_autores = str_replace(", $last_autor", " y $last_autor", $str_autores, $count);

        #SUSTITUIMOS LOS VALORES
        $data = $_POST;
        $data['libros'] = $str_libros;
        $data['capitulos'] = $str_capitulos;

        $condiciones = ['nombre_red' => $_POST['red']];
        $info_red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $condiciones = ['id' => $_POST['congreso']];
        $info_congreso = $this->AdminModel->getAllOneRow('congresos_info', $condiciones);

        $nombre_trabajo = $_POST['submission_id'] . '.- ' . $_POST['nombre_trabajo'];

        $pdf = new CartasDictamenCongresoTCPDF();

        $pdf->SetPrintHeader(true);

        $pdf->SetPrintFooter(false);

        $pdf->SetAutoPageBreak(true, 35);

        $pdf->SetAuthor('REDESLA - IQuatro Editores');

        $pdf->SetCreator('REDESLA - IQuatro Editores');

        $pdf->SetTitle("Carta de dictamen de congreso");

        $pdf->AddPage();

        $pdf->SetFont('Times', 'B', 11);

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $fecha = 'Querétaro, Querétaro, a ' . date('d') . ' de ' . $meses[date('n') - 1] . ' de ' . date('Y'); //de %B del %Y

        $pdf->Cell(0, 5, $fecha, 0, 0, 'R');

        $pdf->Ln();

        for ($i = 1; $i <= 4; $i++) {
            $variable = 'autor_' . $i;
            if ($_POST[$variable] != '') {
                $pdf->Cell(0, 5, $_POST[$variable], 0, 0, 'L');
                $pdf->Ln(5);
            }
        }

        if ($info_congreso['modalidad'] != '') {
            $modalidad = $info_congreso['modalidad'];
        } else {
            $modalidad = 'mixta';
        }

        $pdf->SetFont('Times', '', 11);

        $pdf->Ln(3);

        $pdf->Cell(0, 5, $_POST['universidad'], 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(0, 5, 'PRESENTES', 0, 0, 'L');
        $pdf->Ln();

        $html = '
        <p>
        Reciba un cordial saludo por parte de la editorial <b>iQuatro Editores</b> y la <b>' . $info_red['significado'] . ' (' . strtoupper($info_red['nombre_red']) . ')</b>.
        </p>
        <p>
        Por este medio, le compartimos el dictamen de publicación que se obtuvo de la revisión por pares doble ciego, así como la evaluación obtenida durante 
        la presentación de su ponencia en el ' . $info_congreso['nombre'] . ' que se llevó a cabo en modalidad ' . $modalidad . ', teniendo como institución anfitriona la 
        ' . $info_congreso['sede'] . ', en conjunto con RedesLA (Redes de Estudios Latinoamericanos) —a quien pertenece ' . strtoupper($info_congreso['red']) . ', los días ' . $info_congreso['fechas'] . '.
        </p>
        <p>
        <b>' . $nombre_trabajo . '</b> - realizado por ' . $str_autores . ' fue publicado como Capítulo <i>' . $nombre_capitulo . '</i> del libro <b>' . $nombre_libro . '</b>, con <b>ISBN ' . $isbn . '</b> 
        y puede ser consultado en la biblioteca digital <b><a href="' . $enlace . '" target="_blank">' . $enlace . '</a></b>
        </p>
        <p>
        Este capítulo fue arbitrado por pares académicos, bajo el sistema de doble ciego. Se privilegia dicho dictamen con el aval de distintos 
        investigadores adscritos a diversas universidades públicas y privadas, con líneas de investigación en la(s) area(s) de <b>' . $info_red['area_estudio'] . '</b>.
        </p>
        <p>
        Reconocemos el esfuerzo de nuestros autores— quienes además de estrechar y consolidar lazos de colaboración de diversas disciplinas e 
        instituciones, construyen una comunidad científica comprometiéndose con el desarrollo de las ciencias en Latinoamérica.
        </p>
        ';

        $pdf->writeHTML($html, true, false, false, false, 'J');

        $pdf->Ln(2);

        $pdf->writeHTML('A T E N T A M E N T E', true, false, true, false, 'C');

        $pdf->Ln(3);

        $pdf->Image(base_url('resources/img/firmas/NadiaVelazquez.png'), 90, '', 40, 20, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->Ln(20);

        $pdf->SetFont('Times', '', 10);

        $pdf->writeHTML('Nadia Velázquez Moreno<br>COORDINADORA EDITORIAL DE iQUATRO EDITORES', true, false, true, false, 'C');

        $this->response->setHeader('Content-Type', 'application/pdf');

        $pdf->Output("Libro Derivado De Congreso - " . $_POST['submission_id'] . ".pdf", "D");
    }

    public function insertCartaDictamenCongreso()
    {
        $nombre_capitulo = '';
        $isbn = ''; #Puede ser ISSN
        $nombre_libro = '';
        $enlace = '';

        $str_libros = '';
        $str_capitulos = '';

        if (is_array($_POST['libros'])) {

            #FORMATEAMOS LIBROS
            foreach ($_POST['libros'] as $l) {
                $str_libros .= $l . ',';
            }
            $str_libros = substr($str_libros, 0, -1);
            #FORMATEAMOS CAPITULOS
            foreach ($_POST['capitulos'] as $c) {
                $str_capitulos .= $c . ',';
                $condiciones = ['id' => $c];
                $columnas = ['id_libro', 'nombre_capitulo'];
                $infoCap = $this->AdminModel->getColumnsOneRow($columnas, 'indices_libros', $condiciones);
                $condiciones = ['id' => $infoCap['id_libro']];
                $columnas = ['isbn', 'nombre', 'enlace'];
                $infoLibro = $this->AdminModel->getColumnsOneRow($columnas, 'libros', $condiciones);
            }
            $isbn = $infoLibro['isbn'];
            $enlace = $infoLibro['enlace'];
            $str_capitulos = substr($str_capitulos, 0, -1);
        } else {
            $isbn = $_POST['isbn'];
            $enlace = $_POST['enlace'];

            $str_libros = $_POST['libros'];
            $str_capitulos = $_POST['capitulos'];
        }

        $data = [
            'autor_1' => $_POST['autor_1'],
            'autor_2' => $_POST['autor_2'],
            'autor_3' => $_POST['autor_3'],
            'autor_4' => $_POST['autor_4'],
            'universidad' => $_POST['universidad'],
            'red' => $_POST['red'],
            'congreso' => $_POST['congreso'],
            'submission_id' => $_POST['submission_id'],
            'nombre_trabajo' => $_POST['nombre_trabajo'],
            'libros' => $str_libros,
            'capitulos' => $str_capitulos,
            'isbn' => $isbn,
            'enlace' => $enlace
        ];

        if ($this->AdminModel->generalInsert('carta_dictamen_congreso', $data)) {
            return 'success';
        }
        return 'error';
    }

    public function eliminarCartaDictamenCongreso()
    {

        $condiciones = ['id' => $_POST['id']];

        if (!$this->AdminModel->generalDelete("carta_dictamen_congreso", $condiciones)) {
            return 'error';
        }
        return 'success';
    }

    public function descargarPdfCartaDictamenCongreso($id)
    {

        #ESTE MODULO VA RELACIONADO A LA FUNCION getPdfCartaDictamenCongreso
        #SI SE MODIFICA EL ANTERIOR, TAMBIEN ESTE Y VICEVERSA
        $condiciones = ['id' => $id];
        $data = $this->AdminModel->getAllOneRow('carta_dictamen_congreso', $condiciones);
        if (empty($data)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'El archivo que desea descargar no existe.');
        }

        $isbn = $data['isbn'];
        $enlace = $data['enlace'];

        $nombre_trabajo = $data['submission_id'] . '.- ' . $data['nombre_trabajo'];

        $condiciones = ['nombre_red' => $data['red']];
        $info_red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $condiciones = ['id' => $data['congreso']];
        $info_congreso = $this->AdminModel->getAllOneRow('congresos_info', $condiciones);

        #BUENO, YA SABES, EXTRAEMOS INFORMACION BASICA NO, ARRIBA, AQUI HACEMOS UN RECORRIDO DE AUTORES
        #MEDIANTE UNA ITERACION PARA SIMPLIFICAR CODIGO
        $str_autores = '';
        for ($i = 1; $i <= 4; $i++) {
            $variable = 'autor_' . $i;
            if ($data[$variable] != '') {
                $str_autores .= $data[$variable] . ', ';
            }
        }
        #CUANDO SE TERMINE, SE TENDRA UN ", " AL ULTIMO, DEBEMOS ELIMINARLO
        $str_autores = substr($str_autores, 0, -2);
        #AHORA DEBEMOS SUSTITUIR EL ULTIMO ", " POR UN " Y ", HACEMOS UN EXPLODE A LOS AUTORES, TOMAMOS EL ULTIMO
        #DESPUES CON STR_REPLACE LO BUSCAMOS Y LO REMPLAZAMOS. 
        $explode_autores = explode(', ', $str_autores);
        $last_autor = end($explode_autores);
        $str_autores = str_replace(", $last_autor", " y $last_autor", $str_autores, $count);

        if (is_numeric($data['libros'])) {
            $condiciones = ['id' => $data['libros']];
            $libro = $this->AdminModel->getAllOneRow('libros', $condiciones);
            $nombre_libro = $libro['nombre'];
        } else {
            $nombre_libro = $data['libros'];
        }

        if (is_numeric($data['capitulos'])) {
            $condiciones = ['id' => $data['capitulos']];
            $capitulo = $this->AdminModel->getAllOneRow('indices_libros', $condiciones);
            $nombre_capitulo = $capitulo['nombre_capitulo'];
        } else {
            $nombre_capitulo = $data['capitulos'];
        }

        $pdf = new CartasDictamenCongresoTCPDF();

        $pdf->SetPrintHeader(true);

        $pdf->SetPrintFooter(false);

        $pdf->SetAutoPageBreak(true, 35);

        $pdf->SetAuthor('REDESLA - IQuatro Editores');

        $pdf->SetCreator('REDESLA - IQuatro Editores');

        $pdf->SetTitle("Carta de dictamen de congreso");

        $pdf->AddPage();

        $pdf->SetFont('Times', 'B', 11);

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $fecha = 'Querétaro, Querétaro, a ' . date('d') . ' de ' . $meses[date('n') - 1] . ' de ' . date('Y'); //de %B del %Y

        $pdf->Cell(0, 5, $fecha, 0, 0, 'R');

        $pdf->Ln();

        for ($i = 1; $i <= 4; $i++) {
            $variable = 'autor_' . $i;
            if ($data[$variable] != '') {
                $pdf->Cell(0, 5, $data[$variable], 0, 0, 'L');
                $pdf->Ln(5);
            }
        }

        if ($info_congreso['modalidad'] != '') {
            $modalidad = $info_congreso['modalidad'];
        } else {
            $modalidad = 'mixta';
        }

        $pdf->SetFont('Times', '', 11);

        $pdf->Ln(5);

        $pdf->Cell(0, 5, $data['universidad'], 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(0, 5, 'PRESENTES', 0, 0, 'L');
        $pdf->Ln();

        $html = '
        <p>
        Reciba un cordial saludo por parte de la editorial <b>iQuatro Editores</b> y la <b>' . $info_red['significado'] . ' (' . strtoupper($info_red['nombre_red']) . ')</b>.
        </p>
        <p>
        Por este medio, le compartimos el dictamen de publicación que se obtuvo de la revisión por pares doble ciego, así como la evaluación obtenida durante 
        la presentación de su ponencia en el ' . $info_congreso['nombre'] . ' que se llevó a cabo en modalidad ' . $modalidad . ', teniendo como institución anfitriona la 
        ' . $info_congreso['sede'] . ', en conjunto con RedesLA (Redes de Estudios Latinoamericanos) —a quien pertenece ' . strtoupper($info_congreso['red']) . ', los días ' . $info_congreso['fechas'] . '.
        </p>
        <p>
        <b>' . $nombre_trabajo . '</b> - realizado por ' . $str_autores . ' fue publicado como Capítulo <i>' . $nombre_capitulo . '</i> del libro <b>' . $nombre_libro . '</b>, con <b>ISBN ' . $isbn . '</b> 
        y puede ser consultado en la biblioteca digital <b><a href="' . $enlace . '" target="_blank">' . $enlace . '</a></b>
        </p>
        <p>
        Este capítulo fue arbitrado por pares académicos, bajo el sistema de doble ciego. Se privilegia dicho dictamen con el aval de distintos 
        investigadores adscritos a diversas universidades públicas y privadas, con líneas de investigación en la(s) area(s) de <b>' . $info_red['area_estudio'] . '</b>.
        </p>
        <p>
        Reconocemos el esfuerzo de nuestros autores— quienes además de estrechar y consolidar lazos de colaboración de diversas disciplinas e 
        instituciones, construyen una comunidad científica comprometiéndose con el desarrollo de las ciencias en Latinoamérica.
        </p>
        ';

        $pdf->writeHTML($html, true, false, false, false, 'J');

        $pdf->Ln(2);

        $pdf->writeHTML('A T E N T A M E N T E', true, false, true, false, 'C');

        $pdf->Ln(3);

        $pdf->Image(base_url('resources/img/firmas/NadiaVelazquez.png'), 90, '', 40, 20, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $pdf->Ln(20);

        $pdf->SetFont('Times', '', 10);

        $pdf->writeHTML('Nadia Velázquez Moreno<br>COORDINADORA EDITORIAL DE iQUATRO EDITORES', true, false, true, false, 'C');

        $this->response->setHeader('Content-Type', 'application/pdf');

        $pdf->Output("Libro Derivado De Congreso - " . $data['submission_id'] . ".pdf", "D");
    }

    public function getInfoIquatro()
    {
        $condiciones = ['submission_id' => $_POST['id']];
        #$condiciones = ['submission_id' => 845];
        $columnas = ['publication_id'];
        $publication_id = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);
        if (empty($publication_id)) {
            return 'no_publication_id';
        }
        #PREFIJO
        $columnas = ['setting_value', 'locale'];
        $condiciones = ['publication_id' => $publication_id['publication_id'], 'setting_name' => 'prefix'];
        $prefijo = $this->IquatroModel->getColumns($columnas, 'publication_settings', $condiciones);
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
        }
        #Nombre
        $condiciones = ['publication_id' => $publication_id['publication_id'], 'setting_name' => 'title'];
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
        #Subtitulo
        $condiciones = ['publication_id' => $publication_id['publication_id'], 'setting_name' => 'subtitle'];
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
        }

        if (empty($prefijo)) {

            if (empty($subtitulo)) {

                $nombre_ponencia = $nombre;
            } else {

                $nombre_ponencia = $nombre . ": " . $subtitulo;
            }
        } else {

            if (empty($subtitulo)) {

                $nombre_ponencia = $prefijo . " " . $nombre;
            } else {

                $nombre_ponencia = $prefijo . " " . $nombre . ": " . $subtitulo;
            }
        }

        #Extraemos los autores
        $columnas = ['author_id'];
        $condiciones = ['publication_id' => $publication_id["publication_id"]];
        $autores_id = $this->IquatroModel->getColumns($columnas, 'authors', $condiciones);
        $autores = [];
        foreach ($autores_id as $key => $aut_id) {

            $nombre_autor = $this->IquatroModel->nombre_autor($aut_id["author_id"]);
            $autores[] = [
                'nombre' => $nombre_autor["nombre"] . ' ' . $nombre_autor["apellidos"]
            ];
        }


        $data = [
            'nombre_ponencia' => $nombre_ponencia,
            'autores' => $autores
        ];
        return $this->response->setJSON($data);
    }
    #=================CARTAS DE DICTAMEN DE REVISTA QUATRO====================

    #===================CURSOS===========================

    public function cursos($curso)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        #cursos validos
        $validos = [
            [
                'nombre' => 'metodologia',
                'id' => 1,
                'nombre_completo' => 'Cómo desarrollar artículos científicos Válidos: Metodología de la Investigación'
            ]
        ];
        $columna = array_column($validos, "nombre");
        if (!in_array($curso, $columna)) {
            #Curso no disponible para atras
            return redirect()->back();
        }
        $index = '';
        foreach ($validos as $key => $valor) {
            if (strpos($curso, $valor['nombre']) !== false) {
                $index = $key;
                break;
            }
        }

        $data = [
            'id' => $validos[$index]['id'],
            'nombre_curso' => $validos[$index]['nombre_completo'],
        ];


        return view('admin/headers/index')
            . view('admin/cursos/lista', $data)
            . view('admin/footers/index');
    }

    public function getListadoCursos($id)
    {
        
        $valor_buscado = $_POST['search']['value'];

        $columnas = [
            'id', 'correo', 'nombre', 'curp', 'grado_academico', 'actividad', 'area_conocimiento', 'trabajo',
            'num_tel', 'pais', 'paquete', 'medio_entero', 'factura', 'razon_factura', 'rfc', 'cfdi', 'fact_correo',
            'calle_fact', 'exterior_fact', 'interior_fact', 'cp_fact', 'colonia_fact', 'muni_fact', 'estado_fact',
            'pais_fact','regimen_fiscal', 'congreso', 'terminos', 'fecha', 'curso', 'pago', 'anio_curso', 'sexo', 'constancia',
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM registros_cursos";
        $sql_data = "SELECT * FROM registros_cursos";

        switch ($id) {
            case 1:
                $condiciones_extras = "(anio_curso = '19-26-02')";
                break;
            default:
                http_response_code(404);
                exit;
                return;
        }

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE (curso = {$id} AND {$condiciones_extras}) AND (" . $val . " LIKE '%" . $valor_buscado . "%' ";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = empty($condicion) ? $sql_count . " WHERE curso = {$id} AND {$condiciones_extras}" : $sql_count . $condicion . ')';
        $sql_data = empty($condicion) ? $sql_data . " WHERE curso = {$id} AND {$condiciones_extras}" : $sql_data . $condicion . ')';

        $total_count = $this->db_cursos->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir'] . " LIMIT " . $_POST['start'] . ", " . $_POST['length'] . "";

        $data = $this->db_cursos->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            $folio_format = 'CTMI18a';
            $condiciones = [
                'correo' => $a['correo'],
            ];
            $like = [
                'folio' => $folio_format
            ];

            $c_constancia = $this->AdminModel->countWithLike('constancia_metodologia', $condiciones, $like);

            $constancia = $c_constancia > 0 ? 1 : 0;

            if ($a['constancia'] != $constancia) {
                $dataUpdate = ['constancia' => $constancia];
                $condiciones = ['id' => $a['id']];
                $this->CursosModel->generalUpdate('registros_cursos', $dataUpdate, $condiciones);
            }

            $array[$key] = [
                'id' => $a['id'],
                'correo' => $a['correo'],
                'nombre' => $a['nombre'],
                'curp' => $a['curp'],
                'grado_academico' => $a['grado_academico'],
                'actividad' => $a['actividad'],
                'area_conocimiento' => $a['area_conocimiento'],
                'trabajo' => $a['trabajo'],
                'num_tel' => $a['num_tel'],
                'pais' => $a['pais'],
                'paquete' => $a['paquete'],
                'medio_entero' => $a['medio_entero'],
                'factura' => $a['factura'],
                'razon_factura' => $a['razon_factura'],
                'rfc' => $a['rfc'],
                'cfdi' => $a['cfdi'],
                'fact_correo' => $a['fact_correo'],
                'calle_fact' => $a['calle_fact'],
                'exterior_fact' => $a['exterior_fact'],
                'interior_fact' => $a['interior_fact'],
                'cp_fact' => $a['cp_fact'],
                'colonia_fact' => $a['colonia_fact'],
                'muni_fact' => $a['muni_fact'],
                'estado_fact' => $a['estado_fact'],
                'pais_fact' => $a['pais_fact'],
                'regimen_fiscal'=>$a['regimen_fiscal'],
                'congreso' => $a['congreso'],
                'terminos' => $a['terminos'],
                'fecha' => $a['fecha'],
                'curso' => $a['curso'],
                'pago' => $a['pago'],
                'anio_curso' => $a['anio_curso'],
                'sexo' => $a['sexo'],
                'constancia' => $constancia,
            ];

            

        }

        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function pagoCurso()
    {
        $estado = $_POST['estado'];
        $id = $_POST['id'];

        $condiciones = ['id' => $id];
        if ($estado == 0) {
            #vamos a enviar el correo
            $data = ['pago' => 1];
        } else {
            #desvalidamos el pago
            $data = ['pago' => 0];
        }

        if ($this->CursosModel->generalUpdate('registros_cursos', $data, $condiciones)) {

            if ($estado == 0) {
                #oobtenemos el curso
                $condiciones = ['id' => $id];
                $columnas = ['curso','correo'];
                $info_curso = $this->CursosModel->getColumnsOneRow($columnas, 'registros_cursos', $condiciones);

                if (empty($info_curso)) {
                    $data = ['pago' => $estado];
                    $this->CursosModel->generalUpdate('registros_cursos', $data, $condiciones);
                    $mensaje = "Ha ocurrido un error al obtener la información del curso.";
                    http_response_code(404);
                    echo $mensaje;
                    exit;
                }

                $curso = $info_curso['curso'];

                switch ($curso) {
                    case 1:
                        $nombre_curso = 'metodologia';
                        break;
                    default:
                        $data = ['pago' => $estado];
                        $this->CursosModel->generalUpdate('registros_cursos', $data, $condiciones);
                        $mensaje = "Ha ocurrido un error al obtener el nombre del curso.";
                        http_response_code(404);
                        echo $mensaje;
                        exit;
                        break;
                }

                ob_start();
                // Cargar la vista y capturar la salida en una variable
                echo view('admin/cursos/correo_' . $nombre_curso, $data);
                $htmlCurso = ob_get_contents();
                ob_end_clean();

                $email = \Config\Services::email();
                $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
                $email->setTo($info_curso['correo']);
                $email->setSubject('Pago de curso');
                $email->setMessage($htmlCurso);

                if ($email->send()) {
                    $respuesta = array(
                        "title" => "Hecho",
                        'mensaje' => 'Se ha enviado el correo',
                        "codigo" => 200,
                    );
                    $json_respuesta = json_encode($respuesta);
                    echo $json_respuesta;
                    exit;
                } else {
                    $data = ['pago' => $estado];
                    $this->CursosModel->generalUpdate('registros_cursos', $data, $condiciones);
                    $mensaje = "Ha ocurrido un error al intentar enviar el correo";
                    http_response_code(500);
                    echo $mensaje;
                    exit;
                }

                $respuesta = array(
                    "title" => "Hecho",
                    'mensaje' => 'Se ha actualizado el estado',
                    "codigo" => 200,
                );
                $json_respuesta = json_encode($respuesta);
                echo $json_respuesta;
                exit;
            } else {
                $respuesta = array(
                    "title" => "Hecho",
                    'mensaje' => 'Se ha actualizado el estado',
                    "codigo" => 200,
                );
                $json_respuesta = json_encode($respuesta);
                echo $json_respuesta;
                exit;
            }
        } else {
            $mensaje = "Ha ocurrido un error al intentar actualizar el estado del pago. Correos no enviados";
            http_response_code(500);
            echo $mensaje;
            exit;
        }
    }

    public function getCSVMoodle($id_curso, $edicion)
    {

        switch ($id_curso) {
            case 1:
                $condiciones_extras = "(anio_curso = '19-26-02')";
                break;
            default:
                http_response_code(404);
                exit;
                return;
        }

        $consulta = "SELECT * FROM registros_cursos WHERE curso = {$id_curso} AND {$condiciones_extras} AND pago = 1";

        $data = $this->db_cursos->query($consulta)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        $csv = 'username,firstname,lastname,email,course1,password' . PHP_EOL;

        foreach ($array as $key => $a) {
            $explode_nombre = explode(' ', $a['nombre']);

            if (count($explode_nombre) >= 2) {
                $name_username = ucfirst(strtolower($explode_nombre[0])) . '_' . ucfirst(strtolower($explode_nombre[1]));
                if (count($explode_nombre) >= 4) {
                    #2 nombres 2 apellidos
                    $nombre = $explode_nombre[0] . ' ' . $explode_nombre[1];
                    $apellidos = $explode_nombre[2] . ' ' . $explode_nombre[3];
                } else if (count($explode_nombre) == 3) {
                    # 1 nombre 2 apellidos
                    $nombre = $explode_nombre[0];
                    $apellidos = $explode_nombre[1] . ' ' . $explode_nombre[1];
                } else if (count($explode_nombre) == 2) {
                    # 1 nombre 1 apellidos
                    $nombre = $explode_nombre[0];
                    $apellidos = $explode_nombre[1];
                }
            } else {
                $name_username = ucfirst(strtolower($explode_nombre[0]));
                $nombre = $explode_nombre[0];
                $apellidos = '';
            }

            $acentos = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
            $sinAcentos = array('a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N');
            $name_username = str_replace($acentos, $sinAcentos, $name_username);



            $username = 'CTM' . $edicion . '_' . $name_username;
            $password = $username . '#';

            $str_csv = strtolower("{$username},{$nombre},{$apellidos},{$a['correo']},CTMI,{$password}");

            $csv .= $str_csv . PHP_EOL;
        }
        // Escribir la cadena CSV en un archivo y descargarlo
        $temp_archivo = tmpfile(); // Crear un archivo temporal
        fwrite($temp_archivo, "\xEF\xBB\xBF"); // Escribir BOM para indicar codificación UTF-8
        fwrite($temp_archivo, $csv); // Escribir la cadena CSV en el archivo temporal
        $archivo = stream_get_meta_data($temp_archivo)['uri']; // Obtener la ruta del archivo temporal

        // Configurar las cabeceras de respuesta HTTP
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="CTMI17ma_edicion.csv"');
        header('Pragma: no-cache');

        // Leer y descargar el archivo CSV
        readfile($archivo);
        exit;
    }

    public function addConstancias($id_curso)
    {
        switch ($id_curso) {
            case 1:
                $condiciones_extras = "(anio_curso = '19-26-02')";
                break;
            default:
                http_response_code(300);
                exit;
                return;
        }

        $id_constancias = $_POST['constancias'];

        foreach ($id_constancias as $id) {
            $condiciones = ['id' => $id];
            $info = $this->CursosModel->getAllOneRow('registros_cursos', $condiciones);

            if (empty($info)) {
                http_response_code(301);
            }

            $correo = $info['correo'];
            $nombre_participante = $info['nombre'];

            $data = [
                'nombre' => $info['nombre'],
                'correo' => $info['correo']
            ];
            $folio = $this->AdminModel->generalInsertLastId($data, 'constancia_metodologia');

            $formato_folio = $folio . '-CTMI18a-2023';
            $data = ['folio' => $formato_folio];
            $condiciones = ['id' => $folio];
            if (!$this->AdminModel->generalUpdate('constancia_metodologia', $data, $condiciones)) {
                http_response_code(501);
            }
            $data = ['constancia' => 1];
            $condiciones = ['id' => $id];
            if (!$this->CursosModel->generalUpdate('registros_cursos', $data, $condiciones)) {
                http_response_code(502);
            }

            $html = "
            <p>Apreciable participante <b>{$nombre_participante}</b></p>
            <p>Le envío un cordial saludo por este medio a nombre de <b>Redes de Estudios Latinoamericanos (RedesLA)</b></p>
            <p>
            El motivo de este mensaje es felicitarlo por haber acreditado exitosamente el curso-taller: 
            Cómo Desarrollar Artículos Científicos Válidos: Metodología de la Investigación, por ello nos 
            permitimos compartirle el siguiente enlace: https://redesla.la/cursos/constancias/
            </p>
            <p>
            En el cual puede obtener la constancia de participación por medio de su correo: <b>{$correo}</b>
            Esta constancia es adquirida al cumplir satisfactoriamente con las 30 horas del curso y 
            el envío de las actividades asignadas dentro de los talleres del curso. 
            </p>
            <p>
            Agradecemos su compromiso y confianza en REDESLA y todo el equipo, esperamos que dicha 
            participación contribuya de manera significativa a su formación profesional como investigador.
            </p>
            <p>
            Quedamos a sus órdenes para atender cualquier duda al respecto, saludos cordiales.
            </p>
            <p>
            Lo invitamos a seguirnos en Facebook, sitio en el que encontrará las fotos de la Cabina Fotográfica: 
            https://www.facebook.com/ViveRedesLA 
            </p>
            <p>
            <img src='" . base_url('/resources/img/firmas/Atención_RedesLA.jpg') . "'>
            </p>
            ";

            $ruta_dc_3 = $this->dc3_attachment($info['id']);

            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
            $email->setTo($correo);
            $email->setSubject('Gracias por ser parte de nuestro curso-taller en línea "Cómo Desarrollar Artículos Científicos Válidos: Metodología de la Investigación"');
            $email->setMessage($html);
            $email->attach($ruta_dc_3, 'attachment');

            if (!$email->send()) {
                http_response_code(600);
                echo 'No se ha podido enviar el correo. El correo en cuestion es: ' . $correo;
                exit;
            }
        }

        $respuesta = array(
            "title" => "Hecho",
            'mensaje' => 'Se han otorgado las constancias',
            "codigo" => 200,
        );
        $json_respuesta = json_encode($respuesta);
        echo $json_respuesta;
        exit;
    }

    public function dc3($id)
    {
        #NOS TRAEMOS LA INFO DEL PARTICIPANTE

        $condiciones = [
            'id' => $id
        ];

        $usuario = $this->CursosModel->getAllOneRow('registros_cursos', $condiciones);

        if (empty($usuario)) {
            http_response_code(404);
            exit;
        }

        if ($usuario['curso'] == 1 && $usuario['anio_curso'] == '19-26-02') {
            $nombre_curso = 'Cómo desarrollar artículos científicos: Metodología de la investigación';
            $horas_curso = 30;
            $fechas_curso = '20230429 20230513';
        } else {
            http_response_code(404);
            exit;
        }

        $pdf = new dc3Pdf();

        $pdf->SetPrintHeader(true);

        $pdf->SetPrintFooter(false);

        $pdf->SetAutoPageBreak(true, 35);

        $pdf->SetAuthor('REDESLA');

        $pdf->SetCreator('REDESLA');

        $pdf->SetTitle("Constancia de competencias o de habilidades laborales");

        $pdf->AddPage();

        #================NOMBRE====================
        $x = 10;  // Posición X
        $y = 65;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = $usuario['nombre']; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================NOMBRE====================

        #================CURP====================
        $x = 9.5;  // Posición X
        $y = 77;  // Posición Y
        $width = 90;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $usuario['curp']; // Texto a mostrar

        $pdf->SetFontSpacing(2.5);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================CURP====================

        $pdf->SetFontSpacing(0);

        #================OCUPACION====================
        $x = 102;  // Posición X
        $y = 77;  // Posición Y
        $width = 40;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = '11.1 Investigación'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================OCUPACION====================

        #================PUESTO====================
        $x = 9.5;  // Posición X
        $y = 87;  // Posición Y
        $width = 40;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = 'Investigador'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================PUESTO====================

        #================RAZON SOCIAL====================
        $x = 9.5;  // Posición X
        $y = 108;  // Posición Y
        $width = 80;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = 'SISTEMA DESARROLLADOR DE MYPES'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================RAZON SOCIAL====================

        #================RAZON SOCIAL====================
        $x = 10;  // Posición X
        $y = 120;  // Posición Y
        $width = 80;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = 'SDM1804054J5'; // Texto a mostrar

        $pdf->SetFontSpacing(2.6);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================RAZON SOCIAL====================

        $pdf->SetFontSpacing(0);

        #================NOMBRE DEL CURSO====================
        $x = 8;  // Posición X
        $y = 140;  // Posición Y
        $width = 160;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $nombre_curso; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================NOMBRE DEL CURSO====================

        #================HORAS====================
        $x = 8;  // Posición X
        $y = 149;  // Posición Y
        $width = 40;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $horas_curso; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================HORAS====================

        #================PERIODO====================
        $x = 84;  // Posición X
        $y = 149;  // Posición Y
        $width = 114;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = '20230819a20230902'; // Texto a mostrar

        $pdf->SetFontSpacing(4);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 12;
        $fontFamily = 'century_gothic';
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

        #================PERIODO====================

        #================TEMATICA====================
        $x = 9;  // Posición X
        $y = 157;  // Posición Y
        $width = 114;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = '11. Desarrollo y extensión del conocimiento / Investigación.'; // Texto a mostrar

        $pdf->SetFontSpacing(0);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================TEMATICA====================

        #================STPS====================
        $x = 9;  // Posición X
        $y = 168;  // Posición Y
        $width = 114;  // Ancho del área
        $height = 5;  // Alto del área

        #AUTOSIZE FONT

        $texto = 'Dr. Oscar Cuauhtémoc Aguilar Rascón'; // Texto a mostrar

        $pdf->SetFontSpacing(0);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================STPS====================

        #================FIRMA OSCAR====================
        $x = 30; // Coordenada X
        $y = 187; // Coordenada Y
        $width = 30; // Ancho de la imagen (en puntos)
        $height = 20; // Altura de la imagen (0 para ajustar automáticamente)

        $imagePath = base_url('/resources/img/firmas/DrOscarAguilar.png');

        $pdf->SetXY($x, $y);
        $pdf->Image($imagePath, $x, $y, $width, $height);


        $x = 20;  // Posición X
        $y = 203;  // Posición Y
        $width = 50;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $pdf->SetFontSpacing(0);

        $texto = 'Oscar Cuauhtémoc Aguilar Rascón'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FIRMA OSCAR====================

        #================FIRMA PAU====================
        $x = 83; // Coordenada X
        $y = 189; // Coordenada Y
        $width = 30; // Ancho de la imagen (en puntos)
        $height = 20; // Altura de la imagen (0 para ajustar automáticamente)

        $imagePath = base_url('/resources/img/firmas/PaulaMejia.png');

        $pdf->SetXY($x, $y);
        $pdf->Image($imagePath, $x, $y, $width, $height);


        $y = 203;  // Posición Y
        $width = 50;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $pdf->SetFontSpacing(0);

        $texto = 'Paula Berenice Mejía Ávila'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FIRMA PAU====================

        #================FIRMA PAU====================
        $x = 140; // Coordenada X
        $y = 189; // Coordenada Y
        $width = 30; // Ancho de la imagen (en puntos)
        $height = 20; // Altura de la imagen (0 para ajustar automáticamente)

        $imagePath = base_url('/resources/img/firmas/VictoriaVelazquez.png');

        $pdf->SetXY($x, $y);
        $pdf->Image($imagePath, $x, $y, $width, $height);


        $y = 203;  // Posición Y
        $width = 50;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $pdf->SetFontSpacing(0);

        $texto = 'Victoria Velázquez Moreno'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FIRMA PAU====================

        $pdf->SetPrintHeader(false); // Desactiva la impresión del encabezado

        $pdf->AddPage('P');

        $imagePath = base_url('resources/img/cursos/dc3_2.jpg'); // Ruta de la imagen que deseas agregar

        $pdf->Image($imagePath, 0, 0, 297, 300);

        $this->response->setHeader('Content-Type', 'application/pdf');

        $pdf->Output("DC3.pdf", "I");
    }

    private function dc3_attachment($id)
    {
        #NOS TRAEMOS LA INFO DEL PARTICIPANTE

        $condiciones = [
            'id' => $id
        ];

        $usuario = $this->CursosModel->getAllOneRow('registros_cursos', $condiciones);

        if (empty($usuario)) {
            http_response_code(800);
            exit;
        }

        if ($usuario['curso'] == 1 && $usuario['anio_curso'] == '19-26-02') {
            $nombre_curso = 'Cómo desarrollar artículos científicos: Metodología de la investigación';
            $horas_curso = 30;
            $fechas_curso = '20230429 20230513';
        } else {
            http_response_code(801);
            exit;
        }

        $pdf = new dc3Pdf();

        $pdf->SetPrintHeader(true);

        $pdf->SetPrintFooter(false);

        $pdf->SetAutoPageBreak(true, 35);

        $pdf->SetAuthor('REDESLA');

        $pdf->SetCreator('REDESLA');

        $pdf->SetTitle("Constancia de competencias o de habilidades laborales");

        $pdf->AddPage();

        #================NOMBRE====================
        $x = 10;  // Posición X
        $y = 65;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = $usuario['nombre']; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================NOMBRE====================

        #================CURP====================
        $x = 9.5;  // Posición X
        $y = 77;  // Posición Y
        $width = 90;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $usuario['curp']; // Texto a mostrar

        $pdf->SetFontSpacing(2.5);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================CURP====================

        $pdf->SetFontSpacing(0);

        #================OCUPACION====================
        $x = 102;  // Posición X
        $y = 77;  // Posición Y
        $width = 40;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = '11.1 Investigación'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================OCUPACION====================

        #================PUESTO====================
        $x = 9.5;  // Posición X
        $y = 87;  // Posición Y
        $width = 40;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = 'Investigador'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================PUESTO====================

        #================RAZON SOCIAL====================
        $x = 9.5;  // Posición X
        $y = 108;  // Posición Y
        $width = 80;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = 'SISTEMA DESARROLLADOR DE MYPES'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================RAZON SOCIAL====================

        #================RAZON SOCIAL====================
        $x = 10;  // Posición X
        $y = 120;  // Posición Y
        $width = 80;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = 'SDM1804054J5'; // Texto a mostrar

        $pdf->SetFontSpacing(2.6);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================RAZON SOCIAL====================

        $pdf->SetFontSpacing(0);

        #================NOMBRE DEL CURSO====================
        $x = 8;  // Posición X
        $y = 140;  // Posición Y
        $width = 160;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $nombre_curso; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================NOMBRE DEL CURSO====================

        #================HORAS====================
        $x = 8;  // Posición X
        $y = 149;  // Posición Y
        $width = 40;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $horas_curso; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 10;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================HORAS====================

        #================PERIODO====================
        $x = 84;  // Posición X
        $y = 149;  // Posición Y
        $width = 114;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = '20230819a20230902'; // Texto a mostrar

        $pdf->SetFontSpacing(4);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 12;
        $fontFamily = 'century_gothic';
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

        #================PERIODO====================

        #================TEMATICA====================
        $x = 9;  // Posición X
        $y = 157;  // Posición Y
        $width = 114;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = '11. Desarrollo y extensión del conocimiento / Investigación.'; // Texto a mostrar

        $pdf->SetFontSpacing(0);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================TEMATICA====================

        #================STPS====================
        $x = 9;  // Posición X
        $y = 168;  // Posición Y
        $width = 114;  // Ancho del área
        $height = 5;  // Alto del área

        #AUTOSIZE FONT

        $texto = 'Dr. Oscar Cuauhtémoc Aguilar Rascón'; // Texto a mostrar

        $pdf->SetFontSpacing(0);

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================STPS====================

        #================FIRMA OSCAR====================
        $x = 30; // Coordenada X
        $y = 187; // Coordenada Y
        $width = 30; // Ancho de la imagen (en puntos)
        $height = 20; // Altura de la imagen (0 para ajustar automáticamente)

        $imagePath = base_url('/resources/img/firmas/DrOscarAguilar.png');

        $pdf->SetXY($x, $y);
        $pdf->Image($imagePath, $x, $y, $width, $height);


        $x = 20;  // Posición X
        $y = 203;  // Posición Y
        $width = 50;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $pdf->SetFontSpacing(0);

        $texto = 'Oscar Cuauhtémoc Aguilar Rascón'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FIRMA OSCAR====================

        #================FIRMA PAU====================
        $x = 83; // Coordenada X
        $y = 189; // Coordenada Y
        $width = 30; // Ancho de la imagen (en puntos)
        $height = 20; // Altura de la imagen (0 para ajustar automáticamente)

        $imagePath = base_url('/resources/img/firmas/PaulaMejia.png');

        $pdf->SetXY($x, $y);
        $pdf->Image($imagePath, $x, $y, $width, $height);


        $y = 203;  // Posición Y
        $width = 50;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $pdf->SetFontSpacing(0);

        $texto = 'Paula Berenice Mejía Ávila'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FIRMA PAU====================

        #================FIRMA PAU====================
        $x = 140; // Coordenada X
        $y = 189; // Coordenada Y
        $width = 30; // Ancho de la imagen (en puntos)
        $height = 20; // Altura de la imagen (0 para ajustar automáticamente)

        $imagePath = base_url('/resources/img/firmas/VictoriaVelazquez.png');

        $pdf->SetXY($x, $y);
        $pdf->Image($imagePath, $x, $y, $width, $height);


        $y = 203;  // Posición Y
        $width = 50;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $pdf->SetFontSpacing(0);

        $texto = 'Victoria Velázquez Moreno'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 8;
        $fontFamily = 'century_gothic';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FIRMA PAU====================

        $pdf->SetPrintHeader(false); // Desactiva la impresión del encabezado

        $pdf->AddPage('P');

        $imagePath = base_url('resources/img/cursos/dc3_2.jpg'); // Ruta de la imagen que deseas agregar

        $pdf->Image($imagePath, 0, 0, 297, 300);

        $pdfPath = ROOTPATH . 'public/zip/dc_3_'. strval(time()).'.pdf';

        $pdf->Output($pdfPath, 'F');

        return $pdfPath;
    }

    public function reenviar_correo_inscripcion($id){
        $condiciones = ['id' => $id];
        $info = $this->CursosModel->getAllOneRow('registros_cursos',$condiciones);

        if(!empty($info)){
            $pais = $info['pais'];
            $paquete = $info['paquete'];

            $dataCorreo = [
                'nombre' => $info['nombre']
            ];

            ob_start();
                // Cargar la vista y capturar la salida en una variable
            echo view('admin/cursos/correos_metodologia/'.$paquete.'.php',$dataCorreo);
            $htmlCurso = ob_get_contents();
            ob_end_clean();
            
            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
            $email->setTo($info['correo']);
            $email->setCC('pmejiaa@redesla.la');
            $email->setSubject('Confirmación de inscripción al curso-taller "Cómo Desarrollar Artículos Científicos Válidos: Metodología de la Investigación');
            $email->setMessage($htmlCurso);

            if ($email->send()) {
                return redirect()->back()
                ->with('icon', 'success')
                ->with('title', 'Listo')
                ->with('text', 'Correo reenviado correctamente.');
            } else {
                return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Contacte a sistemas.');
            }
        }
    }

    public function correo_dc3($id_curso){
        switch ($id_curso) {
            case 1:
                $condiciones_extras = "(anio_curso = '19-26-02')";
                break;
            default:
                http_response_code(300);
                exit;
                return;
        }

        $id_constancias = $_POST['constancias'];

        foreach ($id_constancias as $id) {
            $condiciones = ['id' => $id];
            $info = $this->CursosModel->getAllOneRow('registros_cursos', $condiciones);

            if (empty($info)) {
                http_response_code(301);
            }

            $correo = $info['correo'];
            $nombre_participante = $info['nombre'];

            $html = "
            <p>Apreciable participante <b>{$nombre_participante}</b></p>
            <p>Le envío un cordial saludo por este medio a nombre de <b>Redes de Estudios Latinoamericanos (RedesLA)</b></p>
            <p>
            El motivo de este mensaje es felicitarlo por haber acreditado exitosamente el curso-taller: 
            Cómo Desarrollar Artículos Científicos Válidos: Metodología de la Investigación, por ello nos 
            permitimos compartirle el siguiente enlace: https://redesla.la/cursos/constancias/
            </p>
            <p>
            En el cual puede obtener la constancia de participación por medio de su correo: <b>{$correo}</b>
            Esta constancia es adquirida al cumplir satisfactoriamente con las 30 horas del curso y 
            el envío de las actividades asignadas dentro de los talleres del curso. 
            </p>
            <p>
            Agradecemos su compromiso y confianza en REDESLA y todo el equipo, esperamos que dicha 
            participación contribuya de manera significativa a su formación profesional como investigador.
            </p>
            <p>
            Quedamos a sus órdenes para atender cualquier duda al respecto, saludos cordiales.
            </p>
            <p>
            Lo invitamos a seguirnos en Facebook, sitio en el que encontrará las fotos de la Cabina Fotográfica: 
            https://www.facebook.com/ViveRedesLA 
            </p>
            <p>
            <img src='" . base_url('/resources/img/firmas/Atención_RedesLA.jpg') . "'>
            </p>
            ";

            $ruta_dc_3 = $this->dc3_attachment($info['id']);

            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
            $email->setTo($correo);
            $email->setSubject('Gracias por ser parte de nuestro curso-taller en línea "Cómo Desarrollar Artículos Científicos Válidos: Metodología de la Investigación"');
            $email->setMessage($html);
            $email->attach($ruta_dc_3, 'attachment');

            if (!$email->send()) {
                http_response_code(600);
                echo 'No se ha podido enviar el correo. El correo en cuestion es: ' . $correo;
                exit;
            }
        }

        $respuesta = array(
            "title" => "Hecho",
            'mensaje' => 'Se ha enviado el correo',
            "codigo" => 200,
        );
        $json_respuesta = json_encode($respuesta);
        echo $json_respuesta;
        exit;
    }

    #===================CURSOS==========================

    #===================CARPETAS=========================
    #Hecho por Mario
    public function carpetas()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/carpetas/lista')
            . view('admin/footers/index');
    }

    public function getListadoCarpetas()
    {
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = ['id', 'claveCuerpo', 'red', 'ano_carpeta', 'envios', 'recibidos'];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM carpetas";
        $sql_data = "SELECT * FROM carpetas";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            $htmlEditar = '<a type="button" href="editar/' . $a['id'] . '" class="btn btn-warning btn-icon-text btn-rounded">
            <i class="mdi mdi-lead-pencil"></i> Editar </a>';

            if ($a['red'] == 'Releg') {
                $htmlRecibidos = '<a href="' . $a['recibidos'] . '" target="_blank" class="btn btn-info btn-icon-text btn-rounded">Ir a recibidos</a>';
            } else {
                $htmlRecibidos = '<a href="https://drive.google.com/drive/u/0/folders/' . $a['recibidos'] . '" target="_blank" class="btn btn-info btn-icon-text btn-rounded">Ir a recibidos</a>';
            }
            $htmlEnvios = '<a href="https://drive.google.com/drive/u/0/folders/' . $a['envios'] . '" target="_blank" class="btn btn-info btn-icon-text btn-rounded">Ir a Envios</a>';

            $array[$key] = [
                'id' => $a['id'],
                'claveCuerpo' => $a['claveCuerpo'],
                'red' => $a['red'],
                'ano_carpeta' => $a['ano_carpeta'],
                'envios' => $htmlEnvios,
                'recibidos' => $htmlRecibidos,
                'editar' => $htmlEditar,
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

    public function editarCarpetas($id)
    {

        $condiciones = ['id' => $id];
        $carpeta = $this->AdminModel->getAllOneRow('carpetas', $condiciones);

        if (empty($carpeta)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', '>La carpeta al que quiere acceder no existe');
        }

        $data['carpeta'] = $carpeta;
        return view('admin/headers/index')
            . view('admin/carpetas/editar', $data)
            . view('admin/footers/index');
    }

    #===================CARPETAS========================

    #======================FACTURAS================================

    

    #======================FACTURAS================================

    #===========================DESCARGA_RELEG=====================

    public function descarga_releg()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/descarga_releg/lista')
            . view('admin/footers/index');
    }

    public function getlistadescarga()
    {
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = ['id', 'claveCuerpo', 'nombre'];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM cuerpos_academicos";
        $sql_data = "SELECT * FROM cuerpos_academicos";

        $condicion = "";
        #SELECT * FROM cuerpos_academicos WHERE redCueCa = 'Releg' WHERE id like "%valor%"
        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {

                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%' OR redCueCa = 'Releg' ";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count .= empty($condicion) ? ' WHERE redCueCa = "Releg"' : $condicion;
        $sql_data .= empty($condicion) ? ' WHERE redCueCa = "Releg"' : $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            //$A['CLAVECUERPO'].'.docx'
            $archivo = $a['claveCuerpo'] . '.docx';
            $ruta = 'public/docx/investigaciones/Releg/2022/';
            $ruta_completo = ROOTPATH . $ruta . $archivo;
            if (!file_exists($ruta_completo)) {

                $htmlDescargar =  '<label class="text-warning">El archivo no existe</label>';
            } else {
                $htmlDescargar = '<a href="' . base_url('/admin/descargar/capitulo_releg/' . $a['claveCuerpo']) . '.docx" class="btn btn-secondary btn-rounded" >Descargar capítulo</a>';
            }

            $array[$key] = [
                'id' => $a['id'],
                'claveCuerpo' => $a['claveCuerpo'],
                'nombre' => $a['nombre'],
                'descarga' => $htmlDescargar

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

    public function descargar()
    {
        $ruta = 'public/docx/investigaciones/Releg/2022/';
        $array = array_filter(scandir($ruta, SCANDIR_SORT_DESCENDING), function($item) use ($ruta) {
            $rutaCompleta = $ruta . $item;
            return is_file($rutaCompleta);
        });

        foreach ($array as $archivo) {
            $claveCuerpo = basename($archivo, ".docx");
            // Realizar consulta SQL utilizando la variable $claveCuerpo
            $columnas = ['nombre', 'estado', 'municipio'];
            $condiciones = ['claveCuerpo' => $claveCuerpo];
            $cuerpos_academicos = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
            $condiciones2 = ['id' => $cuerpos_academicos['estado']];
            $condiciones3 = ['id' => $cuerpos_academicos['municipio']];
            $estado = $this->AdminModel->getAllOneROw('estados', $condiciones2);
            $municipio = $this->AdminModel->getAllOneROw('municipios', $condiciones3);
            $municipio_ca = $this->AdminModel->getAll('municipios_ca', $condiciones);

            $str_municipios = '';

            if (!empty($estado)) {
                $cuerpos_academicos['estado'] = $estado['nombre'];
            }
            if (!empty($municipio)) {
                $str_municipios .= $municipio['nombre'];
            } else {
                $str_municipios .= $cuerpos_academicos['municipio'];
            }

            if (!empty($municipio_ca)) {
                foreach ($municipio_ca as $key => $mca) {
                    $valor = $mca['nombre_municipio'];
                    if ($mca == end($municipio_ca)) {
                        $str_municipios .= ' y ' . $valor;
                    } else {
                        $str_municipios .= ', ' . $valor;
                    }
                }
            }

            $cuerpos_academicos['municipio'] = $str_municipios;

            $cuerpos_academicos['nombre_completo'] = $estado['nombre'] . '. ' . $str_municipios;

            $arr_2[] = [
                'nombre_completo' => $estado['nombre'] . '. ' . $str_municipios,
                'estado' => $estado['nombre'],
                'municipio' => $municipio['nombre'],
                'claveCuerpo' => $claveCuerpo
            ];
        }


        array_multisort(array_column($arr_2, 'nombre_completo'), SORT_ASC, $arr_2);
        $zipFile = new \PhpZip\ZipFile();
        foreach ($arr_2 as $key => $a) {
            $archivo = $a['claveCuerpo'] . '.docx';
            $ruta = 'public/docx/investigaciones/Releg/2022/';
            $ruta_completo = ROOTPATH . $ruta . $archivo;
            $zipFile->addFile($ruta_completo, $a['nombre_completo'] . '.docx');
        }
        $zipFile->outputAsAttachment(mb_strtoupper('archivos_ordenados.zip'));
        #ORDENAR $cuerpos_academicos POR ORDEN asc
        #ARRAYCOLUMN(ARRAY MULTISORT)



    }

    public function descarga_digital_releg()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/descarga_releg/digital/lista')
            . view('admin/footers/index');
    }

    public function getlistadescargaDigitales()
    {
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = ['id', 'claveCuerpo', 'nombre'];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM cuerpos_academicos";
        $sql_data = "SELECT * FROM cuerpos_academicos";

        $condicion = "";
        #SELECT * FROM cuerpos_academicos WHERE redCueCa = 'Releg' WHERE id like "%valor%"
        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {

                if ($columnas[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%' OR redCueCa = 'Releg' ";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count .= empty($condicion) ? ' WHERE redCueCa = "Releg"' : $condicion;
        $sql_data .= empty($condicion) ? ' WHERE redCueCa = "Releg"' : $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {

            //$A['CLAVECUERPO'].'.docx'
            $archivo = $a['claveCuerpo'] . '.docx';
            $ruta = 'public/docx/investigaciones/Releg/2022/digital/';
            $ruta_completo = ROOTPATH . $ruta . $archivo;
            if (!file_exists($ruta_completo)) {

                $htmlDescargar =  '<label class="text-warning">El archivo no existe</label>';
            } else {
                $htmlDescargar = '<a href="' . base_url('/admin/descargar/capitulo_releg_digital/' . $a['claveCuerpo']) . '.docx" class="btn btn-secondary btn-rounded" >Descargar capítulo</a>';
            }

            $array[$key] = [
                'id' => $a['id'],
                'claveCuerpo' => $a['claveCuerpo'],
                'nombre' => $a['nombre'],
                'descarga' => $htmlDescargar

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

    public function descargarDigital()
    {
        $ruta = 'public/docx/investigaciones/Releg/2022/digital/';
        $array = array_diff(scandir($ruta, SCANDIR_SORT_DESCENDING), array('..', '.'));

        foreach ($array as $archivo) {
            $claveCuerpo = basename($archivo, ".docx");
            // Realizar consulta SQL utilizando la variable $claveCuerpo
            $columnas = ['nombre', 'estado', 'municipio'];
            $condiciones = ['claveCuerpo' => $claveCuerpo];
            $cuerpos_academicos = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
            $condiciones2 = ['id' => $cuerpos_academicos['estado']];
            $condiciones3 = ['id' => $cuerpos_academicos['municipio']];
            $estado = $this->AdminModel->getAllOneROw('estados', $condiciones2);
            $municipio = $this->AdminModel->getAllOneROw('municipios', $condiciones3);
            $municipio_ca = $this->AdminModel->getAll('municipios_ca', $condiciones);

            $str_municipios = '';

            if (!empty($estado)) {
                $cuerpos_academicos['estado'] = $estado['nombre'];
            }
            if (!empty($municipio)) {
                $str_municipios .= $municipio['nombre'];
            } else {
                $str_municipios .= $cuerpos_academicos['municipio'];
            }

            if (!empty($municipio_ca)) {
                foreach ($municipio_ca as $key => $mca) {
                    $valor = $mca['nombre_municipio'];
                    if ($mca == end($municipio_ca)) {
                        $str_municipios .= ' y ' . $valor;
                    } else {
                        $str_municipios .= ', ' . $valor;
                    }
                }
            }

            $cuerpos_academicos['municipio'] = $str_municipios;

            $cuerpos_academicos['nombre_completo'] = $estado['nombre'] . '. ' . $str_municipios;

            $arr_2[] = [
                'nombre_completo' => $estado['nombre'] . '. ' . $str_municipios,
                'estado' => $estado['nombre'],
                'municipio' => $municipio['nombre'],
                'claveCuerpo' => $claveCuerpo
            ];
        }


        array_multisort(array_column($arr_2, 'nombre_completo'), SORT_ASC, $arr_2);
        $zipFile = new \PhpZip\ZipFile();
        foreach ($arr_2 as $key => $a) {
            $archivo = $a['claveCuerpo'] . '.docx';
            $ruta = 'public/docx/investigaciones/Releg/2022/digital';
            $ruta_completo = ROOTPATH . $ruta . $archivo;
            $zipFile->addFile($ruta_completo, $a['nombre_completo'] . '.docx');
        }
        $zipFile->outputAsAttachment(mb_strtoupper('capitulos_digitales_RELEG_2022.zip'));
        #ORDENAR $cuerpos_academicos POR ORDEN asc
        #ARRAYCOLUMN(ARRAY MULTISORT)



    }

    public function generarCapitulosDigitalesReleg2023(){

        $claveCuerpo = 'MXM-UTCJ01';

        $condiciones = [
            'claveCuerpo' => $claveCuerpo
        ];

        $columnas = ['categoria'];

        $categorias_grupo_arr = $this->AdminModel->getAllDistinc($columnas,'filtro_categorias',$condiciones);

        $categorias_grupo = [];
        foreach($categorias_grupo_arr as $c){
            array_push($categorias_grupo,$c['categoria']);
        }

        $condiciones = [];
        $dimensiones = $this->AdminModel->getAll('dimensiones', $condiciones);

        $arr_grupos = [];

        foreach ($dimensiones as $key => $g) {
            #obtenemos las escalas (si aplica)
            $condiciones = ['id_dimension' => $g['id']];
            $escalas = $this->AdminModel->getAll('escalas', $condiciones);

            $arr_grupos[$key]['dimension'] = $g['nombre'];

            if (!empty($escalas)) {
                foreach ($escalas as $keyEscalas => $e) {
                    $arr_grupos[$key]['escalas'][$keyEscalas]['nombre'] = $e['nombre'];
                    $condiciones = ['dimension' => $g['id'], 'escala' => $e['id']];
                    $categorias = $this->AdminModel->getAll('categorias', $condiciones);

                    foreach ($categorias as $key2 => $c) {
                        if(in_array($c['id'],$categorias_grupo)){
                            $arr_grupos[$key]['escalas'][$keyEscalas]['categorias'][$key2]['nombre'] = $c['nombre'];
                            $arr_grupos[$key]['escalas'][$keyEscalas]['categorias'][$key2]['id'] = $c['id'];
                        }
                    }
                }
                #$arr_grupos[$key]['c_categorias'] = $c_categorias;
                continue;
            }

            $condiciones = ['dimension' => $g['id']];
            $categorias = $this->AdminModel->getAll('categorias', $condiciones);

            #$arr_grupos[$key]['nombre'] = $g['nombre'];

            foreach ($categorias as $key2 => $c) {
                if(in_array($c['id'],$categorias_grupo)){
                    $arr_grupos[$key]['categorias'][$key2]['nombre'] = $c['nombre'];
                    $arr_grupos[$key]['categorias'][$key2]['id'] = $c['id'];
                }
            }
        }

        $data = $this->getDataCapituloImpresoReleg($claveCuerpo);

        $clavePorcentaje = array_search(max($data['porcentajes_tipo_institucion']), $data['porcentajes_tipo_institucion']);

        $tipo_institucion = $clavePorcentaje == 'público' ? 'pública' : 'privada';

        $n_autores = count($data['ordenes_autores']);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $phpWord->addTitleStyle(1, array('size' => 14, 'bold' => true, 'color' => '4472c4'), array('alignment' => 'left'));
        $phpWord->addTitleStyle(2, array('size' => 12, 'bold' => true, 'color' => '4472c4'), array('alignment' => 'left'));

        $sangria = array(
            'indentation' => [
                'firstLine' => 720
            ],
            'alignment' => 'both'
        );

        $fontStyle = [
            'name' => 'Arial',
            'size' => '12',
            'lineHeight' => 1.5
        ];

        $fontStyle2 = [
            'name' => 'Arial',
            'size' => '12',
            'lineHeight' => 1.5,
            'italic' => true
        ];

        $fontBold = [
            'name' => 'Arial',
            'size' => '12',
            'lineHeight' => 1.5,
            'bold' => true
        ];

        $fontFooter = [
            'name' => 'Arial',
            'size' => '10',
            'lineHeight' => 1,
        ];

        $pFooterStyle = [
            'alignment' => 'both'
        ];



        $section->addTitle("Capítulo ~no_capitulo~. Los obstáculos que tienen las estudiantes de la {$data['universidad']} que dirigen una micro o pequeña empresa en {$data['municipios']}.",1);

        $section->addText('');
        // Agregar la lista al documento
        $section->addList();

        // Agregar elementos a la lista sin especificar el tipo de viñeta
        foreach ($data['ordenes_autores'] as $elemento) {
            $section->addListItem($elemento,0,$fontStyle);
        }


        $tableStyle = array(
            'borderColor' => '000000',
            'borderSize'  => 6,
            'cellMargin'  => 50,
            'alignment' => 'center'
        );

        $firstRowStyle = array('bgColor' => 'D3D3D3');

        $tableBoldTitles = [
            'bold' => true
        ];

        $cellRowContinue = array('vMerge' => 'continue');
        $cellRowSpan = array('vMerge' => 'restart');
        
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        // Crear la tabla
        $table = $section->addTable('myTable');
        $table->addRow();
        $table->addCell(5000)->addText('Dimensión tema',$tableBoldTitles);
        $table->addCell(5000)->addText('Escala',$tableBoldTitles);
        $table->addCell(5000)->addText('Categorias',$tableBoldTitles);

        /* foreach($arr_grupos as $a){
            $dimension = $a['dimension'];
            $table->addRow();
            $table->addCell(5000)->addText($dimension);
        } */

        $lastDimension = null;

        foreach ($arr_grupos as $row) {
            $dimension = $row['dimension'];

            if(isset($row['escalas'])){
                foreach ($row['escalas'] as $escala) {
                    $escalas = $escala['nombre'];
                    $categorias = '';
    
                    foreach ($escala['categorias'] as $categoria) {
                        $categorias .= '● '.$categoria['nombre'] . "\n";
                    }
                    // Divide el texto en líneas separadas
                    $lineas = explode("\n", $categorias);
    
                    $table->addRow();
                    if ($lastDimension !== $dimension) {
                        $dimensionCell = $table->addCell(3000,$cellRowSpan);
                        $dimensionCell->addText($dimension);
                        $lastDimension = $dimension;
                    } else {
                        $dimensionCell = $table->addCell(null,$cellRowContinue);
                    }
                    $table->addCell(3000)->addText($escalas);
                    $cell = $table->addCell(6000);
                    foreach ($lineas as $linea) {
                        if(!empty($linea)){
                            $cell->addText($linea);
                        }
                    }
                }
            }else{
                $table->addRow();
                $table->addCell(3000)->addText($dimension);
                $table->addCell(3000)->addText('');

                $categorias = '';
    
                foreach ($row['categorias'] as $categoria) {
                    $categorias .= '● '.$categoria['nombre'] . "\n";
                }
                // Divide el texto en líneas separadas
                $lineas = explode("\n", $categorias);

                $cell = $table->addCell(6000);
                foreach ($lineas as $linea) {
                    if(!empty($linea)){
                        $cell->addText($linea);
                    }
                }
            }
        }

        /* foreach ($arr_grupos as $row) {
            $dimension = $row['dimension'];
            $escalas = '';
            $categorias = '';
            
            if(isset($row['escalas'])){
                foreach ($row['escalas'] as $escala) {
                    $escalas .= $escala['nombre'] . "\n";
                    foreach ($escala['categorias'] as $categoria) {
                        $categorias .= $categoria['nombre'] . "\n";
                    }
                }
            }
        
            $table->addRow();
            $table->addCell(3000)->addText($dimension);
            $table->addCell(3000)->addText($escalas);
            $table->addCell(6000)->addText($categorias);
        } */












        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $filePath = ROOTPATH . 'public/docx/investigaciones/Releg/2022/digital/' . $claveCuerpo . '.docx';

        if(file_exists($filePath)){
            unlink($filePath);
        }
        $objWriter->save($filePath);
        exit;



        $section->addTitle("Resumen",2);
        $section->addText("La participación de la mujer en la esfera pública toma sin duda cada vez mayor relevancia, el ingreso a la educación superior y su participación en el ámbito laboral cada vez es más destacada, sin embargo, el camino sigue siendo difícil para la gran mayoría de ellas y lo es más aún cuando a la par llevan a cabo ambas actividades: son estudiantes universitarias y son directoras de una micro o pequeña empresa. Es por ello que la presente investigación ha sido desarrollada con el fin de conocer aquellos obstáculos a los que se enfrentan las mujeres universitarias al dirigir una micro o pequeña empresa. En este capítulo se presentan los resultados del estudio cualitativo llevado a cabo en {$data['universidad']}, en {$data['municipios']}. Se lleva a cabo el análisis de resultados bajo el contexto de los estudios de género, resultados pertinentes para la toma de decisiones que beneficie a la equidad entre hombres y mujeres.",$fontStyle,$sangria);

        $section->addTitle("Palabras clave",2);
        $section->addText('Mujeres directivas / Estudiantes Universitarias /Micro y Pequeñas empresas/ Obstáculos.',$fontStyle,$sangria);

        $section->addTitle("Introducción",2);
        $section->addText('Para las mujeres estudiar una carrera universitaria y dirigir una micro o pequeña empresa les proporciona un doble acceso a la esfera pública, una esfera que les abre oportunidades permitiendo tener una participación activa fuera de su espacio privado, ganando espacios que les permiten aportar en la economía del país y de la región en la que se desarrollan.',$fontStyle,$sangria);

        $textrun = $section->addTextRun($sangria);
        $textrun->addText('En México el 51.2% de la población total son mujeres (Instituto Nacional de Geografía y Estadística [INEGI], 2020) y de acuerdo con el Instituto Mexicano de la Competitividad (2022) ',$fontStyle);
        $textrun->addText('4 de cada 10 mujeres ',$fontBold);
        $textrun->addText('participan en la economía, mientras que ',$fontStyle);
        $textrun->addText('7 de cada 10 hombres lo hacen',$fontBold);
        $textrun->addText('. De estas mujeres que participan en las actividades económicas del país, se encuentran quienes dirigen a 1,472,000 micro y pequeñas empresas mexicanas',$fontStyle,$sangria);
        $footnote = $textrun->addFootnote();
        $footnote->addText('Cifra obtenida a partir del análisis de datos proporcionados por INEGI (2020) y Secretaría de Economía [SE] (citado en Forbes, 2023), al considerar el número total de unidades económicas y a partir de ello determinar la proporción de únicamente el porcentaje de Micro y Pequeñas Empresas, para posteriormente considerar el porcentaje que correspondería para las unidades económicas propiedad de mujeres.',$fontFooter,$pFooterStyle);
        $textrun->addText(' De acuerdo, al análisis de datos proporcionados por el INEGI el 31.14% de la Micro y Pequeña Empresa',$fontStyle);
        $footnote = $textrun->addFootnote();
        $footnote->addText('Porcentaje obtenido a partir del análisis de datos proporcionados por INEGI (2020) y SE (citado en Forbes, 2023), de acuerdo a la cifra obtenida en cuanto al número de micro y pequeñas empresas lidereadas por mujeres.',$fontFooter,$pFooterStyle);
        $textrun->addText(' es liderada por mujeres en México y por lo tanto de acuerdo con los resultados de la Encuesta Nacional de Ocupación y Empleo-Nueva Edición [ENOEN] (2023) estas mujeres dieron empleo a 2.9 millones de personas (cifra que contempla a las propietarias mismas).',$fontStyle);
        

        $section->addText('El porcentaje de mujeres que en México estudian nivel superior, es del 51% (INEGI, 2023), es importante señalar que a pesar que el porcentaje está por encima del total de hombres  universitarios, al momento de ingresar al campo laboral, la cifra de mujeres se reduce, ésta situación deriva de una serie de factores que impiden que las mujeres puedan desarrollarse en el campo laboral, y se reduce aún más la cifra de aquéllas que se encuentran estudiando una carrera universitaria y al mismo tiempo  dirigen una micro o pequeña empresa siendo dueñas o empleándose lo que conlleva enfrentar a estas estudiantes-directoras de mypes una serie de obstáculos que determina el contexto en el que se desenvuelven con sus actividades. Obstáculos que provienen tanto de su espacio privado, su espacio doméstico y del propio espacio público, lo que dificulta que se lleven de manera eficiente los resultados de su organización y/o su desempeño académico.',$fontStyle,$sangria);

        $section->addText("¿Cuáles son entonces estos obstáculos que impiden a estas universitarias de {$data['universidad']} de {$data['only_municipios']}, {$data['estado']} la correcta gestión de sus empresas?, de esta pregunta parte el análisis que en este capítulo se presenta y para el cual se llevó a cabo un estudio cualitativo aplicando un total de {$data['c_entrevistas']} a mujeres estudiantes universitarias que dirigen una micro o pequeña empresa, un estudio que es parte de una investigación con otras 30 universidades mexicanas en las cuales se aplicó a estudiantes universitarias la misma entrevista y se llevo a cabo el análisis de resultados bajo el mismo proceso, lo que permitirá tener una radiografía de este grupo importante de la sociedad, un grupo con una gran necesidad de visibilizar.",$fontStyle,$sangria);

        $section->addTitle("Revisión de la Literatura",2);
        $section->addText('Este capítulo ha sido desarrollado en el contexto de la investigación cualitativa “Los obstáculos que tienen las estudiantes universitarias que dirigen una micro o pequeña empresa”, por lo que la argumentación teórica para el análisis de resultados se retomó del apartado general de “Revisión de la Literatura” de esta misma obra.',$fontStyle,$sangria);

        

        $section->addTitle("Método",2);
        $section->addText('Esta investigación por la naturaleza del planteamiento de su objetivo fue abordada desde un enfoque cualitativo, toda vez que se busca conocer los obstáculos que tienes las estudiantes universitarias mexicanas en la dirección de su micro o pequeña empresa:',$fontStyle,$sangria);

        $section->addText('Del porqué de la selección del diseño de investigación cualitativa radica principalmente en las siguientes características:',$fontStyle,$sangria);

        $section->addText('1.- La investigación cualitativa permite al investigador estudiar a las personas en su contexto, en las situaciones en las que se encuentra (Álvarez-Gayou, 2007).',$fontStyle,$sangria);

        $section->addText('2.- En la perspectiva cualitativa existe una visión holística que “que evita que los sujetos y las acciones nos sean reducidos a variables, sino entendidas como partes de un todo” (Vega, 2004, p. 226).',$fontStyle,$sangria);

        $section->addText('3.- La perspectiva cualitativa y su carácter humanista, que permite al investigador un acercamiento íntimo al mundo de los sujetos investigados (Taylor y Bodgan, 1996).',$fontStyle,$sangria);

        $section->addText('En tanto, el marco referencial interpretativo utilizado para la presente investigación fue el análisis fenomenográfico (Álvarez-Gayou, 2007), dado que se busca conocer las formas en cómo experimentan y perciben las mujeres de este estudio el fenómeno de los obstáculos que se presentan en la gestión de sus organizaciones.',$fontStyle,$sangria);

        $section->addText('De igual forma, para la presente investigación se utilizaron elementos de lo que se conoce como diseño sistemático, en el cual se consideran ciertos pasos para el análisis de los datos obtenidos, a partir de los cuales se desarrolla una codificación y luego se efectúa la generación de categorizaciones (Hernández Sampieri et al., 2014, p. 473), estos elementos derivan a partir de lo que se conoce como teoría fundamentada donde la teoría va emergiendo de los hallazgos, fundamentada en los datos obtenidos durante la investigación, por lo tanto, su propósito general es descubrir una teoría (Álvarez-Gayou, 2007; Hernández Sampieri et al., 2014).',$fontStyle,$sangria);

        $section->addTitle("Contexto o ambiente inicial",2);
        $section->addText('Tal como se mencionó en el capítulo de Método General, en el mes de mayo del 2022, las autoras de este capítulo recibimos capacitación por parte del Comité Académico de la Red Latinoamericana de Estudios de Género, para la determinación de la muestra así, aplicación del instrumento, captura de información y análisis de resultados.',$fontStyle,$sangria);

        $section->addText("Esta investigación se llevó a cabo en la Institución {$tipo_institucion} {$data['universidad_completo']}",$fontStyle,$sangria);

        $section->addText("Se aplicaron un total de {$data['c_entrevistas']} entrevistas a alumnas de la institución, las cuales se llevaron de manera presencial dentro de los cubículos de las docentes y en otros casos se solicitó que fuera vía la plataforma zoom o alguna similar, la elección de esta modalidad dependía de la disponibilidad de la entrevistada. En ambas modalidades las universitarias se encontraban en lugares de desarrollo de sus actividades cotidianas. El promedio de duración de cada entrevista fue de 15 a 20 minutos en promedio. Al finalizar la aplicación de las entrevistas se llevó a cabo el llenado de la bitácora con todos aquellos aspectos pertinentes para la interpretación de información. Todas las entrevistas fueron grabadas y colocadas en el espacio virtual que desarrolló RELEG para captura de información. Posteriormente se hizo de manera manual o apoyadas en software especializado la transcripción de las entrevistas. De igual manera se creo un directorio con los datos para de las universitarias con el fin de mantener el contacto con ellas para cualquier aclaración durante el análisis de los datos.",$fontStyle,$sangria);

        $section->addText("El levantamiento de datos se ejecutó en los meses de mayo y junio del año 2022.",$fontStyle,$sangria);

        $section->addTitle("Muestra",2);
        $section->addText("Se contó con la participación de {$data['c_entrevistas']} estudiantes, universitarias, quienes fueron reclutadas por {$n_autores} docentes investigadoras (es) de la institución estudiada.",$fontStyle,$sangria);

        $section->addText("Las entrevistadas contactadas fueron alumnas, tutoradas, asesoras o conocidas de que contaban con las características solicitadas, no era necesario que dichas entrevistas hubiesen sido alumnas directas de las investigadoras.",$fontStyle,$sangria);

        $section->addText("La muestra para esta investigación es de tipo homogénea, donde las unidades que fueron seleccionadas “poseen un mismo perfil o características, o bien comparten datos similares” (Hernández Sampieri et al., 2014, p. 388), es por ello que los criterios de selección solicitados por RELEG fueron los siguientes:",$fontStyle,$sangria);

        $phpWord->addNumberingStyle(
            'multilevel',
            array(
                'type' => 'multilevel',
                'levels' => array(
                    array('format' => 'decimal', 'text' => '%1.-', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
                    array('format' => \PhpOffice\PhpWord\SimpleType\NumberFormat::LOWER_LETTER, 'text' => '%1%2)', 'left' => 720, 'hanging' => 360, 'tabPos' => 720),
                )
            )
        );
        $section->addListItem('Mujer estudiante universitaria o nivel académico equivalente.', 0, $fontStyle, 'multilevel');
        $section->addListItem('Que se encuentre estudiando cualquier grado académico.', 0, $fontStyle, 'multilevel');
        $section->addListItem('Que dirija o sea dueña de una micro o pequeña empresa, la cual cuente por lo menos con 1 año de operación.', 0, $fontStyle, 'multilevel');
        $section->addListItem('Las estudiantes universitarias pertenecen a la misma institución.', 0, $fontStyle, 'multilevel');
        $section->addListItem('Directora o dueña de una micro o pequeña empresa (Mype):', 0, $fontStyle, 'multilevel');
        $section->addListItem('Tal como se ha señalado se considera directora a la persona que toma la mayoría de las decisiones en la organización.', 1, $fontStyle, 'multilevel');
        $section->addListItem('Una Mype es una organización en la que se gestionan diversas clases de recursos, que tiene fines de lucro y en la que participan diversos actores como clientes, proveedores, que tenga al menos un empleado y 1 año de operación.', 1, $fontStyle, 'multilevel');

        $section->addText("Alternativamente en la muestra también se encuentran estudiantes universitarias que dirigen o son dueñas de una organización que cuenta con todas las características, salvo el requisito de tener empleados, es decir, puede podían no tener empleados, pero: Se excluyeron particularmente las estudiantes en un esquema de autoempleo que implicaba la pérdida de la autonomía en la gestión de la organización, tales como: la venta por catálogo o esquemas piramidales.",$fontStyle,$sangria);

        $section->addTitle("Características de las universitarias de {$data['universidad']}",2);
        $section->addText("Muestra: {$data['c_entrevistas']} universitarias directivas de micro o pequeñas empresas.",$fontStyle,$sangria);

        $section->addText('');
        $section->addText("Conforme a los datos obtenidos a través del instrumento se identificaron características de las Mypes dirigidas o propiedad de las universitarias de {$data['universidad']}. La modalidad en la que trabajan estas empresas es: {$data['porcentaje_modalidades']['física']}% de manera física, {$data['porcentaje_modalidades']['virtual']}% de manera virtual y {$data['porcentaje_modalidades']['mixta']}% de manera mixta.",$fontStyle,$sangria);

        $section->addText("Las Mypes que dirigen estas estudiantes tienen en promedio {$data['promedio_personas']} personas que trabajan permanentemente en estas organizaciones, de las cuales en promedio {$data['promedio_mujeres']} son mujeres y {$data['promedio_familiares']} de ellos son familiares contratadas (os).",$fontStyle,$sangria);

        $section->addTitle("Instrumento y recolección de datos",2);
        $section->addText("La técnica que se utilizó para esta investigación cualitativa fue la entrevista y cuyo diseño de cuestionario fue proporcionado a todos los equipos participantes de esta investigación a nivel nacional por el Comité Académico de RELEG.",$fontStyle,$sangria);

        $section->addText("La entrevista está estructurada por 5 bloques. El primero que aborda los Datos Generales de la aplicación de la entrevista los cuales apoyarán para la confiabilidad de la información, así como la validez y seguimiento si es necesario. El segundo bloque que aborda “Las características sociodemográficas de la universitaria dueña o administradora de la Mype”, tercer bloque contempla los datos de la institución donde estudia la directiva y el cuarto sobre los datos de la Mype. La entrevista contempla 24 preguntas y fue diseñada para ser contestada por la directora de la empresa (persona que toma la mayor parte de las decisiones de la organización), y para ser aplicada por cualquiera de las y los integrantes del equipo de investigación, por lo que se pudo dividir el número total de entrevistas a aplicar. Cada entrevistadora o entrevistador conocía el protocolo de aplicación y llevó a cabo en totalidad el proceso de la entrevista hasta la captura, así como lo necesario para darle seguimiento a las siguientes fases del proceso de investigación.",$fontStyle,$sangria);

        $section->addText("El equipo de investigación también pudo apoyarse con algún equipo de alumnas para la realización de la entrevista, sin embargo, éstas debían tener una capacitación previa para tal aplicación.",$fontStyle,$sangria);

        $textrun = $section->addTextRun($sangria);
        $textrun->addText('Finalmente se capturó la información obtenida en las entrevistas en la Plataforma para Estudios Cualitativos Redesla ',$fontStyle);
        $textrun->addText('Comprende',$fontStyle2);
        $textrun->addText("™, en el apartado creado para el estudio de {$data['universidad']}",$fontStyle);

        $textrun = $section->addTextRun($sangria);
        $textrun->addText('La primera fase consistió en que se tuvieron que transcribir las entrevistas del dispositivo móvil o de lo guardado a partir de la plataforma de telecomunicación (si es que fue utilizado) en el que se grabaron las sesiones de la entrevista a la plataforma ',$fontStyle);
        $textrun->addText('Comprende',$fontStyle2);
        $textrun->addText('™ donde fueron archivadas, así como el apartado de la bitácora con todos los aspectos necesarios para el análisis de texto y contexto.',$fontStyle);

        $textrun = $section->addTextRun($sangria);
        $textrun->addText('Posteriormente se realizó un análisis para determinar las categorías encontradas, de acuerdo a la categorización que el Comité Académico de RELEG realizó con los resultados de la investigación nacional donde emergieron 21 categorías y las cuales se describen en el capítulo de “Resultados Generales de la Investigación” y cuya relación se nos envió con sus respectivas descripciones;  partir de ello se identificó en las  transcripciones de las entrevistas que realizamos, las frases o textos que argumentaban las informantes para darle significado de acuerdo al contexto. La plataforma ',$fontStyle);
        $textrun->addText('Comprende',$fontStyle2);
        $textrun->addText("™ permitió señalar y categorizar cada categoría emergida, cabe aclarar que el orden de estas categorías fue de acuerdo a cómo según iban emergiendo. A cada categoría, dentro de la plataforma se le iba asignando un color. Es así como cuando se iba analizando cada respuesta, si brotaba una nueva categoría que no viniera en la relación enviada por RELEG, entonces se definía y se enviaba a la coordinación general de la red con el objetivo de la autorización y que fuese integrada para los resultados a nivel nacional.  Teniendo las 5 categorías con mayor saturación para el caso de la {$data['universidad']}, se fueron presentando las categorías que definen los obstáculos hallados, cuyo análisis se detalla en el apartado de resultados de este capítulo.",$fontStyle);

        $section->addTitle("Resultados",2);
        $section->addText("En este apartado se presenta el análisis de resultados de la investigación cualitativa realizada a {$data['c_entrevistas']} estudiantes universitarias de {$data['universidad_completo']}.",$fontStyle,$sangria);

        $section->addText("Las unidades de análisis son los párrafos que conforman las respuestas a las preguntas eje de este trabajo. A partir del análisis a estas unidades surgieron los códigos en vivo que dieron origen a las categorías (Hernández Sampieri et al., 2014).",$fontStyle,$sangria);

        $section->addText("Las categorías que emergieron en esta institución de educación superior y que describen los obstáculos de las mujeres universitarias que dirigen una Mype son: {$data['str_categorias']}.",$fontStyle,$sangria);

        $section->addText("Para fines de este capítulo, se determinó analizar las 5 categorías más importantes que describen los obstáculos que presentan las mujeres universitarias de {$data['universidad']}, que dirigen o son dueñas de una micro o pequeña empresa. La importancia fue determinada a partir del orden y constancia con la que fueron emergiendo a lo largo del proceso de análisis de las entrevistas.",$fontStyle,$sangria);

        $section->addText("Las categorías y su análisis se presentan a continuación:",$fontStyle,$sangria);

        $styleCategoria = [
            'name' => 'Arial',
            'size' => '14',
            'lineHeight' => 1.5,
            'bold' => true
        ];

        $styleCodigoEnVivo = [
            'italic' => true,
            'name' => 'Arial',
            'size' => '10',
            'lineHeight' => 1,
        ];



        $section->addTitle("Discusión",2);
        $section->addText("{$data['txt_discusion']}",$fontStyle,$sangria);

        $pReferencesStyle = [
            'indentation' => [
                'left' => 720
            ],
            'alignment' => 'both'
        ];

        $section->addTitle("Referencias",2);

        $section->addText("Ahl, H. (2006). Why Research on women entrepreneurs needs new directions. entrepeneurship: Theory y practice, 30(5), 595-621",$fontStyle,$sangria);
        $section->addText("Ahl, H. J. (2002). The making of the female entrepreneur: A discourse analysis of research texts on women's entrepreneurship. Jönköping, Suecia: Parajett AB",$fontStyle,$sangria);
        $section->addText("Aldrich, H. (1989). Women on the verge of a break-through: Networking among entrepreneurs in the United States and Italy. Entrepreneurship and Regional Development, 1(4), 339-356.",$fontStyle,$sangria);
        $section->addText("Alimo-Metcalfe, B. (1995). Investigation of female and male constructs of leadership and empowerment. Women in Management Review, 10(1), 3-8.",$fontStyle,$sangria);
        $section->addText("Amorós, C. (2008). Espacio público, espacio privado y definiciones ideológicas de “lo masculino” y ' lo femenino '. Feminismo y Filosofía, 6, 2-21.",$fontStyle,$sangria);
        $section->addText("Amorós, J. E., Guerra, M., Pizarro, O., y Poblete, C. (2006). Mujeres y actividad emprendedora en Chile. Santiago de Chile, Chile: Global Entrepreneurship Monitor",$fontStyle,$sangria);
        $section->addText("Anker, R. (1997). La segregación profesional entre hombres y mujeres. Repaso de las teorías. Revista Internacional Del Trabajo , 116(3), 343-370.",$fontStyle,$sangria);
        $section->addText("Aranda, J. J., Oreza, W., Solorzano, M., y Madero, J. (2015). Criterios de conceptualización de la empresa familiar. 3c Empresa, 4(3), 185-199. http://doi.org/DOI: http://dx.doi.org/10.17993/3cemp.2015.040323.185-199",$fontStyle,$sangria);
        $section->addText("Ayman, R., y Korabik, K. (2010). Leadership: Why gender and culture matter. Psychologist, 65(3), 157-170.",$fontStyle,$sangria);
        $section->addText("Azcárate, T. (2006). Propios. Nueva sociedad, 135, 78-91.",$fontStyle,$sangria);
        $section->addText("Barbieri, M. T. De. (2007). Los ámbitos de acción de las mujeres. Revista mexicana de sociología, 53(1), 203-224.",$fontStyle,$sangria);
        $section->addText("Baum, J. (2004). The Relationship of entrepreneurial traits, skill and motivation to subsequent venture growth. Journal of Apllied Psychology, 89(4).",$fontStyle,$sangria);
        $section->addText("Baum, J., Locke, E., y Smith, K. (2001). A multidimensional model of venture growth. Academy of management review, 44(2), 292-303.",$fontStyle,$sangria);
        $section->addText("Berg, N. . (1997). Gender, place and entrepreneurship. Entrepreneurship and regional development, 9(3).",$fontStyle,$sangria);
        $section->addText("Bermúdez-Carrillo, L. (2014). Características de las pymes de Guanacaste. Revista de las sedes regionales, XV, 1-17.",$fontStyle,$sangria);
        $section->addText("Bonder, G. (2003). Construyendo el protagonismo de las mujeres en la sociedad del conocimiento : Estrategias educativas y de formación de redes (mujer, ciencia y tecnología en América). Bilbao, España: UNESCO.",$fontStyle,$sangria);
        $section->addText("Booth, S., Darke, J., y Yeandle, S. (1998). La vida de las mujeres en las ciudades. La ciudad, un espacio para el cambio. Madrid, España: Narcea.",$fontStyle,$sangria);
        $section->addText("Brush, C. G., Carter, N., Gatewood, E., Greene, P., y Hart, M. (2004). Clearing the hurdles: Women building high-growth businesses. Upper Saddle River, EEUU: Pretince Hall.",$fontStyle,$sangria);
        $section->addText("Carter, N., y Allen, K. (1997). Size determinants of women-owned business: choice or barriers to resources? Entrepreneurship and regional development, 9, 211-222.",$fontStyle,$sangria);
        $section->addText("Cheung, F., y Halpern, D. (2010). Women at the top. Powerful leaders define success as work + family in a culture of gender. American psychologist, 65(3), 182-193.",$fontStyle,$sangria);
        $section->addText("Citro, S. (2009). Cuerpos significantes: travesías de una etnografía dialéctica. Reseñas, 17(1), 208-210.",$fontStyle,$sangria);
        $section->addText("Cornet, A., y Constatinidis, C. (2004). Entreprendre au féminin: Une réalité multiple et des attentes différenciées. Revue Francaise de Gestion, 30(1), 191-205.",$fontStyle,$sangria);
        $section->addText("Delic, S. (2006). Income determinants and factors affecting the choice of self-employed canadians to invest in RRSPS and health-related benefits: an empirical analysis and policy reflection. University of Canada",$fontStyle,$sangria);
        $section->addText("Delmar, F., y Shane, S. (2003). Does planning facilitate product development in new ventures? Strategic Management Journal, 24(12), 1165-1185.",$fontStyle,$sangria);
        $section->addText("Eaglye, A. (2005). Achieving relational authenticity in leadership: Does gender matter? The Leadership Quarterly, 16, 459-474.",$fontStyle,$sangria);
        $section->addText("Encuesta Nacional de Ocupación y Empleo (28 de agosto de 2023). Encuesta Nacional de Ocupación y Empleo (ENOE), población de 15 años y más de edad. INEGI.",$fontStyle,$sangria);
        $section->addText("Escapa, R., y Martínez, L. (2010). Estrategias de liderazgo para mujeres directivas (Departamen). Barcelona, España: Departament de Treball.",$fontStyle,$sangria);
        $section->addText("Espinar, E., y Ríos, J. (2002). Producción del espacio y desigualdades de género. Alicante, España: Espagrafic",$fontStyle,$sangria);
        $section->addText("Fagenson, E., y Marcus, E. (1991). Perceptions of sex-role stereotypic characteristics of entrepreneurs: women's evaluations. Entrepeneurship: Theory y Practice, Summer, 33-47.",$fontStyle,$sangria);
        $section->addText("Fernández, J. (1998). Género y sociedad. Madrid, España: Pirámide.",$fontStyle,$sangria);
        $section->addText("Flores, C. (2002). Potencial social de las mujeres microempresarias. Cuadernos de Trabajo Social, 15, 83-92.",$fontStyle,$sangria);
        $section->addText("Forbes (27 de junio de 2023). Mujeres encabezan 1.6 millones de mipymes en México; lanzan plan para que exporten. FORBES. https://www.forbes.com.mx/mujeres-encabezan-1-6-millones-de-mipymes-en-mexico-lanzan-plan-para-que-exporten/",$fontStyle,$sangria);
        $section->addText("Frutos, L., y Titos, S. (2011). Formación y trabajo autónomo desde la perspectiva de género. X Jornadas de la Asociación de la Economía de la Educación (pp. 309-320). Servicio de Publicaciones.",$fontStyle,$sangria);
        $section->addText("Gamber, W. (1998). A gendered enterprise: Placing nineteenth-century businesswomen in history. Business Hisotry Review, 72(2), 188-218.",$fontStyle,$sangria);
        $section->addText("García, B., Blanco, M., y Pacheco, E. (1998). Género y trabajo extradoméstico.",$fontStyle,$sangria);
        $section->addText("Gascón, M. I. (2012). Las Mujeres entre la intimidad doméstica y espacio público : libros de cuentas femeninos y ordenanzas municipales. Revista de Historia Moderna, 30, 283-300.",$fontStyle,$sangria);
        $section->addText("Grant, J. (1989). “Women as managers: What can they offer to organizations.” Organizational Dynamics, 56-63.",$fontStyle,$sangria);
        $section->addText("Guerrero, L., Gómez, E., y Armenteros, M. del C. (2014). Mujeres emprendedoras: Similitudes y diferencias entre las ciudades de torreón y saltillo, coahuila. Revista Internacional Administracion y Finanzas, 7(5), 77-91.",$fontStyle,$sangria);
        $section->addText("Harmon, S. (1997). Do gender differences necessitate separate career development theories and measures? Journal of Career Assessment, 5(4), 463-470.",$fontStyle,$sangria);
        $section->addText("Heras, I., Encinas, L., y Ochoa, I. (2006). Participación de la mujer en el ejercicio del poder y la toma de decisiones dentro de los actuales escenarios laborales. Vértice Universitario, 31, 1-9.",$fontStyle,$sangria);
        $section->addText("Hisrich, R., y Brush, C. G. (1986). The woman entrepreneur: Starting, financing and managing a successful new business. Lexington: Lexington Books.",$fontStyle,$sangria);
        $section->addText("Instituto Nacional de Estadística y Geografía (2022). Estadística a propósito del días Internacional de la Mujer (8 de marzo). https://www.inegi.org.mx/contenidos/saladeprensa/aproposito/2022/EAP_Mujer22.pdf",$fontStyle,$sangria);
        $section->addText("Instituto Nacional de Estadística y Geografía (2023). Matrícula escolar por entidad federativa según nivel educativo, ciclos escolares seleccionados de 2000/2001 a 2022/2023. INEGI.",$fontStyle,$sangria);
        $section->addText("Langowitz, N., y Minniti, M. (2007). The entrepreneurial propensity of women. Theory and Practice, 31(3), 341-364.",$fontStyle,$sangria);
        $section->addText("Lee, F. C., Newton, K., Sharma, B., Gadenne, D., Stevenson, L., Amboise, G. D., Pleitner, H. J. (2001). Innovation of SMEs in the knowledge-based economy quality management strategies and performance : An empirical investigation sources in location decisions problems, motivations. Journal of Small Business y Entrepreneurship, 15(4).",$fontStyle,$sangria);
        $section->addText("Lamas, M. (1995). La perspectiva de género. Revista de educación y cultura de La Sección 47 Del SNTE, (8), 14-20.",$fontStyle,$sangria);
        $section->addText("Mavin, S. (2001). Women's career in theory and practice: Time for change? Women in Management Review, 16(4), 183-192.",$fontStyle,$sangria);
        $section->addText("Medrano, M. C. (2012). Cazando a la cazadora : Cuestiones sobre la posición de la mujer toba en los ámbitos políticos y públicos, domésticos y privados. Bulletin de I'Institu Francais d' Etudes Andines, 41(1), 123-146.",$fontStyle,$sangria);
        $section->addText("Murillo, S. (1997). El mito de la vida privada: De la entrega al tiempo propio. Madrid, España: Siglo XXI de España Editores.",$fontStyle,$sangria);
        $section->addText("Ochman, M. (2006). En busca de una nueva sociedad. Los aportes de la teoría feminista a la reformulación del mundo moderno. Desafíos, (15), 371-387.",$fontStyle,$sangria);
        $section->addText("Organización Internacional del Trabajo. (2014). La mujer en la gestión empresarial.",$fontStyle,$sangria);
        $section->addText("Posada, R., Aguilar, O., y Peña, N. (2015). Análisis Sistémico de la micro y pequeña empresa. Ciudad de México: Pearson.",$fontStyle,$sangria);
        $section->addText("Powell, G., y Butterfield, D. (1994). Investigating the “glass ceiling” phenomenon: An empirical study of actual promotions to top management. Academy of Management Journal, 37, 68-86.",$fontStyle,$sangria);
        $section->addText("Riger, S. (2002). Debates epistemológicos. Voces del feminismo. American Psychologist, 47.",$fontStyle,$sangria);
        $section->addText("Rigg, C., y Sparrow, J. (1994). Gender, diversity and working styles. Women in Management Review, 18(3), 9-16.",$fontStyle,$sangria);
        $section->addText("Rosa, P., y Hamilton, D. (1994). The Impact of Gender on Small Business Management: Preliminary Findings of a British Study. Internacional Small Business Journal, 12, 25-32.",$fontStyle,$sangria);
        $section->addText("Robles, L. (2009). Balance y perspectivas del campo mexicano : In P. Sesia y V.",$fontStyle,$sangria);
        $section->addText("Shane, S. (2003). A general theory of enttrepreneurship- The Individual oportunity nexus. New York, Nueva York, EE.UU.: Edward Elgar Editores.",$fontStyle,$sangria);
        $section->addText("Shane, S., y Venkataraman, S. (2000). The promise of entrepreneurship as a field of research. Academy of Management Review, 25, 217-226.",$fontStyle,$sangria);
        $section->addText("Shelton, L. M. (2006). Female entrepreneurs, work-family conflict, and venture performance: New insights into the work-family interface. Journal of Small Business y Entrepreneurship, 44(2).",$fontStyle,$sangria);
        $section->addText("Suárez, M. (2008). Barreras en el desarrollo profesional femenino. Reop, 19(1), 61-72.",$fontStyle,$sangria);
        $section->addText("Swanson, J., y Tokan, D. (1991). A college students perceptions of barriers to career development. Journal of Vocational Behavior, 38, 92-106.",$fontStyle,$sangria);
        $section->addText("Taylor, S., y Bodgan, R. (1996). Introducción a los métodos cualitativos de investigación. Barcelona, España:Paidós Educador.",$fontStyle,$sangria);
        $section->addText("Varela, H. (2012). Iguales , pero no tanto. El acceso limitado de las mujeres a la esfera pública en México. CONfines de Relaciones Internacionales Y Ciencia Política, VIII, 39-67.",$fontStyle,$sangria);
        $section->addText("Vázquez, V., Cárcamo, N., y Martínez, N. (2012). Entre el cargo, la maternidad y la doble jornada. Presidentas municipales de Oaxaca. Perfiles Latinoamericanos, (39), 31-57.",$fontStyle,$sangria);
        $section->addText("Vega, A. (2004). La decisión de voto de las amas de casa mexicanas y las noticias electorales. Universidad Autónoma de Barcelona.",$fontStyle,$sangria);
        $section->addText("Vega, A. (2007). Por la visibilidad de las amas de casa: Rompiendo la invisibilidad del trabajo doméstico. Política y Cultura, (28), 173-193.",$fontStyle,$sangria);
        $section->addText("Vega, A. (2014). Igualdad de género, poder y comunicación: Las mujeres en la propiedad, dirección y puestos de toma de decisión. La Ventana, 40, 186-213.",$fontStyle,$sangria);
        $section->addText("Verheul, I., Van Stel, A., y Thurik, R. (2006). Explaining female and male entrepreneurship at the country level.",$fontStyle,$sangria);
        $section->addText("Watson, J. (2002). Comparing the performance of male and female-controlled businesses: Re- lating outputs to inputs. Entrepeneurship: Theory y Practice, Primavera, 91-100",$fontStyle,$sangria);
        $section->addText("Welsh, D., y Dragusin, M. (2006). Women-entrepreneurs: A dynamic force of small business sector. Amfiteatru Economic, 20, 60-68.",$fontStyle,$sangria);
        $section->addText("Wiklund, J., Davidsson, P., and Delmar, F. (2003). What Do They Think and Feel about Growth? An Expectancy-Value Approach to Small Business Managers Attitudes Toward Growth1. Entrepreneurship theory and practice, 27(3), 247-270.",$fontStyle,$sangria);
        $section->addText("Zabludovsky, G. (1998). Las mujeres empresarias en México (1st ed.). Ciudad de México: Universidad Nacional Autónoma de México.",$fontStyle,$sangria);











        // Agregar contenido HTML al documento
        //$html = str_replace('\n', '', $_POST['mensaje']);

        //\PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $filePath = ROOTPATH . 'public/docx/investigaciones/Releg/2022/digital/' . $claveCuerpo . '.docx';

        if(file_exists($filePath)){
            unlink($filePath);
        }
        $objWriter->save($filePath);

        echo $claveCuerpo . '.docx';
    }
    #===========================DESCARGA_RELEG=====================


    #====================CATEGORIAS DIGITALES =========================

    public function categoriasDigitales()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];
        $grupos = $this->AdminModel->getAll('grupos_categorias', $condiciones);

        $data['grupos'] = $grupos;

        return view('admin/headers/index')
            . view('admin/categorias/digitales/lista', $data)
            . view('admin/footers/index');
    }

    public function getListadoCategoriasDigitales()
    {

        $valor_buscado = $this->request->getGet('search')['value']; #INPUT DE BUSCAR

        $table_map = ['id', 'nombre', 'descripcion', 'activo', 'grupo'];

        $sql_count = "SELECT count(id) as total FROM categorias_digital";
        $sql_data = "SELECT * FROM categorias_digital";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($table_map as $key => $val) {
                if ($table_map[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $table_map[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        #hacemos los cambios

        foreach ($array as $key => $d) {

            $condiciones = ['id' => $d['grupo']];

            $infoGrupo = $this->AdminModel->getAllOneRow('grupos_categorias', $condiciones);

            $grupo = empty($infoGrupo) ? '' : $infoGrupo['nombre'];

            $array[$key] = [
                'id' => $d['id'],
                'descripcion' => $d['descripcion'],
                'claveCuerpo' => $d['claveCuerpo'],
                'nombre' => $d['nombre'],
                'codigo_en_vivo' => $d['codigo_en_vivo'],
                'activo' => $d['activo'],
                'grupo' => $grupo
            ];
        }

        #Lo convertimos de nuevo a objeto
        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function actualizarGrupoLista()
    {
        $data = ['grupo' => $_POST['grupo']];
        $condiciones = ['id' => $_POST['id']];

        if (!$this->AdminModel->generalUpdate('categorias_digital', $data, $condiciones)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al asignar la dimensión a la categoría.';
            echo $mensaje;
            exit;
        }

        $return = [
            'title' => 'Éxito',
            'text' => 'Dimensión asignado correctamente'
        ];

        echo json_encode($return);
        exit;
    }

    public function diagramaGrupos()
    {
        $condiciones = [];
        $grupos = $this->AdminModel->getAll('grupos_categorias', $condiciones);

        if (empty($grupos)) {
            http_response_code(600);
            $mensaje = 'No hay grupos para realizar el diagrama.';
            echo $mensaje;
            exit;
        }

        $diagrama = [];

        foreach ($grupos as $key => $g) {
            $condiciones = ['grupo' => $g['id']];
            $codigos = $this->AdminModel->getAll('categorias_digital', $condiciones);
            if (empty($codigos)) {
                continue;
            }

            $diagrama[$key]['nombre'] = $g['nombre'];

            foreach ($codigos as $key2 => $c) {
                $diagrama[$key]['ramas'][$key2]['nombre'] = $c['nombre'];
                $diagrama[$key]['ramas'][$key2]['descripcion'] = $c['descripcion'];
            }
        }

        echo json_encode($diagrama);
        exit;
    }

    public function agregarCategoriasDigitales()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/categorias/digitales/agregar')
            . view('admin/footers/index');
    }

    public function submitAgregarCategoriaDigital()
    {

        $data = $_POST;

        if (!$this->AdminModel->generalInsert('categorias_digital', $data)) {
            http_response_code(500);
            $mensaje = 'No se ha podido insertar el registro. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        $return = [
            'title' => 'Éxito',
            'text' => 'La categoría se ha registrado correctamente.',
        ];

        echo json_encode($return);
        exit;
    }

    public function editarCategoriaDigital($id)
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $categoria = $this->AdminModel->getAllOneRow('categorias_digital', $condiciones);

        if (empty($categoria)) {
            http_response_code(404);
            exit;
        }

        $data['categoria'] = $categoria;

        return view('admin/headers/index')
            . view('admin/categorias/digitales/editar', $data)
            . view('admin/footers/index');
    }

    public function actualizarCategoriaDigital()
    {
        $data = $_POST;
        $condiciones = ['id' => $_POST['id']];

        unset($data['id']);

        if (!$this->AdminModel->generalUpdate('categorias_digital', $data, $condiciones)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error actualizando el registro. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        $return = [
            'title' => 'Éxito',
            'text' => 'Registro actualizado correctamente'
        ];
        echo json_encode($return);
        exit;
    }

    #====================CATEGORIAS DIGITALES =========================

    public function gruposDigital()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/categorias/digitales/dimensiones/lista')
            . view('admin/footers/index');
    }

    public function getListadoDimensiones()
    {

        $valor_buscado = $this->request->getGet('search')['value']; #INPUT DE BUSCAR

        $table_map = ['id', 'nombre', 'descripcion'];

        $sql_count = "SELECT count(id) as total FROM dimensiones";
        $sql_data = "SELECT * FROM dimensiones";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($table_map as $key => $val) {
                if ($table_map[$key] == 'id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $table_map[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        #hacemos los cambios

        foreach ($array as $key => $d) {

            $condiciones = ['id_dimension' => $d['id']];
            $escalas = $this->AdminModel->getAll('escalas', $condiciones);

            $array[$key] = [
                'id' => $d['id'],
                'descripcion' => $d['descripcion'],
                'nombre' => $d['nombre'],
                'escalas' => $escalas,
            ];
        }

        #Lo convertimos de nuevo a objeto
        $data = json_decode(json_encode($array), FALSE);

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data
        ];

        echo json_encode($json_data);
    }

    public function agregarGrupoDigital()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/categorias/digitales/dimensiones/agregar')
            . view('admin/footers/index');
    }

    public function submitGrupoDigital()
    {

        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion']
        ];

        if (!$this->AdminModel->generalInsert('dimensiones', $data)) {
            http_response_code(500);
            $mensaje = 'No se ha podido insertar el registro. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        if (!empty($_POST['escalas'])) {
            #VAMOS A AGREGAR LAS ESCALAS A LA BD

            $condiciones = $data;
            $info_dimension = $this->AdminModel->getAllOneRow('dimensiones', $condiciones);

            foreach ($_POST['escalas'] as $e) {
                $dataEscalas[] = [
                    'nombre' => $e,
                    'id_dimension' => $info_dimension['id']
                ];
            }

            if (!$this->AdminModel->generalInsertBatch('escalas', $dataEscalas)) {
                http_response_code(500);
                $mensaje = 'Ha ocurrido un error al insertar las escalas. Contacte a sistemas.';
                echo $mensaje;
                exit;
            }
        }

        $return = [
            'title' => 'Éxito',
            'text' => 'La dimensión y escalas (si aplica) se ha registrado correctamente.',
        ];

        echo json_encode($return);
        exit;
    }

    public function editarGrupo($id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $grupo = $this->AdminModel->getAllOneRow('dimensiones', $condiciones);

        if (empty($grupo)) {
            http_response_code(404);
            exit;
        }

        #VERIFICAMOS SI TIENE ESCALAS

        $condiciones = ['id_dimension' => $grupo['id']];
        $escalas = $this->AdminModel->getAll('escalas', $condiciones);

        $data = [
            'grupo' => $grupo,
            'escalas' => $escalas
        ];

        return view('admin/headers/index')
            . view('admin/categorias/digitales/dimensiones/editar', $data)
            . view('admin/footers/index');
    }

    public function actualizarGrupo()
    {
        $data = [
            'nombre' => $_POST['nombre'],
            'descripcion' => $_POST['descripcion']
        ];
        $condiciones = ['id' => $_POST['id']];

        unset($data['id']);

        if (!$this->AdminModel->generalUpdate('dimensiones', $data, $condiciones)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error actualizando el registro. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        if (!empty($_POST['escalas'])) {
            #eliminamos todas las escalas y las insertamos de nuevo

            $condiciones = ['id_dimension' => $_POST['id']];

            if (!$this->AdminModel->generalDelete('escalas', $condiciones)) {
                http_response_code(501);
                $mensaje = 'Ha ocurrido un error actualizando las escalas. Contacte a sistemas.';
                echo $mensaje;
                exit;
            }

            foreach ($_POST['escalas'] as $e) {
                $dataEscalas[] = [
                    'nombre' => $e,
                    'id_dimension' => $_POST['id']
                ];
            }

            if (!$this->AdminModel->generalInsertBatch('escalas', $dataEscalas)) {
                http_response_code(500);
                $mensaje = 'Ha ocurrido un error al insertar las escalas. Contacte a sistemas.';
                echo $mensaje;
                exit;
            }
        }

        $return = [
            'title' => 'Éxito',
            'text' => 'Registro actualizado correctamente'
        ];
        echo json_encode($return);
        exit;
    }

    public function eliminarDimension()
    {

        #buscamos los id en la tabla del listado de categorias

        $condiciones = ['grupo' => $_POST['id']];

        $listado = $this->AdminModel->getAll('categorias', $condiciones);

        if (!empty($listado)) {
            foreach ($listado as $l) {
                $condiciones = ['id' => $l['id']];
                $data = ['grupo' => ''];

                if (!$this->AdminModel->generalUpdate('categorias', $data, $condiciones)) {
                    http_response_code(501);
                    $mensaje = 'Ha ocurrido un error al actualizar los datos en las categorias del libro digital.';
                    echo $mensaje;
                    exit;
                }
            }
        }

        $condiciones = ['id' => $_POST['id']];

        if (!$this->AdminModel->generalDelete('dimensiones', $condiciones)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al tratar de eliminar el grupo. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        $return = [
            'title' => 'Éxito',
            'text' => 'Registro eliminado correctamente'
        ];
        echo json_encode($return);
        exit;
    }

    public function insertConstanciasAsistencia()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $nombres = [
            'Nuria Beatriz Peña Ahumada',
            'Oscar Cuauhtemoc Aguilar Rascón',
            'Paula Berenice Mejía Ávila',
            'Hugo Armando Arias Pérez',
            'Sergio Armando Gómez Moreno',
            'Areceli Fuentes Matrínez',
            'Nadia Velázquez Moreno',
            'Victoria Velázquez Moreno',
            'Sylvia Verónica  Chávez Valladares',
            'Julio Alberto Lerma Pineda',
            'Julián Alejandro Ramos Paz',
            'Mario Alberto Doria Sanchez',
            'Alma Jaqueline Garcia Silvestre',
            'María Guadalupe Cortez Moreno',
            'Lucero Noguez Correa',
            'Carla Itzel Huertas Raymundo',
            'Jared Alexander Trujillo Ortiz',
            'Diego Salinas Vazquez',
            'Alexia Carolina Chavero Pizano',
            'Andrea Yunuen Anguiano Zuñiga',
            'Angela Morales Sánchez',
            'Galilea Ruiz Lopez',
            'Oliver Rodrigo Eslava Ramirez',
            'Ana Karina Noyola Loredo',
            'Hector Ivan Favela Dominguez',
            'Belen España Naranjo',
        ];


        foreach ($nombres as $n) {
            $data = [
                'nombre' => $n,
                'usuario' => 'No aplica',
                'tipo_constancia' => 'Asistencia',
                'redCueAca' => 'REDESLA',
                'red' => 'Releg',
                'anio' => 2023,
                'porcentaje' => 100,
                'fecha_registro' => date("Y-m-d H:i:s")
            ];

            $inserted_id = $this->AdminModel->generalInsertLastId($data, 'constancia_Releg');

            $condiciones = [
                'id' => $inserted_id
            ];

            $dataUpdate = [
                'folio' => $inserted_id,
                'folio_completo' => $inserted_id . 'PA-Releg-2023'
            ];

            $this->AdminModel->generalUpdate('constancia_Releg', $dataUpdate, $condiciones);
        }
    }
}
