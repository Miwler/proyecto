<?php		
	require ROOT_PATH . "views/shared/content-float-modal.php";	
?>	
<?php function fncTitle(){?>Registrar Cotización<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jPdf.js"></script>
	
        <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>

<?php } ?>

<?php function fncTitleHead(){ ?>Registrar Cotización<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['resultado']==1){ ?>
<form id="form" method="POST" action="/Salida/Nota_Credito_Mantenimiento_Editar/<?php echo $GLOBALS['ob']->ID;?>"  class="form-horizontal" >
    
    <input type="hidden" id="data_table" name="data_table" value="<?php echo $GLOBALS['dt'];?>">
    <input type="hidden" id="txtID" name="txtID" value="<?php echo $GLOBALS['ob']->ID;?>">
    <!-- Start default tabs -->
    <div class="panel panel-tab rounded shadow">
        <!-- Start tabs heading -->
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab1-1" data-toggle="tab">
                        <i class="fa fa-user"></i>
                        <span>Documento</span>
                    </a>
                </li>
                <li>
                    <a href="#tab1-2" data-toggle="tab">
                        <i class="fa fa-file-text"></i>
                        <span>Detalle</span>
                    </a>
                </li>
                
            </ul>
            <?php if($GLOBALS['ob']->estado_ID==90||$GLOBALS['ob']->estado_ID==91){?>
            <button type="button" onclick="fncAgregar_Detalle();" class="btn btn-info active" style="float:right;top:10px;"><span class="glyphicon glyphicon-plus"></span>Detalle</button>
            <?php } ?>
            
        </div><!-- /.panel-heading -->
        <!--/ End tabs heading -->

        <!-- Start tabs content -->
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1-1">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <div class="form-group">
                                <div  class="col-md-1 col-sm-1 col-xs-1">
                                    <div class="ckbox ckbox-theme">
                                        <input type="checkbox" id="ckOpcion" name="ckOpcion" value="1">
                                        <label for="ckOpcion"></label>
                                    </div>
                                </div>
                                <div  class="col-md-1 col-sm-1 col-xs-1">
                                    <button type="button" id="btnActualizar" style="vertical-align: bottom; border: none;" onclick="fncActualizarNumero();"><img src="/include/img/boton/refresh32x32.png" width="22px"/></button>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <select id="selSerie" name="selSerie" class="form-control" disabled  onchange="fncActualizarNumero();" >
                                        <?php foreach($GLOBALS['ob']->dtSerie as $value){ ?>
                                        <option value="<?php echo $value['ID'];?>"><?php echo $value['serie'];?></option>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" id="txtSerie" name="txtSerie" value="<?php echo $GLOBALS['ob']->serie?>">
                                    <script type="text/javascript">
                                    $('#selSerie').val('<?php echo $GLOBALS['ob']->correlativos_ID;?>');
                                    </script>
                                </div>
                                
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Número:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="text" id="txtNumero" name="txtNumero" autocomplete="off" value="<?php echo $GLOBALS['ob']->numero_concatenado;?>" disabled class="int form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Factura:<span class="asterisk">*</span></label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="hidden" id="txtFactura_Venta_ID" name="txtFactura_Venta_ID" value="<?php echo $GLOBALS['ob']->documento_relacionado_ID;?>">
                                    <div class="input-group mb-15">
                                        <input type="text" id="txtFactura" name="txtFactura" class="form-control no-border-right" value="<?php echo $GLOBALS['ob']->factura;?>">
                                        <?php if($GLOBALS['ob']->estado_ID!=92){ ?>
                                        <span class="input-group-btn"><button type="button" title="Buscar factura" class="btn btn-theme" onclick="fncBuscarFacturas();"><i class="fa fa-search-plus"></i></button></span>
                                        <?php } ?>
                                    </div>

                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">T.C.:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio" autocomplete="off" value="<?php echo$GLOBALS['ob']->tipo_cambio;?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">F. Emisión:<span class="asterisk">*</span></label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="text" id="txtFecha_Emision" name="txtFecha_Emision" class="date-range-picker-single form-control" value="<?php echo $GLOBALS['ob']->fecha_emision;?>">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">F. Vence:<span class="asterisk">*</span></label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="text" id="txtFecha_vencimiento" name="txtFecha_vencimiento" class="date-range-picker-single form-control" value="<?php echo $GLOBALS['ob']->fecha_vencimiento;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Tipo:<span class="asterisk">*</span></label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <select id="selTipo" name="selTipo" class="form-control">
                                        <?php foreach($GLOBALS['dtTipo'] as $valor){ ?>
                                        <option value="<?php echo $valor['ID'];?>" ><?php  echo ($valor['nombre']); ?></option>
                                        <?php } ?>
                                    </select>
                                    <script>
                                        $("#selTipo").val(<?php echo $GLOBALS['ob']->tipo_ID;?>);
                                    </script>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Moneda:<span class="asterisk">*</span></label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <select id="selMoneda" name="selMoneda" class="form-control">

                                        <?php foreach($GLOBALS['dtMoneda'] as $valor1){ ?>
                                        <option value="<?php echo $valor1['ID'];?>"><?php  echo ($valor1['descripcion']); ?></option>
                                        <?php } ?>

                                    </select>
                                     <script>
                                        $("#selMoneda").val(<?php echo $GLOBALS['ob']->moneda_ID;?>);
                                    </script>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Cliente:<span class="asterisk">*</span></label>
                                <div class="col-md-10 col-sm-10 col-xs-10">
                                    <input type="hidden" id="txtCliente_ID" name="txtCliente_ID" value="<?php echo $GLOBALS['ob']->cliente_ID;?>">
                                    <input type="text" class="form-control" id="listaCliente" name="listaCliente" value="<?php echo $GLOBALS['ob']->ruc.'-'.$GLOBALS['ob']->razon_social;?>">
                                    <script>
                                        $(document).ready(function(){
                                            lista('/funcion/ajaxListarClientes','listaCliente','txtCliente_ID');
                                        });
                                    </script>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2">Descripción Motivo:<span class="asterisk">*</span></label>
                                <div class="col-md-10 col-sm-10">
                                    <textarea id="txtObservacion" name="txtObservacion" class="form-control" style="height: 50px;overflow:auto;resize:none;"><?php echo FormatTextView($GLOBALS['ob']->observacion);?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="control-label col-sm-5">% Descuento:</label>
                                <div class="col-sm-7">
                                    <input type="text"  id="txtPorcentaje" name="txtPorcentaje" onkeyup="calcular();" autocomplete="off" class="form-control decimal" value="<?php echo $GLOBALS['ob']->porcentaje_descuento;?>">
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="control-label col-sm-5">SubTotal:<span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtSubTotal" name="txtSubTotal" autocomplete="off" class="form-control decimal" value="<?php echo $GLOBALS['ob']->monto_total_neto;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5">IGV:<span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtIGV" name="txtIGV" autocomplete="off" class="form-control decimal" value="<?php echo $GLOBALS['ob']->monto_total_igv;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5">Otros cargos:</label>
                                <div class="col-sm-7">
                                    <input type="text"  id="txtOtros_Cargos" name="txtOtros_Cargos" autocomplete="off" onkeyup="calcular();" class="form-control decimal" value="<?php echo $GLOBALS['ob']->otros_cargos;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5">Descuento Total(-):</label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescuentoTotal" name="txtDescuentoTotal" autocomplete="off"  class="form-control decimal" value="<?php echo $GLOBALS['ob']->descuento_global;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5">Total:<span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtTotal" name="txtTotal" autocomplete="off" class="form-control decimal" value="<?php echo $GLOBALS['ob']->monto_total;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab1-2">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                            
                        </div>
                    </div>
                    <div class="row" id="divDetalle" style="height:300px;overflow:auto; ">
                        <table id="tbDetalle" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio unit.</th>
                                    <th>SubTotal</th>
                                    <th>Total</th>
                                    <th>Opción</th>
                                </tr>
                                
                            </thead>
                            <tbody id="cuerpo">
                                
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                
            </div>
        </div><!-- /.panel-body -->
        <div class="panel-footer">
            <div class="pull-left">
                <button type="button" class="btn btn-success" onclick="Grabar();">Guardar</button>
                <?php if($GLOBALS['ob']->estado_ID==90||$GLOBALS['ob']->estado_ID==91){?>
                <!-- <button type="button" class="btn btn-success" onclick="modal.confirmacion('El proceso es irreversible, esta seguro de generar la nota de crédito.','Generación de nota de crédito',generar);">Generar</button>-->
                <?php } ?>
                <?php if($GLOBALS['ob']->estado_ID==91){?>
                <button type="button" class="btn btn-primary" onclick="modal.confirmacion('El proceso es irreversible, esta seguro de enviar la nota de crédito a la SUNAT.','Envío de nota de crédito',fncEnviar);">Enviar SUNAT</button>
                <?php } ?>
                <button type="button" class="btn btn-danger" onclick="fncVista_Previa();"><i class="fa fa-file-pdf-o"></i> ver PDF</button>
                <button type="button" class="btn btn-danger" onclick="salir();">Salir</button>
                
            </div>
            <div class="clearfix"></div>
        </div>
        <!--/ End tabs content -->
    </div><!-- /.panel -->
    <!--/ End default tabs -->
</form>
<script type="text/javascript">
    var jsonObject;
    var myTable;  
    function salir(){
         window_float_save_modal();
    }
     var Grabar=function(){
        if(validar()==true){
            modal.confirmacion('El proceso es irreversible, esta seguro de generar la nota de crédito.','Generación de nota de crédito',function(){
                 var jSON=JSON.stringify(jsonObject);
                $("#data_table").val(jSON);

                 block_ui();
               $("#form").submit();
                
            });
           
        }
    }
    $(document).ready(function(){
        var align=['C','L','C','R','R','R','C'];
        
        myTable = build_data_table_default($('#tbDetalle'),align);
        jsonObject=<?php echo $GLOBALS['dt'];?>;
        cargar_tabla(jsonObject);
        <?php if($GLOBALS['ob']->estado_ID==92){?>
        bloquear();
        <?php } ?>
    });
    var validar=function(){
        var factura_venta_ID=$.trim($("#txtFactura").val());
        var cliente_ID=$("#txtCliente_ID").val();
        var total=$.trim($("#txtTotal").val());
        var subtotal=$.trim($("#txtSubTotal").val());
        var motivo=$.trim($("#txtObservacion").val());
        if(factura_venta_ID==""){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe seleccionar una factura.","txtFactura");
            return false;
        }
        if(cliente_ID==""){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe seleccionar un cliente.","listaCliente");
            return false;
        }
        if(motivo==""){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe registrar el motivo.","txtObservacion");
            return false;
        }
        if(parseFloat(total)==0){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe registrar un total.","txtTotal");
            return false;
        }
        var nFilas=$("#tbDetalle tbody tr").length;
        if(nFilas==0){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe registrar detalle de la nota de crédito.");
            $(".nav-tabs a[href='#tab1-2']").tab("show");
            return false; 
        }
        $("#selSerie").prop("disabled", false);
       
        return true
        //modal.confirmacion('El proceso es irreversible, esta seguro de eliminar el registro.','Generar',funcion);
        
    }
    var fncEnviar=function(){
        var id=<?php echo $GLOBALS['ob']->ID;?>;
        block_ui(function(){
            cargarValores('Salida/ajaxEnviarNota_CreditoSUNAT',id,function(resultado){
                $.unblockUI();
                if(resultado.resultado==1){
                    toastem.success(resultado.mensaje);
                    bloquear();
                    setTimeout(function(){
                        window_float_save_modal();
                    }, 1000);
                    
                }else{
                    mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
                }
            });
        });
        
    }
    var fncAgregar_Detalle=function(){
        var jSON=JSON.stringify(jsonObject);
            
            
        parent.window_float_open_modal_hijo("AGREGAR DETALLE","Salida/nota_credito_detalle",llave,"",cargar_tabla,700,330);

    } 
    var fncExtraerTotales=function(){
        var sub_total=0;
         var result = jsonObject.map(function (item) {
             sub_total=sub_total+parseFloat(item.sub_total);
         });
        
        
        $("#txtSubTotal").val(sub_total);
        var igv=redondear(sub_total*0.18,2);
        var total=redondear(sub_total*(1.18),2);
        $("#txtIGV").val(igv);
        $("#txtTotal").val(total);
    }
    var fncVista_Previa=function(){
        var id=$("#txtID").val();
        parent.window_float_open_modal_hijo("VER NOTA CRÉDITO","Salida/Comprobante_Regula_Vista_Previa",id,"",null,700,600);
       
    }
    var fncActualizarNumero=function(){
        try{
            block_ui(function(){
                var correlativos_ID=$('#selSerie').val();
                cargarValores('/Salida/ajaxExtraer_Numero_Ultimo',correlativos_ID,function(resultado){
                    $.unblockUI();
                    if(resultado.resultado==1){
                        $('#txtNumero').val(resultado.numero); 
                        $("#txtSerie").val(resultado.serie);
                    }else{
                        mensaje.error("OCURRIÓ UN ERROR","Ocurrió un error, comuniquese con el área de sistemas.");
                    }


                });
            });
        }catch(e){
            console.log(e);
        }
       
    }
    function addFila(array){
        jsonObject.push(array);
        cargar_tabla(jsonObject);
        fncExtraerTotales();
    }
    var cargar_tabla=function(dt){
         var campos=['num','producto','cantidad','precio_unitario','sub_total','total'];
                var btn=['Eliminar'];
            jsonContructor_Tabla(dt,campos,btn);
    }
    
    var fncBuscarFacturas=function(){
        parent.window_float_open_modal_hijo("FACTURAS EMITIDAS","Salida/factura_venta_emitidas",'',"",cargarInformacion,700,330);

    }
    var cargarInformacion=function(factura_venta_ID){
       cargarValores('Salida/ajaxExtraerInformacionFacturas_Emitidas',factura_venta_ID,function(resultado){
            $("#txtFactura").val(resultado.numero);
            $("#selMoneda").val(resultado.moneda_ID);
            $("#txtSubTotal").val(resultado.subtotal);
            //subtotal=parseFloat(resultado.subtotal);
            $("#txtTotal").val(resultado.total);
            $("#txtIGV").val(resultado.igv);
            $("#txtCliente_ID").val(resultado.cliente_ID);
            $("#listaCliente").val(resultado.cliente);
     
            $("#txtFactura_Venta_ID").val(factura_venta_ID);
            jsonObject=resultado.dt;
     
            cargar_tabla(jsonObject);
        });
    }
    function jsonContructor_Tabla(jsonObject,campos,array_btn){
        try {
            ;
            var a=0;
            var result = jsonObject.map(function (item) {
                    
                    var result = [];
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
    function calcular(){   
        var porcentaje=$('#txtPorcentaje').val();
        var otros_cargos=$("#txtOtros_Cargos").val();
        //var subtotal=$("#txtSubTotal").val();
        var total=$("#txtTotal").val();
        if($.trim(porcentaje)==""){
            porcentaje=0;
        } else {porcentaje=parseFloat(porcentaje);}
        
        if($.trim(otros_cargos)==""){
            otros_cargos=0;
        }else {
            otros_cargos=parseFloat(otros_cargos);

        }
        /*if($.trim(subtotal)==""){
            subtotal=0;
        }else {
            subtotal=parseFloat(subtotal);

        }*/
        var subtotal_temp=0;
        var descuento=redondear(subtotal*(porcentaje/100),2);
       
        subtotal_temp=redondear(subtotal*(100-porcentaje)/100,2);
        
        var igv=redondear(subtotal_temp*0.18,2);
        total=redondear(subtotal_temp+igv+otros_cargos,2);
        $("#txtSubTotal").val(subtotal_temp);
        $('#txtIGV').val(igv);  
        $("#txtDescuentoTotal").val(descuento);
        $('#txtTotal').val(total);
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
    var bloquear=function(){
        $("#txtFactura").prop('disabled',true);
        $("#txtTipo_Cambio").prop('disabled',true);
        $("#txtFecha_Emision").prop('disabled',true);
        $("#txtFecha_vencimiento").prop('disabled',true);
        $("#selTipo").prop('disabled',true);
        $("#selMoneda").prop('disabled',true);
        $("#listaCliente").prop('disabled',true);
        $("#txtObservacion").prop('disabled',true);
        $("#txtPorcentaje").prop('disabled',true);
        $("#txtSubTotal").prop('disabled',true);
        $("#txtIGV").prop('disabled',true);
        $("#txtOtros_Cargos").prop('disabled',true);
        $("#txtDescuentoTotal").prop('disabled',true);
        $("#txtTotal").prop('disabled',true);
        $("#ckOpcion").prop('disabled',true);
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
     $.unblockUI();
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