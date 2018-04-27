<div id="divUsuario">  
	<a id="divNomUsuario"><?php echo $_SESSION['usuario_nombre'];?></a>            
	&nbsp;
	<span id="foto_perfil_24x24" style="background:url('include/img/usuario/user-default_24x24.png') center center no-repeat #fff;" >&nbsp;</span>                                 
	<div id="divUsuarioAccion" style="display:none;">             
		<img id="foto_perfil_128x128" alt="foto_perfil" src ="include/img/usuario/user-default.png" width="128" height="128" />
		<div id="contentDatos">
			<span id="nUsuario"><?php echo $_SESSION['usuario_nombre'];?></span>
		</div>
		 <div id="divUsuariobottom">
			<button id="btnEdit" name="btnEdit" type="button" >
				Editar
			</button>&nbsp;&nbsp;&nbsp;
			 <button id="btnLogout" name="btnLogout" type="button" onclick="fncLogout();">
				Cerrar sesión
			</button>
		 </div>
		<br />           
	</div>  
 </div>