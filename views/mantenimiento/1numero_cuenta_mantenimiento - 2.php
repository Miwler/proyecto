<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Numero de cuenta
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
		<link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<div class="panel panel-<?php echo $_SESSION['cabecera']?>">
        <div class="panel-heading">
            <div class="row">
                <h2 class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><i class="fa fa-cc-visa" aria-hidden="true"></i> Registro de número de cuenta</h2>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                        <button type="button" onclick="fncNuevo();" class="btn btn-<?php echo $_SESSION['boton'];?>"><span class="glyphicon glyphicon-plus"></span> Nuevo</button>
                        <button type="button" onclick="f.enviar();" class="btn btn-<?php echo $_SESSION['boton'];?>"><span class="glyphicon glyphicon-refresh"></span> Actualizar</button> 
                </div>
            </div>
           
        </div>
        <div class="panel-body">
            <center>
                <form id="frm1" method="post" action="/Mantenimiento/ajaxNumero_Cuenta_Mantenimiento">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-3">
                            <label>Buscar:</label>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                            <input id="txtBuscar" type="text"  name="txtBuscar" class="form-control" placeholder="Ingrese el texto a buscar">
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-3">
                            <label>Registros a mostrar:</label>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                            <input id="txtMostrar" name="txtMostrar" type="text"  class="int form-control" value="30" >
                        </div>
                    </div>
                    <div class="row">
                        <div id="div1" class="col-md-2 col-lg-2 col-sm-2 col-xs-3 grid-content">
                            
                        </div>
                    </div>
                    <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
                    <input id="txtOrden" name="txtOrden" type="text" value="1" style="display:none;">
                    <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox" checked style="display:none;">
                </form>	
            </center>
        </div>
</div>
	
	
<script type="text/javascript">
        var f=new form('frm1','div1');
        f.terminado = function () {
                var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];

                grids = new grid(tb);
                grids.nuevoEvento();
                grids.fncPaginacion1(f);
                $('[data-toggle="tooltip"]').tooltip(); 
                $('#websendeos').stacktable();
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
                window_float_open('/Mantenimiento/Numero_Cuenta_Mantenimiento_Nuevo','','',f);
        }

        var fncEditar=function(id){			
                window_float_open('/Mantenimiento/Numero_Cuenta_Mantenimiento_Editar',id,'',f);
        }

        var fncEliminar=function(id){			
                gridEliminar(f,id,'/Mantenimiento/ajaxNumero_Cuenta_Mantenimiento_Eliminar','divMensaje');
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