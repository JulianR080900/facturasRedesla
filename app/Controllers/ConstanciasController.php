<?php

#TODO VA A SER UNA API

namespace App\Controllers;

require_once 'vendor/autoload.php';

use App\Models\AdminModel;
use App\Models\IquatroModel;
use TCPDF;

class CustomTCPDF extends TCPDF{

    public $path_name;
    public $w;
    public $h;
    function __construct($valores_pdf) {
        // Llama al constructor de la clase base (TCPDF).
        parent::__construct();

        // Ahora puedes hacer algo con los parámetros pasados.
        // Por ejemplo, asignarlos a propiedades de la clase.
        $this->path_name = $valores_pdf['path'];
        $this->w = $valores_pdf['w'];
        $this->h = $valores_pdf['h']; 
    }

    public function Header(){
        $this->SetAutoPageBreak(false, 0);
        $path = $this->path_name;
        $h = $this->h;
        $w = $this->w;
        $this->Image($path, 0, 0, $w, $h, '', '', '', false, 300, '', false, false, 0);
    }
}

class ConstanciasController extends LoginController
{
    public $AdminModel;
    public $IquatroModel;
    public $arr_constancias;
    public $db_serv;
    public $urlVerificarConstancias;

    public function __construct()
    {
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $db = db_connect('iquatro');
        $this->AdminModel = new AdminModel();
        $this->IquatroModel = new IquatroModel($db);
        $this->db_serv = \Config\Database::connect('cuestionarios');
        $this->urlVerificarConstancias = 'https://redesla.la/redesla/constancias';
        $this->arr_constancias = [
            'Miembro_investigador' => 'MI',
            'Asistencia' => 'PA',
            'Ponente' => 'PO',
            'Coloquio' => 'CQ',
            'Miembro_asociado' => 'MA',
            'Moderador' => 'MO',
            'Dictaminador' => 'DIC',
            'Distinción dictaminador' => 'DISTDIC',
            'Encuestador' => 'CE',
            'Curso SNI' => 'CTSNI',
            'Curso metodología' => 'CTMI',
            'Curso estadistica' => 'CTEST',
            'Reconocimiento_IQ4' => 'RIQ'
        ];
    }

