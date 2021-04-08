var fecha = new Date();
var ano = fecha.getFullYear();

$(document).ready(graficar());

function graficar()
{
    //$("#loader").fadeIn('slow');
    var año = $("#a�o�o").val();
    var user = $("#user").val();
    $.ajax({
        type: 'GET',
        url:'./ajax/graficas/graficar_vendedor.php?año=' + año + '&user=' + user,
                //beforeSend: function(objeto){
                //$('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
                //},
                success: function (data) {
                    //$(".outer_div").html(data).fadeIn('slow');
                    //$('#loader').html('');
                    //$('[data-toggle="tooltip"]').tooltip({html:true});
                    var valores = eval(data);
                    var ene = valores[0];
                    var feb = valores[1];
                    var mar = valores[2];
                    var abr = valores[3];
                    var may = valores[4];
                    var jun = valores[5];
                    var jul = valores[6];
                    var ago = valores[7];
                    var sep = valores[8];
                    var oct = valores[9];
                    var nov = valores[10];
                    var dic = valores[11];

                    var datos = {
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        datasets: [
                            {
                                fillColor: 'rgba(91,228,146,0.6)', //color de las barras
                                strokeColor: 'rgba(57,194,112,0.7)', //color del borde de las barras
                                highlightFill: 'rgba(73,206,180,0.6)', //color de hover de las barras --al pasar el puntero por las barras
                                highlightStroke: 'rgba(66,196,157,0.7)', //color hover del borde de las barras
                                data: [ene, feb, mar, abr, may, jun, jul, ago, sep, oct, nov, dic]
                            }
                        ]
                    }
                    var contexto = document.getElementById('grafico').getContext('2d');
                    window.Barra = new Chart(contexto).Bar(datos, {responsive: true});
                }
    });
    return false;
}