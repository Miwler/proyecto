<?php
require_once('../lib/soap/nusoap.php');

function getData($sql){
    require_once ('../models/connect.php');
    $cn = new connect();
    $resultado=$cn->getData($sql);
    $retornar = Array('resultado' => $resultado);
    return json_encode($retornar, true);
}

function getGrid($sql){
    require_once ('../models/connect.php');
    $cn = new connect();
    $dt=$cn->getGrid($sql);
    $dt=utf8_converter($dt);
   
    return json_encode($dt);
}
function transa($sql){
    require_once ('../models/connect.php');
    try{
         $cn = new connect();

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
    "Ejecuta una sentencia.");
$server->register("transa",
    array("sql" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:services",
    "urn:services#transa",
    "rpc",
    "encoded",
    "Devuelve  registros."); 
if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
$server->service($HTTP_RAW_POST_DATA);


