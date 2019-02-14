var cObj;
var position= new Array();
var n = 0;
var Buscando;

var cbo = function (objContent, element_Send, url,activarClik,ancho){
    this.objContent=objContent;
    this.element_Send = document.getElementById(element_Send);
    this.cboActivo = false;
    this.activarClick = false;
    this.teclaPresionada = false;
    this.inputName = '';
    this.tabIndexNext = null;
    if(ancho){
        if (screen.width<1024){
        //codigo resolución pequeña 
        this.width='100%';
        }else{
            this.width=ancho;
        }
        
    }else{
        this.width = $(this.element_Send).width();
    }
    
    this.inputfocus = function () {
    }
    

    /*Agrego las etiquetas necesarias*/
    this.url = url;
    //var ancho1=$('#'+element_Send).width();
    this.input_send = document.createElement('input');
    this.input_send.name=this.element_Send.id;
    this.input_send.id='send'+this.element_Send.id;
    $(this.input_send).css('display','none');
        
    $(this.objContent).css("width",this.width+"px");
    $(this.objContent).addClass('input-content');
    //$(this.objContent).addClass('lista_click');
    $(this.objContent).css('display','none');
    $(this.element_Send).addClass("cboPorSeleccionar");
    this.input=document.createElement('input');
    this.input.id="input"+element_Send;
    $(this.input).width(this.width+'px');
    $(this.input).addClass('form-control');
    //$(this.input).addClass('lista_click');
    $(this.input).css('display','none');
    //this.input.width(this.width);
    this.div = document.createElement('div');
    this.div.id = 'cbo' + objContent.id;
    this.div.className = 'cbo-div';
    
   
   this.element_Send.autocomplete = 'off';
    $('#'+element_Send).after(this.input_send);
    $('#'+element_Send).after(this.objContent);
    this.objContent.appendChild(this.input);
    this.objContent.appendChild(this.div);
    ///////////////////////////////

    /*Agrago las funciones a cada evento*/
    var obj = this;
    this.input.onkeyup = function (e) {
        //alert('tecl');
        obj.cboActivo = false;
        if (e.which > 36 && e.which < 41)
        {
            if (e.which == 40)
            {
                cObj.seleccionar(cObj.li_sel+1);
            }
            if (e.which == 38) {
                cObj.seleccionar(cObj.li_sel - 1);
            }
            return false;
        }

        //---Elimine la variable que contiene la ejecución del bucle anterior---
        clearInterval(Buscando);

        //---almaceno la función en una variable---
        Buscando=setTimeout(function () { cboBuscar(obj) }, 200);
        
    };

    this.disabled = function (opcion) {
        if (opcion == undefined||opcion==false) {
            if ($('#' + obj.element_Send).val() == undefined) {
                $(obj.input).attr('disabled', 'disabled');
            } else {
                $(obj.objContent).find('img').css('display', 'none');
                $(obj.objContent).css('background', '#EBEBE4');
            }
        } else {
            if ($('#' + obj.element_Send).val() == undefined) {
                $(obj.input).removeAttr('disabled', 'disabled');
            } else {
                $(obj.objContent).find('img').css('display', 'inline-block');
                $(obj.objContent).css('background', '#fff');
            }
        }
    }
    
    this.seleccionar = function (id, mostrar) {
        //alert('3');
        cboSeleccionar(obj,id,mostrar);
    };
    this.seleccionar1 = function (id, mostrar) {
        //alert('3');
        cboSeleccionar1(obj,id,mostrar);
    };  

    this.input.onkeydown = function () {        
        obj.cboActivo = false;       
    }

    this.input.onfocus = function ()
    {     
        this.style.color = '#000';
        obj.inputfocus();
    }

    if (activarClik) {
        this.activarClick = true;
        this.element_Send.onclick = function () {
            //alert('hi');
            cboBuscar(obj);
        }
    }    

    this.input.onchange = function () {
        cboValidar(obj);
    }

    this.input.onblur = function () {        
        cboValidar(obj);        
    }

    this.input.onkeydown = function (e) {
        if (e == null) {
            e = window.event;
        }
                
        if (e.which == 13 || e.which == 9)
        {
            obj.cboActivo = false;
            //cboBuscar(obj);
            cboValidar(obj);
            return false;
        }        
    }
    
    this.seleccionado = function () { }
    this.terminado = function () { }

    this.eliminar = function () {
        var id = $('#' + element_Send).val('');
        cboEliminar(obj,id);
    }

    this.eliminado = function () { }
    $(document).on('click',function(e){
        var container=$('#'+element_Send);
        
        
       // alert("¡Pulsaste fuera!");
       //alert(this.id);
       
    if (!container.is(e.target) && container.has(e.target).length === 0) { 

         var container1=$('#input'+element_Send);
         if (!container1.is(e.target) && container1.has(e.target).length === 0) { 
             //var container2=$('#cbo' + objContent.id);
            if($(e.target).attr("class") != "lista_click"){
                if($(obj.objContent).is(":visible")){
                    $(obj.objContent).css('display','none');
                    $('#'+element_Send).addClass('cboPorSeleccionar');
                }
                
                //alert("¡Pulsaste fuera11!");
               // $(".mydiv").hide();
            }
        }

    }
    });
}

