/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var fParent;
var fParent1;
var fParent2;

var idActual;
var idActualHijo;
$(function () {    
    $('#loading-float', window.parent.document).css('display', 'none');
    $('#window-float', window.parent.document).css('display', 'block');
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

    $('#iwindow-float', window.parent.document).css('position','relative');
});

function redimencionarWindow()
{    //var alto=document.body.offsetHeight;
    //alert(alto);
    $('#iwindow-float', window.parent.document).animate({
        width: document.body.scrollWidth + 'px',
        height: document.body.offsetHeight + 'px'
        
    });
    
   //redimencionarWindow_padre($('#iwindow-float', window.parent.document).width(),$('#iwindow-float', window.parent.document).height());
}


function window_float_close(){   

    $('#iwindow-float', window.parent.document).animate({
    width: '10px',
    height: '10px',
    display:'none'
    },400,function(){
         parent.float_close();
    });
       
}
function window_float_close_modal(){   
    parent.float_close_modal();
    
       
}

function window_float_save() {
    var padre=$(window.parent.document);
    var contenedor=$(padre).find('#divContent-float');
     $(contenedor).animate({ scrollTop: 0},400,function(){
        fParent.enviar();
        window_float_close();
     });
   
}
function window_float_save_modal() {
    fParent.enviar();
    window_float_close_modal();
   
}
function mover_scroll_inicio(){
    var padre=$(window.parent.document);
    var contenedor=$(padre).find('#divContent-float');
    $(contenedor).animate({ scrollTop: 0},400);
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

function cambiarInterfaz(idActual,idCambiar,btn_close,redimensionar,funcion){ 
    
    $('#' + idActual).slideUp('slide');
    $('#' + idCambiar).slideDown('slide', function () {
        if (btn_close) {
            $('#btn-close').css('display', 'block');
        } else {
            $('#btn-close').css('display', 'none');
        }
        
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
function ampliarVentanaVertical(alto,form)
{ 
    //var alto_hijo=$('#iwindow-float1 form').height();
    
    $('#iwindow-float', window.parent.document).animate({
       height: alto + 'px'
        
    });
   // $('#iwindow-float1').contents().find("body").height(500);
    $('#'+form).css('height',alto+'px');
    
    $('body').css('height',alto+'px');
   //redimencionarWindow_padre($('#iwindow-float', window.parent.document).width(),$('#iwindow-float', window.parent.document).height());
}
var fnc;
function window_float_deslizar(idForm,url,id,q,f0)
{ $('#fondo_espera').css('display','block');
  //damos el tamano del contenedor
  
  idActual=idForm;
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
    var window_float = $('#windows_float_deslizador');
    iframe.id = 'iwindow-float1';
    iframe.scrolling = 'no';   
	iframe.style.border=0;
	
	/*Envio el ID*/
    var  cad = (id != '') ? '/' + id : '';  
	
	/*Envio la cadena de consultas*/
	if ((typeof (q) == 'undefined') ||(q=='') ) {      
		cad =cad +'?aleatorio=' + aleatorio;
	} else{
		cad =cad +'?'+ q +'&aleatorio=' + aleatorio;
	}
   
    iframe.src = url.toLowerCase() + cad ;
   
    window_float.append(iframe);
    $('#content-float').slideUp('slide');
    $('#iwindow-float1').css('width','100%');
    $('#iwindow-float1').css('height','100%');
    $('#windows_float_deslizador').css('height','100%');
    $('#windows_float_deslizador').slideDown('slide');
    $('#fondo_espera').css('display','none');
    window.scrollTo(0, 0);
}
function window_deslizar_close(){  
    
    $('#btn-close', window.parent.document).css('display','block');
    $('#windows_float_deslizador', window.parent.document).slideUp('slide',function(){
        $(this).html('');
    });
    //$('#windows_float_deslizador', window.parent.document).html('');
    $('#content-float', window.parent.document).slideDown('slide');
    
  
}

function window_deslizar_save() {
    //alert('sd');
    fParent1.apply();
    window_deslizar_close();
}
function window_float_deslizar_hijo(idForm,url,id,q,f0)
{
    $('.titulo_Formulario').css('display','none');
    $('#fondo_espera').css('display','block');
  //damos el tamano del contenedor
  
  idActualHijo=idForm;
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
    var window_float = $('#windows_float_deslizador_hijo');
    iframe.id = 'iwindow-float2';
    iframe.scrolling = 'no';   
	iframe.style.border=0;
	
	/*Envio el ID*/
    var  cad = (id != '') ? '/' + id : '';  
	
	/*Envio la cadena de consultas*/
	if ((typeof (q) == 'undefined') ||(q=='') ) {      
		cad =cad +'?aleatorio=' + aleatorio;
	} else{
		cad =cad +'?'+ q +'&aleatorio=' + aleatorio;
	}
   
    iframe.src = url.toLowerCase() + cad ;
   
    window_float.append(iframe);
    $('#content-float').slideUp('slide');
    $('#iwindow-float2').css('width','100%');
    $('#iwindow-float2').css('height','100%');
    $('#windows_float_deslizador_hijo').css('height','100%');
    $('#windows_float_deslizador_hijo').slideDown('slide');
    mover_scroll_inicio();
    window.scrollTo(0, 0);
    $('#fondo_espera').css('display','none');
}
function window_deslizar_hijo_close(){ 
    $('.titulo_Formulario', window.parent.document).css('display','block');
    $('#windows_float_deslizador_hijo', window.parent.document).slideUp('slide',function(){
        $(this).html('');
    });
    //$('#windows_float_deslizador', window.parent.document).html('');
    $('#content-float', window.parent.document).slideDown('slide');
    
  
}

function window_deslizar_hijo_save() {
    //alert('sd');
    fParent2.apply();
    window_deslizar_hijo_close();
}

function fncDetalleInfo(value_ID, clase,objeto,btnClase,callbakfunction,callbakfunction1){
    if(callbakfunction){
        callbakfunction();
    }
    
    $('.divDetalle a').each(function(){
        if(this==objeto){
            $(this).addClass('liActivo');
        }else {
            $(this).removeClass('liActivo');
        }
    });
    $('.'+clase).each(function(){
       
        if(value_ID==this.id){
       
            $('#'+this.id).css('display','block');
        }else {
            $('#'+this.id).css('display','none');
        }
        
    });
    if(btnClase){
        
        $('.btn_detalle').each(function(){
            //alert(this.id);
            
            
            var titulo=btnClase.substr(3);
            switch(btnClase){
                case 'btnComponente':
                    $(this).removeClass('btnAdicional');
                    break;
                case 'btnAdicional':
                    $(this).removeClass('btnComponente');
                    break;
                case 'btnProductos':
                    $(this).removeClass('btnObsequios');
                    break;
                case 'btnObsequios':
                    $(this).removeClass('btnProductos');
                    break;
            }
            $(this).addClass(btnClase);
            var id=this.id;
            switch(id){
                case 'btnEditar':
                    
                    $(this).prop('title','Editar '+titulo);
                    break;
                case 'btnEliminar':
                    $(this).prop('title','Eliminar '+titulo);
                    break;
            }
          
        });
    }
    if(callbakfunction1){
        callbakfunction1();
    }
    
}
function verificar_fechas(fecha1,fecha2){
   
    var x=fecha1.split('/');
    var y=fecha2.split('/');
    fecha1=x[1]+"-"+x[0]+"-"+x[2];
    fecha2=y[1]+"-"+y[0]+"-"+y[2];
    if (Date.parse(fecha1) > Date.parse(fecha2)){
        
        return false;
    }else {
        return true;
    }
}