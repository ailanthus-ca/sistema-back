<?php

namespace Control;

class Producto {

    function lista() {
        $Producto = new \Modelos\Producto();
        return json_encode($Producto->lista());
    }

    function detalles($cod) {
        $Producto = new \Modelos\Producto();
        return json_encode($Producto->ver($cod));
    }

    function nuevo() {
        $Producto = new \Modelos\Producto();
        //datos de tipo post
        $Producto->departamento = $Producto->postString('departamento');
        $Producto->descripcion = $Producto->postString('descripcion');
        $Producto->costo = $Producto->postFloat('costo');
        $Producto->precio1 = $Producto->postFloat('precio1');
        $Producto->precio2 = $Producto->postFloat('precio2');
        $Producto->precio3 = $Producto->postFloat('precio3');
        $Producto->tipo = $Producto->postIntenger('tipo');
        $Producto->unidad = $Producto->postIntenger('unidad');
        $Producto->enser = $Producto->postIntenger('enser');
        $Producto->excento = $Producto->postString('excento');
        $Producto->dolar = $Producto->postFloat('dolar');
        //validaciones
        //cantidad de productos por categoria
        $dep = new \Modelos\Departamento();
        $num = $dep->count($Producto->departamento);
        //comprobar si el codigo es valido
        while ($Producto->checkCodigo("$Producto->departamento$num")) {
            $num++;
        }
        //asignar codigo
        $Producto->codigo = "$Producto->departamento$num";
        //crear y responder
        return json_encode($Producto->nuevo());
    }

    function actualizar($id) {
        $Producto = new \Modelos\Producto();
        //datos de tipo post
        $Producto->descripcion = $Producto->postString('descripcion');
        $Producto->unidad = $Producto->postIntenger('unidad');
        // Validar que exista codigo
        if (!$Producto->checkCodigo($id)) {
            $Producto->setError('Producto no existe');
        }
        //Validar si hubo errores
        if ($Producto->response > 300) {
            return json_encode($Producto->getResponse());
        }
        //crear y responder
        return json_encode($Producto->actualizar($id));
    }

    function cancelar($id) {
        $Producto = new \Modelos\Producto();
        return json_encode($Producto->cancelar($id));
    }

    function inventario($departamento, $uso, $tipo, $min, $max) {
        $where = '';
        $titulo = '';
        if ($departamento !== "TODO") {
            $where .= " and departamento = '$departamento'";
            $dp = new \Modelos\Departamento();
            $row = $dp->detalles($departamento);
            $titulo .= 'DEL DEPARTAMENTO ' . $row['descripcion'];
        }
        if ($uso !== "2") {
            $where .= " and enser =  '$uso'";
            if ($uso === '1')
                $titulo .= ' PARA USO INTERNO ';
            else
                $titulo .= ' PARA LA VENTA';
        }
        if ($min !== "-1") {
            $where .= " and cantidad > $min";
            $titulo .= " COM ESTOCK MAYOR A $min";
        }
        if ($max !== "-1") {
            $where .= " and cantidad > $max";
            $titulo .= " COM ESTOCK MENOR A $max";
        }
        if ($tipo !== "-1") {
            $tp = new \Modelos\Tipo();
            $row = $tp->detalles($tipo);
            $where .= " and tipo = $tipo";
            $titulo .= " TIPO DE PRODUCTO " . $row['descripcion'];
        }
        $Producto = new \Modelos\Producto();
        $data = array(
            'productos' => $Producto->listaWhere($where),
            'titulo' => $titulo
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'productos';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function reporte($cod, $rango, $p1, $p2) {
        $compras = new \Modelos\Compra();
        $factura = new \Modelos\Factura();
        $nota = new \Modelos\Nota();
        $ajuste = new \Modelos\Ajuste();
        $where = '';
        $titulo = "DESDE EL INICIO DE LOS TIEMPOS";
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $compras->numberToMes($p2);
                $titulo = "$m DEl $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where = "AND fecha between '$p1' AND '$p2' ";
                $titulo = "DESDE " . $date1->format("d-m-Y") . " HASTA " . $date2->format("d-m-Y");
                break;
        }

        $com = $compras->listaWithProducto($cod, $where . ' AND compra.estatus > 0');
        $fac = $factura->listaWithProducto($cod, $where . ' AND factura.estatus > 0');
        $not = $nota->listaWithProducto($cod, $where . ' AND notasalida.estatus > 0');
        $aju = $ajuste->listaWithProducto($cod, $where);
        $operaciones = array_merge($com, $fac, $not, $aju);
        usort($operaciones, function ($a, $b) {
            return $a['orden'] - $b['orden'];
        });

        $producto = new \Modelos\Producto();
        $pro = $producto->ver($cod);
        $data = array(
            'operaciones' => $operaciones,
            'title' => $pro['descripcion'] . '<br>' . $titulo
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'historico';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

}
