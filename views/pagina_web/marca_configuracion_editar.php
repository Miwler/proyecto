<?php
require ROOT_PATH . "views/shared/content-float.php";

?>	
<?php

function fncTitle() { ?>Editar Marca<?php } ?>

<?php

function fncHead() { ?>
    
   <!--<script src="../../fileinput/js/fileinput.js" type="text/javascript"></script>
    <link href="../../fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>-->
    <script src="../../include/js/jForm.js" type="text/javascript"></script>

    
<?php } ?>

<?php

function fncTitleHead() { ?><span class="glyphicon glyphicon-tags"></span> Editar Marca<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>

<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<form id="form"  method="POST" style="width:500px;padding-top:10px; overflow:auto;"  action="/Pagina_Web/Marca_Configuracion_Editar/<?php echo $GLOBALS['oMarca']->ID;?>" onsubmit="return validar();" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Nombre</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text" id="txtNombre" name="txtNombre" class="form-control" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oMarca']->nombre);?>" >
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>URL</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text" name="txtUrl" id="txtUrl" class="form-control" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oMarca']->url);?>">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Orden</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="number" name="txtOrden" id="txtOrden" class="form-control" autocomplete="off" value="<?php echo $GLOBALS['oMarca']->orden;?>">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Imagen</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="file" name="imagen" id="imagen"type="file" size="44" class="form-control" onchange="return fileValidation()">
                <div id="imagePreview" style="height: 100px;width:270px;">
                    <?php if(trim($GLOBALS['oMarca']->imagen)!=""){?>
                    <img id="bannerimagen" src="../../files/imagenes/marca/<?php echo $GLOBALS['oMarca']->imagen;?>" alt="No existe" width="250" height="90" class="thumbnail"/>
                    <?php } ?>
                </div>
            </div>
        </div>
       
        <div class="row botones" style="margin-top:15px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button  id="btnEnviar" name="btnEnviar" class="btn btn-success" title="Guardar" >
                    <img  alt="" src="/include/img/boton/save_14x14.png">
                Guardar
                </button>
                &nbsp;
                 <button  id="btnCancelar" name="btnCancelar" class="btn btn-danger" title="Guardar" type="button" onclick="window_float_close();" >
                    <img  alt="" src="/include/img/boton/cancel_14x14.png">
                Cancelar
                </button>
            </div>  
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
        if(typeof($('#bannerimagen'))=="undefined"){
            alert('no');
        }
        <?php if(trim($GLOBALS['oMarca']->imagen)==""){?>
        if(file.files.length==0){
            toastem.error("Debe adjuntar una imagen.");
            $('#imagen').focus();
            return false;
        }
        <?php } ?>
        $('#fondo_espera').css('display','block');
    }
    function fileValidation() {

        var fileInput = document.getElementById('imagen');
        var filePath = fileInput.value;
        var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
        if(!allowedExtensions.exec(filePath)){
            alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
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
