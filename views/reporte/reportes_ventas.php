<?php		
	require ROOT_PATH."views/shared/content.php";	
?>	
<?php function fncTitle(){?>
		Reportes de Ventas
<?php } ?>
<?php function fncHead(){?>
        <script type="text/javascript" src="include/js/jForm.js"></script>
        <script type="text/javascript" src="include/js/jPdf.js"></script>
                
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-cc-visa" aria-hidden="true"></i> Reporte de ventas
<?php } ?>
<?php function fncPage(){?>
   
    <form id="frm1" method="post" action="/Reporte/Reportes_Ventas" onsubmit="return validar();" class="form-horizontal">
        <div class="panel panel-tab panel-tab-double shadow">
            <div class="panel-body">
                <div class="row">
                    <div  class="col-lg-4 col-md-4 col-sm-4 col-xs-12 liReporte">
                        <div class="panel panel-info">
                            <div class="panel-heading">Tipos de reportes</div>
                            <div class="panel-body">
                                <div class="list-group" id="Reportes">
                                    <?php foreach( $GLOBALS['dtReportes'] as $reporte){?>
                                    <a id="<?php echo $reporte['ID']?>" class="list-group-item list-group-item-action"><?php echo ucfirst(FormatTextView($reporte['nombre']));?> </a>
                                    <?php } ?>
                                </div>
                                
                            </div>
                        </div>
                       
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Reporte</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div id="divCuerpo" style="height: 400px;overflow-y: auto;" class="col-md-12">
                                        
                                    </div>
                                    
                                </div>
                                
                                
                            </div>
                        
                   
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </form>
               
	
    <script type="text/javascript">

        var validar=function(){
            //$('#fondo_espera').css('display','block');
            
        }
        $('#Reportes a').click(function(){
            var reportes_ID=this.id;
            cargarValores('Reporte/ajaxReportes_Ventas_Campos',reportes_ID, function(resultado){
                $('#divCuerpo').html(resultado.resultado);
                $('#selCliente').trigger('chosen:updated');
                $('.chosen-select').chosen();
                $('.date-range-picker-single').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    locale: {
                    format: 'DD/MM/YYYY'
                }
                },
                function(start, end, label) {
                    var years = moment().diff(start, 'years');
                    //alert("You are " + years + " years old.");
                    //start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
                desbloqueo(reportes_ID);
            });


            $('#Reportes a').each(function(){
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
        var fncGenerar=function(){
            $('#fondo_espera').css('display','block');
            cargarFormularios('Reporte/ajaxGenerar_Reportes_Ventas','divCuerpo',validar,function(resultado){
                $('#fondo_espera').css('display','none');
              
               window.open(resultado.url, '_blank');

            });

        }

        //Funciones para cada reporte
        //Reporte1
        var fncOpcion=function(id){
            if($("#"+id).prop('checked')){

                $('#txtFecha_Inicio').prop('disabled',true);
                $('#txtFecha_Fin').prop('disabled',true);
                $('#selMes').prop('disabled',false);
            }else {

                $('#txtFecha_Inicio').prop('disabled',false);
                $('#txtFecha_Fin').prop('disabled',false);
                $('#selMes').prop('disabled',true);
            }
        }
       var desbloqueo=function(reporte_ID){
           switch(reporte_ID){
               case '1'://Comisión total por empleado
                    $("#selPeriodo").prop('disabled',false);
                    $("#ckRango").prop('disabled',false);
                    $("#selMoneda").prop('disabled',false);
                    $("#selOperador").prop('disabled',false);
                    $("#ckEstado").prop('disabled',false);
                    break;
               case '2'://Comisión detalle por empleado
                    $("#selPeriodo").prop('disabled',false);
                    $("#ckRango").prop('disabled',false);
                    $("#selMoneda").prop('disabled',false);
                    $("#selOperador").prop('disabled',false);
                    $("#ckEstado").prop('disabled',false);
                    break;
                case '3'://Ventas por cliente
                    $("#selPeriodo").prop('disabled',false);
                    $("#ckRango").prop('disabled',false);
                    $("#selMoneda").prop('disabled',false);
                    $("#selOperador").prop('disabled',false);
                    $("#ckEstado").prop('disabled',false);
                    break;
                case '4'://Ventas por cliente detalle
                    $("#selPeriodo").prop('disabled',false);
                    $("#ckRango").prop('disabled',false);
                    $("#selMoneda").prop('disabled',false);
                    $("#selOperador").prop('disabled',false);
                    $("#ckEstado").prop('disabled',false);
                    break;
                case '9'://Facturas por cobrar
                    $("#selPeriodo").prop('disabled',false);
                    $("#ckRango").prop('disabled',false);
                    $("#selMoneda").prop('disabled',false);
                    $("#txtCliente_ID").prop('disabled',false);
                    $("#selOperador").prop('disabled',false);
                    //$("#ckEstado").prop('disabled',false);
                    
                case '10'://Facturas por cobrar
                    $("#selPeriodo").prop('disabled',false);
                    $("#ckRango").prop('disabled',false);
                    $("#selMoneda").prop('disabled',false);
                    $("#txtCliente_ID").prop('disabled',false);
                    $("#selOperador").prop('disabled',false);
                    //$("#ckEstado").prop('disabled',false);
                    break;
           }
          
            /*$("#selPeriodo").prop('disabled',false);
            $("#ckRango").prop('disabled',false);
            $("#txtFecha_Inicio").prop('disabled',false);
            $("#txtFecha_Fin").prop('disabled',false);
            $("#txtProveedor_ID").prop('disabled',false);
            $("#selMoneda").prop('disabled',false);
            $("#txtSerie").prop('disabled',false);
            $("#txtNumero").prop('disabled',false);*/
       }
       var fncActivarRango=function(objeto){
           if($(objeto).is(":checked")){
                $("#selPeriodo").prop('disabled',true);
                $("#txtFecha_Inicio").prop('disabled',false);
                $("#txtFecha_Fin").prop('disabled',false);
           }else{
               $("#selPeriodo").prop('disabled',false);
                $("#txtFecha_Inicio").prop('disabled',true);
                $("#txtFecha_Fin").prop('disabled',true);
           }
       }
       

    </script>
  <?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){?>
    <script type="text/javascript">
         $('#fondo_espera').css('display','none');
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){?>
    <script type="text/javascript">
        $('#fondo_espera').css('display','none');
        $(document).ready(function(){
            toastem.error("Ocurrió un error");
        });
    </script>
<?php } ?>
<?php } ?>

