<div>
	<div class="row">
	    <div style="width: 50px; height: 50px;">
	        <img style="width: 100%; height: 100%;" src="../../public/imagenes/<?php echo $fila['logo']; ?>" alt="Logo"> 
	    </div>
	    <span style="margin-left: 70px;margin-top: -40px; font-size:16px;font-weight:bold"><?php echo $fila['nombre'] ?></span>
    </div>
    <div class="row">
    	<span style="margin-left:  70px;margin-top: -20px; font-size:10px;font-weight:bold"><?php echo $fila['eslogan'] ?></span>
        </div>
    <div class="row">
        <span style="margin-left:550px;"><?php
            $fecha ="Fecha:".date("d-m-Y");
            echo $fecha; ?></span>
    </div>
    <div class="row">
		<span style="margin-left: 550px;"><?php
            $rif ="RIF: ".$fila['numero_fiscal'];
            echo  $rif; ?></span>
    </div>
</div>
    










 