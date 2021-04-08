$( "#form_perfil" ).submit(function( event ) {
    event.preventDefault();
    //var parametros = $(this).serialize();
    var nueva = document.getElementById('nueva').value;
    var repetir = document.getElementById('repetir').value;
    if(nueva!=repetir){
        capa = document.getElementById('mensaje_coinciden');
        capa.style.display = 'block';
    }else{
    $.ajax({
        type: "POST",
        url: "ajax/usuario/perfil.php",
        data: new FormData(this),
        cache:false,
        contentType: false,
        processData: false,
        beforeSend: function(objeto){
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados_ajax").html(datos);
            if(datos==0){
                capa = document.getElementById('mensaje_clave');
                capa.style.display = 'block';
            }else{
                capa = document.getElementById('mensaje_suses');
                capa.style.display = 'block';
            }

        }
    });

    }
})

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});