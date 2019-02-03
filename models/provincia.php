<?php
class provincia
{
	private $ID;
	private $departamento_ID;
	private $codigo_ubigeo;
	private $nombre;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('provincia',$temporal))
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
		if (property_exists('provincia', $temporal))
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
			$q='Select ID,departamento_ID,codigo_ubigeo,nombre,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from provincia ';
			$q.=' where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oProvincia=null;
			
			foreach($dt as $item)
			{
				$oProvincia=new provincia();
				
				$oProvincia->ID=$item['ID'];
				$oProvincia->departamento_ID=$item['departamento_ID'];
				$oProvincia->codigo_ubigeo=$item['codigo_ubigeo'];
				$oProvincia->nombre=$item['nombre'];
				$oProvincia->usuario_id=$item['usuario_id'];
				$oProvincia->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oProvincia;
				
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
			$q='select count(pv.ID) ';
			$q.=' FROM provincia as pv';
			$q.=' where pv.del=0 ';
			
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
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='pv.ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='SELECT pv.ID,pv.departamento_ID,pv.codigo_ubigeo,pv.nombre,pv.usuario_id,ifnull(pv.usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM provincia as pv';
			$q.=' where pv.del=0';
			
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
    static function getOpciones($ID,$departamento_ID) {
       $cn = new connect_new();
       $opciones="";
       try {
           $dt=$cn->store_procedure_getGrid("sp_provincia_getOpciones",
                   array(
                       "iID"=>$ID,
                       "idepartamento_ID"=>$departamento_ID
                    ));
           if(count($dt)>0){
               $opciones= utf8_encode($dt[0]["opciones"]);
           }
           return $opciones;
       } catch (Exception $ex) {
           log_error(__FILE__, "departamento.getOpciones", $ex->getMessage());
           throw new Exception('Ocurrio un error en la consulta');
       }
    }
}

?>