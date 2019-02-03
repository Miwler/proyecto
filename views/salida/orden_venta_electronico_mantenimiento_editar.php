<?php		
	require ROOT_PATH . "views/shared/content-view.php";	
?>	
<?php function fncTitle(){?>Editar Venta<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jPdf.js"></script>
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>
    <link rel="stylesheet" type="text/css" href="include/css/factura.css" /> 
    <script type="text/javascript" src="include/jszip/dist/jszip.js"></script>
    <script type="text/javascript" src="include/jszip/vendor/FileSaver.js"></script>    

<style>
    #tbProductos tbody td,#tbObsequios tbody td,#table_guias tbody td,#table_comprobantes td{
        font-size:12px;
    }
    .btn-group li a:hover{
        cursor:pointer;
    }
</style>
<?php } ?>

<?php function fncTitleHead(){ ?>Editar Venta<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==1||$GLOBALS['resultado']==-1){ ?>
<form id="form" method="POST" action="/Salida/Orden_Venta_Electronico_Mantenimiento_Editar/<?php echo $GLOBALS['oOrden_Venta']->ID?>" onsubmit="return validar();" class="form-horizontal form-bordered">
    <input type="hidden" id="txtCadena_Numero_Cuenta" name="txtCadena_Numero_Cuenta">
    <div class="panel panel-tab rounded shadow">
         <div class="panel-heading">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divCliente" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i> <span>Cliente</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divDatos_Generales" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Datos Generales</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divDatos_Economicos"><i class="fa fa-cc-visa" aria-hidden="true"></i> <span>Datos económicos</span></a></li>
                <li class="nav-item"><a href="#DivProductos" data-toggle="tab" ><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Productos</span></a></li>
                <li class="nav-item"><a href="#DivObsequios" data-toggle="tab" ><i class="fa fa-cubes"></i> <span>Obsequios</span></a></li>
                <li class="nav-item"><a href="#divComprobante" data-toggle="tab" ><i class="fa fa-file-text-o"></i> <span>Documentos</span></a></li>
                
            </ul>
            <div class="pull-right">
                
                    <button  id="btnEnviar" name="btnEnviar" class="grabar" >
                        Guardar
                    </button>
                    
                    <button title="Descargar cotización"  id="btnDescargar" name="btnDescargar" type="button" class="btn btn-danger" style="display:none">
                        <span class="glyphicon glyphicon-cloud-download"></span>
                        Cotización
                    </button>
                    
                    <button  id="btnCancelar" name="btnCancelar" class="salir" type="button" onclick="parent.window_save_view();" >
                       salir
                    </button>
                
            </div>
        </div>
        <div class="panel-body no-padding rounded-bottom">
            
            <div class="tab-content">
                <div id="divCliente" class="tab-pane fade in active inner-all">
                     <div class="row">
                         <div class="col-sm-7">
                             <div class="form-group form-group-divider form-group-inline">
                                <div class="form-inner">
                                    <h4 class="no-margin">Cliente</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3 col-md-3 col-sm-3">Razón social:<span class="asterisk">*</span> </label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <input type="hidden" id="selCliente" name="selCliente" value="<?php echo $GLOBALS['oOrden_Venta']->cliente_ID;?>">
                                    <input type="text" id="listaCliente" class="form-control" value="<?php echo FormatTextView($GLOBALS['oCliente']->ruc.' - '.$GLOBALS['oCliente']->razon_social);?>">

                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            lista('/funcion/ajaxListarClientes','listaCliente','selCliente',fncCargaValores,limpiarPadre);
                                        });

                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                 <label class="control-label col-lg-3 col-md-3 col-sm-3">Dirección: </label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <textarea id="txtDireccion" name="txtDireccion" disabled style="height: 60px;overflow:auto;resize:auto;" class="form-control form-requerido" ><?php echo utf8_encode(trim($GLOBALS['oCliente']->direccion)); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3 col-md-3 col-sm-3">Teléfono: </label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <input id="txtTelefono" name="txtTelefono" type="text" class="text-int form-control" autocomplete=off disabled value="<?php echo $GLOBALS['oCliente']->telefono; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3 col-md-3 col-sm-3">Contacto: </label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <select id="selRepresentante" name="selRepresentante" class="form-control"> 
                                        <option value="0">--</option>
                                        <?php if($GLOBALS['oCotizacion']->ID!=null){ 
                                        foreach($GLOBALS['dtCliente_Contacto'] as $item){?>
                                        <option value="<?php echo $item['ID']?>"><?php echo $item['apellidos'].''.$item['nombres']; ?></option>
                                            <?php }?>
                                        <script type="text/javascript">
                                            $('#selRepresentante').val(<?php echo $GLOBALS['oCotizacion']->representante_cliente_ID; ?>);
                                       </script>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>
                         </div>
                         <div class="col-sm-5">
                            <div class="form-group form-group-divider">
                                <div class="form-inner">
                                    <h4 class="no-margin">Ejecutivo</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2 col-md-2 col-sm-2">Nombres: </label>
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <input id="txtOperador_ID" name="txtOperador_ID" style="display:none;"   value="<?php echo $GLOBALS['oOperador']->ID;?>" /> 
                                    <input type="text" id="txtNombres_Vendedor" name="txtNombres_Vendedor"  disabled value="<?php echo $GLOBALS['oOperador']->nombres . ' '.$GLOBALS['oOperador']->apellido_paterno; ?>" class="form-control"/> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2 col-md-2 col-sm-2">Celular: </label>
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <input type="text" id="txtCelular1" name="txtCelular1"    disabled value="<?php echo $GLOBALS['oOperador']->celular; ?>" class="form-control"/> 
                                </div>
                            </div>
                            <div class="form-group">
                                 <label class="control-label col-lg-2 col-md-2 col-sm-2">Teléfono: </label>
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <input type="text"  id="txtTelefono_Vendedor" name="txtTelefono_Vendedor" disabled value="<?php echo $GLOBALS['oOperador']->telefono; ?>" class="form-control"/> 
                                </div>
                            </div> 
                         </div>
                     </div>
                    
                </div>
                <div id="divDatos_Generales" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Fecha:<span class="asterisk">*</span> </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtFecha" name="txtFecha" class="date-range-picker-single  form-control" value="<?php echo date("d/m/Y"); ?>" /> 
                        </div>
                       <label class="control-label col-lg-3 col-md-3 col-sm-3">Número: </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtCotizacion_ID" name="txtCotizacion_ID" value="<?php echo $GLOBALS['oOrden_Venta']->cotizacion_ID; ?>"style="display:none;">
                            <input type="text" id="txtID" name="txtID" value="<?php echo $GLOBALS['oOrden_Venta']->ID; ?>"style="display:none;">
                            <input id="txtNumero" name="txtNumero" type="text" class="text-int form-control" disabled autocomplete=off  value="<?php echo $GLOBALS['oOrden_Venta']->numero_concatenado; ?>" /> 
                        </div>
                    </div>
                    <div class="form-group">
                        
                       <label class="control-label col-lg-3 col-md-3 col-sm-3">N° Orden de compra: </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input id="txtNumero_Orden_Compra" name="txtNumero_Orden_Compra" type="text"  class="text-int form-control" autocomplete=off  value="<?php echo $GLOBALS['oOrden_Venta']->numero_orden_compra; ?>" />
                        </div>
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Plazo de entrega:<span class="asterisk">*</span> </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtPlazo_Entrega" name="txtPlazo_Entrega" placeholder="Días" class="int form-control" autocomplete="off"  value="<?php echo FormatTextView($GLOBALS['oOrden_Venta']->plazo_entrega);?>"/>
                        </div>
                    </div>
                    
                   
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Validez: </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtValidez_Oferta" placeholder="Días" autocomplete="off" name="txtValidez_Oferta" class="int form-control" value="<?php echo  $GLOBALS['oOrden_Venta']->validez_oferta; ?>" >
                        </div>
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Garantía: </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtGarantia" name="txtGarantia" autocomplete="off" placeholder="1 año" value="<?php echo $GLOBALS['oOrden_Venta']->garantia; ?>" class="form-control" >
                        </div>
                    </div>
                    
                     <div class="form-group">
                       <label class="control-label col-lg-3 col-md-3 col-sm-3">Lugar de entrega: </label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <textarea id="txtLugar_Entrega" name="txtLugar_Entrega" style="height: 40px; overflow:auto;resize:auto;" class="form-control"><?php echo trim($GLOBALS['oOrden_Venta']->lugar_entrega); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Observación: </label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <textarea id="txtObservacion" name="txtObservacion" class="comentario form-control" rows="1" cols="10" maxlength="150" style="height: 80px;overflow:auto;resize:none;"><?php echo $GLOBALS['oOrden_Venta']->observacion; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="ckbox ckbox-theme">
                                <input  type="checkbox" id="ckVer_Adicional" checked="checked" name="ckVer_Adicional" value="1" >
                                <label for="ckVer_Adicional">Adicional</label>
                            </div>
                            <script type='text/javascript'>
                                <?php if($GLOBALS['oOrden_Venta']->ver_adicional==1){ ?>
                                    $('#ckVer_Adicional').prop('checked',true);
                                <?php } ?>
                            </script>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <input type='text' id='txtAdicional' name='txtAdicional' maxlength="40"  value='<?php echo $GLOBALS['oOrden_Venta']->adicional;?>' class="form-control text-uppercase">
                        </div>
                    </div>
                </div>
                <div id="divDatos_Economicos" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Moneda: </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="cboMoneda" name="cboMoneda" class="form-control" onchange="fncCargarNumeroCuenta(this.value);" >
                            <?php foreach($GLOBALS['dtMoneda'] as  $iMoneda){?>
                                <option value="<?php echo $iMoneda['ID']; ?>" > <?php echo utf8_encode($iMoneda['descripcion']);?> </option>
                            <?php }?>
                            </select>
                            <script type="text/javascript">
                                $('#cboMoneda').val('<?php echo $GLOBALS['oOrden_Venta']->moneda_ID;?>');
                            </script>
                        </div>
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Tipo de cambio: </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio" autocomplete="off"  class="decimal form-control text-left" value="<?php echo $GLOBALS['oOrden_Venta']->tipo_cambio; ?>" />
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Forma de pago: </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selForma_Pago" name="selForma_Pago" class="form-control text-uppercase">
                                <?php foreach($GLOBALS['dtForma_Pago'] as $iForma_Pago){ ?>
                                <option value="<?php echo $iForma_Pago['ID']; ?>"> <?php echo utf8_encode($iForma_Pago['nombre']);?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                                   $('#selForma_Pago').val('<?php echo $GLOBALS['oOrden_Venta']->forma_pago_ID;?>')
                            </script> 
                        </div>
                        <label class="control-label col-lg-3 col-md-3 col-sm-3">Tiempo de crédito: </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selTiempo_Credito" name="selTiempo_Credito" class="form-control">
                                <option value="0">--</option>
                                <?php foreach($GLOBALS['dtCredito'] as $idtCredito){ ?>
                                <option value="<?php echo $idtCredito['dias'];?>"><?php echo $idtCredito['texto'];?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                                $('#selTiempo_Credito').val('<?php echo $GLOBALS['oOrden_Venta']->tiempo_credito;?>')
                            </script>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label >Nro. Cuentas: </label>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ContenedorCuadro" style="overflow:auto;">
                            <?php echo $GLOBALS['dtNumero_Cuenta'];?>
                        </div>
                    </div>
                   
                </div>
                
                <div class="tab-pane fade inner-all" id="DivProductos">
                    
                    
                    <div class="form-group">
                        <input type="hidden" id="gravadas" name="gravadas" value="<?php echo $GLOBALS['oOrden_Venta']->gravadas;?>">
                        <input type="hidden" id="exoneradas" name="exoneradas" value="<?php echo $GLOBALS['oOrden_Venta']->exoneradas;?>">
                        <input type="hidden" id="inafectas" name="inafectas" value="<?php echo $GLOBALS['oOrden_Venta']->inafectas;?>">
                        <input type="hidden" id="precio_venta_total_soles" name="precio_venta_total_soles" value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_total_soles;?>">
                        <input type="hidden" id="precio_venta_total_dolares" name="precio_venta_total_dolares" value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_total_dolares;?>">
                        <input type="hidden" id="vigv_soles" name="vigv_soles" value="<?php echo $GLOBALS['oOrden_Venta']->vigv_soles;?>">
                        <input type="hidden" id="vigv_dolares" name="vigv_dolares" value="<?php echo $GLOBALS['oOrden_Venta']->vigv_dolares;?>">
                        <div class="col-sm-2">
                            <button  type="button" id="btnAgregar" name="btnDetalle" class='btn btn-success' onclick="fncRegistrar_Productos();" title="Agregar producto" >
                                <span class="glyphicon glyphicon-plus"></span>
                                Agregar
                            </button>
                        </div>
                        <label class="control-label col-sm-1" id="lbMoneda1">
                            
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon bg-teal">Descuento %</span>
                               <input type="text" id="txtPorcentaje_Descuento" name="txtPorcentaje_Descuento" class="form-control no-border-left moneda" autocomplete="off" onkeyup="calcularPorcentajeDescuento(this.value,'porcentaje');" value="<?php echo $GLOBALS['oOrden_Venta']->porcentaje_descuento;?>">
                            </div>
                            
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-addon bg-teal">Descuento global</span>
                               <input type="text" id="txtDescuento_Global" name="txtDescuento_Global" class="form-control no-border-left moneda" autocomplete="off"  onkeyup="calcularPorcentajeDescuento(this.value,'total');"  value="<?php echo $GLOBALS['oOrden_Venta']->descuento_global?>">
                            </div>
                            
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                               <span class="input-group-addon bg-teal">Otros cargos</span>
                               <input type="text" id="txtOtros_Cargos" name="txtOtros_Cargos" class="form-control no-border-left moneda" autocomplete="off" value="<?php echo $GLOBALS['oOrden_Venta']->otros_cargos?>" onkeyup="calcularPorcentajeDescuento($('#txtPorcentaje_Descuento').val(),'porcentaje')" >
                            </div>  
                        </div>
                       
                    </div>
                    <div class="divCuerpo" id="productos">
                        
                    </div>
                </div>
                <div class="tab-pane fade inner-all" id="DivObsequios">
                    
                    <button  type="button" id="btnAgregarObsequio" name="btnAgregarObsequio" class='btn btn-info' onclick="fncRegistrar_Obsequios();" title="Agregar obsequio" >
                        <span class="glyphicon glyphicon-plus"></span>
                        Agregar
                    </button>
                    
                     <div class="divCuerpo" id="obsequios">
                        
                    </div>
                </div>
                <div class="tab-pane fade inner-all" id="divComprobante">
                    <div class="form-group form-group-divider">
                        <div class="form-inner">
                            <h4 class="no-margin">Comprobante</h4>
                        </div>
                    </div>
                    <button  type="button" id="btnComprobantes" name="btnComprobantes" class='btn btn-info' onclick="fncRegistrar_Comprobante();" title="Agregar comprobante de venta" >
                        <span class="glyphicon glyphicon-plus"></span>
                        Agregar
                    </button>
                    <table id="table_comprobantes" class="table table-hover table-bordered table-teal">
                        <thead>
                            <tr><th class="text-center">N°</th><th class="text-center">Tipo</th><th class="text-center">Número</th><th class="text-center">Fecha</th><th class="text-center">Fecha vencimiento</th><th class="text-center">Total</th><th class="text-center">Estado</th><th></th></tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    <div class="form-group form-group-divider  margin-top">
                        <div class="form-inner">
                            <h4 class="no-margin">Guía</h4>
                        </div>
                    </div>
                    <button  type="button" id="btnGuia" name="btnGuia" class='btn btn-info' onclick="fncRegistrar_Guia();" title="Agregar Guía de remisión" >
                        <span class="glyphicon glyphicon-plus"></span>
                        Agregar
                    </button>
                    <?php if($GLOBALS['oOrden_Venta']->impresion==1) { ?>
                        <button id='btnImprimiendo' type="button" class="btn btn-info" onclick='$("#ModalResultadoImpresion").modal("show");'>Imprimiendo</button>
                        <?php }?>
                    
                    <div id="contenedor_imprimir">
                        
                    </div>
                    <table id="table_guias" class="table table-hover table-bordered table-teal">
                        <thead>
                            <tr><th class="text-center">N°</th><th class="text-center">Número</th><th class="text-center">Fecha emisión</th><th class="text-center">Vehículo</th><th class="text-center">Chofer</th><th class="text-center">Estado</th><th></th></tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
              
            </div>
        </div>
        
    </div>
    <input id="txtOrden" name="txtOrden" type="text"  style="display:none;">
    <input id="chkOrdenASC" name="chkOrdenASC"   value="ASC" style="display:none;">

</form>
<div id="divContenedorDetalle" style="display:none;">
    
</div>
 
<script type="text/javascript">
    $(document).ready(function(){
        fncCargar_Detalle_Orden_Venta();
        fncCargar_Comprobantes_Ventas();
        fncCargar_Guias_Ventas();
        <?php if($GLOBALS['oOrden_Venta']->cotizacion_ID>0){?>
                $("#btnDescargar").css("display","");
        <?php }?>
            <?php if($GLOBALS['oOrden_Venta']->moneda_ID==1){?>
                
                $("#lbMoneda1").html('S/.');
            <?php } else {?>
                 $("#lbMoneda1").html('USD.');
                
            <?php }?>
    });
    function calcularPorcentajeDescuento(valor,tipo){
        var moneda_ID=$("#cboMoneda").val();
        var porcentaje=0;
        var descuento_total=0;
        var gravada=parseFloat($.trim($('#gravadas').val()).split(',').join(''));
        var inafecta=parseFloat($.trim($('#inafectas').val()).split(',').join(''));
        var exonerada=parseFloat($.trim($('#exoneradas').val()).split(',').join(''));
        var valor_igv=0;
        var importe_total=0;
        if(moneda_ID==1){
            valor_igv=parseFloat($.trim($('#vigv_soles').val()).split(',').join(''));
            importe_total=parseFloat($.trim($('#precio_venta_total_soles').val()).split(',').join(''));
        }else{
            valor_igv=parseFloat($.trim($('#vigv_dolares').val()).split(',').join(''));
            importe_total=parseFloat($.trim($('#precio_venta_total_dolares').val()).split(',').join(''));
        }
        
    
        var coeficiente=0;
        switch(tipo){
            case "total":
                coeficiente=redondear(valor/gravada,2);
                porcentaje=redondear(coeficiente*100,2);
                descuento_total=valor;
                $("#txtPorcentaje_Descuento").val(porcentaje);
                break;
            
            case "porcentaje":
                var sub_total=0;
                coeficiente=valor/100;
                descuento_total=redondear(coeficiente*gravada,2); 
                porcentaje=valor;
             
                $("#txtDescuento_Global").val(descuento_total);
            
                break;
        }
        var otros_cargos=parseFloat(($.trim($("#txtOtros_Cargos").val())=="")?0:$("#txtOtros_Cargos").val());
        gravada=gravada*(1-coeficiente);
        inafecta=inafecta*(1-coeficiente);
        exonerada=exonerada*(1-coeficiente);
        valor_igv=valor_igv*(1-coeficiente);
        importe_total=importe_total*(1-coeficiente)+otros_cargos;
        
        $('#tdGravada').text(financiero(gravada))
        $('#tdInafecta').text(financiero(inafecta))
        $('#tdExonerada').text(financiero(exonerada))
        $('#tdIgv').text(financiero(valor_igv))
        $('#tdTotal').text(financiero(importe_total))
    }
    $('.nav-tabs a').on('show.bs.tab', function(event){
        var x = $.trim($(event.target).text());   
       
        switch(x){
            case "Productos":
                fncCargar_Detalle_Orden_Venta();
                break;
            case "Obsequios":
                fncCargar_Detalle_Obsequios();
                break;
        }
         
        
     });
 
    
    var fncOrden = function (col) {

        var col_old = $('#txtOrden').val();
        var tipo=$('#chkOrdenASC').val();
        if (col_old == col) {
            if(tipo=="ASC"){
                $('#chkOrdenASC').val('DESC');va
            }else {
                 $('#chkOrdenASC').val('ASC');
            }
           
        } else {
            $('#txtOrden').val(col);
            $('#chkOrdenASC').val('ASC');
        }
        fncCargar_Detalle_Cotizacion();

    }
   
    

     //Opción para editar los detalles
   var fncRegistrar_Productos=function(){
        var orden_venta_ID=$('#txtID').val();
        //window_float_deslizar('form','/Ventas/orden_venta_mantenimiento_producto_nuevo',orden_venta_ID,'',fncCargar_Detalle_Orden_Venta);
        parent.window_float_open_modal_hijo("AGREGAR NUEVO PRODUCTO","Salida/orden_venta_mantenimiento_producto_nuevo",orden_venta_ID,"",fncCargar_Detalle_Orden_Venta,700,590);
    }
    var fncEditarProducto=function(id){
        parent.window_float_open_modal_hijo("EDITAR PRODUCTO","Salida/Orden_Venta_Mantenimiento_Producto_Editar",id,"",fncCargar_Detalle_Orden_Venta,700,590);
       
    }
    var fncVerProducto=function(id){
        parent.window_float_open_modal_hijo("VER PRODUCTO","Salida/Orden_Venta_Mantenimiento_Producto_Editar",id,"",fncCargar_Detalle_Orden_Venta,700,590);
       
    }
    var fncRegistrar_Obsequios=function(){
        var orden_venta_ID=$('#txtID').val();
        //window_float_deslizar('form','/Ventas/Orden_Venta_Mantenimiento_Obsequio_Nuevo',orden_venta_ID,'',fncCargar_Detalle_Obsequios);
        parent.window_float_open_modal_hijo("AGREGAR NUEVO OBSEQUIO","Salida/Orden_Venta_Mantenimiento_Obsequio_Nuevo",orden_venta_ID,"",fncCargar_Detalle_Obsequios,700,600);
    }
    
    var fncEditarObsequio=function(id){

         parent.window_float_open_modal_hijo("EDITAR OBSEQUIO","Salida/Orden_Venta_Mantenimiento_Obsequio_Editar",id,"",fncCargar_Detalle_Obsequios,700,600);
    }
    var fncSeries=function(id){
       parent.window_float_open_modal_hijo("REGISTRAR SERIE","Salida/Orden_Venta_Mantenimiento_Producto_Serie",id,"",fncCargar_Detalle_Orden_Venta,700,500);
            
    }
    var fncEliminarProducto=function(ID){
        cargarValores('/Salida/ajaxOrden_Venta_Detalle_Mantenimiento_Eliminar',ID,function(resultado){   
            if(resultado.resultado==1){
                fncCargar_Detalle_Orden_Venta();
                toastem.info(resultado.mensaje);
            }else { 
                toastem.error(resultado.mensaje);
            }
        });
    }
    var fncEliminarObsequio=function(ID){
        cargarValores('/Salida/ajaxOrden_Venta_Detalle_Mantenimiento_Eliminar',ID,function(resultado){
            if(resultado.resultado==1){
                
                fncCargar_Detalle_Obsequios();

                toastem.info(resultado.mensaje);
            }else { 
                toastem.error(resultado.mensaje);
            }
        });
    }
   
    var fncCargar_Detalle_Orden_Venta=function(){
       
        var orden_venta_ID=$('#txtID').val();
        
        var tiempo=$('#txtTiempo_Avance').val();
        var orden=$('#txtOrden').val();
        var tipo=$('#chkOrdenASC').val();
        //$('#divContenedor_Float_Hijo').css('display', 'block');
        cargarValores("Salida/ajaxOrden_Venta_Detalle_Productos",orden_venta_ID,function(resultado){
            
            $('#productos').html(resultado.resultado);
            $('#subtotal').html(resultado.subtotal);
            $('#vigv').html(resultado.vigv);
            $('#total').html(resultado.total);
             $("#gravadas").val(resultado.gravadas);
            $("#exoneradas").val(resultado.exoneradas);
            $("#inafectas").val(resultado.inafectas);
            $("#precio_venta_total_soles").val(resultado.precio_venta_total_soles);
            $("#precio_venta_total_dolares").val(resultado.precio_venta_total_dolares);
            $("#precio_venta_total_dolares").val(resultado.precio_venta_total_dolares);
            $("#vigv_soles").val(resultado.vigv_soles);
          
        });
    }
    
    var fncCargar_Detalle_Obsequios=function(){
        var orden_venta_ID=$('#txtID').val();
        if(orden_venta_ID>0){
            //$('#divContenedor_Float_Hijo').css('display', 'block');
            cargarValores("Salida/ajaxOrden_Venta_Detalle_Obsequios",orden_venta_ID,function(resultado){
                //alert(resultado.resultado);
                $('#obsequios').html(resultado.resultado);
                //fncSeleccionarDetalle();
            });
        }
        
    }
    var fncRegistrar_Comprobante=function(){
        var orden_venta_ID=$('#txtID').val();
        //window_float_deslizar('form','/Ventas/orden_venta_mantenimiento_producto_nuevo',orden_venta_ID,'',fncCargar_Detalle_Orden_Venta);
        parent.window_float_open_modal_hijo("AGREGAR COMPROBANTE DE VENTA","Salida/Orden_Venta_Electronico_Mantenimiento_Comprobante_Nuevo",orden_venta_ID,"",fncCargar_Comprobantes_Ventas,700,450);
    }
    var fncEditarComprobante=function(ID){
       
        //window_float_deslizar('form','/Ventas/orden_venta_mantenimiento_producto_nuevo',orden_venta_ID,'',fncCargar_Detalle_Orden_Venta);
        parent.window_float_open_modal_hijo("EDITAR COMPROBANTE DE VENTA","Salida/Orden_Venta_Electronico_Mantenimiento_Comprobante_Editar",ID,"",fncCargar_Comprobantes_Ventas,700,450);
    }
    var fncVerComprobante =function(ID){
       
        //window_float_deslizar('form','/Ventas/orden_venta_mantenimiento_producto_nuevo',orden_venta_ID,'',fncCargar_Detalle_Orden_Venta);
        parent.window_float_open_modal_hijo("VER COMPROBANTE DE VENTA","Salida/Orden_Venta_Electronico_Mantenimiento_Comprobante_Editar",ID,"",fncCargar_Comprobantes_Ventas,700,450);
    }
    var fncCargar_Comprobantes_Ventas=function(){
        var orden_venta_ID=$('#txtID').val();
        block_ui(function(){
            try{
                var object=new Object();
                object['salida_ID']=orden_venta_ID;
                enviarAjax('/Salida/ajaxFilasComprobantes_Ventas','frm1',object,function(res){
                    $.unblockUI();
                    
                    var respuesta = $.parseJSON(res);
                     
                    
                    $("#table_comprobantes tbody").html(respuesta.html);
                    if(respuesta.bloquear_edicion>0){
                        bloquear_edicion();
                    }
                    if(respuesta.ver_boton_agregar>0){
                        $("#btnComprobantes").css("display","none");
                    }
                });
            }catch(e){
                $.unblockUI();
            }
            
        });
        
    }
    var fncEliminarComprobante=function(ID){
        cargarValores('Salida/ajaxOrden_Venta_Electronico_Mantenimiento_Comprobante_Eliminar',ID,function(resultado){
            if(resultado.resultado==1){
                toastem.info(resultado.mensaje);
                fncCargar_Comprobantes_Ventas();
                $("#btnComprobantes").css("display","");
            }else{
                mensaje.error("Ocurrió un error",resultado.mensaje);
            }
        });
    }
    var fncCargar_Guias_Ventas=function(){
        var orden_venta_ID=$('#txtID').val();
        block_ui(function(){
            try{
                var object=new Object();
                object['salida_ID']=orden_venta_ID;
                enviarAjax('/Salida/ajaxFilasGuias_Ventas','frm1',object,function(res){
                    $.unblockUI();
                    var respuesta = $.parseJSON(res);
                    $("#table_guias tbody").html(respuesta.html);
                    if(respuesta.bloquear_edicion>0){
                        bloquear_edicion();
                    }
                    if(respuesta.ver_boton_agregar>0){
                        $("#btnGuia").css("display","none");
                    }
                    $("#contenedor_imprimir").html(respuesta.boton_imprimir);
                });
            }catch(e){
                $.unblockUI();
            }
            
        });
        
    }
    var fncRegistrar_Guia=function(){
        var orden_venta_ID=$('#txtID').val();
        //window_float_deslizar('form','/Ventas/orden_venta_mantenimiento_producto_nuevo',orden_venta_ID,'',fncCargar_Detalle_Orden_Venta);
        parent.window_float_open_modal_hijo("AGREGAR GUÍA DE VENTA","Salida/Orden_Venta_Electronico_Mantenimiento_Guia_Nuevo",orden_venta_ID,"",fncCargar_Guias_Ventas,700,450);
    }
    var fncEditarGuia=function(ID){
        parent.window_float_open_modal_hijo("EDITAR GUÍA DE VENTA","Salida/Orden_Venta_Electronico_Mantenimiento_Guia_Editar",ID,"",fncCargar_Guias_Ventas,700,450);
    }
    var fncVerGuia=function(ID){
        parent.window_float_open_modal_hijo("VER GUÍA DE VENTA","Salida/Orden_Venta_Electronico_Mantenimiento_Guia_Editar",ID,"",fncCargar_Guias_Ventas,700,450);
    }
    var fncEliminarGuia=function(ID){
        cargarValores('Salida/ajaxOrden_Venta_Electronico_Mantenimiento_Guia_Eliminar',ID,function(resultado){
            if(resultado.resultado==1){
                toastem.info(resultado.mensaje);
                fncCargar_Guias_Ventas();
                $("#btnGuia").css("display","");
            }else{
                mensaje.error("Ocurrió un error",resultado.mensaje);
            }
        });
    }
    var fncCargaValores=function(id){
        try{
            block_ui(function(){
                cargarValores('/Salida/ajaxCotizacion_Detalle_Cliente',id,function(resultado){
                    $('#txtDireccion').val(resultado.Direccion);
                    $('#txtLugar_Entrega').val(resultado.Direccion);
                    $('#txtTelefono').val(resultado.Telefono);
                    $('#selRepresentante').html(resultado.lista_representante); 
                    $('#selForma_Pago').val(resultado.Forma_pago);
                    $('#selTiempo_Credito').val(resultado.Tiempo_Credito);
                    $('#txtOperador_ID').val(resultado.operador_ID);
                    $('#txtNombres_Vendedor').val(resultado.operador);
                    $('#txtTelefono_Vendedor').val(resultado.operador_telefono);
                    $('#txtCelular1').val(resultado.operador_celular1);
                    $.unblockUI();
                });
            });
        }catch (e){
            $.unblockUI();
            console.log(e);
        }
        

    }
    
    var fncCargarNumeroCuenta=function(moneda_ID){
        if(moneda_ID==1){
            $("#lbMoneda1").html('S/.');
            $('#lbMoneda').html('Soles (S/.)');
           $('#tbnumero_cuenta .cssSoles').css('display','');
           $('#tbnumero_cuenta .cssDolares').css('display','none');

        }else {
            $('#lbMoneda').html('Dólares (USD.)');
            $("#lbMoneda1").html('USD.');
            $('#tbnumero_cuenta .cssSoles').css('display','none');
            $('#tbnumero_cuenta .cssDolares').css('display','');
        }

    }
    function limpiarPadre(){
        //alert(IDimagen);
       $('#txtDireccion').val('');
            $('#txtTelefono').val('');
            $('#selRepresentante').html('<option value="0">--</option>'); 
            $('#selForma_Pago').val('0');
            $('#txtNombres_Vendedor').val('');
            $('#txtTelefono_Vendedor').val('');
            $('#txtCelular1').val('');
    }
    var validar=function(){
        //$('#txtSubTotalSoles').removeAttr('disabled');
        var cliente_ID=$('#selCliente').val();
        var moneda_ID=$("#cboMoneda").val();
        var tipo_cambio=redondear(parseFloat($("#txtTipo_Cambio").val()),2);
        var Plazo_Entrega=$.trim($('#txtPlazo_Entrega').val());
        var Validez_Oferta=$('#txtValidez_Oferta').val();
        var Garantia=$.trim($('#txtGarantia').val());
        var SelForma_Pago = $.trim($('#selForma_Pago'));
        if(cliente_ID==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione un cliente.','selCliente');
            $('.nav-tabs a[href="#divCliente"]').tab('show');
            return false;
        }	



        if(isNaN(Plazo_Entrega)||$.trim(Plazo_Entrega)==""){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese un plazo de entrega.','txtPlazo_Entrega');
           $('.nav-tabs a[href="#divDatos_Generales"]').tab('show');
            return false;
        }
        if(isNaN(Validez_Oferta)||$.trim(Validez_Oferta)==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese un tiempo de validez de la oferta.','txtValidez_Oferta');
            $('.nav-tabs a[href="#divDatos_Generales"]').tab('show');
            return false;
        }
         if(Garantia==""){
             mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese un tiempo de garantía.','txtGarantia');
            $('.nav-tabs a[href="#divDatos_Generales"]').tab('show');
                return false;
        }
        if(SelForma_Pago=""){
            mensaje.error("VALIDACIÓN DE DATOS",'Ingrese una forma de pago.','selForma_Pago');
            $('.nav-tabs a[href="#divDatos_Economicos"]').tab('show');
            
        }
        var cadena_numero_cuenta='';     
        var i=0;
        $('#tbnumero_cuenta input:checkbox:checked').each(function(){
            if(i==0){
                cadena_numero_cuenta=this.value;
            }else{
                cadena_numero_cuenta=cadena_numero_cuenta+','+this.value;
            }
            i++;
            
        });
        if(cadena_numero_cuenta==''){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Selecciones como mínimo un número de cuenta.');
            $('.nav-tabs a[href="#divDatos_Economicos"]').tab('show');
            return false;
        }else{
            
           $("#txtCadena_Numero_Cuenta").val(cadena_numero_cuenta); 
        }
        $('#txtTiempo_Avance').removeAttr("disabled");
        $('#txtNumero').removeAttr('disabled');
        var gravadas=parseFloat($.trim($('#tdGravada').text()).split(',').join(''));
        var inafectas=parseFloat($.trim($('#tdInafecta').text()).split(',').join(''));
        var exoneradas=parseFloat($.trim($('#tdExonerada').text()).split(',').join(''));
        var vigv=parseFloat($.trim($('#tdIgv').text()).split(',').join(''));
        var importe_total=parseFloat($.trim($('#tdTotal').text()).split(',').join(''));
        
        if(moneda_ID==1){
            $("#precio_venta_total_soles").val(importe_total);
            $("#precio_venta_total_dolares").val(redondear(importe_total/tipo_cambio,2));
            $("#vigv_soles").val(vigv);
            $("#vigv_dolares").val(redondear(vigv/tipo_cambio,2));
        }else{
            $("#precio_venta_total_dolares").val(importe_total);
            $("#precio_venta_total_soles").val(redondear(importe_total*tipo_cambio,2));
            $("#vigv_dolares").val(vigv);
            $("#vigv_soles").val(redondear(vigv*tipo_cambio,2));
        }
        $("#gravadas").val(gravadas);
        $("#exoneradas").val(exoneradas);
        $("#inafectas").val(inafectas);
        block_ui();
    }
    var mostrarInformacion=function(orden_venta_ID){
        cargarValores('Salida/ajaxMostrarInformacion',orden_venta_ID,function(resultado){
            $('#txtID').val(resultado.orden_venta_ID);
            $('#txtCotizacion_ID').val(resultado.cotizacion_ID);
            //cboCliente.seleccionar(resultado.cliente_ID,resultado.Ruc+'-'+resultado.Razon_Social);
             $('#txtDireccion').val(resultado.Direccion);
             $('#txtTelefono').val(resultado.Telefono);
             $('#selRepresentante').html(resultado.lista_representante); 
             $('#selForma_Pago').val(resultado.Forma_pago);
             $('#txtLugar_Entrega').val(resultado.Lugar_Entrega);
             $('#txtObservacion').val(resultado.Observacion);
             
             $('#txtNumero').val(resultado.Numero_Concatenado);
             $('#cboMoneda').val(resultado.moneda_ID);
             $('#txtTipo_Cambio').val(resultado.Tipo_Cambio);
             $('#txtPlazo_Entrega').val(resultado.Plazo_Entrega);
             $('#selTiempo_Credito').val(resultado.Tiempo_Credito);
             $('#txtValidez_Oferta').val(resultado.Validez_Oferta);
             
             $('#txtOperador_ID').val(resultado.operador_ID);
             $('#txtNombres_Vendedor').val(resultado.operador);
             $('#txtDireccion_Vendedor').val(resultado.operador_direccion);
             $('#txtTelefono_Vendedor').val(resultado.operador_telefono);
             $('#txtCelular1').val(resultado.operador_celular1);
             $('#txtGarantia').val(resultado.Garantia);
             $('#btnDescargar').css('display','block');
             $('#btnDescargar').prop('src','');
             var arrayID=resultado.numero_cuenta_IDs.split(",");
             if(arrayID.length>0){
                 for(var i in arrayID){

                     $('#cknumero_cuenta'+arrayID[i]).attr('checked','checked');
                 }
             }
             $('#btnImportar').css('display', 'none');
             mostrarBotones();
             fncCargar_Detalle_Orden_Venta();
             
        });
    }
    $('#btnDescargar').click(function(){
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        
        if(cotizacion_ID!=''){
             pdf.descargar('Salida/Cotizacion_PDF/'+cotizacion_ID);
        }else {
            toastem.error('No existe cotización');
        }
       
    });
    var mostrarBotones=function(){
        $('#btnAgregar').css('display','block');
        $('#btnAgregarObsequio').css('display','block');
        
    }
    var ocultarBotones=function(){
        $('#btnAgregar').css('display','none');
        $('#btnAgregarObsequio').css('display','none');
        
    }

    var bloquear_edicion=function(){
        $('#listaCliente').prop('disabled', true);
      
       $('#selRepresentante').prop('disabled',true);
       $('#selForma_Pago').prop('disabled',true);
       
       $('#txtLugar_Entrega').prop('disabled',true);
       $('#cboMoneda').prop('disabled',true);
       $('#txtTipo_Cambio').prop('disabled',true);
       $('#txtPlazo_Entrega').prop('disabled',true);
       $('#selTiempo_Credito').prop('disabled',true);
       $('#txtValidez_Oferta').prop('disabled',true);
       $('#txtNumero_Orden_Compra').prop('disabled',true);
       $('#txtFecha').prop('disabled',true);
       $('#txtGarantia').prop('disabled',true);
       $('#txtObservacion').prop('disabled',true);
       $('#txtAdicional').prop('disabled',true);
       $('#ckVer_Adicional').prop('disabled',true);
       //Ocultamos los botones
       $('#btnEnviar').prop('disabled',true);
       $('#btnEnviar').css('display', 'none');
       //$('#btnAgregar').prop('disabled',true);
       $('#btnAgregar').css('display', 'none');
       $("#btnAgregarObsequio").css('display', 'none');
       $("#txtPorcentaje_Descuento").prop('disabled',true);
       $("#txtDescuento_Global").prop('disabled',true);
       $("#txtOtros_Cargos").prop('disabled',true);
      
       $('#tbnumero_cuenta input').each(function(){
           $(this).prop('disabled',true);
       });
       $('#btnEliminar').prop('disabled',true);
      // $('#').prop('disabled',true);
   }
    function fncEnviarSUNAT(id) {
        try {
            block_ui(function () {
                cargarValores('Salida/ajaxEnviarSUNAT',id,function(resultado){
                $.unblockUI();

                if (resultado.resultado == 1) {
                    toastem.success(resultado.mensaje);
                    $("#btnEnviarFactura").remove();
                    $('#txtEstado').val('Enviado a SUNAT');
                    $('#tdfacturas_detalle').html(resultado.facturas_detalle);
                    fncCargar_Comprobantes_Ventas();
                    
                    //alert(obj.MensajeRespuesta);
                }else if(resultado.resultado==2){
                    mensaje.advertencia("ADVERTENCIA",resultado.mensaje);
                    $("#btnEnviarFactura").remove();
                    $('#txtEstado').val('Enviado a SUNAT');
                    $('#tdfacturas_detalle').html(resultado.facturas_detalle);
                    fncCargar_Comprobantes_Ventas();
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
    function fncDarBajaSUNAT(id) {
        try {
            block_ui(function () {
                cargarValores('Salida/ajaxDarBajaSUNAT',id,function(resultado){
                $.unblockUI();

                if (resultado.resultado == 1) {
                    toastem.success(resultado.mensaje);
                    /*$("#btnEnviarFactura").remove();
                    $('#txtEstado').val('Enviado a SUNAT');
                    $('#tdfacturas_detalle').html(resultado.facturas_detalle);
                    fncCargar_Comprobantes_Ventas();*/
                    
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
    var fncDOWNLOAD_XML=function(id,tipo) {
        try {
            block_ui(function () {


            var iframe = document.getElementById("iPDF");
            if (tipo == 'PDF') {
                pdf.descargar("salida/Factura_Vista_PreviaPDF/"+id);
            //fncVerPDF(id);

                $.unblockUI();
                return false;
            }

            var zip = new JSZip();
                    $.ajax({
                type: "POST",
                url: 'Salida/ajaxDownloadXML',
                data: {'id': id,'tipo': tipo},
                cache: false,
                success: function(resultado)
                {
                $.unblockUI();
                //console.log(resultado);
                var obj = $.parseJSON(resultado);

                    if (obj.exito == 'true') {
                        if (tipo == 'XML') {
                            var xmlText = formatXml(obj.xml_firmado);
                            var blob = new Blob([xmlText], { type: 'application/xml' });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = obj.nombre_archivo;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }

                        if (tipo=='CDR') {
                        zip.generateAsync({type:"base64"}).then(function (base64) {
                            data = obj.xml_firmado;
                            location.href="data:application/zip;base64," + data;
                        });
                        }
                    }else{
                            alert(obj.mensaje);
                    }
            },
                error: function (XMLHttpRequest, textStatus, errorThrown)
                {
                    alert('Error occurred while opening fax template'
                          + getAjaxErrorString(textStatus, errorThrown));
                }
            });
        });

        } catch (e) {
                $.unblockUI();
                console_log(e);
        } finally {

        }

    }
    function formatXml(xml){
        var formatted = '';
        var reg = /(>)(<)(\/*)/g;
        xml = xml.replace(reg, '$1\r\n$2$3');
        var pad = 0;
        jQuery.each(xml.split('\r\n'), function(index, node) {
            var indent = 0;
            if (node.match( /.+<\/\w[^>]*>$/ )) {
                indent = 0;
            } else if (node.match( /^<\/\w/ )) {
                if (pad != 0) {
                    pad -= 1;
                }
            } else if (node.match( /^<\w[^>]*[^\/]>.*$/ )) {
                indent = 1;
            } else {
                indent = 0;
            }

            var padding = '';
            for (var i = 0; i < pad; i++) {
                padding += '  ';
            }

            formatted += padding + node + '\r\n';
            pad += indent;
        });

        return formatted;
    }
    function fncEnviarGuiaSUNAT(id) {
        try {
            block_ui(function () {
                cargarValores('Salida/ajaxEnviarGuiaSUNAT',id,function(resultado){
                $.unblockUI();
                if (resultado.resultado == 1) {
                    toastem.success(resultado.mensaje);
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
    var fncImprimirGuia=function(salida_ID){
        //$('#fondo_espera').css('display','block');
        //var orden_venta_ID=$('#txtSalida_ID').val();
        // var orden_venta_ID=909;
        try{
            
            block_ui(function(){
                cargarValores('/Salida/ajaxImprimir_Guia_Venta',salida_ID,function(resultado){
                //alert(resultado.resultado);
                if(resultado.resultado==1){
                    $("#txtDocumento").val(resultado.serie+' - '+resultado.numero);
                    $("#ModalResultadoImpresion").modal("show");
                    $("#txtNumero_Hojas").val(resultado.cantidad_pagina);
                    //$('#txtEstado').val('Emitido');
                    //$('#tdguia_detalle').html(resultado.guia_detalle);
                    //bloquear_guia();
                    //$('#btnAnular').css('display','');
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
        object["salida_ID"]=$('#txtID').val();
        //object["salida_ID"]=903;
            enviarAjax('/Salida/ajaxValidarImpresion_Guia_Venta','frmValidacionImpresion',object,function(res){
                var respuesta = $.parseJSON(res);
               fncCargar_Guias_Ventas();
                if(respuesta.resultado=='2'){
                    $("#btnImprimiendo").css("display","none");
                    limpiar_verificacion();
                    $("#ModalResultadoImpresion").modal("hide");
                    
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
<?php }?>
<iframe id="fra" style="display: none; height: 150px;" src="salida/get_Factura_Vista_PreviaPDF/654"></iframe>   
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
<div><?php echo $GLOBALS['mensaje']; ?></div>
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
        mostrarBotones();
        fncCargar_Detalle_Orden_Venta();
    });
   
   //ampliarVentanaVertical(750,'form');
    
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
<!--
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalResultadoImpresion">
  Launch demo modal
</button>-->

	     
<?php }?>    
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
