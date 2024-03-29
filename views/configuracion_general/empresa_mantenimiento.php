<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
Empresas
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jGrid.js"></script>
    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>
<?php function fncTituloCabecera(){?>
    <i class="fa fa-fax" aria-hidden="true"></i>  Registro de Empresas
    
    
   <div class="pull-right">
            <a onclick="f.enviar();" class="btn btn-success btn-add-skills" style="position: absolute;right: 120px;top: 12px;display: block;">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" style="position: absolute;right: 12px;top: 12px;display: block;">Nuevo &nbsp;<i class="fa fa-plus"></i></a>
        </div>
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<div class="panel panel-success">
       
        <div class="panel-body">
            <center>
                <form id="frm1"  method="post" action="/Configuracion_General/ajaxEmpresa_Mantenimiento">
                    <ul class="nav nav-tabs">

                        <li class="nav-item active"><a href="#vista_buscar" data-toggle="tab" class="nav-link"><i class="fa fa-search-plus" aria-hidden="true"></i> Búsqueda</a></li>
                       
                    </ul>
                    <div class="pull-right">
                        <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" style="margin-bottom: 0;">

                    </div>
                    <div class="tab-content">
                        
                        <div class="tab-pane fade" id="vista_buscar">
                            <div class="row">
                                
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                                    <label>Buscar: </label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                     <input  type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingresar nombres del usuario.">
                                </div>
                               
                            </div>

                        </div>
                        
                    </div>
                    <div class="row">
                        <div id="div1" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
                    </div>
                    <input id="rbOpcion" name="rbOpcion" type="text" value="filtrar" style="display:none;">
                    <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
                    <input id="txtOrden" name="txtOrden" type="text" value="1" style="display:none;">
                    <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">
                </form>
            </center>
        </div>
    </div>

    <script type="text/javascript">
        $('.nav-tabs a').on('show.bs.tab', function(event){
       
        var x = $.trim($(event.target).text());   
       
        switch(x){
            case "Filtro":
                $('#rbOpcion').val('filtrar');
                break;
            case "Búsqueda":
                $('#rbOpcion').val('buscar');
                break;
        }
         
        
     });
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
            function fngetData(){
                f.enviar();
            }
            var fncNuevo=function(){	
                window_open_view('/Configuracion_General/Empresa_Mantenimiento_Nuevo','',null,fngetData);
                //window_open_view('REGISTRAR NUEVA EMPRESA','/Configuracion_General/Empresa_Mantenimiento_Nuevo','','',f);
            }

            var fncEditar=function(id){	
                window_open_view('/Configuracion_General/Empresa_Mantenimiento_Editar',id,null,fngetData);
                //window_float_open('/Configuracion_General/Empresa_Mantenimiento_Editar',id,'',f);
            }
            
           
            var fncEliminar=function(id){			
                gridEliminar(f,id,'/Configuracion_General/ajaxEmpresa_Mantenimiento_Eliminar');
            }
            var fncModulos=function(id){
                window_float_open('/Configuracion_General/Empresa_Mantenimiento_Modulo',id,'',f);
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