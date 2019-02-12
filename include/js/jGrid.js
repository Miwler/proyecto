//-----Nuevo objeto Grid-------------------
$(document).click(function(){
    
});
var grid = function (tb) {
    
    this.tb = tb;
    this.rows = 0;
    this.fila_seleccionada = 0;
    this.fila_anterior = -1;
    this.nuevoEvento = nuevoEvento;
    this.trSeleccionar = trSeleccionar;
    this.fncPaginacion = fncPaginacion;
    this.fncPaginacion1 = fncPaginacion1;
    this.fncPaginacionTabs=fncPaginacionTabs;
    this.activo = false;
    this.cellsEdit = -1;
    this.trSeleccionado = function (tr) { };

    var obj = this;
    this.tb.oncontextmenu=function(){
        return false;
    }
     
    this.tb.onmousedown=function (event) {
        /*switch (event.which) {
            case 1:
                //alert('Left mouse button pressed');
                break;
            case 2:
               
                break;
            case 3:
                obj.activo = true;
               $("#contenedor_anticlick li").remove();
                $(obj.tb.rows[obj.fila_seleccionada]).find(".dropdown-menu li").each(function(){
                    $(this).clone().appendTo("#contenedor_anticlick");
                });
                
                
               // $("#contenedor_anticlick .dropdown-menu").css("display",'block');
                 
                
                break;
            default:
                alert('You have a strange mouse');
        }*/
        $('body').unbind('keydown');
        $('body').keydown(function (e) {
           
            if (obj.activo) {
                var objContent = $(obj.tb.parentNode);
                var position;
				
                if (e.keyCode == 38) {
                    /*Mueve el Scroll en el item seleccionado*/
                    position = (obj.fila_seleccionada-1) * ($(obj.tb.rows[obj.fila_seleccionada]).height() ? $(obj.tb.rows[obj.fila_seleccionada]).height() : 0);
                    objContent.scrollTop(position);
                    //---------------------------
                    var movido=obj.trSeleccionar(obj.fila_seleccionada - 1);

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
                    var vdesplazamiento=window.pageYOffset;
                    var filaPostion = $(obj.tb.rows[obj.fila_seleccionada]).offset().top + $(obj.tb.rows[obj.fila_seleccionada]).height() - vdesplazamiento;
                    var windowHeigth = window.innerHeight;
                    
                    if (filaPostion > windowHeigth || movido==0) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }

        });
    }
    
   /* $('.Grid').mouseleave(function () {
        $('body').unbind('keydown');
    });*/
            
    this.tb.onclick = function () {
        
        obj.activo = true;
        
    };
    
    document.body.onmousedown = function () {
        obj.activo = false;
       
    }

    document.body.onkeypress = function (e) {
        if (obj.cellsEdit != -1 && obj.activo) {
            obj.tb.rows[obj.fila_seleccionada].cells[obj.cellsEdit].getElementsByTagName('a')[0].onclick();
        }        
    }
}
$("html").click(function() {
    $("#contenedor_anticlick li").remove();
    $("#contenedorUL").hide();
     
});
$(".grid").click(function (e) {
    e.stopPropagation();
});
var nuevoEvento = function () {
    var i = 0;
    var obj = this;    
    var tb = this.tb;      
    var items = tb.getElementsByClassName('tr-item');
    var rows = items.length;
    for (i = 0; i < rows; i++) {
        if (items[i].addEventListener) {
           items[i].addEventListener('click', function () {
                
                this.rowIndex;                
                obj.trSeleccionar(this.rowIndex);
                //$("#contenedor_anticlick li").remove();
               // $("#contenedorUL").hide();
            }, false); 
            items[i].addEventListener('contextmenu', function (e) {
                
                this.rowIndex;                
                obj.trSeleccionar(this.rowIndex);
                
                $("#contenedor_anticlick li").remove();
                $(obj.tb.rows[obj.fila_seleccionada]).find(".dropdown-menu li").each(function(){
                    $(this).clone().appendTo("#contenedor_anticlick");
                });
                var x=e.pageX;
                var y=e.pageY;
                $("#contenedorUL").css({"top":y+"px","left":x+"px"});
                $("#contenedorUL").show();
            }, false);
        } else {
            items[i].attachEvent('onclick', function () {
                this.rowIndex;
                obj.trSeleccionar(this.rowIndex);
            });            
        }
    }
}

var fncPaginacion = function (obj)
{   
    //---------------Paginación-------------
    var tb = this.tb;
    //var pag = tb.getElementsByClassName('pagination');
    var pag=$('.pagination li a');
    
    var cantidad = pag.length;
    for (i = 0; i < cantidad; i++) {
        if (pag[i].id != '') {
            if (pag[i].addEventListener) {
                pag[i].addEventListener('click', function () {
                    if (obj.txtnum == '' || obj.txtnum == undefined) {
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
var fncPaginacion1 = function (obj)
{
    //---------------Paginación-------------
    
    var tb = this.tb;
    var pag=$('.pagination li a');
   
    var cantidad = pag.length;
    for (i = 0; i < cantidad; i++) {
        if (pag[i].id != '') {
            if (pag[i].addEventListener) {
                pag[i].addEventListener('click', function () {
                    if (obj.txtnum == '' || obj.txtnum == undefined) {
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


var fncPaginacionTabs = function (obj,num_page)
{
    //---------------Paginación-------------
    var tb = this.tb;
    //var pag = tb.getElementsByClassName('pagination');
    var pag=$('.pagination li a');
    var cantidad = pag.length;
    for (i = 0; i < cantidad; i++) {
        if (pag[i].id != '') {
            if (pag[i].addEventListener) {
                pag[i].addEventListener('click', function () {
                    if (obj.txtnum == '' || obj.txtnum == undefined) {
                        $('#'+num_page).val(this.id);
                    } else {
                        $('#' + obj.txtnum).val(this.id);
                    }
                    
                    obj.enviar();
                }, false);
            } else {
                pag[i].attachEvent('onclick', function () {
                    if (obj.txtnum == '' || obj.txtnum == undefined) {
                         $('#'+num_page).val(this.id);
                    } else {
                        $('#' + obj.txtnum).val(this.id);
                    }
                    obj.enviar();
                });
            }
        }
    }
}
var trSeleccionar = function (tr_id) {
   // alert(tr_id);
    var items = this.tb.rows;
	
	if(items[tr_id]!=undefined){
            if (items[tr_id].className.search('tr-item') == 0) {
                this.fila_anterior = this.fila_seleccionada;
                this.fila_seleccionada = tr_id;
                this.tb.rows[this.fila_anterior].className = this.tb.rows[this.fila_anterior].className.replace(' info', '');
                this.tb.rows[this.fila_seleccionada].className += ' info';
                this.trSeleccionado(items[tr_id]);
                return 1;        
            }
	}
    return 0;
}

var gridEliminar = function (obj, id, url) {   

    $(obj.Div).html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');

    $.ajax({
        type: "post",
        url: url+'/'+id,
        data: {
        },
        datatype: "json",
        success: function (respuesta) {	
            //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            
            if(respuesta.resultado==1){
                mensaje.info("Mensaje de respuesta",respuesta.mensaje);
                
            }else{
                mensaje.error("Mensaje de error",respuesta.mensaje);
            }

            if(respuesta.funcion){
                $('#script').html(respuesta.funcion);
            }
            obj.enviar();
        },
        error: function () {
            toastem.error("Ocurrió un error en el ajax");       
            //obj.enviar();
        }
    });
    
}


var gridCondicionProducto = function (obj, id, url) {   

    $(obj.Div).html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');

    $.ajax({
        type: "post",
        url: url+'/'+id,
        data: {
        },
        datatype: "json",
        success: function (respuesta) {	
            //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            
            if(respuesta.resultado==1){
                mensaje.info("Mensaje de respuesta",respuesta.mensaje);
                
            }else{
                mensaje.error("Mensaje de error",respuesta.mensaje);
            }

            if(respuesta.funcion){
                $('#script').html(respuesta.funcion);
            }
            obj.enviar();
        },
        error: function () {
            toastem.error("Ocurrió un error en el ajax");       
            //obj.enviar();
        }
    });
    
}


var newGrid=function(tb){
	var nGrid=new grid(tb);
	nGrid.nuevoEvento();			
	return nGrid;
}

var gridEliminarDetalle = function (Div, id, url,url1,id_cotizacion) {   
    if (confirm('\xBFEst\xE1 seguro que desea eliminar el registro?') == true) {
        $('#'+Div).html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
        //alert(id);
        $.ajax({
            type: "post",
            url: url+'/'+id,
            data: {
            },
            datatype: "json",
            success: function (respuesta) {
                alert(respuesta);
                 var respuesta = $.parseJSON(respuesta);
		alert(respuesta.mensaje);
                if(respuesta.resultado=1){
                     mostrarValores(Div,url1,id_cotizacion);
                }
           
            },
            error: function () {
               
            }
        });
    }
}