<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Categorías
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jGrid.js"></script>
    <script type="text/javascript" src="include/js/jCboDiv.js"></script>
    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
    
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
    
<?php function fncTituloCabecera(){?>
        <i class="fa fa-cubes" aria-hidden="true"></i> Registro de Categoría
        <div class="pull-right">
            <a onclick="f.enviar();" class="btn btn-success btn-add-skills" >Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" >Nuevo &nbsp;<i class="fa fa-plus"></i></a>
        </div>
<?php } ?>
<?php function fncPage(){?>
<form id="frm"  method="post" action="/Mantenimiento/ajaxCategoria_Mantenimiento" class="form-horizontal">
    <div class="panel panel-tab panel-tab-double shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> Filtro</a></li>
                <li><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> Búsqueda</a></li>
            </ul>
            <div class="pull-right">
                <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" >
            </div>
            
        </div>
        <div class="panel-body form-horizontal">
            <div class="tab-content">
                <div class="tab-pane active" id="vista_filtrar">
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Línea: </label>
                        <div class="col-sm-3">
                            
                            <select id="selLinea" name="selLinea" onchange="fncLinea(this.value);" style="width:100%;" class="form-control">
                                <option value="0">TODOS</option>
                        <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
                                <option value="<?php echo $iLinea['ID']; ?>"><?php echo $iLinea['nombre']; ?></option>
                        <?php } ?>

                            </select>
                        </div>
                        <label class="control-label col-sm-3">Categoría: </label>
                        <div class="col-sm-3">
                            
                            <select id="selCategoria" name="selCategoria" onchange="fncCategoria();" style="width:100%;" class="form-control">
                                <option value="0" selected>TODOS</option>
                        <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
                                <option value="<?php echo $iCategoria['ID']; ?>"><?php echo $iCategoria['nombre']; ?></option>
                        <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="vista_buscar">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Nombre: </label>
                        <div class="col-sm-8">
                            
                            <input  type="text" id="txtBuscar" name="txtBuscar" class="form-control" style="width:70%;" autocomplete="off" placeholder="Ingresar nombre de la categoría">
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
    <input id="txtOrden" name="txtOrden" type="text" value="0" style="display:none;">
    <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">
</form>
<script type="text/javascript">
   $('.nav  a').on('show.bs.tab', function(event){
       
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

    var f=new form('frm','div1');

    f.terminado = function () {

            var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];

            grids = new grid(tb);
            grids.nuevoEvento();
            	
            $('[data-toggle="tooltip"]').tooltip(); 
            $('#websendeos').stacktable();
            grids.fncPaginacionTabs(f,'num_page');
    }
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
    $('#txtBuscar,#txtMostrar').keypress(function(e){
        
    if (e.which==13){
            $('#num_page').val(1);
            f.enviar();
            return false;
        }
    });    
    f.enviar();
    

    var fncNuevo=function(){

        var linea_ID=$('#selLinea').val();				
        window_float_open_modal('<i class="fa fa-shopping-cart" aria-hidden="true"></i> REGISTRAR NUEVA CATEGORÍA','/Mantenimiento/Categoria_mantenimiento_Nuevo','','',f,800,480);

    }

    var fncEditar=function(id){	
        
        window_float_open_modal('<i class="fa fa-shopping-cart" aria-hidden="true"></i> EDITAR CATEGORÍA','/Mantenimiento/Categoria_mantenimiento_Editar',id,'',f,800,480);

    }
    
    var fncEliminar=function(id){	

            gridEliminar(f,id,'/Mantenimiento/ajaxCategoria_mantenimiento_Eliminar');
    }
    var fncLinea=function(linea_ID){
            ajaxSelect('selCategoria', '/Mantenimiento/ajaxSelect_Categoria/' + linea_ID, '',fncCategoria(0));
            //f.enviar();
    }

    var fncCategoria=function(){
        
           f.enviar();
    }
    
    
    $('#txtBuscar').focus();

   
</script>

	
<?php } ?>