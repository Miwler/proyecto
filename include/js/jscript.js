var divUsuarioAccion_select = false;
var divHeader_left_select = false;
var w = 0;
var fParent;
var fParent1;
var fParent2;
var fparentPadre;
var fparentPadre1;
var interfaz=0;
$(function () {    
    verificarNavegador();
        
    $('html').click(function () {       
        if (divUsuarioAccion_select == false && $('#divUsuarioAccion').css('display') == 'block') {
            $('#divUsuarioAccion').css('display', 'none');
        }
       
        if (divHeader_left_select == false && $('#divNotificacion').css('display') == 'block') {
            $('#divNotificacion').css('display', 'none');
        }
    });    

    /*Usuario*/
    $('#foto_perfil_24x24').click(function () {        
        if ($('#divUsuarioAccion').css('display') == 'none')
        {            
            $("#divUsuarioAccion").fadeIn(1000);            
            divUsuarioAccion_select = true;
        } else {            
            $("#divUsuarioAccion").fadeOut(2000);
            divUsuarioAccion_select = false;
        }
    });
      
    $('#foto_perfil_24x24').mouseleave(function () {
        divUsuarioAccion_select = false;
    });

    $('#divUsuarioAccion').mouseleave(function () {
        divUsuarioAccion_select = false;        
    });

    $('#divUsuarioAccion').mouseenter(function () {
        divUsuarioAccion_select = true;
    });
    
    /*Notificaciones*/
    $('#aNotificaciones').click(function () {
       
       if ($('#divNotificacion').css('display') == 'none') {

            $('#divNotificacion').css('display', 'block')
            divHeader_left_select = true;

        } else {            
            divHeader_left_select = false;
        }
    });

    $('#aNotificaciones').mouseleave(function () {
        divHeader_left_select = false;
    });

    $('#aNotificaciones').mouseleave(function () {
        divHeader_left_select = false;
    });

    $('#aNotificaciones').mouseenter(function () {
        divHeader_left_select = true;
    });    
	
	fncResize();
});

function verificarNavegador() {    
    if (!document.documentMode)        
        return false;
    if (document.documentMode <= 8) {
        window.location = '/Home/Navegador_Incompatible';
    }
}

function validar() {   
    $('#result').html('');    
    var usuario = $('#usuario').val();
    var contrasena = $('#contrasena').val();
    
    if ($.trim(usuario) == '' || $.trim(contrasena) == '')
    {        
        $('#result').html("El usuario y contraseña son requeridos");
        $('#usuario').focus();
        $('#usuario').val('');
        $('#contrasena').val('');
        return false;
    }

    $('#btnEnviar').css('display', 'none');
    $('#img-loader').css('display', '');
        
    $.ajax({
        type: "post",
        url: "/Acceso/validar",
        data: {
            nUsuario: usuario,
            contrasena: contrasena
        },
        cache:false,
        datatype: "json",
        success: function (respuesta) {
            var respuesta = $.parseJSON(respuesta);
            if (respuesta.resultado == -1) {
                $('#btnEnviar').css('display', '');
                $('#img-loader').css('display', 'none');

                $('#usuario').val('');
                $('#contrasena').val('');
                $('#usuario').focus();
                $('#result').html(respuesta.mensaje);
            } else {
                var query = '';

                if (getUrlVars()['q'] != undefined) {
                    query = '?q=' + getUrlVars()['q'];
                }

                window.location = "/Home/"+query;
            }
        },
        error: function () {
            $('#btnEnviar').css('display', '');
            $('#img-loader').css('display', 'none');

            $('#usuario').val('');
            $('#contrasena').val('');
            $('#usuario').focus();
            alert("Error de Conexión");
        }
    });  
}

function logout()
{    
    $.ajax({
        type: "post",
        url: "/Acceso/logout",
        data: { usuario:"1"          
        },
        datatype: "json",
        success: function (respuesta) {            
            var respuesta = $.parseJSON(respuesta);
            if (respuesta.resultado == -1) {
                alert(respuesta.mensaje);
            } else {
                window.location = "/";
            }
        }
    });    
}


function getValueRadioByName(id)
{
    var chk = document.getElementsByName(id);
    var count = chk.length;
    var valor='';
    var i = 0;
    
    for (i = 0; i < count; i++)
    {
        if (chk[i].checked)
        {
            valor = chk[i].value;
        }           
    }
    return valor;
}

