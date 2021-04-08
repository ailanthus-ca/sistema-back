<?php

 include '../templates/template.php';
 include '../../config/conexion.php';
if ($_SESSION['nivel']==1)
{
    header('Location: panel_us');
}



$sql = $con->query("SELECT *from conf_factura");
  if($row = $sql->fetch_array())
  {
    $top         = $row['margen_sup'];
    $bottom      = $row['margen_inf'];
    $left        = $row['margen_izq'];
    $right       = $row['margen_der'];
    $papel       = $row['tipo_papel'];
    $observacion = $row['observacion'];
    
    $num_factura = $row['num_factura'];
    $visible     = 'readonly';
    $disabled    = 'disabled';
    $mensaje     = '<p style="color: red">Ya se ha inicializado el número de factura. No puede volver a realizar este proceso.</p>';
  }  
  else
  {
    $num_factura = 1;
    $visible     = ''; 
    $disabled    = '';
    $mensaje     = '<p style="color: red">Este proceso es irreversible. Una vez inicializado el número no podrá hacerlo de nuevo.</p>';
  }
?>

<br><br><br>
 <div class="col-md-10 col-md-offset-1">
  <div class="panel panel-info">
    <div class="panel-heading">
      <h4><i class='glyphicon glyphicon-edit'></i> Configuración de la factura </h4>
    </div>
    <div class="panel-body">
      <form class="form-horizontal" method="post" id="form_numeracion" name="form_numeracion">
      <div id="resultados_ajax_ajuste"></div>
      
      <strong>Numeración</strong>
        <div class="panel panel-default">
          <div class="panel-body">
          <div class="row">
              <label for="num_factura" class="col-md-3 control-label">Iniciar numeración de la factura en:  </label>
            <div class="col-md-4">
              <input type="number" class="form-control" name="num_factura" id="num_factura" value="<?php echo $num_factura ?>" min="1" <?php echo $visible ?>>
            </div>
            <?php echo $mensaje ?>
          </div>
          </div>        
        </div>

        <div class="col-md-12">
          <div class="pull-right">       
            <button id="guardar_numeracion" type="submit" class="btn btn-default" <?php echo $disabled ?>>
              <span class="glyphicon glyphicon-print"></span> Guardar
            </button>
          </div>  
        </div>

      </form>      

      <form class="form-horizontal" method="post" id="form_dimensiones" name="form_dimensiones">
      <strong>Dimensiones del formato de salida</strong>

      <div class="panel panel-default">
        <div class="panel-body">
        <div class="row">
            <label for="pagina" class="col-md-3 control-label">Tipo de página: </label>
          <div class="col-md-2">
            <select name="pagina" id="pagina" class="form-control">
              <option value="LETTER">Carta</option>
              <option value="LEGAL">Oficio</option>
            </select>
          </div>
        </div>
        <br>
        <div class="row">
            <label for="top" class="col-md-3 control-label">Margen superior(mm): </label>
          <div class="col-md-2">
            <input type="number" class="form-control" name="top" id="top" value="<?php echo $top; ?>"> 
          </div>
        </div>
        <br>
        <div class="row">
            <label for="bottom" class="col-md-3 control-label">Margen inferior(mm): </label>
          <div class="col-md-2">
            <input type="number" class="form-control" name="bottom" id="bottom" value="<?php echo $bottom; ?>">
          </div>
        </div>
        <br>                        
        <div class="row">
            <label for="left" class="col-md-3 control-label">Margen izquierdo(mm): </label>
          <div class="col-md-2">
            <input type="number" class="form-control" name="left" id="left" value="<?php echo $left; ?>">
          </div>
        </div>
        <br>
        <div class="row">  
            <label for="right" class="col-md-3 control-label">Margen derecho(mm):  </label>
          <div class="col-md-2">
            <input type="number" class="form-control" name="right" id="right" value="<?php echo $right; ?>">
          </div>
        </div>
        <br>
        <div class="row">  
            <label for="right" class="col-md-3 control-label">Observación:  </label>
          <div class="col-md-8">
            <input type="text" class="form-control" name="observacion" id="observacion" value="<?php echo $observacion; ?>">
          </div>
        </div>                            
        </div>        
      </div> 
        
        <div class="col-md-12">
          <div class="pull-right">
            <button class="btn btn-default btn-lg" onclick="ver_prueba();"  data-toggle="tooltip" data-placement="top" title="Ver prueba">
              <span class="glyphicon glyphicon-print"></span>
            </button>                 
            <button id="guardar_dimensiones" type="submit" class="btn btn-default btn-lg"  data-toggle="tooltip" data-placement="top" title="Guardar cambios">
              <span class="glyphicon glyphicon-floppy-disk"></span>
            </button>
          </div>  
        </div>
      </form> 
      
    <div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->      
    </div>
  </div>    
      <div class="row-fluid">
      <div class="col-md-12">
      
  

      
      </div>  
     </div>

  </div>
  <hr>

    <?php
  include("../templates/template_footer.php");
  ?>
  <script type="text/javascript" src="./js/VentanaCentrada.js"></script>
  <script type="text/javascript" src="./js/conf_factura.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  </body>
</html>