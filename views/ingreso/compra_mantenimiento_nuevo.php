<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Nueva compra<?php } ?>

<?php

function fncHead() { ?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>
    
<?php } ?>

<?php

function fncTitleHead() { ?>
    
    Nueva compra
   <?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1||$GLOBALS['resultado'] == 1) { ?>

<form id="form" method="POST" action="/Ingreso/Compra_Mantenimiento_Nuevo" onsubmit="return validar();" class="form-horizontal" >
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i><span> Datos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divContenedorProdutos" class="nav-link"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i><span> Productos</span></a></li>
            </ul>
            <div class="pull-right">
                <button  id="btnEnviar" name="btnEnviar" class='btn btn-success' title="Guardar" >
                    <img alt="" width="16" src="/include/img/boton/save_48x48.png">
                    Guardar
                </button>
                <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
                <button  type="button" id="btnAgregar" name="btnEnviar" title="Agregar productos" class='btn btn-info' onclick="fncRegistrar_Productos();" >
                    <img  alt="" width="16" src="/include/img/boton/addProducto48x48.png">
                    Agregar
                </button>
                <?php } ?>
                <button  id="btnCancelar" name="btnCancelar" type="button" class='btn btn-danger' title="Salir" onclick="salir();" >
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Salir
                </button>
            </div>
        </div>
        <div class="panel-body no-padding rounded-bottom">
            
            <div class="tab-content" >
                <div id="divDatos" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Código:</label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input id="txtID" name="txtID" value="<?php echo $GLOBALS['oCompra']->ID; ?>" style="display: none;"/>
                            <input id="txtNumero" name="txtNumero" disabled class="form-control int" type="text"  value="<?php echo sprintf("%'.07d",$GLOBALS['oCompra']->codigo); ?>" />
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Nro de orden:</label>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="row">
                                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-6">
                                    <input id="txtOrden_Compra_ID" name="txtOrden_Compra_ID" value="<?php echo $GLOBALS['oCompra']->orden_ingreso_ID;?>" style="display:none;"/>
                                    <input type="text" id="txtNumeroOrden" name="txtNumeroOrden" disabled class="form-control" value="<?php echo $GLOBALS['oCompra']->numero_orden_ingreso; ?>">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                    <button type="button" id="btnBuscarOC" class="btn btn-success" title="Buscar Orden" onclick="fncBuscarOrden();"><span class="glyphicon glyphicon-search"></span>Importar OC</button>

                                </div>
                            </div>
                              
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Estado:</label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input type="text" id="txtEstado" name="txtEstado" disabled class="form-control" value="<?php echo FormatTextView($GLOBALS['oCompra']->oEstado->nombre);?>">
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Nro de guía:</label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input id="txtNumero_Guia" name="txtNumero_Guia" autocomplete="off" type="text" class="form-control" value="<?php echo $GLOBALS['oCompra']->numero_guia; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Tipo comprobante:</label>
                        
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <select id="cboComprobante_Tipo" name="cboComprobante_Tipo" disabled class="form-control">
                                <?php echo $GLOBALS['oCompra']->dtTipo_Comprobante;?>
                                     
                            </select>
                            <script type="text/javascript">
                                $('#cboComprobante_Tipo').val(<?php echo $GLOBALS['oCompra']->tipo_comprobante_ID;?>);
                            </script>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Número:<span class="asterisk">*</span></label>
                       
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <input id="txtSerie" name="txtSerie" type="text" class="form-control" autocomplete=off maxlength="4"  onchange="fncSerie();" placeholder="Serie" value="<?php echo $GLOBALS['oCompra']->serie; ?>" />
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7">
                                    <input id="txtNumero_Factura" name="txtNumero_Factura" type="text" class="text-int form-control" autocomplete=off maxlength="9"   onchange="fncNumero();" placeholder="Número" value="<?php echo $GLOBALS['oCompra']->numero; ?>" />
                                </div>
                            </div>
               
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Fecha emisión:<span class="asterisk">*</span></label>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <input id="txtFecha_Emision" name="txtFecha_Emision" type="text" class="form-control date-range-picker-single" value="<?php if(isset($GLOBALS['oCompra']->fecha_emision)){ echo $GLOBALS['oCompra']->fecha_emision;} else{ echo date("d/m/Y");} ?>" />
                            
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Fecha vencimiento:<span class="asterisk">*</span></label>
                        
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <input id="txtFecha_Vencimiento" name="txtFecha_Vencimiento" type="text" class="form-control date-range-picker-single"  value="<?php echo $GLOBALS['oCompra']->fecha_vencimiento; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Proveedor:<span class="asterisk">*</span></label>
                        
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <select id="selProveedor" name="selProveedor" class="chosen-select">
                                <option value="0">--Seleccionar--</option>
                                 <?php foreach($GLOBALS['oCompra']->dtProveedor as $proveedor){?>
                                <option value="<?php echo $proveedor['ID']?>"><?php echo FormatTextView($proveedor['razon_social']);?></option>
                                 <?php }?>
                            </select>
                            
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">I.G.V.%:</label>
                        
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <input type="text" id="txtVigv" name="txtVigv" disabled class="form-control" value="<?php echo ($GLOBALS['oCompra']->vigv*100); ?>"> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Moneda:</label>
                       
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <select id="cboMoneda" name="cboMoneda" class="form-control" >
                                <?php foreach($GLOBALS['oCompra']->dtMoneda as  $iMoneda){?>
                                <option value="<?php echo $iMoneda['ID']; ?>" > <?php echo $iMoneda['descripcion'];?> </option>
                                <?php }?>
                            </select>
                            <script type="text/javascript">
                                $('#cboMoneda').val('<?php echo $GLOBALS['oCompra']->moneda_ID;?>');
                            </script>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-2  control-label">Tipo de cambio:</label>
                       
                        <div class="col-lg-4 col-md-4 col-sm-4 ">
                            <input id="txtTipo_Cambio" name="txtTipo_Cambio" type="text" class="form-control decimal"  value="<?php echo $GLOBALS['oCompra']->tipo_cambio;?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-md-2 col-sm-2 control-label">Comentario:</label>
                       
                        <div id="tdComentario" class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                            <textarea id="txtComentario" name="txtComentario" class="form-control comentario" rows="4"  cols="5" maxlength="300" style="height: 80px;overflow:auto;resize:none;"><?php echo $GLOBALS['oCompra']->descripcion;?></textarea>
                        </div>
                    </div>
                </div>
                <div id="divContenedorProdutos" class="tab-pane fade inner-all" >
                    <div class="form-group">
                        <label class="control-label col-sm-2">Sub Total:</label>
   
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" id="txtSubTotal" class="form-control moneda" disabled >
                        </div>
                       <label class="control-label col-sm-2">IGV (<?php echo $GLOBALS['oCompra']->vigv*100; ?>%):</label>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" id="txtIGV" disabled class="form-control moneda">
                        </div>
                        <label class="control-label col-sm-2">Total:</label>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <input type="text" id="txtTotal" disabled class="form-control moneda">
                        </div>
                       
                         
                    </div>
                    <div class="form-group">
                        <div id="divContenedor_Float_Hijo" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contenedor_detalle" style="height: 350px;overflow:auto;margin: 0 auto; ">
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <input id="txtOrden" name="txtOrden" type="text"  style="display:none;">
    <input id="chkOrdenASC" name="chkOrdenASC"   value="ASC" style="display:none;">
