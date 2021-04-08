$(document).ready(function()
{

    $('[data-toggle="tooltip"]').tooltip();
	if ($("input[name=impuesto_esp]:checked").val()=="1") 
	{
		//habulita campos
		$('#impuesto1').attr("disabled", false);
		$('#impuesto2').attr("disabled", false);
		$('#hasta').attr("disabled", false);
		$('#mayor').attr("disabled", false);
	}
	else
	{
		//inhabilita campos
		$('#impuesto1').attr("disabled", true);
		$('#impuesto2').attr("disabled", true);
		$('#hasta').attr("disabled", true);
		$('#mayor').attr("disabled", true);

		//limpiar campos
		$('#impuesto1').val("");
		$('#impuesto2').val("");
		$('#hasta').val("");
		$('#mayor').val("");						
	}	
	
});

$( "#form_region" ).submit(function( event ) {
  $('#guardar').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/conf_region/nueva_region.php?action=ajax",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})


function imp(value)
{
	if (value=="1") 
	{
		//habulita campos
		$('#impuesto1').attr("disabled", false);
		$('#impuesto2').attr("disabled", false);
		$('#hasta').attr("disabled", false);
		$('#mayor').attr("disabled", false);
	}
	else
	{
		//inhabilita campos
		$('#impuesto1').attr("disabled", true);
		$('#impuesto2').attr("disabled", true);
		$('#hasta').attr("disabled", true);
		$('#mayor').attr("disabled", true);

		//limpiar campos
		$('#impuesto1').val("");
		$('#impuesto2').val("");
		$('#hasta').val("");
		$('#mayor').val("");						
	}	
}