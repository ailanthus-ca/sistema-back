<style type="text/css">
    <!--
    table { vertical-align: top; }
    tr    { vertical-align: top; }
    td    { vertical-align: top; }
    .midnight-blue{
        background:#2c3e50;
        padding: 4px 4px 4px;
        color:white;
        font-weight:bold;
        font-size:12px;
    }
    .silver{
        background:white;
        padding: 3px 4px 3px;
    }
    .clouds{
        background:#ecf0f1;
        padding: 3px 4px 3px;
    }
    .border-top{
        border-top: solid 1px #bdc3c7;

    }
    .border-left{
        border-left: solid 1px #bdc3c7;
    }
    .border-right{
        border-right: solid 1px #bdc3c7;
    }
    .border-bottom{
        border-bottom: solid 1px #bdc3c7;
    }
    table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}

    .check{
        width: 25px;
        height: 25px;
        border: 1px #000;
    }
    -->
</style>

<page >

    <!--Encabezado de la empresa-->
    <!--traer informacion de la empresa desde la base de datos--> 
    <?php
    $sql = $con->query("SELECT *FROM conf_empresa");
    $fila = $sql->fetch_array();

    include 'encabezado.php';
    ?>

    <hr>
    <br>

    <!--Titulo del reporte-->
    <div style="text-align: center;">
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>REPORTE DE INVENTARIO</strong></span>
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php
                if ($dp != "td") {
                    $sql = $con->query("SELECT * FROM departamento WHERE codigo = '" . $dp . "'");
                    while ($row = $sql->fetch_array())
                        echo "DEL DEPARTAMENTO " . $row['descripcion'];
                }
                ?></strong></span>
    </div>
    <br>
    <br>

    <table  cellspacing="5"  style="width: 300%; font-size: 10pt"; width="400">
        <br>
        <tr>
            <th width="100" style="width: 5%;">Codigo</th>
            <th width="300" style="width: 12%;">Descripción</th>
            <th width="50" style="width: 5%;">Unidad</th>
            <th width="50" style="width: 5%">Cantidad</th>
            <th width="20">check</th>

        </tr>
        <?php
        if ($val) {
            $sql = $con->query("SELECT * FROM producto " . $Where) or die(mysqli_error());
        } else {
            $sql = $con->query("SELECT * FROM producto ") or die(mysqli_error());
        }
        while ($row = $sql->fetch_array()) {
            $codigo = $row['codigo'];
            $descripcion = $row['descripcion'];
            $unidad = $row['unidad'];
            $sql2 = $con->query("SELECT * FROM unidad WHERE codigo = '$unidad' ");
            while ($row2 = $sql2->fetch_array())
                $tipo = $row2['descripcion'];
            $cantidad = $row['cantidad'];
            ?>

            <tr>
                <td width="100"><?php echo $codigo ?></td>
                <td width="400" style=" width: 10%; max-width: 10%; overflow: hidden; text-align: left;"><?php echo $descripcion ?></td>
                <td width="50"><?php echo $tipo ?></td>
                <td width="50" align="right"><?php echo $cantidad ?></td>
                <th><div class="check"></div></th>
            </tr>

            <?php
        }
        ?>

    </table>  

    <!--Pie de pagina del reporte-->
    <page_footer backtop="20">
        <hr>
        <div class="row" style="text-align: center; font-size: 10px;">
            <span> <?php echo $fila['direccion']; ?> </span>
        </div>
        <div class="row" style="text-align: center; font-size: 10px;">
            <span><?php echo $fila['telefono']; ?></span>	
        </div>
        <div class="row" style="text-align: center;font-weight:bold; font-size: 10px;">
            <span><?php echo $fila['web']; ?></span>	
        </div>	
    </page_footer>		  

</page>

<?php
mysqli_close($con);
?>