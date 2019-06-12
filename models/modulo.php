<?php
class modulo
{
	private $ID;
	private $orden;
	private $nombre;
        private $nombre_corto;
	private $url;
        private $imagen;
        private $color;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('modulo',$temporal))
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
		if (property_exists('modulo', $temporal))
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
			$q='SET @maxrow:=(select ifnull(max(ID),0) from modulo);';
			$cn->transa($q);
			
			$q='INSERT INTO modulo (ID,orden,nombre,url,usuario_id) ';
			$q.='VALUES ((select @maxrow:=@maxrow+1),'.$this->orden.',"'.FormatTextSave($this->nombre).'",';
			$q.='"'.FormatTextSave($this->url).'",'.$this->usuario_id.');';
			
			$retornar=$cn->transa($q);
			
			$q='select max(ID) from modulo where usuario_id='.$this->usuario_id;
			$this->ID=$cn->getData($q);
			
			$this->getMessage='Se guardó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un erroren la consulta");
		}
	}	
	
	function actualizar(){
		$cn =new connect_new();
		$retornar=-1;
		try{					
			$q='UPDATE modulo SET orden='.$this->orden.',nombre="'.FormatTextSave($this->nombre).'",url="'.FormatTextSave($this->url).'",';
			$q.=' usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se guardó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un erroren la consulta");
		}
	}		
	
	function eliminar(){
		$cn =new connect_new();
		$retornar=-1;
		try{
					
			$q='UPDATE modulo SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
			$q.=' WHERE ID='.$this->ID;
			
			$retornar=$cn->transa($q);
			
			$this->getMessage='Se eliminó correctamente.';
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un erroren la consulta");
		}
	}

 	static function getByID($ID)
	{
            $cn =new connect_new();
            try 
            {
                $q='Select ID,nombre,nombre_corto,orden,imagen,url,ifnull(color,"#395479") as color,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id ';
                $q.='from modulo ';
                $q.='where ID='.$ID;

                $dt=$cn->getGrid($q);			
                $oModulo=null;

                foreach($dt as $item)
                {
                    $oModulo=new modulo();					
                    $oModulo->ID=$item['ID'];
                    $oModulo->nombre=$item['nombre'];
                    $oModulo->nombre_corto=$item['nombre_corto'];
                    $oModulo->orden=$item['orden'];
                    $oModulo->imagen=$item['imagen'];
                    $oModulo->color=$item['color'];
                    $oModulo->url=$item['url'];
                    $oModulo->usuario_id=$item['usuario_id'];
                    $oModulo->usuario_mod_id=$item['usuario_mod_id'];
                }			
                return $oModulo;

            }catch(Exeption $ex)
            {
                throw new Exception("Ocurrio un erroren la consulta");
            }
	}
	
	function verificarDuplicado(){
		$cn =new connect_new();
		$retornar=-1;
		try{			
			//Verifico que no se repita el nombre
			$q='SELECT count(ID) FROM modulo';
			$q.=' WHERE del=0 and Upper(nombre)="'.strtoUpper(FormatTextSave($this->nombre)).'"';		
			
			if($this->ID!=''){
				$q.=' and ID<>'.$this->ID;
			}
			
			$retornar=$cn->getData($q);			
			
			if ($retornar>0){
				$this->getMessage='Ya existe un módulo con el mismo nombre.';
				return $retornar;
			}
			return $retornar;
		}
		catch(Exception $ex){
			throw new Exception("Ocurrio un erroren la consulta");
		}
	}
	
	static function getCount($filtro='')
	{
		$cn =new connect_new();
		try 
		{
			$q='select count(m.ID) ';
			$q.=' FROM modulo as m';
			$q.=' where m.del=0';
			
			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
						
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception("Ocurrio un erroren la consulta");
		}
	} 
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='m.ID asc')
	{
            $cn =new connect_new();
            try 
            {
                $q='SELECT m.ID,m.orden,m.nombre,m.nombre_corto,m.url,m.imagen,ifnull(m.color,"#395479") as color,m.usuario_id,ifnull(m.usuario_mod_id,-1) as usuario_mod_id';
                $q.=' FROM modulo as m';
                $q.=' where m.del=0 ';

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
                    throw new Exception('Ocurrio un erroren la consulta');
            }
	}
	
	static function getModulosxUsuarioID($usuario_id)
	{		
		$cn =new connect_new();
		try 
		{
			$q='select distinct(m.ID),m.orden,m.nombre,m.nombre_corto,m.imagen,m.usuario_id,ifnull(m.usuario_mod_id ,-1) as usuario_mod_id ';
			$q.=' from modulo as m, menu me,menu_usuario mu,modulo_empresa moe';
			$q.=' where m.ID=me.modulo_ID and me.ID=mu.menu_ID and moe.modulo_ID=m.ID and m.del=0 and me.del=0 and mu.del=0 and moe.del=0 and moe.empresa_ID='.$_GET['empresa_ID'].' and mu.usuario_ID='.$usuario_id;
                        $q.=' Order By m.orden';			
			//echo $q;
			$dt=$cn->getGrid($q);									
			return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception('Ocurrio un erroren la consulta');
		}
	}
        static function getModulosLibres($empresa_ID)
	{		
		$cn =new connect_new();
		try 
		{
			$q='select mo.* from modulo mo';
			$q.=' where mo.del=0 and mo.asignar=1 and mo.ID not in(select modulo_ID from modulo_empresa where del=0 and empresa_ID='.$empresa_ID.')';
						
			//echo $q;
			$dt=$cn->getGrid($q);									
			return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception($q);
		}
	}
}

?>