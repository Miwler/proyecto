<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>EDITAR PRODUCTO<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js"></script>
    <script type='text/javascript'>
    $(document).ready(function(){
//        fncCargarPrecioCompra(<?php echo $GLOBALS['oCotizacion_Detalle']->producto_ID;?>);
        <?php if($GLOBALS['oCotizacion_Detalle']->componente==1){?>
            fncCargar_Cotizacion_Componente();
            $('#ckComponente').prop('checked',true);
            $('#txtPrecioUnitarioDolares').prop('disabled', true);
            $('#txtPrecioUnitarioSoles').prop('disabled', true);
        <?php } ?>
        <?php if($GLOBALS['oCotizacion_Detalle']->adicional==1){?>
            $('#ckAdicional').prop('checked',true);
            
             fncCargar_Cotizacion_Adicional();
        <?php } ?>
            <?php if($GLOBALS['oCotizacion']->estado_ID==25){?>
                bloquear();
            <?php } ?>

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
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['oCotizacion_Detalle']->tipo_ID==2||$GLOBALS['oCotizacion_Detalle']->tipo_ID==5||$GLOBALS['oCotizacion_Detalle']->tipo_ID==6){ ?>
<form id="frm1"  method="post" action="Salida/Cotizacion_Mantenimiento_Producto_Editar/<?php echo $GLOBALS['oCotizacion_Detalle']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#Productos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Producto</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divCostos" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i> <span>Costo</span></a></li>
                <li class="nav-item"><a href="#separaciones" data-toggle="tab"><i class="fa fa-clone"></i> <span>Separaciones</span></a></li>
                <li class="nav-item"><a href="#historial" data-toggle="tab"><i class="fa fa-calendar-o"></i> <span>Historial</span></a></li>
                <?php if($GLOBALS['oCotizacion_Detalle']->componente==1){?>
                <li class="nav-item"><a href="#componentes" data-toggle="tab"><i class="fa fa-cogs"></i> <span>Componentes</span></a></li>
                <?php } ?>
                <?php if($GLOBALS['oCotizacion_Detalle']->adicional==1){?>
                <li class="nav-item"><a href="#adicionales" data-toggle="tab"><i class="fa fa-cubes"></i> <span>Adicionales</span></a></li>
                <?php } ?>
            </ul>
            <div class="pull-right">
                <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Guardar">
                        <img width="14"  alt="" src="/include/img/boton/save_48x48.png">
                       Guardar
                    </button>
                     <button id="btnRegresar1" type="button" class="btn btn-danger" onclick="parent.windos_float_save_modal_hijo();" title="Regresar">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                            Regresar
                    </button>
            </div>
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height:450px;overflow:auto; ">
           
            <div class="tab-content">
                <div id="Productos" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Línea: </label>
                            <input id='txtID' name='txtcotizacion_detalle_ID' value='<?php echo $GLOBALS['oCotizacion_Detalle']->ID;?>' style='display:none;' >
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="tdLinea">
                            <select id="selLinea" name="selLinea" onchange="fncLinea();" class="form-control filtroLista" >
                                <option value="0">TODOS</option>
                            <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
                                <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                            <?php } ?>
                            </select>
                            <script type="text/javascript">
                                $('#selLinea').val(<?php echo $GLOBALS['oCotizacion_Detalle']->linea_ID;?>);
                            </script> 
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Categoría: </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="tdCategoria">
                            <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" class="form-control filtroLista">
                                <option value="0" selected>TODOS</option>
                                <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
                                <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                                <?php } ?>
                            </select> 
                            <script type="text/javascript">
                                $('#selCategoria').val(<?php echo $GLOBALS['oCotizacion_Detalle']->categoria_ID;?>);
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Producto: </label>
                        </div>
                        <div class="col-sm-7 lista_producto" id="tdProducto" >
                            <input type="hidden" id="selProducto" name="selProducto" value="<?php echo $GLOBALS['oCotizacion_Detalle']->producto_ID;?>">
                            <input type="text" id="listaProducto" class="form-control" value="<?php echo $GLOBALS['oCotizacion_Detalle']->oProducto->nombre;?>">
                            <script type="text/javascript">
                            $(document).ready(function(){
                                listar_productos();
                            });
                            </script>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" placeholder="Código" autocomplete="off" value="<?php echo $GLOBALS['oCotizacion_Detalle']->oProducto->codigo;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Descripción: </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="tdComentario">
                            <textarea id="txtDescripcion" name="txtDescripcion" class="form-control  comentario" rows="7" cols="40" maxlength="2000" style="height:120px;overflow:auto;resize:none;"><?php echo $GLOBALS['oCotizacion_Detalle']->descripcion;?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                             <div class="ckbox ckbox-theme">
                                <input id="ckComponente"  name="ckComponente"  type="checkbox" value="1">
                                <label for="ckComponente">Componente</label>
                            </div> 
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <div class="ckbox ckbox-theme">
                                <input id="ckAdicional"  name="ckAdicional"  type="checkbox" value="1">
                                <label for="ckAdicional">Adicional</label>
                            </div>
                            
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                           <div class="ckbox ckbox-theme">
                                <input id="ckSeparacion"  name="ckSeparacion"  type="checkbox" value="1">
                                <label for="ckSeparacion">Separar producto</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Tiempo (días): </label>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                             <input type="number" name="txtTiempo_Separacion" disabled id="txtTiempo_Separacion" value="1" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Stock: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtStock" name="txtStock" class="form-control desactivado" value="<?php echo $GLOBALS['oInventario']->stock; ?>" disabled>
                        </div>
                    </div>
                </div>
                <div id="divCostos" class="tab-pane fade inner-all">
                    <div class="form-group">
                       <div class="col-sm-2">
                           <label>Cantidad: </label>
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                           <input type="text" id="txtCantidad" name="txtCantidad" class="form-control form-requerido text-right int" autocomplete="off" value="<?php echo $GLOBALS['oCotizacion_Detalle']->cantidad;?>" onkeyup="ProductoValores();">
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                          <label>Precio Unitario: </label>
                       </div>
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input  type="text" id="valor_unit_dolares_registrado" name="valor_unit_dolares_registrado" class="form-control moneda_redondeo" autocomplete="off"  value="<?php echo $GLOBALS['oCotizacion_Detalle']->valor_unit_dolares_registrado;?>" onkeyup="calcularTipoCambio('2');" placeholder="US$." >
                            <input  type="hidden" id="txtPrecioUnitarioDolares" name="txtPrecioUnitarioDolares" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_unitario_dolares;?>">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input type="text" id="valor_unit_soles_registrado" name="valor_unit_soles_registrado"  class="form-control moneda_redondeo" autocomplete="off" value="<?php echo $GLOBALS['oCotizacion_Detalle']->valor_unit_soles_registrado;?>" onkeyup="calcularTipoCambio('1');" placeholder="S/.">
                            <input type="hidden" id="txtPrecioUnitarioSoles" name="txtPrecioUnitarioSoles" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_unitario_soles;?>" onkeyup="calcularTipoCambio('1');" placeholder="S/.">
                        </div>
                        <div class="col-sm-2">
                            <div class="ckbox ckbox-teal">
                                <input id="ckIncluyeIgv" name="ckIncluyeIgv" onclick="ProductoValores();" <?php echo (($GLOBALS['oCotizacion_Detalle']->incluye_igv==1)?"checked":"");?> type="checkbox">
                                <label for="ckIncluyeIgv">Inc. IGV</label>
                            </div>
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
                   <div class="form-group">
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <label>Precio compra: </label>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input  type="text" id="txtPrecioCompraDolares" name="txtPrecioCompraDolares" class="form-control moneda desactivado" disabled>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtPrecioCompraSoles" name="txtPrecioCompraSoles" class="form-control moneda desactivado" disabled>
                       </div>
                   </div>

                   <div class="form-group">
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <label>Sub Total: </label>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtSubTotalDolares" name="txtSubTotalDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_subtotal_dolares;?>" disabled>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtSubTotalSoles" name="txtSubTotalSoles" class="form-control moneda"  value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_subtotal_soles;?>" disabled>
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <label>Adicional: </label>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtAdicionalDolares" name="txtAdicionalDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oCotizacion_Detalle']->adicional_dolares;?>" disabled>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtAdicionalSoles" name="txtAdicionalSoles" class="form-control moneda" value="<?php echo $GLOBALS['oCotizacion_Detalle']->adicional_soles;?>" disabled>
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <label>Sub Total+: </label>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtSubTotalDolares1" name="txtSubTotalDolares1" class="form-control moneda" value="<?php echo $GLOBALS['oCotizacion_Detalle']->subtotal_dolares1;?>" disabled>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtSubTotalSoles1" name="txtSubTotalSoles1" class="form-control moneda" value="<?php echo $GLOBALS['oCotizacion_Detalle']->subtotal_soles1;?>" disabled>
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <label>I.G.V. <?php echo $GLOBALS['oCotizacion']->igv*100;?>%: </label>
                           <input id="txtValIgv" name="txtValIgv" value="<?php echo $GLOBALS['oCotizacion']->igv;?>" style="display:none;">
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtIgvDolares" name="txtIgvDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oCotizacion_Detalle']->vigv_dolares;?>" disabled>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtIgvSoles" name="txtIgvSoles" class="form-control moneda" value="<?php echo $GLOBALS['oCotizacion_Detalle']->vigv_soles;?>" disabled>
                       </div>
                   </div>
                   <div class="form-group">
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <label>Total: </label>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtTotalDolares" name="txtTotalDolares" class="form-control moneda" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_dolares;?>" disabled>
                       </div>
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                           <input type="text" id="txtTotalSoles" name="txtTotalSoles" class="form-control moneda" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_soles;?>" disabled>
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
                    <div class="row" >
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
                            <table class='table table-hover table-responsive table-teal' id="table_historial_venta" >
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
                    <?php if($GLOBALS['oCotizacion_Detalle']->componente==1){?>
                    <button  id="btnComponente" name="btnComponente" type="button" title="Agregar Componentes" onclick="fncNuevoComponente();"  class="btn btn-info" >
                        <span class="glyphicon glyphicon-plus"></span> Agregar
                     </button>  
                    <?php } ?>
                    
                    <div id="divComponentes">
                    </div>
                </div>
                <div class="tab-pane fade divCuerpo" id="adicionales">
                    <?php if($GLOBALS['oCotizacion_Detalle']->adicional==1){?>
                    <button  id="btnAdicional" name="btnAdicional" type="button" title="Agregar Adicionales" onclick="fncNuevoAdicional();"  class="btn btn-info" >
                        <span class="glyphicon glyphicon-plus"></span> Agregar
                     </button>  
                    <?php } ?>
                    <div id="divAdicionales">
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
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
    $(document).ready(function(){
        fncCargarPrecioCompra(<?php echo $GLOBALS['oCotizacion_Detalle']->oProducto->ID;?>);
        //fncProducto(<?php echo $GLOBALS['oCotizacion_Detalle']->oProducto->ID;?>);

    });
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
            return false;
        }

        //Verifico si el comprobante requiere serie y número
        if(isNaN(cantidad)||cantidad==""){
            
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre una cantidad.','txtCantidad');
            $('.nav-tabs a[href="#divCostos"]').tab('show');
            return false;   
        }
        if(componente==0){
            if(isNaN(PrecioUnitarioSoles)||PrecioUnitarioSoles==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario (S/.).','txtPrecioUnitarioDolares');
                return false;   
            }
             if(isNaN(PrecioUnitarioDolares)||PrecioUnitarioDolares==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario ($).','txtPrecioUnitario');
                return false;   
            }
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
        
        $('#txtSubTotalSoles').removeAttr('disabled');
        $('#txtSubTotalDolares').removeAttr('disabled');
        $('#txtIgvSoles').removeAttr('disabled');
        $('#txtIgvDolares').removeAttr('disabled');
        $('#txtTotalSoles').removeAttr('disabled');
        $('#txtTotalDolares').removeAttr('disabled');
        block_ui();
        
    }
    var llenarCajas=function(){
        var cotizacion_detalle_ID=$('#txtID').val();
        cargarValores('Salida/ajaxCotizacionLlenarCajas',cotizacion_detalle_ID, function(resultado){
            //console.log(resultado);
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
       parent.window_float_open_modal_hijo_hijo("AGREGAR NUEVO COMPONENTE","/Salida/Cotizacion_Mantenimiento_Registro_Componente_Nuevo",id,"",fncCargar_Cotizacion_Componente,700,480);

    }

    var fncEditarComponente=function(id){
         parent.window_float_open_modal_hijo_hijo("EDITAR COMPONENTE","/Salida/Cotizacion_Mantenimiento_Registro_Componente_Editar",id,"",fncCargar_Cotizacion_Componente,700,480);
    }
    var fncEliminarComponente=function(id){
        cargarValores('/Salida/ajaxCotizacion_Mantenimiento_Registro_Componente_Eliminar',id,function(resultado){
                if(resultado.resultado==1){
                    fncCargar_Cotizacion_Componente(llenarCajas);
                    toastem.info(resultado.mensaje);
                }else { 
                    mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
                }
            });
    }
     var fncNuevoAdicional=function(){
        var id=$('#txtID').val();
        parent.window_float_open_modal_hijo_hijo("AGREGAR COMPONENTE","/Salida/Cotizacion_Mantenimiento_Registro_Adicional_Nuevo",id,"",fncCargar_Cotizacion_Adicional,700,600);

    }
    var fncEditarAdicional=function(id){
        parent.window_float_open_modal_hijo_hijo("EDITAR ADICIONAL","/Salida/Cotizacion_Mantenimiento_Registro_Adicional_Editar",id,"",fncCargar_Cotizacion_Adicional,700,530);

        
    }
    var fncEliminarAdicional=function(id){
        cargarValores('/Salida/ajaxCotizacion_Mantenimiento_Registro_Adicional_Eliminar',id,function(resultado){
                if(resultado.resultado==1){
                    fncCargar_Cotizacion_Adicional(llenarCajas);
                    //fncDesactivarBtnDetalle();
                    toastem.info(resultado.mensaje);
                }else {
                    toastem.error(resultado.mensaje);
                }
            }); 
    }
    var fncCargar_Cotizacion_Componente=function(callbackfunction){
        
        var cotizacion_detalle_ID=$('#txtID').val();
        $('#divComponentes').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
        cargarValores('Salida/ajaxCotizacion_Mantenimiento_Registro_Componente',cotizacion_detalle_ID,function(resultado){
           
            $('#divComponentes').html(resultado.html);
           
           
        });
        if(callbackfunction){
            setTimeout(callbackfunction, 200);
        }
    }
    var fncCargar_Cotizacion_Adicional=function(callbackfunction){
        var cotizacion_detalle_ID=$('#txtID').val();
        $('#divAdicionales').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
        cargarValores('Salida/ajaxCotizacion_Mantenimiento_Registro_Adicional',cotizacion_detalle_ID,function(resultado){
            $('#divAdicionales').html(resultado.html);
          
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
                alert(resultado.mensaje);
            }else if(resultado.resultado==0){
                $('#lbMensaje').html('Contraseña incorrecta');
                $('#fondo_mensaje').css('display','block'); 
            }
            else {
                $( "#frm1" ).submit();
                $('#fondo_mensaje').css('display','none'); 
            }
        });
       
    }
    
    var fncCancelarAutorizacion=function(){
        Resultado_verificar=0;
        $('#txtPrecioUnitarioDolares').focus();
        $('#lbMensaje').html('');
        $('#fondo_mensaje').css('display','none');
        
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
        var categoria_ID = $('#selCategoria').val();
        var linea_ID=$('#selLinea').val();
       
        cargarValores1("/Funcion/ajaxListar_Productos",linea_ID,categoria_ID,function(resultado){
           
            if(resultado.resultado==1){
                $("#selProducto").html(resultado.html);
                $("#selProducto").trigger("chosen:updated");
            }else{
                mensaje.error("Mensaje de error",resultado.mensaje);
            }
        });
       
       

    }
 var listar_productos=function(){
        lista_producto('/funcion/ajaxListarProductos','listaProducto','selProducto',$("#selLinea").val(),$("#selCategoria").val(),fncProducto,fncLimpiar);
    }
   var fncProducto=function(producto_ID){
        //var producto_ID=$("#selProducto").val();
        if(producto_ID>0){
            //$('#tbdocumentos').html('<div style="background:#000;opacity:0.7;width:100%;height:100%;text-align:center;" ><img width="80px" src="/include/img/loader-Login.gif"></div>');
            cargarValores('/Funcion/ajaxSeleccionar_Producto1',producto_ID,function(resultado){
                //$('#selLinea').val(resultado.linea_ID); 
                //$('#selCategoria').val(resultado.categoria_ID);
                //$('#selProducto').val(resultado.producto_ID);
                if(resultado.resultado==1){
                    $("#selLinea").val(resultado.linea_ID);
                    $("#selCategoria").html(resultado.html);
                    $("#selLinea").trigger("chosen:updated");
                    $("#selCategoria").trigger("chosen:updated");
                    $('#txtStock').val(resultado.stock);
                    $('#txtDescripcion').val(resultado.descripcion);
                    $('#txtCodigo').val(resultado.codigo);
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
function buscarProducto(codigo){
        if($.trim(codigo)==""){
            toastem.error("Debe registrar un código.");
            return false;
        }
        $("#listaProducto").val('');
        $("#selProducto").val(0);
        $("#selLinea").val(0);
        $("#selCategoria").val(0);
        fncLimpiar();
        
        cargarValores('/funcion/ajaxBuscarProductos',codigo,function(resultado){
            if(resultado.resultado==0){
                toastem.error("No existe el producto");
                $("#selLinea").trigger("chosen:updated");
                $("#selCategoria").trigger("chosen:updated");
                
            }else if(resultado.resultado==1){
                 $("#listaProducto").val(resultado.producto);
                 $("#selProducto").val(resultado.producto_ID);
                 fncProducto(resultado.producto_ID);
            }else{
                 toastem.error("Ocurrió un error en el sistema.");
            }
           
        });
   }
   $('#txtCodigo').keypress(function(e){

        if (e.which==13){
            buscarProducto($('#txtCodigo').val());
               
                return false;
        }
});

    var fncCargarPrecioCompra=function(producto_ID){
          cargarValores('/Ingreso/ajaxPrecio_Ingreso',producto_ID,function(resultado){
            $('#txtPrecioCompraDolares').val(resultado.precio_compra_dolares); 
            $('#txtPrecioCompraSoles').val(resultado.precio_compra_soles);
            
            if(resultado.resultado==-1){
                toastem.error(resultado.mensaje);
               $('#separaciones').html(resultado.mensaje); 
            }
            //$('#separaciones').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
            VerSeparaciones(resultado.producto_ID);
        });
     } 
   
function calcularTipoCambio(tipo){
        var tipo_cambio=<?php echo $GLOBALS['oCotizacion']->tipo_cambio; ?>;
        if(tipo=="1"){
            var valorSoles=$('#valor_unit_soles_registrado').val().split(',').join('')*1;
            var valorDolares=redondear(parseFloat(valorSoles)/tipo_cambio,bd_largo_decimal);
            $('#valor_unit_dolares_registrado').val(valorDolares);
        }else{
            var valorDolares=$('#valor_unit_dolares_registrado').val().split(',').join('')*1;
            var valorSoles=redondear(parseFloat(valorDolares)*tipo_cambio,bd_largo_decimal);
            $('#valor_unit_soles_registrado').val(valorSoles);
        }
        ProductoValores();
    }
  function ProductoValores(){   
        var caso="total-detalle";
        /*var caja1=$('#txtCantidad').val();
        var caja2=$('#valor_unit_soles_registrado').val().split(',').join('');
        var caja3=$('#valor_unit_dolares_registrado').val().split(',').join('');*/
        var incluye_igv=($("#ckIncluyeIgv").is(":checked"))?1:0;
        var valIGV=parseFloat($('#txtValIgv').val());
        
           var cantidad=$('#txtCantidad').val();
           var precio_unitario_soles=$('#valor_unit_soles_registrado').val().split(',').join('');
           var precio_unitario_dolares=$('#valor_unit_dolares_registrado').val().split(',').join('');
           var total_soles=0;
           var total_dolares=0;
           var sub_total_soles=0;
           var sub_total_dolares=0;
           var valor_unitario_soles=0;
           var valor_unitario_dolares=0;
           var vigv_dolares=0;
           var vigv_soles=0;
            if(incluye_igv==1){
                //if(bd_tipo_calculo_precio=="precio_final"){
                    total_soles=redondear(cantidad*precio_unitario_soles,2);
                    total_dolares=redondear(cantidad*precio_unitario_dolares,2);
                    sub_total_soles=redondear((total_soles/(1+parseFloat(valIGV))),2);
                    sub_total_dolares=redondear((total_dolares/(1+parseFloat(valIGV))),2);
                    valor_unitario_soles=redondear((sub_total_soles/cantidad),bd_largo_decimal);
                    valor_unitario_dolares=redondear((sub_total_dolares/cantidad),bd_largo_decimal);
                    vigv_dolares=redondear(parseFloat(total_dolares)-parseFloat(sub_total_dolares),2);
                    //console.log(vigv_dolares) ;
                    vigv_soles=redondear(parseFloat(total_soles)-parseFloat(sub_total_soles),2);
                    $("#txtPrecioUnitarioDolares").val(valor_unitario_dolares);
                    $("#txtPrecioUnitarioSoles").val(valor_unitario_soles);

                    $('#txtSubTotalSoles').val(sub_total_soles);
                    $("#txtSubTotalDolares").val(sub_total_dolares);
                    
                    $("#txtIgvDolares").val(vigv_dolares);
                    $("#txtIgvSoles").val(vigv_soles);
                    $("#txtTotalDolares").val(total_dolares);
                    $("#txtTotalSoles").val(total_soles);
                //}
               // console.log(formatNumber.formatear(105899.5485));
            }else{
                sub_total_soles=redondear(precio_unitario_soles*cantidad,2);
                sub_total_dolares=redondear(precio_unitario_dolares*cantidad,2);
                vigv_dolares=redondear(sub_total_dolares*valIGV,2);
                vigv_soles=redondear(sub_total_soles*valIGV,2);
                total_soles=redondear((parseFloat(sub_total_soles)+parseFloat(vigv_soles)),2);
                total_dolares=redondear((parseFloat(sub_total_dolares)+parseFloat(vigv_dolares)),2);
                $("#txtPrecioUnitarioDolares").val(precio_unitario_dolares);
                $("#txtPrecioUnitarioSoles").val(precio_unitario_soles);

                $('#txtSubTotalSoles').val(sub_total_soles);
                $("#txtSubTotalDolares").val(sub_total_dolares);

                $("#txtIgvDolares").val(vigv_dolares);
                $("#txtIgvSoles").val(vigv_soles);
                $("#txtTotalDolares").val(total_dolares);
                $("#txtTotalSoles").val(total_soles);
            } 
        }
    function VerSeparaciones(producto_ID){
        cargarValores('/Funcion/ajaxVerSeparaciones',producto_ID,function(resultado){
            $("#table_separaciones tbody").html(resultado.html);
                  fncHistoriaProducto(producto_ID);
        });
        
    }
    var fncLimpiar=function(){
        $('#txtPrecioCompraDolares').val('');
        $('#txtPrecioCompraSoles').val('');
       $("#table_historial_compra tbody").html('');
        $("#table_historial_venta tbody").html('');
        $("#table_separaciones tbody").html('');
        $('#txtDescripcion').val('');
        $('#txtStock').val('');
        $("#txtCodigo").val('');
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
            $('#ckSeparacion').prop('disabled', true);
            $('#txtTiempo_Separacion').prop('disabled', true);
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
    
    var bloquear=function(){
        $('#selLinea').prop('disabled', true);
        $('#selCategoria').prop('disabled', true);
        $('#img_divProductos').css('display','none');
        $('#ckComponente').prop('disabled', true);
        $('#ckAdicional').prop('disabled', true);
        $('#ckSeparacion').prop('disabled', true);
        $('#txtTiempo_Separacion').prop('disabled', true);
        $('#txtDescripcion').prop('disabled', true);
        $('#txtCantidad').prop('disabled', true);
        $('#txtPrecioUnitarioDolares').prop('disabled', true);
        $('#txtPrecioUnitarioSoles').prop('disabled', true);
    }
    </script>
</form>

 
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
<?php if($GLOBALS['oCotizacion_Detalle']->tipo_ID==1){ ?>
setTimeout('parent.windos_float_save_modal_hijo();', 1000);
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
