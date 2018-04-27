var getObject = function (url,div) {
    this.url = url;
    this.Div = document.getElementById(div);
    this.objJson = null;
    var obj = this;
    this.request = function () {
        requestObject(obj)
    }
    this.terminado = function () { }
}

var requestObject = function (obj) {    
    $(obj.Div).html('<div id="grid-loading"><center>Cargando...</center></div>');
    var aleatorio = Math.random();
  
    $.ajax({
        type: 'get',
        url: obj.url,
        cache: false,
        data: { aleatorio: aleatorio },
        datatype: "json",
        success: function (respuesta) {            
            obj.objJson = $.parseJSON(respuesta);
            $(obj.Div).html(obj.objJson.mensaje);
        },
        complete: function () {
            obj.terminado();            
        },
        error: function () {
            alert('Ocurrió un Error al intentar conectarse');
        }
    });
}