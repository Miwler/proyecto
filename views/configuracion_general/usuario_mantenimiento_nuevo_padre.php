<?php		
	require ROOT_PATH."views/shared/content-float-modal.php";	
?>	
<?php function fncTitle(){?>
		Nuevo usuario
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
<!-- START @PAGE LEVEL STYLES -->
        <link href="../../../assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css" rel="stylesheet">
        <link href="../../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css" rel="stylesheet">
<!--/ END PAGE LEVEL STYLES -->
        <!-- START @PAGE LEVEL PLUGINS -->
        <script src="../../../assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/holderjs/holder.js"></script>
        <script src="../../../assets/global/plugins/bower_components/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/jquery-autosize/jquery.autosize.min.js"></script>
        <script src="../../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js"></script>
        <!--/ END PAGE LEVEL PLUGINS -->
<?php } ?>
                
<?php
    function fncTitleHead() { ?>
    <span class="glyphicon glyphicon-user"></span> Nuevo usuario
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1||$GLOBALS['resultado']==1){ ?> 
<form id="frm1" method="post" enctype="multipart/form-data" action="/Configuracion_General/Usuario_Mantenimiento_Nuevo" onsubmit="return validar();" class="form-horizontal" >
    <div class="panel panel-tab rounded shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs responsive-tabs">
                <li class="nav-item active"><a data-toggle="tab" href="#divDatos" class="nav-link"><i class="fa fa-user" aria-hidden="true"></i><span> Datos</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divPerfil" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i><span> Perfil</span></a></li>
                <li class="nav-item"><a data-toggle="tab" href="#divMenu" class="nav-link"><i class="fa fa-tasks" aria-hidden="true"></i><span> Menú</span></a></li>
            </ul>
        </div>
        <div class="panel-body no-padding rounded-bottom" style="height: 520px;overflow:auto;">
            <div class="tab-content" >
                <div id="divDatos" class="tab-pane fade in active inner-all">
                    <div class="form-group">
                        <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                            <label>Persona:<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                           <select id="selPersona" name="selPersona" class="chosen-select">
                                <option value="0">--Seleccionar--</option>
                                 <?php foreach( $GLOBALS['dtPersona'] as $iPersona){?>
                                <option value="<?php echo $iPersona['ID']?>"><?php echo FormatTextView(strtoupper($iPersona['apellido_paterno']. " ".$iPersona['apellido_materno']." ".$iPersona['nombres']));?></option>
                                 <?php }?>
                            </select>
                            <script>
                                $("#selPersona").val(<?php echo  $GLOBALS['oUsuario']->persona_ID;?>);
                            </script>
                        </div>
                    </div>
                    <div class="form-group">

                        <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                            <label>Usuario:</label>
                        </div>
                        <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                            <input type="text" id="txtNombre" name="txtNombre" value="<?php echo $GLOBALS['oUsuario']->nombre;?>" class="form-control form-requerido">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                            <label>Foto:</label>
                        </div>
                        <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
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
                    <div class="form-group">
                        <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                            <label>Contraseña:<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                            <input type="text" id="txtPassword" name="txtPassword" value="<?php echo $GLOBALS['oUsuario']->password;?>" class="form-control form-requerido">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                            <label>Correo:<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                            <input type="text" id="txtCorreo" name="txtCorreo" value="<?php echo $GLOBALS['oUsuario']->correo;?>" class="form-control form-requerido">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                            <label>Estado:<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
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
                <div id="divPerfil" class="tab-pane fade inner-all">
                    <div class="form-group">
                        <label class="col-xs-3 col-md-3 col-sm-3 col-lg-3 control-label">Empresa</label>
                        <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                            <select id="selEmpresa" name="selEmpresa" class="form-control">
                                <option value="0">Seleccionar</option>
                                <?php foreach($GLOBALS['oUsuario']->dtEmpresa as $iEmpresa){ ?>
                                <option value="<?php echo $iEmpresa['ID']?>" ><?php echo FormatTextView($iEmpresa['nombre'])?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 col-md-3 col-sm-3 col-lg-3 control-label">Perfil</label>
                        <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                            <select id="selPeril" name="selPeril" class="form-control">
                                <option value="-1">Seleccionar</option>
                                <?php foreach($GLOBALS['oUsuario']->dtPerfil as $iPerfil){ ?>
                                <option value="<?php echo $iPerfil['ID']?>" ><?php echo FormatTextView($iPerfil['nombre'])?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                            <a class="btn btn-info" title="Agregar" onclick="fncAgregarPerfil();">Agregar</a>
                            <input type="hidden" id="txtCodigo" name="txtCodigo" value="<?php echo $GLOBALS['oUsuario']->ID;?>">
                        </div>
                    </div>
                    <div class="form-group" id="tabla">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Nro</th><th>Empresa</th><th>Perfil</th><th>Opción</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div id="divMenu" class="tab-pane fade inner-all">
                    
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="pull-left">
                <button  id="btnEnviar" name="btnEnviar" class="btn btn-success mr-5">
                    <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                    Guardar
                </button>
                <button  id="btnCancelar" name="btnCancelar" type="button" title="Salir" onclick="window_float_close();" class="btn btn-danger">
                    <img  alt="" src="/include/img/boton/cancel_14x14.png">
                    Cancelar
                </button>
            </div>
            <div class="clearfix"></div>
        </div>
       
       
    </div>
    </form>	
    <script type="text/javascript">
     //var cboPersona = newCbo('divPersona', 'txtPersona_ID', '/funcion/ajaxCbo_Persona', true);
     var validar=function(){
        var persona_ID=$("#selPersona").val();
        var nombre=$.trim($("#txtNombre").val());
        var contraseña=$.trim($("#txtPassword").val());
        var correo=$.trim($("#txtCorreo").val());
        var perfil_ID=$("#selPerfil").val();
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
        if(perfil_ID==-1){
            mensaje.advertencia("VALIDACIÓN DE DATOS","Debe seleccionar un perfil.","selPerfil");
            return false;
        }
        if(estado_ID==0){
            mensaje.advertencia("VALIDACIÓN DE DATOS","Debe seleccionar un estado.","selEstado");
            return false;
        }
     }
     var fncAgregarPerfil=function(){
         var empresa_ID=$("#selEmpresa").val();
         var perfil_ID=$("#selPerfil").val();
         var usuario_ID=$("#txtCodigo").val();
         if(usuario_ID>0&& perfil_ID>-1 &&empresa_ID>0){
             cargarValores2("configuracion_general/ajaxAgregarUsuario_Perfil",usuario_ID,perfil_ID,empresa_ID,function(resultado){
                 
             });
         }else{
             mensaje.error("ERROR", "Ocurrió un error.");
         }
         
     }
    </script>
    <?php } ?>  
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
    
    <script type="text/javascript">
       $(document).ready(function(){
           toastem.success("<?php  echo $GLOBALS['mensaje']; ?>");
           setTimeout(' window_float_save_modal();', 1000);
       });

    </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
    
    <script type="text/javascript">
       $(document).ready(function(){
           toastem.error("<?php  echo $GLOBALS['mensaje']; ?>");
           
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