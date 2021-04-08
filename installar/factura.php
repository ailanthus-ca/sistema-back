<?php
if (isset($_POST["num_factura"])) {
    $num_factura = mysqli_real_escape_string($con, (strip_tags($_POST["num_factura"], ENT_QUOTES)));
    $pagina = mysqli_real_escape_string($con, (strip_tags($_POST["pagina"], ENT_QUOTES)));
    $top = mysqli_real_escape_string($con, (strip_tags($_POST["top"], ENT_QUOTES)));
    $right = mysqli_real_escape_string($con, (strip_tags($_POST["right"], ENT_QUOTES)));
    $left = mysqli_real_escape_string($con, (strip_tags($_POST["left"], ENT_QUOTES)));
    $bottom = mysqli_real_escape_string($con, (strip_tags($_POST["bottom"], ENT_QUOTES)));
    $observacion = mysqli_real_escape_string($con, (strip_tags($_POST["observacion"], ENT_QUOTES)));
    $sql = "INSERT INTO `conf_factura` VALUES (1, $num_factura, '$pagina', $top, $bottom, $left, $right, 0, '$observacion')";
    $query = $con->query($sql) or die(mysqli_error());
    header("Location: /install/");
} else {
    ?> 
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-edit"></i> Configuración de la factura </h4>
        </div>
        <div class="panel-body">
            <div id="resultados_ajax_ajuste"></div>
            <strong>Numeración</strong>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <label for="num_factura" class="col-md-4 control-label">Iniciar numeración de la factura en:  </label>
                        <div class="col-md-4">
                            <input required type="number" class="form-control" name="num_factura" id="num_factura" min="1">
                        </div>
                    </div>
                </div>        
            </div>
            <strong>Dimensiones del formato de salida</strong>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <label for="pagina" class="col-md-3 control-label">Tipo de página: </label>
                        <div class="col-md-2">
                            <select name="pagina" id="pagina" class="form-control">
                                <option selected value="LETTER">Carta</option>
                                <option value="LEGAL">Oficio</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="top" class="col-md-3 control-label">Margen superior(mm): </label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="top" id="top" value="35"> 
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="bottom" class="col-md-3 control-label">Margen inferior(mm): </label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="bottom" id="bottom" value="15">
                        </div>
                    </div>
                    <br>                        
                    <div class="row">
                        <label for="left" class="col-md-3 control-label">Margen izquierdo(mm): </label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="left" id="left" value="15">
                        </div>
                    </div>
                    <br>
                    <div class="row">  
                        <label for="right" class="col-md-3 control-label">Margen derecho(mm):  </label>
                        <div class="col-md-2">
                            <input type="number" class="form-control" name="right" id="right" value="15">
                        </div>
                    </div>
                    <br>
                    <div class="row">  
                        <label for="right" class="col-md-3 control-label">Observación:  </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="observacion" id="observacion" value="GARANTIA DEL PRODUCTO VARIA SEGÚN EL FABRICANTE O PROVEEDOR. LOS GASTOS LOGÍSTICOS POR TRAMITACIÓN DE GARANTÍAS CORREN POR CUENTA DEL CLIENTE.">
                        </div>
                    </div>                            
                </div>        
            </div>
        </div>
    </div>
    <?php
}