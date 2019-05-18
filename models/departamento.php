<?php
class departamento
{
	private $ID;
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
		if (property_exists('departamento',$temporal))
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
		if (property_exists('departamento', $temporal))
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
			$q='Select ID,codigo_ubigeo,nombre,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from departamento ';
			$q.=' where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oDepartamento=null;
			
			foreach($dt as $item)
			{
				$oDepartamento=new departamento();
				
				$oDepartamento->ID=$item['ID'];
				$oDepartamento->codigo_ubigeo=$item['codigo_ubigeo'];
				$oDepartamento->nombre=$item['nombre'];
				$oDepartamento->usuario_id=$item['usuario_id'];
				$oDepartamento->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oDepartamento;
				
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
			$q='select count(d.ID) ';
			$q.=' FROM departamento as d';
			$q.=' where d.del=0 ';
			
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
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='d.ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='SELECT d.ID,d.codigo_ubigeo,d.nombre,d.usuario_id,ifnull(d.usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM departamento as d';
			$q.=' where d.del=0';
			
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
    static function getOpciones($departamento_ID) {
       $cn = new connect_new();
       $opciones="";
       try {
           $dt=$cn->store_procedure_getGrid("sp_departamento_getOpciones",
                   array(
                       "iID"=>$departamento_ID
                    ));
           if(count($dt)>0){
               $opciones=($dt[0]["opciones"]);
           }
           return $opciones;
       } catch (Exception $ex) {
           log_error(__FILE__, "departamento.getOpciones", $ex->getMessage());
           throw new Exception('Ocurrio un error en la consulta');
       }
    }
}

?>