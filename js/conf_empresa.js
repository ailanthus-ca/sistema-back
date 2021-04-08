
$("#form_empresa").submit(function (event) {
    $('#guardar').attr("disabled", true);
    var formData = new FormData(this);
    var id = $('#id').val();
    var ruta = "ajax/conf_empresa/nueva_empresa.php?action=ajax";
    $.ajax({
        url: ruta,
        type: "POST",
        data: formData,
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
});


$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});