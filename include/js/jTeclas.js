$(function () {
    $('.text').keypress(function (e) {
      /*  if (e == null) {
            e = window.event;
        }

        if (e.which == 39)
        {
            alert('La tecla presionada no está permitida.');
            return false;
        }*/
    });

    /*-----------------------Texto  - Enteros  '001'------------*/
    $('.text-int').keypress(function (e) {
        if (e == null) {
            e = window.event;
        }

        if (e.which != 8 && e.which != 45 && e.which != 0 && e.which != 13 && (e.which < 48 || e.which > 57)) {
            toastem.error('La tecla presionada no está permitida.');
            return false;
        }
    });

    $('.text-int').click(function () {
        $(this).select();
    });
    
    /*-----------------------Enteros------------*/
    $('.int').keypress(function (e) {
        if (e == null) {
            e = window.event;
        }
		
        if (e.which != 8 && e.which != 45 && e.which != 0 && e.which != 13 && (e.which < 48 || e.which > 57)) {
            toastem.error('La tecla presionada no está permitida.');
            return false;           
        }
    });

    $('.int').click(function () {
        $(this).select();
    });

    $('.int').change(function () {
       $(this).val(redondear($(this).val(), 0));
    });
    
    /* reconocer numero*/

    /*
    $('.int').focus(function () {
        $(this).select();
    });*/
       
    
    $('.decimal').css('text-align', 'right');    
    $('.decimal').keypress(function (e) {
        if (e == null) {    
            e = window.event;
        }
		
        if (e.which == 44)
        {
            toastem.error('El separado de decimales es el punto.');
            return false;
        }
		
        if (e.which != 8  && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
            toastem.error('La tecla presionada no está permitida.');
            return false;
        }
		
    });

    $('.decimal').change(function () {
        $(this).val(redondear($(this).val(), 2));
    });

    $('.decimal').click(function () {
        $(this).select();
    });
  
    $('.moneda').css('text-align', 'right'); 
    
    $('.moneda').keypress(function (e) {
        if (e == null) {    
            e = window.event;
        }
       
        var str=$(this).val().split('.');
        
       /* if(str.length==1){
            var valor=$(this).val();
            if(valor.length>1){
                var val=valor.split('');
                var numero='';
                for(var $i=0;$i<val.length;$i++){
                    numero=numero+val[$i];
                    if($i%3==0){
                       numero=numero+','; 
                    }
                    
                }
                
                $(this).val(numero);
            }
            
            
        }*/
        if(str.length>1 && str[1].split('').length>1){
            return false;
        }
        if(e.which==46){
            
            var str=$(this).val().split('.');
            if(str[0]==''){
                $(this).val(0);
            }
            
            
        }
        if (e.which != 8 && e.which != 45 && e.which != 0 && e.which != 13 && e.which != 46 && (e.which < 48 || e.which > 57)) {
            toastem.error('La tecla presionada no está permitida.');
            $(this).focus();
            return false;
        }
		
    });
    
    /*$('.moneda').change(function () {
        $(this).val(formatNumber.new($(this).val()));
    });*/
    
  

    $('.moneda').click(function () {
        $(this).select();
    });
/*
    $('.decimal').focus(function () {
        $(this).select();
    });*/

    //----------------------Fecha--------------
    $('.date').attr('maxlength', '11');
    $('.date').attr('autocomplete', 'off');
    $('.date').css('width', '75px');    
    $('.date').each(function (key,obj) {
        if (obj.value == '') {
            obj.value = '__/__/____';
        }
    });
    
    $('.date').keypress(function (e) {
        if (e == null) {
            e = window.event;
        }

        if ((e.which <= 47 || e.which >= 58) && e.which != 8 && e.which != 0) {
            return false;
        }
    });

    $('.date').keyup(function (e) {
        if (e == null) {
            e = window.event;
        }

        var cadena = $.trim($(this).val());
        
       var longitud=cadena.length ;
       var posicion = this.selectionStart;
       var nueva_cadena = cadena.split('/');
       
       if (nueva_cadena.length == 2)
       {
           if (posicion == 2)
           {
               nueva_cadena[1] = cadena.substring(2, 4);
               nueva_cadena[2] = cadena.substring(5, 9);               
           }
           
           if (posicion == 5) {
               nueva_cadena[1] = cadena.substring(3, 5);
               nueva_cadena[2] = cadena.substring(5, 9);               
           }
       }

       if (nueva_cadena[1] == undefined) {
           nueva_cadena[1] = '__';
       }
       
       if (nueva_cadena[2] == undefined) {
           nueva_cadena[2] = '____';
       }
       
       nueva_cadena[0] = nueva_cadena[0] + '__';
       nueva_cadena[1] = nueva_cadena[1] + '__';
       nueva_cadena[2] = nueva_cadena[2] + '____';

       nueva_cadena[0] = nueva_cadena[0].slice(0,2);
       nueva_cadena[1] = nueva_cadena[1].slice(0, 2);
       nueva_cadena[2] = nueva_cadena[2].slice(0, 4);
       
       $(this).val(nueva_cadena[0] + '/' + nueva_cadena[1] + '/' + nueva_cadena[2]);

       
       if ((posicion == 2 || posicion == 5) && (e.which != 37 && e.which != 8)) {
            this.selectionStart = posicion + 1;
            this.selectionEnd = posicion + 1;           
       } else {
           this.selectionStart = posicion;
           this.selectionEnd = posicion;
       }
       
    });
    
    $('.date').blur(function () {     
        if (validarFecha($(this).val())) {
            $(this).css('color', '#000');
        } else {
            $(this).css('color', 'red');            
        }
    });
    
    //---------------------------------------

    //----------------------Fecha--------------
    $('.time24H').css('text-align', 'center');
    $('.time24H').css('width', '60px');
    $('.time24H').attr('autocomplete', 'off');
    $('.time24H').each(function (key, obj) {
        if (obj.value == '') {
            obj.value = '--:--:--';
        }
    });

    $('.time24H').keypress(function (e) {
        if (e == null) {
            e = window.event;
        }
        
       /* if (e.shiftKey && e.which == 58) {
            return true;
        }*/

        if ((e.which <= 47 || e.which >= 58) && e.which != 8 && e.which != 0) {
            return false;
        }
    });

    $('.time24H').keyup(function (e) {
        if (e == null) {
            e = window.event;
        }

        var cadena = $.trim($(this).val());

        var longitud = cadena.length;
        var posicion = this.selectionStart;
        var nueva_cadena = cadena.split(':');

        if (nueva_cadena.length == 2) {
            if (posicion == 2) {
                nueva_cadena[1] = cadena.substring(2, 4);
                nueva_cadena[2] = cadena.substring(5, 7);
            }

            if (posicion == 5) {
                nueva_cadena[1] = cadena.substring(3, 5);
                nueva_cadena[2] = cadena.substring(5, 7);
            }
        }

        if (nueva_cadena[1] == undefined) {
            nueva_cadena[1] = '--';
        }

        if (nueva_cadena[2] == undefined) {
            nueva_cadena[2] = '--';
        }

        nueva_cadena[0] = nueva_cadena[0] + '--';
        nueva_cadena[1] = nueva_cadena[1] + '--';
        nueva_cadena[2] = nueva_cadena[2] + '--';

        nueva_cadena[0] = nueva_cadena[0].slice(0, 2);
        nueva_cadena[1] = nueva_cadena[1].slice(0, 2);
        nueva_cadena[2] = nueva_cadena[2].slice(0, 2);

        $(this).val(nueva_cadena[0] + ':' + nueva_cadena[1] + ':' + nueva_cadena[2]);


        if ((posicion == 2 || posicion == 5) && (e.which != 37 && e.which != 8)) {
            this.selectionStart = posicion + 1;
            this.selectionEnd = posicion + 1;
        } else {
            this.selectionStart = posicion;
            this.selectionEnd = posicion;
        }

    });

    $('.time24H').blur(function () {
        if (validarTime24H($(this).val())) {
            $(this).css('color', '#000');
        } else {
            $(this).css('color', 'red');
        }
    });
    //--------------------------------------------

    //---------------Email------------------
    $('.email').blur(function () {        
        if (!validarEmail($(this).val()))
        {
            //mensaje.error("Mensaje de error","No es un correo valido.",this.id);
            $(this).css('color', 'red');
        }
    });

    $('.email').focus(function () {
        $(this).css('color', '#000')
    });


    /**-----Direccion Ipv4----*/
    $('.ipv4').css('text-align', 'right');
    $('.ipv4').css('width', '100px');
    $('.ipv4').attr('maxlength', '15');
    $('.ipv4').attr('placeholder', '0.0.0.0');
    $('.ipv4').keydown(function () {
        $(this).css('color', '#000');
    });

    $('.ipv4').blur(function () {
        if (!validarIP(this.value)) {
            $(this).css('color', 'red');
        }
    });

    /**-----Direccion Mac----*/
    $('.mac').css('text-align', 'right');
    $('.mac').css('width', '140px');
    $('.mac').attr('maxlength', '17');
    $('.mac').attr('placeholder', 'XX:XX:XX:XX:XX:XX');
    $('.mac').keydown(function () {
        $(this).css('color', '#000');
    });

    $('.mac').blur(function () {
        if (!validarMac(this.value)) {
            $(this).css('color', 'red');
        }
    });
});
var format_Moneda_Numero=function(callbackValidar){
    
    $('.moneda').each(function(){
        var valor=$(this).val().split(',').join('');
        $(this).val(valor);
    });
    callbackValidar();
}
var formatNumber = {
     
    separador: ",", // separador para los miles
    sepDecimal: '.', // separador para los decimales
    formatear:function (num){
        
     num +='';
     var splitStr = num.split('.');
     var splitLeft = splitStr[0];
     
     var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '.00';
     var regx = /(\d+)(\d{3})/;
     while (regx.test(splitLeft)) {
     splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
     }
     return this.simbol + splitLeft  +splitRight;
    },
    new:function(num, simbol){
        
     this.simbol = simbol ||'';
    
     return this.formatear(num);
    }
}
function validarEmail(cadena)
{
    var expresion = /^([\dA-Za-z0-9_\.-]+)@([\dA-Za-z0-9\.-]+)\.([A-Za-z0-9\.]{2,6})$/;
    return expresion.test(cadena);       
}

