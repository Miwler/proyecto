<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Nuevo Correlativos<?php } ?>

<?php

function fncHead() { ?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-address-card-o" aria-hidden="true"></i> Nuevo Correlativo<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
    <form id="form"  method="POST" action="/Mantenimiento/Correlativos_Mantenimiento_Nuevo" onsubmit="return validar();" class="form-horizontal" >
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-sm-4">Serie: </label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" id="txtSerie" name="txtSerie" value="<?php echo $GLOBALS['oCorrelativos']->serie;?>" autocomplete="off" class="form-control form-requerido">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Último número: </label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" id="txtUltimo_Numero" name="txtUltimo_Numero" value="<?php echo $GLOBALS['oCorrelativos']->ultimo_numero;?>" autocomplete="off" class="form-control form-requerido">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4"></label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="ckbox ckbox-theme">
                        <input id="ckElectronico" name="ckElectronico" <?php echo (($GLOBALS['oCorrelativos']->electronico==1)?"checked":"")?> type="checkbox">
                        <label for="ckElectronico">Eléctrónico</label>
                    </div>
                </div>
                
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Comprobante:<span class="asterisk">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select id="selTipoComprobante" name="selTipoComprobante" class="form-control">
                        <option value="0">--Seleccione--</option>
                        <?php foreach($GLOBALS['dtTipo_Comprobante'] as $tipo_comprobante){?>
                        <option value="<?php echo $tipo_comprobante['ID']?>"><?php echo utf8_encode($tipo_comprobante['nombre']);?></option>
                        <?php } ?>
                    </select>
                    <script>
                        $("#selTipoComprobante").val(<?php echo $GLOBALS['oCorrelativos']->tipo_comprobante_ID;?>);
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Acción: </label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select id="selAccion" name="selAccion" class="form-control">
                        <option value="0">--Seleccione--</option>
                        <option value="compra">Compra</option>
                        <option value="venta">Venta</option>
                        <option value="guia_remision">Guía de reisión</option>
                        <option value="nota_credito">Nota de crédito</option>
                        <option value="nota_debito">Nota de débito</option>
                    </select>
                    <script>
                        $("#selAccion").val('<?php echo $GLOBALS['oCorrelativos']->accion;?>');
                    </script>
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="pull-left">
                <button  id="btnEnviar" name="btnEnviar" title="Guardar"  class="btn btn-success" >
                <img alt="" src="/include/img/boton/save_14x14.png">
                Guardar
                </button>&nbsp;&nbsp;
                <button  type="button" id="btnCancelar" name="btnCancelar" title="Cancelar"  class="btn btn-danger" onclick="window_float_close_modal();" >
                    <img  alt="" src="/include/img/boton/cancel_14x14.png" >
                    Cancelar
                </button>  
            </div>
            <div class="clearfix"></div>
        </div>
    </form>
<?php } ?>
<script type="text/javascript">
    var validar=function(){
        var serie=$.trim($('#txtSerie').val());
        var ultimo_numero=$.trim($('#txtUltimo_Numero').val());
        var tipo_comprobante_ID=$("#selTipoComprobante").val();
        var accion=$("#selAccion").val();
        if(serie==""){
            mensaje.error("Mensaje de error","Debe registrar una serie.",'txtSerie');
            return false;
        }
        if(ultimo_numero==""||ultimo_numero=="0"){
            mensaje.error("Mensaje de error","Debe registrar el último número.",'txtUltimo_Numero');
            return false;
        
        }
        if(tipo_comprobante_ID=="0"){
            mensaje.error("Mensaje de error","Debe registrar un tipo de comprobante.",'selTipoComprobante');
            return false;
        
        }
        if(accion=="0"){
            mensaje.error("Mensaje de error","Debe registrar una acción.",'selAccion');
            return false;
        
        }
    }
    
</script>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            toastem.success("<?php echo $GLOBALS['mensaje']; ?>");
            setTimeout('window_float_save_modal();', 1000);
        });       
       
       
    </script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
    
    <script type="text/javascript">
        $(document).ready(function(){
            toastem.error("<?php echo $GLOBALS['mensaje']; ?>");
        });       
       
       
    </script>
<?php } ?>
    
        <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -2) { ?>
    <script type="text/javascript">
        $(document).ready(function () {
            toastem.error('<?php  echo $GLOBALS['mensaje'];?>');
            setTimeout('window_float_save_modal();', 1000);

        });

    </script>
    <?php } ?>
    
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 0) { ?>
    <div class="float-mensaje">
        <?php echo $GLOBALS['mensaje']; ?>
    </div>
    <div class="group-btn">
        <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
    </div>
<?php } ?>
<?php } ?>
