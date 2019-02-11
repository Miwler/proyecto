<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>GUIA DE VENTA<?php } ?>

<?php function fncHead(){?>
     <script type="text/javascript" src="include/js/jForm.js"></script>
    
   
    <script type='text/javascript'>
    $(document).ready(function(){
       <?php if($GLOBALS['oGuia_Venta']->opcion==1){?>
            $('#ckOpcion').prop('checked', true);
       <?php } else { ?>
           $('#ckOpcion').prop('checked', false);
       <?php } ?>
        <?php if($GLOBALS['oGuia_Venta']->estado_ID==38){?>  
           $('#btnAnular').css('display','');
            bloquear_guia();
        <?php }elseif($GLOBALS['oGuia_Venta']->estado_ID==39){?>  
            desbloquear_guia();
            $('#btnAnular').css('display','none');
            $('#btnVistaprevia').css('display','none');
            $('#btnImprimir').css('display','none');
        <?php } else { ?>
            $('#btnAnular').css('display','none'); 
        <?php } ?> 
        
    });
    </script>
<?php } ?>

<?php function fncTitleHead(){?>GUÍA DE VENTA<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['resultado']==1){ ?>
<form id="frm1"  method="post"  action="Salida/Orden_Venta_Mantenimiento_Guia/<?php echo $GLOBALS['oOrden_Venta']->ID;?>" onsubmit="return validar();" class="form-horizontal">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos_Generales" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i> <span>Datos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divProductos" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Detalle</span></a></li>
                <!--<li class="nav-item"><a data-toggle="tab" href="#divCosto" class="nav-link"><i class="fa fa-money" aria-hidden="true"></i> <span>Guías</span></a></li>-->
            </ul>
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height:370px;overflow:auto; ">
           
            <div class="tab-content">
                <div id="divDatos_Generales" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>N° Guía</label>
                            <input type="hidden" id="txtID" name="txtID" value="<?php echo  $GLOBALS['oGuia_Venta']->ID;?>">
                            <input type="hidden" id="txtorden_ventaID" name="txtorden_ventaID" value="<?php echo  $GLOBALS['oOrden_Venta']->ID;?>">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selSerie" name="selSerie"  disabled class="form-control" onchange="fncActualizarNumero();">
                                <?php foreach($GLOBALS['oGuia_Venta']->dtSerie as $value){ ?>
                                <option value="<?php echo $value['ID'];?>"><?php echo $value['serie'];?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                            $('#selSerie').val('<?php echo $GLOBALS['oGuia_Venta']->correlativos_ID;?>');
                            </script>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <input type="number" id="txtNumero" name="txtNumero" disabled class="form-control" autocomplete="off" value="<?php echo $GLOBALS['oGuia_Venta']->numero_concatenado;?>">
                        </div>
                        <div class="col-lg-3 col-md-1 col-sm-1 col-xs-1">
                            <button type="button" id="btnActualizar" style="vertical-align: bottom; border: none;" onclick="fncActualizarNumero();"><img src="/include/img/boton/refresh32x32.png" width="22px"/></button>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                            <div class="ckbox ckbox-theme">
                                <input type="checkbox" id="ckOpcion" name="ckOpcion" value="1">
                                <label for="ckOpcion"></label>
                            </div>
                           
                        </div>    
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Fecha</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtFecha_Emision" name="txtFecha_Emision" required class="date-range-picker-single form-control form-requerido" value="<?php echo $GLOBALS['oGuia_Venta']->fecha_emision;?>">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Fecha inicio traslado:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtFecha_Inicio_Traslado" name="txtFecha_Inicio_Traslado" required class="date-range-picker-single form-control form-requerido" value="<?php echo $GLOBALS['oGuia_Venta']->fecha_inicio_traslado;?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Punto de Partida:</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <input type="text" id="txtPunto_Partida" name="txtPunto_Partida" required class="form-control form-requerido" autocomplete="off" value="<?php echo $GLOBALS['oGuia_Venta']->punto_partida;?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Punto de llegada:</label>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <input type="text" id="txtPunto_Llegada" name="txtPunto_Llegada" class="form-control" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oGuia_Venta']->punto_llegada);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Vehículo:<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selVehiculo_ID" name="selVehiculo_ID" class="form-control">
                                <option value="0">Seleccione</option>
                                <?php foreach($GLOBALS['oGuia_Venta']->dtVehiculo as $item){ ?>
                                <option value="<?php echo $item["ID"]?>"><?php echo $item["placa"]?> - <?php echo FormatTextView($item["marca"])?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                               $('#selVehiculo_ID').val('<?php echo $GLOBALS['oGuia_Venta']->vehiculo_ID;?>'); 
                            </script>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Chofer:<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <select id="selChofer_ID" name="selChofer_ID" class="form-control">
                                <?php foreach($GLOBALS['oGuia_Venta']->dtChofer as $item1){ ?>
                                <option value="<?php echo $item1["ID"]?>"><?php echo FormatTextViewHtml($item1["nombres"]);?>, <?php echo FormatTextViewHtml($item1["apellido_paterno"]);?></option>
                                <?php } ?>
                            </select>
                            <script type="text/javascript">
                               $('#selChofer_ID').val('<?php echo $GLOBALS['oGuia_Venta']->chofer_ID;?>'); 
                            </script>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Empresa de transporte:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtEmpresa_Transporte" name="txtEmpresa_Transporte" autocomplete="off" class="form-control" value="<?php echo FormatTextViewHtml($GLOBALS['oGuia_Venta']->empresa_transporte);?>">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>Estado:</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtEstado" name="txtEstado" class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->estado;?>" disabled>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>N° Orden de compra</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtOrden_Compra" name="txtOrden_Compra" autocomplete="off" disabled class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->numero_orden_compra; ?>" >
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <label>N° orden de venta</label>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <input type="text" id="txtOrden_Pedido" name="txtOrden_Pedido" autocomplete="off" disabled class="form-control" value="<?php echo $GLOBALS['oGuia_Venta']->numero_orden_venta; ?>" >
                        </div>
                    </div>
                    
                </div>
                <div id="divProductos" class="tab-pane fade inner-all">
                    <!--
                    <div id="divProductos" name="divProductos" class="grid-content-hijo">
                        <?php echo $GLOBALS['listaproducto'];?>
                    </div>-->
                    <div class="form-group">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="tdguia_detalle">
                            <?php echo  $GLOBALS['facturas_informacion'];?>
                        </div>

                    </div>
                </div>
                <!--
                <div id="divCosto" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label></label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-2">
                            <label>Dólares</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-2">
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
                    <div class="tab-content">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>Total</label>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtTotal_Dolares" name="txtTotal_Dolares" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_total_dolares;?>">
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <input type="text" id="txtTotal_Soles" name="txtTotal_Soles" class="form-control" disabled value="<?php echo $GLOBALS['oOrden_Venta']->precio_venta_total_soles;?>">
                        </div>
                    </div>
                    

                </div> -->
            </div>
        </div>
        
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="tdfacturas_detalle">
                    <button  id="btnEnviar" name="btnEnviar" style="display: none" class="btn btn-success" title="Imprimir Guía">
                         <span class="glyphicon glyphicon-print"></span>
                      Imprimir
                   </button>
               <button  type="button" id="btnImprimir" name="btnImprimir" style="display: none" title="Imprimir guía" class="btn btn-success" onclick="modal.confirmacion('El proceso será irreversible, esta seguro de emitir la Guía?','Imprimir guía',fncImprimirGuia);">
                       <span class="glyphicon glyphicon-print"></span>
                      Imprimir
                   </button>
               
               
              
                <button type="button" id="btnVistaprevia" name="btnVistaprevia" style="display: none"  title="Vista previa" class="btn btn-info" onclick="fncVistaPrevia();">
                       <span class="glyphicon glyphicon-eye-open"></span>
                      Vista previa
                   </button>
                   <button id="btnAnular" type="button" title="Anular guía" style="display: none"  class="btn btn-danger" onclick="modal.confirmacion('El proceso será irreversible, esta seguro de anular la guía?','Anular Guía',fncAnularGuia);">
                       <span class="glyphicon glyphicon-ban-circle"></span>
                        Anular
                   </button> 

                    <button id="btnRegresar" type="button" title="Regresar" class="btn btn-danger" onclick="parent.float_close_modal_hijo();">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Regresar
                   </button>   
                   
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        <?php if($GLOBALS['oGuia_Venta']->estado_ID!=38){?>
            $("#btnEnviar").css("display","");    
        <?php } ?>
        <?php if($GLOBALS['oGuia_Venta']->estado_ID==38){?>
            $("#btnImprimir").css("display","");  
            $("#btnAnular").css("display",""); 
        <?php } ?>
        <?php  if($GLOBALS['oGuia_Venta']->ver_vista_previa==1){?>
            $("#btnVistaprevia").css("display",""); 
        <?php } ?>
    });
    var fncVistaPrevia=function(){
        var orden_venta_ID=<?php echo $GLOBALS['oOrden_Venta']->ID;?>;
        
        parent.window_float_open_modal_hijo_hijo("VISTA PREVIA DE GUÍA","/Salida/Orden_Venta_Mantenimiento_Guia_Vista_Previa",orden_venta_ID,"",null,700,600);
    }

    var fncActualizarNumero=function(){
       var serie=$("#selSerie").val();
        cargarValores('/salida/ajaxGuia_Venta_Numero_Ultimo',serie,function(resultado){
            if(resultado.resultado==1){
                $('#txtNumero').val(resultado.numero); 
            }else{
                mensaje.error("OCURRIÓ UN ERROR","Comuniquese con el área de sistemas");
            }
           

        });
    }
   var fncVerGuiaVenta=function(valor){
      window.parent.ocultarBotonGuia(valor);
   }

    var fncImprimirGuia=function(){
        //$('#fondo_espera').css('display','block');
        var orden_venta_ID=$('#txtorden_ventaID').val();
        try{
            
            block_ui(function(){
                var object=new Object();
                object['orden_venta_ID']=orden_venta_ID;
                enviarAjaxParse('/Salida/ajaxImprimir_Guia','frm1',object,function(resultado){
                    if(resultado.resultado==1){
                        $('#txtEstado').val('Emitido');
                        $("#btnVistaprevia").css("display",""); 
                        $("#btnAnular").css("display",""); 
                        $("#btnImprimir").css("display","");
                        $("#btnEnviar").css("display","none");
                        $('#tdguia_detalle').html(resultado.guia_detalle);
                        bloquear_guia();
                        $('#btnAnular').css('display','');
                        parent.fParent1.call(this,2);
                        $.unblockUI();
                        toastem.success(resultado.mensaje);

                    }else {
                         $.unblockUI();
                        mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
                            //modal.advertencia('ERROR DE IMPRESIÓN',resultado.mensaje);
                    }
                });
               
            });
        }catch(e){
            $.unblockUI();
            console.log(e);
        }
        
        
    }
    var fncAnularGuia=function(){
        var orden_venta_ID=$('#txtorden_ventaID').val();
         try{
             block_ui(function(){
                 cargarValores('Salida/ajaxAnular_Guia',orden_venta_ID,function(resultado){
                    if(resultado.resultado==1){
                        $.unblockUI();
                        toastem.success(resultado.mensaje);
                        desbloquear_guia();
                        fncActualizarNumero();
                        $('#tdguia_detalle').html(resultado.guia_detalle);
                        $('#btnAnular').css('display','none');
                        $("#btnVistaprevia").css("display","none");
                        $("#btnImprimir").css("display","none");
                        
                        
                        $('#btn_flotante_hijo').prepend('<button  id="btnEnviar" name="btnEnviar" class="botones_formulario" title="Generar Guía"> <img  alt="" src="/include/img/boton/generar_48x48.png">Generar</button>');
                        
                    }else {
                        $.unblockUI();
                        toastem.error(resultado.mensaje);
                    }
                });
             });
            
        }catch(e){
            $.unblockUI();
            console.log(e);
        }
    }
    var bloquear_guia=function(){
        $('#btnActualizar').css('display', 'none');
        $('#ckOpcion').css('display', 'none');
        $('#txtFecha_Emision').prop('disabled', true);
        $('#selChofer_ID').prop('disabled', true);
        $('#txtFecha_Inicio_Traslado').prop('disabled', true);
        $('#txtOrden_Compra').prop('disabled', true);
        $('#txtOrden_Pedido').prop('disabled', true);
        $('#selVehiculo_ID').prop('disabled', true);
        $("#selSerie").prop('disabled', true);
        $("#txtNumero").prop('disabled', true);
        $("#ckOpcion").prop("checked",false);
        $('#txtPunto_Partida').prop('disabled', true);
        $('#txtPunto_Llegada').prop('disabled', true);
        $('#txtEmpresa_Transporte').prop('disabled', true);
        $('#txtEstado').prop('disabled', true);
        $('#btnActualizar').css('display', 'none');
        $('#btnEnviar').prop('disabled', true);
        $('#btnEnviar').css('display', 'none');
       // $('#btnImprimir').css('display', 'none');
        
    }
     var desbloquear_guia=function(){
        $('#btnActualizar').css('display', '');
        $('#ckOpcion').css('display', '');
        $('#txtFecha_Emision').prop('disabled', false);
        $('#selChofer_ID').prop('disabled', false);
        $('#txtFecha_Inicio_Traslado').prop('disabled', false);
        $('#txtOrden_Compra').prop('disabled', false);
        $('#txtOrden_Pedido').prop('disabled', false);
        $('#selVehiculo_ID').prop('disabled', false);
        
        $('#txtPunto_Partida').prop('disabled', false);
        $('#txtPunto_Llegada').prop('disabled', false);
        $('#txtEmpresa_Transporte').prop('disabled', false);
        $('#txtEstado').prop('disabled', false);
        $('#btnActualizar').css('display', '');
        $('#btnEnviar').prop('disabled', false);
        $('#btnEnviar').css('display', '');
       // $('#btnImprimir').css('display', 'none');
        
    }
    var validar=function(){
      
       var fecha_emision=$('#txtFecha_Emision').val();
       var fecha_inicio_traslado=$('#txtFecha_Inicio_Traslado').val();
       var vehiculo_ID=$("#selVehiculo_ID").val();
       var chofer_ID=$("selChofer_ID").val();
       if(fecha_emision==""){
           mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione la fecha de emisión de la guía.','txtFecha_Emision');
           
           return false;
       }
        if(fecha_inicio_traslado==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione fecha de inicio de traslado.','txtFecha_Inicio_Traslado');
           
           return false;
       }
       if(vehiculo_ID=="0"){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione un vehículo.','selVehiculo_ID');
           
           return false;
       }
       if(chofer_ID=="0"){
            mensaje.advertencia("VALIDACIÓN DE DATOS",'Seleccione un chofer.','selChofer_ID');
           
           return false;
       }
       $('#selSerie').prop('disabled', false);
       
       $('#txtNumero ').prop('disabled', false);
       $("#txtOrden_Compra").prop('disabled', false);
       $("#txtOrden_Pedido").prop('disabled', false);
       block_ui();
       
   }
   /*
    var bloqueo_padre=function(){
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
    cargarValores('/Salida/ajaxQuitarGuia',ID,function(resultado){
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
    </script>
 
 <?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $.unblockUI();
            toastem.error('<?php echo $GLOBALS['mensaje'];?>');
        });
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

<script type="text/javascript">
 //alert('hola');
 $(document).ready(function () {
     $.unblockUI();
    toastem.success('<?php echo $GLOBALS['mensaje'];?>');
    fncImprimirGuia();
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
