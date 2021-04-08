<?php
include '../../config/seccion.php';
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}




/* Conectar a la base de datos */
include '../../config/conexion.php';

$departamento = mysqli_real_escape_string($con,(strip_tags($_POST["departamento"], ENT_QUOTES)));
$descripcion = mysqli_real_escape_string($con,(strip_tags($_POST["descripcion"], ENT_QUOTES)));
$tipo = mysqli_real_escape_string($con,(strip_tags($_POST["tipo"], ENT_QUOTES)));
$unidad = mysqli_real_escape_string($con,(strip_tags($_POST["unidad"], ENT_QUOTES)));
$cantidad = (isset($_REQUEST['cantidad']) && $_REQUEST['cantidad'] != NULL) ? $_REQUEST['cantidad'] : 0;

if (isset($_POST['enser'])) {
    $enser = $_POST['enser'];
} else {
    $enser = 0;
}
$costo = floatval($_POST['costo_producto']);
if (isset($_POST['porcentaje1'])) {
    $precio1 = floatval($_POST['porcentaje1']);
    $precio2 = floatval($_POST['porcentaje2']);
    $precio3 = floatval($_POST['porcentaje3']);
} else {
    $precio1 = 0;
    $precio2 = 0;
    $precio3 = 0;
}

//$estado=intval($_POST['estado']); revisar si es necesario insertar el estatus



$query = $con->query("SELECT count(*) AS num FROM producto WHERE departamento = '$departamento'");
if ($row = mysqli_fetch_array($query)) {
    $num = $row['num'];
}
$codigo_producto = $departamento . $num;

$query_err = $con->query("SELECT * FROM producto WHERE codigo = '$codigo_producto'");
if ($row_err = mysqli_fetch_array($query_err)) {
    $errors[] = "Ya existe un registro con el mismo codigo";
}

$sql = "INSERT INTO producto 
              (codigo,departamento, descripcion, tipo, enser, unidad, costo, precio1, precio2, precio3, cantidad, imagen, estatus, fecha_creacion) 
              VALUES (UPPER('$codigo_producto'),'$departamento',UPPER('$descripcion'),UPPER('$tipo'), '$enser' ,UPPER('$unidad'),
              $costo,$precio1,$precio2,$precio3,$cantidad,'',1, NOW())";

$query = $con->query($sql);
if ($query) {
    $messages[] = "Producto registrado satisfactoriamente.";
}
$sql = "select codigo from producto ";
if (isset($errors)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong> 
    <?php
    foreach ($errors as $error) {
        echo '<input id="bool" type="hidden" value="0"></input>';
        echo $error;
    }
    ?>
    </div>
        <?php
    }
    if (isset($messages)) {
        ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Registro con exito!</strong>
    <?php
    foreach ($messages as $message) {
        echo '<input id="bool" type="hidden" value="1"></input>';
        echo $message;
    }
    ?><br>
        Con el codigo: <strong><?php echo $codigo_producto; ?></strong>
    </div>
        <?php
    }
    ?>

<!--
<script>
                function load(page){
                        var q= $("#q").val();
                        $("#loader").fadeIn('slow');
                        $.ajax({
                                url:'./ajax/productos_factura.php?action=ajax&page='+page+'&q='+q,
                                 beforeSend: function(objeto){
                                 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
                          },
                                success:function(data){
                                        $(".outer_div").html(data).fadeIn('slow');
                                        $('#loader').html('');
                                        
                                }
                        })			
                }
INSERT INTO `cliente`(`codigo`, `nombre`, `correo`, `direccion`, `contacto`, `telefono`, `tipo_contribuyente`, `retencion`, `estatus`)
VALUES ("v-0000000-0","ñame canción","t@ñame.com","","1528586",,[value-7],[value-8],[value-9])
</script>
-->
