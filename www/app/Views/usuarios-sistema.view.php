<section class="content">
    <div class="container-fluid">
        <!--Fin header --><div class="row">
            <?php if (isset($error)){ ?>
            <div class="col-12">
              <div class="alert alert-warning"><p><?php echo $error ?></p></div>
            </div>
            <?php }?>
            <?php if (isset($_SESSION['exito'])){ ?>
                <div class="col-12">
                    <div class="alert alert-success"><p><?php echo $_SESSION['exito'] ?></p></div>
                </div>
            <?php }?>
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <div class="col-6">
                            <h6 class="m-0 installfont-weight-bold text-primary">Usuarios del sistema</h6>
                        </div>
                        <?php if (str_contains($_SESSION['PERMISOS']['usuarios-sistema'],'w')){ ?>
                        <div class="col-6">
                            <div class="m-0 font-weight-bold justify-content-end">
                                <a href="/usuarios-sistema/add/" class="btn btn-primary ml-1 float-right"> Nuevo Usuario del Sistema <i class="fas fa-plus-circle"></i></a>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body" id="card_table">
                        <div id="button_container" class="mb-3"></div>
                        <!--<form action="./?sec=formulario" method="post">                   -->
                        Total de registros: 3
                        <table id="tabladatos" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Rol</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($usuarios as $usuario){ ?>
                                <tr class="<?php echo ($usuario['baja']==1) ? 'table-danger' : ''?>">
                                    <td><?php echo $usuario['nombre'] ?></td>
                                    <td><?php echo $usuario['email'] ?></td>
                                    <td><?php echo $usuario['rol'] ?></td>
                                    <?php if (str_contains($_SESSION['PERMISOS']['usuarios-sistema'],'w')){ ?>
                                    <td><a href="/usuarios-sistema/edit/<?php echo $usuario['id_usuario']?>" class="btn btn-success"><i class="fas fa-edit"></i></a></td>
                                    <td><a href="/usuarios-sistema/baja/<?php echo $usuario['id_usuario']?>" class="btn btn-primary"> <i class="fas fa-toggle-on"></i></a></td>
                                    <?php }?>
                                    <?php if (str_contains($_SESSION['PERMISOS']['usuarios-sistema'],'d')){ ?>
                                    <td> <a href="/usuarios-sistema/delete/<?php echo $usuario['id_usuario']?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                                    <?php }?>
                                </tr>
                            <?php }?>
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div><!--Comienzo footer -->
    </div><!-- /.container-fluid -->
</section>