<?php

namespace App\Controllers;

require_once 'vendor/autoload.php';

use App\Models\AdminModel;
use App\Models\IquatroModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Response;

class ApiController extends BaseController
{
    public $AdminModel;
    //public $IquatroModel;

    public function __construct()
    {
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        //$db = db_connect('iquatro');
        $this->AdminModel = new AdminModel();
        //$this->IquatroModel = new IquatroModel($db);

    }

    public function getLibros()
    {

        $config = $this->request->getJSON();
        $info = json_decode(json_encode($config), true);

        $red = $info['red'];

        $condiciones = [
            'red' => $red,
            'editorial !=' => 4
        ];

        if ($info['red'] == '') {
            unset($condiciones['red']);
        }

        if ($info['tipo'] != 'na') {
            switch ($info['tipo']) {
                case 'impresos':
                    $tipo_seleccionado = 'Impreso';
                    break;
                case 'digitales':
                    $tipo_seleccionado = 'Digital';
                    break;
                default:
                    http_response_code(500);
                    break;
            }
            $condiciones['formato'] = $tipo_seleccionado;
        }

        $columas = ['id', 'nombre', 'carpeta', 'anio', 'editorial', 'red', 'paginas', 'doi'];

        $libros = $this->AdminModel->getAllColums($columas, 'libros', $condiciones);

        //Vamos a formatear la informacion

        foreach ($libros as $key => $l) {

            $red = $info['red'] == 'todos' ? $l['red'] : $red;
            //Vamos a obtener el nombre de la editorial
            $editorial = $l['editorial'];
            $columnasEditorial = ['nombre'];
            $condicionesEditorial = ['id' => $editorial];
            $infoEditorial = $this->AdminModel->getColumnsOneRow($columnasEditorial, 'editoriales', $condicionesEditorial);

            if (!empty($infoEditorial)) {
                $libros[$key]['editorial'] = $infoEditorial['nombre'];
            }

            //VERIFICAMOS LA EXISTENCIA DE LOS ARCHIVOS

            $libro_exist = '';
            $dictamen_exist = '';
            $status = '';

            if ($l['carpeta'] == '') {
                $img = null;
                $status = 0;
            } else {

                //VAMOS A VERIFICAR LA EXISTENCIA DE CADA ARCHIVO IMPORTANTE

                $ruta_libro = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/libro.pdf';

                if (!file_exists($ruta_libro)) {
                    $libro_exist = null;
                }

                $ruta_dictamen = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/dictamen.pdf';
                if (!file_exists($ruta_dictamen)) {
                    $dictamen_exist = null;
                }


                $ruta_imagen = WRITEPATH . 'uploads/libros/' . $l['red'] . '/' . $l['anio'] . '/' . $l['carpeta'] . '/portada.png';

                if (!file_exists($ruta_imagen)) {
                    $ruta_imagen = WRITEPATH . 'uploads/libros/404.png';
                    $imgData = file_get_contents($ruta_imagen);
                    $base_64_cover = base64_encode($imgData);
                    $img = $base_64_cover;
                } else {
                    $imgData = file_get_contents($ruta_imagen);
                    $base_64_cover = base64_encode($imgData);
                    $img = $base_64_cover;
                }
            }

            $libros[$key]['portada'] = $img;
        }

        $key_sort3  = array_column($libros, 'anio');
        array_multisort($key_sort3, SORT_DESC, $libros);

        return $this->response->setHeader('Content-Type', 'application/json')->setJSON($libros);
    }

