<?php
	define('ROOT_PATH',dirname(__FILE__)."/");
	define('DOMAIN_BASE',"http://".$_SERVER['HTTP_HOST']);
        require ROOT_PATH."models/connect.php";
	require ROOT_PATH."models/inventario.php";
        require ROOT_PATH."models/cotizacion_detalle.php";
        $dtInventario=inventario::getGrid('estado_ID=51');
        $html="<table><tr><td>cotizacion_detalle</td><td>ID Inv</td><td>Fecha</td><td>Fecha cierre</td></tr>";
        foreach($dtInventario as $item){
            $oInventario=inventario::getByID($item['ID']);
            $oCotizacion_Detalle=cotizacion_detalle::getByID($item['cotizacion_detalle_ID']);
            $html.="<tr>";
           
            $html.="<td>".$oCotizacion_Detalle->ID."</td>";
             $html.="<td>".$item['ID']."</td>";
            $fecha_actual=date('Y-m-d');
            $fecha_modificacion= date_create($oInventario->fdm);
            $html.="<td>".date_format($fecha_modificacion,'Y-m-d')."</td>";
            $tiempo_espera=$oCotizacion_Detalle->tiempo_separacion;
            date_add($fecha_modificacion,date_interval_create_from_date_string($tiempo_espera.' days'));
            $valor=0;
            $nueva_fecha=date_format($fecha_modificacion,'Y-m-d');
            if($nueva_fecha<$fecha_actual){
                
                $oInventario->estado_ID=48;
                $valor=$oInventario->actualizarEstadoAutomatico();
                $oCotizacion_Detalle->separacion=0;
                $oCotizacion_Detalle->tiempo_separacion=0;
                $oCotizacion_Detalle->cantidad_separada=0;
                $oCotizacion_Detalle->actualizar();
            }
            $html.="<td>".date_format($fecha_modificacion,'Y-m-d')."</td>";
             $html.="<td>".$valor."</td>";
            $html.="</tr>";
        }
        
        echo $html;
?>
