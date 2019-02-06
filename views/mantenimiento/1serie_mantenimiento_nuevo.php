<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Nuevo Serie<?php } ?>

<?php

function fncHead() { ?>

    <script type="text/javascript" src="include/js/jForm.js"></script>

<?php } ?>

<?php

function fncTitleHead() { ?> Nuevo Serie<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>

<form id="form" method="POST"  action="/Mantenimiento/Serie_Mantenimiento_Nuevo" onsubmit="return validar();" >
    <div class="panel panel-tab rounded shadow">
        <div class="panel-body no-padding rounded-bottom">
            <div class="tab-content form-horizontal">
                <div id="divDatos" class="tab-pane fade in active inner-all">
    <div class="form-group">
        <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
            <label>Tipo de Comprobante: </label>
        </div>
        <div class="col-md-9 col-sm-9 col-lg-9 col-xs-9">
           <select id="selComprobante_Tipo" name="selComprobante_Tipo" class="form-control form-requerido">
                <?php foreach($GLOBALS['oSerie']->dtComprobante_tipo as $iComprobante_Tipo){ ?>
                        <option value="<?php echo $iComprobante_Tipo['ID']; ?>"><?php echo FormatTextView($iComprobante_Tipo['nombre']); ?></option>
                <?php } ?>
            </select>

            <script type="text/javascript">
                 $('#selComprobante_Tipo').val(<?php echo $GLOBALS['oSerie']->comprobante_tipo_ID;?>);
            </script>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Nombre:</label>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <input type="text" id="txtNombre"  name="txtNombre"  autocomplete="off"  value="<?php echo $GLOBALS['oSerie']->nombre; ?>" class="form-control form-requerido text-uppercase"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label">Descripcion:</label>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <input type="text" id="txtDescripcion" name="txtDescripcion"  autocomplete="off"  value="<?php echo $GLOBALS['oSerie']->descripcion; ?>" class="form-control text-uppercase"/>
        </div>
    </div>
        </div>
        </div>
        </div>
        <div class="panel-footer">
   <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" >
                <img alt="" width="16" src="/include/img/boton/save_48x48.png">
                Guardar
            </button>
            <button  id="btnCancelar" name="btnCancelar"  class="btn btn-danger" type="button" title="Cancelar" onclick="salir();" >
                <img  alt="" src="/include/img/boton/cancel_14x14.png">
                Cancelar
            </button> 
        </div>
        
    </div>
        </div>
    </div>
</form>
    <?php } ?>
<script>
    var validar=function(){
        var nombre=$.trim($('#txtNombre').val());
        var comprobante_tipo_ID = $.trim($('#selComprobante_Tipo').val());
        if(nombre==""){
            mensaje.error("Mensaje de error", "Debe registrar el nombre de la serie.","txtNombre");
            return false;
        }
        if(comprobante_tipo_ID=="0"){
            mensaje.error("Mensaje de error", "Debe registrar el tipo de comprobante.","selComprobante_Tipo");
            return false;
        }
    }
            var salir=function(){
        //window.parent.fncMantenimiento();
        window_float_close_modal();
    }
        
</script>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        
    <script type="text/javascript">
        $(document).ready(function(){
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
