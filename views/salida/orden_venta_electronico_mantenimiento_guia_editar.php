<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>GUIA DE VENTA<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>

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
<form id="frm1" method="post" role="form" action="Salida/Orden_Venta_Electronico_Mantenimiento_Guia_Editar/<?php echo $GLOBALS['oGuia_Venta']->ID;?>" onsubmit="return validar();" class="form-horizontal">
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
                    <div class="form-group" style="display:none">
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
                            
                        <div class="col-sm-2">
                            <select id="selSerie" name="selSerie"  disabled class="form-control" onchange="fncActualizarNumero();">
                                <?php echo $GLOBALS['oGuia_Venta']->dtSerie;?>
                               
                            </select>
                            
                        </div>
                        <div class="col-sm-2">
                            <input type="text" id="txtNumero" name="txtNumero" disabled class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->numero_concatenado;?>">
                        </div>
                        <div class="col-sm-1">
                            <button type="button" id="btnActualizar" style="vertical-align: bottom; border: none;" onclick="fncActualizarNumero();"><img src="/include/img/boton/refresh32x32.png" width="22px"/></button>
                        </div>
                        <label class="control-label col-sm-2">Fact/Bol:<span class="asterisk">*</span></label>
                        <div class="col-sm-2">
                            
                            <select id="selFactura" name="selFactura" class="form-control">
                                <?php foreach($GLOBALS['oGuia_Venta']->dtFactura_Venta as $factura_venta){?>
                                <option value="<?php echo $factura_venta['ID']?>"><?php echo $factura_venta['serie'].'-'.$factura_venta['numero']?></option>
                                <?php } ?>
                            </select>
                        
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
                        <label class="control-label col-sm-3">Vehículo:<span class="asterisk">*</span></label>
                        <div class="col-sm-3">
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
                        <label class="control-label col-sm-3">Chofer:<span class="asterisk">*</span></label>
                        <div class="col-sm-3">
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
                        <label class="control-label col-sm-3">Observación:<span class="asterisk">*</span></label>
                        
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <textarea id="txtObservacion" name="txtObservacion" class="form-control" style="height: 80px;resize: none;overflow:auto;"><?php echo $GLOBALS['oGuia_Venta']->observacion; ?></textarea>
                        </div>
                       
                    </div>
                    <div class="form-group" style="display:none">
                       
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckGenerar" name="ckGenerar" <?php  echo(($GLOBALS['oGuia_Venta']->estado_ID==97||$GLOBALS['oGuia_Venta']->estado_ID==98||$GLOBALS['oGuia_Venta']->estado_ID==99||$GLOBALS['oGuia_Venta']->estado_ID==100)?" checked ":"")?>>
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
                    <div class="alert alert-teals">
                        <strong>Importante!</strong> La longitud máxima del nombre, descripción,componente,adicional y series deben sumar como máximo 250.
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
                            <script>
                                $("#selMotivo_Traslado").val(<?php echo $GLOBALS['oGuia_Venta']->motivo_traslado_ID;?>);
                            </script>
                        </div>
                        <label class="control-label col-sm-3">Descripcion motivo:</label>
                        <div class="col-sm-3">
                            <input type="text" id="txtDescripcion_Motivo" name="txtDescripcion_Motivo" autocomplete="off" class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->descripcion_motivo;?>">
                        </div>
                    </div>
                </div>
                <div id="divTransportista" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Tipo de transporte:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selModalidad_Traslado" name="selModalidad_Traslado" class="form-control" >
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
                        
                        <label class="control-label col-sm-3">Ruc empresa transporta:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtRuc_Empresa_Transporte" name="txtRuc_Empresa_Transporte" disabled autocomplete="off" class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->ruc_transportista;?>">
                        </div>
                        
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Empresa de transporte:</label>
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <input type="text" id="txtEmpresa_Transporte" name="txtEmpresa_Transporte" autocomplete="off" disabled class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->razon_social_transportista;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Placa vehículo:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtPlaca_Vehiculo" name="txtPlaca_Vehiculo" autocomplete="off" disabled class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->nro_placa_vehiculo;?>">
                    
                        </div>
                         <label class="control-label col-sm-3">DNI del conductor:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtDNI_Conductor" name="txtDNI_Conductor" autocomplete="off" disabled class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->nro_documento_conductor;?>">
                    
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
                <?php if($GLOBALS['oGuia_Venta']->estado_ID==36||$GLOBALS['oGuia_Venta']->estado_ID==37){?>
                    <button type="submit" id="btnEnviar" name="btnEnviar" class="grabar" title="Generar Guía">
                        <span class="glyphicon glyphicon-ok"></span>
                      Generar
                   </button>
                <?php } ?>
                <button type="button" id="btn_EnviarFactura" class="btn btn-primary" style="display:none;" onclick="fncEnviarFacturaSUNAT();">
                    Enviar Fact/Boleta a SUNAT
                </button>
                    <!--
                <button id="btnAnular" type="button" title="Anular guía" class="btn btn-danger" onclick="modal.confirmacion('El proceso será irreversible, esta seguro de anular la guía?','Anular Guía',fncAnularGuia);">
                    <span class="glyphicon glyphicon-ban-circle"></span>
                     Anular
                </button> -->
            
                <button id="btnRegresar" type="button" title="Regresar" class="cancelar" onclick="salir();">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Salir
               </button>   
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    
    function salir(){
        parent.fParent1.call(this,<?php echo $GLOBALS['oGuia_Venta']->factura_venta_ID;?>,<?php echo $GLOBALS['oGuia_Venta']->ID;?>);
         parent.float_close_modal_hijo();
    }
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
                mensaje.error("OCURRIÓ UN ERROR","Ocurrió un error, comuniquese con el área de sistemas.");
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
        $("#txtPeso_Bruto_Total").prop('disabled',true);
        $('#txtPunto_Partida').prop('disabled', true);
        $("#selDepartamento_Partida").prop('disabled', true);
        $("#selProvincia_Partida").prop('disabled', true);
        $("#selDistrito_Partida").prop('disabled', true);
        $("#selDepartamento_LLegada").prop('disabled', true);
        $("#selProvincia_LLegada").prop('disabled', true);
        $("#selDistrito_LLegada").prop('disabled', true);
        $("#selMotivo_Traslado").prop('disabled', true);
        $("#txtDescripcion_Motivo").prop('disabled', true);
        $('#txtPunto_Llegada').prop('disabled', true);
        $('#txtEmpresa_Transporte').prop('disabled', true);
        $('#selModalidad_Traslado').prop('disabled', true);
        
        
        $('#txtEstado').prop('disabled', true);
        $('#btnActualizar').css('display', 'none');
        $('#btnEnviar').prop('disabled', true);
        $('#btnEnviar').css('display', 'none');
        $("#selTipoDocumento").prop("disabled",true);
        $("#ckver_descripcion").prop("disabled",true);
        $("#ckver_adicional").prop("disabled",true);
        $("#ckver_serie").prop("disabled",true);
        $("#ckver_componente").prop("disabled",true);
        $("#ckincluir_obsequios").prop("disabled",true);
        $("#txtObservacion").prop("disabled", true);
        $("#selFactura").prop("disabled",true);
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
       var peso=$.trim($("#txtPeso_Bruto_Total").val());
       if(fecha_emision==""){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione la fecha de emisión de la guía.','txtFecha_Emision');
           
           return false;
       }
       if(factura_venta_ID=="" ||factura_venta_ID<1){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe seleccionar un comprobante de pago.','selFactura');
           
           return false;
       }
       if(peso=='0'||peso==''){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar un peso mayor a cero.','txtPeso_Bruto_Total');
           
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
       <?php if($GLOBALS['oGuia_Venta']->opcion==1){?>
            $('#ckOpcion').prop('checked', true);
       <?php } else { ?>
           $('#ckOpcion').prop('checked', false);
       <?php } ?>
        <?php if($GLOBALS['oGuia_Venta']->estado_ID==44||$GLOBALS['oGuia_Venta']->estado_ID==38||$GLOBALS['oGuia_Venta']->estado_ID==39||$GLOBALS['oGuia_Venta']->estado_ID==97||$GLOBALS['oGuia_Venta']->estado_ID==98||$GLOBALS['oGuia_Venta']->estado_ID==99||$GLOBALS['oGuia_Venta']->estado_ID==100){?>  
           
            bloquear_guia();
        <?php }?>  
            
    });
   var fncImprimirGuia=function(){
         var salida_ID=$("#txtSalida_ID").val();
        try{
            
            block_ui(function(){
                cargarValores('/Salida/ajaxImprimir_Guia_Venta',salida_ID,function(resultado){
                $.unblockUI();
                if(resultado.resultado==1){
                    $("#txtDocumento").val(resultado.serie+' - '+resultado.numero);
                    $("#ModalResultadoImpresion").modal("show");
                    $("#txtNumero_Hojas").val(resultado.cantidad_pagina);
                    //$("#btn_EnviarFactura").css("display","");
                    
                    toastem.success(resultado.mensaje);
                   
                    
                }else {
                     
                    mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
                        //modal.advertencia('ERROR DE IMPRESIÓN',resultado.mensaje);
                }
               
               
            });
        });
        }catch(e){
            $.unblockUI();
            console.log(e);
        }
        
        
    }
    function fncEnviarFacturaSUNAT() {
        var id=<?php echo $GLOBALS['oGuia_Venta']->factura_venta_ID?>;
        try {
            block_ui(function () {
                cargarValores('Salida/ajaxEnviarSUNAT',id,function(resultado){
                    $.unblockUI();

                    if (resultado.resultado == 1||resultado.resultado == 2) {
                        if(resultado.resultado == 1){
						 toastem.success(resultado.mensaje);
						}else{
							mensaje.info("Resultado",resultado.mensaje);
						}
					
                        
                        $("#btn_EnviarFactura").css("display","none");
                        setTimeout(function(){
                            parent.fParent1.call(this,id);
                            parent.float_close_modal_hijo();
                        },1000);
                        
                        //$('#txtEstado').val('Enviado a SUNAT');
                        //$('#tdfacturas_detalle').html(resultado.facturas_detalle);
                        //fncCargar_Comprobantes_Ventas();

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
   function fncGuardarVerificacion(){
        var estado_impresion=$("#selEstadoImpresion").val();
        var estado_hoja=$("#selEstadoHoja").val();
        var numero_hoja=$.trim($("#txtNumero_Hojas").val());
        var nueva_impresion=$("#selNuevaImpresion").val();
        if(estado_impresion==-1){
            mensaje.error("Mensaje error","Debe seleccionar si la impresión salió correctamente.",'selEstadoImpresion');
            return false;
        }
        if(estado_impresion==0){
            if(estado_hoja==-1){
                mensaje.error("Mensaje error","Debe seleccionar si la hoja se dañó.",'selEstadoHoja');
                return false;
            }
            if(estado_hoja==1){
                if(numero_hoja==""||numero_hoja=="0"){
                    mensaje.error("Mensaje error","Debe registrar la cantidad de hojas dañadas.",'txtNumero_Hojas');
                    return false;
                }
               
            }
            if(nueva_impresion==-1){
                mensaje.error("Mensaje error","Debe seleccionar si desea volver a imprimir el documento.",'selNuevaImpresion');
                return false;
            }
        }
        $("#divCargandoVerificacion").css('display','');
        $("#frmValidacionImpresion").css("display","none");
        var object=new Object();
        object["salida_ID"]=$('#txtSalida_ID').val();
        //object["salida_ID"]=903;
            enviarAjax('/Salida/ajaxValidarImpresion_Guia_Venta','frmValidacionImpresion',object,function(res){
                var respuesta = $.parseJSON(res);
               //fncCargar_Guias_Ventas();
                if(respuesta.resultado=='2'){
                    $("#btnImprimiendo").css("display","none");
                    limpiar_verificacion();
                    $("#ModalResultadoImpresion").modal("hide");
                    $("#btn_EnviarFactura").css("display","");
                    setTimeout(function(){
                        fncEnviarFacturaSUNAT();
                    },1000);
                    bloquear_guia();
                    
                }else if(respuesta.resultado=='1'){
                    limpiar_verificacion();
                    $("#txtNumero_Hojas").val(respuesta.cantidad_pagina);
                     $("#txtDocumento").val(respuesta.serie+' - '+respuesta.numero);
                    $("#divCargandoVerificacion").css('display','none');
                    $("#frmValidacionImpresion").css("display","");
                }else{
                    mensaje.error('Ocurrió un error','Ocurrió un error al grabar la información.');
                }
            });
        
        
    }
    function limpiar_verificacion(){
        $("#selEstadoImpresion").val(-1);
        $("#selEstadoHoja").val(-1);
        $("#selEstadoHoja").prop('disabled', true);
        $("#txtNumero_Hojas").val('');
        $("#txtNumero_Hojas").prop('disabled', true);
        $("#selNuevaImpresion").val(-1);
        $("#selNuevaImpresion").prop('disabled', true);
        $("#divCargandoVerificacion").css("display",'none');
    }
    $(document).ready(function () {
        $("#selEstadoImpresion").change(function(){
        
        var valor=this.value;
        $("#selEstadoHoja").val(-1);
         $("#selNuevaImpresion").val(-1);
        if(valor==0){
            $("#selEstadoHoja").prop('disabled',false);
            $("#selNuevaImpresion").prop('disabled',false);
            $("#selEstadoHoja").focus();
            
        }else{
            $("#selEstadoHoja").prop('disabled',true);
            $("#selNuevaImpresion").prop('disabled',true);
        }
    });
        $("#selEstadoHoja").change(function(){
            var valor=this.value;
            if(valor==1){
                $("#txtNumero_Hojas").prop('disabled',false);
                $("#txtNumero_Hojas").focus();
            }else{
                $("#txtNumero_Hojas").prop('disabled',true);
                $("#txtNumero_Hojas").val('');
            }
        });
    });
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
    fncImprimirGuia();
    //setTimeout('parent.windos_float_save_modal_hijo();', 1000);
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
<div class="modal fade modal-teal" id="ModalResultadoImpresion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Validación de impresión</h5>
        
      </div>
        <div class="modal-body form-horizontal">
            <div id="frmValidacionImpresion">
                <div class="form-group">
                      <label class="col-sm-5 control-label">Documento impreso:</label>
                      <div class="col-sm-7">
                          <input type="text" id="txtDocumento" name="txtDocumento" disabled class="form-control" >
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-5 control-label">¿Se imprimió correctamente?</label>
                      <div class="col-sm-7">
                          <select id="selEstadoImpresion" name="selEstadoImpresion" class="form-control">
                              <option value="-1">Seleccione</option>
                              <option value="1">SI</option>
                              <option value="0">NO</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-5 control-label">¿Se dañó la hoja?</label>
                      <div class="col-sm-7">
                          <select id="selEstadoHoja" name="selEstadoHoja" class="form-control" disabled>
                              <option value="-1">Seleccione</option>
                              <option value="1">SI</option>
                              <option value="0">NO</option>
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-5 control-label">¿Cuantas hojas se dañaron?</label>
                      <div class="col-sm-7">
                          <input type="number" id="txtNumero_Hojas" name="txtNumero_Hojas" class="int form-control" min="1"  disabled>
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-5 control-label">¿Desea volver a imprimir?</label>
                      <div class="col-sm-7">
                          <select id="selNuevaImpresion" name="selNuevaImpresion" class="form-control" disabled>
                              <option value="-1">Seleccione</option>
                              <option value="1">SI</option>
                              <option value="0">NO</option>
                          </select>
                      </div>
                  </div>
            </div>
            <div id="divCargandoVerificacion" style="height: 100%;width:100%;display:none;">
                <div style="margin:30px auto;width:100px;"><img src="../../include/img/loader-Login.gif" alt="" style="width:100px;"/></div>
                
            </div>
        </div>
      
      <div class="modal-footer">
          <button type="button" class="grabar" onclick="fncGuardarVerificacion();">Save changes</button>
        <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
        
      </div>
    </div>
  </div>
</div>