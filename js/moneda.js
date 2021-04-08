$(document).ready(function(){
    load(1);

});

function load(page)
{
    var q= $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'ajax/parametros/moneda/buscar.php?action=ajax&page='+page+'&q='+q,
        beforeSend: function(objeto){
            $('#loader').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
            $('[data-toggle="tooltip"]').tooltip({html:true});
        }
    })
}

function eliminar (id)
{
    var q= $("#q").val();
    if (confirm("¿Realmente deseas eliminar el registro?")){
        $.ajax({
            type: "GET",
            url: "ajax/parametros/moneda/buscar.php?action=eliminar",
            data: "id="+id,"q":q,
            beforeSend: function(objeto){
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function(datos){
                $("#resultados").html(datos);
                load(1);
            }
        });
    }
}

function ver_unidad(id)
{
    $("#carga").fadeIn('slow');
    $.ajax({
        url:"ajax/parametros/moneda/ver.php?id=" + id,
        beforeSend: function(objeto){
            $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success:function(data){
            $(".edit").html(data).fadeIn('slow');
            $("#resultados_ajax").html('');
            $('#carga').html('');

        }
    })
}

$( "#form_editar_unidad" ).submit(function( event ) {
    $('#guardar_cambios').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/parametros/moneda/editar.php",
        data: parametros,
        beforeSend: function(objeto){
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados_ajax").html(datos);
            $('#guardar_cambios').attr("disabled", false);
            var obj = document.getElementById("btn_modalEditarProducto");
            obj.click();
            load(1);
        }
    });

    event.preventDefault();
})

$( "#form_unidad" ).submit(function( event ) {
    $('#guardar').attr("disabled", false);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/parametros/moneda/nuevo.php",
        data: parametros,
        beforeSend: function(objeto){
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function(datos){
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);

            document.getElementById("form_unidad").reset();
            $('#descripcion').focus();

        }
    });

    event.preventDefault();
})
