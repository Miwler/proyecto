<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?> Registro de Pagos<?php } ?>

<?php

function fncHead() { ?>
  
    <script type="text/javascript" src="include/js/jForm.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            <?php if($GLOBALS['oCompra']->estado_ID==11){?>
                    bloquear_edicion();
            <?php } ?>
        });
                
    </script>
    

   
<?php } ?>

<?php

function fncTitleHead() { ?>Registro de Pagos<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1||$GLOBALS['resultado'] == 1) { ?>
<form id="frm1" method="POST"  class="form-horizontal">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i><span> Datos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divPagos" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i><span> Pagos realizados</span></a></li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content" >
                <div id="divDatos" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Fecha:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtFecha_Pago" id="txtFecha_Pago" class="date-range-picker-single form-control" value="<?php echo date('d/m/Y');?>">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                            <label>Aporte:</label>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

                            <input type="text" name="txtMonto_Pago" id="txtMonto_Pago" class="input-sm intEnter form-control" data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true" autocomplete="off">
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-right">
                            <label>Total:</label>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                            <div class="ckbox ckbox-theme">
                                <input  type="checkbox" id="checkbox-checked1"  name="ckPago_Total" value="1" >
                                <label for="checkbox-checked1"></label>
                            </div>
                            <!--<input type="checkbox" name="" id="ckPago_Total" value="1" onclick="fncMarcarTotal();">-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Serie:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txt_serie" name="txt_serie" disabled value="<?php  echo sprintf("%'.03d",$GLOBALS['oCompra']->serie);?>" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Estado:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                             <label id="titulo_estado">Factura: <?php echo $GLOBALS['oCompra']->estado;?></label>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Número:</label>
                            <input name="txtCompra_ID" id="txtCompra_ID" value="<?php echo $GLOBALS['oCompra']->ID;?>" style="display:none;">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtNumero" id="txtNumero" disabled value="<?php echo sprintf("%'.09d",$GLOBALS['oCompra']->numero);?>" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Moneda:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtMoneda" id="txtMoneda" disabled value="<?php echo utf8_encode($GLOBALS['oCompra']->moneda);?>" class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Fecha emisión:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtFecha_Emision" id="txtFecha_Emision" disabled value="<?php echo $GLOBALS['oCompra']->fecha_emision;?>" class="form-control date-range-picker-single">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Fecha vencimiento:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtFecha_Vencimiento" id="txtFecha_Vencimiento" disabled  value="<?php echo $GLOBALS['oCompra']->fecha_vencimiento;?>"  class="form-control date-range-picker-single">
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Sub Total:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtSubTotal" id="txtSubTotal" disabled value="<?php echo number_format($GLOBALS['oCompra']->subtotal,2,'.',',');?>" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>I.G.V.</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtvIGV" id="txtvIGV" disabled value="<?php echo number_format($GLOBALS['oCompra']->igv,2,'.',',');?>" class="form-control">
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Total:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtTotal" id="txtTotal" disabled value="<?php echo number_format($GLOBALS['oCompra']->total,2,'.',',');?>" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Saldo pendiente:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="txtMonto_Pendiente" id="txtMonto_Pendiente" disabled value="<?php echo number_format($GLOBALS['oCompra']->monto_pendiente,2,'.',',');?>" class="form-control">
                        </div>

                    </div>
                    
                    
                </div>
                <div id="divPagos" class="tab-pane fade inner-all form-group" style="height: 300px;" >
                    
                </div>
            </div>
           
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    
                    <button  id="btnRegistrar" name="btnRegistrar" type="button" onclick="fncGrabar();" title="Registrar pago" class="btn btn-success" >
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                       Registrar
                    </button>
                    <button  id="btnSalir" name="btnSalir" type="button" onclick=" window_float_save_modal();" title='Salir' class="btn btn-danger" >
                        <span class="glyphicon glyphicon-arrow-left"></span>
                    Salir
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>



<div id="script"></div>
<script type="text/javascript">

   $(document).ready(function(){
       cargarDetalle();
   });
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
    var fncGrabar=function(){
        var fecha=$('#txtFecha_Pago').val();
        var aporte=$('#txtMonto_Pago').val();
        if(fecha==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre una fecha.','txtFecha_Pago');
           return false;
        }
        if(aporte==''||aporte==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese un monto de aporte válido.','txtMonto_Pago');
           return false;
        }
        var monto_pendiente=parseFloat($('#txtMonto_Pendiente').val().replace(',',''));
        
        var monto_reg=parseFloat($('#txtMonto_Pago').val());
        
        if(monto_reg>monto_pendiente){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'El monto no puede mayor al monto pendiente.');
            return false;
        }
        $('#txtMonto_Pago').removeAttr('disabled');
        block_ui(function(){
            enviarFormulario("Ingreso/ajaxGrabarPagos_Mantenimiento_Registro",'frm1',function(res){
                $.unblockUI();
                if(res.resultado==1){
                    toastem.success(res.mensaje);
                    $("#txtMonto_Pago").val("");
                    fncMontoPendiente(res.monto_pendiente);
                    cargarDetalle();
                }else{
                    mensaje.error("OCURRIÓ UN ERROR", res.mensaje);
                }

                if(res.bloquear==1){
                    bloquear_edicion();
                }
            });
        });
        
    }
    var cargarDetalle=function(){
        var compra_ID=$("#txtCompra_ID").val();
        cargarValores('ingreso/ajaxPagos_Mantenimiento_Registro',compra_ID,function(res){
            $("#divPagos").html(res.resultado);
        });
    }
    /*var registrar=function(){
        $('#txtMonto_Pago').removeAttr('disabled');
        var fecha=$('#txtFecha_Pago').val();
        var aporte=$('#txtMonto_Pago').val();
        var error=0;
        if(fecha=='__/__/____'){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre una fecha.','txtFecha_Pago');
           
            error=1;
        }
        if(aporte==''||aporte==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese un monto de aporte válido.','txtMonto_Pago');
           
          error=1;
        }
        var monto_pendiente=parseFloat($('#txtMonto_Pendiente').val().replace(',',''));
        
        var monto_reg=parseFloat($('#txtMonto_Pago').val());
        
        if(monto_reg>monto_pendiente){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'El monto no puede mayor al monto pendiente.');
             error=1;
        }
        if(error==0){
            f.enviar();
            $('#txtMonto_Pago').val('');
        }
        fncDesactivarBtnDetalle();
    }*/
    $("#checkbox-checked1").click(function(){
        if($(this).is(':checked')){
            
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
    });
    
    
    var fncEliminar=function(id){
        block_ui(function(){
            cargarValores('/Ingreso/ajaxMantenimiento_Registro_Eliminar',id,function(resultado){
                $.unblockUI();
            if(resultado.resultado==1){
               cargarDetalle();

                mensaje.info("OK",resultado.mensaje);
                fncMontoPendiente(resultado.monto_pendiente);
               // fncDesactivarBtnDetalle();

            }else {
                mensaje.error("Ocurrió un error",resultado.mensaje);
            }
        });
        });
        
  
    }
    var fncDesactivarBtnDetalle=function(){
        
        $('#detalle_ID').val('');
        $('.btn_detalle').each(function(){
            if($(this).is(":visible")){
                $(this).toggle("fast");
            }  
        });
    }
    $('.intEnter').keypress(function(e){			
            if (e.which==13){
                  registrar();
            }
    });
    var bloquear_edicion=function(){
        $('#txtFecha_Pago').prop('disabled', true);
        $('#txtMonto_Pago').prop('disabled', true);
        $('#checkbox-checked1').prop('disabled', true);
        $('#btnRegistrar').prop('disabled', true);
    }
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
