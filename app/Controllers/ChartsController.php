<?php

namespace App\Controllers;
use App\Models\CuestionariosModel;
use TCPDF;

class ChartsController extends BaseController
{

    public $db_serv;

    public function __construct(){
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $this->CuestionariosModel = new CuestionariosModel();
        $this->db_serv = \Config\Database::connect('cuestionarios');
    }

    public function ingresos_gastos($tabla,$claveCuerpo){
        #6a,6b,6c
        $arr_labels = [];
        array_push($arr_labels,'Aumentaron mucho');
        array_push($arr_labels,'Aumentaron poco');
        array_push($arr_labels,'Permanece igual');
        array_push($arr_labels,'Disminuyeron poco');
        array_push($arr_labels,'Disminuyeron mucho');
        $data['labels_externos'] = $arr_labels;

        $preguntas = ['6a','6b','6c'];

        foreach($preguntas as $key => $p){
            $arr_data = [];
            for ($e=0; $e <=4 ; $e++) {

                switch($p){
                    case '6a':
                        $data['datasets'][$key]['label'] = 'Las ventas (anuales)';
                        break;
                    case '6b':
                        $data['datasets'][$key]['label'] = 'Las utilidades (anuales)';
                        break;
                    case '6c':
                        $data['datasets'][$key]['label'] = 'El número de empleados';
                        break;
                }
                $condiciones = [$p => $e, 'claveCuerpo' => $claveCuerpo];
                $cantidad = $this->CuestionariosModel->count($tabla,$condiciones);
                array_push($arr_data,$cantidad);
                
            }

            $data['datasets'][$key]['data'] = $arr_data;
            $data['datasets'][$key]['fill'] = true;
            $data['datasets'][$key]['pointBorderColor'] = '#fff';
            $data['datasets'][$key]['pointHoverBackgroundColor'] = '#fff';
            $strColor = '';
            for ($i=1; $i <=3 ; $i++) { 
                $strColor .= mt_rand(0, 255).',';
            }
            $data['datasets'][$key]['backgroundColor'] = 'rgba('.$strColor.' 0.2)';
            $data['datasets'][$key]['borderColor'] = 'rgb('.rtrim($strColor, ",").')';
            $data['datasets'][$key]['pointBackgroundColor'] = 'rgb('.rtrim($strColor, ",").')';
            $data['datasets'][$key]['pointHoverBorderColor'] = 'rgb('.rtrim($strColor, ",").')';            
        }
        $data = (object) $data;
        return $this->response->setJSON($data);
    }

