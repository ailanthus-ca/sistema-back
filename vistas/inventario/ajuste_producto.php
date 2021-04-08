<?php
include '../templates/template.php';
include '../../config/conexion.php';

//reinicia la tabla temporal
$con->query("TRUNCATE TABLE tmp");
require_once "../modals/buscar_productos.php";
?>

<br><br><br>
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-info">
        <div  class="panel-heading panel">
            <h3>Ajuste de Costos sobre Inventario</h3>
        </div>
        <form class="panel-body form-horizontal" id="precio">
            <div class="col-md-12">
                <div class="col-md-12">
                    <h4>Aplicar a:</h4>
                </div>
                <div class="col-md-12 panel panel-info">
                    <div class="col-md-1">
                        <input checked onchange="validar(this)"  type="radio" name="eleccion" class="radio" value="td">
                    </div>
                    <div class="col-md-11">
                        <h5>Todos los Productos en el Sistema</h5>
                    </div>
                </div>
                <div class="col-md-12 panel panel-info">
                    <div class="col-md-1">
                        <input onchange="validar(this)"  type="radio" name="eleccion" class="radio" value="dp">
                    </div>
                    <div class="col-md-5">
                        <h5>Todos los Productos en un Departamento</h5>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control" id="dpt" name="dpt">
                            <option value="">-------</option>
                            <?php
                            $r = $con->query('select * from departamento where estatus = 1');
                            while ($row = mysqli_fetch_array($r)) {
                                ?><option value="<?php echo $row['codigo']; ?>"><?php echo $row['descripcion'] ?></option><?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 panel panel-info">
                    <div class="col-md-1">

                        <input onchange="validar(this)"  type="radio" name="eleccion" class="radio" value="pd">
                    </div> 
                    <div class="col-md-3">
                        <h5>A un Producto espesifico</h5>
                    </div> 
                    <div class="col-md-8">
                        <div class="col-md-3">
                            <input id="pdt" type="button" data-toggle="modal" data-target="#myModal"  onclick="load(1);" value="buscar" class="form-control btn-primary btn"/>
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="codigo" class="form-control" disabled="true"/>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="des" class="form-control" disabled="true"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 form-horizontal">
                <div class="col-md-2 ">
                    <select id="operacion" name="operacion" class="form-control">
                        <option value="%2B">+</option>
                        <option value="-">-</option>
                        <option value="*">*</option>
                        <option value="/">/</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="valor" id="numero" class="form-control" value="" />
                </div>
                <div class="col-md-4">
                    <input type="button" value="Aplicar" onclick="sumit()" class="form-control btn-primary btn"/>
                </div>
            </div>
        </form>
        <div id="rpt"></div>	
        <br>
    </div>
</div>

<?php
include("../templates/template_footer.php");
?>
<script type="text/javascript" src="./js/ajuste_producto.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</body>
</html>