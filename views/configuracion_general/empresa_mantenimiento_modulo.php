<?php		
	require ROOT_PATH."views/shared/content-float.php";	
?>	
<?php function fncTitle(){?>
		Módulos
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
 
<?php } ?>
                
<?php
    function fncTitleHead() { ?>
    <span class="glyphicon glyphicon-briefcase"></span> Módulos
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
    <?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?> 
    <div class="panel panel-success">
        <form id="frm1" method="post" style="width:800px;" action="/Configuracion_General/Empresa_Mantenimiento_Modulo/<?php echo $GLOBALS['oEmpresa']->ID;?>" onsubmit="return validar();">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-xs-5 col-sm-5">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3>Módulos</h3>
                            </div>
                            <div id="divModuloLibre" class="panel-body" style="height:400px;overflow:auto;">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2" style="height:400px;padding-top:70px">
                        <h1><a title="Agregar" onclick="fncAgregar();" style="cursor:pointer;"><span class="glyphicon glyphicon-chevron-right"></span></a></h1>
                        <h1><a title="Quitar" onclick="fncQuitar();" style="cursor:pointer;"><span class="glyphicon glyphicon-chevron-left"></span></a></h1>
                    </div>
                    <div class="col-lg-5 col-md-5 col-xs-5 col-sm-5">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3>Módulos asignados</h3>
                            </div>
                            <div id="divModuloAsignado" class="panel-body" style="height:400px;overflow:auto;">
                                
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </form>	
       
    </div>
    <script type="text/javascript">
    var cargarmodulos=function(){
        var empresa_ID=<?php echo $GLOBALS['oEmpresa']->ID;?>;
        cargarValores('Configuracion_General/ajaxModulos',empresa_ID,function(resultado){
            $("#divModuloLibre").html(resultado.resultado);
        });
    }
    var cargarmodulosAsignados=function(){
        var empresa_ID=<?php echo $GLOBALS['oEmpresa']->ID;?>;
        cargarValores('Configuracion_General/ajaxModulosAsignados',empresa_ID,function(resultado){
            $("#divModuloAsignado").html(resultado.resultado);
        });
    }
    var fncAgregar=function(){
        var empresa_ID=<?php echo $GLOBALS['oEmpresa']->ID;?>;
        var modulos_ID="";
        var i=0;
        $("#divModuloLibre input").each(function(){
            if($(this).is(":checked")){
                if(i==0){
                    modulos_ID=this.id;
                }else{
                    modulos_ID=modulos_ID+"-"+this.id;
                }
                i++;
            }  
        });
        if(modulos_ID==""){
            toastem.error("No a seleccionado ningún módulo");
        }else{
            
            cargarValores1('Configuracion_General/ajaxAsignarModulosEmpresa',empresa_ID,modulos_ID,function(resultado){
                
                if(resultado.resultado==1){
                    toastem.success(resultado.mensaje);
                    cargarmodulos();
                    cargarmodulosAsignados();
                }else{
                    toastem.error(resultado.mensaje);
                }
            });
        }
    }
    var fncQuitar=function(){
        var empresa_ID=<?php echo $GLOBALS['oEmpresa']->ID;?>;
        var IDs="";
        var i=0;
        $("#divModuloAsignado input").each(function(){
            if($(this).is(":checked")){
                if(i==0){
                    IDs=this.id;
                }else{
                    IDs=IDs+"-"+this.id;
                }
                i++;
            }  
        });
        if(IDs==""){
            toastem.error("No a seleccionado ningún módulo");
        }else{
            
            cargarValores('Configuracion_General/ajaxQuitarModulosEmpresa',IDs,function(resultado){
                
                if(resultado.resultado==1){
                    toastem.success(resultado.mensaje);
                    cargarmodulos();
                    cargarmodulosAsignados();
                }else{
                    toastem.error(resultado.mensaje);
                }
            });
        }
    }
    $(document).ready(function(){
        cargarmodulos();
        cargarmodulosAsignados();
    });
       
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