<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
 
?>	
<?php

function fncTitle() { ?>Nueva Categoría<?php } ?>

<?php

function fncHead() { ?>
 <script src=".../../assets/admin/js/pages/blankon.form.advanced.js"></script>
<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-th-list" aria-hidden="true"></i> Nueva Categoría<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>


    <form id="frm" enctype="multipart/form-data" method="post" action="Mantenimiento/Documentos_Mantenimiento_Formato" class="form-horizontal">
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-sm-4">Color Documentos:</label>
                <div class="col-sm-8">
                    <input type="hidden" id="empresa_ID" name="empresa_ID" value="<?php echo $GLOBALS['oEmpresa']->ID;?>">
                    <input name="color" type="color" id="color" value="<?php echo $GLOBALS['oEmpresa']->color_documentos;?>" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Imagen Pie de página 1:<span class="asterisk">*</span></label>
                <div class="col-sm-8">
                    <img id="imagen_previa1" src="<?php echo ruta_archivo;?>/imagenes/imagen_documentos/<?php echo $GLOBALS['array']['imagen1'];?>" style="height: 40px">
                <input type="file" name="imagen1" id="imagen1" onchange="fileValidation1();">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Imagen Pie de página 2:<span class="asterisk">*</span></label>
                <div class="col-sm-8">
                    <img id="imagen_previa2" src="<?php echo ruta_archivo;?>/imagenes/imagen_documentos/<?php echo $GLOBALS['array']['imagen2'];?>" style="height: 40px">
                <input type="file" name="imagen2" id="imagen2" onchange="fileValidation2();">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Imagen Pie de página 3:<span class="asterisk">*</span></label>
                <div class="col-sm-8">
                    <img id="imagen_previa3" src="<?php echo ruta_archivo;?>/imagenes/imagen_documentos/<?php echo $GLOBALS['array']['imagen3'];?>" style="height: 40px">
                <input type="file" name="imagen3" id="imagen3" onchange="fileValidation3();">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Imagen Pie de página 4:<span class="asterisk">*</span></label>
                <div class="col-sm-8">
                    <img id="imagen_previa4" src="<?php echo ruta_archivo;?>/imagenes/imagen_documentos/<?php echo $GLOBALS['array']['imagen4'];?>" style="height: 40px">
                <input type="file" name="imagen4" id="imagen4" onchange="fileValidation4();">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">Imagen Pie de página 5:<span class="asterisk">*</span></label>
                <div class="col-sm-8">
                    <img id="imagen_previa5" src="<?php echo ruta_archivo;?>/imagenes/imagen_documentos/<?php echo $GLOBALS['array']['imagen5'];?>" style="height: 40px">
                <input type="file" name="imagen5" id="imagen5" onchange="fileValidation5();">
                </div>
            </div>
        </div>
        <div class="form-footer">
            <div class="pull-left">
                <button type="submit" id="btnGrabar" name="btnEnviar" title="Guardar"  class="btn btn-success" >
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
<?php } ?>
<script type="text/javascript">
        //ingreso de datos obligatorios
        var validar = function () {
            var linea =$('#selLinea').val();
            var nombre = $.trim($('#txtNombre').val());
            var file = document.getElementById('imagen');
            if (linea == 0) {
                mensaje.error('Mensaje de error','Debe seleccionar una línea.','selLinea');
               
                return false;
            }
            if (nombre== "") {
                mensaje.error('Mensaje de error','Debe registrar un nombre.','txtNombre');
                
                return false;
            }
           /* if(file.files.length==0){
                mensaje.error('Mensaje de error','Debe adjuntar una imagen.','imagen');

                return false;
             }*/
        }
        var MostrarLista=function(buscador,contenedorLista){
            var valor_buscar=$('#'+buscador).val();
            cboMostrarTexto('/Mantenimiento/ajaxCbo_Categoria_Seleccionar',valor_buscar,contenedorLista);

        }
        
        function fileValidation1() {
            var fileInput = document.getElementById('imagen1');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .jpg');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previa1').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }

        }
        function fileValidation2() {
            var fileInput = document.getElementById('imagen2');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .jpg');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previa2').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }

        }
        function fileValidation3() {
            var fileInput = document.getElementById('imagen3');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .jpg');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previa3').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }

        }
        function fileValidation4() {
            var fileInput = document.getElementById('imagen4');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .jpg');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previa4').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }

        }
        function fileValidation5() {
            var fileInput = document.getElementById('imagen5');
            var filePath = fileInput.value;
            var allowedExtensions = /(.jpg)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .jpg');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previa5').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }

        }
        
    </script>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>

        <script type="text/javascript">
            $(document).ready(function(){
                toastem.success("<?php echo $GLOBALS['mensaje']; ?>");
                 setTimeout('window_float_close_modal();', 1000);
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
	<?php if(isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1){?>
    <script type="text/javascript">
        $(document).ready(function(){
                toastem.error("<?php echo $GLOBALS['mensaje']; ?>");
                 setTimeout('window_float_save();', 1000);
            });
        $('#selLinea').val('<?php echo $GLOBALS['linea_ID'];?>');
	    
                         
    </script>   

    <?php } ?>
<?php } ?>
