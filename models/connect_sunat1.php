<?php
require_once('././lib/soap/nusoap.php');
class WSSoapClient1 extends \SoapClient
{
    /**
     * WS-Security Username
     * @var string
     */
    //private $username;
    /**
     * WS-Security Password
     * @var string
     */
    //private $password;
    /**
     * Set WS-Security credentials
     *
     * @param string $username
     * @param string $password
     */
    /*public function __setUsernameToken($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
    /** 
     * Overwrites the original method adding the security header. As you can
     * see, if you want to add more headers, the method needs to be modified.
     */
    /*public function __soapCall($function_name, $arguments, $options=null, $input_headers=null, &$output_headers=null)
    {
        return parent::__soapCall($function_name, $arguments, $options, $this->generateWSSecurityHeader());
    }
    /**
     * Generate password digest
     *
     * Using the password directly may work also, but it's not secure to
     * transmit it without encryption. And anyway, at least with
     * axis+wss4j, the nonce and timestamp are mandatory anyway.
     *
     * @return string   base64 encoded password digest
     */
    private function generatePasswordDigest()
    {
        // Can use rand() to repeat the word if the server is under high load
        $this->nonce = mt_rand();
        $this->timestamp = gmdate('Y-m-d\TH:i:s\Z');
        $packedNonce = pack('H*', $this->nonce);
        $packedTimestamp = pack('a*', $this->timestamp);
        $packedPassword = pack('a*', $this->password);
        $hash = sha1($packedNonce . $packedTimestamp . $packedPassword);
        $packedHash = pack('H*', $hash);
        return base64_encode($packedHash);
    }
    /**
     * Generates WS-Security headers
     *
     * @return \SoapHeader
     */
    private function generateWSSecurityHeader()
    {
        //$passwordDigest = $this->generatePasswordDigest();
        $xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
    <soapenv:Header>            
        <wsse:Security SOAP-ENV:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken>
                <wsse:Username>10474911085MODDATOS</wsse:Username>
                <wsse:Password >MODDATOS</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
    </soapenv:Header>
    <soapenv:Body>
        <ser:sendBill> 
            <fileName>20100066603-01-F001-1.zip</fileName> 
            <contentFile>cid:20100066603-01-F001-1.zip</contentFile> 
        </ser:sendBill> 
    </soapenv:Body> 
</soapenv:Envelope>
';
        return new \SoapHeader('https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl',
            'Security',
            new \SoapVar($xml, SOAP_ENC_OBJECT), 
            true
        );
    }
}

?>