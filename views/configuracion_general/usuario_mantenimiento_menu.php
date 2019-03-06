<?php		
	require ROOT_PATH."views/shared/content-float-modal.php";	
?>	
<?php function fncTitle(){?>
        Menu por usuario
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
 
<?php } ?>
                
<?php
    function fncTitleHead() { ?>
    <span class="glyphicon glyphicon-user"></span> Menu por usuario
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
    <?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?> 
 
    <form id="frm1" method="post" action="/Configuracion_General/Usuario_Mantenimiento_Menu/<?php echo $GLOBALS['oUsuario']->ID;?>" class="form-horizontal" >
        <div class="form-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Usuario:</label>
                        <div class="col-sm-9">
                            <input type="text" id="txtNombre" name="txtNombre" autocomplete="off" value="<?php echo $GLOBALS['oUsuario']->nombre;?>" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group">

                        <label class="col-sm-3 control-label">Empresa:</label>

                        <div class="col-sm-9">
                            <select id="selEmpresa" name="selEmpresa" class="form-control" onchange="fncSeleccionarModulo();">
                                <?php foreach($GLOBALS['oUsuario']->dtEmpresa as $item1){?>
                                <option value="<?php echo $item1['ID']?>"><?php echo utf8_encode($item1['nombre'])?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Módulo:</label>

                        <div class="col-sm-9">
                            <select id="selModulo" name="selModulo" class="form-control" onchange="cargarMenu();">
                                <?php foreach($GLOBALS['oUsuario']->dtModulo as $item){?>
                                <option value="<?php echo $item['ID']?>"><?php echo utf8_encode($item['nombre'])?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">Menú</div>
                        <div class="panel-body">
                            <div id="divMenus" class="col-xs-12 col-md-12 col-sm-12 col-lg-12" style="height:400px;overflow:auto;">

                            </div>
                        </div>
                    </div>
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
    $(document).ready(function(){
        cargarMenu();
    });
    
    var cargarMenu=function(){
        var usuario_ID=<?php echo $GLOBALS['oUsuario']->ID;?>;
        var modulo_ID=$("#selModulo").val();
        cargarValores1("Configuracion_General/ajaxExtraer_Menu_Modulo",usuario_ID,modulo_ID,function(resultado){
            console.log(resultado.html);
            $("#divMenus").html(resultado.html);
        });
    }
    var fncSeleccionarModulo=function(){
        var empresa_ID=$("#selEmpresa").val();
        cargarValores('/Configuracion_General/ajaxExtraerModuloEmpresa',empresa_ID,function(resultado){
            $("#selModulo").html(resultado.html);
        });
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