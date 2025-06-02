<section class="content">
    <div class="container-fluid">
        <!--Fin header --><div class="row">
            <!--
            <div class="col-12">
                <div class="alert alert-warning"><p>No está permitido darse de baja a uno mismo.</p></div>
            </div>
            -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <div class="col-6">
                            <h6 class="m-0 installfont-weight-bold text-primary">Usuarios del sistema</h6>
                        </div>
                        <?php if (str_contains($_SESSION['permisos']['ususariosistema'],'w')){?>
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

                        Total de registros: 3                        <table id="tabladatos" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Rol</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario){?>
                                    <tr class="<?php echo ($usuario['baja'] ==1 ? 'bg-danger':'')?> ">
                                        <td><?php echo $usuario['nombre']?></td>
                                        <td><?php echo $usuario['email']?></td>
                                        <td><?php echo $usuario['rol']?></td>
                                        <td>
                                            <?php if (str_contains($_SESSION['permisos']['ususariosistema'],'w')){?>
                                            <a href="/usuarios-sistema/edit/1" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                            <a href="/usuarios-sistema/baja/1" class="btn btn-primary"> <i class="fas fa-toggle-on"></i></a>
                                            <?php }?>
                                            <?php if (str_contains($_SESSION['permisos']['ususariosistema'],'d')){?>
                                            <a href="/usuarios-sistema/delete/1" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                            <?php }?>
                                        </td>
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