
$(document).ready(function () {
    load(1);
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/ajuste_precio/productos_ajustePre.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function (objeto) {
            $('#loader').html('<img src="public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');

        }
    })
}

$("#ajuste_todos").submit(function (event) {
    $('#guardar_ajusteT').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/ajuste_precio/nuevo_ajuste.php?action=individual",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax_ajuste").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax_ajuste").html(datos);
            $('#guardar_ajusteT').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})

$("#ajuste_general").submit(function (event) {
    $('#guardar_ajusteG').attr("disabled", false);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/ajuste_precio/nuevo_ajuste.php?action=general",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax_ajuste").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax_ajuste").html(datos);
            $('#guardar_ajusteG').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})

function ajuste_producto(id)
{
    if (confirm("¿Desea cambiar el precio al producto seleccionado?"))
    {
        var precio1 = document.getElementById('precio1_' + id).value;
        var precio2 = document.getElementById('precio2_' + id).value;
        var precio3 = document.getElementById('precio3_' + id).value;
        $.ajax
                ({
                    type: "POST",
                    url: "./ajax/ajuste_precio/nuevo_ajuste.php",
                    data: {'id': id, 'precio1': precio1, 'precio2': precio2, 'precio3': precio3},
                    beforeSend: function (objeto)
                    {
                        $("#resultados_ajax_ajuste").html("Mensaje: Cargando...");
                    },
                    success: function (datos)
                    {
                        $("#resultados_ajax_ajuste").html(datos);
                        load(1);
                    }
                });
    }
}		