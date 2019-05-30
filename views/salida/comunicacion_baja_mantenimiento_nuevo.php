<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Nueva comunicacion<?php } ?>

<?php

function fncHead() { ?>
 <script type="text/javascript" src="include/js/jForm.js"></script>
<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-taxi" aria-hidden="true"></i> Nueva comunicación<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1|| $GLOBALS['resultado'] == 1) { ?>

<form id="form" method="POST"  action="Salida/Comunicacion_Baja_Mantenimiento_Nuevo" onsubmit="return validar();" class="form-horizontal">
    <input type="hidden" id="ID" name="ID" value="<?php echo $GLOBALS['oComunicacion_Baja']->ID;?>">
    <input type="hidden" id="documentos_IDs" name="documentos_IDs">
    <input type="hidden" id="txtFechaReferencia" name="txtFechaReferencia"   value="<?php echo $GLOBALS['oComunicacion_Baja']->FechaReferencia?>">
    <div class="form-body">
        <div class="alert alert-success"><strong>!Importante: </strong>Solo se pueden dar de baja comprobantes emitidos en 72 horas y que no han sido enviados al cliente.</div>
        <h4 class="page-header">Datos generales</h4>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Identificador</label>
                    <div class="col-sm-8">
                        <input type="textIdDocumento" name="textIdDocumento" disabled class="form-control" value="<?php echo $GLOBALS['oComunicacion_Baja']->IdDocumento?>">

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Fecha emisión:<span class="asterisk">*</span></label>
                    <div class="col-sm-8">
                       <input type="text" id="txtFechaEmision" name="txtFechaEmision" class="form-control date-range-picker-single" value="<?php echo $GLOBALS['oComunicacion_Baja']->FechaEmision?>">
                    </div>
                </div>
               
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-12">Motivo:<span class="asterisk">*</span></label>
                    <div class="col-sm-12">
                        <textarea id="txtMotivo" name="txtMotivo" class="form-control" style="height: 60px;overflow:auto;resize:none;"><?php echo $GLOBALS['oComunicacion_Baja']->MotivoBaja?></textarea>
                    </div>
                </div>
                
            </div>
        </div>
        <h4 class="page-header">Documentos</h4>
        <div class="form-group">
            <div class="col-sm-3">
                <div class="ckbox ckbox-theme">
                    <input id="ckFacturas" name="ckFacturas" checked="checked" type="checkbox">
                    <label for="ckFacturas">Facturas/Boletas</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ckbox ckbox-danger">
                    <input id="ckFacturas_Erradas" name="ckFacturas_Erradas" type="checkbox">
                    <label for="ckFacturas_Erradas">Facturas/Boletas Erradas</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ckbox ckbox-theme">
                    <input id="ckNota_Credito" name="ckNota_Credito" type="checkbox">
                    <label for="ckNota_Credito">Nota de crédito</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ckbox ckbox-theme">
                    <input id="ckNota_Debito" name="ckNota_Debito" type="checkbox">
                    <label for="ckNota_Debito">Nota de débito</label>
                </div>
            </div>
        </div>
        <div class="border border-teal" style="height: 300px;overflow:auto;">
             <table id="table_documentos" class="table table-teal table-bordered table-responsive">
                <thead>
                    <tr>
                        <th class="text-center">Nro</th>
                        <th class="text-center">Comprob.</th>
                        <th class="text-center">Número</th>
                        <th class="text-center">Fecha E.</th>
                         <th class="text-center">Fecha Gener.</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Seleccionar</th>
                       
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
       
    </div>
    <div class="form-footer">
        <button type="submit"  class="grabar"></button>
        <button type="button"  class="cancelar" onclick="window_float_close_modal();"></button>
    </div>
</form>
    
<script>
    var validar=function(){
        var FechaEmision=$.trim($('#txtFechaEmision').val());
        var FechaReferencia=$.trim($('#txtFechaReferencia').val());
        var motivo=$.trim($("#txtMotivo").val());
        if(FechaEmision==""){
            mensaje.error("Mensaje de error", "Debe registrar una fecha de emisión.","txtFechaEmision");
            return false;
        }
        
        if(motivo==""){
            mensaje.error("Mensaje de error", "Debe registrar un motivo de la baja del comprobante.","txtMotivo");
            return false;
        }
        var i=0;
        var valor="";
        $("#table_documentos tbody input:radio:checked").each(function(){
            if(i==0){
                valor=this.value;
            }else{
                valor=valor+','+this.value;
            }
            i++;
        });
        
        if(valor==""){
            mensaje.error("validación de datos","Debe seleccionar un documento");
            return false;
        }
        if(FechaReferencia==""){
            mensaje.error("Mensaje de error", "Debe registrar una fecha de referencia.","txtFechaReferencia");
            return false;
        }
        $("#documentos_IDs").val(valor);
       
        block_ui();
    }
   
    function cargarFilas(){
       
        var object=new Object();
        block_ui(function(){
            enviarAjax("Salida/ajaxCargarFilarDocumetosBjas",'form',object,function(resultado){
                $.unblockUI();
                var resul = $.parseJSON(resultado);
                //console.log(resul);
                if(resul.resultado==1){

                    $("#table_documentos tbody").html(resul.filas);
                }else{
                    mensaje.error("Ocurrió un error",resul.mensaje);
                }

            });
        });
        
    }
    function fnVerFecha(fecha){
        $("#txtFechaReferencia").val(fecha);
    }
    $(document).ready(function(){
        cargarFilas();
    }); 
    $("#ckFacturas").click(function(){
        cargarFilas();
    });
    $("#ckFacturas_Erradas").click(function(){
        cargarFilas();
    });
    $("#ckNota_Credito").click(function(){
        cargarFilas();
    });
    $("#ckNota_Debito").click(function(){
        cargarFilas();
    });
    $("#txtFechaReferencia").change(function(){
            cargarFilas();
        }
    );
</script>
<?php } ?>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        
    <script type="text/javascript">
        $(document).ready(function(){
            $("#btnAgregar").css("display","");
            toastem.success("<?php echo $GLOBALS['mensaje']; ?>");
           setTimeout('window_float_save_modal();', 1000);
        });
        
    </script>
    <?php } ?>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
        
    <script type="text/javascript">
        $(document).ready(function(){
            mensaje.error("Mensaje de error","<?php echo $GLOBALS['mensaje']; ?>");
           
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
