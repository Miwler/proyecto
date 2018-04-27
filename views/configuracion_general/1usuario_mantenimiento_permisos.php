<?php
require ROOT_PATH . "views/shared/content-float.php";
?>	
<?php

function fncTitle() { ?>Asignacion de permisos de usuario<?php } ?>

<?php

function fncHead() { ?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<?php } ?>

<?php

function fncTitleHead() { ?>Asignacion de permisos de usuario<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>
<?php

function fncPage() { ?>
   
        <form id="form" method="POST" >
            <input id="txtUsuario_ID"  name="txtUsuario_ID" type="text" style="display:none;" value="<?php echo $GLOBALS['usuario_ID']; ?>"/>
            <table>
                
                <tr>
                    <td colspan="2">
                         <div class="btnEnviando" style="display:none;">         
                            <button type="button">
                                <img src="/include/img/boton/boton-loader_14x14.gif" title="Guardando" alt="Guardando" /> Enviando
                            </button>     
                        </div>  
                        <div id="divMensaje" class="float-mensaje">        
                        <?php echo $GLOBALS['mensaje']; ?>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td style="width:300px; border:1px solid #A4A4A4; background: #555;color:#fff;text-align:center;">
                        MENUS
                    </td>
                    <td style="width:80px; border:1px solid #A4A4A4; background: #555;color:#fff; text-align:center;">
                        OPCION
                    </td>
                </tr>
                <?php $Modulo="";?>
                 <?php foreach($GLOBALS['dtMu'] as $idtMenu){ ?>
                    <?php if($Modulo!=$idtMenu['modulo']){?>
                        <tr>
                             <td colspan="2" style="border:1px solid #A4A4A4; background: #ddd;color:#808080; text-align:center;">MODULO <?php echo $idtMenu['modulo'];?></td>
                        </tr>    
                        <tr>
                           <td style="border:1px solid #A4A4A4;">
                                <?php echo $idtMenu['menu']?>
                            </td>
                            <td style="border:1px solid #A4A4A4;text-align:center;">
                                <input type="checkbox" id="<?php echo $idtMenu['ID']?>" value="<?php echo $idtMenu['ID']?>"  onclick="seleccionar(this.value);"/> 
                            </td>
                        </tr>
                     <?php } else {?>
                
                <tr>
                    
                    
                    <td style="border:1px solid #A4A4A4;">
                        <?php echo $idtMenu['menu']?>
                    </td>
                    <td style="border:1px solid #A4A4A4;text-align:center;">
                         <input type="checkbox" id="<?php echo $idtMenu['ID']?>" value="<?php echo $idtMenu['ID']?>" onclick="seleccionar(this.value);"/> 
                    </td>
                </tr>
                <?php }?>
                 <?php   $Modulo=$idtMenu['modulo'];
                    }?>

            </table>
        <script type="text/javascript">
            //marcarCheckbok();
             <?php  foreach($GLOBALS['dtMenu_usuario'] as $imenu_usuario) { ?>
                 marcarCheckbok(<?php echo $imenu_usuario['menu_ID'];?>);
                      
               <?php }?>  
         function marcarCheckbok(ID){
            $('#'+ID).prop("checked", "checked");;
                
            }
        function seleccionar(valor){
            var usuario_ID=$('#txtUsuario_ID').val();
            //alert(usuario_ID);
               seleccionarCk('Mantenimiento/ajaxUsuario_Mantenimiento_Permiso_Seleccionar',usuario_ID,valor);
        }
          
        </script>
             
        </form>
       


<?php } ?>
