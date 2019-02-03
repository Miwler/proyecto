<?php
	require ROOT_PATH."views/shared/content.php";
?><
<?php function fncTitle(){?>
		Registro de ventas
<?php } ?>
<?php function fncHead(){?>
    <script type="text/javascript" src="include/js/jForm.js"></script>



   
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
     <i class="fa fa-file-text-o" aria-hidden="true"></i> Registro de resumen <a onclick="fngetData();" class="btn btn-success btn-add-skills" style="position: absolute;right: 120px;top: 12px;display: block;">Actualizar &nbsp;<i class="fa fa-refresh"></i></a>
            <a onclick="fncNuevo();" class="btn btn-primary btn-add-skills" style="position: absolute;right: 12px;top: 12px;display: block;">Nuevo &nbsp;<i class="fa fa-plus"></i></a>
<?php } ?>
<?php function fncPage(){?>
<form id="frm1" method="post" action="#" class="form-horizontal">
	<!--<form id="frm1" name="frm1" method="post" class="form-horizontal">-->
   <div class="form-group">
        <table id="datatable-ajax" class="table table-teal table-teal table-middle table-striped table-bordered table-condensed dt-responsive nowrap">
            <thead>
                <tr>
                    <th>Numero</th>
                    <th>ID Resumen</th>
                    <th>Fecha emisión</th>
                    <th>Fecha ref.</th>
                    <th>Número</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <!--tbody section is required-->
            <tbody></tbody>
            <!--tfoot section is optional-->
            <tfoot>
                <tr>
                    <th>Numero</th>
                    <th>ID Resumen</th>
                    <th>Fecha emisión</th>
                    <th>Fecha ref.</th>
                    <th>Número</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </tfoot>
        </table>
                            <!--/ End datatable -->
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
        block_ui(function(){
            enviarAjax('Salida/ajaxResumen_Diario_Mantenimiento', 'frm1', myObject, function (res) {
            
            var jsonObject = $.parseJSON(res);
            if(jsonObject.error_sistema){
                toastem.error(jsonObject.error_sistema);
            }else{
                 var result = jsonObject.map(function (item) {

                    var result = [];
                    result.push(item.num);
                    result.push(item.IdDocumento);
                    result.push(item.FechaEmision);
                    result.push(item.FechaReferencia);
                    result.push(item.numero);
                    result.push(item.estado);
                    result.push(item.accion);
                    result.push("");
                    return result;
                });
                myTable.rows().remove();
                myTable.rows.add(result);
                myTable.draw();
            }
            $.unblockUI();
           
            
        });
        });
       
    }
    function fnGridCSS() {
        try {
            var shadows =
                [

                    { "width": "5%", "targets": 0,"className":"text-center" },
                    { "width": "15%", "targets": 1 },
                    { "width": "10%", "targets": 2 ,"className":"text-center" },
                    { "width": "10%", "targets": 3,"className":"text-center" },
                    { "width": "10%", "targets": 4 },
                    { "width": "20%", "targets": 5 },
                    { 'targets': [6], 'orderable': false, 'searchable': false, "width": "10%","className":"text-center" }
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
        window_float_open_modal('REGISTRAR RESUMEN DIARIO','Salida/Resumen_Diario_Mantenimiento_Nuevo','','',f,800,480);
    }
    var fncVerPDF=function(id){
        window_float_open_modal('REGISTRAR NUEVA ORDEN DE VENTA','Salida/Factura_Vista_PreviaPDF',id,'',f,800,550);
    }
    var fncEditar=function(id){
         window_float_open_modal('EDITAR ORDEN DE VENTA','Salida/Orden_Venta_Electronico_Mantenimiento_Editar',id,'',f,800,480);
    }

    var fncVer=function(id){
         window_float_open_modal('VER ORDEN DE VENTA','Salida/Orden_Venta_Mantenimiento_Editar',id,'',f,800,480);
    }
    /*var fncDOWNLOAD_XML=function(id,tipo) {
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
    }*/
    var fncEliminar=function(id){
            gridEliminar(f,id,'/Salida/ajaxOrden_Venta_Mantenimiento_Eliminar');
				    
    }
        
</script>

<?php } ?>
