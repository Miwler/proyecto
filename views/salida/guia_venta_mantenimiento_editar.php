<?php		
	//require ROOT_PATH . "views/shared/content-float-modal.php";	
        require ROOT_PATH . "views/shared/content-view.php";	
?>	
<?php function fncTitle(){?>Nueva Guía de remisión<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jPdf.js"></script>
	<script type="text/javascript" src="include/js/jCronometro.js"></script>
        <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>
        <link rel="stylesheet" type="text/css" href="include/css/cronometro.css" />

<?php } ?>

<?php function fncTitleHead(){ ?>Registro de guía de remisión<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==1||$GLOBALS['resultado']==-1){ ?>
<form id="frm1" method="post" role="form" action="Salida/Guia_Venta_Mantenimiento_Editar/<?php echo $GLOBALS['oGuia_Venta']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <input type="hidden" id="data_table" name="data_table" value="<?php echo $GLOBALS['data_table'];?>">   
    <input type="hidden" id="ID" name="ID" value="<?php echo $GLOBALS['oGuia_Venta']->ID;?>">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos_Generales" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Datos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divInfoTraslado" class="nav-link"><i class="fa fa-globe" aria-hidden="true"></i> <span>Inf. Traslado</span></a></li>
                
            </ul>
            <div class="pull-right">
                <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" >
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                        Guardar
                </button>
                <?php if ($GLOBALS['oGuia_Venta']->ID >0) { ?>
                <?php if($GLOBALS['oGuia_Venta']->estado_ID<>98){?>
                <button  id="btnEnviarSUNAT" name="btnEnviarSUNAT" type="button" class="btn btn-lilac" onclick="fncEnviarGuiaSUNAT();" title="Descargar PDF" >
                    <i class="fa fa-check"></i>
                    Enviar SUNAT
                </button> 
                <?php } ?>
                <button  id="btnDescargar" name="btnDescargar" type="button" class="btn btn-danger" onclick="descargar();" title="Descargar PDF" >
                    <span class="glyphicon glyphicon-cloud-download"></span>
                    PDF
                </button> 
                
                <?php } ?>
                
                <button  id="btnCancelar" name="btnCancelar" class="btn btn-warning" type="button" onclick="parent.window_save_view();" >
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Salir
                </button>
            </div>
        </div>
        <div class="panel-body no-padding rounded-bottom">
           
            <div class="tab-content">
                <div id="divDatos_Generales" class="tab-pane fade in active inner-all">
                    <div class="form-group form-group-divider">
                        <div class="form-inner">
                            <h4 class="no-margin">Información de la guía</h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">N° Guía:<span class="asterisk">*</span></label>
                        <div class="col-sm-2">
                            <select id="selSerie" name="selSerie"   class="form-control" onchange="fncActualizarNumero();">
                                <?php echo $GLOBALS['oGuia_Venta']->dtSerie;?>
                               
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" id="txtNumero" name="txtNumero" disabled class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->numero;?>">
                        </div>
                        <div class="col-sm-1">
                            <button type="button" id="btnActualizar" style="vertical-align: bottom; border: none;" onclick="fncActualizarNumero();"><img src="/include/img/boton/refresh32x32.png" width="22px"/></button>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Cliente:<span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                            <input type="hidden" id="cliente_ID" name="cliente_ID" value="<?php echo $GLOBALS['oGuia_Venta']->cliente_ID;?>">
                            <input type="text" id="listaCliente" class="form-control" value="<?php echo FormatTextViewPDF($GLOBALS['oGuia_Venta']->oCliente->ruc.' '.$GLOBALS['oGuia_Venta']->oCliente->razon_social);?>">
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    lista('/funcion/ajaxListarClientes','listaCliente','cliente_ID',fncCargaValores,limpiarPadre);
                                });

                            </script>
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
                            <input type="text" id="txtNumero_Orden_Compra" name="txtNumero_Orden_Compra"  autocomplete="off"  class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->numero_orden_compra; ?>" >
                        </div>
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">N° orden de venta:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtNumero_Orden_Venta" name="txtNumero_Orden_Venta"  autocomplete="off" class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->numero_orden_venta; ?>" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Observación:<span class="asterisk">*</span></label>
                        
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <textarea id="txtObservacion" name="txtObservacion" class="form-control" style="height: 80px;resize: none;overflow:auto;"><?php echo $GLOBALS['oGuia_Venta']->observacion;?></textarea>
                        </div>
                       
                    </div>
                    
                    <div class="form-group form-group-divider">
                        <div class="form-inner">
                            <h4 class="no-margin">Productos<button type="button" id="btnAgregarDetalle" class="pull-right btn btn-lilac" onclick="fnAgregarProducto();">Agregar</button></h4>
                            
                        </div>
                        
                    </div>
                   
                    <table id="table_detalle" class="table table-hover table-bordered table-teal">
                        <thead>
                            <tr><th class="text-center">N°</th><th class="text-center">COD.</th><th class="text-center">DESCRIPCIÓN</th><th class="text-center">UM</th><th class="text-center">CANT.</th><th class="text-center">PESO.</th><th></th></tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="divInfoTraslado" class="tab-pane fade inner-all">
                    <div class="form-group form-group-divider">
                        <div class="form-inner">
                            <h4 class="no-margin">Información de ubicación</h4>
                        </div>
                    </div>
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
                            <textarea id="txtPunto_Partida" name="txtPunto_Partida" maxlength="100" class="form-control input-sm" style="height: 40px;resize: none;overflow:auto;"><?php echo $GLOBALS['oGuia_Venta']->punto_partida;?></textarea>
                            
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
                            <select id="selProvincia_LLegada" name="selProvincia_LLegada"   class="chosen-select form-control" onchange="Opciones_Distrito(this,'selDistrito_LLegada');">
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
                            <textarea id="txtPunto_Llegada" name="txtPunto_Llegada" maxlength="100" class="form-control" style="height: 40px;resize: none;overflow:auto;"><?php echo $GLOBALS['oGuia_Venta']->punto_llegada;?></textarea>
                            
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
                    <div class="form-group form-group-divider">
                        <div class="form-inner">
                            <h4 class="no-margin">Información del transporte</h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Tipo de transporte:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selModalidad_Traslado" name="selModalidad_Traslado" class="form-control" >
                                <option value="0">--Seleccionar--</option>
                                <?php foreach($GLOBALS['oGuia_Venta']->dtModalidad_Traslado as $modalidad_traslado){?>
                                <option value="<?php echo $modalidad_traslado['ID']?>"><?php echo $modalidad_traslado['nombre']?></option>
                                <?php } ?>
                            </select>
                            <script>
                                $("#selModalidad_Traslado").val(<?php echo $GLOBALS['oGuia_Venta']->modalidad_traslado_ID;?>);
                            </script>
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
                                <option value="0">--Seleccionar--</option>
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
            </div>
        </div>
        
        
    </div>
