<?php
declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    public function mostrarMenuLogin():void
    {
        $this->view->show('login.view.php');
    }

    public function doLogin():void
    {
        $modelo = new UsuarioModel();

        $login = $modelo->getByUserName($_POST['username']);

        if ($login !== false) {
            if (password_verify($_POST['password'],$login['pass'])){
                $_SESSION['usuario'] = $login;
                header('Location: /');
            }else{
                $data['error'] = 'Datos incorrectos';
                $this->view->show('login.view.php');
            }
        }else{
            $data['error'] = 'Datos incorrectos';
            $this->view->show('login.view.php');
        }
    }
}