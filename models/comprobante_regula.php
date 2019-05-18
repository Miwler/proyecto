<?php

class comprobante_regula {
    private $ID;
    private $documento_relacionado_ID;
    private $cliente_ID;
    private $tipo_ID;
    private $serie;
    private $numero;
    private $numero_concatenado;
    private $fecha_emision;
    private $fecha_vencimiento;
    private $estado_ID;
    private $moneda_ID;
    private $monto_total_neto;
    private $monto_total_igv;
    private $monto_total;
    private $monto_pendiente;
    private $empresa_ID;
    private $correlativos_ID;
    private $porcentaje_descuento;
    private $anticipo;
    private $exoneradas;
    private $inafectas;
    private $gravadas;
    private $gratuitas;
    private $otros_cargos;
    private $descuento_global;
    private $monto_detraccion;
    private $operador_ID_creador;
    private $observacion;
    private $tipo_cambio;
    private $usuario_id;
    private $usuario_mod_id;
    private $getMessage;
    private $moneda;
    private $estado;
    private $tipo;
    private $motivo_descripcion;
    private $codigo_comprobante;
    private $dtSerie;
    private $ruc;
    private $razon_social;
    private $codigo_moneda;
    private $factura;
    private $cliente_descripcion;
    private $ubigeo;
    private $direccion_cliente;
    private $urbanizacion_cliente;
    private $departamento_cliente;
    private $provincia_cliente;
    private $distrito_cliente;
    private $igv;
    private $tipo_comprobante_discrepancia;
    private $tipo_documento;
  public function __set($var, $valor)
    {
// convierte a minúsculas toda una cadena la función strtolower
          $temporal = $var;

          // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
          if (property_exists('comprobante_regula',$temporal))
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
        if (property_exists('comprobante_regula', $temporal))
         {
                return $this->$temporal;
         }

        // Retorna nulo si no existe
        return null;
    }
    function __construct()
    {
        $this->documento_relacionado_ID=0;
        $this->tipo_ID=0;
        $this->serie="";
        $this->numero=0;
        $this->numero_concatenado="";
        $this->fecha_emision=NULL;
        $this->fecha_vencimiento=NULL;
        $this->estado_ID=0;
        $this->moneda_ID=0;
        $this->monto_total_neto=0;
        $this->monto_total_igv=0;
        $this->monto_total=0;
        $this->monto_pendiente=0;
        $this->empresa_ID=0;
        $this->correlativos_ID=0;
        $this->porcentaje_descuento=0;
        $this->anticipo=0;
        $this->exoneradas=0;
        $this->inafectas=0;
        $this->gravadas=0;
        $this->gratuitas=0;
        $this->otros_cargos=0;
        $this->descuento_global=0;
        $this->monto_detraccion=0;
        $this->operador_ID_creador=0;
        $this->tipo_cambio=0;
        $this->observacion="";
        $this->usuario_id=$_SESSION["usuario_ID"];
        $this->usuario_mod_id=$_SESSION["usuario_ID"];

      }
    function __destruct()
    {
        $this->documento_relacionado_ID;
        $this->tipo_ID;
        $this->serie;
        $this->numero;
        $this->numero_concatenado;
        $this->fecha_emision;
        $this->fecha_vencimiento;
        $this->estado_ID;
        $this->moneda_ID;
        $this->monto_total_neto;
        $this->monto_total_igv;
        $this->monto_total;
        $this->monto_pendiente;
        $this->empresa_ID;
        $this->correlativos_ID;
        $this->porcentaje_descuento;
        $this->anticipo;
        $this->exoneradas;
        $this->inafectas;
        $this->gravadas;
        $this->gratuitas;
        $this->otros_cargos;
        $this->descuento_global;
        $this->monto_detraccion;
        $this->operador_ID_creador;
        $this->tipo_cambio;
        $this->observacion;
        $this->usuario_id;
        $this->usuario_mod_id;

      }
    function insertar()
    {
        
        $retornar=-1;
        try{
            
            $q='select ifnull(max(ID),0)+1 as ID from comprobante_regula;';
            $cn =new connect_new();
            $ID=$cn->getData($q);
            $q='INSERT INTO comprobante_regula (ID,documento_relacionado_ID,cliente_ID,tipo_ID,serie,numero,numero_concatenado,fecha_emision,fecha_vencimiento,';
            $q.='estado_ID,moneda_ID,monto_total_neto,monto_total_igv,monto_total,monto_pendiente,empresa_ID,correlativos_ID,porcentaje_descuento,';
            $q.='anticipo,exoneradas,inafectas,gravadas,gratuitas,otros_cargos,descuento_global,monto_detraccion,observacion,tipo_cambio,usuario_id) ';
            $q.='VALUES ('.$ID.','.$this->documento_relacionado_ID.','.$this->cliente_ID.','.$this->tipo_ID.',"'.$this->serie.'",'.$this->numero.',"'.$this->numero_concatenado.'","'.FormatTextToDate($this->fecha_emision,'Y-m-d').'","'.FormatTextToDate($this->fecha_vencimiento,'Y-m-d').'"';
            $q.=','.$this->estado_ID.','.$this->moneda_ID.','.$this->monto_total_neto.','.$this->monto_total_igv.','.$this->monto_total.','.$this->monto_pendiente.','.$this->empresa_ID.','.$this->correlativos_ID.','.$this->porcentaje_descuento.',';
            $q.=$this->anticipo.','.$this->exoneradas.','.$this->inafectas.','.$this->gravadas.','.$this->gratuitas.','.$this->otros_cargos.','.$this->descuento_global.','.$this->monto_detraccion.',"'.FormatTextSave($this->observacion).'",'.$this->tipo_cambio.','.$this->usuario_id.');';
            //echo $q;
            $cn =new connect_new();
            $retornar=$cn->transa($q);
            $q="call sp_tabla_movimiento_Insertar(".$ID.",'comprobante_regula',".$this->estado_ID.",'".date("Y-m-d H:i:s")."','',".$this->usuario_id.",".$_SESSION['empresa_ID'].",".$this->usuario_id.")";
            $cn =new connect_new();
            $cn->transa($q);
            $this->ID=$ID;
            $this->getMessage='Se guardó correctamente';

            return $retornar;

        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    /*function actualizar(){
        
	$retornar=-1;
        try{
            $q="call comprobante_regula_Update(";
            $q.=$this->ID.',';
            $q.=$this->documento_relacionado_ID.',';
            $q.=$this->tipo_ID.',';
            $q.='"'.$this->serie.'",';
            $q.=$this->numero.',';
            $q.='"'.$this->numero_concatenado.'",';
            $q.='"'.$this->fecha_emision.'",';
            $q.='"'.$this->fecha_vencimiento.'",';
            $q.=$this->estado_ID.',';
            $q.=$this->moneda_ID.',';
            $q.=$this->monto_total_neto.',';
            $q.=$this->monto_total_igv.',';
            $q.=$this->monto_total.',';
            $q.=$this->monto_pendiente.',';
            $q.=$this->empresa_ID.',';
            $q.=$this->correlativos_ID.',';
            $q.=$this->porcentaje_descuento.',';
            $q.=$this->anticipo.',';
            $q.=$this->exoneradas.',';
            $q.=$this->inafectas.',';
            $q.=$this->gravadas.',';
            $q.=$this->gratuitas.',';
            $q.=$this->otros_cargos.',';
            $q.=$this->descuento_global.',';
            $q.=$this->monto_detraccion.',';
            $q.='"'.$this->observacion.'",';
            $q.=$this->cliente_ID.',';
            $q.=$this->tipo_cambio.',';
            $q.=$this->usuario_mod_id.');';
            echo $q;
            //console_log($q);
            $cn =new connect_new();
            $retornar=$cn->transa($q);
            $q="call sp_tabla_movimiento_Insertar(".$this->ID.",'comprobante_regula',".$this->estado_ID.",'".date("Y-m-d H:i:s")."','',".$this->usuario_mod_id.",".$_SESSION['empresa_ID'].",".$this->usuario_mod_id.")";
            $cn =new connect_new();
            $cn->transa($q);
            $this->getMessage='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }*/

    
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
                    $q='select count(cr.ID) ';
                    $q.=' from comprobante_regula cr,factura_venta fv,tipo ti, estado es,moneda mo where cr.documento_relacionado_ID=fv.ID and cr.tipo_ID=ti.ID and cr.moneda_ID=mo.ID and ';
                    $q.='cr.estado_ID=es.ID and fv.del=0 and cr.del=0 and ti.del=0 and cr.empresa_ID='.$_SESSION['empresa_ID'];;

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
        function actualizar()
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $ID=$cn->store_procedure_transa(
            "sp_comprobante_regula_Update",
            array(
                "retornar"=>$retornar,
                "iID"=>$this->ID,
                "idocumento_relacionado_ID"=>$this->documento_relacionado_ID,
                "itipo_ID"=>$this->tipo_ID,
                "iserie"=>$this->serie,
                "inumero"=>$this->numero,
                "inumero_concatenado"=>$this->numero_concatenado,
                "ifecha_emision"=>FormatTextToDate($this->fecha_emision,'Y-m-d'),
                "ifecha_vencimiento"=>FormatTextToDate($this->fecha_vencimiento,'Y-m-d'),
                "iestado_ID"=>$this->estado_ID,
                "imoneda_ID"=>$this->moneda_ID,
                "imonto_total_neto"=>$this->monto_total_neto,
                "imonto_total_igv"=>$this->monto_total_igv,
                "imonto_total"=>$this->monto_total,
                "imonto_pendiente"=>$this->monto_pendiente,
                "iempresa_ID"=>$this->empresa_ID,
                "icorrelativos_ID"=>$this->correlativos_ID,
                "iporcentaje_descuento"=>$this->porcentaje_descuento,
                "ianticipo"=>$this->anticipo,
                "iexoneradas"=>$this->exoneradas,
                "iinafectas"=>$this->inafectas,
                "igravadas"=>$this->gravadas,
                "igratuitas"=>$this->gratuitas,
                "iotros_cargos"=>$this->otros_cargos,
                "idescuento_global"=>$this->descuento_global,
                "imonto_detraccion"=>$this->monto_detraccion,
                "ioperador_ID_creador"=>$this->operador_ID_creador,
                "itipo_cambio"=>$this->tipo_cambio,
                "icliente_ID"=>$this->cliente_ID,
                "iobservacion"=>$this->observacion,
                "iusuario_mod_id"=>$this->usuario_mod_id
            ),0);
      if($retornar>0){
          $this->getMessage="Se actualizó correctamente.";
      }
      return $retornar;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "comprobante_regula.actualizar", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
        //modificado por ortega-agregar todos los datos y cargar en el modelo
   static function getByID($ID)
	{
            $cn =new connect_new();
            try
            {
                $dt=$cn->store_procedure_getGrid("sp_comprobante_regula_getByID", 
                        array("ID"=>$ID));
                //$q='call comprobante_regula_getByID('.$ID.')';
                    //echo $q;
                    //$dt=$cn->getGrid($q);
                    $oComprobante_Regula=null;
                    $oComprobante_Regula=new comprobante_regula();
                    foreach($dt as $item)
                    {
                        $oComprobante_Regula->ID=$item['ID'];
                        $oComprobante_Regula->documento_relacionado_ID=$item['documento_relacionado_ID'];
                        $oComprobante_Regula->cliente_ID=$item['cliente_ID'];
                        $oComprobante_Regula->tipo_ID=$item['tipo_ID'];
                        $oComprobante_Regula->serie=$item['serie'];
                        $oComprobante_Regula->numero=$item['numero'];
                        $oComprobante_Regula->numero_concatenado=$item['numero_concatenado'];
                        $oComprobante_Regula->fecha_emision=$item['fecha_emision'];
                        $oComprobante_Regula->fecha_vencimiento=$item['fecha_vencimiento'];
                        $oComprobante_Regula->estado_ID=$item['estado_ID'];
                        $oComprobante_Regula->moneda_ID=$item['moneda_ID'];
                        $oComprobante_Regula->monto_total_neto=$item['monto_total_neto'];
                        $oComprobante_Regula->monto_total_igv=$item['monto_total_igv'];
                        $oComprobante_Regula->monto_total=$item['monto_total'];
                        $oComprobante_Regula->monto_pendiente=$item['monto_pendiente'];
                        $oComprobante_Regula->empresa_ID=$item['empresa_ID'];
                        $oComprobante_Regula->correlativos_ID=$item['correlativos_ID'];
                        $oComprobante_Regula->porcentaje_descuento=$item['porcentaje_descuento'];
                        $oComprobante_Regula->anticipo=$item['anticipo'];
                        $oComprobante_Regula->exoneradas=$item['exoneradas'];
                        $oComprobante_Regula->inafectas=$item['inafectas'];
                        $oComprobante_Regula->gravadas=$item['gravadas'];
                        $oComprobante_Regula->gratuitas=$item['gratuitas'];
                        $oComprobante_Regula->otros_cargos=$item['otros_cargos'];
                        $oComprobante_Regula->descuento_global=$item['descuento_global'];
                        $oComprobante_Regula->monto_detraccion=$item['monto_detraccion'];
                        $oComprobante_Regula->tipo_cambio=$item['tipo_cambio'];
                        $oComprobante_Regula->observacion=$item['observacion'];
                        $oComprobante_Regula->usuario_id=$item['usuario_id'];
                        $oComprobante_Regula->usuario_mod_id=$item['usuario_mod_id'];
                        $oComprobante_Regula->estado=$item['estado'];
                        $oComprobante_Regula->moneda=$item['moneda'];
                        $oComprobante_Regula->tipo=$item['tipo'];
                        $oComprobante_Regula->motivo_descripcion=$item['motivo_descripcion'];
                        $oComprobante_Regula->codigo_comprobante=$item['codigo_comprobante'];
                        $oComprobante_Regula->ruc=$item['ruc'];
                        $oComprobante_Regula->razon_social=$item['razon_social'];
                        $oComprobante_Regula->codigo_moneda=$item['codigo_moneda'];
                        $oComprobante_Regula->factura=$item['factura'];
                        $oComprobante_Regula->cliente_descripcion=$item['ruc'].'-'.$item['razon_social'];
                    }
                    return $oComprobante_Regula;

            }catch(Exeption $ex)
            {
                    throw new Exception($q);
            }
	}
    static function getByIDSUNAT($ID)
    {
        $cn =new connect_new();
        try
        {
            //$q='call comprobante_regula_getByIDSUNAT('.$ID.')';
            
                //echo $q;
                $dt=$cn->store_procedure_getGrid("sp_comprobante_regula_getByIDSUNAT",
                        array("iID"=>$ID));
                $oComprobante_Regula=null;
                $oComprobante_Regula=new comprobante_regula();
                foreach($dt as $item)
                {
                    $oComprobante_Regula->ID=$item['ID'];
                    $oComprobante_Regula->documento_relacionado_ID=$item['documento_relacionado_ID'];
                    $oComprobante_Regula->cliente_ID=$item['cliente_ID'];
                    $oComprobante_Regula->tipo_ID=$item['tipo_ID'];
                    $oComprobante_Regula->serie=$item['serie'];
                    $oComprobante_Regula->numero=$item['numero'];
                    $oComprobante_Regula->numero_concatenado=$item['numero_concatenado'];
                    $oComprobante_Regula->fecha_emision=$item['fecha_emision'];
                    $oComprobante_Regula->fecha_vencimiento=$item['fecha_vencimiento'];
                    $oComprobante_Regula->estado_ID=$item['estado_ID'];
                    $oComprobante_Regula->moneda_ID=$item['moneda_ID'];
                    $oComprobante_Regula->monto_total_neto=$item['monto_total_neto'];
                    $oComprobante_Regula->monto_total_igv=$item['monto_total_igv'];
                    $oComprobante_Regula->monto_total=$item['monto_total'];
                    $oComprobante_Regula->monto_pendiente=$item['monto_pendiente'];
                    $oComprobante_Regula->empresa_ID=$item['empresa_ID'];
                    $oComprobante_Regula->correlativos_ID=$item['correlativos_ID'];
                    $oComprobante_Regula->porcentaje_descuento=$item['porcentaje_descuento'];
                    $oComprobante_Regula->anticipo=$item['anticipo'];
                    $oComprobante_Regula->exoneradas=$item['exoneradas'];
                    $oComprobante_Regula->inafectas=$item['inafectas'];
                    $oComprobante_Regula->gravadas=$item['gravadas'];
                    $oComprobante_Regula->gratuitas=$item['gratuitas'];
                    $oComprobante_Regula->otros_cargos=$item['otros_cargos'];
                    $oComprobante_Regula->descuento_global=$item['descuento_global'];
                    $oComprobante_Regula->monto_detraccion=$item['monto_detraccion'];
                    $oComprobante_Regula->tipo_cambio=$item['tipo_cambio'];
                    $oComprobante_Regula->usuario_id=$item['usuario_id'];
                    $oComprobante_Regula->usuario_mod_id=$item['usuario_mod_id'];
                    $oComprobante_Regula->estado=$item['estado'];
                    $oComprobante_Regula->moneda=$item['moneda'];
                    $oComprobante_Regula->tipo=$item['tipo'];
                    $oComprobante_Regula->motivo_descripcion=$item['motivo_descripcion'];
                    $oComprobante_Regula->codigo_comprobante=$item['codigo_comprobante'];
                    $oComprobante_Regula->ruc=$item['ruc'];
                    $oComprobante_Regula->razon_social=$item['razon_social'];
                    $oComprobante_Regula->codigo_moneda=$item['codigo_moneda'];
                    $oComprobante_Regula->tipo_comprobante_discrepancia=$item['tipo_comprobante_discrepancia'];
                    $oComprobante_Regula->factura=$item['factura'];
                    $oComprobante_Regula->ubigeo=$item['ubigeo'];
                    $oComprobante_Regula->direccion_cliente=$item['direccion_cliente'];
                    $oComprobante_Regula->urbanizacion_cliente=$item['urbanizacion_cliente'];
                    $oComprobante_Regula->departamento_cliente=$item['departamento_cliente'];
                    $oComprobante_Regula->provincia_cliente=$item['provincia_cliente'];
                    $oComprobante_Regula->distrito_cliente=$item['distrito_cliente'];
                    $oComprobante_Regula->igv=$item['distrito_cliente'];
                    $oComprobante_Regula->tipo_documento=$item['tipo_documento'];
                }
                return $oComprobante_Regula;

        }catch(Exeption $ex)
        {
                throw new Exception($q);
        }
    }
    /*static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='cr.ID asc')
	{
		$cn =new connect_new();
		try
		{
                    $q='select cr.ID,cr.serie,cr.numero_concatenado,ti.nombre as tipo,ifnull(cr.fecha_emision,"") as fecha_emision,fv.serie as serie_factura,fv.numero as numero_factura,es.nombre as estado,cr.estado_ID,mo.simbolo as moneda,cr.monto_total';
                    $q.=' from comprobante_regula cr,factura_venta fv,tipo ti, estado es,moneda mo where cr.documento_relacionado_ID=fv.ID and cr.tipo_ID=ti.ID and cr.moneda_ID=mo.ID and ';
                    $q.='cr.estado_ID=es.ID and fv.del=0 and cr.del=0 and ti.del=0 and cr.empresa_ID='.$_SESSION['empresa_ID'];
                  
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
	}*/
    static function getGrid($filtro="",$inicio=-1,$fin=-1,$orden="ID asc")
    {
    $cn =new connect_new();
    $retornar =0;
    try
    {
      $dt=$cn->store_procedure_getGrid(
          "sp_comprobante_regula_sunat_getGrid",
            array(
              "filtro"=>$filtro,
              "inicio"=>$inicio,
              "fin"=>$fin,
              "orden"=>$orden));
      return $dt;
    }catch(Exeption $ex)
    {
      log_error(__FILE__, "guia_venta_sunat.getGrid", $ex->getMessage());
      throw new Exception($ex->getMessage());
    }
  }
    static function getGridByID($ID)
    {
        $cn =new connect_new();
        try
        {
            $dt=$cn->store_procedure_getGrid("sp_comprobante_regula_getByID", array(
                "ID"=>$ID
            ));
        //$q='call sp_comprobante_regula_getByID('.$ID.')';
        //$dt=$cn->getGrid($q);
        return $dt;
        }catch(Exception $ex)
        {
            throw new Exception($q);
        }
    }    
    static function getTabla($opcion,$cliente_ID,$periodo,$fecha_inicio,$fecha_fin,$estado_ID,$moneda_ID,$serie,$numero,$documento)
    {
        $cn =new connect_new();
        try
        {
            $dt=$cn->store_procedure_getGrid("getTabla_Comprobante_Regula", 
                    array(
                        "iopcion"=>$opcion,
                        "iempresa_ID"=>$_SESSION['empresa_ID'],
                        "icliente_ID"=>$cliente_ID,
                        "iperiodo"=>$periodo,
                        "ifecha_inicio"=>$fecha_inicio,
                        "ifecha_fin"=>$fecha_fin,
                        "iestado_ID"=>$estado_ID,
                        "imoneda_ID"=>$moneda_ID,
                        "iserie"=>$serie,
                        "inumero"=>$numero,
                        "idocumento"=>$documento
                    ));
        //$q='call getTabla_Comprobante_Regula("'.$opcion.'",'.$_SESSION['empresa_ID'].','.$cliente_ID.','.$periodo.',"'.$fecha_inicio.'","'.$fecha_fin.'",'.$estado_ID.','.$moneda_ID.',"'.$serie.'",'.$numero.',"'.$documento.'");';
        //console_log($q);
        //$dt=$cn->getTabla($q);
        return $dt;
        }catch(Exception $ex)
        {
            throw new Exception($q);
        }
    }
    function verificarFactura(){
        $cn =new connect_new();
        $retornar=-1;
        try{
            $q="select count(ID) from factura_venta where del=0 and  estado_ID=53 and ID=".$this->documento_relacionado_ID;
            //echo $q;
            $retornar=$cn->getData($q);
            return $retornar;
        }
        catch(Exception $ex){
                throw new Exception("Ocurrio un error en la consulta");
        }
    }
   

  }


?>
