<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>FACTURA<?php } ?>

<?php function fncHead(){?>
     <script type="text/javascript" src="include/js/jForm.js"></script>
   
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js"></script>
    <script src="../../include/js/jPdf.js" type="text/javascript"></script>

    <style>
        #table_detalle p{
            font-size:0.8em;
            text-align:justify;
        }
        #table_detalle td{
             font-size:0.8em;
        }
    </style>
<?php } ?>

<?php function fncTitleHead(){?>FACTURA<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1"  method="post"  action="Salida/Orden_Venta_Electronico_Mantenimiento_Comprobante_Nuevo/<?php echo $GLOBALS['oOrden_Venta']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <input type="hidden" id="txtSalida_ID" name="txtSalida_ID" value="<?php echo $GLOBALS['oOrden_Venta']->ID;?>">
    <input type="hidden" id="txtID" name="txtID" value="<?php echo  $GLOBALS['oFactura_Venta']->ID;?>">
    <input type="hidden" id="txtorden_ventaID" name="txtorden_ventaID" value="<?php echo  $GLOBALS['oOrden_Venta']->ID;?>">
    <input type="hidden" id="txtSerie" name="txtSerie" value="<?php echo  $GLOBALS['oFactura_Venta']->serie;?>">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos_Generales" class="nav-link"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Cabecera</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divProductos" class="nav-link"><i class="fa fa-table" aria-hidden="true"></i> <span>Detalle</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divCosto" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i> <span>Costos SUNAT</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divVista" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Vista previa</span></a></li>
            </ul>
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height:340px;overflow:auto; ">
            <div class="tab-content">
                <div id="divDatos_Generales" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            
                            <select class="form-control" id="selTipoComprobante" name="selTipoComprobante" onchange="fncSelComprobante(this.value);">
                               <?php echo $GLOBALS['oFactura_Venta']->dtTipo_Comprobante?>
                            </select>
                           
                            
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selSerie" name="selSerie" class="form-control" disabled onchange="fncActualizarNumero();" >
                                <?php echo $GLOBALS['oFactura_Venta']->dtSerie; ?>
                            </select>
                            
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input type="text" id="txtNumero" name="txtNumero" class="form-control" autocomplete="off" value="<?php echo  $GLOBALS['oFactura_Venta']->numero;?>" disabled >
                            
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                           <button type="button" id="btnActualizar" style="vertical-align: bottom; border: none;" onclick="fncActualizarNumero();"><img src="/include/img/boton/refresh32x32.png" width="22px"/></button>
                           
                            
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Fecha emisión:<span class="asterisk">*</span></label>
                       
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtFecha_Emision" name="txtFecha_Emision" required autocomplete="off" class="date-range-picker-single form-control" value="<?php echo $GLOBALS['oFactura_Venta']->fecha_emision;?>">
                        </div>
                        <label class="control-label col-sm-3">Plazo de facturación:</label>
                       
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtPlazo_Factura" name="txtPlazo_Factura" required autocomplete="off" class="form-control int" style="width:50px;" autocomplete="off" onkeyup="fncVerFecha(this.value,$('#txtFecha_Emision').val());" value="<?php echo $GLOBALS['oFactura_Venta']->plazo_factura;?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Fecha vencimiento:</label>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtFecha_Vencimiento" name="txtFecha_Vencimiento" required class="form-control date-range-picker-single" autocomplete="off" value="<?php echo $GLOBALS['oFactura_Venta']->fecha_vencimiento;?>">
                        </div>
                        <label class="control-label col-sm-3">N° Orden de Venta:</label>
                       
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtNumero_Orden_Venta" name="txtNumero_Orden_Venta" autocomplete="off" disabled class="form-control" value="<?php echo $GLOBALS['oFactura_Venta']->numero_orden_venta; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">N° order de compra:</label>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtNumero_Orden_Compra" name="txtNumero_Orden_Compra" autocomplete="off" disabled class="form-control" value="<?php echo $GLOBALS['oFactura_Venta']->numero_orden_compra; ?>" >
                        </div>
                        <label  class="control-label col-sm-3">Moneda:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selMoneda" name="selMoneda" disabled class="form-control" >
                                <?php foreach($GLOBALS['oFactura_Venta']->dtMoneda as $moneda){?>
                                <option value="<?php echo $moneda['ID']?>"><?php echo utf8_encode($moneda['descripcion'])?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                                $('#selMoneda').val(<?php echo $GLOBALS['oFactura_Venta']->moneda_ID; ?>);
                            </script>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="ckbox ckbox-theme" style="display:none">
                                <input type="checkbox" id="ckGenerar" name="ckGenerar" checked value="93" <?php  echo(($GLOBALS['oFactura_Venta']->estado_ID==93||$GLOBALS['oFactura_Venta']->estado_ID==94||$GLOBALS['oFactura_Venta']->estado_ID==95||$GLOBALS['oFactura_Venta']->estado_ID==96)?" checked ":"")?>>
                                <label for="ckGenerar">Generar factura electrónica</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 ">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckCon_Guia" name="ckCon_Guia" checked value="1" <?php  echo(($GLOBALS['oFactura_Venta']->con_guia==1)?" checked ":"")?>>
                                <label for="ckCon_Guia">Con guía?</label>
                            </div>
                        </div>
                       
                    </div>
                    <div class="form-group">
                        
                        <label class="control-label col-sm-3">Observación:</label>
                        <div class="col-sm-9">
                            <textarea id="txtObservacion" name="txtObservacion" class="form-control" style="height: 80px;overflow:auto;resize:none;"><?php echo $GLOBALS['oFactura_Venta']->observacion;?></textarea>
                        </div>
                    </div>
                    
                </div>
                <div id="divProductos" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckver_descripcion" name="ckver_descripcion" value="1" <?php  echo(($GLOBALS['oFactura_Venta']->ver_descripcion==1)?" checked ":"")?> onclick="cargar_detalle_factura();">
                                <label for="ckver_descripcion">Ver descripción</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckver_componente" name="ckver_componente" value="1" <?php  echo(($GLOBALS['oFactura_Venta']->ver_componente==1)?" checked ":"")?> onclick="cargar_detalle_factura();">
                                <label for="ckver_componente">Ver componentes</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckver_adicional" name="ckver_descripcion" value="1" <?php  echo(($GLOBALS['oFactura_Venta']->ver_adicional==1)?" checked ":"")?> onclick="cargar_detalle_factura();">
                                <label for="ckver_adicional">Ver adicionales</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckver_serie" name="ckver_serie" value="1" <?php  echo(($GLOBALS['oFactura_Venta']->ver_serie==1)?" checked ":"")?> onclick="cargar_detalle_factura();">
                                <label for="ckver_serie">Ver serie</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckincluir_obsequios" name="ckincluir_obsequios" checked value="1" <?php  echo(($GLOBALS['oFactura_Venta']->incluir_obsequios==1)?" checked ":"")?>  onclick="cargar_detalle_factura();">
                                <label for="ckincluir_obsequios">Obsequios</label>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-teals">
                        <strong>Importante!</strong> La longitud máxima del nombre, descripción,componente,adicional y series deben sumar como máximo 250.
                    </div>
                    <table id="table_detalle" class="table table-hover table-bordered table-teal">
                        <thead>
                            <tr><th class="text-center">N°</th><th class="text-center">CANT.</th><th class="text-center">UM</th><th class="text-center">COD</th><th class="text-center">DESCRIPCIÓN</th><th class="text-center">P/U</th><th class="text-center">IMPORTE</th></tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!--<div id="divProductos" name="divProductos" class="grid-content-hijo">
                        
                       
                    </div>-->
                </div>
                <div id="divCosto" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Anticipo(-)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal"  disabled id="txtAnticipos" name="txtAnticipos" value="<?php echo $GLOBALS['oFactura_Venta']->anticipos;?>">
                        </div>
                        <label class="control-label col-sm-2">Descuento(%)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal" id="txtPorcentaje_Descuento" autocomplete="off" name="txtPorcentaje_Descuento" disabled onkeyup="fncCalcularDescuento();" value="<?php echo $GLOBALS['oFactura_Venta']->porcentaje_descuento;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Exonerada</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal"  disabled id="txtExoneradas" name="txtExoneradas" value="<?php echo $GLOBALS['oFactura_Venta']->exoneradas;?>">
                        </div>
                        <label class="control-label col-sm-2">Gravada</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal"  disabled id="txtGravadas" name="txtGravadas" value="<?php echo $GLOBALS['oFactura_Venta']->gravadas;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Descuentos por items</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal"  disabled id="txtDescuento_Total_Items" name="txtDescuento_Total_Items" value="<?php echo $GLOBALS['oFactura_Venta']->descuento_total_items ;?>">
                        </div>
                        <label class="control-label col-sm-2">Descuento Global</label>
                        <div class="col-sm-4">
                           <input type="text" class="form-control decimal"  disabled autocomplete="off" id="txtDescuento_Global" name="txtDescuento_Global" value="<?php echo $GLOBALS['oFactura_Venta']->descuento_global;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Inafecta</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal"  disabled id="txtInafectas" name="txtInafectas" value="<?php echo $GLOBALS['oFactura_Venta']->inafectas;?>">
                        </div>
                        <label class="control-label col-sm-2">IGV <?php echo $GLOBALS['oOrden_Venta']->igv*100?> %</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal"  disabled id="txtTotal_IGV" name="txtTotal_IGV" value="<?php echo $GLOBALS['oFactura_Venta']->monto_total_igv;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Gratuita</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal"  disabled id="txtGratuitas" name="txtGratuitas" value="<?php echo $GLOBALS['oFactura_Venta']->gratuitas;?>">
                        </div>
                        <label class="control-label col-sm-2">Otros Cargos</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal"  id="txtOtros_Cargos" autocomplete="off" name="txtOtros_Cargos" disabled onkeyup="fncSuma_Otros_Cargos();" value="<?php echo $GLOBALS['oFactura_Venta']->otros_cargos;?>">
                        </div>
                    </div>
                    <div class="form-group">
                       
                        <div class="col-sm-6">
                            
                        </div>
                        <label class="control-label col-sm-2">Total</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control decimal"  disabled id="txtMonto_Total" name="txtMonto_Total" value="<?php echo $GLOBALS['oFactura_Venta']->monto_total;?>">
                        </div>
                    </div>
                   

                </div>
                <div id="divVista" class="tab-pane fade inner-all">
                    <div class="embed-responsive embed-responsive-16by9" style="height: 100%;">
                        <iframe id="pdf" class="embed-responsive-item" ></iframe>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="tdfacturas_detalle">
                <?php if($GLOBALS['oFactura_Venta']->estado_ID!=41){?>
                    <button  id="btnEnviar" name="btnEnviar" title="Generar factura" class="grabar">
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
                   <button  type="button" id="btnImprimir" name="btnImprimir" title="Imprimir" class="btn btn-warning" onclick="modal.confirmacion('El proceso será irreversible, esta seguro de emitir la factura?','Imprimir factura',fncImprimirFactura);">
                       <span class="glyphicon glyphicon-print"></span>
                      Imprimir
                   </button>
               <?php } ?>
                    <button  type="button" id="btnEnviarFactura" name="btnEnviarFactura" title="Enviar SUNAT" style="display: none;" class="btn btn-primary" onclick="modal.confirmacion('El proceso será irreversible, esta seguro de enviar a la SUNAT la factura?','Enviar SUNAT',fncEnviarSUNAT,<?php echo $GLOBALS['oFactura_Venta']->ID;?>);">
                       <i class="fa fa-angle-double-right"></i>
                      Enviar SUNAT
                   </button>
                
                    <button id="btnRegresar" type="button" onclick="parent.float_close_modal_hijo();" class="cancelar">
                        <i class="fa fa-circle-o-notch"></i>
                        Cancelar
                   </button> 
                    
                </div>
            </div>
        </div>
    </div>
</form>
 <script type="text/javascript">
     $('.nav-tabs a').on('show.bs.tab', function(event){
        var x = $.trim($(event.target).text());   
       
        switch(x){
            case "Vista previa":
                vista_previa();
                break;
           
        }
         
        
     });
     var validar=function(){
      
        var fecha_emision=$('#txtFecha_Emision').val();
        var fecha_vencimiento=$('#txtFecha_Vencimiento').val();
        var numero=$.trim($('#txtNumero').val());
        var serie=$.trim($('#selSerie').val());
        var plazo_facturacion=$("#txtPlazo_Factura").val();
        if(fecha_emision==""){
            mensaje.error('VALIDACIÓN DE DATOS','Seleccione la fecha de emisión.','txtFecha_Emision');

            return false;
        }
        if(fecha_vencimiento==""){
       
           mensaje.advertencia('VALIDACIÓN DE DATOS','Seleccione fecha de vencimiento.','txtFecha_Vencimiento');
           
           return false;
        }
        $('#selSerie').prop('disabled',false);
        
       
       
        if(serie==''){
            mensaje.advertencia('VALIDACIÓN DE DATOS','Seleccione una serie.','selSerie');
            return false;
        }
       
         
        if(numero==''){
            mensaje.advertencia('VALIDACIÓN DE DATOS','Falta registrar el número de la factura.','txtNumero');

           return false;
        }
        if(plazo_facturacion<0){
            mensaje.advertencia('VALIDACIÓN DE DATOS','Registre un plazo de facturación correcto.','txtPlazo_Factura');
        }
        $('#txtNumero_Orden_Venta').prop('disabled',false);
        $('#txtNumero_Orden_Compra').prop('disabled',false);
        $('#selMoneda').prop('disabled',false);
        $('#txtAnticipos').prop('disabled',false);
        $('#txtExoneradas').prop('disabled',false);
        $('#txtInafectas').prop('disabled',false);
        $('#txtGratuitas').prop('disabled',false);
        $('#txtDescuento_Global').prop('disabled',false);
        $('#txtGravadas').prop('disabled',false);
        $('#txtTotal_IGV').prop('disabled',false);
        $('#txtMonto_Total').prop('disabled',false);
        $('#selImpuestos_Tipo ').prop('disabled',false);
        $('#txtPorcentaje_Descuento ').prop('disabled',false);
        $('#txtOtros_Cargos ').prop('disabled',false);
        $('#txtDescuento_Total_Items ').prop('disabled',false);
        block_ui();
       
         //$('#fondo_espera').css('display', 'block');
   }
     function vista_previa(){
         var object=new Object();
         object['serie']=$.trim($("#selSerie").text());
         $("#pdf").prop("src","");
         block_ui(function(){
             enviarAjaxParse("Salida/ajaxVistaPrevia_Comprobante_Electronico",'frm1',object,function(resultado){
                 
                $("#pdf").prop("src",resultado.ruta);
                $.unblockUI();
            });
         });
         
         //pdf.mostrar('Salida/Factura_Vista_Electronico/100');  
     }
     function cargar_detalle_factura(){
         
         //var salida_ID=$("#txtSalida_ID").val();
         var ver_descripcion=($("#ckver_descripcion").is(":checked"))? 1:0;
         var ver_componente=($("#ckver_componente").is(":checked"))? 1:0;
         var ver_adicional=($("#ckver_adicional").is(":checked"))? 1:0;
         var ver_serie=($("#ckver_serie").is(":checked"))? 1:0;
         var incluir_obsequios=($("#ckincluir_obsequios").is(":checked"))? 1:0;
         var object=new Object();
         object['ver_descripcion']=ver_descripcion;
         object['ver_componente']=ver_componente;
         object['ver_adicional']=ver_adicional;
         object['ver_serie']=ver_serie;
         object['incluir_obsequios']=incluir_obsequios;
         block_ui(function(){
             enviarAjaxParse("salida/ajaxCargarDetalle_Comprobante",'frm1',object,function(resultado){
             
             $("#table_detalle tbody").html(resultado.html);
             $.unblockUI();
            });
         });
     }
    var fncSelComprobante=function(comprobante){
        
        cargarValores1('/Salida/ajaxExtraerSeries',comprobante,1,function(resultado){
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
    var gravadas=0;
    var exoneradas=0;
    var inafectas=0;
    var igv=0;
    $(document).ready(function(){
        cargar_detalle_factura();
        //gravadas=$.trim($('#txtGravadas').val());
        exoneradas=parseFloat($.trim($('#txtExoneradas').val()));
        inafectas=parseFloat($.trim($('#txtInafectas').val()));
        igv=parseFloat($.trim($('#txtTotal_IGV').val()));
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
        
        if(porcentaje_descuento>100){
            toastem.error("Error","El porcentaje no puede ser mayor a 100%");
            $('#txtPorcentaje_Descuento').val('');
            $("#txtDescuento_Global").val('0');
            $("#txtPorcentaje_Descuento").focus();
            
        }
        if(porcentaje_descuento==''){
            porcentaje_descuento=0;
        }
        var gravadas=parseFloat($.trim($('#txtGravadas').val()));
        var descuento_global=redondear(gravadas*(porcentaje_descuento)/100,2);
        
        var exoneradas1=redondear(exoneradas*(100-porcentaje_descuento)/100,2);
        var inafectas1=redondear(inafectas*(100-porcentaje_descuento)/100,2);
        var igv1=redondear(igv*(100-porcentaje_descuento)/100,2);
        
        var gravadas_descuento=redondear(gravadas*(porcentaje_descuento)/100,2);
        var exoneradas_descuento=redondear(exoneradas*(porcentaje_descuento)/100,2);
        var inafectas_descuento=redondear(inafectas*(porcentaje_descuento)/100,2);
        var igv_descuento=redondear(igv*(porcentaje_descuento)/100,2);
        var descuento_total=gravadas_descuento+exoneradas_descuento+inafectas_descuento+igv_descuento;
        //$('#txtGravadas').val(gravadas1);
        $('#txtExoneradas').val(exoneradas1);
        $('#txtInafectas').val(inafectas1);
        $('#txtTotal_IGV').val(igv1);
        $('#txtDescuento_Global').val(descuento_global);
        //var total=gravadas-descuento_global+igv1+
        fncSuma_Otros_Cargos();
         
    }
    var fncSuma_Otros_Cargos=function(){
        var otros_cargos=parseFloat($.trim($("#txtOtros_Cargos").val()));
        if(otros_cargos==''){
            otros_cargos=0;
        }
        //var gravadas2=parseFloat($.trim($('#txtGravadas').val()));
        var exoneradas2=parseFloat($.trim($('#txtExoneradas').val()));
        var inafectas2=parseFloat($.trim($('#txtInafectas').val()));
        var igv2=parseFloat($.trim($('#txtTotal_IGV').val()));
        var gravadas1=parseFloat($.trim($('#txtGravadas').val()));
        var descuento_global=parseFloat($.trim($("#txtDescuento_Global").val()));
        
        var nuevo_total=redondear(otros_cargos+gravadas1+exoneradas2+inafectas2+igv2-descuento_global,2);
        $('#txtMonto_Total').val(nuevo_total);
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
     toastem.success('<?php echo $GLOBALS['mensaje'];?>');
     setTimeout(function(){
         parent.fParent1.call(this,<?php echo $GLOBALS['oFactura_Venta']->ID;?>,<?php echo $GLOBALS['oFactura_Venta']->con_guia;?>);
         parent.float_close_modal_hijo();
     }, 1000);
   
});

//setTimeout('window_deslizar_save();', 1000);

 
</script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-2){ ?>

<script type="text/javascript">
 //alert('hola');
 $(document).ready(function () {
     $.unblockUI();
     //parent.fParent1.call(this,1);
    //window.parent.crear_boton_guia();
    toastem.advertencia('<?php echo $GLOBALS['mensaje'];?>');
    setTimeout(function(){
         parent.float_close_modal_hijo();
    }, 2000);
    
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
<?php } ?>
