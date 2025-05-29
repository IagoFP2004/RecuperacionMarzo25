<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\UsuarioSistemaControllers;
use Steampixel\Route;

class FrontController
{

    static function main()
    {
        session_start();
        if (!isset($_SESSION['usuario'])) {

            Route::add(
                '/login',
                function () {
                    $controlador =  new UsuarioSistemaControllers();
                    $controlador->showLogin();
                },
                'get'
            );

            Route::add(
                '/login',
                function () {
                    $controlador =  new UsuarioSistemaControllers();
                    $controlador->doLogin();
                },
                'post'
            );

            Route::pathNotFound(
                function () {
                   header('Location: /login');
                }
            );

        }else {
            //Rutas que están disponibles para todos

            Route::add(
                '/logout',
                function () {
                    session_destroy();
                    header('Location: /login');
                },
                'get'
            );

            Route::add(
                '/',
                function () {
                    $controlador = new \Com\Daw2\Controllers\InicioController();
                    $controlador->index();
                },
                'get'
            );

            //Demos
            Route::add(
                '/demos/usuarios-sistema',
                function () {
                    $controlador = new \Com\Daw2\Controllers\InicioController();
                    $controlador->demoUsuariosSistema();
                },
                'get'
            );

            Route::add(
                '/demos/usuarios-sistema/add',
                function () {
                    $controlador = new \Com\Daw2\Controllers\InicioController();
                    $controlador->demoUsuariosSistemaAdd();
                },
                'get'
            );

            Route::add(
                '/demos/login',
                function () {
                    $controlador = new \Com\Daw2\Controllers\InicioController();
                    $controlador->demoLogin();
                },
                'get'
            );
            if (str_contains($_SESSION['permisos']['categorias'],'r')) {
                # Gestion de categorías
                Route::add(
                    '/categorias',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\CategoriaController();
                        $controlador->mostrarTodos();
                    },
                    'get'
                );

                Route::add(
                    '/categorias/view/([0-9]+)',
                    function ($id) {
                        $controlador = new \Com\Daw2\Controllers\CategoriaController();
                        $controlador->view((int)$id);
                    },
                    'get'
                );
                if (str_contains($_SESSION['permisos']['categorias'],'d')) {
                    Route::add(
                        '/categorias/delete/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\CategoriaController();
                            $controlador->delete($id);
                        },
                        'get'
                    );
                }
                if (str_contains($_SESSION['permisos']['categorias'],'w')) {
                    Route::add(
                        '/categorias/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\CategoriaController();
                            $controlador->mostrarEdit((int)$id);
                        },
                        'get'
                    );

                    Route::add(
                        '/categorias/edit/([0-9]+)',
                        function ($id) {
                            $controlador = new \Com\Daw2\Controllers\CategoriaController();
                            $controlador->edit($id);
                        },
                        'post'
                    );

                    Route::add(
                        '/categorias/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\CategoriaController();
                            $controlador->mostrarAdd();
                        },
                        'get'
                    );

                    Route::add(
                        '/categorias/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\CategoriaController();
                            $controlador->add();
                        },
                        'post'
                    );
                }
            }
            if (str_contains($_SESSION['permisos']['productos'],'r')){
                //Produtos
                Route::add(
                    '/productos',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\ProductoController();
                        $controlador->mostrarTodos();
                    },
                    'get'
                );
                Route::add(
                    '/productos/view/([A-Za-z0-9]+)',
                    function ($codigo) {
                        $controlador = new \Com\Daw2\Controllers\ProductoController();
                        $controlador->view($codigo);
                    },
                    'get'
                );

                if (str_contains($_SESSION['permisos']['productos'],'d')) {
                    Route::add(
                        '/productos/delete/([A-Za-z0-9]+)',
                        function ($codigo) {
                            $controlador = new \Com\Daw2\Controllers\ProductoController();
                            $controlador->delete($codigo);
                        },
                        'get'
                    );
                }
                if (str_contains($_SESSION['permisos']['productos'],'w')) {
                    Route::add(
                        '/productos/edit/([A-Za-z0-9]+)',
                        function ($codigo) {
                            $controlador = new \Com\Daw2\Controllers\ProductoController();
                            $controlador->mostrarEdit($codigo);
                        },
                        'get'
                    );

                    Route::add(
                        '/productos/edit/([A-Za-z0-9]+)',
                        function ($codigo) {
                            $controlador = new \Com\Daw2\Controllers\ProductoController();
                            $controlador->processEdit($codigo);
                        },
                        'post'
                    );

                    Route::add(
                        '/productos/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\ProductoController();
                            $controlador->mostrarAdd();
                        },
                        'get'
                    );

                    Route::add(
                        '/productos/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\ProductoController();
                            $controlador->processAdd();
                        },
                        'post'
                    );
                }
            }
            //Proveedores
            if (str_contains($_SESSION['permisos']['proveedores'],'r')) {
                Route::add(
                    '/proveedores',
                    function () {
                        $controlador = new \Com\Daw2\Controllers\ProveedorController();
                        $controlador->mostrarTodos();
                    },
                    'get'
                );

                Route::add(
                    '/proveedores/view/([A-Za-z0-9]+)',
                    function ($cif) {
                        $controlador = new \Com\Daw2\Controllers\ProveedorController();
                        $controlador->view($cif);
                    },
                    'get'
                );

                if (str_contains($_SESSION['permisos']['proveedores'], 'd')) {
                    Route::add(
                        '/proveedores/delete/([A-Za-z0-9]+)',
                        function ($cif) {
                            $controlador = new \Com\Daw2\Controllers\ProveedorController();
                            $controlador->delete($cif);
                        },
                        'get'
                    );
                }
                if (str_contains($_SESSION['permisos']['proveedores'], 'w')) {
                    Route::add(
                        '/proveedores/edit/([A-Za-z0-9]+)',
                        function ($cif) {
                            $controlador = new \Com\Daw2\Controllers\ProveedorController();
                            $controlador->mostrarEdit($cif);
                        },
                        'get'
                    );

                    Route::add(
                        '/proveedores/edit/([A-Za-z0-9]+)',
                        function ($cif) {
                            $controlador = new \Com\Daw2\Controllers\ProveedorController();
                            $controlador->edit($cif);
                        },
                        'post'
                    );

                    Route::add(
                        '/proveedores/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\ProveedorController();
                            $controlador->mostrarAdd();
                        },
                        'get'
                    );

                    Route::add(
                        '/proveedores/add',
                        function () {
                            $controlador = new \Com\Daw2\Controllers\ProveedorController();
                            $controlador->add();
                        },
                        'post'
                    );
                }
            }
            Route::pathNotFound(
                function () {
                    $controller = new \Com\Daw2\Controllers\ErroresController();
                    $controller->error404();
                }
            );

            Route::methodNotAllowed(
                function () {
                    $controller = new \Com\Daw2\Controllers\ErroresController();
                    $controller->error405();
                }
            );

        }
        Route::run();
    }
}
