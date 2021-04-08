
$(document).ready(function () {
    load(1);
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="modal"]').tooltip();

}

//Buscar proveedores por autocompletado cedula
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function () {
    $("#codigo_proveedor").autocomplete({
        source: "ajax/autocomplete/proveedores_cod.php",
        minLength: 2,
        select: function (event, ui) {
            event.preventDefault();
            $('#codigo_proveedor').val(ui.item.id_proveedor);
            $('#nombre_proveedor').val(ui.item.nombre_proveedor);
            $('#tel1').val(ui.item.telefono_proveedor);
            $('#mail').val(ui.item.email_proveedor);
            $('#direccion_proveedor').val(ui.item.direccion_proveedor);



        }
    });


});

$("#codigo_proveedor").on("keydown", function (event) {
    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE)
    {
        $("#id_proveedor").val("");
        $("#nombre_proveedor").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_proveedor').val('');

    }
    if (event.keyCode == $.ui.keyCode.DELETE) {
        $("#nombre_proveedor").val("");
        $("#id_proveedor").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_proveedor').val('');
    }
});

//Buscar proveedores por autocompletado nombre
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function () {
    $("#nombre_proveedor").autocomplete({
        source: "ajax/autocomplete/proveedores_nom.php",
        minLength: 2,
        select: function (event, ui) {
            event.preventDefault();
            $('#codigo_proveedor').val(ui.item.id_proveedor);
            $('#nombre_proveedor').val(ui.item.nombre_proveedor);
            $('#tel1').val(ui.item.telefono_proveedor);
            $('#mail').val(ui.item.email_proveedor);
            $('#direccion_proveedor').val(ui.item.direccion_proveedor);



        }
    });


});

$("#nombre_proveedor").on("keydown", function (event) {
    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE)
    {
        $("#id_proveedor").val("");
        $("#codigo_proveedor").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_proveedor').val('');

    }
    if (event.keyCode == $.ui.keyCode.DELETE) {
        $("#nombre_proveedor").val("");
        $("#id_proveedor").val("");
        $("#tel1").val("");
        $("#mail").val("");
        $('#direccion_proveedor').val('');
    }
});

function editarCompra(id) {
    console.log(id);
    $("#carga").fadeIn('slow');
    $.ajax({
        url: "./ajax/orden_compra/editar_compra.php?id=" + id,
        beforeSend: function (objeto) {
            $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".edit").html(data).fadeIn('slow');
            $('#carga').html('');

        }
    })
}

