
$(document).ready(function () {
    load(1);
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="modal"]').tooltip();
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    //resetear botones
    document.getElementById("guardar_cliente").reset();
    document.getElementById("codigo").focus();
}

//Buscar clientes por autocompletado cedula
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function () {
    $("#codigo_cliente").autocomplete({
        source: "ajax/autocomplete/clientes_cod.php",
        minLength: 2,
        select: function (event, ui) {
            event.preventDefault();
            $('#codigo_cliente').val(ui.item.id_cliente);
            $('#nombre_cliente').val(ui.item.nombre_cliente);
            $('#tel1').val(ui.item.telefono_cliente);
            $('#mail').val(ui.item.email_cliente);
            $('#direccion_cliente').val(ui.item.direccion_cliente);
        }
    });
});

$("#codigo_cliente").on("keydown", function (event) {
    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE)
    {
        $("#id_cliente").val("");
        $("#nombre_cliente").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_cliente').val('');

    }
    if (event.keyCode == $.ui.keyCode.DELETE) {
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
        }
    });


});

$("#nombre_cliente").on("keydown", function (event) {
    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE)
    {
        $("#id_cliente").val("");
        $("#codigo_cliente").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_cliente').val('');
    }
    if (event.keyCode == $.ui.keyCode.DELETE) {
        $("#nombre_cliente").val("");
        $("#id_cliente").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_cliente').val('');
    }
});


function editarFactura(id) {
    $("#carga").fadeIn('slow');
    $.ajax({
        url: "./ajax/factura/editar_factura.php?id=" + id,
        beforeSend: function (objeto) {
            $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".edit").html(data).fadeIn('slow');
            $('#carga').html('');

        }
    })
}


function editarProducto(id, stock, tipo) {

    var precio_venta = document.getElementById('precio_venta' + id).value;
    var cantidad = document.getElementById('cantidad' + id).value;
    var costo = document.getElementById('costo').value;



    //Inicia validacion
    if (parseFloat(precio_venta) < parseFloat(costo))
    {
        alert('El precio no puede ser menor que el costo');
        document.getElementById('precio_venta' + id).focus();
        return false;
    }
    if (isNaN(cantidad))
    {
        alert('La cantidad debe ser un valor numerico entero');
        document.getElementById('cantidad' + id).focus();
        return false;
    }
    if (cantidad == "") {
        alert('Ingrese una cantidad');
        document.getElementById('cantidad' + id).focus();
        return false;
    }
    if (cantidad == 0) {
        alert('La cantidad no puede ser 0');
        document.getElementById('cantidad' + id).focus();
        return false;
    }
    if (tipo == 1)
    {
        if (parseInt(cantidad) > parseInt(stock))
        {
            alert('La cantidad supera el stock en inventario');
            document.getElementById('cantidad_' + id).focus();
            return false;
        }
    }
    if (isNaN(precio_venta))
    {
        alert('El precio debe ser un valor numerico');
        document.getElementById('precio_venta' + id).focus();
        return false;
    }
    //Fin validacion

    var porc_impuesto = $("input[name=porc_impuesto]:checked").val();

    $.ajax({
        type: "POST",
        url: "./ajax/factura/agregar_facturacion.php",
        data: {id: id, precio_venta: precio_venta, cantidad: cantidad, porc_impuesto: porc_impuesto, nota: $('#id_nota').val()},
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            //validar el boton de procesar
            var check = document.getElementById('check').value;
            if (check == "true")
            {
                $("#procesar").attr("disabled", true);
            } else
            {
                $("#procesar").attr("disabled", false);
            }
            var obj = document.getElementById("btn_modalEditarFactura");
            obj.click();
        }
    });
}


function agregarProducto(id) {
    var precio_venta = document.getElementById('precio_venta_' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    var costo = document.getElementById('costo_producto_' + id).value;
    var stock = document.getElementById('stock_' + id).value;
    var tipo = document.getElementById('tipo_' + id).value;
    var nivel = document.getElementById('nivel').value;
    var precio1 = document.getElementById('precio1_' + id).value;

    //Inicia validacion
    if (nivel == 1 && parseFloat(precio_venta) < parseFloat(precio1))
    {
        alert('El precio no puede ser menor que el precio 1');
        document.getElementById('precio_venta' + id).focus();
        return false;
    }

    if (tipo == 1)
    {
        if (parseInt(cantidad) > parseInt(stock))
        {
            alert('La cantidad supera el stock en inventario');
            document.getElementById('cantidad_' + id).focus();
            return false;
        }
    }

    if (parseFloat(precio_venta) < parseFloat(costo))
    {
        alert('El precio no puede ser menor que el costo');
        document.getElementById('precio_venta' + id).focus();
        return false;
    }
    if (isNaN(cantidad))
    {
        alert('Esto no es un numero');
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(precio_venta))
    {
        alert('Esto no es un numero');
        document.getElementById('precio_venta_' + id).focus();
        return false;
    }
    //Fin validacion
    var porc_impuesto = $("input[name=porc_impuesto]:checked").val();

    $.ajax({
        type: "POST",
        url: "./ajax/factura/agregar_facturacion.php",
        data: {id: id, precio_venta: precio_venta, cantidad: cantidad, porc_impuesto: porc_impuesto, nota: $('#id_nota').val()},
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            //validar el boton de procesar
            var check = document.getElementById('check').value;
            if (check == "true")
            {
                $("#procesar").attr("disabled", true);
            } else
            {
                $("#procesar").attr("disabled", false);
            }
        }
    });
}

