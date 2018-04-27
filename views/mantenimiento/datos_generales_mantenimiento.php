<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Mantenimiento Datos Generales
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jLista.js"></script>	
		
<?php } ?>
    
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
        <i class="fa fa-envelope" aria-hidden="true"></i>Mantenimiento Datos Generales
<?php } ?>
<?php function fncPage(){?>
    <form id="frm1" name="frm1" method="post" action="/Mantenimiento/Datos_generales_Mantenimiento" enctype="multipart/form-data" onsubmit="return validar();" class="form-horizontal">
    <div class="panel panel-tab panel-tab-double shadow">
        
        <div class="panel-body">
           
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h4><img src="include/img/boton/dolar_48x48.png" style="height: 20px"> Información Monetaria  </h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Tipo de cambio: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtTipo_Cambio" name="txtTipo_Cambio" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->tipo_cambio);?>" class="form-control form-requerido text-uppercase decimal">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>I.G.V: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtVigv" name="txtVigv" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->vigv);?>" class="form-control form-requerido text-uppercase decimal">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h4><img src="include/img/boton/phone_32x32.png" style="height: 20px"> Contactos</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Página web: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtPagina_Web" name="txtPagina_Web" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->pagina_web);?>" class="form-control form-requerido">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Correo principal: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtMail_Principal" name="txtMail_Principal" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->mail_principal);?>" class="form-control form-requerido">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Correo de información: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtMail_Info" name="txtMail_Info" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->mail_info);?>" class="form-control form-requerido">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Correo de venta: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                               <input type="text" id="txtMail_Venta" name="txtMail_Venta" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->mail_venta);?>" class="form-control form-requerido">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Central telefónica: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtTelefono" name="txtTelefono" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->telefono);?>" class="form-control form-requerido">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Celular1: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtRpc" name="txtRpc" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->rpc);?>" class="form-control text-uppercase">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Celular2: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtRpm" name="txtRpm" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->rpm);?>" class="form-control text-uppercase">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Celular3: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtNextel" name="txtNextel" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->nextel);?>" class="form-control text-uppercase">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Celular4: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtOtro_Operador" name="txtOtro_Operador" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->otro_operador);?>" class="form-control text-uppercase">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                  <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4><img src="../../include/img/boton/sunat.png" alt="" style="height: 30px;"/> Información SUNAT </h4>

                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Razon social: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtRazon_Social" name="txtRazon_Social" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->razon_social);?>" class="form-control form-requerido text-uppercase">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>R.U.C.: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtRuc" name="txtRuc" value="<?php echo FormatTextView($GLOBALS['oDatos_Generales']->ruc);?>" class="form-control form-requerido text-uppercase int">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Dirección fiscal: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtDireccion_Fiscal" name="txtDireccion_Fiscal" value="<?php echo $GLOBALS['oDatos_Generales']->direccion_fiscal;?>" class="form-control form-requerido text-uppercase">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Información Visual</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Logo: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <img id="imagen_previa" src="files/imagenes/logo/<?php echo $GLOBALS['oDatos_Generales']->logo_extension;?>" style="height: 80px">
                                                <input type="file" name="imagen" id="imagen" onchange="fileValidation();">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Favicon: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <img id="imagen_previaicono" src="files/imagenes/favicon/<?php echo $GLOBALS['oDatos_Generales']->favicon;?>" style="height: 40px">
                                                <input type="file" name="icono" id="icono" onchange="fileValidationIcono();">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Nombre corto: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtAlias" name="txtAlias" value="<?php echo $GLOBALS['oDatos_Generales']->alias;?>" class="form-control form-requerido text-uppercase">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Dirección: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <input type="text" id="txtDireccion" name="txtDireccion" value="<?php echo $GLOBALS['oDatos_Generales']->direccion;?>" class="form-control form-requerido text-uppercase">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Departamento: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <select id="selDepartamento" name="selDepartamento" class="form-control" onchange="fncDepartamento();">
                                                    <?php foreach($GLOBALS['dtDepatamento'] as $departamento){ ?>
                                                    <option value="<?php echo $departamento['ID']?>"><?php echo FormatTextView($departamento['nombre'])?></option>
                                                    <?php } ?>
                                                </select>
                                                <script type="text/javascript">
                                                    $('#selDepartamento').val('<?php echo $GLOBALS['oDatos_Generales']->departamento_ID?>');
                                                </script>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Provincia: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <select id="selProvincia" name="selProvincia" class="form-control">
                                                    <?php foreach($GLOBALS['dtProvincia'] as $provincia){ ?>
                                                    <option value="<?php echo $provincia['ID']?>"><?php echo FormatTextView($provincia['nombre'])?></option>
                                                    <?php } ?>
                                                </select>
                                                <script type="text/javascript">
                                                    $('#selProvincia').val('<?php echo $GLOBALS['oDatos_Generales']->provincia_ID?>');
                                                </script>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Distrito: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <select id="selDistrito" name="selDistrito" class="form-control">
                                                     <?php foreach($GLOBALS['dtDistrito'] as $distrito){ ?>
                                                    <option value="<?php echo $distrito['ID']?>"><?php echo FormatTextView($distrito['nombre'])?></option>
                                                    <?php } ?>
                                                </select>
                                                <script type="text/javascript">
                                                    $('#selDistrito').val('<?php echo $GLOBALS['oDatos_Generales']->distrito_ID?>');
                                                </script>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                                                <label>Observación: </label>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 col-md-9 col-xs-6">
                                                <textarea id="txtObservacion" name="txtObservacion" class="form-control form-requerido text-uppercase"><?php echo FormatTextView($GLOBALS['oDatos_Generales']->observacion);?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button  id="btnEnviar" name="btnEnviar" class="btn btn-success btn-lg" title="Guardar cambios" >
                            <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                            Guardar
                        </button>
                    </div>
                </div>
                
            
        </div>
    </div>
    </form>
    <script type="text/javascript">
        function validar(){
            
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
        function fileValidationIcono() {
            var fileInput = document.getElementById('icono');
            var filePath = fileInput.value;
            var allowedExtensions = /(.ico)$/i;
            if(!allowedExtensions.exec(filePath)){
                mensaje.error('Mensaje de error','Solo se aceptan imagenes .ico.');
                fileInput.value = '';
                return false;
            }else{
                //Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagen_previaicono').attr("src",e.target.result);
                        //document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'" width="250" height="90" class="thumbnail"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }

        }
        var fncDepartamento=function(){
            var obj = $('#selDepartamento');
            ajaxSelect('selProvincia', '/Mantenimiento/ajaxSelect_Provincia/' + obj.val(), '',fncProvincia);
        }

        var fncProvincia=function(){
            var obj = $('#selProvincia');
            ajaxSelect('selDistrito', '/Mantenimiento/ajaxSelect_Distrito/' + obj.val(), '',null);
        }
    </script>
   <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                 mensaje.success("Mensaje de resultado","<?php echo $GLOBALS['mensaje']?>");
                 var img=document.getElementById("imagen_previa");
                 img.src="";
                 img.src="files/imagenes/logo/<?php echo $GLOBALS['oDatos_Generales']->logo_extension;?>";
                 var img1=document.getElementById("imagen_previaicono");
                 img1.src="";
                 img1.src="files/imagenes/favicon/<?php echo $GLOBALS['oDatos_Generales']->favicon;?>";
            });

        </script>
    <?php } ?>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                 mensaje.error("Mensaje de error","<?php echo $GLOBALS['mensaje']?>");
            });

        </script>
    <?php } ?>
<?php } ?>
