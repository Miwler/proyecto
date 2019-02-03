    function close_registro_informacion(){
        $('#Modal_Registro_Informacion').modal('hide');
        fncAgregarInformacionGrilla();
    }
    var objeto;
    var opcion_seleccionado="";
    var obligatorio=0;
    function fncRegistrar_Informacion_Multiple(obj,html_input,opcion,valobligatorio){
        objeto=obj;
        opcion_seleccionado=opcion;
        obligatorio=valobligatorio;
        var valores_registrados=$(obj).val();

        $("#Modal_Registro_Informacion .modal-body").html(html_input);
        $("#Modal_Registro_Informacion").modal("show");
        if($.trim(valores_registrados)!=""){
             var array_valores=[];
             switch(opcion){
                 case "correos":
                     
                     
                     array_valores=valores_registrados.split(';');
                     break;
                 case "celulares":
                     
                     array_valores=valores_registrados.split('/');
                     break;
                case "telefono":
                    
                     array_valores=valores_registrados.split('/');
                     break;
             }
           
            var i=0;
            $("#Modal_Registro_Informacion .modal-body :input").each(function(){
                $(this).val(array_valores[i]);
                i++;
            });
        }
        switch(opcion){
            case "correos":
                
                $("#Registro_Informacion_Title").html("Registro de correos");
               
                break;
            case "celulares":
                $("#Registro_Informacion_Title").html("Registro de celulares");
                
                break;
           case "telefono":
                $("#Registro_Informacion_Title").html("Registro de teléfonos");
                
                break;
        }
    }
    function fncAgregarInformacionGrilla(){
        var cadena='';
        var i=0;
        var contador_sinvalor=0;
        $("#Modal_Registro_Informacion .modal-body :input").each(function(){
            var valor=$(this).val();
            if($.trim(valor)!=""){
                switch(opcion_seleccionado){
                    case "correos":
                        if(i==0){
                            cadena=valor;  
                        }else{
                            cadena=cadena+';'+valor;  
                        }
                        break;
                    case "celulares":
                        if(i==0){
                            cadena=valor;  
                        }else{
                            cadena=cadena+'/'+valor;  
                        }
                        break;
                    case "telefono":
                        if(i==0){
                            cadena=valor;  
                        }else{
                            cadena=cadena+'/'+valor;  
                        }
                        break;
                }
                
              i++;  
            }else{
                if(obligatorio==1){
                    
                   contador_sinvalor++;
                }
            }

        });
        if(contador_sinvalor==0){
            opcion_seleccionado="";
            obligatorio=0;
            $(objeto).val(cadena);
            $('#Modal_Registro_Informacion').modal('hide');
        }else{
            toastem.error("Debe registrar todos las cajas.");
        }
        
    }
    function validar_correo(obj){
        if(obligatorio==1){
            if (!validarEmail($(obj).val()))
            {

                toastem.error("Debe registrar un email correcto");
                $(obj).focus();
                return false;
            }
        }else{
            if($(obj).val()!=""){
                if (!validarEmail($(obj).val()))
                {
                    toastem.error("Debe registrar un email correcto");
                    $(obj).focus();
                    return false;
                }
            }
        }
        
    }
    function validar_celular(obj){
        
        if(obligatorio==1){
            var valida=validarCelular($(obj).val());
            if (isNaN($(obj).val()) || !validarCelular($(obj).val()))
            {
                console.log(valida);
                toastem.error("Debe registrar un celular correcto");
                $(obj).focus();
                return false;
            }
        }else{
            if($(obj).val()!=""){
               if (isNaN($(obj).val()) || !expresion.test($(obj).val()))
                {

                    toastem.error("Debe registrar un celular correcto");
                    $(obj).focus();
                    return false;
                }
            }
        }
        
    }

   
    function validarEmail(cadena)
    {
        var expresion = /^([\dA-Za-z0-9_\.-]+)@([\dA-Za-z0-9\.-]+)\.([A-Za-z0-9\.]{2,6})$/;
        return expresion.test(cadena);       
    }
    function validarCelular(cadena)
    {
        var expresion = /^([0-9])*$/;
        return expresion.test(cadena);       
    }