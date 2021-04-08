<?php
include '../templates/template.php';
include '../../config/conexion.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>

    </head>
    <br><br><br>
    <body> 
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <a href="nuevo_producto" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nuevo Producto</a>
                    </div>
                    <h4><i class='glyphicon glyphicon-search'></i> Buscar Productos</h4>
                </div>
                <div class="panel-body">
<?php
include("../modals/editar_producto.php");
include("../modals/ver_detalleproducto.php");
?>	
                    <form class="form-horizontal" role="form" id="form_proveedores">

                        <div class="form-group row">
                            <div class="col-sm-1">
                                <h5 id="myModalLabel">DPTO:</h5>
                            </div>
                            <div class="col-sm-3">
                                <select class="selectpicker form-control" id="dp" name="dp" onchange="cargar_producto(1)">
                                    <option value="td">TODOS</option>
<?php
$sql = "SELECT codigo, descripcion FROM departamento WHERE estatus = 1";
$query = $con->query($sql);
while ($row = mysqli_fetch_array($query)) {
    ?><option value="<?php echo $row['codigo']; ?>"><?php echo $row['descripcion']; ?></option><?php
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="q" placeholder="Ingrese el codigo o nombre del producto" onkeyup='cargar_producto(1);'>
                            </div>



                            <div class="col-md-2">
                                <button type="button" class="btn btn-default" onclick='cargar_producto(1);'>
                                    <span class="glyphicon glyphicon-search" ></span> Buscar</button>
                                <span id="loader"></span>
                            </div>

                        </div>



                    </form>
                    <div id="resultados"></div><!-- Carga los datos ajax -->
                    <div class='outer_div'></div><!-- Carga los datos ajax -->
                </div>
            </div>	

        </div>
        <hr>
<?php
include("../templates/template_footer.php");
?>
        <script type="text/javascript" src="./js/productos.js"></script>
    </body>
</html>