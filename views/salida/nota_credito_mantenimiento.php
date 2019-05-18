<?php		
	require ROOT_PATH."views/shared/content.php";	
?>

<?php function fncTitle(){?>
		Notas de créditos
<?php } ?>
<?php function fncHead(){?>
        <script type="text/javascript" src="include/js/jForm.js"></script>
       <script type="text/javascript" src="include/js/jPdf.js"></script>
    <script type="text/javascript" src="include/js/jValidarLargoComentarios.js" ></script>
    <link rel="stylesheet" type="text/css" href="include/css/factura.css" /> 
    <script type="text/javascript" src="include/jszip/dist/jszip.js"></script>
    <script type="text/javascript" src="include/jszip/vendor/FileSaver.js"></script>   
                                  
        <link rel="stylesheet" type="text/css" href="include/css/grid.css" />
       
                
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-file-text" aria-hidden="true"></i> Registro de Notas de créditos
     <div class="pull-right">
         <a onclick="f.enviar();" class="btn btn-success btn-add-skills" >Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
        <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" >Nuevo &nbsp;<i class="fa fa-plus"></i></a>
        
     </div>
<?php } ?>
<?php function fncPage(){?>
<form id="frm1"  method="post" action="/Salida/ajaxNota_Credito_Mantenimiento" class="form-horizontal">
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
                                     <label>Fecha emisión inicio: </label>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input  type="text" id="txtFechaInicio" name="txtFechaInicio" disabled class="date-range-picker-single form-control" autocomplete="off" value="<?php echo date("d/m/Y")?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                                    <label>Fecha emisión fin: </label>
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
                <table id="datatable-ajax" class="table table-teal table-teal table-middle table-striped table-bordered table-condensed dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Número</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Factura</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>SUNAT</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <!--tbody section is required-->
                    <tbody></tbody>
                    <!--tfoot section is optional-->
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Número</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Factura</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>SUNAT</th>
                            <th>Acción</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            

        </div>
    </div>
    <input type="hidden" id="rbOpcion" name="rbOpcion" value="filtrar"> 
</form>
     <iframe id="frmDescargar" style="display:none;"></iframe>
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

        enviarAjax('Salida/ajaxNota_Credito_Mantenimiento', 'frm1', myObject, function (res) {

            var jsonObject = $.parseJSON(res);
            var y=1;
            var result = jsonObject.map(function (item) {
                
                var result = [];
                result.push(y);
                result.push(item.codigo);
                result.push(item.tipo);
                result.push(item.fecha_emision);
                result.push(item.cliente);
                result.push(item.numero_factura);
                result.push(item.total);
                result.push(item.estado);
                result.push(item.descripcion_estado);
                result.push(item.accion);
                result.push("");
                y++;
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
                    { "width": "10%", "targets": 1,"className":"text-center"},
                    { "width": "15%", "targets": 2,"className":"text-center" },
                    { "width": "5%", "targets": 3 },
                    { "width": "30%", "targets": 4},
                    { "width": "10%", "targets": 5,"className":"text-center" },
                    { "width": "10%", "targets": 6,"className":"text-right"},
                    { "width": "10%", "targets": 8},
                    { 'targets': [9], 'orderable': false, 'searchable': false, "width": "5%","className":"text-center" }
                ];

            myTable = build_data_table($('#datatable-ajax'), shadows, [[0, "asc"]]);

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
        window_float_open_modal('NOTA DE CRÉDITO','Salida/Nota_Credito_Mantenimiento_Nuevo','','',f,800,430); 
        //window_float_open('/Ventas/cobranza_mantenimiento_registro',id,'',f);
    }
    var fncEditar=function(id){
        window_float_open_modal('NOTA DE CRÉDITO','Salida/Nota_Credito_Mantenimiento_Editar',id,'',f,800,430); 
        //window_float_open('/Ventas/cobranza_mantenimiento_registro',id,'',f);
    }
    var fncCargarVista=function(valor){
        $('#rbOpcion').val(valor);
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
    var fncDOWNLOAD_XML_NOTA=function(id,tipo) {
        try {
            block_ui(function () {


            var iframe = document.getElementById("iPDF");
            if (tipo == 'PDF') {
                
                pdf.descargar("salida/Comprobante_RegulaDescargarPDF/"+id);
            //fncVerPDF(id);

                $.unblockUI();
                return false;
            }

            var zip = new JSZip();
                    $.ajax({
                type: "POST",
                url: 'Salida/ajaxDownloadXMLNota',
                data: {'id': id,'tipo': tipo},
                cache: false,
                success: function(resultado)
                {
                $.unblockUI();
                //console.log(resultado);
                var obj = $.parseJSON(resultado);

                    if (obj.exito == 'true') {
                        if (tipo == 'XML') {
                            var link = document.createElement('a');
                            link.href = obj.ruta;
                            link.download = obj.nombre_archivo;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }

                        if (tipo=='CDR') {
                            $("#frmDescargar").prop("src",obj.nombre_archivo);
                            //location.href=obj.nombre_archivo;
                        /*zip.generateAsync({type:"base64"}).then(function (base64) {
                            data = obj.xml_firmado;
                            location.href="data:application/zip;base64," + data;
                        });*/
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
    $('#txtBuscar').focus();
</script>
        <!--<iframe id="iframe2" src="" style="width:1100px; height: 800px; display:none; border:none;">
            
        </iframe>-->
<?php } ?>