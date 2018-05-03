<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?> Anulacion de Comprobante<?php } ?>

<?php

function fncHead() { ?>
   
    <script type="text/javascript" src="include/js/jForm.js"></script>


    
<?php } ?>

<?php

function fncTitleHead() { ?>Anulacion de Comprobante<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1" name="frm1" method="POST" style="width:800px;" action="/Ingreso/Anulacion_Comprobante_Mantenimiento_Registro/<?php echo $GLOBALS['oCompra']->ID;?>" onsubmit="return validar();">
    <div class="panel panel-info form-horizontal">
        <div class="panel-body form-body">
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Serie:</label>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input type="text" id="txt_serie" name="txt_serie" disabled value="<?php  echo sprintf("%'.03d",$GLOBALS['oCompra']->serie);?>" class="form-control">
                </div>
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Estado:</label>
                
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input value="factura cancelada" disabled class="form-control">
                </div>
                
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Número:</label>
                   
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                     <input type="hidden" name="txtCompra_ID" id="txtCompra_ID" value="<?php echo $GLOBALS['oCompra']->ID;?>" >
               
                    <input type="text" name="txtNumero" id="txtNumero" disabled value="<?php echo sprintf("%'.09d",$GLOBALS['oCompra']->numero);?>" class="form-control">
                </div>
                 <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Moneda:</label>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input type="text" name="txtMoneda" id="txtMoneda" disabled value="<?php echo $GLOBALS['oCompra']->moneda;?>" class="form-control">
                </div>
                
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Fecha emisión:</label>
                
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input type="text" name="txtFecha_Emision" id="txtFecha_Emision" disabled value="<?php echo $GLOBALS['oCompra']->fecha_emision;?>" class="form-control">
                </div>
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Fecha vencimiento:</label>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input type="text" name="txtFecha_Vencimiento" id="txtFecha_Vencimiento" disabled  value="<?php echo $GLOBALS['oCompra']->fecha_vencimiento;?>"  class="form-control">
                </div>
                
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Sub Total:</label>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input type="text" name="txtSubTotal" id="txtSubTotal" disabled value="<?php echo number_format($GLOBALS['oCompra']->subtotal,2,'.',',');?>" class="form-control">
                </div>
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">I.G.V.</label>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input type="text" name="txtvIGV" id="txtvIGV" disabled value="<?php echo number_format($GLOBALS['oCompra']->igv,2,'.',',');?>" class="form-control">
                </div>
                
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Total:</label>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input type="text" name="txtTotal" id="txtTotal" disabled value="<?php echo number_format($GLOBALS['oCompra']->total,2,'.',',');?>" class="form-control">
                </div>
                <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Saldo pendiente:</label>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <input type="text" name="txtMonto_Pendiente" id="txtMonto_Pendiente" disabled value="<?php echo number_format($GLOBALS['oCompra']->monto_pendiente,2,'.',',');?>" class="form-control">
                </div>
                
            </div>
          <div class="panel panel-info">
                <div class="panel-heading">
                    Anulación
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Fecha:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtFecha_Anulacion" id="txtFecha_Anulacion" class="date-range-picker-single form-control" value="<?php echo $GLOBALS['oCompra']->fecha_anulacion;?>" >
                        </div>
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Motivo:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selMotivo_Anulacion_ID" name="selMotivo_Anulacion_ID" class="form-control">
                                <option value="0">--Seleccione--</option>
                                <?php foreach($GLOBALS['oCompra']->dtMotivo_Anulacion as $ivalue){ ?>
                                <option value="<?php echo $ivalue['ID']?>"><?php echo FormatTextView($ivalue['nombre']);?></option>

                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Autorizado por:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="seloperador_ID_anulacion" name="seloperador_ID_anulacion" class="form-control">
                                <option value="0">--Seleccione--</option>
                                <?php foreach($GLOBALS['oCompra']->dtOperador as $item){ ?>
                                <option value="<?php echo $item['ID']?>"><?php echo FormatTextView($item['apellido_paterno'].' '.$item['apellido_materno'].','.$item['nombres'])?></option>

                                <?php } ?>
                            </select>
                        </div>

                    </div>

                </div>
            </div>
            
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    
                    <button  id="btnEnviar" name="btnEnviar" title="Registrar pago" class="btn btn-success" >
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                       Guardar
                    </button>
                    <button  id="btnSalir" name="btnSalir" type="button" onclick="window_float_close_modal();" title='Salir' class="btn btn-danger" >
                        <span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
  $('#selMotivo_Anulacion_ID').val(<?php echo $GLOBALS['oCompra']->motivo_anulacion_ID?>);
  $('#seloperador_ID_anulacion').val(<?php echo $GLOBALS['oCompra']->operador_ID_anulacion?>);
var validar=function(){
      var motivo_anulacion_ID=$('#selMotivo_Anulacion_ID').val();
      var usuario_anulacion_id=$('#seloperador_ID_anulacion').val();
      var fecha_anulacion=$('#txtFecha_Anulacion').val();
    if(fecha_anulacion==''){

        mensaje.advertencia('VALIDACIÓN DE DATOS','Ingrese una fecha valida.','txtFecha_Anulacion');

        return false;
    }
    if(motivo_anulacion_ID==0){
        mensaje.advertencia('VALIDACIÓN DE DATOS','Seleccione un motivo.','selMotivo_Anulacion_ID');

        return false;
    }
    if(usuario_anulacion_id==0){
        mensaje.advertencia('VALIDACIÓN DE DATOS','Seleccione la persona que autorizó la anulación.','selUsuario_Anulacion_ID');

        return false;
    }
  }
      
</script>  
<?php }?>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
 
    <script type="text/javascript">
//   
        $(document).ready(function () {
            toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
        });
          setTimeout('window_float_save_modal();', 1000);
    </script>
    <?php } ?>
    
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
    <div id="error"></div>
    <script type="text/javascript">
        $('#error').html('<?php echo $GLOBALS['mensaje']; ?>');
        $(document).ready(function () {
            
            mensaje.error('Ocurrió un error','<?php echo $GLOBALS['mensaje']; ?>');
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
