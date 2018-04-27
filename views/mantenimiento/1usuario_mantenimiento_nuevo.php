<?php		
	require ROOT_PATH."views/shared/content-float.php";	
?>	
<?php function fncTitle(){?>
		Información para Asignar Usuario
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
               <script type="text/javascript" src="include/js/jCboDiv.js"></script> 
<!--               <script type="text/javascript" src="include/js/jscript.js"></script>-->
               
                <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
                <link rel="stylesheet" type="text/css" href="include/css/estilos.css" />
                <link rel="stylesheet" type="text/css" href="include/css/menu.css" />
                <script type="text/javascript">
                   $(function(){
                       var usuario_ID=$('#txtUsuario_ID').val();
                       if(usuario_ID==0){
                         $('#pestana2').Attr('disabled');  
                       }else if(usuario_ID>0){
                           
                           $('#pestana2').removeAttr('disabled'); 
                       }
                   }); 
                </script>
<?php } ?>
                
<?php
     function fncTitleHead() { ?>
<?php } ?>                
                
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<h1 class="title-principal" style="font-size:14px">
    <center> TRABAJADOR: <label for="nombre" style="font-size:14px;width:300px;"><?php echo $GLOBALS['oOperador']->apellido_paterno ." ". $GLOBALS['oOperador']->apellido_materno ." ". $GLOBALS['oOperador']->nombres; ?> </label></center>


</h1>
<div class="tab" id="tab" style="width: 914px;height:520px;">
    <div id="pestanas" class="cabecera-taps" style="width: 900px;">
        <button id="pestana1" class="botonTabs activetabs" onclick="mostrarForm('pestana1');" >USUARIO</button>
        <button id="pestana2" class="botonTabs"  disabled onclick="mostrarForm('pestana2');"  >ASIGNAR MENU</button>
       
    </div>
	
   <div id="contenidopestanas" class="cuerpo-taps">
       
