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
        require ROOT_PATH . 'models/unidad_medida.php';
        require ROOT_PATH . 'models/numero_cuenta.php';
        require ROOT_PATH . 'models/cotizacion_numero_cuenta.php';
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
        $fecha=fechaATexto(FormatTextToDate($oCotizacion->fecha, 'd/m/Y'));
        $dtCotizacion_Numero_Cuenta=cotizacion_numero_cuenta::getGrid('cotizacion_ID='.$cotizacion_ID);
        $htmlNumero_Cuenta='<table cellspacin="0" cellpadding="0" class="tabNumero_Cuenta" style="width:450px;" ><tr><th style="width:150px;">Banco</th><th style="width:120px;">Cta. Cte. N°</th><th style="width:120px;">CCI</th></tr>';
        foreach($dtCotizacion_Numero_Cuenta as $valores){
            $oNumero_Cuenta=numero_cuenta::getByID($valores['numero_cuenta_ID']);
            $htmlNumero_Cuenta.='<tr>';
            $htmlNumero_Cuenta.='<td>'.FormatTextViewHtml($oNumero_Cuenta->nombre_banco).'</td>';
            $htmlNumero_Cuenta.='<td>'.$oNumero_Cuenta->numero.'</td>';
            $htmlNumero_Cuenta.='<td>'.$oNumero_Cuenta->cci.'</td>';
            $htmlNumero_Cuenta.='</tr>';
        }
        $htmlNumero_Cuenta.='</table>';
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
        if($oCotizacion->moneda_ID==1){
            $sub_total=$oCotizacion->precio_venta_neto_soles;
            $vigv=$oCotizacion->vigv_soles;
            $precio_total=$oCotizacion->precio_venta_total_soles;
        }else if($oCotizacion->moneda_ID==2){
            $sub_total=$oCotizacion->precio_venta_neto_dolares;
            $vigv=$oCotizacion->vigv_dolares;
            $precio_total=$oCotizacion->precio_venta_total_dolares;
        }
        $alto_Total=1210;
  //  $ocliente = cliente::getByID($aCotizacion->cliente);	
//$codigoHTML
$cabeceraHTML='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cotizacion PDF</title>
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
            font-size:7px;
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
           text-align:center;
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
        .tabNumero_Cuenta{
        border:none;
        width:385px;
        }
        .tabNumero_Cuenta th{
        font-family:arial;
         border:none;
         font-size:10px;
         font-weight: bold;
        }
        .tabNumero_Cuenta td{
        font-family:"calibri";
         border:none;
         font-size:10px;
        }
    </style>
    <div>
<div>
    <table>
<tr>
    <td>
        <table width="700px" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="275px" style="vertical-align: bottom;"><img  src="imagen/logo_cotizacion.jpg" width="240" ></img></td>
                <td width="255px" style="vertical-align: bottom;"><span  style="font-size:18px; font-weight:bold; text-align:left;display:inline-block;font-family: calibri">RUC: '.$oDatos_Generales->ruc .'</span></td>
                <td width="170px" style="vertical-align: bottom;">
                  <span align="center" style="font-size:18px; font-weight: bold;text-align:center;">'.$oDatos_Generales->telefono .'</span>
                  <span align="center" style="font-size:15px; color:#556B2F;text-align:center;">Central Telefónica</span>
                  <span align="center" style="font-size:12px; font-weight: bold;text-align:center;">Email : '.$oDatos_Generales->mail_info.'</span>
                  <span align="center" style="font-size:12px; font-weight: bold;text-align:center;">'.FormatTextViewHtml($oDatos_Generales->direccion).'</span>
                  
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
                        <span style="font-weight: bold;font-size:14px;padding-left: 4px;display: inline-block; width:75px;"> Atención: </span> <span style="display: inline-block;width:435px; font-size:14px; font-family:calibri;">'.$oRepresentanteCliente->nombres.' '.$oRepresentanteCliente->apellidos.'</span>

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
</table>
</div>';
$cuerpoHTML='
<div>

    <table width="700px" cellpadding=0 cellspacing=0 class="tablacontenido"   >
        <tr>
            <th width="40px" >Item</th>
            <th width="430px">Descripción</th>
            <th width="85px">Prec. Unit. '.$oMoneda->simbolo.'</th>
            <th width="60px">Cantidad</th>
            <th width="85px">Total '.$oMoneda->simbolo.'</th>
        </tr>';


