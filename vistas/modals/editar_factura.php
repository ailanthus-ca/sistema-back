	<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Editar Factura</h4>
	  </div>
	  <div class="modal-body">
		<div id="carga" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
		<div class="edit" ></div><!-- Datos ajax Final -->
	  </div>
	  <div class="modal-footer">
	  <button id="btn_modalEditarFactura" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	  </div>
	</div>
  </div>
</div>

<script type="text/javascript" src="./js/editar_factura.js"></script>