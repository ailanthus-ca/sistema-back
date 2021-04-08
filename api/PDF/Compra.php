<?php

namespace PDF;

class Compra extends \PDFClass {

    function ver($compra) {
        $sql = $this->con->query("SELECT *from conf_region") or die(mysqli_error());
        if ($row = $sql->fetch_array()) {
            $cod_fiscal = $row['codigo_fiscal'];
        }
        $this->style();
        ?><page><?php
            $this->encabesado();
            $fecha = new \DateTime($compra['fecha']);
            ?>
            <br><br>
            <div style="text-align: left;">
                <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL PROVEEDOR</strong></span>
            </div>

            <table cellspacing="3" style="width: 100%; font-size: 7pt;">
                <tr>
                    <td  style="width: 80%;"><strong style="font-size: 7pt;">NOMBRE Y <br> RAZON SOCIAL: &nbsp; </strong> <?php echo $compra['nombre']; ?></td>        	
                    <td style="width: 20%;"><strong style="font-size: 7pt;">FECHA: &nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?></td>			
                </tr>
            </table>

            <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                <tr>
                    <td style="width: 80%;"> <strong style="font-size: 7pt;"><?php echo $cod_fiscal ?>:&nbsp;</strong> <?php echo $compra["cod_proveedor"]; ?></td>
                    <td style="width: 30%;"> <strong style="font-size: 7pt;">NUM. COMPRA:&nbsp;</strong><?php echo $compra['codigo'] ?></td>
                </tr>
                <tr>
                    <td style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $compra["telefono"]; ?></td>
                </tr>		
            </table>

            <table cellspacing="3" style="text-align: left; font-size: 7pt;">
                <tr>
                    <td style="width: 100%;"> <strong style="font-size: 7pt;">DIRECCION <br> FISCAL:&nbsp;</strong><?php echo $compra['direccion']; ?> </td>
                </tr>
            </table>

            <br>
            <!--Titulo del reporte-->
            <div style="text-align: center;">
                <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>C O M P R A</strong></span>
            </div>
            <hr>
            <br>
            <div style="text-align: left;">
                <span style="font-size:10px;font-weight:bold"><strong>DATOS DE LA COMPRA</strong></span>
            </div>

            <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                <tr>
                    <td style="width: 30%;"><strong>NRO. DOCUMENTO:&nbsp;</strong><?php echo $compra['cod_documento']; ?></td>
                    <td style="width: 30%;"><strong>FECHA DOCUMENTO:&nbsp;</strong><?php echo $compra['fecha_documento']; ?></td>
                </tr>
            </table>
            <table border="1" cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
                <tr>
                    <th style="width: 10%;text-align:center;" >CANTIDAD</th>
                    <th style="width: 50%;text-align: center;">DESCRIPCION</th>
                    <th style="width: 10%;text-align: center;">UND</th>
                    <th style="width: 15%;text-align: center;">PRECIO</th>
                    <th style="width: 15%;text-align: center;">TOTAL</th>

                </tr>
                <?php
                $subtotal = 0;
                foreach ($compra['detalles'] as $pro) {
                    $sql = $this->con->query("SELECT * from unidad where codigo=" . $pro['unidad']) or die(mysqli_error());
                    if ($row = $sql->fetch_array()) {
                        $unidad = $row['descripcion'];
                    }
                    $subtotal += $pro['unidades'] * $pro['precio'];
                    ?><tr>
                        <td style=" text-align: center; height: 15px; vertical-align: middle;"><?php echo $pro['unidades']; ?></td>
                        <td style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $pro['descripcion']; ?></td>
                        <td style=" text-align: center; height: 15px; vertical-align: middle;;"><?php echo $unidad; ?></td>
                        <td style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
                        <td style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>

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
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($compra['impuesto'], 2, ',', '.'); ?></td>
                </tr><tr>
                    <td colspan="4" style="widtd: 85%; text-align: right;"><strong> TOTAL COMPRA:</strong></td>
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal + $compra['impuesto'], 2, ',', '.'); ?></td>
                </tr>

            </table>
            <?php
            $this->footer();
            ?></page><?php
    }

}
