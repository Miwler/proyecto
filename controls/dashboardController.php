<?php	

function get_Index($id) {
    global $returnView;
    $returnView = true;
}

//-----------------------------------------------------------------------------------------------------------------------------
function get_Graficos_Estadisticos() {
    //require ROOT_PATH.'models/ingreso.php';
    require ROOT_PATH.'controls/funcionController.php';
    global $returnView;
    $returnView = true;
    $dtMeses=getMeses(1,12);
    $dtPeriodo=array();

    $GLOBALS['dtMeses']=$dtMeses;

}
function post_ajaxGraficos_Estadisticos_Compras(){
    require ROOT_PATH.'models/reportes.php';
    require ROOT_PATH.'controls/funcionController.php';
    $grafico=$_POST['selGrafico'];
    $periodo=$_POST['selPeriodo'];
    $tipo_valor=$_POST['selValores'];
    $mes=0;
    if(isset($_POST['selMes'])){
         $mes=$_POST['selMes'];
    }
    
    $labels="";
    $group="";
    $filtro="";
    if($periodo==0){
        $group="year(co.fecha_emision)";
        $dtPeriodos=getPeriodos(2016,date('Y'));
        $i=0;
        foreach($dtPeriodos as $val){
            if($labels==""){
                $labels='"'.$val['nombre'].'"';
            }else {
                $labels.=',"'.$val['nombre'].'"';
            }
          $i++;  
        }
            
    }else if($mes==0) {
        $group="year(co.fecha_emision),month(co.fecha_emision)";
        $fin=12;
        if($periodo==date('Y')){
            $fin=date('n');
        }
        $dtMeses=getMeses(1,$fin);
        $i=0;
        foreach($dtMeses as $item){
            if($i==0){
                $labels='"'.$item['nombre'].'"';
            }else {
                $labels=$labels.',"'.$item['nombre'].'"';
            }
            
            $i++;
        };
        $filtro="year(co.fecha_emision)=".$periodo;
    }else {
        $group="year(co.fecha_emision),year(co.fecha_emision),day(co.fecha_emision)";
        $filtro="year(co.fecha_emision)=".$periodo." and month(co.fecha_emision)=".$mes;
        $dtDias=getDiasMes(1,$mes,$periodo);
        $i=0;
        foreach($dtDias as $item){
            if($i==0){
                $labels='"'.$item['nombre'].'"';
            }else {
                $labels=$labels.',"'.$item['nombre'].'"';
            }
            
            $i++;
        };
        
    }
   
    try{
        $order=$group.',co.moneda_ID';
        $group.=",co.moneda_ID";
        $dtReportesCompras=reportes::getReporteCompras($filtro,-1,-1,$order,$group);
        if($tipo_valor=="porcentaje"){
            $total_soles=0;
            $total_dolares=0;
            foreach($dtReportesCompras as $value){
                if($value['moneda_ID']==1){
                    $total_soles=$total_soles+$value['total'];
                }else {
                    $total_dolares=$total_dolares+$value['total'];
                }
            }
            $array_soles=array();    
            $array_dolares=array(); 
            foreach($dtReportesCompras as $valor){
                
                if($periodo==0){
                    if($valor['moneda_ID']==1){
                        if($total_soles>0){
                            $array_soles[$valor['periodo']]=round($valor['total']/$total_soles*100);
                        }
                        
                    }else {
                        if($total_dolares>0){
                            $array_dolares[$valor['periodo']]=round($valor['total']/$total_dolares*100);
                        }
                        
                    }
                }else if($mes==0){
                    if($valor['moneda_ID']==1){
                        if($total_soles>0){
                             $array_soles[$valor['mes']]=round($valor['total']/$total_soles*100); 
                        }
                       
                    }else {
                        if($total_dolares>0){
                            $array_dolares[$valor['mes']]=round($valor['total']/$total_dolares*100);
                        }
                       
                    }
                }else {
                    if($valor['moneda_ID']==1){
                        if($total_soles>0){
                             $array_soles[$valor['dia']]=round($valor['total']/$total_soles*100); 
                        }
                        
                    }else {
                        if($total_dolares>0){
                            $array_dolares[$valor['dia']]=round($valor['total']/$total_dolares*100);
                        }
                        
                    }
                }

            };
        }else {
        
        $array_soles=array();    
        $array_dolares=array(); 
        foreach($dtReportesCompras as $valor){
            if($periodo==0){
                if($valor['moneda_ID']==1){
                    $array_soles[$valor['periodo']]=$valor['total'];
                }else {
                    $array_dolares[$valor['periodo']]=$valor['total'];
                }
            }else if($mes==0){
                if($valor['moneda_ID']==1){
                    $array_soles[$valor['mes']]=$valor['total'];
                }else {
                    $array_dolares[$valor['mes']]=$valor['total'];
                }
            }else {
                if($valor['moneda_ID']==1){
                    $array_soles[$valor['dia']]=$valor['total'];
                }else {
                    $array_dolares[$valor['dia']]=$valor['total'];
                }
            }
  
        };
        
       }
        $valores_soles="";
        $valores_dolares="";
        $valor_indice="";
        $i=0;
        $y=0;
        $z=0;
        $dtBuscador=array();
        if($periodo==0){
            $dtBuscador=$dtPeriodos;
        }elseif($mes==0){
            $dtBuscador=$dtMeses;
        }else {
            $dtBuscador=$dtDias;
        }
        foreach($dtBuscador as $valores){
            if($z==0){
                    $valor_indice=$valores['valor'];
                }else {
                    $valor_indice.=",".$valores['valor'];
                }
                $z++;
            if(isset($array_soles[$valores['valor']])){
                
                if($i==0){
                    $valores_soles=$array_soles[$valores['valor']];
                    $i++;
                }else {
                    $valores_soles=$valores_soles.",".$array_soles[$valores['valor']];
                }
                
            }else {
                if($i==0){
                    $valores_soles="0";
                    $i++;
                }else {
                    $valores_soles=$valores_soles.",0";
                }
            }
            if(array_key_exists($valores['valor'],$array_dolares)){
                 if($y==0){
                    $valores_dolares=$array_dolares[$valores['valor']];
                    $y++;
                }else {
                    $valores_dolares=$valores_dolares.",".$array_dolares[$valores['valor']];
                }
            }else {
                if($y==0){
                    $valores_dolares="0";
                    $y++;
                }else {
                    $valores_dolares=$valores_dolares.",0";
                }
            }
          
        };
        $resultado='<script type=text/javascript">var barChartData = {
                     labels: ['.$labels.'],
                     datasets: [{
                        type: "'.$grafico.'",
                         label: "Dólares",
                         backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
                         borderColor: window.chartColors.blue,
                         data: ['.$valores_dolares.'
                             
                         ],
                         options:{
                            animation:{
                                onProgress:function(animation){
                                    progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                                }
                                
                            }
                         }
                     }, {
                         type: "'.$grafico.'",
                         label: "Soles",
                         backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
                         borderColor: window.chartColors.red,
                         data: ['.$valores_soles.'                             
                         ],
                         options:{
                            animation:{
                                onProgress:function(animation){
                                    progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                                }
                                
                            }
                         }
                     }]
                 }; </script>';
        $titulo="Gráfico de compras";
    }catch(Exception $ex){
        
    }
       
    $retornar = Array('resultado' => $resultado, 'titulo' => $titulo);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}
