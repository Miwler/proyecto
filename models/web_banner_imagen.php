<?php
class web_banner_imagen
{
	public $ID;
        private $web_banner_ID;
	public $nombre;
	private $ruta;
        public $titulo;
        public $resumen;
        public $ruta_ver_mas;
        public $orden;
        public $estado_ID;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('web_banner_imagen',$temporal))
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
		if (property_exists('web_banner_imagen', $temporal))
		 {
			return $this->$temporal;
		 }
		 
		// Retorna nulo si no existe
		return null;
	}
	
	function insertar(){
            $cn =new connect_new();
            $retornar=-1;
            try{
                    $q='select ifnull(max(ID),0)+1 from web_banner_imagen;';
                    $ID=$cn->getData($q);

                    $q='INSERT INTO web_banner_imagen (ID,web_banner_ID,nombre,ruta,titulo,resumen,ruta_ver_mas';
                    $q.=',orden,estado_ID,usuario_id) ';
                    $q.='VALUES ('.$ID.','.$this->web_banner_ID.',"'.$this->nombre.'","'.$this->ruta.'",';
                    $q.='"'.$this->titulo.'","'.$this->resumen.'","'.$this->ruta_ver_mas.'",'.$this->orden.','.$this->estado_ID.',';
                    $q.=$this->usuario_id.');';
                    //echo $q;
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
		$cn =new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE web_banner_imagen SET web_banner_ID='.$this->web_banner_ID.',nombre="'.$this->nombre.'",ruta="'.$this->ruta.'",';
			$q.='titulo="'.$this->titulo.'",resumen="'.$this->resumen.'",ruta_ver_mas="'.$this->ruta_ver_mas.'",orden='.$this->orden;
                        $q.=',estado_ID='.$this->estado_ID.',usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			//echo $q;
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se guardó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}		
	
	function eliminar(){
		$cn =new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE web_banner_imagen SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
		$cn =new connect_new();
		try 
		{
			$q='Select ID,web_banner_ID,nombre,ruta,titulo,resumen,ruta_ver_mas,orden,estado_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id ';
			$q.=' from web_banner_imagen ';
			$q.=' where del=0 and ID='.$ID;
			//echo $q;
			$dt=$cn->getGrid($q);			
			$oWeb_Banner_Imagen=null;
			
			foreach($dt as $item)
			{
                            $oWeb_Banner_Imagen=new web_banner_imagen();

                            $oWeb_Banner_Imagen->ID=$item['ID'];
                            $oWeb_Banner_Imagen->web_banner_ID=$item['web_banner_ID'];
                            $oWeb_Banner_Imagen->nombre=$item['nombre'];
                            $oWeb_Banner_Imagen->ruta=$item['ruta'];
                            $oWeb_Banner_Imagen->titulo=$item['titulo'];
                            $oWeb_Banner_Imagen->resumen=$item['resumen'];
                            $oWeb_Banner_Imagen->ruta_ver_mas=$item['ruta_ver_mas'];
                            $oWeb_Banner_Imagen->orden=$item['orden'];
                            $oWeb_Banner_Imagen->estado_ID=$item['estado_ID'];
                            $oWeb_Banner_Imagen->usuario_id=$item['usuario_id'];
                            $oWeb_Banner_Imagen->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oWeb_Banner_Imagen;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	
	static function getCount($filtro='')
	{
		$cn =new connect_new();
		try 
		{
			$q='select count(ID) ';
			$q.=' FROM web_banner_imagen';
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
            $cn =new connect_new();
            try 
            {
                $q='SELECT ID,web_banner_ID,nombre,ruta,titulo,usuario_id,resumen,ruta_ver_mas,orden,estado_ID,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                $q.=' FROM web_banner_imagen';
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