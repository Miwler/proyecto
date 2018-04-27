<?php
require ROOT_PATH . "views/shared/content.php";

?>	
<?php

function fncTitle() { ?>
    Grafico Estadistico de Ventas
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
            $('#container_DiarioSoles').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Ventas Dia de la Semana'
                },
                

                subtitle: {
                    text: 'Ventas diarias de la semana'
                },
                xAxis: {
                    categories: [

                        'Día'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Soles (S./)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>S/. {point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                

                    <?php 
                            

                          foreach($GLOBALS['dtGrafico_Estadistico_Ventas_DiarioSoles'] as $row){
                    ?>{

                    name: '<?php echo FormatTextView($row['dia']);?>',
                    data: [<?php echo ($row['total_dia']);?>
                    ]},
                    <?php     
                            }
                            ?>
                    

                ]
            });
        });

    </script>
    
    
    
    
    
    
        
      <script type="text/javascript">
        $(function () {
            $('#container_DiarioDolares').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Ventas Dia de la Semana'
                },
                

                subtitle: {
                    text: 'Ventas diarias de la semana'
                },
                xAxis: {
                    categories: [

                        'Día'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Dolares ($.)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>$. {point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                

                    <?php 
                            

                          foreach($GLOBALS['dtGrafico_Estadistico_Ventas_DiarioDolares'] as $row){
                    ?>{

                    name: '<?php echo FormatTextView($row['dia']);?>',
                    data: [<?php echo ($row['total_dia']);?>
                    ]},
                    <?php     
                            }
                            ?>
                    

                ]
            });
        });

    </script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <script type="text/javascript">
        $(function () {
            $('#container_DiarioxMesSoles').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Ultima Mes'
                },
                

                subtitle: {
                    text: 'Ventas diarias del Mes'
                },
                xAxis: {
                    categories: [

                        'Día'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Soles (S./)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>S/. {point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                

                    <?php 
                            

                          foreach($GLOBALS['dtGrafico_Estadistico_Ventas_DiarioxMesSoles'] as $row){
                    ?>{

                    name: '<?php echo FormatTextView($row['numero_dia']);?>',
                    data: [<?php echo ($row['total_dia']);?>
                    ]},
                    <?php     
                            }
                            ?>
                    

                ]
            });
        });

    </script>
    
    
    
    
    
       
    <script type="text/javascript">
        $(function () {
            $('#container_DiarioxMesDolares').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Ultima Mes'
                },
                

                subtitle: {
                    text: 'Ventas diarias del Mes'
                },
                xAxis: {
                    categories: [

                        'Día'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Dolares ($)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>$ {point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                

                    <?php 
                            

                          foreach($GLOBALS['dtGrafico_Estadistico_Ventas_DiarioxMesDolares'] as $row){
                    ?>{

                    name: '<?php echo FormatTextView($row['numero_dia']);?>',
                    data: [<?php echo ($row['total_dia']);?>
                    ]},
                    <?php     
                            }
                            ?>
                    

                ]
            });
        });

    </script>
    
    
    
    

    <script type="text/javascript">
        $(function () {
            $('#container_MensualSoles').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Últimos Meses'
                },
                

                subtitle: {
                    text: 'Ventas Mensuales'
                },
                xAxis: {
                    categories: [

                        'Mes'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Soles (S./)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>S/. {point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                

                    <?php 
                            

                           foreach($GLOBALS['dtGrafico_Estadistico_Ventas_MensualSoles'] as $row){
                    ?>{

                    name: '<?php echo FormatTextView($row['mes']);?>',
                    data: [<?php echo ($row['total_mes']);?>
                    ]},
                    <?php     
                            }
                            ?>
                    

                ]
            });
        });

    </script>
    
    
    
       <script type="text/javascript">
        $(function () {
            $('#container_MensualDolares').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Últimos Meses'
                },
                

                subtitle: {
                    text: 'Ventas Mensuales'
                },
                xAxis: {
                    categories: [

                        'Mes'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Dolares ($)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>$ {point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                

                    <?php 
                            

                           foreach($GLOBALS['dtGrafico_Estadistico_Ventas_MensualDolares'] as $row){
                    ?>{

                    name: '<?php echo FormatTextView($row['mes']);?>',
                    data: [<?php echo ($row['total_mes']);?>
                    ]},
                    <?php     
                            }
                            ?>
                    

                ]
            });
        });

    </script>
    
    
    
    
    
    
     <script type="text/javascript">
        $(function () {
            $('#container_AnualSoles').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Último Anio'
                },
                

                subtitle: {
                    text: 'Ventas Anuales'
                },
                xAxis: {
                    categories: [

                        'Anio'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Soles (S./)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>S/. {point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                

                    <?php 

                           foreach($GLOBALS['dtGrafico_Estadistico_Ventas_AnualSoles'] as $row){
                    ?>{

                    name: '<?php echo ($row['anio']);?>',
                    data: [<?php echo ($row['total_anio']);?>
                    ]},
                    <?php     
                            }
                            ?>
                    

                ]
            });
        });

    </script>
    
    
    
     <script type="text/javascript">
        $(function () {
            $('#container_AnualDolares').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Último Anio'
                },
                

                subtitle: {
                    text: 'Ventas Anuales'
                },
                xAxis: {
                    categories: [

                        'Anio'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Dolares ($)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>$ {point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                

                    <?php 

                           foreach($GLOBALS['dtGrafico_Estadistico_Ventas_AnualDolares'] as $row){
                    ?>{

                    name: '<?php echo ($row['anio']);?>',
                    data: [<?php echo ($row['total_anio']);?>
                    ]},
                    <?php     
                            }
                            ?>
                    

                ]
            });
        });

    </script>
    
    
    

    
