
<div class="col-12" style="text-align: center">
    <span style="color: #34495e;font-size:16px;font-weight:bold"><strong>REPORTE DE INVENTARIO</strong></span><br>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $data['titulo'] ?></strong></span>
</div>
<table  cellspacing="0">
    <tr>
        <th class="col-1" style="text-align: center">Codigo</th>
        <th class="col-8">Descripción</th>
        <th class="col-1" style="text-align: center">Unidad</th>
        <th class="col-1">Cantidad</th>
        <th class="col-1">check</th>
    </tr>
    <?php foreach ($data['productos'] as $c) { ?>
        <tr>
            <td  class="col-1" style="text-align: center"><?php echo $c['codigo'] ?></td>
            <td  class="col-8"><?php echo $c['descripcion']  ?></td>
            <td  class="col-1" style="text-align: center"><?php echo $c['medida']  ?></td>
            <td  class="col-1"><?php echo($c['inventario']===1)?'NO APLICA': $c['cantidad']  ?></td>
            <th  class="col-1"></th>
        </tr>
    <?php } ?>
</table>  