<?php

 include '../templates/template.php';
 include '../../config/conexion.php';
if ($_SESSION['nivel']==1)
{
    header('Location: panel_us');
}



$sql = $con->query("SELECT *from conf_empresa");
  if($row = $sql->fetch_array())
  {
    $nombre = $row['nombre'];
    $num_fiscal = $row['numero_fiscal'];
    $direccion = $row['direccion'];
    $telefono = $row['telefono'];
    $correo = $row['correo'];
    $web = $row['web'];
    $pago = $row['pago'];
    $logo = $row['logo'];
    $eslogan = $row['eslogan'];

  }
?>

<br><br><br>
 <div class="col-md-10 col-md-offset-1">
  <div class="panel panel-info">
    <div class="panel-heading">
      <h4><i class='glyphicon glyphicon-edit'></i> Configuración de la empresa </h4>
    </div>
    <div class="panel-body">
      <form enctype="multipart/form-data" class="form-horizontal" method="post" id="form_empresa" name="form_empresa">
      <div id="resultados_ajax"></div>
      
      <strong>Datos de la empresa</strong>
        <div class="panel panel-default">
          <div class="panel-body">
          <div class="row">
             <label for="num_fiscal" class="col-md-3 control-label">Número fiscal:</label>
              <div class="col-md-3">
                <input type="text" class="form-control" name="num_fiscal" id="num_fiscal" onkeypress="javascript: return ValidarEspacio(event,this)" value="<?php echo $num_fiscal ?>">
              </div>
          </div>
          <br>
          <div class="row">
              <label for="nombre" class="col-md-3 control-label">Nombre:</label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre ?>">
            </div>
          </div>
          <br> 
          <div class="row">
              <label for="direccion" class="col-md-3 control-label">Dirección</label>
            <div class="col-md-8">
              <textarea class="form-control" name="direccion" id="direccion"><?php echo $direccion ?></textarea>
            </div>
          </div>
          <br>
          <div class="row">
              <label for="telefono" class="col-md-3 control-label">Telefonos:</label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $telefono ?>">
            </div>
          </div>
          <br> 
          <div class="row">
              <label for="correo" class="col-md-3 control-label">Correo:</label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="correo" id="correo" value="<?php echo $correo ?>">
            </div>
          </div>
          <br>
          <div class="row">
              <label for="web" class="col-md-3 control-label">Sitio Web:</label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="web" id="web" value="<?php echo $web ?>">
            </div>
          </div>                    
          <br>
          <div class="row">
              <label for="pago" class="col-md-3 control-label">Información de pago:</label>
            <div class="col-md-8">
              <textarea class="form-control" name="pago" id="pago" placeholder="Puede ingresar Información como cuentas bancarias, nombre del titular, entre otros..."><?php echo $pago ?></textarea>
            </div>
          </div>                    
          <br> 
          <div class="row">
              <label for="logo" class="col-md-3 control-label">logo:</label>
            <div class="col-md-8">
              <input type="file" class="form-control" name="logo" id="logo">
            </div>
          </div>  
          <br>                   
          <div class="row">
              <label for="eslogan" class="col-md-3 control-label">Eslogan:</label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="eslogan" id="eslogan" value="<?php echo $eslogan; ?>">
            </div>
          </div>                     	                 
          </div>        
        </div>        

        <div class="col-md-12">
          <div class="pull-right">       
            <button id="guardar" type="submit" class="btn btn-default btn-lg"  data-toggle="tooltip" data-placement="top" title="Guardar cambios">
              <span class="glyphicon glyphicon-floppy-disk"></span>
            </button>
          </div>  
        </div>

      </form>      
      
    </div>
  </div>    
         
  </div>
  <hr>

    <?php
  include("../templates/template_footer.php");
  ?>
  <script type="text/javascript" src="./js/conf_empresa.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  </body>
</html>

<script>
  function ValidarEspacio(e, campo){
      key = e.keyCode ? e.keyCode : e.which;
      if (key == 32) {return false;}
  }   
</script> 