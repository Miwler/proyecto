<?php		
	require ROOT_PATH . "views/shared/content-float.php";	
?>	
<?php function fncTitle(){?>Editar Cotización<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jDate.js"></script>
	<script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jCboDiv.js"></script> 
        <script type="text/javascript" src="include/js/jscript.js"></script>
        <script type="text/javascript" src="include/js/jGrid-float.js"></script>
        <script type="text/javascript" src="include/js/jPdf.js"></script>
	<link rel="stylesheet" type="text/css" href="include/css/date.css" />
        <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>
	<link rel="stylesheet" type="text/css" href="include/css/cboDiv.css" />
	<link rel="stylesheet" type="text/css" href="include/css/grid-float.css" /> 
        
        <link rel="stylesheet" type="text/css" href="include/css/cronometro.css" />

    <script type="text/javascript">
//        $('#btnBuscarOC').css('display','none');
        $(document).ready(function () {
           
             fncCargar_Detalle_Cotizacion();
          
          <?php if($GLOBALS['oCotizacion']->estado_ID==25){ ?>
            $('#divCliente').html('');
            $('#cboMoneda').attr('disabled','disabled');
            $('#txtTipo_Cambio').attr('disabled','disabled');
            $('#txtPlazo_Entrega').attr('disabled','disabled');
            $('#selForma_Pago').attr('disabled','disabled');
            $('#selTiempo_Credito').attr('disabled','disabled');
            $('#txtFecha').attr('disabled','disabled');
            $('#selRepresentante').attr('disabled','disabled');
            $('#cknumero_cuenta1').attr('disabled','disabled');
            $('#cknumero_cuenta2').attr('disabled','disabled');
            $('#cknumero_cuenta3').attr('disabled','disabled');
            $('#cknumero_cuenta4').attr('disabled','disabled');
            $('#cknumero_cuenta5').attr('disabled','disabled');
            $('#cknumero_cuenta6').attr('disabled','disabled');
            $('#txtLugar_Entrega').attr('disabled','disabled');
            $('#txtValidez_Oferta').attr('disabled','disabled');
            $('#txtGarantia').attr('disabled','disabled');
            $('#txtObservacion').attr('disabled','disabled');
        
        
            <?php } else { ?>
                cronometro();
            <?php } ?>
         });

    </script>
<?php } ?>

