<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Comunicación de baja
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
		<link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
        <i class="fa fa-cut" aria-hidden="true"></i> Comunicación de baja de comprobante electrónico
        <div class="pull-right">
            <a onclick="f.enviar();" class="btn btn-success btn-add-skills" style="position: absolute;right: 120px;top: 12px;display: block;">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" style="position: absolute;right: 12px;top: 12px;display: block;">Nuevo &nbsp;<i class="fa fa-plus"></i></a>
            
        </div>
<?php } ?>
<?php function fncPage(){?>
<form id="frm1" name="frm1" method="post" action="Salida/ajaxComunicacion_Baja_Mantenimiento" class="form-horizontal">
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
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                            <div class="form-group">
                                <label class="control-label col-sm-5">Tipo comprobante: </label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                    <select id="selTipoComprobante" name="selTipoComprobante" class="form-control">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label class="control-label col-sm-5">Número: </label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                     <input  type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" >
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
                
                $('[data-toggle="tooltip"]').tooltip(); 
                $('#websendeos').stacktable();
                grids.fncPaginacion1(f);
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
               
                window_float_open_modal('REGISTRAR BAJA DE COMPROBANTE','/Salida/Comunicacion_Baja_Mantenimiento_Nuevo','','',f,450,750);
        }

        var fncEditar=function(id){			
                window_float_open_modal('EDITAR VEHICULO','/Salida/Vehiculo_Mantenimiento_Editar',id,'',f,400,800);
        }

        var fncEliminar=function(id){			
                gridEliminar(f,id,'/Salida/ajaxComunicacion_Baja_Mantenimiento_Eliminar');
        }
        var fncEnviarSUNAT=function(id){
            block_ui(function(){
                cargarValores('/Salida/ajaxEnviarComunicacionSUNAT',id,function(resultado){
                    $.unblockUI();
                    if(resultado.resultado==1){
                        f.enviar();
                        toastem.success(resultado.mensaje);
                    }else{
                        mensaje.error("Ocurrió un error",resultado.mensaje);
                    }
                });
            });
            
        }
        $('#txtBuscar,#txtMostrar,#txtCodigo').keypress(function(e){			
                if (e.which==13){
                        $('#num_page').val(1);
                        f.enviar();
                        return false;
                }
        });

        $('#txtBuscar').focus();
</script>

<?php } ?>