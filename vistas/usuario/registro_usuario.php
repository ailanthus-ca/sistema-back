<?php
  
 include '../templates/template.php';
 include '../../config/conexion.php';
if ($_SESSION['nivel']==1)
{
    header('Location: panel_us');
}
?>

<script language="JavaScript" type="text/javascript" src="./js/ajax.js"></script>
<link href="../../public/css/imgresponsive.css" rel="stylesheet">

<br><br><br><br><br><br><br>

<form id="guardar_usuario" name="guardar_usuario" method="POST">
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">

            <div class="panel-group" id="accordion">
             <div id="resultados_ajax_usuario"></div>
                  <div class="panel panel-info">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <h4><i class='glyphicon glyphicon-user'></i> Nuevo Usuario </h4>
                          </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" required />
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input id="correo" name="correo" type="email" class="form-control" placeholder="Correo@ejemplo.com" required onkeypress="javascript: return ValidarEspacio(event,this)" />
                                      </div>
                                  </div> 
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input id="clave" name="clave" type="password" class="form-control" placeholder="Ingrese una clave" required />
                                      </div>
                                  </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="estatus" name="estatus" class="form-control" id="estatus">
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>                                      
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">
                                            Nivel</label>
                                        <select id="nivel" name="nivel" class="form-control" id="nivel">
                                            <option value="1">Usuario</option>
                                            <option value="0">Administrador</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="">
                                  <div class="col-md-3">
                                    <button type="reset" class="btn btn-danger"> <i class="fa fa-paint-brush"></i> Limpiar</button>
                                  </div> 
                                  <div class="col-md-3"> 
                                    <button name="guardar_datos" id="guardar_datos" type="submit" class="btn btn-primary"> <i class="fa fa-check-square"></i> Guardar</button>
                                  </div>
                                </div>
                              </div>
                              </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  </div>
</form>  
                

<?php include "../templates/template_footer.php" ?>

<script type="text/javascript" src="./js/nuevo_usuario.js"></script>