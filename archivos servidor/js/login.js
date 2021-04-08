
$( "#form_login" ).submit(function( event ) {
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/login/control_acceso.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Iniciando sesión");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			if (datos==0) 
			{
				location.href ="http://ailanthus-sistems.com/sistema/panel_ad";
			}
			if (datos==1)
			{
				location.href ="http://ailanthus-sistems.com/sistema/panel_us";
			}
		  }
	});
	 
  event.preventDefault();
})


$( "#form_login" ).reset(function( event ) {
  
console.log('reset');
	 
  event.preventDefault();
})