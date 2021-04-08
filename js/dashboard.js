//Charts Gauge Google, pto equilibrio
google.charts.load('current', {'packages': ['gauge']});
google.charts.setOnLoadCallback(drawChart_equi);
google.charts.setOnLoadCallback(drawChart_util);
//Chart table Google, cotizaciones pendientes
google.charts.load('current', {'packages': ['table']});
google.charts.setOnLoadCallback(drawTable);
//Chart bars Google, mejor mes
google.charts.load("current", {packages: ["corechart"]});
google.charts.setOnLoadCallback(drawChart);
DolarGrafica();

//Medidor de punto de equilibrio
function drawChart_equi(){

    $.ajax({
        type: 'POST',
        url: './ajax/widgets/equilibrio.php',
        success: function (data)
        {
            var datos = eval(data);
            var equi = parseFloat(datos[0]);
            var ventas = Math.floor(datos[1]);

            if (equi == 0)
            {
                var pto = prompt("Ingrese un punto de equilibrio:");
                if (pto == null || pto == "")
                {
                    ventas = 0;
                } else
                {
                    $.ajax({
                        type: 'POST',
                        data: 'pto=' + pto,
                        url: './ajax/widgets/equilibrio.php',
                        success: function (data)
                        {
                            drawChart_equi();
                        }
                    });
                }
            }

            var red_to = equi / 2;
            var yellow_from = red_to;
            var yellow_to = equi;
            var green_from = equi;
            var green_to = equi + equi * 0.3;

            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['', ventas]
            ]);

            var options =
                    {
                        width: 480, height: 180,
                        redFrom: 0, redTo: red_to,
                        yellowFrom: yellow_from, yellowTo: yellow_to,
                        greenFrom: green_from, greenTo: green_to,
                        max: green_to,
                        minorTicks: 5
                    };

            var chart = new google.visualization.Gauge(document.getElementById('chart_equi'));

            chart.draw(data, options);
        }
    });
}

//Medididor de utilidad promedio
function drawChart_util(){

    $.ajax({
        type: 'POST',
        url: './ajax/widgets/utilidad.php',
        success: function (data)
        {
            var datos = eval(data);
            var prom = parseFloat(datos[0]);


            var red_to = 10;
            var yellow_from = red_to;
            var yellow_to = 25;
            var green_from = yellow_to;
            var green_to = 50;

            var data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['%', prom]
            ]);

            var options = {
                width: 480, height: 180,
                redFrom: 0, redTo: red_to,
                yellowFrom: yellow_from, yellowTo: yellow_to,
                greenFrom: green_from, greenTo: green_to,
                max: green_to,
                minorTicks: 5
            };

            var chart = new google.visualization.Gauge(document.getElementById('chart_util'));

            chart.draw(data, options);
        }
    });
}

//Tabla de cotizaciones pendientes
function drawTable(){

    $.ajax({
        type: 'POST',
        url: './ajax/widgets/tabla_cot.php',
        success: function (data)
        {
            var datos = eval(data);

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Codigo');
            data.addColumn('string', 'Cliente');
            data.addColumn('string', 'Fecha');
            data.addColumn('number', 'Monto');
            if (datos[0]['usuario'] != undefined) {
                data.addColumn('string', 'Usuario')
                for (var i = 0; i < datos.length; i++)
                {
                    data.addRows([
                        [datos[i]['codigo'], datos[i]['nombre'], datos[i]['fecha'], {v: 10000, f: datos[i]['total']}, datos[i]['usuario']]
                    ]);
                }
            } else {
                for (var i = 0; i < datos.length; i++)
                {
                    data.addRows([
                        [datos[i]['codigo'], datos[i]['nombre'], datos[i]['fecha'], {v: 10000, f: datos[i]['total']}]
                    ]);
                }
            }

            var cssClassNames = {'headerRow': 'italic-darkblue-font large-font bold-font',
                'tableRow': '',
                'oddTableRow': 'beige-background',
                'selectedTableRow': 'orange-background large-font',
                'hoverTableRow': '',
                'headerCell': 'gold-border',
                'tableCell': '',
                'rowNumberCell': 'underline-blue-font'};

            var options = {'showRowNumber': true,
                'width': '100%',
                'height': '100%',
                'page': 'enable',
                'pageSize': 5,
                'cssClassNames': cssClassNames};

            var table = new google.visualization.Table(document.getElementById('table_div'));

            table.draw(data, options);

        }
    });

}

//Barras de comparacion del mes actual con el mejor mes
function drawChart()
{
    $.ajax({
        type: 'POST',
        url: './ajax/widgets/mejor_mes.php',
        success: function (data)
        {
            var datos = eval(data);
            var data = google.visualization.arrayToDataTable([
                ["Element", "Total", {role: "style"}],
                [datos[2], parseFloat(datos[1][0]), "blue"],
                [datos[3], parseFloat(datos[0][0]), "silver"],
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"},
                2]);

            var options = {
                title: datos[4],
                width: 480,
                height: 180,
                bar: {groupWidth: "95%"},
                legend: {position: "none"},
                hAxis: {minValue: 0}
            };
            var chart = new google.visualization.BarChart(document.getElementById("bar"));
            chart.draw(view, options);
        }
    });
}
function DolarGrafica(){
    $.ajax({
		type:'POST',
		url:'./ajax/graficas/graficar_ventas_dia.php',
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
			var contexto = document.getElementById('dolar').getContext('2d');

			window.Line = new Chart(contexto).Line(datos, {responsive: true, fill: false});

		}
	});
	return false;
}