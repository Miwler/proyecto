
<?php

    /*$cliente = new nusoap_client("http://localhost:8081/webservices/services.php?wsdl");
    
    $error = $cliente->getError();
    /*if ($error) {
        echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
    }*/
      
   /* $result = $cliente->call("transa", array("sql" => 'insert into mensaje(ID,empresa_ID,remitente_ID,nombre,email,asunto,mensaje,archivo,email_destinatario,email_amigo,nombre_amigo,usuario_id)values(145,2,"-1","pde","mi@de.ed","de","ded","","","","",-1);'));
   
    $result=  json_decode($result);
     echo $result->mensaje;
     */
    //require_once '/./models/WSSoapClient.php';
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


$username="20536781499mquito88";
$password="Lima1234";

$wsse_header = new WsseAuthHeader($username, $password);
//$x = new SoapClient('https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl', array("trace" => 1, "exception" => 0));
//$x = new SoapClient('https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService?wsdl', array("trace" => 1, "exception" => 0));
$x = new SoapClient('https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl', array("trace" => 1, "exception" => 0));
$x->__setSoapHeaders(array($wsse_header));
$parametro=array();

$handle = fopen("20536781499-01-F001-0000001.zip", "rb");
$contents = fread($handle, filesize("20536781499-01-F001-0000001.zip"));
fclose($handle);
$parametros['fileName']="20536781499-01-F001-0000001.zip";
$parametros['contentFile']=$contents;
$array[]= $x->sendBill($parametros);
print_r($array);
file_put_contents("R-20536781499-01-F001-0000001.zip", $array[0]->applicationResponse);
        
