<?php

namespace App\Controllers;
use App\Models\ExternalModel;
use Exception;

class RelegController extends ExternalController
{

    public function __construct()
    {
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $this->ExternalModel = new ExternalModel();
    }

    private function generar_clave($strength = 16){

        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $input_length = strlen($input);

        $random_string = '';

        for ($i = 0; $i < $strength; $i++) {

            $random_character = $input[mt_rand(0, $input_length - 1)];

            $random_string .= $random_character;

        }

        return $random_string;

    }

    public function insertarRegistro(){

        $pagina_anterior = $_SERVER['HTTP_REFERER'];

        if($pagina_anterior === null || $pagina_anterior == "" || empty($pagina_anterior) || !isset($pagina_anterior)){

            redirect(base_url());

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

        

        $rnd_clave = $this->generar_clave(10);

        $clave = "CG-" . $rnd_clave;

        $dataUbicacion = $this->validarUbicacion($_POST['cbx_pais'],$_POST['cbx_estado'],$_POST['cbx_municipio']);

        $data_institucion = array(

            'claveCuerpo' => $clave,

            'nombre' => $_POST["nombreUniversidad"],

            'nombre_rector' => $_POST["nombreRector"],

            'grado_rector' => $_POST["gradoRector"],

            'municipio' => $dataUbicacion['municipio'],

            'estado' => $dataUbicacion['estado'],

            'pais' => $dataUbicacion['pais'],

            'especialidad' => "especialidad pendiente",

            'direccion' => $_POST["direccionUniversidad"],

            'telefono' => $_POST["telefonoUniversidad"],

            'extension' => $_POST["extensionUniversidad"],

            'direccion_envio' => $_POST["direccionEnvio"],

            'nombre_prodep' => $_POST["nombreProdep"],

            'nivel_prodep' => $_POST["nivelProdep"],

            'ano_prodep' => $_POST["anoProdep"],

            'redCueCa' => "Releg",

            'tipo_registro' => $_POST["tipo_registro"],

            'activo' => 0,

            'inst_est' => $_POST["inst_est"],

            'fac_estudio' => $str_facultades,

            'medio_entero' => $_POST['cbx_medio'],

            'anio_inscripcion' => date('Y'),

            'password' => random_int(1,100000000)

        );



        if ($this->ExternalModel->generalInsertSession("cuerpos_academicos", $data_institucion)) {

            //SE INSERTO EL REGISTRO EN CUERPOS ACADEMICOS

            //INSERTAMOS LA CARPETA

            

            //OBTENEMOS EL ULTIMO ID QUE SE INSERTO POR SI FALLA EL INSERTAR LOS MIEMBROS, TAMBIEN ELIMINAMOS EL CUERPO

            $id_insertado = $_SESSION["id_insertado"];

            unset($_SESSION["id_insertado"]);

            $inserciones = 0;

            $count_miembros = count($_POST["miembros"]);

            $i = 0;

            foreach ($_POST["miembros"] as $m) {

                $i++;

                $pass = password_hash($m['correo_personal'], PASSWORD_DEFAULT);

                if (!empty($m['usuario'])) {

                    //SIGNIFICA QUE SI HAY UN USUARIO POR LO QUE NO LO AGREGAMOS EN LA TABLA DE USUARIOS

                    $usuario = $m['usuario'];

                    //ACTUALIZAMOS LA TABLA DE USUARIOS

                    $condiciones_actualizar = ["usuario" => $usuario];

                    $data_actualizar = [

                        'Releg' => 1,

                        'sexo' => $m["sexo"]

                    ];

                    $this->ExternalModel->generalUpdate("usuarios",$data_actualizar, $condiciones_actualizar);



                    //ACTUALIZAMOS LA TABLA DE MIEMBROS EN LA COLUMNA PAIS

                    $condiciones_miembros = ["usuario" => $usuario];

                    $datos_actualizar = ['pais' => $m["nacionalidad"]];

                    $this->ExternalModel->generalUpdate("miembros",$datos_actualizar, $condiciones_miembros);

                } else {

                    //SIGNIFICA QUE NO EXISTE Y ES UN USUARIO COMPLETAMENTE NUEVO, SE DEBE INSERTAR EN LA TABLA DE USUARIOS

                    //TENEMOS QUE CREAR UN USUARIO

                    $usuario = $this->generar_clave(20);

                    //CREAMOS EL ARRAY PARA USUARIOS

                    $dataUsuario = array(

                        'id' => "",

                        'nombre' => trim($m['nombre']),

                        'ap_paterno' => trim($m['ap_paterno']),

                        'ap_materno' => trim($m['ap_materno']),

                        'correo' => trim($m['correo_personal']),

                        'correo_institucional' => trim($m['correo_institucional']),

                        'password' => $pass,

                        'usuario' => $usuario,

                        'Releg' => 1,

                        'sexo' => $m['sexo']

                    );

                }



                //en caso de que los datos esten vacios

                if ($m["SNI"] == "no") {

                    $m["nivelSNI"] = NULL;

                    $m["anoSNI"] = NULL;

                }



                // if(isset($m['grado_academico'])){

                //     $m["grado_academico"] = NULL;

                // }

                //CREAMOS EL ARRAY PARA INSERTAR EN LA TABLA DE MIEMBROS

                $data = array( //creamos el array de maestros

                    'nombre' => trim($m['nombre']),

                    'apaterno' => trim($m['ap_paterno']),

                    'amaterno' => trim($m['ap_materno']),

                    'usuario' => "$usuario",

                    'grado' => $m['grado_academico'],

                    'especialidad' => $m['especialidad'],

                    'telefono' => $m['telefono'],

                    'nivelSNI' => $m['nivelSNI'],

                    'anoSNI' => $m['anoSNI'],

                    'tipo' => 'maestro', //MAESTRO O ALUMNO (Alumno es para RELEEM)

                    'lider' => $m['lider'], //HACER INPUT PARA SABER CUAL ES

                    'redCueCa' => 'Releg',

                    'cuerpoAcademico' => $clave,

                    'pais' => $m["nacionalidad"],

                    'fecha_registro' => date("Y-m-d H:i:s")

                );

                $dataHistoria = array( //CREAMOS EL ARRAY PARA LA HISTORIA DE USUARIO

                    "usuario" => $usuario,

                    "redCueCa" => "Releg",

                    "cuerpoAcademico" => $clave,

                    "year" => date("Y")

                );

                $dataCarpeta = array(  //CREAMOS EL ARRAT PARA LA CARPETA DEL CA

                    "claveCuerpo" => $clave,

                    "envios" => "",

                    "recibidos" => "",

                    "formulario" => "",

                    "respuestas" => "",

                    "validacion" => "",

                    "alumnos" => "",

                    "capitulo" => "",

                    "ano_carpeta" => "2021-2022",

                    "red" => "Releg"

                );



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

                            return redirect()->to(base_url())
                            ->with('icon','error')
                            ->with('title','Lo sentimos')
                            ->with('text','Ha ocurrido un error. Código de error: '.$codigo_error);

                    }

                }

            }



            if($count_miembros == $inserciones){

                $this->ExternalModel->generalInsert("carpetas",$dataCarpeta);

                //La cantidad de miembros insertados fue la misma cantidad que el usuario escribio, no ocurrio ningun error por lo que

                //mandaremos los correos

                $anio = date("Y");

                $condiciones_inv = array("red"=> "Releg","anio"=>$anio); //Esto se tiene que cambiar con cada año

                $datos_investigacion = $this->ExternalModel->getAll("investigaciones",$condiciones_inv);

                //Validamos si en realidad es un id de estado o ingreso otro estado

                $condiciones_estado = ["id" => $_POST["cbx_estado"]];

                $estado = $this->ExternalModel->getAll("estados",$condiciones_estado);

                if(isset($estado[0]["nombre"])){

                    $estado = $estado[0]["nombre"];

                }else{

                    $estado = $_POST["cbx_estado"];

                }

                $condiciones_municipio = ["id" => $_POST["cbx_municipio"]];

                $municipio = $this->ExternalModel->getAll("municipios",$condiciones_municipio);

                if(isset($municipio[0]["nombre"])){

                    $municipio = $municipio[0]["nombre"];

                }else{

                    $municipio = $_POST["cbx_municipio"];

                }

                $html = "

                <p>

                Por medio de la presente reciba un cordial saludo cada uno de los miembros del nuevo grupo <span style='color:#FF509C'>$clave</span>, 

                le confirmamos su participación para colaborar y ser parte de la 

                <span style='color:#FF509C'>Red de Estudios Latinoamericanos de las Mujeres en las Organizaciones</span>.

                </p>

                <p>

                Para poder dar seguimiento a su participación en los eventos de la red, le compartimos sus 

                accesos para ingresar a la zona miembros de nuestra plataforma: <a href='https://redesla.la/redesla/'>https://redesla.la/redesla/</a>

                </p>

                ";

                $g = 1;

                foreach($_POST["miembros"] as $m){

                    $condiciones_ga = ["id" => $m['grado_academico']];

                    $grado_academico = $this->ExternalModel->getAll("grado_academico",$condiciones_ga);

                    $grado_academico = $grado_academico[0]["nombre"];

                    $nombre_completo = $m["nombre"]." ".$m["ap_paterno"]." ".$m["ap_materno"];

                    if($m['lider'] == 1){

                        $html .= "

                        <h3>Lider: </h3>

                        Nombre completo: $nombre_completo <br>

                        Correo electrónico: ".$m["correo_personal"]."<br> 

                        Contraseña: ".$m["correo_personal"]."<br>

                        ";

                    }else{

                        $html .= "

                        <h3>Miembro $g</h3>

                        Nombre completo: $nombre_completo <br>

                        Correo electrónico: ".$m["correo_personal"]."<br> 

                        Contraseña: ".$m["correo_personal"]."<br>

                        ";

                        $g++;

                    }

                }

                $html .= "

                <p>
                    Espere el correo de confirmación por parte del equipo de REDESLA para acceder a la plataforma.
                </p>
                
                <p>

                Quedamos a sus órdenes y muy pronto nos pondremos en contacto con usted.

                </p>

                <p>

                <b>Este correo no acepta respuestas, para enviar la confirmación de su participación, resolver 

                dudas o aclaraciones, dejamos a continuación los medios de contacto a través de los cuales les daremos la atención debida:</b>

                </p>

                <img src='https://redesla.la/redesla/resources/img/firmas/Releg.jpeg' />

                ";

                foreach($_POST["miembros"] as $m){

                    $email = \Config\Services::email();
                    $email->setFrom('atencion@redesla.la', 'Registro RELEG');
                    $email->setTo($m["correo_personal"]);
                    $email->setSubject('¡Bienvenidos a RELEG!');
                    $email->setMessage($html);
            
                    if($email->send()){
                        echo 'enviado';
                    }else{
                        echo 'error';
                    }


                    $email->clear(); 

                }

                return redirect()->to(base_url())
                ->with('icon','success')
                ->with('title','¡Éxito!')
                ->with('text','Registro completado correctamente. Se mandaron instrucciones a los correos proporcionados.');

                /*

                switch($_POST["tipo_registro"]){

                    case 'investigación':

                        $html = "

                        <p>

                        Por medio de la presente reciba un cordial saludo cada uno de los miembros del nuevo grupo <b>"

                        . strtoupper("Releg")."</b>, con el fin de confirmar su participación y colaborar la 

                        investigación anual 2022 < <b><i>".$datos_investigacion[0]["nombre"]."</i></b> >, dicha red tiene como

                        objetivo general ".$datos_investigacion[0]["objetivo"]. "a travez de un mismo instrumento, enfocándose 

                        en algún aspecto particular cada año.

                        </p>

                        <p>

                        Deseando asignar la zona de estudio a investigar, solicitamos que nos confirme la siguiente información, la cual estará sujeta a disponibilidad:

                        </p>

                        <ul>

                            <li>Estado: ".$estado."</li>

                            <li>Municipio: ".$municipio."</li>

                            <li>Institución/Universidad en la que se aplicará el estudio: ".$_POST["nombreUniversidad"]."</li>

                            <li>Facultades/Carreras en las que aplicarán el estudio: ".$_POST["inst_est"]."</li>

                        </ul>

                        <p>

                        Solicitamos amablemente confirmen su registro de participación, es importante que

                        los datos de contacto sean verídicos para mantenernos en contacto. 

                        Dichos datos deberán confirmarse a más tardar el día ".$datos_investigacion[0]["ult_dia_datos"].",

                        para poder recibir acceso a los materiales, la capacitación, además de los

                        detalles del levantamiento.

                        </p><br>

                        ";

                        $g = 1;

                        foreach($_POST["miembros"] as $m){

                            $condiciones_ga = ["id" => $m['grado_academico']];

                            $grado_academico = $this->ExternalModel->getAllConditions("grado_academico",$condiciones_ga);

                            $grado_academico = $grado_academico[0]["nombre"];

                            $nombre_completo = $m["nombre"]." ".$m["ap_paterno"]." ".$m["ap_materno"];

                            if($m['lider'] == 1){

                                $html .= "

                                <h3>Lider del GI</h3>

                                Nombre completo: $nombre_completo <br>

                                Grado académico: $grado_academico <br>

                                Especialidad: ".$m["especialidad"]."<br>

                                Teléfono: ".$m["telefono"]."<br>

                                Correo personal (acceso a plataforma): ".$m["correo_personal"]."<br> 

                                Correo institucional ".$m["correo_institucional"]."<br>

                                ";

                            }else{

                                $html .= "

                                <h3>Miembro $g</h3>

                                Nombre completo: $nombre_completo <br>

                                Grado académico: $grado_academico <br>

                                Especialidad: ".$m["especialidad"]."<br>

                                Teléfono: ".$m["telefono"]."<br>

                                Correo personal (acceso a plataforma): ".$m["correo_personal"]."<br> 

                                Correo institucional ".$m["correo_institucional"]."<br>

                                ";

                                $g++;

                            }

                        }

                        $html .= "

                        <p>Recuerde consultar todos los detalles de la convocatoria: </p>

                        <a href='https://drive.google.com/file/d/1UkeKom-Ep_vFW2gvC8TvOfe3op7p13Fu/view'>https://drive.google.com/file/d/1UkeKom-Ep_vFW2gvC8TvOfe3op7p13Fu/view</a>

                        <p>

                        <b>

                        Este correo no acepta respuestas, para enviar la confirmación de su participación, resolver dudas o aclaraciones, dejamos a continuación los medios de contacto a través de los cuales les daremos la atención debida:

                        </b>

                        </p>

                        <img src='https://redesla.net/redesla/resources/img/firmas/Releg.jpeg' />

                        ";

                        foreach($_POST["miembros"] as $m){

                            $mail->SMTPDebug = 0;

                            $mail->isSMTP();

                            $mail->Host = "mail.redesla.net";

                            $mail->SMTPAuth = true;

                            $mail->Username = 'atencion@redesla.net';

                            $mail->Password = 'Atenci@n.2021';

                            $mail->SMTPSecure = 'ssl';

                            $mail->Port = 465;

                            $mail->isHTML(true);//especificamos que el correo tendra soporte html

                            $mail->setFrom("atencion@redesla.net", 'Registro Releg');

                            $mail->addAddress($m["correo_personal"]);

                            $mail->CharSet = 'UTF-8';

                            $mail->Subject = "¡Bienvenido a Releg!";

                            $mail->Body = $html;

                            if(!$mail->send()) 

                            {

                                echo "Mailer Error: " . $mail->ErrorInfo;

                            } 

                            else 

                            {

                                $this->session->set_flashdata('message','Message has been sent successfully');

                            }

                            $mail->clearAddresses(); 

                        }

                        $this->session->set_flashdata('message', 'success');

                        header("Location: ".base_url());

                        break;

                    case 'congreso':

                        $primer_autor = $_POST["miembros"][1]["nombre"] . " " . $_POST["miembros"][1]["ap_paterno"] . " " . $_POST["miembros"][1]["ap_materno"];

                        

                        break;

                    case 'oyente':

                        $primer_autor = $_POST["miembros"][1]["nombre"] . " " . $_POST["miembros"][1]["ap_paterno"] . " " . $_POST["miembros"][1]["ap_materno"];

                        

                        break;

                }

                */

            }

        } else {

            //OCURRIO UN ERROR AL INSERTAR EL CUERPO ACADEMICO

            return redirect()->to(base_url())
                ->with('icon','error')
                ->with('title','Lo sentimos')
                ->with('text','Ha ocurrido un error. Intentelo mas tarde o contacte a sistemas.');

        }

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


}