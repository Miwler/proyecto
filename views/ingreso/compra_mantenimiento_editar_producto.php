<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Detalle compra<?php } ?>

<?php function fncHead(){?>
	
	<script type="text/javascript" src="include/js/jGrid-float.js"></script>	
	<script type="text/javascript" src="include/js/jForm.js"></script>
	<link rel="stylesheet" type="text/css" href="include/css/grid-float.css" />
	
        <script>
            $(document).ready(function(){
                <?php if($GLOBALS['oCompra']->estado_ID==11){?>
                       desactivar_edicion(); 
                <?php } ?>
                 
               
            });
            
        </script>
	
<?php } ?>

<?php function fncTitleHead(){?>Detalle de compras<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1"  method="post" action="Ingreso/compra_mantenimiento_editar_producto/<?php echo $GLOBALS['oCompra_Detalle']->ID;?>" onsubmit="return validar();" class="form-horizontal">
   <div class="panel panel-tab rounded shadow">
       <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Datos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#tbdocumentos" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i> <span>Ventas pendientes</span></a></li>
            </ul>
           <div class="pull-right">
               <button  id="btnEnviar" name="btnEnviar" class='btn btn-success' title="Guardar" >
                    <img alt="" width="16" src="/include/img/boton/save_48x48.png">
                    Guardar
                </button>

                <button  id="btnCancelar" name="btnCancelar" type="button" class='btn btn-danger' title="Cancelar" onclick="parent.float_close_modal_hijo();" >
                    <span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar
                </button>
           </div>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div id="divDatos" class="tab-pane fade in active inner-all">
                    <div class="row">
                        <div class="col-sm-7">
                             <div class="form-group">
                                <label class="col-lg-4 col-md-4 col-sm-4 control-label">Línea:</label>

                                <input type="hidden" id="txtID" name="txtID" value="<?php echo $GLOBALS['oCompra_Detalle']->ID;?>">

                                <div id="tdLinea" class="col-lg-8 col-md-8 col-sm-8">
                                    <select id="selLinea" name="selLinea" onchange="fncLinea();" class="chosen-select form-control filtroLista" style="width:300px;">
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
                                <label class="col-lg-4 col-md-4 col-sm-4 control-label">Categoría:</label>

                                <div id="tdCategoria" class="col-lg-8 col-md-8 col-sm-8">
                                    <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" class="chosen-select form-control filtroLista" style="width:300px;">
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
                            <div class="form-group">
                                <label class="col-lg-4 col-md-4 col-sm-4 control-label">Producto:<span class="asterisk">*</span></label>

                                <div class="col-lg-8 col-md-8 col-sm-8 lista_producto" id="tdProducto" >
                                    <select id='selProducto' name='selProducto' onchange='fncProducto();' class="chosen-select">
                                        <option value='0'>--SELECCIONAR--</option>
                                        <?php foreach($GLOBALS['dtProducto'] as $item){?>
                                        <option value="<?php echo $item['ID']?>"><?php echo sprintf("%'.07d",$item['codigo'])." - ".FormatTextView($item['producto']);?></option>
                                        <?php } ?>
                                     </select>
                                </div>
                                <script type="text/javascript">
                                    $("#selProducto").val(<?php echo $GLOBALS['oCompra_Detalle']->producto_ID;?>);

                                </script>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Descripción:</label>

                                <div class="col-sm-12 ">
                                    <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" style="height: 100px;overflow:auto;resize:none;" ><?php echo FormatTextView($GLOBALS['oCompra_Detalle']->descripcion); ?></textarea>

                                </div>

                            </div>
                        </div>
                        <div class="col-sm-5">
                            
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Cantidad:<span class="asterisk">*</span></label>

                                <div class="col-sm-7">
                                    <input type="text" id="txtCantidad" name="txtCantidad"  class="int form-control text-center"  autocomplete="off" value="<?php echo $GLOBALS['oCompra_Detalle']->cantidad;?>" onkeyup="ProductoValores($('#txtCantidad').val(),$('#txtPrecioUnitario').val(),'#txtSubTotal');">

                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Precio unitario <?php echo FormatTextView($GLOBALS['oCompra_Detalle']->oMoneda->simbolo);?>:<span class="asterisk">*</span></label>

                                <div class="col-sm-7">
                                    <input type="text" id="txtPrecioUnitario" name="txtPrecioUnitario"  autocomplete="off" class="decimal form-control" value="<?php echo $GLOBALS['oCompra_Detalle']->precio?>" onkeyup="ProductoValores($('#txtCantidad').val(),$('#txtPrecioUnitario').val(),'#txtSubTotal');">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-5 control-label">Destino:</label>

                               <div class="col-sm-3">
                                    <div class="rdio rdio-theme circle">
                                        <input id="rbStock" type="radio" name="rbDestino" value="1" onclick="desactivarDocumentos(this.value);">
                                        <label for="rbStock">Stock</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="rdio rdio-theme circle">
                                        <input type="radio" id="rbVenta" name="rbDestino" value="2" onclick="desactivarDocumentos(this.value);">

                                        <label for="rbVenta">Vendidos</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Stock:</label>

                                <div class="col-sm-7">
                                    <input type="text" id="txtStock" name="txtStock" class="form-control" value="<?php echo $GLOBALS['oCompra_Detalle']->stock; ?>" disabled>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5  control-label">Sub total <?php echo FormatTextView($GLOBALS['oCompra_Detalle']->oMoneda->simbolo);?>:</label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtSubTotal" name="txtSubTotal" class="form-control" value="<?php echo $GLOBALS['oCompra_Detalle']->subtotal?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">I.G.V.<?php echo $GLOBALS['oCompra_Detalle']->vigv*100;?>% <?php echo FormatTextView($GLOBALS['oCompra_Detalle']->oMoneda->simbolo);?>:</label>

                                <div class="col-sm-7">
                                    <input type="text" id="txtIgv" name="txtIgv" class="form-control" value="<?php echo $GLOBALS['oCompra_Detalle']->igv?>" disabled>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Total <?php echo FormatTextView($GLOBALS['oCompra_Detalle']->oMoneda->simbolo);?>:</label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtTotal" name="txtTotal" class="form-control" value="<?php echo $GLOBALS['oCompra_Detalle']->total?>" disabled> 

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div id="tbdocumentos" class="form-group tab-pane fade inner-all"  style="overflow:auto;height: 300px;">
                   
                   
                </div>
            </div>
        </div>
        
    </div>
  
</form>

        
   

<div id="fondo_espera" style="background:#000;opacity:0.7;width:100%;height:100%;z-index: 56;text-align:center;top:0;position:absolute; display:none;" ><img width="80px" src="/include/img/loader-Login.gif"></div>
    

<script type="text/javascript">
        <?php if($GLOBALS['oCompra_Detalle']->destino==1){ ?>
            $('#rbVenta').prop('checked', false);
            $('#rbStock').prop('checked', true);
        <?php } else {?>
            $('#rbStock').prop('checked', false);
            $('#rbVenta').prop('checked', true);
        <?php } ?>
       
           
    var validar=function(){
        
        $('#txtSubTotal').removeAttr('disabled');
        $('#txtIgv').removeAttr('disabled');
        $('#txtTotal').removeAttr('disabled');
        var producto_ID=$('#selProducto').val();
        var descripcion= $.trim($('#txtDescripcion').val());
        var cantidad= $.trim($('#txtCantidad').val());
        var precio_unitario=$.trim($('#txtPrecioUnitario').val());
        
        if(producto_ID=='0'){
            mensaje.advertencia('VALIDACIÓN DE DATOS','Seleccione un producto.','selProducto');
            
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
    
    var fncProducto=function(producto_ID){
        
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
    var limpiarPadre=function(){
        $('#txtStock').val('');
        $('#tbdocumentos').html('');
    } 
    var fncListaProductosVendidos=function(producto_ID){
        var compra_detalle_ID=$('#txtID').val();
         $('#tbdocumentos').html('<div style="background:#000;opacity:0.7;width:500px;height:100%;text-align:center;" ><img width="80px" src="/include/img/loader-Login.gif"></div>');
        cargarValores1('/Ingreso/ajaxProductos_Vendidos',producto_ID,compra_detalle_ID,function(resultado){
           
            $('#tbdocumentos').html(resultado.html); 
            $('#script').html(resultado.funcion);

        });
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
    var desactivarDocumentos=function(valor){
        if(valor==2){
            $('#tableDestino input[type=checkbox]').each(function(){
                $(this).removeAttr('disabled');
            });
            
            $('#tbdocumentos td').css('background','#fff');
            var cantidad=$('#txtCantidad').val();
                if(cantidad==""||cantidad==0){
                    $('#divMensaje').html('<label style="color:red;">Debe ingresar una cantidad.</label>');
                }else {
                   
                    var i=0;
                    $('#tableDestino tr').each(function(){
                        if(i>0){
                            var cantidad_vendida=parseInt($(this).find("td").eq(0).html(),10);
                            if(cantidad>0){
                                 
                                var objeto=$(this).find("td input[type=checkbox]");
                                $(objeto).prop('checked',true);
                            }
                            cantidad=cantidad-cantidad_vendida;
                        }
                        i++;
                    });
                }
        }else {
            $('#tableDestino input[type=checkbox]').each(function(){
                $(this).prop('checked',false);
                $(this).prop('disabled',true);
            });
            //$(this).attr('disabled',true);
            $('#tbdocumentos td').css('background','rgb(235, 235, 228)');
        }
        
      
    }
    $(document).ready(function(){
        fncListaProductosVendidos(<?php echo $GLOBALS['oCompra_Detalle']->producto_ID;?>);
    });
    var desactivar_edicion=function(){
        $('#selLinea').prop('disabled',true);
        $('#selCategoria').prop('disabled',true);
        $('#selProducto').prop('disabled',true);
        $('#txtDescripcion').prop('disabled',true);
        $('#txtCantidad').prop('disabled',true);
        $('#txtPrecioUnitario').prop('disabled',true);
        $('#rbVenta').prop('disabled',true);
       // $('#img_divProductos').remove();
        $('#btnEnviar').remove();
    }
    
    </script>
 <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
            
            <script type="text/javascript">
               // alert('-1');
           $('#divMensaje').html(' <?php  echo $GLOBALS['mensaje']; ?>');
           // setTimeout('window_float_save();', 1000);
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
