<?php

namespace App\Controllers;
use App\Models\ExternalModel;
use Exception;

class RelaynController extends ExternalController
{

    public function __construct()
    {
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $this->ExternalModel = new ExternalModel();
    }

    #FAVOR DE BORRAR ESTA FUNCION
    public function mail(){

        $email = \Config\Services::email();
        $email->setFrom('atencion@redesla.la', 'Registro RELAYN');
        $email->setTo('pmejiaa@redesla.net');
        $email->setSubject('Email Test');
        $email->setMessage('Testing the email class.');

        if($email->send()){
            echo 'enviado';
        }else{
            echo 'error';
        }
    }

    public function insertarRegistro(){

        $pagina_anterior = $_SERVER['HTTP_REFERER'];

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if(date('md') >= '1118'){

            $anio = date('Y')+1;

        }else{

            $anio = date('Y');

        }

        function generar_clave($input, $strength = 16)

        {

            $input_length = strlen($input);

            $random_string = '';

            for ($i = 0; $i < $strength; $i++) {

                $random_character = $input[mt_rand(0, $input_length - 1)];

                $random_string .= $random_character;

            }

            return $random_string;

        }

        $clave = "CG-" . generar_clave($permitted_chars, 10);

        #VAMOS A VALIDAR LOS PAISES Y EL ESTADO

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

            'redCueCa' => "Relayn",

            'tipo_registro' => $_POST["tipo_registro"],

            'activo' => 0,

            'inst_est' => "No aplica",

            'medio_entero' => $_POST['cbx_medio'],

            'anio_inscripcion' => $anio,

            'password' => random_int(1,100000000)

        );



        if ($this->ExternalModel->generalInsertSession("cuerpos_academicos", $data_institucion)) {

            //SE INSERTO EL REGISTRO EN CUERPOS ACADEMICOS

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

                        'Relayn' => 1,

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

                    $usuario = generar_clave($permitted_chars, 20);

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

                        'Relayn' => 1,

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

                    'redCueCa' => 'Relayn',

                    'cuerpoAcademico' => $clave,

                    'pais' => $m["nacionalidad"],

                    'fecha_registro' => date("Y-m-d H:i:s")

                );

