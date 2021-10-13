
--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajusteinv`
--
ALTER TABLE `ajusteinv`
  ADD PRIMARY KEY (`codigo`,`usuario`),
  ADD KEY `fk_ajusteinv_usuario1_idx` (`usuario`);

--
-- Indexes for table `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`codigo`,`usuario`,`cod_proveedor`),
  ADD KEY `cod_proveedor` (`cod_proveedor`),
  ADD KEY `fk_compra_usuario1_idx` (`usuario`);

--
-- Indexes for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`,`cod_usuario`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indexes for table `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`codigo`,`usuario`,`cod_cliente`),
  ADD KEY `cod_cliente` (`cod_cliente`),
  ADD KEY `fk_cotizacion_usuario1_idx` (`usuario`);

--
-- Indexes for table `cotizacion_seguimiento`
--
ALTER TABLE `cotizacion_seguimiento`
  ADD PRIMARY KEY (`id`,`cod_cotizacion`,`usuario`),
  ADD KEY `cod_cotizacion` (`cod_cotizacion`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `creditosemitidos`
--
ALTER TABLE `creditosemitidos`
  ADD PRIMARY KEY (`codigo`,`cod_factura`,`usuario`),
  ADD KEY `fk_CreditosEmitidos_factura1_idx` (`cod_factura`),
  ADD KEY `fk_CreditosEmitidos_usuario1_idx` (`usuario`);

--
-- Indexes for table `creditosrecibidos`
--
ALTER TABLE `creditosrecibidos`
  ADD PRIMARY KEY (`codigo`,`cod_compra`,`usuario`),
  ADD KEY `fk_CreditosRecibidos_compra1_idx` (`cod_compra`),
  ADD KEY `fk_CreditosRecibidos_usuario1_idx` (`usuario`);

--
-- Indexes for table `debitosemitidos`
--
ALTER TABLE `debitosemitidos`
  ADD PRIMARY KEY (`codigo`,`cod_factura`,`usuario`),
  ADD KEY `fk_DevitosEmitidos_factura1_idx` (`cod_factura`),
  ADD KEY `fk_DebitosEmitidos_usuario1_idx` (`usuario`);

--
-- Indexes for table `debitosrecibidos`
--
ALTER TABLE `debitosrecibidos`
  ADD PRIMARY KEY (`codigo`,`cod_compra`,`usuario`),
  ADD KEY `fk_DebitosRecibidos_compra1_idx` (`cod_compra`),
  ADD KEY `fk_DebitosRecibidos_usuario1_idx` (`usuario`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `detalleajusteinv`
--
ALTER TABLE `detalleajusteinv`
  ADD PRIMARY KEY (`cod_ajuste`,`cod_producto`),
  ADD KEY `cod_producto` (`cod_producto`);

--
-- Indexes for table `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD PRIMARY KEY (`cod_compra`,`cod_producto`),
  ADD KEY `cod_producto` (`cod_producto`);

--
-- Indexes for table `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD PRIMARY KEY (`codCotizacion`,`codProducto`),
  ADD UNIQUE KEY `codFactura` (`codCotizacion`,`codProducto`),
  ADD KEY `codProducto` (`codProducto`);

--
-- Indexes for table `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`codFactura`,`codProducto`),
  ADD UNIQUE KEY `codFactura` (`codFactura`,`codProducto`),
  ADD KEY `codProducto` (`codProducto`);

--
-- Indexes for table `detalleordencompra`
--
ALTER TABLE `detalleordencompra`
  ADD PRIMARY KEY (`cod_orden`,`cod_producto`),
  ADD KEY `cod_producto` (`cod_producto`);

--
-- Indexes for table `detallescreditosemitidos`
--
ALTER TABLE `detallescreditosemitidos`
  ADD PRIMARY KEY (`nota`,`producto`),
  ADD KEY `fk_detallesCreditosEmitidos_producto1_idx` (`producto`);

--
-- Indexes for table `detallescreditosrecibidos`
--
ALTER TABLE `detallescreditosrecibidos`
  ADD PRIMARY KEY (`nota`,`producto`),
  ADD KEY `fk_detallesCreditosRecibidos_producto1_idx` (`producto`);

--
-- Indexes for table `detallesdebitosemitidos`
--
ALTER TABLE `detallesdebitosemitidos`
  ADD PRIMARY KEY (`nota`,`producto`),
  ADD KEY `fk_detallesDebitosEmitidos_producto1_idx` (`producto`);

--
-- Indexes for table `detallesdebitosrecibidos`
--
ALTER TABLE `detallesdebitosrecibidos`
  ADD PRIMARY KEY (`nota`,`producto`),
  ADD KEY `fk_detallesDebitosRecibidos_producto1_idx` (`producto`);

--
-- Indexes for table `detallesnotas`
--
ALTER TABLE `detallesnotas`
  ADD PRIMARY KEY (`nota`,`producto`),
  ADD KEY `fk_detallesNotas_producto1_idx` (`producto`);

--
-- Indexes for table `dolares`
--
ALTER TABLE `dolares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equilibrio`
--
ALTER TABLE `equilibrio`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`codigo`,`cod_cliente`,`usuario`),
  ADD KEY `cod_cliente` (`cod_cliente`),
  ADD KEY `fk_factura_usuario1_idx` (`usuario`);

--
-- Indexes for table `mejor_mes`
--
ALTER TABLE `mejor_mes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notasalida`
--
ALTER TABLE `notasalida`
  ADD PRIMARY KEY (`codigo`,`usuario`,`cod_cliente`),
  ADD KEY `fk_notasalida_cliente1_idx` (`cod_cliente`),
  ADD KEY `fk_notasalida_usuario2` (`usuario`);

--
-- Indexes for table `ordencompra`
--
ALTER TABLE `ordencompra`
  ADD PRIMARY KEY (`codigo`,`cod_proveedor`,`usuario`),
  ADD KEY `fk_ordencompra_proveedor1_idx` (`cod_proveedor`),
  ADD KEY `fk_ordencompra_usuario1_idx` (`usuario`);

--
-- Indexes for table `orden_seguimiento`
--
ALTER TABLE `orden_seguimiento`
  ADD PRIMARY KEY (`id`,`usuario`,`cod_orden`),
  ADD KEY `fk_orden_seguimiento_ordencompra1_idx` (`cod_orden`),
  ADD KEY `fk_orden_seguimiento_usuario1_idx` (`usuario`);

--
-- Indexes for table `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permisos_roles`
--
ALTER TABLE `permisos_roles`
  ADD KEY `fk_permisos_roles_roles1_idx` (`id_role`),
  ADD KEY `fk_permisos_roles_permisos1` (`id_permiso`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_producto_tipo_producto1_idx` (`tipo`),
  ADD KEY `fk_producto_unidad1_idx` (`unidad`),
  ADD KEY `fk_producto_departamento1_idx` (`departamento`);

--
-- Indexes for table `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `resetclave`
--
ALTER TABLE `resetclave`
  ADD KEY `fk_resetclave_usuario1` (`id_usuario`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipo_producto`
--
ALTER TABLE `tipo_producto`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `tmp_cotizacion`
--
ALTER TABLE `tmp_cotizacion`
  ADD PRIMARY KEY (`codigo`,`usuario`),
  ADD KEY `cod_cliente` (`cod_cliente`),
  ADD KEY `fk_tmp_cotizacion_usuario1_idx` (`usuario`);

--
-- Indexes for table `tmp_detalle_cotizacion`
--
ALTER TABLE `tmp_detalle_cotizacion`
  ADD PRIMARY KEY (`codCotizacion`,`codProducto`),
  ADD UNIQUE KEY `codFactura` (`codCotizacion`,`codProducto`),
  ADD KEY `codProducto` (`codProducto`);

--
-- Indexes for table `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_usuario_roles1_idx` (`nivel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajusteinv`
--
ALTER TABLE `ajusteinv`
  MODIFY `codigo` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `codigo` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cotizacion_seguimiento`
--
ALTER TABLE `cotizacion_seguimiento`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creditosemitidos`
--
ALTER TABLE `creditosemitidos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creditosrecibidos`
--
ALTER TABLE `creditosrecibidos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `debitosemitidos`
--
ALTER TABLE `debitosemitidos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `debitosrecibidos`
--
ALTER TABLE `debitosrecibidos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `factura`
--
ALTER TABLE `factura`
  MODIFY `codigo` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notasalida`
--
ALTER TABLE `notasalida`
  MODIFY `codigo` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ordencompra`
--
ALTER TABLE `ordencompra`
  MODIFY `codigo` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orden_seguimiento`
--
ALTER TABLE `orden_seguimiento`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_cotizacion`
--
ALTER TABLE `tmp_cotizacion`
  MODIFY `codigo` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ajusteinv`
--
ALTER TABLE `ajusteinv`
  ADD CONSTRAINT `fk_ajusteinv_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`cod_proveedor`) REFERENCES `proveedor` (`codigo`),
  ADD CONSTRAINT `fk_compra_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `configuracion`
--
ALTER TABLE `configuracion`
  ADD CONSTRAINT `configuracion_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE;

--
-- Constraints for table `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `cotizacion_ibfk_1` FOREIGN KEY (`cod_cliente`) REFERENCES `cliente` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cotizacion_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cotizacion_seguimiento`
--
ALTER TABLE `cotizacion_seguimiento`
  ADD CONSTRAINT `cotizacion_seguimiento_ibfk_1` FOREIGN KEY (`cod_cotizacion`) REFERENCES `cotizacion` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotizacion_seguimiento_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`);

--
-- Constraints for table `creditosemitidos`
--
ALTER TABLE `creditosemitidos`
  ADD CONSTRAINT `fk_CreditosEmitidos_factura1` FOREIGN KEY (`cod_factura`) REFERENCES `factura` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_CreditosEmitidos_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `creditosrecibidos`
--
ALTER TABLE `creditosrecibidos`
  ADD CONSTRAINT `fk_CreditosRecibidos_compra1` FOREIGN KEY (`cod_compra`) REFERENCES `compra` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_CreditosRecibidos_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `debitosemitidos`
--
ALTER TABLE `debitosemitidos`
  ADD CONSTRAINT `fk_DebitosEmitidos_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DevitosEmitidos_factura1` FOREIGN KEY (`cod_factura`) REFERENCES `factura` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `debitosrecibidos`
--
ALTER TABLE `debitosrecibidos`
  ADD CONSTRAINT `fk_DebitosRecibidos_compra1` FOREIGN KEY (`cod_compra`) REFERENCES `compra` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_DebitosRecibidos_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalleajusteinv`
--
ALTER TABLE `detalleajusteinv`
  ADD CONSTRAINT `detalleajusteinv_ibfk_1` FOREIGN KEY (`cod_ajuste`) REFERENCES `ajusteinv` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalleajusteinv_ibfk_2` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE;

--
-- Constraints for table `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD CONSTRAINT `detallecompra_ibfk_2` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detallecompra_ibfk_3` FOREIGN KEY (`cod_compra`) REFERENCES `compra` (`codigo`) ON DELETE CASCADE;

--
-- Constraints for table `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD CONSTRAINT `detallecotizacion_ibfk_1` FOREIGN KEY (`codCotizacion`) REFERENCES `cotizacion` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detallecotizacion_ibfk_2` FOREIGN KEY (`codProducto`) REFERENCES `producto` (`codigo`);

--
-- Constraints for table `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`codProducto`) REFERENCES `producto` (`codigo`),
  ADD CONSTRAINT `fk_detallefactura_factura1` FOREIGN KEY (`codFactura`) REFERENCES `factura` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detalleordencompra`
--
ALTER TABLE `detalleordencompra`
  ADD CONSTRAINT `detalleordencompra_ibfk_2` FOREIGN KEY (`cod_producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalleordencompra_ibfk_3` FOREIGN KEY (`cod_orden`) REFERENCES `ordencompra` (`codigo`) ON DELETE CASCADE;

--
-- Constraints for table `detallescreditosemitidos`
--
ALTER TABLE `detallescreditosemitidos`
  ADD CONSTRAINT `fk_detallesCreditosEmitidos_CreditosEmitidos1` FOREIGN KEY (`nota`) REFERENCES `creditosemitidos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallesCreditosEmitidos_producto1` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detallescreditosrecibidos`
--
ALTER TABLE `detallescreditosrecibidos`
  ADD CONSTRAINT `fk_detallesCreditosRecibidos_CreditosRecibidos1` FOREIGN KEY (`nota`) REFERENCES `creditosrecibidos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallesCreditosRecibidos_producto1` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detallesdebitosemitidos`
--
ALTER TABLE `detallesdebitosemitidos`
  ADD CONSTRAINT `fk_detallesDebitosEmitidos_DebitosEmitidos1` FOREIGN KEY (`nota`) REFERENCES `debitosemitidos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallesDebitosEmitidos_producto1` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detallesdebitosrecibidos`
--
ALTER TABLE `detallesdebitosrecibidos`
  ADD CONSTRAINT `fk_detallesDebitosRecibidos_DebitosRecibidos1` FOREIGN KEY (`nota`) REFERENCES `debitosrecibidos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallesDebitosRecibidos_producto1` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detallesnotas`
--
ALTER TABLE `detallesnotas`
  ADD CONSTRAINT `fk_detallesNotas_notasalida1` FOREIGN KEY (`nota`) REFERENCES `notasalida` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detallesNotas_producto1` FOREIGN KEY (`producto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_cliente1` FOREIGN KEY (`cod_cliente`) REFERENCES `cliente` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_factura_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notasalida`
--
ALTER TABLE `notasalida`
  ADD CONSTRAINT `fk_notasalida_cliente1` FOREIGN KEY (`cod_cliente`) REFERENCES `cliente` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notasalida_usuario2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ordencompra`
--
ALTER TABLE `ordencompra`
  ADD CONSTRAINT `fk_ordencompra_proveedor1` FOREIGN KEY (`cod_proveedor`) REFERENCES `proveedor` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ordencompra_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orden_seguimiento`
--
ALTER TABLE `orden_seguimiento`
  ADD CONSTRAINT `fk_orden_seguimiento_ordencompra1` FOREIGN KEY (`cod_orden`) REFERENCES `ordencompra` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orden_seguimiento_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permisos_roles`
--
ALTER TABLE `permisos_roles`
  ADD CONSTRAINT `fk_permisos_roles_permisos1` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_permisos_roles_roles1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_departamento1` FOREIGN KEY (`departamento`) REFERENCES `departamento` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_tipo_producto1` FOREIGN KEY (`tipo`) REFERENCES `tipo_producto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_unidad1` FOREIGN KEY (`unidad`) REFERENCES `unidad` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resetclave`
--
ALTER TABLE `resetclave`
  ADD CONSTRAINT `fk_resetclave_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tmp_cotizacion`
--
ALTER TABLE `tmp_cotizacion`
  ADD CONSTRAINT `fk_tmp_cotizacion_cliente1` FOREIGN KEY (`cod_cliente`) REFERENCES `cliente` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tmp_cotizacion_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tmp_detalle_cotizacion`
--
ALTER TABLE `tmp_detalle_cotizacion`
  ADD CONSTRAINT `fk_tmp_detalle_cotizacion_producto1` FOREIGN KEY (`codProducto`) REFERENCES `producto` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tmp_detalle_cotizacion_tmp_cotizacion1` FOREIGN KEY (`codCotizacion`) REFERENCES `tmp_cotizacion` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_roles1` FOREIGN KEY (`nivel`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
