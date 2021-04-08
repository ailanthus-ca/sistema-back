<?php


include '../templates/template.php';
include '../../config/conexion.php';

$id_usuario = $_SESSION['id_usuario'];

$sql = $con->query("SELECT correo from usuario WHERE  codigo='".$id_usuario."'") or die(mysqlii_errno());
if($row = $sql->fetch_array())
{
    $correo = $row['correo'];
}
?>

<br><br><br>

<input type="hidden" id="nivel" name="nivel" value="<?php echo $_SESSION['nivel'] ?>">
<div class="col-md-10 col-md-offset-1">
    <div id="mensaje_suses" style="display: none;" class="alert alert-success" role="alert" >
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Se han guardado los cambios!</strong>
    </div>
    <div id="mensaje_clave" style="display: none;" class="alert alert-danger" role="alert" >
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡La contraseña es incorrecta!</strong>
    </div>
    <div id="mensaje_coinciden" style="display: none;" class="alert alert-danger" role="alert" >
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Las contraseñas no coinciden!</strong>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            <strong>Datos del Usuario</strong>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" id="form_perfil">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group row">
                            <label for="codigo_cliente" class="col-md-2 control-label">Nombre</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control input-sm" id="nombre" name="nombre" value="<?php echo $_SESSION['usuario'] ?>" required>
                                <input id="id_cliente" type='hidden'>
                            </div>
                            <label for="nombre_cliente" class="col-md-2 control-label">Correo</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control input-sm" id="correo" name="correo"value="<?php echo $correo ?>" disabled="true" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="codigo_cliente" class="col-md-2 control-label">Clave actual</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control input-sm" id="clave" name="clave" placeholder="*************" >
                                <input id="id_cliente" type='hidden'>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="codigo_cliente" class="col-md-2 control-label">Nueva Clave</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control input-sm" id="nueva" name="nueva" placeholder="*************" >
                                <input id="id_cliente" type='hidden'>
                            </div>
                            <label for="nombre_cliente" class="col-md-2 control-label">Repetir clave</label>
                            <div class="col-md-10">
                                <input type="password" class="form-control input-sm" id="repetir" name="repetir" placeholder="*************" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-right">
                        <button id="procesar" type="submit" class="btn btn-default btn-lg" data-toggle="tooltip" data-placement="top" title="guardar">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include("../templates/template_footer.php");
?>
<script type="text/javascript" src="./js/perfil.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</body>
</html>