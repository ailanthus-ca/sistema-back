
$( "#form_login" ).submit(function( event ) {
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/login/control_acceso.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Iniciando sesión...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
		  }
	});
	 
  event.preventDefault();
})


$( "#form_login" ).reset(function( event ) {

  event.preventDefault();
})