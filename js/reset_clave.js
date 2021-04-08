$( "#frmRestablecer" ).submit(function( event ) {

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/reset_clave/validar_email.php",
        data: parametros,
        beforeSend: function(objeto){
            $("#mensaje").html("Enviando correo...");
        },
        success: function(datos){
            $("#mensaje").html(datos);
        }
    });

    event.preventDefault();
})