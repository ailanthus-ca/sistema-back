		$(document).ready(function(){
			load(1);
			
			
		});

		function load(page){
			console.log("primer log");
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/seguimiento/productos_seguimiento.php?action=ajax&page='+page+'&q='+q,
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

		function loadS(page,id){
			console.log('paginate');
			console.log(id);
			$("#cargaS").fadeIn('slow');
			$.ajax({
				url:'./ajax/seguimiento/ver_seguimiento.php?action=ajax&page='+page+'&id='+id,
				 beforeSend: function(objeto){
				 $('#cargaS').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".div_ajax").html(data).fadeIn('slow');
					$('#cargaS').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}
		

	function ver_seguimiento(id){
		console.log(id);
		$("#carga").fadeIn('slow');
		$.ajax({
			url:"./ajax/seguimiento/ver_seguimiento.php?action=ajax&id="+id,
			 beforeSend: function(objeto){
			 $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
		  },
			success:function(data){
				$(".div_ajax").html(data).fadeIn('slow');
				$("#resultados_ajax").html('');
				$('#carga').html('');
				
			}
		})
	}

	function imprimir_seguimiento(id)
	{
		//VentanaCentrada('./pdf/documentos/reporte_seguimiento.php?id_prod='+id,'Seguimiento','','1024','768','true');
  		$.ajax({
    		type: "POST",
    		data: 'id_prod='+id,
    		url: 'pdf/documentos/reporte_seguimiento.php',
     		beforeSend: function(objeto){
      			$('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando reporte...');
      		},
    		success: function(datos){
      		//location.href ="ailanthus/%202017/rep_seguimiento.php";	//en 192.168.1.32/ailanthus/
			location.href ="rep_seguimiento";		//en servidor
      		}
  });		
	}