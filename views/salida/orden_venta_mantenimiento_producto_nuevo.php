<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>REGISTRAR NUEVO PRODUCTO<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js"></script>
    <script type='text/javascript'>
         
    $(document).ready(function(){
        <?php if($GLOBALS['oOrden_Venta_Detalle']->componente==1){?>
                
            fncCargarPrecioCompra(<?php echo $GLOBALS['oOrden_Venta_Detalle']->producto_ID;?>);
            $('#ckComponente').prop('checked',true);
            $('#txtPrecioUnitarioDolares').prop('disabled', true);
            $('#txtPrecioUnitarioSoles').prop('disabled', true);
             bloquear_con_hijo();
        <?php } ?>
        <?php if($GLOBALS['oOrden_Venta_Detalle']->adicional==1){?>
            $('#ckAdicional').prop('checked',true);
             fncCargarPrecioCompra(<?php echo $GLOBALS['oOrden_Venta_Detalle']->producto_ID;?>);
              bloquear_con_hijo();
        <?php } ?>
        <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']!=1 && $GLOBALS['oOrden_Venta_Detalle']->isc_activo>0){?>
                 $("#selTipoISC").prop("disabled",false);
                fncISCIngresarMonto("<?php echo $GLOBALS['oOrden_Venta_Detalle']->tipo_sistema_calculo_isc_ID;?>");
        <?php } ?>

    });
    </script>
    <style>
         #table_historial_compra tbody td,#table_historial_venta tbody td,#table_separaciones tbody td,#table_componente tbody td,#table_adicional tbody td{
            font-size:11px;
        }
    </style>
<?php } ?>

