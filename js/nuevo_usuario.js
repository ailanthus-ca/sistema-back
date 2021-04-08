$(document).ready(function(){
	
	$('#nombre').focus();

});


$( "#guardar_usuario" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", false);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/usuario/nuevo_usuario.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_usuario").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_usuario").html(datos);
			$('#guardar_datos').attr("disabled", false);
			document.getElementById("guardar_usuario").reset();
			document.getElementById("nombre").focus();
		  }
	});
	 
  event.preventDefault();
})


function ValidarEspacio(e, campo){
  key = e.keyCode ? e.keyCode : e.which;
  if (key == 32) {return false;}
}