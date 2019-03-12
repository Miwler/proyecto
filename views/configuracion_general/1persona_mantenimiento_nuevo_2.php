<?php		
	require ROOT_PATH."views/shared/content-float.php";	
?>	
<?php function fncTitle(){?>
		Nuevo usuario
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
 
<?php } ?>
                
<?php
    function fncTitleHead() { ?>
    <span class="glyphicon glyphicon-user"></span> Nuevo usuario
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
    <?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?> 
    <div class="panel panel-success">
        <form id="frm1" name="frm1" method="post" action="/Configuracion_General/Usuario_Mantenimiento_Nuevo" onsubmit="return validar();">
            <div class="panel-body">
            <center>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Persona:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <input type="text" id="txtPersona_ID" class="form-control form-requerido" >
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Usuario:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <input type="text" id="txtNombre" name="txtNombre" value="<?php echo $GLOBALS['oUsuario']->nombre;?>" class="form-control form-requerido">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Contraseña:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <input type="text" id="txtPassword" name="txtPassword" value="<?php echo $GLOBALS['oUsuario']->password;?>" class="form-control form-requerido">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Perfil:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <select id="selPerfil" name="selPerfil" class="form-control form-requerido text-uppercase">
                        <option value="0">Seleccionar</option>
                        <?php foreach($GLOBALS['oUsuario']->dtPerfil as $item){?>
                        <option value="<?php echo $item['ID']; ?>"><?php echo FormatTextView($item['nombre']); ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Estado:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <select id="selEstado" name="selEstado" class="form-control form-requerido text-uppercase">
                        <option value="0">Seleccionar</option>
                        <?php foreach($GLOBALS['oUsuario']->dtEstado as $item1){?>
                        <option value="<?php echo $item1['ID']; ?>"><?php echo FormatTextView($item1['nombre']); ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        
            </center>
                
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button  id="btnEnviar" name="btnEnviar" class="btn btn-success">
                            <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                            Guardar
                        </button>
                        <button  id="btnCancelar" name="btnCancelar" type="button" title="Salir" onclick="window_float_close();" class="btn btn-danger">
                            <img  alt="" src="/include/img/boton/cancel_14x14.png">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </form>	
       
    </div>
    <script type="text/javascript">
     var cboPersona = newCbo('divPersona', 'txtPersona_ID', '/funcion/ajaxCbo_Persona', true);
     var validar=function(){
        var persona_ID=$.trim($("#sendtxtPersona_ID").val());
        var nombre=$.trim($("#txtNombre").val());
        var contraseña=$.trim($("#txtPassword").val());
        var perfil_ID=$("#selPerfil").val();
        var estado_ID=$("#selEstado").val();
        if(persona_ID==""){
            toastem.error("Debe seleccionar una persona.");
            return false;
        }
        if(nombre==""){
            toastem.error("Debe registrar el nombre del usuario.");
            $("#txtNombre").focus();
            return false;
        }
        if(contraseña==""){
            toastem.error("Debe registrar la contraseña.");
            $("#txtPassword").focus();
            return false;
        }
        if(perfil_ID==0){
            toastem.error("Debe seleccionar un perfil.");
            $("#selPerfil").focus();
            return false;
        }
        if(estado_ID==0){
            toastem.error("Debe seleccionar un estado.");
            $("#selEstado").focus();
            return false;
        }
     }
    </script>
    <?php } ?>  
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
    
    <script type="text/javascript">
       $(document).ready(function(){
           toastem.success("<?php  echo $GLOBALS['mensaje']; ?>");
           setTimeout('window_float_save();', 1000);
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