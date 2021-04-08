<?php
if (isset($_POST["garantia"])) {
    $observacion = (isset($_POST["observacion"]) && $_POST["observacion"] != NULL) ? $_POST["observacion"] : ' ';
    $garantia = mysqli_real_escape_string($con, (strip_tags($_POST["garantia"], ENT_QUOTES)));
    $observacion = mysqli_real_escape_string($con, (strip_tags($observacion, ENT_QUOTES)));
    $sql1 = "INSERT INTO conf_venta (garantia,observacion) VALUES (UPPER('$garantia'),UPPER('$observacion'))";
    echo $sql1;
    $query1 = $con->query($sql1) or die(mysqli_error());
    header("Location: /install/");
} else {
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-edit"></i> Configuración de ventas </h4>
        </div>
        <div class="panel-body">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <label for="garantia" class="col-md-3 control-label">Garantia de los productos:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="garantia" id="garantia" placeholder="GARANTIA DEL PRODUCTO VARIA SEGÚN EL FABRICANTE O PROVEEDOR" required="">
                        </div>
                    </div>
                    <br> 
                    <div class="row">
                        <label for="observacion" class="col-md-3 control-label">Observación general</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="observacion" id="observacion" placeholder="EL PRECIO INDICADO ES EL TOTAL A CANCELAR INCLUYE FLETE Y ENTREGA EN BARQUISIMETO"></textarea>
                        </div>
                    </div>                     	                 
                </div>        
            </div>
        </div>
    </div>
<?php } ?>