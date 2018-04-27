<?php
class web_banner_ubicacion
{
	private $ID;
        private $web_banner_ID;
	private $titulo_encabezado;
	private $ruta;
        private $tipo;
        private $efecto;
        private $medida_imagen;
        private $orden;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('web_banner_ubicacion',$temporal))
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
		if (property_exists('web_banner_ubicacion', $temporal))
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
			$q='select ifnull(max(ID),0)+1 from web_banner_ubicacion;';
			$ID=$cn->getData($q);
			
			$q='INSERT INTO web_banner_ubicacion (ID,web_banner_ID,ruta,tipo,efecto,medida_imagen,orden,titulo_encabezado,usuario_id) ';
			$q.='VALUES ('.$ID.','.$this->web_banner_ID.',"'.$this->ruta.'","'.$this->tipo.'","'.$this->efecto.'","'.$this->medida_imagen.'",';
			$q.=$this->orden.',"'.$this->titulo_encabezado.'",'.$this->usuario_id.');';
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
		$cn =new connect();
		$retornar=-1;
		try{
					
			$q='UPDATE menu SET modulo_ID='.$this->modulo_ID.',orden='.$this->orden.',nombre="'.FormatTextSave($this->nombre).'",';
			$q.='url="'.FormatTextSave($this->url).'",usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se guardó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}		
	
	function eliminar(){
		$cn =new connect();
		$retornar=-1;
		try{
					
			$q='UPDATE web_banner_ubicacion SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
		$cn =new connect();
		try 
		{
			$q='Select ID,web_banner_ID,ruta,tipo,efecto,medida_imagen,orden,titulo_encabezado,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from web_banner_ubicacion ';
			$q.=' where del=0 and ID='.$ID;
			//echo $q;
			$dt=$cn->getGrid($q);			
			$oWeb_Banner_Ubicacion=null;
			
			foreach($dt as $item)
			{
					$oWeb_Banner_Ubicacion=new web_banner_ubicacion();
					
					$oWeb_Banner_Ubicacion->ID=$item['ID'];
					$oWeb_Banner_Ubicacion->web_banner_ID=$item['web_banner_ID'];
                                        $oWeb_Banner_Ubicacion->ruta=$item['ruta'];
                                        $oWeb_Banner_Ubicacion->tipo=$item['tipo'];
                                        $oWeb_Banner_Ubicacion->efecto=$item['efecto'];
                                        $oWeb_Banner_Ubicacion->medida_imagen=$item['medida_imagen'];
                                        $oWeb_Banner_Ubicacion->orden=$item['orden'];
                                        $oWeb_Banner_Ubicacion->titulo_encabezado=$item['titulo_encabezado'];
					$oWeb_Banner_Ubicacion->usuario_id=$item['usuario_id'];
					$oWeb_Banner_Ubicacion->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oWeb_Banner_Ubicacion;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	
	static function getCount($filtro='')
	{
		$cn =new connect();
		try 
		{
			$q='select count(ID) ';
			$q.=' FROM web_banner_ubicacion';
			$q.=' where del=0';
			
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
		$cn =new connect();
		try 
		{
                    $q='SELECT ID,web_banner_ID,titulo_encabezado,ruta,tipo,usuario_id,efecto,medida_imagen,orden,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' FROM web_banner_ubicacion';
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
			throw new Exception('Ocurrio un Error en la consulta');
		}
	}
	
	
}

?>