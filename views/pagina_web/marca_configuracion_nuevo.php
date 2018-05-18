<?php
require ROOT_PATH . "views/shared/content-float-modal.php";

?>	
<?php

function fncTitle() { ?>Nueva Marca<?php } ?>

<?php

function fncHead() { ?>
    
   <!--<script src="../../fileinput/js/fileinput.js" type="text/javascript"></script>
    <link href="../../fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>-->
    <script src="../../include/js/jForm.js" type="text/javascript"></script>

    
<?php } ?>

<?php

function fncTitleHead() { ?><span class="glyphicon glyphicon-tags"></span> Nueva Marca<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>

<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
    <form id="form"  method="POST" class="form-horizontal"  action="/Pagina_Web/Marca_Configuracion_Nuevo" onsubmit="return validar();" enctype="multipart/form-data">
        <div class="form-body">
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label>Nombre</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" id="txtNombre" name="txtNombre" class="form-control" autocomplete="off" >
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label>URL</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" name="txtUrl" id="txtUrl" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label>Orden</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="number" name="txtOrden" id="txtOrden" class="form-control" autocomplete="off" value="0">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <input type="file" name="imagen" id="imagen"type="file" size="44" class="form-control" onchange="return fileValidation()">
                   
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                     <div id="imagePreview" style="height: 100px;width:270px;"></div>
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
        var file = document.getElementById('imagen');
        
        
        if(nombre==""){
            toastem.error("Tiene que registrar un nombre.");
            $('#txtNombre').focus();
            return false;
        }
        if(file.files.length==0){
            toastem.error("Debe adjuntar una imagen.");
            $('#imagen').focus();
            return false;
        }
        $('#fondo_espera').css('display','block');
    }
    function fileValidation() {

       
        var fileInput = document.getElementById('imagen');
        var filePath = fileInput.value;
        var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
        if(!allowedExtensions.exec(filePath)){
            toastem.error('Solo se aceptan imagenes .jpeg/.jpg/.png/.gif.');
            fileInput.value = '';
            return false;
        }else{
            //Image preview
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
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