function validarFecha(cadena) {    
    var buscar = cadena.indexOf("_");

    if (buscar == -1) {
        var cadena = cadena.split('/');
        var dia = parseFloat(cadena[0]);
        var mes = parseFloat(cadena[1]);
        var anio = parseFloat(cadena[2]);
        
        if (mes == 2) {
            var bisiesto = (anio % 4 == 0 && (anio % 100 != 0 || anio % 400 == 0));

            if (dia > 29 || (dia == 29 && !bisiesto)) {
               
                alert('Febrero del año ' + anio + ' no contiene ' + dia + ' días.');
                return false;
            }
        }

        if (dia < 1 || dia > 31) {
            alert("El valor del día debe estar comprendido entre 1 y 31 dependiendo de la fecha");
            return false;
        }

        if (mes < 1 || mes > 12) {
            alert("El valor del mes debe estar comprendido entre 1 y 12");
            return false;
        }

        if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31) {
            alert('El mes ' + mes + ' no tiene 31 días');
            return false;
        }

        return true;
    } else {
        return false;
    }
}

function validarTime24H(cadena) {
    var buscar = cadena.indexOf("-");

    if (buscar == -1) {
        var cadena = cadena.split(':');
        var hours = parseInt(cadena[0]);
        var minutes = parseInt(cadena[1]);
        var seconds = parseInt(cadena[2]);

        if (hours > 23) {
            alert("El valor de la hora debe estar comprendido entre 0 y 23.");
            return false;
        }

        if (minutes > 59) {
            alert("El valor de los minutos debe estar comprendido entre 0 y 59.");
            return false;
        }

        if (seconds > 59) {
            alert("El valor de los segundos debe estar comprendido entre 0 y 59.");
            return false;
        }

        return true;
    } else {
        return false;
    }
}

