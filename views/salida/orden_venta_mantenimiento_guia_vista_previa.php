<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo-hijo.php";	
?>	
<?php function fncTitle(){?>VISTA PREVIA DE GUIA<?php } ?>

<?php function fncHead(){?>
        <script src="../../include/js/jPdf.js" type="text/javascript"></script>
        <script type="text/javascript">
        $(document).ready(function(){
          pdf.mostrar('Ventas/Guia_Vista_Previa/<?php echo $GLOBALS['oOrden_Venta']->ID;?>');
        });
        </script>
<?php } ?>

<?php function fncTitleHead(){?>VISTA PREVIA DE GUIA<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
 

<form id="frm1"  method="post"  action="Ventas/Orden_Venta_Mantenimiento_Guia_Vista_Previa/<?php echo $GLOBALS['oOrden_Venta']->ID;?>" onsubmit="return validar();">
    <div class="form-body">
        <iframe id="pdf" style='width: 100%; height: 540px;'>
        </iframe>
    </div>
    <div class="form-footer">
        <button  id="btnCancelar" name="btnCancelar" type="button" class="btn btn-warning" title="Regresar" onclick="parent.float_close_modal_hijo_hijo();" >
        <span class="glyphicon glyphicon-arrow-left"></span>
            Regresar
        </button>  
    </div>
</form>
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
