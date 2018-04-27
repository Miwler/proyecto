<?php		
	require ROOT_PATH . "views/shared/content-impresion.php";
?>	
<?php function fncTitle(){?>
		Registro de Cotizaciones
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
                <script type="text/javascript" src="include/js/jDate.js"></script>
		<link rel="stylesheet" type="text/css" href="include/css/grid.css" />
                <link rel="stylesheet" type="text/css" href="include/css/date.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>

	<form id="frm1" name="frm1" method="post" action="/Cotizacion/vista_cotizacion">
		
	</form>	
	
	
<?php } ?>