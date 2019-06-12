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
<?php function fncTituloCabecera(){?>
        <i class="fa fa-credit-card" aria-hidden="true"></i>Registro de número de cuenta
        <div class="pull-right">
            <a onclick="f.enviar();" class="btn btn-success btn-add-skills" >Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" >Nuevo &nbsp;<i class="fa fa-plus"></i></a>
        </div>
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<form id="frm1" method="post" action="/Mantenimiento/ajaxNumero_Cuenta_Mantenimiento" class="form-horizontal">
<div class="panel panel-tab panel-tab-double shadow">
    <div class="panel-heading no-padding">
        <ul class="nav nav-tabs">

            <li class="active nav-border nav-border-top-primary"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>

        </ul>
        <div class="pull-right">
            <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" >

        </div>

        
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="vista_buscar">
                <div class="form-group">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                 <label>Buscar: </label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                 <input  type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingresar numero de cuenta.">
                            </div>
                        </div>
                    </div>
                   
                </div>

            </div>
        </div>
        <div class="form-group">
            <div id="div1" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
        </div>
        <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
        <input id="txtOrden" name="txtOrden" type="text" value="0" style="display:none;">
        <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">


    </div>
</div>
</form>		
	
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
            window_float_open_modal('REGISTRAR NUEVO NÚMERO DE CUENTA','/Mantenimiento/Numero_Cuenta_Mantenimiento_Nuevo','','',f,700,350);

        }

        var fncEditar=function(id){
           window_float_open_modal('EDITAR NÚMERO DE CUENTA','/Mantenimiento/Numero_Cuenta_Mantenimiento_Editar',id,'',f,700,350);
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