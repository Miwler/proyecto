<?php
	require_once 'dompdf/dompdf_config.inc.php';
        require ROOT_PATH . 'models/cotizacion_detalle.php';
        require ROOT_PATH . 'models/producto.php';
        require ROOT_PATH . 'models/operador.php';
        require ROOT_PATH . 'models/cargo.php';
        require ROOT_PATH . 'models/datos_generales.php';
        require ROOT_PATH . 'models/representantecliente.php';
        require ROOT_PATH . 'models/cliente.php';
        require ROOT_PATH . 'models/cotizacion.php';
        require ROOT_PATH . 'models/forma_pago.php';
        require ROOT_PATH . 'models/moneda.php';
        require ROOT_PATH . 'include/lib_fecha_texto.php';
        $cotizacion_ID=$_GET["idcotizacion"];
//	$dtCotizacion_Detalle=cotizacion_detalle::getGrid('cotizacion_ID='.$cotizacion);
	$oCotizacion=cotizacion::getByID($cotizacion_ID);	
        $oDatos_Generales=datos_generales::getByID(1);	
        $oCliente=cliente::getByID($oCotizacion->cliente_ID);
        $oRepresentanteCliente=representantecliente::getByID($oCotizacion->representante_cliente_ID);
        if($oRepresentanteCliente==null){
            $oRepresentanteCliente=new representantecliente();
            $oRepresentanteCliente->nombres="-";
            $oRepresentanteCliente->apellidos="-";
        }
        $oForma_Pago=forma_pago::getByID($oCotizacion->forma_pago_ID);
        $oMoneda=moneda::getByID($oCotizacion->moneda_ID);
        $dtCotizacion_Detalle=  cotizacion_detalle::getGrid('cotizacion_ID='.$cotizacion_ID.' and cotizacion_detalle_ID=0');
        $fecha=fechaATexto("04/08/2016");
        if($oCotizacion->operador_ID=="-1"){
            
            $oOperador= new operador();
            $oOperador->nombres="";
            $oOperador->apellido_paterno="";
            $oOperador->anexo="";
            $oOperador->rpc="";
            $oOperador->rpm="";
            $oOperador->nextel="";
            $oOperador->mail="";
            $oCargo= new cargo();
            $oCargo->nombre="";
        }else {
            $oOperador=operador::getByID($oCotizacion->operador_ID);
            if($oOperador->cargo_ID!="null"){
                $oCargo=Cargo::getByID($oOperador->cargo_ID);
            }else{
                $oCargo= new cargo();
                $oCargo->nombre="";
            }
        }
        $sub_total=0;
        $vigv=0;
        $precio_total=0;
        if($oCotizacion->forma_pago_ID==1){
            $sub_total=$oCotizacion->precio_venta_neto_soles;
            $vigv=$oCotizacion->vigv_soles;
            $precio_total=$oCotizacion->precio_venta_total_soles;
        }else if($oCotizacion->forma_pago_ID==2){
            $sub_total=$oCotizacion->precio_venta_neto_dolares;
            $vigv=$oCotizacion->vigv_dolares;
            $precio_total=$oCotizacion->precio_venta_total_dolares;
        }
  //  $ocliente = cliente::getByID($aCotizacion->cliente);	
//$codigoHTML
$cabeceraHTML='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cotización PDF</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <style type="text/css">
    @font-face
        {
           font-family: "calibri";
           src: url("include/font/calibri.ttf");
           src: url("include/font/calibri..eot?#amocristalab") format("embedded-opentype"),
                url("fuentefancy.woff") format("woff"),
                url("fuentefancy.ttf") format("truetype"),
                url("fuentefancy.svg#IDdelafuente") format("svg");
        }
        span{font-family: sans-serif;
        display:block;font-weight: normal;}
        .condiciones{
            font-size:10px;
            padding-left: 4px;
        }
        .presentacion{
            font-size:10px;
        }
        .presentacion_contenido{
            display:inline-block;
        }
        th{
           background: #99d959; 
           font-family: calibri;
           font-size:14px;
           padding: 5px 0;
        }
        .tablacontenido{
            border-collapse:collapse;
        }
       .tablacontenido th{
            border:1px solid #000;
        }
        .tablacontenido td{
            border:1px solid #000;
        }
        .tablacontenido span{
            font-size: 12px; 
            font-weight: bold; 
            padding-left: 4px;
        }
        .producto{
           text-transform:uppercase;
           font-size:12px;
           font-weight: bold;
           color:#413F3F;
        }
        td.celda{
            
            vertical-align:top;
        }
        .descripcion{
            font-weight: normal !important;
            font-size: 12px!important;
            text-align: left;
        }
        .contacto{
            font-size:10px;
            display:inline-block;
        }
    </style>
     <div style="position:fixed; height: 80px;">
        dedede
    </div>
    <div style="height:80px;"></div>
    <div>