var cboBuscar = function (obj)
{
    $(obj.objContent).css('display','block');
    $(obj.input).css('display','block');
    $(obj.input).focus();
    $(obj.element_Send).removeClass("cboSeleccionado");
    $(obj.element_Send).removeClass("cboPorSeleccionar");
    var input=obj.input;
    var div = obj.div;

    if (input.value == '' && !obj.activarClick) {
        div.style.display = 'none';
        return;
    }

    div.innerHTML='Cargando...';
    div.style.display = 'block';

    $.ajax({
        type: "post",
        url: obj.url,
        data: {            
            txtBuscar: input.value
        },
        datatype: "json",
        success: function (respuesta) {  
			//alert(respuesta);		
            var respuesta = $.parseJSON(respuesta);  
            div.innerHTML = '' + respuesta.resultado;

            var ul = $('#' + div.id + ' .cbo-ul');   
            //var ancho =$(obj.objContent).width();
            ul.width(obj.width + 'px');
            
            /*Agrego el evento seleccionar*/
            var item=0;
            ul.find('li').each(function (key, li) {               
                $(li).find('span').each(function (key, span) {
                    item++;
                    li.onclick = function () {                        
                        obj.seleccionar(span.id);
                    };
                });               
            });
            /*if(item==0){
                //$('#send'+obj.element_Send.id).remove();
                obj.eliminar();
            }*/
            /*Agrego los eventos de seleccionar con teclado*/
            cObj = new objUl(ul,obj);

            $('#script').html(respuesta.funcion);
           
        },
        error: function () {
            div.innerHTML = 'Error al conectarse';
        },
        complete: function () {
            obj.terminado();
        }
    });

}

