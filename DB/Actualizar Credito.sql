
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

