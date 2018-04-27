<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Asignacion de permisos de usuario<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<?php } ?>

<?php

function fncTitleHead() { ?>Asignacion de permisos de usuario<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
        <form id="form" method="POST" action="/Mantenimiento/Usuario_Mantenimiento_Permisos" onsubmit="return validar();">
            <div class="col-lg-12" style="margin-top:10px">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Usuario:</label>
                       <div id="divUsuario" class="input-content" >                           
                        </div>
                        <script type="text/javascript">
        <?php if ($GLOBALS['oUsuario']->ID == 0) { ?>
                                var cboUsuario = newCbo('divUsuario', 'txtUsuario_ID', '/Mantenimiento/ajaxCbo_Usuario', 150, true);
        <?php } else { ?>
                                var cboUsuario = cargarCbo('divUsuario', 'txtUsuario_ID', '/Mantenimiento/ajaxCbo_Usuario', 150, "", "", true);
        <?php } ?>
                        </script>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Permisos:</label>
                        <div id="divPermisos" class="input-content" >                           
                        </div>
                        <script type="text/javascript">
        <?php if ($GLOBALS['oUsuario']->ID == 0) { ?>
                                var cboPermisos = newCbo('divPermisos', 'txtPermisos_ID', '/Mantenimiento/ajaxCbo_Permisos', 150, true);
        <?php } else { ?>
                                var cboPermisos = cargarCbo('divPermisos', 'txtPermisos_ID', '/Mantenimiento/ajaxCbo_Permisos', 150, "", "", true);
        <?php } ?>
                        </script>
                    </div>
                </div>
</div> 
                <div id="divMensaje" class="float-mensaje">        
                    <?php echo $GLOBALS['mensaje']; ?>
                </div>    
                <div class="tool-btn" style ="text-align:right;">                     
                    <div class="btn">                                  
                        <button  id="btnEnviar" name="btnEnviar" >
                            <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                            Guardar
                        </button>
                        <button  id="btnCancelar" name="btnCancelar" type="button" onclick="window_float_close();" >
                            <img title="Guardar" alt="" src="/include/img/boton/cancel_14x14.png">
                            Cancelar
                        </button>                                                          
                    </div> 
                </div> 
            
        </form>
    <?php } ?>

    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <script type="text/javascript">

            setTimeout('window_float_save();', 1000);
        </script>
    <?php } ?>

    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 0) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <div class="group-btn">
            <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
        </div>
    <?php } ?>
<?php } ?>
