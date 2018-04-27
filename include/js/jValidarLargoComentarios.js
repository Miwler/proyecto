$(function() {
    $('#tdComentario').append("max caracteres<input type='text' id='num_caracteres' disabled style='width:50px;'>");
    
   
})

$(document).ready(function(){
    
    var largo_max=$('.comentario').attr('maxlength');
    var numero_fila_maximo=$('.comentario').attr('rows');
    var contenido=$('.comentario').val();
    
    var largo_actual=$('.comentario').length;
    var largo_restante=0;
    if(largo_actual==0){
        largo_restante=largo_max;
    }else{
        largo_restante=largo_max-largo_actual;
    }
    $('#num_caracteres').val(largo_restante);
    
    $('.comentario').keyup(function(){
        var contenido1=$(this).val();
        var largo=$(this).val().length;
    //var max=$(this).attr('maxlength');
    //alert(contenido1);
    var diff=largo_max-largo;
     
    $('#num_caracteres').val(diff);
    if(typeof(numero_fila_maximo)!='undefined'){
        var numero_fila=contenido1.split("\n");
        if(numero_fila.length>numero_fila_maximo){
            toastem.advertencia("Solo puede escribir hasta "+ numero_fila_maximo + " Filas");
            var nuevo_texto='';
            for( var i=0;i<numero_fila_maximo;i++){
                if(i==0){
                    nuevo_texto=numero_fila[i];
                }else {
                    nuevo_texto=nuevo_texto+'\n'+numero_fila[i];
                }
                
            }
            $(this).val(nuevo_texto);
        }
        
        
    }
    });
});

