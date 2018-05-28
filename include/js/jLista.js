var cObj;
var position= new Array();
var n = 0;
var Buscando;
var filtros;
var lista1 = function (objContent,element_Send, url, width, activarClik,filtroClase,widthContenedor,cantidad){
    
    this.objContent = objContent;
    this.element_Send = element_Send;
    if (screen.width<1024){
    //codigo resolución pequeña 
        this.width='100%';
    }else{
        this.width = width;
    }
    
    this.widthContenedor=widthContenedor;
    this.cboActivo = false;
    this.activarClick = false;
    this.teclaPresionada = false;
    this.inputName = '';
    this.tabIndexNext = null;
    this.filtroClase=filtroClase;
    //this.fncEndSeleccionar=fncEndSeleccionar;
    this.inputfocus = function () {
    }

    /*Agrego las etiquetas necesarias*/
    this.url = url;
      
    this.input = document.createElement('input');
    this.input.id = 'txt' + objContent.id;
    this.input.name = 'txt' + objContent.id;
    this.input.type = 'text';
    this.input.autocomplete = 'off';
    //this.input.width = width;   
    this.input.className='form-control';
    this.div = document.createElement('div');
    this.div.id = 'cbo' + objContent.id;
    this.div.className = 'cbo-div';
    //$("#"+objContent.id).css('margin-top','-10px');
   
    
    this.objContent.appendChild(this.input);
    this.objContent.appendChild(this.div);
    ///////////////////////////////
    /////agrego inputcantidad
   
    if(isNaN(cantidad)==false){
        $(this.objContent).after("<div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><input id='IntCantidad' name='IntCantidad' autocomplete='off' value='"+ cantidad +"' class='form-control'></div>");
        /*this.inputInt=document.createElement('input');
        this.inputInt.id='IntCantidad';
        this.inputInt.name='IntCantidad';
        this.inputInt.type='text';
        this.inputInt.autocomplete='off';
        this.inputInt.className='form-control';
        this.inputInt.width='30';
        this.inputInt.height='25';
        this.inputInt.value=cantidad;
        $(this.inputInt).css('top','-8');
        //var contenedor=this.objContent.parentNode;
        //contenedor.appendChild(this.inputInt);*/
        
    /*Agrego el ancho*/
        //$('#'+this.inputInt.id).width('20px');
        //$('#'+this.inputInt.id).height('20px');
    }
    
    var nuevo=parseInt(width)+14;
    $('#' + this.objContent.id).width(nuevo + 'px');
    //$('#' + this.input.id).width((width*99.2/100) + 'px');
    
    $(this.input).width(width + 'px');
    $('#' + this.div.id).width((widthContenedor) + 'px');

    /*Agrago las funciones a cada evento*/
    var obj = this;
    this.input.onkeyup = function (e) {
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
        Buscando=setTimeout(function () { listaBuscar(obj) }, 200);
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
     
            cboSeleccionar(obj,id,mostrar);
     
        
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
        this.input.onclick = function () {
            listaBuscar(obj);
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
            cboValidar(obj);
        }        
    }
    
    this.seleccionado = function () { }
    this.terminado = function () { }

    this.eliminar = function () {
        var id = $('#' + element_Send).val();
        cboEliminar(obj,id);
    }

    this.eliminado = function () { }
}