    public function verConstancia($tipo,$anio,$submission_id = 0){
        if(!session('red') || session('red') == ''){
            return redirect()->to(base_url());
            exit;
        }

        $red = session('red');

        /* Hacemmos condiciones para algunas cuestiones COMO ALGUNOS TIPOS DE CONSTANCIAS */

        $tabla_red = '';

        if($tipo == 'Moderador'){
            $tabla_red = 'constancia_moderadores';
        }else{
            $tabla_red = 'constancia_' . $red;
        }

        /* VERIFICAMOS QUE LA CONSTANCIA SEA DEL USUARIO */

        if($submission_id != 0){
            $condiciones = ['usuario' => session('usuario'), 'tipo_constancia' => $tipo, 'anio' => $anio, 'submission_id' => $submission_id];
        }else{
            $condiciones = ['usuario' => session('usuario'), 'tipo_constancia' => $tipo, 'anio' => $anio];
        }

        

        #ERROR 100
        if (!$this->AdminModel->exist($tabla_red, $condiciones)) {
            /* La constancia no existe */
            return redirect()->to(base_url('/perfil'))
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intente mas tarde. Error 100.');
        }


        $info_constancia = $this->AdminModel->getAllOneRow($tabla_red, $condiciones);

        /* VAMOS A VERIFICAR SI EXISTE EL ARCHIVO PARA HACER LA CONSTANCIA CON EL PDF */
        $nombre_constancia = $tipo . '_' . $red . '_' . $anio;

        //VAMOS A ESTABLECER CASOS ESPECIALES PARA EL NOMBRE DE PATH_NAME
        if($red == 'Releg' && $anio == 2023 && $tipo == 'Asistencia'){
            $path_name = "resources/img/constancias/{$red}/{$anio}/Asistencia/" . $info_constancia['folio_completo'].'.jpg';
        }else{
            $path_name = "resources/img/constancias/{$red}/{$anio}/{$tipo}.jpg";
        }
        //http://localhost/redeslaci/ver/constancia/Asistencia/2023

        #ERROR NO EXISTE IMAGEN
        if (!file_exists($path_name)) {
            /* El archivo para generar la constancia aun no esta subido. Lo mas optimo es que me manden un msj para saber que tengo que subir que constancia. */
            return redirect()->to(base_url('/perfil'))
                ->with('icon', 'info')
                ->with('title', 'Trabajando... 👷🏻‍♀️')
                ->with('text', 'La constancia esta bajo mantenimiento. Se estará habilitando lo más pronto posible.');
        }


        $nombre_constancia = $info_constancia['nombre'];

        #ERROR 101
        if( !isset($this->arr_constancias[$info_constancia['tipo_constancia']]) ){
            return redirect()->to(base_url('/perfil'))
                ->with('icon', 'error')
                ->with('title', 'Lo sentimos')
                ->with('text', 'Ha ocurrido un error, intente mas tarde. Error 101.');
        }

        $tipo_constancia = $this->arr_constancias[$info_constancia['tipo_constancia']];

        if(empty($info_constancia['folio_completo'])){
            //El folio completo no esta registrado, vamos a hacerle update

            $formato_folio = $info_constancia['folio'].$tipo_constancia.'-'.ucfirst($red).'-'.$info_constancia['anio'];

            $data = ['folio_completo' => $formato_folio];
            $condiciones = ['id' => $info_constancia['id']];
            $this->AdminModel->generalUpdate('constancia_'.$red,$data,$condiciones);

            $condiciones = ['usuario' => session('usuario'), 'tipo_constancia' => $tipo, 'anio' => $anio];
            $info_constancia = $this->AdminModel->getAllOneRow('constancia_' . $red, $condiciones);
        }

        //VAMOS A TRAERNOS EL LINK DE LA RED
        $condiciones = ['nombre_red' => ucfirst($red)];
        $columnas = ['website'];
        $info_red = $this->AdminModel->getColumnsOneRow($columnas,'redes',$condiciones);
        $website = $info_red['website'];

        /* Empezamos la generacion del archivo, la razon por la cual lo establecemos apesar de ser el mismo tipo es poder perzonalizar los datos en caso de */

        $arr_condiciones_constancias = [
            'Relayn' => [
                '2019' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2019', #Nombre de la funcion
                    ],
                ],
                '2020' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2020', #Nombre de la funcion
                    ],
                ],
                '2021' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 255, 'h' => 420, 'type' => 'P'
                        ],
                        'funcion' => 'MI2021', #Nombre de la funcion
                    ],
                ],
                '2022' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2022', #Nombre de la funcion
                    ],
                    'PA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 255, 'h' => 330, 'type' => 'L'
                        ],
                        'funcion' => 'PA2022', #Nombre de la funcion
                    ],
                    'MA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MA2022', #Nombre de la funcion
                    ],
                    'PO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'PO2022', #Nombre de la funcion
                    ],
                    'MO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MO2022', #Nombre de la funcion
                    ],
                    'RIQ' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'RIQ2022', #Nombre de la funcion
                    ]
                ],
                '2023' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2023', #Nombre de la funcion
                    ],
                    'PO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'PO2023_Relayn', #Nombre de la funcion
                    ],
                    'CQ' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'CQ2023', #Nombre de la funcion
                    ],
                    'PA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 255, 'h' => 330, 'type' => 'L'
                        ],
                        'funcion' => 'PA2023', #Nombre de la funcion
                    ],
                    'RIQ' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'RIQ2023', #Nombre de la funcion
                    ],
                    'MO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MO2023', #Nombre de la funcion
                    ],
                    'MA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MA2023Relayn', #Nombre de la funcion
                    ],
                ]
            ],
            'Relep' => [
                '2019' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2019_Relep', #Nombre de la funcion
                    ],
                ],
                '2020' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2020_Relep', #Nombre de la funcion
                    ],
                ],
                '2021_2022' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2022',
                    ]
                ],
                '2022' => [
                    'PA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 255, 'h' => 330, 'type' => 'L'
                        ],
                        'funcion' => 'PA2022_porcentaje', #Nombre de la funcion
                    ],
                    'MA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MA2022', #Nombre de la funcion
                    ],
                    'PO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'PO2022', #Nombre de la funcion
                    ],
                    'MO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MO2022', #Nombre de la funcion
                    ],
                    'RIQ' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'RIQ2022', #Nombre de la funcion
                    ]
                ],
                '2023' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2023', #Nombre de la funcion
                    ],
                    'RIQ' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'RIQ2023', #Nombre de la funcion
                    ],
                    'CQ' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'CQ2023', #Nombre de la funcion
                    ],
                    'PO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'PO2023_Relayn', #Nombre de la funcion
                    ],
                    'MO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MO2023', #Nombre de la funcion
                    ],
                ]
            ],
            'Relen' => [
                '2021_2022' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2022',
                    ]
                ],
                '2022' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2022',
                    ],
                    'PA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 255, 'h' => 330, 'type' => 'L'
                        ],
                        'funcion' => 'PA2022_porcentaje', #Nombre de la funcion
                    ],
                    'MA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MA2022', #Nombre de la funcion
                    ],
                    'PO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'PO2022', #Nombre de la funcion
                    ],
                    'MO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MO2022', #Nombre de la funcion
                    ],
                    'RIQ' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'RIQ2022', #Nombre de la funcion
                    ]
                ],
                '2023' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2023', #Nombre de la funcion
                    ],
                    'RIQ' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'RIQ2023', #Nombre de la funcion
                    ],
                    'PO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'PO2023_Relayn', #Nombre de la funcion
                    ],
                    'MO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MO2023', #Nombre de la funcion
                    ],
                ]
            ],
            'Releg' => [
                '2022' => [
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2023', #Esta investogacion inicio en 2022 y termino en 2023, se toma el formato 2023 como constancia
                    ]
                ],
                '2023' => [
                    'PA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'PA2023_Releg', #Nombre de la funcion
                    ],
                    'MA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MA2023', #Nombre de la funcion
                    ],
                    'PO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'PO2023', #Nombre de la funcion
                    ],
                    'MO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MO2023', #Nombre de la funcion
                    ],
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2023', #Nombre de la funcion
                    ],
                    'RIQ' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'RIQ2023', #Nombre de la funcion
                    ]
                ],
            ],
            'Releem' => [
                '2022' => [
                    'MA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'L'
                        ],
                        'funcion' => 'MA2022_Releem', #Nombre de la funcion
                    ],
                    'PA' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 255, 'h' => 330, 'type' => 'L'
                        ],
                        'funcion' => 'PA2022', #Nombre de la funcion
                    ],
                    'MI' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 220, 'h' => 170, 'type' => 'P'
                        ],
                        'funcion' => 'MI2022', #Nombre de la funcion
                    ],
                    'PO' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'PO2022', #Nombre de la funcion
                    ],
                ]
            ]
        ];

        #ERROR 102
        if( !isset($arr_condiciones_constancias[ucfirst($red)][$info_constancia['anio']][$tipo_constancia]['valores'])){
            return redirect()->to(base_url('/perfil'))
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error, intente mas tarde. Error 102.');
        }

        $valores_pdf = $arr_condiciones_constancias[ucfirst($red)][$info_constancia['anio']][$tipo_constancia]['valores'];
        $function_pdf = $arr_condiciones_constancias[ucfirst($red)][$info_constancia['anio']][$tipo_constancia]['funcion'];

        //Ocupamos saber si es una constancia de ponente si es hay que establecer el valor, si no esta lo mandamos pero vacio
        $nombre_ponencia = '';
        $porcentaje = '';
        $lugar = '';

        if($info_constancia['tipo_constancia'] == 'Ponente' || $info_constancia['tipo_constancia'] == 'Reconocimiento_IQ4' || $info_constancia['tipo_constancia'] == 'Coloquio'){
            //Si es de ponencia hay que sacar el nombre de la ponencia
            $condiciones = [
                'submission_id' => $info_constancia['submission_id']
            ];
            $columnas = ['nombre'];

            $ponencia = $this->AdminModel->getColumnsOneRow($columnas, 'ponencias', $condiciones);

            //ERROR 103
            if (empty($ponencia)) {
                return redirect()->to(base_url('/perfil'))
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Ha ocurrido un error, intente mas tarde. Error 103.' . $info_constancia['submission_id']);
            }

            $nombre_ponencia = $ponencia['nombre'];
        }

        if(isset($info_constancia['porcentaje'])){
            $porcentaje = $info_constancia['porcentaje'];
        }

        if(isset($info_constancia['lugar'])){
            switch($info_constancia['lugar']){
                case 1:
                    $lugar = 'primer';
                    break;
                case 2:
                    $lugar = 'segundo';
                    break;
                case 3:
                    $lugar = 'tercer';
                    break;
                default:
                    return redirect()->back();
                    break;
            }
        }        

        $pdf = new CustomTCPDF($valores_pdf); #Esto debemos de ponerlo dependiendo el caso
        $data_pdf = [
            'pdf' => $pdf,
            'nombre_constancia' => $nombre_constancia,
            'folio_completo' => $info_constancia['folio_completo'],
            'website' => $website,
            'porcentaje' => $porcentaje,
            'nombre_ponencia' => $nombre_ponencia,
            'lugar' => $lugar
        ];
        $pdf->AddPage($valores_pdf['type']);
        $pdf->SetPrintHeader(true);
        $pdf->SetPrintFooter(false);
        $pdf->SetAuthor('REDESLA');
        $pdf->SetCreator('REDESLA');
        $pdf->SetTitle("Constancia REDESLA");
        $this->$function_pdf($data_pdf);
        $this->response->setContentType('application/pdf');
        $pdf->Output("Constancia.pdf", 'I');
    }

    public function constancias(){
        return view('external/librerias/index') 
        .view('external/formularios/constancias')
        .view('external/footer/index');
    }

    public function verificar(){

        #EN ESTE APARTADO SE VERIFICA EL FOLIO DE LAS CONSTANCIAS
        #HAY DISTINTOS TIPOS DE CONSTANCIAS
        # LOS DE LA RED, LA PLATAFORMA (INICIAN CON UN ID SEGUIDO DEL TIPO) EJ. 0041MI-
        # LOS DE CURSOS QUE HACE LA EMPRESA (PENDIENTE)
        # LOS DE DICTAMINADOR (EMPIEZAN CON LA ABREVIACION DIC) EJ. DIC-RELAYN-JA-2022
        #TODAS ELLAS TIENEN DIFERENTE ESTRUCTURA, LO MEJOR ES QUE
        #HAGAS DIFERENTES ESTRUCTURAS PARA SABER A DONDE IR CON EL PRIMER
        #PORCION DEL FOLIO

        $folioCompleto = $_POST["folio"];
        #$folioCompleto = 'dbfisdbkjf';

        $cadena = $folioCompleto;
        $caracter = "-";

        $array_caracteres = str_split($cadena);

        if (!in_array($caracter, $array_caracteres)) {
            return redirect()->to(base_url('/constancias'))
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text','El folio proporcionado no existe. Error 100.');
        }


        $folio = explode("-", $folioCompleto);
        $abreviatura_folio_user = preg_replace('/[0-9]+/', '', $folio[0]);

        if (!in_array($abreviatura_folio_user, array_values($this->arr_constancias))) {
            //Vamos a pasar por un segundo filtro por constancias que no siguen el formato, por x o y razón

            if(empty($abreviatura_folio_user)){
                $abreviatura_folio_user = strpos($folioCompleto,'CTSNI') === false ? '' :  'CTSNI';
            }
            if(empty($abreviatura_folio_user)){
                $abreviatura_folio_user = strpos($folioCompleto,'CTMI') === false ? '' :  'CTMI';
            }
            if(empty($abreviatura_folio_user)){
                $abreviatura_folio_user = strpos($folioCompleto,'CTEST') === false ? '' :  'CTEST';
            }
        }

        if(empty($abreviatura_folio_user)){
            return redirect()->to(base_url('/constancias'))
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text',"Ha ocurrido un error. Código de error: 101.");
        }


        if($abreviatura_folio_user == 'DIC'){

            #CONSTANCIA DE DICTAMINADOR

            $condiciones = ['folio_completo' => $folioCompleto];

            if($this->AdminModel->exist('constancia_dictaminador',$condiciones)){

                #OBTENEMOS LA INFORMACION DEL REGISTRO

                $constancia = $this->AdminModel->getAllOneRow('constancia_dictaminador',$condiciones);

                #OBTENEMOS LA CANTIDAD DE PONENCIAS QUE SE TIENEN

                $explode = explode(',',$constancia['ids_dictaminador']);

                $cantidad_ponencias = count($explode)-1;

                #OBTENEMOS LAS REDES QUE PARTICIPARON

                $nombre_redes = [];

                foreach($explode as $e){

                    $columnas = [];

                    array_push($columnas,'area_revision');

                    $condiciones = ['id' => $e];

                    $valor = $this->AdminModel->getColumnsOneRow($columnas,'dictaminador2021',$condiciones);

                    //$valor[arearevision] tiene REDESLA
                    //esto lo cambia a Redesla

                    $valorRed = ucfirst(strtolower($valor['area_revision']));

                    if(!empty($e)){

                        if(!in_array($valorRed, $nombre_redes)){
                            
                            array_push($nombre_redes,$valorRed);
    
                        }

                    }

                }

                $explode_fecha = explode(' ',$constancia['fecha_insert']);

                $data['info'] = $constancia;
                $data['info']['red'] = $nombre_redes;
                $data['info']['tipo_constancia'] = 'Dictaminador';
                $data['info']['folio'] = $folioCompleto;
                $data['info']['c_ponencias'] = $cantidad_ponencias;
                $data['info']['fecha_insert'] = $explode_fecha[0];

                echo '<pre>';
                //print_r($data);
                echo '</pre>';
                return view('external/librerias/index') 
                .view('external/constancias/info',$data)
                .view('external/footer/index');
            }else{
                return redirect()->to(base_url('/constancias'))
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','El folio proporcionado no existe.');
            }

        }else if($abreviatura_folio_user == 'DISTDIC'){

            #DISTINCION DICTAMINADOR

            $condiciones = ['folio_completo' => $folioCompleto];

            if($this->AdminModel->exist('constancia_distincionDictaminador',$condiciones)){

                #OBTENEMOS LA INFORMACION DEL REGISTRO

                $constancia = $this->AdminModel->getAllOneRow('constancia_distincionDictaminador',$condiciones);

                $explode_fecha = explode(' ',$constancia['fecha_insert']);

                $data['info'] = $constancia;
                $data['info']['tipo_constancia'] = 'Distincion Dictaminador';
                $data['info']['folio'] = $folioCompleto;
                $data['info']['fecha_insert'] = $explode_fecha[0];

                echo '<pre>';
                //print_r($data);
                echo '</pre>';
                return view('external/librerias/index') 
                .view('external/constancias/info',$data)
                .view('external/footer/index');

            }else{
                return redirect()->to(base_url('/constancias'))
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','El folio proporcionado no existe.');
            }
            
        }else if($abreviatura_folio_user == 'CE'){

            #CONSTANCIA DE ENCUESTADOR

            #LA UNICA VALIDACION ES EL FOLIO NTP

            $condicion = ['folio_completo' => $folioCompleto];

            $constancia = $this->AdminModel->getAllOneRow("constancia_encuestador",$condicion);

            #SI ESTA VACIA, NO EXISTE O NO HA PASADO EL PROCESO DE LA VISUALIZACION

            if(empty($constancia)){

                return redirect()->to(base_url('/constancias'))
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','El folio proporcionado no existe.');

            }

            $data['info'] = [

                'nombre' => $constancia["nombre"],

                'tipo_constancia' => 'Encuestador',

                'red' => $constancia["red"],

                'folio' => $folioCompleto,

                'anio_colaboracion' => $constancia['anio']

            ];

            return view('external/librerias/index') 
            .view('external/constancias/info',$data)
            .view('external/footer/index');

        }else if($abreviatura_folio_user == 'MO'){
            #CONSTANCIA DE MODERADOR

            #LA UNICA VALIDACION ES EL FOLIO NTP

            $condicion = ['folio_completo' => $folioCompleto];

            $constancia = $this->AdminModel->getAllOneRow("constancia_moderadores",$condicion);

            #SI ESTA VACIA, NO EXISTE O NO HA PASADO EL PROCESO DE LA VISUALIZACION

            if(empty($constancia)){

                return redirect()->to(base_url('/constancias'))
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','El folio proporcionado no existe.');

            }

            $data['info'] = [

                'nombre' => $constancia["nombre"],

                'tipo_constancia' => 'Moderador',

                'red' => $constancia["red"],

                'folio' => $folioCompleto,

                'anio_colaboracion' => $constancia['anio']

            ];

            return view('external/librerias/index') 
            .view('external/constancias/info',$data)
            .view('external/footer/index');
            
        }else if($abreviatura_folio_user == 'CTSNI'){
            #CONSTANCIAS DEL CURSO Curso-taller en línea "¿Cómo presentar adecuadamente la solicitud de ingreso, 
            #permanencia o promoción al Sistema Nacional de Investigadores (SNI)?"
           
            $condiciones = ['folio' => $folioCompleto];

            if( $this->AdminModel->exist('constancia_sni',$condiciones)){

                #EL USUARIO EXISTE, VAMOS A EXTRAER LA INFORMACION

                $registro = $this->AdminModel->getAllOneRow('constancia_sni',$condiciones);

                $data['info']['curso'] = 'Curso-taller en línea "¿Cómo presentar adecuadamente la solicitud de ingreso, permanencia o promoción al Sistema Nacional de Investigadores (SNI)?"';

                $data['info']['nombre'] = $registro['nombre'];

                $guion = explode('-',$folioCompleto);

                $data['info']['anio'] = $guion[2];

                $edicion = str_replace('CTSNI','',$guion[1]);

                $data['info']['edicion'] = $edicion;

                $data['info']['tipo_constancia'] = 'Acreditación del curso';

                $data['info']['folio'] = $folioCompleto;

                return view('external/librerias/index') 
                .view('external/constancias/info',$data)
                .view('external/footer/index');

            }else{
                return redirect()->to(base_url('/constancias'))
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','El folio proporcionado no existe.');
            }

        }else if($abreviatura_folio_user == 'CTMI'){
            #CONSTANCIAS DEL CURSO Curso-taller en línea "¿Cómo presentar adecuadamente la solicitud de ingreso, 
            #permanencia o promoción al Sistema Nacional de Investigadores (SNI)?"
           
            $condiciones = ['folio' => $folioCompleto];

            if( $this->AdminModel->exist('constancia_metodologia',$condiciones)){

                #EL USUARIO EXISTE, VAMOS A EXTRAER LA INFORMACION

                $registro = $this->AdminModel->getAllOneRow('constancia_metodologia',$condiciones);

                $data['info']['curso'] = 'Curso-taller en línea "Metodología de la investigación: de como desarrollar artículos científicos válidos"';

                $data['info']['nombre'] = $registro['nombre'];

                $guion = explode('-',$folioCompleto);

                $data['info']['anio'] = $guion[2];

                $edicion = str_replace('CTMI','',$guion[1]);

                $data['info']['edicion'] = $edicion;

                $data['info']['tipo_constancia'] = 'Acreditación del curso';

                $data['info']['folio'] = $folioCompleto;

                return view('external/librerias/index') 
                .view('external/constancias/info',$data)
                .view('external/footer/index');

            }else{

                return redirect()->to(base_url('/constancias'))
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','El folio proporcionado no existe.');

            }

        }else if($abreviatura_folio_user == 'CTEST'){
            #CONSTANCIAS DEL CURSO Curso-taller en línea "¿Cómo presentar adecuadamente la solicitud de ingreso, 
            #permanencia o promoción al Sistema Nacional de Investigadores (SNI)?"
           
            $condiciones = ['folio' => $folioCompleto];

            if($this->AdminModel->exist('constancia_estadistica',$condiciones)){

                #EL USUARIO EXISTE, VAMOS A EXTRAER LA INFORMACION

                $registro = $this->AdminModel->getAllOneRow('constancia_estadistica',$condiciones);

                $data['info']['curso'] = 'Curso-taller en línea "Estadística para investigación científica"';

                $data['info']['nombre'] = $registro['nombre'];

                $guion = explode('-',$folioCompleto);

                $data['info']['anio'] = $guion[2];

                $edicion = str_replace('CTEST','',$guion[1]);

                $data['info']['edicion'] = $edicion;

                $data['info']['tipo_constancia'] = 'Acreditación del curso';

                $data['info']['folio'] = $folioCompleto;

                return view('external/librerias/index') 
                .view('external/constancias/info',$data)
                .view('external/footer/index');

            }else{

                return redirect()->to(base_url('/constancias'))
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','El folio proporcionado no existe.');
            }

        }else{


            
            #ESTAS PUEDEN SER CONSTANCIAS DE LA RED O DE ENCUESTADOR

            $red =  $folio[1];

            $condiciones = [];

            $columnas = ['nombre_red'];

            $redes = $this->AdminModel->getAllColums($columnas,'redes',$condiciones);

            $tipo = preg_replace('/[0-9]+/', '', $folio[0]);

            if(!empty($redes)){

                #LA RED EXISTE EN LA BD, PODEMOS CONTINUAR EVITANDO EL ERROR DE NO ENCONTRAR LA TABLA EN LA BD

                $condiciones = array("folio_completo" => $folioCompleto);

                $constancia = $this->AdminModel->getAllOneRow("constancia_".$red,$condiciones);

                #SI ESTA VACIA SIGNIFICA QUE NO EXISTE

                if(empty($constancia)){

                    return redirect()->to(base_url('/constancias'))
                    ->with('icon','error')
                    ->with('title','Lo sentimos')
                    ->with('text','El folio proporcionado no existe.');
                }

                #VERIFICAMOS EL TIPO DE CONSTANCIA QUE ES CON SU ABREVIATURA, PUEDES HACERLO
                #SUSTITUYENDO EL _ CON ESPACIO CON STR_REPLACE PERO PUES CREO ES MEJOR

                $tipo_constancia = str_replace('_',' ',$constancia['tipo_constancia']);

                $condicion = ['claveCuerpo' => $constancia["redCueAca"]];

                $uni = $this->AdminModel->getAllOneRow("cuerpos_academicos",$condicion);

                $data['info'] = [

                    'nombre' => $constancia["nombre"],

                    'tipo_constancia' => $tipo_constancia,

                    'cuerpo_academico' => $constancia["redCueAca"],

                    'red' => $constancia["red"],

                    'nombre_uni' => $uni['nombre'],

                    'folio' => $folioCompleto

                ];

                return view('external/librerias/index') 
                .view('external/constancias/info',$data)
                .view('external/footer/index');

            }else{

                return redirect()->to(base_url('/constancias'))
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','El folio proporcionado no existe.');

            }
        }

    }

    public function encuestadores(){
        return view('external/librerias/index') 
        .view('external/formularios/encuestador')
        .view('external/footer/index');
    }

    public function verificar_encuestador(){

        if(isset($_POST['correo'])){

            $condiciones = ["correo" => $_POST['correo']];

            $constancias = $this->AdminModel->getAll("constancia_encuestador",$condiciones);

            //Puede tener diversas constancias

            if(empty($constancias)){
                return redirect()->back()
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','No hay constancias adjuntas al correo proporcionado. Código de error: 101');
            }

            //existe el correo, pero hubo un problema al verificar a quien se le insertaba la constancia, entonces vamos a verificar mas informacion para ver si aplica para ella o se la revocamos
            $acredita = $this->verificarConstanciaEncuestador($constancias);

            if(empty($acredita)){
                return redirect()->back()
                ->with('icon','info')
                ->with('title','Lo sentimos')
                ->with('text','Su correo no cuenta con la cantidad mínima de encuestas efectuadas. Código de error: 102');
            }

            $data = [];

            $data['info'] = $constancias;

            return view('external/librerias/index') 
            .view('external/constancias/infoEncuestador',$data)
            .view('external/footer/index');

        }else{

            //ENTRO DIRECTO, MANDALO A LA VISTA ANTERIOR

            return redirect()->back()
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text','Llene los campos correctamente');

        }

    }

    private function verificarConstanciaEncuestador($data){
        $c_minima = 3; #modificarla a 3
        foreach($data as $key=>$d){
            $red = strtolower($d['red']);
            $anio = $d['anio'];
            if($anio == '2021_2022' || $anio == 2022){
                continue;
            }
            $tabla = "cuestionarios_{$red}_{$anio}";
            $correo = $d['correo'];
            if($anio <= 2023){
                //db_serv
                $sql = "SELECT count(id) as total FROM `{$tabla}` where correo_encuestador = '{$correo}' AND estado = 1";
                $total_count = $this->db_serv->query($sql)->getRow();
                if($total_count->total < $c_minima){
                    unset($data[$key]);
                }
            }
        }
        
        return $data;
    }

    public function descargar_encuestador(){

        if(!isset($_POST['correo'])){
            return redirect()->to(base_url('/encuestadores'))
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text','Ha ocurrido un error, intentelo mas tarde');
        }
        $correo = $_POST['correo'];
        $anio = $_POST['anio'];
        $red = $_POST['red'];
        $tipo = 'CE';

        #VERIFICAMOS SI EXISTE UNA CONSTANCIA DE ENCUESTADOR CON EL CORREO ELECTRONICO

        $condiciones = ['red' => $red, 'anio' => $anio, 'correo' => $correo];

        $constancia = $this->AdminModel->getAllOneRow('constancia_encuestador',$condiciones);

        if(empty($constancia)){
            return redirect()->to(base_url('/encuestadores'))
            ->with('icon','error')
            ->with('title','Lo sentimos')
            ->with('text','La constancia que solicita no esta adjuntada al correo proporcionada');
        }

        $path_name = "resources/img/constancias/{$red}/{$anio}/Encuestador.jpg";

        #ERROR NO EXISTE IMAGEN
        if (!file_exists($path_name)) {
            /* El archivo para generar la constancia aun no esta subido. Lo mas optimo es que me manden un msj para saber que tengo que subir que constancia. */
            return redirect()->to(base_url('/perfil'))
                ->with('icon', 'info')
                ->with('title', 'Trabajando... 👷🏻‍♀️')
                ->with('text', 'La constancia esta bajo mantenimiento. Se estará habilitando lo más pronto posible.');
        }

        $arr_condiciones_constancias = [
            'Relayn' => [
                '2022' => [
                    'CE' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'CE2022', #Nombre de la funcion
                    ]
                ],
                '2023' => [
                    'CE' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'CE2023', #Nombre de la funcion
                    ]
                ]
            ],
            'Relep' => [          
                '2021_2022' => [
                    'CE' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'CE2022', #Nombre de la funcion
                    ]
                ],
                '2023' => [
                    'CE' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'CE2023', #Nombre de la funcion
                    ]
                ]
            ],
            'Relen' => [
                '2022' => [
                    'CE' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'CE2022', #Nombre de la funcion
                    ]
                ],
                '2023' => [
                    'CE' => [
                        'valores' => [
                            'path' => $path_name, 'w' => 330, 'h' => 255, 'type' => 'L'
                        ],
                        'funcion' => 'CE2023', #Nombre de la funcion
                    ]
                ]
            ],
        ];

        #ERROR 102
        if( !isset($arr_condiciones_constancias[ucfirst($red)][$anio][$tipo]['valores'])){
            return redirect()->back()
            ->with('icon', 'error')
            ->with('title', 'Lo sentimos')
            ->with('text', 'Ha ocurrido un error, intente mas tarde. Error 102.');
        }

        $valores_pdf = $arr_condiciones_constancias[ucfirst($red)][$anio][$tipo]['valores'];
        $function_pdf = $arr_condiciones_constancias[ucfirst($red)][$anio][$tipo]['funcion'];

        $formato_completo = $constancia['folio_completo'];

        if(empty($constancia['folio_completo'])){
            $formato_folio = $constancia['id']."CE-".strtoupper($constancia['red'])."-".$constancia['anio'];
            $condiciones = ["id" => $constancia['id']];
            $data = ["folio_completo" => $formato_folio];
            $this->AdminModel->generalUpdate("constancia_encuestador",$data,$condiciones);
            $formato_completo = $formato_folio;
        }

        //VAMOS A TRAERNOS DATOS DE LA WEB
        //VAMOS A TRAERNOS EL LINK DE LA RED
        $condiciones = ['nombre_red' => ucfirst($red)];
        $columnas = ['website'];
        $info_red = $this->AdminModel->getColumnsOneRow($columnas,'redes',$condiciones);
        $website = $info_red['website'];

        $pdf = new CustomTCPDF($valores_pdf); #Esto debemos de ponerlo dependiendo el caso
        $data_pdf = [
            'pdf' => $pdf,
            'nombre_constancia' => $constancia["nombre"],
            'folio_completo' => $formato_completo,
            'website' => $website,
        ];
        $pdf->AddPage($valores_pdf['type']);
        $pdf->SetPrintHeader(true);
        $pdf->SetPrintFooter(false);
        $pdf->SetAuthor('REDESLA');
        $pdf->SetCreator('REDESLA');
        $pdf->SetTitle("Constancia REDESLA");
        $this->$function_pdf($data_pdf);
        $this->response->setContentType('application/pdf');
        $pdf->Output("Constancia.pdf", 'I');
    }

    #======================= FUNCIONES PARA CADA CONSTANCIA ===================================

    private function MI2022($data){
        $pdf = $data['pdf'];
         #================NOMBRE====================
         $x = 25;  // Posición X
         $y = 78;  // Posición Y
         $width = 165;  // Ancho del área
         $height = 12;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['nombre_constancia']; // Texto a mostrar

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
         $y = 11;  // Posición Y
         $width = 25;  // Ancho del área
         $height = 6;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['folio_completo']; // Texto a mostrar

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

         $x = 55;  // Posición X
         $y = 10;  // Posición Y
         $width = 100;  // Ancho del área
         $height = 30;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $data['website'];
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================
    }

    private function MI2023($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 25;  // Posición X
        $y = 78;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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

        $texto = $data['folio_completo']; // Texto a mostrar

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

        $x = 55;  // Posición X
        $y = 10;  // Posición Y
        $width = 100;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================


        #================HYPERVINCULO====================

        $x = 90;  // Posición X
        $y = 290;  // Posición Y
        $width = 125;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function PA2022($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 40;  // Posición X
        $y = 83;  // Posición Y
        $width = 220;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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

        #================FOLIO====================

        $x = 5;  // Posición X
        $y = 195;  // Posición Y
        $width = 25;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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

       

        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 10;  // Posición Y
        $width = 100;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 200;  // Posición Y
        $width = 170;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function PA2022_porcentaje($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 40;  // Posición X
        $y = 83;  // Posición Y
        $width = 220;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 180;  // Posición X
        $y = 135;  // Posición Y
        $width = 20;  // Ancho del área
        $height = 10;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['porcentaje']; // Texto a mostrar

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

        #================FOLIO====================

        $x = 5;  // Posición X
        $y = 195;  // Posición Y
        $width = 25;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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

       

        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 10;  // Posición Y
        $width = 100;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 200;  // Posición Y
        $width = 170;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function PA2023_Releg($data){
        $pdf = $data['pdf'];

        #================HYPERVINCULO====================

        $x = 250;  // Posición X
        $y = 5;  // Posición Y
        $width = 45;  // Ancho del área
        $height = 20;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 200;  // Posición Y
        $width = 170;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function MA2023($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 25;  // Posición X
        $y = 75;  // Posición Y
        $width = 247;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 253;  // Posición X
        $y = 195;  // Posición Y
        $width = 30;  // Ancho del área
        $height = 7;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 40;  // Posición X
        $y = 9;  // Posición Y
        $width = 75;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================


        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 200;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function MA2023Relayn($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 25;  // Posición X
        $y = 73;  // Posición Y
        $width = 247;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 250;  // Posición X
        $y = 202;  // Posición Y
        $width = 30;  // Ancho del área
        $height = 7;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 13;  // Posición X
        $y = 9;  // Posición Y
        $width = 85;  // Ancho del área
        $height = 35;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================


        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 200;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function MA2022($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 35;  // Posición X
        $y = 71;  // Posición Y
        $width = 230;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 5;  // Posición X
        $y = 195;  // Posición Y
        $width = 30;  // Ancho del área
        $height = 7;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 10;  // Posición X
        $y = 9;  // Posición Y
        $width = 90;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================


        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 200;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function MA2022_Releem($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 35;  // Posición X
        $y = 66;  // Posición Y
        $width = 230;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 262;  // Posición X
        $y = 195;  // Posición Y
        $width = 30;  // Ancho del área
        $height = 7;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 22;  // Posición X
        $y = 11;  // Posición Y
        $width = 90;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================


        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 200;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function PO2022($data){

        $pdf = $data['pdf'];

        #================NOMBRE====================
        $x = 36;  // Posición X
        $y = 65;  // Posición Y
        $width = 228;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 65;  // Posición X
        $y = 90;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 30;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_ponencia']; // Texto a mostrar

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
        $x = 265;  // Posición X
        $y = 203;  // Posición Y
        $width = 25;  // Ancho del área
        $height = 6;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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

        $x = 22;  // Posición X
        $y = 6;  // Posición Y
        $width = 85;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 4;  // Posición X
        $y = 199;  // Posición Y
        $width = 165;  // Ancho del área
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

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function PO2023($data){

        $pdf = $data['pdf'];

        #================NOMBRE====================
        $x = 36;  // Posición X
        $y = 72;  // Posición Y
        $width = 228;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 65;  // Posición X
        $y = 95;  // Posición Y
        $width = 175;  // Ancho del área
        $height = 30;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_ponencia']; // Texto a mostrar

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
        $x = 253;  // Posición X
        $y = 193;  // Posición Y
        $width = 35;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 22;  // Posición X
        $y = 6;  // Posición Y
        $width = 55;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 4;  // Posición X
        $y = 199;  // Posición Y
        $width = 165;  // Ancho del área
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

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function MO2023($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 35;  // Posición X
        $y = 80;  // Posición Y
        $width = 230;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 253;  // Posición X
        $y = 200;  // Posición Y
        $width = 30;  // Ancho del área
        $height = 7;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 30;  // Posición X
        $y = 9;  // Posición Y
        $width = 90;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================


        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 200;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function MO2022($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 35;  // Posición X
        $y = 80;  // Posición Y
        $width = 230;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 8;  // Posición X
        $y = 195;  // Posición Y
        $width = 30;  // Ancho del área
        $height = 7;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 30;  // Posición X
        $y = 9;  // Posición Y
        $width = 90;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================


        #================HYPERVINCULO====================

        $x = 5;  // Posición X
        $y = 200;  // Posición Y
        $width = 165;  // Ancho del área
        $height = 8;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $this->urlVerificarConstancias;
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function MI2019($data){
        $pdf = $data['pdf'];
         #================NOMBRE====================
         $x = 25;  // Posición X
         $y = 100;  // Posición Y
         $width = 165;  // Ancho del área
         $height = 12;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['nombre_constancia']; // Texto a mostrar

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
         $x = 135;  // Posición X
         $y = 270;  // Posición Y
         $width = 25;  // Ancho del área
         $height = 6;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['folio_completo']; // Texto a mostrar

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

         $x = 10;  // Posición X
         $y = 10;  // Posición Y
         $width = 80;  // Ancho del área
         $height = 36;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $data['website'];
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================

         #================HYPERVINCULO====================

         $x = 7;  // Posición X
         $y = 270;  // Posición Y
         $width = 115;  // Ancho del área
         $height = 8;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $this->urlVerificarConstancias;
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================
    }

    private function MI2019_Relep($data){
        $pdf = $data['pdf'];
         #================NOMBRE====================
         $x = 25;  // Posición X
         $y = 90;  // Posición Y
         $width = 165;  // Ancho del área
         $height = 12;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['nombre_constancia']; // Texto a mostrar

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
         $x = 135;  // Posición X
         $y = 270;  // Posición Y
         $width = 25;  // Ancho del área
         $height = 6;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['folio_completo']; // Texto a mostrar

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

         $x = 10;  // Posición X
         $y = 10;  // Posición Y
         $width = 80;  // Ancho del área
         $height = 36;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $data['website'];
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================

         #================HYPERVINCULO====================

         $x = 7;  // Posición X
         $y = 270;  // Posición Y
         $width = 115;  // Ancho del área
         $height = 8;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $this->urlVerificarConstancias;
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================
    }

    private function MI2020($data){
        $pdf = $data['pdf'];
         #================NOMBRE====================
         $x = 25;  // Posición X
         $y = 100;  // Posición Y
         $width = 165;  // Ancho del área
         $height = 12;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['nombre_constancia']; // Texto a mostrar

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
         $x = 135;  // Posición X
         $y = 270;  // Posición Y
         $width = 25;  // Ancho del área
         $height = 6;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['folio_completo']; // Texto a mostrar

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

         $x = 10;  // Posición X
         $y = 10;  // Posición Y
         $width = 80;  // Ancho del área
         $height = 36;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $data['website'];
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================

         #================HYPERVINCULO====================

         $x = 7;  // Posición X
         $y = 270;  // Posición Y
         $width = 115;  // Ancho del área
         $height = 8;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $this->urlVerificarConstancias;
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================
    }

    private function MI2020_Relep($data){
        $pdf = $data['pdf'];
         #================NOMBRE====================
         $x = 25;  // Posición X
         $y = 90;  // Posición Y
         $width = 165;  // Ancho del área
         $height = 12;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['nombre_constancia']; // Texto a mostrar

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
         $x = 135;  // Posición X
         $y = 270;  // Posición Y
         $width = 25;  // Ancho del área
         $height = 6;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['folio_completo']; // Texto a mostrar

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

         $x = 10;  // Posición X
         $y = 10;  // Posición Y
         $width = 80;  // Ancho del área
         $height = 36;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $data['website'];
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================

         #================HYPERVINCULO====================

         $x = 7;  // Posición X
         $y = 270;  // Posición Y
         $width = 115;  // Ancho del área
         $height = 8;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $this->urlVerificarConstancias;
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================
    }
    
    private function MI2021($data){
        $pdf = $data['pdf'];
         #================NOMBRE====================
         $x = 12;  // Posición X
         $y = 80;  // Posición Y
         $width = 186;  // Ancho del área
         $height = 12;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['nombre_constancia']; // Texto a mostrar

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
         $x = 175;  // Posición X
         $y = 278;  // Posición Y
         $width = 30;  // Ancho del área
         $height = 6;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['folio_completo']; // Texto a mostrar

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



         // Establecer el área de texto
         $pdf->SetXY($x, $y);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->MultiCell($width, $height, $texto, 0, 'R', false, 1, '', '', true, 0, false, true, $height, 'M');

         #================FOLIO====================


         #================HYPERVINCULO====================

         $x = 60;  // Posición X
         $y = 10;  // Posición Y
         $width = 90;  // Ancho del área
         $height = 36;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $data['website'];
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================

         #================HYPERVINCULO====================

         $x = 60;  // Posición X
         $y = 287;  // Posición Y
         $width = 150;  // Ancho del área
         $height = 8;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $this->urlVerificarConstancias;
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================
    }

    private function CE2023($data){
        $pdf = $data['pdf'];
         #================NOMBRE====================
         $x = 23;  // Posición X
         $y = 80;  // Posición Y
         $width = 255;  // Ancho del área
         $height = 12;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['nombre_constancia']; // Texto a mostrar

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
         $x = 250;  // Posición X
         $y = 193;  // Posición Y
         $width = 30;  // Ancho del área
         $height = 6;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['folio_completo']; // Texto a mostrar

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



         // Establecer el área de texto
         $pdf->SetXY($x, $y);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

         #================FOLIO====================


         #================HYPERVINCULO====================

         $x = 25;  // Posición X
         $y = 8;  // Posición Y
         $width = 90;  // Ancho del área
         $height = 36;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $data['website'];
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================

         #================HYPERVINCULO====================

         $x = 5;  // Posición X
         $y = 200;  // Posición Y
         $width = 155;  // Ancho del área
         $height = 8;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $this->urlVerificarConstancias;
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================
    }

    private function CE2022($data){
        $pdf = $data['pdf'];
         #================NOMBRE====================
         $x = 23;  // Posición X
         $y = 80;  // Posición Y
         $width = 255;  // Ancho del área
         $height = 12;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['nombre_constancia']; // Texto a mostrar

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
         $x = 250;  // Posición X
         $y = 193;  // Posición Y
         $width = 30;  // Ancho del área
         $height = 6;  // Alto del área

         #AUTOSIZE FONT

         $texto = $data['folio_completo']; // Texto a mostrar

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



         // Establecer el área de texto
         $pdf->SetXY($x, $y);
         $pdf->SetTextColor(0, 0, 0);
         $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

         #================FOLIO====================


         #================HYPERVINCULO====================

         $x = 25;  // Posición X
         $y = 8;  // Posición Y
         $width = 90;  // Ancho del área
         $height = 36;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $data['website'];
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================

         #================HYPERVINCULO====================

         $x = 5;  // Posición X
         $y = 200;  // Posición Y
         $width = 155;  // Ancho del área
         $height = 8;  // Alto del área

         $pdf->SetXY($x, $y);

         $pdf->SetTextColor(101, 113, 124);

         $url = $this->urlVerificarConstancias;
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);

         #================HYPERVINCULO====================
    }
    
    private function RIQ2022($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 34;  // Posición X
        $y = 85;  // Posición Y
        $width = 230;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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

        #================Lugar====================
        $x = 154;  // Posición X
        $y = 97;  // Posición Y
        $width = 32;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['lugar'] . ' lugar'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 14;
        $fontFamily = 'gothicb';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================Lugar====================

        #================Ponencia====================
        $x = 34;  // Posición X
        $y = 135;  // Posición Y
        $width = 230;  // Ancho del área
        $height = 15;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_ponencia']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================Ponencia====================

        #================FOLIO====================
        $x = 227;  // Posición X
        $y = 187;  // Posición Y
        $width = 40;  // Ancho del área
        $height = 7;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 190;  // Posición X
        $y = 18;  // Posición Y
        $width = 90;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================


        #================HYPERVINCULO====================

        $x = 20;  // Posición X
        $y = 18;  // Posición Y
        $width = 110;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = 'https://iquatroeditores.org/revista/';
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function RIQ2023($data){
        $pdf = $data['pdf'];
        #================NOMBRE====================
        $x = 34;  // Posición X
        $y = 85;  // Posición Y
        $width = 230;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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

        #================Lugar====================
        $x = 154;  // Posición X
        $y = 97;  // Posición Y
        $width = 32;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['lugar'] . ' lugar'; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 14;
        $fontFamily = 'gothicb';
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
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================Lugar====================

        #================Ponencia====================
        $x = 34;  // Posición X
        $y = 135;  // Posición Y
        $width = 230;  // Ancho del área
        $height = 15;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_ponencia']; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $fontSize = 12;
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
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================Ponencia====================

        #================FOLIO====================
        $x = 227;  // Posición X
        $y = 187;  // Posición Y
        $width = 40;  // Ancho del área
        $height = 7;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 190;  // Posición X
        $y = 18;  // Posición Y
        $width = 90;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================


        #================HYPERVINCULO====================

        $x = 20;  // Posición X
        $y = 18;  // Posición Y
        $width = 110;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = 'https://iquatroeditores.org/revista/';
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function CQ2023($data){

        $pdf = $data['pdf'];

        #================NOMBRE====================
        $x = 36;  // Posición X
        $y = 68;  // Posición Y
        $width = 228;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 55;  // Posición X
        $y = 90;  // Posición Y
        $width = 190;  // Ancho del área
        $height = 30;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_ponencia']; // Texto a mostrar

        $textWidth = $pdf->GetStringWidth($texto);
        $textHeight = $pdf->getStringHeight($width, $texto);
        $fontSize = 16;
        $fontFamily = 'gothicb';
        $pdf->SetFont($fontFamily, '', $fontSize, '', false);

        while ($textHeight > $height) {
            $fontSize -= 0.5; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textHeight = $pdf->getStringHeight($width, $texto);
        }

        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================PONENCIA====================

        #================FOLIO====================
        $x = 240;  // Posición X
        $y = 202;  // Posición Y
        $width = 35;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 85;  // Posición X
        $y = 6;  // Posición Y
        $width = 65;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 15;  // Posición X
        $y = 6;  // Posición Y
        $width = 65;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = 'https://redesla.la/';
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 4;  // Posición X
        $y = 200;  // Posición Y
        $width = 165;  // Ancho del área
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

        $url = 'https://redesla.la/redesla/constancias';
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function PO2023_Relayn($data){

        $pdf = $data['pdf'];

        #================NOMBRE====================
        $x = 36;  // Posición X
        $y = 68;  // Posición Y
        $width = 228;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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
        $x = 65;  // Posición X
        $y = 90;  // Posición Y
        $width = 175;  // Ancho del área
        $height = 30;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_ponencia']; // Texto a mostrar

        // Obtener el ancho del texto con la fuente y el tamaño actual
        $textWidth = $pdf->GetStringWidth($texto);
        $textHeight = $pdf->getStringHeight($width, $texto);
        $fontSize = 16;
        $fontFamily = 'gothicb';
        $pdf->SetFont($fontFamily, '', $fontSize, '', false);

        while ($textHeight > $height) {
            $fontSize -= 0.5; // Reducir el tamaño de fuente
            $pdf->SetFont($fontFamily, '', $fontSize);
            $textHeight = $pdf->getStringHeight($width, $texto);
        }

        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'C', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================PONENCIA====================

        #================FOLIO====================
        $x = 240;  // Posición X
        $y = 202;  // Posición Y
        $width = 35;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

        #================HYPERVINCULO====================

        $x = 15;  // Posición X
        $y = 6;  // Posición Y
        $width = 65;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = 'https://redesla.la/redesla/';
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 84;  // Posición X
        $y = 6;  // Posición Y
        $width = 63;  // Ancho del área
        $height = 30;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 4;  // Posición X
        $y = 200;  // Posición Y
        $width = 165;  // Ancho del área
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

        $url = 'https://redesla.la/redesla/constancias';
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }

    private function PA2023($data){

        $pdf = $data['pdf'];

        #================NOMBRE====================
        $x = 36;  // Posición X
        $y = 85;  // Posición Y
        $width = 228;  // Ancho del área
        $height = 12;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['nombre_constancia']; // Texto a mostrar

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

        #================Porcentaje====================
        $x = 175;  // Posición X
        $y = 150;  // Posición Y
        $width = 20;  // Ancho del área
        $height = 10;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['porcentaje']; // Texto a mostrar

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


        #================FOLIO====================
        $x = 245;  // Posición X
        $y = 202;  // Posición Y
        $width = 35;  // Ancho del área
        $height = 8;  // Alto del área

        #AUTOSIZE FONT

        $texto = $data['folio_completo']; // Texto a mostrar

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



        // Establecer el área de texto
        $pdf->SetXY($x, $y);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell($width, $height, $texto, 0, 'L', false, 1, '', '', true, 0, false, true, $height, 'M');

        #================FOLIO====================

         #================HYPERVINCULO====================

         $x = 13;  // Posición X
         $y = 7;  // Posición Y
         $width = 90;  // Ancho del área
         $height = 35;  // Alto del área
 
         $pdf->SetXY($x, $y);
 
         $pdf->SetTextColor(101, 113, 124);
 
         $url = 'https://redesla.la/redesla/';
         $pdf->SetAlpha(0.0);
         $pdf->Rect($x, $y, $width, $height, 'F');
         $pdf->Link($x, $y, $width, $height, $url);
 
         #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 100;  // Posición X
        $y = 6;  // Posición Y
        $width = 100;  // Ancho del área
        $height = 35;  // Alto del área

        $pdf->SetXY($x, $y);

        $pdf->SetTextColor(101, 113, 124);

        $url = $data['website'];
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================

        #================HYPERVINCULO====================

        $x = 4;  // Posición X
        $y = 200;  // Posición Y
        $width = 165;  // Ancho del área
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

        $url = 'https://redesla.la/redesla/constancias';
        $pdf->SetAlpha(0.0);
        $pdf->Rect($x, $y, $width, $height, 'F');
        $pdf->Link($x, $y, $width, $height, $url);

        #================HYPERVINCULO====================
    }
    
    

}
