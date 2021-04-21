<div class="col-12" style="text-align: center">
    <span style="color: #34495e;font-size:16px;font-weight:bold"><strong>REPORTE DE FACTURAS</strong></span><br>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $data['titulo'] ?></strong></span>
</div>
<table  cellspacing="0">
    <thead>
        <tr>
            <th class="col-1" style="text-align: center">Numero</th>
            <th class="col-1" style="text-align: center">Fecha</th>
            <th class="col-6" style="text-align: left">Cliente</th>
            <th class="col-2" style="text-align: right">Total</th>
        </tr>	
    </thead>
    <tbody>
        <?php
        $todo = 0;
        foreach ($data['facturas'] as $c) {
            $date1 = new DateTime($c['fecha']);
            $todo += $c['monto'];
            ?>
            <tr>
                <td class="col-1" style="text-align: center"><?php echo str_pad($c['codigo'], 6, "0", STR_PAD_LEFT); ?></td>
                <td class="col-1" style="text-align: center"><?php echo $date1->format("d/m/Y") ?></td>
                <td class="col-6" style="text-align: left"><?php echo $c['nombre'] ?></td>
                <td class="col-2" style="text-align: right"><?php echo number_format($c['monto'], 2, ".", ",") ?></td>
            </tr>
        <?php } ?>

    </tbody>
    <tfoot>
        <tr>
            <td class="col-10" colspan="3" style="text-align: right"> Total:</td>
            <td class="col-2" style="text-align: right"><?php echo number_format($todo, 2, ".", ",") ?></td>
        </tr>
    </tfoot>
</table>  

