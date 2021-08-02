-- NOTA: Se recomienda trabajar en la base de datos mecica_ailanthus_sistema, ya que tiene las actualizaciones mas recientes

ALTER TABLE `ajusteinv` CHANGE `nota` `nota` VARCHAR(600) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `compra` CHANGE `subtotal` `subtotal` DOUBLE NOT NULL, CHANGE `impuesto` `impuesto` DOUBLE NOT NULL, CHANGE `total` `total` DOUBLE NOT NULL;
ALTER TABLE `cotizacion` CHANGE `iva` `iva` DOUBLE NOT NULL, CHANGE `subtotal` `subtotal` DOUBLE NOT NULL, CHANGE `total` `total` DOUBLE NOT NULL, CHANGE `nota` `nota` VARCHAR(600) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `detalleajusteinv` CHANGE `descripcion` `descripcion` VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `detallecompra` CHANGE `precio_unit` `precio_unit` DOUBLE NOT NULL, CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `detallecotizacion` CHANGE `precio_unit` `precio_unit` DOUBLE NOT NULL, CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `detallefactura` CHANGE `precio_unit` `precio_unit` DOUBLE NOT NULL, CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `detalleordencompra` CHANGE `precio_unit` `precio_unit` DOUBLE NOT NULL, CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `equilibrio` CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `factura` CHANGE `observacion` `observacion` VARCHAR(600) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `ordencompra` CHANGE `subtotal` `subtotal` DOUBLE NOT NULL, CHANGE `impuesto` `impuesto` DOUBLE NOT NULL, CHANGE `total` `total` DOUBLE NOT NULL, CHANGE `nota` `nota` VARCHAR(600) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `tmp_comp_prod` CHANGE `precio_tmp` `precio_tmp` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `tmp_cotizacion` CHANGE `iva` `iva` DOUBLE NOT NULL, CHANGE `subtotal` `subtotal` DOUBLE NOT NULL, CHANGE `total` `total` DOUBLE NOT NULL;
ALTER TABLE `tmp_cot_prod` CHANGE `precio_tmp` `precio_tmp` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `tmp_detalle_cotizacion` CHANGE `precio_unit` `precio_unit` DOUBLE NOT NULL, CHANGE `monto` `monto` DOUBLE NOT NULL;
ALTER TABLE `tmp_fact_prod` CHANGE `precio_tmp` `precio_tmp` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `tmp_ord_prod` CHANGE `precio_tmp` `precio_tmp` DOUBLE NULL DEFAULT NULL;