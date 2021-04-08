    $(document).ready(function(){
      loads();
      
    });

    function loads(){
      input = 'costo';
      costo = document.getElementById('costo').value;
      sumar(input,costo);
    }


     function sumar (input,valor) {
        
        valor = parseFloat(valor);

        if (input=='costo') 
        {
          var por1 = document.getElementById('porcentaje1').value;
          var por2 = document.getElementById('porcentaje2').value;
          var por3 = document.getElementById('porcentaje3').value;

          console.log(por1);
          console.log(por2);
          console.log(por3);
          
          precio1 = (parseFloat(valor+valor*por1/100));
          precio2 = (parseFloat(valor+valor*por2/100));
          precio3 = (parseFloat(valor+valor*por3/100));

          $("#precio1").val(precio1);
          $("#precio2").val(precio2);
          $("#precio3").val(precio3);
        }

        if(input=='porcentaje1')
        {
          var costo = document.getElementById('costo').value;
          costo = parseFloat(costo);
          console.log(costo);
          $("#precio1").val(costo+costo*valor/100);
        }

        if(input=='porcentaje2')
        {
          var costo = document.getElementById('costo').value;
          costo = parseFloat(costo);
          console.log(costo);
          $("#precio2").val(costo+costo*valor/100);
        }

        if(input=='porcentaje3')
        {
          var costo = document.getElementById('costo').value;
          costo = parseFloat(costo);
          console.log(costo);
          $("#precio3").val(costo+costo*valor/100);
        }                
        
    }
         