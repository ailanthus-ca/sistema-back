
-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `roles` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT(11) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuario` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `usuario` (
  `codigo` INT(11) NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `correo` VARCHAR(150) NOT NULL,
  `clave` VARCHAR(400) NOT NULL,
  `nivel` INT(1) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `cliente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cliente` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `cliente` (
  `codigo` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `nombre` VARCHAR(75) NOT NULL,
  `correo` VARCHAR(50) CHARACTER SET 'latin1' NOT NULL,
  `direccion` VARCHAR(150) NULL DEFAULT NULL,
  `contacto` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(120) CHARACTER SET 'latin1' NULL DEFAULT NULL,
  `tipo_contribuyente` VARCHAR(50) CHARACTER SET 'latin1' NOT NULL,
  `retencion` DOUBLE NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `factura`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `factura` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `factura` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_cliente` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `fecha` DATETIME NOT NULL,
  `condicion` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `porc_impuesto` DOUBLE NOT NULL,
  `costo` DOUBLE NOT NULL,
  `iva` DOUBLE NOT NULL,
  `subtotal` DOUBLE NOT NULL,
  `total` DOUBLE NOT NULL,
  `observacion` VARCHAR(300) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
-- CREATE INDEX `cod_cliente` ON `factura` (`cod_cliente` ASC) VISIBLE;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `notas_emitidas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `notas_emitidas` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `notas_emitidas` (
  `id` INT NOT NULL,
  `cod_factura` INT NOT NULL,
  `descripcion` TEXT NOT NULL,
  `tipo` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`id`, `cod_factura`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `proveedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `proveedor` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `proveedor` (
  `codigo` VARCHAR(50) NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `correo` VARCHAR(150) NOT NULL,
  `direccion` VARCHAR(300) NULL DEFAULT NULL,
  `contacto` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(120) NULL DEFAULT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `compra`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `compra` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `compra` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_proveedor` VARCHAR(50) NOT NULL,
  `cod_documento` VARCHAR(50) NULL DEFAULT NULL,
  `nun_control` VARCHAR(50) NULL DEFAULT NULL,
  `fecha` DATETIME NOT NULL,
  `fecha_documento` DATE NULL DEFAULT NULL,
  `subtotal` DOUBLE NOT NULL,
  `impuesto` DOUBLE NOT NULL,
  `total` DOUBLE NOT NULL,
  `nota` VARCHAR(600) NULL DEFAULT NULL,
  `usuario` INT(11) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  `dolar` DOUBLE NULL DEFAULT 1,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `notas_recividas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `notas_recividas` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `notas_recividas` (
  `id` INT NOT NULL,
  `cod_compra` INT NOT NULL,
  `descripcion` TEXT NOT NULL,
  `tipo` VARCHAR(7) NOT NULL,
  PRIMARY KEY (`id`, `cod_compra`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ajusteinv`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ajusteinv` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `ajusteinv` (
  `codigo` INT(11) NOT NULL,
  `tipo_ajuste` VARCHAR(20) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `nota` VARCHAR(200) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `estatus` TINYINT(4) NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `cliente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cliente` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `cliente` (
  `codigo` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `nombre` VARCHAR(75) NOT NULL,
  `correo` VARCHAR(50) CHARACTER SET 'latin1' NOT NULL,
  `direccion` VARCHAR(150) NULL DEFAULT NULL,
  `contacto` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(120) CHARACTER SET 'latin1' NULL DEFAULT NULL,
  `tipo_contribuyente` VARCHAR(50) CHARACTER SET 'latin1' NOT NULL,
  `retencion` DOUBLE NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `proveedor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `proveedor` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `proveedor` (
  `codigo` VARCHAR(50) NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `correo` VARCHAR(150) NOT NULL,
  `direccion` VARCHAR(300) NULL DEFAULT NULL,
  `contacto` VARCHAR(50) NOT NULL,
  `telefono` VARCHAR(120) NULL DEFAULT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `compra`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `compra` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `compra` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_proveedor` VARCHAR(50) NOT NULL,
  `cod_documento` VARCHAR(50) NULL DEFAULT NULL,
  `nun_control` VARCHAR(50) NULL DEFAULT NULL,
  `fecha` DATETIME NOT NULL,
  `fecha_documento` DATE NULL DEFAULT NULL,
  `subtotal` DOUBLE NOT NULL,
  `impuesto` DOUBLE NOT NULL,
  `total` DOUBLE NOT NULL,
  `nota` VARCHAR(600) NULL DEFAULT NULL,
  `usuario` INT(11) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  `dolar` DOUBLE NULL DEFAULT 1,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuario` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `usuario` (
  `codigo` INT(11) NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `correo` VARCHAR(150) NOT NULL,
  `clave` VARCHAR(400) NOT NULL,
  `nivel` INT(1) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `configuracion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `configuracion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` INT(11) NOT NULL,
  `cod_usuario` INT(11) NOT NULL,
  `descripcion` VARCHAR(100) NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id`, `cod_usuario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `cotizacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cotizacion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `cotizacion` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_cliente` VARCHAR(20) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `iva` DOUBLE NOT NULL,
  `subtotal` DOUBLE NOT NULL,
  `total` DOUBLE NOT NULL,
  `forma_pago` VARCHAR(120) NOT NULL,
  `tiempo_entrega` VARCHAR(120) NOT NULL,
  `validez` VARCHAR(120) NOT NULL,
  `nota` VARCHAR(250) NOT NULL,
  `tasa` FLOAT NULL DEFAULT NULL,
  `estatus` TINYINT(1) NOT NULL,
  `usuario` INT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `cotizacion_seguimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cotizacion_seguimiento` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `cotizacion_seguimiento` (
  `id` INT(11) NOT NULL,
  `cod_cotizacion` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` VARCHAR(300) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `departamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `departamento` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `departamento` (
  `codigo` VARCHAR(4) NOT NULL,
  `descripcion` VARCHAR(150) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producto` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `producto` (
  `codigo` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `departamento` VARCHAR(4) NOT NULL,
  `descripcion` VARCHAR(300) NOT NULL,
  `tipo` VARCHAR(2) CHARACTER SET 'latin1' NOT NULL,
  `enser` TINYINT(1) NOT NULL,
  `unidad` VARCHAR(2) CHARACTER SET 'latin1' NOT NULL,
  `costo` DOUBLE NOT NULL,
  `precio1` DOUBLE NOT NULL,
  `precio2` DOUBLE NOT NULL,
  `precio3` DOUBLE NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `imagen` VARCHAR(200) CHARACTER SET 'latin1' NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  `fecha_creacion` DATETIME NOT NULL,
  `exento` TINYINT(4) NULL DEFAULT NULL,
  `dolar` DOUBLE NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `detalleajusteinv`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detalleajusteinv` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `detalleajusteinv` (
  `cod_ajuste` INT(11) NOT NULL,
  `cod_producto` VARCHAR(20) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `descripcion` VARCHAR(150) NOT NULL,
  `data` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`cod_ajuste`, `cod_producto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `detallecompra`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detallecompra` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `detallecompra` (
  `cod_compra` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_producto` VARCHAR(50) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `monto` DOUBLE NOT NULL,
  PRIMARY KEY (`cod_compra`, `cod_producto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `detallecotizacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detallecotizacion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `detallecotizacion` (
  `codCotizacion` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `codProducto` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `monto` DOUBLE NOT NULL,
  `comentario` VARCHAR(250) CHARACTER SET 'latin1' NOT NULL,
  PRIMARY KEY (`codCotizacion`, `codProducto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
-- CREATE UNIQUE INDEX `codFactura` ON `detallecotizacion` (`codCotizacion` ASC, `codProducto` ASC) VISIBLE;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `detallefactura`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detallefactura` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `detallefactura` (
  `codFactura` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `codProducto` VARCHAR(20) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `monto` DOUBLE NOT NULL,
  PRIMARY KEY (`codFactura`, `codProducto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;
-- CREATE UNIQUE INDEX `codFactura` ON `detallefactura` (`codFactura` ASC, `codProducto` ASC) VISIBLE;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ordencompra`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ordencompra` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `ordencompra` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_proveedor` VARCHAR(50) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `subtotal` DOUBLE NOT NULL,
  `impuesto` DOUBLE NOT NULL,
  `total` DOUBLE NOT NULL,
  `forma_pago` VARCHAR(120) NOT NULL,
  `tiempo_entrega` VARCHAR(120) NOT NULL,
  `validez` VARCHAR(120) NOT NULL,
  `nota` VARCHAR(250) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `detalleordencompra`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detalleordencompra` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `detalleordencompra` (
  `cod_orden` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_producto` VARCHAR(20) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `monto` DOUBLE NOT NULL,
  PRIMARY KEY (`cod_orden`, `cod_producto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `detallesEntrada`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detallesEntrada` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `detallesEntrada` (
  `nota` INT(10) NOT NULL,
  `producto` VARCHAR(20) NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `precio` DOUBLE NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `detallesNotas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detallesNotas` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `detallesNotas` (
  `nota` INT(10) NOT NULL,
  `producto` VARCHAR(20) NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `precio` DOUBLE NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `dolares`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dolares` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `dolares` (
  `id` INT(11) NOT NULL,
  `valor` FLOAT NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `equilibrio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `equilibrio` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `equilibrio` (
  `codigo` INT(11) NOT NULL,
  `ano` INT(11) NOT NULL,
  `mes` INT(11) NOT NULL,
  `monto` DOUBLE NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `factura`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `factura` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `factura` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_cliente` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `fecha` DATETIME NOT NULL,
  `condicion` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `porc_impuesto` DOUBLE NOT NULL,
  `costo` DOUBLE NOT NULL,
  `iva` DOUBLE NOT NULL,
  `subtotal` DOUBLE NOT NULL,
  `total` DOUBLE NOT NULL,
  `observacion` VARCHAR(300) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
-- CREATE INDEX `cod_cliente` ON `factura` (`cod_cliente` ASC) VISIBLE;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `mejor_mes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mejor_mes` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `mejor_mes` (
  `id` INT(11) NOT NULL,
  `ventas` DOUBLE NOT NULL,
  `mes` INT(3) NOT NULL,
  `año` INT(4) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `moneda`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moneda` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `moneda` (
  `id` INT(11) NOT NULL,
  `nombre` VARCHAR(80) NULL DEFAULT NULL,
  `descripcion` VARCHAR(5) NOT NULL,
  `estatus` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `notaentrada`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `notaentrada` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `notaentrada` (
  `codigo` INT(10) UNSIGNED ZEROFILL NOT NULL,
  `cod_proveedor` VARCHAR(20) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `total` DOUBLE NOT NULL,
  `nota` VARCHAR(600) NOT NULL,
  `estatus` INT(11) NOT NULL,
  `usuario` INT(11) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `notasalida`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `notasalida` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `notasalida` (
  `codigo` INT(10) UNSIGNED ZEROFILL NOT NULL,
  `cod_cliente` VARCHAR(20) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `total` DOUBLE NOT NULL,
  `nota` VARCHAR(600) NOT NULL,
  `estatus` INT(11) NOT NULL,
  `usuario` INT(11) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `orden_seguimiento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orden_seguimiento` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `orden_seguimiento` (
  `id` INT(11) NOT NULL,
  `cod_orden` INT(11) NOT NULL,
  `descripcion` VARCHAR(300) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `permisos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `permisos` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `permisos` (
  `id` INT(11) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `permisos_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `permisos_roles` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `permisos_roles` (
  `id_permiso` INT(11) NOT NULL,
  `id_role` INT(11) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `resetclave`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `resetclave` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `resetclave` (
  `id_usuario` INT(11) NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `token` VARCHAR(250) NOT NULL,
  `creado` DATETIME NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `roles` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT(11) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `tempnotas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tempnotas` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `tempnotas` (
  `productor` VARCHAR(20) NOT NULL,
  `catidad` FLOAT NOT NULL,
  `precio` INT(11) NOT NULL,
  `usuario` INT(11) NOT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `tipo_producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tipo_producto` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `tipo_producto` (
  `codigo` INT(3) NOT NULL,
  `descripcion` VARCHAR(120) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  `inventario` TINYINT(4) NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `tmp_cotizacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tmp_cotizacion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `tmp_cotizacion` (
  `codigo` INT(6) NOT NULL,
  `cod_cliente` VARCHAR(20) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `iva` DOUBLE NOT NULL,
  `subtotal` DOUBLE NOT NULL,
  `total` DOUBLE NOT NULL,
  `forma_pago` VARCHAR(50) NOT NULL,
  `tiempo_entrega` VARCHAR(50) NOT NULL,
  `validez` VARCHAR(50) NOT NULL,
  `nota` VARCHAR(250) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  `usuario` INT(11) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

SHOW WARNINGS;
-- CREATE INDEX `cod_cliente` ON `tmp_cotizacion` (`cod_cliente` ASC) VISIBLE;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `tmp_detalle_cotizacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tmp_detalle_cotizacion` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `tmp_detalle_cotizacion` (
  `codCotizacion` INT(6) NOT NULL,
  `codProducto` VARCHAR(8) CHARACTER SET 'latin1' NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `monto` DOUBLE NOT NULL,
  `comentario` VARCHAR(250) CHARACTER SET 'latin1' NOT NULL,
  PRIMARY KEY (`codCotizacion`, `codProducto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;
-- CREATE UNIQUE INDEX `codFactura` ON `tmp_detalle_cotizacion` (`codCotizacion` ASC, `codProducto` ASC) VISIBLE;

SHOW WARNINGS;
-- CREATE INDEX `codProducto` ON `tmp_detalle_cotizacion` (`codProducto` ASC) VISIBLE;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `unidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `unidad` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `unidad` (
  `codigo` INT(11) NOT NULL,
  `descripcion` VARCHAR(120) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
