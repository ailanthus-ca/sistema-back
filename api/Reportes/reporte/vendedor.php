<div class="col-12" style="text-align: center">
    <span style="color: #34495e;font-size:16px;font-weight:bold"><strong>REPORTE DE  <?php echo $data['operacion'] ?></strong></span><br>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $data['titulo'] ?></strong></span>
</div><br>

<?php
$todof = 0;
$todon = 0;
if (count($data['facturas']) > 0) {
    ?>
    <div class="col-12">
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>Facturas</strong></span><br>
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
            foreach ($data['facturas'] as $c) {
                $date1 = new DateTime($c['fecha']);
                $todof += $c['imponible'];
                ?>
                <tr>
                    <td class="col-1" style="text-align: center"><?php echo str_pad($c['codigo'], 6, "0", STR_PAD_LEFT); ?></td>
                    <td class="col-1" style="text-align: center"><?php echo $date1->format("d/m/Y") ?></td>
                    <td class="col-6" style="text-align: left"><?php echo $c['nombre'] ?></td>
                    <td class="col-2" style="text-align: right"><?php echo number_format($c['imponible'], 2, ".", ",") ?></td>
                </tr>
            <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <td class="col-10" colspan="3" style="text-align: right"> Total:</td>
                <td class="col-2" style="text-align: right"><?php echo number_format($todof, 2, ".", ",") ?></td>
            </tr>
        </tfoot>
    </table>  
<?php } ?>
<?php if (count($data['notas']) > 0) { ?>
    <div class="col-12">
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>Notas de Entrega</strong></span><br>
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
            foreach ($data['notas'] as $c) {
                $date1 = new DateTime($c['fecha']);
                $todon += $c['monto'];
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
                <td class="col-2" style="text-align: right"><?php echo number_format($todon, 2, ".", ",") ?></td>
            </tr>
        </tfoot>
    </table>  
<?php } ?>
<div class="col-12" style="text-align: right">
    <span style="color: #34495e;font-size:14px;"><strong>Total: </strong><?php echo number_format($todon + $todof, 2, ".", ",") ?></span><br>
</div>


