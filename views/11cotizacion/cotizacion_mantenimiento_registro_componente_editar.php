<?php		
	require ROOT_PATH."views/shared/content-float-hijo-hijo.php";	
?>	
<?php function fncTitle(){?>EDITAR COMPONENTE<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jDate.js"></script>
        <script type="text/javascript" src="include/js/jGrid-float.js"></script>
	<script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jlista.js"></script>
         <script type="text/javascript" src="include/js/jValidarLargoComentarios.js"></script>
	<link rel="stylesheet" type="text/css" href="include/css/date.css" />
	<link rel="stylesheet" type="text/css" href="include/css/cboDiv.css" />
	<link rel="stylesheet" type="text/css" href="include/css/grid-float.css" />
        <link rel="stylesheet" type="text/css" href="include/css/listaDiv.css" />
        <script type="text/javascript">
 $(document).ready(function(){
    <?php if($GLOBALS['oCotizacion']->estado_ID==25){?>
        bloquear();
    <?php } ?>
     
 });
        </script>
<?php } ?>

<?php function fncTitleHead(){?>EDITAR COMPONENTE<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
 

<form id="frm1" name="frm1" method="post" style='width: 1100px; height: 500px;' action="Cotizacion/Cotizacion_Mantenimiento_Registro_Componente_Editar/<?php echo $GLOBALS['oCotizacion_Detalle']->ID;?>" onsubmit="return validar();">
   
    <table width='1000px' height='300px' style='margin:5px auto;'>
        <tr>
           
            <th colspan='5'>
               
            </th>
            
                
           
            <th style="width:490px;text-align:center;">Descripción</th>
        </tr>
        <tr>
            <th>Línea</th>
            <td id="tdLinea" colspan="4">
                <select id="selLinea" name="selLinea" onchange="fncLinea();" class="filtroLista" style="width:200px;">
                <option value="0">TODOS</option>
                <?php foreach($GLOBALS['oCotizacion_Detalle']->dtLinea as $iLinea){ ?>
                    <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                <?php } ?>
                </select>
                <script type="text/javascript">
                    $('#selLinea').val(<?php echo $GLOBALS['oCotizacion_Detalle']->linea_ID;?>);
                </script>  
            </td>
            <td rowspan="5" id="tdComentario">
                <textarea id="txtDescripcion" name="txtDescripcion" class="comentario" rows="7"  cols="40" maxlength="3000"   style="width:490px;height:60px;"><?php echo FormatTextViewHtml($GLOBALS['oCotizacion_Detalle']->descripcion);?></textarea>
            </td>
        </tr>
        <tr>
            <th>Categoría</th>
            <td id="tdCategoria" colspan="4" >
                <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" class="filtroLista" style="width:200px;">
                <option value="0" selected>TODOS</option>
                <?php foreach($GLOBALS['oCotizacion_Detalle']->dtCategoria as $iCategoria){ ?>
                        <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                <?php } ?>

                </select> 
                <input id="txtp" style="display:none;">
                <script type="text/javascript">
                    $('#selCategoria').val(<?php echo $GLOBALS['oCotizacion_Detalle']->categoria_ID;?>);
                </script>  
            </td>
           
        </tr>
        <tr>
            <th>Producto</th>
            <td id="tdProducto" class="lista_producto" colspan="4">
                <div id="divProductos" class="input-content obligatorio"></div>
                <script type="text/javascript">
                    <?php if($GLOBALS['oCotizacion_Detalle']->ID>0){ ?>
                         cargarLista('divProductos', 'txtProducto_ID', '/Funcion/ajaxListar_Producto', 350,<?php echo $GLOBALS['oCotizacion_Detalle']->oProducto->ID;?>,'<?php echo sprintf("%'.05d",$GLOBALS['oCotizacion_Detalle']->oProducto->ID);?>-<?php  echo FormatTextViewHtml($GLOBALS['oCotizacion_Detalle']->oProducto->nombre);?>', true,'filtroLista',500,20);
                    <?php } else {?>
                         newLista('divProductos', 'txtProducto_ID', '/Funcion/ajaxListar_Producto', 350, true,'filtroLista',500,20);
                    <?php } ?> 
                   
                </script>

             </td>
        </tr>

        <tr>
            <th>Cantidad</th>
            <th>
                <input type="text" id="txtCantidad"  name="txtCantidad" class="int obligatorio"  autocomplete="off" style="width:80px;text-align:right;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->cantidad;?>" onkeyup="ProductoValores();">
                
                
                
            </th>
            <th>
                Stock
            </th>
            <td>
                <input type="text" id="txtStock" name="txtStock" style="width:50px;" class="desactivado" value="<?php echo $GLOBALS['oCotizacion_Detalle']->stock; ?>" disabled>
              
            </td>
            <td></td>
        </tr>
        <tr>
            <th>Precio Compra</th>
            <th>US$</th>
            <td>
                <input  type="text" id="txtPrecioCompraDolares"  name="txtPrecioCompraDolares" class="decimal" disabled  style="width:100px;" >
            </td>
            <th>S/.</th>
            <td>
                <input type="text" id="txtPrecioCompraSoles" name="txtPrecioCompraSoles" class="decimal" disabled  style="width:100px;" >
          
            </td>
        </tr>
        <tr>
            <th>Precio unitario</th>
            <th>US$</th>
            <td>
                <input type="text" id="txtPrecioUnitarioDolares" autocomplete="off"  class="moneda" name="txtPrecioUnitarioDolares" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_unitario_dolares;?>" onkeyup="calcularTipoCambio('2');">
            </td>
            <th>S/.</th>
            <td>
                <input type="text" id="txtPrecioUnitarioSoles" autocomplete="off" class="moneda"  name="txtPrecioUnitarioSoles" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_unitario_soles;?>" onkeyup="calcularTipoCambio('1');">
            
            </td>
            <td rowspan="4" >
                <div id="DivSeparaciones" style="overflow:auto;width:490px;height: 100px;"></div>
            </td>
        </tr>
       
        <tr>
            <th>SubTotal</th>
            <th>US$</th>
            <td>
                <input type="text" id="txtSubTotalDolares" class="moneda" name="txtSubTotalDolares" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_subtotal_dolares;?>" disabled>
               
            </td>
            <th>S/.</th>
            <td>
                <input type="text" id="txtSubTotalSoles" class="moneda" name="txtSubTotalSoles" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_subtotal_soles;?>" disabled>
                
            </td>
        </tr>
         <tr>
            <th>I.G.V <?php echo $GLOBALS['oCotizacion_Detalle']->oCotizacion->igv*100;?>%
                <input type="text" id="txtValIgv" name="txtValIgv" value="<?php echo $GLOBALS['oCotizacion_Detalle']->oCotizacion->igv;?>" style="display:none;">
            </th>
            <th>US$</th>
            <td>
                <input type="text" id="txtIgvDolares" name="txtIgvDolares" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->vigv_dolares;?>" disabled>
                
            </td>
            <th>S/.</th>
            <td>
                <input type="text" id="txtIgvSoles" name="txtIgvSoles" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->vigv_soles;?>" disabled>
                
            </td>
           
        </tr>
        <tr>
            <th>Total</th>
            <th>US$</th>
            <td>
                <input type="text" id="txtTotalDolares" name="txtTotalDolares" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_dolares;?>" disabled>
                
            </td>
            <th>S/.</th>
            <td>
                <input type="text" id="txtTotalSoles" name="txtTotalSoles" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_soles;?>" disabled>
             
            </td>
              
        </tr>
       
        <tr>
            <th>
                Mostrar Precio
            </th>
            <td>
                <input  id="cbVer_Precio" name="cbVer_Precio" type="checkbox" value="1">
                <script type="text/javascript">
                    <?php if($GLOBALS['oCotizacion_Detalle']->ver_precio==1){?>
                        $('#cbVer_Precio').prop('checked', true);
                    <?php } ?>
                </script>
            </td>
            <th>Separar Productos</th>
            <td><input type="checkbox" name="ckSeparacion" id="ckSeparacion" disabled value="1" onclick="fncTiempo_Separacion();"></td> 
            <th> Tiempo(días)</th>
            <td>
                <input type="number" name="txtTiempo_Separacion" disabled id="txtTiempo_Separacion" value="1" style="width:50px;">
         
            </td>
           
        </tr>
        <tr>
            <td colspan="6">
                <div class="btn_flotante_hijo_hijo">  
                    <?php if($GLOBALS['oCotizacion']->estado_ID!=25){?>
                    <button  id="btnEnviar" name="btnEnviar" class="botones_formulario" >
                       <img title="Guardar" alt="" src="/include/img/boton/save_48x48.png">
                       Guardar
                    </button>
                    <?php }?>
                    <button  id="btnCancelar" name="btnCancelar" type="button" class="botones_formulario" title="Cancelar" onclick="window_deslizar_hijo_save();" >
                        <?php if($GLOBALS['oCotizacion']->estado_ID!=25){?>
                        <img src="/include/img/boton/cancel_48x48.png"  />
                        Cancelar
                         <?php } else {?>
                         <img src="/include/img/boton/salir1_48x48.png"  />
                        Regresar
                         <?php }?>
                    </button>                                                          
                </div> 
            </td>
        </tr>
       
    </table>

    <div id="historial" style="height:195px;overflow:overlay;"></div>
    <div id="script"></div>
    <div id="fondo_mensaje" style="display:none;">
        <div id="window-float" style="background: #fff; width:300px; margin:0 auto;border-radius: 5px; padding: 10px;border:1px solid #000;text-align:center;">
            El precio de venta es menor que el costo de referencia, <br/> por favor ingrese la contraseña de autorización. <br/>
            <input type="password" id="txtContrasena" style="margin:10px;"><br/>
            <button type="button" onclick="fncValidarAutorizacion();" >Validar</button>
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
        $('#txtSubTotalSoles').removeAttr('disabled');
        $('#txtSubTotalDolares').removeAttr('disabled');
        $('#txtIgvSoles').removeAttr('disabled');
        $('#txtIgvDolares').removeAttr('disabled');
        $('#txtTotalSoles').removeAttr('disabled');
        $('#txtTotalDolares').removeAttr('disabled');
        var producto_ID=$('#selProducto').val();
        
        var cantidad= $.trim($('#txtCantidad').val());
        var PrecioUnitarioSoles=$.trim($('#txtPrecioUnitarioSoles').val());
        var PrecioUnitarioDolares=$.trim($('#txtPrecioUnitarioDolares').val());
        
        $('#divMensaje').html('');
        if(producto_ID==0){
            $('#divMensaje').html('Seleccione un producto.');
            $('#selProducto').focus();
            return false;
        }

        //Verifico si el comprobante requiere serie y número
        if(isNaN(cantidad)||cantidad==""){
            
            $('#divMensaje').html('Registre una cantidad.');
            $('#txtCantidad').focus();
            return false;   
        }

        if(isNaN(PrecioUnitarioSoles)||PrecioUnitarioSoles==""){
            $('#divMensaje').html('Registre un precio unitario (S/.).');
            $('#txtPrecioUnitario').focus();
            return false;   
        }
         if(isNaN(PrecioUnitarioDolares)||PrecioUnitarioDolares==""){
            $('#divMensaje').html('Registre un precio unitario ($).');
            $('#txtPrecioUnitario').focus();
            return false;   
        }
        var precioCompraUnitarioDolares=$('#txtPrecioCompraDolares').val();
        
        if(precioCompraUnitarioDolares*1>=PrecioUnitarioDolares*1){
           if(Resultado_verificar==0){
                $('#fondo_mensaje').css('display','block');
                return false;
           }
        }
        $('#fondo_espera').css('display','block');
        			
    }
    var fncValidarAutorizacion=function(){
        var resultado=0;
        var valor=$('#txtContrasena').val();
        cargarValores('/Cotizacion/ajaxValidarCostoCompraMenor',valor,function(resultado){
            Resultado_verificar=resultado.resultado;
            
            if(resultado.resultado==-1){
                alert(resultado.mensaje);
            }else if(resultado.resultado==0){
                $('#lbMensaje').html('Contraseña incorrecta');
                $('#fondo_mensaje').css('display','block'); 
            }
            else {
                $( "#frm1" ).submit();
                $('#fondo_mensaje').css('display','none'); 
            }
        });
       
    }
    
    var fncCancelarAutorizacion=function(){
        Resultado_verificar=0;
        $('#txtPrecioUnitarioDolares').focus();
        $('#lbMensaje').html('');
        $('#fondo_mensaje').css('display','none');
        
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
    var fncOpcion=function(valor){
        if(valor==3){
            $('#txtPrecioUnitarioSoles').val(0);
            $('#txtPrecioUnitarioDolares').val(0);
            $('#txtSubTotalDolares').val(0);
            $('#txtSubTotalSoles').val(0);
            $('#txtIgvDolares').val(0);
            $('#txtIgvSoles').val(0);
            $('#txtTotalDolares').val(0);
            $('#txtTotalSoles').val(0);
            $('#txtPrecioUnitarioSoles').prop('disabled',true);
            $('#txtPrecioUnitarioDolares').prop('disabled',true);
        }else {
            $('#txtPrecioUnitarioSoles').val('');
            $('#txtPrecioUnitarioDolares').val('');
            $('#txtSubTotalDolares').val('');
            $('#txtSubTotalSoles').val('');
            $('#txtIgvDolares').val('');
            $('#txtIgvSoles').val('');
            $('#txtTotalDolares').val('');
            $('#txtTotalSoles').val('');
            $('#txtPrecioUnitarioSoles').prop('disabled',false);
            $('#txtPrecioUnitarioDolares').prop('disabled',false);
        }
       
    }
    var fncLinea=function(){
    //alert(obj.val());                       
    var obj = $('#selLinea');

    ajaxSelect('selCategoria', '/Compra/ajaxSelect_Categoria/' + obj.val(), '',fncCategoria);
    //f.enviar();
    }

    var fncCategoria=function(){
        var obj = $('#selCategoria');
        var linea_ID=$('#selLinea').val();
        var valorobjeto=obj.val();
        if(valorobjeto==-1){
           $('#selProducto').html('<option value="-1">Sin Producto</option>')
        } else{
             ajaxSelect('selProducto', '/Compra/ajaxSelect_Producto/' + obj.val(), linea_ID,null);
        }

    }

   var fncEndSeleccionar=function(producto_ID){
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
    var fncLimpiar=function(){
        $('#txtPrecioCompraDolares').val('');
        $('#txtPrecioCompraSoles').val('');
        $('#DivSeparaciones').html('');
        $('#historial').html('');
        $('#txtDescripcion').val('');
        $('#txtStock').val('');
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
     
    function calcularTipoCambio(tipo){
        var tipo_cambio=<?php echo $GLOBALS['oCotizacion_Detalle']->oCotizacion->tipo_cambio; ?>;
        if(tipo=="1"){
            var valorSoles=$('#txtPrecioUnitarioSoles').val();
            var valorDolares=redondear(parseFloat(valorSoles)/tipo_cambio,2);
            $('#txtPrecioUnitarioDolares').val(valorDolares);
        }else{
            var valorDolares=$('#txtPrecioUnitarioDolares').val();
            var valorSoles=redondear(parseFloat(valorDolares)*tipo_cambio,2);
            $('#txtPrecioUnitarioSoles').val(valorSoles);
        }
        ProductoValores()
    }
    function ProductoValores()
       {   
           var caja1=$('#txtCantidad').val();
           var caja2=$('#txtPrecioUnitarioSoles').val();
           var caja3=$('#txtPrecioUnitarioDolares').val();
             if($.trim(caja1)==""){
                 var valor1=0;
             } else {valor1=parseInt(caja1);}
             
             if($.trim(caja3)==""){
                  var valor3=0;
             }else {
                 valor3=parseFloat(caja3);
                
                }
             if($.trim(caja2)==""){
             var valor2=0;
                }else {
                    valor2=parseFloat(caja2);
                   
                }
            var resultadoSoles=redondear(valor1*valor2,2);
            if(isNaN(resultadoSoles)==false){ 
            $('#txtSubTotalSoles').val(resultadoSoles); 
            }else{
                $('#txtSubTotalSoles').val('--');
            }
             var resultadoDolares=redondear(valor1*valor3,2);
             
             if(isNaN(resultadoDolares)==false){
                 $('#txtSubTotalDolares').val(resultadoDolares);
             }else{
                 $('#txtSubTotalDolares').val('--');
             }
             
             
             calcularIGV();    
             
        }
    function calcularIGV(){

        var subtotalSoles=$('#txtSubTotalSoles').val();
        var subtotalDolares=$('#txtSubTotalDolares').val();
        var valIGV=parseFloat($('#txtValIgv').val());
        if(subtotalSoles!=0){
            var igvSoles=redondear(parseFloat(subtotalSoles)*valIGV,2);
            $('#txtIgvSoles').val(igvSoles);
            var TotalSoles=redondear(parseFloat(subtotalSoles)+parseFloat(igvSoles),2);
            $('#txtTotalSoles').val(TotalSoles);
        }
        if(subtotalDolares!=0){
            var igvDolares=redondear(parseFloat(subtotalDolares)*valIGV,2);
            $('#txtIgvDolares').val(igvDolares);
            var TotalDolares=redondear(parseFloat(subtotalDolares)+parseFloat(igvDolares),2);
            $('#txtTotalDolares').val(TotalDolares);
        }


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
        $('#txtSubTotalDolares').val('');
        $('#txtSubTotalSoles').val('');
        $('#txtIgvDolares').val('');
        $('#txtIgvSoles').val('');
        $('#txtTotalDolares').val('');
        $('#txtTotalSoles').val('');
        $('#DivSeparaciones').html('');
        $('#historial').html('');
        
    }
    var bloquear=function(){
       
        $('#selLinea').prop('disabled', true);
        $('#selCategoria').prop('disabled', true);
        $('#img_divProductos').css('display','none');
        $('#cbVer_Precio').prop('disabled', true);
        $('#ckSeparacion').prop('disabled', true);
        $('#txtTiempo_Separacion').prop('disabled', true);
        $('#txtDescripcion').prop('disabled', true);
        $('#txtCantidad').prop('disabled', true);
        $('#txtPrecioUnitarioDolares').prop('disabled', true);
        $('#txtPrecioUnitarioSoles').prop('disabled', true);
    }
    
    </script>
</form>

 
 <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
            
            <script type="text/javascript">
               // alert('-1');
           $('#divMensaje').html('No Se Guardó.');
           // setTimeout('window_float_save();', 1000);
        </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
   <script type="text/javascript">
     
    $(document).ready(function () {
        window.parent.parent.actualizar_dimensiones();
        toastem.success('<?php echo $GLOBALS['mensaje'];?>');
    });
    window.parent.llenarCajas();
    setTimeout('window_deslizar_hijo_save();', 1000);
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
