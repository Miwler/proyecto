<?php

class factura_venta1 {
    private $ID;
    private $serie;
    private $numero;
    private $numero_concatenado;
    private $forma_pago_ID;
    private $estado_ID;
    private $observacion;

    private $fecha_emision;
    private $plazo_factura;
    private $fecha_vencimiento;
    private $moneda_ID;
    private $salida_ID;
    private $numero_orden_compra;
    private $numero_orden_venta;
    private $impuestos_tipo_ID;
    private $usuario_id;
    private $usuario_mod_id;
    private $opcion;
    private $empresa_ID;
    private $message;
    private $fecha_texto;
    private $fecha_cancelacion_texto;
    private $operador;
    private $numero_cuenta;
    private $subtotal;
    private $igv;
    private $vigv;
    private $total;
    private $totaltexto;
    private $con_guia;
    private $decimal;
    private $facturas_informacion;
    private $impresion;
    private $numero_producto;
    private $pago;
    private $monto_total_neto;
    private $monto_total_igv;
    private $monto_total;
    private $monto_pendiente;
    private $moneda;
    private $fecha_anulacion;
    private $motivo_anulacion_ID;
    private $operador_ID_anulacion;
    private $dtOperador;
    private $dtMotivo_Anulacion;
    private $estado;
    private $ver_cambios;
    private $ver_vista_previa;
    private $ver_imprimir;
    private $ver_enviar_SUNAT;
    private $dtSerie;

    private $gravadas;
    private $anticipos;
    private $gratuitas;
    private $inafectas;
    private $exoneradas;
    private $descuento_global;
    private $monto_detraccion;
    private $porcentaje_descuento;
    private $otros_cargos;
    private $comprobante;
    private $dtImpuestos_Tipo;
    private $ver_descripcion;
    private $ver_componente;
    private $ver_adicional;

    private $correlativos_ID;


