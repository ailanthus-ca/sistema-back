-- NOTA: Se recomienda trabajar en la base de datos mecica_ailanthus_sistema, ya que tiene las actualizaciones mas recientes

ALTER TABLE `ajusteinv` CHANGE `fecha` `fecha` DATETIME NOT NULL;
ALTER TABLE `ajusteinv` ADD `estatus` TINYINT NULL AFTER `usuario`;
ALTER TABLE `ajusteinv` CHANGE `nota` `nota` VARCHAR(600) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `cliente` CHANGE `retencion` `retencion` DOUBLE NOT NULL;
ALTER TABLE `compra` CHANGE `fecha` `fecha` DATETIME NOT NULL, CHANGE `subtotal` `subtotal` DOUBLE NOT NULL, CHANGE `impuesto` `impuesto` DOUBLE NOT NULL, CHANGE `total` `total` DOUBLE NOT NULL;
ALTER TABLE `compra` ADD `dolar` DOUBLE NULL AFTER `estatus`;
ALTER TABLE `cotizacion` CHANGE `fecha` `fecha` DATETIME NOT NULL, CHANGE `iva` `iva` DOUBLE NOT NULL, CHANGE `subtotal` `subtotal` DOUBLE NOT NULL, CHANGE `total` `total` DOUBLE NOT NULL, CHANGE `nota` `nota` VARCHAR(600) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `detalleajusteinv` CHANGE `descripcion` `descripcion` VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `detalleajusteinv` ADD `data` TEXT NULL AFTER `descripcion`;
ALTER TABLE `detallecompra` CHANGE `precio_unit` `precio_unit` DOUBLE NOT NULL, CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `detallecotizacion` CHANGE `precio_unit` `precio_unit` DOUBLE NOT NULL, CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `detallefactura` CHANGE `precio_unit` `precio_unit` DOUBLE NOT NULL, CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `detalleordencompra` CHANGE `precio_unit` `precio_unit` DOUBLE NOT NULL, CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `equilibrio` CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `factura` CHANGE `fecha` `fecha` DATETIME NOT NULL, CHANGE `porc_impuesto` `porc_impuesto` DOUBLE NOT NULL, CHANGE `costo` `costo` DOUBLE NOT NULL, CHANGE `iva` `iva` DOUBLE NOT NULL, CHANGE `subtotal` `subtotal` DOUBLE NOT NULL, CHANGE `total` `total` DOUBLE NOT NULL, CHANGE `observacion` `observacion` VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `moneda` ADD `nombre` VARCHAR(80) NULL AFTER `id`;
ALTER TABLE `notasalida` CHANGE `fecha` `fecha` DATETIME NOT NULL;
ALTER TABLE `ordencompra` CHANGE `fecha` `fecha` DATETIME NOT NULL, CHANGE `subtotal` `subtotal` DOUBLE NOT NULL, CHANGE `impuesto` `impuesto` DOUBLE NOT NULL, CHANGE `total` `total` DOUBLE NOT NULL, CHANGE `nota` `nota` VARCHAR(600) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `orden_seguimiento` CHANGE `descripcion` `descripcion` VARCHAR(300) NOT NULL, CHANGE `fecha` `fecha` DATETIME NOT NULL;
ALTER TABLE `producto` ADD `exento` TINYINT NULL AFTER `fecha_creacion`, ADD `dolar` DOUBLE NULL AFTER `exento`;
ALTER TABLE `tipo_producto` ADD `inventario` TINYINT NULL AFTER `estatus`;
ALTER TABLE `tmp_comp_prod` CHANGE `precio_tmp` `precio_tmp` DOUBLE NULL DEFAULT NULL;
UPDATE `ajusteinv` SET `estatus`= 1 WHERE 1
ALTER TABLE `orden_seguimiento` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `tmp_cotizacion` CHANGE `codigo` `codigo` INT(6) NOT NULL AUTO_INCREMENT;