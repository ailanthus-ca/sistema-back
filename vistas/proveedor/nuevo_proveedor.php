<?php

 include '../templates/template.php';
 include '../../config/conexion.php';

?>

<link href="../../public/css/imgresponsive.css" rel="stylesheet">

<br><br><br><br><br><br><br>


<form action="" method="POST" name="form_proveedor" id="form_proveedor">
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel-group" id="accordion">
              <div id="resultados_ajax"></div>
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-user">
                              </i> Proveedor</a>
                          </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input id="codigo" name="codigo" type="text" class="form-control" placeholder="RIF/Cedula" onkeypress="validar(this)" required />
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" required />
                                      </div>
                                  </div>
                                </div>
                                <div class="row">   
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <textarea id="direccion" name="direccion" class="form-control" required="" placeholder="Ingrese una direccion"></textarea>
                                      </div>
                                  </div> 
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input id="telefono" name="telefono" type="text" class="form-control" placeholder="Telefono" required />
                                      </div>
                                  </div>
                                </div>
                                <div class="row">  
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <input id="correo" name="email" type="text" class="form-control" placeholder="Correo" required />
                                      </div>
                                  </div>  
                              
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <select id="estado" name="estado" class="form-control" id="estado">
                                              <option value="1">Activo</option>
                                              <option value="0">Inactivo</option>
                                          </select>
                                      </div>
                                  </div>
                                </div>
                                
                                <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                   <input id="contacto" name="contacto" type="text" class="form-control" placeholder="Persona contacto" required />
                                </div>
                                </div>
                                <div class="">
                                  <div class="col-md-3">
                                    <button type="reset" class="btn btn-danger"> <i class="fa fa-paint-brush"></i> Limpiar</button>
                                  </div> 
                                  <div class="col-md-3"> 
                                    <button name="guardar" id="guardar" type="submit" class="btn btn-primary"> <i class="fa fa-check-square"></i> Guardar</button>
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

<?php include '../templates/template_footer.php' ?>

<script type="text/javascript" src="./js/nuevo_proveedor.js"></script>

<script type="text/javascript" src="./js/maskedinput.js"></script>
