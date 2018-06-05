<?php

class api_SUNAT {




    public function sendPostCPE($data,$metodo) {

      $headers = array(
            "Content-Type: application/json; charset=UTF-8",
            "Cache-Control: no-cache",
            "Pragma: no-cache"
        );
        //$ch = curl_init("http://192.168.10.151:8085/api/".$metodo);
        //$ch = curl_init("http://192.168.0.15/OpenInvoicePeru/api/".$metodo);
        //$ch = curl_init("http://192.168.43.242/OpenInvoicePeru/api/".$metodo);
        $ch = curl_init("http://192.168.1.4/api/".$metodo);
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

        if($http_status != 200 && $http_status != 302 && $http_status != 304)
        {
          //$json = json_decode($response);
          $response =  json_encode(array('Exito' => false, 'MensajeError' =>'Ocurrió un error con el servicio web.','Pila'=>''));
        }
        else {
            $response = $response;
        }

        return $response;

      }

      public function getParamEmisor($empresa_ID){

        require ROOT_PATH.'models/datos_generales.php';
        require ROOT_PATH.'models/distrito.php';
        if(!class_exists("configuracion")){
            require ROOT_PATH.'models/configuracion.php';
        }
        $oDatos_generales=datos_generales::getByID1($empresa_ID);
        $configuracion=configuracion::getGrid();
        $oDistrito=distrito::getByID($oDatos_generales->distrito_ID);
        $certificateCAcer = ROOT_PATH.$configuracion[3]['valores'].'/SUNAT/CERTIFICADO/'.$oDatos_generales->certificado;
        $certificateCAcerContent = file_get_contents($certificateCAcer);
        $certificadostring =  PHP_EOL.chunk_split(base64_encode($certificateCAcerContent), 64, PHP_EOL).PHP_EOL;

        $Emisor = array (
          'NroDocumento' =>$oDatos_generales->ruc,
          'TipoDocumento' => '6',//Antes 6
          'NombreLegal' => $oDatos_generales->razon_social,
          'NombreComercial' => $oDatos_generales->alias,
          'Ubigeo' => $oDistrito->codigo_ubigeo,
          'Direccion' => $oDatos_generales->direccion_fiscal,
          'Urbanizacion' => $oDatos_generales->urbanizacion,
          'Departamento' =>$oDistrito->departamento,
          'Provincia' =>$oDistrito->provincia,
          'Distrito' =>$oDistrito->nombre
        );

        $data = array( "RUC"=>$oDatos_generales->ruc,
                      "UsuarioSol"=>$oDatos_generales->usuariosol,
                      "ClaveSol"=>$oDatos_generales->clavesol,
                      "Certificado"=>$certificadostring,
                      "PasswordCertificado"=>$oDatos_generales->passwordcertificado,
                      "TasaIgv"=>$oDatos_generales->vigv,
                      "TasaIsc"=>$oDatos_generales->visc,
                      "TasaDetraccion"=>$oDatos_generales->tasadetraccion,
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
        if(!class_exists("configuracion")){
            require ROOT_PATH.'models/configuracion.php';
        }

        $configuracion=configuracion::getGrid();
        $OUTPUT = ROOT_PATH.$configuracion[3]['valores']."/SUNAT/XML/".$NombreArchivo;
        $bin = base64_decode($TramaXmlFirmado);
        file_put_contents($OUTPUT, $bin);
    }

      public function EscribirArchivoCDR($NombreArchivo,$TramaXmlFirmado)
      {
        if(!class_exists("configuracion")){
            require ROOT_PATH.'models/configuracion.php';
        }
        
        $configuracion=configuracion::getGrid();
        $OUTPUT =  ROOT_PATH.$configuracion[3]['valores']."/SUNAT/CDR/".$NombreArchivo;
      	//$bin = base64_decode($TramaXmlFirmado);
        $bin = ($TramaXmlFirmado);
      	file_put_contents($OUTPUT, $bin);
      }

}
?>
