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
 
    <form id="frm1" method="post" action="/Configuracion_General/Usuario_Mantenimiento_Reporte/<?php echo $GLOBALS['oUsuario']->ID;?>" class="form-horizontal" >
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
                            <select id="selEmpresa" name="selEmpresa" class="form-control" onchange="cargarReportes();">
                                <?php foreach($GLOBALS['oUsuario']->dtEmpresa as $item1){?>
                                <option value="<?php echo $item1['ID']?>"><?php echo ($item1['nombre'])?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">Reportes</div>
                        <div class="panel-body">
                            <div id="divReportes" class="col-xs-12 col-md-12 col-sm-12 col-lg-12" style="height:400px;overflow:auto;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
            <div class="form-footer">
                <div class="pull-left">
                    <button type="button"  id="btnEnviar" name="btnEnviar" class="btn btn-success" onclick="Grabar();">
                            <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                            Guardar
                        </button>
                        <button  id="btnCancelar" name="btnCancelar" type="button" title="Salir" onclick="window_float_close_modal();" class="btn btn-danger">
                            <img  alt="" src="/include/img/boton/cancel_14x14.png">
                            Cerrar
                        </button>
                </div>
                <div class="clearfix"></div>
            </div>
    </form>	
       
   
    <script type="text/javascript">
    $(document).ready(function(){
        cargarReportes();
    });
    
    var cargarReportes=function(){
        var usuario_ID=<?php echo $GLOBALS['oUsuario']->ID;?>;
        var empresa_ID=$("#selEmpresa").val();
        block_ui(function(){
            $("#divReportes").html("");
            cargarValores1("Configuracion_General/ajaxExtraer_Reportes_Empresa",usuario_ID,empresa_ID,function(resultado){
                $.unblockUI();
                $("#divReportes").html(resultado.html);
            });
        });
        
    }
    
    function Grabar(){
        var lista_reportes="";
        var i=0;
        $("#divReportes input:checkbox:checked").each(function(){
            if(i==0){
                lista_reportes=this.id;
            }else{
                lista_reportes=lista_reportes+','+this.id;
            }
            i++;
        });
        
        var usuario_ID="<?php echo $GLOBALS['oUsuario']->ID;?>";
        
        if(usuario_ID!=""|| usuario_ID!=0){
            var object=new Object();
            object['lista_reportes']=lista_reportes;
            object['usuario_ID']=usuario_ID;
            
                block_ui(function(){
                    enviarAjaxParse('Configuracion_General/ajaxGrabarReportes_Usuario','frm',object,function(resul){
                        $.unblockUI();
                    if(resul.resultado==1){
                        toastem.success(resul.mensaje);
                    }else{
                        mensaje.error("Ocurrió un error",resul.mensaje);
                    }
                });
            });
            
        }
        else{
             mensaje.error("Ocurrió un error","Debe seleccionar un usuario");
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