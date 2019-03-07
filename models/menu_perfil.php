<?php
class menu_perfil
{
	private $ID;
	private $modulo_ID;
	private $nombre;
	private $url;	
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('menu_perfil',$temporal))
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
		if (property_exists('menu_perfil', $temporal))
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
			$q='SET @maxrow:=(select ifnull(max(ID),0) from menu_perfil);';
			$cn->transa($q);
			
			$q='INSERT INTO menu_perfil (ID,menu_ID,perfil_ID,usuario_id) ';
			$q.='VALUES ((select @maxrow:=@maxrow+1),'.$this->menu_ID.','.$this->perfil_ID.','.$this->usuario_id.');';
			
			$retornar=$cn->transa($q);
			
			$q='select max(ID) from menu_perfil where usuario_id='.$this->usuario_id;
			$this->ID=$cn->getData($q);
			
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
					
			$q='UPDATE menu_perfil SET menu_ID='.$this->menu_ID.',perfil_ID='.$this->perfil_ID.',usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
		$cn =new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE menu_perfil SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
			$q='Select ID,menu_ID,perfil_ID,usuario_id,ifnull(usuario_mod_id,0) as usuario_mod_id';
			$q.='from menu_perfil ';
			$q.='where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oMenu_perfil=null;
			
			foreach($dt as $item)
			{
					$oMenu_perfil=new menu();
					
					$oMenu_perfil->ID=$item['ID'];
					$oMenu_perfil->menu_ID=$item['menu_ID'];
					$oMenu_perfil->perfil_ID=$item['perfil_ID'];
					$oMenu_perfil->usuario_id=$item['usuario_id'];
					$oMenu_perfil->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oMenu_perfiloMenu_perfil;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	function verificarDuplicado(){
		$cn =new connect_new();
		$retornar=-1;
		try{
			
			//Verifico que no exista registrado un mismo menú para un mismo perfil
			$q='SELECT count(ID) FROM menu_perfil';
			$q.=' WHERE del=0 and menu_ID='.$this->menu_ID.' and perfil_ID='.$this->perfil_ID;	
			
			if($this->ID!=''){
				$q.=' and ID<>'.$this->ID;
			}
			
			$retornar=$cn->getData($q);			
			
			if ($retornar>0){
				$this->getMessage='Ya existe un menu realicionado con este perfil.';
				return $retornar;
			}		
			
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	static function getCount($filtro='')
	{
		$cn =new connect_new();
		try 
		{
			$q='select count(mn.ID) ';
			$q.=' FROM menu_perfil as mnp,menu as mn,perfil as p';
			$q.=' where mnp.del=0 and m.ID=mnp.menu_ID and p.ID=mnp.perfil_ID';
			
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
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='mnp.ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='SELECT mnp.ID,mnp.menu_ID,mn.nombre as menu,mnp.perfil_ID,p.nombre as perfil,mnp.usuario_id,ifnull(mnp.usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM menu_perfil as mnp,menu as mn,perfil as p';
			$q.=' where mnp.del=0 and mn.ID=mnp.menu_ID and p.ID=mnp.perfil_ID';
			
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