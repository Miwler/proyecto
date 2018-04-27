<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Modificar Datos Generales<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
   <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>

<?php

function fncTitleHead() { ?>Modificar Datos Generales<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>
<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
        <form id="form" method="POST" style="width:900px;height: 500px;" action="/Mantenimiento/Datos_generales_Mantenimiento_Editar/<?php echo $GLOBALS['oDatos_generales']->ID; ?>" onsubmit="return validar();">
            <div class="col-lg-12" style="margin-top:10px">
       <table width="870" height="430"  cellpadding="0" cellspacing="0" style="margin:0 auto;">
  <tr>
    <td   width="190"> <label>Ruc:</label></td>
    <td width="250"><input id="txtRuc" name="txtRuc" type="text" maxlength="11" autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->ruc; ?>" onkeypress="return solonumeros(event)"/><samp style="color: red;">*</samp></td>
    <td width="190"><label>Mail_Info:</label></td>
    <td width="250"> <input id="txtMail_Info" name="txtMail_Info" type="email" required  autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->mail_info; ?>"/><samp style="color: red;">*</samp></td>
  </tr>
  <tr>
    <td><label>Razon Social:</label></td>
    <td><input id="txtRazon_Social" name="txtRazon_Social" type="text" autocomplete="off" value="<?php echo FormatTextViewHtml($GLOBALS['oDatos_generales']->razon_social); ?>"/><samp style="color: red;">*</samp></td>
    <td><label>Mail_Venta:</label></td>
    <td> <input id="txtMail_Venta" name="txtMail_Venta" type="email" required  autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->mail_venta; ?>"/><samp style="color: red;">*</samp></td>
  </tr>
  <tr>
    <td><label>Alias:</label></td>
    <td><input id="txtAlias" name="txtAlias" type="text"autocomplete="off" value="<?php echo FormatTextViewHtml($GLOBALS['oDatos_generales']->alias); ?>"/><samp style="color: red;">*</samp></td>
    <td><label>Pagina_Web:</label></td>
    <td><input id="txtPagina_Web" name="txtPagina_Web" type="text"autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->pagina_web; ?>"/><samp style="color: red;">*</samp></td>
  </tr>
  <tr>
    <td><label> Direccion:</label></td>
    <td><input id="txtDireccion" name="txtDireccion" type="text" autocomplete="off" value="<?php echo FormatTextViewHtml($GLOBALS['oDatos_generales']->direccion); ?>"/><samp style="color: red;">*</samp></td>
    <td><label> Telefono:</label></td>
    <td> <input id="txtTelefono" name="txtTelefono" type="text" autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->telefono; ?>"  /><samp style="color: red;">*</samp></td>
  </tr>
  <tr >
    <td><label> Direccion_Fiscal:</label></td>
    <td><input id="txtDireccion_Fiscal" name="txtDireccion_Fiscal" type="text" autocomplete="off" value="<?php echo FormatTextViewHtml($GLOBALS['oDatos_generales']->direccion_fiscal); ?>"/><samp style="color: red;">*</samp></td>
    <td><label> Rpc:</label></td>
    <td>  <input id="txtRpc" name="txtRpc" type="text" autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->rpc; ?>" /><samp style="color: red;">*</samp></td>
  </tr>
  <tr hidden>
    <td><label>Correlativo Guia:</label></td>
    <td><input  id="txtCorrelativo_Guia" name="txtCorrelativo_Guia" type="number" min="1"    autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->correlativo_guia; ?>"/><samp style="color: red;">*</samp></td>
    <td><label>Rpm:</label></td>
    <td><input id="txtRpm" name="txtRpm" type="text" autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->rpm; ?>" /><samp style="color: red;">*</samp></td>
  </tr>
  <tr hidden>
    <td><label>Correlativo Factura:</label></td>
    <td><input  id="txtCorrelativo_Factura" name="txtCorrelativo_Factura" type="number" min="1"   autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->correlativo_factura; ?>"/><samp style="color: red;">*</samp></td>
    <td><label>Nextel:</label></td>
    <td> <input id="txtNextel" name="txtNextel" type="text" autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->nextel; ?>" /><samp style="color: red;">*</samp></td>
  </tr>
  <tr>
    <td><label>Departamento:</label></td>
    <td>
        <select id="cboDepartamento" name="cboDepartamento" onchange="fncDepartamento();">
                <?php foreach($GLOBALS['dtDepartamento'] as $iDepartamento){
                        echo '<option value="'.$iDepartamento['ID'].'">'.$iDepartamento['nombre'].'</option>';
                } ?>
        </select>	
        <script type="text/javascript">
                $('#cboDepartamento').val(<?php echo $GLOBALS['departamento_ID']; ?>);
        </script><samp style="color: red;">*</samp>
	</td>
    <td><label>Otro_Operador:</label></td>
    <td><input id="txtOtro_Operador" name="txtOtro_Operador" type="text"autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->otro_operador; ?>"  /><samp style="color: red;">*</samp></td>
  </tr>
  
    <tr>
    <td><label>Provincia:</label></td>
    <td id="tdProvincia">
            <select id="cboProvincia" name="cboProvincia" onchange="fncProvincia();">
                    <?php foreach($GLOBALS['dtProvincia'] as $iProvincia){
                            echo '<option value="'.$iProvincia['ID'].'">'.$iProvincia['nombre'].'</option>';
                    } ?>
            </select>	
            <script type="text/javascript">
                    $('#cboProvincia').val(<?php echo $GLOBALS['provincia_ID']; ?>);
            </script>
	</td>
   <td><label> Logo_Extension:</label></td>
    <td> <input id="txtLogo_Extension" name="txtLogo_Extension" type="text" autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->logo_extension; ?>"/></td>
  </tr>
  
  <tr>
    <td><label> Distrito:</label></td>
    <td id="tdDistrito">
            <select id="cboDistrito" name="cboDistrito" onchange="fncDistrito();">
                    <?php foreach($GLOBALS['dtDistrito'] as $iDistrito){
                            echo '<option value="'.$iDistrito['ID'].'">'.$iDistrito['nombre'].'</option>';
                    } ?>
            </select>	
            <script type="text/javascript">
                    $('#cboDistrito').val(<?php echo $GLOBALS['distrito_ID']; ?>);
            </script>	
	</td>
    <td><label> Tipo_Cambio:</label></td>
    <td><input id="txtTipo_Cambio" name="txtTipo_Cambio" type="text" autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->tipo_cambio; ?>"  onkeypress="return numeroDecimal(event, this)" /><samp style="color: red;">*</samp></td>
  </tr>
  <tr>
    <td><label> Mail_Principal:</label></td>
    <td><input id="txtMail_Principal" name="txtMail_Principal" type="email" required  autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->mail_principal; ?>" /><samp style="color: red;">*</samp></td>
    <td><label> Vigv:</label></td>
    <td><input id="txtVigv" name="txtVigv" type="text" autocomplete="off" value="<?php echo $GLOBALS['oDatos_generales']->vigv; ?>"  onkeypress="return numeroDecimal4(event, this)" /><samp style="color: red;">*</samp></td>
  </tr>
  <tr>
      <td>Observación</td>
      <td colspan="3">
          <textarea id="txtObservacion" name="txtObservacion"  style="width: 560px;height: 50px;"><?php echo  FormatTextViewHtml($GLOBALS['oDatos_generales']->observacion); ?></textarea>

      </td>
  </tr>
  
</table>

    <div id="divMensaje" class="float-mensaje">        
        <?php echo $GLOBALS['mensaje']; ?>
    </div>
        <div class="tool-boton" style ="text-align:left;">                            
            <div class="btn">                                  
                <button  id="btnEnviar" name="btnEnviar" class="botonVentanas"  >
                    <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                    Guardar
                </button>
                <button  id="btnCancelar" name="btnCancelar" type="button" class="botonVentanas" onclick="window_float_close();" >
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

            </div>  
        </form>
		
		
		<script type="text/javascript">
		
		var fncDepartamento=function(){
				var obj = $('#cboDepartamento');
				ajaxSelect('tdProvincia', '/Mantenimiento/ajaxSelect_Provincia/' + obj.val(), '',fncProvincia);
			}
			
			var fncProvincia=function(){
				var obj = $('#cboProvincia');
				ajaxSelect('tdDistrito', '/Mantenimiento/ajaxSelect_Distrito/' + obj.val(), '',null);
			}
		
		
		</script>
		
    <?php } ?>
 <script>
 
 
        // function validarEmail(email) {
 			    // valor = document.getElementById("txtMail_Principal").value;
                    // if( !(/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/.test(valor)) ) {
                    // return false;
                      // }
          // }
 
 
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

		
		
        //funcion para solo numeros decimal con 2  decimales
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
		
		
		//funcion para solo numeros decimal con 4 decimales
        function numeroDecimal4(e, field) {
            key = e.keyCode ? e.keyCode : e.which
            // backspace
            if (key == 8)
                return true
            // 0-9
            if (key > 47 && key < 58) {
                if (field.value == "")
                    return true
                regexp = /.[0-9]{4}$/
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

        //ingreso de datos obligatorios
        var validar = function () {
            var ruc = $.trim($('#txtRuc').val());
			var mail_info = $.trim($('#txtMail_Info').val());
            var razon_social = $.trim($('#txtRazon_Social').val());
            var mail_venta = $.trim($('#txtMail_Venta').val());
			var alias = $.trim($('#txtAlias').val());
			var pagina_web = $.trim($('#txtPagina_Web').val());
			var direccion = $.trim($('#txtDireccion').val());
			var telefono = $.trim($('#txtTelefono').val());
            var direccion_fiscal = $.trim($('#txtDireccion_Fiscal').val());
            var rpc = $.trim($('#txtRpc').val());
            var correlativo_guia = $.trim($('#txtCorrelativo_Guia').val());
			var rpm = $.trim($('#txtRpm').val());
            var correlativo_factura = $.trim($('#txtCorrelativo_Factura').val());
			var nextel = $.trim($('#txtNextel').val());
			var otro_operador = $.trim($('#txtOtro_Operador').val());
			var logo_extension = $.trim($('#txtLogo_Extension').val());
			var distrito_ID = $.trim($('#cboDistrito').val());
			var tipo_cambio = $.trim($('#txtTipo_Cambio').val());
			var mail_principal = $.trim($('#txtMail_Principal').val());
            var vigv = $.trim($('#txtVigv').val());
            
            $('#divMensaje').html('');

            if (ruc == "") {
                $('#divMensaje').html('Ingrese ruc válido.');
                $('#txtRuc').focus();
                return false;
            }
            if (ruc.length != 11) {
                $('#divMensaje').html('Longitud  de ruc no es válido.');
                $('#txtRuc').focus();
                return false;
            }
			
			if (mail_info == "") {
                $('#divMensaje').html('Ingrese mail info válida.');
                $('#txtMail_Info').focus();
                return false;
            }
			
            if (razon_social == "") {
                $('#divMensaje').html('Ingrese razón social válida.');
                $('#txtRazon_Social').focus();
                return false;
            }
			
			if (mail_venta == "") {
                $('#divMensaje').html('Ingrese mail venta válida.');
                $('#txtMail_Venta').focus();
                return false;
            }
			
			
			if (alias == "") {
                $('#divMensaje').html('Ingrese alias válida.');
                $('#txtAlias').focus();
                return false;
            }
			
			
			if (pagina_web == "") {
                $('#divMensaje').html('Ingrese pagina web válida.');
                $('#txtPagina_Web').focus();
                return false;
            }
			
			
			if (direccion == "") {
                $('#divMensaje').html('Ingrese direccion válida.');
                $('#txtDireccion').focus();
                return false;
            }
			
			if (telefono == "") {
                $('#divMensaje').html('Ingrese telefono válido.');
                $('#txtTelefono').focus();
                return false;
            }
			
            
            if (direccion_fiscal == "") {
                $('#divMensaje').html('Ingrese direccion fiscal válido.');
                $('#txtDireccion_Fiscal').focus();
                return false;
            }
			
			if (rpc == "") {
                $('#divMensaje').html('Ingrese rpc válido.');
                $('#txtRpc').focus();
                return false;
            }
			
			
            if (correlativo_guia == "") {
                $('#divMensaje').html('Ingrese correlativo guia válido.');
                $('#txtCorrelativo_Guia').focus();
                return false;
            }
			
			
			if (rpm == "") {
                $('#divMensaje').html('Ingrese rpm válido.');
                $('#txtRpm').focus();
                return false;
            }
			
			
            if (correlativo_factura == "") {
                $('#divMensaje').html('Ingrese correlativo factura válido.');
                $('#txtCorrelativo_Factura').focus();
                return false;
            }
			
			
			if (nextel == "") {
                $('#divMensaje').html('Ingrese nextel válido.');
                $('#txtNextel').focus();
                return false;
            }
			
			if (otro_operador == "") {
                $('#divMensaje').html('Ingrese otro operador válido.');
                $('#txtOtro_Operador').focus();
                return false;
            }
			
			if (distrito_ID == 0) {
                $('#divMensaje').html('Ingrese distrito válido.');
                $('#cboDistrito').focus();
                return false;
            }
			
			
			if (tipo_cambio == "") {
                $('#divMensaje').html('Ingrese tipo de cambio válido.');
                $('#txtTipo_Cambio').focus();
                return false;
            }
			
			if (mail_principal == "") {
                $('#divMensaje').html('Ingrese una email válido.');
                $('#txtMail_Principal').focus();
                return false;
            }
			
            if (vigv == "") {
                $('#divMensaje').html('Ingrese venta igv válido.');
                $('#txtVigv').focus();
                return false;
            }
			
             $('.btn').css('display', 'none');
             $('.btnEnviando').css('display', 'inline-block');
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
