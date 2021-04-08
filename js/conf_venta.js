
$("#form_ventas").submit(function (event) {
    $('#guardar').attr("disabled", true);

    //var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/conf_venta/nueva_confventa.php?action=ajax",
        data: new FormData(this),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function (objeto) {
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});