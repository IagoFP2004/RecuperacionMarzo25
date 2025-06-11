<?php
declare(strict_types=1);
namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\RolModel;
use Com\Daw2\Models\UsuarioSistemaModel;

class UsuarioSistemaController extends BaseController
{
    public function showMenuLogin(): void
    {
        $this->view->show('login.view.php');
    }

    public function doLogin(): void
    {
        $modelo = new UsuarioSistemaModel();

        $login = $modelo->getByUsername($_POST['username']);

        if ($login !== false) {
            if (password_verify($_POST['pass'], $login['pass'])) {
                $modelo->updateDate($login['nombre']);
                $_SESSION['USUARIO'] = $login;
                $_SESSION['PERMISOS'] = $this->getPermisos($_SESSION['USUARIO']['id_rol']);
                header('Location: /');
            } else {
                $data['error'] = "Datos incorrectos";
                $data['input'] = filter_var($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->view->show('login.view.php', $data);
            }
        } else {
            $data['error'] = "Datos incorrectos";
            $data['input'] = filter_var($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->view->show('login.view.php', $data);
        }
    }

    public function getPermisos(int $idRol) :array
    {
        $permisos = [
            'usuarios-sistema' => '',
            'categorias'=>'',
            'productos'=>'',
            'proveedores'=>''
        ];

        if ($idRol == 1) {
            $permisos = [
                'usuarios-sistema' => 'rwd',
                'categorias'=>'rwd',
                'productos'=>'rwd',
                'proveedores'=>'rwd'
            ];
        }elseif ($idRol == 2) {
            $permisos = [
                'usuarios-sistema' => 'r',
                'categorias'=>'r',
                'productos'=>'r',
                'proveedores'=>'r'
            ];
        }elseif ($idRol == 3) {
            $permisos = [
                'usuarios-sistema' => '',
                'categorias'=>'',
                'productos'=>'rwd',
                'proveedores'=>'rwd'
            ];
        }

        return $permisos;
    }

    public function listado():void
    {
        $data = array(
            'titulo' => 'Gestion de Usuarios',
            'breadcrumb' => ['/usuarios-sistema']
        );

        $modelo = new UsuarioSistemaModel();
        $data['usuarios'] = $modelo->getAllUsers();

        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function cambiarBaja(int $idUsuario):void
    {
        $data = array(
        'titulo' => 'Gestion de Usuarios',
        'breadcrumb' => ['/usuarios-sistema']
    );
        $modelo = new UsuarioSistemaModel();

        if ($_SESSION['USUARIO']['id_usuario'] === $idUsuario) {
            $data['error'] = 'No está permitido darse de baja a uno mismo.';
            $data['usuarios'] = $modelo->getAllUsers();
        }else{
            $modelo->cambiarCampoBaja($idUsuario);
            $data['usuarios'] = $modelo->getAllUsers();
        }
        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function deleteUser(int $idUsuario):void
    {
        $data = array(
            'titulo' => 'Gestion de Usuarios',
            'breadcrumb' => ['/usuarios-sistema']
        );
        $modelo = new UsuarioSistemaModel();

        if ($_SESSION['USUARIO']['id_usuario'] === $idUsuario) {
            $data['error'] = 'No está permitido darse de baja a uno mismo.';
            $data['usuarios'] = $modelo->getAllUsers();
        }else{
            $modelo->deleteUser($idUsuario);
            $data['usuarios'] = $modelo->getAllUsers();
        }
        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistema.view.php', 'templates/footer.view.php'), $data);
    }

    public function showMenuAlta():void
    {
        $data = array(
            'titulo' => 'Gestion de Usuarios',
            'breadcrumb' => ['/usuarios-sistema']
        );

        $rolModel = new RolModel();

        $data['roles'] = $rolModel->getAll();

        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistemaEditAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function doAlta():void
    {
        $data = array(
            'titulo' => 'Alta de Usuarios',
            'breadcrumb' => ['/usuarios-sistema']
        );

        $modelo = new UsuarioSistemaModel();
        $rolModel = new RolModel();

        $errores = $this->checkErrors($_POST);

        if ($errores === []){
            $insertado = $modelo->insertarUsuario($_POST);

            if ($insertado !== false){
                $_SESSION['exito'] = 'El usuario ha sido registrado exitosamente.';
                header('Location: /usuarios-sistema');
            }else{
                $data['error'] = "No se pudo insertar el usuario";
                header('Location: /usuarios-sistema');
            }

        }else{
            $data['error'] = $errores;
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data['roles'] = $rolModel->getAll();
        }

        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistemaEditAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function showMenuEdit(int $idUsuario):void
    {
        $data = array(
            'titulo' => 'Edit de Usuarios',
            'breadcrumb' => ['/usuarios-sistema/edit']
        );

        $modelo = new UsuarioSistemaModel();
        $rolModel = new RolModel();

        $data['roles'] = $rolModel->getAll();
        $data['input'] = $modelo->getById($idUsuario);

        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistemaEditAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function doEdit(int $idUsuario):void
    {
        $data = array(
            'titulo' => 'Edit de Usuarios',
            'breadcrumb' => ['/usuarios-sistema/edit']
        );

        $modelo = new UsuarioSistemaModel();
        $rolModel = new RolModel();
        $errores = $this->checkErrors($_POST, $idUsuario);

        if ($errores === []){
            $editado = $modelo->actualizarUsuario($_POST,$idUsuario);

            if ($editado !== false){
                $_SESSION['exito'] = 'El usuario ha sido actualizado exitosamente.';
                header('Location: /usuarios-sistema');
            }else{
                $data['error'] = "No se pudo actualizar el usuario";
                header('Location: /usuarios-sistema');
            }

        }else{
            $data['error'] = $errores;
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $data['roles'] = $rolModel->getAll();
        $data['input'] = $modelo->getById($idUsuario);

        $this->view->showViews(array('templates/header.view.php', 'usuarios-sistemaEditAlta.view.php', 'templates/footer.view.php'), $data);
    }

    public function checkErrors(array $data, ?int $idUsuario=null):array
    {
        $errores = [];
        $editando = !is_null($idUsuario);
        $modelo = new UsuarioSistemaModel();
        $rolModel = new RolModel();

        if (!$editando || !empty($data['username'])) {
            if ( !$editando && empty($data['username'])) {
                $errores['username'] = "El nombre es obligatorio";
            }else if (!preg_match('/^[A-Za-z0-9_]{5,20}$/', $data['username'])) {
                $errores['username'] = "Longitud entre 5 y 20. Sólo letras, números y guiones bajos están permitidos.";
            }else if ($modelo->getByName($data['username']) !== false) {
                $errores['username'] = "El nombre de usuario ya existe.";
            }
        }

        if (!$editando || !empty($data['pass'])) {
            if ( !$editando && empty($data['pass'])) {
                $errores['pass'] = "El password es obligatorio";
            }else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $data['pass'])) {
                $errores['pass'] = "La contraseña no cumple el formato";
            }
        }

        if (!$editando || !empty($data['pass2'])) {
            if ( !$editando && empty($data['pass2'])) {
                $errores['pass2'] = "El password es obligatorio";
            }else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $data['pass2'])) {
                $errores['pass2'] = "La contraseña no cumple el formato";
            }else if ($data['pass2'] !== $data['pass']) {
                $errores['pass2'] ="Las contraseñas no coinciden";
            }
        }

        if (!$editando || !empty($data['email'])) {
            if ( !$editando && empty($data['email'])) {
                $errores['email'] = "El email es obligatorio";
            }else if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errores['email'] = "El email no es valido";
            }else if ($modelo->getByEmail($data['email']) !== false) {
                $errores['email'] = "El email ya existe.";
            }
        }

        if (!$editando || !empty($data['id_rol'])) {
            if ( !$editando && empty($data['id_rol'])) {
                $errores['id_rol'] = "El rol es obligatorio";
            }else if($rolModel->getById((int)$data['id_rol']) === false){
                $errores['id_rol'] = "El rol no existe";
            }
        }

        if (!$editando || !empty($data['idioma'])) {
            if ( !$editando && empty($data['idioma'])) {
                $errores['idioma'] = "El idioma es obligatorio";
            }else if (!in_array($data['idioma'], array('es', 'en', 'gl'))){
                $errores['idioma'] = "El idioma no es valido";
            }
        }

        return $errores;
    }

}