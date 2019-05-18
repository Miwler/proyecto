<?php		
	require ROOT_PATH . "views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Registrar producto<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jForm.js"></script>
       

<?php } ?>

<?php function fncTitleHead(){ ?>Registrar producto<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="form" method="POST" action="/Salida/Guia_Venta_Mantenimiento_Producto"  class="form-horizontal" onsubmit="return validar();" >
    
    <div class="form-body">
        <div  class="form-group">
            <label class="control-label col-sm-2">Producto:</label>
            <div class="col-sm-8">
                
                <input type="hidden" id="txtProducto_ID" name="txtProducto_ID">
                <input type="text" id="listaProductos" name="listaProductos" class="form-control">
                <script type="text/javascript">
                    $(document).ready(function(){
                        listar_productos();
                    });
                </script>
            </div>
            <div class="col-sm-2">
                <input type="text" id="txtCodigo" name="txtCodigo"  autocomplete="off" class="form-control int">
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Descripción:</label>
            <div class="col-sm-10 col-md-10 col-xs-10">
                <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" style="height: 100px;overflow:auto;resize:none;"></textarea>
                
            </div>
        </div>
        <div  class="form-group">
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Cantidad:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="text" id="txtCantidad" name="txtCantidad"  autocomplete="off" class="form-control int">
            </div>
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Unidad medida:</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="text" id="txtUnidad_Medida" name="txtUnidad_Medida" disabled  autocomplete="off" class="form-control int">
            </div>
        </div>
        <div  class="form-group">
            
            <label class="control-label col-sm-2 col-md-2 col-xs-2">Peso(kg):</label>
            <div class="col-sm-4 col-md-4 col-xs-4">
                <input type="text" id="txtPeso" name="txtPeso"  autocomplete="off" class="form-control int">
            </div>
        </div>
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button type="submit" class="btn btn-success">Agregar</button>
            <button type="button" class="btn btn-danger" onclick="parent.float_close_modal_hijo();">Cancelar</button>
        </div>
        <div class="clearfix"></div>
    </div>
    
</form>
 <script type="text/javascript">
     $("#ckDescripcion").click(function(){
        if($(this).is(":checked")){
            $("#listaProductos").prop("disabled",true);
            $("#txtDescripcion").prop("disabled",false);
        }else{
            $("#listaProductos").prop("disabled",false);
            $("#txtDescripcion").prop("disabled",true);
        }
     });
    var listar_productos=function(){
        lista_producto('/funcion/ajaxListarProductos','listaProductos','txtProducto_ID',0,0,fncProducto,null);
    }
    var validar=function(){
        
        var producto_ID=$.trim($("#txtProducto_ID").val());
        var cantidad=$.trim($("#txtCantidad").val());
        
        var descripcion=$.trim($("#txtDescripcion").val());
        var peso=$.trim($("#txtPeso").val());
        if(cantidad==""||cantidad==0){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe registrar una catidad.",'txtCantidad');
            return false;
        }
        if(peso==""||peso==0){
            mensaje.advertencia("VALIDACIÓN DE INFORMACIÓN","Debe registrar un peso.",'txtPeso');
            return false;
        }
        $("#txtUnidad_Medida").prop("disabled", false);
    }
    var fncProducto=function(producto_ID){
        //var producto_ID=$("#selProducto").val();
        
        if(producto_ID>0){
            cargarValores('/Funcion/ajaxSeleccionar_Producto1',producto_ID,function(resultado){
           
                if(resultado.resultado==1){
                    
                    $('#txtStock').val(resultado.stock);
                    $('#txtDescripcion').val(resultado.descripcion);
                    $('#txtCodigo').val(resultado.codigo);
                    $('#txtUnidad_Medida').val(resultado.unidad_medida);
                    $('#txtPeso').val(resultado.peso);
                    
                }else{
                    mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
                }
                
                //fncListaProductosVendidos(producto_ID);
            });
        }else{
            fncLimpiar();
        }
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
    setTimeout('parent.windos_float_save_modal_hijo(<?php echo json_encode($GLOBALS['array']);?>);', 1000);
    
  
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