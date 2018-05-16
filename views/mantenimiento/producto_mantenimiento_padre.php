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
    <script type="text/javascript">
        $(document).ready(function(){
            mostrar_tabs("productos");
        });
    </script>
   
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
    
<?php function fncTituloCabecera(){?>
        <i class="fa fa-cubes" aria-hidden="true"></i> Registro de productos
<?php } ?>
<?php function fncPage(){?>
  
        <div class="panel panel-tab panel-tab-double shadow">
            <div class="panel-heading">
               
            </div>
            <div class="panel-body">
                 <div class="tab-pane fade in active row" id="vista_productos">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 bhoechie-tab-menu">
                            <div class="list-group-<?php echo $_SESSION['tabs'];?>">
                                <a href="#" class="list-group-item active text-center" onclick="mostrar_tabs('productos')">
                                  <h4><i class="fa fa-shopping-cart" aria-hidden="true"></i></h4>Productos
                                </a>
                                <a href="#" class="list-group-item text-center" onclick="mostrar_tabs('categorias')">
                                  <h4><i class="fa fa-th-list" aria-hidden="true"></i></h4>Categorías
                                </a>
                                <a href="#" class="list-group-item text-center" onclick="mostrar_tabs('lineas')">
                                  <h4><i class="fa fa-align-left" aria-hidden="true"></i></h4>Líneas
                                </a>

                            </div>
                        </div>
                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 bhoechie-tab">
                            <!-- flight section -->
                            <div class="bhoechie-tab-content active">
                                <center>
                                    <form id="frm1" name="frm1" method="post" action="/Mantenimiento/ajaxProducto_Mantenimiento">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> Filtro</a></li>
                                            <li><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> Búsqueda</a></li>
                                            <li style="float:right;"><a class="btn btn-<?php echo $_SESSION['boton'];?>" onclick="fncNuevo();"><span class="glyphicon glyphicon-plus"></span> Nuevo</a></li>
                                            <li style="float:right;"><a class="btn btn-<?php echo $_SESSION['boton'];?>" onclick="f.enviar();"><span class="glyphicon glyphicon-refresh"></span> Ejecutar</a></li>
                                            
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="vista_filtrar">
                                                <div class="row">
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
                                                    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
                                                        <label>Filas: </label>
                                                        <input id="txtMostrar" name="txtMostrar" type="text"  value="30"  style="width:10%;" class="form-control int" autocomplete="off">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vista_buscar">
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
                                        <div class="row">
                                            <div id="divc1" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
                                        </div>
                                        

                                        <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
                                        <input id="txtOrden" name="txtOrden" type="text" value="1" style="display:none;">
                                        <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">
                                    </form>
                                    
                                </center>
                            </div>
                            <!-- train section -->
                            <div class="bhoechie-tab-content">
                                <center>
                                    <form id="frm2"  method="post" action="/Mantenimiento/ajaxCategoria_Mantenimiento">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#vista_filtrar2" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> Filtro</a></li>
                                            <li><a href="#vista_buscar2" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> Búsqueda</a></li>
                                            <li style="float:right;"><a class="btn btn-<?php echo $_SESSION['boton'];?>" onclick="fncNuevo2();"><span class="glyphicon glyphicon-plus"></span> Nuevo</a></li>
                                            <li style="float:right;"><a class="btn btn-<?php echo $_SESSION['boton'];?>" onclick="f2.enviar();"><span class="glyphicon glyphicon-refresh"></span> Ejecutar</a></li>
                                            
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="vista_filtrar2">
                                                <div class="row">
                                                    <div class="col-md-4 col-lg-4 col-sm-4  col-xs-6">
                                                        <label>Línea: </label>
                                                        <select id="selLinea2" name="selLinea2" onchange="fncLinea(this.value);" style="width:100%;" class="form-control">
                                                            <option value="0">TODOS</option>
                                                    <?php foreach($GLOBALS['dtLinea'] as $iLinea){ ?>
                                                            <option value="<?php echo $iLinea['ID']; ?>"><?php echo FormatTextView($iLinea['nombre']); ?></option>
                                                    <?php } ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 col-lg-4 col-sm-4  col-xs-6">
                                                        <label>Categoría: </label>
                                                        <select id="selCategoria2" name="selCategoria2" onchange="fncCategoria2(this.value);" style="width:100%;" class="form-control">
                                                            <option value="0" selected>TODOS</option>
                                                    <?php foreach($GLOBALS['dtCategoria'] as $iCategoria){ ?>
                                                            <option value="<?php echo $iCategoria['ID']; ?>"><?php echo FormatTextView($iCategoria['nombre']); ?></option>
                                                    <?php } ?>
                                                        </select>
                                                    </div>
                                                   
                                                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
                                                        <label>Filas: </label>
                                                        <input id="txtMostrar2" name="txtMostrar2" type="text"  value="30"  style="width:10%;" class="form-control int" autocomplete="off">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vista_buscar2">
                                                <div class="row">
                                                    
                                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                                        <label>Nombre: </label>
                                                        <input  type="text" id="txtBuscar2" name="txtBuscar2" class="form-control" style="width:70%;" autocomplete="off" placeholder="Ingresar nombre de la categoría">
                                                    </div>
                                                    
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="divc2" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
                                        </div>
                                        

                                        <input id="num_page2" name="num_page2" type="text" value="1" style="display:none;">
                                        <input id="txtOrden2" name="txtOrden2" type="text" value="1" style="display:none;">
                                        <input id="chkOrdenASC2" name="chkOrdenASC2" type="checkbox" checked style="display:none;">
                                    </form>
                                </center>
                            </div>

                            <!-- hotel search -->
                            <div class="bhoechie-tab-content">
                                <center>
                                    <form id="frm3"  method="post" action="/Mantenimiento/ajaxLinea_Mantenimiento">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#vista_buscar3" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> Búsqueda</a></li>
                                            <li style="float:right;"><a class="btn btn-<?php echo $_SESSION['boton'];?>" onclick="fncNuevo3();"><span class="glyphicon glyphicon-plus"></span> Nuevo</a></li>
                                            <li style="float:right;"><a class="btn btn-<?php echo $_SESSION['boton'];?>" onclick="f3.enviar();"><span class="glyphicon glyphicon-refresh"></span> Ejecutar</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="vista_buscar3">
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-sm-6  col-xs-6">
                                                        <label>Nombre: </label>
                                                        <input  type="text" id="txtBuscar3" name="txtBuscar3" class="form-control" style="width:80%;" autocomplete="off"  placeholder="Ingresar nombre de la línea">
                                                        
                                                    </div>
                                                   
                                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                                        <label>Filas: </label>
                                                        <input id="txtMostrar3" name="txtMostrar3" type="text"  value="30"  style="width:10%;" class="form-control int" autocomplete="off">
                                                    </div>

                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div id="div3" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
                                        </div>
                                        <input id="num_page3" name="num_page3" type="text" value="1" style="display:none;">
                                        <input id="txtOrden3" name="txtOrden3" type="text" value="1" style="display:none;">
                                        <input id="chkOrdenASC3" name="chkOrdenASC3" type="checkbox" checked style="display:none;">
                                    </form>
                                </center>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
   
                

<script type="text/javascript">
    var mostrar_tabs=function(vista){
        
        switch(vista){
            case "productos":
                 f.enviar();
                break;
            case "categorias":
                f2.enviar();
                break;
            case "lineas":
               
                f3.enviar();
                break;
        }
    }

    var f=new form('frm1','divc1');

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

        window_float_open('/Mantenimiento/Producto_mantenimiento_Nuevo',Ids,'',f);
    }

    var fncEditar=function(id){			
        window_float_open('/Mantenimiento/Producto_mantenimiento_Editar',id,'',f);
    }
    var fncImagen=function(id){
        window_float_open('/Mantenimiento/Producto_mantenimiento_Imagen',id,'',f);
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
        ajaxSelect('selProducto', '/Mantenimiento/ajaxSelect_Producto/' + ids, '',mostrarPadres('categoria',categoria_ID));
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

    var mostrarPadres=function(tipo,id){

        var valor=tipo+"_"+id;
        //alert(valor);
        cargarValores('/Mantenimiento/AjaxSeleccionarPadres',valor,function(resultado){
            switch(resultado.tipo){
                case "categoria":
                    if(resultado.linea_ID!=0){
                        $('#selLinea').val(resultado.linea_ID);
                    }

                     break;
                case "categoria2":

                    $('#selLinea2').val(resultado.linea_ID);
                     break;
                case "producto":

                    $('#selLinea').val(resultado.linea_ID);
                    ajaxSelect('selCategoria', '/Mantenimiento/ajaxSelect_Categoria/' + resultado.linea_ID, '',function(){$('#selCategoria').val(resultado.categoria_ID);});
                    break;
            }


        });
    }
</script>
<script type="text/javascript">
    var f2=new form('frm2','divc2');
    f2.terminado = function () {

            var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];

            grids = new grid(tb);
            grids.nuevoEvento();
            grids.fncPaginacionTabs(f2,'num_page2');	
            $('[data-toggle="tooltip"]').tooltip(); 
            $('#websendeos').stacktable();			
    }
    

    var fncOrden2=function(col){

            var col_old=$('#txtOrden2').val();

            if(col_old==col){
                    if($('#chkOrdenASC2').is(':checked')){
                            $('#chkOrdenASC2').prop('checked',false);
                    }else{
                            $('#chkOrdenASC2').prop('checked',true);
                    }
            }else{
                    $('#txtOrden2').val(col);
                    $('#chkOrdenASC2').prop('checked',true);
            }		

            f2.enviar();
    }

    var fncNuevo2=function(){	
        var linea_ID=$('#selLinea2').val();				
        window_float_open('/Mantenimiento/Categoria_mantenimiento_Nuevo',linea_ID,'',f2);
    }

    var fncEditar2=function(id){			
            window_float_open('/Mantenimiento/Categoria_mantenimiento_Editar',id,'',f2);
    }

    var fncEliminar2=function(id){			
            gridEliminar(f2,id,'/Mantenimiento/ajaxCategoria_mantenimiento_Eliminar');
    }

    $('#txtBuscar2,#txtMostrar2').keypress(function(e){

            if (e.which==13){
                    $('#num_page2').val(1);
                    f2.enviar();
                    return false;
            }
    });
    var fncLinea2=function(){

        var obj = $('#selLinea2');

        ajaxSelect('selCategoria2', '/Mantenimiento/ajaxSelect_Categoria/' + obj.val(), '',f2.enviar());

    }
    var fncCategoria2=function(id){

        mostrarPadres("categoria2",id);
        f2.enviar()
    }

    $('#txtBuscar2').focus();
