
<?php


        //return false;
  require(dirname(__FILE__) . '/include/xmlseclibs-master/xmlseclibs.php');
   
  use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

//include (dirname(__FILE__).'/include/xmlseclibs-master/src/xmlsecuritydsig.php');
    //include (dirname(__FILE__).'/include/xmlseclibs-master/src/xmlsecuritykey.php');
    
    
$xmlstr='20536781499-01-F001-92.xml';

signBill($xmlstr,'clave_publica.pem','clave_privada.pem','','20536781499-01-F001-92.xml');
   

        function signBill($xmlFile,$publicPath,$privatePath,$xmlpath,$xmlName){
                
        $ReferenceNodeName = 'ExtensionContent';
        
        //$privateKey = file_get_contents($privatePath);
       // $publicKey = file_get_contents($publicPath);
        if (openssl_pkcs12_read(file_get_contents("10474911085.pfx"), $certs, "FloresSalas")) {
            //print_r($certs['cert']);
            $publicKey = $certs['cert'];
            $privateKey = openssl_pkey_get_private($certs['pkey']);
        }
        //echo $publicKey;
        
        $domDocument = new DOMDocument();
        $domDocument->load($xmlFile);
        
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
                
        $content = $domDocument->save($xmlpath.$xmlName);
        
    }
        
