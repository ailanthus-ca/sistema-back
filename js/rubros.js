$( "#form_rubros" ).submit(function( event ) {
    var ano = $( "#ano option:selected" ).val();
    var mes = $( "#mes option:selected" ).val();

    //var parametros = $(this).serialize()


    $.ajax({
        type: "POST",
        data: '&mes='+mes+'&ano='+ano,
        url: 'pdf/documentos/reporte_rubros.php',
        beforeSend: function(objeto){
            $('#resultados').html('<img src="./public/imagenes/ajax-loader.gif"> Generando Reporte...');
            event.preventDefault();
        },
        success: function(datos){
           location.href ="rubro_pdf";
        }
    });
})
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});