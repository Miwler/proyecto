<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Editar numero de cuenta<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<?php } ?>

<?php

function fncTitleHead() { ?>Editar numero de cuenta<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
    <form id="form" method="POST" action="/Mantenimiento/Numero_Cuenta_Mantenimiento_Editar/<?php echo $GLOBALS['oNumero_Cuenta']->ID;?>" style="width:580px;" onsubmit="return validar();">
        <table style="width:580px; height:200px; ">
            <tr>
                <td rowspan="4">
                    <img src="/include/img/boton/banco.jpg" width="100"  />
                </td>
                <th>Banco:</th>
                <td>
                    <input type="text" id="txtNombre_Banco" autocomplete="off" name="txtNombre_Banco" value="<?php echo FormatTextViewHtml($GLOBALS['oNumero_Cuenta']->nombre_banco);?>">
                </td>
            </tr>
            <tr>
                <th>Numero Cuenta:</th>
                <td>
                    <input type="text" id="txtNumero" autocomplete="off" class="text-int"  value="<?php echo FormatTextViewHtml($GLOBALS['oNumero_Cuenta']->numero);?>" name="txtNumero">
                </td>
            </tr>
            <tr>
                <th>N&uacute;mero Cuenta Interbancaria:</th>
                <td>
                    <input type="text" id="txtCci" name="txtCci" class="text-int"  autocomplete="off" value="<?php echo FormatTextViewHtml($GLOBALS['oNumero_Cuenta']->cci);?>">
                </td>
            </tr>
            <tr>
                <th>Moneda</th>
                <td>
                    <select id="selMoneda_ID" name="selMoneda_ID">
                        <?php foreach($GLOBALS['oNumero_Cuenta']->dtMoneda as $item){ ?>
                        <option value="<?php echo $item['ID']?>"><?php echo FormatTextViewHtml($item['descripcion']);?></option>
                        <?php } ?>
                      
                    </select>
                    <script type="text/javascript">
                        $('#selMoneda_ID').val(<?php echo $GLOBALS['oNumero_Cuenta']->moneda_ID;?>);
                    </script>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div id="divMensaje" class="float-mensaje">        
                    <?php echo $GLOBALS['mensaje'];?>
                    </div>    
                    <div class="tool-btn" style ="text-align:right;">                     
                    <div class="btn">                                  
                        <button  id="btnEnviar" name="btnEnviar" class="botonVentanas" >
                            <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                            Guardar
                        </button>
                        <button  id="btnCancelar" name="btnCancelar" type="button" class="botonVentanas" onclick="window_float_close();" >
                            <img title="Guardar" alt="" src="/include/img/boton/cancel_14x14.png">
                            Cancelar
                        </button>                                                          
                    </div> 
                    </div> 
                </td>
            </tr>
        </table>
        
        </form>
	
    <?php } ?>
<script type="text/javascript">
        //ingreso de datos obligatorios
    var validar = function () {
        var nombre_banco = $.trim($('#txtNombre_Banco').val());
        var txtNumero = $.trim($('#txtNumero').val());

        if (nombre_banco == "") {
            $('#divMensaje').html('Ingrese un nombre de banco.');
            $('#txtNombre_Banco').focus();
            return false;
        }
        if (txtNumero =="") {
            $('#divMensaje').html('Ingrese un número de cuenta.');
            $('#txtNumero').focus();
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
