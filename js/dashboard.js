
DolarGrafica();
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
//Medidor de punto de equilibrio
function drawChart_equi() {

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
function drawChart_util() {

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
function drawTable() {

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
function DolarGrafica() {
    $.ajax({
        type: 'POST',
        url: './api/Dolares/grafica',
        dataType: 'json',
        success: function (data) {
            var aux = [];
            for (var i = 7; i >= 0; i--) {
                var date = new Date();
                date.setDate(date.getDate() - i);
                date.setHours(11);
                aux.push(date);
                var date2 = new Date();
                date2.setDate(date.getDate() - i);
                date2.setHours(18);
                aux.push(date2);
            }
            var valores = [];
            var labels = aux.map(d => {
                var r = getFechaHora(d);
                var v = 0;
                data.forEach(f => {
                    var fecha = new Date(f.fecha);
                    if (fecha.getDate() === d.getDate()) {
                        if (fecha.getHours() < d.getHours()) {
                            r = getFechaHora(fecha);
                            v = f.valor;
                        }
                    }
                })
                valores.push(v);
                return r;
            })
            var datos = {
                labels,
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
            console.log(datos);
            var contexto = document.getElementById('dolar').getContext('2d');
            window.Line = new Chart(contexto).Line(datos, {responsive: true, fill: false});
        }
    });
    return false;
}


function getFechaHora(fecha) {
    return getFecha(fecha) + ' ' + getHora(fecha);
}

function getFecha(date) {
    var año = date.getFullYear();
    var mes = date.getMonth() + 1;
    var dia = date.getDate() + 1;
    return zfill(dia, 2) + '/' + zfill(mes, 2) + '/' + año;
}

function getHora(date) {
    let hora = date.getHours(),
            minuto = date.getMinutes(),
            segundo = date.getSeconds(),
            turno = ' AM';
    if (hora >= 12)
        turno = ' PM'
    if (hora > 12)
        hora = hora - 12;
    if (hora === 0)
        hora = hora + 12;
    return zfill(hora, 2) + ":" + zfill(minuto, 2) + ":" + zfill(segundo, 2) + turno;
}

function zfill(number, width = 6) {
    var numberOutput = Math.abs(number) /* Valor absoluto del número */
    var length = number.toString().length /* Largo del número */
    var zero = "0" /* String de cero */

    if (width <= length) {
        if (number < 0) {
            return ("-" + numberOutput.toString())
        } else {
            return numberOutput.toString()
        }
    } else {
        if (number < 0) {
            return ("-" + (zero.repeat(width - length)) + numberOutput.toString())
        } else {
            return ((zero.repeat(width - length)) + numberOutput.toString())
        }
}
}

function setDolar() {
    $.ajax({
        type: 'POST',
        url: './api/Dolares/set',
        dataType: 'json',
        data: {
            valor: document.getElementById('nuevaTasaDolar').value
        },
        success: function (data) {
            location.reload();
        }
    });
}