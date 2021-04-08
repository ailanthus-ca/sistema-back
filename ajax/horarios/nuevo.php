<?php
$fh = fopen("horarios.json", 'w');
fwrite($fh, json_encode($_POST));
fclose($fh);
?>
<div class="alert alert-success" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>¡Guardado con exito!</strong>
</div>


