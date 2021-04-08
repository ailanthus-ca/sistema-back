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