<?php		
	//require ROOT_PATH . "views/shared/content-float-modal.php";
        require ROOT_PATH . "views/shared/content-view.php";	
?>	
<?php function fncTitle(){?>Registrar Venta<?php } ?>

<?php function fncHead(){?>
	
	<script type="text/javascript" src="include/js/jForm.js"></script>
 
        <script type="text/javascript" src="include/js/jPdf.js"></script>
        <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>
        <link rel="stylesheet" type="text/css" href="include/css/factura.css" /> 
        
<script>
    $(document).ready(function(){
        

        <?php if($GLOBALS['oOrden_Venta']->ver_factura==1){?>
            crear_boton_factura();
        <?php } ?> 
        <?php if($GLOBALS['oOrden_Venta']->ver_guia==1){?>
                crear_boton_guia();
        <?php } ?> 
        <?php if($GLOBALS['oOrden_Venta']->impresion==1){?>
            crear_boton_QuitarPrint();
        <?php } ?> 
    });
</script>
<?php } ?>

<?php function fncTitleHead(){ ?>Registrar Venta<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==1||$GLOBALS['resultado']==-1){ ?>
<form id="form" method="POST" action="/Salida/Orden_Venta_Mantenimiento_Nuevo" onsubmit="return validar();" class="form-horizontal form-bordered">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divCliente" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i> <span>Cliente</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divDatos_Generales" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Datos Generales</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divDatos_Economicos"><i class="fa fa-cc-visa" aria-hidden="true"></i> <span>Datos económicos</span></a></li>
               
                <li class="nav-item"><a href="#DivProductos" data-toggle="tab" ><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Productos</span></a></li>
                <li class="nav-item"><a href="#DivObsequios" data-toggle="tab" ><i class="fa fa-cubes"></i> <span>Obsequios</span></a></li>
            </ul>
            <div class="pull-right">
                <?php if($GLOBALS['oOrden_Venta']->cotizacion_ID==-1){?>
                    <button type='button'  id="btnImportar" name="btnImportar" title="Importar desde una cotización" class='btn btn-info' onclick="fncImportar();" >
                        <span class="glyphicon glyphicon-cloud-download"></span>
                        Importar
                    </button>
                    <?php } ?>
                    <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" >
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        Guardar
                    </button>
                    <button title="Descargar cotización"  id="btnDescargar" name="btnDescargar" type="button" class="btn btn-danger" style="display: none;">
                        <span class="glyphicon glyphicon-cloud-download"></span>
                        Cotización
                    </button>
                    <button  id="btnCancelar" name="btnCancelar" class="btn btn-warning" type="button" onclick="parent.window_save_view();" >
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Salir
                    </button>
            </div>
        </div>
       
        <div class="panel-body no-padding rounded-bottom" >
            
            <div class="tab-content">
                <div id="divCliente" class="tab-pane fade in active inner-all">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Cliente: </label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <input type="hidden" id="selCliente" name="selCliente" value="<?php echo $GLOBALS['oOrden_Venta']->cliente_ID;?>">
                                    <input type="text" id="listaCliente" class="form-control" value="<?php echo FormatTextView($GLOBALS['oCliente']->ruc.' '.$GLOBALS['oCliente']->razon_social);?>">

                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            lista('/funcion/ajaxListarClientes','listaCliente','selCliente',fncCargaValores);
                                        });

                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Dirección: </label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <textarea id="txtDireccion" name="txtDireccion" disabled style="height: 60px;" class="form-control form-requerido text-uppercase" ><?php echo FormatTextViewHtml(trim($GLOBALS['oCliente']->direccion)); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Teléfono: </label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <input id="txtTelefono" name="txtTelefono" type="text" class="text-int form-control" autocomplete=off disabled value="<?php echo $GLOBALS['oCliente']->telefono; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <label>Contacto: </label>
                                </div>
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
                            <div class="form-group form-group-divider form-group-inline">
                                <div class="form-inner">
                                    <h4 class="no-margin">Ejecutivo</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <label>Nombres: </label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <input id="txtOperador_ID" name="txtOperador_ID" style="display:none;"   value="<?php echo $GLOBALS['oOperador']->ID;?>" /> 
                                    <input type="text" id="txtNombres_Vendedor" name="txtNombres_Vendedor"  disabled value="<?php echo $GLOBALS['oOperador']->nombres . ' '.$GLOBALS['oOperador']->apellido_paterno; ?>" class="form-control"/> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <label>Celular: </label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <input type="text" id="txtCelular1" name="txtCelular1"    disabled value="<?php echo $GLOBALS['oOperador']->celular; ?>" class="form-control"/> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <label>Teléfono: </label>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <input type="text"  id="txtTelefono_Vendedor" name="txtTelefono_Vendedor" disabled value="<?php echo $GLOBALS['oOperador']->telefono; ?>" class="form-control"/> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div id="divDatos_Generales" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Fecha:<span class="asterisk">*</span> </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtFecha" name="txtFecha" class="date-range-picker-single form-control" value="<?php echo date("d/m/Y"); ?>" /> 
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Número: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtCotizacion_ID" name="txtCotizacion_ID" value="<?php echo $GLOBALS['oCotizacion']->ID; ?>"style="display:none;">
                            <input type="text" id="txtID" name="txtID" value="<?php echo $GLOBALS['oOrden_Venta']->ID; ?>"style="display:none;">
                            <input id="txtNumero" name="txtNumero" type="text" class="text-int form-control" disabled autocomplete=off  value="<?php echo $GLOBALS['oOrden_Venta']->numero_concatenado; ?>" /> 
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>N° Orden de compra: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input id="txtNumero_Orden_Compra" name="txtNumero_Orden_Compra" type="text"  class="text-int form-control" autocomplete=off  value="<?php echo $GLOBALS['oOrden_Venta']->numero_orden_compra; ?>" />
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Plazo de entrega: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtPlazo_Entrega" name="txtPlazo_Entrega" placeholder="Días" class="int form-control" autocomplete="off"  value="<?php echo $GLOBALS['oOrden_Venta']->plazo_entrega;?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Validez: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtValidez_Oferta" placeholder="Días" autocomplete="off" name="txtValidez_Oferta" class="int form-control" value="<?php echo  FormatTextView($GLOBALS['oOrden_Venta']->validez_oferta); ?>" >
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Garantía: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtGarantia" name="txtGarantia" autocomplete="off" placeholder="1 año" value="<?php echo FormatTextView($GLOBALS['oOrden_Venta']->garantia); ?>" class="form-control text-uppercase" >
                        </div>
                    </div>
                    
                   
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Lugar de entrega: </label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <textarea id="txtLugar_Entrega" name="txtLugar_Entrega" style="height: 40px;overflow:auto;resize:none;" class="form-control text-uppercase"><?php echo FormatTextViewHtml(trim($GLOBALS['oOrden_Venta']->lugar_entrega)); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Observación: </label>
                        </div>
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
                            <input type='text' id='txtAdicional' name='txtAdicional' maxlength="40"  value='<?php echo FormatTextViewHtml($GLOBALS['oOrden_Venta']->adicional);?>' class="form-control text-uppercase">
                        </div>
                    </div>
                </div>
                <div id="divDatos_Economicos" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Moneda: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <select id="cboMoneda" name="cboMoneda" class="form-control" onchange="fncCargarNumeroCuenta(this.value);" >
                            <?php foreach($GLOBALS['dtMoneda'] as  $iMoneda){?>
                                <option value="<?php echo $iMoneda['ID']; ?>" > <?php echo FormatTextViewHtml($iMoneda['descripcion']);?> </option>
                            <?php }?>
                            </select>
                            <script type="text/javascript">
                                $('#cboMoneda').val('<?php echo $GLOBALS['oOrden_Venta']->moneda_ID;?>');
                            </script>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tipo de cambio: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio"  class="decimal form-control text-left" value="<?php echo $GLOBALS['oOrden_Venta']->tipo_cambio; ?>" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Forma de pago: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <select id="selForma_Pago" name="selForma_Pago" class="form-control text-uppercase">
                                <?php foreach($GLOBALS['dtForma_Pago'] as $iForma_Pago){ ?>
                                <option value="<?php echo $iForma_Pago['ID']; ?>"> <?php echo FormatTextView($iForma_Pago['nombre']);?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                                   $('#selForma_Pago').val('<?php echo $GLOBALS['oOrden_Venta']->forma_pago_ID;?>')
                            </script> 
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tiempo de crédito: </label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Nro. Cuentas: </label>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ContenedorCuadro" style="overflow:auto;">
                            <?php echo $GLOBALS['dtNumero_Cuenta'];?>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade inner-all" id="DivProductos">
                    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
                    <button  type="button" id="btnAgregar" name="btnDetalle" class='btn btn-success' onclick="fncRegistrar_Productos();" title="Agregar producto" >
                        <span class="glyphicon glyphicon-plus"></span>
                        Agregar
                    </button>
                    <?php } ?>
                    <div class="divCuerpo" id="productos">
                        
                    </div>
                </div>
                <div class="tab-pane fade inner-all" id="DivObsequios">
                    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
                    <button  type="button" id="btnAgregarObsequio" name="btnAgregarObsequio" class='btn btn-info' onclick="fncRegistrar_Obsequios();" title="Agregar obsequio" >
                        <span class="glyphicon glyphicon-plus"></span>
                        Agregar
                    </button>
                    <?php } ?>
                     <div class="divCuerpo" id="obsequios">
                        
                    </div>
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
    /*$("#selCliente").change(function(){
        var id=this.value;
        if(id==0){
            limpiarPadre();
        }else{
            fncCargaValores(id);
        }
        
        
    });*/
    var fncOrden = function (col) {

        var col_old = $('#txtOrden').val();
        var tipo=$('#chkOrdenASC').val();
        if (col_old == col) {
            if(tipo=="ASC"){
                $('#chkOrdenASC').val('DESC');
            }else {
                 $('#chkOrdenASC').val('ASC');
            }
           
        } else {
            $('#txtOrden').val(col);
            $('#chkOrdenASC').val('ASC');
        }
        fncCargar_Detalle_Cotizacion();

    }
    var fncImportar=function(){
        var orden_venta_ID=$('#txtID').val();
        var tipo_ID=27;//Tipo de venta con factura física
        parent.window_float_open_modal_hijo("IMPORTAR INFORMACIÓN DE UNA COTIZACIÓN","Salida/Orden_Venta_Mantenimiento_Importar_Cotizacion",tipo_ID,"",mostrarInformacion,900,600);
        //window_float_deslizar('form','/Ventas/Orden_Venta_Mantenimiento_Importar_Cotizacion','','');

    }
    
    
    var fncRegistrar_Productos=function(){
        var orden_venta_ID=$('#txtID').val();
        //window_float_deslizar('form','/Ventas/orden_venta_mantenimiento_producto_nuevo',orden_venta_ID,'',fncCargar_Detalle_Orden_Venta);
        parent.window_float_open_modal_hijo("AGREGAR NUEVO PRODUCTO","Salida/orden_venta_mantenimiento_producto_nuevo",orden_venta_ID,"",fncCargar_Detalle_Orden_Venta,700,590);
    }
    var fncEditarProducto=function(id){
        parent.window_float_open_modal_hijo("EDITAR PRODUCTO","Salida/Orden_Venta_Mantenimiento_Producto_Editar",id,"",fncCargar_Detalle_Orden_Venta,700,590);
       
    }
    var fncRegistrar_Obsequios=function(){
        var orden_venta_ID=$('#txtID').val();
        //window_float_deslizar('form','/Ventas/Orden_Venta_Mantenimiento_Obsequio_Nuevo',orden_venta_ID,'',fncCargar_Detalle_Obsequios);
        parent.window_float_open_modal_hijo("AGREGAR NUEVO OBSEQUIO","Salida/Orden_Venta_Mantenimiento_Obsequio_Nuevo",orden_venta_ID,"",fncCargar_Detalle_Obsequios,700,600);
    }
    
    var fncEditarObsequio=function(id){

         parent.window_float_open_modal_hijo("EDITAR OBSEQUIO","Salida/Orden_Venta_Mantenimiento_Obsequio_Editar",id,"",fncCargar_Detalle_Obsequios,700,600);
    }
    var fncFactura=function(){
        var i=0;
        $('#productos .item-tr').each(function(){
          
            i++;
        }); 
        if(i>0){
            var orden_venta_ID=$('#txtID').val();
            parent.window_float_open_modal_hijo("FACTURA DE VENTA","/Salida/Orden_Venta_Mantenimiento_Factura",orden_venta_ID,"",factura_impreso,700,550);
            //window_float_deslizar('form','Ventas/Orden_Venta_Mantenimiento_Factura',orden_venta_ID,'');
        
        }else {
            toastem.error('Debe registrar productos.');
        }
        
       
    }
    var fncGuia=function(){
        var i=0;
        $('#productos .item-tr').each(function(){
           
            i++;
        }); 
        if(i>0){
            var orden_venta_ID=$('#txtID').val();
            parent.window_float_open_modal_hijo("GUIA DE VENTA","/Salida/Orden_Venta_Mantenimiento_Guia",orden_venta_ID,"",null,700,500);
            //window_float_deslizar('form','Ventas/Orden_Venta_Mantenimiento_Guia',orden_venta_ID,'');
        }else {
            toastem.error('Debe registrar productos.');
        }
        
   
    }
    var crear_boton_factura=function(){
        if($('#btnFactura').length){
           
        }else{
            $('#btnDescargar').after(' <button  type="button" id="btnFactura" title="Generar Factura" name="btnFactura" class="btn btn-primary" onclick="fncFactura();" ><span class="glyphicon glyphicon-list-alt"></span> Factura</button>');
        }
        
    }
    var crear_boton_guia=function(){
        if($('#btnGuia').length){

        }else {
            $('#btnFactura').after(' <button  type="button" id="btnGuia" title="Generar Guía" name="btnGuia" class="btn btn-info"  onclick="fncGuia();" ><span class="glyphicon glyphicon-list-alt"></span> Guía  </button>');
        }
        
    }
    var crear_boton_QuitarPrint=function(){

        if($('#btnQuitarPrint').length){
          
        }else {
             $('#btnGuia').after('&nbsp;&nbsp;<button id="btnQuitarPrint" type="button" title="Terminar impresión" class="btn btn-danger" onclick="fncQuitarPrint();"><img width="16" src="/include/img/boton/printer-error-48.png"> Terminar</button>');
        }
        
    }
     //Opción para editar los detalles
  
    var factura_impreso=function(opcion){
        if(opcion==1){
            crear_boton_guia();
        }else{
            bloquear_edicion();
            crear_boton_QuitarPrint();
        }
        
    }
    var fncSeries=function(id){
        //if(fncValidarDetalle()==1){
            //var orden_venta_detalle_ID=$('#detalle_ID').val();
            parent.window_float_open_modal_hijo("EDITAR OBSEQUIO","Salida/Orden_Venta_Mantenimiento_Producto_Serie",id,"",fncCargar_Detalle_Orden_Venta,700,500);
            
   
        //}
        
    }
     var fncQuitarPrint=function(){
        var orden_venta_ID=$('#txtID').val();
        cargarValores('Ventas/ajaxTerminarImpresion',orden_venta_ID,function(resultado){
            toastem.info(resultado.mensaje);
            if(resultado.resultado==1){
                setTimeout('window_float_save_modal();', 1000);   
            }
        });
    } 
   //==============funcion para elminar
  /*  $('#btnEliminar').click(function(){
        var id=$('#detalle_ID').val();
        var src=$(this).attr('class');
         
        var i=src.search('btnProductos');
        
        if(i>-1){
            
            //Encontró clase boton de Producto
            cargarValores('/Salida/ajaxCotizacion_Detalle_Mantenimiento_Eliminar',id,function(resultado){
                
                if(resultado.resultado==1){
                    //$('#detalle_ID').val('');
                    fncCargar_Detalle_Cotizacion();
                    
                    toastem.info(resultado.mensaje);
                    
                }else { 
                    toastem.error(resultado.mensaje);
                }
            });
        }else {
            //Encontró clase boton de adicional
            cargarValores('/Salida/ajaxCotizacion_Detalle_Mantenimiento_Eliminar',id,function(resultado){
                if(resultado.resultado==1){
                    $('#detalle_ID').val('');
                    fncCargar_Detalle_Obsequios();
                    
                    toastem.info(resultado.mensaje);
                }else { 
                    toastem.error(resultado.mensaje);
                }
            });    
        }
    });
     
   */
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
    var fncCargar_Detalle_Orden_Venta=function(funcion){
       
        var orden_venta_ID=$('#txtID').val();
        
        var tiempo=$('#txtTiempo_Avance').val();
        var orden=$('#txtOrden').val();
        var tipo=$('#chkOrdenASC').val();
       if(orden_venta_ID>0){
            cargarValores("Salida/ajaxOrden_Venta_Detalle_Productos",orden_venta_ID,function(resultado){
             //alert(resultado.resultado);
                $('#productos').html(resultado.resultado);
                $('#subtotal').html(resultado.subtotal);
                $('#vigv').html(resultado.vigv);
                $('#total').html(resultado.total);
                $('#divContenedorDetalle').html(resultado.html);
                calcularEstructura(orden_venta_ID);
             
            });
       }
        if(funcion){
            setTimeout(funcion, 300);
        }
    }
    
    var fncCargar_Detalle_Obsequios=function(funcion){
        var orden_venta_ID=$('#txtID').val();
        if(orden_venta_ID>0){
            //$('#divContenedor_Float_Hijo').css('display', 'block');
            cargarValores("Salida/ajaxOrden_Venta_Detalle_Obsequios",orden_venta_ID,function(resultado){
                //alert(resultado.resultado);
                $('#obsequios').html(resultado.resultado);
                //fncSeleccionarDetalle();
            });
        }
        if(funcion){
            setTimeout(funcion, 300);
        }
    }
    var fncCargaValores=function(id){
        try{
            block_ui(function () {
                cargarValores('/Salida/ajaxCotizacion_Detalle_Cliente',id,function(resultado){ 
                    //console.log(resultado.operador_ID);
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
            $('#lbMoneda').html('Soles (S/.)');
           $('#tbnumero_cuenta .cssSoles').css('display','');
           $('#tbnumero_cuenta .cssDolares').css('display','none');

        }else {
            $('#lbMoneda').html('Dólares (US$.)');
            $('#tbnumero_cuenta .cssSoles').css('display','none');
            $('#tbnumero_cuenta .cssDolares').css('display','');
        }

    }
    function limpiarPadre(IDimagen){
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
    var validar=function(){
        //$('#txtSubTotalSoles').removeAttr('disabled');
        var cliente_ID=$('#selCliente').val();
        
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
            
        
            
        var i=0;
        $('#tbnumero_cuenta input:checkbox:checked').each(function(){
            i++;
        });
        if(i==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Selecciones como mínimo un número de cuenta.');
            $('.nav-tabs a[href="#divDatos_Economicos"]').tab('show');
            return false;
        }
        $('#txtTiempo_Avance').removeAttr("disabled");
        $('#txtNumero').removeAttr('disabled');
         block_ui();
        //$('#fondo_espera').css('display','block');
    }
    var mostrarInformacion=function(orden_venta_ID){
        cargarValores('Salida/ajaxMostrarInformacion',orden_venta_ID,function(resultado){
            $('#txtID').val(resultado.salida_ID);
            $('#txtCotizacion_ID').val(resultado.cotizacion_ID);
            $("#selCliente").val(resultado.cliente_ID);
            $("#listaCliente").val(resultado.Ruc+' - '+resultado.Razon_Social);
            //$("#selCliente").trigger("chosen:updated");
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
             $('#txtGarantia').val(resultado.garantia);
             $('#btnDescargar').css('display','');
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
            mensaje.error('OCURRIÓ UN ERROR','No existe cotización');
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
    
   var calcularEstructura=function(orden_venta_ID){
       //alert(orden_venta_ID);
        $('#divContenedorDetalle').css('display','block');
        var tabla= document.getElementById('tablaproducto');
        var nFilas =tabla.rows.length;
        var alto=tabla.offsetHeight;

        //var contenedor=iframe.contentWindow.document.getElementById('contenedor_productos');
        var altocontenedor=500;//524
        var altostd=0;
        var numero_pagina=0;
        var nproductoxhoja="";
        var suma=0;
        var nproducto=0;
        var n=0;
        //var y=0;
        //alert(nFilas);
        for (i = 1; i <= nFilas; i++) { 

            var td=document.getElementById('td'+i);
            var altotd=td.offsetHeight;

            altostd=altostd +altotd;
                // 1000>=500
            if(altostd>=altocontenedor){
                if(i==nFilas){
                    if(n>0){
                        nproductoxhoja=nproductoxhoja+n+'/';
                        numero_pagina=numero_pagina+1;
                        //nproducto=1;
                        //n=0;
                    }
                    nproducto=1;
                    nproductoxhoja=nproductoxhoja+nproducto;
                    numero_pagina =numero_pagina + 1;

                }else {
                    if(n>0){

                        nproductoxhoja=nproductoxhoja+n+'/';
                        numero_pagina=numero_pagina+1;
                        nproducto=1;
                        n=1;
                        altostd=altotd;
                    }else {
                        nproducto=1;
                        nproductoxhoja=nproductoxhoja+nproducto+'/';
                        //numero_pagina =numero_pagina + 1;
                        altostd=0;
                    }
                    //numero_pagina =numero_pagina + 1;
                }


            }else{
                n=n+1;

                if(i==nFilas){

                nproducto=nproducto+1;
                nproductoxhoja=nproductoxhoja+n;
                numero_pagina =numero_pagina + 1;
                }
            }
            //nproducto=nproducto+1;

        }
        //alert(numero_pagina);
        cargarValores2('/Salida/ajaxOrden_Venta_Grabar',orden_venta_ID,numero_pagina,nproductoxhoja,function(resultado){
            if(resultado.resultado==-1){
                toastem.error(resultado.mensaje);
            }
        });
        $('#divContenedorDetalle').css('display','none');
   }
   var bloquear_edicion=function(){
       $('#selCliente').prop('disabled', true);
       $('#selCliente').trigger('chosen:updated');
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
       $('#btnAgregar').prop('disabled',true);
       $('#btnAgregar').css('display', 'none');
       $('#tbnumero_cuenta input').each(function(){
           $(this).prop('disabled',true);
       });
       $('#btnEliminar').prop('disabled',true);
      // $('#').prop('disabled',true);
       
       
       
       
   }
</script>       
<?php }?>
            
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
         $.unblockUI();
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

	     
<?php }?>        