var fecha = new Date();
var ano = fecha.getFullYear();

$(document).ready(graficar(ano));

function graficar(año){
	
	$.ajax({
		type:'POST',
		url:'./ajax/graficas/graficar_ventas_dia.php',
		data:'año='+año,
		success:function(data){
		var valores = eval(data);
		var datos = {
			labels: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16',
					 '17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'],
			datasets: [
					{
						fillColor: 'rgba(91,228,146,0.6)', //color de las barras
						strokeColor: 'rgba(57,194,112,0.7)', //color del borde de las barras
						highlightFill: 'rgba(73,206,180,0.6)', //color de hover de las barras --al pasar el puntero por las barras
						highlightStroke: 'rgba(66,196,157,0.7)', //color hover del borde de las barras
						data: valores
					}
			]
		};
			var contexto = document.getElementById('grafico').getContext('2d');

			window.Line = new Chart(contexto).Line(datos, {responsive: true, fill: false});

		}
	});
	return false;
}