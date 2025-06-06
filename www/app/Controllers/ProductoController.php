<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Libraries\Mensaje;

class ProductoController extends \Com\Daw2\Core\BaseController {
       
    private const IVAS = [0, 4, 10, 21];
    
    function mostrarTodos(){
        $data = [];
        $data['titulo'] = 'Todos los productos';
        $data['seccion'] = '/productos';
        
        $modelo = new \Com\Daw2\Models\ProductoModel();
        $data['productos'] = $modelo->getAll();

        $this->view->showViews(array('templates/header.view.php', 'productos.view.php', 'templates/footer.view.php'), $data);
    }
    
    function mostrarAdd(array $input = [], array $errors = []){
        $data = [];
        $data['titulo'] = 'Todos los productos';
        $data['seccion'] = '/productos/add';
        $data['tituloDiv'] = 'Alta producto';
        
        $categoriaModel = new \Com\Daw2\Models\CategoriaModel();
        $data['categorias'] = $categoriaModel->getAllCategorias();
        $data['ivas'] = self::IVAS;
        //var_dump($data['categorias']); die();
        
        $proveedoresModel = new \Com\Daw2\Models\ProveedorModel();
        $data['proveedores'] = $proveedoresModel->getAll();
        $data['input'] = $input;
        $data['errores'] = $errors;

        $this->view->showViews(array('templates/header.view.php', 'edit.producto.view.php', 'templates/footer.view.php'), $data);
    }
    
    function view(string $id){
        $data = [];
        $modelo = new \Com\Daw2\Models\ProductoModel();
        $input = $modelo->loadProducto($id);
        if(is_null($input)){
            header('location: /productos');
        }
        else{
            $data['titulo'] = 'Mostrando producto: '. $input['nombre'];
            $data['tituloDiv'] = 'Datos del producto';
            $data['seccion'] = '/productos/view';
            $data['ivas'] = self::IVAS;
            
            $data['input'] = $input;

            $categoriaModel = new \Com\Daw2\Models\CategoriaModel();
            $data['categorias'] = $categoriaModel->getAllCategorias();
            //var_dump($data['categorias']); die();

            $proveedoresModel = new \Com\Daw2\Models\ProveedorModel();
            $data['proveedores'] = $proveedoresModel->getAll();

            $this->view->showViews(array('templates/header.view.php', 'edit.producto.view.php', 'templates/footer.view.php'), $data);
        }
    }
    
    function mostrarEdit(string $id, array $input = [], array $errors = []){
        $data = [];
        $modelo = new \Com\Daw2\Models\ProductoModel();
        $data['errores'] = $errors;
        $input = $input !== [] ? $input : $modelo->loadProducto($id);
        if(is_null($input)){
            header('location: /productos');
        }
        else{
            $data['titulo'] = 'Editando producto: '. $input['nombre'];
            $data['tituloDiv'] = 'Modificar producto';
            $data['seccion'] = '/productos/edit';
            $data['ivas'] = self::IVAS;
            
            $data['input'] = $input;

            $categoriaModel = new \Com\Daw2\Models\CategoriaModel();
            $data['categorias'] = $categoriaModel->getAllCategorias();
            //var_dump($data['categorias']); die();

            $proveedoresModel = new \Com\Daw2\Models\ProveedorModel();
            $data['proveedores'] = $proveedoresModel->getAll();

            $this->view->showViews(array('templates/header.view.php', 'edit.producto.view.php', 'templates/footer.view.php'), $data);
        }
    }
    
    function processAdd(){
        $errores = $this->checkForm($_POST);
        if(count($errores) > 0){
            $input = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->mostrarAdd($input, $errores);
        }
        else{
            //Procesar el alta
            $modelo = new \Com\Daw2\Models\ProductoModel();
            $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            if($modelo->insertProducto($saneado)){
                $this->addFlashMessage(new Mensaje("Producto registrado correctamente", Mensaje::SUCCESS));
            }
            else{
                $this->addFlashMessage(new Mensaje("Error indeterminado al guardar", Mensaje::ERROR));
            }
        }
    }
    
