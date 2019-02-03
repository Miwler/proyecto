<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>FACTURA<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type='text/javascript'>
    $(document).ready(function(){
       <?php if($GLOBALS['oFactura_Venta']->opcion==1){?>
            $('#ckOpcion').prop('checked', true);
       <?php } else { ?>
           $('#ckOpcion').prop('checked', false);
       <?php } ?>
        <?php if($GLOBALS['oFactura_Venta']->estado_ID==41||$GLOBALS['oFactura_Venta']->estado_ID==93||$GLOBALS['oFactura_Venta']->estado_ID==94){?>  
            bloquear_factura();
        <?php } ?>   

    });
    </script>
<?php } ?>

<?php function fncTitleHead(){?>FACTURA<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['resultado']==1){ ?>
<form id="frm1"  method="post"  action="Salida/Orden_Venta_Mantenimiento_Factura/<?php echo $GLOBALS['oOrden_Venta']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos_Generales" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i> <span>Datos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divProductos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Productos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divCosto" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i> <span>Costos</span></a></li>
            </ul>
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height:300px;overflow:auto; ">
            <div class="tab-content">
                <div id="divDatos_Generales" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            
                            <select class="form-control" id="selTipoComprobante" name="selTipoComprobante" onchange="fncSelComprobante(this.value);">
                                <option value="factura_venta">Factura</option>
                                <option value="boleta_venta">Boleta</option>
                            </select>
                            <script type="text/javascript">
                                $("#selTipoComprobante").val("<?php echo $GLOBALS['oFactura_Venta']->comprobante;?>");
                            </script>
                            <input type="hidden" id="txtID" name="txtID" value="<?php echo  $GLOBALS['oFactura_Venta']->ID;?>">
                            <input type="hidden" id="txtorden_ventaID" name="txtorden_ventaID" value="<?php echo  $GLOBALS['oOrden_Venta']->ID;?>">
                            <input type="hidden" id="txtSerie" name="txtSerie" value="<?php echo  $GLOBALS['oFactura_Venta']->serie;?>">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selSerie" name="selSerie" class="form-control" disabled onchange="fncActualizarNumero();" >
                                <?php foreach($GLOBALS['oFactura_Venta']->dtSerie as $value){ ?>
                                <option value="<?php echo $value['ID'];?>"><?php echo $value['serie'];?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                             $('#selSerie').val('<?php echo $GLOBALS['oFactura_Venta']->correlativos_ID;?>');
                             </script>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input type="text" id="txtNumero" name="txtNumero" class="form-control" autocomplete="off" value="<?php echo  $GLOBALS['oFactura_Venta']->numero_concatenado;?>" disabled onchange="fncNumero();">
                            
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                            <?php if($GLOBALS['oFactura_Venta']->estado_ID!=41){?>
                            <button type="button" id="btnActualizar" style="vertical-align: bottom; border: none;" onclick="fncActualizarNumero();"><img src="/include/img/boton/refresh32x32.png" width="22px"/></button>
                           
                            
                            <?php } ?>
                            
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                             <?php if($GLOBALS['oFactura_Venta']->estado_ID!=41){?>
                             <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckOpcion" name="ckOpcion" value="1">
                                <label for="ckOpcion"></label>
                            </div>
                             <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Fecha emisión</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtFecha_Emision" name="txtFecha_Emision" required class="date-range-picker-single form-control" value="<?php echo $GLOBALS['oFactura_Venta']->fecha_emision;?>">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Plazo de facturación</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtPlazo_Factura" name="txtPlazo_Factura" required autocomplete="off" class="form-control int" style="width:50px;" onkeyup="fncVerFecha(this.value,$('#txtFecha_Emision').val());" value="<?php echo $GLOBALS['oFactura_Venta']->plazo_factura;?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Fecha vencimiento:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtFecha_Vencimiento" name="txtFecha_Vencimiento" required class="form-control date-range-picker-single" value="<?php echo $GLOBALS['oFactura_Venta']->fecha_vencimiento;?>">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>N° Orden de compra</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtOrden_Compra" name="txtOrden_Compra" autocomplete="off" class="form-control" value="<?php echo $GLOBALS['oFactura_Venta']->numero_orden_compra; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>N° orden de pedido</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtOrden_Pedido" name="txtOrden_Pedido" autocomplete="off" class="form-control" value="<?php echo $GLOBALS['oFactura_Venta']->numero_orden_venta; ?>" >
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Moneda</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selMoneda" name="selMoneda" disabled class="form-control" >
                                <option value="1">Soles</option>
                                <option value="2">Dolares</option>
                            </select>
                            <script type="text/javascript">
                                $('#selMoneda').val(<?php echo $GLOBALS['oFactura_Venta']->moneda_ID; ?>);
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Estado:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtEstado" name="txtEstado" class="form-control" value="<?php echo $GLOBALS['oFactura_Venta']->estado;?>" disabled>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Tipo impuesto:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select class="form-control" id="selImpuestos_Tipo" name="selImpuestos_Tipo">
                                <?php foreach($GLOBALS['oFactura_Venta']->dtImpuestos_Tipo as $valor){?>
                                <option value="<?php echo $valor['ID'];?>"><?php echo FormatTextView($valor['nombre']);?></option>
                                <?php } ?>
                            </select>
                            <script>
                                $("#selImpuestos_Tipo").val(<?php echo $GLOBALS['oFactura_Venta']->impuestos_tipoID;?>);
                            </script>
                        </div>
                    </div>
                    
                </div>
                <div id="divProductos" class="tab-pane fade inner-all">
                    <div id="divProductos" name="divProductos" class="grid-content-hijo">
                        <?php echo $GLOBALS['listaproducto'];?>
                    </div>
                </div>
                <div id="divCosto" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5">
                                <h4>Datos SUNAT</h4>
                                <div class="row">
                                    <label class="control-label col-sm-4 col-xs-12">%Descuento</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal" id="txtPorcentaje_Descuento" autocomplete="off" name="txtPorcentaje_Descuento" onkeyup="fncCalcularDescuento();" value="<?php echo $GLOBALS['oFactura_Venta']->porcentaje_descuento;?>">
                                    </div>
                                    <label class="control-label col-sm-4 col-xs-12">Anticipo(-)</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal"  disabled id="txtAnticipos" name="txtAnticipos" value="<?php echo $GLOBALS['oFactura_Venta']->anticipos;?>">
                                    </div>
                                    <label class="control-label col-sm-4 col-xs-12">Exonerada</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal"  disabled id="txtExoneradas" name="txtExoneradas" value="<?php echo $GLOBALS['oFactura_Venta']->exoneradas;?>">
                                    </div>
                                    <label class="control-label col-sm-4 col-xs-12">Inafecta</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal"  disabled id="txtInafectas" name="txtInafectas" value="<?php echo $GLOBALS['oFactura_Venta']->inafectas;?>">
                                    </div>
                                    <label class="control-label col-sm-4 col-xs-12">Gravada</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal"  disabled id="txtGrvadas" name="txtGrvadas" value="<?php echo $GLOBALS['oFactura_Venta']->gravadas;?>">
                                    </div>
                                    <label class="control-label col-sm-4 col-xs-12">IGV <?php echo $GLOBALS['oOrden_Venta']->igv*100?> %</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal"  disabled id="txtTotal_IGV" name="txtTotal_IGV" value="<?php echo $GLOBALS['oFactura_Venta']->monto_total_igv;?>">
                                    </div>
                                    <label class="control-label col-sm-4 col-xs-12">Gratuita</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal"  disabled id="txtGratuitas" name="txtGratuitas" value="<?php echo $GLOBALS['oFactura_Venta']->gratuitas;?>">
                                    </div>
                                    <label class="control-label col-sm-4 col-xs-12">Otros Cargos</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal"  id="txtOtros_Cargos" autocomplete="off" name="txtOtros_Cargos" onkeyup="fncSuma_Otros_Cargos();" value="<?php echo $GLOBALS['oFactura_Venta']->otros_cargos;?>">
                                    </div>
                                    <label class="control-label col-sm-4 col-xs-12">Descuento</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal"  disabled autocomplete="off" id="txtDescuento_Global" name="txtDescuento_Global" value="<?php echo $GLOBALS['oFactura_Venta']->descuento_global;?>">
                                    </div>
                                    <label class="control-label col-sm-4 col-xs-12">Total</label>
                                    <div class="col-sm-8 col-xs-12">
                                        <input type="text" class="form-control decimal"  disabled id="txtMonto_Total" name="txtMonto_Total" value="<?php echo $GLOBALS['oFactura_Venta']->monto_total;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                
                            </div>
                        </div>
                        
                        
                    </div>
                    <!--
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label></label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <label>Dólares</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <label>Soles</label>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>Sub Total:</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                             <input type="text" id="txtSubTotal_Dolares" name="txtSubTotal_Dolares" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_neto_dolares;?>">
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtSubTotal_Soles" name="txtSubTotal_Soles" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_neto_soles;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>I.G.V.:</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtIgv_Dolares" name="txtIgv_Dolares" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->vigv_dolares;?>">
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                             <input type="text" id="txtIgv_Soles" name="txtIgv_Soles" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->vigv_soles;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>Total</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtTotal_Dolares" name="txtTotal_Dolares" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_total_dolares;?>">
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtTotal_Soles" name="txtTotal_Soles" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_total_soles;?>">
                        </div>
                    </div>-->
                    <?php if($GLOBALS['electronico']==0){?>
                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="tdfacturas_detalle">
                            <?php echo  $GLOBALS['facturas_informacion'];?>
                        </div>

                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="tdfacturas_detalle">
                    <?php if($GLOBALS['oFactura_Venta']->estado_ID!=41){?>
                    <button  id="btnEnviar" name="btnEnviar" title="Generar factura" class="btn btn-success">
                       <span class="glyphicon glyphicon-ok"></span>
                      Generar
                   </button>
               <?php } ?>
               <?php  if($GLOBALS['oFactura_Venta']->ver_vista_previa==1){?>
                   <button type="button" id="btnVistaprevia" name="btnVistaprevia"  title="Vista previa" class="btn btn-info" onclick="fncVistaPrevia();">
                       <span class="glyphicon glyphicon-eye-open"></span>
                      Vista previa
                   </button>
               <?php } ?>
               <?php  if($GLOBALS['oFactura_Venta']->ver_imprimir==1){?>
                   <button  type="button" id="btnImprimir" name="btnImprimir" title="Vista previa" class="btn btn-warning" onclick="modal.confirmacion('El proceso será irreversible, esta seguro de emitir la factura?','Imprimir factura',fncImprimirFactura);">
                       <span class="glyphicon glyphicon-print"></span>
                      Imprimir
                   </button>
               <?php } ?>
                <?php  if($GLOBALS['oFactura_Venta']->ver_enviar_SUNAT==1){?>
                   <button  type="button" id="btnEnviarFactura" name="btnEnviarFactura" title="Enviar SUNAT" class="btn btn-primary" onclick="modal.confirmacion('El proceso será irreversible, esta seguro de enviar a la SUNAT la factura?','Enviar SUNAT',fncSUNAT,<?php echo $GLOBALS['oFactura_Venta']->ID;?>);">
                       <i class="fa fa-angle-double-right"></i>
                      Enviar SUNAT
                   </button>
               <?php } ?>
                    <button id="btnRegresar" type="button" onclick="parent.float_close_modal_hijo();" class="btn btn-danger">
                           <span class="glyphicon glyphicon-arrow-left"></span>
                           Regresar
                   </button>       
                </div>
            </div>
        </div>
    </div>
</form>
 <script type="text/javascript">
    var fncVistaPrevia=function(){
        var orden_venta_ID=$('#txtorden_ventaID').val();
        //window_float_deslizar_hijo('form','Ventas/Orden_Venta_Mantenimiento_Factura_Vista_Previa',orden_venta_ID,'');
        parent.window_float_open_modal_hijo_hijo("VISTA PREVIA DE FACTURA","Salida/Orden_Venta_Mantenimiento_Factura_Vista_Previa",orden_venta_ID,"",null,700,600);
        
    }
    function fncNumero(){
        var numero=$('#txtNumero').val();
        var nNumero=('0000000'+numero);

        $('#txtNumero').val(nNumero.substring(nNumero.length-9,nNumero.length));
    }
    function fncSUNAT(id) {
        try {
            block_ui(function () {
                cargarValores('Salida/ajaxEnviarSUNAT',id,function(resultado){
                //console.log(resultado);
                $.unblockUI();
                //var obj = $.parseJSON(resultado);
                //console.log(obj.Exito);
                //console.log(obj.MensajeRespuesta);
                if (resultado.resultado == 1) {
                    toastem.success(resultado.mensaje);
                    $("#btnEnviarFactura").remove();
                    $('#txtEstado').val('Enviado a SUNAT');
                    $('#tdfacturas_detalle').html(resultado.facturas_detalle);
                    bloquear_factura();
                    
                    //alert(obj.MensajeRespuesta);
                }else{
                    mensaje.error('OCURRIÓ UN ERROR',resultado.mensaje);
                }
            });
            });
        } catch (e) {
                //$.unblockUI();
                console.log(e);
        } finally {

        }
    }
    /*$('#txtNumero').focus(function(){
        $('#txtNumero').val('');
    });*/
    /*
   var fncVerGuiaVenta=function(valor){
      window.parent.ocultarBotonGuia(valor);
   }*/
    var fncSelComprobante=function(comprobante){
        
        cargarValores('/Salida/ajaxExtraerSeries',comprobante,function(resultado){
            if(resultado.resultado==1){
                $("#selSerie").html(resultado.html);
                fncActualizarNumero();
            }
        });
    }
    var fncActualizarNumero=function(){
       var correlativos_ID=$('#selSerie').val();
        cargarValores('/Salida/ajaxExtraer_Numero_Ultimo',correlativos_ID,function(resultado){
            if(resultado.resultado==1){
                $('#txtNumero').val(resultado.numero); 
                $("#txtSerie").val(resultado.serie);
            }else{
                mensaje.error("OCURRIÓ UN ERROR","Ocurrió un error, comuniquese con el área de sistemas.");
            }
            

        });
    }
   
    var fncImprimirFactura=function(){
        $('#fondo_espera').css('display','block');
        var orden_venta_ID=$('#txtorden_ventaID').val();
        
        cargarValores('Salida/ajaxImprimir_Factura',orden_venta_ID,function(resultado){
            
            if(resultado.resultado==1){
                $('#txtEstado').val('Emitido');
                $('#tdfacturas_detalle').html(resultado.facturas_detalle);
                bloquear_factura();
                /*window.parent.bloquear_edicion();
                window.parent.crear_boton_QuitarPrint();*/
                parent.fParent1.call(this,2);
               //parent.fParent1.call(2);
                //window.parent.crear_boton_guia();
                toastem.success(resultado.mensaje);
                
            }else {
                mensaje.advertencia("ERROR DE IMPRESION",resultado.mensaje);
                //toastem.error(resultado.mensaje);
            }
            $('#fondo_espera').css('display','none');
        });
        
    }
    var bloquear_factura=function(){
        $('#btnActualizar').css('display', 'none');
        $('.ckbox-theme').css('display', 'none');
        $('#txtFecha_Emision').prop('disabled', true);
        $('#txtPlazo_Factura').prop('disabled', true);
        $('#txtFecha_Vencimiento').prop('disabled', true);
        $('#txtOrden_Compra').prop('disabled', true);
        $('#txtOrden_Pedido').prop('disabled', true);
        $('#selMoneda').prop('disabled', true);
        $('#txtEstado').prop('disabled', true);
        $('#btnActualizar').css('display', 'none');
        $('#btnEnviar').prop('disabled', true);
        $('#btnEnviar').css('display', 'none');
        $("#selTipoComprobante").prop('disabled',true);
        $("#selSerie").prop('disabled',true);
        $("#txtNumero").prop('disabled',true);
        $("#selImpuestos_Tipo").prop('disabled',true);
       // $('#btnImprimir').css('display', 'none');
        
    }
   
    var validar=function(){
      
        var fecha_emision=$('#txtFecha_Emision').val();
        var fecha_vencimiento=$('#txtFecha_Vencimiento').val();
        
        if(fecha_emision==""){
            toastem.error('Seleccione la fecha de emisión.');
            $('#txtFecha_Emision').focus();
            return false;
        }
        if(fecha_vencimiento==""){
           mensaje.advertencia('VALIDACIÓN DE DATOS','Seleccione fecha de vencimiento.','txtFecha_Vencimiento');
           
           return false;
        }
        $('#selSerie').prop('disabled',false);
        
        var serie=$.trim($('#selSerie').val());
       
        if(serie==''){
            mensaje.advertencia('VALIDACIÓN DE DATOS','Seleccione una serie.','selSerie');
            return false;
        }
        $('#txtNumero').prop('disabled',false);
         var numero=$.trim($('#txtNumero').val());
         if(numero==''){
            toastem.error('Ingrese un número de factura.');
            $('#txtNumero').focus();
            return false;
         }
         $('#selMoneda').prop('disabled',false);
         $('#txtDescuento_Global').prop('disabled',false);
      block_ui(function () {});
       
         //$('#fondo_espera').css('display', 'block');
   }
    /*var bloqueo_padre=function(){
       window.parent.bloqueo_orden_venta();
    }
    var fncCargarVistaFactura=function(){
        $('#btnImprimirFactura').css('display','none');
        window.parent.fncCargarVistaFactura();
    }
    var fncCargarVistaGuia=function(){

         window.parent.fncCargarVistaGuia();
    }*/
    var ocultarBotones=function(){
        $('#btnImprimirFactura').attr('disabled');
        $('#btnImprimirFactura').css('display','none');
        $('#btnEnviar').attr('disabled');
        $('#btnEnviar').css('display','none');
        $('#Imprimir').css('display','none');
    }
    var fncVerFecha=function(d,fecha){
         var fechaFinal="";
        if(d.trim().length>0){
              var Fecha = new Date();
              var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
              var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
              var aFecha = sFecha.split(sep);
              var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
              fecha= new Date(fecha);
              fecha.setDate(fecha.getDate()+parseInt(d));
              var anno=fecha.getFullYear();
              var mes= fecha.getMonth()+1;
              var dia= fecha.getDate();
              mes = (mes < 10) ? ("0" + mes) : mes;
              dia = (dia < 10) ? ("0" + dia) : dia;
              fechaFinal = dia+sep+mes+sep+anno;
        }

         $('#txtFecha_Vencimiento').val(fechaFinal);
    }
    var fncQuitarGuia=function(){
      var ID=<?php echo $GLOBALS['oOrden_Venta']->ID;?>;
      cargarValores('/Salida/ajaxQuitarGuia',ID,function(resultado){
          $('.float-mensaje').html(resultado.mensaje);
           if(resultado.resultado==1){
               $('#selGuia_Venta').val('0');
           }
       });
    }
    $('#ckOpcion').click(function(){
      if($(this).prop('checked')){
         
          $('#selSerie').prop('disabled', false);
          $('#txtNumero').prop('disabled', false);
      }else {
          $('#selSerie').prop('disabled', true);
          $('#txtNumero').prop('disabled', true);
          $('#txtNumero').focus();
      }
  });
    $('#selSerie').change(function(){
        mostrar_estructura();
    });
    var mostrar_estructura=function(){
        var orden_venta_ID=$('#txtorden_ventaID').val();
        var serie=$('#selSerie').val();

        cargarValores1('Salida/ajaxExtraer_Estructura_Facturas',orden_venta_ID,serie,function(resultado){

            $('#tdfacturas_detalle').html(resultado.html);
        });
    }
        var gravadas=0;
        var exoneradas=0;
        var inafectas=0;
        var igv=0;
        
    $(document).ready(function(){
        
        gravadas=$.trim($('#txtGrvadas').val());
        exoneradas=$.trim($('#txtExoneradas').val());
        inafectas=$.trim($('#txtInafectas').val());
        igv=$.trim($('#txtTotal_IGV').val());
        if(gravadas==''){
            gravadas=0;
        }
        if(exoneradas==''){
            exoneradas=0;
        }
        if(inafectas==''){
            inafectas=0;
        }
        if(igv==''){
            igv=0;
        }
    });
    var fncCalcularDescuento=function(){
        
        var porcentaje_descuento=$.trim($('#txtPorcentaje_Descuento').val());
        if(porcentaje_descuento==''){
            porcentaje_descuento=0;
        }
        var gravadas1=redondear(gravadas*(100-porcentaje_descuento)/100,2);
        var exoneradas1=redondear(exoneradas*(100-porcentaje_descuento)/100,2);
        var inafectas1=redondear(inafectas*(100-porcentaje_descuento)/100,2);
        var igv1=redondear(igv*(100-porcentaje_descuento)/100,2);
        
        var gravadas_descuento=redondear(gravadas*(porcentaje_descuento)/100,2);
        var exoneradas_descuento=redondear(exoneradas*(porcentaje_descuento)/100,2);
        var inafectas_descuento=redondear(inafectas*(porcentaje_descuento)/100,2);
        var igv_descuento=redondear(igv*(porcentaje_descuento)/100,2);
        var descuento_total=gravadas_descuento+exoneradas_descuento+inafectas_descuento+igv_descuento;
        $('#txtGrvadas').val(gravadas1);
        $('#txtExoneradas').val(exoneradas1);
        $('#txtInafectas').val(inafectas1);
        $('#txtTotal_IGV').val(igv1);
        $('#txtDescuento_Global').val(descuento_total);
    }
    var fncSuma_Otros_Cargos=function(){
        var otros_cargos=parseFloat($.trim($("#txtOtros_Cargos").val()));
        if(otros_cargos==''){
            otros_cargos=0;
        }
        var gravadas2=parseFloat($.trim($('#txtGrvadas').val()));
        var exoneradas2=parseFloat($.trim($('#txtExoneradas').val()));
        var inafectas2=parseFloat($.trim($('#txtInafectas').val()));
        var igv2=parseFloat($.trim($('#txtTotal_IGV').val()));
        var nuevo_total=redondear(otros_cargos+gravadas2+exoneradas2+inafectas2+igv2,2);
        $('#txtMonto_Total').val(nuevo_total);
    }
</script>
 
 <?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
         $(document).ready(function () {

            toastem.error('<?php echo $GLOBALS['mensaje'];?>');
        });
           // alert('-1');
      
       // setTimeout('window_float_save();', 1000);
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

<script type="text/javascript">
 //alert('hola');
 $(document).ready(function () {
     $.unblockUI();
     parent.fParent1.call(this,1);
    //window.parent.crear_boton_guia();
    toastem.success('<?php echo $GLOBALS['mensaje'];?>');
    
});

//setTimeout('window_deslizar_save();', 1000);

 
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
<?php } ?>
