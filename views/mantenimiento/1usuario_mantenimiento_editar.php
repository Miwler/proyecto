<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Modificar Usuarios<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="include/js/jDate.js"></script>
    <script type="text/javascript" src="include/js/jCboDiv.js"></script>
    <script type="text/javascript" src="include/js/jGrid.js"></script>
    <script type="text/javascript" src="include/js/jForm.js"></script>

    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="include/css/date.css" />
    <link rel="stylesheet" type="text/css" href="include/css/cboDiv.css" />
    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>

<?php

function fncTitleHead() { ?>Modificar Usuarios<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>
<?php

//onsubmit="return validar();"
function fncPage() {
    ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
        <br />
     <div align="center">  
      <form id="form" method="POST" action="/Mantenimiento/Usuario_Mantenimiento_Editar/<?php echo $GLOBALS['oUsuario']->ID; ?>"  onsubmit="return validar();">
<table width="758" height="281" border="0" align="center">
  <tr>
    <td width="134">Nombres: </td>
    <td width="229"><span>
      <input id="txtNombre" name="txtNombre" type="text"autocomplete="off" value="<?php echo $GLOBALS['oOperador']->nombre; ?>"  onkeypress="return soloLetras(event)"/>
    <samp style="color: red;">*</samp></span></td>
    <td width="143">Correo:</td>
    <td width="224"><span>
      <input id="txtCorreo" name="txtCorreo" type="email" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->mail; ?>"/>
      <samp style="color: red;">*</samp></span></td>
    </tr>
  <tr>
    <td>Apellidos Paterno:</td>
    <td><span>
      <input id="txtApellido_Paterno" name="txtApellido_Paterno" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->apellidos_paternos; ?>" onkeypress="return soloLetras(event)"/>
    <samp style="color: red;">*</samp></span></td>
    <td>Comisión:</td>
    <td><span>
      <input id="txtComision" name="txtComision" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->comision; ?>" onkeypress="return numeroDecimal(event)"/>
      <samp style="color: red;">*</samp></span></td>
    </tr>
  <tr>
    <td height="28">Apellidos Materno
      :</td>
    <td><span>
      <input id="txtApellido_Materno" name="txtApellido_Materno" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->apellidos_maternos; ?>" onkeypress="return soloLetras(event)"/>
    <samp style="color: red;">*</samp></span></td>
    <td>Estado civil: </td>
    <td><span>
      <select name="cboEstado_Civil">
        <option value="Soltero(a)"<?php
                            if ("Soltero(a)" == $GLOBALS['oOperador']->estado_civil) {
                                echo "selected='selected'";
                            };
                            ?>>Soltero(a)</option>
        <option value="Casado(a)"<?php
                            if ("Casado(a)" == $GLOBALS['oOperador']->estado_civil) {
                                echo "selected='selected'";
                            };
                            ?>>Casado(a)</option>
        <option value="Divorciado(a)"<?php
                            if ("Divorciado(a)" == $GLOBALS['oOperador']->estado_civil) {
                                echo "selected='selected'";
                            };
                            ?>>Divorciado(a)</option>
        <option value="Viudo(a)"<?php
                            if ("Viudo(a)" == $GLOBALS['oOperador']->estado_civil) {
                                echo "selected='selected'";
                            };
                            ?>>Viudo(a)</option>
        <option value="Otro"<?php
                            if ("Otro" == $GLOBALS['oOperador']->estado_civil) {
                                echo "selected='selected'";
                            };
                            ?>>Otro</option>
        </select>
      <samp style="color: red;">*</samp></span></td>
    </tr>
  <tr>
    <td>Direción:</td>
    <td><span>
      <input id="txtDireccion" name="txtDireccion" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->direccion; ?>"/>
    <samp style="color: red;">*</samp></span></td>
    <td>Cuenta:</td>
    <td><span>
      <input id="txtCuenta" name="txtCuenta" type="text" autocomplete="off" value="<?php echo $GLOBALS['oUsuario']->nombre; ?>"/>
      <samp style="color: red;">*</samp></span></td>
    </tr>
  <tr>
    <td>Dni:</td>
    <td><span>
      <input id="txtDni" name="txtDni" type="text" autocomplete="off" maxlength="8" value="<?php echo $GLOBALS['oOperador']->dni; ?>" onkeypress="return solonumeros(event)"/>
    <samp style="color: red;">*</samp></span></td>
    <td>Contraseña:</td>
    <td><span>
      <input id="txtPassword" name="txtPassword" type="text" autocomplete="off" value="<?php echo $GLOBALS['oUsuario']->password; ?>"/>
      <samp style="color: red;">*</samp></span></td>
    </tr>
  <tr>
    <td>Fecha de Nacimiento:</td>
    <td><span>
      <input id="txtFecha_Nacimiento" name="txtFecha_Nacimiento" type="text" class="date" autocomplete="off" value="<?php echo date("d/m/Y", strtotime($GLOBALS['oOperador']->fecha_nacimiento)); ?>"/>
    <samp style="color: red;">*</samp></span></td>
    <td>Perfil:</td>
    <td><span >
      <select name="txtPerfil_ID">
        <?php foreach ($GLOBALS['dtPerfil'] as $dtperfil){?>
        <option value="<?php echo $dtperfil['ID']?>" <?php 
                                if ($GLOBALS['oUsuario']->perfile_ID == $dtperfil['ID']) {
                                echo "selected='selected'";
                            };
                                ?>><?php echo $dtperfil['nombre']?></option>
        <?php };?>
        </select>
      <samp style="color: red;">*</samp></span></td>
    </tr>
  <tr>
    <td>Telefono:</td>
    <td><span>
      <input id="txtTelefono" name="txtTelefono" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->telefono; ?>" onkeypress="return solonumeros(event)"/>
    </span></td>
    <td>sexo:</td>
    <td><span>
      <select name="cboSexo">
        <option value="Femenino"<?php
                            if ("Femenino" == $GLOBALS['oOperador']->sexo) {
                                echo "selected='selected'";
                            };
                            ?>>Femenino</option>
        <option value="Masculino"<?php
                            if ("Masculino" == $GLOBALS['oOperador']->sexo) {
                                echo "selected='selected'";
                            };
                            ?>>Masculino</option>
        </select>
      <samp style="color: red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*</samp></span></td>
    </tr>
  <tr>
    <td>Rpc:</td>
    <td><span>
      <input id="txtRpc" name="txtRpc" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->rpc; ?>" onkeypress="return solonumeros(event)"/>
    </span></td>
    <td>Fecha de Contrato:</td>
    <td><span>
      <input id="txtFecha_Contrato" name="txtFecha_Contrato" type="text" class="date" autocomplete="off" value="<?php echo date("d/m/Y", strtotime($GLOBALS['oOperador']->fecha_contrato)); ?>"/>
      <samp style="color: red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;*</samp></span></td>
    </tr>
  <tr>
    <td>Rpm:</td>
    <td><span>
      <input id="txtRpm" name="txtRpm" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->rpm; ?>" onkeypress="return solonumeros(event)"/>
    </span></td>
   <td>Cargo</td>
    <td>
	  <select id="selCargo" name="selCargo">
		<option value="0">SELECCIONAR</option>
		<?php foreach($GLOBALS['dtCargo'] as $iCargo){ ?>
				<option value="<?php echo $iCargo['ID']; ?>"><?php echo FormatTextView($iCargo['nombre']); ?></option>
		<?php } ?>

	 </select>
	 <script type="text/javascript">
		$('#selCargo').val(<?php echo $GLOBALS['oOperador']->cargo_ID; ?>);
	 </script>
	</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
 
          <div style="margin-top:10px;">
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
     </div> 
     <br />
         <script type="text/javascript">
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

        //funcion para solo numeros decimal
        function numeroDecimal(e, field) {
            key = e.keyCode ? e.keyCode : e.which
            // backspace
            if (key == 8)
                return true
            // 0-9
            if (key > 47 && key < 58) {
                if (field.value == "")
                    return true
                regexp = /.[0-9]{2}$/
                return !(regexp.test(field.value))
            }
            // .
            if (key == 46) {
                if (field.value == "")
                    return false
                regexp = /^[0-9]+$/
                return regexp.test(field.value)
            }
            // other key
            return false
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

        var validar = function () {
            var nombre = $.trim($('#txtNombre').val());
            var apellido_paterno = $.trim($('#txtApellido_Paterno').val());
            var apellido_materno = $.trim($('#txtApellido_Materno').val());
            var direccion = $.trim($('#txtDireccion').val());
            var dni = $.trim($('#txtDni').val());
            var fecha_nacimiento = $.trim($('#txtFecha_Nacimiento').val());
            var correo = $.trim($('#txtCorreo').val());
            var comision = $.trim($('#txtComision').val());
            var cuenta = $.trim($('#txtCuenta').val());
            var password = $.trim($('#txtPassword').val());
            var perfil = $.trim($('#txtPerfil_ID').val());
            $('#divMensaje').html('');

            if (nombre == "") {
                $('#divMensaje').html('Ingrese un nombre válido.');
                $('#txtNombre').focus();
                return false;
            }
            if (apellido_paterno == "") {
                $('#divMensaje').html('Ingrese apellidos paterno.');
                $('#txtApellido_Paterno').focus();
                return false;
            }

            if (apellido_materno == "") {
                $('#divMensaje').html('Ingrese apellido maternos válido.');
                $('#txtApellido_Materno').focus();
                return false;
            }
            if (direccion == "") {
                $('#divMensaje').html('Ingrese una dirección válida.');
                $('#txtDireccion').focus();
                return false;
            }
            if (dni == "") {
                $('#divMensaje').html('Ingrese DNI válido.');
                $('#txtDni').focus();
                return false;
            }
            

            if (fecha_nacimiento == "") {
                $('#divMensaje').html('Ingrese fecha nacimiento válido.');
                $('#txtFecha_Nacimiento').focus();
                return false;
            }
            if (correo == "") {
                $('#divMensaje').html('Ingrese correo válido.');
                $('#txtEmail').focus();
                return false;
            }
            if (comision == "") {
                $('#divMensaje').html('Ingrese comision válido.');
                $('#txtComision').focus();
                return false;
            }
            if (cuenta == "") {
                $('#divMensaje').html('Ingrese cuenta válido.');
                $('#txtCuenta').focus();
                return false;
            }
            if (password == "") {
                $('#divMensaje').html('Ingrese contraseña válido.');
                $('#txtPassword').focus();
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
