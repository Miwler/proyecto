<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?>Imagenes del producto<?php } ?>
<script src="../../include/js/jForm.js" type="text/javascript"></script>
<?php

function fncHead() { ?>

<?php } ?>

<?php

function fncTitleHead() { ?><span class="glyphicon glyphicon-camera"></span> Imagenes del producto<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
    
    <form id="form" method="POST"  action="/Mantenimiento/Producto_Mantenimiento_Imagen/<?php echo $GLOBALS['oProducto']->ID; ?>" enctype="multipart/form-data" class="form-horizontal" onsubmit="return validar();">
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Nombre: </label>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <input type="text" id="txtNombre" name="txtNombre"   autocomplete="off"  class="form-control text-uppercase form-requerido" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <label>Orden: </label>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                <input type="number" id="txtOrden" name="txtOrden"  autocomplete="off" value="0" class="form-control text-uppercase form-requerido"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                <input type="file" id="imagen" name="imagen"  class="form-control" onchange="fileValidation();"/>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                <img id="imagen_previa"  alt="" src="/include/img/boton/camara_128x128.png" style="height: 90px;">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button  id="btnEnviar" name="btnEnviar" title="Agregar"  class="btn btn-success" >
                <img alt="" src="/include/img/boton/add_16x16.png">
                Agregar
                </button>&nbsp;&nbsp;
                <button  type="button" id="btnCancelar" name="btnCancelar" title="Cerrar"  class="btn btn-danger" onclick="window_float_close_modal();" >
                    <img  alt="" src="/include/img/boton/cancel_14x14.png" >
                    Cerrar
                </button>  
            </div>
        </div>
        <div class="form-group" style="margin-top:15px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Fotos</h4> 
                    </div>
                    <div id="contenedor_imagen" class="panel-body" style="text-align:center;height: 150px; overflow-y:auto;">


                    </div>
                </div>
            </div>
        </div>
    </form>
    
<script type="text/javascript">
    $(document).ready(function(){
        mostrar_fotos();
    });
        //ingreso de datos obligatorios
    var validar = function () {
        var nombre = $.trim($('#txtNombre').val());
        var file = document.getElementById('imagen');
        if (nombre== "") {
            mensaje.error('Mensaje de error','Debe registrar un nombre.','txtNombre');
            return false;
        }
        
        if(file.files.length==0){
            mensaje.error('Mensaje de error','Debe adjuntar una imagen.','imagen');
            return false;
        }

    }
    var mostrar_fotos=function(){
        var prodcuto_ID=<?php echo $GLOBALS['oProducto']->ID; ?>;
        cargarValores('mantenimiento/ajaxProducto_Mantenimiento_Imagen',prodcuto_ID,function(resultado){
            $('#contenedor_imagen').html(resultado.resultado);
        });
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
    var fncEliminar=function(id){
        cargarValores('mantenimiento/ajaxProducto_Mantenimiento_Imagen_Eliminar',id,function(resultado){
            if(resultado.resultado==1){
                mensaje.info("Mensaje de resultado",resultado.mensaje);
                mostrar_fotos();
            }else{
                mensaje.error("Mensaje de error",resultado.mensaje);
            }
        });
    }
        
    </script>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>

        <script type="text/javascript">
            $(document).ready(function(){
                toastem.success("<?php echo $GLOBALS['mensaje']; ?>");    
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
                mensaje.error("Mensaje de error","<?php echo $GLOBALS['mensaje']; ?>");
                
        });
                
    </script>   

    <?php } ?>
<?php } ?>