</script>
<script type="text/javascript">
    
    var f3=new form('frm3','div3');
    //f3.txtnum=$('#txtOrden3').val();
    f3.terminado = function () {

            var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];

            grids = new grid(tb);
            grids.nuevoEvento();
            grids.fncPaginacionTabs(f3,'num_page3');
            $('[data-toggle="tooltip"]').tooltip(); 
            $('#websendeos').stacktable();			
    }
    var fncOrden3=function(col){

            var col_old=$('#txtOrden3').val();

            if(col_old==col){
                    if($('#chkOrdenASC3').is(':checked')){
                            $('#chkOrdenASC3').prop('checked',false);
                    }else{
                            $('#chkOrdenASC3').prop('checked',true);
                    }
            }else{
                    $('#txtOrden3').val(col);
                    $('#chkOrdenASC3').prop('checked',true);
            }		

            f3.enviar();
    }

    var fncNuevo3=function(){			
            window_float_open('/Mantenimiento/Linea_mantenimiento_Nuevo','','',f3);
    }

    var fncEditar3=function(id){			
            window_float_open('/Mantenimiento/Linea_mantenimiento_Editar',id,'',f3);
    }

    var fncEliminar3=function(id){			
            gridEliminar(f3,id,'/Mantenimiento/ajaxLinea_mantenimiento_Eliminar');
    }

    $('#txtBuscar3,#txtMostrar3').keypress(function(e){

            if (e.which==13){
                    $('#num_page3').val(1);
                    f3.enviar();
                    return false;
            }
    });

    $('#txtBuscar3').focus();
</script>
    
	
<?php } ?>