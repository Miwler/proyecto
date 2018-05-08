<?php

class api_SUNAT {

    public function sendPostCPE($data,$metodo) {

        $headers = array(
            "Content-Type: application/json; charset=UTF-8",
            "Cache-Control: no-cache",
            "Pragma: no-cache"
        );
        $ch = curl_init("http://192.168.10.151:8085/api/".$metodo);
        //$ch = curl_init("http://192.168.0.15/OpenInvoicePeru/api/".$metodo);
        //$ch = curl_init("http://192.168.43.242/OpenInvoicePeru/api/".$metodo);
        //$ch = curl_init("http://localhost:5649/OpenInvoicePeru/api/".$metodo);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($ch, CURLOPT_USERPWD, "PRUEBA:LOG");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Se cierra el recurso CURL y se liberan los recursos del sistema
        curl_close($ch);

        //echo "RESULT: $response\n";

        if( $http_status != 200 )
        {
          $json = json_decode($response);
          echo $json;
          $response =  json_encode(array('Exito' => false, 'MensajeError' => $json->Message,'Pila'=>''));
        }
        else {
            $response = $response;
        }

        return $response;

      }

      public function getParamEmisor($empresa_ID){

        require ROOT_PATH.'models/datos_generales.php';

        $oDatos_generales=datos_generales::getByID($empresa_ID);

        $certificateCAcer = ROOT_PATH.'files/SUNAT/CERTIFICADO/'.$oDatos_generales->ruc.'.pfx';
        $certificateCAcerContent = file_get_contents($certificateCAcer);
        $certificadostring =  PHP_EOL.chunk_split(base64_encode($certificateCAcerContent), 64, PHP_EOL).PHP_EOL;

        $Emisor = array (
          'NroDocumento' => $oDatos_generales->ruc,
          'TipoDocumento' => '6',
          'NombreLegal' => $oDatos_generales->razon_social,
          'NombreComercial' => $oDatos_generales->alias,
          'Ubigeo' => '140101',
          'Direccion' => $oDatos_generales->direccion_fiscal,
          'Urbanizacion' => '',
          'Departamento' => 'LIMA',
          'Provincia' => 'LIMA',
          'Distrito' => 'SAN BORJA'
        );

        $data = array( "RUC"=>$oDatos_generales->ruc,
                      "UsuarioSol"=>"MODDATOS",
                      "ClaveSol"=>"MODDATOS",
                      "Certificado"=>$certificadostring,
                      "PasswordCertificado"=>"FloresSalas",
                      "TasaIgv"=>0.18,
                      "TasaIsc"=>0.10,
                      "TasaDetraccion"=>0.04,
                      "UrlSunat"=>"https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService",
                      "UrlOtroCpe"=>"https://e-beta.sunat.gob.pe/ol-ti-itemision-otroscpe-gem-beta/billService",
                      "Emisor"=>$Emisor
                    );
        return $data;

      }

      //Escribir una trama Base64 en un archivo fisico en disco
      //<param name="nombreArchivo">Ruta de Destino (incluir extension)</param>
      //<param name="trama">Trama del Archivo</param>
      public function EscribirArchivoXML($NombreArchivo,$TramaXmlFirmado)
      {
        $OUTPUT = ROOT_PATH."files/SUNAT/XML/".$NombreArchivo;
      	$bin = base64_decode($TramaXmlFirmado);
      	file_put_contents($OUTPUT, $bin);
      }

      public function EscribirArchivoCDR($NombreArchivo,$TramaXmlFirmado)
      {
        $OUTPUT =  ROOT_PATH."files/SUNAT/CDR/".$NombreArchivo;
      	$bin = base64_decode($TramaXmlFirmado);
      	file_put_contents($OUTPUT, $bin);
      }

}
?>