  public function __set($var, $valor)
    {
// convierte a minúsculas toda una cadena la función strtolower
          $temporal = $var;

          // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
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

        // Verifica que exista
        if (property_exists('factura_venta', $temporal))
         {
                return $this->$temporal;
         }

        // Retorna nulo si no existe
        return null;
    }
    function __construct()
  {
        $this->cotizacion_ID=0;
    $this->cliente_contacto_ID=0;
    $this->operador_ID=0;
    $this->periodo=0;
    $this->numero=0;
    $this->numero_concatenado="";
    $this->numero_orden_compra="";
    $this->fecha="";
    $this->igv=0;
    $this->vigv_soles=0;
    $this->vigv_dolares=0;
    $this->precio_venta_neto_soles=0;
    $this->precio_venta_total_soles=0;
    $this->precio_venta_neto_dolares=0;
    $this->precio_venta_total_dolares=0;
    $this->forma_pago_ID=0;
    $this->tiempo_credito=0;
    $this->descuento_soles=0;
    $this->descuento_dolares=0;
    $this->tipo_cambio=0;
    $this->lugar_entrega="";
    $this->plazo_entrega=0;
    $this->validez_oferta="";
    $this->garantia="";
    $this->observacion="";
    $this->nproducto_pagina="";
    $this->numero_pagina=0;
    $this->impresion=0;
    $this->adicional="";
    $this->ver_adicional=0;
    $this->tipo=0;
    $this->isc=0;
    $this->detraccion=0;
    $this->porcentaje_descuento=0;
    $this->anticipos=0;
    $this->exoneradas=0;
    $this->inafectas=0;
    $this->gravadas=0;
    $this->gratuitas=0;
    $this->otros_cargos=0;
    $this->descuento_global=0;
    $this->monto_detraccion=0;
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];

  }
  function __destruct()
  {
        $this->cotizacion_ID;
    $this->cliente_contacto_ID;
    $this->operador_ID;
    $this->periodo;
    $this->numero;
    $this->numero_concatenado;
    $this->numero_orden_compra;
    $this->fecha;
    $this->igv;
    $this->vigv_soles;
    $this->vigv_dolares;
    $this->precio_venta_neto_soles;
    $this->precio_venta_total_soles;
    $this->precio_venta_neto_dolares;
    $this->precio_venta_total_dolares;
    $this->forma_pago_ID;
    $this->tiempo_credito;
    $this->descuento_soles;
    $this->descuento_dolares;
    $this->tipo_cambio;
    $this->lugar_entrega;
    $this->plazo_entrega;
    $this->validez_oferta;
    $this->garantia;
    $this->observacion;
    $this->nproducto_pagina;
    $this->numero_pagina;
    $this->impresion;
    $this->adicional;
    $this->ver_adicional;
    $this->tipo;
    $this->isc;
    $this->detraccion;
    $this->porcentaje_descuento;
    $this->anticipos;
    $this->exoneradas;
    $this->inafectas;
    $this->gravadas;
    $this->gratuitas;
    $this->otros_cargos;
    $this->descuento_global;
    $this->monto_detraccion;
    $this->usuario_id;
    $this->usuario_mod_id;

  }
    /*function insertar()
    {
        $cn =new connect_new();
        $retornar=-1;
        try{
            $fecha_save='NULL';
            if($this->fecha_emision!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha_emision,'Y-m-d').'"';
            }
            $fecha_save_vencimiento='NULL';
            if($this->fecha_vencimiento!=null){
                $fecha_save_vencimiento='"'.FormatTextToDate($this->fecha_vencimiento,'Y-m-d').'"';
            }
            $con_guia='NULL';
            if($this->con_guia!=null){
                $con_guia=$this->con_guia;
            }
            $q='select ifnull(max(ID),0)+1 as ID from factura_venta;';
            $ID=$cn->getData($q);
            $q='INSERT INTO factura_venta (ID,empresa_ID,serie,salida_ID,numero,numero_concatenado,fecha_emision,forma_pago_ID,plazo_factura,fecha_vencimiento,estado_ID,moneda_ID,numero_orden_compra,numero_orden_venta,con_guia,usuario_id,opcion,numero_producto,correlativos_ID,impuestos_tipo_ID,';
            $q.='gravadas,gratutas,inafectas,exoneradas,descuento_global,porcentaje_descuento,otros_cargos) ';
            $q.='VALUES ('.$ID.','.$_SESSION['empresa_ID'].',"'.$this->serie.'",'.$this->salida_ID.','.$this->numero.',"'.$this->numero_concatenado.'",'.$fecha_save.','.$this->forma_pago_ID.','.$this->plazo_factura.','.$fecha_save_vencimiento;
            $q.=','.$this->estado_ID.','.$this->moneda_ID.',"'.$this->numero_orden_compra.'","'.$this->numero_orden_venta.'",'.$con_guia.','.$this->usuario_id.','.$this->opcion.','.$this->numero_producto.','.$this->correlativos_ID.','.$this->impuestos_tipo_ID.')';
            //echo $q;
            $retornar=$cn->transa($q);
            $q="call sp_tabla_movimiento_Insertar(".$ID.",'factura_venta',".$this->estado_ID.",'".date("Y-m-d H:i:s")."','',".$this->usuario_id.",".$_SESSION['empresa_ID'].",".$this->usuario_id.")";
            $cn->transa($q);
            $this->ID=$ID;
            $this->message='Se guardó correctamente';

            return $retornar;

        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    */
    function actualizar(){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $fecha_save='NULL';
            if($this->fecha_emision!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha_emision,'Y-m-d').'"';
            }
            $fecha_save_vencimiento='NULL';
            if($this->fecha_vencimiento!=null){
                $fecha_save_vencimiento='"'.FormatTextToDate($this->fecha_vencimiento,'Y-m-d').'"';
            }
            $con_guia='NULL';
            if($this->con_guia!=null){
                $con_guia=$this->con_guia;
            }
            $q='UPDATE factura_venta set salida_ID='.$this->salida_ID.',serie="'.$this->serie.'",numero='.$this->numero.',numero_concatenado="'.$this->numero_concatenado.'",fecha_emision='.$fecha_save.
               ',forma_pago_ID='.$this->forma_pago_ID.',plazo_factura='.$this->plazo_factura.',fecha_vencimiento='.$fecha_save_vencimiento.',estado_ID='.$this->estado_ID.
               ',moneda_ID='.$this->moneda_ID .',numero_orden_compra="'.$this->numero_orden_compra.'",numero_orden_venta="'.$this->numero_orden_venta.'",impresion='.$this->impresion.',con_guia='.$con_guia.',opcion='.$this->opcion;
                ',numero_producto='.$this->numero_producto.',correlativos_ID='.$this->correlativos_ID.',impuestos_tipo_ID='.$this->impuestos_tipo_ID.', usuario_mod_id='.$this->usuario_mod_id;
            $q.=',gravadas='.$this->gravadas.',gratuitas='.$this->gratuitas.',inafectas='.$this->inafectas.',exoneradas='.$this->exoneradas.',descuento_global='.$this->descuento_global.',monto_detraccion='.$this->monto_detraccion;
            $q.=',porcentaje_descuento='.$this->porcentaje_descuento.',otros_cargos='.$this->otros_cargos;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $q="call sp_tabla_movimiento_Insertar(".$this->ID.",'factura_venta',".$this->estado_ID.",'".date("Y-m-d H:i:s")."','',".$this->usuario_mod_id.",".$_SESSION['empresa_ID'].",".$this->usuario_mod_id.")";
            $cn->transa($q);
            $this->message='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
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
            $this->message='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    //codigo ortega-aprobar cotizacion
     function actualizarEstado(){
        $cn =new connect_new();
	$retornar=-1;
        try{

            $q='UPDATE factura_venta set estado_ID='.$this->estado_ID.',observacion="'.$this->observacion.'",impresion='.$this->impresion.', usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function actualizarMontoPendiente(){
      $cn =new connect_new();
      $numero=0;
        try{
            $q='update factura_venta set monto_pendiente='.$this->monto_pendiente;
            $q.=',usuario_mod_id='.$this->usuario_mod_id.', fdm=now() where ID='.$this->ID;
            $numero=$cn->transa($q);
           // echo $q;
            return $numero;
        } catch (Exception $ex) {
            throw new Exception($q);
        }

    }
    function actualizarPago(){
      $cn =new connect_new();
      $numero=0;
        try{
            $q='update factura_venta set pago='.$this->pago.', estado_ID='.$this->estado_ID;
            $q.=' where ID='.$this->ID;
            $numero=$cn->transa($q);
           // echo $q;
            return $numero;
        } catch (Exception $ex) {
            throw new Exception($q);
        }

    }
    function actualizarAnulacion(){
      $cn =new connect_new();
      $numero=0;
        try{
            $fecha_save='NULL';
            if($this->fecha_anulacion!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha_anulacion,'Y-m-d').'"';
            }
            $q='update factura_venta set fecha_anulacion ='.$fecha_save.',motivo_anulacion_ID='.$this->motivo_anulacion_ID;
            $q.=',operador_ID_anulacion='.$this->operador_ID_anulacion.', estado_ID=53 where ID='.$this->ID;
            //echo $q;
            $numero=$cn->transa($q);
           // echo $q;
            return $numero;

            $this->message="Se anuló correctamente.";
        } catch (Exception $ex) {
            throw new Exception($q);
        }

    }
    function eliminar(){
            $cn =new connect_new();
            $retornar=-1;
            try{

                    $q='UPDATE cotizacion SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                    $q.=' WHERE del=0 and ID='.$this->ID;

                    $retornar=$cn->transa($q);

                    $this->message='Se eliminó correctamente';
                    return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un error en la consulta");
            }
    }
    static function getCount($filtro='')
	{
		$cn =new connect_new();
		try
		{
			$q='select count(ID) ';
			$q.=' FROM factura_venta ';
			$q.=' where del=0 and empresa_ID='.$_SESSION['empresa_ID'];

			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
			//echo $q;
			$resultado=$cn->getData($q);

			return $resultado;
		}catch(Exception $ex)
		{
			throw new Exception("Ocurrio un error en la consulta");
		}
	}

        //modificado por ortega-agregar todos los datos y cargar en el modelo
   static function getByID($ID)
	{
            $cn =new connect_new();
            try
            {
                $q='select fv.ID,fv.salida_ID,fv.serie,fv.numero,fv.numero_concatenado,DATE_FORMAT(fv.fecha_emision,"%d/%m/%Y") as fecha_emision,fv.forma_pago_ID,fv.plazo_factura,DATE_FORMAT(fv.fecha_vencimiento,"%d/%m/%Y") as fecha_vencimiento,';
                $q.='fv.estado_ID,fv.moneda_ID,fv.numero_orden_compra,fv.numero_orden_venta,ifnull(fv.impresion,0) as impresion,fv.con_guia,pago,ifnull(fv.monto_total_neto,0) as monto_total_neto,ifnull(fv.monto_total_igv,0) as monto_total_igv,ifnull(fv.monto_total,0) as monto_total,';
                $q.='ifnull(fv.monto_pendiente,0) as monto_pendiente,DATE_FORMAT(fv.fecha_anulacion,"%d/%m/%Y") as fecha_anulacion,fv.operador_ID_anulacion,fv.motivo_anulacion_ID ,fv.opcion,fv.numero_producto,fv.correlativos_ID,';
                $q.='fv.impuestos_tipo_ID,fv.usuario_id,ifNull(fv.usuario_mod_id,-1) as usuario_mod_id,tce.tabla as comprobante from factura_venta fv,correlativos co,tipo_comprobante_empresa tce';
                $q.=' where fv.correlativos_ID=co.ID and co.tipo_comprobante_empresa_ID=tce.ID and fv.del=0 and co.del=0 and tce.del=0 and fv.ID='.$ID;
                    
                    $dt=$cn->getGrid($q);
                    $oFactura_Venta=null;

                    foreach($dt as $item)
                    {
                        $oFactura_Venta = new factura_venta();
                        $oFactura_Venta->ID=$item['ID'];
                        $oFactura_Venta->salida_ID=$item['salida_ID'];
                        $oFactura_Venta->serie=$item['serie'];
                        $oFactura_Venta->numero=$item['numero'];
                        $oFactura_Venta->numero_concatenado=$item['numero_concatenado'];
                        $oFactura_Venta->fecha_emision=$item['fecha_emision'];
                        $oFactura_Venta->forma_pago_ID=$item['forma_pago_ID'];
                        $oFactura_Venta->plazo_factura=$item['plazo_factura'];
                        $oFactura_Venta->fecha_vencimiento=$item['fecha_vencimiento'];
                        $oFactura_Venta->estado_ID=$item['estado_ID'];
                        $oFactura_Venta->moneda_ID=$item['moneda_ID'];
                        $oFactura_Venta->numero_orden_compra=$item['numero_orden_compra'];
                        $oFactura_Venta->numero_orden_venta=$item['numero_orden_venta'];
                        $oFactura_Venta->impresion=$item['impresion'];
                        $oFactura_Venta->con_guia=$item['con_guia'];
                        $oFactura_Venta->pago=$item['pago'];
                        $oFactura_Venta->monto_total_neto=$item['monto_total_neto'];
                        $oFactura_Venta->monto_total_igv=$item['monto_total_igv'];
                        $oFactura_Venta->monto_total=$item['monto_total'];
                        $oFactura_Venta->monto_pendiente=$item['monto_pendiente'];
                        $oFactura_Venta->fecha_anulacion=$item['fecha_anulacion'];
                        $oFactura_Venta->operador_ID_anulacion=$item['operador_ID_anulacion'];
                        $oFactura_Venta->motivo_anulacion_ID=$item['motivo_anulacion_ID'];
                        $oFactura_Venta->opcion=$item['opcion'];
                        $oFactura_Venta->numero_producto=$item['numero_producto'];
                        $oFactura_Venta->correlativos_ID=$item['correlativos_ID'];
                        $oFactura_Venta->impuestos_tipo_ID=$item['impuestos_tipo_ID'];
                        $oFactura_Venta->usuario_id=$item['usuario_id'];
                        $oFactura_Venta->usuario_mod_id=$item['usuario_mod_id'];
                        $oFactura_Venta->comprobante=$item['comprobante'];
                    }
                    return $oFactura_Venta;

            }catch(Exeption $ex)
            {
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
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect_new();
		try
		{
                    $q='select fv.ID,tc.codigo,fv.salida_ID,fv.serie,fv.numero,fv.numero_concatenado, date_format(fv.fecha_emision,"%d/%m/%Y") as fecha_emision,fv.forma_pago_ID,fv.plazo_factura,fv.fecha_vencimiento,';
                    $q.='fv.estado_ID,fv.moneda_ID,fv.numero_orden_compra,fv.numero_orden_venta,fv.impresion,fv.con_guia,fv.pago,fv.usuario_id,fv.fecha_anulacion,';
                    $q.='fv.operador_ID_anulacion,fv.motivo_anulacion_ID,fv.opcion,fv.numero_producto,';
                    $q.='fv.monto_total_neto,fv.monto_total_igv,fv.monto_total,';
                    $q.='ifNull(fv.usuario_mod_id,-1) as usuario_mod_id,fv.gravadas,fv.gratuitas,fv.inafectas,fv.exoneradas,fv.descuento_global,fv.monto_detraccion,';
                    $q.='fv.monto_total_neto,fv.monto_total_igv,fv.monto_total,fv.correlativos_ID,';
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

        static function getFactura_SUNAT($ID,$tipo)
	{
            $cn =new connect_new();
            try
            {
                $q='call factura_venta_SUNAT('.$ID.',"'.$tipo.'");';
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
                $q='call getTabla_Factura_Emitida_SNC('.$_SESSION['empresa_ID'].','.$periodo.',"'.$serie.'",'.$numero.');';
                //echo $q;
                $dt=$cn->getTabla($q);
                return $dt;
            }catch(Exception $ex)
            {
                throw new Exception($q);
            }
	}

    function verificarDuplicado(){
		$cn =new connect_new();
		$retornar=-1;
		try{
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un error en la consulta");
		}
	}
    static function getNumero(){
      $cn =new connect_new();
      $numero=0;
        try{
            $q='select ifnull(max(numero),0) as numero from factura_venta';
            $numero=$cn->getData($q);
           // echo $q;
            return $numero;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }

    }
    static function getImpresion(){
      $cn =new connect_new();
      $numero=0;
        try{
            $q='select ifnull(max(numero),0) as numero from factura_venta where del=0';
            $numero=$cn->getData($q);
           // echo $q;
            return $numero;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }

    }

    static function getComprobante_Electronico($factura_venta_ID,$opcion) {
       $cn = new connect_new();
       try {
           $q = 'call getComprobante_Electronico('.$factura_venta_ID.',"'.$opcion.'");';
           //ECHO $q;
           $dt = $cn->getGrid($q);
           return $dt;
       } catch (Exception $ex) {
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
}


?>
