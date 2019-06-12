<?php

class salida {
    private $ID;
    private $empresa_ID;
    private $cotizacion_ID;
    private $cliente_ID;
    private $cliente_contacto_ID;
    private $operador_ID;
    private $periodo;
    private $numero;
    private $numero_concatenado;
    private $numero_orden_compra;
    private $moneda_ID;
    private $fecha;
    private $igv;
    private $vigv_soles;
    private $vigv_dolares;
    private $precio_venta_neto_soles;
    private $precio_venta_total_soles;
    private $precio_venta_neto_dolares;
    private $precio_venta_total_dolares;
    private $forma_pago_ID;
    private $tiempo_credito;
    private $descuento_soles;
    private $descuento_dolares;
    private $estado_ID;
    private $tipo_cambio;
    private $plazo_entrega;
    private $lugar_entrega;
    private $validez_oferta;
    private $garantia;
    private $observacion;
    private $numero_pagina;
    private $impresion;
    private $nproducto_pagina;
    private $ver_adicional;
    private $adicional;
    private $usuario_id;
    private $usuario_mod_id;
    private $serie;
    private $isc;
    private $detraccion;
    private $porcentaje_descuento;
    private $anticipos;
    private $exoneradas;
    private $inafectas;
    private $gravadas;
    private $gratuitas;
    private $otros_cargos;
    private $descuento_global;
    private $monto_detraccion;
    private $tipo_ID;
    private $valor_venta_soles;
    private $valor_venta_dolares;
    private $visc_soles;
    private $visc_dolares;
    private $descuento_item_soles;
    private $descuento_item_dolares;
    Private $getMessage;
    Private $bloquear_edicion;
    Private $dtRepresentante_Cliente;
    Private $ver_factura;
    Private $ver_guia;
    private $cadena_numero_cuenta;
    private $mostrar_precio_unitario;
    private $tipo;

