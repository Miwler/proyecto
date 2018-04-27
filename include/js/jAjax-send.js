var jAjax_Send = function (content_form,content_result,url) {
    this.contentForm = document.getElementById(content_form);
    this.contentResult = document.getElementById(content_result);
    this.divMensaje = '';
    this.url= url;
    this.accion = '';
    this.method = 'post';
    var obj = this;
    this.enviar = function (accion) {
       // alert('aqui');
        obj.accion = accion;
        jAjax_enviar(obj);
    }

    this.loading = function () {
        $(obj.contentResult).html('<div id="grid-loading"><center><img src="/Image/loading-grid.gif" /></center></div>');
    }

    this.terminado = function () { }
    this.validar = function () { return true; }

    this.Mostrar_Mensaje = function (msj) {
        frmMostrar_Mensaje(obj, msj);
    };

    this.Ocultar_Mensaje = function () {
        frmOcultar_Mensaje(obj);
    }
}

var jAjax_enviar = function (obj) {
    
    if (!obj.validar()) {
        return false;
    }

    var aObj = $(obj.contentForm).find('input,textarea,button,select');
    var data = null;

    var myObject = new Object();
    $(aObj).each(function (key, ob) {
        if (ob.name != '' && ob.name != undefined) {
            if (myObject[ob.name] == undefined) {                
                switch (ob.type) {
                    case 'radio':
                        if (ob.checked) {
                            myObject[ob.name] = ob.value.replace('"', "'").replace(/\r?\n/gi, " --n ");
                        }
                        break;
                    case 'checkbox':
                        if (ob.checked) {
                            myObject[ob.name] = ob.value.replace('"', "'").replace(/\r?\n/gi, " --n ");
                        }
                        break;
                    default:
                        myObject[ob.name] = ob.value.replace('"', "'").replace(/\r?\n/gi, " --n ");
                        break;
                }
            } else {
                switch (ob.type) {
                    case 'radio':
                        if (ob.checked) {
                            myObject[ob.name] = myObject[ob.name] + ',' + ob.value.replace('"', "'").replace(/\r?\n/gi, " --n ");
                        }
                        break;
                    case 'checkbox':
                        if (ob.checked) {
                            myObject[ob.name] = myObject[ob.name] + ',' + ob.value.replace('"', "'").replace(/\r?\n/gi, " --n ");
                        }
                        break;
                    default:
                        myObject[ob.name] = myObject[ob.name] + ',' + ob.value.replace('"', "'").replace(/\r?\n/gi, " --n ");
                        break;
                }
            }
        }
    });

    var aleatorio = Math.random();
    myObject['aleatorio'] = aleatorio;

    obj.loading();

    /*Se convierte en json para enviarlo*/
    data = JSON.stringify(myObject);
    data = $.parseJSON(data);
    
    $.ajax({
        type: obj.method,
        url: obj.url,
        data: data,
        cache:false,
        datatype: "json",
        success: function (respuesta) {            
            var respuesta = $.parseJSON(respuesta);
            $(obj.contentResult).html(respuesta.resultado);
            if (respuesta.funcion != '') {
                $('#script').html(respuesta.funcion);
            }

            if (respuesta.mensaje != '') {
                if (document.getElementById('divMensaje') == null) {
                    if (obj.divMensaje == '') {
                        alert(respuesta.mensaje);
                    } else {
                        obj.Mostrar_Mensaje(respuesta.mensaje);
                        setTimeout(function () {
                            frmOcultar_Mensaje(obj);
                        }, 10000);
                    }
                } else {
                    /*Muestro el mensaje y lo dejo visible por unos 5 mminutos*/
                    obj.divMensaje = 'divMensaje';
                    obj.Mostrar_Mensaje(respuesta.mensaje);
                    setTimeout(function () {
                        frmOcultar_Mensaje(obj);
                    }, 10000);
                }
            }
        },
        complete: function () {
            obj.terminado();
        },
        error: function () {
            $(obj.contentResult).html('Ocurrió un Error al intentar conectarse');
        }
    });
}