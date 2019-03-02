<?php
require ROOT_PATH.'include/facturacion_electronica/formatos_xml/formatos_xml.php';
require ROOT_PATH.'include/xmlseclibs-master/xmlseclibs.php';
   
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;
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
class transaccion_documentos
{
    private $username;
    private $password;
    private $certificado;
    private $password_certificado;
    private $nombre_archivo_zip;
    private $ruta_archivo_zip;
    private $ruta_descargar_zip;
    private $array_documento;
    private $documento;
    private $nombre_documento;
    private $cdr_sunat;
    private $descripcion_estado;
    private $codigo_estado;
    private $fecha_resultado;
    private $codigo_hash;
    private $observacion;
    private $error;
    
    
        public function __set($var, $valor) {
// convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el dias es la cadena en "$temporal"		
        if (property_exists('transaccion_documentos', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('transaccion_documentos', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }
    
    function excribir_archivo_xml($NombreArchivo,$TramaXmlFirmado,$carpeta)

    {
        
        $OUTPUT = ROOT_PATH.ruta_archivo."/SUNAT/XML/".$_SESSION['empresa_ID']."/".$carpeta."/".$NombreArchivo;
        $bin = base64_decode($TramaXmlFirmado);
        file_put_contents($OUTPUT, $bin);
    }

    function escribir_archivo_cdr($NombreArchivo,$TramaXmlFirmado,$carpeta)
    {

      $OUTPUT =  ROOT_PATH.ruta_archivo."/SUNAT/CDR/".$_SESSION['empresa_ID']."/".$carpeta."/".$NombreArchivo;
      $bin = base64_decode($TramaXmlFirmado);
      //$bin = ($TramaXmlFirmado);
      file_put_contents($OUTPUT, $bin);
    }
   
    function firmar_documento($xmlFile,$documento){
        $ReferenceNodeName = 'ExtensionContent';
        $ruta="";
        try{
            $array=$this->getParamEmisor($_SESSION['empresa_ID']);
            if (openssl_pkcs12_read(file_get_contents($array['RutaCertificado']), $certs, $array['PasswordCertificado'])) {
                $publicKey = $certs['cert'];
                $privateKey = openssl_pkey_get_private($certs['pkey']);
            }
            $domDocument = new DOMDocument();
            $domDocument->load($xmlFile);
            //$xml=base64_decode($xmlFile);
            //echo $xml;
            //$domDocument=simplexml_load_string($xml);
            $objSign = new Xmlsecuritydsig();
            $objSign->setCanonicalMethod(XMLSecurityDSig::C14N);
            $objSign->addReference(
                    $domDocument,
                    XMLSecurityDSig::SHA1,
                    array('http://www.w3.org/2000/09/xmldsig#enveloped-signature'),
                    $options = array('force_uri' => true)
                    );

            $objKey = new Xmlsecuritykey(XMLSecurityKey::RSA_SHA1, array('type'=>'private'));

            $objKey->loadKey($privateKey);

            $objSign->sign($objKey, $domDocument->getElementsByTagName($ReferenceNodeName)->item(0));

            $objSign->add509Cert($publicKey);
            //$xmlName=$this->array_documento['Emisor']['NroDocumento'].'-'.$this->array_documento['TipoDocumento'].'-'.$this->array_documento['IdDocumento'];
            $xmlpath=ROOT_PATH.ruta_archivo."/SUNAT/XML/".$_SESSION['empresa_ID']."/".$documento."/";
            $ruta=$xmlpath.$this->nombre_documento.'.xml';                
            $domDocument->save($ruta);
           
        }catch(Exception $ex){
            log_error(__FILE__,"transaccion_documento.firmar_documento", $ex->getMessage());
            $rutaa="";
        }
         return $ruta;
        
    }
    function enviar_documento($ruta_xml,$documento,$metodo){
        try{
            $array=$this->getParamEmisor($_SESSION['empresa_ID']);
        $username=$array['RUC'].$array['UsuarioSol'];
        $password=$array['ClaveSol'];
        
        //Creamos el archivo zip
        $zip=new ZipArchive();
        $xmlpath=ROOT_PATH.ruta_archivo."/SUNAT/ZIP_ENVIADOS/".$_SESSION['empresa_ID']."/";
        
        $nombre_zip=$this->nombre_documento.".zip";
        $ruta_archivo_zip=$xmlpath.$nombre_zip;
        $xmlName=$this->nombre_documento.".xml";
        if($zip->open($ruta_archivo_zip,ZipArchive::CREATE)===TRUE){
            $zip->addFile($ruta_xml,$xmlName);
            $zip->close();
        }
        
        
        //=======================
        $wsse_header = new WsseAuthHeader($username, $password);
        $ws="";
        if($this->documento=="guia_venta"){
            if(conexion_ws_sunat=="beta"){
                $ws=beta_ws_guia;
            }else{
                $ws=produccion_ws_guia;
            }
            
        }else{
           if(conexion_ws_sunat=="beta"){
                $ws=beta_ws_factura;
            }else{
                $ws=produccion_ws_factura;
            } 
        }
        
        //print_r($wsse_header);
        //Producción
        //$x = new SoapClient('https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl', array("trace" => 1, "exception" => 0));
        //$x = new SoapClient($_SERVER['DOCUMENT_ROOT'].'\include\facturacion_electronica\xml_sunat\billService.wsdl', array("trace" => 1, "exception" => 0));
        
        //Desarrollo
        //$x = new SoapClient('https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl', array("trace" => 1, "exception" => 0));
        //Beta guia
        $x = new SoapClient('https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService?wsdl', array("trace" => 1, "exception" => 0));
        
        $x->__setSoapHeaders(array($wsse_header));
        $parametro=array();
        //echo $ruta_archivo_zip;
        $handle = fopen($ruta_archivo_zip, "rb");
        $contents = fread($handle, filesize($ruta_archivo_zip));
        //print_r($contents);
        fclose($handle);
        $parametros['fileName']=$nombre_zip;
        $parametros['contentFile']=$contents;
       
        switch(strtolower($metodo)){
            case "sendbill":
                
                 
                $array[]= $x->sendBill($parametros);
               //print_r($array);
                $ZIP_resultado=ROOT_PATH.ruta_archivo."/SUNAT/CDR/".$_SESSION['empresa_ID']."/".$documento."/".$nombre_zip;
                
                file_put_contents($ZIP_resultado, $array[0]->applicationResponse);
                //$ZIP_resultado=ROOT_PATH.ruta_archivo."/SUNAT/CDR/".$_SESSION['empresa_ID']."/".$documento."/R-20536781499-01-F001-0000001.zip";
                $string=file_get_contents($ZIP_resultado);
              
                $this->cdr_sunat= base64_encode($string);
                
                //Nuevo codigo
                $zip=zip_open($ZIP_resultado);
                if($zip){
                   
                    while ($zip_entry = zip_read($zip)){
                        $nombre_resultado=zip_entry_name($zip_entry);
                        $contenido = zip_entry_read($zip_entry,100000000);
                       
                        if($contenido!=""){
                            $string1 = <<< XML
$contenido
XML;
                            // echo $string1;
                            $sxe = new SimpleXMLElement($string1);
                             
                             
                            $ns = $sxe->getNamespaces(true);
                            $child = $sxe->children($ns['cbc']);
                            $fecha_respuesta=$child->ResponseDate.' '.$child->ResponseTime;
                            $this->fecha_resultado=$fecha_respuesta;
                            $array=array();
                            $array=$child->Note;
                            $observacion="";
                            for($i=0;$i<count($array);$i++){
                                $observacion.=$array[$i]."<br>";
                            }
                            $this->observacion=$observacion; 
                            
                            //echo $observacion;
                            
                            $Document = $sxe->children($ns['cac']);
                            $DocumentResponse=$Document->DocumentResponse;
                            $response=$DocumentResponse->children($ns['cac']);
                            $response1=$response->Response;
                            $res=$response1->children($ns['cbc']);
                            //var_dump($Document);
                            $descripcion_estado=$res->Description;
                            $codigo_estado=$res->ResponseCode;
                            $this->descripcion_estado=$descripcion_estado;
                            $this->codigo_estado=$codigo_estado;
                            
                            
                            $info=$sxe->children($ns['ext']);
                            $UBLExtensions=$info->UBLExtensions;
                            $info2=$UBLExtensions->children($ns['ext']);
                            $UBLExtension=$info2->UBLExtension;
                            $info3=$UBLExtension->children($ns['ext']);
                            $ExtensionContent=$info3->ExtensionContent;
                            $ExtensionContent1=$ExtensionContent->children();
                            $Signature=$ExtensionContent1->Signature->children();
                            $SignedInfo=$Signature->SignedInfo->children();
                            $Reference=$SignedInfo->Reference->children();
                            $this->codigo_hash=$Reference->DigestValue;
                        }

                    }
                }
                //
                break;
            case "sendsummary":
                $array[]= $x->sendSummary($parametros);
                print_r($array);
                $ticket=$array[0]->ticket;
                
                return $ticket;
                break;
            case "sendPack":
                
                 
                $array[]= $x->sendBill($parametros);
               //print_r($array[]);
                $ZIP_resultado=ROOT_PATH.ruta_archivo."/SUNAT/CDR/".$_SESSION['empresa_ID']."/".$documento."/".$nombre_zip;
                
                file_put_contents($ZIP_resultado, $array[0]->applicationResponse);
                //$ZIP_resultado=ROOT_PATH.ruta_archivo."/SUNAT/CDR/".$_SESSION['empresa_ID']."/".$documento."/R-20536781499-01-F001-0000001.zip";
                $string=file_get_contents($ZIP_resultado);
              
                $this->cdr_sunat= base64_encode($string);
                
                //Nuevo codigo
                $zip=zip_open($ZIP_resultado);
                if($zip){
                   
                    while ($zip_entry = zip_read($zip)){
                        $nombre_resultado=zip_entry_name($zip_entry);
                        $contenido = zip_entry_read($zip_entry,100000000);
                       
                        if($contenido!=""){
                            $string1 = <<< XML
$contenido
XML;
                            // echo $string1;
                            $sxe = new SimpleXMLElement($string1);
                             
                             
                            $ns = $sxe->getNamespaces(true);
                            $child = $sxe->children($ns['cbc']);
                            $fecha_respuesta=$child->ResponseDate.' '.$child->ResponseTime;
                            $this->fecha_resultado=$fecha_respuesta;
                            $array=array();
                            $array=$child->Note;
                            $observacion="";
                            for($i=0;$i<count($array);$i++){
                                $observacion.=$array[$i]."<br>";
                            }
                            $this->observacion=$observacion; 
                            
                            //echo $observacion;
                            
                            $Document = $sxe->children($ns['cac']);
                            $DocumentResponse=$Document->DocumentResponse;
                            $response=$DocumentResponse->children($ns['cac']);
                            $response1=$response->Response;
                            $res=$response1->children($ns['cbc']);
                            //var_dump($Document);
                            $descripcion_estado=$res->Description;
                            $codigo_estado=$res->ResponseCode;
                            $this->descripcion_estado=$descripcion_estado;
                            $this->codigo_estado=$codigo_estado;
                            
                            
                            $info=$sxe->children($ns['ext']);
                            $UBLExtensions=$info->UBLExtensions;
                            $info2=$UBLExtensions->children($ns['ext']);
                            $UBLExtension=$info2->UBLExtension;
                            $info3=$UBLExtension->children($ns['ext']);
                            $ExtensionContent=$info3->ExtensionContent;
                            $ExtensionContent1=$ExtensionContent->children();
                            $Signature=$ExtensionContent1->Signature->children();
                            $SignedInfo=$Signature->SignedInfo->children();
                            $Reference=$SignedInfo->Reference->children();
                            $this->codigo_hash=$Reference->DigestValue;
                        }

                    }
                }
                //
                break;
        }
        //$array[]= $x->sendBill($parametros);
        
        }catch(Exception $ex){
            log_error(__FILE__,"transaccion_documento.enviar_documento",$ex->getMessage());
        }
        
    }
    function enviar_documento_sunat($ruta_xml,$documento,$metodo){
        try{
            $array=$this->getParamEmisor($_SESSION['empresa_ID']);
            $username=$array['RUC'].$array['UsuarioSol'];
            $password=$array['ClaveSol'];
        
        //Creamos el archivo zip
        $zip=new ZipArchive();
        $xmlpath=ROOT_PATH.ruta_archivo."/SUNAT/ZIP_ENVIADOS/".$_SESSION['empresa_ID']."/";
        
        $nombre_zip=$this->nombre_documento.".zip";
        $ruta_archivo_zip=$xmlpath.$nombre_zip;
        $xmlName=$this->nombre_documento.".xml";
        if($zip->open($ruta_archivo_zip,ZipArchive::CREATE)===TRUE){
            $zip->addFile($ruta_xml,$xmlName);
            $zip->close();
        }
        $xml_post_string="";
        switch(strtolower($metodo)){
             case "sendbill":
                $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
                    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" 
                    xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                    <soapenv:Header>
                        <wsse:Security>
                            <wsse:UsernameToken>
                                <wsse:Username>'.$username.'</wsse:Username>
                                <wsse:Password>'.$password.'</wsse:Password>
                            </wsse:UsernameToken>
                        </wsse:Security>
                    </soapenv:Header>
                    <soapenv:Body>
                        <ser:sendBill>
                            <fileName>' . $nombre_zip. '</fileName>
                            <contentFile>' . base64_encode(file_get_contents($ruta_archivo_zip)) . '</contentFile>
                        </ser:sendBill>
                    </soapenv:Body>
                    </soapenv:Envelope>';
                 break;
        }
        if($xml_post_string==""){
            throw new Exception("No existe la cabecera");
        }
        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-length: " . strlen($xml_post_string),
        );
        $ws="";
         switch($this->documento){
            case "guia_venta":
                 if(conexion_ws_sunat=="beta"){
                        $ws=beta_ws_guia;
                    }else{
                        $ws=produccion_ws_guia;
                    }
                break;
            default:
                if(conexion_ws_sunat=="beta"){
                    $ws=beta_ws_factura;
                }else{
                    $ws=produccion_ws_factura;
                } 
                
         }
        
        if($ws==""){throw new Exception("No existe la ebs ervices");}
        $url = $ws;

        // PHP cURL  for https connection with auth
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //cambio
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // converting
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //print_r($response);
        curl_close($ch);
        if ($httpcode == 200) {
            $doc = new DOMDocument();
            $doc->loadXML($response);
            if (isset($doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue)) {
                switch(strtolower($metodo)){
                    case "sendbill":
                        $ZIP_resultado=ROOT_PATH.ruta_archivo."/SUNAT/CDR/".$_SESSION['empresa_ID']."/".$documento."/R-".$nombre_zip;
                        $xmlCDR = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue;
                        file_put_contents($ZIP_resultado, base64_decode($xmlCDR));
                        $string=file_get_contents($ZIP_resultado);
              
                            $this->cdr_sunat= base64_encode($string);

                            //Nuevo codigo
                            $zip=zip_open($ZIP_resultado);
                            if($zip){

                                while ($zip_entry = zip_read($zip)){
                                    $nombre_resultado=zip_entry_name($zip_entry);
                                    $contenido = zip_entry_read($zip_entry,100000000);

                                    if($contenido!=""){
$string1 = <<< XML
$contenido
XML;
                                        // echo $string1;
                                        $sxe = new SimpleXMLElement($string1);


                                        $ns = $sxe->getNamespaces(true);
                                        $child = $sxe->children($ns['cbc']);
                                        $fecha_respuesta=$child->ResponseDate.' '.$child->ResponseTime;
                                        $this->fecha_resultado=$fecha_respuesta;
                                        $array=array();
                                        $array=$child->Note;
                                        $observacion="";
                                        for($i=0;$i<count($array);$i++){
                                            $observacion.=$array[$i]."<br>";
                                        }
                                        $this->observacion=$observacion; 

                                        echo $observacion;

                                        $Document = $sxe->children($ns['cac']);
                                        $DocumentResponse=$Document->DocumentResponse;
                                        $response=$DocumentResponse->children($ns['cac']);
                                        $response1=$response->Response;
                                        $res=$response1->children($ns['cbc']);
                                        //var_dump($Document);
                                        $descripcion_estado=$res->Description;
                                        $codigo_estado=$res->ResponseCode;
                                        $this->descripcion_estado=$descripcion_estado;
                                        $this->codigo_estado=$codigo_estado;


                                        $info=$sxe->children($ns['ext']);
                                        $UBLExtensions=$info->UBLExtensions;
                                        $info2=$UBLExtensions->children($ns['ext']);
                                        $UBLExtension=$info2->UBLExtension;
                                        $info3=$UBLExtension->children($ns['ext']);
                                        $ExtensionContent=$info3->ExtensionContent;
                                        $ExtensionContent1=$ExtensionContent->children();
                                        $Signature=$ExtensionContent1->Signature->children();
                                        $SignedInfo=$Signature->SignedInfo->children();
                                        $Reference=$SignedInfo->Reference->children();
                                        $this->codigo_hash=$Reference->DigestValue;
                                    }

                                }
                            }
                        break;
                        case "sendsummary":
                            $array[]= $x->sendSummary($parametros);
                            print_r($array);
                            $ticket=$array[0]->ticket;

                            return $ticket;
                            break;
                        
                }
                
            }else{
                $this->error=1;
                $this->observacion=$doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
                $this->codigo_estado=$doc->getElementsByTagName('faultcode')->item(0)->nodeValue;
            }
        }else{
            $this->error="Código de Error: 0000 <br /> Web Service de Prueba SUNAT - Fuera de Servicio: <a href='https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService' target='_blank'>https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService</a>, Para validar la información llamar al: *4000 (Desde Claro, Entel y Movistar) - SUNAT";
            $this->observacion="";
        }
        
    
        
        }catch(Exception $ex){
            log_error(__FILE__,"transaccion_documento.enviar_documento",$ex->getMessage());
        }
    }
    function generar_xml(){
        $ruta="";
        try{
            switch($this->documento){
                case "factura_venta":
                    $factura=new formatosxml();
                    $xml=$factura->factura_venta_UBL2_1($this->array_documento);

                    $this->nombre_documento=$this->array_documento['Emisor']['NroDocumento'].'-'.$this->array_documento['TipoDocumento'].'-'.$this->array_documento['IdDocumento'];
                    $NombreArchivo=$this->nombre_documento.".xml";

                    $OUTPUT =  ROOT_PATH.ruta_archivo."/SUNAT/XML_SINFIRMAR/".$_SESSION['empresa_ID']."/".$NombreArchivo;
                    $xml->save($OUTPUT);
                    $ruta=$OUTPUT;
                    break;
                case "guia_venta":
                    $guia_venta=new formatosxml();
                    $xml=$guia_venta->guia_venta2_1($this->array_documento);
                    $this->nombre_documento=$this->array_documento['Remitente']['NroDocumento'].'-'.$this->array_documento['TipoDocumento'].'-'.$this->array_documento['IdDocumento'];
                    $NombreArchivo=$this->nombre_documento.".xml";
                    $OUTPUT =  ROOT_PATH.ruta_archivo."/SUNAT/XML_SINFIRMAR/".$_SESSION['empresa_ID']."/".$NombreArchivo;
                    $xml->save($OUTPUT);
                    $ruta=$OUTPUT;
                    break;
                case "nota_credito":
                    $nota_credito=new formatosxml();
                    $xml=$nota_credito->nota_credito_UBL2_1($this->array_documento);
                    $this->nombre_documento=$this->array_documento['Emisor']['NroDocumento'].'-'.$this->array_documento['TipoDocumento'].'-'.$this->array_documento['IdDocumento'];
                    $NombreArchivo=$this->nombre_documento.".xml";

                    $OUTPUT =  ROOT_PATH.ruta_archivo."/SUNAT/XML_SINFIRMAR/".$_SESSION['empresa_ID']."/".$NombreArchivo;
                    $xml->save($OUTPUT);
                    $ruta=$OUTPUT;
                    break;
                case "nota_debito":
                    $nota_debito=new formatosxml();
                    $xml=$nota_debito->nota_debito_UBL2_1($this->array_documento);
                    $this->nombre_documento=$this->array_documento['Emisor']['NroDocumento'].'-'.$this->array_documento['TipoDocumento'].'-'.$this->array_documento['IdDocumento'];
                    $NombreArchivo=$this->nombre_documento.".xml";

                    $OUTPUT =  ROOT_PATH.ruta_archivo."/SUNAT/XML_SINFIRMAR/".$_SESSION['empresa_ID']."/".$NombreArchivo;
                    $xml->save($OUTPUT);
                    $ruta=$OUTPUT;
                    break;
                case "comunicacion_baja":
                    $comunicacion_baja=new formatosxml();
                    $xml=$comunicacion_baja->comunicacion_baja_UBL2_0($this->array_documento);

                    $this->nombre_documento=$this->array_documento['Emisor']['NroDocumento'].'-'.$this->array_documento['IdDocumento'];
                    $NombreArchivo=$this->nombre_documento.".xml";

                    $OUTPUT =  ROOT_PATH.ruta_archivo."/SUNAT/XML_SINFIRMAR/".$_SESSION['empresa_ID']."/".$NombreArchivo;
                    $xml->save($OUTPUT);
                    $ruta=$OUTPUT;
                    break;
            }
        }catch(Exception $ex){
            log_error(__FILE__,"transaccion_documentos.generar_xml", $ex->getMessage());
            $ruta="";
        }
        
        return $ruta;
    }
    public function getParamEmisor($empresa_ID){
        if(!class_exists("datos_generales")){
            require ROOT_PATH.'models/datos_generales.php';
        }
        if(!class_exists("distrito")){
            require ROOT_PATH.'models/distrito.php';
        }
        if(!class_exists("provincia")){
            require ROOT_PATH.'models/provincia.php';
        }
        if(!class_exists("departamento")){
            require ROOT_PATH.'models/departamento.php';
        }
        
        /*if(!class_exists("configuracion")){
            require ROOT_PATH.'models/configuracion.php';
        }*/
        $oDatos_generales=datos_generales::getByID1($empresa_ID);
        //$configuracion=configuracion::getGrid();
        $oDistrito=distrito::getByID($oDatos_generales->distrito_ID);
        
        $certificateCAcer = ROOT_PATH.ruta_archivo.'/SUNAT/CERTIFICADO/'.$empresa_ID.'/'.$oDatos_generales->certificado;
        
        $certificateCAcerContent = file_get_contents($certificateCAcer);
        $certificadostring =  PHP_EOL.chunk_split(base64_encode($certificateCAcerContent), 64, PHP_EOL).PHP_EOL;
        
        $Emisor = array (
          'NroDocumento' =>$oDatos_generales->ruc,
          'TipoDocumento' => '6',//Antes 6
          'NombreLegal' => trim($oDatos_generales->razon_social),
          'NombreComercial' => trim($oDatos_generales->alias),
          'Ubigeo' => $oDistrito->codigo_ubigeo,
          'Direccion' => trim($oDatos_generales->direccion_fiscal),
          'Urbanizacion' => '',
          'Departamento' =>$oDistrito->departamento,
          'Provincia' =>$oDistrito->provincia,
          'Distrito' =>$oDistrito->nombre,
            'Pais'=>'PE'
        );

        $data = array( "RUC"=>$oDatos_generales->ruc,
                      "UsuarioSol"=>$oDatos_generales->usuariosol,
                      "ClaveSol"=>$oDatos_generales->clavesol,
                      "Certificado"=>$certificadostring,
                      "RutaCertificado"=>$certificateCAcer,
                      "PasswordCertificado"=>$oDatos_generales->passwordcertificado,
                      "TasaIgv"=>$oDatos_generales->vigv,
                      "TasaIsc"=>$oDatos_generales->visc,
                      "TasaDetraccion"=>$oDatos_generales->tasadetraccion,
                      "UrlSunat"=>"https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService",
                      "UrlOtroCpe"=>"https://e-beta.sunat.gob.pe/ol-ti-itemision-otroscpe-gem-beta/billService",
                      "UrlGuia"=>"https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService",
                      "Emisor"=>$Emisor
                    );
        return $data;

      }
}

?>