function window_float_open(url,id,q,f0)
{
    $('body').css('overflow-y','hidden');
    var idIframe = document.getElementById('iwindow-float');
    if (idIframe != null){
        return false;
    }
    var contenedor_pantalla=$('#contenedor_pantalla').height();
    var altoPantalla=$(window).height();
    var altop=0;
    /*if(altoPantalla>contenedor_pantalla){
        altop=altoPantalla;
    }else {
        altop=contenedor_pantalla;
    }*/
    $('#divContent-float').css('display', 'block');  
    //$('#divContent-float').height(altop);
    $('#loading-float').css('display', 'block');
    //var altoFloat=window.parent.parent.document.getElementById('iwindow-float').style.height;
   

    if (typeof (f0) == 'undefined') {        
        if (typeof (f0) == 'undefined') {
            fParent= '';
        } else {
            fParent = f0;
        }        
    } else {
        fParent= f0;
    }
   
    var aleatorio = Math.random();

    var iframe = document.createElement('iframe');	
    var window_float = $('#window-float');
    iframe.id = 'iwindow-float';
    iframe.scrolling = 'no';   
	iframe.style.border=0;
	
	/*Envio el ID*/
    var  cad = (id != '') ? '/' + id : '';  
	
	/*Envio la cadena de consultas*/
	if (typeof (q) == 'undefined') {      
		cad =cad +'?aleatorio=' + aleatorio;
	} else{
		cad =cad +'?'+ q +'&aleatorio=' + aleatorio;
	}
	
	iframe.src = url.toLowerCase() + cad ;
        iframe.className+=" embed-responsive-item"; //embed-responsive-item
        //$(iframe).css('width','100%');
        window_float.append(iframe);
		
	$('#window-float').css('display', 'block');
    
    
 
    window.scrollTo(0, 0);
     var altoContenedor=0;
    $(iframe).load(function(){
        altoContenedor= $('#iwindow-float').height();
        
    });
    if (screen.width<1024){
    //codigo resolución pequeña 
     
    }else if (screen.width<1280){
    //codigo resolución mediana 
    $(iframe).css('min-width','400px');
    }else {
    $(iframe).css('min-width','600px');
    }
    var altoFondo=0;
    if(altoPantalla > altoContenedor){
        altoFondo=altoPantalla;
    }else {
        altoFondo=altoContenedor+15;
    }
    if(altoFondo>altop){
        $('#divContent-float').height(altoFondo); 
    }else {
        $('#divContent-float').height(altop); 
    }
     
}
function window_float_open_modal(titulo,url,id,q,f0,ancho,alto)
{
    


    if (typeof (f0) == 'undefined') {        
        if (typeof (f0) == 'undefined') {
            fParent= '';
        } else {
            fParent = f0;
        }        
    } else {
        fParent= f0;
    }
   
    var aleatorio = Math.random();

    var iframe = document.createElement('iframe');	
    //var window_float = $('#window-float');
    iframe.id = 'iwindow-float-modal';
    iframe.scrolling = 'no';   
	iframe.style.border=0;
	
	/*Envio el ID*/
    var  cad = (id != '') ? '/' + id : '';  
	
	/*Envio la cadena de consultas*/
	if (typeof (q) == 'undefined') {      
		cad =cad +'?aleatorio=' + aleatorio;
	} else{
		cad =cad +'?'+ q +'&aleatorio=' + aleatorio;
	}
	
	iframe.src = url.toLowerCase() + cad ;
        //iframe.className+="embed-responsive-item"; //embed-responsive-item
        var window_float=$("#float_modal .modal-body");
        
        $("#float_modal .modal-title").html(titulo);
        window_float.html(iframe);
        var alto_minimo="400px";
        var ancho_minimo="500px";
        if(alto){
            alto_minimo=alto+"px";
            $(iframe).css('min-height',alto_minimo);
        }
        
        if(ancho){
            var ancho_minimo=ancho+30;
            $(iframe).css('min-width',ancho+"px");
            $("#float_modal .modal-content").css('min-width',ancho_minimo);
        }
        $(iframe).css('width',"100%");
        $(iframe).addClass("embed-responsive-item");
        /*$("#float_modal").on('show.bs.modal', function () {
            alert('The modal is about to be shown.');
        });*/
	$('#float_modal').modal('show');
        $('#float_modal').on('shown.bs.modal', function () {
            
        })
       
        //var altoContenedor=0;
  
}
function serialize(arr)
{
var res = 'a:'+arr.length+':{';
for(i=0; i<arr.length; i++)
{
res += 'i:'+i+';s:'+arr[i].length+':"'+arr[i]+'";';
}
res += '}';
 
return res;
}
function window_float_open_modal_hijo(titulo,url,id,q,f0,ancho,alto)
{
   
    if (typeof (f0) == 'undefined') {        
        if (typeof (f0) == 'undefined') {
            fParent1= '';
        } else {
            fParent1 = f0;
        }        
    } else {
        fParent1= f0;
    }
   
    var aleatorio = Math.random();

    var iframe = document.createElement('iframe');	
    //var window_float = $('#window-float');
    iframe.id = 'iwindow-float-modal-hijo';
    iframe.scrolling = 'no';   
	iframe.style.border=0;
	
	/*Envio el ID*/
    var  cad = (id != '') ? '/' + id : '';  
	
	/*Envio la cadena de consultas*/
       
		
	if ($.trim(q)!=""||q.length>0) {
           
            cad =cad +'?'+ q +'&aleatorio=' + aleatorio;
		
	} else{
           cad =cad +'?aleatorio=' + aleatorio;
	}
	//alert(cad);
	iframe.src = url.toLowerCase() + cad ;
        //iframe.className+="embed-responsive-item"; //embed-responsive-item
        var window_float=$("#float_modal_hijo .modal-body");
        
        $("#float_modal_hijo .modal-title").html(titulo);
        window_float.html(iframe);
        var alto_minimo="400px";
        //var ancho_minimo="500px";
        if(alto){
            alto_minimo=alto+"px";
            $(iframe).css('min-height',alto_minimo);
        }
        
        if(ancho){
            var ancho_minimo=ancho+30;
            $(iframe).css('min-width',ancho+"px");
            $("#float_modal_hijo .modal-content").css('min-width',ancho_minimo);
        }
        $(iframe).css('width',"100%");
        $(iframe).addClass("embed-responsive-item");
        $("#float_modal").modal('hide');
	$('#float_modal_hijo').modal('show');
        //var altoContenedor=0;
  
}
function window_float_open_modal_hijo_hijo(titulo,url,id,q,f0,ancho,alto)
{
    if (typeof (f0) == 'undefined') {        
        if (typeof (f0) == 'undefined') {
            fParent2= '';
        } else {
            fParent2 = f0;
        }        
    } else {
        fParent2= f0;
    }
   
    var aleatorio = Math.random();

    var iframe = document.createElement('iframe');	
    //var window_float = $('#window-float');
    iframe.id = 'iwindow-float-modal-hijo-hijo';
    iframe.scrolling = 'no';   
	iframe.style.border=0;
	
	/*Envio el ID*/
    var  cad = (id != '') ? '/' + id : '';  
	
	/*Envio la cadena de consultas*/
	if (typeof (q) == 'undefined') {      
		cad =cad +'?aleatorio=' + aleatorio;
	} else{
		cad =cad +'?'+ q +'&aleatorio=' + aleatorio;
	}
	
	iframe.src = url.toLowerCase() + cad ;
        //iframe.className+="embed-responsive-item"; //embed-responsive-item
        var window_float=$("#float_modal_hijo_hijo .modal-body");
        
        $("#float_modal_hijo_hijo .modal-title").html(titulo);
        window_float.html(iframe);
        var alto_minimo="400px";
        //var ancho_minimo="500px";
        if(alto){
            alto_minimo=alto+"px";
            $(iframe).css('min-height',alto_minimo);
        }
        
        if(ancho){
            var ancho_minimo=ancho+30;
            $(iframe).css('min-width',ancho+"px");
            $("#float_modal_hijo_hijo .modal-content").css('min-width',ancho_minimo);
        }
        $(iframe).css('width',"100%");
        
        $("#float_modal_hijo").modal('hide');
	$('#float_modal_hijo_hijo').modal('show');
        //var altoContenedor=0;
  
}
function window_float_open_padre(url,id,q,f0)
{
	
    var idIframe = document.getElementById('iwindow-float-padre');
    if (idIframe != null){
        return false;
    }
    var altoPantalla=$(window).height();
    var altoContenedor= $('#contenedor_pantalla').height();
    var altoFondo=0;
    if(altoPantalla > altoContenedor){
        altoFondo=altoPantalla;
    }else {
        altoFondo=altoContenedor;
    }
    
    $('#divContent-float-padre').css('display', 'block');  
    $('#divContent-float-padre').height(altoFondo);
    $('#loading-float-padre').css('display', 'block');

    if (typeof (f0) == 'undefined') {        
        if (typeof (f0) == 'undefined') {
            fparentPadre= '';
        } else {
            fparentPadre = f0;
        }        
    } else {
        fparentPadre= f0;
    }
   
    var aleatorio = Math.random();

    var iframe = document.createElement('iframe');	
    var window_float = $('#window-float-padre');
    iframe.id = 'iwindow-float-padre';
    iframe.scrolling = 'no';   
	iframe.style.border=0;
	
	/*Envio el ID*/
    var  cad = (id != '') ? '/' + id : '';  
	
	/*Envio la cadena de consultas*/
	if (typeof (q) == 'undefined') {      
		cad =cad +'?aleatorio=' + aleatorio;
	} else{
		cad =cad +'?'+ q +'&aleatorio=' + aleatorio;
	}
	
	iframe.src = url.toLowerCase() + cad ;
    window_float.append(iframe);
		
	$('#window-float-padre').css('display', 'block');
        //$('#iwindow-float').css('display', 'block');
       // alert('fee');
      $('#iwindow-float-padre').css('height', '600px');
     // $('#iwindow-float').css('margin-left', '150px');
    window.scrollTo(0, 0);	    
}
function window_float_exportar(url,divForm,id,q)
{
    var data = null;
    //var myObject = new Object();
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
    data = JSON.stringify(myObject);
    data = $.parseJSON(data);
    $.ajax({
        type: "post",
        url: url,
        data: data,
        cache:false,
        datatype: "json",
       
        success: function (respuesta) { 
            
           
            var respuesta = $.parseJSON(respuesta);   
            if(respuesta.resultado==1){
                var idIframe = document.getElementById('iwindow-float');
                if (idIframe != null){
                    $("#window-float").html("");
                }
                var aleatorio1 = Math.random();

                var iframe = document.createElement('iframe');	
                var window_float = $('#window-float');
                iframe.id = 'iwindow-float';
                //id=2015;
                var  cad = (id != '') ? '/' + id : '';  
	
                /*Envio la cadena de consultas*/
                if (typeof (q) == 'undefined') {      
                        cad =cad +'?aleatorio=' + aleatorio1;
                } else{
                        cad =cad +'?'+ q +'&aleatorio=' + aleatorio1;
                }
                
                //alert(respuesta.dtReporte);
                var url="/Reporte/Exportar_Excel";
                iframe.src =url.toLowerCase() +"/"+ cad;
                window_float.append(iframe);
    //setTimeout(function(){$("#window-float").html("");},3000);    
            }
            
        },
        complete: function () {
            //obj.terminado();
            
        },
        error: function ()
        {
            //alert('error');
            alert('Error');
            
        }
    });
    //alert(data);
    
}
function float_close() {   
    $('body').css('overflow-y','auto');
    $('#divContent-float').fadeOut(1000, function () {
        $('#window-float').css('display', 'none');
        $('#divContent-float').css('display', 'none');
        $('#iwindow-float').remove();
    });    
}
function float_close_modal() {   
    //alert('');
    $("#float_modal .modal-body").html("");
    $("#float_modal").modal("hide");
    
}
function float_close_modal_hijo() {   
    $("#float_modal_hijo .modal-body").html("");
        $("#float_modal_hijo").modal("hide");
    if(interfaz==0){
        
        $("#float_modal").modal("show");
    }
    
    
}
function float_close_modal_hijo_hijo() {   
    //alert('');
    $("#float_modal_hijo_hijo .modal-body").html("");
    $("#float_modal_hijo_hijo").modal("hide");
    
    $("#float_modal_hijo").modal("show");
    
}
function windos_float_save_modal(parametro){
    if(parametro){
        fParent.call(this,parametro);
        //fParent1.apply();
    }else{
        fParent.apply();
    }
    
    float_close_modal();
}
function windos_float_save_modal_hijo(parametro){
    if(parametro){
        fParent1.call(this,parametro);
        //fParent1.apply();
    }else{
        fParent1.apply();
    }
    
    float_close_modal_hijo();
}
function windos_float_save_modal_hijo_hijo(parametro){
    if(parametro){
        fParent2.call(this,parametro);
        //fParent1.apply();
    }else{
        fParent2.apply();
    }
    
    float_close_modal_hijo_hijo();
}
function float_close_float() { 
   
    $('#windows_float_deslizador').fadeOut(1000, function () {
        $('#windows_float_deslizador').css('display', 'none');
        
        $('#iwindow-float1').remove();
    });    
}
function float_close_padre() {    
    $('#divContent-float-padre').fadeOut(1000, function () {
        $('#window-float-padre').css('display', 'none');
        $('#divContent-float-padre').css('display', 'none');
        $('#iwindow-float-padre').remove();
    });    
}
function window_open(url, q) {
    var cad = (q != '') ? '/' + q : '';    
    window.location = url + cad;

}

