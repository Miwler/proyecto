<?php		
	require ROOT_PATH . "views/shared/content-float-modal.php";	
?>	
<?php function fncTitle(){?>Registrar Venta<?php } ?>

<?php function fncHead(){?>
	
    <script type="text/javascript" src="include/js/jForm.js"></script>

        
<script>

</script>
<style>
    #tbProductos tbody td,#tbObsequios tbody td{
        font-size:11px;
    }
    .btn-group li a:hover{
        cursor:pointer;
    }
</style>
<?php } ?>

<?php function fncTitleHead(){ ?>Registrar Venta<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['resultado']==2){ ?>
<form id="form" method="POST" action="/Salida/Resumen_Diario_Mantenimiento_Nuevo" onsubmit="return validar();" class="form-horizontal">
    <input type="hidden" id="documentos_IDs" name="documentos_IDs">
    <div class="form-body">
        <div class="form-group">
            <label class="control-label col-sm-3">Fecha emisión:<span class="asterisk">*</span></label>
            <div class="col-sm-3">
                <input id="txtFechaEmision" name="txtFechaEmision" class="date-range-picker-single form-control" value="<?php echo $GLOBALS['oResumen_Diario']->FechaEmision?>">
            </div>
            <label class="control-label col-sm-3">Fecha referencial:<span class="asterisk">*</span></label>
            <div class="col-sm-3">
                <input id="txtFechaReferencia" name="txtFechaReferencia" class="date-range-picker-single form-control"  value="<?php echo $GLOBALS['oResumen_Diario']->FechaReferencia?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Tipo<span class="asterisk">*</span></label>
            <div class="col-sm-3">
                <select id="selTipo" name="selTipo" class="form-control">
                    <?php foreach( $GLOBALS['oResumen_Diario']->dtTipo as $tipo){ ?>
                    <option value="<?php echo $tipo['ID']?>"><?php echo utf8_encode($tipo['nombre'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-6">
                <div class="ckbox ckbox-theme">
                    <input type="checkbox" id="ckGenerar" name="ckGenerar" checked disabled>
                    <label for="ckGenerar">Generar</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="height: 290px;overflow:auto;">
                <table id="table_documentos" class="table table-hover table-bordered table-responsive table-teal">
                    <thead>
                        <tr><th class="text-center">N°</th><th class="text-center">Nro doc.</th><th class="text-center">Fecha</th><th class="text-center">Cliente</th><th class="text-center">Opc.</th></tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button type="submit" class="btn btn-success">
                <img width="14" alt="" src="/include/img/boton/save_48x48.png">Grabar
            </button>
            <button id="btnRegresar1" type="button" class="btn btn-danger" title="Cancelar" onclick="parent.float_close_modal();">
                <span class="glyphicon glyphicon-arrow-left"></span>
                Regresar
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
    

</form>
<script type="text/javascript">
    function validar(){
        var fecha_emision=$("#txtFechaEmision").val();
        var fecha_referencia=$("#txtFechaReferencia").val();
        if(fecha_emision==""){
            mensaje.advertencia("validación de datos","Debe registrar una fecha de emisión","txtFechaEmision");
            return false;
        }
        if(new Date(fecha_referencia).getTime()>new Date(fecha_emision).getTime()){
            mensaje.advertencia("validación de datos","La fecha de referencia debe ser meno o igual a la fecha de emisión","txtFechaReferencia");
            return false;
        }
        var i=0;
        var valor="";
        $("#table_documentos tbody input:checkbox:checked").each(function(){
            if(i==0){
                valor=this.id;
            }else{
                valor=valor+','+this.id;
            }
            i++;
        });
        if(valor==""){
            mensaje.advertencia("validación de datos","Debe seleccionar un documento");
            return false;
        }
        
        $("#documentos_IDs").val(valor);
        $("#ckGenerar").prop("disabled",false);
        block_ui();
    }
    function cargarFilas(){
       
        var object=new Object();
        enviarAjax("Salida/ajaxCargarFilarDocumetos",'form',object,function(resultado){
            var resul = $.parseJSON(resultado);
            if(resul.resultado==1){
                
                $("#table_documentos tbody").html(resul.filas);
            }else{
                mensaje.error("Ocurrió un error",resul.mensaje);
            }
            
        });
    }
    $("#txtFechaReferencia,#selTipo").change(function(){
       
        cargarFilas();
    });
    
    $(document).ready(function(){
        cargarFilas();
    });
</script>
    
<?php }?>
            
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
<div><?php echo $GLOBALS['mensaje']; ?></div>
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
       
         $.unblockUI();
    });

</script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==2){ ?>
<script type="text/javascript">
    $(document).ready(function () {
       toastem.advertencia('<?php echo $GLOBALS['mensaje']; ?>');
       
         $.unblockUI();
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

	     
<?php }?>        