<?php
  
   include '../templates/template.php';
   include '../../config/conexion.php';
if ($_SESSION['nivel']==1)
{
    header('Location: panel_us');
}



$sql = $con->query("SELECT *from conf_venta");
  if($row = $sql->fetch_array())
  {
    $garantia = $row['garantia'];
    /*$envio = $row['envio'];
    if ($envio == 1)
    {
      $checked1 = 'checked';
      $checked0 = '';
    }
    else
    {
      $checked1 = '';
      $checked0 = 'checked';
    }*/
    $observacion = $row['observacion'];
    

  }
?>

<br><br><br>
 <div class="col-md-10 col-md-offset-1">
  <div class="panel panel-info">
    <div class="panel-heading">
      <h4><i class='glyphicon glyphicon-edit'></i> Configuración de ventas </h4>
    </div>
    <div class="panel-body">
      <form enctype="multipart/form-data" class="form-horizontal" method="post" id="form_ventas" name="form_ventas">
      <div id="resultados_ajax"></div>
      
      <strong>Datos de venta</strong>
        <div class="panel panel-default">
          <div class="panel-body">
          <div class="row">
             <label for="garantia" class="col-md-3 control-label">Garantia de los productos:</label>
              <div class="col-md-8">
                <input type="text" class="form-control" name="garantia" id="garantia" value="<?php echo $garantia ?>" required>
              </div>
          </div>
          <br>
         <!-- <div class="row">
              <label for="envio" class="col-md-3 control-label">Envios al interior:</label>
            <div class="col-md-2">
              <input type="radio" class="" id="envio" name="envio" value="1" <?php echo $checked1; ?> > SI
            </div>
            <div class="col-md-2">
              <input type="radio" class="" id="envio" name="envio" value="0" <?php echo $checked0; ?> > No
            </div>
          </div>
          <br> -->
          <div class="row">
              <label for="observacion" class="col-md-3 control-label">Observación general</label>
            <div class="col-md-8">
              <textarea class="form-control" name="observacion" id="observacion"><?php echo $observacion ?></textarea>
            </div>
          </div>                     	                 
          </div>        
        </div>        

        <div class="col-md-12">
          <div class="pull-right">       
            <button id="guardar" type="submit" class="btn btn-default btn-lg" data-toggle="tooltip" data-placement="top" title="Guardar cambios" >
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
  <script type="text/javascript" src="./js/VentanaCentrada.js"></script>
  <script type="text/javascript" src="./js/conf_venta.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  </body>
</html>