</form>
<script type="text/javascript">
    function salir(){
        
        parent.float_close_modal_hijo();
    }
   
    
 
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
        $("#btnAgregarDetalle").css('display', 'none');
        $('#selSerie').prop('disabled', true);
        $('#listaCliente').prop('disabled', true);
        $('#txtNumero_Orden_Compra').prop('disabled', true);
        $('#txtNumero_Orden_Venta').prop('disabled', true);
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
       var cliente_ID=$("#cliente_ID").val();
       var fecha_emision=$('#txtFecha_Emision').val();
       var peso=$.trim($("#txtPeso_Bruto_Total").val());
       var cantidad_producto=jsonObject.lenght;
       var fecha_inicio_traslado=$('#txtFecha_Inicio_Traslado').val();
       var distrito_partida=$("#selDistrito_Partida").val();
       var direccion_partida=$.trim($("#txtPunto_Partida").val());
       var distrito_llegada=$("#selDistrito_LLegada").val();
       var direccion_llegada=$.trim($("#txtPunto_Llegada").val());
       var motivo_ID=$("#selMotivo_Traslado").val();
       
       var modalidad_transporte_ID=$("#selModalidad_Traslado").val();
       if(cliente_ID<=0){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione un cliente.','listaCliente');
           
           return false;
       }
       
       if(fecha_emision==""){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione la fecha de emisión de la guía.','txtFecha_Emision');
           
           return false;
       }
       
       if(peso=='0'||peso==''){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar un peso mayor a cero.','txtPeso_Bruto_Total');
           
           return false;
       }
       if(cantidad_producto==0){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar los productos.');
           
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
       if(direccion_partida==""){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar la dirección de partida.','txtPunto_Partida');
           return false;
       }
       if(distrito_llegada==0){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione el distrito de llegada.','selDistrito_LLegada');
           return false;
       }
       if(direccion_llegada==""){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar la dirección de llegada.','txtPunto_Llegada');
           return false;
       }
       if(motivo_ID<=0){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar el motivo del traslado.','selMotivo_Traslado');
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
       $("#selTipoDocumento").prop('disabled', false);
       var jSON=JSON.stringify(jsonObject);
        $("#data_table").val(jSON);
      
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
         /*block_ui(function(){
             
             /*enviarAjaxParse("salida/ajaxCargarDetalle_Guia_Venta",'frm1',object,function(resultado){
            
                $("#table_detalle tbody").html(resultado.html);
                $.unblockUI();
               });
         });*/
     }
     
   
    function fncEnviarGuiaSUNAT() {
        var id=$("#ID").val();
        
        try {
            if(id>0){
                block_ui(function(){
                        cargarValores('Salida/ajaxEnviarGuiaIndividualSUNAT',id,function(resultado){

                            $.unblockUI();
                             if (resultado.resultado == 1) {
                                 $("#btnEnviarSUNAT").css("display","none");
                                 toastem.success(resultado.mensaje);
                                 bloquear_guia();
                                 
                                 
                             }else{
                                 mensaje.error('OCURRIÓ UN ERROR',resultado.mensaje);
                             }
                         });
                });
            }else{
                mensaje.error("Debe registrar la guía");
            }
            
           
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
                    },500);
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
    var fncCargaValores=function(id){
        try{
            block_ui(function () {
                cargarValores('/Salida/ajaxCotizacion_Detalle_Cliente',id,function(resultado){ 
                    //console.log(resultado.operador_ID);
                    $('#txtDireccion').val(resultado.Direccion);
                    $('#txtPunto_Llegada').val(resultado.Direccion);
                    $('#txtTelefono').val(resultado.Telefono);
                    $('#selRepresentante').html(resultado.lista_representante); 
                    $('#selForma_Pago').val(resultado.Forma_pago);
                    $('#selTiempo_Credito').val(resultado.Tiempo_Credito);
                    $('#txtOperador_ID').val(resultado.operador_ID);
                    $('#txtNombres_Vendedor').val(resultado.operador);
                    $('#txtTelefono_Vendedor').val(resultado.operador_telefono);
                    $('#txtCelular1').val(resultado.operador_celular1);
                    $("#selDepartamento_LLegada").html(resultado.dtDepartamento);
                    $("#selDepartamento_LLegada").trigger("chosen:updated");
                    $("#selProvincia_LLegada").html(resultado.dtProvincia);
                    $("#selProvincia_LLegada").trigger("chosen:updated");
                    $("#selDistrito_LLegada").html(resultado.dtDistrito);
                    $("#selDistrito_LLegada").trigger("chosen:updated");
                    $.unblockUI();
                });
                
            });
        }catch (e){
            $.unblockUI();
            console.log(e);
        }
        

    }
 
   function limpiarPadre(){
        //alert(IDimagen);
        $("#selCliente").val('');
        $("#listaCliente").val('');
        $('#txtDireccion').val('');
        $('#txtTelefono').val('');
        $('#selRepresentante').html('<option value="0">--</option>'); 
        $('#selForma_Pago').val('0');
        $('#txtNombres_Vendedor').val('');
        $('#txtTelefono_Vendedor').val('');
        $('#txtCelular1').val('');
        $("#txtLugar_Entrega").val('');
    }
    
    function fnAgregarProducto(){
        parent.window_float_open_modal_hijo("AGREGAR PRODUCTO","Salida/guia_venta_mantenimiento_producto","","",addFila,700,330);

    }
    var jsonObject=new Array();
    var myTable;  
    
    $(document).ready(function(){
        
        var align=['C','C','L','C','C','C','C'];
        
        myTable = build_data_table_default($('#table_detalle'),align);
        <?php if($GLOBALS['oGuia_Venta']->ID>0){ ?>
             jsonObject=<?php echo $GLOBALS['data_table'];?>;   
            cargar_tabla(jsonObject);
        <?php } ?>
        <?php if($GLOBALS['oGuia_Venta']->estado_ID==98){?>
            bloquear_guia();
        <?php } ?>
    });
    function calcular_peso_total(){
        var peso_total=0;
        var result = jsonObject.map(function (item) {
            peso_total=peso_total+parseFloat(item.peso);
        });
        $("#txtPeso_Bruto_Total").val(peso_total);
    }
    function addFila(array){
        jsonObject.push(array);
        cargar_tabla(jsonObject);
        calcular_peso_total();
    }
    var cargar_tabla=function(dt){
         var campos=['codigo','producto','unidad_medida','cantidad','peso'];
                var btn=['Eliminar'];
            jsonContructor_Tabla(dt,campos,btn);
    }
    function jsonContructor_Tabla(dt,campos,array_btn){
        try {
            
            var a=0;
            var m=1;
            var result = dt.map(function (item) {
                    
                    var result = [];
                    result.push(m);
                    m++;
                    for(i=0;i<campos.length;i++){
                        result.push(item[campos[i]]);
                    }
                    
                  
                    var btn='<div class="btn-group"><button type="button" class="btn btn-teal dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i></button><ul class="dropdown-menu pull-right">';
                    for(y=0;y < array_btn.length;y++){
                        btn=btn+'<li><a class="dropdown-item" href="javascript:void(0);" onclick="fncDt'+array_btn[y]+'('+a+');">'+array_btn[y]+'</a></li>';
                    }
                    btn=btn+'</ul></div>';
                    btn=btn+'</ul></div>';
                    result.push(btn);
                    result.push('');
                    
                    a++;
                    return result;
                });
                myTable.rows().remove();
                myTable.rows.add(result);
                myTable.draw();

        } catch (e) {
            //alert(e.message);
            mensaje.error('Error', e.message);
        }     
    }
    function fncDtEliminar(y){
        jsonObject.splice(y,1);
      
       var campos=['num','producto','cantidad','precio_unitario','sub_total','sub_total'];
                var btn=['Eliminar'];
            jsonContructor_Tabla(jsonObject,campos,btn);
    }
    function fncDtEditar(y){
        $("#ModalDataTable").modal("show");
    }
    function descargar(){
        var id=<?php echo $GLOBALS['oGuia_Venta']->ID;?>;
        if(id>0){
            pdf.descargar("salida/Guia_Venta_DescargarPDF/"+id);
        }else{
            mensaje.error("No existe una guía");
        }
        
    }
</script>    
   
<?php }?>
            
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
        $(document).ready(function () {
        toastem.error('<?php echo $GLOBALS['mensaje']; ?>');
        });
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
<script type="text/javascript">
    $(document).ready(function () {
       toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
    });
   //ampliarVentanaVertical(750,'form');
    //fncCargar_Detalle_Cotizacion();
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

	     
<?php }?>        