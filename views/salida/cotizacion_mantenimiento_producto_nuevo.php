<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>REGISTRAR NUEVO PRODUCTO<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js"></script>
    <script type='text/javascript'>
    $(document).ready(function(){
        <?php if($GLOBALS['oCotizacion_Detalle']->componente==1){?>
             fncCargarPrecioCompra(<?php echo $GLOBALS['oCotizacion_Detalle']->producto_ID;?>);
            $('#ckComponente').prop('checked',true);
            $('#txtPrecioUnitarioDolares').prop('disabled', true);
            $('#txtPrecioUnitarioSoles').prop('disabled', true);
        <?php } ?>
        <?php if($GLOBALS['oCotizacion_Detalle']->adicional==1){?>
            $('#ckAdicional').prop('checked',true);
             fncCargarPrecioCompra(<?php echo $GLOBALS['oCotizacion_Detalle']->producto_ID;?>);
        <?php } ?>

    });
    </script>
<?php } ?>

<?php function fncTitleHead(){?>REGISTRAR NUEVO PRODUCTO<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['oCotizacion_Detalle']->tipo==2||$GLOBALS['oCotizacion_Detalle']->tipo==5||$GLOBALS['oCotizacion_Detalle']->tipo==6){ ?>
<form id="frm1"  method="post" action="Salida/Cotizacion_Mantenimiento_Producto_Nuevo/<?php echo $GLOBALS['oCotizacion']->ID;?>" onsubmit="return validar();" class="form-horizontal">
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
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height: 450px;overflow:auto;">
            
            <div class="tab-content" >
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
                    <div class="form-group" >
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Producto: </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 lista_producto" id="tdProducto" >
                            <select id='selProducto' name='selProducto' onchange='fncProducto();' class="chosen-select">
                                <?php echo utf8_encode($GLOBALS['listaProducto']);?>
                            </select>
                            
                            <script type="text/javascript">
                                <?php if($GLOBALS['oCotizacion_Detalle']->ID>0){ ?>
                                   $("#selProducto").val(<?php echo $GLOBALS['oCotizacion_Detalle']->producto_ID;?>);
                                <?php }?>
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Descripción: </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="tdComentario">
                            <textarea id="txtDescripcion" name="txtDescripcion" class="form-control text-uppercase comentario" rows="7" cols="40" maxlength="2000" style="height:120px;"><?php echo FormatTextView($GLOBALS['oCotizacion_Detalle']->descripcion);?></textarea>
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
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Cantidad: </label>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input type="text" id="txtCantidad" name="txtCantidad" class="form-control form-requerido text-right int" autocomplete="off" value="<?php echo $GLOBALS['oCotizacion_Detalle']->cantidad;?>" onkeyup="ProductoValores();">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                           <label>Precio Unitario: </label>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input  type="text" id="txtPrecioUnitarioDolares" class="form-control moneda" autocomplete="off" name="txtPrecioUnitarioDolares" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_unitario_dolares;?>" onkeyup="calcularTipoCambio('2');" placeholder="US$." >
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input type="text" id="txtPrecioUnitarioSoles" class="form-control moneda" autocomplete="off" name="txtPrecioUnitarioSoles" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_unitario_soles;?>" onkeyup="calcularTipoCambio('1');" placeholder="S/.">
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
                            <input type="text" id="txtAdicionalSoles" name="txtAdicionalSoles" class="form-control moneda" value="<?php echo $GLOBALS['oCotizacion_Detalle']->adicional_solares;?>" disabled>
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
                </div>
                <div class="tab-pane fade inner-all divCuerpo" id="historial">
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
                <div class="tab-pane fade inner-all divCuerpo" id="adicionales">
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
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Guardar">
                        <img width="14"  alt="" src="/include/img/boton/save_48x48.png">
                       Guardar
                    </button>
                     <button id="btnRegresar1" type="button" class="btn btn-warning" onclick="parent.float_close_modal_hijo();" title="Regresar">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                            Regresar
                    </button>   
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
    $('.nav-tabs a').on('show.bs.tab', function(event){
        var x = $.trim($(event.target).text());    
        switch(x){
            case "Componentes":
                fncCargar_Cotizacion_Componente();
                break;
            case "Adicionales":
                fncCargar_Cotizacion_Adicional();
                break;
        }
         
        
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
            $('.nav-tabs a[href="#Productos"]').tab('show');
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
                $('.nav-tabs a[href="#divCostos"]').tab('show');
                return false;   
            }
             if(isNaN(PrecioUnitarioDolares)||PrecioUnitarioDolares==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario ($).','txtPrecioUnitario');
                 $('.nav-tabs a[href="#divCostos"]').tab('show');
                return false;   
            }
        }
        
       
        var precioCompraUnitarioDolares=$('#txtPrecioCompraDolares').val();
        if(componente==0){
            if(precioCompraUnitarioDolares*1>=PrecioUnitarioDolares*1){
               if(Resultado_verificar==0){
                   mensaje_validacion();
                    //$('#fondo_mensaje').css('display','block');
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
        $('#fondo_espera').css('display','');
        
    }
    var llenarCajas=function(){
       
        var cotizacion_detalle_ID=$('#txtID').val();
        
        cargarValores('Salida/ajaxCotizacionLlenarCajas',cotizacion_detalle_ID, function(resultado){
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
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
            }
        });
    }
    var fncNuevoComponente=function(){
        var id=$('#txtID').val();
        parent.window_float_open_modal_hijo_hijo("AGREGAR NUEVO COMPONENTE","/Salida/Cotizacion_Mantenimiento_Registro_Componente_Nuevo",id,"",fncCargar_Cotizacion_Componente,700,600);
    }
    //Opción para editar los detalles

    var fncEditarComponente=function(id){
        parent.window_float_open_modal_hijo_hijo("EDITAR COMPONENTE","/Salida/Cotizacion_Mantenimiento_Registro_Componente_Editar",id,"",fncCargar_Cotizacion_Componente,700,600);

    }
    var fncEliminarComponente=function(id){
        cargarValores('/Salida/ajaxCotizacion_Mantenimiento_Registro_Componente_Eliminar',id,function(resultado){
                if(resultado.resultado==1){
                    fncCargar_Cotizacion_Componente("llenarCajas();");
                    toastem.info(resultado.mensaje);
                }else { 
                    toastem.error(resultado.mensaje);
                }
            });
    }
    var fncNuevoAdicional=function(){
        var id=$('#txtID').val();
        parent.window_float_open_modal_hijo_hijo("AGREGAR COMPONENTE","/Salida/Cotizacion_Mantenimiento_Registro_Adicional_Nuevo",id,"",fncCargar_Cotizacion_Adicional,700,600);

    }
    var fncEditarAdicional=function(id){
        parent.window_float_open_modal_hijo_hijo("EDITAR COMPONENTE","/Salida/Cotizacion_Mantenimiento_Registro_Adicional_Editar",id,"",fncCargar_Cotizacion_Adicional,700,600);

        
    }
    var fncEliminarAdicional=function(id){
        cargarValores('/Salida/ajaxCotizacion_Mantenimiento_Registro_Adicional_Eliminar',id,function(resultado){
                if(resultado.resultado==1){
                    fncCargar_Cotizacion_Adicional("llenarCajas();");
                    //fncDesactivarBtnDetalle();
                    toastem.info(resultado.mensaje);
                }else {
                    mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
                }
            }); 
    }
    //==============funcion para elminar
  
    var fncCargar_Cotizacion_Componente=function(callbackfunction){
        
        var cotizacion_detalle_ID=$('#txtID').val();
        $('#divComponente').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
        cargarValores('Salida/ajaxCotizacion_Mantenimiento_Registro_Componente',cotizacion_detalle_ID,function(resultado){
           $('#divComponentes').html(resultado.html);
           
            //fncSeleccionarDetalle();
        });
        if(callbackfunction){
            setTimeout(callbackfunction, 200);
            //callbackfunction.apply();
        }
    }
    var fncCargar_Cotizacion_Adicional=function(callbackfunction){
        var cotizacion_detalle_ID=$('#txtID').val();
        $('#divAdicionales').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
        cargarValores('Salida/ajaxCotizacion_Mantenimiento_Registro_Adicional',cotizacion_detalle_ID,function(resultado){
            $('#divAdicionales').html(resultado.html);
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
                mensaje.error("OCURRIÓ UN ERROR", resultado.mensaje);
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
       // $('#lbMensaje').html('');
        //$('#fondo_mensaje').css('display','none');
        
    }
    
    var fncHistoriaProducto=function(producto_ID){
        cargarValores('/Salida/ajaxHistorial_Producto',producto_ID,function(resultado){
            
            $('#historial').html(resultado.html); 
        });
    }
    $("#ckSeparacion").click(function(){
        if($(this).is(':checked')){
            $('#txtTiempo_Separacion').removeAttr('disabled');
            $('#txtTiempo_Separacion').focus();
            
        }else {
            $('#txtTiempo_Separacion').attr('disabled','disabled');
        }
    });
    
 
   
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

   var fncProducto=function(){
        var producto_ID=$("#selProducto").val();
        if(producto_ID>0){
            //$('#tbdocumentos').html('<div style="background:#000;opacity:0.7;width:100%;height:100%;text-align:center;" ><img width="80px" src="/include/img/loader-Login.gif"></div>');
            cargarValores('/Funcion/ajaxSeleccionar_Producto1',producto_ID,function(resultado){
                //$('#selLinea').val(resultado.linea_ID); 
                //$('#selCategoria').val(resultado.categoria_ID);
                //$('#selProducto').val(resultado.producto_ID);
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



    var fncCargarPrecioCompra=function(producto_ID){
          cargarValores('/Ingreso/ajaxPrecio_Ingreso',producto_ID,function(resultado){
            $('#txtPrecioCompraDolares').val(resultado.precio_compra_dolares); 
            $('#txtPrecioCompraSoles').val(resultado.precio_compra_soles);
            
            if(resultado.resultado==-1){
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
               $('#separaciones').html(resultado.mensaje); 
            }
            
            $('#separaciones').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
            VerSeparaciones(resultado.producto_ID);
        });
     }
    function calcularTipoCambio(tipo){
        var tipo_cambio=<?php echo $GLOBALS['oCotizacion']->tipo_cambio; ?>;
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
        cargarValores('/Salida/ajaxVerSeparaciones',producto_ID,function(resultado){
            $('#separaciones').html(resultado.html); 
            if(resultado.resultado==-1){
               $('#separaciones').html(resultado.mensaje); 
            }
             $('#historial').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
            fncHistoriaProducto(resultado.producto_ID);
        });
        
    }
    var fncLimpiar=function(){
        $('#txtPrecioCompraDolares').val('');
        $('#txtPrecioCompraSoles').val('');
        $('#separaciones').html('');
        $('#historial').html('');
        $('#txtDescripcion').val('');
        $('#txtStock').val('');
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
    $(".chosen-search input").on("keyup",function(){
        alert($(this).val());
        
    });
    </script>
    <style>
        .vista-grid{
            font-size: 11px;
        }
    </style>
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
    //window.parent.actualizar_dimensiones();
    toastem.success('<?php echo $GLOBALS['mensaje'];?>');
});
<?php if($GLOBALS['oCotizacion_Detalle']->tipo==1){ ?>
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
