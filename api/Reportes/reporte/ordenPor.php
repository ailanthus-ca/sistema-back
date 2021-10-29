<div class="col-12" style="text-align: center">
    <span style="color: #34495e;font-size:16px;font-weight:bold"><strong>REPORTE DE  <?php echo $data['operacion'] ?></strong></span><br>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $data['titulo'] ?></strong></span>
</div>
<table  cellspacing="0">
    <thead>
        <tr>
            <th class="col-1" style="text-align: center">Fecha</th>
            <th class="col-6" style="text-align: center">Proveedor</th>
            <th class="col-1" style="text-align: center">Cant</th>
            <th class="col-2" style="text-align: center">Precio</th>
            <th class="col-2" style="text-align: center">Total</th>
        </tr>	
    </thead>
    <tbody>
        <?php
        $todo = 0;
        foreach ($data['orden'] as $c) {
            $date1 = new DateTime($c['fecha']);
            $todo += $c['monto'];
            ?>
            <tr>
                <td class="col-1" style="text-align: center"><?php echo $date1->format("d/m/Y") ?></td>
                <td class="col-6" style="text-align: left"><?php echo $c['nombre'] ?></td>               
                <td class="col-1" style="text-align: right"><?php echo number_format($c['cantidad'], 2, ".", ",") ?></td>
                <td class="col-2" style="text-align: right"><?php echo number_format($c['precio_unit'], 2, ".", ",") ?></td>
                <td class="col-2" style="text-align: right"><?php echo number_format($c['cantidad'] * $c['precio_unit'], 2, ".", ",") ?></td>
            </tr>
        <?php } ?>

    </tbody>
    <tfoot>
        <tr>
            <td class="col-10" colspan="4" style="text-align: right"> Total:</td>
            <td class="col-2" style="text-align: right"><?php echo number_format($todo, 2, ".", ",") ?></td>
        </tr>
    </tfoot>
</table>  

