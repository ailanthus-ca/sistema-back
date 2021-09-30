-- MySQL Script generated by MySQL Workbench
-- Thu Sep 23 14:55:26 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario` (
  `codigo` INT(11) NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `correo` VARCHAR(150) NOT NULL,
  `clave` VARCHAR(400) NOT NULL,
  `nivel` INT(1) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_usuario_roles1_idx` (`nivel` ASC) ,
  CONSTRAINT `fk_usuario_roles1`
    FOREIGN KEY (`nivel`)
    REFERENCES `roles` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ajusteinv`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ajusteinv` (
  `codigo` INT(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `tipo_ajuste` VARCHAR(20) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `nota` VARCHAR(200) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `estatus` TINYINT(4) NOT NULL,
  PRIMARY KEY (`codigo`, `usuario`),
  INDEX `fk_ajusteinv_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `fk_ajusteinv_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `cliente`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `proveedor`
-- -----------------------------------------------------
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


-- -----------------------------------------------------
-- Table `compra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `compra` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_proveedor` VARCHAR(50) NOT NULL,
  `cod_documento` VARCHAR(50) NULL DEFAULT NULL,
  `nun_control` VARCHAR(50) NULL DEFAULT NULL,
  `fecha` DATETIME NOT NULL,
  `fecha_documento` DATE NULL,
  `subtotal` DOUBLE NOT NULL,
  `impuesto` DOUBLE NOT NULL,
  `total` DOUBLE NOT NULL,
  `nota` VARCHAR(600) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  `dolar` DOUBLE NOT NULL DEFAULT 1,
  PRIMARY KEY (`codigo`, `usuario`, `cod_proveedor`),
  INDEX `cod_proveedor` (`cod_proveedor` ASC) ,
  INDEX `fk_compra_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `compra_ibfk_1`
    FOREIGN KEY (`cod_proveedor`)
    REFERENCES `proveedor` (`codigo`),
  CONSTRAINT `fk_compra_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `configuracion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` INT(11) NOT NULL,
  `cod_usuario` INT(11) NOT NULL,
  `descripcion` VARCHAR(100) NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id`, `cod_usuario`),
  INDEX `cod_usuario` (`cod_usuario` ASC) ,
  CONSTRAINT `configuracion_ibfk_1`
    FOREIGN KEY (`cod_usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `cotizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cotizacion` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`codigo`, `usuario`, `cod_cliente`),
  INDEX `cod_cliente` (`cod_cliente` ASC) ,
  INDEX `fk_cotizacion_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `cotizacion_ibfk_1`
    FOREIGN KEY (`cod_cliente`)
    REFERENCES `cliente` (`codigo`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_cotizacion_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `cotizacion_seguimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cotizacion_seguimiento` (
  `id` INT(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `cod_cotizacion` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `descripcion` VARCHAR(300) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id`, `cod_cotizacion`, `usuario`),
  INDEX `cod_cotizacion` (`cod_cotizacion` ASC) ,
  INDEX `usuario` (`usuario` ASC) ,
  CONSTRAINT `cotizacion_seguimiento_ibfk_1`
    FOREIGN KEY (`cod_cotizacion`)
    REFERENCES `cotizacion` (`codigo`)
    ON DELETE CASCADE,
  CONSTRAINT `cotizacion_seguimiento_ibfk_2`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `departamento` (
  `codigo` VARCHAR(4) NOT NULL,
  `descripcion` VARCHAR(150) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `tipo_producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tipo_producto` (
  `codigo` INT(3) NOT NULL,
  `descripcion` VARCHAR(120) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  `inventario` TINYINT(4) NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `unidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `unidad` (
  `codigo` INT(11) NOT NULL,
  `descripcion` VARCHAR(120) NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `producto` (
  `codigo` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `departamento` VARCHAR(4) NOT NULL,
  `descripcion` VARCHAR(300) NOT NULL,
  `tipo` INT(3) NOT NULL,
  `enser` TINYINT(1) NOT NULL,
  `unidad` INT(11) NOT NULL,
  `costo` DOUBLE NOT NULL,
  `precio1` DOUBLE NOT NULL,
  `precio2` DOUBLE NOT NULL,
  `precio3` DOUBLE NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `imagen` VARCHAR(200) CHARACTER SET 'latin1' NOT NULL,
  `estatus` TINYINT(1) NOT NULL,
  `fecha_creacion` DATETIME NOT NULL,
  `exento` TINYINT(4) NULL,
  `dolar` DOUBLE NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_producto_tipo_producto1_idx` (`tipo` ASC) ,
  INDEX `fk_producto_unidad1_idx` (`unidad` ASC) ,
  INDEX `fk_producto_departamento1_idx` (`departamento` ASC) ,
  CONSTRAINT `fk_producto_tipo_producto1`
    FOREIGN KEY (`tipo`)
    REFERENCES `tipo_producto` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_producto_unidad1`
    FOREIGN KEY (`unidad`)
    REFERENCES `unidad` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_producto_departamento1`
    FOREIGN KEY (`departamento`)
    REFERENCES `departamento` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `detalleajusteinv`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detalleajusteinv` (
  `cod_ajuste` INT(11) UNSIGNED ZEROFILL NOT NULL,
  `cod_producto` VARCHAR(20) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `descripcion` VARCHAR(150) NOT NULL,
  `data` TEXT NULL DEFAULT NULL,
  INDEX `cod_producto` (`cod_producto` ASC) ,
  PRIMARY KEY (`cod_ajuste`, `cod_producto`),
  CONSTRAINT `detalleajusteinv_ibfk_1`
    FOREIGN KEY (`cod_ajuste`)
    REFERENCES `ajusteinv` (`codigo`)
    ON DELETE CASCADE,
  CONSTRAINT `detalleajusteinv_ibfk_2`
    FOREIGN KEY (`cod_producto`)
    REFERENCES `producto` (`codigo`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `detallecompra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detallecompra` (
  `cod_compra` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_producto` VARCHAR(50) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `monto` DOUBLE NOT NULL,
  INDEX `cod_producto` (`cod_producto` ASC) ,
  PRIMARY KEY (`cod_compra`, `cod_producto`),
  CONSTRAINT `detallecompra_ibfk_2`
    FOREIGN KEY (`cod_producto`)
    REFERENCES `producto` (`codigo`)
    ON DELETE CASCADE,
  CONSTRAINT `detallecompra_ibfk_3`
    FOREIGN KEY (`cod_compra`)
    REFERENCES `compra` (`codigo`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `detallecotizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detallecotizacion` (
  `codCotizacion` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `codProducto` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `monto` DOUBLE NOT NULL,
  `comentario` VARCHAR(250) CHARACTER SET 'latin1' NOT NULL,
  UNIQUE INDEX `codFactura` (`codCotizacion` ASC, `codProducto` ASC) ,
  INDEX `codProducto` (`codProducto` ASC) ,
  PRIMARY KEY (`codCotizacion`, `codProducto`),
  CONSTRAINT `detallecotizacion_ibfk_1`
    FOREIGN KEY (`codCotizacion`)
    REFERENCES `cotizacion` (`codigo`)
    ON DELETE CASCADE,
  CONSTRAINT `detallecotizacion_ibfk_2`
    FOREIGN KEY (`codProducto`)
    REFERENCES `producto` (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `factura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `factura` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`codigo`, `cod_cliente`, `usuario`),
  INDEX `cod_cliente` (`cod_cliente` ASC) ,
  INDEX `fk_factura_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `fk_factura_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_factura_cliente1`
    FOREIGN KEY (`cod_cliente`)
    REFERENCES `cliente` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `detallefactura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detallefactura` (
  `codFactura` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `codProducto` VARCHAR(20) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `monto` DOUBLE NOT NULL,
  UNIQUE INDEX `codFactura` (`codFactura` ASC, `codProducto` ASC) ,
  INDEX `codProducto` (`codProducto` ASC) ,
  PRIMARY KEY (`codFactura`, `codProducto`),
  CONSTRAINT `detallefactura_ibfk_2`
    FOREIGN KEY (`codProducto`)
    REFERENCES `producto` (`codigo`),
  CONSTRAINT `fk_detallefactura_factura1`
    FOREIGN KEY (`codFactura`)
    REFERENCES `factura` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `ordencompra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ordencompra` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`codigo`, `cod_proveedor`, `usuario`),
  INDEX `fk_ordencompra_proveedor1_idx` (`cod_proveedor` ASC) ,
  INDEX `fk_ordencompra_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `fk_ordencompra_proveedor1`
    FOREIGN KEY (`cod_proveedor`)
    REFERENCES `proveedor` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ordencompra_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `detalleordencompra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detalleordencompra` (
  `cod_orden` INT(6) UNSIGNED ZEROFILL NOT NULL,
  `cod_producto` VARCHAR(20) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `monto` DOUBLE NOT NULL,
  INDEX `cod_producto` (`cod_producto` ASC) ,
  PRIMARY KEY (`cod_orden`, `cod_producto`),
  CONSTRAINT `detalleordencompra_ibfk_2`
    FOREIGN KEY (`cod_producto`)
    REFERENCES `producto` (`codigo`)
    ON DELETE CASCADE,
  CONSTRAINT `detalleordencompra_ibfk_3`
    FOREIGN KEY (`cod_orden`)
    REFERENCES `ordencompra` (`codigo`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `notasalida`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `notasalida` (
  `codigo` INT(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `cod_cliente` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `fecha` DATETIME NOT NULL,
  `total` DOUBLE NOT NULL,
  `nota` VARCHAR(600) NOT NULL,
  `estatus` INT(11) NOT NULL,
  `usuario` INT(11) NOT NULL,
  PRIMARY KEY (`codigo`, `usuario`, `cod_cliente`),
  INDEX `fk_notasalida_cliente1_idx` (`cod_cliente` ASC) ,
  CONSTRAINT `fk_notasalida_cliente1`
    FOREIGN KEY (`cod_cliente`)
    REFERENCES `cliente` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_notasalida_usuario2`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `detallesNotas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detallesNotas` (
  `nota` INT(10) UNSIGNED ZEROFILL NOT NULL ,
  `producto` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `precio` DOUBLE NOT NULL,
  INDEX `fk_detallesNotas_producto1_idx` (`producto` ASC) ,
  PRIMARY KEY (`nota`, `producto`),
  CONSTRAINT `fk_detallesNotas_producto1`
    FOREIGN KEY (`producto`)
    REFERENCES `producto` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_detallesNotas_notasalida1`
    FOREIGN KEY (`nota`)
    REFERENCES `notasalida` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dolares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dolares` (
  `id` INT(11) NOT NULL,
  `valor` FLOAT NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `equilibrio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `equilibrio` (
  `codigo` INT(11) NOT NULL,
  `ano` INT(11) NOT NULL,
  `mes` INT(11) NOT NULL,
  `monto` DOUBLE NOT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mejor_mes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mejor_mes` (
  `id` INT(11) NOT NULL,
  `ventas` DOUBLE NOT NULL,
  `mes` INT(3) NOT NULL,
  `año` INT(4) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `moneda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `moneda` (
  `id` INT(11) NOT NULL,
  `nombre` VARCHAR(80) NULL DEFAULT NULL,
  `descripcion` VARCHAR(5) NOT NULL,
  `estatus` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `orden_seguimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `orden_seguimiento` (
  `id` INT(11) ZEROFILL UNSIGNED NOT NULL AUTO_INCREMENT,
  `cod_orden` INT(11) ZEROFILL UNSIGNED NOT NULL,
  `descripcion` VARCHAR(300) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id`, `usuario`, `cod_orden`),
  INDEX `fk_orden_seguimiento_ordencompra1_idx` (`cod_orden` ASC) ,
  INDEX `fk_orden_seguimiento_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `fk_orden_seguimiento_ordencompra1`
    FOREIGN KEY (`cod_orden`)
    REFERENCES `ordencompra` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_orden_seguimiento_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `permisos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `permisos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `permisos_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `permisos_roles` (
  `id_permiso` INT(11) NOT NULL,
  `id_role` INT(11) NOT NULL,
  INDEX `fk_permisos_roles_roles1_idx` (`id_role` ASC) ,
  CONSTRAINT `fk_permisos_roles_permisos1`
    FOREIGN KEY (`id_permiso`)
    REFERENCES `permisos` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_permisos_roles_roles1`
    FOREIGN KEY (`id_role`)
    REFERENCES `roles` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `resetclave`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `resetclave` (
  `id_usuario` INT(11) NOT NULL,
  `nombre` VARCHAR(150) NOT NULL,
  `token` VARCHAR(250) NOT NULL,
  `creado` DATETIME NOT NULL,
  CONSTRAINT `fk_resetclave_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `tmp_cotizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tmp_cotizacion` (
  `codigo` INT(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `cod_cliente` VARCHAR(20) NULL,
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
  PRIMARY KEY (`codigo`, `usuario`),
  INDEX `cod_cliente` (`cod_cliente` ASC) ,
  INDEX `fk_tmp_cotizacion_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `fk_tmp_cotizacion_cliente1`
    FOREIGN KEY (`cod_cliente`)
    REFERENCES `cliente` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tmp_cotizacion_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `tmp_detalle_cotizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tmp_detalle_cotizacion` (
  `codCotizacion` INT(6) ZEROFILL UNSIGNED NOT NULL,
  `codProducto` VARCHAR(8) CHARACTER SET 'latin1' NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `precio_unit` DOUBLE NOT NULL,
  `monto` DOUBLE NOT NULL,
  `comentario` VARCHAR(250) CHARACTER SET 'latin1' NOT NULL,
  UNIQUE INDEX `codFactura` (`codCotizacion` ASC, `codProducto` ASC) ,
  INDEX `codProducto` (`codProducto` ASC) ,
  PRIMARY KEY (`codCotizacion`, `codProducto`),
  CONSTRAINT `fk_tmp_detalle_cotizacion_producto1`
    FOREIGN KEY (`codProducto`)
    REFERENCES `producto` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tmp_detalle_cotizacion_tmp_cotizacion1`
    FOREIGN KEY (`codCotizacion`)
    REFERENCES `tmp_cotizacion` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `CreditosEmitidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CreditosEmitidos` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `cod_factura` INT UNSIGNED ZEROFILL NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT now(),
  `descripcion` TEXT NOT NULL,
  `monto` DOUBLE NOT NULL,
  `estado` TINYINT NOT NULL,
  `usuario` INT NOT NULL,
  PRIMARY KEY (`codigo`, `cod_factura`, `usuario`),
  INDEX `fk_CreditosEmitidos_factura1_idx` (`cod_factura` ASC) ,
  INDEX `fk_CreditosEmitidos_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `fk_CreditosEmitidos_factura1`
    FOREIGN KEY (`cod_factura`)
    REFERENCES `factura` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_CreditosEmitidos_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DebitosEmitidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DebitosEmitidos` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `cod_factura` INT ZEROFILL UNSIGNED NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT now(),
  `descripcion` TEXT NOT NULL,
  `monto` DOUBLE NOT NULL,
  `estado` TINYINT NOT NULL,
  `usuario` INT NOT NULL,
  PRIMARY KEY (`codigo`, `cod_factura`, `usuario`),
  INDEX `fk_DevitosEmitidos_factura1_idx` (`cod_factura` ASC) ,
  INDEX `fk_DebitosEmitidos_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `fk_DevitosEmitidos_factura1`
    FOREIGN KEY (`cod_factura`)
    REFERENCES `factura` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_DebitosEmitidos_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `detallesCreditosEmitidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detallesCreditosEmitidos` (
  `nota` INT NOT NULL,
  `producto` VARCHAR(20) CHARACTER SET 'latin1' NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `precio` FLOAT NOT NULL,
  PRIMARY KEY (`nota`, `producto`),
  INDEX `fk_detallesCreditosEmitidos_producto1_idx` (`producto` ASC) ,
  CONSTRAINT `fk_detallesCreditosEmitidos_CreditosEmitidos1`
    FOREIGN KEY (`nota`)
    REFERENCES `CreditosEmitidos` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_detallesCreditosEmitidos_producto1`
    FOREIGN KEY (`producto`)
    REFERENCES `producto` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `CreditosRecibidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CreditosRecibidos` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `cod_compra` INT ZEROFILL UNSIGNED NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT now(),
  `descripcion` TEXT NOT NULL,
  `monto` DOUBLE NOT NULL,
  `estado` TINYINT NOT NULL,
  `usuario` INT NOT NULL,
  PRIMARY KEY (`codigo`, `cod_compra`, `usuario`),
  INDEX `fk_CreditosRecibidos_compra1_idx` (`cod_compra` ASC) ,
  INDEX `fk_CreditosRecibidos_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `fk_CreditosRecibidos_compra1`
    FOREIGN KEY (`cod_compra`)
    REFERENCES `compra` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_CreditosRecibidos_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DebitosRecibidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `DebitosRecibidos` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `cod_compra` INT ZEROFILL UNSIGNED NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT now(),
  `descripcion` TEXT NOT NULL,
  `monto` DOUBLE NOT NULL,
  `estado` TINYINT NOT NULL,
  `usuario` INT NOT NULL,
  PRIMARY KEY (`codigo`, `cod_compra`, `usuario`),
  INDEX `fk_DebitosRecibidos_compra1_idx` (`cod_compra` ASC) ,
  INDEX `fk_DebitosRecibidos_usuario1_idx` (`usuario` ASC) ,
  CONSTRAINT `fk_DebitosRecibidos_compra1`
    FOREIGN KEY (`cod_compra`)
    REFERENCES `compra` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_DebitosRecibidos_usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `detallesDebitosEmitidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detallesDebitosEmitidos` (
  `nota` INT NOT NULL,
  `producto` VARCHAR(20)  CHARACTER SET 'latin1' NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `precio` FLOAT NOT NULL,
  PRIMARY KEY (`nota`, `producto`),
  INDEX `fk_detallesDebitosEmitidos_producto1_idx` (`producto` ASC) ,
  CONSTRAINT `fk_detallesDebitosEmitidos_DebitosEmitidos1`
    FOREIGN KEY (`nota`)
    REFERENCES `DebitosEmitidos` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_detallesDebitosEmitidos_producto1`
    FOREIGN KEY (`producto`)
    REFERENCES `producto` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `detallesCreditosRecibidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detallesCreditosRecibidos` (
  `nota` INT NOT NULL,
  `producto` VARCHAR(20)  CHARACTER SET 'latin1' NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `precio` FLOAT NOT NULL,
  PRIMARY KEY (`nota`, `producto`),
  INDEX `fk_detallesCreditosRecibidos_producto1_idx` (`producto` ASC) ,
  CONSTRAINT `fk_detallesCreditosRecibidos_CreditosRecibidos1`
    FOREIGN KEY (`nota`)
    REFERENCES `CreditosRecibidos` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_detallesCreditosRecibidos_producto1`
    FOREIGN KEY (`producto`)
    REFERENCES `producto` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `detallesDebitosRecibidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `detallesDebitosRecibidos` (
  `nota` INT NOT NULL,
  `producto` VARCHAR(20)  CHARACTER SET 'latin1' NOT NULL,
  `cantidad` FLOAT NOT NULL,
  `precio` FLOAT NOT NULL,
  PRIMARY KEY (`nota`, `producto`),
  INDEX `fk_detallesDebitosRecibidos_producto1_idx` (`producto` ASC) ,
  CONSTRAINT `fk_detallesDebitosRecibidos_producto1`
    FOREIGN KEY (`producto`)
    REFERENCES `producto` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_detallesDebitosRecibidos_DebitosRecibidos1`
    FOREIGN KEY (`nota`)
    REFERENCES `DebitosRecibidos` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