    public function getLibro()
    {
        $config = $this->request->getJSON();
        $info = json_decode(json_encode($config), true);

        $red = $info['red'];

        $condiciones = [
            'red' => $info['red'],
            'id' => $info['id']
        ];

        $libro = $this->AdminModel->getAllOneRow('libros', $condiciones);

        if(empty($libro)){
            $errorHandle = [
                'error' => 404
            ];
            return $this->response->setHeader('Content-Type', 'application/json')->setJSON($errorHandle);
        }

        if ($libro['carpeta'] == '') {
            $img = null;
            $status = 0;
        } else {

            //VAMOS A VERIFICAR LA EXISTENCIA DE CADA ARCHIVO IMPORTANTE

            $ruta_libro = WRITEPATH . 'uploads/libros/' . $red . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/libro.pdf';

            if (!file_exists($ruta_libro)) {
                $libro_exist = null;
            }else{
                $pdfContent = file_get_contents($ruta_libro);
                // Convierte el contenido a base64
                $base64Data = base64_encode($pdfContent);
                $libro['base64Data'] = $base64Data;
            }

            $is_dictamen = false;

            $ruta_dictamen = WRITEPATH . 'uploads/libros/' . $red . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/dictamen.pdf';

            $is_dictamen = !file_exists($ruta_dictamen) ? false : true;

            if (file_exists($ruta_dictamen)) {
                //HAY QUE HACER EL LINK PARA QUE DESCARGUE EL ARCHIVO
                $dictamenPdfPathDownloader = base_url() . '/api/biblioteca/download/dictamen/' . $red . '/' . $libro['anio'] . '/' . $libro['carpeta'];
                $libro['dictamenPdfPathDownloader'] = $dictamenPdfPathDownloader;
            }




            $ruta_imagen = WRITEPATH . 'uploads/libros/' . $red . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/portada.png';

            if (!file_exists($ruta_imagen)) {
                $ruta_imagen = WRITEPATH . 'uploads/libros/404.png';
                $imgData = file_get_contents($ruta_imagen);
                $base_64_cover = base64_encode($imgData);
                $img = $base_64_cover;
            } else {
                $imgData = file_get_contents($ruta_imagen);
                $base_64_cover = base64_encode($imgData);
                $img = $base_64_cover;
            }
        }

        $libroPdfPathVisualizer = base_url() . '/api/biblioteca/visualizador/' . $red . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/libro.pdf';

        $editorial = $libro['editorial'];
        $columnasEditorial = ['nombre'];
        $condicionesEditorial = ['id' => $editorial];
        $infoEditorial = $this->AdminModel->getColumnsOneRow($columnasEditorial, 'editoriales', $condicionesEditorial);

        if (!empty($infoEditorial)) {
            $libro['editorial'] = $infoEditorial['nombre'];
        }

        $libro['portada'] = $img;
        $libro['libroPdfPathVisualizer'] = $libroPdfPathVisualizer;
        $libro['is_dictamen'] = $is_dictamen;

        return $this->response->setHeader('Content-Type', 'application/json')->setJSON($libro);
    }

