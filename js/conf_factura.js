
		$( "#form_numeracion" ).submit(function( event ) {
		  $('#guardar_numeracion').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/conf_factura/nueva_numeracion.php?action=ajax",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_ajuste").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_ajuste").html(datos);
					$('#guardar_numeracion').attr("disabled", true);
					load(1);
				  }
			});
		  event.preventDefault();
		})

		$( "#form_dimensiones" ).submit(function( event ) {
		  $('#guardar_dimensiones').attr("disabled", true);
		  
		 var parametros = $(this).serialize();
			 $.ajax({
					type: "POST",
					url: "ajax/conf_factura/nueva_dimension.php?action=ajax",
					data: parametros,
					 beforeSend: function(objeto){
						$("#resultados_ajax_ajuste").html("Mensaje: Cargando...");
					  },
					success: function(datos){
					$("#resultados_ajax_ajuste").html(datos);
					$('#guardar_dimensiones').attr("disabled", false);
					load(1);
				  }
			});
		  event.preventDefault();
		})					

		function ver_prueba()
		{
			//Generar PDF y mostrar factura en pantalla
			$.ajax({
				type: "GET",
				url: 'pdf/documentos/ver_prueba.php',
				beforeSend: function(objeto){
			 		$('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando prueba...');
			 	},
				success: function(datos){
				location.href ="prueba_factura";
		  		}
				});
		}
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });