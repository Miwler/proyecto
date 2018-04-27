var gridv2 = function (table)
{ //alert('5');
    this.tb = table;
    this.rows = table.rows.length;
    this.fila_seleccionada =-1;
    this.fila_anterior = -1;
    this.nuevoEvento = nuevoEvento;
    this.trSeleccionar = trSeleccionar;
    this.trSeleccionado = function (tr) { };
    this.fncPaginacion = fncPaginacion;
    this.activo = false;
    var obj = this;
    this.txtnum = '';

    this.tb.onmousedown = function () {  
        $('body').unbind('keydown');
        $('body').keydown(function (e) {
            if (obj.activo) {
                var objContent = $(obj.tb.parentNode);
                var position;
                
                if (e.keyCode == 38) {
                    /*Mueve el Scroll en el item seleccionado*/
                    position = (obj.fila_seleccionada + 1) * ($(obj.tb.rows[obj.fila_seleccionada]).height() ? $(obj.tb.rows[obj.fila_seleccionada]).height() : 0);                    
                    objContent.scrollTop(position);
                    //---------------------------                
                    var movido = obj.trSeleccionar(obj.fila_seleccionada - 1);

                    //Obtener el tamaño de desplazamiento del scroll en forma vertical     
                    var vdesplazamiento = window.pageYOffset;
                    var filaPostion = $(obj.tb.rows[obj.fila_seleccionada]).offset().top - vdesplazamiento;
                    var windowHeigth = window.innerHeight;

                    if (filaPostion <= 0 || movido == 0) {
                        return true;
                    } else {
                        return false;
                    }
                }

                if (e.keyCode == 40) {
                    /*Mueve el Scroll en el item seleccionado*/
                    position = (obj.fila_seleccionada - 1) * ($(obj.tb.rows[obj.fila_seleccionada]).height() ? $(obj.tb.rows[obj.fila_seleccionada]).height() : 0);                    
                    objContent.scrollTop(position);
                    //---------------------------
                                        
                    var movido = obj.trSeleccionar(obj.fila_seleccionada + 1);
                    
                    //Obtener el tamaño de desplazamiento del scroll en forma vertical     
                    var vdesplazamiento = window.pageYOffset;
                    var filaPostion = $(obj.tb.rows[obj.fila_seleccionada]).offset().top + $(obj.tb.rows[obj.fila_seleccionada]).height() - vdesplazamiento;
                    var windowHeigth = window.innerHeight;

                    if (filaPostion > windowHeigth || movido == 0) {
                        return true;
                    } else {
                        return false;
                    }
                }                
            }

        });             
    }

    this.tb.onclick=function () {
        obj.activo = true;
    };

    document.body.onmousedown = function (e) {
        obj.activo = false;
    }
}

var nuevoEvento = function (){
    var i = 0;
    var obj = this;
    var tb = this.tb;
    var cItem = $(tb).find('.item').length;
    this.rows = cItem;
    $(tb).find('.item').each(function (key, tr) {
        tr.addEventListener('click', function () {
            this.rowIndex;
            obj.trSeleccionar(this.rowIndex);
        }, false);            
    });
}

var trSeleccionar = function (tr_id) {    
    var items = this.tb.rows;    
    if (items[tr_id].className == 'item') {
        if (this.fila_seleccionada == -1) {
            this.fila_seleccionada = tr_id;
        }

        this.fila_anterior = this.fila_seleccionada;
        this.fila_seleccionada = tr_id;
        this.tb.rows[this.fila_anterior].className = this.tb.rows[this.fila_anterior].className.replace(' trSel', '');
        this.tb.rows[this.fila_seleccionada].className += ' trSel';
        this.trSeleccionado(items[tr_id]);
        return 1;
    }
    return 0;
}

var grid_float = function ()
{
    var aObj = $('.grid-float');
    var g = new Array();
    aObj.each(function (key, obj) {        
        g[key] = new gridv2(obj);
        g[key].nuevoEvento();
    });
}

var newGridByDiv = function (Div) {
    var g;
    $(Div).find('.grid-float').each(function (key, obj) {        
        g=new gridv2(obj);
        g.nuevoEvento();
        return;
    });    
    return g;
}


var fncPaginacion = function (obj) {    
    //---------------Paginación-------------
    var tb = this.tb;
    var pag = tb.getElementsByClassName('pagination');
    var cantidad = pag.length;
    for (i = 0; i < cantidad; i++) {
        if (pag[i].id != '') {
            if (pag[i].addEventListener) {
                pag[i].addEventListener('click', function () {                    
                    if (obj.txtnum == '' || obj.txtnum==undefined) {
                        $('#num_page').val(this.id);
                    } else {
                        $('#' + obj.txtnum).val(this.id);
                    }
                    obj.enviar();
                }, false);
            } else {
                pag[i].attachEvent('onclick', function () {                    
                    if (obj.txtnum == '' || obj.txtnum == undefined) {
                        $('#num_page').val(this.id);
                    } else {
                        $('#' + obj.txtnum).val(this.id);
                    }
                    obj.enviar();
                });
            }
        }
    }
}

var fncActivar=function(id,ob){
    
    var activo=0;
    if($(ob).hasClass('trActivo')){
        activo=1;
    }
   
    $('.trActivo').each(function(index){
        
        $(this).removeClass('trActivo');
    });
    if(typeof($('#detalle_ID').val())=="undefined"){
        
        $('body').append('<input style="display:none;" id="detalle_ID">');
    }
    
    if(activo==0){
        //alert(id);
       $(ob).addClass('trActivo');
       
       $('#detalle_ID').val(id);
       
       fncMostrarAction();
    }else {
       
        $('#detalle_ID').val('');
        fncOcultarAction();
    }
   
}
var fncSeleccionarDetalle=function(){
    if(typeof($('#detalle_ID').val())!="undefined" && $('#detalle_ID').val()!=''){
        var valor=$('#detalle_ID').val();
        $('#'+valor).addClass('trActivo');
        if(valor!=''){
            fncMostrarAction();
        }
       
    }else {
        fncOcultarAction();
    }
}
var fncValidarDetalle=function(){
    var cantidad=0;
    $('.item-tr').each(function(){
        cantidad++;
    });
   if(cantidad==0){
        mensaje.error("Ocurrió un error",'No registró ningún detalle.');
   }else {
        if(typeof($('#detalle_ID').val())!="undefined" && $('#detalle_ID').val()!=''){
        return 1;
        }else {
            mensaje.error("Ocurrió un error",'Debe seleccionar un registro');
        }
   }
    
}
var fncMostrarAction=function(){
    
    $('.btn_detalle').each(function(){
        if($(this).is(':visible')){
            
        }else {
            $(this).toggle("fast");
        }
        
        
    });
}
var fncOcultarAction=function(){
   
    $('.btn_detalle').each(function(){
        if($(this).is(':visible')){
            $(this).toggle("fast");
        }
    });
}
var fncDesactivarBtnDetalle=function(){
     $('#detalle_ID').val('');
}