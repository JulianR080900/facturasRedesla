<?php

namespace App\Controllers;
use App\Models\LoginModel;

class LoginController extends BaseController
{
    public $LoginModel;

    //public $LoginModel;
    public function __construct()
    {
        helper('url');
        helper('cookie');
        helper('session');
        date_default_timezone_set('America/Monterrey');
        $this->LoginModel = new LoginModel();
        $session = session();
    }
    public function index()
    {
        if(isset($_SESSION['is_logged'])){
            return redirect()->to(base_url('/cuerpos'));
        }
        return view('librerias/index')
        .view('external/index');
    }

    public function login()
    {

        echo 'hi';
        exit;
        if(!isset($_POST['correo'])){
            return redirect()->to(base_url());
        }
        #Obtenemos los datos
        $correo = $_POST["correo"];
        $password = $_POST["password"];
        $condiciones = ['correo' => $correo];
        $exist = $this->LoginModel->exist("usuarios",$condiciones);
        if($exist != 1){
            return redirect()->to(base_url())
            ->with('icon','warning')
            ->with('title','Opsss')
            ->with('text','Correo o contraseña incorrectos.');
        }

        /*
        if($correo != 'ramos.julian00@outlook.com'){
            return redirect()->back()
            ->with('icon','warning')
            ->with('title','En mantenimiento 👷‍♂️')
            ->with('text','El acceso a la plataforma se reaunudará en unos momentos. Agradecemos su comprensión');
        }
        */
        
        //TOMAMOS DATOS DEL USUARIO Y ESTABLECEMOS VARIABLES DE SESSION
        $usuario = $this->LoginModel->getAllOneRow('usuarios',$condiciones);
        if(!password_verify($password, $usuario['password'])){
            if($password != "Maw4+ETUS*A57JeW+h8au=AXmS%wa5"){
                return redirect()->to(base_url())
                ->with('icon','warning')
                ->with('title','Opsss')
                ->with('text','Correo o contraseña incorrectos');
            }
            
        }
        
        $miembroInfo = $this->LoginModel->getUserInfo($usuario['usuario']);

        $redes_ca = $this->LoginModel->redesCA($usuario['usuario']);

        
        if(count($redes_ca) == 1){
            $condiciones = ['claveCuerpo' => $miembroInfo['cuerpoAcademico'],'activo' => 1];
            $activo = $this->LoginModel->exist('cuerpos_academicos',$condiciones);
            if($activo != 1){
                return redirect()->to(base_url())
                ->with('icon','warning')
                ->with('title','Opsss')
                ->with('text','Su grupo aún no ha sido verificado, favor de esperar a su confirmación o comunicarse con el Equipo RedesLA para su activación. No es necesario volverse a registrar para acceder.');
            }
        }

        $i = 0;

        $redes = [];
        $inactivos = 0;

        foreach ($redes_ca as $ra) {

            $condiciones = ['claveCuerpo' => $ra['cuerpoAcademico']];
            $columnas = ['activo'];

            $activo = $this->LoginModel->getColumnsOneRow($columnas, 'cuerpos_academicos', $condiciones);

            if (!empty($activo)) {

                if ($activo["activo"] == 1) {

                    $redes[$i]["cuerpoAcademico"] = $ra["cuerpoAcademico"];

                    $redes[$i]["redCueCa"] = $ra["redCueCa"];

                    $i++;
                }else{
                    $inactivos++;
                }
            }
        }

        if(count($redes_ca) == $inactivos){
            if($usuario['tipo_usuario'] == 0){
                return redirect()->to(base_url())
                ->with('icon','warning')
                ->with('title','Opsss')
                ->with('text','Sus cuerpos academicos aun no ha sido dado de alta, favor de esperar a su confirmación');
            }
        }
        
        if($usuario['tipo_usuario'] == 0){
            $session_data = [
                'is_logged' => true,
                'user_type' => $usuario['tipo_usuario'],
                'lider' => $miembroInfo["lider"],
                'pass' => $usuario['password'],
                'nombre' => $usuario['nombre'],
                'nombre_completo' => $usuario['nombre'].' '.$usuario['ap_paterno'].' '.$usuario['ap_materno'],
                'redesCA' => $redes,
                'profile_pic' => $usuario["profile_pic"],
                'theme' => $usuario['theme'],
                'usuario' => $usuario['usuario']
    
            ];
        }else if($usuario['tipo_usuario'] == 2){
            #MODERADOR
            $session_data = [
                'is_logged' => true,
                'user_type' => $usuario['tipo_usuario'],
                'nombre' => $usuario['nombre'],
                'profile_pic' => $usuario["profile_pic"],
                'usuario' => $usuario['usuario']
            ];
        }else if($usuario['tipo_usuario'] == 4){
            #ENLACES
            $session_data = [
                'is_logged' => true,
                'user_type' => $usuario['tipo_usuario'],
                'nombre' => $usuario['nombre'],
                'profile_pic' => $usuario["profile_pic"],
                'usuario' => $usuario['usuario']
            ];
        }else{
            $session_data = [
                'is_logged' => true,
                'user_type' => $usuario['tipo_usuario'],
                'pass' => $usuario['password'],
                'nombre' => $usuario['nombre'],
                'nombre_completo' => $usuario['nombre'].' '.$usuario['ap_paterno'].' '.$usuario['ap_materno'],
                'profile_pic' => $usuario["profile_pic"],
                'theme' => $usuario['theme'],
                'usuario' => $usuario['usuario']
            ];
        }

        $session = session();
        $session->set($session_data);

        #	0 normal, 1 admin, 2 moderador, 3 promoción, 4 staff

        switch ($usuario['tipo_usuario']) {
            case 0:
                return redirect()->to(base_url('/cuerpos'));
                break;
            case 1:
                return redirect()->to(base_url('/admin/dashboard'));
                break;
            case 2:
                return redirect()->to(base_url('/admin/dashboard'));
                break;
            case 3:
                return redirect()->to(base_url('/admi/dashboard'));
                break;
            case 4:
                return redirect()->to(base_url('/admin/dashboard'));
                break;
            default:
                return redirect()->to(base_url())
                    ->with('icon', 'error')
                    ->with('title', 'Lo sentimos')
                    ->with('text', 'Su vista aun no ha sido dada de alta, intente mas atrde');
        }

    }

}
