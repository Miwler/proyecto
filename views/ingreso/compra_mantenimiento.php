<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Registro de comprobantes de compras
<?php } ?>
<?php function fncHead(){?>
        <script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jGrid.js"></script>

        <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
        <style>
            .st-val{
                text-align:left!important;
            }
            .st-key{
                font-weight: bold;
            }
        </style>        
         
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-shopping-cart" aria-hidden="true"></i> Registros de compras
     <div class="pull-right">
        <a onclick="f.enviar();" class="btn btn-success btn-add-skills">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
        <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills">Nuevo &nbsp;<i class="fa fa-plus"></i></a>
          
     </div>
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
<form id="frm1"  method="post" action="/Ingreso/ajaxCompra_Mantenimiento" class="form-horizontal">
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
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                    <label>Proveedor: </label>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <select id="selProveedor" name="selProveedor" class="chosen-select">
                                        <option value="0">-TODOS-</option>
                                        <?php foreach($GLOBALS['dtProveedor'] as $proveedor){?>
                                        <option value="<?php echo $proveedor['ID']?>"><?php echo strtoupper(utf8_encode($proveedor['razon_social']))?></option>
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
                                    <input  type="text" id="txtFechaInicio" name="txtFechaInicio" class="form-control date-range-picker-single" disabled autocomplete="off" value="<?php echo date("d/m/Y")?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                     <label>Fecha fin: </label>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                     <input  type="text" id="txtFechaFin" name="txtFechaFin" class="form-control date-range-picker-single" disabled autocomplete="off" value="<?php echo date("d/m/Y")?>">
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
                                        <option value="<?php echo $moneda['ID'] ;?>"><?php echo utf8_encode($moneda['descripcion']) ;?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane" id="vista_buscar">
                    <div class="form-group">

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right">
                                     <label>Código: </label>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                     <input  type="text" id="txtCodigo" name="txtCodigo" class="int form-control" autocomplete="off" >
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right">
                                     <label>Serie: </label>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                     <input  type="text" id="txtSerie" name="txtSerie" class="form-control" autocomplete="off" onchange="">
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 text-right">
                                     <label>Número: </label>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                     <input  type="text" id="txtNumero" name="txtNumero" class="form-control" autocomplete="off" onchange="fncNumero();">
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

            
        </div>
    </div>
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
        window_float_open_modal('REGISTRAR NUEVA COMPRA','/Ingreso/Compra_Mantenimiento_Nuevo','','',f,800,500);
        
    }

 
    var fncEditar=function(id){	
        window_float_open_modal('EDITAR COMPRA','/Ingreso/Compra_Mantenimiento_Editar',id,'',f,800,500);
       
    }

    var fncEliminar=function(id){
        cargarValores('/Ingreso/ajaxCompra_Mantenimiento_Eliminar',id,function(resultado){
            if(resultado.resultado==1){
                f.enviar();
                mensaje.info("OK",resultado.mensaje);
            }else {
                mensaje.error("Ocurrió un error",resultado.mensaje);
            }


        });

            
    }


    var fncVerDetalle=function(id){	
        window_float_open_modal('VER COMPRA','/Ingreso/Compra_Mantenimiento_Editar',id,'',f,800,550);
        

    }

    $('#txtBuscar,#txtMostrar,#txtPeriodo,#txtNumero,#txtCodigo').keypress(function(e){			
        if (e.which==13){
                $('#num_page').val(1);
                f.enviar();
                return false;
        }
    });

    function fncSerie(){
        var serie=$('#txtSerie').val();
        var cadena=parseInt(serie,10);
        if(isNaN(cadena)==false){
            var nSerie=('000'+serie);				
            $('#txtSerie').val(nSerie.substring(nSerie.length-3,nSerie.length));
        }
    }
    function fncNumero(){
        var numero=$('#txtNumero').val();
        var nNumero=('000000000'+numero);

        $('#txtNumero').val(nNumero.substring(nNumero.length-9,nNumero.length));
    }
</script>

<?php } ?>