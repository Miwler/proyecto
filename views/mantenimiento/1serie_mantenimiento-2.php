<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Mantenimiento de Serie
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
		<link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<h1 class="title-principal">
		Mantenimiento de Serie
	</h1>
        <form id="frm1" name="frm1" method="post" action="/Mantenimiento/ajaxSerie_Mantenimiento">
		<div class="tool">
			<input type="text" id="txtBuscar"  name="txtBuscar" style="width:400px;" placeholder="Buscar por Nombre">
			<button id="btnBuscar" name="btnBuscar" class="botonVentanas" type="button" title="Buscar" onclick="f.enviar();">
				<img src="/include/img/boton/find_14x14.png"  /> Buscar
			</button>
			<button id="btnNuevo" name="btnNuevo" type="button" class="botonVentanas" title="Nuevo" onclick="fncNuevo();">
				<img src="/include/img/boton/new_14x14.png" /> Nuevo
			</button>
			<div style="float:right;">
				Registros a mostrar: <input id="txtMostrar" name="txtMostrar" type="text"  class="int" value="30" style="width:30px;">
			</div>
		</div>
		
		<div id="divMensaje" class="divMensaje"></div>
		<div id="div1" class="grid-content"></div>

		<input id="num_page" name="num_page" type="text" value="1" style="display:none;">
		<input id="txtOrden" name="txtOrden" type="text" value="1" style="display:none;">
		<input id="chkOrdenASC" name="chkOrdenASC" type="checkbox" checked style="display:none;">
	</form>	
	
	<script type="text/javascript">
		var f=new form('frm1','div1');
		f.terminado = function () {
                    
			var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];
			
			grids = new grid(tb);
			grids.nuevoEvento();
			grids.fncPaginacion(f);			
		}
		f.enviar();
		
		var fncOrden=function(col){
                    
			var col_old=$('#txtOrden').val();
			
			if(col_old==col){
				if($('#chkOrdenASC').is(':checked')){
					$('#chkOrdenASC').prop('checked',false);
				}else{
					$('#chkOrdenASC').prop('checked',true);
				}
			}else{
				$('#txtOrden').val(col);
				$('#chkOrdenASC').prop('checked',true);
			}		
			
			f.enviar();
		}
		
		var fncNuevo=function(){			
			window_float_open('/Mantenimiento/Serie_mantenimiento_Nuevo','','',f);
		}
		
		var fncEditar=function(id){			
			window_float_open('/Mantenimiento/Serie_mantenimiento_Editar',id,'',f);
		}
		
		var fncEliminar=function(id){			
			gridEliminar(f,id,'/Mantenimiento/ajaxSerie_mantenimiento_Eliminar');
		}
		
		$('#txtBuscar,#txtMostrar').keypress(function(e){
                    
			if (e.which==13){
				$('#num_page').val(1);
				f.enviar();
				return false;
			}
		});
		
		$('#txtBuscar').focus();
	</script>
<?php } ?>