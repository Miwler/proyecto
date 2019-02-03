
<?php

   require_once '/./models/WSSoapClient.php';
class WsseAuthHeader extends SoapHeader {

private $wss_ns = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

    function __construct($user, $pass, $ns = null) {
        if ($ns) {
            $this->wss_ns = $ns;
        }

        $auth = new stdClass();
        $auth->Username = new SoapVar($user, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns); 
        $auth->Password = new SoapVar($pass, XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns);

        $username_token = new stdClass();
        $username_token->UsernameToken = new SoapVar($auth, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns); 

        $security_sv = new SoapVar(
            new SoapVar($username_token, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns),
            SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'Security', $this->wss_ns);
        parent::__construct($this->wss_ns, 'Security', $security_sv, true);
    }
}



$username="20536781499JGONZALE";
$password="Lima1234";

$wsse_header = new WsseAuthHeader($username, $password);
//$x = new SoapClient('https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl', array("trace" => 1, "exception" => 0));
//$x = new SoapClient('https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService?wsdl', array("trace" => 1, "exception" => 0));
//var_dump($x);
//$x = new SoapClient('https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl', array("trace" => 1, "exception" => 0));
$x = new SoapClient($_SERVER['DOCUMENT_ROOT'].'\include\facturacion_electronica\xml_sunat\billService.wsdl', array("trace" => 1, "exception" => 0));
//$x = new SoapClient($_SERVER['DOCUMENT_ROOT'].'\include\facturacion_electronica\xml_sunat_guia_electronica\billService.wsdl', array("trace" => 1, "exception" => 0));

        
$x->__setSoapHeaders(array($wsse_header));
$parametro=array();

$handle = fopen("20536781499-01-F001-3.zip", "rb");
$contents = fread($handle, filesize("20536781499-01-F001-3.zip"));
fclose($handle);
$parametros['fileName']="20536781499-01-F001-3.zip";
$parametros['contentFile']=$contents;

//$array[]= $x->sendSummary($parametros);
$array[]= $x->sendBill($parametros);
print_r($array);
file_put_contents("R-20536781499-01-F001-3.zip", $array[0]->applicationResponse);
    
/*
require_once 'SOAP/Client.php';
//$wsdl = new SOAP_WSDL('https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl');
$WSHeader = '<wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
    <wsse:UsernameToken>
        <wsse:Username>20536781499Jjsoluci</wsse:Username>
        <wsse:Password>fiorella</wsse:Password>
    </wsse:UsernameToken>
</wsse:Security>';
$headers = new SoapHeader('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'Security', new SoapVar($WSHeader, XSD_ANYXML));
$soapclient = new SOAP_Client(__FILE__.'xml_sunat\billService.wsdl');





header('Content-Type: text/plain');

$handle = fopen("20536781499-01-F001-0000001.zip", "rb");
$contents = fread($handle, filesize("20536781499-01-F001-0000001.zip"));
fclose($handle);
$parametros['fileName']="20536781499-01-F001-0000001.zip";
$parametros['contentFile']=$contents;
$array[]=$soapclient->__soapCall('sendBill', array($parametros), null, $headers);

print_r($array[0]);
file_put_contents("R-20536781499-01-F001-0000001.zip", $array[0]->sendBillResponse);
*/
