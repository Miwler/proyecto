<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>REGISTRAR NUEVO PRODUCTO<?php } ?>

<?php function fncHead(){?>

    <script type="text/javascript" src="include/js/jForm.js"></script>
    
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js"></script>
    
    <style>
        #table_historial_compra tbody td,#table_historial_venta tbody td,#table_separaciones tbody td{
            font-size:11px;
        }
    </style>
<?php } ?>

<?php function fncTitleHead(){?>REGISTRAR PRODUCTO DE OBSEQUIOS<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1"  method="post"  action="Salida/Orden_Venta_Mantenimiento_Obsequio_Editar/<?php echo $GLOBALS['oOrden_Venta_Detalle']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading">
            <ul class="nav nav-tabs nav-pills">
                <li class=" active"><a data-toggle="tab" href="#Productos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Producto</span></a></li>
                <li class="nav-item"><a href="#separaciones" data-toggle="tab"><i class="fa fa-clone"></i><span>Separaciones</span> </a></li>
                <li class="nav-item"><a href="#historial" data-toggle="tab"><i class="fa fa-calendar-o"></i> <span>Historial</span></a></li>
            </ul>
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height: 300px;overflow: auto;">
            <div class="tab-content">
                <div id="Productos" class="tab-pane fade in active inner-all">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label>Línea</label>
                                    <input id='txtID' name='txtcotizacion_detalle_ID' value='<?php echo $GLOBALS['oOrden_Venta_Detalle']->ID;?>' style='display:none;' >
                                </div>
                                <div id="tdLinea" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                    <select id="selLinea" name="selLinea" onchange="fncLinea();" class="form-control text-uppercase filtroLista chosen-select mb-15">
                                        <option value="0">TODOS</option>
                                        <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
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
                                    <label>Categoría</label>
                                </div>
                                <div id="tdCategoria" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                    <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" class="form-control text-uppercase filtroLista chosen-select mb-15">
                                        <option value="0" selected>TODOS</option>
                                        <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
                                                <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                                        <?php } ?>

                                    </select> 

                                    <script type="text/javascript">
                                        $('#selCategoria').val(<?php echo $GLOBALS['oOrden_Venta_Detalle']->categoria_ID;?>);
                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label>Producto</label>
                                </div>
                                <div id="tdProducto" class="col-lg-9 col-md-9 col-sm-9 col-xs-9 lista_producto">
                                    <input type="hidden" id="selProducto" name="selProducto" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->producto_ID;?>">
                                            <input type="text" id="listaProducto" class="form-control" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->oProducto->codigo." - ".$GLOBALS['oOrden_Venta_Detalle']->oProducto->nombre?>">
                                            <script type="text/javascript">
                                            $(document).ready(function(){
                                                listar_productos();
                                            });
                                            </script>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label>Cantidad</label>
                                </div>
                                <div  class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <input type="text" id="txtCantidad" name="txtCantidad" class="form-control form-requerido int" autocomplete="off" value="<?php echo $GLOBALS['oOrden_Venta_Detalle']->cantidad;?>" >
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label>Stock</label>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <input type="text" id="txtStock" name="txtStock" class="form-control"  value="<?php echo $GLOBALS['oInventario']->stock; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <label>Precio de compra</label>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <input  type="text" id="txtPrecioCompraDolares" name="txtPrecioCompraDolares" class="form-control moneda" disabled>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <input type="text" id="txtPrecioCompraSoles" name="txtPrecioCompraSoles" class="form-control moneda" disabled>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label>Descripción</label>
                        </div>
                        <div id="tdComentario" class="col-lg-12 col-md-12 col-sm-12">
                            <textarea id="txtDescripcion" name="txtDescripcion" class="form-control text-uppercase comentario" rows="7" cols="40" maxlength="2000" style="height:80px;"><?php echo FormatTextView($GLOBALS['oOrden_Venta_Detalle']->descripcion);?></textarea>
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
    
</form>
<script type="text/javascript">
 $(document).ready(function(){
      fncCargarPrecioCompra(<?php echo $GLOBALS['oOrden_Venta_Detalle']->producto_ID;?>);
       
    });
    var Resultado_verificar=0;
    var validar=function(){
        var producto_ID=$('#selProducto').val();
        var cantidad= $.trim($('#txtCantidad').val());
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
        block_ui();
        //$('#fondo_espera').css('display','block');
        
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
        lista_producto('/Funcion/ajaxListarProductos','listaProducto','selProducto',$("#selLinea").val(),$("#selCategoria").val(),fncProducto,fncLimpiar);
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
                
                //fncListaProductosVendidos(producto_ID);
            });
        }else{
            fncLimpiar();
        }
    }
   
    

    var fncCargarPrecioCompra=function(producto_ID){
          cargarValores('/Ingreso/ajaxPrecio_ingreso',producto_ID,function(resultado){
            $('#txtPrecioCompraDolares').val(resultado.precio_compra_dolares); 
            $('#txtPrecioCompraSoles').val(resultado.precio_compra_soles);
            
            if(resultado.resultado==-1){
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
              
            }
            
            VerSeparaciones(resultado.producto_ID);
        });
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
       
        $('#txtDescripcion').val('');
        $('#txtStock').val('');
        $("#listaProducto").val("");
        $("#selProducto").val("");
         $("#table_historial_compra tbody").html('');
        $("#table_historial_venta tbody").html('');
        $("#table_separaciones tbody").html('');
    }
   
    </script>
 
 <?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
           // alert('-1');
        $(document).ready(function () {
            toastem.error('<?php echo $GLOBALS['mensaje'];?>');
        });
       
       // setTimeout('window_float_save();', 1000);
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

<script type="text/javascript">
 //alert('hola');
 $(document).ready(function () {
     $.unblockUI();
    toastem.success('<?php echo $GLOBALS['mensaje'];?>');
    setTimeout('parent.windos_float_save_modal_hijo();', 1000);
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
