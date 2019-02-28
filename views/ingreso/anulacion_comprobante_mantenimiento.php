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
<?php function fncTituloCabecera(){?>
     <i class="fa fa-cut" aria-hidden="true"></i> Anulación de comprobantes
     <div class="pull-right">
         <a onclick="f.enviar();" class="btn btn-success btn-add-skills">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            
     </div>
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncPage(){?>
    <form id="frm1"  method="post" action="/Ingreso/ajaxAnulacion_Comprobante_Mantenimiento" class="form-horizontal">
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
                        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                    <label>Proveedor: </label>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <select id="selProveedor" name="selProveedor" class="chosen-select">
                                        <option value="0">-TODOS-</option>
                                        <?php foreach($GLOBALS['dtProveedor'] as $proveedor){?>
                                        <option value="<?php echo $proveedor['ID']?>"><?php echo strtoupper($proveedor['razon_social']);?></option>
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

                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
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
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                                <label>Periodo: </label>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <select id="selPeriodo" name="selPeriodo" class="form-control">
                                    <option value="0">--</option>
                                    <?php for ($i=0;$i<count($GLOBALS['dtPeriodo']);$i++) { ?>
                                    <option value="<?php echo $GLOBALS['dtPeriodo'][$i]?>"><?php echo $GLOBALS['dtPeriodo'][$i]?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                                 <label>Serie: </label>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                 <input  type="text" id="txtSerie" name="txtSerie" class="form-control" autocomplete="off" onchange="fncSerie();">
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                                 <label>Número: </label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                 <input  type="text" id="txtNumero" name="txtNumero" class="form-control" autocomplete="off" onchange="fncNumero();">
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
    var verificar=function(){

        var Numero = $.trim($('#txtNumero').val());

        $('#divMensaje').html('');

        if (Numero == "") {
            toastem.error('Seleccione una factura .');
            $('#txtNumero').focus();
            return false;
        }                
    }
        var f=new form('frm1','div1');
        f.terminado = function () {
                var tb = document.getElementById(this.Div.id).getElementsByClassName('grid')[0];

                grids = new grid(tb);
                grids.nuevoEvento();
                grids.fncPaginacion(f);
                $('[data-toggle="tooltip"]').tooltip(); 
                $('#websendeos').stacktable();
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
            window_float_open_modal('ANULACIÓN DE COMPROBANTES DE COMPRAS','/Ingreso/anulacion_comprobante_mantenimiento_registro',id,'',f,800,500);
             
           
        }

        var fncVendido=function(id){
            window_float_open_modal('ANULACIÓN DE COMPROBANTES DE COMPRAS - VENDIDOS','/Ingreso/anulacion_comprobante_mantenimiento_registro',id,'',f,800,500);
                
        }



        $('#txtBuscar,#txtMostrar').keypress(function(e){			
                if (e.which==13){
                        $('#num_page').val(1);
                        f.enviar();
                        return false;
                }
        });

        function fncSerie(){
            var serie=$('#txtSerie').val();
            var nSerie=('000'+serie);				
            $('#txtSerie').val(nSerie.substring(nSerie.length-3,nSerie.length));
        }
        function fncNumero(){
            var numero=$('#txtNumero').val();
            var nNumero=('000000000'+numero);

            $('#txtNumero').val(nNumero.substring(nNumero.length-9,nNumero.length));
        }

        $('#txtBuscar').focus();
</script>
  
                     
<?php } ?>