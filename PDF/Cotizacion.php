<?php

namespace PDF;

class Cotizacion extends \PDFClass {

    function ver($cotizacion) {
        $sql = $this->con->query("SELECT *from conf_region") or die(mysqli_error());
        if ($row = $sql->fetch_array()) {
            $cod_fiscal = $row['codigo_fiscal'];
        }
        $this->style();
        ?><page><?php
            $this->encabesado();
            $fecha = new \DateTime($cotizacion['fecha']);
            ?><br><br>
            <div style="text-align: left;">
                <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL CLIENTE</strong></span>
            </div>

            <table border="0" cellspacing="3" style="width: 100%; font-size: 7pt;">
                <tr>
                    <td style="width: 100%;">	
                        <table cellspacing="3" style="width: 100%; font-size: 7pt;">   
                            <tr>
                                <td  style="width: 82%;"><strong style="font-size: 7pt;">NOMBRE:&nbsp; </strong> <?php echo $cotizacion['nombre'] ?></td>      	
                                <td style="width: 20%;"><strong style="font-size: 7pt;">FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?> </td>		
                            </tr>
                        </table>

                        <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                            <tr>
                                <td style="width: 82%;"> <strong style="font-size: 7pt;"><?php echo $cod_fiscal ?>:&nbsp;</strong> <?php echo $cotizacion["cod_cliente"] ?></td>
                                <td style="width: 20%;"> <strong style="font-size: 7pt;">NRO. COT:&nbsp;</strong> <?php echo $cotizacion['codigo'] ?> </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $cotizacion["telefono"] ?> </td>
                            </tr>		
                        </table>

                        <table cellspacing="3" style="text-align: left; font-size: 7pt;">
                            <tr>
                                <td style="width: 30%;"> <strong style="font-size: 7pt;">DIRECCIÓN:&nbsp;</strong><?php echo $cotizacion["direccion"] ?> </td>				
                            </tr>
                            <tr>
                                <td style="width: 30%;"> <strong style="font-size: 7pt;">ATENCIÓN:&nbsp;</strong><?php echo $cotizacion["contacto"] ?> </td>
                            </tr>
                        </table>
                    </td>	
                </tr>	
            </table>
            <br>
            <!--Titulo del reporte-->
            <div style="text-align: center;">
                <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>C O T I Z A C I O N</strong></span>
            </div>
            <hr>
            <br>
            <br>				

            <div style="text-align: left;">
                <span style="font-size:10px;font-weight:bold"><strong>DESCRIPCION DE LA COTIZACION</strong></span>
            </div>
            <!--<hr>-->

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
                foreach ($cotizacion['detalles'] as $pro) {
                    $sql = $this->con->query("SELECT * from unidad where codigo=" . $pro['unidad']) or die(mysqli_error());
                    if ($row = $sql->fetch_array()) {
                        $unidad = $row['descripcion'];
                    }
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
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($cotizacion['subtotal'], 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="widtd: 85%; text-align: right;"><strong> IVA: </strong></td>
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($cotizacion['impuesto'], 2, ',', '.'); ?></td>
                </tr><tr>
                    <td colspan="4" style="widtd: 85%; text-align: right;"><strong> TOTAL:</strong></td>
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format($cotizacion['total'], 2, ',', '.'); ?></td>
                </tr>

            </table>
            <?php
            $this->condiciones($cotizacion);
            $this->footer();
            ?></page><?php
    }

    function dolar($cotizacion) {
        $sql = $this->con->query("SELECT *from conf_region") or die(mysqli_error());
        if ($row = $sql->fetch_array()) {
            $cod_fiscal = $row['codigo_fiscal'];
        }
        $this->style();
        ?><page><?php
            $this->encabesado();
            $fecha = new \DateTime($cotizacion['fecha']);
            ?><br><br>
            <div style="text-align: left;">
                <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL CLIENTE</strong></span>
            </div>

            <table border="0" cellspacing="3" style="width: 100%; font-size: 7pt;">
                <tr>
                    <td style="width: 100%;">	
                        <table cellspacing="3" style="width: 100%; font-size: 7pt;">   
                            <tr>
                                <td  style="width: 82%;"><strong style="font-size: 7pt;">NOMBRE:&nbsp; </strong> <?php echo $cotizacion['nombre'] ?></td>      	
                                <td style="width: 20%;"><strong style="font-size: 7pt;">FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?> </td>		
                            </tr>
                        </table>

                        <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                            <tr>
                                <td style="width: 82%;"> <strong style="font-size: 7pt;"><?php echo $cod_fiscal ?>:&nbsp;</strong> <?php echo $cotizacion["cod_cliente"] ?></td>
                                <td style="width: 20%;"> <strong style="font-size: 7pt;">NRO. COT:&nbsp;</strong> <?php echo $cotizacion['codigo'] ?> </td>
                            </tr>
                            <tr>
                                <td style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $cotizacion["telefono"] ?> </td>
                            </tr>		
                        </table>

                        <table cellspacing="3" style="text-align: left; font-size: 7pt;">
                            <tr>
                                <td style="width: 30%;"> <strong style="font-size: 7pt;">DIRECCIÓN:&nbsp;</strong><?php echo $cotizacion["direccion"] ?> </td>				
                            </tr>
                            <tr>
                                <td style="width: 30%;"> <strong style="font-size: 7pt;">ATENCIÓN:&nbsp;</strong><?php echo $cotizacion["contacto"] ?> </td>
                            </tr>
                        </table>
                    </td>	
                </tr>	
            </table>
            <br>
            <!--Titulo del reporte-->
            <div style="text-align: center;">
                <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>C O T I Z A C I O N</strong></span>
            </div>
            <hr>
            <br>
            <br>				

            <div style="text-align: left;">
                <span style="font-size:10px;font-weight:bold"><strong>DESCRIPCION DE LA COTIZACION</strong></span>
            </div>
            <!--<hr>-->

            <table border="1" cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
                <tr>
                    <th style="width: 10%;text-align:center;" >CANTIDAD</th>
                    <th style="width: 50%;text-align: center;">DESCRIPCION</th>
                    <th style="width: 10%;text-align: center;">UND</th>
                    <th style="width: 15%;text-align: center;">PRECIO $</th>
                    <th style="width: 15%;text-align: center;">TOTAL $</th>

                </tr>
                <?php
                $subtotal = 0;
                foreach ($cotizacion['detalles'] as $pro) {
                    $sql = $this->con->query("SELECT * from unidad where codigo=" . $pro['unidad']) or die(mysqli_error());
                    if ($row = $sql->fetch_array()) {
                        $unidad = $row['descripcion'];
                    }
                    ?><tr>
                        <td style=" text-align: center; height: 15px; vertical-align: middle;"><?php echo $pro['unidades']; ?></td>
                        <td style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $pro['descripcion']; ?></td>
                        <td style=" text-align: center; height: 15px; vertical-align: middle;;"><?php echo $unidad; ?></td>
                        <td style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format(($pro['precio']/$cotizacion['tasa']), 2, ',', '.'); ?></td>
                        <td style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format(($pro['unidades'] * $pro['precio']/$cotizacion['tasa']), 2, ',', '.'); ?></td>

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
                    <td colspan="4" style="widtd: 85%; text-align: right;"><strong> SUB TOTAL $: </strong></td>
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format(($cotizacion['subtotal']/$cotizacion['tasa']), 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="widtd: 85%; text-align: right;"><strong> IVA $: </strong></td>
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format(($cotizacion['impuesto']/$cotizacion['tasa']), 2, ',', '.'); ?></td>
                </tr><tr>
                    <td colspan="4" style="widtd: 85%; text-align: right;"><strong> TOTAL $:</strong></td>
                    <td style="widtd: 15%; text-align: right;"> <?php echo number_format(($cotizacion['total']/$cotizacion['tasa']), 2, ',', '.'); ?></td>
                </tr>

            </table>
            <?php
            $this->condiciones($cotizacion);
            $this->footer();
            ?></page><?php
    }
}