function post_ajaxGraficos_Estadisticos_Ventas(){
    require ROOT_PATH.'models/reportes.php';
    require ROOT_PATH.'controls/funcionController.php';
    $grafico=$_POST['selGrafico'];
    $periodo=$_POST['selPeriodo'];
    $tipo_valor=$_POST['selValores'];
    $mes=0;
    if(isset($_POST['selMes'])){
         $mes=$_POST['selMes'];
    }
    $opcion=0;
    $labels="";
    $group="";
    $filtro="";
    if($periodo==0){
        $group="year(ov.fecha)";
        $dtPeriodos=getPeriodos(2016,date('Y'));
        $i=0;
        foreach($dtPeriodos as $val){
            if($labels==""){
                $labels='"'.$val['nombre'].'"';
            }else {
                $labels.=',"'.$val['nombre'].'"';
            }
          $i++;  
        }
            
    }else if($mes==0) {
        $group="year(ov.fecha),month(ov.fecha)";
        $fin=12;
        if($periodo==date('Y')){
            $fin=date('n');
        }
        $dtMeses=getMeses(1,$fin);
        $i=0;
        foreach($dtMeses as $item){
            if($i==0){
                $labels='"'.$item['nombre'].'"';
            }else {
                $labels=$labels.',"'.$item['nombre'].'"';
            }
            
            $i++;
        };
        $filtro="year(ov.fecha)=".$periodo;
    }else {
        $group="year(ov.fecha),year(ov.fecha),day(ov.fecha)";
        $filtro="year(ov.fecha)=".$periodo." and month(ov.fecha)=".$mes;
        $dtDias=getDiasMes(1,$mes,$periodo);
        $i=0;
        foreach($dtDias as $item){
            if($i==0){
                $labels='"'.$item['nombre'].'"';
            }else {
                $labels=$labels.',"'.$item['nombre'].'"';
            }
            
            $i++;
        };
        
    }
   
    try{
        $order=$group.',ov.moneda_ID';
        $group.=",ov.moneda_ID";
        $dtReportesCompras=reportes::getReporteVentas($filtro,-1,-1,$order,$group);
        if($tipo_valor=="porcentaje"){
            $total_soles=0;
            $total_dolares=0;
            foreach($dtReportesCompras as $value){
                if($value['moneda_ID']==1){
                    $total_soles=$total_soles+$value['total'];
                }else {
                    $total_dolares=$total_dolares+$value['total'];
                }
            }
            $array_soles=array();    
            $array_dolares=array(); 
            foreach($dtReportesCompras as $valor){
                
                if($periodo==0){
                    if($valor['moneda_ID']==1){
                        if($total_soles>0){
                            $array_soles[$valor['periodo']]=round($valor['total']/$total_soles*100);
                        }
                        
                    }else {
                        if($total_dolares>0){
                            $array_dolares[$valor['periodo']]=round($valor['total']/$total_dolares*100);
                        }
                        
                    }
                }else if($mes==0){
                    if($valor['moneda_ID']==1){
                        if($total_soles>0){
                             $array_soles[$valor['mes']]=round($valor['total']/$total_soles*100); 
                        }
                       
                    }else {
                        if($total_dolares>0){
                            $array_dolares[$valor['mes']]=round($valor['total']/$total_dolares*100);
                        }
                       
                    }
                }else {
                    if($valor['moneda_ID']==1){
                        if($total_soles>0){
                             $array_soles[$valor['dia']]=round($valor['total']/$total_soles*100); 
                        }
                        
                    }else {
                        if($total_dolares>0){
                            $array_dolares[$valor['dia']]=round($valor['total']/$total_dolares*100);
                        }
                        
                    }
                }

            };
        }else {
        $array_soles=array();    
        $array_dolares=array(); 
        foreach($dtReportesCompras as $valor){
            if($periodo==0){
                if($valor['moneda_ID']==1){
                    $array_soles[$valor['periodo']]=$valor['total'];
                }else {
                    $array_dolares[$valor['periodo']]=$valor['total'];
                }
            }else if($mes==0){
                if($valor['moneda_ID']==1){
                    $array_soles[$valor['mes']]=$valor['total'];
                }else {
                    $array_dolares[$valor['mes']]=$valor['total'];
                }
            }else {
                if($valor['moneda_ID']==1){
                    $array_soles[$valor['dia']]=$valor['total'];
                }else {
                    $array_dolares[$valor['dia']]=$valor['total'];
                }
            }
  
        };
        }
        $valores_soles="";
        $valores_dolares="";
        $i=0;
        $y=0;
        $dtBuscador=array();
        if($periodo==0){
            $dtBuscador=$dtPeriodos;
        }elseif($mes==0){
            $dtBuscador=$dtMeses;
        }else {
            $dtBuscador=$dtDias;
        }
        foreach($dtBuscador as $valores){
            if(isset($array_soles[$valores['valor']])){
                if($i==0){
                    $valores_soles=$array_soles[$valores['valor']];
                    $i++;
                }else {
                    $valores_soles=$valores_soles.",".$array_soles[$valores['valor']];
                }
                
            }else {
                if($i==0){
                    $valores_soles="0";
                    $i++;
                }else {
                    $valores_soles=$valores_soles.",0";
                }
            }
            if(isset($array_dolares[$valores['valor']])){
                if($y==0){
                    $valores_dolares=$array_dolares[$valores['valor']];
                    $y++;
                }else {
                    $valores_dolares=$valores_dolares.",".$array_dolares[$valores['valor']];
                }
                
            }else {
                if($y==0){
                    $valores_dolares="0";
                    $y++;
                }else {
                    $valores_dolares=$valores_dolares.",0";
                }
            }
        };
        $resultado='<script type=text/javascript">var barChartData = {
                     labels: ['.$labels.'],
                     datasets: [{
                        type: "'.$grafico.'",
                         label: "Dólares",
                         backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
                         borderColor: window.chartColors.blue,
                         data: ['.$valores_dolares.'
                             
                         ],
                         options:{
                            animation:{
                                onProgress:function(animation){
                                    progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                                }
                                
                            }
                         }
                     }, {
                         type: "'.$grafico.'",
                         label: "Soles",
                         backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
                         borderColor: window.chartColors.red,
                         data: ['.$valores_soles.'                             
                         ],
                         options:{
                            animation:{
                                onProgress:function(animation){
                                    progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                                }
                                
                            }
                         }
                     }]
                 }; </script>';
        $titulo="Gráfico de ventas";
    }catch(Exception $ex){
        $resultado=$ex->getMessage();
        $titulo="";
    }
       
    $retornar = Array('resultado' => $resultado, 'titulo' => $titulo);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}