                $dataHistoria = array( //CREAMOS EL ARRAY PARA LA HISTORIA DE USUARIO

                    "usuario" => $usuario,

                    "redCueCa" => "Relayn",

                    "cuerpoAcademico" => $clave,

                    "year" => $anio

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

                    "ano_carpeta" => $anio,

                    "red" => "Relayn"

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

                //La cantidad de miembros insertados fue la misma cantidad que el usuario escribio, no ocurrio ningun error por lo que

                $this->ExternalModel->generalInsert("carpetas", $dataCarpeta);

                //mandaremos los correos

                $anio = date("Y");

                $condiciones_inv = array("red"=> "Relayn","anio"=>$anio); //Esto se tiene que cambiar con cada año

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

                //Se tiene que crear un correo generico

                $html = "

                <p>

                Por medio de la presente reciba un cordial saludo cada uno de los miembros del nuevo grupo <span style='color:#9D0303'>$clave</span>, 

                le confirmamos su participación para colaborar y ser parte de la 

                <span style='color:#9D0303'>Red de Estudios Latinoamericanos en Administración y Negocios RELAYN</span>.

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

                <img src='https://redesla.la/redesla/resources/img/firmas/Relayn_atencion.jpg' />

                ";

                foreach($_POST["miembros"] as $m){

                    $email = \Config\Services::email();
                    $email->setFrom('atencion@redesla.la', 'Registro RELAYN');
                    $email->setTo($m["correo_personal"]);
                    $email->setSubject('¡Bienvenidos a RELAYN!');
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

                        . strtoupper("Relayn")."</b>, con el fin de confirmar su participación y colaborar la 

                        investigación anual 2022 < <b><i>".$datos_investigacion[0]["nombre"]."</i></b> >, dicha red tiene como

                        objetivo general ".$datos_investigacion[0]["objetivo"]. "a travez de un mismo instrumento, enfocándose 

                        en algún aspecto particular cada año

                        </p>

                        <p>

                        Deseando asignar la zona de estudio a investigar, solicitamos que nos confirme la siguiente información, la cual estará sujeta a disponibilidad:

                        </p>

                        <ul>

                            <li>Estado: ".$estado."</li>

                            <li>Municipio: ".$municipio."</li>

                            <li>Institución/Universidad en la que se aplicará el estudio: ".$_POST["nombreUniversidad"]."</li>

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

                        <p>

                        <b>

                        Este correo no acepta respuestas, para enviar la confirmación de su participación, resolver dudas o aclaraciones, dejamos a continuación los medios de contacto a través de los cuales les daremos la atención debida:

                        </b>

                        </p>

                        <img src='https://redesla.net/redesla/resources/img/firmas/Relayn.jpeg' />

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

                            $mail->setFrom("atencion@redesla.net", 'Registro RELAYN');

                            $mail->addAddress($m["correo_personal"]);

                            $mail->CharSet = 'UTF-8';

                            $mail->Subject = "¡Bienvenido a RELAYN!";

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

                    case 'coloquio':

                        $primer_autor = $_POST["miembros"][1]["nombre"] . " " . $_POST["miembros"][1]["ap_paterno"] . " " . $_POST["miembros"][1]["ap_materno"];

                        $html = '

                        <img src="https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELAYN.jpg" />

                        <p>

                        Apreciable investigador (a) '.$primer_autor.' <br>

                        Le confirmamos que ya contamos con su solicitud para ser parte del <b>"4to. Coloquio de Investigación para alumnos de Doctorado

                        y Maestría RELAYN 2022"</b>, que se llevará a cabo en el marco del <b>"7mo. Congreso Latinoamericano de Investigación

                        en Administración y Negocios. RELAYN 2022"</b>.

                        </p>

                        <p>

                        El evento será de gran relevancia académica ya que los productos que de éste deriven abonan al perfil PRODEP,

                        al perfil SNI, al PNPC, a la consolidación de cuerpos académicos, a las certificaciones de CACECA, 

                        a programas de fortalecimiento como PIFI, PROFOCIE, PFCE. 

                        </p>

                        <p>

                        Dicho evento se llevará a cabo <a onclick="return false">bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio 

                        <b>"Vive RedesLA"</b> y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona</a>: el <b>Centro

                        Universitario de la Costa de la Universidad de Guadalajara en Puerto Vallarta, Jalisco</b>, quienes en 

                        conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b>RELAYN</b>, llevarán a cabo 

                        la organización de este congreso de investigación, los días <b>17 y 18 de noviembre del 2022</b>.

                        </p>

                        <p>

                        Para continuar con su participación deberá hacer el <b>"Envío de artículo-ponencia"</b>

                        </p>

                        <p>

                        <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de iQuatro Editores e iniciar sesión realizando el siguiente proceso:</b><br>

                        <ol>

                            <li>

                            Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro en plataforma

                            de iQuatro Editores: <a href="http://iquatroeditores.com/revista/index.php/iquatro/user/register" target="_blank">Registrarse | Libros IQuatro(iquatroeditores.com)</a>. Si ya cuenta con un usuario, omita este paso e inicie sesión

                            </li>

                            <li>

                            Dé clic en: <b>Enviar artículo</b>. Revise que cumpla con todos los <b><a href="http://iquatroeditores.com/revista/index.php/iquatro/about/submissions">requisitos</a></b>,

                            antes de proceder con el envío de su artículo.  

                            </li>

                            <li>

                            En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la "<a href="https://drive.google.com/file/d/1NssoXPsK7aujW8eDAtP6dP6KAv31XFSB/view" target="_blank">convocatoria"</a>

                            y el nivel (categoría) con el que participará, mismo que contiene los parámetros mencionados en el apartado <b>I. 

                            Formato de la <a href="https://drive.google.com/file/d/1NssoXPsK7aujW8eDAtP6dP6KAv31XFSB/view" target="_blank">convocatoria</a></b>.

                            </li>

                            <li>

                            Introducir <b>"los metadatos (nombre de artículo y autores)" y "el resumen"</b>.  En la pestaña de "CONFIRMACIÓN" dar

                            clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. Es importante que su archivo Word

                            no contenga el nombre de los autores para garantizar la revisión anónima. 

                            </li>

                            <li>

                            Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores, 

                            es importante verificar la bandeja de correo no deseado, ver <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">manual</a> 

                            de envío <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">aquí</a>.

                            </li>

                            <li>

                            El Cuerpo Arbitral conformado por investigadores expertos en el área realizará la evaluación donde se definirá si es aceptada 

                            o rechazada la presentación de la ponencia en el <b>4to. Coloquio de Investigación para alumnos de Doctorado y 

                            Maestría RELAYN 2022</b> en el marco del <b>7mo. Congreso Latinoamericano de Investigación en Administración y Negocios.

                            RELAYN 2022</b>. Se notificará dicho dictamen vía electrónica.

                            </li>

                            <li>

                            <b><u>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten</u></b>.  

                            Deberá confirmar si enviarán su trabajo en la categoría 4, en caso de haber seleccionado la categoría 1, 2 o 3.

                            </li>

                            <li>

                            Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar

                            si dicha ponencia será publicada como artículo en la <a href="http://iquatroeditores.com/revista/index.php/relayn/index" target="_blank">Revista RELAYN</a> 

                            o como capítulo en el <a href="https://www.relayn.org/biblioteca/" target="_blank">libro electrónico</a> del 

                            <b>"7mo. Congreso Latinoamericano de Investigación en Administración y Negocios. RELAYN 2022"</b>.  

                            </li>

                            <li>

                            Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación; una vez realizada la revisión por pares y enviadas sus correcciones. 

                            </li>

                            <li>

                            Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que deberá editar, 

                            firmar y subirla a la <a href="http://iquatroeditores.com/revista/index.php/iquatro/login" target="_blank">plataforma</a> escaneada en formato PDF, según las indicaciones de la editorial iQuatro Editores.   

                            </li>

                        </ol>

                        </p>

                        <p>

                        <b><u>Una vez aceptada su ponencia:</u></b><br>

                        Se deberá cubrir a más tardar el 19 de noviembre del presente año la <b>tarifa de inscripción</b>: $6,410.00 (seis mil cuatrocientos diez pesos 00/100 MXN) 

                        IVA incluido por ponencia, para los participantes fuera de México será de: 330 USD (trescientos treinta dólares 00/100 USD) IVA incluido por

                        ponencia, esta puede ser de uno a máximo dos autores.

                        </p>

                        <p>

                        Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 07 de octubre del 2022, con la <b>tarifa de inscripción 

                        con descuento</b>: $6,010.00 (seis mil diez pesos 00/100 MXN) IVA incluido por ponencia, para los participantes fuera de México será de 

                        305 USD: (trescientos cinco dólares 00/100 USD) IVA incluido por ponencia, esta puede ser de uno a máximo dos autores.

                        </p>

                        <p>

                        Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca móvil o depósito bancario 

                        a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en la cuenta clásica 0223143300201 del banco BANBAJIO BANCO

                        DEL BAJIO S.A con <b>CLABE interbancaria 030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de 

                        forma directa, OXXO o tiendas de conveniencia: <a herf="https://link.mercadopago.com.mx/sdmypesredesla" target="_blank">https://link.mercadopago.com.mx/sdmypesredesla</a>  

                        </p>

                        <p>

                        Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una 

                        <a href="https://www.paypal.com/mx/webapps/mpp/country-worldwide" target="_blank">plataforma online</a> a sus correos 

                        electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus bancos, o bien podrá ejecutarlo desde este link:

                        <a href="https://paypal.me/paqueteb1?locale.x=es_XC" target="_blank">https://paypal.me/paqueteb1?locale.x=es_XC</a>.  

                        </p>

                        <p>

                        Recuerde colocar el en concepto su ID del artículo-Coloquio RELAYN.

                        </p>

                        <p>

                        <b>MANTÉNGASE ACTUALIZADO:</b><br>

                        Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle "like" 

                        a nuestra página de Facebook para estar actualizado de todas las actividades a realizar:

                        <a href="https://www.facebook.com/Relayn.org" target="_blank">https://www.facebook.com/Relayn.org</a>

                        </p>

                        <p>

                        Esperamos verlos y contar con su presencia física o virtual, realizando la ponencia correspondiente y asistiendo a las 

                        actividades de nuestro <b>7mo. Congreso Latinoamericano de Investigación en Administración y Negocios. RELAYN 2022</b>.<br>

                        <b>#PasiónPorLaInvestigación</b>

                        </p>

                        <p>

                        Nos ponemos a sus órdenes para cualquier duda o aclaración:<br>

                        Correo: relayn@redesla.net, ponencias@relayn.org<br>

                        WhatsApp: <a target="_blank" href="https://api.whatsapp.com/send?phone=5214271067882&text=%F0%9F%8C%90%20%C2%A1Hola!%20Me%20gustar%C3%ADa%20recibir%20informaci%C3%B3n%20del%20*7mo%20Congreso%20Latinoamericano%20de%20Investigaci%C3%B3n%20en%20Administraci%C3%B3n%20y%20Negocios.%20RELAYN%202022*%2C%20me%20podr%C3%ADa%20indicar%20m%C3%A1s%20detalles%20sobre...">+52 1 4425039607 </a><br>

                        Teléfonos: 4271067882 y 4271389926

                        </p>

                        <p>

                        <img src="https://redesla.net/redesla/resources/img/firmas/Relayn_atencion.jpg" />

                        </p>

                        ';

                        $mail->SMTPDebug = 0;

                        $mail->isSMTP();

                        $mail->Host = "mail.redesla.net";

                        $mail->SMTPAuth = true;

                        $mail->Username = 'atencion@redesla.net';

                        $mail->Password = 'Atenci@n.2021';

                        $mail->SMTPSecure = 'ssl';

                        $mail->Port = 465;

                        $mail->isHTML(true);//especificamos que el correo tendra soporte html

                        $mail->setFrom("atencion@redesla.net", 'Registro a Coloquio Relayn '. date("Y"));

                        $mail->addAddress($_POST["miembros"][1]["correo_personal"]);

                        $mail->CharSet = 'UTF-8';

                        $mail->Subject = "Confirmación de inscripción como ponentes del 4to. Coloquio de Investigación para alumnos de Doctorado y Maestría RELAYN 2022";

                        $mail->Body = $html;

                        $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Coloquio_RELAYN_22.jpg")), 'Coloquio_RELAYN_22.jpg');

                        $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Mercado_Pago_SISTEMA_DESARROLLADOR.jpg")), 'Mercado_Pago_SISTEMA_DESARROLLADOR.jpg');

                        if(!$mail->send()){

                            echo "Mailer Error: " . $mail->ErrorInfo;

                        }else{

                            $this->session->set_flashdata('message','Message has been sent successfully');

                        }

                        $mail->clearAddresses();

                        $this->session->set_flashdata('message', 'success');

                        header("Location: ".base_url());

                        break;

                    case 'congreso':

                        $primer_autor = $_POST["miembros"][1]["nombre"] . " " . $_POST["miembros"][1]["ap_paterno"] . " " . $_POST["miembros"][1]["ap_materno"];

                        $html = '

                        <img src="https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELAYN.jpg" />

                        <p>

                        Apreciable investigador (a) '.$primer_autor.' <br>

                        Le confirmamos que ya contamos con su solicitud para ser parte del <b>"7mo. Congreso Latinoamericano de Investigación

                        en Administración y Negocios. RELAYN 2022"</b>.

                        </p>

                        <p>

                        El evento será de gran relevancia académica ya que los productos que de éste deriven abonan al perfil PRODEP,

                        al perfil SNI, al PNPC, a la consolidación de cuerpos académicos, a las certificaciones de CACECA, 

                        a programas de fortalecimiento como PIFI, PROFOCIE, PFCE. 

                        </p>

                        <p>

                        Dicho evento se llevará a cabo <a onclick="return false">bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio 

                        <b>"Vive RedesLA"</b> y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona</a>: el <b>Centro

                        Universitario de la Costa de la Universidad de Guadalajara en Puerto Vallarta, Jalisco</b>, quienes en 

                        conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b>RELAYN</b>, llevarán a cabo 

                        la organización de este congreso de investigación, los días <b>17 y 18 de noviembre del 2022</b>.

                        </p>

                        <p>

                        Para continuar con su participación deberá hacer el <b>"Envío de artículo-ponencia"</b>

                        </p>

                        <p>

                        <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de iQuatro Editores e iniciar sesión realizando el siguiente proceso:</b><br>

                        <ol>

                            <li>

                            Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro en plataforma

                            de iQuatro Editores: <a href="http://iquatroeditores.com/revista/index.php/iquatro/user/register" target="_blank">Registrarse | Libros IQuatro(iquatroeditores.com)</a>. Si ya cuenta con un usuario, omita este paso e inicie sesión

                            </li>

                            <li>

                            Dé clic en: <b>Enviar artículo</b>. Revise que cumpla con todos los <b><a href="http://iquatroeditores.com/revista/index.php/iquatro/about/submissions">requisitos</a></b>,

                            antes de proceder con el envío de su artículo.  

                            </li>

                            <li>

                            En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la "<a href="https://drive.google.com/file/d/1NssoXPsK7aujW8eDAtP6dP6KAv31XFSB/view" target="_blank">convocatoria"</a>

                            y el nivel (categoría) con el que participará, mismo que contiene los parámetros mencionados en el apartado <b>I. 

                            Formato de la <a href="https://drive.google.com/file/d/1NssoXPsK7aujW8eDAtP6dP6KAv31XFSB/view" target="_blank">convocatoria</a></b>.

                            </li>

                            <li>

                            Introducir <b>"los metadatos (nombre de artículo y autores)" y "el resumen"</b>.  En la pestaña de "CONFIRMACIÓN" dar

                            clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. Es importante que su archivo Word

                            no contenga el nombre de los autores para garantizar la revisión anónima. 

                            </li>

                            <li>

                            Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores, 

                            es importante verificar la bandeja de correo no deseado, ver <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">manual</a> 

                            de envío <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">aquí</a>.

                            </li>

                            <li>

                            El Cuerpo Arbitral conformado por investigadores expertos en el área realizará la evaluación donde se definirá si es aceptada 

                            o rechazada la presentación de la ponencia en el <b>4to. Coloquio de Investigación para alumnos de Doctorado y 

                            Maestría RELAYN 2022</b> en el marco del <b>7mo. Congreso Latinoamericano de Investigación en Administración y Negocios.

                            RELAYN 2022</b>. Se notificará dicho dictamen vía electrónica.

                            </li>

                            <li>

                            <b><u>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten</u></b>.  

                            Deberá confirmar si enviarán su trabajo en la categoría 4, en caso de haber seleccionado la categoría 1, 2 o 3.

                            </li>

                            <li>

                            Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar

                            si dicha ponencia será publicada como artículo en la <a href="http://iquatroeditores.com/revista/index.php/relayn/index" target="_blank">Revista RELAYN</a> 

                            o como capítulo en el <a href="https://www.relayn.org/biblioteca/" target="_blank">libro electrónico</a> del 

                            <b>"7mo. Congreso Latinoamericano de Investigación en Administración y Negocios. RELAYN 2022"</b>.  

                            </li>

                            <li>

                            Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación; una vez realizada la revisión por pares y enviadas sus correcciones. 

                            </li>

                            <li>

                            Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que deberá editar, 

                            firmar y subirla a la <a href="http://iquatroeditores.com/revista/index.php/iquatro/login" target="_blank">plataforma</a> escaneada en formato PDF, según las indicaciones de la editorial iQuatro Editores.   

                            </li>

                        </ol>

                        </p>

                        <p>

                        <b><u>Una vez aceptada su ponencia:</u></b><br>

                        Se deberá cubrir a más tardar el 19 de noviembre del presente año la <b>tarifa de inscripción</b>: $6,410.00 (seis mil cuatrocientos diez pesos 00/100 MXN) 

                        IVA incluido por ponencia, para los participantes fuera de México será de: 330 USD (trescientos treinta dólares 00/100 USD) IVA incluido por

                        ponencia, esta puede ser de uno a máximo dos autores.

                        </p>

                        <p>

                        Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 07 de octubre del 2022, con la <b>tarifa de inscripción 

                        con descuento</b>: $6,010.00 (seis mil diez pesos 00/100 MXN) IVA incluido por ponencia, para los participantes fuera de México será de 

                        305 USD: (trescientos cinco dólares 00/100 USD) IVA incluido por ponencia, esta puede ser de uno a máximo dos autores.

                        </p>

                        <p>

                        Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca móvil o depósito bancario 

                        a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en la cuenta clásica 0223143300201 del banco BANBAJIO BANCO

                        DEL BAJIO S.A con <b>CLABE interbancaria 030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de 

                        forma directa, OXXO o tiendas de conveniencia: <a herf="https://link.mercadopago.com.mx/sdmypesredesla" target="_blank">https://link.mercadopago.com.mx/sdmypesredesla</a>  

                        </p>

                        <p>

                        Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una 

                        <a href="https://www.paypal.com/mx/webapps/mpp/country-worldwide" target="_blank">plataforma online</a> a sus correos 

                        electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus bancos, o bien podrá ejecutarlo desde este link:

                        <a href="https://paypal.me/paqueteb1?locale.x=es_XC" target="_blank">https://paypal.me/paqueteb1?locale.x=es_XC</a>.  

                        </p>

                        <p>

                        Recuerde colocar el en concepto su ID del artículo-Congreso RELAYN.

                        </p>

                        <p>

                        <b>MANTÉNGASE ACTUALIZADO:</b><br>

                        Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle "like" 

                        a nuestra página de Facebook para estar actualizado de todas las actividades a realizar:

                        <a href="https://www.facebook.com/Relayn.org" target="_blank">https://www.facebook.com/Relayn.org</a>

                        </p>

                        <p>

                        Esperamos verlos y contar con su presencia física o virtual, realizando la ponencia correspondiente y asistiendo a las 

                        actividades de nuestro <b>7mo. Congreso Latinoamericano de Investigación en Administración y Negocios. RELAYN 2022</b>.<br>

                        <b>#PasiónPorLaInvestigación</b>

                        </p>

                        <p>

                        Nos ponemos a sus órdenes para cualquier duda o aclaración:<br>

                        Correo: relayn@redesla.net, ponencias@relayn.org<br>

                        WhatsApp: <a target="_blank" href="https://api.whatsapp.com/send?phone=5214271067882&text=%F0%9F%8C%90%20%C2%A1Hola!%20Me%20gustar%C3%ADa%20recibir%20informaci%C3%B3n%20del%20*7mo%20Congreso%20Latinoamericano%20de%20Investigaci%C3%B3n%20en%20Administraci%C3%B3n%20y%20Negocios.%20RELAYN%202022*%2C%20me%20podr%C3%ADa%20indicar%20m%C3%A1s%20detalles%20sobre...">+52 1 4425039607 </a><br>

                        Teléfonos: 4271067882 y 4271389926

                        </p>

                        <p>

                        <img src="https://redesla.net/redesla/resources/img/firmas/Relayn_atencion.jpg" />

                        </p>

                        ';

                        $mail->SMTPDebug = 0;

                        $mail->isSMTP();

                        $mail->Host = "mail.redesla.net";

                        $mail->SMTPAuth = true;

                        $mail->Username = 'atencion@redesla.net';

                        $mail->Password = 'Atenci@n.2021';

                        $mail->SMTPSecure = 'ssl';

                        $mail->Port = 465;

                        $mail->isHTML(true);//especificamos que el correo tendra soporte html

                        $mail->setFrom("atencion@redesla.net", 'Registro a Congreso Relayn ' .date("Y"));

                        $mail->addAddress($_POST["miembros"][1]["correo_personal"]);

                        $mail->CharSet = 'UTF-8';

                        $mail->Subject = "Confirmación de inscripción como ponentes del 7mo. Congreso Latinoamericano de Investigación en Administración y Negocios. RELAYN 2022";

                        $mail->Body = $html;

                        $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Cartel_General_RELAYN_22.jpg")), 'Cartel_General_RELAYN_22.jpg');

                        $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Mercado_Pago_SISTEMA_DESARROLLADOR.jpg")), 'Mercado_Pago_SISTEMA_DESARROLLADOR.jpg');

                        if(!$mail->send()){

                            echo "Mailer Error: " . $mail->ErrorInfo;

                        }else{

                            $this->session->set_flashdata('message','Message has been sent successfully');

                        }

                        $mail->clearAddresses();

                        $this->session->set_flashdata('message', 'success');

                        header("Location: ".base_url());

                        break;

                    case 'oyente':

                        $primer_autor = $_POST["miembros"][1]["nombre"] . " " . $_POST["miembros"][1]["ap_paterno"] . " " . $_POST["miembros"][1]["ap_materno"];

                        $html = '

                        <img src="https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELAYN.jpg" />

                        <p>

                        Apreciable investigador (a) '.$primer_autor.' <br>

                        Le confirmamos que ya contamos con su solicitud para ser parte del <b>"7mo. Congreso Latinoamericano de Investigación

                        en Administración y Negocios. RELAYN 2022"</b>.

                        </p>

                        <p>

                        Dicho evento se llevará a cabo <a onclick="return false">bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio 

                        <b>"Vive RedesLA"</b> y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona</a>: el <b>Centro

                        Universitario de la Costa de la Universidad de Guadalajara en Puerto Vallarta, Jalisco</b>, quienes en 

                        conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b>RELAYN</b>, llevarán a cabo 

                        la organización de este congreso de investigación, los días <b>17 y 18 de noviembre del 2022</b>.

                        </p>

                        <p>

                        </p>

                        <p>

                        <b>Pago de la participación:</b><br>

                        Para continuar con su participación deberá hacer el <b>"Pago de su participación"</b> a más tardar el 19 de noviembre 

                        del presente año de: $1,100.00 (mil cien pesos 00/100 MXN) IVA incluido por ponencia, para los participantes

                        fuera de México será de: 55 USD (cincuenta y cinco dólares 00/100 USD) IVA incluido por ponencia, esta puede 

                        ser de uno a máximo de cuatro autores.

                        </p>

                        <p>

                        Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 07 de octubre del 2022,

                        con la <b>tarifa de inscripción con descuento</b>: $975 (novecientos setenta y cinco pesos 00/100 MXN) IVA incluido

                        por ponencia, para los participantes fuera de México será de 49 USD: (cuarenta y nueve dólares 00/100 USD) 

                        IVA incluido por ponencia, esta puede ser de uno a máximo de cuatro autores.

                        </p>

                        <p>

                        Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca móvil

                        o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en la cuenta clásica 

                        0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria 030685900014901994</b>, o bien 

                        pueden pagar desde esta liga de pago en línea que le permitirá pagar de forma directa, OXXO o tiendas de

                        conveniencia: <a href="https://link.mercadopago.com.mx/sdmypesredesla" target="_blank">https://link.mercadopago.com.mx/sdmypesredesla</a> 

                        </p>

                        <p>

                        Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una <a href="https://www.paypal.com/mx/webapps/mpp/country-worldwide" target="_blank">plataforma 

                        online</a> a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus bancos, 

                        o bien podrá ejecutarlo desde este link: <a href="https://paypal.me/paqueteb1?locale.x=es_XC" target="_blank>https://paypal.me/paqueteb1?locale.x=es_XC</a>.  

                        </p>

                        <p>

                        Recuerde colocar el en concepto su ID del artículo-Congreso RELAYN.

                        </p>

                        <b>MANTÉNGASE ACTUALIZADO:</b><br>

                        Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle "like" 

                        a nuestra página de Facebook para estar actualizado de todas las actividades a realizar:

                        <a href="https://www.facebook.com/Relayn.org" target="_blank">https://www.facebook.com/Relayn.org</a>

                        </p>

                        <p>

                        Esperamos verlos y contar con su presencia física o virtual, realizando la ponencia correspondiente y asistiendo a las 

                        actividades de nuestro <b>7mo. Congreso Latinoamericano de Investigación en Administración y Negocios. RELAYN 2022</b>.<br>

                        <b>#PasiónPorLaInvestigación</b>

                        </p>

                        <p>

                        Nos ponemos a sus órdenes para cualquier duda o aclaración:<br>

                        Correo: relayn@redesla.net, ponencias@relayn.org<br>

                        WhatsApp: <a target="_blank" href="https://api.whatsapp.com/send?phone=5214271067882&text=%F0%9F%8C%90%20%C2%A1Hola!%20Me%20gustar%C3%ADa%20recibir%20informaci%C3%B3n%20del%20*7mo%20Congreso%20Latinoamericano%20de%20Investigaci%C3%B3n%20en%20Administraci%C3%B3n%20y%20Negocios.%20RELAYN%202022*%2C%20me%20podr%C3%ADa%20indicar%20m%C3%A1s%20detalles%20sobre...">+52 1 4425039607 </a><br>

                        Teléfonos: 4271067882 y 4271389926

                        </p>

                        <p>

                        <img src="https://redesla.net/redesla/resources/img/firmas/Relayn_atencion.jpg" />

                        </p>

                        ';

                        $mail->SMTPDebug = 0;

                        $mail->isSMTP();

                        $mail->Host = "mail.redesla.net";

                        $mail->SMTPAuth = true;

                        $mail->Username = 'atencion@redesla.net';

                        $mail->Password = 'Atenci@n.2021';

                        $mail->SMTPSecure = 'ssl';

                        $mail->Port = 465;

                        $mail->isHTML(true);//especificamos que el correo tendra soporte html

                        $mail->setFrom("atencion@redesla.net", 'Registro oyente RELAYN '.date("Y"));

                        $mail->addAddress($_POST["miembros"][1]["correo_personal"]);

                        $mail->CharSet = 'UTF-8';

                        $mail->Subject = "Confirmación de inscripción como oyente del 7mo. Congreso Latinoamericano de Investigación en Administración y Negocios. RELAYN 2022";

                        $mail->Body = $html;

                        $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Cartel_General_RELAYN_22.jpg")), 'Cartel_General_RELAYN_22.jpg');

                        $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Mercado_Pago_SISTEMA_DESARROLLADOR.jpg")), 'Mercado_Pago_SISTEMA_DESARROLLADOR.jpg');

                        if(!$mail->send()){

                            echo "Mailer Error: " . $mail->ErrorInfo;

                        }else{

                            $this->session->set_flashdata('message','Message has been sent successfully');

                        }

                        $mail->clearAddresses();

                        $this->session->set_flashdata('message', 'success');

                        header("Location: ".base_url());

                        break;

                }

                */   
                        

            }else{
                echo $count_miembros.'<br>'.$inserciones;
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