<table>
<tr>
    <td>
        <table width="700px" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="275px" style="vertical-align: bottom;"><img  src="imagen/logo_cotizacion.jpg" width="240" ></img></td>
                <td width="255px" style="vertical-align: bottom;"><span  style="font-size:18px; font-weight:bold; text-align:left;display:block;font-family: calibri">RUC: '.$oDatos_Generales->ruc .'</span></td>
                <td width="170px" style="vertical-align: bottom;">
                  <span align="center" style="font-size:18px; font-weight: bold;text-align:center;">'.$oDatos_Generales->telefono .'</span>
                  <span align="center" style="font-size:15px; color:#556B2F;text-align:center;">Central Telefónica</span>
                  <span align="center" style="font-size:12px; font-weight: bold;text-align:center;">Email : '.$oDatos_Generales->mail_info.'</span>
                  <span align="center" style="font-size:12px; font-weight: bold;text-align:center;">'.$oDatos_Generales->direccion.'</span>
                  
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table cellpadding=0 cellspacing=0 style="width:700px;" >
        <tr>
            <td rowspan="3" width="520px" style="border:1px solid #000; vertical-align: top;padding-top: 5px;">
                <span style="font-weight:bold; font-size:14px;padding-left: 4px;display: inline-block; width:75px; ">Señores :</span> <span style="width: 435px;display: inline-block; text-transform: uppercase;font-weight: bold;font-size:14px;">'.$oCliente->razon_social.'</span>
                <span style="font-weight:bold;font-size:14px;padding-left:4px; width:75px;display:block;" >Presente.-  </span>
                <div style="padding-top:15px;">
                    <span style="font-weight: bold;font-size:14px;padding-left: 4px;display: inline-block; width:75px;"> Atención: </span> <span style="display: inline-block;width:435px; font-size:14px; font-family:calibri">'.$oRepresentanteCliente->nombres.' '.$oRepresentanteCliente->apellidos.'</span>

                </div>
            </td >
            <td width="180px" style="border:1px solid #000;">
               <span style=" text-align: center; background: #99d959; font-weight: bold; font-size:17px; height:30px;padding-top:5px;">COTIZACION Nº</span>  
            </td>
        <tr>
             <td   style="border-right: 1px solid #000;border-bottom: 1px solid #000;text-align:center; ">

            <span style="text-align: center;font-size:15px; font-weight: bold;height:26.7px;">'.$oCotizacion->numero_concatenado.'</span>

            </td>
        </tr>
           
        </tr>
        <tr>
            
            <td style="border-right: 1px solid #000;border-bottom: 1px solid #000;">
              <span style="text-align: center;height:21.7px; font-size:12px;padding-top: 5px;"> Lima, '.$fecha.'</span>
            </td>
        </tr>


        </table>
    </td>
</tr>
<tr>
    <td>
        <span style="font-size:12px; padding-bottom:10px;">De nuestra consideración :</span>
        <span style="font-size:12px;">Por medio de la presente nos permitimos saludarlos y a la vez le hacemos llegar la siguiente cotización:</span>
    </td>
</tr>
<tr>
    <td style="height:490px; vertical-align: top;">
        <table width="700px" cellpadding=0 cellspacing=0 class="tablacontenido"   >
            <tr>
                <th width="40px" >Item</th>
                <th width="430px">Descripción</td>
                <th width="85px">Prec. Unit. '.$oMoneda->simbolo.'</th>
                <th width="60px">Cantidad</th>
                <th width="85px">Total '.$oMoneda->simbolo.'</th>
            </tr>';
$contar=count($dtCotizacion_Detalle);

