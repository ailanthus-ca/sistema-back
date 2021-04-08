<?php


if($_POST['ajax']=='agregar'){
    agregar();
}elseif($_POST['ajax']=='eliminar'){
    eliminar();
}


function agregar(){
    include '../../config/conexion.php';
   include '../../config/seccion.php';
    $id = $_POST['id'];
    $cantidad = $_POST['descripcion'];
    $descripcion = $_POST['cantidad'];
    if (!empty($id) and !empty($cantidad) and !empty($descripcion)){
        $cod_usuario = $_SESSION['id_usuario'];
        $sql=$con->query("select *from tmp_cot_prod where id_producto = '$id'");
        if ($row=$sql->fetch_array())
        {
            $con->query("update tmp_cot_prod set cantidad_tmp = $cantidad, descripcion_tmp = '$descripcion' WHERE id_producto = '$id' and usuario_tmp = $cod_usuario");
        }
        else
        {
            $insert_tmp=$con->query("INSERT into tmp_cot_prod (id_producto,cantidad_tmp,descripcion_tmp,usuario_tmp) VALUES ('$id','$cantidad','$descripcion',$cod_usuario)");
        }
        $chek="true";
    }
    calcular($chek);
}

function eliminar(){
    $id = $_POST['id'];
include '../../config/conexion.php';
session_start();
$cod_usuario = $_SESSION['id_usuario'];
$delete =$con->query("DELETE from tmp_cot_prod WHERE id_tmp='".$id."'");
$cont=$con->query("select * from tmp_cot_prod WHERE usuario_tmp = $cod_usuario");
if($t=mysqli_fetch_array($cont)){
    $chek="true";
}else{
    $chek="false";
}
    calcular($chek);
}

function calcular($chek){
    ?>
    <input id="check" type="hidden" value="<?php echo $chek?>">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th class='text-center'>CODIGO</th>
                <th>NOMBRE DEL PRODUCTO</th>
                <th class='text-center'>CANT.</th>
                <th class="text-center">DESC. DEL AJUSTE</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql=$con->query("select *from producto, tmp_cot_prod where producto.codigo=tmp_cot_prod.id_producto  and usuario_tmp = $cod_usuario");
            while ($row=$sql->fetch_array())
            {
                $id_tmp          =$row["id_tmp"];
                $codigo_producto =$row['codigo'];
                $cantidad        =$row['cantidad_tmp'];
                $nombre_producto =$row['descripcion'];
                $descripcion     =$row['descripcion_tmp'];

                ?>

                <tr>
                    <td class='text-center'><?php echo $codigo_producto; ?></td>
                    <td><?php echo $nombre_producto; ?></td>
                    <td class='text-center'><?php echo $cantidad;?></td>
                    <td class='text-center'><?php echo $descripcion;?></td>
                    <td class='text-center'><a href="#" data-toggle="modal" data-target="#editar" onclick="editarAjuste('<?php echo $id_tmp ?>')" ><i class="glyphicon glyphicon-edit"></i></a></td>
                    <td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>

                </tr>
                <?php
            }
            ?>

            </tbody>
        </table>
    </div>
    <?php
}

