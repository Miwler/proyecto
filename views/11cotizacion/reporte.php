
<?php 
require_once 'dompdf/dompdf_config.inc.php';
 require ROOT_PATH . 'models/detalle_guia_venta.php';
 require ROOT_PATH . 'models/vehiculo.php';
 require ROOT_PATH . 'models/guia.php';
 require ROOT_PATH . 'models/representantecliente.php';
  require ROOT_PATH . 'models/cliente.php';
 
 $guia=$_GET["idguia"];
 $dtGv = detalle_guia_venta::getGrid($guia);
 $oGuia = guia::getByID($guia);
 $oVehiculo = vehiculo::getByID($oGuia->vehiculo);
$oRc = representantecliente::getByID($oGuia->rep_cliente);
$ocliente = cliente::getByID($oRc->cliente);
 
$codigoHTML='<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=divece-width, initial-scale=1">

    </head>
    <body >
        <!--        primera columna de tablas-->

            <table  style="height: 150px;margin-bottom: 10px;margin-top: 20px;height: 150px;">
            <tr>
                <td style="width:350px;text-align:center;">
                    <div  style="width:100%;">
                        <img src="include/img/logo.JPG" alt="" style="height: 150px;"/>
                    </div>
                </td>
                <td style="width:350px;text-align:center;">
                 <div  style="width:100%;">
                    <table  style="width:100%;">
                        <tr>

                             <td>
                                R.U.C : 
                            </td>								
                        </tr>
                        <tr>
                            <td >
                                GUIA DE REMISION REMITENTE
                            </td>
                        </tr>
                        <tr>
                            <td >
                                 001-NRO 004733
                            </td>
                        </tr>
                    </table>
                    </div>
                </td>
                </tr>
            </table>

        <!--       fin primera columna de tablas-->

        <!--       inicio segunda columna de tablas 100%-->
        <div style="margin-left: 20px;margin-right: 20px;margin-bottom: 5px;font-size: 10px;">
            <table  style="width:100%;">
                <tr style="border: 1px solid;">
                    <td style="text-align: right;" rowspan="2">FECHA DE EMISION:</td>
                    <td style="text-align: left;" rowspan="2">  '.$oGuia->fecha.' </td>
                    <td style="text-align: right;" rowspan="2">FECHA DE INICIO DEL TRASLADO:</td>											
                    <td style="text-align: left;" rowspan="2">__/__/____   </td>
                    <td style="text-align: right;" rowspan="2">CONTACTO:</td>
                    <td style="text-align: left;" rowspan="2">JUAN PEDRO SANCHES ROJAS</td>
                    <td style="text-align: right;">ORDEN DE PEDIDO NRO :</td>
                    <td style="text-align: left;">        </td>
                </tr>
                <tr style="border: 1px solid;">

                    <td style="text-align: right;">ORDEN DE COMPRA NRO :</td>
                    <td style="text-align: left;">         </td>
                </tr>
            </table>
        </div>
        <!--       fin segunda columna de tablas 100%-->
        <!--        tercera columna de tablas-->

         <table  style="height: 40px;margin-bottom: 10px;margin-top: 20px;">
          <tr>
             <td style="width:350px;text-align:center;">
            <table  style="width:100%;border:1px solid;">
                <tr>
                    <th style="background: green;">
                        DOMICILIO DE PARTIDA
                    </th>								
                </tr>
                <tr>
                    <td style="font-size: 11px;">sexto dato</td>
                </tr>
            </table>
            </td>
            <td style="width:350px;text-align:center;">
            <table  style="width:100%;border:1px solid;">
                <tr>
                    <th style="background: green" >
                        DOMICILIO DE LLEGADA
                    </th>								
                </tr>
                <tr >
                    <td style="font-size: 11px;">sexto dato</td>
                </tr>
            </table>
            </td>
             </tr>
        </table>
        <!--       fin tercera columna de tablas-->
        <!--       inicio cuarta columna de tablas-->
        <table  style="margin-bottom: 10px;margin-top: 20px;height: 80px;">
        <tr >
        <td style="width:350px;text-align:center;">
            <table  style="width:100%;border:1px solid;">
                <tr>
                    <th style="background: green;">
                        DESTINATARIO
                    </th>								
                </tr>
                <tr >
                    <td style="font-size: 10px;">NOMBRES/RAZON SOCIAL: '.$ocliente->nombre.' </td>
                </tr>
                <tr style="font-size: 11px;">
                    <td>R.U.C:   '.$ocliente->ruc.'</td>
                </tr>

            </table>
            </td>
            <td style="width:350px;text-align:center;">
            <table  style="width:100%;border:1px solid;">
                <tr>
                    <th style="background: green;" >
                        DATOS DEL TRANSPORTE/CONDUCTOR
                    </th>								
                </tr>
                <tr >
                    <td style="font-size: 11px;">VEHICULO MARCA Y PLACA NRO:   '.$oVehiculo->placa."   ".$oVehiculo->descripcion.'</td>
                </tr>
                <tr >
                    <td style="font-size: 11px;">CERTIFICADO DE INSCRIPCION NRO: -----------</td>
                </tr>
                <tr >
                    <td style="font-size: 11px;">LICENCIA DE CONDUCIR NRO: --------------</td>
                </tr>
            </table>
            </td>
            </tr>
        </table>
        <!--     fin   cuarta columna de tablas-->
        
<!--       inicio quinta columna de tablas-->
 <div style="margin-right: 20px;margin-bottom: 5px;">
        <table  style="width:100%;border-spacing:0" border="0.1" >
        <tr style="background: green;">
            <th style="width:100px;">CANTIDAD</th>
            <th>DESCRIPCION</th>
            <th style="width:100px;">U.MEDIDA</th>
            <th style="width:100px;">PESO TOTAL</th>
        </tr>
         ';
        foreach ( $dtGv as $Detalle) {
$codigoHTML.='
      <tr>
        <td>'.$Detalle['cantidad'].'</td>
        <td>'.$Detalle['descripcion'].'</td>
        <td>'.$Detalle['precio_venta_unitario'].'</td>
        <td>'.$Detalle['precio_venta'].'</td>
      </tr>';
      } 
$codigoHTML.='
        </table>
        </div>
        <!--     fin   cuarta columna de tablas-->
    </body>
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();

$dompdf->stream("Repore.pdf");
?>