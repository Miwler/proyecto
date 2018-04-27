<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Modificar Operador<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<?php } ?>

<?php

function fncTitleHead() { ?>Modificar Operador<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>
<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
        <form id="form" method="POST" style="width: 880px;" action="/Mantenimiento/Operador_Mantenimiento_Editar/<?php echo $GLOBALS['oOperador']->ID; ?>" onsubmit="return validar();">
            <div class="col-lg-12" style="margin-top:10px">
              
             
<table width="870" height="434"  cellpadding="0" cellspacing="0">
  <tr>
    <td width="191">Nombres:</td>
    <td width="252"><input id="txtNombres" name="txtNombres" type="text"autocomplete="off" value="<?php echo $GLOBALS['oOperador']->nombres; ?>"/></td>
    <td width="191">Correo:</td>
    <td width="234"> <input id="txtMail" name="txtMail" type="email" maxlength="100" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->mail; ?>"/></td>
  </tr>
  <tr>
    <td>Apellido Paterno:</td>
    <td><input id="txtApellido_Paterno" name="txtApellido_Paterno" type="text"autocomplete="off" value="<?php echo $GLOBALS['oOperador']->apellido_paterno; ?>"/></td>
    <td>Sexo:</td>
    <td> 
        
             <select name="cboSexo">
        <option value="Hombre"<?php
                            if ("Hombre" == $GLOBALS['oOperador']->sexo) {
                                echo "selected='selected'";
                            };
                            ?>>Hombre</option>
        <option value="Mujer"<?php
                            if ("Mujer" == $GLOBALS['oOperador']->sexo) {
                                echo "selected='selected'";
                            };
                            ?>>Mujer</option>
           </select>
    </td>
  </tr>
  <tr>
    <td>Apellido Materno:</td>
    <td><input id="txtApellido_Materno" name="txtApellido_Materno" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->apellido_materno; ?>"/><samp style="color: red;">*</samp></td>
    <td>Fecha Contrato:</td>
    <td><input id="txtFecha_Contrato" name="txtFecha_Contrato" type="text" class="date"  autocomplete="off" value="<?php echo date("d/m/Y", strtotime($GLOBALS['oOperador']->fecha_contrato)); ?>"/></td>
  </tr>
  <tr>
    <td>Direccion:</td>
    <td><input id="txtDireccion" name="txtDireccion" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->direccion; ?>"/></td>
    <td>Comision:</td>
    <td> <input id="txtComision" name="txtComision" type="text" class="decimal" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->comision; ?>"/></td>
  </tr>
  <tr>
    <td>DNI:</td>
    <td><input id="txtDni" name="txtDni"  class="int" maxlength="8" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->dni; ?>"/></td>
    <td>Estado Civil</td>
    <td>  
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
    </td>
  </tr>
  <tr>
    <td>Fecha Nacimiento:</td>
    <td><input id="txtFecha_Nacimiento" name="txtFecha_Nacimiento" type="text" class="date" autocomplete="off" value="<?php  echo date("d/m/Y", strtotime($GLOBALS['oOperador']->fecha_nacimiento)); ?>"/></td>
    <td>Cargo</td>
    <td>
        <select name="cboCargo" >
        <?php foreach ($GLOBALS['dtCargo'] as $item) {?>
        <option value="<?php echo $item['ID'] ?>"
                <?php if ($GLOBALS['oOperador']->cargo_ID == $item['ID']) { echo "selected='selected'";} ?> >
                <?php echo $item['nombre'] ?>
        </option>
        <?php } ?>
        </select>
      <samp style="color: red;">*</samp>
    </td>
  </tr>
  <tr>
    <td>Telefono:</td>
    <td><input id="txtTelefono" name="txtTelefono" maxlength="20" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->telefono; ?>"/></td>
    <td>Nextel</td>
    <td> <input id="txtNextel" name="txtNextel" maxlength="20" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->nextel; ?>"/><samp style="color: red;">*</samp></td>
  </tr>
  <tr>
    <td>Celular 1:</td>
    <td><input id="txtRpc" name="txtRpc" type="text" maxlength="20" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->rpc; ?>"/></td>
    <td>Anexo</td>
    <td><input id="txtAnexo" name="txtAnexo" type="text" maxlength="20" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->anexo; ?>"/><samp style="color: red;">*</samp></td>
  </tr>
  <tr>
    <td>Celular 2:</td>
    <td> <input id="txtRpm" name="txtRpm" type="text" maxlength="20" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->rpm; ?>"/> </td>
    <td>Celular 3:</td>
    <td><input id="txtOtro_Operador" name="txtOtro_Operador" maxlength="20" type="text" autocomplete="off" value="<?php echo $GLOBALS['oOperador']->otro_operador; ?>"/><samp style="color: red;">*</samp></td>
  </tr>
</table>   
                

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
                    <div class="btnEnviando" style="display:none;">         
                        <button type="button">
                            <img src="/include/img/boton/boton-loader_14x14.gif" title="Guardando" alt="Guardando" /> Enviando
                        </button>     
                    </div>                                    
                </div>
            </div> 
        </form>
        <script type="text/javascript">

            var validar = function () {

                var nombres = $.trim($('#txtNombres').val());


                $('#divMensaje').html('');



                if (nombres == '') {
                    $('#divMensaje').html('Ingrese nombre del operador.');
                    $('#txtNombres').focus();
                    return false;
                }


                $('.btn').css('display', 'none');
                $('.btnEnviando').css('display', 'inline-block');

            }

            $('#txtRuc').focus();
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
