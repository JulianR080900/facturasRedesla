<?php

/* 
Notas

submission_id es el id publico de iquatro
publication_id es el id privado de iquatro

*/

namespace App\Controllers;


require_once 'vendor/autoload.php';

use App\Models\AdminModel;
use App\Models\IquatroModel;
use CodeIgniter\Exceptions\PageNotFoundException;

use CodeIgniter\HTTP\Response;
use PhpParser\Node\Stmt\Else_;

use App\Models\CuestionariosModel;

use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS\Root;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpWord\PhpWord;

use CodeIgniter\Files\File;
use CodeIgniter\HTTP\DownloadResponse;


use TCPDF;

use function PHPSTORM_META\map;
use function PHPUnit\Framework\isNull;

class CartasAceptacion extends TCPDF
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
        $img_file = base_url('resources/img/congresos/' . date('Y') . '/' . $_SESSION['red'] . '.jpg');

        if ($this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0) === false) {
            $mensaje = "No se ha encontrado la imagen de la menbretada. Ninguna accion realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        $this->SetMargins(10, 40, 10);
    }
}

class CustomTCPDF extends TCPDF {
    public function Footer() {
        // Obtener el número de página actual y el número total de páginas
        $currentPage = $this->getAliasNumPage();
        $totalPages = $this->getAliasNbPages();

        // Definir tu contenido personalizado para el pie de página
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 6);
        $html = 'Acceda a las instalaciones de nuestro espacio <b>Vive RedesLA</b> en: <a href="https://vive.redesla.la/">https://vive.redesla.la/</a> - Las ponencias grabadas serán transmitidas en los salones presenciales.';
        $this->writeHTML($html, true, false, true, false, 'R');
        //$this->Cell(0, 10, 'Acceda a las instalaciones de nuestro espacio Vive RedesLA en: https://vive.redesla.la/ - Las ponencias grabadas serán transmitidas en los salones presenciales.', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}


class ConstanciasAsistencia extends TCPDF{
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
        $img_file = base_url('resources/img/constancias/'.$_SESSION['nombre_constancia']);
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

class CongresosController extends BaseController
{

    public $db_serv;
    public $db_serv_cuest;
    public $db_serv_iquatro;
    public $CuestionariosModel;
    public $AdminModel;
    public $IquatroModel;
    public $db_cursos;

    public function __construct()
    {
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $db = db_connect('iquatro');
        $this->AdminModel = new AdminModel();
        $this->IquatroModel = new IquatroModel($db);
        $this->CuestionariosModel = new CuestionariosModel();
        $this->db_serv_cuest = \Config\Database::connect('cuestionarios');
        $this->db_serv_iquatro = \Config\Database::connect('iquatro');
        $this->db_cursos = \Config\Database::connect('cursos');
        $this->db_serv = \Config\Database::connect();
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

        // Establecer los encabezados HTTP
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename=' . $nombreArchivo);
        header('Content-Length: ' . $filesize);

        // Descargar el archivo
        readfile($ruta_completo);
    }

    #===========================CONGRESOS_INFO=====================

    public function congresos_info()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
            . view('admin/congresos_info/lista')
            . view('admin/footers/index');
    }

    public function getlistacongresosinfo()
    {
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = ['id', 'nombre', 'red', 'sede', 'fechas', 'anio', 'activo'];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM congresos_info";
        $sql_data = "SELECT * FROM congresos_info";

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

            $array[$key] = [
                'id' => $a['id'],
                'nombre' => $a['nombre'],
                'red' => $a['red'],
                'sede' => $a['sede'],
                'fechas' => $a['fechas'],
                'anio' => $a['anio'],
                'activo' => $a['activo'],
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

    public function activo($activo, $id)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #VAMOS A CAMBIAR EL STATUS DEL CONGRESO, ESTO SIGINFICA
        #TOMAREMOS SU ESTADO Y LO INVERTIREMOS

        if ($activo == 0) {
            #ACTUALIZAMOS EL ACTIVO EN LA BD Y MANDAMOS PARA ATRAS
            $activo = 1;
            $data = ['activo' => $activo];
            $condiciones = ['id' => $id];
            if ($this->AdminModel->generalUpdate('congresos_info', $data, $condiciones)) {
                #SE ACTUALIZO, MANDAMOS PARA ATRAS
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Listo')
                    ->with('text', 'Estado actualizado correctamente');
            }
        } else {
            $activo = 0;
            $data = ['activo' => $activo];
            $condiciones = ['id' => $id];
            if ($this->AdminModel->generalUpdate('congresos_info', $data, $condiciones)) {
                #SE ACTUALIZO, MANDAMOS PARA ATRAS
                return redirect()->back()
                    ->with('icon', 'success')
                    ->with('title', 'Listo')
                    ->with('text', 'Estado actualizado correctamente');
            }
        }
    }

    public function editarCongreso($id)
    {

        $condiciones = ['id' => $id];
        $congreso_info = $this->AdminModel->getAllOneRow('congresos_info', $condiciones);

        if (empty($congreso_info)) {
            return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', '>El congreso al que quiere acceder no existe, informe a soporte tecnico');
        }
        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);
        $data = [
            'redes' => $redes
        ];

        $data['congreso_info'] = $congreso_info;
        $data['redes'] = $redes;

        return view('admin/headers/index')
            . view('admin/congresos_info/editar', $data)
            . view('admin/footers/index');
    }

    public function agregarcongreso()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);
        $data = [
            'redes' => $redes
        ];

