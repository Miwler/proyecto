<?php
class factura_venta {
    private $ID;
    private $salida_ID;
    private $numero;
    private $numero_concatenado;
    private $fecha_emision;
    private $forma_pago_ID;
    private $plazo_factura;
    private $fecha_vencimiento;
    private $estado_ID;
    private $observacion;
    private $moneda_ID;
    private $numero_orden_venta;
    private $numero_orden_compra;
    private $impresion;
    private $con_guia;
    private $pago;
    private $monto_total_neto;
    private $monto_total_igv;
    private $monto_total;
    private $monto_pendiente;
    private $operador_ID_anulacion;
    private $fecha_anulacion;
    private $motivo_anulacion_ID;
    private $serie;
    private $opcion;
    private $numero_producto;
    private $empresa_ID;
    private $correlativos_ID;
    private $gravadas;
    private $anticipos;
    private $gratuitas;
    private $inafectas;
    private $exoneradas;
    private $descuento_global;
    private $descuento_total_items;
    private $monto_detraccion;
    private $impuestos_tipo_ID;
    private $porcentaje_descuento;
    private $otros_cargos;
    private $ver_descripcion;
    private $ver_componente;
    private $ver_adicional;
    private $ver_serie;
    private $incluir_obsequios;
    
    private $usuario_id;
    private $usuario_mod_id;
    private $getMessage;
    private $comprobante;
    private $dtImpuestos_Tipo;
    private $dtSerie;
    private $estado;
    private $dtTipo_Comprobante;
    private $dtMoneda;
    
    private $ver_cambios;
    private $ver_vista_previa;
    private $ver_imprimir;
    