    public function __set($var, $valor)
    {
// convierte a minúsculas toda una cadena la función strtolower
          $temporal = $var;

          // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
          if (property_exists('salida',$temporal))
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
        if (property_exists('salida', $temporal))
         {
                return $this->$temporal;
         }

        // Retorna nulo si no existe
        return null;
    }
    function __construct()
    {
        $this->cliente_contacto_ID=NULL;
        $this->operador_ID=NULL;
        $this->periodo=date("Y");
        $this->numero=0;
        $this->numero_concatenado="";
        $this->numero_orden_compra="";
        $this->fecha=NULL;
        $this->igv=0;
        $this->vigv_soles=0;
        $this->vigv_dolares=0;
        $this->precio_venta_neto_soles=0;
        $this->precio_venta_total_soles=0;
        $this->precio_venta_neto_dolares=0;
        $this->precio_venta_total_dolares=0;
        $this->forma_pago_ID=null;
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
        $this->valor_venta_soles=0;
        $this->valor_venta_dolares=0;
        $this->visc_soles=0;
        $this->visc_dolares=0;
        $this->descuento_item_soles=0;
        $this->descuento_item_dolares=0;
        $this->mostrar_precio_unitario=precio_incluye_igv;
        $this->usuario_id=$_SESSION['usuario_ID'];
        $this->usuario_mod_id=$_SESSION['usuario_ID'];

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
        $this->valor_venta_soles;
        $this->valor_venta_dolares;
        $this->visc_soles;
        $this->visc_dolares;
        $this->descuento_item_soles;
        $this->descuento_item_dolares;
        $this->mostrar_precio_unitario;
        $this->usuario_id;
        $this->usuario_mod_id;

      }
    function insertar()
    {
        
        $retornar=-1;
        try{
            $fecha_save='NULL';
            if($this->fecha!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha,'Y-m-d').'"';
            }
           $q='select ifnull(max(ID),0)+1 as ID from salida;';
           $cn =new connect_new();
           $ID=$cn->getData($q);
            $q='INSERT INTO salida(ID,empresa_ID,cotizacion_ID,cliente_ID,cliente_contacto_ID,operador_ID,periodo,numero,';
            $q.='numero_concatenado,numero_orden_compra,moneda_ID,fecha,igv,vigv_soles,vigv_dolares,precio_venta_neto_soles,';
            $q.='precio_venta_total_soles,precio_venta_neto_dolares,precio_venta_total_dolares,forma_pago_ID,';
            $q.='tiempo_credito,descuento_soles,descuento_dolares,estado_ID,tipo_cambio,plazo_entrega,lugar_entrega,';
            $q.='validez_oferta,garantia,observacion,numero_pagina,nproducto_pagina,ver_adicional,adicional,tipo_ID,usuario_id)';
            $q.='values ('.$ID.','.$_GET['empresa_ID'].','.$this->cotizacion_ID.','.$this->cliente_ID.','.$this->cliente_contacto_ID.','.$this->operador_ID.',';
            $q.=$this->periodo.','.$this->numero.',"'.$this->numero_concatenado.'","'.$this->numero_orden_compra.'",'.$this->moneda_ID.','.$fecha_save.','.$this->igv.',';
            $q.=$this->vigv_soles.','.$this->vigv_dolares.','.$this->precio_venta_neto_soles.','.$this->precio_venta_total_soles.','.$this->precio_venta_neto_dolares.',';
            $q.=$this->precio_venta_total_dolares.','.$this->forma_pago_ID.','.$this->tiempo_credito.','.$this->descuento_soles.','.$this->descuento_dolares.','.$this->estado_ID.',';
            $q.=$this->tipo_cambio.','.$this->plazo_entrega.',"'.$this->lugar_entrega.'","'.$this->validez_oferta.'","'.$this->garantia.'","'.$this->observacion.'",';
            $q.=$this->numero_pagina.',"'.$this->nproducto_pagina.'",'.$this->ver_adicional.',"'.$this->adicional.'",'.$this->tipo_ID.','.$this->usuario_id.')';
            $cn =new connect_new();
            $retornar=$cn->transa($q);
            //echo $q;
            $this->ID=$ID;
            $this->getMessage='Se actualizó correctamente';

            return $retornar;

        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    function actualizar(){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $fecha_save='NULL';
            if($this->fecha!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha,'Y-m-d').'"';
            }
            $q='UPDATE salida SET cotizacion_ID='.$this->cotizacion_ID.',cliente_ID='.$this->cliente_ID.','
                    . 'cliente_contacto_ID='.$this->cliente_contacto_ID.',operador_ID='.$this->operador_ID.','
                    . 'periodo='.$this->periodo.',numero='.$this->numero.',numero_concatenado="'.$this->numero_concatenado.'",'
                    . 'numero_orden_compra="'.$this->numero_orden_compra.'",moneda_ID='.$this->moneda_ID.',fecha='.$fecha_save.','
                    . 'igv='.$this->igv.',vigv_soles='.$this->vigv_soles.',vigv_dolares='.$this->vigv_dolares.',precio_venta_neto_soles='.$this->precio_venta_neto_soles.','
                    . 'precio_venta_total_soles='.$this->precio_venta_total_soles.',precio_venta_neto_dolares='.$this->precio_venta_neto_dolares.','
                    . 'precio_venta_total_dolares='.$this->precio_venta_total_dolares.',forma_pago_ID='.$this->forma_pago_ID.',tiempo_credito='.$this->tiempo_credito.','
                    . 'descuento_soles='.$this->descuento_soles.',descuento_dolares='.$this->descuento_dolares.',estado_ID='.$this->estado_ID.','
                    . 'tipo_cambio='.$this->tipo_cambio.',lugar_entrega="'.$this->lugar_entrega.'",plazo_entrega="'.$this->plazo_entrega.'",'
                    . 'validez_oferta="'.$this->validez_oferta.'",garantia="'.$this->garantia.'",observacion="'.$this->observacion.'",numero_pagina='.$this->numero_pagina.','
                    .' nproducto_pagina="'.$this->nproducto_pagina.'",ver_adicional='.$this->ver_adicional.', adicional="'.$this->adicional.'",isc='.$this->isc.','
                    .'detraccion='.$this->detraccion.',porcentaje_descuento='.$this->porcentaje_descuento.',anticipos='.$this->anticipos.',exoneradas='.$this->exoneradas
                    .',inafectas='.$this->inafectas.',gravadas='.$this->gravadas.',gratuitas='.$this->gratuitas.',otros_cargos='.$this->otros_cargos
                    .',descuento_global='.$this->descuento_global.',monto_detraccion='.$this->monto_detraccion.',usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->getMessage='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    //codigo ortega-aprobar cotizacion
    function aprobarCotizacion($id){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $q='update cotizacion set estado_ID=3';
            $q.=', fdm=now() where del=0 and ID='.$id;
            $retornar=$cn->transa($q);
            $this->getMessage='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
    }
    function actualizarCosto(){
        $cn =new connect_new();
	$retornar=-1;
        try{
            $q='update cotizacion set precio_venta_total_soles='.$this->precio_venta_total_soles.', igv='.$this->igv.', precio_venta_total_dolares='.$this->precio_venta_total_dolares.', usuario_mod_id='. $this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and id='.$this->ID;
            $retornar=$cn->transa($q);
            $this->getMessage='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {
        throw new Exception("Ocurrio un error en la consulta");
        }
    }
  function actualizarImpresion($valor){
        $cn =new connect_new();
	      $retornar=-1;
        try{
            $q='update salida set impresion='.$valor.', usuario_mod_id='.$this->usuario_mod_id;
            $q.=' where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->getMessage='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {
        throw new Exception("Ocurrio un error en la consulta");
        }
    }

    function eliminar(){
            $cn =new connect_new();
            $retornar=-1;
            try{

                    $q='UPDATE salida SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                    $q.=' WHERE del=0 and ID='.$this->ID;

                    $retornar=$cn->transa($q);

                    $this->getMessage='Se eliminó correctamente';
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
            $q='SELECT  count(ov.ID)';
            $q.=' FROM salida ov,cliente cl, estado es ';
            $q.=' where ov.del=0 and ov.cliente_ID=cl.ID and ov.estado_ID=es.ID and ov.empresa_ID='.$_GET['empresa_ID'];
            if ($filtro!='')
            {
                    $q.=' and '.$filtro;
            }
            //echo $q;
            $resultado=$cn->getData($q);

            return $resultado;
        }catch(Exception $ex)
        {
                throw new Exception($q);
        }
    }
        //modificado por ortega-agregar todos los datos y cargar en el modelo
  /* static function getByID($ID)
	{
            $cn =new connect_new();
            try
            {
                $q='SELECT  ID,empresa_ID,ifNull(cotizacion_ID,-1) as cotizacion_ID ,cliente_ID,cliente_contacto_ID,operador_ID,periodo,numero,';
                $q.='numero_concatenado,numero_orden_compra,moneda_ID,DATE_FORMAT(fecha,"%d/%m/%Y") as fecha,igv,vigv_soles,vigv_dolares,precio_venta_neto_soles,';
                $q.='precio_venta_total_soles,precio_venta_neto_dolares,precio_venta_total_dolares,forma_pago_ID,';
                $q.='tiempo_credito,descuento_soles,descuento_dolares,estado_ID,tipo_cambio,plazo_entrega,lugar_entrega,validez_oferta,garantia,observacion,numero_pagina,nproducto_pagina,impresion,ver_adicional,adicional,';
                $q.='isc,detraccion,porcentaje_descuento,anticipos,exoneradas,inafectas,gravadas,gratuitas,otros_cargos,descuento_global,monto_detraccion,usuario_id ';
                $q.=' FROM salida ';
                $q.=' where del=0 and ID='.$ID;
                    //echo $q;
                $dt=$cn->getGrid($q);
                $osalida=null;

                foreach($dt as $item)
                {
                    $osalida=new salida();
                    $osalida->ID=$item['ID'];
                    $osalida->empresa_ID=$item['empresa_ID'];
                    $osalida->cotizacion_ID=$item['cotizacion_ID'];
                    $osalida->cliente_ID=$item['cliente_ID'];
                    $osalida->cliente_contacto_ID=$item['cliente_contacto_ID'];
                    $osalida->operador_ID=$item['operador_ID'];
                    $osalida->periodo=$item['periodo'];
                    $osalida->numero=$item['numero'];
                    $osalida->numero_concatenado=$item['numero_concatenado'];
                    $osalida->numero_orden_compra=$item['numero_orden_compra'];
                    $osalida->moneda_ID=$item['moneda_ID'];
                    $osalida->fecha=$item['fecha'];
                    $osalida->igv=$item['igv'];
                    $osalida->vigv_soles=$item['vigv_soles'];
                    $osalida->vigv_dolares=$item['vigv_dolares'];
                    $osalida->precio_venta_neto_soles=$item['precio_venta_neto_soles'];
                    $osalida->precio_venta_total_soles=$item['precio_venta_total_soles'];
                    $osalida->precio_venta_neto_dolares=$item['precio_venta_neto_dolares'];
                    $osalida->precio_venta_total_dolares=$item['precio_venta_total_dolares'];
                    $osalida->forma_pago_ID=$item['forma_pago_ID'];
                    $osalida->tiempo_credito=$item['tiempo_credito'];
                    $osalida->descuento_soles=$item['descuento_soles'];
                    $osalida->descuento_dolares=$item['descuento_dolares'];
                    $osalida->estado_ID=$item['estado_ID'];
                    $osalida->tipo_cambio=$item['tipo_cambio'];
                    $osalida->plazo_entrega=$item['plazo_entrega'];
                    $osalida->lugar_entrega=$item['lugar_entrega'];
                    $osalida->validez_oferta=$item['validez_oferta'];
                    $osalida->garantia=$item['garantia'];
                    $osalida->observacion=$item['observacion'];
                    $osalida->numero_pagina=$item['numero_pagina'];
                    $osalida->nproducto_pagina=$item['nproducto_pagina'];
                    $osalida->impresion=$item['impresion'];
                    $osalida->usuario_id=$item['usuario_id'];
                    $osalida->ver_adicional=$item['ver_adicional'];
                    $osalida->adicional=$item['adicional'];
                    $osalida->isc=$item['isc'];
                    $osalida->detraccion=$item['detraccion'];
                    $osalida->porcentaje_descuento=$item['porcentaje_descuento'];
                    $osalida->anticipos=$item['anticipos'];
                    $osalida->exoneradas=$item['exoneradas'];
                    $osalida->inafectas=$item['inafectas'];
                    $osalida->gravadas=$item['gravadas'];
                    $osalida->gratuitas=$item['gratuitas'];
                    $osalida->otros_cargos=$item['otros_cargos'];
                    $osalida->descuento_global=$item['descuento_global'];
                    $osalida->monto_detraccion=$item['monto_detraccion'];
                }
                return $osalida;

		}catch(Exeption $ex)
		{
                    throw new Exception($q);
		}
	}
*/
   static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_salida_getByID",
          array('iID'=>$ID));
        $osalida=null;
        foreach($dt as $item){
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
            $osalida->vigv_soles=round($item["vigv_soles"],2);
            $osalida->vigv_dolares=round($item["vigv_dolares"],2);
            $osalida->precio_venta_neto_soles=round($item["precio_venta_neto_soles"],2);
            $osalida->precio_venta_total_soles=round($item["precio_venta_total_soles"],2);
            $osalida->precio_venta_neto_dolares=round($item["precio_venta_neto_dolares"],2);
            $osalida->precio_venta_total_dolares=round($item["precio_venta_total_dolares"],2);
            $osalida->forma_pago_ID=$item["forma_pago_ID"];
            $osalida->tiempo_credito=$item["tiempo_credito"];
            $osalida->descuento_soles=round($item["descuento_soles"],2);
            $osalida->descuento_dolares=round($item["descuento_dolares"],2);
            $osalida->estado_ID=$item["estado_ID"];
            $osalida->tipo_cambio=round($item["tipo_cambio"],2);
            $osalida->lugar_entrega=$item["lugar_entrega"];
            $osalida->plazo_entrega=$item["plazo_entrega"];
            $osalida->validez_oferta=$item["validez_oferta"];
            $osalida->garantia= $item["garantia"];
            $osalida->observacion=$item["observacion"];
            $osalida->nproducto_pagina=$item["nproducto_pagina"];
            $osalida->numero_pagina=$item["numero_pagina"];
            $osalida->impresion=$item["impresion"];
            $osalida->adicional=$item["adicional"];
            $osalida->ver_adicional=$item["ver_adicional"];
            $osalida->tipo=$item["tipo"];
            $osalida->isc=$item["isc"];
            $osalida->detraccion=$item["detraccion"];
            $osalida->porcentaje_descuento=round($item["porcentaje_descuento"],2);
            $osalida->anticipos=round($item["anticipos"],2);
            $osalida->exoneradas=round($item["exoneradas"],2);
            $osalida->inafectas=round($item["inafectas"],2);
            $osalida->gravadas=round($item["gravadas"],2);
            $osalida->gratuitas=round($item["gratuitas"],2);
            $osalida->otros_cargos=round($item["otros_cargos"],2);
            $osalida->descuento_global=round($item["descuento_global"],2);
            $osalida->monto_detraccion=round($item["monto_detraccion"],2);
            $osalida->tipo_ID=$item["tipo_ID"];
            $osalida->valor_venta_soles=round($item["valor_venta_soles"],2);
            $osalida->valor_venta_dolares=round($item["valor_venta_dolares"],2);
            $osalida->visc_soles=round($item["visc_soles"],2);
            $osalida->visc_dolares=round($item["visc_dolares"],2);
            $osalida->descuento_item_soles=round($item["descuento_item_soles"],2);
            $osalida->descuento_item_dolares=round($item["descuento_item_dolares"],2);
            $osalida->mostrar_precio_unitario=$item["mostrar_precio_unitario"];
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
  static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ov.ID asc')
	{
		$cn =new connect_new();
		try
		{
        $q='SELECT ifnull(fvs.codigo_estado,-1) as sunat_codigo_estado,fv.ID as factura_venta_ID,fvs.codigo_estado,fvs.descripcion_estado,ov.ID,ov.empresa_ID,ifNull(ov.cotizacion_ID,-1) as cotizacion_ID,ov.cliente_ID,ov.cliente_contacto_ID,ov.operador_ID,ov.periodo,ov.numero,ov.';
        $q.='numero_concatenado,ov.numero_orden_compra,ov.moneda_ID,date_format(ov.fecha,"%d/%m/%Y") as fecha,ov.igv,ov.vigv_soles,ov.vigv_dolares,ov.precio_venta_neto_soles,ov.';
        $q.='precio_venta_total_soles,ov.precio_venta_neto_dolares,ov.precio_venta_total_dolares,ov.forma_pago_ID,ov.';
        $q.='tiempo_credito,ov.descuento_soles,ov.descuento_dolares,ov.estado_ID,ov.tipo_cambio,ov.plazo_entrega,ov.lugar_entrega,ov.validez_oferta,ov.garantia,ov.observacion,ov.usuario_id,ov.usuario_mod_id,ov.impresion, ';
        $q.='cl.razon_social ,es.nombre as estado,';
        $q.=' fvs.descripcion_estado as estado_sunat';
        $q.=' FROM salida ov ';
        $q.=' inner join factura_venta fv on ov.ID = fv.salida_ID';
        $q.=' inner join cliente cl on ov.cliente_ID=cl.ID';
        $q.=' inner join estado es on ov.estado_ID=es.ID';
        $q.=' left join factura_venta_sunat fvs on fvs.factura_venta_ID = fv.ID and fvs.del=0 and fv.ID in (select max(ID) from factura_venta_sunat where del=0 and factura_venta_ID=fv.ID)';
        $q.=' where ov.del=0';

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
    static function getTabla($opcion,$cliente_ID,$todos,$fecha_inicio,$fecha_fin,$estado_ID,$moneda_ID,$periodo_texto,$numero,$numero_factura,$tipo_ID)
    {
        //$cn =new connect_new();
        $cn=new connect_new();
        try
        {
            
        //$q='call getTabla_Orden_Venta("'.$opcion.'",'.$_GET['empresa_ID'].','.$cliente_ID.','.$todos.',"'.$fecha_inicio.'","'.$fecha_fin.'",'.$estado_ID.','.$moneda_ID.',"'.$periodo_texto.'",'.$numero.','.$numero_factura.');';
        //console_log($q);
        //$dt=$cn->getTabla($q);
        $dt=$cn->store_procedure_getGridParse(
                'sp_salida_getTabla_Orden_Venta',
                array(
                    'opcion'=>$opcion,
                    'empresa_ID'=>$_GET['empresa_ID'],
                    'cliente_ID'=>$cliente_ID,
                    'periodo'=>$todos,
                    'fecha_inicio'=>$fecha_inicio,
                    'fecha_fin'=>$fecha_fin,
                    'estado_ID'=>$estado_ID,
                    'moneda_ID'=>$moneda_ID,
                    'periodo2'=>$periodo_texto,
                    'inumero'=>$numero,
                    'inumero_factura'=>$numero_factura,
                    'tipo_ID'=>$tipo_ID)
                );
        //var_dump($dt);
        return $dt;
        }catch(Exception $ex)
        {
            log_error(__FILE__, "salida.getTabla", $ex->getMessage());
                throw new Exception("Ocurrió un error en el sistema");
        }
    }
    static function getPeriodos()
    {
        $cn =new connect_new();
        try
        {
            $q='select DISTINCT periodo from salida where del=0 and empresa_ID='.$_GET['empresa_ID'];
                //echo $q;
                $dt=$cn->getGrid($q);
                return $dt;
        }catch(Exception $ex)
        {
                throw new Exception($q);
        }
    }

    static function getNumero(){
      $cn =new connect_new();
      $numero=0;
        try{
            //$q='select ifnull(max(numero),0) +1 as numero from salida where empresa_ID='.$_GET['empresa_ID'];
            $retorna=$cn->store_procedure_getData('sp_salida_getNumero', 
                    array('iempresa_ID'=>$_GET['empresa_ID']));
            //$numero=$cn->getData($q);
           
            return $retorna;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }

    }
     static function verificarDisponibilidadImpresora()
	{
            $cn =new connect_new();
            try
            {
                $q='SELECT  count(ov.ID)';
                $q.=' FROM salida ov,cliente cl, estado es ';
                $q.=' where ov.del=0 and ov.cliente_ID=cl.ID and ov.estado_ID=es.ID and ov.empresa_ID='.$_GET['empresa_ID'];
                if ($filtro!='')
                {
                    $q.=' and '.$filtro;
                }
                //echo $q;
                $resultado=$cn->getData($q);

                return $resultado;
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
	}
    function liberarImpresora(){
        $cn =new connect_new();
            try
            {
                $q='update salida set impresion=0 where ID='. $this->ID;
                $resultado=$cn->transa($q);
                $q='update factura_venta set con_guia=0 where salida_ID='. $this->ID;
                $resultado=$cn->transa($q);
                return $resultado;
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
    }




	// inicio de reportes dasboard de ventas//



        static function MostrarGrafico_DiarioSoles() {
        $cn = new connect_new();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = ' select ov.fecha,dayname(ov.fecha) as dia, sum(ov.precio_venta_total_soles) as total_dia , ov.moneda_ID ';
            $q.='from salida ov ';
            $q.='  where ov.empresa_ID='.$_GET['empresa_ID'].' and YEARWEEK(ov.fecha) =  YEARWEEK(CURDATE()) and ov.moneda_ID = 1 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42)  ';
            $q.=' group by ov.fecha ';
     //       $q.=' order by day(co.fecha_emision) desc';
            $q.=' limit 7 ';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }


        static function MostrarGrafico_DiarioDolares() {
        $cn = new connect_new();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'select ov.fecha,dayname(ov.fecha) as dia, sum(ov.precio_venta_total_dolares) as total_dia , ov.moneda_ID ';
            $q.='from salida ov ';
            $q.=' where empresa_ID='.$_GET['empresa_ID'].' and  YEARWEEK(ov.fecha) =  YEARWEEK(CURDATE()) and ov.moneda_ID = 2 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42) ';
            $q.=' group by ov.fecha ';
     //       $q.=' order by day(co.fecha_emision) desc';
            $q.=' limit 7 ';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }


       static function MostrarGrafico_DiarioxMesSoles() {
        $cn = new connect_new();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = ' select ov.fecha, DAYOFMONTH(ov.fecha) as numero_dia, monthname(ov.fecha) as mes, sum(ov.precio_venta_total_soles) as total_dia, ov.moneda_ID ';
            $q.='from salida ov  ';
            $q.='  where month(ov.fecha) = month(curdate()) and ov.moneda_ID = 1 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42) ';
            $q.=' group by day(ov.fecha) ';
     //       $q.=' order by day(co.fecha_emision) desc';
            $q.=' limit 31 ';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }


           static function MostrarGrafico_DiarioxMesDolares() {
        $cn = new connect_new();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = ' select ov.fecha, DAYOFMONTH(ov.fecha) as numero_dia, monthname(ov.fecha) as mes, sum(ov.precio_venta_total_dolares) as total_dia, ov.moneda_ID ';
            $q.='from salida ov  ';
            $q.='   where month(ov.fecha) = month(curdate()) and ov.moneda_ID = 2 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42) ';
            $q.=' group by day(ov.fecha)   ';
     //       $q.=' order by day(co.fecha_emision) desc';
            $q.=' limit 31 ';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }



        static function MostrarGrafico_MensualSoles() {
        $cn = new connect_new();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'SELECT monthname(ov.fecha) as mes, sum(ov.precio_venta_total_soles) as total_mes, ov.moneda_ID ';
            $q.='from salida ov ';
            $q.=' where year(ov.fecha) = year(curdate()) and ov.moneda_ID = 1 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42) ';
            $q.=' group by monthname(ov.fecha) ';
  //          $q.=' order by month(co.fecha_emision) desc';
            $q.=' limit 12';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }


            static function MostrarGrafico_MensualDolares() {
        $cn = new connect_new();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'SELECT monthname(ov.fecha) as mes, sum(ov.precio_venta_total_dolares) as total_mes, ov.moneda_ID ';
            $q.='from salida ov ';
            $q.=' where year(ov.fecha) = year(curdate()) and ov.moneda_ID = 2 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42) ';
            $q.=' group by monthname(ov.fecha) ';
  //          $q.=' order by month(co.fecha_emision) desc';
            $q.=' limit 12';

//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }


       static function MostrarGrafico_AnualSoles() {
        $cn = new connect_new();
        try {
            $q = 'SELECT year(ov.fecha) as anio, sum(ov.precio_venta_total_soles) as total_anio, ov.moneda_ID ';
            $q.='from salida ov ';
            $q.='where ov.moneda_ID = 1 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42) ';
            $q.='group by year(ov.fecha)  ';
     //       $q.=' order by day(co.fecha_emision) desc';
//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }



    static function MostrarGrafico_AnualDolares() {
        $cn = new connect_new();
        try {
            $q = 'SELECT year(ov.fecha) as anio, sum(ov.precio_venta_total_dolares) as total_anio, ov.moneda_ID  ';
            $q.='from salida ov ';
            $q.='where ov.moneda_ID = 2 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42) ';
            $q.='group by year(ov.fecha)   ';
     //       $q.=' order by day(co.fecha_emision) desc';
//            echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function insertar_new()
    {
        $cn =new connect_new();
        try
        {
          $ID=$cn->store_procedure_transa(
              "sp_salida_Insert",
                array(
                "iID"=>0,
                "iempresa_ID"=>$_GET['empresa_ID'],
                "icotizacion_ID"=>$this->cotizacion_ID,
                "icliente_ID"=>$this->cliente_ID,
                "icliente_contacto_ID"=>$this->cliente_contacto_ID,
                "ioperador_ID"=>$this->operador_ID,
                "iperiodo"=>$this->periodo,
                "inumero"=>$this->numero,
                "inumero_concatenado"=>$this->numero_concatenado,
                "inumero_orden_compra"=>$this->numero_orden_compra,
                "imoneda_ID"=>$this->moneda_ID,
                "ifecha"=>FormatTextToDate($this->fecha,'Y-m-d'),
                "iigv"=>$this->igv,
                "ivigv_soles"=>$this->vigv_soles,
                "ivigv_dolares"=>$this->vigv_dolares,
                "iprecio_venta_neto_soles"=>$this->precio_venta_neto_soles,
                "iprecio_venta_total_soles"=>$this->precio_venta_total_soles,
                "iprecio_venta_neto_dolares"=>$this->precio_venta_neto_dolares,
                "iprecio_venta_total_dolares"=>$this->precio_venta_total_dolares,
                "iforma_pago_ID"=>$this->forma_pago_ID,
                "itiempo_credito"=>$this->tiempo_credito,
                "idescuento_soles"=>$this->descuento_soles,
                "idescuento_dolares"=>$this->descuento_dolares,
                "iestado_ID"=>$this->estado_ID,
                "itipo_cambio"=>$this->tipo_cambio,
                "ilugar_entrega"=>$this->lugar_entrega,
                "iplazo_entrega"=>$this->plazo_entrega,
                "ivalidez_oferta"=>$this->validez_oferta,
                "igarantia"=>$this->garantia,
                "iobservacion"=>$this->observacion,
                "inproducto_pagina"=>$this->nproducto_pagina,
                "inumero_pagina"=>$this->numero_pagina,
                "iimpresion"=>$this->impresion,
                "iadicional"=>$this->adicional,
                "iver_adicional"=>$this->ver_adicional,
                "itipo"=>$this->tipo,
                "iisc"=>$this->isc,
                "idetraccion"=>$this->detraccion,
                "iporcentaje_descuento"=>$this->porcentaje_descuento,
                "ianticipos"=>$this->anticipos,
                "iexoneradas"=>$this->exoneradas,
                "iinafectas"=>$this->inafectas,
                "igravadas"=>$this->gravadas,
                "igratuitas"=>$this->gratuitas,
                "iotros_cargos"=>$this->otros_cargos,
                "idescuento_global"=>$this->descuento_global,
                "imonto_detraccion"=>$this->monto_detraccion,
                "itipo_ID"=>$this->tipo_ID,
                "imostrar_precio_unitario"=>$this->mostrar_precio_unitario,
                "iusuario_id"=>$this->usuario_id,
                "cadena_numero_cuenta"=>$this->cadena_numero_cuenta  
            ),0);
          if($ID>0){
            $this->ID=$ID;
          }
          
          return $ID;
        }catch(Exeption $ex)
        {
          throw new Exception($ex->getMessage());
        }
    }
    function actualizar_new()
    {
    $cn =new connect_new();
    $retornar=0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_salida_Update",
            array(
                "retornar"=>$retornar,
                "iID"=>$this->ID,
                "iempresa_ID"=>$this->empresa_ID,
                "icotizacion_ID"=>$this->cotizacion_ID,
                "icliente_ID"=>$this->cliente_ID,
                "icliente_contacto_ID"=>$this->cliente_contacto_ID,
                "ioperador_ID"=>$this->operador_ID,
                "iperiodo"=>$this->periodo,
                "inumero"=>$this->numero,
                "inumero_concatenado"=>$this->numero_concatenado,
                "inumero_orden_compra"=>$this->numero_orden_compra,
                "imoneda_ID"=>$this->moneda_ID,
                "ifecha"=>FormatTextToDate($this->fecha,'Y-m-d'),
                "iigv"=>$this->igv,
                "ivigv_soles"=>$this->vigv_soles,
                "ivigv_dolares"=>$this->vigv_dolares,
                "iprecio_venta_neto_soles"=>$this->precio_venta_neto_soles,
                "iprecio_venta_total_soles"=>$this->precio_venta_total_soles,
                "iprecio_venta_neto_dolares"=>$this->precio_venta_neto_dolares,
                "iprecio_venta_total_dolares"=>$this->precio_venta_total_dolares,
                "iforma_pago_ID"=>$this->forma_pago_ID,
                "itiempo_credito"=>$this->tiempo_credito,
                "idescuento_soles"=>$this->descuento_soles,
                "idescuento_dolares"=>$this->descuento_dolares,
                "iestado_ID"=>$this->estado_ID,
                "itipo_cambio"=>$this->tipo_cambio,
                "ilugar_entrega"=>$this->lugar_entrega,
                "iplazo_entrega"=>$this->plazo_entrega,
                "ivalidez_oferta"=>$this->validez_oferta,
                "igarantia"=>$this->garantia,
                "iobservacion"=>$this->observacion,
                "inproducto_pagina"=>$this->nproducto_pagina,
                "inumero_pagina"=>$this->numero_pagina,
                "iimpresion"=>$this->impresion,
                "iadicional"=>$this->adicional,
                "iver_adicional"=>$this->ver_adicional,
                "itipo"=>$this->tipo,
                "iisc"=>$this->isc,
                "idetraccion"=>$this->detraccion,
                "iporcentaje_descuento"=>$this->porcentaje_descuento,
                "ianticipos"=>$this->anticipos,
                "iexoneradas"=>$this->exoneradas,
                "iinafectas"=>$this->inafectas,
                "igravadas"=>$this->gravadas,
                "igratuitas"=>$this->gratuitas,
                "iotros_cargos"=>$this->otros_cargos,
                "idescuento_global"=>$this->descuento_global,
                "imonto_detraccion"=>$this->monto_detraccion,
                "itipo_ID"=>$this->tipo_ID,
                "ivalor_venta_soles"=>$this->valor_venta_soles,
                "ivalor_venta_dolares"=>$this->valor_venta_dolares,
                "ivisc_soles"=>$this->visc_soles,
                "ivisc_dolares"=>$this->visc_dolares,
                "idescuento_item_soles"=>$this->descuento_item_soles,
                "idescuento_item_dolares"=>$this->descuento_item_dolares,
                "imostrar_precio_unitario"=>$this->mostrar_precio_unitario,
                "iusuario_mod_id"=>$this->usuario_mod_id,
                "cadena_numero_cuenta"=>$this->cadena_numero_cuenta),0);
      if($retornar>0)$this->getMessage="Se actualizó correctamente";
      return $retornar;
    }catch(Exeption $ex)
    {
      throw new Exception();
       log_error(__FILE__,"salida.actualizar_new",$ex->getMessage());
    }
  }
  static function anular($ID,$usuario_mod_id)
    {
    $cn =new connect_new();
    $retornar=0;
    try
    {
      $retornar=$cn->store_procedure_transa(
          "sp_salida_Anular",
            array(
                "retornar"=>$retornar,
                "iID"=>$ID,
                "iusuario_mod_id"=>$usuario_mod_id),0);
     
      return $retornar;
    }catch(Exeption $ex)
    {
      throw new Exception();
       log_error(__FILE__,"salida.actualizar_new",$ex->getMessage());
    }
  }
  static function getTabla_Orden_Venta()
    {
        //$cn =new connect_new();
        $cn=new connect_new();
        try
        {
            
        //$q='call getTabla_Orden_Venta("'.$opcion.'",'.$_GET['empresa_ID'].','.$cliente_ID.','.$todos.',"'.$fecha_inicio.'","'.$fecha_fin.'",'.$estado_ID.','.$moneda_ID.',"'.$periodo_texto.'",'.$numero.','.$numero_factura.');';
        //console_log($q);
        //$dt=$cn->getTabla($q);
        $dt=$cn->store_procedure_getGrid(
                'sp_salida_getReporte',
                array(                
                    'iempresa_ID'=>$_GET['empresa_ID'])
                );
        //var_dump($dt);
        return $dt;
        }catch(Exception $ex)
        {
            log_error(__FILE__, "salida.getTabla", $ex->getMessage());
                throw new Exception("Ocurrió un error en el sistema");
        }
    }
  }


?>