        return view('admin/headers/index')
            . view('admin/congresos_info/agregar', $data)
            . view('admin/footers/index');
    }

    public function insertCongreso()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $data = $_POST;
        $data['updated_by'] = session('nombre');

        if ($this->AdminModel->generalInsert('congresos_info', $data)) {
            return redirect()->to(base_url('/admin/congresos_info/lista'))
                ->with('icon', 'success')
                ->with('title', 'Exito')
                ->with('text', 'El evento se agrego correctamente');
        } else {
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error. Contacte a sistemas');
        }
    }

    public function verDesgloseCongreso($id){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $columnas = ['red', 'anio','nombre','id'];
        $congreso = $this->AdminModel->getColumnsOneRow($columnas,'congresos_info',$condiciones);

        if(empty($congreso)){
            http_response_code(500);
            exit;
        }

        $condiciones = [
            'red' => $congreso['red'],
            'anio' => $congreso['anio']
        ];

        $columnas = [
            'id',
            'claveCuerpo',
            'nombre',
            'ponente',
            'submission_id',
            'tipo_registro',
            'clave_ponencia'
        ];

        $ponencias = $this->AdminModel->getAllColums($columnas,'ponencias',$condiciones);

        $condiciones = [
            'red' => $congreso['red'],
            'anio' => $congreso['anio'],
            'tipo_registro' => 'virtual'
        ];

        $c_ponencias_virtual = $this->AdminModel->count('ponencias',$condiciones);

        $condiciones = [
            'red' => $congreso['red'],
            'anio' => $congreso['anio'],
            'tipo_registro' => 'presencial'
        ];

        $c_ponencias_presencial = $this->AdminModel->count('ponencias',$condiciones);


        #VAMOS A VER CUANTAS PONENCIAS HAN SIDO CALIFICADAS

        $c_ponencias_calificadas = 0;

        foreach($ponencias as $key=>$p){
            $condiciones = ['ponencia' => $p['clave_ponencia']];

            if($this->AdminModel->exist('calificaciones',$condiciones)){
                $c_ponencias_calificadas++;
            }
        }

        $c_ponencias_sin_calificar = count($ponencias) - $c_ponencias_calificadas;

        $condiciones = [
            'red' => $congreso['red'],
            'anio' => $congreso['anio'],
            'tipo_asistencia' => 'virtual'
        ];

        $c_virtual = $this->AdminModel->count('participantes_congresos',$condiciones);

        $condiciones = [
            'red' => $congreso['red'],
            'anio' => $congreso['anio'],
            'tipo_asistencia' => 'presencial'
        ];

        $c_presencial = $this->AdminModel->count('participantes_congresos',$condiciones);

        $condiciones = [
            'red' => $congreso['red'],
            'anio' => $congreso['anio'],
            'asistencia_presencial' => 1
        ];
        
        $presenciales_reales = $this->AdminModel->count('participantes_congresos',$condiciones);

        #VIRTUALES REALES
        $condiciones = [
            'red' => $congreso['red'],
            'anio' => $congreso['anio'],
            'asistencia_virtual' => 1
        ];
        
        $virtuales_reales = $this->AdminModel->count('participantes_congresos',$condiciones);

        $condiciones = [
            'anio' => $congreso['anio'],
            'tipo_constancia' => 'Asistencia'
        ];
        
        $constancias_asistencia = $this->AdminModel->count("constancia_".ucfirst($congreso['red']),$condiciones);

        $condiciones = [
            'anio' => $congreso['anio'],
            'tipo_constancia' => 'Ponente'
            ];
        
        $constancias_ponentes = $this->AdminModel->count("constancia_".ucfirst($congreso['red']),$condiciones);

        $total_constancias = $constancias_asistencia + $constancias_ponentes;

        $data = [
            'nombre_congreso' => $congreso['nombre'],
            'ponencias_registradas' => count($ponencias),
            'c_ponencias_virtual' => $c_ponencias_virtual,
            'c_ponencias_presencial' => $c_ponencias_presencial,
            'c_presenciales_estimados' => $c_presencial,
            'c_virtuales_estimados' => $c_virtual,
            'c_presenciales_reales' => $presenciales_reales,
            'c_virtuales_reales' => $virtuales_reales,
            'c_ponencias_calificadas' => $c_ponencias_calificadas,
            'c_ponencias_sin_calificar' => $c_ponencias_sin_calificar,
            'constancias_asistencia' => $constancias_asistencia,
            'constancias_ponentes' => $constancias_ponentes,
            'total_constancias' => $total_constancias,
            'id' => $congreso['id']
        ];

        return view('admin/headers/index')
            . view('admin/congresos_info/ver', $data)
            . view('admin/footers/index');

        #ahora vamos a tomar la red y el anio
    }

    public function descargarConstanciasAdmin($tipo_constancia,$id_congreso){
        $validos = [
            'asistencia' => 'Asistencia',
            'ponente' => 'Ponente'
        ];


        if (!array_key_exists($tipo_constancia, $validos)) {
            http_response_code(500);
            exit;
        }

        $columnas = ['red','anio'];
        $condiciones = ['id' => $id_congreso];

        $congreso = $this->AdminModel->getAllOneRow('congresos_info',$condiciones);

        if(empty($congreso)){
            http_response_code(404);
            exit;
        }


        $tabla = 'constancia_'.ucfirst($congreso['red']);

        $condiciones = [
            'tipo_constancia' => $validos[$tipo_constancia],
            'anio' => $congreso['anio']
        ];

        $columnas = ['nombre','folio','folio_completo','porcentaje'];

        $constancias = $this->AdminModel->getAllColums($columnas,$tabla,$condiciones);

        if(empty($constancias)){
            http_response_code(403);
            exit;
        }

        if($validos[$tipo_constancia] == 'Asistencia'){
            $_SESSION['nombre_constancia'] = 'Asistencia_'.ucfirst($congreso['red'].'_'.$congreso['anio'].'.jpg');
            $pdf = new ConstanciasAsistencia();
        }else if($validos[$tipo_constancia] == 'Ponente'){
            $_SESSION['nombre_constancia'] = 'Ponente_'.ucfirst($congreso['red'].'_'.$congreso['anio'].'.jpg');
            $pdf = new ConstanciasPonente();
        }else{
            http_response_code(500);
            exit;
        }

        $pdf->SetPrintHeader(true);

        $pdf->SetPrintFooter(false);

        $pdf->SetAutoPageBreak(true, 35);

        $pdf->SetAuthor('REDESLA');

        $pdf->SetCreator('REDESLA');

        $pdf->SetTitle("Constancias");



        foreach($constancias as $c){
            if($congreso['red'] == 'Releg' && $congreso['anio'] == 2023){
                $h = 170;
                $w = 220;
                $pdf->AddPage('L',[$h,$w]);
            

                #================NOMBRE====================
                $x = 52;  // Posición X
                $y = 54;  // Posición Y
                $width = 115;  // Ancho del área
                $height = 12;  // Alto del área

                #AUTOSIZE FONT

                $texto = 'A: '.$c['nombre']; // Texto a mostrar

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
                $pdf->SetTextColor(255,255,255);
                $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

                #================NOMBRE====================


                #================PORCENTAJE====================

                $x = 121;  // Posición X
                $y = 94;  // Posición Y
                $width = 10;  // Ancho del área
                $height = 8;  // Alto del área

                $pdf->SetXY($x, $y);

                $texto = $c['porcentaje']; // Texto a mostrar

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
                
                $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');
                
                #================PORCENTAJE====================

                #================FOLIO====================

                $x = 169;  // Posición X
                $y = 160;  // Posición Y
                $width = 28;  // Ancho del área
                $height = 8;  // Alto del área

                $pdf->SetXY($x, $y);
                $texto = $c['folio_completo'];

                // Obtener el ancho del texto con la fuente y el tamaño actual
                $textWidth = $pdf->GetStringWidth($texto);
                $fontSize = 8;
                $fontFamily = 'century_gothic';
                
                $pdf->SetFont($fontFamily, '', $fontSize, '', false);

                // Reducir el tamaño de fuente iterativamente hasta que el texto quepa en el área
                while ($textWidth > $width) {
                    $fontSize -= 1; // Reducir el tamaño de fuente
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $textWidth = $pdf->GetStringWidth($texto);
                }

                $pdf->SetTextColor(101, 113, 124);

                $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

                #================FOLIO====================

                #================HYPERVINCULO====================

                $x = 7;  // Posición X
                $y = 160;  // Posición Y
                $width = 69;  // Ancho del área
                $height = 8;  // Alto del área

                $pdf->SetXY($x, $y);
                $texto = $c['folio_completo'];

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

            }
        }

        $this->response->setContentType('application/pdf');

        $pdf->Output("d.pdf", 'I');

        unset($_SESSION['nombre_constancia']);


    }

    #===========================CONGRESOS_INFO=====================



    public function cartas_aceptacion()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #NOS TRAEMOS LOS PUBLICATIONS ID DE IQUATRO
        $columnas = ['publication_id'];
        $publications_id = $this->IquatroModel->getColumns($columnas, 'publications', []);

        if (empty($publications_id)) {
            $data['tabla'] = 'ponencias';
            return view('error_handling/empty_query', $data);
        }

        $condiciones = ['activo' => 1];
        $congresos = $this->AdminModel->getAll('congresos_info', $condiciones);

        if (empty($congresos)) {
            $data['tabla'] = 'congresos';
            return view('error_handling/empty_query', $data);
        }

        $data = [
            'congresos' => $congresos
        ];

        $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', '0');

        return view('admin/headers/index')
            . view('admin/congresos/cartas_aceptacion/lista', $data)
            . view('admin/footers/index');

        /*
        $data = [];

        foreach($publications_id as $key=>$pub_id){
            
            
        }*/
    }

    public function getListadoCartas()
    {

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'publication_id', 'submission_id'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(publication_id) as total FROM publications";
        $sql_data = "SELECT * FROM publications";

        $condicion = "";

        if (!empty($valor_buscado)) {
            foreach ($columnas as $key => $val) {
                if ($columnas[$key] == 'publication_id') {
                    $condicion .= " WHERE " . $val . " LIKE '%" . $valor_buscado . "%'";
                } else {
                    $condicion .= " OR " . $val . " LIKE '%" . $valor_buscado . "%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv_iquatro->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $columnas[$this->request->getGet('order')[0]['column']] . " " . $this->request->getGet('order')[0]['dir'] . " LIMIT " . $this->request->getGet('start') . ", " . $this->request->getGet('length') . "";

        $data = $this->db_serv_iquatro->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach ($array as $key => $a) {
            #PREFIJO
            $columnas = ['setting_value', 'locale'];
            $condiciones = ['publication_id' => $a['publication_id'], 'setting_name' => 'prefix'];
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
            $condiciones = ['publication_id' => $a['publication_id'], 'setting_name' => 'title'];
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
            $condiciones = ['publication_id' => $a['publication_id'], 'setting_name' => 'subtitle'];
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

            $nombre_ponencia = '';

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

            if (empty($prefijo) && empty($nombre) && empty($subtitulo)) {
                $htmlPonencia = 'Inexistente';
            } else {
                $htmlPonencia = $nombre_ponencia;
            }


            //$condiciones = ["publication_id" => $a["publication_id"], 'seq' => '0.00'];
            $condiciones = ["publication_id" => $a["publication_id"]];
            $columnas = ['author_id '];

            $autor = $this->IquatroModel->getMinOneRow('seq',$columnas,"authors", $condiciones);

            $nombre_autor = '';

            if (!empty($autor)) {
                $info_autor = $this->IquatroModel->nombre_autor($autor['author_id']);
                $nombre_autor = $info_autor["nombre"] . " " . $info_autor["apellidos"];
            }

            #tomamos el estatus de la carta
            $condiciones = ['id_iquatro' => $a['submission_id']];
            $columnas = ['enviado'];
            $enviado = $this->AdminModel->getColumnsOneRow($columnas, 'password_ponencias', $condiciones);
            $enviado = $enviado['enviado'];

            $array[$key] = [
                'id' => $a['submission_id'],
                'nombre' => $htmlPonencia,
                'autor' => $nombre_autor,
                'enviado' => $enviado
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

    public function enviarCartas()
    {

        $adminModel = new AdminModel();

        $str_enviados = '';


        $submission_ids = $_POST['submission_ids'];
        #$submission_ids = [9];

        #TRAEMOS LA INFORMACION DEL CONGRESO
        $condiciones = ['id' => $_POST['congreso']];
        $info_congreso = $this->AdminModel->getAllOneRow('congresos_info', $condiciones);

        if (empty($info_congreso)) {
            $mensaje = "No se encontro información del congreso seleccionado. Ninguna acción realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

        #TRAEMOS LA INFORMACION DE LA RED
        $condiciones = ['nombre_red' => $info_congreso['red']];
        $info_red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        if (empty($info_red)) {
            $mensaje = "No se encontro información de la red. Ninguna acción realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

        #TRAEMOS LA INFO DE LA INVESTIGACION
        $valores_permitidos = ['Congreso', 'Coloquio'];
        $tipo_evento = '';
        foreach ($valores_permitidos as $valor) {
            if (strpos($info_congreso['nombre'], $valor) !== false) {
                $tipo_evento = $valor;
                break;
            }
        }

        $condiciones = ['nombre' => $tipo_evento, 'redCueCa' => $info_congreso['red'], 'anio' => $info_congreso['anio'], 'activacion_usuarios' => '1'];
        $infoProyecto = $this->AdminModel->getAllOneRow('proyectos', $condiciones);

        if (empty($infoProyecto)) {
            $mensaje = "No se encontro información del proyecto. Verifique que el proyecto este registrado y dado de alta a los usuarios. Ninguna acción realizada.";
            http_response_code(404);
            echo $mensaje;
            exit;
        }

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $limite = explode(' ', $info_congreso['fechas']);

        $mes_limite = '';
        foreach ($meses as $valor) {
            if (strpos(ucwords($info_congreso['fechas']), $valor) !== false) {
                $mes_limite = $valor;
                break;
            }
        }

        if ($limite <= 0 || empty($mes_limite)) {
            $mensaje = "Ocurrio un error al establecer la fecha límite del pago del proyecto.";
            http_response_code(501);
            echo $mensaje;
            exit;
        }

        $limite = $limite[0] - 2 . ' de ' . strtolower($mes_limite);

        switch ($tipo_evento) {
            case 'Coloquio':
                $min = 'uno';
                $max = 'dos';
                $condiciones = ['red' => $info_congreso['red'], 'anio' => $info_congreso['anio']];
                $info_congreso_coloquio = $this->AdminModel->getAllOneRow('congresos_info', $condiciones);
                if (empty($info_congreso_coloquio)) {
                    $mensaje = "No se encontro información del congreso. Ninguna acción realizada.";
                    http_response_code(404);
                    echo $mensaje;
                    exit;
                }
                $marco = $info_congreso_coloquio['nombre'];
                break;
            case 'Congreso':
                $min = 'uno';
                $max = 'cuatro';
                $marco = '';
                break;
            default:
                $mensaje = "Ocurrio un error al establecer el mínimo y máximo de autores del evento.";
                http_response_code(502);
                echo $mensaje;
                exit;
                break;
        }


        $nombre_red = $info_red['significado'] . " (" . strtoupper($info_red['nombre_red']) . ")";

        $fecha = date("d") . " de " . $meses[date('n') - 1] . " de " . date("Y");

        $comentarios = $_POST['comentarios'];

        foreach ($submission_ids as $keySubmission=>$submission_id) {

            #EL ID ES EL SUBMISSION(EL PUBLICO)HAY QUE TRAERNOS EL PUBLICATION (PRIVADO)
            $columnas = ['publication_id'];
            $condiciones = ['submission_id' => $submission_id];
            $publication_id = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);
            $publication_id = $publication_id['publication_id'];

            #PREFIJO
            $columnas = ['setting_value', 'locale'];
            $condiciones = ['publication_id' => $publication_id, 'setting_name' => 'prefix'];
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
            $condiciones = ['publication_id' => $publication_id, 'setting_name' => 'title'];
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
            $condiciones = ['publication_id' => $publication_id, 'setting_name' => 'subtitle'];
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

            #TRAEREMOS EL NOMBRE DE LOS AUTORES
            $condiciones = ["publication_id" => $publication_id];

            $autores = $this->IquatroModel->getAllOrderBy("authors", $condiciones, 'seq ASC');

            $str_autores = '';
            $emails = [];
            foreach ($autores as $key => $a) {
                array_push($emails, $a['email']);
                $info_autor = $this->IquatroModel->nombre_autor($a['author_id']);
                $nombre_autor = $info_autor["nombre"] . " " . $info_autor["apellidos"];

                if ($key === 0) {
                    #PRIMER AUTOR
                    $primer_autor = $nombre_autor;
                    $sql_0 = $a['author_id'];
                }

                if ($a == end($autores)) {
                    #Es el ultimo valor del ciclo
                    $str_autores .= count($autores) == 1 ? $nombre_autor : 'y ' . $nombre_autor;
                } else {
                    #Aun existen autores
                    $str_autores .= $nombre_autor . ', ';
                }
            }

            $condiciones = ['setting_name' => 'affiliation', 'author_id' => $sql_0];
            $info_uni = $this->IquatroModel->getAllOneRow("author_settings", $condiciones);
            if (empty($info_uni)) {

                $mensaje = "La universidad de la ponencia {$submission_id} no fue encontrada. " . empty($str_enviados) ? 'No se envio ninguna carta' : 'Las cartas enviadas son: ' . $str_enviados;
                http_response_code(404);
                echo $mensaje;
                exit;
            }

            $universidad = $info_uni['setting_value'];

            $condiciones = ["id_iquatro" => $submission_id];

            $password = $this->AdminModel->getAllOneRow("password_ponencias", $condiciones);

            $password = $password["password"];

            $url_programa = $this->getUrlPrograma($info_congreso['red']);

            $data = [
                'nombre_ponencia' => $nombre_ponencia,
                'primer_autor' => $primer_autor,
                'autores' => $str_autores,
                'universidad' => $universidad,
                'nombre_congreso' => $info_congreso['nombre'],
                'sede' => $info_congreso['sede'],
                'fechas' => $info_congreso['fechas'],
                'red' => strtoupper($info_congreso['red']),
                'anio' => $info_congreso['anio'],
                'fecha_actual' => $fecha,
                'nombre_red' => $nombre_red,
                'id' => $submission_id,
                'password' => $password,
                'facebook' => $info_red['facebook'],
                'whatsapp' => $info_red['whatsapp'],
                'color_red' => $info_red['color_primario'],
                'proyecto' => $infoProyecto,
                'fecha_limite_pago' => $limite,
                'min' => $min,
                'max' => $max,
                'tipo_evento' => $tipo_evento,
                'marco' => $marco,
                'emails' => $emails,
                'comentarios' => $comentarios,
                'pagado' => $_POST['pagado'],
                'url_programa' => $url_programa
            ];

            $_SESSION['red'] = $info_congreso['red'];

            $this->generarCarta($data, $adminModel,$keySubmission);

            unset($_SESSION['red']);

            $error = error_get_last();

            if ($error !== null) {
                // Se produjo un error
                $mensaje = "Ha ocurrido un errro al enviar la carta del ID {$submission_id} " . empty($str_enviados) ? 'No se envio ninguna carta' : 'Las cartas enviadas son: ' . $str_enviados;
                http_response_code(503);
                echo $mensaje;
                exit;
            } else {
                // No hubo errores
                $str_enviados = $submission_id . ', ';
            }
        }

        $respuesta = array(
            "title" => "Hecho",
            'mensaje' => 'Se ha enviado las cartas',
            "codigo" => 200,
        );
        $json_respuesta = json_encode($respuesta);
        echo $json_respuesta;
        exit;
    }

    private function getUrlPrograma($red){
        $url_programa = '';

        $red = strtolower($red);
        switch($red){
            case 'relayn':
                $url_programa = 'https://relayn.redesla.la/programa/';
                break;
            case 'relep':
                $url_programa = 'https://relep.redesla.la/programa/';
                break;
            case 'relen':
                $url_programa = 'https://relen.redesla.la/programa/';
                break;
            default:
                $url_programa = '';
                break;
        }
        return $url_programa;
    }

    public function generarCarta($data, $adminModel,$keySubmission)
    {
        $pdfPath = '';
        $ruta = $data['red'] . '/' . $data['anio'] . '/index';
        // Iniciar el buffer de salida
        ob_start();

        // Cargar la vista y capturar la salida en una variable
        echo view('admin/congresos/cartas_aceptacion/formato_carta', $data);

        $html_carta = ob_get_contents();

        // Limpiar el buffer de salida
        ob_end_clean();

        $pdf = new CartasAceptacion();

        $pdf->SetPrintHeader(true);
        $pdf->SetPrintFooter(false);
        $pdf->SetAutoPageBreak(true, 35);
        $pdf->SetAuthor('REDESLA');
        $pdf->SetCreator('REDESLA');
        $pdf->SetTitle("Carta de aceptacion");
        $pdf->AddPage();

        $pdf->SetFont('Times', '', 11);

        // Luego, agrega el contenido HTML
        $pdf->writeHTML($html_carta, true, false, true, false, 'J');

        if ($data['pagado'] == 0) {
            // NO PAGO AUN LA PONENCIA, ESTABLECEREMOS LA MARCA DE AGUA
            $marca_de_agua = 'Documento por pagar';
            $font_size = 60; // Tamaño de fuente de la marca de agua
            $angle = 45; // Ángulo de la marca de agua
        
            // Guarda la configuración actual
            $pdf->StartTransform();
        
            $pdf->SetAlpha(0.2); // Configura la transparencia (ajusta el valor según tu preferencia)
            $pdf->SetFont('helvetica', 'B', $font_size); // Configura la fuente y el tamaño
            $pdf->SetTextColor(128, 128, 128); // Configura el color de la marca de agua (gris claro)
            $pdf->Rotate($angle); // Rota el texto a un ángulo determinado
        
            // Agrega el texto como marca de agua en el fondo
            $pdf->Text(55, 230, $marca_de_agua);
        
            // Restaura la configuración guardada
            $pdf->StopTransform();
        }

        $pdfPath = ROOTPATH . 'public/zip/Carta_aceptacion_' . strval(time()) . '_' . $keySubmission . '.pdf';
        $pdf->Output($pdfPath, 'F');


        ob_start();

        // Cargar la vista y capturar la salida en una variable
        echo view('admin/congresos/cartas_aceptacion/formato_correo', $data);

        $html_correo = ob_get_contents();

        // Limpiar el buffer de salida
        ob_end_clean();

        $subject = "Enhorabuena, su ponencia ha sido aceptada en el {$data['nombre_congreso']} | {$data['password']}";

        #$email->setTo('jaramosp@red.redesla.la,julianalejandroramospaz@gmail.com, vickyvem@hotmail.com');


        $email = \Config\Services::email();
        $email->clear(true);
        $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
        $email->setTo($data['emails']);
        $email->setCC('pmejiaa@redesla.la');
        $email->setSubject($subject);
        $email->setMessage($html_correo);
        $email->attach($pdfPath, 'attachment');

        if (!$email->send()) {

            $strCorreos = '';
            foreach($data['emails'] as $e){
                $strCorreos .= $e.', ';
            }
            $mensaje = 'Ha ocurrido un errro al enviar el correo. Correos en cuestión: '.$strCorreos.'. '.$email->printDebugger();;
            http_response_code(600);
            echo $mensaje;
            exit;
        }

        $dataUpdate = ['enviado' => 1];
        $condiciones = ['id_iquatro' => $data['id']];
        $adminModel->generalUpdate('password_ponencias', $dataUpdate, $condiciones);
    }

    public function cancelarCarta()
    {
        $id = $_POST['id'];

        $data = ['enviado' => 0];
        $condiciones = ['id_iquatro' => $id];

        if (!$this->AdminModel->generalUpdate('password_ponencias', $data, $condiciones)) {
            $mensaje = "Ocurrio un error al actualizar el estado. Intente mas tarde";
            http_response_code(500);
            echo $mensaje;
            exit;
        }
        $respuesta = array(
            "title" => "Hecho",
            'mensaje' => 'Se ha habilitado de nuevo para enviar la carta',
            "codigo" => 200,
        );
        $json_respuesta = json_encode($respuesta);
        echo $json_respuesta;
        exit;
    }

    public function asistencia()
    {
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];
        $redes = $this->AdminModel->getAll('redes', $condiciones);

        $columnas = ['nombre', 'red', 'anio'];
        $condiciones = ['activo' => 1];
        $congresos = $this->AdminModel->getAllColums($columnas, 'congresos_info', $condiciones);

        $data = [
            'redes' => $redes,
            'congresos' => $congresos
        ];

        return view('admin/headers/index')
            . view('admin/congresos/asistencia/index', $data)
            . view('admin/footers/index');
    }

    public function getInfoGafete()
    {
        $clave_gafete = $_POST['gafete'];
        $red = $_POST['red'];
        $anio = $_POST['anio'];

        $condiciones = [
            'clave_gafete' => $clave_gafete,
            'anio' => $anio,
            'red' => $red
        ];

        if (!$this->AdminModel->exist('participantes_congresos', $condiciones)) {
            http_response_code(404);
            $mensaje = 'No se ha encontrado el gafete en el congreso seleccionado';
            echo $mensaje;
            exit;
        }

        #VAMOS A TRAERNOS LA INFORMACION
        $participante = $this->AdminModel->getAllOneRow('participantes_congresos', $condiciones);

        #EXTRAEMOS LA INFORMACION REQUERIDA PERO SOLO LOS CAMPOS NECESARIOS
        $condiciones = ['claveCuerpo' => $participante['claveCuerpo']];
        $columnas = ['nombre'];
        $universidad = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

        if (empty($universidad)) {
            $nombre_universidad = $participante['claveCuerpo'];
        }else{
            $nombre_universidad = $universidad['nombre'];
        }


        $tipo_gafete = $participante['oyente'] == 1 ? 'Oyente' : 'Ponente';

        $nombre_ponencia = 'No aplica';
        $submission_id = 'No aplica';

        if ($participante['publication_id'] != 0 && $participante['oyente'] == 0) {
            #Tiene ponencia, vamos a buscar la informacion de la ponencia
            $condiciones = ['publication_id' => $participante['publication_id']];
            $columnas = ['nombre'];
            $ponencia = $this->AdminModel->getColumnsOneRow($columnas, 'ponencias', $condiciones);

            if (empty($nombre_ponencia)) {
                http_response_code(404);
                $mensaje = 'No se ha encontrado el nombre de la ponencia, contacte a sistemas';
                echo $mensaje;
                exit;
            }

            $columnas = ['submission_id'];
            $submission = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);

            if (empty($submission)) {
                http_response_code(404);
                $mensaje = 'No se ha encontrado el id de la ponencia, contacte a sistemas';
                echo $mensaje;
                exit;
            }

            $nombre_ponencia = $ponencia['nombre'];
            $submission_id = $submission['submission_id'];
        }

        $condiciones = ['usuario' => $participante['usuario']];
        $columnas = ['profile_pic'];
        $usuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
        if (empty($usuario)) {
            http_response_code(404);
            $mensaje = 'No se ha encontrado informacion del usuario, contacte a sistemas';
            echo $mensaje;
            exit;
        }

        if($usuario['profile_pic'] === null || $usuario['profile_pic'] == '' || $usuario['profile_pic'] == 'null'){
            $profile_pic = 'avatar.png';
        }else{
            $profile_pic = $usuario['profile_pic'];
        }


        #SABER SI YA HAY UN KIT PRESENCIAL O VIRTUAL YA REGISTRADO AL EQUIPO

        $condiciones = [
            'kit' => 1,
            'claveCuerpo' => $participante['claveCuerpo']
        ];

        if($this->AdminModel->exist('participantes_congresos',$condiciones)){
            $kit_presencial = 1;
        }else{
            $kit_presencial = 0;
        }

        $condiciones = [
            'kit_virtual' => 1,
            'claveCuerpo' => $participante['claveCuerpo']
        ];

        if($this->AdminModel->exist('participantes_congresos',$condiciones)){
            $kit_virtual = 1;
        }else{
            $kit_virtual = 0;
        }



        $data = [
            'nombre' => $participante['nombre'],
            'gafete' => $clave_gafete,
            'claveCuerpo' => $participante['claveCuerpo'],
            'universidad' => $nombre_universidad,
            'id_ponencia' => $submission_id,
            'ponencia' => $nombre_ponencia,
            'tipo_registro' => $participante['tipo_asistencia'],
            'tipo_gafete' => $tipo_gafete,
            'profile_pic' => $profile_pic,
            'kit_presencial' => $kit_presencial,
            'kit_virtual' => $kit_virtual
        ];

        $dataUpdate = [
            'asistencia_presencial' => 1
        ];

        $condiciones = [
            'clave_gafete' => $clave_gafete,
            'anio' => $anio,
            'red' => $red
        ];

        if (!$this->AdminModel->generalUpdate('participantes_congresos', $dataUpdate, $condiciones)) {
            http_response_code(404);
            $mensaje = 'Ha ocurrido un error al registrar la asistencia. Contacte a sistemas';
            echo $mensaje;
            exit;
        }
        #participantes_congresos
        echo json_encode($data);
        exit;
    }

    public function updateKit()
    {
        $clave_gafete = $_POST['gafete'];
        $red = $_POST['red'];
        $anio = $_POST['anio'];
        $tipo = $_POST['tipo'];
        $val = $_POST['val'];

        $valReturn = $val == 1 ? 0 : 1;

        $data = [
            $tipo => $valReturn
        ];

        $condiciones = [
            'clave_gafete' => $clave_gafete,
            'anio' => $anio,
            'red' => $red
        ];

        if (!$this->AdminModel->generalUpdate('participantes_congresos', $data, $condiciones)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error. Contacte a sistemas';
            echo $mensaje;
            exit;
        }



        $dataReturn = [
            'valReturn' => $valReturn
        ];

        echo json_encode($dataReturn);
        exit;
    }

    #=================HORARIOS========================

    public function horarios()
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];

        $columnas = ['id', 'nombre', 'salones', 'horarios'];

        #CONTIENE LOS HORARIOS

        $congresos = $this->AdminModel->getAllColums($columnas, "congresos", $condiciones);

        $condiciones = ['activo' => 1];
        $columnas = ['id', 'nombre', 'red', 'anio'];
        $congresos_activos = $this->AdminModel->getAllColums($columnas, 'congresos_info', $condiciones);

        #vamos a obtener los proyectos
        $condiciones = [
            'activacion_usuarios' => 1
        ];
        $columnas = ['redCueCa', 'anio', 'nombre', 'id'];
        $proyectos = $this->AdminModel->getAllColums($columnas, 'proyectos', $condiciones);

        $data = [
            'congresos' => $congresos,
            'congresos_activos' => $congresos_activos,
            'proyectos' => $proyectos
        ];

        return view('admin/headers/index')
            . view('admin/congresos/horarios/lista', $data)
            . view('admin/footers/index');

        #$this->load->view("admin/congresos", $data);
    }

    public function getListadoHorarios()
    {

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = ['id', 'nombre', 'salones', 'horarios'];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM congresos";
        $sql_data = "SELECT * FROM congresos";

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
            $array[$key] = [
                'id' => $a['id'],
                'nombre' => $a['nombre'],
                'salones' => $a['salones'],
                'horarios' => $a['horarios']
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

    public function updateAspectos()
    {

        $condiciones = [
            'id' => $_POST['id']
        ];
        $data = [
            'salones' => $_POST['salones'],
            'horarios' => $_POST['horarios'],
            'nombre' => $_POST['nombre']
        ];

        if (!$this->AdminModel->generalUpdate('congresos', $data, $condiciones)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al actualizar la información. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }
        http_response_code(200);
        $respuesta = [
            'title' => 'ÉXITO',
            'mensaje' => 'Información actualizada correctamente',
        ];

        echo json_encode($respuesta);
        exit;
    }

    public function insertHorario()
    {
        $nombre = $_POST['nombre'];
        $explode_nombre = explode('~', $nombre);

        $condiciones = [
            'nombre' => $explode_nombre[0],
            'red' => $explode_nombre[1],
            'anio' => $explode_nombre[2]
        ];

        if ($this->AdminModel->exist('congresos', $condiciones)) {
            http_response_code(403);
            $mensaje = 'El congreso que quiere registrar ya existe.';
            echo $mensaje;
            exit;
        }
        $data = [
            'nombre' => $explode_nombre[0],
            'red' => $explode_nombre[1],
            'anio' => $explode_nombre[2],
            'horarios' => $_POST['horarios'],
            'salones' => $_POST['salones'],
            'id_proyecto' => $_POST['id_proyecto']
        ];

        if (!$this->AdminModel->generalInsert('congresos', $data)) {
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error al insertar el horario. Contacte a sistemas';
            echo $mensaje;
            exit;
        }

        $response = [
            'title' => 'Éxito',
            'mensaje' => 'Horario registrado correctamente'
        ];

        echo json_encode($response);
        exit;
    }

    public function verHorario($id)
    {

        $condiciones = ["id" => $id];

        $congreso = $this->AdminModel->getAllOneRow("congresos", $condiciones);

        if (empty($congreso)) {
            return redirect()->back();
        }

        $condiciones = [];

        $moderadores = $this->AdminModel->getAll("moderadores", $condiciones);

        $enlaces = $this->AdminModel->getAll("enlaces_congresos", $condiciones);

        $mesas = $this->AdminModel->getAll("mesas", $condiciones);

        $condiciones = [
            'red' => ucfirst(strtolower($congreso['red'])),
            'anio' => $congreso['anio']
        ];

        $columnas = ['publication_id', 'nombre','mesa','tipo_registro'];
        $ponencias = $this->AdminModel->getAllColums($columnas, "ponencias", $condiciones);

        foreach ($ponencias as $key => $p) {
            $columnas = ['submission_id'];
            $condiciones = ['publication_id' => $p['publication_id']];
            $submission_id = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);
            $submission_id = $submission_id['submission_id'];
            $ponencias[$key]['submission_id'] = $submission_id;
            #VERIFICAMOS SI YA FUE UTILIZADO
            $valor_buscar = $submission_id;
            $valor_donde = $congreso['ponencias'];
            if (strpos($valor_donde, $valor_buscar) != false) {
                $ponencias[$key]['is_used'] = 1;
            } else {
                $ponencias[$key]['is_used'] = 0;
            }
        }

        $html = "
        <style>
        table, th, td{
            border: 1px solid black;
        }
        thead{
            background-color: #000;
            color: #fff;
        }

        .b_1{
            background-color: lightgreen;
        }

        .b_0{
            background-color: Crimson;
        }
        </style>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Modalidad</th>
                    <th>Usado</th>
                    <th>Mesa preliminar</th>
                </tr>
            </thead>
            <tbody>";
        foreach($ponencias as $p){
            $usado = $p['is_used'] == 1 ? 'Sí' : 'No';
            $mesa = $p['mesa'] === null ? 'Sin registrar': $p['mesa'];
            $modalidad = $p['tipo_registro'] == '' ? 'No registrado en el momento.':$p['tipo_registro'];
            $html .= "
            <tr>
                <td class='b_{$p['is_used']}'>{$p['submission_id']}</td>
                <td>{$p['nombre']}</td>
                <td>{$modalidad}</td>
                <td>{$usado}</td>
                <td>{$mesa}</td>
            </tr>
            ";
        }

        $html .= "
            </tbody>
        </table>
        ";

        $data = [
            'datos_tabla' => $congreso,
            'moderadores' => $moderadores,
            'enlaces' => $enlaces,
            'mesas' => $mesas,
            'ponencias' => $ponencias,
            'tabla_ponencias' => $html
        ];

        return view('admin/headers/index')
            . view('admin/congresos/horarios/ver', $data)
            . view('admin/footers/index');
    }

    public function act_datos_congreso()
    {

        $data = $_POST;

        $condiciones = ["id" => $data["id_congreso"]];

        $datos_tabla = $this->AdminModel->getAllOneRow("congresos", $condiciones);

        #=====ENLACES=====

        $stringEnlaces = "";

        foreach ($data["enlaces"] as $e) {

            $stringEnlaces .= $e . ",";
        }

        $dataEnlace = ["enlaces" => $stringEnlaces];

        $condiciones = ["id" => $data["id_congreso"]];

        $this->AdminModel->generalUpdate("congresos", $dataEnlace, $condiciones);

        #=====MESAS=====

        $stringMesas = "";

        for ($i = 1; $i <= $datos_tabla["horarios"]; $i++) {

            for ($e = 1; $e <= $datos_tabla["salones"]; $e++) {

                $posicion = "mesas_salon_" . $e . "_horario_$i";

                $stringMesas .= $posicion . ";";

                $stringMesas .= $data[$posicion][0] . "-";
            }
        }

        $dataMesas = ["mesas" => $stringMesas];

        $condiciones = ["id" => $data["id_congreso"]];

        $this->AdminModel->generalUpdate("congresos", $dataMesas, $condiciones);



        #=====MODERADORES=====

        $stringModeradores = "";

        for ($i = 1; $i <= $datos_tabla["horarios"]; $i++) {

            for ($e = 1; $e <= $datos_tabla["salones"]; $e++) {

                $posicion = "moderadores_salon_" . $e . "_horario_$i";

                $stringModeradores .= $posicion . ";";

                $stringModeradores .= $data[$posicion][0] . "-";
            }
        }

        $dataModeradores = ["moderadores" => $stringModeradores];

        $condiciones = ["id" => $data["id_congreso"]];

        $this->AdminModel->generalUpdate("congresos", $dataModeradores, $condiciones);



        #=====HORARIOS=====

        $stringHorarios = "";

        foreach ($data["horarios"] as $e) {

            $stringHorarios .= $e . ",";
        }

        $dataHorarios = ["infoHorarios" => $stringHorarios];

        $condiciones = ["id" => $data["id_congreso"]];

        $this->AdminModel->generalUpdate("congresos", $dataHorarios, $condiciones);

        #=====TEMAS=====

        $stringTemas = "";

        foreach ($data["temas"] as $e) {

            $stringTemas .= $e . ",";
        }

        $dataTemas = ["temas" => $stringTemas];

        $condiciones = ["id" => $data["id_congreso"]];

        $this->AdminModel->generalUpdate("congresos", $dataTemas, $condiciones);

        #======ZOOM==========

        $stringZoom = "";

        foreach ($data["zoom"] as $z) {

            $stringZoom .= $z . ",";
        }

        $dataZoom = ["zoom" => $stringZoom];

        $condiciones = ["id" => $data["id_congreso"]];

        $this->AdminModel->generalUpdate("congresos", $dataZoom, $condiciones);

        #=====PONENCIAS=====

        $stringPonencias = "";

        for ($i = 1; $i <= $datos_tabla["horarios"]; $i++) {

            for ($e = 1; $e <= $datos_tabla["salones"]; $e++) {

                $posicion = "ponencias_salon_" . $e . "_horario_$i";

                $stringPonencias .= $posicion . ";";

                for ($a = 0; $a <= 5; $a++) {

                    if ($a == 5) {

                        $stringPonencias .= $data[$posicion][$a] . "-";
                    } else {

                        $stringPonencias .= $data[$posicion][$a] . ",";
                    }
                }
            }
        }

        $dataPonencia = ["ponencias" => $stringPonencias];

        $condiciones = ["id" => $data["id_congreso"]];

        $this->AdminModel->generalUpdate("congresos", $dataPonencia, $condiciones);

        $this->previsualizacionHorarioCongresoView($data["id_congreso"]);

        //return redirect()->back();
    }

    /* public function previsualizacionHorarioCongreso($id){

        $condiciones = ["id" => $id];

        $datos_tabla = $this->AdminModel->getAllOneRow("congresos", $condiciones);

        $tcpdf = new CustomTCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $tcpdf->SetPrintHeader(false);

        $tcpdf->SetPrintFooter(false);

        $tcpdf->SetCreator('REDESLA');

        $tcpdf->SetAuthor('REDESLA');

        $tcpdf->SetTitle('Horario de congreso');

        // set margins

        $tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $tcpdf->AddPage();

        #DEBE SER PNG
        if(!file_exists(ROOTPATH.'/resources/img/congresos/'.$datos_tabla['anio'].'/Tira_horarios_'.$datos_tabla['red'].'.png')){
            //la tira aun no existe
            return redirect()->back()
            ->with('icon', 'warning')
            ->with('title', 'Lo sentimos')
            ->with('text', 'La tira del horario del '.$datos_tabla['nombre'].' no se ha subido a la plataforma. Por lo que no puede visualizar el horario.');
        }

        $path = ROOTPATH.'/resources/img/congresos/'.$datos_tabla['anio'].'/Tira_horarios_'.$datos_tabla['red'].'.png';
        
        $tcpdf->Image($path, 5, 15, 200, 0);

        //$tcpdf->Image($path, 75, 0, 60, 40);

        //$tcpdf->Image($path, 150, 0, 60, 40);

        $txt = 'PROGRAMACIÓN DE PONENCIAS';

        $tcpdf->SetFont('times', '', 25);

        $tcpdf->SetFillColor(255, 255, 255);

        $tcpdf->Ln(20);

        $tcpdf->MultiCell(0, 0, $txt . "\n", 0, 'C', 1, 1, '', '', true, 0, false, true, 0); //primero es ancho, segundo es un margen hacia abajo

        $tcpdf->SetFont('times', '', 14);

        $tcpdf->MultiCell(0, 0, 'Dicho programa está sujeto a cambios SIN previo aviso, actualice al término de cada ciclo de ponencias.' . "\n", 0, 'C', 1, 1, '', '', true, 0, false, true, 0); //primero es ancho, segundo es un margen hacia abajo

        $tcpdf->SetFont('times', '', 25);

        $tcpdf->Ln(5);

        $data = [];

        $tcpdf->SetFont('times', '', 12);

        $data["datos_tabla"] = $datos_tabla;

        $explode_enlaces = explode(",", $datos_tabla["enlaces"]);

        $explode_mesas = explode(",", $datos_tabla["mesas"]);

        $explode_moderadores = explode(",", $datos_tabla["moderadores"]);

        $explode_horarios = explode(",", $datos_tabla["infoHorarios"]);

        $explode_temas = explode(",", $datos_tabla["temas"]);

        for ($i = 0; $i < (count($explode_horarios) - 1); $i++) { //HORARIOS

            $tcpdf->SetTextColor(255, 255, 255);

            switch ($datos_tabla['red']) {
                case 'Relayn':
                    $tcpdf->SetFillColor(255, 77, 0);
                    break;
                case 'Releem':
                    $tcpdf->SetFillColor(79, 48, 179);
                    break;
                case 'Relep':
                    $tcpdf->SetFillColor(54, 58, 54);
                    break;
                case 'Relen':
                    $tcpdf->SetFillColor(157, 3, 3);
                    break;
                case 'Releg':
                    $tcpdf->setFillColor(232, 84, 152);
                    break;
            }



            if (empty($explode_horarios[$i])) {

                //echo "<h1>Horario sin registrar</h1>";

                $txtHorario = 'Horario sin registrar';

                $tcpdf->MultiCell(0, 0, "Horario sin registrar" . "\n", 1, 'C', 1, 1, '', '', true, 0, false, true, 0); //primero es ancho, segundo es un margen hacia abajo

            } else {

                //echo "<h1>Horario".$explode_horarios[$i]."</h1>";

                $txtHorario = $explode_horarios[$i] . ' Hora Centro de México';

                $tcpdf->MultiCell(0, 0, ("" . $explode_horarios[$i] . ' Hora Centro de México') . "\n", 1, 'C', 1, 1, '', '', true, 0, false, true, 0); //primero es ancho, segundo es un margen hacia abajo

            }

            $tcpdf->SetFillColor(100, 255, 200);

            $tcpdf->Ln(5);

            $html = "";

            $tcpdf->SetTextColor(0, 0, 0);

            for ($e = 0; $e <= $datos_tabla["salones"] - 1; $e++) { //SALONES

                if ($e <= $datos_tabla["salones"]) {

                    $html .= '<table cellspacing="0" cellpadding="1"  border="1" style="text-align: center;">' . "\n";

                    //SIGUE SALONES Y MODERADORES

                    $html .= "<thead>\n";

                    $html .= "<tr>\n";

                    $html .= '<th colspan="2">';

                    $html .= utf8_decode($txtHorario); //Horario

                    $html .= "</th>\n";

                    $html .= "</tr>\n";

                    $html .= "<tr style='text-align: center; vertical-align: middle;  '>\n";

                    $html .= '<th colspan="2" style="text-align: center; vertical-align: middle;">';

                    $name = "ponencias_salon_" . ($e + 1) . "_horario_" . ($i + 1) . ";";

                    $nameMod  = "moderadores_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                    $html .= utf8_decode($explode_temas[$e]) . "";

                    $html .= "</th>\n";

                    $html .= "</tr>\n";

                    $html .= "<tr>\n";

                    $html .= '<th colspan="2">';

                    $name = "ponencias_salon_" . ($e + 1) . "_horario_" . ($i + 1) . ";";

                    $nameMod  = "moderadores_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                    $explodeModeradores = explode($nameMod, $datos_tabla["moderadores"]); // 0 nombre 1 valor

                    if (isset($explodeModeradores[1])) {

                        $valoresMod = explode("-", $explodeModeradores[1]); //en 0 estan los valores para ese string 

                        $valor_real_ciclo_mod = explode(";", $valoresMod[0]);

                        $valor_real_ciclo_mod = $valor_real_ciclo_mod[1];

                        if ($valor_real_ciclo_mod == "None") {

                            $valor_real_ciclo_mod  = "Sin registrar";
                        } else {

                            //SACAMOS EL VALOR EN TEXTO PLANO DE LA CLAVE

                            if($valor_real_ciclo_mod != ''){
                                $condicion = ["clave" => $valor_real_ciclo_mod];

                                $nombre_mod = $this->AdminModel->getAllOneRow("moderadores", $condicion);
    
                                $valor_real_ciclo_mod = $nombre_mod["nombre"];
                            }else{
                                $valor_real_ciclo_mod = 'Sin registrar';
                            }

                            
                        }
                    }

                    $html .= "Moderador: <i>" . utf8_decode($valor_real_ciclo_mod).'</i>'; //Tenemos que sacar el nombre del moderador mediante su clave

                    $html .= "</th>\n";

                    $html .= "</tr>\n";

                    $html .= "<tr>\n";

                    $html .= '<th colspan="2">';

                    $nameMesa  = "mesas_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                    $explodeMesas = explode($nameMesa, $datos_tabla["mesas"]); // 0 nombre 1 valor

                    if (isset($explodeMesas[1])) {

                        $valoresMod = explode("-", $explodeMesas[1]); //en 0 estan los valores para ese string 

                        $valor_real_ciclo_mod = explode(";", $valoresMod[0]);

                        $valor_real_ciclo_mod = $valor_real_ciclo_mod[1];

                        if ($valor_real_ciclo_mod == "None") {

                            $valor_real_ciclo_mod  = "Sin registrar";
                        } else {

                            //SACAMOS EL VALOR EN TEXTO PLANO DE LA CLAVE

                            if($valor_real_ciclo_mod != ''){
                                $condicion = ["clave" => $valor_real_ciclo_mod];

                                $nombre_mesa = $this->AdminModel->getAllOneRow("mesas", $condicion);
    
                                $valor_real_ciclo_mod = $nombre_mesa["nombre"];
                            }else{
                                $valor_real_ciclo_mod = 'Sin registrar';
                            }

                            
                        }
                    }

                    $html .= "Mesa: " . utf8_decode($valor_real_ciclo_mod); //Tenemos que sacar el nombre del moderador mediante su clave

                    $html .= "</th>\n";

                    $html .= "</tr>\n";

                    $html .= "</thead>\n";

                    //AHORA TOCA SACAR LAS PONENCIAS

                    $html .= "<tbody>\n";

                    if ($datos_tabla["ponencias"] != "") {

                        $posicion = explode($name, $datos_tabla["ponencias"]); //0 es vacio o en donde termina y el 1 tiene toodo lo demas del string

                        if (isset($posicion[1])) {

                            $valores = explode("-", $posicion[1]); //en 0 estan los valores para ese tring 

                            $valor_selects = explode(",", $valores[0]); //Me da valores del 0 al 4

                            if($valor_selects[0] == ''){
                                $html = "";
                                continue;
                            }

                            $q = 0;

                            foreach ($valor_selects as $v) {

                                if($v != ''){

                                $html .= "<tr>\n";

                                $html .= '<td style="border-collapse: collapse;">';

                                $html .= $v;

                                $html .= "</td>\n";

                                $html .= '<td style="border-collapse: collapse;">';

                                //$v es el submission_id, hay que tomar el publication_id

                                $columnas = ['nombre'];
                                $condiciones = ['submission_id' => $v];
                                $nombre_ponencia = $this->AdminModel->getColumnsOneRow($columnas,'ponencias',$condiciones);

                                if (!empty($nombre_ponencia)) {

                                    $html .= utf8_decode($nombre_ponencia["nombre"]);
                                } else {

                                    $html .= ""; //nombre de la ponencia

                                }

                                $html .= "</td>\n";

                                $html .= "</tr>\n";

                                $q++;
                                }
                            }

                            $q = 0;
                        }
                    }

                    $html .= "</tbody>\n";

                    $html .= "</table>\n<br><br>";

                    $html = utf8_encode($html);

                    $tbl = <<<EOD

                    {$html}
                    
                    EOD;

                    $tcpdf->writeHTML($tbl, true, false, false, false, '');

                    $html = "";
                }
            }
        }

        $ruta = getcwd() . '/resources/pdf/congresos/' . $datos_tabla['nombre'] . '.pdf';

        $this->response->setHeader('Content-Type', 'application/pdf');

        $tcpdf->Output($ruta, 'FI');
    } */

    public function previsualizacionHorarioCongresoView($id){
        $condiciones = ["id" => $id];

        $datos_tabla = $this->AdminModel->getAllOneRow("congresos", $condiciones);

        $tcpdf = new CustomTCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $tcpdf->SetPrintHeader(false);

        $tcpdf->SetPrintFooter(true);

        $tcpdf->SetCreator('REDESLA');

        $tcpdf->SetAuthor('REDESLA');

        $tcpdf->SetTitle('Horario de congreso');

        // set margins

        $tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $tcpdf->AddPage();

        #DEBE SER PNG
        if(!file_exists(ROOTPATH.'/resources/img/congresos/'.$datos_tabla['anio'].'/Tira_horarios_'.$datos_tabla['red'].'.png')){
            //la tira aun no existe
            return redirect()->back()
            ->with('icon', 'warning')
            ->with('title', 'Lo sentimos')
            ->with('text', 'La tira del horario del '.$datos_tabla['nombre'].' no se ha subido a la plataforma. Por lo que no puede visualizar el horario.');
        }

        $path = ROOTPATH.'/resources/img/congresos/'.$datos_tabla['anio'].'/Tira_horarios_'.$datos_tabla['red'].'.png';
        
        $tcpdf->Image($path, 2, 20, 150, 0,'PNG','','',false,300,'C',false,false,1);

        //$tcpdf->Image($path, 75, 0, 60, 40);

        //$tcpdf->Image($path, 150, 0, 60, 40);

        $txt = 'PROGRAMACIÓN DE PONENCIAS';

        $tcpdf->SetFont('times', '', 25);

        $tcpdf->SetFillColor(255, 255, 255);

        $tcpdf->Ln(20);

        $tcpdf->MultiCell(0, 0, $txt . "\n", 0, 'C', 1, 1, '', '', true, 0, false, true, 0); //primero es ancho, segundo es un margen hacia abajo

        $tcpdf->SetFont('times', '', 14);

        $tcpdf->MultiCell(0, 0, 'Dicho programa está sujeto a cambios SIN previo aviso, actualice al término de cada ciclo de ponencias.' . "\n", 0, 'C', 1, 1, '', '', true, 0, false, true, 0); //primero es ancho, segundo es un margen hacia abajo

        $tcpdf->SetFont('times', '', 25);

        $tcpdf->Ln(5);

        $data = [];

        $tcpdf->SetFont('times', '', 12);

        $data["datos_tabla"] = $datos_tabla;

        $explode_enlaces = explode(",", $datos_tabla["enlaces"]);

        $explode_mesas = explode(",", $datos_tabla["mesas"]);

        $explode_moderadores = explode(",", $datos_tabla["moderadores"]);

        $explode_horarios = explode(",", $datos_tabla["infoHorarios"]);

        $explode_temas = explode(",", $datos_tabla["temas"]);

        for ($i = 0; $i < (count($explode_horarios) - 1); $i++) { //HORARIOS

            $tcpdf->SetTextColor(255, 255, 255);

            switch ($datos_tabla['red']) {
                case 'Relayn':
                    $tcpdf->SetFillColor(255, 77, 0);
                    break;
                case 'Releem':
                    $tcpdf->SetFillColor(79, 48, 179);
                    break;
                case 'Relep':
                    $tcpdf->SetFillColor(54, 58, 54);
                    break;
                case 'Relen':
                    $tcpdf->SetFillColor(157, 3, 3);
                    break;
                case 'Releg':
                    $tcpdf->setFillColor(232, 84, 152);
                    break;
            }



            if (empty($explode_horarios[$i])) {

                //echo "<h1>Horario sin registrar</h1>";

                $txtHorario = 'Horario sin registrar';

                $tcpdf->MultiCell(0, 0, "Horario sin registrar" . "\n", 1, 'C', 1, 1, '', '', true, 0, false, true, 0); //primero es ancho, segundo es un margen hacia abajo

            } else {

                //echo "<h1>Horario".$explode_horarios[$i]."</h1>";

                $txtHorario = $explode_horarios[$i] . ' Hora Centro de México';

                $tcpdf->MultiCell(0, 0, ("" . $explode_horarios[$i] . ' Hora Centro de México') . "\n", 1, 'C', 1, 1, '', '', true, 0, false, true, 0); //primero es ancho, segundo es un margen hacia abajo

            }

            $tcpdf->SetFillColor(100, 255, 200);

            $tcpdf->Ln(5);

            $html = "";

            $tcpdf->SetTextColor(0, 0, 0);

            for ($e = 0; $e <= $datos_tabla["salones"] - 1; $e++) { //SALONES

                if ($e <= $datos_tabla["salones"]) {

                    $html .= '<table cellspacing="0" cellpadding="1"  border="1" style="text-align: center;">' . "\n";

                    //SIGUE SALONES Y MODERADORES

                    $html .= "<thead>\n";

                    $html .= "<tr>\n";

                    $html .= '<th colspan="2">';

                    $html .= $txtHorario; //Horario

                    $html .= "</th>\n";

                    $html .= "</tr>\n";

                    $html .= "<tr style='text-align: center; vertical-align: middle;  '>\n";

                    $html .= '<th colspan="2" style="text-align: center; vertical-align: middle;">';

                    $name = "ponencias_salon_" . ($e + 1) . "_horario_" . ($i + 1) . ";";

                    $nameMod  = "moderadores_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                    $html .= $explode_temas[$e] . "";

                    $html .= "</th>\n";

                    $html .= "</tr>\n";

                    $html .= "<tr>\n";

                    $html .= '<th colspan="2">';

                    $name = "ponencias_salon_" . ($e + 1) . "_horario_" . ($i + 1) . ";";

                    $nameMod  = "moderadores_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                    $explodeModeradores = explode($nameMod, $datos_tabla["moderadores"]); // 0 nombre 1 valor

                    if (isset($explodeModeradores[1])) {

                        $valoresMod = explode("-", $explodeModeradores[1]); //en 0 estan los valores para ese string 

                        $valor_real_ciclo_mod = explode(";", $valoresMod[0]);

                        $valor_real_ciclo_mod = $valor_real_ciclo_mod[1];

                        if ($valor_real_ciclo_mod == "None") {

                            $valor_real_ciclo_mod  = "Sin registrar";
                        } else {

                            //SACAMOS EL VALOR EN TEXTO PLANO DE LA CLAVE

                            if($valor_real_ciclo_mod != ''){
                                $condicion = ["clave" => $valor_real_ciclo_mod];

                                $nombre_mod = $this->AdminModel->getAllOneRow("moderadores", $condicion);
    
                                $valor_real_ciclo_mod = $nombre_mod["nombre"];
                            }else{
                                $valor_real_ciclo_mod = 'Sin registrar';
                            }

                            
                        }
                    }

                    $html .= "Moderador: <i>" . $valor_real_ciclo_mod.'</i>'; //Tenemos que sacar el nombre del moderador mediante su clave

                    $html .= "</th>\n";

                    $html .= "</tr>\n";

                    $html .= "<tr>\n";

                    $html .= '<th colspan="2">';

                    $nameMesa  = "mesas_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                    $explodeMesas = explode($nameMesa, $datos_tabla["mesas"]); // 0 nombre 1 valor

                    if (isset($explodeMesas[1])) {

                        $valoresMod = explode("-", $explodeMesas[1]); //en 0 estan los valores para ese string 

                        $valor_real_ciclo_mod = explode(";", $valoresMod[0]);

                        $valor_real_ciclo_mod = $valor_real_ciclo_mod[1];

                        if ($valor_real_ciclo_mod == "None") {

                            $valor_real_ciclo_mod  = "Sin registrar";
                        } else {

                            //SACAMOS EL VALOR EN TEXTO PLANO DE LA CLAVE

                            if($valor_real_ciclo_mod != ''){
                                $condicion = ["clave" => $valor_real_ciclo_mod];

                                $nombre_mesa = $this->AdminModel->getAllOneRow("mesas", $condicion);
    
                                $valor_real_ciclo_mod = $nombre_mesa["nombre"];
                            }else{
                                $valor_real_ciclo_mod = 'Sin registrar';
                            }

                            
                        }
                    }

                    $html .= "Mesa: " . $valor_real_ciclo_mod; //Tenemos que sacar el nombre del moderador mediante su clave

                    $html .= "</th>\n";

                    $html .= "</tr>\n";

                    $html .= "</thead>\n";

                    //AHORA TOCA SACAR LAS PONENCIAS

                    $html .= "<tbody>\n";

                    if ($datos_tabla["ponencias"] != "") {

                        $posicion = explode($name, $datos_tabla["ponencias"]); //0 es vacio o en donde termina y el 1 tiene toodo lo demas del string

                        if (isset($posicion[1])) {

                            $valores = explode("-", $posicion[1]); //en 0 estan los valores para ese tring 

                            $valor_selects = explode(",", $valores[0]); //Me da valores del 0 al 4

                            if($valor_selects[0] == ''){
                                #$tcpdf->writeHTML($tbl, true, false, false, false, '');
                                $html = "";
                                continue;
                            }

                            $q = 0;

                            foreach ($valor_selects as $v) {

                                if($v != ''){

                                $html .= "<tr>\n";

                                $html .= '<td style="border-collapse: collapse;">';

                                $html .= $v;

                                $html .= "</td>\n";

                                $html .= '<td style="border-collapse: collapse;">';

                                //$v es el submission_id, hay que tomar el publication_id

                                $columnas = ['nombre'];
                                $condiciones = ['submission_id' => $v];
                                $nombre_ponencia = $this->AdminModel->getColumnsOneRow($columnas,'ponencias',$condiciones);

                                if (!empty($nombre_ponencia)) {

                                    $html .= $nombre_ponencia["nombre"];
                                } else {

                                    $html .= ""; //nombre de la ponencia

                                }

                                $html .= "</td>\n";

                                $html .= "</tr>\n";

                                $q++;
                                }
                            }

                            $q = 0;
                        }
                    }

                    $html .= "</tbody>\n";

                    $html .= "</table>\n<br><br>";

                    $html = $html;

                    $tbl = <<<EOD

                    {$html}
                    
                    EOD;

                    $tcpdf->writeHTML($tbl, true, false, false, false, '');

                    $html = "";
                }
            }
        }

        $ruta = getcwd() . '/resources/pdf/congresos/' . $datos_tabla['nombre'] . '.pdf';

        $this->response->setHeader('Content-Type', 'application/pdf');

        $tcpdf->Output($ruta, 'FI');

        /* $this->response->setHeader('Content-Type', 'application/pdf');

        $tcpdf->Output('Previsualizacion.pdf', 'I'); */
    }

    #=================HORARIOS========================

    #==============PONENCIAS=====================

    public function ponencias(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];

        $mesas = $this->AdminModel->getAll('mesas',$condiciones);

        $data = [
            'mesas' => $mesas
        ];

        return view('admin/headers/index')
            . view('admin/congresos/ponencias/lista',$data)
            . view('admin/footers/index');

    }

    public function getListadoPonencias(){

        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'claveCuerpo','ponente', 'nombre','mesa','nombre_congreso','anio','submission_id','tipo_registro','clave_ponencia'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM ponencias";
        $sql_data = "SELECT * FROM ponencias";

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

            $submission = $a['submission_id'] == 0 ? '<span class="text-warning">No registrado en el momento</span>' : $a['submission_id'];

            $mesa = $a['mesa'] === null ? '<span class="text-danger">Sin registrar</span>': $a['mesa'];

            $val_mesa = $a['mesa'] === null ? '': $a['mesa'];

            $array[$key] = [
                'id' => $a['id'],
                'submissison_id' => $submission,
                'congreso' => $a['nombre_congreso'],
                'mesa' => $mesa,
                'val_mesa' => $val_mesa,
                'tipo_registro' => $a['tipo_registro'],
                'ponencia' => $a['nombre'],
                'ponente' => $a['ponente'],
                'clave_ponencia' => $a['clave_ponencia']
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

    public function updateMesa(){

        $data = ['mesa' => $_POST['mesa']];

        $condiciones = ['id' => $_POST['id']];

        if(!$this->AdminModel->generalUpdate('ponencias',$data,$condiciones)){
            http_response_code(500);
            $mensaje = 'Ha ocurrido un error. Contacte a sistemas.';
            echo $mensaje;
            exit;
        }

        $response = [
            'title' => 'Éxito',
            'mensaje' => 'Mesa preliminar actualizada correctamente'
        ];

        echo json_encode($response);
        exit;
    }

    #==============PONENCIAS=====================




    #===========================MODERADORES=====================

    public function moderador(){
        
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
        . view('admin/congresos/moderadores/lista')
        . view('admin/footers/index');

    }

    public function getlistadomoderador(){
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = ['id','clave','nombre','contacto'];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM moderadores";
        $sql_data = "SELECT * FROM moderadores";

        $condicion = "";

        if(!empty($valor_buscado)){
            foreach($columnas as $key => $val){
                if($columnas[$key] == 'id'){
                    $condicion .= " WHERE ".$val." LIKE '%".$valor_buscado."%'";
                }else{
                    $condicion .= " OR ".$val." LIKE '%".$valor_buscado."%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY ".$columnas[$this->request->getGet('order')[0]['column']]." ".$this->request->getGet('order')[0]['dir']." LIMIT ".$this->request->getGet('start').", ".$this->request->getGet('length')."";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach($array as $key=>$a){

        
            $htmlEliminar = '
            <div class="dropdown">
            <button class="btn btn-danger dropdown-toggle btn-rounded  btn-icon-text" type="button" id="dropdownMenuSizeButton' . $a['id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-alert btn-icon-prepend"></i> Eliminar </button> </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton' . $a['id'] . '" style="">
                <h6 class="dropdown-header">Seleccione una opcion</h6>
                <button class="dropdown-item eliminarmoderador" data-id="' . $a['id'] . '">Eliminar moderador</button>
            </div>
            </div>
            ';
            $htmlEditar = '<a type="button" href="editar/'.$a['id'].'" class="btn btn-warning btn-icon-text btn-rounded">
            <i class="mdi mdi-lead-pencil"></i> Editar </a>';
        
            $array[$key] = [
                'id'=>$a['id'],
                'clave' => $a['clave'],
                'nombre' => $a['nombre'],
                'contacto' => $a['contacto'],
                'editar' => $htmlEditar,
                'eliminar'=>$htmlEliminar,
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

    public function editarmoderador($id){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        

        $condiciones = ['id' => $id];
        $moderadores = $this->AdminModel->getAllOneRow('moderadores', $condiciones);
        
        if (empty($moderadores)) {
            #NO HAY REGISTROS
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'Esta intentando acceder a un registro inexistente');
        }

        $condicones_usuarios = ['correo'=> $moderadores['contacto']];
        $usuario = $this->AdminModel->getAllOneRow('usuarios', $condicones_usuarios);

        //Mostrarenos una vista para que el admin edite los datos
        $data['moderadores'] = $moderadores;
        $data['id_usuario'] = $usuario ['id'];

        return view('admin/headers/index')
            . view('admin/congresos/moderadores/editar', $data)
            . view('admin/footers/index');
    }

    public function agregarmoderador(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        
        return view('admin/headers/index')
        .view('admin/congresos/moderadores/agregar')
        .view('admin/footers/index');

    }

    public function updatemoderador(){
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $data = $_POST;
        $data['updated_by'] = session('nombre');
        $clave = $_POST["clave"];
        $nombre = $_POST["nombre"];
        $contacto = $_POST["contacto"];

        #CONDICIONES PARA EVITAR REPETIR DATOS AL MOMENTO DE EDITAR
        $condicion_contacto = array(
            "correo" => $contacto,
            'id !=' => $_POST['id_usuario']
        );

        $condicion_clave = array(
            "clave" => $clave,
            'id !=' => $_POST['id']
        );

        #HACEMOS LAS VALIDACIONES PARA EVITAR REPETIR DATOS EN LA TABLA
        if($this->AdminModel->exist('usuarios', $condicion_contacto)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'El contacto del moderador ya esta en uso. Use un contacto diferente o edite el que ya tiene');
        }
        if($this->AdminModel->exist('moderadores', $condicion_clave)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'La clave del moderador ya esta en uso. Use un contacto diferente o edite el que ya tiene');
        }

        $condiciones = ['id' => $_POST['id']];
        $info_moderador = $this->AdminModel->getAllOneRow('moderadores',$condiciones);
        $valor_actual = $info_moderador['clave'];

        $condiciones = [];
        $columnas = ['id','moderadores'];
        $congresos = $this->AdminModel->getAllColums($columnas,'congresos',$condiciones);

        foreach($congresos as $c){
            $str = $c['moderadores'];
            $str_2 = str_replace ( $valor_actual , $clave , $str , $contador );
            if($contador > 0){
                //HAY QUE ACTUALIZAR EL STR
                $data = ['moderadores' => $str_2];
                $condiciones = ['id' => $c['id']];
                $this->AdminModel->generalUpdate('congresos',$data,$condiciones);
            }

        }

        $pass = password_hash($contacto, PASSWORD_DEFAULT);

        #DATOS A EDITAR
        $updatemoderador = array(
            "clave" => $clave,
            "nombre" => $nombre,
            "contacto" => $contacto,
            );
        $updateusuario = array(
            "nombre" => $nombre,
            "correo" => $contacto,
            'password' => $pass
            );
    
        #HACEMOS EL UPDATE
        
        if (!$this->AdminModel->generalUpdate('moderadores',$updatemoderador,["id"=>$_POST["id"]])) {
                #OCURRIO UN ERROR AL HACER UPDATE, PA ATRAS
                return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intentelo mas tarde. Codigo de error: 101');
                    
        }
        
        if (!$this->AdminModel->generalUpdate('usuarios',$updateusuario,["id"=>$_POST["id_usuario"]])) {
            #OCURRIO UN ERROR AL HACER UPDATE, PA ATRAS
            return redirect()->back()
            ->with('icon', 'warning')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error, intentelo mas tarde. Codigo de error: 101');
            
        }
        #EL UPDATE FUNCIONO, HACEMOS REDIRECCIONES
        return redirect()->to(base_url('admin/congresos/moderadores/lista'))
            ->with('icon', 'success')
            ->with('title', '¡ÉXITO!')
            ->with('text', 'Información actualizada correctamente');   

    }

    public function insertmoderador(){
            
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $data = $_POST;
        $data['updated_by'] = session('nombre');

        $clave = $_POST["clave"];

        $nombre = $_POST["nombre"];

        $contacto = $_POST["contacto"];

        $pass = password_hash($contacto, PASSWORD_DEFAULT);

        $condicion_contacto = array(
            "correo" => $contacto,
        );
        $condicion_clave = array(
            "clave" => $clave,
        );

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $usuario = $this->generar_clave($permitted_chars, 20);

        $data['usuario'] = $usuario;
        
        $insert = array(
            "nombre" => $nombre,
            "correo" => $contacto,
            "password" => $pass,
            "tipo_usuario" => 2,
            'usuario' => $usuario
        );

        if($this->AdminModel->exist('usuarios', $condicion_contacto)){

            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'El contacto del moderador ya esta en uso. Use un contacto diferente o edite el que ya tiene');
        }

        if($this->AdminModel->exist('moderadores', $condicion_clave)){

            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'La clave del moderador ya esta en uso. Use un contacto diferente o edite el que ya tiene');
        }

        if(!$this->AdminModel->generalInsert('moderadores',$data)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error al insertar el moderador. Contacte a sistemas');
        }

        if(!$this->AdminModel->generalInsert('usuarios',$insert)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error al insertar el usuario. Contacte a sistemas');
        }
        return redirect()->to(base_url('/admin/congresos/moderadores/lista'))
            ->with('icon', 'success')
            ->with('title', 'Exito')
            ->with('text', 'El moderador se agrego correctamente');
    }

    public function eliminarmoderador(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        //Al eliminar un moderador
        $condiciones = ['id' => $_POST['id']];
        //OBTENEMOS LOS DATOS DEL MODERADOR MEDIANTE EL ID
        $moderador = $this->AdminModel->getAllOneRow("moderadores", $condiciones);
        //SI NO EXISTE EL ID DE LA TABLA DE MODERADORES REGRESA VACIO EL CUAL REGRESA UN MENSAJE QUE DICE QUE EL MODERADOR NO EXISTE
        if (!$this->AdminModel->exist('moderadores', $condiciones)) {
            return 'empty';
        }
        $condicones_usuarios = ['correo'=> $moderador['contacto']];
        $moderador = $this->AdminModel->generalDelete("moderadores", $condiciones);
        $usuario = $this->AdminModel->generalDelete("usuarios", $condicones_usuarios);
        if ($moderador && $usuario) {
            return 'success';
        } else {
            return 'error';}
    
    }
    #===========================MODERADORES=====================

    #===========================ENLACES=====================

    public function enlaces(){
        
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
        . view('admin/congresos/enlaces/lista')
        . view('admin/footers/index');

    }

    public function getlistaenlaces(){
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = ['id','clave','nombre','contacto'];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM enlaces_congresos";
        $sql_data = "SELECT * FROM enlaces_congresos";

        $condicion = "";

        if(!empty($valor_buscado)){
            foreach($columnas as $key => $val){
                if($columnas[$key] == 'id'){
                    $condicion .= " WHERE ".$val." LIKE '%".$valor_buscado."%'";
                }else{
                    $condicion .= " OR ".$val." LIKE '%".$valor_buscado."%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY ".$columnas[$this->request->getGet('order')[0]['column']]." ".$this->request->getGet('order')[0]['dir']." LIMIT ".$this->request->getGet('start').", ".$this->request->getGet('length')."";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach($array as $key=>$a){

        
            $htmlEliminar = '
            <div class="dropdown">
            <button class="btn btn-danger dropdown-toggle btn-rounded  btn-icon-text" type="button" id="dropdownMenuSizeButton' . $a['id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-alert btn-icon-prepend"></i> Eliminar </button> </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton' . $a['id'] . '" style="">
                <h6 class="dropdown-header">Seleccione una opcion</h6>
                <button class="dropdown-item eliminarenlace" data-id="' . $a['id'] . '">Eliminar enlace</button>
            </div>
            </div>
            ';
            $htmlEditar = '<a type="button" href="editar/'.$a['id'].'" class="btn btn-warning btn-icon-text btn-rounded">
            <i class="mdi mdi-lead-pencil"></i> Editar </a>';
        
            $array[$key] = [
                'id'=>$a['id'],
                'clave' => $a['clave'],
                'nombre' => $a['nombre'],
                'contacto'=>$a['contacto'],
                'editar' => $htmlEditar,
                'eliminar'=>$htmlEliminar,
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

    public function agregaenlace(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        
        return view('admin/headers/index')
        .view('admin/congresos/enlaces/agregar')
        .view('admin/footers/index');

    }

    public function insertenlace(){
            
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $data = $_POST;
        $data['updated_by'] = session('nombre');

        $clave = $_POST["clave"];

        $nombre = $_POST["nombre"];

        $contacto = $_POST["contacto"];
        $pass = password_hash($contacto, PASSWORD_DEFAULT);
        $condicion_contacto = array(
            "correo" => $contacto,
        );
        $condicion_clave = array(
            "clave" => $clave,
        );
        
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $usuario = $this->generar_clave($permitted_chars, 20);

        $data['usuario'] = $usuario;

        $insert = array(
            "nombre" => $nombre,
            "correo" => $contacto,
            "password" => $pass,
            "tipo_usuario" => 4,
            'usuario' => $usuario
        );

        if($this->AdminModel->exist('usuarios', $condicion_contacto)){

            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'El contacto del enlace ya esta en uso. Use un contacto diferente o edite el que ya tiene');
        }
        if($this->AdminModel->exist('enlaces_congresos', $condicion_clave)){

            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'La clave del enlace ya esta en uso. Use una clave diferente o edite el que ya tiene');
        }

        

        if(!$this->AdminModel->generalInsert('enlaces_congresos',$data)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error al insertar el enlace. Contacte a sistemas');
        }
        if(!$this->AdminModel->generalInsert('usuarios',$insert)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error al insertar el usuario. Contacte a sistemas');
        }
        #CUANDO SE INSERTAN LOS DATOS NOS REDIRECCIONA A LA LISTA DE ENLACES
        return redirect()->to(base_url('/admin/congresos/enlaces/lista'))
            ->with('icon', 'success')
            ->with('title', 'Exito')
            ->with('text', 'El enlace se agrego correctamente');
    }

    public function eliminarenlace(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        //Al eliminar un enlace
        $condiciones = ['id' => $_POST['id']];
        //OBTENEMOS LOS DATOS DEL ENLACE MEDIANTE EL ID
        $enlace = $this->AdminModel->getAllOneRow("enlaces_congresos", $condiciones);
        //SI NO EXISTE EL ID DE LA TABLA DE ENLACES REGRESA VACIO EL CUAL REGRESA UN MENSAJE QUE DICE QUE EL ENLACE NO EXISTE
        if (!$this->AdminModel->exist('enlaces_congresos', $condiciones)) {
            return 'empty';
        }
        $condicones_usuarios = ['correo'=> $enlace['contacto']];
        $enlace = $this->AdminModel->generalDelete("enlaces_congresos", $condiciones);
        $usuario = $this->AdminModel->generalDelete("usuarios", $condicones_usuarios);
        if ($enlace && $usuario) {
            return 'success';
        } else {
            return 'error';
        }
    
    }

    public function editarenlace($id){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $enlaces = $this->AdminModel->getAllOneRow('enlaces_congresos', $condiciones);
        
        if (empty($enlaces)) {
            #NO HAY REGISTROS
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'Esta intentando acceder a un registro inexistente');
        }
        $condicones_usuarios = ['correo'=> $enlaces['contacto']];
        $usuario = $this->AdminModel->getAllOneRow('usuarios', $condicones_usuarios);

        if(empty($usuario)){
            #vacio
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'No se ha encontrado el usuario del enlace, contacte a sistemas.');
        }

        //Mostrarenos una vista para que el admin edite los datos
        $data['enlaces_congresos'] = $enlaces;
        $data['id_usuario'] = $usuario['id'];

        return view('admin/headers/index')
            . view('admin/congresos/enlaces/editar', $data)
            . view('admin/footers/index');
    }

    public function updateenlace(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $data = $_POST;

        $data['updated_by'] = session('nombre');
        $clave = $_POST["clave"];
        $nombre = $_POST["nombre"];
        $contacto = $_POST["contacto"];
        #CONDICIONES PARA EVITAR REPETIR DATOS AL MOMENTO DE EDITAR COMO EVITAR REPETIR CONTACTO O CLAVE

        $condicion_contacto = array(
            "correo" => $contacto,
            'id !=' => $_POST['id_usuario'],
            'tipo_usuario' => 4
        );
        $condicion_clave = array(
            "clave" => $clave,
            'id !=' => $_POST['id']
        );

        $condiciones = ['id' => $_POST['id']];
        $info_enlace = $this->AdminModel->getAllOneRow('enlaces_congresos',$condiciones);

        #HACEMOS LAS VALIDACIONES PARA EVITAR REPETIR DATOS EN LA TABLA
        if($this->AdminModel->exist('usuarios', $condicion_contacto)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'El contacto del enlace ya esta en uso. Use un contacto diferente o edite el que ya tiene');
        }

        if($this->AdminModel->exist('enlaces_congresos', $condicion_clave)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'La clave del enlace ya esta en uso. Use un contacto diferente o edite el que ya tiene');
        }

        $condiciones = [];
        $columnas = ['id','enlaces'];
        $congresos = $this->AdminModel->getAllColums($columnas,'congresos',$condiciones);

        $valor_actual = $info_enlace['clave'];
        foreach($congresos as $c){
            $str = $c['enlaces'];
            $str_2 = str_replace ( $valor_actual , $clave , $str , $contador );
            if($contador > 0){
                //HAY QUE ACTUALIZAR EL STR
                $data = ['enlaces' => $str_2];
                $condiciones = ['id' => $c['id']];
                $this->AdminModel->generalUpdate('congresos',$data,$condiciones);
            }

        }

        #DATOS A EDITAR

        $updatemoderador = array(
            "clave" => $clave,
            "nombre" => $nombre,
            "contacto" => $contacto,
        );

        $password = password_hash($contacto,PASSWORD_DEFAULT);

        $updateusuario = array(
            "nombre" => $nombre,
            "correo" => $contacto,
            'password' => $password
        );
    
        #HACEMOS EL UPDATE
        
        if (!$this->AdminModel->generalUpdate('enlaces_congresos',$updatemoderador,["id"=>$_POST["id"]])) {
                #OCURRIO UN ERROR AL HACER UPDATE, PA ATRAS
                return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intentelo mas tarde. Codigo de error: 101');
                    
        }
        
        if (!$this->AdminModel->generalUpdate('usuarios',$updateusuario,["id"=>$_POST["id_usuario"]])) {
            #OCURRIO UN ERROR AL HACER UPDATE, PA ATRAS
            return redirect()->back()
            ->with('icon', 'warning')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error, intentelo mas tarde. Codigo de error: 101');
            
        }
            
        #EL UPDATE FUNCIONO, HACEMOS REDIRECCIONES A LA LISTA DE ENLACES
        return redirect()->to(base_url('admin/congresos/enlaces/lista'))
            ->with('icon', 'success')
            ->with('title', '¡ÉXITO!')
            ->with('text', 'Información actualizada correctamente');   

    }

    public function generar_clave($input, $strength = 16){

        $input_length = strlen($input);

        $random_string = '';

        for ($i = 0; $i < $strength; $i++) {

            $random_character = $input[mt_rand(0, $input_length - 1)];

            $random_string .= $random_character;

        }

        return $random_string;

    }

    public function generarUsuarios(){
        $condiciones = [];
        $enlaces = $this->AdminModel->getAll('moderadores',$condiciones);
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        foreach($enlaces as $e){
            $usuario = $this->generar_clave($permitted_chars, 20);

            $condiciones = [
                'id' => $e['id']
            ];
            $data = ['usuario' => $usuario];

            $this->AdminModel->generalUpdate('moderadores',$data,$condiciones);

            $condiciones = ['correo' => $e['contacto']];

            $this->AdminModel->generalUpdate('usuarios',$data,$condiciones);
        }
    }
    #===========================ENLACES=====================

    #===========================MESAS=====================

    public function mesas(){
        
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
        . view('admin/congresos/mesas/lista')
        . view('admin/footers/index');

    }

    public function getlistamesas(){
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = ['id','clave','nombre'];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM mesas";
        $sql_data = "SELECT * FROM mesas";

        $condicion = "";

        if(!empty($valor_buscado)){
            foreach($columnas as $key => $val){
                if($columnas[$key] == 'id'){
                    $condicion .= " WHERE ".$val." LIKE '%".$valor_buscado."%'";
                }else{
                    $condicion .= " OR ".$val." LIKE '%".$valor_buscado."%'";
                }
            }
        }

        $sql_count = $sql_count . $condicion;
        $sql_data = $sql_data . $condicion;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY ".$columnas[$this->request->getGet('order')[0]['column']]." ".$this->request->getGet('order')[0]['dir']." LIMIT ".$this->request->getGet('start').", ".$this->request->getGet('length')."";

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        foreach($array as $key=>$a){

        
            $htmlEliminar = '
            <div class="dropdown">
            <button class="btn btn-danger dropdown-toggle btn-rounded  btn-icon-text" type="button" id="dropdownMenuSizeButton' . $a['id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-alert btn-icon-prepend"></i> Eliminar </button> </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuSizeButton' . $a['id'] . '" style="">
                <h6 class="dropdown-header">Seleccione una opcion</h6>
                <button class="dropdown-item eliminarmesa" data-id="' . $a['id'] . '">Eliminar mesa</button>
            </div>
            </div>
            ';
            $htmlEditar = '<a type="button" href="editar/'.$a['id'].'" class="btn btn-warning btn-icon-text btn-rounded">
            <i class="mdi mdi-lead-pencil"></i> Editar </a>';
        
            $array[$key] = [
                'id'=>$a['id'],
                'clave' => $a['clave'],
                'nombre' => $a['nombre'],
                'editar' => $htmlEditar,
                'eliminar'=>$htmlEliminar,
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

    public function editarmesas($id){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = ['id' => $id];
        $mesas = $this->AdminModel->getAllOneRow('mesas', $condiciones);
        if (empty($mesas)) {
            #NO HAY REGISTROS
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Opss')
                ->with('text', 'Esta intentando acceder a un registro inexistente');
        }
        //Mostrarenos una vista para que el admin edite los datos
        $data['mesas'] = $mesas;

        return view('admin/headers/index')
            . view('admin/congresos/mesas/editar', $data)
            . view('admin/footers/index');
    }

    public function updatemesas(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $data = $_POST;
        $data['updated_by'] = session('nombre');
        $clave = $_POST["clave"];
        $nombre = $_POST["nombre"];
        #CONDICIONES PARA EVITAR REPETIR DATOS AL MOMENTO DE EDITAR COMO EVITAR REPETIR CONTACTO O CLAVE
        $condicion_nombre = array(
            "nombre" => $nombre,
            'id !=' => $_POST['id']
        );
        $condicion_clave = array(
            "clave" => $clave,
            'id !=' => $_POST['id']
        );
        #HACEMOS LAS VALIDACIONES PARA EVITAR REPETIR DATOS EN LA TABLA
        if($this->AdminModel->exist('mesas', $condicion_nombre)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'El nombre de la mesa ya esta en uso. Use un nombre diferente o edite el que ya tiene');
        }
        if($this->AdminModel->exist('mesas', $condicion_clave)){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'La clave de la mesa ya esta en uso. Use un clave diferente o edite el que ya tiene');
        }
        #DATOS A EDITAR
        $updatemesa = array(
            "clave" => $clave,
            "nombre" => $nombre,
        
            );
    
    
        #HACEMOS EL UPDATE
        
        if (!$this->AdminModel->generalUpdate('mesas',$updatemesa,["id"=>$_POST["id"]])) {
                #OCURRIO UN ERROR AL HACER UPDATE, PA ATRAS
                return redirect()->back()
                ->with('icon', 'warning')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intentelo mas tarde. Codigo de error: 101');
                    
        }
        
        #EL UPDATE FUNCIONO, HACEMOS REDIRECCIONES A LA LISTA DE ENLACES
        return redirect()->to(base_url('admin/congresos/mesas/lista'))
            ->with('icon', 'success')
            ->with('title', '¡ÉXITO!')
            ->with('text', 'Información actualizada correctamente');   

    }

    public function agregarmesas(){

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        
        return view('admin/headers/index')
        .view('admin/congresos/mesas/agregar')
        .view('admin/footers/index');

    }

    public function insertmesas(){
            
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $data = $_POST;
        $data['updated_by'] = session('nombre');
        
        if($this->AdminModel->generalInsert('mesas',$data)){
            return redirect()->to(base_url('/admin/congresos/mesas/lista'))
            ->with('icon', 'success')
            ->with('title', 'Exito')
            ->with('text', 'La mesa se agrego correctamente');
        }else{
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error. Contacte a sistemas');
        }
    }

    public function eliminarmesa(){
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }
        //Al eliminar un enlace
        $condiciones = ['id' => $_POST['id']];
        //SI NO EXISTE EL ID DE LA TABLA DE MESAS REGRESA VACIO EL CUAL REGRESA UN MENSAJE QUE DICE QUE LA MESA NO EXISTE

        if (!$this->AdminModel->exist('mesas', $condiciones)) {
            return 'empty';
        }else{
        $mesa = $this->AdminModel->generalDelete("mesas", $condiciones);
        if ($mesa) {
            return 'success';
        } else {
            return 'error';}
        }
    }

    #===========================MESAS=====================

    public function horariosModeradores(){

        if (session('user_type') != 2) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];

        $congresos = $this->AdminModel->getAll("congresos", $condiciones);

        $data = [];

        $p = 0;

        foreach($congresos as $c){

            #RECORREMOS CADA CONGRESO Y HACEMOS EL EXPLODE DE LOS VALORES DE CADA CONGRESO

            $explode_enlaces = explode(",", $c["enlaces"]);

            $explode_mesas = explode(",", $c["mesas"]);

            $explode_moderadores = explode(",", $c["moderadores"]);

            $explode_horarios = explode(",", $c["infoHorarios"]);

            $explode_temas = explode(",", $c["temas"]);

            $explode_zoom = explode(',', $c['zoom']);

            #RECORREMOS CADA HORARIO DEL EVENTO, ESTE HORARIO ES UN DIA Y UNA HORA EN ESPECIFICO DEL EVENTO

            for ($i = 0; $i < (count($explode_horarios) - 1); $i++) {

                #CON CADA HORARIO, CONLLEVA A CADA UNO DE LOS SALONES, CON ESO SOBRE LA MESA, TENEMOS QUE RECORRER CADA SALON DEL EVENTO. CADA HORARIO TIENE X NUMERO DE SALONES.

                for ($e = 0; $e <= $c["salones"] - 1; $e++) {

                    #HACEMOS UNA COMPROBACION SI AUN FORMA PARTE DEL CICLO

                    if ($e <= $c["salones"]) {

                        $name = "ponencias_salon_" . ($e + 1) . "_horario_" . ($i + 1) . ";";

                        $data[$p] = [
                            'congreso' => $c['nombre'],
                            'horario' => $explode_horarios[$i],
                            'salon' => $explode_temas[$e],
                            'anio' => $c['anio']
                        ];

                        $nameMod  = "moderadores_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                        $explodeModeradores = explode($nameMod, $c["moderadores"]); // 0 nombre 1 valor

                        if(!isset($explode_zoom[$e])){
                            $zoom = '';
                        }else{
                            $zoom = $explode_zoom[$e];
                        }

                        if (isset($explodeModeradores[1])) {

                            $valoresMod = explode("-", $explodeModeradores[1]); //en 0 estan los valores para ese string 

                            $valor_real_ciclo_mod = explode(";", $valoresMod[0]);

                            $valor_real_ciclo_mod = $valor_real_ciclo_mod[1];

                            if ($valor_real_ciclo_mod == "None" || $valor_real_ciclo_mod == '') {

                                $valor_real_ciclo_mod  = "Sin registrar";

                            } else {

                                //SACAMOS EL VALOR EN TEXTO PLANO DE LA CLAVE

                                $condicion = ["clave" => $valor_real_ciclo_mod];

                                $nombre_mod = $this->AdminModel->getAllOneRow("moderadores", $condicion);

                                $valor_real_ciclo_mod = $nombre_mod["nombre"];

                            }

                        }

                        $data[$p]['moderador'] = $valor_real_ciclo_mod;
                        $data[$p]['zoom'] = $zoom;

                        $nameMesa  = "mesas_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                        $explodeMesas = explode($nameMesa, $c["mesas"]); // 0 nombre 1 valor

                        if (isset($explodeMesas[1])) {

                            $valoresMod = explode("-", $explodeMesas[1]); //en 0 estan los valores para ese string 

                            $valor_real_ciclo_mod = explode(";", $valoresMod[0]);

                            $valor_real_ciclo_mod = $valor_real_ciclo_mod[1];

                            if ($valor_real_ciclo_mod == "None" || $valor_real_ciclo_mod == '') {

                                $valor_real_ciclo_mod  = "Sin registrar";

                            } else {

                                //SACAMOS EL VALOR EN TEXTO PLANO DE LA CLAVE

                                $condicion = ["clave" => $valor_real_ciclo_mod];

                                $nombre_mesa = $this->AdminModel->getAllOneRow("mesas", $condicion);

                                $valor_real_ciclo_mod = $nombre_mesa["nombre"];

                            }

                        }

                        if ($c["ponencias"] !== "") {

                            $posicion = explode($name, $c["ponencias"]); //0 es vacio o en donde termina y el 1 tiene toodo lo demas del string

                            if (isset($posicion[1])) {

                                $valores = explode("-", $posicion[1]); //en 0 estan los valores para ese tring 

                                $valor_selects = explode(",", $valores[0]); //Me da valores del 0 al 4

                                $q = 0;

                                $valor_selects = array_filter($valor_selects, function($element) {
                                    return !empty($element);
                                });

                                foreach ($valor_selects as $v) {

                                    $condiciones = array("submission_id" => $v);

                                    $nombre_ponencia = $this->AdminModel->getAllOneRow("ponencias", $condiciones);

                                    if (!empty($nombre_ponencia)) {

                                        $data[$p]['ponencias'][$q]['ponencia'] = $nombre_ponencia["nombre"];

                                        $data[$p]['ponencias'][$q]['ponente'] = $nombre_ponencia["ponente"];

                                        $data[$p]['ponencias'][$q]['submission_id'] = $nombre_ponencia["submission_id"];

                                    } else {

                                        $condiciones = ['submission_id' => $v];
                                        $columnas = ['publication_id'];
                                        $publication_id = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);

                                        if (empty($publication_id)) {
                                            $data[$p]['ponencias'][$q]['ponencia'] = "No encontrado.";
                                            $data[$p]['ponencias'][$q]['ponente'] = "No encontrado.";
                                        }else{
                                            $condiciones = array("publication_id" => $publication_id['publication_id']);
                                            $nombre_ponencia = $this->AdminModel->getAllOneRow("ponencias", $condiciones);
    
                                            if(empty($nombre_ponencia)){
                                                $data[$p]['ponencias'][$q]['ponencia'] = "No encontrado..";
                                                $data[$p]['ponencias'][$q]['ponente'] = "No encontrado..";
                                            }else{
                                                $data[$p]['ponencias'][$q]['ponencia'] = $nombre_ponencia["nombre"];
                                                $data[$p]['ponencias'][$q]['ponente'] = $nombre_ponencia["ponente"];
                                            }
                                        }

                                    }

                                    $q++;

                                }

                                $q = 0;

                        }

                    }

                    }

                    $p++;

                }

            }

            

            

            /*

            if (isset($posicion[1])) {

                $valores = explode("-", $posicion[1]); //en 0 estan los valores para ese tring 

                $valor_selects = explode(",", $valores[0]); //Me da valores del 0 al 4

            }*/

        }

        echo '<pre>';
        #print_r($data);
        echo '</pre>';
        #exit;
        
        foreach($data as $key=>$d){

            if($d['moderador'] != session('nombre') || $d['anio'] != date('Y')){  #|| $d['anio'] != date('Y') para que solo aparezcan del año en cuestion
                unset($data[$key]);
            }

        }

        echo '<pre>';
        #print_r($data);
        echo '</pre>';
        #exit;

        if(empty($data)){
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Aun no ha sido asignado a ningun horario en los congresos en este año. Intente mas tarde o contacte al equipo REDESLA.');
        }
        $data_congresos['congresos'] = $data;

        return view('admin/headers/index')
        . view('admin/congresos/horarios/moderadores/lista',$data_congresos)
        . view('admin/footers/index');

        

        #$this->load->view('admin/ponencias_asistencias',$data2);
    }

    public function horariosEnlaces(){

        if (session('user_type') != 4) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [];

        $congresos = $this->AdminModel->getAll("congresos", $condiciones);

        $data = [];

        $p = 0;

        foreach($congresos as $c){

            #RECORREMOS CADA CONGRESO Y HACEMOS EL EXPLODE DE LOS VALORES DE CADA CONGRESO

            $explode_enlaces = explode(",", $c["enlaces"]);

            $explode_mesas = explode(",", $c["mesas"]);

            $explode_moderadores = explode(",", $c["moderadores"]);

            $explode_horarios = explode(",", $c["infoHorarios"]);

            $explode_temas = explode(",", $c["temas"]);

            $explode_zoom = explode(',', $c['zoom']);

            $tabla_constancias = 'constancia_'.$c['red'];

            #RECORREMOS CADA HORARIO DEL EVENTO, ESTE HORARIO ES UN DIA Y UNA HORA EN ESPECIFICO DEL EVENTO

            for ($i = 0; $i < (count($explode_horarios) - 1); $i++) {

                #CON CADA HORARIO, CONLLEVA A CADA UNO DE LOS SALONES, CON ESO SOBRE LA MESA, TENEMOS QUE RECORRER CADA SALON DEL EVENTO. CADA HORARIO TIENE X NUMERO DE SALONES.

                for ($e = 0; $e <= $c["salones"] - 1; $e++) {

                    #HACEMOS UNA COMPROBACION SI AUN FORMA PARTE DEL CICLO

                    if ($e <= $c["salones"]) {

                        $name = "ponencias_salon_" . ($e + 1) . "_horario_" . ($i + 1) . ";";

                        $condiciones = ['clave' => $explode_enlaces[$e]];
                        $info_enlace = $this->AdminModel->getAllOneRow('enlaces_congresos',$condiciones);

                        if(empty($info_enlace)){
                            $nombre_enlace = 'No encontrado';
                            $usuario_enlace = 'No encontrado';
                        }else{
                            $nombre_enlace = $info_enlace['nombre'];
                            $usuario_enlace = $info_enlace['usuario'];
                        }

                        $nameMesas  = "mesas_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                        $explodeMesa = explode($nameMesas, $c["mesas"]);

                        if(!isset($explode_zoom[$e])){
                            $zoom = '';
                        }else{
                            $zoom = $explode_zoom[$e];
                        }

                        $data[$p] = [
                            'congreso' => $c['nombre'],
                            'horario' => $explode_horarios[$i],
                            'salon' => $explode_temas[$e],
                            'zoom' => $zoom,
                            'anio' => $c['anio'],
                            'enlace' => $explode_enlaces[$e],
                            'nombre_enlace' => $nombre_enlace,
                            'usuario_enlace' => $usuario_enlace,
                            'red' => $c['red']
                        ];

        

                        $nameMod  = "moderadores_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                        $explodeModeradores = explode($nameMod, $c["moderadores"]); // 0 nombre 1 valor

                        if (isset($explodeModeradores[1])) {

                            $valoresMod = explode("-", $explodeModeradores[1]); //en 0 estan los valores para ese string 

                            $valor_real_ciclo_mod = explode(";", $valoresMod[0]);

                            $valor_real_ciclo_mod = $valor_real_ciclo_mod[1];

                            if ($valor_real_ciclo_mod == "None" || $valor_real_ciclo_mod == '') {

                                if($c['red'] == 'Releg'){
                                    $valor_real_ciclo_mod = session('nombre');

                                    $contacto_mod = 'No aplica';
                                }else{
                                    $valor_real_ciclo_mod  = '<span class="text-danger">No encontrado</span>';

                                    $contacto_mod = '<span class="text-danger">No encontrado</span>';
                                }

                                

                            } else {

                                //SACAMOS EL VALOR EN TEXTO PLANO DE LA CLAVE

                                $condicion = ["clave" => $valor_real_ciclo_mod];

                                $nombre_mod = $this->AdminModel->getAllOneRow("moderadores", $condicion);

                                if($c['red'] == 'Releg'){
                                    $valor_real_ciclo_mod = session('nombre');

                                    $contacto_mod = 'No aplica';
                                }else{
                                    $valor_real_ciclo_mod = $nombre_mod["nombre"];

                                    $contacto_mod = $nombre_mod['contacto'];
                                }

                                

                            }

                        }

                        $data[$p]['moderador'] = $valor_real_ciclo_mod;
                        $data[$p]['contacto_mod'] = $contacto_mod;

                        if (isset($explodeMesa[1])) {

                            $valoresMod = explode("-", $explodeMesa[1]); //en 0 estan los valores para ese string 

                            $valor_real_ciclo_mod = explode(";", $valoresMod[0]);

                            $valor_real_ciclo_mod = $valor_real_ciclo_mod[1];

                            if ($valor_real_ciclo_mod == "None" || $valor_real_ciclo_mod == '') {

                                $valor_real_ciclo_mod  = "Sin registrar";

                            } else {

                                //SACAMOS EL VALOR EN TEXTO PLANO DE LA CLAVE

                                $condicion = ["clave" => $valor_real_ciclo_mod];

                                $nombre_mesa = $this->AdminModel->getAllOneRow("mesas", $condicion);

                                $valor_real_ciclo_mod = $nombre_mesa["nombre"];

                            }

                        }

                        $data[$p]['mesa'] = $valor_real_ciclo_mod;

                        

                        $nameMesa  = "mesas_salon_" . ($e + 1) . "_horario_" . ($i + 1);

                        $explodeMesas = explode($nameMesa, $c["mesas"]); // 0 nombre 1 valor

                        if (isset($explodeMesas[1])) {

                            $valoresMod = explode("-", $explodeMesas[1]); //en 0 estan los valores para ese string 

                            $valor_real_ciclo_mod = explode(";", $valoresMod[0]);

                            $valor_real_ciclo_mod = $valor_real_ciclo_mod[1];

                            if ($valor_real_ciclo_mod == "None" || $valor_real_ciclo_mod == '') {

                                $valor_real_ciclo_mod  = "Sin registrar";

                            } else {

                                //SACAMOS EL VALOR EN TEXTO PLANO DE LA CLAVE

                                $condicion = ["clave" => $valor_real_ciclo_mod];

                                $nombre_mesa = $this->AdminModel->getAllOneRow("mesas", $condicion);

                                $valor_real_ciclo_mod = $nombre_mesa["nombre"];

                            }

                        }

                        if ($c["ponencias"] != "") {

                            $posicion = explode($name, $c["ponencias"]); //0 es vacio o en donde termina y el 1 tiene toodo lo demas del string

                            if (isset($posicion[1])) {

                                $valores = explode("-", $posicion[1]); //en 0 estan los valores para ese tring 

                                $valor_selects = explode(",", $valores[0]); //Me da valores del 0 al 4

                                $q = 0;

                                $valor_selects = array_filter($valor_selects, function($element) {
                                    return !empty($element);
                                });

                                foreach ($valor_selects as $v) {

                                    $condiciones = array("submission_id" => $v);

                                    $nombre_ponencia = $this->AdminModel->getAllOneRow("ponencias", $condiciones);

                                    if (!empty($nombre_ponencia)){

                                        $condiciones = [
                                            'publication_id' => $nombre_ponencia['publication_id'],
                                            'tipo_constancia' => 'Ponente'
                                        ];

                                        $data[$p]['ponencias'][$q]['ponencia'] = $nombre_ponencia["nombre"];
                                        $data[$p]['ponencias'][$q]['ponente'] = $nombre_ponencia["ponente"];
                                        $data[$p]['ponencias'][$q]['submission_id'] = $nombre_ponencia['submission_id'];
                                        $data[$p]['ponencias'][$q]['publication_id'] = $nombre_ponencia['publication_id'];
                                        $data[$p]['ponencias'][$q]['clave_ponencia'] = $nombre_ponencia['clave_ponencia'];

                                        if($this->AdminModel->exist($tabla_constancias,$condiciones)){
                                            $data[$p]['ponencias'][$q]['constancias'] = 1;
                                        }else{
                                            $condiciones = [
                                                'publication_id' => $nombre_ponencia['publication_id'],
                                                'tipo_constancia' => 'Coloquio'
                                            ];

                                            $data[$p]['ponencias'][$q]['constancias'] = $this->AdminModel->exist($tabla_constancias,$condiciones) ? 1 : 0;
                                        }

                                        

                                    } else {

                                        $condiciones = ['submission_id' => $v];
                                        $columnas = ['publication_id'];
                                        $publication_id = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);

                                        if (empty($publication_id)) {
                                            $data[$p]['ponencias'][$q]['ponencia'] = "No encontrado.";
                                            $data[$p]['ponencias'][$q]['ponente'] = "No encontrado.";
                                        }else{
                                            $condiciones = array("publication_id" => $publication_id['publication_id']);
                                            $nombre_ponencia = $this->AdminModel->getAllOneRow("ponencias", $condiciones);
    
                                            if(empty($nombre_ponencia)){
                                                $data[$p]['ponencias'][$q]['ponencia'] = "No encontrado..";
                                                $data[$p]['ponencias'][$q]['ponente'] = "No encontrado..";
                                            }else{

                                                $condiciones = [
                                                    'publication_id' => $nombre_ponencia['publication_id'],
                                                    'tipo_constancia' => 'Ponente'
                                                ];

                                                $data[$p]['ponencias'][$q]['ponencia'] = $nombre_ponencia["nombre"];
                                                $data[$p]['ponencias'][$q]['ponente'] = $nombre_ponencia["ponente"];
                                                $data[$p]['ponencias'][$q]['submission_id'] = $nombre_ponencia['submission_id'];
                                                $data[$p]['ponencias'][$q]['publication_id'] = $nombre_ponencia['publication_id'];
                                                $data[$p]['ponencias'][$q]['clave_ponencia'] = $nombre_ponencia['clave_ponencia'];

                                                if($this->AdminModel->exist($tabla_constancias,$condiciones)){
                                                    $data[$p]['ponencias'][$q]['constancias'] = 1;
                                                }else{
                                                    $condiciones = [
                                                        'publication_id' => $nombre_ponencia['publication_id'],
                                                        'tipo_constancia' => 'Coloquio'
                                                    ];

                                                    $data[$p]['ponencias'][$q]['constancias'] = $this->AdminModel->exist($tabla_constancias,$condiciones) ? 1 : 0;

                                                    //$data[$p]['ponencias'][$q]['constancias'] = 0;
                                                }

                                            }
                                        }

                                    }

                                    $q++;

                                }

                                $q = 0;

                        }

                    }

                    }

                    $p++;

                }

            }

            

            

            /*

            if (isset($posicion[1])) {

                $valores = explode("-", $posicion[1]); //en 0 estan los valores para ese tring 

                $valor_selects = explode(",", $valores[0]); //Me da valores del 0 al 4

            }*/

        }


        echo '<pre>';
        #print_r($data);
        echo '</pre>';
        #exit;

        foreach($data as $key=>$d){

            if($d['usuario_enlace'] != session('usuario')){  #|| $d['anio'] != date('Y') para que solo aparezcan del año en cuestion
                unset($data[$key]);
            }

        }
        #echo session('nombre');
        

        if(empty($data)){
            return redirect()->back()
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Aun no ha sido asignado a ningun horario en los congresos en este año. Intente mas tarde o contacte al equipo REDESLA.');
        }
        $data_congresos['congresos'] = $data;

        return view('admin/headers/index')
        . view('admin/congresos/horarios/enlaces/lista',$data_congresos)
        . view('admin/footers/index');

        

        #$this->load->view('admin/ponencias_asistencias',$data2);
    }

    public function getSubmissionIds(){

        $redes = ['Relayn', 'Relep', 'Relen', 'Releem','Releg'];

        foreach($redes as $r){
            $tabla = 'constancia_'.$r;

            $condiciones = [
                'tipo_constancia' => 'Ponente',
            ];
            $columnas = ['id','publication_id'];

            $constancias = $this->AdminModel->getAllColums($columnas,$tabla,$condiciones);

            foreach($constancias as $c){
                $condiciones = ['publication_id' => $c['publication_id']];
                $columnas = ['submission_id'];
                $submission_id = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);

                if(!empty($submission_id)){
                    $data = ['submission_id' => $submission_id['submission_id']];
                    $condiciones = ['id' => $c['id']];
                    $this->AdminModel->generalUpdate($tabla,$data,$condiciones);
                }
            }
        }

        /*
        $condiciones = [];
        $columnas = ['id','publication_id'];

        $pub = $this->AdminModel->getAllColums($columnas,'participantes_congresos',$condiciones);

        foreach($pub as $p){
            $condiciones = ['publication_id' => $p['publication_id']];
            $columnas = ['submission_id'];
            $submission_id = $this->IquatroModel->getColumnsOneRow($columnas, 'publications', $condiciones);

            if(!empty($submission_id)){
                $data = ['submission_id' => $submission_id['submission_id']];
                $condiciones = ['id' => $p['id']];
                $this->AdminModel->generalUpdate('participantes_congresos',$data,$condiciones);
            }
        }
        */

    }

    public function constancias_ponentes(){

        #AQUI OTORGAMOS LAS CONSTANCIAS DE PONENTES PARA TODOS LOS MIEMBROS DEL GRUPO QUE NO SEAN OYENTES

        $publication_id = $_POST['publication_id'];
        $submission_id = $_POST['submission_id'];

        $condiciones = [
            'publication_id' => $publication_id,
            'submission_id' => $submission_id,
        ];

        $columnas = ['nombre_congreso'];

        $info_ponencia = $this->AdminModel->getColumnsOneRow($columnas,'ponencias',$condiciones);

        $explode_congreso = explode(' ',$info_ponencia['nombre_congreso']);

        $tipo_congreso = $explode_congreso[0] == 'Coloquio' ? 'Coloquio' : 'Ponente';

        $condiciones = [
            'publication_id' => $publication_id,
            'submission_id' => $submission_id,
            'oyente' => 0
        ];

        $autores = $this->AdminModel->getAll('participantes_congresos',$condiciones);

        if(empty($autores)){
            http_response_code(404);
            $mensaje = 'No se han encontrado autores para esta ponencia. Favor de comunicarse con el equipo REDESLA y notifique el problema. El ID de la ponencia es '.$submission_id;
            echo $mensaje;
            exit;
        }

        foreach($autores as $a){
            #VAMOS A AñADIR LA DATA PARA INSERTAR LA CONSTANCIA DE PONENTE A LA RED
            $tabla = 'constancia_'.ucfirst($a['red']);
            if($a['usuario'] == '' || $a['usuario'] === null){
                http_response_code(500);
                $mensaje = 'No se ha encontrado uno de los autores. Favor de comunicarse con el equipo REDESLA. El ID de la ponencia es '.$submission_id;
                echo $mensaje;
                exit;
            }

            $data[] = [
                'usuario' => $a['usuario'],
                'nombre' => $a['nombre'],
                'tipo_constancia' => $tipo_congreso,
                'redCueAca' => $a['claveCuerpo'],
                'publication_id' => $publication_id,
                'submission_id' => $submission_id,
                'red' => ucfirst($a['red']),
                'anio' => $a['anio'],
                'fecha_registro' => date('Y-m-d H:i:s'),
                'inserted_by' => session('nombre')
            ];
        }

        foreach($data as $d){

            $tabla = 'constancia_'.ucfirst($d['red']);
            $infoConstancia = $d;
            $inserted_id = $this->AdminModel->generalInsertLastId($infoConstancia,$tabla);

            if($inserted_id === null){
                http_response_code(500);
                $mensaje = 'Ha ocurrido un error al insertar una constancia. Favor de comunicarse con el equipo REDESLA. El ID de la ponencia es '.$submission_id;
                echo $mensaje;
                exit;
            }

            $condiciones = ['id' => $inserted_id];
            $infoAct = [
                'folio' => $inserted_id
            ];

            if(!$this->AdminModel->generalUpdate($tabla,$infoAct,$condiciones)){
                http_response_code(500);
                $mensaje = 'Ha ocurrido un error con el folio de la constancia. Favor de comunicarse con el equipo REDESLA. El ID de la ponencia es '.$submission_id;
                echo $mensaje;
                exit;
            }
        }

        http_response_code(200);
        $response = [
            'title' => 'Éxito',
            'mensaje' => 'Constancias otorgadas correctamente.',
        ];

        echo json_encode($response);
        exit;
    }

    public function instruccionesEnlaces(){

        if (session('user_type') != 4) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
        . view('admin/congresos/horarios/enlaces/instrucciones')
        . view('admin/footers/index');
    }


    #=================PARTICIPANTES=================

    public function participantes(){
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        return view('admin/headers/index')
        . view('admin/congresos/participantes/lista')
        . view('admin/footers/index');
    }

    public function getListadoParticipantes(){
        $valor_buscado = $this->request->getGet('search')['value']; #VALOR DEL INPUT DE BUSCAR

        $columnas = [
            'id', 'clave_gafete','nombre','claveCuerpo', 'anio', 'oyente', 'red', 'tipo_asistencia', 'nombre_congreso','submission_id'
        ];

        //sin grado ni usuario

        $sql_count = "SELECT count(id) as total FROM participantes_congresos";
        $sql_data = "SELECT * FROM participantes_congresos";

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

            $condiciones = [
                'usuario' => $a['usuario'],
                'tipo_constancia' => 'Asistencia',
                'anio' => $a['anio']
            ];

            $tabla = 'constancia_'.ucfirst($a['red']);

            $isset_asistencia = $this->AdminModel->getAllOneRow($tabla,$condiciones);

            $array[$key] = [
                'id' => $a['id'],
                'clave_gafete' => $a['clave_gafete'],
                'nombre' => $a['nombre'],
                'claveCuerpo' => $a['claveCuerpo'],
                'anio' => $a['anio'],
                'oyente' => $a['oyente'],
                'red' => $a['red'],
                'tipo_asistencia' => $a['tipo_asistencia'],
                'nombre_congreso' => $a['nombre_congreso'],
                'submission_id' => $a['submission_id'],
                'isset_asistencia' => $isset_asistencia
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

    #==================== Ganadores de los congresos =========================

    public function ganadores($red, $anio){
        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        //Vamos a traernos las ponencias que participaron durante ese congreso

        $condiciones = ['red' => $red, 'anio' => $anio];
        $columnas = ['id','publication_id', 'submission_id', 'nombre', 'claveCuerpo'];
        $ponencias = $this->AdminModel->getAllColums($columnas,'ponencias',$condiciones);

        if(empty($ponencias)){
            throw PageNotFoundException::forPageNotFound();
        }

        $tabla = 'constancia_'.ucfirst($red);
        
        $primer_lugar = $this->getProfilePicGanadores($tabla,$anio,1);
        $segundo_lugar = $this->getProfilePicGanadores($tabla,$anio,2);
        $tercer_lugar = $this->getProfilePicGanadores($tabla,$anio,3);
        
        $data = [
            'ponencias' => $ponencias,
            'red' => $red,
            'lugares' => [
                'primero' => [
                    'ponencia' => $primer_lugar['nombre_ponencia'],
                    'miembros' => $primer_lugar['data_constancias'],
                    'claveCuerpo' => $primer_lugar['claveCuerpo'],
                    'uni' => $primer_lugar['uni']
                ],
                'segundo' => [
                    'ponencia' => $segundo_lugar['nombre_ponencia'],
                    'miembros' => $segundo_lugar['data_constancias'],
                    'claveCuerpo' => $segundo_lugar['claveCuerpo'],
                    'uni' => $segundo_lugar['uni']
                ],
                'tercero' => [
                    'ponencia' => $tercer_lugar['nombre_ponencia'],
                    'miembros' => $tercer_lugar['data_constancias'],
                    'claveCuerpo' => $tercer_lugar['claveCuerpo'],
                    'uni' => $tercer_lugar['uni']
                ],
            ]
            
        ];

        /* echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit; */


        return view('admin/headers/index')
        . view('admin/congresos/ganadores/lista',$data)
        . view('admin/footers/index');
    }

    private function getProfilePicGanadores($tabla, $anio, $lugar){

        $columnas = ['nombre','usuario','publication_id'];
        $condiciones_constancias = ['tipo_constancia' => 'Reconocimiento_IQ4', 'anio' => $anio, 'lugar' => $lugar];
        $data_constancias = $this->AdminModel->getAllColums($columnas,$tabla,$condiciones_constancias);

        $nombre_ponencia = '';
        $claveCuerpo = '';
        $nombre_uni = '';
        
        
        if(!empty($data_constancias)){
            //Hay datos, vamos a sacar la info
            foreach($data_constancias as $key=> $d){
                $condiciones = ['usuario' => $d['usuario']];
                $columnas = ['profile_pic'];
                $usuario = $this->AdminModel->getColumnsOneRow($columnas,'usuarios',$condiciones);
                if(!empty($usuario)){
                    $data_constancias[$key]['profile_pic'] = $usuario['profile_pic'] === null ? 'avatar.png' : $usuario['profile_pic'];
                }
            }

            $condiciones = ['publication_id' => $data_constancias[0]['publication_id']];
            $ponencia = $this->AdminModel->getAllOneRow('ponencias',$condiciones);

            if(!empty($ponencia)){
                $nombre_ponencia = $ponencia['nombre'];
                $claveCuerpo = $ponencia['claveCuerpo'];

                $condiciones =['claveCuerpo' => $claveCuerpo];
                $columnas = ['nombre'];

                $uni = $this->AdminModel->getColumnsOneRow($columnas,'cuerpos_academicos',$condiciones);

                if(!empty($uni)){
                    $nombre_uni = $uni['nombre'];
                }
                
            }

        }

        $data = [
            'nombre_ponencia' => $nombre_ponencia,
            'data_constancias' => $data_constancias,
            'claveCuerpo' => $claveCuerpo,
            'uni' => $nombre_uni
        ];

        return $data;
    }

    public function updateGanadores(){

        //Estas constancias tendran la abreviatura RIQ - 680

        $data = $_POST;

        $publication_id = $data['publication_id'];
        $submission_id = $data['submission_id'];
        $lugar = $data['lugar'];

        //Vamos a traernos la info de esta ponencia

        $condiciones = ['publication_id' => $publication_id, 'submission_id' => $submission_id];
        $ponencia = $this->AdminModel->getAllOneRow('ponencias',$condiciones);

        if( empty($ponencia) ){
            http_response_code(800);
            exit;
        }

        $tabla = 'constancia_'.ucfirst($ponencia['red']);

        $dataSend = [
            'publication_id' => $publication_id,
            'submisson_id' => $submission_id,
            'lugar' => $lugar,
            'red' => $ponencia['red'],
            'anio' => $ponencia['anio'],
            'tabla' => $tabla
        ];

        $condiciones = ['cuerpoAcademico' => $ponencia['claveCuerpo']];
        $miembros_nuevos = $this->AdminModel->getAll('miembros',$condiciones);

        if(empty($miembros_nuevos)){
            http_response_code(801);
            exit;
        }

        

        //Primero vamos a verificar si ya hay registros de ese lugar en la plataforma
        $condiciones_constancias = ['tipo_constancia' => 'Reconocimiento_IQ4', 'anio' => $ponencia['anio'], 'lugar' => $lugar];

        $is_constancias = $this->AdminModel->exist($tabla,$condiciones_constancias);

        if($is_constancias){
            /* Significa que hay reconocimientos de ese año y ese lugar, por lo que la info se va a eliminar y agregaremos los nuevos  */
            /*  'submission_id' => $submission_id, 'publication_id' => $publication_id, 'anio' => $ponencia['anio'] */
            $this->AdminModel->generalDelete($tabla,$condiciones_constancias);

            $this->generarConstanciasRIQ($miembros_nuevos, $dataSend);
            
        }else{
            $this->generarConstanciasRIQ($miembros_nuevos, $dataSend);
        }

        echo json_encode($is_constancias);
        exit;

        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }

    private function generarConstanciasRIQ($data, $send){
        
        $data_insert = [];

        foreach($data as $m){
            $condiciones = ['usuario' => $m['usuario']];
            $columnas = ['nombre', 'ap_paterno', 'ap_materno'];
            $usuario = $this->AdminModel->getColumnsOneRow($columnas,'usuarios',$condiciones);

            if(empty ($usuario)){
                http_response_code(900);
                exit;
            }

            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'].' '.$usuario['ap_paterno'] : $usuario['nombre'].' '.$usuario['ap_paterno'].' '.$usuario['ap_materno'];
            
            $data_insert = [
                'usuario' => $m['usuario'],
                'nombre' => $nombre,
                'tipo_constancia' => 'Reconocimiento_IQ4',
                'redCueAca' => $m['cuerpoAcademico'],
                'publication_id' => $send['publication_id'],
                'submission_id' => $send['submisson_id'],
                'lugar' => $send['lugar'],
                'red' => $send['red'],
                'anio' => $send['anio'],
                'fecha_registro' => date('Y-m-d H:i:s'),
            ];

            $inserted_id = $this->AdminModel->generalInsertLastId($data_insert,$send['tabla']);

            if($inserted_id === null){
                http_response_code(901);
                exit;
            }

            $folio_completo = $inserted_id.'RIQ-'.ucfirst($send['red']).'-'.$send['anio'];

            $condiciones = ['id' => $inserted_id];
            $infoAct = [
                'folio' => $inserted_id,
                'folio_completo' => $folio_completo
            ];

            if(!$this->AdminModel->generalUpdate($send['tabla'],$infoAct,$condiciones)){
                http_response_code(902);
                exit;
            }

        }

    }

    /* ACORTADOR DE URL */

    public function shortUrl($red,$anio){
        
        $condiciones = [
            'red' => $red,
            'anio' => $anio
        ];

        $info_congreso = $this->AdminModel->getAllOneRow('congresos_info',$condiciones);

        if(empty($info_congreso)){
            return view('error_handling/empty');
        }

        $nombre = $info_congreso['nombre'];

        $path = ROOTPATH.'/resources/pdf/congresos/'.$nombre.'.pdf';

        if(!file_exists($path)){
            return view('error_handling/empty');
        }

        $fp = fopen($path, 'rb');
        header('Content-Type: application/pdf');
        header('Content-Length: ' . filesize($path));

        # CORREGIDO: Usa fpassthru($fp) en lugar de fpassthru($path)
        fpassthru($fp);
        exit;
    }

    



}
