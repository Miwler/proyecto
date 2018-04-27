/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {    
    $('#loading-float-padre', window.parent.document).css('display', 'none');
    $('#window-float-padre', window.parent.document).css('display', 'block');
    redimencionarWindow();
   
    $(window).bind('beforeunload', function () {
        return "¿Está seguro que desea salir de la ventana?";
    });
   
    $('form').submit(function () {
        $(window).unbind('beforeunload');
    });
    
    /*$(window).blur(function () {
        $('#float-mensaje').html('');
    });

    $(window).click(function () {
        $('#float-mensaje').html('');
    });*/

    $('#iwindow-float-padre', window.parent.document).css('position','relative');
});

function redimencionarWindow()
{    //var alto=document.body.offsetHeight;
    //alert(alto);
    $('#iwindow-float-padre', window.parent.document).animate({
        width: document.body.scrollWidth + 'px',
        height: document.body.offsetHeight + 'px'
    });
   
}
function redimencionarWindow_padre(ancho, alto)
{  
   // var anchopadre=$('#iwindow-float-padre', window.parent.document).width();
   // var altopadre=$('#iwindow-float-padre', window.parent.document).height();
     //alert(ancho);
   
     $('#iwindow-float-padre', window.parent.document).width(ancho);
     $('#iwindow-float-padre', window.parent.document).height(alto);
    
  
   
}

function window_float_close_padre(){   
    
    $('#iwindow-float-padre', window.parent.document).animate({
        width: '10px',
        height: '10px',
        display:'none'
    });	
    
    parent.float_close_padre();	
}

function window_float_save() {
    fParent.enviar();
    window_float_close_padre();
}

function recargar(){
    $(window).unbind('beforeunload');    
	window.location.reload();   
}

function recargar_parent(){	
	 $(window).unbind('beforeunload');   
	parent.recargar();
}


function redireccionar_parent(url){  
     $(window).unbind('beforeunload');   
    parent.redireccionar(url);
}

function cambiarInterfaz_padre(idActual,idCambiar,btn_close,redimensionar,funcion){ 
    
    $('#' + idActual).slideUp('slide');
    $('#' + idCambiar).slideDown('slide', function () {
       /* if (btn_close) {
            $('#btn-close').css('display', 'block');
        } else {
            $('#btn-close').css('display', 'none');
        }*/
        
        if (redimensionar)
        {
            redimencionarWindow();
        }
        
        if (funcion)
        {
            funcion.apply();
        }
    });    
}

function redondear(numero, cantidad_decimal) {
    var nDecimal = Math.pow(10, cantidad_decimal);
	numero=numero+'';
	numero=numero.replace(',','');
    var rNumero = Math.round(numero * nDecimal) / nDecimal;
	
    if (isNaN(rNumero))
    {
        rNumero = 0;
    }
    return rNumero;
}

function formatDate(dateIn,formatIn,formatOut){
	var date=new Array();
	switch(formatIn){
		case 'd/m/Y':
			date=dateIn.split('/');
			var d=date[0];
			var m=date[1];
			var Y=date[3];
			
			
			switch(formatOut){
				case 'Y-m-d':
					var newDate=new Date(Y+'-'+m+'-'+d);
					return newDate;
				break;
			}			
			
		break;
	}	
}