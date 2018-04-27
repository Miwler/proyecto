<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Nuevo producto<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jForm.js"></script>
<?php } ?>

<?php function fncTitleHead(){?>Nuevo detalle de compra<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1"  method="post"  action="Compra/ordencompra_mantenimiento_nuevo_producto/<?php echo $GLOBALS['orden_compra_ID']; ?>" onsubmit="return validar();" class="form-horizontal">
    <div class="form-body">
        <div class="form-group">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Línea:</label>
            <input type="hidden" id="txtOrden_CompraID" name="txtOrden_CompraID" value="<?php echo $GLOBALS['orden_compra_ID'];?>">
            <input type="hidden" id="txtID" name="txtID" value="<?php echo $GLOBALS['oOrden_Compra_detalle']->ID;?>">
            <div id="tdLinea" class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <select id="selLinea" name="selLinea" class="chosen-select form-control filtroLista" onchange='fncLinea();'>
                    <option value="0">TODOS</option>
                <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
                    <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                <?php } ?>
                </select>
                <script type="text/javascript">
                    $('#selLinea').val(<?php echo $GLOBALS['linea_ID'];?>);
                </script>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Categoría:</label>
            <div id="tdCategoria" class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <select id="selCategoria" name="selCategoria"  class="chosen-select form-control filtroLista" onchange='fncCategoria();'>
                    <option value="0" selected>TODOS</option>
                <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
                        <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                <?php } ?>

                </select> 
                <input id="txtp" style="display:none;">
                <script type="text/javascript">
                    $('#selCategoria').val(<?php echo $GLOBALS['categoria_ID'];?>);
                </script>
            </div>
        </div> 
        <div class="form-group" style="margin:10px 0">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Producto:<span class="asterisk">*</span></label>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 lista_producto" id="tdProducto" >
                <select id='selProducto' name='selProducto' onchange='fncProducto();' class="chosen-select">
                   <option value='0'>--SELECCIONAR--</option>
                   <?php foreach($GLOBALS['dtProducto'] as $item){?>
                   <option value="<?php echo $item['ID']?>"><?php echo sprintf("%'.07d",$item['codigo'])." - ".FormatTextView($item['producto']);?></option>
                   <?php } ?>
                </select>
            </div>

        </div>
        <div class="form-group">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Descripción:</label>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" style="height: 50px;" ><?php echo FormatTextView($GLOBALS['oOrden_Compra_detalle']->descripcion); ?></textarea>
            </div>

        </div>
        <div class="form-group">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Cantidad:<span class="asterisk">*</span></label>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="txtCantidad" name="txtCantidad"  class="int form-control"  autocomplete="off" value="<?php echo $GLOBALS['oOrden_Compra_detalle']->cantidad;?>" onkeyup="ProductoValores($('#txtCantidad').val(),$('#txtPrecioUnitario').val(),'#txtSubTotal');">

            </div>
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Precio unitario <?php echo FormatTextView($GLOBALS['oOrden_Compra_detalle']->oMoneda->simbolo);?>:<span class="asterisk">*</span></label>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="txtPrecioUnitario" name="txtPrecioUnitario"  autocomplete="off" class="decimal form-control" value="<?php echo $GLOBALS['oOrden_Compra_detalle']->precio?>" onkeyup="ProductoValores($('#txtCantidad').val(),$('#txtPrecioUnitario').val(),'#txtSubTotal');">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">Stock:</label>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="txtStock" name="txtStock" class="form-control" value="<?php echo $GLOBALS['oOrden_Compra_detalle']->stock; ?>" disabled>
            </div>
            <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Sub total <?php echo FormatTextView($GLOBALS['oOrden_Compra_detalle']->oMoneda->simbolo);?>:</label>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" id="txtSubTotal" name="txtSubTotal" class="form-control" value="<?php echo $GLOBALS['oOrden_Compra_detalle']->subtotal?>" disabled>
            </div>
        </div>

        <div class="form-group">
           <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label">I.G.V.<?php echo $GLOBALS['oOrden_Compra_detalle']->vigv*100;?>% <?php echo FormatTextView($GLOBALS['oOrden_Compra_detalle']->oMoneda->simbolo);?>:</label>
           <input type="hidden" id="txtvigv" value="<?php echo $GLOBALS['oOrden_Compra_detalle']->vigv;?>">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <input type="text" id="txtIgv" name="txtIgv" class="form-control" value="<?php echo $GLOBALS['oOrden_Compra_detalle']->igv?>" disabled>
            </div>
            <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">Total <?php echo FormatTextView($GLOBALS['oOrden_Compra_detalle']->oMoneda->simbolo);?>:</label>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <input type="text" id="txtTotal" name="txtTotal" class="form-control" value="<?php echo $GLOBALS['oOrden_Compra_detalle']->total?>" disabled> 

            </div>
        </div>
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button  id="btnEnviar" name="btnEnviar" class='btn btn-success' title="Guardar" >
                <img alt="" width="16" src="/include/img/boton/save_48x48.png">
                Guardar
            </button>

            <button  id="btnCancelar" name="btnCancelar" type="button" class='btn btn-danger' title="Cancelar" onclick="parent.float_close_modal_hijo();" >
                <span class="glyphicon glyphicon-ban-circle"></span>
                Cancelar
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
    
