<?php		
	require ROOT_PATH."views/shared/content-float-hijo.php";	
?>	
<?php function fncTitle(){?>EDITAR NUEVO PRODUCTO<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jDate.js"></script>
    <script type="text/javascript" src="include/js/jCboDiv.js"></script>
    <script type="text/javascript" src="include/js/jGrid-float.js"></script>
    <script type="text/javascript" src="include/js/jForm.js"></script>
     <script type="text/javascript" src="include/js/jlista.js"></script>
      <script type="text/javascript" src="include/js/jValidarLargoComentarios.js"></script>
    <link rel="stylesheet" type="text/css" href="include/css/date.css" />

    <link rel="stylesheet" type="text/css" href="include/css/cboDiv.css" />
    <link rel="stylesheet" type="text/css" href="include/css/grid-float.css" />
    <link rel="stylesheet" type="text/css" href="include/css/listaDiv.css" />
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

<?php function fncTitleHead(){?>EDITAR PRODUCTO DE OBSEQUIOS<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1"  method="post" style='width: 1100px; height: auto;' action="Cotizacion/Cotizacion_Mantenimiento_Obsequio_Editar/<?php echo $GLOBALS['oCotizacion_Detalle']->ID;?>" onsubmit="return validar();">
    <table width='1000px' height='200px' style='margin:0 auto;'>
        <tr>
            <th>Línea
                <input id='txtID' name='txtcotizacion_detalle_ID' value='<?php echo $GLOBALS['oCotizacion_Detalle']->ID;?>' style='display:none;' >
            </th>
            <td id="tdLinea" >
                <select id="selLinea" name="selLinea" onchange="fncLinea();" class="filtroLista" style="width:350px;">
                    <option value="0">TODOS</option>
                <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
                    <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                <?php } ?>
                </select>
                <script type="text/javascript">
                    $('#selLinea').val(<?php echo $GLOBALS['oCotizacion_Detalle']->linea_ID;?>);
                </script>  
            </td>
            
            
            <th>
               Stock
            </th>
            <td colspan="2">
                <input type="text" id="txtStock" name="txtStock" class="desactivado" style="width:50px;" value="<?php echo $GLOBALS['oInventario']->stock; ?>" disabled>
        
            </td>
        </tr>
        <tr>
            <th>Categoría</th>
            <td id="tdCategoria" >
                <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" class="filtroLista" style="width:350px;">
                <option value="0" selected>TODOS</option>
                <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
                        <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                <?php } ?>

                </select> 
                
                <script type="text/javascript">
                    $('#selCategoria').val(<?php echo $GLOBALS['oCotizacion_Detalle']->categoria_ID;?>);
                </script>  
            </td>
           <th>Precio Compra</th>
            <td>
                <input  type="text" id="txtPrecioCompraDolares" name="txtPrecioCompraDolares" class="moneda" disabled  style="width:100px;" >
            </td>
            <td>
                <input type="text" id="txtPrecioCompraSoles" name="txtPrecioCompraSoles" class="moneda" disabled  style="width:100px;" >
            </td>
        </tr>
        <tr>
            <th>Producto</th>

            <td id="tdProducto" class="lista_producto" >
                <div id="divProductos" class="input-content obligatorio"></div>
                <script type="text/javascript">
                    
                    <?php if($GLOBALS['oCotizacion_Detalle']->ID>0){ ?>
                         cargarLista('divProductos', 'txtProducto_ID', '/Funcion/ajaxListar_Producto', 350,<?php echo $GLOBALS['oCotizacion_Detalle']->oProducto->ID;?>,'<?php echo sprintf("%'.05d",$GLOBALS['oCotizacion_Detalle']->oProducto->ID);?>-<?php  echo FormatTextViewHtml($GLOBALS['oCotizacion_Detalle']->oProducto->nombre);?>', true,'filtroLista',500,20);
                    <?php } else {?>
                        
                        newLista('divProductos', 'txtProducto_ID', '/Funcion/ajaxListar_Producto', 350, true,'filtroLista',500,20);
                    <?php } ?> 
                   
                </script>
    
            </td>
            <th width='200'>Cantidad</th>
            <td width='200'>
                <input type="text" id="txtCantidad" name="txtCantidad" class="int obligatorio" autocomplete="off" style="width:80px;text-align:right;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->cantidad;?>" >
            </td>
            <td></td>
        </tr>
      
      
        <tr>
            <th style="width:500px;text-align:left;" colspan='2'>Descripción</th>
            <th>Separar Productos</th>
            <td colspan="2"><input type="checkbox" name="ckSeparacion" id="ckSeparacion" disabled value="1" onclick="fncTiempo_Separacion();"></td> 
            
           
            
        </tr>
        <tr>
            <td colspan="2" rowspan='3' id="tdComentario" style="vertical-align: top;">
                <textarea id="txtDescripcion" name="txtDescripcion" class="comentario" rows="7" cols="40" maxlength="2000" style="width:500px;height:50px;"><?php echo FormatTextView($GLOBALS['oCotizacion_Detalle']->descripcion);?></textarea>
            </td>
            <th style="vertical-align: top;"> Tiempo(días)</th>
            <td colspan="2" style="vertical-align: top;">
                <input type="number" name="txtTiempo_Separacion" disabled id="txtTiempo_Separacion" value="1" style="width:50px;">
         
            </td>
            
        </tr>
        <tr>   
            
            <th colspan="3">
            </th>
            
        </tr>
        <tr>
            <th colspan="3"></th>
            
        </tr>
        <tr>
            <td colspan="5">
                <div class="btn_flotante_hijo">   
                   
                    <button  id="btnEnviar" name="btnEnviar" class="botones_formulario">
                        <img title="Guardar" alt="" src="/include/img/boton/save_48x48.png">
                       Guardar
                    </button>
                     <button id="btnRegresar1" type="button" class="botones_formulario" onclick=" window_deslizar_close();">
                            <img src="/include/img/boton/cancel_48x48.png"  />
                            Cancelar
                    </button>                                                      
                </div> 
              
            </td>
        </tr>
    </table>
    
    
    <div id="divDetalle" class='divDetalle'>
        <div class='divDetalleCabecera'>
            <ul>
            <li><a  onclick="fncDetalleInfo('DivSeparaciones','divCuerpo',this,null,fncDesactivarBtnDetalle);" class='liActivo'>Separaciones</a></li>
            <li><a  onclick="fncDetalleInfo('historial','divCuerpo',this,null, fncDesactivarBtnDetalle);" >Historial</a></li>
            </ul>
        </div>
        
        <div  class='divDetalleCuerpo' style="height:200px;overflow:overlay;">
            <div id="DivSeparaciones" class='divCuerpo' ></div>
            <div id="historial" class='divCuerpo'  style="display:none" ></div>
 
            
        </div>
            
        
    </div>
    
    
   
    <div id="fondo_mensaje" style="display:none;">
        <div id="window-float" style="background: #fff; width:300px; margin:0 auto;border-radius: 5px; padding: 10px;border:1px solid #000;">
            El precio de venta es menor que el costo de referencia, <br/> por favor ingrese la contraseña de autorización. <br/>
            <input type="password" id="txtContrasena" style="margin:10px;"><br/>
            <button type="button" onclick="fncValidarAutorizacion();">Validar</button>
            <button type="button" onclick="fncCancelarAutorizacion();">Cancelar</button><br/>
            <label id="lbMensaje" style="color:red;"></label>
        </div> 
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
        fncCargarPrecioCompra(<?php echo $GLOBALS['oCotizacion_Detalle']->oProducto->ID;?>);
            
    });    
    var Resultado_verificar=0;
    var validar=function(){
       
        var producto_ID=$('#txtProducto_ID').val();
        var componente=0;
        
        var cantidad= $.trim($('#txtCantidad').val());
        
        if(producto_ID==undefined){
           toastem.error('Seleccione un producto.');
            $('#txtdivProductos').focus();
            return false;
        }

        //Verifico si el comprobante requiere serie y número
        if(isNaN(cantidad)||cantidad==""){
            
            toastem.error('Registre una cantidad.');
            $('#txtCantidad').focus();
            return false;   
        }
        $('#fondo_espera').css('display','');
        
    }
   

    
    var fncHistoriaProducto=function(producto_ID){
        cargarValores('/Ventas/ajaxHistorial_Producto',producto_ID,function(resultado){
            $('#historial').html(resultado.html); 
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
    //alert(obj.val()); 
    $('#divProducto').html('');
    //$('#txtNombre').val('');
   // $('#selProducto').val('');
    var obj = $('#selLinea');

    ajaxSelect('selCategoria', '/Compra/ajaxSelect_Categoria/' + obj.val(), '',fncCategoria);
    //f.enviar();
    }

    var fncCategoria=function(){
        $('#divProducto').html('');
       // $('#txtNombre').val('');
        //$('#selProducto').val('');
        var obj = $('#selCategoria');
        var linea_ID=$('#selLinea').val();
        var valorobjeto=obj.val();
        if(valorobjeto==-1){
           $('#selProducto').html('<option value="-1">Sin Producto</option>')
        } else{
             ajaxSelect('selProducto', '/Compra/ajaxSelect_Producto/' + obj.val(), linea_ID,null);
        }

    }

   /* $('#cbodivProductos').click(function(){
        
        fncProducto($('#txtProducto_ID').val());
    });*/


    var fncEndSeleccionar=function(){
        var producto_ID=$('#txtProducto_ID').val();
        if(producto_ID>0){
            cargarValores('/Compra/ajaxSeleccionar_Producto',producto_ID,function(resultado){
            $('#txtStock').val(resultado.stock);
            $('#txtDescripcion').val(resultado.descripcion);
            if(resultado.resultado==-1){
               $('#DivSeparaciones').html(resultado.mensaje); 
            }
            if(resultado.stock>0){
                $('#ckSeparacion').removeAttr('disabled');
            }else {
                 $('#ckSeparacion').attr('disabled','disabled');
            }
            fncCargarPrecioCompra(resultado.producto_ID);
            });
        }else {
            fncLimpiar();
        }
    }
    
    var fncCargarPrecioCompra=function(producto_ID){
          cargarValores('/Compra/ajaxPrecio_Compra',producto_ID,function(resultado){
            $('#txtPrecioCompraDolares').val(resultado.precio_compra_dolares); 
            $('#txtPrecioCompraSoles').val(resultado.precio_compra_soles);
            
            if(resultado.resultado==-1){
                toastem.error(resultado.mensaje);
               $('#DivSeparaciones').html(resultado.mensaje); 
            }
            $('#DivSeparaciones').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
            VerSeparaciones(resultado.producto_ID);
        });
     } 
   
    var fncCargarPrecioCompra=function(producto_ID){
          cargarValores('/Compra/ajaxPrecio_Compra',producto_ID,function(resultado){
            $('#txtPrecioCompraDolares').val(resultado.precio_compra_dolares); 
            $('#txtPrecioCompraSoles').val(resultado.precio_compra_soles);
            
            if(resultado.resultado==-1){
                toastem.error(resultado.mensaje);
               $('#DivSeparaciones').html(resultado.mensaje); 
            }
            $('#DivSeparaciones').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
            VerSeparaciones(resultado.producto_ID);
        });
     }
   
    function VerSeparaciones(producto_ID){
        cargarValores('/Cotizacion/ajaxVerSeparaciones',producto_ID,function(resultado){
            $('#DivSeparaciones').html(resultado.html); 
            if(resultado.resultado==-1){
               $('#DivSeparaciones').html(resultado.mensaje); 
            }
             $('#historial').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
            fncHistoriaProducto(resultado.producto_ID);
        });
        
    }
    var fncLimpiar=function(){
        $('#txtPrecioCompraDolares').val('');
        $('#txtPrecioCompraSoles').val('');
        $('#DivSeparaciones').html('');
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
setTimeout('window_deslizar_save();', 1000);

 
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
