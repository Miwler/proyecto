<?php
	require ROOT_PATH . "views/shared/content-float-modal.php";
?>
<?php function fncTitle(){?>Registrar Cotización<?php } ?>

<?php function fncHead(){?>

<script>
$(document).ready(function(){
    cronometro();
});
</script>
<?php } ?>

<?php function fncTitleHead(){ ?>Registrar Cotización<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==1||$GLOBALS['resultado']==-1){ ?>
	<form id="frm1"  method="post" >
	    <div class="form-body">
	        <H3>prueba</H3>


	        <!--<iframe id="pdf" style='width: 100%; height: 540px;'>
	        </iframe>-->
	    </div>
	    <div class="form-footer">
	        <button  id="btnCancelar" name="btnCancelar" type="button" class="btn btn-warning" title="Regresar" onclick="parent.float_close_modal_hijo_hijo();" >
	        <span class="glyphicon glyphicon-arrow-left"></span>
	            Regresar
	        </button>
	    </div>
	</form>
<?php }?>

<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
        $(document).ready(function () {
        toastem.error('<?php echo $GLOBALS['mensaje']; ?>');
        });
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
<script type="text/javascript">
    $(document).ready(function () {
       toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
    });
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