function redireccionar(url)
{
    window.location = url;
}

function returnPageBack() {
    window.history.back();
}

function redondear(numero, cantidad_decimal) {
   // console.log(numero);
   var nDecimal = Math.pow(10, cantidad_decimal);
    numero = numero + '';
    numero = numero.replace(',', '');
    var rNumero = Math.round(numero * nDecimal) / nDecimal;
    if (isNaN(rNumero)) {
        rNumero = 0;
    }
    new Intl.NumberFormat("de-DE").format(rNumero)
   // console.log(rNumero);*/
    return rNumero;
   // return Number.parseFloat(numero).toFixed(cantidad_decimal);
}
function formatear_moneda(numero,cantidad_decimal){
     return Number.parseFloat(numero).toFixed(cantidad_decimal);
    /*var retorna=numero.parseFloat;
    if(numero % 1!=0){
        var num=numero.toString().split('.');
        console.log(numero+"deed-"+decimal);
        if(num.lenght>0){
            var decimal=num[1];
            
            var largo=decimal.toString().length;
            if(largo<cantidad_decimal){
                retorna=numero.toString()+'.'+(zero.repeat(cantidad_decimal - largo));
            }
        }
    }
    return retorna;*/
    
}

function financiero(x) {
     x=x+'';
    x=x.replace(',', '');
  return Number.parseFloat(x).toFixed(2);
}
function fncMostrar_Mensaje(obj) {
    $(obj).slideDown('slide');

}
function fncOcultar_Mensaje(obj)
{    
    $(obj).slideUp('slide');
}


