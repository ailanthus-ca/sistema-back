SELECT 
producto.codigo as codigo,
producto.descripcion as descripcion,
producto.departamento as departamento,
SUM( detalleordencompra.cantidad ) as cantidad,
SUM( detalleordencompra.precio_unit*detalleordencompra.cantidad ) as monto
FROM detalleordencompra,  producto, ordencompra 
WHERE producto.codigo = detalleordencompra.cod_producto 
AND ordencompra.codigo = detalleordencompra.cod_orden
GROUP BY `producto`.`codigo`