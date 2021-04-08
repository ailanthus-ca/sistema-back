<?php
include '../templates/template.php';
$horarios = (Object) json_decode(file_get_contents("../../ajax/horarios/horarios.json"));
?>

<!DOCTYPE html>
<html lang="en">
    <head>

    </head>
    <br><br><br>
    <body>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4><i class='glyphicon glyphicon-edit'></i> Configuración de la Horarios de Trabajo </h4>
                </div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" class="form-horizontal" method="post" id="horarios" name="form_empresa">
                        <div id="result"></div>
                        <table class="table-responsive table-striped table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="40%">
                                        Dia de la Semana
                                    </th>
                                    <th width="10%">
                                        Laborable
                                    </th>
                                    <th width="25%">
                                        Hora de Entrada
                                    </th>
                                    <th width="25%">
                                        Hora de Salida
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Lunes
                                    </td>
                                    <td>
                                        <input id="LunesL" type="checkbox" <?php if ($horarios->Lunes->Laborable == 'true') echo 'checked' ?> class="checkbox">
                                    </td>
                                    <td>
                                        <input id="LunesE" type="time" value="<?php echo $horarios->Lunes->Entrada ?>" max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                    <td>
                                        <input id="LunesS" type="time" value="<?php echo $horarios->Lunes->Salida ?>"  max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Martes
                                    </td>
                                    <td>
                                        <input id="MartesL" type="checkbox" <?php if ($horarios->Martes->Laborable == 'true') echo 'checked' ?> class="checkbox">
                                    </td>
                                    <td>
                                        <input id="MartesE" type="time" value="<?php echo $horarios->Martes->Entrada ?>" max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                    <td>
                                        <input id="MartesS" type="time" value="<?php echo $horarios->Martes->Salida ?>"  max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Miercoles
                                    </td>
                                    <td>
                                        <input id="MiercolesL" type="checkbox" <?php if ($horarios->Miercoles->Laborable == 'true') echo 'checked' ?> class="checkbox">
                                    </td>
                                    <td>
                                        <input id="MiercolesE" type="time" value="<?php echo $horarios->Miercoles->Entrada ?>" max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                    <td>
                                        <input id="MiercolesS" type="time" value="<?php echo $horarios->Miercoles->Salida ?>"  max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Jueves
                                    </td>
                                    <td>
                                        <input id="JuevesL" type="checkbox" <?php if ($horarios->Jueves->Laborable == 'true') echo 'checked' ?> class="checkbox">
                                    </td>
                                    <td>
                                        <input id="JuevesE" type="time" value="<?php echo $horarios->Jueves->Entrada ?>" max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                    <td>
                                        <input id="JuevesS" type="time" value="<?php echo $horarios->Jueves->Salida ?>"  max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Viernes
                                    </td>
                                    <td>
                                        <input id="ViernesL" type="checkbox" <?php if ($horarios->Viernes->Laborable == 'true') echo 'checked' ?> class="checkbox">
                                    </td>
                                    <td>
                                        <input id="ViernesE" type="time" value="<?php echo $horarios->Viernes->Entrada ?>" max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                    <td>
                                        <input id="ViernesS" type="time" value="<?php echo $horarios->Viernes->Salida ?>"  max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Sabado
                                    </td>
                                    <td>
                                        <input id="SabadoL" type="checkbox" <?php if ($horarios->Sabado->Laborable == 'true') echo 'checked' ?> class="checkbox">
                                    </td>
                                    <td>
                                        <input id="SabadoE" type="time" value="<?php echo $horarios->Sabado->Entrada ?>" max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                    <td>
                                        <input id="SabadoS"  type="time" value="<?php echo $horarios->Sabado->Salida ?>" max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Domingo
                                    </td>
                                    <td>
                                        <input id="DomingoL" type="checkbox" <?php if ($horarios->Domingo->Laborable == 'true') echo 'checked' ?> class="checkbox">
                                    </td>
                                    <td>
                                        <input id="DomingoE" type="time" value="<?php echo $horarios->Domingo->Entrada ?>" max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                    <td>
                                        <input id="DomingoS" type="time" value="<?php echo $horarios->Domingo->Salida ?>"  max="22:30:00"  min="5:00:00" class="form-control" step="1">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-md-12 text-right"> 
                            <button type="reset" class="btn btn-danger"> <i class="fa fa-paint-brush"></i> Limpiar</button>
                            <button name="guardar_datos" id="guardar_datos" class="btn btn-primary"> <i class="fa fa-check-square"></i> Guardar</button>
                        </div>
                    </form>      

                </div>
            </div>    

        </div>
        <?php
        include("../templates/template_footer.php");
        ?>
        <script src="/js/horas.js"></script>
    </body>
</html>

