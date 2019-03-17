<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Anulación de comprobantes
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jGrid.js"></script>

    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
                
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-cut" aria-hidden="true"></i> Registro de anulación de facturas
     <div class="pull-right">
         <a onclick="f.enviar();" class="btn btn-success btn-add-skills">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
           
     </div>
<?php } ?>
<?php function fncPage(){?>
     
<form id="frm1"  method="post" action="/Salida/ajaxAnulacion_Comprobante_Mantenimiento" class="form-horizontal">
<div class="panel panel-tab panel-tab-double shadow">
    <div class="panel-heading no-padding"> 
        <ul class="nav nav-tabs">
            <li class="active nav-border nav-border-top-success"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> <div><span class="text-strong">Filtro</span></div></a></li>
            <li class="nav-border nav-border-top-primary"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>

        </ul>
            <div class='pull-right'>
                <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" >

            </div>
            
            
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
                                <select id="selCliente" name="selCliente" class="form-control chosen-select">
                                    <option value="0">Todos</option>
                                    <?php foreach($GLOBALS['dtCliente'] as $item3){ ?>
                                    <option value="<?php echo $item3['ID'];?>"><?php echo ($item3['razon_social']);?></option>
                                    <?php } ?>
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
                                <input  type="text" id="txtFechaInicio" name="txtFechaInicio" disabled class="date-range-picker-single form-control" autocomplete="off" value="<?php echo date("d/m/Y")?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                <label>Fecha fin: </label>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input  type="text" id="txtFechaFin" name="txtFechaFin" disabled class="date-range-picker-single form-control" autocomplete="off" value="<?php echo date("d/m/Y")?>">
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
                                <select id="selPeriodo" name="selPeriodo" class="form-control">
                                    <option value="0">--</option>
                                    <?php for ($i=periodo_inicio;$i<date("Y");$i++) { ?>
                                    <option value="<?php echo $i?>"><?php echo $i?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                 <label>Serie: </label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                <input type='text' id='txtSerie' name='txtSerie' class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                 <label>N&uacute;mero: </label>
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
    <input id="rbOpcion" name="rbOpcion" type="text" value="filtrar" checked style="display:none;">
    <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
    <input id="txtOrden" name="txtOrden" type="text" style="display:none;" >
    <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox" checked style="display:none;">

        
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
            
            $('[data-toggle="tooltip"]').tooltip(); 
            $('#websendeos').stacktable();
            grids.fncPaginacion1(f);
    }
    f.enviar();
    var fncCargaValores=function(){
        f.enviar();
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


    var fncAnular=function(id){
        window_float_open_modal('ANULACIÓN DE FACTURAS','Salida/anulacion_comprobante_mantenimiento_registro',id,'',f,800,480); 
        
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