function post_ajaxGraficos_Estadisticos_Ganancias(){
    require ROOT_PATH.'models/reportes.php';
    require ROOT_PATH.'controls/funcionController.php';
    $grafico=$_POST['selGrafico'];
    $periodo=$_POST['selPeriodo'];
    $tipo_valor=$_POST['selValores'];
    $mes=0;
    if(isset($_POST['selMes'])){
         $mes=$_POST['selMes'];
    }
    $opcion=0;
    $labels="";
    $group="";
    $filtro="";
    if($periodo==0){
        $group="year(ov.fecha)";
        $dtPeriodos=getPeriodos(2016,date('Y'));
        $i=0;
        foreach($dtPeriodos as $val){
            if($labels==""){
                $labels='"'.$val['nombre'].'"';
            }else {
                $labels.=',"'.$val['nombre'].'"';
            }
          $i++;  
        }
            
    }else if($mes==0) {
        $group="year(ov.fecha),month(ov.fecha)";
        $fin=12;
        if($periodo==date('Y')){
            $fin=date('n');
        }
        $dtMeses=getMeses(1,$fin);
        $i=0;
        foreach($dtMeses as $item){
            if($i==0){
                $labels='"'.$item['nombre'].'"';
            }else {
                $labels=$labels.',"'.$item['nombre'].'"';
            }
            
            $i++;
        };
        $filtro="year(ov.fecha)=".$periodo;
    }else {
        $group="year(ov.fecha),year(ov.fecha),day(ov.fecha)";
        $filtro="year(ov.fecha)=".$periodo." and month(ov.fecha)=".$mes;
        $dtDias=getDiasMes(1,$mes,$periodo);
        $i=0;
        foreach($dtDias as $item){
            if($i==0){
                $labels='"'.$item['nombre'].'"';
            }else {
                $labels=$labels.',"'.$item['nombre'].'"';
            }
            
            $i++;
        };
        
    }
   
    try{
        $order=$group.',ov.moneda_ID';
        $group.=",ov.moneda_ID";
        $dtReportesCompras=reportes::getReporteGanancias($filtro,-1,-1,$order,$group);
        if($tipo_valor=="porcentaje"){
            $total_soles=0;
            $total_dolares=0;
            foreach($dtReportesCompras as $value){
                if($value['moneda_ID']==1){
                    $total_soles=$total_soles+$value['total'];
                }else {
                    $total_dolares=$total_dolares+$value['total'];
                }
            }
            $array_soles=array();    
            $array_dolares=array(); 
            foreach($dtReportesCompras as $valor){
                
                if($periodo==0){
                    if($valor['moneda_ID']==1){
                        if($total_soles>0){
                            $array_soles[$valor['periodo']]=round($valor['total']/$total_soles*100);
                        }
                        
                    }else {
                        if($total_dolares>0){
                            $array_dolares[$valor['periodo']]=round($valor['total']/$total_dolares*100);
                        }
                        
                    }
                }else if($mes==0){
                    if($valor['moneda_ID']==1){
                        if($total_soles>0){
                             $array_soles[$valor['mes']]=round($valor['total']/$total_soles*100); 
                        }
                       
                    }else {
                        if($total_dolares>0){
                            $array_dolares[$valor['mes']]=round($valor['total']/$total_dolares*100);
                        }
                       
                    }
                }else {
                    if($valor['moneda_ID']==1){
                        if($total_soles>0){
                             $array_soles[$valor['dia']]=round($valor['total']/$total_soles*100); 
                        }
                        
                    }else {
                        if($total_dolares>0){
                            $array_dolares[$valor['dia']]=round($valor['total']/$total_dolares*100);
                        }
                        
                    }
                }

            };
        }else {
        $array_soles=array();    
        $array_dolares=array(); 
        foreach($dtReportesCompras as $valor){
            if($periodo==0){
                if($valor['moneda_ID']==1){
                    $array_soles[$valor['periodo']]=$valor['total'];
                }else {
                    $array_dolares[$valor['periodo']]=$valor['total'];
                }
            }else if($mes==0){
                if($valor['moneda_ID']==1){
                    $array_soles[$valor['mes']]=$valor['total'];
                }else {
                    $array_dolares[$valor['mes']]=$valor['total'];
                }
            }else {
                if($valor['moneda_ID']==1){
                    $array_soles[$valor['dia']]=$valor['total'];
                }else {
                    $array_dolares[$valor['dia']]=$valor['total'];
                }
            }
  
        };
        }
        $valores_soles="";
        $valores_dolares="";
        $i=0;
        $y=0;
        $dtBuscador=array();
        if($periodo==0){
            $dtBuscador=$dtPeriodos;
        }elseif($mes==0){
            $dtBuscador=$dtMeses;
        }else {
            $dtBuscador=$dtDias;
        }
        foreach($dtBuscador as $valores){
            if(isset($array_soles[$valores['valor']])){
                if($i==0){
                    $valores_soles=$array_soles[$valores['valor']];
                    $i++;
                }else {
                    $valores_soles=$valores_soles.",".$array_soles[$valores['valor']];
                }
                
            }else {
                if($i==0){
                    $valores_soles="0";
                    $i++;
                }else {
                    $valores_soles=$valores_soles.",0";
                }
            }
            if(isset($array_dolares[$valores['valor']])){
                if($y==0){
                    $valores_dolares=$array_dolares[$valores['valor']];
                    $y++;
                }else {
                    $valores_dolares=$valores_dolares.",".$array_dolares[$valores['valor']];
                }
                
            }else {
                if($y==0){
                    $valores_dolares="0";
                    $y++;
                }else {
                    $valores_dolares=$valores_dolares.",0";
                }
            }
        };
        $resultado='<script type=text/javascript">var barChartData = {
                     labels: ['.$labels.'],
                     datasets: [{
                        type: "'.$grafico.'",
                         label: "Dólares",
                         backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
                         borderColor: window.chartColors.blue,
                         data: ['.$valores_dolares.'
                             
                         ],
                         options:{
                            animation:{
                                onProgress:function(animation){
                                    progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                                }
                                
                            }
                         }
                     }, {
                         type: "'.$grafico.'",
                         label: "Soles",
                         backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
                         borderColor: window.chartColors.red,
                         data: ['.$valores_soles.'                             
                         ],
                         options:{
                            animation:{
                                onProgress:function(animation){
                                    progress.value = animation.animationObject.currentStep / animation.animationObject.numSteps;
                                }
                                
                            }
                         }
                     }]
                 }; </script>';
        $titulo="Gráfico de ganancias";
    }catch(Exception $ex){
        $resultado=$ex->getMessage();
        $titulo="";
    }
       
    $retornar = Array('resultado' => $resultado, 'titulo' => $titulo);
    //$retorn="<h1>Hola</h1>";

    echo json_encode($retornar);
}


