<div class="col-12" style="text-align: center">
    <span style="color: #34495e;font-size:16px;font-weight:bold"><strong>PRODUCTOS EN  <?php echo $data['operacion'] ?></strong></span><br>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $data['titulo'] ?></strong></span>
</div>
<table cellspacing="0">
    <thead>
        <tr>
            <th class="col-1" style="text-align: center;">codigo</th>
            <th class="col-8" style="text-align: center;">Descripcion</th>
            <th class="col-1" style="text-align: center;">Cantidad</th>
            <th class="col-2" style="text-align: center;">Monto</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['itens'] as $row) { ?>
            <tr>
                <td class="col-1" style="text-align: center;"><?php echo $row['codigo'] ?></td>
                <td class="col-8" style="text-align: left;"><?php echo $row['descripcion'] ?></td>
                <td class="col-1" style="text-align: right;"><?php echo number_format($row['cantidad'], 2, ",", ".") ?></td>
                <td class="col-2" style="text-align: right;"><?php echo number_format($row['monto'], 2, ",", ".") ?></td>
            </tr>
        <?php } ?>        
    </tbody>
</table>  