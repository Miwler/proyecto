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


<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-file-text-o" aria-hidden="true"></i> Consulta de documentos enviados a la SUNAT
     
<?php } ?>
<?php function fncPage(){?>

    <div class="panel panel-tab panel-tab-double panel-tab-vertical row no-margin rounded shadow">
        <!-- Start tabs heading -->
        <div class="panel-heading no-padding col-md-3">
            <ul class="nav nav-tabs nav-pills">
                <li class="active">
                    <a href="#tab2-1" data-toggle="tab" aria-expanded="true" onclick="fnVer('consulta_cdr');">
                        <i class="fa fa-file-zip-o"></i>
                        <div>
                            <span class="text-strong">Consulta I</span>
                            <span>Estado de CDR</span>
                        </div>
                    </a>
                </li>
                <li class="">
                    <a href="#tab2-2" data-toggle="tab" aria-expanded="false" onclick="fnVer('consulta_ticket');">
                        <i class="fa fa-file-text"></i>
                        <div>
                            <span class="text-strong">Consulta 2</span>
                            <span>Estado de ticket</span>
                        </div>
                    </a>
                </li>
                
            </ul>
        </div><!-- /.panel-heading -->
        <!--/ End tabs heading -->

        <!-- Start tabs content -->
        <div class="panel-body col-md-9">
            <form id='frm' action='post' class="tab-content form-horizontal">
                <div class="tab-pane fade inner-all active in" id="tab2-1">
                    <h5 class="page-header">Consultar el estado de los archivos CDR enviados a la SUNAT</h5>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tipo de comprobante<span class="asterisk">*</span></label>
                        <div class="col-sm-4">
                            <select id="selTipoComprobante" name="selTipoComprobante" class="form-control">
                                <option value="01">Factura</option>
                                <option value="07">Nota de crédito</option>
                                <option value="08">Nota de débito</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label text-uppercase">Serie<span class="asterisk">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="txtSerie" name="txtSerie" autocomplete="off" class="form-control text-uppercase">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Número<span class="asterisk">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="txtNumero" name="txtNumero" autocomplete="off" class="form-control">
                        </div>
                    </div>
                    
                </div>
                <div class="tab-pane fade inner-all" id="tab2-2">
                    <h5 class="page-header">Consultar los estados de los ticket</h5>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nro ticket</label>
                        <div class="col-sm-4">
                            <input type="text" id='txtTicket' name='txtTicket' class="form-control">
                        </div>
                    </div>
                    
                </div>
                
            </form>
            <!-- Start pager -->
            <div class="panel-footer no-bg">
                <div class='form-group'>
                    <div class='col-sm-12'>
                        <button type='button' class="btn btn-info" title="Buscar documento" onclick="fncBuscar();"><i class="fa fa-search-plus"></i> Buscar</button>
               
                    </div>
                    <div id='divResultado' class='col-sm-12' style='margin-top:5px;'>
                    
                    </div>
                </div>
                
            </div>
            <!--/ End pager -->
        </div><!-- /.panel-body -->
        <!--/ End tabs content -->
    </div><!-- /.panel -->
    <iframe id='frmDescargar' style='display: none'></iframe>
<script type="text/javascript">


var vista="consulta_cdr";
function fnVer(valor){
    vista=valor;
    $("#divResultado").html("");
    $("#frmDescargar").prop("src","");
}
function fncBuscar(){
    var object=new Object();
    
    object['vista']=vista;
    $("#divResultado").html("");
    $("#frmDescargar").prop("src","");
    block_ui(function(){
        enviarAjaxParse('salida/ajaxBuscarDocumentoSunat','frm',object,function(resultado){
            $.unblockUI();
            if(resultado.resultado==1){
                $("#divResultado").html(resultado.html);
            }else{
                mensaje.error("Ocurrió un error",resultado.mensaje);
            }
        });
    });
    
}
function fncDescargar(ruta){
   $("#frmDescargar").prop("src",ruta); 
}
</script>

<?php } ?>
