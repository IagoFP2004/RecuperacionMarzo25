<!-- Content Row -->

<div class="row">

    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Introduzca los datos de la nueva categoría</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action="/categorias/add" method="post">         
                    <!--form method="get"-->
                    <div class="row">
                        <div class="mb-3 col-sm-3">
                            <label for="cif">ID Categoría</label>
                            <input class="form-control" id="id_categoria" type="text" name="id_categoria" placeholder="ID Categoría" value="<?php echo isset($input['id_categoria']) ? $input['id_categoria'] : ''; ?>" required>
                            <p class="text-danger"><?php echo isset($errores['id_categoria']) ? $errores['id_categoria'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-5">
                            <label for="codigo">Nombre</label>
                            <input class="form-control" id="nombre_categoria" type="text" name="nombre_categoria" placeholder="Nombre de la categoría" value="<?php echo isset($input['nombre_categoria']) ? $input['nombre_categoria'] : ''; ?>" required>
                            <p class="text-danger"><?php echo isset($errores['nombre_categoria']) ? $errores['nombre_categoria'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-4">
                            <label for="nombre">Categoría Padre</label>
                            <select class="form-control select2-container--default" name="id_padre">                                
                                <option value="" selected>[Sin categoría padre] </option>
                                <?php
                                if (count($categorias) > 0) {
                                    foreach ($categorias as $c) {
                                        ?>
                                        <option value="<?php echo $c['id_categoria'] ?>" <?php echo isset($input['id_padre']) && $input['id_padre'] == $c['id_categoria'] ? 'selected' : ''; ?>><?php echo $c['fullName'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <p class="text-danger"><?php echo isset($errores['id_padre']) ? $errores['id_padre'] : ''; ?></p>

                        </div>

                        <div class="col-12 text-right">                            
                            <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                            <a href="/categorias" class="btn btn-danger ml-3">Cancelar</a>                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>