$(window).keydown(function (e) {    
    if (e.which == 27) {
        var iwindow_float = document.getElementById('iwindow-float');
        if (iwindow_float != null) {
            if (confirm('¿Está seguro que desea salir de la ventana?')) {
                iwindow_float.contentWindow.float_close();
            }
        }       
    }
});

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

var fncResize=function(){
	if(document.getElementById('divContent')!=null){
		var h=$('#divContent').height();
		var h1=$('#divContent').offset().top+80;
		$('.grid-content').height(h-h1);
		$('#window-float').height(h);
	}	
        
}

$(window).resize(function(){
	fncResize();	
});


function build_data_table0(table, data, columnDefs) {
    var responsiveHelperAjax = undefined;
    var breakpointDefinition =
        {
            tablet: 1024,
            phone: 480
        };

    columnDefs = (typeof columnDefs === 'undefined') ? [] : columnDefs;
    $(table).DataTable
        ({
            destroy: true,
            paging: true,
            autoWidth: false,
            responsive: true,
            //scrollY: 500,
            //scrollCollapse: true,
            pageLength: 20,
            pagingType: 'full_numbers',
            dom: '<"pull-left"f><"pull-right"l>tip',
            bInfo: false,
            bLengthChange: false,
            orderMulti: false,
            orderClasses: false,
            data: data,
            columnDefs: columnDefs,
            language:
            {
                search: '_INPUT_',
                searchPlaceholder: 'Buscar...',
                emptyTable: "<h5 class='text-center'>No hay registros para mostrar</h5>",
                zeroRecords: "<h5 class='text-center'>No hay registros para mostrar</h5>",
                processing: 'Procesando',
                loadingRecords: 'Cargando datos',
                lengthMenu: 'Mostrando _MENU_ entradas',
                infoFiltered: '(Filtrado de _MAX_ entradas totales)',
                info: 'Mostrando _START_ de _END_ de las _TOTAL_ entradas totales',
                infoEmpty: 'mostrando 0 de 0 de las 0 entradas totales',
                paginate:
                {
                    'first': 'Primera',
                    'last': 'Ultima',
                    'next': 'Siguiente',
                    'previous': 'Anterior'
                }
            },
            preDrawCallback: function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelperAjax) {
                    responsiveHelperAjax = new ResponsiveDatatablesHelper(table, breakpointDefinition);
                }
            },
            rowCallback: function (nRow, data) {
                responsiveHelperAjax.createExpandIcon(nRow);
            },
            drawCallback: function (oSettings) {
                responsiveHelperAjax.respond();
            }

        });
    var id = table.attr('id');
    var padreInput = document.getElementById(id + '_filter');
    var input = padreInput.getElementsByTagName('input')[0];
    $(input).attr('placeholder', 'Buscar...');
    $(input).attr('id', id + '_input');
}

