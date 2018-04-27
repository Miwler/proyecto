<?php
require ROOT_PATH."views/shared/content-float-hijo.php";
?>	
<?php

function fncTitle() { ?>Nuevo Contacto<?php } ?>

<?php

function fncHead() { ?>
     <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
    <script type="text/javascript" src="include/js/jForm.js"></script>
  
<?php } ?>

<?php

function fncTitleHead() { ?>Nuevo Contacto<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>
<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>

<form id="form1" method="POST" style=" width:900px;" action="/Mantenimiento/RepresentanteProveedor_Mantenimiento_Nuevo/<?php echo $GLOBALS['oProveedor']->ID;?>" onsubmit="return validar();" >
    <table  cellpadding="0" cellspacing="0" style=" width: 420;height: 300px;margin:0 auto;">

        <tr>
            
            <td rowspan="3">
                 <img  src="/include/img/boton/proveedorcontacto.png" width="100">
                
                
            </td>
            <td>Nombres:</td>
            <td>
              <input id="txtNombre" name="txtNombre" type="text"autocomplete="off" required />
            <samp style="color: red;">*</samp></td>
            
        </tr>
        <tr>
            <td> Apellidos:</td>
            <td>
              <input id="txtApellidos" name="txtApellidos" type="text" autocomplete="off" required  />
            <samp style="color: red;">*</samp> </td>
           
        </tr>
       
        <tr>
            
           <td>Correo:</td>
            <td>
              <input type="email" id="txtCorreo" name="txtCorreo"  autocomplete="off" />
            </td>
        </tr>
        <tr>
            <td>Celular1:</td>
            <td colspan="2">
              <input id="txtCelular1" name="txtCelular1" type="text" autocomplete="off"  />
            </td>
               
        </tr>
        <tr>
            <td>Celular2:</td>
            <td colspan="2">
              <input id="txtCelular2" name="txtCelular2" type="text" autocomplete="off"  />
            </td> 
        </tr>
        <tr>
            <td>Teléfono:</td>
            <td colspan="2">
              <input id="txtTelefono" name="txtTelefono" type="text" autocomplete="off"  />
            </td>
            
        </tr>
    </table>
        <div class="btn_flotante_hijo">                    
            <div class="btn">                                  
                <button  id="btnGrabar" name="btnGrabar" class='botones_formulario'  >
                    <img title="Guardar" alt="" src="/include/img/boton/save_14x14.png">
                    Guardar
                </button>
                <button id="btnRegresar1" type="button" class="botones_formulario" onclick=" window_deslizar_save();">
                    <img src="/include/img/boton/salir1_48x48.png"  title="Regresar"/>
                    Regresar
                </button>                                                         
            </div> 
        </div> 
 

   
    <script type='text/javascript' >
      
        
        var validar=function(){
            var nombres=$('#txtNombre').val().trim();
            var apellidos=$('#txtApellidos').val().trim();
            var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
            var correo=$('#txtCorreo').val().trim();
            if(nombres==''){
                toastem.error('Registre el nombre');
                $('#txtNombre').focus();
                return false;
            } 
            if(apellidos==''){
                toastem.error('Registre el apellidos');
                $('#txtApellidos').focus();
                return false;
            } 
            if(correo!=''){
                if (regex.test(correo)) {
               
                return true;
            } else {
                 toastem.error('Registre un correo válido');
                 $('#txtCorreo').focus();
                return false;
            }
            } 
            
           
        }

    </script>
    <style type="text/css">
        .trSelecionado{
            background: #7FFFD4;
        }
    </style>
</form>

    <?php } ?>
<style type="text/css">	
    .enlaces:hover{
      color:blue;
      cursor: pointer;
    }
</style>

    
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <script type="text/javascript">

          setTimeout('window_deslizar_save();', 1000);
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
