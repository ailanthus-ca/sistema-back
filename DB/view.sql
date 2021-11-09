
-- -----------------------------------------------------
-- View `factura_lista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `factura_lista`;
SHOW WARNINGS;
DROP VIEW IF EXISTS `factura_lista` ;
SHOW WARNINGS;

CREATE  OR REPLACE VIEW `factura_lista` AS
SELECT DISTINCT 
factura.codigo as codFact, 
fecha,cod_cliente,
factura.actualizado,
nombre,
total,
factura.estatus as status,
factura.usuario  
FROM factura,cliente 
WHERE factura.cod_cliente = cliente.codigo 
order by fecha DESC;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `cotizacion_lista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cotizacion_lista`;
SHOW WARNINGS;
DROP VIEW IF EXISTS `cotizacion_lista` ;
SHOW WARNINGS;

CREATE  OR REPLACE VIEW `cotizacion_lista` AS
SELECT DISTINCT 
cotizacion.codigo as codFact, 
fecha,cod_cliente,
nombre,
total,
cotizacion.actualizado,
cotizacion.estatus as status, 
usuario,tasa   
FROM cotizacion,cliente 
WHERE cotizacion.cod_cliente = cliente.codigo 
order by fecha desc;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `nota_lista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `nota_lista`;
SHOW WARNINGS;
DROP VIEW IF EXISTS `nota_lista` ;
SHOW WARNINGS;

CREATE  OR REPLACE VIEW `nota_lista` AS
SELECT DISTINCT 
notasalida.codigo as codFact, 
fecha,cod_cliente,
nombre,
total,
notasalida.actualizado,
notasalida.estatus as status,
notasalida.usuario 
FROM notasalida,cliente 
WHERE notasalida.cod_cliente = cliente.codigo 
order by fecha DESC;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `compra_lista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `compra_lista`;
SHOW WARNINGS;
DROP VIEW IF EXISTS `compra_lista` ;
SHOW WARNINGS;

CREATE  OR REPLACE VIEW `compra_lista` AS
SELECT DISTINCT 
compra.codigo as codFact,
fecha,
cod_proveedor, 
nombre,
total,
compra.actualizado,
compra.estatus as status,
compra.usuario  
FROM compra,proveedor 
WHERE compra.cod_proveedor = proveedor.codigo 
order by fecha DESC;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `orden_lista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orden_lista`;
SHOW WARNINGS;
DROP VIEW IF EXISTS `orden_lista` ;
SHOW WARNINGS;

CREATE  OR REPLACE VIEW `orden_lista` AS
SELECT DISTINCT 
ordencompra.codigo as codFact,
fecha,
cod_proveedor,
nombre,
total,
ordencompra.actualizado,
ordencompra.estatus as status,
usuario 
FROM ordencompra,proveedor 
WHERE ordencompra.cod_proveedor = proveedor.codigo 
order by fecha DESC;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `ajuste_lista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ajuste_lista`;
SHOW WARNINGS;
DROP VIEW IF EXISTS `ajuste_lista` ;
SHOW WARNINGS;

CREATE  OR REPLACE VIEW `ajuste_lista` AS
SELECT DISTINCT 
ajusteinv.codigo as codFact,
tipo_ajuste, 
fecha, 
ajusteinv.actualizado,
ajusteinv.estatus, 
usuario, 
usuario.nombre as nombre, 
nota 
FROM `ajusteinv`, `usuario` 
WHERE ajusteinv.usuario = usuario.codigo
order by fecha DESC;
SHOW WARNINGS;