function get_Grafico_Estadistico_Ventas() {
    require ROOT_PATH.'models/orden_venta.php';
    global $returnView;
    $returnView = true;
    
       
    $dtGrafico_Estadistico_Ventas_DiarioSoles=orden_venta::MostrarGrafico_DiarioSoles();
    $dtGrafico_Estadistico_Ventas_DiarioDolares=orden_venta::MostrarGrafico_DiarioDolares();
    
    $dtGrafico_Estadistico_Ventas_DiarioxMesSoles=orden_venta::MostrarGrafico_DiarioxMesSoles();
    $dtGrafico_Estadistico_Ventas_DiarioxMesDolares=orden_venta::MostrarGrafico_DiarioxMesDolares();
    
    $dtGrafico_Estadistico_Ventas_MensualSoles=orden_venta::MostrarGrafico_MensualSoles();
    $dtGrafico_Estadistico_Ventas_MensualDolares=orden_venta::MostrarGrafico_MensualDolares();
    
    $dtGrafico_Estadistico_Ventas_AnualSoles=orden_venta::MostrarGrafico_AnualSoles();
    $dtGrafico_Estadistico_Ventas_AnualDolares=orden_venta::MostrarGrafico_AnualDolares();
   
    $GLOBALS['dtGrafico_Estadistico_Ventas_DiarioSoles']=$dtGrafico_Estadistico_Ventas_DiarioSoles;
    $GLOBALS['dtGrafico_Estadistico_Ventas_DiarioDolares']=$dtGrafico_Estadistico_Ventas_DiarioDolares;
    $GLOBALS['dtGrafico_Estadistico_Ventas_DiarioxMesSoles']=$dtGrafico_Estadistico_Ventas_DiarioxMesSoles;
    $GLOBALS['dtGrafico_Estadistico_Ventas_DiarioxMesDolares']=$dtGrafico_Estadistico_Ventas_DiarioxMesDolares;
    $GLOBALS['dtGrafico_Estadistico_Ventas_MensualSoles']=$dtGrafico_Estadistico_Ventas_MensualSoles;
    $GLOBALS['dtGrafico_Estadistico_Ventas_MensualDolares']=$dtGrafico_Estadistico_Ventas_MensualDolares;
    $GLOBALS['dtGrafico_Estadistico_Ventas_AnualSoles']=$dtGrafico_Estadistico_Ventas_AnualSoles;
    $GLOBALS['dtGrafico_Estadistico_Ventas_AnualDolares']=$dtGrafico_Estadistico_Ventas_AnualDolares;
    
}




function get_Grafico_Estadistico_Productos() {
    require ROOT_PATH.'models/producto.php';
    global $returnView;
    $returnView = true;
    
    $dtGrafico_Estadistico_Producto_MasVendidos=producto::MostrarGraficoProducto_MasVendidos();
   
    $GLOBALS['dtGrafico_Estadistico_Producto_MasVendidos']=$dtGrafico_Estadistico_Producto_MasVendidos;
  
}



function get_Grafico_Estadistico_Clientes() {
    require ROOT_PATH.'models/cliente.php';
    global $returnView;
    $returnView = true;
    
    $dtGrafico_Estadistico_Cliente_Exclusivo=cliente::MostrarGraficoCliente_Exclusivo();
   
    $GLOBALS['dtGrafico_Estadistico_Cliente_Exclusivo']=$dtGrafico_Estadistico_Cliente_Exclusivo;
  
}

	
?>