/*Agregar una clase int en tiempo de ejecución*/
var addInt = function (obj) {
    
}


/*Agregar una clase decimal en tiempo de ejecución*/
var addClassRunTime = function (obj, _class) {
    $(obj).unbind("keypress");
    $(obj).unbind("change");
    $(obj).unbind("click");

    switch (_class) {
        case "int":
                $(obj).css('text-align', 'right');
                $(obj).keypress(function (e) {
                    alert();
                    if (e == null) {
                        e = window.event;
                    }

                    if (e.which != 8 && e.which != 45 && e.which != 0 && e.which != 13 && (e.which < 48 || e.which > 57)) {
                        alert('La tecla presionada no está permitida.');
                        return false;
                    }
                });

                $(obj).change(function () {
                    $(this).val(redondear($(this).val(), 0));
                });

                $(obj).click(function () {
                    $(this).select();
                });
                
                if ($.trim($(obj).val()) != '') {
                    $(obj).val(redondear($(obj).val(), 0));
                }
                break;

        case "decimal":
            $(obj).css('text-align', 'right');
            $(obj).keypress(function (e) {
                if (e == null) {
                    e = window.event;
                }

                if (e.which == 44) {
                    alert('El separado de decimales es el punto.');
                    return false;
                }

                if (e.which != 8 && e.which != 45 && e.which != 0 && e.which != 13 && e.which != 46 && (e.which < 48 || e.which > 57)) {
                    alert('La tecla presionada no está permitida.');
                    return false;
                }
            });

            $(obj).change(function () {
                $(this).val(redondear($(this).val(), 2));
            });

            $(obj).click(function () {
                $(this).select();
            });

            if ($.trim($(obj).val()) != '') {
                $(obj).val(redondear($(obj).val(), 2));
            }            
            break;
       
    }
}

/*-----------Validar la dirección IP----------*/
var validarIP = function (text) {
    var reg = new RegExp('^([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})$');
    return reg.test(text);
}

/*-----------Validar la dirección Mac----------*/
var validarMac = function (text) {
    var reg = new RegExp('^(([a-zA-Z]|[0-9]){1,2}):(([a-zA-Z]|[0-9]){1,2}):(([a-zA-Z]|[0-9]){1,2}):(([a-zA-Z]|[0-9]){1,2}):(([a-zA-Z]|[0-9]){1,2}):(([a-zA-Z]|[0-9]){1,2})$');
    return reg.test(text);
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