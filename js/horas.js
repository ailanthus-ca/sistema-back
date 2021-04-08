$('#guardar_datos').click(function () {
    var dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
    var data = {};
    dias.forEach(function (element) {
        data[element] = {
            Laborable: $('#' + element + 'L').is(':checked'),
            Entrada: $('#' + element + 'E').val(),
            Salida: $('#' + element + 'S').val()
        };
    });
    $.ajax({
        url: "ajax/horarios/nuevo.php",
        type: "POST",
        data: data,
        datatype: 'json;',
        beforeSend: function (objeto) {
            $('#carga').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $("#result").html(data).show('slow');
        }
    });
    event.preventDefault();
});