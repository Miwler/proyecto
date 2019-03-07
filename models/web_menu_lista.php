<?php
class web_menu_lista
{
	private $ID;
        private $web_menu_ID;
	private $nombre;
	private $ruta;	
        private $web_menu_lista_ID;
        private $orden;
        private $tabla;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
	private $dtWeb_Menu_Lista_Padre;
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('web_menu_lista',$temporal))
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
		if (property_exists('web_menu_lista', $temporal))
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
			$q='select ifnull(max(ID),0)+1 from web_menu_lista;';
			$ID=$cn->getData($q);
			
			$q='INSERT INTO web_menu_lista (ID,web_menu_ID,nombre,ruta,web_menu_lista_ID,orden,tabla,usuario_id) ';
			$q.='VALUES ('.$ID.','.$this->web_menu_ID.',"'.$this->nombre.'","'.$this->ruta.'",'.$this->web_menu_lista_ID;
                        $q.=','.$this->orden.',"'.$this->tabla.'",'.$this->usuario_id.');';
			
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
		$cn =new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE web_menu_lista SET web_menu_ID='.$this->web_menu_ID.',nombre="'.$this->nombre.'",';
			$q.='ruta="'.$this->ruta.'",web_menu_lista_ID='.$this->web_menu_lista_ID.',orden='.$this->orden;
                        $q.=',tabla="'.$this->tabla.'",usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se guardó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception($q);
		}
	}		
	
	function eliminar(){
		$cn =new connect_new();
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
		$cn =new connect_new();
		try 
		{
                    $q='Select ID,web_menu_ID,nombre,ruta,web_menu_lista_ID,orden,tabla,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
                    $q.=' from web_menu_lista';
                    $q.=' where del=0 and ID='.$ID;

                    $dt=$cn->getGrid($q);			
                    $oWeb_Menu_Lista=null;

                    foreach($dt as $item)
                    {
                        $oWeb_Menu_Lista=new web_menu_lista();
                        $oWeb_Menu_Lista->ID=$item['ID'];
                        $oWeb_Menu_Lista->web_menu_ID=$item['web_menu_ID'];
                        $oWeb_Menu_Lista->nombre=$item['nombre'];
                        $oWeb_Menu_Lista->ruta=$item['ruta'];
                        $oWeb_Menu_Lista->web_menu_lista_ID=$item['web_menu_lista_ID'];
                        $oWeb_Menu_Lista->orden=$item['orden'];
                        $oWeb_Menu_Lista->tabla=$item['tabla'];
                        $oWeb_Menu_Lista->usuario_id=$item['usuario_id'];
                        $oWeb_Menu_Lista->usuario_mod_id=$item['usuario_mod_id'];
                    }			
                    return $oWeb_Menu_Lista;
				
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
			$q='select count(mn.ID) ';
			$q.=' FROM menu as mn,modulo as m';
			$q.=' where mn.del=0  and m.ID=mn.modulo_ID';
			
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
			$q='SELECT ID,web_menu_ID,nombre,ruta,web_menu_lista_ID,orden,tabla,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM web_menu_lista ';
			$q.=' where del=0 ';
			
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
	
	static function getMenuxUsuarioID($usuario_id)
	{		
		$cn =new connect_new();
		try 
		{
			$q='select mn.ID,mn.menu_ID,mn.modulo_ID,mn.orden,mn.nombre,mn.url,mn.usuario_id,ifnull(mn.usuario_mod_id,-1) as usuario_mod_id';
			$q.=' from menu as mn,  menu_usuario mu';
			$q.=' where mn.ID=mu.menu_ID and mn.del=0 and mu.del=0 and mu.usuario_ID='.$usuario_id;			
			$q.=' Order By mn.orden';			
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