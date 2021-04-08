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
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>HISTORICO DEL PRODUCTO:</strong></span><br>
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $des ?></strong></span><br>
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $titulo ?></strong></span><br>
    </div>
    <br>
    <br>
    <div class="table-responsive">
        <table border="1" CELLSPACING="-1" class="table">
            <tr>
                <th width="100" align="center">Fecha</th>
                <th width="100" align="center">Codigo</th>
                <th width="100" align="center">OPERACION</th>
                <th width="200" align="center">Nombre</th>
                <th width="50"  align="center">Entrada</th>
                <th width="50"  align="center">Salida</th>
                <th width="50"  align="center">Total</th>
            </tr>
            <?php
            $total = 0;
            foreach ($his as $row) {
                ?>
                <tr>
                    <td width="100" align="center"><?php echo $row['fecha']; ?></td>
                    <td width="100" align="center"><?php echo $row['codigo']; ?></td>
                    <td width="100" align="center"><?php echo $row['opera']; ?></td>
                    <td width="200" align="center"><?php echo $row['nombre']; ?></td>
                    <?php
                    if ($row['tipo'] == 'ENTRADA') {
                        $total += $row['cantidad'];
                        echo '<td width="50"  align="center">' . $row['cantidad'] . '</td><td width="50"  align="center"></td>';
                    } elseif ($row['tipo'] == 'SALIDA') {
                        $total -= $row['cantidad'];
                        echo '<td width="50"  align="center"></td><td width="50"  align="center">' . $row['cantidad'] . '</td>';
                    }
                    ?>
                    <td width="50"  align="center"><?php echo $total ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>

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