<?php		
	require ROOT_PATH."views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Buscar Orden de Compras<?php } ?>

<?php function fncHead(){?>
	
	<script type="text/javascript" src="include/js/jForm.js"></script>
	
<?php } ?>

<?php function fncTitleHead(){?>Buscar Orden de Compras<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>
<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="frm1"  method="post" action="Ingreso/compra_mantenimiento_buscar_orden" onsubmit="return validar();">
    
    <div class="panel panel-info">
        <div class="panel-body" style="height: 400px;overflow: auto;">
            <table class="table table-hover table-bordered" class='grid'>
                <thead>
                    <tr>
                        <th></th>
                        <th class="tdCenter">Nro Orden</th>
                        <th class="tdCenter">Fecha</th>
                        <th class="tdCenter">Proveedor</th>
                        <th class="tdCenter">Moneda</th>
                        <th class="tdCenter">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($GLOBALS['dtOrden_Compra'] as $item ) {?>
                    <tr class="tr-item">
                        <td><a class="btn btn-info" title="Generar la compra" onclick="fncComprar(<?php echo $item['ID'];?>);">Comprar</a></td>
                        <td class="tdCenter"><?php echo sprintf("%'.07d",$item['numero_orden']);?></td>
                        <td class="tdCenter"><?php echo date("d/m/Y",strtotime($item['fecha']));?></td>
                        <td><?php echo $item['proveedor'];?></td>
                        <td><?php echo FormatTextView($item['simbolo']);?></td>
                        <td class="tdRight"><?php echo number_format($item['total'],2,'.',',');?></td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>
        <div class="panel-footer">
            <button id="btnRegresar1" type="button" class="btn btn-danger" title="Cancelar" onclick=" parent.float_close_modal_hijo();">
                <span class="glyphicon glyphicon-ban-circle"></span>
                    Cancelar
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
    var fncComprar=function(id){
        $('#fondo_espera').css('display','block');
        cargarValores('Ingreso/ajaxComprar_Orden',id,function(resultado){
            if(resultado.resultado==1){
                toastem.info(resultado.mensaje);
                parent.windos_float_save_modal_hijo(resultado.compra_ID);
                //window.parent.fncCargarValores(resultado.compra_ID);
                //window_deslizar_close();
            }else {
                //$('#divp').html(resultado.mensaje);
                mensaje.error("OCURRIÓ UN ERROR",resultado.mensaje);
            }
        });
    }
</script>
 <?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>
    <div class="float-mensaje">
        <?php  echo $GLOBALS['mensaje']; ?>
    </div>
    
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>

<script type="text/javascript">
    $(document).ready(function(){
        toastem.success("<?php echo $GLOBALS['mensaje']; ?>");
    });
    setTimeout('window_deslizar_save();', 1000);
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
