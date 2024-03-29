<?php
require_once('../lib/soap/nusoap.php');

function getData($sql){
    require_once ('../models/connect_new.php');
    $cn = new connect_new();
    $resultado=$cn->getData($sql);
    $retornar = Array('resultado' => $resultado);
    return json_encode($retornar, true);
}
//Web service
function getGrid($sql){
    require_once ('../models/connect_new.php');
    $cn = new connect_new();
    $dt=$cn->getGrid($sql);
    $dt=utf8_converter($dt);
   
    return json_encode($dt);
}
function store_procedure_getGrid($array){
    require_once ('../models/connect_new.php');
    $cn = new connect_new();
    $argumentos=json_decode($array['pt_args'],true);
    /*$dt=$cn->store_procedure_getGrid($array['pv_proc'], array(
                'iempresa_ID'=>2,
                'itipo_comprobante_ID'=>1,
                'iserie'=>'F001',
                'inumero'=>'133',
                'imonto_total'=>94302.5,
            ));*/
    $dt=$cn->store_procedure_getGrid($array['pv_proc'], $argumentos);
    $dt=utf8_converter($dt);
   
    return json_encode($dt);
}
function transa($sql){
    require_once ('../models/connect_new.php');
    try{
         $cn = new connect_new();

         $resultado=$cn->transa($sql);;
         $mensaje="Se realizó correctamente";
    }catch(Exception $ex){
         $resultado=-1;
         $mensaje=$ex->getMessage();
    }
    $retornar = Array('resultado' => $resultado, 'mensaje' => $mensaje);
    return json_encode($retornar);
}
function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
            $item = utf8_encode($item);
        }
    });

    return $array;
}
      
$server = new soap_server();
$server->configureWSDL("services", "urn:services");
$server->soap_defencoding='utf-8';
$server->register("getData",
    array("sql" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:services",
    "urn:services#getData",
    "rpc",
    "encoded",
    "Extrae un solo valor.");

$server->register("getGrid",
    array("sql" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:services",
    "urn:services#getGrid",
    "rpc",
    "encoded",
    "Extrae una cadena de registros.");
$server->register("store_procedure_getGrid",
    array("pv_proc" => "xsd:string","pt_args" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:services",
    "urn:services#store_procedure_getGrid",
    "rpc",
    "encoded",
    "Extrae una cadena de registros.");
$server->register("transa",
    array("sql" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:services",
    "urn:services#transa",
    "rpc",
    "encoded",
    "Ejecuta una sentencia."); 
if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);