    function processEdit(string $codigo){
        $errores = $this->checkForm($_POST, false);
        $modelo = new \Com\Daw2\Models\ProductoModel();            
        if(count($errores) > 0){
            $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->mostrarEdit($codigo);

        }
        else{
            //Procesar el alta
            $modelo = new \Com\Daw2\Models\ProductoModel();
            $saneado = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            if($modelo->updateProducto($codigo, $saneado)){
                $this->addFlashMessage(new Mensaje("Producto actualizado correctamente", Mensaje::SUCCESS));
            }
            else{
                $this->addFlashMessage(new Mensaje("Error indeterminado al actualizar", Mensaje::ERROR));
            }
            header('location: /productos');
        }
    }
    
    private function checkForm(array $post, bool $alta = true){
        $errores = [];
        if($post['codigo'] == ''){
            $errores['codigo'] = 'Inserte un código';
        }
        else if(strlen($post['codigo']) > 10){
            $errores['codigo'] = 'El código debe tener una longitud máxima de 10 caracteres';
        }
        else if($alta){
            $modelo = new \Com\Daw2\Models\ProductoModel();
            $row = $modelo->loadProducto($post['codigo']);
            if(!is_null($row)){
                $errores['codigo'] = 'El código ya está en uso por otro producto.';
            }
        }
        //Es una modificación
        else{
            $modelo = new \Com\Daw2\Models\ProductoModel();
            $row = $modelo->loadProducto($post['codigo']);
            if(is_null($row)){
                $errores['codigo'] = 'No se encuentra en base de datos el producto que se desea editar.';
            }
        }
        
        if(strlen($post['nombre']) == 0){
            $errores['nombre'] = 'Debe insertar un nombre de producto.';
        }        
        
        if($post['id_categoria'] == ''){
            $errores['id_categoria'] = 'Seleccione una categoría';
        }
        else if(!is_numeric($post['id_categoria'])){
            $errores['id_categoria'] = 'Categoría seleccionada inválida.';
        }
        else{
            $categoriaModel = new \Com\Daw2\Models\CategoriaModel();
            $categoriaRow = $categoriaModel->find((int)$post['id_categoria']);
            if(is_null($categoriaRow)){
                $errores['id_categoria'] = 'La categoría seleccionada no existe.';
            }
        }
        
        if($post['proveedor'] == ''){
            $errores['proveedor'] = 'Debe seleccionar un proveedor.';
        }
        else{
            $proveedorModel = new \Com\Daw2\Models\ProveedorModel();
            $proveedorRow = $proveedorModel->loadProveedor($post['proveedor']);
            if(is_null($proveedorRow)){
                $errores['proveedor'] = 'El proveedor seleccionado no existe.';
            }
        }
        
        $numericos = ['coste', 'margen', 'stock'];
        
        foreach($numericos as $variable){
            if(!is_numeric($post[$variable])){
                $errores[$variable] = "Por favor inserte un número.";
            }
            else if($post[$variable] <= 0){
                $errores[$variable] = "El campo $variable debe tener un valor mayor que cero.";
            }
        }
         
        if($post['iva'] == ''){
            $errores['iva'] = 'Seleccione un IVA';
        }
        else if(!in_array($post['iva'], self::IVAS)){
            $errores['iva'] = 'El iva puede tener los siguientes valores: '.implode(",", self::IVAS);
        }
        return $errores;
    }
    
    public function delete(string $codigo){
        $modelo = new \Com\Daw2\Models\ProductoModel();
        if($modelo->deleteProducto($codigo)){
            $this->addFlashMessage(new Mensaje("Producto $codigo eliminado con éxito", Mensaje::SUCCESS));
        }
        else{
            $this->addFlashMessage(new Mensaje('No se ha logrado eliminar el producto '.$codigo, Mensaje::ERROR));
        }
        header('location: /productos');
    }
}