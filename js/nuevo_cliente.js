	   $(document).ready(function(){
			
			//$('#codigo').focus();

		});

		$( "#form_cliente" ).submit(function( event ) {
		  $('#guardar').attr("disabled", false);

		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/cliente/nuevo_cliente.php",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax").html(datos);
					$('#guardar_datos').attr("disabled", false);
					document.getElementById("form_cliente").reset();			
					$('#codigo').focus();
									  }
			});
			 
		  event.preventDefault();
		})

function option(value) 
{
	if (value=='ordinario') 
	{
		$('#retencion').attr("disabled", false);
		$('#retencion').attr("readonly", true);
		$('#retencion').val("");	
	}
	if (value=='especial')
	{
		$('#retencion').attr("disabled", false);
		$('#retencion').attr("readonly", false);
	}	
}