function build_data_table(table) {
    var responsiveHelperAjax = undefined;
    var breakpointDefinition =
        {
            tablet: 1024,
            phone: 480
        };

    $(table).DataTable
        ({
            destroy: true,
            autoWidth: false,
            responsive: true,
            pagingType: 'full_numbers',
            bInfo: false,
            bFilter: false,
            bLengthChange: false,
            orderMulti: false,
            orderClasses: false,
            pageLength: 20,
            paging: true,
            bFilter: false,
            ordering: false,
            searching: true,
            dom: '<"pull-left"f><"pull-right"l>tip',
            language:
            {
                emptyTable: "<h5 class='text-center'>No hay registros para mostrar</h5>",
                zeroRecords: "<h5 class='text-center'>No hay registros para mostrar</h5>",
                processing: 'Procesando',
                loadingRecords: 'Cargando datos',
                lengthMenu: 'Mostrando _MENU_ entradas',
                infoFiltered: '(Filtrado de _MAX_ entradas totales)',
                info: 'Mostrando _START_ de _END_ de las _TOTAL_ entradas totales',
                infoEmpty: 'mostrando 0 de 0 de las 0 entradas totales',
                paginate:
                {
                    'first': 'Primera',
                    'last': 'Ultima',
                    'next': 'Siguiente',
                    'previous': 'Anterior'
                }
            },
            preDrawCallback: function () {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelperAjax) {
                    responsiveHelperAjax = new ResponsiveDatatablesHelper(table, breakpointDefinition);
                }
            },
            rowCallback: function (nRow, data) {
                responsiveHelperAjax.createExpandIcon(nRow);
            },
            drawCallback: function (oSettings) {
                responsiveHelperAjax.respond();
            }
        });
}




