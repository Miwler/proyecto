<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?> Registro de cobranzas<?php } ?>

<?php

function fncHead() { ?>
   

    <script type="text/javascript" src="include/js/jGrid.js"></script>
    <script type="text/javascript" src="include/js/jForm.js"></script>
   
    <script type="text/javascript">
         $(document).ready(function(){
            <?php if($GLOBALS['oFactura_Venta']->estado_ID==60){?>
                    bloquear_edicion();
            <?php } ?>
        });
    </script>
<?php } ?>

<?php

function fncTitleHead() { ?>Registro de cobranzas<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>

<form id="frm1" method="POST"  action="/Ventas/Cobranza_Mantenimiento_Registro" onsubmit="return validar();" class="form-horizontal">
    <div class="form-body">
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
                <label>Saldo pendiente:</label>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtMonto_Pendiente" id="txtMonto_Pendiente" disabled value="<?php echo $GLOBALS['oFactura_Venta']->monto_pendiente;?>" class="form-control">
            </div>
        </div>
        <h2>Pagos</h2>
        <div class="form-group">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                Fecha
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
               <input type="text" name="txtFecha_Pago" id="txtFecha_Pago" class="date-range-picker-single form-control" value="<?php echo date('d/m/Y');?>" >
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                Aporte
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" name="txtMonto_Pago" id="txtMonto_Pago" class="decimal form-control" >
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <div class="ckbox ckbox-theme">
                    <input  type="checkbox" id="ckPago_Total"  name="ckPago_Total" value="1" onclick="fncMarcarTotal();">
                    <label for="ckPago_Total">Total</label>
                </div>
                
            </div>
                        
        </div>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="divRegistro_Cobranzas"  style="overflow:auto;height: 200px;">

            </div>
        </div>
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button  id="btnRegistrar" name="btnRegistrar" class="btn btn-success mr-5" type="button" onclick="registrar();" >
                <span class="glyphicon glyphicon-usd"></span>
               Registrar
            </button>
            <button  id="btnSalir" name="btnSalir" title="Salir"  class="btn btn-danger" type="button" onclick="window_float_save_modal();" >
                <span class="glyphicon glyphicon-off"></span>
            Salir
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
    
    
</form>

<script type="text/javascript">
    var f=new form('frm1','divRegistro_Cobranzas');
    f.terminado = function () {
        var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];
        grids = new grid(tb);
        grids.nuevoEvento();
        grids.fncPaginacion(f);			
    }
    f.enviar();    
    var fncMontoPendiente=function(monto_pendiente){
        $('#txtMonto_Pendiente').val(monto_pendiente);
        monto_pendiente=parseFloat(monto_pendiente.replace(',',''));
        if(monto_pendiente==0){
            $('#titulo_estado').html('Estado: Cancelado');
            $('#txtFecha_Pago').prop('disabled',true);
            $('#txtMonto_Pago').prop('disabled',true);
            $('#ckPago_Total').prop('disabled', true);
            $('#btnRegistrar').css('display','none');
             $('#ckPago_Total').prop('checked', false);
        }else {
             $('#titulo_estado').html('Estado: Pendiente');
            $('#txtFecha_Pago').prop('disabled',false);
            $('#txtMonto_Pago').prop('disabled',false);
            $('#ckPago_Total').prop('disabled', false);
            $('#btnRegistrar').css('display','');
            $('#btnRegistrar').prop('disabled', false);
            $('#ckPago_Total').prop('checked', false);    
        }   
    }
    var registrar=function(){
        $('#txtMonto_Pago').removeAttr('disabled');
        var fecha=$('#txtFecha_Pago').val();
        var aporte=$('#txtMonto_Pago').val();
        var error=0;
        if(fecha=='__/__/____'){
            toastem.error('Registre una fecha');
            $('#txtFecha_Pago').focus();
            error=1;
        }
        if(aporte==''||aporte==0){
            toastem.error('Ingrese un monto de aporte válido');
            $('#txtMonto_Pago').focus();
          error=1;
        }
        var monto_pendiente=parseFloat($('#txtMonto_Pendiente').val().replace(',',''));
        
        var monto_reg=parseFloat($('#txtMonto_Pago').val());
        
        if(monto_reg>monto_pendiente){
            toastem.error('El monto no puede mayor al monto pendiente.');
             error=1;
        }
        if(error==0){
            f.enviar();
            $('#txtMonto_Pago').val('');
        }
    }
    var fncMarcarTotal=function(){
        if($('#ckPago_Total').is(':checked')){    
            $('#txtMonto_Pendiente').removeAttr('disabled');
            var monto=$('#txtMonto_Pendiente').val();
            $('#txtMonto_Pago').val(monto);
            $('#txtMonto_Pago').prop('disabled',true);
            $('#txtMonto_Pendiente').attr('disabled',true);
        }else {
            $('#txtMonto_Pago').val('');
            $('#txtMonto_Pago').focus();
            $('#txtMonto_Pago').prop('disabled',false);
        }
       
    }
    var bloquear_edicion=function(){
        $('#txtFecha_Pago').prop('disabled', true);
        $('#txtMonto_Pago').prop('disabled', true);
        $('#ckPago_Total').prop('disabled', true);
        $('#btnRegistrar').prop('disabled', true);
    }
</script>  

    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 0) { ?>
    <div class="float-mensaje">
    <?php echo $GLOBALS['mensaje']; ?>
    </div>
    <div class="group-btn">
        <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
    </div>
    <?php } ?>
<?php } ?>
