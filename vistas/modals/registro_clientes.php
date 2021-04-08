	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo cliente</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Código</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="codigo" name="codigo" placeholder="RIF, NIF, Cedula..." required>
				</div>
			  </div>			
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la persona" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el(los) numero(s) de contacto" required>
				</div>
			  </div>

			  <div class="form-group">
				<label for="telefono" class="col-sm-3 control-label">Contacto</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="contacto" name="contacto" placeholder="Persona contacto">
				</div>
			  </div>			  
			  
			  <div class="form-group">
				<label for="email" class="col-sm-3 control-label">Correo</label>
				<div class="col-sm-8">
					<input type="email" class="form-control" id="email" name="correo" placeholder="ejemplo@correo.com" required>
				  
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-sm-8">
					<textarea class="form-control" id="direccion" name="direccion" placeholder="Ingrese una direccion"   maxlength="255" ></textarea>
				  
				</div>
			  </div>
            <div class="form-group">
             <label for="tipo_contribuyente" class="col-sm-3 control-label">Tipo de contribuyente</label><br>
              <div class="col-sm-8">
             <input id="tipo_contribuyente" name="tipo_contribuyente" type="radio"  value="ordinario" checked onclick="option(this.value)" />Ordinario
             <input id="tipo_contribuyente" name="tipo_contribuyente" type="radio"  value="especial"  onclick="option(this.value)" /> especial
             <input type="number" name="retencion" id="retencion" class="form-control" maxlength="3" placeholder="Retencion %" readonly>
              </div>
            </div>			  

			  <div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="estado" name="estatus" required>
					<option value="">-- Selecciona estado --</option>
					<option value="1" selected>Activo</option>
					<option value="0">Inactivo</option>
				  </select>
				</div>
			  </div>
			 
			 			
		  </div>
		  <div class="modal-footer">
			<button id="btn_modalCliente" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

<script>
	function option(value) 
		{
			if (value=='ordinario') 
			{
				$('#retencion').attr("disabled", false);
				$('#retencion').attr("readonly", true);
				$('#retencion').val("");	
			}
			if (value=='especial')
			{
				$('#retencion').attr("disabled", false);
				$('#retencion').attr("readonly", false);
			}	
		}
</script>