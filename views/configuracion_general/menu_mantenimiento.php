<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
Menú
<?php } ?>

<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jGrid.js"></script>
    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
    <i class="fa fa-list"></i>Menú
 <div class="pull-right">
                    <button type="button" onclick="fncNuevo();" class="btn btn-primary btn-add-skills"><i class="fa fa-plus"></i> Nuevo</button>
                    <button type="button" onclick="f.enviar();" class="btn btn-success btn-add-skills"><i class="fa fa-refresh"></i> Actualizar</button>
                </div>
<?php } ?>
<?php function fncPage(){?>
 <form id="frm1"  method="post" action="/Configuracion_General/ajaxMenu_Mantenimiento">
     <div class="panel panel-tab panel-tab-double shadow">
         <div class="panel-heading no-padding">
             <ul class="nav nav-tabs">

                    <li class="active nav-border nav-border-top-primary"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Filtro</span></div></a></li>
                    <li class="nav-border nav-border-top-teal"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>

            </ul>
            <div class="pull-right">
                <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" style="margin-bottom: 0;">

            </div>
         </div>
         <div class="panel-body">
             <div class="tab-content">
                <div class="tab-pane fade in active" id="vista_filtrar">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                            <label>Módulo: </label>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <select id="selModulo" name="selModulo" class="form-control">
                                <option value="0">Todos</option>
                                <?php foreach($GLOBALS['dtModulo'] as $modulo){?>
                                <option value="<?php echo $modulo['ID']?>"><?php echo FormatTextView($modulo['nombre']);?></option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                </div>
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
                    window_float_open('/Configuracion_General/Menu_Mantenimiento_Nuevo','','',f);
            }

            var fncEditar=function(id){			
                    window_float_open('/Configuracion_General/Menu_mantenimiento_Editar',id,'',f);
            }
            
           
            var fncEliminar=function(id){			
                    gridEliminar(f,id,'/Configuracion_General/ajaxMenu_Mantenimiento_Eliminar');
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