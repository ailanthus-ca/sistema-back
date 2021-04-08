		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/usuario/buscar_usuarios.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}

	
		
		function eliminar (correo)
		{
			var q= $("#q").val();
		if (confirm("¿Realmente deseas eliminar este usuario?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/usuario/buscar_usuarios.php?action=eliminar",
        data: "correo="+correo,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}

		function activar (correo)
		{
			var q= $("#q").val();
		if (confirm("¿Deseas activar este usuario?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/usuario/buscar_usuarios.php?action=activar",
        data: "correo="+correo,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}		
		

	function ver_usuario(correo){
		console.log(correo);
		$("#carga").fadeIn('slow');
		$.ajax({
			url:"./ajax/usuario/ver_usuario.php?correo=" + correo,
			 beforeSend: function(objeto){
			 $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
		  },
			success:function(data){
				$(".edit").html(data).fadeIn('slow');
				$("#resultados_ajax").html('');
				$('#carga').html('');
				
			}
		})
	}

	$( "#form_editar_usuario" ).submit(function( event ) {
	  $('#guardar_cambios').attr("disabled", true);
	  
	 var parametros = $(this).serialize();
		 $.ajax({
				type: "POST",
				url: "ajax/usuario/editar_usuario.php",
				data: parametros,
				 beforeSend: function(objeto){
					$("#resultados_ajax_usuario").html("Mensaje: Cargando...");
				  },
				success: function(datos){
				$("#resultados_ajax").html(datos);
				$('#guardar_cambios').attr("disabled", false);
				load(1);
			  }
		});
		 
	  event.preventDefault();
	})