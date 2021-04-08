<?php
if (isset($_POST["cod_fiscal"])) {
    $cod_fiscal = mysqli_real_escape_string($con, (strip_tags($_POST["cod_fiscal"], ENT_QUOTES)));
    $moneda = mysqli_real_escape_string($con, (strip_tags($_POST["moneda"], ENT_QUOTES)));
    $impuesto = mysqli_real_escape_string($con, (strip_tags($_POST["impuesto"], ENT_QUOTES)));
    $imp_esp = mysqli_real_escape_string($con, (strip_tags($_POST["impuesto_esp"], ENT_QUOTES)));
    $impuesto1 = (isset($_POST['impuesto1']) && $_POST['impuesto1'] != NULL) ? $_POST['impuesto1'] : '0.00';
    $impuesto2 = (isset($_POST['impuesto2']) && $_POST['impuesto2'] != NULL) ? $_POST['impuesto2'] : '0.00';
    $monto1 = (isset($_POST['hasta']) && $_POST['hasta'] != NULL) ? $_POST['hasta'] : '0.00';
    $monto2 = (isset($_POST['mayor']) && $_POST['mayor'] != NULL) ? $_POST['mayor'] : '0.00';
    $sql1 = "INSERT INTO `conf_region`(`id`, `codigo_fiscal`, `moneda`, `impuesto`, `imp_esp`, `impuesto1`, `monto1`, `impuesto2`, `monto2`) VALUES(null,UPPER('$cod_fiscal'),'$moneda',$impuesto, $imp_esp, $impuesto1, $monto1, $impuesto2,$monto2)";
    $query1 = $con->query($sql1);
    header("Location: /install/");
} else {
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class="glyphicon glyphicon-edit"></i> Configuración de región </h4>
        </div>
        <div class="panel-body">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <label for="cod_fiscal" class="col-md-3 control-label">Identificación tributaria:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="cod_fiscal" id="cod_fiscal" onkeypress="javascript: return ValidarEspacio(event, this)" value="RIF">
                        </div>
                        <label class="control-label" style="color: red;"><em>Ejemplo: RIF, CUIT, NIT...</em></label>
                    </div>
                    <br>
                    <div class="row">
                        <label for="pagina" class="col-md-3 control-label">Tipo de moneda: </label>
                        <div class="col-md-3">
                            <select class="form-control" name="moneda"  id="moneda">
                                <?php
                                $query = $con->query('select descripcion from moneda');
                                while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <option value="<?php echo $row['descripcion'] ?>"><?php echo $row['descripcion'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <br> 
                    <div class="row">
                        <label for="cod_fiscal" class="col-md-3 control-label">Impuesto General (%):</label>
                        <div class="col-md-3">
                            <input type="number" step="any" class="form-control" name="impuesto" id="impuesto" value="16.00">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="envio" class="col-md-3 control-label">Uso de impuesto especial:</label>
                        <div class="col-md-2">
                            <input type="radio" class="" id="impuesto_esp" name="impuesto_esp" onclick="imp(this.value);" value="1"> SI
                        </div>
                        <div class="col-md-2">
                            <input type="radio" class="" id="impuesto_esp" name="impuesto_esp" onclick="imp(this.value);" value="0" checked=""> No
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="impuesto1" class="col-md-3 control-label">Impuesto 1 (%):</label>
                        <div class="col-md-2">
                            <input type="number" step="any" class="form-control" name="impuesto1" id="impuesto1" min="0" value="0.00" disabled="disabled">
                        </div>
                        <label for="hasta" class="col-md-2 control-label">Hasta Bs:</label>
                        <div class="col-md-3">
                            <input type="number" step="any" class="form-control" name="hasta" id="hasta" min="0" value="0.00" disabled="disabled">
                        </div>                          
                    </div>
                    <br>
                    <div class="row">
                        <label for="impuesto2" class="col-md-3 control-label">Impuesto 2 (%):</label>
                        <div class="col-md-2">
                            <input type="number" step="any" class="form-control" name="impuesto2" id="impuesto2" min="0" value="0.00" disabled="disabled">
                        </div>
                        <label for="mayor" class="col-md-2 control-label">Mayor a Bs:</label>
                        <div class="col-md-3">
                            <input type="number" step="any" class="form-control" name="mayor" id="mayor" min="0" value="0.00" disabled="disabled">
                        </div>                          
                    </div>          
                </div>        
            </div>       
        </div>
    </div>    
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            if ($("input[name=impuesto_esp]:checked").val() == "1") {
                //habulita campos
                $('#impuesto1').attr("disabled", false);
                $('#impuesto2').attr("disabled", false);
                $('#hasta').attr("disabled", false);
                $('#mayor').attr("disabled", false);
            } else {
                //inhabilita campos
                $('#impuesto1').attr("disabled", true);
                $('#impuesto2').attr("disabled", true);
                $('#hasta').attr("disabled", true);
                $('#mayor').attr("disabled", true);
                //limpiar campos
                $('#impuesto1').val("");
                $('#impuesto2').val("");
                $('#hasta').val("");
                $('#mayor').val("");
            }
        });

        function imp(value) {
            if (value == "1") {
                //habulita campos
                $('#impuesto1').attr("disabled", false);
                $('#impuesto2').attr("disabled", false);
                $('#hasta').attr("disabled", false);
                $('#mayor').attr("disabled", false);
            } else {
                //inhabilita campos
                $('#impuesto1').attr("disabled", true);
                $('#impuesto2').attr("disabled", true);
                $('#hasta').attr("disabled", true);
                $('#mayor').attr("disabled", true);
                //limpiar campos
                $('#impuesto1').val("");
                $('#impuesto2').val("");
                $('#hasta').val("");
                $('#mayor').val("");
            }
        }
    </script>
<?php } ?>
