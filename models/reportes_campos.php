<?php
class reportes_campos
{
	private $ID;
        private $reportes_ID;
        
	private $nombre;
        private $orden;
        private $tipo;
        private $descripcion;
        private $valor;
        private $nombre_id;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('reportes',$temporal))
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
		if (property_exists('reportes', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}

 	static function getByID($ID)
	{
		$cn =new connect_new();
		try 
		{
			$q='Select ID,provincia_ID,codigo_ubigeo,nombre,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from distrito ';
			$q.=' where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oDistrito=null;
			
			foreach($dt as $item)
			{
				$oDistrito=new distrito();
				
				$oDistrito->ID=$item['ID'];
				$oDistrito->provincia_ID=$item['provincia_ID'];
				$oDistrito->codigo_ubigeo=$item['codigo_ubigeo'];
				$oDistrito->nombre=$item['nombre'];
				$oDistrito->usuario_id=$item['usuario_id'];
				$oDistrito->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oDistrito;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un error en la consulta.");
		}
	}
	
	static function getCount($filtro='')
	{
		$cn =new connect_new();
		try 
		{
			$q='select count(dt.ID) ';
			$q.=' FROM distrito as dt';
			$q.=' where dt.del=0 ';
			
			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
						
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception("Ocurrio un error en la consulta.");
		}
	} 
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='orden asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='SELECT ID,reportes_ID,nombre,orden,tipo,descripcion,valor,nombre_id, usuario_id, ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM reportes_campos';
			$q.=' where del=0';
			
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
			throw new Exception('Ocurrio un error en la consulta.');
		}
	}
}

?>