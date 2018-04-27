<?php
class web_menu
{
	private $ID;
	private $nombre;
	private $empresa_ID;
        private $tipo;
        private $descripcion;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('web_menu',$temporal))
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
		if (property_exists('web_menu', $temporal))
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
			$q='select ifnull(max(ID),0)+1 from web_menu;';
			$ID=$cn->getData($q);
			
			$q='INSERT INTO web_menu (ID,nombre,empresa_ID,tipo,descripcion,usuario_id) ';
			$q.='VALUES ('.$ID.',"'.$this->nombre.'",'.$this->empresa_ID.','.$this->tipo.',';
			$q.='"'.$this->descripcion.'",'.$this->usuario_id.');';
			
			$retornar=$cn->transa($q);

			$this->ID=$ID;
			
			$this->getMessage='Se guardó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception($q);
		}
	}	
	
	function actualizar(){
            $cn =new connect();
            $retornar=-1;
            try{

                $q='UPDATE web_menu SET nombre="'.$this->nombre.'", empresa_ID='.$this->empresa_ID.',tipo='.$this->tipo.',descripcion="'.$this->descripcion.'"';
                $q.=',usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
                $q.=' WHERE ID='.$this->ID;

                $retornar=$cn->transa($q);

                $this->getMessage='Se actualizó correctamente.';
                return $retornar;
            }
            catch(Exception $ex){
                    throw new Exception($q);
            }
	}		
	
	function eliminar(){
		$cn =new connect();
		$retornar=-1;
		try{
					
			$q='UPDATE menu SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
                    $q='Select ID,nombre,empresa_ID,tipo,ifnull(descripcion,"") as descripcion ,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' from web_menu ';
                    $q.=' where del=0 and ID='.$ID;
                    //echo $q;
                    $dt=$cn->getGrid($q);			
                    $oWeb_Menu=null;

                    foreach($dt as $item)
                    {
                        $oWeb_Menu=new web_menu();
                        $oWeb_Menu->ID=$item['ID'];
                        $oWeb_Menu->nombre=$item['nombre'];
                        $oWeb_Menu->empresa_ID=$item['empresa_ID'];
                        $oWeb_Menu->tipo=$item['tipo'];
                        $oWeb_Menu->descripcion=$item['descripcion'];
                        $oWeb_Menu->usuario_id=$item['usuario_id'];
                        $oWeb_Menu->usuario_mod_id=$item['usuario_mod_id'];
                    }			
                    return $oWeb_Menu;

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
			$q.=' FROM web_menu';
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
			$q='SELECT ID,nombre,empresa_ID,tipo,ifnull(descripcion,"") as descripcion,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM web_menu';
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