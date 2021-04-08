		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/orden_compra/buscar_ordenes.php?action=ajax&page='+page+'&q='+q,
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
            $("#cargaO").fadeIn('slow');
            $.ajax({
                url:"./ajax/orden_compra/ver_detalleorden.php?id=" + id,
                beforeSend: function(objeto){
                    $('#cargaO').html('<img src="../../public/imagenes/ajax-loader.gif"> Cargando...');
                },
                success:function(data){
                    $(".detalleO").html(data).fadeIn('slow');
                    $('#cargaO').html('');

                }
            })
        }
	
		
		function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("¿Realmente deseas eliminar la orden?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/orden_compra/buscar_ordenes.php",
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
		
		function imprimir_orden(id_orden){
			//Generar PDF y mostrar factura en pantalla
			$.ajax({
				type: "GET",
				url: 'pdf/documentos/ver_orden.php?id_orden='+id_orden,
				beforeSend: function(objeto){
			 		$('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando orden de compra...');
			 	},
				success: function(datos){
				location.href ="orden";
		  		}
				});

		}
        function seguimiento_cotizacion(id_cotizacion){
            $("#cargaSeguimiento").fadeIn('slow');
            $.ajax({
                url:"./ajax/orden_compra/ver_seguimiento_ordenes.php?id=" + id_cotizacion,
                beforeSend: function(objeto){
                    $('#cargaSeguimiento').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
                },
                success:function(data){
                    $(".detalleSeguimiento").html(data).fadeIn('slow');
                    $('#cargaSeguimiento').html('')
                }
            })
        }
        function nuevo_seguimiento(id, id_usuario)
        {
            var comentario=document.getElementById('comentario'+id).value;

            $.ajax({
                type: "POST",
                url: "./ajax/orden_compra/nuevo_seguimiento.php",
                data: "id="+id+"&comentario="+comentario+"&id_usuario="+id_usuario,
                beforeSend: function(objeto){
                    $("#resultado_comentario").html("Mensaje: Cargando...");
                },
                success: function(datos){

                    $.ajax({
                        url:"./ajax/cotizacion/ver_seguimiento_cotizacion.php?id=" + id,
                        beforeSend: function(objeto){
                            $('#cargaSeguimiento').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
                        },
                        success:function(data){
                            $(".detalleSeguimiento").html(data).fadeIn('slow');
                            $('#cargaSeguimiento').html('');

                        }
                    })
                }
            });
        }