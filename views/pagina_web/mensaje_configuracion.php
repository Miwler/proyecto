<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Mantenimiento Marcas
<?php } ?>
<?php function fncHead(){?>
        <script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jGrid.js"></script>
        <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
<?php } ?>

<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
        <i class="fa fa-envelope" aria-hidden="true"></i> Correos recibidos
<?php } ?>
<?php function fncPage(){?>
    <form id="frm1" name="frm1" method="post" action="/pagina_web/ajaxMensaje_Configuracion" class="form-horizontal">
    <div class="panel panel-tab panel-tab-double shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">
                
                <li class="active nav-border nav-border-top-primary"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>
               
            </ul>
            <div style="position: absolute;right: 260px;top: 12px;display: block;">
                <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" >

            </div>
            
            <a onclick="f.enviar();" class="btn btn-success btn-add-skills" style="position: absolute;right: 120px;top: 12px;display: block;">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" style="position: absolute;right: 12px;top: 12px;display: block;">Nuevo &nbsp;<i class="fa fa-plus"></i></a>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane active" id="vista_buscar">
                    <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label>Buscar</label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input type="text" id="txtBuscar" name="txtBuscar" class="form-control" placeholder="Nombre de banner">

                            </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12" id="div1">
                </div>
            </div>
        </div>
        
    </div>
        <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
        <input id="txtOrden" name="txtOrden" type="text" value="1" style="display:none;">
        <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">           
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

        

        var fncEditar=function(id){			
            window_float_open('/Pagina_Web/Mensaje_Configuracion_Editar',id,'',f);
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