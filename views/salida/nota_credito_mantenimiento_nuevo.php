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
                        <span>Producto</span>
                    </a>
                </li>
                
            </ul>
        </div><!-- /.panel-heading -->
        <!--/ End tabs heading -->

        <!-- Start tabs content -->
        <div class="panel-body" style="height:270px;overflow:auto; ">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1-1">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">Serie:</label>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <input type="text" id="txtSerie" name="txtSerie" class="form-control">
                        </div>
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">Número:</label>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <input type="text" id="txtNumero" name="txtNumero" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">Factura:</label>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="input-group mb-15">
                                <input type="text" id="txtFactura" name="txtFactura" class="form-control no-border-right">
                                <a class="input-group-addon bg-primary glyphicon btn"><span class="glyphicon-search"></span></a>
                            </div>
                            
                        </div>
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">T.C.:</label>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">Tipo:</label>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <select id="selTipo" name="selTipo" class="form-control">
                                
                            </select>
                        </div>
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">Moneda:</label>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <select id="selMoneda" name="selMoneda" class="form-control">
                                
                            </select>
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
                        <label class="control-label col-md-2 col-sm-2 col-xs-2">Cliente:</label>
                        <div class="col-md-10 col-sm-10 col-xs-10">
                            <select id="selCliente" name="selCliente" class="form-control">
                                
                            </select>
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
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Valor unit.</th>
                                    <th>Cantidad</th>
                                    <th>Anticipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                
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
   
    parent.window_float_open_modal_hijo("AGREGAR DETALLE","Salida/nota_credito_detalle",'',"",cargar_informacion,700,600);
       
} 
var cargar_informacion=function(){

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