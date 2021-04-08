$(document).ready(function () {
    load(1);
    cargar_producto(1);
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/notas/list.php',
        data: {page: page, q: q},
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('[data-toggle="tooltip"]').tooltip({html: true});
        }
    });
}

function eliminar(id) {
    var q = $("#q").val();
    if (confirm("¿Realmente deseas eliminar la nota de entrega?")) {
        $.ajax({
            type: "GET",
            url: "./ajax/notas/eliminar.php",
            data: {id: id, q: q},
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
                setTimeout(load(1), 10000);
            }
        });
    }
}

function imprimir_nota(id) {
    $.ajax({
        type: "GET",
        url: './pdf/documentos/ver_notasalida.php',
        data: {id: id},
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando cotización...');
        },
        success: function (datos) {
            location.href = "nota";
        }
    });
}

function cargar_producto(page) {
    var q = $("#des").val();
    var dp = $("#dp").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/cotizacion/Buscar_producto.php',
        data: {'action': 'ajax', 'page': page, 'q': q, 'dp': dp},
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".productos").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    });
}

function Seleccionar(id) {
    $('#cod').val(id);
    $('#q').val($('#' + id).contents('.col-md-5').html());
    cargar_cotizaciones(1);
    $('#historico').modal('hide');
}

function cargar_cotizaciones(page) {
    var cod = $("#cod").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/notas/list_producto.php',
        data: {'page': page, 'Producto': cod},
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
            $('[data-toggle="tooltip"]').tooltip({html: true});
        }
    });
}

function ver_detalle(id) {
    $("#cargaC").fadeIn('slow');
    $.ajax({
        url: "./ajax/notas/ver_detalle.php?id=" + id,
        beforeSend: function (objeto) {
            $('#cargaC').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".detalleC").html(data).fadeIn('slow');
            $('#cargaC').html('');
        }
    });
}