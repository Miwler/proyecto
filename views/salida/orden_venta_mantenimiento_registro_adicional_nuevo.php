<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo-hijo.php";	
?>	
<?php function fncTitle(){?>NUEVO PRODUCTO ADICIONAL<?php } ?>

<?php function fncHead(){?>
	
	<script type="text/javascript" src="include/js/jForm.js"></script>
        
        <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>
	
       <style>
   
        
            #table_historial_compra tbody td,#table_historial_venta tbody td,#table_separaciones tbody td{
                font-size:11px;
            }

        </style>
        
<?php } ?>

<?php function fncTitleHead(){?>NUEVO PRODUCTO ADICIONAL<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
 

<form id="frm1" method="post"  action="Salida/Orden_Venta_Mantenimiento_Registro_Adicional_Nuevo/<?php echo $GLOBALS['oOrden_Venta_Detalle']->salida_detalle_padre_ID;?>" onsubmit="return validar();" class="form-horizontal">
   <div class="panel panel-tab rounded shadow">
       <div class="panel-heading">
           <ul class="nav nav-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#Productos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Producto</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divCostos" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i> <span>Costo</span></a></li>
                <li class="nav-item"><a href="#separaciones" data-toggle="tab"><i class="fa fa-clone"></i> <span>Separaciones</span></a></a></li>
                <li class="nav-item"><a href="#historial" data-toggle="tab"><i class="fa fa-calendar-o"></i> <span>Historial</span></a></li>
            </ul>
       </div>
        <div class="panel-bodyrounded-bottom" style="height: 370px;overflow: auto;">
            <div class="tab-content">
                <div id="Productos" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Línea: </label>
                        </div>
                        <div id="tdLinea" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <select id="selLinea" name="selLinea" onchange="fncLinea();" class="form-control filtroLista chosen-select mb-15">
                                <option value="0">TODOS</option>
                            <?php foreach($GLOBALS['oOrden_Venta_Detalle']->dtLinea as $iLinea){ ?>
                                <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                            <?php } ?>
                            </select>
                            <script type="text/javascript">
                                $('#selLinea').val(<?php echo $GLOBALS['oOrden_Venta_Detalle']->linea_ID;?>);
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Categoría: </label>
                        </div>
                        <div id="tdCategoria" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" class="form-control filtroLista chosen-select mb-15">
                            <option value="0" selected>TODOS</option>
                            <?php foreach($GLOBALS['oOrden_Venta_Detalle']->dtCategoria as $iCategoria){ ?>
                            <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                            <?php } ?>
                            </select> 
                            <input id="txtp" style="display:none;">
                            <script type="text/javascript">
                                $('#selCategoria').val(<?php echo $GLOBALS['oOrden_Venta_Detalle']->categoria_ID;?>);
                            </script>
                        </div>    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Producto: </label>
                        </div>
                        <div  class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <input type="hidden" id="selProducto" name="selProducto" value="">
                                <input type="text" id="listaProducto" class="form-control" value="">
                               <script type="text/javascript">
                                  $(document).ready(function(){
                                   listar_productos();
                                   });
                               </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Descripción: </label>
                        </div>
                        <div id="tdComentario" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <textarea id="txtDescripcion" name="txtDescripcion" class="form-control text-uppercase comentario" rows="7"  cols="40" maxlength="3000"   style="height:100px;"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Stock: </label>
                        </div>
                        <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtStock" name="txtStock"  class="form-control desactivado" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->stock; ?>" disabled>
                        </div>
                         <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <div class="ckbox ckbox-theme">
                                <input id="cbVer_Precio" name="cbVer_Precio" <?php echo (($GLOBALS['oOrden_Venta_Detalle']->ver_precio==1)?"checked":"");?>  type="checkbox" value="1">
                                <label for="cbVer_Precio">Ver precio</label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div id="divCostos" class="tab-pane fade inner-all">
                     <input type="hidden" id="valor_unitario" name="valor_unitario" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->valor_unitario;?>">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Cantidad: </label>
                        </div>
                        <div  class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input type="text" id="txtCantidad"  name="txtCantidad"  class="form-control int obligatorio" autocomplete="off" style="text-align:right;" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->cantidad;?>" onkeyup="ProductoValores();">   
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                            <label>Precio unitario: </label>
                        </div>
                        <div  class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input type="text" id="txtPrecioUnitarioDolares" autocomplete="off"  name="txtPrecioUnitarioDolares"  value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_unitario_dolares;?>" onkeyup="calcularTipoCambio('2');" class="form-control" placeholder="US$.">
                        </div>
                        <div  class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input type="text" id="txtPrecioUnitarioSoles" autocomplete="off"  name="txtPrecioUnitarioSoles"  value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_unitario_soles;?>" onkeyup="calcularTipoCambio('1');" class="form-control" placeholder="S/.">
                        </div>
                    </div>
                     <div class="form-group">
                        
                        <div class="col-xs-6">
                            <div class="ckbox ckbox-theme">
                                <input id="ckIncluyeIgv" name="ckIncluyeIgv"  type="checkbox" onclick="ProductoValores();" <?php echo (($GLOBALS['oOrden_Venta_Detalle']->pu_incluye_igv==1)?"checked":"");?>>
                                <label for="ckIncluyeIgv">precio unitario incluye IGV</label>
                            </div>
                        </div>
                         <label class="control-label col-xs-3">% descuento</label>
                        <div class="col-xs-3">
                            <input type="text" id="txtPorcentaje_Descuento" name="txtPorcentaje_Descuento" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->descuento_porcentaje;?>">
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon bg-danger">Tipo de IGV:</span>
                                 <select class="form-control no-border-left" id="selImpuestos_Tipo" name="selImpuestos_Tipo" onchange="ProductoValores();" disabled>
                                    <?php foreach($GLOBALS['dtImpuestos_Tipo'] as $valor){?>
                                    <option value="<?php echo $valor['ID'];?>"><?php echo utf8_encode($valor['nombre']);?></option>
                                    <?php } ?>
                                </select>
                                <script>
                                    $("#selImpuestos_Tipo").val(<?php echo $GLOBALS['oOrden_Venta_Detalle']->impuestos_tipo_ID;?>);
                                </script>
                            </div>
                        </div>
                        
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Moneda</th>
                                <th>Precio compra</th>
                                <th>Sub Total</th>
                                <th>I.G.V <?php echo $GLOBALS['oOrden_Venta_Detalle']->oSalida->igv*100;?>%
                                    <input type="text" id="txtValIgv" name="txtValIgv" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->oSalida->igv;?>" style="display:none;">
                                </th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>US$.</td>
                                <td><input  type="text" id="txtPrecioCompraDolares"  name="txtPrecioCompraDolares" class="form-control decimal desactivado" disabled  style="width:100px;" ></td>
                                <td><input type="text" id="txtSubTotalDolares" class="form-control desactivado" name="txtSubTotalDolares" style="width:100px;" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_subtotal_dolares;?>" disabled></td>
                                <td><input type="text" id="txtIgvDolares" name="txtIgvDolares" class="form-control desactivado" style="width:100px;" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->vigv_dolares;?>" disabled></td>
                                <td><input type="text" id="txtTotalDolares" name="txtTotalDolares" class="form-control desactivado" style="width:100px;" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_dolares;?>" disabled></td>
                            </tr>
                            <tr>
                                <td>S/.</td>
                                <td><input type="text" id="txtPrecioCompraSoles" name="txtPrecioCompraSoles" class="form-control decimal desactivado" disabled  style="width:100px;" ></td>
                                <td><input type="text" id="txtSubTotalSoles" class="form-control desactivado" name="txtSubTotalSoles" style="width:100px;" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_subtotal_soles;?>" disabled></td>
                                <td><input type="text" id="txtIgvSoles" name="txtIgvSoles" class="form-control desactivado" style="width:100px;" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->vigv_soles;?>" disabled></td>
                                <td><input type="text" id="txtTotalSoles" name="txtTotalSoles" class="form-control desactivado" style="width:100px;" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_soles;?>" disabled></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade inner-all divCuerpo" id="separaciones">
                    <h4>Separaciones de producto</h4>
                    <table id="table_separaciones" class='table table-hover table-bordered table-teal'><thead>
                        <tr><th>N°Cotizaci&oacute;n</th><th>Fecha</th><th>Cant. Comprada</th><th>Cant. Separada</th><th >Responsable</th></tr>
                    </thead>
                    <tbody>
                    </table>
                </div>
                <div class="tab-pane fade inner-alldivCuerpo" id="historial">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>Historial de Compras</h4>
                            <table class='table table-hover  table-responsive table-teal' id="table_historial_compra">
                                <thead>
                                    <tr><th>Fecha</th><th>Precio U.</th><th>Cantidad</th><th>Proveedor</th></tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="title lg-text">Historial de Ventas</h4>
                            <table class='table table-hover table-responsive table-teal' id="table_historial_venta">
                                <thead>
                                    <tr><th>Fecha</th><th>Precio U.</th><th>Cantidad</th><th>Cliente</th></tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button  id="btnEnviar" name="btnEnviar" class="grabar" >
                        <img width="16" title="Guardar" alt="" src="/include/img/boton/save_48x48.png">
                        Guardar
                    </button>

                    <button  id="btnCancelar" name="btnCancelar" type="button" class="cancelar" title="Cancelar" onclick="parent.float_close_modal_hijo_hijo();" >
                        
                         Cancelar
                    </button>    
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    var mensaje_validacion=function(){
        var ventana_validacion= new  BootstrapDialog({
            title: "Validación de precio",
            message: "<p>El precio de venta es menor que el costo de referencia, por favor ingrese la contraseña de autorización.</p><input type='password' id='txtContrasena' class='form-control' >",
            type: BootstrapDialog.TYPE_WARNING,
            buttons: [{
                label: 'Validar',
                action: function() {
                   fncValidarAutorizacion();
                }
            },{
                label:'Cerrar',
                action: function(dialog) {
                    dialog.close();
                }
            }
        ]
        });
        ventana_validacion.open();
    }
    var Resultado_verificar=0;
    var validar=function(){
    
        var producto_ID=$('#selProducto').val();
        var cantidad= $.trim($('#txtCantidad').val());
        var PrecioUnitarioSoles=$.trim($('#txtPrecioUnitarioSoles').val());
        var PrecioUnitarioDolares=$.trim($('#txtPrecioUnitarioDolares').val());
        var precioCompraUnitarioDolares=$('#txtPrecioCompraDolares').val();
      
        if(producto_ID==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione un producto.','selProducto');
            $('.nav-tabs a[href="#Productos"]').tab('show');
            return false;
        }

        //Verifico si el comprobante requiere serie y número
        if(isNaN(cantidad)||cantidad==""){
            
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre una cantidad.','txtCantidad');
            $('.nav-tabs a[href="#divCostos"]').tab('show');
            return false;   
        }
        if(precioCompraUnitarioDolares*1>=PrecioUnitarioDolares*1){
           if(Resultado_verificar==0){
               mensaje_validacion();
                return false;
           }
        }
        if(isNaN(PrecioUnitarioSoles)||PrecioUnitarioSoles==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario (S/.).','txtPrecioUnitario');
           $('.nav-tabs a[href="#divCostos"]').tab('show');
            return false;   
        }

         if(isNaN(PrecioUnitarioDolares)||PrecioUnitarioDolares==""){
             mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario ($).','txtPrecioUnitario');
            $('.nav-tabs a[href="#divCostos"]').tab('show');
            return false;   
        }
        $('#txtSubTotalSoles').removeAttr('disabled');
        $('#txtSubTotalDolares').removeAttr('disabled');
        $('#txtIgvSoles').removeAttr('disabled');
        $('#txtIgvDolares').removeAttr('disabled');
        $('#txtTotalSoles').removeAttr('disabled');
        $('#txtTotalDolares').removeAttr('disabled');
        $('#selImpuestos_Tipo').removeAttr('disabled');
        
      
        block_ui();
    }
    var fncValidarAutorizacion=function(){
        var resultado=0;
        var valor=$('#txtContrasena').val();
        cargarValores('/Salida/ajaxValidarCostoCompraMenor',valor,function(resultado){
            Resultado_verificar=resultado.resultado;
            
            if(resultado.resultado==-1){
                toastem.error(resultado.mensaje);
            }else if(resultado.resultado==0){
                toastem.advertencia('Contraseña incorrecta');
                //$('#lbMensaje').html('Contraseña incorrecta');
                //$('#fondo_mensaje').css('display','block'); 
            }
            else {
                $( "#frm1" ).submit();
                //$('#fondo_mensaje').css('display','none'); 
            }
        });
       
    }
    
    var fncCancelarAutorizacion=function(){
        Resultado_verificar=0;
        $('#txtPrecioUnitarioDolares').focus();
        //$('#lbMensaje').html('');
        //$('#fondo_mensaje').css('display','none');
        
    }
    var fncHistoriaProducto=function(producto_ID){
        cargarValores('/Funcion/ajaxHistorial_Producto',producto_ID,function(resultado){
            
            $('#table_historial_compra tbody').html(resultado.filas_compras); 
            $('#table_historial_venta tbody').html(resultado.filas_ventas); 
        });
    }
    $("#ckSeparacion").click(function(){
        if($('#ckSeparacion').is(':checked')){
            $('#txtTiempo_Separacion').removeAttr('disabled');
            $('#txtTiempo_Separacion').focus();
        }else {
            $('#txtTiempo_Separacion').attr('disabled','disabled');
        }
    });
    var fncTiempo_Separacion=function(){
        if($('#ckSeparacion').is(':checked')){
            $('#txtTiempo_Separacion').removeAttr('disabled');
            $('#txtTiempo_Separacion').focus();
        }else {
            $('#txtTiempo_Separacion').attr('disabled','disabled');
        }
        
    }
    var fncOpcion=function(valor){
        if(valor==3){
            $('#txtPrecioUnitarioSoles').val(0);
            $('#txtPrecioUnitarioDolares').val(0);
            $('#txtSubTotalDolares').val(0);
            $('#txtSubTotalSoles').val(0);
            $('#txtIgvDolares').val(0);
            $('#txtIgvSoles').val(0);
            $('#txtTotalDolares').val(0);
            $('#txtTotalSoles').val(0);
            $('#txtPrecioUnitarioSoles').prop('disabled',true);
            $('#txtPrecioUnitarioDolares').prop('disabled',true);
        }else {
            $('#txtPrecioUnitarioSoles').val('');
            $('#txtPrecioUnitarioDolares').val('');
            $('#txtSubTotalDolares').val('');
            $('#txtSubTotalSoles').val('');
            $('#txtIgvDolares').val('');
            $('#txtIgvSoles').val('');
            $('#txtTotalDolares').val('');
            $('#txtTotalSoles').val('');
            $('#txtPrecioUnitarioSoles').prop('disabled',false);
            $('#txtPrecioUnitarioDolares').prop('disabled',false);
        }
       
    }
    var fncLinea=function(){
                        
    var linea_ID = $('#selLinea').val();

        cargarValores("/Funcion/ajaxListar_Categorias",linea_ID,function(resultado){
            if(resultado.resultado==1){
                $('#selCategoria').html(resultado.html);
                $("#selCategoria").trigger("chosen:updated");
                //fncCategoria();
            }else{
                mensaje.error("Mensaje de error",resultado.mensaje);
            }
        });
 
    }

   var fncCategoria=function(){
       listar_productos();
    }
    var listar_productos=function(){
        lista_producto('/funcion/ajaxListarProductos','listaProducto','selProducto',$("#selLinea").val(),$("#selCategoria").val(),fncProducto,fncLimpiar);
    }
   var fncProducto=function(producto_ID){
        
        if(producto_ID>0){
            //$('#tbdocumentos').html('<div style="background:#000;opacity:0.7;width:100%;height:100%;text-align:center;" ><img width="80px" src="/include/img/loader-Login.gif"></div>');
            cargarValores('/Funcion/ajaxSeleccionar_Producto1',producto_ID,function(resultado){
                
                if(resultado.resultado==1){
                    $('#txtStock').val(resultado.stock);
                    $('#txtDescripcion').val(resultado.descripcion);
                    if(resultado.stock>0){
                        $('#ckSeparacion').prop('disabled',false);
                         
                    }else{
                        $('#ckSeparacion').prop('disabled',true);
                    }
                    fncCargarPrecioCompra(producto_ID);
                    
                }else{
                    mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
                }
                
                //fncListaProductosVendidos(producto_ID);
            });
        }else{
            fncLimpiar();
        }
    }
    var fncLimpiar=function(){
       $('#txtPrecioCompraDolares').val('');
        $('#txtPrecioCompraSoles').val('');
        $('#txtSubTotalDolares').val('');
        $('#txtSubTotalSoles').val('');
        $('#txtIgvDolares').val('');
        $('#txtIgvSoles').val('');
        $('#txtTotalDolares').val('');
        $('#txtTotalSoles').val('');
        $("#selProducto").val('');
        $("#table_historial_compra tbody").html('');
        $("#table_historial_venta tbody").html('');
        $("#table_separaciones tbody").html('');
        $("#txtDescripcion").val("");
        $("#txtStock").val("");
    }
    var fncCargarPrecioCompra=function(producto_ID){
          cargarValores('/Ingreso/ajaxPrecio_Ingreso',producto_ID,function(resultado){
            $('#txtPrecioCompraDolares').val(resultado.precio_compra_dolares); 
            $('#txtPrecioCompraSoles').val(resultado.precio_compra_soles);
            
            if(resultado.resultado==-1){
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
              
            }
            VerSeparaciones(resultado.producto_ID);
        });
     } 
     
    function calcularTipoCambio(tipo){
        var tipo_cambio=<?php echo $GLOBALS['oOrden_Venta_Detalle']->oSalida->tipo_cambio; ?>;
        if(tipo=="1"){
            var valorSoles=$('#txtPrecioUnitarioSoles').val();
            var valorDolares=redondear(parseFloat(valorSoles)/tipo_cambio,2);
            $('#txtPrecioUnitarioDolares').val(valorDolares);
        }else{
            var valorDolares=$('#txtPrecioUnitarioDolares').val();
            var valorSoles=redondear(parseFloat(valorDolares)*tipo_cambio,2);
            $('#txtPrecioUnitarioSoles').val(valorSoles);
        }
        ProductoValores()
    }
     function ProductoValores()
       {   
            var tipo_cambio=<?php echo $GLOBALS['oOrden_Venta']->tipo_cambio; ?>;
            var incluye_igv=($("#ckIncluyeIgv").is(":checked"))?1:0;
            var igv=parseFloat(<?php  echo $GLOBALS['oOrden_Venta']->igv;?>);
            var moneda_ID=<?php  echo $GLOBALS['oOrden_Venta']->moneda_ID?>; 
           var caja1=$('#txtCantidad').val();
           var caja2=$('#txtPrecioUnitarioSoles').val();
           var caja3=$('#txtPrecioUnitarioDolares').val();
             if($.trim(caja1)==""){
                 var valor1=0;
             } else {valor1=parseInt(caja1);}
             
            
             if($.trim(caja2)==""){
             var valor2=0;
                }else {
                    valor2=parseFloat(caja2);
                   
                }
            if (incluye_igv==1){
                valor2=redondear(valor2/(1+igv),2);  
            }   
                
            if($.trim(caja3)==""){
                  var valor3=0;
             }else {
                 valor3=parseFloat(caja3);
                
                }
            if(incluye_igv==1) {
                valor3=redondear(valor3/(1+igv),2);

            }    
            var subtotalSoles=redondear(valor1*valor2,2);
            if(isNaN(subtotalSoles)==false){ 
            $('#txtSubTotalSoles').val(subtotalSoles); 
            }else{
                $('#txtSubTotalSoles').val('--');
            }
             var subtotalDolares=redondear(valor1*valor3,2);
             
             if(isNaN(subtotalDolares)==false){
                 $('#txtSubTotalDolares').val(subtotalDolares);
             }else{
                 $('#txtSubTotalDolares').val('--');
             }
             

            if(moneda_ID==1){
                $("#valor_unitario").val(valor2);
            }else{
                $("#valor_unitario").val(valor3);
            }
            var porcentaje_descuento=parseFloat(($.trim($("#txtPorcentaje_Descuento").val())=="")?0:$.trim($("#txtPorcentaje_Descuento").val()));
        //calcularPorcentajeDescuento(porcentaje_descuento,"porcentaje");
        var descuento=0;
        var descuento_dolares=0;
        var descuento_soles=0;
        if(moneda_ID==1){
            descuento=redondear((subtotalSoles*porcentaje_descuento)/100,2);
            descuento_soles=descuento;
            descuento_dolares=redondear(descuento/tipo_cambio,2);
        }else{
            descuento=redondear(subtotalDolares*porcentaje_descuento/100,2);
            descuento_dolares=descuento;
            descuento_soles=redondear(descuento_dolares*tipo_cambio,2);
        }
   
       var valor_venta_soles=0;
        
        var valor_venta_dolares=0;
        if(moneda_ID==1){
            valor_venta_soles=redondear(subtotalSoles-descuento_soles,2);
            valor_venta_dolares=redondear(valor_venta_soles/tipo_cambio,2);
        }else{
            valor_venta_dolares=redondear(subtotalDolares-descuento_dolares,2);
            valor_venta_soles=redondear(valor_venta_dolares*tipo_cambio,2);
            
        }
        //$("#txtValorVentaDolares").val(valor_venta_dolares);
       // $("#tdValorVentaSoles").html(valor_venta_soles);
            var valor_igv_dolares=0;
            var valor_igv_soles=0;
            var obj=new Object();
            obj['moneda_ID']=moneda_ID;
            obj['tipo_cambio']=tipo_cambio;
            obj['impuesto_tipo_ID']=$("#selImpuestos_Tipo").val();
            obj['monto']=(moneda_ID==1)?valor_venta_soles:valor_venta_dolares;
            obj['igv']=igv;


            enviarAjax('salida/ajaxExtraerIGV','frm',obj,function(res){

                var resultado=$.parseJSON(res);
                valor_igv_dolares=parseFloat(resultado.resultado_dolares);
                valor_igv_soles=parseFloat(resultado.resultado_soles);
                $('#txtIgvDolares').val(valor_igv_dolares);
              
                $('#txtIgvSoles').val(valor_igv_soles);
               
                var total_venta_dolares=valor_igv_dolares+valor_venta_dolares;
                var total_venta_soles=valor_igv_soles+valor_venta_soles;
               
                $("#txtTotalDolares").val(redondear(total_venta_dolares,2));
                
                $("#txtTotalSoles").val(redondear(total_venta_soles,2)); 
                if($.trim(resultado.mensaje)!=""){
                    toastem.info(resultado.mensaje);
                }


            });
             
        }
    function calcularIGV(){

        var subtotalSoles=$('#txtSubTotalSoles').val();
        var subtotalDolares=$('#txtSubTotalDolares').val();
        var valIGV=parseFloat($('#txtValIgv').val());
        if(subtotalSoles!=0){
            var igvSoles=redondear(parseFloat(subtotalSoles)*valIGV,2);
            $('#txtIgvSoles').val(igvSoles);
            var TotalSoles=redondear(parseFloat(subtotalSoles)+parseFloat(igvSoles),2);
            $('#txtTotalSoles').val(TotalSoles);
        }
        if(subtotalDolares!=0){
            var igvDolares=redondear(parseFloat(subtotalDolares)*valIGV,2);
            $('#txtIgvDolares').val(igvDolares);
            var TotalDolares=redondear(parseFloat(subtotalDolares)+parseFloat(igvDolares),2);
            $('#txtTotalDolares').val(TotalDolares);
        }


    }
    function VerSeparaciones(producto_ID){
       cargarValores('/Funcion/ajaxVerSeparaciones',producto_ID,function(resultado){
            $("#table_separaciones tbody").html(resultado.filas);
             
                  fncHistoriaProducto(producto_ID);
        });
        
    }
    
    </script>
 
 <?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
           // alert('-1');
    $(document).ready(function () {

    toastem.error('<?php echo $GLOBALS['mensaje']; ?>');
    });
       // setTimeout('window_float_save();', 1000);
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
<script type="text/javascript">

$(document).ready(function () {

    toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
        setTimeout('parent.windos_float_save_modal_hijo_hijo("llenarCajas();");', 1000);
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
