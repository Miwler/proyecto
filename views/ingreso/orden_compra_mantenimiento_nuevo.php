<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Nueva orden de compra<?php } ?>

<?php

function fncHead() { ?>
    
    <link rel="stylesheet" type="text/css" href="include/css/grid-float.css" />  

    
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jGrid-float.js"></script>
    <script type="text/javascript" src="include/js/jPdf.js"></script>
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>
    <script type="text/javascript" src="include/js/jPdf.js"></script>
<?php } ?>

<?php

function fncTitleHead() { ?>
    <img src="/include/img/generar_compras.png"/>
    Nueva orden de compra
        <?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1||$GLOBALS['resultado'] == 1) { ?>
    <style>
        #divContenedor_Float_Hijo .table td{
            font-size:12px;
        }
    </style>
<form id="form" method="POST" action="/Ingreso/Orden_Compra_Mantenimiento_Nuevo" onsubmit="return validar();">
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos" class="nav-link"><i class="fa fa-file-text-o" aria-hidden="true"></i><span> Datos</span></a></li>
                <li id="li_producto" class="nav-item" style="display:none"><a data-toggle="tab" href="#divContenedorProdutos" class="nav-link"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i><span> Productos</span></a></li>
            </ul>
            <div class="pull-right">
                <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
               <button  type="button" id="btnAgregar" name="btnEnviar" title="Agregar productos" class='btn btn-info' onclick="fncRegistrar_Productos();" >
                   <img  alt="" width="16" src="/include/img/boton/addProducto48x48.png">
                   Agregar
               </button>
                 <?php } ?>
                <button  id="btnEnviar" name="btnEnviar" class='btn btn-success' title="Guardar" >
                    <img alt="" width="16" src="/include/img/boton/save_48x48.png">
                    Guardar
                </button>
                <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
                <button  id="btnPDF" name="btnPDF" type="button" title="Descargar en PDF" class="btn btn-info" onclick=" pdf.descargar('Ingreso/Orden_Compra_pdf/<?php echo $GLOBALS['oOrden_Compra']->ID;?>');" >
                    <span class="glyphicon glyphicon-cloud-download"></span>
                    PDF
                </button> 
                <?php } ?>

                <button  id="btnCancelar" name="btnCancelar" type="button" class='btn btn-danger' title="Salir" onclick="salir();" >
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Salir
                </button>
              
           </div>
        </div>
        <div class="panel-body no-padding rounded-bottom">
            <div class="tab-content form-horizontal">
                <div id="divDatos" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 control-label">Fecha:<span class="asterisk">*</span></label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input id="txtFecha" name="txtFecha" type="text" class="form-control date-range-picker-single" value="<?php if(isset($GLOBALS['oOrden_Compra']->fecha)){ echo $GLOBALS['oOrden_Compra']->fecha;} else{ echo date("d/m/Y");} ?>" />
                        </div>
                        <label class="col-lg-3 col-md-3 col-sm-3  control-label">Nro de orden:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                             <input id="txtOrden_Compra_ID" name="txtOrden_Compra_ID" value="<?php echo $GLOBALS['oOrden_Compra']->ID;?>" style="display:none;"/>
                             <input id="txtNumero_Orden" name="txtNumero_Orden" disabled class="int form-control" type="text"  value="<?php echo sprintf("%'.07d",$GLOBALS['oOrden_Compra']->numero_orden); ?>" />
                        </div>
                        
                    </div>
                    
                    <div class="row form-group" >
                        <label  class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Proveedor:<span class="asterisk">*</span></label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <select id="selProveedor" name="selProveedor" class="chosen-select">
                               <option value="0">--Seleccionar--</option>
                                <?php foreach($GLOBALS['oOrden_Compra']->dtProveedor as $proveedor){?>
                               <option value="<?php echo $proveedor['ID']?>"><?php echo FormatTextView(strtoupper($proveedor['razon_social']));?></option>
                                <?php }?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 control-label">Moneda:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selMoneda" name="selMoneda" class="form-control" >
                                <?php foreach($GLOBALS['oOrden_Compra']->dtMoneda as  $iMoneda){?>
                                <option value="<?php echo $iMoneda['ID']; ?>" > <?php echo utf8_encode($iMoneda['descripcion']);?> </option>
                                <?php }?>
                            </select>
                            <script type="text/javascript">
                                $('#selMoneda').val('<?php echo $GLOBALS['oOrden_Compra']->moneda_ID;?>');
                            </script>
                        </div>
                        <label class="col-lg-3 col-md-3 col-sm-3 control-label">Tipo de cambio:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input id="txtTipo_Cambio" name="txtTipo_Cambio" type="text" class="form-control decimal" autocomplete="off"  value="<?php echo $GLOBALS['oOrden_Compra']->tipo_cambio;?>" />
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">I.G.V.%:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <input type="text" id="txtVigv" name="txtVigv" disabled class="form-control" value="<?php echo ($GLOBALS['oOrden_Compra']->vigv); ?>"> 
                        </div>
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Estado:</label>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <select id="selEstado" name="selEstado" class="form-control">
                                <?php foreach($GLOBALS['oOrden_Compra']->dtEstado as $iEstado){ ?>
                                     <option value="<?php echo $iEstado['ID']; ?>"><?php echo FormatTextView($iEstado['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Comentario:</label>
                        <div id="tdComentario" class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                            <textarea id="txtComentario" name="txtComentario" class="form-control comentario" rows="4"  cols="5" maxlength="300" style="height: 80px;resize:none;overflow:auto;"><?php echo $GLOBALS['oOrden_Compra']->comentario;?></textarea>
                        </div>
                    </div>
                </div>
                <div id="divContenedorProdutos" class="tab-pane fade inner-all" style="padding-top:10px;">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Sub Total:</label>
                        <div class="col-sm-2">
                            <input type="text" id="txtSubTotal" class="form-control" disabled>
                        </div>
                        <label class="col-sm-2 control-label">IGV (<?php echo $GLOBALS['oOrden_Compra']->vigv; ?>):</label>
                        <div class="col-sm-2">
                            <input type="text" id="txtIGV" disabled class="form-control moneda">
                        </div>
                        <label class="col-sm-2 control-label">Total:</label>
                        <div class="col-sm-2">
                            <input type="text" id="txtTotal" disabled class="form-control moneda">
                        </div>
                    </div>
                    <div class="row">
                        <div id="divContenedor_Float_Hijo" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contenedor_detalle" style="height: 300px;overflow:auto;margin: 0 auto; ">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            
        </div>
    </div>
    
</form>
<script type="text/javascript">
    $('#selEstado').val(<?php echo $GLOBALS['oOrden_Compra']->estado_ID; ?>);
    <?php if($GLOBALS['oOrden_Compra']->ID>0){?>
        $("#selProveedor").val("<?php echo $GLOBALS['oOrden_Compra']->proveedor_ID?>");
    
    <?php } else {?>

    <?php } ?>
    
    
    var fncRegistrar_Productos=function(){
        var orden_compra_ID=$('#txtOrden_Compra_ID').val();
        parent.window_float_open_modal_hijo("AGREGAR NUEVO PRODUCTO",'Ingreso/orden_compra_mantenimiento_nuevo_producto',orden_compra_ID,'',fncCargar_Detalle_Orden,null,450);
    }
    var fncEditar=function(id){
        //var id=$('#detalle_ID').val();
        parent.window_float_open_modal_hijo("EDITAR PRODUCTO","/Ingreso/Orden_Compra_Mantenimiento_Editar_Producto",id,"",fncCargar_Detalle_Orden,null,450);

    }
    var fncEliminar=function(id){
        //var id=$('#detalle_ID').val();
        cargarValores('/Ingreso/ajaxOrden_Compra_Mantenimiento_Producto_Eliminar',id,function(resultado){
            if(resultado.resultado==1){
                fncCargar_Detalle_Orden();
                toastem.info(resultado.mensaje);
            }else {
                toastem.error(resultado.mensaje);
            }
            
            
        });
    }
    
   var fncCargar_Detalle_Orden=function(){
        
        var orden_compra_ID=$('#txtOrden_Compra_ID').val();
       
        cargarValores("/Ingreso/ajaxOrden_Compra_Mantenimiento_Producto",orden_compra_ID,function(resultado){
            
            $('#divContenedor_Float_Hijo').html(resultado.resultado);
            
            if(resultado.mensaje==1){
                
                $('#txtSubTotal').val(resultado.subtotal);
                $('#txtIGV').val(resultado.igv);
                $('#txtTotal').val(resultado.total);
                
            } 
        });
    }
    var salir=function(){
        //window.parent.fncMantenimiento();
        window_float_save_modal();
    }
    var validar=function(){
        var proveedor_ID=$("#selProveedor").val();
        var fecha = $.trim($('#txtFecha').val());
        var tipo_cambio=$("#txtTipo_Cambio").val();
        $('#txtVigv').removeAttr('disabled');


        var estado_ID=$('#selEstado').val();
       if (!validarFecha(fecha)) {
            mensaje.advertencia("VERIFICACIÓN DE DATOS",'Ingrese una fecha de emisión válida.',"txtFecha");

            return false;
        }
        if(proveedor_ID==0){
            mensaje.advertencia("VERIFICACIÓN DE DATOS","Debe seleccionar un proveedor.","txtProveedor_ID");

            return false;
        }

        if(isNaN(tipo_cambio)){
            mensaje.advertencia("VERIFICACIÓN DE DATOS",'Registre un tipo de cambio correcto.',"txtTipo_Cambio");

            return false;
        }
        if(tipo_cambio<=0){
            mensaje.advertencia("VERIFICACIÓN DE DATOS",'Registre un tipo de cambio mayor que cero.',"txtTipo_Cambio");

            return false;
        }


        if(estado_ID==56){
            var cant_detalle=total_detalle();
            if(cant_detalle==0){
                mensaje.advertencia("VERIFICACIÓN DE DATOS",'No ha registrado productos.');
                $('#selEstado').val(55);
                $('.nav-tabs a[href="#divContenedorProdutos"]').tab('show');
                return false;
            }
        }
        block_ui();

    }
var total_detalle=function(){
    var valor=0;
    $('#tabla-producto  .item-tr').each(function(){
        valor++;
    });
    return valor;
}    
</script>

<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
   
    <script type="text/javascript">
        $(document).ready(function () {
            $("#li_producto").css("display","");
            toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
            $('.nav-tabs a[href="#divContenedorProdutos"]').tab('show');
         });

        //ampliarVentanaVertical(450,'form');
        fncCargar_Detalle_Orden();

    </script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
   
    <script type="text/javascript">
        $(document).ready(function () {
            toastem.error('<?php echo $GLOBALS['mensaje']; ?>');
         });

     
    </script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -2) { ?>
<script type="text/javascript">
    $(document).ready(function () {
        toastem.error('<?php  echo $GLOBALS['mensaje'];?>');
        setTimeout('window_float_save();', 1000);
       
    });

</script>
<?php } ?>
<?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 0) { ?>
    <div class="float-mensaje">
        <?php echo $GLOBALS['mensaje']; ?>
    </div>
    <div class="group-btn">
        <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
    </div>
<?php } ?>
<?php } ?>
