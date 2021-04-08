<?php
if (isset($_POST["num_fiscal"])) {
    $num_fiscal = mysqli_real_escape_string($con, (strip_tags($_POST["num_fiscal"], ENT_QUOTES)));
    $nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $direccion = mysqli_real_escape_string($con, (strip_tags($_POST["direccion"], ENT_QUOTES)));
    $telefono = mysqli_real_escape_string($con, (strip_tags($_POST["telefono"], ENT_QUOTES)));
    $correo = mysqli_real_escape_string($con, (strip_tags($_POST["correo"], ENT_QUOTES)));
    $web = mysqli_real_escape_string($con, (strip_tags($_POST["web"], ENT_QUOTES)));
    $pago = mysqli_real_escape_string($con, (strip_tags($_POST["pago"], ENT_QUOTES)));
    $eslogan = mysqli_real_escape_string($con, (strip_tags($_POST["eslogan"], ENT_QUOTES)));

    if (isset($_FILES["logo"])) {
        $file = $_FILES["logo"];
        $logo = $file["name"];
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $ruta_provisional = $file["tmp_name"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "../public/imagenes/";
        $src = $carpeta . $logo;
        move_uploaded_file($ruta_provisional, $src);
    } else {
        $logo = '';
    }
    if ($logo != "") {
       $sql1 = "INSERT INTO conf_empresa VALUES (null, UPPER('$nombre'), UPPER('$num_fiscal'), UPPER('$direccion'), UPPER('$telefono'), UPPER('$correo'), UPPER('$web'), UPPER('$pago'), 'isotipo plano rgb res300 jpg.jpg', UPPER('$eslogan'))";
    } else {
        $sql1 = "INSERT INTO conf_empresa VALUES (null, UPPER('$nombre'), UPPER('$num_fiscal'), UPPER('$direccion'), UPPER('$telefono'), UPPER('$correo'), UPPER('$web'), UPPER('$pago'), '$logo', UPPER('$eslogan'))";
    }
    $query1 = $con->query($sql1) or die(mysqli_error());
    header("Location: /install/");

} else {
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-edit"></i> Datos de la empresa </h4>
        </div>
        <div class="panel-body">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <label for="num_fiscal" class="col-md-3 control-label">Número fiscal:</label>
                        <div class="col-md-3">
                            <input required type="text" class="form-control" name="num_fiscal" id="num_fiscal" onkeypress="javascript: return ValidarEspacio(event, this)" placeholder="J-40031173-0">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="nombre" class="col-md-3 control-label">Nombre:</label>
                        <div class="col-md-8">
                            <input required type="text" class="form-control" name="nombre" id="nombre" placeholder="AILANTHUS SISTEMS CA">
                        </div>
                    </div>
                    <br> 
                    <div class="row">
                        <label for="direccion" class="col-md-3 control-label">Dirección</label>
                        <div class="col-md-8">
                            <textarea required class="form-control" name="direccion" id="direccion" placeholder="CARRERA 4, ESQUINA CALLE 18, ZONA INDUSTIAL I, GALPON MANPEG, PISO. 1 OFC.3, BARQUISIMETO, ESTADO LARA."></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="telefono" class="col-md-3 control-label">Telefonos:</label>
                        <div class="col-md-8">
                            <input type="text" required class="form-control" name="telefono" id="telefono" placeholder="(58) 251-2378406 (TELEFAX) / 2528375, (58) 414-5088735 / 416-6506831">
                        </div>
                    </div>
                    <br> 
                    <div class="row">
                        <label for="correo" class="col-md-3 control-label">Correo:</label>
                        <div class="col-md-8">
                            <input type="text" required class="form-control" name="correo" id="correo" placeholder="VENTAS@AILANTHUS-SISTEMS.COM">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="web" class="col-md-3 control-label">Sitio Web:</label>
                        <div class="col-md-8">
                            <input type="text" required class="form-control" name="web" id="web" placeholder="WWW.AILANTHUS-SISTEMS.COM">
                        </div>
                    </div>                    
                    <br>
                    <div class="row">
                        <label for="pago" class="col-md-3 control-label">Información de pago:</label>
                        <div class="col-md-8">
                            <textarea required class="form-control" name="pago" id="pago" placeholder="Puede ingresar Información como cuentas bancarias, nombre del titular, entre otros..."></textarea>
                        </div>
                    </div>                    
                    <br> 
                    <div class="row">
                        <label for="logo" class="col-md-3 control-label">logo:</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control" name="logo" id="logo">
                        </div>
                    </div>  
                    <br>                   
                    <div class="row">
                        <label for="eslogan" class="col-md-3 control-label">Eslogan:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="eslogan" id="eslogan" placeholder="TECNOLOGÍA TOTAL EN INGENIERÍA Y SERVICIO">
                        </div>
                    </div>                     	                 
                </div>        
            </div>       
        </div>
    </div>    
    <?php
}    