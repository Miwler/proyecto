<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Mantenimiento de Correlativos
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
		<link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
        <i class="fa fa-envelope" aria-hidden="true"></i>Mantenimiento de Correlativos
<?php } ?>
<?php function fncPage(){?>

        <form id="frm1" name="frm1" method="post" action="/Mantenimiento/Correlativos_Mantenimiento" class="form-horizontal">
            <div class="panel panel-tab panel-tab-double shadow">
               
                <div class="panel-body">
                   
                        <table class="grid table table-hover table-bordered">
                            <tr>
                                <th>Documento</th>
                                <th>Serie</th>
                                <th>Último número</th>
                            </tr>
                            <?php foreach($GLOBALS['dtCorrelativos'] as $item){?>
                            <tr>
                                <td><?php echo FormatTextView($item['nombre'])?></td>
                                <td class="tdCenter"><?php echo $item['serie']?></td>
                                <td class="tdCenter">
                                    <input type="number" id="txt<?php echo $item['ID']?>" name="txt<?php echo $item['ID']?>" value="<?php echo $item['ultimo_numero']?>" class="int form-control">
                                </td>
                            </tr>
                            <?php } ?>
                           
                        </table>
                    
                </div>
                <div class="panel-footer">
                    <button id="btnGrabar" name="btnGrabar"  title="Grabar" onclick="f.enviar();" class="btn btn-success">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Grabar
                    </button>
                </div>
            </div>
           
	</form>	
	<?php if(isset($GLOBALS['resultado'])&& $GLOBALS['resultado']==1){?>
	<script type="text/javascript">
            $(document).ready(function () {
                toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
                
             });
	</script>
        <?php } ?>
        <?php if(isset($GLOBALS['resultado'])&& $GLOBALS['resultado']==-1){?>
	<script type="text/javascript">
            $(document).ready(function () {
                toastem.error('<?php echo $GLOBALS['mensaje']; ?>');
                
             });
	</script>
        <?php } ?>
<?php } ?>