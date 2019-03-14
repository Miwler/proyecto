<?php
require ROOT_PATH . "views/shared/content.php";

?>	
<?php

function fncTitle() { ?>
    Grafico Estadistico de Compras
<?php } ?>
<?php

function fncHead() { ?>
    <script type="text/javascript" src="include/js/jForm.js"></script>
    <script src="../../include/chart/Chart.bundle.js" type="text/javascript"></script>
    <script src="../../include/chart/utils.js" type="text/javascript"></script>
    <style>
    canvas{
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
    .nav-tabs.nav-justified>.active>a{
       background: #337ab7!important; 
       color:#fff!important;
    }
    </style>

<?php } ?>
<?php

function fncMenu() { ?>
<?php } ?>
<?php function fncTituloCabecera(){?>
     <i class="fa fa-dashboard" aria-hidden="true"></i> GRÁFICOS ESTADÍSTICOS
<?php } ?>
<?php function fncPage() { ?>
    <div class="panel panel-tab panel-tab-double shadow" class="form-horizontal">
       
        
        <div class="panel-boby">
            <div id="divFiltro" class="form-group">
                <div class="col-md-1 col-sm-1 col-xs-1 text-right">
                    <label>Tipo gráfico:</label>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <select id='selGrafico' name='selGrafico' class="form-control">
                        <option value='line'>Líneas</option>
                        <option value='bar'>Barras</option>
                    </select>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 text-right">
                    <label>	Valores:</label>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <select id='selValores' name='selValores' class="form-control">
                        <option value='numero'>Cífras</option>
                        <option value='porcentaje'>Porcentaje</option>
                    </select>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 text-right">
                    <label>Periodo:</label>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <select id="selPeriodo" name="selPeriodo" class="form-control">
                        <option value="0">Todos</option>
                       <?php for($i=periodo_inicio;$i<=date('Y');$i++){?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 text-right">
                    <label>Mes:</label>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <select id="selMes" name="selMes" disabled class="form-control">
                        <option value="0">Todos</option>
                        <?php foreach($GLOBALS['dtMeses'] as $item){?>
                        <option value="<?php echo $item['valor']?>"><?php echo $item['nombre']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <ul id="menu_opciones" class="nav nav-tabs nav-justified">
                        <li class="nav-item border border-primary">
                            <a id="compras" class="nav-link active" data-toggle="tab" href="#panel1" role="tab"><h3>Compras</h3></a>
                        </li>
                        <li class="nav-item border border-primary">
                            <a id="ventas" class="nav-link" data-toggle="tab" href="#panel2" role="tab"><h3>Ventas</h3></a>
                        </li>
                        <li class="nav-item border border-primary">
                            <a id="ganancias" class="nav-link" data-toggle="tab" href="#panel3" role="tab"><h3>Ganancias</h3></a>
                        </li>
                    </ul>
                </div>
                
            </div>
            <div class="form-group">
                <div id="divContenedor" class="col-sm-12">
                    <canvas id="canvas" style="height: 350px;width: 1100px;"></canvas>
               </div>
            </div>
            
        </div>
    </div>
   
    
        
    <div id="barChartData" style="display:none" ></div>
    <script>
         $('#menu_opciones a').click(function(){
            
           var ID=this.id;
           grafico(ID);
        });
        function grafico(ID){
        $('#divContenedor').html('');
            
            $('.chartjs-hidden-iframe').remove();
            
            
           
            
            
            var url="";
          switch(ID){
              case "compras":
                  url="ajaxGraficos_Estadisticos_Compras";
                  break;
              case "ventas":
                  url="ajaxGraficos_Estadisticos_Ventas";
                  break;
            case "ganancias":
                  url="ajaxGraficos_Estadisticos_Ganancias";
                  break;
              
          }
         enviarValores('divFiltro','dashboard/'+url, function(resultado){
                $('#divContenedor').html('<canvas id="canvas" style="height: 350px;width: 1100px;"></canvas>');
               
                $('#barChartData').html(resultado.resultado);
                mostrar_grafico(resultado.titulo);
            });
        }
        var mostrar_grafico=function(titulo){
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: titulo
                    },
                }
            });
        }
        $('#selPeriodo').change(function(){
            var valor=this.value;
            if(valor==0){
                $('#selMes').val(0);
                $('#selMes').prop('disabled', true);
            }else {
                $('#selMes').prop('disabled', false);
            }
            
        });
            
            var color = Chart.helpers.color;
          
            window.onload = function() {
                    var ctx = document.getElementById('canvas').getContext('2d');
                    window.myBar = new Chart(ctx, {
                            type: 'bar',
                            data: barChartData,
                            options: {
                                    responsive: true,
                                    legend: {
                                            position: 'top',
                                    },
                                    title: {
                                            display: true,
                                            text: 'Chart.js Bar Chart'
                                    }
                            }
                    });

            };

            
            var colorNames = Object.keys(window.chartColors);
            $(document).ready(function(){
                $("#ventas").parent().addClass("active");
                grafico("ventas");
            });
            
            
            
    </script>
<?php } ?>
