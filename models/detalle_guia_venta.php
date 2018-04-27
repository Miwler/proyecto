<?php
class detalle_guia_venta
{
	private $ID;
        private $descripcion;
        private $fdc;
        private $fdm;
        private $cantidad;
        private $del;
        private $usuario_id;	
	private $usuario_mod_id;
        private $precio_venta_unitario;
        private $precio_venta;
        private $producto_ID;
        private $guia_venta_ID;
        private $detalle_guia_venta_ID;
        private $message;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('detalle_guia_venta',$temporal))
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
		if (property_exists('detalle_guia_venta', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	function insertar(){
		$cn =new connect();
		$retornar=-1;
		try{
			$q='SET @maxrow:=(select ifnull(max(ID),0) from detalle_guia_venta);';
			$cn->transa($q);
			
			$q='INSERT INTO detalle_guia_venta(ID,descripcion,fdc,cantidad,usuario_id,precio_venta_unitario,precio_venta,producto_ID,guia_venta_ID) ';
			$q.='VALUES ((select @maxrow:=@maxrow+1),"'.FormatTextSave($this->descripcion).'","'.FormatTextSave($this->fdc).'","'.FormatTextSave($this->cantidad).'",'.$this->usuario_id.','.number_format($this->precio_venta_unitario,4).','.number_format($this->precio_venta,4).','.$this->producto_ID.','.$this->guia_venta_ID.');';
			
			
			$retornar=$cn->transa($q);
			
			$q='select max(ID) from detalle_guia_venta where usuario_id='.$this->usuario_id;
			$this->ID=$cn->getData($q);
			
			$this->message='Se guardó correctamente';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un error en la consulta");
		}
	}	
		
	function actualizar(){
		$cn =new connect();
		$retornar=-1;
		try{
				
			$q='UPDATE detalle_guia_venta SET descripcion="'.FormatTextSave($this->descripcion).'",cantidad='.$this->cantidad.',precio_venta_unitario="'.number_format($this->precio_venta_unitario,4).'",precio_venta='.number_format($this->precio_venta,4).',';
			$q.='usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->message='Se guardó correctamente';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un error en la consulta");
		}
	}
	
	function eliminar(){
		$cn =new connect();
		$retornar=-1;
		try{
					
			$q='UPDATE detalle_guia_venta SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->message='Se eliminó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un error en la consulta.");
		}
	}

 	static function getByID($ID)
	{
		$cn =new connect();
		try 
		{
                        $q='Select ID,descripcion,fdc,fdm,cantidad,del,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id,precio_venta_unitario,precio_venta,producto_ID,guia_venta_ID,detalle_guia_venta_ID';
			$q.=' from detalle_guia_venta ';
			$q.=' where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oDetalle_guia_venta=null;
			
			foreach($dt as $item)
			{
				$oDetalle_guia_venta=new detalle_guia_venta();
				
				$oDetalle_guia_venta->ID=$item['ID'];
				$oDetalle_guia_venta->cantidad=$item['cantidad'];
				$oDetalle_guia_venta->del=$item['del'];
				$oDetalle_guia_venta->descripcion=$item['descripcion'];
				$oDetalle_guia_venta->detalle_guia_venta_ID=$item['detalle_guia_venta_ID'];
				$oDetalle_guia_venta->fdc=$item['fdc'];
				$oDetalle_guia_venta->fdm=$item['fdm'];
				$oDetalle_guia_venta->guia_venta_ID=$item['guia_venta_ID'];
				$oDetalle_guia_venta->precio_venta=$item['precio_venta'];
				$oDetalle_guia_venta->precio_venta_unitario=$item['precio_venta_unitario'];
				$oDetalle_guia_venta->producto_ID=$item['producto_ID'];
                                $oDetalle_guia_venta->usuario_id=$item['usuario_id'];
				$oDetalle_guia_venta->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oDetalle_guia_venta;
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un error en la consulta.");
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
	
	static function getCount($filtro='')
	{
		$cn =new connect();
		try 
		{
			$q='select count(dgv.ID) ';
			$q.=' FROM detalle_guia_venta as dgv';
			$q.=' where dgv.del=0';
			
			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
			
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception("Ocurrio un error en la consulta");
		}
	} 
	
	static function getGrid($guia)
	{
		$cn =new connect();
		try 
		{
			$q='SELECT dgv.ID,dgv.descripcion,dgv.fdc,dgv.fdm,dgv.cantidad,dgv.del,dgv.usuario_id,ifnull(dgv.usuario_mod_id,-1) as usuario_mod_id,dgv.precio_venta_unitario,dgv.precio_venta,dgv.producto_ID,dgv.guia_venta_ID,dgv.detalle_guia_venta_ID';
			$q.=' FROM detalle_guia_venta as dgv';
			$q.=' where dgv.guia_venta_ID='.$guia;	
			
			$dt=$cn->getGrid($q);									
			return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception('Ocurrio un error en la consulta.');
		}
	}
}

?>