</form>
    
    <script type="text/javascript">
    var validar=function(){
        $('#cboComprobante_Tipo').prop('disabled',false)
        var proveedor_ID=$("#selProveedor").val();
        var serie=$.trim($('#txtSerie').val());
        var numero=$.trim($('#txtNumero_Factura').val());
        var fecha_emision = $.trim($('#txtFecha_Emision').val());
        var fecha_vencimiento=$.trim($('#txtFecha_Vencimiento').val());
        var tipo_cambio=$("#txtTipo_Cambio").val();
        if(proveedor_ID==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS","Debe seleccionar un proveedor","selProveedor");
            return false;
        }
        if(serie==''){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese la serie de la factura.',"txtSerie");
            
            return false;
        }
        if(numero=='' || numero ==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese el nro de factura.',"txtNumero_Factura");
            
            return false;
        }
        if (!validarFecha(fecha_emision)) {
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese una fecha de emisión.',"txtFecha");
            return false;
        }
        if (!validarFecha(fecha_vencimiento)) {
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese una fecha de vencimiento.',"txtFecha_Vencimiento");

            return false;
        }

        if(isNaN(tipo_cambio)){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un tipo de cambio correcto.',"txtTipo_Cambio");
            
            return false;
        }
        if(tipo_cambio<=0){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre un tipo de cambio mayor que cero.',"txtTipo_Cambio");
           
            return false;
        }
       if(verificar_fechas(fecha_emision,fecha_vencimiento)==false){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Debe seleccionar una fecha de vencimiento mayor o igual al que la fecha de emisión.',"txtFecha_Vencimiento");
            
            return false;
       };
        
        $("#selProveedor").prop("disabled", false);
        $('#txtVigv').removeAttr('disabled');   
        $('#fondo_espera').css('display','block')
    }

    <?php if($GLOBALS['oCompra']->ID>0){?>
    $("#selProveedor").val(<?php echo $GLOBALS['oCompra']->proveedor_ID?>);
    $("#selCategoria").trigger("chosen:updated");
    <?php } else {?>
    
    <?php } ?>
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
        fncCargar_Detalle_Compra();

    }

    var fncRegistrar_Productos=function(){
        var compra_ID=$('#txtID').val();
        parent.window_float_open_modal_hijo("AGREGAR NUEVO PRODUCTO",'Ingreso/Compra_Mantenimiento_Nuevo_Producto',compra_ID,'',fncCargar_Detalle_Compra,null,440);

    }
    var fncEditar=function(id){
        parent.window_float_open_modal_hijo("EDITAR PRODUCTO","Ingreso/Compra_Mantenimiento_Editar_Producto",id,"",fncCargar_Detalle_Compra,null,440);
        
    }
    var fncValidarExistencia=function(){
        var cantidad=0;
        $('#divContenedor_Float_Hijo .item-tr').each(function(){
            cantidad++;
        });
       if(cantidad==0){
            mensaje.error("Ocurrió un error",'No registró ningún detalle.');
       }else {
           return 1;
            
       }

    }
    var fncSeries=function(compra_detalle_ID){
        if(fncValidarExistencia()==1){
            //var compra_detalle_ID=$('#detalle_ID').val();
           parent.window_float_open_modal_hijo("REGISTRAR DE SERIES DE PRODUCTOS","Ingreso/Compra_Mantenimiento_Producto_Serie",compra_detalle_ID,"",fncCargar_Detalle_Compra,800,550);

        }

    }

    var fncEliminar=function(id){
        //var id=$('#detalle_ID').val();
        $("#fondo_espera").css('display','block');
        cargarValores('/Ingreso/ajaxCompra_Mantenimiento_Producto_Eliminar',id,function(resultado){
            
            if(resultado.resultado==1){
                
                fncCargar_Detalle_Compra();
                $('#script').html(resultado.funcion);
                toastem.info(resultado.mensaje);

            }else {
                toastem.error(resultado.mensaje);
            }
            $("#fondo_espera").css('display','none');

        });
    }

    var fncCargar_Detalle_Compra=function(){
        var compra_ID=$('#txtID').val();
        var orden=$('#txtOrden').val();
        var tipo=$('#chkOrdenASC').val();
        cargarValores2("/Ingreso/ajaxCompra_Mantenimiento_Detalle",compra_ID,orden,tipo,function(resultado){
            $('#divContenedor_Float_Hijo').html(resultado.resultado);
            if(resultado.mensaje==1){
                $('#txtSubTotal').val(resultado.subtotal);
                $('#txtIGV').val(resultado.igv);
                $('#txtTotal').val(resultado.total);
                
            }

        });
    }
    var salir=function(){
        window_float_save_modal();
    }
    
    function fncSerie(){
        var serie=$('#txtSerie').val();
        var cadena=parseInt(serie,10);
        if(isNaN(cadena)==false){
            var nSerie=('000'+serie);				
            $('#txtSerie').val(nSerie.substring(nSerie.length-3,nSerie.length));
        }
        
    }

    function fncNumero(){
        var numero=$('#txtNumero_Factura').val();
        var nNumero=('000000000'+numero);

        $('#txtNumero_Factura').val(nNumero.substring(nNumero.length-9,nNumero.length));
    }

   
    var fncEstado=function(){
        var estado_ID=$('#cboEstado').val();

        $('#txtFecha_Vencimiento').removeAttr('disabled');
        if(estado_ID==11){
                $('#txtFecha_Vencimiento').attr('disabled','disabled');
        }
    }
    var fncComprobante_Tipo=function(){
        var tipo_comprobante_ID=$('#cboComprobante_Tipo').val();	

        $('#txtSerie').attr('disabled','disabled');
        $('#txtNumero').attr('disabled','disabled');

        //Verifico si el comprobante requiere serie y número
        if(tipo_comprobante_ID==1){
                $('#txtSerie').removeAttr('disabled');
                $('#txtNumero').removeAttr('disabled');
        }else{
            $('#txtSerie').attr('enabled');
            $('#txtNumero').attr('enabled');
        }
    }
    var fncCargarValores=function(compra_ID){
        //alert(compra_ID);
        cargarValores('Ingreso/ajaxCargarCompra',compra_ID,function(resultado){
            if(resultado.resultado==1){
                $('#txtID').val(compra_ID);
                $('#txtNumero').val(resultado.numero);
                $('#txtNumeroOrden').prop('disabled', false);
                $('#txtNumeroOrden').val(resultado.numero_orden);
                $("#selProveedor").val(resultado.proveedor_ID);
                $("#selProveedor").prop("disabled",true);
                 $("#selProveedor").trigger("chosen:updated");
                //$('#divProveedor').html(resultado.proveedor);
                //$('#divProveedor').append('<input name="txtProveedor_ID" id="txtProveedor_ID" style="display:none;" value="'+ resultado.proveedor_ID + '"/>');
                //var cboProveedor = cargarCbo('divProveedor', 'txtProveedor_ID', '/Compra/ajaxCbo_Proveedor',500,resultado.proveedor_ID,resultado.proveedor, true);
                $('#cboEstado').val(resultado.estado_ID);
                
                $('#txtVigv').prop('disabled',false);
                $('#txtVigv').val(resultado.vigv+'%');
                $('#cboMoneda').val(resultado.moneda_ID);
                $('#txtTipo_Cambio').val(resultado.tipo_cambio);
                $('#btnBuscarOC').css('display','none');
              
                fncCargar_Detalle_Compra();
            }else {
                toastem.error(resultado.mensaje);
            }
            $('#txtNumeroOrden').prop('disabled', true);
            $('#txtVigv').prop('disabled',true);
        });
        
    }
    var fncBuscarOrden=function(){
    parent.window_float_open_modal_hijo("ORDEN DE COMPRAS GENERADAS","Ingreso/compra_mantenimiento_buscar_orden",'','',fncCargarValores,640,450);
        //window_float_deslizar('form','Compra/compra_mantenimiento_buscar_orden','','');
    }
          
</script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
   
    <script type="text/javascript">
        $('#btnBuscarOC').css('display','none');
        $(document).ready(function () {
            toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
            $('.nav-tabs a[href="#divContenedorProdutos"]').tab('show');
         });

        //ampliarVentanaVertical(700,'form');
        fncCargar_Detalle_Compra();

    </script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
    <div id="error"></div>
    <script type="text/javascript">
        $('#error').html('<?php echo $GLOBALS['mensaje']; ?>');
        $(document).ready(function () {
            
            toastem.error('<?php echo $GLOBALS['mensaje']; ?>');
         });

     
    </script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -2) { ?>
<script type="text/javascript">
    $(document).ready(function () {
        toastem.error('<?php  echo $GLOBALS['mensaje'];?>');
        setTimeout('window_float_save();', 1000);
       
    });

</script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 0) { ?>
    <div class="float-mensaje">
        <?php echo $GLOBALS['mensaje']; ?>
    </div>
    <div class="group-btn">
        <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
    </div>
<?php } ?>
<?php } ?>
