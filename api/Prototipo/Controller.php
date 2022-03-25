<?php

namespace Prototipo;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller extends \conexion {

    var $model = '';
    var $tabla = '';

    public function getModelo() {
        $obj = '\\Modelos\\' . $this->model;
        return new $obj();
    }

    public function getPDF() {
        $obj = '\\PDF\\' . $this->model;
        return new $obj();
    }

    public function cambios($fecha, $hora) {
        $bj = $this->getModelo();
        return json_encode($bj->cambios($fecha, $hora));
    }

    public function lista() {
        $bj = $this->getModelo();
        return json_encode($bj->lista());
    }

    public function detalles($id) {
        $bj = $this->getModelo();
        return json_encode($bj->detalles($id));
    }

    public function cancelar($id) {
        $bj = $this->getModelo();
        return json_encode($bj->cancelar($id));
    }

    public function getRango($rango, $p1, $p2) {
        $get = [];
        switch ($rango) {
            case 'ano':
                $get['w'] = " AND YEAR(fecha) = $p1 ";
                $get['t'] = "AÑO $p1";
                break;
            case 'mes':
                $get['w'] = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $this->numberToMes($p2);
                $get['t'] = "$m DEl $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $get['w'] = " AND fecha between '$p1' AND '$p2' ";
                $get['t'] = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default :
                $get['w'] = "";
                $get['t'] = "TODO";
                break;
        }
        return $get;
    }

    public function PDF($id) {
        $bj = $this->getModelo();
        $data = $bj->detalles($id);
        $pdf = $this->getPDF();
        ob_start();
        $pdf->ver($data, 'BS');
        $content = ob_get_clean();
        $pdf->ouput($this->model . '.pdf', $content);
    }

    public function PDFD($id) {
        $bj = $this->getModelo();
        $data = $bj->detalles($id);
        if ($data['tasa'] == 0)
            return "<h1>ESTA CONSULTA NO POSEE MONTO EN DOLARES</h1>";
        $d = $data['detalles'];
        $data['detalles'] = array();
        $detalle = array();
        foreach ($d as $row) {
            $detalle = $row;
            $detalle['precio'] = $row['precio'] / $data['tasa'];
            $data['detalles'][] = $detalle;
        }
        $pdf = $this->getPDF();
        ob_start();
        $pdf->ver($data, '$');
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    public function reporte($rango, $p1, $p2) {
        $bj = $this->getModelo();
        $get = $this->getRango($rango, $p1, $p2);
        $where = $get['w'] . " AND $this->tabla.estatus = 2";
        $titulo = $get['t'];
        $data = array(
            'lista' => $bj->listaWhere($where),
            'titulo' => $titulo,
            'operacion' => strtoupper($this->tabla)
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = $this->tabla;
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function de2($cod, $rango, $p1, $p2, $ver, $lista, $operacion) {
        $bj = $this->getModelo();
        $get = $this->getRango($rango, $p1, $p2);
        $producto = new \Modelos\Producto();
        $pro = $producto->ver($cod);
        $data = array(
            $lista => $bj->listaWithProducto($cod, $get['w'] . " AND $this->tabla.estatus > 0"),
            'titulo' => $pro['descripcion'] . '<br>' . $get['t'],
            'operacion' => $operacion
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = $ver;
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput($this->model . '.pdf', $content);
    }

    function productos($dpt, $rango, $p1, $p2) {
        $facturas = new \Modelos\Factura();
        $get = $this->getRango($rango, $p1, $p2);
        $where = $get['w'];
        $titulo = $get['t'];
        if ($dpt !== 'TODO') {
            $where .= " and departamento = '$dpt'";
            $dp = new \Modelos\Departamento();
            $row = $dp->detalles($dpt);
            $titulo .= '<br> DEL DEPARTAMENTO ' . $row['descripcion'];
        }
        $data = array(
            'itens' => $facturas->productos($where . ' AND factura.estatus > 0'),
            'titulo' => $titulo,
            'operacion' => 'FACTURAS'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'productosDe';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }
}