function build_data_table_dom(table, columnDefs, order, npageLength) {
    var responsiveHelperAjax = undefined;
    var responsiveHelperDom = undefined;
    var breakpointDefinition = {
        tablet: 1024,
        phone: 480
    };

    columnDefs = (typeof columnDefs === 'undefined') ? [] : columnDefs;
    order = (typeof order === 'undefined') ? [[0, "asc"]] : order;
    npageLength = (typeof npageLength === 'undefined') ? 10 : npageLength;

    var tableDom = table;


    tableDom.dataTable({
        destroy: true,
        autoWidth: false,
        responsive: true,
        pagingType: 'full_numbers',
        bInfo: false,
        bFilter: false,
        bLengthChange: true,
        orderMulti: false,
        orderClasses: true,
        "pageLength": npageLength,
        dom: '<"top"i>rt<"bottom"flp><"clear">',
        columnDefs: columnDefs,
        order: order,
        bFilter: false,
        ordering: true,
        searching: true,
        stateSave: false,
        paging: true,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        language:
        {
            emptyTable: "<h5 class='text-center'>No hay registros para mostrar</h5>",
            zeroRecords: "<h5 class='text-center'>No hay registros para mostrar</h5>",
            processing: 'Procesando',
            loadingRecords: 'Cargando datos',
            lengthMenu: 'Mostrando _MENU_ entradas',
            infoFiltered: '(Filtrado de _MAX_ entradas totales)',
            info: 'Mostrando _START_ de _END_ de las _TOTAL_ entradas totales',
            infoEmpty: 'mostrando 0 de 0 de las 0 entradas totales',
            paginate:
            {
                'first': 'Primera',
                'last': 'Ultima',
                'next': 'Siguiente',
                'previous': 'Anterior'
            }
        },
        preDrawCallback: function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelperDom) {
                responsiveHelperDom = new ResponsiveDatatablesHelper(tableDom, breakpointDefinition);
            }
        },
        rowCallback: function (nRow) {
            responsiveHelperDom.createExpandIcon(nRow);
        },
        drawCallback: function (oSettings) {
            responsiveHelperDom.respond();
        }
    });

    //order : [[$('th.sort').index(), 'asc']],
}

function build_data_table(table, columnDefs, order, npageLength) {
    
    columnDefs = (typeof columnDefs === 'undefined') ? [] : columnDefs;
    order = (typeof order === 'undefined') ? [[0, "asc"]] : order;
    npageLength = (typeof npageLength === 'undefined') ? 10 : npageLength;

    return table.DataTable({
        "deferRender": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "pageLength": npageLength,
        "sDom": '<"top"i>rt<"bottom"flp><"clear">',
        columnDefs: columnDefs,
        order: order,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        language:
        {
            emptyTable: "<h5 class='text-center'>No hay registros para mostrar</h5>",
            zeroRecords: "<h5 class='text-center'>No hay registros para mostrar</h5>",
            processing: 'Procesando',
            loadingRecords: 'Cargando datos',
            lengthMenu: 'Mostrando _MENU_ entradas',
            infoFiltered: '(Filtrado de _MAX_ entradas totales)',
            info: 'Mostrando _START_ de _END_ de las _TOTAL_ entradas totales',
            infoEmpty: 'mostrando 0 de 0 de las 0 entradas totales',
            paginate:
            {
                'first': 'Primera',
                'last': 'Ultima',
                'next': 'Siguiente',
                'previous': 'Anterior'
            }
        }
    });

}