    public function visualizador($red, $anio, $carpeta)
    {
        if (!$carpeta) {
            $img = $this->request->getGet('img');
        }

        if ($carpeta == '') {
            throw PageNotFoundException::forPageNotFound();
        }

        $name = WRITEPATH . 'uploads/libros/' . $red . '/' . $anio . '/' . $carpeta . '/libro.pdf';

        if (!file_exists($name)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $fp = fopen($name, 'rb');

        header('Content-Type: application/pdf');

        #ENVIA LAS CABECERAS CORRECTAS

        header('Content-Length: ' . filesize($name));

        #VUELCA LA IMAGEN Y DETIENE EL SCRIPT
        fpassthru($fp);
        exit;
    }

    public function visualizador_cap($red, $anio, $carpeta, $capitulo)
    {
        if (!$carpeta) {
            $img = $this->request->getGet('img');
        }

        if ($carpeta == '') {
            throw PageNotFoundException::forPageNotFound();
        }

        $name = WRITEPATH . 'uploads/libros/' . $red . '/' . $anio . '/' . $carpeta . '/capitulos/capitulo_' . $capitulo . '.pdf';

        if (!file_exists($name)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $fp = fopen($name, 'rb');

        header('Content-Type: application/pdf');

        #ENVIA LAS CABECERAS CORRECTAS

        header('Content-Length: ' . filesize($name));

        #VUELCA LA IMAGEN Y DETIENE EL SCRIPT
        fpassthru($fp);
        exit;
    }

    public function getRecomendacionesLibros()
    {
        $config = $this->request->getJSON();
        $info = json_decode(json_encode($config), true);

        $red = $info['red'];
        $id_libro = $info['id'];

        $condiciones = [
            'red' => $red,
            'editorial !=' => 4
        ];

        $columas = ['id', 'nombre', 'carpeta', 'anio', 'editorial', 'red'];

        $libros = $this->AdminModel->getRandomRows('libros', $columas, $condiciones, 4);

        foreach ($libros as $key => $l) {

            $red = $info['red'] == 'todos' ? $l['red'] : $red;
            //Vamos a obtener el nombre de la editorial
            $editorial = $l['editorial'];
            $columnasEditorial = ['nombre'];
            $condicionesEditorial = ['id' => $editorial];
            $infoEditorial = $this->AdminModel->getColumnsOneRow($columnasEditorial, 'editoriales', $condicionesEditorial);

            if (!empty($infoEditorial)) {
                $libros[$key]['editorial'] = $infoEditorial['nombre'];
            }

            //VERIFICAMOS LA EXISTENCIA DE LOS ARCHIVOS

            $libro_exist = '';
            $dictamen_exist = '';
            $status = '';

            if ($l['carpeta'] == '') {
                $img = null;
                $status = 0;
            } else {

                //VAMOS A VERIFICAR LA EXISTENCIA DE CADA ARCHIVO IMPORTANTE

                $ruta_libro = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/libro.pdf';

                if (!file_exists($ruta_libro)) {
                    $libro_exist = null;
                }

                $ruta_dictamen = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/dictamen.pdf';
                if (!file_exists($ruta_dictamen)) {
                    $dictamen_exist = null;
                }


                $ruta_imagen = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/portada.png';

                if (!file_exists($ruta_imagen)) {
                    $ruta_imagen = WRITEPATH . 'uploads/libros/404.png';
                    $imgData = file_get_contents($ruta_imagen);
                    $base_64_cover = base64_encode($imgData);
                    $img = $base_64_cover;
                } else {
                    $imgData = file_get_contents($ruta_imagen);
                    $base_64_cover = base64_encode($imgData);
                    $img = $base_64_cover;
                }
            }

            $libros[$key]['portada'] = $img;
        }

        return $this->response->setHeader('Content-Type', 'application/json')->setJSON($libros);
    }

    public function getCapitulosLibros()
    {

        $config = $this->request->getJSON();
        $info = json_decode(json_encode($config), true);

        $id = $info['id'];
        $condiciones = ['id_libro' => $id];
        $capitulos = $this->AdminModel->getAll('indices_libros', $condiciones);



        foreach ($capitulos as $key => $c) {
            //$ruta = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'].'/'.$libro['carpeta'].'/capitulos/capitulo_'.$indice_libro['capitulo'].'.pdf';
            $i = 1;
            while ($i <= 4) {
                $columna = 'autor_' . $i;
                $capitulos[$key]['autores'][$i] = $c[$columna];
                unset($capitulos[$key][$columna]);
                $i++;
            }

            //VAMOS A TRAERNOS DATOS DEL LIBRO
            $columnas = ['red', 'anio', 'carpeta'];
            $condiciones = ['id' => $c['id_libro']];
            $libro = $this->AdminModel->getColumnsOneRow($columnas, 'libros', $condiciones);

            $ruta = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/capitulos/capitulo_' . $c['capitulo'] . '.pdf';
            //$libroPdfPathVisualizer = base_url() . '/api/biblioteca/visualizador_cap/' . $libro['red'].'/'.$libro['anio'].'/'.$libro['carpeta'].'/capitulos/capitulo_'.$c['capitulo'].'.pdf';
            $libroPdfPathVisualizer = base_url() . '/api/biblioteca/visualizador_cap/' . $libro['red'] . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/' . $c['capitulo'];

            if (file_exists($ruta)) {
                //existe
                $capitulos[$key]['pdf'] = true;
                $capitulos[$key]['url'] = $libroPdfPathVisualizer;
            } else {
                //no
                $capitulos[$key]['pdf'] = false;
            }
        }

        return $this->response->setHeader('Content-Type', 'application/json')->setJSON($capitulos);
    }

    public function download_files($case, $red, $anio, $carpeta)
    {
        if (!$carpeta) {
            $img = $this->request->getGet('img');
        }

        if ($carpeta == '') {
            throw PageNotFoundException::forPageNotFound();
        }

        switch ($case) {
            case 'dictamen':
                $name = WRITEPATH . 'uploads/libros/' . $red . '/' . $anio . '/' . $carpeta . '/dictamen.pdf';
                break;
            default:
                throw PageNotFoundException::forPageNotFound();
                break;
        }

        if (!file_exists($name)) {
            throw PageNotFoundException::forPageNotFound();
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="dictamen.pdf"');

        #ENVIA LAS CABECERAS CORRECTAS
        header('Content-Length: ' . filesize($name));

        #VUELCA EL ARCHIVO Y DETIENE EL SCRIPT
        readfile($name);
        exit;
    }

    public function download_book(){
        $config = $this->request->getJSON();
        $info = json_decode(json_encode($config), true);

        $condiciones = [
            'id' => $info['bookid']
        ];

        $libro = $this->AdminModel->getAllOneRow('libros',$condiciones);

        $filePath = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/libro.pdf';

        if(file_exists($filePath)){
            $pdfContent = file_get_contents($filePath);
            // Convierte el contenido a base64
            $base64Data = base64_encode($pdfContent);

            $arr = [
                'status' => true
            ];

        }else{
            $arr = [
                'status' => false
            ];
        }
        return $this->response->setHeader('Content-Type', 'application/json')->setJSON($arr);
        
    }

    public function getRecomendacionesLibrosIQuatro()
    {
        $config = $this->request->getJSON();
        $info = json_decode(json_encode($config), true);

        $red = $info['red'];
        $id_libro = $info['id'];

        $condiciones = [
            'red' => $red,
            'editorial' => 4
        ];

        $columas = ['id', 'nombre', 'carpeta', 'anio', 'editorial', 'red'];

        $libros = $this->AdminModel->getRandomRows('libros', $columas, $condiciones, 4);

        foreach ($libros as $key => $l) {

            $red = $info['red'] == 'todos' ? $l['red'] : $red;
            //Vamos a obtener el nombre de la editorial
            $editorial = $l['editorial'];
            $columnasEditorial = ['nombre'];
            $condicionesEditorial = ['id' => $editorial];
            $infoEditorial = $this->AdminModel->getColumnsOneRow($columnasEditorial, 'editoriales', $condicionesEditorial);

            if (!empty($infoEditorial)) {
                $libros[$key]['editorial'] = $infoEditorial['nombre'];
            }

            //VERIFICAMOS LA EXISTENCIA DE LOS ARCHIVOS

            $libro_exist = '';
            $dictamen_exist = '';
            $status = '';

            if ($l['carpeta'] == '') {
                $img = null;
                $status = 0;
            } else {

                //VAMOS A VERIFICAR LA EXISTENCIA DE CADA ARCHIVO IMPORTANTE

                $ruta_libro = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/libro.pdf';

                if (!file_exists($ruta_libro)) {
                    $libro_exist = null;
                }

                $ruta_dictamen = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/dictamen.pdf';
                if (!file_exists($ruta_dictamen)) {
                    $dictamen_exist = null;
                }


                $ruta_imagen = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/portada.png';

                if (!file_exists($ruta_imagen)) {
                    $ruta_imagen = WRITEPATH . 'uploads/libros/404.png';
                    $imgData = file_get_contents($ruta_imagen);
                    $base_64_cover = base64_encode($imgData);
                    $img = $base_64_cover;
                } else {
                    $imgData = file_get_contents($ruta_imagen);
                    $base_64_cover = base64_encode($imgData);
                    $img = $base_64_cover;
                }
            }

            $libros[$key]['portada'] = $img;
        }

        return $this->response->setHeader('Content-Type', 'application/json')->setJSON($libros);
    }

    public function getLibrosIQuatro()
    {

        $config = $this->request->getJSON();
        $info = json_decode(json_encode($config), true);

        $red = $info['red'];

        $condiciones = [
            'red' => $red,
            'editorial' => 4
        ];

        if ($info['red'] == '') {
            unset($condiciones['red']);
        }

        if ($info['tipo'] != 'na') {
            switch ($info['tipo']) {
                case 'impresos':
                    $tipo_seleccionado = 'Impreso';
                    break;
                case 'digitales':
                    $tipo_seleccionado = 'Digital';
                    break;
                default:
                    http_response_code(500);
                    break;
            }
            $condiciones['formato'] = $tipo_seleccionado;
        }

        $columas = ['id', 'nombre', 'carpeta', 'anio', 'editorial', 'red', 'paginas', 'doi', 'formato'];

        $libros = $this->AdminModel->getAllColums($columas, 'libros', $condiciones);

        //Vamos a formatear la informacion

        foreach ($libros as $key => $l) {

            $red = $info['red'] == 'todos' ? $l['red'] : $red;
            //Vamos a obtener el nombre de la editorial
            $editorial = $l['editorial'];
            $columnasEditorial = ['nombre'];
            $condicionesEditorial = ['id' => $editorial];
            $infoEditorial = $this->AdminModel->getColumnsOneRow($columnasEditorial, 'editoriales', $condicionesEditorial);

            if (!empty($infoEditorial)) {
                $libros[$key]['editorial'] = $infoEditorial['nombre'];
            }

            //VERIFICAMOS LA EXISTENCIA DE LOS ARCHIVOS

            $libro_exist = '';
            $dictamen_exist = '';
            $status = '';

            if ($l['carpeta'] == '') {
                $img = null;
                $status = 0;
            } else {

                //VAMOS A VERIFICAR LA EXISTENCIA DE CADA ARCHIVO IMPORTANTE

                $ruta_libro = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/libro.pdf';

                if (!file_exists($ruta_libro)) {
                    $libro_exist = null;
                }

                $ruta_dictamen = WRITEPATH . 'uploads/libros/' . $red . '/' . $l['anio'] . '/' . $l['carpeta'] . '/dictamen.pdf';
                if (!file_exists($ruta_dictamen)) {
                    $dictamen_exist = null;
                }


                $ruta_imagen = WRITEPATH . 'uploads/libros/' . $l['red'] . '/' . $l['anio'] . '/' . $l['carpeta'] . '/portada.png';

                if (!file_exists($ruta_imagen)) {
                    $ruta_imagen = WRITEPATH . 'uploads/libros/404.png';
                    $imgData = file_get_contents($ruta_imagen);
                    $base_64_cover = base64_encode($imgData);
                    $img = $base_64_cover;
                } else {
                    $imgData = file_get_contents($ruta_imagen);
                    $base_64_cover = base64_encode($imgData);
                    $img = $base_64_cover;
                }
            }

            $libros[$key]['portada'] = $img;
        }

        $key_sort3  = array_column($libros, 'anio');
        array_multisort($key_sort3, SORT_DESC, $libros);

        return $this->response->setHeader('Content-Type', 'application/json')->setJSON($libros);
    }

    public function getCapitulosLibrosIQuatro()
    {

        $config = $this->request->getJSON();
        $info = json_decode(json_encode($config), true);

        $id = $info['id'];
        $condiciones = ['id_libro' => $id];
        $capitulos = $this->AdminModel->getAll('indices_libros', $condiciones);



        foreach ($capitulos as $key => $c) {
            //$ruta = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'].'/'.$libro['carpeta'].'/capitulos/capitulo_'.$indice_libro['capitulo'].'.pdf';
            $i = 1;
            while ($i <= 4) {
                $columna = 'autor_' . $i;
                $capitulos[$key]['autores'][$i] = $c[$columna];
                unset($capitulos[$key][$columna]);
                $i++;
            }

            //VAMOS A TRAERNOS DATOS DEL LIBRO
            $columnas = ['red', 'anio', 'carpeta'];
            $condiciones = ['id' => $c['id_libro']];
            $libro = $this->AdminModel->getColumnsOneRow($columnas, 'libros', $condiciones);

            $ruta = WRITEPATH . 'uploads/libros/' . $libro['red'] . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/capitulos/capitulo_' . $c['capitulo'] . '.pdf';
            //$libroPdfPathVisualizer = base_url() . '/api/biblioteca/visualizador_cap/' . $libro['red'].'/'.$libro['anio'].'/'.$libro['carpeta'].'/capitulos/capitulo_'.$c['capitulo'].'.pdf';
            $libroPdfPathVisualizer = base_url() . '/api/biblioteca/visualizador_cap/' . $libro['red'] . '/' . $libro['anio'] . '/' . $libro['carpeta'] . '/' . $c['capitulo'];

            if (file_exists($ruta)) {
                //existe
                $capitulos[$key]['pdf'] = true;
                $pdfContent = file_get_contents($ruta);
                // Convierte el contenido a base64
                $base64Data = base64_encode($pdfContent);
                $capitulos[$key]['CapPdfPathVisualizer'] = $libroPdfPathVisualizer;
            } else {
                //no
                $capitulos[$key]['pdf'] = false;
            }
        }

        return $this->response->setHeader('Content-Type', 'application/json')->setJSON($capitulos);
    }

}
