    $(document).ready(function(){
      load(1);
      
    });

    function load(page)
    {
      var q= $("#q").val();
      $("#loader").fadeIn('slow');
      $.ajax({
        url:'ajax/parametros/tipo_producto/buscar_tipo_producto.php?action=ajax&page='+page+'&q='+q,
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
        if (confirm("¿Realmente deseas eliminar el tipo de producto?")){  
        $.ajax({
          type: "GET",
          url: "ajax/parametros/tipo_producto/buscar_tipo_producto.php?action=eliminar",
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

    function activar (id)
    {
        var q= $("#q").val();
        if (confirm("¿Deseas activar este tipo de productos?")){ 
        $.ajax({
          type: "GET",
          url: "ajax/parametros/tipo_producto/buscar_tipo_producto.php?action=activar",
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

  function ver_tipo_producto(id)
  {
    $("#carga").fadeIn('slow');
    $.ajax({
      url:"ajax/parametros/tipo_producto/ver_tipo_producto.php?id=" + id,
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

  $( "#form_editar_tipo_producto" ).submit(function( event ) {
    $('#guardar_cambios').attr("disabled", true);
    
   var parametros = $(this).serialize();
     $.ajax({
        type: "POST",
        url: "ajax/parametros/tipo_producto/editar_tipo_producto.php",
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

$( "#form_tipo_producto" ).submit(function( event ) {
  $('#guardar').attr("disabled", false);
  
 var parametros = $(this).serialize();
   $.ajax({
      type: "POST",
      url: "ajax/parametros/tipo_producto/nuevo_tipo_producto.php",
      data: parametros,
       beforeSend: function(objeto){
        $("#resultados_ajax").html("Mensaje: Cargando...");
        },
      success: function(datos){
      $("#resultados_ajax").html(datos);
      $('#guardar_datos').attr("disabled", false);
      
      document.getElementById("form_tipo_producto").reset();
      $('#descripcion').focus();

      }
  });
   
  event.preventDefault();
})
