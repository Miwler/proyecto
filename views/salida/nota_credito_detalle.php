<?php		
	require ROOT_PATH . "views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Registrar Cotización<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jPdf.js"></script>
	
        <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>

<?php } ?>

<?php function fncTitleHead(){ ?>Registrar Cotización<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==1||$GLOBALS['resultado']==-1){ ?>
<form id="form" method="POST" action="/Salida/Cotizacion_Mantenimiento_Nuevo" onsubmit="return validar();"  class="form-horizontal" >
    <div class="form-body">
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Descripción:</label>
            <div class="col-sm-10 col-md-10 col-xs-10">
                <input type="text" class="form-control">
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Cantidad:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="text" class="form-control">
            </div>
            <label class="control-label col-sm-2 col-md-2 col-xs-2">V. Init:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="text" class="form-control">
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Tipo:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <select class="form-control">
                    <option>BIEN</option>
                </select>
            </div>
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Operación Gratuita:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="checkbox" class="form-control" >
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Descuento:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="checkbox" class="form-control" >
            </div>
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Afectación del IGV.</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <select class="form-control">
                    <option>option</option>
                </select>
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">ISC:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <select class="form-control">
                    <option>Sistema al valor</option>
                </select>
            </div>
            <label class="control-label col-sm-2 col-md-2 col-xs-2">importe ISC.</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <select class="form-control">
                    <option>option</option>
                </select>
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">IGV:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="checkbox" class="form-control" >
            </div>
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Total:</label>
            <div class="col-sm-4 col-md-4 col-xs-4 text-left">
                <input type="checkbox">
            </div>
        </div>
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button type="button" class="btn btn-success">Guardar</button>
            <button type="button" class="btn btn-danger" onclick="parent.float_close_modal_hijo();">Cancelar</button>
        </div>
        <div class="clearfix"></div>
    </div>
    
</form>
<script type="text/javascript">
    
  var fncRegistrar_Productos=function(){
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        parent.window_float_open_modal_hijo("AGREGAR DETALLE","Salida/cotizacion_mantenimiento_producto_nuevo",cotizacion_ID,"",fncCargar_Detalle_Cotizacion,700,600);
       
    }  
   
</script>       
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