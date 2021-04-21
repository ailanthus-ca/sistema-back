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
        //validaciones
        //cantidad de productos por categoria
        $dep = new \Modelos\Departamento();
        $num = $dep->count($Producto->departamento);
        //comprobar si el codigo es valido
        while ($Producto->checkCodigo($Producto->departamento + $num)) {
            $num++;
        }
        //asignar codigo
        $Producto->codigo = $Producto->departamento + $num;
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

    function inventario($departamento, $tipo, $stock) {
        $where = '';
        $titulo = '';
        if ($departamento !== "TODO") {
            $where .= " and departamento = '$departamento'";
            $dp = new \Modelos\Departamento();
            $row = $dp->detalles($departamento);
            $titulo .= 'DEL DEPARTAMENTO ' . $row['descripcion'];
        }
        if ($tipo !== "2") {
            $where .= " and enser =  '$tipo'";
            if ($tipo === '1')
                $titulo .= ' PARA USO INTERNO ';
            else
                $titulo .= ' PARA LA VENTA';
        }
        if ($stock !== "null") {
            $where .= " and cantidad > $stock";
            $titulo .= " COM ESTOCK MAYOR A $stock";
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

    function reporte($rango, $p1, $p2, $cod) {
        $compras = new \Modelos\Compra();
        $where = "";
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 AND compra.estatus = 2";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 AND compra.estatus = 2";
                $m = $compras->numberToMes($p2);
                $titulo = "$m DEl $p1";
                break;
            case 'rango':
                $date1 = new DateTime($p1);
                $date2 = new DateTime($p2);
                $where = "AND fecha between '$p1' AND '$p2' AND compra.estatus = 2";
                $titulo = "DESDE " . $date1->format("d-m-Y") . " HASTA " . $date2->format("d-m-Y");
                break;
            default :
                $titulo = "TODO";
                break;
        }
        $data = array();
        $sql = $con->query("select fecha,compra.codigo as codigo,proveedor.nombre as nombre,cantidad from compra,detallecompra,proveedor WHERE proveedor.codigo=cod_proveedor and compra.codigo=cod_compra and compra.estatus = 2 and cod_producto = '$cod' " . $where);
        while ($row = $sql->fetch_array()) {
            $data[] = array(
                'fecha' => $row['fecha'],
                'orden' => strtotime($row['fecha']),
                'tipo' => 'ENTRADA',
                'opera' => 'COMPRA',
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'cantidad' => $row['cantidad']
            );
        }
        $sql = $con->query("select fecha,factura.codigo as codigo,cliente.nombre as nombre,cantidad from factura,detallefactura,cliente WHERE cliente.codigo=cod_cliente and factura.codigo=codFactura and factura.estatus = 2 and codProducto = '$cod' " . $where);
        while ($row = $sql->fetch_array()) {
            $data[] = array(
                'fecha' => $row['fecha'],
                'orden' => strtotime($row['fecha']),
                'tipo' => 'SALIDA',
                'opera' => 'VENTA',
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'cantidad' => $row['cantidad']
            );
        }
        $sql = $con->query("select fecha,ajusteinv.codigo as codigo,tipo_ajuste,usuario.nombre as nombre,cantidad from ajusteinv,detalleajusteinv,usuario WHERE usuario.codigo=usuario and ajusteinv.codigo=cod_ajuste and cod_producto = '$cod' " . $where);
        while ($row = $sql->fetch_array()) {
            $data[] = array(
                'fecha' => $row['fecha'],
                'orden' => strtotime($row['fecha']),
                'tipo' => $row['tipo_ajuste'],
                'opera' => 'AJUSTE',
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'cantidad' => $row['cantidad']
            );
        }

        $sql = $con->query("select fecha,notasalida.codigo as codigo,cliente.nombre as nombre,cantidad from notasalida,detallesNotas,cliente WHERE cliente.codigo=notasalida.cod_cliente and notasalida.codigo=detallesNotas.nota and notasalida.estatus=1 and detallesNotas.producto = '$cod' " . $where);
        while ($row = $sql->fetch_array()) {
            $data[] = array(
                'fecha' => $row['fecha'],
                'orden' => strtotime($row['fecha']),
                'tipo' => 'SALIDA',
                'opera' => 'NOTA DE ENTREGA',
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'cantidad' => $row['cantidad']
            );
        }
        
        $data = array(
            'compras' => $compras->listaWhere($where),
            'titulo' => $titulo
        );
        $where = '';
        $titulo = '';
        if ($departamento !== "TODO") {
            $where .= " and departamento = '$departamento'";
            $dp = new \Modelos\Departamento();
            $row = $dp->detalles($departamento);
            $titulo .= 'DEL DEPARTAMENTO ' . $row['descripcion'];
        }
        if ($tipo !== "2") {
            $where .= " and enser =  '$tipo'";
            if ($tipo === '1')
                $titulo .= ' PARA USO INTERNO ';
            else
                $titulo .= ' PARA LA VENTA';
        }
        if ($stock !== "null") {
            $where .= " and cantidad > $stock";
            $titulo .= " COM ESTOCK MAYOR A $stock";
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

}
