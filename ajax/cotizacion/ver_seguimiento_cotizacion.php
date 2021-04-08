<?php
/**
 * Created by PhpStorm.
 * User: Ailanthus
 * Date: 31-01-2018
 * Time: 04:19 PM
 */


	include '../../config/conexion.php';

   include '../../config/seccion.php';
	$id = $_GET['id'];
	$id_usuario_sesion = $_SESSION['id_usuario'];

	$sql = $con->query("SELECT *from cotizacion_seguimiento where cod_cotizacion = '$id'");

	$codigo = $id;
	$descripcion = "";
	$fecha = "";
?>
    <div class="table-responsive">
        <table border="1">
            <tr>
                <th><span class="pull-center">Codigo.</span></th>
                <th><span class="pull-center">Descripcion</span></th>
                <th><span class="pull-center">Usuario</span></th>
                <th><span class="pull-center">Fecha</span></th>
            </tr>
            <?php
            while ($row = $sql->fetch_array())
            {
                $codigo = $row['cod_cotizacion'];
                $descripcion = $row['descripcion'];
                $usuario = $row['usuario'];
                $fecha = $row['fecha'];

                $query_usuario = $con->query("SELECT nombre FROM usuario WHERE codigo = '$usuario'");
                if ($row = mysqli_fetch_array($query_usuario))
                {
                    $usuario_nombre = $row['nombre'];
                }
                else
                    $usuario_nombre = "";

                ?>
                <tr>
                    <td class='col-xs-1'>
                        <div class="pull-left">
                            <?php echo $codigo; ?>
                        </div>
                    </td>
                    <td class='col-xs-1'>
                        <div class="pull-left">
                            <?php echo $descripcion; ?>
                        </div>
                    </td>
                    <td class='col-xs-1'>
                        <div class="pull-center">
                            <?php echo $usuario_nombre; ?>
                        </div>
                    </td>
                    <td class='col-xs-1'>
                        <div class="pull-center">
                            <?php echo $fecha; ?>
                        </div>
                    </td>
                </tr>

                <?php
            }
            ?>
        </table>
        <br><br>
        <div class="col-md-6">
            <input id="comentario<?php echo $codigo ?>" class="form-control" type="text" placeholder="ingrese su comentario...">
        </div>
        <div class="col-md-2">
            <button onclick="nuevo_seguimiento('<?php echo $codigo; ?>', '<?php echo $id_usuario_sesion; ?>')" class="form-control btn-info">Comentar</button>
        </div>
    </div>
<?php
	mysqli_close($con);
?>