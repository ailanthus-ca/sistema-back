
CREATE  VIEW `debitos_emitidos_lista` AS
SELECT DISTINCT
debitosemitidos.codigo,
debitosemitidos.fecha,
cod_factura,
nombre,
cod_cliente,
debitosemitidos.monto,
debitosemitidos.estado,
debitosemitidos.usuario
FROM debitosemitidos, factura_lista
WHERE cod_factura=codFact;


CREATE  OR REPLACE VIEW `creditos_emitidos_lista` AS
SELECT DISTINCT
creditosemitidos.codigo,
creditosemitidos.fecha,
cod_factura,
nombre,
cod_cliente,
monto,
estado,
creditosemitidos.usuario
FROM creditosemitidos, factura_lista
WHERE cod_factura=codFact;

CREATE  OR REPLACE VIEW `debitos_recibidos_lista` AS
SELECT DISTINCT
debitosrecibidos.codigo,
debitosrecibidos.fecha,
cod_compra,
nombre,
cod_proveedor,
monto,
estado,
debitosrecibidos.usuario
FROM debitosrecibidos , compra_lista
WHERE cod_compra=codFact;
CREATE  OR REPLACE VIEW `creditos_recibidos_lista` AS
SELECT DISTINCT
creditosrecibidos.codigo,
creditosrecibidos.fecha,
cod_compra,
nombre,
cod_proveedor,
monto,
estado,
creditosrecibidos.usuario
FROM creditosrecibidos , compra_lista
WHERE cod_compra=codFact;