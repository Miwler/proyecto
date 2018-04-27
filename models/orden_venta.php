<?php

class orden_venta {
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
    Private $getMessage;
    Private $bloquear_edicion;
    Private $dtRepresentante_Cliente;
    Private $ver_factura;
    Private $ver_guia;

  public function __set($var, $valor)
    {
// convierte a minúsculas toda una cadena la función strtolower
          $temporal = $var;

          // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
          if (property_exists('orden_venta',$temporal))
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
        if (property_exists('orden_venta', $temporal))
         {
                return $this->$temporal;
         }

        // Retorna nulo si no existe
        return null;
    }
    function insertar()
    {
        $cn =new connect();
        $retornar=-1;
        try{
            $fecha_save='NULL';
            if($this->fecha!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha,'Y-m-d').'"';
            }
           $q='select ifnull(max(ID),0)+1 as ID from orden_venta;';
           $ID=$cn->getData($q);
            $q='INSERT INTO orden_venta (ID,empresa_ID,cotizacion_ID,cliente_ID,cliente_contacto_ID,operador_ID,periodo,numero,';
            $q.='numero_concatenado,numero_orden_compra,moneda_ID,fecha,igv,vigv_soles,vigv_dolares,precio_venta_neto_soles,';
            $q.='precio_venta_total_soles,precio_venta_neto_dolares,precio_venta_total_dolares,forma_pago_ID,';
            $q.='tiempo_credito,descuento_soles,descuento_dolares,estado_ID,tipo_cambio,plazo_entrega,lugar_entrega,';
            $q.='validez_oferta,garantia,observacion,numero_pagina,nproducto_pagina,ver_adicional,adicional,usuario_id)';
            $q.='values ('.$ID.','.$_SESSION['empresa_ID'].','.$this->cotizacion_ID.','.$this->cliente_ID.','.$this->cliente_contacto_ID.','.$this->operador_ID.',';
            $q.=$this->periodo.','.$this->numero.',"'.$this->numero_concatenado.'","'.$this->numero_orden_compra.'",'.$this->moneda_ID.','.$fecha_save.','.$this->igv.',';
            $q.=$this->vigv_soles.','.$this->vigv_dolares.','.$this->precio_venta_neto_soles.','.$this->precio_venta_total_soles.','.$this->precio_venta_neto_dolares.',';
            $q.=$this->precio_venta_total_dolares.','.$this->forma_pago_ID.','.$this->tiempo_credito.','.$this->descuento_soles.','.$this->descuento_dolares.','.$this->estado_ID.',';
            $q.=$this->tipo_cambio.','.$this->plazo_entrega.',"'.$this->lugar_entrega.'","'.$this->validez_oferta.'","'.$this->garantia.'","'.$this->observacion.'",';
            $q.=$this->numero_pagina.',"'.$this->nproducto_pagina.'",'.$this->ver_adicional.',"'.$this->adicional.'",'.$this->usuario_id.')';

            $retornar=$cn->transa($q);
            //echo $q;
            $this->ID=$ID;
            $this->getMessage='Se guardó correctamente';
            
            return $retornar;
            
        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    function actualizar(){
        $cn =new connect();
	$retornar=-1;
        try{
            $fecha_save='NULL';
            if($this->fecha!=null){
                $fecha_save='"'.FormatTextToDate($this->fecha,'Y-m-d').'"';
            }
            $q='UPDATE orden_venta SET cotizacion_ID='.$this->cotizacion_ID.',cliente_ID='.$this->cliente_ID.','
                    . 'cliente_contacto_ID='.$this->cliente_contacto_ID.',operador_ID='.$this->operador_ID.','
                    . 'periodo='.$this->periodo.',numero='.$this->numero.',numero_concatenado="'.$this->numero_concatenado.'",'
                    . 'numero_orden_compra="'.$this->numero_orden_compra.'",moneda_ID='.$this->moneda_ID.',fecha='.$fecha_save.','
                    . 'igv='.$this->igv.',vigv_soles='.$this->vigv_soles.',vigv_dolares='.$this->vigv_dolares.',precio_venta_neto_soles='.$this->precio_venta_neto_soles.','
                    . 'precio_venta_total_soles='.$this->precio_venta_total_soles.',precio_venta_neto_dolares='.$this->precio_venta_neto_dolares.','
                    . 'precio_venta_total_dolares='.$this->precio_venta_total_dolares.',forma_pago_ID='.$this->forma_pago_ID.',tiempo_credito='.$this->tiempo_credito.','
                    . 'descuento_soles='.$this->descuento_soles.',descuento_dolares='.$this->descuento_dolares.',estado_ID='.$this->estado_ID.','
                    . 'tipo_cambio='.$this->tipo_cambio.',lugar_entrega="'.$this->lugar_entrega.'",plazo_entrega="'.$this->plazo_entrega.'",'
                    . 'validez_oferta="'.$this->validez_oferta.'",garantia="'.$this->garantia.'",observacion="'.$this->observacion.'",numero_pagina='.$this->numero_pagina.','
                    .' nproducto_pagina="'.$this->nproducto_pagina.'",ver_adicional='.$this->ver_adicional.', adicional="'.$this->adicional.'",usuario_mod_id='.$this->usuario_mod_id;
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
        $cn =new connect();
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
        $cn =new connect();
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
        $cn =new connect();
	$retornar=-1;
        try{
            $q='update orden_venta set impresion='.$valor.', usuario_mod_id='.$this->usuario_mod_id;
            $q.=' where del=0 and id='.$this->ID;
            $retornar=$cn->transa($q);
            $this->getMessage='Se guardó correctamente';
            //echo $q;
            return $retornar;
        } catch (Exception $ex) {
        throw new Exception("Ocurrio un error en la consulta");
        }
    }
    
    function eliminar(){
            $cn =new connect();
            $retornar=-1;
            try{

                    $q='UPDATE orden_venta SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
        $cn =new connect();
        try 
        {
            $q='SELECT  count(ov.ID)';
            $q.=' FROM orden_venta ov,cliente cl, estado es ';
            $q.=' where ov.del=0 and ov.cliente_ID=cl.ID and ov.estado_ID=es.ID and ov.empresa_ID='.$_SESSION['empresa_ID'];
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
   static function getByID($ID)
	{
		$cn =new connect();
		try 
		{
                    $q='SELECT  ID,empresa_ID,ifNull(cotizacion_ID,-1) as cotizacion_ID ,cliente_ID,cliente_contacto_ID,operador_ID,periodo,numero,';
                    $q.='numero_concatenado,numero_orden_compra,moneda_ID,DATE_FORMAT(fecha,"%d/%m/%Y") as fecha,igv,vigv_soles,vigv_dolares,precio_venta_neto_soles,';
                    $q.='precio_venta_total_soles,precio_venta_neto_dolares,precio_venta_total_dolares,forma_pago_ID,';
                    $q.='tiempo_credito,descuento_soles,descuento_dolares,estado_ID,tipo_cambio,plazo_entrega,lugar_entrega,validez_oferta,garantia,observacion,numero_pagina,nproducto_pagina,impresion,ver_adicional,adicional,usuario_id ';
                    $q.=' FROM orden_venta ';
                    $q.=' where del=0 and ID='.$ID;
			//echo $q;
			$dt=$cn->getGrid($q);			
			$oOrden_Venta=null;
			
			foreach($dt as $item)
			{
                            $oOrden_Venta=new orden_venta();
                            $oOrden_Venta->ID=$item['ID'];
                            $oOrden_Venta->empresa_ID=$item['empresa_ID'];
                            $oOrden_Venta->cotizacion_ID=$item['cotizacion_ID'];
                            $oOrden_Venta->cliente_ID=$item['cliente_ID'];
                            $oOrden_Venta->cliente_contacto_ID=$item['cliente_contacto_ID'];
                            $oOrden_Venta->operador_ID=$item['operador_ID'];
                            $oOrden_Venta->periodo=$item['periodo'];
                            $oOrden_Venta->numero=$item['numero'];
                            $oOrden_Venta->numero_concatenado=$item['numero_concatenado'];
                            $oOrden_Venta->numero_orden_compra=$item['numero_orden_compra'];
                            $oOrden_Venta->moneda_ID=$item['moneda_ID'];
                            $oOrden_Venta->fecha=$item['fecha'];
                            $oOrden_Venta->igv=$item['igv'];
                            $oOrden_Venta->vigv_soles=$item['vigv_soles'];
                            $oOrden_Venta->vigv_dolares=$item['vigv_dolares'];
                            $oOrden_Venta->precio_venta_neto_soles=$item['precio_venta_neto_soles'];
                            $oOrden_Venta->precio_venta_total_soles=$item['precio_venta_total_soles'];
                            $oOrden_Venta->precio_venta_neto_dolares=$item['precio_venta_neto_dolares'];
                            $oOrden_Venta->precio_venta_total_dolares=$item['precio_venta_total_dolares'];
                            $oOrden_Venta->forma_pago_ID=$item['forma_pago_ID'];
                            $oOrden_Venta->tiempo_credito=$item['tiempo_credito'];
                            $oOrden_Venta->descuento_soles=$item['descuento_soles'];
                            $oOrden_Venta->descuento_dolares=$item['descuento_dolares'];
                            $oOrden_Venta->estado_ID=$item['estado_ID'];
                            $oOrden_Venta->tipo_cambio=$item['tipo_cambio'];
                            $oOrden_Venta->plazo_entrega=$item['plazo_entrega'];
                            $oOrden_Venta->lugar_entrega=$item['lugar_entrega'];
                            $oOrden_Venta->validez_oferta=$item['validez_oferta'];
                            $oOrden_Venta->garantia=$item['garantia'];
                            $oOrden_Venta->observacion=$item['observacion'];
                            $oOrden_Venta->numero_pagina=$item['numero_pagina'];
                            $oOrden_Venta->nproducto_pagina=$item['nproducto_pagina'];
                            $oOrden_Venta->impresion=$item['impresion'];
                            $oOrden_Venta->usuario_id=$item['usuario_id'];
                            $oOrden_Venta->ver_adicional=$item['ver_adicional'];
                            $oOrden_Venta->adicional=$item['adicional'];
			}			
			return $oOrden_Venta;
				
		}catch(Exeption $ex)
		{
			throw new Exception($q);
		}
	}
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ov.ID asc')
	{
		$cn =new connect();
		try 
		{
                    $q='SELECT  ov.ID,ov.empresa_ID,ifNull(ov.cotizacion_ID,-1) as cotizacion_ID,ov.cliente_ID,ov.cliente_contacto_ID,ov.operador_ID,ov.periodo,ov.numero,ov.';
                    $q.='numero_concatenado,ov.numero_orden_compra,ov.moneda_ID,date_format(ov.fecha,"%d/%m/%Y") as fecha,ov.igv,ov.vigv_soles,ov.vigv_dolares,ov.precio_venta_neto_soles,ov.';
                    $q.='precio_venta_total_soles,ov.precio_venta_neto_dolares,ov.precio_venta_total_dolares,ov.forma_pago_ID,ov.';
                    $q.='tiempo_credito,ov.descuento_soles,ov.descuento_dolares,ov.estado_ID,ov.tipo_cambio,ov.plazo_entrega,ov.lugar_entrega,ov.validez_oferta,ov.garantia,ov.observacion,ov.usuario_id,ov.usuario_mod_id,ov.impresion, ';
                    $q.='cl.razon_social ,es.nombre as estado';
                    $q.=' FROM orden_venta ov,cliente cl, estado es ';
                    $q.=' where ov.del=0 and ov.cliente_ID=cl.ID and ov.estado_ID=es.ID';
			
			
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
    static function getPeriodos()
    {
        $cn =new connect();
        try 
        {
            $q='select DISTINCT periodo from orden_venta where del=0 and empresa_ID='.$_SESSION['empresa_ID'];
                //echo $q;
                $dt=$cn->getGrid($q);									
                return $dt;												
        }catch(Exception $ex)
        {
                throw new Exception($q);
        }
    } 

    static function getNumero(){
      $cn =new connect();
      $numero=0;
        try{
            $q='select ifnull(max(numero),0) +1 as numero from orden_venta where empresa_ID='.$_SESSION['empresa_ID'];
            $numero=$cn->getData($q);
            //echo $q;
            return $numero;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
              
    }
     static function verificarDisponibilidadImpresora()
	{
            $cn =new connect();
            try 
            {
                $q='SELECT  count(ov.ID)';
                $q.=' FROM orden_venta ov,cliente cl, estado es ';
                $q.=' where ov.del=0 and ov.cliente_ID=cl.ID and ov.estado_ID=es.ID and ov.empresa_ID='.$_SESSION['empresa_ID'];
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
        $cn =new connect();
            try 
            {
                $q='update orden_venta set impresion=0 where ID='. $this->ID;
                $resultado=$cn->transa($q);									
                $q='update factura_venta set con_guia=0 where orden_venta_ID='. $this->ID;
                $resultado=$cn->transa($q);
                return $resultado;					
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
    }
    
    
       
    	
	// inicio de reportes dasboard de ventas//
	
	
	   
        static function MostrarGrafico_DiarioSoles() {
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = ' select ov.fecha,dayname(ov.fecha) as dia, sum(ov.precio_venta_total_soles) as total_dia , ov.moneda_ID ';
            $q.='from orden_venta ov ';
            $q.='  where ov.empresa_ID='.$_SESSION['empresa_ID'].' and YEARWEEK(ov.fecha) =  YEARWEEK(CURDATE()) and ov.moneda_ID = 1 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42)  ';
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
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'select ov.fecha,dayname(ov.fecha) as dia, sum(ov.precio_venta_total_dolares) as total_dia , ov.moneda_ID ';
            $q.='from orden_venta ov ';
            $q.=' where empresa_ID='.$_SESSION['empresa_ID'].' and  YEARWEEK(ov.fecha) =  YEARWEEK(CURDATE()) and ov.moneda_ID = 2 and ov.del=0 and (ov.estado_ID= 40 or ov.estado_ID= 42) ';
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
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = ' select ov.fecha, DAYOFMONTH(ov.fecha) as numero_dia, monthname(ov.fecha) as mes, sum(ov.precio_venta_total_soles) as total_dia, ov.moneda_ID ';
            $q.='from orden_venta ov  ';
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
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = ' select ov.fecha, DAYOFMONTH(ov.fecha) as numero_dia, monthname(ov.fecha) as mes, sum(ov.precio_venta_total_dolares) as total_dia, ov.moneda_ID ';
            $q.='from orden_venta ov  ';
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
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'SELECT monthname(ov.fecha) as mes, sum(ov.precio_venta_total_soles) as total_mes, ov.moneda_ID ';
            $q.='from orden_venta ov ';
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
        $cn = new connect();
        try {
            $q = "SET lc_time_names = 'es_PE';";
            $cn->transa($q);
            $q = 'SELECT monthname(ov.fecha) as mes, sum(ov.precio_venta_total_dolares) as total_mes, ov.moneda_ID ';
            $q.='from orden_venta ov ';
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
        $cn = new connect();
        try {
            $q = 'SELECT year(ov.fecha) as anio, sum(ov.precio_venta_total_soles) as total_anio, ov.moneda_ID ';
            $q.='from orden_venta ov ';
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
        $cn = new connect();
        try {
            $q = 'SELECT year(ov.fecha) as anio, sum(ov.precio_venta_total_dolares) as total_anio, ov.moneda_ID  ';
            $q.='from orden_venta ov ';
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
    
  }
 

?>