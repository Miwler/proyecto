<?php
function factura_venta_UBL2_1($array){
        $xml = new DomDocument("1.0", "ISO-8859-1"); 
        
        $Invoice=$xml->createElement('Invoice'); 
        $Invoice = $xml->appendChild($Invoice);
        $this->inyectar_atributo2_1($xml,$Invoice);
            $UBLExtensions = $xml->createElement('ext:UBLExtensions'); 
            $UBLExtensions = $Invoice->appendChild($UBLExtensions);
                $UBLExtension=$xml->createElement('ext:UBLExtension'); 
                $UBLExtension =$UBLExtensions->appendChild($UBLExtension);
                    $ExtensionContent=$xml->createElement('ext:ExtensionContent'); 
                    $ExtensionContent =$UBLExtension->appendChild($ExtensionContent);
                                            
            $UBLVersionID=$xml->createElement('cbc:UBLVersionID','2.1'); 
            $UBLVersionID =$Invoice->appendChild($UBLVersionID);
            $CustomizationID=$xml->createElement('cbc:CustomizationID','2.0'); 
            $CustomizationID =$Invoice->appendChild($CustomizationID);
            
            //$InvoiceTypeCode=$xml->createElement("cbc:InvoiceTypeCode");
            
            
            /*$ProfileID=$xml->createElement('cbc:ProfileID','0101');
            $ProfileID=$Invoice->appendChild($ProfileID);
                $schemeName=$xml->createAttribute('schemeName');
                $schemeName->value='SUNAT:Identificador de Tipo de Operación';
                $ProfileID->appendChild($schemeName);
                
                $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                $schemeAgencyName->value='PE:SUNAT';
                $ProfileID->appendChild($schemeAgencyName);
                
                $schemeURI=$xml->createAttribute('schemeURI');
                $schemeURI->value='urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17';
                $ProfileID->appendChild($schemeURI);*/
                
            
            $ID=$xml->createElement('cbc:ID',$array['IdDocumento']); 
            $ID =$Invoice->appendChild($ID);
            
            $IssueDate=$xml->createElement('cbc:IssueDate',$array['FechaEmision']); 
            $IssueDate=$Invoice->appendChild($IssueDate);
            $IssueTime=$xml->createElement('cbc:IssueTime',$array['HoraEmision']); 
            $IssueTime=$Invoice->appendChild($IssueTime);
            
            $DueDate=$xml->createElement('cbc:DueDate',$array['FechaVencimiento']); 
            $DueDate=$Invoice->appendChild($DueDate);
            
            $InvoiceTypeCode=$xml->createElement('cbc:InvoiceTypeCode',$array['TipoDocumento']); 
            $InvoiceTypeCode =$Invoice->appendChild($InvoiceTypeCode);
                $listID=$xml->createAttribute("listID");
                $listID->value="0101";
                $InvoiceTypeCode->appendChild($listID);
                $name=$xml->createAttribute("name");
                $name->value="Tipo de Operacion";
                $InvoiceTypeCode->appendChild($name);
                $listSchemeURI=$xml->createAttribute("listSchemeURI");
                $listSchemeURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo51";
                $InvoiceTypeCode->appendChild($listSchemeURI);
                
                $listAgencyName=$xml->createAttribute("listAgencyName");
                $listAgencyName->value="PE:SUNAT";
                $InvoiceTypeCode->appendChild($listAgencyName);
                $listName=$xml->createAttribute("listName");
                $listName->value="Tipo de Documento";//16/03/2019SUNAT:Identificador de Tipo de Documento";
                $InvoiceTypeCode->appendChild($listName);
                $listURI=$xml->createAttribute("listURI");
                $listURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01";
                $InvoiceTypeCode->appendChild($listURI);
                
            $Note=$xml->createElement('cbc:Note'); 
            $Note=$Invoice->appendChild($Note);
                $languageLocaleID=$xml->createAttribute("languageLocaleID");
                $languageLocaleID->value="1000";
                $Note->appendChild($languageLocaleID);
                $total_texto=$xml->createTextNode($array['MontoEnLetras']);
                $Note->appendChild($total_texto);
                
            $DocumentCurrencyCode=$xml->createElement('cbc:DocumentCurrencyCode',$array['Moneda']); 
            $DocumentCurrencyCode =$Invoice->appendChild($DocumentCurrencyCode);
                $listID=$xml->createAttribute("listID");
                $listID->value="ISO 4217 Alpha";
                $DocumentCurrencyCode->appendChild($listID);
                $listName=$xml->createAttribute("listName");
                $listName->value="Currency";
                $DocumentCurrencyCode->appendChild($listName);
                $listAgencyName=$xml->createAttribute("listAgencyName");
                $listAgencyName->value="United Nations Economic Commission for Europe";
                $DocumentCurrencyCode->appendChild($listAgencyName);
            //Guías
                
                
                
            $LineCountNumeric=$xml->createElement('cbc:LineCountNumeric',$array['TotalItems']); 
            $LineCountNumeric =$Invoice->appendChild($LineCountNumeric);
        if(isset($array['DocumentoDespacho'])&& count($array['DocumentoDespacho'])>0 && $array['DocumentoDespacho']['NroDocumento']!=""){
            $DespatchDocumentReference=$xml->createElement('cac:DespatchDocumentReference');
            $DespatchDocumentReference=$Invoice->appendChild($DespatchDocumentReference);
                $ID=$xml->createElement('cbc:ID',$array['DocumentoDespacho']['NroDocumento']);
                $ID=$DespatchDocumentReference->appendChild($ID);
                $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['DocumentoDespacho']['TipoDocumento']);
		$DocumentTypeCode=$DespatchDocumentReference->appendChild($DocumentTypeCode);
                $listAgencyName=$xml->createAttribute('listAgencyName');
                $listAgencyName->value='PE:SUNAT';
                $DocumentTypeCode->appendChild($listAgencyName);
                $listName=$xml->createAttribute('listName');
                $listName->value="Tipo de Documento";//'SUNAT:Identificador de Tipo de Documento';
                $DocumentTypeCode->appendChild($listName);
                $listURI=$xml->createAttribute('listURI');
                $listURI->value='urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01';
                $DocumentTypeCode->appendChild($listURI);
        }    
        if(isset($array['Relacionados']) && count($array['Relacionados'])>0 && $array['Relacionados']['NroDocumento']!=""){
            $AdditionalDocumentReference=$xml->createElement('cac:AdditionalDocumentReference'); 
            $AdditionalDocumentReference=$Invoice->appendChild($AdditionalDocumentReference);
                $ID=$xml->createElement('cbc:ID',$array['Relacionados']['NroDocumento']); 
                $ID=$AdditionalDocumentReference->appendChild($ID);
                
                $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['Relacionados']['TipoDocumento']); 
                $DocumentTypeCode=$AdditionalDocumentReference->appendChild($DocumentTypeCode);
                    $listAgencyName=$xml->createAttribute("listAgencyName");
                    $listAgencyName->value="PE:SUNAT";
                    $DocumentTypeCode->appendChild($listAgencyName);
                    $listName=$xml->createAttribute("listName");
                    $listName->value="Documento Relacionado";
                    $DocumentTypeCode->appendChild($listName);
                    
                    $listURI=$xml->createAttribute("listURI");
                    $listURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo12";
                    $DocumentTypeCode->appendChild($listURI);
                /*16/06/2019$DocumentStatusCode=$xml->createElement('cbc:DocumentStatusCode',$array['Relacionados']['NroDocumento']); 
                $DocumentStatusCode=$AdditionalDocumentReference->appendChild($DocumentStatusCode);
                    $listName=$xml->createAttribute("listName");
                    $listName->value="Anticipo";
                    $DocumentTypeCode->appendChild($listName);
                    $listAgencyName=$xml->createAttribute("listAgencyName");
                    $listAgencyName->value="PE:SUNAT";
                    $DocumentTypeCode->appendChild($listAgencyName);*/
                    
                /*16/06/2019$IssuerParty=$xml->createElement('cac:IssuerParty'); 
                $IssuerParty=$AdditionalDocumentReference->appendChild($IssuerParty);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification=$IssuerParty->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',$array['Emisor']['NroDocumento']); 
                        $ID=$PartyIdentification->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="6";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="Documento de Identidad";
                            $ID->appendChild($schemeName);
                            $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                            $schemeAgencyName->value="PE:SUNAT";
                            $ID->appendChild($schemeAgencyName);
                            $schemeURI=$xml->createAttribute("schemeURI");
                            $schemeURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
                            $ID->appendChild($schemeURI);*/
                    
        }
            
            $Signature=$xml->createElement('cac:Signature'); 
            $Signature=$Invoice->appendChild($Signature);
                $ID=$xml->createElement('cbc:ID','LlamaSign'); 
                $ID=$Signature->appendChild($ID);
                $SignatoryParty=$xml->createElement('cac:SignatoryParty'); 
                $SignatoryParty=$Signature->appendChild($SignatoryParty);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification=$SignatoryParty->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID','20600695771'); 
                        $ID=$PartyIdentification->appendChild($ID);
                    $PartyName=$xml->createElement('cac:PartyName'); 
                    $PartyName=$SignatoryParty->appendChild($PartyName);    
                        $Name=$xml->createElement('cbc:Name'); 
                        $Name=$PartyName->appendChild($Name);
                            $razon_social=$xml->createCDATASection('LLAMA.PE SA');
                            $Name->appendChild($razon_social);
                $DigitalSignatureAttachment=$xml->createElement('cac:DigitalSignatureAttachment'); 
                $DigitalSignatureAttachment=$Signature->appendChild($DigitalSignatureAttachment);
                    $ExternalReference=$xml->createElement('cac:ExternalReference'); 
                    $ExternalReference=$DigitalSignatureAttachment->appendChild($ExternalReference);
                        $URI=$xml->createElement('cbc:URI','#LlamaSign'); 
                        $URI=$ExternalReference->appendChild($URI);
            //Emisor                
            $AccountingSupplierParty=$xml->createElement('cac:AccountingSupplierParty'); 
            $AccountingSupplierParty=$Invoice->appendChild($AccountingSupplierParty);
                $Party=$xml->createElement('cac:Party'); 
                $Party=$AccountingSupplierParty->appendChild($Party);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification=$Party->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',$array['Emisor']['NroDocumento']); 
                        $ID=$PartyIdentification->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="6";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="Documento de Identidad";//16/03/2019SUNAT:Identificador de Documento de Identidad";
                            $ID->appendChild($schemeName);
                            $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                            $schemeAgencyName->value="PE:SUNAT";
                            $ID->appendChild($schemeAgencyName);
                            $schemeURI=$xml->createAttribute("schemeURI");
                            $schemeURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
                            $ID->appendChild($schemeURI);
                        
                        
                    $PartyName=$xml->createElement('cac:PartyName'); 
                    $PartyName =$Party->appendChild($PartyName);
                        $Name=$xml->createElement('cbc:Name'); 
                        $Name=$PartyName->appendChild($Name);
                            $nombre_comercial=$xml->createCDATASection($array['Emisor']['NombreComercial']);
                            $nombre_comercial=$Name->appendChild($nombre_comercial);
                    $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                    $PartyLegalEntity=$Party->appendChild($PartyLegalEntity);
                        $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                        $RegistrationName=$PartyLegalEntity->appendChild($RegistrationName);
                            $nombre_legal=$xml->createCDATASection($array['Emisor']['NombreLegal']);
                            $RegistrationName->appendChild($nombre_legal);
                        $RegistrationAddress=$xml->createElement('cac:RegistrationAddress'); 
                        $RegistrationAddress=$PartyLegalEntity->appendChild($RegistrationAddress);
                        //16/03/2019
                            /*$AddressLine=$xml->createElement("cac:AddressLine");
                            $AddressLine=$RegistrationAddress->appendChild($AddressLine);
                                $Line=$xml->createElement("cbc:Line");
                                $Line=$AddressLine->appendChild($Line);
                                    $direccion_completa=$xml->createCDATASection(substr(FormatTextViewXML($array['Emisor']['Direccion']),0,200));
                                    $direccion_completa=$Line->appendChild($direccion_completa);
                                
                            $CitySubdivisionName=$xml->createElement("cbc:CitySubdivisionName",substr(FormatTextViewXML($array['Emisor']['Urbanizacion']),0,25));
                            $CitySubdivisionName=$RegistrationAddress->appendChild($CitySubdivisionName);
                                
                            $CityName=$xml->createElement("cbc:CityName",substr(FormatTextViewXML($array['Emisor']['Provincia']),0,30));
                            $CityName=$RegistrationAddress->appendChild($CityName);*/
                                
                                
                                
                            /*$ID=$xml->createElement("cbc:ID",$array['Emisor']['Ubigeo']);
                            $ID=$RegistrationAddress->appendChild($ID);
                                $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                                $schemeAgencyName->value="PE:INEI";
                                $ID->appendChild($schemeAgencyName); 
                                $schemeName=$xml->createAttribute("schemeName");
                                $schemeName->value="Ubigeos";
                                $ID->appendChild($schemeName); 
                                
                            $CountrySubentity=$xml->createElement("cbc:CountrySubentity",substr(FormatTextViewXML($array['Emisor']['Departamento']),0,30));
                            $CountrySubentity=$RegistrationAddress->appendChild($CountrySubentity);
                            $District=$xml->createElement("cbc:District",substr(FormatTextViewXML($array['Emisor']['Distrito']),0,30));
                            $District=$RegistrationAddress->appendChild($District);
                            $Country=$xml->createElement("cac:Country");
                            $Country=$RegistrationAddress->appendChild($Country);
                                $IdentificationCode=$xml->createElement("cbc:IdentificationCode",$array['Emisor']['Pais']);
                                $IdentificationCode=$Country->appendChild($IdentificationCode);
                                    $listID=$xml->createAttribute("listID");
                                    $listID->value="ISO 3166-1";
                                    $IdentificationCode->appendChild($listID);
                                    $listAgencyName=$xml->createAttribute("listAgencyName");
                                    $listAgencyName->value="United Nations Economic Commission for Europe";
                                    $IdentificationCode->appendChild($listAgencyName);
                                    $listName=$xml->createAttribute("listName");
                                    $listName->value="Country";
                                    $IdentificationCode->appendChild($listName);*/
                                    
                            //
                            $AddressTypeCode=$xml->createElement('cbc:AddressTypeCode',$array['Emisor']['Local']); 
                            $AddressTypeCode=$RegistrationAddress->appendChild($AddressTypeCode);
                                $listAgencyName=$xml->createAttribute("listAgencyName");
                                $listAgencyName->value="PE:SUNAT";
                                $AddressTypeCode->appendChild($listAgencyName);
                                $listName=$xml->createAttribute("listName");
                                $listName->value="Establecimientos anexos";
                                $AddressTypeCode->appendChild($listName);
                    
                    
            $AccountingCustomerParty=$xml->createElement('cac:AccountingCustomerParty'); 
            $AccountingCustomerParty=$Invoice->appendChild($AccountingCustomerParty);
                $Party=$xml->createElement('cac:Party'); 
                $Party=$AccountingCustomerParty->appendChild($Party);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification=$Party->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',trim($array['Receptor']['NroDocumento'])); 
                        $ID=$PartyIdentification->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="6";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="Documento de Identidad";//16/03/209"SUNAT:Identificador de Documento de Identidad";
                            $ID->appendChild($schemeName);
                            
                            $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                            $schemeAgencyName->value="PE:SUNAT";
                            $ID->appendChild($schemeAgencyName);
                            $schemeURI=$xml->createAttribute("schemeURI");
                            $schemeURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";
                            $ID->appendChild($schemeURI);
                    $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                    $PartyLegalEntity=$Party->appendChild($PartyLegalEntity);
                        $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                        $RegistrationName=$PartyLegalEntity->appendChild($RegistrationName);
                            $nombre_legal=$xml->createCDATASection(FormatTextViewXML(trim($array['Receptor']['NombreLegal'])));
                            $RegistrationName->appendChild($nombre_legal);
        ///final revisado                    
          
        if(isset($array['Delivery']) && count($array['Delivery'])>0){
            $DeliveryTerms=$xml->createElement('cac:DeliveryTerms'); 
            $DeliveryTerms =$Invoice->appendChild($DeliveryTerms);
                $DeliveryLocation=$xml->createElement('cac:DeliveryLocation'); 
                $DeliveryLocation =$DeliveryTerms->appendChild($DeliveryLocation);
                    $Address=$xml->createElement('cac:Address'); 
                    $Address=$DeliveryLocation->appendChild($Address);
                        $StreetName=$xml->createElement('cbc:StreetName'); 
                        $StreetName=$Address->appendChild($StreetName);
                            $direccion=$xml->createCDATASection($array['Delivery']['Direccion']);
                            $direccion=$StreetName->appendChild($direccion);
                        $CitySubdivisionName=$xml->createElement('cbc:CitySubdivisionName'); 
                        $CitySubdivisionName=$Address->appendChild($CitySubdivisionName);
                        $CityName=$xml->createElement('cbc:CityName'); 
                        $CityName=$Address->appendChild($CityName);
                            $provincia=$xml->createTextNode($array['Delivery']['Provincia']);
                            $provincia=$CityName->appendChild($provincia);
                        //$PostalZone=$xml->createElement('cbc:PostalZone',$array['Delivery']['Ubigeo']); 
                        //$PostalZone=$Address->appendChild($PostalZone);
                        $CountrySubentity=$xml->createElement('cbc:CountrySubentity'); 
                        $CountrySubentity =$Address->appendChild($CountrySubentity);
                            $Departamento=$xml->createTextNode($array['Delivery']['Departamento']);
                            $Departamento=$CountrySubentity->appendChild($Departamento);
                        $CountrySubentityCode=$xml->createElement('cbc:CountrySubentityCode',$array['Delivery']['Ubigeo']); 
                        $CountrySubentityCode=$Address->appendChild($CountrySubentityCode);
                        $District=$xml->createElement('cbc:District'); 
                        $District =$Address->appendChild($District);
                            $Distrito=$xml->createTextNode($array['Delivery']['Distrito']);
                            $Distrito=$District->appendChild($Distrito);
                        $Country=$xml->createElement('cac:Country'); 
                        $Country =$Address->appendChild($Country);
                            $IdentificationCode=$xml->createElement('cbc:IdentificationCode',$array['Delivery']['Pais']); 
                            $IdentificationCode =$Address->appendChild($IdentificationCode);
                            $listID=$xml->createAttribute("listID");
                            $listID->value="ISO 3166-1";
                            $IdentificationCode->appendChild($listID);
                            $listAgencyName=$xml->createAttribute("listID");
                            $listAgencyName->value="United Nations Economic Commission for Europe";
                            $IdentificationCode->appendChild($listAgencyName);
                            $listName=$xml->createAttribute("listName");
                            $listName->value="Country";
                            $IdentificationCode->appendChild($listName);
                             
        }
        if ($array['DescuentoGlobal']!=""&&$array['DescuentoGlobal']>0){
            $AllowanceCharge=$xml->createElement('cac:AllowanceCharge'); 
            $AllowanceCharge=$Invoice->appendChild($AllowanceCharge);
                $ChargeIndicator=$xml->createElement('cbc:ChargeIndicator','false'); 
                $ChargeIndicator=$AllowanceCharge->appendChild($ChargeIndicator);
                $AllowanceChargeReasonCode=$xml->createElement('cbc:AllowanceChargeReasonCode','00'); 
                $AllowanceChargeReasonCode=$AllowanceCharge->appendChild($AllowanceChargeReasonCode);
                $MultiplierFactorNumeric=$xml->createElement('cbc:MultiplierFactorNumeric',$array["PorcentajeDescuento"]); 
                $MultiplierFactorNumeric=$AllowanceCharge->appendChild($MultiplierFactorNumeric);
                $Amount=$xml->createElement('cbc:Amount',$array['DescuentoGlobal']); 
                $Amount=$AllowanceCharge->appendChild($Amount);
                    $currencyID=$xml->createAttribute("currencyID");
                    $currencyID->value=$array["Moneda"];
                    $Amount->appendChild($currencyID);
                $BaseAmount=$xml->createElement('cbc:BaseAmount',$array['Gravadas']+$array['DescuentoGlobal']); 
                $BaseAmount=$AllowanceCharge->appendChild($BaseAmount);
                    $currencyID=$xml->createAttribute("currencyID");
                    $currencyID->value=$array["Moneda"];
                    $BaseAmount->appendChild($currencyID);
        }
        
            $TaxTotal=$xml->createElement('cac:TaxTotal'); 
            $TaxTotal =$Invoice->appendChild($TaxTotal);
                $TaxAmount=$xml->createElement('cbc:TaxAmount',$array['TotalIgv']+$array['TotalIsc']+$array['TotalIvap']); 
                $TaxAmount=$TaxTotal->appendChild($TaxAmount);
                $currencyID=$xml->createAttribute('currencyID');
                $currencyID->value=$array['Moneda'];
                $TaxAmount->appendChild($currencyID);
                
                $TaxSubtotal=$xml->createElement('cac:TaxSubtotal'); 
                $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                    $TaxableAmount=$xml->createElement('cbc:TaxableAmount',$array['Gravadas']); 
                    $TaxableAmount=$TaxSubtotal->appendChild($TaxableAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxableAmount->appendChild($currencyID);
                        
                    $TaxAmount=$xml->createElement('cbc:TaxAmount',$array['TotalIgv']); 
                    $TaxAmount=$TaxSubtotal->appendChild($TaxAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxAmount->appendChild($currencyID);
                    
                    $TaxCategory=$xml->createElement('cac:TaxCategory'); 
                    $TaxCategory=$TaxSubtotal->appendChild($TaxCategory);
                        $ID=$xml->createElement('cbc:ID','S'); 
                        $ID=$TaxCategory->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="UN/ECE 5305";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="Tax Category Identifier";
                            $ID->appendChild($schemeName);
                            $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                            $schemeAgencyName->value="United Nations Economic Commission for Europe";
                            $ID->appendChild($schemeAgencyName);
                            
                        $TaxScheme=$xml->createElement('cac:TaxScheme'); 
                        $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                            $ID=$xml->createElement('cbc:ID','1000'); 
                            $ID=$TaxScheme->appendChild($ID);
                                $schemeName=$xml->createAttribute("schemeName");
                                $schemeName->value="Codigo de tributos";
                                $ID->appendChild($schemeName);
                                $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                                $schemeAgencyName->value="PE:SUNAT";
                                $ID->appendChild($schemeAgencyName);
                                
                                $schemeURI=$xml->createAttribute("schemeURI");
                                $schemeURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05";
                                $ID->appendChild($schemeURI);
                                
                                /*$schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5153";
                                $ID->appendChild($schemeID);
                                $schemeAgencyID=$xml->createAttribute("schemeAgencyID");
                                $schemeAgencyID->value="6";
                                $ID->appendChild($schemeAgencyID);*/
                            $name=$xml->createElement('cbc:Name','IGV'); 
                            $name=$TaxScheme->appendChild($name);
                            $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','VAT'); 
                            $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);
                            //Si tiene impuesto selectivo
           
                     /// por retirar    
            if($array['Exoneradas']!=""&&$array['Exoneradas']!='0.00'){
                    //Total valor de venta - operaciones exoneradas
                $TaxSubtotal=$xml->createElement('cac:TaxSubtotal'); 
                $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                    $TaxableAmount=$xml->createElement('cbc:TaxableAmount',$array['Exoneradas']); 
                    $TaxableAmount=$TaxSubtotal->appendChild($TaxableAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxableAmount->appendChild($currencyID);
                        
                    $TaxAmount=$xml->createElement('cbc:TaxAmount','0.00'); 
                    $TaxAmount=$TaxSubtotal->appendChild($TaxAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];//PEN
                        $TaxAmount->appendChild($currencyID);
                    
                    $TaxCategory=$xml->createElement('cac:TaxCategory'); 
                    $TaxCategory=$TaxSubtotal->appendChild($TaxCategory);
                        $ID=$xml->createElement('cbc:ID','E'); 
                        $ID=$TaxCategory->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="UN/ECE 5305";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="Tax Category Identifier";
                            $ID->appendChild($schemeName);
                            $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                            $schemeAgencyName->value="United Nations Economic Commission for Europe";
                            $ID->appendChild($schemeAgencyName);
                            
                        $TaxScheme=$xml->createElement('cac:TaxScheme'); 
                        $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                            $ID=$xml->createElement('cbc:ID','9997'); 
                            $ID=$TaxScheme->appendChild($ID);
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5153";
                                $ID->appendChild($schemeID);
                                $schemeAgencyID=$xml->createAttribute("schemeAgencyID");
                                $schemeAgencyID->value="6";
                                $ID->appendChild($schemeAgencyID);
                            $name=$xml->createElement('cbc:Name','EXONERADO'); 
                            $name=$TaxScheme->appendChild($name);
                            $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','VAT'); 
                            $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);        
            }
            if($array['Inafectas']!=""&&$array['Inafectas']!='0.00'){
                    //25 Total valor de venta - operaciones inafectas.
                $TaxSubtotal=$xml->createElement('cac:TaxSubtotal'); 
                $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                    $TaxableAmount=$xml->createElement('cbc:TaxableAmount',$array['Inafectas']); 
                    $TaxableAmount=$TaxSubtotal->appendChild($TaxableAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxableAmount->appendChild($currencyID);
                        
                    $TaxAmount=$xml->createElement('cbc:TaxAmount','0.00'); 
                    $TaxAmount=$TaxSubtotal->appendChild($TaxAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];//PEN
                        $TaxAmount->appendChild($currencyID);
                    
                    $TaxCategory=$xml->createElement('cac:TaxCategory'); 
                    $TaxCategory=$TaxSubtotal->appendChild($TaxCategory);
                        $ID=$xml->createElement('cbc:ID','O'); 
                        $ID=$TaxCategory->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="UN/ECE 5305";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="Tax Category Identifier";
                            $ID->appendChild($schemeName);
                            $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                            $schemeAgencyName->value="United Nations Economic Commission for Europe";
                            $ID->appendChild($schemeAgencyName);
                            
                        $TaxScheme=$xml->createElement('cac:TaxScheme'); 
                        $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                            $ID=$xml->createElement('cbc:ID','9998'); 
                            $ID=$TaxScheme->appendChild($ID);
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5153";
                                $ID->appendChild($schemeID);
                                $schemeAgencyID=$xml->createAttribute("schemeAgencyID");
                                $schemeAgencyID->value="6";
                                $ID->appendChild($schemeAgencyID);
                            $name=$xml->createElement('cbc:Name','INAFECTO'); 
                            $name=$TaxScheme->appendChild($name);
                            $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','FRE'); 
                            $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);        
            }
            if($array['Gratuitas']!=""&&$array['Gratuitas']!='0.00'){
                    //26 Total Valor de Venta de Operaciones gratuitas.
                $TaxSubtotal=$xml->createElement('cac:TaxSubtotal'); 
                $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                    $TaxableAmount=$xml->createElement('cbc:TaxableAmount',$array['Gratuitas']); 
                    $TaxableAmount=$TaxSubtotal->appendChild($TaxableAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxableAmount->appendChild($currencyID);
                        
                    $TaxAmount=$xml->createElement('cbc:TaxAmount',$array['GratuitasIGV']); 
                    $TaxAmount=$TaxSubtotal->appendChild($TaxAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];//PEN($array['GratuitasIGV']=='0.00')?'PEN':$array['Moneda'];
                        $TaxAmount->appendChild($currencyID);
                    
                    $TaxCategory=$xml->createElement('cac:TaxCategory'); 
                    $TaxCategory=$TaxSubtotal->appendChild($TaxCategory);
                        $ID=$xml->createElement('cbc:ID','Z'); 
                        $ID=$TaxCategory->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="UN/ECE 5305";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="Tax Category Identifier";
                            $ID->appendChild($schemeName);
                            $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                            $schemeAgencyName->value="United Nations Economic Commission for Europe";
                            $ID->appendChild($schemeAgencyName);
                            
                        $TaxScheme=$xml->createElement('cac:TaxScheme'); 
                        $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                            $ID=$xml->createElement('cbc:ID','9996'); 
                            $ID=$TaxScheme->appendChild($ID);
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5153";
                                $ID->appendChild($schemeID);
                                $schemeAgencyID=$xml->createAttribute("schemeAgencyID");
                                $schemeAgencyID->value="6";
                                $ID->appendChild($schemeAgencyID);
                            $name=$xml->createElement('cbc:Name','GRATUITO'); 
                            $name=$TaxScheme->appendChild($name);
                            $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','FRE'); 
                            $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);        
            }
            if($array['TotalIsc']!=""&&$array['TotalIsc']!='0.00'){
                    //Total valor de venta - operaciones exoneradas
                $TaxSubtotal=$xml->createElement('cac:TaxSubtotal'); 
                $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                    $TaxableAmount=$xml->createElement('cbc:TaxableAmount',$array['isc_base']); 
                    $TaxableAmount=$TaxSubtotal->appendChild($TaxableAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxableAmount->appendChild($currencyID);
                        
                    $TaxAmount=$xml->createElement('cbc:TaxAmount',$array['TotalIsc']); 
                    $TaxAmount=$TaxSubtotal->appendChild($TaxAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxAmount->appendChild($currencyID);
                    
                    $TaxCategory=$xml->createElement('cac:TaxCategory'); 
                    $TaxCategory=$TaxSubtotal->appendChild($TaxCategory);
                        $ID=$xml->createElement('cbc:ID','S'); 
                        $ID=$TaxCategory->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="UN/ECE 5305";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="Tax Category Identifier";
                            $ID->appendChild($schemeName);
                            $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                            $schemeAgencyName->value="United Nations Economic Commission for Europe";
                            $ID->appendChild($schemeAgencyName);
                            
                        $TaxScheme=$xml->createElement('cac:TaxScheme'); 
                        $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                            $ID=$xml->createElement('cbc:ID','2000'); 
                            $ID=$TaxScheme->appendChild($ID);
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5153";
                                $ID->appendChild($schemeID);
                                $schemeAgencyID=$xml->createAttribute("schemeAgencyID");
                                $schemeAgencyID->value="6";
                                $ID->appendChild($schemeAgencyID);
                            $name=$xml->createElement('cbc:Name','ISC'); 
                            $name=$TaxScheme->appendChild($name);
                            $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','EXC'); 
                            $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);        
            }
            $LegalMonetaryTotal=$xml->createElement('cac:LegalMonetaryTotal'); 
            $LegalMonetaryTotal =$Invoice->appendChild($LegalMonetaryTotal);    
                $LineExtensionAmount=$xml->createElement('cbc:LineExtensionAmount',$array['Gravadas']); 
                $LineExtensionAmount=$LegalMonetaryTotal->appendChild($LineExtensionAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $LineExtensionAmount->appendChild($currencyID);
                    $total_precio_venta=round($array['Gravadas']*(1+$array['CalculoIgv']),2);
                $TaxInclusiveAmount=$xml->createElement('cbc:TaxInclusiveAmount',$total_precio_venta); 
                $TaxInclusiveAmount=$LegalMonetaryTotal->appendChild($TaxInclusiveAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $TaxInclusiveAmount->appendChild($currencyID);
                $AllowanceTotalAmount=$xml->createElement('cbc:AllowanceTotalAmount',$array['DescuentoGlobal']+$array['DescuentoTotalItems']); 
                $AllowanceTotalAmount=$LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $AllowanceTotalAmount->appendChild($currencyID);
                $ChargeTotalAmount=$xml->createElement('cbc:ChargeTotalAmount',$array['TotalOtrosCargos']); 
                $ChargeTotalAmount=$LegalMonetaryTotal->appendChild($ChargeTotalAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $ChargeTotalAmount->appendChild($currencyID);
            
           
                $PayableAmount=$xml->createElement('cbc:PayableAmount',$array['TotalVenta']); 
                $PayableAmount=$LegalMonetaryTotal->appendChild($PayableAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $PayableAmount->appendChild($currencyID);
            
             if(isset($array['MontoAnticipo'])&&$array['MontoAnticipo']>0){    
                    
                $PrepaidAmount=$xml->createElement('cbc:PrepaidAmount',$array['MontoAnticipo']); 
                $PrepaidAmount=$LegalMonetaryTotal->appendChild($PrepaidAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['MonedaAnticipo'];
                    $PrepaidAmount->appendChild($currencyID);
            }
                    //final porreviar
            
        foreach($array['Items'] as $items){
            $InvoiceLine=$xml->createElement('cac:InvoiceLine'); 
            $InvoiceLine =$Invoice->appendChild($InvoiceLine);
                $ID=$xml->createElement('cbc:ID',$items['Id']); 
                $ID =$InvoiceLine->appendChild($ID);
                $InvoicedQuantity=$xml->createElement('cbc:InvoicedQuantity',$items['Cantidad']); 
                $InvoicedQuantity =$InvoiceLine->appendChild($InvoicedQuantity);
                    $unitCode=$xml->createAttribute('unitCode');
                    $unitCode->value=$items['UnidadMedida'];
                    $InvoicedQuantity->appendChild($unitCode);
                    
                    $unitCodeListID=$xml->createAttribute('unitCodeListID');
                    $unitCodeListID->value="UN/ECE rec 20";
                    
                    $InvoicedQuantity->appendChild($unitCodeListID);
                    $unitCodeListAgencyName=$xml->createAttribute('unitCodeListAgencyName');
                    $unitCodeListAgencyName->value="United Nations Economic Commission for Europe";
                    $InvoicedQuantity->appendChild($unitCodeListAgencyName);
                    
                $LineExtensionAmount=$xml->createElement('cbc:LineExtensionAmount',$items['valor_venta']); 
                $LineExtensionAmount=$InvoiceLine->appendChild($LineExtensionAmount);
                $currencyID=$xml->createAttribute('currencyID');
                $currencyID->value=$array['Moneda'];
                $LineExtensionAmount->appendChild($currencyID);
            
                $PricingReference=$xml->createElement('cac:PricingReference');
                $PricingReference=$InvoiceLine->appendChild($PricingReference);
                    $AlternativeConditionPrice=$xml->createElement('cac:AlternativeConditionPrice');
                    $AlternativeConditionPrice=$PricingReference->appendChild($AlternativeConditionPrice);
                        $PriceAmount=$xml->createElement('cbc:PriceAmount',$items['PrecioVentaUnitario']);
                        $PriceAmount=$AlternativeConditionPrice->appendChild($PriceAmount);
                            $currencyID=$xml->createAttribute('currencyID');
                            $currencyID->value=$array['Moneda'];
                            $PriceAmount->appendChild($currencyID);
                        $PriceTypeCode=$xml->createElement('cbc:PriceTypeCode',$items['TipoPrecio']);
                        $PriceTypeCode=$AlternativeConditionPrice->appendChild($PriceTypeCode);
                            $listName=$xml->createAttribute("listName");
                            $listName->value="Tipo de Precio";
                            $PriceTypeCode->appendChild($listName);
                            $listAgencyName=$xml->createAttribute("listAgencyName");
                            $listAgencyName->value="PE:SUNAT";
                            $PriceTypeCode->appendChild($listAgencyName);
                            $listURI=$xml->createAttribute("listURI");
                            $listURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16";
                            $PriceTypeCode->appendChild($listURI);
            if($items['Descuento']>0){
                $AllowanceCharge=$xml->createElement('cac:AllowanceCharge');
                $AllowanceCharge=$InvoiceLine->appendChild($AllowanceCharge);
                    $ChargeIndicator=$xml->createElement('cbc:ChargeIndicator','false');
                    $ChargeIndicator=$AllowanceCharge->appendChild($ChargeIndicator);
                    $AllowanceChargeReasonCode=$xml->createElement('cbc:AllowanceChargeReasonCode','00');
                    $AllowanceChargeReasonCode=$AllowanceCharge->appendChild($AllowanceChargeReasonCode);
                    $MultiplierFactorNumeric=$xml->createElement('cbc:MultiplierFactorNumeric',$items['DescuentoFactor']);
                    $MultiplierFactorNumeric=$AllowanceCharge->appendChild($MultiplierFactorNumeric);
                    $Amount=$xml->createElement('cbc:Amount',$items['Descuento']);
                    $Amount=$AllowanceCharge->appendChild($Amount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $Amount->appendChild($currencyID);
                    $BaseAmount=$xml->createElement('cbc:BaseAmount',$items['SubtotalBase']);
                    $BaseAmount=$AllowanceCharge->appendChild($BaseAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];    
                        $BaseAmount->appendChild($currencyID);
            }
                $TaxTotal=$xml->createElement('cac:TaxTotal');
                $TaxTotal=$InvoiceLine->appendChild($TaxTotal);
                    $TaxAmount=$xml->createElement('cbc:TaxAmount',$items['Impuesto']);
                    $TaxAmount=$TaxTotal->appendChild($TaxAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $TaxAmount->appendChild($currencyID);
                    
                    $TaxSubtotal=$xml->createElement('cac:TaxSubtotal');
                    $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                        $TaxableAmount=$xml->createElement('cbc:TaxableAmount',$items['MontoBaseSinIGV']);
                        $TaxableAmount=$TaxSubtotal->appendChild($TaxableAmount);
                            $currencyID=$xml->createAttribute('currencyID');
                            $currencyID->value=$array['Moneda'];
                            $TaxableAmount->appendChild($currencyID);
                            
                        $TaxAmount=$xml->createElement('cbc:TaxAmount',$items['Impuesto']);
                        $TaxAmount=$TaxSubtotal->appendChild($TaxAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxAmount->appendChild($currencyID);
                        
                        
                        
                        
                        $TaxCategory=$xml->createElement('cac:TaxCategory');
                        $TaxCategory=$TaxSubtotal->appendChild($TaxCategory);
                            /*$ID=$xml->createElement('cbc:ID',$items['codigo_categoria']);
                            $ID=$TaxCategory->appendChild($ID);
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5305";
                                $ID->appendChild($schemeID);
                                $schemeName=$xml->createAttribute("schemeName");
                                $schemeName->value="Tax Category Identifier";
                                $ID->appendChild($schemeName);
                                $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                                $schemeAgencyName->value="United Nations Economic Commission for Europe";
                                $ID->appendChild($schemeAgencyName);*/
                            $Percent=$xml->createElement('cbc:Percent',$array['porcentajeIgv']);
                            $Percent=$TaxCategory->appendChild($Percent);
                            
                            $TaxExemptionReasonCode=$xml->createElement('cbc:TaxExemptionReasonCode',$items['TipoImpuesto']);
                            $TaxExemptionReasonCode=$TaxCategory->appendChild($TaxExemptionReasonCode);
                                $listAgencyName=$xml->createAttribute("listAgencyName");
                                $listAgencyName->value="PE:SUNAT";
                                $TaxExemptionReasonCode->appendChild($listAgencyName);
                                $listName=$xml->createAttribute("listName");
                                $listName->value="Afectacion del IGV";//"SUNAT:Codigo de Tipo de Afectación del IGV";
                                $TaxExemptionReasonCode->appendChild($listName);
                                $listURI=$xml->createAttribute("listURI");
                                $listURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07";
                                $TaxExemptionReasonCode->appendChild($listURI);
                                
                            $TaxScheme=$xml->createElement('cac:TaxScheme');
                            $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                                $ID=$xml->createElement('cbc:ID',$items['tipo_tributo_codigo']);
                                $ID=$TaxScheme->appendChild($ID);
                                    /*16/03/2019$schemeID=$xml->createAttribute("schemeID");
                                    $schemeID->value="UN/ECE 5153";
                                    $ID->appendChild($schemeID);*/
                                    $schemeName=$xml->createAttribute("schemeName");
                                    $schemeName->value="Codigo de tributos";//16/03/2019"Tax Scheme Identifier";
                                    $ID->appendChild($schemeName);
                                    $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                                    $schemeAgencyName->value="PE:SUNAT";//"United Nations Economic Commission for Europe";
                                    $ID->appendChild($schemeAgencyName);
                                    $schemeURI=$xml->createAttribute("schemeURI");
                                    $schemeURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05";//"United Nations Economic Commission for Europe";
                                    $ID->appendChild($schemeURI);
                                
                                $Name=$xml->createElement('cbc:Name',$items['tipo_tributo_descripcion']);
                                $Name=$TaxScheme->appendChild($Name);
                                $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode',$items['codigo_tipo_nombre']);
                                $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);
                                
                if($items['ImpuestoSelectivo']>0&&$items['codigo_calculo_isc']!=''){
                    /*$TaxAmount=$xml->createElement('cbc:TaxAmount',$items['ImpuestoSelectivo']);
                    $TaxAmount=$TaxTotal->appendChild($TaxAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $TaxAmount->appendChild($currencyID);*/
                    
                    $TaxSubtotal=$xml->createElement('cac:TaxSubtotal');
                    $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                        $TaxableAmount=$xml->createElement('cbc:TaxableAmount',$items['isc_base']);
                        $TaxableAmount=$TaxSubtotal->appendChild($TaxableAmount);
                            $currencyID=$xml->createAttribute('currencyID');
                            $currencyID->value=$array['Moneda'];
                            $TaxableAmount->appendChild($currencyID);
                            
                        $TaxAmount=$xml->createElement('cbc:TaxAmount',$items['ImpuestoSelectivo']);
                        $TaxAmount=$TaxSubtotal->appendChild($TaxAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxAmount->appendChild($currencyID);
                        $TaxCategory=$xml->createElement('cac:TaxCategory');
                        $TaxCategory=$TaxSubtotal->appendChild($TaxCategory);
                            $ID=$xml->createElement('cbc:ID','S');
                            $ID=$TaxCategory->appendChild($ID);
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5305";
                                $ID->appendChild($schemeID);
                                $schemeName=$xml->createAttribute("schemeName");
                                $schemeName->value="Tax Category Identifier";
                                $ID->appendChild($schemeName);
                                $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                                $schemeAgencyName->value="United Nations Economic Commission for Europe";
                                $ID->appendChild($schemeAgencyName);
                            $Percent=$xml->createElement('cbc:Percent',$items['PorcentajeISC']);
                            $Percent=$TaxCategory->appendChild($Percent);
                            
                            /*$TaxExemptionReasonCode=$xml->createElement('cbc:TaxExemptionReasonCode',$items['TipoImpuesto']);
                            $TaxExemptionReasonCode=$TaxCategory->appendChild($TaxExemptionReasonCode);
                                $listAgencyName=$xml->createAttribute("listAgencyName");
                                $listAgencyName->value="PE:SUNAT";
                                $TaxExemptionReasonCode->appendChild($listAgencyName);
                                $listName=$xml->createAttribute("listName");
                                $listName->value="SUNAT:Codigo de Tipo de Afectación del IGV";
                                $TaxExemptionReasonCode->appendChild($listName);
                                $listURI=$xml->createAttribute("listURI");
                                $listURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07";
                                $TaxExemptionReasonCode->appendChild($listURI);*/
                                
                            $TierRange=$xml->createElement('cbc:TierRange',$items['codigo_calculo_isc']);
                            $TierRange=$TaxCategory->appendChild($TierRange);
                            $TaxScheme=$xml->createElement('cac:TaxScheme');
                            $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                                $ID=$xml->createElement('cbc:ID','2000');
                                $ID=$TaxScheme->appendChild($ID);
                                    $schemeID=$xml->createAttribute("schemeID");
                                    $schemeID->value="UN/ECE 5153";
                                    $ID->appendChild($schemeID);
                                    $schemeName=$xml->createAttribute("schemeName");
                                    $schemeName->value="Tax Scheme Identifier";
                                    $ID->appendChild($schemeName);
                                    $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                                    $schemeAgencyName->value="United Nations Economic Commission for Europe";
                                    $ID->appendChild($schemeAgencyName);
                                    
                                $Name=$xml->createElement('cbc:Name','ISC');
                                $Name=$TaxScheme->appendChild($Name);
                                $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','EXC');
                                $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);
                }    
                $Item=$xml->createElement('cac:Item');
                $Item=$InvoiceLine->appendChild($Item);
                    $Description=$xml->createElement('cbc:Description');
                    $Description=$Item->appendChild($Description);
                        $descripcion=$xml->createCDATASection($items['Descripcion']);
                        $descripcion=$Description->appendChild($descripcion);
                    $SellersItemIdentification=$xml->createElement('cac:SellersItemIdentification');
                    $SellersItemIdentification=$Item->appendChild($SellersItemIdentification);
                        $ID=$xml->createElement('cbc:ID',$items['CodigoItem']);
                        $ID=$SellersItemIdentification->appendChild($ID);
                        
                        
                $Price=$xml->createElement('cac:Price');
                $Price=$InvoiceLine->appendChild($Price);
                    $PriceAmount=$xml->createElement('cbc:PriceAmount',$items['ValorUnitario']);
                    $PriceAmount=$Price->appendChild($PriceAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $PriceAmount->appendChild($currencyID);
        }    
            
        $xml->formatOutput = true;
        return $xml;
    }