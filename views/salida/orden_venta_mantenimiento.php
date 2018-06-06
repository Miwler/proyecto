<?php
	require ROOT_PATH."views/shared/content.php";
?><
<?php function fncTitle(){?>
		Registro de ventas
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <!--<script type="text/javascript" src="include/js/jGrid.js"></script>-->

       
        
  
    <!--<script type="text/javascript" src="include/FileSaver.js/src/FileSaver.js"></script>
    <script type="text/javascript" src="include/jszip/dist/jszip.js"></script>
    <script type="text/javascript" src="include/jszip/vendor/FileSaver.js"></script>
    <script type="text/javascript" src="include/jsPDF/dist/jspdf.debug.js"></script>
    <script type="text/javascript" src="include/jsPDF/dist/jspdf.min.js"></script>
    <script type="text/javascript" src="include/jsPDF/dist/jspdf.plugin.autotable.js"></script>
		<script type="text/javascript" src="include/qrcode/qrcode.js"></script>-->


    <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
		<style media="screen">
		.tooltip-inner {
			max-width: 350px;
	width: 350px;
}
#qrcode {
  width:160px;
  height:160px;
  margin-top:15px;
}
#text {
  display: block;
  width: 80%;
}
		</style>

<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-file-text-o" aria-hidden="true"></i> Registros de orden de ventas
<?php } ?>
<?php function fncPage(){?>
<form id="frm1" method="post" action="/Salida/ajaxOrden_Venta_Mantenimiento" class="form-horizontal">
	<!--<form id="frm1" name="frm1" method="post" class="form-horizontal">-->
    <div class="panel panel-tab panel-tab-double shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">
                <li class="active nav-border nav-border-top-success"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> <div><span class="text-strong">Filtro</span></div></a></li>
                <li class="nav-border nav-border-top-primary"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>
            </ul>
            
            <a onclick="fncVerPDF(600);"  class="btn btn-success btn-add-skills" style="position: absolute;right: 120px;top: 12px;display: block;">verPDF</a>
            <a onclick="fngetData();" class="btn btn-success btn-add-skills" style="position: absolute;right: 120px;top: 12px;display: block;">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" style="position: absolute;right: 12px;top: 12px;display: block;">Nuevo &nbsp;<i class="fa fa-plus"></i></a>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div  id="vista_filtrar" class="tab-pane fade in active">
                    <div class="form-group">
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                    <label>Cliente: </label>
                                </div>
                                <select id="selCliente" name="selCliente" class="chosen-select">
                                    <option value="0">-TODOS-</option>
                                    <?php foreach($GLOBALS['dtCliente'] as $cliente){?>
                                    <option value="<?php echo $cliente['ID']?>"><?php echo FormatTextView($cliente['ruc'].' - '.$cliente['razon_social'])?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                     <label>Todos: </label>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                <div id="vista_buscar" class="tab-pane fade" >
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
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                     <label>Número: </label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                     <input  type="text" id="txtNumero" name="txtNumero" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                     <label>N° Factura: </label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                     <input  type="text" id='txtNumero_Factura' name='txtNumero_Factura' class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                

                <!-- Start datatable -->
                <table id="datatable-ajax" class="table table-teal table-teal table-middle table-striped table-bordered table-condensed dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Factura</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <!--tbody section is required-->
                    <tbody></tbody>
                    <!--tfoot section is optional-->
                    <tfoot>
                        <tr>
                            <th>Numero</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Factura</th>
                            <th>Acción</th>
                        </tr>
                    </tfoot>
                </table>
                                    <!--/ End datatable -->
            </div>

           
        </div>
    </div>


</form>
    <style>
        
    </style>
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
  var myTable;
    function fngetData() {
        var myObject = new Object();

        enviarAjax('Salida/ajaxOrden_Venta_Mantenimiento1', 'frm1', myObject, function (res) {

            var jsonObject = $.parseJSON(res);
            var result = jsonObject.map(function (item) {

                var result = [];
                result.push(item.numero_concatenado);
                result.push(item.fecha);
                result.push(item.cliente);
                result.push(item.moneda+' '+item.total);
                result.push(item.estado);
                result.push(item.factura);
                result.push(item.accion);
                result.push("");
                return result;
            });
            myTable.rows().remove();
            myTable.rows.add(result);
            myTable.draw();
        });
    }
    function fnGridCSS() {
        try {
            var shadows =
                [

                    { "width": "5%", "targets": 0 },
                    { "width": "5%", "targets": 1 },
                    { "width": "20%", "targets": 2 },
                    { "width": "10%", "targets": 3,"className":"text-right" },
                    { "width": "20%", "targets": 4 },
                    { "width": "20%", "targets": 5 },
                    { 'targets': [6], 'orderable': false, 'searchable': false, "width": "10%","className":"text-center" }
                ];

            myTable = build_data_table($('#datatable-ajax'), shadows, [[0, "asc"]]);

        } catch (e) {
            //alert(e.message);
            mensaje.error('Error', e.message);
        }
    }
    $(document).ready(function () {
        try {

            fnGridCSS();
            fngetData();

        }
        catch (err) {
            mensaje.error('Error', err.message);
        }
    });
    $('#txtBuscar,#txtMostrar,#txtCodigo').keypress(function(e){

                if (e.which==13){
                        $('#num_page').val(1);
                        fngetData();
                        return false;
                }
        });
</script>

<?php } ?>
