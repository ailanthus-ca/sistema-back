	<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="historico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
	  </div>
	  <div class="modal-body">
		<form class="form-horizontal">
		  <div class="form-group">
              <div class="col-sm-1">
                  <h5 id="myModalLabel">DPTO:</h5>
              </div>
              <div class="col-sm-3">
                  <select class="selectpicker form-control" id="dp" name="dp" onchange="cargar_producto(1)">
                      <option value="td">TODOS</option>
                      <?php
                      $sql = "SELECT codigo, descripcion FROM departamento WHERE estatus = 1";
                      $query = $con->query($sql);
                      while($row = mysqli_fetch_array($query)){
                          ?><option value="<?php echo $row['codigo']; ?>"><?php echo $row['descripcion']; ?></option><?php
                          $i++;
                      }
                      ?>
                  </select>
              </div>
			<div class="col-sm-6">
			  <input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="cargar_producto(1)">
			</div>
			<button type="button" class="btn btn-default" onclick="cargar_producto(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
		  </div>
		</form>
		<div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
		<div class="productos" ></div><!-- Datos ajax Final -->
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		
	  </div>
	</div>
  </div>
</div>