if($contar>0){
    $contador=1;
    $cuerpoHTML='';
    foreach ($dtCotizacion_Detalle as $value) {
        if($oCotizacion->moneda_ID==1){
            $precio_unitario=$value['precio_venta_unitario_soles'];
            $precio_subtotal=$value['precio_venta_subtotal_soles'];
        }else if($oCotizacion->moneda_ID==2){
            $precio_unitario=$value['precio_venta_unitario_dolares'];
            $precio_subtotal=$value['precio_venta_subtotal_dolares'];
        }
        
        $oProducto=producto::getByID($value['producto_ID']);
   $cuerpoHTML.='<tr>
                <td width="40px" class="celda" style="border:none; border-left:1px solid #000;" >
                    <div class="celda1"> <span class="producto">'.$contador.'</span></div>
                </td>
                <td width="430px" class="celda" style="border:none; border-left:1px solid #000;">
                    <span class="producto" style="padding-bottom:5px;">'.$oProducto->nombre.'</span>';
                    if($value['descripcion']!=""){
                       $cuerpoHTML.='<span class="descripcion" style="font-style:normal;font-size:9px;padding-bottom:5px; color:#413F3F;">'.
                                    FormatTextViewHtml($value['descripcion']).'</span>'; 
                    }
                   
                        $dtCotizacion_Detalle_Hijo=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$value['ID']);
                        $contar_hijo=count($dtCotizacion_Detalle_Hijo);
                        if($contar_hijo>0){
                            $contador_hijo=1;
                            $cuerpoHTML.='<span style="padding-bottom:10px;"><table width="430px" cellpadding=0 cellspacing=0 style="font-size:10px; border:none;">';
                            foreach ($dtCotizacion_Detalle_Hijo as $item) {
                                $cuerpoHTML.='<tr>';
                                if($oCotizacion->moneda_ID==1){
                                    $precio_unitario_hijo=$item['precio_venta_unitario_soles'];
                                    $precio_subtotal_hijo=$item['precio_venta_subtotal_soles'];
                                }else if($oCotizacion->moneda_ID==2){
                                    $precio_unitario_hijo=$item['precio_venta_unitario_dolares'];
                                    $precio_subtotal_hijo=$item['precio_venta_subtotal_dolares'];
                                }
                                 $oProducto_Hijo=producto::getByID($item['producto_ID']);
                                 $cuerpoHTML.='<td width="20px" style="font-size:9px; border:none; vertical-align:top; text-align:center;  color:#413F3F;">'.$contador_hijo.'</td>';
                                 $cuerpoHTML.='<td width="340px" style="font-size:9px; border:none; vertical-align:top; text-align:justify; color:#413F3F;">'.$oProducto_Hijo->nombre.'</td>';
                                 $cuerpoHTML.='<td width="20px" style="font-size:9px; border:none; vertical-align:top; text-align:right; color:#413F3F;">'.$item['cantidad'].'</td>';
                                 $cuerpoHTML.='<td width="50px" style="font-size:9px; border:none; vertical-align:top;text-align:right; color:#413F3F;">'.$oMoneda->simbolo.' '.$precio_subtotal_hijo.'</td>';
                                 $cuerpoHTML.='</tr>';
                            $contador_hijo=$contador_hijo+1;
                            }
                            $cuerpoHTML.='</table></span>';
                        }
                    
   
     
  $cuerpoHTML.='</td>
                <td width="85px" class="celda" style="border:none; border-left:1px solid #000;">
                    <span class="producto" style="text-align:right; padding-right:4px;">'.$precio_unitario.'</span>
                </td>
                <td width="60px" class="celda" style="border:none; border-left:1px solid #000;">
                    <span class="producto" style="text-align:center;">'.$value['cantidad'].'</span>
                </td>
                <td width="85px" class="celda" style="border:none; border-left:1px solid #000;border-right:1px solid #000;">
                    <span class="producto" style="text-align:right;padding-right:4px;">'.$precio_subtotal.'</span>
                </td>
                    
                </td>
            </tr>';
      $contador=$contador+1; 
      
    }
   //$cuerpoHTML.=$cuerpoHTML.'';
} else {
    $cuerpoHTML='<tr>
                <td width="40px" class="celda" style="height:100px;" >
                    <div class="celda1"> <span class="producto">1</span></div>
                </td>
                <td width="430px" class="celda">
                    
                    <span class="producto"></span>
                    <span class="descripcion">
                        
                    </span>
                </td>
                <td width="85px" class="celda">
                    <span class="producto" style="text-align:right; padding-right:4px;"></span>
                </td>
                <td width="60px" class="celda">
                    <span class="producto">1</span>
                </td>
                <td width="85px" class="celda">
                    <span class="producto" style="text-align:right;padding-right:4px;"></span>
                </td>
                    
                </td>
            </tr>';
}

   $pieHTML='<tr>
                <td colspan="2" rowspan="3" style="border-left: 1px solid #fff; border-bottom: 1px solid #fff;"></td>
                <td rowspan="3" style="height:60px; color:413F3F;">
                    <span style="color:413F3F;">Precio</span>
                    <span >Expresado en:</span> 
                    <span>'.$oMoneda->simbolo.'</span>
                </td>
                <td><span style="color:413F3F;">Sub-Total</span></td>
                <td><span style="text-align:right; padding-right:4px; color:413F3F;">'.$sub_total.'</span></td>
            </tr>
            <tr>
                <td><span>IGV.</span></td>
                <td><span style="text-align:right; padding-right:4px; color:413F3F;">'.$vigv.'</span></td>
            </tr>
            <tr>
                <td><span>Total</span></td>
                <td><span style="text-align:right; padding-right:4px; color:413F3F;">'.$precio_total.'</span></td>
            </tr>
        </table>


    </td>
