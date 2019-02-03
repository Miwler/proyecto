<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>EDITAR PRODUCTO<?php } ?>

<?php function fncHead(){?>
  
    <script type="text/javascript" src="include/js/jForm.js"></script>
   
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js"></script>
   
    <script type='text/javascript'>
    
    $(document).ready(function(){
        
      
        <?php if($GLOBALS['oSalida_Detalle']->componente==1){?>
             
             fncCargar_Orden_Venta_Componente();
            $('#ckComponente').prop('checked',true);
            $('#txtPrecioUnitarioDolares').prop('disabled', true);
            $('#txtPrecioUnitarioSoles').prop('disabled', true);
        <?php } ?>
        <?php if($GLOBALS['oSalida_Detalle']->adicional==1){?>
            $('#ckAdicional').prop('checked',true);
             
             fncCargar_Orden_Venta_Adicional();
        <?php } ?>
         <?php if($GLOBALS['oSalida_Detalle']->bloquear_edicion>0){?>
             bloquear_edicion();
         <?php }?>
            
    });
    </script>
    <style>
        #table_historial_compra tbody td,#table_historial_venta tbody td,#table_separaciones tbody td,#table_componente tbody td,#table_adicional tbody td{
            font-size:11px;
        }
    </style>
<?php } ?>

