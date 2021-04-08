//Buscar clientes por autocompletado cedula
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function () {
    $("#codigo_cliente").autocomplete({
        source: 'ajax/autocomplete/clientes_cod.php',
        minLength: 2,
        select: function (event, ui) {
            event.preventDefault();
            $('#codigo_cliente').val(ui.item.id_cliente);
            $('#nombre_cliente').val(ui.item.nombre_cliente);
            $('#tel1').val(ui.item.telefono_cliente);
            $('#mail').val(ui.item.email_cliente);
            $('#direccion_cliente').val(ui.item.direccion_cliente);
            isProducto();
        }
    });
});
$("#codigo_cliente").on("keydown", function (event) {
    if (event.keyCode === $.ui.keyCode.LEFT || event.keyCode === $.ui.keyCode.RIGHT || event.keyCode === $.ui.keyCode.UP || event.keyCode === $.ui.keyCode.DOWN || event.keyCode === $.ui.keyCode.DELETE || event.keyCode === $.ui.keyCode.BACKSPACE)
    {
        $("#id_cliente").val("");
        $("#nombre_cliente").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_cliente').val('');
    }
    if (event.keyCode === $.ui.keyCode.DELETE) {
        $("#nombre_cliente").val("");
        $("#id_cliente").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_cliente').val('');
    }
});
//Buscar clientes por autocompletado nombre
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function () {
    $("#nombre_cliente").autocomplete({
        source: "ajax/autocomplete/clientes_nom.php",
        minLength: 2,
        select: function (event, ui) {
            event.preventDefault();
            $('#codigo_cliente').val(ui.item.id_cliente);
            $('#nombre_cliente').val(ui.item.nombre_cliente);
            $('#tel1').val(ui.item.telefono_cliente);
            $('#mail').val(ui.item.email_cliente);
            $('#direccion_cliente').val(ui.item.direccion_cliente);
            isProducto();
        }
    });
});
$("#nombre_cliente").on("keydown", function (event) {
    if (event.keyCode === $.ui.keyCode.LEFT || event.keyCode === $.ui.keyCode.RIGHT || event.keyCode === $.ui.keyCode.UP || event.keyCode === $.ui.keyCode.DOWN || event.keyCode === $.ui.keyCode.DELETE || event.keyCode === $.ui.keyCode.BACKSPACE)
    {
        $("#id_cliente").val("");
        $("#codigo_cliente").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_cliente').val('');
    }
    if (event.keyCode === $.ui.keyCode.DELETE) {
        $("#nombre_cliente").val("");
        $("#id_cliente").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_cliente').val('');
    }
});
//Productos
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function cargar_producto(page) {
    var q = $("#q").val();
    var dp = $("#dp").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/cotizacion/productos_cotizacion.php?action=ajax&page=' + page + '&q=' + q + "&dp=" + dp,
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $('#loader').html('');
            $(".outer_div").html(data).fadeIn('slow');
        }
    });
}
function producto() {
    cargar_producto(1);
}
function agregarProducto(productor) {
    var precio_venta = document.getElementById('precio_venta_' + productor).value;
    var cantidad = document.getElementById('cantidad_' + productor).value;
    var costo = document.getElementById('costo_producto_' + productor).value;
    var stock = document.getElementById('stock_' + productor).value;
    var nivel = document.getElementById('nivel').value;
    var precio1 = document.getElementById('precio1_' + productor).value;

    if (parseInt(cantidad) > parseInt(stock))
    {
        alert('La cantidad supera el stock en inventario');
        document.getElementById('cantidad_' + productor).focus();
        return false;
    }
    if (nivel === 1 && parseFloat(precio_venta) < parseFloat(precio1))
    {
        alert('El precio no puede ser menor que el precio 1');
        document.getElementById('precio_venta' + productor).focus();
        return false;
    }
    if (parseFloat(precio_venta) < parseFloat(costo))
    {
        alert('El precio no puede ser menor que el costo');
        document.getElementById('precio_venta' + productor).focus();
        return false;
    }
    if (isNaN(cantidad))
    {
        alert('Esto no es un numero');
        document.getElementById('cantidad_' + productor).focus();
        return false;
    }
    if (isNaN(precio_venta))
    {
        alert('Esto no es un numero');
        document.getElementById('precio_venta_' + productor).focus();
        return false;
    }
    $.ajax({
        type: "POST",
        url: "./ajax/notas/eadd.php",
        data: {
            producto: productor,
            cantidad: $('#cantidad_' + productor).val(),
            precio: $('#precio_venta_' + productor).val()
        },
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            $('#myModal').modal('hide');
            isProducto();
        }
    });
}
function editarFactura(codigo, descr, cant, prec, costo, pre1, pre2, pre3) {
    $('#cod_edit').html(codigo);
    $('#desc_edit').html(descr);
    $('#cant_edit').val(cant);
    $('#prec_edit').val(prec);
    $('#pre1_edit').val(pre1);
    $('#pre2_edit').val(pre2);
    $('#pre3_edit').val(pre3);
    document.getElementById('btn_edit').onclick = function () {
        if ($('#prec_edit').val() < costo) {
            alert('El precio no puede ser menor que el costo');
        } else {
            $.ajax({
                type: "POST",
                url: "./ajax/notas/eadd.php",
                data: {
                    producto: codigo,
                    cantidad: $('#cant_edit').val(),
                    precio: $('#prec_edit').val()
                },
                beforeSend: function (objeto) {
                    $("#resultados").html("Mensaje: Cargando...");
                },
                success: function (datos) {
                    $("#resultados").html(datos);
                    var obj = document.getElementById("btn_modalEditarFactura");
                    obj.click();
                }
            });
        }
    };
}
function eliminar(codigo) {
    $.ajax({
        type: "POST",
        url: "./ajax/notas/eremove.php",
        data: {
            producto: codigo
        },
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            isProducto();
        }
    });
}
function isProducto() {
    var check = document.getElementById('check').value;
    var direccion = document.getElementById('direccion_cliente').value;
    console.log((check > 0) && (direccion != ""));
    if ((check > 0) && (direccion != "")) {
        $("#procesar").attr("disabled", false);
    } else {
        $("#procesar").attr("disabled", true);
    }
}
//clientes
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$("#guardar_cliente").submit(function (event) {
    $('#guardar_datos').attr("disabled", false);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/cliente/nuevo_cliente.php",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax").html(datos);
            //valor del input oculto que se crea en ajax/nuevo_cliente.php, 1 si se registra el cliente y 0 si ya existe
            var bool = $('#bool').val();
            if (bool === '1') {
                $('#codigo_cliente').val($('#codigo').val());
                $('#nombre_cliente').val($('#nombre').val());
                $('#tel1').val($('#telefono').val());
                $('#direccion_cliente').val($('#direccion').val());
                var obj = document.getElementById("btn_modalCliente");
                obj.click();
            }
            $('#guardar_datos').attr("disabled", false);
            document.getElementById('guardar_cliente').reset();
            load(1);
        }
    });
    event.preventDefault();
});
//prosesar nota de entrega
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$('#notaSalida').submit(function (event) {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "./ajax/notas/new.php",
        data: {
            cotizacion: $('#cod_cotizacion').val(),
            codigo_cliente: $('#codigo_cliente').val(),
            nota: $('#nota').val()
        },
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $.ajax({
                type: "GET",
                url: './pdf/documentos/ver_notasalida.php',
                data: {id: datos},
                beforeSend: function (objeto) {
                    $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando cotización...');
                },
                success: function (datos) {
                    location.href = "nota";
                }
            });
        }
    });
});

function cargar_cotizaciones(page) {
    var q = $("#bc").val();
    $("#cargarEspera").fadeIn('slow');
    $.ajax({
        url: './ajax/notas/mostar_cotizaciones.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function (objeto) {
            $('#cargar').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".otro").html(data).fadeIn('slow');
            $('#cargar').html('');
        }
    });
}

function cotizacion() {
    cargar_cotizaciones(1);
}

function cargaCotizacion(id, nom, te, di, cod, fo, tem, val, nota) {
    $.ajax({
        type: "POST",
        url: "./ajax/notas/cargar_cotizacion.php",
        data: {
            id: id
        },
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            document.getElementById("cod_cotizacion").value = id;
            document.getElementById("codigo_cliente").value = cod;
            document.getElementById("nombre_cliente").value = nom;
            document.getElementById("tel1").value = te;
            document.getElementById("direccion_cliente").value = di;
            document.getElementById("cod_cotizacion").value = id;
            document.getElementById("nota").value = nota;
            $("#resultados").html(datos);
            $("#procesar").attr("disabled", false);
        }
    });
}