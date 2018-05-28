<?php		
	require ROOT_PATH . "views/shared/content-float-modal.php";	
?>	
<?php function fncTitle(){?>Registrar Cotización<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jPdf.js"></script>
	
        <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>

<?php } ?>

<?php function fncTitleHead(){ ?>Registrar Cotización<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==1||$GLOBALS['resultado']==-1){ ?>
<form id="form" method="POST" action="/Salida/Cotizacion_Mantenimiento_Nuevo" onsubmit="return validar();"  class="form-horizontal" >
    <!-- Start default tabs -->
    <div class="panel panel-tab rounded shadow">
        <!-- Start tabs heading -->
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab1-1" data-toggle="tab">
                        <i class="fa fa-user"></i>
                        <span>Documento</span>
                    </a>
                </li>
                <li>
                    <a href="#tab1-2" data-toggle="tab">
                        <i class="fa fa-file-text"></i>
                        <span>Detalle</span>
                    </a>
                </li>
                
            </ul>
        </div><!-- /.panel-heading -->
        <!--/ End tabs heading -->

        <!-- Start tabs content -->
        <div class="panel-body" style="height:280px;overflow:auto; ">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1-1">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Serie:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="text" id="txtSerie" name="txtSerie" autocomplete="off" disabled value="F001" class="form-control">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Número:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="text" id="txtNumero" name="txtNumero" autocomplete="off" value="<?php echo $GLOBALS['numero'];?>" disabled class="int form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Factura:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="input-group mb-15">
                                        <input type="text" id="txtFactura" name="txtFactura" class="form-control no-border-right">
                                        <a class="input-group-addon bg-primary glyphicon btn" onclick="fncBuscarFacturas();"><span class="glyphicon-search"></span></a>
                                    </div>

                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">T.C.:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio" autocomplete="off" value="<?php echo $GLOBALS['tipo_cambio'];?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">F. Emisión:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="text" class="date-range-picker-single form-control">
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">F. Vence:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <input type="text" class="date-range-picker-single form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Tipo:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <select id="selTipo" name="selTipo" class="form-control">
                                        <?php foreach($GLOBALS['dtTipo'] as $valor){ ?>
                                        <option value="<?php echo $valor['ID'];?>"><?php  echo FormatTextView($valor['nombre']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Moneda:</label>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <select id="selMoneda" name="selMoneda" class="form-control">

                                        <?php foreach($GLOBALS['dtMoneda'] as $valor1){ ?>
                                        <option value="<?php echo $valor1['ID'];?>"><?php  echo FormatTextView($valor1['descripcion']); ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-2">Cliente:</label>
                                <div class="col-md-10 col-sm-10 col-xs-10">
                                    <input type="hidden" id="txtCliente_ID" name="txtCliente_ID">
                                    <input type="text" class="form-control" id="listaCliente" name="listaCliente">
                                    <script>
                                        $(document).ready(function(){
                                            lista('/funcion/ajaxListarClientes','listaCliente','txtCliente_ID');
                                        });
                                    </script>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="control-label col-sm-5">% Descuento:</label>
                                <div class="col-sm-7">
                                    <input type="text"  id="txtPorcentaje" name="txtPorcentaje" autocomplete="off" class="form-control decimal">
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="control-label col-sm-5">SubTotal:</label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtSubTotal" name="txtSubTotal" autocomplete="off" class="form-control decimal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5">IGV:</label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtIGV" name="txtIGV" autocomplete="off" class="form-control decimal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5">Descuento Total:</label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtDescuentoTotal" name="txtDescuentoTotal" autocomplete="off"  class="form-control decimal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-5">Total:</label>
                                <div class="col-sm-7">
                                    <input type="text" id="txtTotal" name="txtTotal" autocomplete="off" class="form-control decimal">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="tab-pane fade" id="tab1-2">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                            <button type="button" onclick="fncAgregar_Detalle();" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span>Detalle</button>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio unit.</th>
                                    <th>SubTotal</th>
                                    <th>Total</th>
                                    <th>Opción</th>
                                </tr>
                                
                            </thead>
                            <tbody id="cuerpo">
                                
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                
            </div>
        </div><!-- /.panel-body -->
        <div class="panel-footer">
            <div class="pull-left">
                <button type="button" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-danger">Cancelar</button>
                
            </div>
            <div class="clearfix"></div>
        </div>
        <!--/ End tabs content -->
    </div><!-- /.panel -->
    <!--/ End default tabs -->
</form>
<script type="text/javascript">
    
    var fncAgregar_Detalle=function(){

        parent.window_float_open_modal_hijo("AGREGAR DETALLE","Salida/nota_credito_detalle",'',"",cargar_tabla,700,330);

    } 
    var myarray=[];
    var i=0;
    var cargar_tabla=function(obj){
        var val=i+1;
        var fila='<tr id="tr'+i+'"><td class="text-center">'+val+'</td><td>'+obj.producto+'</td><td class="text-center">'+obj.cantidad+'</td><td>'+obj.precio_unitario+'</td><td>'+obj.subtotal+'</td><td>'+obj.total+'</td><td class="text-center"><a class="btn btn-danger" title="Eliminar" onclick="fncEliminar('+i+');"><i class="fa fa-trash"></i></a></td></tr>';
        $("#cuerpo").append(fila);
        myarray[i]=obj;
        //myarray.push(obj);
        i++;
        //alert(obj.ID);
    }
    var fncEliminar=function(i){
        $('#tr'+i).remove();
        myarray.splice(i,1);
    }
    var fncBuscarFacturas=function(){
        parent.window_float_open_modal_hijo("FACTURAS EMITIDAS","Salida/factura_venta_emitidas",'',"",cargarInformacion,700,330);

    }
    var cargarInformacion=function(factura_venta_ID){
        cargarValores('Salida/ajaxExtraerInformacionFacturas_Emitidas',factura_venta_ID,function(resultado){
            $("#txtFactura").val(resultado.numero);
            $("#selMoneda").val(resultado.moneda_ID);
            
            $("#txtCliente_ID").val(resultado.cliente_ID);
            $("#listaCliente").val(resultado.cliente);
            $("#cuerpo").append(resultado.tabla);
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
   //ampliarVentanaVertical(750,'form');
    //fncCargar_Detalle_Cotizacion();
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