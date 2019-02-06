<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Información para linea de producto
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
        <i class="fa fa-cubes" aria-hidden="true"></i> Registro de Línea
        <div class="pull-right">
            <a onclick="f.enviar();" class="btn btn-success btn-add-skills" >Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" >Nuevo &nbsp;<i class="fa fa-plus"></i></a>

        </div>
<?php } ?>
<?php function fncPage(){?>
<form id="frm"  method="post" action="/Mantenimiento/ajaxLinea_Mantenimiento" class="form-horizontal">
    <div class="panel panel-tab panel-tab-double shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">

                <li class="active"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> Búsqueda</a></li>
            </ul>
            <div class="pull-right">
                <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" >
            </div>
            
        </div>
        <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="vista_buscar">
                        <div class="form-group">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                 <label>Nombre: </label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                <input  type="text" id="txtBuscar" name="txtBuscar" class="form-control" autocomplete="off" placeholder="Ingresar nombre de linea de producto.">
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
    <input id="chkOrdenASC" name="chkOrdenDESC" type="checkbox" checked style="display:none;">
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
   
    $('#txtBuscar,#txtMostrar').keypress(function(e){
        
    if (e.which==13){
            $('#num_page').val(1);
            f.enviar();
            return false;
        }
    });    
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

        var linea_ID=$('#selLinea').val();				
        window_float_open_modal('<i class="fa fa-shopping-cart" aria-hidden="true"></i> REGISTRAR NUEVA LÍNEA','/Mantenimiento/Linea_mantenimiento_Nuevo','','',f,null,470);

    }

    var fncEditar=function(id){	
        
        window_float_open_modal('<i class="fa fa-shopping-cart" aria-hidden="true"></i> EDITAR LÍNEA','/Mantenimiento/Linea_mantenimiento_Editar',id,'',f,null,470);

    }
    
    var fncEliminar=function(id){	
        gridEliminar(f,id,'/Mantenimiento/ajaxLinea_mantenimiento_Eliminar');
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