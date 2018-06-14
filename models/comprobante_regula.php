<?php

class comprobante_regula {
    private $ID;
    private $factura_venta_ID;
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
    private $usuario_id;
    private $usuario_mod_id;
    private $getMessage;
    private $moneda;
    private $estado;
    private $tipo;
    private $codigo_comprobante;
    private $dtSerie;
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
    function insertar()
    {
        $cn =new connect();
        $retornar=-1;
        try{
            
            $q='select ifnull(max(ID),0)+1 as ID from comprobante_regula;';
            $ID=$cn->getData($q);
            $q='INSERT INTO comprobante_regula (ID,factura_venta_ID,cliente_ID,tipo_ID,serie,numero,numero_concatenado,fecha_emision,fecha_vencimiento,';
            $q.='estado_ID,moneda_ID,monto_total_neto,monto_total_igv,monto_total,monto_pendiente,empresa_ID,correlativos_ID,porcentaje_descuento,';
            $q.='anticipo,exoneradas,inafectas,gravadas,gratuitas,otros_cargos,descuento_global,monto_detraccion,observacion,usuario_id) ';
            $q.='VALUES ('.$ID.','.$this->factura_venta_ID.','.$this->cliente_ID.','.$this->tipo_ID.',"'.$this->serie.'",'.$this->numero.',"'.$this->numero_concatenado.'","'.$this->fecha_emision.'","'.$this->fecha_vencimiento.'"';
            $q.=','.$this->estado_ID.','.$this->moneda_ID.','.$this->monto_total_neto.','.$this->monto_total_igv.','.$this->monto_total.','.$this->monto_pendiente.','.$this->empresa_ID.','.$this->correlativos_ID.','.$this->porcentaje_descuento.',';
            $q.=$this->anticipo.','.$this->exoneradas.','.$this->inafectas.','.$this->gravadas.','.$this->gratuitas.','.$this->otros_cargos.','.$this->descuento_global.','.$this->monto_detraccion.',"'.$this->observacion.'",'.$this->usuario_id.');';
            //echo $q;
            $retornar=$cn->transa($q);

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
               ',moneda_ID='.$this->moneda_ID .',orden_pedido="'.$this->orden_pedido.'",orden_ingreso="'.$this->orden_ingreso.'",impresion='.$this->impresion.',con_guia='.$con_guia.',opcion='.$this->opcion;
                ',numero_producto='.$this->numero_producto.',correlativos_ID='.$this->correlativos_ID.' usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }

    
    function eliminar(){
            $cn =new connect();
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
		$cn =new connect();
		try
		{
                    $q='select count(cr.ID) ';
                    $q.=' from comprobante_regula cr,factura_venta fv,tipo ti, estado es,moneda mo where cr.factura_venta_ID=fv.ID and cr.tipo_ID=ti.ID and cr.moneda_ID=mo.ID and ';
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

        //modificado por ortega-agregar todos los datos y cargar en el modelo
   static function getByID($ID)
	{
            $cn =new connect();
            try
            {
                $q.='call comprobante_regula_getByID('.$ID.')';
                    //echo $q;
                    $dt=$cn->getGrid($q);
                    $oComprobante_Regula=null;

                    foreach($dt as $item)
                    {
                        $oComprobante_Regula->ID=$item['ID'];
                        $oComprobante_Regula->factura_venta_ID=$item['factura_venta_ID'];
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
                        $oComprobante_Regula->operador_ID_creador=$item['operador_ID_creador'];
                        $oComprobante_Regula->usuario_id=$item['usuario_id'];
                        $oComprobante_Regula->usuario_mod_id=$item['usuario_mod_id'];
                        $oComprobante_Regula->estado=$item['estado'];
                        $oComprobante_Regula->moneda=$item['moneda'];
                        $oComprobante_Regula->tipo=$item['tipo'];
                        $oComprobante_Regula->codigo_comprobante=$item['codigo_comprobante'];
                    }
                    return $oComprobante_Regula;

            }catch(Exeption $ex)
            {
                    throw new Exception($q);
            }
	}
    static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='cr.ID asc')
	{
		$cn =new connect();
		try
		{
                    $q='select cr.ID,cr.serie,cr.numero_concatenado,ti.nombre as tipo,ifnull(cr.fecha_emision,"") as fecha_emision,fv.serie as serie_factura,fv.numero as numero_factura,es.nombre as estado,cr.estado_ID,mo.simbolo as moneda,cr.monto_total';
                    $q.=' from comprobante_regula cr,factura_venta fv,tipo ti, estado es,moneda mo where cr.factura_venta_ID=fv.ID and cr.tipo_ID=ti.ID and cr.moneda_ID=mo.ID and ';
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
	}
        
    static function getTabla($opcion,$cliente_ID,$periodo,$fecha_inicio,$fecha_fin,$estado_ID,$moneda_ID,$serie,$numero)
    {
        $cn =new connect();
        try
        {
        $q='call getTabla_Comprobante_Regula("'.$opcion.'",'.$_SESSION['empresa_ID'].','.$cliente_ID.','.$periodo.',"'.$fecha_inicio.'","'.$fecha_fin.'",'.$estado_ID.','.$moneda_ID.',"'.$serie.'",'.$numero.');';
        //console_log($q);
        $dt=$cn->getTabla($q);
        return $dt;
        }catch(Exception $ex)
        {
            throw new Exception($q);
        }
    }
    function verificarFactura(){
        $cn =new connect();
        $retornar=-1;
        try{
            $q="select count(ID) from factura_venta where del=0 and  estado_ID=53 and ID=".$this->factura_venta_ID;
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
