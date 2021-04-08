var itens = [];
$(document).ready(function () {
    load(1);
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="modal"]').tooltip();
});
function load(page) {
    //resetear botones
    document.getElementById("guardar_cliente").reset();
    document.getElementById("guardar_producto").reset();
    document.getElementById("codigo").focus();
}

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
        }
    }
    )
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
        url: "ajax/cotizacion/editar_cotizacion.php?id=" + id,
        beforeSend: function (objeto) {
            $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".edit").html(data).show('slow');
            $('#carga').html('');
        }
    })
}

function comentario(id) {
    $(document).ready(function () {
        $("#cargagif").load("ajax/cotizacion/comentario_cotizacion.php?id=" + id, function () {
            $("#resultado_comentario").html('');
            $("#cargagif").show("slow");
            $("#coment").hide("slow");
        });
    });
}

function agregarComentario(id)
{

    var comentario = document.getElementById('comentario' + id).value;
    $.ajax({
        type: "POST",
        url: "./ajax/cotizacion/agregar_comentario.php",
        data: "id=" + id + "&comentario=" + comentario,
        beforeSend: function (objeto) {
            $("#resultado_comentario").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultado_comentario").html(datos);
        }
    });
}

function editarProducto(id)
{

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
    if (isNaN(precio_venta))
    {
        alert('El precio debe ser un valor numerico');
        document.getElementById('precio_venta' + id).focus();
        return false;
    }
//Fin validacion


    $.ajax({
        type: "POST",
        url: "./ajax/cotizacion/agregar_facturacion.php",
        data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad,
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


function agregarProducto(id) {
    var precio_venta = document.getElementById('precio_venta_' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    var costo = document.getElementById('costo_producto_' + id).value;
    var stock = document.getElementById('stock_' + id).value;
    var nivel = document.getElementById('nivel').value;
    var precio1 = document.getElementById('precio1_' + id).value;
    if (nivel == 1 && parseFloat(precio_venta) < parseFloat(precio1))
    {
        alert('El precio no puede ser menor que el precio 1');
        document.getElementById('precio_venta' + id).focus();
        return false;
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

    $.ajax({
        type: "POST",
        url: "./ajax/cotizacion/agregar_facturacion.php",
        data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad,
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
    $.ajax({
        type: "POST",
        url: "./ajax/cotizacion/agregar_cotizacion.php",
        data: "id=" + id + "&parametro=agregarCotizacion",
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            var total = document.getElementById('total').value;
            if (total !== '0.00')
            {
                $("#procesar").attr("disabled", false);
            }
            var check = document.getElementById("check").value;
            if (check == "true") {
                $("#procesar").attr("disabled", true);
            }
        }
    });
}

function agregarCotizacionEspera(id, nom, te, di, cod, fo, tem, val, nota) {
    $.ajax({
        type: "POST",
        url: "./ajax/cotizacion/agregar_cotizacion_espera.php",
        data: "id=" + id + "&parametro=agregarCotizacion",
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            var total = document.getElementById('total').value;
            if (total !== '0.00')
            {
                $("#procesar").attr("disabled", false);
            }
            var check = document.getElementById("check").value;
            if (check == "true") {
                $("#procesar").attr("disabled", true);
            }
            document.getElementById("codigo_cliente").value = cod;
            document.getElementById("nombre_cliente").value = nom;
            document.getElementById("tel1").value = te;
            document.getElementById("direccion_cliente").value = di;
            document.getElementById("cod_cotizacion").value = id;
            document.getElementById("forma_pago").value = fo;
            document.getElementById("validez").value = val;
            document.getElementById("tiempo_entrega").value = tem;
            document.getElementById("otros").value = nota;
        }
    });
}

function eliminar(id) {
    $.ajax({
        type: "POST",
        url: "./ajax/cotizacion/agregar_facturacion.php",
        data: "id=" + id,
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
            //validar el boton de procesar
            var total = document.getElementById('total').value;
            if (total !== '0.00')
            {
                $("#procesar").attr("disabled", false);
            } else
                $("#procesar").attr("disabled", true);
            var check = document.getElementById("check").value;
            if (check == "true") {
                $("#procesar").attr("disabled", true);
            }
        }
    });
}

$("#datos_cotizacion").submit(function () {
//datos de la cotizacion
//var num_cotizacion = document.getElementById('num_cotizacion').value;
    var id_cliente = document.getElementById('codigo_cliente').value;
    var condicion = document.getElementById('forma_pago').value;
    var telefono = document.getElementById('tel1').value;
    var direccion = document.getElementById('direccion_cliente').value;
    var impuesto = document.getElementById('impuesto').value;
    var subtotal = document.getElementById('subtotal').value;
    var total = document.getElementById('total').value;
    var cod_cotizacion = document.getElementById('cod_cotizacion').value;
    if (telefono == "" || direccion == "")
    {
        alert("Debe seleccionar un cliente");
        return false;
    }
//guardar cotizacion en la BD
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: 'ajax/cotizacion/nueva_cotizacion.php?impuesto=' + impuesto + '&subtotal=' + subtotal + '&total=' + total + '&cod_cotizacion=' + cod_cotizacion,
        data: parametros,
        beforeSend: function (objeto) {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
            //VentanaCentrada('pdf/documentos/ver_cotizacion.php?id_cotizacion='+num_cotizacion,'Cotizacion','','1024','768','true');
        }, success: function (datos) {

            //Generar PDF y mostrar cotizacion en pantalla
            var data = eval(datos);
            //Se trae en formato json el id de la ultima cotizacion registrada
            var id_ult_cot = data;
            $.ajax({
                type: "GET",
                url: 'pdf/documentos/ver_cotizacion.php?id_cotizacion=' + id_ult_cot,
                beforeSend: function (objeto) {
                    $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando cotización...');
                },
                success: function (datos) {
                    location.href = "cotizacion";
                }
            });
        }
    });
    event.preventDefault();
});
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
})

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
                $('#codigo').focus();
                var bool = $('#bool').val();
                if (bool == '1')
                {
                    $.ajax({
                        type: "POST",
                        url: "./ajax/cotizacion/crear_producto.php",
                        data: parametros,
                        beforeSend: function (objeto)
                        {
                            $("#resultados").html("Mensaje: Cargando...");
                        },
                        success: function (datos)
                        {
                            $("#resultados").html(datos);
                            document.getElementById("guardar_producto").reset();
                            //validar el boton de procesar
                            var total = document.getElementById('total').value;
                            if (total !== '0.00')
                            {
                                $("#procesar").attr("disabled", false);
                            } else
                                $("#procesar").attr("disabled", true);
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

function limpiar_modal() {

    $("#resultados_ajax_productos").html("");
    $("#resultados_ajax").html("");
    document.getElementById("guardar_producto").reset();
    document.getElementById("guardar_proveedor").reset();
}

function cotizacion_espera() {
    var cod_cliente = document.getElementById('codigo_cliente').value;
    if (cod_cliente != "")
    {
//guardar la cotizacion en la tabla temporal
        var cod_cotizacion = document.getElementById('cod_cotizacion').value;
        var impuesto = "0";
        var subtotal = "0";
        var total = "0";
        var forma_pago = document.getElementById('forma_pago').value;
        var tiempo_entrega = document.getElementById('tiempo_entrega').value;
        var validez = document.getElementById('validez').value;
        var otros = document.getElementById('otros').value;
        if ($('#impuesto').length) {
            impuesto = document.getElementById('impuesto').value;
            subtotal = document.getElementById('subtotal').value;
            total = document.getElementById('total').value;
            if (total !== '0.00') {
                $.ajax({
                    type: "POST",
                    url: "ajax/cotizacion/cotizacion_espera.php",
                    data: "impuesto=" + impuesto + "&subtotal=" + subtotal + "&total=" + total + "&codigo_cliente=" + cod_cliente +
                            "&forma_pago=" + forma_pago + "&tiempo_entrega=" + tiempo_entrega + "&validez=" + validez + "&otros=" + otros +
                            "&cod_cotizacion=" + cod_cotizacion,
                    beforeSend: function (objeto) {
                    }, success: function (datos) {
                        $('#cod_cotizacion').attr("value", datos[1]);
                        capa = document.getElementById('mensaje');
                        capa.style.display = 'block';
                    }
                });
            } else {
                alert("No hay datos para guardar");
            }
        } else {
            alert("No hay datos para guardar");
        }

    } else {
        alert("No hay datos para guardar");
    }
}

function cargar_cotizaciones_espera(page) {

    var q = $("#bce").val();
    $("#cargarEspera").fadeIn('slow');
    $.ajax({
        url: './ajax/cotizacion/cargar_cotizaciones_espera.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function (objeto) {
            $('#cargarEspera').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".datosEspera").html(data).fadeIn('slow');
            $('#cargarEspera').html('');
        }
    });
}

function retomar_cotizacion() {
    cargar_cotizaciones_espera(1);
}

function cargar_cotizaciones(page) {

    var q = $("#bc").val();
    $("#cargarEspera").fadeIn('slow');
    $.ajax({
        url: './ajax/cotizacion/cargar_cotizaciones.php?action=ajax&page=' + page + '&q=' + q,
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
            $(".outer_div").html(data).fadeIn('slow');
        }
    });
}

function producto() {
    cargar_producto(1);
}