function editarProducto(id)
{

    var costo_compra = document.getElementById('costo_compra_' + id).value;
    console.log(costo_compra);
    var cantidad = document.getElementById('cantidad' + id).value;

    //Inicia validacion
    if (cantidad == '')
    {
        alert('Ingrese una cantidad');
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(cantidad))
    {
        alert('Esto no es un numero');
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(costo_compra))
    {
        alert('Esto no es un numero');
        document.getElementById('costo_compra' + id).focus();
        return false;
    }
    if (costo_compra == '')
    {
        alert('Ingrese un costo');
        document.getElementById('costo_compra' + id).focus();
        return false;
    }
    //Fin validacion

    $.ajax({
        type: "POST",
        url: "./ajax/orden_compra/agregar_compra.php",
        data: "id=" + id + "&costo_compra=" + costo_compra + "&cantidad=" + cantidad,
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

function agregarProducto(id)
{
    console.log('agregarProducto');
    var costo_compra = document.getElementById('costo_compra' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    //var costo=document.getElementById('costo_producto').value;

    //Inicia validacion
    if (cantidad == '')
    {
        alert('Ingrese una cantidad');
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(cantidad))
    {
        alert('Esto no es un numero');
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(costo_compra))
    {
        alert('Esto no es un numero');
        document.getElementById('costo_compra' + id).focus();
        return false;
    }
    if (costo_compra == '')
    {
        alert('Ingrese un costo');
        document.getElementById('costo_compra' + id).focus();
        return false;
    }
    //Fin validacion			

    $.ajax({
        type: "POST",
        url: "./ajax/orden_compra/agregar_compra.php",
        data: "id=" + id + "&costo_compra=" + costo_compra + "&cantidad=" + cantidad,
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
        }
    });

    document.getElementById('costo_compra' + id).value = '';
    document.getElementById('cantidad_' + id).value = 1;
}


function eliminar(id)
{

    $.ajax({
        type: "GET",
        url: "./ajax/orden_compra/agregar_compra.php",
        data: "id=" + id,
        beforeSend: function (objeto) {
            $("#resultados").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados").html(datos);
        }
    });

}

$("#datos_orden").submit(function () {

    //datos de la orden
    var nombre_proveedor = $("#nombre_proveedor").val();
    var cod_orden = $("#cod_orden").val();
    var fecha = $("#fecha").val();
    var id_proveedor = $("#codigo_proveedor").val();
    var impuesto = document.getElementById('impuesto').value;
    var subtotal = document.getElementById('subtotal').value;
    var total = document.getElementById('total').value;

    if (nombre_proveedor == "")
    {
        alert("Debes seleccionar un cliente");
        $("#codigo_proveedor").focus();
        return false;
    }

    //guardar orden en la bd
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: 'ajax/orden_compra/nueva_orden.php?id_proveedor=' + id_proveedor + '&cod_orden=' + cod_orden + '&fecha=' + fecha + '&impuesto=' + impuesto + '&subtotal=' + subtotal + '&total=' + total,
        data: parametros,
        beforeSend: function (objeto)
        {
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (datos)
        {
            //Generar PDF y mostrar factura en pantalla
            $.ajax({
                type: "GET",
                url: 'pdf/documentos/ver_orden.php?id_orden=' + cod_orden,
                beforeSend: function (objeto) {
                    $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando orden de compra...');
                },
                success: function (datos) {
                    location.href = "orden";
                }
            });

        }
    });
    event.preventDefault();

});

$("#guardar_proveedor").submit(function (event) {
    $('#guardar_datos').attr("disabled", false);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/proveedor/nuevo_proveedor.php",
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
                $('#codigo_proveedor').val($('#codigo').val());
                $('#nombre_proveedor').val($('#nombre').val());
                $('#tel1').val($('#telefono').val());
                $('#direccion_proveedor').val($('#direccion').val());
                var obj = document.getElementById("btn_modalProveedor");
                obj.click();
            }
            $('#guardar_datos').attr("disabled", false);
            document.getElementById('guardar_proveedor').reset();
            load(1);
        }
    });
    event.preventDefault();
})

/*	$( "#guardar_producto" ).submit(function( event ) {
 $('#guardar_datos').attr("disabled", true);
 
 var parametros = $(this).serialize();
 $.ajax({
 type: "POST",
 url: "ajax/nuevo_producto.php",
 data: parametros,
 beforeSend: function(objeto){
 $("#resultados_ajax_productos").html("Mensaje: Cargando...");
 },
 success: function(datos){
 $("#resultados_ajax_productos").html(datos);
 $('#guardar_datos').attr("disabled", false);
 document.getElementById('guardar_producto').reset();
 load(1);
 }
 });
 event.preventDefault();
 }) */

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
                console.log(bool);
                if (bool == '1')
                {
                    $.ajax({
                        type: "POST",
                        url: "./ajax/orden_compra/crear_producto.php",
                        data: parametros,
                        beforeSend: function (objeto)
                        {
                            $("#resultados").html("Mensaje: Cargando...");
                        },
                        success: function (datos)
                        {
                            $("#resultados").html(datos);
                            document.getElementById("guardar_producto").reset();
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
});


function pulsar(e, cod_producto)
{
    var tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13)
        agregarProducto(cod_producto)
}

function limpiar_modal()
{
    $("#resultados_ajax_productos").html("");
    $("#resultados_ajax").html("");
    document.getElementById("guardar_producto").reset();
    document.getElementById("guardar_proveedor").reset();
}


function cargar_producto(page) {
    var q = $("#q").val();
    var dp = $("#dp").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/compra/productos_compra.php?action=ajax&page=' + page + '&q=' + q + "&dp=" + dp,
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