<?php
include '../templates/template.php';
include '../../config/conexion.php';
?>

<link href="../../public/css/imgresponsive.css" rel="stylesheet">
<br><br><br><br><br><br><br>

<form class="form" role="form" method="POST" id="form_producto" name="form_producto" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel-group" id="accordion">
                    <div id="resultados_ajax"></div>     
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-file">
                                    </span>Registro de productos</a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="departamento">
                                                Departamento</label>
                                            <select name="departamento" class="form-control" id="departamento">
                                                <option value="null" selected>Selecione un Departamento</option>
                                                <?php
                                                $sql_dpto = $con->query("SELECT *FROM departamento where estatus = 1");
                                                while ($rowt = mysqli_fetch_array($sql_dpto)) {
                                                    ?>
                                                    <option value="<?php echo $rowt['codigo']; ?>"><?php echo $rowt['descripcion'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label></label>
                                        <div class="form-group">
                                            <input name="descripcion" type="text" class="form-control" id="descripcion" placeholder="Descripcion" required maxlength="300" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipo">
                                                Tipo</label>
                                            <select name="tipo" class="form-control" id="tipo">
                                                <?php
                                                $sql_tipo = $con->query("SELECT *FROM tipo_producto where estatus = 1");
                                                while ($rowt = mysqli_fetch_array($sql_tipo)) {
                                                    ?>
                                                    <option value="<?php echo $rowt['codigo']; ?>"><?php echo $rowt['descripcion'] ?></option>

                                                <?php } ?>  
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Porcentaje</label>
                                        <input name="porcentaje1" class="form-control" type="number" id="porcentaje1" onchange="sumar('porcentaje1', this.value);"  onkeyup="sumar('porcentaje1', this.value);" max="100" placeholder="%">                                    
                                    </div>
                                    <div class="col-md-3">
                                        <label>Precio 1</label>
                                        <input name="precio1" type="text" class="form-control" id="precio1" placeholder="Precio 1" />   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="costo_producto">Costo</label>
                                            <input step="0.01" name="costo_producto" type="number" class="form-control" id="costo_producto" onclick="focus();" placeholder="Costo" value="0" onchange="sumar('costo', this.value);" onkeyup="sumar('costo', this.value);" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Porcentaje</label>
                                        <input name="porcentaje2" class="form-control" type="number" id="porcentaje2" onchange="sumar('porcentaje2', this.value);"  onkeyup="sumar('porcentaje2', this.value);" placeholder="%" max="100">                                    
                                    </div>
                                    <div class="col-md-3">
                                        <label>Precio 2</label>
                                        <input name="precio2" type="text" class="form-control" id="precio2" placeholder="Precio 2" />   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">
                                                Unidad</label>
                                            <select name="unidad" class="form-control" id="unidad">
                                                <?php
                                                $sql_unidad = $con->query("SELECT *FROM unidad where estatus = 1");
                                                while ($rowt = mysqli_fetch_array($sql_unidad)) {
                                                    if ($rowt['descripcion'] == $unidad) {
                                                        $selected_u = "selected";
                                                    } else {
                                                        $selected_u = "";
                                                    }
                                                    echo $check;
                                                    ?>
                                                    <option value="<?php echo $rowt['codigo']; ?>" <?php echo $selected_u ?> ><?php echo $rowt['descripcion'] ?></option>

                                                <?php } ?>  
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Porcentaje</label>
                                        <input name="porcentaje3" class="form-control" type="number" id="porcentaje3" onchange="sumar('porcentaje3', this.value);" onkeyup="sumar('porcentaje3', this.value);" max="100" placeholder="%">                                    
                                    </div>
                                    <div class="col-md-3">
                                        <label>Precio 3</label>
                                        <input name="precio3" type="text" class="form-control" id="precio3" placeholder="Precio 3" />   
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="checkbox" name="enser" id="enser" value="1" onclick="habilitar()">
                                        <label for="enser"><strong style="font-size: 18px;">Enser</strong></label>
                                    </div>                              
                                    <div class="col-md-3">
                                        <button type="reset" class="btn btn-danger"> <i class="fa fa-paint-brush"></i> Limpiar</button>
                                    </div> 
                                    <div class="col-md-3"> 
                                        <button id="guardar" name="guardar" type="submit" class="btn btn-primary"> <i class="fa fa-check-square"></i> Guardar</button>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>  
</div>
</div>
</div>
</div>


<?php
include '../templates/template_footer.php';
mysqli_close($con);
?>
<script type="text/javascript" src="./js/nuevo_producto.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>