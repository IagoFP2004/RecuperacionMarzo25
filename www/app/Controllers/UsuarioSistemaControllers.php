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
                'ususariosistema'=>'rwd',
                'categorias'=>'rwd',
                'proveedores'=>'rwd',
                'productos'=>'rwd',
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
                'proveedores'=>'rwd',
                'productos'=>'rwd',
            ];
        }

        return $permisos;
    }

    public function mostrarListado():void
    {
        $data = [];
        $data['titulo'] = 'Todos los usuarios del sistema';
        $data['seccion'] = '/usuarios-sistema';

        $modelo = new UsuarioSistemaModel();
        $data['usuarios'] = $modelo->getAllUsuarios();

        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function mostrarAlta():void
    {
        $data = [];
        $data['titulo'] = 'Alta usuarios en el sistema';
        $data['seccion'] = '/usuarios-sistema/add';
        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistemaAltaEdit.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAlta():void
    {
        $data = [];
        $data['titulo'] = 'Alta usuarios en el sistema';
        $data['seccion'] = '/usuarios-sistema/add';

        $errores = $this->checkErrors($_POST);

        if ($errores === []){

        }else{
            $data['errores'] = $errores;
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistemaAltaEdit.view.php', 'templates/footer.view.php'), $data);
    }

    public function checkErrors(array $data):array
    {
        $errors = [];
        $modelo = new UsuarioSistemaModel();

        if($modelo->getByUsername($data['username']) !==false){
            $errors['username'] = 'El nombre de usuario ya existe';
        }else if (!preg_match('/^[A-Za-z0-9_]{5,20}$/', $data['username'])) {
            $errors['username'] = 'El formato no es adecuado';
        }


        return $errors;
    }
}