function option(value) {

    if (value === 'hoy') {
        $('#hoy').attr("disabled", false);
        $('#mes').attr("disabled", true);
        $('#fecha1').attr("disabled", true);
        $('#fecha2').attr("disabled", true);
        $('#otro').attr("disabled", true);
    }
    if (value === 'mes') {
        $('#mes').attr("disabled", false);
        $('#hoy').attr("disabled", true);
        $('#fecha1').attr("disabled", true);
        $('#fecha2').attr("disabled", true);
        $('#otro').attr("disabled", true);
    }
    if (value === 'rango') {
        $('#hoy').attr("disabled", true);
        $('#mes').attr("disabled", true);
        $('#fecha1').attr("disabled", false);
        $('#fecha2').attr("disabled", false);
        $('#otro').attr("disabled", true);
    }
    if (value === 'otro') {
        $('#hoy').attr("disabled", true);
        $('#mes').attr("disabled", true);
        $('#fecha1').attr("disabled", true);
        $('#fecha2').attr("disabled", true);
        $('#otro').attr("disabled", false);
    }


}

$(document).ready(function () {
    load(1);
});

function load(page) {
    cargar_producto(page);
}

function Seleccionar(id) {
    $('#cod').val(id);
    $('#des').val($('#'+id).contents('.col-md-5').html());
}

function cargar_producto(page) {
    var q = $("#q").val();
    var dp = $("#dp").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/reporte/productos.php?action=ajax&page=' + page + '&q=' + q + "&dp=" + dp,
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".productos").html(data).fadeIn('slow');
            $('#loader').html('');

        }
    });
}

function imprimir()
{
    var cod = $('#cod').val();
    var des = $('#des').val();
    var tipo = $("input:checked").val();
    if (tipo === 'hoy') {
        var f = new Date();
        hoy = (f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + f.getDate());
        mes = '';
        fecha1 = '';
        fecha2 = '';
        otro = '';
    } else if (tipo === 'mes') {
        hoy = '';
        mes = $('#mes').val();
        fecha1 = '';
        fecha2 = '';
        otro = '';
    } else if (tipo === 'rango') {
        hoy = '';
        mes = '';
        fecha1 = $('#fecha1').val();
        fecha2 = $('#fecha2').val();
        otro = '';
    } else if (tipo === 'otro') {
        hoy = '';
        mes = '';
        fecha1 = '';
        fecha2 = '';
        otro = $('#otro').val();
    }
    //VentanaCentrada('pdf/documentos/reporte_compras_pdf.php?hoy='+hoy+'&mes='+mes+'&fecha1='+fecha1+'&fecha2='+fecha2+'&otro='+otro,'Reporte','','1024','768','true');
    $.ajax({
        type: "POST",
        data: 'hoy=' + hoy + '&mes=' + mes + '&fecha1=' + fecha1 + '&fecha2=' + fecha2 + '&otro=' + otro + '&codigo=' + cod + '&des=' + des,
        url: 'pdf/documentos/reporte_historico_pdf.php',
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando reporte...');
        },
        success: function (datos) {
            location.href = "rep_historico";    //en servidor

        }
    });
}