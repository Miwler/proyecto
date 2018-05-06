var form = function (frm,div)
{
    this.Form = document.getElementById(frm) ;
    this.Div = document.getElementById(div);
    this.divMensaje ='';
    this.btn = '';
    this.url = '';
	this.txtnum='';

    var obj = this;
    this.enviar = function (btn) {
       // alert();
        obj.btn = btn;
        enviar(obj,btn);
    }

    this.ajaxGuardar= function (btn) {
        obj.btn = btn;
        ajaxGuardar(obj, btn);
    }

    this.terminado = function () { }
    this.error= function () { }
    this.validar = function () { return true; }

    this.Mostrar_Mensaje = function (msj) {
        frmMostrar_Mensaje(obj, msj);
    };

    this.Ocultar_Mensaje = function () {
        frmOcultar_Mensaje(obj);
    }
}


var enviar = function (obj,btn)
{ //alert('ddg');
    if (!obj.validar()){
        return false;
    }

    var data = null;
    var myObject = new Object();
   /* $(obj.Form).serializeArray().forEach(function (ob, key) {
        if (myObject[ob.name] == undefined) {
            myObject[ob.name] = ob.value.replace('"', "'").replace(/\r?\n/gi, " --n ");
        } else {
            myObject[ob.name] = myObject[ob.name] + ',' + ob.value.replace('"', "'").replace(/\r?\n/gi, " --n ");
        }
    });*/

    $(obj.Form).find('input,textarea,button,select').each(function (key, ob) {
        if (ob.name != '' && ob.name != undefined) {
            if (myObject[ob.name] == undefined) {
               // alert(ob.name);
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
    myObject['btnEnviar'] = btn;
    //alert(myObject['btnEnviar']);
    $(obj.Div).html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');

    /*Se convierte en json para enviarlo*/

    data = JSON.stringify(myObject);
    data = $.parseJSON(data);
 //alert (data);
    $.ajax({
        type: $(obj.Form).attr('method'),
        url: (obj.url == '') ? $(obj.Form).attr('action') : obj.url,
        data: data,
        cache:false,
        datatype: "json",

        success: function (respuesta) {

           //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);

            $(obj.Div).html(respuesta.resultado);
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
        error: function ()
        {
            //alert('error');
            obj.error();
            $(obj.Div).html('Ocurrió un Error al intentar conectarse');
        }
    });
}

var ajaxGuardar= function (obj, btn) {
    if (!obj.validar()) {
        return false;
    }

    var data = new FormData();
    $(obj.Form).serializeArray().forEach(function (ob, key) {
        data.append(ob.name, ob.value);
    });

    var sizeArchive = 0;
    $(obj.Form).find('input[type=file]').each(function (key, ob) {
        var files = $("#" + ob.id).get(0).files;
        for (i = 0; i < files.length; i++) {
            data.append("file" + i, files[i]);
            sizeArchive = sizeArchive + files[i].size;
        }
    });

    //Configuro la cantidad de Megas a subir 4194304 bytes=4MB
    if (sizeArchive > 4194304){
        alert('El o los archivos a subir deben ser menores a 4 MB.');
        $('#txtFoto_Nueva').focus();
        return false;
    }

    $(obj.Div).html('<div id="grid-loading"><center>Guardando...</center></div>');
     $.ajax({
        type: $(obj.Form).attr('method'),
        url: $(obj.Form).attr('action'),
        contentType: false,
        processData: false,
        data: data,
        datatype: "json",
        success: function (respuesta) {
            var respuesta = $.parseJSON(respuesta);
            $(obj.Div).html(respuesta.mensaje);

            if (respuesta.funcion != '') {
                $('#script').html(respuesta.funcion);
            }
        },
        complete: function () {
            obj.terminado();
        },
        error: function () {
            $(obj.Div).html('');
            alert('Ocurrió un Error al intentar conectarse');
        }
    });
}

function frmMostrar_Mensaje(obj, msj) {
    $('#' + obj.divMensaje).html(msj);
    $('#'+obj.divMensaje).slideDown('slide');

}
function frmOcultar_Mensaje(obj) {
    $('#' + obj.divMensaje).slideUp('slide');
}

var enviarValor = function (divForm,divResultado,url,url1)
{

   /*var vali=validaHijo();
    if(vali==false){
        return false;
    }
    */
    var data = null;
    var myObject = new Object();

    $('#'+divForm).find('input,textarea,button,select').each(function (key, ob) {
		//alert(ob.value+ob.name);
        if (ob.name != '' && ob.name != undefined) {
            if (myObject[ob.name] == undefined) {
               // alert(ob.name);
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
    /*myObject['btnEnviar'] = btn;  */
    //alert(myObject['btnEnviar']);
    $('#'+divResultado).html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');

    /*Se convierte en json para enviarlo*/

    data = JSON.stringify(myObject);
    data = $.parseJSON(data);
 //alert (data);
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        cache:false,
        datatype: "json",

        success: function (respuesta) {
            var respuesta = $.parseJSON(respuesta);
            alert(respuesta);
            //alert(respuesta.mensaje);
            //$('#'+divResultado).html(respuesta.resultado);
            //$('#txtcotizacion_detalle_ID').val(respuesta.cotizacion_detalle_ID);
           if(respuesta.resultado==1){
               mostrarValores(divResultado,url1,respuesta.ID);

           }
        },
        complete: function () {

            //$('#ModalProducto').modal( 'toggle' );

        },
        error: function ()
        {
            //divForm.error();
            $(divForm).html('Ocurrió un Error al intentar conectarse');
        }
    });
}

var enviarValorHijo = function (divForm,divResultado,url,url1)
{
   /* if (!obj.validar()){
        return false;
    }*/

    var data = null;
    var myObject = new Object();

    $('#'+divForm).find('input,textarea,button,select').each(function (key, ob) {

        if (ob.name != '' && ob.name != undefined) {
            if (myObject[ob.name] == undefined) {
               // alert(ob.name);
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
    /*myObject['btnEnviar'] = btn;  */
    //alert(myObject['btnEnviar']);
    $('#'+divResultado).html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');

    /*Se convierte en json para enviarlo*/

    data = JSON.stringify(myObject);
    data = $.parseJSON(data);
 //alert (data);
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        cache:false,
        datatype: "json",

        success: function (respuesta) {
            //alert(respuesta);

            var respuesta = $.parseJSON(respuesta);

            alert(respuesta.mensaje);
            //$('#'+divResultado).html(respuesta.resultado);
           if(respuesta.resultado==1){
               mostrarValores(divResultado,url1,respuesta.ID);
           }

        },
        complete: function () {

          //$('#ModalProducto').modal( 'toggle' );


        },
        error: function ()
        {
            //divForm.error();
            $(divForm).html('Ocurrió un Error al intentar conectarse');
        }
    });
}
var enviarValores = function (divForm,url,resultado)
{

   /*var vali=validaHijo();
    if(vali==false){
        return false;
    }
    */
    var data = null;
    var myObject = new Object();

    $('#'+divForm).find('input,textarea,button,select').each(function (key, ob) {
		//alert(ob.value+ob.name);
        if (ob.name != '' && ob.name != undefined) {
            if (myObject[ob.name] == undefined) {
               // alert(ob.name);
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
    /*myObject['btnEnviar'] = btn;  */
    //alert(myObject['btnEnviar']);

    /*Se convierte en json para enviarlo*/

    data = JSON.stringify(myObject);
    data = $.parseJSON(data);
 //alert (data);
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        cache:false,
        datatype: "json",

       success: function (respuesta) {
           //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            resultado(respuesta);

        },
        complete: function () {

            //$('#ModalProducto').modal( 'toggle' );

        },
        error: function ()
        {
            //divForm.error();
            alert('ocurrio un error');
        }
    });
}
var mostrarValores = function (divResultado,url,id)
{

//alert(id);
    $.ajax({
        type: "post",
        url: url,
        data: {
            ID: id

        },
        datatype: "json",

        success: function (respuesta) {
          //alert(respuesta);

            var respuesta = $.parseJSON(respuesta);

            $('#'+divResultado).html(respuesta.resultado);
            if (respuesta.funcion != '') {
                //alert(respuesta.funcion);
                $('#script').html(respuesta.funcion);
            }
        },
        complete: function () {
            if (!limpiar()){
                limpiar();;
            }

        },
        error: function ()
        {
            //divForm.error();
            $(divForm).html('Ocurrió un Error al intentar conectarse');
        }
    });
}
var mostrarValor = function (divResultado,url,id,divresultado1)
{
    $.ajax({
        type: "post",
        url: url,
        data: {
            ID: id

        },
        datatype: "json",

        success: function (respuesta) {
           // alert(respuesta);

            var respuesta = $.parseJSON(respuesta);

            $('#'+divResultado).val(respuesta.resultado);
            $('#'+divresultado1).val(respuesta.resultado1);
            if (respuesta.funcion != '') {
                //alert(respuesta.funcion);
                //$('#script').html(respuesta.funcion);
            }
        },
        complete: function () {

         // ajaxSelect('selCategoria', '/Compra/ajaxSelect_Categoria/' + respuesta.resultado1, '',null);
        },
        error: function ()
        {
            //divForm.error();
            alert(respuesta.mensaje);
            //$(divForm).html('Ocurrió un Error al intentar conectarse');
        }
    });
}
var cargarValores=function(url,id,resultado){
  $.ajax({
      type: "post",
      url: url,
      data: {
          id: id
      },
      datatype: "json",
      success: function (respuesta) {
        try {
          console.log(respuesta);
          resultado($.parseJSON(respuesta));
        } catch (e) {
            $.unblockUI();
            console.log(e);
            alert(e.message);
        }
      },
      error: function (ex) {
        console.log(ex);
          alert(ex);
          //$('#' + objContent).html('Error al conectarse con el servidor');
      }
  });
}

var cargarValores1=function(url,id,id1,resultado){
    //alert(id);
    $.ajax({
        type: "post",
        url: url,
        data: {
            id: id,
            id1: id1
        },
        datatype: "json",
        success: function (respuesta) {
           //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            resultado(respuesta);

        },
        error: function () {
            alert(respuesta.mensaje);
            //$('#' + objContent).html('Error al conectarse con el servidor');
        }
    });
}
var cargarValores2=function(url,id,id1,id2,resultado){
    //alert(id);
    $.ajax({
        type: "post",
        url: url,
        data: {
            id: id,
            id1: id1,
            id2: id2
        },
        datatype: "json",
        success: function (respuesta) {
           //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            resultado(respuesta);

        },
        error: function () {
            alert(respuesta.mensaje);
            //$('#' + objContent).html('Error al conectarse con el servidor');
        }
    });
}
var cargarValores3=function(url,id,id1,id2,id3,resultado){
    //alert(id);
    $.ajax({
        type: "post",
        url: url,
        data: {
            id: id,
            id1: id1,
            id2: id2,
            id3:id3
        },
        datatype: "json",
        success: function (respuesta) {
           //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            resultado(respuesta);

        },
        error: function () {
            alert(respuesta.mensaje);
            //$('#' + objContent).html('Error al conectarse con el servidor');
        }
    });
}
var cargarFormularios=function(url,divForm,funcion,resultado){
    if(funcion!=null){
        funcion.apply();
    }


    var data = null;
    var myObject = new Object();

    $('#'+divForm).find('input,textarea,button,select').each(function (key, ob) {

        if (ob.name != '' && ob.name != undefined) {
            if (myObject[ob.name] == undefined) {
               // alert(ob.name);
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
                 //alert(ob.name);
            }
        }
    });

    var aleatorio = Math.random();
    myObject['aleatorio'] = aleatorio;
    data = JSON.stringify(myObject);
    data = $.parseJSON(data);


    $.ajax({
        type: "post",
        url: url,
        data: data,
        cache:false,
        datatype: "json",
        success: function (respuesta) {
           //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            resultado(respuesta);

        },
        error: function () {
            alert(respuesta.mensaje);
            //$('#' + objContent).html('Error al conectarse con el servidor');
        }
    });
}
var enviarFormulario = function(url,divForm,resultado)
{

    var data = null;
    var myObject = new Object();

    $('#'+divForm).find('input,textarea,button,select').each(function (key, ob) {

        if (ob.name != '' && ob.name != undefined) {
            if (myObject[ob.name] == undefined) {
               // alert(ob.name);
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
    /*myObject['btnEnviar'] = btn;  */
    //alert(myObject['btnEnviar']);
    //$('#'+divForm).html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');

    /*Se convierte en json para enviarlo*/

    data = JSON.stringify(myObject);
    data = $.parseJSON(data);
 //alert (data);
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        cache:false,
        datatype: "json",

        success: function (respuesta) {

            //alert(respuesta);

            var respuesta = $.parseJSON(respuesta);
            resultado(respuesta);


        },
        complete: function () {

        },
        error: function ()
        {
            //divForm.error();
            $(divForm).html('Ocurrió un Error al intentar conectarse');
        }
    });
}

var actualizarCk=function(url,id,valor){
     //$('#' + objContent).html('<div id="grid-loading"><img style="width:40%;" src="/include/img/loading-select.gif" /></div>');

    $.ajax({
        type: "post",
        url: url,
        data: {
            cotizacion_detalle_ID: id,
            ver_precio: valor
        },
        datatype: "json",
        success: function (respuesta) {
            //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);

        },
        error: function () {
            alert(respuesta.mensaje);
            //$('#' + objContent).html('Error al conectarse con el servidor');
        }
    });
}

var seleccionarCk=function(url,ID1,ID2){
     //$('#' + objContent).html('<div id="grid-loading"><img style="width:40%;" src="/include/img/loading-select.gif" /></div>');
   //alert(ID1);
    $.ajax({
        type: "post",
        url: url,
        data: {
            ID1: ID1,
            ID2:ID2
        },
        datatype: "json",
        success: function (respuesta) {
            //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            if(respuesta.mensaje){
                 alert(respuesta.mensaje);
            }

        },
        error: function () {
            alert(respuesta.mensaje);
            //$('#' + objContent).html('Error al conectarse con el servidor');
        }
    });
}
var regitrarSeries=function(url,ID,serie){
     //$('#' + objContent).html('<div id="grid-loading"><img style="width:40%;" src="/include/img/loading-select.gif" /></div>');
   //alert(menu_ID);
    $.ajax({
        type: "post",
        url: url,
        data: {
            ID: ID,
            serie: serie
            //inventario_ID2:inventario_ID2
        },
        datatype: "json",
        success: function (respuesta) {
            //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            if(respuesta.resultado==0){
            alert(respuesta.mensaje);
            }
            if(respuesta.resultado==2){
                alert(respuesta.mensaje);
                fncInventarioSalida();
            }
            //alert(respuesta.resultado);
        },
        error: function () {
            alert(respuesta.mensaje);
            //$('#' + objContent).html('Error al conectarse con el servidor');
        }
    });
}

        function soloLetras(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            especiales = "8-37-39-46";

            tecla_especial = false
            for (var i in especiales) {
                if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                return false;
            }
        }



        //funcion para solo numeros decimal con 2  decimales
        function numeroDecimal(e, field) {
            key = e.keyCode ? e.keyCode : e.which
            // backspace
            if (key == 8)
                return true
            // 0-9
            if (key > 47 && key < 58) {
                if (field.value == "")
                    return true
                regexp = /.[0-9]{2}$/
                return !(regexp.test(field.value))
            }
            // .
            if (key == 46) {
                if (field.value == "")
                    return false
                regexp = /^[0-9]+$/
                return regexp.test(field.value)
            }
            // other key
            return false
        }


		//funcion para solo numeros decimal con 4 decimales
        function numeroDecimal4(e, field) {
            key = e.keyCode ? e.keyCode : e.which
            // backspace
            if (key == 8)
                return true
            // 0-9
            if (key > 47 && key < 58) {
                if (field.value == "")
                    return true
                regexp = /.[0-9]{4}$/
                return !(regexp.test(field.value))
            }
            // .
            if (key == 46) {
                if (field.value == "")
                    return false
                regexp = /^[0-9]+$/
                return regexp.test(field.value)
            }
            // other key
            return false
        }

        // Block UI Element
function block_ui(eo_function) {
    var html_message =
        '<div class="progress" style="margin: 0px !important;">' +
        '<div class="progress-bar progress-bar-teal progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">' +
        '<span class="label label-defaul"><strong>Procesando petici&oacute;n</strong></span>' +
        '</div>' +
        '<div>';
    $.blockUI(
        {
            fadeIn: 1000,
            message: html_message,
            onBlock: eo_function
        });
    //$.unblockUI();
}





        //funcion para solo numeros
