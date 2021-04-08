$(document).ready(function(){
	load(1);
	
});

function load(page){
	var q= $("#q").val();
	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/factura/buscar_facturas.php?action=ajax&page='+page+'&q='+q,
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
	if (confirm("¿Realmente deseas cancelar la factura? este proceso es irreversible")){	
		$.ajax({
		type: "GET",
		url: "./ajax/factura/buscar_facturas.php",
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

function imprimir_factura(id_factura){
	//Generar PDF y mostrar factura en pantalla
	$.ajax({
		type: "GET",
		url: 'pdf/documentos/ver_factura.php?id_factura='+id_factura,
		beforeSend: function(objeto){
	 		$('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando factura...');
	 	},
		success: function(datos){
		location.href ="factura";
  		}
		});
}

function ver_detalle(id){
console.log(id);
$("#carga").fadeIn('slow');
$.ajax({
	url:"./ajax/factura/ver_detallefactura.php?id=" + id,
	 beforeSend: function(objeto){
	 $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
  },
	success:function(data){
		$(".detalle").html(data).fadeIn('slow');
		$('#carga').html('');
		
	}
})
}