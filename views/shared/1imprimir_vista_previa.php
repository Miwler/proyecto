<?php		
	require ROOT_PATH."views/shared/content-float.php";	
?>	
<?php function fncTitle(){?>Vista previa<?php } ?>

<?php function fncHead(){?>
	<style type="text/css">
		.tbCabecera{
			margin-bottom:5px;
			border:1px solid #808080;
			padding:5px;
		}
		
		.tbCabecera caption{
			font-weight:bold;
			text-decoration:underline;
			font-size:20px;
			margin-bottom:10px;
		}
		
		.tbCabecera th{
			font-size:15px;
			font-style:italic;
			text-align:left;
		}
		
		/*Formato de impresión para los Grid*/						
		.Grid .print{
			display:table-cell !important;
		}
			
		.Grid .no-print{
			display:none !important;
		}
		
		.trsel,.trsel:hover
		{  
			border-top: 1px solid #fff !important;
		    border-right: 1px solid #fff !important;
		    border-bottom: 1px solid #808080 !important;
		    border-left: 1px solid #808080 !important;
			background:#fff !important;
			color:#000 !important;	
			
		}
	</style>
	<link rel="stylesheet" type="text/css" href="include/css/grid.css" />
	<script type='text/javascript'>		
		if(top.location==self.location){
			self.location='/';
		}
	</script>
<?php } ?>

<?php function fncTitleHead(){?>Vista previa<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>		
	<div class="tool-bar" style="text-align:right">
		<button onclick="window.print();">
			<img title="Imprimir" src="/include/img/boton/print_16x16.png" />
			Imprimir
		</button>
		
		<button onclick="window_float_close();">
			<img title="Salir" src="/include/img/boton/back_16x16.png" />
			Regresar
		</button>
	</div>	
	<div id="divPrint" style="position:relative;">
		<div id="divCargando" style="position:absolute;left:0;top:0;right:0;bottom:0;background:#fff;text-align:center;" >
			Preparando la impresión....
			<br />
			<img src='/include/img/loading_bar.gif' />
		</div>
		<div id="divCabecera">
			<?php 			
			switch($_GET['tipo']){
				case 'producto':
					$html='<table class="tbCabecera"  style="width:100%"><caption>'.$_GET['title'].'</caption>';
					$html.='<tr><th style="width:200px;">Clasificación de Productos: </th><td>'.$_GET['clasificacion'].'</td></tr>';
					$html.='<tr><th>Fecha de Impresión:</th><td>'.date('d/m/Y').'</td></tr>';
					$html.='<tr><th>Usuario:</th><td>'.$_SESSION['usuario_nombre'].'</td></tr></table>';
					echo $html;
				break;				
				
				case 'producto_clasificacion':
					$html='<table class="tbCabecera"  style="width:100%"><caption>'.$_GET['title'].'</caption>';
					$html.='<tr><th  style="width:200px;">Fecha de Impresión:</th><td>'.date('d/m/Y').'</td></tr>';
					$html.='<tr><th>Usuario:</th><td>'.$_SESSION['usuario_nombre'].'</td></tr></table>';
					echo $html;
				break;				
				
				case 'pedidos':
					$html='<table class="tbCabecera"  style="width:100%"><caption>'.$_GET['title'].'</caption>';
					$html.='<tr><th  style="width:200px;">Fecha de Impresión:</th><td>'.date('d/m/Y').'</td></tr>';
					$html.='<tr><th>Usuario:</th><td>'.$_SESSION['usuario_nombre'].'</td></tr></table>';
					echo $html;
				break;	
				
				case 'ventas':
					$html='<table class="tbCabecera"  style="width:100%"><caption>'.$_GET['title'].'</caption>';
					$html.='<tr><th  style="width:200px;">Fecha de Impresión:</th><td>'.date('d/m/Y').'</td></tr>';
					$html.='<tr><th>Usuario:</th><td>'.$_SESSION['usuario_nombre'].'</td></tr></table>';
					echo $html;
				break;	
			}
			?>
		</div>
		
		<div id="divContenido"></div>
	</div>
	<script type="text/javascript">		
		document.getElementById('divContenido').innerHTML=parent.document.getElementById('<?php echo $_GET['id']; ?>').innerHTML;
		
		window.onload=function(){			
			document.getElementById('divCargando').style.display='none';
		}
	</script>
<?php } ?>