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

use \CodeIgniter\Files\Handlers\FileHandler;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpZip\ZipFile;
use TCPDF;
use ZipArchive;

use function PHPSTORM_META\map;
use function PHPUnit\Framework\isNull;


class InvestigacionesController extends BaseController
{

    public $db_serv;
    public $db_serv_cuest;
    public $db_serv_iquatro;
    public $CuestionariosModel;
    public $AdminModel;
    public $IquatroModel;
    public $db_cursos;
    public $esquemas_validos;
    public $nombres_fases;

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
        $this->esquemas_validos = [
            'A', 'B'
        ];
        $this->nombres_fases = [
            1 => [
                'Captura de encuestas'
            ],
            2 => [
                'Subir logotipo'
            ],
            3 => [
                'Orden de autores'
            ],
            4 => [
                'Redacción de resumen'
            ],
            5 => [
                'Palabras clave'
            ],
            6 => [
                'Redactar discusión'
            ],
            7 => [
                'Carta de cesión de derechos'
            ],
            8 => [
                'Carta de visto bueno'
            ],
            9 => [
                'Fases terminadas, Felicidades'
            ]
        ];
    }

    private function generateServerSideTable($send)
    {

        $tabla = $send['tabla'];
        $valor_buscado = $send['valor_buscado'];

        $condicion = '';
        $join = '';

        if (!empty($send['valor_buscado'])) {
            foreach ($send['columnas'] as $key => $val) {
                if ($send['columnas'][$key] == 'id') {
                    $condicion .= " {$tabla}.{$val} LIKE '%{$valor_buscado}%'";
                } else {
                    $condicion .= " OR {$tabla}.{$val} LIKE '%{$valor_buscado}%'";
                }
            }
        }

        if (isset($send['inner_join'])) {
            $columns_joins = '';
            $search_join = '';
            foreach ($send['inner_join'] as $key => $val) {
                $tabla_join = $key;
                $relacion = $val['join'];
                $type = isset($val['type']) ? $val['type'] : 'INNER JOIN';
                $join .= " {$type} {$tabla_join} ON {$relacion} ";

                $count = count($val['columnas']);
                foreach ($val['columnas'] as $key => $c) {

                    if ($key === $count - 1) {
                        $columns_joins .= "{$tabla_join}.{$c} as {$tabla_join}_{$c}, ";
                    } else {
                        $columns_joins .= "{$tabla_join}.{$c} as {$tabla_join}_{$c}, ";
                    }

                    $search_join .= " OR {$tabla_join}.{$c} LIKE '%{$valor_buscado}%' ";
                }
            }
        }


        if (isset($columns_joins)) {
            $columns_joins = substr($columns_joins, 0, -2);
        }
        $str_columnas = '';

        foreach ($send['columnas'] as $c) {
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

        if (isset($search_join) && !empty($valor_buscado)) {
            $sql_data .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion}{$search_join})" : " WHERE {$condicion}{$search_join}";
            $sql_count .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion}{$search_join})" : " WHERE {$condicion}{$search_join}";
        } else {
            if (!empty($condicion)) {
                $sql_data .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion})" : " WHERE {$condicion}";
                $sql_count .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion})" : " WHERE {$condicion}";
            } else {
                $sql_data .= isset($send['where']) ? " WHERE ({$send['where']})" : "{$condicion}";
                $sql_count .= isset($send['where']) ? " WHERE ({$send['where']})" : "{$condicion}";
            }
        }

        ##echo $sql_count; exit;

        $total_count = $this->db_serv_cuest->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $send['columnas'][$send['order_column']] . " " . $send['dir'] . " LIMIT " . $send['start'] . ", " . $send['length'] . "";

        #echo $sql_data; exit;

        $data = $this->db_serv_cuest->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        $dataReturn = [
            'total_count' => $total_count,
            'array' => $array
        ];

        return $dataReturn;
    }

    private function generateServerSideTableMaster($send)
    {

        $tabla = $send['tabla'];
        $valor_buscado = $send['valor_buscado'];

        $condicion = '';
        $join = '';

        if (!empty($send['valor_buscado'])) {
            foreach ($send['columnas'] as $key => $val) {
                if ($send['columnas'][$key] == 'id') {
                    $condicion .= " {$tabla}.{$val} LIKE '%{$valor_buscado}%'";
                } else {
                    $condicion .= " OR {$tabla}.{$val} LIKE '%{$valor_buscado}%'";
                }
            }
        }

        if (isset($send['inner_join'])) {
            $columns_joins = '';
            $search_join = '';
            foreach ($send['inner_join'] as $key => $val) {
                $tabla_join = $key;
                $relacion = $val['join'];
                $type = isset($val['type']) ? $val['type'] : 'INNER JOIN';
                $join .= " {$type} {$tabla_join} ON {$relacion} ";

                $count = count($val['columnas']);
                foreach ($val['columnas'] as $key => $c) {

                    if ($key === $count - 1) {
                        $columns_joins .= "{$tabla_join}.{$c} as {$tabla_join}_{$c}, ";
                    } else {
                        $columns_joins .= "{$tabla_join}.{$c} as {$tabla_join}_{$c}, ";
                    }

                    $search_join .= " OR {$tabla_join}.{$c} LIKE '%{$valor_buscado}%' ";
                }
            }
        }


        if (isset($columns_joins)) {
            $columns_joins = substr($columns_joins, 0, -2);
        }
        $str_columnas = '';

        foreach ($send['columnas'] as $c) {
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

        if (isset($search_join) && !empty($valor_buscado)) {
            $sql_data .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion}{$search_join})" : " WHERE {$condicion}{$search_join}";
            $sql_count .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion}{$search_join})" : " WHERE {$condicion}{$search_join}";
        } else {
            if (!empty($condicion)) {
                $sql_data .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion})" : " WHERE {$condicion}";
                $sql_count .= isset($send['where']) ? " WHERE ({$send['where']}) AND ({$condicion})" : " WHERE {$condicion}";
            } else {
                $sql_data .= isset($send['where']) ? " WHERE ({$send['where']})" : "{$condicion}";
                $sql_count .= isset($send['where']) ? " WHERE ({$send['where']})" : "{$condicion}";
            }
        }

        /* echo json_encode($sql_data);
        exit; */

        #echo $sql_count; exit;

        $total_count = $this->db_serv->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $send['columnas'][$send['order_column']] . " " . $send['dir'] . " LIMIT " . $send['start'] . ", " . $send['length'] . "";

        #echo $sql_data; exit;

        $data = $this->db_serv->query($sql_data)->getResult(); //es un objeto

        $array = json_decode(json_encode($data), true); //lo convertimos a un array

        $dataReturn = [
            'total_count' => $total_count,
            'array' => $array
        ];

        return $dataReturn;
    }

    public function verArchivo($tipo, $obra, $anio)
    {

        $condiciones = [
            'claveCuerpo' => session('CA'),
            'red' => session('red'),
            'anio' => $anio,
            'nombre' => $tipo,
            'tipo' => $obra
        ];
        $columnas = ['archivo', 'tipo_archivo','nombre_usuarios'];

        $archivo = $this->AdminModel->getColumnsOneRow($columnas, 'archivos_inv', $condiciones);
        $blobData = $archivo['archivo'];

        if ($archivo['tipo_archivo'] === 'image/png') {
            // Configura las cabeceras
            $this->response->setHeader('Content-Type', 'image/png');
            // Envía los datos binarios directamente
            echo $blobData;
        }else if($archivo['tipo_archivo'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
            // Configura las cabeceras para un archivo Word DOCX
            $this->response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            // Especifica el nombre del archivo para la descarga
            $this->response->setHeader('Content-Disposition', 'attachment; filename='.$archivo['nombre_usuarios'].'_'.session('CA').'.docx');
            // Envía los datos binarios del BLOB
            echo $blobData;
        }else if($archivo['tipo_archivo'] == 'application/pdf'){
            // Configura las cabeceras para un archivo PDF
            $this->response->setHeader('Content-Type', 'application/pdf');
            // Especifica el nombre del archivo para la descarga
            $this->response->setHeader('Content-Disposition', 'inline; filename=' . $archivo['nombre_usuarios'] . '_' . session('CA') . '.pdf');
            // Envía los datos binarios del BLOB
            echo $blobData;
        }
    }

    private function pre($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }

    public function proyecto($esquema, $anio)
    {
        if (session('is_logged') === false) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $esquema = strtoupper($esquema);

        $esquemas_validos = [
            'A', 'B'
        ];

        if (!in_array($esquema, $esquemas_validos)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = [];

        /* VAMOS A REQUERIR INFORMACION DEPENDIENDO LA INVESTIGACION, HAREMOS UN MOLDE POR SI UNO ES IGUAL A OTRO O SI ES INDEPENDIENTE PUES LO PODEMOS CAMBIAR */

        $red = session('red');
        $claveCuerpo = session('CA');

        /* VAMOS A VERIFICAR SI EXISTEN LAS CARPETAS DE LAS INVESTIGACIONES */

        /* $directorios = [
            "uploads/investigacion/$red/$anio/archivos_comunes",
            "uploads/investigacion/$red/$anio/$esquema/$claveCuerpo",
            "uploads/investigacion/$red/$anio/$esquema/$claveCuerpo/cartas/digital"
        ];

        if ($esquema == 'B') {
            $directorios[] = "uploads/investigacion/$red/$anio/$esquema/$claveCuerpo/cartas/impreso";
        }

        foreach ($directorios as $ruta) {
            $rutaCompleta = WRITEPATH . $ruta;
            if (!file_exists($rutaCompleta)) {
                mkdir($rutaCompleta, 0777, true);
            }
        } */

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => $anio];
        $fase = $this->AdminModel->getAllOneRow('fases_investigaciones', $condiciones);

        if (empty($fase)) {
            //NO EXISTE UN REGISTRO, LO CREAMOS
            $dataInsert = [
                'claveCuerpo' => $claveCuerpo,
                'f_digital' => 1,
                'r_digital' => 0,
                'anio' => $anio,
                'esquema' => $esquema,
                'red' => $red
            ];

            if ($esquema == 'B') {
                $dataInsert['f_impreso'] = 1;
                $dataInsert['r_impreso'] = 0;
            }

            if (!$this->AdminModel->generalInsert('fases_investigaciones', $dataInsert)) {
                //ERROR 101
                return redirect()->back();
            }

            $condiciones = ['claveCuerpo' => $claveCuerpo, 'anio' => $anio];
            $fase = $this->AdminModel->getAllOneRow('fases_investigaciones', $condiciones);
        }

        //VAMOS A OBTENER LA CONTRASEñA DEL CUERPO

        $columnas = ['password'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $ca = $this->AdminModel->getColumnsOneRow($columnas, "cuerpos_academicos", $condiciones);

        //OBTENEMOS LAS INSTRUCCIONES
        $condiciones = [
            'red' => $red,
            'anio' => $anio,
            'tipo' => 'Investigación'
        ];

        $instruccion_investigacion = $this->AdminModel->getAllOneRow('instrucciones_investigaciones', $condiciones);

        if (empty($instruccion_investigacion['instrucciones'])) {
            //ERROR 102
            return redirect()->back()
            ->with('icon', 'info')
            ->with('title', 'Trabajando 👨‍💻')
            ->with('text', 'El módulo aún no se encuentra disponible');
        }

        $nombre_tabla_cuestionarios = 'cuestionarios_' . strtolower($red) . '_' . $anio;
        $db = db_connect('cuestionarios');
        if (!$db->tableExists($nombre_tabla_cuestionarios)) {
            return redirect()->to(base_url('inicio/' . $_SESSION['red'] . '/' . session('CA')))
                ->with('icon', 'warning')
                ->with('title', 'Trabajando 👨‍💻')
                ->with('text', 'El módulo aún no se encuentra disponible');
        }

        $condiciones = ['estado' => 0, 'claveCuerpo' => session('CA')];
        $c_pendientes = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
        $condiciones = ['estado !=' => 0, 'claveCuerpo' => session('CA')];
        $c_completadas = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);

        #CANTIDAD DE CADA ESTADO
        $condiciones = ['estado' => 1, 'claveCuerpo' => session('CA')];
        $estado_1 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
        $condiciones = ['estado' => 2, 'claveCuerpo' => session('CA')];
        $estado_2 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
        $condiciones = ['estado' => 3, 'claveCuerpo' => session('CA')];
        $estado_3 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
        $condiciones = ['estado' => 4, 'claveCuerpo' => session('CA')];
        $estado_4 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);
        $condiciones = ['estado' => 5, 'claveCuerpo' => session('CA')];
        $estado_5 = $this->CuestionariosModel->count($nombre_tabla_cuestionarios, $condiciones);

        $cantidad_minima = 384;

        if (!empty($c_completadas)) {
            $pocentaje_completado = ($estado_1 * 100) / $cantidad_minima;
            $pocentaje_completado = round($pocentaje_completado, 2);
            $pocentaje_completado = $pocentaje_completado > 100 ? 100 : $pocentaje_completado;
        } else {
            $pocentaje_completado = 0;
        }


        $investigacion['entrevistas_pendientes'] = $c_pendientes;
        $investigacion['entrevistas_completadas'] = $c_completadas;
        $investigacion['pocentaje_completado'] = $pocentaje_completado;
        $investigacion['estado_1'] = $estado_1;
        $investigacion['estado_2'] = $estado_2;
        $investigacion['estado_3'] = $estado_3;
        $investigacion['estado_4'] = $estado_4;
        $investigacion['estado_5'] = $estado_5;
        $investigacion['nombre_tabla'] = $nombre_tabla_cuestionarios;
        #$data['investigacion']['esquema'] = str_replace(':', '', $nombre_explode[1]);
        #$data['investigacion']['nombre_esquema'] = $nombre;

        $condiciones = [
            'red' => $red,
            'anio' => $anio,
            'claveCuerpo' => $claveCuerpo
        ];

        $columnas = ['id', 'nombre', 'nombre_usuarios', 'tipo_archivo', 'usuario', 'fecha_insert', 'fecha_update', 'fecha_validate','validado','tipo','atendido'];
        $archivos = $this->AdminModel->getAllColums($columnas, 'archivos_inv', $condiciones);

        if (!empty($archivos)) {
            foreach ($archivos as $key => $val) {
                if($val['usuario'] != 'admin'){
                    $columnas = ['profile_pic', 'nombre'];
                    $condiciones = ['usuario' => $val['usuario']];
                    $profile_pic = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
                    $profile_name = $profile_pic['nombre'];
                    $profile = $profile_pic['profile_pic'];
    
                    if ($profile === null || $profile == '') {
                        $profile = 'avatar.png';
                    }
    
                    $archivos[$key]['profile_pic'] = $profile;
                    $archivos[$key]['nombre_usuario'] = $profile_name;
                }
            }
        }

        /* $columnas = ['usuario'];
        $condiciones = ['cuerpoAcademico' => $claveCuerpo];
        $miembros = $this->AdminModel->getAllColums($columnas, 'miembros', $condiciones);

        foreach ($miembros as $m) {
            $condiciones = ['usuario' => $m['usuario']];
            $columnas = ['nombre', 'ap_paterno', 'ap_materno'];
            $usuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);
            $nombre_usuario = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];
            $dataMiembros[] = [
                'nombre_usuario' => $nombre_usuario,
                'usuario' => $usuario
            ];
        } */

        $condiciones = [
            'red' => $red,
            'anio' => $anio
        ];

        $cartas = $this->AdminModel->getAll('cartas_inv',$condiciones);

        $data = [
            'red' => $red,
            'claveCuerpo' => $claveCuerpo,
            'esquema' => $esquema,
            'anio' => $anio,
            'fase' => $fase,
            'password' => $ca['password'],
            'instrucciones' => $instruccion_investigacion['instrucciones'],
            'tabla_encuestas' => $nombre_tabla_cuestionarios,
            'investigacion' => $investigacion,
            'archivos' => $archivos,
            'cartas' => $cartas
            //'miembros' => $dataMiembros
        ];

        //$this->pre($data);

        $contenidoHTML = $this->getHTMLAcciones($data);

        $data['html'] = $contenidoHTML;

        $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', '0');

        return view('usuarios/headers/index', $data)
            . view('usuarios/proyectos/investigaciones', $data)
            . view('usuarios/footers/index');
    }

    private function getHTMLAcciones($data)
    {
        ob_start();

        // Cargar la vista y capturar la salida en una variable
        echo view('usuarios/proyectos/estructura/index', $data);

        $contenidoHTML = ob_get_contents();

        ob_end_clean();

        return $contenidoHTML;
    }

    public function getListadoEncuestas($anio)
    {

        $columnas = [
            'id', 'folio', 'nombre_encuestador', 'estado'
        ];

        $red = strtolower(session('red'));
        $tabla = "cuestionarios_{$red}_{$anio}";
        $claveCuerpo = session('CA');

        $dataSend = [
            'valor_buscado' => $this->request->getGet('search')['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $this->request->getGet('order')[0]['dir'],
            'start' => $this->request->getGet('start'),
            'length' => $this->request->getGet('length'),
            'order_column' => $this->request->getGet('order')[0]['column'],
            'where' => "{$tabla}.claveCuerpo = '{$claveCuerpo}'"
        ];

        $serverSide = $this->generateServerSideTable($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        $json_data = [
            'draw' => intval($this->request->getGet('draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $array
        ];

        echo json_encode($json_data);
    }

    public function getExcelEncuesta($anio)
    {

        if (session('is_logged') === false) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }
        $red = session('red');
        $pais = session('pais');

        $preguntas = $this->getPreguntasEncuesta($anio, $red, $pais);

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

        foreach ($getAllEncuestas as $e) {
            $folio = $e['folio'];
            $estado = $this->getEstadoEncuesta($e['estado']);
            array_push($arr_respuestas, $folio);
            array_push($arr_respuestas, $estado);
            foreach ($preguntas as $p) {
                #$pregunta_solo_num = preg_replace('/[^0-9]/', '', $p['inciso']);
                if (session('red') == 'Relayn' && $anio == 2024) {
                    $arr_respuestas = $this->investigacionRelayn2024Excel($e, $p, $arr_respuestas);
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

    private function getEstadoEncuesta($estado)
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

    private function getPreguntasEncuesta($anio, $red, $pais)
    {
        $condiciones = [
            'red' => $red,
            'anio' => $anio,
            'pais' => 2
        ];

        $preguntas = $this->CuestionariosModel->getAll('preguntas_cuestionarios', $condiciones);

        if (empty($preguntas)) {
            return false;
            exit;
        }

        if ($pais != 2) {
            $condiciones = [
                'red' => $red,
                'anio' => $anio,
                'pais' => $pais
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
                switch ($pais) {
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

        return $preguntas;
    }

    private function investigacionRelayn2024Excel($e, $p, $arr_respuestas)
    {
        $valores = [
            5 => 'Muy de acuerdo',
            4 => 'De acuerdo',
            3 => 'Neutral',
            2 => 'En desacuerdo',
            1 => 'Muy en desacuerdo',
        ];

        $pregunta_solo_num = preg_replace('/[^0-9]/', '', $p['inciso']);

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
                    $datos = $this->db_serv_cuest->query($consulta)->getResult();
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
                }
                $valor_pregunta = rtrim($str_scian, ', ');
            }
            array_push($arr_respuestas, $valor_pregunta);
        }

        return $arr_respuestas;
    }

    public function updateStatusEncuesta()
    {

        $data = [
            'estado' => $_POST['selectStatus']
        ];

        $condiciones = [
            'id' => $_POST['id_cuestionario']
        ];

        if (!$this->CuestionariosModel->generalUpdate($_POST['tabla'], $data, $condiciones)) {
            http_response_code(100);
            exit;
        }

        $condiciones = ['id' => $_POST['id_cuestionario']];

        $columnas = ['nombre_encuestador', 'correo_encuestador', 'red', 'anio', 'claveCuerpo'];

        $dataEncuesta = $this->CuestionariosModel->getColumnsOneRow($columnas, $_POST['tabla'], $condiciones);

        if (empty($dataEncuesta)) {
            return json_encode($_POST);
        }

        if ($dataEncuesta['correo_encuestador'] == 'No aplica por el medio de captura.') {
            return true;
        }

        $condiciones = [
            'estado' => 1,
            'correo_encuestador' => $dataEncuesta['correo_encuestador'],
        ];

        $c_encuestas_validas = $this->CuestionariosModel->count($_POST['tabla'], $condiciones);

        if ($_POST['selectStatus'] == 1) {

            //La validacion es exitosa, puede ser acreditado a una constancia, pprimero pasa por un filtro, si tiene 2 encuestas ese correo con validas

            if ($c_encuestas_validas == 2) {

                $data = [
                    'nombre' => $dataEncuesta['nombre_encuestador'],
                    'correo' => $dataEncuesta['correo_encuestador'],
                    'red' => $dataEncuesta['red'],
                    'anio' => $dataEncuesta['anio']
                ];

                if (!$this->AdminModel->generalInsert('constancia_encuestador', $data)) {
                    http_response_code(101);
                    exit;
                }
                return true;
            } else {
                // O aun no completa los requisitos o ya se paso de 2
                return true;
            }
        } else {

            $condiciones = [
                'correo' => $dataEncuesta['correo_encuestador'],
                'red' => $dataEncuesta['red'],
                'anio' => $dataEncuesta['anio']
            ];

            if ($this->AdminModel->exist('constancia_encuestador', $condiciones)) {

                //Existe la constancia, vamos a ver si aun lo puede tener, sino para eliminarlo

                if ($c_encuestas_validas < 2) {
                    $condiciones = [
                        'correo' => $dataEncuesta['correo_encuestador'],
                        'red' => $dataEncuesta['red'],
                        'anio' => $dataEncuesta['anio']
                    ];
                    //YA NO TIENE 2 ENCUESTAS VALIDAS, LE REMOVEMOS LA ENCUESTA QUE TENIA
                    if (!$this->AdminModel->generalDelete('constancia_encuestador', $condiciones)) {
                        http_response_code(102);
                        exit;
                    }
                    return true;
                } else {
                    //AUN TIENE MAS O 2 ENCUESTAS VALIDAS
                    return true;
                }
            }
        }
    }

    public function getInfoEncuesta()
    {

        $id = $_POST['id'];
        $anio = $_POST['anio'];

        $condiciones = [
            'id' => $id
        ];

        $tabla = $_POST['tabla'];

        $info = $this->CuestionariosModel->getAll($tabla, $condiciones);

        if (empty($info)) {
            http_response_code(404);
            exit;
        }

        $red = session('red');
        $pais = session('pais');
        $preguntas = $this->getPreguntasEncuesta($anio, $red, $pais);

        if($preguntas == false){
            http_response_code(600);
            echo 'El archivo aún no esta disponible.';
            exit;
        }

        $adicionales = ['Folio', 'Estado'];



        $arr_respuestas = [];
        $inicio = 2;

        foreach ($info as $e) {
            $folio = $e['folio'];
            $estado = $this->getEstadoEncuesta($e['estado']);
            array_push($arr_respuestas, $folio);
            array_push($arr_respuestas, $estado);

            foreach ($preguntas as $p) {
                #$pregunta_solo_num = preg_replace('/[^0-9]/', '', $p['inciso']);
                if (session('red') == 'Relayn' && $anio == 2024) {
                    $arr_respuestas = $this->investigacionRelayn2024Excel($e, $p, $arr_respuestas);
                }
            }
        }

        /* $columnas = [];

        $columnas[0] = [
            'type' => 'text',
            'title' => 'Folio',
            'width' => 90
        ];
        $columnas[1] = [
            'type' => 'text',
            'title' => 'Estado',
            'width' => 90
        ];

        foreach($preguntas as $p){
            $columnas[] = [
                'type' => 'text',
                'title' => $p['nombre'],
                'width' => 90
            ];    
        }

        $dataReturn = [
            'columnas' => $columnas,
            'data' => $arr_respuestas
        ]; */

        $columnas[0] = [
            'type' => 'text',
            'title' => 'Pregunta',
            'width' => 350
        ];
        $columnas[1] = [
            'type' => 'text',
            'title' => 'Respuesta',
            'width' => 350
        ];

        $valores[0] = ['Folio', $arr_respuestas[0]];

        $valores[1] = ['Estado', $arr_respuestas[1]];

        foreach ($preguntas as $key => $p) {
            $valores[$key + 2] = [$p['nombre'], $arr_respuestas[$key + 2]];
        }

        $dataReturn = [
            'columnas' => $columnas,
            'data' => $valores
        ];


        return json_encode($dataReturn);
    }

    public function updatePhase()
    {

        $claveCuerpo = session('CA');
        $anio = $_POST['anio'];
        $red = session('red');

        $condiciones = [
            'claveCuerpo' => $claveCuerpo,
            'anio' => $anio
        ];

        $phase = $this->AdminModel->getAllOneRow('fases_investigaciones', $condiciones);

        if (empty($phase)) {
            http_response_code(600);
            exit;
        }

        $esquema = $phase['esquema'];

        if (!in_array($esquema, $this->esquemas_validos)) {
            http_response_code(601);
            exit;
        }

        $data = [
            'claveCuerpo' => $claveCuerpo,
            'anio' => $anio,
            'red' => $red,
            'phase' => $phase,
            'file' => isset($_FILES) ? $_FILES : null,
            'autores' => isset($_POST['autores']) ? $_POST['autores'] : null,
            'resumen' => isset($_POST['resumen']) ? $_POST['resumen'] : null,
            'obra' => isset($_POST['obra']) ? $_POST['obra'] : null,
            'tags' => isset($_POST['tags']) ? $_POST['tags'] : null,
            'discusion' => isset($_POST['discusion']) ? $_POST['discusion'] : null,
        ];
        

        $check = $this->checkUpdatePhase($data);

        if ($check === false) {
            http_response_code(602);
            exit;
        }

        return json_encode(true);
    }

    private function checkUpdatePhase($info)
    {

        $phase = $info['phase'];
        $obra = $info['obra'];
        //LA FASE 1 ES DONDE LOS 2 COINCIDEN, SON IGUALES, DESPUES SON INDEPENDIENTES

        if ($phase['f_impreso'] == 1 || $phase['f_digital'] == 1) {
            //ACTUALIZAMOS EL 'R' A 1
            if ($phase['esquema'] == 'B') {
                $dataUpdate = [
                    'r_impreso' => 1,
                    'r_digital' => 1
                ];
            } else if ($phase['esquema'] == 'A') {
                $dataUpdate = [
                    'r_digital' => 1
                ];
            }
        } else if ($phase['f_impreso'] == 2 || $phase['f_digital'] == 2) {
            //ES LA FASE DE INSERCION DE SU IMAGEN, POR LO QUE APARTE DE ACTUALIZAR, VAMOS A INSERTAR,
            $file_tmp = $info['file']['archivo']['tmp_name'];
            $file_type = $info['file']['archivo']['type'];
            $fp = fopen($file_tmp, 'r+b');
            $binario = fread($fp, filesize($file_tmp));
            fclose($fp);

            if ($phase['r_impreso'] == 2 || $phase['r_digital'] == 2) {
                //LA REVISION ES PORQUE HABIA SIDO RECHAZADA, POR LO QUE LA IMAGEN Y LA FECHA DE ACTUALIZACION SERA ACTUALIZADA
                $dataUpdate = [
                    'archivo' => $binario,
                    'fecha_update' => $this->getDateTime(),
                    'tipo_archivo' => $file_type,
                    'usuario' => session('usuario')
                ];
                $condiciones = [
                    'claveCuerpo' => $info['claveCuerpo'],
                    'anio' => $info['anio'],
                    'red' => $info['red'],
                    'nombre' => 'logo'
                ];
                $this->AdminModel->generalUpdate('archivos_inv', $dataUpdate, $condiciones);
            } else {
                $dataArchivo = [
                    'archivo' => $binario,
                    'nombre' => 'logo',
                    'nombre_usuarios' => 'Logotipo de la institución',
                    'usuario' => session('usuario'),
                    'claveCuerpo' => $info['claveCuerpo'],
                    'anio' => $info['anio'],
                    'red' => $info['red'],
                    'fecha_insert' => $this->getDateTime(),
                    'fecha_update' => $this->getDateTime(),
                    'tipo_archivo' => $file_type
                ];

                $this->AdminModel->generalInsert('archivos_inv', $dataArchivo);
            }

            if ($phase['esquema'] == 'B') {
                $dataUpdate = [
                    'r_impreso' => 1,
                    'r_digital' => 1
                ];
            } else if ($phase['esquema'] == 'A') {
                $dataUpdate = [
                    'r_digital' => 1
                ];
            }
        } else if ($phase['f_impreso'] == 3 || $phase['f_digital'] == 3) {
            //ES LA FASE DE ORDEN DE AUTORES, AQUI VAMOS A DIVIDIRLO AHORA SI.
            $orden_autores = $info['autores'];
            if ($phase['esquema'] == 'B') {
                //impreso y digital
                $ordenImpreso = $orden_autores['impreso'];
                $ordenDigital = $orden_autores['digital'];

                foreach ($ordenImpreso as $key => $o) {
                    $dataInsert = [
                        'claveCuerpo' => $info['claveCuerpo'],
                        'anio' => $info['anio'],
                        'usuario' => $o,
                        'orden_impreso' => $key + 1,
                        'red' => $info['red'],
                        'esquema' => $phase['esquema']
                    ];

                    $this->AdminModel->generalInsert('ordenes_autores', $dataInsert);
                }

                foreach ($ordenDigital as $key => $o) {
                    $dataUpdateDigital = [
                        'orden_digital' => $key + 1
                    ];
                    $condiciones = [
                        'claveCuerpo' => $info['claveCuerpo'],
                        'anio' => $info['anio'],
                        'usuario' => $o
                    ];
                    $this->AdminModel->generalUpdate('ordenes_autores', $dataUpdateDigital, $condiciones);
                }

                $dataUpdate = [
                    'f_impreso' => 4,
                    'f_digital' => 4
                ];
            } else {
                $ordenDigital = $orden_autores['digital'];
                foreach ($ordenDigital as $key => $o) {
                    $dataInsert = [
                        'claveCuerpo' => $info['claveCuerpo'],
                        'anio' => $info['anio'],
                        'usuario' => $o,
                        'orden_digital' => $key + 1,
                        'red' => $info['red'],
                        'esquema' => $phase['esquema']
                    ];

                    $this->AdminModel->generalInsert('ordenes_autores', $dataInsert);
                }

                $dataUpdate = [
                    'f_digital' => 4
                ];
            }
        }else if($phase['f_'.$obra] == 4){
            //RESUMEN
            if($phase['r_'.$obra] == 2){
                //se actualiza
            }else{
                //se inserta
                $dataInsert = [
                    'nombre' => 'resumen',
                    'obra' => $obra,
                    'texto' => $info['resumen'],
                    'claveCuerpo' => $info['claveCuerpo'],
                    'red' => $info['red'],
                    'anio' => $info['anio'],
                    'fecha_insert' => $this->getDateTime(),
                    'fecha_update' => $this->getDateTime()
                ];

                if(!$this->AdminModel->generalInsert('redacciones_inv',$dataInsert)){
                    return false;
                }

                $dataUpdate = [
                    'f_'.$obra => 5
                ];
                
            }
        }else if($phase['f_'.$obra] == 5){
            //RESUMEN
            if($phase['r_'.$obra] == 2){
                //se actualiza
            }else{
                //se inserta
                $str_palabras_clave = '';

                usort($info['tags'], function($a, $b) {
                    // Comparar los valores de los elementos
                    $valueA = strtolower($a);
                    $valueB = strtolower($b);
                    
                    // Realizar la comparación alfabética
                    return strcasecmp($valueA, $valueB);
                });
                

                foreach($info['tags'] as $key => $tag){
                    
                    if( (count($info['tags']) - 1) == $key ){
                        $str_palabras_clave .= $tag;
                    }else{
                        $str_palabras_clave .= $tag.'~';
                    }
                    
                    
                }
                

                $dataInsert = [
                    'nombre' => 'palabras_clave',
                    'obra' => $obra,
                    'texto' => $str_palabras_clave,
                    'claveCuerpo' => $info['claveCuerpo'],
                    'red' => $info['red'],
                    'anio' => $info['anio'],
                    'fecha_insert' => $this->getDateTime(),
                    'fecha_update' => $this->getDateTime()
                ];

                if(!$this->AdminModel->generalInsert('redacciones_inv',$dataInsert)){
                    return false;
                }

                $dataUpdate = [
                    'f_'.$obra => 6
                ];
                
            }
        }else if($phase['f_'.$obra] == 6){
            //RESUMEN
            if($phase['r_'.$obra] == 2){
                //se actualiza
            }else{

                $dataInsert = [
                    'nombre' => 'discusion',
                    'obra' => $obra,
                    'texto' => $_POST['discusion'],
                    'claveCuerpo' => $info['claveCuerpo'],
                    'red' => $info['red'],
                    'anio' => $info['anio'],
                    'fecha_insert' => $this->getDateTime(),
                    'fecha_update' => $this->getDateTime()
                ];

                if(!$this->AdminModel->generalInsert('redacciones_inv',$dataInsert)){
                    return false;
                }

                $dataUpdate = [
                    'f_'.$obra => 7
                ];
                
            }
        }else if($phase['f_'.$obra] == 7){
            //CARTA DE SESION DE DERECHOS
            
            $file_tmp = $info['file']['archivo']['tmp_name'];
            $file_type = $info['file']['archivo']['type'];
            $fp = fopen($file_tmp, 'r+b');
            $binario = fread($fp, filesize($file_tmp));
            fclose($fp);

            if($phase['r_'.$obra] == 2){

                $dataUpdateCartaDerechos = [
                    'archivo' => $binario,
                    'fecha_update' => $this->getDateTime(),
                    'tipo_archivo' => $file_type,
                    'usuario' => session('usuario'),
                    'validado' => 2
                ];

                $condiciones = [
                    'claveCuerpo' => $info['claveCuerpo'],
                    'anio' => $info['anio'],
                    'red' => $info['red'],
                    'nombre' => 'carta_derechos',
                    'tipo' => $obra
                ];
                $this->AdminModel->generalUpdate('archivos_inv', $dataUpdateCartaDerechos, $condiciones);
            }else{
                $dataArchivo = [
                    'archivo' => $binario,
                    'nombre' => 'carta_derechos',
                    'nombre_usuarios' => 'Carta de cesión de derechos',
                    'usuario' => session('usuario'),
                    'claveCuerpo' => $info['claveCuerpo'],
                    'anio' => $info['anio'],
                    'red' => $info['red'],
                    'fecha_insert' => $this->getDateTime(),
                    'fecha_update' => $this->getDateTime(),
                    'tipo_archivo' => $file_type,
                    'tipo' => $obra
                ];

                $this->AdminModel->generalInsert('archivos_inv',$dataArchivo);
            }

            $dataUpdate = [
                'r_'.$obra => 1
            ];
        }else if($phase['f_'.$obra] == 8){
            //CARTA DE VISTO BUENO
            //El 0 es la carta de visto bueno, el 1 es el marcaje
            $file_tmp = $info['file']['archivo']['tmp_name'][0];
            $file_type = $info['file']['archivo']['type'][0];
            $fp = fopen($file_tmp, 'r+b');
            $binario = fread($fp, filesize($file_tmp));
            fclose($fp);

            if(isset($info['file']['archivo']['tmp_name'][1])){
                $file_tmp_marcaje = $info['file']['archivo']['tmp_name'][1];
                $file_type_marcaje = $info['file']['archivo']['type'][1];
                $fp_marcaje = fopen($file_tmp_marcaje, 'r+b');
                $binario_marcaje = fread($fp_marcaje, filesize($file_tmp_marcaje));
                fclose($fp_marcaje);
            }

            if($phase['r_'.$obra] == 2){

                $dataUpdateCartaDerechos = [
                    'archivo' => $binario,
                    'fecha_update' => $this->getDateTime(),
                    'tipo_archivo' => $file_type,
                    'usuario' => session('usuario'),
                    'validado' => 2
                ];

                $condiciones = [
                    'claveCuerpo' => $info['claveCuerpo'],
                    'anio' => $info['anio'],
                    'red' => $info['red'],
                    'nombre' => 'carta_visto',
                    'tipo' => $obra
                ];
                $this->AdminModel->generalUpdate('archivos_inv', $dataUpdateCartaDerechos, $condiciones);
            }else{

                $dataArchivo = [
                    'archivo' => $binario,
                    'nombre' => 'carta_visto',
                    'nombre_usuarios' => 'Carta de visto bueno',
                    'usuario' => session('usuario'),
                    'claveCuerpo' => $info['claveCuerpo'],
                    'anio' => $info['anio'],
                    'red' => $info['red'],
                    'fecha_insert' => $this->getDateTime(),
                    'fecha_update' => $this->getDateTime(),
                    'tipo_archivo' => $file_type,
                    'tipo' => $obra
                ];

                $dataMarcaje = [
                    'archivo' => $binario_marcaje,
                    'nombre' => 'marcaje',
                    'nombre_usuarios' => 'Solicitud de marcaje',
                    'usuario' => session('usuario'),
                    'claveCuerpo' => $info['claveCuerpo'],
                    'anio' => $info['anio'],
                    'red' => $info['red'],
                    'fecha_insert' => $this->getDateTime(),
                    'fecha_update' => $this->getDateTime(),
                    'tipo_archivo' => $file_type_marcaje,
                    'tipo' => $obra,
                    'atendido' => 0
                ];

                $this->AdminModel->generalInsert('archivos_inv',$dataArchivo);
                $this->AdminModel->generalInsert('archivos_inv',$dataMarcaje);
            }

            $dataUpdate = [
                'r_'.$obra => 1
            ];
        }

        if (!isset($dataUpdate)) {
            return false;
        }

        $condiciones = [
            'claveCuerpo' => $info['claveCuerpo'],
            'anio' => $info['anio']
        ];

        if (!$this->AdminModel->generalUpdate('fases_investigaciones', $dataUpdate, $condiciones)) {
            return false;
        }

        return true;
    }

    private function getDateTime()
    {
        return date("Y-m-d H:i:s");
    }

    public function listaAdmin($red, $anio)
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

        //VAMOS A VER SI TIENE CARTA DE SESION DE DERECHOS

        $condiciones = [
            'red' => $red,
            'anio' => $anio,
            'tipo' => 'derechos'
        ];

        $is_cartaDerechos = $this->AdminModel->exist('cartas_inv',$condiciones);

        $data = [
            'nombre_tabla' => $tabla,
            'c_cuerpos' => $c_cuerpos,
            'c_encuestas' => $c_encuestas,
            'estado_0' => $estado_0,
            'estado_1' => $estado_1,
            'estado_2' => $estado_2,
            'estado_3' => $estado_3,
            'estado_4' => $estado_4,
            'estado_5' => $estado_5,
            'red' => $red,
            'anio' => $anio,
            'nombres_fases' => $this->nombres_fases,
            'is_cartaDerechos' => $is_cartaDerechos
        ];

        return view('admin/headers/index')
            . view('admin/investigaciones/lista', $data)
            . view('admin/footers/index');
    }

    public function getExcelEncuestasEquipo($tabla, $claveCuerpo)
    {

        if (session('is_logged') === false) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }
        $explode_tabla = explode('_', $tabla);
        $anio = $explode_tabla[2];
        $red = $explode_tabla[1];

        $columnas = ['pais'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $ca = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
        $pais = $ca['pais'];

        $preguntas = $this->getPreguntasEncuesta($anio, $red, $pais);

        $condiciones = ['claveCuerpo' => $claveCuerpo];

        $getAllEncuestas = $this->CuestionariosModel->getAll($tabla, $condiciones);

        $condiciones = ['nombre_red' => ucfirst($red)];
        $red_array = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $color = $red_array['color_primario'];

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

        foreach ($getAllEncuestas as $e) {
            $folio = $e['folio'];
            $estado = $this->getEstadoEncuesta($e['estado']);
            array_push($arr_respuestas, $folio);
            array_push($arr_respuestas, $estado);
            foreach ($preguntas as $p) {
                #$pregunta_solo_num = preg_replace('/[^0-9]/', '', $p['inciso']);
                if ($red == 'Relayn' && $anio == 2024) {
                    $arr_respuestas = $this->investigacionRelayn2024Excel($e, $p, $arr_respuestas);
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
        header('Content-Disposition: attachment;filename="Encuestas_' . $claveCuerpo . '_' . $anio . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function getExcelEncuestasEquipoValidas($tabla, $claveCuerpo)
    {

        if (session('is_logged') === false) {
            return redirect()->to(base_url())
                ->with('icon', 'warning')
                ->with('title', 'Opsss')
                ->with('text', 'Su sesión ha expirado, inicie sesión nuevamente');
        }

        $explode_tabla = explode('_', $tabla);
        $anio = $explode_tabla[2];
        $red = $explode_tabla[1];

        $tabla = strtolower($tabla);

        $columnas = ['pais'];
        $condiciones = ['claveCuerpo' => $claveCuerpo];
        $ca = $this->AdminModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);
        $pais = $ca['pais'];

        $preguntas = $this->getPreguntasEncuesta($anio, $red, $pais);

        $condiciones = ['claveCuerpo' => $claveCuerpo, 'estado' => 1];

        $getAllEncuestas = $this->CuestionariosModel->getAll($tabla, $condiciones);

        $condiciones = ['nombre_red' => ucfirst($red)];
        $red_array = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $color = $red_array['color_primario'];

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

        foreach ($getAllEncuestas as $e) {
            $folio = $e['folio'];
            $estado = $this->getEstadoEncuesta($e['estado']);
            array_push($arr_respuestas, $folio);
            array_push($arr_respuestas, $estado);
            foreach ($preguntas as $p) {
                #$pregunta_solo_num = preg_replace('/[^0-9]/', '', $p['inciso']);
                if ($red == 'Relayn' && $anio == 2024) {
                    $arr_respuestas = $this->investigacionRelayn2024Excel($e, $p, $arr_respuestas);
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
        header('Content-Disposition: attachment;filename="Encuestas_' . $claveCuerpo . '_' . $anio . '_validas.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function getListaInvestigacionesEquipos()
    {

        $columnas = [
            'id', 'claveCuerpo', 'esquema', 'f_impreso', 'r_impreso', 'f_digital', 'r_digital','red','anio'
        ];

        $tabla = 'fases_investigaciones';
        $red = $_POST['red'];
        $anio = $_POST['anio'];



        $dataSend = [
            'valor_buscado' => $_POST['search']['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $_POST['order'][0]['dir'],
            'start' => $_POST['start'],
            'length' => $_POST['length'],
            'order_column' => $_POST['order'][0]['column'],
            'where' => "{$tabla}.red = '{$red}' AND {$tabla}.anio = '{$anio}'"
        ];


        $serverSide = $this->generateServerSideTableMaster($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        $json_data = [
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $array
        ];

        echo json_encode($json_data);
    }

    public function revisionAdmin($red,$anio,$tipo,$claveCuerpo)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        $condiciones = [
            'red' => $red,
            'anio' => $anio,
            'claveCuerpo' => $claveCuerpo
        ];

        $phase = $this->AdminModel->getAllOneRow('fases_investigaciones', $condiciones);

        if (empty($phase)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $tabla = 'cuestionarios_' . strtolower($red) . '_' . $anio;

        $info = [
            'red' => $red,
            'anio' => $anio,
            'claveCuerpo' => $claveCuerpo,
            'tipo' => $tipo,
            'phase' => $phase,
            'tabla' => $tabla,
        ];

        $data = $this->getInfoVistaRevsion($info);

        if ($data === false) {
            throw PageNotFoundException::forPageNotFound();
        }

        $dataMerge = [
            'tipo' => $info['tipo'],
            'red' => $info['red'],
            'anio' => $info['anio'],
            'claveCuerpo' => $claveCuerpo
        ];

        $data = array_merge($dataMerge, $data);

        $fase_actual = $phase['f_' . $info['tipo']];

        return view('admin/headers/index')
            . view('admin/investigaciones/fases/fase_' . $fase_actual, $data)
            . view('admin/footers/index');
    }

    private function getInfoVistaRevsion($info)
    {

        $fase_actual = $info['phase']['f_' . $info['tipo']];
        $claveCuerpo = $info['claveCuerpo'];
        $tabla = $info['tabla'];

        if ($fase_actual == 1) {
            //Aqui vamos a obtenr los datos de la investigacion, este no distingue entre impreso o digital
            if (session('user_type') == 0) {
                session_destroy();
                return redirect()->to(base_url());
            }
            $condiciones = ['claveCuerpo' => $claveCuerpo];

            if (!$this->AdminModel->exist('cuerpos_academicos', $condiciones)) {
                echo 'No existe el cuerpo academico';
                return redirect()->back();
            }

            $anio = date('Y');
            $consulta = 'SELECT * FROM mensajes_CA WHERE claveCuerpo = "' . $claveCuerpo . '" AND fechaExpiracion LIKE "%' . $anio . '%"';
            $mensajes = $this->db_serv->query($consulta)->getResult();
            $mensajes = json_decode(json_encode($mensajes), true);

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

            $data = [
                'nombre_tabla' => $tabla,
                'claveCuerpo' => $claveCuerpo,
                'mensajes' => $mensajes,
                'estado_0' => $estado_0,
                'estado_1' => $estado_1,
                'estado_2' => $estado_2,
                'estado_3' => $estado_3,
                'estado_4' => $estado_4,
                'estado_5' => $estado_5,
            ];
        } else if ($fase_actual == 2) {
            //ES LA FASE DEL LOGO, HAY QUE TRAERNOS LA IMAGEN
            $condiciones = [
                'red' => $info['red'],
                'anio' => $info['anio'],
                'claveCuerpo' => $info['claveCuerpo'],
                'nombre' => 'logo'
            ];

            $logo = $this->AdminModel->getAllOneRow('archivos_inv', $condiciones);

            $imagen_base64 = base64_encode($logo['archivo']);

            $data = [
                'logo' => $imagen_base64
            ];
        } else {
            return false;
        }

        #DATA es una variable fija y global, no se puede redeclarar
        return $data;
    }

    public function updatePhaseAdmin()
    {

        $condiciones = [
            'red' => $_POST['red'],
            'anio' => $_POST['anio'],
            'claveCuerpo' => $_POST['claveCuerpo']
        ];
        $phase = $this->AdminModel->getAllOneRow('fases_investigaciones', $condiciones);

        if (empty($phase)) {
            http_response_code(600);
            return;
        }

        $fase_actual = $phase['f_' . $_POST['tipo']];

        $terminado = $_POST['terminado'];
        $next_fase = $terminado == 0 ? $fase_actual + 1 : $fase_actual;

        if ($fase_actual == 1) {
            //ESTA NO HAY DIFERENCIA ENTRE IMPRESO O DIGITAL, SON IGUAL LOS 2
            //PERO HAY QUE ACTUALIZAR DONDE SE DEBE
            if ($phase['esquema'] == 'B') {
                $dataUpdate = [
                    'r_impreso' => $terminado,
                    'f_impreso' => $next_fase,
                    'f_digital' => $next_fase,
                    'r_digital' => $terminado
                ];
            } else {
                $dataUpdate = [
                    'f_digital' => $next_fase,
                    'r_digital' => $terminado
                ];
            }
        } else if ($fase_actual == 2) {

            //Vamos a actualizar a la fecha cuando se valido
            $dataUpdate = [
                'fecha_validate' => $this->getDateTime(),
                'validado' => $terminado == 2 ? 0 : 1 
            ];
            $condiciones = [
                'red' => $_POST['red'],
                'anio' => $_POST['anio'],
                'claveCuerpo' => $_POST['claveCuerpo'],
                'nombre' => 'logo'
            ];

            $this->AdminModel->generalUpdate('archivos_inv', $dataUpdate, $condiciones);

            if ($phase['esquema'] == 'B') {
                $dataUpdate = [
                    'r_impreso' => $terminado,
                    'f_impreso' => $next_fase,
                    'f_digital' => $next_fase,
                    'r_digital' => $terminado
                ];
            } else {
                $dataUpdate = [
                    'f_digital' => $next_fase,
                    'r_digital' => $terminado
                ];
            }
        } else if ($fase_actual == 7){
            //Vamos a actualizar a la fecha cuando se valido
            $dataUpdate = [
                'fecha_validate' => $this->getDateTime(),
                'validado' => $terminado == 2 ? 0 : 1 
            ];
            $condiciones = [
                'red' => $_POST['red'],
                'anio' => $_POST['anio'],
                'claveCuerpo' => $_POST['claveCuerpo'],
                'nombre' => 'carta_derechos',
                'tipo' => $_POST['tipo']
            ];

            $this->AdminModel->generalUpdate('archivos_inv', $dataUpdate, $condiciones);

            if($terminado == 2){
                if($_POST['tipo'] == 'impreso'){
                    $dataUpdate = [
                        'r_impreso' => 2
                    ];
                }else if($_POST['tipo'] == 'digital'){
                    $dataUpdate = [
                        'r_digital' => 2
                    ];
                }
            }else{
                if($_POST['tipo'] == 'impreso'){
                    $dataUpdate = [
                        'f_impreso' => 8,
                        'r_impreso' => 0
                    ];
                }else if($_POST['tipo'] == 'digital'){
                    $dataUpdate = [
                        'f_digital' => 8,
                        'r_digital' => 0
                    ];
                }
            }

            

        }else if ($fase_actual == 8){
            //Vamos a actualizar a la fecha cuando se valido
            $dataUpdate = [
                'fecha_validate' => $this->getDateTime(),
                'validado' => $terminado == 2 ? 0 : 1 
            ];
            $condiciones = [
                'red' => $_POST['red'],
                'anio' => $_POST['anio'],
                'claveCuerpo' => $_POST['claveCuerpo'],
                'nombre' => 'carta_visto',
                'tipo' => $_POST['tipo']
            ];

            $this->AdminModel->generalUpdate('archivos_inv', $dataUpdate, $condiciones);

            if($terminado == 2){
                if($_POST['tipo'] == 'impreso'){
                    $dataUpdate = [
                        'r_impreso' => 2
                    ];
                }else if($_POST['tipo'] == 'digital'){
                    $dataUpdate = [
                        'r_digital' => 2
                    ];
                }
            }else{
                if($_POST['tipo'] == 'impreso'){
                    $dataUpdate = [
                        'f_impreso' => 9,
                        'r_impreso' => 0
                    ];
                }else if($_POST['tipo'] == 'digital'){
                    $dataUpdate = [
                        'f_digital' => 9,
                        'r_digital' => 0
                    ];
                }
            }

            

        }else {
            http_response_code(800);
            return;
        }

        $condiciones = [
            'red' => $_POST['red'],
            'anio' => $_POST['anio'],
            'claveCuerpo' => $_POST['claveCuerpo']
        ];

        $this->AdminModel->generalUpdate('fases_investigaciones', $dataUpdate, $condiciones);

        $claveCuerpo = $_POST['claveCuerpo'];

        $correos = $this->getCorreosGrupo($claveCuerpo);

        //mensaje de vuelta porque se lo devolvieron
        $red = ucfirst($_POST['red']);
        $condiciones = ['nombre_red' => $red];
        $info_red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $red_lower = strtolower($red);
        $red_upper = strtoupper($red);

        $nombre_fase = $this->nombres_fases[$next_fase][0];

        $corazon = "<span style='color: {$info_red['color_primario']}'>&#x2764;</span>";

        $subject = "Mensaje de la Investigación {$red_upper} {$_POST['anio']}";

        if(isset($_POST['mensaje'])){

            $html = "
            <p>
            Estimados investigadores e investigadoras del grupo <b>{$claveCuerpo}</b>
            </p>
            <p>
            El Equipo RedesLA informa que la fase <b>{$nombre_fase}</b> se ha sido <b>rechazada</b>. 
            Favor de atender las observaciones que se les indique.
            </p>
            <p>
            Observaciones:
            </p>
            <p>
            {$_POST['mensaje']}
            </p>

            <p>
            {$corazon} En {$red_upper} tenemos #PasiónPorLaInvestigación
            </p>
            <p>
            🤓  Manténgase actualizado: <a href='{$info_red['facebook']}'>{$info_red['facebook']}</a>
            </p>
            🌍 https://{$red_lower}.redesla.la 
            ";

            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
            $email->setTo($correos);
            $email->setSubject($subject);
            $email->setMessage($html);
    
            if (!$email->send()) {
                http_response_code(700);
                exit;
            }

            $mensaje_plano = "
            <p>
            Estimados investigadores e investigadoras del grupo <b>{$claveCuerpo}</b>
            </p>
            <p>
            El Equipo RedesLA informa que la fase <b>{$nombre_fase}</b> se ha sido rechazada. 
            Favor de atender las observaciones que se les indique.
            </p>
            <p>Observaciones:</p>
            <p>
            {$_POST['mensaje']}
            </p>
            ";

            $fecha_actual = date("Y-m-d");
            $fecha_expiracion = date("Y-m-d", strtotime($fecha_actual . "+ 7 days"));

            $data = [
                'claveCuerpo' => $claveCuerpo,
                'mensaje' => $mensaje_plano,
                'nivelAlerta' => $terminado == 0 ? 'success':'danger',
                'activo' => 1,
                'fechaExpiracion' => $fecha_expiracion
            ];

            $this->AdminModel->generalInsert('mensajes_ca',$data);

        }else{

            $nombre_fase_anterior = $this->nombres_fases[$next_fase-1][0];
            $html = "
            <p>
            Estimados investigadores e investigadoras del grupo <b>{$claveCuerpo}</b>
            </p>
            <p>
            El Equipo RedesLA informa que la fase <b>{$nombre_fase_anterior}</b> se ha sido aceptada. 
            Puede continuar con la siguente fase <b>{$nombre_fase}</b> en la <a href='".base_url()."'>plataforma de miembros RedesLA</a>
            </p>
            <p>
            {$corazon} En {$red_upper} tenemos #PasiónPorLaInvestigación
            </p>
            <p>
            🤓  Manténgase actualizado: <a href='{$info_red['facebook']}'>{$info_red['facebook']}</a>
            </p>
            🌍 https://{$red_lower}.redesla.la 
            ";

            $email = \Config\Services::email();
            $email->setFrom('atencion@redesla.la', 'Equipo REDESLA');
            $email->setTo($correos);
            $email->setSubject($subject);
            $email->setMessage($html);
    
            if (!$email->send()) {
                http_response_code(700);
                exit;
            }

            $mensaje_plano = "
            <p>
            Estimados investigadores e investigadoras del grupo <b>{$claveCuerpo}</b>
            </p>
            <p>
            El Equipo RedesLA informa que la fase <b>{$nombre_fase_anterior}</b> se ha sido aceptada.
            </p>
            <p>
            Puede continuar con la siguente fase <b>{$nombre_fase}</b>
            </p>
            ";

            $fecha_actual = date("Y-m-d");
            $fecha_expiracion = date("Y-m-d", strtotime($fecha_actual . "+ 7 days"));

            $data = [
                'claveCuerpo' => $claveCuerpo,
                'mensaje' => $mensaje_plano,
                'nivelAlerta' => $terminado == 0 ? 'success':'danger',
                'activo' => 1,
                'fechaExpiracion' => $fecha_expiracion
            ];

            $this->AdminModel->generalInsert('mensajes_ca',$data);
        }

        return json_encode(true);
    }

    private function getCorreosGrupo($claveCuerpo)
    {
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

        return $correos;
    }

    public function getMiembros()
    {
        $condiciones = ['cuerpoAcademico' => session('CA')];
        $columnas = ['usuario', 'especialidad', 'grado'];
        $miembros = $this->AdminModel->getAllColums($columnas, 'miembros', $condiciones);
        foreach ($miembros as $m) {
            $condiciones = ['usuario' => $m['usuario']];
            $usuario = $this->AdminModel->getAllOneRow('usuarios', $condiciones);
            $profile_pic = $usuario['profile_pic'] == null ? 'avatar.png' : $usuario['profile_pic'];
            $datos_miembro = $this->AdminModel->getAllOneRow('miembros', $condiciones);
            $condiciones = ['id' => $datos_miembro['grado']];
            $info_grado = $this->AdminModel->getAllOneRow('grado_academico', $condiciones);
            $str_academico = $info_grado['abreviatura'] . ' en ' . ucfirst($datos_miembro['especialidad']);
            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

            $data[] = [
                "value" => $m['usuario'],
                "name" => $nombre,
                "avatar" => base_url('resources/img/profiles/'.$profile_pic),
                "email" => $usuario['correo']
            ];

            /* $data[] = [
                'nombre' => $nombre,
                'profile_pic' => $profile_pic,
                'usuario' => $usuario['usuario'],
                'especialidad' => $str_academico
            ]; */
        }
        return $this->response->setJSON($data);
    }

    public function excelOrdenAutores($red, $anio)
    {
        //VAMOS A TRAER TODOS LOS ORDENES DE AUTORES

        //VAMOS A OBTENER LOS GRUPOS QUE TENGAN LA INVESTIGACION

        //vamos a obtenr el id de la investogacion
        $condiciones = [
            'nombre' => 'Esquema B: Investigación',
            'redCueCa' => $red,
            'anio' => $anio
        ];
        $columnas = ['id'];
        $id_esquema_b = $this->AdminModel->getColumnsOneRow($columnas, 'proyectos', $condiciones);

        $condiciones = [
            'nombre' => 'Esquema A: Investigación',
            'redCueCa' => $red,
            'anio' => $anio
        ];
        $columnas = ['id'];
        $id_esquema_a = $this->AdminModel->getColumnsOneRow($columnas, 'proyectos', $condiciones);

        $columna = ['claveCuerpo'];
        $condiciones = [
            'id_proyecto' => $id_esquema_a['id']
        ];
        $equipos_a = $this->AdminModel->getAllDistinc($columna, 'pagos', $condiciones);

        $columna = ['claveCuerpo'];
        $condiciones = [
            'id_proyecto' => $id_esquema_b['id']
        ];
        $equipos_b = $this->AdminModel->getAllDistinc($columna, 'pagos', $condiciones);

        $equipos = array_merge($equipos_a, $equipos_b);

        $condiciones = ['nombre_red' => ucfirst($red)];
        $red_array = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $color = $red_array['color_primario'];

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

        $headerExcel = ['Equipo', 'Nombre del autor(a)', 'Orden impreso', 'Orden digital'];

        $sheet->fromArray([$headerExcel], NULL, 'A1');
        $highestColumn = $sheet->getHighestColumn();
        $spreadsheet->getActiveSheet()->getStyle('A1:' . $highestColumn . '1')->applyFromArray($styleArray);

        $arr_respuestas = [];
        $inicio = 2;

        foreach ($equipos as $e) {
            $claveCuerpo = $e['claveCuerpo'];
            //vamos a traernos la info del equipo
            $condiciones = [
                'claveCuerpo' => $claveCuerpo,
                'red' => $red,
                'anio' => $anio
            ];

            $infoEquipo = $this->AdminModel->getAll('ordenes_autores', $condiciones);

            if (empty($infoEquipo)) {
                array_push($arr_respuestas, $claveCuerpo);
                array_push($arr_respuestas, 'El equipo aun no registra su orden de autores.');
                array_push($arr_respuestas, 'El equipo aun no registra su orden de autores.');
                array_push($arr_respuestas, 'El equipo aun no registra su orden de autores.');
                $sheet->fromArray([$arr_respuestas], NULL, 'A' . $inicio);
                $arr_respuestas = [];
                $inicio++;
            } else {
                foreach ($infoEquipo as $i) {
                    $usuario = $i['usuario'];
                    $columnas = ['nombre', 'ap_paterno', 'ap_materno'];
                    $condiciones = ['usuario' => $usuario];
                    $usuario = $this->AdminModel->getColumnsOneRow($columnas, 'usuarios', $condiciones);

                    $nombre_completo = empty($usuario['ap_materno']) ? $usuario['nombre'] . ' ' . $usuario['ap_paterno'] : $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

                    array_push($arr_respuestas, $claveCuerpo);
                    array_push($arr_respuestas, $nombre_completo);

                    if ($i['esquema'] == 'B') {
                        array_push($arr_respuestas, $i['orden_impreso']);
                        array_push($arr_respuestas, $i['orden_digital']);
                    } else {
                        array_push($arr_respuestas, 'No aplica por esquema');
                        array_push($arr_respuestas, $i['orden_digital']);
                    }
                    $sheet->fromArray([$arr_respuestas], NULL, 'A' . $inicio);
                    $arr_respuestas = [];
                    $inicio++;
                }
            }
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="orden_autores.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        $this->pre($equipos);
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
            'anio' => $explode_tabla[2],
            'pais' => 2
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

    }

    public function getExcelEncuestasValidas($tabla)
    {

        if (session('user_type') == 0) {
            session_destroy();
            return redirect()->to(base_url());
        }

        #HACEMOS LAS CONDICIONES PARA SACAR LAS PREGUNTAS DE LA INVESTIGACION
        $explode_tabla = explode('_', $tabla);
        $condiciones = [
            'red' => $explode_tabla[1],
            'anio' => $explode_tabla[2],
            'pais' => 2
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
        $condiciones = ['estado' => 1];
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

    public function subirPreliminar($red,$anio,$tipo){
        $file_name =  $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_tipe = $_FILES['file']['type'];
        $claveCuerpoFile = pathinfo($file_name, PATHINFO_FILENAME);
        //VAMOS A BUSCAR SI EXISTE EL NOMBRE EN LA BD
        //SE SUPONE QUE SI ESTAN POR SUBIR EL RESUMEN, EL LOGO YA ESTA LISTO Y POR LO TANTO
        //REGISTRO EL ARCHIVOS_INV

        $condiciones = [
            'claveCuerpo' => $claveCuerpoFile,
            'red' => $red,
            'anio' => $anio
        ];
        $exist = $this->AdminModel->exist('archivos_inv',$condiciones);

        if(!$exist){
            http_response_code(700);
            exit;
        }

        $fp = fopen($file_tmp, 'r+b');
        $binario = fread($fp, filesize($file_tmp));
        fclose($fp);

        //Existe ahora debemos comprobar si existe el archivo
        $condiciones = [
            'claveCuerpo' => $claveCuerpoFile,
            'red' => $red,
            'anio' => $anio,
            'nombre' => 'preliminar_'.$tipo
        ];

        $already_exist = $this->AdminModel->exist('archivos_inv',$condiciones);

        if($already_exist){
            //EL REGISTRO DEL ARCHIVO YA EXISTE, VAMOS A ACTUALIZARLO
            
            //VAMOS A OBTENER EL ID DE ESE REGISTRO
            $columnas = ['id'];
            $condiciones = [
                'claveCuerpo' => $claveCuerpoFile,
                'red' => $red,
                'anio' => $anio,
                'nombre' => 'preliminar_'.$tipo
            ];
            $id_archivo = $this->AdminModel->getColumnsOneRow($columnas,'archivos_inv',$condiciones);
            $id_archivo = $id_archivo['id'];
            
            $dataUpdate = [
                'archivo' => $binario,
                'fecha_update' => $this->getDateTime(),
                'fecha_validate' => $this->getDateTime(),
            ];
            $condiciones = [
                'id' => $id_archivo
            ];

            $this->AdminModel->generalUpdate('archivos_inv',$dataUpdate,$condiciones);

        }else{
            //EL REGISTRO DEL ARCHIVO NO EXISTE, VAMOS A INSERTARLO
            $dataInsert = [
                'claveCuerpo' => $claveCuerpoFile,
                'red' => $red,
                'anio' => $anio,
                'nombre' => 'preliminar_'.$tipo,
                'nombre_usuarios' => 'Capítulo '.$tipo.' preliminar',
                'tipo_archivo' => $file_tipe,
                'archivo' => $binario,
                'fecha_insert' => $this->getDateTime(),
                'fecha_update' => $this->getDateTime(),
                'fecha_validate' => $this->getDateTime(),
                'usuario' => 'admin',
                'validado' => 1
            ];

            $this->AdminModel->generalInsert('archivos_inv',$dataInsert);
        }

    }

    public function subirFinal($red,$anio,$tipo){
        $file_name =  $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_tipe = $_FILES['file']['type'];
        $claveCuerpoFile = pathinfo($file_name, PATHINFO_FILENAME);

        //VAMOS A BUSCAR SI EXISTE EL NOMBRE EN LA BD
        //SE SUPONE QUE SI ESTAN POR SUBIR EL RESUMEN, EL LOGO YA ESTA LISTO Y POR LO TANTO
        //REGISTRO EL ARCHIVOS_INV

        $condiciones = [
            'claveCuerpo' => $claveCuerpoFile,
            'red' => $red,
            'anio' => $anio
        ];
        $exist = $this->AdminModel->exist('archivos_inv',$condiciones);

        if(!$exist){
            http_response_code(700);
            exit;
        }

        $fp = fopen($file_tmp, 'r+b');
        $binario = fread($fp, filesize($file_tmp));
        fclose($fp);

        //Existe ahora debemos comprobar si existe el archivo
        $condiciones = [
            'claveCuerpo' => $claveCuerpoFile,
            'red' => $red,
            'anio' => $anio,
            'nombre' => 'final_'.$tipo
        ];

        $already_exist = $this->AdminModel->exist('archivos_inv',$condiciones);

        if($already_exist){
            //EL REGISTRO DEL ARCHIVO YA EXISTE, VAMOS A ACTUALIZARLO
            
            //VAMOS A OBTENER EL ID DE ESE REGISTRO
            $columnas = ['id'];
            $condiciones = [
                'claveCuerpo' => $claveCuerpoFile,
                'red' => $red,
                'anio' => $anio,
                'nombre' => 'final_'.$tipo
            ];
            $id_archivo = $this->AdminModel->getColumnsOneRow($columnas,'archivos_inv',$condiciones);
            $id_archivo = $id_archivo['id'];
            
            $dataUpdate = [
                'archivo' => $binario,
                'fecha_update' => $this->getDateTime(),
                'fecha_validate' => $this->getDateTime(),
            ];
            $condiciones = [
                'id' => $id_archivo
            ];

            $this->AdminModel->generalUpdate('archivos_inv',$dataUpdate,$condiciones);

        }else{
            //EL REGISTRO DEL ARCHIVO NO EXISTE, VAMOS A INSERTARLO
            $dataInsert = [
                'claveCuerpo' => $claveCuerpoFile,
                'red' => $red,
                'anio' => $anio,
                'nombre' => 'final_'.$tipo,
                'nombre_usuarios' => 'Capítulo '.$tipo.' final',
                'tipo_archivo' => $file_tipe,
                'archivo' => $binario,
                'fecha_insert' => $this->getDateTime(),
                'fecha_update' => $this->getDateTime(),
                'fecha_validate' => $this->getDateTime(),
                'usuario' => 'admin',
                'validado' => 1,
                'tipo' => $tipo
            ];

            $this->AdminModel->generalInsert('archivos_inv',$dataInsert);
        }

    }

    public function subirAgradecimientos($red,$anio,$tipo){
        $file_name =  $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_tipe = $_FILES['file']['type'];
        $claveCuerpoFile = pathinfo($file_name, PATHINFO_FILENAME);

        //VAMOS A BUSCAR SI EXISTE EL NOMBRE EN LA BD
        //SE SUPONE QUE SI ESTAN POR SUBIR EL RESUMEN, EL LOGO YA ESTA LISTO Y POR LO TANTO
        //REGISTRO EL ARCHIVOS_INV

        $condiciones = [
            'claveCuerpo' => $claveCuerpoFile,
            'red' => $red,
            'anio' => $anio
        ];
        $exist = $this->AdminModel->exist('archivos_inv',$condiciones);

        if(!$exist){
            http_response_code(700);
            exit;
        }

        $fp = fopen($file_tmp, 'r+b');
        $binario = fread($fp, filesize($file_tmp));
        fclose($fp);

        //Existe ahora debemos comprobar si existe el archivo
        $condiciones = [
            'claveCuerpo' => $claveCuerpoFile,
            'red' => $red,
            'anio' => $anio,
            'nombre' => 'agradecimientos_'.$tipo
        ];

        $already_exist = $this->AdminModel->exist('archivos_inv',$condiciones);

        if($already_exist){
            //EL REGISTRO DEL ARCHIVO YA EXISTE, VAMOS A ACTUALIZARLO
            
            //VAMOS A OBTENER EL ID DE ESE REGISTRO
            $columnas = ['id'];
            $condiciones = [
                'claveCuerpo' => $claveCuerpoFile,
                'red' => $red,
                'anio' => $anio,
                'nombre' => 'agradecimientos_'.$tipo
            ];
            $id_archivo = $this->AdminModel->getColumnsOneRow($columnas,'archivos_inv',$condiciones);
            $id_archivo = $id_archivo['id'];
            
            $dataUpdate = [
                'archivo' => $binario,
                'fecha_update' => $this->getDateTime(),
                'fecha_validate' => $this->getDateTime(),
            ];
            $condiciones = [
                'id' => $id_archivo
            ];

            $this->AdminModel->generalUpdate('archivos_inv',$dataUpdate,$condiciones);

        }else{
            //EL REGISTRO DEL ARCHIVO NO EXISTE, VAMOS A INSERTARLO
            $dataInsert = [
                'claveCuerpo' => $claveCuerpoFile,
                'red' => $red,
                'anio' => $anio,
                'nombre' => 'agradecimientos_'.$tipo,
                'nombre_usuarios' => 'Agradecimientos e índice - '.$tipo,
                'tipo_archivo' => $file_tipe,
                'archivo' => $binario,
                'fecha_insert' => $this->getDateTime(),
                'fecha_update' => $this->getDateTime(),
                'fecha_validate' => $this->getDateTime(),
                'usuario' => 'admin',
                'validado' => 1,
                'tipo' => $tipo
            ];

            $this->AdminModel->generalInsert('archivos_inv',$dataInsert);
        }

    }

    public function cartasInicio(){

        $columnas = ['nombre_red'];
        $redes = $this->AdminModel->getAllColums($columnas,'redes',[]);
        $data = [
            'redes' => $redes
        ];

        return view('admin/headers/index')
            . view('admin/investigaciones/cartas_derechos',$data)
            . view('admin/footers/index');
    }

    public function getListaCartas(){

        $columnas = [
            'id', 'tipo', 'red', 'anio', 'obra'
        ];

        $tabla = 'cartas_inv';

        $dataSend = [
            'valor_buscado' => $_POST['search']['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $_POST['order'][0]['dir'],
            'start' => $_POST['start'],
            'length' => $_POST['length'],
            'order_column' => $_POST['order'][0]['column'],
        ];


        $serverSide = $this->generateServerSideTableMaster($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        $json_data = [
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $array
        ];

        echo json_encode($json_data);

    }

    public function subirCartas(){

        $file_name =  $_FILES['molde']['name'];
        $file_tmp = $_FILES['molde']['tmp_name'];
        $file_tipe = $_FILES['molde']['type'];

        $red = $_POST['red'];
        $anio = $_POST['anio'];
        $obra = $_POST['obra'];
        $tipo = $_POST['tipo'];

        $ruta = $this->pathCartas($tipo,$red,$anio,$obra);

        if(move_uploaded_file($_FILES['molde']['tmp_name'], "{$ruta}")){
            $dataInsert = [
                'red' => $red,
                'anio' => $anio,
                'tipo' => $tipo,
                'obra' => $obra
            ];

            if(!$this->AdminModel->exist('cartas_inv',$dataInsert)){
                $this->AdminModel->generalInsert('cartas_inv',$dataInsert);
            }

            
        }

        return redirect()->back();
    }

    private function pathCartas($tipo,$red,$anio,$obra){
        return WRITEPATH . "uploads/investigacion/cartas/Carta_{$tipo}_{$red}_{$anio}_{$obra}.docx";
    }

    public function downloadDerechos($red,$anio,$obra,$tipo){
        //VAMOS A TOMAR LA CARTA DE SESION DE DERECHOS
        $nombre_archivo = "Carta_{$tipo}_{$red}_{$anio}_{$obra}.docx";
        $ruta_completo = $this->pathCartas($tipo,$red,$anio,$obra);

        if(!file_exists($ruta_completo)){
            echo 'No existe el archivo';
            exit;
        }
        // Establecer las cabeceras HTTP para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header("Content-Disposition: attachment; filename=$nombre_archivo");
        header('Content-Length: ' . filesize($ruta_completo));

        // Leer y enviar el contenido del archivo
        readfile($ruta_completo);
        exit;
    }

    public function generarCartaSesionDerechos($tipo,$anio,$obra){
        $red = session('red');
        $claveCuerpo = session('CA');

        //vamos a obtener el string para los autores
        $autores = $this->getOrdenAutores($claveCuerpo,$anio,$obra);

        $ruta_completo = $this->pathCartas($tipo,$red,$anio,$obra);

        if(!file_exists($ruta_completo)){
            return redirect()->back()
            ->with('icon', 'warning')
            ->with('title', 'Lo sentimos')
            ->with('text', 'La carta de cesión de derechos de la obra seleccionada aún no esta disponible.');
        }

        $templateProcessor  = new TemplateProcessor($ruta_completo);

        $templateProcessor->setValues([
            'autores' => $autores['str_autores'],
            'autor1' => isset($autores['autores'][0]['nombre']) ? $autores['autores'][0]['grado_academico']['abreviatura'].' '.$autores['autores'][0]['nombre'] : '',
            'autor2' => isset($autores['autores'][1]['nombre']) ? $autores['autores'][1]['grado_academico']['abreviatura'].' '.$autores['autores'][1]['nombre'] : '',
            'autor3' => isset($autores['autores'][2]['nombre']) ? $autores['autores'][2]['grado_academico']['abreviatura'].' '.$autores['autores'][2]['nombre'] : '',
            'autor4' => isset($autores['autores'][3]['nombre']) ? $autores['autores'][3]['grado_academico']['abreviatura'].' '.$autores['autores'][3]['nombre'] : ''
        ]);

        header("Content-Disposition: attachment; filename=Carta_sesion_derechos_{$claveCuerpo}_{$anio}.docx");
        $templateProcessor->saveAs('php://output');
    }

    private function getOrdenAutores($claveCuerpo,$anio,$tipo){
        $condiciones = [
            'claveCuerpo' => $claveCuerpo,
            'anio' => $anio,
        ];
        $columnas = ['orden_'.$tipo, 'usuario'];
        $orden_autores = $this->AdminModel->getAllColums($columnas,'ordenes_autores',$condiciones);

        // Clave por la que deseas ordenar (en este caso, 'orden_impreso')
        $tipo_orden_autores = 'orden_'.$tipo;
        // Obtener la columna de claves para ordenar
        $key_sort = array_column($orden_autores, $tipo_orden_autores);
        // Ordenar el array usando array_multisort
        array_multisort($key_sort, SORT_ASC, $orden_autores);

        $str_autores = '';

        foreach($orden_autores as $key => $o){
            $condiciones = ['usuario' => $o['usuario']];
            $columnas = ['nombre','ap_paterno','ap_materno'];
            $usuario = $this->AdminModel->getColumnsOneRow($columnas,'usuarios',$condiciones);

            $nombre = empty($usuario['ap_materno']) ? $usuario['nombre'].' '.$usuario['ap_paterno'] : $usuario['nombre'].' '.$usuario['ap_paterno'].' '.$usuario['ap_materno'];

            //VAMOS A OBTENER SU GRADO ACADEMICO
            $condiciones = ['usuario' => $o['usuario']];
            $columnas = ['grado'];
            $grado_id = $this->AdminModel->getColumnsOneRow($columnas,'miembros',$condiciones);

            $condiciones = [
                'id' => $grado_id
            ];
            $grado_academico = $this->AdminModel->getAllOneRow('grado_academico',$condiciones);

            $dataReturn['autores'][$key]['nombre'] = $nombre;
            $dataReturn['autores'][$key]['grado_academico'] = $grado_academico;

            if( ($key+1) == (count($orden_autores)) ){
                //El siguiente es el ultimo
                $str_autores .= ' y '.$nombre;
            }else if( ($key+1) == (count($orden_autores) - 1) ){
                $str_autores .= $nombre;
            }else{
                $str_autores .= $nombre.', ';
            }
        }

        $dataReturn['str_autores'] = $str_autores;

        return $dataReturn;

    }

    public function verCartaAdmin($red,$anio,$nombre,$claveCuerpo,$obra){
        
        $condiciones = [
            'claveCuerpo' => $claveCuerpo,
            'red' => $red,
            'anio' => $anio,
            'nombre' => $nombre,
            'tipo' => $obra
        ];
        $columnas = ['archivo'];

        $archivo = $this->AdminModel->getColumnsOneRow($columnas,'archivos_inv',$condiciones);

        $blob = $archivo['archivo'];

        // Establecer las cabeceras adecuadas para el tipo de archivo
        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->response->setHeader('Content-Disposition', 'inline; filename=Carta de sesion de derechos - '.$claveCuerpo.'.pdf');

        // Imprimir el contenido del archivo blob
        echo $blob;

    }

    public function descargarTodoArhivos($red,$anio){
        //VAMOS A HACER CARPETAS CON ESOS DATOS Y VAMOS A CREARLAS
        $condiciones = [
            'red' => $red,
            'anio' => $anio
        ];
        $columnas = ['claveCuerpo','esquema'];

        $equipos = $this->AdminModel->getAllColums($columnas,'fases_investigaciones',$condiciones);

        if(empty($equipos)){
            echo '404';
            exit;
        }


        $zip = new ZipArchive();
        $zipFileName = "Archivos_investigacion_{$red}_{$anio}.zip";

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            //VAMOS A OBTENER TODOS LOS EQUIPOS
            
            foreach($equipos as $e){
                $claveCuerpo = $e['claveCuerpo'];

                $zip->addEmptyDir($claveCuerpo);
                
                
                $condiciones = [
                    'claveCuerpo' => $claveCuerpo,
                    'red' => $red,
                    'anio' => $anio,
                    'usuario !=' => 'admin'
                ];

                $archivos_equipo = $this->AdminModel->getAll('archivos_inv',$condiciones);

                foreach($archivos_equipo as $file){
                    
                    $blobFile = $file['archivo'];
                    $typeFile = $file['tipo_archivo'];
                    $nameFile = $file['nombre'];
                    $userNameFile = $file['nombre_usuarios'];
                    
                    $extension = $nameFile == 'logo' ? '.png' : '.pdf';

                    $fileFinal = $userNameFile.$extension;
                    $rutaZip = "$claveCuerpo/{$fileFinal}";
                    
                    if(!$zip->addFromString($rutaZip, $blobFile)){
                        echo 'fail';
                    }

                    
                }

                $fileOrdenDigital = 'Orden_digital.txt';
                $strOrdenDigital = '';
                $autores_digital = $this->getOrdenAutores($claveCuerpo,$anio,'digital');

                foreach($autores_digital['autores'] as $keyOrden=>$a){
                    $strOrdenDigital .= $keyOrden+1 . '.- '.$a['nombre']."\n";
                }
                $pathDigital = $claveCuerpo.'/'.$fileOrdenDigital;

                file_put_contents($fileOrdenDigital, $strOrdenDigital);
                $zip->addFile($fileOrdenDigital, $pathDigital);

                if($e['esquema'] == 'B'){
                    $fileOrdenImpreso = 'Orden_impreso.txt';
                    $strOrdenImpreso = '';
                    $autores_impreso = $this->getOrdenAutores($claveCuerpo,$anio,'impreso');

                    foreach($autores_impreso['autores'] as $keyOrden=>$a){
                        $strOrdenImpreso .= $keyOrden+1 . '.- '.$a['nombre']."\n";
                    }
                    $pathImpreso = $claveCuerpo.'/'.$fileOrdenImpreso;

                    file_put_contents($fileOrdenImpreso, $strOrdenImpreso);
                    $zip->addFile($fileOrdenImpreso, $pathImpreso);
                    
                }

            }
            $zip->close();
            $this->response->setHeader('Content-Type', 'application/zip');
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $zipFileName . '"');
            //$this->response->setHeader('Content-Length', filesize($zipFileName));
            readfile($zipFileName);
            unlink($zipFileName);

        }

    }

    public function marcajesInicio(){

        $condiciones = [
            'nombre' => 'marcaje',
            'atendido !=' => 1
        ];

        $c_marcajes_pendientes = $this->AdminModel->count('archivos_inv',$condiciones);

        $data = [
            'c_marcajes_pendientes' => $c_marcajes_pendientes
        ];

        return view('admin/headers/index')
            . view('admin/investigaciones/marcajes',$data)
            . view('admin/footers/index');
    }

    public function getListaMarcajes(){

        $columnas = [
            'id', 'claveCuerpo', 'red', 'anio', 'tipo','nombre','atendido'
        ];

        $tabla = 'archivos_inv';

        $dataSend = [
            'valor_buscado' => $_POST['search']['value'], #VALOR A BUSCAR
            'columnas' => $columnas,
            'tabla' => $tabla,
            'dir' => $_POST['order'][0]['dir'],
            'start' => $_POST['start'],
            'length' => $_POST['length'],
            'order_column' => $_POST['order'][0]['column'],
            'where' => "{$tabla}.nombre = 'marcaje'"
        ];


        $serverSide = $this->generateServerSideTableMaster($dataSend);

        $array = $serverSide['array'];
        $total_count = $serverSide['total_count'];

        $json_data = [
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $array
        ];

        echo json_encode($json_data);
    }

    public function verMarcaje($id){

        $condiciones = [
            'id' => $id 
        ];
        $columnas = ['archivo','claveCuerpo'];

        $archivo = $this->AdminModel->getColumnsOneRow($columnas,'archivos_inv',$condiciones);

        $blob = $archivo['archivo'];

        // Establecer las cabeceras adecuadas para el tipo de archivo
        $this->response->setHeader('Content-Type', 'application/pdf');
        $this->response->setHeader('Content-Disposition', 'inline; filename=Marcaje - '.$archivo['claveCuerpo'].'.pdf');

        // Imprimir el contenido del archivo blob
        echo $blob;
    }

    public function updateMarcaje(){
        
        $atendido = $_POST['atendido'];
        $claveCuerpo = $_POST['claveCuerpo'];
        $anio = $_POST['anio'];
        $red = $_POST['red'];
        $tipo = $_POST['tipo'];

        if($atendido == 1){
            //VAMOS A ACTUALIZAR EL ARCHIVO
            $file_tmp = $_FILES['archivo']['tmp_name'];
            $file_type = $_FILES['archivo']['type'];
            $fp = fopen($file_tmp, 'r+b');
            $binario = fread($fp, filesize($file_tmp));
            fclose($fp);

            $dataUpdateCartaDerechos = [
                'archivo' => $binario,
                'fecha_update' => $this->getDateTime(),
                'tipo_archivo' => $file_type,
                'atendido' => $atendido
            ];

            $condiciones = [
                'claveCuerpo' => $claveCuerpo,
                'anio' => $anio,
                'red' => $red,
                'nombre' => 'final_'.$tipo,
                'tipo' => $tipo
            ];
            $this->AdminModel->generalUpdate('archivos_inv', $dataUpdateCartaDerechos, $condiciones);

            $dataUpdateCartaDerechos = [
                'atendido' => $atendido
            ];

            $condiciones = [
                'claveCuerpo' => $claveCuerpo,
                'anio' => $anio,
                'red' => $red,
                'nombre' => 'marcaje',
                'tipo' => $tipo
            ];

            $this->AdminModel->generalUpdate('archivos_inv', $dataUpdateCartaDerechos, $condiciones);

        }else if($atendido == 2){
            //RECHAZADO
            $dataUpdateCartaDerechos = [
                'atendido' => $atendido
            ];

            $condiciones = [
                'claveCuerpo' => $claveCuerpo,
                'anio' => $anio,
                'red' => $red,
                'nombre' => 'marcaje',
                'tipo' => $tipo
            ];

            $this->AdminModel->generalUpdate('archivos_inv', $dataUpdateCartaDerechos, $condiciones);
        }

        return json_encode(true);

    }

    public function bd2($red,$anio,$obra){
        
        $condiciones = [
            'red' => $red,
            'anio' => $anio
        ];

        $dataExcel = [];

        $equipos = $this->AdminModel->getAll('fases_investigaciones',$condiciones);

        foreach($equipos as $key=>$e){

            $claveCuerpo = $e['claveCuerpo'];

            //Vamos a traernos los datos de la ubicacion

            $datos_universidad = $this->AdminModel->datos_universidad($claveCuerpo);

            $condiciones = ['claveCuerpo' => $claveCuerpo];
            $columnas = ['nombre_municipio'];
            $municipios_extra = $this->AdminModel->getAllColums($columnas,'municipios_ca',$condiciones);

            $str_municipios = $datos_universidad['municipio'];
            if(!empty($municipios_extra)){

                foreach($municipios_extra as $keyMun => $m){
                    $nombre_municipio = $m['nombre_municipio'];
                    $str_municipios .= ', '.$nombre_municipio;
                }

            }

            $dataExcel[$key] = [
                'claveCuerpo' => $claveCuerpo,
                'universidad' => $datos_universidad['nombre'],
                'pais' => $datos_universidad['pais'],
                'estado' => $datos_universidad['estado'],
                'municipios' => $str_municipios,
            ];

            $orden_digital = $this->getOrdenAutores($claveCuerpo,$anio,'digital');

            foreach($orden_digital['autores'] as $keyod => $od){
                $nombre = $od['nombre'];
                $newKey = $keyod+1;
                $n_key = "N{$newKey}_digital";
                $dataExcel[$key][$n_key] = $nombre;
            }

            $condiciones = [
                'claveCuerpo' => $claveCuerpo,
                'red' => $red,
                'anio' => $anio,
                'obra' => 'digital'
            ];
            $columnas = ['nombre','obra','texto'];
            $redacciones_inv_digital = $this->AdminModel->getAll('redacciones_inv',$condiciones);

            foreach($redacciones_inv_digital as $rd){
                $nombre_key = ucfirst($rd['nombre']).'_digital';
                $texto = $rd['texto'];
                if($rd['nombre'] == 'palabras_clave'){
                    $texto = str_replace('~',',',$texto);
                }
                $dataExcel[$key][$nombre_key] = $texto;
            }

            if($obra == 'impreso'){
                $autores_impreso = $this->getOrdenAutores($claveCuerpo,$anio,'impreso');
                foreach($autores_impreso['autores'] as $keyoi => $oi){
                    $nombre = $oi['nombre'];
                    $newKey = $keyoi+1;
                    $n_key = "N{$newKey}_impreso";
                    $dataExcel[$key][$n_key] = $nombre;
                }

                $condiciones = [
                    'claveCuerpo' => $claveCuerpo,
                    'red' => $red,
                    'anio' => $anio,
                    'obra' => 'impreso'
                ];
                $columnas = ['nombre','obra','texto'];
                $redacciones_inv_impreso = $this->AdminModel->getAll('redacciones_inv',$condiciones);
    
                foreach($redacciones_inv_impreso as $ri){
                    $nombre_key = ucfirst($ri['nombre']).'_impreso';
                    $texto = $ri['texto'];
                    if($ri['nombre'] == 'palabras_clave'){
                        $texto = str_replace('~',',',$texto);
                    }
                    $dataExcel[$key][$nombre_key] = $texto;
                }
            }

        }

        usort($dataExcel,array($this,'ordenarEstadoMunPaisBd2'));

        #$this->pre($dataExcel);

        $condiciones = ['nombre_red' => $red];
        $red = $this->AdminModel->getAllOneRow('redes', $condiciones);

        $color = $red['color_primario'];

        $color = str_replace('#', '', $color);
        $color = strtoupper($color);

        $headerExcel = [];

        if($obra == 'impreso'){
            $headerExcel = [
                'ID','Clave','Pais','Estado','Municipio(s)','Universidad','N1_impreso','N2_impreso','N3_impreso','N4_impreso','N1_digital','N2_digital','N3_digital','N4_digital','Habitantes','Empresas','Servicio','Comercio','Industria','Resumen_impreso','Resumen_digital','Palabras_clave_impreso','Palabras_clave_digital','Discusion_impreso','Discusion_digital'
            ];
        }else if($obra == 'digital'){
            $headerExcel = [
                'ID','Clave','Pais','Estado','Municipio(s)','Universidad','N1_digital','N2_digital','N3_digital','N4_digital','Habitantes','Empresas','Servicio','Comercio','Industria','Resumen_digital','Palabras_clave_digital','Discusion_digital'
            ];
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


        if($obra == 'impreso'){
            $arr_respuestas = [];
            $inicio = 2;
            foreach ($dataExcel as $keyRes => $c) {
                //TENGO QUE AGREGAR EN UN ARRAY NUMERICO EN SU POSICION, ESTO VA A SER DEPENDIENDO LA OBRA
                array_push($arr_respuestas, $keyRes+1);
                array_push($arr_respuestas, $c['claveCuerpo']);
                array_push($arr_respuestas, $c['pais']);
                array_push($arr_respuestas, $c['estado']);
                array_push($arr_respuestas, $c['municipios']);
                array_push($arr_respuestas, $c['universidad']);

                array_push($arr_respuestas, isset($c['N1_impreso']) ? $c['N1_impreso'] : '' );
                array_push($arr_respuestas, isset($c['N2_impreso']) ? $c['N2_impreso'] : '' );
                array_push($arr_respuestas, isset($c['N3_impreso']) ? $c['N3_impreso'] : '' );
                array_push($arr_respuestas, isset($c['N4_impreso']) ? $c['N4_impreso'] : '' );

                array_push($arr_respuestas, isset($c['N1_digital']) ? $c['N1_digital'] : '' );
                array_push($arr_respuestas, isset($c['N2_digital']) ? $c['N2_digital'] : '' );
                array_push($arr_respuestas, isset($c['N3_digital']) ? $c['N3_digital'] : '' );
                array_push($arr_respuestas, isset($c['N4_digital']) ? $c['N4_digital'] : '' );

                array_push($arr_respuestas, ''); #Habitantes
                array_push($arr_respuestas, ''); #Empresas
                array_push($arr_respuestas, ''); #Servicio
                array_push($arr_respuestas, ''); #Comercio
                array_push($arr_respuestas, ''); #Industria

                array_push($arr_respuestas, isset($c['Resumen_impreso']) ? $c['Resumen_impreso'] : 'Pendiente' );
                array_push($arr_respuestas, isset($c['Resumen_digital']) ? $c['Resumen_digital'] : 'Pendiente' );
                array_push($arr_respuestas, isset($c['Palabras_clave_impreso']) ? $c['Palabras_clave_impreso'] : 'Pendiente' );
                array_push($arr_respuestas, isset($c['Palabras_clave_digital']) ? $c['Palabras_clave_digital'] : 'Pendiente' );
                array_push($arr_respuestas, isset($c['Discusion_impreso']) ? $c['Discusion_impreso'] : 'Pendiente' );
                array_push($arr_respuestas, isset($c['Discusion_digital']) ? $c['Discusion_digital'] : 'Pendiente' );

                $sheet->fromArray([$arr_respuestas], NULL, 'A' . $inicio);
                $arr_respuestas = [];
                $inicio++;
            }
        }else if($obra == 'digital'){
            $arr_respuestas = [];
            $inicio = 2;
            foreach ($dataExcel as $keyRes => $c) {
                //TENGO QUE AGREGAR EN UN ARRAY NUMERICO EN SU POSICION, ESTO VA A SER DEPENDIENDO LA OBRA
                array_push($arr_respuestas, $keyRes+1);
                array_push($arr_respuestas, $c['claveCuerpo']);
                array_push($arr_respuestas, $c['pais']);
                array_push($arr_respuestas, $c['estado']);
                array_push($arr_respuestas, $c['municipios']);
                array_push($arr_respuestas, $c['universidad']);

                array_push($arr_respuestas, isset($c['N1_digital']) ? $c['N1_digital'] : '' );
                array_push($arr_respuestas, isset($c['N2_digital']) ? $c['N2_digital'] : '' );
                array_push($arr_respuestas, isset($c['N3_digital']) ? $c['N3_digital'] : '' );
                array_push($arr_respuestas, isset($c['N4_digital']) ? $c['N4_digital'] : '' );

                array_push($arr_respuestas, ''); #Habitantes
                array_push($arr_respuestas, ''); #Empresas
                array_push($arr_respuestas, ''); #Servicio
                array_push($arr_respuestas, ''); #Comercio
                array_push($arr_respuestas, ''); #Industria

                array_push($arr_respuestas, $c['Resumen_digital']);
                array_push($arr_respuestas, $c['Palabras_clave_digital']);
                array_push($arr_respuestas, $c['Discusion_digital']);

                $sheet->fromArray([$arr_respuestas], NULL, 'A' . $inicio);
                $arr_respuestas = [];
                $inicio++;
            }
        }
        

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setWidth(15);
        }


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="BD2_obra_'.$obra.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    private function ordenarEstadoMunPaisBd2($a, $b) {
        // Primero, comparamos por estado
        $estadoA = $a['estado'];
        $estadoB = $b['estado'];

        if ($estadoA !== $estadoB) {
            return strcmp($estadoA, $estadoB);
        }

        // Si los estados son iguales, comparamos por municipios
        $municipiosA = $a['municipios'];
        $municipiosB = $b['municipios'];

        if ($municipiosA !== $municipiosB) {
            return strcmp($municipiosA, $municipiosB);
        }

        // Si los municipios son iguales, comparamos por país
        $paisA = $a['pais'];
        $paisB = $b['pais'];

        return strcmp($paisA, $paisB);
    }

}
