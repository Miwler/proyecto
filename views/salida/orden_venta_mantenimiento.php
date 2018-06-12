<?php
	require ROOT_PATH."views/shared/content.php";
?><
<?php function fncTitle(){?>
		Registro de ventas
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <!--<script type="text/javascript" src="include/FileSaver.js/src/FileSaver.js"></script>-->
    <script type="text/javascript" src="include/jszip/dist/jszip.js"></script>
    <script type="text/javascript" src="include/jszip/vendor/FileSaver.js"></script>
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
<form id="frm1" method="post" action="#" class="form-horizontal">
	<!--<form id="frm1" name="frm1" method="post" class="form-horizontal">-->
    <div class="panel panel-tab panel-tab-double shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">
                <li class="active nav-border nav-border-top-success"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> <div><span class="text-strong">Filtro</span></div></a></li>
                <li class="nav-border nav-border-top-primary"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>
            </ul>
            
           
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
                        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                    <label>Periodo: </label>
                                </div>
                                <select id="selPeriodo" name="selPeriodo" class="form-control">
                                    <option value="0">Por fecha</option>
                                    <?php for($i=periodo_inicio;$i<=date("Y");$i++){?>
                                    <option value="<?php echo $i;?>" <?php echo ($i==date("Y"))?"selected":"";?>><?php echo $i;?></option>
                                    <?php }?>
                                </select>
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
                        <div class="col-md-1 col-lg-1 col-sm-1 col-xs-12">
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
                                    <input type="text" id="txtPeriodo" name="txtPeriodo" class="form-control int" value="<?php echo date("Y");?>" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                     <label>Número orde de venta: </label>
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
        <input type="hidden" id="rbOpcion" name="rbOpcion" value="filtrar"> 
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
     $("#selPeriodo").change(function(){
         if(this.value==0){
             $("#txtFechaInicio").prop("disabled", false);
            $("#txtFechaFin").prop("disabled", false);
             
            $("#txtFechaInicio").focus();
         }else{
            $("#txtFechaInicio").prop("disabled", true);
            $("#txtFechaFin").prop("disabled", true); 
         }
     });
    
  var myTable;
    function fngetData() {
        var myObject = new Object();

        enviarAjax('Salida/ajaxOrden_Venta_Mantenimiento', 'frm1', myObject, function (res) {

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

                    { "width": "5%", "targets": 0,"className":"text-center" },
                    { "width": "5%", "targets": 1 },
                    { "width": "20%", "targets": 2 },
                    { "width": "10%", "targets": 3,"className":"text-right" },
                    { "width": "20%", "targets": 4 },
                    { "width": "20%", "targets": 5 },
                    { 'targets': [6], 'orderable': false, 'searchable': false, "width": "10%","className":"text-center" }
                ];

            myTable = build_data_table($('#datatable-ajax'), shadows, [[0, "desc"]]);

        } catch (e) {
            //alert(e.message);
            mensaje.error('Error', e.message);
        }
    }
    var form1 = function(){
        this.enviar=function(){
           fngetData(); 
           
        }
    }
    var f=new form1();
    $(document).ready(function () {
        try {

            fnGridCSS();
            f.enviar();

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
    
    var fncNuevo=function(){
        window_float_open_modal('REGISTRAR NUEVA ORDEN DE VENTA','Salida/Orden_Venta_Mantenimiento_Nuevo','','',f,800,500);
    }
    var fncVerPDF=function(id){
        window_float_open_modal('REGISTRAR NUEVA ORDEN DE VENTA','Salida/Factura_Vista_PreviaPDF',id,'',f,800,550);
    }
    var fncEditar=function(id){
         window_float_open_modal('EDITAR ORDEN DE VENTA','Salida/Orden_Venta_Mantenimiento_Editar',id,'',f,800,550);
    }

    var fncVer=function(id){
         window_float_open_modal('VER ORDEN DE VENTA','Salida/Orden_Venta_Mantenimiento_Editar',id,'',f,800,550);
    }
    var fncDOWNLOAD_XML=function(id,tipo) {
        try {
            block_ui(function () {


            var iframe = document.getElementById("iPDF");
            if (tipo == 'PDF') {

            fncVerPDF(id);

                $.unblockUI();
                return false;
            }

            var zip = new JSZip();
                    $.ajax({
                type: "POST",
                url: 'Salida/ajaxDownloadXML',
                data: {'id': id,'tipo': tipo},
                cache: false,
                success: function(resultado)
                {
                $.unblockUI();
                console.log(resultado);
                var obj = $.parseJSON(resultado);

                    if (obj.exito == 'true') {
                        if (tipo == 'XML') {
                            var xmlText = formatXml(obj.xml_firmado);
                            var blob = new Blob([xmlText], { type: 'application/xml' });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = obj.nombre_archivo;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }

                        if (tipo=='CDR') {
                        zip.generateAsync({type:"base64"}).then(function (base64) {
                            data = obj.xml_firmado;
                            location.href="data:application/zip;base64," + data;
                        });
                        }
                    }else{
                            alert(obj.mensaje);
                    }
            },
                error: function (XMLHttpRequest, textStatus, errorThrown)
                {
                    alert('Error occurred while opening fax template'
                          + getAjaxErrorString(textStatus, errorThrown));
                }
            });
        });

        } catch (e) {
                $.unblockUI();
                console_log(e);
        } finally {

        }

    }
    function formatXml(xml){
        var formatted = '';
        var reg = /(>)(<)(\/*)/g;
        xml = xml.replace(reg, '$1\r\n$2$3');
        var pad = 0;
        jQuery.each(xml.split('\r\n'), function(index, node) {
            var indent = 0;
            if (node.match( /.+<\/\w[^>]*>$/ )) {
                indent = 0;
            } else if (node.match( /^<\/\w/ )) {
                if (pad != 0) {
                    pad -= 1;
                }
            } else if (node.match( /^<\w[^>]*[^\/]>.*$/ )) {
                indent = 1;
            } else {
                indent = 0;
            }

            var padding = '';
            for (var i = 0; i < pad; i++) {
                padding += '  ';
            }

            formatted += padding + node + '\r\n';
            pad += indent;
        });

        return formatted;
    }
    var fncEliminar=function(id){
            gridEliminar(f,id,'/Salida/ajaxOrden_Venta_Mantenimiento_Eliminar');
				    
    }
        
</script>

<?php } ?>
