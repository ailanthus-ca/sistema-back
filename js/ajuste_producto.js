$(document).ready(function () {
    load(1);
    $("#dpt").prop('disabled', true);
    $("#pdt").prop('disabled', true);
});

function load(page) {
    var q = $("#q").val();
    var dp = $("#dp").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/cotizacion/Buscar_producto.php?action=ajax&page=' + page + '&q=' + q + "&dp=" + dp,
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}

function sumit() {
    var c = document.getElementById('codigo').value;
    var d = document.getElementById('dpt').value;
    var n = document.getElementById('numero').value;
    var o = document.getElementById('operacion').value;
    if (c != "") {
        var parametros = "cod='" + c + "'";
    } else if (d != "") {
        var parametros = "dpt='" + d + "'";
    } else {
        var parametros = "td='td'";
    }
    $.ajax({
        url: "ajax/producto/actualizar.php",
        data: parametros + "&num=" + n + "&ope=" + o,
        beforeSend: function (objeto) {
            $("#rpt").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#rpt").html(datos);
        }
    });
}


function validar(valor) {
    var d = valor.value;
    if (d == 'td') {
        $("#dpt").prop('disabled', true);
        $("#pdt").prop('disabled', true);
        $("#codigo").val("");
        $("#des").val("");
        $("#dpt").val("");
    } else if (d == 'dp') {
        $("#dpt").prop('disabled', false);
        $("#pdt").prop('disabled', true);
        $("#codigo").val("");
        $("#des").val("");
    } else if (d == 'pd') {
        $("#dpt").prop('disabled', true);
        $("#pdt").prop('disabled', false);
        $("#dpt").val("");
    }
}

function Seleccionar(cod) {
    $("#codigo").val(cod);
    $('#des').val($('#'+cod).contents('.col-md-5').html());
    $('#myModal').modal('hide');
}

$("#numero").on('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});
function cargar_producto(page){
    load(page);
}