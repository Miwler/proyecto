var select = function (objContent, id,url)
{
    $.ajax({
        type: "post",
        url: url,
        data: {
            id: id
        },
        datatype: "json",
        success: function (respuesta) {
            var respuesta = $.parseJSON(respuesta);
            $('#'+objContent).html(respuesta.resultado);
        },
        error: function () {
            $('#'+objContent).html('Error al conectarse');
        }
    });
}