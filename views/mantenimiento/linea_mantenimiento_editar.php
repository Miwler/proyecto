<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Editar Línea<?php } ?>

<?php

function fncHead() { ?>
    
    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-align-left" aria-hidden="true"></i>Editar Línea<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
<form id="form" method="POST"  action="/Mantenimiento/Linea_Mantenimiento_Editar/<?php echo $GLOBALS['oLinea']->ID; ?>" class="form-horizontal" enctype="multipart/form-data" onsubmit="return validar();">
    <div class="form-body">
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <lable>Nombre: </lable>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <input type="text" id="txtNombre" name="txtNombre"   onkeyup="MostrarLista(this.id,'divLinea');" autocomplete="off" value="<?php echo $GLOBALS['oLinea']->nombre; ?>" class="form-control form-requerido text-uppercase" style="margin-bottom:0;"/>
                <div id="divLinea" style="position:absolute;width:400px;z-index: 10;"></div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <lable>Descripción: </lable>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" >
                <input type="text" id="txtDescripcion" name="txtDescripcion"   autocomplete="off" value="<?php echo $GLOBALS['oLinea']->descripcion; ?>" class="form-control text-uppercase"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <lable>Tipo: </lable>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <select id="selTipo" name="selTipo" class="form-control form-requerido">
                    <option value="0">--SELECCIONAR--</option>
                    <option value="alquiler">ALQUILER</option>
                    <option value="producto">PRODUCTO</option>
                    <option value="servicio">SERVICIO</option>
                </select>
                <script type="text/javascript">
                    $('#selTipo').val('<?php echo $GLOBALS['oLinea']->tipo;?>');
                </script>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-<?php echo $_SESSION['cabecera'];?>">
                    <div class="panel-heading">
                        <h4>Imagen</h4> <input type="file" id="imagen" name="imagen"  class="form-control form-requerido" onchange="fileValidation();"/>
                    </div>
                    <div class="panel-body" style="text-align:center;">
                        <input id="txtImagen" value="<?php echo $GLOBALS['oLinea']->imagen;?>" style="display:none;">
                       <img id="imagen_previa"  alt="" src="<?php echo $GLOBALS['oLinea']->ruta_imagen;?>" style="height: 128px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button  id="btnEnviar" name="btnEnviar" title="Guardar"  class="btn btn-success" >
            <img alt="" src="/include/img/boton/save_14x14.png">
            Guardar
            </button>&nbsp;&nbsp;
            <button  type="button" id="btnCancelar" name="btnCancelar" title="Cancelar"  class="btn btn-danger" onclick="window_float_close_modal();" >
                <img  alt="" src="/include/img/boton/cancel_14x14.png" >
                Cancelar
            </button>  
        </div>
        <div class="clearfix"></div>
    </div>

    </form>
    <script type="text/javascript">
        
        var validar = function () {
            var tipo=$('#selTipo').val();
            var nombre = $.trim($('#txtNombre').val());
            var file = document.getElementById('imagen');
            var imagen=$.trim($('#txtImagen').val());
            if (nombre== "") {
                mensaje.error('Mensaje de error','Debe registrar un nombre.','txtNombre');
                
                return false;
            }
            if(tipo=="0"){
                mensaje.error('Mensaje de error','Debe seleccionar un tipo.','selTipo');
                return false;
            }
            if(imagen==""){
                if(file.files.length==0){
                    mensaje.error('Mensaje de error','Debe adjuntar una imagen.','imagen');
                    return false;
                }
            }
            
        }
        var MostrarLista=function(buscador,contenedorLista){
        var valor_buscar=$('#'+buscador).val();
        cboMostrarTexto('/Mantenimiento/ajaxCbo_Linea_Seleccionar',valor_buscar,contenedorLista);

        }
        var subirValorCaja=function(valor){
            $('#txtNombre').val(valor);
            $('#divLinea').html('');
        }
        function fileValidation() {
            var fileInput = document.getElementById('imagen');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .jpeg/.jpg/.png/.gif.');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previa').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }

        }
    </script>    
     
    <?php } ?>

    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                toastem.success(" <?php echo $GLOBALS['mensaje']; ?>");
                setTimeout('window_float_save_modal();', 1000);
            });
            
        </script>
    <?php } ?>
  
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                toastem.error(" <?php echo $GLOBALS['mensaje']; ?>");
                
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