<?php } ?>
<?php

function fncMenu() { ?>
<?php } ?>
<?php

function fncPage() { ?>
    <h1 class="title-principal">
        Reporte de Ventas
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
                                        <li><a onclick="mostrar_DiarioSoles()"      style="background-color: #008CBA; color: white;font-size: 14px;">Ventas Ultima Semana</a></li>
                                        <li><a onclick="mostrar_DiarioxMesSoles()"  style="background-color: #008CBA; color: white;font-size: 14px;">Ventas Último Mes</a></li>
                                        <li><a onclick="mostrar_MensualSoles()"      style="background-color: #008CBA; color: white;font-size: 14px;">Ventas Últimos Meses</a></li>
                                        <li><a onclick="mostrar_AnualSoles()"    style="background-color: #008CBA; color: white;font-size: 14px;">Ventas Último Anio</a></li>
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
                                        <li><a onclick="mostrar_DiarioDolares()"     style="background-color: #4CAF50; color: white;font-size: 14px;">Ventas Ultima Semana</a></li>
                                        <li><a onclick="mostrar_DiarioxMesDolares()" style="background-color: #4CAF50; color: white;font-size: 14px;">Ventas Último Mes</a></li>
                                        <li><a onclick="mostrar_MensualDolares()"     style="background-color: #4CAF50; color: white;font-size: 14px;">Ventas Últimos Meses</a></li>
                                        <li><a onclick="mostrar_AnualDolares()"   style="background-color: #4CAF50; color: white;font-size: 14px;">Ventas Último Año</a></li>
<!--                                        <li class="divider" ></li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>

<div class="panel-body">
    
    <div id="container_DiarioSoles" style="width:90%;max-width:1000px; "></div>
    <div id="container_DiarioxMesSoles" style="width:90%;max-width:1000px; display:none;"></div>
    <div id="container_MensualSoles" style="width:90%;max-width:1000px; display:none;"></div>
    <div id="container_AnualSoles" style="width:90%;max-width:1000px; display:none;"></div> 
    
    
    
    <div id="container_DiarioDolares" style="width:90%;max-width:1000px; display:none;"></div>
    <div id="container_DiarioxMesDolares" style="width:90%;max-width:1000px; display:none;"></div>
    <div id="container_MensualDolares" style="width:90%;max-width:1000px; display:none;"></div>
    <div id="container_AnualDolares" style="width:90%;max-width:1000px; display:none;"></div> 
    
</div>
 </div>
</div>
</div>
<?php } ?>