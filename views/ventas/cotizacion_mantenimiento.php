<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Registro de Cotizaciones
<?php } ?>
<?php function fncHead(){?>
        <script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jGrid.js"></script>
        <link rel="stylesheet" type="text/css" href="include/css/grid.css" />

<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-file-text-o" aria-hidden="true"></i> Registro de cotizaciones
<?php } ?>
<?php function fncPage(){?>
<form id="frm1"  method="post" action="/Ventas/ajaxCotizacion_Mantenimiento" class="form-horizontal">

<div class="panel panel-tab panel-tab-double shadow">

    <div class="panel-heading no-padding"> 
         <ul class="nav nav-tabs">
                <li class="active nav-border nav-border-top-success"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> <div><span class="text-strong">Filtro</span></div></a></li>
                <li class="nav-border nav-border-top-primary"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>
               
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
                    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                <label>Cliente: </label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <select id="selCliente" name="selCliente" class="chosen-select">
                                    <option value="0">-TODOS-</option>
                                    <?php foreach($GLOBALS['dtCliente'] as $cliente){?>
                                    <option value="<?php echo $cliente['ID']?>"><?php echo FormatTextView($cliente['ruc'].' - '.$cliente['razon_social'])?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 text-left">
                                 <label>Todos: </label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                                <div class="ckbox ckbox-theme">
                                    <input  type="checkbox" id="checkbox-checked1" checked="checked" name="ckTodos" value="1" >
                                    <label for="checkbox-checked1"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                 <label>Fecha inicio: </label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input  type="text" id="txtFechaInicio" name="txtFechaInicio" disabled class="form-control date-range-picker-single" autocomplete="off" value="<?php echo date("d/m/Y")?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                 <label>Fecha fin: </label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <input  type="text" id="txtFechaFin" name="txtFechaFin" disabled class="form-control date-range-picker-single" autocomplete="off" value="<?php echo date("d/m/Y")?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                 <label>Estado: </label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <select id="selEstado" name="selEstado"  class="form-control text-uppercase">
                                    <option value="0">TODOS</option>
                                    <?php foreach($GLOBALS['dtEstado'] as $estado){?>
                                    <option value="<?php echo $estado['ID'] ;?>"><?php echo FormatTextView($estado['nombre']) ;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                 <label>Moneda: </label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <select id="selMoneda" name="selMoneda" class="form-control text-uppercase" >
                                    <option value="0">TODOS</option>
                                    <?php foreach($GLOBALS['dtMoneda'] as $moneda){?>
                                    <option value="<?php echo $moneda['ID'] ;?>"><?php echo FormatTextView($moneda['descripcion']) ;?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="vista_buscar">
                <div class="form-group">
                    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                 <label>Periodo: </label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                <input type="text" id="txtPeriodo" name="txtPeriodo" class="form-control int"  autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                 <label>Número: </label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                 <input  type="text" id="txtNumero" name="txtNumero" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div id="div1" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
        </div>

        <input id="rbOpcion" name="rbOpcion" type="text" value="filtrar" style="display:none;">
        <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
        <input id="txtOrden" name="txtOrden" type="text" value="1" style="display:none;">
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
     $("#checkbox-checked1").click(function(){
        if($(this).is(":checked")){
            $("#txtFechaInicio").prop("disabled", true);
            $("#txtFechaFin").prop("disabled", true);
            $("#txtFechaInicio").focus();
        }else{
            $("#txtFechaInicio").prop("disabled", false);
            $("#txtFechaFin").prop("disabled", false);
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
    var fncNuevo=function(){
        window_float_open_modal('REGISTRAR NUEVA COTIZACIÓN','Ventas/Cotizacion_Mantenimiento_Nuevo','','',f,800,550);
      
    }
   
    var fncEditar=function(id){	
        window_float_open_modal('EDITAR COTIZACIÓN','/Ventas/Cotizacion_Mantenimiento_Editar',id,'',f,800,550);
        

    }
    var fncClonar=function(id){	
        window_float_open_modal('CLONAR COTIZACIÓN','/Ventas/Cotizacion_Mantenimiento_Clonar',id,'',f,800,550);  
    }
    var fncEliminar=function(id){	
        gridEliminar(f,id,'/Ventas/ajaxCotizacion_Mantenimiento_Eliminar');
    }

    $('#txtBuscar,#txtMostrar,#txtPeriodo,#txtNumero').keypress(function(e){			
        if (e.which==13){
                $('#num_page').val(1);
                f.enviar();
                return false;
        }
    });

    function fncNumero(){
        var numero=$('#txtNumero').val();
        var nNumero=('0000000'+numero);

        $('#txtNumero').val(nNumero.substring(nNumero.length-9,nNumero.length));
    }
    $('#txtBuscar').focus();
    $('#ckTodos').click(function(){
        if($(this).prop('checked')){
            $('#txtFechaInicio').prop('disabled', true);
            $('#txtFechaFin').prop('disabled', true);
        }else {
            $('#txtFechaInicio').prop('disabled', false);
            $('#txtFechaFin').prop('disabled', false);
        }
    });
    var fncCargarVista=function(valor){
        $('#rbOpcion').val(valor);
    }
</script>

<?php } ?>