<?php		
	require ROOT_PATH."views/shared/content-float-modal.php";	
?>	
<?php function fncTitle(){?>
		Nuevo usuario
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>

        <link href="../../../assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css" rel="stylesheet">
       <link href="../../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css" rel="stylesheet">

        
        <script src="../../../assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/holderjs/holder.js"></script>
        <script src="../../../assets/global/plugins/bower_components/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/jquery-autosize/jquery.autosize.min.js"></script>
      <script src="../../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js"></script>
     
<?php } ?>
                
<?php
    function fncTitleHead() { ?>
    <span class="glyphicon glyphicon-user"></span>NUEVO USUARIO
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?> 
<form id="frm1" method="post" enctype="multipart/form-data" action="/Configuracion_General/Usuario_Mantenimiento_Nuevo" onsubmit="return validar();" class="form-horizontal" >
    <div class="form-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Foto:</label>
                    <div class="col-sm-9">
                        <label class="control-label">Foto para la cuenta</label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="files/imagenes/foto_usuario/<?php echo $GLOBALS['oUsuario']->foto;?>" data-src="holder.js/100%x100%/blankon/text:Fluid image" alt="...">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" data-trigger="fileinput" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                                <span class="btn btn-info btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="foto"></span>
                                <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                        <label>Persona:<span class="asterisk">*</span></label>
                    </div>
                    <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                       <select id="selPersona" name="selPersona" class="chosen-select">
                            <option value="0">--Seleccionar--</option>
                             <?php foreach( $GLOBALS['dtPersona'] as $iPersona){?>
                            <option value="<?php echo $iPersona['ID']?>"><?php echo utf8_decode(strtoupper($iPersona['apellido_paterno']. " ".$iPersona['apellido_materno']." ".$iPersona['nombres']));?></option>
                             <?php }?>
                        </select>
                        <script>
                            $("#selPersona").val(<?php echo  $GLOBALS['oUsuario']->persona_ID;?>);
                        </script>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Usuario:</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtNombre" name="txtNombre" autocomplete="off" value="<?php echo $GLOBALS['oUsuario']->nombre;?>" class="form-control form-requerido">
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Contraseña:</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtPassword" name="txtPassword" autocomplete="off" value="<?php echo $GLOBALS['oUsuario']->password;?>" class="form-control form-requerido">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Correo:</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtCorreo" name="txtCorreo" autocomplete="off" value="<?php echo $GLOBALS['oUsuario']->correo;?>" class="form-control form-requerido">
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Estado:</label>
                    <div class="col-sm-9">
                        <select id="selEstado" name="selEstado" class="form-control form-requerido text-uppercase">
                            <option value="0">Seleccionar</option>
                            <?php foreach($GLOBALS['oUsuario']->dtEstado as $item1){?>
                            <option value="<?php echo $item1['ID']; ?>"><?php echo FormatTextView($item1['nombre']); ?></option>
                            <?php }?>
                        </select>
                        <script>
                            $("#selEstado").val(<?php echo  $GLOBALS['oUsuario']->estado_ID;?>);
                        </script>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success mr-5">
                <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                Guardar
            </button>
            <button  id="btnCancelar" name="btnCancelar" type="button" title="Salir" onclick="window_float_close_modal();" class="btn btn-danger">
                <img  alt="" src="/include/img/boton/cancel_14x14.png">
                Cancelar
            </button>
        </div>
        <div class="clearfix"></div>
    </div>

       
   
    </form>	
    <script type="text/javascript">
     //var cboPersona = newCbo('divPersona', 'txtPersona_ID', '/funcion/ajaxCbo_Persona', true);
     var validar=function(){
        var persona_ID=$("#selPersona").val();
        var nombre=$.trim($("#txtNombre").val());
        var contraseña=$.trim($("#txtPassword").val());
        var correo=$.trim($("#txtCorreo").val());
       
        var estado_ID=$("#selEstado").val();
        if(persona_ID==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS","Debe seleccionar una persona.","selPersona");
            return false;
        }
        if(nombre==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS","Debe registrar el nombre del usuario.","txtNombre");
            
            return false;
        }
        if(contraseña==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS","Debe registrar la contraseña.","txtPassword");
            
            return false;
        }
        if(correo==""){
            mensaje.advertencia("VALIDACIÓN DE DATOS","Debe registrar un correo.","txtCorreo");
            return false;
        }
        if(validarEmail(correo)==false){
            mensaje.advertencia("VALIDACIÓN DE DATOS","Debe registrar un correo.","txtCorreo");
            return false;
        }
    
        if(estado_ID==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS","Debe seleccionar un estado.","selEstado");
            return false;
        }
     }
    </script>
    <?php } ?>  
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
    
    <script type="text/javascript">
       $(document).ready(function(){
           toastem.success("<?php  echo $GLOBALS['mensaje']; ?>");
           
           setTimeout(function(){
             window_float_save_modal();  
           }, 1000);
       });

    </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
    
    <script type="text/javascript">
       $(document).ready(function(){
           mensaje.error("Ocurrió un error","<?php  echo $GLOBALS['mensaje']; ?>");
           
       });

    </script>
    <?php } ?>
   <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==0){ ?>
        <div class="float-mensaje">
             <?php  echo $GLOBALS['mensaje']; ?>
        </div>
        <div class="group-btn">
            <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
        </div>
    <?php } ?>
        
<?php } ?>