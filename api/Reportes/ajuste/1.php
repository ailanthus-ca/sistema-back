<?php $subtotal = 0; ?>
<!--Titulo del reporte-->
<div class="col-12" style="text-align: center;">
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>AJUSTE N.  <?php echo str_pad($data['codigo'], 6, "0", STR_PAD_LEFT) ?></strong></span>
</div><br>
<div class="col-12 bordered">
    <div class="col-12">
        <strong>USUARIO:&nbsp; </strong> <?php echo $data['usuario'] ?>
    </div><br/>
    <div class="col-8">
        <strong>TIPO DE AJUSTE:&nbsp;</strong><?php echo $data["tipo"] ?>
    </div>
    <div class="col-4" style="text-align: right">
        <strong >FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?>
    </div><br/>
    <div class="col-12">
        <strong>NOTA:&nbsp;</strong><br><?php echo $data["nota"] ?>
    </div>
</div><br/><br/>
<table cellspacing="0"> 
    <thead>
        <tr>
            <th class="col-1" style="text-align: center;">COD</th>
            <th class="col-5" style="text-align: center;">DESCRIPCION</th>
            <?php
            switch ($data["tipo"]) {
                case "ENTRADA":
                case "SALIDA":
                    ?> 
                    <th class="col-1" style="text-align: center;">UND</th>
                    <th class="col-1" style="text-align:center;" >CANTIDAD</th> 
                    <?php
                    break;
                case "COSTO":
                case "UTILIDAD":
                    ?>
                    <th class="col-1" style="text-align: center;">ANTERIOR</th>
                    <th class="col-1" style="text-align:center;" >ACTUAL</th>
                    <th class="col-1" style="text-align:center;" >VIGENTE</th> 
                    <?php
                    break;
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data['detalles'] as $pro) {
            ?><tr>
                <td class="col-1" style=" text-align: center; ;"><?php echo $pro['codigo']; ?></td>
                <td class="col-5" style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left; "><?php echo $pro['descripcion']; ?></td>
                <?php
                switch ($data["tipo"]) {
                    case "ENTRADA":
                    case "SALIDA":
                        ?> 
                        <td class="col-1" style=" text-align: center; ;"><?php echo $pro['medida']; ?></td>
                        <td class="col-1" style=" text-align: center; "><?php echo $pro['unidades']; ?></td>
                        <?php
                        break;
                    case "COSTO":
                        ?><th class="col-1" style="text-align: center;">
                            ANTERIOR
                        </th><th class="col-1" style="text-align: center;">
                            ANTERIOR
                        </th><th class="col-1" style="text-align: center;">
                            ANTERIOR
                        </th><?php
                        break;
                    case "UTILIDAD":
                        ?><th class="col-1" style="text-align: center;">
                            ANTERIOR
                        </th><th class="col-1" style="text-align: center;">
                            ANTERIOR
                        </th><th class="col-1" style="text-align: center;">
                            ANTERIOR
                        </th><?php
                        break;
                }
                ?>
                <td class="col-1" style=" text-align: center; ;"><?php echo $pro['medida']; ?></td>
                <td class="col-1" style=" text-align: center; "><?php echo $pro['unidades']; ?></td>
                <td class="col-2" style=" text-align: right; "><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
                <td class="col-2" style=" text-align: right;"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>
            </tr><?php
        }
        ?>
    </tbody>
</table>