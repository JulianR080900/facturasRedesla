<?php

namespace App\Controllers;
use App\Models\ExternalModel;
use Exception;

class RelepController extends ExternalController
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

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if(date('md') >= '1203'){

            $anio = date('Y')+1;

        }else{

            $anio = date('Y');

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

            'redCueCa' => "Relep",

            'tipo_registro' => $_POST["tipo_registro"],

            'activo' => 0,

            'inst_est' => $_POST["inst_est"],

            'fac_estudio' => $str_facultades,

            'medio_entero' => $_POST['cbx_medio'],

            'anio_inscripcion' => $anio,

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

                        'Relep' => 1,

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

                        'Relep' => 1,

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

                    'redCueCa' => 'Relep',

                    'cuerpoAcademico' => $clave,

                    'pais' => $m["nacionalidad"],

                    'fecha_registro' => date("Y-m-d H:i:s")

                );

                $dataHistoria = array( //CREAMOS EL ARRAY PARA LA HISTORIA DE USUARIO

                    "usuario" => $usuario,

                    "redCueCa" => "Relep",

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

                    "red" => "Relep"

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

                $condiciones_inv = array("red"=> "Relep","anio"=>$anio); //Esto se tiene que cambiar con cada año

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

                Por medio de la presente reciba un cordial saludo cada uno de los miembros del nuevo grupo <span style='color:#189B4F'>$clave</span>, 

                le confirmamos su participación para colaborar y ser parte de la 

                <span style='color:#189B4F'>Red de Estudios Latinoamericanos en Educación y Pedagogía RELEP</span>.

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

                <img src='https://redesla.la/redesla/resources/img/firmas/Relep.jpeg' />

                ";

                foreach($_POST["miembros"] as $m){

                    $email = \Config\Services::email();
                    $email->setFrom('atencion@redesla.la', 'Registro RELEP');
                    $email->setTo($m["correo_personal"]);
                    $email->setSubject('¡Bienvenidos a RELEP!');
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

                        . strtoupper("Relep")."</b>, con el fin de confirmar su participación y colaborar la 

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

                            <li>Institución/Universidad en la que se aplicará el estudio: ".$_POST["inst_est"]."</li>

                            <li>Facultades/Carreras en las que aplicarán el estudio: ".$_POST["fac_estudio"]."</li>

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

                        <img src='https://redesla.net/redesla/resources/img/firmas/Relep.jpeg' />

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

                            $mail->setFrom("atencion@redesla.net", 'Registro RELEP');

                            $mail->addAddress($m["correo_personal"]);

                            $mail->CharSet = 'UTF-8';

                            $mail->Subject = "¡Bienvenido a RELEP!";

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

                        <img src="https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEP.jpg" />

                        <p>Apreciable investigador (a) <b>' . $primer_autor . '</b></p>

                        <p>

                        Le confirmamos que ya contamos con su solicitud para ser parte del "<b>3er. Coloquio de Investigación 

                        para alumnos de Doctorado y Maestría RELEP 2022</b>", que se llevará a cabo en el marco del "<b>4to. 

                        Congreso Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022</b>". 

                        </p>

                        <p>

                        El evento será de gran relevancia académica ya que los productos que de éste deriven 

                        abonan al perfil PRODEP, al perfil SNI, al PNPC, a la consolidación de cuerpos 

                        académicos, a las certificaciones de CACECA, a programas de fortalecimiento como 

                        PIFI, PROFOCIE, PFCE.  

                        </p>

                        <p>

                        Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro 

                        de nuestro espacio "<b>Vive RedesLA</b>" y de <b>forma física</b> en las instalaciones de nuestra 

                        institución anfitriona: la <b>Universidad Latina de América en Morelia, Michoacán</b>, 

                        quienes en conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece 

                        <b>RELEP</b>, llevarán a cabo la organización de este congreso de investigación, los días <b>02 

                        y 03 de diciembre del 2022</b>. 

                        </p>

                        <p>

                        Para continuar con su participación deberá hacer el "<b>Envío de artículo-ponencia</b>" 

                        </p>

                        <p>

                        <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de 

                        iQuatro Editores e iniciar sesión realizando el siguiente proceso:</b>

                        </p>

                        <p>

                        1. Previo a este paso debe seleccionar su categoría de participación y posteriormente 

                        realizar su registro en plataforma de iQuatro Editores: <a href="https://iquatroeditores.com/revista/index.php/iquatro/user/register" target="_blank">Registrarse | Libros IQuatro

                        (iquatroeditores.com)</a>. Si ya cuenta con un usuario, omita este paso e inicie sesión.

                        </p>

                        <p>

                        2. Dé clic en: Enviar artículo.   

                        </p>

                        <p>

                        2.1. Revise que cumpla con todos los <b>requisitos</b>, antes de proceder con el envío de 

                        su artículo.  

                        </p>

                        <p>

                        3. En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, 

                        respetando la "<a href="https://drive.google.com/file/d/18PHK8RKw02Cpm_Y887QTIHiKKrIfR89A/view" target="_blank">convocatoria</a>" y el nivel (categoría) con el que participará, 

                        mismo que contiene los parámetros mencionados en el apartado <b>I. Formato de la 

                        <a href="https://drive.google.com/file/d/18PHK8RKw02Cpm_Y887QTIHiKKrIfR89A/view" target="_blank">convocatoria</a></b>.

                        </p>

                        <p>

                        4. Introducir "<b>los metadatos (nombre de artículo y autores)</b>" y "<b>el resumen</b>". 

                        En la pestaña de "CONFIRMACIÓN" dar clic al botón: Finalizar el envío, se le asignará 

                        un ID para su trabajo. <i>Es importante que su archivo Word no contenga el nombre de los 

                        autores para garantizar la revisión anónima</i>. 

                        </p>

                        <p>

                        5. Se enviará un correo con la confirmación de recepción de ponencia por parte de 

                        iQuatro Editores, es importante verificar la bandeja de correo no deseado, ver <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">manual</a> 

                        de envío <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">aquí</a>. 

                        </p>

                        <p>

                        6. El Cuerpo Arbitral conformado por investigadores expertos en el área realizará la 

                        evaluación donde se definirá si es aceptada o rechazada la presentación de la ponencia 

                        en el <b>3er. Coloquio de Investigación para alumnos de Doctorado y Maestría RELEP 2022</b> en 

                        el marco del <b>4to. Congreso Latinoamericano de Investigación en Educación y Pedagogía. 

                        RELEP 2022</b>. Se notificará dicho dictamen vía electrónica.

                        </p>

                        <p>

                        7.  <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de 

                        que se soliciten</i></b>.  Deberá confirmar si enviarán su trabajo en la categoría 4, en caso 

                        de haber seleccionado la categoría 1, 2 o 3.

                        </p>

                        <p>

                        8. Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble 

                        ciego proceso para determinar si dicha ponencia será publicada como artículo en la 

                        <a href="https://iquatroeditores.com/revista/index.php/relep/index" target="_blank">Revista RELEP</a> o como capítulo en el <a href="https://www.relep.org/biblioteca/" target="_blank">libro electrónico</a> del "<b>>4to. Congreso 

                        Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022</b".  

                        </p>

                        <p>

                        9. Se notificará vía correo electrónico el dictamen de la publicación 

                        (aceptada o rechazada) y sitio de publicación; una vez realizada la revisión por 

                        pares y enviadas sus correcciones.  

                        </p>

                        <p>

                        10. Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión 

                        de derechos misma que deberá editar, firmar y subirla a la <a href="https://iquatroeditores.com/revista/index.php/iquatro/login" target="_blank">plataforma</a> escaneada en 

                        formato PDF, según las indicaciones de la editorial iQuatro Editores.  

                        </p>

                        <p>

                        <b><u>Una vez aceptada su ponencia: </u></b>

                        </p>

                        <p>

                        Se deberá cubrir a más tardar el 21 de noviembre del presente año la <b>tarifa de 

                        inscripción</b>: $6,420.00 (seis mil cuatrocientos veinte pesos 00/100 MXN) IVA 

                        incluido por ponencia, para los participantes fuera de México será de: 331 USD 

                        (trescientos treinta y un dólares 00/100 USD) IVA incluido por ponencia, esta puede ser 

                        de uno a máximo dos autores. 

                        </p>

                        <p>

                        Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar 

                        el 15 de octubre del 2022, con la <b>tarifa de inscripción con descuento</b>: $6,020.00 

                        (seis mil veinte pesos 00/100 MXN) IVA incluido por ponencia, para los participantes 

                        fuera de México será de 306 USD: (trescientos seis dólares 00/100 USD) IVA incluido por 

                        ponencia, esta puede ser de uno a máximo dos autores. 

                        </p>

                        <p>

                        Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su 

                        banca móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> 

                        en la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria 

                        030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar 

                        de forma directa, OXXO o tiendas de conveniencia: <a href="https://link.mercadopago.com.mx/sdmypesredesla" target="_blank">https://link.mercadopago.com.mx/sdmypesredesla</a> 

                        </p>

                        <p>

                        Los participantes de cualquier país ajeno a México recibirán la solicitud de pago 

                        mediante una <a href="https://www.paypal.com/mx/webapps/mpp/country-worldwide" target="blank">plataforma online</a> a sus correos electrónicos y podrán realizarlo vía 

                        internet de acuerdo a las políticas de sus bancos, o bien podrá ejecutarlo desde este 

                        link: <a href="https://paypal.me/paqueteb1?locale.x=es_XC" target="_blank">https://paypal.me/paqueteb1?locale.x=es_XC</a>. 

                        </p>

                        <p>

                        Recuerde colocar el en concepto su ID del artículo-Coloquio RELEP.

                        </p>

                        <p>

                        <b>MANTÉNGASE ACTUALIZADO: </b>

                        </p>

                        <p>

                        Todos los comunicados del congreso serán enviados vía correo electrónico, pero también 

                        lo invitamos a darle "like" a nuestra página de Facebook para estar actualizado de todas 

                        las actividades a realizar:<br>

                        <a href="https://www.facebook.com/RELEP.ORG/" target="_blank">https://www.facebook.com/RELEP.ORG</a>

                        </p>

                        <p>

                        Esperamos verlos y contar con su presencia física o virtual, realizando la ponencia 

                        correspondiente y asistiendo a las actividades de nuestro <b>4to. Congreso 

                        Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022</b>. <br>

                        #PasiónPorLaInvestigación 

                        </p>

                        <p>

                        Nos ponemos a sus órdenes para cualquier duda o aclaración: <br>

                        Correo: relep@redesla.net, ponencias@relep.org  <br>

                        WhatsApp: +52 477 843 3415  <br>

                        Teléfonos: 4425039607, 4271389926 <br>

                        </p>

                        <p>

                        <img src="https://redesla.net/redesla/resources/img/firmas/Atencion_Relep.jpg" />

                        <img src="https://redesla.net/redesla/resources/img/firmas/Relep.jpeg" />

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

                        $mail->setFrom("atencion@redesla.net", 'Registro a Coloquio Relep '. date("Y"));

                        $mail->addAddress($_POST["miembros"][1]["correo_personal"]);

                        $mail->CharSet = 'UTF-8';

                        $mail->Subject = "Confirmación de inscripción como ponentes del 3er. Coloquio de Investigación para alumnos de Doctorado y Maestría RELEP 2022";

                        $mail->Body = $html;

                        $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Cartel_General_RELEP_22.jpg")), 'Cartel_General_RELEP_22.jpg');

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

                        <img src="https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEP.jpg" />

                        <p>Apreciable investigador (a) <b>' . $primer_autor . '</b></p>

                        <p>

                        Le confirmamos que ya contamos con su solicitud para ser parte del "<b>4to. Congreso 

                        Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022</b>". 

                        </p>

                        <p>

                        El evento será de gran relevancia académica ya que los productos que de éste deriven 

                        abonan al perfil PRODEP, al perfil SNI, al PNPC, a la consolidación de cuerpos 

                        académicos, a las certificaciones de CACECA, a programas de fortalecimiento como 

                        PIFI, PROFOCIE, PFCE.  

                        </p>

                        <p>

                        Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro 

                        de nuestro espacio "<b>Vive RedesLA</b>" y de <b>forma física</b> en las instalaciones de nuestra 

                        institución anfitriona: la <b>Universidad Latina de América en Morelia, Michoacán</b>, 

                        quienes en conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece 

                        <b>RELEP</b>, llevarán a cabo la organización de este congreso de investigación, los días <b>02 

                        y 03 de diciembre del 2022</b>. 

                        </p>

                        <p>

                        Para continuar con su participación deberá hacer el "<b>Envío de artículo-ponencia</b>" 

                        </p>

                        <p>

                        <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de 

                        iQuatro Editores e iniciar sesión realizando el siguiente proceso:</b>

                        </p>

                        <p>

                        1. Previo a este paso debe seleccionar su categoría de participación y posteriormente 

                        realizar su registro en plataforma de iQuatro Editores: <a href="https://iquatroeditores.com/revista/index.php/iquatro/user/register" target="_blank">Registrarse | Libros IQuatro

                        (iquatroeditores.com)</a>. Si ya cuenta con un usuario, omita este paso e inicie sesión.

                        </p>

                        <p>

                        2. Dé clic en: Enviar artículo.   

                        </p>

                        <p>

                        2.1. Revise que cumpla con todos los <b>requisitos</b>, antes de proceder con el envío de 

                        su artículo.  

                        </p>

                        <p>

                        3. En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, 

                        respetando la "<a href="https://drive.google.com/file/d/18PHK8RKw02Cpm_Y887QTIHiKKrIfR89A/view" target="_blank">convocatoria</a>" y el nivel (categoría) con el que participará, 

                        mismo que contiene los parámetros mencionados en el apartado <b>I. Formato de la 

                        <a href="https://drive.google.com/file/d/18PHK8RKw02Cpm_Y887QTIHiKKrIfR89A/view" target="_blank">convocatoria</a></b>.

                        </p>

                        <p>

                        4. Introducir "<b>los metadatos (nombre de artículo y autores)</b>" y "<b>el resumen</b>". 

                        En la pestaña de "CONFIRMACIÓN" dar clic al botón: Finalizar el envío, se le asignará 

                        un ID para su trabajo. <i>Es importante que su archivo Word no contenga el nombre de los 

                        autores para garantizar la revisión anónima</i>. 

                        </p>

                        <p>

                        5. Se enviará un correo con la confirmación de recepción de ponencia por parte de 

                        iQuatro Editores, es importante verificar la bandeja de correo no deseado, ver <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">manual</a> 

                        de envío <a href="https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view" target="_blank">aquí</a>. 

                        </p>

                        <p>

                        El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o 

                        rechazada la presentación de la ponencia en el <b>4to. Congreso Latinoamericano de 

                        Investigación en Educación y Pedagogía. RELEP 2022</b>. Se notificará dicho dictamen 

                        vía electrónica. 

                        </p>

                        <p>

                        7.  <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de 

                        que se soliciten</i></b>.

                        </p>

                        <p>

                        8. Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble 

                        ciego proceso para determinar si dicha ponencia será publicada como artículo en la 

                        <a href="https://iquatroeditores.com/revista/index.php/relep/index" target="_blank">Revista RELEP</a> o como capítulo en el <a href="https://www.relep.org/biblioteca/" target="_blank">libro electrónico</a> del "<b>>4to. Congreso 

                        Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022</b>".  

                        </p>

                        <p>

                        9. Se notificará vía correo electrónico el dictamen de la publicación 

                        (aceptada o rechazada) y sitio de publicación; una vez realizada la revisión por 

                        pares y enviadas sus correcciones.  

                        </p>

                        <p>

                        10. Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión 

                        de derechos misma que deberá editar, firmar y subirla a la <a href="https://iquatroeditores.com/revista/index.php/iquatro/login" target="_blank">plataforma</a> escaneada en 

                        formato PDF, según las indicaciones de la editorial iQuatro Editores.  

                        </p>

                        <p>

                        <b><u>Una vez aceptada su ponencia: </u></b>

                        </p>

                        <p>

                        Se deberá cubrir a más tardar el 21 de noviembre del presente año la <b>tarifa de 

                        inscripción</b>: $6,420.00 (seis mil cuatrocientos veinte pesos 00/100 MXN) IVA 

                        incluido por ponencia, para los participantes fuera de México será de: 331 USD 

                        (trescientos treinta y un dólares 00/100 USD) IVA incluido por ponencia, esta puede ser 

                        de uno a máximo dos autores. 

                        </p>

                        <p>

                        Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar 

                        el 15 de octubre del 2022, con la <b>tarifa de inscripción con descuento</b>: $6,020.00 

                        (seis mil veinte pesos 00/100 MXN) IVA incluido por ponencia, para los participantes 

                        fuera de México será de 306 USD: (trescientos seis dólares 00/100 USD) IVA incluido por 

                        ponencia, esta puede ser de uno a máximo dos autores. 

                        </p>

                        <p>

                        Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su 

                        banca móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> 

                        en la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria 

                        030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar 

                        de forma directa, OXXO o tiendas de conveniencia: <a href="https://link.mercadopago.com.mx/sdmypesredesla" target="_blank">https://link.mercadopago.com.mx/sdmypesredesla</a> 

                        </p>

                        <p>

                        Los participantes de cualquier país ajeno a México recibirán la solicitud de pago 

                        mediante una <a href="https://www.paypal.com/mx/webapps/mpp/country-worldwide" target="blank">plataforma online</a> a sus correos electrónicos y podrán realizarlo vía 

                        internet de acuerdo a las políticas de sus bancos, o bien podrá ejecutarlo desde este 

                        link: <a href="https://paypal.me/paqueteb1?locale.x=es_XC" target="_blank">https://paypal.me/paqueteb1?locale.x=es_XC</a>. 

                        </p>

                        <p>

                        Recuerde colocar el en concepto su ID del artículo-Congreso RELEP. 

                        </p>

                        <p>

                        <b>MANTÉNGASE ACTUALIZADO: </b>

                        </p>

                        <p>

                        Todos los comunicados del congreso serán enviados vía correo electrónico, pero también 

                        lo invitamos a darle "like" a nuestra página de Facebook para estar actualizado de todas 

                        las actividades a realizar:<br>

                        <a href="https://www.facebook.com/RELEP.ORG/" target="_blank">https://www.facebook.com/RELEP.ORG</a>

                        </p>

                        <p>

                        Esperamos verlos y contar con su presencia física o virtual, realizando la ponencia 

                        correspondiente y asistiendo a las actividades de nuestro <b>4to. Congreso 

                        Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022</b>. <br>

                        #PasiónPorLaInvestigación 

                        </p>

                        <p>

                        Nos ponemos a sus órdenes para cualquier duda o aclaración: <br>

                        Correo: relep@redesla.net, ponencias@relep.org  <br>

                        WhatsApp: +52 477 843 3415  <br>

                        Teléfonos: 4425039607, 4271389926 <br>

                        </p>

                        <p>

                        <img src="https://redesla.net/redesla/resources/img/firmas/Atencion_Relep.jpg" />

                        <img src="https://redesla.net/redesla/resources/img/firmas/Relep.jpeg" />

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

                        $mail->setFrom("atencion@redesla.net", 'Registro a Congreso Relep ' .date("Y"));

                        $mail->addAddress($_POST["miembros"][1]["correo_personal"]);

                        $mail->CharSet = 'UTF-8';

                        $mail->Subject = "Confirmación de inscripción como ponentes del 4to. Congreso Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022";

                        $mail->Body = $html;

                        $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Cartel_General_RELEP_22.jpg")), 'Cartel_General_RELEP_22.jpg');

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

                        <img src="https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEP.jpg" />

                        <p>Apreciable investigador (a) <b>' . $primer_autor . '</b></p>

                        <p>

                        Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del 

                        "<b>4to. Congreso Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022</b>".  

                        </p>

                        <p>

                        Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro 

                        de nuestro espacio "<b>Vive RedesLA</b>" y de <b>forma física</b> en las instalaciones de nuestra 

                        institución anfitriona: la <b>Universidad Latina de América en Morelia, Michoacán</b>, 

                        quienes en conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece 

                        <b>RELEP</b>, llevarán a cabo la organización de este congreso de investigación, los días <b>02 

                        y 03 de diciembre del 2022</b>. 

                        </p>

                        <p>

                        <b><u>Pago de la participación:</u></b>

                        </p>

                        <p>

                        Para continuar con su participación deberá hacer el "<b>Pago de su participación</b>" a más 

                        tardar el 21 de noviembre del presente año de: $1,120.00 (mil ciento veinte pesos 

                        00/100 MXN) IVA incluido por asistente, para los participantes fuera de México será 

                        de: 56 USD (cincuenta y seis dólares 00/100 USD) IVA incluido por asistente.

                        </p>

                        <p>

                        Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 15 de 

                        octubre del 2022, con la <b>tarifa de inscripción con descuento</b>: $980 (novecientos ochenta 

                        pesos 00/100 MXN) IVA incluido por asistente, para los participantes fuera de México será 

                        de 49 USD: (cuarenta y nueve dólares 00/100 USD) IVA incluido por asistente.

                        </p>

                        <p>

                        Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su 

                        banca móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> 

                        en la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria 

                        030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar 

                        de forma directa, OXXO o tiendas de conveniencia: <a href="https://link.mercadopago.com.mx/sdmypesredesla" target="_blank">https://link.mercadopago.com.mx/sdmypesredesla</a> 

                        </p>

                        <p>

                        Los participantes de cualquier país ajeno a México recibirán la solicitud de pago 

                        mediante una <a href="https://www.paypal.com/mx/webapps/mpp/country-worldwide" target="blank">plataforma online</a> a sus correos electrónicos y podrán realizarlo vía 

                        internet de acuerdo a las políticas de sus bancos, o bien podrá ejecutarlo desde este 

                        link: <a href="https://paypal.me/paqueteb1?locale.x=es_XC" target="_blank">https://paypal.me/paqueteb1?locale.x=es_XC</a>. 

                        </p>

                        <p>

                        Recuerde colocar el en concepto su nombre-Congreso RELEP.

                        </p>

                        <p>

                        <b>MANTÉNGASE ACTUALIZADO: </b>

                        </p>

                        <p>

                        Todos los comunicados del congreso serán enviados vía correo electrónico, pero también 

                        lo invitamos a darle "like" a nuestra página de Facebook para estar actualizado de todas 

                        las actividades a realizar:<br>

                        <a href="https://www.facebook.com/RELEP.ORG/" target="_blank">https://www.facebook.com/RELEP.ORG</a>

                        </p>

                        <p>

                        Esperamos verlos y contar con su presencia física o virtual, realizando la ponencia 

                        correspondiente y asistiendo a las actividades de nuestro <b>4to. Congreso 

                        Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022</b>. <br>

                        #PasiónPorLaInvestigación 

                        </p>

                        <p>

                        Nos ponemos a sus órdenes para cualquier duda o aclaración: <br>

                        Correo: relep@redesla.net, ponencias@relep.org  <br>

                        WhatsApp: +52 477 843 3415  <br>

                        Teléfonos: 4425039607, 4271389926 <br>

                        </p>

                        <p>

                        <img src="https://redesla.net/redesla/resources/img/firmas/Relep.jpeg" />

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

                        $mail->setFrom("atencion@redesla.net", 'Registro oyente Relep '.date("Y"));

                        $mail->addAddress($_POST["miembros"][1]["correo_personal"]);

                        $mail->CharSet = 'UTF-8';

                        $mail->Subject = "Confirmación de inscripción como oyente del 4to. Congreso Latinoamericano de Investigación en Educación y Pedagogía. RELEP 2022";

                        $mail->Body = $html;

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