function agregarCotizacion(id) {

    var porc_impuesto = $("input[name=porc_impuesto]:checked").val();
    $('#id_nota').val('');
    $.ajax({
        type: "POST",
        url: "./ajax/factura/agregar_cotizacion.php",
        data: {id: id, porc_impuesto: porc_impuesto},
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            //validar el boton procesar
            var check = document.getElementById('check').value;
            if (check == "true")
            {
                $("#procesar").attr("disabled", true);
            } else
            {
                $("#procesar").attr("disabled", false);
            }
            var cod_cliente = document.getElementById('cod_cliente_' + id).value;
            var nom_cliente = document.getElementById('nom_cliente_' + id).value;
            var tel_cliente = document.getElementById('tel_cliente_' + id).value;
            var dir_cliente = document.getElementById('dir_cliente_' + id).value;

            var id_cotizacion = document.getElementById('id_cotizacion').value = id;

            //Mostrar los datos del cliente de la cotizacion cargada
            document.getElementById('codigo_cliente').value = cod_cliente;
            document.getElementById('nombre_cliente').value = nom_cliente;
            document.getElementById('tel1').value = tel_cliente;
            document.getElementById('direccion_cliente').value = dir_cliente;

        }
    });
}

function eliminar(id) {
    var porc_impuesto = $("input[name=porc_impuesto]:checked").val()
    $.ajax({
        type: "POST",
        url: "./ajax/factura/agregar_facturacion.php",
        data: {id: id, porc_impuesto: porc_impuesto, action: "eliminar", nota: $('#id_nota').val()},
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            //validar el boton de procesar
            var check = document.getElementById('check').value;
            var total = document.getElementById('total').value;

            if (check == "true") {
                $("#procesar").attr("disabled", true);
            } else {
                $("#procesar").attr("disabled", false);
            }
            if (total == '0.00') {
                $("#procesar").attr("disabled", true);
            }
        }
    });

}


//Procesar factura
///////////////////////////////////////////////////////////////////////////////////
$("#datos_factura").submit(function () {
    var num_factura = $("#num_factura").val();
    if (document.getElementById('direccion_cliente').value == "") {
        alert("Debes seleccionar un cliente");
        $("#codigo_cliente").focus();
        return false;
    }
    var check = document.getElementById('check').value;
    if (check == "true") {
        alert("No hay productos seleccionados");
        return false;
    }
    $.ajax({
        type: "POST",
        url: 'ajax/factura/nueva_factura.php?impuesto=' + impuesto + '&subtotal=' + subtotal + '&total=' + total + '&id_cotizacion=' + id_cotizacion + '&porc_impuesto=' + porc_impuesto + '&costo_total=' + costo_total,
        data: {
            num_factura: $("#num_factura").val(),
            codigo_cliente: $("#codigo_cliente").val(),
            condicion: $("#condiciones").val(),
            observacion: $('#observacion').val(),
            porc_impuesto: $("#porc_impuesto").val(),
            id_cotizacion: $("#id_cotizacion").val(),
            id_nota: $("#id_nota").val()
        },
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (datos) {
            if (datos == 1) {
                pdf(num_factura);
            } else {
                $('#resultados').html(datos);
            }
        }
    });
    event.preventDefault();
});
function pdf(num_factura) {
    $.ajax({
        type: "GET",
        url: 'pdf/documentos/ver_factura.php?id_factura=' + num_factura,
        success: function (datos) {
            console.log(datos);
            location.href = "factura";
        }
    });
}
function dar() {
//datos de la factura
    var id_cliente = $("#codigo_cliente").val();
    var nombre_cliente = $("#nombre_cliente").val();
    var num_factura = $("#num_factura").val();
    var condicion = $("#condiciones").val();
    var impuesto = document.getElementById('impuesto').value;
    var porc_impuesto = $("#porc_impuesto").val();
    var subtotal = document.getElementById('subtotal').value;
    var total = document.getElementById('total').value;
    var id_cotizacion = document.getElementById('id_cotizacion').value
    var costo_total = document.getElementById('costo_total').value
    if (nombre_cliente == "") {
        alert("Debes seleccionar un cliente");
        $("#codigo_cliente").focus();
        return false;
    }
    if (condicion == "" || impuesto == "" || subtotal == "" || total == "") {
        alert("No hay productos seleccionados");
        return false;
    }
//guardar factura en la BD
    var parametros = $("#datos_factura").serialize();
    $.ajax({
        type: "POST",
        url: 'ajax/factura/nueva_factura.php?impuesto=' + impuesto + '&subtotal=' + subtotal + '&total=' + total + '&id_cotizacion=' + id_cotizacion + '&porc_impuesto=' + porc_impuesto + '&costo_total=' + costo_total,
        data: parametros,
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (datos) {
            $('#resultados').html(datos);
        }
    });
}