function build_data_table_dom_bloqueo_temporal(table, columnDefs, order) {
    var responsiveHelperAjax = undefined;
    var responsiveHelperDom = undefined;
    var breakpointDefinition = {
        tablet: 1024,
        phone: 480
    };

    columnDefs = (typeof columnDefs === 'undefined') ? [] : columnDefs;
    order = (typeof order === 'undefined') ? [[0, "asc"]] : order;

    var tableDom = table;


    tableDom.dataTable({
        destroy: true,
        autoWidth: false,
        responsive: true,
        pagingType: 'full_numbers',
        bInfo: false,
        bFilter: false,
        bLengthChange: true,
        orderMulti: false,
        orderClasses: true,
        pageLength: 10,
        paging: false,
        bFilter: false,
        ordering: true,
        searching: false,
        dom: '<"top"i>rt<"bottom"flp><"clear">',
        columnDefs: columnDefs,
        order: order,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        language:
        {
            emptyTable: "<h5 class='text-center'>No hay registros para mostrar</h5>",
            zeroRecords: "<h5 class='text-center'>No hay registros para mostrar</h5>",
            processing: 'Procesando',
            loadingRecords: 'Cargando datos',
            lengthMenu: 'Mostrando _MENU_ entradas',
            infoFiltered: '(Filtrado de _MAX_ entradas totales)',
            info: 'Mostrando _START_ de _END_ de las _TOTAL_ entradas totales',
            infoEmpty: 'mostrando 0 de 0 de las 0 entradas totales',
            paginate:
            {
                'first': 'Primera',
                'last': 'Ultima',
                'next': 'Siguiente',
                'previous': 'Anterior'
            }
        },
        preDrawCallback: function () {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelperDom) {
                responsiveHelperDom = new ResponsiveDatatablesHelper(tableDom, breakpointDefinition);
            }
        },
        rowCallback: function (nRow) {
            responsiveHelperDom.createExpandIcon(nRow);
        },
        drawCallback: function (oSettings) {
            responsiveHelperDom.respond();
        }
    });
}
function search_filter(table_id) {
    $(table_id).DataTable().search
        (
        jQuery.fn.DataTable.ext.type.search.string(this.value)
        ).draw();
}


function LoadCombo(combo, url, parametro, id, nombre, todos, callBack) {
    
    if (!id)
        id = 'ID';
    if (!nombre)
        nombre = 'nombre';

    enviarAjax(url, 'frm1', parametro, function (res) {
        var jsonObject = $.parseJSON(res);

        $('#' + combo).html('');
        if (todos == 'T')
            $('#' + combo).append("<option value='-1' selected='selected'>-Todos-</option>").trigger('chosen:updated');
        else if (todos == 'S')
            $('#' + combo).append("<option value='-1' selected='selected'>-Seleccione-</option>").trigger('chosen:updated');

        $.each(jsonObject, function (i, item) {
            $('#' + combo).append("<option value='" + $.trim(item[id]) + "'>" + $.trim(item[nombre]) + "</option>").trigger('chosen:updated');
        });

        if (callBack) {
            callBack.apply();
        }

    });
}
function build_data_table_default(table,$array_align) {
   
       
        var config="";
        for(i=0;i<$array_align.length;i++){
            var clase="text-left";
            if($array_align[i]=="C"){
                clase="text-center";
            }else if($array_align[i]=="R"){
                clase="text-right";
            }
            if(i==0){
                 config=config+'{ "targets": '+i+',"className":"'+clase+'" }';
            }else{
                config=config+',{ "targets": '+i+',"className":"'+clase+'" }';
            }
            
        }
        config='['+config+']';
        var columnDefs =JSON.parse(config);
        
    columnDefs = (typeof columnDefs === 'undefined') ? [] : columnDefs;
    order = (typeof order === 'undefined') ? [[0, "asc"]] : order;
    npageLength = (typeof npageLength === 'undefined') ? 10 : npageLength;

    return table.DataTable({
        "deferRender": true,
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "pageLength": 'ALL',
        "sDom": '<"top"i>rt<"bottom"flp><"clear">',
        columnDefs: columnDefs,
        //order: order,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        language:
        {
            emptyTable: "<h5 class='text-center'>No hay registros para mostrar</h5>",
            zeroRecords: "<h5 class='text-center'>No hay registros para mostrar</h5>",
            processing: 'Procesando',
            loadingRecords: 'Cargando datos',
            lengthMenu: 'Mostrando _MENU_ entradas',
            infoFiltered: '(Filtrado de _MAX_ entradas totales)',
            info: 'Mostrando _START_ de _END_ de las _TOTAL_ entradas totales',
            infoEmpty: 'mostrando 0 de 0 de las 0 entradas totales',
            paginate:
            {
                'first': 'Primera',
                'last': 'Ultima',
                'next': 'Siguiente',
                'previous': 'Anterior'
            }
        }
    });

}