var cboSeleccionar = function (obj, id, mostrar) {
    
    /*if($("#send"+obj.element_Send.id).length){
        $("#send"+obj.element_Send.id).remove();
    }*/
    var text = '';
    if (mostrar == undefined) {
        text = $('#' + obj.div.id).find('#'+id).html();
    } else {
        text = mostrar;
    }
    
    if (text!=null) {
        var div_Content = obj.objContent;
        /*var input_send = document.createElement('input');
        input_send.name=obj.element_Send.id;
        input_send.id='send'+obj.element_Send.id;
        $(input_send).css('display','none');*/
        obj.input_send.value=id;
        
        $(obj.element_Send).click(function(){
           cboEliminar(obj, id);
        });
  
        $(div_Content).html('');
        $(div_Content).css('display','none');
        //$(obj.element_Send).after(input_send);
        $(obj.element_Send).val(text);
        $(obj.element_Send).addClass("cboSeleccionado");
        $(obj.element_Send).removeClass("cboPorSeleccionar");
        
        obj.seleccionado();
        var contador=0;
        var objeto_sig;
        $('input').each(function(){
            if($(this).is(":visible")){
                if(contador>0){
                objeto_sig=this.id;
                return false;
                }
                if(this.id==obj.element_Send.id){
                    contador++;
                }
            }
        });
       
        if($.trim(objeto_sig)!=""){
            $("#"+objeto_sig).focus();
        }
      
        
    }
}
var cboSeleccionar1 = function (obj, id, mostrar) {
    
    
    var text = '';
    if (mostrar == undefined) {
        text = $('#' + obj.div.id).find('#'+id).html();
    } else {
        text = mostrar;
    }
    
    if (text!=null) {
        var div_Content = obj.objContent;
       
        obj.input_send.value=id;
        $(obj.element_Send).click(function(){
            cboEliminar(obj, id);
        });
  
        $(div_Content).html('');
        $(div_Content).css('display','none');
        //$(obj.element_Send).after(input_send);
        $(obj.element_Send).val(text);
        $(obj.element_Send).addClass("cboSeleccionado");
        $(obj.element_Send).removeClass("cboPorSeleccionar");
        
        //obj.seleccionado();
        var contador=0;
        var objeto_sig;
        $('input').each(function(){
            if($(this).is(":visible")){
                if(contador>0){
                objeto_sig=this.id;
                return false;
                }
                if(this.id==obj.element_Send.id){
                    contador++;
                }
            }
        });
        if($.trim(objeto_sig)!=""){
            $("#"+objeto_sig).focus();
        }   
    }
}


var cboEliminar=function (obj, id) {
    var div_content = obj.objContent;
    var div_cbo = document.createElement('div');
    $(obj.element_Send).val('');
    $(obj.input).val('');
    obj.input.onfocus = function () {
        obj.inputfocus();
    }
    //$("#send"+obj.element_Send.id).remove();
    /*if(typeof($("#send"+obj.element_Send.id))!="undefined"){
        $("#send"+obj.element_Send.id).val('');
    }*/
    div_cbo = obj.div;
    div_cbo.style.display = 'block';
    obj.input_send.value='';
    //$('#send'+obj.element_Send.id).remove();
    $(div_content).css('display','block');
    $(obj.input).css('display','block');
    
    div_content.appendChild(obj.input);
    div_content.appendChild(div_cbo);
    $(obj.element_Send).addClass("cboPorSeleccionar");
    $(obj.element_Send).removeClass("cboSeleccionado");
    $(obj.input).focus();
    obj.eliminado();
}

var cboValidar = function (obj) {
    //var ancho=$(obj.element_Send).width();
    
    //$(obj.objContent).width(ancho);
   
    if (obj.cboActivo == false) {
        obj.div.style.display = 'none';
        //obj.element_Send.style.color = 'red';
        var lies = $('#' + obj.div.id + ' ul li');
        
        var encontrado = false;
        lies.each(function (key, li) {            
            $(li).find('span').each(function (key, span) {
                var texto = HTMLtoValue(span.innerHTML);
                var buscar = obj.input.value;

                if ($.trim(texto.toLowerCase()) == $.trim(buscar.toLowerCase())) {
                    //alert(this.id);
                    obj.seleccionar(this.id);
                    encontrado = true;
                    return false;
                }
            });
            if (encontrado){
                return false;
            }
        });
       lies.remove();
       
    }
    
}


var newCbo = function (objContent_id,element_Send, url,activarClick,ancho)
{ 
    var objContent = document.createElement('div');
    objContent.id=objContent_id;
    //var objContent = document.getElementById(objContent_id);
    var oCbo = new cbo(objContent, element_Send, url, activarClick,ancho);
	
    return oCbo;
}

