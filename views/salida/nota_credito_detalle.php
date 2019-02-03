<?php		
	require ROOT_PATH . "views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Registrar Cotización<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jForm.js"></script>
       

<?php } ?>

<?php function fncTitleHead(){ ?>Registrar Cotización<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="form" method="POST" action="/Salida/Nota_Credito_Detalle"  class="form-horizontal" onsubmit="return validar();" >
    <input type="hidden" id="llave" name="llave" value="<?php echo $GLOBALS['llave'];?>">
    <div class="form-body">
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Producto:</label>
            <div class="col-sm-10 col-md-10 col-xs-10">
                
                <input type="hidden" id="txtProducto_ID" name="txtProducto_ID">
                <input type="text" id="listaProductos" name="listaProductos" class="form-control">
                <script type="text/javascript">
                    $(document).ready(function(){
                        lista('/funcion/ajaxListarProductos','listaProductos','txtProducto_ID');
                    });
                </script>
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Descripción:</label>
            <div class="col-sm-10 col-md-10 col-xs-10">
                <input type="text" id="txtDescripcion" name="txtDescripcion" class="form-control">
                
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Cantidad:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="text" id="txtCantidad" name="txtCantidad" onkeyup="ProductoValores();" autocomplete="off" class="form-control int">
            </div>
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Tipo del IGV.:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <select id="selTipo_Impuesto" name="selTipo_Impuesto" class="form-control">
                    <?php foreach($GLOBALS['dtTipo_Impuestos'] as $item){?>
                    <option value="<?php echo $item['Id']?>"><?php echo FormatTextView($item['Descripcion']);?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Precio Unit:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="text" id="txtValor_Unitario"  name="txtValor_Unitario" onkeyup="ProductoValores();" autocomplete="off" class="form-control decimal">
            </div>
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Subtotal:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="text" id="txtSubTotal" name="txtSubTotal" disabled class="form-control" >
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Total:</label>
            <div class="col-sm-4 col-md-4 col-xs-4 text-left">
                <input type="text" id="txtTotal" name="txtTotal" disabled class="form-control">
            </div>
            <label class="control-label col-sm-2 col-md-2 col-xs-2">IGV:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="text" id="txtIGV" name="txtIGV" disabled class="form-control" >
            </div>
        </div>
        
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button type="submit" class="btn btn-success">Guardar</button>
            <button type="button" class="btn btn-danger" onclick="parent.float_close_modal_hijo();">Cancelar</button>
        </div>
        <div class="clearfix"></div>
    </div>
    
</form>
 <script type="text/javascript">
    var validar=function(){
        $("#txtSubTotal").prop('disabled', false);
        $("#txtIGV").prop('disabled', false);
        $("#txtTotal").prop('disabled', false);
        var producto_ID=$.trim($("#txtProducto_ID").val());
        var cantidad=$.trim($("#txtCantidad").val());
        var precio_unitario=$.trim($("#txtValor_Unitario").val());
        var subtotal=$.trim($("#txtSubTotal").val());
        var igv=$.trim($("#txtIGV").val());
        var total=$.trim($("#txtTotal").val());
        //var otros_cargos=$.trim($("#txtOtros_Cargos").val());
        if(producto_ID==""){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe seleccionar un producto.",'listaProductos');
            return false;
        }
        if(cantidad==""||cantidad==0){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe registrar una catidad.",'txtCantidad');
            return false;
        }
        if(precio_unitario==""||precio_unitario==0){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe registrar un valor unitario.",'txtValor_Unitario');
            return false;
        }
        if(subtotal==""||subtotal==0){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Existe un error al calcular el sub total.");
            return false;
        }
        if(igv==""||igv==0){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Existe un error al calcular el IGV.");
            return false;
        }
        if(total==""||total==0){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Existe un error al calcular el total.");
            return false;
        }
        
        
    }
    function ProductoValores(){   
        var cantidad=$('#txtCantidad').val();
        var valor_unitario=$('#txtValor_Unitario').val().split(',').join('');
        //var porcentaje_descuento=$.trim($('#txtDescuento').val());
        var tipo_igv=$("#selTipo_Impuesto").val();
        //var otros_cargos=$.trim($("#txtOtros_Cargos").val());
        if($.trim(cantidad)==""){
            cantidad=0;
        } else {cantidad=parseInt(cantidad);}
        if($.trim(valor_unitario)==""){
          var valor_unitario=0;
        }else {
            valor_unitario=valor_unitario;

        }
        var resultado=redondear(cantidad*valor_unitario,2);
        /*if($.trim(porcentaje_descuento)!=""){
            resultado=resultado*((100-porcentaje_descuento)/100);
        }*/
        var subtotal=redondear(parseFloat(resultado)/1.18,2)
        if(isNaN(subtotal)==false){ 
            $('#txtSubTotal').val(subtotal); 
        }else{
            $('#txtSubTotal').val('--');
        }
        var total=redondear(resultado,2);
        var vigv=redondear(total-subtotal,2);
        $('#txtIGV').val(vigv);   
       
        /*if(otros_cargos!=""){
            resultado=resultado+parseFloat(otros_cargos);
        }*/
        //var total=redondear(resultado,2);
        $('#txtTotal').val(resultado);
    }
        
        
   
 </script>   
<?php }?>
            
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
        $(document).ready(function () {
            mensaje.error('MENSAJE DE RESULTADO','<?php echo $GLOBALS['mensaje']; ?>');
        });
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
<script type="text/javascript">
    $(document).ready(function () {
       toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
    });
    setTimeout('parent.windos_float_save_modal_hijo(<?php echo json_encode($GLOBALS['obj']);?>);', 1000);
    
  
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