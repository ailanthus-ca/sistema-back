<?php

	include '../../config/conexion.php';

	$id = $_GET['id'];

  $query = "SELECT producto.codigo AS codigo, producto.descripcion AS descripcion, 
                      tipo_producto.descripcion AS tipo, unidad.descripcion AS unidad, costo, precio1, precio2, precio3, enser 
                      FROM producto, tipo_producto, unidad 
                      where producto.codigo = '$id' 
                      AND producto.tipo = tipo_producto.codigo
                      AND producto.unidad = unidad.codigo";

                      
	$sql = $con->query($query);
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
    $enser = $row['enser'];

    if ($enser == 1)
      $check = "checked";
    else
      $check = "";

	}

?>

	  <div class="form-group">
		<label for="codigo" class="col-sm-3 control-label">Código</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del producto" value="<?php echo $codigo ?>" readonly>
		</div>
	  </div>
	  
	  <div class="form-group">
		<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
		<div class="col-sm-8">
			<textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion del producto" required maxlength="300" ><?php echo $descripcion ?></textarea>
		  
		</div>
	  </div>
     
      <div class="form-group">
			<label for="tipo" class="col-sm-3 control-label">Tipo</label>
          <div class="col-sm-8">    
          <select name="tipo" class="form-control" id="tipo">
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
            <select name="unidad" class="form-control" id="unidad">
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
                    <input  name="costo" type="text" class="form-control" id="costo" placeholder="Costo" value="<?php echo $costo ?>" onkeyup="sumar('costo',this.value);" required pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="11" />
                	</div>
            </div>

            <div class="form-group">
               <label for="costo" class="col-sm-3 control-label">Enser</label>
                <div class="col-sm-4">          
                   <input type="checkbox" name="enser" id="enser" value="1" <?php echo $check; ?>>
                   <label for="enser"><strong style="font-size: 18px;"></strong></label>
                </div>
            </div>  
  
            <div class="row">
              <label for="porcentaje1" class="col-sm-3 control-label">Porcentaje 1</label>
              <div class="col-sm-2">
                  <input name="porcentaje1" class="form-control" type="text" id="porcentaje1"  onkeyup="sumar('porcentaje1',this.value);" placeholder="%" required pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="3" value="<?php echo $precio1; ?>">
              </div>
              <label for="precio1" class="col-sm-2 control-label">Precio 1</label>
              <div class="col-sm-4">
                  <input name="precio1" type="text" class="form-control" id="precio1" placeholder="Precio 1" required pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" readonly />
              </div>
            </div>             
            <br>
            <div class="row">
              <label for="porcentaje2" class="col-sm-3 control-label">Porcentaje 2</label>
              <div class="col-sm-2">
                  <input name="porcentaje2" class="form-control" type="text" id="porcentaje2"  onkeyup="sumar('porcentaje2',this.value);" placeholder="%" required pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="3" value="<?php echo $precio2; ?>">
              </div>
              <label for="precio2" class="col-sm-2 control-label">Precio 2</label>
              <div class="col-sm-4">
                   <input name="precio2" type="text" class="form-control" id="precio2" placeholder="Precio 2" required pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" readonly />  
              </div>
            </div> 
            <br>
            <div class="row">
              <label for="porcentaje3" class="col-sm-3 control-label">Porcentaje 3</label>
              <div class="col-sm-2">
                  <input name="porcentaje3" class="form-control" type="text" id="porcentaje3"  onkeyup="sumar('porcentaje3',this.value);" placeholder="%" required pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="3" value="<?php echo $precio3; ?>">
              </div>
              <label for="precio3" class="col-sm-2 control-label">Precio 3</label>
              <div class="col-sm-4">
                   <input name="precio3" type="text" class="form-control" id="precio3" placeholder="Precio 3" required pattern="^[0-9]{12,2}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" readonly />
              </div>
            </div>
    	      

<script>
      $(document).ready(function(){
      loads();
      
    });

    function loads(){
      input = 'costo';
      costo = document.getElementById('costo').value;
      sumar(input,costo);
    }


     function sumar (input,valor) {
        
        valor = parseFloat(valor);

        if (input=='costo') 
        {
          var por1 = document.getElementById('porcentaje1').value;
          var por2 = document.getElementById('porcentaje2').value;
          var por3 = document.getElementById('porcentaje3').value;

          console.log(por1);
          console.log(por2);
          console.log(por3);
          
          precio1 = (parseFloat(valor+valor*por1/100));
          precio2 = (parseFloat(valor+valor*por2/100));
          precio3 = (parseFloat(valor+valor*por3/100));

          $("#precio1").val(precio1);
          $("#precio2").val(precio2);
          $("#precio3").val(precio3);
        }

        if(input=='porcentaje1')
        {
          var costo = document.getElementById('costo').value;
          costo = parseFloat(costo);
          console.log(costo);
          $("#precio1").val(costo+costo*valor/100);
        }

        if(input=='porcentaje2')
        {
          var costo = document.getElementById('costo').value;
          costo = parseFloat(costo);
          console.log(costo);
          $("#precio2").val(costo+costo*valor/100);
        }

        if(input=='porcentaje3')
        {
          var costo = document.getElementById('costo').value;
          costo = parseFloat(costo);
          console.log(costo);
          $("#precio3").val(costo+costo*valor/100);
        }                
        
    }
         
</script>

<?php
	mysqli_close($con);
?>