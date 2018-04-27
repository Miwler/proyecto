<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Modificar Chofer<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
   
<?php } ?>

<?php

function fncTitleHead() { ?>Modificar Chofer<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>
<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
    <form id="form" method="POST" style="width:400px; height: 400px;" action="/Mantenimiento/Chofer_Mantenimiento_Editar/<?php echo $GLOBALS['oChofer']->ID; ?>" >
	
    <table width="400" height="300"  cellpadding="0" cellspacing="0" style="padding:0 10px;">
        <tr>
            <td rowspan="3"> <img src="/include/img/boton/chofer.jpg" title="Guardando" alt="Guardando" width="100"/></td>
            <td >D.N.I.:</td>
            <td><input id="txtDni" name="txtDni" type="text"  class="int obligatorio" required autocomplete="off" maxlength="8" value="<?php echo $GLOBALS['oChofer']->dni; ?>"/></td>

        </tr>
        <tr>
            
            <td>Nombres:</td>
            <td> <input id="txtNombre" name="txtNombre" type="text"autocomplete="off" required class="obligatorio" value="<?php echo FormatTextView($GLOBALS['oChofer']->nombres); ?>"  onkeypress="return soloLetras(event)"/></td>
        </tr>
      <tr>
            <td >Apellidos:</td>
            <td><input id="txtApellidos" name="txtApellidos" type="text" autocomplete="off" class="obligatorio" required value="<?php echo FormatTextView($GLOBALS['oChofer']->apellidos); ?>"  onkeypress="return soloLetras(event)"/></td>

      </tr>
       
        <tr>
        <td >Nro. Licencia Con.:</td>
        <td colspan="2"><input id="txtLicencia" name="txtLicencia" maxlength="9" type="text" autocomplete="off" value="<?php echo $GLOBALS['oChofer']->licencia_conducir; ?>"/></td>

      </tr>
        <tr>
            <td>Direccion:</td>
            <td colspan="2">
                <textarea id="txtDireccion" name="txtDireccion" style="width:202px;height: 50px;"><?php echo FormatTextView($GLOBALS['oChofer']->direccion); ?></textarea>
            </td>

        </tr>
        <tr>
            <td>Celular1:</td>
            <td colspan="2"> <input id="txtCelular1" name="txtCelular1" type="text" autocomplete="off" value="<?php echo $GLOBALS['oChofer']->celular1; ?>" maxlength="15" onkeypress="return solonumeros(event)"/></td>

        </tr>
      <tr>
        <td>Celular2:</td>
        <td colspan="2"><input id="txtCelular2" name="txtCelular2" type="text" autocomplete="off" value="<?php echo $GLOBALS['oChofer']->celular2; ?>" maxlength="15" onkeypress="return solonumeros(event)"/></td>
      </tr>

    </table>

          
    <div id="divMensaje" class="float-mensaje">        
        <?php echo $GLOBALS['mensaje']; ?>
    </div>  
    <div class="tool-boton" style ="text-align:left;">                            
        <div class="btn">                                  
            <button  id="btnEnviar" name="btnEnviar" class="botonVentanas" >
                <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                Guardar
            </button>
            <button  id="btnCancelar" name="btnCancelar" class="botonVentanas" type="button" onclick="window_float_close();" >
                <img title="Guardar" alt="" src="/include/img/boton/cancel_14x14.png">
                Cancelar
            </button>                                                          
        </div>    
        <div class="btnEnviando" style="display:none;">         
            <button type="button">
                <img src="/include/img/boton/boton-loader_14x14.gif" title="Guardando" alt="Guardando" /> Enviando
            </button>     
        </div>                                    
    </div>
           
</form>

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

        //funcion para solo numeros
        function solonumeros(e) {
            tecla = (document.all) ? e.keyCode : e.which;

            //Tecla de retroceso para borrar, siempre la permite
            if (tecla == 8) {
                return true;
            }

            // Patron de entrada, en este caso solo acepta numeros
            patron = /[0-9]/;
            tecla_final = String.fromCharCode(tecla);
            return patron.test(tecla_final);
        }
        
        //ingreso de datos obligatorios
        var validar = function () {
                var nombre = $.trim($('#txtNombre').val());
                var apellidos = $.trim($('#txtApellidos').val());
                
                
                $('#divMensaje').html('');

                if (nombre=="") {
                    $('#divMensaje').html('Ingrese un nombre válido.');
                    $('#txtNombre').focus();
                    return false;
                }
                if (apellidos=="") {
                    $('#divMensaje').html('Ingrese un apellido válido.');
                    $('#txtApellidos').focus();
                    return false;
                }
                
            }
    </script>

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

    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -3) { ?>
        <div style="width:400px;margin:0 auto;">
            <div class="float-mensaje">
                <?php echo $GLOBALS['mensaje']; ?>
            </div>
            <div class="tool-btn" style ="text-align:center;">  
                <button  id="btnCancelar" name="btnCancelar" type="button" onclick="window_float_save();" >
                    <img title="Guardar" src='/include/img/boton/back_16x16.png' />
                    Regresar
                </button>      
            </div>
        </div>
    <?php } ?>
<?php } ?>
