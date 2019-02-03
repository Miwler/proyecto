<?php
class distrito
{
	private $ID;
	private $provincia_ID;
	private $codigo_ubigeo;
	private $nombre;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
	private $provincia;
        private $departamento;
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('distrito',$temporal))
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
		if (property_exists('distrito', $temporal))
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
			$q='Select di.ID,di.provincia_ID,concat(de.codigo_ubigeo,pr.codigo_ubigeo,di.codigo_ubigeo) as codigo_ubigeo,di.nombre,di.usuario_id,ifnull(di.usuario_mod_id,-1) as usuario_mod_id,';
			$q.='de.nombre as departamento,pr.nombre as provincia';
                        $q.=' from distrito di,provincia pr,departamento de ';
			$q.=' where di.provincia_ID=pr.ID and pr.departamento_ID=de.ID and di.ID='.$ID;
			//echo $q;
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
                                $oDistrito->departamento=$item['departamento'];
                                $oDistrito->provincia=$item['provincia'];
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
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='dt.ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='SELECT dt.ID,dt.provincia_ID,dt.codigo_ubigeo,dt.nombre,dt.usuario_id,ifnull(dt.usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM distrito as dt';
			$q.=' where dt.del=0';
			
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
    static function getOpciones($ID,$provincia_ID) {
        $cn = new connect_new();
        $opciones="";
        try {
            $dt=$cn->store_procedure_getGrid("sp_distrito_getOpciones",
                    array(
                        "iID"=>$ID,
                        "iprovincia_ID"=>$provincia_ID
                     ));
            if(count($dt)>0){
               $opciones=utf8_encode($dt[0]["opciones"]);
           }
            return $opciones;
        } catch (Exception $ex) {
            log_error(__FILE__, "departamento.getOpciones", $ex->getMessage());
            throw new Exception('Ocurrio un error en la consulta');
        }
    }
    
    static function getUbigeo($ID,$empresa_ID,$cliente_ID) {
        $cn = new connect_new();
        $opciones="";
        try {
            $dt=$cn->store_procedure_getGrid("sp_distrito_getUbigeo",
                    array(
                        "idistrito_ID"=>$ID,
                        "iempresa_ID"=>$empresa_ID,
                        "icliente_ID"=>$cliente_ID
                     ));
           
            return $dt;
        } catch (Exception $ex) {
            log_error(__FILE__, "departamento.getOpciones", $ex->getMessage());
            throw new Exception('Ocurrio un error en la consulta');
        }
    }
}

?>