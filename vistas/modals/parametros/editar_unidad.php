<?php
/**
 * Created by PhpStorm.
 * User: Carlos Peraza
 * Date: 04-12-2017
 * Time: 01:41 PM
 */
?>
<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="editar_unidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Editar</h4>
	  </div>
	  <div class="modal-body">
		<form class="form-horizontal" method="post" name="form_editar_unidad" id="form_editar_unidad">
			<div id="resultados_ajax"></div>
		  	<div class="form-group">
				<div class="col-sm-6">
				</div>
		  	</div>
		  	<div id="carga" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
			<div class="edit" ></div><!-- Datos ajax Final -->
	  </div>
	  <div class="modal-footer">

		  <button type="submit" class="btn btn-primary" name="guardar_cambios" id="guardar_cambios"> <i class="glyphicon glyphicon-floppy-saved"></i>Guardar cambios</button>
	  	  <button id="btn_modalEditarProducto" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>	  </div>
	  </form>
	</div>
  </div>
</div>