</tr>
<tr>
    <td>
        <table width="700px" cellpadding=0 cellspacing=0 style="border:1px solid #000;" >
            <tr>
                <td style="background: #99d959; border-bottom:1px solid #000; font-weight:bold;" colspan="6" align="center"   >
                    <span >CONDICIONES GENERALES</span>
                </td>
            </tr>
            <tr>
                <td width="80px" ><span style="" class="condiciones">Lugar de entrega</span></td>
                <td width="260px"><span class="condiciones" style="height:10px;">'.($oCotizacion->lugar_entrega).'</span></td>
                <td width="100px"><span class="condiciones">Tiempo de entrega</span></td>
                <td width="80px"><span class="condiciones">'.$oCotizacion->plazo_entrega.'</span></td>
                <td width="80px"><span class="condiciones">Validez de oferta</span></td>
                <td width="100px"><span class="condiciones">'.$oCotizacion->validez_oferta.' días</span></td>
            </tr>
            <tr>
                <td><span class="condiciones">Forma de pago</span></td>
                <td colspan="5"><span class="condiciones">'.$oForma_Pago->nombre.'</span></td>
            </tr>
            <tr>
                <td><span class="condiciones">Garantía</span></td>
                <td  colspan="5"><span class="condiciones">'.$oCotizacion->garantia.'</span></td>

            </tr>
            <tr>
                <td ><span class="condiciones">Observaciones</span></td>
                <td colspan="5">
                    <span class="condiciones">'.$oCotizacion->observacion.'</span>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <table width="700px;" style="border-top:1px solid #000;" cellpadding=0 cellspacing=0>
                        <tr>
                            <td width="390px" style="padding-left:4px;">
                                <span class="presentacion" style="font-weight:bold;display:inline;">Banco: </span><span class="presentacion_contenido" style="font-size:10px; display:inline;">'.FormatTextViewHtml($oCotizacion->banco).'</span> 
                                <span class="presentacion" style="font-weight:bold;">Cta. Cte. N°: <span class="presentacion_contenido" style="width: 150px;"> '.$oCotizacion->numero_cuenta.'</span> CI: <span class="presentacion_contenido">'.$oCotizacion->cuenta_interbancaria.'</span></span> 
                                <span class="presentacion" style="font-weight: normal;" >Sin otro en particular y en espera de su pronta comunicación, nos despedimos de usted.</span> 
                            </td>
                            <td width="310px" rowspan="2" align="center" style="border-left:1px solid #000;">
                               <span class="presentacion" style="font-weight:bold; font-family:arial; font-style: italic; font-size:12px;">'.$oOperador->nombre.' '.$oOperador->apellidos_paternos.'</span> 
                                <span class="presentacion" style="font-weight:bold; font-size:11px;">'.$oCargo->nombre.'</span> 
                                <span style="font-size:10px;display:inline;"><b>Central: </b></span> <span style="font-size:10px;display:inline; padding-right:10px;">'.$oDatos_Generales->telefono.'</span> <span style="font-size:10px;display:inline;"><b>Anexo: </b> </span><span style="font-size:10px;display:inline;">'.$oOperador->anexo.'</span> <br>
                                <span style="font-size:10px;display:inline;"><b>rpc: </b></span><span style="font-size:10px;display:inline;padding-right:10px;">'.$oOperador->rpc.'</span><span style="font-size:10px;display:inline;"><b>Rpm: </b></span><span style="font-size:10px;display:inline;padding-right:10px;">'.$oOperador->rpm.'</span><span style="font-size:10px;display:inline;"><b>Nextel: </b></span><span style="font-size:10px;display:inline;padding-right:10px;">'.$oOperador->nextel.'</span><br>
                                <span style="font-size:10px;display:inline;"><b>e-mail:  </b></span><span style="font-size:10px;display:inline;">'.$oOperador->mail.'</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top:1px solid #000; height:40px; padding-left:10px;">
                                <img  src="imagen/logo_parne.jpg" width="300" ></img>
                            </td>
                            
                        </tr>
                    </table>
                </td>
            </tr>
    </table>
    </td>
</tr>
</table>
</div>
</div>
</body>
</html>
';
$codigoHTML=$cabeceraHTML.$cuerpoHTML.$pieHTML;

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("cotizacion_$oCotizacion->numero.pdf");


?>