<?php

class comprobante_regula_detalle {
    public $ID;
    public $producto_ID;
    public $comprobante_regula_ID;
    public $descripcion;
    public $cantidad;
    public $precio_unitario;
    public $subtotal;
    public $total;
    public $igv;
    public $vigv;
    public $tipo_impuestos_ID;
    public $porcentaje_descuento;
    public $otros_cargos;
    private $factura_venta_detalle_ID ;
    public $usuario_id;
    public $usuario_mod_id;
    private $getMessage;
    public $producto;


  public function __set($var, $valor)
    {
// convierte a minúsculas toda una cadena la función strtolower
          $temporal = $var;

          // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
          if (property_exists('comprobante_regula_detalle',$temporal))
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
        if (property_exists('comprobante_regula_detalle', $temporal))
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
            
            $q='select ifnull(max(ID),0)+1 as ID from comprobante_regula_detalle;';
            $ID=$cn->getData($q);
            $q='INSERT INTO comprobante_regula_detalle(ID,producto_ID,comprobante_regula_ID,descripcion,cantidad,precio_unitario,subtotal,total,igv,vigv,tipo_impuestos_ID,factura_venta_detalle_ID,usuario_id) ';
            $q.='VALUES ('.$ID.','.$this->producto_ID.','.$this->comprobante_regula_ID.',"'.$this->descripcion.'",'.$this->cantidad.','.$this->precio_unitario.','.$this->subtotal.','.$this->total.','.$this->igv;
            $q.=','.$this->vigv.','.$this->tipo_impuestos_ID.','.$this->factura_venta_detalle_ID.','.$this->usuario_id.');';
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

    function actualizarCostos(){
        $cn =new connect();
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
        $cn =new connect();
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
      $cn =new connect();
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
      $cn =new connect();
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
      $cn =new connect();
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
                $q='select ID,salida_ID,serie,numero,numero_concatenado,DATE_FORMAT(fecha_emision,"%d/%m/%Y") as fecha_emision,forma_pago_ID,plazo_factura,DATE_FORMAT(fecha_vencimiento,"%d/%m/%Y") as fecha_vencimiento,';
                $q.='estado_ID,moneda_ID,orden_pedido,orden_ingreso,impresion,con_guia,pago,ifnull(monto_total_neto,0) as monto_total_neto,ifnull(monto_total_igv,0) as monto_total_igv,ifnull(monto_total,0) as monto_total,';
                $q.='ifnull(monto_pendiente,0) as monto_pendiente,DATE_FORMAT(fecha_anulacion,"%d/%m/%Y") as fecha_anulacion,operador_ID_anulacion,motivo_anulacion_ID ,opcion,numero_producto,correlativos_ID,';
                $q.='usuario_id,ifNull(usuario_mod_id,-1) as usuario_mod_id from factura_venta';
                $q.=' where del=0 and ID='.$ID;
                    //echo $q;
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
                        $oFactura_Venta->orden_pedido=$item['orden_pedido'];
                        $oFactura_Venta->orden_ingreso=$item['orden_ingreso'];
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
                        $oFactura_Venta->usuario_id=$item['usuario_id'];
                        $oFactura_Venta->usuario_mod_id=$item['usuario_mod_id'];
                    }
                    return $oFactura_Venta;

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
                    $q='select cr.ID,cr.serie,cr.numero_concatenado,ti.nombre as tipo,cr.fecha_emision,fv.serie as serie_factura,fv.numero as numero_factura,es.nombre as estado,cr.estado_ID,mo.simbolo as moneda,cr.monto_total';
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
        static function getGrid2($filtro='',$desde=-1,$hasta=-1,$order='fv.fecha_emision asc')
	{
		$cn =new connect();
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



        /*static function getGrid_CuentaXCobrar($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect();
        try {
            $q = 'select fv.ID,fv.numero_concatenado as numero,ov.cliente_ID,cl.razon_social as cliente,fv.fecha_emision,fv.fecha_vencimiento,';
            $q.='fv.moneda_ID,mo.descripcion as moneda, mo.simbolo, fv.forma_pago_ID,fv.monto_total,fv.monto_pendiente,fv.estado_ID,es.nombre as estado ';
            $q.=' from factura_venta fv, salida ov,cliente cl, estado es, moneda mo';
            $q.=' where fv.del=0 and ov.del=0 and fv.salida_ID=ov.ID and ov.cliente_ID=cl.ID and fv.estado_ID=es.ID and fv.moneda_ID=mo.ID and fv.forma_pago_ID=1 and fv.estado_ID=41';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }

            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }
        */

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
            $q='select ifnull(max(numero),0) as numero from factura_venta';
            $numero=$cn->getData($q);
           // echo $q;
            return $numero;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un error en la consulta");
        }

    }
    static function getImpresion(){
      $cn =new connect();
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

  }


?>