var cargarCbo = function (objContent_id, element_Send, url,id, txtMostrar, activarClick,ancho) {
    var objContent = document.createElement('div');
    objContent.id=objContent_id;
    //var objContent = document.getElementById(objContent_id);
    var oCbo = new cbo(objContent, element_Send, url,activarClick,ancho);

    //Cargo el registro seleccionado
    oCbo.seleccionar(id, txtMostrar);
    return oCbo;
}

var objUl = function (obj,Obj_contenedor)
{   
    this.li_sel=0;
    this.li_sel_old = -1;
    this.vDesplazamiento = 0;

    obj.find('li').hover(function () {       
          Obj_contenedor.cboActivo = true;       
    });

    obj.mouseleave(function () {
        Obj_contenedor.cboActivo = false;
    });

    obj.find('li').click(function () {        
        Obj_contenedor.element_Send.select();        
    });

    this.seleccionar = function (li_id) {
        
        if (obj.find('#li_' + li_id).html())
        {
            ///*Mueve el Scroll en el item seleccionado*/
            //if (li_id == 1) {
            //    position[li_id] = 0;
            //} else {
            //    position[li_id] = position[li_id - 1] + obj.find('#li_' + (li_id-1)).height();
            //}                        
            //obj.scrollTop(position[li_id]+100);
            ////---------------------------

            this.li_sel_old = this.li_sel;
            this.li_sel = li_id;
            obj.find('#li_' + this.li_sel).addClass('cObj_Sel');
            obj.find('#li_' + this.li_sel_old).removeClass('cObj_Sel');
            Obj_contenedor.input.value = HTMLtoValue(obj.find('#li_' + this.li_sel).find('span').html());
            
            var ulHeight = obj.height();
            var liHeight=obj.find('#li_' + this.li_sel).height();
            var position = obj.find('#li_' + this.li_sel).position().top + liHeight;
             
            if (this.li_sel > this.li_sel_old) {
                if (position >= ulHeight) {
                    this.vDesplazamiento = this.vDesplazamiento + liHeight;
                    obj.scrollTop(this.vDesplazamiento);
                }
            }

            if (this.li_sel < this.li_sel_old) {
                if (position - liHeight <= 0) {
                    this.vDesplazamiento = this.vDesplazamiento - liHeight;
                    obj.scrollTop(this.vDesplazamiento);
                }
            }
            
            
        }
    }
}

/*----------------Etiquetas Select-----------------------*/
var ajaxSelect = function (objContent,url,txtBuscar,callBack)
{
   //alert(url);
   $('#' + objContent).html('<div id="grid-loading"><img style="width:40%;" src="/include/img/loading-select.gif" /></div>');
   $.ajax({
        type: "post",
        url: url,
        data: {
            txtBuscar: txtBuscar
        },
        datatype: "json",
        success: function (respuesta) {
          
            var respuesta = $.parseJSON(respuesta);
            //alert(respuesta.resultado);
            $('#' + objContent).html(respuesta.resultado);            
            $('#' + objContent).trigger("chosen:updated");
            $('#script').html(respuesta.funcion);

            if (callBack){
                callBack.apply();
            }
            
        },
        error: function () {
            $('#' + objContent).html('Error al conectarse con el servidor');            
        }
    });
}


/*--------------Etiquetas selec -------*/
var cboMostrarTexto = function (url,buscador,divContenedor)
{
    //alert(buscador);
    $.ajax({
        type: "post",
        url: url,
        data: {            
            txtBuscar: buscador
        },
        datatype: "json",
        success: function (respuesta) {  
		//alert(respuesta);		
            var respuesta = $.parseJSON(respuesta); 
            $('#'+divContenedor).html(respuesta.resultado);

        },
        error: function () {
            $('#'+divContenedor).html('Error al conectarse');
        },
        complete: function () {
            
        }
    });

}

