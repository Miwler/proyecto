<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?> Registro de anulación<?php } ?>

<?php

function fncHead() { ?>
   
     <script type="text/javascript" src="include/js/jGrid.js"></script>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script>
        $(document).ready(function(){
            <?php if($GLOBALS['oFactura_Venta']->estado_ID==53){?>
                    $('#txtFecha_Anulacion').prop('disabled', true);
                     $('#selMotivo_Anulacion_ID').prop('disabled', true);
                      $('#seloperador_ID_anulacion').prop('disabled', true);
            <?php } ?>
        });
    </script>
<?php } ?>

<?php

function fncTitleHead() { ?>Registro de anulación<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1" method="POST" action="/Ventas/Anulacion_Comprobante_Mantenimiento_Registro/<?php echo $GLOBALS['oFactura_Venta']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    
    <div class="form-body">
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 style="margin-bottom: 0;">Anulación</h2>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Autorizado por:</label>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <select id="seloperador_ID_anulacion" name="seloperador_ID_anulacion" class="form-control">
                    <option value="0">--Seleccione--</option>
                    <?php foreach($GLOBALS['oFactura_Venta']->dtOperador as $item){ ?>
                    <option value="<?php echo $item['ID']?>"><?php echo FormatTextView($item['apellido_paterno'].' '.$item['apellido_materno'].','.$item['nombres'])?></option>

                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Fecha:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtFecha_Anulacion" id="txtFecha_Anulacion" value="<?php echo $GLOBALS['oFactura_Venta']->fecha_anulacion;?>" class="date-range-picker-single form-control">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Motivo:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <select id="selMotivo_Anulacion_ID" name="selMotivo_Anulacion_ID" class="form-control">
                    <option value="0">--Seleccione--</option>
                    <?php foreach($GLOBALS['oFactura_Venta']->dtMotivo_Anulacion as $ivalue){ ?>
                    <option value="<?php echo $ivalue['ID']?>"><?php echo FormatTextView($ivalue['nombre']);?></option>

                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 id="titulo_estado" style="margin-bottom: 0;">Factura: <?php echo $GLOBALS['oFactura_Venta']->estado;?></h2>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Número:</label>
                <input name="txtFactura_Venta_ID" id="txtFactura_Venta_ID" value="<?php echo $GLOBALS['oFactura_Venta']->ID;?>" style="display:none;">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtNumero" id="txtNumero" disabled value="<?php echo $GLOBALS['oFactura_Venta']->numero_concatenado;?>" class="form-control">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Moneda:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtMoneda" id="txtMoneda" disabled value="<?php echo $GLOBALS['oFactura_Venta']->moneda;?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>F. emisión:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtFecha_Emision" id="txtFecha_Emision" disabled value="<?php echo $GLOBALS['oFactura_Venta']->fecha_emision;?>" class="form-control">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>F. Vencimiento:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtFecha_Vencimiento" id="txtFecha_Vencimiento" disabled  value="<?php echo $GLOBALS['oFactura_Venta']->fecha_vencimiento;?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Sub Total:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtSubTotal" id="txtSubTotal" disabled value="<?php echo $GLOBALS['oFactura_Venta']->monto_total_neto;?>" class="form-control">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>IGV:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtvIGV" id="txtvIGV" disabled value="<?php echo $GLOBALS['oFactura_Venta']->monto_total_igv;?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Total:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtTotal" id="txtTotal" disabled value="<?php echo $GLOBALS['oFactura_Venta']->monto_total;?>" class="form-control">
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Pendiente:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtMonto_Pendiente" id="txtMonto_Pendiente" disabled value="<?php echo $GLOBALS['oFactura_Venta']->monto_pendiente;?>" class="form-control">
            </div>
        </div>
        
        
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <?php if($GLOBALS['oFactura_Venta']->estado_ID!=53){?>
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success">
                <span class="glyphicon glyphicon-floppy-disk"></span>
               Guardar
            </button>
            <?php } ?>
            <button  id="btnCancelar" name="btnCancelar" type="button" class="btn btn-danger" onclick="parent.float_close_modal();" >
                <span class="glyphicon glyphicon-off"></span>
                Cancelar
            </button>  
        </div>
        <div class="clearfix"></div>
    </div>
    
</form>
<div id="script"></div>
<script type="text/javascript">
  $('#selMotivo_Anulacion_ID').val(<?php echo $GLOBALS['oFactura_Venta']->motivo_anulacion_ID?>);
  $('#seloperador_ID_anulacion').val(<?php echo $GLOBALS['oFactura_Venta']->usuario_anulacion_id?>);
  var validar=function(){
      var motivo_anulacion_ID=$('#selMotivo_Anulacion_ID').val();
      var usuario_anulacion_id=$('#seloperador_ID_anulacion').val();
      var fecha_anulacion=$('#txtFecha_Anulacion').val();
      if(fecha_anulacion=='__/__/____'){
          toastem.error('Ingrese una fecha valida.');
           
           $('#txtFecha_Anulacion').focus();
            return false;
      }
      if(motivo_anulacion_ID==0){
          toastem.error('Seleccione un motivo');
          
          $('#selMotivo_Anulacion_ID').focus();
          return false;
      }
    if(usuario_anulacion_id==0){
        toastem.error('Seleccione la persona que autorizó la anulación.');
          
          $('#seloperador_ID_anulacion').focus();
          return false;
      }
  }
</script>  
<?php }?>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
 
    <script>
        $(document).ready(function () {
            toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
            
         });
    setTimeout('window_float_save_modal();', 1000);
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
