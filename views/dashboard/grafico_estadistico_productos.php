<?php
require ROOT_PATH . "views/shared/content.php";


?>	
<?php

function fncTitle() { ?>
    Grafico Estadistico de Productos
<?php } ?>

  
    
    
<?php

function fncHead() { ?>

    <link href="include/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="include/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="include/css/sb-admin-2.css" rel="stylesheet" type="text/css">
    <link href="include/css/morris.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="include/js/bootstrap.min.js"></script>   
    <script type="text/javascript" src="include/js/sb-admin-2.js"></script> 
    <script type="text/javascript" src="include/js/script.js"></script> 
    <script type="text/javascript" src="include/js/jquery.min.js"></script>            
    <script src="highcharts/js/highcharts.js"></script>
    <script src="highcharts/js/modules/exporting.js"></script>
      
    
    
    
    
    <script type="text/javascript">
$(function () {
    $('#containerMasVendidosSoles').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Los 10 Productos Mas Vendidos (S/.)'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>S/. {point.y:.1f} </b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Venta Total',
            data: [
             <?php 
               foreach($GLOBALS['dtGrafico_Estadistico_Producto_MasVendidos'] as $row){
            ?>
                ['<?php echo FormatTextView($row['producto']); ?>',   <?php echo ($row['precio_venta_soles']) ?>],
            <?php 
            }
            ?>
            ]
        }]
    });
});

</script>




   <script type="text/javascript">
$(function () {
    $('#containerMasVendidosDolares').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Los 10 Productos Mas Vendidos ($)'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>$ {point.y:.1f} </b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Venta Total',
            data: [
             <?php 
               foreach($GLOBALS['dtGrafico_Estadistico_Producto_MasVendidos'] as $row){
            ?>
                ['<?php echo FormatTextView($row['producto']); ?>',   <?php echo ($row['precio_venta_dolares']) ?>],
            <?php 
            }
            ?>
            ]
        }]
    });
});

</script>

    

<?php } ?>
<?php

function fncMenu() { ?>
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-dashboard" aria-hidden="true"></i> GRÁFICOS ESTADÍSTICOS
<?php } ?>
<?php

function fncPage() { ?>
    <h1 class="title-principal">
        Reporte de Productos 
    </h1>


<div class="row">
<div class="col-lg-12">
 <div class="panel panel-default">
     
                             <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Gráficos Estadísticos
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" style="background-color: #008CBA; color: white;font-size: 14px;">
                                        Acciones en soles
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu"  style="background-color: #008CBA;">
                                        <li><a onclick="mostrar_MasVendidosSoles()"      style="background-color: #008CBA; color: white;font-size: 14px;">Productos Mas Vendidos</a></li>
<!--                                        <li class="divider"></li>-->
                                    </ul>
                                </div>
                            </div>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" style="background-color: #4CAF50; color: white;font-size: 14px;">
                                        Acciones en Dolares
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu"  style="background-color: #4CAF50;">
                                        <li><a onclick="mostrar_MasVendidosDolares()"     style="background-color: #4CAF50; color: white;font-size: 14px;">Productos Mas Vendidos</a></li>
<!--                                        <li class="divider" ></li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>

     
     


<div class="panel-body">
    <div id="containerMasVendidosSoles" style="width:90%;max-width:1000px; "></div>
    <div id="containerMasVendidosDolares" style="width:90%;max-width:1000px; display:none;"></div>
        
</div>
 </div>
</div>
</div>
<script>
function mostrar_MasVendidosSoles()
{
    $('#containerMasVendidosSoles').css('display','block');
    $('#containerMasVendidosDolares').css('display','none');
    
}


function mostrar_MasVendidosDolares()
{
    $('#containerMasVendidosSoles').css('display','none');
    $('#containerMasVendidosDolares').css('display','block');
    
}
</script>
<?php } ?>