$(document).ready(function(){
   
    $('.obligatorio').each(function(){
        
        //$(this).after('<span style="color:red;float:left;"> *</span>');
         $(this).css('border','1px solid rgba(255,64,23,0.9)');
        
    });
    
    if(typeof($('.btn_flotante'))){
        var contedor=$('.btn_flotante');
        var alto_contenedor=contedor.height();
        var alto_ventana=$('body').height();
        contedor.append('<img  id="imgLeft" class="imgContenedor"  src="/include/img/left.png" style="position:absolute;width:20px;">');
        $('.imgContenedor').click(function(){
            var atributo=$(this).attr('src');
            //alert(atributo);
            if(atributo=='/include/img/left.png'){
                $('.btn_flotante').toggle("fast");
                //var top_boton=(alto_ventana-32)/2;
                var contador=0;
                $('#imgRight').each(function(){
                    contador++;
                });
                if(contador==0){
                    $('body').append('<img  id="imgRight" onclick="mostrar();" style="position:absolute;cursor:pointer;left:0;bottom:15px;" class="imgContenedor" src="/include/img/right.png">');
                }else {
                    
                    $('#imgRight').css('display','block');
                }
               
                
             
               
               
            }else {
                contedor.css('display','block');
            }
            
        });
      
       /* var top=(alto_ventana-alto_contenedor)/2;
        $('.btn_flotante').css('top',top);*/
        
    }
        if(typeof($('.btn_flotante_hijo'))){
        var contedor=$('.btn_flotante_hijo');
        var alto_contenedor=contedor.height();
        var alto_ventana=$('body').height();
        contedor.append('<img  id="imgLeft" class="imgContenedor" src="/include/img/left.png"  style="position:absolute;width:20px;">');
        $('.imgContenedor').click(function(){
            var atributo=$(this).attr('src');
            //alert(atributo);
            if(atributo=='/include/img/left.png'){
                $('.btn_flotante_hijo').toggle("fast");
                //var top_boton=(alto_ventana-32)/2;
                var contador=0;
                $('#imgRight').each(function(){
                    contador++;
                });
                if(contador==0){
                    $('body').append('<img  id="imgRight" onclick="mostrar1();" style="position:absolute;cursor:pointer;left:0;bottom:90px;" class="imgContenedor" src="/include/img/right.png">');
                }else {
                    
                    $('#imgRight').css('display','block');
                }
               
            }else {
                contedor.css('display','block');
            }
            
        });
      
       /* var top=(alto_ventana-alto_contenedor)/2;
        $('.btn_flotante').css('top',top);*/
        
    }
    if(typeof($('.btn_flotante_hijo_hijo'))){
        var contedor=$('.btn_flotante_hijo_hijo');
        var alto_contenedor=contedor.height();
        var alto_ventana=$('body').height();
        contedor.append('<img  id="imgLeft" style="padding-bottom:35px;" class="imgContenedor" src="/include/img/left.png" style="position:absolute; width:20px;">');
        $('.imgContenedor').click(function(){
            var atributo=$(this).attr('src');
            //alert(atributo);
            if(atributo=='/include/img/left.png'){
                $('.btn_flotante_hijo_hijo').toggle("fast");
                //var top_boton=(alto_ventana-32)/2;
                var contador=0;
                $('#imgRight').each(function(){
                    contador++;
                });
                if(contador==0){
                    $('body').append('<img  id="imgRight" onclick="mostrar2();" style="position:absolute;cursor:pointer;left:0;bottom:10px;" class="imgContenedor" src="/include/img/right.png">');
                }else {
                    
                    $('#imgRight').css('display','block');
                }
               
            }else {
                contedor.css('display','block');
            }
            
        });
      
       /* var top=(alto_ventana-alto_contenedor)/2;
        $('.btn_flotante').css('top',top);*/
        
    }
    $('.btnBuscadorBtn input[type=radio]').click(function(){
        var valor=this.value;
        if(valor=='buscar'){
            $('.tablaFiltrar').css('display','none');
            $('.tablaBuscar').css('display','block');
            $('#btnTitulo').html('Buscar');
        }else {
             $('.tablaFiltrar').css('display','block');
            $('.tablaBuscar').css('display','none');
            $('#btnTitulo').html('Filtrar');
        }
    });
    
    
});
       
function mostrar(){
    $('.btn_flotante').toggle("fast");
    $('#imgRight').css('display','none');
}
function mostrar1(){
   
    $('.btn_flotante_hijo').toggle("fast");
    $('#imgRight').css('display','none');
}
function mostrar2(){
   
    $('.btn_flotante_hijo_hijo').toggle("fast");
    $('#imgRight').css('display','none');
}