<?php function fncTitleHead(){ ?>Editar Cotización<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>

<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==1||$GLOBALS['resultado']==2||$GLOBALS['resultado']==-1){ ?>
<form id="form" method="POST" action="/Cotizacion/Cotizacion_Mantenimiento_Editar/<?php echo $GLOBALS['oCotizacion']->ID;?>" onsubmit="return validar();" style="width:1100px;height:600px; ">
    <table style='width:1000px;height: 300px; margin:5px auto'>
        <tr>
            <th>Cliente</th>
            <td>
                <div id="divCliente" class="input-content" >                           
                </div>
                 <script type="text/javascript">
                     <?php if($GLOBALS['oCotizacion']->ID==null){ ?>
                    var cboCliente = newCbo('divCliente', 'txtCliente_ID', '/Cotizacion/ajaxCbo_Cliente', 370, true);
                     <?php } else { ?>
                    var cboCliente = cargarCbo('divCliente', 'txtCliente_ID', '/Cotizacion/ajaxCbo_Cliente', 370,<?php echo $GLOBALS['oCliente']->ID;?>,"<?php echo $GLOBALS['oCliente']->ruc .'-'. FormatTextViewHtml($GLOBALS['oCliente']->razon_social);?>", true);     
                     <?php } ?>
                 </script> 
            </td>
            <th>N&uacute;mero</th>
            <td>
                <input type="text" id="txtCotizacion_ID" name="txtCotizacion_ID" value="<?php echo $GLOBALS['oCotizacion']->ID; ?>"style="display:none;">
                <input id="txtNumero" name="txtNumero" type="text" class="text-int" style="width:100px;" disabled autocomplete=off  value="<?php echo $GLOBALS['oCotizacion']->numero_concatenado; ?>" /> 
            </td>
            <th>Tiempo</th>
            <td>
                <input id="txtTiempo_Avance" name="txtTiempo_Avance" disabled type="text" class="cronometro" autocomplete=off  value="<?php echo $GLOBALS['oCotizacion']->tardanza; ?>" >  
            </td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td>
                <textarea id="txtDireccion" name="txtDireccion" disabled style="width:370px;height: 40px;" ><?php echo FormatTextViewHtml(trim($GLOBALS['oCliente']->direccion)); ?></textarea>
            </td>
            <th>Moneda</th>
            <td>
                <select id="cboMoneda" name="cboMoneda" class="form-control" onchange="fncCargarNumeroCuenta(this.value);" >
                <?php foreach($GLOBALS['dtMoneda'] as  $iMoneda){?>
                    <option value="<?php echo $iMoneda['ID']; ?>" > <?php echo FormatTextViewHtml($iMoneda['descripcion']);?> </option>
                <?php }?>
                </select>
                <script type="text/javascript">
                     $('#cboMoneda').val('<?php echo $GLOBALS['oCotizacion']->moneda_ID;?>');

                </script> 
            </td>
            <th>Vendedor</th>
            <td>
               <input id="txtOperador_ID" name="txtOperador_ID" type="text" style="display:none;"   value="<?php echo $GLOBALS['oOperador']->ID;?>" /> 
                <input id="txtNombres_Vendedor" name="txtNombres_Vendedor" type="text"  style="width:200px;" disabled value="<?php echo $GLOBALS['oOperador']->nombres . ' '.$GLOBALS['oOperador']->apellido_paterno; ?>" /> 
                                        
            </td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>
                <input id="txtTelefono" name="txtTelefono" type="text" class="text-int" autocomplete=off disabled value="<?php echo $GLOBALS['oCliente']->telefono; ?>" />    
            </td>
            <th>Tipo cambio</th>
            <td>
                <input id="txtTipo_Cambio" name="txtTipo_Cambio" type="text" class="decimal" style="width:80px;" value="<?php echo $GLOBALS['oCotizacion']->tipo_cambio; ?>" />
            </td>
            <th>Celular</th>
            <td>
                <input id="txtCelular1" name="txtCelular1" type="text"  style="width:200px;" disabled value="<?php echo $GLOBALS['oOperador']->rpc; ?>" /> 
            </td>
        </tr>
        <tr>
            <th>Contacto</th>
            <td>
                <select id="selRepresentante" name="selRepresentante" class="form-control" style="width:250px;"> 
                    <option value="0">--</option>
                    <?php if($GLOBALS['oCotizacion']->ID!=null){ 
                        foreach($GLOBALS['dtRepresentanteCliente'] as $item){?>
                    <option value="<?php echo $item['ID']?>"><?php echo FormatTextView($item['apellidos'].''.$item['nombres']); ?></option>
                        <?php }?>
                    <script type="text/javascript">
                        $('#selRepresentante').val(<?php echo $GLOBALS['oCotizacion']->representante_cliente_ID; ?>);
                   </script>
                        <?php } ?>
                </select>
            </td>
            <th>Plazo entrega</th>
            <td>
                <input id="txtPlazo_Entrega" name="txtPlazo_Entrega" placeholder="Días" type="text" class="int" autocomplete="off" style="width:80px;" value="<?php echo $GLOBALS['oCotizacion']->plazo_entrega; ?>"/>
            </td>
            <th>Teléfono</th>
            <td>
                 <input id="txtTelefono_Vendedor" name="txtTelefono_Vendedor" type="text"  style="width:200px;" disabled value="<?php echo $GLOBALS['oOperador']->telefono; ?>" /> 
            </td>
        </tr>
        <tr>
            <th>Forma pago</th>
            <td>
                <select id="selForma_Pago" name="selForma_Pago">
                    <?php foreach($GLOBALS['dtForma_Pago'] as $iForma_Pago){ ?>
                    <option value="<?php echo $iForma_Pago['ID']; ?>"> <?php echo $iForma_Pago['nombre'];?></option>
                    <?php } ?>
                </select>
                <script type="text/javascript">

                       $('#selForma_Pago').val('<?php echo $GLOBALS['oCotizacion']->forma_pago_ID;?>')

                </script> 
            </td>
            <th>Tiempo Crédito</th>
            <td>
                <select id="selTiempo_Credito" name="selTiempo_Credito">
                    <option value="0">--</option>
                    <?php foreach($GLOBALS['dtCredito'] as $idtCredito){ ?>
                    <option value="<?php echo $idtCredito['dias'];?>"><?php echo $idtCredito['texto'];?></option>
                    <?php } ?>

                </select>
                <script type="text/javascript">

                       $('#selTiempo_Credito').val('<?php echo $GLOBALS['oCotizacion']->tiempo_credito;?>')

                </script> 
            </td>
            <th>Fecha</th>
            <td>
               <input id="txtFecha" name="txtFecha" type="text" class="date" value="<?php echo date("d/m/Y"); ?>" />   
            </td>
        </tr>
        <tr>
            <th>Lugar entrega</th>
            <td>
                <textarea id="txtLugar_Entrega" name="txtLugar_Entrega" style="width:370px;height: 40px;"><?php echo FormatTextViewHtml(trim($GLOBALS['oCotizacion']->lugar_entrega)); ?></textarea>
            </td>
            <th>Validez</th>
            <td> 
                <input type="text" id="txtValidez_Oferta" placeholder="Días" style="width:50px;" autocomplete="off" name="txtValidez_Oferta" class="int" value="<?php echo  FormatTextViewHtml($GLOBALS['oCotizacion']->validez_oferta); ?>" >
            </td>
            <th>Garantía</th>
            <td>
                <input type="text" id="txtGarantia" name="txtGarantia" autocomplete="off" placeholder="1 año" value="<?php echo FormatTextViewHtml($GLOBALS['oCotizacion']->garantia); ?>" >
            </td>
        </tr>
        <tr>
            <th colspan='2' style='text-align: center;'>Observación</th>
            <th colspan='2' style='text-align: center;'>Número de cuenta <label id="lbMoneda">Dólares (US$.)</label></th>
            <th>Estado</th>
            <td>
                <select id="selEstado" name="selEstado">
                    <?php foreach($GLOBALS['dtEstado'] as $value){?>
                    <option value="<?php echo $value['ID'];?>"><?php  echo FormatTextView($value['nombre']);?></option>
                    <?php } ?>
                </select>
                <script type="text/javascript">
                    $('#selEstado').val(<?php echo $GLOBALS['oCotizacion']->estado_ID;?>);
                </script>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <textarea id="txtObservacion" name="txtObservacion" class="comentario" rows="1" cols="10" maxlength="150" style="width:450px;height: 80px;"><?php echo FormatTextViewHtml($GLOBALS['oCotizacion']->observacion); ?></textarea>
                                            
            </td>
            <td colspan='4' class='ContenedorCuadro'>
                 <?php echo $GLOBALS['dtNumero_Cuenta'];?>
            </td>
        </tr>
        <tr>
            <td colspan='6'>
                <div class="btn_flotante" >                     
                    <div class="btn"> 
                       
                        <button  title="Editar productos" id="btnEditar" name="btnEditar" type="button"  style="display:none;" class="botones_formulario btn_detalle btnProductos" >
                       <?php if($GLOBALS['oCotizacion']->estado_ID!=25){ ?> <img   src="/include/img/boton/edit_48x48.png">Editar<?php } else {?><img   src="/include/img/boton/search_48x48.png"> Ver <?php } ?>
                        </button>
                        <button title="Eliminar productos" id="btnEliminar" name="btnEliminar" type="button"  style="display:none;" class="botones_formulario btn_detalle btnProductos" >
                           <img   src="/include/img/boton/delete_48x48.png"> Eliminar
                        </button>
                        <?php if($GLOBALS['oCotizacion']->estado_ID!=25){ ?>
                        <button  type="button" id="btnAgregar" name="btnDetalle" class='botones_formulario' onclick="fncRegistrar_Productos();" >
                            <img title="Agregar producto" alt="" src="/include/img/boton/addProducto48x48.png">
                            Agregar
                        </button>
                        <button  type="button" id="btnAgregarObsequio" name="btnAgregarObsequio" class='botones_formulario' onclick="fncRegistrar_Obsequios();" >
                            <img title="Agregar obsequio" alt="" src="/include/img/boton/regalo48x48.png">
                            Obsequio
                        </button>
                        <?php } ?>
                        
                        <button   id="btnEnviar" name="btnEnviar" class='botones_formulario' >
                            <img title="Guardar" alt="" src="/include/img/boton/save_48x48.png">
                            Guardar
                        </button>
                        
                        <button  id="btnDescargar" name="btnDescargar" type="button" class="botones_formulario" onclick=" pdf.descargar('Cotizacion/Cotizacion_PDF/<?php echo $GLOBALS['oCotizacion']->ID;?>');" >
                            <img title="Descargar" alt="" src="/include/img/boton/dpdf1_48x48.png">
                            PDF
                       </button> 
                      
                        <button  id="btnCancelar" name="btnCancelar" type="button" class='botones_formulario' onclick="window_float_save();" >
                            <img title="Salir" alt="" src="/include/img/boton/salir1_48x48.png">
                            Salir
                        </button>                                                          
                    </div> 
                </div> 
            </td>
        </tr>
    </table>
    <div id="divDetalle" class='divDetalle'>
        <div class='divDetalleCabecera'>
            <ul>
            <li><a  onclick="fncDetalleInfo('DivProductos','divCuerpo',this,'btnProductos',fncCargar_Detalle_Cotizacion,fncDesactivarBtnDetalle);" class='liActivo'>Productos</a></li>
            <li><a  onclick="fncDetalleInfo('DivObsequios','divCuerpo',this,'btnObsequios',fncCargar_Detalle_Obsequios, fncDesactivarBtnDetalle);" >Obsequios</a></li>
            </ul>
        </div>
        
        <div  class='divDetalleCuerpo' style="height:250px;overflow:overlay;">
            <div id="DivProductos" class='divCuerpo' ></div>
            <div id="DivObsequios" class='divCuerpo'  style="display:none" ></div>
        </div>
    </div>

    <input id="txtOrden" name="txtOrden" type="text"  style="display:none;">
    <input id="chkOrdenASC" name="chkOrdenASC"   value="ASC" style="display:none;">
</form>
<script type="text/javascript">
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
        fncCargar_Detalle_Cotizacion();

    }
    
    
      //Opción para editar los detalles
    $('#btnEditar').click(function(){
        var id=$('#detalle_ID').val();
        var src=$(this).attr('class');
        var i=src.search('btnProductos');
       
        if(i>-1){
            //Encontró clase boton de componente
           
            window_float_deslizar('form','Cotizacion/Cotizacion_Mantenimiento_Producto_Editar',id,'',actualizar_dimensiones);
       //     window_float_deslizar('form','Cotizacion/Cotizacion_Mantenimiento_Obsequio_Editar',id,'',fncCargar_Detalle_Obsequios);
 
        }else {
            //Encontró clase boton de adicional
           // window_float_deslizar('form','Cotizacion/Cotizacion_Mantenimiento_Producto_Editar',id,'',fncCargar_Detalle_Cotizacion);
           window_float_deslizar('form','Cotizacion/Cotizacion_Mantenimiento_Obsequio_Editar',id,'',fncCargar_Detalle_Obsequios);
        }
    });
   //==============funcion para elminar
    $('#btnEliminar').click(function(){
        var id=$('#detalle_ID').val();
        var src=$(this).attr('class');
         
        var i=src.search('btnProductos');
        
        if(i>-1){
            
            //Encontró clase boton de Producto
            cargarValores('/Cotizacion/ajaxCotizacion_Detalle_Mantenimiento_Eliminar',id,function(resultado){
                
                if(resultado.resultado==1){
                    $('#detalle_ID').val('');
                    fncCargar_Detalle_Cotizacion();
                    toastem.info(resultado.mensaje);
                }else { 
                    toastem.error(resultado.mensaje);
                }
            });
        }else {
            //Encontró clase boton de adicional
            cargarValores('/Cotizacion/ajaxCotizacion_Detalle_Mantenimiento_Eliminar',id,function(resultado){
                if(resultado.resultado==1){
                    $('#detalle_ID').val('');
                    fncCargar_Detalle_Obsequios();
                    toastem.info(resultado.mensaje);
                }else { 
                    toastem.error(resultado.mensaje);
                }
            });    
        }
    });
     
   
     
    var fncRegistrar_Productos=function(){
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        window_float_deslizar('form','/cotizacion/cotizacion_mantenimiento_producto_nuevo',cotizacion_ID,'',fncCargar_Detalle_Cotizacion);
    }
    var fncRegistrar_Obsequios=function(){
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        window_float_deslizar('form','/cotizacion/cotizacion_mantenimiento_obsequio_nuevo',cotizacion_ID,'',fncCargar_Detalle_Obsequios);
     
    }
    var fncCargar_Detalle_Cotizacion=function(){
       
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        var tiempo=$('#txtTiempo_Avance').val();
        var orden=$('#txtOrden').val();
        var tipo=$('#chkOrdenASC').val();
        $('#divContenedor_Float_Hijo').css('display', 'block');
        cargarValores3("Cotizacion/ajaxCotizacion_Detalle_Productos",cotizacion_ID,tiempo,orden,tipo,function(resultado){
            $('#DivProductos').html(resultado.resultado);
            fncSeleccionarDetalle();
        });
    }
    var fncCargar_Detalle_Obsequios=function(){
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        $('#divContenedor_Float_Hijo').css('display', 'block');
        cargarValores("Cotizacion/ajaxCotizacion_Detalle_Obsequios",cotizacion_ID,function(resultado){
            $('#DivObsequios').html(resultado.resultado);
            fncSeleccionarDetalle();
        });
    }
    var fncCargaValores=function(id){
        cargarValores('/Cotizacion/ajaxCotizacion_Detalle_Cliente',id,function(resultado){
                      
            $('#txtDireccion').val(resultado.Direccion);
            $('#txtLugar_Entrega').val(resultado.Direccion);
            $('#txtTelefono').val(resultado.Telefono);
            $('#selRepresentante').html(resultado.lista_representante); 
            $('#selForma_Pago').val(resultado.Forma_pago);
            $('#selTiempo_Credito').val(resultado.Tiempo_Credito);
            $('#txtOperador_ID').val(resultado.operador_ID);
            $('#txtNombres_Vendedor').val(resultado.operador);
            $('#txtTelefono_Vendedor').val(resultado.operador_telefono);
            $('#txtCelular1').val(resultado.operador_celular1);

        });

    }
    
    var fncCargarNumeroCuenta=function(moneda_ID){
        if(moneda_ID==1){
            $('#lbMoneda').html('Soles (S/.)');
           $('#tbnumero_cuenta .cssSoles').css('display','');
           $('#tbnumero_cuenta .cssDolares').css('display','none');

        }else {
            $('#lbMoneda').html('Dólares (US$.)');
            $('#tbnumero_cuenta .cssSoles').css('display','none');
            $('#tbnumero_cuenta .cssDolares').css('display','');
        }

    }
    function limpiarPadre(IDimagen){
        //alert(IDimagen);
        if(IDimagen=="#img_divCliente"){
                     
            $('#txtDireccion').val('');
            $('#txtTelefono').val('');
            $('#selRepresentante').html('<option value="0">--</option>'); 
            $('#selForma_Pago').val('0');
            $('#txtNombres_Vendedor').val('');
            $('#txtTelefono_Vendedor').val('');
            $('#txtCelular1').val('');
        }
    }
    var validar=function(){
        //$('#txtSubTotalSoles').removeAttr('disabled');
        var cliente_ID=$('#txtCliente_ID').val();

        var Plazo_Entrega=$.trim($('#txtPlazo_Entrega').val());
        var Validez_Oferta=$('#txtValidez_Oferta').val();
        var Garantia=$.trim($('#txtGarantia').val());

        if(cliente_ID==undefined){
           toastem.error('Seleccione un cliente.');
            $('#txtdivCliente').focus();
            return false;
        }	



        if(isNaN(Plazo_Entrega)||$.trim(Plazo_Entrega)==""){
           toastem.error('Ingrese un plazo de entrega.');
            $('#txtPlazo_Entrega').focus();
            return false;
        }
        if(isNaN(Validez_Oferta)||$.trim(Validez_Oferta)==""){
            toastem.error('Ingrese un tiempo de validez de la oferta.');
            $('#txtValidez_Oferta').focus();
            return false;
        }
         if(Garantia==""){
            toastem.error('Ingrese un tiempo de garantía.');
            $('#txtGarantia').focus();
                return false;
        }
        var i=0;
        $('#tbnumero_cuenta input:checkbox:checked').each(function(){
            i++;
        });
        if(i==0){
            toastem.error('Selecciones como mínimo un número de cuenta.');
            return false;
        }
        $('#txtTiempo_Avance').removeAttr("disabled");
        $('#txtNumero').removeAttr('disabled');
        //$('#fondo_espera').css('display','block');
    }
    var actualizar_dimensiones=function(){
       
        var orden_venta_ID=$('#txtCotizacion_ID').val();
        
        cargarValores('Cotizacion/ajaxActualzarDimension',orden_venta_ID,function(resultado){
            if(resultado.resultado==-1){
                toastem.error('Ocurrió un error en el dimensionamiento');
            }
            
        });
    }
</script>       
<?php }?>
            
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
    $(document).ready(function () {
    toastem.error('<?php echo $GLOBALS['mensaje']; ?>');
    });
</script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
<script type="text/javascript">
    $(document).ready(function () {
       toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
    });
//   ampliarVentanaVertical(750,'form');
//    fncCargar_Detalle_Cotizacion();
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