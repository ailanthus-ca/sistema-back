		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/proveedor/buscar_proveedores.php?action=ajax&page='+page+'&q='+q,
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

	
		
		function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("¿Realmente deseas eliminar este proveedor?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/proveedor/buscar_proveedores.php?action=eliminar",
        data: "id="+id,"q":q,
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

		function activar (id)
		{
			console.log(id);
			var q= $("#q").val();
		if (confirm("¿Deseas activar este proveedor?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/proveedor/buscar_proveedores.php?action=activar",
        data: "id="+id,"q":q,
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
		

	function editar_proveedor(id){
		$("#carga").fadeIn('slow');
		$.ajax({
			url:"./ajax/proveedor/ver_editarproveedor.php?id=" + id,
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

	function ver_proveedor(id){
		$("#carga").fadeIn('slow');
		$.ajax({
			url:"./ajax/proveedor/ver_proveedor.php?id=" + id,
			 beforeSend: function(objeto){
			 $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
		  },
			success:function(data){
				$(".detalle").html(data).fadeIn('slow');
				$('#carga').html('');
				
			}
		})
	}

	$( "#form_editar_proveedor" ).submit(function( event ) {
	  $('#guardar_cambios').attr("disabled", true);
	  
	 var parametros = $(this).serialize();
		 $.ajax({
				type: "POST",
				url: "ajax/proveedor/editar_proveedor.php",
				data: parametros,
				 beforeSend: function(objeto){
					$("#resultados_ajax").html("Mensaje: Cargando...");
				  },
				success: function(datos){
				$("#resultados_ajax").html(datos);
				$('#guardar_cambios').attr("disabled", false);
				var obj = document.getElementById("btn_modalEditarProveedor");
				obj.click();					
				load(1);
			  }
		});
		 
	  event.preventDefault();
	})