<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Modificar Serie<?php } ?>

<?php

function fncHead() { ?>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
   <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>

<?php

function fncTitleHead() { ?>Modificar Serie<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
    <?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
        <form id="form" method="POST" style="width:300px; height: 300px;" action="/Mantenimiento/Serie_Mantenimiento_Editar/<?php echo $GLOBALS['oSerie']->ID; ?>" onsubmit="return validar();">
           <table width="300" height="200"  cellpadding="0" cellspacing="0" style="padding: 0 10px;">
          
               
            <tr>
                    <td>Tipo de comprobante</td>
                    <td>
                        <select id="selComprobante_Tipo" name="selComprobante_Tipo">
<!--                            <option value="0">SELECCIONAR</option>-->
                            <?php foreach($GLOBALS['oSerie']->dtComprobante_tipo as $iComprobante_Tipo){ ?>
                                <option value="<?php echo $iComprobante_Tipo['ID']; ?>"><?php echo FormatTextView($iComprobante_Tipo['nombre']); ?></option>
                            <?php } ?>

                         </select> 
                         <script type="text/javascript">
                              $('#selComprobante_Tipo').val(<?php echo $GLOBALS['oSerie']->comprobante_tipo_ID;?>);
                         </script>

                    </td>
                </tr>
               
               
                <tr>

                    <td>Nombre</td>
                    <td>
                        <input id="txtNombre" name="txtNombre"  type="text" autocomplete="off" value="<?php echo $GLOBALS['oSerie']->nombre; ?>"/>
		
                    </td>
                </tr>
               

                <tr>
                    <td>Descripción</td>
                    <td>
                       <input id="txtDescripcion" name="txtDescripcion"  type="text" autocomplete="off" value="<?php echo $GLOBALS['oSerie']->descripcion; ?>" />
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
        //ingreso de datos obligatorios
        var validar = function () {
            var nombre = $.trim($('#txtNombre').val());
            var descripcion = $.trim($('#txtDescripcion').val());
            var comprobante_tipo_ID = $.trim($('#selComprobante_Tipo').val());

            $('#divMensaje').html('');
            if (comprobante_tipo_ID == "0") {
                $('#divMensaje').html('Seleccione una comprobante tipo.');
                $('#selComprobante_Tipo').focus();
                return false;
            }
            if (nombre== "") {
                $('#divMensaje').html('Ingrese un nombre válido.');
                $('#txtNombre').focus();
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
