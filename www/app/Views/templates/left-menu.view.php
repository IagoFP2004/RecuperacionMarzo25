<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="/" class="nav-link active">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Inicio
                </p>
            </a>
        </li>         
        
            <li class="nav-item menu-open">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        DB
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                
                    <ul class="nav nav-treeview">
                        <?php if (str_contains($_SESSION['PERMISOS']['usuarios-sistema'],'r')){ ?>
                        <li class="nav-item">
                            <a href="/usuarios-sistema" class="nav-link <?php echo isset($seccion) && $seccion === '/usuarios-sistema' ? 'active' : ''; ?>">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Usuarios del Sistema</p>
                            </a>
                        </li>
                        <?php }?>
                        <?php if (str_contains($_SESSION['PERMISOS']['productos'],'r')){ ?>
                        <li class="nav-item">
                            <a href="/productos" class="nav-link <?php echo isset($seccion) && $seccion === '/productos' ? 'active' : ''; ?>">
                                <i class="fas fa-shopping-bag nav-icon"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                        <?php }?>
                        <?php if (str_contains($_SESSION['PERMISOS']['categorias'],'r')){ ?>
                        <li class="nav-item">
                            <a href="/categorias" class="nav-link <?php echo isset($seccion) && $seccion === '/categorias' ? 'active' : ''; ?>">
                                <i class="fas fa-folder nav-icon"></i>
                                <p>Categorías</p>
                            </a>
                        </li>
                        <?php }?>
                        <?php if (str_contains($_SESSION['PERMISOS']['proveedores'],'r')){ ?>
                        <li class="nav-item">
                            <a href="/proveedores" class="nav-link <?php echo isset($seccion) && $seccion === '/proveedores' ? 'active' : ''; ?>">
                                <i class="fas fa-handshake nav-icon"></i>
                                <p>Proveedores</p>
                            </a>
                        </li>
                        <?php }?>
                </ul>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-database"></i>
                    <p>
                        Demos
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/demos/usuarios-sistema" class="nav-link <?php echo isset($seccion) && $seccion === '/demos/usuarios-sistema' ? 'active' : ''; ?>">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Usuarios del Sistema</p>
                            </a>
                        </li>
     
                        <li class="nav-item">
                            <a href="/demos/usuarios-sistema/add" class="nav-link <?php echo isset($seccion) && $seccion === '/demos/usuarios-sistema/edit' ? 'active' : ''; ?>">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Alta usuario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/demos/login" class="nav-link <?php echo isset($seccion) && $seccion === '/categorias' ? 'active' : ''; ?>">
                                <i class="fas fa-key nav-icon"></i>
                                <p>Login</p>
                            </a>
                        </li>                                                                       
                </ul>
            </li>
       
    </ul>
</nav>
<!-- /.sidebar-menu -->