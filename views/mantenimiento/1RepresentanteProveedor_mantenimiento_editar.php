<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Modificar Representante Proveedor<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<?php } ?>

<?php

function fncTitleHead() { ?>Modificar reprentante proveedor<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>
<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
        <form id="form" method="POST" action="/Mantenimiento/RepresentanteProveedor_Mantenimiento_Editar/<?php echo $GLOBALS['oRepresentanteProveedor']->ID; ?>" onsubmit="return validar();">
<table width="692" height="217" border="0" align="center">
  <tr>
    <td width="91">Nombre:</td>
    <td width="271"><span  >
      <input id="txtNombre" name="txtNombre" type="text"autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteProveedor']->nombre; ?>" onkeypress="return soloLetras(event)"/>
    </span><samp style="color: red;">*</samp></td>
    <td width="74">Celular1:</td>
    <td width="238"><span  >
      <input id="txtCelular1" name="txtCelular1" type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteProveedor']->celular1; ?>" />
    </span></td>
    </tr>
  <tr>
    <td> Apellido:</td>
    <td><span >
      <input id="txtApellidos" name="txtApellidos" type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteProveedor']->apellidos; ?>"  onkeypress="return soloLetras(event)"/>
    </span><samp style="color: red;">*</samp> </td>
    <td>Celular2:</td>
    <td><span  >
      <input id="txtCelular2" name="txtCelular2" type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteProveedor']->celular2; ?>" />
    </span></td>
    </tr>
  <tr>
    <td>Dni:</td>
    <td><span  >
      <input id="txtDni" name="txtDni" type="text" autocomplete="off" maxlength="8" value="<?php echo $GLOBALS['oRepresentanteProveedor']->dni; ?>"  onkeypress="return solonumeros(event)"/>
    </span><samp style="color: red;">*</samp> </td>
    <td>Correo:</td>
    <td><span  >
      <input id="txtCorreo" name="txtCorreo" type="email" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteProveedor']->correo; ?>"/>
    </span> </td>
    </tr>
  <tr>
    <td height="35">Dirección:</td>
    <td><span >
      <input id="txtDireccion" name="txtDireccion" type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteProveedor']->direccion;?>"/>
    </span><samp style="color: red;">*</samp></td>
    <td>  
	  </td>
    </tr>
  <tr>
    <td height="56">Teléfono:</td>
    <td><span  >
      <input id="txtTelefono" name="txtTelefono" type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteProveedor']->telefono; ?>" />
    </span></td>
    <td>Proveedor:</td>
    <td>
      <select name="cboProveedor" id="cboProveedor" >
        <?php foreach ($GLOBALS['dtProveedor'] as $item) {?>
        <option value="<?php echo $item['ID'] ?>"
                            <?php if ($GLOBALS['oRepresentanteProveedor']->proveedor == $item['ID']) { echo "selected='selected'";} ?>> <?php echo $item['razon_social'] ?></option>
        <?php } ?>
        </select>
      <samp style="color: red;">*</samp>
	  </td>
    </tr>
</table>

       
            <div>
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
            var dni = $.trim($('#txtDni').val());
            var direccion = $.trim($('#txtDireccion').val());
          
            var proveedor = $.trim($('#cboProveedor').val());

            $('#divMensaje').html('');

            if (nombre== "") {
                $('#divMensaje').html('Ingrese un nombre válido.');
                $('#txtNombre').focus();
                return false;
            }
            if (apellidos == "") {
                $('#divMensaje').html('Ingrese apellidos.');
                $('#txtApellidos').focus();
                return false;
            }
           
            if (dni == "") {
                $('#divMensaje').html('Ingrese DNI válido.');
                $('#txtDni').focus();
                return false;
            }
			
		    if (dni.length != 8) {
                $('#divMensaje').html('Longitud  de DNI no es válido.');
                $('#txtDni').focus();
                return false;
            }
			
            if (direccion == "") {
                $('#divMensaje').html('Ingrese una dirección válida.');
                $('#txtDireccion').focus();
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
