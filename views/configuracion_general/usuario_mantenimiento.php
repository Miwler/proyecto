<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Usuarios
<?php } ?>
<?php function fncHead(){?>
		<script type="text/javascript" src="include/js/jForm.js"></script>
		<script type="text/javascript" src="include/js/jGrid.js"></script>
		<link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-shopping-cart" aria-hidden="true"></i> Registro de usuarios
     <div class="pull-right">
        <a onclick="f.enviar();" class="btn btn-success btn-add-skills" >Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
        <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" >Nuevo &nbsp;<i class="fa fa-plus"></i></a>
           
         <div class="clearfix"></div>
     </div>
<?php } ?>
<?php function fncPage(){?>
<form id="frm1"  method="post" action="/Configuracion_General/ajaxUsuario_Mantenimiento" class="form-horizontal">
<div class="panel panel-tab panel-tab-double shadow">
        <div class="panel-heading no-padding">
           <ul class="nav nav-tabs">
                <li class="active nav-border nav-border-top-success"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> <div><span class="text-strong">Filtro</span></div></a></li>
                <li class="nav-border nav-border-top-primary"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>
                
            </ul>
            
            <div class="pull-right">
                <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" >
            </div>
            
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane active" id="vista_filtrar">
                    <div class="form-group">
                        
                        <label class="control-label col-sm-2">Estado: </label>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <select id="selEstado" name="selEstado" class="form-control">
                                <option value="0">Todos</option>
                                <?php foreach($GLOBALS['oUsuario']->dtEstado as $estado){?>
                                <option value="<?php echo $estado['ID']?>"><?php echo FormatTextView($estado['nombre']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <label class="control-label col-sm-2">Perfil: </label>
                        
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <select id="selPerfil" name="selPerfil" class="form-control">
                                 <option value="0">Todos</option>
                                <?php foreach($GLOBALS['oUsuario']->dtPerfil as $perfil){?>
                                <option value="<?php echo $perfil['ID']?>"><?php echo FormatTextView($perfil['nombre']);?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="vista_buscar">
                    <div class="form-group">

                        <label  class="control-label col-sm-2">Buscar: </label>
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
            <input id="txtOrden" name="txtOrden" type="text" value="0" style="display:none;">
            <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">
                
          
        </div>
    </div>
</form>
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
            function fncCargar(){
                f.enviar();
            }
            var fncNuevo=function(){	
                window_float_open_modal('NUEVO USUARIO','/Configuracion_General/Usuario_mantenimiento_Nuevo','','',f,null,300);
                
            }

            var fncEditar=function(id){	
                 window_float_open_modal('EDITAR USUARIO','/Configuracion_General/Usuario_mantenimiento_Editar',id,'',f,null,300);
                  
            }
            var fncMenu=function(id){
               
                window_float_open_modal('<span class="glyphicon glyphicon-user"></span> ASIGNAR MENÚ','/Configuracion_General/Usuario_mantenimiento_Menu',id,'',f,null,540);
               
            }
            var fncReporte=function(id){
               
                window_float_open_modal('<span class="glyphicon glyphicon-user"></span> ASIGNAR REPORTES','/Configuracion_General/Usuario_mantenimiento_Reporte',id,'',f,null,540);
               
            }
            var fncPerfil=function(id){
                window_float_open_modal('<i class="fa fa-users"></i> ASIGNAR PERFIL','/Configuracion_General/Usuario_mantenimiento_Perfil',id,'',f,900,440);
               
            }
           
            var fncEliminar=function(id){			
                    gridEliminar(f,id,'/Mantenimiento/ajaxUsuario_mantenimiento_Eliminar');
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