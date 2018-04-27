<?php		
	require ROOT_PATH."views/shared/content-float.php";	
?>	
<?php function fncTitle(){?>
		Nuevo Menú
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
 
<?php } ?>
                
<?php
    function fncTitleHead() { ?>
    <span class="glyphicon glyphicon-align-left"></span> Nuevo Menú
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
    <?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?> 
    <div class="panel panel-success">
        <form id="frm1" name="frm1" method="post" action="/Configuracion_General/Menu_Mantenimiento_Nuevo" onsubmit="return validar();">
            <div class="panel-body">
            <center>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Nombre:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <input type="text" id="txtNombre" name="txtNombre" autocomplete="off" class="form-control form-requerido" value="<?php echo $GLOBALS['oMenu']->nombre;?>" >
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>url:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <input type="text" id="txtURL" name="txtURL" autocomplete="off" value="<?php echo $GLOBALS['oMenu']->url;?>" class="form-control form-requerido">
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Módulo:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <select id="selModulo" name="selModulo" class="form-control form-requerido text-uppercase" onchange="fncMenu_Padre(this.value);">
                        <option value="0">Seleccionar</option>
                        <?php foreach($GLOBALS['oMenu']->dtModulo as $item){?>
                        <option value="<?php echo $item['ID']; ?>"><?php echo FormatTextView($item['nombre']); ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Menú padre:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <select id="selMenu_Padre" name="selMenu_Padre" class="form-control form-requerido text-uppercase">
                        <option value="0">Ninguno</option>
                        
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Orden:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <input type="number" id="txtOrden" name="txtOrden" autocomplete="off" class="form-control" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 text-right">
                    <label>Descripción:</label>
                </div>
                <div class="col-xs-9 col-md-9 col-sm-9 col-lg-9">
                    <input type="text" id="txtDescripcion" name="txtDescripcion" autocomplete="off" class="form-control" >
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
    
     var validar=function(){
        
        var nombre=$.trim($("#txtNombre").val());
        var url=$.trim($("#txtURL").val());
        var modulo_ID=$("#selModulo").val();
        
        
        if(nombre==""){
            toastem.error("Debe registrar el nombre del usuario.");
            $("#txtNombre").focus();
            return false;
        }
        if(url==""){
            toastem.error("Debe registrar el url.");
            $("#txtURL").focus();
            return false;
        }
        if(modulo_ID==0){
            toastem.error("Debe seleccionar un módulo.");
            $("#selModulo").focus();
            return false;
        }
        
     }
     var fncMenu_Padre=function(modulo_ID){
         
        cargarValores('configuracion_general/ajaxExtraer_Menu_Modulo1',modulo_ID,function(resultado){
            $("#selMenu_Padre").html(resultado.html);
        });
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