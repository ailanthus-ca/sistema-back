<?php
if (isset($_POST["nombre"])) {
    $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $clave = mysqli_real_escape_string($con, (strip_tags($_POST["clave"], ENT_QUOTES)));
    $correo = mysqli_real_escape_string($con, (strip_tags($_POST["correo"], ENT_QUOTES)));
    $clave = crypt($clave);
    $sql = "INSERT INTO usuario (nombre,correo,clave,nivel,estatus) VALUES (UPPER('$nombre'),UPPER('$correo'), '$clave', 0, 1)";
    $query = $con->query($sql);
    header("Location: /install/");
} else {
    ?>
    <div class="panel panel-info">
        <div class="panel-group" id="accordion">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="glyphicon glyphicon-user"></i> Nuevo Usuario
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="panel panel-default">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="col-md-4" for="nombre">Nombre del Usuario</label>
                                    <div class="form-group col-md-6">
                                        <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" required="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="col-md-4" for="email">Correo Electronico</label>
                                    <div class="form-group  col-md-6">
                                        <input name="correo" type="email" class="form-control" placeholder="Correo@ejemplo.com" required="" onkeypress="javascript: return ValidarEspacio(event, this)">
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <label class="col-md-4" for="clave">Contraseña</label>
                                    <div class="form-group  col-md-6">
                                        <input name="clave" type="password" class="form-control" placeholder="Ingrese una clave" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}