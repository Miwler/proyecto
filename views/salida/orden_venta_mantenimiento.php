<?php
	require ROOT_PATH."views/shared/content.php";
?>
<?php function fncTitle(){?>
		Registro de ventas
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script type="text/javascript" src="include/js/jGrid.js"></script>

    <script type="text/javascript" src="include/FileSaver.js/src/FileSaver.js"></script>
    <script type="text/javascript" src="include/jszip/dist/jszip.js"></script>
    <script type="text/javascript" src="include/jszip/vendor/FileSaver.js"></script>
    <script type="text/javascript" src="include/jsPDF/dist/jspdf.debug.js"></script>
    <script type="text/javascript" src="include/jsPDF/dist/jspdf.min.js"></script>
    <script type="text/javascript" src="include/jsPDF/dist/jspdf.plugin.autotable.js"></script>
		<script type="text/javascript" src="include/qrcode/qrcode.js"></script>


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
<form id="frm1" name="frm1" method="post" action="/Salida/ajaxOrden_Venta_Mantenimiento" class="form-horizontal">
	<!--<form id="frm1" name="frm1" method="post" class="form-horizontal">-->
    <div class="panel panel-tab panel-tab-double shadow">
        <div class="panel-heading no-padding">
            <ul class="nav nav-tabs">
                <li class="active nav-border nav-border-top-success"><a href="#vista_filtrar" data-toggle="tab"><i class="fa fa-hourglass" aria-hidden="true"></i> <div><span class="text-strong">Filtro</span></div></a></li>
                <li class="nav-border nav-border-top-primary"><a href="#vista_buscar" data-toggle="tab"><i class="fa fa-search-plus" aria-hidden="true"></i> <div><span class="text-strong">Búsqueda</span></div></a></li>
            </ul>
            <div style="position: absolute;right: 260px;top: 12px;display: block;">
                <input id="txtMostrar" name="txtMostrar" type="number"  value="30"   class="form-control int text-center" autocomplete="off" >
            </div>
						<a onclick="fncVerPDF(600);"  class="btn btn-success btn-add-skills" style="position: absolute;right: 120px;top: 12px;display: block;">verPDF</a>
            <a onclick="f.enviar();" class="btn btn-success btn-add-skills" style="position: absolute;right: 120px;top: 12px;display: block;">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
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
                <div id="div1" class="col-md-12 col-lg-12 col-sm-12 col-xs-12"></div>
            </div>

            <input id="rbOpcion" name="rbOpcion" type="text" value="filtrar" style="display:none;">
            <input id="num_page" name="num_page" type="text" value="1" style="display:none;">
            <input id="txtOrden" name="txtOrden" type="text" value="1" style="display:none;">
            <input id="chkOrdenASC" name="chkOrdenASC" type="checkbox"  style="display:none;">

						<iframe id="iPDF" style="height: 600px; width: 100%;"></iframe>
						<input id="text" type="text" value="kylespice.com?cumin" />
						<div id="dvContent">
							<div id="qrcode" crossOrigin="anonymous"></div>
						</div>


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
        window_float_open_modal('REGISTRAR NUEVA ORDEN DE VENTA','Salida/Orden_Venta_Mantenimiento_Nuevo','','',f,800,550);
    }
		var fncVerPDF=function(id){
        window_float_open_modal('REGISTRAR NUEVA ORDEN DE VENTA','Salida/Factura_Vista_PreviaPDF',id,'',f,800,550);
    }

    var fncMantenimiento=function(){
        $('#frm1').css('display','block');
        $('#iframe2').attr('src','');
        $('#iframe2').css('display','none');
        f.enviar();
    }
    var fncEditar=function(id){
         window_float_open_modal('EDITAR ORDEN DE VENTA','Salida/Orden_Venta_Mantenimiento_Editar',id,'',f,800,550);
    }

    var fncVer=function(id){
         window_float_open_modal('VER ORDEN DE VENTA','Salida/Orden_Venta_Mantenimiento_Editar',id,'',f,800,550);
    }

		function fncSUNAT(id) {
			try {
					block_ui(function () {
						cargarValores('Salida/ajaxEnviarSUNAT',id,function(resultado){
							console.log(resultado);

							$.unblockUI();
							var obj = $.parseJSON(resultado);
							console.log(obj.Exito);
							//console.log(obj.MensajeRespuesta);
							if (obj.Exito == true) {
									alert(obj.MensajeRespuesta);
							}
					});
				});
			} catch (e) {
				$.unblockUI();
				console.log(e);
			} finally {

			}
		}

		function formatXml(xml) {
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

		var faker = window.faker;
		var base64Img = null;
		/*var getColumns = function () {
		            return [
		                { title: "CÓDIGO", dataKey: "codigo" },
		                { title: "DESCRIPCIÓN", dataKey: "descripcion" },
		                { title: "UM", dataKey: "unidad_medida" },
		                { title: "CANTIDAD", dataKey: "cantidad" },
		                { title: "P. UNIT", dataKey: "p_unit" },
										{ title: "TOTAL", dataKey: "total" }
		            ];
		        };
						// Uses the faker.js library to get random data.
			        /*function getData(rowCount) {
			            rowCount = rowCount || 4;
			            //var sentence = "Minima quis totam nobis nihil et molestiae architecto accusantium qui necessitatibus sit ducimus cupiditate qui ullam et aspernatur esse et dolores ut voluptatem odit quasi ea sit ad sint voluptatem est dignissimos voluptatem vel adipisci facere consequuntur et reprehenderit cum unde debitis ab cumque sint quo ut officiis rerum aut quia quia expedita ut consectetur animiqui voluptas suscipit Monsequatur";
			            var data = [];
			            for (var j = 1; j <= rowCount; j++) {
			                data.push({
			                    codigo: j,
			                    descripcion: "faker.name.findName()",
			                    email: "faker.internet.email()",
			                    unidad_medida: "NIU",
			                    cantidad: "1",
			                    expenses: "0.00",
			                    p_unit: "0.00",
			                    total: "0.00"
			                });
			            }
			            return data;
			        }

							function getBase64Image(img) {
							  img.setAttribute('crossOrigin', 'anonymous');
							  var canvas = document.createElement("canvas");
							  canvas.width = img.width;
							  canvas.height = img.height;
							  var ctx = canvas.getContext("2d");
							  ctx.drawImage(img, 0, 0);
							  var dataURL = canvas.toDataURL("image/png");
							  return dataURL;
							}*/



	function fncDOWNLOAD_XML(id,tipo) {
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
				console.log(e);
			} finally {

			}

		}

    var fncEliminar=function(id){
            gridEliminar(f,id,'/Salida/ajaxOrden_Venta_Mantenimiento_Eliminar');
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

		/*function fnModalPopover() {

			$('[rel="popover"]').popover({
					container: 'body',
					html: true,
					trigger: 'focus',
					placement: "left",
					content: function () {
							var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
							return clone;
					}
			}).on("show.bs.popover", function () { $(this).data("bs.popover").tip().css("max-width", "650px"); });
		}*/




		$(document).ready(function(){

			// var qrcode = new QRCode("qrcode");
			// qrcode.makeCode("ajoi");
			//
			// $("#text").on("keyup", function () {
			//     qrcode.makeCode("ajoi");
			// }).keyup().focus();

			//fncDOWNLOAD_XML(0,'PDF');

			});


</script>

<?php } ?>
