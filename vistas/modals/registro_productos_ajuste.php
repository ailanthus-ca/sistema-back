<!-- Modal -->
<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo producto</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
                    <div id="resultados_ajax_productos"></div>
                    <div class="form-group">
                        <label for="departamento" class="col-sm-3 control-label">Departamento</label>
                        <div class="col-sm-8">
                            <select name="departamento" class="form-control" id="departamento">
                                <option value="null" selected>Selecione un Departamento</option>
                                <?php
                                $sql_dpto = $con->query("SELECT *FROM departamento where estatus = 1");
                                while ($rowt = mysqli_fetch_array($sql_dpto)) {
                                    ?>
                                    <option value="<?php echo $rowt['codigo']; ?>"><?php echo $rowt['descripcion'] ?></option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descripcion" class="col-sm-3 control-label">Descripción</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion del producto" required maxlength="300" ></textarea>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tipo" class="col-sm-3 control-label">Tipo</label>
                        <div class="col-sm-8">    
                            <select name="tipo" class="form-control" id="tipo">
                                <?php
                                $sql_tipo = $con->query("SELECT *FROM tipo_producto where estatus = 1");
                                while ($rowt = mysqli_fetch_array($sql_tipo)) {
                                    ?>
                                    <option value="<?php echo $rowt['codigo']; ?>"><?php echo $rowt['descripcion'] ?></option>
                                <?php } ?>  
                            </select>             	 
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="unidad" class="col-sm-3 control-label">Unidad</label>
                        <div class="col-sm-8">    
                            <select name="unidad" class="form-control" id="unidad">
                                <?php
                                $sql_unidad = $con->query("SELECT *FROM unidad where estatus = 1");
                                while ($rowt = mysqli_fetch_array($sql_unidad)) {
                                    if ($rowt['descripcion'] == $unidad) {
                                        $selected_u = "selected";
                                    } else {
                                        $selected_u = "";
                                    }
                                    echo $check;
                                    ?>
                                    <option value="<?php echo $rowt['codigo']; ?>" <?php echo $selected_u ?> ><?php echo $rowt['descripcion'] ?></option>

                                <?php } ?>  
                            </select>
                        </div>
                    </div>          	 

                    <div class="form-group">
                        <label for="costo_producto" class="col-sm-3 control-label">Costo</label>
                        <div class="col-sm-8">          
                            <input step="0.01" name="costo_producto" type="number" class="form-control" id="costo_producto" placeholder="Costo" value="0" onchange="sumar('costo', this.value);" onkeyup="sumar('costo', this.value);" pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales"/>
                        </div>
                    </div>

                    <div class="row">
                        <label for="porcentaje1" class="col-sm-3 control-label">Porcentaje 1</label>
                        <div class="col-sm-2">
                            <input name="porcentaje1" class="form-control" type="number" id="porcentaje1" onchange="sumar('porcentaje1', this.value);"  onkeyup="sumar('porcentaje1', this.value);" placeholder="%" pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" max="100">
                        </div>
                        <label for="precio1" class="col-sm-2 control-label">Precio 1</label>
                        <div class="col-sm-4">
                            <input name="precio1" type="text" class="form-control" id="precio1" placeholder="Precio 1"  pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" readonly />
                        </div>
                    </div>          	 
                    <br>
                    <div class="row">
                        <label for="porcentaje2" class="col-sm-3 control-label">Porcentaje 2</label>
                        <div class="col-sm-2">
                            <input name="porcentaje2" class="form-control" type="number" id="porcentaje2" onchange="sumar('porcentaje2', this.value);"  onkeyup="sumar('porcentaje2', this.value);" placeholder="%"  pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" max="100">
                        </div>
                        <label for="precio2" class="col-sm-2 control-label">Precio 2</label>
                        <div class="col-sm-4">
                            <input name="precio2" type="text" class="form-control" id="precio2" placeholder="Precio 2"  pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" readonly />
                        </div>
                    </div> 
                    <br>
                    <div class="row">
                        <label for="porcentaje3" class="col-sm-3 control-label">Porcentaje 3</label>
                        <div class="col-sm-2">
                            <input name="porcentaje3" class="form-control" type="number" id="porcentaje3" onchange="sumar('porcentaje3', this.value);"  onkeyup="sumar('porcentaje3', this.value);" placeholder="%" pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" max="100">
                        </div>
                        <label for="precio3" class="col-sm-2 control-label">Precio 3</label>
                        <div class="col-sm-4">
                            <input name="precio3" type="text" class="form-control" id="precio3" placeholder="Precio 3"  pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" readonly />
                        </div>
                    </div>	      	           	                         
                    <br>

                    <!--<div class="form-group">
                          <label for="cantidad" class="col-sm-3 control-label">Cantidad</label>
                            <div class="col-sm-4">
                                <input name="cantidad" class="form-control" type="number" id="cantidad" placeholder="Cantidad" required pattern="^[0-9]{12,2}(\.[0-9]{0})?$" title="Ingresa sólo números" min="0" value="0">
                            </div>
                            <div class="col-sm-4">
                        <input type="checkbox" name="enser" id="enser" value="1">
                        <label for="enser"><strong style="font-size: 18px;">Enser</strong></label>
                            </div>		          
                    </div>--> 

                    <div class="form-group">
                        <label for="estado" class="col-sm-3 control-label">Estado</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="checkbox" name="enser" id="enser" value="1" onclick="habilitar()">
                        <label for="enser"><strong style="font-size: 18px;">Enser</strong></label>
                    </div>

                    <div class="modal-footer">
                        <button id="btn_modalProducto" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="guardar_datos" onclick="">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="./js/nuevo_producto.js"></script>
