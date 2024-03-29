<?php		
	//require ROOT_PATH . "views/shared/content-float-modal.php";	
        require ROOT_PATH . "views/shared/content-view.php";	
?>	
<?php function fncTitle(){?>Editar Cotización<?php } ?>

<?php function fncHead(){?>
	
	<script type="text/javascript" src="include/js/jForm.js"></script>
       
        
        <script type="text/javascript" src="include/js/jPdf.js"></script>
	
        <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>
	
        <script type="text/javascript" src="include/js/jCronometro.js"></script>
        <link rel="stylesheet" type="text/css" href="include/css/cronometro.css" />
        
    <script type="text/javascript">
//        $('#btnBuscarOC').css('display','none');
        $(document).ready(function () {
           
             fncCargar_Detalle_Cotizacion();
          
          <?php if($GLOBALS['oCotizacion']->estado_ID==25){ ?>
            $("#btnEnviar").css("display","none");
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
            $("#selCliente").prop('disabled',true);
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
<form id="form" method="POST" action="/Salida/Cotizacion_Mantenimiento_Editar/<?php echo $GLOBALS['oCotizacion']->ID;?>" onsubmit="return validar();"  class="form-horizontal form-bordered" enctype="multipart/form-data">
    
    <div class="panel panel-tab rounded shadow">
         <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divCliente" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i> <span>Cliente</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divDatos_Generales" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Datos Generales</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divDatos_Economicos"><i class="fa fa-cc-visa" aria-hidden="true"></i><span>Datos económicos</span> </a></li>
                <li class="nav-item"><a href="#DivProductos" data-toggle="tab" onclick="fncCargar_Detalle_Cotizacion();"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Productos</span></a></li>
                <li class="nav-item"><a href="#DivObsequios" data-toggle="tab" onclick="fncCargar_Detalle_Obsequios();"><i class="fa fa-cubes"></i><span>Obsequios</span></a></li>
                <li class="nav-item"><a href="#anexo" data-toggle="tab" ><i class="fa fa-file-pdf-o"></i><span>Documento Anexo</span></a></li>
            </ul>
            <div class="pull-right" id="btns-grupo">
                
                <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" >
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    Guardar
                </button>
                <button  id="btnDescargar" name="btnDescargar" type="button" class="btn btn-danger" onclick=" pdf.descargar('Salida/Cotizacion_PDF/<?php echo $GLOBALS['oCotizacion']->ID;?>');" title="Descargar PDF" >
                    <span class="glyphicon glyphicon-cloud-download"></span>
                    PDF
                </button> 
                <button  id="btnCancelar" name="btnCancelar" class="btn btn-warning" type="button" onclick="parent.window_save_view();" >
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Salir
                </button>
             </div>
        </div>
        <div class="panel-body no-padding rounded-bottom">
            
            <div class="tab-content">
                <div id="divCliente" class="tab-pane fade in active inner-all">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group form-group-divider form-group-inline">
                                <div class="form-inner">
                                    <h4 class="no-margin">Cliente</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Cliente:<span class="asterisk">*</span> </label>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                   <select id="selCliente" name="selCliente" class="chosen-select">
                                       <option value="0">--Seleccionar--</option>
                                        <?php foreach($GLOBALS['dtCliente'] as $cliente){?>
                                       <option value="<?php echo $cliente['ID']?>"><?php echo $cliente['ruc'].' - '.($cliente['razon_social']);?></option>
                                        <?php }?>
                                   </select>
                                   <script type="text/javascript">
                                   $("#selCliente").val(<?php echo $GLOBALS['oCotizacion']->cliente_ID;?>);
                                   </script>
                                </div>
                            </div>
                           <div class="form-group">
                               <label class="control-label col-sm-3">Dirección: </label>
                               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                   <textarea id="txtDireccion" name="txtDireccion" disabled style="height: 60px;overflow:auto;resize:none;" class="form-control form-requerido" ><?php echo ($GLOBALS['oCliente']->direccion); ?></textarea>
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-sm-3">Teléfono: </label>

                               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                   <input id="txtTelefono" name="txtTelefono" type="text" class="text-int form-control" autocomplete=off disabled value="<?php echo $GLOBALS['oCliente']->telefono; ?>" />
                               </div>
                           </div>
                           <div class="form-group">
                               <label class="control-label col-sm-3">Contacto: </label>

                               <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                   <select id="selRepresentante" name="selRepresentante" class="form-control"> 
                                       <option value="0">--</option>
                                       <?php if($GLOBALS['oCotizacion']->ID!=null){ 
                                           foreach($GLOBALS['dtCliente_Contacto'] as $item){?>
                                       <option value="<?php echo $item['ID']?>"><?php echo $item['apellidos'].''.$item['nombres']; ?></option>
                                           <?php }?>
                                       <script type="text/javascript">
                                           $('#selRepresentante').val(<?php echo $GLOBALS['oCotizacion']->representante_cliente_ID; ?>);
                                      </script>
                                           <?php } ?>
                                   </select>
                               </div>
                           </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group form-group-divider form-group-inline">
                                <div class="form-inner">
                                    <h4 class="no-margin">Ejecutivo</h4>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Nombres: </label>

                                <div class="col-sm-9">
                                    <input id="txtOperador_ID" name="txtOperador_ID" style="display:none;"   value="<?php echo $GLOBALS['oOperador']->ID;?>" /> 
                                    <input type="text" id="txtNombres_Vendedor" name="txtNombres_Vendedor"  disabled value="<?php echo $GLOBALS['oOperador']->nombres . ' '.$GLOBALS['oOperador']->apellido_paterno; ?>" class="form-control"/> 

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Celular: </label>

                                <div class="col-sm-9">
                                    <input type="text" id="txtCelular1" name="txtCelular1"    disabled value="<?php echo $GLOBALS['oOperador']->celular; ?>" class="form-control"/> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Teléfono: </label>

                                <div class="col-sm-9">
                                    <input type="text"  id="txtTelefono_Vendedor" name="txtTelefono_Vendedor" disabled value="<?php echo $GLOBALS['oOperador']->telefono; ?>" class="form-control"/> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="divDatos_Generales" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Estado</label>
                        <div class="col-sm-3">
                            <select  id="selEstado" name="selEstado" class="form-control">
                                <?php foreach($GLOBALS['dtEstado'] as $estado){?>
                                <option value="<?php echo $estado['ID']?>"><?php echo $estado['nombre']?></option>
                                <?php }?>

                            </select>
                            <script>
                                $("#selEstado").val(<?php echo $GLOBALS['oCotizacion']->estado_ID;?>);
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="control-label col-sm-3">Fecha: <span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtFecha" name="txtFecha" class="date-range-picker-single form-control" value="<?php echo $GLOBALS['oCotizacion']->fecha; ?>" /> 
                        </div>
                        <label class="control-label col-sm-3">Número: </label>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtCotizacion_ID" name="txtCotizacion_ID" value="<?php echo $GLOBALS['oCotizacion']->ID; ?>"style="display:none;">
                            <input id="txtNumero" name="txtNumero" type="text" class="text-int form-control" disabled autocomplete=off  value="<?php echo $GLOBALS['oCotizacion']->numero_concatenado; ?>" /> 
                        </div>
                    </div>
                    
                    <div class="form-group">
                       
                        <label class="control-label col-sm-3">Garantía: </label>
                       
                        <div class="col-sm-3">
                            <input type="text" id="txtGarantia" name="txtGarantia" autocomplete="off" placeholder="1 año" value="<?php echo $GLOBALS['oCotizacion']->garantia; ?>" class="form-control" >
                        </div>
                        <label class="control-label col-sm-3">Tiempo avance: </label>
                       
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtTiempo_Avance" name="txtTiempo_Avance" disabled class="cronometro form-control" autocomplete=off  value="<?php echo $GLOBALS['oCotizacion']->tardanza; ?>" > 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Plazo de entrega: </label>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtPlazo_Entrega" name="txtPlazo_Entrega" placeholder="Días" class="int form-control" autocomplete="off"  value="<?php echo $GLOBALS['oCotizacion']->plazo_entrega; ?>"/>
                        </div>
                        <label class="control-label col-sm-3">Validez: </label>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtValidez_Oferta" placeholder="Días" autocomplete="off" name="txtValidez_Oferta" class="int form-control" value="<?php echo  $GLOBALS['oCotizacion']->validez_oferta; ?>" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Lugar de entrega: </label>
                       
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <textarea id="txtLugar_Entrega" name="txtLugar_Entrega" style="height: 40px;overflow:auto;resize:none;" class="form-control"><?php echo ($GLOBALS['oCotizacion']->lugar_entrega); ?></textarea>
                        </div>
                    </div>
                  
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Observación: </label>
                       
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <textarea id="txtObservacion" name="txtObservacion" class="comentario form-control" rows="1" cols="10" maxlength="150" style="height: 80px;overflow:auto;resize: none;"><?php echo $GLOBALS['oCotizacion']->observacion; ?></textarea>
                        </div>
                    </div>
                </div>
                <div id="divDatos_Economicos" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Moneda: </label>
                       
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="cboMoneda" name="cboMoneda" class="form-control" onchange="fncCargarNumeroCuenta(this.value);" >
                            <?php foreach($GLOBALS['dtMoneda'] as  $iMoneda){?>
                                <option value="<?php echo $iMoneda['ID']; ?>" > <?php echo $iMoneda['descripcion'];?> </option>
                            <?php }?>
                            </select>
                            <script type="text/javascript">
                                $('#cboMoneda').val('<?php echo $GLOBALS['oCotizacion']->moneda_ID;?>');
                            </script>
                        </div>
                        <label class="control-label col-sm-3">Tipo de cambio: </label>
                       
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio"  class="decimal form-control text-left" value="<?php echo $GLOBALS['oCotizacion']->tipo_cambio; ?>" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Forma de pago: </label>
                       
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selForma_Pago" name="selForma_Pago" class="form-control">
                                <?php foreach($GLOBALS['dtForma_Pago'] as $iForma_Pago){ ?>
                                <option value="<?php echo $iForma_Pago['ID']; ?>"> <?php echo $iForma_Pago['nombre'];?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                                   $('#selForma_Pago').val('<?php echo $GLOBALS['oCotizacion']->forma_pago_ID;?>')
                            </script> 
                        </div>
                        <label class="control-label col-sm-3">Tiempo de crédito: </label>
                        
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selTiempo_Credito" name="selTiempo_Credito" class="form-control">
                                <option value="0">--</option>
                                <?php foreach($GLOBALS['dtCredito'] as $idtCredito){ ?>
                                <option value="<?php echo $idtCredito['dias'];?>"><?php echo $idtCredito['texto'];?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                                $('#selTiempo_Credito').val('<?php echo $GLOBALS['oCotizacion']->tiempo_credito;?>')
                            </script>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-12 text-left">Nro. Cuentas: </label>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ContenedorCuadro">
                            <?php echo $GLOBALS['dtNumero_Cuenta'];?>
                        </div>
                    </div>
                    
                </div>
                
                <div class="tab-pane fade inner-all" id="DivProductos">
                    <div class="form-group">
                        <div class="col-sm-4">
                            <button  type="button" id="btnAgregar" name="btnDetalle" class='btn btn-success' onclick="fncRegistrar_Productos();" title="Agregar producto" >
                                <span class="glyphicon glyphicon-plus"></span>
                                Agregar
                            </button>
                        </div>
                         <div class="col-sm-4">
                            <div class="rdio rdio-teal">
                                <input id="rbCostoUnitario" type="radio" name="preciounitario" <?php echo ($GLOBALS['oCotizacion']->mostrar_precio_unitario==1?"":"checked");?> value="0">
                                <label for="rbCostoUnitario">Mostrar en la cotización precio unitario sin IGV. </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="rdio rdio-teal">
                                <input id="rbPrecioUnitario" type="radio" name="preciounitario" <?php echo ($GLOBALS['oCotizacion']->mostrar_precio_unitario==1?"checked":"");?> value="1">
                                <label for="rbPrecioUnitario">Mostrar en la cotización precio unitario incluido IGV</label>
                            </div>
                        </div>
                       
                    </div>
                    
                    <div class="divCuerpo" id="productos">
                        
                    </div>
                </div>
                <div class="tab-pane fade inner-all" id="DivObsequios">
                    <button  type="button" id="btnAgregarObsequio" name="btnAgregarObsequio" class='btn btn-info' onclick="fncRegistrar_Obsequios();" title="Agregar obsequio" >
                        <span class="glyphicon glyphicon-plus"></span>
                        Agregar
                    </button>
                    <div class="divCuerpo" id="obsequios">
                        
                    </div>
                </div>
                <div class="tab-pane fade inner-all" id="anexo">
                   <div class="form-group">
                        <label class="control-label col-sm-4">Documento anexo(.pdf)</label>
                        <div class="col-sm-8">
                            <input type="hidden" id="ruta" name="ruta" value="<?php echo(isset($GLOBALS['nombre_anexo'])?$GLOBALS['ruta_anexo']:""); ?>">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"><?php echo(isset($GLOBALS['nombre_anexo'])?$GLOBALS['nombre_anexo']:""); ?></span></div>
                                <span class="input-group-addon btn btn-success btn-file"><span class="fileinput-new">Seleccionar</span><span class="fileinput-exists">Cambiar</span><input type="file" id="file_anexo" name="file_anexo"></span>
                                <a href="#" class="input-group-addon btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                            </div>
                            
                            <button type="button" class="btn btn-danger" id="btnEliminarAnexo" name="btnEliminarAnexo" style="display: none" onclick="$('#ruta').val('');$('#frame_anexo').attr('src','');$('.fileinput .fileinput-filename').html('');">Eliminar</button>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="frame_anexo" class="embed-responsive-item" src="" style="width:100%; height: 600px;overflow:auto;"></iframe>
                            
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    
                </div>
            </div>
        </div>
    </div>
    <input id="txtOrden" name="txtOrden" type="text"  style="display:none;">
    <input id="chkOrdenASC" name="chkOrdenASC"   value="ASC" style="display:none;">
</form>
<script type="text/javascript">
     
    
    $(document).ready(function(){
        $("#frame_anexo").attr("src","");
        $("#frame_anexo").attr("src","<?php echo  $GLOBALS['ruta_anexo']?>");
        <?php if($GLOBALS['ruta_anexo']!=""){?>
            $("#btnEliminarAnexo").css("display","");
        <?php } ?>
        
       
    });
    $("#selCliente").change(function(){
        var id=this.value;
        if(id==0){
            limpiarPadre();
        }else{
            fncCargaValores(id);
        }
        
        
    });
    $("#file_anexo").change(function () {
        
            filePreview(this);
        });
     function filePreview(input) {
            var uploadFile = input.files[0];
            if(uploadFile){
                if (!window.FileReader) {
                    $('#file_anexo').val('');
                    toastem.error('El navegador no soporta la lectura de archivos', 'error');
                    return;
                }

                if (!(/\.(pdf)$/i).test(uploadFile.name)) {
                    $('#file_anexo').val('');
                    toastem.error('Solo se admiten archivos PDF', 'error');
                    return;
                }

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.readAsDataURL(input.files[0]);

                    reader.onload = function (e) {
                       // console.log(e.target.result);
                        $('#frame_anexo').prop("src", e.target.result);
                        //$('#uploadForm').after('<img src="' + e.target.result + '" width="450"       height= "300" />');
                    }
                }
            }else{
                $("#ruta").val('');
                $("#btnEliminarAnexo").css("display","");
            }
            
        }

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
    var fncRegistrar_Productos=function(){
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        parent.window_float_open_modal_hijo("AGREGAR NUEVO PRODUCTO","Salida/cotizacion_mantenimiento_producto_nuevo",cotizacion_ID,"",fncCargar_Detalle_Cotizacion,null,510);
       
    }
     var fncEditarProducto=function(id){
         parent.window_float_open_modal_hijo("EDITAR PRODUCTO","Salida/Cotizacion_Mantenimiento_Producto_Editar",id,"",fncCargar_Detalle_Cotizacion,null,510);
       
        
    }
    var fncEliminarProducto=function(id){
        cargarValores('/Salida/ajaxCotizacion_Detalle_Mantenimiento_Eliminar',id,function(resultado){
                
                if(resultado.resultado==1){
                    $('#detalle_ID').val('');
                    fncCargar_Detalle_Cotizacion();
                    
                    toastem.info(resultado.mensaje);
                    
                }else { 
                    toastem.error(resultado.mensaje);
                }
            });
    }
    var fncRegistrar_Obsequios=function(){
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        parent.window_float_open_modal_hijo("AGREGAR NUEVO OBSEQUIO","Salida/cotizacion_mantenimiento_obsequio_nuevo",cotizacion_ID,"",fncCargar_Detalle_Obsequios,700,530);
    }
    var fncEditarObsequio=function(id){
        parent.window_float_open_modal_hijo("EDITAR OBSEQUIO","Salida/Cotizacion_Mantenimiento_Obsequio_Editar",id,"",fncCargar_Detalle_Obsequios,700,530);

    }
    var fncEliminarObsequio=function(id){
        cargarValores('/Salida/ajaxCotizacion_Detalle_Mantenimiento_Eliminar',id,function(resultado){
            if(resultado.resultado==1){
                //$('#detalle_ID').val('');
                fncCargar_Detalle_Obsequios();

                toastem.info(resultado.mensaje);
            }else { 
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
            }
        }); 
    }
     
    
    
    var fncCargar_Detalle_Cotizacion=function(){
       
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        var tiempo=$('#txtTiempo_Avance').val();
        var orden=$('#txtOrden').val();
        var tipo=$('#chkOrdenASC').val();
        $('#divContenedor_Float_Hijo').css('display', 'block');
        cargarValores3("Salida/ajaxCotizacion_Detalle_Productos",cotizacion_ID,tiempo,orden,tipo,function(resultado){
            $('#productos').html(resultado.resultado);
            actualizar_dimensiones();
            //fncSeleccionarDetalle();
        });
    }
    var fncCargar_Detalle_Obsequios=function(){
        var cotizacion_ID=$('#txtCotizacion_ID').val();
        $('#divContenedor_Float_Hijo').css('display', 'block');
        cargarValores("Salida/ajaxCotizacion_Detalle_Obsequios",cotizacion_ID,function(resultado){
            $('#obsequios').html(resultado.resultado);
            //fncSeleccionarDetalle();
        });
    }
    var fncCargaValores=function(id){
        cargarValores('/Salida/ajaxCotizacion_Detalle_Cliente',id,function(resultado){
                      
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
    function limpiarPadre(){
        //alert(IDimagen);
        $('#txtDireccion').val('');
            $('#txtTelefono').val('');
            $('#selRepresentante').html('<option value="0">--</option>'); 
            $('#selForma_Pago').val('0');
            $('#txtNombres_Vendedor').val('');
            $('#txtTelefono_Vendedor').val('');
            $('#txtCelular1').val('');
            $("#txtLugar_Entrega").val('');
    }
    var validar=function(){
        //$('#txtSubTotalSoles').removeAttr('disabled');
        var cliente_ID=$('#selCliente').val();

        var Plazo_Entrega=$.trim($('#txtPlazo_Entrega').val());
        var Validez_Oferta=$('#txtValidez_Oferta').val();
        var Garantia=$.trim($('#txtGarantia').val());
        var SelForma_Pago = $.trim($('#selForma_Pago'));
        var estado_ID = $('#selEstado').val();
        if(cliente_ID==0){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione un cliente.','selCliente');
            $('.nav-tabs a[href="#divCliente"]').tab('show');
            return false;
        }	



        if(isNaN(Plazo_Entrega)||$.trim(Plazo_Entrega)==""){
           toastem.error("VALIDACIÓN DE DATOS",'Ingrese un plazo de entrega.','txtPlazo_Entrega');
             $('.nav-tabs a[href="#divDatos_Generales"]').tab('show');
            return false;
        }
        if(isNaN(Validez_Oferta)||$.trim(Validez_Oferta)==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese un tiempo de validez de la oferta.','txtValidez_Oferta');
           $('.nav-tabs a[href="#divDatos_Generales"]').tab('show');
            return false;
        }
         if(Garantia==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Ingrese un tiempo de garantía.','txtGarantia');
             $('.nav-tabs a[href="#divDatos_Generales"]').tab('show');
                return false;
        }
        if(SelForma_Pago=""){
            mensaje.error("VALIDACIÓN DE DATOS",'Ingrese una forma de pago.','selForma_Pago');
            $('.nav-tabs a[href="#divDatos_Economicos"]').tab('show');
            
        }
        var i=0;
        $('#tbnumero_cuenta input:checkbox:checked').each(function(){
            i++;
        });
        if(i==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Selecciones como mínimo un número de cuenta.');
             $('.nav-tabs a[href="#divDatos_Economicos"]').tab('show');
            return false;
        }
        var contador=0;
        $('#productos .item-tr').each(function(){
                 
            contador++;
        });
        
        if(contador==0 && estado_ID==2){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'No puede cambiar de estado, no tiene registrado ningún producto.');
            return false;
        }
        $('#txtTiempo_Avance').removeAttr("disabled");
        $('#txtNumero').removeAttr('disabled');
        //$('#fondo_espera').css('display','block');
         block_ui();
    }
    var actualizar_dimensiones=function(){
       
        var orden_venta_ID=$('#txtCotizacion_ID').val();
        console.log('deeddedde');
        cargarValores('Salida/ajaxActualzarDimension',orden_venta_ID,function(resultado){
            if(resultado.resultado==-1){
                mensaje.error('OCURRIÓ UN ERROR','Ocurrió un error en el dimensionamiento');
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