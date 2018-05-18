<?php
require ROOT_PATH . "views/shared/content-float-modal.php";

?>	
<?php

function fncTitle() { ?>Detalle mensaje<?php } ?>

<?php

function fncHead() { ?>
    
   <!--<script src="../../fileinput/js/fileinput.js" type="text/javascript"></script>
    <link href="../../fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>-->
    <script src="../../include/js/jForm.js" type="text/javascript"></script>

    
<?php } ?>

<?php

function fncTitleHead() { ?><span class="glyphicon glyphicon-envelope"></span> Detalle de mensaje<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>

<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<form id="form"  method="POST" style="overflow:auto;height:410px;" class="form-horizontal"  action="/Pagina_Web/Mensaje_Configuracion_Editar/<?php echo $GLOBALS['oMensaje']->ID;?>" >
    <div class="form-body">
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Usuario :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text" class="form-control" autocomplete="off" disabled value="<?php echo FormatTextView($GLOBALS['oMensaje']->remitente);?>" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Nombres :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text"  class="form-control" autocomplete="off" disabled class="form-control" value="<?php echo FormatTextView($GLOBALS['oMensaje']->nombre);?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Email :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text"  class="form-control" autocomplete="off" disabled value="<?php echo FormatTextView($GLOBALS['oMensaje']->email);?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Asunto :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text"  class="form-control" autocomplete="off" disabled value="<?php echo FormatTextView($GLOBALS['oMensaje']->asunto);?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Mensaje :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <textarea disabled style="height: 50px;" class="form-control"><?php echo FormatTextView($GLOBALS['oMensaje']->mensaje);?></textarea>
               
            </div>
        </div>
        <?php if(trim($GLOBALS['oMensaje']->archivo)!=""){ ?>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Archivo :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <a href='../../files/archivos/mensajes/<?php echo $GLOBALS['oMensaje']->archivo;?>' target='_blank'><?php echo FormatTextView($GLOBALS['oMensaje']->nombre_archivo);?></a> 
            </div>
        </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Email destinatario :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                
               <input type="text"  class="form-control" autocomplete="off" disabled  value="<?php echo FormatTextView($GLOBALS['oMensaje']->email_destinatario);?>">
            </div>
        </div>
        <?php if(trim($GLOBALS['oMensaje']->nombre_amigo)!=""){ ?>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Nombre amigo :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text"  class="form-control" disabled autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oMensaje']->nombre_amigo);?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Email amigo :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text"  class="form-control" disabled autocomplete="off"  value="<?php echo FormatTextView($GLOBALS['oMensaje']->email_amigo);?>">
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button  id="btnCancelar" name="btnCancelar" class="btn btn-danger" title="Guardar" type="button" onclick="window_float_close_modal();" >
               <img  alt="" src="/include/img/boton/cancel_14x14.png">
           Cerrar
           </button>
        </div>
        <div class="clearfix"></div>
    </div>    
</form>
<?php } ?>
<script type="text/javascript">
  
    
</script>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
       
        <script type="text/javascript">
            $(document).on('ready',function(){
                toastem.success('<?php echo $GLOBALS['mensaje'];?>');
            });
            //setTimeout('window_float_save();', 1000);
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
