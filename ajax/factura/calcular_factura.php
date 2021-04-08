<?php
$sql = $con->query("SELECT *from conf_region");
if ($row = $sql->fetch_array()) {
    $moneda = $row['moneda'];
    $imp_esp = $row['imp_esp'];
    $impuesto = $row['impuesto'];
    $impuesto1 = $row['impuesto1'];
    $monto1 = $row['monto1'];
    $impuesto2 = $row['impuesto2'];
}
?>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class='text-center'>CODIGO</th>
                <th class='text-center'>CANT.</th>
                <th>DESCRIPCION</th>
                <th class='text-right'>PRECIO UNIT.</th>
                <th class='text-right'>PRECIO TOTAL</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = $con->query("select * from producto, tmp_fact_prod where producto.codigo=tmp_fact_prod.id_producto");
            $check = (object) array(
                        'cant' => true,
                        'precio' => true,
                        'nota' => false
            );
            if ($nota != '') {
                $check->nota = true;
            }
            $total = 0;
            while ($row = $sql->fetch_array()) {
                $total += $row['precio_tmp'] * $row['cantidad_tmp'];
                ?>
                <tr <?php
                if ($row['cantidad_tmp'] > $row['cantidad'] && $row['tipo'] == '1') {
                    if (!$check->nota) {
                        ?>bgcolor="#F3F781"<?php
                            $check->cant = false;
                        }
                    } else if ($row['precio_tmp'] < $row['costo']) {
                        ?>bgcolor="#FE2E2E"<?php
                        $check->precio = false;
                    }
                    ?>>
                    <td class = 'text-center'><?php echo $row['codigo']; ?></td>
                    <td class='text-center'><?php echo $row['cantidad_tmp']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td class='text-right'><?php echo  number_format($row['precio_tmp'], 2); ?></td>
                    <td class='text-right'><?php echo number_format($row['precio_tmp'] * $row['cantidad_tmp'], 2); ?></td>
                    <td class='text-center'><a href="#" data-toggle="modal" data-target="#editar" onclick="editarFactura('<?php echo $row['id_tmp'] ?>')" ><i class="glyphicon glyphicon-edit"></i></a></td>
                    <td class='text-center'><a href="#" onclick="eliminar('<?php echo $row['id_tmp'] ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
                </tr><?php
            }

            if ($porc_impuesto == "imp_esp") {
                $esp = true;
                if ($total < $monto1) {
                    $porc_impuesto = $impuesto1;
                } else {
                    $porc_impuesto = $impuesto2;
                }
            } else {
                $esp = false;
                $porc_impuesto = $impuesto;
            }
            $iva_general = ($total * $impuesto ) / 100;
            $iva_general = number_format($iva_general, 2, '.', '');
            $total_iva = ($total * $porc_impuesto ) / 100;
            $total_iva = number_format($total_iva, 2, '.', '');
            $total_factura = $total + $total_iva;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td class='text-right' colspan=4><strong>SUBTOTAL <?php echo $moneda ?>.</strong></td>
                <td class='text-right' ><?php echo number_format($total, 2); ?></td>
                <!--input hidden para guardar el subtotal-->
        <input type="hidden" name="subtotal" id="subtotal" value="<?php echo number_format($total, 2); ?>">

        <!--input hidden para guardar el impuesto-->
        <input type="hidden" name="impuesto" id="impuesto" value="<?php echo number_format($total_iva, 2); ?>">
        <input type="hidden" name="porc_impuesto" id="porc_impuesto" value="<?php echo $porc_impuesto ?>">
        <input type="hidden" name="costo_total" id="costo_total" value="<?php echo $costo_total ?>">

        <td></td>
        </tr>

        <tr>
            <td class="text-right" colspan=4><strong> IVA <?php echo $porc_impuesto; ?>%</strong></td>
            <td class="text-right"><?php echo number_format($total_iva, 2); ?></td>
        </tr>

        <tr>
            <td class="text-right" colspan=4><strong>TOTAL <?php echo $moneda ?>.</strong> </td>
            <td class="text-right"><?php echo number_format($total_factura, 2); ?></td>
            <!--input hidden para guardar el total-->
        <input type="hidden" name="total" id="total" value="<?php echo number_format($total_factura, 2); ?>">
        <td></td>
        </tr>
        </tfoot>
    </table>
</div>
<!--Fin de calcular impuesto y total-->

<?php
if (!$check->cant) {
    if (!$check->nota) {
    ?><div style="width: 100%;" class="alert alert-danger">	
        <strong>¡La cantidad supera el stock en inventario!</strong> Modifique la cantidad de los productos marcados en rojo.
    </div> 
    <input type="hidden" id="check" value="true"></input><?php
    }
}
if (!$check->precio) {
        ?><div style="width: 100%;" class="alert alert-warning">	
            <strong>¡El precio no puede ser menor al costo!</strong> Por favor modifique el precio de los productos marcados en amarillo.
        </div>
        <input type="hidden" id="check" value="true"></input><?php
} else {
    ?><input type="hidden" id="check" value="false"></input><?php
}
mysqli_close($con);
?>