<?php function fncTitleHead(){?>REGISTRAR NUEVO PRODUCTO<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['oOrden_Venta_Detalle']->tipo_ID==2||$GLOBALS['oOrden_Venta_Detalle']->tipo_ID==5||$GLOBALS['oOrden_Venta_Detalle']->tipo_ID==6){ ?>
<form id="frm1"  method="post" action="Salida/Orden_Venta_Mantenimiento_Producto_Nuevo/<?php echo $GLOBALS['oOrden_Venta']->ID;?>" onsubmit="return validar();" class="form-horizontal">
     <input type="hidden" id='txtID' name='txtID' value='<?php echo $GLOBALS['oOrden_Venta_Detalle']->ID;?>'>
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading ">
            <ul class="nav nav-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#Productos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Producto</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divCostos" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i> <span>Costo</span></a></li>
                <li class="nav-item"><a href="#separaciones" data-toggle="tab"><i class="fa fa-clone"></i> <span>Separaciones</span></a></li>
                <li class="nav-item"><a href="#historial" data-toggle="tab"><i class="fa fa-calendar-o"></i> <span>Historial</span></a></li>
                <?php if($GLOBALS['oOrden_Venta_Detalle']->componente==1){?>
                <li class="nav-item"><a href="#componentes" data-toggle="tab"><i class="fa fa-cogs"></i> <span>Componentes</span></a></li>
                <?php } ?>
                <?php if($GLOBALS['oOrden_Venta_Detalle']->adicional==1){?>
                <li class="nav-item"><a href="#adicionales" data-toggle="tab"><i class="fa fa-cubes"></i> <span>Adicionales</span></a></li>
                <?php } ?>
            </ul>
            <div class="pull-right">
                
                <label class="bold">Tipo de cambio:S/.<?php echo round($GLOBALS['oOrden_Venta']->tipo_cambio,2);?></label>
            </div>
        </div>
        <div class="panel-body rounded-bottom">
            
            <div class="tab-content" style="height: 450px;overflow:auto;">
                <div id="Productos" class="tab-pane fade in active inner-all">
                    <div class="row">
                       <div class="form-group">
                                <label class="control-label col-lg-3 col-md-3 col-sm-3">Línea: </label>
                                <div class="col-lg-9 col-md-9 col-sm-9" id="tdLinea">
                                    <select id="selLinea" name="selLinea" onchange="fncLinea();" class="form-control filtroLista chosen-select mb-15" >
                                        <option value="0">TODOS</option>
                                        
                                        <?php echo $GLOBALS['dtLinea'];?>
                                    </select>
                                    <script type="text/javascript">
                                        $('#selLinea').val(<?php echo $GLOBALS['oOrden_Venta_Detalle']->linea_ID;?>);
                                    </script> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3 col-md-3 col-sm-3">Categoría: </label>
                                
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="tdCategoria">
                                    <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" class="form-control filtroLista chosen-select mb-15">
                                        <option value="0" selected>TODOS</option>
                                        <?php echo $GLOBALS['dtCategoria']; ?>
                                        
                                    </select> 
                                    <script type="text/javascript">
                                        $('#selCategoria').val(<?php echo $GLOBALS['oOrden_Venta_Detalle']->categoria_ID;?>);
                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Producto: </label>
                                
                                <div class="col-sm-7 lista_producto" id="tdProducto" >
                                    <input type="hidden" id="selProducto" name="selProducto" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->producto_ID;?>">
                                    <input type="text" id="listaProducto" class="form-control" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->producto;?>">
                                    <script type="text/javascript">
                                    $(document).ready(function(){
                                        listar_productos();
                                    });
                                    </script>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" placeholder="Código" autocomplete="off" value="<?php echo $GLOBALS['oProducto']->codigo;?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                   <div class="ckbox ckbox-theme">
                                        <input id="ckComponente"  name="ckComponente"  type="checkbox" value="1">
                                        <label for="ckComponente">Componente</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="ckbox ckbox-theme">
                                        <input id="ckAdicional"  name="ckAdicional"  type="checkbox" value="1">
                                        <label for="ckAdicional">Adicional</label>
                                    </div>

                                </div>
                               

                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-sm-3">Stock: </label>
                                <div class="col-sm-3">
                                     <input type="text" id="txtStock" name="txtStock" class="form-control desactivado" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->stock; ?>" disabled>
                                </div>
                                <label class="col-sm-3 control-label">Peso(kg): </label>
                                <div class="col-sm-3">
                                    <input type="text" id="txtPeso" name="txtPeso" class="form-control" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->peso;?>" autocomplete="off">
                                </div>
                            </div>
                           
                        <div class="form-group">
                                <label class="control-label col-lg-12 col-md-12">Descripción: </label>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" rows="7" cols="40" maxlength="2000" style="height:100px;resize: none;overflow: auto;"><?php echo FormatTextView($GLOBALS['oOrden_Venta_Detalle']->descripcion);?></textarea>
                                </div>
                            </div>
                    </div>
                    
                    
                    
                    
                </div>
                <div id="divCostos" class="tab-pane fade inner-all">
                    <div class="row">
                        <div class="col-sm-4">
                            
                            
                            <h5 class="page-header">Cant. y Precio Unit.</h5>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-info">Cantidad<span class="asterisk">*</span></span>
                                        <input type="text" id="txtCantidad" name="txtCantidad" class="form-control form-requerido text-right int" autocomplete="off" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->cantidad;?>" onkeyup="ProductoValores();">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="hidden" id="valor_unitario" name="valor_unitario" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->valor_unitario;?>">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-success">USD</span>
                                        <input type="text" id="txtPrecioUnitarioDolares" class="form-control no-border-left moneda" name="txtPrecioUnitarioDolares" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_unitario_dolares;?>" onkeyup="calcularTipoCambio('2');" type="text" autocomplete="off">
                                        <input type="hidden" id="txtValorUnitarioDolares" name="txtValorUnitarioDolares">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-success">S/.</span>
                                        <input type="text" id="txtPrecioUnitarioSoles" class="form-control no-border-left moneda" name="txtPrecioUnitarioSoles" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_unitario_soles;?>" onkeyup="calcularTipoCambio('1');" type="text" autocomplete="off">
                                        <input type="hidden" id="txtValorUnitarioSoles" name="txtValorUnitarioSoles">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="ckbox ckbox-theme">
                                        <input id="ckIncluyeIgv" name="ckIncluyeIgv"  type="checkbox" onclick="ProductoValores();" <?php echo (($GLOBALS['oOrden_Venta_Detalle']->pu_incluye_igv==1)?"checked":"");?>>
                                        <label for="ckIncluyeIgv">Incluye IGV</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="ckbox ckbox-theme">
                                        <input id="ckPUIncluyeIsc" name="ckPUIncluyeIsc" type="checkbox" onclick="activarISC(this);" <?php echo (($GLOBALS['oOrden_Venta_Detalle']->pu_incluye_isc==1)?"checked":"");?>>
                                        <label for="ckPUIncluyeIsc">Incluye ISC</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h5 class="page-header">Descuento:</h5>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-teal">%</span>

                                       <input type="text" id="txtPorcentaje_Descuento" name="txtPorcentaje_Descuento" autocomplete="off" class="form-control" onkeyup="calcularPorcentajeDescuento(this.value,'porcentaje');" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->descuento_porcentaje;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-teal"><?php echo (($GLOBALS['oOrden_Venta']->moneda_ID==1)?"Total S/.":"Total USD.");?></span>
                                        <input type="text" id="txtTotal_Descuento" name="txtTotal_Descuento" class="form-control no-border-left moneda" onkeyup="calcularPorcentajeDescuento(this.value,'total');" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->descuento;?>">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-teal"><?php echo (($GLOBALS['oOrden_Venta']->moneda_ID==1)?"Unit. S/.":"Unit.USD.");?></span>
                                        <input type="text" id="txtUnit_Descuento" name="txtUnit_Descuento" class="form-control no-border-left moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->descuento_unitario;?>" onkeyup="calcularPorcentajeDescuento(this.value,'unitario');" type="text" autocomplete="off">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h5 class="page-header">Impuestos</h5>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-danger">Tipo de IGV:</span>
                                         <select class="form-control no-border-left" id="selImpuestos_Tipo" name="selImpuestos_Tipo" onchange="ProductoValores();">
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
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="ckbox ckbox-theme">
                                        <input id="ckIncluyeISC" name="ckIncluyeISC" type="checkbox" <?php echo (($GLOBALS['oOrden_Venta_Detalle']->isc_activo==1)?"checked":"");?>>
                                        <label for="ckIncluyeISC">Tiene I.S.C.?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-danger">Cálculo ISC:</span>
                                        <select id="selTipoISC" name="selTipoISC" class="form-control no-border-left" disabled onchange="fncISCIngresarMonto(this.value);">
                                            <?php echo utf8_encode($GLOBALS['OP_tipo_sistema_calculo_isc']);?>
                                        </select>
                                        <script>
                                            $("#selTipoISC").val(<?php echo $GLOBALS['oOrden_Venta_Detalle']->tipo_sistema_calculo_isc_ID?>);
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-danger">ISC %</span>
                                        <input type="text" id="txtPorcentajeISC" disabled name="txtPorcentajeISC" class="form-control no-border-left" autocomplete="off" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->isc_porcentaje;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-addon bg-danger" id="lbEtiqueta"></span>
                                        <input type="text" id="txtIscValor_Calculo" name="txtIscValor_Calculo" disabled class="form-control no-border-left" autocomplete="off" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->isc_valor_referencial;?>">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <input id="txtValIgv" name="txtValIgv" value="<?php echo $GLOBALS['oOrden_Venta']->igv;?>" style="display:none;">
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
                                        <th class="text-center">Descuento</th>
                                        <th class="text-center">Valor de venta</th>
                                        <th class="text-center">I.S.C.</th>
                                        <th class="text-center">I.G.V. <?php echo $GLOBALS['oOrden_Venta']->igv*100;?>%:</th>
                                        
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
                                            <label id="tdSubTotalDolares"></label>
                                            <input type="hidden" id="txtSubTotalDolares" name="txtSubTotalDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_subtotal_dolares;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdAdicionalDolares"></label>
                                            <input type="hidden" id="txtAdicionalDolares" name="txtAdicionalDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->adicional_dolares;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdSubTotalDolares1"></label>
                                            <input type="hidden" id="txtSubTotalDolares1" name="txtSubTotalDolares1" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->subtotal_dolares1;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdDescuentoDolares"></label>
                                            <input type="hidden" id="txtDescuentoDolares" name="txtDescuentoDolares" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->descuento_dolares;?>" >
                                        </td>
                                         <td class="text-right" >
                                            <label id="tdValorVentaDolares"></label>
                                            <input type="hidden" id="txtValorVentaDolares" name="txtValorVentaDolares" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->valor_venta_dolares;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdIscDolares"></label>
                                             <input type="hidden" id="txtIscDolares" name="txtIscDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->visc_dolares;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdIgvDolares"></label>
                                             <input type="hidden" id="txtIgvDolares" name="txtIgvDolares" class="form-control moneda"  value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->vigv_dolares;?>" >
                                        </td>
                                        
                                        <td class="text-right" >
                                            <label id="tdTotalDolares"></label>
                                            <input type="hidden" id="txtTotalDolares" name="txtTotalDolares" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_dolares;?>" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Soles</th>
                                        <td class="text-right" >
                                            <label id="tdPrecioCompraSoles"></label>
                                            <input type="hidden" id="txtPrecioCompraSoles" name="txtPrecioCompraSoles" class="form-control moneda desactivado" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdSubTotalSoles"></label>
                                            <input type="hidden" id="txtSubTotalSoles" name="txtSubTotalSoles" class="form-control moneda"  value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_subtotal_soles;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdAdicionalSoles"></label>
                                            <input type="hidden" id="txtAdicionalSoles" name="txtAdicionalSoles" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->adicional_solares;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdSubTotalSoles1"></label>
                                            <input type="hidden" id="txtSubTotalSoles1" name="txtSubTotalSoles1" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->subtotal_soles1;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdDescuentoSoles"></label>
                                            <input type="hidden" id="txtDescuentoSoles" name="txtDescuentoSoles" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->descuento_soles;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdValorVentaSoles"></label>
                                            <input type="hidden" id="txtValorVentaSoles" name="txtValorVentaSoles" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_soles;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdIscSoles"></label>
                                             <input type="hidden" id="txtIscSoles" name="txtIscSoles" class="form-control moneda"  value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->vigv_dolares;?>" >
                                        </td>
                                        <td class="text-right" >
                                            <label id="tdIgvSoles"></label>
                                            <input type="hidden" id="txtIgvSoles" name="txtIgvSoles" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->vigv_soles;?>">
                                        </td>
                                        
                                        <td class="text-right" >
                                            <label id="tdTotalSoles"></label>
                                            <input type="hidden" id="txtTotalSoles" name="txtTotalSoles" class="form-control moneda" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->precio_venta_soles;?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
                <div class="tab-pane fade divCuerpo" id="separaciones">
                    <h4>Separaciones de producto</h4>
                    <table id="table_separaciones" class='table table-hover table-bordered table-teal'><thead>
                        <tr><th>N°Cotizaci&oacute;n</th><th>Fecha</th><th>Cant. Comprada</th><th>Cant. Separada</th><th >Responsable</th></tr>
                    </thead>
                    <tbody>
                    </table> 
                </div>
                <div class="tab-pane fade divCuerpo" id="historial" style="height: 340px;overflow:auto;">
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
                <div class="tab-pane fade divCuerpo" id="componentes">
                    <?php if($GLOBALS['oOrden_Venta_Detalle']->componente==1){?>
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
                                <th>Valor U.</th>
                                <th>Descuento</th>
                                <th>Sub Total</th>
                                <th>Op</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade divCuerpo" id="adicionales">
                    <?php if($GLOBALS['oOrden_Venta_Detalle']->adicional==1){?>
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
                                <th>Valor U.</th>
                                <th>Descuento</th>
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
    
   <style>
  
  </style>
    <script type="text/javascript">
        
        
        function fncISCIngresarMonto(valor){
            var moneda_ID=<?php  echo $GLOBALS['oOrden_Venta']->moneda_ID?>; 
            var moneda=(moneda_ID==1)?"S/":"USD";
            
            switch(valor){
                case "1":
                    $("#txtIscValor_Calculo").prop("disabled", true);
                    $("#txtPorcentajeISC").prop("disabled", false);
                    $("#txtPorcentajeISC").select();
                    $("#lbEtiqueta").text("");
                    break;
                case "2":
                    $("#lbEtiqueta").text("Valor definido "+moneda);
                    $("#txtPorcentajeISC").prop("disabled", true);
                    $("#txtPorcentajeISC").val("");
                    $("#txtIscValor_Calculo").prop("disabled", false);
                    $("#txtIscValor_Calculo").select();
                    
                    break;
                case "3":
                    $("#lbEtiqueta").text("Valor al público "+moneda);
                    $("#txtIscValor_Calculo").prop("disabled", false);
                    $("#txtPorcentajeISC").prop("disabled", false);
                    $("#txtPorcentajeISC").select();
                    break;   
            }
            ProductoValores();
        }
        function activarISC(obj){
           if($(obj).is(":checked")){
               $("#ckIncluyeISC").prop("checked",true);
               $("#selTipoISC").prop("disabled",false);
               $("#txtPorcentajeISC").prop("disabled",false);
               $("#txtPorcentajeISC").prop("disabled",false);
               
           } 
           ProductoValores();
        }
        $("#txtPorcentajeISC").keyup(function(){
            ProductoValores();
        });
        $("#txtIscValor_Calculo").keyup(function(){
            ProductoValores();
        });
        function calcularPorcentajeDescuento(valor,tipo){
            
            var moneda_ID=<?php  echo $GLOBALS['oOrden_Venta']->moneda_ID?>; 
            var valor_unitario=0;
            if(moneda_ID==1){
                valor_unitario=parseFloat(($.trim($("#txtValorUnitarioSoles").val())=="")?0:$("#txtValorUnitarioSoles").val());
            }else{
                valor_unitario=parseFloat(($.trim($("#txtValorUnitarioDolares").val())=="")?0:$("#txtValorUnitarioDolares").val());
            }        
              
            var cantidad=parseFloat(($.trim($("#txtCantidad").val())=="")?1:$("#txtCantidad").val());
            var porcentaje=0;
            var descuento_total=0;
            var decuento_unitario=0;
            switch(tipo){
                case "total":
                    porcentaje=redondear((valor/(valor_unitario*cantidad))*100,2);
                    descuento_total=valor;
                    decuento_unitario=redondear(valor/cantidad,2);
                    
                    $("#txtPorcentaje_Descuento").val(porcentaje);
                    $("#txtUnit_Descuento").val(decuento_unitario);
                    break;
                case "unitario":
                    porcentaje=redondear((valor/valor_unitario)*100,2);
                    descuento_total=redondear(valor*cantidad,2); 
                    decuento_unitario=valor;
                    $("#txtPorcentaje_Descuento").val(porcentaje);
                    $("#txtTotal_Descuento").val(descuento_total);
                    break;
                case "porcentaje":
                    var sub_total=0;
                    if(moneda_ID==1){
                        sub_total=parseFloat(($.trim($("#txtSubTotalSoles").val())=="")?0:$("#txtSubTotalSoles").val());
                    }else{
                        sub_total=parseFloat(($.trim($("#txtSubTotalDolares").val())=="")?0:$("#txtSubTotalDolares").val());
                    }

                    descuento_total=redondear((sub_total*valor)/100,2); 
                    porcentaje=valor;
                    decuento_unitario=redondear((descuento_total/cantidad),2);
                    
                    $("#txtTotal_Descuento").val(descuento_total);
                    $("#txtUnit_Descuento").val(decuento_unitario);
                    break;
            }
            
          
            
        }
    $('.nav-tabs a').on('show.bs.tab', function(event){
        var x = $.trim($(event.target).text());  
        
        switch(x){
            case "Componentes":
                fncCargar_Orden_Venta_Componente();
                break;
            case "Adicionales":
                fncCargar_Orden_Venta_Adicional();
                break;
        }  
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
        var PrecioUnitarioSoles=$.trim($('#txtPrecioUnitarioSoles').val());
        var PrecioUnitarioDolares=$.trim($('#txtPrecioUnitarioDolares').val());
        var venta_dolares=parseFloat($.trim($('#txtTotalDolares').val()).split(',').join(''));
        var venta_soles=parseFloat($.trim($('#txtTotalSoles').val()).split(',').join(''));
        
        if(producto_ID==0||producto_ID==''){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione un producto.','selProducto');
            $('.nav-tabs a[href="#Productos"]').tab('show');
            return false;
        }

        //Verifico si el comprobante requiere serie y número
        if(isNaN(cantidad)||cantidad==""||cantidad=="0"){
             mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre una cantidad.','txtCantidad');
            $('.nav-tabs a[href="#divCostos"]').tab('show');
           
            return false;   
        }
        var precioCompraUnitarioDolares=$('#txtPrecioCompraDolares').val();
        if(componente==0){
            if(PrecioUnitarioSoles=="0"||PrecioUnitarioSoles==""){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario (S/.).','txtPrecioUnitarioDolares');
                $('.nav-tabs a[href="#divCostos"]').tab('show');
                return false;
            }
            if(precioCompraUnitarioDolares*parseFloat(cantidad)>=venta_dolares*parseFloat(cantidad)){
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
            if(isNaN(PrecioUnitarioSoles)||PrecioUnitarioSoles==""||PrecioUnitarioSoles=="0"){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario (S/.).','txtPrecioUnitarioDolares');
                $('.nav-tabs a[href="#divCostos"]').tab('show');
               
                return false;   
            }
             if(isNaN(PrecioUnitarioDolares)||PrecioUnitarioDolares==""||PrecioUnitarioSoles=="0"){
                mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un precio unitario ($).','txtPrecioUnitario');
                $('.nav-tabs a[href="#divCostos"]').tab('show');
                
                return false;   
            }
        }
        var con_isc=($("#ckIncluyeISC").is(":checked"))?1:0;
        if(con_isc==1){
            var tipo_calculo_isc=$("#selTipoISC").val();
            var porcentaje_isc=$.trim($("#txtPorcentajeISC").val());
            var referencial_isc=$.trim($("#txtIscValor_Calculo").val());
            switch(tipo_calculo_isc){
                case "1":
                    if(porcentaje_isc==""||parseFloat(porcentaje_isc)<=0){
                        mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar un porcentaje del ISC.','txtPorcentajeISC');
                        return false;
                    }
                    break;
                case "2":
                    if(referencial_isc==""||parseFloat(referencial_isc)<=0){
                        mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar el monto fijo.','txtIscValor_Calculo');
                        return false;
                    }
                    break;
                case "3":
                    if(porcentaje_isc==""||parseFloat(porcentaje_isc)<=0){
                        mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar un porcentaje del ISC.','txtPorcentajeISC');
                        return false;
                    }
                    if(referencial_isc==""||parseFloat(referencial_isc)<=0){
                        mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe registrar el valor al público.','txtIscValor_Calculo');
                        return false;
                    }
                    break;
            }
        }
        
        $('#txtSubTotalSoles').removeAttr('disabled');
        $('#txtSubTotalDolares').removeAttr('disabled');
        $('#txtIgvSoles').removeAttr('disabled');
        $('#txtIgvDolares').removeAttr('disabled');
        $('#txtTotalSoles').removeAttr('disabled');
        $('#txtTotalDolares').removeAttr('disabled');
        $("#selImpuestos_Tipo").removeAttr('disabled');
        
        $('#selTipoISC').removeAttr('disabled');
        $("#txtPorcentajeISC").removeAttr('disabled');
        $("#txtIscValor_Calculo").removeAttr('disabled');
        
        block_ui();
        //$('#fondo_espera').css('display','');
        
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
                
                $('#tdSubTotalDolares').html(resultado.precio_venta_subtotal_dolares);
                $('#tdSubTotalDolares1').html(resultado.precio_venta_subtotal_dolares1);
                $('#tdIgvDolares').html(resultado.vigv_dolares);
                $('#tdTotalDolares').html(resultado.precio_venta_dolares);
                $('#tdAdicionalDolares').html(resultado.adicional_dolares);
                $('#tdAdicionalSoles').html(resultado.adicional_soles);
                $('#tdPrecioUnitarioSoles').html(resultado.precio_venta_unitario_soles);
                $('#tdSubTotalSoles1').html(resultado.precio_venta_subtotal_soles1);
                $('#tdSubTotalSoles').html(resultado.precio_venta_subtotal_soles);
                $('#tdIgvSoles').html(resultado.vigv_soles);
                $('#tdTotalSoles').html(resultado.precio_venta_soles);
                
            }else {
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
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
                block_ui();
                //$('#fondo_mensaje').css('display','none'); 
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

     $("#ckSeparacion").click(function(){
        if($(this).is(':checked')){
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
    var fncLinea=function(){
                        
        var linea_ID = $('#selLinea').val();

        cargarValores("/Funcion/ajaxListar_Categorias",linea_ID,function(resultado){
            if(resultado.resultado==1){
                $('#selCategoria').html(resultado.html);
                $("#selCategoria").trigger("chosen:updated");
                fncLimpiar();
                $("#listaProducto").val('');
                $("#selProducto").val(0);
                //listar_productos();
                
                //fncCategoria();
            }else{
                mensaje.error("Mensaje de error",resultado.mensaje);
            }
        });
 
    }

    var fncCategoria=function(){
        listar_productos();
        /*var categoria_ID = $('#selCategoria').val();
        var linea_ID=$('#selLinea').val();
        cargarValores1("/Funcion/ajaxListar_Productos1",linea_ID,categoria_ID,function(resultado){
           
            if(resultado.resultado==1){
                //("#selProducto").html(resultado.html);
                listar_productos();
                $("#selProducto").trigger("chosen:updated");
            }else{
                mensaje.error("Mensaje de error",resultado.mensaje);
            }
        });*/
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
          cargarValores('/Ingreso/ajaxPrecio_ingreso',producto_ID,function(resultado){
            $('#txtPrecioCompraDolares').val(resultado.precio_compra_dolares); 
            $('#txtPrecioCompraSoles').val(resultado.precio_compra_soles);
            $('#tdPrecioCompraDolares').html(resultado.precio_compra_dolares); 
            $('#tdPrecioCompraSoles').html(resultado.precio_compra_soles);
            if(resultado.resultado==-1){
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
              
            }
            
            VerSeparaciones(resultado.producto_ID);
        });
     }
    function calcularTipoCambio(tipo_ID){
        var tipo_cambio=<?php echo $GLOBALS['oOrden_Venta']->tipo_cambio; ?>;
        if(tipo_ID=="1"){
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
        var tipo_cambio=<?php echo $GLOBALS['oOrden_Venta']->tipo_cambio; ?>;
        var incluye_igv=($("#ckIncluyeIgv").is(":checked"))?1:0;
        var PUincluye_isc=($("#ckPUIncluyeIsc").is(":checked"))?1:0;
        var igv=parseFloat(<?php  echo $GLOBALS['oOrden_Venta']->igv;?>);
        var caja1=$('#txtCantidad').val();
        var caja2=$('#txtPrecioUnitarioSoles').val().split(',').join('');
        var caja3=$('#txtPrecioUnitarioDolares').val().split(',').join('');
        var valIGV=parseFloat($('#txtValIgv').val());
        var isc_activado=($("#ckIncluyeISC").is(":checked"))?1:0;
        var isc_porcentaje=parseFloat(($.trim($("#txtPorcentajeISC").val())=="")?0:$("#txtPorcentajeISC").val())/100;  
        var isc_tipo_calculo=$("#selTipoISC").val();
       // var isc_valor_calculo=parseFloat(($.trim($("#txtIscValor_Calculo").val())=="")?0:$("#txtIscValor_Calculo").val());
       
        var moneda_ID=<?php  echo $GLOBALS['oOrden_Venta']->moneda_ID?>; 
        var isc_valor_calculo_dolares=0;
        var isc_valor_calculo_soles=0;
        if(moneda_ID==1){
            isc_valor_calculo_soles=parseFloat(($.trim($("#txtIscValor_Calculo").val())=="")?0:$("#txtIscValor_Calculo").val());
            isc_valor_calculo_dolares=isc_valor_calculo_soles/tipo_cambio;
           
            
        }else{
            isc_valor_calculo_dolares=parseFloat(($.trim($("#txtIscValor_Calculo").val())=="")?0:$("#txtIscValor_Calculo").val());
            isc_valor_calculo_soles=isc_valor_calculo_dolares*tipo_cambio;
        }
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
        if (incluye_igv==1){
            valor2=valor2/(1+igv);  
        }
        if(PUincluye_isc==1){
            switch(isc_tipo_calculo){
                case "1":
                    valor2=valor2/(1+isc_porcentaje);

                    break;
                case "2":
                    valor2=valor2-isc_valor_calculo_soles;
                    break;
                case "3":
                     
                    valor2=valor2-(isc_valor_calculo_soles*isc_porcentaje);
                     
                    break;

            }

        }
        valor2=redondear(valor2,2);
         var subtotalSoles=redondear(valor1*valor2,2);
         if(isNaN(subtotalSoles)==true){ 
             subtotalSoles="--";
         
         }
        
        if(incluye_igv==1) {
            valor3=valor3/(1+igv);
            
        }
        if(PUincluye_isc==1){
                switch(isc_tipo_calculo){
                    case "1":
                        valor3=valor3/(1+isc_porcentaje);
                        break;
                    case "2":
                        valor3=valor3-isc_valor_calculo_dolares;
                        break;
                    case "3":
                       
                        valor3=valor3-(isc_valor_calculo_dolares*isc_porcentaje);
                       
                        break;
                        
                }
               
            }
        if(moneda_ID==1){
            $("#valor_unitario").val(redondear(valor2,2));
        }else{
            $("#valor_unitario").val(redondear(valor3,2));
        }    
        valor3=redondear(valor3,2);
        var subTotalDolares=redondear(valor1*valor3,2);
        if(isNaN(subTotalDolares)==true){
            subTotalDolares="--";

        }
        $("#txtValorUnitarioDolares").val(valor3);
        $("#txtValorUnitarioSoles").val(valor2);
        //calcularDescuento();
        $('#txtSubTotalSoles').val(subtotalSoles); 
        $('#txtSubTotalDolares').val(subTotalDolares);
        $('#tdSubTotalSoles').html(subtotalSoles); 
        $('#tdSubTotalDolares').html(subTotalDolares);    
       
        var descuento=0;
        var descuento_dolares=0;
        var descuento_soles=0;
        var porcentaje_descuento=parseFloat(($.trim($("#txtPorcentaje_Descuento").val())=="")?0:$.trim($("#txtPorcentaje_Descuento").val()));
        //calcularPorcentajeDescuento(porcentaje_descuento,"porcentaje");
    if(moneda_ID==1){
            descuento=redondear((subtotalSoles*porcentaje_descuento)/100,2);
            descuento_soles=descuento;
            descuento_dolares=redondear(descuento/tipo_cambio,2);
        }else{
            descuento=redondear(subTotalDolares*porcentaje_descuento/100,2);
            descuento_dolares=descuento;
            descuento_soles=redondear(descuento_dolares*tipo_cambio,2);
        }
        $("#tdDescuentoDolares").text(descuento_dolares);
        $("#txtDescuentoDolares").val(descuento_dolares);
        $("#tdDescuentoSoles").text(descuento_soles);
        $("#txtDescuentoSoles").val(descuento_soles);
        
        var valor_venta_soles=0;
        
        var valor_venta_dolares=0;
        if(moneda_ID==1){
            valor_venta_soles=redondear(subtotalSoles-descuento_soles,2);
            valor_venta_dolares=redondear(valor_venta_soles/tipo_cambio,2);
        }else{
            valor_venta_dolares=redondear(subTotalDolares-descuento_dolares,2);
            valor_venta_soles=redondear(valor_venta_dolares*tipo_cambio,2);
            
        }
        
        
        $("#tdValorVentaDolares").html(valor_venta_dolares);
        $("#txtValorVentaDolares").val(valor_venta_dolares);
        $("#tdValorVentaSoles").html(valor_venta_soles);
        $("#txtValorVentaSoles").val(valor_venta_soles);
        
        var isc_soles=0;
            var isc_dolares=0;
            
            if(isc_activado==1){
                var isc_unit_soles=0;
                var isc_unit_dolares=0;
                switch(isc_tipo_calculo){
                    case "1":
                        
                        isc_unit_dolares=valor3*isc_porcentaje;
                        isc_unit_soles=valor2*isc_porcentaje;
                        break;
                    case "2":
                        isc_unit_dolares=isc_valor_calculo_dolares;
                        isc_unit_soles=isc_valor_calculo_soles;
                        
                        
                        break;
                    case "3":
                        
                        isc_unit_soles=isc_valor_calculo_soles*isc_porcentaje;
                        isc_unit_dolares=isc_valor_calculo_dolares*isc_porcentaje;
                        
                        break;
                        
                }
                
                isc_soles=redondear(isc_unit_soles*valor1,2);
                isc_dolares=redondear(isc_unit_dolares*valor1,2);
            }
            $("#tdIscDolares").html(isc_dolares);
            $("#txtIscDolares").val(isc_dolares);
            $("#tdIscSoles").html(isc_soles);
            $("#txtIscSoles").val(isc_soles);
            
            
        var tipo_impuesto=$("#selImpuestos_Tipo").val();
        
        var valor_igv_dolares=0;
        var valor_igv_soles=0;
        var obj=new Object();
        obj['moneda_ID']=moneda_ID;
        obj['tipo_cambio']=tipo_cambio;
        obj['impuesto_tipo_ID']=$("#selImpuestos_Tipo").val();
        obj['monto']=(moneda_ID==1)?(valor_venta_soles+isc_soles):(valor_venta_dolares+isc_dolares);
        obj['igv']=valIGV;
       
        
        enviarAjax('salida/ajaxExtraerIGV','frm',obj,function(res){
            
            var resultado=$.parseJSON(res);
            valor_igv_dolares=parseFloat(resultado.resultado_dolares);
            valor_igv_soles=parseFloat(resultado.resultado_soles);
            $('#txtIgvDolares').val(valor_igv_dolares);
            $('#tdIgvDolares').html(valor_igv_dolares);
            $('#txtIgvSoles').val(valor_igv_soles);
            $('#tdIgvSoles').html(valor_igv_soles);
            var total_venta_dolares=valor_igv_dolares+valor_venta_dolares+isc_dolares;
            var total_venta_soles=valor_igv_soles+valor_venta_soles+isc_soles;
            $("#tdTotalDolares").html(redondear(total_venta_dolares,2));
            $("#txtTotalDolares").val(redondear(total_venta_dolares,2));
            $("#tdTotalSoles").html(redondear(total_venta_soles,2));
            $("#txtTotalSoles").val(redondear(total_venta_soles,2)); 
            if($.trim(resultado.mensaje)!=""){
                toastem.info(resultado.mensaje);
            }
            
             
        });
        
        }
    /*function calcularIGV(){
        var tipo_impuesto=$("#selImpuestos_Tipo").val();
        var subtotalSoles=$("#txtSubTotalSoles").val();
        var subtotalDolares=$("#txtSubTotalDolares").val();
        
        var valIGV=parseFloat($('#txtValIgv').val());
        if(tipo_impuesto==1){
            if(subtotalSoles!=0){
                var igvSoles=redondear(parseFloat(subtotalSoles)*valIGV,2);
                $('#txtIgvSoles').val(igvSoles);
                $('#tdIgvSoles').html(igvSoles);
                var TotalSoles=redondear(parseFloat(subtotalSoles)+parseFloat(igvSoles),2);
                $('#txtTotalSoles').val(TotalSoles);
                $('#tdTotalSoles').html(TotalSoles);
            }
            if(subtotalDolares!=0){
                var igvDolares=redondear(parseFloat(subtotalDolares)*valIGV,2);
                $('#txtIgvDolares').val(igvDolares);
                $('#tdIgvDolares').html(igvDolares);
                var TotalDolares=redondear(parseFloat(subtotalDolares)+parseFloat(igvDolares),2);
                $('#txtTotalDolares').val(TotalDolares);
                $('#tdTotalDolares').html(TotalDolares);
            }
        }else{
            if(subtotalSoles!=0){
                //var igvSoles=redondear(parseFloat(subtotalSoles)*valIGV,2);
                $('#txtIgvSoles').val(0);
                $('#tdIgvSoles').html(0);
                //var TotalSoles=redondear(parseFloat(subtotalSoles)+parseFloat(igvSoles),2);
                $('#txtTotalSoles').val(subtotalSoles);
                $('#tdTotalSoles').html(subtotalSoles);
            }
            if(subtotalDolares!=0){
                //var igvDolares=redondear(parseFloat(subtotalDolares)*valIGV,2);
                $('#txtIgvDolares').val(0);
                $('#tdIgvDolares').html(0);
                //var TotalDolares=redondear(parseFloat(subtotalDolares)+parseFloat(igvDolares),2);
                $('#txtTotalDolares').val(subtotalDolares);
                $('#tdTotalDolares').html(subtotalDolares);
            }
        }
        

       
    }*/
    function calcularDescuento(){
        var moneda_ID=<?php  echo $GLOBALS['oOrden_Venta']->moneda_ID?>;
        var igv=parseFloat(<?php  echo $GLOBALS['oOrden_Venta']->igv;?>);
        var inclute_igv=($("#ckIncluyeIgv").is(":checked"))?1:0;
        var precio_unitario=parseFloat((moneda_ID==1)?$("#txtPrecioUnitarioSoles").val():$("#txtPrecioUnitarioDolares").val());
        var cantidad=parseFloat($("#txtCantidad").val());
        var valor_unitario=precio_unitario;
        var descuento=0;
        var porcentaje_descuento=parseFloat($("#txtPorcentaje_Descuento").val());
        var valor_venta_bruto=precio_unitario*cantidad;
        if(inclute_igv==1){
            valor_unitario=precio_unitario/(1+igv);
            valor_venta_bruto=valor_unitario*cantidad;
        }
        var descuento=redondear(valor_venta_bruto*porcentaje_descuento/100,2);
        $("#txtTotal_Descuento").val(descuento);
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
        $('#tdPrecioCompraDolares').html('');
        $('#tdPrecioCompraSoles').html('');

        $('#txtDescripcion').val('');
        $('#txtStock').val('');
        $("#selProducto").val('');
        $("#table_historial_compra tbody").html('');
        $("#table_historial_venta tbody").html('');
        $("#table_separaciones tbody").html('');
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
           
           $("#ckIncluyeIgv").prop("checked", true);
           $("#ckIncluyeIgv").prop("disabled", true);
           $("#ckPUIncluyeIsc").prop("disabled", true);
           $("#ckIncluyeISC").prop("disabled", true);
       }else {

           var contador=0;
           $('#table_componente tbody tr').each(function(){
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
               
                $("#ckIncluyeIgv").prop("disabled", false);
                $("#ckPUIncluyeIsc").prop("disabled", false);
                $("#ckIncluyeISC").prop("disabled", false);
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
           $("#ckIncluyeIgv").prop("checked",true);
           $("#ckIncluyeIgv").prop("disabled", true);
           $("#ckPUIncluyeIsc").prop("disabled", true);
           $("#ckIncluyeISC").prop("disabled", true);
       }else {
           var contador=0;
           $('#table_adicional tbody tr').each(function(){
               contador++;
           });
           if(contador>0){
              $(this).prop('checked', true);
               toastem.error('El producto tiene productos adicionales, debes eliminarlos para seleccionar que no tiene adicional. ');

           }else{
                $("#ckIncluyeIgv").prop("disabled", false);
                $("#ckPUIncluyeIsc").prop("disabled", false);
                $("#ckIncluyeISC").prop("disabled", false);
           }
           
       }
   });
    $("#ckIncluyeISC").click(function(){
        if($(this).is(":checked")){
            $("#selTipoISC").prop("disabled",false);
            $("#txtPorcentajeISC").prop("disabled",false);
            $("#txtIscValor_Calculo").prop("disabled",false);
            
            
        }else{
            $("#selTipoISC").prop("disabled",true);
             $("#txtPorcentajeISC").prop("disabled",true);
             $("#txtIscValor_Calculo").prop("disabled",true);
        }
        $("#txtPorcentajeISC").val("");
        $("#txtIscValor_Calculo").val("");
        ProductoValores();
    });
    function bloquear_con_hijo(){
        $("#ckIncluyeIgv").prop("checked", true);
        $("#ckIncluyeIgv").prop("disabled", true);
        $("#ckPUIncluyeIsc").prop("checked", false);
        $("#ckPUIncluyeIsc").prop("disabled", true);
        $("#ckIncluyeISC").prop("checked", false);
        $("#ckIncluyeISC").prop("disabled", true);
        $("#selTipoISC").prop("disabled", true);
        $("#txtPorcentajeISC").prop("disabled", true);
        $("#txtIscValor_Calculo").prop("disabled", true);
    }
    function desbloquear_con_hijo(){
        
        $("#ckIncluyeIgv").prop("disabled", false);
       
        $("#ckPUIncluyeIsc").prop("disabled", false);
       
        $("#ckIncluyeISC").prop("disabled", false);
       
        
    }
    </script>
</form>

 
 <?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
           mensaje.error("Ocurrió un error en el sistema",'<?php echo $GLOBALS['mensaje'];?>');
       
       // setTimeout('window_float_save();', 1000);
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

<script type="text/javascript">
 //alert('hola');
 $(document).ready(function () {
     $.unblockUI();
    toastem.success('<?php echo $GLOBALS['mensaje'];?>');
    <?php if($GLOBALS['oOrden_Venta_Detalle']->tipo_ID==1){ ?>
    setTimeout('parent.windos_float_save_modal_hijo();', 1000);
   
    <?php } ?>
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
