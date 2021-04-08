<?php
include '../templates/template.php';
include '../../config/conexion.php';
if ($_SESSION['nivel'] == 1) {
    header('Location: panel_us');
}



$sql = $con->query("SELECT *from conf_region");
if ($row = $sql->fetch_array()) {
    $cod_fiscal = $row['codigo_fiscal'];
    $moneda = $row['moneda'];
    $impuesto = $row['impuesto'];
    $impuesto1 = $row['impuesto1'];
    $monto1 = $row['monto1'];
    $impuesto2 = $row['impuesto2'];
    $monto2 = $row['monto2'];
}

$sql = $con->query("SELECT *from conf_region");
if ($row = $sql->fetch_array()) {
    $especial = $row['imp_esp'];
    if ($especial == 1) {
        $checked1 = 'checked';
        $checked0 = '';
    } else {
        $checked1 = '';
        $checked0 = 'checked';
    }
}
?>

<br><br><br>
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class='glyphicon glyphicon-edit'></i> Configuración de región </h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" id="form_region" name="form_region">
                <div id="resultados_ajax"></div>

                <strong>Ajustes</strong>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <label for="cod_fiscal" class="col-md-3 control-label">Identificación tributaria:</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="cod_fiscal" id="cod_fiscal" onkeypress="javascript: return ValidarEspacio(event, this)" value="<?php echo $cod_fiscal ?>">
                            </div>
                            <label class="control-label" style="color: red;"><em>Ejemplo: RIF, CUIT, NIT...</em></label>
                        </div>
                        <br>
                        <div class="row">
                            <label for="pagina" class="col-md-3 control-label">Tipo de moneda: </label>
                            <div class="col-md-3">
                                <select class="form-control" name="moneda"  id="moneda">
                                    <?php
                                    require_once '../../config/conexion.php';
                                    $query = $con->query('select descripcion from moneda');
                                    while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                    <option <?php if($row['descripcion'] == $moneda) echo 'descripcion'; ?> value="<?php echo $row['descripcion'] ?>"><?php echo $row['descripcion'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br> 
                        <div class="row">
                            <label for="cod_fiscal" class="col-md-3 control-label">Impuesto General (%):</label>
                            <div class="col-md-3">
                                <input type="number" step="any" class="form-control" name="impuesto" id="impuesto" value="<?php echo $impuesto ?>">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="envio" class="col-md-3 control-label">Uso de impuesto especial:</label>
                            <div class="col-md-2">
                                <input type="radio" class="" id="impuesto_esp" name="impuesto_esp" onclick="imp(this.value);" value="1" <?php echo $checked1; ?> > SI
                            </div>
                            <div class="col-md-2">
                                <input type="radio" class="" id="impuesto_esp" name="impuesto_esp" onclick="imp(this.value);" value="0" <?php echo $checked0; ?> > No
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label for="impuesto1" class="col-md-3 control-label">Impuesto 1 (%):</label>
                            <div class="col-md-2">
                                <input type="number" step="any" class="form-control" name="impuesto1" id="impuesto1" min="0" value="<?php echo $impuesto1 ?>" >
                            </div>
                            <label for="hasta" class="col-md-2 control-label">Hasta Bs:</label>
                            <div class="col-md-3">
                                <input type="number" step="any" class="form-control" name="hasta" id="hasta" min="0" value="<?php echo $monto1 ?>" >
                            </div>                          
                        </div>
                        <br>
                        <div class="row">
                            <label for="impuesto2" class="col-md-3 control-label">Impuesto 2 (%):</label>
                            <div class="col-md-2">
                                <input type="number" step="any" class="form-control" name="impuesto2" id="impuesto2" min="0" value="<?php echo $impuesto2 ?>">
                            </div>
                            <label for="mayor" class="col-md-2 control-label">Mayor a Bs:</label>
                            <div class="col-md-3">
                                <input type="number" step="any" class="form-control" name="mayor" id="mayor" min="0" value="<?php echo $monto2 ?>">
                            </div>                          
                        </div>          
                    </div>        
                </div>        
                <div class="col-md-12">
                    <div class="pull-right">       
                        <button id="guardar" type="submit" class="btn btn-default btn-lg"  data-toggle="tooltip" data-placement="top" title="Guardar cambios">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                        </button>
                    </div>  
                </div>

            </form>      

        </div>
    </div>    

</div>
<hr>

<?php
include("../templates/template_footer.php");
?>
<script type="text/javascript" src="./js/VentanaCentrada.js"></script>
<script type="text/javascript" src="./js/conf_region.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</body>
</html>

<script>
                                    function ValidarEspacio(e, campo) {
                                        key = e.keyCode ? e.keyCode : e.which;
                                        if (key == 32) {
                                            return false;
                                        }
                                    }
</script> 