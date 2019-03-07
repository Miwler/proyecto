<?php
class web_banner
{
	private $ID;
	private $nombre;
	private $descripcion;
        private $empresa_ID;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('web_banner',$temporal))
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
		if (property_exists('web_banner', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	function insertar(){
            $cn =new new connect_new();
            $retornar=-1;
            try{
                $q='select ifnull(max(ID),0)+1 from web_banner;';
                $ID=$cn->getData($q);
				$cn =new new connect_new();
                $q='INSERT INTO web_banner (ID,nombre,descripcion,empresa_ID,usuario_id) ';
                $q.='VALUES ('.$ID.',"'.$this->nombre.'","'.$this->descripcion.'",'.$this->empresa_ID.','.$this->usuario_id.');';
                $retornar=$cn->transa($q);
                $this->ID=$ID;
                $this->getMessage='Se guardó correctamente.';
                return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception("Ocurrio un Error en la consulta");
            }
	}	
	
	function actualizar(){
		$cn =new new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE web_banner SET nombre="'.$this->nombre.'",descripcion="'.$this->descripcion.'",empresa_ID='.$this->empresa_ID.',';
			$q.='usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se actualizó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}		
	
	function eliminar(){
		$cn =new new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE web_banner SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se eliminó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	static function getByID($ID)
	{
		$cn =new new connect_new();
		try 
		{
			$q='Select ID,nombre,descripcion,usuario_id,empresa_ID,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from web_banner ';
			$q.=' where del=0 and ID='.$ID;
			//echo $q;
			$dt=$cn->getGrid($q);			
			$oWeb_Banner=null;
			
			foreach($dt as $item)
			{
                            $oWeb_Banner=new web_banner();

                            $oWeb_Banner->ID=$item['ID'];
                            $oWeb_Banner->nombre=$item['nombre'];
                            $oWeb_Banner->descripcion=$item['descripcion'];
                            $oWeb_Banner->empresa_ID=$item['empresa_ID'];
                            $oWeb_Banner->usuario_id=$item['usuario_id'];
                            $oWeb_Banner->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oWeb_Banner;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	
	static function getCount($filtro='')
	{
            $cn =new new connect_new();
            try 
            {
                $q='select count(ID) ';
                $q.=' FROM web_banner';
                $q.=' where del=0 ';

                if ($filtro!='')
                {
                        $q.=' and '.$filtro;
                }

                $resultado=$cn->getData($q);									

                return $resultado;					
            }catch(Exception $ex)
            {
                    throw new Exception("Ocurrio un Error en la consulta");
            }
	} 
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='ID asc')
	{
            $cn =new new connect_new();
            try 
            {
                    $q='select ID,nombre,descripcion,empresa_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' FROM web_banner';
                    $q.=' where del=0 ';

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