<div id="cpestana1" style="display:block;" class="cpestana">
<h2 style="margin:0; padding:10px 0;">Registro de Usuario</h2>
 
 <?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==1||$GLOBALS['resultado']==-1){ ?>   
<form id="frm1" name="frm1" method="post" action="/Mantenimiento/Usuario_Mantenimiento_Nuevo/<?php echo $GLOBALS['oOperador']->ID; ?>">
                           		          
<table width="733" height="256" border="0" align="center">
  <tr>
    <td width="101">Usuario:</td>
    <td width="280"> 
        
        <input id="txtOperador" name="txtOperador" type="hidden" value="<?php echo $GLOBALS['oOperador']->ID; ?>"/>
        <input id="txtUsuario_ID" name="txtUsuario_ID" type="hidden" value="<?php echo $GLOBALS['oUsuario']->ID; ?>"/>
        <input id="txtUsuario" name="txtUsuario" type="text" autocomplete="off" value="<?php echo $GLOBALS['oUsuario']->nombre; ?>" required/>
      <samp style="color: red;">*</samp> </td>
    
     <td width="190"><label>Perfil:</label></td>
    <td width="250"> 
	  <select id="cboPerfil" name="cboPerfil"  onchange="fncPerfil();">
                        <?php foreach ( $GLOBALS['dtPerfil'] as $item){ ?>
                            <option value="<?php echo $item['ID']; ?>"><?php echo $item['nombre']; ?></option>
                        <?php } ?>
          </select>
	  <label class="lblrequired">*</label>
	     <script type="text/javascript">
	    $('#cboPerfil').val(<?php echo $GLOBALS['oUsuario']->perfile_ID; ?>);
	    </script>
   </td>
     
    </tr>
  <tr>
    <td> Password:</td>
    <td> 
        <input id="txtPassword" name="txtPassword" type="text" autocomplete="off" value="<?php echo $GLOBALS['oUsuario']->password; ?>" required/>
    </td>
    <td><label> Estado:</label></td>
    <td>
    <select id="cboEstado" name="cboEstado">
        <?php foreach($GLOBALS['dtEstado'] as $iEstado){?>
        <option value="<?php echo $iEstado['ID']; ?>"><?php echo FormatTextView($iEstado['nombre']); ?></option>
        <?php } ?>
    </select>						
        <script type="text/javascript">
            $('#cboEstado').val(<?php echo $GLOBALS['oUsuario']->estado_ID; ?>);
        </script>
    </td>
  </tr>
  
  <tr>
    <td colspan='4'>
        <div class="tool-btn" style ="text-align:left;">                     
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
         </div> 
    </td>
  </tr>
  
</table>

     <div>
        <div id="divMensaje" class="float-mensaje">        
                    <?php echo $GLOBALS['mensaje']; ?>
        </div>    
      
    </div> 
                            
                            
</form>	

				
</div>

<div id="cpestana2" style="display:none;" class="cpestana">
    <div align="center">
                    <h2 style="margin:0; padding:5px 0;font-size: 18px;">Asignacion de permisos de usuario </h2>
			
         <form id="frm2" method="POST" style="height: 400px;overflow-y:overlay" action="" >
            <input id="txtUsuario_ID"  name="txtUsuario_ID" type="text" style="display:none;" value="<?php echo $GLOBALS['oUsuario']->ID; ?>"/>
            <table>
                
               
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
                            <td colspan="2" style="border:1px solid #A4A4A4; background: #ddd;color:#808080; text-align:center;">MODULO <?php echo FormatTextViewHtml($idtMenu['modulo']);?></td>
                        </tr>    
                        <tr>
                           <td style="border:1px solid #A4A4A4;">
                                <?php echo FormatTextViewHtml($idtMenu['menu'])?>
                            </td>
                            <td style="border:1px solid #A4A4A4;text-align:center;">
                                <input type="checkbox" id="<?php echo $idtMenu['ID']?>" value="<?php echo $idtMenu['ID']?>"  onclick="seleccionar(this.value);"/> 
                            </td>
                        </tr>
                     <?php } else {?>
                
                <tr>
                    
                    
                    <td style="border:1px solid #A4A4A4;">
                        <?php echo FormatTextViewHtml($idtMenu['menu']);?>
                    </td>
                    <td style="border:1px solid #A4A4A4;text-align:center;">
                         <input type="checkbox" id="<?php echo $idtMenu['ID']?>" value="<?php echo $idtMenu['ID']?>" onclick="seleccionar(this.value);"/> 
                    </td>
                </tr>
                <?php }?>
                 <?php   $Modulo=$idtMenu['modulo'];
                    }?>
                
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
			
	<script type="text/javascript">
				var f2=new form('frm2','divc2');
				f2.terminado = function () {
							
					var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];
					
					grids = new grid(tb);
					grids.nuevoEvento();
					grids.fncPaginacion(f2);
					f2.enviar();			
				}
				
			
	</script>
	</div>			
</div>
	
</div>
</div>
	<script type="text/javascript">
            
	function mostrarForm(valor){
		//alert(Valor);
		if(valor=="pestana1"){
                        $('#pestana2').removeClass('activetabs');
                    
                       	$('#pestana1').addClass('activetabs');
                        $('#cpestana1').show();
                        $('#cpestana2').hide();
                        
			valor="";
		} else if(valor=="pestana2"){
			//f.enviar();
                        $('#pestana1').removeClass('activetabs');
                       	$('#pestana2').addClass('activetabs');
                       
                        $('#cpestana2').show();
                        $('#cpestana1').hide();
                      valor="";
                       
		} 
	}
	
	</script>
        <?php } ?>
        
	<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
        <div class="float-mensaje">
            <?php  echo $GLOBALS['mensaje']; ?>
        </div>
        <script type="text/javascript">
            $('#pestana2').removeAttr('disabled');
            mostrarForm('pestana2');
          
        </script>
        <?php } ?>

   <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==0){ ?>
        <div class="float-mensaje">
             <?php  echo $GLOBALS['mensaje']; ?>
        </div>
        <div class="group-btn">
            <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
        </div>
    <?php } ?>
        
<?php } ?>