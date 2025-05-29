<?php
declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Models\UsuarioSistemaModel;

class UsuarioSistemaControllers extends \Com\Daw2\Core\BaseController
{
    public function showLogin():void
    {
       $this->view->show('login.view.php');
    }

    public function doLogin():void
    {
        $modelo = new UsuarioSistemaModel();

        $login = $modelo->getByNombre($_POST['username']);

        if ($login !== false){
            if (password_verify($_POST['pass'], $login['pass'])) {
                $_SESSION['usuario'] = $login;
                $_SESSION['permisos'] = $this->getPermisos($login['id_rol']);
                header('Location: /');
            }else{
                $data['error'] = 'Datos incorrectos';
                $data['input']=filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->view->show('login.view.php', $data);
            }
        }else{
            $data['error'] = 'Datos incorrectos';
            $data['input']=filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->view->show('login.view.php', $data);
        }
    }

    public function getPermisos(int $idRol): array
    {
        $permisos = [
            'ususariosistema'=>'',
            'categorias'=>'',
            'proveedores'=>'',
            'productos'=>'',
        ];

        if ($idRol == 1) {
            $permisos = [
                'ususariosistema'=>'rwx',
                'categorias'=>'rwx',
                'proveedores'=>'rwx',
                'productos'=>'rwx',
            ];
        }else if ($idRol == 2) {
            $permisos = [
                'ususariosistema'=>'r',
                'categorias'=>'r',
                'proveedores'=>'r',
                'productos'=>'r',
            ];
        }else if ($idRol == 3) {
            $permisos = [
                'ususariosistema'=>'',
                'categorias'=>'',
                'proveedores'=>'rwx',
                'productos'=>'rwx',
            ];
        }

        return $permisos;
    }
}