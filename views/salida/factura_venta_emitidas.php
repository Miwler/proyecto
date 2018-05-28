<?php		
	require ROOT_PATH . "views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Registrar Cotización<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jForm.js"></script>
       

<?php } ?>

<?php function fncTitleHead(){ ?>Registrar Cotización<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="form" method="POST" action="/Salida/Factura_Venta_Emitidas"  class="form-horizontal" onsubmit="return validar();" >
    <div class="form-body">
        <div class="form-group">
            <label class="control-label col-sm-2 col-xs-2">Periodo:</label>
            <div class="col-sm-2 col-xs-2">
                <input type="text" id="txtPeriodo" name="txtPeriodo" value="<?php echo date("Y");?>" class="form-control">
            </div>
            <label class="control-label col-sm-1 col-xs-1">Serie:</label>
            <div class="col-sm-2 col-xs-2">
                <input type="text" id="txtSerie" name="txtSerie" class="form-control">
            </div>
            <label class="control-label col-sm-2 col-xs-2">Número</label>
            <div class="col-sm-2 col-xs-2">
                <input type="text" id="txtNumero" name="txtNumero" class="form-control">
            </div>
            <div class="col-sm-1 col-xs-1">
                <button type="button" class="btn btn-success" onclick="cargarFacturas_Emitidas();"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="form-group" id="tabla" style="height: 270;overflow:auto;">
            
        </div>
    </div>
    
</form>
<script type="text/javascript">
    var cargarFacturas_Emitidas=function(){
        //$("#fondo_espera").appendTo("#tabla");
        $("#fondo_espera").css("display","");
        enviarFormulario('Salida/ajaxFacturas_Emitidas','form',function(resultado){
            $('#tabla').html(resultado.html);
            $("#fondo_espera").css("display","none");
        });
       
    }
    var fncSeleccionar=function(ID){
        parent.windos_float_save_modal_hijo(ID);
    }
    $(document).ready(function(){
        cargarFacturas_Emitidas();
    });
    
</script>   
<?php }?>
            
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
        $(document).ready(function () {
            mensaje.error('MENSAJE DE RESULTADO','<?php echo $GLOBALS['mensaje']; ?>');
        });
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
<script type="text/javascript">
    $(document).ready(function () {
       toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
    });
    setTimeout('parent.windos_float_save_modal_hijo(<?php echo json_encode($GLOBALS['obj']);?>);', 1000);
    
   //ampliarVentanaVertical(750,'form');
    //fncCargar_Detalle_Cotizacion();
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

	     
<?php }?>        