$contar=count($dtCotizacion_Detalle);

if($contar>0){
    $contador=1;
    
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
                    <div class="celda1"> <span class="producto" style="text-alig:center;">'.$contador.'</span></div>
                </td>
                <td width="430px" class="celda" style="border:none; border-left:1px solid #000;">
                    <span class="producto" style="padding-bottom:5px; text-align:left;">'.FormatTextViewHtml($oProducto->nombre).'</span>';
                    if(strlen(trim($value['descripcion']))>1){
                       $cuerpoHTML.='<span class="descripcion" style="padding:0 4px 5px 4px;width:410px;font-style:normal;font-size:9px; color:#413F3F;text-align: justify;">'.
                        FormatTextViewHtml($value['descripcion']).'</span>'; 
                    }
                   
                        $dtCotizacion_Detalle_Hijo=cotizacion_detalle::getGrid('cotizacion_detalle_ID='.$value['ID']);
                        $contar_hijo=count($dtCotizacion_Detalle_Hijo);
                        if($contar_hijo>0){
                            $contador_hijo=1;
                            $cuerpoHTML.='<span style="padding-bottom:10px;"><table width="410px" cellpadding=0 cellspacing=0 style="font-size:10px; border:none;">';
                            foreach ($dtCotizacion_Detalle_Hijo as $item) {
                                $cuerpoHTML.='<tr>';
                                if($oCotizacion->moneda_ID==1){
                                    $precio_unitario_hijo=$item['precio_venta_unitario_soles'];
                                    $precio_subtotal_hijo=$item['precio_venta_subtotal_soles'];
                                }else if($oCotizacion->moneda_ID==2){
                                    $precio_unitario_hijo=$item['precio_venta_unitario_dolares'];
                                    $precio_subtotal_hijo=$item['precio_venta_subtotal_dolares'];
                                }
								$valor="";
								if($item['ver_precio']!=0){
									$valor=$oMoneda->simbolo.' '.$precio_subtotal_hijo;
								}
                                                                
                                 $oProducto_Hijo=producto::getByID($item['producto_ID']);
                                  $oUnidad_Medida=unidad_medida::getByID($oProducto_Hijo->unidad_medida_ID); 
                                 //$cuerpoHTML.='<td width="20px" style="font-size:9px; border:none; vertical-align:top; text-align:center;  color:#413F3F;font-weight: normal;">'.$contador_hijo.'</td>';
                                  $cuerpoHTML.='<td width="20px" style="font-size:9px; border:none; vertical-align:top; text-align:left; color:#413F3F;font-weight: normal;">'.$item['cantidad'].'</td>';
                                 $cuerpoHTML.='<td width="25px" style="font-size:9px; border:none; vertical-align:top; text-align:left; color:#413F3F;font-weight: normal;">'.$oUnidad_Medida->nombre.'</td>';
                                 $cuerpoHTML.='<td width="315px" style="font-size:9px; border:none; vertical-align:top; text-align:justify; color:#413F3F;font-weight: normal;">'.FormatTextViewHtml($oProducto_Hijo->nombre);
								 if(strlen(trim($item['descripcion']))>1){
									 $cuerpoHTML.='<span style="font-size:9px;font-weight:normal;">'.FormatTextViewHtml($item['descripcion']).'</span>';
								 }
								 $cuerpoHTML.='';
								 $cuerpoHTML.='</td>';
                                                               
                                 
                                 $cuerpoHTML.='<td width="50px" style="font-size:9px; border:none; vertical-align:top;text-align:right; color:#413F3F;font-weight: normal;">'.$valor.'</td>';
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
 
}
 $cuerpoHTML.=' <tr>
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
        </tr>';
$cuerpoHTML.='<table> </div>';

   $pieHTML='<div style="height:151px;">
       <div style="position:fixed; bottom:151px;">
 
        <table width="700px" cellpadding=0 cellspacing=0 style="border:1px solid #000;" >
            <tr>
                <td  colspan="6" style="background: #99d959; border-bottom:1px solid #000; font-weight:bold;"  align="center"   >
                    <span >CONDICIONES GENERALES</span>
                </td>
            </tr>
            <tr>
                <td width="80px" style="border:none;" ><span class="condiciones" style="font-size:9px;" >Lugar de entrega</span></td>
                <td width="260px" style="border:none;"><span class="condiciones" style="font-size:9px;font-weight: normal;">'.($oCotizacion->lugar_entrega).'</span></td>
                <td width="100px" style="border:none;"><span class="condiciones" style="font-size:9px;" >Tiempo de entrega</span></td>
                <td width="80px" style="border:none;"><span class="condiciones" style="font-size:9px;font-weight: normal;">'.$oCotizacion->plazo_entrega.'&nbsp;d&iacute;as</span></td>
                <td width="80px" style="border:none;"><span class="condiciones" style="font-size:9px;" >Validez de oferta</span></td>
                <td width="100px" style="border:none;"><span class="condiciones" style="font-size:9px;font-weight: normal;">'.$oCotizacion->validez_oferta.' días</span></td>
            </tr>
            <tr>
                <td style="border:none;"><span class="condiciones" style="font-size:9px;" >Forma de pago</span></td>
                <td colspan="5" style="border:none;"><span class="condiciones" style="font-size:9px;" >'.$oForma_Pago->nombre.'</span></td>
            </tr>
            <tr>
                <td style="border:none;"><span class="condiciones" style="font-size:9px;" >Garantía</span></td>
                <td style="border:none;" colspan="5"><span class="condiciones" style="font-size:9px;" >'.FormatTextViewHtml($oCotizacion->garantia).'</span></td>

            </tr>
            <tr>
                <td style="border:none;"><span class="condiciones" style="font-size:9px;" >Observaciones</span></td>
                <td style="border:none;" colspan="5">
                    <span style="font-size:10px;font-weight: normal;" class="condiciones"  >'.FormatTextViewHtml($oCotizacion->observacion).'</span>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <table width="700px;" style="border:none;" cellpadding=0 cellspacing=0>
                        <tr>
                            <td width="450px" style="padding-left:4px;border-right:1px solid #000;border-top:none;" >'.
                               $htmlNumero_Cuenta
                                .'<span class="presentacion" style="font-weight: normal;font-size:10px;" >Sin otro en particular y en espera de su pronta comunicación, nos despedimos de usted.</span> 
                            </td>
                            <td width="250px" rowspan="2" align="center" style="border:none;">
                               <span class="presentacion" style="font-weight:bold; font-family:arial; font-style: italic; font-size:12px;">'.$oOperador->nombres.' '.$oOperador->apellido_paterno.'</span> 
                                <span class="presentacion" style="font-weight:bold; font-size:11px;">'.FormatTextViewHtml($oCargo->nombre).'</span> 
                                <span style="font-size:10px;display:inline;"><b>Central: </b></span> <span style="font-size:10px;display:inline; padding-right:10px;">'.$oDatos_Generales->telefono.'</span> <span style="font-size:10px;display:inline;"><b>Anexo: </b> </span><span style="font-size:10px;display:inline;">'.$oOperador->anexo.'</span> <br>
                                <span style="font-size:10px;display:inline;"><b>Celular: </b></span><span style="font-size:10px;display:inline;padding-right:10px;">'.$oOperador->rpc.'</span><br>
                                <span style="font-size:10px;display:inline;"><b>e-mail:  </b></span><span style="font-size:10px;display:inline;">'.$oOperador->mail.'</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top:1px solid #000; border-bottom:none; height:40px; padding-left:10px;">
                                <img  src="imagen/logo1.png" style="height:30px;"></img>
                                <img  src="imagen/logo2.png" style="height:30px;" ></img>&nbsp;&nbsp;
                                <img  src="imagen/logo3.jpg" style="height:30px;" ></img>&nbsp;&nbsp;
                                <img  src="imagen/logo4.jpg" style="height:30px;" ></img>&nbsp;&nbsp;
                                <img  src="imagen/logo5.png" style="height:30px;" ></img>
                            </td>
                            
                        </tr>
                    </table>
                </td>
            </tr>
    </table>
    </div>
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
$dompdf->stream("$oCliente->razon_social-Cotizacion Nro $cotizacion_$oCotizacion->numero.pdf");


?>