<?php function fncTitleHead(){?>EDITAR PRODUCTO<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['oSalida_Detalle']->tipo_ID==2||$GLOBALS['oSalida_Detalle']->tipo_ID==5||$GLOBALS['oSalida_Detalle']->tipo_ID==6){ ?>
<form id="frm1"  method="post"  action="Salida/Orden_Venta_Mantenimiento_Producto_Editar/<?php echo $GLOBALS['oSalida_Detalle']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#Productos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Producto</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divCostos" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i> <span>Costo</span></a></li>
                <li class="nav-item"><a href="#separaciones" data-toggle="tab"><i class="fa fa-clone"></i> <span>Separaciones</span></a></li>
                <li class="nav-item"><a href="#historial" data-toggle="tab"><i class="fa fa-calendar-o"></i> <span>Historial</span></a></li>
                <?php if($GLOBALS['oSalida_Detalle']->componente==1){?>
                <li class="nav-item"><a href="#componentes" data-toggle="tab"><i class="fa fa-cogs"></i> <span>Componentes</span></a></li>
                <?php } ?>
                <?php if($GLOBALS['oSalida_Detalle']->adicional==1){?>
                <li class="nav-item"><a href="#adicionales" data-toggle="tab"><i class="fa fa-cubes"></i> <span>Adicionales</span></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="panel-body rounded-bottom" style="height:300px;overflow:auto; ">
            
            <div class="tab-content">
                <div id="Productos" class="tab-pane fade in active inner-all">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label>Línea: </label>
                                    <input id='txtID' name='txtcotizacion_detalle_ID' value='<?php echo $GLOBALS['oSalida_Detalle']->ID;?>' style='display:none;' >
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="tdLinea">
                                    <select id="selLinea" name="selLinea" onchange="fncLinea();" class="form-control filtroLista chosen-select mb-15" >
                                        <option value="0">TODOS</option>
                                    <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
                                        <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                                    <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selLinea').val(<?php echo $GLOBALS['oSalida_Detalle']->linea_ID;?>);
                                    </script> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label>Categoría: </label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="tdCategoria">
                                    <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" class="form-control filtroLista chosen-select mb-15">
                                        <option value="0" selected>TODOS</option>
                                        <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
                                        <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                                        <?php } ?>
                                    </select> 
                                    <script type="text/javascript">
                                        $('#selCategoria').val(<?php echo $GLOBALS['oSalida_Detalle']->categoria_ID;?>);
                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label>Producto: </label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 lista_producto" id="tdProducto" >
                                    <input type="hidden" id="selProducto" name="selProducto" value="<?php echo $GLOBALS['oSalida_Detalle']->producto_ID;?>">
                                     <input type="text" id="listaProducto" class="form-control" value="<?php echo $GLOBALS['oSalida_Detalle']->oProducto->codigo." - ".$GLOBALS['oSalida_Detalle']->oProducto->nombre;?>">
                                    <script type="text/javascript">
                                       $(document).ready(function(){
                                        listar_productos();
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                   <div class="ckbox ckbox-theme">
                                        <input id="ckComponente"  name="ckComponente"  type="checkbox" value="1">
                                        <label for="ckComponente">Componente</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="ckbox ckbox-theme">
                                        <input id="ckAdicional"  name="ckAdicional"  type="checkbox" value="1">
                                        <label for="ckAdicional">Adicional</label>
                                    </div>

                                </div>   
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label>Stock: </label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 ">
                                     <input type="text" id="txtStock" name="txtStock" class="form-control desactivado" value="<?php echo $GLOBALS['oSalida_Detalle']->stock; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <label>Descripción: </label>
                        </div>
                        <div class="col-sm-12" id="tdComentario">
                            <textarea id="txtDescripcion" name="txtDescripcion" class="form-control text-uppercase comentario" rows="7" cols="40" maxlength="2000" style="height:100px;resize: none;overflow: auto;"><?php echo FormatTextView($GLOBALS['oSalida_Detalle']->descripcion);?></textarea>
                        </div>
                    </div>
                </div>
                <div id="divCostos" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="control-label col-lg-2 col-md-2 col-sm-2">Cantidad: </label>
                       <div class="col-lg-2 col-md-2 col-sm-2">
                           <input type="text" id="txtCantidad" name="txtCantidad" class="form-control form-requerido text-right int" autocomplete="off" value="<?php echo $GLOBALS['oSalida_Detalle']->cantidad;?>" onkeyup="ProductoValores();">
                       </div>
                        <label  class="control-label col-lg-3 col-md-3 col-sm-3">Precio Unitario(sin IGV):  </label>
                       <div class="col-lg-2 col-md-2 col-sm-2">
                           <input  type="text" id="txtPrecioUnitarioDolares" class="form-control moneda" autocomplete="off" name="txtPrecioUnitarioDolares" value="<?php echo $GLOBALS['oSalida_Detalle']->precio_venta_unitario_dolares;?>" onkeyup="calcularTipoCambio('2');" placeholder="US$." >
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-2">
                           <input type="text" id="txtPrecioUnitarioSoles" class="form-control moneda" autocomplete="off" name="txtPrecioUnitarioSoles" value="<?php echo $GLOBALS['oSalida_Detalle']->precio_venta_unitario_soles;?>" onkeyup="calcularTipoCambio('1');" placeholder="S/.">
                       </div>
                   </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2 col-md-2 col-sm-2">Tipo de IGV:</label>
                        <div class="col-lg-10 col-md-10 col-sm-10">
                            <select class="form-control" id="selImpuestos_Tipo" name="selImpuestos_Tipo" disabled>
                                <?php foreach($GLOBALS['dtImpuestos_Tipo'] as $valor){?>
                                <option value="<?php echo $valor['ID'];?>"><?php echo utf8_encode($valor['nombre']);?></option>
                                <?php } ?>
                            </select>
                            <script>
                                $("#selImpuestos_Tipo").val(<?php echo $GLOBALS['oSalida_Detalle']->impuestos_tipo_ID;?>);
                            </script>
                        </div>
                    </div>
                   <div class="form-group">
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <label>Dólares(US$): </label>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <label>Soles(S/.): </label>
                       </div>
                   </div>
                   
                    <input id="txtValIgv" name="txtValIgv" value="<?php echo $GLOBALS['oSalida']->igv;?>" style="display:none;">
                   <div class="form-group">
                        <div class="col-sm-12">
                            <table id="tbCostos" class="table table-bordered table-hover table-primary">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-center">Precio Compra</th>
                                        <th class="text-center">Sub Total</th>
                                        <th class="text-center">Adicional</th>
                                        <th class="text-center">Sub Total+</th>
                                        <th class="text-center">I.G.V. <?php echo $GLOBALS['oSalida']->igv*100;?>%:</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Dólares</th>
                                        <td class="text-right" >
                                            <label id="tdPrecioCompraDolares"></label>
                                            <input  type="hidden" id="txtPrecioCompraDolares" name="txtPrecioCompraDolares" class="form-control moneda desactivado" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdSubTotalDolares"><?php echo $GLOBALS['oSalida_Detalle']->precio_venta_subtotal_dolares;?></label>
                                            <input type="hidden" id="txtSubTotalDolares" name="txtSubTotalDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oSalida_Detalle']->precio_venta_subtotal_dolares;?>" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdAdicionalDolares"><?php echo $GLOBALS['oSalida_Detalle']->adicional_dolares;?></label>
                                            <input type="hidden" id="txtAdicionalDolares" name="txtAdicionalDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oSalida_Detalle']->adicional_dolares;?>" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdSubTotalDolares1"><?php echo $GLOBALS['oSalida_Detalle']->subtotal_dolares1;?></label>
                                            <input type="hidden" id="txtSubTotalDolares1" name="txtSubTotalDolares1" class="form-control moneda" value="<?php echo $GLOBALS['oSalida_Detalle']->subtotal_dolares1;?>" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdIgvDolares"><?php echo $GLOBALS['oSalida_Detalle']->vigv_dolares;?></label>
                                             <input type="hidden" id="txtIgvDolares" name="txtIgvDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oSalida_Detalle']->vigv_dolares;?>" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdTotalDolares"><?php echo $GLOBALS['oSalida_Detalle']->precio_venta_dolares;?></label>
                                            <input type="hidden" id="txtTotalDolares" name="txtTotalDolares" class="form-control moneda" value="<?php echo $GLOBALS['oSalida_Detalle']->precio_venta_dolares;?>" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Soles</th>
                                        <td class="text-right" >
                                            <label id="tdPrecioCompraSoles"></label>
                                            <input type="hidden" id="txtPrecioCompraSoles" name="txtPrecioCompraSoles" class="form-control moneda desactivado" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdSubTotalSoles"><?php echo $GLOBALS['oSalida_Detalle']->precio_venta_subtotal_soles;?></label>
                                            <input type="hidden" id="txtSubTotalSoles" name="txtSubTotalSoles" class="form-control moneda"  value="<?php echo $GLOBALS['oSalida_Detalle']->precio_venta_subtotal_soles;?>" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdAdicionalSoles"><?php echo $GLOBALS['oSalida_Detalle']->adicional_soles;?></label>
                                            <input type="hidden" id="txtAdicionalSoles" name="txtAdicionalSoles" class="form-control moneda" value="<?php echo $GLOBALS['oSalida_Detalle']->adicional_soles;?>" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdSubTotalSoles1"><?php echo $GLOBALS['oSalida_Detalle']->subtotal_soles1;?></label>
                                            <input type="hidden" id="txtSubTotalSoles1" name="txtSubTotalSoles1" class="form-control moneda" value="<?php echo $GLOBALS['oSalida_Detalle']->subtotal_soles1;?>" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdIgvSoles"><?php echo $GLOBALS['oSalida_Detalle']->vigv_soles;?></label>
                                            <input type="hidden" id="txtIgvSoles" name="txtIgvSoles" class="form-control moneda" value="<?php echo $GLOBALS['oSalida_Detalle']->vigv_soles;?>" disabled>
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdTotalSoles"><?php echo $GLOBALS['oSalida_Detalle']->precio_venta_soles;?></label>
                                            <input type="hidden" id="txtTotalSoles" name="txtTotalSoles" class="form-control moneda" value="<?php echo $GLOBALS['oSalida_Detalle']->precio_venta_soles;?>" disabled>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade inner-all divCuerpo" id="separaciones">
                    <h4>Separaciones de producto</h4>
                    <table id="table_separaciones" class='table table-hover table-bordered table-teal'><thead>
                        <tr><th>N°Cotizaci&oacute;n</th><th>Fecha</th><th>Cant. Comprada</th><th>Cant. Separada</th><th >Responsable</th></tr>
                    </thead>
                    <tbody>
                    </table>
                </div>
                <div class="tab-pane fade inner-all divCuerpo" id="historial">
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
                <div class="tab-pane fade inner-all divCuerpo" id="componentes">
                    <?php if($GLOBALS['oSalida_Detalle']->componente==1){?>
                    <button  id="btnComponente" name="btnComponente" type="button" title="Agregar Componentes" onclick="fncNuevoComponente();"  class="btn btn-info" >
                        <span class="glyphicon glyphicon-plus"></span> Agregar
                     </button>  
                    <?php } ?>
                    
                    <div id="divComponentes">
                        <table id="table_componente" class='table table-hover table-bordered table-responsive table-teal'>
                            <thead>
                                <th>Código</th>
                                <th>Componente</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Sub Total</th>
                                <th>Op</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade inner-all divCuerpo" id="adicionales">
                    <?php if($GLOBALS['oSalida_Detalle']->adicional==1){?>
                    <button  id="btnAdicional" name="btnAdicional" type="button" title="Agregar Adicionales" onclick="fncNuevoAdicional();"  class="btn btn-info" >
                        <span class="glyphicon glyphicon-plus"></span> Agregar
                     </button>  
                    <?php } ?>
                    <div id="divAdicionales">
                        <table id="table_adicional" class='table table-hover table-bordered table-responsive table-teal'>
                            <thead>
                                <th>Código</th>
                                <th>Adicional</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Sub Total</th>
                                <th>Op</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Guardar">
                        <img width="14"  alt="" src="/include/img/boton/save_48x48.png">
                       Guardar
                    </button>
                    <button id="btnRegresar1" type="button" class="btn btn-warning" onclick="parent.windos_float_save_modal_hijo();" title="Regresar">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                            Regresar
                    </button>   
                </div>

            </div>
        </div>
    </div>
   
</form>
<script type="text/javascript">
    
    $(document).ready(function(){
        fncCargarPrecioCompra(<?php echo $GLOBALS['oSalida_Detalle']->producto_ID;?>);
    });
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
        var componente=0;
        if($('#ckComponente').prop('checked')){
            componente=1;
        }
        var adicional=0;
        if($('#ckAdicional').prop('checked')){
            adicional=1;
        }
        var cantidad= $.trim($('#txtCantidad').val());
        var PrecioUnitarioSoles=$.trim($('#txtPrecioUnitarioSoles').val()).split(',').join('');
        var PrecioUnitarioDolares=$.trim($('#txtPrecioUnitarioDolares').val()).split(',').join('');
        
        
        if(producto_ID==0){
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
       
        
       
        var precioCompraUnitarioDolares=$('#txtPrecioCompraDolares').val();
        if(componente==0){
            if(precioCompraUnitarioDolares*1>=PrecioUnitarioDolares*1){
               if(Resultado_verificar==0){
                    mensaje_validacion();
                    return false;
               }
            }
        }else {
            $('#txtPrecioUnitarioSoles').prop('disabled', false);
            $('#txtPrecioUnitarioDolares').prop('disabled', false);
        }
         if(componente==0){
            if(isNaN(PrecioUnitarioSoles)||PrecioUnitarioSoles==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario (S/.).','txtPrecioUnitarioDolares');
                $('.nav-tabs a[href="#divCostos"]').tab('show');
               
                return false;   
            }
             if(isNaN(PrecioUnitarioDolares)||PrecioUnitarioDolares==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario ($).','txtPrecioUnitario');
                $('.nav-tabs a[href="#divCostos"]').tab('show');
                
                return false;   
            }
        }
        $('#txtSubTotalSoles').removeAttr('disabled');
        $('#txtSubTotalDolares').removeAttr('disabled');
        $('#txtIgvSoles').removeAttr('disabled');
        $('#txtIgvDolares').removeAttr('disabled');
        $('#txtTotalSoles').removeAttr('disabled');
        $('#txtTotalDolares').removeAttr('disabled');
        $("#selImpuestos_Tipo").removeAttr('disabled');
       block_ui();

   }
    var llenarCajas=function(){
       var orden_venta_detalle_ID=$('#txtID').val();
       cargarValores('Salida/ajaxLlenarCajas',orden_venta_detalle_ID, function(resultado){
           if(resultado.resultado==1){

               $('#txtPrecioUnitarioDolares').val(resultado.precio_venta_unitario_dolares);
               $('#txtSubTotalDolares').val(resultado.precio_venta_subtotal_dolares);
               $('#txtSubTotalDolares1').val(resultado.precio_venta_subtotal_dolares1);
               $('#txtIgvDolares').val(resultado.vigv_dolares);
               $('#txtTotalDolares').val(resultado.precio_venta_dolares);
               $('#txtAdicionalDolares').val(resultado.adicional_dolares);
               $('#txtAdicionalSoles').val(resultado.adicional_soles);
               $('#txtPrecioUnitarioSoles').val(resultado.precio_venta_unitario_soles);
               $('#txtSubTotalSoles1').val(resultado.precio_venta_subtotal_soles1);
               $('#txtSubTotalSoles').val(resultado.precio_venta_subtotal_soles);
               $('#txtIgvSoles').val(resultado.vigv_soles);
               $('#txtTotalSoles').val(resultado.precio_venta_soles);

           }else {
               toastem.error(resultado.mensaje);
           }
       });
   }

   var fncNuevoComponente=function(){
        var id=$('#txtID').val();
        parent.window_float_open_modal_hijo_hijo("AGREGAR NUEVO COMPONENTE","/Salida/Orden_Venta_Mantenimiento_Registro_Componente_Nuevo",id,"",fncCargar_Orden_Venta_Componente,700,500);
        

    }
    var fncEditarComponente=function(id){
        parent.window_float_open_modal_hijo_hijo("EDITAR COMPONENTE","/Salida/Orden_Venta_Mantenimiento_Registro_Componente_Editar",id,"",fncCargar_Orden_Venta_Componente,700,500);
        
    }
    var fncVerComponente=function(id){
        parent.window_float_open_modal_hijo_hijo("VER COMPONENTE","/Salida/Orden_Venta_Mantenimiento_Registro_Componente_Editar",id,"",fncCargar_Orden_Venta_Componente,700,500);
        
    }
    var fncSeriesComponente=function(id){
         parent.window_float_open_modal_hijo_hijo("REGISTRAR SERIE DE LOS COMPONENTES","/Salida/Orden_Venta_Mantenimiento_Producto_Serie_hijo",id,"",fncCargar_Orden_Venta_Componente,700,540);
        

    }
    var fncEliminarComponente=function(id){
        cargarValores('/Salida/ajaxOrden_Venta_Mantenimiento_Registro_Componente_Eliminar',id,function(resultado){
            if(resultado.resultado==1){
                fncCargar_Orden_Venta_Componente("llenarCajas();");
                toastem.info(resultado.mensaje);
            }else { 
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
            }
        });
    }
   
    var fncCargar_Orden_Venta_Componente=function(callbackfunction){
        
        var orden_venta_detalle_ID=$('#txtID').val();
        
        cargarValores('Salida/ajaxOrden_Venta_Mantenimiento_Registro_Componente',orden_venta_detalle_ID,function(resultado){
            
           $('#table_componente tbody').html(resultado.html);
           
           
        });
        if(callbackfunction){
            setTimeout(callbackfunction, 200);
        }
    }
   
    var fncNuevoAdicional=function(){
        var orden_venta_detalle_ID=$('#txtID').val();
       
        parent.window_float_open_modal_hijo_hijo("NUEVO PRODUCTO ADICIONAL","/Salida/Orden_Venta_Mantenimiento_Registro_Adicional_Nuevo",orden_venta_detalle_ID,"",fncCargar_Orden_Venta_Adicional,700,500);
        
    }
    var fncEditarAdicional=function(id){
        parent.window_float_open_modal_hijo_hijo("EDITAR PRODUCTO ADICIONAL","/Salida/Orden_Venta_Mantenimiento_Registro_Adicional_Editar",id,"",fncCargar_Orden_Venta_Adicional,700,500);
    }
    var fncVerAdicional=function(id){
        parent.window_float_open_modal_hijo_hijo("VER PRODUCTO ADICIONAL","/Salida/Orden_Venta_Mantenimiento_Registro_Adicional_Editar",id,"",fncCargar_Orden_Venta_Adicional,700,500);
    }
    var fncSeriesAdicional=function(id){
        parent.window_float_open_modal_hijo_hijo("REGISTRAR SERIE DE LOS ADICIONALES","/Salida/Orden_Venta_Mantenimiento_Producto_Serie_hijo",id,"",fncCargar_Orden_Venta_Adicional,700,540);

    } 
    var fncEliminarAdicional=function(id){
        cargarValores('/Salida/ajaxOrden_Venta_Mantenimiento_Registro_Adicional_Eliminar',id,function(resultado){
                if(resultado.resultado==1){
                    fncCargar_Orden_Venta_Adicional(llenarCajas);
                    //fncDesactivarBtnDetalle();
                    toastem.info(resultado.mensaje);
                }else {
                    toastem.error(resultado.mensaje);
                }
            }); 
    }
     var fncCargar_Orden_Venta_Adicional=function(callbackfunction){
        var orden_venta_detalle_ID=$('#txtID').val();
       
        cargarValores('Salida/ajaxOrden_Venta_Mantenimiento_Registro_Adicional',orden_venta_detalle_ID,function(resultado){
            $('#table_adicional tbody').html(resultado.html);
            //fncSeleccionarDetalle();
        });
        if(callbackfunction){
            setTimeout(callbackfunction, 200);
        }
    }
    
   var fncValidarAutorizacion=function(){
       var resultado=0;
       var valor=$('#txtContrasena').val();
       cargarValores('/Salida/ajaxValidarCostoCompraMenor',valor,function(resultado){
           Resultado_verificar=resultado.resultado;

           if(resultado.resultado==-1){
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
           }else if(resultado.resultado==0){
               toastem.advertencia('Contraseña incorrecta');
           }
           else {
               $( "#frm1" ).submit();
               
           }
       });

   }
   

    var fncCancelarAutorizacion=function(){
        Resultado_verificar=0;
        $('#txtPrecioUnitarioDolares').focus();
    }

      var fncHistoriaProducto=function(producto_ID){
        cargarValores('/Funcion/ajaxHistorial_Producto',producto_ID,function(resultado){
            
            $('#table_historial_compra tbody').html(resultado.filas_compras); 
            $('#table_historial_venta tbody').html(resultado.filas_ventas); 
        });
    }

   var fncTiempo_Separacion=function(){
       if($('#ckSeparacion').is(':checked')){
           $('#txtTiempo_Separacion').removeAttr('disabled');
           $('#txtTiempo_Separacion').focus();

       }else {
           $('#txtTiempo_Separacion').attr('disabled','disabled');
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
                
               
            });
        }else{
            fncLimpiar();
        }
    }

   var fncCargarPrecioCompra=function(producto_ID){
   
         cargarValores('/Ingreso/ajaxPrecio_ingreso',producto_ID,function(resultado){
           $('#txtPrecioCompraDolares').val(resultado.precio_compra_dolares); 
           $('#txtPrecioCompraSoles').val(resultado.precio_compra_soles);
           $("#tdPrecioCompraDolares").text(resultado.precio_compra_dolares);
           $("#tdPrecioCompraSoles").text(resultado.precio_compra_soles);
           
           if(resultado.resultado==-1){
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
                
           }
          
           VerSeparaciones(resultado.producto_ID);
       });
    } 


   function calcularTipoCambio(tipo){
       var tipo_cambio=<?php echo $GLOBALS['oSalida']->tipo_cambio; ?>;
       if(tipo=="1"){
           var valorSoles=$('#txtPrecioUnitarioSoles').val().split(',').join('')*1;
           var valorDolares=redondear(parseFloat(valorSoles)/tipo_cambio,2);
           $('#txtPrecioUnitarioDolares').val(valorDolares);
       }else{
           var valorDolares=$('#txtPrecioUnitarioDolares').val().split(',').join('')*1;
           var valorSoles=redondear(parseFloat(valorDolares)*tipo_cambio,2);
           $('#txtPrecioUnitarioSoles').val(valorSoles);
       }
       ProductoValores();
   }
   function ProductoValores(){   
       var caja1=$('#txtCantidad').val();
       var caja2=$('#txtPrecioUnitarioSoles').val().split(',').join('');
       var caja3=$('#txtPrecioUnitarioDolares').val().split(',').join('');
         if($.trim(caja1)==""){
             var valor1=0;
         } else {valor1=parseInt(caja1);}

         if($.trim(caja3)==""){
              var valor3=0;
         }else {
             valor3=parseFloat(caja3);

            }
       if($.trim(caja2)==""){
         var valor2=0;
       }else {
           valor2=caja2;

       }
        var resultadoSoles=redondear(valor1*valor2,2);
        if(isNaN(resultadoSoles)==false){ 
        $('#txtSubTotalSoles').val(resultadoSoles); 
        }else{
            $('#txtSubTotalSoles').val('--');
        }
         var resultadoDolares=redondear(valor1*valor3,2);

         if(isNaN(resultadoDolares)==false){
             $('#txtSubTotalDolares').val(resultadoDolares);
         }else{
             $('#txtSubTotalDolares').val('--');
         }


         calcularIGV();    

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
   var fncLimpiar=function(){
       $('#txtPrecioCompraDolares').val('');
       $('#txtPrecioCompraSoles').val('');
       $('#tdPrecioCompraDolares').html('');
       $('#tdPrecioCompraSoles').html('');
       
       $('#txtDescripcion').val('');
       $('#txtStock').val('');
       $("#selProducto").val('');
        $("#table_historial_compra tbody").html('');
        $("#table_historial_venta tbody").html('');
        $("#table_separaciones tbody").html('');
   }
   $('#ckComponente').click(function(){
       if($(this).prop('checked')){
           $('#txtPrecioUnitarioDolares').prop('disabled', true);
           $('#txtPrecioUnitarioDolares').val(0);
           $('#txtPrecioUnitarioSoles').prop('disabled', true);
           $('#txtPrecioUnitarioSoles').val(0);
           $('#txtSubTotalDolares').val(0);
           $('#txtIgvDolares').val(0);
           $('#txtTotalDolares').val(0);
           $('#txtSubTotalSoles').val(0);
           $('#txtIgvSoles').val(0);
           $('#txtTotalSoles').val(0);



       }else {

           var contador=0;
           $('#divComponente .item-tr').each(function(){
               contador++;
           });

           if(contador==0){
               $('#txtPrecioUnitarioDolares').prop('disabled', false);
               $('#txtPrecioUnitarioDolares').val('');
               $('#txtPrecioUnitarioSoles').prop('disabled', false);
               $('#txtPrecioUnitarioSoles').val('');
               $('#txtSubTotalDolares').val('');
               $('#txtIgvDolares').val('');
               $('#txtTotalDolares').val('');
               $('#txtSubTotalSoles').val('');
               $('#txtIgvSoles').val('');
               $('#txtTotalSoles').val('');
               if($('#txtStock').val()>0){
                   $('#ckSeparacion').prop('disabled', false);
                   $('#txtTiempo_Separacion').prop('disabled', false);
               }

           }else {
               if($('#ckSeparacion').prop('checked')){
                   toastem.error('No puede separar el producto, tiene componentes internos');

               }
               $(this).prop('checked', true);
               toastem.error('El producto tiene componentes, debes eliminarlos para seleccionar que no tiene componente. ');
           }
       }
   });
   $('#ckAdicional').click(function(){
       if($(this).prop('checked')){

       }else {
           var contador=0;
           $('#divAdicional .item-tr').each(function(){
               contador++;
           });
           if(contador>0){
              $(this).prop('checked', true);
               toastem.error('El producto tiene productos adicionales, debes eliminarlos para seleccionar que no tiene adicional. ');

           }
       }
   });
   var bloquear_edicion=function(){
       $('#selLinea').prop('disabled',true);
       $('#selCategoria').prop('disabled', true);
       $('#selProducto').prop('disabled', true);
       $('#ckComponente').prop('disabled', true);
       $('#ckAdicional').prop('disabled', true);
       $('#txtDescripcion').prop('disabled', true);
       $('#txtCantidad').prop('disabled', true);
       $('#txtPrecioUnitarioDolares').prop('disabled', true);
       $('#txtPrecioUnitarioSoles').prop('disabled', true);
       $('#btnEnviar').remove();
       $('#btnEliminar').remove();
       $('#btnComponente').css('display','none');
       $('#btnAdicional').css('display','none');
   }
   </script>
 
 <?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
           // alert('-1');
       $('#divMensaje').html('<?php echo $GLOBALS['mensaje'];?>');
       // setTimeout('window_float_save();', 1000);
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

<script type="text/javascript">
 //alert('hola');
 $(document).ready(function () {

    toastem.success('<?php echo $GLOBALS['mensaje'];?>');
});
<?php if($GLOBALS['oSalida_Detalle']->tipo_ID==1){ ?>
setTimeout('parent.windos_float_save_modal_hijo("crear_boton_factura();");', 1000);
<?php } ?>
 
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
