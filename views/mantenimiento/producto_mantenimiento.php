<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Información para producto
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
        <i class="fa fa-cubes" aria-hidden="true"></i> Registro de productos
<?php } ?>
<?php function fncPage(){?>
  
    <form id="frm"  method="post" action="/Mantenimiento/ajaxProducto_Mantenimiento" class="form-horizontal">
        <div class="panel panel-tab panel-tab-double shadow">
            <div class="panel-heading no-padding">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> Filtro</a></li>
                    <li><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> Búsqueda</a></li>

                </ul>
                <div style="position: absolute;right: 260px;top: 12px;display: block;">
                    <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" >

                </div>
                <a onclick="f.enviar();" class="btn btn-success btn-add-skills" style="position: absolute;right: 120px;top: 12px;display: block;">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
                <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" style="position: absolute;right: 12px;top: 12px;display: block;">Nuevo &nbsp;<i class="fa fa-plus"></i></a>
           
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="vista_filtrar">
                        <div class="form-group">
                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
                                <label>Línea: </label>
                                <select id="selLinea" name="selLinea" onchange="fncLinea(this.value);" style="width:100%;" class="form-control">
                                    <option value="0">TODOS</option>
                            <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
                                    <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                            <?php } ?>

                                </select>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
                                <label>Categoría: </label>
                                <select id="selCategoria" name="selCategoria" onchange="fncCategoria(this.value);" style="width:100%;" class="form-control">
                                    <option value="0" selected>TODOS</option>
                            <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
                                    <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                            <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
                                <label>Producto: </label>
                                <select id="selProducto" name="selProducto" onchange="fncProducto(this.value);" style="width:100%;" class="form-control">
                                    <option value="0" selected>--</option>
                            <?php foreach($GLOBALS['dtProducto'] as $iProducto){ ?>
                                    <option value="<?php echo $iProducto['ID']; ?>"><?php echo FormatTextView($iProducto['producto']); ?></option>
                            <?php } ?>
                                </select>
                            </div>
                           
                        </div>
                    </div>
                    <div class="tab-pane" id="vista_buscar">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                <label>Código: </label>
                                <input type="number" id="txtCodigo" name="txtCodigo" class="form-control int" style="width:50%;" autocomplete="off">
                            </div>
                            <div class="col-md-6 col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                <label>Nombre: </label>
                                <input  type="text" id="txtBuscar" name="txtBuscar" class="form-control" style="width:100%;" autocomplete="off" placeholder="Ingresar nombre de producto">
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
            grids.fncPaginacionTabs(f,'num_page');	
            $('[data-toggle="tooltip"]').tooltip(); 
            $('#websendeos').stacktable();
    }
   
    $('#txtBuscar,#txtMostrar,#txtCodigo').keypress(function(e){
        
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

        var categoria_ID=$('#selCategoria').val();
        var linea_ID=$('#selLinea').val();
        var Ids=linea_ID+'_'+categoria_ID;
        window_float_open_modal('<i class="fa fa-shopping-cart" aria-hidden="true"></i> REGISTRAR NUEVO PRODUCTO','/Mantenimiento/Producto_mantenimiento_Nuevo',Ids,'',f,800,500);

    }

    var fncEditar=function(id){	
        window_float_open_modal('<i class="fa fa-shopping-cart" aria-hidden="true"></i> EDITAR PRODUCTO','/Mantenimiento/Producto_mantenimiento_Editar',id,'',f,800,500);

    }
    var fncImagen=function(id){
        window_float_open_modal('<i class="fa fa-shopping-cart" aria-hidden="true"></i> REGISTRAR FOTOS DEL PRODUCTO','/Mantenimiento/Producto_mantenimiento_Imagen',id,'',f,800,500);

        //window_float_open('/Mantenimiento/Producto_mantenimiento_Imagen',id,'',f);
    }
    var fncEliminar=function(id){	

            gridEliminar(f,id,'/Mantenimiento/ajaxProducto_mantenimiento_Eliminar');
    }
    var fncLinea=function(linea_ID){
            ajaxSelect('selCategoria', '/Mantenimiento/ajaxSelect_Categoria/' + linea_ID, '',fncCategoria(0));
            //f.enviar();
    }

    var fncCategoria=function(categoria_ID){
        var linea_ID=$('#selLinea').val();
        var ids=linea_ID+"_"+categoria_ID
        ajaxSelect('selProducto', '/Mantenimiento/ajaxSelect_Producto/' + ids, '',null);
           f.enviar();
    }
    var fncProducto=function(id){
        mostrarPadres('producto',id);
        f.enviar();
    }
    var fncEstado=function(){
        f.enviar();
    }
    $('#txtBuscar').focus();

   
</script>

	
<?php } ?>