    public function __set($var, $valor)
      {
        $temporal = $var;
        if (property_exists("factura_venta",$temporal))
        {
          $this->$temporal = $valor;
        }
        else
        {
          echo $var . " No existe.";
        }
      }
    public function __get($var)
    {
      $temporal = $var;
      if (property_exists("factura_venta", $temporal))
      {
        return $this->$temporal;
      }
      return null;
    }
    function __construct()
    {
         $this->numero=0;
        $this->numero_concatenado="";
        $this->fecha_emision='NULL';
        $this->plazo_factura=0;
        $this->fecha_vencimiento='NULL';
        $this->observacion="";
        $this->numero_orden_venta="";
        $this->numero_orden_compra="";
        $this->impresion=0;
        $this->con_guia=0;
        $this->pago=0;
        $this->monto_total_neto=0;
        $this->monto_total_igv=0;
        $this->monto_total=0;
        $this->monto_pendiente=0;
        $this->operador_ID_anulacion='NULL';
        $this->fecha_anulacion='NULL';
        $this->motivo_anulacion_ID='NULL';
        $this->serie="";
        $this->opcion=0;
        $this->numero_producto=0;
        $this->empresa_ID=$_SESSION['empresa_ID'];
        $this->correlativos_ID='NULL';
        $this->gravadas=0;
        $this->anticipos=0;
        $this->gratuitas=0;
        $this->inafectas=0;
        $this->exoneradas=0;
        $this->descuento_global=0;
        $this->monto_detraccion=0;
        $this->porcentaje_descuento=0;
        $this->otros_cargos=0;
        $this->ver_descripcion=0;
        $this->ver_componente=0;
        $this->ver_adicional=0;
        $this->ver_serie=0;
        $this->incluir_obsequios=0;
        $this->usuario_id=$_SESSION["usuario_ID"];
        $this->usuario_mod_id=$_SESSION["usuario_ID"];

    }
    function __destruct()
    {
        $this->numero;
        $this->numero_concatenado;
        $this->fecha_emision;
        $this->plazo_factura;
        $this->fecha_vencimiento;
        $this->observacion;
        $this->numero_orden_venta;
        $this->numero_orden_compra;
        $this->impresion;
        $this->con_guia;
        $this->pago;
        $this->monto_total_neto;
        $this->monto_total_igv;
        $this->monto_total;
        $this->monto_pendiente;
        $this->operador_ID_anulacion;
        $this->fecha_anulacion;
        $this->serie;
        $this->opcion;
        $this->numero_producto;
        $this->correlativos_ID;
        $this->gravadas;
        $this->anticipos;
        $this->gratuitas;
        $this->inafectas;
        $this->exoneradas;
        $this->descuento_global;
        $this->monto_detraccion;
        $this->porcentaje_descuento;
        $this->otros_cargos;
        $this->ver_descripcion;
        $this->ver_componente;
        $this->ver_adicional;
        $this->ver_serie;
        $this->incluir_obsequios;
        $this->usuario_id;
        $this->usuario_mod_id;

    }
    static function getByID($ID)
      {
      $cn =new connect_new();
      try
      {
        $dt=$cn->store_procedure_getGrid(
            "sp_factura_venta_getByID",
            array("iID"=>$ID));
        $ofactura_venta=null;
        foreach($dt as $item)
        {
          $ofactura_venta= new factura_venta();
            $ofactura_venta->ID=$item["ID"];
            $ofactura_venta->salida_ID=$item["salida_ID"];
            $ofactura_venta->numero=$item["numero"];
            $ofactura_venta->numero_concatenado=$item["numero_concatenado"];
            $ofactura_venta->fecha_emision=$item["fecha_emision"];
            $ofactura_venta->forma_pago_ID=$item["forma_pago_ID"];
            $ofactura_venta->plazo_factura=$item["plazo_factura"];
            $ofactura_venta->fecha_vencimiento=$item["fecha_vencimiento"];
            $ofactura_venta->estado_ID=$item["estado_ID"];
            $ofactura_venta->observacion=$item["observacion"];
            $ofactura_venta->moneda_ID=$item["moneda_ID"];
            $ofactura_venta->numero_orden_venta=$item["numero_orden_venta"];
            $ofactura_venta->numero_orden_compra=$item["numero_orden_compra"];
            $ofactura_venta->impresion=$item["impresion"];
            $ofactura_venta->con_guia=$item["con_guia"];
            $ofactura_venta->pago=$item["pago"];
            $ofactura_venta->monto_total_neto=$item["monto_total_neto"];
            $ofactura_venta->monto_total_igv=$item["monto_total_igv"];
            $ofactura_venta->monto_total=$item["monto_total"];
            $ofactura_venta->monto_pendiente=$item["monto_pendiente"];
            $ofactura_venta->operador_ID_anulacion=$item["operador_ID_anulacion"];
            $ofactura_venta->fecha_anulacion=$item["fecha_anulacion"];
            $ofactura_venta->motivo_anulacion_ID=$item["motivo_anulacion_ID"];
            $ofactura_venta->serie=$item["serie"];
            $ofactura_venta->opcion=$item["opcion"];
            $ofactura_venta->numero_producto=$item["numero_producto"];
            $ofactura_venta->empresa_ID=$item["empresa_ID"];
            $ofactura_venta->correlativos_ID=$item["correlativos_ID"];
            $ofactura_venta->gravadas=$item["gravadas"];
            $ofactura_venta->anticipos=$item["anticipos"];
            $ofactura_venta->gratuitas=$item["gratuitas"];
            $ofactura_venta->inafectas=$item["inafectas"];
            $ofactura_venta->exoneradas=$item["exoneradas"];
            $ofactura_venta->descuento_global=$item["descuento_global"];
            $ofactura_venta->monto_detraccion=$item["monto_detraccion"];
            $ofactura_venta->impuestos_tipo_ID=$item["impuestos_tipo_ID"];
            $ofactura_venta->porcentaje_descuento=$item["porcentaje_descuento"];
            $ofactura_venta->otros_cargos=$item["otros_cargos"];
            $ofactura_venta->ver_descripcion=$item["ver_descripcion"];
            $ofactura_venta->ver_componente=$item["ver_componente"];
            $ofactura_venta->ver_adicional=$item["ver_adicional"];
            $ofactura_venta->ver_serie=$item["ver_serie"];
            $ofactura_venta->incluir_obsequios=$item["incluir_obsequios"];
            $ofactura_venta->usuario_id=$item["usuario_id"];
            $ofactura_venta->usuario_mod_id=$item["usuario_mod_id"];

        }
        return $ofactura_venta;
      }catch(Exeption $ex)
      {
        log_error(__FILE__, "factura_venta.getByID", $ex->getMessage());
        throw new Exception($ex->getMessage());
      }
    }
     static function getByID1($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_salida_getByID",
          array("iID"=>$ID));
      $osalida=null;
      foreach($dt as $item)
      {
        $osalida= new salida();
        $osalida->ID=$item["ID"];
        $osalida->empresa_ID=$item["empresa_ID"];
        $osalida->correlativos_ID=$item["correlativos_ID"];
        $osalida->cotizacion_ID=$item["cotizacion_ID"];
        $osalida->cliente_ID=$item["cliente_ID"];
        $osalida->cliente_contacto_ID=$item["cliente_contacto_ID"];
        $osalida->operador_ID=$item["operador_ID"];
        $osalida->periodo=$item["periodo"];
        $osalida->numero=$item["numero"];
        $osalida->numero_concatenado=$item["numero_concatenado"];
        $osalida->numero_orden_compra=$item["numero_orden_compra"];
        $osalida->moneda_ID=$item["moneda_ID"];
        $osalida->fecha=$item["fecha"];
        $osalida->igv=$item["igv"];
        $osalida->vigv_soles=$item["vigv_soles"];
        $osalida->vigv_dolares=$item["vigv_dolares"];
        $osalida->precio_venta_neto_soles=$item["precio_venta_neto_soles"];
        $osalida->precio_venta_total_soles=$item["precio_venta_total_soles"];
        $osalida->precio_venta_neto_dolares=$item["precio_venta_neto_dolares"];
        $osalida->precio_venta_total_dolares=$item["precio_venta_total_dolares"];
        $osalida->forma_pago_ID=$item["forma_pago_ID"];
        $osalida->tiempo_credito=$item["tiempo_credito"];
        $osalida->descuento_soles=$item["descuento_soles"];
        $osalida->descuento_dolares=$item["descuento_dolares"];
        $osalida->estado_ID=$item["estado_ID"];
        $osalida->tipo_cambio=$item["tipo_cambio"];
        $osalida->lugar_entrega=$item["lugar_entrega"];
        $osalida->plazo_entrega=$item["plazo_entrega"];
        $osalida->validez_oferta=$item["validez_oferta"];
        $osalida->garantia=$item["garantia"];
        $osalida->observacion=$item["observacion"];
        $osalida->nproducto_pagina=$item["nproducto_pagina"];
        $osalida->numero_pagina=$item["numero_pagina"];
        $osalida->impresion=$item["impresion"];
        $osalida->adicional=$item["adicional"];
        $osalida->ver_adicional=$item["ver_adicional"];
        $osalida->tipo=$item["tipo"];
        $osalida->isc=$item["isc"];
        $osalida->detraccion=$item["detraccion"];
        $osalida->porcentaje_descuento=$item["porcentaje_descuento"];
        $osalida->anticipos=$item["anticipos"];
        $osalida->exoneradas=$item["exoneradas"];
        $osalida->inafectas=$item["inafectas"];
        $osalida->gravadas=$item["gravadas"];
        $osalida->gratuitas=$item["gratuitas"];
        $osalida->otros_cargos=$item["otros_cargos"];
        $osalida->descuento_global=$item["descuento_global"];
        $osalida->monto_detraccion=$item["monto_detraccion"];
        $osalida->tipo_ID=$item["tipo_ID"];
        $osalida->usuario_id=$item["usuario_id"];
        $osalida->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $osalida;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "salida.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    function insertar()
      {
      $cn =new connect_new();
      try
      {
            $ID=$cn->store_procedure_transa(
                "sp_factura_venta_Insert",
                array(
                "iID"=>0,
                "isalida_ID"=>$this->salida_ID,
                "inumero"=>$this->numero,
                "inumero_concatenado"=>$this->numero_concatenado,
                "ifecha_emision"=>FormatTextToDate($this->fecha_emision,'Y-m-d'),
                "iforma_pago_ID"=>$this->forma_pago_ID,
                "iplazo_factura"=>$this->plazo_factura,
                "ifecha_vencimiento"=>FormatTextToDate($this->fecha_vencimiento,'Y-m-d'),
                "iestado_ID"=>$this->estado_ID,
                "iobservacion"=>$this->observacion,
                "imoneda_ID"=>$this->moneda_ID,
                "inumero_orden_venta"=>$this->numero_orden_venta,
                "inumero_orden_compra"=>$this->numero_orden_compra,
                "iimpresion"=>$this->impresion,
                "icon_guia"=>$this->con_guia,
                "ipago"=>$this->pago,
                "imonto_total_neto"=>$this->monto_total_neto,
                "imonto_total_igv"=>$this->monto_total_igv,
                "imonto_total"=>$this->monto_total,
                "imonto_pendiente"=>$this->monto_pendiente,
                "ioperador_ID_anulacion"=>$this->operador_ID_anulacion,
                "ifecha_anulacion"=>$this->fecha_anulacion,
                "imotivo_anulacion_ID"=>$this->motivo_anulacion_ID,
                "iserie"=>$this->serie,
                "iopcion"=>$this->opcion,
                "inumero_producto"=>$this->numero_producto,
                "iempresa_ID"=>$this->empresa_ID,
                "icorrelativos_ID"=>$this->correlativos_ID,
                "igravadas"=>$this->gravadas,
                "ianticipos"=>$this->anticipos,
                "igratuitas"=>$this->gratuitas,
                "iinafectas"=>$this->inafectas,
                "iexoneradas"=>$this->exoneradas,
                "idescuento_total_items"=>$this->descuento_total_items,
                "idescuento_global"=>$this->descuento_global,
                "imonto_detraccion"=>$this->monto_detraccion,
                "iporcentaje_descuento"=>$this->porcentaje_descuento,
                "iotros_cargos"=>$this->otros_cargos,
                "iver_descripcion"=>$this->ver_descripcion,
                "iver_componente"=>$this->ver_componente,
                "iver_adicional"=>$this->ver_adicional,
                "iver_serie"=>$this->ver_serie,
                "iincluir_obsequios"=>$this->incluir_obsequios,   
                "iusuario_id"=>$this->usuario_id,

            ),0);
            if($ID>0){
                $this->ID=$ID;
                $this->getMessage="El registro se guardó correctamente.";
                return $ID;
            }else{
                throw new Exception("No se registró");
            }
        
        
      }catch(Exeption $ex)
      {
        log_error(__FILE__, "factura_venta.insertar", $ex->getMessage());
        throw new Exception($ex->getMessage());
      }
    }
   function actualizar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_factura_venta_Update",
            array(
                "retornar"=>$retornar,
                "iID"=>$this->ID,
                "isalida_ID"=>$this->salida_ID,
                "iserie"=>$this->serie,
                "inumero"=>$this->numero,
                "inumero_concatenado"=>$this->numero_concatenado,
                "ifecha_emision"=>FormatTextToDate($this->fecha_emision,'Y-m-d'),
                "iforma_pago_ID"=>$this->forma_pago_ID,
                "iplazo_factura"=>$this->plazo_factura,
                "ifecha_vencimiento"=>FormatTextToDate($this->fecha_vencimiento,'Y-m-d'),
                "iestado_ID"=>$this->estado_ID,
                "iobservacion"=>$this->observacion,
                "imoneda_ID"=>$this->moneda_ID,
                "inumero_orden_venta"=>$this->numero_orden_venta,
                "inumero_orden_compra"=>$this->numero_orden_compra,
                "iimpresion"=>$this->impresion,
                "icon_guia"=>$this->con_guia,
                "ipago"=>$this->pago,
                "imonto_total_neto"=>$this->monto_total_neto,
                "imonto_total_igv"=>$this->monto_total_igv,
                "imonto_total"=>$this->monto_total,
                "imonto_pendiente"=>$this->monto_pendiente,
                "ioperador_ID_anulacion"=>$this->operador_ID_anulacion,
                "ifecha_anulacion"=>$this->fecha_anulacion,
                "imotivo_anulacion_ID"=>$this->motivo_anulacion_ID,
                "iopcion"=>$this->opcion,
                "inumero_producto"=>$this->numero_producto,
                "iempresa_ID"=>$this->empresa_ID,
                "icorrelativos_ID"=>$this->correlativos_ID,
                "igravadas"=>$this->gravadas,
                "ianticipos"=>$this->anticipos,
                "igratuitas"=>$this->gratuitas,
                "iinafectas"=>$this->inafectas,
                "iexoneradas"=>$this->exoneradas,
                "idescuento_global"=>$this->descuento_global,
                "imonto_detraccion"=>$this->monto_detraccion,
                "iporcentaje_descuento"=>$this->porcentaje_descuento,
                "iotros_cargos"=>$this->otros_cargos,
                "iver_descripcion"=>$this->ver_descripcion,
                "iver_componente"=>$this->ver_componente,
                "iver_adicional"=>$this->ver_adicional,
                "iver_serie"=>$this->ver_serie,
                "iincluir_obsequios"=>$this->incluir_obsequios,
                "iusuario_mod_id"=>$this->usuario_mod_id
                ),0);
      $this->getMessage="Se actualizó correctamente";
      return $retornar;
      
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "factura_venta.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    static function getCount($filtro='')
	{
            $cn =new connect_new();
            try
            {
                $resultado= $cn->store_procedure_getData(
                    "sp_factura_venta_getCount",
                    array("filtro"=>$filtro)
                    );
                   
                    return $resultado;
            }catch(Exception $ex)
            {
                    throw new Exception("Ocurrio un error en la consulta");
            }
    }
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='fv.ID asc')
    {
        $cn =new connect_new();
        try
        {
            $q='select fv.ID,tc.codigo,fv.salida_ID,fv.serie,fv.numero,fv.numero_concatenado, date_format(fv.fecha_emision,"%d/%m/%Y") as fecha_emision,fv.forma_pago_ID,fv.plazo_factura,fv.fecha_vencimiento,';
            $q.='fv.estado_ID,fv.moneda_ID,fv.numero_orden_compra,fv.numero_orden_venta,fv.impresion,fv.con_guia,fv.pago,fv.usuario_id,fv.fecha_anulacion,';
            $q.='fv.operador_ID_anulacion,fv.motivo_anulacion_ID,fv.opcion,fv.numero_producto,';
            $q.='fv.monto_total_neto,fv.monto_total_igv,fv.monto_total,';
            $q.='ifNull(fv.usuario_mod_id,-1) as usuario_mod_id,fv.gravadas,fv.gratuitas,fv.inafectas,fv.exoneradas,fv.descuento_global,fv.monto_detraccion,';
            $q.='fv.monto_total_neto,fv.monto_total_igv,fv.monto_total,fv.correlativos_ID,fv.ver_descripcion,fv.ver_componente,fv.ver_adicional,fv.ver_serie,';
            $q.='ifNull(fv.usuario_mod_id,-1) as usuario_mod_id from factura_venta fv
            inner join correlativos c on fv.correlativos_ID=c.ID
            inner join tipo_comprobante_empresa tce on tce.ID=c.tipo_comprobante_empresa_ID
            inner join tipo_comprobante tc on tc.ID=tce.tipo_comprobante_ID ';
            $q.=' where fv.del=0 and fv.empresa_ID='.$_SESSION['empresa_ID'];

                if($filtro!=''){
                        $q.=' and '.$filtro;
                }

                $q.=' Order By '.$order;

                if($desde!=-1&&$hasta!=-1){
                        $q.=' Limit '.$desde.','.$hasta;
                }
                //echo $q;
                $dt=$cn->getGrid($q);
                return $dt;
        }catch(Exception $ex)
        {
                throw new Exception($q);
        }
}
    static function getComprobante_Electronico($factura_venta_ID,$opcion) {
       $cn = new connect_new();
       try {
           $dt=$cn->store_procedure_getGrid("sp_factura_venta_getComprobante_Electronico",
                   array(
                       "ifactura_venta_ID"=>$factura_venta_ID,
                       "opcion"=>$opcion
                    ));
           
           return $dt;
       } catch (Exception $ex) {
           log_error(__FILE__, "factura_venta.getComprobante_Electronico", $ex->getMessage());
           throw new Exception('Ocurrio un error en la consulta');
       }
    }
    static function getComprobante_Vista_Previa($array) {
       $cn = new connect_new();
       try {
           $dt=$cn->store_procedure_getGrid("sp_factura_venta_getVistaPrevia",$array);
           
           return $dt;
       } catch (Exception $ex) {
           log_error(__FILE__,"factura_venta.getComprobante_Vista_Previa", $ex->getMessage());
           throw new Exception('Ocurrio un error en la consulta');
       }
    }
    static function getFilasComprobantes($salida_ID) {
        $cn = new connect_new();
        try {
            $dt=$cn->store_procedure_getGrid("sp_factura_venta_getComprobantes",
            array(
                "isalida_ID"=>$salida_ID
            ));
            return $dt;
        } catch (Exception $ex) {
            
            log_error(__FILE__,"factura_venta.getFilasComprobantes", $ex->getMessage());
           throw new Exception('Ocurrio un error en el sistema');
        }
    }
    static function getFactura_SUNAT($factura_venta_ID,$tipo)
	{//
            $cn =new connect_new();
            try
            {
                $dt=$cn->store_procedure_getGrid("sp_factura_venta_SUNAT",
                    array(
                        "ifactura_venta_ID"=>$factura_venta_ID,
                        "tipo"=>$tipo
                    ));
                
                
                return $dt;
            }catch(Exception $ex)
            {
                log_error(__FILE__,"factura_venta.getFactura_SUNAT", $ex->getMessage());
                throw new Exception('Ocurrio un error en el sistema');
            }
	}
    function eliminar()
    {
        $cn =new connect_new();
        $retornar =0;
        try
        {
          $retornar=$cn->store_procedure_transa(
              "sp_factura_venta_Delete",
                array(
                  "retornar"=>$retornar,
                  "iID"=>$this->ID,
                  "iusuario_mod_id"=>$this->usuario_mod_id ),0
                );
          if($retornar>0)$this->getMessage = "Se eliminó correctamente";
          return $retornar;
        }catch(Exeption $ex)
        {
          log_error(__FILE__, "factura_venta.eliminar", $ex->getMessage());
          throw new Exception($ex->getMessage());
        }
  }
  static function getGrid2($filtro='',$desde=-1,$hasta=-1,$order='fv.fecha_emision asc')
	{
		$cn =new connect_new();
		try
		{
                    $q='select fv.ID,ov.numero as salida,fv.fecha_emision,fv.fecha_vencimiento,fv.numero_concatenado,ov.moneda_ID,cl.razon_social as cliente,fv.pago,fv.forma_pago_ID,fv.monto_total_neto,fv.monto_total_igv,fv.monto_total,fv.estado_ID';
                     $q.=' ,es.nombre as estado, fv.monto_pendiente';
                    $q.=' from factura_venta fv, salida ov,cliente cl, estado es';
                    $q.=' where ov.empresa_ID='.$_SESSION['empresa_ID'].' and fv.del=0 and ov.del=0 and fv.salida_ID=ov.ID and ov.cliente_ID=cl.ID and fv.estado_ID=es.ID ';

                        if($filtro!=''){
				$q.=' and '.$filtro;
			}

			$q.=' Order By '.$order;

			if($desde!=-1&&$hasta!=-1){
				$q.=' Limit '.$desde.','.$hasta;
			}
                        //echo $q;
			$dt=$cn->getGrid($q);
			return $dt;
		}catch(Exception $ex)
		{
			throw new Exception($q);
		}
	}
