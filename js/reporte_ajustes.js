function option(value)
{

	if (value=='hoy') 
	{
		$('#hoy').attr("disabled", false);
		$('#mes').attr("disabled", true);
		$('#fecha1').attr("disabled", true);
		$('#fecha2').attr("disabled", true);
		$('#otro').attr("disabled", true);	
	}
	if (value=='mes') 
	{
		$('#mes').attr("disabled", false);
		$('#hoy').attr("disabled", true);
		$('#fecha1').attr("disabled", true);
		$('#fecha2').attr("disabled", true);
		$('#fecha1').val('');
		$('#fecha2').val('');
		$('#otro').attr("disabled", true);	
	}
	if (value=='rango') 
	{
		$('#hoy').attr("disabled", true);
		$('#mes').attr("disabled", true);
		$("#mes").val('0');
		$('#fecha1').attr("disabled", false);
		$('#fecha2').attr("disabled", false);
		$('#otro').attr("disabled", true);	
	}
	if (value=='otro') 
	{
		$('#hoy').attr("disabled", true);
		$('#mes').attr("disabled", true);
		$('#fecha1').attr("disabled", true);
		$('#fecha2').attr("disabled", true);
		$('#otro').attr("disabled", false);	
	}		
	
	
}


$(document).ready(function(){
	load(1);
	
});

function load(){
	var page = 1;
	console.log(tipo);
	//var tipo = document.getElementById('tipo_ajuste').value;
	var tipo = $('input[name=tipo_ajuste]:checked', '#reporte_ajustes').val()
	var fecha1 = document.getElementById('fecha1').value;
	var fecha2 = document.getElementById('fecha2').value;
	var mes = document.getElementById('mes').value;

	$("#loader").fadeIn('slow');
	$.ajax({
		url:'./ajax/reporte_ajustes/buscar_ajustes.php?action=ajax&page='+page+'&tipo='+tipo+'&mes='+mes+'&fecha1='+fecha1+'&fecha2='+fecha2,
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

function imprimir_ajuste(id_ajuste){
	//VentanaCentrada('./pdf/documentos/reporte_ajustes_pdf.php?id_ajuste='+id_ajuste,'Ajustes','','1024','768','true');
	$.ajax({
		type: "POST",
		data: 'id_ajuste='+id_ajuste,
		url: 'pdf/documentos/reporte_ajustes_pdf.php',
		 beforeSend: function(objeto){
		 	$('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando reporte...');
		  },
		success: function(datos){
			//en 192.168.1.32/ailanthus/
			//location.href ="ailanthus/%202017/rep_ajustes.php";
			//en servidor
			location.href ="rep_ajustes";
	  	}
	});		
}
