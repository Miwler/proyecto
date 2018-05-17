<?php		
	require ROOT_PATH . "views/shared/content-float-modal.php";
?>	
<?php function fncTitle(){?>
		Asignar Cliente
<?php } ?>
<?php function fncHead(){?>

        <link rel="stylesheet" type="text/css" href="include/css/cbo.css" />
        <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
        <script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jGrid.js"></script>
		
<?php } ?>

<?php

function fncTitleHead() { ?>Asignar Cliente<?php } ?>

<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<div class="panel panel-<?php echo $_SESSION['cabecera']?>">
    
    <div class="panel-body">
        <form id="frm1" method="post"  action="/Mantenimiento/Operador_Mantenimiento_Asignar_Cliente">
            <div class="panel panel-info">
                <div class="panel-heading">Clientes asignados</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="height: 250px; overflow:auto;">
                            <div id="div1"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info" >
                <div class="panel-heading">Clientes libres</div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="height: 250px; overflow:auto;">
                            <div id="div2"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <input id="txtOperador_ID"  name="txtOperador_ID" type="text" style="display:none;"  value="<?php echo $GLOBALS['operador_ID']; ?>"/>
        
	</form>	
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-md-12 col-lg-12">
                <button type="button" class="btn btn-danger" onclick="window_float_close();" >Cerrar</button>
            </div>
        </div>
    </div>
</div>

	
	
	<script type="text/javascript">
            $(document).ready(function(){
                ver_clientes_asignados();
                ver_clientes_libres();
            });
            function seleccionar(cliente_ID){
               
                var operador_ID=$('#txtOperador_ID').val();
                cargarValores1('Mantenimiento/ajaxAsignar_Cliente_Seleccionar',operador_ID,cliente_ID,function(resultado){
                    if(resultado.resultado!=-1){
                        toastem.success(resultado.mensaje);
                        ver_clientes_asignados();
                        ver_clientes_libres();
                    }else{
                        toastem.error(resultado.mensaje);
                    }
                });
                   //seleccionarCk('Mantenimiento/ajaxAsignar_Cliente_Seleccionar',operador_ID,cliente_ID);
                   //f.enviar();
            }
            
            var ver_clientes_libres=function(){
                cargarValores('mantenimiento/ajaxClientes_Libres','',function(resultado){
                    $("#div2").html(resultado.html);
                });
            }
            var ver_clientes_asignados=function(){
                var operador_ID=$("#txtOperador_ID").val();
                cargarValores('mantenimiento/ajaxClientes_Asignados',operador_ID,function(resultado){
                    $("#div1").html(resultado.html);
                });
            }
		
	</script>
        

<?php } ?>