var listaBuscar = function (obj)
{
   
    var data = null;
    var myObject = new Object();
    if(obj.filtroClase!=null){
        $('.'+ obj.filtroClase).each(function(key, ob){

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
      filtros=myObject;
      $('.' + obj.div.className).each(function (key, divObj) {
        if (obj.div != divObj) {
            divObj.style.display = 'none';
        }
    });
    }
    
    
    //console.log(arreglo_filtro);
    

    var input=obj.input;
    var div = obj.div;

    if (input.value == '' && !obj.activarClick) {
        div.style.display = 'none';
        return;
    }

    div.innerHTML='Cargando...';
    div.style.display = 'block';
    myObject['txtBuscar']=input.value;
    if(typeof($('#IntCantidad').val()!="undefined")){
        myObject['IntCantidad']=$('#IntCantidad').val();
    }else{
        myObject['IntCantidad']=20;
    }
    
    data = JSON.stringify(myObject);
    data = $.parseJSON(data);
    $.ajax({
        type: "post",
        url: obj.url,
        data: data,
        datatype: "json",
        success: function (respuesta) {  
		//alert(respuesta);		
            var respuesta = $.parseJSON(respuesta);  
            div.innerHTML = '' + respuesta.resultado;

            var ul = $('#' + div.id + ' .cbo-ul');            
            ul.width(obj.widthContenedor + 'px');
            
            /*Agrego el evento seleccionar*/
            ul.find('li').each(function (key, li) {               
                $(li).find('span').each(function (key, span) {
                   
                    li.onclick = function () {                        
                        obj.seleccionar(span.id);
                    };
                });               
            });
            
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
    
    
   
    var text = '';
    if (mostrar == undefined) {
        text = $('#' + obj.div.id).find('#'+id).html();
        //alert(text);
    } else {
        text = mostrar;
    }
    
    if (text!=null) {
        var div_Content = obj.objContent;
        /*Agrego las etiquetas necesarias una vez seleccionada un registro*/
        var div = document.createElement('div');
        var img = document.createElement('img');
        var input = document.createElement('input');
        var input_send = document.createElement('input');
        var input_sendText = document.createElement('input');
        var div_clear = document.createElement('div');
        
        img.id = 'img_' + div_Content.id;
        img.src = '/include/img/boton/delete_list_14x14.png';
        img.className = 'delete-list';
        img.title = 'Eliminar';
        img.onclick = function () {
          
            cboEliminar(obj, id);
        };

        div.id = 'div_' + div_Content.id;
        div.innerHTML = text;
		div.title = HTMLtoValue(text);
        div.className = 'div-list';
        div.style.width = (obj.width - 14) +'px';
        div_clear.id = 'clear_' + div_Content.id;
        div_clear.className = 'clear';
        div.style.height = '18px';
        div.style.overflow= 'hidden';

        input_send.id = obj.element_Send;
        input_send.name = (obj.inputName == '') ? obj.element_Send : obj.inputName;
        input_send.value = id;
        input_send.style.display = 'none';

        input_sendText.id = obj.element_Send+'_Mostrar';
        input_sendText.name = obj.element_Send + '_Mostrar';
        input_sendText.value = div.innerHTML;
        input_sendText.style.display = 'none';

        div_Content.innerHTML = '';
        div_Content.appendChild(div);
        div_Content.appendChild(img);
        div_Content.appendChild(input_send);
        div_Content.appendChild(input_sendText);
        div_Content.appendChild(div_clear);
        obj.seleccionado();
    }
    //Seleccionamos los filtros
    
    $.ajax({
        type: "post",
        url:"Funcion/ajaxListar_Producto_Listar",
        data: {
            codigo: id
        },
        datatype: "json",
        success: function (respuesta) {
            //alert(respuesta);
            var respuesta = $.parseJSON(respuesta);
            
            var i=0;
            $('.'+obj.filtroClase).each(function(){
                if(i==0){
                    $(this).val(respuesta.valor1);
                }else {
                     $(this).val(respuesta.valor2);
                }
                i++;
            });
                
            
           

        },
        error: function () {
            alert(respuesta.mensaje);
            //$('#' + objContent).html('Error al conectarse con el servidor');            
        }
    });
    if(typeof fncEndSeleccionar === 'function') {
    //Es seguro ejecutar la función
        fncEndSeleccionar();
    }
}


var cboEliminar=function (obj, id) {
  
    //alert(obj);
    var div_content = obj.objContent;
    var div = $('#div_' + div_content.id);
    var img = $('#img_' + div_content.id);
    var input_send = $('#' + obj.element_Send);
    var div_clear = $('#clear_' + div_content.id);
//alert(div_content);
    var div_cbo = document.createElement('div');
    var input = document.createElement('input');
   
   
    input = obj.input;
    input.value = "";
    input.onfocus = function () {
        obj.inputfocus();
    }

    div_cbo = obj.div;
    div_cbo.style.display = 'none';

    div_clear.remove();
    div.remove();
    img.remove();
    input_send.remove();
    div_content.appendChild(input);
    div_content.appendChild(div_cbo);
    obj.eliminado();
    if(typeof fncLimpiar ==='function'){
        fncLimpiar();
    }
}

var cboValidar = function (obj) {

    if (obj.cboActivo == false) {
        obj.div.style.display = 'none';
        obj.input.style.color = 'red';
        var lies = $('#' + obj.div.id + ' ul li');
        
        var encontrado = false;
        lies.each(function (key, li) {            
            $(li).find('span').each(function (key, span) {
                var texto = HTMLtoValue(span.innerHTML);
                var buscar = obj.input.value;

                if ($.trim(texto.toLowerCase()) == $.trim(buscar.toLowerCase())) {
                    
                    obj.seleccionar(span.id);
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


var newLista = function (objContent_id,element_Send, url, width,activarClick,filtroClase,widthContenedor,cantidad)
{ //alert('de');
    
    var objContent = document.getElementById(objContent_id);
    var oLista = new lista(objContent,element_Send, url, width, activarClick,filtroClase,widthContenedor,cantidad);
	
    return oLista;
}

var cargarLista = function (objContent_id, element_Send, url, width, id, txtMostrar, activarClick,filtroClase,widthContenedor,cantidad) {
	
    var objContent = document.getElementById(objContent_id);
    var oLista = new lista(objContent, element_Send, url, width, activarClick,filtroClase,widthContenedor,cantidad);

    //Cargo el registro seleccionado
    oLista.seleccionar(id, txtMostrar);
    return oLista;
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
        Obj_contenedor.input.select();        
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

