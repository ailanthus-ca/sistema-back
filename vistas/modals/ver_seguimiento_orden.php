<?php
/**
 * Created by PhpStorm.
 * User: Ailanthus
 * Date: 31-01-2018
 * Time: 04:23 PM
 */
?>
<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="ver_seguimiento_cotizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Seguimiento de la Orden de Compra</h4>
	  </div>
	  <div class="modal-body">
		<div id="cargaSeguimiento" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
		<div class="detalleSeguimiento" ></div><!-- Datos ajax Final -->
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	  </div>
	</div>
  </div>
</div>