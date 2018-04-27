<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Detalle compra<?php } ?>

<?php function fncHead(){?>

	<script type="text/javascript" src="include/js/jForm.js"></script>
      
        

        <script>
            $(document).ready(function(){
                /*if(typeof($('#txtProducto_ID').val())!="undefined"){
                    fncListaProductosVendidos($('#txtProducto_ID').val());
                }*/
            $('#txtRegSeries').focus();
            });
            
        </script>
	
<?php } ?>

<?php function fncTitleHead(){?>Registrar series de los productos<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>

 
<form id="frm2"  class="divRegistrarSeries form-horizontal"  method="post" action="/Inventario/Inventario_Mantenimiento_Serie" onsubmit="return validar();" class="form-horizontal">
    <div style="heigth:300px;overflow:auto;">
        <?php echo $GLOBALS['table'];?>
    </div>
    
			
</form>
   <script type="text/javascript">


    $("#txtRegSeries").keypress(function(e){
         if(e.which==13){
             fncRegistrarSeries($("#txtRegSeries").val());
         }
     });
    /*$('#txtRegSeries').change(function(){

        fncRegistrarSeries($('#txtRegSeries').val());
    });*/
    $('.grid_detalle input').keyup(function(){
        $('#span'+this.id).html($(this).val());
    });
        var fncRegistrarSeries=function(serie){
            var valor=$('.seleccionar').val();
            //verificamos duplicado
            var i=0;
            $('.grid_detalle tr :input').each(function(){
                var serie_reg=this.value;
                if(serie_reg==$.trim(serie)){
                    i++;
                }
            });
            if(i==0){
                if(valor=="ckSecuencia"){
                $('.grid_detalle tr :input').each(function(){
                        if($.trim($(this).val())==''){
                            $(this).val($.trim(serie));

                            $('#span'+ this.id).html(serie);
                            $('#txtRegSeries').val('');
                            $('#txtRegSeries').focus();
                            return false;
                        }
                    }); 
                }
            }else {
                mensaje.error('Ocurrió un error','Ya existe una serie igual.');
                $('#txtRegSeries').val('');
                $('#txtRegSeries').focus();
                return false;
            }
            
        }
        var fncEditar=function(id){
            if($('#'+id).is(':visible')){
                $('#'+id).css('display','none');
                $('#span'+id).css('display','block');
            }else {
                $('#'+id).css('display','block');
                $('#span'+id).css('display','none');
                $('#'+id).focus();
            }
            
        }
        var fncEliminar=function(id){
            $('#'+id).val('');
            $('#span'+id).html('');
        }
        
       
      $('.seleccionar').click(function(index){
         
          if(this.value=='ckSecuencia'){
              $('#ckDetalle').prop('checked',false);
              $.each($('.grid_detalle input[type=text]'),function(){
                   
                  $(this).css('display', 'none');
              });
              $('.grid_detalle span').each(function(){
                  $(this).css('display', 'block');
              });
          }else {
              $('#ckSecuencia').prop('checked',false);
               $('.grid_detalle input').each(function(){
                  $(this).css('display', 'block');
              });
              $('.grid_detalle span').each(function(){
                  $(this).css('display', 'none');
                });
          }
      });
    var validar=function(){
        $('#fondo_espera').css('display','block');
    }
    </script>
 
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
    <div id="divMensaje"></div>
        <script type="text/javascript">
            
        $('#divMensaje').html(' <?php  echo $GLOBALS['mensaje']; ?>');
           
        </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

    <script type="text/javascript">
    
    $(document).ready(function () {
            
        toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
         setTimeout('parent.windos_float_save_modal_hijo();', 1000);
    });
   
   
    </script>
    <?php } ?>

   <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==0){ ?>
        <div class="float-mensaje">
             <?php  echo $GLOBALS['mensaje']; ?>
        </div>
        <div class="group-btn">
            <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
        </div>
    <?php } ?>    
<?php } ?>
