<div>
	<div class="row">
	    <div style="width: 75px; height: 75px;">
	        <img style="width: 100%; height: 100%;" src="../../public/imagenes/<?php echo $fila['logo']; ?>" alt="Logo">
	    </div>
	    <span style="margin-left: 100px;margin-top: -60px; font-size:16px;font-weight:bold"><?php echo $fila['nombre'] ?></span>
    </div>
    <div class="row">
		<span style="margin-left:  100px;margin-top: -40px; font-size:10px;font-weight:bold"><?php
            $rif ="RIF: ".$fila['numero_fiscal'];
            echo  $rif; ?></span>
    </div>
    <div class="row">
    	<span style="margin-left:  100px;margin-top: -40px; font-size:10px;font-weight:bold;font-family: times, serif; font-style:italic"><?php echo $fila['eslogan'] ?></span>
        </div>
</div>
    










 