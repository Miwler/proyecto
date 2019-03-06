<?php
class perfil
{
	private $ID;
	private $nombre;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $message;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('perfil',$temporal))
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
		if (property_exists('perfil', $temporal))
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
			$q='SET @maxrow:=(select ifnull(max(ID),0) from perfil);';
			//$cn->transa($q);
			
			$q.='INSERT INTO perfil (ID,nombre,usuario_id) ';
			$q.='VALUES ((select @maxrow:=@maxrow+1),"'.FormatTextSave($this->nombre).'",'.$this->usuario_id.');';
			
			$retornar=$cn->transa($q);
			$cn =new connect_new();
			$q='select max(ID) from perfil where usuario_id='.$this->usuario_id;
			$this->ID=$cn->getData($q);
			
			$this->message='Se guardó correctamente.';
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
					
			$q='UPDATE perfil SET nombre="'.FormatTextSave($this->nombre).'",usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->message='Se guardó correctamente.';
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
					
			$q='UPDATE perfil SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->message='Se eliminó correctamente.';
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
			$q='Select ID,nombre,usuario_id,ifnull(usuario_mod_id,0) as usuario_mod_id';
			$q.='from perfil ';
			$q.='where ID='.$ID;
			
			$dt=$cn->getGrid($q);			
			$oPerfil=null;
			
			foreach($dt as $item)
			{
					$oPerfil=new perfil();					
					$oPerfil->ID=$item['ID'];
					$oPerfil->nombre=$item['nombre'];
					$oPerfil->usuario_id=$item['usuario_id'];
					$oPerfil->usuario_mod_id=$item['usuario_mod_id'];
			}			
			return $oPerfil;
				
		}catch(Exeption $ex)
		{
			throw new Exception("Ocurrio un Error en la consulta");
		}
	}
	
	function verificarDuplicado(){
		$cn =new connect_new();
		$retornar=-1;
		try{
			
			//Verifico que no se repita el nombre
			$q='SELECT count(ID) FROM perfil';
			$q.=' WHERE del=0 and Upper(nombre)="'.strtoUpper(FormatTextSave($this->nombre)).'"';		
			
			if($this->ID!=''){
				$q.=' and ID<>'.$this->ID;
			}
			
			$retornar=$cn->getData($q);			
			
			if ($retornar>0){
				$this->message='Ya existe un perfil con el mismo nombre.';
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
			$q='select count(p.ID) ';
			$q.=' FROM perfil as p';
			$q.=' where p.del=0 ';
			
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
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='p.ID asc')
	{
		$cn =new connect_new();
		try 
		{
			$q='SELECT p.ID,p.nombre,p.usuario_id,ifnull(p.usuario_mod_id,-1) as usuario_mod_id';
			$q.=' FROM perfil as p';
			$q.=' where p.del=0';			
			
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