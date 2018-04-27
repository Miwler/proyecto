<?php

class estado {

   private $ID;
	private $orden;
	private $nombre;
	private $tabla;
	private $usuario_id;	
		
	private $message;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('estado',$temporal))
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
		if (property_exists('estado', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
 	static function getByID($ID)
	{
		$cn =new connect();
		try 
		{
			$q='Select ID,orden,nombre,tabla,usuario_id';
			$q.=' from estado ';
			$q.=' where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oEstado=null;
			
			foreach($dt as $item)
			{
				$oEstado=new estado();
				
				$oEstado->ID=$item['ID'];
				$oEstado->orden=$item['orden'];
				$oEstado->nombre=FormatTextView($item['nombre']);
				$oEstado->tabla=FormatTextView($item['tabla']);
				$oEstado->usuario_id=$item['usuario_id'];
				
			}			
			return $oEstado;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un error en la consulta.");
		}
	}
	
	static function getCount($filtro='')
	{
		$cn =new connect();
		try 
		{
			$q='select count(est.ID) ';
			$q.=' FROM estado as est';
			$q.=' where est.del=0 ';
			
			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
						
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception($q);
		}
	} 
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='est.ID asc,est.orden asc')
	{
		$cn =new connect();
		try 
		{
			$q='SELECT est.ID,est.orden,upper(est.nombre)as nombre,est.tabla,est.usuario_id';
			$q.=' FROM estado as est';
			$q.=' where est.del=0 ';
			
			if($filtro!=''){
				$q.=' and '.$filtro;
			}
			
			$q.=' Order By '.$order;
			
			if($desde!=-1&&$hasta!=-1){
				$q.=' Limit '.$desde.','.$hasta;
			}			
			
			$dt=$cn->getGrid($q);									
			return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception('Ocurrio un error en la consulta');
		}
	}
}
