<div class="col-12" style="text-align: center;">
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>HISTORICO DEL PRODUCTO:</strong></span><br>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $data['title'] ?></strong></span><br>
</div>
<table  cellspacing="0">
    <thead>
        <tr>
            <th class="col-1" style="text-align: center">FECHA</th>
            <th class="col-1" style="text-align: center">ACCION</th>
            <th class="col-1" style="text-align: center">CODIGO</th>
            <th class="col-6">NOMBRE</th>
            <th class="col-1" style="text-align: right">ENTRADA</th>
            <th class="col-1" style="text-align: right">SALIDA</th>
            <th class="col-1" style="text-align: right">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        foreach ($data['operaciones'] as $row) {
            ?>
            <tr>
                <td class="col-1" style="text-align: center"><?php
                    $date = new DateTime($row['fecha']);
                    echo $date->format("d/m/Y");
                    ?></td>
                <td class="col-1" style="text-align: center"><?php echo $row['operacion']; ?></td>
                <td class="col-1" style="text-align: center"><?php echo $row['codigo']; ?></td>
                <td class="col-6"><?php echo $row['nombre']; ?></td>
                <td class="col-1" style="text-align: right"><?php
                    if ($row['tipo'] == 'ENTRADA') {
                        $total += $row['cantidad'];
                        echo $row['cantidad'];
                    }
                    ?></td>
                <td class="col-1" style="text-align: right"><?php
                    if ($row['tipo'] == 'SALIDA') {
                        $total -= $row['cantidad'];
                        echo $row['cantidad'];
                    }
                    ?></td>
                <td class="col-1" style="text-align: right"><?php echo $total; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>