$("#guardar_cliente").submit(function (event) {
    $('#guardar_datos').attr("disabled", false);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/cliente/nuevo_cliente.php",
        data: parametros,
        datatype: 'json;',
        beforeSend: function (objeto) {
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax").html(datos);
            //valor del input oculto que se crea en ajax/cliente//nuevo_cliente.php, 1 si se registra el cliente y 0 si ya existe
            var bool = $('#bool').val();
            if (bool == '1')
            {
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
}
)


$("#guardar_producto").submit(function (event) {
    $('#guardar_datos').attr("disabled", false);
    var parametros = $(this).serialize();
    if ($('#departamento').val() !== 'null') {
        $.ajax({
            type: "POST",
            url: "ajax/producto/nuevo_producto.php",
            data: parametros,
            beforeSend: function (objeto) {
                $("#resultados_ajax_productos").html("Mensaje: Cargando...");
            },
            success: function (datos)
            {
                $("#resultados_ajax_productos").html(datos);
                $('#guardar_datos').attr("disabled", false);
                document.getElementById("guardar_producto").reset();
                $('#codigo').focus();
                var bool = $('#bool').val();
                var porc_impuesto = $("input[name=porc_impuesto]:checked").val();
                if (bool == '1')
                {
                    $.ajax({
                        type: "POST",
                        url: "./ajax/factura/crear_producto.php?porc_impuesto=" + porc_impuesto,
                        data: parametros,
                        beforeSend: function (objeto)
                        {
                            $("#resultados").html("Mensaje: Cargando...");
                        },
                        success: function (datos)
                        {
                            $("#resultados").html(datos);
                            //validar el boton de procesar
                            var check = document.getElementById('check').value;
                            console.log(check);
                            if (check == "true")
                            {
                                $("#procesar").attr("disabled", true);
                            } else
                            {
                                $("#procesar").attr("disabled", false);
                            }
                        }
                    });
                    var obj = document.getElementById("btn_modalProducto");
                    obj.click();
                }
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
})

function limpiar_modal()
{
    $("#resultados_ajax_productos").html("");
    $("#resultados_ajax").html("");
    document.getElementById("guardar_producto").reset();
    document.getElementById("guardar_proveedor").reset();
}

function cambiar_impuesto(impuesto)
{
    $.ajax({
        type: "POST",
        url: "./ajax/factura/cambiar_impuesto.php",
        data: "porc_impuesto=" + impuesto,
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
        }
    });
}
function cargar_producto(page) {
    var dp = $("#dp").val();
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/factura/productos_factura.php?action=ajax&page=' + page + '&q=' + q + "&dp=" + dp,
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    });
}

function producto() {
    cargar_producto(1);
}

function cargar_cotizaciones(page) {

    var q = $("#bc").val();
    $("#cargarEspera").fadeIn('slow');
    $.ajax({
        url: './ajax/factura/cargar_cotizaciones.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function (objeto) {
            $('#cargar').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".otro").html(data).fadeIn('slow');
            $('#cargar').html('');
        }
    })
}

function cotizacion() {
    cargar_cotizaciones(1);
}

function cargar_nota(page) {
    var q = $("#bn").val();
    $.ajax({
        url: './ajax/factura/carga_nota.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function (objeto) {
            $('#cargarN').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $("#ListNotas").html(data).fadeIn('slow');
            $('#cargarN').html('');
        }
    });
}

function notas() {
    cargar_nota(1);
}
function agregarNota(id) {

    var porc_impuesto = $("input[name=porc_impuesto]:checked").val();

    $.ajax({
        type: "POST",
        url: "./ajax/factura/agregar_nota.php",
        data: {id: id, porc_impuesto: porc_impuesto},
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos).fadeIn('slow');
            var check = document.getElementById('check').value;
            if (check == "true") {
                $("#procesar").attr("disabled", true);
            } else {
                $("#procesar").attr("disabled", false);
            }
            var cod_cliente = document.getElementById('cod_nota_' + id).value;
            var nom_cliente = document.getElementById('nom_nota_' + id).value;
            var tel_cliente = document.getElementById('tel_nota_' + id).value;
            var dir_cliente = document.getElementById('dir_nota_' + id).value;
            document.getElementById('id_nota').value = id;
            //Mostrar los datos del cliente de la cotizacion cargada
            document.getElementById('codigo_cliente').value = cod_cliente;
            document.getElementById('nombre_cliente').value = nom_cliente;
            document.getElementById('tel1').value = tel_cliente;
            document.getElementById('direccion_cliente').value = dir_cliente;

        }
    });
}