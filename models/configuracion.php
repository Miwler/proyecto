<?php
class configuracion
{
	private $ID;
        private $nombre;
        private $nombre_identificador;
        private $valores;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('configuracion_empresa',$temporal))
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
		if (property_exists('configuracion', $temporal))
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
			$q='Select ID,nombre,valores,usuario_id,ifnull(usuario_mod_id,0) as usuario_mod_id';
			$q.=' from configuracion';
			$q.=' where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oConfiguracion=null;
			
			foreach($dt as $item)
			{
                            $oConfiguracion=new configuracion();					
                            $oConfiguracion->ID=$item['ID'];
                            $oConfiguracion->nombre=$item['nombre'];
                            $oConfiguracion->valores=$item['valores'];
                            $oConfiguracion->usuario_id=$item['usuario_id'];
                            $oConfiguracion->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oConfiguracion;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	
	
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='Select ID,nombre_identificador,nombre,valores,usuario_id,ifnull(usuario_mod_id,0) as usuario_mod_id';
			$q.=' FROM configuracion';
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
			throw new Exception('Ocurrio un Error en la consulta');
		}
	}
}

?>