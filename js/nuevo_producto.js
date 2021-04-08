$(document).ready(function () {

    $('#codigo_producto').focus();

});

function sumar(input, valor) {
    valor = parseFloat(valor);
    if (input == 'costo') {
        var por1 = document.getElementById('porcentaje1').value;
        var por2 = document.getElementById('porcentaje2').value;
        var por3 = document.getElementById('porcentaje3').value;
        precio1 = (parseFloat(valor + valor * por1 / 100));
        precio2 = (parseFloat(valor + valor * por2 / 100));
        precio3 = (parseFloat(valor + valor * por3 / 100));
        $("#precio1").val(precio1);
        $("#precio2").val(precio2);
        $("#precio3").val(precio3);
    }
    if (input == 'porcentaje1') {
        var costo = document.getElementById('costo_producto').value;
        costo = parseFloat(costo);
        $("#precio1").val(costo + costo * valor / 100);
    }
    if (input == 'porcentaje2') {
        var costo = document.getElementById('costo_producto').value;
        costo = parseFloat(costo);
        $("#precio2").val(costo + costo * valor / 100);
    }
    if (input == 'porcentaje3') {
        var costo = document.getElementById('costo_producto').value;
        costo = parseFloat(costo);
        $("#precio3").val(costo + costo * valor / 100);
    }
}

function focus() {
    console.log("focus");

}

$("#form_producto").submit(function (event) {
    $('#guardar').attr("disabled", false);
    var parametros = $(this).serialize();
    if ($('#departamento').val() !== 'null') {
        $.ajax({
            type: "POST",
            url: "ajax/producto/nuevo_producto.php",
            data: parametros,
            beforeSend: function () {
                $("#resultados_ajax").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados_ajax").html(datos);
                $('#guardar_datos').attr("disabled", false);

                document.getElementById("form_producto").reset();
                $('#codigo_producto').focus();
                habilitar();
            }
        });
    } else {
        var div = '<div class="alert alert-danger" role="alert">'
                + '<button type="button" class="close" data-dismiss="alert">&times;</button>'
                + '<strong>Debe Seleccionar un Departamento</strong> '
                + '</div>';
        $('#resultados_ajax').html(div);
    }
    event.preventDefault();
});


//Mostrar productos por codigo
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function () {
    $("#codigo_producto").autocomplete({
        source: "ajax/autocomplete/productos.php",
        minLength: 2,
    });
});

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