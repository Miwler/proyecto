<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Personas
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
		<link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<div class="panel panel-success">
        <div class="panel-heading">
            <div class="row">
                <h2 class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><span class="glyphicon glyphicon-user"></span> Registro de personas</h2>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <button type="button" onclick="fncNuevo();" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Nuevo</button>
                    <button type="button" onclick="f.enviar();" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Actualizar</button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <center>
                <form id="frm1"  method="post" action="/Configuracion_General/ajaxPersona_Mantenimiento">
                    <ul class="nav nav-tabs">
<!--                        <li class="nav-item active"><a href="#vista_filtrar" data-toggle="tab" class="nav-link" ><i class="fa fa-hourglass" aria-hidden="true"></i> Filtro</a></li>-->
                        <li class="active"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> Búsqueda</a></li>
                    </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="vista_buscar">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                         <label>N.Documento: </label>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                        <input type="number" id="txtNumero" name="txtNumero" class="form-control int"  autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                         <label>Buscar: </label>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                         <input  type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingresar Nombres de Persona.">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                         <label>Filas: </label>
                                    </div>

                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                        <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off">
                                    </div>
                                </div> 
                            </div>
                        </div>

                    </div>
                </div>
                    <div class="row">
                        <div id="div1" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
                    </div>
                    
                    <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
                    <input id="txtOrden" name="txtOrden" type="text" value="1" style="display:none;">
                    <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">
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
                    window_float_open('/Configuracion_General/Persona_mantenimiento_Nuevo','','',f);
            }

            var fncEditar=function(id){			
                    window_float_open('/Configuracion_General/Persona_mantenimiento_Editar',id,'',f);
            }

            var fncEliminar=function(id){			
                    gridEliminar(f,id,'/Mantenimiento/ajaxPersona_mantenimiento_Eliminar');
            }

            $('#txtBuscar,#txtMostrar,#txtNumero').keypress(function(e){

                    if (e.which==13){
                            $('#num_page').val(1);
                            f.enviar();
                            return false;
                    }
            });

            $('#txtBuscar').focus();
    </script>
<?php } ?>