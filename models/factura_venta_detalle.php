<?php

class factura_venta_detalle {
    private $ID;
    private $factura_venta_ID;
    private $salida_detalle_ID;
    private $usuario_id;
    private $usuario_mod_id;
    private $message;

  public function __set($var, $valor)
    {
// convierte a minúsculas toda una cadena la función strtolower
          $temporal = $var;

          // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
          if (property_exists('factura_venta_detalle',$temporal))
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
        if (property_exists('factura_venta_detalle', $temporal))
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

            $q='select ifnull(max(ID),0)+1 as ID from factura_venta_detalle;';
            $ID=$cn->getData($q);
            $q='INSERT INTO factura_venta_detalle (ID,factura_venta_ID,salida_detalle_ID,usuario_id) ';
            $q.='VALUES ('.$ID.','.$this->factura_venta_ID.','.$this->salida_detalle_ID.','.$this->usuario_id.')';
            //echo $q;
            $retornar=$cn->transa($q);

            $this->ID=$ID;
            $this->message='Se guardó correctamente';

            return $retornar;

        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }
    function actualizar(){
        $cn =new connect();
	$retornar=-1;
        try{

            $q='UPDATE factura_venta_detalle set factura_venta_ID='.$this->factura_venta_ID.',salida_detalle_ID='.$this->salida_detalle_ID.' usuario_mod_id='.$this->usuario_mod_id;
            $q.=', fdm=now() where del=0 and ID='.$this->ID;
            //echo $q;
            $retornar=$cn->transa($q);
            $this->message='Se guardó correctamente';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
    //codigo ortega-aprobar cotizacion

    function eliminar(){
            $cn =new connect();
            $retornar=-1;
            try{

                $q='UPDATE factura_venta_detalle SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
			$q='select count(ID) ';
			$q.=' FROM factura_venta_detalle ';
			$q.=' where del=0' ;

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
                $q='select ID,factura_venta_ID,salida_detalle_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                $q.=' from factura_venta_detalle';
                $q.=' where del=0 and ID='.$ID;
                    //echo $q;
                    $dt=$cn->getGrid($q);
                    $oFactura_Venta_Detalle=null;

                    foreach($dt as $item)
                    {
                        $oFactura_Venta_Detalle = new factura_venta_detalle();
                        $oFactura_Venta_Detalle->ID=$item['ID'];
                        $oFactura_Venta_Detalle->factura_venta_ID=$item['factura_venta_ID'];
                        $oFactura_Venta_Detalle->salida_detalle_ID=$item['salida_detalle_ID'];
                        $oFactura_Venta_Detalle->usuario_id=$item['usuario_id'];
                        $oFactura_Venta_Detalle->usuario_mod_id=$item['usuario_mod_id'];
                    }
                    return $oFactura_Venta_Detalle;

            }catch(Exeption $ex)
            {
                    throw new Exception($q);
            }
	}

  static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect();
		try
		{
                    $q='select ID,factura_venta_ID,salida_detalle_ID,usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id from factura_venta_detalle';
                    $q.=' where del=0';

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


  static function getGrid2($salida_ID)
	{
		$cn =new connect();
		try
		{
          $q='select sd.*,p.nombre as producto_nombre,fv.serie from factura_venta fv
          inner join factura_venta_detalle fvd on fv.ID=fvd.factura_venta_ID
          inner join salida_detalle sd on fvd.salida_detalle_ID=sd.ID
          inner join producto p on sd.producto_ID=p.ID
          where sd.tipo=1 and fv.salida_ID='.$salida_ID.' and fv.del=0 and fvd.del=0 and sd.del=0;';

			    $dt=$cn->getGrid($q);
			    return $dt;

		}catch(Exception $ex)
		{
			throw new Exception($q);
		}
	}

  static function getGrid1($filtro='',$desde=-1,$hasta=-1,$order='ovd.ID asc')
    {
        $cn =new connect();
        try
        {
        $q='select ovd.ID, ov.moneda_ID,ovd.cantidad,ovd.precio_venta_unitario_soles,ovd.precio_venta_unitario_dolares,';
        $q.='ovd.vigv_soles,ovd.vigv_dolares,ovd.precio_venta_subtotal_soles,precio_venta_subtotal_dolares,ovd.precio_venta_soles';
        $q.=',ovd.precio_venta_dolares,pro.nombre as producto,ovd.descripcion,fv.ID as factura_venta_detalle_ID';
        $q.=' from salida ov,salida_detalle ovd,factura_venta_detalle fvd, producto pro';
        $q.=' where fvd.del=0 and ov.del=0 and ovd.del=0 and  ov.ID=ovd.salida_ID and';
        $q.=' fvd.salida_detalle_ID =ovd.ID and ovd.producto_ID=pro.ID';

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
    function verificarDuplicado(){
		$cn =new connect();
		$retornar=-1;
		try{
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un error en la consulta");
		}
	}
    static function getNumero(){
      $cn =new connect();
      $numero=0;
        try{
            $q='select ifnull(max(numero),0)+1 as ID from factura_venta';
            $numero=$cn->getData($q);
            //echo $q;
            return $numero;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }

    }
  }


?>
