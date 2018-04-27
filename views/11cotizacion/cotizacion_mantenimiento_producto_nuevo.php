<?php		
	require ROOT_PATH."views/shared/content-float-hijo.php";	
?>	
<?php function fncTitle(){?>REGISTRAR NUEVO PRODUCTO<?php } ?>

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

<?php function fncTitleHead(){?>REGISTRAR NUEVO PRODUCTO<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['oCotizacion_Detalle']->tipo==2||$GLOBALS['oCotizacion_Detalle']->tipo==5||$GLOBALS['oCotizacion_Detalle']->tipo==6){ ?>
<form id="frm1"  method="post" style='width: 1100px; height: auto;' action="Cotizacion/Cotizacion_Mantenimiento_Producto_Nuevo/<?php echo $GLOBALS['oCotizacion']->ID;?>" onsubmit="return validar();">
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
            <th width='200'>Cantidad</th>
            <td width='200'>
                <input type="text" id="txtCantidad" name="txtCantidad" class="int obligatorio" autocomplete="off" style="width:80px;text-align:right;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->cantidad;?>" onkeyup="ProductoValores();">
            </td>
            
            <th>
               Stock <input type="text" id="txtStock" name="txtStock" class="desactivado" style="width:50px;" value="<?php echo $GLOBALS['oInventario']->stock; ?>" disabled>
              
            </th>
            
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
            <td></td>
            <th style="text-align: left;">Dólares(US$)</th>
            <th style="text-align: center;">Soles( S/.)</th>
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
            <th>Precio Compra</th>
            <td>
                <input  type="text" id="txtPrecioCompraDolares" name="txtPrecioCompraDolares" class="moneda desactivado" disabled  style="width:100px;" >
            </td>
            <td>
                <input type="text" id="txtPrecioCompraSoles" name="txtPrecioCompraSoles" class="moneda desactivado" disabled  style="width:100px;" >
            </td>
        </tr>
        <tr>
            <th colspan='2' style='text-align: left;'>
                Componente <input type="checkbox" id='ckComponente' name="ckComponente" class="checkboxTitle"  value="1">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Adicional<input type="checkbox" id='ckAdicional' name="ckAdicional"  class="checkboxTitle" value='1'>
            </th>
            
            <th>Precio unitario</th>
            <td>
                <input  type="text" id="txtPrecioUnitarioDolares" class="moneda" autocomplete="off" name="txtPrecioUnitarioDolares" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_unitario_dolares;?>" onkeyup="calcularTipoCambio('2');" >
                
            </td>
            <td>
                <input type="text" id="txtPrecioUnitarioSoles" class="moneda" autocomplete="off" name="txtPrecioUnitarioSoles" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_unitario_soles;?>" onkeyup="calcularTipoCambio('1');">
            
            </td>
        </tr>
        <tr>
            <th colspan='2' style='text-align: left;'>
                Separar Productos <input type="checkbox" name="ckSeparacion" id="ckSeparacion" disabled value="1" class="checkboxTitle" onclick="fncTiempo_Separacion();">&nbsp;&nbsp;
           &nbsp;&nbsp;&nbsp;&nbsp;
            Tiempo(días) <input type="number" name="txtTiempo_Separacion" disabled id="txtTiempo_Separacion" value="1" style="width:50px;">
         
            </th> 
            
            <th>SubTotal</th>
            <td>
                <input type="text" id="txtSubTotalDolares" name="txtSubTotalDolares" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_subtotal_dolares;?>" disabled>
                
            </td>
            <td>
                <input type="text" id="txtSubTotalSoles" name="txtSubTotalSoles" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_subtotal_soles;?>" disabled>
            </td>
        </tr>
        <tr>
            <th style="width:500px;text-align:left;" colspan='2'>Descripción</th>
            <th>Adicional</th>
            <td style='border-bottom:1px solid #000;'>
                <input type="text" id="txtAdicionalDolares" name="txtAdicionalDolares" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->adicional_dolares;?>" disabled>
               
            </td>
            <td style='border-bottom:1px solid #000;'>
                <input type="text" id="txtAdicionalSoles" name="txtAdicionalSoles" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->adicional_solares;?>" disabled>
                
            </td>
            
        </tr>
        <tr>
            <td colspan="2" rowspan='3' id="tdComentario" style="vertical-align: top;">
                <textarea id="txtDescripcion" name="txtDescripcion" class="comentario" rows="7" cols="40" maxlength="2000" style="width:500px;height:50px;"><?php echo FormatTextView($GLOBALS['oCotizacion_Detalle']->descripcion);?></textarea>
            </td>
            <th>SubTotal+</th>
            <td>
                <input type="text" id="txtSubTotalDolares1" name="txtSubTotalDolares1" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->subtotal_dolares1;?>" disabled>
                
            </td>
            <td>
                <input type="text" id="txtSubTotalSoles1" name="txtSubTotalSoles1" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->subtotal_soles1;?>" disabled>
                
            </td>
            
        </tr>
        <tr>   
            
            <th>I.G.V <?php echo $GLOBALS['oCotizacion']->igv*100;?>%
                <input type="text" id="txtValIgv" name="txtValIgv" value="<?php echo $GLOBALS['oCotizacion']->igv;?>" style="display:none;">
            </th>
            <td>
                <input type="text" id="txtIgvDolares" name="txtIgvDolares" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->vigv_dolares;?>" disabled>
                
            </td>
            <td>
                <input type="text" id="txtIgvSoles" name="txtIgvSoles" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->vigv_soles;?>" disabled>
                
            </td>
            
        </tr>
        <tr>
            <th>Total</th>
            <td>
                <input type="text" id="txtTotalDolares" name="txtTotalDolares" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_dolares;?>" disabled>
               
            </td>
            <td>
                <input type="text" id="txtTotalSoles" name="txtTotalSoles" class="moneda" style="width:100px;" value="<?php echo $GLOBALS['oCotizacion_Detalle']->precio_venta_soles;?>" disabled>
                
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <div class="btn_flotante_hijo">   
                    <button  title="Editar Componente" id="btnEditar" name="btnEditar" type="button"  style="display:none;" class="botones_formulario btn_detalle" >
                    <img   src="/include/img/boton/edit_48x48.png"> Editar
                    </button>
                    <button  title="Eliminar Componente"  id="btnEliminar" name="btnEliminar" type="button"  style="display:none;" class="botones_formulario btn_detalle" >
                       <img  src="/include/img/boton/delete_48x48.png"> Eliminar
                    </button>
 
                    <?php if($GLOBALS['oCotizacion_Detalle']->componente==1){?>
                    <button  id="btnComponente" name="btnComponente" type="button" title="Agregar Componentes" onclick="fncNuevoComponente();"  class="botones_formulario" >
                        <img   src="/include/img/boton/piezas_48x48.png"> Componente
                     </button>  
                    <?php } ?>
                    <?php if($GLOBALS['oCotizacion_Detalle']->adicional==1){?>
                    <button  id="btnAdicional" name="btnAdicional" type="button" title="Agregar Adicional" onclick="fncNuevoAdicional();"  class="botones_formulario" >
                        <img   src="/include/img/boton/Addadicional_48x48.png"> Adicional
                     </button>  
                    <?php } ?>
                     <button  id="btnEnviar" name="btnEnviar" class="botones_formulario">
                        <img title="Guardar" alt="" src="/include/img/boton/save_48x48.png">
                       Guardar
                    </button>
                     <button id="btnRegresar1" type="button" class="botones_formulario" onclick=" window_deslizar_save();">
                            <img src="/include/img/boton/salir1_48x48.png"  title="Regresar"/>
                            Regresar
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
            <?php if($GLOBALS['oCotizacion_Detalle']->componente==1){?>
            <li><a onclick="fncDetalleInfo('divComponente','divCuerpo',this,'btnComponente',fncDesactivarBtnDetalle,fncCargar_Cotizacion_Componente);">Componentes</a></li>
            <?php } ?>
            <?php if($GLOBALS['oCotizacion_Detalle']->adicional==1){?>
            <li><a onclick="fncDetalleInfo('divAdicional','divCuerpo',this,'btnAdicional',fncDesactivarBtnDetalle,fncCargar_Cotizacion_Adicional);">Adicionales</a></li>
            <?php } ?>
            </ul>
        </div>
        
        <div  class='divDetalleCuerpo' style="height:150px;overflow:overlay;">
            <div id="DivSeparaciones" class='divCuerpo' ></div>
            <div id="historial" class='divCuerpo'  style="display:none" ></div>
            <div id="divComponente" class='divCuerpo' style="display:none"></div>
            
            <div id="divAdicional" class='divCuerpo' style="display:none"></div>
            
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

    var Resultado_verificar=0;
    var validar=function(){
       
        var producto_ID=$('#txtProducto_ID').val();
        var componente=0;
        if($('#ckComponente').prop('checked')){
            componente=1;
        }
        var adicional=0;
        if($('#ckAdicional').prop('checked')){
            adicional=1;
        }
        var cantidad= $.trim($('#txtCantidad').val());
        var PrecioUnitarioSoles=$.trim($('#txtPrecioUnitarioSoles').val()).split(',').join('');
        var PrecioUnitarioDolares=$.trim($('#txtPrecioUnitarioDolares').val()).split(',').join('');
        
        
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
        if(componente==0){
            if(isNaN(PrecioUnitarioSoles)||PrecioUnitarioSoles==""){
                toastem.error('Registre un precio unitario (S/.).');
                $('#txtPrecioUnitarioDolares').focus();
                return false;   
            }
             if(isNaN(PrecioUnitarioDolares)||PrecioUnitarioDolares==""){
                toastem.error('Registre un precio unitario ($).');
                $('#txtPrecioUnitario').focus();
                return false;   
            }
        }
        
       
        var precioCompraUnitarioDolares=$('#txtPrecioCompraDolares').val();
        if(componente==0){
            if(precioCompraUnitarioDolares*1>=PrecioUnitarioDolares*1){
               if(Resultado_verificar==0){
                    $('#fondo_mensaje').css('display','block');
                    return false;
               }
            }
        }else {
            $('#txtPrecioUnitarioSoles').prop('disabled', false);
            $('#txtPrecioUnitarioDolares').prop('disabled', false);
        }
        
        $('#txtSubTotalSoles').removeAttr('disabled');
        $('#txtSubTotalDolares').removeAttr('disabled');
        $('#txtIgvSoles').removeAttr('disabled');
        $('#txtIgvDolares').removeAttr('disabled');
        $('#txtTotalSoles').removeAttr('disabled');
        $('#txtTotalDolares').removeAttr('disabled');
        $('#fondo_espera').css('display','');
        
    }
    var llenarCajas=function(){
        var cotizacion_detalle_ID=$('#txtID').val();
        cargarValores('Cotizacion/ajaxLlenarCajas',cotizacion_detalle_ID, function(resultado){
            if(resultado.resultado==1){
                
                $('#txtPrecioUnitarioDolares').val(resultado.precio_venta_unitario_dolares);
                $('#txtSubTotalDolares').val(resultado.precio_venta_subtotal_dolares);
                $('#txtSubTotalDolares1').val(resultado.precio_venta_subtotal_dolares1);
                $('#txtIgvDolares').val(resultado.vigv_dolares);
                $('#txtTotalDolares').val(resultado.precio_venta_dolares);
                $('#txtAdicionalDolares').val(resultado.adicional_dolares);
                $('#txtAdicionalSoles').val(resultado.adicional_soles);
                $('#txtPrecioUnitarioSoles').val(resultado.precio_venta_unitario_soles);
                $('#txtSubTotalSoles1').val(resultado.precio_venta_subtotal_soles1);
                $('#txtSubTotalSoles').val(resultado.precio_venta_subtotal_soles);
                $('#txtIgvSoles').val(resultado.vigv_soles);
                $('#txtTotalSoles').val(resultado.precio_venta_soles);
                
            }else {
                toastem.error(resultado.mensaje);
            }
        });
    }
    var fncNuevoComponente=function(){
        var id=$('#txtID').val();
        window_float_deslizar_hijo('form','Cotizacion/Cotizacion_Mantenimiento_Registro_Componente_Nuevo',id,'',fncCargar_Cotizacion_Componente);

    }
    //Opción para editar los detalles
    $('#btnEditar').click(function(){
        var id=$('#detalle_ID').val();
        var src=$(this).attr('class');
        var i=src.search('btnComponente');
       
        if(i>-1){
            //Encontró clase boton de componente
            
            window_float_deslizar_hijo('form','/cotizacion/Cotizacion_Mantenimiento_Registro_Componente_Editar',id,'',fncCargar_Cotizacion_Componente);
 
        }else {
            //Encontró clase boton de adicional
             window_float_deslizar_hijo('form','/cotizacion/Cotizacion_Mantenimiento_Registro_Adicional_Editar',id,'',fncCargar_Cotizacion_Adicional);
        }
    });
    //==============funcion para elminar
    $('#btnEliminar').click(function(){
        var id=$('#detalle_ID').val();
        var src=$(this).attr('class');
        var i=src.search('btnComponente');
        if(i>-1){
           
            //Encontró clase boton de componente
            cargarValores('/Cotizacion/ajaxCotizacion_Mantenimiento_Registro_Componente_Eliminar',id,function(resultado){
                if(resultado.resultado==1){
                    fncCargar_Cotizacion_Componente(llenarCajas);
                    toastem.info(resultado.mensaje);
                }else { 
                    toastem.error(resultado.mensaje);
                }
            });
        }else {
            //Encontró clase boton de adicional
            cargarValores('/Cotizacion/ajaxCotizacion_Mantenimiento_Registro_Adicional_Eliminar',id,function(resultado){
                if(resultado.resultado==1){
                    fncCargar_Cotizacion_Adicional(llenarCajas);
                    //fncDesactivarBtnDetalle();
                    toastem.info(resultado.mensaje);
                }else {
                    toastem.error(resultado.mensaje);
                }
            });     
        }
    });
     
  
    
    var fncCargar_Cotizacion_Componente=function(callbackfunction){
        
        var cotizacion_detalle_ID=$('#txtID').val();
        $('#divComponente').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
        cargarValores('Cotizacion/ajaxCotizacion_Mantenimiento_Registro_Componente',cotizacion_detalle_ID,function(resultado){
           $('#divComponente').html(resultado.html);
           
            fncSeleccionarDetalle();
        });
        if(callbackfunction){
            callbackfunction();
        }
    }
    var fncCargar_Cotizacion_Adicional=function(callbackfunction){
        var cotizacion_detalle_ID=$('#txtID').val();
        $('#divAdicional').html('<div id="grid-loading"><center><img src="/include/img/loading_bar.gif" /></center></div>');
        cargarValores('Cotizacion/ajaxCotizacion_Mantenimiento_Registro_Adicional',cotizacion_detalle_ID,function(resultado){
            $('#divAdicional').html(resultado.html);
            fncSeleccionarDetalle();
        });
        if(callbackfunction){
            callbackfunction();
        }
    }
    var fncNuevoAdicional=function(){
        var id=$('#txtID').val();
        window_float_deslizar_hijo('form','Cotizacion/Cotizacion_Mantenimiento_Registro_Adicional_Nuevo',id,'',fncCargar_Cotizacion_Adicional);

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
    function calcularTipoCambio(tipo){
        var tipo_cambio=<?php echo $GLOBALS['oCotizacion']->tipo_cambio; ?>;
        if(tipo=="1"){
            var valorSoles=$('#txtPrecioUnitarioSoles').val().split(',').join('')*1;
            var valorDolares=redondear(parseFloat(valorSoles)/tipo_cambio,2);
            $('#txtPrecioUnitarioDolares').val(valorDolares);
        }else{
            var valorDolares=$('#txtPrecioUnitarioDolares').val().split(',').join('')*1;
            var valorSoles=redondear(parseFloat(valorDolares)*tipo_cambio,2);
            $('#txtPrecioUnitarioSoles').val(valorSoles);
        }
        ProductoValores();
    }
    function ProductoValores(){   
        var caja1=$('#txtCantidad').val();
        var caja2=$('#txtPrecioUnitarioSoles').val().split(',').join('');
        var caja3=$('#txtPrecioUnitarioDolares').val().split(',').join('');
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
            valor2=caja2;

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
        $('#DivSeparaciones').html('');
        $('#historial').html('');
        $('#txtDescripcion').val('');
        $('#txtStock').val('');
    }
    $('#ckComponente').click(function(){
        if($(this).prop('checked')){
            $('#txtPrecioUnitarioDolares').prop('disabled', true);
            $('#txtPrecioUnitarioDolares').val(0);
            $('#txtPrecioUnitarioSoles').prop('disabled', true);
            $('#txtPrecioUnitarioSoles').val(0);
            $('#txtSubTotalDolares').val(0);
            $('#txtIgvDolares').val(0);
            $('#txtTotalDolares').val(0);
            $('#txtSubTotalSoles').val(0);
            $('#txtIgvSoles').val(0);
            $('#txtTotalSoles').val(0);
            $('#ckSeparacion').prop('disabled', true);
            $('#txtTiempo_Separacion').prop('disabled', true);
            
        }else {
            var contador=0;
            $('#divComponente .item-tr').each(function(){
                contador++;
            });
            if(contador==0){
                $('#txtPrecioUnitarioDolares').prop('disabled', false);
                $('#txtPrecioUnitarioDolares').val('');
                $('#txtPrecioUnitarioSoles').prop('disabled', false);
                $('#txtPrecioUnitarioSoles').val('');
                $('#txtSubTotalDolares').val('');
                $('#txtIgvDolares').val('');
                $('#txtTotalDolares').val('');
                $('#txtSubTotalSoles').val('');
                $('#txtIgvSoles').val('');
                $('#txtTotalSoles').val('');
                if($('#txtStock').val()>0){
                    $('#ckSeparacion').prop('disabled', false);
                    $('#txtTiempo_Separacion').prop('disabled', false);
                }
                
            }else {
                if($('#ckSeparacion').prop('checked')){
                    toastem.error('No puede separar el producto, tiene componentes internos');
     
                }
                $(this).prop('checked', true);
                toastem.error('El producto tiene componentes, debes eliminarlos para seleccionar que no tiene componente. ');
            }
        }
    });
    $('#ckAdicional').click(function(){
        if($(this).prop('checked')){
            
        }else {
            var contador=0;
            $('#divAdicional .item-tr').each(function(){
                contador++;
            });
            if(contador>0){
               $(this).prop('checked', true);
                toastem.error('El producto tiene productos adicionales, debes eliminarlos para seleccionar que no tiene adicional. ');
        
            }
        }
    });
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
    window.parent.actualizar_dimensiones();
    toastem.success('<?php echo $GLOBALS['mensaje'];?>');
});
<?php if($GLOBALS['oCotizacion_Detalle']->tipo==1){ ?>
setTimeout('window_deslizar_save();', 1000);

<?php } ?>
 
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
