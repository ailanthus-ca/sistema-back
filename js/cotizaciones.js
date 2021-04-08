$(document).ready(function () {
    load(1);
    cargar_producto(1);
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/cotizacion/buscar_cotizaciones.php?action=ajax&page=' + page + '&q=' + q,
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

function eliminar(id) {
    var q = $("#q").val();
    if (confirm("¿Realmente deseas eliminar la cotizacion?")) {
        $.ajax({
            type: "GET",
            url: "./ajax/cotizacion/buscar_cotizaciones.php",
            data: "id=" + id, "q": q,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
                load(1);
            }
        });
    }
}

function imprimir_cotizacion(id_cotizacion) {
    $.ajax({
        type: "GET",
        url: './pdf/documentos/ver_cotizacion.php?id_cotizacion=' + id_cotizacion,
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando cotización...');
        },
        success: function (datos) {
            location.href = "cotizacion";
        }
    });
}

function seguimiento_cotizacion(id_cotizacion) {
    $("#cargaSeguimiento").fadeIn('slow');
    $.ajax({
        url: "./ajax/cotizacion/ver_seguimiento_cotizacion.php?id=" + id_cotizacion,
        beforeSend: function (objeto) {
            $('#cargaSeguimiento').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".detalleSeguimiento").html(data).fadeIn('slow');
            $('#cargaSeguimiento').html('');
        }
    });
}

function nuevo_seguimiento(id, id_usuario) {
    console.log(id_usuario);
    var comentario = document.getElementById('comentario' + id).value;
    console.log(comentario);

    $.ajax({
        type: "POST",
        url: "./ajax/cotizacion/nuevo_seguimiento.php",
        data: "id=" + id + "&comentario=" + comentario + "&id_usuario=" + id_usuario,
        beforeSend: function (objeto) {
            $("#resultado_comentario").html("Mensaje: Cargando...");
        },
        success: function (datos) {

            $.ajax({
                url: "./ajax/cotizacion/ver_seguimiento_cotizacion.php?id=" + id,
                beforeSend: function (objeto) {
                    $('#cargaSeguimiento').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
                },
                success: function (data) {
                    $(".detalleSeguimiento").html(data).fadeIn('slow');
                    $('#cargaSeguimiento').html('');

                }
            });
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
    $('#q').val($('#'+id).contents('.col-md-5').html());
    cargar_cotizaciones(1);
    $('#historico').modal('hide');
}

function cargar_cotizaciones(page) {
    var cod = $("#cod").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/cotizacion/buscar_cotizaciones_producto.php',
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