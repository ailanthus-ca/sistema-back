
$(document).ready(function () {
    load(1);
});

function load(page) {
    cargar_producto(page);
}

function editarProducto(id) {

    var cantidad = document.getElementById('cantidad' + id).value;
    var descripcion = document.getElementById('descripcion' + id).value;

    if (isNaN(cantidad))
    {
        alert('La cantidad debe ser un valor numerico entero');
        document.getElementById('cantidad' + id).focus();
        return false;
    }
    //Fin validacion

    $.ajax({
        type: "POST",
        url: "./ajax/ajuste_inventario/agregar_ajuste.php",
        data: "id=" + id + "&descripcion=" + descripcion + "&cantidad=" + cantidad,
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
        }
    });
}

function agregar_producto(id) {
    var cantidad = document.getElementById('cantidad_' + id).value;
    var descripcion = document.getElementById('descripcion_' + id).value;
    var tipo = document.getElementById('tipo_ajuste').value;
    var stock = document.getElementById('stock_' + id).value;


    if (tipo == "SALIDA" && parseInt(cantidad) > parseInt(stock))
    {
        alert("En la salida la cantidad no puede ser mayor al stock. Por favor modifique la cantidad");
        document.getElementById('cantidad_' + id).focus();
        return  false;
    }

    if (tipo == "0")
    {
        alert("Debe seleccionar un tipo de ajuste");
        return false;
    }


    //Inicia validacion
    if (descripcion == "")
    {
        alert('Ingrese una descripcion para el ajuste');
        document.getElementById('descripcion_' + id).focus();
        return false;
    }
    if (isNaN(cantidad) || cantidad == "")
    {
        alert('Debe ingresar un valor en la cantidad');
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    //Fin validacion

    $.ajax({
        type: "POST",
        url: "./ajax/ajuste_inventario/agregar_ajuste.php",
        data: "id=" + id + "&descripcion=" + descripcion + "&cantidad=" + cantidad,
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            $("#guardar_ajuste").attr("disabled", false);
        }
    });
}

function eliminar(id) {
    $.ajax({
        type: "GET",
        url: "./ajax/ajuste_inventario/eliminar.php",
        data: "id=" + id,
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            var check = $('#check').val();
            if (check == "true") {
                $("#guardar_ajuste").attr("disabled", false);
            } else {
                $("#guardar_ajuste").attr("disabled", true);
            }
        }
    });

}

$("#datos_ajuste").submit(function () {

    $('#guardar_ajuste').attr("disabled", false);

    var tipo_ajuste = $("#tipo_ajuste").val();

    //guardar en la bd con ajax
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: './ajax/ajuste_inventario/nuevo_ajusteinv.php?tipo_ajuste=' + tipo_ajuste,
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax").html("Mensaje: Cargando...");
            event.preventDefault();
        },
        success: function (datos) {
            $.ajax({
                type: "POST",
                data: 'id_ajuste=' + datos,
                url: 'pdf/documentos/reporte_ajustes_pdf.php',
                beforeSend: function (objeto) {
                    $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando reporte...');
                },
                success: function (datos) {
                    //en 192.168.1.32/ailanthus/
                    //location.href ="ailanthus/%202017/rep_ajustes.php";
                    //en servidor
                    location.href = "rep_ajustes";
                }
            });
        }
    });
    event.preventDefault();

});

$(function () {
    $("#codigo_producto").autocomplete({
        source: "./ajax/autocomplete/productos.php",
        minLength: 2,
        select: function (event, ui) {
            event.preventDefault();
            $('#codigo_producto').val(ui.item.id_producto);
            $('#nombre_producto').val(ui.item.nombre_producto);
            $('#stock').val(ui.item.cantidad_producto);



        }
    });


});

$("#codigo_producto").on("keydown", function (event) {
    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE)
    {
        $("#id_producto").val("");
        $("#nombre_producto").val("");
        $("#stock").val("");

    }
    if (event.keyCode == $.ui.keyCode.DELETE) {
        $("#nombre_producto").val("");
        $("#id_cliente").val("");
        $("#stock").val("");
    }
});

function editarAjuste(id) {
    console.log(id);
    $("#carga").fadeIn('slow');
    $.ajax({
        url: "./ajax/ajuste_inventario/editar_ajuste.php?id=" + id,
        beforeSend: function (objeto) {
            $('#carga').html('<img src="../../public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".edit").html(data).fadeIn('slow');
            $('#carga').html('');

        }
    })
}

$("#guardar_producto").submit(function (event) {
    $('#guardar_datos').attr("disabled", true);

    var parametros = $(this).serialize();
    if ($('#departamento').val() !== 'null') {
        $.ajax({
            type: "POST",
            url: "./ajax/producto/nuevo_producto.php",
            data: parametros,
            beforeSend: function (objeto) {
                $("#resultados_ajax_productos").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados_ajax_productos").html(datos);
                $('#guardar_datos').attr("disabled", false);
            }
        });
    } else {
        var div = '<div class="alert alert-danger" role="alert">'
                + '<button type="button" class="close" data-dismiss="alert">&times;</button>'
                + '<strong>Debe Seleccionar un Departamento</strong> '
                + '</div>';
        $('#resultados_ajax_productos').html(div);
    }
    event.preventDefault();
});

function cargar_producto(page) {
    var q = $("#q").val();
    var dp = $("#dp").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/ajuste_inventario/productos_ajusteInv.php?action=ajax&page=' + page + '&q=' + q + "&dp=" + dp,
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');

        }
    })
}

function producto() {
    cargar_producto(1);
}

function habilitar() {
    if ($('#enser').prop('checked')) {
        $('#porcentaje1').removeAttr("required");
        $('#porcentaje2').removeAttr("required");
        $('#porcentaje3').removeAttr("required");
        $('#costo_producto').removeAttr("required");
        $('#porcentaje1').attr("disabled", true);
        $('#porcentaje2').attr("disabled", true);
        $('#porcentaje3').attr("disabled", true);
    } else {
        $('#porcentaje1').prop("required", true);
        $('#porcentaje2').prop("required", true);
        $('#porcentaje3').prop("required", true);
        $('#costo_producto').prop("required", true);
        $('#porcentaje1').prop("disabled", false);
        $('#porcentaje2').prop("disabled", false);
        $('#porcentaje3').prop("disabled", false);
    }
}