$(document).ready(function () {
    cargar_producto(1);

});

function cargar_producto(page) {
    var dp = $("#dp").val();
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/producto/buscar_productos.php?action=ajax&page=' + page + '&q=' + q + "&dp=" + dp,
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
            $('[data-toggle="tooltip"]').tooltip({html: true});

        }
    })
}



function eliminar(id)
{
    var q = $("#q").val();
    if (confirm("¿Realmente deseas eliminar este producto?")) {
        $.ajax({
            type: "GET",
            url: "./ajax/producto/buscar_productos.php?action=eliminar",
            data: "id=" + id, "q": q,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
                cargar_producto(1);
            }
        });
    }
}

function activar(id)
{
    console.log(id);
    var q = $("#q").val();
    if (confirm("¿Deseas activar este producto?")) {
        $.ajax({
            type: "GET",
            url: "./ajax/producto/buscar_productos.php?action=activar",
            data: "id=" + id, "q": q,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
                cargar_producto(1);
            }
        });
    }
}

function editar_producto(id) {
    console.log(id);
    $("#carga").fadeIn('slow');
    $.ajax({
        url: "./ajax/producto/ver_editarproducto.php?id=" + id,
        beforeSend: function (objeto) {
            $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".edit").html(data).fadeIn('slow');
            $("#resultados_ajax").html('');
            $('#carga').html('');

        }
    })
}

function ver_producto(id) {
    console.log(id);
    $("#carga").fadeIn('slow');
    $.ajax({
        url: "./ajax/producto/ver_producto.php?id=" + id,
        beforeSend: function (objeto) {
            $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".detalle").html(data).fadeIn('slow');
            $("#resultados_ajax").html('');
            $('#carga').html('');

        }
    })
}

$("#form_editar_producto").submit(function (event) {
    $('#guardar_cambios').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/producto/editar_producto.php",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_cambios').attr("disabled", false);
            var obj = document.getElementById("btn_modalEditarProducto");
            obj.click();
            cargar_producto(1);
        }
    });

    event.preventDefault();
})