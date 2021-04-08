$(document).ready(function () {
    $("input[id=tipo][value='hoy']").prop("checked",true);
});
//validaciones

function option(value) {

    if (value == 'hoy')
    {
        $('#hoy').attr("disabled", false);
        $('#mes').attr("disabled", true);
        $('#fecha1').attr("disabled", true);
        $('#fecha2').attr("disabled", true);
        $('#otro').attr("disabled", true);
        $('#ano').attr("disabled", true);
    }
    if (value == 'mes')
    {
        $('#mes').attr("disabled", false);
        $('#ano').attr("disabled", false);
        $('#hoy').attr("disabled", true);
        $('#fecha1').attr("disabled", true);
        $('#fecha2').attr("disabled", true);
        $('#otro').attr("disabled", true);
    }
    if (value == 'rango')
    {
        $('#hoy').attr("disabled", true);
        $('#mes').attr("disabled", true);
        $('#fecha1').attr("disabled", false);
        $('#fecha2').attr("disabled", false);
        $('#otro').attr("disabled", true);
        $('#ano').attr("disabled", true);
    }
    if (value == 'otro')
    {
        $('#hoy').attr("disabled", true);
        $('#mes').attr("disabled", true);
        $('#fecha1').attr("disabled", true);
        $('#fecha2').attr("disabled", true);
        $('#otro').attr("disabled", false);
        $('#ano').attr("disabled", true);
    }


}

//reporte de compras

function reporte_compras() {

    var tipo = $("input:checked").val();
    if (tipo == 'hoy')
    {
        var f = new Date();
        hoy = (f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate());
        mes = '';
        fecha1 = '';
        fecha2 = '';
        otro = '';
    }

    if (tipo == 'mes')
    {
        hoy = '';
        mes = $('#mes').val();
        fecha1 = '';
        fecha2 = '';
        otro = '';
    }

    if (tipo == 'rango')
    {
        hoy = '';
        mes = '';
        fecha1 = $('#fecha1').val();
        fecha2 = $('#fecha2').val();
        otro = '';
    }
    if (tipo == 'otro')
    {
        hoy = '';
        mes = '';
        fecha1 = '';
        fecha2 = '';
        otro = $('#otro').val();
    }


    //VentanaCentrada('pdf/documentos/reporte_compras_pdf.php?hoy='+hoy+'&mes='+mes+'&fecha1='+fecha1+'&fecha2='+fecha2+'&otro='+otro,'Reporte','','1024','768','true');
    $.ajax({
        type: "POST",
        data: 'hoy=' + hoy + '&mes=' + mes + '&fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&otro=' + otro,
        url: 'pdf/documentos/reporte_compras_pdf.php',
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando reporte...');
        },
        success: function (datos) {
            location.href = "rep_compras";    //en servidor

        }
    });
}

//Reporte de ventas

function reporte_ventas()
{
    var tipo = $("input:checked").val();
    if (tipo == 'hoy') {
        var f = new Date();
        hoy = (f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate());
        mes = '';
        ano = '';
        fecha1 = '';
        fecha2 = '';
        otro = '';
    } else if (tipo == 'mes') {
        hoy = '';
        mes = $('#mes').val();
        ano = $('#ano').val();
        fecha1 = '';
        fecha2 = '';
        otro = '';
    } else if (tipo == 'rango') {
        hoy = '';
        mes = '';
        ano = '';
        fecha1 = $('#fecha1').val();
        fecha2 = $('#fecha2').val();
        otro = '';
    } else if (tipo == 'otro') {
        hoy = '';
        mes = '';
        ano = '';
        fecha1 = '';
        fecha2 = '';
        otro = $('#otro').val();
        ;
    }

    //VentanaCentrada('pdf/documentos/reporte_ventas_pdf.php?hoy='+hoy+'&mes='+mes+'&fecha1='+fecha1+'&fecha2='+fecha2+'&otro='+otro,'Reporte','','1024','768','true');
    $.ajax({
        type: "POST",
        data: {'hoy': hoy, 'mes': mes, 'ano': ano, 'fecha1': fecha1, 'fecha2': fecha2, 'otro': otro},
        url: 'pdf/documentos/reporte_ventas_pdf.php',
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando reporte...');
        },
        success: function (datos) {
            //location.href ="ailanthus/%202017/rep_ventas.php"; //en 192.168.1.32/ailanthus/
            location.href = "rep_ventas";    //en servidor
        }
    });
}
;


//reporte de inventario

function reporte_inventario() {

    var dp = $('#dp').val();
    var tipo = $("input:checked").val();
    var cero = document.getElementById("cero").checked;
    //VentanaCentrada('pdf/documentos/reporte_inventario_pdf.php?tipo='+tipo,'Reporte','','1024','768','true');
    $.ajax({
        type: "POST",
        data: 'tipo=' + tipo + '&cero=' + cero + '&dp=' + dp,
        url: 'pdf/documentos/reporte_inventario_pdf.php',
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando reporte...');
        },
        success: function (datos) {
            //location.href ="ailanthus/%202017/rep_inventario.php";  //en 192.168.1.32/ailanthus/
            window.location.href = "rep_inventario";     //en servidor
        }
    });

}
;
function reporte_vendedor()
{
    var ven = $("#ven").val();
    var tipo = $("input:checked").val();
    if (tipo == 'hoy')
    {
        var f = new Date();
        hoy = (f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate());
        mes = '';
        fecha1 = '';
        fecha2 = '';
        otro = '';
    }

    if (tipo == 'mes')
    {
        hoy = '';
        mes = $('#mes').val();
        fecha1 = '';
        fecha2 = '';
        otro = '';
    }

    if (tipo == 'rango')
    {
        hoy = '';
        mes = '';
        fecha1 = $('#fecha1').val();
        fecha2 = $('#fecha2').val();
        otro = '';
    }
    if (tipo == 'otro')
    {
        hoy = '';
        mes = '';
        fecha1 = '';
        fecha2 = '';
        otro = $('#otro').val();
    }
    if (ven != 0) {
        ur = 'pdf/documentos/reporte_vendedor_pdf.php';
    } else {
        ur = 'pdf/documentos/reporte_vendedores_pdf.php'
    }

    $.ajax({
        type: "POST",
        data: {'hoy': hoy, 'mes': mes, 'ano': ano, 'fecha1': fecha1, 'fecha2': fecha2, 'otro': otro, 'user': ven},
        url: ur,
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando reporte...');
        },
        success: function (datos) {
            if (ven != 0) {
                location.href = "rep_vendedor";
            } else {
                location.href = "rep_vender";
            }
            //en servidor
        }
    });
    //VentanaCentrada('pdf/documentos/reporte_ventas_pdf.php?hoy='+hoy+'&mes='+mes+'&fecha1='+fecha1+'&fecha2='+fecha2+'&otro='+otro,'Reporte','','1024','768','true');

}
;