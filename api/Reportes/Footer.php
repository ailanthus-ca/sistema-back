<page_footer backtop="20">
    <div class="col-6" style="padding: 0 0 0 0; text-align: left;font-weight:bold; font-size: 8px;">
        <span>RESPONSABLE: <?php echo $_SESSION['usuario']; ?></span>	
    </div>
    <div class="col-6" style="padding: 0 0 0 0;text-align: right;font-weight:bold; font-size: 8px;">
        PÁGINA [[page_cu]] DE [[page_nb]]
    </div>
    <hr>
    <div class="row" style="text-align: center; font-size: 10px;">
        <span> <?php echo $company['direccion']; ?> </span>
    </div>
    <div class="row" style="text-align: center; font-size: 10px;">
        <span><?php echo $company['telefono']; ?></span>	
    </div>
    <div class="row" style="padding: 0 0 0 0;text-align: center;font-weight:bold; font-size: 10px;">
        <span><?php echo $company['web']; ?></span>	
    </div>	
</page_footer>