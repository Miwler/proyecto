<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Nuevo Estado<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<?php } ?>

<?php

function fncTitleHead() { ?>Nuevo Estado<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
        <form id="form" method="POST" action="/Mantenimiento/Estado_Mantenimiento_Nuevo" onsubmit="return validar();">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 form-group"><label>Nombre:</label></div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 form-group"><input id="txtNombre" name="txtNombre" type="text"autocomplete="off" value="<?php echo $GLOBALS['oEstado']->nombre; ?>" onkeypress="return soloLetras(event)"/><samp style="color: red;">*</samp></div>

                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 form-group"><label>Tabla:</label></div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 form-group"><input id="txtTabla" name="txtTabla" type="text" autocomplete="off" value="<?php echo $GLOBALS['oEstado']->tabla; ?>"/><samp style="color: red;">*</samp></div>

                </div>
  </div>
             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px">
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
            </div>
        </form>
    <?php } ?>
 <script>
        function soloLetras(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            especiales = "8-37-39-46";

            tecla_especial = false
            for (var i in especiales) {
                if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                return false;
            }
        }
        var validar = function () {
                var nombre = $.trim($('#txtNombre').val());
                var tabla = $.trim($('#txtTabla').val());
                if (nombre=="") {
                    $('#divMensaje').html('Ingrese un nombre.');
                    $('#txtNombre').focus();
                    return false;
                }
                if (tabla=="") {
                    $('#divMensaje').html('Ingrese nombre de la tabla.');
                    $('#txtTabla').focus();
                    return false;
                }
            }
        
    </script>
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