</form>
 <script type="text/javascript">

    var validar=function(){
        var producto_ID=$('#selProducto').val();
        var descripcion= $.trim($('#txtDescripcion').val());
        var cantidad= $.trim($('#txtCantidad').val());
        var precio_unitario=$.trim($('#txtPrecioUnitario').val());
        
        
        if(producto_ID=='0'){
            mensaje.advertencia('VALIDACIÓN DE DATOS','Seleccione un producto.','txtdivProductos');
            
            return false;
        }
        //Verifico si el comprobante requiere serie y número
        if(isNaN(cantidad)||cantidad==""){
            mensaje.advertencia('VALIDACIÓN DE DATOS','Registre una cantidad.','txtCantidad');
            
            return false;   
        }
        
        
        if(isNaN(precio_unitario)||precio_unitario==""){
            mensaje.advertencia('VALIDACIÓN DE DATOS','Registre un precio unitario.','txtPrecioUnitario');
            
            return false;   
        }
        
        $('#txtSubTotal').removeAttr('disabled');
        $('#txtIgv').removeAttr('disabled');
        $('#txtTotal').removeAttr('disabled');
        $('#fondo_espera').css('display','');
        			
    }
    $('#txtSubTotal').attr('disabled');
    $('#txtIgv').attr('disabled');
    $('#txtTotal').attr('disabled');
    
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
                }else{
                    mensaje.error(resultado.mensaje);
                }
                
                //fncListaProductosVendidos(producto_ID);
            });
        }
    }

    
    function ProductoValores(caja1,caja2,resultado)
        {   
            if($.trim(caja1)==""){
                var valor1=0;
            } else {valor1=caja1;}
            if($.trim(caja2)==""){
                 var valor2=0;
            }else {valor2=caja2;}
            var producto=redondear(valor1*valor2,2);
            if(isNaN(producto)==false){
                $(resultado).val(producto);
            }else{
                $(resultado).val('--');
            }
            calcularIGV();    

        }
    function calcularIGV(){

        var subtotal=redondear($('#txtSubTotal').val(),2);
        var vigv=$('#txtvigv').val();
        if(subtotal!=0){

            var igv=redondear(subtotal*vigv,2);
            $('#txtIgv').val(igv);
            var Total=subtotal+igv;
            //var Total=redondear(subtotal*(vigv+1),2);
            $('#txtTotal').val(Total);
        }


    }

    </script>
 <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
            
            <script type="text/javascript">
               // alert('-1');
               $(document).ready(function () {
                    toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
                });
             </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

    <script type="text/javascript">
     
    $(document).ready(function () {
        toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
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
