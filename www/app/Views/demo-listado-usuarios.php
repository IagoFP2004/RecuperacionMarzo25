<div class="row">       
    <div class="col-12">
        <div class="alert alert-warning"><p>No está permitido darse de baja a uno mismo.</p></div>
    </div>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="col-6">
                    <h6 class="m-0 installfont-weight-bold text-primary">Usuarios del sistema</h6> 
                </div>
                <div class="col-6">
                    <div class="m-0 font-weight-bold justify-content-end">
                        <a href="/usuarios-sistema/add/" class="btn btn-primary ml-1 float-right"> Nuevo Usuario del Sistema <i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body" id="card_table">
                <div id="button_container" class="mb-3"></div>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <table id="tabladatos" class="table table-striped">                    
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>                          
                            <th>Email</th>                            
                            <th>Rol</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td>1</td>
                            <td>administrador</td>
                            <td>admin@test.org</td>    
                            <td>Administrador</td>   
                            <td>                                        
                                <a href="/usuarios-sistema/edit/1" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                <a href="/usuarios-sistema/baja/1" class="btn btn-primary"> <i class="fas fa-toggle-on"></i></a>
                                <a href="/usuarios-sistema/delete/1" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>

                        </tr>
                        <tr class="">
                            <td>93</td>
                            <td>facturacion</td>
                            <td>facturacion@test.org</td>    
                            <td>Facturación</td>   
                            <td>                                        
                                <a href="/usuarios-sistema/edit/93" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                <a href="/usuarios-sistema/baja/93" class="btn btn-primary"> <i class="fas fa-toggle-on"></i></a>
                                <a href="/usuarios-sistema/delete/93" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>

                        </tr>
                        <tr class="table-danger">
                            <td>95</td>
                            <td>auditor</td>
                            <td>auditor@test.org</td>    
                            <td>Auditor</td>   
                            <td>                                        
                                <a href="/usuarios-sistema/edit/95" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                <a href="/usuarios-sistema/baja/95" class="btn btn-secondary"> <i class="fas fa-toggle-off"></i></a>
                                <a href="/usuarios-sistema/delete/95" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>

                        </tr>
                    </tbody>
                    <tfoot>
                        Total de registros: 3                        </tfoot>
                </table>
            </div>
        </div>
    </div>                        
</div>