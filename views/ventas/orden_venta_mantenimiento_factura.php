<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>FACTURA<?php } ?>

<?php function fncHead(){?>
    
    
    <script type="text/javascript" src="include/js/jForm.js"></script>
    
  

    <script type='text/javascript'>
    $(document).ready(function(){
       <?php if($GLOBALS['oFactura_Venta']->opcion==1){?>
            $('#ckOpcion').prop('checked', true);
       <?php } else { ?>
           $('#ckOpcion').prop('checked', false);
       <?php } ?>
        <?php if($GLOBALS['oFactura_Venta']->estado_ID==41){?>  
            bloquear_factura();
        <?php } ?>   

    });
    </script>
<?php } ?>

<?php function fncTitleHead(){?>FACTURA<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['resultado']==1){ ?>
<form id="frm1"  method="post"  action="Ventas/Orden_Venta_Mantenimiento_Factura/<?php echo $GLOBALS['oOrden_Venta']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos_Generales" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i> <span>Datos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divProductos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Productos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divCosto" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i> <span>Costos</span></a></li>
            </ul>
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height:400px;overflow:auto; ">
            
            <div class="tab-content">
                <div id="divDatos_Generales" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Número de Factura</label>
                            <input type="hidden" id="txtID" name="txtID" value="<?php echo  $GLOBALS['oFactura_Venta']->ID;?>">
                            <input type="hidden" id="txtorden_ventaID" name="txtorden_ventaID" value="<?php echo  $GLOBALS['oOrden_Venta']->ID;?>">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selSerie" name="selSerie" class="form-control" disabled >
                                <?php foreach($GLOBALS['oFactura_Venta']->dtSerie as $value){ ?>
                                <option value="<?php echo $value['nombre'];?>"><?php echo $value['nombre'];?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                             $('#selSerie').val('<?php echo $GLOBALS['oFactura_Venta']->serie;?>');
                             </script>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input type="text" id="txtNumero" name="txtNumero" class="form-control" value="<?php echo  $GLOBALS['oFactura_Venta']->numero_concatenado;?>" disabled onchange="fncNumero();">
                            
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                            <?php if($GLOBALS['oFactura_Venta']->estado_ID!=41){?>
                            <button type="button" id="btnActualizar" style="vertical-align: bottom; border: none;" onclick="fncActualizarNumero();"><img src="/include/img/boton/refresh32x32.png" width="22px"/></button>
                           
                            
                            <?php } ?>
                            
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                             <?php if($GLOBALS['oFactura_Venta']->estado_ID!=41){?>
                             <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckOpcion" name="ckOpcion" value="1">
                                <label for="ckOpcion"></label>
                            </div>
                             <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Fecha emisión</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <input type="text" id="txtFecha_Emision" name="txtFecha_Emision" required class="date-range-picker-single form-control" value="<?php echo $GLOBALS['oFactura_Venta']->fecha_emision;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Plazo de facturación</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <input type="text" id="txtPlazo_Factura" name="txtPlazo_Factura" required autocomplete="off" class="form-control int" style="width:50px;" onkeyup="fncVerFecha(this.value,$('#txtFecha_Emision').val());" value="<?php echo $GLOBALS['oFactura_Venta']->plazo_factura;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Fecha vencimiento:</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <input type="text" id="txtFecha_Vencimiento" name="txtFecha_Vencimiento" required class="form-control date-range-picker-single" value="<?php echo $GLOBALS['oFactura_Venta']->fecha_vencimiento;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>N° Orden de compra</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtOrden_Compra" name="txtOrden_Compra" autocomplete="off" class="form-control" value="<?php echo $GLOBALS['oFactura_Venta']->orden_compra; ?>" >
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>N° orden de pedido</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtOrden_Pedido" name="txtOrden_Pedido" autocomplete="off" class="form-control" value="<?php echo $GLOBALS['oFactura_Venta']->orden_pedido; ?>" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Moneda</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <select id="selMoneda" name="selMoneda" disabled class="form-control" >
                                <option value="1">Soles</option>
                                <option value="2">Dolares</option>
                            </select>
                            <script type="text/javascript">
                                $('#selMoneda').val(<?php echo $GLOBALS['oFactura_Venta']->moneda_ID; ?>);
                            </script>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Estado</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <input type="text" id="txtEstado" name="txtEstado" class="form-control" value="<?php echo $GLOBALS['oFactura_Venta']->estado;?>" disabled>
                        </div>
                    </div>
                </div>
                <div id="divProductos" class="tab-pane fade inner-all">
                    <div id="divProductos" name="divProductos" class="grid-content-hijo">
                        <?php echo $GLOBALS['listaproducto'];?>
                    </div>
                </div>
                <div id="divCosto" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label></label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <label>Dólares</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <label>Soles</label>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>Sub Total:</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                             <input type="text" id="txtSubTotal_Dolares" name="txtSubTotal_Dolares" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_neto_dolares;?>">
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtSubTotal_Soles" name="txtSubTotal_Soles" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_neto_soles;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>I.G.V.<?php echo $GLOBALS['oOrden_Venta']->igv*100?> %:</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtIgv_Dolares" name="txtIgv_Dolares" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->vigv_dolares;?>">
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                             <input type="text" id="txtIgv_Soles" name="txtIgv_Soles" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->vigv_soles;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>I.G.V.<?php echo $GLOBALS['oOrden_Venta']->igv*100?> %:</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtTotal_Dolares" name="txtTotal_Dolares" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_total_dolares;?>">
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtTotal_Soles" name="txtTotal_Soles" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_total_soles;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="tdfacturas_detalle">
                            <?php echo  $GLOBALS['facturas_informacion'];?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="tdfacturas_detalle">
                    <?php if($GLOBALS['oFactura_Venta']->estado_ID!=41){?>
                    <button  id="btnEnviar" name="btnEnviar" title="Generar factura" class="btn btn-success">
                       <span class="glyphicon glyphicon-ok"></span>
                      Generar
                   </button>
               <?php } ?>
               <?php  if($GLOBALS['oFactura_Venta']->ver_vista_previa==1){?>
                   <button type="button" id="btnVistaprevia" name="btnVistaprevia"  title="Vista previa" class="btn btn-info" onclick="fncVistaPrevia();">
                       <span class="glyphicon glyphicon-eye-open"></span>
                      Vista previa
                   </button>
               <?php } ?>
               <?php  if($GLOBALS['oFactura_Venta']->ver_imprimir==1){?>
                   <button  type="button" id="btnImprimir" name="btnImprimir" title="Vista previa" class="btn btn-warning" onclick="modal.confirmacion('El proceso será irreversible, esta seguro de emitir la factura?','Imprimir factura',fncImprimirFactura);">
                       <span class="glyphicon glyphicon-print"></span>
                      Imprimir
                   </button>
               <?php } ?>
                    <button id="btnRegresar" type="button" onclick="parent.float_close_modal_hijo();" class="btn btn-danger">
                           <span class="glyphicon glyphicon-arrow-left"></span>
                           Regresar
                   </button>       
                </div>
            </div>
        </div>
    </div>
</form>
 <script type="text/javascript">
    var fncVistaPrevia=function(){
        var orden_venta_ID=$('#txtorden_ventaID').val();
        //window_float_deslizar_hijo('form','Ventas/Orden_Venta_Mantenimiento_Factura_Vista_Previa',orden_venta_ID,'');
        parent.window_float_open_modal_hijo_hijo("VISTA PREVIA DE FACTURA","/Ventas/Orden_Venta_Mantenimiento_Factura_Vista_Previa",orden_venta_ID,"",null,700,600);
        
    }
    function fncNumero(){
        var numero=$('#txtNumero').val();
        var nNumero=('0000000'+numero);

        $('#txtNumero').val(nNumero.substring(nNumero.length-9,nNumero.length));
    }
    $('#txtNumero').focus(function(){
        $('#txtNumero').val('');
    });
    /*
   var fncVerGuiaVenta=function(valor){
      window.parent.ocultarBotonGuia(valor);
   }*/
    var fncActualizarNumero=function(){
       var serie=$('#selSerie').val();
        cargarValores('/Ventas/ajaxFactura_Venta_Numero_Ultimo',serie,function(resultado){
            if(resultado.resultado==1){
                $('#txtNumero').val(resultado.numero); 
            }else{
                mensaje.error("OCURRIÓ UN ERROR","Ocurrió un error, comuniquese con el área de sistemas.");
            }
            

        });
    }
   
    var fncImprimirFactura=function(){
        $('#fondo_espera').css('display','block');
        var orden_venta_ID=$('#txtorden_ventaID').val();
        
        cargarValores('ventas/ajaxImprimir_Factura',orden_venta_ID,function(resultado){
            
            if(resultado.resultado==1){
                $('#txtEstado').val('Emitido');
                $('#tdfacturas_detalle').html(resultado.facturas_detalle);
                bloquear_factura();
                /*window.parent.bloquear_edicion();
                window.parent.crear_boton_QuitarPrint();*/
                parent.fParent1.call(this,2);
               //parent.fParent1.call(2);
                //window.parent.crear_boton_guia();
                toastem.success(resultado.mensaje);
                
            }else {
                mensaje.advertencia("ERROR DE IMPRESION",resultado.mensaje);
                //toastem.error(resultado.mensaje);
            }
            $('#fondo_espera').css('display','none');
        });
        
    }
    var bloquear_factura=function(){
        $('#btnActualizar').css('display', 'none');
        $('#ckOpcion').css('display', 'none');
        $('#txtFecha_Emision').prop('disabled', true);
        $('#txtPlazo_Factura').prop('disabled', true);
        $('#txtFecha_Vencimiento').prop('disabled', true);
        $('#txtOrden_Compra').prop('disabled', true);
        $('#txtOrden_Pedido').prop('disabled', true);
        $('#selMoneda').prop('disabled', true);
        $('#txtEstado').prop('disabled', true);
        $('#btnActualizar').css('display', 'none');
        $('#btnEnviar').prop('disabled', true);
        $('#btnEnviar').css('display', 'none');
       // $('#btnImprimir').css('display', 'none');
        
    }
    var validar=function(){
      
       var fecha_emision=$('#txtFecha_Emision').val();
       var fecha_vencimiento=$('#txtFecha_Vencimiento').val();
       if(fecha_emision=="__/__/____"){
           toastem.error('Seleccione la fecha de emisión.');
           $('#txtFecha_Emision').focus();
           return false;
       }
        if(fecha_vencimiento=="__/__/____"){
           toastem.error('Seleccione fecha de vencimiento.');
           $('#txtFecha_Vencimiento').focus();
           return false;
       }
        $('#selSerie').prop('disabled',false);
        
        var serie=$.trim($('#selSerie').val());
       
        if(serie==''){
            toastem.error('Seleccione una serie.');
           $('#selSerie').focus();
           return false;
        }
        $('#txtNumero').prop('disabled',false);
         var numero=$.trim($('#txtNumero').val());
         if(numero==''){
            toastem.error('Ingrese un número de factura.');
            $('#txtNumero').focus();
            return false;
         }
         $('#selMoneda').prop('disabled',false);
         $('#fondo_espera').css('display', 'block');
   }
    /*var bloqueo_padre=function(){
       window.parent.bloqueo_orden_venta();
    }
    var fncCargarVistaFactura=function(){
        $('#btnImprimirFactura').css('display','none');
        window.parent.fncCargarVistaFactura();
    }
    var fncCargarVistaGuia=function(){

         window.parent.fncCargarVistaGuia();
    }*/
    var ocultarBotones=function(){
        $('#btnImprimirFactura').attr('disabled');
        $('#btnImprimirFactura').css('display','none');
        $('#btnEnviar').attr('disabled');
        $('#btnEnviar').css('display','none');
        $('#Imprimir').css('display','none');
    }
    var fncVerFecha=function(d,fecha){
         var fechaFinal="__/__/____";
        if(d.trim().length>0){
              var Fecha = new Date();
              var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
              var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
              var aFecha = sFecha.split(sep);
              var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
              fecha= new Date(fecha);
              fecha.setDate(fecha.getDate()+parseInt(d));
              var anno=fecha.getFullYear();
              var mes= fecha.getMonth()+1;
              var dia= fecha.getDate();
              mes = (mes < 10) ? ("0" + mes) : mes;
              dia = (dia < 10) ? ("0" + dia) : dia;
              fechaFinal = dia+sep+mes+sep+anno;
        }

         $('#txtFecha_Vencimiento').val(fechaFinal);
    }
    var fncQuitarGuia=function(){
      var ID=<?php echo $GLOBALS['oOrden_Venta']->ID;?>;
      cargarValores('/Ventas/ajaxQuitarGuia',ID,function(resultado){
          $('.float-mensaje').html(resultado.mensaje);
           if(resultado.resultado==1){
               $('#selGuia_Venta').val('0');
           }
       });
    }
    $('#ckOpcion').click(function(){
      if($(this).prop('checked')){
         
          $('#selSerie').prop('disabled', false);
          $('#txtNumero').prop('disabled', false);
      }else {
          $('#selSerie').prop('disabled', true);
          $('#txtNumero').prop('disabled', true);
          $('#txtNumero').focus();
      }
  });
    $('#selSerie').change(function(){
        mostrar_estructura();
    });
    var mostrar_estructura=function(){
        var orden_venta_ID=$('#txtorden_ventaID').val();
        var serie=$('#selSerie').val();

        cargarValores1('Ventas/ajaxExtraer_Estructura_Facturas',orden_venta_ID,serie,function(resultado){

            $('#tdfacturas_detalle').html(resultado.html);
        });
    }
</script>
 
 <?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
         $(document).ready(function () {

            toastem.error('<?php echo $GLOBALS['mensaje'];?>');
        });
           // alert('-1');
      
       // setTimeout('window_float_save();', 1000);
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

<script type="text/javascript">
 //alert('hola');
 $(document).ready(function () {
     parent.fParent1.call(this,1);
    //window.parent.crear_boton_guia();
    toastem.success('<?php echo $GLOBALS['mensaje'];?>');
    
});

//setTimeout('window_deslizar_save();', 1000);

 
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
