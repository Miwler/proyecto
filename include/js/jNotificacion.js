var n_ultimo = 0;
var n_primero = 0;
var title = window.parent.document.title;

function distribuir_notificacion() {
    var data = '';
    /*Se convierte en json para enviarlo*/
    data = $.parseJSON(data);

    $.ajax({
        type: 'post',
        url: '/Notificacion/Distribuir_Notificaciones'
    });
}

function extraer_cantidad_notificacion() {
    var data = '';
    /*Se convierte en json para enviarlo*/
    data = $.parseJSON(data);

    $.ajax({
        type: 'post',
        url: '/Notificacion/Extraer_Cantidad_Notificacion',
        data: data,
        datatype: "json",
        success: function (respuesta) {
            var respuesta = $.parseJSON(respuesta);

            if (respuesta.cantidad == -1) {
                return;
            }

            if (respuesta.cantidad > 0) {
                $('#trSinNotificacion').css('display', 'none');
                $('#imgNotificacion', window.parent.document).addClass('notificado');
                $('#imgNotificacion', window.parent.document).attr('title', respuesta.cantidad + ' notificaciones sin leer.');

                if (respuesta.cantidad > 9) {
                    $('#spanNotificacion', window.parent.document).css('left', '4px');
                    $('#spanNotificacion', window.parent.document).html(9 + '+');
                } else {
                    $('#spanNotificacion', window.parent.document).css('left', '6px');
                    $('#spanNotificacion', window.parent.document).html(respuesta.cantidad);
                }
            } else {
                var tb = document.getElementById('tbNotificacion');
                $(tb).find('tr.item').each(function (key, obj) {
                    tb.deleteRow(obj.rowIndex);
                });
                $('#trSinNotificacion').css('display', 'block');
                $('#imgNotificacion', window.parent.document).removeClass('notificado');
                $('#spanNotificacion', window.parent.document).css('left', '6px');
                $('#spanNotificacion', window.parent.document).html('');
            }
            
            if (respuesta.cantidad == 0) {
                window.parent.document.title = title;
            } else {
                window.parent.document.title = '('+ respuesta.cantidad +') ' + title;
            }
            
            setTimeout('extraer_cantidad_notificacion()', 5000);
        },
        error: function () {
            $('#imgNotificacion', window.parent.document).removeClass('notificado');
            $('#spanNotificacion', window.parent.document).css('left', '6px');
            $('#spanNotificacion', window.parent.document).html('');
        }
    });
}
setTimeout('extraer_notificacion()', 3000);
function extraer_notificacion() {
    var tb = document.getElementById('tbNotificacion');
    $.ajax({
        type: 'post',
        url: '/Funcion/ajaxExtraer_Notificacion',
        data: {
           
        },
        datatype: "json",
        success: function (respuesta) {
            var respuesta = $.parseJSON(respuesta);
           $('#contenedorNotificacion').html(respuesta.html);
           $("#contenedorContador").html(respuesta.contador);
           $("#stronContador").html("("+respuesta.contador+")");
            //setTimeout('extraer_notificacion()', 5000);
        },
        complete: function () {
            //redimencionarWindow();
        },
    });
}

function extraer_notificacion_page()
{
    var tb = document.getElementById('tbNotificacion');
    $.ajax({
        type: 'post',
        url: '/Notificacion/Extraer_Notificacion_page',
        data: {
            n_primero: n_primero
        },
        datatype: "json",
        success: function (respuesta) {
            var respuesta = $.parseJSON(respuesta);

            var rowsNotificacion = 0;
            var contenido;
            var n;
            var responsable;
            var asunto;
            var descripcion;
            var estado;
            var tbRows = tb.rows.length;

            if (respuesta.notificacion != '') {
                rowsNotificacion = respuesta.notificacion.length
                if (rowsNotificacion > 0)                {
                    $('#trSinNotificacion').css('display', 'none');
                }
                if (rowsNotificacion > 9) {
                    rowsNotificacion = 9;
                }
            }

            for (var i = 1; i < rowsNotificacion + 1; i++) {
                var f = i - 1;
                n = respuesta.notificacion[f].n;
                responsable = respuesta.notificacion[f].responsable;
                asunto = respuesta.notificacion[f].asunto;
                descripcion = respuesta.notificacion[f].descripcion;
                estado=respuesta.notificacion[f].estado;

                contenido = '<input type="text" value="' + n + '" style="display:none;"/><div class="header"><span id="nombreNotificacion">' + responsable +
                            '</span> ' + asunto + '</div>' +
                            '<div class="descripcion">' + descripcion + '<br /><b>Estado:</b> <a>' + estado + '</a></div>';
                var row = tb.insertRow(i);
                row.className = 'item';
                row.id = 'trItem_' + n;

                row.onclick = function () {
                    redireccionar('/Notificacion/Redireccionar/' + this.cells[0].innerHTML,false);
                }

                var cell0 = row.insertCell(0);
                cell0.innerHTML = n;
                cell0.style.display = 'none';

                var cell1 = row.insertCell(1);
                cell1.innerHTML = contenido;

                if (i == rowsNotificacion) {
                    n_primero = n;
                }                
            }
        }
    });
}

function marcar_leido_todos() {   
    $.ajax({
        type: 'get',
        url: '/Notificacion/Marcar_Leido_Todo',
        data: {},
        cache: false,
        datatype: "json",
        success: function (respuesta) {
            var respuesta = $.parseJSON(respuesta);            
            if (respuesta.funcion != '') {
                $('#script').html(respuesta.funcion);
            }
        }
    });
}


function redireccionar(url, wParent) {
    if (wParent) {
        parent.document.location = url;
    } else {
        document.location = url;
    }
}

function redimencionarWindow() {
    var tb = document.getElementById('tbNotificacion');
    if (tb != null) {
        var height = ((tb.rows.length - 1) * 39) + 27;
        $('#iNotificacion', window.parent.document).animate({
            height: height + 'px'
            
        });
        //alert('fee');
    }
}

