<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>GUIA DE VENTA<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>

   
    <script type='text/javascript'>
    $(document).ready(function(){
       <?php if($GLOBALS['oGuia_Venta']->opcion==1){?>
            $('#ckOpcion').prop('checked', true);
       <?php } else { ?>
           $('#ckOpcion').prop('checked', false);
       <?php } ?>
        <?php if($GLOBALS['oGuia_Venta']->estado_ID==38){?>  
           $('#btnAnular').css('display','');
            bloquear_guia();
        <?php }elseif($GLOBALS['oGuia_Venta']->estado_ID==39){?>  
            desbloquear_guia();
            $('#btnAnular').css('display','none');
            $('#btnVistaprevia').css('display','none');
            $('#btnImprimir').css('display','none');
        <?php } else { ?>
            $('#btnAnular').css('display','none'); 
        <?php } ?> 
        
    });
    </script>
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

<?php function fncTitleHead(){?>GUÍA DE VENTA<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1" method="post" role="form" action="Salida/Orden_Venta_Electronico_Mantenimiento_Guia_Nuevo/<?php echo $GLOBALS['oOrden_Venta']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <input type="hidden" id="txtSalida_ID" name="txtSalida_ID" value="<?php echo $GLOBALS['oOrden_Venta']->ID;?>">            
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos_Generales" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Datos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divProductos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Productos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divInfoTraslado" class="nav-link"><i class="fa fa-globe" aria-hidden="true"></i> <span>Inf. Traslado</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divTransportista" class="nav-link"><i class="fa fa-bus" aria-hidden="true"></i> <span>Transportista</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divVista" class="nav-link"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span>Vista previa</span></a></li>
            </ul>
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height:340px;overflow:auto; ">
           
            <div class="tab-content">
                <div id="divDatos_Generales" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Tipo documento:<span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control" id="selTipoDocumento" name="selTipoDocumento">
                                <option value="1">Eléctronico</option>
                                <option value="0">Físico</option>
                            </select>
                            <script type="text/javascript"> 
                                $("#selTipoDocumento").val("<?php echo $GLOBALS['oGuia_Venta']->tipo_documento?>")
                            </script>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">N° Guía:<span class="asterisk">*</span></label>
                            
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selSerie" name="selSerie"  disabled class="form-control" onchange="fncActualizarNumero();">
                                <?php echo $GLOBALS['oGuia_Venta']->dtSerie;?>
                               
                            </select>
                            
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <input type="text" id="txtNumero" name="txtNumero" disabled class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->numero_concatenado;?>">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <button type="button" id="btnActualizar" style="vertical-align: bottom; border: none;" onclick="fncActualizarNumero();"><img src="/include/img/boton/refresh32x32.png" width="22px"/></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Fecha emisión:<span class="asterisk">*</span></label>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtFecha_Emision" name="txtFecha_Emision" class="date-range-picker-single form-control" value="<?php echo $GLOBALS['oGuia_Venta']->fecha_emision;?>">
                        </div>
                       <label class="control-label col-sm-3">Peso bruto total(KG):</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtPeso_Bruto_Total" name="txtPeso_Bruto_Total"  class="decimal form-control" autocomplete="off" value="<?php echo $GLOBALS['oGuia_Venta']->peso_bruto_total;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">N° orden de compra:</label>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtNumero_Orden_Compra" name="txtNumero_Orden_Compra" disabled autocomplete="off"  class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->numero_orden_compra; ?>" >
                        </div>
                         <label class="control-label col-lg-3 col-md-3 col-sm-3">N° orden de venta:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtNumero_Orden_Venta" name="txtNumero_Orden_Venta" disabled autocomplete="off" class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->numero_orden_venta; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Observación:<span class="asterisk">*</span></label>
                        
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <textarea id="txtObservacion" name="txtObservacion" class="form-control" style="height: 80px;resize: none;overflow:auto;"></textarea>
                        </div>
                       
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Comprobante de pago:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selFactura" name="selFactura" class="form-control">
                                <?php foreach($GLOBALS['oGuia_Venta']->dtFactura_Venta as $factura_venta){?>
                                <option value="<?php echo $factura_venta['ID']?>"><?php echo $factura_venta['serie'].'-'.$factura_venta['numero_concatenado']?></option>
                                <?php } ?>
                            </select>
                        
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckGenerar" name="ckGenerar"  <?php  echo(($GLOBALS['oGuia_Venta']->estado_ID==44||$GLOBALS['oGuia_Venta']->estado_ID==38||$GLOBALS['oGuia_Venta']->estado_ID==97||$GLOBALS['oGuia_Venta']->estado_ID==98||$GLOBALS['oGuia_Venta']->estado_ID==99||$GLOBALS['oGuia_Venta']->estado_ID==100)?" checked ":"")?>>
                                <label for="ckGenerar" id="lbGenerar"><?php echo (($GLOBALS['oGuia_Venta']->tipo_documento==0)?'Guía listo para imprimir':'Guía listo para enviar a SUNAT'); ?></label>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div id="divProductos" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckver_descripcion" name="ckver_descripcion" value="1" <?php  echo(($GLOBALS['oGuia_Venta']->ver_descripcion==1)?" checked ":"")?> onclick="cargar_detalle_guia();">
                                <label for="ckver_descripcion">Ver descripción</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckver_componente" name="ckver_componente" value="1" <?php  echo(($GLOBALS['oGuia_Venta']->ver_componente==1)?" checked ":"")?> onclick="cargar_detalle_guia();">
                                <label for="ckver_componente">Ver componentes</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckver_adicional" name="ckver_adicional" value="1" <?php  echo(($GLOBALS['oGuia_Venta']->ver_adicional==1)?" checked ":"")?> onclick="cargar_detalle_guia();">
                                <label for="ckver_adicional">Ver adicionales</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckver_serie" name="ckver_serie" value="1" <?php  echo(($GLOBALS['oGuia_Venta']->ver_serie==1)?" checked ":"")?> onclick="cargar_detalle_guia();">
                                <label for="ckver_serie">Ver serie</label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckincluir_obsequios" name="ckincluir_obsequios" checked value="1" <?php  echo(($GLOBALS['oGuia_Venta']->incluir_obsequios==1)?" checked ":"")?>  onclick="cargar_detalle_guia();">
                                <label for="ckincluir_obsequios">Obsequios</label>
                            </div>
                        </div>
                    </div>
                    <table id="table_detalle" class="table table-hover table-bordered table-teal">
                        <thead>
                            <tr><th class="text-center">N°</th><th class="text-center">COD.</th><th class="text-center">DESCRIPCIÓN</th><th class="text-center">UM</th><th class="text-center">CANT.</th></tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="divInfoTraslado" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Fecha inicio traslado:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtFecha_Inicio_Traslado" name="txtFecha_Inicio_Traslado" required class="date-range-picker-single form-control form-requerido" value="<?php echo $GLOBALS['oGuia_Venta']->fecha_inicio_traslado;?>">
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Dpto./Prov./Dist. Partida:<span class="asterisk">*</span></label>
                       
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select name="selDepartamento_Partida" id="selDepartamento_Partida" class="chosen-select form-control" onchange="Opciones_Provincia(this,'selProvincia_Partida');">
                                 <?php echo $GLOBALS['oGuia_Venta']->dtDepartamento;?>
                            </select>
                            
                           
                        </div>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selProvincia_Partida" name="selProvincia_Partida" class="chosen-select mb-15 form-control" onchange="Opciones_Distrito(this,'selDistrito_Partida');">
                                <?php echo $GLOBALS['oGuia_Venta']->dtProvincia;?>
                            </select>
                            
                        </div>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selDistrito_Partida" name="selDistrito_Partida" class="chosen-select mb-15 form-control">
                                 <?php echo $GLOBALS['oGuia_Venta']->dtDistrito;?>
                            </select>
                            
                        </div>
                        
                       
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Dirección partida:<span class="asterisk">*</span></label>
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <textarea id="txtPunto_Partida" name="txtPunto_Partida" class="form-control input-sm" style="height: 40px;resize: none;overflow:auto;"><?php echo $GLOBALS['oGuia_Venta']->punto_partida;?></textarea>
                            
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Dpto./Prov./Dist. llegada:<span class="asterisk">*</span></label>
                         
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selDepartamento_LLegada" name="selDepartamento_LLegada" class="chosen-select form-control" onchange="Opciones_Provincia(this,'selProvincia_LLegada');">
                                <?php echo $GLOBALS['oGuia_Venta']->dtDepartamento_llegada;?>
                            </select>
                            
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selProvincia_LLegada" name="selProvincia_LLegada" class="chosen-select form-control" onchange="Opciones_Distrito(this,'selDistrito_LLegada');">
                                 <?php echo $GLOBALS['oGuia_Venta']->dtProvincia_llegada;?>
                            </select>
                            
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selDistrito_LLegada" name="selDistrito_LLegada" class="chosen-select form-control">
                                 <?php echo $GLOBALS['oGuia_Venta']->dtDistrito_llegada;?>
                            </select>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Dirección de llegada:<span class="asterisk">*</span></label>
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <textarea id="txtPunto_Llegada" name="txtPunto_Llegada" class="form-control" style="height: 40px;resize: none;overflow:auto;"><?php echo $GLOBALS['oGuia_Venta']->punto_llegada;?></textarea>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Motivo:<span class="asterisk">*</span></label>
                        <div class="col-sm-3">
                            <select id="selMotivo_Traslado" name="selMotivo_Traslado" class="form-control">
                                <?php foreach($GLOBALS['oGuia_Venta']->dtMotivo_Traslado as $motivo){?>
                                <option value="<?php echo $motivo['ID']?>"><?php echo $motivo['nombre']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <label class="control-label col-sm-3">Descripcion motivo:</label>
                        <div class="col-sm-3">
                            <input type="text" id="txtDescripcion_Motivo" name="txtDescripcion_Motivo" autocomplete="off" class="form-control">
                        </div>
                    </div>
                </div>
                <div id="divTransportista" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Tipo de transporte:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selModalidad_Traslado" name="selModalidad_Traslado" class="form-control" >
                                <option value="0">--Seleccionar--</option>
                                <?php foreach($GLOBALS['oGuia_Venta']->dtModalidad_Traslado as $modalidad_traslado){?>
                                <option value="<?php echo $modalidad_traslado['ID']?>"><?php echo utf8_encode($modalidad_traslado['nombre'])?></option>
                                <?php } ?>
                            </select>
                            <script>
                                $("#selModalidad_Traslado").val(<?php echo $GLOBALS['oGuia_Venta']->modalidad_traslado_ID;?>);
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Vehículo:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selVehiculo_ID" name="selVehiculo_ID" class="form-control">
                                <option value="0">Seleccionar</option>
                                <?php foreach($GLOBALS['oGuia_Venta']->dtVehiculo as $item){ ?>
                                <option value="<?php echo $item["ID"]?>"><?php echo $item["placa"]?> - <?php echo FormatTextView($item["marca"])?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                               $('#selVehiculo_ID').val('<?php echo $GLOBALS['oGuia_Venta']->vehiculo_ID;?>'); 
                            </script>
                        </div>
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Chofer:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selChofer_ID" name="selChofer_ID" class="form-control">
                                <?php foreach($GLOBALS['oGuia_Venta']->dtChofer as $item1){ ?>
                                <option value="<?php echo $item1["ID"]?>"><?php echo FormatTextViewHtml($item1["nombres"]);?>, <?php echo FormatTextViewHtml($item1["apellido_paterno"]);?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                               $('#selChofer_ID').val('<?php echo $GLOBALS['oGuia_Venta']->chofer_ID;?>'); 
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        
                        <label class="control-label col-sm-3">Ruc empresa transporta:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtRuc_Empresa_Transporte" name="txtRuc_Empresa_Transporte" disabled autocomplete="off" class="form-control" value="<?php echo FormatTextViewHtml($GLOBALS['oGuia_Venta']->ruc_transportista);?>">
                        </div>
                        
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Empresa de transporte:</label>
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <input type="text" id="txtEmpresa_Transporte" name="txtEmpresa_Transporte" autocomplete="off" disabled class="form-control" value="<?php echo FormatTextViewHtml($GLOBALS['oGuia_Venta']->razon_social_transportista);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Placa vehículo:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtPlaca_Vehiculo" name="txtPlaca_Vehiculo" autocomplete="off" disabled class="form-control" value="<?php echo FormatTextViewHtml($GLOBALS['oGuia_Venta']->nro_placa_vehiculo);?>">
                    
                        </div>
                         <label class="control-label col-sm-3">DNI del conductor:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtDNI_Conductor" name="txtDNI_Conductor" autocomplete="off" disabled class="form-control" value="<?php echo FormatTextViewHtml($GLOBALS['oGuia_Venta']->nro_documento_conductor);?>">
                    
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
                <?php if($GLOBALS['oGuia_Venta']->estado_ID!=38){?>
                    <button type="submit" id="btnEnviar" name="btnEnviar" class="grabar" title="Generar Guía">
                        <span class="glyphicon glyphicon-ok"></span>
                      Generar
                   </button>
                <?php } ?>
               <?php  if($GLOBALS['oGuia_Venta']->ver_vista_previa==1){?>
                   <button type="button" id="btnVistaprevia" name="btnVistaprevia"  title="Vista previa" class="btn btn-info" onclick="fncVistaPrevia();">
                       <span class="glyphicon glyphicon-eye-open"></span>
                      Vista previa
                   </button>
               <?php } ?>
               

                   <button id="btnAnular" type="button" title="Anular guía" class="btn btn-danger" onclick="modal.confirmacion('El proceso será irreversible, esta seguro de anular la guía?','Anular Guía',fncAnularGuia);">
                       <span class="glyphicon glyphicon-ban-circle"></span>
                        Anular
                   </button> 

                    <button id="btnRegresar" type="button" title="Regresar" class="btn btn-danger" onclick="parent.windos_float_save_modal_hijo();">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Regresar
                   </button>   
                    
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $("#selTipoDocumento").change(function(){
        var electronico=this.value;
       if(electronico==1){
           $("#lbGenerar").html("Guía listo para enviar a SUNAT.");
       }else{
           $("#lbGenerar").html("Guía listo para imprimir.");
       }
        cargarValores('Salida/ajaxCargarSerieGuia',electronico,function(resultado){
            if(resultado.resultado==1){
                $("#selSerie").html(resultado.options);
                fncActualizarNumero();
                
            }else{
                mensaje.error("OCURRIÓ UN ERROR","Ocurrió un error, comuníquese con el área de sistemas.");
            }
        });
    });
  $('.nav-tabs a').on('show.bs.tab', function(event){
        var x = $.trim($(event.target).text());   
       
        switch(x){
            case "Vista previa":
                vista_previa();
                break;
           
        }
         
        
     });
    function vista_previa(){
         var object=new Object();
         object['serie']=$.trim($("#selSerie option:selected").text());
         $("#pdf").prop("src","");
         block_ui(function(){
             enviarAjaxParse("Salida/ajaxVistaPrevia_Guia_Electronico",'frm1',object,function(resultado){
                
                $("#pdf").prop("src",resultado.ruta);
                $.unblockUI();
            });
         });
         
         //pdf.mostrar('Salida/Factura_Vista_Electronico/100');  
     }
    var fncActualizarNumero=function(){
       var correlativos_ID=$('#selSerie').val();
        cargarValores('/Salida/ajaxExtraer_Numero_Ultimo',correlativos_ID,function(resultado){
            if(resultado.resultado==1){
                $('#txtNumero').val(resultado.numero); 
                $("#txtSerie").val(resultado.serie);
            }else{
                mensaje.error("OCURRIÓ UN ERROR","Ocurrió un error, comuníquese con el área de sistemas.");
            }
            

        });
    }


    
    
    var bloquear_guia=function(){
        $('#btnActualizar').css('display', 'none');
        $('#ckOpcion').css('display', 'none');
        $('#txtFecha_Emision').prop('disabled', true);
        $('#selChofer_ID').prop('disabled', true);
        $('#txtFecha_Inicio_Traslado').prop('disabled', true);
        $('#txtOrden_Compra').prop('disabled', true);
        $('#txtOrden_Pedido').prop('disabled', true);
        $('#selVehiculo_ID').prop('disabled', true);
        
        $('#txtPunto_Partida').prop('disabled', true);
        $('#txtPunto_Llegada').prop('disabled', true);
        $('#txtEmpresa_Transporte').prop('disabled', true);
        $('#txtEstado').prop('disabled', true);
        $('#btnActualizar').css('display', 'none');
        $('#btnEnviar').prop('disabled', true);
        $('#btnEnviar').css('display', 'none');
        $("#selTipoDocumento").prop("disabled",true);
       // $('#btnImprimir').css('display', 'none');
        
    }
     var desbloquear_guia=function(){
        $('#btnActualizar').css('display', '');
        $('#ckOpcion').css('display', '');
        $('#txtFecha_Emision').prop('disabled', false);
        $('#selChofer_ID').prop('disabled', false);
        $('#txtFecha_Inicio_Traslado').prop('disabled', false);
        $('#txtOrden_Compra').prop('disabled', false);
        $('#txtOrden_Pedido').prop('disabled', false);
        $('#selVehiculo_ID').prop('disabled', false);
        
        $('#txtPunto_Partida').prop('disabled', false);
        $('#txtPunto_Llegada').prop('disabled', false);
        $('#txtEmpresa_Transporte').prop('disabled', false);
        $('#txtEstado').prop('disabled', false);
        $('#btnActualizar').css('display', '');
        $('#btnEnviar').prop('disabled', false);
        $('#btnEnviar').css('display', '');
       // $('#btnImprimir').css('display', 'none');
        
    }
    var validar=function(){
        var factura_venta_ID=$("#selFactura").val();
       var fecha_emision=$('#txtFecha_Emision').val();
       var fecha_inicio_traslado=$('#txtFecha_Inicio_Traslado').val();
       var distrito_partida=$("#selDistrito_Partida").val();
       var distrito_llegada=$("#selDistrito_LLegada").val();
       var modalidad_transporte_ID=$("#selModalidad_Traslado").val();
       if(fecha_emision==""){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione la fecha de emisión de la guía.','txtFecha_Emision');
           
           return false;
       }
       if(factura_venta_ID=="" ||factura_venta_ID<1){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe seleccionar un comprobante de pago.','selFactura');
           
           return false;
       }
        if(fecha_inicio_traslado==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione fecha de inicio de traslado.','txtFecha_Inicio_Traslado');
           
           return false;
       }
       if(distrito_partida==0){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione el distrito de partida.','selDistrito_Partida');
           return false;
       }
       if(distrito_llegada==0){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione el distrito de llegada.','selDistrito_LLegada');
           return false;
       }
       if(modalidad_transporte_ID==2){
           var vehiculo_ID=$("#selVehiculo_ID").val();
           var chofer_ID=$("#selChofer_ID").val();
           if(vehiculo_ID==0){
               mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe seleccionar un vehículo.','selVehiculo_ID');
                return false;
           }
           if(chofer_ID==0){
               mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe seleccionar un chofer.','selChofer_ID');
                return false;
           }
       }else{
           var ruc_transporte=$.trim($("#txtRuc_Empresa_Transporte").val());
           var razon_transporte=$.trim($("#txtEmpresa_Transporte").val());
           var placa_vehiculo=$.trim($("#txtPlaca_Vehiculo").val());
           var dni_conductor=$.trim($("#txtDNI_Conductor").val());
           if(ruc_transporte==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe ingresar el ruc de la empresa de transporte.','txtRuc_Empresa_Transporte');
                return false;
           }
           if(razon_transporte==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe ingresar la razón social de la empresa de transporte.','txtEmpresa_Transporte');
                return false;
           }
           if(placa_vehiculo==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe ingresar la placa del vehículo de la empresa de transporte.','txtPlaca_Vehiculo');
                return false;
           }
            if(dni_conductor==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar el DNI del conductor.','txtPlaca_Vehiculo');
                return false;
           }
           
       }
       $('#selSerie').prop('disabled', false);
       $('#txtNumero ').prop('disabled', false);
       $('#txtNumero_Orden_Compra ').prop('disabled', false);
       $('#txtNumero_Orden_Venta ').prop('disabled', false);
       $('#txtRuc_Empresa_Transporte ').prop('disabled', false);
       $('#txtEmpresa_Transporte ').prop('disabled', false);
       $('#txtPlaca_Vehiculo ').prop('disabled', false);
       $('#txtDNI_Conductor ').prop('disabled', false);
       block_ui();
       
   }
   
  function Opciones_Provincia(ob,id_contenedor){
      cargarValores("Funcion/ajaxOpcionesProvincias",ob.value,function(resultado){
          console.log(resultado.provincias);
          $("#"+id_contenedor).html(resultado.provincias);
          $("#"+id_contenedor).trigger("chosen:updated");
          //Opciones_Distrito()
      });
  }
  function Opciones_Distrito(ob,id_contenedor){
      cargarValores("Funcion/ajaxOpcionesDistritos",ob.value,function(resultado){
          $("#"+id_contenedor).html(resultado.distritos);
          $("#"+id_contenedor).trigger("chosen:updated");
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
  $("#selModalidad_Traslado").change(function(){
     if(this.value==1){
        $("#txtRuc_Empresa_Transporte").prop("disabled",false);
        $("#txtEmpresa_Transporte").prop("disabled",false);
        $("#txtPlaca_Vehiculo").prop("disabled",false);
        $("#txtDNI_Conductor").prop("disabled",false);
        $("#selVehiculo_ID").val(0);
        $("#selChofer_ID").val(0);
        $("#selVehiculo_ID").prop("disabled",true);
        $("#selChofer_ID").prop("disabled",true);
     } else{
          $("#txtRuc_Empresa_Transporte").prop("disabled",true);
        $("#txtEmpresa_Transporte").prop("disabled",true);
        $("#txtPlaca_Vehiculo").prop("disabled",true);
        $("#txtDNI_Conductor").prop("disabled",true);
         $("#selVehiculo_ID").prop("disabled",false);
        $("#selChofer_ID").prop("disabled",false);
     }
  });
    function cargar_detalle_guia(){
         
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
             enviarAjaxParse("salida/ajaxCargarDetalle_Guia_Venta",'frm1',object,function(resultado){
             
             $("#table_detalle tbody").html(resultado.html);
             $.unblockUI();
            });
         });
     }
     $(document).ready(function(){
         cargar_detalle_guia();
     });
     var fncImprimirGuia=function(){
        //$('#fondo_espera').css('display','block');
        //var orden_venta_ID=$('#txtSalida_ID').val();
         var orden_venta_ID=908;
        try{
            
            block_ui(function(){
                cargarValores('/Salida/ajaxImprimir_Guia_Venta',orden_venta_ID,function(resultado){
                //alert(resultado.resultado);
                if(resultado.resultado==1){
                    $('#txtEstado').val('Emitido');
                    //$('#tdguia_detalle').html(resultado.guia_detalle);
                    bloquear_guia();
                    $('#btnAnular').css('display','');
                    //parent.fParent1.call(this,2);
                    $.unblockUI();
                    toastem.success(resultado.mensaje);

                }else {
                     $.unblockUI();
                    mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
                        //modal.advertencia('ERROR DE IMPRESIÓN',resultado.mensaje);
                }
               
                //$('#fondo_espera').css('display','none');
            });
        });
        }catch(e){
            $.unblockUI();
            console.log(e);
        }
        
        
    }
    </script>
 
 <?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $.unblockUI();
            toastem.error('<?php echo $GLOBALS['mensaje'];?>');
        });
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

<script type="text/javascript">
 //alert('hola');
 $(document).ready(function () {
     $.unblockUI();
    toastem.success('<?php echo $GLOBALS['mensaje'];?>');
    setTimeout('parent.windos_float_save_modal_hijo();', 1000);
    
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
    setTimeout('parent.windos_float_save_modal_hijo();', 2000);
    
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