$(document).ready(function () {

    $('#codigo').focus();

});


$("#form_proveedor").submit(function (event) {
    $('#guardar').attr("disabled", false);

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
            $('#guardar_datos').attr("disabled", false);

            document.getElementById("form_proveedor").reset();
            $('#codigo').focus();

        }
    });

    event.preventDefault();
})

jQuery(function($){
   $("#codigo").mask("a-99999999-9");
});