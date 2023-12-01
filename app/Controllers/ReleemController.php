<?php

namespace App\Controllers;
use App\Models\ExternalModel;
use Exception;

class ReleemController extends ExternalController
{

    public function __construct()
    {
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $this->ExternalModel = new ExternalModel();
    }

    public function insertarRegistro()
    {
        $pagina_anterior = $_SERVER['HTTP_REFERER'];
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if(date('md') >= '0909'){
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
        $data_institucion = array(
            'claveCuerpo' => $clave,
            'nombre' => $_POST["nombreUniversidad"],
            'nombre_rector' => $_POST["nombreRector"],
            'grado_rector' => $_POST["gradoRector"],
            'municipio' => $_POST["cbx_municipio"],
            'estado' => $_POST["cbx_estado"],
            'pais' => $_POST["cbx_pais"],
            'especialidad' => "especialidad pendiente",
            'direccion' => $_POST["direccionUniversidad"],
            'telefono' => $_POST["telefonoUniversidad"],
            'extension' => $_POST["extensionUniversidad"],
            'direccion_envio' => $_POST["direccionEnvio"],
            'nombre_prodep' => $_POST["nombreProdep"],
            'nivel_prodep' => $_POST["nivelProdep"],
            'ano_prodep' => $_POST["anoProdep"],
            'redCueCa' => "Releem",
            'tipo_registro' => $_POST["tipo_registro"],
            'activo' => 0,
            'inst_est' => "No aplica",
            'medio_entero' => $_POST['cbx_medio'],
            'anio_inscripcion' => $anio,
            'password' => random_int(1,100000000)
        );

        if ($this->ExternalModel->generalInsertSession("cuerpos_academicos", $data_institucion)) {
            //SE INSERTO EL REGISTRO EN CUERPOS ACADEMICOS
            //CONDICION PARA SABER SI ES PARA ESTE AñO O PARA EL SIGUIENTE
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
                "red" => "Releem"
            );
            //OBTENEMOS EL ULTIMO ID QUE SE INSERTO POR SI FALLA EL INSERTAR LOS MIEMBROS, TAMBIEN ELIMINAMOS EL CUERPO
            $id_insertado = $_SESSION["id_insertado"];
            unset($_SESSION["id_insertado"]);
            $inserciones = 0; //MIEMBROS
            $count_miembros = count($_POST["miembros"]); //MIEMBROS
            $insercionesAlumnos = 0; //ALUMNOS
            //$count_alumnos = count($_POST["alumnos"]); //ALUMNOS
            
            
            if(isset($_POST["alumnos"])){
                $count_alumnos = count($_POST["alumnos"]);
            }else{
                $count_alumnos = 0;
            }
            
            
            $i = 0; //MIEMBROS
            $e = 0; //ALUMNOS
            foreach ($_POST["miembros"] as $m) {
                $i++;
                $pass = password_hash($m['correo_personal'], PASSWORD_DEFAULT);
                if (!empty($m['usuario'])) {
                    //SIGNIFICA QUE SI HAY UN USUARIO POR LO QUE NO LO AGREGAMOS EN LA TABLA DE USUARIOS
                    $usuario = $m['usuario'];
                    //ACTUALIZAMOS LA TABLA DE USUARIOS
                    $condiciones_actualizar = ["usuario" => $usuario];
                    $data_actualizar = [
                        'Releem' => 1,
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
                        'Releem' => 1,
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
                    'redCueCa' => 'Releem',
                    'cuerpoAcademico' => $clave,
                    'pais' => $m["nacionalidad"],
                    'fecha_registro' => date("Y-m-d H:i:s")
                );
                $dataHistoria = array( //CREAMOS EL ARRAY PARA LA HISTORIA DE USUARIO
                    "usuario" => $usuario,
                    "redCueCa" => "Releem",
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
                    "red" => "Releem"
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
                    switch ($e->getMessage()) {
                        case 'miembros':
                            $condiciones = ['id' => $id_insertado];
                            $this->ExternalModel->generalDelete("cuerpos_academicos", $condiciones, "");
                            foreach ($array_miembros as $m) {
                                $condiciones = ['id' => $m];
                                $this->ExternalModel->delete("miembros", $condiciones, "");
                            }
                            return redirect()->to(base_url())
                            ->with('icon','error')
                            ->with('title','Lo sentimos')
                            ->with('text','Ha ocurrido un error. Código de error: '.$e->getCode());
                            break;
                        case 'historia_usuario':
                            $condiciones = ['id' => $id_insertado];
                            $this->ExternalModel->generalDelete("cuerpos_academicos", $condiciones, "");
                            foreach ($array_miembros as $m) {
                                $condiciones = ['id' => $m];
                                $this->ExternalModel->generalDelete("miembros", $condiciones, "");
                            }
                            foreach ($array_historia_usuario as $m) {
                                $condiciones = ['id' => $m];
                                $this->ExternalModel->generalDelete("historia_usuarios", $condiciones, "");
                            }
                            return redirect()->to(base_url())
                            ->with('icon','error')
                            ->with('title','Lo sentimos')
                            ->with('text','Ha ocurrido un error. Código de error: '.$e->getCode());
                            break;
                        case 'usuarios':
                            $condiciones = ['id' => $id_insertado];
                            $this->ExternalModel->generalDelete("cuerpos_academicos", $condiciones, "");
                            foreach ($array_miembros as $m) {
                                $condiciones = ['id' => $m];
                                $this->ExternalModel->generalDelete("miembros", $condiciones, "");
                            }
                            foreach ($array_historia_usuario as $m) {
                                $condiciones = ['id' => $m];
                                $this->ExternalModel->generalDelete("historia_usuarios", $condiciones, "");
                            }
                            foreach ($array_usuarios as $m) {
                                $condiciones = ['id' => $m];
                                $this->ExternalModel->generalDelete("usuarios", $condiciones, "");
                            }
                            return redirect()->to(base_url())
                            ->with('icon','error')
                            ->with('title','Lo sentimos')
                            ->with('text','Ha ocurrido un error. Código de error: '.$e->getCode());
                            break;

                        default:
                            # Error no identificado
                            return redirect()->to(base_url())
                            ->with('icon','error')
                            ->with('title','Lo sentimos')
                            ->with('text','Ha ocurrido un error. Código de error: 600');
                            break;
                    }
                }
            }
            if($count_alumnos > 0){
                foreach ($_POST["alumnos"] as $m) {
                    $e++;
                    $pass = password_hash($m['correo_personal'], PASSWORD_DEFAULT);
                    if (!empty($m['usuario'])) {
                        //SIGNIFICA QUE SI HAY UN USUARIO POR LO QUE NO LO AGREGAMOS EN LA TABLA DE USUARIOS
                        $usuario = $m['usuario'];
                        //ACTUALIZAMOS LA TABLA DE USUARIOS
                        $condiciones_actualizar = ["usuario" => $usuario];
                        $data_actualizar = [
                            'Releem' => 1,
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
                            'Releem' => 1,
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
                        'tipo' => 'alumno', //MAESTRO O ALUMNO (Alumno es para RELEEM)
                        'lider' => $m['lider'], //HACER INPUT PARA SABER CUAL ES
                        'redCueCa' => 'Releem',
                        'cuerpoAcademico' => $clave,
                        'pais' => $m["nacionalidad"],
                        'fecha_registro' => date("Y-m-d H:i:s")
                    );
                    $dataHistoria = array( //CREAMOS EL ARRAY PARA LA HISTORIA DE USUARIO
                        "usuario" => $usuario,
                        "redCueCa" => "Releem",
                        "cuerpoAcademico" => $clave,
                        "year" => $anio
                    );
    
                    $array_alumnos = [];
                    $array_historia_usuario_alumno = [];
                    $array_usuarios_alumnos = [];
                    //HACEMOS UN TRY-CATCH PARA LAS INSERCIONES
                    try {
                        if ($m["correo_personal"] != "") {
                            if ($this->ExternalModel->generalInsertSession('miembros', $data)) {
                                //SE INSERTO MIEMBROS, AHORA TOCA INSERTAR LA HISTORIA DE USUARIO, TOMAMOS EL ID DEL MIEMBRO Y LO AGREMAMOS A UN ARRAY
                                $id_alumno = $_SESSION["id_insertado"];
                                unset($_SESSION["id_insertado"]);
                                array_push($array_alumnos, $id_alumno);
                                if ($this->ExternalModel->generalInsertSession("historia_usuarios", $dataHistoria)) {
                                    $id_historia = $_SESSION["id_insertado"];
                                    array_push($array_historia_usuario_alumno, $id_historia);
                                    if (isset($dataUsuario)) { //SI EXISTE LA VARIABLE HACE LA INSERCION
                                        if ($m["usuario"] == "") {
                                            if ($this->ExternalModel->generalInsertSession('usuarios', $dataUsuario)) {
                                                $id_usuario = $_SESSION["id_insertado"];
                                                array_push($array_usuarios_alumnos, $id_usuario);
                                                $insercionesAlumnos++;
                                            } else {
                                                # OCURRIO UN ERROR AL INSERTAR EL USUARIO, HAY QUE BORRAR EL CUERPO ACADEMICO, LOS MIEMBROS, LAS HISTORIAS DE USUARIO Y LOS USUARIOS REGISTRADOS
                                                throw new Exception('usuarios', 102);
                                            }
                                        }
                                    }else{
                                        //NO TIENE UN USUARIO ASOCIADO AL SISTEMA, POR LO QUE ES COMPLETAMENTE NUEVO
                                        $insercionesAlumnos++;
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
                        switch ($e->getMessage()) {
                            case 'miembros':
                                $condiciones = ['id' => $id_insertado];
                                $this->ExternalModel->generalDelete("cuerpos_academicos", $condiciones, "");
                                foreach ($array_miembros as $m) {
                                    $condiciones = ['id' => $m];
                                    $this->ExternalModel->generalDelete("miembros", $condiciones, "");
                                }
                                return redirect()->to(base_url())
                                ->with('icon','error')
                                ->with('title','Lo sentimos')
                                ->with('text','Ha ocurrido un error. Código de error: '.$e->getCode());
                                break;
                            case 'historia_usuario':
                                $condiciones = ['id' => $id_insertado];
                                $this->ExternalModel->generalDelete("cuerpos_academicos", $condiciones, "");
                                foreach ($array_miembros as $m) {
                                    $condiciones = ['id' => $m];
                                    $this->ExternalModel->generalDelete("miembros", $condiciones, "");
                                }
                                foreach ($array_historia_usuario as $m) {
                                    $condiciones = ['id' => $m];
                                    $this->ExternalModel->generalDelete("historia_usuarios", $condiciones, "");
                                }
                                return redirect()->to(base_url())
                                ->with('icon','error')
                                ->with('title','Lo sentimos')
                                ->with('text','Ha ocurrido un error. Código de error: '.$e->getCode());
                                break;
                            case 'usuarios':
                                $condiciones = ['id' => $id_insertado];
                                $this->ExternalModel->generalDelete("cuerpos_academicos", $condiciones, "");
                                foreach ($array_miembros as $m) {
                                    $condiciones = ['id' => $m];
                                    $this->ExternalModel->generalDelete("miembros", $condiciones, "");
                                }
                                foreach ($array_historia_usuario as $m) {
                                    $condiciones = ['id' => $m];
                                    $this->ExternalModel->generalDelete("historia_usuarios", $condiciones, "");
                                }
                                foreach ($array_usuarios as $m) {
                                    $condiciones = ['id' => $m];
                                    $this->ExternalModel->generalDelete("usuarios", $condiciones, "");
                                }
                                return redirect()->to(base_url())
                                ->with('icon','error')
                                ->with('title','Lo sentimos')
                                ->with('text','Ha ocurrido un error. Código de error: '.$e->getCode());
                                break;
    
                            default:
                                # Error no identificado
                                return redirect()->to(base_url())
                                ->with('icon','error')
                                ->with('title','Lo sentimos')
                                ->with('text','Ha ocurrido un error. Código de error: 600');
                                break;
                        }
                    }
                }    
            }
            
            if($count_miembros == $inserciones && $count_alumnos == $insercionesAlumnos){
                //La cantidad de miembros insertados fue la misma cantidad que el usuario escribio, no ocurrio ningun error por lo que
                //insertamos la carpeta
                $this->ExternalModel->generalInsert("carpetas", $dataCarpeta);
                //mandaremos los correos
                $anio = date("Y");
                $condiciones_inv = array("red"=> "Releem","anio"=>$anio); //Esto se tiene que cambiar con cada año
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
                Por medio de la presente reciba un cordial saludo cada uno de los miembros del nuevo grupo <span style='color:#5e327c'>$clave</span>, 
                le confirmamos su participación para colaborar y ser parte de la 
                <span style='color:#5e327c'>Red de estudios latinoamericanoe sen Energía, Electrónica, Eléctrica y Mecatrónica RELEEM</span>.
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
                if(!empty($_POST["alumnos"])){
                $i = 1;
                if($count_alumnos > 0){
                    foreach($_POST["alumnos"] as $m){
                        $condiciones_ga = ["id" => $m['grado_academico']];
                        $grado_academico = $this->ExternalModel->getAll("grado_academico",$condiciones_ga);
                        $grado_academico = $grado_academico[0]["nombre"];
                        $nombre_completo = $m["nombre"]." ".$m["ap_paterno"]." ".$m["ap_materno"];
                        $html .= "
                        <h3>Alumno $i: </h3>
                        Nombre completo: $nombre_completo <br>
                        Correo electrónico: ".$m["correo_personal"]."<br> 
                        Contraseña: ".$m["correo_personal"]."<br>
                        ";
                        $i++;
                    }    
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
                <img src='https://redesla.net/redesla/resources/img/firmas/Releem.jpeg' style='width=' />
                ";
                foreach($_POST["miembros"] as $m){
                    $email = \Config\Services::email();
                    $email->setFrom('atencion@redesla.la', 'Registro RELEEM');
                    $email->setTo($m["correo_personal"]);
                    $email->setSubject('¡Bienvenidos a RELEEM!');
                    $email->setMessage($html);
            
                    if($email->send()){
                        echo 'enviado';
                    }else{
                        echo 'error';
                    }

                    $email->clear(); 
                }
                
                if(!empty($_POST["alumnos"])){
                    foreach($_POST["alumnos"] as $m){
                        $email = \Config\Services::email();
                        $email->setFrom('atencion@redesla.la', 'Registro RELEEM');
                        $email->setTo($m["correo_personal"]);
                        $email->setSubject('¡Bienvenidos a RELEEM!');
                        $email->setMessage($html);
                
                        if($email->send()){
                            echo 'enviado';
                        }else{
                            echo 'error';
                        }

                        $email->clear();  
                    }
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
                        . strtoupper("Releem")."</b>, con el fin de confirmar su participación y colaborar la 
                        investigación anual 2022 < <b><i>".$datos_investigacion[0]["nombre"]."</i></b> >, dicha red tiene como
                        objetivo general ".$datos_investigacion[0]["objetivo"]. ".
                        </p>
                        <p>
                        Solicitamos amablemente confirmen su registro de participación.
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
                                <h3>Lider: </h3>
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
                        $i = 1;
                        if($count_alumnos > 0){
                            foreach($_POST["alumnos"] as $m){
                                $condiciones_ga = ["id" => $m['grado_academico']];
                                $grado_academico = $this->ExternalModel->getAllConditions("grado_academico",$condiciones_ga);
                                $grado_academico = $grado_academico[0]["nombre"];
                                $nombre_completo = $m["nombre"]." ".$m["ap_paterno"]." ".$m["ap_materno"];
                                $html .= "
                                    <h3>Alumno $i: </h3>
                                    Nombre completo: $nombre_completo <br>
                                    Grado académico: $grado_academico <br>
                                    Especialidad: ".$m["especialidad"]."<br>
                                    Teléfono: ".$m["telefono"]."<br>
                                    Correo personal (acceso a plataforma): ".$m["correo_personal"]."<br> 
                                    Correo institucional ".$m["correo_institucional"]."<br>
                                ";
                                $i++;
                            }    
                        }
                        
                        $html .= "
                        <p>
                        <b>
                        Este correo no acepta respuestas, para enviar la confirmación de su participación, resolver dudas o aclaraciones, dejamos a continuación los medios de contacto a través de los cuales les daremos la atención debida:
                        </b>
                        </p>
                        <img src='https://redesla.net/redesla/resources/img/firmas/Releem.jpeg' />
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
                            $mail->setFrom("atencion@redesla.net", 'Registro RELEEM');
                            $mail->addAddress($m["correo_personal"]);
                            $mail->CharSet = 'UTF-8';
                            $mail->Subject = "¡Bienvenido a RELEEM!";
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
                        if($count_alumnos > 0){
                            foreach($_POST["alumnos"] as $m){
                                $mail->SMTPDebug = 0;
                                $mail->isSMTP();
                                $mail->Host = "mail.redesla.net";
                                $mail->SMTPAuth = true;
                                $mail->Username = 'atencion@redesla.net';
                                $mail->Password = 'Atenci@n.2021';
                                $mail->SMTPSecure = 'ssl';
                                $mail->Port = 465;
                                $mail->isHTML(true);//especificamos que el correo tendra soporte html
                                $mail->setFrom("atencion@redesla.net", 'Registro RELEEM');
                                $mail->addAddress($m["correo_personal"]);
                                $mail->CharSet = 'UTF-8';
                                $mail->Subject = "¡Bienvenido a RELEEM!";
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
                        }
                        
                        $this->session->set_flashdata('message', 'success');
                        header("Location: ".base_url());
                        break;
                    case 'congreso':
                        //<b><span style='color:#5e327c'></span></b>
                        $primer_autor = $_POST["miembros"][1]["nombre"] . " " . $_POST["miembros"][1]["ap_paterno"] . " " . $_POST["miembros"][1]["ap_materno"];
                        $html = "
                        <style>
                        ol {
                            counter-reset: item
                          }
                          li {
                            display: block
                          }
                          li:before {
                            content: counters(item, '.') ' ';
                            counter-increment: item
                          }
                        </style>
                        <img src='https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEEM (1).jpg' />
                        <p>
                            Apreciable investigador (a) <b>$primer_autor</b>
                        </p>
                        <p>
                            Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del <b><span style='color:#5e327c'>'2do. Congreso 
                            Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022'</span></b>.
                        </p>
                        <p>
                            Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio '<b>Vive RedesLA</b>' 
                            y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: la <b><span style='color:#5e327c'>Universidad Autónoma de Zacatecas 
                            'Francisco García Salinas' (Unidad Académica de Ingeniería Eléctrica) en Zacatecas, Zacatecas</span></b>, quienes en 
                            conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><span style='color:#5e327c'>RELEEM</span></b>, llevarán a cabo la organización 
                            de este congreso de investigación, los días <b>08 y 09 de septiembre del 2022</b>. 
                        </p>
                        <p>
                            Para continuar con su participación deberá hacer el '<b>Envío de artículo-ponencia</b>'
                        </p>
                        <p>
                            <b>Para subir su trabajo, deberá solo un participante registrarse en la plataforma de 
                            <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>iQuatro Editores</a> e iniciar sesión realizando el siguiente proceso:</b> 
                        </p>
                        <p>
                            <ol>
                                <li>
                                    Previo a este paso debe seleccionar su categoría de participación y posteriormente realizar su registro 
                                    en plataforma de iQuatro Editores: <a href='https://iquatroeditores.com/revista/index.php/iquatro/user/register'>Registrarse | Libros IQuatro(iquatroeditores.com)</a>. 
                                    Si ya cuenta con un usuario, omita este paso e inicie sesión.
                                </li>
                                <li>
                                    Dé clic en: <b>Enviar artículo</b>.  
                                </li>
                                <ol>
                                    <li>
                                        Revise que cumpla con todos los <a href='https://iquatroeditores.com/revista/index.php/iquatro/about/submissions'>requisitos</a>, antes de proceder con el envío de su artículo.
                                    </li>
                                </ol>
                                <li>
                                    En caso de que cumpla con todos los requisitos, enviar el fichero en formato Word, respetando la 
                                    '<a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a>' y plantilla de trabajo misma que contiene los parámetros mencionados en el 
                                    apartado <b>I. Formato de la <a href='https://drive.google.com/file/d/1bexeQSxXg8uLMzFHR6Rpv1hpSntbLTeu/view'>convocatoria</a></b>.
                                </li>
                                <li>
                                    Introducir <b>'los metadatos (nombre de artículo y autores)' y 'el resumen'</b>.  En la pestaña de 'CONFIRMACIÓN' 
                                    dar clic al botón: Finalizar el envío, se le asignará un ID para su trabajo. <i>Es importante que su archivo 
                                    Word no contenga el nombre de los autores para garantizar la revisión anónima</i>. 
                                </li>
                                <li>
                                    Se enviará un correo con la confirmación de recepción de ponencia por parte de iQuatro Editores, 
                                    es importante verificar la bandeja de correo no deseado, ver <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>manual</a> de envío <a href='https://drive.google.com/file/d/1bfRyeta6nTMbz2nksV4TSfk7CGVnJm7V/view'>aquí</a>. 
                                </li>
                                <li>
                                    El Comité Editorial hará una primera evaluación donde se definirá si es aceptada o rechazada la 
                                    presentación de la ponencia en el <b>2do. Congreso Latinoamericano de Investigación en Energía, 
                                    Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>. Se notificará dicho dictamen vía electrónica. 
                                </li>
                                <li>
                                    <b><i>Es importante estar al pendiente de la realización de modificaciones en caso de que se soliciten.</i></b>
                                </li>
                                <li>
                                    Una vez aceptado su trabajo como ponencia, se enviará a una dictaminación a doble ciego proceso para determinar 
                                    si dicha ponencia será publicada como capítulo en el <a href='https://www.releem.org/'>libro electrónico</a> del '<b>2do. Congreso Latinoamericano 
                                    de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</b>'.   
                                </li>
                                <li>
                                    Se notificará vía correo electrónico el dictamen de la publicación (aceptada o rechazada) y sitio de publicación; 
                                    una vez realizada la revisión por pares y enviadas sus correcciones.  
                                </li>
                                <li>
                                    Una vez aceptada la ponencia y otorgado el dictamen recibirá la carta de cesión de derechos misma que 
                                    deberá editar, firmar y subirla a la <a href='https://iquatroeditores.com/revista/index.php/iquatro/login'>plataforma</a> escaneada en formato PDF, según las indicaciones 
                                    de la editorial iQuatro Editores. 
                                </li>
                            </ol>
                        </p>
                        <p>
                            <b><u>Una vez aceptada su ponencia: </u></b>
                        </p>
                        <p>
                            Se deberá cubrir a más tardar el 05 de septiembre del presente año la <b>tarifa de inscripción</b>: $6,440.00 
                            (seis mil cuatrocientos cuarenta pesos 00/100 MXN) IVA incluido por ponencia, para los participantes 
                            fuera de México será de: 333 USD (trescientos treinta y tres dólares 00/100 USD) IVA incluido por ponencia, 
                            esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar conformados con un número mayor 
                            de alumnos y al menos con un profesor.
                        </p>
                        <p>
                            Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 18 de julio del 2022, 
                            con la <b>tarifa de inscripción con descuento</b>: $6,040.00 (seis mil cuarenta pesos 00/100 MXN) IVA incluido 
                            por ponencia, para los participantes fuera de México será de 308 USD: (trescientos ocho dólares 00/100 USD) 
                            IVA incluido por ponencia, esta puede ser de uno a máximo cuatro autores. * Los equipos pueden estar 
                            conformados con un número mayor de alumnos y al menos con un profesor.
                        </p>
                        <p>
                            Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca 
                            móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en 
                            la cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria 
                            030685900014901994</b>, o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar de forma 
                            directa, OXXO y otras tiendas de conveniencia: <a href='https://link.mercadopago.com.mx/sdmypesredesla'>https://link.mercadopago.com.mx/sdmypesredesla</a>
                        </p>
                        <p>
                            Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una plataforma 
                            online a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus 
                            bancos, o bien podrá ejecutarlo desde este link: <a href='https://paypal.me/paqueteb1?locale.x=es_XC'>https://paypal.me/paqueteb1?locale.x=es_XC</a>.   
                        </p>
                        <p>
                            Recuerde colocar el en concepto su ID del artículo-Congreso RELEEM. 
                        </p>
                        <p>
                            <b>MANTÉNGASE ACTUALIZADO:</b> 
                        </p>
                        <p>
                            Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle 
                            'like' a nuestra página de Facebook para estar actualizado de todas las actividades a realizar: <br>
                            <a href='https://www.facebook.com/RELEEM.ORG'>https://www.facebook.com/RELEEM.ORG</a>
                        </p>
                        <p>
                            Esperamos verlos y contar con su presencia física o virtual y asistiendo a las actividades de nuestro 
                            <b><span style='color:#5e327c'>2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</span></b>.<br>
                            <b><span style='color:#5e327c'>#</span>Pasión<span style='color:#5e327c'>Por</span>La<span style='color:#5e327c'>Investigación</span></b> 
                        </p>
                        <p>
                        Nos ponemos a sus órdenes para cualquier duda o aclaración: <br>
                        Correo: releem@redesla.net <br>
                        WhatsApp: <a href='https://api.whatsapp.com/send?phone=5214778433415&text=%C2%A1Hola!%0AMe%20he%20inscrito%20al%20*Congreso%20RELEEM*%2C%20me%20podr%C3%ADa%20apoyar%20con...'>+52 1 4778433415</a> <br>
                        Teléfonos: 4425039607, 4428794549
                        </p>
                        <p>
                            <img src='https://redesla.net/redesla/resources/img/firmas/Releem.jpeg' />
                        </p>
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
                            $mail->setFrom("atencion@redesla.net", 'Confirmación de inscripción como ponentes del 2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022 ');
                            $mail->addAddress($m["correo_personal"]);
                            $mail->CharSet = 'UTF-8';
                            $mail->Subject = "Confirmación de inscripción como ponentes del 2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022 ";
                            $mail->Body = $html;
                            $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Mercado_Pago_SISTEMA_DESARROLLADOR.jpg")), 'Mercado_Pago_SISTEMA_DESARROLLADOR.jpg');
                            $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Cartel_General_RELEEM.jpg")), 'Cartel General RELEEM.jpg');// \
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
                        
                        if($count_alumnos > 0){
                        
                            foreach($_POST["alumnos"] as $m){
                                $mail->SMTPDebug = 0;
                                $mail->isSMTP();
                                $mail->Host = "mail.redesla.net";
                                $mail->SMTPAuth = true;
                                $mail->Username = 'atencion@redesla.net';
                                $mail->Password = 'Atenci@n.2021';
                                $mail->SMTPSecure = 'ssl';
                                $mail->Port = 465;
                                $mail->isHTML(true);//especificamos que el correo tendra soporte html
                                $mail->setFrom("atencion@redesla.net", 'Confirmación de inscripción como ponentes del 2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022 ');
                                $mail->addAddress($m["correo_personal"]);
                                $mail->CharSet = 'UTF-8';
                                $mail->Subject = "Confirmación de inscripción como ponentes del 2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022 ";
                                $mail->Body = $html;
                                $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Mercado_Pago_SISTEMA_DESARROLLADOR.jpg")), 'Mercado_Pago_SISTEMA_DESARROLLADOR.jpg');
                                $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Cartel_General_RELEEM.jpg")), 'Cartel General RELEEM.jpg');
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
                        }
                       
                        $this->session->set_flashdata('message', 'success');
                        header("Location: ".base_url());
                        
                        break;
                    case 'oyente':
                        //<b><span style='color:#5e327c'></span></b>
                        $primer_autor = $_POST["miembros"][1]["nombre"] . " " . $_POST["miembros"][1]["ap_paterno"] . " " . $_POST["miembros"][1]["ap_materno"];
                        $html = "
                        <img src='https://redesla.net/redesla/resources/img/attachments_correos/Mailing Congreso RELEEM (1).jpg' />
                        <p>
                            Apreciable investigador (a) <b>$primer_autor</b>
                        </p>
                        <p>
                            Le confirmamos que ya contamos con su solicitud para ser parte participante-oyente del <b><span style='color:#5e327c'>'2do. Congreso 
                            Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022'</span></b>.
                        </p>
                        <p>
                            Dicho evento se llevará a cabo bajo <b>modalidad mixta</b>, siendo de <b>manera virtual</b> dentro de nuestro espacio '<b>Vive RedesLA</b>' 
                            y de <b>forma física</b> en las instalaciones de nuestra institución anfitriona: la <b><span style='color:#5e327c'>Universidad Autónoma de Zacatecas 
                            'Francisco García Salinas' (Unidad Académica de Ingeniería Eléctrica) en Zacatecas, Zacatecas</span></b>, quienes en 
                            conjunto con <b>Redes de Estudios Latinoamericanos (REDESLA)</b> a quien pertenece <b><span style='color:#5e327c'>RELEEM</span></b>, llevarán a cabo la organización 
                            de este congreso de investigación, los días <b>08 y 09 de septiembre del 2022</b>. 
                        </p>
                        <p>
                            <b><u>Pago de la participación:</u></b>
                        </p>
                        <p>
                            Para continuar con su participación deberá hacer el '<b>Pago de su participación</b>' a más tardar el 05 de 
                            septiembre del presente año de: $1,100.00 (mil cien pesos 00/100 MXN) IVA incluido por asistente, para 
                            los participantes fuera de México será de: 58 USD (cincuenta y ocho dólares 00/100 USD) IVA incluido 
                            por asistente.
                        </p>
                        <p>
                            Puede aprovechar los <b>descuentos de pronto pago</b> realizando el mismo a más tardar el 18 de julio del 2022, 
                            con la <b>tarifa de inscripción con descuento</b>: $990 (novecientos noventa pesos 00/100 MXN) IVA incluido por 
                            asistente, para los participantes fuera de México será de 49 USD: (cuarenta y nueve dólares 00/100 USD) 
                            IVA incluido por asistente.
                        </p>
                        <p>
                            Los participantes de México podrán realizar el pago mediante transferencia interbancaria desde su banca 
                            móvil o depósito bancario a la cuenta bancaria de <b>Sistema Desarrollador de Mypes SA de CV</b> en la 
                            cuenta clásica 0223143300201 del banco BANBAJIO BANCO DEL BAJIO S.A con <b>CLABE interbancaria 030685900014901994</b>, 
                            o bien pueden pagar desde esta liga de pago en línea que le permitirá pagar en OXXO y otras tiendas de 
                            conveniencia: <a href='https://link.mercadopago.com.mx/sdmypesredesla'>https://link.mercadopago.com.mx/sdmypesredesla</a>
                        </p>
                        <p>
                            Los participantes de cualquier país ajeno a México recibirán la solicitud de pago mediante una <a href='https://www.paypal.com/mx/webapps/mpp/country-worldwide'>plataforma 
                            online</a> a sus correos electrónicos y podrán realizarlo vía internet de acuerdo a las políticas de sus bancos, 
                            o bien podrá ejecutarlo desde este link: <a href='https://paypal.me/paqueteb1?locale.x=es_XC'>https://paypal.me/paqueteb1?locale.x=es_XC</a>.  
                        </p>
                        <p>
                            Recuerde colocar el en concepto su nombre-Congreso RELEEM.
                        </p>
                        <p>
                            <b>MANTÉNGASE ACTUALIZADO: </b>
                        </p>
                        <p>
                            Todos los comunicados del congreso serán enviados vía correo electrónico, pero también lo invitamos a darle 
                            'like' a nuestra página de Facebook para estar actualizado de todas las actividades a realizar: <br>
                            <a href='https://www.facebook.com/RELEEM.ORG'>https://www.facebook.com/RELEEM.ORG</a>
                        </p>
                        <p>
                            Esperamos verlos y contar con su presencia física o virtual y asistiendo a las actividades de nuestro 
                            <b><span style='color:#5e327c'>2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica RELEEM 2022</span></b>.<br>
                            <b><span style='color:#5e327c'>#</span>Pasión<span style='color:#5e327c'>Por</span>La<span style='color:#5e327c'>Investigación</span></b> 
                        </p>
                        <p>
                        Nos ponemos a sus órdenes para cualquier duda o aclaración: <br>
                        Correo: releem@redesla.net <br>
                        WhatsApp: <a href='https://api.whatsapp.com/send?phone=5214778433415&text=%C2%A1Hola!%0AMe%20he%20inscrito%20al%20*Congreso%20RELEEM*%2C%20me%20podr%C3%ADa%20apoyar%20con...'>+52 1 4778433415</a> <br>
                        Teléfonos: 4425039607, 4428794549
                        </p>
                        <p>
                            <img src='https://redesla.net/redesla/resources/img/firmas/Releem.jpeg' />
                        </p>
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
                            $mail->setFrom("atencion@redesla.net", 'Confirmación de inscripción como oyente del 2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica, RELEEM 2022');
                            $mail->addAddress($m["correo_personal"]);
                            $mail->CharSet = 'UTF-8';
                            $mail->Subject = "Confirmación de inscripción como oyente del 2do. Congreso Latinoamericano de Investigación en Energía, Electrónica, Eléctrica y Mecatrónica, RELEEM 2022";
                            $mail->Body = $html;
                            $mail->addStringAttachment(file_get_contents(base_url("resources/img/attachments_correos/Mercado_Pago_SISTEMA_DESARROLLADOR.jpg")), 'Mercado_Pago_SISTEMA_DESARROLLADOR.jpg');
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
                        // redirect(base_url());
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


}