<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Editar Categoría<?php } ?>

<?php

function fncHead() { ?>

<?php } ?>

<?php

function fncTitleHead() { ?><i class="fa fa-th-list" aria-hidden="true"></i> Editar Categoría<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
        <form id="form" method="POST" style="width:600px;padding-top:10px;" action="/Mantenimiento/Categoria_Mantenimiento_Editar/<?php echo $GLOBALS['oCategoria']->ID; ?>" enctype="multipart/form-data" onsubmit="return validar();">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Línea: </label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <select id="selLinea" name="selLinea"  class="form-control form-requerido">
                        <option value="0">SELECCIONAR</option>
                    <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
                        <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                    <?php } ?>
                    </select> 
                    <script type="text/javascript">
                    $('#selLinea').val(<?php echo $GLOBALS['oCategoria']->linea_ID;?>);
                    </script>
                </div>
            </div>
            <div class="row" style="margin-bottom: 15px;">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Nombre: </label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" id="txtNombre" name="txtNombre"   onkeyup="MostrarLista(this.id,'divCategoria');" autocomplete="off" value="<?php echo FormatTextView($GLOBALS['oCategoria']->nombre); ?>" class="form-control text-uppercase form-requerido" style="margin-bottom:1px;"/>
                    <div id="divCategoria" style="position:absolute;width:100%;z-index: 10;"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Descripción: </label>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <input type="text" id="txtDescripcion" name="txtDescripcion"  autocomplete="off" value="<?php echo $GLOBALS['oCategoria']->descripcion; ?>" class="form-control text-uppercase form-requerido"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-<?php echo $_SESSION['cabecera'];?>">
                        <div class="panel-heading">
                            <h4>Imagen</h4> <input type="file" id="imagen" name="imagen"  class="form-control" onchange="fileValidation();"/>
                        </div>
                        <div class="panel-body" style="text-align:center;">
                            <input id="txtImagen" value="<?php echo $GLOBALS['oCategoria']->imagen;?>" style="display:none;">
                           <img id="imagen_previa"  alt="" src="<?php echo $GLOBALS['oCategoria']->ruta_imagen;?>" style="height: 128px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button  id="btnEnviar" name="btnEnviar" title="Guardar"  class="btn btn-success" >
                    <img alt="" src="/include/img/boton/save_14x14.png">
                    Guardar
                    </button>&nbsp;&nbsp;
                    <button  type="button" id="btnCancelar" name="btnCancelar" title="Cancelar"  class="btn btn-danger" onclick="window_float_close();" >
                        <img  alt="" src="/include/img/boton/cancel_14x14.png" >
                        Cancelar
                    </button>  
                </div>
            </div>

        </form>
    <?php } ?>
<script type="text/javascript">
        //ingreso de datos obligatorios
        var validar = function () {
            var linea =$('#selLinea').val();
            var nombre = $.trim($('#txtNombre').val());
            var file = document.getElementById('imagen');
            var imagen=$.trim($('#txtImagen').val());
            if (linea == 0) {
                mensaje.error('Mensaje de error','Debe seleccionar una línea.','selLinea');
               
                return false;
            }
            if (nombre== "") {
                mensaje.error('Mensaje de error','Debe registrar un nombre.','txtNombre');
                
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
            cboMostrarTexto('/Mantenimiento/ajaxCbo_Categoria_Seleccionar',valor_buscar,contenedorLista);

        }
        var subirValorCaja=function(valor){
            $('#txtNombre').val(valor);
            $('#divCategoria').html('');
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
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>

        <script type="text/javascript">
            $(document).ready(function(){
                toastem.success("<?php echo $GLOBALS['mensaje']; ?>");
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
