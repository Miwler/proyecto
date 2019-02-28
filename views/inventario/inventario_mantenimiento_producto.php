<?php
require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php

function fncTitle() { ?> Kardex de producto<?php } ?>

<?php

function fncHead() { ?>
   

   
    <script type="text/javascript" src="include/js/jForm.js"></script>
   
<?php } ?>

<?php

function fncTitleHead() { ?>Kardex de producto<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
    <form id="frm1" name="frm1" method="POST"  action="/Inventario/inventario_mantenimiento_producto/<?php echo $GLOBALS['oInventario']->producto_ID;?>" class="form-horizontal" >
        <div class="form-group">
            <label class="control-label col-sm-2">Producto:</label>
            <label class="col-sm-4"><b> <?php echo $GLOBALS['oProducto']->nombre?></b></label>
            
            <label class="control-label col-sm-3">Unidad medida:</label>
            <label class="col-sm-3"><b><?php echo $GLOBALS['oProducto']->unidad_medida?></b></label>
            
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Código:</label>
            <label class="col-sm-4"><b><?php echo sprintf("%'.05d",$GLOBALS['oProducto']->codigo);?></b></label>
           
            <label class="control-label col-sm-3">Método:</label>
            <div class="col-sm-3">
                <b>Promedio</b>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12" style="height: 420px;overflow:auto;">
                <?php echo $GLOBALS['tabla'];?>
            </div>
        </div>
  

    </form>
<?php } ?>
<div id="script"></div>
<div id="cuerpo"></div>
<script type="text/javascript">
  var fncVerSeries=function(tipo,codigo){
      parent.window_float_open_modal_hijo("VER SERIE DE PRODUCTOS",'Inventario/Inventario_Mantenimiento_Serie',codigo,'tipo='+tipo,null,null,500);
      /*$('#fondo_mensaje').css('display','block');
      cargarValores1('inventario/ajaxVerSeries',tipo,codigo,function(resultado){
          $('#cuerpo').html(resultado.resultado);
          
      });*/
  }
  var fncCerrar=function(){
      $('#fondo_mensaje').css('display','none');
      $('#cuerpo').html('');
  } 
</script>  

   
<?php } ?>
