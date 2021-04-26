<page_header>
    <div class="col-12">
        <div style="width: 50px; height: 50px;top: 5px;left: 10px;position: absolute">
            <img style="width: 100%; height: 100%;" src="../public/imagenes/<?php echo $company['logo']; ?>" alt="Logo"> 
        </div>
        <div class="col-11 col-offset-1" style="font-size:8px;">
            <span class="text-encabezado" style="font-size:16px;"><?php echo $company['nombre'] ?></span><br>
            <span class="text-encabezado" style="font-size:10px;"><?php echo $company['eslogan'] ?></span><br>
            <span class="text-encabezado"><?php echo $region['cod_fiscal'] . " " . $company['numero_fiscal'] ?></span>
        </div>
        <hr style="margin-top: -5px"/>
    </div>
</page_header>