/*===========================Tabla=============================*/
function cargarCombo(combo, url, parametro, id, nombre, todos, seleccion, callBack) {

    if (!seleccion)
        seleccion = false;
    if (!id)
        id = 'ID';
    if (!nombre)
        nombre = 'nombre';

    enviarAjax(url, 'frm1', parametro, function (res) {
        var jsonObject = $.parseJSON(res);

        $('#' + combo).html('');
        if (todos == 'T') {
            $('#' + combo).append("<option value='-1' selected='selected'>-Todos-</option>").trigger('chosen:updated');
        } else if (todos == 'S') {
            $('#' + combo).append("<option value='-1' selected='selected'>-seleccione-</option>").trigger('chosen:updated');
        }
        $.each(jsonObject, function (i, item) {
            if ($.trim(item[id]) == seleccion) {
                seleccionar = " selected='selected'";
            } else {
                seleccionar = "";
            }
            $('#' + combo).append("<option value='" + $.trim(item[id]) + "' " + seleccionar + ">" + $.trim(item[nombre]) + "</option>").trigger('chosen:updated');
        });

        if (callBack) {
            callBack.apply();
        }

    });
}

function window_open_view(url,id,q,f0)
{
    if (typeof (f0) == 'undefined') {        
        if (typeof (f0) == 'undefined') {
            fparentPadre1= '';
        } else {
            fparentPadre1 = f0;
        }        
    } else {
        fparentPadre1= f0;
    }
   
    var aleatorio = Math.random();

    var iframe = document.createElement('iframe');	
    //var window_float = $('#window-float');
    iframe.id = 'iwindow-float-modal';
    iframe.scrolling = 'no';   
	iframe.style.border=0;
	
	/*Envio el ID*/
    var  cad = (id != '') ? '/' + id : '';  
	
	/*Envio la cadena de consultas*/
	if (typeof (q) == 'undefined') {      
		cad =cad +'?aleatorio=' + aleatorio;
	} else{
		cad =cad +'?'+ q +'&aleatorio=' + aleatorio;
	}
	
	var src = url.toLowerCase() + cad ;
     $("#divContenedorDIV").html('<iframe id="iframeContenedor" class="embed-responsive-item" src="'+src+'" allowfullscreen></iframe>');
        $("#cuerpo_principal").hide('fast');
        
        $('#divContenedorDIV').show("fast");
     interfaz=1;  
  
}
function window_close_view() {   
  
   $('#divContenedorDIV').hide("fast");
        $("#cuerpo_principal").show('fast');
        $("#divContenedorDIV").html('');
    
}

function window_save_view(parametro){
    if(parametro){
        fparentPadre1.call(this,parametro);
        //fParent1.apply();
    }else{
        fparentPadre1.apply();
    }
    
    window_close_view();
}
function get_breadcrumb(){
         var ul='<span class="label">Ubicación:</span><ol class="breadcrumb"><li><i class="fa fa-home"></i> <a >Home</a><i class="fa fa-angle-right"></i></li>';
        
          
         $("#sidebar-left .sidebar-menu>li.active").each(function(){
             var titulo=$(this).find("span.text:first").text();
             var  href=$(this).find("a:first").attr("href");
             ul=ul+'<li><a>'+titulo+'</a><i class="fa fa-angle-right"></i></li>';
             //var titulo1=$(this).find("ul li.active:first");
             $(this).find("ul>li.active:first").each(function(){
                 var titulo1=$(this).find("span.text:first").text();
                 var href1=$(this).find("a:first").attr("href");
                    ul=ul+'<li><a >'+titulo1+'</a><i class="fa fa-angle-right"></i></li>';
                    $(this).find("ul>li.active").each(function(){
                        var titulo2=$(this).find("span.text:first").text();
                        var href2=$(this).find("a:first").attr("href");
                           ul=ul+'<li><a >'+titulo2+'</a><i class="fa fa-angle-right"></i></li>';
                    });
             });
            
            
          
         });
         //ul=ul+'</ol>';
         return ul;
         //$("#divArbol").html(ul);
     }   