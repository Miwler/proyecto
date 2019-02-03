<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of factura_xml
 *
 * @author miwle_000
 */
class formatosxml {
    private $atributos=array(
        'xmlns'=>'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2',
        'xmlns:cac'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2',
        'xmlns:cbc'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2',
        'xmlns:ccts'=>'urn:un:unece:uncefact:documentation:2',
        'xmlns:ds'=>'http://www.w3.org/2000/09/xmldsig#',
        'xmlns:ext'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2',
        'xmlns:qdt'=>'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2',
        'xmlns:sac'=>'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1',
        'xmlns:udt'=>'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2',
        'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance'
    );
    private $atributos2_1=array(
        'xmlns'=>'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2',
        'xmlns:cac'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2',
        'xmlns:cbc'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2',
        'xmlns:ccts'=>'urn:un:unece:uncefact:documentation:2',
        'xmlns:ds'=>"http://www.w3.org/2000/09/xmldsig#",
        'xmlns:ext'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2',
        'xmlns:qdt'=>'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2',
        'xmlns:udt'=>'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2',
        'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance'
    );
    private $atributos_guia=array(
        "xmlns"=>"urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2",
        "xmlns:cac"=>"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2",
        "xmlns:cbc"=>"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2",
        "xmlns:ccts"=>"urn:un:unece:uncefact:documentation:2",
        "xmlns:ds"=>"http://www.w3.org/2000/09/xmldsig#",
        "xmlns:ext"=>"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2",
        "xmlns:qdt"=>"urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2",
        "xmlns:sac"=>"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1",
        "xmlns:udt"=>"urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2",
        "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance"
    );
    private $atributos_guia2_1=array(
        "xmlns"=>"urn:oasis:names:specification:ubl:schema:xsd:DespatchAdvice-2",
        "xmlns:cac"=>"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2",
        "xmlns:cbc"=>"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2",
        "xmlns:ccts"=>"urn:un:unece:uncefact:documentation:2",
        "xmlns:ds"=>"http://www.w3.org/2000/09/xmldsig#",
        "xmlns:ext"=>"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2",
        "xmlns:qdt"=>"urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2",
        "xmlns:sac"=>"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1",
        "xmlns:udt"=>"urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2",
        "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance"
    );
    private $atributos_nota_credito2_1=array(
        'xmlns'=>'urn:oasis:names:specification:ubl:schema:xsd:CreditNote-2',
        'xmlns:cac'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2',
        'xmlns:cbc'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2',
        'xmlns:ccts'=>'urn:un:unece:uncefact:documentation:2',
        'xmlns:ds'=>"http://www.w3.org/2000/09/xmldsig#",
        'xmlns:ext'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2',
        'xmlns:qdt'=>'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2',
        'xmlns:sac'=>'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1',
        'xmlns:udt'=>'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2',
        'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance'
    );
    private $atributos_nota_debito2_1=array(
        'xmlns'=>'urn:oasis:names:specification:ubl:schema:xsd:DebitNote-2',
        'xmlns:cac'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2',
        'xmlns:cbc'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2',
        'xmlns:ccts'=>'urn:un:unece:uncefact:documentation:2',
        'xmlns:ds'=>"http://www.w3.org/2000/09/xmldsig#",
        'xmlns:ext'=>'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2',
        'xmlns:qdt'=>'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2',
        'xmlns:sac'=>'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1',
        'xmlns:udt'=>'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2',
        'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance'
    );
    private $atributos_comunicacion_baja2_0=array(
        "xmlns"=>"urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1",
        "xmlns:cac"=>"urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2",
        "xmlns:cbc"=>"urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2",
        "xmlns:ds"=>"http://www.w3.org/2000/09/xmldsig#",
        "xmlns:ext"=>"urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2",
        "xmlns:sac"=>"urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1",
        "xmlns:udt"=>"urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2",
        "xmlns:xsi"=>"http://www.w3.org/2001/XMLSchema-instance"
    );
    function factura_venta($array){
        $xml = new DomDocument("1.0", "ISO-8859-1"); 
        
        $Invoice=$xml->createElement('Invoice'); 
        $Invoice = $xml->appendChild($Invoice);
        $this->inyectar_atributo($xml,$Invoice);
            $UBLExtensions = $xml->createElement('ext:UBLExtensions'); 
            $UBLExtensions = $Invoice->appendChild($UBLExtensions);
                $UBLExtension=$xml->createElement('ext:UBLExtension'); 
                $UBLExtension =$UBLExtensions->appendChild($UBLExtension);
                    $ExtensionContent=$xml->createElement('ext:ExtensionContent'); 
                    $ExtensionContent =$UBLExtension->appendChild($ExtensionContent);
                $UBLExtension=$xml->createElement('ext:UBLExtension'); 
                $UBLExtension =$UBLExtensions->appendChild($UBLExtension);
                    $ExtensionContent=$xml->createElement('ext:ExtensionContent'); 
                    $ExtensionContent =$UBLExtension->appendChild($ExtensionContent);
                        $AdditionalInformation=$xml->createElement('sac:AdditionalInformation');
                        $AdditionalInformation=$ExtensionContent->appendChild($AdditionalInformation);
                            $AdditionalMonetaryTotal=$xml->createElement('sac:AdditionalMonetaryTotal');
                            $AdditionalMonetaryTotal=$AdditionalInformation->appendChild($AdditionalMonetaryTotal);
                            $ID=$xml->createElement('cbc:ID','1001');
                            $ID=$AdditionalMonetaryTotal->appendChild($ID);
                            $PayableAmount=$xml->createElement('cbc:PayableAmount',$array['Gravadas']);
                            $PayableAmount=$AdditionalMonetaryTotal->appendChild($PayableAmount);
                            $currencyID=$xml->createAttribute('currencyID');
                            $currencyID->value=$array['Moneda'];
                            $PayableAmount->appendChild($currencyID);
                                
                        $AdditionalProperty=$xml->createElement('sac:AdditionalProperty');
                        $AdditionalProperty=$AdditionalInformation->appendChild($AdditionalProperty);
                            $ID=$xml->createElement('cbc:ID');
                            $ID=$AdditionalProperty->appendChild($ID);
                                $IDs=$xml->createTextNode('1000');
                                $IDs =$ID->appendChild($IDs);
                            $Value=$xml->createElement('cbc:Value');
                            $Value=$AdditionalProperty->appendChild($Value);
                                $monto_letra=$xml->createTextNode($array['MontoEnLetras']);
                                $monto_letra =$Value->appendChild($monto_letra);
                            
            $UBLVersionID=$xml->createElement('cbc:UBLVersionID','2.0'); 
            $UBLVersionID =$Invoice->appendChild($UBLVersionID);
            $CustomizationID=$xml->createElement('cbc:CustomizationID','1.0'); 
            $CustomizationID =$Invoice->appendChild($CustomizationID);
            
            $ID=$xml->createElement('cbc:ID',$array['IdDocumento']); 
            $ID =$Invoice->appendChild($ID);
            
            $IssueDate=$xml->createElement('cbc:IssueDate'); 
            $IssueDate =$Invoice->appendChild($IssueDate);
                $fecha_emision=$xml->createTextNode($array['FechaEmision']);
                $fecha_emision =$IssueDate->appendChild($fecha_emision);
            $InvoiceTypeCode=$xml->createElement('cbc:InvoiceTypeCode',$array['TipoDocumento']); 
            $InvoiceTypeCode =$Invoice->appendChild($InvoiceTypeCode);
            $DocumentCurrencyCode=$xml->createElement('cbc:DocumentCurrencyCode',$array['Moneda']); 
            $DocumentCurrencyCode =$Invoice->appendChild($DocumentCurrencyCode);
            
            /*$PaymentMeans=$xml->createElement('cac:PaymentMeans'); 
            $PaymentMeans =$Invoice->appendChild($PaymentMeans);
                $PaymentDueDate=$xml->createElement('cbc:PaymentDueDate'); 
                $PaymentDueDate =$PaymentMeans->appendChild($PaymentDueDate);
                    $fecha_vencimiento=$xml->createTextNode($array['FechaVencimiento']);
                    $fecha_vencimiento =$PaymentDueDate->appendChild($fecha_vencimiento);*/
            $Signature=$xml->createElement('cac:Signature'); 
            $Signature =$Invoice->appendChild($Signature);
                $ID=$xml->createElement('cbc:ID','IDSignKG'); 
                $ID =$Signature->appendChild($ID);
                $SignatoryParty=$xml->createElement('cac:SignatoryParty'); 
                $SignatoryParty =$Signature->appendChild($SignatoryParty);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification =$SignatoryParty->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',$array['Emisor']['NroDocumento']); 
                        $ID =$PartyIdentification->appendChild($ID);
                    $PartyName=$xml->createElement('cac:PartyName'); 
                    $PartyName =$SignatoryParty->appendChild($PartyName);
                        $Name=$xml->createElement('cbc:Name'); 
                        $Name =$PartyName->appendChild($Name);
                            $nombre_legal=$xml->createCDATASection($array['Emisor']['NombreLegal']);
                            $nombre_legal=$Name->appendChild($nombre_legal);
                $DigitalSignatureAttachment=$xml->createElement('cac:DigitalSignatureAttachment'); 
                $DigitalSignatureAttachment =$Signature->appendChild($DigitalSignatureAttachment);
                    $ExternalReference=$xml->createElement('cac:ExternalReference'); 
                    $ExternalReference =$DigitalSignatureAttachment->appendChild($ExternalReference);
                        $URI=$xml->createElement('cbc:URI','#signatureKG'); 
                        $URI =$ExternalReference->appendChild($URI);
            $AccountingSupplierParty=$xml->createElement('cac:AccountingSupplierParty'); 
            $AccountingSupplierParty =$Invoice->appendChild($AccountingSupplierParty);
                $CustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID',$array['Emisor']['NroDocumento']); 
                $CustomerAssignedAccountID =$AccountingSupplierParty->appendChild($CustomerAssignedAccountID);
                $AdditionalAccountID=$xml->createElement('cbc:AdditionalAccountID',$array['Emisor']['TipoDocumento']); 
                $AdditionalAccountID =$AccountingSupplierParty->appendChild($AdditionalAccountID);
                $Party=$xml->createElement('cac:Party'); 
                $Party =$AccountingSupplierParty->appendChild($Party); 
                    $PartyName=$xml->createElement('cac:PartyName'); 
                    $PartyName =$Party->appendChild($PartyName);
                        $Name=$xml->createElement('cbc:Name'); 
                        $Name =$PartyName->appendChild($Name);
                            $nombre_comercial=$xml->createCDATASection($array['Emisor']['NombreComercial']);
                            $nombre_comercial=$Name->appendChild($nombre_comercial);
                    $PostalAddress=$xml->createElement('cac:PostalAddress'); 
                    $PostalAddress =$Party->appendChild($PostalAddress);
                        $ID=$xml->createElement('cbc:ID',$array['Emisor']['Ubigeo']); 
                        $ID =$PostalAddress->appendChild($ID);
                        $StreetName=$xml->createElement('cbc:StreetName'); 
                        $StreetName =$PostalAddress->appendChild($StreetName);
                            $direccion=$xml->createCDATASection($array['Emisor']['Direccion']);
                            $direccion=$StreetName->appendChild($direccion);
                        $CityName=$xml->createElement('cbc:CityName'); 
                        $CityName =$PostalAddress->appendChild($CityName);
                            $provincia=$xml->createTextNode($array['Emisor']['Provincia']);
                            $provincia=$CityName->appendChild($provincia);
                        $CountrySubentity=$xml->createElement('cbc:CountrySubentity'); 
                        $CountrySubentity =$PostalAddress->appendChild($CountrySubentity);
                            $departamento=$xml->createTextNode($array['Emisor']['Departamento']);
                            $departamento=$CountrySubentity->appendChild($departamento);
                        $District=$xml->createElement('cbc:District'); 
                        $District =$PostalAddress->appendChild($District);
                            $distrito=$xml->createTextNode($array['Emisor']['Distrito']);
                            $distrito=$District->appendChild($distrito);
                        $Country=$xml->createElement('cac:Country'); 
                        $Country =$PostalAddress->appendChild($Country);
                            $IdentificationCode=$xml->createElement('cbc:IdentificationCode',$array['Emisor']['Pais']); 
                            $IdentificationCode =$Country->appendChild($IdentificationCode);
                    $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                    $PartyLegalEntity =$Party->appendChild($PartyLegalEntity);
                        $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                        $RegistrationName =$PartyLegalEntity->appendChild($RegistrationName);
                            $nombre_legal=$xml->createCDATASection($array['Emisor']['NombreLegal']);
                            $nombre_legal=$RegistrationName->appendChild($nombre_legal);
        if(isset($array['Delivery']) && count($array['Delivery'])>0){
            $DeliveryTerms=$xml->createElement('cac:DeliveryTerms'); 
            $DeliveryTerms =$Invoice->appendChild($DeliveryTerms);
                $DeliveryLocation=$xml->createElement('cac:DeliveryLocation'); 
                $DeliveryLocation =$DeliveryTerms->appendChild($DeliveryLocation);
                    $Address=$xml->createElement('cac:Address'); 
                    $Address =$DeliveryLocation->appendChild($Address);
                        $StreetName=$xml->createElement('cbc:StreetName'); 
                        $StreetName =$Address->appendChild($StreetName);
                            $direccion=$xml->createComment($array['Delivery']['Direccion']);
                            $direccion=$StreetName->appendChild($direccion);
                        $CitySubdivisionName=$xml->createElement('cbc:CitySubdivisionName'); 
                        $CitySubdivisionName =$Address->appendChild($CitySubdivisionName);
                        $CityName=$xml->createElement('cbc:CityName'); 
                        $CityName =$Address->appendChild($CityName);
                            $provincia=$xml->createTextNode($array['Delivery']['Provincia']);
                            $provincia=$CityName->appendChild($provincia);
                        $PostalZone=$xml->createElement('cbc:PostalZone',$array['Delivery']['Ubigeo']); 
                        $PostalZone =$Address->appendChild($PostalZone);
                        $CountrySubentity=$xml->createElement('cbc:CountrySubentity'); 
                        $CountrySubentity =$Address->appendChild($CountrySubentity);
                            $Departamento=$xml->createTextNode($array['Delivery']['Departamento']);
                            $Departamento=$CountrySubentity->appendChild($Departamento);
                        $District=$xml->createElement('cbc:District'); 
                        $District =$Address->appendChild($District);
                            $Distrito=$xml->createTextNode($array['Delivery']['Distrito']);
                            $Distrito=$District->appendChild($Distrito);
                        $Country=$xml->createElement('cac:Country'); 
                        $Country =$Address->appendChild($Country);
                            $IdentificationCode=$xml->createElement('cbc:IdentificationCode',$array['Delivery']['Pais']); 
                            $IdentificationCode =$Address->appendChild($IdentificationCode);
                             
        }        
            $AccountingCustomerParty=$xml->createElement('cac:AccountingCustomerParty'); 
            $AccountingCustomerParty =$Invoice->appendChild($AccountingCustomerParty);
                $CustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID',$array['Receptor']['NroDocumento']); 
                $CustomerAssignedAccountID=$AccountingCustomerParty->appendChild($CustomerAssignedAccountID);
                $AdditionalAccountID=$xml->createElement('cbc:AdditionalAccountID',$array['Receptor']['TipoDocumento']); 
                $AdditionalAccountID =$AccountingCustomerParty->appendChild($AdditionalAccountID);
                $Party=$xml->createElement('cac:Party'); 
                $Party=$AccountingCustomerParty->appendChild($Party);
                    $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                    $PartyLegalEntity=$Party->appendChild($PartyLegalEntity);
                        $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                        $RegistrationName=$PartyLegalEntity->appendChild($RegistrationName);
                            $nombre_legal=$xml->createCDATASection($array['Receptor']['NombreLegal']);
                            $nombre_legal=$RegistrationName->appendChild($nombre_legal);
        if(isset($array['Relacionados']) && count($array['Relacionados'])>0 && $array['Relacionados']['NroDocumento']!=""){
            $DespatchDocumentReference=$xml->createElement('cac:DespatchDocumentReference'); 
            $DespatchDocumentReference =$Invoice->appendChild($DespatchDocumentReference);
                $ID=$xml->createElement('cbc:ID',$array['Relacionados']['NroDocumento']); 
                $ID =$DespatchDocumentReference->appendChild($ID);
                $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['Relacionados']['TipoDocumento']); 
                $DocumentTypeCode =$DespatchDocumentReference->appendChild($DocumentTypeCode);
        }
        if(isset($array['OtrosDocumentosRelacionados']) && count($array['OtrosDocumentosRelacionados'])>0 && $array['OtrosDocumentosRelacionados']['NroDocumento']!=""){
            $AdditionalDocumentReference=$xml->createElement('cac:AdditionalDocumentReference'); 
            $AdditionalDocumentReference =$Invoice->appendChild($AdditionalDocumentReference);
                $ID=$xml->createElement('cbc:ID',$array['OtrosDocumentosRelacionados']['NroDocumento']); 
                $ID =$DespatchDocumentReference->appendChild($ID);
                $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['OtrosDocumentosRelacionados']['TipoDocumento']); 
                $DocumentTypeCode =$DespatchDocumentReference->appendChild($DocumentTypeCode);
        }
            $TaxTotal=$xml->createElement('cac:TaxTotal'); 
            $TaxTotal =$Invoice->appendChild($TaxTotal);
                $TaxAmount=$xml->createElement('cbc:TaxAmount',$array['TotalIgv']); 
                $TaxAmount=$TaxTotal->appendChild($TaxAmount);
                $currencyID=$xml->createAttribute('currencyID');
                $currencyID->value=$array['Moneda'];
                $TaxAmount->appendChild($currencyID);
                $TaxSubtotal=$xml->createElement('cac:TaxSubtotal'); 
                $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                    $TaxAmount=$xml->createElement('cbc:TaxAmount',$array['TotalIgv']); 
                    $TaxAmount=$TaxSubtotal->appendChild($TaxAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $TaxAmount->appendChild($currencyID);
                    $TaxCategory=$xml->createElement('cac:TaxCategory'); 
                    $TaxCategory=$TaxSubtotal->appendChild($TaxCategory);
                        $TaxScheme=$xml->createElement('cac:TaxScheme'); 
                        $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                            $ID=$xml->createElement('cbc:ID','1000'); 
                            $ID=$TaxScheme->appendChild($ID);
                            $name=$xml->createElement('cbc:Name','IGV'); 
                            $name=$TaxScheme->appendChild($name);
                            $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','VAT'); 
                            $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);
            $LegalMonetaryTotal=$xml->createElement('cac:LegalMonetaryTotal'); 
            $LegalMonetaryTotal =$Invoice->appendChild($LegalMonetaryTotal);        
                $PayableAmount=$xml->createElement('cbc:PayableAmount',$array['TotalVenta']); 
                $PayableAmount=$LegalMonetaryTotal->appendChild($PayableAmount);
                $currencyID=$xml->createAttribute('currencyID');
                $currencyID->value=$array['Moneda'];
                $PayableAmount->appendChild($currencyID);
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
                $LineExtensionAmount=$xml->createElement('cbc:LineExtensionAmount',$items['TotalVenta']); 
                $LineExtensionAmount=$InvoiceLine->appendChild($LineExtensionAmount);
                $currencyID=$xml->createAttribute('currencyID');
                $currencyID->value=$array['Moneda'];
                $LineExtensionAmount->appendChild($currencyID);
                $PricingReference=$xml->createElement('cac:PricingReference');
                $PricingReference=$InvoiceLine->appendChild($PricingReference);
                    $AlternativeConditionPrice=$xml->createElement('cac:AlternativeConditionPrice');
                    $AlternativeConditionPrice=$PricingReference->appendChild($AlternativeConditionPrice);
                        $PriceAmount=$xml->createElement('cbc:PriceAmount','0.00');
                        $PriceAmount=$AlternativeConditionPrice->appendChild($PriceAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $PriceAmount->appendChild($currencyID);
                        $PriceTypeCode=$xml->createElement('cbc:PriceTypeCode',$items['TipoPrecio']);
                        $PriceTypeCode=$AlternativeConditionPrice->appendChild($PriceTypeCode);
                $TaxTotal=$xml->createElement('cac:TaxTotal');
                $TaxTotal=$InvoiceLine->appendChild($TaxTotal);
                    $TaxAmount=$xml->createElement('cbc:TaxAmount',$items['Impuesto']);
                    $TaxAmount=$TaxTotal->appendChild($TaxAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $TaxAmount->appendChild($currencyID);
                    $TaxSubtotal=$xml->createElement('cac:TaxSubtotal');
                    $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                    
                        $TaxAmount=$xml->createElement('cbc:TaxAmount',$items['Impuesto']);
                        $TaxAmount=$TaxSubtotal->appendChild($TaxAmount);
                        $currencyID=$xml->createAttribute('currencyID');
                        $currencyID->value=$array['Moneda'];
                        $TaxAmount->appendChild($currencyID);
                        
                        $TaxCategory=$xml->createElement('cac:TaxCategory');
                        $TaxCategory=$TaxSubtotal->appendChild($TaxCategory);



                            $TaxExemptionReasonCode=$xml->createElement('cbc:TaxExemptionReasonCode',$items['TipoImpuesto']);
                            $TaxExemptionReasonCode=$TaxCategory->appendChild($TaxExemptionReasonCode);
                            $TaxScheme=$xml->createElement('cac:TaxScheme');
                            $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                                $ID=$xml->createElement('cbc:ID','1000');
                                $ID=$TaxScheme->appendChild($ID);
                                $Name=$xml->createElement('cbc:Name','IGV');
                                $Name=$TaxScheme->appendChild($Name);
                                $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','VAT');
                                $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);
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
                    $PriceAmount=$xml->createElement('cbc:PriceAmount',$items['PrecioUnitario']);
                    $PriceAmount=$Price->appendChild($PriceAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $PriceAmount->appendChild($currencyID);
        }    
            
        $xml->formatOutput = true;
        return $xml;
    }
    function guia_venta($array){
        $xml = new DomDocument("1.0", "ISO-8859-1"); 
        
        $DespatchAdvice=$xml->createElement('DespatchAdvice'); 
        $DespatchAdvice = $xml->appendChild($DespatchAdvice);
        $this->inyectar_atributo_guia($xml,$DespatchAdvice);
            
                
                            
            $UBLVersionID=$xml->createElement('cbc:UBLVersionID','2.0'); 
            $UBLVersionID =$DespatchAdvice->appendChild($UBLVersionID);
            $CustomizationID=$xml->createElement('cbc:CustomizationID','1.0'); 
            $CustomizationID =$DespatchAdvice->appendChild($CustomizationID);
            
            $ID=$xml->createElement('cbc:ID',$array['IdDocumento']); 
            $ID =$DespatchAdvice->appendChild($ID);
            
                    
            $IssueDate=$xml->createElement('cbc:IssueDate'); 
            $IssueDate =$DespatchAdvice->appendChild($IssueDate);
                $fecha_emision=$xml->createTextNode($array['FechaEmision']);
                $fecha_emision =$IssueDate->appendChild($fecha_emision);

            
            $DespatchAdviceTypeCode=$xml->createElement('cbc:DespatchAdviceTypeCode',$array['TipoDocumento']); 
            $DespatchAdviceTypeCode =$DespatchAdvice->appendChild($DespatchAdviceTypeCode);
            if($array['Observacion']!=""){
            $note=$xml->createElement('cbc:Note');
            $note=$DespatchAdvice->appendChild($note);
                $observacion=$xml->createTextNode($array['Observacion']);
                $note->appendChild($observacion);
            }
        if($array['DocumentoRelacionado']['NroDocumento']!=""){
            $AdditionalDocumentReference=$xml->createElement('cac:AdditionalDocumentReference'); 
            $AdditionalDocumentReference =$DespatchAdvice->appendChild($AdditionalDocumentReference);
                $ID=$xml->createElement("cbc:ID",$array['DocumentoRelacionado']['NroDocumento']);
                $ID=$AdditionalDocumentReference->appendChild($ID);
                $DocumentTypeCode=$xml->createElement("cbc:DocumentTypeCode",$array['DocumentoRelacionado']['TipoDocumento']);
                $DocumentTypeCode=$AdditionalDocumentReference->appendChild($DocumentTypeCode);
        }
            $UBLExtensions = $xml->createElement('ext:UBLExtensions'); 
            $UBLExtensions = $DespatchAdvice->appendChild($UBLExtensions);
                $UBLExtension=$xml->createElement('ext:UBLExtension'); 
                $UBLExtension =$UBLExtensions->appendChild($UBLExtension);
                    $ExtensionContent=$xml->createElement('ext:ExtensionContent'); 
                    $ExtensionContent =$UBLExtension->appendChild($ExtensionContent);
            
            $Signature=$xml->createElement('cac:Signature'); 
            $Signature =$DespatchAdvice->appendChild($Signature);
                $ID=$xml->createElement('cbc:ID','IDSignKG'); 
                $ID =$Signature->appendChild($ID);
                $SignatoryParty=$xml->createElement('cac:SignatoryParty'); 
                $SignatoryParty =$Signature->appendChild($SignatoryParty);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification =$SignatoryParty->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',$array['Remitente']['NroDocumento']); 
                        $ID =$PartyIdentification->appendChild($ID);
                    $PartyName=$xml->createElement('cac:PartyName'); 
                    $PartyName =$SignatoryParty->appendChild($PartyName);
                        $Name=$xml->createElement('cbc:Name'); 
                        $Name =$PartyName->appendChild($Name);
                            $nombre_legal=$xml->createCDATASection($array['Remitente']['NombreLegal']);
                            $nombre_legal=$Name->appendChild($nombre_legal);
                $DigitalSignatureAttachment=$xml->createElement('cac:DigitalSignatureAttachment'); 
                $DigitalSignatureAttachment =$Signature->appendChild($DigitalSignatureAttachment);
                    $ExternalReference=$xml->createElement('cac:ExternalReference'); 
                    $ExternalReference =$DigitalSignatureAttachment->appendChild($ExternalReference);
                        $URI=$xml->createElement('cbc:URI','#signatureKG'); 
                        $URI =$ExternalReference->appendChild($URI);
                        
            $DespatchSupplierParty=$xml->createElement('cac:DespatchSupplierParty'); 
            $DespatchSupplierParty =$DespatchAdvice->appendChild($DespatchSupplierParty);
                $CustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID',$array['Remitente']['NroDocumento']); 
                $CustomerAssignedAccountID =$DespatchSupplierParty->appendChild($CustomerAssignedAccountID);
                    $schemeID=$xml->createAttribute("schemeID");
                    $schemeID->value=$array['Remitente']['TipoDocumento'];
                    $CustomerAssignedAccountID->appendChild($schemeID);
                $Party=$xml->createElement('cac:Party'); 
                $Party =$DespatchSupplierParty->appendChild($Party);
                    $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                    $PartyLegalEntity=$Party->appendChild($PartyLegalEntity);
                        $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                        $RegistrationName =$PartyLegalEntity->appendChild($RegistrationName);
                            $razon_social=$xml->createCDATASection($array['Remitente']['NombreLegal']);
                            $razon_social=$RegistrationName->appendChild($razon_social);
            $DeliveryCustomerParty=$xml->createElement('cac:DeliveryCustomerParty'); 
            $DeliveryCustomerParty =$DespatchAdvice->appendChild($DeliveryCustomerParty);
                $CustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID',$array['Destinatario']['NroDocumento']); 
                $CustomerAssignedAccountID =$DeliveryCustomerParty->appendChild($CustomerAssignedAccountID);
                    $schemeID=$xml->createAttribute("schemeID");
                    $schemeID->value=$array['Destinatario']['TipoDocumento'];
                    $CustomerAssignedAccountID->appendChild($schemeID);
                $Party=$xml->createElement('cac:Party'); 
                $Party =$DeliveryCustomerParty->appendChild($Party);
                    $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                    $PartyLegalEntity =$Party->appendChild($PartyLegalEntity);
                        $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                        $RegistrationName =$PartyLegalEntity->appendChild($RegistrationName);
                            $razon_social=$xml->createCDATASection($array['Destinatario']['NombreLegal']);
                            $razon_social=$RegistrationName->appendChild($razon_social);
            if($array['Proveedor']['NroDocumento']!=""){
            $SellerSupplierParty=$xml->createElement('cac:SellerSupplierParty'); 
            $SellerSupplierParty =$DespatchAdvice->appendChild($SellerSupplierParty);
                $CustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID',$array['Proveedor']['NroDocumento']); 
                $CustomerAssignedAccountID =$SellerSupplierParty->appendChild($CustomerAssignedAccountID);
                    $schemeID=$xml->createAttribute("schemeID");
                    $schemeID->value=$array['Proveedor']['TipoDocumento'];
                    $CustomerAssignedAccountID->appendChild($schemeID);
                    $Party=$xml->createElement('cac:Party'); 
                $Party =$SellerSupplierParty->appendChild($Party);
                $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                $PartyLegalEntity =$Party->appendChild($PartyLegalEntity);
                    $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                    $RegistrationName =$PartyLegalEntity->appendChild($RegistrationName);
                        $razon_social=$xml->createCDATASection($array['Proveedor']['NombreLegal']);
                        $razon_social=$RegistrationName->appendChild($razon_social);
            }          
            $Shipment=$xml->createElement('cac:Shipment'); 
            $Shipment =$DespatchAdvice->appendChild($Shipment);
                $HandlingCode=$xml->createElement('cbc:HandlingCode',$array['CodigoMotivoTraslado']); 
                $HandlingCode =$Shipment->appendChild($HandlingCode);
                $Information=$xml->createElement('cbc:Information'); 
                $Information =$Shipment->appendChild($Information);
                    $descripcion_motivo=$xml->createCDATASection($array['DescripcionMotivo']);
                    $Information->appendChild($descripcion_motivo);
                $SplitConsignmentIndicator=$xml->createElement('cbc:SplitConsignmentIndicator',$array['Transbordo']); 
                $SplitConsignmentIndicator =$Shipment->appendChild($SplitConsignmentIndicator);
                $GrossWeightMeasure=$xml->createElement('cbc:GrossWeightMeasure',$array['PesoBrutoTotal']); 
                $GrossWeightMeasure =$Shipment->appendChild($GrossWeightMeasure);
                    $unitCode=$xml->createAttribute("unitCode");
                    $unitCode->value=$array['UnidadMedida'];
                    $GrossWeightMeasure->appendChild($unitCode);
                $TotalTransportHandlingUnitQuantity=$xml->createElement('cbc:TotalTransportHandlingUnitQuantity',$array['NroPallets']); 
                $TotalTransportHandlingUnitQuantity =$Shipment->appendChild($TotalTransportHandlingUnitQuantity);
                $ShipmentStage=$xml->createElement('cac:ShipmentStage'); 
                $ShipmentStage =$Shipment->appendChild($ShipmentStage);
                    $TransportModeCode=$xml->createElement('cbc:TransportModeCode',$array['ModalidadTraslado']); 
                    $TransportModeCode =$ShipmentStage->appendChild($TransportModeCode);
                    $TransitPeriod=$xml->createElement('cac:TransitPeriod'); 
                    $TransitPeriod =$ShipmentStage->appendChild($TransitPeriod);
                        $StartDate=$xml->createElement('cbc:StartDate',$array['FechaInicioTraslado']); 
                        $StartDate =$TransitPeriod->appendChild($StartDate);
                if($array['ModalidadTraslado']=="01"){
                    //Transportista (Transporte Público)
                    $CarrierParty=$xml->createElement('cac:CarrierParty'); 
                    $CarrierParty=$ShipmentStage->appendChild($CarrierParty);
                        $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                        $PartyIdentification=$CarrierParty->appendChild($PartyIdentification);
                            $ID=$xml->createElement('cbc:ID',$array['RucTransportista']);
                            $ID=$PartyIdentification->appendChild($ID);    
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value='6';
                                $ID->appendChild($schemeID);
                        $PartyName=$xml->createElement('cac:PartyName'); 
                        $PartyName=$CarrierParty->appendChild($PartyName);
                            $Name=$xml->createElement('cbc:Name'); 
                            $Name=$PartyName->appendChild($Name);
                                $razon_social_transportista=$xml->createCDATASection($array['RazonSocialTransportista']);
                                $Name->appendChild($razon_social_transportista);
                        
                }else if($array['ModalidadTraslado']=="02"){
                    $TransportMeans=$xml->createElement('cac:TransportMeans'); 
                    $TransportMeans=$ShipmentStage->appendChild($TransportMeans);
                        $RoadTransport=$xml->createElement('cac:RoadTransport'); 
                        $RoadTransport=$TransportMeans->appendChild($RoadTransport);

                        $LicensePlateID=$xml->createElement('cbc:LicensePlateID',$array['NroPlacaVehiculo']);
                        $LicensePlateID=$RoadTransport->appendChild($LicensePlateID);
                    $DriverPerson=$xml->createElement('cac:DriverPerson'); 
                    $DriverPerson =$ShipmentStage->appendChild($DriverPerson);
                        $ID=$xml->createElement("cbc:ID",$array['NroDocumentoConductor']);
                        $ID=$DriverPerson->appendChild($ID);
                        $schemeID=$xml->createAttribute("schemeID");
                        $schemeID->value='1';
                        $ID->appendChild($schemeID);    
                }    
                    
                $Delivery=$xml->createElement("cac:Delivery");
                $Delivery=$Shipment->appendChild($Delivery);
                    $DeliveryAddress=$xml->createElement('cac:DeliveryAddress'); 
                    $DeliveryAddress =$Delivery->appendChild($DeliveryAddress);
                        $ID=$xml->createElement('cbc:ID',$array['DireccionLlegada']['Ubigeo']);
                        $ID=$DeliveryAddress->appendChild($ID);
                        $StreetName=$xml->createElement('cbc:StreetName');
                        $StreetName=$DeliveryAddress->appendChild($StreetName);
                            $direccion_llegada=$xml->createCDATASection($array['DireccionLlegada']['DireccionCompleta']);
                            $StreetName->appendChild($direccion_llegada);
                        
                
                if($array['CodigoMotivoTraslado']=='07'){
                    //MOTIVO IMPORTACION
                $TransportHandlingUnit=$xml->createElement('cac:TransportHandlingUnit'); 
                $TransportHandlingUnit=$Shipment->appendChild($TransportHandlingUnit);
                    $ID=$xml->createElement('cbc:ID');
                    $ID=$TransportHandlingUnit->appendChild($ID,$array['NumeroContenedor']);
                   
                }    
                
                    
                $OriginAddress=$xml->createElement('cac:OriginAddress'); 
                $OriginAddress=$Shipment->appendChild($OriginAddress);
                    $ID=$xml->createElement('cbc:ID',$array['DireccionPartida']['Ubigeo']);
                    $ID=$OriginAddress->appendChild($ID);
                    $StreetName=$xml->createElement('cbc:StreetName');
                    $StreetName=$OriginAddress->appendChild($StreetName);
                        $direccion_partida=$xml->createCDATASection($array['DireccionPartida']['DireccionCompleta']);
                        $StreetName->appendChild($direccion_partida);
            if($array['CodigoPuerto']!=""){
                $FirstArrivalPortLocation=$xml->createElement('cac:FirstArrivalPortLocation');
                $FirstArrivalPortLocation=$Shipment->appendChild($FirstArrivalPortLocation);
                    $ID=$xml->createElement("cbc:ID",$array['CodigoPuerto']);
                    $ID=$FirstArrivalPortLocation->appendChild($ID);
            }        
                /*$LoadingPortLocation=$xml->createElement('cac:LoadingPortLocation'); 
                $LoadingPortLocation=$Shipment->appendChild($LoadingPortLocation);
                    $ID=$xml->createElement('cbc:ID',$array['CodigoPuerto']);
                    $ID=$LoadingPortLocation->appendChild($ID);
                    $Description=$xml->createElement('cbc:Description');
                    $Description=$LoadingPortLocation->appendChild($Description);
                    $descripcion_puerto=$xml->createCDATASection($array['DescripcionPuerto']);
                    $Description->appendChild($descripcion_puerto);*/
        foreach($array['BienesATransportar'] as $items){
            
            $DespatchLine=$xml->createElement('cac:DespatchLine'); 
            $DespatchLine=$DespatchAdvice->appendChild($DespatchLine);
                $ID=$xml->createElement("cbc:ID",$items['Correlativo']);
                $ID=$DespatchLine->appendChild($ID);
                $OrderLineReference=$xml->createElement('cac:OrderLineReference');
                $OrderLineReference=$DespatchLine->appendChild($OrderLineReference);
                    $ID=$xml->createElement('cbc:ID',$items['Correlativo']); 
                    $ID=$OrderLineReference->appendChild($ID);
                
                $DeliveredQuantity=$xml->createElement('cbc:DeliveredQuantity',$items['Cantidad']); 
                $DeliveredQuantity=$DespatchLine->appendChild($DeliveredQuantity);
                    $unitCode=$xml->createAttribute("unitCode");
                    $unitCode->value=$items['UnidadMedida'];
                    $DeliveredQuantity->appendChild($unitCode);
                
                    
                /*$OrderLineReference=$xml->createElement('cac:OrderLineReference'); 
                $OrderLineReference=$DespatchLine->appendChild($OrderLineReference);
                    $LineID=$xml->createElement('cbc:LineID','1'); 
                    $LineID=$OrderLineReference->appendChild($LineID);*/
                $Item=$xml->createElement('cac:Item'); 
                $Item=$DespatchLine->appendChild($Item);
                    $name=$xml->createElement("cbc:Description");
                    $name=$Item->appendChild($name);
                        $Description=$xml->createCDATASection($items['Descripcion']); 
                        $name->appendChild($Description);
                    
                        
                    $SellersItemIdentification=$xml->createElement('cac:SellersItemIdentification'); 
                    $SellersItemIdentification=$Item->appendChild($SellersItemIdentification);
                        $ID=$xml->createElement('cbc:ID',$items['CodigoItem']); 
                        $ID=$SellersItemIdentification->appendChild($ID);
        }   
        $xml->formatOutput = true;
        return $xml;
    }
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
            $ProfileID=$xml->createElement('cbc:ProfileID','0101');
            $ProfileID=$Invoice->appendChild($ProfileID);
                $schemeName=$xml->createAttribute('schemeName');
                $schemeName->value='SUNAT:Identificador de Tipo de Operación';
                $ProfileID->appendChild($schemeName);
                $schemeAgencyName=$xml->createAttribute("schemeAgencyName");
                $schemeAgencyName->value='PE:SUNAT';
                $ProfileID->appendChild($schemeAgencyName);
                $schemeURI=$xml->createAttribute('schemeURI');
                $schemeURI->value='urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17';
                $ProfileID->appendChild($schemeURI);
                
            
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
                $listAgencyName=$xml->createAttribute("listAgencyName");
                $listAgencyName->value="PE:SUNAT";
                $InvoiceTypeCode->appendChild($listAgencyName);
                $listName=$xml->createAttribute("listName");
                $listName->value="SUNAT:Identificador de Tipo de Documento";
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
                $listName->value='SUNAT:Identificador de Tipo de Documento';
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
                    $listName=$xml->createAttribute("listName");
                    $listName->value="Documento Relacionado";
                    $DocumentTypeCode->appendChild($listName);
                    $listAgencyName=$xml->createAttribute("listAgencyName");
                    $listAgencyName->value="PE:SUNAT";
                    $DocumentTypeCode->appendChild($listAgencyName);
                    $listURI=$xml->createAttribute("listURI");
                    $listURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo12";
                    $DocumentTypeCode->appendChild($listURI);
                $DocumentStatusCode=$xml->createElement('cbc:DocumentStatusCode',$array['Relacionados']['NroDocumento']); 
                $DocumentStatusCode=$AdditionalDocumentReference->appendChild($DocumentStatusCode);
                    $listName=$xml->createAttribute("listName");
                    $listName->value="Anticipo";
                    $DocumentTypeCode->appendChild($listName);
                    $listAgencyName=$xml->createAttribute("listAgencyName");
                    $listAgencyName->value="PE:SUNAT";
                    $DocumentTypeCode->appendChild($listAgencyName);
                $IssuerParty=$xml->createElement('cac:IssuerParty'); 
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
                            $ID->appendChild($schemeURI);
                    
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
                            $schemeName->value="SUNAT:Identificador de Documento de Identidad";
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
                            $AddressTypeCode=$xml->createElement('cbc:AddressTypeCode','0000'); 
                            $AddressTypeCode=$RegistrationAddress->appendChild($AddressTypeCode);
                    
                    
            $AccountingCustomerParty=$xml->createElement('cac:AccountingCustomerParty'); 
            $AccountingCustomerParty=$Invoice->appendChild($AccountingCustomerParty);
                $Party=$xml->createElement('cac:Party'); 
                $Party=$AccountingCustomerParty->appendChild($Party);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification=$Party->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',$array['Receptor']['NroDocumento']); 
                        $ID=$PartyIdentification->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="6";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="SUNAT:Identificador de Documento de Identidad";
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
                            $nombre_legal=$xml->createCDATASection($array['Receptor']['NombreLegal']);
                            $RegistrationName->appendChild($nombre_legal);
                            
          
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
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5153";
                                $ID->appendChild($schemeID);
                                $schemeAgencyID=$xml->createAttribute("schemeAgencyID");
                                $schemeAgencyID->value="6";
                                $ID->appendChild($schemeAgencyID);
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
                            $listName->value="SUNAT:Indicador de Tipo de Precio";
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
                            $ID=$xml->createElement('cbc:ID',$items['codigo_categoria']);
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
                            $Percent=$xml->createElement('cbc:Percent',$array['porcentajeIgv']);
                            $Percent=$TaxCategory->appendChild($Percent);
                            
                            $TaxExemptionReasonCode=$xml->createElement('cbc:TaxExemptionReasonCode',$items['TipoImpuesto']);
                            $TaxExemptionReasonCode=$TaxCategory->appendChild($TaxExemptionReasonCode);
                                $listAgencyName=$xml->createAttribute("listAgencyName");
                                $listAgencyName->value="PE:SUNAT";
                                $TaxExemptionReasonCode->appendChild($listAgencyName);
                                $listName=$xml->createAttribute("listName");
                                $listName->value="SUNAT:Codigo de Tipo de Afectación del IGV";
                                $TaxExemptionReasonCode->appendChild($listName);
                                $listURI=$xml->createAttribute("listURI");
                                $listURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07";
                                $TaxExemptionReasonCode->appendChild($listURI);
                                
                            $TaxScheme=$xml->createElement('cac:TaxScheme');
                            $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                                $ID=$xml->createElement('cbc:ID',$items['tipo_tributo_codigo']);
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
    function nota_credito_UBL2_1($array){
        $xml = new DomDocument("1.0", "ISO-8859-1"); 
        
        $CreditNote=$xml->createElement('CreditNote'); 
        $CreditNote=$xml->appendChild($CreditNote);
        $this->inyectar_atributo_nota_credito2_1($xml,$CreditNote);
            $UBLExtensions = $xml->createElement('ext:UBLExtensions'); 
            $UBLExtensions = $CreditNote->appendChild($UBLExtensions);
                $UBLExtension=$xml->createElement('ext:UBLExtension'); 
                $UBLExtension =$UBLExtensions->appendChild($UBLExtension);
                    $ExtensionContent=$xml->createElement('ext:ExtensionContent'); 
                    $ExtensionContent =$UBLExtension->appendChild($ExtensionContent);
                                             
            $UBLVersionID=$xml->createElement('cbc:UBLVersionID','2.1'); 
            $UBLVersionID =$CreditNote->appendChild($UBLVersionID);
            $CustomizationID=$xml->createElement('cbc:CustomizationID','2.0'); 
            $CustomizationID =$CreditNote->appendChild($CustomizationID);
           
            $ID=$xml->createElement('cbc:ID',$array['IdDocumento']); 
            $ID =$CreditNote->appendChild($ID);
            $IssueDate=$xml->createElement('cbc:IssueDate',$array['FechaEmision']); 
            $IssueDate=$CreditNote->appendChild($IssueDate);
            $IssueTime=$xml->createElement('cbc:IssueTime',$array['HoraEmision']); 
            $IssueTime=$CreditNote->appendChild($IssueTime);
            $Note=$xml->createElement('cbc:Note'); 
            $Note=$CreditNote->appendChild($Note);
                $languageLocaleID=$xml->createAttribute("languageLocaleID");
                $languageLocaleID->value="3000";
                $Note->appendChild($languageLocaleID);
                $total_texto=$xml->createTextNode('0501002017062500125');
                $Note->appendChild($total_texto);
            $DocumentCurrencyCode=$xml->createElement('cbc:DocumentCurrencyCode',$array['Moneda']); 
            $DocumentCurrencyCode=$CreditNote->appendChild($DocumentCurrencyCode);
            $DiscrepancyResponse=$xml->createElement('cac:DiscrepancyResponse'); 
            $DiscrepancyResponse=$CreditNote->appendChild($DiscrepancyResponse);
                $ReferenceID=$xml->createElement('cbc:ReferenceID',$array['Discrepancias'][0]['NroReferencia']); 
                $ReferenceID=$DiscrepancyResponse->appendChild($ReferenceID);
                $ResponseCode=$xml->createElement('cbc:ResponseCode',$array['TipoOperacion']); 
                $ResponseCode=$DiscrepancyResponse->appendChild($ResponseCode);
                $Description=$xml->createElement('cbc:Description'); 
                $Description=$DiscrepancyResponse->appendChild($Description);
                    $Motivo=$xml->createCDATASection($array['Discrepancias'][0]['Descripcion']);
                    $Description->appendChild($Motivo);///error
            $BillingReference=$xml->createElement('cac:BillingReference'); 
            $BillingReference=$CreditNote->appendChild($BillingReference);        
                $InvoiceDocumentReference=$xml->createElement('cac:InvoiceDocumentReference'); 
                $InvoiceDocumentReference=$BillingReference->appendChild($InvoiceDocumentReference);
                    $ID=$xml->createElement('cbc:ID',$array['Discrepancias'][0]['NroReferencia']); 
                    $ID=$InvoiceDocumentReference->appendChild($ID);    
                    $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['Discrepancias'][0]['Tipo']); 
                    $DocumentTypeCode=$InvoiceDocumentReference->appendChild($DocumentTypeCode);
        if(isset($array['Relacionados'][0]['NroDocumento'])&& $array['Relacionados'][0]['NroDocumento']!=""){
            //Documento de referencia
            //Tipo y número de la guía de remisión relacionada con la operación
            $DespatchDocumentReference=$xml->createElement('cac:DespatchDocumentReference'); 
            $DespatchDocumentReference=$CreditNote->appendChild($DespatchDocumentReference);
                $ID=$xml->createElement('cbc:ID',$array['Relacionados']['NroDocumento']); 
                $ID=$DespatchDocumentReference->appendChild($ID);
                $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['Relacionados'][0]['TipoDocumento']); 
                $DocumentTypeCode=$DespatchDocumentReference->appendChild($DocumentTypeCode);
        }    
        if(isset($array['OtrosDocumentosRelacionados'][0]['NroDocumento'])&& $array['OtrosDocumentosRelacionados'][0]['NroDocumento']!=""){
            //Tipo y número de otro documento y
            //código relacionado con la operación
            $AdditionalDocumentReference=$xml->createElement('cac:AdditionalDocumentReference'); 
            $AdditionalDocumentReference=$CreditNote->appendChild($AdditionalDocumentReference);
                $ID=$xml->createElement('cbc:ID',$array['OtrosDocumentosRelacionados']['NroDocumento']); 
                $ID=$AdditionalDocumentReference->appendChild($ID);
                $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['OtrosDocumentosRelacionados']['TipoDocumento']); 
                $DocumentTypeCode=$AdditionalDocumentReference->appendChild($DocumentTypeCode);
        }            
            $Signature=$xml->createElement('cac:Signature'); 
            $Signature=$CreditNote->appendChild($Signature);
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
                            
            $AccountingSupplierParty=$xml->createElement('cac:AccountingSupplierParty'); 
            $AccountingSupplierParty=$CreditNote->appendChild($AccountingSupplierParty);
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
                            $schemeName->value="SUNAT:Identificador de Documento de Identidad";
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
                            $AddressTypeCode=$xml->createElement('cbc:AddressTypeCode',$array['Emisor']['Ubigeo']); 
                            $AddressTypeCode=$RegistrationAddress->appendChild($AddressTypeCode);
                    
                   
            $AccountingCustomerParty=$xml->createElement('cac:AccountingCustomerParty'); 
            $AccountingCustomerParty=$CreditNote->appendChild($AccountingCustomerParty);
                $Party=$xml->createElement('cac:Party'); 
                $Party=$AccountingCustomerParty->appendChild($Party);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification=$Party->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',$array['Receptor']['NroDocumento']); 
                        $ID=$PartyIdentification->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="6";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="SUNAT:Identificador de Documento de Identidad";
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
                            $nombre_legal=$xml->createCDATASection($array['Receptor']['NombreLegal']);
                            $RegistrationName->appendChild($nombre_legal);

        
            $TaxTotal=$xml->createElement('cac:TaxTotal'); 
            $TaxTotal =$CreditNote->appendChild($TaxTotal);
                $TaxAmount=$xml->createElement('cbc:TaxAmount',$array['TotalIgv']); 
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
                        $TaxScheme=$xml->createElement('cac:TaxScheme'); 
                        $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                            $ID=$xml->createElement('cbc:ID','1000'); 
                            $ID=$TaxScheme->appendChild($ID);
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5305";
                                $ID->appendChild($schemeID);
                                $schemeAgencyID=$xml->createAttribute("schemeAgencyID");
                                $schemeAgencyID->value="6";
                                $ID->appendChild($schemeAgencyID);
                            $name=$xml->createElement('cbc:Name','IGV'); 
                            $name=$TaxScheme->appendChild($name);
                            $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','VAT'); 
                            $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);
                            
            $LegalMonetaryTotal=$xml->createElement('cac:LegalMonetaryTotal'); 
            $LegalMonetaryTotal=$CreditNote->appendChild($LegalMonetaryTotal); 
                $AllowanceTotalAmount=$xml->createElement('cbc:AllowanceTotalAmount',$array['DescuentoGlobal']); 
                $AllowanceTotalAmount=$LegalMonetaryTotal->appendChild($AllowanceTotalAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $AllowanceTotalAmount->appendChild($currencyID);
                $PayableAmount=$xml->createElement('cbc:PayableAmount',$array['ImporteTotalVenta']); 
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
                    
           
        foreach($array['Items'] as $items){
            $CreditNoteLine=$xml->createElement('cac:CreditNoteLine'); 
            $CreditNoteLine =$CreditNote->appendChild($CreditNoteLine);
                $ID=$xml->createElement('cbc:ID',$items['Id']); 
                $ID=$CreditNoteLine->appendChild($ID);
                $CreditedQuantity=$xml->createElement('cbc:CreditedQuantity',$items['Cantidad']); 
                $CreditedQuantity =$CreditNoteLine->appendChild($CreditedQuantity);
                    $unitCode=$xml->createAttribute('unitCode');
                    $unitCode->value=$items['UnidadMedida'];
                    $CreditedQuantity->appendChild($unitCode);
                $LineExtensionAmount=$xml->createElement('cbc:LineExtensionAmount',$items['TotalVenta']); 
                $LineExtensionAmount=$CreditNoteLine->appendChild($LineExtensionAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $LineExtensionAmount->appendChild($currencyID);
            
                $PricingReference=$xml->createElement('cac:PricingReference');
                $PricingReference=$CreditNoteLine->appendChild($PricingReference);
                    $AlternativeConditionPrice=$xml->createElement('cac:AlternativeConditionPrice');
                    $AlternativeConditionPrice=$PricingReference->appendChild($AlternativeConditionPrice);
                        $PriceAmount=$xml->createElement('cbc:PriceAmount',($items['TipoPrecio']=='01')?$items['PrecioReferencial']:0);
                        $PriceAmount=$AlternativeConditionPrice->appendChild($PriceAmount);
                            $currencyID=$xml->createAttribute('currencyID');
                            $currencyID->value=$array['Moneda'];
                            $PriceAmount->appendChild($currencyID);
                        $PriceTypeCode=$xml->createElement('cbc:PriceTypeCode',$items['TipoPrecio']);
                        $PriceTypeCode=$AlternativeConditionPrice->appendChild($PriceTypeCode);
                                       
                $TaxTotal=$xml->createElement('cac:TaxTotal');
                $TaxTotal=$CreditNoteLine->appendChild($TaxTotal);
                    $TaxAmount=$xml->createElement('cbc:TaxAmount',$items['Impuesto']);
                    $TaxAmount=$TaxTotal->appendChild($TaxAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $TaxAmount->appendChild($currencyID);
                    
                    $TaxSubtotal=$xml->createElement('cac:TaxSubtotal');
                    $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                        $TaxableAmount=$xml->createElement('cbc:TaxableAmount',$items['TotalVenta']);
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
                            $Percent=$xml->createElement('cbc:Percent',$array['CalculoIgv']);
                            $Percent=$TaxCategory->appendChild($Percent);
                            
                            $TaxExemptionReasonCode=$xml->createElement('cbc:TaxExemptionReasonCode',$items['TipoImpuesto']);
                            $TaxExemptionReasonCode=$TaxCategory->appendChild($TaxExemptionReasonCode);
                                $listAgencyName=$xml->createAttribute("listAgencyName");
                                $listAgencyName->value="PE:SUNAT";
                                $TaxExemptionReasonCode->appendChild($listAgencyName);
                                $listName=$xml->createAttribute("listName");
                                $listName->value="SUNAT:Codigo de Tipo de Afectación del IGV";
                                $TaxExemptionReasonCode->appendChild($listName);
                                $listURI=$xml->createAttribute("listURI");
                                $listURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07";
                                $TaxExemptionReasonCode->appendChild($listURI);
                                
                            $TaxScheme=$xml->createElement('cac:TaxScheme');
                            $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                                $ID=$xml->createElement('cbc:ID','1000');
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
                                
                                $Name=$xml->createElement('cbc:Name','IGV');
                                $Name=$TaxScheme->appendChild($Name);
                                $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','VAT');
                                $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);
                $Item=$xml->createElement('cac:Item');
                $Item=$CreditNoteLine->appendChild($Item);
                    $Description=$xml->createElement('cbc:Description');
                    $Description=$Item->appendChild($Description);
                        $descripcion=$xml->createCDATASection($items['Descripcion']);
                        $descripcion=$Description->appendChild($descripcion);
                    
                $Price=$xml->createElement('cac:Price');
                $Price=$CreditNoteLine->appendChild($Price);
                    $PriceAmount=$xml->createElement('cbc:PriceAmount',$items['PrecioUnitario']);
                    $PriceAmount=$Price->appendChild($PriceAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $PriceAmount->appendChild($currencyID);
        }    
            
        $xml->formatOutput = true;
        return $xml;
    }
    function nota_debito_UBL2_1($array){
        $xml = new DomDocument("1.0", "ISO-8859-1"); 
        
        $DebitNote=$xml->createElement('DebitNote'); 
        $DebitNote=$xml->appendChild($DebitNote);
        $this->inyectar_atributo_nota_debito2_1($xml,$DebitNote);
            $UBLExtensions = $xml->createElement('ext:UBLExtensions'); 
            $UBLExtensions = $DebitNote->appendChild($UBLExtensions);
                $UBLExtension=$xml->createElement('ext:UBLExtension'); 
                $UBLExtension =$UBLExtensions->appendChild($UBLExtension);
                    $ExtensionContent=$xml->createElement('ext:ExtensionContent'); 
                    $ExtensionContent =$UBLExtension->appendChild($ExtensionContent);
                                             
            $UBLVersionID=$xml->createElement('cbc:UBLVersionID','2.1'); 
            $UBLVersionID =$DebitNote->appendChild($UBLVersionID);
            $CustomizationID=$xml->createElement('cbc:CustomizationID','2.0'); 
            $CustomizationID =$DebitNote->appendChild($CustomizationID);
           
            $ID=$xml->createElement('cbc:ID',$array['IdDocumento']); 
            $ID=$DebitNote->appendChild($ID);
            $IssueDate=$xml->createElement('cbc:IssueDate',$array['FechaEmision']); 
            $IssueDate=$DebitNote->appendChild($IssueDate);
            $IssueTime=$xml->createElement('cbc:IssueTime',$array['HoraEmision']); 
            $IssueTime=$DebitNote->appendChild($IssueTime);
            /*$Note=$xml->createElement('cbc:Note'); 
            $Note=$DebitNote->appendChild($Note);
                $languageLocaleID=$xml->createAttribute("languageLocaleID");
                $languageLocaleID->value="3000";
                $Note->appendChild($languageLocaleID);
                $total_texto=$xml->createTextNode('05010020170628000785');
                $Note->appendChild($total_texto);*/
            $DocumentCurrencyCode=$xml->createElement('cbc:DocumentCurrencyCode',$array['Moneda']); 
            $DocumentCurrencyCode=$DebitNote->appendChild($DocumentCurrencyCode);
            $DiscrepancyResponse=$xml->createElement('cac:DiscrepancyResponse'); 
            $DiscrepancyResponse=$DebitNote->appendChild($DiscrepancyResponse);
                $ReferenceID=$xml->createElement('cbc:ReferenceID',$array['Discrepancias'][0]['NroReferencia']); 
                $ReferenceID=$DiscrepancyResponse->appendChild($ReferenceID);
                $ResponseCode=$xml->createElement('cbc:ResponseCode',$array['TipoOperacion']); 
                $ResponseCode=$DiscrepancyResponse->appendChild($ResponseCode);
                $Description=$xml->createElement('cbc:Description'); 
                $Description=$DiscrepancyResponse->appendChild($Description);
                    $Motivo=$xml->createCDATASection($array['Discrepancias'][0]['Descripcion']);
                    $Description->appendChild($Motivo);///error
            $BillingReference=$xml->createElement('cac:BillingReference'); 
            $BillingReference=$DebitNote->appendChild($BillingReference);        
                $InvoiceDocumentReference=$xml->createElement('cac:InvoiceDocumentReference'); 
                $InvoiceDocumentReference=$BillingReference->appendChild($InvoiceDocumentReference);
                    $ID=$xml->createElement('cbc:ID',$array['Discrepancias'][0]['NroReferencia']); 
                    $ID=$InvoiceDocumentReference->appendChild($ID);    
                    $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['Discrepancias'][0]['Tipo']); 
                    $DocumentTypeCode=$InvoiceDocumentReference->appendChild($DocumentTypeCode);
        if(isset($array['Relacionados'][0]['NroDocumento'])&& $array['Relacionados'][0]['NroDocumento']!=""){
            //Documento de referencia
            //Tipo y número de la guía de remisión relacionada con la operación
            $DespatchDocumentReference=$xml->createElement('cac:DespatchDocumentReference'); 
            $DespatchDocumentReference=$DebitNote->appendChild($DespatchDocumentReference);
                $ID=$xml->createElement('cbc:ID',$array['Relacionados']['NroDocumento']); 
                $ID=$DespatchDocumentReference->appendChild($ID);
                $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['Relacionados'][0]['TipoDocumento']); 
                $DocumentTypeCode=$DespatchDocumentReference->appendChild($DocumentTypeCode);
        }    
        if(isset($array['OtrosDocumentosRelacionados'][0]['NroDocumento'])&& $array['OtrosDocumentosRelacionados'][0]['NroDocumento']!=""){
            //Tipo y número de otro documento y
            //código relacionado con la operación
            $AdditionalDocumentReference=$xml->createElement('cac:AdditionalDocumentReference'); 
            $AdditionalDocumentReference=$DebitNote->appendChild($AdditionalDocumentReference);
                $ID=$xml->createElement('cbc:ID',$array['OtrosDocumentosRelacionados']['NroDocumento']); 
                $ID=$AdditionalDocumentReference->appendChild($ID);
                $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$array['OtrosDocumentosRelacionados']['TipoDocumento']); 
                $DocumentTypeCode=$AdditionalDocumentReference->appendChild($DocumentTypeCode);
        }            
            $Signature=$xml->createElement('cac:Signature'); 
            $Signature=$DebitNote->appendChild($Signature);
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
                            
            $AccountingSupplierParty=$xml->createElement('cac:AccountingSupplierParty'); 
            $AccountingSupplierParty=$DebitNote->appendChild($AccountingSupplierParty);
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
                            $schemeName->value="SUNAT:Identificador de Documento de Identidad";
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
                            $AddressTypeCode=$xml->createElement('cbc:AddressTypeCode',$array['Emisor']['Ubigeo']); 
                            $AddressTypeCode=$RegistrationAddress->appendChild($AddressTypeCode);
                    
                   
            $AccountingCustomerParty=$xml->createElement('cac:AccountingCustomerParty'); 
            $AccountingCustomerParty=$DebitNote->appendChild($AccountingCustomerParty);
                $Party=$xml->createElement('cac:Party'); 
                $Party=$AccountingCustomerParty->appendChild($Party);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification=$Party->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',$array['Receptor']['NroDocumento']); 
                        $ID=$PartyIdentification->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value="6";
                            $ID->appendChild($schemeID);
                            $schemeName=$xml->createAttribute("schemeName");
                            $schemeName->value="SUNAT:Identificador de Documento de Identidad";
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
                            $nombre_legal=$xml->createCDATASection($array['Receptor']['NombreLegal']);
                            $RegistrationName->appendChild($nombre_legal);

        
            $TaxTotal=$xml->createElement('cac:TaxTotal'); 
            $TaxTotal=$DebitNote->appendChild($TaxTotal);
                $TaxAmount=$xml->createElement('cbc:TaxAmount',$array['TotalIgv']); 
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
                        $TaxScheme=$xml->createElement('cac:TaxScheme'); 
                        $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                            $ID=$xml->createElement('cbc:ID','1000'); 
                            $ID=$TaxScheme->appendChild($ID);
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value="UN/ECE 5153";
                                $ID->appendChild($schemeID);
                                $schemeAgencyID=$xml->createAttribute("schemeAgencyID");
                                $schemeAgencyID->value="6";
                                $ID->appendChild($schemeAgencyID);
                            $name=$xml->createElement('cbc:Name','IGV'); 
                            $name=$TaxScheme->appendChild($name);
                            $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','VAT'); 
                            $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);
                            
            $RequestedMonetaryTotal=$xml->createElement('cac:RequestedMonetaryTotal'); 
            $RequestedMonetaryTotal=$DebitNote->appendChild($RequestedMonetaryTotal); 
                $AllowanceTotalAmount=$xml->createElement('cbc:AllowanceTotalAmount',$array['DescuentoGlobal']); 
                $AllowanceTotalAmount=$RequestedMonetaryTotal->appendChild($AllowanceTotalAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $AllowanceTotalAmount->appendChild($currencyID);
                $PayableAmount=$xml->createElement('cbc:PayableAmount',$array['ImporteTotalVenta']); 
                $PayableAmount=$RequestedMonetaryTotal->appendChild($PayableAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $PayableAmount->appendChild($currencyID);
            if(isset($array['MontoAnticipo'])&&$array['MontoAnticipo']>0){    
                $PrepaidAmount=$xml->createElement('cbc:PrepaidAmount',$array['MontoAnticipo']); 
                $PrepaidAmount=$RequestedMonetaryTotal->appendChild($PrepaidAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['MonedaAnticipo'];
                    $PrepaidAmount->appendChild($currencyID);
            }
                    
           
        foreach($array['Items'] as $items){
            $DebitNoteLine=$xml->createElement('cac:DebitNoteLine'); 
            $DebitNoteLine=$DebitNote->appendChild($DebitNoteLine);
                $ID=$xml->createElement('cbc:ID',$items['Id']); 
                $ID=$DebitNoteLine->appendChild($ID);
                $DebitedQuantity=$xml->createElement('cbc:DebitedQuantity',$items['Cantidad']); 
                $DebitedQuantity =$DebitNoteLine->appendChild($DebitedQuantity);
                    $unitCode=$xml->createAttribute('unitCode');
                    $unitCode->value=$items['UnidadMedida'];
                    $DebitedQuantity->appendChild($unitCode);
                $LineExtensionAmount=$xml->createElement('cbc:LineExtensionAmount',$items['TotalVenta']); 
                $LineExtensionAmount=$DebitNoteLine->appendChild($LineExtensionAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $LineExtensionAmount->appendChild($currencyID);
            
                $PricingReference=$xml->createElement('cac:PricingReference');
                $PricingReference=$DebitNoteLine->appendChild($PricingReference);
                    $AlternativeConditionPrice=$xml->createElement('cac:AlternativeConditionPrice');
                    $AlternativeConditionPrice=$PricingReference->appendChild($AlternativeConditionPrice);
                        $PriceAmount=$xml->createElement('cbc:PriceAmount',($items['TipoPrecio']=='01')?$items['PrecioReferencial']:0);
                        $PriceAmount=$AlternativeConditionPrice->appendChild($PriceAmount);
                            $currencyID=$xml->createAttribute('currencyID');
                            $currencyID->value=$array['Moneda'];
                            $PriceAmount->appendChild($currencyID);
                        $PriceTypeCode=$xml->createElement('cbc:PriceTypeCode',$items['TipoPrecio']);
                        $PriceTypeCode=$AlternativeConditionPrice->appendChild($PriceTypeCode);
                                       
                $TaxTotal=$xml->createElement('cac:TaxTotal');
                $TaxTotal=$DebitNoteLine->appendChild($TaxTotal);
                    $TaxAmount=$xml->createElement('cbc:TaxAmount',$items['Impuesto']);
                    $TaxAmount=$TaxTotal->appendChild($TaxAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $TaxAmount->appendChild($currencyID);
                    
                    $TaxSubtotal=$xml->createElement('cac:TaxSubtotal');
                    $TaxSubtotal=$TaxTotal->appendChild($TaxSubtotal);
                        $TaxableAmount=$xml->createElement('cbc:TaxableAmount',$items['TotalVenta']);
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
                            $Percent=$xml->createElement('cbc:Percent',$array['CalculoIgv']);
                            $Percent=$TaxCategory->appendChild($Percent);
                            
                            $TaxExemptionReasonCode=$xml->createElement('cbc:TaxExemptionReasonCode',$items['TipoImpuesto']);
                            $TaxExemptionReasonCode=$TaxCategory->appendChild($TaxExemptionReasonCode);
                                $listAgencyName=$xml->createAttribute("listAgencyName");
                                $listAgencyName->value="PE:SUNAT";
                                $TaxExemptionReasonCode->appendChild($listAgencyName);
                                $listName=$xml->createAttribute("listName");
                                $listName->value="SUNAT:Codigo de Tipo de Afectación del IGV";
                                $TaxExemptionReasonCode->appendChild($listName);
                                $listURI=$xml->createAttribute("listURI");
                                $listURI->value="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07";
                                $TaxExemptionReasonCode->appendChild($listURI);
                                
                            $TaxScheme=$xml->createElement('cac:TaxScheme');
                            $TaxScheme=$TaxCategory->appendChild($TaxScheme);
                                $ID=$xml->createElement('cbc:ID','1000');
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
                                
                                $Name=$xml->createElement('cbc:Name','IGV');
                                $Name=$TaxScheme->appendChild($Name);
                                $TaxTypeCode=$xml->createElement('cbc:TaxTypeCode','VAT');
                                $TaxTypeCode=$TaxScheme->appendChild($TaxTypeCode);
                $Item=$xml->createElement('cac:Item');
                $Item=$DebitNoteLine->appendChild($Item);
                    $Description=$xml->createElement('cbc:Description');
                    $Description=$Item->appendChild($Description);
                        $descripcion=$xml->createCDATASection($items['Descripcion']);
                        $descripcion=$Description->appendChild($descripcion);
                    
                $Price=$xml->createElement('cac:Price');
                $Price=$DebitNoteLine->appendChild($Price);
                    $PriceAmount=$xml->createElement('cbc:PriceAmount',$items['PrecioUnitario']);
                    $PriceAmount=$Price->appendChild($PriceAmount);
                    $currencyID=$xml->createAttribute('currencyID');
                    $currencyID->value=$array['Moneda'];
                    $PriceAmount->appendChild($currencyID);
        }    
            
        $xml->formatOutput = true;
        return $xml;
    }
    function comunicacion_baja_UBL2_0($array){
        $xml = new DomDocument("1.0", "ISO-8859-1"); 
        $VoidedDocuments=$xml->createElement('VoidedDocuments'); 
        $VoidedDocuments=$xml->appendChild($VoidedDocuments);
        $this->inyectar_atributo_comunicacion_baja($xml,$VoidedDocuments);
            $UBLExtensions = $xml->createElement('ext:UBLExtensions'); 
            $UBLExtensions = $VoidedDocuments->appendChild($UBLExtensions);
                $UBLExtension = $xml->createElement('ext:UBLExtension'); 
                $UBLExtension=$UBLExtensions->appendChild($UBLExtension);
                
                    $ExtensionContent=$xml->createElement('ext:ExtensionContent'); 
                    $ExtensionContent =$UBLExtension->appendChild($ExtensionContent);
            $UBLVersionID=$xml->createElement('cbc:UBLVersionID','2.0'); 
            $UBLVersionID =$VoidedDocuments->appendChild($UBLVersionID);
            $CustomizationID=$xml->createElement('cbc:CustomizationID','1.0'); 
            $CustomizationID =$VoidedDocuments->appendChild($CustomizationID);
            
            $ID=$xml->createElement('cbc:ID',$array['IdDocumento']); 
            $ID=$VoidedDocuments->appendChild($ID);
            $ReferenceDate=$xml->createElement('cbc:ReferenceDate',$array['FechaReferencia']); 
            $ReferenceDate=$VoidedDocuments->appendChild($ReferenceDate);
            
            
            $IssueDate=$xml->createElement('cbc:IssueDate',$array['FechaEmision']); 
            $IssueDate=$VoidedDocuments->appendChild($IssueDate); 
            
            $Signature=$xml->createElement('cac:Signature'); 
            $Signature =$VoidedDocuments->appendChild($Signature);
                $ID=$xml->createElement('cbc:ID','IDSignKG'); 
                $ID =$Signature->appendChild($ID);
                $SignatoryParty=$xml->createElement('cac:SignatoryParty'); 
                $SignatoryParty =$Signature->appendChild($SignatoryParty);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification =$SignatoryParty->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',$array['Emisor']['NroDocumento']); 
                        $ID =$PartyIdentification->appendChild($ID);
                    $PartyName=$xml->createElement('cac:PartyName'); 
                    $PartyName =$SignatoryParty->appendChild($PartyName);
                        $Name=$xml->createElement('cbc:Name'); 
                        $Name =$PartyName->appendChild($Name);
                            $nombre_legal=$xml->createCDATASection($array['Emisor']['NombreLegal']);
                            $nombre_legal=$Name->appendChild($nombre_legal);
                $DigitalSignatureAttachment=$xml->createElement('cac:DigitalSignatureAttachment'); 
                $DigitalSignatureAttachment =$Signature->appendChild($DigitalSignatureAttachment);
                    $ExternalReference=$xml->createElement('cac:ExternalReference'); 
                    $ExternalReference =$DigitalSignatureAttachment->appendChild($ExternalReference);
                        $URI=$xml->createElement('cbc:URI','#signatureKG'); 
                        $URI =$ExternalReference->appendChild($URI);
                        
            $AccountingSupplierParty=$xml->createElement('cac:AccountingSupplierParty'); 
            $AccountingSupplierParty=$VoidedDocuments->appendChild($AccountingSupplierParty);
                $CustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID',$array['Emisor']['NroDocumento']);
                $CustomerAssignedAccountID=$AccountingSupplierParty->appendChild($CustomerAssignedAccountID);
                $AdditionalAccountID=$xml->createElement('cbc:AdditionalAccountID',$array['Emisor']['TipoDocumento']);
                $AdditionalAccountID=$AccountingSupplierParty->appendChild($AdditionalAccountID);
                $Party=$xml->createElement('cac:Party');
                $Party=$AccountingSupplierParty->appendChild($Party);
                    $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity');
                    $PartyLegalEntity=$Party->appendChild($PartyLegalEntity);
                        $RegistrationName=$xml->createElement('cbc:RegistrationName');
                        $RegistrationName=$PartyLegalEntity->appendChild($RegistrationName);
                            $razon_social=$xml->createCDATASection($array['Emisor']['NombreLegal']);
                            $RegistrationName->appendChild($razon_social);
                
            foreach($array['Bajas'] as $Bajas){
                $VoidedDocumentsLine=$xml->createElement('sac:VoidedDocumentsLine'); 
                $VoidedDocumentsLine=$VoidedDocuments->appendChild($VoidedDocumentsLine);  
                    $LineID=$xml->createElement('cbc:LineID',$Bajas['Id']); 
                    $LineID=$VoidedDocumentsLine->appendChild($LineID);
                    $DocumentTypeCode=$xml->createElement('cbc:DocumentTypeCode',$Bajas['TipoDocumento']); 
                    $DocumentTypeCode=$VoidedDocumentsLine->appendChild($DocumentTypeCode);
                    $DocumentSerialID=$xml->createElement('sac:DocumentSerialID',$Bajas['Serie']); 
                    $DocumentSerialID=$VoidedDocumentsLine->appendChild($DocumentSerialID);
                    $DocumentNumberID=$xml->createElement('sac:DocumentNumberID',$Bajas['Correlativo']); 
                    $DocumentNumberID=$VoidedDocumentsLine->appendChild($DocumentNumberID);
                    $VoidReasonDescription=$xml->createElement('sac:VoidReasonDescription'); 
                    $VoidReasonDescription=$VoidedDocumentsLine->appendChild($VoidReasonDescription);
                        $motivo=$xml->createTextNode($Bajas['MotivoBaja']);
                        $VoidReasonDescription->appendChild($motivo);
            }
               
        $xml->formatOutput = true;
        return $xml;
    }
    function guia_venta2_1($array){
        $xml = new DomDocument("1.0", "ISO-8859-1"); 
        
        $DespatchAdvice=$xml->createElement('DespatchAdvice'); 
        $DespatchAdvice = $xml->appendChild($DespatchAdvice);
        $this->inyectar_atributo_guia2_1($xml,$DespatchAdvice);
            
                
                            
            $UBLVersionID=$xml->createElement('cbc:UBLVersionID','2.1'); 
            $UBLVersionID =$DespatchAdvice->appendChild($UBLVersionID);
            $CustomizationID=$xml->createElement('cbc:CustomizationID','1.0'); 
            $CustomizationID =$DespatchAdvice->appendChild($CustomizationID);
            
            $ID=$xml->createElement('cbc:ID',$array['IdDocumento']); 
            $ID =$DespatchAdvice->appendChild($ID);
            
            $IssueDate=$xml->createElement('cbc:IssueDate'); 
            $IssueDate =$DespatchAdvice->appendChild($IssueDate);
                $fecha_emision=$xml->createTextNode($array['FechaEmision']);
                $fecha_emision =$IssueDate->appendChild($fecha_emision);
            $IssueTime=$xml->createElement('cbc:IssueTime',$array['HoraEmision']); 
            $IssueTime =$DespatchAdvice->appendChild($IssueTime);
                
            
            $DespatchAdviceTypeCode=$xml->createElement('cbc:DespatchAdviceTypeCode',$array['TipoDocumento']); 
            $DespatchAdviceTypeCode =$DespatchAdvice->appendChild($DespatchAdviceTypeCode);
            if($array['Observacion']!=""){
            $Note=$xml->createElement('cbc:Note'); 
            $Note=$DespatchAdvice->appendChild($Note);
                $observacion=$xml->createTextNode($array['Observacion']);
                $Note->appendChild($observacion);
            }
            
            if($array['DocumentoReferenciaBaja']['NroDocumento']!=""){
                $OrderReference=$xml->createElement("cac:OrderReference");
                $OrderReference=$DespatchAdvice->appendChild($OrderReference);
                    $ID=$xml->createElement("cbc:ID",$array['DocumentoReferenciaBaja']['NroDocumento']);
                    $ID=$OrderReference->appendChild($ID);
                    $OrderTypeCode=$xml->createElement("cbc:OrderTypeCode",$array['DocumentoReferenciaBaja']['TipoDocumento']);
                    $OrderTypeCode=$OrderReference->appendChild($OrderTypeCode);
                        $name=$xml->createAttribute('name');
                        $name->value=$array['DocumentoReferenciaBaja']['Descripcion'];
                        $OrderTypeCode->appendChild($name);
            }    
            //Numero de DAM (obligatorio cuando el motivo de traslado es importacion)
            //Documento Relacionado (Numeración de manifiesto de carga)
            //Documento Relacionado (Número de Orden de entrega, Número de SCOP, numeración de detracción u OTROS)
            if($array['DocumentoRelacionado']['NroDocumento']!=""){
                
            $AdditionalDocumentReference=$xml->createElement('cac:AdditionalDocumentReference'); 
            $AdditionalDocumentReference =$DespatchAdvice->appendChild($AdditionalDocumentReference);
                $ID=$xml->createElement("cbc:ID",$array['DocumentoRelacionado']['NroDocumento']);
                $ID=$AdditionalDocumentReference->appendChild($ID);
                $DocumentTypeCode=$xml->createElement("cbc:DocumentTypeCode",$array['DocumentoRelacionado']['TipoDocumento']);
                $DocumentTypeCode=$AdditionalDocumentReference->appendChild($DocumentTypeCode);
            }  
            $UBLExtensions = $xml->createElement('ext:UBLExtensions'); 
            $UBLExtensions = $DespatchAdvice->appendChild($UBLExtensions);
                $UBLExtension=$xml->createElement('ext:UBLExtension'); 
                $UBLExtension =$UBLExtensions->appendChild($UBLExtension);
                    $ExtensionContent=$xml->createElement('ext:ExtensionContent'); 
                    $ExtensionContent =$UBLExtension->appendChild($ExtensionContent);
            //Firma Digital
            $Signature=$xml->createElement('cac:Signature'); 
            $Signature =$DespatchAdvice->appendChild($Signature);
                $ID=$xml->createElement('cbc:ID','IDSignKG'); 
                $ID =$Signature->appendChild($ID);
                $SignatoryParty=$xml->createElement('cac:SignatoryParty'); 
                $SignatoryParty =$Signature->appendChild($SignatoryParty);
                    $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                    $PartyIdentification =$SignatoryParty->appendChild($PartyIdentification);
                        $ID=$xml->createElement('cbc:ID',$array['Remitente']['NroDocumento']); 
                        $ID =$PartyIdentification->appendChild($ID);
                    $PartyName=$xml->createElement('cac:PartyName'); 
                    $PartyName =$SignatoryParty->appendChild($PartyName);
                        $Name=$xml->createElement('cbc:Name'); 
                        $Name =$PartyName->appendChild($Name);
                            $nombre_legal=$xml->createCDATASection($array['Remitente']['NombreLegal']);
                            $nombre_legal=$Name->appendChild($nombre_legal);
                $DigitalSignatureAttachment=$xml->createElement('cac:DigitalSignatureAttachment'); 
                $DigitalSignatureAttachment =$Signature->appendChild($DigitalSignatureAttachment);
                    $ExternalReference=$xml->createElement('cac:ExternalReference'); 
                    $ExternalReference =$DigitalSignatureAttachment->appendChild($ExternalReference);
                        $URI=$xml->createElement('cbc:URI','#signatureKG'); 
                        $URI =$ExternalReference->appendChild($URI);
            //Datos del Remitente            
            $DespatchSupplierParty=$xml->createElement('cac:DespatchSupplierParty'); 
            $DespatchSupplierParty =$DespatchAdvice->appendChild($DespatchSupplierParty);
                $CustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID',$array['Remitente']['NroDocumento']); 
                $CustomerAssignedAccountID =$DespatchSupplierParty->appendChild($CustomerAssignedAccountID);
                    $schemeID=$xml->createAttribute("schemeID");
                    $schemeID->value=$array['Remitente']['TipoDocumento'];
                    $CustomerAssignedAccountID->appendChild($schemeID);
                $Party=$xml->createElement('cac:Party'); 
                $Party =$DespatchSupplierParty->appendChild($Party);
                    $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                    $PartyLegalEntity=$Party->appendChild($PartyLegalEntity);
                        $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                        $RegistrationName =$PartyLegalEntity->appendChild($RegistrationName);
                            $razon_social=$xml->createCDATASection($array['Remitente']['NombreLegal']);
                            $razon_social=$RegistrationName->appendChild($razon_social);
            //Datos del Destinatario                
            $DeliveryCustomerParty=$xml->createElement('cac:DeliveryCustomerParty'); 
            $DeliveryCustomerParty =$DespatchAdvice->appendChild($DeliveryCustomerParty);
                $CustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID',$array['Destinatario']['NroDocumento']); 
                $CustomerAssignedAccountID =$DeliveryCustomerParty->appendChild($CustomerAssignedAccountID);
                    $schemeID=$xml->createAttribute("schemeID");
                    $schemeID->value=$array['Destinatario']['TipoDocumento'];
                    $CustomerAssignedAccountID->appendChild($schemeID);
                $Party=$xml->createElement('cac:Party'); 
                $Party =$DeliveryCustomerParty->appendChild($Party);
                    $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                    $PartyLegalEntity =$Party->appendChild($PartyLegalEntity);
                        $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                        $RegistrationName =$PartyLegalEntity->appendChild($RegistrationName);
                            $razon_social=$xml->createCDATASection($array['Destinatario']['NombreLegal']);
                            $razon_social=$RegistrationName->appendChild($razon_social);
            //Datos del Proveedor (cuando se ingrese)                 
            if($array['Proveedor']['NroDocumento']!=""){
            $SellerSupplierParty=$xml->createElement('cac:SellerSupplierParty'); 
            $SellerSupplierParty =$DespatchAdvice->appendChild($SellerSupplierParty);
                $CustomerAssignedAccountID=$xml->createElement('cbc:CustomerAssignedAccountID',$array['Proveedor']['NroDocumento']); 
                $CustomerAssignedAccountID =$SellerSupplierParty->appendChild($CustomerAssignedAccountID);
                    $schemeID=$xml->createAttribute("schemeID");
                    $schemeID->value=$array['Proveedor']['TipoDocumento'];
                    $CustomerAssignedAccountID->appendChild($schemeID);
                    $Party=$xml->createElement('cac:Party'); 
                $Party =$SellerSupplierParty->appendChild($Party);
                $PartyLegalEntity=$xml->createElement('cac:PartyLegalEntity'); 
                $PartyLegalEntity =$Party->appendChild($PartyLegalEntity);
                    $RegistrationName=$xml->createElement('cbc:RegistrationName'); 
                    $RegistrationName =$PartyLegalEntity->appendChild($RegistrationName);
                        $razon_social=$xml->createTextNode($array['Proveedor']['NombreLegal']);
                        $razon_social=$RegistrationName->appendChild($razon_social);
            }
            //Datos del envío
            
            
            $Shipment=$xml->createElement('cac:Shipment'); 
            $Shipment =$DespatchAdvice->appendChild($Shipment);
                $HandlingCode=$xml->createElement('cbc:HandlingCode',$array['CodigoMotivoTraslado']); 
                $HandlingCode =$Shipment->appendChild($HandlingCode);
                $Information=$xml->createElement('cbc:Information'); 
                $Information =$Shipment->appendChild($Information);
                    $descripcion_motivo=$xml->createTextNode($array['DescripcionMotivo']);
                    $descripcion_motivo=$Information->appendChild($descripcion_motivo);
                    
                $SplitConsignmentIndicator=$xml->createElement('cbc:SplitConsignmentIndicator',$array['Transbordo']); 
                $SplitConsignmentIndicator =$Shipment->appendChild($SplitConsignmentIndicator);
                  
                $GrossWeightMeasure=$xml->createElement('cbc:GrossWeightMeasure',$array['PesoBrutoTotal']); 
                $GrossWeightMeasure =$Shipment->appendChild($GrossWeightMeasure);
                    $unitCode=$xml->createAttribute("unitCode");
                    $unitCode->value=$array['UnidadMedida'];
                    $GrossWeightMeasure->appendChild($unitCode);
                if($array['CodigoMotivoTraslado']!="08"){
                $TotalTransportHandlingUnitQuantity=$xml->createElement('cbc:TotalTransportHandlingUnitQuantity',$array['NroPallets']); 
                $TotalTransportHandlingUnitQuantity =$Shipment->appendChild($TotalTransportHandlingUnitQuantity);
               
                }    
                $ShipmentStage=$xml->createElement('cac:ShipmentStage'); 
                $ShipmentStage =$Shipment->appendChild($ShipmentStage);
                    $TransportModeCode=$xml->createElement('cbc:TransportModeCode',$array['ModalidadTraslado']); 
                    $TransportModeCode =$ShipmentStage->appendChild($TransportModeCode);
                    $TransitPeriod=$xml->createElement('cac:TransitPeriod'); 
                    $TransitPeriod =$ShipmentStage->appendChild($TransitPeriod);
                        $StartDate=$xml->createElement('cbc:StartDate',$array['FechaInicioTraslado']); 
                        $StartDate =$TransitPeriod->appendChild($StartDate);
                if($array['ModalidadTraslado']=="01"){
                    //Transportista (Transporte Público)
                    $CarrierParty=$xml->createElement('cac:CarrierParty'); 
                    $CarrierParty=$ShipmentStage->appendChild($CarrierParty);
                        $PartyIdentification=$xml->createElement('cac:PartyIdentification'); 
                        $PartyIdentification=$CarrierParty->appendChild($PartyIdentification);
                            $ID=$xml->createElement("cbc:ID",$array['RucTransportista']);
                            $ID=$PartyIdentification->appendChild($ID);
                                $schemeID=$xml->createAttribute("schemeID");
                                $schemeID->value='6';
                                $PartyIdentification->appendChild($ID);
                        $PartyName=$xml->createElement('cac:PartyName'); 
                        $PartyName=$CarrierParty->appendChild($PartyName);
                            $Name=$xml->createElement('cbc:Name'); 
                            $Name=$PartyName->appendChild($Name);
                                $razon_social_transportista=$xml->createCDATASection($array['RazonSocialTransportista']);
                                $razon_social_transportista=$Name->appendChild($razon_social_transportista);
                    
                }else if($array['ModalidadTraslado']=="02"){
                    //VEHICULO (Transporte Privado)        
                    $TransportMeans=$xml->createElement('cac:TransportMeans'); 
                    $TransportMeans=$ShipmentStage->appendChild($TransportMeans);
                        $RoadTransport=$xml->createElement('cac:RoadTransport'); 
                        $RoadTransport=$TransportMeans->appendChild($RoadTransport);     
                        $LicensePlateID=$xml->createElement('cbc:LicensePlateID',$array['NroPlacaVehiculo']);
                        $LicensePlateID=$RoadTransport->appendChild($LicensePlateID);
                $TransportHandlingUnit=$xml->createElement('cac:TransportHandlingUnit');
                $TransportHandlingUnit=$Shipment->appendChild($TransportHandlingUnit);
                    $ID=$xml->createElement('cbc:ID',$array['NroPlacaVehiculo']);
                    $ID=$TransportHandlingUnit->appendChild($ID);
                        
                if($array['NroPlacaVehiculoSecundario']!=""){
                    //Vehiculos (Secundarios)        
                $TransportHandlingUnit=$xml->createElement('cac:TransportHandlingUnit'); 
                $TransportHandlingUnit=$Shipment->appendChild($TransportHandlingUnit);
                    $TransportEquipment=$xml->createElement('cac:TransportEquipment'); 
                    $TransportHandlingUnit=$Shipment->appendChild($TransportEquipment);
                    $ID=$xml->createElement('cbc:ID',$array['NroPlacaVehiculoSecundario']);
                    $ID=$TransportHandlingUnit->appendChild($ID);
                }    
                //CONDUCTOR (Transporte Privado)              
                    $DriverPerson=$xml->createElement('cac:DriverPerson'); 
                    $DriverPerson =$ShipmentStage->appendChild($DriverPerson);
                        $ID=$xml->createElement("cbc:ID",$array['NroDocumentoConductor']);
                        $ID=$DriverPerson->appendChild($ID);
                            $schemeID=$xml->createAttribute("schemeID");
                            $schemeID->value='1';
                            $ID->appendChild($schemeID);
                }        
                    
                //Direccion punto de llegada  
                $Delivery=$xml->createElement('cac:Delivery'); 
                $Delivery=$Shipment->appendChild($Delivery);
                $DeliveryAddress=$xml->createElement('cac:DeliveryAddress'); 
                $DeliveryAddress =$Delivery->appendChild($DeliveryAddress);
                    $ID=$xml->createElement('cbc:ID',$array['DireccionLlegada']['Ubigeo']);
                    $ID=$DeliveryAddress->appendChild($ID);
                    $StreetName=$xml->createElement('cbc:StreetName');
                    $StreetName=$DeliveryAddress->appendChild($StreetName);
                        $direccion_llegada=$xml->createCDATASection($array['DireccionLlegada']['DireccionCompleta']);
                        $StreetName->appendChild($direccion_llegada);
                //Datos del contenedor (Obligatorio si motivo es Importación)
                if($array['CodigoMotivoTraslado']=='08'){
                $TransportHandlingUnit=$xml->createElement('cac:TransportHandlingUnit'); 
                $TransportHandlingUnit=$Shipment->appendChild($TransportHandlingUnit);    
                    $ID=$xml->createElement("cbc:ID",$array['NumeroContenedor']);
                    $ID=$TransportHandlingUnit->appendChild($ID);
                }
                //Direccion del punto de partida
                $OriginAddress=$xml->createElement('cac:OriginAddress'); 
                $OriginAddress=$Shipment->appendChild($OriginAddress);
                    $ID=$xml->createElement('cbc:ID',$array['DireccionPartida']['Ubigeo']);
                    $ID=$OriginAddress->appendChild($ID);
                    $StreetName=$xml->createElement('cbc:StreetName');
                    $StreetName=$OriginAddress->appendChild($StreetName);
                        $direccion_partida=$xml->createCDATASection($array['DireccionPartida']['DireccionCompleta']);
                        $StreetName->appendChild($direccion_partida);
                
                //Puerto o Aeropuerto de embarque/desembarque cuando el motivo de traslado es importacion
                if($array['CodigoMotivoTraslado']=='08'){
                $FirstArrivalPortLocation=$xml->createElement('cac:FirstArrivalPortLocation');
                $FirstArrivalPortLocation=$Shipment->appendChild($FirstArrivalPortLocation);
                    $ID=$xml->createElement('cbc:ID',$array['CodigoPuerto']);
                    $ID=$FirstArrivalPortLocation->appendChild($ID);    
                }
                //BIENES A TRANSPORTAR        
                
        foreach($array['BienesATransportar'] as $items){
            $DespatchLine=$xml->createElement('cac:DespatchLine'); 
            $DespatchLine=$DespatchAdvice->appendChild($DespatchLine);
                $ID=$xml->createElement('cbc:ID',$items['Correlativo']);
                $ID=$DespatchLine->appendChild($ID);
                $OrderLineReference=$xml->createElement('cac:OrderLineReference');
                $OrderLineReference=$DespatchLine->appendChild($OrderLineReference);
                    $ID=$xml->createElement('cbc:ID',$items['Correlativo']); 
                    $ID=$OrderLineReference->appendChild($ID);
                
                
                $DeliveredQuantity=$xml->createElement('cbc:DeliveredQuantity',$items['Cantidad']); 
                $DeliveredQuantity=$DespatchLine->appendChild($DeliveredQuantity);
                    $unitCode=$xml->createAttribute("unitCode");
                    $unitCode->value=$items['UnidadMedida'];
                    $DeliveredQuantity->appendChild($unitCode);
                $Item=$xml->createElement('cac:Item');
                $Item=$DespatchLine->appendChild($Item);
                    $name=$xml->createElement("cbc:Name");
                    $name=$Item->appendChild($name);
                        $descripcion_item=$xml->createCDATASection($items['Descripcion']);
                        $name->appendChild($descripcion_item);
                    $SellersItemIdentification=$xml->createElement('cac:SellersItemIdentification'); 
                    $SellersItemIdentification=$Item->appendChild($SellersItemIdentification);    
                        $ID=$xml->createElement("cbc:ID",$items['CodigoItem']);
                        $ID=$SellersItemIdentification->appendChild($ID);
        }   
        $xml->formatOutput = true;
        return $xml;
    }
    function inyectar_atributo($xml,$Invoice){
        foreach($this->atributos as $atributo=>$uri){
            $xmlns=$xml->createAttribute($atributo);
            $xmlns->value=$uri;
            $Invoice->appendChild($xmlns);
        }
        return $xml;
    }
    function inyectar_atributo2_1($xml,$Invoice){
        foreach($this->atributos2_1 as $atributo=>$uri){
            $xmlns=$xml->createAttribute($atributo);
            $xmlns->value=$uri;
            $Invoice->appendChild($xmlns);
        }
        return $xml;
    }
    function inyectar_atributo_nota_credito2_1($xml,$CreditNote){
        foreach($this->atributos_nota_credito2_1 as $atributo=>$uri){
            $xmlns=$xml->createAttribute($atributo);
            $xmlns->value=$uri;
            $CreditNote->appendChild($xmlns);
        }
        return $xml;
    }
    function inyectar_atributo_nota_debito2_1($xml,$DebitNote){
        foreach($this->atributos_nota_debito2_1 as $atributo=>$uri){
            $xmlns=$xml->createAttribute($atributo);
            $xmlns->value=$uri;
            $DebitNote->appendChild($xmlns);
        }
        return $xml;
    }
    function inyectar_atributo_guia($xml,$DespatchAdvice){
        foreach($this->atributos_guia as $atributo=>$uri){
            $xmlns=$xml->createAttribute($atributo);
            $xmlns->value=$uri;
            $DespatchAdvice->appendChild($xmlns);
        }
        return $xml;
    }
    function inyectar_atributo_guia2_1($xml,$DespatchAdvice){
        foreach($this->atributos_guia2_1 as $atributo=>$uri){
            $xmlns=$xml->createAttribute($atributo);
            $xmlns->value=$uri;
            $DespatchAdvice->appendChild($xmlns);
        }
        return $xml;
    }
    function inyectar_atributo_comunicacion_baja($xml,$VoidedDocuments){
        foreach($this->atributos_comunicacion_baja2_0 as $atributo=>$uri){
            $xmlns=$xml->createAttribute($atributo);
            $xmlns->value=$uri;
            $VoidedDocuments->appendChild($xmlns);
        }
        return $xml;
    }
}
