<?php		
	require ROOT_PATH."views/shared/content-float-modal.php";	
?>	
<?php function fncTitle(){?>
		ASIGNAR PERFIL
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <!-- START @PAGE LEVEL STYLES -->
        <link href="../../assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="../../assets/global/plugins/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="../../assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet">
        <link href="../../assets/global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css" rel="stylesheet">
        <link href="../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.min.css" rel="stylesheet">
<!--/ END PAGE LEVEL STYLES -->
<!--/ END PAGE LEVEL STYLES -->
        <!-- START @PAGE LEVEL PLUGINS -->
        <script src="../../assets/global/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/jasny-bootstrap-fileinput/js/jasny-bootstrap.fileinput.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/holderjs/holder.js"></script>
        <script src="../../assets/global/plugins/bower_components/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/jquery-autosize/jquery.autosize.min.js"></script>
        <script src="../../assets/global/plugins/bower_components/chosen_v1.2.0/chosen.jquery.min.js"></script>
        <!--/ END PAGE LEVEL PLUGINS -->
<?php } ?>
                
<?php
    function fncTitleHead() { ?>
    <span class="glyphicon glyphicon-user"></span> ASIGNAR PERFIL
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?> 
<form id="frm1" method="post" enctype="multipart/form-data" action="/Configuracion_General/Usuario_Mantenimiento_Perfil/<?php echo $GLOBALS['oUsuario']->ID;?>" onsubmit="return validar();" class="form-horizontal" >
    <div class="form-body">
        <div class="form-group">
            <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12" style="overflow:auto;">
                <?php echo $GLOBALS['table'];?>
            </div>
        </div>

    </div>
    <div class="form-footer">
        <div class="pull-left">
            <button  id="btnEnviar" name="btnEnviar" class="btn btn-success">
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
           setTimeout('window_float_close_modal();', 1000);
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