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

<?php function fncTitleHead(){?>REGISTRAR PRODUCTO DE OBSEQUIOS<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1"  method="post"  action="Salida/Cotizacion_Mantenimiento_Obsequio_Nuevo/<?php echo $GLOBALS['oCotizacion']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#Productos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Producto</span></a></li>
                 <li class="nav-item"><a href="#separaciones" data-toggle="tab"><i class="fa fa-clone"></i> <span>Separaciones</span></a></li>
                <li class="nav-item"><a href="#historial" data-toggle="tab"><i class="fa fa-calendar-o"></i> <span>Historial</span></a></li>
            </ul>
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height: 460px;overflow: auto;">
            
            <div class="tab-content">
                <div id="Productos" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Línea</label>
                            <input id='txtID' name='txtcotizacion_detalle_ID' value='<?php echo $GLOBALS['oCotizacion_Detalle']->ID;?>' style='display:none;' >
                        </div>
                        <div id="tdLinea" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <select id="selLinea" name="selLinea" onchange="fncLinea();" class="form-control text-uppercase filtroLista">
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
                            <label>Categoría</label>
                        </div>
                        <div id="tdCategoria" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" class="form-control text-uppercase filtroLista">
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
                            <label>Producto</label>
                        </div>
                        <div id="tdProducto" class="col-lg-9 col-md-9 col-sm-9 col-xs-9 lista_producto">
                            <select id='selProducto' name='selProducto' onchange='fncProducto();' class="chosen-select">
                                <option value='0'>--SELECCIONAR--</option>
                                <?php foreach($GLOBALS['dtProducto'] as $item){?>
                                <option value="<?php echo $item['ID']?>"><?php echo sprintf("%'.07d",$item['codigo'])." - ".FormatTextView($item['producto']);?></option>
                                <?php } ?>
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
                            <label>Descripción</label>
                        </div>
                        <div id="tdComentario" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <textarea id="txtDescripcion" name="txtDescripcion" class="form-control text-uppercase comentario" rows="7" cols="40" maxlength="2000" style="height:100px;"><?php echo FormatTextView($GLOBALS['oCotizacion_Detalle']->descripcion);?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Cantidad<span class="asterisk">*</span></label>
                        </div>
                        <div  class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input type="text" id="txtCantidad" name="txtCantidad" class="form-control int" autocomplete="off" value="<?php echo $GLOBALS['oCotizacion_Detalle']->cantidad;?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <div class="ckbox ckbox-theme">
                                <input id="ckSeparacion"  name="ckSeparacion"  type="checkbox" value="1">
                                <label for="ckSeparacion">Separar producto</label>
                            </div>
                        </div>
                        
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>Tiempo</label>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input type="number" id="txtTiempo_Separacion" name="txtTiempo_Separacion" disabled value="1" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Precio de compra</label>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input  type="text" id="txtPrecioCompraDolares" name="txtPrecioCompraDolares" class="form-control moneda" disabled>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <input type="text" id="txtPrecioCompraSoles" name="txtPrecioCompraSoles" class="form-control moneda" disabled>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>Stock</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtStock" name="txtStock" class="form-control"  value="<?php echo $GLOBALS['oInventario']->stock; ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade inner-all divCuerpo" id="separaciones">
                </div>
                <div class="tab-pane fade inner-all divCuerpo" id="historial">
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Guardar">
                        <img width="14" alt="" src="/include/img/boton/save_48x48.png">
                       Guardar
                    </button>
                    <button id="btnRegresar1" type="button" class="btn btn-danger" title="Cancelar" onclick="parent.float_close_modal_hijo();">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Regresar
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
  
    var Resultado_verificar=0;
    var validar=function(){
        var cantidad= $.trim($('#txtCantidad').val());
        var producto=$("selProducto").val();
        if(producto==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione un producto.','selProducto');
           
            return false;
        }
        //Verifico si el comprobante requiere serie y número
        if(isNaN(cantidad)||cantidad==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Registre una cantidad.','txtCantidad');
            $('.nav-tabs a[href="#divCostos"]').tab('show');
            
            return false;   
        }
        $('#fondo_espera').css('display','block');
        
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
          cargarValores('/Ingreso/ajaxPrecio_Compra',producto_ID,function(resultado){
            $('#txtPrecioCompraDolares').val(resultado.precio_compra_dolares); 
            $('#txtPrecioCompraSoles').val(resultado.precio_compra_soles);
            
            if(resultado.resultado==-1){
                toastem.error(resultado.mensaje);
               $('#separaciones').html(resultado.mensaje); 
            }
            $('#separaciones').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
            VerSeparaciones(resultado.producto_ID);
        });
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
setTimeout('parent.windos_float_save_modal_hijo();', 1000);

 
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
