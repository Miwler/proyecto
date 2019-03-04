
<?php

$ruta_archivo="20536781499-09-T001-16";
$archivo="20536781499-09-T001-16";
$ruta_archivo_cdr="C:\xampp\htdocs\proyecto\proyecto/";
$soapUrl = "https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService";
$zip = new ZipArchive();
        $filenameXMLCPE = $ruta_archivo . '.ZIP';

        if ($zip->open($filenameXMLCPE, ZIPARCHIVE::CREATE) === true) {
            $zip->addFile($ruta_archivo . '.XML', $archivo . '.XML'); //ORIGEN, DESTINO
            $zip->close();
        }

        //===================ENVIO FACTURACION=====================
        
        // xml post structure
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
        xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" 
        xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
        <soapenv:Header>
            <wsse:Security>
                <wsse:UsernameToken>
                    <wsse:Username>10474911085MODDATOS</wsse:Username>
                    <wsse:Password>MODDATOS</wsse:Password>
                </wsse:UsernameToken>
            </wsse:Security>
        </soapenv:Header>
        <soapenv:Body>
            <ser:sendBill>
                <fileName>' . $archivo . '.ZIP</fileName>
                <contentFile>' . base64_encode(file_get_contents($ruta_archivo . '.ZIP')) . '</contentFile>
            </ser:sendBill>
        </soapenv:Body>
        </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-length: " . strlen($xml_post_string),
        );

        $url = $soapUrl;

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
        curl_close($ch);
        print_r($response);
        if ($httpcode == 200) {
            $doc = new DOMDocument();
            $doc->loadXML($response);
            
            //===================VERIFICAMOS SI HA ENVIADO CORRECTAMENTE EL COMPROBANTE=====================
            if (isset($doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue)) {
                $xmlCDR = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue;
               
                file_put_contents('R-' . $archivo . '.ZIP', base64_decode($xmlCDR));

                //extraemos archivo zip a xml
                $zip = new ZipArchive;
                if ($zip->open('R-' . $archivo . '.ZIP') === TRUE) {
                    $zip->extractTo('R-' . $archivo . '.XML');
                    $zip->close();
                }

                //eliminamos los archivos Zipeados
                //unlink($ruta_archivo . '.ZIP');
                //unlink($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP');

                //=============hash CDR=================
                $doc_cdr = new DOMDocument();
                $doc_cdr->load('R-' . $archivo . '.XML');
                $resp['respuesta'] = 'ok';
                $resp['cod_sunat'] = $doc_cdr->getElementsByTagName('ResponseCode')->item(0)->nodeValue;
                $resp['mensaje'] = $doc_cdr->getElementsByTagName('Description')->item(0)->nodeValue;
                $resp['hash_cdr'] = $doc_cdr->getElementsByTagName('DigestValue')->item(0)->nodeValue;
            } else {
                $resp['respuesta'] = 'error';
                $resp['cod_sunat'] = $doc->getElementsByTagName('faultcode')->item(0)->nodeValue;
                $resp['mensaje'] = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
                $resp['hash_cdr'] = "";
            }
        } else {
            //echo "no responde web";
            $resp['respuesta'] = 'error';
            $resp['cod_sunat'] = "0000";
            $resp['mensaje'] = "Código de Error: 0000 <br /> Web Service de Prueba SUNAT - Fuera de Servicio: <a href='https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService' target='_blank'>https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService</a>, Para validar la información llamar al: *4000 (Desde Claro, Entel y Movistar) - SUNAT";
            $resp['hash_cdr'] = "$httpcode";
        }