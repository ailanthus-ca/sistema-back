-- -----------------------------------------------------
-- Placeholder table for view `factura_lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `factura_lista` (`codFact` INT, `fecha` INT, `cod_cliente` INT, `nombre` INT, `total` INT, `status` INT, `usuario` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `cotizacion_lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cotizacion_lista` (`codFact` INT, `fecha` INT, `cod_cliente` INT, `nombre` INT, `total` INT, `status` INT, `usuario` INT, `tasa` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `nota_lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nota_lista` (`codFact` INT, `fecha` INT, `cod_cliente` INT, `nombre` INT, `total` INT, `status` INT, `usuario` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `compra_lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compra_lista` (`codFact` INT, `fecha` INT, `cod_proveedor` INT, `nombre` INT, `total` INT, `status` INT, `usuario` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `orden_lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orden_lista` (`codFact` INT, `fecha` INT, `cod_proveedor` INT, `nombre` INT, `total` INT, `status` INT, `usuario` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `ajuste_lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ajuste_lista` (`codFact` INT, `tipo_ajuste` INT, `fecha` INT, `estatus` INT, `usuario` INT, `nombre` INT, `nota` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `recibidas_lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recibidas_lista` (`id` INT, `cod_documento` INT, `fecha` INT, `rif` INT, `nombre` INT, `monto` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `emitidas_lista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `emitidas_lista` (`id` INT, `codigo` INT, `fecha` INT, `rif` INT, `nombre` INT, `monto` INT);
SHOW WARNINGS;

-- -----------------------------------------------------
-- Placeholder table for view `facturas_producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `facturas_producto` (`codFact` INT, `producto` INT, `fecha` INT, `telefono` INT, `correo` INT, `contacto` INT, `nombre` INT, `total` INT, `status` INT, `usuario` INT, `cantidad` INT, `precio` INT);
SHOW WARNINGS;

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
ajusteinv.estatus, 
usuario, 
usuario.nombre as nombre, 
nota 
FROM `ajusteinv`, `usuario` 
WHERE ajusteinv.usuario = usuario.codigo
order by fecha DESC;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `recibidas_lista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `recibidas_lista`;
SHOW WARNINGS;
DROP VIEW IF EXISTS `recibidas_lista` ;
SHOW WARNINGS;

CREATE  OR REPLACE VIEW `recibidas_lista` AS
SELECT 
notas_recividas.id,
compra.cod_documento,
notas_recividas.fecha,
compra.cod_proveedor AS rif,
proveedor.nombre,
notas_recividas.monto
FROM compra,notas_recividas,proveedor 
WHERE	compra.codigo=notas_recividas.cod_compra 
AND compra.cod_proveedor=proveedor.codigo 
order by fecha desc;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `emitidas_lista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emitidas_lista`;
SHOW WARNINGS;
DROP VIEW IF EXISTS `emitidas_lista` ;
SHOW WARNINGS;

CREATE  OR REPLACE VIEW `emitidas_lista` AS
SELECT 
notas_emitidas.id,
factura.codigo,
notas_emitidas.fecha,
factura.cod_cliente AS rif,
cliente.nombre,
notas_emitidas.monto
FROM factura,notas_emitidas,cliente 
WHERE	factura.codigo=notas_emitidas.cod_factura 
AND factura.cod_cliente=cliente.codigo 
order by fecha desc;
SHOW WARNINGS;

-- -----------------------------------------------------
-- View `facturas_producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `facturas_producto`;
SHOW WARNINGS;
DROP VIEW IF EXISTS `facturas_producto` ;
SHOW WARNINGS;

CREATE  OR REPLACE VIEW `facturas_producto` AS
SELECT 
notasalida.codigo as codFact, 
producto,
fecha, 
telefono,
correo, 
contacto,
nombre, 
total, 
notasalida.estatus as status, 
notasalida.usuario, 
detallesNotas.cantidad, 
detallesNotas.precio 
FROM notasalida, detallesNotas, cliente 
WHERE notasalida.cod_cliente = cliente.codigo 
AND detallesNotas.nota = notasalida.codigo;
SHOW WARNINGS;