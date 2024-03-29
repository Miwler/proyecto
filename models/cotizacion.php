<?php

class cotizacion {
    private $ID;
    private $empresa_ID;
    private $cliente_ID;
    private $cliente_contacto_ID;
    private $operador_ID;
    private $periodo;
    private $numero;
    private $numero_concatenado;
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
    private $tardanza;
    private $plazo_entrega;
    private $estado_ID;
    private $tipo_cambio;
    private $lugar_entrega;
    private $validez_oferta;
    private $garantia;
    private $observacion;
    private $area_texto;
    private $numero_pagina;
    private $producto_pagina;
    private $usuario_id;
    private $usuario_mod_id;
    
    private $boton_producto;
    private $boton_pdf;
    private $mostrar_precio_unitario;
    
    Private $getMessage;


  public function __set($var, $valor)
    {
// convierte a minúsculas toda una cadena la función strtolower
          $temporal = $var;

          // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
          if (property_exists('cotizacion',$temporal))
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
        if (property_exists('cotizacion', $temporal))
         {
                return $this->$temporal;
         }

        // Retorna nulo si no existe
        return null;
    }
    function __construct()
  {
        $this->cliente_contacto_ID=0;
    $this->operador_ID=0;
    $this->periodo=0;
    $this->numero=0;
    $this->numero_concatenado="";
    $this->fecha="";
    $this->igv=0;
    $this->vigv_soles=0;
    $this->vigv_dolares=0;
    $this->precio_venta_neto_soles=0;
    $this->precio_venta_total_soles=0;
    $this->precio_venta_neto_dolares=0;
    $this->precio_venta_total_dolares=0;
    $this->tiempo_credito=0;
    $this->tardanza="";
    $this->plazo_entrega=0;
    $this->tipo_cambio=0;
    $this->lugar_entrega="";
    $this->validez_oferta="";
    $this->garantia="";
    $this->observacion="";
    $this->area_texto="";
    $this->numero_pagina=0;
    $this->producto_pagina="";
    $this->mostrar_precio_unitario=precio_incluye_igv;
    $this->usuario_id=$_SESSION["usuario_ID"];
    $this->usuario_mod_id=$_SESSION["usuario_ID"];
   

  }
  function __destruct()
  {
    $this->cliente_contacto_ID;
    $this->operador_ID;
    $this->periodo;
    $this->numero;
    $this->numero_concatenado;
    $this->fecha;
    $this->igv;
    $this->vigv_soles;
    $this->vigv_dolares;
    $this->precio_venta_neto_soles;
    $this->precio_venta_total_soles;
    $this->precio_venta_neto_dolares;
    $this->precio_venta_total_dolares;
    $this->tiempo_credito;
    $this->tardanza;
    $this->plazo_entrega;
    $this->tipo_cambio;
    $this->lugar_entrega;
    $this->validez_oferta;
    $this->garantia;
    $this->observacion;
    $this->area_texto;
    $this->numero_pagina;
    $this->producto_pagina;
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
           $q='select ifnull(max(ID),0)+1 as ID from cotizacion;';
           $cn =new connect_new();
           $ID=$cn->getData($q);
            
            $q=" insert into cotizacion (ID,empresa_ID,cliente_ID,cliente_contacto_ID,operador_ID,periodo,numero,numero_concatenado,moneda_ID,fecha,";
            $q.=" igv,vigv_soles,vigv_dolares,precio_venta_neto_soles,precio_venta_total_soles,precio_venta_neto_dolares,precio_venta_total_dolares,";
            $q.="forma_pago_ID,tiempo_credito,tardanza,plazo_entrega,estado_ID,tipo_cambio,lugar_entrega,";
            $q.=" validez_oferta,garantia,observacion,mostrar_precio_unitario,usuario_id) values (".$ID.",".$this->empresa_ID;
            $q.=",".$this->cliente_ID.",".$this->cliente_contacto_ID.",".$this->operador_ID.",'".$this->periodo."','".$this->numero."','".$this->numero_concatenado."',".$this->moneda_ID.",".$fecha_save.",";
            $q.=$this->igv.",".$this->vigv_soles.",".$this->vigv_dolares.",".$this->precio_venta_neto_soles.",".$this->precio_venta_total_soles.",".$this->precio_venta_neto_dolares.",".$this->precio_venta_total_dolares.",";
            $q.=$this->forma_pago_ID.",".$this->tiempo_credito.",'".$this->tardanza."','".$this->plazo_entrega."',".$this->estado_ID.",".$this->tipo_cambio.",'".$this->lugar_entrega."',";
            $q.="'".$this->validez_oferta."','".$this->garantia."','".$this->observacion."',".$this->mostrar_precio_unitario.",".$this->usuario_id.");";
            $cn =new connect_new();
            $retornar=$cn->transa($q);
            $this->ID=$ID;
            $this->getMessage='Se guardó correctamente';
            
            return $retornar;
            
        } catch (Exception $ex) {

            throw new Exception("Ocurrio un error en la consulta");
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
            $q='update cotizacion set cliente_ID='.$this->cliente_ID.',cliente_contacto_ID='.$this->cliente_contacto_ID.',operador_ID='.$this->operador_ID.',periodo="'.$this->periodo.'",numero="'.$this->numero.'",numero_concatenado="'.$this->numero_concatenado.'",moneda_ID='.$this->moneda_ID.',fecha='.$fecha_save;
            $q.=',igv='.$this->igv.',vigv_soles='.$this->vigv_soles.',vigv_dolares='.$this->vigv_dolares.',precio_venta_neto_soles='.$this->precio_venta_neto_soles.',precio_venta_total_soles='.$this->precio_venta_total_soles.',precio_venta_neto_dolares='.$this->precio_venta_neto_dolares.',precio_venta_total_dolares='.$this->precio_venta_total_dolares;
            $q.=',forma_pago_ID='.$this->forma_pago_ID.',tiempo_credito='.$this->tiempo_credito.',tardanza="'.$this->tardanza.'",plazo_entrega="'.$this->plazo_entrega.'",estado_ID='.$this->estado_ID.',tipo_cambio='.$this->tipo_cambio.',lugar_entrega="'.$this->lugar_entrega;
            $q.='",validez_oferta="'.$this->validez_oferta.'",garantia="'.$this->garantia.'",observacion="'.$this->observacion.'",mostrar_precio_unitario='.$this->mostrar_precio_unitario.',usuario_mod_id='.$this->usuario_mod_id.',fdm=now() where del=0 and ID='.$this->ID;
           //echo $q;
            $retornar=$cn->transa($q);
            $this->getMessage='Se actualizó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    function actualizar1()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $ID=$cn->store_procedure_transa(
          "sp_cotizacion_Update",
            array(
                "retornar"=>$retornar,
                "iID"=>$this->ID,
                "iempresa_ID"=>$this->empresa_ID,
                "icliente_ID"=>$this->cliente_ID,
                "icliente_contacto_ID"=>$this->cliente_contacto_ID,
                "ioperador_ID"=>$this->operador_ID,
                "iperiodo"=>$this->periodo,
                "inumero"=>$this->numero,
                "inumero_concatenado"=>$this->numero_concatenado,
                "imoneda_ID"=>$this->moneda_ID,
                "ifecha"=> FormatTextToDate($this->fecha,"Y-m-d"),
                "iigv"=>$this->igv,
                "ivigv_soles"=>$this->vigv_soles,
                "ivigv_dolares"=>$this->vigv_dolares,
                "iprecio_venta_neto_soles"=>$this->precio_venta_neto_soles,
                "iprecio_venta_total_soles"=>$this->precio_venta_total_soles,
                "iprecio_venta_neto_dolares"=>$this->precio_venta_neto_dolares,
                "iprecio_venta_total_dolares"=>$this->precio_venta_total_dolares,
                "iforma_pago_ID"=>$this->forma_pago_ID,
                "itiempo_credito"=>$this->tiempo_credito,
                "itardanza"=>$this->tardanza,
                "iplazo_entrega"=>$this->plazo_entrega,
                "iestado_ID"=>$this->estado_ID,
                "itipo_cambio"=>$this->tipo_cambio,
                "ilugar_entrega"=>$this->lugar_entrega,
                "ivalidez_oferta"=>$this->validez_oferta,
                "igarantia"=>$this->garantia,
                "iobservacion"=>$this->observacion,
                "iarea_texto"=>$this->area_texto,
                "inumero_pagina"=>$this->numero_pagina,
                "iproducto_pagina"=>$this->producto_pagina,
                "imostrar_precio_unitario"=>$this->mostrar_precio_unitario,
                "iusuario_mod_id"=>$this->usuario_mod_id
            ),0);
      if($retornar>0){
          $this->getMessage="Se actualizó correctamente";
      }
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "cotizacion.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
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
    function eliminar(){
            $cn =new connect_new();
            $retornar=-1;
            try{

                    $q='UPDATE cotizacion SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
			$q='select count(co.ID) ';
			$q.=' FROM cotizacion as co, cliente as cl ';
			$q.=' where co.del=0 and co.cliente_ID=cl.ID';
			
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
   /*static function getByID($ID)
    {
        $cn =new connect_new();
        try 
        {
            $q=' select ID,empresa_ID,cliente_ID,cliente_contacto_ID,ifNull(operador_ID,-1) as operador_ID,periodo,numero,numero_concatenado,moneda_ID,DATE_FORMAT(fecha,"%d/%m/%Y") as fecha,';
            $q.='igv,vigv_soles,vigv_dolares,precio_venta_neto_soles,precio_venta_total_soles,precio_venta_neto_dolares,';
            $q.='precio_venta_total_dolares,forma_pago_ID,tiempo_credito,tardanza,plazo_entrega,estado_ID,tipo_cambio,lugar_entrega,';
            $q.='validez_oferta,garantia,observacion,area_texto,numero_pagina,ifnull(producto_pagina,"") as producto_pagina,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
            $q.=' from cotizacion ';
            $q.=' where del=0 and ID='.$ID;
            //echo $q;
            $dt=$cn->getGrid($q);			
            $oCotizacion=null;

            foreach($dt as $item)
            {
                $oCotizacion=new cotizacion();

            $oCotizacion->ID=$item['ID'];
            $oCotizacion->empresa_ID=$item['empresa_ID'];
            $oCotizacion->cliente_ID=$item['cliente_ID'];
            $oCotizacion->cliente_contacto_ID=$item['cliente_contacto_ID'];
            $oCotizacion->operador_ID=$item['operador_ID'];
            $oCotizacion->periodo=$item['periodo'];
            $oCotizacion->numero=$item['numero'];
            $oCotizacion->numero_concatenado=$item['numero_concatenado'];
            $oCotizacion->moneda_ID=$item['moneda_ID'];
            $oCotizacion->fecha=$item['fecha'];
            $oCotizacion->igv=$item['igv'];
            $oCotizacion->vigv_soles=$item['vigv_soles'];
            $oCotizacion->vigv_dolares=$item['vigv_dolares'];
            $oCotizacion->precio_venta_neto_soles=$item['precio_venta_neto_soles'];
            $oCotizacion->precio_venta_total_soles=$item['precio_venta_total_soles'];
            $oCotizacion->precio_venta_neto_dolares=$item['precio_venta_neto_dolares'];
            $oCotizacion->precio_venta_total_dolares=$item['precio_venta_total_dolares'];
            $oCotizacion->forma_pago_ID=$item['forma_pago_ID'];
            $oCotizacion->tiempo_credito=$item['tiempo_credito'];
            $oCotizacion->tardanza=$item['tardanza'];
            $oCotizacion->plazo_entrega=$item['plazo_entrega'];
            $oCotizacion->estado_ID=$item['estado_ID'];
            $oCotizacion->tipo_cambio=$item['tipo_cambio'];
            $oCotizacion->lugar_entrega=$item['lugar_entrega'];
            $oCotizacion->validez_oferta=$item['validez_oferta'];
            $oCotizacion->garantia=$item['garantia'];
            $oCotizacion->observacion=$item['observacion'];
            $oCotizacion->area_texto=$item['area_texto'];
            $oCotizacion->numero_pagina=$item['numero_pagina'];
            $oCotizacion->producto_pagina=$item['producto_pagina'];
            $oCotizacion->usuario_id=$item['usuario_id'];
            $oCotizacion->usuario_mod_id=$item['usuario_mod_id'];
            }			
            return $oCotizacion;
        }catch(Exeption $ex)
        {
            throw new Exception($q);
        }
    }*/
    static function getByID($ID)
    {
    $cn =new connect_new();
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_cotizacion_getByID",
          array("iID"=>$ID));
      $ocotizacion=null;
      foreach($dt as $item)
      {
        $ocotizacion= new cotizacion();
      $ocotizacion->ID=$item["ID"];
      $ocotizacion->empresa_ID=$item["empresa_ID"];
      $ocotizacion->cliente_ID=$item["cliente_ID"];
      $ocotizacion->cliente_contacto_ID=$item["cliente_contacto_ID"];
      $ocotizacion->operador_ID=$item["operador_ID"];
      $ocotizacion->periodo=$item["periodo"];
      $ocotizacion->numero=$item["numero"];
      $ocotizacion->numero_concatenado=$item["numero_concatenado"];
      $ocotizacion->moneda_ID=$item["moneda_ID"];
      $ocotizacion->fecha=$item["fecha"];
      $ocotizacion->igv=$item["igv"];
      $ocotizacion->vigv_soles=$item["vigv_soles"];
      $ocotizacion->vigv_dolares=$item["vigv_dolares"];
      $ocotizacion->precio_venta_neto_soles=$item["precio_venta_neto_soles"];
      $ocotizacion->precio_venta_total_soles=$item["precio_venta_total_soles"];
      $ocotizacion->precio_venta_neto_dolares=$item["precio_venta_neto_dolares"];
      $ocotizacion->precio_venta_total_dolares=$item["precio_venta_total_dolares"];
      $ocotizacion->forma_pago_ID=$item["forma_pago_ID"];
      $ocotizacion->tiempo_credito=$item["tiempo_credito"];
      $ocotizacion->tardanza=$item["tardanza"];
      $ocotizacion->plazo_entrega=$item["plazo_entrega"];
      $ocotizacion->estado_ID=$item["estado_ID"];
      $ocotizacion->tipo_cambio=$item["tipo_cambio"];
      $ocotizacion->lugar_entrega=$item["lugar_entrega"];
      $ocotizacion->validez_oferta=$item["validez_oferta"];
      $ocotizacion->garantia=$item["garantia"];
      $ocotizacion->observacion=$item["observacion"];
      $ocotizacion->area_texto=$item["area_texto"];
      $ocotizacion->numero_pagina=$item["numero_pagina"];
      $ocotizacion->producto_pagina=$item["producto_pagina"];
      $ocotizacion->mostrar_precio_unitario=$item["mostrar_precio_unitario"];
      $ocotizacion->usuario_id=$item["usuario_id"];
      $ocotizacion->usuario_mod_id=$item["usuario_mod_id"];

      }
      return $ocotizacion;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "cotizacion.getByID", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='co.ID asc')
	{
            $cn =new connect_new();
            try 
            {
                $q=' select co.ID,co.cliente_ID,co.cliente_contacto_ID,co.operador_ID,co.periodo,co.numero,';
                $q.='ifNull(co.numero_concatenado,"") as numero_concatenado,co.moneda_ID,date_format(co.fecha,"%d/%m/%Y") as fecha,';
                $q.='co.igv,co.vigv_soles,co.vigv_dolares,co.precio_venta_neto_soles,co.precio_venta_total_soles,';
                $q.='co.precio_venta_neto_dolares,co.precio_venta_total_dolares,co.forma_pago_ID,co.tiempo_credito,';
                $q.='co.tardanza,co.plazo_entrega,';
                $q.='co.estado_ID,co.tipo_cambio,co.lugar_entrega,co.validez_oferta,co.garantia,co.observacion,co.area_texto,co.usuario_id,co.usuario_mod_id,';
                $q.='cl.razon_social,es.nombre as estado, mo.descripcion as moneda, mo.simbolo,co.numero_pagina,ifnull(co.producto_pagina,"") as producto_pagina ';
                $q.=' from cotizacion co, cliente cl, estado es, moneda mo ';
                $q.=' where co.cliente_ID=cl.ID and co.estado_ID=es.ID  and co.moneda_ID=mo.ID and co.del=0 ';
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
        static function getGrid1($filtro='',$desde=-1,$hasta=-1,$orden='co.ID asc')
	{
            $cn =new connect_new();
            try 
            {
                $dt=$cn->store_procedure_getGrid("getTabla_Cotizacion", 
                        array("ifiltro"=>$filtro,
                            "desde"=>$desde,
                            "hasta"=>$hasta,
                            "orden"=>$orden));
                //$q="call getTabla_Cotizacion('".$filtro."',".$desde.",".$hasta.",'".$orden."');";
                
                //$dt=$cn->getGrid($q);									
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
            $q='select ifnull(max(numero),0) +1 as numero from cotizacion where empresa_ID='.$_GET['empresa_ID'];
            $numero=$cn->getData($q);
            //echo $q;
            return $numero;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }
              
    }
    function actualizar_pagina(){
        $cn =new connect_new();
        $retornar=-1;
        try{

                $q='UPDATE cotizacion SET numero_pagina='.$this->numero_pagina;
                $q.=' WHERE ID='.$this->ID;

                $retornar=$cn->transa($q);

                //$this->message='Se actualizó correctamente.';
                return $retornar;
        }
        catch(Exception $ex){
                throw new Exception("Ocurrio un error en la consulta");
        }
    }  
  }


?>