    public function insumos($tabla,$claveCuerpo){
        #6a,6b,6c
        $labelValues = [
            'Mi empresa ha logrado conseguir empleados muy leales.',
            'Mi empresa ha logrado conseguir empleados muy capaces.',
            'Mi empresa ha logrado conseguir empleados que tienen buen trato con todos.',
            'Me enfoco principalmente en mejorar la productividad de mis empleados.',
            'Me enfoco principalmente en mejorar el bienestar de mis empleados.'
        ];

        $data['labels_externos'] = $labelValues;

        /*
        $arr_labels = [];
        array_push($arr_labels,'Muy de acuerdo');
        array_push($arr_labels,'De acuerdo');
        array_push($arr_labels,'En desacuerdo');
        array_push($arr_labels,'Muy en desacuerdo');
        array_push($arr_labels,'No sé / No aplica');

        $data['labels_externos'] = $arr_labels;

        $labelValues = [
            'Muy de acuerdo' => 4,
            'De acuerdo' => 3,
            'En desacuerdo' => 2,
            'Muy en desacuerdo' => 1,
            'No sé / No aplica' => 'nc'
        ];
        $labelValues = [
            'Muy de acuerdo' => 4,
            'De acuerdo' => 3,
            'En desacuerdo' => 2,
            'Muy en desacuerdo' => 1,
            'No sé / No aplica' => 'nc'
        ];
        $preguntas = [
            '9' => [
                'preguntas' => ['9a','9b','9c','9d','9e'],
                'label' => 'Recursos humanos'
            ],
            '10' => [
                'preguntas' => ['10a','10b','10c','10d','10e'],
                'label' => 'Análisis de mercado (Información)'
            ],
            '11' => [
                'preguntas' => ['11a','11b','11c','11d','11e'],
                'label' => 'Proveedores'
                ]
        ];
        */
        /*
        $i = 0;
        foreach($preguntas as $key => $p){
            $arr_data = [];
            $data['datasets'][$i]['label'] = $p['label'];

            foreach($labelValues as $keyValue=>$l){
                $cantidad = 0;
                foreach($p['preguntas'] as $v){
                    $condiciones = [$v => $l, 'claveCuerpo' => $claveCuerpo];
                    $cantidad = $cantidad + ($this->CuestionariosModel->count($tabla,$condiciones));
                }
                $promedio = $cantidad / count($p['preguntas']);
                $promedio = round($promedio,2);
                array_push($arr_data,$promedio);
            }
            
            $data['datasets'][$i]['data'] = $arr_data;
            $data['datasets'][$i]['fill'] = true;
            $data['datasets'][$i]['pointBorderColor'] = '#fff';
            $data['datasets'][$i]['pointHoverBackgroundColor'] = '#fff';
            $strColor = '';
            for ($e=1; $e <=3 ; $e++) { 
                $strColor .= mt_rand(0, 255).',';
            }
            $data['datasets'][$i]['backgroundColor'] = 'rgba('.$strColor.' 0.2)';
            $data['datasets'][$i]['borderColor'] = 'rgb('.rtrim($strColor, ",").')';
            $data['datasets'][$i]['pointBackgroundColor'] = 'rgb('.rtrim($strColor, ",").')';
            $data['datasets'][$i]['pointHoverBorderColor'] = 'rgb('.rtrim($strColor, ",").')';
            $i++;
        }
        */
        $preguntas = [
            0 => [
                'inciso' => '9a',
                'label' => 'Mi empresa ha logrado conseguir empleados muy leales.'
            ],
            1 => [
                'inciso' => '9b',
                'label' => 'Mi empresa ha logrado conseguir empleados muy capaces.'
            ],
            2 => [
                'inciso' => '9c',
                'label' => 'Mi empresa ha logrado conseguir empleados que tienen buen trato con todos.'
            ],
            3 => [
                'inciso' => '9d',
                'label' => 'Me enfoco principalmente en mejorar la productividad de mis empleados.'
            ],
            4 => [
                'inciso' => '9e',
                'label' => 'Me enfoco principalmente en mejorar el bienestar de mis empleados.'
            ]
        ];

        $arr_promedio = [];
        
        foreach($preguntas as $key=>$p){
            $arr_data = [];
            #$data['datasets'][$key]['label'] = $p['label'];
            $columnas = [$p['inciso']];
            $condiciones = ['claveCuerpo' => $claveCuerpo];
            $datos_columna = $this->CuestionariosModel->getAllColums($columnas,$tabla,$condiciones);
            $suma = 0;
            foreach($datos_columna as $keyColumna => $d){;
                $d = $d[$p['inciso']] == 'nc' ? 0 : $d[$p['inciso']];      
                $suma = $suma + intVal($d);
            }
            $promedio = $suma / count($datos_columna);
            array_push($arr_promedio,$promedio);

            /*
            $cantidad_registros = 0;
            foreach($labelValues as $keyValores => $l){
                $condiciones = [$p['inciso'] => $l, 'claveCuerpo' => $claveCuerpo];
                $cantidad_registros = $cantidad_registros + ($this->CuestionariosModel->count($tabla,$condiciones));
                #array_push($arr_data,$cantidad);
            }
            
            */
        }
            $data['datasets'][0]['label'] = 'Promedio';
            $data['datasets'][0]['data'] = $arr_promedio;
            $data['datasets'][0]['fill'] = true;
            $data['datasets'][0]['pointBorderColor'] = '#fff';
            $data['datasets'][0]['pointHoverBackgroundColor'] = '#fff';
            $strColor = '';
            for ($e=1; $e <=3 ; $e++) { 
                $strColor .= mt_rand(0, 255).',';
            }
            $data['datasets'][0]['backgroundColor'] = 'rgba('.$strColor.' 0.2)';
            $data['datasets'][0]['borderColor'] = 'rgb('.rtrim($strColor, ",").')';
            $data['datasets'][0]['pointBackgroundColor'] = 'rgb('.rtrim($strColor, ",").')';
            $data['datasets'][0]['pointHoverBorderColor'] = 'rgb('.rtrim($strColor, ",").')';

        
        $data = (object) $data;
        return $this->response->setJSON($data);
    }

}
?>