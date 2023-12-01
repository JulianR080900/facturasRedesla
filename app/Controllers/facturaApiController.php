<?php

#TODO VA A SER UNA API

namespace App\Controllers;

require_once 'vendor/autoload.php';

use App\Models\AdminModel;
use App\Models\IquatroModel;

use App\Models\CuestionariosModel;
use App\Models\CursosModel;


use TCPDF;
use Smalot\PdfParser\Parser;


class facturaApiController extends BaseController
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
        $db = db_connect('iquatro');
        $this->AdminModel = new AdminModel();
        $this->IquatroModel = new IquatroModel($db);
        $this->CuestionariosModel = new CuestionariosModel();
        $this->CursosModel = new CursosModel();
        $this->db_serv_cuest = \Config\Database::connect('cuestionarios');
        $this->db_cursos = \Config\Database::connect('cursos');
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

    public function cfdi40lista()
    {
        return view('admin/headers/index')
            . view('admin/factura/cfdi40/lista')
            . view('admin/footers/index');
    }

    public function getListadoCFDI40()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi.'/v4/cfdi40/list',
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
        echo $response;
    }

    public function getProductos()
    {
        $curl = curl_init();

        $keys = $_POST['keys'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi.'/v3/products/list',
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
                'F-Api-Key: ' . $keys['key'],
                'F-Secret-Key: ' . $keys['private_key']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getImpuestos(){
        $curl = curl_init();
        $keys = $_POST['keys'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi.'/v3/catalogo/Impuesto',
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
                'F-Api-Key: ' . $keys['key'],
                'F-Secret-Key: ' . $keys['private_key']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getUsosCFDI(){
        $curl = curl_init();
        $keys = $_POST['keys'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi.'/v3/catalogo/UsoCfdi',
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
                'F-Api-Key: ' . $keys['key'],
                'F-Secret-Key: ' . $keys['private_key']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getSeries(){
        $curl = curl_init();
        $keys = $_POST['keys'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi.'/v4/series',
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
                'F-Api-Key: ' . $keys['key'],
                'F-Secret-Key: ' . $keys['private_key']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getFormaPago(){
        $curl = curl_init();
        $keys = $_POST['keys'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi.'/v3/catalogo/FormaPago',  #tiene la v3, hay que ver cuando cambie a v4
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
                'F-Api-Key: ' . $keys['key'],
                'F-Secret-Key: ' . $keys['private_key']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getMetodoPago(){
        $curl = curl_init();
        $keys = $_POST['keys'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi.'/v3/catalogo/MetodoPago',  #tiene la v3, hay que ver cuando cambie a v4
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
                'F-Api-Key: ' . $keys['key'],
                'F-Secret-Key: ' . $keys['private_key']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getMoneda(){
        $curl = curl_init();
        $keys = $_POST['keys'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi.'/v3/catalogo/Moneda',  #tiene la v3, hay que ver cuando cambie a v4
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
                'F-Api-Key: ' . $keys['key'],
                'F-Secret-Key: ' . $keys['private_key']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getPaises(){
        $curl = curl_init();
        $keys = $_POST['keys'];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->rutaApi.'/v3/catalogo/Pais',  #tiene la v3, hay que ver cuando cambie a v4
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
                'F-Api-Key: ' . $keys['key'],
                'F-Secret-Key: ' . $keys['private_key']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getUID(){

        $rfc = $_POST['rfc'];
        $keys = $_POST['keys'];

        //$rfc = 'XEXX010101000';
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->rutaApi.'/v1/clients/rfc/'.$rfc,
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
            'F-Api-Key: ' . $keys['key'],
            'F-Secret-Key: ' . $keys['private_key']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function generateClient(){

        $obj = json_encode($_POST);
        $keys = $_POST['keys'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->rutaApi.'/v1/clients/create',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $obj,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'F-PLUGIN: 9d4095c8f7ed5785cb14c0e3b033eeb8252416ed',
            'F-Api-Key: ' . $keys['key'],
            'F-Secret-Key: ' . $keys['private_key']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function emitirFactura(){

        $obj = json_encode($_POST['formFactura']);
        $keys = $_POST['keys'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->rutaApi.'/v4/cfdi40/create',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $obj,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'F-PLUGIN: 9d4095c8f7ed5785cb14c0e3b033eeb8252416ed',
            'F-Api-Key: ' . $keys['key'],
            'F-Secret-Key: ' . $keys['private_key']
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function verificarCSF(){

        $csf = $_POST['csf'];

        // Get the path to the file.
        $path = WRITEPATH . '/uploads/csf/'.$csf;

        $explode = explode('.', $path);

        if($explode[1] != 'pdf'){
            return json_encode(false);
            exit;
        }
        return json_encode(true);
    }

    public function getArchivos(){

        $uuid = $_POST['uuid'];
        $keys = $_POST['keys'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->rutaApi.'/v4/cfdi40/'.$uuid.'/pdf',
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
            'F-Api-Key: ' . $keys['key'],
            'F-Secret-Key: ' . $keys['private_key']
        ),
        ));

        $responsePDF = curl_exec($curl);

        curl_close($curl);

        //XML

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->rutaApi.'api/v4/cfdi40/'.$uuid.'/xml',
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
            'F-Api-Key: ' . $keys['key'],
            'F-Secret-Key: ' . $keys['private_key']
        ),
        ));

        $responseXML = curl_exec($curl);

        curl_close($curl);

        $zipFile = new \PhpZip\ZipFile();

        $ruta = 'public/zip/factura/';
        $ruta_completo = ROOTPATH . $ruta . $uuid.'.zip';
        $zipFile->addFromString($uuid.'.pdf',$responsePDF);
        $zipFile->addFromString($uuid.'.xml',$responseXML);

        $zipFile->saveAsFile($ruta_completo);

        echo $uuid.'.zip';
    }

    public function getEmpresas(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->rutaApi.'/v1/accounts',
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
        echo $response;
    }
    

}
