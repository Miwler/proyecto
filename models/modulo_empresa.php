<?php
class modulo_empresa
{
	private $ID;
	private $empresa_ID;
	private $modulo_ID;
	private $usuario_id;	
	private $usuario_mod_id;	
	private $getMessage;
		
	public function __set($var, $valor)
	{
		// convierte a minúsculas toda una cadena la función strtolower
		$temporal = $var;
		
		// Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
		if (property_exists('modulo_empresa',$temporal))
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
		if (property_exists('modulo_empresa', $temporal))
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
			$q='select ifnull(max(ID),0)+1 from modulo_empresa;';
			$ID=$cn->getData($q);
			
			$q='INSERT INTO modulo_empresa(ID,empresa_ID,modulo_ID,usuario_id) ';
			$q.='VALUES ('.$ID.','.$this->empresa_ID.','.$this->modulo_ID.',';
			$q.=$this->usuario_id.');';
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
					
			$q='UPDATE modulo_empresa SET del=1,usuario_mod_id='.$this->usuario_mod_id.', fdm=Now()';
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
                $q='Select ID,empresa_ID,modulo_ID,usuario_id,ifnull(usuario_mod_id,-1) as usuario_mod_id ';
                $q.='from modulo_empresa ';
                $q.='where del=0 and ID='.$ID;

                $dt=$cn->getGrid($q);			
                $oModulo_Empresa=null;

                foreach($dt as $item)
                {
                    $oModulo_Empresa=new modulo_empresa();					
                    $oModulo_Empresa->ID=$item['ID'];
                    $oModulo_Empresa->empresa_ID=$item['empresa_ID'];
                    $oModulo_Empresa->modulo_ID=$item['modulo_ID'];
                    $oModulo_Empresa->usuario_id=$item['usuario_id'];
                    $oModulo_Empresa->usuario_mod_id=$item['usuario_mod_id'];
                }			
                return $oModulo_Empresa;

            }catch(Exeption $ex)
            {
                    throw new Exception("Ocurrio un erroren la consulta");
            }
	}
	
	
	
	static function getCount($filtro='')
	{
		$cn =new connect_new();
		try 
		{
			$q='select count(moe.ID) ';
			$q.=' FROM modulo_empresa moe, empresa em, modulo mo';
			$q.=' WHERE moe.empresa_ID=em.ID and moe.modulo_ID=mo.ID and moe.del=0';
			
			if ($filtro!='')
			{
				$q.=' and '.$filtro;
			}
			//echo $q;			
			$resultado=$cn->getData($q);									
		
			return $resultado;					
		}catch(Exception $ex)
		{
			throw new Exception("Ocurrio un error en la consulta");
		}
	} 
	
	static function getGrid($filtro='',$desde=-1,$hasta=-1,$order='moe.ID asc')
	{
            $cn =new connect_new();
            try 
            {
                $q='SELECT moe.ID,moe.empresa_ID,moe.modulo_ID,moe.usuario_id,ifnull(moe.usuario_mod_id,-1) as usuario_mod_id,';
                $q.='mo.nombre,mo.imagen,mo.url,ifnull(mo.color,"#354B8A") as color,mo.nombre_corto';
                $q.=' FROM modulo_empresa moe, empresa em, modulo mo';
                $q.=' WHERE moe.empresa_ID=em.ID and moe.modulo_ID=mo.ID and moe.del=0 ';

                if($filtro!=''){
                        $q.=' and '.$filtro;
                }

                $q.=' Order By '.$order;

                if($desde!=-1&&$hasta!=-1){
                        $q.=' Limit '.$desde.','.$hasta;
                }			

                $dt=$cn->getGrid($q);	
                //echo $q;
                return $dt;												
            }catch(Exception $ex)
            {
                    throw new Exception($q);
            }
	}
	
	static function getGridModulosUsuario($filtro='',$desde=-1,$hasta=-1,$order='mo.ID asc')
	{		
		$cn =new connect_new();
		try 
		{
			$q='select moe.modulo_ID, mo.nombre,mo.nombre_corto,ifnull(mo.color,"#354B8A") as color,mo.imagen,mo.url';
			$q.=' from menu_usuario mu,menu me,modulo_empresa moe,modulo mo,empresa em';
			$q.=' where mu.menu_ID=me.ID and me.modulo_ID=moe.modulo_ID and moe.modulo_ID=mo.ID and moe.empresa_ID=em.ID ';
                        $q.=' and me.del=0 and mu.del=0 and moe.del=0 and em.del=0';
                       
			if($filtro!=''){
                            $q.=' and '.$filtro;
                        }
                        $q.=' group by mo.ID, mo.nombre ';
                        $q.=' Order By '.$order;

                        if($desde!=-1&&$hasta!=-1){
                                $q.=' Limit '.$desde.','.$hasta;
                        }	
                        
			$dt=$cn->getGrid($q);									
			return $dt;												
		}catch(Exception $ex)
		{
			throw new Exception('Ocurrio un erroren la consulta');
		}
	}
       
}

?>