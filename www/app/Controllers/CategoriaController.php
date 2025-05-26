<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Libraries\Mensaje;

class CategoriaController extends \Com\Daw2\Core\BaseController
{

    function mostrarTodos()
    {
        $data = [];
        $data['titulo'] = 'Todas las categorías';
        $data['seccion'] = '/categorias';

        $modelo = new \Com\Daw2\Models\CategoriaModel();
        $res = $modelo->getAllCategorias();
        //var_dump($res); die();
        $data['categorias'] = $res;

        $this->view->showViews(array('templates/header.view.php', 'categorias.view.php', 'templates/footer.view.php'), $data);
    }

    public function mostrarAdd(array $input = [], array $errores = []): void
    {
        $data = [];
        $data['errores'] = $errores;
        $data['input'] = $input;
        $data['titulo'] = 'Nueva categoría';
        $data['seccion'] = '/categorias/add';
        $modelo = new \Com\Daw2\Models\CategoriaModel();
        $data['categorias'] = $modelo->getAllCategorias();
        $this->view->showViews(array('templates/header.view.php', 'edit.categoria.view.php', 'templates/footer.view.php'), $data);
    }

    public function mostrarEdit(int $id, array $input = [], array $errors = []): void
    {
        $data = [];
        $modelo = new \Com\Daw2\Models\CategoriaModel();
        $data['categorias'] = $modelo->getAllCategorias();
        $data['input'] = $input === [] ? $modelo->find($id) : $input;
        $data['errores'] = $errors;
        $data['titulo'] = 'Edición de categoría';
        $this->view->showViews(array('templates/header.view.php', 'edit.categoria.view.php', 'templates/footer.view.php'), $data);
    }

    public function delete(int $id): void
    {
        try {
            $modelo = new \Com\Daw2\Models\CategoriaModel();
            $result = $modelo->delete($id);
            if ($result) {
                $this->addFlashMessage(new Mensaje('Categoría eliminada correctamente.', Mensaje::SUCCESS));
            } else {
                $this->addFlashMessage(new Mensaje('No se ha podido eliminar la categoría.', Mensaje::WARNING));
            }
            header('Location: /categorias');
        }
        catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                $this->addFlashMessage(new Mensaje('La categoría seleccionada tiene categorías hija y no se puede eliminar', Mensaje::WARNING));
            }
            else {
                $this->addFlashMessage(new Mensaje($e->getMessage(), Mensaje::WARNING));
            }
            header('Location: /categorias');
        }
    }

    public function view(int $id)
    {
        $data = [];
        $modelo = new \Com\Daw2\Models\CategoriaModel();
        $data['actual'] = $modelo->find($id, true);
        $data['titulo'] = 'Ver Categoría';

        $this->view->showViews(array('templates/header.view.php', 'detail.categoria.view.php', 'templates/footer.view.php'), $data);
    }

    public function add(): void
    {
        $errores = $this->checkFormAdd($_POST);
        if (count($errores) === 0) {
            $idPadre = empty($_POST['id_padre']) ? null : (int)$_POST['id_padre'];
            $modelo = new \Com\Daw2\Models\CategoriaModel();
            if ($modelo->add((int)$_POST['id_categoria'], $_POST['nombre_categoria'], $idPadre)) {
                $this->addFlashMessage(new Mensaje('Categoría creada correctamente', Mensaje::SUCCESS));
            } else {
                $this->addFlashMessage(new Mensaje('No se ha podido crear la categoría', Mensaje::ERROR));
            }
            header('Location: /categorias');
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->mostrarAdd($input, $errores);
        }
    }

    function edit(int $id): void
    {
        $errores = $this->checkFormAdd($_POST);
        if (count($errores) === 0) {
            $modelo = new \Com\Daw2\Models\CategoriaModel();
            $idPadre = empty($_POST['id_padre']) ? null : (int)$_POST['id_padre'];
            $result = $modelo->edit((int)$_POST['id_categoria'], $_POST['nombre_categoria'], $idPadre, $id);
            if ($result) {
                $this->addFlashMessage(new Mensaje('Categoría modificada correctamente', Mensaje::SUCCESS));
            } else {
                $this->addFlashMessage(new Mensaje('No se ha podido modificar la categoría', Mensaje::ERROR));
            }
            header('Location: /categorias');
        } else {
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->mostrarEdit($id, $input, $errores);
        }
    }

    function checkFormAdd(array $post): array
    {
        $errores = [];
        if (empty($post['id_categoria'])) {
            $errores['id_categoria'] = "Campo obligatorio";
        } elseif (!preg_match("/[0-9]{1,11}/", $post['id_categoria'])) {
            $errores['id_categoria'] = "El ID solo puede contener números enteros hasta 11 cifras como máximo.";
        }

        if (empty($post['nombre_categoria'])) {
            $errores['nombre_categoria'] = "Campo obligatorio";
        }

        return $errores;
    }
}
