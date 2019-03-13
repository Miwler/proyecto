<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Asignar Correlativos por Defecto<?php } ?>

<?php

function fncHead() { ?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-address-card-o" aria-hidden="true"></i> Asignar Correlativos por Defecto<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
    <form id="form"  method="POST" action="/Mantenimiento/Correlativos_Mantenimiento_Defecto"  class="form-horizontal" >
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-sm-4">Correlativo por defecto para las facturas de ventas electrónicas:<span class="asterisk">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select class="form-control" id="correlativos_ID" name="correlativos_ID">
                        <option value="0">--Ninguno--</option>
                        <?php  foreach($GLOBALS['dtCorrelativosVentaE'] as $valor){?>
                        <option value="<?php echo $valor['ID']?>"><?php echo $valor['comprobante']."-".$valor['serie'] ?></option>
                        <?php }?>
                    </select>
                    <script>
                    $("#correlativos_ID").val(<?php echo $GLOBALS['valores']['correlativos_ID'];?>);
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Correlativo por defecto para las facturas de ventas impresos:<span class="asterisk">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select class="form-control" id="correlativos_ID_fisico" name="correlativos_ID_fisico">
                        <option value="0">--Ninguno--</option>
                        <?php  foreach($GLOBALS['dtCorrelativosVentaF'] as $valor){?>
                        <option value="<?php echo $valor['ID']?>"><?php echo $valor['comprobante']."-".$valor['serie'] ?></option>
                        <?php }?>
                    </select>
                    <script>
                    $("#correlativos_ID_fisico").val(<?php echo $GLOBALS['valores']['correlativos_ID_fisico'];?>);
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Correlativo por defecto para las guías de ventas electrónicos:<span class="asterisk">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select class="form-control" id="correlativos_ID_guia_electronico" name="correlativos_ID_guia_electronico">
                        <option value="0">--Ninguno--</option>
                        <?php  foreach($GLOBALS['dtCorrelativosGuiaE']  as $valor){?>
                        <option value="<?php echo $valor['ID']?>"><?php echo $valor['comprobante']."-".$valor['serie'] ?></option>
                        <?php }?>
                    </select>
                    <script>
                    $("#correlativos_ID_guia_electronico").val(<?php echo $GLOBALS['valores']['correlativos_ID_guia_electronico'];?>);
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Correlativo por defecto para las guías de ventas impresas:<span class="asterisk">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select class="form-control" id="correlativos_ID_guia_fisico" name="correlativos_ID_guia_fisico">
                        <option value="0">--Ninguno--</option>
                        <?php  foreach($GLOBALS['dtCorrelativosGuiaF']  as $valor){?>
                        <option value="<?php echo $valor['ID']?>"><?php echo $valor['comprobante']."-".$valor['serie'] ?></option>
                        <?php }?>
                    </select>
                    <script>
                    $("#correlativos_ID_guia_fisico").val(<?php echo $GLOBALS['valores']['correlativos_ID_guia_fisico'];?>);
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Correlativo por defecto para las notas de créditos electrónico:<span class="asterisk">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select class="form-control" id="correlativos_ID_nota_credito" name="correlativos_ID_nota_credito">
                        <option value="0">--Ninguno--</option>
                        <?php  foreach($GLOBALS['dtCorrelativosNotaCreditoE']  as $valor){?>
                        <option value="<?php echo $valor['ID']?>"><?php echo $valor['comprobante']."-".$valor['serie'] ?></option>
                        <?php }?>
                    </select>
                    <script>
                    $("#correlativos_ID_nota_credito").val(<?php echo $GLOBALS['valores']['correlativos_ID_nota_credito'];?>);
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Correlativo por defecto para las notas de débito electrónico:<span class="asterisk">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select class="form-control" id="correlativos_ID_nota_debito" name="correlativos_ID_nota_debito">
                        <option value="0">--Ninguno--</option>
                        <?php  foreach($GLOBALS['dtCorrelativosNotaDebitoE']  as $valor){?>
                        <option value="<?php echo $valor['ID']?>"><?php echo $valor['comprobante']."-".$valor['serie'] ?></option>
                        <?php }?>
                    </select>
                    <script>
                    $("#correlativos_ID_nota_debito").val(<?php echo $GLOBALS['valores']['correlativos_ID_nota_debito'];?>);
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Tipo comprobante por defecto en las compras:<span class="asterisk">*</span></label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select class="form-control" id="compra_tipo_comprobante_ID" name="compra_tipo_comprobante_ID">
                        <option value="0">--Ninguno--</option>
                        <?php  foreach($GLOBALS['dtTipoComprobanteCompra']  as $valor){?>
                        <option value="<?php echo $valor['tipo_comprobante_ID']?>"><?php echo $valor['comprobante'] ?></option>
                        <?php }?>
                    </select>
                    <script>
                    $("#compra_tipo_comprobante_ID").val(<?php echo $GLOBALS['valores']['compra_tipo_comprobante_ID'];?>);
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
