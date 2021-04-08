		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/compra/buscar_compras.php?action=ajax&page='+page+'&q='+q,
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

        function ver_detalle(id){
            console.log(id);
            $("#cargaCompra").fadeIn('slow');
            $.ajax({
                url:"./ajax/compra/ver_detallecompra.php?id=" + id,
                beforeSend: function(objeto){
                    $('#cargaCompra').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
                },
                success:function(data){
                    $(".detalleCompra").html(data).fadeIn('slow');
                    $('#cargaCompra').html('');

                }
            })
        }
		
		function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("¿Realmente deseas cancelar la compra? este proceso es irreversible")){	
		$.ajax({
        type: "GET",
        url: "./ajax/compra/buscar_compras.php",
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
		
		function imprimir_compra(id_compra){
			//Generar PDF y mostrar factura en pantalla
			$.ajax({
				type: "GET",
				url: 'pdf/documentos/ver_compra.php?id_compra='+id_compra,
				beforeSend: function(objeto){
			 		$('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando compra...');
			 	},
				success: function(datos){
				location.href ="compra";
		  		}
				});
		}
