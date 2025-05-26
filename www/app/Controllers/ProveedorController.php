<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Libraries\Mensaje;

class ProveedorController extends \Com\Daw2\Core\BaseController
{
    function mostrarTodos()
    {
        $data = [];
        $data['titulo'] = 'Todos los proveedores';
        $data['seccion'] = '/proveedores';

        $modelo = new \Com\Daw2\Models\ProveedorModel();
        $data['proveedores'] = $modelo->getAll();

        $this->view->showViews(array('templates/header.view.php', 'proveedores.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarAdd(array $input = [], array $errors = [])
    {
        $data = [];
        $data['input'] = $input;
        $data['errores'] = $errors;
        $data['titulo'] = 'Nuevo proveedor';
        $data['seccion'] = '/proveedores/add';
        $this->view->showViews(array('templates/header.view.php', 'edit.proveedor.view.php', 'templates/footer.view.php'), $data);
    }

    function mostrarEdit(string $cif, array $input = [], array $errors = [])
    {
        $data = [];
        $data['titulo'] = 'Proveedor ' . $cif;
        $modelo = new \Com\Daw2\Models\ProveedorModel();
        $data['input'] = $input === [] ? $modelo->loadProveedor($cif) : $input;
        $data['errores'] = $errors;
        $this->view->showViews(array('templates/header.view.php', 'edit.proveedor.view.php', 'templates/footer.view.php'), $data);
    }

    function delete(string $cif)
    {
        try {
            $modelo = new \Com\Daw2\Models\ProveedorModel();
            $result = $modelo->delete($cif);
            if ($result == 1) {
                $this->addFlashMessage(new Mensaje('El proveedor se ha eliminado correctamente.', Mensaje::SUCCESS));
            } else {
                $this->addFlashMessage(new Mensaje('El proveedor se ha eliminado correctamente.', Mensaje::ERROR));
            }
            header('Location: /proveedores');
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                $this->addFlashMessage(new Mensaje('El proveedor seleccionado tiene productos en el sistema y no se puede borrar', Mensaje::WARNING));
            } else {
                $this->addFlashMessage(new Mensaje($e->getMessage(), Mensaje::WARNING));
            }
            header('Location: /proveedores');
        }
    }

    function view(string $cif)
    {
        $data = [];
        $data['titulo'] = 'Proveedor ' . $cif;
        $modelo = new \Com\Daw2\Models\ProveedorModel();
        $data['proveedor'] = $modelo->loadProveedor($cif);

        $this->view->showViews(array('templates/header.view.php', 'detail.proveedor.view.php', 'templates/footer.view.php'), $data);
    }

    function add(): void
    {
        $data = [];
        $errores = $this->checkFormAdd($_POST);
        if (count($errores) === 0) {
            $modelo = new \Com\Daw2\Models\ProveedorModel();
            $result = $modelo->add($_POST['cif'], $_POST['codigo'], $_POST['nombre'], $_POST['direccion'], $_POST['website'], $_POST['pais'], $_POST['email'], $_POST['telefono']);

            if ($result == 1) {
                $this->addFlashMessage(new Mensaje('El proveedor se ha añadido correctamente.', Mensaje::SUCCESS));
            } else {
                $this->addFlashMessage(new Mensaje('Error indeterminado al guardar.', Mensaje::ERROR));
            }
            header('Location: /proveedores');
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->mostrarAdd($input, $errores);
        }
    }

    function edit(string $cif): void
    {
        $data = [];
        $errores = $this->checkFormAdd($_POST, $cif);
        if (count($errores) === 0) {
            $modelo = new \Com\Daw2\Models\ProveedorModel();
            $result = $modelo->edit($cif, $_POST['codigo'], $_POST['nombre'], $_POST['direccion'], $_POST['website'], $_POST['pais'], $_POST['email'], $_POST['telefono']);
            if ($result) {
                $this->addFlashMessage(new Mensaje('El proveedor se ha editado correctamente.', Mensaje::SUCCESS));
            } else {
                $this->addFlashMessage(new Mensaje('El proveedor se ha editado correctamente.', Mensaje::SUCCESS));
            }
            header('Location: /proveedores');
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->mostrarEdit($cif, $input, $errores);
        }
    }

    /**
     * Comprueba que el formulario es válido
     * @param array $post Valores recibidos por post
     * @return array Array de errores
     */
    function checkFormAdd(array $post, string $cif = ''): array
    {
        $errores = [];
        if (empty($post['cif'])) {
            $errores['cif'] = "Campo obligatorio";
        } elseif (!preg_match("/[a-zA-Z][0-9]{7}[a-zA-Z]/", $post['cif'])) {
            $errores['cif'] = "El cif debe seguir el siguiente formato: A0000000A";
        } elseif ($cif != '' && $cif != $post['cif']) {
            $modelo = new \Com\Daw2\Models\ProveedorModel();
            $row = $modelo->loadProveedor($cif);
            if (!is_null($row)) {
                $errores['cif'] = 'El cif se encuentra en uso por otro usuario';
            }
        }

        if (empty($post['codigo'])) {
            $errores['codigo'] = "Campo obligatorio";
        }

        if (empty($post['nombre'])) {
            $errores['nombre'] = "Campo obligatorio";
        }

        if (empty($post['website'])) {
            $errores['website'] = "Campo obligatorio";
        }

        if (empty($post['email'])) {
            $errores['email'] = "Campo obligatorio";
        }

        if (empty($post['pais'])) {
            $errores['pais'] = "Campo obligatorio";
        }

        if (empty($post['direccion'])) {
            $errores['direccion'] = "Campo obligatorio";
        }

        if (!preg_match("/[0-9+]+/", $post['telefono'])) {
            $errores['telefono'] = "El telefono debe tener un formato válido";
        }
        return $errores;
    }
}
