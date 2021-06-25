<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Control;

/**
 * Description of Nota
 *
 * @author victo
 */
class Nota extends \conexion {

    function lista() {
        $Nota = new \Modelos\Nota();
        return json_encode($Nota->lista());
    }

    function detalles($id) {
        $Nota = new \Modelos\Nota();
        return json_encode($Nota->detalles($id));
    }

    function nuevo() {
        $Nota = new \Modelos\Nota();
        $Nota->codigo = $Nota->postString('codigo');
        $Nota->cod_cliente = $Nota->postString('cod_cliente');
        $Nota->id_cotizacion = $Nota->postString('id_cotizacion');
        $Nota->nota = $Nota->postString("nota");
        $Nota->total = $Nota->postFloat("total");
        $Nota->detalles = $Nota->postArray("detalles");
        if ($Nota->id_cotizacion > 0) {
            $cotizacion = new Cotizacion();
            $Nota->user = $cotizacion->procesar($Nota->id_cotizacion);
        } else {
            $Nota->user = $_SESSION['id_usuario'];
        }

        // Validar que exista el cliente
        if ($Nota->cod_cliente == '') {
            $Nota->setError('Debe mandar un cliente');
        }
        // Validar cliente
        $Cliente=new \Modelos\Cliente();
        $Cliente->detalles($Nota->cod_cliente);
        if($Cliente->response==404){
            $Nota->setError('El cliente mandado no existe');         
        }
        // Validar si existe al menos un item(producto)
        if (count($Nota->detalles)==0) {
            $Nota->setError('No se mandaron productos');
        }
        // Validar total
        if ($Nota->total == 0) {
            $Nota->setError('No se mando el total');
        }
        //Validar si hubo errores
        if ($Nota->response > 300) {
            return json_encode($Nota->getResponse());
        }
        // Validar que exista Nota
        if ($Nota->checkCodigo($Nota->codigo)) {
            return $Nota->getResponse($Nota->detalles($Nota->codigo));
        }

        return json_encode($Nota->nuevo());
    }

    function cancelar($id) {
        $Nota = new \Modelos\Nota();
        return json_encode($Nota->cancelar($id));
    }

    function PDF($id) {
        $Nota = new \Modelos\Nota();
        $data = $Nota->detalles($id);
        $pdf = new \PDF\Nota();
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function reporte($rango, $p1, $p2) {
        $Factura = new \Modelos\Nota();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $Factura->numberToMes($p2);
                $titulo = "$m DEl $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where = " AND fecha between '$p1' AND '$p2' ";
                $titulo = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default :
                $where = "";
                $titulo = "TODO";
                break;
        }
        $data = array(
            'lista' => $Factura->listaWhere($where),
            'titulo' => $titulo,
            'operacion' => 'NOTA DE ENTREGA'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'factura';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function de($cod, $rango, $p1, $p2) {
        $nota = new \Modelos\Nota();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $nota->numberToMes($p2);
                $titulo = "$m DEL $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where = " AND fecha between '$p1' AND '$p2' ";
                $titulo = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default :
                $where = "";
                $titulo = "TODO";
                break;
        }
        $producto = new \Modelos\Producto();
        $pro = $producto->ver($cod);
        $data = array(
            'facturas' => $nota->listaWithProducto($cod, $where . ' AND notasalida.estatus > 0'),
            'titulo' => $pro['descripcion'] . '<br>' . $titulo,
            'operacion' => 'NOTA DE ENTREGA'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'facturaPor';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function productos($dpt, $rango, $p1, $p2) {
        $nota = new \Modelos\Nota();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $nota->numberToMes($p2);
                $titulo = "$m DEL $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where = " AND fecha between '$p1' AND '$p2' ";
                $titulo = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default :
                $where = "";
                $titulo = "TODO";
                break;
        }
        if ($dpt !== 'TODO') {
            $where .= " and departamento = '$dpt'";
            $dp = new \Modelos\Departamento();
            $row = $dp->detalles($dpt);
            $titulo .= '<br> DEL DEPARTAMENTO ' . $row['descripcion'];
        }
        $data = array(
            'itens' => $nota->productos($where . ' AND notasalida.estatus > 0'),
            'titulo' => $titulo,
            'operacion' => 'NOTA DE ENTREGA'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'productosDe';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function torta($rango, $p1, $p2) {
        $nota = new \Modelos\Nota();
        $data = array();
        switch ($rango) {
            case 'ano':
                $where = " YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $nota->numberToMes($p2);
                $titulo = "$m DEl $p1";
                break;
            default :
                $where = "";
                $titulo = "TODO";
                break;
        }
        $data = $nota->torta($where);
        return json_encode($data);
    }

}
