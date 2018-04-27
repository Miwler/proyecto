<?php		
	require ROOT_PATH."views/shared/content-float-hijo.php";	
?>	
<?php function fncTitle(){?>Lista de menú<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
<?php } ?>

<?php function fncTitleHead(){?>Lista de menú<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1"  method="post" action="pagina_web/web_menu_lista_configuracion_nuevo/<?php echo $GLOBALS['oWeb_Menu_Lista']->web_menu_ID; ?>" onsubmit="return validar();">
    <div class="panel panel-info">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                    <label class="text-right">Nombre:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" id="txtNombre" name="txtNombre" autocomplete="off" class="form-control form-requerido" > 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                    <label class="text-right">Ruta:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" id="txtRuta" name="txtRuta" autocomplete="off"  class="form-control form-requerido" > 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                    <label class="text-right">Padre:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <select id="selWeb_Menu_Lista" name="selWeb_Menu_Lista" class="form-control">
                        <option value="0">Ninguno</option>
                        <?php foreach($GLOBALS['oWeb_Menu_Lista']->dtWeb_Menu_Lista_Padre as $item){?>
                        <option value="<?php echo $item['ID'];?>"><?php echo $item['ID'].'-'. FormatTextView($item['nombre']);?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                    <label class="text-right">Orden:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="number" id="txtOrden" name="txtOrden" value="0" class="form-control" > 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                    <label class="text-right">Tabla:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input type="text" id="txtTabla" name="txtTabla" autocomplete="off"  class="form-control" > 
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button  id="btnEnviar" name="btnEnviar" class='btn btn-success' title="Guardar" >
                        <img alt="" width="16" src="/include/img/boton/save_48x48.png">
                        Guardar
                    </button>
                  
                    <button  id="btnCancelar" name="btnCancelar" type="button" class='btn btn-danger' title="Cancelar" onclick="window_deslizar_save();" >
                        <span class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">  
    var validar=function(){
        
       
        var nombre= $.trim($('#txtNombre').val());
        var ruta= $.trim($('#txtRuta').val());
        

        //Verifico si el comprobante requiere serie y número
        if(nombre==""){
            toastem.error('Registre un nombre.');
            $('#txtNombre').focus();
            return false;   
        }
        if(ruta==""){
            toastem.error('Registre una ruta del menú.');
            $('#txtRuta').focus();
            return false;   
        }
       
        			
    }
  
    </script>
    
 <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
            
        <script type="text/javascript">
        $(document).ready(function () {
            
            toastem.error('<?php echo $GLOBALS['mensaje']; ?>');
        });
        </script>
    <?php } ?>
    <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

    <script type="text/javascript">
     
     $(document).ready(function () {
            
        toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
    });
      setTimeout('window_deslizar_save();', 1000);
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