static function getTablaFactura_VentaSNC($periodo,$serie,$numero)
    {
        $cn =new connect_new();
        try
        {
            $dt=$cn->store_procedure_getGridParse("getTabla_Factura_Emitida_SNC",
                    array(
                        "iempresa_ID"=>$_SESSION['empresa_ID'],
                        "iperiodo"=>$periodo,
                        "iserie"=>$serie,
                        "inumero"=>$numero
                    ));
            //$q='call getTabla_Factura_Emitida_SNC('.$_SESSION['empresa_ID'].','.$periodo.',"'.$serie.'",'.$numero.');';
            //echo $q;
            //$dt=$cn->getTabla($q);
            return $dt;
        }catch(Exception $ex)
        {
            throw new Exception($q);
        }
    }
    function actualizarCostos(){
        $cn =new connect_new();
	$retornar=-1;
        try{

            $q='UPDATE factura_venta set monto_total_neto='.$this->monto_total_neto.',monto_total_igv='.$this->monto_total_igv.',monto_total='.$this->monto_total;
            $q.=',monto_pendiente='.$this->monto_pendiente.' where ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->getMessage='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function actualizarEstado(){
        $cn =new connect_new();
	$retornar=-1;
        try{

            $q='UPDATE factura_venta set estado_ID='.$this->estado_ID.',observacion="'.$this->observacion.'",impresion='.$this->impresion.', usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->getMessage='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function actualizar_estructura($salida_ID,$ver_descripcion)
    {
        $cn =new connect_new();
        $retornar =0;
        try
        {
          $retornar=$cn->store_procedure_transa(
              "sp_factura_venta_UpdateEstructura",
                array(
                  "isalida_ID"=>$salida_ID,
                  "iver_descripcion"=>$ver_descripcion),0
                );
          
          
        }catch(Exeption $ex)
        {
          log_error(__FILE__, "factura_venta.eliminar", $ex->getMessage());
          throw new Exception($ex->getMessage());
        }
  }
}  



?>
