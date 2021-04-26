<div class="col-12" style="text-align: center">
    <span style="color: #34495e;font-size:16px;font-weight:bold"><strong>REPORTE DE COMPRAS</strong></span><br>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $data['titulo'] ?></strong></span>
</div>
<table  cellspacing="0">
    <thead>
        <tr>
            <th class="col-1" style="text-align: center">Fecha Reg.</th>
            <th class="col-3" style="text-align: center">Proveedor</th>
            <th class="col-1" style="text-align: center">Numero Doc.</th>
            <th class="col-1" style="text-align: center">Fecha Doc.</th>
            <th class="col-1" style="text-align: center">cant</th>
            <th class="col-2" style="text-align: center">precio</th>
            <th class="col-2" style="text-align: center">Total</th>
        </tr>	
    </thead>
    <tbody>
        <?php
        $todo = 0;
        foreach ($data['compras'] as $c) {
            $date1 = new DateTime($c['fecha']);
            $date2 = new DateTime($c['fecha_documento']);
            $todo += $c['monto'];
            ?>
            <tr>
                <td class="col-1" style="text-align: center"><?php echo $date1->format("d/m/Y") ?></td>
                <td class="col-3" style="text-align: left"><?php echo $c['nombre'] ?></td>
                <td class="col-1" style="text-align: center"><?php
                    if ($c['cod_documento'] !== '')
                        echo $c['cod_documento'];
                    else
                        echo 'N/A';
                    ?></td>
                <td class="col-1" style="text-align: center"><?php
                    if ($c['cod_documento'] !== '')
                        echo $date2->format("d/m/Y");
                    else
                        echo 'N/A';
                    ?></td>
                <td class="col-1" style="text-align: right"><?php echo number_format($c['cantidad'], 2, ".", ",") ?></td>
                <td class="col-2" style="text-align: right"><?php echo number_format($c['precio_unit'], 2, ".", ",") ?></td>
                <td class="col-2" style="text-align: right"><?php echo number_format($c['cantidad'] * $c['precio_unit'], 2, ".", ",") ?></td>
            </tr>
        <?php } ?>

    </tbody>
    <tfoot>
        <tr>
            <td class="col-10" colspan="6" style="text-align: right"> Total:</td>
            <td class="col-2" style="text-align: right"><?php echo number_format($todo, 2, ".", ",") ?></td>
        </tr>
    </tfoot>
</table>  

