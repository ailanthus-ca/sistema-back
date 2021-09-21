
CREATE TABLE IF NOT EXISTS `mydb`.`notas_emitidas` (
  `id` INT NOT NULL,
  `cod_factura` INT NOT NULL,
  `descripcion` TEXT NULL,
  PRIMARY KEY (`id`, `cod_factura`),
  INDEX `fk_notas_emitidas_factura1_idx` (`cod_factura` ASC) VISIBLE,
  CONSTRAINT `fk_notas_emitidas_factura1`
    FOREIGN KEY (`cod_factura`)
    REFERENCES `mydb`.`factura` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `mydb`.`notas_recividas` (
  `id` INT NOT NULL,
  `cod_compra` INT NOT NULL,
  `descripcion` TEXT NOT NULL,
  PRIMARY KEY (`id`, `cod_compra`),
  INDEX `fk_notas_recividas_compra1_idx` (`cod_compra` ASC) VISIBLE,
  CONSTRAINT `fk_notas_recividas_compra1`
    FOREIGN KEY (`cod_compra`)
    REFERENCES `mydb`.`compra` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;