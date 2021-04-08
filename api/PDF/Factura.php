<?php

namespace PDF;

class Factura extends \PDFClass {

    function ver($factura) {
        $sql = $this->con->query("SELECT *from conf_region") or die(mysqli_error());
        if ($row = $sql->fetch_array()) {
            $cod_fiscal = $row['codigo_fiscal'];
        }
        $this->style();
        ?><page><?php
            $fecha = new \DateTime($factura['fecha']);
            ?>
            <table cellspacing="3" style="width: 100%; font-size: 8pt;">   
                <tr>
                    <td  style="width: 80%;"><strong >NOMBRE Y <br> RAZON SOCIAL:&nbsp; </strong> <?php echo $factura['nombre'] ?></td>      	
                    <td style="width: 20%;"><strong >FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?> </td>		
                </tr>
            </table>

            <table cellspacing="3" style="width: 100%; text-align: left; font-size: 8pt;">
                <tr>
                    <td style="width: 50%;"> <strong ><?php echo $cod_fiscal ?>:&nbsp;</strong> <?php echo $factura["cod_cliente"] ?></td>
                    <td style="width: 30%;"> <strong >TELEFONO:&nbsp;</strong><?php echo $factura["telefono"] ?> </td>
                    <td style="width: 20%;"> <strong >NRO. FACT:&nbsp;</strong> <?php echo $factura['codigo'] ?> </td>
                </tr>		
            </table>

            <table cellspacing="3" style="text-align: left; font-size: 8pt;">
                <tr>
                    <td style="width: 100%;"> <strong > DIRECCION <br> FISCAL:&nbsp;</strong> <?php echo $factura['direccion'] ?></td>
                </tr>
                <tr>
                    <td><strong>CONDICION:&nbsp;</strong>
                        <?php
                        echo $factura["condicion"];
                        ?>	
                    </td>
                </tr>
            </table>		

            <br>

            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">
                <tr>
                    <th style="width: 10%;text-align:center;" >CANTIDAD</th>
                    <th style="width: 45%;text-align: center;">DESCRIPCION</th>
                    <th style="width: 10%;text-align: center;">UND</th>
                    <th style="width: 15%;text-align: center;">PRECIO</th>
                    <th style="width: 20%;text-align: center;">TOTAL</th>

                </tr>
            </table>
            <hr>
            <table cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">

                <?php
                $subtotal = 0;
                foreach ($factura['detalles'] as $pro) {
                    $sql = $this->con->query("SELECT * from unidad where codigo=" . $pro['unidad']) or die(mysqli_error());
                    if ($row = $sql->fetch_array()) {
                        $unidad = $row['descripcion'];
                    }
                    $subtotal += $pro['unidades'] * $pro['precio'];
                    ?><tr>
                        <td style=" width: 10%;text-align: center; height: 15px; vertical-align: middle;"><?php echo $pro['unidades']; ?></td>
                        <td style=" width: 45%; max-width: 40%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $pro['descripcion']; ?></td>
                        <td style=" width: 10%;text-align: center; height: 15px; vertical-align: middle;;"><?php echo $unidad; ?></td>
                        <td style=" width: 15%;text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
                        <td style=" width: 20%;text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>

                    </tr><?php
                }
                ?>

            </table>

            <table cellspacing="3" style="width: 100%; font-size: 7pt;">

                <tr>
                    <th style="width: 10%;text-align:center;"></th>
                    <th style="width: 50%; text-align: center;"></th>
                    <th style="width: 10%;text-align: center;"></th>
                    <th style="width: 15%;text-align: center;"></th>
                    <th style="width: 15%;text-align: center;"></th>

                </tr>

                <tr>
                    <td colspan="4" style="widtd: 85%; text-align: right;"><strong> SUB TOTAL: </strong></td>
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="widtd: 85%; text-align: right;"><strong> IVA: </strong></td>
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($factura['impuesto'], 2, ',', '.'); ?></td>
                </tr><tr>
                    <td colspan="4" style="widtd: 85%; text-align: right;"><strong> TOTAL COMPRA:</strong></td>
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal + $factura['impuesto'], 2, ',', '.'); ?></td>
                </tr>

            </table>
        </page><?php
    }

}
