<?php
require ROOT_PATH . "views/shared/content-float-modal.php";

?>	
<?php

function fncTitle() { ?>Nuevo Banner<?php } ?>

<?php

function fncHead() { ?>
    
   <!--<script src="../../fileinput/js/fileinput.js" type="text/javascript"></script>
    <link href="../../fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>-->
    <script src="../../include/js/jForm.js" type="text/javascript"></script>

    
<?php } ?>

<?php

function fncTitleHead() { ?>Nuevo Banner<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>

<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
    <form id="form"  method="POST"  action="/Pagina_Web/Web_Banner_Configuracion_Nuevo" class="form-horizontal" onsubmit="return validar();">
        <div class="form-body">
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label>Nombre</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" id="txtNombre" name="txtNombre" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oWeb_Banner']->nombre);?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label>Descripción</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <textarea id="txtDescripcion" name="txtDescripcion" style="height: 50px;" class="form-control"><?php echo FormatTextView($GLOBALS['oWeb_Banner']->descripcion);?></textarea>

                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="pull-left">
                <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Guardar" >
                    <img  alt="" src="/include/img/boton/save_14x14.png">
                Guardar
                </button>
                &nbsp;
                 <button  id="btnCancelar" name="btnCancelar" class="btn btn-danger" title="Guardar" type="button" onclick="window_float_close_modal();" >
                    <img  alt="" src="/include/img/boton/cancel_14x14.png">
                Cancelar
                </button>
            </div> 
            <div class="clearfix"></div>
        </div>
    </form>
<?php } ?>
<script type="text/javascript">
  
    var validar=function(){
        var nombre=$.trim($('#txtNombre').val());
        if(nombre==""){
            toastem.error("Tiene que registrar un nombre.");
            $('#txtNombre').focus();
            return false;
        }
    }
</script>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
       
        <script type="text/javascript">
            $(document).on('ready',function(){
                toastem.success('<?php echo $GLOBALS['mensaje'];?>');
            });
            setTimeout('window_float_save_modal();', 1000);
        </script>
    <?php } ?>
 <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <script type="text/javascript">

            $(document).on('ready',function(){
                toastem.error('<?php echo $GLOBALS['mensaje'];?>');
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
