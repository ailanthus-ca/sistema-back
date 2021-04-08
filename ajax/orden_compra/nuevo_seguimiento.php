<?php
/**
 * Created by PhpStorm.
 * User: Ailanthus
 * Date: 31-01-2018
 * Time: 04:45 PM
 */

	if (isset($_POST['id'])){$id=$_POST['id'];}
	if (isset($_POST['comentario'])){$comentario=$_POST['comentario'];}
    if (isset($_POST['id_usuario'])){$id_usuario=$_POST['id_usuario'];}


	include '../../config/conexion.php';

	$query = $con->query("INSERT into orden_seguimiento VALUES ('','$id', '$comentario','$id_usuario',NOW()) ");

?>
    <!--
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Comentario agregado!</strong>
            Se ha agregado el comentario exitosamente
        </div>
    -->

<?php
	mysqli_close($con);

?>