<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Modificar Representante Cliente<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
   <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>

<?php

function fncTitleHead() { ?>Modificar reprentante cliente<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>
<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
       
<form id="form" method="POST" style="width:620px; height: 320px;" action="/Mantenimiento/RepresentanteCliente_Mantenimiento_Editar/<?php echo $GLOBALS['oRepresentanteCliente']->ID; ?>" onsubmit="return validar();">
<table width="620" height="256" border="0" align="center" style="padding: 0 10px;">
    <tr>
        
    </tr>
  <tr>
        <td rowspan="2">
            <img  alt="" src="/include/img/boton/contacto.jpg" width="80">
        </td>
        <td>
            Codigo:
        </td>
      <td> 
          <input id="txtCodigo" name="txtCodigo" type="text" disabled autocomplete="off" maxlength="8" style="width:100px;" value="<?php echo $GLOBALS['oRepresentanteCliente']->codigo; ?>" />
      </td>
       <td>Apellidos:</td>  
    <td>  <input id="txtApellidos" name="txtApellidos" required type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteCliente']->apellidos; ?> " onkeypress="return soloLetras(event)"/>
      <samp style="color: red;">*</samp></td>
       
    </tr>
  <tr>
      <td>
            DNI:
        </td>
        <td> 
            <input id="txtDni" name="txtDni" type="text" autocomplete="off" minlength="8" maxlength="8" style="width:100px;" value="<?php echo $GLOBALS['oRepresentanteCliente']->dni; ?>" onkeypress="return solonumeros(event)"/>
      
        </td>
    <td>
        Nombres:
    </td>
    <td>
        <input id="txtNombre" name="txtNombre" type="text" required autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteCliente']->nombres; ?>"  onkeypress="return soloLetras(event)"/>
      <samp style="color: red;">*</samp>
    </td>
   
    </tr>
  <tr>
   <td>Correo:</td>
    <td colspan="2"> 
      <input id="txtCorreo" name="txtCorreo" type="email" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteCliente']->correo; ?> "/>
       </td>
     <td>Cargo:</td>
    <td> 
      <input id="txtCargo" name="txtCargo" type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteCliente']->cargo; ?>"/>
       </td>
  </tr>
  <tr>
     <td>Teléfono:</td>
    <td colspan="2">
      <input id="txtTelefono" name="txtTelefono" type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteCliente']->telefono; ?>" />
    </td>
   <td>Cliente:</td>
    <td>
        <select id="cboCliente" name="cboCliente" >
            <option value="0">--</option>
          <?php foreach ($GLOBALS['dtCliente'] as $item) {?>
          <option value="<?php echo $item['ID'] ?>"> <?php echo $item['razon_social'] ?></option>
          <?php } ?>
        </select>
        
      <samp style="color: red;">*</samp>
      <script>
          $('#cboCliente').val(<?php echo $GLOBALS['oRepresentanteCliente']->cliente;?>);
      </script>
    </td>
    </tr>
  <tr>
     <td>Celular1:</td>
     <td colspan="2"> 
      <input id="txtCelular1" name="txtCelular1" type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteCliente']->celular1; ?>" />
     </td>
     <td>Celular2:</td>
    <td > 
      <input id="txtCelular2" name="txtCelular2" type="text" autocomplete="off" value="<?php echo $GLOBALS['oRepresentanteCliente']->celular2; ?>" />
     </td>
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
           
            // var direccion = $.trim($('#txtDireccion').val());
            
            var cliente = $.trim($('#cboCliente').val());

            $('#divMensaje').html('');

            if (nombre == "") {
                $('#divMensaje').html('Ingrese un nombre válido.');
                $('#txtNombre').focus();
                return false;
            }
            if (apellidos == "") {
                $('#divMensaje').html('Ingrese apellidos.');
                $('#txtApellidos').focus();
                return false;
            }
           
            
			
			if (dni.length != 8) {
                $('#divMensaje').html('Longitud  de DNI no es válido.');
                $('#txtDni').focus();
                return false;
            }
			
            // if (direccion == "") {
                // $('#divMensaje').html('Ingrese una dirección válida.');
                // $('#txtDirección').focus();
                // return false;
            // }
            
            $('#txtNombre').focus();
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
