<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class='text-center'>CODIGO</th>
                <th>DESCRIPCION</th>
                <th class='text-center'>CANT.</th>
                <th class='text-right'>PRECIO UNIT.</th>
                <th class='text-right'>PRECIO TOTAL</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $region = $con->query("SELECT  `moneda` FROM `conf_region`");
            while ($row = $region->fetch_array()) {
                $moneda = $row['moneda'];
            }
            $sql = $con->query("SELECT `productor`, `costo`,`catidad`, `precio`, `usuario`,`descripcion`,`precio1`,`precio2`,`precio3` FROM `tempnotas`, `producto` WHERE `productor`=`codigo` AND `usuario`=$user")or die($con->error);
            $total = 0;
            ?><input id="check" type="hidden" value="<?php echo $sql->num_rows ?>"/><?php
            while ($row = $sql->fetch_array()) {
                $total += ($row['precio'] * $row['catidad']);
                ?>
            <tr <?php if ($row['precio'] < $row['costo']) echo 'bgcolor="#FE2E2E"'; ?>>
                <td class='text-center'><?php echo $row['productor'] ?></td>
                <td><?php echo $row['descripcion'] ?></td>
                <td class='text-center'><?php echo $row['catidad'] ?></td>
                <td class='text-right'><?php echo str_replace(",", "", number_format($row['precio'], 2)); ?></td>
                <td class='text-right'><?php echo str_replace(",", "", number_format(($row['precio'] * $row['catidad']), 2)); ?></td>
                <td class='text-center'><a href="#" data-toggle="modal" data-target="#editar" onclick="editarFactura('<?php echo $row['productor'] ?>', '<?php echo $row['descripcion'] ?>',<?php echo $row['catidad'] ?>,<?php echo $row['precio'] ?>,<?php echo $row['costo'] ?>,<?php echo $row['precio1'] ?>,<?php echo $row['precio2'] ?>,<?php echo $row['precio3'] ?>)"" ><i class="glyphicon glyphicon-edit"></i></a></td>
                <td class='text-center'><a href="#" onclick="eliminar('<?php echo $row['productor'] ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td class='text-right' colspan=4><strong>TOTAL <?php echo $moneda ?>.</strong> </td>
                <td class='text-right'><?php echo str_replace(",", "", number_format($total, 2)); ?></td>
            </tr>
        </tfoot>
    </table>
</div>