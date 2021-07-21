<?php

namespace Control;

class Ajuste {

    public function lista() {
        $ajuste = new \Modelos\Ajuste;
        return json_encode($ajuste->lista());
    }

    public function detalles($id) {
        $ajuste = new \Modelos\Ajuste;
        return json_encode($ajuste->detalles($id));
    }

    public function nuevo() {
        $ajuste = new \Modelos\Ajuste;
        $ajuste->tipo_ajuste = $ajuste->postString("tipo");
        $ajuste->nota = $ajuste->postString("nota");
        $ajuste->detalles = $ajuste->postArray("detalles");

        // Validar si existe tipo de ajuste
        if ($ajuste->tipo_ajuste == '') {
            $ajuste->setError('SE DEBE AGREGAR UN TIPO DE AJUSTE');
        }
        // Validar si existe nota
        if ($ajuste->nota == '') {
            $ajuste->setError('SE DEBE AGREGAR UNA NOTA EN LA DESCRIPCION DEL AJUSTE');
        }
        //Validar si hubo errores
        if ($ajuste->response > 300) {
            return json_encode($ajuste->getResponse());
        }
        return json_encode($ajuste->nuevo());
    }

    public function cancelar($id) {
        $ajuste = new \Modelos\Ajuste;
        $data = $ajuste->detalles($id);
        if ($data['tipo'] === 'ENTRADA') {
            $producto = new \Modelos\Producto();
            foreach ($data['detalles'] as $pro) {
                $producto->cargar($pro['codigo']);
                if ($producto->checkStock($pro['unidades']))
                    $ajuste->setError('NO HAY EL STOCK PARA REALIZAR LA OPERACION');
            }
        }

        if ($data['status'] === 0) {
            $ajuste->setError('YA FUE REVERTIDA LA OPERACION');
        }

        if ($ajuste->response > 300)
            return json_encode($ajuste->getResponse());
        switch ($data['tipo']) {
            case 'ENTRADA': $ajuste->deshacerEntrada($data['detalles']);
                break;
            case 'SALIDA': $ajuste->deshacerSalida($data['detalles']);
                break;
            case 'COSTO': $ajuste->deshacerCosto($data['detalles']);
                break;
            case 'UTILIDAD': $ajuste->deshacerUtilidad($data['detalles']);
                break;
        }
        return json_encode($ajuste->cancelar($id));
    }

    function PDF($id) {
        $compras = new \Modelos\Ajuste;
        $data = $compras->detalles($id);
        $pdf = new \PDF\Ajuste;
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

}
