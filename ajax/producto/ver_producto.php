<?php

	include '../../config/conexion.php';

	$id = $_GET['id'];


	$sql = $con->query("SELECT *from producto where codigo = '$id' ");
	if ($row = $sql->fetch_array()) 
	{
		$codigo = $row['codigo'];
		$descripcion = $row['descripcion'];
		$tipo = $row['tipo'];
		$unidad = $row['unidad'];
		$costo = $row['costo'];
		$precio1 = $row['precio1'];
		$precio2 = $row['precio2'];
		$precio3 = $row['precio3'];

    $precio1 = floatval($costo+($costo*$precio1)/100);
    $precio2 = floatval($costo+($costo*$precio2)/100);
    $precio3 = floatval($costo+($costo*$precio3)/100);

	}

?>

<div class="table-responsive">

	  <div class="form-group">
		<label for="codigo" class="col-sm-3 control-label">Código</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del producto" value="<?php echo $codigo ?>" readonly>
		</div>
	  </div>
	  
	  <div class="form-group">
		<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
		<div class="col-sm-8">
			<textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion del producto" required maxlength="255" readonly="" ><?php echo $descripcion ?></textarea>
		  
		</div>
	  </div>
     
      <div class="form-group">
			<label for="tipo" class="col-sm-3 control-label">Tipo</label>
          <div class="col-sm-8">    
          <select name="tipo" class="form-control" id="tipo" readonly>
              <?php  
                $sql_tipo = $con->query("SELECT *FROM tipo_producto");
                while ($rowt = mysqli_fetch_array($sql_tipo))
                {
                  if ($rowt['descripcion'] == $tipo)
                  {
                    $selected = "selected";
                  }
                  else
                  {
                    $selected = "";
                  }
                  echo $check;   
              ?>
                <option value="<?php echo $rowt['codigo']; ?>" <?php echo $selected ?> ><?php echo $rowt['descripcion']?></option>

              <?php } ?>  
          </select>
     	 </div>
  	 </div>

      <div class="form-group">
			<label for="unidad" class="col-sm-3 control-label">Unidad</label>
          <div class="col-sm-8">    
              <select name="unidad" class="form-control" id="unidad" readonly>
                <?php  
                  $sql_unidad = $con->query("SELECT *FROM unidad");
                  while ($rowt = mysqli_fetch_array($sql_unidad))
                  {
                    if ($rowt['descripcion'] == $unidad)
                    {
                      $selected_u = "selected";
                    }
                    else
                    {
                      $selected_u = "";
                    }
                    echo $check;   
                ?>
                  <option value="<?php echo $rowt['codigo']; ?>" <?php echo $selected_u ?> ><?php echo $rowt['descripcion']?></option>

                <?php } ?> 
              </select>
     	 </div>
  	 </div>          	 

      <div class="form-group">
		<label for="costo" class="col-sm-3 control-label">Costo</label>
       		<div class="col-sm-8">          
              <input  name="costo" type="text" class="form-control" id="costo" placeholder="Costo" value="<?php echo $costo ?>" readonly />
          	</div>
      </div>
  
      <div class="form-group">
      	<label for="porcentaje1" class="col-sm-3 control-label">Precio 1</label>
          <div class="col-sm-8">
            <input name="precio1" type="text" class="form-control" id="precio1" value="<?php echo $precio1 ?>" readonly />
          </div>
  	  </div>          	 

      <div class="form-group">
      	<label for="porcentaje2" class="col-sm-3 control-label">Precio 2</label>
          <div class="col-sm-8">
              <input name="precio2" type="text" class="form-control" id="precio2" value="<?php echo $precio2 ?>" readonly />
          </div>
  	  </div> 

      <div class="form-group">
      	<label for="porcentaje3" class="col-sm-3 control-label">Precio 3</label>
          <div class="col-sm-8">
              <input name="precio3" type="text" class="form-control" id="precio3" value="<?php echo $precio3 ?>" readonly />
          </div>
  	  </div>	
</div>            	      


<?php
	mysqli_close($con);
?>