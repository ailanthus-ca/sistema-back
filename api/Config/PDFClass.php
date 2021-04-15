<?php

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class PDFClass extends \conexion {

    function ouput($name, $content) {
        $sql_conf = $this->query("SELECT *from conf_factura");
        if ($row = $sql_conf->fetch_array()) {
            $papel = $row['tipo_papel'];
        }
        try {
            $html2pdf = new HTML2PDF('P', $papel, 'es', true, 'UTF-8', array(15, 15, 15, 15));
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            if (file_exists(DR . '/output/' . $name))
                unlink(DR . '/output/' . $name);
            $html2pdf->output(DR . '/output/' . $name);
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

    function ouputFactura($name, $content) {
        $sql_conf = $this->query("SELECT *from conf_factura");
        if ($row = $sql_conf->fetch_array()) {
            $mtop = $row['margen_sup'];
            $mder = $row['margen_der'];
            $mizq = $row['margen_izq'];
            $mbot = $row['margen_inf'];
            $papel = $row['tipo_papel'];
        }
        try {
            $html2pdf = new HTML2PDF('P', $papel, 'es', true, 'UTF-8', array($mizq, $mtop, $mder, $mbot));
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            if (file_exists(DR . '/output/' . $name))
                unlink(DR . '/output/' . $name);
            $html2pdf->output(DR . '/output/' . $name);
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

    function style() {
        ?>
        <style type="text/css">
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
        </style>
        <?php
    }

    function encabesado() {
        $sql = $this->query("SELECT *FROM conf_empresa") or die(mysqli_error());
        $fila = $sql->fetch_array();
        ?>
        <div>
            <div class="row">
                <div style="width: 50px; height: 50px;">
                    <img style="width: 100%; height: 100%;" src="../public/imagenes/<?php echo $fila['logo']; ?>" alt="Logo"> 
                </div>
                <span style="margin-left: 70px;margin-top: -40px; font-size:16px;font-weight:bold"><?php echo $fila['nombre'] ?></span>
            </div>
            <div class="row">
                <span style="margin-left:  70px;margin-top: -20px; font-size:10px;font-weight:bold"><?php echo $fila['eslogan'] ?></span>
            </div>
            <div class="row">
                <span style="margin-left:  70px;margin-top: -20px; font-size:8px;font-weight:bold"><?php echo "RIF: " . $fila['numero_fiscal'] ?></span>
            </div>
            <div class="row">
                <span style="margin-left:  70px;margin-top: -20px; font-size:8px;font-weight:bold"><?php echo "Fecha:" . date("d-m-Y") ?></span>
            </div>
        </div>
        <?php
    }

    function footer() {
        $sql = $this->query("SELECT *FROM conf_empresa") or die(mysqli_error());
        $fila = $sql->fetch_array();
        ?><page_footer backtop="20">
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
        </page_footer><?php
    }

    function condiciones($iten) {
        ?><br>
        <div style="text-align: left;">
            <span style="font-size:10px;font-weight:bold"><strong>CONDICIONES</strong></span>
        </div>	
        <table border="1" cellspacing="0" style="width: 100%; font-size: 7pt;">
            <tr>
                <td style="width: 100%;">	
                    <table cellspacing="3" style="width: 100%; font-size: 7pt;">   
                        <tr>
                            <td  style="width: 80%;"><strong style="font-size: 7pt;">FORMA DE PAGO:&nbsp; </strong> <?php echo $iten['forma_pago'] ?></td>      	
                        </tr>
                        <tr>
                            <td  style="width: 80%;"><strong style="font-size: 7pt;">VALIDEZ DE LA OFERTA:&nbsp; </strong> <?php echo $iten['validez'] ?></td>      	
                        </tr>
                        <tr>
                            <td  style="width: 80%;"><strong style="font-size: 7pt;">TIEMPO DE ENTREGA:&nbsp; </strong> <?php echo $iten['tiempo_entrega'] ?></td>      	
                        </tr>
                        <tr>
                            <td  style="width: 80%;"><strong style="font-size: 7pt;">NOTA:&nbsp; </strong><?php echo $iten['nota']; ?></td> 
                        </tr>      	

                    </table>
                </td>
            </tr>	
        </table>
        <br>

        <table cellspacing="3" style="width: 100%; font-size: 7pt;">		  
            <tr>
                <td style="width: 80%">
                    <strong>Atentamente: <?php echo $iten['user'] ?></strong>
                </td>
            </tr>
        </table>
        <?php
    }

}
